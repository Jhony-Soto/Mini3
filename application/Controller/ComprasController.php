<?php
namespace Mini\Controller;
\session_start();
use Mini\Model\ComprasModel;
use Mini\Model\ArticulosModel;

class ComprasController extends ComprasModel
{
    private $compraModel;
    private $ArticulosModel;


    function __construct(){
        $this->compraModel=new ComprasModel();
        $this->ArticulosModel=new ArticulosModel();
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

    function generarCompra(){
        $arrayArticulos=$_POST['articulos'];
        $provedor=$_POST['provedor'];

        $this->compraModel->__SET('proveedor',$provedor);
        
        $lasIdcompra=$this->compraModel->crearCompra();
        if($lasIdcompra){
    
            for ($i=0; $i < count($arrayArticulos) ; $i++) {

                $this->compraModel->__SET('idproducto',$arrayArticulos[$i]['id']);
                $this->compraModel->__SET('cantidad',$arrayArticulos[$i]['cantidad']);
                $this->compraModel->__SET('valor_u',$arrayArticulos[$i]['valor']);
                
                $resul=$this->compraModel->crearCompraProducto();
            
                // SI LA COMPRA SE HIZO CON EXITO VAMOS A ACTALIZAR LA TABLA PRODUCTOS
                if($resul==1){

                    $this->ArticulosModel->__set('codigo',$arrayArticulos[$i]['id']);
                    $producto=$this->ArticulosModel->getArticulosId();
                    
                    // REALIAZAMOS EL PROMEDIO PONDERADO
                    $existencia=$producto->cantidad+$arrayArticulos[$i]['cantidad']; 
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

            echo \json_encode(['status'=>200,"message"=>"Se guardo la compra correctamente!"]);
        }else{
            echo \json_encode(['status'=>500,"message"=>"Ocurrio un error al guardar la compra !"]);
        }
    }

    function getCompras(){
        $res=$this->compraModel->reporteCompras();
        echo json_encode(['data'=>$res]);
    }

    //compras hechas el dia de hoy 
    function getDetalleCompra(){
        $res=$this->compraModel->getDetalleCompra();
        if(count($res)>0){

            $idCompras=[];
    
            foreach($res as $value){
                if(!in_array($value->id,$idCompras)){
                    array_push($idCompras,$value->id);
                }
            }
            $final=[];
            foreach($idCompras as $compra){
                $objec=[];
                foreach($res as $value){
                    if($compra==$value->id){
                        $objec['id']=$value->id;
                        $objec['fecha_compra']=$value->fecha;
                        $objec['proveedor']=$value->proveedor;
                        $objec['articulos']=[];
                    }
                }
                foreach($res as $value){
                    $art=[];
                    if($compra==$value->id_compra){
                        $art['producto']=$value->producto;
                        $art['cantidad']=$value->cantidad;
                        $art['valor_unidad']=$value->valor_unidad;
    
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

}