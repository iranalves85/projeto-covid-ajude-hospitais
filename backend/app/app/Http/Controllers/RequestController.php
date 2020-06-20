<?php

namespace App\Http\Controllers;

use App\Request as RequestModel;
use App\Unity as UnityModel;
use App\Resources as ResourcesModel;
use App\Business as BusinessModel;
use App\Support as SupportModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    function get(Request $request, $paged = 0, $bairro = null) {

        //Query inicial
        $query = DB::table('requests AS req')
                    ->join('unity as u', 'req.unity_id', '=', 'u.ID')
                    ->select("req.ID", "req.updated_at", "req.unity_id", "u.address", "u.cep", "u.city", "u.name", "u.neighborhood", "u.number", "u.state", DB::raw("(select group_concat(R.ID, '-', R.name separator ',' ) from resources R where R.request_id = req.ID group by R.request_id order by count(R.request_id)) as items"))
                    ->orderByDesc('req.updated_at')
                    ->offset(($paged > 1)? ($paged - 1) * 10 : 0)
                    ->take(10);

        //Se houve envio de solicitação de filtrar solicitações
        if (!is_null($bairro))
        {
            $query->where("u.neighborhood", "=", $bairro);
        }
        
        //Realiza a query
        $solicitacoes = $query->get();

        //Retorna dados do token solicitado
        if ($token = $request->cookie(env('COOKIE_NAME'))) {
            $request_token = RequestModel::where("token", "=", $token)->first();
        }

        //Se existir dados a interar
        if ($solicitacoes->count() > 0) {

            //Se token presente, retornar items
            if ($token) {
                //Query que verifica requisições e token de sessão
                $resources = ResourcesModel::
                join("requests as req", "resources.request_id", "=", "req.ID")
                ->select("resources.ID")
                ->where([ 
                    ["req.token", "=", $token], 
                ])->get()->toArray();
            }            

            foreach ($solicitacoes->all() as $key => $value) {
                
                if (property_exists($value, 'items') && !empty($value->items)) {
                    
                    //Transforma itens em array
                    $items = explode(',', $value->items);

                    //Percorre array de items
                    foreach ($items as $k => $v) {

                        //$res[0] = ID
                        //$res[1] = NOME
                        //$res[2] = BUSINESS ID
                        //$res[3] = EMPRESA
                        $res = explode('-', $v);

                        //Se existe token registrado na sessão
                        if ($token && isset($resources) && $supportFound = $this->searchForValue((int) $res[0], $resources)) {

                            foreach ($supportFound as $index => $current) {
                                
                                //Retorna dados da empresa atribuido ao recurso
                                $businessArray = BusinessModel::where("ID", "=", $current->business_id)->get()->toArray();

                                //Atribui empresa ao array principal
                                if (count($businessArray) > 0) {
                                    //Adicionando a variavel
                                    $empresa = $businessArray[key($businessArray)];
                                    $res[2][] = [
                                        'name'  => $empresa['name'],
                                        'site'  => $empresa['site'],
                                        'email' => $empresa['email']
                                    ];
                                }
                            }
                            
                        }

                        $items[$k] = $res; //Atribuindo ao array
                        
                    }

                    //Adicionando ao array geral
                    $solicitacoes[$key]->items = [];
                    $solicitacoes[$key]->items[] = $items; 

                }

                //Adicionando atributo que permite edição da solicitação
                if (isset($request_token) && $request_token->getAttribute('ID') == $value->ID) {
                    $solicitacoes[$key]->can_edit = true;
                }
            }
        } 

        return response()->json($solicitacoes);
    }

    function post(Request $request) {
        
        //Dados não preenchidos
        if (!$request->has('solicitacao') || !$request->filled('solicitacao') ) return false;

        //Carrega parametros enviados
        $data = $request->input('solicitacao'); 

        //Retorna dados do token solicitado
        $token = $request->cookie(env('COOKIE_NAME'));

        //Se não existir token registrado para a sessão
        if (is_null($token)) return ['error' => ['request' => 'Para abrir uma solicitação é necessário uma sessão ativa. Registre uma nova sessão com "Registrar nova sessão"!']];

        //Pesquisa no banco se já existe token usado em solicitação
        $exist = RequestModel::where("token", "=", $token)->first();
        
        //Se nulo, continua processo
        if (!is_null($exist)) return ['error' => ['request' => 'Só é permitido a utilização de um token por solicitação. Se necessário gere uma nova sessão!']];

        //Dados não preenchidos, adicionar nova instituição
        if (!key_exists('unidade', $data) || empty($data['unidade'])) {
            $unity_model = UnityModel::create([
                'name'          => (string) $data['name'], 
                'address'       => (string) $data['address'],
                'number'        => (int) $data['number'],
                'neighborhood'  => (string) $data['neighborhood'],
                'city'          => (string) $data['city'],
                'state'         => (string) $data['state'],
                'cep'           => (int) $data['cep']
            ]); 

            $data['unidade'] = $unity_model->getAttribute('ID');
        }

        //Insere modelo no banco registrando timestamps
        $request_model = RequestModel::create([
            'unity_id'  => (int) $data['unidade'], 
            'token'     => (string) $token
        ]);

        //Se inserção foi feita corretamente
        if (($request_insert_id = $request_model->getAttribute('ID')) > 0) {

            //Adicionando items
            foreach ($data['items'] as $key => $value) {
                //Inserindo dados no banco
                $resource_model = ResourcesModel::create([
                    'name'          => filter_var($value, FILTER_SANITIZE_STRING), 
                    'request_id'    => (int) $request_insert_id
                ]);
            }

            //Retorna mensagem de sucesso
            return response()->json(['success' => ['request' => 'Solicitação aberta com sucesso.']]);

        } else {
            //Retorna mensagem de erro
            return response()->json(['error' => ['request' => 'Não foi possível registrar sua solicitação.']]);
        }

    }

    function delete(Request $request, $requestID) {

        //Retorna dados do token solicitado
        $token = $request->cookie(env('COOKIE_NAME'));

        //Se não existir token registrado para a sessão
        if (is_null($token)) return ['error' => ['request' => 'Para deletar a solicitação é necessário uma sessão ativa.']];

        //Retorna a requisição pelo ID
        $request_model = RequestModel::where("ID", "=", $requestID)->first();
        
        //Se nulo, continua processo
        return ($request_model->delete())? ['success' => ['request' => 'Solicitação excluída!']] : ['error' => ['request' => 'Erro ao excluir solicitação!']];

    }

    private function searchForValue(int $valueToFind, $array) {
        
        $exist = false;
        
        foreach ($array as $key => $value) {
            //Se encontrado atribuir como true
            if (key_exists('ID', $value) && $valueToFind == (int) $value['ID']) {
                //Retorna todos os items de apoios
                $exist = SupportModel::where("resource_id", "=", $valueToFind)->get();
                break;
            }
        }

        return $exist;
    }

}
