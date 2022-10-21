<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>

<?php
// ************************************************************************************* 
// Programa: p_vercip.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
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

$resultado=pg_exec("SELECT * FROM stptmpcip WHERE solicitud='$vsoli'");
$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center' width='05%'></td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='40%'>Clasificaci&oacute;n</td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='20%'>Tipo</td></tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vclase=$regtmp[clasificacion]; 
    $vtipo=$regtmp[tipo_clas];
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='left'><small>";
    echo $vclase; 
    echo "</small></td><td align='left'><small>";
    echo $vtipo; 
    echo "</small></td></tr>";
}
echo "</table>";

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>