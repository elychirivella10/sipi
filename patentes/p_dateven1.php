<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function max(txarea,totalc) 
 { 
   total = totalc; 
   tam = txarea.value.length; 
   str=""; 
   str=str+tam; 
   Digitado.innerHTML = str; 
   Restante.innerHTML = total - str; 
   if (tam > total){ 
      aux = txarea.value; 
      txarea.value = aux.substring(0,total); 
      Digitado.innerHTML = total 
      Restante.innerHTML = 0 
   } 
 } 

</script> 

<?php
// ************************************************************************************* 
// Programa: p_dateven1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año 2006 
// Modificado Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$usuario  = $_SESSION['usuario_login'];
$sql      = new mod_db();
$tbname_1 = "stzevder";
$tbname_2 = "stztmpbo";
$fecha    = fechahoy();

//Validacion de Entrada
$anno  =$_POST["anno"];
$vder  =$_POST["vder"];
$numero=$_POST["numero"];
$fecha_solic=$_POST["fecha_solic"];
$fecha_venc =$_POST["fecha_venc"];
$tipo_paten =$_POST["tipo_paten"];
$nombre     =$_POST["nombre"];
$estatus    =$_POST["estatus"];
$descripcion=$_POST["descripcion"];
$eventos_id =$_POST["eventos_id"];
$input2     =$_POST["input2"];
$nameimage  =$_POST["nameimage"];
$usuario    =$_POST['usuario'];
$role       =$_POST['role'];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$dirano=$anno;
$vsol=$anno."-".$numero;

