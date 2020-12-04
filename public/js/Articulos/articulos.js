$(document).ready(()=>{
    var tablaArticulos;
    var tablaCategoria;

    $('.select2').select2({ width: 'resolve' });
    
    getDataCatgoria();

    tablaArticulos=$('#articulos').DataTable({
        "ajax": {
            "url": url+"Articulos/getArticulos",
            "type": "POST"
        },
        "columns":[
            {"data":'producto'},
            {"data":'cantidad'},
            {"data":'Valor_unidad'}, 
            {"data":'Valor_venta'},
            {"data":'gananciaxUnidad'},
            {"data":'Inventario'},
            {"data":'categoria'},
            {"data":'Descripcion'},
            {"defaultContent":'</button><button class="editar btn btn-outline-warning btn-sm" title="Editar registro"><i class="fas fa-pencil-alt"></i></button> | <button class="delete btn btn-outline-danger btn-sm" title="Eliminar registro"><i class="fas fa-trash-alt"></i></button>'}
        ],
         "language":{
                        "decimal":        ",",
                        "thousands":      ".",
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        },
                        "buttons": {
                            "copy": "Copiar",
                            "colvis": "Visibilidad"
                        }
        },

        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive":false
    });

    

    $('#articulos tbody').on('click','.editar',function (){
        var data=tablaArticulos.row($(this).parents('tr')).data();
        mapear(data);

    })

    $('#articulos tbody').on('click','.delete',function (){
        var data=tablaArticulos.row($(this).parents('tr')).data();
        
        $('#form_delete #cod_delete').val(data.codigo);
        $('#deleteArticulo').modal('show');
    })


    function mapear(data){
        console.log(data);
        $('#img').attr('src',url+'public/img/Articulos/'+data.imagen);
        $('#form_editar #cod_edit').val(data.codigo);
        $('#form_editar #nom_edit').val(data.producto);
        $('#form_editar #stock_edit').val(data.cantidad);
        $('#form_editar #valor_unidad_edit').val(data.Valor_unidad);
        $('#form_editar #valor_venta_edit').val(data.Valor_venta);
        $('#form_editar #desp_edit').val(data.Descripcion);
        $('#form_editar #categoria_edit').val(data.cod_categoria);
        $('#form_editar #categoria_edit').change();

        $('#modalArticulos').modal('show');
    }

    // CARGA LA IMAGEN SELECCIONADA PARA PREVISULAIZARLA
    document.getElementById('file').onchange=function(e){

        let reader= new FileReader();

        reader.readAsDataURL(e.target.files[0]);

        reader.onload=function(){
            let preview=document.getElementById('load-img');
            imagen=document.getElementById('foto');

            $('#load-img').removeClass('d-none');
            imagen.src=reader.result;
        }
    }

    //ARCTUALIZAR LA IMAGEN DEL ARTICULO
    document.getElementById('imagen_edit').onchange=function(e){

        let reader= new FileReader();

        reader.readAsDataURL(e.target.files[0]);

        reader.onload=function(){
            imagen=document.getElementById('img');
            imagen.src=reader.result;
        }
    }

    // FUNCION  PARA CARGAR EL SELECT DE CATEGORIAS Y LA DATATABLE DE ARTICULOS Y CATEGORIAS
    function getDataCatgoria(){
        $.ajax({
            method:'POST',
            url:url+'Articulos/getCategorias',
            success:function(res){
                var res=JSON.parse(res);
                cargarSelec_tablaCategoria(res.data);
            }
        });
    }

    function cargarSelec_tablaCategoria(data){
        data.forEach(categoria => {
            $('.categoria').append('<option value='+categoria.codigo+'>'+categoria.nombre+'</option>');
        });



    }
    
    
    // GUARDAR ARTICULO
    $('#form_articulos').on("submit",function(e){
        e.preventDefault();
        
        var n=$('#nombre').val();
        var c=$('#categoria').val();
        var d=$('#descripcion').val();
        var v=$('#descripcion').val();

    
        
        if(n=='' || c=='' || d=='' || v==''){
            document.getElementById('message').innerHTML='<div class="alert alert-danger" role="alert">  Los campos Nombre y categoria son obligatorios ! </div>';
        }else{
            document.getElementById('message').innerHTML='';

            var data=new FormData(document.getElementById('form_articulos'));

            $.ajax({
                method:'POST',
                url:url+'Articulos/saveArticulo',
                data:data,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    $('#mensaje').text('Estamos guardando los datos...');
                    $('#myModal').modal('show');
                },
                success:function(res){
                    
                    var data=JSON.parse(res);
                    setTimeout(()=>{
                        $('#myModal').modal('hide');
                        if(data.status==200){
                            $("#form_articulos")[0].reset();
                            alertify.success(data.message);
                            tablaArticulos.ajax.reload();
                        }else{
                            alertify.success(data.message);
                        }
                    },1000);

                }
            });
        }

    })


    //EDITAR Y GUARDAR UN ARTICULO
    //al hacer click en cambiar imagen hace visible el input file 
    $('#cambiar_img').on('click',(e)=>{
        e.preventDefault();
        $('#imagen_edit').removeClass('d-none');
    })

    //Guardar nueva inforamacion del articulo
    $('#actualizar').on('click',(e)=>{
        e.preventDefault();
        var data=new FormData(document.getElementById('form_edit'));

        $.ajax({
            url:url+'Articulos/update',
            type:'POST',
            data:data,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#modalArticulos').modal('hide');
                $('#mensaje').text('Estamos guardando los datos...');
                $('#myModal').modal('show');
            },
            success:function(res){
                var data=JSON.parse(res);
                setTimeout(()=>{

                    if(data.status==200){
                        $('#myModal').modal('hide');
                        $('#modalArticulos').modal('hide');
                        $("#form_edit")[0].reset();
                        $('#imagen_edit').addClass('d-none');
                        tablaArticulos.ajax.reload();
                        alertify.success(data.message);
                    }else{
                        alertify.error(data.message);
                    }

                },1000)
            }
        });
    })


    //Eliminar articulo
    $('#btn-delete').on('click',()=>{
        $.ajax({
            url:url+'Articulos/delete',
            type:'POST',
            beforeSend:function(){
                $('#deleteArticulo').modal('hide');
                $('#mensaje').text('Estamos Eliminado el registro...');
                $('#myModal').modal('show');
            },
            data:{codigo:$('#cod_delete').val()},
            success:function(res){
                var data=JSON.parse(res);
                setTimeout(()=>{
                    
                    if(data.status==200){
                        $('#myModal').modal('hide');
                        $('#deleteArticulo').modal('hide');
                        tablaArticulos.ajax.reload();
                        alertify.success(data.message);
                    }else{
                        alertify.error(data.message);
                    }
                },1000)
            }
        });
        
    })
 

    $('#saveCategoria').on('click',(e)=>{
        e.preventDefault();
        var categoria=$('#nombre_categoria').val();

        if(categoria==''){
            alertify.error('Todos los campos son obligatorias');
        }else{

            $.ajax({
                url:url+'Categoria/saveCategoria',
                type:'POST',
                data:{categoria},
                beforeSend:function(){
                    $('#mensaje').text('Estamos guardarndo los datos...');
                    $('#myModal').modal('show');
                },
                success:function(res){
                   
                    var data=JSON.parse(res);
                    setTimeout(()=>{
                        
                        if(data.status==200){
                            $('#myModal').modal('hide');
                            // alertify.success(data.message)
                            // tablaArticulos.ajax.reload();
                            alertify.success(data.message);
                        }else{
                            alertify.error(data.message);
                        }
                    },1000)
                }
            });
        }
    })

})