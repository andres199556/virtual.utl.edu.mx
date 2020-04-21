<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    include "../template/metas.php";
    ?>
    <style>
    .attachment-preview{
        border:2px solid #cbcbcb;
        width:200px;
        height:70px;
        border-radius:10px;
        margin-bottom:10px;
    }
    .attachment-preview .attachment-icon{
        float:left;
        background:#4bb5fc;
        border-radius:10px 0px 0px 10px;
        width:70px;
        height:66px;
        color:#ffffff;
    }
    .attachment-preview .attachment-content2{
        position:absolute;
        background:#fdfdfd;
        margin-left:70px;
        width:125px;
        border-radius:0px 10px 10px 0px;
        height:66px;
        
    }
    .attachment-preview .attachment-icon .icon{
        font-size:30px;
        position:absolute;
        margin-left:24px;
        margin-top:17px;

    }
    .attachment-name{
        position:absolute;
        font-weight:bold;
        left:10px;
    }
    .attachment-description{
        position:absolute;
        margin-top:26px;
        left:10px;
        font-size:15px;
        overflow:hidden;
        white-space:nowrap;
        text-overflow: ellipsis;
    }
    .removeAttachment{
        background:#797D7F ;
        width:15px;
        height:15px;
        position:absolute;
        margin-left:100px;
        border-radius:10px;
        color:#ffffff;
        font-size:10px;
        margin-top:5px;
        text-align:center;
        cursor:pointer;
        
    }
    .span-cancelar{
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding: .375rem .75rem;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
    }
        .btn-toggle{
            color:#fff;
            font-weight:bold;
            font-size:20px;
        }
        .span-right{
            position: absolute;
            top: 54%;
            right: 15px;
            margin-top: -7px;
        }
        .span-soporte{
            position: absolute;
            top: 61%;
            right: 15px;
            margin-top: -7px;
        }
        .span-puesto{
            position: absolute;
            top: 67%;
            right: 15px;
            margin-top: -7px;
        }
    </style>
    <link rel="stylesheet" href="../material/css/icons/font-awesome2/css/fontawesome.css">
    <link rel="stylesheet" href="../material/css/icons/font-awesome2/css/all.css">
</head>

