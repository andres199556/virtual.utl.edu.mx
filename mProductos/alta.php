<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
//include "../sesion/validar_sesion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    include "../template/metas.php";
    ?>
    <style>
        .btn-toggle{
            color:#fff;
            font-weight:bold;
            font-size:20px;
        }
        .span-right{
            position: absolute;
            top: 54%;
            right: 15px;
            margin-top: -7px;
        }
        .span-soporte{
            position: absolute;
            top: 61%;
            right: 15px;
            margin-top: -7px;
        }
        .span-puesto{
            position: absolute;
            top: 67%;
            right: 15px;
            margin-top: -7px;
        }
    </style>
    <link rel="stylesheet" href="../material/css/icons/font-awesome2/css/fontawesome.css">
    <link rel="stylesheet" href="../material/css/icons/font-awesome2/css/all.css">
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $categoria_actual;?></a></li>
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
                
                <form action="guardar.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Detalle</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Precios</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#existencias" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Existencias</span></a> </li>
                                    </ul>
                                    <div class="tab-content tabcontent-border">
                                        <div class="tab-pane active show container" id="home" role="tabpanel">
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="imagen" class="control-label">Imagen: </label>
                                                    <input type="file" name="imagen" id="imagen">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="tipo_producto" class="control-label">Tipo de producto: </label>
                                                    <select name="id_tipo_producto" id="id_tipo_producto" class="form-control">
                                                        <?php
                                                        $tipos = $conexion->query("SELECT id_tipo_producto,tipo_producto
                                                        FROM tipo_productos
                                                        WHERE activo = 1");
                                                        while($row_tipos = $tipos->fetch(PDO::FETCH_NUM)){
                                                            ?>
                                                            <option value="<?php echo $row_tipos[0];?>"><?php echo $row_tipos[1];?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="codigo" class="control-label">Código: </label>
                                                    <input type="text" name="codigo" id="codigo" class="form-control" required="required">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="titulo">Título:</label>
                                                    <input type="text" name="titulo" id="titulo" class="form-control" required="required">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                        <label for="sku" class="control-label">SKU:</label>
                                                        <input type="text" name="sku" id="sku" class="form-control" required="required">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 form-group">
                                                    <label for="moneda" class="control-label">Moneda: </label>
                                                    <select name="moneda" id="moneda" class="form-control">
                                                    <?php
                                                        $monedas = $conexion->query("SELECT id_moneda,moneda
                                                        FROM monedas
                                                        WHERE activo = 1");
                                                        while($row_monedas = $monedas->fetch(PDO::FETCH_NUM)){
                                                            ?>
                                                            <option value="<?php echo $row_monedas[0];?>"><?php echo $row_monedas[1];?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label for="iva" class="control-label">IVA:</label>
                                                    <select name="iva" id="iva" class="form-control">
                                                        <option value="0">0%</option>
                                                        <option value="16">16%</option>
                                                        <option value="exento">Exento</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label for="unidad_medida" class="control-label">Unidad de medida: </label>
                                                    <select name="unidad_medida" id="unidad_medida" class="form-control">
                                                        <?php
                                                        $combo = $conexion->query("SELECT id_unidad_medida,unidad_medida
                                                        FROM unidades_medida
                                                        WHERE activo = 1");
                                                        while($row_combo = $combo->fetch(PDO::FETCH_NUM)){
                                                            ?>
                                                            <option value="<?php echo $row_combo[0];?>"><?php echo $row_combo[1];?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label for="costo_inicial" class="control-label">Costo inicial:</label>
                                                    <input type="number" min=0 name="costo_inicial" id="costo_inicial" class="form-control" required="required">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="clave_cfdi" class="control-label">Clave CFDI:</label>
                                                    <select name="clave_cfdi" id="clave_cfdi" class="form-control">

                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="unidad_cfdi" class="control-label">Unidad CFDI:</label>
                                                    <select name="unidad_cfdi" id="unidad_cfdi" class="form-control">

                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="tipo_producto" class="control-label">Tipo de uso:</label>
                                                    <select name="tipo_producto" id="tipo_producto" class="form-control">
                                                        <option value="producto_terminado">Producto terminado</option>
                                                        <option value="materia_prima">Materia prima</option>
                                                        <option value="ambos">Producto terminado y materia prima</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="descripcion" class="control-label">Descripción: </label>
                                                    <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="tab-pane p-20" id="profile" role="tabpanel">
                                        <div class="row">
                                                        <div class="col-md-12">
                                                            <button class="btn btn-info" type="button" onclick="agregar_precio();"><i class="fa fa-plus"></i> Agregar precio</button>
                                                        </div>
                                        </div>
                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover table-bordered table-striped table-condensed color-table success-table">
                                                                        <thead>
                                                                            <tr>
                                                                                
                                                                                <th class="text-center">Título del precio</th>
                                                                                <th class="text-center">Precio</th>
                                                                                <th class="text-center">Eliminar</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="cuerpo_precios">
                                                                            <th class="text-center"><input type="text" name="nombre_precios[]" id="" value="Precio general" class="form-control"></th>
                                                                            <th class="text-center"><input type="number" name="precios[]" step="any" id="" min=0 value="0.00" class="form-control"></th>
                                                                            <td class="text-center"><button class="btn btn-danger btn-sm" title="Eliminar" data-toggle="tooltip"><i class="fa fa-times"></i></button></td>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                        </div>
                                        <div class="tab-pane p-20" id="existencias" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-condensed table-hover color-table info-table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Almacen</th>
                                                                    <th class="text-center">Sucursal</th>
                                                                    <th class="text-center">Dirección</th>
                                                                    <th class="text-center">Mínimo</th>
                                                                    <th class="text-center">Máximo</th>
                                                                    <th class="text-center">Inventario inicial</th>
                                                                    <th class="text-center">Ubicación</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                //busco los almacenes
                                                                $almacenes = $conexion->query("SELECT A.id_almacen,A.nombre_almacen,S.nombre_sucursal,S.direccion
                                                                FROM almacenes as A
                                                                INNER JOIN sucursales as S ON A.id_sucursal = S.id_sucursal
                                                                WHERE A.activo = 1 AND S.activo = 1");
                                                                while($row_almacenes = $almacenes->fetch(PDO::FETCH_NUM)){
                                                                    $id_almacen = $row_almacenes[0];
                                                                    $almacen = $row_almacenes[1];
                                                                    $sucursal = $row_almacenes[2];
                                                                    $direccion = $row_almacenes[3];
                                                                    ?>
                                                                    <th class="text-center"><?php echo $almacen;?><input type="hidden" name="almacenes[]" value="<?php echo $id_almacen;?>"></th>
                                                                    <th class="text-center"><?php echo $sucursal;?></th>
                                                                    <th class="text-center"><?php echo $direccion;?></th>
                                                                    <th class="text-center"><input type="number" name="minimos[]" id="minimo" class="form-control" value=0></th>
                                                                    <th class="text-center"><input type="number" name="maximos[]" id="minimo" class="form-control" value=0></th>
                                                                    <th class="text-center"><input type="number" name="inventario_inicial[]" id="minimo" class="form-control" value=0></th>
                                                                    <th class="text-center"><input type="text" name="ubicaciones[]" id="minimo" class="form-control"></th>
                                                                    <?php
                                                                }
                                                                ?>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-8">
                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php" class="btn btn-danger btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success btn-block">Agregar producto</button>                             
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php
                include "../template/right-sidebar.php";
                ?>
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
    <script type="text/javascript">
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");
        $("#clave_cfdi").select2({
            language:"es",
            placeholder:"Selecciona la clave CFDI",
            ajax: {
                url: 'buscar_claves.php',
                dataType: 'json',
                type:"POST",
                data: function (params) {
                    return {
                        criterio:params.term
                    };
                },
                processResults:function(response){
                    return{
                        results: $.map(response, function (item) {
                            return {
                                text: item.clave_cfdi+" - " +item.descripcion,
                                id: item.clave_cfdi
                            }
                        })
                    };
                },
                cache:true
            }
        });
        $("#unidad_cfdi").select2({
            language:"es",
            placeholder:"Selecciona la unidad CFDI",
            ajax: {
                url: 'buscar_unidades.php',
                dataType: 'json',
                type:"POST",
                data: function (params) {
                    return {
                        criterio:params.term
                    };
                },
                processResults:function(response){
                    return{
                        results: $.map(response, function (item) {
                            return {
                                text: item.unidad_cfdi+" - " +item.descripcion,
                                id: item.unidad_cfdi
                            }
                        })
                    };
                },
                cache:true
            }
        });
        <?php
                $resultado  =$_GET["resultado"];
                if($resultado == "exito_actualizacion"){
                    ?>
                    Swal.fire({
                        type: 'success',
                        title: 'Exito',
                        text: 'Tu información se ha guardado correctamente.!',
                        timer:3000
                    })
                    <?php
                }
                ?>
             
    </script>
    <script src="funciones.js"></script>
</body>
</html>