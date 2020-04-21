<?php
include "../conexion/conexion.php";
$id_producto = $_POST["id_producto"];
$codigo = $_POST["codigo"];
$sku = $_POST["sku"];
$titulo = $_POST["titulo"];
$costo_inicial  =$_POST["costo_inicial"];
$moneda = $_POST["moneda"];
$iva = $_POST["iva"];
$id_unidad_medida = $_POST["unidad_medida"];
$clave_cfdi  =$_POST["clave_cfdi"];
$unidad_cfdi = $_POST["unidad_cfdi"];
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
$id_tipo_producto = $_POST["id_tipo_producto"];
try{
    //primero busco que no exista un producto con ese codigo
    $buscar_codigo = $conexion->query("SELECT
	id_producto
FROM
	productos
WHERE
	(
		codigo = '$codigo'
		OR sku = '$sku'
	)
AND id_producto != $id_producto");
    $existe = $buscar_codigo->rowCount();
    
    if($existe != 0){
        //existe el producto
        header("Locarion:editar.php?id=$id_producto&resultado=existe_producto");
    }
    else{
        //agrego el producto
        $actualizar = $conexion->query("UPDATE productos SET
        codigo = '$codigo',
        nombre_producto = '$titulo',
        costo_inicial = $costo_inicial,
        id_moneda = $moneda,
        iva = $iva,
        id_unidad_medida = $id_unidad_medida,
        clave_cfdi = '$clave_cfdi',
        unidad_cfdi = '$unidad_cfdi',
        id_tipo_producto = $id_tipo_producto,
        sku = '$sku',
        fecha_hora = '$fecha_hora',
        id_usuario = $id_usuario,
        descripcion = '$descripcion'
        WHERE id_producto = $id_producto
        ");
        //verifico cuales son los precios del sistema
        $precios_bd = $_POST["precios_bd"];
        $cantidad_precios_bd = count($precios_bd);
        if($cantidad_precios_bd == 0){
            
        }
        else{
            $array_precios = join($precios_bd);
            $precios_base = $conexion->query("SELECT id_precio
            FROM precios_productos
            WHERE id_producto = $id_producto AND id_precio NOT IN($array_precios)");
            while($row_precios_eliminar = $precios_base->fetch(PDO::FETCH_NUM)){
                $id_precio_eliminar = $row_precios_eliminar[0];
                $eliminar = $conexion->query("DELETE
                FROM precios_productos
                WHERE id_precio = $id_precio_eliminar");
            }
            //recorro los que quedaron
            for($i = 0;$i<count($precios_bd);$i++){
                $id_precio_bd = $precios_bd[$i];
                $nombre_precio = $nombres_precios[$i];
                $precio = $precios[$i];
                //actualizo
                $actualizar_precio = $conexion->query("UPDATE precios_productos SET
                nombre_precio = '$nombre_precio',
                precio = $precio,
                fecha_hora = '$fecha_hora'
                WHERE id_precio = $id_precio_bd
                ");
            }
        }
        //if($cantidad_precios_bd == 0)
        //despues, recorro los que quedan
        $cantidad_nombres = count($nombres_precios);
        if($cantidad_nombres == $cantidad_precios_bd){
            //significa que no se agregaron nuevos
        }
        else{
            for($i = $cantidad_precios_bd;$i<$cantidad_nombres;$i++){
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
        }

        //recorro los inventarios
        $datos_existentes_almacenes = $_POST["existencias"];
        $cantidad_existencias = count($datos_existentes_almacenes);
        for($i = 0;$i<$cantidad_existencias;$i++){
            $id_existencia = $datos_existentes_almacenes[$i];
            $id_almacen = $almacenes[$i];
                $minimo = $minimos[$i];
                $maximo = $maximos[$i];
                $stock = $stock_iniciales[$i];
                $ubicacion = $ubicaciones[$i];
                $actualizar_existencia = $conexion->query("UPDATE existencias_almacenes SET
                minimo = $minimo,
                maximo = $maximo,
                stock = $stock,
                ubicacion = '$ubicacion',
                fecha_hora = '$fecha_hora',
                id_usuario = $id_usuario
                WHERE id_existencia = $id_existencia
                ");
        }

        //despues, agrego en caso que existan mas
        $cantidad_almacenes = count($almacenes);
        if($cantidad_almacenes == $cantidad_existencias){
            //no ocupo insertar
        }
        else{
            for($i = $cantidad_existencias;$i<$cantidad_almacenes;$i++){
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
            }
        }
        header("Location:index.php?resultado=exito_actualizar");
    }
}
catch(Exception $error){
    header("Location:index.php?resultado=error_actualizar");
    echo $error->getMessage();
}
?>