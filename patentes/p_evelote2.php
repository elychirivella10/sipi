<?php
// *************************************************************************************
// Programa: p_evelote2.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado Año 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variable
$sql = new mod_db();
$tbname_1 = "stppatee";
$tbname_2 = "stzevder";
$tbname_3 = "stzstder";
$tbname_4 = "stzevtrd";
$tbname_5 = "stzderec";
$fecha    = fechahoy();

$vopc=$_GET['vopc'];
$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$vsol3=$_POST['vsol3'];
$vsol4=$_POST['vsol4'];
$vuser=$_POST['vuser'];
$est_id1=$_POST['est_id1'];
$est_id2=$_POST['est_id2'];
$usuario=$_POST['usuario'];
$fechat1=$_POST['fechat1'];
$fechat2=$_POST['fechat2'];
$evento_id=$_POST['evento_id'];
$evento2_id=$_POST['evento2_id'];
$vdoc=$_POST['vdoc'];
$role=$_POST['role'];

$inf_adicional=$_POST['inf_adicional'];
$tipo_evento=$_POST['tipo_evento'];
$plazo_ley=$_POST['plazo_ley'];
$tipo_plazo=$_POST['tipo_plazo'];
$mensa_automatico=$_POST['mensa_automatico'];
$tit_comenta=$_POST['tit_comenta'];
$tit_nro_doc=$_POST['tit_nro_doc'];
$nfechaev=$_POST['nfechaev'];
$fechapub=$_POST['fechapub'];
$fechaven=$_POST['fechaven'];
$comentario=$_POST['comentario'];
$documento=$_POST['documento'];
$resultado=false;

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Actualizacion de Expedientes por Lotes');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
  $indcond = 0;
  $vsola=$vsol1."-".sprintf("%06d",$vsol2);
  $vsolb=$vsol3."-".sprintf("%06d",$vsol4);
  $condicion = "SELECT stzderec.nro_derecho,stzderec.solicitud,stzderec.fecha_solic,stzderec.estatus,stzderec.fecha_venc FROM stzderec";
  $lcwhere = " WHERE (stzderec.solicitud>='$vsola' AND stzderec.solicitud<='$vsolb') AND stzderec.tipo_mp='P' ";

  if ((!empty($est_id1)) and ($est_id1!=0)) {
    $est_id1 = $est_id1+2000;
    $lcwhere = $lcwhere." AND stzderec.estatus='$est_id1'";
  }

  if ((!empty($est_id2)) and ($est_id2!=0)) {
     if ($indcond==0) {
       $condicion = $condicion.",stzevtrd"; 
       $lcwhere = $lcwhere." AND (stzevtrd.nro_derecho=stzderec.nro_derecho) ";
       $indcond=1; 
     }
     $lcwhere = $lcwhere." AND stzevtrd.estat_ant='$est_id2'";
  }

  if ((!empty($evento_id))) {
     if ($indcond==0) {
       $condicion = $condicion.",stzevtrd"; 
       $lcwhere = $lcwhere." AND (stzevtrd.nro_derecho=stzderec.nro_derecho) ";
       $indcond=1; 
     }
     $lcwhere = $lcwhere." AND stzevtrd.evento='$evento_id'";
  }
  
  if (!empty($vuser)) {
     if ($indcond==0) {
       $condicion = $condicion.",stzevtrd";
       $lcwhere = $lcwhere." AND (stzevtrd.nro_derecho=stzderec.nro_derecho) ";
       $indcond=1; 
     }
     $lcwhere = $lcwhere." AND stzevtrd.usuario='$vuser'";
  }
  
  if (!empty($fechat1) && !empty($fechat2)) {
    $esmayor=0;
    $esmayor=compara_fechas($fechat1,$fechat2);
    if ($esmayor==1) {
      mensajenew('Error en el Rango de Fecha de Transaccion ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); } 
    if ($indcond==0) {
      $condicion = $condicion.",stzevtrd"; 
      $lcwhere = $lcwhere." AND (stzevtrd.nro_derecho=stzderec.nro_derecho) ";
      $indcond=1; 
    }
    $lcwhere = $lcwhere." AND (stzevtrd.fecha_trans>='$fechat1' AND stzevtrd.fecha_trans<='$fechat2')";
  }
  
  if (!empty($fechaeven)) {
     if ($indcond==0) {
       $condicion = $condicion.",stzevtrd"; 
       $lcwhere = $lcwhere." AND (stzevtrd.nro_derecho=stzderec.nro_derecho) ";
       $indcond=1; 
     }
     $lcwhere = $lcwhere." AND stzevtrd.fecha_event='$fechaeven'";
  }
  
  if (!empty($vdoc)) {
     if ($indcond==0) {
       $condicion = $condicion.",stzevtrd"; 
       $lcwhere = $lcwhere." AND (stzevtrd.nro_derecho=stzderec.nro_derecho) ";
       $indcond=1; 
     }
     $lcwhere = $lcwhere." AND stzevtrd.documento='$vdoc'";
  }

  //La Fecha de Hoy para la transaccion y calculos de fechas de vencimientos
  $fechahoy = hoy();
  
  //Validacion en el Rango de Solicitudes
  if ($vsola=='0000-000000' AND $vsolb=='0000-000000') {
     //mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','m_evelote.php');
     mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  if ($vsola > $vsolb) {
     //mensaje('ERROR AL INTENTAR PROCESAR - RANGO INCORRECTO','m_evelote.php');
     mensajenew('ERROR AL INTENTAR PROCESAR - RANGO INCORRECTO ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if (!empty($evento2_id)) { 
    
    if (empty($nfechaev)) { 
      mensajenew('La Fecha del Evento esta Vacia ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    $fechaeve = Convertir_en_fecha($nfechaev,0);
    $esmayor=compara_fechas($fechaeve,$fechahoy);
    if ($esmayor==1) {
      mensajenew('NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); } 
  } //Verificacion del Evento

  $resultado=pg_exec("$condicion$lcwhere");
  if (!$resultado) { 
    mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','p_evelote.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado);
   
  if ($filas_found==0) {
    mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','p_evelote.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  { 
    $errorgrabar = 0; 
    $evento2_id = $evento2_id + 2000; 
    $regsol = pg_fetch_array($resultado);
    for($cont=0;$cont<$filas_found;$cont++) 
    { 
      $update_str ='';
      $vder = $regsol['nro_derecho'];
      $vsolicitud = trim($regsol['solicitud']);
      $fecha_solic = $regsol['fecha_solic'];
      $estatus = trim($regsol['estatus']);
      $fecha_venc = $regsol['fecha_venc'];
      
      if (!empty($evento2_id) || ($evento2_id!=0)) { 
        $solfecha = Convertir_en_fecha($fecha_solic,0);
        $esmayor=compara_fechas($solfecha,$fechaeve);
        if ($esmayor==0) {
          if ($tipo_evento == "M") {
            //Se obtiene el Estatus Final de la tabla de Migraciones y el derecho "M=Marca, P=Patente"
            $regestfin=estatus_final($evento2_id,$estatus,"P");
            if (!empty($regestfin)) {
              $update_str = "estatus='$regestfin'";
              if ($plazo_ley == 0)
                { $fecha_venc = null; 
                  if (!empty($update_str)) { $update_str = $update_str.",fecha_venc=null"; }
                  else { $update_str = 'fecha_venc=null'; } 
                }  
              else 
                { if ($evento2_id==2025) { 
                    $fechavenc = calculo_fechas($fecha_venc,$plazo_ley,$tipo_plazo,"/"); }
                  else { $fechavenc = calculo_fechas($nfechaev,$plazo_ley,$tipo_plazo,"/"); }
                 $fecha_venc = $fechavenc;          
                 $update_str = $update_str.",fecha_venc='$fecha_venc'";
                } 
              if ($evento2_id==2124) {
                if (!empty($update_str)) {
                   $update_str = $update_str.",fecha_publi='$nfechaev'"; }
                else { $update_str = "fecha_publi='$nfechaev'"; } 
              }
            } // Estatus Final
          } 
          else 
          { $fecha_venc = null; }  //Tipo Evento
          //Se obtiene el proximo valor para el secuencial a guardar en stmevtrd a partir de stzsistem
          //$sys_actual = next_sys("msecuencial");
          //$vsecuencial = grabar_sys("msecuencial",$sys_actual);
          $horactual=hora();
          $instram = true;
          //Inserto Datos en la tabla de Tramite Stzevtrd
          if (($tipo_evento == "M") && ($plazo_ley != 0)) {
            $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora";
            $insert_str = "'$vder','$evento2_id','$nfechaev',nextval('stzevtrd_secuencial_seq'),'$estatus','$fecha_venc','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
            $instram = $sql->insert("$tbname_4","$col_campos","$insert_str",""); }
          else { 
            $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
            $insert_str = "'$vder','$evento2_id','$nfechaev',nextval('stzevtrd_secuencial_seq'),'$estatus','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
            $instram = $sql->insert("$tbname_4","$col_campos","$insert_str",""); }
        } 
      } 
      else {
        if (!empty($fechapub)) 
           { $update_str = $update_str."fecha_publi='$fechapub'"; }
        if (!empty($fechaven)) 
        {
          if (!empty($update_str)) {
            $update_str = $update_str.",fecha_venc='$fechaven'"; }
          else { $update_str = "fecha_venc='$fechaven'"; }
        }
      }    
      $actprim = true;
      
      //Se actualiza Maestra de Patentes  
      if (!empty($update_str))
        { $actprim = $sql->update("$tbname_5","$update_str","nro_derecho='$vder'"); }
      $regsol = pg_fetch_array($resultado);
    }
    // Verificacion y actualizacion real de los Datos en BD 
    if ($actprim and $instram) { }
    else {
      $errorgrabar = $errorgrabar+1; }
  }

  // Verificacion y actualizacion real de los Datos en BD 
  if ($errorgrabar == 0) {
    pg_exec("COMMIT WORK");
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    if (!$actprim) { $error_pri  = " - Maestra "; } 
    if (!$instram) { $error_tra  = " - Tr&aacute;mite "; }
    Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_pri $error_tra  ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }
  
  //Desconexion de la Base de Datos
  $sql->disconnect();
  mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','p_evelote.php','S');
  $smarty->display('pie_pag.tpl'); exit();
}

?>
