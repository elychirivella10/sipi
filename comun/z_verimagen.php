<script language="javascript">
function cerrarwindows3(){
  window.opener.frames[0].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: z_verimagen.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2013 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autónomo de la Propiedad Intelectual</title>
</head> 

<body onload="cerrarwindows3()" bgcolor="#FFFFFF"> 

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$sql = new mod_db();
$usuario = $_SESSION['usuario_login'];
$vsol    = trim($_GET['psol']);

//Verificando conexion
$sql->connection($usuario);

if ($vsol=='-') {
  $nameimage = "../imagenes/sin_imagen8.png"; }
else {
  $obj_query = $sql->query("SELECT * FROM stmpsolpla WHERE solicitud='$vsol'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas==0) { $nameimage = "../imagenes/sin_imagen8.png"; }
  else {
    $objs = $sql->objects('',$obj_query);
    $nplanilla = $objs->cod_planilla; 
    if ($nplanilla=='000000') {
      $nameimage = "../imagenes/sin_imagen8.png"; }
    else {
      $nameimage = "../graficos/planblog/".$nplanilla.".jpg"; 
    }
  }  
}
// width='262' height='233'
echo "<table width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr>";
echo "<td align='center'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='100%' height='100%'></td></a>"; 
echo "</tr>";
echo "</table>";

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
