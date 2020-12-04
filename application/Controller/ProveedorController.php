<?php
namespace Mini\Controller;
\session_start();
use Mini\Model\ProveedorModel;



class ProveedorController extends ProveedorModel
{
    private $articulos;
    private $proveedorModel;

    function __construct(){
        $this->proveedorModel=new ProveedorModel();
    }

    function index(){

        if(isset($_SESSION['usuario'])){

            $titulo='Compras';

            $estilos=[
                        'css/panel/adminlte.min.css',
                        'css/panel/all.min.css'
                    ];

            $script=[
                    'js/Panel/adminlte.min.js',
                    'js/Panel/bootstrap.bundle.js',
                    'js/Compra/index.js'
                    ];
            
            require_once APP.'view/_templates/header.php';
            require_once APP.'view/_templates/panel.php';
            require_once APP.'view/Compra/index.php';
            require_once APP.'view/_templates/footer.php';

        }else{
            header('location:'.URL.'/Error');
        }

    }


    function getProveedores(){
        $res= $this->proveedorModel->getProveedores();
        echo \json_encode(['status'=>200,'data'=>$res]);
    }

}