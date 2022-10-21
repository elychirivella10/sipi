<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <script language="javascript" src="../include/js/wforms.js"></script>
</head>
<body onload="window.close();">

<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql   = new mod_db();

//Verificacion de Conexion 
$sql->connection();   

$vsol=$_GET['psol'];
$resultado=pg_exec("SELECT * FROM stmtmpnac WHERE solicitud=$vsol");
$filas_found=pg_numrows($resultado);
if ($filas_found>0) {
   $regp = pg_fetch_array($resultado); 
   $vtip=$regp['tipo_marca'];
   $vcla=$regp['clase_int'];
   $vclanac=$regp['clase_nac'];
   echo "<table style='font-size:13' border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>";
   echo "<tr>";
   echo "<td class='izq8-color'><input type='text' name='vvclanac' size='2' value='$vclanac' class='required' readonly></td></tr>";
   echo "</table>"; 
} else {
   echo "<p align='center'><font face='Arial' color='#000000' size='1'><<< <font face='Arial' color='#800000' size='1'>Obligatorio: <font face='Arial' color='#000000' size='1'>Debe ubicar la Clase Nacional previamente de acuerdo a la Clase Internacional >>></font></p>";
}
//Desconexion de la Base de Datos
//$sql->disconnect();

?>
</body>
</html>



