<?php
include "../conexion/conexion.php";
include "../sesion/validar_sesion.php";
include "../assets/plugins/webclientprint/WebClientPrint.php";
$resultado = array();
$id_productos = $_POST["id_productos"];
$id_precios_seleccionados = $_POST["id_precios_seleccionados"];
$valores_precios = $_POST["valores_precios"];
$cantidades = $_POST["valores_cantidades"];
$totales = $_POST["valores_totales"];
$id_cliente = $_POST["id_cliente_seleccionado"];
$cantidad_productos  =$_POST["cantidad_productos"];
$total_global = $_POST["total_global"];
$id_metodo_pago = $_POST["id_metodo_pago"];
$id_usuario = 1;
$fecha_venta = date("Y-m-d");
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$abonado  =$_POST["abonado"];
$cambio = $_POST["restante"];
$id_almacen = 1;
$id_origen_entrada = 1;
$nota = "NA";
try{
//inserto la venta
$agregar_venta = $conexion->query("INSERT INTO ventas(
    id_cliente,
    fecha_venta,
    id_usuario_atendio,
    cantidad_productos,
    subtotal,
    total_venta,
    id_metodo_pago,
    fecha_hora,
    activo,
    id_usuario,
    abonado,
    cambio)VALUES(
        $id_cliente,
        '$fecha_venta',
        $id_usuario,
        $cantidad_productos,
        $total_global,
        $total_global,
        $id_metodo_pago,
        '$fecha_hora',
        $activo,
        $id_usuario,
        $abonado,
        $cambio
    )");
    //extraigo el id de la venta
    $id_venta = $conexion->lastInsertId();
    //actualizo el Nº de venta
    $actualizar = $conexion->query("UPDATE ventas SET no_venta = $id_venta
    WHERE id_venta = $id_venta");
    //recorro los productos
    $n = 0;
    foreach($id_productos as $id_producto){
        //extraigo su valor correspondiente
        $id_precio = $id_precios_seleccionados[$n];
        $precio = $valores_precios[$n];
        $cantidad = $cantidades[$n];
        $total = $totales[$n];
        $agregar_detalle = $conexion->query("INSERT INTO detalle_ventas(
            id_venta,
            id_producto,
            id_precio_venta,
            precio_venta,
            cantidad_productos,
            total,
            fecha_hora,
            activo,
            id_usuario
        )VALUES(
            $id_venta,
            $id_producto,
            $id_precio,
            $precio,
            $cantidad,
            $total,
            '$fecha_hora',
            $activo,
            $id_usuario
        )");
        //lo descuento del inventario
        $actualizar_inventario = $conexion->query("UPDATE existencias_almacenes
        SET stock = (stock - $cantidad),
        fecha_hora = '$fecha_hora',
        id_usuario = $id_usuario
        WHERE
            id_producto = $id_producto AND id_almacen = $id_almacen");
        $n++;
    }
    //agrego la entrada de efectivo
    $agregar_entrada = $conexion->query("INSERT INTO entradas_efectivo(
        id_origen_entrada,
        fecha_hora_entrada,
        efectivo,
        nota,
        fecha_hora,
        activo,
        id_usuario,
        id_venta
    )VALUES(
        $id_origen_entrada,
        '$fecha_hora',
        $total_global,
        '$nota',
        '$fecha_hora',
        $activo,
        $id_usuario,
        $id_venta
    )");
    $resultado["resultado"] = "exito";
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = "Ha ocurrido el siguiente error:".$error->getMessage();
}
echo json_encode($resultado);
?>