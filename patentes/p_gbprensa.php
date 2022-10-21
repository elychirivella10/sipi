<script language="javascript">
function cerrarwindows8(){
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: p_gbprensa.php 
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
//<body onload="cerrarwindows8()" bgcolor="#D8E6FF"> 

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

$vmod=$_POST["vmod"];
$vsol=$_POST["vsol"];
$vcod=$_POST["vcod"];
$vfil=$_POST["vfil"];
$vopc=$_POST["salir"];
$evto=$_POST['evto'];
$vest=$_POST['vest'];

$tbname_1 = "stzprensa";

if (($vmod=='Buscar/Incluir') || ($vmod=='Grabar') or ($vmod=='Buscar/Incluir_32') or ($vmod=='Buscar/Incluir_33'))
{    
    if ($vopc=='Incluir') {
       $resulcon=pg_exec("select * from $tbname_1 where solicitud='$vsol' AND nprensa = '$vcod' ");
       if (pg_numrows($resulcon)==0) {
        $evto=2000+$evto;
        $vest=2000+$vest;
        
        if ($vmod=='Buscar/Incluir') {
          switch ($vest) {
            case 2004:
              $evto = 2022;
              break;
            case 2005:
              $evto = 2023;
              break;
            case 2011:
              $evto = 2031;
              break;
          }       
        }
        
        if ($vmod=='Buscar/Incluir_32') {
         if (($vest==2004) || ($vest==2005) || ($vest==2011)) { $evto = 2032; }
        }

        if ($vmod=='Buscar/Incluir_33') {
         if (($vest==2004) || ($vest==2005) || ($vest==2011)) { $evto = 2033; }
        }
        
        //echo " $vmod, $vsol, $evto, $vest "; exit();
        
        $resultado=pg_exec("INSERT INTO $tbname_1 VALUES($vcod,'$vsol','P',$evto)"); }
    }
}

if (($vmod=='Buscar/Eliminar' )  or ($vmod=='Buscar/Eliminar_32')  or ($vmod=='Buscar/Eliminar_33'))
   {
   
    for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $ti[$cont]=$_POST["tit$cont"];
       if ($vb[$cont]=="on") { 
         $resultado=pg_exec("DELETE FROM $tbname_1 WHERE solicitud='$ti[$cont]' and nprensa='$vcod'"); } 
       }

   }

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
