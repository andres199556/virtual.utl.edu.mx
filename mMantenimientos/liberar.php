<?php
include "../conexion/conexion.php";
$t = $_GET["t"];
//busco los datos
$buscar_datos = $conexion->query("SELECT PIM.id_plan_individual,fecha_inicio_mantenimiento,fecha_cierre_mantenimiento,comentarios,comentarios_cierre,PM.titulo_plan,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as responsable,libero
FROM planes_individuales_mantenimientos as PIM
INNER JOIN planes_mantenimientos as PM ON PIM.id_plan_mantenimiento = PM.id_plan_mantenimiento
INNER JOIN usuarios as U ON PIM.id_responsable_mantenimiento = U.id_usuario
INNER JOIN personas as P ON U.id_persona = P.id_persona
WHERE PIM.token = '$t'");
$existe = $buscar_datos->rowCount();
if($existe == 0){
    header("Location:../mInicio/index.php");
}
else{
    $row_datos = $buscar_datos->fetch(PDO::FETCH_ASSOC);
    $id_plan  =$row_datos["id_plan_individual"];
    $libero = $row_datos["libero"];
    
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liberar servicio de mantenimiento</title>
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
    <?php
    if($libero ==1){
        echo "<p class='text-center'>El mantenimiento ya ha sido liberado previamente!.</p>";
    
    }
    else{

    
    ?>
        <form action="save_liberar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id_plan;?>">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Liberar servicio de mantenimiento</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="plan_principal" class="control-label">Plan principal: </label>
                    <input type="text" name="" value="<?php echo $row_datos['titulo_plan'];?>" readonly id="principal"
                        class="form-control">
                </div>
                <div class="col-md-4 form-group">
                    <label for="plan_principal" class="control-label">Fecha de inicio del mantenimiento: </label>
                    <input type="text" name="" value="<?php echo $row_datos['fecha_inicio_mantenimiento'];?>" readonly
                        id="principal" class="form-control">
                </div>
                <div class="col-md-4 form-group">
                    <label for="plan_principal" class="control-label">Fecha de cierre de mantenimiento: </label>
                    <input type="text" name="" value="<?php echo $row_datos['fecha_cierre_mantenimiento'];?>" readonly
                        id="principal" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="plan_principal" class="control-label">Comentarios del mantenimiento: </label>
                    <textarea name="" id="" cols="30" rows="5" style="resize:none" readonly
                        class="form-control"><?php echo $row_datos["comentarios"];?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="plan_principal" class="control-label">Responsable de realizar mantenimiento: </label>
                    <input type="text" name="" value="<?php echo $row_datos['responsable'];?>" readonly id="principal"
                        class="form-control">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Notas realizadas</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Fecha de la nota</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    $notas = $conexion->query("SELECT NM.nota,NM.fecha_hora,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as usuario
                    FROM notas_mantenimientos as NM
                    INNER JOIN usuarios as U ON NM.id_usuario = U.id_usuario
                    INNER JOIN personas as P ON U.id_persona = P.id_persona
                    WHERE NM.id_plan_individual = $id_plan");
                    $n = 0;
                    while($row = $notas->fetch(PDO::FETCH_ASSOC)){
                        $n++;
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $n;?></td>
                                <td class="text-center"><?php echo $row["fecha_hora"];?></td>
                                <td class="text-center"><?php echo $row["usuario"];?></td>
                                <td class="text-center"><?php echo $row["nota"];?></td>
                            </tr>
                            <?php
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Cierre de mantenimiento</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="" class="control-label">Comentarios de cierre:</label>
                    <textarea name="" id="" cols="30" rows="5" style="resize:none;" class="form-control"
                        readonly><?php echo $row_datos["comentarios_cierre"];?></textarea>
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Evidencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $n = 0;
                        $evidencias = $conexion->query("SELECT id_evidencia,name,type,size,ruta,name_random
                        FROM evidencia_mantenimientos as EM
                        WHERE EM.id_plan_individual = $id_plan");
                        while($row = $evidencias->fetch(PDO::FETCH_ASSOC)){
                            $n++;
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $n;?></td>
                                <td class="text-center"><a download
                                        href="descargar.php?e=<?php echo $row['name_random'];?>"><?php echo $row["name"];?></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Liberar servicio</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 form-group">
                    <input type="checkbox" name="liberar" id="liberar" value=1><label for="liberar"
                        class="control-label">Valido los
                        datos y doy fe de que el mantenimiento se ha realizado correctamente.</label>
                </div>
                <div class="col-md-7 form-group">
                    <label for="comentarios" class="control-label">Agregar comentarios: </label>
                    <textarea name="comentarios" style="resize:none;" id="comentarios" cols="30" rows="5"
                        class="form-control"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <button type="submit" class=" btn btn-success btn-block">Guardar cambios y liberar mantenimiento
                        </button:btn>
                </div>
            </div>
        </form>
        <?php
        
        }
        ?>
    </div>
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>