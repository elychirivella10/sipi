<script language="javascript">
 function cerrarwindows5(otxt) {
   otxt.value = 1;
   window.opener.frames[0].location.reload();
   window.close();
 }
</script>

<?php
  //include ("../setting.inc.php");
  //require ("../include.php");
  include ("/apl/librerias/library.php");
  include ("../z_includes.php");

?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head>
<body onload="centrarwindows()">   
<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
 $usuario = $_SESSION['usuario_login'];
 $sql = new mod_db();
 $vpod=$_GET['vpod'];
 $vnomtram=$_GET['vtra'];
 $vpod1=substr($vpod,0,4);
 $vpod2=substr($vpod,5,4);

$smarty->display('encabezado1.tpl');
echo "<p align='center'><font class='nota5'><I><b>Poder: $vpod</b></I></font></p>";
if ($vpod=='-' or $vpod1=='0000' or $vpod2=='0000') 
   {echo "<hr>";
   echo "<p align='center'><font class='nota3'><b>Introduzca correctamente el Numero de Poder</b></font></p>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();'></font></p>";
   $smarty->display('pie_pag.tpl');
   exit;
   }

//Verificando conexion
 $sql->connection($usuario);

 $tram = agente_tram_am($nagen,trim($vnomtram),$vpod);
 echo "<p align='center'>$tram</p>";
 echo "<hr>";
 echo "<p align='center'><font color='#0000FF'><input type='image' name='Continuar' value='Salir' onclick='cerrarwindows5(document.formarcas2.tramitante)' 
       src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
 $smarty->display('pie_pag.tpl');
 exit;
?>
</body>
</html>
