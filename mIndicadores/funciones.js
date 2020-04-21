function eliminar(id){
    swal({
        title: '¿Deseas eliminar el indicador?',
        text: "El indicador seguirá existiendo y podrás verlo en el historial de indicadores.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
          cancelButtonText:"Cancelar"
      }).then((result) => {
        if (result.value) {
            //si lo tomo, por lo tanto actualizo el responsable
            $.ajax({
                url:"eliminar.php",
                type:"POST",
                dataType:"json",
                data:{'id':id},
                success:function(respuesta){
                    if(respuesta["resultado"] == "exito"){
                        window.location = "index.php?resultado=exito_eliminar";
                    }
                },
                error:function(xhr,status){
                    alert("Error");
                }
            });
        }
      });
}
function activar(id){
    swal({
        title: '¿Deseas activar el indicador?',
        text: "El indicador aparecerá en la sección principal de indicadores.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Activar',
          cancelButtonText:"Cancelar"
      }).then((result) => {
        if (result.value) {
            //si lo tomo, por lo tanto actualizo el responsable
            $.ajax({
                url:"activar.php",
                type:"POST",
                dataType:"json",
                data:{'id':id},
                success:function(respuesta){
                    if(respuesta["resultado"] == "exito"){
                        window.location = "index.php?resultado=exito_eliminar";
                    }
                },
                error:function(xhr,status){
                    alert("Error");
                }
            });
        }
      });
}