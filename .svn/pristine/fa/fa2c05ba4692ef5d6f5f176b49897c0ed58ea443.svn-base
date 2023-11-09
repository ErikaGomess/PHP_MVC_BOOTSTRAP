<?php

namespace App\Controller\Api;

class Api{
    
    /**
     * Métdo responsável por retornar o conteúdo (view) da nossa página de Sobre WDEV
     * @param Request $request
     * @return array
     */
    public static function getDetails($request){
        return[
            'nome' => 'API - WDEV',
            'versao' => 'v1.0.0',
            'autor' => 'William Costa',
            'email' => 'canalwdev@gamil.com'
        ];
    }
   
    /**
     * Método responsável por retornar od detalhes da paginação
     * @param Request $request
     * @param Pagination $obPagination
     */
    protected static function getPagination($request, $obPagination){
       //QUERY PARAMS
       $queryParams = $request->getQueryParams();
       
       //PAGINA
       $pages = $obPagination->getPages();
       
       //RETORNO
       return[
           'paginaAtual' => isset($queryParams['page']) ? (int)$queryParams['page']: 1,
           'quantidadePaginas' => !empty($pages) ? count($pages) : 1
       ];
    }
}