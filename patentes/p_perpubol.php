<?php
// *************************************************************************************
// Programa: p_perpubol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// Modificado I Semestre 2009 BD - Relacional   
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
$tbname_1 = "stppatee";
$tbname_2 = "stzevder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzstder";
$tbname_5 = "stzderec";

$vopc=$_GET['vopc'];
$boletin=$_POST['boletin'];
$resultado=false;

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Perenci&oacute;n de Patentes por NO Consignar Publicaci&oacute;n en Prensa x Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
  $evento    = 2034;
  $update_str="";
  //Obtención de la Descripcion del Evento
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE evento='$evento'");
  if (!$obj_query) { 
    mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('ERROR: Tabla de Eventos Vacia ...!!!','index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $mensa_automatico=$objs->mensa_automatico;
  $tipo_evento=$objs->tipo_evento;

  if ($tipo_evento=="M") {
    //Se obtiene el Estatus Final de la tabla de Migraciones y el derecho "M=Marca, P=Patente"
    $regestfin = 2030;
    //estatus_final($evento,$estatus,"M");
    if (!empty($regestfin)) {
      //Fecha de Vencimiento es NULO ya que plazo_ley=0
      $update_str = "estatus='$regestfin',fecha_venc=null"; }
  }
  //$condicion = "SELECT stppatee.solicitud,stppatee.estatus FROM stppatee,stpevtrd";
  //$lcwhere = " WHERE (stppatee.solicitud=stpevtrd.solicitud) AND stppatee.estatus IN (4,5,11) AND stpevtrd.evento in (201,22,23) AND stpevtrd.estat_ant in (2,4,5)";
  $condicion = "SELECT stzderec.nro_derecho,stzderec.solicitud,stzderec.estatus FROM stzderec,stzevtrd";
  $lcwhere = " WHERE stzderec.tipo_mp='P' AND stzderec.estatus IN (2004,2005,2011) AND (stzderec.nro_derecho=stzevtrd.nro_derecho) AND stzevtrd.evento in (2201,2022,2023) AND stzevtrd.estat_ant in (2002,2004,2005)";

  if (!empty($boletin)) {
     $lcwhere = $lcwhere." AND stzevtrd.documento='$boletin'"; } 
  else {
     mensajenew('ERROR: N&uacute;mero de Bolet&iacute;n esta vacio o errado ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $comentario = "PROCEDIMIENTO DE PUBLICACION EN PRENSA PERIMIDO.";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("$condicion$lcwhere");
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','p_peribol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew('AVISO: NO existen DATOS Asociados ...!!!','p_peribol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  { 
    $numerror = 0;
    $regsol = pg_fetch_array($resultado);
    for($cont=0;$cont<$filas_found;$cont++) 
    { 
      $ins_tram = true;
      $act_dere = true;
      $horactual=hora();
      $vder = trim($regsol['nro_derecho']);
      $estatus_ant= $regsol['estatus'];
      //Inserto Datos en la tabla de Tramite Stpevtrd
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$estatus_ant','$boletin','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
      $ins_tram =  $sql->insert("$tbname_3","$col_campos","$insert_str","");
      
      //Se actualiza Maestra Principal de Derecho  
      if (!empty($update_str))
        { $act_dere = $sql->update("$tbname_5","$update_str","nro_derecho='$vder' AND estatus in (2004,2005,2011)"); }

      if ($ins_tram AND $act_dere) { }
      else { $numerror = $numerror + 1; }  
        
      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew('DATOS ACTUALIZADOS CORRECTAMENTE!!!','p_peribol.php','S');
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
