<!-- Navegacion actual -->
<div class="col-lg-12">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= ($titulo) ?></h1>
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
            <h3 class="card-title"><i class="nav-icon far fa-plus-square"></i> Realizar una Venta</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        
        <div class="card-body text-center">
	
			<div class="bg-dark rounded px-4 pt-2">
				<form id="compra">
					<div class="row">
						<div class="col-lg-6" >
							<label class="ml-3">PRODUCTO</label>
							<select class="form-control selectProducto" name="producto" id="select_producto"  required>
								<option value="" disabled selected> Seleccione un producto</option>
							</select>	
							<label class="ml-3">CANTIDAD</label>
							<input type="number" name="cantidad"class="form-control" id="cantidad" required>
						</div>

						<div class="col-lg-6" >
							<label class="ml-3">Valor Unidad</label>
							<input type="number" name="valor_unidad"class="form-control" id="valor_unidad" required>
							<br>
							<button type="submit" class="btn btn-outline-success"><span class="icon-circle-with-plus"></span></button>
						</div>

					</div>
				</form>

				<button class="limpiarTabla btn btn-outline-danger mt-5">Limpiar tabla</button>
				<div id="tabla"></div><BR>
		

				<table class="table col-lg-12" id='tabla_compra'>
					<thead class="thead-dark">
						<tr>
							<th scope="col">CODIGO</th>
							<th scope="col">ARTICULO</th>
							<th scope="col">CANTIDAD</th>
							<th scope="col">VALOR UNIDAD</th>
							<th scope="col">SUBTOTAL</th>
						</tr>
					</thead>

						<tbody id='tbody'>
								<!--contenido de la tabka  -->
						</tbody>
						<tfoot>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th>TOTAL A PAGAR</th>
								<th  class="bg-success"><input type="number" id="total_pagar" disabled></th>
							</tr>
						<t/foot>
				</table>
            <form id="ventaForm" class="py-5">
                <button type="submit" class="btn btn-outline-primary">Guardar Compra</button>
            </form>
			</div>


		</div>
    </div>
</div>


<!-- Formulario de registro de nuevo articulo -->
<div class="col-lg-12">
    <div class="card bg-secondary collapse-card">     
        <div class="card-header">
            <h3 class="card-title" id="h3valores"></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

		<div class="card-body text-center" style="display:block"  id="detalles_compra"> 
			<div class="spinner-border text-ligth" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDetalleCompra"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center bg-dark">
                <h3 id="tituloCompras"></h3>
            </div> 
            <div class="modal-body bg-secondary">
                <div class="row">
					<div class="col-lg-12" id="detalles_compra" style="text-align:center">
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-dark">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



