<?php 
    $root=$_SERVER['DOCUMENT_ROOT'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?= APP_NAME ?> - <?= $titulo ?></title>

    
	<link rel="icon" type="image/png" href="<?= URL ?>img/icono.png" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="En la licorera 4 esquinas vendemos todo tipo de licores con el mejor precio"/>
    <meta name="keywords" content="Rionegro,Estanquillo,Licorera,Venta de licor,estanquillo 4 esquinas,vinos y licores"/>
  
    <link rel="stylesheet" href="<?= URL ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= URL ?>css/alertify.min.css">
    <link rel="stylesheet" href="<?= URL ?>css/alertify.css">
    <link rel="stylesheet" href="<?= URL ?>fonts/style.css">
    <link rel="stylesheet" href="<?= URL ?>fonts/css/all.css">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- DATATABLES -->
    <link rel="stylesheet" href="<?= URL ?>css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= URL ?>css/responsive.bootstrap4.min.cs">

    <!-- SELECT2 -->
    <link rel="stylesheet" href="<?= URL ?>css/select2.css">

    <?php
        if(isset($estilos)){
            for($i=0;$i<count($estilos);$i++){
               echo '<link rel="stylesheet" href="'.URL.$estilos[$i].'">';
            }
        }
    ?>

</head>
<body>


  <header id="nav">
            <section class="nav" id="nav">
                <div class="logo">
                    <a href="<?= URL ?>">
                        <img src="<?= URL ?>img/logo2.png" alt="">
                    </a>
                </div>

                <div class="form-buscador">
                    <form onsubmit="buscarProductoCliente('<?= URL ?>');return false">
                        <input type="text" placeholder="Buscar Productos"id="buscador" autocomplete="off" required>
                        <button title="Buscar" type="submit"><i class="fa fa-search"></i></button>
                     </form>
                </div>
                
                <div class="enlaces">
                    <a href="https://www.facebook.com/Licorera-4-esquinas-103924317986011"><span class="icon-facebook-with-circle face"></span></a>
                    <a href="https://www.instagram.com/licorera_4_esquinas/?hl=es-la"><span class="icon-instagram-with-circle insta"></span></a>
                </div>
            </section>
    </header>
    <div id="relleno"></div> 

  
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-10" ><h5 id="mensaje">Cargado datos...</h5></div>
                <div class="col-sm-2">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

