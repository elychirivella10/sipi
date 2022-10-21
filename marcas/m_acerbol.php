<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// *************************************************************************************
// Programa: m_acerbol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$sql     = new mod_db();

$tbname_1 = "stmmarce";
$tbname_2 = "stzevder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzderec";
$evento   = 1839; 

$vopc     = $_GET['vopc'];
$desdec   = $_POST["desdec"];
$hastac   = $_POST["hastac"];
$boletin  = $_POST['boletin'];
//$fechabol = $_POST["fechabol"];
$fechabol = $_POST["vfpub"];
$resultado= false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizaci&oacute;n de Certificados');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('varfocus','formarcas2.desdec'); 
$smarty->assign('modo2','readonly');

//Verificando conexion
$sql->connection($usuario);

//Se verifica si el usuario puede o no actualizar por lotes
$aplica = even_rol($role,$evento);
if ($aplica==0) {
    mensajenew('ERROR: El Usuario NO tiene permiso para Actualizar Certificados ...!!!','../index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

if ($vopc==1) {
  //La Fecha de Hoy para la transaccion y calculos de fechas de vencimientos
  $fechahoy = hoy();

  //Validacion en el Rango de Fecha
  $esmayor=compara_fechas($desdec,$hastac);
  if ($esmayor==1) {
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  $esmayor=compara_fechas($fechabol,$fechahoy);
  if ($esmayor==1) {
     mensajenew('ERROR: NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit();  } 

  $resultado=pg_exec("SELECT * FROM $tbname_2 WHERE evento='$evento'");
  $filas_found   = pg_numrows($resultado); 
  $regeve        = pg_fetch_array($resultado);
  $tipo_evento   = $regeve['tipo_evento'];
  $inf_adicional = trim($regeve['inf_adicional']);
  $mensa_automatico = trim($regeve['mensa_automatico']);
  $tipo_plazo    = $regeve['tipo_plazo'];
  $plazo_ley     = $regeve['plazo_ley'];
  $documento=0;
  $comentario="CERTIFICADO DE REGISTRO NOTIFICADO EN BOLETIN";
  
  //Obtención de los Expedientes a Actualizar
  $obj_query=$sql->query("SELECT distinct a.nro_derecho,a.solicitud,a.estatus
                          FROM stzderec a, stzevtrd b 
                          WHERE a.nro_derecho=b.nro_derecho AND 
                                a.estatus = 1555 AND
                                b.evento = 1838 AND
                               (b.fecha_trans >= '$desdec' AND 
                                b.fecha_trans <= '$hastac')
                          ORDER BY a.solicitud");
                                  
 if (!$obj_query) { 
    mensajenew('ERROR: Problema al realizar la consulta en la Base de Datos ...!!!','index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    Mensage_Error("AVISO: Ningun Expediente recuperado para actualizar ...!!!");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $numerror = 0;
  $objs = $sql->objects('',$obj_query);
  for($cont=0;$cont<$filas_found;$cont++) 
  { 
    $ins_tram = true;    
    $horactual= hora();

    $vder=$objs->nro_derecho;    
    //Inserto Datos en la tabla de Tramite Stzevtrd
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
    $insert_str = "'$vder','$evento','$fechabol',nextval('stzevtrd_secuencial_seq'),1555,'$boletin','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
    $ins_tram = $sql->insert("$tbname_3","$col_campos","$insert_str","");

    if ($ins_tram) { }
    else { $numerror = $numerror + 1; }  
    
    $objs = $sql->objects('',$obj_query);
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' REGISTROS ACTUALIZADOS CORRECTAMENTE ...!!!",'m_acerbol.php','S');
    $smarty->display('pie_pag.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Fecha de Transaccion:');
$smarty->assign('campo2','Desde:');
$smarty->assign('campo3','Hasta:');
$smarty->assign('campo4','Boletin:');
$smarty->assign('campo5','Fecha de Boletin:');
$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);

$smarty->display('m_acerbol.tpl');
$smarty->display('pie_pag.tpl');

?>