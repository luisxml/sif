<?php
$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	session_start();	

$RIF=$_SESSION[$_SESSION['SISTEMA_SIGLA'].'RIF'];
$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SISTEMA_SIGLA'].'LOGIN'];	
$ID_LOCALIDAD=$_SESSION[$_SESSION['SISTEMA_SIGLA'].'ID_LOCALIDAD'];	
$ID_USER=$_SESSION[$_SESSION['SISTEMA_SIGLA'].'ID_USUARIO'];


$documento = $_POST["documento"];

	$vSQL="EXEC dbo.[SP_PROCESAR_PAGOS_FACTURA] '$documento',$ID_USER";
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{		
		while (odbc_fetch_array($resultPrin))
        {		
			$ID=odbc_result($resultPrin,"ID");
			$MENSAJE=odbc_result($resultPrin,"MENSAJE");
			$AVISO=odbc_result($resultPrin,"AVISO");
			
			$Arreglo["ID"]=$ID;
			$Arreglo["MENSAJE"]=$MENSAJE;
			$Arreglo["AVISO"]=$AVISO;

			$Arreglo["CONEXION"]=$CONEXION;	
			$Arreglo["ERROR"]=$ERROR;
			
		}
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
	}
		
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();


?>