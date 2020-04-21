<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
try{
    include "../funciones/strings.php";
include "../conexion/conexion.php";
    $id_conversacion  =$_POST["id_conversacion"];
    $id_usuario_conversacion = $_POST["user_id"];
    $mensaje = (isset($_POST["mensaje"]) ? $_POST["mensaje"]:"N/A");
    $tipo_mensaje = $_POST["tipo_mensaje"];
    $fecha_hora = date("Y-m-d H:i:s");
    $activo = 1;
    $resultado = array();
    $cantidad_files = $_POST["count_files"];
    $resultado["messages"] = array();
    echo strlen($mensaje);
    //busco el tipo de conversacion
    //busco el apodo de la conversacion
    //busco el tipo de conversacion
    $buscar_tipo = $conexion->query("SELECT tipo_conversacion
        FROM conversaciones
        WHERE id_conversacion = $id_conversacion");
    $row_buscar = $buscar_tipo->fetch(PDO::FETCH_NUM);
    $tipo = $row_buscar[0];
    if($tipo == "normal"){
        //busco los datos del otro intgrante
        $datos_destinatario = $conexion->query("SELECT IC.apodo,IC.id_usuario,P.fotografia
        FROM integrantes_conversaciones as IC
        INNER JOIN usuarios as U ON IC.id_usuario = U.id_usuario
        INNER JOIN personas as P ON U.id_persona = P.id_persona
        WHERE IC.id_conversacion  =$id_conversacion AND IC.id_usuario != $id_usuario_conversacion");
        $row_datos_d = $datos_destinatario->fetch(PDO::FETCH_ASSOC);
        $id_destinatario = $row_datos_d["id_usuario"];
        $resultado["nombre_destinatario"] = $row_datos_d["apodo"];
        $resultado["foto_destinatario"] = $row_datos_d["fotografia"];
        $resultado["id_destinatario"] = $row_datos_d["id_usuario"];
        $resultado["nombre_conversacion"] = "NA";
        //busco los datos del remitente
        $buscar_apodo = $conexion->query("SELECT IC.apodo,IC.id_usuario,P.fotografia
        FROM integrantes_conversaciones as IC
        INNER JOIN usuarios as U ON IC.id_usuario = U.id_usuario
        INNER JOIN personas as P ON U.id_persona = P.id_persona
        WHERE IC.id_conversacion  =$id_conversacion AND IC.id_usuario = $id_usuario_conversacion");
        $row_apodo = $buscar_apodo->fetch(PDO::FETCH_ASSOC);
        $id_remitente = $row_apodo["id_usuario"];
        $resultado["nombre_remitente"] = $row_apodo["apodo"];
        $resultado["id_remitente"] = $row_apodo["id_usuario"];;
        $resultado["foto_remitente"] = $row_apodo["fotografia"];
        $id_usuario_conversacion = $id_destinatario;
        $id_usuario_logueado = $id_remitente;
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
                    '$tipo_mensaje',
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
                    "tipo_mensaje" => $tipo_mensaje,
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
            if(strlen($mensaje) != 0){
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
                    '$tipo_mensaje',
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
                    "tipo_mensaje" => $tipo_mensaje,
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
                    '$tipo_mensaje',
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
                    "tipo_mensaje" => $tipo_mensaje,
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
            if(strlen($mensaje) != 0){
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
                    '$tipo_mensaje',
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
                    "tipo_mensaje" => $tipo_mensaje,
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