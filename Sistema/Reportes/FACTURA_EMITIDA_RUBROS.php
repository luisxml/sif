<?php
$Nivel = "../../";
include($Nivel."includes/PHP/funciones.php");
session_start();
header("Content-type: text/html; charset=utf8");
$conector=Conectar(); /* conexion a la base de datos */

require_once 'PHPExcel/PHPExcel.php';  /* libreria para expotar a excel */

/* ------------------------- parametros de la consulta del reporte ------------------------*/

$Localidad=$_GET["puerto"];
$rangofecha = $_GET["RangoFecha"];
$fechas = explode("-",$rangofecha);
$COD_TARFIFA=$_GET["Codigo"];


/* -------------------FIN PARAMETROS ------------------------ */


/* ---------- INICIO DEL OBJETO EXCEL ----------------- */
$objPHPExcel = new PHPExcel();

/*--------- TITULO DEL REPORTE ----------------------------- */
$tituloReporte = "FACTURACION EMITIDA POR RUBROS";

/* ------ ACTIVAR PESTAÑA DE EXCEL ------------ */
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:Z1'); /* --- COMBINAR CELDAS ---- */

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1',  $tituloReporte); /* --- ASIGNAR EL TITULO DEL REPORTE A LA CELDA ---- */



/*--- NOMBRE DE LAS COLUMNAS ----------- */
$titulosColumnas = array('NRO','NOMBRE LOCALIDAD','SERIE','TIPO DOCUMENTO','DOCUMENTO','CONTROL','NOMBRE CLIENTE','RIF CLIENTE','DIRECCION FISCAL','FECHA EMISION','MONEDA','CONDICION PAGO','SUB TOTAL','MONTO GRAVADO','MONTO NOGRAVADO','PORCENTAJE IVA','MONTO IVA','MONTO TOTAL','FECHA ANULACION','DESCRIPCION ESTATUS','DOCUMENTO AFECTADO','LOCALIDAD','VALOR CAMBIO','MONTO TOTAL BASE','TIPO SERVICIO','CODIGO TARIFA', 'MONTO ITEM');
/*--- FIN NOMBRE DE LAS COLUMNAS ------------ */

/* --- ASIGNAR LOS TITULOS DE LAS COLUMNAS  ---- */
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3',  $titulosColumnas[0])
->setCellValue('B3',  $titulosColumnas[1])
->setCellValue('C3',  $titulosColumnas[2])
->setCellValue('D3',  $titulosColumnas[3])
->setCellValue('E3',  $titulosColumnas[4])
->setCellValue('F3',  $titulosColumnas[5])
->setCellValue('G3',  $titulosColumnas[6])
->setCellValue('H3',  $titulosColumnas[7])
->setCellValue('I3',  $titulosColumnas[8])
->setCellValue('J3',  $titulosColumnas[9])
->setCellValue('K3',  $titulosColumnas[10])
->setCellValue('L3',  $titulosColumnas[11])
->setCellValue('M3',  $titulosColumnas[12])
->setCellValue('N3',  $titulosColumnas[13])
->setCellValue('O3',  $titulosColumnas[14])
->setCellValue('P3',  $titulosColumnas[15])
->setCellValue('Q3',  $titulosColumnas[16])
->setCellValue('R3',  $titulosColumnas[17])
->setCellValue('S3',  $titulosColumnas[18])
->setCellValue('T3',  $titulosColumnas[19])
->setCellValue('U3',  $titulosColumnas[20])
->setCellValue('V3',  $titulosColumnas[21])
->setCellValue('W3',  $titulosColumnas[22])
->setCellValue('X3',  $titulosColumnas[23]) 
->setCellValue('Y3',  $titulosColumnas[24])
->setCellValue('Z3',  $titulosColumnas[25])
->setCellValue('AA3',  $titulosColumnas[25]); 

