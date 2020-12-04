<?php
namespace Mini\Controller;


class CatalogoController
{


    function index(){
        $titulo='Catalogo';

        $estilos=[
                    'css/catalogo/estilo.css',
                ];

        $script=[
                'js/catalogo/funciones.js',
                ];
        
        require_once APP.'view/_templates/headerCatalogo.php';
        require_once APP.'view/catalogo/index.php';
        // require_once APP.'view/Paneladmin/index.php';
        require_once APP.'view/_templates/footerCatalogo.php';
    }

}