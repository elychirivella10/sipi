<?php
// *************************************************************************************
// Programa: z_prebol588.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// Año: 2019 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

$tbname_1  = "stzevtrd";
$tbname_2  = "stzderec";
$tbname_3  = "stzevder";

$vopc    = $_GET['vopc'];
$boletin = trim($_POST['boletin']);
$tipbol  = "O";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizaci&oacute;n Botet&iacute;n Ordinario Caducidad por Falta de Uso Ratificadas/NO Ratificadas Bol. 600');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) 
{
	
  if (empty($boletin)) {
    mensajenew('ERROR: NO indic&oacute; el Bolet&iacute;n a Generar ...!!!','z_actcanbol600.php','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //Verificando conexion
  $sql = new mod_db();
  $sql->connection($usuario);

  $obj_query = $sql->query("SELECT * FROM stzboletin WHERE nro_boletin=$boletin");
  $bol_found=$sql->nums('',$obj_query);

  if ($bol_found==0) {
    mensajenew("ERROR: Bolet&iacute;n '$boletin' NO Existe o NO Generado ...!!!","z_actcanbol600.php","N");
    $smarty->display('pie_pag.tpl'); exit();           
  }
  $objs = $sql->objects('',$obj_query);
  $tipoboletin = $objs->tipo_boletin;

  if ($tipoboletin!='O') {
    mensajenew("ERROR: Bolet&iacute;n NO Corresponde a un Ordinario ...!!!","z_actcanbol600.php","N");
    $smarty->display('pie_pag.tpl'); exit();           
  }

  //Recursos y Acciones de Marcas
  $counter = 1;
  $filas_total = 0;
  $fechabol ="07/02/2020";
  while ( $counter <= 2) {

    if($counter==1)  { 
    $estatus = 1830;
    $evento = 1312;
    $estat_ant = 1830;
    $estatus_fin= 1842;
    $condicion = "SELECT DISTINCT a.nro_derecho,a.solicitud,a.estatus FROM stztmpbor a";
    $lcWhere = " WHERE a.tipo='M' AND a.estatus='$estatus'";
    $lcOrder = " ORDER BY 2";

    //La Fecha de Hoy para la transaccion
    $fechahoy = hoy();
    $comentario = "";

    //Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $resultado=pg_exec("$condicion$lcWhere$lcOrder");
    $filas_qfound=pg_numrows($resultado); 
    //echo "$filas_found ";
    if ($filas_qfound!=0) {
      $numerror = 0;
      $documento= 0;
      $comentario="";
      $horahoy  = hora();
      $evento  = 1312;
      $comentario = "AVISO EN BOLETIN DE SOLICITUD DE CADUCIDAD POR NO USO.";
      
      //Obtención de la Descripcion del Evento
      $obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE evento='$evento' AND tipo_mp='M'");
      if (!$obj_query) { 
        mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','z_actcanbol600.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_found=$sql->nums('',$obj_query);
      if ($filas_found==0) {
        mensajenew('ERROR: Tabla de Eventos Marcas Vacia ...!!!','z_actcanbol600.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
      $objs = $sql->objects('',$obj_query);
      $mensa_automatico=$objs->mensa_automatico; 
      
      $regsol = pg_fetch_array($resultado);
      $filas_total =  $filas_total + $filas_qfound;
      for($cont=0;$cont<$filas_qfound;$cont++) 
      {
        $ins_tram = true;
        $act_dere = true;
        $horactual= hora();
        $vsol = trim($regsol['solicitud']);
        $vder = trim($regsol['nro_derecho']); 
        //echo "$condicion$lcWhere$lcOrder DERECHO= $vder, $vsol "; 
        //exit();

        //Verificacion si ya fue cargado o no el evento de perimida por publicar
        $obj_queryver = $sql->query("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento='$evento'");
        $evento_found=$sql->nums('',$obj_queryver);
        if ($evento_found==0) {
 
          //Inserto Datos en la tabla de Tramite stzevtrd
          $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
          $insert_str = "$vder,1312,'$fechabol',nextval('stzevtrd_secuencial_seq'),1830,'$fechahoy','$usuario','$mensa_automatico',600,'$comentario','$horactual'";
          $instram = $sql->insert("$tbname_1","$col_campos","$insert_str",""); 
          
          //Actualizo la maestra en estatus a 842
          $update_str = "estatus=1842";
          $actestat = $sql->update("$tbname_2","$update_str","nro_derecho=$vder");
        } 
        $regsol = pg_fetch_array($resultado);
      }
    }
    } //Fin counter 1

    if($counter==2)  { 
    $estatus = 1831;
    $evento = 1312;
    $estat_ant = 1831;
    $estatus_fin= 1842;
    $condicion = "SELECT DISTINCT a.nro_derecho,a.solicitud,a.estatus FROM stztmpbor a";
    $lcWhere = " WHERE a.tipo='M' AND a.estatus='$estatus'";
    $lcOrder = " ORDER BY 2";

    //La Fecha de Hoy para la transaccion
    $fechahoy = hoy();
    $comentario = "";

    //Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $resultado=pg_exec("$condicion$lcWhere$lcOrder");
    $filas_qfound=pg_numrows($resultado); 
    //echo "$filas_found ";
    if ($filas_qfound!=0) {
      $numerror = 0;
      $documento= 0;
      $comentario="";
      $horahoy  = hora();
      $evento  = 1312;
      $comentario = "AVISO EN BOLETIN DE SOLICITUD DE CADUCIDAD POR NO USO.";
      
      //Obtención de la Descripcion del Evento
      $obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE evento='$evento' AND tipo_mp='M'");
      if (!$obj_query) { 
        mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','z_actcanbol600.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_found=$sql->nums('',$obj_query);
      if ($filas_found==0) {
        mensajenew('ERROR: Tabla de Eventos Marcas Vacia ...!!!','z_actcanbol600.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
      $objs = $sql->objects('',$obj_query);
      $mensa_automatico=$objs->mensa_automatico; 
      
      $regsol = pg_fetch_array($resultado);
      $filas_total =  $filas_total + $filas_qfound;
      for($cont=0;$cont<$filas_qfound;$cont++) 
      {
        $ins_tram = true;
        $act_dere = true;
        $horactual= hora();
        $vsol = trim($regsol['solicitud']);
        $vder = trim($regsol['nro_derecho']); 
        //echo "$condicion$lcWhere$lcOrder DERECHO= $vder, $vsol "; 
        //exit();

        //Verificacion si ya fue cargado o no el evento de perimida por publicar
        $obj_queryver = $sql->query("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento='$evento'");
        $evento_found=$sql->nums('',$obj_queryver);
        if ($evento_found==0) {
 
          //Inserto Datos en la tabla de Tramite stzevtrd
          $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
          $insert_str = "$vder,1312,'$fechabol',nextval('stzevtrd_secuencial_seq'),1831,'$fechahoy','$usuario','$mensa_automatico',600,'$comentario','$horactual'";
          $instram = $sql->insert("$tbname_1","$col_campos","$insert_str",""); 
          
          //Actualizo la maestra en estatus a 842
          $update_str = "estatus=1842";
          $actestat = $sql->update("$tbname_2","$update_str","nro_derecho=$vder");
        } 
        $regsol = pg_fetch_array($resultado);
      }
    }
    } //Fin counter 2
    
    $counter = $counter + 1; 

  }//fin del while Recursos y Acciones de Marcas

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_total' SOLICITUDES GENERADAS CORRECTAMENTE  ...!!!","z_actcanbol600.php","S");
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

$smarty->assign('lboletin','Bolet&iacute;n:'); 
$smarty->display('z_actcanbol600.tpl');
$smarty->display('pie_pag.tpl');

?>
