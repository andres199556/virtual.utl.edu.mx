<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "../template/metas.php";
    ?>
</head>

<body class="fix-sidebar fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php
                include "../template/navbar.php";
                ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php
        include "../template/sidebar.php";
        ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $modulo_actual;?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><?php echo $categoria_actual;?></a></li>
                            <li class="breadcrumb-item active"><?php echo $modulo_actual;?></li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                           <div class="card-header">
                              <span class="" id="1">Control de acciones correctivas</span>
                               <div class="card-actions">
                                        <button onclick="window.location='alta.php';" class="btn btn-success btn-sm">Agregar acción</button>
                                    </div>
                           </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-hover table-striped table-condensed table-bordered color-table info-table"
                                                id="tabla_registros">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Año</th>
                                                        <th class="text-center">Enero</th>
                                                        <th class="text-center">Febrero</th>
                                                        <th class="text-center">Marzo</th>
                                                        <th class="text-center">Abril</th>
                                                        <th class="text-center">Mayo</th>
                                                        <th class="text-center">Junio</th>
                                                        <th class="text-center">Julio</th>
                                                        <th class="text-center">Agosto</th>
                                                        <th class="text-center">Septiembre</th>
                                                        <th class="text-center">Octubre</th>
                                                        <th class="text-center">Noviembre</th>
                                                        <th class="text-center">Diciembre</th>
                                                        <th class="text-center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cuerpo_tabla">
                                                    <?php
                                                if($permiso_acceso == 1){
                                                    //es administrador, puede ver todas
                                                    $condicion = "";
                                                }
                                                else if($permiso_acceso == 2){
                                                    //solo se muestra en las que es verificador o responsable
                                                    $condicion = "
                                                    LEFT JOIN detalle_acciones as DA ON AC.id_accion = DA.id_accion
                                                    WHERE DA.id_responsable = $id_usuario_logueado OR DA.id_verificador = $id_usuario_logueado
                                                    ";
                                                }
                                                $qry = "SELECT DISTINCT
                                                (YEAR(AC.fecha_alta)) AS anio,
                                                (
                                                    SELECT
                                                        COUNT(AC1.id_accion)
                                                    FROM
                                                        acciones AS AC1
                                                    WHERE
                                                        YEAR (AC1.fecha_alta) = anio
                                                    AND MONTH (AC1.fecha_alta) = 1
                                                ) AS Enero,
                                                (
                                                    SELECT
                                                        COUNT(AC2.id_accion)
                                                    FROM
                                                        acciones AS AC2
                                                    WHERE
                                                        YEAR (AC2.fecha_alta) = anio
                                                    AND MONTH (AC2.fecha_alta) = 2
                                                ) AS Febrero,
                                                (
                                                    SELECT
                                                        COUNT(AC3.id_accion)
                                                    FROM
                                                        acciones AS AC3
                                                    WHERE
                                                        YEAR (AC3.fecha_alta) = anio
                                                    AND MONTH (AC3.fecha_alta) = 3
                                                ) AS Marzo,
                                                (
                                                    SELECT
                                                        COUNT(AC4.id_accion)
                                                    FROM
                                                        acciones AS AC4
                                                    WHERE
                                                        YEAR (AC4.fecha_alta) = anio
                                                    AND MONTH (AC4.fecha_alta) = 4
                                                ) AS Abril,
                                                (
                                                    SELECT
                                                        COUNT(AC5.id_accion)
                                                    FROM
                                                        acciones AS AC5
                                                    WHERE
                                                        YEAR (AC5.fecha_alta) = anio
                                                    AND MONTH (AC5.fecha_alta) = 5
                                                ) AS Mayo,
                                                (
                                                    SELECT
                                                        COUNT(AC6.id_accion)
                                                    FROM
                                                        acciones AS AC6
                                                    WHERE
                                                        YEAR (AC6.fecha_alta) = anio
                                                    AND MONTH (AC6.fecha_alta) = 6
                                                ) AS Junio,
                                                (
                                                    SELECT
                                                        COUNT(AC7.id_accion)
                                                    FROM
                                                        acciones AS AC7
                                                    WHERE
                                                        YEAR (AC7.fecha_alta) = anio
                                                    AND MONTH (AC7.fecha_alta) = 7
                                                ) AS Julio,
                                                (
                                                    SELECT
                                                        COUNT(AC8.id_accion)
                                                    FROM
                                                        acciones AS AC8
                                                    WHERE
                                                        YEAR (AC8.fecha_alta) = anio
                                                    AND MONTH (AC8.fecha_alta) = 8
                                                ) AS Agosto,
                                                (
                                                    SELECT
                                                        COUNT(AC9.id_accion)
                                                    FROM
                                                        acciones AS AC9
                                                    WHERE
                                                        YEAR (AC9.fecha_alta) = anio
                                                    AND MONTH (AC9.fecha_alta) = 9
                                                ) AS Septiembre,
                                                (
                                                    SELECT
                                                        COUNT(AC10.id_accion)
                                                    FROM
                                                        acciones AS AC10
                                                    WHERE
                                                        YEAR (AC10.fecha_alta) = anio
                                                    AND MONTH (AC10.fecha_alta) = 10
                                                ) AS Octubre,
                                                (
                                                    SELECT
                                                        COUNT(AC11.id_accion)
                                                    FROM
                                                        acciones AS AC11
                                                    WHERE
                                                        YEAR (AC11.fecha_alta) = anio
                                                    AND MONTH (AC11.fecha_alta) = 11
                                                ) AS Noviembre,
                                                (
                                                    SELECT
                                                        COUNT(AC12.id_accion)
                                                    FROM
                                                        acciones AS AC12
                                                    WHERE
                                                        YEAR (AC12.fecha_alta) = anio
                                                    AND MONTH (AC12.fecha_alta) = 12
                                                ) AS Diciembre,
                                                (
                                                    SELECT
                                                        COUNT(AC13.id_accion)
                                                    FROM
                                                        acciones AS AC13
                                                    WHERE
                                                        YEAR (AC13.fecha_alta) = anio
                                                ) AS total
                                            FROM
                                                acciones AS AC
                                                $condicion
                                            ORDER BY
                                                anio ASC";
                                                $acciones = $conexion->query($qry);
                                                while($row = $acciones->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                    <tr>
                                                        <td class="text-center td-count"><?php echo $row["anio"];?></td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Enero"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Febrero"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Marzo"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Abril"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Mayo"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Junio"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Julio"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Agosto"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Septiembre"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Octubre"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Noviembre"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["Diciembre"];?></span></strong></b>
                                                        </td>
                                                        <td class="text-center td-count"
                                                            data-year="<?php echo $row['anio'];?>"><b><strong><span
                                                                        class='number-td'><?php echo $row["total"];?></span></strong></b>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-hover table-bordered color-table success-table tabla-acciones">
                                                <thead>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Origen</th>
                                                    <th class="text-center">Nº de auditoría o revisión</th>
                                                    <th class="text-center">Dirección</th>
                                                    <th class="text-center">Descripción</th>
                                                    <th class="text-center">Fecha de alta</th>
                                                    <th class="text-center">Días caducada</th>
                                                    <th class="text-center">Estado</th>
                                                    <th class="text-center">Acciones</th>
                                                </thead>
                                                <tbody class="body-acciones">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php
            include "../template/footer.php";
            ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?php
    include "../template/footer-js.php";
    ?>
    <!-- <script type="text/javascript" src="funciones.js"></script> -->
    <script type="text/javascript">
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    $(document).ready(function(e) {
        var celdas = $(".td-count");
        var cantidad = $(celdas).length;
        for (var i = 0; i < cantidad; i++) {
            var celda = $(celdas).eq(i).closest("td");
            var cell_index = celda[0].cellIndex;
            var fila = $(celda).closest("tr");
            var row_index = fila[0].rowIndex;

            var valor_celda = parseInt($(celda).find(".number-td").html());
            var anio = parseInt($(celda).attr("data-year"));
            if (valor_celda != 0 && cell_index != 0) {
                //tiene acciones correctivas y esta fuera de los años
                var link = "<a href='javascript:ver_acciones(" + anio + "," + cell_index + ");'  data-year=" +
                    anio + " data-month=" + cell_index +
                    " class='btn btn-success btn-sm btn-ver-acciones' title='Ver acciones' data-toggle='tooltip'><b><strong>" +
                    valor_celda + "</strong></b></a>";
                $(celda).html(link);
            }

        }
    })

    function ver_acciones(valor1, valor2) {
        $('.tabla-acciones').DataTable().destroy();
        var year = valor1;
        var month = valor2;
        $.ajax({
            url: "acciones.php",
            type: "POST",
            dataType: "html",
            data: {
                'year1': year,
                'month1': month
            }
        }).done(function(success) {
            $(".body-acciones").html(success);
            if ($.fn.dataTable.isDataTable('.tabla-acciones')) {
                //ya tenia asignada una funcion de tabla
                $('.tabla-acciones').DataTable().destroy();
                crear_tabla();
            } else {
                crear_tabla();
            }
        }).fail(function(error) {
            alert("Error");
        });
    }

    function crear_tabla(){
        var table = $('.tabla-acciones').DataTable({
                    "language": {
                        "url": "../assets/plugins/datatables/media/js/Spanish.json"
                    }
                });
                $(".tabla-acciones").removeClass("dataTable");
                $(table.table().header()).addClass('th-header');
    }
    </script>

</body>

</html>