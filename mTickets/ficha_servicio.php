<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
//valido que recibo el codigo
if(!isset($_GET["servicio"])){
    header("Location:index.php");
}
else{
    $codigo = $_GET["servicio"];
    if($codigo == "" || $codigo == null){
        header("Location:index.php");
    }
    else{
        //busco si existe el servicio
        $buscar = $conexion->prepare("SELECT
	id_servicio,
	TS.tipo_servicio,
	fecha_apertura,
	hora_apertura,
	fecha_cierre,
	hora_cierre,
	acciones_realizadas,
	titulo_servicio,
	CONCAT(
		P1.nombre,
		' ',
		P1.ap_paterno,
		' ',
		P1.ap_materno
	) AS usuario_solicitante,
	CONCAT(
		P2.nombre,
		' ',
		P2.ap_paterno,
		' ',
		P2.ap_materno
	) AS usuario_responsable,
    titulo_servicio,
    S.descripcion,
    DE.departamento
FROM
	servicios AS S
INNER JOIN tipo_servicios AS TS ON S.id_tipo_servicio = TS.id_tipo_servicio #hago el inner join para el usuario solicitante
INNER JOIN usuarios AS U1 ON S.id_usuario_solicitante = U1.id_usuario
INNER JOIN personas AS P1 ON U1.id_persona = P1.id_persona #inner join para el responsable
INNER JOIN trabajadores as T ON P1.id_persona = T.id_persona
INNER JOIN departamentos as DE ON T.id_departamento = DE.id_departamento
INNER JOIN usuarios AS U2 ON S.id_usuario_responsable = U2.id_usuario
INNER JOIN personas AS P2 ON U2.id_persona = P2.id_persona
WHERE
	codigo_servicio = '$codigo'
AND S.estado_servicio = 3");
        $buscar->execute();
        $filas = $buscar->rowCount();
        if($filas != 1){
            //no existe
            header("Location:index.php");
        }
        else{
            //extraigo los datos
            $row_servicio = $buscar->fetch(PDO::FETCH_NUM);
            $id_servicio = $row_servicio[0];
            $tipo_servicio = $row_servicio[1];
            $fecha_apertura = $row_servicio[2];
            $hora_apertura = $row_servicio[3];
            $fecha_cierre = $row_servicio[4];
            $hora_cierre = $row_servicio[5];
            $acciones_realizadas = $row_servicio[6];
            $usuario_solicitante = $row_servicio[8];
            $usuario_responsable = $row_servicio[9];
            $titulo_servicio = $row_servicio[10];
            $descripcion_servicio = $row_servicio[11];
            $departamento = $row_servicio[12];
            define(limite_registros_pagina,37);
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		
		/** Include PHPExcel */
		require_once '../assets/plugins/PHPExcel/Classes/PHPExcel/IOFactory.php';
		require_once dirname(__FILE__) . '/../assets/plugins/PHPExcel/Classes/PHPExcel.php';
		
		//especifico la plantilla que voy a utilizar
		$inputFileType = 'Excel5';
		$inputFileName = 'formato/formato.xls';
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);
		$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
        );
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Aarón Andrés Rizo Barrrera")
							 ->setTitle("Ficha de solicitud de servicio")
							 ->setCategory("Reportes");
            		$objPHPExcel->getActiveSheet()->setTitle('Solicitud de Servicio');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5', $departamento);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B6', $usuario_solicitante);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', date("d-m-Y"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8', $fecha_apertura);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', $hora_apertura);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B9', $fecha_cierre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C9', $hora_cierre);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle("B8:C9")->applyFromArray($style);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C11', $tipo_servicio);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C12', $titulo_servicio.' - '.$descripcion_servicio);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C13', $acciones_realizadas);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B18', $usuario_solicitante);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F18', $usuario_responsable);
            	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
            	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);

            $objPHPExcel->setActiveSheetIndex(0);
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Ficha de servicio '.$codigo.'.xls"');
	 header('Cache-Control: max-age=0');
	 header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	 header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	 header ('Cache-Control: cache, must-revalidate');
	 header ('Pragma: public');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $inputFileType);
	$objWriter->save('php://output');
	exit;

		
        }
    }
}
?>