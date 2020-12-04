$(document).ready(function(){
    

    //INFO GENTERAL
    $.ajax({
        url:url+'Paneladmin/infoGeneral',
        type:'POST',
        cache:false,
        beforeSend:function(){
            $('#mensaje').text('Cargando Informes Actuales');
            $('#myModal').modal('show');
        },
        success:function(response){
            var res=JSON.parse(response);
            console.log(res);
            setTimeout(()=>{
                $('#myModal').modal('hide');
                document.getElementById('total_inventario').innerHTML=`<h3>$ ${res.Total_inventario}</h3>`;
            },1000)
           
        }
    })
})