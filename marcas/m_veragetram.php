<script language="javascript">
 function cerrarwindows2() {
   window.opener.frames[0].location.reload();
   window.close();
 }
</script>

<?php
  //include ("../setting.inc.php");
  //require ("../include.php");
  include ("/apl/librerias/library.php");
  include ("../z_includes.php");
  // ************************************************************************************* 
  // Programa: ver_agentram.php 
  // Realizado por el Analista de Sistema Nelson Gonzalez 
  // Año: 2021 
  // *************************************************************************************
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head>
<body onload="centrarwindows()">   
<?php
 if (($_SERVER['HTTP_REFERER']=="")) {
    echo "Acceso Denegado..."; exit(); }

 //Variable
 $usuario = $_SESSION['usuario_login'];

 $sql = new mod_db();
 $vpod1=$_GET['vpod1'];
 $vpod2=$_GET['vpod2'];
 $vnomtram=$_GET['tramitante'];
 $n_poder=$vpod1.'-'.$vpod2;
 if (empty($vpod1)) { $n_poder=$_GET['psol'];}
 $nagente=0;

//prueba
// $n_poder='1995-0052';
// $vnomtram='';
//fin prueba

 //Verificando conexion
 $sql->connection($usuario);

 $tram = agente_tramp($nagen,trim($vnomtram),$n_poder);
 echo "$tram";
 echo "Poder: $n_poder";
?>
</body>
</html>
