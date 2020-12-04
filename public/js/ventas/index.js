var articulosBD;
var arrayArticulos=[];
var totalPagar=0;
var tablaCompras;

$(document).ready(()=>{

    //Inicializa select2
    $('.selectProducto').select2();
    
    datalleVenta()

    function datalleVenta(){
        $('#detalles_compra').empty();
    
        $.ajax({type:'post',url:url+'Ventas/getDetalleventa'}).then(response=>{
            var data=JSON.parse(response)
            
            if(data.status==200){
                setTimeout(()=>{pintarDetallesVentas(data.data)},1000)
            }else{
                $('#detalles_compra').empty();
                $('#detalles_compra').append(`<div class="info-box shadow-lg bg-dark">
                                                <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">No cuenta con ventas hechas  el dia de hoy !</span>
                                                    <span class="info-box-number"></span>
                                                </div>
                                            </div>`)
            }
            
        })
        
    }

    function pintarDetallesVentas(data){
        console.log('daata de ventas hoy ',data);

        $('#detalles_compra').empty();
        var total_general=0;
        $.each(data,function(key,value){
            var card=`<div class="card card-warning collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Venta Numero # <span class="float-right badge bg-primary"> ${key+1}</span> </h3>

                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: none;">`;

            card+=`<table  class="table table-bordered table-responsive text-dark">
                        <thead>
                            <tr>
                                <td>ARTICULO</td>
                                <td>CANTIDAD</td>
                                <td>VALOR UNIDAD</td>
                                <td>SUBTOTAL</td>
                            </tr>
                        </thead>
                        <tbody>`;
            var total=0;
            $.each(value.articulos,function(key,art){
                total=total+(art.cantidad * art.valor_unidad)
                card+=`<tr>
                            <td>${art.producto}</td>
                            <td>${art.cantidad}</td>
                            <td>$ ${new Intl.NumberFormat("de-DE").format(art.valor_unidad)}</td>
                            <td>$ ${new Intl.NumberFormat("de-DE").format(art.cantidad * art.valor_unidad)}</td>
                        </tr>`;
            })

             card+=`<tr>
                    <td colspan="3">TOTAL CANCELADO</td>
                    <td colspan="3">$ ${new Intl.NumberFormat("de-DE").format(total)}</td>
                </tr>`

            card+=`</tbody>
            </table></div>
            </div>`;
            
            $('#detalles_compra').append(card)

            total_general=total_general+total;
            $('#h3valores').empty();
            $('#h3valores').append(`<i class="nav-icon far fa-plus-square"></i> Ventas  relizadas hoy - <small class="badge badge-success"><i   class="far fa-clock"></i> $ ${new Intl.NumberFormat("de-DE").format(total_general)}</small>`);

        })
    }
   
  //Obtenenos los articulos 
    $.ajax({
        type:"POST",
        url:url+"Articulos/getArticulos",
        cache:false,
        success:function(r){
            var datos=JSON.parse(r);
            datos=datos.data;
            articulosBD=datos;
            // console.log('ARTICULOS -> ',datos);
            datos.forEach(art => {
                $('.selectProducto').append('<option value='+art.codigo+'>'+art.producto+'</option>');
            });
        }   
    });



    //Evento change del select
    $('#select_producto').on('change',()=>{

        var cod_art=$('#select_producto').val()
     
        var res=articulosBD.find(art=>{
            return art.codigo==cod_art;
        })
        console.log(res); 
        $('#valor_unidad').val(res.Valor_venta)
    })


    //SUBMIT DEL FORMUALIO COMPRA
    $('#compra').on('submit',(e)=>{
        e.preventDefault();

        var object={
                        id:$('.selectProducto').val(),
                        nombre:$('.selectProducto[name="producto"] option:selected').text(),
                        valor:$('#valor_unidad').val(),
                        cantidad:$('#cantidad').val(),
                    }
        
        arrayArticulos.push(object);
        totalPagar=totalPagar+(object.cantidad*object.valor);

        var fila='';
        fila+='<tr>';
        fila+=`<td id="numero"><input type="number" name="cod_producto[]"class="form-control" value="${$('.selectProducto').val()}"></td>`;
        fila+=`<td id="numero"><input type="text" name="nombre_prod"class="form-control" value="${$('.selectProducto[name="producto"] option:selected').text()}"></td>`;
        fila+=`<td id="numero"><input type="number" name="cantidad[]"class="form-control" value="${$('#cantidad').val()}"></td>`;
        fila+=`<td id="numero"><input type="number" name="valor_U[]"class="form-control" value="${new Intl.NumberFormat("de-DE").format($('#valor_unidad').val())}"></td>`;
        fila+=`<td class="text-success">${new Intl.NumberFormat("de-DE").format($('#cantidad').val() * $('#valor_unidad').val())}</td>`;
    

        $('#tbody').append(fila);
                    
        
        // console.log('total_pagar a pagar -> ',new Intl.NumberFormat("de-DE").format(totalPagar));
        $('#total_pagar').val(new Intl.NumberFormat("de-DE").format(totalPagar));
        $("#compra")[0].reset();
    })


    //borra fila de la tabla
    $('.limpiarTabla').on('click',(e)=>{
        e.preventDefault();
        $('#tabla_compra tbody tr').remove();
        totalPagar=0;
        $('#total_pagar').val(totalPagar);
    })

    //GENERAR COMPRA
    $('#ventaForm').on('submit',(e)=>{
        e.preventDefault();


        if(arrayArticulos.length>=1){
            var provedor=$('#proveedor').val();
            $.ajax({
                url:url+'Ventas/generarVenta',
                type:'POST',
                cache:false,
                data:{articulos:arrayArticulos},
                beforeSend:function(){
                    $('#mensaje').text('Guardando la venta...');
                    $('#myModal').modal('show');
                },
                success:function(response){
                    var res=JSON.parse(response)
                    console.log(res);
                    setTimeout(()=>{
                        $('#myModal').modal('hide');
                        if(res.status===200){
                            $('#tabla_compra tbody tr').remove();
                            totalPagar=0;
                            $('#total_pagar').val(totalPagar);
                            alertify.success(res.message)
                            datalleVenta()
                            arrayArticulos=[];
                        }else{
                            alertify.error(res.message)
                        }
                    },1000)
                   
                }
            })
        }else{
            alertify.error('No hay productos agregados a la compra !');
        }
      
    });


})


