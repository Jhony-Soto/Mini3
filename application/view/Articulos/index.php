<!-- MODAL DE DETALLE ARTICULOS -->
<!-- Modal -->
<div class="modal fade" id="modalArticulos"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center bg-dark">
                <h3>Detalle del Articulo</h3>
            </div> 
            <div class="modal-body bg-secondary">
                <div class="row">
                    <div class="col-lg-12" >
                        <form id="form_edit" enctype="multipart/form-data">
                            
                            <div class="text-center">
                                <img id="img" src="" class="rounded float-center bg-light" width="200" height="180">
                                <button class="btn btn-outline-info" id="cambiar_img">Cambiar Imagen</button>
                                <input type="file" name="imagen_edit" id="imagen_edit" class="form-control-file d-none my-3">
                            </div>
                            <div class="form-group" id="form_editar">
                                <input type="text" id='cod_edit' name="cod_edit" class="form-control" placeholder="Codigo del Producto" hidden autocomplete="off"/>
                                <label>Nombre</label>
                                <input type="text" name="nom_edit" id="nom_edit" class="form-control" placeholder="Nombre del Producto" autocomplete="off"/>
                                <label>Stock</label>
                                <input type="number" id='stock_edit' name="stock_edit" class="form-control" placeholder="Stock del Producto" autocomplete="off"/>
                                <label>Valor Unidad</label>
                                <input type="number" id='valor_unidad_edit' name="valor_unidad_edit" class="form-control" placeholder="Valor Unidad del Producto" autocomplete="off"/>
                                <label>Valor Venta</label>
                                <input type="number" id='valor_venta_edit' name="valor_venta_edit" class="form-control" placeholder="Valor venta del Producto" autocomplete="off"/>
                                <label>Descripcion</label>
                                <textarea type="text" class="form-control-file" name="desp_edit" id="desp_edit"></textarea>
                                <label>Categoria</label>
                                <select class="form-control select2 categoria" style="width:100%;" id="categoria_edit" name="categoria_edit">
                                    <option  disabled>Selecciona una Categoria</option>
                                </select>    
                            </div>
                        </form>  
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-dark">
                <button type="submit" id="actualizar" class="btn btn-outline-success">Actualizar información</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL DE DELETE ARTICULO -->
<!-- Modal -->
<div class="modal fade" id="deleteArticulo"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center bg-dark">
                <h3>Eliminar articulo</h3>
            </div> 
            <div class="modal-body bg-secondary">
                <div class="row">
                    <div class="col-lg-12" >
                        <form id="form_delete" enctype="multipart/form-data">
                            <input type="text" id='cod_delete' name="cod_delete" class="form-control" placeholder="Codigo del Producto" hidden autocomplete="off"/>  
                        </form>
                        <h6> ¿ Esta seguro de eliminar el articulo ?</h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-dark">
                <button type="submit" id="btn-delete" class="btn btn-outline-danger">Eliminar</button>
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<!-- Navegacion actual -->
<div class="col-lg-12">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>INVENTARIO</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= URL ?>/Paneladmin">Home</a></li>
                <li class="breadcrumb-item active"><?= $titulo ?></li>
                </ol>
            </div>
            </div>
        </div>
    </section>
</div>



<!-- Formulario de registro de nuevo articulo -->
<div class="col-lg-12">
    <div class="card bg-secondary collapse-card">     
        <div class="card-header">
            <h3 class="card-title"><i class="nav-icon far fa-plus-square"></i> Tabla de articulos</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
          <!-- /.card-header -->
        <div class="card-body text-center">
            <form id="form_articulos" enctype="multipart/form-data">
                <div class="row bg-dark mb-5 rounded">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" id='nombre' name="nombre" class="form-control" placeholder="Nombre del Producto" autocomplete="off"/>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>Categoria</label>
                        <select class="form-control select2 categoria" name="categoria" id="categoria">
                            <option  disabled>Selecciona una Categoria</option>
                        
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Valor Venta</label>
                        <input type="number" id='valor_v' name="valor_v" class="form-control" placeholder="Valor venta  del Producto" autocomplete="off"/>
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea type="text" class="form-control" name="descripcion" id="descripcion"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Imagen</label>
                        <input type="file" class="form-control-file" name="imagen" id="file">
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <div id="load-img" class="d-none">
                            <img id="foto" src="" class="rounded float-center bg-light" width="100" height="100">
                        </div>
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
                    <div class="col-md-6 mb-5">
                        <button type="submit" class="btn btn-outline-primary form-control" id="guardar">Guardar</button>
                        <div id="message" class="mt-3"></div>
                    </div>

                </div>
                </form>

                <!-- TABLA DE ARTICULOS -->
             
                    <table id="articulos" class="table table-bordered table-responsive bg-dark my-5">
                        <thead class="text-wrap">
                            <tr>
                                <th>ARTICULO</th>
                                <th>STOCK</th>
                                <th>VALOR UNIDAD</th>
                                <th>VALOR U/VENTA</th>
                                <th>GANANCIA X UNIDAD</th>
                                <th>INVENTARIO</th>
                                <th>CATEGORIA</th>
                                <th>DESCRIPCION</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
</div>







