<?php

namespace App\Http\Controllers;

use App\Business    as BusinessModel;
use App\Resources   as ResourcesModel;
use App\Support     as SupportModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResourcesController extends Controller
{
    function post(Request $request) {
        
        //Dados não preenchidos
        if (!$request->has('ajuda') || !$request->filled('ajuda') ) return false;

        $data = $request->input('ajuda');

        //Criando empresa no banco
        $business_model = BusinessModel::create([
            'name'  => filter_var($data['empresa'], FILTER_SANITIZE_STRING), 
            'logo'  => filter_var($data['logo'], FILTER_SANITIZE_URL), 
            'site'  => filter_var($data['url'], FILTER_SANITIZE_URL), 
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL)
        ]); 

        //Atribuindo Id da inserção
        $business_id = $business_model->getAttribute('ID');

        //Verifica se houve erro na inserção
        if (!is_int($business_id) || $business_id <= 0) 
            return ['error' => ['resource' => 'Erro ao inserir ajuda.']];

        //Atribuindo empresa como provedora de determinado recurso
        $support_model = SupportModel::create([
            'business_id'   => (int) $business_id,
            'resource_id'   => filter_var($data['recurso_id'], FILTER_SANITIZE_NUMBER_INT)
        ]);

        //Atribuindo id de inserção
        $support_id = $support_model->getAttribute('ID');
            
        //Verifica se houve erro na inserção
        if (!is_int($support_id) || $support_id <= 0) 
            return ['error' => ['resource' => 'Erro ao atualizar ajuda.']];

        return response()->json(['success' => ['resource' => 'Ajuda enviada com sucesso.']]);

    }

}
