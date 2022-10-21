<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>
<?php
// *************************************************************************************
// Programa: z_vertitular.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado Año 2009 I Semestre 
// *************************************************************************************

include ("../setting.inc.php");
require ("../include.php");
include ("/apl/librerias/library.php");

$sql = new mod_db();
$sql->connection();   
$vsoli=$_GET['psol'];
$vder =$_GET['pder'];

$resultado=pg_exec("SELECT * FROM stztmptit WHERE solicitud='$vsoli' and solicitud!='0000-000000' AND tipo_mp='M'");
$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center' width='05%'></td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>C&oacute;digo</td>"; 
echo "    <td bgcolor='#CCCCCC' align='left' width='35%'>Nombre</td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='45%'>Domicilio</td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='05%'>Nac</td></tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vnombre=$regtmp[nombre];
    $vtitular=$regtmp[titular];
    $vpais=$regtmp[nacionalidad];
    $vdomicilio=$regtmp[domicilio];     
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='center'><small>";
    echo $vtitular; 
    echo "</small></td><td align='left'><small>";
    echo $vnombre; 
    echo "</small></td><td><small>";
    echo $vdomicilio; 
    echo "</small></td><td><small>";
    echo $vpais; 
    echo "</small></td></tr>";
}
echo "</table>";
//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
