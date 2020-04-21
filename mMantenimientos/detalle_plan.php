<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_plan = $_POST["id"];
//buscamos los datos
$datos = $conexion->prepare("SELECT
                                                                id_plan_mantenimiento,
                                                                titulo_plan,
                                                                fecha_inicio,
                                                                fecha_final,
                                                                descripcion
                                                                FROM planes_mantenimientos
                                                                WHERE id_plan_mantenimiento = $id_plan");
$datos->execute();
$row = $datos->fetch(PDO::FETCH_NUM);
?>
<div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label for="">Nombre del plan: </label>
                                                        <input type="text" name="" class="form-control" readonly value="<?php echo $row[1];?>">
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label for="">Fecha de inicio: </label>
                                                        <input type="text" name="" class="form-control" readonly value="<?php echo $row[2];?>">
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label for="">Fecha de cierre: </label>
                                                        <input type="text" name="" class="form-control" readonly value="<?php echo $row[3];?>">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="">Descripción: </label>
                                                        <textarea name="" readonly id="" rows="4" class="form-control"><?php echo $row[4];?></textarea>
                                                    </div>
                                                </div>