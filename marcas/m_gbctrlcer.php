<script language="javascript">
function cerrarwindows8(){
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: m_gbprensa.php 
// Realizado por el Analista de Sistema Romulo Mendoza modificado por Karina Pérez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2010 BD - Relacional 
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

//Verificacion de Conexion 
$sql->connection($usuario);   

$vmod=$_POST["vmod"];
$vreg=$_POST["vreg"];
$vder=$_POST["vder"];
$vcod=$_POST["vcod"];
$vfil=$_POST["vfil"];
$vopc=$_POST["salir"];

$tbname_1 = "stmtmpcer";
$tbname_2 = "stmregcer";
$fechahoy = hoy();

if (($vmod=='Buscar/Incluir') || ($vmod=='Grabar'))
{    
    if ($vopc=='Incluir') {
      $resulcon=pg_exec("SELECT * from $tbname_1 WHERE registro='$vreg' AND control = '$vcod' "); 
      if (pg_numrows($resulcon)==0) {
        $resultado=pg_exec("INSERT INTO $tbname_1 VALUES($vcod,$vder,'$vreg','$fechahoy')"); }
    }
}

if ($vmod=='Buscar/Eliminar')
   {
   
    for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $ti[$cont]=$_POST["tit$cont"];
       if ($vb[$cont]=="on") { 
         $resultado=pg_exec("DELETE FROM $tbname_1 WHERE registro='$ti[$cont]' AND control='$vcod'"); } 
       }

   }

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
