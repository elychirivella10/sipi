<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo','Sistema de Marcas');
//$smarty->assign('subtitulo','Listado de Marcas Presentadas Mensual');
$smarty->assign('subtitulo','Listado de Marcas Publicadas Mensual');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Captura Variables leidas en formulario inicial  
$mes     = $_POST["tipo"];
$vano    = $_POST["vano"];
$nconex  = $_POST['nconex'];
$boletin = $_POST["vbol"]; 

$mes = '*'; 

//Validacion de Entrada
//if ($mes=='' || $vano=='') {
if ($boletin=='') {
   $smarty->display('encabezado1.tpl');
   mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

   if ($mes=='ENERO') {$mes='01';}
   if ($mes=='FEBRERO') {$mes='02';}
   if ($mes=='MARZO') {$mes='03';}
   if ($mes=='ABRIL') {$mes='04';}
   if ($mes=='MAYO') {$mes='05';}
   if ($mes=='JUNIO') {$mes='06';}
   if ($mes=='JULIO') {$mes='07';}
   if ($mes=='AGOSTO') {$mes='08';}
   if ($mes=='SEPTIEMBRE') {$mes='09';}
   if ($mes=='OCTUBRE') {$mes='10';}
   if ($mes=='NOVIEMBRE') {$mes='11';}
   if ($mes=='DICIEMBRE') {$mes='12';}

//Query
   //$resul=pg_exec("SELECT stzderec.nro_derecho, stzderec.solicitud, stzderec.nombre, stmmarce.clase,stmmarce.ind_claseni,stzderec.agente, stzderec.tramitante, stzderec.pais_resid	
	//FROM  stmmarce, stzderec
	//WHERE ((EXTRACT(YEAR FROM stzderec.fecha_solic) = '$vano') and (EXTRACT(MONTH FROM stzderec.fecha_solic) = '$mes')) and (stzderec.nro_derecho = stmmarce.nro_derecho) and stzderec.estatus=1008 
	//ORDER BY stmmarce.ind_claseni,stmmarce.clase, stzderec.solicitud");

   // Cambiado el dia 30/12/2009 pore orden de Arlen Pinate y la Registradora por Ley 
   // Ahora corresponde al boletin publicado en el mes pedido ...  
   $resul=pg_exec("SELECT stzderec.nro_derecho, stzderec.solicitud, stzderec.nombre, stmmarce.clase,stmmarce.ind_claseni,stzderec.agente, stzderec.tramitante, stzderec.pais_resid	
	FROM  stmmarce, stzderec, stzevtrd 
	WHERE stzderec.tipo_mp = 'M' AND stzevtrd.evento in (1124) AND 
	(stzderec.nro_derecho = stmmarce.nro_derecho) AND 
   (stzderec.nro_derecho = stzevtrd.nro_derecho) AND 
    stzevtrd.estat_ant in (1006) AND
    stzevtrd.documento = $boletin
	ORDER BY stmmarce.ind_claseni,stmmarce.clase, stzderec.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
 		$smarty->display('encabezado1.tpl');
		//mensaje('No Existen Solicitudes Presentadas en el Mes','javascript:history.back();','N');
      mensaje('No Existen Solicitudes Publicadas en el Mes','javascript:history.back();','N');
		$smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
	 else {
         $reg = pg_fetch_array($resul); 


// Encabezado del listado
	 $archivo = "SAPI"."\n"."\n";
	 //$archivo = $archivo."                         Listado de Marcas Presentadas en el Mes"."\n";
	 $archivo = $archivo."                         Listado de Marcas Publicadas como Solicitadas en el Mes"."\n";
	 $archivo = $archivo."                         ----------------------------------------"."\n"."\n";
	 $archivo = $archivo."\n"."\n";
	 $archivo = $archivo."\n"."\n";

//Datos del Listado 
         $clase=0;
         for ($cont=0;$cont<$cantreg;$cont++) {
	 $nderec=$reg['nro_derecho'];
	 $nagen=$reg['agente'];
         if ($clase!=$reg[clase]) {
	 $archivo = $archivo."*********************************************************"."\n";
	 $archivo = $archivo."                     CLASE       ".$reg['clase']."  ".$reg['ind_claseni']."\n";
	 $archivo = $archivo."*********************************************************"."\n";
         $clase=$reg[clase];
	 $archivo = $archivo."\n"."\n";
         }

         //busqueda del nombre de la marca
         $archivo = $archivo.trim($reg[nombre])."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
	       $titular= $titular.trim($regt['nombre']); }
	   else {  $titular= $titular.trim($regt['nombre'])." / "; }                
	   $regt = pg_fetch_array($res_titular);
	} 

	 $archivo = $archivo.$titular."\n";
	//busqueda del pais de residencia
	$pais_nombre=pais($reg['pais_resid']);
  	$archivo = $archivo.$pais_nombre."\n";  
  
	//busqueda del tramitante
        $res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$nagen'");
	$regage = pg_fetch_array($res_agen);
	if ($regage['agente']<=0)
           { $tram = trim($reg['tramitante']);}
	if ($regage['agente']>0)
	   { $tram= trim(sprintf($regage['nombre']));}

	$archivo = $archivo."AGENTE: ".$tram."\n"."\n";
		   	   
        $reg = pg_fetch_array($resul); 
        $archivo = $archivo."\n"."\n";
         }
	
	$open = fopen('documentos/'.'REVPRO.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

// Mensaje final
$smarty->assign('n_conex',$nconex);  
if ($cont=$cantreg) {
   $smarty->display('encabezado1.tpl');
   mensaje('Proceso Terminado...!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Desconexion a la base de datos
  $sql->disconnect(); 
  exit(); 

?>
