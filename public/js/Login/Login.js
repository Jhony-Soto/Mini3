$(document).ready(function(){

    alertify.set('notifier','position', 'top-right');

    let btn_ingresar=document.getElementById('boton');
  
    $('#registro').hide();

    $('#aceptar').click(function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        // document.getElementById('boton-registro').innerHTML='<div class="spinner-border text-dark" role="status">  <span class="sr-only">Loading...</span></div>';

        
        var cc=$.trim($('#cc').val());
        var nombre=$.trim($('#nombre').val());
        var apellido=$.trim($('#apellido').val());
        var usuario=$.trim($('#usuario').val());
        var contraseña1=$.trim($('#pass1').val());
        var contraseña2=$.trim($('#pass2').val());
        var foto=$.trim($('#foto').val());
        var email=$.trim($('#email').val());
    

        if(cc=='' || nombre=='' || apellido=='' || usuario=='' || contraseña2=='' || contraseña1==''){
            document.getElementById('error-registro').innerHTML='<div class="alert alert-danger">Todos los campos son obligatorios !</div>';
        }else{
            if(contraseña1!=contraseña2){
                document.getElementById('error-registro').innerHTML='<div class="alert alert-danger">Las contraseñas no coinciden !</div>';
            }else{
                if(email.indexOf('@',0)==-1 && email.indexOf('.',0)==-1){
                    document.getElementById('error-registro').innerHTML='<div class="alert alert-danger">Correo no valido !</div>';

                }else{
                    var formulario=new FormData($('#form-registro')[0]);
                    
                    $.ajax({
                        url:url+'Usuarios/registro',
                        type:'POST',
                        data:formulario,
                        cache:false,
                        processData:false,
                        contentType:false,
                        beforeSend:function(){
                            $('#mensaje').text('Estamos guardando tu información.');
                            $('#myModal').modal('show');
                        },
                        success:function(response){
                            alert(response);
                            setTimeout(()=>{
                                $('#myModal').modal('hide');
                                var data=JSON.parse(response);
                                console.log(data);
                                if(data.status==200){
                                    alertify.success(data.message);
                                    $('#form-registro')[0].reset();
                                    $('#formulario').show();
                                    $('#registro').hide();
                                     document.getElementById('error-registro').innerHTML='';
                                }else{
                                    alertify.error(data.message);
                                }

                            },2000)
                            
                        }
                    });
                }
            }
        }

    //     // document.getElementById('boton-registro').innerHTML='<div class="spinner-border text-primary" title="V alidando informacion" role="status"><span class="sr-only">Loading...</span></div>';
    });

    //  // LOGUEO
    $('#btnIngresar').click(()=>{
        let login=$('#email').val();
        let pass=$('#password').val();



        if(login=='' || pass==''){
            document.getElementById('info-error').innerHTML='<div class="alert alert-danger">Todos los campos son obligatorios !</div>';
        }else{
            if(login.indexOf('@',0)==-1 && login.indexOf('.',0)==-1 ){
                document.getElementById('info-error').innerHTML='<div class="alert alert-danger">Correo no valido !</div>';
            }else{

                var objec={
                    proceso:'ingresar',
                    user:login,
                    password:pass
                }

                $.ajax({
                    url:url+'Home/login',
                    type:'POST',
                    cache:false,
                    data:{objec},
                    beforeSend:function(){
                        $('#mensaje').text('Estamos validando tu información.');
                        $('#myModal').modal('show');
                    },
                    success:function(response){

                        var data=JSON.parse(response);
                        if(data.status==200){
                            location.href=url+'Paneladmin';
                        }else{
                            setTimeout(()=>{
                                $('#myModal').modal('hide');
                                alertify.error(data.message);
                            },2000);
                        }
                    }
                });
            }
        }
    })

    
    // //REGISTRO
    $('#registrarme').click(function(e){
        $.ajax({ url:url+'home/viewRegister',type:'post',success:function(res){
            document.getElementById('formContent').innerHTML=res;
            }
        });
        // $('#formulario').hide();
        // $('#registro').show();
    //     // document.getElementById('boton-registro').innerHTML='<input type="button" id="aceptar" class="fadeIn fourth" value="Aceptar">';
    });

});