<?php
// *************************************************************************************
// Programa: z_conrolus.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2008 y 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos  	
include ("../setting.inc.php");

//Variables 
$sql     = new mod_db();
$tbname1 = "stzroles";
$tbname2 = "stzuserol";

//Variables Get 
$vuser = $_GET['vuser'];

//Verificando conexion  
$sql->connection();

if (!empty($vuser)) {
  $result = pg_exec("SELECT $tbname1.role,$tbname1.nombre,$tbname1.descripcion,$tbname2.fecha_role,
                            $tbname2.hora_asig,$tbname2.estado,$tbname2.fecha_elim,$tbname2.hora_elim 
                     FROM   $tbname1,$tbname2 
                     WHERE  $tbname2.usuario='$vuser' AND $tbname1.role=$tbname2.role   
                     ORDER BY $tbname2.fecha_role desc");
} 

if ($result) {
  //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
  echo " <form name='foroles' action='z_conrolus.php' method='post'>";
  echo " <div id='resultado'>";
  echo " <table width='120%' style='border:1px solid #FF0000; color:#000099;width:730px;'>";
  echo " <tr style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
  echo " <td width='25%'><small><font color='#FFFFFF'><b>Asignaci&oacute;n</b></font></small></td>";
  echo " <td width='12%'><small><font color='#FFFFFF'><b>Rol</b></font></small></td>";
  echo " <td width='21%'><small><font color='#FFFFFF'><b>Nombre</b></font></small></td>";
  echo " <td width='22%'><small><font color='#FFFFFF'><b>Descripci&oacute;n</b></font></small></td>";
  echo " <td width='5%'><small><font color='#FFFFFF'><b>Estado</b></font></small></td>";
  echo " <td width='25%'><small><font color='#FFFFFF'><b>Eliminaci&oacute;n</b></font></small></td>";
  echo " </tr>";
  $filas_solicita=pg_numrows($result); 
  $row = pg_fetch_array($result);
  for($i=0;$i<$filas_solicita;$i++) {
	 echo "<tr>";
	 echo "<td width='25%'><small>".$row['fecha_role']." - ".$row['hora_asig']."</small></td>"; 	 echo "<td width='12%'><small>".$row['role']."</small></td>";  
 	 echo "<td width='21%'><small>".$row['nombre']."</small></td>";  
 	 echo "<td width='22%'><small>".$row['descripcion']."</small></td>";  
	 echo "<td width='5%'><small>".$row['estado']."</small></td>";
	 echo "<td width='25%'><small>".$row['fecha_elim']." - ".$row['hora_elim']."</small></td>";
	 echo "</tr>";
	 $row = pg_fetch_array($result);
  }
  echo " </table>";
  echo " </div>";
  echo " </form>";
}

?>
