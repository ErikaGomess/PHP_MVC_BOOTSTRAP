<?php

use App\Http\Response;
use App\Controller\Pages;

//Rota home
$obRouter->get('/', [
    
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

// Rota sobre
$obRouter->get('/sobre', [
    'middlewares' =>[
        'cache' 
     ],
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);

$obRouter->get('/pagina/{idPagina}/{acao}', [
    function ($idPagina,$acao) {
        return new Response(200,'Página '.$idPagina.'-'.$acao);
    }
]);

//ROTA DEPOIMENTO
$obRouter->get('/depoimentos',[
        'middlewares' =>[
           'cache'
        ],
        function ($request){
            return new Response(200, Pages\Testimony::getTestimonies($request));
        }
]);

//ROTA DEPOIMENTO (INSERT)
$obRouter->post('/depoimentos',[
        function ($request){
           return new Response(200, Pages\Testimony::insertTestimony($request));
        }
]);