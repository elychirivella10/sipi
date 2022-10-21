<script language="Javascript"> 
function pregunta() { 
  return confirm('Estas seguro de transferir la Informacion ?'); }
</script> 

<?php
// *************************************************************************************
// Programa: m_fondotxt1.php 
// Realizado por el Ing. Romulo Mendoza - Profesional II 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado I Semestre 2015 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo  = "m_fondotxt1.php";
$vopc    = $_GET['vopc'];
$vsol1   = $_POST["vsol1"];
$vsol2   = $_POST["vsol2"];
$vsol1h  = $_POST["vsol1h"];
$vsol2h  = $_POST["vsol2h"];
$fecsold = $_POST["fecsold"];
$fecsolh = $_POST["fecsolh"];

//Encabezado
//$substmar="Subsistema de Marcas";
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n de Archivo TXT Solicitudes para Forma/Fondo');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) {
 $sql = new mod_db();
 $sql -> connection($usuario);
 $fechahoy = Hoy();
 $where="stzderec.estatus=1001 AND stzderec.tipo_mp='M' AND stmmarce.modalidad IN ('D','M') AND stzderec.nro_derecho=stmmarce.nro_derecho ";

 $vsold=sprintf("%04d-%06d",$vsol1,$vsol2);
 $vsolh=sprintf("%04d-%06d",$vsol1h,$vsol2h);

 if ($vsolh <$vsold){ 
   mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 if ($fecsolh <$fecsold){ 
   mensajenew('ERROR: Rango de Fechas de solicitud erroneo ...!!!','javascript:history.back();','N');    
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

 if (($vsold=='0000-000000') &&  ($vsolh=='0000-000000') && empty($fecsold) && empty($fecsolh)) { 
   mensajenew('ERROR: Debe ingresar un Rango de Solicitudes y/o Fechas para buscar y generar archivo ...!!!','javascript:history.back();','N');    
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 	
 }

 $punt=0;
 if ($vsold == '0000-000000') { $punt=1; }
 if ($vsolh == '0000-000000') { $punt=1; }

 if (($punt!=1) and (!empty($vsold) and !empty($vsolh))) { 
	if(!empty($where)) {
	   $where = $where." AND"." ((stzderec.solicitud >= '$vsold') AND (stzderec.solicitud <='$vsolh'))";
	}
	else { 
	   $where = $where." ((stzderec.solicitud >= '$vsold') AND (stzderec.solicitud <='$vsolh'))";
	}
 }
 
 if(!empty($fecsold) and !empty($fecsolh)) { 
	if(!empty($where)) {
	   $where = $where." AND"." ((stzderec.fecha_solic >= '$fecsold') AND (stzderec.fecha_solic <='$fecsolh'))";
	}
	else { 
	   $where = $where." ((stzderec.fecha_solic >= '$fecsold') AND (stzderec.fecha_solic <='$fecsolh'))";
	}
 }

 $separador="|";
 //RUTA Para el archivo TXT 
 $via= "../../";
 $via1= "pedidosexternos/";
 $filesal = 'fondosol.txt';
 //Genero el archivo TXT 
 $open = fopen($via.$via1.$filesal,"w+") or die ("Error de lectura");

 //Genero el listado segun la petición
 $query = "SELECT stzderec.solicitud FROM stzderec,stmmarce WHERE $where ORDER BY 1"; 

 //Ejecuto la Consulta 
 $resul=pg_exec($query);
 $cantreg = pg_numrows($resul);

 if ($cantreg==0) {
   $mensaje=$mensaje."No existen Solicitudes Nuevas ...!!!"; }
 else {
   $archivo="";				    	
   $npag = 0;	
   while ($row=pg_fetch_array($resul)){
     $vsol = $row['solicitud'];
     $vanno = substr($vsol,2,2); 
     $vnumero=substr($vsol,-6,6);
     $vexp = $vanno.'-'.$vnumero;  
     $archivo = $archivo.$vexp.$separador.$separador.$fechahoy.$separador.$npag.$separador.$usuario."\n";
   } 
   //Lo escribo en el TXT
   fputs($open, "$archivo");
   fclose($open);		
 } 

 $cmd="scp /var/www/apl/pedidosexternos/fondosol.txt www-data@192.8.18.19:/home/taquilla/"; 
 exec($cmd,$salida);
 foreach($salida as $line) { 
 echo "Holaa<br>";	
 echo "$line<br>"; }

 $sql->disconnect();
 Mensajenew("TOTAL SOLICITUDES GENERADAS: ".$cantreg,"m_fondotxt1.php",'S');
 $smarty->display('pie_pag2.tpl');
 exit();  
}

$smarty->assign('campo1','Solicitud:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo2','Fecha de Solicitud:');
$smarty->assign('varfocus','foravzcri.vsol1'); 

$smarty->display('m_fondotxt1.tpl');
$smarty->display('pie_pag.tpl');
?>
