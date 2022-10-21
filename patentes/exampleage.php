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
$vtipo2=$_GET['ptip2'];

if ($vtipo=='M' or $vtipo=='P') {
$resultado=pg_exec("SELECT agente,nombre FROM tmpagenr WHERE solicitud='$vsoli' and tipo_mp='$vtipo2' order by agente");
} else {
  $resultado=pg_exec("SELECT a.agente,b.nombre FROM stzautod a, stzagenr b, stzderec c WHERE c.solicitud='$vsoli' and c.tipo_mp='$vtipo2' and c.nro_derecho=a.nro_derecho and a.agente=b.agente UNION select a.agente,b.nombre FROM stzderec a, stzagenr b WHERE a.solicitud='$vsoli' and a.tipo_mp='$vtipo2' and a.agente=b.agente order by 1");
}

$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center'></td>";
echo "    <td bgcolor='#CCCCCC' align='center'>Codigo</td>"; 
echo "    <td bgcolor='#CCCCCC' align='left'>Nombre</td></tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vnombre=$regtmp[nombre];
    $vtitular=$regtmp[agente];
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center'><font color='#0000FF'>";
    echo $cont+1;
    echo "</td><td align='center'>";
    echo $vtitular; 
    echo "</td><td>";
    echo $vnombre; 
    echo "</td></tr>";
}
echo "</table>";
?>
</body>
</html>
