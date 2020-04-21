<?php
include "../conexion/conexion.php";
require_once '../assets/plugins/PHPExcel/Classes/PHPExcel.php';
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(true);

$objPHPExcel = $objReader->load("trabajadores.xlsx");
$objWorksheet = $objPHPExcel->getActiveSheet();

$highestRow = $objWorksheet->getHighestRow(); 
$highestColumn = $objWorksheet->getHighestColumn(); 

$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn) - 1; 
$direccion = "pendiente";
$colonia = "pendiente";
$ciudad = "pendiente";
$estado = "Nuevo León";
$pais = "México";
$curp = "pendiente";
$puesto = 2;
$foto = "images/profile/avatarH.jpg";
$nacimiento = date("Y-m-d");
$sexo = "H";
$password = md5("123456");
$cambiar_password = 1;
$llenar_informacion = 1;
$activo = 1;
$fecha_hora = date("Y-m-d H:i:s");
$id_usuario = 1;
$edo_civil = "Soltero";
$existe_grupo = false;
for ($row = 3; $row <= $highestRow; $row++) {
  $nombre = $objWorksheet->getCell("A$row")->getValue();
  $paterno = $objWorksheet->getCell("B$row")->getValue();
  $materno = $objWorksheet->getCell("C$row")->getValue();
  $correo = $objWorksheet->getCell("D$row")->getValue();
  $no_empleado = $objWorksheet->getCell("N$row")->getValue();
  $usuario = $objWorksheet->getCell("O$row")->getValue();
  $direccion = $objWorksheet->getCell("S$row")->getValue();
  $departamento = $objWorksheet->getCell("T$row")->getValue();
  $tipo_trabajador = $objWorksheet->getCell("U$row")->getValue();
  $agregar_alumno = $conexion->query("INSERT INTO personas(
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
          fotografia,
          fecha_hora,
          activo,
          id_usuario,
          curp
      )VALUES(
          '$nombre',
          '$paterno',
          '$materno',
          '$nacimiento',
          '$sexo',
          '$direccion',
          '$colonia',
          '$ciudad',
          '$estado',
          '$pais',
          '$edo_civil',
          '$foto',
          '$fecha_hora',
          $activo,
          $id_usuario,
          '$curp'
      )");
      $id_persona = $conexion->lastInsertId();
      //agrego el trabajador
      $insert_docente = $conexion->query("INSERT INTO trabajadores(
          id_persona,
          no_empleado,
          correo,
          fecha_ingreso_trabajo,
          id_departamento,
          id_direccion,
          id_puesto,
          fecha_hora,
          activo,
          id_usuario,
          id_tipo_trabajador
      )VALUES(
          $id_persona,
          $no_empleado,
          '$correo',
          '$fecha_hora',
          $departamento,
          $direccion,
          $puesto,
          '$fecha_hora',
          $activo,
          $id_usuario,
          $tipo_trabajador
      )");
      //agrego el usuario
      $agregar_usuario = $conexion->query("INSERT INTO usuarios(
          id_persona,
          usuario,
          password,
          fecha_hora,
          activo,
          id_usuario_alta,
          password_sin_enc,
          cambiar_contra,
          llenar_informacion
      )VALUES(
          $id_persona,
          '$usuario',
          '$password',
          '$fecha_hora',
          $activo,
          $id_usuario,
          '123456',
          $cambiar_password,
          $llenar_informacion
      )"); 
  echo "Se inserto el docente<br>";
}
?>