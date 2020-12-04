var categorias;
var articulos;

$('#exampleModalLong').modal('show')
$(document).ready(function(){
	todosProductos(url);
	nuevaVisita(url);
});


function cargarProductos(opcion,direccion){

	if (opcion==0) {
		todosProductos(direccion);
	}else{
		$.ajax({
			type:"POST",
			url:direccion+"Main/consultarProductos",
			data:{opcion},
			beforeSend:function(){
				document.getElementById('contenido').innerHTML='<div class="alert alert-success" role="alert"><h1>Cargando ...</h1></div>';
			
			},
			success:function(r){
				document.getElementById('contenido').innerHTML=r;
			}
		});
	}
}


function todosProductos(direccion){
	$.ajax({
		type:"POST",
		url:direccion+"Articulos/todosProductos",
		beforeSend:function(){
			$('#contenido-productos').append(`  <div class="spinner" style="margin:auto;">
			<div class="double-bounce1"></div>
			<div class="double-bounce2"></div>
		</div>`);
		},
		success:function(r){
			var data=JSON.parse(r)
			categorias=data.categorias
			articulos=data.articulos

			pintarCategorias();
			pintarArticulos();
		}
	});
}

function pintarCategorias(){

	var list='';
	$.each(categorias,function(key,value){
		if(key==0){
			list+=`<button type="button" class="btn btn-light form-control listcategoria active" onclick="selectCte(this)" value="${value.codigo}">${value.nombre}</button>`;
		}else{
			list+=`<button type="button" class="btn btn-light form-control listcategoria" onclick="selectCte(this)" value="${value.codigo}">${value.nombre}</button>`;
		}
	})
	// $('#listCategoria').empty();
	$('#listCategoria').append(list);
}


function pintarArticulos(){
	var idCategoria=0;
	$('#listCategoria button').each(function(){
		var activa=$(this)[0].classList
		if(activa[4]=='active'){
			idCategoria=$(this).val();
		}
	})

	var array=[];
	$.each(articulos,function(key,value){
		if(value.cod_categoria==idCategoria){
			array.push(value);
		}
	})
	
	console.log('articulos ',array);
	var card='';

	if(array.length>0){
		$.each(array,function(key,value){
			card+=`
					<div class="col-sm-4">
					<div class="card">
						<img class="card-img-top" src="<?= URL ?>${value.imagen}">
						<div class="card-body">
							<h5 class="card-title">${value.producto}</h5>
							<p class="card-text">${value.Descripcion}</p>
							<span class="btn btn-primary  form-control"><center>$ ${new Intl.NumberFormat().format(value.Valor_venta)}</center></span>
						</div>
					</div>
				</div>
			`;
		})
	}else{
		card+=`<div class="text-white d-flex h-100 mask peach-gradient-rgba">
		<div class="first-content align-self-center p-3">
		  <h3 class="card-title">! Lo Sentimos !</h3>
		  <p class="lead mb-0">Este producto se encuentra agotado.</p>
		</div>
		<div class="second-content  align-self-center mx-auto text-center">
		  <i class="fas fa-exclamation-circle fa-3x"></i>
		</div>
	  </div>`;
	}

	$('#contenido-productos').empty();
	$('#contenido-productos').append(card);

}




function selectCte(control){	
	$('#contenido-productos').empty();
	$('#contenido-productos').append(`<div class="sk-circle">
	<div class="sk-circle1 sk-child"></div>
	<div class="sk-circle2 sk-child"></div>
	<div class="sk-circle3 sk-child"></div>
	<div class="sk-circle4 sk-child"></div>
	<div class="sk-circle5 sk-child"></div>
	<div class="sk-circle6 sk-child"></div>
	<div class="sk-circle7 sk-child"></div>
	<div class="sk-circle8 sk-child"></div>
	<div class="sk-circle9 sk-child"></div>
	<div class="sk-circle10 sk-child"></div>
	<div class="sk-circle11 sk-child"></div>
	<div class="sk-circle12 sk-child"></div>
  </div>`);

	$('#listCategoria button').each(function(){
		if($(this).val()==control.value){
			$(this).addClass('active');

		}else{
			$(this).removeClass('active');
		}
	})
	setTimeout(()=>{
		pintarArticulos()
	},1000)
}

function resultSearch(array){
		var card='';
		$.each(array,function(key,value){
			card+=`
					<div class="col-sm-4">
					<div class="card">
						<img class="card-img-top" src="<?= URL ?>${value.imagen}">
						<div class="card-body">
							<h5 class="card-title">${value.producto}</h5>
							<p class="card-text">${value.Descripcion}</p>
							<span class="btn btn-primary  form-control"><center>$ ${new Intl.NumberFormat().format(value.Valor_venta)}</center></span>
						</div>
					</div>
				</div>
			`;
		})
	
	$('#contenido-productos').empty();
	$('#contenido-productos').append(card);
}
function login(direccion){

	var datos=$('#formulario').serialize();

	$.ajax({
		type:"POST",
		url:direccion+"Login/validarLogin",
		cache:false,
		data:{datos},
		success:function(r){
			if(r==1){
				swal("BIENVENIDO !","","success")
				.then((value) => {
  					window.location=direccion+"Home";
				});
			}else{
				swal("Datos incorrectos","Por favor valida tus datos","error");
			}
		}
	});
}	


