<?php

namespace Mini\Model;

use PDO;
use Mini\Core\model;

class ProveedorModel extends Model
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


    //OBTENEMOS TODAS LOS PROVEEDORES
    function getProveedores(){
        $sql="SELECT * FROM tbl_proveedor";
        $strms=$this->db->prepare($sql);
        $strms->execute();
        return $strms->fetchAll();	
    }


    function insert($datos){

        $sql=mysqli_query($this->connec,"INSERT INTO tbl_proveedor VALUES ('','$datos')");
        if ($sql){
            return true;
        }else{
            return fale;
        }	
    }


    function delete($id){
        $sql=mysqli_query($this->connec,"DELETE FROM tbl_proveedor where id='$id'");
        if ($sql){
            return true;
        }else{
            return false;
        }	

    }

    function selectProveedor($id){
        $sql=mysqli_query($this->connec,"SELECT * FROM tbl_proveedor where id='$id'");
        $sql=mysqli_fetch_array($sql);
        if ($sql){
            return $sql;
        }else{
            return $sql;
        }	

    }


    function updateProveedor($datos){
        $id=$datos['id'];
        $nombre=$datos['proveedor'];

        $sql=mysqli_query($this->connec,"UPDATE  tbl_proveedor
                                         SET proveedor='$nombre'
                                         WHERE id='$id'");
        if ($sql){
            return true;
        }else{
            return fale;
        }	

    }
}