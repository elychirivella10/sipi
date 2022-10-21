<?php
// *************************************************************************************
// Programa: z_coneve.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2008 y 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos  	
include ("../setting.inc.php");

//Variables 
$sql     = new mod_db();
$tbname1 = "stzroles";
$tbname2 = "stzevder";
$tbname4 = "stdevobr";
$tbname5 = "stzroleve";

$tbname6 = "stzusuar";
$tbname7 = "stzdepto";

//Variables Get 
$vrol  = $_GET['vrol'];
$vtipo = $_GET['vtipo'];

$vest = "A";
//Verificando conexion  
$sql->connection();


if ($vtipo=='M') {
  $result = pg_exec("SELECT $tbname5.evento,$tbname5.fecha_asig,$tbname5.fecha_elim,$tbname5.estado,$tbname2.descripcion,$tbname2.tipo_evento 
                     FROM $tbname5,$tbname2 
                     WHERE $tbname5.role='$vrol' AND $tbname5.estado='A' AND $tbname5.tip_derecho='$vtipo' AND $tbname5.evento=$tbname2.evento 
                     ORDER BY $tbname5.evento,$tbname5.fecha_asig");
} 
if ($vtipo=='P') {
  $result = pg_exec("SELECT $tbname5.evento,$tbname5.fecha_asig,$tbname5.fecha_elim,$tbname5.estado,$tbname2.descripcion,$tbname2.tipo_evento 
                     FROM $tbname5,$tbname2 
                     WHERE $tbname5.role='$vrol' AND $tbname5.estado='A' AND $tbname5.tip_derecho='$vtipo' AND $tbname5.evento=$tbname2.evento 
                     ORDER BY $tbname5.evento,$tbname5.fecha_asig");
} 
if ($vtipo=='A') {
  $result = pg_exec("SELECT $tbname5.evento,$tbname5.fecha_asig,$tbname5.fecha_elim,$tbname5.estado,$tbname4.descripcion,$tbname4.tipo_evento 
                     FROM $tbname5,$tbname4 
                     WHERE $tbname5.role='$vrol' AND $tbname5.estado='A' AND $tbname5.tip_derecho='$vtipo' AND $tbname5.evento=$tbname4.evento 
                     ORDER BY $tbname5.evento,$tbname5.fecha_asig");
} 

if (($vtipo=='R') && (!empty($vrol))) {
  $result = pg_exec("SELECT $tbname6.usuario,$tbname6.cedula,$tbname6.nombre,$tbname6.cod_depto,trim($tbname7.nombre) as departamento 
                    FROM $tbname6,$tbname7 
                    WHERE $tbname6.role='$vrol' AND $tbname6.estatus='1' AND $tbname6.cod_depto=$tbname7.cod_depto  
                    ORDER BY 1");
} 

if ($vtipo!='R') {
 if ($result) {
  //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
  echo " <form name='forajax' action='z_coneve.php' method='post'>";
  echo " <div id='resultado'>";
  if ($vtipo=='M') { echo " Marcas"; }
  if ($vtipo=='P') { echo " Patentes"; }
  if ($vtipo=='A') { echo " Autor"; }    
  echo " <table width='120%' style='border:1px solid #FF0000; color:#000099;width:730px;'>";
  echo " <tr style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
  echo " <td width='5%'><small><font color='#FFFFFF'><b>Evento</b></font></small></td>";
  echo " <td width='75%'><small><font color='#FFFFFF'><b>Descripci&oacute;n</b></font></small></td>";
  echo " <td width='5%'><small><font color='#FFFFFF'><b>Tipo</b></font></small></td>";
  echo " <td width='15%'><small><font color='#FFFFFF'><b>Asignaci&oacute;n</b></font></small></td>";
  echo " <td width='5%'><small><font color='#FFFFFF'><b>Estado</b></font></small></td>";
  echo " <td width='15%'><small><font color='#FFFFFF'><b>Eliminaci&oacute;n</b></font></small></td>";
  echo " </tr>";
  $filas_solicita=pg_numrows($result); 
  $row = pg_fetch_array($result);
  for($i=0;$i<$filas_solicita;$i++) {
	 echo "<tr>";
	 echo "<td width='5%'><small>".$row['evento']."</small></td>"; 	 echo "<td width='75%'><small>".$row['descripcion']."</small></td>";  
	 echo "<td width='5%'><small>".$row['tipo_evento']."</small></td>";
	 echo "<td width='15%'><small>".$row['fecha_asig']."</small></td>";	 echo "<td width='5%'><small>".$row['estado']."</small></td>";
	 echo "<td width='15%'><small>".$row['fecha_elim']."</small></td>";
	 echo "</tr>";
	 $row = pg_fetch_array($result);
  }
  echo " </table>";
  echo " </div>";
  echo " </form>";
 }
} else {
  //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
  echo " <form name='forajax' action='z_coneve.php' method='post'>";
  echo " <div id='resultado'>";
  //if ($vtipo=='R') { echo " Usuarios Adscritos"; }
  echo " <table width='120%' style='border:1px solid #FF0000; color:#000099;width:730px;'>";
  echo " <tr style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
  echo " <td width='12%'><small><font color='#FFFFFF'><b>Usuario</b></font></small></td>";
  echo " <td width='10%'><small><font color='#FFFFFF'><b>Cedula</b></font></small></td>";
  echo " <td width='25%'><small><font color='#FFFFFF'><b>Nombre</b></font></small></td>";
  echo " <td width='08%'><small><font color='#FFFFFF'><b>Depto</b></font></small></td>";
  echo " <td width='70%'><small><font color='#FFFFFF'><b>Nombre Coordinacion/Unidad</b></font></small></td>";
  echo " </tr>";
 if ($result) {
  $filas_solicita=pg_numrows($result); 
  $row = pg_fetch_array($result);
  for($i=0;$i<$filas_solicita;$i++) {
	 echo "<tr>";
	 echo "<td width='12%'><small>".$row['usuario']."</small></td>";
	 echo "<td width='10%'><small>".$row['cedula']."</small></td>";
 	 echo "<td width='25%'><small>".$row['nombre']."</small></td>";  
	 echo "<td width='08%'><small>".$row['cod_depto']."</small></td>";
  	 echo "<td width='70%'><small>".$row['departamento']."</small></td>";  
	 echo "</tr>";
	 $row = pg_fetch_array($result);
  }
  echo " </table>";
  echo " </div>";
  echo " </form>";
 }
}

?>
