<?php
namespace Mini\Controller;
\session_start();
use Mini\Model\ArticulosModel;
use Mini\Model\categoriaModel;


class ArticulosController extends ArticulosModel
{
    private $articulos;
    private $categorias;

    function __construct(){
        $this->articulos=new ArticulosModel();
        $this->categorias=new categoriaModel();
    }

    function index(){

        if(isset($_SESSION['usuario'])){

            $titulo='Articulos';

            $estilos=[
                        'css/panel/adminlte.min.css',
                        'css/panel/all.min.css'
                    ];

            $script=[
                    'js/Panel/adminlte.min.js',
                    'js/Panel/bootstrap.bundle.js',
                    'js/Articulos/articulos.js'
                    ];
            
            require_once APP.'view/_templates/header.php';
            require_once APP.'view/_templates/panel.php';
            require_once APP.'view/Articulos/index.php';
            require_once APP.'view/_templates/footer.php';

        }else{
            header('location:'.URL.'/Error');
        }

    }

    function getArticulos(){
        $res=$this->articulos->getArticulos();
        echo \json_encode(['status'=>200,'data'=>$res]);
    }
    
    function getCategorias(){
        $categoria=$this->categorias->getAll();
        echo \json_encode(['status'=>200,'data'=>$categoria]);
    }


    function saveArticulo(){
        
        $res=$this->saveImagen($_FILES['imagen']);
        if($res==1){
            echo \json_encode(['status'=>400,"message"=>"La imagen deb tener un formato(JPG/JPEG/GIF/PNG) !"]);
        }else{
            $this->articulos->__SET('producto',$_POST['nombre']);
            $this->articulos->__SET('categoria',$_POST['categoria']);
            $this->articulos->__SET('descripcion',$_POST['descripcion']);
            $this->articulos->__SET('valor_venta',$_POST['valor_v']);
            $this->articulos->__SET('imagen',$res);
            $res=$this->articulos->addArticulo();
            
            if($res){
                echo \json_encode(['status'=>200,"message"=>"Se guardo el articulo correctamente !"]);
            }else{
                echo \json_encode(['status'=>400,"message"=>"Lo sentimos , no se guardo el registro, vuelve a intentarlo !"]);
            }
        }

    }

    function saveImagen($img){

        
        $root=$_SERVER['DOCUMENT_ROOT'];
        $file_admin=$root.'/public/img/Articulos/';

        //si no existe la carpeta donde se guardaran las img la creadmos
        if(!file_exists($file_admin)){
            if(mkdir($file_admin,0777,true)){
                chmod($file_admin,0777);
            }
        }

         
        if($img['size']!=0){
            
            $tipo=$img['type'];
        
            if($tipo=="image/jpg" || $tipo=="image/jpeg" || $tipo=="image/png" || $tipo=="image/gif"){
                $tipo=explode('/',$tipo);
                $name=md5($img['name']).'.'.$tipo[1]; 
                $arhivo=$name;

                move_uploaded_file($img['tmp_name'],$file_admin.$name);

                return $name;
                
            }else{
                return  1;
            }
        }else{
            return 'Sin imagen';
        }


    }

    function update(){
        $res=$this->saveImagen($_FILES['imagen_edit']);


        if($res==1){
            echo \json_encode(['status'=>400,"message"=>"La imagen deb tener un formato(JPG/JPEG/GIF/PNG) !"]);
        }else{

            $this->articulos->__SET('codigo',$_POST['cod_edit']);
            $articulo=$this->articulos->getArticulosId();

            if($res=='Sin imagen'){
                $res=$articulo->imagen;
            }else{
                if($articulo->imagen!='Sin imagen')
                    unlink($_SERVER['DOCUMENT_ROOT'].'/public/img/Articulos/'.$articulo->imagen);
            }

            
            $this->articulos->__SET('codigo',$_POST['cod_edit']);
            $this->articulos->__SET('producto',$_POST['nom_edit']);
            $this->articulos->__SET('cantidad',$_POST['stock_edit']);
            $this->articulos->__SET('valor_unidad',$_POST['valor_unidad_edit']);
            $this->articulos->__SET('valor_venta',$_POST['valor_venta_edit']);
            $this->articulos->__SET('categoria',$_POST['categoria_edit']);
            $this->articulos->__SET('descripcion',$_POST['desp_edit']);
            $this->articulos->__SET('imagen',$res);
            $res=$this->articulos->Apdate_Articulos();
    
            if($res){
           
                echo \json_encode(['status'=>200,"message"=>"Se actualizo el articulo correctamente !"]);
            }else{
                echo \json_encode(['status'=>400,"message"=>"Ocurrio un error en el proceso.Intentalo de nuevo !"]);
            }

        }
    

            
    }

    function delete(){
        $this->articulos->__SET('codigo',$_POST['codigo']);
        $articulo=$this->articulos->getArticulosId();
    
        $res=$this->articulos->deleteArticulo();
        if($res){
            if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/img/Articulos/'.$articulo->imagen)){
                unlink($_SERVER['DOCUMENT_ROOT'].'/public/img/Articulos/'.$articulo->imagen);
            }
            echo \json_encode(['status'=>200,"message"=>"Se elimino el articulo correctamente !"]);
        }else{
            echo \json_encode(['status'=>400,"message"=>"Lo sentimos , no se gueliminar el registro, vuelve a intentarlo !"]);
        }
    }


    function todosProductos(){
        $categorias=$this->categorias->getAll();

        $resul=$this->articulos->getArticulos();
        echo json_encode(['categorias'=>$categorias,'articulos'=>$resul]);
    }




    function consultarProductos(){

        parent::cargarModelo('Categoria');
        $aumento=$this->model->aumentos();
        

        $hora=date("H:i:s");
        $hora=explode(":", $hora);

        if ($hora[0]>=22 or $hora[0]=00){
            $aumento=$aumento[0]['cantidad'];
        }else{
            $aumento=0;
        }




        $categoria=$_POST['opcion'];

        parent::cargarModelo('Productos');

        $resul=$this->model->productoXcategoria($categoria);

        $cards='';

        foreach ($resul as $value) {
            $cards.='<div class="col-sm-4">
                        <div class="card">
                              <img class="card-img-top" src="'.URL.$value['imagen'].'">
                              <div class="card-body">
                                <h5 class="card-title">'.$value['nombre'].'</h5>
                                <p class="card-text">'.$value['Descripcion'].'</p>
                                <span class="btn btn-primary form-control"><center> $'.number_format($value['Valor_venta']+ $aumento,0).'</center></span>
                              </div>
                        </div>
                    </div>';
        }

        echo ($cards);
    }

    function consultaPorcliente(){
        $producto=$this->articulos->selectProductoLike($_POST['input']);
        
        echo json_encode(['articulos'=>$producto]);
    }

   
}

