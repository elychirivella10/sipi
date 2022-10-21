<script language="javascript">
function cerrarwindows8(){
  window.opener.frames[0].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: p_gbpagoder.php 
// Realizado por el Analista de Sistema Romulo Mendoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2016 II Semestre BD - Relacional I Semestre  
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autónomo de la Propiedad Intelectual</title>
</head> 
<body onload="cerrarwindows8()" bgcolor="#D8E6FF"> 

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }
//<body  bgcolor="#D8E6FF">   

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fechahoy = hoy();
$horactual= Hora();

//Verificacion de Conexion 
$sql->connection($usuario);   

$vmod=$_POST["vmod"];
$vsol=$_POST["vsol"];
$vcod=$_POST["vcod"];
$vfil=$_POST["vfil"];
$vopc=$_POST["salir"];
$vtot=$_POST["vtot"];
$vbol=$_POST["vbol"]; 
$vder=$_POST["vder"];
$tbname_1 = "stppagocon";

//echo " $vmod, $vsol, $vcod, $vtot, $vbol, $vder, ";  
    
if (($vmod=='Buscar/Incluir') || ($vmod=='Grabar'))
{    echo " entro a grabar ";
    $resulcon=pg_exec("SELECT * FROM $tbname_1 WHERE solicitud='$vsol' AND factura='$vcod'");
    if (pg_numrows($resulcon)==0) {
      $resultado=pg_exec("INSERT INTO $tbname_1 VALUES('$vcod','$vder','$vsol',$vbol,'C','$usuario','$fechahoy','$horactual')"); } 
}

if ($vmod=='Buscar/Eliminar' )
   {
    for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $ti[$cont]=$_POST["tit$cont"];
       if ($vb[$cont]=="on") { 
         $resultado=pg_exec("DELETE FROM $tbname_1 WHERE solicitud='$ti[$cont]' AND factura='$vcod'"); } 
       }
   }

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
