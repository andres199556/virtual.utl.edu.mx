<?php
include "../funciones/strings.php";
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
try{
    $id_conversacion  =$_POST["id_conversacion"];
    $id_usuario_conversacion = $_POST["user_id"];
    $mensaje = $_POST["message"];
    $fecha_hora = date("Y-m-d H:i:s");
    $activo = 1;
    $resultado = array();
    $cantidad_files = $_POST["count_files"];
    $resultado["messages"] = array();
    //busco el tipo de conversacion
    //busco el apodo de la conversacion
    //busco el tipo de conversacion
    $buscar_tipo = $conexion->query("SELECT tipo_conversacion
        FROM conversaciones
        WHERE id_conversacion = $id_conversacion");
    $row_buscar = $buscar_tipo->fetch(PDO::FETCH_NUM);
    $tipo = $row_buscar[0];
    if($tipo == "normal"){
        $resultado["nombre_conversacion"] = "NA";
        //es una conversacion entre dos personas
        $buscar_apodo = $conexion->query("SELECT IC.apodo,IC.id_usuario,P.fotografia
        FROM integrantes_conversaciones as IC
        INNER JOIN usuarios as U ON IC.id_usuario = U.id_usuario
        INNER JOIN personas as P ON U.id_persona = P.id_persona
        WHERE IC.id_conversacion  =$id_conversacion AND IC.id_usuario = $id_usuario_conversacion");
        $row_apodo = $buscar_apodo->fetch(PDO::FETCH_NUM);
        $apodo_user_mensaje = $row_apodo[0];
        $id_destinatario = $row_apodo[1];
        $fotografia_destinatario = $row_apodo[2];
        $resultado["id_destinatario"] = $id_destinatario;
        $resultado["nombre_destinatario"] = $apodo_user_mensaje;
        $resultado["foto_destinatario"] = $fotografia_destinatario;
        $resultado["nombre_remitente"] = $_SESSION["nombre_persona"];
        $resultado["id_remitente"] = $id_usuario_logueado;
        $resultado["foto_remitente"] = $_SESSION["fotografia"];
        if($cantidad_files == 0){
            $resultado["messages_count"] = 1;
            //trato de enviar el mensaje
            
            if($tipo == "normal"){
                $acceso = $id_usuario_logueado.",".$id_usuario_conversacion;
                //inserto el mensaje
                $enviar = $conexion->query("INSERT INTO mensajes(
                    id_conversacion,
                    id_usuario_remitente,
                    tipo_mensaje,
                    mensaje,
                    fecha_hora,
                    activo,
                    nuevo,
                    acceso_mensaje
                )VALUES(
                    $id_conversacion,
                    $id_usuario_logueado,
                    'texto',
                    '$mensaje',
                    '$fecha_hora',
                    $activo,
                    1,
                    '$acceso'
                )");
                $id_mensaje = $conexion->lastInsertId();
                $newDateTime = date('Y-m-d h:i A', strtotime($fecha_hora));
                $hora = date('h:i A', strtotime($fecha_hora));
                $msg = array(
                    "id_mensaje" => $id_mensaje,
                    "fecha_hora" => $newDateTime,
                    "hora" => $hora,
                    "tipo_conversacion" =>$tipo,
                    "apodo1" => $apodo_user_mensaje,
                    "apodo2" => $_SESSION["nombre_persona"],
                    "tipo_mensaje" => 'texto',
                    "mensaje" => $mensaje,
                    "imagen" => $_SESSION["fotografia"]
                );
                array_push($resultado["messages"],$msg);
                $resultado["resultado"] = "exito";
                $resultado["tipo_conversacion"] = $tipo;
                //regreso el resultado
            }
        }
        else{
            $resultado["messages_count"] = 1;
            $resultado["resultado"] = "exito";
            $resultado["tipo_conversacion"] = $tipo;
            $acceso = $id_usuario_logueado.",".$id_usuario_conversacion;
            if($mensaje != "" || $mensaje != null){
                $resultado["messages_count"] = 2;
                //envio tambien un mensaje
                //agrego el mensaje
                $enviar = $conexion->query("INSERT INTO mensajes(
                    id_conversacion,
                    id_usuario_remitente,
                    tipo_mensaje,
                    mensaje,
                    fecha_hora,
                    activo,
                    nuevo,
                    acceso_mensaje
                )VALUES(
                    $id_conversacion,
                    $id_usuario_logueado,
                    'texto',
                    '$mensaje',
                    '$fecha_hora',
                    $activo,
                    1,
                    '$acceso'
                )");
                $id_mensaje = $conexion->lastInsertId();
                $newDateTime = date('Y-m-d h:i A', strtotime($fecha_hora));
                $hora = date('h:i A', strtotime($fecha_hora));
                $msg = array(
                    "id_mensaje" => $id_mensaje,
                    "fecha_hora" => $newDateTime,
                    "hora" => $hora,
                    "tipo_conversacion" =>$tipo,
                    "apodo1" => $apodo_user_mensaje,
                    "apodo2" => $_SESSION["nombre_persona"],
                    "tipo_mensaje" => 'texto',
                    "mensaje" => $mensaje,
                    "imagen" => $_SESSION["fotografia"]
                );
                array_push($resultado["messages"],$msg);
            }
            $acceso = $id_usuario_logueado.",".$id_usuario_conversacion;
                //inserto el mensaje
                $enviar = $conexion->query("INSERT INTO mensajes(
                    id_conversacion,
                    id_usuario_remitente,
                    tipo_mensaje,
                    mensaje,
                    fecha_hora,
                    activo,
                    nuevo,
                    acceso_mensaje
                )VALUES(
                    $id_conversacion,
                    $id_usuario_logueado,
                    'files',
                    'NA',
                    '$fecha_hora',
                    $activo,
                    1,
                    '$acceso'
                )");
                $id_mensaje = $conexion->lastInsertId();
                $newDateTime = date('Y-m-d h:i A', strtotime($fecha_hora));
                $hora = date('h:i A', strtotime($fecha_hora));
                
                //regreso el resultado
                $links = "";
                foreach($_FILES as $file){
                    $name = $file["name"];
                    $tmp_name = $file["tmp_name"];
                    $type = $file["type"];
                    $size = $file["size"];
                    $file_string = generar_string(30);
                    $extension = end(explode(".",$name));
                    $file_path = "files/messages/$file_string";
                    move_uploaded_file($tmp_name,"../".$file_path);
                    //inserto el acceso al mensaje
                    $agregar_file = $conexion->query("INSERT INTO messages_files(
                        id_conversacion,
                        id_usuario_envia,
                        id_mensaje,
                        name,
                        filepath,
                        filetype,
                        fecha_hora,
                        activo,
                        id_usuario,
                        filesize,
                        filestring,
                        extension
                    )VALUES(
                        $id_conversacion,
                        $id_usuario_logueado,
                        $id_mensaje,
                        '$name',
                        '$file_path',
                        '$type',
                        '$fecha_hora',
                        $activo,
                        $id_usuario_logueado,
                        '$size',
                        '$file_string',
                        '$extension'
                    )");
                    //creo el link
                    $link = "<a href=\"download.php?file=$file_string\">$name</a><br>";
                    $links.=$link;
                }
                $msg = array(
                    "id_mensaje" => $id_mensaje,
                    "fecha_hora" => $newDateTime,
                    "hora" => $hora,
                    "tipo_conversacion" =>$tipo,
                    "apodo1" => $apodo_user_mensaje,
                    "apodo2" => $_SESSION["nombre_persona"],
                    "tipo_mensaje" => 'files',
                    "mensaje" => $links,
                    "imagen" => $_SESSION["fotografia"]
                );
                array_push($resultado["messages"],$msg);
    
                //update links
                $update = $conexion->query("UPDATE mensajes SET mensaje = '$links' WHERE id_mensaje = $id_mensaje");
    
        }
    }
    else{
        //es una conversacion grupal
        $integrantes = $_POST["integrantes"];
        //genero el array de los integrantes
        $array_integrantes = explode(",",$integrantes);
        //busco los datos de la conversacion
        $datos_conversacion = $conexion->query("SELECT nombre_conversacion,color,imagen_conversacion
        FROM conversaciones
        WHERE id_conversacion = $id_conversacion");
        $row_datos_c = $datos_conversacion->fetch(PDO::FETCH_NUM);
        $nombre_conversacion = $row_datos_c[0];
        $color = $row_datos_c[1];
        $imagen = $row_datos_c[2];
        $resultado["imagen_conversacion"] = $imagen;
        $resultado["nombre_conversacion"] = $nombre_conversacion;
        $resultado["tipo_conversacion"] = "grupal";
        $buscar_integrantes = $conexion->query("SELECT
        GROUP_CONCAT(id_usuario) AS integrantes
    FROM
        integrantes_conversaciones
    WHERE
        id_conversacion = $id_conversacion");
        $row_inte = $buscar_integrantes->fetch(PDO::FETCH_ASSOC);
        $integrantes_actuales = $row_inte["integrantes"];
        $resultado["integrantes"] = $integrantes_actuales;
        if($cantidad_files == 0){
            $resultado["messages_count"] = 1;
                //inserto el mensaje
                $enviar = $conexion->query("INSERT INTO mensajes(
                    id_conversacion,
                    id_usuario_remitente,
                    tipo_mensaje,
                    mensaje,
                    fecha_hora,
                    activo,
                    nuevo,
                    acceso_mensaje
                )VALUES(
                    $id_conversacion,
                    $id_usuario_logueado,
                    'texto',
                    '$mensaje',
                    '$fecha_hora',
                    $activo,
                    1,
                    '$integrantes_actuales'
                )");
                $id_mensaje = $conexion->lastInsertId();
                $newDateTime = date('Y-m-d h:i A', strtotime($fecha_hora));
                $hora = date('h:i A', strtotime($fecha_hora));
                $msg = array(
                    "id_mensaje" => $id_mensaje,
                    "fecha_hora" => $newDateTime,
                    "hora" => $hora,
                    "tipo_conversacion" =>$tipo,
                    "apodo2" => $_SESSION["nombre_persona"],
                    "tipo_mensaje" => 'texto',
                    "mensaje" => $mensaje,
                    "nombre_conversacion" => $nombre_conversacion,
                    "color" => $color,
                    "imagen" => $_SESSION["fotografia"]
                );
                array_push($resultado["messages"],$msg);
                $resultado["resultado"] = "exito";
                $resultado["tipo_conversacion"] = $tipo;
                //regreso el resultado
        }
        else{
            //tambien se enviaron archivos
            $resultado["messages_count"] = 1;
            $resultado["resultado"] = "exito";
            $resultado["tipo_conversacion"] = $tipo;
            if($mensaje != "" || $mensaje != null){
                $resultado["messages_count"] = 2;
                //envio tambien un mensaje
                //agrego el mensaje
                $enviar = $conexion->query("INSERT INTO mensajes(
                    id_conversacion,
                    id_usuario_remitente,
                    tipo_mensaje,
                    mensaje,
                    fecha_hora,
                    activo,
                    nuevo,
                    acceso_mensaje
                )VALUES(
                    $id_conversacion,
                    $id_usuario_logueado,
                    'texto',
                    '$mensaje',
                    '$fecha_hora',
                    $activo,
                    1,
                    '$integrantes_actuales'
                )");
                $id_mensaje = $conexion->lastInsertId();
                $newDateTime = date('Y-m-d h:i A', strtotime($fecha_hora));
                $hora = date('h:i A', strtotime($fecha_hora));
                $msg = array(
                    "id_mensaje" => $id_mensaje,
                    "fecha_hora" => $newDateTime,
                    "hora" => $hora,
                    "tipo_conversacion" =>$tipo,
                    "apodo2" => $_SESSION["nombre_persona"],
                    "tipo_mensaje" => 'texto',
                    "mensaje" => $mensaje,
                    "nombre_conversacion" => $nombre_conversacion,
                    "color" => $color,
                    "imagen" => $_SESSION["fotografia"]
                );
                array_push($resultado["messages"],$msg);
            }
                //inserto el mensaje de archivos
                $enviar = $conexion->query("INSERT INTO mensajes(
                    id_conversacion,
                    id_usuario_remitente,
                    tipo_mensaje,
                    mensaje,
                    fecha_hora,
                    activo,
                    nuevo,
                    acceso_mensaje
                )VALUES(
                    $id_conversacion,
                    $id_usuario_logueado,
                    'files',
                    'NA',
                    '$fecha_hora',
                    $activo,
                    1,
                    '$integrantes_actuales'
                )");
                $id_mensaje = $conexion->lastInsertId();
                $newDateTime = date('Y-m-d h:i A', strtotime($fecha_hora));
                $hora = date('h:i A', strtotime($fecha_hora));
                
                //regreso el resultado
                $links = "";
                foreach($_FILES as $file){
                    $name = $file["name"];
                    $tmp_name = $file["tmp_name"];
                    $type = $file["type"];
                    $size = $file["size"];
                    $file_string = generar_string(30);
                    $extension = end(explode(".",$name));
                    $file_path = "files/messages/$file_string";
                    move_uploaded_file($tmp_name,"../".$file_path);
                    //inserto el acceso al mensaje
                    $agregar_file = $conexion->query("INSERT INTO messages_files(
                        id_conversacion,
                        id_usuario_envia,
                        id_mensaje,
                        name,
                        filepath,
                        filetype,
                        fecha_hora,
                        activo,
                        id_usuario,
                        filesize,
                        filestring,
                        extension
                    )VALUES(
                        $id_conversacion,
                        $id_usuario_logueado,
                        $id_mensaje,
                        '$name',
                        '$file_path',
                        '$type',
                        '$fecha_hora',
                        $activo,
                        $id_usuario_logueado,
                        '$size',
                        '$file_string',
                        '$extension'
                    )");
                    //creo el link
                    $link = "<a href=\"download.php?file=$file_string\">$name</a><br>";
                    $links.=$link;
                }
                $msg = array(
                    "id_mensaje" => $id_mensaje,
                    "fecha_hora" => $newDateTime,
                    "hora" => $hora,
                    "tipo_conversacion" =>$tipo,
                    "apodo2" => $_SESSION["nombre_persona"],
                    "tipo_mensaje" => 'texto',
                    "mensaje" => $links,
                    "nombre_conversacion" => $nombre_conversacion,
                    "color" => $color,
                    "imagen" => $_SESSION["fotografia"]
                );
                array_push($resultado["messages"],$msg);
    
                //update links
                $update = $conexion->query("UPDATE mensajes SET mensaje = '$links' WHERE id_mensaje = $id_mensaje");

        }
    }
    
    
    
}
catch(Exception $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
    /* echo $error->getMessage(); */
}
echo json_encode($resultado);
?>