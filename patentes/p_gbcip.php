<script language="javascript">
function cerrarwindows2(){
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();
  window.opener.frames[3].location.reload();
  window.opener.frames[4].location.reload();
  window.close();
}
</script>

<?php
// *************************************************************************************
// Programa: p_gbcip.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado Año 2009 BD - Relacional 
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
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

$vmod =$_POST["vmod"];
$vsol =$_POST["vsol"];
$vfil =$_POST["vfil"];

$nbtabla="stptmpcip";

if ($vmod=='Buscar/Incluir' || $vmod=='Grabar') {
    if ($vfil==0) {
      $vcla=$_POST["vcla"];
      $vtip=$_POST["vtip"];

      if ($vcla!="" AND $vtip!="") {
      
       $resultt=pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$vsol' AND 
                         clasificacion='$vcla' AND tipo_clas='$vtip'");                     
       if (pg_numrows($resultt)==0) {
         $col_campos = "solicitud,clasificacion,tipo_clas";
         $insert_str = "'$vsol','$vcla','$vtip'";
         $ins_datobfie = $sql->insert("$nbtabla","$col_campos","$insert_str",""); }
      }   
    }
  }

if ($vmod=='Buscar/Eliminar')
   {
    for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $cl[$cont]=$_POST["cla$cont"];
       $ti[$cont]=$_POST["tip$cont"];
       if ($vb[$cont]=="on")
          {$resultado=pg_exec("DELETE FROM $nbtabla WHERE solicitud='$vsol' AND clasificacion='$cl[$cont]' AND tipo_clas='$ti[$cont]'"); 
          } 
       }
   
   }

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
