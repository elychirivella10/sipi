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
// Programa: p_gbequiv.php 
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

$nbtabla="stptmpeq";
$fechahoy = hoy();

if ($vmod=='Buscar/Incluir' || $vmod=='Grabar') {
    if ($vfil==0) {
      $vnum=trim($_POST["vnum"]);

      if ($vnum!="") {
      
       $resultt=pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$vsol' AND 
                         equivalente='$vnum'");                     
       if (pg_numrows($resultt)==0) {
         $res_inv=pg_exec("SELECT max(numero) as codigo FROM $nbtabla WHERE solicitud='$vsol'");
         $filas_obfie=pg_numrows($res_inv);
         $reginv = pg_fetch_array($res_inv);
         $loc1=$reginv[codigo]+1;
         $col_campos = "solicitud,equivalente,fecha_trans,numero";
         $insert_str = "'$vsol','$vnum','$fechahoy',$loc1";
         $ins_datobfie = $sql->insert("$nbtabla","$col_campos","$insert_str",""); }
      }   
    }
  }

if ($vmod=='Buscar/Eliminar')
   {
    for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $nu[$cont]=$_POST["num$cont"];
       $eq[$cont]=$_POST["eqv$cont"];
       if ($vb[$cont]=="on")
          {$resultado=pg_exec("DELETE FROM $nbtabla WHERE solicitud='$vsol' AND equivalente='$eq[$cont]' AND numero='$nu[$cont]'"); 
          } 
       }
   }

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
