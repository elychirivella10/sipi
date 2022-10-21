<?php
// *************************************************************************************
// Programa: p_perpusol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado II Semestre 2009 BD - Relacional   
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
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol1h=$_POST["vsol1h"];
$varsol2h=$_POST["vsol2h"];
$vestatus=$_POST['estatus'];
$resultado=false;

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Perenci&oacute;n de Patentes por NO Consignar Publicaci&oacute;n en Prensa x Rango');
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
    mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('Tabla de Eventos Vacia ...!!!','p_perisol.php','N');
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
  $vsol1 = $varsol1."-".$varsol2;
  $vsol2 = $varsol1h."-".$varsol2h;
  
  $condicion = "SELECT stzderec.nro_derecho,stzderec.solicitud,stzderec.estatus FROM stzderec,stppatee";
  $lcwhere = " WHERE tipo_mp='P' AND stzderec.estatus=$vestatus AND (stzderec.solicitud>='$vsol1' AND stzderec.solicitud<='$vsol2') AND (stzderec.nro_derecho=stppatee.nro_derecho)";

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $comentario = "PROCEDIMIENTO DE PUBLICACION EN PRENSA PERIMIDO.";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("$condicion$lcwhere");
  if (!$resultado) { 
    mensajenew('Error al Procesar la Busqueda ...!!!','p_perisol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) { 
    mensajenew('NO existen DATOS Asociados ...!!!','p_perisol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  {
    $numerror = 0;
    $regsol = pg_fetch_array($resultado);
    for($cont=0;$cont<$filas_found;$cont++) 
    {
      $vdoc = 0; 
      $ins_tram = true;
      $act_dere = true;
      $horactual=hora();
      $vder = trim($regsol['nro_derecho']);
      $estatus_ant= $regsol['estatus'];
      
      //Obtención Orden de Publicacion del Boletin de la Solicitud de Patentes
      $obj_query = $sql->query("SELECT documento FROM $tbname_3 WHERE nro_derecho='$vder' AND evento=2201");
      if (!$obj_query) { 
        Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas=$sql->nums('',$obj_query);
      if ($filas==0) {
        Mensajenew("No existe el Evento 201 de Tramite para la Solicitud ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
        $objs = $sql->objects('',$obj_query);
      $vdoc = $objs->documento;
      
      //Inserto Datos en la tabla de Tramite Stpevtrd
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$estatus_ant','$vdoc','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
      $ins_tram =  $sql->insert("$tbname_3","$col_campos","$insert_str","");
      
      //Se actualiza Maestra Principal de Derecho  
      if (!empty($update_str))
        { $act_dere = $sql->update("$tbname_5","$update_str","nro_derecho='$vder' AND estatus = $vestatus"); }

      if ($ins_tram AND $act_dere) { }
      else { $numerror = $numerror + 1; }  
        
      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew('DATOS ACTUALIZADOS CORRECTAMENTE!!!','p_perisol.php','S');
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