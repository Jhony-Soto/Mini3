
                    </div>
                <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

       <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.1.0-pre
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3 control-sidebar-content">
                <h5>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Personalizar AdminLTE</font>
                    </font>
                </h5><hr class="mb-2">
                <div class="mb-1">
                    <button  class="btn mr-1 text-light">Cerrar session <i class="fa fa-sign-out-alt"></i></button>
                </div>
            </div>
        </aside>
  <!-- /.control-sidebar -->
</div>
    <!-- define the project's URL (to make AJAX calls possible, even when using this in sub-folders etc) -->
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
