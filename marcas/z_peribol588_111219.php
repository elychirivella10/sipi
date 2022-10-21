<?php
// *************************************************************************************
// Programa: z_peribol588.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// creado: 2019 II Semestre 
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

$resultado = false;
//$boletin = 600;
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Boletin Extraordinario de Perencion de Recursos y Acciones por NO Ratificacion por Publicar, Cont. Bol. 588');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$vopc    = $_GET['vopc'];
$boletin = trim($_POST['boletin']);

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
	
  if (empty($boletin)) {
    mensajenew('ERROR: NO indic&oacute; el Bolet&iacute;n a Generar ...!!!','z_prebol588.php','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
	
  $obj_query = $sql->query("SELECT max(nro_boletin) FROM stzboletin WHERE generado='S'");
  $objs = $sql->objects('',$obj_query);
  $vbolult = $objs->max;
  if ($boletin<=$vbolult) {
    mensajenew("ERROR: Bolet&iacute;n '$boletin' ya Generado anteriormente ...!!!","z_prebol588.php","N");
    $smarty->display('pie_pag.tpl'); exit();           
  }
		
  //Recursos y Acciones de Marcas
  $counter= 1;
  $estatus = 1800;
  $evento  = 1865;
  $filas_total = 0;
  while ( $counter <= 22) {

    //Obtención de la Descripcion del Evento
    $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE evento='$evento' AND tipo_mp='M'");
    if (!$obj_query) { 
      mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','z_prebol588.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=$sql->nums('',$obj_query);
    if ($filas_found==0) {
      mensajenew('ERROR: Tabla de Eventos Marcas Vacia ...!!!','z_prebol588.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
    $objs = $sql->objects('',$obj_query);
    $mensa_automatico=$objs->mensa_automatico; 

    $condicion = "SELECT DISTINCT a.nro_derecho,a.solicitud,a.estatus FROM stzderec a, stmmarce b, stzevtrd c";
    $lcWhere = " WHERE a.tipo_mp='M' AND a.estatus='$estatus' AND (a.nro_derecho=b.nro_derecho) AND (a.nro_derecho=c.nro_derecho) AND c.evento = 1195 AND c.documento = 588 AND a.nro_derecho NOT IN (SELECT nro_derecho FROM stzevtrd WHERE evento = 1196)";
    $lcOrder = " ORDER BY 1";

    //La Fecha de Hoy para la transaccion
    $fechahoy = hoy();
    $comentario = "";

    //Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $resultado=pg_exec("$condicion$lcWhere$lcOrder");
    $filas_found=pg_numrows($resultado); 
    //echo "$filas_found ";
    if ($filas_found!=0) {
      $numerror = 0;
      $documento= 0;
      $comentario="";
      $horahoy  = hora();
      $regsol = pg_fetch_array($resultado);
      $filas_total =  $filas_total + $filas_found;
      for($cont=0;$cont<$filas_found;$cont++) 
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
          //Inserto Datos en la tabla de Tramite Stzevtrd
          $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
          $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$estatus','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
          $ins_tram = $sql->insert("$tbname_3","$col_campos","$insert_str","");
          if ($ins_tram) { }
          else { $numerror = $numerror + 1; } 
 
          //Inserto Datos en Tabla Temporal del Boletin
          $insert_campos="nro_derecho,solicitud,boletin,estatus,tipo,usuario,
                          fecha_carga,hora_carga,nanota";
          $insert_valores ="$vder,'$vsol',$boletin,$estatus,'M','$usuario','$fechahoy','$horahoy',0";
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbo WHERE solicitud='$vsol' and 
                               boletin='$boletin' and estatus='$estatus' and tipo='M'");
          $cantfound = pg_numrows($resulfound);
          if ($cantfound==0) {
              $vertra=$sql->insert("stztmpbo","$insert_campos","$insert_valores","");     
              if (!$vertra) { $numerror = $numerror + 1; }
          }
 
        } 
        $regsol = pg_fetch_array($resultado);
      }
    }

    $counter = $counter + 1; 
    if($counter==2)  { $estatus = 1801; $evento  = 1865; }
    if($counter==3)  { $estatus = 1802; $evento  = 1865; }
    if($counter==4)  { $estatus = 1803; $evento  = 1865; }
    if($counter==5)  { $estatus = 1804; $evento  = 1865; }
    if($counter==6)  { $estatus = 1805; $evento  = 1865; }
    if($counter==7)  { $estatus = 1806; $evento  = 1865; }
    if($counter==8)  { $estatus = 1807; $evento  = 1865; }
    if($counter==9)  { $estatus = 1808; $evento  = 1865; }

    if($counter==10) { $estatus = 1809; $evento  = 1867; }
    if($counter==11) { $estatus = 1825; $evento  = 1867; }
    if($counter==12) { $estatus = 1836; $evento  = 1867; }
    if($counter==13) { $estatus = 1837; $evento  = 1867; }

    if($counter==14) { $estatus = 1830; $evento  = 1869; }
    if($counter==15) { $estatus = 1831; $evento  = 1869; }

    if($counter==16) { $estatus = 1821; $evento  = 1871; }
    if($counter==17) { $estatus = 1822; $evento  = 1873; }
    if($counter==18) { $estatus = 1823; $evento  = 1875; }
    if($counter==19) { $estatus = 1824; $evento  = 1877; }
    if($counter==20) { $estatus = 1835; $evento  = 1879; }
    if($counter==21) { $estatus = 1833; $evento  = 1881; }
    if($counter==22) { $estatus = 1838; $evento  = 1883; }

  }//fin del while Recursos y Acciones de Marcas
  $filasmar = $filas_total;
 
  //Recursos y Acciones de Patentes
  $counter= 1;
  $estatus = 2800;
  $evento  = 2865;
  $filas_total = 0;
  while ( $counter <= 15) {

    //Obtención de la Descripcion del Evento
    $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE evento='$evento' AND tipo_mp='P'");
    //echo "SELECT * FROM $tbname_2 WHERE evento='$evento' AND tipo_mp='P'";
    if (!$obj_query) { 
      mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','z_prebol588.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=$sql->nums('',$obj_query);
    if ($filas_found==0) { 
      mensajenew('ERROR: Tabla de Eventos Patentes Vacia ...!!!','z_prebol588.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
    $objs = $sql->objects('',$obj_query);
    $mensa_automatico=$objs->mensa_automatico; 

    $condicion = "SELECT DISTINCT a.nro_derecho,a.solicitud,a.estatus FROM stzderec a, stppatee b, stzevtrd c";
    $lcWhere = " WHERE a.tipo_mp='P' AND a.estatus='$estatus' AND (a.nro_derecho=b.nro_derecho) AND (a.nro_derecho=c.nro_derecho) AND c.evento = 2195 AND c.documento = 588 AND a.nro_derecho NOT IN (SELECT nro_derecho FROM stzevtrd WHERE evento = 2196)";
    $lcOrder = " ORDER BY 1";

    //La Fecha de Hoy para la transaccion
    $fechahoy = hoy();
    $comentario = "";

    //Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $resultado=pg_exec("$condicion$lcWhere$lcOrder");
    $filas_found=pg_numrows($resultado); 
    //echo "$filas_found ";
    if ($filas_found!=0) {
      $numerror = 0;
      $documento= 0;
      $comentario="";
      $horahoy  = hora();
      $regsol = pg_fetch_array($resultado);
      $filas_total =  $filas_total + $filas_found;
      for($cont=0;$cont<$filas_found;$cont++) 
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
          //Inserto Datos en la tabla de Tramite Stzevtrd
          $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
          $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$estatus','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
          $ins_tram = $sql->insert("$tbname_3","$col_campos","$insert_str","");
          if ($ins_tram) { }
          else { $numerror = $numerror + 1; } 
 
          //Inserto Datos en Tabla Temporal del Boletin
          $insert_campos="nro_derecho,solicitud,boletin,estatus,tipo,usuario,
                          fecha_carga,hora_carga,nanota";
          $insert_valores ="$vder,'$vsol',$boletin,$estatus,'P','$usuario','$fechahoy','$horahoy',0";
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbo WHERE solicitud='$vsol' and 
                               boletin='$boletin' and estatus='$estatus' and tipo='P'");
          $cantfound = pg_numrows($resulfound);
          if ($cantfound==0) {
              $vertra=$sql->insert("stztmpbo","$insert_campos","$insert_valores","");     
              if (!$vertra) { $numerror = $numerror + 1; }
          }
 
        } 
        $regsol = pg_fetch_array($resultado);
      }
    }

    $counter = $counter + 1; 
    if($counter==2)  { $estatus = 2801; $evento  = 2865; }
    if($counter==3)  { $estatus = 2802; $evento  = 2865; }
    if($counter==4)  { $estatus = 2804; $evento  = 2865; }
    if($counter==5)  { $estatus = 2805; $evento  = 2865; }
    if($counter==6)  { $estatus = 2806; $evento  = 2865; }
    if($counter==7)  { $estatus = 2840; $evento  = 2865; }

    if($counter==8)  { $estatus = 2809; $evento  = 2867; }
    if($counter==9)  { $estatus = 2821; $evento  = 2867; }

    if($counter==10) { $estatus = 2833; $evento  = 2869; }
    if($counter==11) { $estatus = 2838; $evento  = 2869; }

    if($counter==12) { $estatus = 2835; $evento  = 2871; }
    if($counter==13) { $estatus = 2836; $evento  = 2871; }

    if($counter==14) { $estatus = 2921; $evento  = 2873; }
    if($counter==15) { $estatus = 2922; $evento  = 2873; }

  }//fin del while Recursos y Acciones de Patentes
  $filaspat = $filas_total;
  $filasbol588 = $filasmar+$filaspat;

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filasbol588' SOLICITUDES ACTUALIZADAS CORRECTAMENTE, $filasmar de Marcas, $filaspat de Patentes ...!!!","z_prebol588.php","S");
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
