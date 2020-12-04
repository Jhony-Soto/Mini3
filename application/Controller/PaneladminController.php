<?php
namespace Mini\Controller;
use Mini\Model\ArticulosModel;
\session_start();

class PaneladminController
{
    private $articulosModel;

    function __construct(){
        $this->articulosModel=new ArticulosModel();
    }

    function index(){
        if(isset($_SESSION['usuario'])){

            $titulo='PanelAdministrativo';

            $estilos=[
                        'css/panel/adminlte.min.css',
                        'css/panel/all.min.css'
                    ];

            $script=[
                    'js/Panel/adminlte.min.js',
                    'js/Panel/bootstrap.bundle.js',
                    'js/Panel/index.js'
                    ];
            
            require_once APP.'view/_templates/header.php';
            require_once APP.'view/_templates/panel.php';
            require_once APP.'view/Paneladmin/index.php';
            require_once APP.'view/_templates/footer.php';

        }else{
            header('location:'.URL.'/Error');
        }
    }

    function infoGeneral(){
        $res= $this->articulosModel->totalInventario();
        $totalinvent=number_format($res->Total_inventario);
        echo json_encode(['Total_inventario'=>$totalinvent]);
    }

}