<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../assets/plugins/PHPExcel/Classes/PHPExcel/IOFactory.php";
set_time_limit(600);
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
for ($row = 2; $row <= 1379; $row++){ 
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
    $numero = $sheet->getCell("H$row")->getValue();
    $colonia = $sheet->getCell("I$row")->getValue();
    $ciudad = $sheet->getCell("J$row")->getValue();
    $estado = $sheet->getCell("K$row")->getValue();
    /* $pais = $sheet->getCell("K$row")->getValue(); */
    $pais = "México";
    $curp = $sheet->getCell("M$row")->getValue();
    $rfc = $sheet->getCell("N$row")->getValue();
    $telefono = $sheet->getCell("O$row")->getValue();
    $correo_personal = $sheet->getCell("P$row")->getValue();
    $matricula = $sheet->getCell("R$row")->getValue();
    $correo_escolar = $matricula."@utl.edu.mx";
    $carrera = $sheet->getCell("S$row")->getValue();
    $grupo = $sheet->getCell("T$row")->getValue();
    $tutor = $sheet->getCell("U$row")->getValue();
    $seguro = $sheet->getCell("V$row")->getValue();
    $sede = $sheet->getCell("W$row")->getValue();
    $crear_correo_institucional = $sheet->getCell("X$row")->getValue();
    $sexo = ($sexo == "F") ? "M":"H";
    $fotografia = ($sexo == "H") ? "images/profile/avatarH.jpg":"images/profile/avatarM.jpg";
    /* if($nombre == "" && $pais == "" && $paterno == "" && $materno == "" && $fecha_nacimiento_v == "" && $sexo == "" && $edo_civil == "" && $direccion == "" && $colonia == "" && $ciudad == "" && $estado == "" && $curp == ""){
    break;
    }
    else if($nombre == "" || $pais == "" || $paterno == "" || $materno == "" || $fecha_nacimiento_v == "" || $sexo == "" || $edo_civil == "" || $direccion == "" || $colonia == "" || $ciudad == "" || $estado == "" || $curp == ""){
        $res = array(
            "fila" => $row,
            "resultado" => "vacio",
            "mensaje" => "La fila $fila contiene campos vacios."
        );
        array_push($resultado["resultados"],$res);
        $numero_error++;
    } */
    
        //agrego el docente
        //primero valido que no exista ya el N° de empleado
        /* $buscar_alumno  = $conexion->query("SELECT id_persona FROM personas WHERE curp = '$curp'");
        $existe = $buscar_alumno->rowCount(); */
        /* if($existe != 0){
            $res = array(
                "fila" => $row,
                "resultado" => "existe_curp",
                "mensaje" => "El curp $curp de la fila $row ya existe en el sistema."
            );
            array_push($resultado["resultados"],$res);
            $numero_error++;
        } */
            //valido el N° de empleado
            $validar_numero = $conexion->query("SELECT id_alumno FROM alumnos WHERE matricula = '$matricula'");
            $existe_no = $validar_numero->rowCount();
            if($existe_no != 0){
                $res = array(
                    "fila" => $row,
                    "resultado" => "existe_matricula",
                    "mensaje" => "La matricula $matricula de la fila $row ya existe."
                );
                array_push($resultado["resultados"],$res);
                $numero_error++;
            }
            else{
                //valido si ya existe el correo
                $validar_correo = $conexion->query("SELECT id_alumno FROM alumnos WHERE correo_institucional = '$correo_escolar'");
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
                    $insertar = $conexion->query("INSERT INTO personas(
                        nombre,
                        ap_paterno,
                        ap_materno,
                        fecha_nacimiento,
                        sexo,
                        direccion,
                        colonia,
                        ciudad,
                        estado,
                        pais,
                        edo_civil,
                        fecha_hora,
                        activo,
                        id_usuario,
                        curp,
                        fotografia,
                        rfc,
                        correo_personal,
                        telefono)VALUES(
                            '$nombre',
                            '$paterno',
                            '$materno',
                            '$fecha_nacimiento',
                            '$sexo',
                            '$direccion',
                            '$colonia',
                            '$ciudad',
                            '$estado',
                            '$pais',
                            '$edo_civil',
                            '$fecha_hora',
                            $activo,
                            $id_usuario_logueado,
                            '$curp',
                            '$fotografia',
                            '$rfc',
                            '$correo_personal',
                            '$telefono'
                        )");
                        $id_persona = $conexion->lastInsertId();
                        //agrego el trabajador
                        //busco si ya existe el grupo
                        $buscar_grupo = $conexion->query("SELECT id_grupo FROM grupos WHERE grupo = '$grupo'");
                        if($buscar_grupo->rowCount() == 0){
                            //inserto el grupo
                            $add_grupo = $conexion->query("INSERT INTO grupos(
                                grupo,
                                descripcion,
                                id_periodo,
                                fecha_hora,
                                activo,
                                tipo_grupo,
                                id_sede
                            )VALUES(
                                '$grupo',
                                '$grupo',
                                1,
                                '$fecha_hora',
                                1,
                                'carrera',
                                (SELECT id_sede FROM sedes WHERE sede = '$sede')
                            )");
                            $id_grupo = $conexion->lastInsertId();
                        }
                        else{
                            //extraigo el id
                            $row_grupo = $buscar_grupo->fetch(PDO::FETCH_ASSOC);
                            $id_grupo = $row_grupo["id_grupo"];
                        }
                        
                        $add_alumno  =$conexion->query("INSERT INTO alumnos(
                            id_persona,
                            matricula,
                            id_carrera,
                            id_sede,
                            id_grupo_actual,
                            correo_institucional,
                            tutor,
                            seguro_facultativo,
                            fecha_hora,
                            activo,
                            id_usuario
                        )VALUES(
                            $id_persona,
                            '$matricula',
                            (SELECT id_carrera FROM carreras WHERE carrera = '$carrera'),
                            (SELECT id_sede FROM sedes WHERE sede = '$sede'),
                            $id_grupo,
                            '$correo_escolar',
                            '$tutor',
                            '$seguro',
                            '$fecha_hora',
                            $activo,
                            $id_usuario_logueado  
                        )");
                        $id_alumno = $conexion->lastInsertId();
                        //agrego el alumno al grupo
                        $add_relacion = $conexion->query("INSERT INTO alumnos_grupos(
                            id_grupo,
                            id_alumno,
                            fecha_hora,
                            activo,
                            id_usuario
                        )VALUES(
                            $id_grupo,
                            $id_alumno,
                            '$fecha_hora',
                            $activo,
                            $id_usuario_logueado
                        )");
                        //inserto el usuario
                        $password_enc = md5("123456789");
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
                            '$correo_escolar',
                            '$password_enc',
                            '$password',
                            1,
                            '$fecha_hora',
                            $activo,
                            $id_usuario_logueado
                        )");
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