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

$resultado=pg_exec("SELECT solicitud,trim(nombre) as titulo,fecha_solic,tipo_derecho,estatus-2000 as estatus FROM stzderec
                    where tipo_mp='P' and poder='$vsoli' and poder!='0000-0000' and poder!='-' and poder!=' '");
$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center'></td>";
echo "    <td bgcolor='#CCCCCC' align='left'>Solicitud</td>";
echo "    <td bgcolor='#CCCCCC' align='left'>Titulo</td>";
echo "    <td bgcolor='#CCCCCC' align='left'>Fecha</td>";
echo "    <td bgcolor='#CCCCCC' align='left'>Tipo</td>";
echo "    <td bgcolor='#CCCCCC' align='left'>Estatus</td></tr>";

for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vsol=$regtmp[solicitud];
    $vnom=$regtmp[titulo];
    $vfec=$regtmp[fecha_solic];
    $vcla=$regtmp[tipo_derecho];
    $vest=$regtmp[estatus];
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center'><font color='#0000FF'>";
    echo $cont+1;
    echo "</td><td align='center'>";
    echo "<a href='../consultapatentes/busca_patentes_n.php??vopc=1&vusuario=7&vnsol=$vsol' target='_blank'>$vsol</a>";
    echo "</td><td>";
    echo $vnom; 
    echo "</td><td>";
    echo $vfec; 
    echo "</td><td>";
    echo $vcla;
    echo "</td><td>";
    echo $vest;
    echo "</td></tr>";
}
echo "</table>";
?>
</body>
</html>