if (empty($vsol))
   { mensajenew("Nro. de Expediente vacio ...!!!","p_eveind.php","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Verificando conexion
$sql->connection($usuario);

if (($eventos_id==165) || ($eventos_id==205) || ($eventos_id==206) || ($eventos_id==207) || 
    ($eventos_id==208) || ($eventos_id==209) || ($eventos_id==235) ||  
    ($eventos_id==236) || ($eventos_id==237) || ($eventos_id==238) || ($eventos_id==222)) 
  {
  mensajenew("AVISO: El Evento $eventos_id NO aplica en esta pantalla ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }

//Eventos de No Ratificaciones de Recursos y Acciones
if (($eventos_id==865) || ($eventos_id==867) || ($eventos_id==869) || ($eventos_id==871) || ($eventos_id==873)) {
  mensajenew("AVISO: Evento $eventos_id NO aplica en esta pantalla ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }

$eventos_id = $eventos_id+2000; //echo "$eventos_id";    
//Verificando Código Evento en tabla básica de Eventos de Marcas
if (!empty($vsol))
   {
     $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE evento='$eventos_id'");
   }
if (!$resultado) 
   { 
     mensajenew("ERROR: Código de Evento NO existe en la Base de Datos ...!!!","javascript:history.back();","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) 
   {
     mensajenew("ERROR: No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } 
$regeve = pg_fetch_array($resultado);
$evendesc = trim($regeve['descripcion']);
$tipo_evento = $regeve['tipo_evento'];
$inf_adicional=trim($regeve['inf_adicional']);
$mensa_automatico=trim($regeve['mensa_automatico']);
$tit_comenta=trim($regeve['tit_comenta']);
$tit_nro_doc=trim($regeve['tit_nro_doc']);
$tipo_plazo=$regeve['tipo_plazo'];
$plazo_ley=$regeve['plazo_ley'];
$aplica=$regeve['aplica'];
$documento=0;
$comentario="";

//Se verifica si el usuario puede o no cargar el evento seleccionado
$aplica = even_rol($role,$eventos_id);
if ($aplica==0) 
  {
    mensajenew("ERROR: El Usuario NO tiene permiso para Cargar el Evento Seleccionado ...!!!","javascript:history.back();","N");     
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$tipoevento = $tipo_evento;

if ($tipo_evento=='M') {
  //Verificando expediente en tabla Stztmpbo
  $resul=pg_exec("SELECT * FROM $tbname_2 WHERE solicitud='$vsol' AND tipo='P'");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     mensajenew("ERROR: Evento no aplica, Expediente en estatus Migrable por Boletin ...!!!","p_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}

// Verificacion que no hayan cargado previamente el evento 799
if ($eventos_id==2799) {
  if ($estatus!=555) {
     mensajenew("AVISO: Evento aplicable solamente a Patentes Registradas en estatus 555 ...!!!","p_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }   
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=2799");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     mensajenew("ERROR: Evento ya aplicado, no puede cargarse de nuevo al registro ...!!!","p_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}

// Evento de Pago de Derechos 
if ($eventos_id==2066) {
  if (($estatus!=400) && ($estatus!=402) && ($estatus!=404)) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Patentes ya Concedidas ...!!!","p_eveind.php","N");
    $smarty->display('pie_pag.tpl'); exit(); }
}  

// Verificacion que no hayan cargado previamente el evento 15
if ($eventos_id==2015) {
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=2015");
  $filas_found=pg_numrows($resul);
  if ($filas_found!=0) {
     mensajenew("ERROR: Evento ya aplicado, no puede cargarse de nuevo al expediente ...!!!","p_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $vexp=$anno.$numero;  
  $cmd="scp -P 3535 www-data@172.16.0.7:/var/www/consulta/patente/venezuela/".$vexp.".pdf /var/www/apl/sipi/graficos/pdfpattmp/"; 
  exec($cmd);
  $vexp = "/var/www/apl/sipi/graficos/pdfpattmp/".$vexp.".pdf";
  if (!file_exists($vexp)) { 
    $vexp = "/var/www/apl/sipi/graficos/pdfpattmp/".$vexp.".PDF";
    if (!file_exists($vexp)) {
      mensajenew("ERROR: Evento no puede aplicarse al Expediente dado que no se encuentra el PDF en el servidor ...!!!","p_eveind.php","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  }
  }  
}

// Evento de Pago de Derechos en Dolares Pago de Intencion 
if ($eventos_id==2074) {
  if ($estatus!=400) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Patentes Concedidas en Estatus 400 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
    
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=2074");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","p_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  //Verificando el pais de domicilio
  $resul=pg_exec("SELECT * FROM stzottid WHERE nro_derecho='$vder'");
  $filas_found=pg_numrows($resul);
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud NO presenta Titular o Solicitante, Verificar con el Administrdor del Sistema ...!!!","p_eveind.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  else {
     $regtitu = pg_fetch_array($resul);
     $paisdom = trim($regtitu['pais_domicilio']);
     if ($paisdom!='VE') { }
     else {
       mensajenew("ERROR: El Evento solo aplica a solicitudes cuyo Pais sea distinto a Venezuela ...!!!","p_eveind.php","N");
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
     }
  }
}  

// Evento de Pago en Dolares Pago de Intencion Cambios Posterior a Registro 
if ($eventos_id==2214) {
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='P' ");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regsoli = pg_fetch_array($resul);
     $nregistro = trim($regsoli['registro']); 
     if (empty($nregistro)) {
      mensajenew("ERROR: Evento $eventos_id Aplica solo a Patentes Registradas ...!!!","p_eveind.php","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  } 
  //Verificando si el expediente ya presenta dicho evento 
  //$resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=2214");
  //$filas_found=pg_numrows($resul); 
  //if ($filas_found!=0) {
  //   $regtrami = pg_fetch_array($resul);
  //   $fechaeve = trim($regtrami['fecha_trans']);
  //   $loginusr = trim($regtrami['usuario']); 
  //   mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","p_eveind.php","N");     
  //   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  //} 
  //Verificando el pais de domicilio
  $resul=pg_exec("SELECT * FROM stzottid WHERE nro_derecho='$vder'");
  $filas_found=pg_numrows($resul);
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud NO presenta Titular o Solicitante, Verificar con el Administrdor del Sistema ...!!!","p_eveind.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  else {
     $regtitu = pg_fetch_array($resul);
     $paisdom = trim($regtitu['pais_domicilio']);
     if ($paisdom!='VE') { }
     else {
       mensajenew("ERROR: El Evento solo aplica a solicitudes cuyo Pais sea distinto a Venezuela ...!!!","p_eveind.php","N");
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
     }
  }
}  

// Evento de Pago en Dolares Pago de Intencion Anualidad 
if ($eventos_id==2239) {
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='P' ");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regsoli = pg_fetch_array($resul);
     $nregistro = trim($regsoli['registro']); 
     if (empty($nregistro)) {
      mensajenew("ERROR: Evento $eventos_id Aplica solo a Patentes Registradas ...!!!","p_eveind.php","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  } 
  //Verificando el pais de domicilio
  $resul=pg_exec("SELECT * FROM stzottid WHERE nro_derecho='$vder'");
  $filas_found=pg_numrows($resul);
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud NO presenta Titular o Solicitante, Verificar con el Administrdor del Sistema ...!!!","p_eveind.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  else {
     $regtitu = pg_fetch_array($resul);
     $paisdom = trim($regtitu['pais_domicilio']);
     if ($paisdom!='VE') { }
     else {
       mensajenew("ERROR: El Evento solo aplica a solicitudes cuyo Pais sea distinto a Venezuela ...!!!","p_eveind.php","N");
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
     }
  }
}  

// Evento de Ratificacion de Escritos de Reconsideracion y Acciones Nulidades 
if ($eventos_id==2196) {
	
  mensajenew("AVISO: Evento $eventos_id Extemporaneo, NO Aplica ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit();
	
  //Verificando si el expediente ya presenta el estatus adecuado 
  if (($estatus==800) || ($estatus==801) || ($estatus==802) || ($estatus==804) || ($estatus==805) || ($estatus==806) || ($estatus==809) || ($estatus==821) || ($estatus==833) || ($estatus==835) || ($estatus==836) || ($estatus==837) || ($estatus==838) || ($estatus==840) || ($estatus==921) || ($estatus==922)) { } 
  else {
    mensajenew("AVISO: Evento $eventos_id NO Aplica a este estatus ".$estatus." de la Patente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=2195 AND documento=588");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud NO fue publicada en el Boletin 588 ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=2196");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","p_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
}  

// Evento de Ratificacion de Escritos de Reconsideracion y Acciones Nulidades 
if ($eventos_id==2314) {
  //Verificando si el expediente ya presenta el estatus adecuado 
  if (($estatus==800) || ($estatus==801) || ($estatus==802) || ($estatus==804) || ($estatus==805) || ($estatus==806) || ($estatus==809) || ($estatus==821) || ($estatus==833) || ($estatus==835) || ($estatus==836) || ($estatus==838) || ($estatus==840) || ($estatus==921) || ($estatus==922)) { } 
  else {
    mensajenew("AVISO: Evento $eventos_id NO Aplica a este estatus ".$estatus." de la Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificando si el expediente fue publicado en el Boletin 588 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=2195 AND documento=588");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud/Registro NO fue publicada en el Boletin 588 ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //Verificando si hubo ratificacion  
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=2196 AND documento=588");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     mensajenew("ERROR: Solicitud/Registro presenta Escrito de Ratificacion ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //Verificando si el expediente fue publicado en el Boletin Extraordinario 1 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND documento=1 AND tipo_documento='E' AND evento IN (2866,2868,2870,2872,2874)");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud/Registro NO fue publicada en el Boletin Extraordinario 1 ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1314");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
}  

// Verificacion de Evento 310 y Publicacion de Boletin Extraordinario 
if ($eventos_id==2310) {
  //Verificando si el expediente ya presenta el estatus adecuado 
  if (($estatus==800) || ($estatus==801) || ($estatus==802) || ($estatus==803) || ($estatus==804) || ($estatus==805) || ($estatus==806) || ($estatus==807) || ($estatus==808) || ($estatus==809) || ($estatus==821) || ($estatus==822) || ($estatus==823) || ($estatus==824) || ($estatus==825) || ($estatus==830) || ($estatus==831) || ($estatus==833) || ($estatus==835) || ($estatus==836) || ($estatus==837)|| ($estatus==838)) { 
    //Verificando si el expediente fue publicado en el Boletin Extraordinario 1 
    $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND documento=1 AND tipo_documento='E' AND evento IN (2866,2868,2870,2872,2874)");
    $filas_found=pg_numrows($resul); 
    if ($filas_found!=0) {
      mensajenew("ERROR: Solicitud/Registro Publicado en Boletin Extraordinario 1, Contacte al Administrador del Sistema ...!!!","m_eveind.php","N");     
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  } 
}

// Evento de Desincorporacion 
if ($eventos_id==2982) {
  if (($estatus==7) || ($estatus==91) || ($estatus==500) || ($estatus==502) || ($estatus==600) || ($estatus==601) || ($estatus==602) || ($estatus==650) || ($estatus==651) || ($estatus==751) || ($estatus==810) || ($estatus==815) || ($estatus==817) || ($estatus==818) || ($estatus==819) || ($estatus==837) || ($estatus==911) || ($estatus==912) || ($estatus==916) || ($estatus==919) || ($estatus==920) || ($estatus==999)) { } 
  else {
    mensajenew("AVISO: Evento $eventos_id NO Aplica a este estatus ".$estatus." de la Patente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=2982");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","p_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

//Desconexion a la Base de Datos
$sql->disconnect();

$smarty->assign('vder',$vder);
$smarty->assign('anno',$dirano);
$smarty->assign('numero',$numero);
$smarty->assign('nombre',$nombre);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('fecha_venc',$fecha_venc);
$smarty->assign('tipo_paten',$tipo_paten);
$smarty->assign('estatus',$estatus);
$smarty->assign('descripcion',$descripcion);
$smarty->assign('evento',$eventos_id-2000);
$smarty->assign('eve_nombre',$evendesc);
$smarty->assign('inf_adicional',$inf_adicional);
$smarty->assign('tipo_evento',$tipoevento);
$smarty->assign('plazo_ley',$plazo_ley);
$smarty->assign('tipo_plazo',$tipo_plazo);
$smarty->assign('mensa_automatico',$mensa_automatico);
$smarty->assign('aplica',$aplica);
$smarty->assign('documento',$documento);
$smarty->assign('comentario',$comentario);
$smarty->assign('usuario',$usuario);
$smarty->assign('nameimage',$nameimage);

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('campo3','Tipo:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Estatus:');
$smarty->assign('campo6','Evento:');
$smarty->assign('campo7','Fecha del Evento:');
$smarty->assign('campo8',$tit_nro_doc);
$smarty->assign('campo9',$tit_comenta);
$smarty->assign('varfocus','fordatev.fecha_evento'); 

$smarty->display('p_dateven.tpl');
$smarty->display('pie_pag.tpl');
?>
