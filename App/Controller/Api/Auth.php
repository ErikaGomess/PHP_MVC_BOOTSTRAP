<?php
namespace App\Controller\Api;

use \Firebase\JWT\JWT;

use \App\Model\Entity\User;

class Auth extends Api{
   
    /**
     * Método responsável por gerar um token JWK
     * @param Request $request
     * @return array
     */
    public static function generateToken($request){
        //POST VARS
        $postVars = $request->getPostVars($request);
        
        //VALIDA OS CAMPOS OBRIGATÓRIOS
        if(!isset($postVars['email']) or !isset($postVars['senha'])){
            throw new \Exception("Os campos 'email' e 'senha' são obrigatórios",400);
        }
        
        //BUSCA USUÁRIO PELO EMAIL
        $obUser = User::getUserByEmail($postVars['email']);
        if(!$obUser instanceof User){
            throw new \Exception("O usuário ou senha são inválidos",400);
        }
        
        //VALIDA A SENHA DO USUÁRIO
        if(!password_verify($postVars['senha'],$obUser->senha)){
            throw new \Exception("O usuário ou senha são inválidos",400);
        }
        
        //PAYLOAD
        $payload = [
            'email' => $obUser->email
        ];
        
        //RETORNA O TOKEN GERADO
        return[
            'token' => JWT::encode($payload, getenv('JWT_KEY'))
        ];
    }
}