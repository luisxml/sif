<?php
	session_start();	
	
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	$SISTEMA_SIGLA=$_SESSION['SISTEMA_SIGLA'];
	
	date_default_timezone_set('America/Caracas');

	$LOGIN=$_SESSION[$SISTEMA_SIGLA.'LOGIN'];
	$RAZON_SOCIAL=$_POST['RAZON_SOCIAL'];
	$DIRECCION=$_POST['DIRECCION'];
	$TLF=$_POST['TLF'];
	$EMAILV=$_POST['EMAILV'];
	$EMAIL=$_POST['EMAIL'];
	$CLAVE=$_POST['CLAVE'];

	$vSQL="EXEC SP_MODIFICAR_USUARIO '$LOGIN', '$RAZON_SOCIAL', '$DIRECCION', '$TLF', '$EMAIL', '$CLAVE';";	

	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

	$CONEXION=$ResultadoEjecutar["CONEXION"];
	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$result=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$RESULTADO=odbc_result($result,"RESULTADO");

		if ($RESULTADO==1 and (trim(strlen($CLAVE)) or $EMAIL!=$EMAILV)) {

			$ArregloEnviarCorreo	=	EnviarCorreo
			(
				$EmisorCorreo			=	'sif@bolipuertos.gob.ve', 
				$EmisorNombre			=	'Bolivariana de Puertos, S.A.', 
				$EmisorCorreoResponder	=	'sif@bolipuertos.gob.ve', 
				$EmisorNombreResponder	=	'Bolivariana de Puertos, S.A.', 
				$DestinatarioCorreo		=	$EMAIL, 
				$DestinatarioNombre		=	$RAZON_SOCIAL, 
				$Asunto					=	'Clave modificada en el SIF exitosamente, '.$RAZON_SOCIAL, 
				$Plantilla				=	'Sistema/Correo/registroExitoso.php?&LOGIN='.$LOGIN.'&RAZON_SOCIAL='.str_replace(' ', '+', $RAZON_SOCIAL).'&CLAVE='.str_replace(' ', '+', $CLAVE),
				$Nivel					=	$Nivel
			);
			
			if(!$ArregloEnviarCorreo["RESULTADO"])
			{				
				$ERROR					=	"SI";
				$Arreglo["MSJ_ERROR"]	=	"Error de envio de correo: ".$ArregloEnviarCorreo["MSJ_ERROR"];
			}
		}
		
		//$Arreglo["SQL"]=$vSQL;
		$Arreglo["RESULTADO"]=$RESULTADO;
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
	}
	else
	{			
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
	}
	
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();
?>