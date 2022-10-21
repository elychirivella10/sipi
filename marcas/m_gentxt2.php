<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }
vvvvvvv;;;
//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n  de las Negadas para Ventura');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$vsol3=$_POST['vsol3'];
$vsol4=$_POST['vsol4'];
$vsola=sprintf($vsol1.'-'.$vsol2);
$vsolb=sprintf($vsol3.'-'.$vsol4);
$articulo=$_POST["articulo"];
$literal=$_POST["literal"];
$boletin=$_POST["boletin"];

//colocado el 08/02/07 por RM 
if ($articulo==176 || $articulo==177 || $articulo==178) {
  if ($boletin==''|| $vsola==''|| $vsolb=='' ) {
    $smarty->display('encabezado1.tpl');
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } }
else {    
if ($articulo==''|| $boletin==''|| $vsola==''|| $vsolb=='' ) {
    $smarty->display('encabezado1.tpl');
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } }
	 
//colocado el 08/02/07 por RM 
// Armando el query segun las opciones
if ($articulo=='176' || $articulo=='177' || $articulo=='178') {
      $resultado=pg_exec("SELECT stmmarce.clase,stztmpbo.solicitud, stmliaor.*, stzderec.tramitante, stzderec.agente, stzderec.nombre
			FROM stmmarce,stmliaor, stztmpbo, stzderec	
			WHERE stztmpbo.solicitud between '$vsola' and '$vsolb'
			AND stztmpbo.estatus = '1102'
			AND stztmpbo.boletin = '$boletin'
			AND stztmpbo.tipo = 'M'
			AND stmmarce.nro_derecho = stztmpbo.nro_derecho
			AND stztmpbo.nro_derecho = stmliaor.nro_derecho
			AND stztmpbo.nro_derecho = stzderec.nro_derecho
			AND stmliaor.articulo = '$articulo'
			ORDER BY stztmpbo.solicitud,stmliaor.articulo"); }   
else {
      $resultado=pg_exec("SELECT stmmarce.clase,stztmpbo.solicitud, stmliaor.*,stzderec.tramitante, stzderec.agente, stzderec.nombre
			FROM stmmarce,stmliaor, stztmpbo, stzderec
			WHERE stztmpbo.solicitud between '$vsola' and '$vsolb'
			AND stztmpbo.estatus = '1102'
			AND stztmpbo.boletin = '$boletin'
			AND stztmpbo.tipo = 'M'
			AND stmmarce.nro_derecho = stztmpbo.nro_derecho
			AND stztmpbo.nro_derecho = stmliaor.nro_derecho
			AND stztmpbo.nro_derecho = stzderec.nro_derecho
			AND stmliaor.articulo = '$articulo'
			AND stmliaor.literal = '$literal'
			ORDER BY stztmpbo.solicitud,stmliaor.articulo, stmliaor.literal"); }	   

//verificando que consiguio los datos necesarios
if (!$resultado)    { 
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Negadas ...!!!','m_pgentxt.php','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Datos asociados para Generar ...!!!','m_pgentxt.php','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;
$tab="     ";

//generacion del TXT 
$cantreg = pg_numrows($resultado);
$archivo = "Solicitud".$tab."Clase".$tab."Nombre de la Marca".$tab."Nombre del Titular"."\n"."\n";
$archivo =$archivo."---------------------------------------------------------------------------------------
"."\n";

if ((($articulo== '136') AND ($literal== 'a' OR $literal == 'b' OR $literal== 'c')) OR
    (($articulo== '33') AND ($literal==11))) {
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$nagen=$registro['agente'];
	$nderec=$registro['nro_derecho'];
        if (empty($nagen)) {$nagen=0;}
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad,
                                       stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular."; ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	//
	$archivo = $archivo.$registro['solicitud'].$tab.$registro['clase'].$tab.trim($registro['nombre']).$tab.$titular."\n";

	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro['tramitante'],'1');
	$archivo = $archivo."Tramitante: ".trim($tram)."\n"; //}
   			   
	//Registros Negantes
   // Modificado el 12/08/2010 por Romulo Mendoza, estaba incompleto ... 
	//$reg_neg=pg_exec("SELECT * FROM stzderec WHERE registro='$registro[reg_base]' ");
   $reg_neg=pg_exec("SELECT stzderec.nro_derecho,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni FROM stzderec,stmmarce WHERE registro='$registro[reg_base]' AND stzderec.tipo_mp='M' AND stmmarce.nro_derecho = stzderec.nro_derecho");   
   $reg = pg_fetch_array($reg_neg);

   $regneg=trim($registro['reg_base']);
   if (!empty($regneg)){

  	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$reg[nro_derecho]'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
	       $titular= $titular.trim($regt['nombre']); }
	   else { $titular= $titular."; ".trim($regt['nombre']); }                
	   $regt = pg_fetch_array($res_titular);
	} 

     $archivo = $archivo."Registros Negantes: ".$registro['reg_base']." Clase: ".$reg['clase']." ".$reg['ind_claseni']." ".trim($reg['nombre'])." Titular: ".$titular."\n"."\n";
	}

	else {

	//comentario
	 $reg_com=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$registro[nro_derecho]' and evento='1225' ");   
	$reg_com = pg_fetch_array($reg_com);
        $archivo = $archivo."Registros Negantes: ".trim($reg_com['comentario'])."\n";

       }

  $registro = pg_fetch_array($resultado);
  }

}

else {
 for($cont=0;$cont<$filas_resultado;$cont++) { 
      $nagen=$registro['agente'];
      $nderec=$registro['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}
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
	   else { $titular= $titular."; ".trim($regt['nombre']); }                
	   $regt = pg_fetch_array($res_titular);
	} 

	$archivo = $archivo.$registro['solicitud'].$tab.$registro['clase'].$tab.trim($registro['nombre']).$tab.$titular."\n";

	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro['tramitante'],'1');
	$archivo = $archivo."Tramitante: ".trim($tram)."\n";//}
	
	//comentario
	 $reg=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$registro[nro_derecho]' and evento='1225' ");   
	 $reg = pg_fetch_array($reg);
         $archivo = $archivo."Comentario: ".trim($reg['comentario'])."\n";

   $registro = pg_fetch_array($resultado);
  }
}

//Creacion de archivo
$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
$via= "../../";
$via1= "boletin/";
$fecha= strftime("%d-%m-%y,%T");
$open = fopen($via.$via1.'neg'.$articulo.'_'.$literal.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
fputs($open, "$archivo");
fclose($open);

//Desconexion a la base de datos
$smarty->display('encabezado1.tpl');
mensajebrowse("Proceso Terminado...!!",'m_pgentxt.php');
$smarty->display('pie_pag.tpl');
$sql->disconnect();exit(); 

?>
