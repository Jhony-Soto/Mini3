<?php

/**
 * Class SongsController
 * This is a demo Controller class.
 *
 * If you want, you can use multiple Models or Controllers.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

namespace Mini\Controller;

use Mini\Model\usuarios;

class UsuariosController 
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/songs/index
     */


    /**
     * ACTION: addSong
     * This method handles what happens when you move to http://yourproject/songs/addsong
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a song" form on songs/index
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to songs/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function registro()
    {   
        $foto=$this->validarFoto($_FILES['foto']);
        // print_r($_FILES['foto']);
        if($foto!==0){
            $usuario=new usuarios();
            $usuario->SET('documento',$_POST['cc']);
            $usuario->SET('contraseña',md5($_POST['pass1']));
            $usuario->SET('nombre',$_POST['nombre']);
            $usuario->SET('email',$_POST['email']);
            $usuario->SET('imagen',$foto);
            $usuario->SET('apellido',$_POST['apellido']);
            $usuario->SET('usuario',$_POST['usuario']);

            $resul=$usuario->addUsuarios();
                switch ($resul){
                    case 1 :
                        echo json_encode(['status'=>200,'message'=>'Se realizo el registro existosamente !.']);
                    break;
                    case 23000:
                        echo json_encode(['status'=>400,'message'=>'El documento de identidad ya esta registrado.']);
                    break;
                    default:
                    echo json_encode(['status'=>400,'message'=>'Hubo un error al guardar el registro.']);
                }
                        
            
        }else{
           echo json_encode(['status'=>400,'message'=>'El archivo no tiene un formato de imagen (JPG,JPEG,PNG).']); 
        }
       
    }

    function validarFoto($foto){
        if($foto['name']!=''){
            $nombre=$_FILES['foto']['name'];
            $tipo=$_FILES['foto']['type'];
            $tmp=$_FILES['foto']['tmp_name'];
            if($tipo=='image/jpg' or $tipo=='image/jpeg' or $tipo=='image/png' ){
    
                $nombre=md5($nombre);
                $ruta=ROOTA.'/img/usuarios/'.$nombre.'.jpg';
                move_uploaded_file($tmp,$ruta);
                return $ruta;
            }else{
                return 0;
            }
        }else{
            return null;
        }
    }




}
