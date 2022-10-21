<script language="javascript">
function cerrarwindows2(){
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: m_gbautoriza.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2014 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>SIPI - Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head>
<body onload="cerrarwindows2()" bgcolor="#FFFFFF">

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

//Variables        
$vmod =$_POST["vmod"];
$vcod =$_POST["vcod"];
$vfil =$_POST["vfil"];

$nbtabla="stmpceraut";
$fechahoy = hoy();

if ($vmod=='Buscar/Incluir' || $vmod=='Grabar') {
    if ($vfil==0) {
      $vnom=$_POST["vnom"];
      $vced=$_POST["vced"];
      $vcodl=$_POST["vcodl"];

      if ($vnom!="" AND $vced!="") {
       $vide = $vcodl.$vced;
       $resultt=pg_exec("SELECT * FROM $nbtabla WHERE control='$vcod' AND nombre_aut='$vnom' AND cedula_aut='$vide'");                     
       if (pg_numrows($resultt)==0) {
         $col_campos = "control,cedula_aut,nombre_aut,fecha_trans";
         $insert_str = "'$vcod','$vide','$vnom','$fechahoy'";
         $ins_datosaut = $sql->insert("$nbtabla","$col_campos","$insert_str",""); }
      }   
    }
  }

if ($vmod=='Buscar/Eliminar')
   {
    for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $no[$cont]=$_POST["nom$cont"];
       $ce[$cont]=$_POST["ced$cont"];
       if ($vb[$cont]=="on")
          {$resultado=pg_exec("DELETE FROM $nbtabla WHERE control='$vcod' AND cedula_aut='$ce[$cont]' AND nombre_aut='$no[$cont]'"); 
          } 
       }
   
   }

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
