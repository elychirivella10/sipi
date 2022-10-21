<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

//Variables de sesion
$login    = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$fecha    = fechahoy();
$fechahoy = hoy();

//Pantalla
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Consulta de Certificados ya Elaborados en txt');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);
  
//Validacion de Entrada
$desde  =$_POST["desdet"];
$hasta  =$_POST["hastat"];
$usuario=$_POST["usuario"];
$vbol   =$_POST["boletin"]; 
$nconex =$_POST['nconex'];

//Validacion de Boletin a Generar 
$obj_query = $sql->query("SELECT max(nro_boletin) FROM stzboletin");
$objs = $sql->objects('',$obj_query);
$vbolult = $objs->max;
if ($vbol<$vbolult) {
  $smarty->display('encabezado1.tpl');
  mensajenew("ERROR: Bolet&iacute;n '$vbol' ya Generado anteriormente ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit();           
}

//Query para buscar las opciones deseadas
$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
  $smarty->display('encabezado1.tpl');
  mensajenew('Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

// Armando el query
if ((!empty($desde)) and (!empty($hasta)) and (!empty($usuario))) {

$where = $where." and stzderec.nro_derecho=stmmarce.nro_derecho";
$where = $where." and stzderec.nro_derecho=stzevtrd.nro_derecho";
$where = $where." and stzderec.nro_derecho=stzottid.nro_derecho";
$where = $where." and stmmarce.nro_derecho=stzottid.nro_derecho";
$where = $where." and stzsolic.titular = stzottid.titular";

$resultado=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud,stzderec.nombre,stmmarce.clase, stzderec.registro, substr(stzsolic.nombre,1,120) as ntitular,stzevtrd.documento, stzottid.nacionalidad,stzottid.domicilio
			   FROM  stmmarce, stzevtrd, stzottid, stzsolic, stzderec
			   WHERE stzevtrd.fecha_trans between '$desde' and '$hasta'  AND
				stzevtrd.usuario = '$usuario' AND
				stzevtrd.evento = '1838' AND
				stzderec.estatus = '1555' AND
				stzderec.tipo_mp = 'M' AND
				stzderec.nro_derecho=stmmarce.nro_derecho AND	
				stzderec.nro_derecho=stzevtrd.nro_derecho AND
				stzderec.nro_derecho=stzottid.nro_derecho AND
				stmmarce.nro_derecho=stzottid.nro_derecho AND
				stzsolic.titular = stzottid.titular
			   ORDER BY registro");		
}

else {
 if ((!empty($desde)) and (!empty($hasta))) {
$resultado=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud,stzderec.nombre,stmmarce.clase, stzderec.registro, substr(stzsolic.nombre,1,120) as ntitular,stzevtrd.documento,
stzottid.nacionalidad,stzottid.domicilio
			   FROM  stmmarce, stzevtrd, stzottid, stzsolic, stzderec
			   WHERE stzevtrd.fecha_trans between '$desde' and '$hasta'  AND
				stzevtrd.evento = '1838' AND
				stzderec.estatus = '1555' AND
				stzderec.tipo_mp = 'M' AND
				stzderec.nro_derecho=stmmarce.nro_derecho AND	
				stzderec.nro_derecho=stzevtrd.nro_derecho AND
				stzderec.nro_derecho=stzottid.nro_derecho AND
				stmmarce.nro_derecho=stzottid.nro_derecho AND
				stzsolic.titular = stzottid.titular
			   ORDER BY registro");
}}
				 
//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

//Inicio de Reporte en Txt
$smarty->assign('n_conex',$nconex); 
$archivo = $archivo."Listado de Certificados Eleborados"."\n";
$archivo = $archivo."Registro|Solicitud|Clase|Nombre|Titular|Doc"."\n";

$vtip    = 1563; 
$horahoy = hora();
$traerr  = 0;
$tipanota="T";
$titular='';
for ($cont=0;$cont<$filas_resultado;$cont++) {
  $pais_nombre=pais($registro['nacionalidad']);
  if ($cont=='0'){
      $titular= $titular.trim($registro['ntitular']).'.'.trim($registro['domicilio']).','.trim($pais_nombre); }
  else { $titular= $titular.", ".trim($registro['ntitular']).'.'.trim($registro['domicilio']).','.trim($pais_nombre); }                
  $archivo = $archivo.$registro[registro]."|".$registro[solicitud]."|".$registro[clase]."|".trim($registro[nombre])."|".trim($titular)."|".$registro[documento]."\n";

  $vder=$registro[nro_derecho];
  $vsol=$registro[solicitud];
  $vreg=$registro[registro];
  
  $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                  fecha_carga,hora_carga,nanota,tipo_anota,resolucion";
  $insert_valores ="$vder,'$vsol','$vreg',$vbol,$vtip,'M','$login','$fechahoy','$horahoy',0,'$tipanota',0";
          
  //No grabar cuando la solicitud exista en el temporal
  $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' AND 
                              boletin='$vbol' AND estatus='$vtip' AND tipo='M'");
  $cantfound = pg_numrows($resulfound);
  if ($cantfound==0) {
     $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
     if (!$vertra) {$traerr=$traerr+1;}
  }
  $titular='';   
  $registro = pg_fetch_array($resultado); 
}

$via= "../../";
$via1= "boletin/";
$fecha= strftime("%d-%m-%y,%T");
$open = fopen($via.$via1.'certfelab'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
fputs($open, "$archivo");
fclose($open);

if ($cont=$filas_resultado) {
   $smarty->display('encabezado1.tpl');
   mensaje('Proceso Terminado...!!','m_rptpcertxt.php');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 

?>
