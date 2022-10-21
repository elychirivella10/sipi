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
$boletin = $_POST['boletin'];
$resultado = false;
$tbname_2 = "stzevder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzderec";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Notificacion de Cancelaciones Resolucion 31, Bol. 600 a Anular');
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
     mensajenew('AVISO: Error en el N&uacute;mero de Bolet&iacute;n o esta vacio ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //Verificando conexion
  $sql = new mod_db();
  $sql->connection($usuario);

  $boletin  = 600;
  $evento   = 1303;
  $estatus  = 1842;
  $update_str="";
  //Obtención de la Descripcion del Evento
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE evento='$evento' AND tipo_mp='M'");
  if (!$obj_query) { 
    mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','m_nulcad31_600.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('Tabla de Eventos Vacia ...!!!','m_nulcan600.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $mensa_automatico=$objs->mensa_automatico;
  $tipo_evento=$objs->tipo_evento;

  $condicion = "SELECT a.nro_derecho,a.solicitud,a.estatus,b.estat_ant FROM stzderec a,stzevtrd b";
  $lcwhere = " WHERE a.tipo_mp='M' AND a.estatus=1842 AND (a.nro_derecho=b.nro_derecho) AND b.evento IN (1312) AND documento='600' AND fecha_trans='27/02/2020' AND fecha_event='07/02/2020' AND usuario='ehernandez' ORDER BY a.solicitud";

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $comentario = "";
  $fechabol="18/09/2020";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("$condicion$lcwhere");
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_nulcad31_600.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 

  if ($filas_found==0) {
    mensajenew('ERROR: NO existen DATOS Asociados ...!!!','m_nulcad31_600.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else
  {
    $numerror  = 0;
    $documento =602;
    $regestfin =1830;
    $comentario= "NULIDAD DE OFICIO PUBLICADA EN EL BOLETÍN N°602 DE 18/09/2020, RESOLUCIÓN N° 124, TOMO XII, PÁGINAS 2-20, MEDIANTE LA CUAL:  RECONOCER LA NULIDAD ABSOLUTA, de las que están revestidas tanto la Resolución N° 030.2020, publicada en el Boletín Extraordinario de la Propiedad Industrial N.º 2, Tomo I, de fecha 10/02/2020, pp 82-84, como las Resoluciones Nros. 29, 31 y 32, todas de fecha 03/02/2020, publicadas en el Boletín N.º 600 de fecha 07/02/2020, Tomo V, pp 59-77. Y ASÍ SE DECIDE";
    $regsol = pg_fetch_array($resultado);
    //for($cont=0;$cont<1;$cont++) 
    for($cont=0;$cont<$filas_found;$cont++) 
    {
      $ins_tram = true;
      $act_dere = true;
      $horactual= hora();
      $vder      = trim($regsol['nro_derecho']); 
      $nsol      = trim($regsol['solicitud']); 
         
      $regestfin = $regsol['estat_ant'];      
      $update_str = "estatus='$regestfin'";

      //Verificacion de si ya le fue cargado la decision en tramite
      $obj_query2 = $sql->query("SELECT * FROM $tbname_3 WHERE nro_derecho='$vder' AND evento='$evento' AND documento='$documento' AND fecha_event='$fechabol'");
      if (!$obj_query2) { 
        mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!','m_nulcad31_600.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_303=$sql->nums('',$obj_query2);
      if ($filas_303==0) {
        //Inserto Datos en la tabla de Tramite Stzevtrd
        $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
        $insert_str = "'$vder','$evento','$fechabol',nextval('stzevtrd_secuencial_seq'),'$estatus','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
        $ins_tram = $sql->insert("$tbname_3","$col_campos","$insert_str","");
        //echo "$nsol -- $update_str -- $insert_str";

        //Se actualiza Maestra Principal de Derecho 
        if (!empty($update_str)) { 
         $act_dere = $sql->update("$tbname_4","$update_str","nro_derecho='$vder' AND estatus=1842"); 
        }

        if ($ins_tram AND $act_dere) { }
        else { $numerror = $numerror + 1; }  
      }
      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' SOLICITUDES ACTUALIZADAS CORRECTAMENTE ...!!!","m_nulcad31_600.php","S");
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
$smarty->assign('campo6','Boletin:');
$smarty->assign('varfocus','forcaduca.boletin'); 

$smarty->display('m_nulcad31_600.tpl');
$smarty->display('pie_pag.tpl');
?>

