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

        //Retorna dados do token solicitado
        $token = $request->cookie(env('COOKIE_NAME'));

        //Query inicial
        $query = DB::table('requests AS req')
                    ->join('unity as u', 'req.unity_id', '=', 'u.ID')
                    ->select("req.ID", "req.unity_id", "u.address", "u.cep", "u.city", "u.name", "u.neighborhood", "u.number", "u.state", DB::raw("(select group_concat(R.ID, '-', R.name separator ',' ) from resources R where R.request_id = req.ID group by R.request_id order by count(R.request_id)) as items"))
                    ->orderByDesc('req.ID')
                    ->offset(($paged > 1)? $paged * 20 : 0)
                    ->take(20);

        //Se houve envio de solicitação de filtrar solicitações
        if(!is_null($bairro))
        {
            //Todo: Não filtrando corretamente por bairro
            $query->where("u.neighborhood", "=", $bairro);
        }
        
        //Realiza a query
        $solicitacoes = $query->get();

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
            }
        } 

        return response()->json($solicitacoes);
    }

    function post(Request $request) {
        
        //Dados não preenchidos
        if (!$request->has('solicitacao') || !$request->filled('solicitacao') ) return false;

        //Retorna dados do token solicitado
        $token = $request->cookie(env('COOKIE_NAME'));

        //Se não existir token registrado para a sessão
        if (is_null($token)) return ['error' => ['request' => 'Para abrir uma solicitação é necessário uma sessão ativa. Registre uma nova sessão com "Registrar nova sessão"!']];

        //Verificar se token existe e já foi usado em solicitação anterior
        if ($token && $exist = RequestModel::where("token", "=", $token)->get()) return ['error' => ['request' => 'Só é permitido a utilização de um token por solicitação. Se necessário gere uma nova sessão!']];

        $data = $request->input('solicitacao');

        //Dados não preenchidos, adicionar nova instituição
        if (!key_exists('unidade', $data) || empty($data['unidade'])) {
            $data['unidade'] = UnityModel::insertGetId([
                'name'          => (string) $data['name'], 
                'address'       => (string) $data['address'],
                'number'        => (int) $data['number'],
                'neighborhood'  => (string) $data['neighborhood'],
                'city'          => (string) $data['city'],
                'state'         => (string) $data['state'],
                'cep'           => (int) $data['cep']
            ]); 
        }

        //Inserindo dados no banco
        $request_insert_id = RequestModel::insertGetId([
            'unity_id'  => (int) $data['unidade'], 
            'token'     => (string) $token
        ]); 

        //Se inserção foi feita corretamente
        if (is_int($request_insert_id) && $request_insert_id > 0) {
            //Adicionando items
            foreach ($data['items'] as $key => $value) {
                //Inserindo dados no banco
                $resource_insert_id = ResourcesModel::insertGetId([
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
