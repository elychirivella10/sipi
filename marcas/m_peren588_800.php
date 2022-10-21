<?php
// *************************************************************************************
// Programa: m_peren588_800.php
// Realizado por el Analista de Sistema Romulo Mendoza 
// Direccion de Sistemas / SAPI / MPPCN
// Desarrollo Año: 2020 II Semestre
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

//Variables
$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$vopc    = $_GET['vopc'];
$boletin = $_POST['boletin'];
$resultado = false;
$tbname_2 = "stzevder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzderec";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Perencion de Procedimiento Recursos/Acciones - Bol. 588 III Parte/Estatus 800');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($usuario!='rmendoza') {
  mensajenew('AVISO: Opci&oacute;n del Sistema ya Ejecutada, y Bloqueada ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit();
}

if ($vopc==2) 
{
  if (empty($boletin)) {
     mensajenew('AVISO: Error en el N&uacute;mero de Bolet&iacute;n o esta vacio ...!!!','m_peren588_800.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //Verificando conexion
  $sql = new mod_db();
  $sql->connection($usuario);

  $boletin  = 588;
  $evento   = 1197;
  $estatus  = 1800;
  $regestfin = 1600;      
  $update_str="";
  //Obtención de la Descripcion del Evento
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE evento='$evento' AND tipo_mp='M'");
  if (!$obj_query) { 
    mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','m_peren588_800.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('ERROR: Tabla de Eventos Vacia ...!!!','m_peren588_800.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $mensa_automatico=$objs->mensa_automatico;
  $tipo_evento=$objs->tipo_evento;

  $condicion = "SELECT a.nro_derecho,a.solicitud,a.estatus,b.estat_ant FROM stzderec a,stzevtrd b";
  $lcwhere = " WHERE a.tipo_mp='M' AND a.estatus=1800 AND (a.nro_derecho=b.nro_derecho) AND b.evento IN (1197) AND documento='588' AND usuario='lcrodriguez' AND fecha_trans='09/02/2021' AND fecha_event='09/02/2021' ORDER BY a.solicitud";

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $comentario = "";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("$condicion$lcwhere");
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_peren588_800.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 

  if ($filas_found==0) {
    mensajenew('ERROR: NO existen DATOS Asociados ...!!!','m_peren588_800.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else
  {
    $numerror  = 0;
    $regsol = pg_fetch_array($resultado);
    //for($cont=0;$cont<5;$cont++) 
    for($cont=0;$cont<$filas_found;$cont++) 
    {
      $act_dere = true;
      $horactual= hora();
      $vder      = trim($regsol['nro_derecho']); 
      $nsol     = trim($regsol['solicitud']); 
      $update_str = "estatus='$regestfin'";

      //Verificacion de si ya le fue cargado la decision en tramite
      $obj_query2 = $sql->query("SELECT * FROM $tbname_3 WHERE nro_derecho='$vder' AND evento='$evento'");
      if (!$obj_query2) { 
        mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!','m_peren588_800.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_197=$sql->nums('',$obj_query2);
      if ($filas_197!=0) {
        $act_dere = $sql->update("$tbname_4","$update_str","nro_derecho='$vder' AND estatus=1800"); 
        //echo "$nsol - $vder /";
        if ($act_dere) { }
        else { $numerror = $numerror + 1; }  
      }
      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' SOLICITUDES ACTUALIZADAS CORRECTAMENTE ...!!!","m_peren588_800.php","S");
    $smarty->display('pie_pag.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
    Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","m_peren588_800.php","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

}

//Paso de asignacion de variables de encabezados
$smarty->assign('campo6','Boletin:');
$smarty->assign('varfocus','forcaduca.boletin'); 

$smarty->display('m_peren588_800.tpl');
$smarty->display('pie_pag.tpl');
?>

