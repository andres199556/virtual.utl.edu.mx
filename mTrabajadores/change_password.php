<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$password = md5("123456");
$resultado = array();
try{
    $id = $_POST["id"];
    //busco si existe el trabajador
    $buscar = $conexion->query("SELECT U.id_usuario
    FROM trabajadores as T
    INNER JOIN usuarios as U ON T.id_persona = U.id_persona
    WHERE id_trabajador = $id");
    $existe = $buscar->rowCount();
    if($existe == 0){
        $resultado["resultado"] = "no_existe";
        $resultado["header"] = "Error!.";
        $resultado["mensaje"] = "El usuario no existe.";
    }
    else{
        //actualizo los datos
        $fecha = date("Y-m-d H:i:s");
        $row = $buscar->fetch(PDO::FETCH_NUM);
        $id_usuario = $row[0];
        $update = $conexion->query("UPDATE usuarios
        SET cambiar_contra = 1,
        password = '$password',
        fecha_hora = '$fecha'
        WHERE id_usuario = $id_usuario");
        $resultado["resultado"] = "exito";
        $resultado["header"] = "Exito!.";
        $resultado["mensaje"] = "El usuario tendrá que cambiar su contraseña en su proximo inicio de sesión.";
    }
}
catch(PDOException $Error){
    $resultado["resultado"] = "error";
        $resultado["header"] = "Error.";
        $resultado["mensaje"] = "Ha ocurrido un error, vuelve a intentarlo mas tarde.";
}
echo json_encode($resultado);
?>