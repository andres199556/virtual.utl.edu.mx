<?php
include "../conexion/conexion.php";
$codigo = $_POST["codigo"];
$sku = $_POST["sku"];
$titulo = $_POST["titulo"];
$costo_inicial  =$_POST["costo_inicial"];
$moneda = $_POST["moneda"];
$iva = $_POST["iva"];
$id_unidad_medida = $_POST["unidad_medida"];
$clave_cfdi  =$_POST["clave_cfdi"];
$unidad_cfdi = $_POST["unidad_cfdi"];
$tipo_producto = $_POST["tipo_producto"];
$descripcion = $_POST["descripcion"];
$imagen = $_POST["imagen"];
$almacenes = $_POST["almacenes"];
$minimos = $_POST["minimos"];
$maximos = $_POST["maximos"];
$stock_iniciales = $_POST["inventario_inicial"];
$ubicaciones  =$_POST["ubicaciones"];
$costos_finales  =$_POST["costos_finales"];
$nombres_precios = $_POST["nombre_precios"];
$precios = $_POST["precios"];
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$id_usuario = 1;
$tipo_producto = 1;
$imagen = $_FILES["imagen"];
try{
    //primero busco que no exista un producto con ese codigo
    $buscar_codigo = $conexion->query("SELECT id_producto
    FROM productos
    WHERE codigo = '$codigo' OR sku = '$sku'");
    $existe = $buscar_codigo->rowCount();
    if($existe != 0){
        //existe el producto
    }
    else{
        //agrego el producto
        $insert = $conexion->query("INSERT INTO productos(
            codigo,
            nombre_producto,
            costo_inicial,
            id_moneda,
            iva,
            id_unidad_medida,
            clave_cfdi,
            unidad_cfdi,
            id_tipo_producto,
            sku,
            fecha_hora,
            activo,
            id_usuario,
            descripcion
            )VALUES(
                '$codigo',
                '$titulo',
                $costo_inicial,
                $moneda,
                $iva,
                $id_unidad_medida,
                '$clave_cfdi',
                '$unidad_cfdi',
                $tipo_producto,
                '$sku',
                '$fecha_hora',
                $activo,
                $id_usuario,
                '$descripcion'
            )");
            //extraigo el id del producto insertado
            $id_producto = $conexion->lastInsertId();
            //inserto los precios
            for($i = 0;$i<count($precios);$i++){
                $nombre_precio = $nombres_precios[$i];
                $precio = $precios[$i];
                $agregar_precio = $conexion->query("INSERT INTO precios_productos(
                    id_producto,
                    nombre_precio,
                    precio,
                    fecha_hora,
                    activo
                    )VALUES(
                        $id_producto,
                        '$nombre_precio',
                        $precio,
                        '$fecha_hora',
                        $activo
                    )");

            }
            //inserto los inventarios
            for($i = 0;$i<count($almacenes);$i++){
                $id_almacen = $almacenes[$i];
                $minimo = $minimos[$i];
                $maximo = $maximos[$i];
                $stock = $stock_iniciales[$i];
                $ubicacion = $ubicaciones[$i];
                $agregar_inventario = $conexion->query("INSERT INTO existencias_almacenes(
                    id_producto,
                    id_almacen,
                    minimo,
                    maximo,
                    stock,
                    ubicacion,
                    fecha_hora,
                    activo,
                    id_usuario
                    )VALUES(
                        $id_producto,
                        $id_almacen,
                        $minimo,
                        $maximo,
                        $stock,
                        '$ubicacion',
                        '$fecha_hora',
                        $activo,
                        $id_usuario
                    )");
                    //inserto la imagen
                    $size_imagen = $imagen["size"];
                    if($size_imagen == 0){
                        //no subio imagen, por lo tanto hasrta aqui temrino
                        //header("Location:index.php?resultado=exito_alta");
                        $ruta_imagen = "../images/productos/generico.jpg";
                    }
                    else{
                        $name = $imagen["name"];
                        $tmp_name = $imagen["tmp_name"];
                        $extension = end(explode(".",$name));
                        $ruta_imagen = "../images/productos/$id_producto.$extension";
                        move_uploaded_file($tmp_name,$ruta_imagen);
                    }
                    //actualizo la ruta
                    $update_imagen = $conexion->query("UPDATE productos 
                    SET imagen_producto = '$ruta_imagen'
                    WHERE id_producto = $id_producto
                    ");
                    header("Location:index.php?resultado=exito_alta");
            }
    }
}
catch(Exception $error){
    header("Location:index.php?resultado=error_alta");
}
?>