<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n  de Devoluciones de Registro a Publicar para Ventura');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$usuario=$_POST["usuario"];
$vbol   =$_POST["boletin"]; 

//Validacion de Boletin a Generar 
$obj_query = $sql->query("SELECT max(nro_boletin) FROM stzboletin");
$objs = $sql->objects('',$obj_query);
$vbolult = $objs->max;
if ($vbol<$vbolult) {
  $smarty->display('encabezado1.tpl');
  mensajenew("ERROR: Bolet&iacute;n '$vbol' ya Generado anteriormente ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit();           
}

$where='';
// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecsold","fecsolh");
  $valores = array($fecsold,$fecsolh);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

$esmayor=compara_fechas($fecsold,$fecsolh);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($usuario)) { 
	   $where = $where." and"." ( stzevtrd.usuario = '$usuario')";	}

// Armando el query segun las opciones
$resultado=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud, stzderec.nombre, stmmarce.clase, stzderec.registro, stzsolic.nombre as titular, stzderec.agente, trim(tramitante) as tramitante, stzevtrd.comentario
			FROM  stmmarce, stzottid, stzsolic, stzderec, stzevtrd, stztmpbor		
         WHERE stzevtrd.evento = '1502' $where
			AND stzevtrd.fecha_trans >='$fecsold' AND stzevtrd.fecha_trans <='$fecsolh'
			AND stzevtrd.nro_derecho = stzderec.nro_derecho 
			AND stzevtrd.nro_derecho = stmmarce.nro_derecho 
			AND stzevtrd.nro_derecho = stztmpbor.nro_derecho
			AND stzevtrd.documento   = stztmpbor.documento
			AND stmmarce.nro_derecho = stzottid.nro_derecho
			AND stzsolic.titular = stzottid.titular
         ORDER BY stzderec.registro ");	

//verificando que consiguio los datos necesarios
if (!$resultado)    { 
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Devoluciones de Registro a Publicar ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Datos asociados para Generar ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$reg = pg_fetch_array($resultado);
$cantreg=pg_numrows($resultado); 

//generacion del TXT 
 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
 $archivo = $archivo."***TRIM***"."\n";
 $archivo = $archivo."***TRIM***"."\n";
 $archivo = $archivo."***TRIM***"."\n";
 $archivo = $archivo."***TRIM***"."\n";
 $archivo = $archivo."@TITUL00=Devoluciones de Registro a Publicar (Anotaciones Marginales)= "."\n"."\n";
 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
 $archivo = $archivo."@TIT_02=<B>CLASE<D>"."\n"."\n";
 $archivo = $archivo."@TIT_03=<B>MARCA<D>"."\n"."\n";
 $archivo = $archivo."@TIT_04=<B>TRAMITANTE.<D>"."\n"."\n";
 $archivo = $archivo."@TIT_05=<B>TITULAR<D>"."\n"."\n";
 $archivo = $archivo."***TRIM***"."\n"."\n";
 $archivo = $archivo."@SEPARADOR="."\n"."\n";

 $traerr  = 0;
 $tipanota="T";
 $vtip    = 1564; 
 $horahoy = hora();
 $fechahoy = hoy();
 for ($cont=0;$cont<$cantreg;$cont++) {
 	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
   $tram = agente_tram($reg['agente'],$reg['tramitante'],($ind='1'));
 	$archivo = $archivo."@COL_04=".trim($tram)."\n"."\n";
  	$archivo = $archivo."@COL_05=".$reg['titular']."\n"."\n";      
   $archivo = $archivo."\n";

   $vder=$reg[nro_derecho];
   $vsol=$reg[solicitud];
   $vreg=$reg[registro];
   $vanota=$reg[comentario];
   $vanota=substr($vanota,0,1);
   if ($vanota=="O") { $vanota="D"; }  
   $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                  fecha_carga,hora_carga,nanota,tipo_anota,resolucion";
   $insert_valores ="$vder,'$vsol','$vreg',$vbol,$vtip,'M','$login','$fechahoy','$horahoy',0,'$vanota',0";
          
   //No grabar cuando la solicitud exista en el temporal
   $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' AND 
                               boletin='$vbol' AND estatus='$vtip' AND tipo='M'");
   $cantfound = pg_numrows($resulfound);
   if ($cantfound==0) {
    $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
    if (!$vertra) {$traerr=$traerr+1;}
   }
       
   $reg = pg_fetch_array($resultado); 
 }

 $archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 $via= "../../";
 $via1= "boletin/";
 $fecha= strftime("%d-%m-%y,%T");
 $open = fopen($via.$via1.'devregam'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
 fputs($open, "$archivo");
 fclose($open);

//Desconexion a la base de datos
$smarty->display('encabezado1.tpl');
mensajebrowse("Proceso Terminado...!!",'m_pgendevreg.php');
$smarty->display('pie_pag.tpl');
$sql->disconnect();exit(); 

?>
