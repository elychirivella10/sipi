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
$tbname1 = "stzusuar";
$tbname2 = "stzdepto";
$tbname3 = "stzuserol";

//Variables Get 
$vrol  = $_GET['vrol'];

echo "rol=$vrol"; 

exit();
//Verificando conexion  
$sql->connection();

$result = pg_exec("SELECT $tbname1.usuario,$tbname1.cedula,$tbname1.nombre,$tbname1.cod_depto,trim($tbname2.nombre) as departamento 
                     FROM $tbname1,$tbname2 
                    WHERE $tbname1.role='$vrol' AND $tbname1.cod_depto=$tbname2.cod_depto  
                    ORDER BY 1");
} 

$result = pg_exec("SELECT stzusuar.usuario,stzusuar.cedula,stzusuar.nombre,stzusuar.cod_depto,trim(stzdepto.nombre) as departamento 
                     FROM stzusuar,stzdepto 
                    WHERE stzusuar.role='ADMIN' AND stzusuar.cod_depto=stzdepto.cod_depto  
                    ORDER BY 1");
} 

if ($result) {
  //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
  echo " <form name='foroluse' action='z_conusr.php' method='post'>";
  echo " <div id='resultado'>";
  echo " Usuarios Adscritos";    
  echo " <table width='120%' style='border:1px solid #FF0000; color:#000099;width:730px;'>";
  echo " <tr style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
  echo " <td width='10%'><small><font color='#FFFFFF'><b>Usuario</b></font></small></td>";
  echo " <td width='10%'><small><font color='#FFFFFF'><b>Cedula</b></font></small></td>";
  echo " <td width='25%'><small><font color='#FFFFFF'><b>Nombre</b></font></small></td>";
  echo " <td width='05%'><small><font color='#FFFFFF'><b>Cd. Depto</b></font></small></td>";
  echo " <td width='75%'><small><font color='#FFFFFF'><b>Coordinacion</b></font></small></td>";
  echo " </tr>";
  $filas_solicita=pg_numrows($result); echo "son=$filas_solicita "; 
  $row = pg_fetch_array($result);
  for($i=0;$i<$filas_solicita;$i++) {
	 echo "<tr>";
	 echo "<td width='10%'><small>".$row['usuario']."</small></td>";
	 echo "<td width='10%'><small>".$row['cedula']."</small></td>";
 	 echo "<td width='25%'><small>".$row['nombre']."</small></td>";  
	 echo "<td width='5%'><small>".$row['cod_depto']."</small></td>";
  	 echo "<td width='75%'><small>".$row['departamento']."</small></td>";  
	 echo "</tr>";
	 $row = pg_fetch_array($result);
  }
  echo " </table>";
  echo " </div>";
  echo " </form>";
}

?>
