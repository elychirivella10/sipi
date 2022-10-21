<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>

<?php
// ************************************************************************************* 
// Programa: m_verautoriza.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2014 BD - Relacional 
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

$vcontrol=$_GET['pcod'];

$resultado=pg_exec("SELECT * FROM stmpceraut WHERE control='$vcontrol'");
$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center' width='05%'>Num</td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='09%'>C&eacute;dula</td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='76%'>Nombre</td></tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vnombre=$regtmp[nombre_aut];
    $vcedula=$regtmp[cedula_aut];
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='left'><small>";
    echo $vcedula;
    echo "</small></td><td align='left'><small>";
    echo $vnombre; 
    echo "</small></td></tr>";
}
echo "</table>";

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
