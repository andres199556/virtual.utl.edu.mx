var id_tipo_seleccionado = 0;
var permiso = 0;
function seleccionar_tipo(id_tipo_documento,elemento){
    var listas = $(".list-group-item");
    for(var i = 0;i<listas.length;i++){
        var lista = $(listas).eq(i);
        $(lista).removeClass("active");
    }
    $(".lista_"+id_tipo_documento).addClass("active");
    id_tipo_seleccionado = id_tipo_documento;
    var categoria = elemento;
    $.ajax({
    url:"buscar_direcciones.php",
    type:"POST",
    dataType:"json",
    data:{'id_tipo_documento':id_tipo_documento,'categoria':categoria}
    }).done(function(success){
    var resultado = success["resultado"];
    if(resultado == "no_existen"){
        $(".texto-error").html(success["mensaje"]);
        $("#row_buscar_documentos").addClass("hide");
        $("#id_direccion").prop("disabled",true);
        $(".row_error").removeClass("hide");
        $('.tabla_documentos tbody').html("");
        if ( $.fn.dataTable.isDataTable( '.tabla_documentos' ) ) {
            $('.tabla_documentos').DataTable().destroy();
            $('.tabla_documentos').DataTable().clear().destroy();
            //crear_tabla();
        }
        else{

        }
        
    }
    else{
        $(".row_error").addClass("hide");
        $("#row_buscar_documentos").removeClass("hide");
        $("#id_direccion").prop("disabled",false);
        var array_datos = success["data"];
        $("#id_direccion").html("");
        for(var i = 0;i<array_datos.length;i++){
            var id = array_datos[i][0];
            var text = array_datos[i][1];
            $("#id_direccion").append('<option value="'+id+'">'+text+'</option>');
        }
    }
    }).fail(function(error){
    alert("Error");
    });
}
function buscar_documentos(){
    var id_tipo_documento = id_tipo_seleccionado;
    var id_direccion = $("#id_direccion").val();
    var id_departamento = $("#id_departamento").val();
    switch(id_tipo_documento){
        case 8:
            //elimino un th
            break;
    }
    if(permiso == 1){
            var table = $('.tabla_documentos').DataTable( {
              "language": {
                      "url": "../assets/plugins/datatables/media/js/Spanish.json"
              },responsive: true,
          paging: true,
          retrieve: true,
              ajax: {
                  type: "POST",
                  url: "buscar_documentos.php",
                  data: {
                      "id_tipo_documento":id_tipo_documento,
                      "id_direccion":id_direccion,
                      "id_departamento":id_departamento
                  },
                  dataSrc:""
              },
              columnDefs: [
                  { className: "text-center", targets: "_all" },
              ],
          "columns": [
              {
              "data": "id_documento"
            },
            {
              "data": "codigo"
            },
            {
              "data": "titulo"
            },
            {
              "data": "version"
            },
            {
              "data": "comentarios"
            },
            {
              "data": "fecha_vigencia"
            },
            {
              "data": "responsable"
            },
            {
              "data": "nueva_version"
            },
            {
              "data": "editar"
            },
            {
              "data": "obsoleto"
            },
            {
              "data": "ver"
            }
          ]
      } );
    }
    else{
      var table = $('.tabla_documentos').DataTable( {
        "language": {
                "url": "../assets/plugins/datatables/media/js/Spanish.json"
        },responsive: true,
    paging: true,
    retrieve: true,
        ajax: {
            type: "POST",
            url: "buscar_documentos.php",
            data: {
                "id_tipo_documento":id_tipo_documento,
                "id_direccion":id_direccion,
                "id_departamento":id_departamento
            },
            dataSrc:""
        },
        columnDefs: [
            { className: "text-center", targets: "_all" },
        ],
    "columns": [
        {
        "data": "id_documento"
      },
      {
        "data": "codigo"
      },
      {
        "data": "titulo"
      },
      {
        "data": "version"
      },
      {
        "data": "comentarios"
      },
      {
        "data": "fecha_vigencia"
      },
      {
        "data": "responsable"
      },
      {
        "data": "ver"
      }
    ]
} );
    }
        
    $(".tabla_documentos").removeClass("dataTable");
    $( table.table().header()).addClass( 'th-header' );
    $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    $("#btnSeleccionarDireccion").removeClass("btn-success");
        
}

function buscar_departamentos(){
  var id_direccion = $("#id_direccion").val();
  $("#btnSeleccionarDireccion").addClass("btn-danger");
  $("#btnSeleccionarDireccion").html("<i class='fa fa-times'></i> Cancelar");
  $("#id_direccion").prop("disabled",true);
  $.ajax({
    url:"buscar_departamentos.php",
    type:"POST",
    dataType:"json",
    data:{'id_tipo_documento':id_tipo_seleccionado,'id_direccion':id_direccion}
    }).done(function(success){
    var resultado = success["resultado"];
    if(resultado == "no_existen"){
      $("#btnSeleccionarDepartamento").addClass("hide");
        $(".texto-error").html(success["mensaje"]);
        $("#row_buscar_documentos").addClass("hide");
        $("#id_direccion").prop("disabled",true);
        $(".row_error").removeClass("hide");
        $('.tabla_documentos tbody').html("");
        /* if ( $.fn.dataTable.isDataTable( '.tabla_documentos' ) ) {
            $('.tabla_documentos').DataTable().destroy();
            $('.tabla_documentos').DataTable().clear().destroy();
            //crear_tabla();
        } */
        /* if)
        else{

        } */
        
    }
    else{
      $("#btnSeleccionarDepartamento").removeClass("hide");
        $(".row_error").addClass("hide");
        $("#row_buscar_documentos").removeClass("hide");
        $("#id_departamento").prop("disabled",false);
        var array_datos = success["data"];
        $("#id_departamento").html("");
        for(var i = 0;i<array_datos.length;i++){
            var id = array_datos[i][0];
            var text = array_datos[i][1];
            $("#id_departamento").append('<option value="'+id+'">'+text+'</option>');
        }
    }
    }).fail(function(error){
    alert("Error");
    });
}
function enviar_obsoletos(id){
    swal({
        title: '¿Deseas enviar a obsoletos?',
        text: "Si el documento es enviado a documentos obsoletos solo los administradores podrán verlo.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Enviar a obsoletos',
          cancelButtonText:"Cancelar"
      }).then((result) => {
        if (result.value) {
            window.location = "obsoletos.php?id="+id;
        }
      });
}

function habilitar(id){
  swal({
      title: '¿Deseas volver a habilitar?',
      text: "Una vez habilitado se podrá editar y cargar nuevas versiones del mismo.",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Habilitar',
        cancelButtonText:"Cancelar"
    }).then((result) => {
      if (result.value) {
          window.location = "habilitar.php?id="+id;
      }
    });
}