<body class="fix-sidebar fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php
                include "../template/navbar.php";
                ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php
        include "../template/sidebar.php";
        ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $modulo_actual;?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $categoria_actual;?></a></li>
                            <li class="breadcrumb-item active"><?php echo $modulo_actual;?></li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-0">
                            <!-- .chat-row -->
                            <div class="chat-main-box">
                                <!-- .chat-left-panel -->
                                <div class="chat-left-aside">
                                    <div class="open-panel"><i class="ti-angle-right"></i></div>
                                    <div class="chat-left-inner">
                                        <div class="form-material">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button style="margin-left:5px;margin-top:5px;" title="Configuración" data-toggle="tooltip" class="btn btn-sm btn-warning"><i class="fa fa-cog"></i></button>
                                                    <button id="btnNew" style="float:right;margin-right:5px;margin-top:5px;" title="Nueva conversación" data-toggle="tooltip" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button>
                                                </div>
                                            </div>
                                        <div class="input-group">
                                            <input type="search" class="form-control p-20" placeholder="Buscar" id="criterio_buscar">
                                            <div class="input-group-append hide" id="cancelar-busqueda">
                                                <span class="span-cancelar" id="" onclick="cancelar_busqueda();">
                                                    <i class="fa fa-times times-cancelar" style="cursor:pointer;" title="Cancelar"></i>
                                                </span>
                                            </div>
                                        </div>
                                        </div>
                                        <ul class="chatonline style-none chat-normal">
                                        <?php
                                            $conversaciones = $conexion->query("SELECT
                                            C.id_conversacion,
                                            C.tipo_conversacion,
                                        
                                        IF (
                                            C.tipo_conversacion = 'normal',
                                            (
                                                SELECT
                                                    P.fotografia
                                                FROM
                                                    integrantes_conversaciones AS ICO
                                                INNER JOIN usuarios AS U ON ICO.id_usuario = U.id_usuario
                                                INNER JOIN personas AS P ON U.id_persona = P.id_persona
                                                WHERE
                                                    ICO.id_conversacion = C.id_conversacion
                                                AND ICO.id_usuario != $id_usuario_logueado
                                            ),
                                            C.imagen_conversacion
                                        ) AS imagen_conversacion,
                                        
                                        IF (
                                            C.tipo_conversacion = 'normal',
                                            (
                                                SELECT
                                                    ICO.apodo
                                                FROM
                                                    integrantes_conversaciones AS ICO
                                                INNER JOIN usuarios AS U ON ICO.id_usuario = U.id_usuario
                                                INNER JOIN personas AS P ON U.id_persona = P.id_persona
                                                WHERE
                                                    ICO.id_conversacion = C.id_conversacion
                                                AND ICO.id_usuario != $id_usuario_logueado
                                            ),
                                            C.nombre_conversacion
                                        ) AS nombre_conversacion,
                                         (
                                            SELECT
                                                M.mensaje
                                            FROM
                                                mensajes AS M
                                            WHERE
                                                M.id_conversacion = C.id_conversacion AND M.activo = 1
                                            ORDER BY
                                                M.id_mensaje DESC
                                            LIMIT 1
                                        ) AS mensaje,
                                         (
                                            SELECT
                                                DATE(M.fecha_hora)
                                            FROM
                                                mensajes AS M
                                            WHERE
                                                M.id_conversacion = C.id_conversacion
                                            ORDER BY
                                                M.id_mensaje DESC
                                            LIMIT 1
                                        ) AS fecha,
                                         (
                                            SELECT
                                                TIME_FORMAT(
                                                    TIME(M.fecha_hora),
                                                    '%h:%i %p'
                                                )
                                            FROM
                                                mensajes AS M
                                            WHERE
                                                M.id_conversacion = C.id_conversacion
                                            ORDER BY
                                                M.id_mensaje DESC
                                            LIMIT 1
                                        ) AS hora,
                                         (
                                            SELECT
                                                M.id_usuario_remitente
                                            FROM
                                                mensajes AS M
                                            WHERE
                                                M.id_conversacion = C.id_conversacion
                                            ORDER BY
                                                M.id_mensaje DESC
                                            LIMIT 1
                                        ) AS remitente,
                                        (
                                            SELECT
                                                M.tipo_mensaje
                                            FROM
                                                mensajes AS M
                                            WHERE
                                                M.id_conversacion = C.id_conversacion
                                            ORDER BY
                                                M.id_mensaje DESC
                                            LIMIT 1
                                        ) AS tipo_mensaje,
                                        (
	SELECT
		COUNT(M.id_mensaje)
	FROM
		mensajes AS M
	WHERE
		M.id_conversacion = C.id_conversacion
	ORDER BY
		M.id_mensaje DESC
) AS cantidad_mensajes
                                        FROM
                                            conversaciones AS C
                                        INNER JOIN integrantes_conversaciones AS IC ON C.id_conversacion = IC.id_conversacion
                                        WHERE
                                            IC.id_usuario = $id_usuario_logueado
                                        GROUP BY
                                            C.id_conversacion
                                        ORDER BY
                                            fecha DESC,
                                            hora DESC
                                            LIMIT 10");
                                            $n = 0;
                                            while ($row_c = $conversaciones->fetch(PDO::FETCH_ASSOC)) {
                                                $estado = ($n == 0) ? "active":"";
                                                $tipo_conversacion = $row_c["tipo_conversacion"];
                                                $id_conversacion = $row_c["id_conversacion"];
                                                $id_remitente = $row_c["remitente"];
                                                $tipo_mensaje = $row_c["tipo_mensaje"];
                                                $cantidad_mensajes = $row_c["cantidad_mensajes"];
                                                $mensaje = $row_c["mensaje"];
                                                if($tipo_mensaje == "files"){
                                                    $mensaje = "Archivo adjunto";
                                                }
                                                else{

                                                }
                                                $texto_remitente = ($id_remitente == $id_usuario_logueado) ? "Tú: ":"";
                                                if($cantidad_mensajes == 0){

                                                }
                                                else{
                                                    ?>
                                                    <li data-conver="<?php echo $id_conversacion;?>" class="li-conversations" data-type="<?php echo $tipo_conversacion;?>">
                                                        <a href="javascript:ver_conversacion(<?php echo $id_conversacion;?>,'<?php echo $tipo_conversacion;?>');" class="<?php echo $estado;?>" >
                                                        <?php
                                                        if($tipo_conversacion == "normal"){
                                                            ?>
                                                            <span class="dot-online" title="En linea"></span>
                                                            <?php
                                                        }

                                                        ?>
                                                            
                                                            <img src="../<?php echo $row_c["imagen_conversacion"];?>" alt="user-img" class="img-circle"> 
                                                                
                                                                <span><span class="span-conversacion-<?php echo $row_c['id_conversacion'];?>"><?php echo $row_c["nombre_conversacion"];?> </span>
                                                                    <span class="profile-status online pull-right"></span> 
                                                                    <small class="texto_conversacion"><?php echo $texto_remitente.$mensaje;?></small>
                                                                </span>
                                                            </a>
                                                    </li>
                                                    <?php
                                                }
                                                $n++;
                                            }
                                            ?>
                                            
                                        </ul>
                                        <ul class="chatonline style-none chat-buscar hide">
                                            <li class="indicador" style="    background-color: rgba(0, 0, 0, .03);
                                                color: rgba(0, 0, 0, .40);
                                                font-size: 13px;
                                                line-height: 24px;
                                                padding: 0 12px;
                                                position: relative;">
                                                <span>Contactos</span>
                                            </li>
                                            <div class="chat-buscar-contactos">
                                                
                                            </div>
                                            
                                            <li class="indicador" style="    background-color: rgba(0, 0, 0, .03);
                                                color: rgba(0, 0, 0, .40);
                                                font-size: 13px;
                                                line-height: 24px;
                                                padding: 0 12px;
                                                position: relative;">
                                                <span>Conversaciones de grupo</span>
                                            </li>
                                            <li class="p-20"></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- .chat-left-panel -->
                                <!-- .chat-right-panel -->
                                <div class="chat-right-aside">
                                    <div class="chat-main-header bg-primary">
                                        <div class="p-20 b-b">
                                            <h3 class="box-title text-white">
                                            <div class="btn-group" style="float:left;">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <i class="fa fa-cog"></i> Opciones
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a class="dropdown-item" href="#" id="btnCambiarNombre"><i class="fa fa-edit text-info"></i> Cambiar nombre de la conversación</a>
                                                        <a class="dropdown-item" href="#"><i class="fa fa-user text-primary"></i> Agregar integrante</a>
                                                        <a class="dropdown-item" href="#"><i class="fa fa-times text-danger"></i> Eliminar conversacion</a>
                                                        <a class="dropdown-item" href="#"><i class="fa fa-eye-dropper text-success"></i> Cambiar el color</a>
                                                    </div>
                                                </div> 
                                                <span style="margin-left:5px;" class="label-conversacion">Mensajes </span>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="chat-rbox">
                                        <ul class="chat-list p-20" style="min-height:400px;">
                                            
                                        </ul>
                                    </div>
                                    <div class="card-body b-t">
                                        <div class="row row-attachments">
                                            
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-8">
                                                <textarea id="txtMessage" placeholder="Escribe tu mensaje" class="form-control b-0"></textarea>
                                            </div>
                                            <div class="col-4 text-right">
                                            <input class="hide" type="file" name="attachment" multiple id="attachment">
                                                <button type="button" onclick="send_message();" class="btn btn-disabled btn-circle btn-lg btn-enviar" disabled title="Enviar mensaje" data-toggle="tooltip"><i class="fas fa-paper-plane"></i> </button>
                                                <button type="button" class="btn btn-disabled btn-circle btn-lg btn-adjunto"  title="Adjuntar archivos" disabled data-toggle="tooltip"><i class="fas fa-paperclip"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- .chat-right-panel -->
                            </div>
                            <!-- /.chat-row -->
                        </div>
                    </div>
                </div>
                <div id="modal_conver" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title">Nueva conversación</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="usuario" class="control-label">Usuarios: </label>
                                    <select name="integrantes" multiple id="integrantes" class="form-control"></select>
                                </div>
                            </div>
                            <div class="row">
                                            <div class="col-md-12">
                                                <label for="nombre">Nombre de la conversación: </label>
                                                <input type="text" class="text form-control" id="name_new" name="name_new">
                                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="btnCrear" class="btn btn-success" >Crear</button>
                        </div>
                        </div>

                    </div>
                    </div>

                    <!-- modal conversacion_name -->
                    <!-- Modal -->
                    <div id="modal_name_conversacion" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Nombre de la conversación</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="nombre_conver" class="control-label">Nombre de la conversación: </label>
                                                <input type="text" name="nombre_conversacion" id="input_name_conver" class="form-control">
                                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="btnSaveName" class="btn btn-success">Cambiar nombre</button
                        </div>
                        </div>

                    </div>
                    </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php
                include "../template/right-sidebar.php";
                ?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php
            include "../template/footer.php";
            ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?php
    include "../template/footer-js.php";
    ?>
<script>
   /* var div_chat = $(".chat-list");
  div_chat.slimScroll({
        position: 'right'
        , size: "9px"
        , height: '400px'
        , color: '#2b2929',
        start: 'bottom'
     }); */
     modulo_actual = "<?php echo $menu;?>";
</script>   
<script src="funciones.js"></script>
<script src="http://127.0.0.1:8080/socket.io/socket.io.js"></script>
    <script src="../js/socket.js"></script>
    <script>
        modulo_actual = "<?php echo $menu;?>";
        global_date = '<?php echo date("Y-m-d H:i:s");?>';
        conect_socket('<?php print session_id();?>',<?php echo $_SESSION["id_usuario"];?>,'reload');
    </script>


    <script type="text/javascript">
    var id_conversacion_activa = 0;
    var id_usuario_conver = 0;
    var div_buscar = false;
    var integrantes = 0;
    permiso = <?php echo $permiso_acceso;?>;
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");
        
        <?php
                $resultado  =$_GET["resultado"];
                if($resultado == "exito_actualizacion"){
                    ?>
                    Swal.fire({
                        type: 'success',
                        title: 'Exito',
                        text: 'Tu información se ha guardado correctamente.!',
                        timer:3000
                    })
                    <?php
                }
                ?>
    function buscar(){
        $("#lstBuscar").addClass("active");
        $(".col-buscar").removeClass("hide");
        $(".col-normal").addClass("hide");
        $("#criterio").focus();
    }
    $("#criterio_buscar").on('keyup', function (e) {
    if (e.keyCode === 13) {
        buscar_c();
    }
});
    function buscar_c(){
        var valor = $("#criterio_buscar").val();
        if(valor == "" || valor == undefined){
            //no escribio nada
        }
        else{
            $("#cancelar-busqueda").removeClass("hide");
        $(".chat-normal").addClass("hide");
        $(".chat-buscar").removeClass("hide");
            $.ajax({
            url:"buscar_c.php",
            type:"POST",
            dataType:"json",
            data:{'criterio':valor}
        }).done(function(success){
            var c_u = success["cantidad_usuarios"];
            if(c_u != 0){
                $(".chat-buscar-contactos").html("");
                //los voy agregando
                var array_usuarios = success["array_usuarios"];
                for(var i = 0;i<c_u;i++){
                    $id = array_usuarios[i]["id_usuario"];
                    $name = array_usuarios[i]["trabajador"];
                    $id_t = array_usuarios[i]["id_trabajador"];
                    $picture = array_usuarios[i]["fotografia"];
                    var contacto = '<li>'+
                                        '<a href="javascript:ver_conversacion('+$id+',\'na\');" class=""><img src="../'+$picture+'" alt="user-img" class="img-circle"> <span>'+$name+' <small class="text-success">Conectado</small></span></a>'+
                                    '</li>';
                    $(".chat-buscar-contactos").append(contacto);
                }
            }
        }).fail(function(error){
            alert(error);
        });
        }
        
    }
    function ver_conversacion(id,type){
        if(id == id_conversacion_activa){
            //significa que quiero ver la misma, por lo tanto solo mando el foco al de mensaje
            $("#txtMessage").focus();
        }
        else{
            //es una conversacion diferente
            $(".chat-list").html("");
            $.ajax({
            url:"buscar_conversacion.php",
            type:"POST",
            dataType:"json",
            data:{'id_integrante':id,'type':type}
        }).done(function(success){
            $(".btn-enviar").prop("disabled",false);
            $(".btn-adjunto").prop("disabled",false);
            $(".btn-enviar").removeClass("btn-disabled");
            $(".btn-adjunto").removeClass("btn-disabled");
            $(".btn-adjunto").addClass("btn-success");
            $(".btn-enviar").addClass("btn-info");
            $("#criterio_buscar").val("");
            $("#cancelar-busqueda").addClass("hide");
            var resultado = success["resultado"];
            if(resultado == "no_existe"){
                id_conversacion_activa = success["id_conversacion"];
                var nombre = success["apodo"];
                id_usuario_conver = id;
                $(".label-conversacion").html(nombre);
                $("#txtMessage").focus();
            }
            else if(resultado == "existe"){
                id_conversacion_activa = success["id_conversacion"];
                var nombre = success["apodo"];
                id_usuario_conver = success["user_id"];
                $(".label-conversacion").html(nombre);
                $("#txtMessage").focus();
            }
            else if(resultado == "existe_conversacion"){
                if(type == "normal"){
                    //es una conversacion para mostrar
                        var apodo = success["apodo"];
                        var color = success["color"];
                        id_conversacion_activa = success["id_conversacion"];
                        var mensajes = success["mensajes"];
                        id_usuario_conver = success["user_id"];
                        var cantidad = mensajes.length;
                        var id_conversacion = success["id_conversacion"];
                        var array_m = new Array();
                        if(messages_array["conversation_"+id_conversacion] == undefined){
                            //todavia no se crea
                            messages_array["conversation_"+id_conversacion] = new Array();
                        }
                        else{

                        }
                        
                        for(var i = 0;i<cantidad;i++){
                            var msg = mensajes[i];
                            var id_mensaje = msg[0];
                            var mensaje = msg[1];
                            var apodo_m = msg[2];
                            var date = msg[3];
                            var access = msg[4];
                            var classe = msg[5];
                            var foto = msg[8];
                            if(classe == "inverse"){
                                //es un mensaje propio
                                $(".chat-list").prepend('<li class="reverse"> '+
                                                        '<div class="chat-content">'+
                                                            '<h5>'+apodo_m+'</h5>'+
                                                            '<div class="box-out"><div class="box-chat-user bg-primary" title="'+date+'" id="mensaje_'+id_mensaje+'" data-placement="top">'+mensaje+'</div></div>'+
                                                        '</div>'+
                                                        '<div class="chat-img"><img src="../'+foto+'" alt="user" /></div>'+
                                                    '</li>');
                            }
                            else{
                                $(".chat-list").prepend('<li class=""> '+
                                '<div class="chat-img"><img src="../'+foto+'" alt="user" /></div>'+
                                                        '<div class="chat-content">'+
                                                            '<h5>'+apodo_m+'</h5>'+
                                                            '<div class="box-out"><div class="box-chat-user bg-primary" title="'+date+'" id="mensaje_'+id_mensaje+'" data-placement="top">'+mensaje+'</div></div>'+
                                                        '</div>'+
                                                    '</li>');
                            }
                            $("#mensaje_"+id_mensaje).tooltip();
                            messages_array["conversation_"+id_conversacion].push(id_mensaje);
                        }
                        $(".chat-list").prepend("<p class='text-center link-cargar'><a href=\"javascript:cargar_mas("+id_conversacion+");\">Cargar más</a></p>");
                        var scrollTo_int = $(".chat-list").prop('scrollHeight') + 'px';
                        $(".chat-list").slimScroll({
                        scrollTo : scrollTo_int,
                        height: '400px',
                        start: 'bottom',
                        alwaysVisible: true
                    });
                        $(".label-conversacion").html(apodo);
                        $("#txtMessage").focus();
                }
                else{
                    //es una conversacion para mostrar
                    var apodo = success["nombre_conversacion"];
                    var color = success["color"];
                    id_conversacion_activa = success["id_conversacion"];
                    var mensajes = success["mensajes"];
                    id_usuario_conver = success["user_id"];
                    var cantidad = mensajes.length;
                    var id_conversacion = success["id_conversacion"];
                    integrantes = success["integrantes"];
                    var array_m = new Array();
                    if(messages_array["conversation_"+id_conversacion] == undefined){
                        //todavia no se crea
                        messages_array["conversation_"+id_conversacion] = new Array();
                    }
                    else{

                    }
                    
                    for(var i = 0;i<cantidad;i++){
                        var msg = mensajes[i];
                        var id_mensaje = msg[0];
                        var mensaje = msg[1];
                        var apodo_m = msg[2];
                        var date = msg[3];
                        var access = msg[4];
                        var classe = msg[5];
                        var foto = msg[8];
                        if(classe == "inverse"){
                            //es un mensaje propio
                            $(".chat-list").prepend('<li class="reverse"> '+
                                                    '<div class="chat-content">'+
                                                        '<h5>'+apodo_m+'</h5>'+
                                                        '<div class="box-out"><div class="box-chat-user bg-primary" title="'+date+'" id="mensaje_'+id_mensaje+'" data-placement="top">'+mensaje+'</div></div>'+
                                                    '</div>'+
                                                    '<div class="chat-img"><img src="../'+foto+'" alt="user" /></div>'+
                                                '</li>');
                        }
                        else{
                            $(".chat-list").prepend('<li class=""> '+
                            '<div class="chat-img"><img src="../'+foto+'" alt="user" /></div>'+
                                                    '<div class="chat-content">'+
                                                        '<h5>'+apodo_m+'</h5>'+
                                                        '<div class="box-out"><div class="box-chat-user bg-primary" title="'+date+'" id="mensaje_'+id_mensaje+'" data-placement="top">'+mensaje+'</div></div>'+
                                                    '</div>'+
                                                '</li>');
                        }
                        $("#mensaje_"+id_mensaje).tooltip();
                        messages_array["conversation_"+id_conversacion].push(id_mensaje);
                    }
                    $(".chat-list").prepend("<p class='text-center link-cargar'><a href=\"javascript:cargar_mas("+id_conversacion+");\">Cargar más</a></p>");
                    var scrollTo_int = $(".chat-list").prop('scrollHeight') + 'px';
                    $(".chat-list").slimScroll({
                    scrollTo : scrollTo_int,
                    height: '400px',
                    start: 'bottom',
                    alwaysVisible: true
                });
                    $(".label-conversacion").html(apodo);
                    $("#txtMessage").focus();
                }
            }
        }).fail(function(error){
            alert("Error");
        });
        }
        
    }
    function send_message(){
        var cantidad = $(".data-files").length;
        var mensaje = $("#txtMessage").val();
        formDatafiles.append("id_conversacion",id_conversacion_activa);
        formDatafiles.append("user_id",id_usuario_conver);
        formDatafiles.append("count_files",cantidad);
        formDatafiles.append("message",mensaje);
        formDatafiles.append("integrantes",integrantes);
        $.ajax({
            url:"send_message.php",
            type:"POST",
            dataType:"json",
            data:formDatafiles,
            processData: false,  // tell jQuery not to process the data
            contentType: false   // tell jQuery not to set contentType
        }).done(function(success){
            //alert(JSON.stringify(success));
            var resultado = success["resultado"];
            var tipo_conversacion = success["tipo_conversacion"];
            var cantidad = success["messages_count"];
            for(var i = 0;i<cantidad;i++){
                var id_mensaje = success["messages"][i]["id_mensaje"];
                var tipo_mensaje = success["messages"][i]["tipo_mensaje"];
                var nickname = success["messages"][i]["apodo1"];
                var nickname2 = success["messages"][i]["apodo2"];
                var mensaje = success["messages"][i]["mensaje"];
                var fecha_hora = success["messages"][i]["fecha_hora"];
                 $(".chat-list").append('<li class="reverse"> '+
                                                '<div class="chat-content">'+
                                                    '<h5>'+nickname2+'</h5>'+
                                                    '<div class="box-out"><div class="box-chat-user bg-primary" title="'+fecha_hora+'" id="mensaje_'+id_mensaje+'" data-placement="top">'+mensaje+'</div></div>'+
                                                '</div>'+
                                                '<div class="chat-img"><img src="../<?php echo $_SESSION['fotografia'];?>" alt="user" /></div>'+
                                            '</li>');
                                            $("#mensaje_"+id_mensaje).tooltip();

                //agrego el ultimo mnesaje al li del mensaje
                var span_conversacion = $("[data-conver="+id_conversacion_activa+"]").find(".texto_conversacion");
                $(span_conversacion).html("Tú: "+mensaje);
            }
            if(resultado == "exito"){
                //agrego el mensaje al chat
               
            var scrollTo_int = $(".chat-list").prop('scrollHeight') + 'px';
            $(".chat-list").slimScroll({
                scrollTo : scrollTo_int,
                height: '200px',
                start: 'bottom',
                alwaysVisible: true
            });
                $("#txtMessage").val("");
                $("#txtMessage").focus();
                $(".data-files").remove();
                cantidad_files = 0;
                //envio el mensaje por el socket
                var integrantes = success["integrantes"];
                var msg = {
                    type:"message_sended",
                    array_messages:success["messages"],
                    cantidad:cantidad,
                    user_id : id_usuario_conver,
                    conversation : id_conversacion_activa,
                    conversation_type:tipo_conversacion,
                    message_type:tipo_mensaje,
                    nickname:nickname2,
                    nickname2:nickname,
                    user_send:<?php echo $_SESSION["id_usuario"];?>,
                    integrantes:integrantes,
                    nombre_conversacion: success["nombre_conversacion"],
                    nombre_destinatario:success["nombre_destinatario"],
                    nombre_remitente:success["nombre_remitente"],
                    id_remitente : success["id_remitente"],
                    id_destinatario:success["id_destinatario"],
                    foto_remitente :success["foto_remitente"],
                    foto_destinatario:success["foto_destinatario"]
                };

                //convert and send data to server
                send_data(msg);
            }
        }).fail(function(error){
            alert("Error");
        })
        
    }
    $(".times-cancelar").tooltip();
    </script>
   <script>
   $('#txtMessage').keyup(function (e) {
    if (e.keyCode === 13) {
       send_message();
    }
  });

  function cancelar_busqueda(){
      $("#criterio_buscar").val("");
      $("#cancelar-busqueda").addClass("hide");
      $(".chat-normal").removeClass("hide");
        $(".chat-buscar").addClass("hide");
        $(".chat-buscar-contactos").html("");
  }
       function mostrar(){
           $(".notify-mensaje").removeClass("hide");
       }
   </script>
   <script>
       var cantidad = $(".li-conversations").length;
       if(cantidad != 0){
           //si existe al menos una
           var conversacion = $(".li-conversations").eq(0).attr("data-conver");
           var tipo = $(".li-conversations").eq(0).attr("data-type");
           ver_conversacion(conversacion,tipo);
       }
       $("#btnNew").on("click",function(e){
           $.ajax({
               url:"contactos.php",
               type:"POST",
               dataType:"html",
               data:{'id':<?php echo $_SESSION["id_usuario"];?>},
           }).done(function(success){
               $("#integrantes").html(success);
               $("#integrantes").select2({
                   width:'100%'
               });
               $("#modal_conver").modal("show");
           }).fail(function(error){
               alert("Error");
           })
       });
       $("#btnCrear").on("click",function(e){
           var integrantes = $("#integrantes").val();
           var name = $("#name_new").val();
           $.ajax({
               url:"create.php",
               type:"POST",
               dataType:"json",
               data:{'integrantes':integrantes,'name_new':name}
           }).done(function(success){
               var resultado = success["resultado"];
               if(resultado == "exito"){
                   var id = success["id"];
                   var name = success["name"];
                   var type = success["type"];
                   id_conversacion_activa = id;
                   var listas = $(".li-conversations");
                  var cantidad = $(listas).length;
                  for(var i =0 ;i<cantidad;i++){
                    $(listas).eq(i).find("a").removeClass("active");
                  }
                   //significa que es una conversacion nueva
                  $(".chat-normal").prepend('<li data-conver="'+id+'" class="li-conversations">'+
                    '<a href="javascript:ver_conversacion('+id+',"'+type+'");" class="active" >'+
                    '   <span class="dot-online" title="En linea"></span>'+
                    '   <img src="../images/generales/conversation.jpg" alt="user-img" class="img-circle"> '+
                    '       <span> '+name+
                    '           <span class="profile-status online pull-right"></span> '+
                    '           <small class="texto_conversacion"><b><strong>Haz creado la conversación</strong></b></small>'+
                    '       </span>'+
                    '   </a>'+
                    '</li>');
                    $("#modal_conver").modal("hide");
               }
               $(".chat-list").html("");
               ver_conversacion(id,type);
           }).fail(function(error){
               alert("ERror");
           });
       })
    $("#btnCambiarNombre").on("click",function(e){
        var nombre = $(".label-conversacion").html();
        $("#input_name_conver").val(nombre);
        $("#modal_name_conversacion").modal("show");
    });
    $("#btnSaveName").on("click",function(e){
        var nombre = $("#input_name_conver").val();
        $.ajax({
            url:"save_name.php",
            type:"POST",
            dataType:"json",
            data:{'name':nombre,'id_conversacion':id_conversacion_activa},
            beforeSend:function(respuesta){
                $("#btnSaveName").html("<i class='fa fa-spinner fa-spin'></i> Cambiando nombre");
                $("#btnSaveName").prop("disabled",true);
            }
        }).done(function(success){
            var resultado  =success["resultado"];
            if(resultado == "exito"){
                //si se cambio
                var nombre = success["nombre_conversacion"];
                $(".label-conversacion").html(nombre);
                $(".span-conversacion-"+id_conversacion_activa).html(nombre);
                $("#btnSaveName").html("Cambiar nombre");
                $("#btnSaveName").prop("disabled",false);
                $("#modal_name_conversacion").modal("hide");
            }


        }).fail(function(error){
            alert("Error");
        });
    });
    $('#input_name_conver').on('keyup', function(e) {
    if (e.which == 13) {
        $("#btnSaveName").click();
    }
});
   </script>
   
</body>
</html>