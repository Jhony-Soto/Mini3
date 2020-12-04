<?php 
namespace Mini\Model;
use Mini\Core\Model;
use PDO;
class ComprasModel extends Model
{
	private $proveedor;
	private $idcompra;
	private $idproducto;
	private $cantidad;
	private $valor_u;

	function __construct()
	{
		parent::__construct();
	}


	function __SET($atributo,$valor){
        $this->$atributo=$valor;
    }


	function crearCompra(){
		$fecha=date('Y-m-d');
			// return $fecha;
		$sql="INSERT INTO tbl_compra VALUES (:id,:fecha,:provedor)";
		$strm=$this->db->prepare($sql);
		if($strm->execute(array(':id'=>'',':fecha'=>$fecha,'provedor'=>$this->proveedor))){
			$this->idcompra=$this->db->lastInsertId();
			return $this->idcompra;
		}else{
			return false;
		}
	}


	function crearCompraProducto(){
		$sql="INSERT INTO tbl_compra_producto VALUES (:id,:compra,:producto,:cantidad,:valor_u)";
		$strm=$this->db->prepare($sql);
		return $strm->execute(array(':id'=>'',
									':compra'=>$this->idcompra,
									':producto'=>$this->idproducto,
									':cantidad'=>$this->cantidad,
									':valor_u'=>$this->valor_u));
	}

	function reporteCompras(){
		$fechaActual= Date('Y-m-d');
		$sql=$this->db->prepare("SELECT com.id,prove.proveedor,
											sum(compro.cantidad*compro.valor_unidad) as 'Total_de_compras',
											count(com.id) as 'Numero_de_compras'
									from tbl_compra as com inner join tbl_compra_producto as compro
												on com.id=compro.id_compra
										inner join tbl_proveedor as prove
												on com.proveedor=prove.id
												
												
									where com.fecha='$fechaActual'
												
									GROUP by prove.proveedor");
		$sql->execute();
		return $sql->fetchAll();
	}
		
	function getDetalleCompra(){
		$fechaActual= Date('Y-m-d');
		$sql=$this->db->prepare("SELECT com.id,
									com.fecha,
									prove.proveedor,
									compro.id_compra,
									prod.producto,
									compro.cantidad,
									compro.valor_unidad
									
								from tbl_compra as com left join tbl_compra_producto as compro
										on com.id=compro.id_compra
									left join tbl_proveedor as prove
										on com.proveedor=prove.id
									left join tbl_productos as prod
										on compro.id_producto=prod.codigo
								
								where com.fecha='$fechaActual'");
		$sql->execute();
		return $sql->fetchAll();							

	}
}