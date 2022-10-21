<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>
<?php
// *************************************************************************************
// Programa: p_verprensa.php  
// Realizado por el Analista de Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2010
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

$vcod=$_GET['vcod'];
$vbol=$_GET['vbol'];
//echo "$vcod,$vbol";
//$vbol = 552;
$resultado=pg_exec("SELECT c.solicitud, nombre FROM stzderec b, stptmppren c
			   WHERE c.factura = '$vcod' AND c.boletin = '$vbol' AND 
                           c.solicitud = b.solicitud AND
                           b.tipo_mp='P'");
                           
$filas_found=pg_numrows($resultado);
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center' width='03%'>Num.</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='07%'>Solicitud</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='75%'>Titulo</td>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vsol=$regtmp[solicitud];
    $vnom=$regtmp[nombre];
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center' width='03%'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='center' width='07%'><small>";
    echo $vsol; 
    echo "</small></td><td align='left' width='60%'><small>";
    echo $vnom;
    echo "</small></td></tr>";
} 
echo "</table>";

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
