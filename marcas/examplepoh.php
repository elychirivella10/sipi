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

$resultado=pg_exec("SELECT poderhabi,nombre FROM tmppohad WHERE poder='$vsoli' 
                    and poder!='0000-0000' and poder!='-' and poder!=' '");
$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center'></td>";
echo "    <td bgcolor='#CCCCCC' align='center'>Codigo</td>"; 
echo "    <td bgcolor='#CCCCCC' align='left'>Nombre</td></tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vnombre=$regtmp[nombre];
    $vtitular=$regtmp[poderhabi];
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
