<script language="Javascript"> 

function confirmar() { 
  return confirm('Estas seguro de verificar los Archivos PDF faltantes ?'); }

</script>

<?php
// *************************************************************************************
// Programa: z_enviarcert.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: II Semestre 2010
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/PDF_tablesbfsrweb.php");

?>
<html>
<head>
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head> 

<?php

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables 
$usuario  = $_SESSION['usuario_login'];
$fecha    = fechahoy();
$vopc     = $_GET['vopc'];

$smarty->assign('subtitulo','PASE DE CERTIFICADOS PARA LA FIRMA ELECTRONICA');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


 // Pase al Servidor de Firma Electronica
  $cmd= "scp /apl/certificados/*.pdf www-data@172.16.0.10:/var/www/apl/sifel/documentos/certificado/marcas";
  
      exec($cmd,$salida);
      echo "<table align='center'>"; 	  		
  		echo "<tr><td>";
  		echo " <br><b>El proceso de enviar los certificados al SIFEL ha culminado con Exito</b> 
                       <br> Ya los Certificados se pueden firmar<br><br>";
                echo "</td></tr>";
                echo "<tr><td>";
  		echo " <a href='index1.php'><img src='imagenes/b_volver.png' alt=''> </a><br> ";
  		echo "</td></tr>";	
  		echo "<table/>";
		//Antes de Pasar Limpio los PDFs que ya estan organizados
		$cmd= 'rm -f /apl/certificados/*.pdf';
		exec($cmd,$salida); 	
		  
$smarty->display('z_enviarcert.tpl');
$smarty->display('pie_pag.tpl');
?>
</body>
</html>
