<?php
include "../conexion/conexion.php";
require_once '../assets/plugins/PHPExcel/Classes/PHPExcel.php';
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(true);

$objPHPExcel = $objReader->load("alumnos.xlsx");
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
for ($row = 2; $row <= $highestRow; $row++) {
  $nombre = $objWorksheet->getCell("A$row")->getValue();
  $paterno = $objWorksheet->getCell("B$row")->getValue();
  $materno = $objWorksheet->getCell("C$row")->getValue();
  $matricula = $objWorksheet->getCell("M$row")->getValue();
  $grupo = $objWorksheet->getCell("N$row")->getValue();
  $carrera = rtrim($objWorksheet->getCell("O$row")->getValue());
  $correo = $matricula."@utl.edu.mx";
  $usuario = $matricula;
  $buscar_carrera = $conexion->query("SELECT id_carrera
      FROM carreras
      WHERE carrera = '$carrera'");

      $row_carrera = $buscar_carrera->fetch(PDO::FETCH_NUM);
      $id_carrera = $row_carrera[0];
  //primero busco si ya existe el alumno
  $e_a = $conexion->query("SELECT id_alumno
  FROM alumnos
  WHERE matricula =$matricula");
  $existe = $e_a->rowCount();

  if($existe != 0){
      echo "La matricula $matricula ya existe";
  }
  else{
      //lo agrego
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
      //agrego el alumno
      $insert_alumno = $conexion->query("INSERT INTO alumnos(
          id_persona,
          id_carrera,
          matricula,
          fecha_ingreso,
          fecha_hora,
          activo,
          id_usuario,
          correo
      )VALUES(
          $id_persona,
          $id_carrera,
          '$matricula',
          '$fecha_hora',
          '$fecha_hora',
          '$activo',
          '$id_usuario',
          '$correo'
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
  }
  
  
  echo "Se inserto el alumno<br>";
}
?>