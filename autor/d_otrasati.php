<script language="javascript">
function cerrarwindows2(){
  window.close();
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();
  window.opener.frames[3].location.reload();
  window.opener.frames[4].location.reload();    
  window.opener.frames[5].location.reload();    
  window.opener.frames[6].location.reload();    
  window.opener.frames[7].location.reload();    
  window.opener.frames[8].location.reload();    
}
</script>

<?php
//Para trabajar con Operaciones de Bases de Datos
//include ("../setting.inc.php");
//LLamadas a funciones de Libreria 
//include ("$include_path/libreria.php");
//include ("$include_path/library.php");
include ("../z_includes.php");
?>

<html>
<head>
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 
<!--<body onload="cerrarwindows2()" bgcolor="#D8E6FF"> -->

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

$sql = new mod_db();
$usuario = $_SESSION['usuario_login'];

//Verificando conexion
$sql->connection($usuario);

$vsol=$_GET["vsol"];
$vnom=$_GET["vtex"];

$col_campos = "solicitud,nombre";
$insert_str = "'$vsol','$vnom'";
$ins_tab = $sql->insert("stdtmpat","$col_campos","$insert_str","");

cerrarwindows2();

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>

