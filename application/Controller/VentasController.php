<?php
namespace Mini\Controller;
\session_start();
use Mini\Model\ventasModel;
use Mini\Model\ArticulosModel;

class VentasController extends ventasModel
{
    private $ventaModel;
    private $ArticulosModel;


    function __construct(){
        $this->ventaModel=new ventasModel();
        $this->ArticulosModel=new ArticulosModel();
    }

    function index(){

        if(isset($_SESSION['usuario'])){

            $titulo='Ventas';

            $estilos=[
                        'css/panel/adminlte.min.css',
                        'css/panel/all.min.css'
                    ];

            $script=[
                    'js/Panel/adminlte.min.js',
                    'js/Panel/bootstrap.bundle.js',
                    'js/ventas/index.js'
                    ];
            
            require_once APP.'view/_templates/header.php';
            require_once APP.'view/_templates/panel.php';
            require_once APP.'view/ventas/index.php';
            require_once APP.'view/_templates/footer.php';

        }else{
            header('location:'.URL.'/Error');
        }

    }

    function generarVenta(){
        $arrayArticulos=$_POST['articulos'];

        
        $lasIdventa=$this->ventaModel->crearVenta();
        if($lasIdventa){
    
            for ($i=0; $i < count($arrayArticulos) ; $i++) {

                $this->ventaModel->__SET('idproducto',$arrayArticulos[$i]['id']);
                $this->ventaModel->__SET('cantidad',$arrayArticulos[$i]['cantidad']);
                $this->ventaModel->__SET('valor_u',$arrayArticulos[$i]['valor']);
                
                $resul=$this->ventaModel->crearVentaProducto();
            
                // SI LA COMPRA SE HIZO CON EXITO VAMOS A ACTALIZAR LA TABLA PRODUCTOS
                if($resul==1){

                    $this->ArticulosModel->__set('codigo',$arrayArticulos[$i]['id']);
                    $producto=$this->ArticulosModel->getArticulosId();
                    
                    // REALIAZAMOS EL PROMEDIO PONDERADO
                    $existencia=$producto->cantidad-$arrayArticulos[$i]['cantidad']; 
                    $inventario=(($producto->cantidad * $producto->Valor_unidad) + ($arrayArticulos[$i]['cantidad'] * $arrayArticulos[$i]['valor']));

                    $v_unidad=$inventario/$existencia;
        
                    $this->ArticulosModel->__SET('producto',$producto->producto);
                    $this->ArticulosModel->__SET('cantidad',$existencia);
                    $this->ArticulosModel->__SET('valor_unidad',$v_unidad);
                    $this->ArticulosModel->__SET('valor_venta',$producto->Valor_venta);
                    $this->ArticulosModel->__SET('categoria',$producto->cod_categoria);
                    $this->ArticulosModel->__SET('descripcion',$producto->Descripcion);
                    $this->ArticulosModel->__SET('imagen',$producto->imagen);
                    $res=$this->ArticulosModel->Apdate_Articulos();
                }
            }

            echo \json_encode(['status'=>200,"message"=>"Se guardo la venta correctamente!"]);
        }else{
            echo \json_encode(['status'=>500,"message"=>"Ocurrio un error al guardar la venta !"]);
        }
    }

    function getCompras(){
        $res=$this->compraModel->reporteCompras();
        echo json_encode(['data'=>$res]);
    }

    //compras hechas el dia de hoy 
    function getDetalleventa(){
        $res=$this->ventaModel->getDetalleVenta();
        if(count($res)>0){

            $idVentas=[];
    
            foreach($res as $value){
                if(!in_array($value->id,$idVentas)){
                    array_push($idVentas,$value->id);
                }
            }
            $final=[];
            foreach($idVentas as $venta){
                $objec=[];
                foreach($res as $value){
                    if($venta==$value->id){
                        $objec['id']=$value->id;
                        $objec['fecha_venta']=$value->fecha;
                        $objec['articulos']=[];
                    }
                }
                foreach($res as $value){
                    $art=[];
                    if($venta==$value->id_venta){
                        $art['producto']=$value->producto;
                        $art['cantidad']=$value->cantidad;
                        $art['valor_unidad']=$value->valor_venta;
    
                        array_push($objec['articulos'],$art);
                    }
                }
    
    
                array_push($final,$objec);
            }
            
            echo json_encode(['status'=>200,'data'=>$final]);
        }else{
            echo json_encode(['status'=>400,'data'=>[]]);

        }
    }


    function search(){
        $this->ArticulosModel->__set('producto',$_POST['inputSearch']);
        $res=$this->ArticulosModel->articulosLike();
        echo 'llego';
    }

    function report(){
        if(isset($_SESSION['usuario'])){

            $titulo='Reportes de Ventas';

            $estilos=[
                        'css/panel/adminlte.min.css',
                        'css/panel/all.min.css',
                        'css/Chart.min.js'
                    ];

            $script=[
                    'js/Panel/adminlte.min.js',
                    'js/Panel/bootstrap.bundle.js',
                    'js/ventas/report.js',
                    'js/Chart.min.js'
                    ];
            
            require_once APP.'view/_templates/header.php';
            require_once APP.'view/_templates/panel.php';
            require_once APP.'view/ventas/report.php';
            require_once APP.'view/_templates/footer.php';

        }else{
            header('location:'.URL.'/Error');
        }
    }

}