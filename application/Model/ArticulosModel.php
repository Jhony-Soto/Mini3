<?php

/**
 * Class Songs
 * This is a demo Model class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

namespace Mini\Model;

use Mini\Core\Model;

class ArticulosModel extends Model
{

    public $codigo;
    public $producto;
    public $cantidad;
    public $valor_unidad;
    public $valor_venta;
    public $categoria;
    public $descripcion;
    public $imagen;


    function __SET($atributo,$valor){
        $this->$atributo=$valor;
    }

    function __GET($atributo){
        return $this->$atributo;
    }


    /**
     * Get all songs from database
     */
    public function getArticulos()
    {
        $sql = "SELECT codigo,
                    producto,
                    cantidad,
                    Valor_unidad,
                    Valor_venta,
                    (Valor_venta - Valor_unidad) as gananciaxUnidad,
                    (cantidad * Valor_unidad)as Inventario,
                    cod_categoria,
		            (SELECT nombre from tbl_categoria where codigo=p.cod_categoria)as categoria,Descripcion,imagen 
                    FROM `tbl_productos` as p;";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    /**
     * Add a song to database
     * TODO put this explanation into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     */
    public function addArticulo()
    {
        $sql = "INSERT INTO tbl_productos (codigo,producto,cantidad,Valor_unidad,Valor_venta,cod_categoria,descripcion,imagen) VALUES (?,?,?,?,?,?,?,?)";
        $query = $this->db->prepare($sql);
        $parameters = array(0 => '',
                            1 => $this->producto,
                            2 => 0,
                            3 =>0,
                            4 => $this->valor_venta,
                            5 => $this->categoria,
                            6 => $this->descripcion,
                            7=>$this->imagen);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        
         return $query->execute($parameters);
    }

    /**
     * Delete a song in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $song_id Id of song
     */
    public function deleteArticulo()
    {
        $sql = "DELETE FROM tbl_productos WHERE codigo = :cod";
        $query = $this->db->prepare($sql);
        $parameters = array(':cod' => $this->codigo);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

       return $query->execute($parameters);
    }

    /**
     * Get a song from database
     * @param integer $song_id
     */
    public function Apdate_Articulos ()
    {
     
        try{
            $sql = "UPDATE `tbl_productos` SET `producto`=:prod,`cantidad`=:cant,`Valor_unidad`=:vu,`Valor_venta`=:vv,`cod_categoria`=:cat,`Descripcion`=:desp,`imagen`=:img WHERE  `codigo`=:cod";
                $query = $this->db->prepare($sql);
                $parameters = array(':prod' => $this->producto,
                                    ':cant'=>$this->cantidad,
                                    ':vu'=>$this->valor_unidad,
                                    ':vv'=>$this->valor_venta,
                                    ':cat'=>$this->categoria,
                                    ':desp'=>$this->descripcion,
                                    ':img'=>$this->imagen,
                                    ':cod'=>$this->codigo);

                // // useful for debugging: you can see the SQL behind above construction by using:
                // // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

            return $query->execute($parameters);
        }catch(PDOException $e){
            return 'error'.$e->getMessage();
        }
        
    }

    /**
     * Update a song in database
     * // TODO put this explaination into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     * @param int $song_id Id
     */
    public function getArticulosId()
    {
        $sql = "SELECT * FROM tbl_productos WHERE codigo=?";
        $query = $this->db->prepare($sql);
        $query->bindParam(1,$this->codigo);
        $query->execute();
        return $query->fetch();
    }


    function totalInventario(){
        $sql=$this->db->prepare("SELECT SUM(cantidad*Valor_unidad) as 'Total_inventario' FROM tbl_productos");
        $sql->execute();
        return $sql->fetch();
    }

    function selectProductoLike($dato){
        $sql=$this->db->prepare("SELECT pro.codigo,pro.producto,pro.cantidad,pro.Valor_unidad,pro.Valor_venta,pro.cod_categoria,ca.nombre,pro.Descripcion,pro.imagen FROM `tbl_productos` as pro INNER join tbl_categoria as ca on pro.cod_categoria=ca.codigo where pro.producto like '%$dato%' or ca.nombre like '%$dato%' or pro.Descripcion like '%$dato%'");
        $sql->execute();
        
            return $sql->fetchAll();
       
        
    } 
    

}
