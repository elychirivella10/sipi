<script language="javascript">
function cerrarwindows8(){
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: a_gbcostoser.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2012 BD - Relacional I Semestre 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head> 
<body onload="cerrarwindows8()" bgcolor="#FFFFFF"> 

<?php
// onload="cerrarwindows8()" 
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();
$tbname_1= "stdseraut";

//Verificacion de Conexion 
$sql->connection();   

$vcod=$_POST["vcod"];
$vban=$_POST["banco"];
$vfac=trim($_POST["factura"]);
$vdep=trim($_POST["deposito"]);
$vfec=trim($_POST["fechadep"]);
$vopc=$_POST["salir"];

pg_exec("BEGIN WORK");
$resulact=pg_exec("UPDATE $tbname_1 SET nro_factura='$vfac',rif_banco='$vban',nro_deposito='$vdep',f_deposito='$vfec' WHERE control='$vcod'"); 
if ($resulact) { pg_exec("COMMIT WORK"); }
else { pg_exec("ROLLBACK WORK"); }

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
