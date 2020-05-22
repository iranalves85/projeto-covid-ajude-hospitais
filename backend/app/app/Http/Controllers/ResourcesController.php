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
        $business_id = BusinessModel::insertGetId([
            'name'  => filter_var($data['empresa'], FILTER_SANITIZE_STRING), 
            'logo'  => filter_var($data['logo'], FILTER_SANITIZE_URL), 
            'site'  => filter_var($data['url'], FILTER_SANITIZE_URL), 
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL)
        ]); 

        //Verifica se houve erro na inserção
        if (!is_int($business_id) || $business_id <= 0) 
            return ['error' => ['resource' => 'Erro ao inserir ajuda.']];

        //Atribuindo empresa como provedora de determinado recurso
        $support_id = SupportModel::insertGetId([
            'business_id'   => (int) $business_id,
            'resource_id'   => filter_var($data['recurso_id'], FILTER_SANITIZE_NUMBER_INT)
        ]);
            
        //Verifica se houve erro na inserção
        if (!is_int($support_id) || $support_id <= 0) 
            return ['error' => ['resource' => 'Erro ao atualizar ajuda.']];

        return response()->json(['success' => ['resource' => 'Ajuda enviada com sucesso.']]);

    }

}
