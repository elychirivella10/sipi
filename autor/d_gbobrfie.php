<script language="javascript">
function cerrarwindows2(){
  window.close();
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();
}
</script>

<?php
// *************************************************************************************
// Programa: d_gbobrfie.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2006
// Modificado Año 2009 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head>
<body onload="cerrarwindows2()" bgcolor="#D8E6FF">

<?php

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$sql = new mod_db();
$usuario = $_SESSION['usuario_login'];

//Verificando conexion
$sql->connection($usuario);

$vmod=$_POST["vmod"];
$vsol=$_POST["vsol"];
$vfil=$_POST["vfil"];
$dtipo=$_POST["vtip"];
$accion=$_POST["accion"];

$nbtabla="stdtmpfie";

if ($accion=='incluir') {
  if ($vmod=='Incluir Obra Fijada' || $vmod=='Incluir Obra Int/Eje' || $vmod=='Grabar Nueva Obra') {
    if ($vfil==0) {
      $vnom=$_POST["vnom"];
      $vaut=$_POST["vaut"];
      $varr=$_POST["varr"];
      $vint=$_POST["vint"];
      $vobr=$_POST["vgen"];

      if ($vnom!="" AND  $vaut!="" AND $vobr!="") {
        $vsalir=0; 
        while ($vsalir==0) {
          $numero=rand(10,90);
          $nro_obfie="OBFIE".$numero;
          $res_fie=pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$vsol' and nro_obfinej='$nro_obfie'");
          $filas_obfie=pg_numrows($res_fie);
          if ($filas_obfie==0) { $vsalir=1; }
        } 
        $col_campos = "solicitud,nro_obfinej,titulo_obfie,nombre_autor,arreglista,interprete,tipo_obfie";
        $insert_str = "'$vsol','$nro_obfie','$vnom','$vaut','$varr','$vint','$vobr'";
        $ins_datobfie = $sql->insert("$nbtabla","$col_campos","$insert_str","");            
      }
    }
  }
}
else {
  // Accion Modificar 
  $vcod=$_POST["vtex"];
  $vnom=$_POST["vnom"];
  $vaut=$_POST["vaut"];
  $varr=$_POST["varr"];
  $vint=$_POST["vint"];
  $vobr=$_POST["vgen"];
  $update_str = "titulo_obfie='$vnom', nombre_autor='$vaut', arreglista='$varr', interprete='$vint',tipo_obfie='$vobr'";
  $sql->update("$nbtabla","$update_str","solicitud='$vsol' and nro_obfinej='$vcod'");
}

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
