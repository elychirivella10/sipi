<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>
<?php
include ("../setting.inc.php");
require ("../include.php");
include ("/apl/librerias/library.php");

$sql = new mod_db();
$sql->connection();   
$vsoli=$_GET['psol'];
$vtipo=$_GET['ptip'];
$vdere=$_GET['pder'];

if ($vtipo=='M' or $vtipo=='P') {
$resultado=pg_exec("SELECT titular,nombre,nacionalidad,domicilio FROM temptitu 
                    WHERE solicitud='$vsoli' and solicitud!='0000-000000' and tipo_mp='$vtipo'
                    ORDER BY titular");
} else {
  if ($vtipo=='I' and !empty($vdere)) {
     $resultado=pg_exec("SELECT a.titular,b.nombre,nacionalidad,domicilio 
                         FROM stzottid a, stzsolic b 
                         WHERE a.titular=b.titular and a.nro_derecho=$vdere
                         ORDER BY titular");
  } else {
     $resultado=pg_exec("SELECT titular,nombre,nacionalidad,domicilio FROM temptitu 
                         WHERE solicitud='$vsoli' and solicitud!='0000-0000'
                         ORDER BY titular");
  }
}
$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center'></td>";
echo "    <td bgcolor='#CCCCCC' align='center'>Codigo</td>"; 
echo "    <td bgcolor='#CCCCCC' align='left'>Nombre</td>";
if ($vtipo=='M' or $vtipo=='P' or $vtipo=='I') {
   echo "    <td bgcolor='#CCCCCC' align='left'>Nacionalidad</td>";
   echo "    <td bgcolor='#CCCCCC' align='left'>Domicilio</td>";
}
echo "</tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vnombre=$regtmp[nombre];
    $vtitular=$regtmp[titular];
    $vnacionalidad=$regtmp[nacionalidad];
    $respa=pg_exec("SELECT nombre FROM stzpaisr WHERE pais='$vnacionalidad'"); 
    $regpa=pg_fetch_array($respa); 
    $vdes_nac=$regpa[nombre];
    $vdomicilio=$regtmp[domicilio];
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center'><font color='#0000FF'>";
    echo $cont+1;
    echo "</td><td align='center'>";
    echo $vtitular; 
    echo "</td><td>";
    echo $vnombre; 
    echo "</td>";
    if ($vtipo=='M' or $vtipo=='P' or $vtipo=='I') {
       echo "<td>";
       echo $vnacionalidad.'-'.$vdes_nac; 
       echo "</td><td>";
       echo $vdomicilio; 
       echo "</td>";
    } 
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>
