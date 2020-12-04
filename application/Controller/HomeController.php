<?php

/**
 * Class HomeController
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

namespace Mini\Controller;
use Mini\Model\usuarios;

\session_start();
class HomeController
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */

    public function index()
    {
        \session_destroy();
        $titulo='Login';
        $estilos=['css/Login/style.css'];
        $script=['js/Login/Login.js'];
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: exampleone
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function login()
    {

        
        if(isset($_POST['objec']['proceso'])){
                $usuarios=new usuarios();
                $usuarios->SET('email',$_POST['objec']['user']);
                $usuarios->SET('contraseña',md5($_POST['objec']['password']));
                $resul=$usuarios->getUsuario();
                if(!empty($resul)){
                        $_SESSION['usuario']=$resul;
                echo \json_encode(['status'=>200,'message'=>'Usuario y contraseña correctos']);
            }else{
                    echo \json_encode(['status'=>400,'message'=>'Usuario y/o contraseña incorrectos.']);
                }
            
            }
        }


}
