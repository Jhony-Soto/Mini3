<?php 
namespace Mini\Model;
use Mini\Core\Model;
use PDO;
class ventasModel extends Model
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


	function crearVenta(){
		$fecha=date('Y-m-d');
			// return $fecha;
		$sql="INSERT INTO tbl_venta VALUES (:id,:fecha)";
		$strm=$this->db->prepare($sql);
		if($strm->execute(array(':id'=>'',':fecha'=>$fecha))){
			$this->idcompra=$this->db->lastInsertId();
			return $this->idcompra;
		}else{
			return false;
		}
	}


	function crearVentaProducto(){
		$sql="INSERT INTO tbl_venta_producto VALUES (:id,:compra,:producto,:cantidad,:valor_u)";
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
		
	function getDetalleVenta(){
		$fechaActual= Date('Y-m-d');
		$sql=$this->db->prepare("SELECT ven.id,
											ven.fecha,
											venpro.id_venta,
											prod.producto,
											venpro.cantidad,
											venpro.valor_venta
																		
									from tbl_venta as ven left join tbl_venta_producto as venpro
											on ven.id=venpro.id_venta
										left join tbl_productos as prod
											on venpro.id_producto=prod.codigo
																	
									where ven.fecha='$fechaActual'");
		$sql->execute();
		return $sql->fetchAll();							

	}
}