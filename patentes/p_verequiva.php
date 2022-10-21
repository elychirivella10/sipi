<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>

<?php
// ************************************************************************************* 
// Programa: p_verequiva.php  
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

$vsoli=$_GET['psol'];
$vder =$_GET['pder'];

$resultado=pg_exec("SELECT * FROM stptmpeq WHERE solicitud='$vsoli'");
$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center' width='05%'></td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='40%'>Equivalente</td></tr>";
//echo "    <td bgcolor='#CCCCCC' align='left' width='20%'>Fecha Transacci&oacute;n</td></tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vequiva=$regtmp[equivalente];
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='left'><small>";
    echo $vequiva; 
    //echo "</small></td><td align='left'><small>";
    //echo $vnac; 
    //echo "</small></td><td><small>";
    //echo $vpais; 
    echo "</small></td></tr>";
}
echo "</table>";

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>