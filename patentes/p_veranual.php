<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>
<?php
// *************************************************************************************
// Programa: p_veranual.php  
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creacion Año: 2009 II Semestre 
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

$resultado=pg_exec("SELECT * FROM stpanual,stzderec WHERE stzderec.solicitud='$vsoli' AND solicitud!='0000-000000' AND stzderec.tipo_mp='P' AND stpanual.nro_derecho=stzderec.nro_derecho ORDER BY stpanual.anualidad");
$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center' width='03%'></td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>Anualidad</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='15%'>Fecha Anualidad</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>Planilla</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>Tasa</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>Monto</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>Multa</td></tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vanual=$regtmp[anualidad];
    $vfecha=$regtmp[fecha_anual];
    $vplani=$regtmp[planilla];
    $vtasa =$regtmp[tasa];
    $vmonto=$regtmp[monto];
    $vind  =$regtmp[ind_multa]; 
    $vmulta=$regtmp[multa];
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center' width='03%'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='center' width='10%'><small>";
    echo $vanual; 
    echo "</small></td><td align='left' width='15%'><small>";
    echo $vfecha;
    echo "</small></td><td align='left' width='10%'><small>";
    echo $vplani; 
    echo "</small></td><td align='left' width='10%'><small>";
    echo $vtasa;
    echo "</small></td><td align='left' width='10%'><small>";
    echo $vmonto; 
    echo "</small></td><td align='left' width='10%'><small>";
    echo $vmulta; 
    echo "</small></td></tr>";
} 
echo "</table>";

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
