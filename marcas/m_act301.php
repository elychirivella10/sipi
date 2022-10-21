<?php
// *************************************************************************************
// Programa: m_nulcan600.php
// Realizado por el Analista de Sistema Romulo Mendoza 
// Direccion de Sistemas / SAPI / MPPCN
// II Semestre Año: 2020
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
$resultado = false;
$tbname_2 = "stzevder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzderec";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizacion de Cancelaciones 301 a Caducidad 316');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) 
{

  //Verificando conexion
  $sql = new mod_db();
  $sql->connection($usuario);

  $evento   = 1316;
  $estatus  = 1846;
  $update_str="";
  //Obtención de la Descripcion del Evento
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE evento='$evento' AND tipo_mp='M'");
  if (!$obj_query) { 
    mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','m_act301.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('Tabla de Eventos Vacia ...!!!','m_act301.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $mensa_automatico=$objs->mensa_automatico;
  $tipo_evento=$objs->tipo_evento;

  $condicion = "SELECT a.nro_derecho,a.solicitud,a.estatus,b.estat_ant,b.evento,b.fecha_event FROM stzderec a,stzevtrd b";
  $lcwhere = " WHERE a.tipo_mp='M' AND a.estatus=1830 AND (a.nro_derecho=b.nro_derecho) AND b.evento IN (1301) AND (fecha_event>='17/09/2008' AND fecha_event<='21/02/2021') ORDER BY b.fecha_event,a.solicitud";

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $comentario = "";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("$condicion$lcwhere");
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_act301.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 

  if ($filas_found==0) {
    mensajenew('ERROR: NO existen DATOS Asociados ...!!!','m_act301.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else
  {
    $numerror  = 0;
    $update_str  = "estatus='1846'";
    $update_str1 = "evento=1316, desc_evento='SOLICITUD DE ACCION DE CADUCIDAD POR NO USO'";
    $regsol = pg_fetch_array($resultado);
    //for($cont=0;$cont<1;$cont++) 
    for($cont=0;$cont<$filas_found;$cont++) 
    {
      $act_tram = true;
      $act_dere = true;
      $horactual= hora();
      $vder      = trim($regsol['nro_derecho']); 
      $nsol      = trim($regsol['solicitud']); 
         
      //Verificacion de si ya le fue cargado la decision en tramite
      $obj_query2 = $sql->query("SELECT * FROM $tbname_3 WHERE nro_derecho='$vder' AND evento='$evento' AND (fecha_event>='17/09/2008' AND fecha_event<='21/02/2021')");
      if (!$obj_query2) { 
        mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!','m_act301.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_303=$sql->nums('',$obj_query2);
      if ($filas_303==0) {
        //Actualizo Datos en la tabla de Tramite Stzevtrd
        $act_tram = $sql->update("$tbname_3","$update_str1","nro_derecho='$vder' AND evento=1301");
        //echo "$nsol - $update_str - $update_str1 ";

        //Se actualiza Maestra Principal de Derecho 
        if (!empty($update_str)) { 
         $act_dere = $sql->update("$tbname_4","$update_str","nro_derecho='$vder' AND estatus=1830"); 
        }

        if ($act_tram AND $act_dere) { }
        else { $numerror = $numerror + 1; }  
      }
      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' SOLICITUDES ACTUALIZADAS CORRECTAMENTE ...!!!","m_act301.php","S");
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

//Paso de asignacion de variables de encabezados
$smarty->assign('varfocus','forcaduca.boletin'); 

$smarty->display('m_act301.tpl');
$smarty->display('pie_pag.tpl');
?>

