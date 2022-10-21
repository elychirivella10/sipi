<?php
// *************************************************************************************
// Programa: m_pubprenbol.php
// Realizado por el Analista de Sistema Romulo Mendoza 
// Direccion de Sistemas / SAPI / MPPCN
// I Semestre Año: 2021
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
$tbname_1 = "stmpagopren";
$tbname_2 = "stzevtrd";
$tbname_3 = "stzderec";
$tbname_4 = "stzevder";
$tbname_5 = "stzfactram";

$sede     = 3;
$vext     = "N";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Publicación en Prensa Digital del SAPI x Vigencia Boletin Año => 2021');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) 
{
  if (empty($boletin)) {
     mensajenew('AVISO: Error en el N&uacute;mero de Bolet&iacute;n o esta vacio ...!!!','m_pubprenbol.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if ($boletin<607) {
     mensajenew('AVISO: Error en el N&uacute;mero de Bolet&iacute;n, Aplica para Boletines desde el 607 ...!!!','m_pubprenbol.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //Verificando conexion
  $sql = new mod_db();
  $sql->connection($usuario);

  //Verificacion de Proceso Ejecutado
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE documento='$boletin' AND evento='1215'");
  if (!$obj_query) { 
    mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','m_pubprenbol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  /*if ($filas_found!=0) {
    $objs = $sql->objects('',$obj_query);
    $fechatrans=$objs->fecha_trans;
    mensajenew('ERROR: Proceso Ejecutado el dia '.$fechatrans.' con '.$filas_found.' solicitudes enviadas a Prensa Digital ...!!!','m_pubprenbol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  */

  $evento   = 1215;
  //Obtención de la Descripcion del Evento
  $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE evento='$evento' AND tipo_mp='M'");
  if (!$obj_query) { 
    mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','m_pubprenbol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('ERROR: Tabla de Tramtes o Cronologia Vacia ...!!!','m_pubprenbol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $mensa_automatico=$objs->mensa_automatico;
  $tipo_evento=$objs->tipo_evento;

  //Datos del Boletin
  $resultado=pg_exec("SELECT * FROM stzboletin WHERE nro_boletin = $boletin");
  $filas_bol = pg_numrows($resultado);
  if ($filas_bol==0) {
    $smarty->display('encabezado2.tpl');
    mensajenew('AVISO: Boletin NO Existe o NO ha sido Generado o no ha sido Actualizado ...!!!','m_pubprenbol.php','N');
    $smarty->display('pie_pag.tpl'); exit();
  } else {
  $regbol = pg_fetch_array($resultado);
  $fecha_vbol = $regbol['fecha_vig']; }
  $fecha_ven2m = trim($regbol['fecha_2meses']);
  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();

  if ($fecha_ven2m == '') {  
    mensajenew('ERROR: Bolet&iacute;n No. '.$boletin.' NO ha entrado en Vigencia aun ...!!!','m_pubprenbol.php','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($fechahoy==$fecha_vbol) { }
  else {
    $esmayor=compara_fechas($fechahoy,$fecha_vbol); 
    if ($esmayor == 0) {
       mensajenew('AVISO: Boletin aun NO Vigente para este proceso de Prensa Digital Automatico ...!!!','m_pubprenbol.php','N');
       $smarty->display('pie_pag.tpl'); exit();
    }
  }

  $esmayor=compara_fechas($fechahoy,$fecha_ven2m);
  if ($esmayor == 1) {
    mensajenew("ERROR: Proceso de envio a Difusion de Publicacion en Prensa Extemporaneo, NO puede ser ejecutado ...!!!","m_pubprenbol.php","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

  $condicion = "SELECT a.nro_derecho,a.solicitud,a.estatus FROM stzderec a,stzevtrd b";
  $lcwhere = " WHERE a.tipo_mp='M' AND a.estatus=1004 AND solicitud >='2021-000001' AND b.estat_ant=1002 AND (a.nro_derecho=b.nro_derecho) AND b.evento IN (1201) AND documento='$boletin' ORDER BY a.solicitud";

  //$condicion = " select * from stztmpbo ";
  //$lcwhere = " WHERE boletin=607 AND tipo='M' AND estatus=1002 AND solicitud >='2021-000001' ORDER BY solicitud";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("$condicion$lcwhere");
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_pubprenbol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 

  if ($filas_found==0) {
    mensajenew('ERROR: NO existen DATOS Asociados ...!!!','m_pubprenbol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else
  { 
    $numerror  = 0;
    $regsol = pg_fetch_array($resultado);

    //for($cont=0;$cont<4;$cont++) 
    for($cont=0;$cont<$filas_found;$cont++) 
    {
      $ins_tram  = true;
      $ins_prensa= true;
      $horactual = hora();
      $vder      = trim($regsol['nro_derecho']); 
      $nsol      = trim($regsol['solicitud']); 
      $vsta      = trim($regsol['estatus']); 
        
      $filas_prensa =0;
      //Verificacion de si ya fue cargado la solicitud a publicar en prensa
      $obj_prensa = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder' AND boletin='$boletin'");
      $filas_prensa = $sql->nums('',$obj_prensa);
      if ($filas_prensa==0) {

        $filas_found200 = 0;
        //Obtención de los Datos de Ingreso de Solicitud del SIPI/WEBPI
        $obj_query200 = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho='$vder' AND evento='1200'");
        $filas_found200 = $sql->nums('',$obj_query200);
        if ($filas_found200 != 0) {
          $objs200 = $sql->objects('',$obj_query200);
          $scomentario=trim($objs200->comentario);
          $ntramite = trim(substr($scomentario,32,6));
          if ($ntramite=="ensa:") {
            $ntramite = substr($scomentario,56,6);
          }
          //echo "$scomentario, $ntramite ---";           
        }

        $filas_factram = 0;
        //Obtención de los Datos de Ingreso de Solicitud del SIPI/WEBPI
        $obj_querytram = $sql->query("SELECT * FROM $tbname_5 WHERE nro_derecho='$vder' AND nro_tramite='$ntramite' AND tipo_mpa='M'");
        $filas_factram = $sql->nums('',$obj_querytram);
        if ($filas_factram != 0) {
          $objstram = $sql->objects('',$obj_querytram);
          $ftramite = trim($objstram->fecha_tramite);
          $nfactura = $objstram->nro_factura;
        }
        //echo "$ntramite,$ftramite,$nfactura -/-";
        $filas_215 = 0;
        //Verificacion de si ya le fue cargado el evento 215 en tramite
        //28092021
        $obj_query2 = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho='$vder' AND evento='$evento'");
        //$obj_query2 = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho='$vder' AND evento='$evento' AND fecha_trans='24/09/2021'");
        $filas_215=$sql->nums('',$obj_query2);

        //28092021
        //if ($filas_215!=0) {
        if ($filas_215==0) {
          //Inserto Datos en la tabla de Tramite stmpagopren

          //28092021          
          //$usuario   = "lcrodriguez";
          //$fechahoy  = "24/09/2021";
          //$horactual = "11:48:39 AM";

          $col_campos = "factura,nro_derecho,solicitud,boletin,estatus,usuario,fecha_carga,hora_carga,publicada,fecha_publi,extemporanea,fecha_fac,sede";
          $insert_str = "'$ntramite','$vder','$nsol','$boletin','C','$usuario','$fechahoy','$horactual','N','$fechahoy','$vext','$ftramite','$sede'";
          $ins_prensa = $sql->insert("$tbname_1","$col_campos","$insert_str","");
          //echo "/ $nsol -- $fecha_vbol -- $scomentario -- $ntramite - $ftramite -- $insert_str "; exit();

          //Inserto Datos en la tabla de Tramite Stzevtrd
          $col_campos1 = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
          $insert_str1 = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$vsta','$boletin','$fechahoy','$usuario','$mensa_automatico','$scomentario','$horactual'";

          //28092021
          $ins_tram = $sql->insert("$tbname_2","$col_campos1","$insert_str1","");

          //echo " -- $insert_str1";

          if (($ins_prensa) AND ($ins_tram)) { }
          else { $numerror = $numerror + 1; }  
        }
      }
      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' SOLICITUDES ENVIADAS A DIFUSION PARA SU PUBLICACION CORRECTA EN PRENSA DIGITAL ...!!!","m_pubprenbol.php","S");
    $smarty->display('pie_pag.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","m_pubprenbol.php","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

}

//Paso de asignacion de variables de encabezados
$smarty->assign('campo6','Boletin:');
$smarty->assign('varfocus','forcaduca.boletin'); 

$smarty->display('m_pubprenbol.tpl');
$smarty->display('pie_pag.tpl');
?>

