<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>
<?php
// *************************************************************************************
// Programa: m_vercvfac.php  
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2013
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

$vfac=$_GET['nfac'];
$resultado=pg_exec("SELECT * FROM stmviena,stmtmpcvfac WHERE factura='$vfac' AND factura!='F0000000' AND stmviena.ccv=stmtmpcvfac.ccv ORDER BY stmtmpcvfac.ccv");
$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center' width='03%'></td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='07%'>C&oacute;digo</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='70%'>Descripci&oacute;n</td>";
//echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>Frecuencia</td></tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vccv=$regtmp[ccv];
    $vdes=$regtmp[descripcion];
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center' width='03%'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='center' width='07%'><small>";
    echo $vccv; 
    echo "</small></td><td align='left' width='70%'><small>";
    echo $vdes;
    //echo "</small></td><td align='left' width='10%'><small>";
    //echo $vfre;
    echo "</small></td></tr>";
} 
echo "</table>";

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
