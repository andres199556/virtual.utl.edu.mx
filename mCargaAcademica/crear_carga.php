<?php
include "../conexion/conexion.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


    <title>Document</title>
</head>

<body>
    <br>
    <div class="container">
        <div class="row">
            <form action="" id="frmGenerar">
                <div class="col-md-3 form-group">
                    <label for="docente" class="control-label">Docente: </label>
                    <select name="docente" id="docente" class="form-control">
                        <?php
                            $docentes = $conexion->query("SELECT T.id_trabajador, CONCAT(P.ap_paterno,' ',P.ap_materno,' ',P.nombre) as docente FROM trabajadores as T
                            INNER JOIN personas as P ON T.id_persona = P.id_persona
                            WHERE T.activo = 1 AND P.activo = 1 AND T.id_tipo_trabajador = 2
                            ORDER BY P.ap_paterno ASC");
                            while($row = $docentes->fetch(PDO::FETCH_ASSOC)){
                                ?>
                        <option value="<?php echo $row['id_trabajador'];?>"><?php echo $row['docente'];?></option>
                        <?php
                            }
                            ?>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="docente" class="control-label">Materia: </label>
                    <select name="materia" id="materia" class="form-control">
                        <?php
                                $docentes = $conexion->query("SELECT M.id_materia,CONCAT(C.siglas,' - ',M.materia) as materia
                            FROM materias as M
                            INNER JOIN carreras as C ON M.id_carrera = C.id_carrera
                            WHERE M.activo = 1");
                            while($row = $docentes->fetch(PDO::FETCH_ASSOC)){
                                ?>
                        <option value="<?php echo $row['id_materia'];?>"><?php echo $row['materia'];?></option>
                        <?php
                            }
                            ?>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="docente" class="control-label">Carrera: </label>
                    <select name="carrera" id="materia" class="form-control">
                        <?php
                            $docentes = $conexion->query("SELECT id_carrera,carrera FROM carreras WHERE activo = 1");
                            while($row = $docentes->fetch(PDO::FETCH_ASSOC)){
                                ?>
                        <option value="<?php echo $row['id_carrera'];?>"><?php echo $row['carrera'];?></option>
                        <?php
                            }
                            ?>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="turno" class="control-label">Turno: </label>
                    <select name="turno" id="turno" class="form-control">
                        <option value="M">Matutino</option>
                        <option value="V">Vespertino</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success btn-block">Generar clase</button>
            </form>
        </div>
    </div>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
    $("#frmGenerar").submit(function(e) {
        $.ajax({
            url: "create_room.php",
            type: "POST",
            dataType: "html",
            data: $(this).serialize()
        }).done(function(exito) {
            alert(exito);
            console.log(exito);
        }).fail(function(error) {
            alert(error);
        });
        e.preventDefault();
        return false;
    })
    </script>
</body>

</html>