$objPHPExcel->getActiveSheet()->getColumnDimension('A'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('E'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('G'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('H'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('H'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('I'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('J'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('K'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('L'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('M'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('N'.$i)->setAutoSize(false);



/* --- FIN ASIGNAR LOS TITULOS DE LAS COLUMNAS  ---- */

/* -- Estilo del titulo del reporte ---  */
$estiloTituloReporte = array(
    'font' => array(
        'name'      => 'Verdana',
        'bold'      => true,
        'italic'    => false,
        'strike'    => false,
        'size' =>16,
            'color'     => array(
                'rgb' => '000000'
            )
    ),
    'fill' => array(
        'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
        'color'	=> array('argb' => '3399FF')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE                    
        )
    ), 
    'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'          => TRUE
    )
);

/* -- FIN   ---  */

/* -- Estilo del titulo de las columnas  ---  */

$estiloTituloColumnas = array(
    'font' => array(
        'name'      => 'Arial',
        'bold'      => true,
		'size' =>9,                         
        'color'     => array(
            'rgb' => '000000'
        )
    ),
    'fill' 	=> array(
        'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
        'rotation'   => 90,
        'startcolor' => array(
            'rgb' => '3399FF'
        ),
        'endcolor'   => array(
            'argb' => 'bdbdbd'
        )
    )
    
);

/* -- FIN   ---  */

/*
$vSQL = " select * from view where letra = '$letra'  and numeric = $numerico"; 
$vSQL = " select * from view where letra = '".$letra."'  and numeric =".$numerico; 

    /* ---- Consulta SQl ------ */
     $vSQL = "SELECT * FROM [dbo].[FN_RPT_FACTURA_EMITIDA_IP] ($Localidad, '$fechas[0]','$fechas[1]','$COD_TARFIFA')";

    $ResultadoEjecutar=$conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
    $CONEXION=$ResultadoEjecutar["CONEXION"];						
    $ERROR=$ResultadoEjecutar["ERROR"];
    $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
    $resul=$ResultadoEjecutar["RESULTADO"];
    /* Fin */
    $i =4; 
    $j = 1;

    /* Verificar si existe un error en la consulta  */
    if($CONEXION=="SI" and $ERROR=="NO")
    {    
         /* RECORRER LOS RESULTADOS DE LA CONSULTA   */
        while ($registro=odbc_fetch_array($resul))
		{   
            /* SI EXISTE ALGUNA VALIDACION EN LOS REPORTES  */
           
            /* FIN  */

            /* IMPRIMIR LOS VALORES EN LAS CELDAS DEL EXCEL  */
            
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $j)
            ->setCellValue('B'.$i, utf8_encode(odbc_result($resul,'NB_LOCALIDAD')))
            ->setCellValue('C'.$i, utf8_encode(odbc_result($resul,'NB_SERIE')))
            ->setCellValue('D'.$i, utf8_encode(odbc_result($resul,'TIPO_DOCUMENTO')))
            ->setCellValue('E'.$i, utf8_encode(odbc_result($resul,'NRO_DOCUMENTO')))
            ->setCellValue('F'.$i, utf8_encode(odbc_result($resul,'NRO_CONTROL')))
            ->setCellValue('G'.$i, (odbc_result($resul,'NOMBRE_CLIENTE')))
            ->setCellValue('H'.$i, utf8_encode(odbc_result($resul,'RIF_CLIENTE')))
            ->setCellValue('I'.$i, utf8_encode(odbc_result($resul,'DIRECCION_FISCAL')))
            ->setCellValue('J'.$i, FechaNormal(odbc_result($resul,'F_EMISION')))
            ->setCellValue('K'.$i, utf8_encode(odbc_result($resul,'MONEDA_DOCUMENTO')))
            ->setCellValue('L'.$i, utf8_encode(odbc_result($resul,'NB_CONDICION_PAGO')))
            ->setCellValue('M'.$i, utf8_encode(odbc_result($resuRl,'SUB_TOTAL')))
            ->setCellValue('N'.$i, (odbc_result($resul,'MTO_GRAVADO')))
            ->setCellValue('O'.$i, (odbc_result($resul,'MTO_NOGRAVADO')))
            ->setCellValue('P'.$i, utf8_encode(odbc_result($resul,'PORC_IVA')))
            ->setCellValue('Q'.$i, (odbc_result($resul,'MTO_IVA')))
            ->setCellValue('R'.$i, (odbc_result($resul,'MTO_TOTAL')))
            ->setCellValue('S'.$i, FechaNormal(odbc_result($resul,'F_ANULACION')))
            ->setCellValue('T'.$i, utf8_encode(odbc_result($resul,'DS_ESTATUS')))
            ->setCellValue('U'.$i, utf8_encode(odbc_result($resul,'DOC_AFECTADO')))
            ->setCellValue('V'.$i, utf8_encode(odbc_result($resul,'ID_LOCALIDAD')))
            ->setCellValue('W'.$i, utf8_encode(odbc_result($resul,'VALOR_CAMBIO')))
            ->setCellValue('X'.$i, (odbc_result($resul,'MTO_TOTAL_BASE')))
            ->setCellValue('Y'.$i, utf8_encode(odbc_result($resul,'TIPO_SERVICIO')))
            ->setCellValue('Z'.$i, utf8_encode(odbc_result($resul,'COD_TARIFA')))
			->setCellValue('AA'.$i, utf8_encode(odbc_result($resul,'MTO_ITEM')));
           
           $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getNumberFormat()->setFormatCode('#.##00');
			$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getNumberFormat()->setFormatCode('#.##00');
			$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getNumberFormat()->setFormatCode('#.##00');
			$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getNumberFormat()->setFormatCode('#.##00');
			$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getNumberFormat()->setFormatCode('#.##00');
			$objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getNumberFormat()->setFormatCode('#.##00');
			$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getNumberFormat()->setFormatCode('#.##00');
			$objPHPExcel->getActiveSheet()->getStyle('X'.$i)->getNumberFormat()->setFormatCode('#.##00');
			$objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->getNumberFormat()->setFormatCode('#.##00');
			
            $i ++;
            $j ++;
		}        
    }  


    
    /* ESTILO DE LOS DATOS A IMPRIMIR  */
    $estiloInformacion = new PHPExcel_Style();
	
	$estiloInformacion->applyFromArray(
		array(
			'font' => array(
			'name'      => 'Arial',               
			'color'     => array(
				'rgb' => 'bdbdbd'
			)
		),
		'fill' 	=> array(
			'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
			'color'		=> array('argb' => 'bdbdbd')
		),
		'borders' => array(
			'left'     => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN ,
				'color' => array(
					'rgb' => 'ffffff'
				)
			)             
		)
    ));
    /* FIN */

    /* ASIGNACION DE LOS ESTILOS TITULOS DE LOS REPORTE */
    $objPHPExcel->getActiveSheet()->getStyle('A1:AZ1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->getStyle('A3:AZ3')->applyFromArray($estiloTituloColumnas);
    


	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(60);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
    /* AUTO SIZE A LAS COLUMNAS */     


    /* FIN */

    /* TITULO A LA PESTAÑA ACTIVA */ 
    
    $objPHPExcel->getActiveSheet()->setTitle('FACT EMITIDA RUBROS');

    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);
    
    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="FACTURACION_EMITIDA_RUBROS.xlsx"'); // CAMBIAR EL NOMBRE DEL REPORTE 
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();
    ob_start();
    $objWriter->save('php://output');
    exit;

?>