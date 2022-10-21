<script language="javascript">
function cerrarwindows2(){
  window.close();
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();
  window.opener.frames[3].location.reload();
}
</script>

<?php
// *************************************************************************************
// Programa: m_gbinven.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head>
<body onload="cerrarwindows2()" bgcolor="#D8E6FF">

<?php
//Variable
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables 
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificando conexion
$sql->connection($usuario);

$vmod =$_POST["vmod"];
$vsol =$_POST["vsol"];
$vfil =$_POST["vfil"];
$dtipo=$_POST["vtip"];
$accion=$_POST["accion"];

$nbtabla="stptmpinv";

if ($accion=='Incluir') {
  if ($vmod=='Incluir Inventor' || $vmod=='Grabar Inventor') {
    if ($vfil==0) {
      $vnom=$_POST["vnom"];
      $vpai=$_POST["vpai"];

      if ($vnom!="" AND $vpai!="") {
        $res_inv=pg_exec("SELECT max(numero) as codigo FROM $nbtabla WHERE solicitud='$vsol'");
        $filas_obfie=pg_numrows($res_inv);
        $reginv = pg_fetch_array($res_inv);
        $loc1=$reginv[codigo]+1;
        $col_campos = "solicitud,nombre_inv,nacionalidad,numero";
        $insert_str = "'$vsol','$vnom','$vpai',$loc1";
        $ins_datobfie = $sql->insert("$nbtabla","$col_campos","$insert_str","");            
      }
    }
  }
}
else {
  if ($accion=='Modificar') {
    // Accion Modificar 
    $vcod=$_POST["vtex"];
    $vnom=$_POST["vnom"];
    $vpai=$_POST["vpai"];
    $vcod=$_POST["vtex"];
    $update_str = "nombre_inv='$vnom', nacionalidad='$vpai'";
    $sql->update("$nbtabla","$update_str","solicitud='$vsol' and numero=$vcod");
  }
}

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
