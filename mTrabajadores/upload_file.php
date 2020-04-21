<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../assets/plugins/PHPExcel/Classes/PHPExcel/IOFactory.php";
$tmp = $_FILES["archivo"]["tmp_name"];
$resultado = array();
$resultado["resultados"] = array();
$password = "123456789";
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$numero_subidos = 0;
$numero_error = 0;
//  Include PHPExcel_IOFactory


$inputFileName = $tmp;

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
//  Loop through each row of the worksheet in turn
for ($row = 2; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
    $nombre = $sheet->getCell("A$row")->getValue();
    $paterno = $sheet->getCell("B$row")->getValue();
    $materno = $sheet->getCell("C$row")->getValue();
    $fecha_nacimiento_v = $sheet->getCell("D$row")->getValue();
    $array_fecha = explode("/",$fecha_nacimiento_v);
    $fecha_nacimiento = $array_fecha[2]."-".$array_fecha[1]."-".$array_fecha[0];
    $sexo = $sheet->getCell("E$row")->getValue();
    $edo_civil = $sheet->getCell("F$row")->getValue();
    $direccion = $sheet->getCell("G$row")->getValue();
    $colonia = $sheet->getCell("H$row")->getValue();
    $ciudad = $sheet->getCell("I$row")->getValue();
    $estado = $sheet->getCell("J$row")->getValue();
    $pais = $sheet->getCell("K$row")->getValue();
    $curp = $sheet->getCell("L$row")->getValue();
    $correo_personal = $sheet->getCell("M$row")->getValue();
    $correo = $sheet->getCell("N$row")->getValue();
    $no_empleado = $sheet->getCell("O$row")->getValue();
    if($nombre == "" && $pais == "" && $paterno == "" && $materno == "" && $fecha_nacimiento_v == "" && $sexo == "" && $edo_civil == "" && $direccion == "" && $colonia == "" && $ciudad == "" && $estado == "" && $curp == "" && $correo_personal == "" && $no_empleado == ""){
    break;
    }
    else if($nombre == "" || $pais == "" || $paterno == "" || $materno == "" || $fecha_nacimiento_v == "" || $sexo == "" || $edo_civil == "" || $direccion == "" || $colonia == "" || $ciudad == "" || $estado == "" || $curp == "" || $correo_personal == "" || $no_empleado == ""){
        $res = array(
            "fila" => $row,
            "resultado" => "vacio",
            "mensaje" => "La fila $fila contiene campos vacios."
        );
        array_push($resultado["resultados"],$res);
        $numero_error++;
    }
    else{
        //agrego el docente
        //primero valido que no exista ya el N° de empleado
        $buscar_empleado  = $conexion->query("SELECT id_persona FROM personas WHERE curp = '$curp'");
        $existe = $buscar_empleado->rowCount();
        if($existe != 0){
            $res = array(
                "fila" => $row,
                "resultado" => "existe_curp",
                "mensaje" => "El curp $curp de la fila $row ya existe en el sistema."
            );
            array_push($resultado["resultados"],$res);
            $numero_error++;
        }
        else{
            //valido el N° de empleado
            $validar_numero = $conexion->query("SELECT id_trabajador FROM trabajadores WHERE no_empleado = $no_empleado");
            $existe_no = $validar_numero->rowCount();
            if($existe_no != 0){
                $res = array(
                    "fila" => $row,
                    "resultado" => "existe_numero",
                    "mensaje" => "El N° de empleado $no_empleado de la fila $row ya existe."
                );
                array_push($resultado["resultados"],$res);
                $numero_error++;
            }
            else{
                //valido si ya existe el correo
                $validar_correo = $conexion->query("SELECT id_trabajador FROM trabajadores WHERE correo = '$correo'");
                $existe_correo = $validar_correo->rowCount();
                if($existe_correo != 0){
                    $res = array(
                        "fila" => $row,
                        "resultado" => "existe_correo",
                        "mensaje" => "El correo institucional: $correo de la fila $row ya se encuentra asignado."
                    );
                    array_push($resultado["resultados"],$res);
                    $numero_error++;
                }
                else{
                    //inserto el registro
                    $numero_subidos++;
                    $foto = ($sexo == "H") ? "images/profile/avatarH.jpg":"images/profile/avatarM.jpg";
                    $add_persona = $conexion->query("INSERT INTO personas(
                        nombre,
                        ap_paterno,
                        ap_materno,
                        sexo,
                        fecha_nacimiento,
                        direccion,
                        colonia,
                        ciudad,
                        estado,
                        pais,
                        fotografia,
                        fecha_hora,
                        activo,
                        id_usuario,
                        curp,
                        edo_civil
                    )VALUES(
                        '$nombre',
                        '$paterno',
                        '$materno',
                        '$sexo',
                        '$fecha_nacimiento',
                        '$direccion',
                        '$colonia',
                        '$ciudad',
                        '$estado',
                        'México',
                        '$foto',
                        '$fecha_hora',
                        $activo,
                        $id_usuario_logueado,
                        '$curp',
                        'soltero'
                    )");
                    $id_persona = $conexion->lastInsertId();
                    //agrego el trabajador
            $insertar_trabajador = $conexion->query("INSERT INTO trabajadores(
                id_persona,
                no_empleado,
                correo,
                id_departamento,
                id_direccion,
                id_puesto,
                fecha_hora,
                activo,
                id_usuario
            )VALUES(
                $id_persona,
                $no_empleado,
                '$correo',
                4,
                2,
                2,
                '$fecha_hora',
                $activo,
                $id_usuario_logueado
            )");
            $id_trabajador = $conexion->lastInsertId();
            //inserto el usuario
            $password_enc = md5($password);
            $insertar_usuario  =$conexion->query("INSERT INTO usuarios(
                id_persona,
                usuario,
                password,
                password_sin_enc,
                cambiar_contra,
                fecha_hora,
                activo,
                id_usuario_alta
            )VALUES(
                $id_persona,
                '$correo',
                '$password_enc',
                '$password',
                1,
                '$fecha_hora',
                $activo,
                $id_usuario_logueado
            )");
                }
            }
        }
    }
    //  Insert row data array into your database of choice here
}
$resultado["resultado"] = "exito_subir";
$resultado["subidos"] = $numero_subidos;
$resultado["errores"] = $numero_error;
$resultado["mensaje"] = "Se ha generado un archivo txt con los detalles de la subida.";
$log_file = fopen("../files/logs/upload_file_".date("Y m d H i s").".txt", "w");
$resultado["link"] = "../files/logs/upload_file_".date("Y m d H i s").".txt";
/* file_put_contents($log_file, $_POST['comment'].PHP_EOL, FILE_APPEND); */
fwrite($log_file, "Numero de filas correctas: $numero_subidos\n");
fwrite($log_file, "Numero de filas con errores: $numero_error\n");
fwrite($log_file, "-------logs-----------------------\n\n\n");
foreach($resultado["resultados"] as $fila){
    fwrite($log_file, "fila: ".$fila['fila']."; resultado: ".$fila['resultado']."; mensaje: ".$fila['mensaje']."\n");
    fwrite($log_file, "------------------------------\n\n");
}
fclose($log_file);
echo json_encode($resultado,true);
?>