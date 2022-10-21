<?php
// *************************************************************************************
// Programa: m_actpubsin81.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// creado: 2016 II Semestre 
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
$smarty->assign('subtitulo','Actualizacion a Solicitadas, Observadas No Ratificadas sin Evento 81');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
  $evento  = 1072;
  $estatus = 1124;
  $update_str="";
  //Obtención de la Descripcion del Evento
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE evento='$evento' AND tipo_mp='M'");
  if (!$obj_query) { 
    mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','m_actobsinev81.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('Tabla de Eventos Vacia ...!!!','m_actobsinev81.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $mensa_automatico=$objs->mensa_automatico;
  $tipo_evento=$objs->tipo_evento;

  if ($tipo_evento=="M") {
    //Se obtiene el Estatus Final de la tabla de Migraciones y el derecho "M=Marca, P=Patente"
    $regestfin=estatus_final($evento,$estatus,"M");
    if (!empty($regestfin)) {
      //Fecha de Vencimiento es NULO ya que plazo_ley=0
      $update_str = "estatus='$regestfin'"; }
  }
  $condicion = "SELECT nro_derecho,solicitud,estatus FROM stzderec";
  $lcWhere = " WHERE tipo_mp='M' AND estatus IN (1124) AND nro_derecho NOT IN (SELECT nro_derecho FROM stzevtrd WHERE evento = 1081)";
  $lcOrder = " ORDER BY 2";

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $comentario = "";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("$condicion$lcWhere$lcOrder");
  if (!$resultado) { 
    mensajenew('Error al Procesar la Busqueda ...!!!','m_actobsinev81.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 

  if ($filas_found==0) {
    mensajenew('ERROR: NO existen DATOS Asociados ...!!!','m_actobsinev81.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else
  {
    $numerror = 0;
    $documento= 0;
    $comentario="Pasa a Continuaci&oacute;n de Tr&aacute;mite por no ratificacion de observacion/oposicion.";
    $regsol = pg_fetch_array($resultado);
    //$filas_found = 1;
    //for($cont=0;$cont<1;$cont++) 
    for($cont=0;$cont<$filas_found;$cont++) 
    {
      $ins_tram = true;
      $act_dere = true;
      $horactual= hora();
      $vsol = trim($regsol['solicitud']);
      $vder = trim($regsol['nro_derecho']); //echo "DERECHO= $vder, $vsol "; exit();
      //Inserto Datos en la tabla de Tramite Stzevtrd
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$estatus','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
      $ins_tram = $sql->insert("$tbname_3","$col_campos","$insert_str","");

      //Se actualiza Maestra Principal de Derecho 
      if (!empty($update_str))
        { $act_dere = $sql->update("$tbname_4","$update_str","nro_derecho='$vder' AND tipo_mp='M' AND estatus=1124"); }

      if ($ins_tram AND $act_dere) { }
      else { $numerror = $numerror + 1; }  
      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' SOLICITUDES ACTUALIZADAS CORRECTAMENTE ...!!!","m_actobsinev81.php","S");
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
