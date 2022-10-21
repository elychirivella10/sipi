<?php
// *************************************************************************************
// Programa: m_devfosconbol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2014 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha    = fechahoy();

//Variable
$sql = new mod_db();
$tbname_1 = "stmmarce";
$tbname_2 = "stzevder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzderec";

$vopc    = $_GET['vopc'];
$boletin = $_POST['boletin'];
$resultado = false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Devueltas de Fondo Publicadas en Bolet&iacute;n sin Contestaci&oacute;n a Extinguir');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
  $evento    =1091;
  $estatus   =1118; 
  $update_str="";
  //Obtención de la Descripcion del Evento
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE evento='$evento' AND tipo_mp='M'");
  if (!$obj_query) { 
    mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','m_actdevfondo.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('Tabla de Eventos Vacia ...!!!','m_actdevfondo.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $mensa_automatico=$objs->mensa_automatico;
  $tipo_evento=$objs->tipo_evento;

  if ($tipo_evento=="M") {
    //Se obtiene el Estatus Final de la tabla de Migraciones y el derecho "M=Marca, P=Patente"
    $regestfin=estatus_final($evento,$estatus,"M");
    if (!empty($regestfin)) {
      //Fecha de Vencimiento es NULO ya que plazo_ley=0
      $update_str = "estatus='$regestfin',fecha_venc=null"; }
  }

  $condicion = "SELECT DISTINCT ON(stzderec.solicitud) stzderec.solicitud,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.nombre,stmmarce.modalidad,stmmarce.clase,stmmarce.ind_claseni,stzderec.tipo_derecho,stzsolic.nombre as titular FROM stzderec,stzevtrd,stmmarce,stzottid,stzsolic";
  $lcwhere = " WHERE stzderec.nro_derecho = stzevtrd.nro_derecho
                 AND stmmarce.nro_derecho=stzderec.nro_derecho
                 AND stmmarce.nro_derecho=stzottid.nro_derecho
                 AND stzsolic.titular = stzottid.titular    
                 AND stzderec.tipo_mp='M'
                 AND stzderec.estatus=1118 
                 AND stzevtrd.evento IN (1122) 
                 AND stzevtrd.documento=$boletin
                 AND stzderec.solicitud not in 
                    (SELECT stzderec.solicitud from stzderec,stzevtrd 
                      WHERE stzderec.nro_derecho = stzevtrd.nro_derecho 
                        AND stzderec.tipo_mp='M'
                        AND stzderec.estatus=1118 
                        AND stzevtrd.evento=1020)
	         ORDER BY stzderec.solicitud";	

  if (empty($boletin)) {
     //$lcwhere = $lcwhere." AND .documento='$boletin'"; } 
  //else {
     mensajenew('ERROR: N&uacute;mero de Bolet&iacute;n incorrecto o esta vacio ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $comentario = "";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");
  
  $resultado=pg_exec("$condicion$lcwhere");
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_actdevfondo.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew('AVISO: NO existen DATOS Asociados ...!!!','m_actdevfondo.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  { 
    $numerror = 0;
    $regsol = pg_fetch_array($resultado);
    for($cont=0;$cont<$filas_found;$cont++) 
    {
      $ins_tram = true;
      $act_dere = true;
      $horactual= hora();
      $vder = trim($regsol['nro_derecho']);
      $vsol = trim($regsol['solicitud']);
      //Inserto Datos en la tabla de Tramite Stzevtrd
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$estatus','$boletin','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
      $ins_tram = $sql->insert("$tbname_3","$col_campos","$insert_str","");
      //echo "Sol=$vsol -  ";
      //Se actualiza Maestra Principal de Derecho 
      if (!empty($update_str))
        { $act_dere = $sql->update("$tbname_4","$update_str","nro_derecho='$vder' AND estatus=1118"); }

      if ($ins_tram AND $act_dere) { }
      else { $numerror = $numerror + 1; }  

      $regsol = pg_fetch_array($resultado);
    }
  }
  $numerror=0;
  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' SOLICITUDES ACTUALIZADAS CORRECTAMENTE ...!!!","m_actdevfondo.php","S");
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

?>