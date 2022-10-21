<?php
//Clase para Visualizar y Eliminar la(s) Persona(s) Natural(es) o Juridica(s) 
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//implementamos la clase de Persona Natural o Juridico cpNatuJuri
class coFijinEje{
 //constructor	
 function coFijinEje(){
 }	

 // consulta de la Persona Natural o Juridica segun la tabla temporal de la BD
 function consultar($idsol,$nbtabla,$dtipo){
   $sql = new mod_db();
   //Verificando conexion
   $sql->connection();
   $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol' ORDER BY nombre");
	if (!$result)
	 return false; 
	else
    //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
    echo "<form name='forajax' action='d_elisoli.php' method='post'>";
  	 echo " <div id='resultado'>";
	 echo " <table style='border:1px solid #FF0000; color:#000099;width:730px;'>";
	 echo " <tr style='background:#99CCCC;'>";
	 //echo " <td>Expediente</td>";            
	 echo " <td>Ced/Rif</td>";
 	 echo " <td>Nombre/Raz&oacute;n Social</td>";
	 echo " <td>Domicilio</td>";
	 echo " <td>Nacionalidad</td>";
	 echo " <td>Eli</td>";
	 echo " </tr>";
	 $filas_solicita=pg_numrows($result); 
	 $row = pg_fetch_array($result);
	 for($i=0;$i<$filas_solicita;$i++) {
		$vsolicitud=$row['solicitud'];
	   $conjunto[$i]=$row['codigo'];
		echo "<tr>";
		//echo "<td>".$row['solicitud']."</td>";
		echo "<td>".$row['codigo']."</td>";  
		echo "<td>".$row['nombre']."</td>";
		echo "<td>".$row['domicilio']."</td>";
		echo "<td>".$row['pais']."</td>";
	   echo "<td>";
	   echo "<input type='image' name='elimina' src='../imagenes/erase.png' value=$conjunto[$i]>";
	   echo "<input type ='hidden' name=valor[$i] value=$conjunto[$i]>";
	   echo "<input type ='hidden' name='idsol' value='$vsolicitud'>";
 	   echo "<input type ='hidden' name='dtipo' value='$dtipo'>";
	   echo "</td>";
		echo "</tr>";
	   $row = pg_fetch_array($result);
	 }
	 echo " </table>";
 	 echo " </div>";
	 echo " </form>";
	 return $result;
 }

 //elimina una Persona Natural o Juridica de la tabla temporal en la base de datos
 function eliminar($vsol,$vcod,$nbtabla){
     $sql = new mod_db();
     //Verificando conexion
     $sql->connection();
     $result = $sql->del($nbtabla,"solicitud='$vsol' AND codigo='$vcod'");
     if (!$result)
	   return false;
     else
       return true;
 }


}
?>
