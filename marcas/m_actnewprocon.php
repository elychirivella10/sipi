<?php
// *************************************************************************************
// Programa: m_devsconbol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado Año: 2009 II Semestre 
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
$tbname_5 = "stmforfon";

$vopc    = $_GET['vopc'];
$boletin = $_POST['boletin'];
$resultado = false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizaci&oacute;n a Concedidas por Nuevo Procedimiento de Forma/Fondo por Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
  $evento    =1051;
  $estatus   =1008; 
  $update_str="";
  //Obtención de la Descripcion del Evento
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE evento='$evento' AND tipo_mp='M'");
  if (!$obj_query) { 
    mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','m_actconnewpro.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('Tabla de Eventos Vacia ...!!!','m_actdevscon.php','N');
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
  //$condicion = "SELECT a.nro_derecho,a.solicitud,a.estatus FROM stzderec a,stzevtrd b";
  //$condicion = "SELECT stmmarce.solicitud,stmmarce.estatus FROM stmmarce,stmevtrd";

  $condicion = "SELECT stzderec.nro_derecho FROM stzevtrd,stzderec "; 
//  $lcwhere   = " WHERE evento=1124 AND estat_ant=1006 AND estatus=1008 AND documento=$boletin
//                   AND stzevtrd.nro_derecho=stzderec.nro_derecho 
//                   AND stzderec.nro_derecho in (SELECT nro_derecho FROM stmforfon WHERE evento=1051)";
  $lcwhere   = " WHERE evento IN (1124,1095) AND estat_ant IN (1006,1027) AND estatus=1008 AND documento=$boletin
                   AND stzevtrd.nro_derecho=stzderec.nro_derecho 
                   AND stzderec.nro_derecho in (SELECT nro_derecho FROM stmforfon WHERE evento=1051)";

  if (empty($boletin)) {
     mensajenew('Error en el N&uacute;mero de Bolet&iacute;n o esta vacio ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $comentario = "";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");
  
  $resultado=pg_exec("$condicion$lcwhere");
  //echo "query = $condicion$lcwhere";
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_actconnewpro.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  //echo "son $filas_found "; exit();
  if ($filas_found==0) {
    mensajenew('ERROR: NO existen DATOS Asociados ...!!!','m_actconnewpro.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  { 
    $numerror = 0;
    $regsol = pg_fetch_array($resultado);
    //for($cont=0;$cont<2;$cont++) 
    for($cont=0;$cont<$filas_found;$cont++) 
    {
      $ins_tram = true;
      $act_dere = true;
      $act_forfon = true;
      $horactual= hora();
      $vder = trim($regsol['nro_derecho']);

      $obj_query = $sql->query("SELECT * FROM $tbname_5 WHERE nro_derecho='$vder' AND evento='1051'");
      $objs = $sql->objects('',$obj_query);
      $usuario_examinador=$objs->usuario;
      $vsolicitud=$objs->solicitud;
      //echo "Solicitud= $vsolicitud";
      
      //Inserto Datos en la tabla de Tramite Stzevtrd
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$estatus',0,'$fechahoy','$usuario_examinador','$mensa_automatico','$comentario','$horactual'";
      $ins_tram = $sql->insert("$tbname_3","$col_campos","$insert_str","");

      //Se actualiza Maestra Principal de Derecho 
      if (!empty($update_str))
        { $act_dere = $sql->update("$tbname_4","$update_str","nro_derecho='$vder' AND estatus=1008"); }

      $update_str1 = "estado='C'";
      $act_forfon = $sql->update("$tbname_5","$update_str1","nro_derecho='$vder' AND evento='1051'");

      if ($ins_tram AND $act_dere AND $act_forfon) { }
      else { $numerror = $numerror + 1; }  

      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' SOLICITUDES ACTUALIZADAS CORRECTAMENTE ...!!!","m_actconnewpro.php","S");
    $smarty->display('pie_pag.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

}

?>
