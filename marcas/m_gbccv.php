<script language="javascript">
function cerrarwindows3(){
  window.opener.frames[0].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: z_gbccv.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinaci?n de Inform?tica / Direcci?n de Soporte Administrativo / SAPI / MICO
// A?o: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Aut?nomo de la Propiedad Intelectual</title>
</head> 

<body onload="cerrarwindows3()" bgcolor="#FFFFFF"> 

<?php
//onload="cerrarwindows3()"

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

$vmod=$_POST["vmod"];
$vsol=trim($_POST["vsol"]);
$vfil=$_POST["vfil"];

$tbname_1 = "stmtmpccv";
$tbname_2 = "stmcvbgra";
$tbname_3 = "stmcvplan";

if ($vmod=='Buscar/Incluir' || $vmod=='Grabar') {
  for($cont=0;$cont<$vfil;$cont++) { 
    $vb[$cont]=$_POST["B$cont"];
    $vtit[$cont]=$_POST["vtit$cont"];
    $vnom[$cont]=$_POST["vnom$cont"];
    if ($vb[$cont]=="on") {
      $resulcon=pg_exec("select * from $tbname_1 where solicitud='$vsol' AND ccv='$vtit[$cont]'");
      if (pg_numrows($resulcon)==0) {
        $resultado=pg_exec("INSERT INTO $tbname_1 (solicitud,ccv,descripcion) VALUES ('$vsol','$vtit[$cont]','$vnom[$cont]')"); }
      if ((strlen($vsol)) < 11) {
        $resulcon=pg_exec("select * from $tbname_2 where solicitud='$vsol' AND ccv='$vtit[$cont]'");        
        if (pg_numrows($resulcon)==0) {
          $resultado=pg_exec("INSERT INTO $tbname_2 (solicitud,ccv) VALUES ('$vsol','$vtit[$cont]')"); }
      }  
    } 
  }
}

if ($vmod=='Buscar/Eliminar') {
  for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $ti[$cont]=$_POST["tit$cont"];
       if ($vb[$cont]=="on") {
       	$resultado=pg_exec("DELETE FROM $tbname_1 WHERE solicitud='$vsol' and ccv='$ti[$cont]'"); 
       	$resultado=pg_exec("DELETE FROM $tbname_2 WHERE solicitud='$vsol' and ccv='$ti[$cont]'"); 
       } 
  }
}

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
