<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>
<?php
// ************************************************************************************* 
// Programa: z_veragente.php 
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

$vsoli = $_GET['psol'];
$vder  = $_GET['pder'];
$tper  = $_GET['tper'];

if (empty($tper)) {
  $resultado= pg_exec("SELECT tipo_per FROM stztmpage WHERE solicitud='$vsoli' AND tipo_mp='$vder' AND tipo_per!='1'");
  $regper   = pg_fetch_array($resultado); 
  $tper     = $regper[tipo_per]; } 

$resultado=pg_exec("SELECT * FROM stztmpage WHERE solicitud='$vsoli' AND tipo_mp='$vder' AND tipo_per='$tper'");
$filas_found=pg_numrows($resultado);
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center' width='05%'></td>";
if ($tper==1) {
  echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>C&oacute;digo</td>"; }
else { 
  echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>C&eacute;dula</td>"; }
echo "    <td bgcolor='#CCCCCC' align='left' width='35%'>Nombre</td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='45%'>Domicilio</td></tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado);
    $identifica = $regtmp[identificacion]; 
    $vnombre=$regtmp[nombre];
    $vagente=$regtmp[agente];
    $vdomicilio=$regtmp[domicilio];     
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='center'><small>";
    if ($tper==1) { echo $vagente; }
    else { echo $identifica; } 
    echo "</small></td><td align='left'><small>";
    echo $vnombre; 
    echo "</small></td><td><small>";
    echo $vdomicilio; 
    echo "</small></td></tr>";
}
echo "</table>";

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
