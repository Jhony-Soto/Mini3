

<!-- Footer -->
<footer class="page-footer font-small blue">
	<div class="direccion">
		<h5>Rionegro Antioquia</h5>
		<p>Dirección : Cra 46 N°41- 46  Barrio 4 esquinas, al lado del cai.</p>
		<p>Teléfonos : 3226510502 - 3148396980 -3136221255</p>
		<div class="footer-copyright text-center">© 2020 Desarrollado por :
    		<a>Jhalsolo@gmail.com</a>
  		</div>
	</div>
  <!-- Copyright -->

  <!-- Copyright -->

</footer>
<!-- Footer -->

 <script>
        var url = "<?php echo URL; ?>";
    </script>

    <!-- our JavaScript -->
    <script src="<?php echo URL ?>js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo URL ?>js/alertify.min.js"></script>
    <script src="<?php echo URL ?>js/font Js/all.js"></script>

    <!-- DATATABLES -->
    <script src="<?= URL ?>js/jquery.dataTables.min.js"></script>
    <script src="<?= URL ?>js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= URL ?>js/dataTables.responsive.min.js"></script>
    <script src="<?= URL ?>js/responsive.bootstrap4.min.js"></script>

    <!-- SELECT2 -->
    <script src="<?= URL ?>js/select2.full.min.js"></script>
    

    <?php
        if(isset($script)){
            for($i=0;$i<count($script);$i++){
                echo '<script src="'.URL.$script[$i].'"></script>';
            }
        }
    ?>
    
</body>
</html>