function aggCategoria(direccion){
	var datos=$('#frmcategoria').serialize();

	$.ajax({
		type:"POST",
		url:direccion+"Categoria/insert",
		cache:false,
		data:{datos},
		success:function(r){
			if(r==1){
				cargarCategoria(direccion);
			}else{
				swal("Datos incorrectos","Por favor valida tus datos","error");
			}
		}
	});
}


function SetProductos(direccion){

	$.ajax({
		type:"POST",
		url:direccion+"Producto/todosProductos",
		beforeSend:function(){
			document.getElementById('contenido').innerHTML='<div class="alert alert-success" role="alert"><h1>Cargando ...</h1></div>';
			
		},
		success:function(r){
			document.getElementById('contenido').innerHTML=r;
			
		}
	});
}


function aggAumento(direccion){
	var datos=$('#frmaunmento').serialize();

	$.ajax({
		type:"POST",
		url:direccion+"Categoria/aumento",
		cache:false,
		data:{datos},
		success:function(r){
			if(r==1){
				cargarAumento(direccion);
			}else{
				swal("Datos incorrectos","Por favor valida tus datos","error");
			}
		}
	});
}

function cargarCategoria(direccion){
	$.ajax({
		type:"POST",
		url:direccion+"Categoria/todosCategoria",
		beforeSend:function(){
			document.getElementById('contenido').innerHTML='<div class="alert alert-success" role="alert"><h1>Cargando ...</h1></div>';
			
		},
		success:function(r){
			document.getElementById('contenido').innerHTML=r;
		}
	});
}

function cargarAumento(direccion){
	$.ajax({
		type:"POST",
		url:direccion+"Categoria/todosAumento",
		beforeSend:function(){
			document.getElementById('tablaAumento').innerHTML='<div class="alert alert-success" role="alert"><h1>Cargando ...</h1></div>';
			
		},
		success:function(r){
			document.getElementById('tablaAumento').innerHTML=r;
		}
	});
}

function cerrarModal(){
	document.getElementById('overlay').style.display="none";
}


function nuevaVisita(direccion){
	$.ajax({
		type:"POST",
		url:direccion+"Main/nuevaVisita",
		cache:false,
	});
}

function consultarVisitas(direccion){
	var datos=$('#formVisitas').serialize();

	$.ajax({
		type:"POST",
		url:direccion+"Visitas/consultar",
		cache:false,
		data:{datos},
		success:function(r){
			document.getElementById('contenido').innerHTML=r;
		}
	});
}


function buscarProducto(direccion){
	var input=$('#buscador').val();

	$.ajax({
		type:"POST",
		url:direccion+"Producto/consultar",
		cache:false,
		data:{input},
		beforeSend:function(){
			document.getElementById('contenido').innerHTML='<div class="alert alert-success" role="alert"><h1>Cargando ...</h1></div>';
		},
		success:function(r){
			document.getElementById('contenido').innerHTML=r;
			$('#formBuscar')[0].reset();
		}
	});
}

function buscarProductoCliente(direccion){
	
	window.location='#contenidoLoad';

	$('#contenido-productos').empty();
	$('#contenido-productos').append(`<div class="sk-circle">
	<div class="sk-circle1 sk-child"></div>
	<div class="sk-circle2 sk-child"></div>
	<div class="sk-circle3 sk-child"></div>
	<div class="sk-circle4 sk-child"></div>
	<div class="sk-circle5 sk-child"></div>
	<div class="sk-circle6 sk-child"></div>
	<div class="sk-circle7 sk-child"></div>
	<div class="sk-circle8 sk-child"></div>
	<div class="sk-circle9 sk-child"></div>
	<div class="sk-circle10 sk-child"></div>
	<div class="sk-circle11 sk-child"></div>
	<div class="sk-circle12 sk-child"></div>
  </div>`);

	var input=$('#buscador').val();

	$.ajax({
		type:"POST",
		url:direccion+"Articulos/consultaPorcliente",
		cache:false,
		data:{input},
		success:function(r){
			var data=JSON.parse(r)
			setTimeout(()=>{
				if(data.articulos.length==0){
					var card='';
					card+=`<div class="text-white d-flex h-100 mask peach-gradient-rgba  mx-auto">
								<div class="first-content align-self-center p-3">
								<h3 class="card-title">! Lo Sentimos !</h3>
								<p class="lead mb-0">No hay resultados para "${input}"</p>
								</div>
								<div class="second-content  align-self-center mx-auto text-center">
								<i class="fas fa-exclamation-circle fa-3x"></i>
								</div>
							</div>`;
		
					$('#contenido-productos').empty();
					$('#contenido-productos').append(card);
				}else{
					resultSearch(data.articulos)
				}

			},1000)


		}
	});
}
		

function totalInventario(direccion){
		$.ajax({
			type:"POST",
			url:direccion+"Home/totalInventario",
			beforeSend:function(){
				document.getElementById('total_inventario').innerHTML='Cargando...';
			},
			success:function(r){
				document.getElementById('total_inventario').innerHTML=r;
			}
		});
}

function gananciaMenual(direccion){
		$.ajax({
			type:"POST",
			url:direccion+"Home/gananciaMenual",
			beforeSend:function(){
				document.getElementById('ganancia_mensual').innerHTML='Cargando...';
			},
			success:function(r){
				document.getElementById('ganancia_mensual').innerHTML=r;
			}
		});
}
