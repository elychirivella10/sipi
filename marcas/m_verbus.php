<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>
<?php
// *************************************************************************************
// Programa: m_verbus.php  
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2010 I Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

$vfac = $_GET['vfac'];

if ($vfac!='') {
  //Verificacion de Conexion 
  $sql->connection();   

  $ruta = "../imagentemp/";
  //$ruta = $imagen_temp."/";

  $resultado=pg_exec("SELECT * FROM stmtmpbus WHERE nro_factura='$vfac'");
  $filas_found=pg_numrows($resultado); 
  echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
  echo "<tr><td bgcolor='#CCCCCC' align='center' width='03%'></td>";
  echo "    <td bgcolor='#CCCCCC' align='center' width='06%'>C&oacute;digo</td>";
  echo "    <td bgcolor='#CCCCCC' align='center' width='05%'>Tipo</td>";
  echo "    <td bgcolor='#CCCCCC' align='center' width='76%'>Denominación / Signo</td>";
  echo "    <td bgcolor='#CCCCCC' align='center' width='05%'>Clase</td></tr>";
  for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vbus=$regtmp[nro_planilla];
    $vtip=$regtmp[tipo_bus];
    $vden=$regtmp[denominacion];
    $vcla=$regtmp[clase];

    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center' width='03%'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='center' width='06%'><small>";
    echo $vbus; 
    echo "</small></td><td align='left' width='05%'><small>";
    echo $vtip;
    echo "</small></td><td align='left' width='76%'><small>";
    if ($vtip=="F") { echo $vden; }
    if ($vtip=="G") {
      $nameimagen = $ruta.$vden;
      echo "<a href='$nameimagen' target='_blank'><img border='1' src='$nameimagen' width='80' height='80'></a>";
      echo "  Archivo=$nameimagen  "; }
//      echo "  Archivo=$vden  "; }
    echo "</small></td><td align='left' width='05%'><small>";
    echo $vcla;
    echo "</small></td></tr>";
  } 
  echo "</table>";

  //Desconexion de la Base de Datos
  $sql->disconnect();
}
?>
</body>
</html>
