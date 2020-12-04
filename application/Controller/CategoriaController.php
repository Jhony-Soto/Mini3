<?php
namespace Mini\Controller;
\session_start();
use Mini\Model\categoriaModel;


class CategoriaController extends categoriaModel
{

    private $categoriaModel;

    function __construct(){
        $this->categoriaModel=new categoriaModel();
    }


    function saveCategoria(){


        $this->categoriaModel->__SET('nombre',$_POST['categoria']);
        $res=$this->categoriaModel->saveCategoria();
        if($res){
           
            echo \json_encode(['status'=>200,"message"=>"Se Guardo la categoria correctamente !"]);
        }else{
            echo \json_encode(['status'=>400,"message"=>"Ocurrio un error en el proceso.Intentalo de nuevo !"]);
        }
    }
}
