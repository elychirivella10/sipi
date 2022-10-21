<?php
// *************************************************************************************
// Programa: m_obsconbol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Variable
$sql = new mod_db();
$tbname_1 = "stmmarce";
$tbname_2 = "stzevder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzderec";

$vopc=$_GET['vopc'];
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol1h=$_POST["vsol1h"];
$varsol2h=$_POST["vsol2h"];
$boletin=trim($_POST["boletin"]);
$tipo=$_POST["tipo"];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Oposiciones sin Contestaci&oacute;n a Desistir por Ley');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
  $evento    =1250;
  $estatus   =1120; 
  $update_str="";

  $vsold  = trim($varsol1."-".$varsol2);
  $vsolh  = trim($varsol1h."-".$varsol2h);
  $where  = "estatus=1120 AND tipo_mp='M' "; 
  $from   = 'stzderec';
  $where1 = "((stzderec.solicitud>='$vsold') AND (stzderec.solicitud<='$vsolh')) AND stzderec.tipo_mp='M' AND stzevtrd.evento=1048 ";
  $where1 = $where1." AND"." (stzderec.nro_derecho=stzevtrd.nro_derecho)";

  if ($tipo=='MARCA DE PRODUCTO')      {$tipo='M';}
  if ($tipo=='NOMBRE COMERCIAL')       {$tipo='N';}
  if ($tipo=='DENOMINACION COMERCIAL') {$tipo='D';}
  if ($tipo=='LEMA COMERCIAL')         {$tipo='L';}
  if ($tipo=='MARCA DE SERVICIO')      {$tipo='S';}
  if ($tipo=='MARCA COLECTIVA')        {$tipo='C';}
  if ($tipo=='DENOMINACION DE ORIGEN') {$tipo='O';}

  $punt='0';
  if ($vsold=='-') { $punt='1'; }
  if ($vsolh=='-') { $punt='1'; }

  if ((($vsold=='-') OR ($vsolh=='-')) AND (empty($boletin))) {
    mensajenew('ERROR: No selecciono criterio para actualizar ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  
  if ($vsolh<$vsold){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if (!empty($vsold) and !empty($vsolh) and ($punt=='0')) { 
    if(!empty($where)) {
      $where = $where." AND"." ((stzderec.solicitud >= '$vsold') AND (stzderec.solicitud <='$vsolh'))";
      //$where1 = $where1." and"." ((stzevtrd.solicitud >= '$vsold') AND (stmevtrd.solicitud <='$vsolh'))";
      //$where1 = $where1." AND"." (stzderec.nro_derecho=stzevtrd.nro_derecho)";
    }
    else { 
      $where = $where." ((stzderec.solicitud >= '$vsold') AND (stzderec.solicitud <='$vsolh'))";
    }
  }

  if(!empty($boletin)) { 
    if(!empty($where)) {
      $from = $from.", stzevtrd";    
      $where = $where." AND"." (stzevtrd.documento = '$boletin')"." AND (stzevtrd.nro_derecho=stzderec.nro_derecho) AND stzevtrd.evento=1122 AND stzevtrd.estat_ant=1003 ";
    }
    else { 
      $from = $from.", stzevtrd"; 
      $where = $where." (stzevtrd.documento = '$boletin')"." AND (stzevtrd.nro_derecho=stzderec.nro_derecho) AND stzevtrd.evento=1122 AND stzevtrd.estat_ant=1003 ";
    }
  }

  if(!empty($tipo)) { 
    if(!empty($where)) {
      $where = $where." AND"." (stzderec.tipo_derecho = '$tipo')"; } 
    else { 
      $where = $where." (stzderec.tipo_derecho = '$tipo')"; }
  }

  //Obtención de la Descripcion del Evento
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE evento='$evento' AND tipo_mp='M'");
  if (!$obj_query) { 
    mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('Tabla de Eventos Vacia ...!!!','index1.php','N');
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

  //Query para buscar las opciones deseadas
  // Armando el query segun las opciones
  //$resultado=pg_exec("SELECT DISTINCT stmmarce.solicitud FROM $from WHERE $where 
  //                    AND  stmmarce.solicitud not in (select distinct solicitud from stmevtrd where $where1) ORDER BY stmmarce.solicitud ");	

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("SELECT DISTINCT stzderec.solicitud, stzderec.nro_derecho FROM $from WHERE $where 
                      AND  stzderec.solicitud NOT IN (select distinct solicitud FROM stzderec,stzevtrd WHERE $where1) ORDER BY stzderec.solicitud ");
                      	
  $cadenaq = "SELECT DISTINCT stzderec.solicitud, stzderec.nro_derecho FROM $from WHERE $where 
                      AND  stzderec.solicitud NOT IN (select distinct solicitud FROM stzderec,stzevtrd WHERE $where1) ORDER BY stzderec.solicitud ";
                      
  //verificando los resultados
  if (!$resultado)    { 
     mensajenew('Error: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=pg_numrows($resultado); 

  //echo "$update_str - $cadenaq - $filas_found "; exit();

  if ($filas_found==0)    {
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  { 
    //La Fecha de Hoy para la transaccion
    $doc = 0;
    $fechahoy = hoy();
    $comentario = "OPOSICION NO CONTESTADA";
    //echo "filas= $filas_found en $cadenaq "; exit();
    $numerror = 0;
    $regsol = pg_fetch_array($resultado);
    for($cont=0;$cont<$filas_found;$cont++) 
    //for($cont=0;$cont<15;$cont++) 
    { 
      $ins_tram = true;
      $act_dere = true;
      $horactual= hora();
      //$vsolicitud = trim($regsol['solicitud']);
      $vder = trim($regsol['nro_derecho']);
      //Inserto Datos en la tabla de Tramite Stmevtrd
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$estatus','$doc','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
      $ins_tram = $sql->insert("$tbname_3","$col_campos","$insert_str","");

      //Se actualiza Maestra Principal de Derecho  
      if (!empty($update_str))
        { $act_dere = $sql->update("$tbname_4","$update_str","nro_derecho='$vder' AND estatus=1120"); }

      if ($ins_tram AND $act_dere) { }
      else { $numerror = $numerror + 1; }  

      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_actobscon.php','S');
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
