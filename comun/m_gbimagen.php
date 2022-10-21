<script language="javascript">
function cerrarwindows1(){
  window.opener.frames[0].location.reload();
  window.close();
}
</script>
<?php
 include ("../z_includes.php");
 // ************************************************************************************* 
 // Programa: m_gbimagen.php 
 // Realizado por el Analista de Sistema Romulo Mendoza 
 // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
 // Año: 2013 BD - Relacional 
 // *************************************************************************************
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 

<body onload="cerrarwindows1()" bgcolor="#FFFFFF"> 

<?php
//Variables   
$sql = new mod_db();

$tbname_1 = "stmpsolpla";

//Verificando conexion
$sql->connection();

$vsol=$_POST["vsol"];
$vcod=$_POST["vcod"];

$col_campos = "solicitud,cod_planilla";
$insert_str = "'$vsol','$vcod'";
$insplan = $sql->insert("$tbname_1","$col_campos","$insert_str",""); 

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
