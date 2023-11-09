<?php

namespace App\Controller\Pages;

use \App\Utils\View;


class Page {

    /**
     * Método responsável por renderizar o topo da página
     * @return string
     */
    private static function getHeader() {
        return View::render('Pages/header');
    }

    /**
     * Método responsável por renderizar o layout de paginação
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    public static function getPagination($request, $obPagination) {
        //PAGINAS
        $pages = $obPagination->getPages();
         

        //VERIFICAR A QUANTIDADE DE PÁGINAS
        if (count($pages) <= 1) return '';

        //LINKS
        $links = '';

        //URL ATUAL (SEM GETS)
        $url = $request->getRouter()->getCurrentUrl();
       
        //GET
        $queryParams = $request->getQueryParams();
        


        //RENDERIZA OS LINKS
        foreach ($pages as $page) {
            //ALTERA A PAGINA
            $queryParams['page'] = $page['page'];

            //LINK
            $link = $url . '?' . http_build_query($queryParams);
            
            //VIEW
            $links .= View::render('Pages/pagination/link', [
                        'page'   => $page['page'],
                        'link'   => $link,
                        'active' => $page['current'] ? 'active' : ''
            ]);
        }
        //RENDERIZA BOX DE PAGINAÇÃO
        return View::render('pages/pagination/box', [
                    'links' => $links
        ]);
    }

    /**
     * Método responsável por renderizar o rodapé da página
     * @return string
     */
    private static function getFooter() {
        return View::render('Pages/footer');
    }

    /**
     * Método responsável por retornar o conteúdo (view) da nossa página genérica
     * @param type $title
     * @param type $content
     * @return string
     */
    public static function getPage($title, $content) {
        return View::render('Pages/Page', [
                    'title' => $title,
                    'header' => self::getHeader(),
                    'content' => $content,
                    'footer' => self::getFooter()
        ]);
    }

}
