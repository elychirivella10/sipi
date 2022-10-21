<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<?php
// ************************************************************************************* 
// Programa: d_vernatjur.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

//$vsoli=$_GET['psol'];
//$vder =$_GET['pder'];

$idsol   = $_GET['psol'];
$dtipo  = $_GET['vtipo'];

 switch ($dtipo) {
   case "Solicitante":
     $nbtabla="stdtmpso";
     break;
   case "Productor":
     $nbtabla="stdtmppt"; 
     break;
   case "Autor":
     $nbtabla="stdtmpau"; 
     break;
   case "Coautor":
     $nbtabla="stdtmpco"; 
     break;
   case "Artista":
     $nbtabla="stdtmpar"; 
     break;
   case "Editor":
     $nbtabla="stdtmped"; 
     break;
   case "Titular":
     $nbtabla="stdtmpti"; 
     break;
 }       
//$nbtabla= "stdtmpso";

 $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol' ORDER BY nombre");
 if ($dtipo=='Coautor1') {
    $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol' and tipo_autor='CD' ORDER BY nombre"); }
 if ($dtipo=='Coautor2') {
    $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol' and tipo_autor='CA' ORDER BY nombre"); }
 if ($dtipo=='Coautor3') {
    $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol' and tipo_autor='CG' ORDER BY nombre"); }
 if ($dtipo=='Coautor4') {
    $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol' and tipo_autor='CM' ORDER BY nombre"); }

 if (!$result)
   return false; 
 else {
   $filas_found=pg_numrows($result);
   echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
   echo "<tr><td class='celda3' width='04%'></td>";
   echo "    <td class='celda3' width='08%'>C&oacute;digo</td>"; 
   echo "    <td class='celda3' align='center' width='08%'>C&eacute;dula/Rif</td>"; 
   echo "    <td class='celda3' align='left' width='34%'>Nombre</td>";
   echo "    <td class='celda3' align='left' width='44%'>Domicilio</td>";
   echo "    <td class='celda3' width='05%'>Pa&iacute;s</td></tr>";

   for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp  = pg_fetch_array($result); 
    $vcodigo=$regtmp['codigo'];
    $vcedrif =$regtmp['ced_rif'];
    $vnombre =$regtmp['nombre'];
    $vdomicilio=$regtmp['domicilio'];     
    $vpais = $regtmp['pais'];

    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='center'><small>";
    echo $vcodigo; 
    echo "</small></td><td align='center'><small>";
    echo $vcedrif; 
    echo "</small></td><td align='left'><small>";
    echo $vnombre; 
    echo "</small></td><td><small>";
    echo $vdomicilio; 
    echo "</small></td><td><small>";
    echo $vpais; 
    echo "</small></td></tr>";
   }
   echo "</table>";
  }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
