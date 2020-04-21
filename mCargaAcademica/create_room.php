<?php
require_once 'google-api2/vendor/autoload.php';
include "../conexion/conexion.php";
$docente = $_POST["docente"];
$materia = $_POST["materia"];
$turno = $_POST["turno"];
$carrera = $_POST["carrera"];
function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Classroom API PHP Quickstart');
        $client->setScopes([Google_Service_Classroom::CLASSROOM_COURSES,Google_Service_Classroom::CLASSROOM_ROSTERS,Google_Service_Classroom::CLASSROOM_COURSEWORK_STUDENTS]);
        $client->setAuthConfig('buenas.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $client->setDeveloperKey("AIzaSyC77r3KKSRECez7tUleOyczyC13jaoXZIs");
    
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
        return $client;
    }
try{
    //correo docente
    $d_docente = $conexion->query("SELECT correo FROM trabajadores WHERE id_trabajador = $docente");
    $row_d = $d_docente->fetch(PDO::FETCH_ASSOC);
    $correo_docente = $row_d["correo"];
    //extraigo el nombre
    $datos_materia = $conexion->query("SELECT materia,M.siglas as siglas_materia,tetramestre,C.siglas as siglas_carrera FROM materias as M INNER JOIN carreras as C ON M.id_carrera = C.id_carrera  WHERE id_materia = $materia");
    $row_materia = $datos_materia->fetch(PDO::FETCH_ASSOC);
    $nombre_materia = $row_materia['materia'];
    $siglas_materia = $row_materia['siglas_materia'];
    $tetramestre  =$row_materia["tetramestre"];
    $siglas_carrera = $row_materia["siglas_carrera"];
    $heading = $siglas_carrera."0".$tetramestre."-A".$turno." - ".$siglas_materia;
    $grupo = $siglas_carrera."0".$tetramestre."A".$turno;
    $add = $conexion->query("INSERT INTO carga_academicas(
        id_carrera,
        id_docente,
        id_materia,
        nombre_carga_academica,
        turno,
        ownerId
    )VALUES(
        $carrera,
        $docente,
        $materia,
        CONCAT((SELECT C.siglas FROM carreras as C WHERE C.id_carrera = $carrera),'0',(SELECT M.tetramestre FROM materias as M WHERE M.id_materia = $materia),'-','A','$turno'),
        '$turno',
        (SELECT T.correo FROM trabajadores as T WHERE T.id_trabajador = $docente)
    )");
    $id_carga = $conexion->lastInsertId();
    //creo la clase en classroom
    $client = getClient();
    $service = new Google_Service_Classroom($client);
    $course = new Google_Service_Classroom_Course(array(
        'name' => $nombre_materia." ($siglas_materia).",
        'section' => $heading,
        'descriptionHeading' => 'Bienvenido a la materia de'.$nombre_materia,
        'description' => 'Presentación',
        'room' => $grupo,
        'ownerId' => $correo_docente,
        'courseState' => 'ACTIVE'
      ));
      $course = $service->courses->create($course);
      printf("Course created: %s (%s)\n", $course->name, $course->id);
      $id_curso = $course->id;
      //actualizo
      $update = $conexion->query("UPDATE carga_academicas SET course_id = $id_curso WHERE id_carga_academica = $id_carga");
}
catch(Exception $error){
    echo $error->getMessage();
}
?>