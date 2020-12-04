<?php


namespace Mini\Model;

use Mini\Core\Model;
use PDO;
use Mini\Libs\Helper;

class usuarios extends Model
{

    Private $documento;
    private $contraseña;
    private $nombre;
    private $email;
    private $imagen;
    private $apellido;
    private $usuario;
    private $helper;

    function __construct(){
        $this->helper=new Helper();
        parent::__construct();
    }

    function SET($name, $value)
    {
        $this->$name=$value;
    }
    function GET($name)
    {
        return $this->$name;
    }


    // INSERTAR
    function addUsuarios(){
        $sql="INSERT into tbl_admin (documento,contrasenia,nombre,email,Imagen,apellido,usuario) values(?,?,?,?,?,?,?)";
        try{
        $strm=$this->db->prepare($sql);
        $strm->bindParam(1,$this->documento);
        $strm->bindParam(2,$this->contraseña);
        $strm->bindParam(3,$this->nombre);
        $strm->bindParam(4,$this->email);
        $strm->bindParam(5,$this->imagen);
        $strm->bindParam(6,$this->apellido);
        $strm->bindParam(7,$this->usuario);
        
            return $strm->execute();
        }catch(\PDOException $e){
            return $e->getcode();
               
            
        }
    }

    //CONSULTA USUARIO
    function getUsuario(){
        $sql="SELECT * FROM tbl_admin where email=? and contrasenia=?";
        $strm=$this->db->prepare($sql);
        $strm->bindParam(1,$this->email);
        $strm->bindParam(2,$this->contraseña);
        $strm->execute();
        return $strm->fetchAll(PDO::FETCH_ASSOC);
    
    }
} 
