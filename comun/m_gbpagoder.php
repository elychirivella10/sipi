<script language="javascript">
function cerrarwindows8(){
  window.opener.frames[0].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: m_gbpagoder.php 
// Realizado por el Analista de Sistema Romulo Mendoza modificado por Karina Pérez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2016 BD - Relacional II Semestre  
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

// onload="cerrarwindows8()"

//Variable
$usuario = $_SESSION['usuario_login'];
$fechahoy = hoy();

$vmod=trim($_POST["vmod"]);
$vsol=$_POST["vsol"];
$vcod=$_POST["vcod"];
$vfil=$_POST["vfil"];
$vopc=$_POST["salir"];
$vtot=$_POST["vtot"];
$vbol=$_POST["vbol"]; 
$vder=$_POST["vder"];
$vcla=$_POST["vcla"];
$vtip=trim($_POST["vtip"]);
$vnom=$_POST["vnom"];
$tbname_1 = "stmtmppago";

//echo " $vmod, $vcod, $vder, $vsol, $vnom, $vtip, $vbol, $vtot, $vcla "; 

//Verificacion de Conexion 
$sql = new mod_db();
$sql->connection();   
    
if (($vmod=='Buscar/Incluir') || ($vmod=='Grabar'))
{   
    $obj_query = $sql->query("update stzsystem set nro_pagodem=nextval('stzsystem_nro_pagodem_seq')");
    $obj_query = $sql->query("select last_value from stzsystem_nro_pagodem_seq");
    $objs = $sql->objects('',$obj_query);
    $vnumpren = $objs->last_value;
    $horactual= Hora();  
    if ($vtip=='M') {
      $resulcon=pg_exec("SELECT * FROM $tbname_1 WHERE solicitud='$vsol' AND nro_tramite='$vcod'");
      if (pg_numrows($resulcon)==0) {
        $resultado=pg_exec("INSERT INTO $tbname_1 VALUES($vnumpren,'$vcod','$vder','$vsol','$vnom','$vcla',$vbol,'$usuario','$fechahoy','$horactual')"); } 
    }
}

if ($vmod=='Buscar/Eliminar' )
   {
    for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $ti[$cont]=$_POST["tit$cont"];
       if ($vb[$cont]=="on") { 
         $resultado=pg_exec("DELETE FROM $tbname_1 WHERE solicitud='$ti[$cont]' AND nro_tramite='$vcod'"); } 
       }
   }

//Desconexion de la Base de Datos
//$sql->disconnect();
?>
</body>
</html>
