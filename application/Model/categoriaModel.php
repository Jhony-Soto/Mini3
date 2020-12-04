<?php

namespace Mini\Model;

use PDO;
use Mini\Core\model;

class categoriaModel extends Model
{
    private $codigo;
    private $nombre; 

    //CLASE QUE TIENE LA CONEXION
    function __construct(){
        parent::__construct();
    }

    function __SET($atributo,$valor){
        $this->$atributo=$valor;
    }

    function __GET($atributo){
        return $this->$atributo;
    }


    //OBTENEMOS TODAS LAS CATEGORIAS
    function getAll(){
        $sql="SELECT * FROM tbl_categoria";
        $strms=$this->db->prepare($sql);
        $strms->execute();
        return $strms->fetchAll();
    }

    function saveCategoria(){
        $sql = "INSERT INTO tbl_categoria (codigo,nombre) VALUES (?,?)";
        $query = $this->db->prepare($sql);
        $parameters = array(0 => '',
                            1 => $this->nombre);
                            
         return $query->execute($parameters);
    }


}
