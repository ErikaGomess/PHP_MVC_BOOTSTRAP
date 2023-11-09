<?php

namespace App\Controller\Admin;

use \App\Utils\View;


class Home extends Page{
   
    /**
     * Método responsável por renderizar a view de home do painel
     * @param Request $request
     * @return string
     */
    public static function getHome($request) {
        //CONTEÚDO DA HOME
        $content = View::render('admin/module/home/index',[]);
        
        //RETORNAR A PÁGINA COMPLETA
        return parent::getPanel('Home > WDEV', $content,'home');
    }
} 