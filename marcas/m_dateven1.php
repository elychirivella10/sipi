<script language="Javascript"> 

  function checkKey(evt){
   if (evt.keyCode == '17')  
     {alert("Comando No Permitido ...!!!");
     return false;}
   return true; }
   
  function cerrarwindows() {
     window.close(); }
  
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
// Programa: m_dateven1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables
$sql = new mod_db();
$tbname_q1 = "stzevder";
$tbname2   = "stztmpbo";
$fecha     = fechahoy();

//Validacion de Entrada
$vder        = $_POST["vder"];
$anno        = $_POST["anno"];
$numero      = $_POST["numero"];
$vreg        = $_POST["registro"];
$fecha_solic = $_POST["fecha_solic"];
$fecha_venc  = $_POST["fecha_venc"];
$tipo_marca  = $_POST["tipo_marca"];
$nombre      = $_POST["nombre"];
$estatus     = $_POST["estatus"];
$descripcion = $_POST["descripcion"];
$eventos_id  = $_POST["eventos_id"];
$input2      = $_POST["input2"];
$nameimage   = $_POST["nameimage"];
$modalidad   = $_POST["modalidad"];
$usuario     = $_POST['usuario'];
$role        = $_POST['role'];
$nconex      = $_POST['nconex'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// ************************************************************************************  
// Control de acceso: Entrada y Salida al Modulo 
$smarty->assign('n_conex',$nconex);
// ************************************************************************************  

$dirano=$anno;
$vsol=$anno."-".$numero;

if (empty($vsol))
   { mensajenew("ERROR: Nro. de Expediente vac&iacute;o ...!!!","m_eveind.php","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Verificando conexion
$sql->connection($usuario);

//if ((($eventos_id==65) || ($eventos_id==66)) AND ($role=='INTEGRAL')) {
//  mensajenew("AVISO: Evento $eventos_id NO aplica en esta pantalla ...!!!","javascript:history.back();","N");
//  $smarty->display('pie_pag.tpl'); exit(); }

if (($eventos_id==165) || ($eventos_id==204) || ($eventos_id==205) || ($eventos_id==206) || 
   ($eventos_id==207) || ($eventos_id==208) || ($eventos_id==209)) {
  mensajenew("AVISO: Evento $eventos_id NO aplica en esta pantalla ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }

//if (($eventos_id==51) || ($eventos_id==52) || ($eventos_id==225) || ($eventos_id==1803)) {
if (($eventos_id==52) || ($eventos_id==225) || ($eventos_id==1803)) {
  mensajenew("AVISO: Evento $eventos_id NO aplica en esta pantalla ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }

//Eventos de No Ratificaciones de Recursos y Acciones
if (($eventos_id==865) || ($eventos_id==867) || ($eventos_id==869) || ($eventos_id==871) || 
    ($eventos_id==873) || ($eventos_id==875) || ($eventos_id==877) || ($eventos_id==879) || ($eventos_id==881) || ($eventos_id==883)) {
  mensajenew("AVISO: Evento $eventos_id NO aplica en esta pantalla ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }

if (($eventos_id==54)) {
  if ($estatus!=120) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas Observadas en esta pantalla ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
}

if (($eventos_id==22)) {
    mensajenew("AVISO: Evento $eventos_id NO Aplica en esta pantalla ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
}

if (($eventos_id==228)) {
  if (($estatus==120) || ($estatus==124)) {
    //Verificando si el expediente presenta el evento 1081 de Ratificacion de Observacion 
    $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1081");
    $filas_found=pg_numrows($resul); 
    if ($filas_found==0) {
      mensajenew("AVISO: El Expediente NO presenta el Escrito de Ratificaci&oacute;n  ...!!!","m_eveind.php","N");     
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    } 
  }
  else {
    mensajenew("AVISO: Evento $eventos_id aplica solo a Marcas Observadas u Observadas Detenidas en esta pantalla ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
}

//Evento de Verificadas Graficamente con Busqueda elaborada
if ($eventos_id==50) {
  if ($modalidad == "D") {
    mensajenew("AVISO: Evento $eventos_id NO aplica a Solicitudes de tipo DENOMINATIVAS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  if ($estatus!=8) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Solicitudes en estatus 8 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //Verificando si el expediente ya fue arrojado impresa su busqueda 
  $resul=pg_exec("SELECT * FROM stmaudef WHERE pedido='$vsol'");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
     mensajenew("ERROR: La Solicitud no ha sido procesada ni impresa su busqueda  ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1050");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("AVISO: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

if (($eventos_id==51)) {
  if ($modalidad!="D") {
    //Verificando si el expediente ya presenta dicho evento 
    $resul1=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1050");
    $filas1_found=pg_numrows($resul1); 
    $resul2=pg_exec("SELECT * FROM stmaudef WHERE pedido='$vsol'");
    $filas2_found=pg_numrows($resul2);
      
    //if (($filas1_found==0) && ($filas2_found==0)) {
    //  mensajenew("ERROR: Expediente Gr&aacute;fico o Mixto sin B&uacute;squeda Gr&aacute;fica de Fondo ...!!!","m_eveind.php","N");     
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    //} 


    //if (($filas1_found==0) || ($filas2_found==0)) {
    //  mensajenew("ERROR: Expediente Gr&aacute;fico o Mixto sin B&uacute;squeda Gr&aacute;fica de Fondo ...!!!","m_eveind.php","N");     
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    //} 
  }
}

// Evento de Bloqueo de solicitud por evento 234 cargado sin autorizacion  
if ($eventos_id==300) { 
  //Verificando si el expediente ya presenta dicho evento 234 y 165 cargado por el usuario jrisquez 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1234 AND usuario='jrisquez'
                  AND fecha_trans >= '01/01/2012' AND fecha_trans <= '18/07/2012'");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud NO presenta el Evento 234 cargado por jrisquez ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Ratificacion de Observadas 
if ($eventos_id==81) {
  if (($estatus==120) || ($estatus==124)) { }
  else {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas Observadas y/o Observadas Detenidas ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
}

// Evento de Pago de Derechos en Dolares 
if ($eventos_id==794) {
  if ($estatus!=555) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas ya Registradas ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
    
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1794");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Pago de Derechos en Dolares Pago de Intencion 
if ($eventos_id==74) {
  if ($estatus!=400) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas Concedidas en Estatus 400 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
    
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1074");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  //Verificando el pais de domicilio
  $resul=pg_exec("SELECT * FROM stzottid WHERE nro_derecho='$vder'");
  $filas_found=pg_numrows($resul);
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud NO presenta Titular o Solicitante, Verificar con el Administrador del Sistema ...!!!","m_eveind.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  else {
     $resul=pg_exec("SELECT * FROM stzottid WHERE nro_derecho='$vder' AND pais_domicilio!='VE'");
     $regtitu = pg_fetch_array($resul);
     $filas_found=pg_numrows($resul);
     //$paisdom = trim($regtitu['pais_domicilio']);
     if ($filas_found!=0) { }
       //if ($paisdom!='VE') { }
       else {
         mensajenew("ERROR: El Evento solo aplica a solicitudes cuyo Pais sea distinto a Venezuela ...!!!","m_eveind.php","N");
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
       }
     //}
     //else {
     //}	  
  }
}  

// Agregado el 04/09/18 por Ing. Romulo Mendoza PIII.
if (($eventos_id==77)) {
  if ($estatus==404) {
    //Verificando si el expediente presenta el evento 1074 de Intencion de Pago 
    $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1074");
    $filas_found=pg_numrows($resul); 
    if ($filas_found==0) {
      mensajenew("AVISO: El Expediente NO presenta el Escrito de Intencion de Pago de Derechos ...!!!","m_eveind.php","N");     
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    } 
  }
  else {
    mensajenew("AVISO: Evento $eventos_id aplica solo a Marcas Concedidas ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
}

// Evento de Pago en Dolares Pago de Intencion Cambios Posterior a Registro 
if ($eventos_id==214) {
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='M' ");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regsoli = pg_fetch_array($resul);
     $nregistro = trim($regsoli['registro']); 
     if (empty($nregistro)) {
      mensajenew("ERROR: Evento $eventos_id Aplica solo a Marcas Registradas ...!!!","m_eveind.php","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  } 
  //Verificando si el expediente ya presenta dicho evento 
  //$resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1214");
  //$filas_found=pg_numrows($resul); 
  //if ($filas_found!=0) {
  //   $regtrami = pg_fetch_array($resul);
  //   $fechaeve = trim($regtrami['fecha_trans']);
  //   $loginusr = trim($regtrami['usuario']); 
  //   mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
  //   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  //} 
  
  //Verificando el pais de domicilio
  $resul=pg_exec("SELECT * FROM stzottid WHERE nro_derecho='$vder'");
  $filas_found=pg_numrows($resul);
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud NO presenta Titular o Solicitante, Verificar con el Administrdor del Sistema ...!!!","m_eveind.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  else {
  	  //De Acuerdo al Requerimiento SIRE Nro. 2014022829 
     //$regtitu = pg_fetch_array($resul);
     //$paisdom = trim($regtitu['pais_domicilio']);
     //if ($paisdom!='VE') { }
     //else {
     //  mensajenew("ERROR: El Evento solo aplica a solicitudes cuyo Pais sea distinto a Venezuela ...!!!","m_eveind.php","N");
     //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
     //}
  }
}  

$nboletin = 0;
// Evento de Habilitacion de Resolucion de Oposiciones Boletines 462 al 599 x Aviso Oficial DG-001-2020 
//if ($eventos_id==40) {
//  //Verificando el Boletin de Publicacion
//  $resul=pg_exec("SELECT * FROM stzderec a,stzevtrd b WHERE a.nro_derecho='$vder' AND a.estatus IN (1008,1003) AND b.evento=1124 AND b.estat_ant=1006 AND a.nro_derecho=b.nro_derecho");
//  $filas_found=pg_numrows($resul); 
//  if ($filas_found!=0) {
//    $regsolm  = pg_fetch_array($resul);
//    $nboletin = trim($regsolm['documento']);
//  } 
//}  

// Evento de Retiro de Escrito de Oposicion 
if ($eventos_id==240) {
  //Verificando el Boletin de Publicacion
  $resul=pg_exec("SELECT * FROM stzderec a,stzevtrd b WHERE a.nro_derecho='$vder' AND a.estatus IN (1120) AND b.evento=1122 AND b.estat_ant IN (1003) AND a.nro_derecho=b.nro_derecho");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
    mensajenew("AVISO: Solicitud sin Escrito de Oposicion presentado ...!!!","javascript:history.back();","N"); 
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Habilitacion de Resolucion de Oposiciones Boletines 462 al 599 x Aviso Oficial DG-001-2020 
if ($eventos_id==226) {
  if ($estatus!=120) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas con Oposicion Publicadas en Boletin ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }

  //Verificando si el expediente fue notificada entre los Boletines 462 al 599 y con Escrito de Contestacion a Oposicion
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1122 AND estat_ant=1003 AND documento between 462 AND 599 AND nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1048)");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
    mensajenew("AVISO: Solicitud con Oposicion NO Notificada entre los Boletines 462 al 599 o NO presenta Escrito de Contestacion a Oposicion ...!!!","javascript:history.back();","N"); 
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Ratificacion de Escritos de Reconsideracion y Acciones Nulidades 
if ($eventos_id==196) {

  mensajenew("AVISO: Evento $eventos_id Extemporaneo, NO Aplica ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit();
	
  //Verificando si el expediente ya presenta el estatus adecuado 
  if (($estatus==800) || ($estatus==801) || ($estatus==802) || ($estatus==803) || ($estatus==804) || ($estatus==805) || ($estatus==806) || ($estatus==807) || ($estatus==808) || ($estatus==809) || ($estatus==821) || ($estatus==822) || ($estatus==823) || ($estatus==824) || ($estatus==825) || ($estatus==830) || ($estatus==831) || ($estatus==833) || ($estatus==835) || ($estatus==836) || ($estatus==837)|| ($estatus==838)) { } 
  else {
    mensajenew("AVISO: Evento $eventos_id NO Aplica a este estatus ".$estatus." de la Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1195 AND documento=588");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud NO fue publicada en el Boletin 588 ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1196");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
}  

// Evento de Ratificacion de Escritos de Reconsideracion y Acciones Nulidades 
if ($eventos_id==314) {
  //Verificando si el expediente ya presenta el estatus adecuado 
  if (($estatus==800) || ($estatus==801) || ($estatus==802) || ($estatus==803) || ($estatus==804) || ($estatus==805) || ($estatus==806) || ($estatus==807) || ($estatus==808) || ($estatus==809) || ($estatus==821) || ($estatus==822) || ($estatus==823) || ($estatus==824) || ($estatus==825) || ($estatus==830) || ($estatus==831) || ($estatus==833) || ($estatus==835) || ($estatus==836) || ($estatus==837)|| ($estatus==838)) { } 
  else {
    mensajenew("AVISO: Evento $eventos_id NO Aplica a este estatus ".$estatus." de la Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificando si el expediente fue publicado en el Boletin 588 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1195 AND documento=588");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
     mensajenew("ERROR: Solicitud/Registro NO fue publicada en el Boletin 588 ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //Verificando si hubo ratificacion  
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1196 AND documento=588");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     mensajenew("ERROR: Solicitud/Registro presenta Escrito de Ratificacion ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //Verificando si el expediente fue publicado en el Boletin Extraordinario 1 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND documento=1 AND tipo_documento='E' AND evento IN (1866,1868,1870,1872,1874,1876,1878,1880,1882,1884)");
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
if ($eventos_id==310) {
  //Verificando si el expediente ya presenta el estatus adecuado || ($estatus==837)
  if (($estatus==800) || ($estatus==801) || ($estatus==802) || ($estatus==803) || ($estatus==804) || ($estatus==805) || ($estatus==806) || ($estatus==807) || ($estatus==808) || ($estatus==809) || ($estatus==821) || ($estatus==822) || ($estatus==823) || ($estatus==824) || ($estatus==825) || ($estatus==830) || ($estatus==831) || ($estatus==833) || ($estatus==835) || ($estatus==836) || ($estatus==838)) { 
    //Verificando si el expediente fue publicado en el Boletin Extraordinario 1 
    $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND documento=1 AND tipo_documento='E' AND evento IN (1866,1868,1870,1872,1874,1876,1878,1880,1882,1884)");
    $filas_found=pg_numrows($resul); 
    if ($filas_found!=0) {
      mensajenew("ERROR: Solicitud/Registro Publicado en Boletin Extraordinario 1, Contacte al Administrador del Sistema ...!!!","m_eveind.php","N");     
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  } 
}

// Verificacion de Evento 310 y Marca Negada 
if ($eventos_id==310) {
  //Verificando si el expediente ya presenta el estatus adecuado 
  if ($estatus==500) { 
    mensajenew("ERROR: Solo se permite la carga de Recursos de Reconsideracion a Negadas por el Webpi ...!!!","m_eveind.php","N");     
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  
  } 
}

// Evento de Pago de Derechos en Dolares 
if ($eventos_id==792) {
  if (($estatus==400) || ($estatus==555)) { }
  else {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas Concedidas Estatus 400 ...!!!","m_eveind.php","N");
    $smarty->display('pie_pag.tpl'); exit(); }
    
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1792");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Certificados elaborados 
if ($eventos_id==838) {
  if ($estatus!=555) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas ya Registradas ...!!!","m_eveind.php","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1838");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento IN (1840,1841)");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     mensajenew("ERROR: El Certificado de Registro ya fue entregado anteriormente ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Certificados entregados 
if ($eventos_id==840) {
  if ($estatus!=555) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas ya Registradas ...!!!","m_eveind.php","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1840");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1838");
  $filas_838=pg_numrows($resul); 
  if ($filas_838==0) {
     mensajenew("ERROR: El Registro NO tiene cargado el Evento 838, debe tenerlo para aceptar el evento 840 ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1839");
  $filas_839=pg_numrows($resul); 
  //if (($filas_838+$filas_839)==2) { 
  //   mensajenew("ERROR: NO le corresponde cargar el evento 840, sino el 841 por haberse entregado por Cuaderno Control ...!!!","m_eveind.php","N");     
  //   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  //}
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1841");
  $filas_841=pg_numrows($resul); 
  if ($filas_841!=0) {
     mensajenew("ERROR: El Certificado de Registro ya fu&eacute; Retirado en su momento de acuerdo al Cuaderno Control ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Retiro de Escrito de Caducidad/Cancelacion x NO Uso BLOQUEADO. YA NO SE USARA 
if ($eventos_id==315) {
  //Verificando el Boletin de Publicacion de la Caducidad x NO Uso
  $resul=pg_exec("SELECT * FROM stzderec a,stzevtrd b WHERE a.nro_derecho='$vder' AND a.estatus IN (1842) AND b.evento=1312 AND b.documento=600 AND a.nro_derecho=b.nro_derecho");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
    mensajenew("AVISO: Registro SIN Aviso de Publicacion de Caducidad por NO Uso ...!!!","m_eveind.php","N"); 
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Escrito de Caducidad x NO Uso LPI 55, validacion que tenga numero de registro
if ($eventos_id==316) {
  if ($vreg=='') {
    mensajenew("ERROR: Evento $eventos_id Aplica solo a Marcas Registradas, Soliciten URGENTEMENTE al RPI que asignen el respectivo Numero de Registro para cargar luego el evento 316 ...!!!","m_eveind.php","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }
}  

// Evento de Retiro de Escrito de Caducidad x NO Uso 
if ($eventos_id==318) {
  //Verificando el Boletin de Publicacion de la Caducidad x NO Uso
  $resul=pg_exec("SELECT * FROM stzderec a,stzevtrd b WHERE a.nro_derecho='$vder' AND b.evento=1330 AND a.nro_derecho=b.nro_derecho");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
    mensajenew("ERROR: Registro SIN Aviso de Notificacion de Caducidad por NO Uso en Boletin...!!!","m_eveind.php","N"); 
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Retiro de Escrito de Caducidad/Cancelacion x NO Uso BLOQUEADO. YA NO SE USARA 
if ($eventos_id==297) {
  if ($estatus!=861) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas con Publicacion de Caducidad por NO Uso en Boletin ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificando el Boletin de Publicacion de la Caducidad x NO Uso
  $resul=pg_exec("SELECT * FROM stzderec a,stzevtrd b WHERE a.nro_derecho='$vder' AND a.estatus IN (1861) AND b.evento=1330 AND a.nro_derecho=b.nro_derecho");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
    mensajenew("AVISO: Registro SIN Aviso de Publicacion de Caducidad por NO Uso ...!!!","javascript:history.back();","N"); 
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Pago en Moneda Extranjera Marcas Registradas 
if ($eventos_id==805) {

//  if (($usuario!='rmendoza')) {	 
//    Mensajenew("ERROR: Evento NO autorizado aun por la Registradora del RPI para ser usado en este Módulo ...!!!","../index1.php","N");
//    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }  
//  else {  
		
  if ($estatus!=655) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas en Estatus 655 Registradas ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1805");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
//  }
}  

// Evento de Certificados entregados 
if ($eventos_id==841) {
  if ($estatus!=555) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas ya Registradas ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1841");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1839");
  $filas_839=pg_numrows($resul); 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1838");
  $filas_838=pg_numrows($resul); 
  if ((($filas_838+$filas_839)==1) || (($filas_838+$filas_839)==2)) {  }
  else {
     mensajenew("ERROR: El Certificado de Registro est&aacute; a la espera de ser retirado Nuevamente, o debe cargarle el Evento 838 y/o 840. Notifique inmediatamente al Registrador(a) ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Certificados Generados por Omision y/o Error Material involuntario 
if (($eventos_id==901) || ($eventos_id==902)) {
  if ($estatus!=555) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas ya Registradas ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
    
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento IN (1901,1902)");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento de Certificado Generado por Omision y/o Error Involuntario cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Desincorporacion 
if ($eventos_id==982) {
  if (($estatus==500) || ($estatus==600) || ($estatus==601) || ($estatus==602) || ($estatus==651) || ($estatus==700) || ($estatus==751) || ($estatus==810) || ($estatus==815) || ($estatus==817) || ($estatus==819) || ($estatus==832) || ($estatus==840) || ($estatus==911) || ($estatus==912) || ($estatus==915) || ($estatus==916) || ($estatus==997) || ($estatus==999)) { } 
  else {
    mensajenew("AVISO: Evento $eventos_id NO Aplica a este estatus ".$estatus." de la Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1982");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

if ($eventos_id==260) {
  //Verificacion que sea Marca Registrada
  $resul=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='M' ");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regsoli = pg_fetch_array($resul);
     $nregistro = trim($regsoli['registro']); 
     if (empty($nregistro)) {
      mensajenew("ERROR: Evento $eventos_id Aplica solo a Marcas Registradas ...!!!","m_eveind.php","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  } 
  //Verificacion que presente alguna anotacion marginal
  $resul_anota=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento IN (1204,1205,1206,1207,1208,1209)");
  $filas_found=pg_numrows($resul_anota); 
  if ($filas_found==0) {
    mensajenew('ERROR: Solicitud NO presenta algun Cambio Posterior a Registro ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); 
  } 

}

$eventos_id  = $eventos_id+1000;
//Verificando Codigo de Evento en tabla basica de Eventos de Marcas
if (!empty($vsol)) {
     $resultado=pg_exec("SELECT * FROM $tbname_q1 WHERE evento='$eventos_id'");
 }
if (!$resultado) { 
     mensajenew("ERROR: Codigo de Evento NO existe en la Base de Datos ...!!!","javascript:history.back();","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) 
   {
     mensajenew("ERROR: No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } 

$regeve           = pg_fetch_array($resultado);
$evendesc         = trim($regeve['descripcion']);
$tipo_evento      = $regeve['tipo_evento'];
$inf_adicional    = trim($regeve['inf_adicional']);
$mensa_automatico = trim($regeve['mensa_automatico']);
$tit_comenta      = trim($regeve['tit_comenta']);
$tit_nro_doc      = trim($regeve['tit_nro_doc']);
$tipo_plazo       = $regeve['tipo_plazo'];
$plazo_ley        = $regeve['plazo_ley'];
$aplica           = $regeve['aplica'];
$documento        = "";
$comentario       = "";

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
  $resul=pg_exec("SELECT * FROM $tbname2 WHERE solicitud='$vsol' AND tipo='M'");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) 
   {
     mensajenew("ERROR: Evento no aplica, Expediente en estatus Migrable por Boletin ...!!!","m_eveind.php","N");     
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
$smarty->assign('tipo_marca',$tipo_marca);
$smarty->assign('estatus',$estatus);
$smarty->assign('descripcion',$descripcion);
$smarty->assign('evento',$eventos_id-1000);
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
$smarty->assign('modalidad',$modalidad);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('nboletin',$nboletin);

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('campo3','Tipo:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Estatus:');
$smarty->assign('campo6','Evento:');
$smarty->assign('campo7','Fecha del Evento:');
$smarty->assign('campo8',$tit_nro_doc);
$smarty->assign('campo9',$tit_comenta);
$smarty->assign('campo10','Factura Numero:');
$smarty->assign('varfocus','fordatev.fecha_evento'); 

$smarty->display('m_dateven.tpl');
$smarty->display('pie_pag.tpl');
?>
