<?php
//Clase para Visualizar y Eliminar la(s) Persona(s) Natural(es) o Juridica(s) 
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//implementamos la clase de Persona Natural o Juridico cpNatuJuri
class cpNatuJuri{
 //constructor	
 function cpNatuJuri(){
 }	

 // consulta de la Persona Natural o Juridica segun la tabla temporal de la BD
 function consultar($idsol,$nbtabla,$dtipo){
   $sql = new mod_db();
   //Verificando conexion
   $sql->connection();
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
   else
    //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
    echo "<form name='forajax' action='d_elisoli.php' method='post'>";
  	 echo " <div id='resultado'>";
	 //echo " <table style='border:1px solid #FF0000; color:#000099;width:730px;'>";
	 echo " <table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
	 echo " <tr style='background:#99CCCC;'>";
	 echo " <td>Codigo</td>";            
	 echo " <td width='15%'>Cedula/Rif</td>";
 	 echo " <td>Nombre</td>";
	 echo " <td>Domicilio</td>";
	 echo " <td>Nacionalidad</td>";
	 echo " <td width='2%'>Quitar</td>";
	 echo " </tr>";
	 $filas_solicita=pg_numrows($result); 
	 $row = pg_fetch_array($result);
	 for($i=0;$i<$filas_solicita;$i++) {
           $vsolicitud=$row['solicitud'];
	   $conjunto[$i]=$row['codigo'];
		echo "<tr>";
		echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'>".$row['codigo']."</td>";
		echo "<td>".$row['ced_rif']."</td>";  
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
//	 echo "<a href='d_versoli.php?vsol=$idsol&dtipo=$dtipo'><img src='../imagenes/viewmag+.png' border='0'></a>&nbsp;Actualizar Lista";
	 echo " </table>";
 	 echo " </div>";
	 echo " </form>";
	 return $result;
 }

// consulta de la Persona Natural o Juridica segun la tabla temporal de la BD
 function consultarat($idsol,$nbtabla,$dtipo){
   $sql = new mod_db();
   //Verificando conexion
   $sql->connection();
   $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol'");
   
   if (!$result)
	 return false; 
   else
    //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
    echo "<form name='forajax' action='d_elisoli.php' method='post'>";
  	 echo " <div id='resultado'>";
	 echo " <table style='border:1px solid #FF0000; color:#000099;width:730px;'>";
	 echo " <tr style='background:#99CCCC;'>";
	 echo " <td width='15%'>No.</td>";
 	 echo " <td>Artistas Principales</td>";
	 echo " <td width='2%'>Quitar</td>";
	 echo " </tr>";
	 $filas_solicita=pg_numrows($result); 
	 $row = pg_fetch_array($result);
       $cant=1;
	 for($i=0;$i<$filas_solicita;$i++) {
		$vsolicitud=$row['solicitud'];
	      $vnombre[$i]=$row['nombre'];
		echo "<tr>";
	      echo "<td>$cant.-</td>";  
		echo "<td>".$row['nombre']."</td>";
	   echo "<td>";
	   echo "<input type='image' name='elimina' src='../imagenes/erase.png' value=$vnombre[$i]>";
	   echo "<input type ='hidden' name=valor[$i]  value=$vnombre[$i]>";
	   echo "<input type ='hidden' name='idsol'    value='$vsolicitud'>";
 	   echo "<input type ='hidden' name='dtipo'    value='$dtipo'>";
     
	   echo "</td>";
	   echo "</tr>";
         $cant++;
	   $row = pg_fetch_array($result);
	 }
	 echo " </table>";
 	 echo " </div>";
	 echo " </form>";
	 return $result;
 }

// consulta de los inventores de patentes segun la tabla temporal de la BD 
 function consultainv($idsol,$nbtabla,$dtipo){
   $sql = new mod_db();
   //Verificando conexion
   $sql->connection();
   $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol'");
   
   if (!$result)
	 return false; 
   else
    //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
    echo "<form name='forajax' action='../autor/d_elisoli.php' method='post'>";
	 echo " <table style='border:1px solid #FF0000; color:#000099;width:570px;'>";
	 echo " <tr style='background:#99CCCC;'>";
	 echo " <td width='6%'>No.</td>";
 	 echo " <td width='58%'>Inventor</td>";
 	 echo " <td width='18%'>Nacionalidad</td>";
	 //echo " <td width='6%'>Quitar</td>";
	 echo " </tr>";
	 $filas_solicita=pg_numrows($result); 
	 $row = pg_fetch_array($result);
    $cant=1;
    $vnombre=array();
	 for($i=1;$i<=$filas_solicita;$i++) {
	   $vsolicitud=$row['solicitud'];
	   $vnombre[$i]=$row['nombre_inv'];
	   $vcodigo[$i]=$row['numero'];
	   echo "<tr>";
      echo "<td width='6%'>".$row['numero'].".-</td>";    
	   echo "<td width='58%'>".$row['nombre_inv']."</td>";
	   echo "<td width='18%'>".$row['nacionalidad']."</td>";
	   echo "<td>";
	   //echo "<input type='image' name='elimina' value='$vcodigo[$i]' src='../imagenes/erase.png'>";

	   echo "<input type ='hidden' name=valor[$i]  value='$vnombre[$i]'>";
	   echo "<input type ='hidden' name='idsol'    value='$vsolicitud'>";
 	   echo "<input type ='hidden' name='dtipo'    value='$dtipo'>";
	   echo "</td>";
	   echo "</tr>";
      $cant++;
      $row = pg_fetch_array($result);
	 }
	 echo " </table>";
	 echo " </form>";
	 return $result;
 }

// consulta de las Clasificaciones de patentes segun la tabla temporal de la BD 
 function consulclas($idsol,$nbtabla,$dtipo){
   $sql = new mod_db();
   //Verificando conexion
   $sql->connection();
   $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol'");
   
   if (!$result)
	 return false; 
   else
    //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
    echo "<form name='forajax' action='../autor/d_elisoli.php' method='post'>";
  	 echo " <div id='resultado'>";
	 echo " <table style='border:1px solid #FF0000; color:#000099;width:570px;'>";
	 echo " <tr style='background:#99CCCC;'>";
	 echo " <td width='6%'>No.</td>";
 	 echo " <td width='6%'>Tipo</td>";
 	 echo " <td width='70%'>Clasificaci&oacute;n</td>";
	 echo " <td width='6%'>Quitar</td>";
	 echo " </tr>";
	 $filas_solicita=pg_numrows($result); 
	 $row = pg_fetch_array($result);
	 for($i=1;$i<=$filas_solicita;$i++) {
	   $vsolicitud=$row['solicitud'];
	   $vnombre[$i]=$row['clasificacion'];
	   $vcodigo[$i]=$row['numero'];
	   echo "<tr>";
      echo "<td width='6%'>".$row['numero'].".-</td>";    
	   echo "<td width='6%'>".$row['tipo_clas']."</td>";
	   echo "<td width='70%'>".$row['clasificacion']."</td>";
	   echo "<td>";
	   echo "<input type='image' name='elimina' value='$vcodigo[$i]' src='../imagenes/erase.png'>";
	   echo "<input type ='hidden' name=valor[$i]  value='$vnombre[$i]'>";
	   echo "<input type ='hidden' name='idsol'    value='$vsolicitud'>";
 	   echo "<input type ='hidden' name='dtipo'    value='$dtipo'>";
	   echo "</td>";
	   echo "</tr>";
      $row = pg_fetch_array($result);
	 }
	 echo " </table>";
 	 echo " </div>";
	 echo " </form>";
	 return $result;
 }

// consulta de las prioridades de patentes o marcas segun la tabla temporal de la BD 
 function consulpri($idsol,$nbtabla,$dtipo,$derecho) {
   $sql = new mod_db();
   //Verificando conexion   
   $sql->connection();
   $resp = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol' and tipo_derecho='$derecho'");
   
   if (!$resp)
	 return false; 
   else
    //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
    echo "<form name='frajaxpri' action='../autor/d_elisoli.php' method='post'>";
	 echo " <table style='border:1px solid #FF0000; color:#000099;width:570px;'>";
	 echo " <tr style='background:#99CCCC;'>";
	 echo " <td width='6%'>No.</td>";
 	 echo " <td width='25%'>Prioridad</td>";
 	 echo " <td width='18%'>Fecha</td>";
 	 echo " <td width='5%'>Nacionalidad</td>";
	 //echo " <td width='6%'>Quitar</td>";
	 echo " </tr>";
	 $filasp=pg_numrows($resp); 
	 $row = pg_fetch_array($resp);
	 for($i=1;$i<=$filasp;$i++) {
	   $vsolicitud=$row['solicitud'];
	   $vprioridad[$i]=$row['prioridad'];
	   $vcodigo[$i]=$row['numero'];
	   echo "<tr>";
      echo "<td width='6%'>".$row['numero'].".-</td>";    
	   echo "<td width='25%'>".$row['prioridad']."</td>";
	   echo "<td width='18%'>".$row['fecha_priori']."</td>";
	   echo "<td width='5%'>".$row['pais_priori']."</td>";
	   echo "<td>";
	   //echo "<input type='image' name='elimina' value='$vcodigo[$i]' src='../imagenes/erase.png'>";
	   echo "<input type ='hidden' name=valor[$i] value='$vprioridad[$i]'>";
	   echo "<input type ='hidden' name='idsol'   value='$vsolicitud'>";
 	   echo "<input type ='hidden' name='dtipo'   value='$dtipo'>";
 	   echo "<input type ='hidden' name='derecho' value='$derecho'>";
	   echo "</td>";
	   echo "</tr>";
      $row = pg_fetch_array($resp);
	 }
	 echo " </table>";
	 echo " </form>";
	 return $resp;
 }

// consulta de las Equivalentes de patentes segun la tabla temporal de la BD 
 function consequiv($idsol,$nbtabla,$dtipo){
   $sql = new mod_db();
   //Verificando conexion
   $sql->connection();
   $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol'");
   
   if (!$result)
	 return false; 
   else
    //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
    echo "<form name='forajax' action='../autor/d_elisoli.php' method='post'>";
  	 echo " <div id='resultado'>";
	 echo " <table style='border:1px solid #FF0000; color:#000099;width:570px;'>";
	 echo " <tr style='background:#99CCCC;'>";
	 echo " <td width='6%'>No.</td>";
 	 echo " <td width='78%'>Equivalente</td>";
	 echo " <td width='6%'>Quitar</td>";
	 echo " </tr>";
	 $filas_solicita=pg_numrows($result); 
	 $row = pg_fetch_array($result);
	 for($i=1;$i<=$filas_solicita;$i++) {
	   $vsolicitud=$row['solicitud'];
	   $vnombre[$i]=$row['equivalente'];
	   $vcodigo[$i]=$row['numero'];
	   echo "<tr>";
      echo "<td width='6%'>".$row['numero'].".-</td>";    
	   echo "<td width='78%'>".$row['equivalente']."</td>";
	   echo "<td>";
	   echo "<input type='image' name='elimina' value='$vcodigo[$i]' src='../imagenes/erase.png'>";
	   echo "<input type ='hidden' name=valor[$i]  value='$vnombre[$i]'>";
	   echo "<input type ='hidden' name='idsol'    value='$vsolicitud'>";
 	   echo "<input type ='hidden' name='dtipo'    value='$dtipo'>";
	   echo "</td>";
	   echo "</tr>";
      $row = pg_fetch_array($result);
	 }
	 echo " </table>";
 	 echo " </div>";
	 echo " </form>";
	 return $result;
 }

 // consulta de los titulares de patentes o marcas segun la tabla temporal de la BD 
 function consultatit($idsol,$nbtabla,$dtipo,$derecho) {
   $sql = new mod_db();
   //Verificando conexion   
   $sql->connection();
   $result = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$idsol' and tipo_derecho='$derecho'");
   
   if (!$result)
      return false; 
   else
    //Muestra los datos consultados, se hara uso de tabla para tabular los resultados
    echo "<form name='forajax' action='../autor/d_elisoli.php' method='post'>";
  	 echo " <div id='resultado'>";
	 echo " <table style='border:1px solid #FF0000; color:#000099;width:730px;'>";
	 echo " <tr style='background:#99CCCC;'>";
	 echo " <td width='6%'>No.</td>";
 	 echo " <td width='38%'>Nombre</td>";
 	 echo " <td width='35%'>Domicilio</td>";
 	 echo " <td width='15%'>Nacionalidad</td>";
	 echo " <td width='6%'>Quitar</td>";
	 echo " </tr>";
	 $filas_solicita=pg_numrows($result); 
	 $row = pg_fetch_array($result);
    $cant=1;
	 for($i=0;$i<$filas_solicita;$i++) {
	   $vsolicitud=$row['solicitud'];
	   $vnombre[$i]=$row['nombre'];
	   echo "<tr>";
	   echo "<td width='6%'>$cant.-</td>";  
	   echo "<td width='38%'>".$row['nombre']."</td>";
	   echo "<td width='35%'>".$row['domicilio']."</td>";
	   echo "<td width='15%'>".$row['pais_resid']."</td>";
	   echo "<td>";
	   echo "<input type='image' name='elimina' src='../imagenes/erase.png' value=$vnombre[$i]>";
	   echo "<input type ='hidden' name=valor[$i] value=$vnombre[$i]>";
	   echo "<input type ='hidden' name='idsol'   value='$vsolicitud'>";
 	   echo "<input type ='hidden' name='dtipo'   value='$dtipo'>";
 	   echo "<input type ='hidden' name='derecho' value='$derecho'>";
	   echo "</td>";
	   echo "</tr>";
      $cant++;
      $row = pg_fetch_array($result);
	 }
	 echo " </table>";
 	 echo " </div>";
	 echo " </form>";
	 return $result;
 }

 //elimina una Persona Natural o Juridica de la tabla temporal en la base de datos
 function eliminar($vsol,$vcod,$nbtabla,$vcondadd=''){
     $sql = new mod_db();
     //Verificando conexion
     $sql->connection();
     $result = $sql->del($nbtabla,"solicitud='$vsol' AND codigo='$vcod'".$vcondadd);
     if (!$result)
	   return false;
     else
      return true;
 }

 //elimina una Persona Natural o Juridica de la tabla temporal en la base de datos
 function eliminarat($vsol,$vcod,$nbtabla,$vcondadd=''){
     $sql = new mod_db();
     //Verificando conexion
     $sql->connection();
     $result = $sql->del($nbtabla,"solicitud='$vsol' AND nombre LIKE '%$vcod%'".$vcondadd);
     if (!$result)
	   return false;
     else
      return true;
 }

 //elimina un Inventor de la tabla en la base de datos
 function eliminainv($vsol,$vcod,$nbtabla,$vcondadd=''){
     $sql = new mod_db();
     //Verificando conexion
     $sql->connection();
     $result = $sql->del($nbtabla,"solicitud='$vsol' AND nombre LIKE '%$vcod%'".$vcondadd);
     if (!$result)
	   return false;
     else
      return true;
 }

 //elimina un Inventor de la tabla temporal en la base de datos
 function borrarinv($vsol,$vcod,$nbtabla){
     $sql = new mod_db();
     //Verificando conexion
     $sql->connection();
     $result = $sql->del($nbtabla,"solicitud='$vsol' AND numero = $vcod");
     if (!$result)
       return false;
     else
       return true;
 }

 //elimina una Clasificacion de la tabla temporal en la base de datos
 function eliminacla($vsol,$vcod,$nbtabla){
     $sql = new mod_db();
     //Verificando conexion
     $sql->connection();
     $result = $sql->del($nbtabla,"solicitud='$vsol' AND numero = $vcod");
     if (!$result)
	   return false;
     else
      return true;
 }

 //elimina una Prioridad de la tabla temporal en la base de datos
 function eliminapri($vsol,$vcod,$nbtabla,$derecho){
     $sql = new mod_db();
     //Verificando conexion
     $sql->connection();
     $result = $sql->del($nbtabla,"solicitud='$vsol' AND tipo_derecho='$derecho' AND numero = $vcod");
     if (!$result)
	   return false;
     else
      return true;
 }

 //elimina un Equivalente de la tabla temporal en la base de datos
 function elimequiv($vsol,$vcod,$nbtabla){
     $sql = new mod_db();
     //Verificando conexion
     $sql->connection();
     $result = $sql->del($nbtabla,"solicitud='$vsol' AND numero = $vcod");
     if (!$result)
       return false;
     else
       return true;
 }


 //elimina un Titular de la tabla temporal en la base de datos
 function eliminatit($vsol,$vcod,$nbtabla,$derecho){
     $sql = new mod_db();
     //Verificando conexion
     $sql->connection();
     $result = $sql->del($nbtabla,"solicitud='$vsol' AND tipo_derecho='$derecho' AND nombre LIKE '%$vcod%'");
     if (!$result)
	   return false;
     else
      return true;
 }

 //inserta un nuevo empleado en la base de datos
 function crear($vsol,$tipo_persona,$codigo,$vnombre,$fecha_nacim,$domicilio,$pais,$telefono1,$telefono2,$fax,$profesion,$seudonimo,$datos_registro,$cedula_repre){
    
    $result = pg_exec("SELECT * FROM stdtmpso WHERE solicitud='$vsol' ORDER BY nombre");
    $filas_solicita=pg_numrows($result); 
    if ($filas_solicita>0) {
       mensajenew("El Expediente solo puede tener 1 Solicitante...!!!","javascript:history.back();","N");
       return false;}
    
     
    $vnombre = str_replace("'","´",$nombre);
    if ($tipo_persona='N') { 
      $col_campos = "solicitud,tipo_persona,codigo,nombre,fecha_nacim,domicilio,pais,telefono1,telefono2,fax,profesion,seudonimo";
      $insert_str = "'$vsol','$tipo_persona','$codigo','$vnombre','$fecha_nacim','$domicilio','$pais','$telefono1','$telefono2','$fax','$profesion','$seudonimo'"; }
    else { 
      $col_campos = "solicitud,tipo_persona,codigo,nombre,domicilio,pais,telefono1,telefono2,fax,datos_registro,cedula_repre";
      $insert_str = "'$vsol','$tipo_persona','$codigo','$vnombre','$domicilio','$pais','$telefono1','$telefono2','$fax','$datos_registro','$cedula_repre'";
    }
    
    $result = $sql->insert("stdtmpso","$col_campos","$insert_str","");
    if (!$result)
	   return false;
    else
       return true;
 }

 // consulta solicitante por su codigo
 function consultarid($vsol,$cod){
     $result = pg_exec("select * from stdtmpso WHERE solicitud=$vsol AND codigo=$cod");
     if (!$result)
       return false;
     else
       return $result;
 }

}
?>
