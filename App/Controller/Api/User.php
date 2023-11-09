<?php

namespace App\Controller\Api;

use \App\Model\Entity\User as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Api{
    
    /**
     * Método responsável por obter a renderização dos itens de depoimentos para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getUserItems($request,&$obPagination){
        //DEPOIMENTOS
        $itens = [];
        
        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadetotal = EntityUser::getUsers(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
        
        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal,$paginaAtual,5);
        
        //RESULTADOS DA PÁGINA
        $results = EntityUser::getUsers(null,'id ASC', $obPagination->getLimit());
        
        //RENDERIZA O ITEM
        while($obUser = $results->fetchObject(EntityUser::class)){
            $itens[] = [
                'id'        => (int)$obUser->id,
                'name'      => $obUser->nome,
                'email'     => $obUser->email,
            ];
        }
               
        //RETORNA OS DEPOIMENTOS
        return $itens;
    }
    
    /**
     * Métdo responsável por retornar o conteúdo (view) da nossa página de Sobre WDEV
     * @param Request $request
     * @return array
     */
    public static function getUsers($request){
        return[
            'usuarios' => self::getUserItems($request, $obPagination),
            'paginacao'  => parent::getPagination($request, $obPagination)
        ];
    }
    
    public static function getCurrentUser($request) {
        //USUÁRIO ATUAL
        $obUser = $request->user;
        
        return[
            'id'    => (int)$obUser->id,
            'nome'  => $obUser-> nome,
            'email' => $obUser->email
        ];
    }
    
    /**
     * Método responsável por retornar os detalhes de um usuário
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getUser($request,$id){
        //VALIDA O ID DO USUÁRIO
        if(!is_numeric($id)){
            throw new \Exception("O id'".$id."' não é válido.",400);
        }
        //BUSCA USUÁRIO
        $obUser = EntityUser::getUserById($id);
        
        //VALIDA SE O USUÁRIO EXISTE
        if(!$obUser instanceof EntityUser){
            throw new \Exception("O usuário ".$id." não foi encontrado", 404);
        }
        
        //RETORNA OS DETALHES DO DEPOIMENTO
        return[
                'id'        => (int)$obUser->id,
                'name'      => $obUser->nome,
                'email'     => $obUser->email,
        ];
    }
    
    /**
     * Método responsável por cadastrar um novo depoimento
     * @param Request $request
     */
    public static function setNewUser($request){
        //POST VARS
        $postVars = $request->getPostVars();
        
        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if(!isset($postVars['nome']) or !isset($postVars['email']) or !isset($postVars['senha'])){
            throw new \Exception("Os campos 'nome', 'email' e 'senha' são obrigátorios",400); 
        }
        
        //VALIDA A DUPLICAÇÃO DE USUÁRIOS
        $obUserEmail = EntityUser::getUserByEmail($postVars['email']);
        if($obUserEmail instanceof EntityUser){
            throw new \Exception("O e-mail'".$postVars['email']."' já está em uso.",400);
        }
        
        
        //NOVO USUARIO
        $obUser = new EntityUser;
        $obUser->nome = $postVars['nome'];
        $obUser->email = $postVars['email'];
        $obUser->senha = password_hash($postVars['senha'],PASSWORD_DEFAULT);
        $obUser->cadastrar();
        
        //RETORNA OS DETALHES DO USUÁRIO CADASTRADO
        return[
                'id'        => (int)$obUser->id,
                'name'      => $obUser->nome,
                'email'     => $obUser->email,
        ];
    }
    /**
     * Método responsável por atualizar um depoimento
     * @param Request $request
     */
    public static function setEditUser($request,$id){
       //POST VARS
        $postVars = $request->getPostVars();
        
        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if(!isset($postVars['nome']) or !isset($postVars['email']) or !isset($postVars['senha'])){
            throw new \Exception("Os campos 'nome', 'email' e 'senha' são obrigátorios",400); 
        }
        
        //BUSCA USUÁRIO
        $obUser = EntityUser::getUserById($id);
        
        //VALIDA SE O USUÁRIO EXISTE
        if(!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário ".$id." não foi encontrado",404);
        }
        
        //VALIDA A DUPLICAÇÃO DE USUÁRIOS
        $obUserEmail = EntityUser::getUserByEmail($postVars['email']);
        if($obUserEmail instanceof EntityUser && $obUserEmail->id != $obUser->id){
            throw new \Exception("O e-mail'".$postVars['email']."' já está em uso.",400);
        }
        
        //ATUALIZA O USUARIO
        $obUser->nome = $postVars['nome'];
        $obUser->email = $postVars['email'];
        $obUser->senha = password_hash($postVars['senha'],PASSWORD_DEFAULT);
        $obUser->atualizar();
        
        //RETORNA OS DETALHES DO USUÁRIO ATUALIZADO
        return[
                'id'        => (int)$obUser->id,
                'name'      => $obUser->nome,
                'email'     => $obUser->email,
        ];
    }
    
    /**
     * Método responsável por excluir um usuário
     * @param Request $request
     */
    public static function setDeleteUser($request,$id){
        
        //BUSCA USUÁRIO
        $obUser = EntityUser::getUserById($id);
        
        //VALIDA SE O USUÁRIO EXISTE
        if(!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário ".$id." não foi encontrado",404);
        }
        
        //IMPEDE A EXCLUSÃO DO PRÓPRIO CADASTRO
        if($obUser->id == $request->user->id){
            throw new \Exception("Não é possivel excluir o cadastro atualmente conectado",400);
        }
             
        //EXCLUI O USUÁRIO
        $obUser->excluir();
        
        //RETORNA OS SUCESSO DA EXCLUSÃO
        return[
            'sucesso' => true
        ];
    }
}