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

function checkear(f)	{
				function no_prever() {
					alert("El archivo buscado y seleccionado no es valido ...!!!");
					f.value='';
				}
				function prever() {
					var campos = new Array("maxpeso", "maxalto", "maxancho");
					for (i = 0, total = campos.length; i < total; i ++)
						f.form[campos[i]].disabled = false;
					actionActual = f.form.action;
					targetActual = f.form.target;
					f.form.action = "previsor.php";
					f.form.target = "ver";
					f.form.submit();
					for (i = 0, total = campos.length; i < total; i ++)
						f.form[campos[i]].disabled = true;
					f.form.action = actionActual;
					f.form.target = targetActual;
				}

				(/\.(pdf)$/i.test(f.value)) ? prever() : no_prever();
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
$ubicacion   = $_POST['ubicacion'];
$cant_pag    = $_POST['cant_pag'];
$fecha_evento= $_POST['fecha_evento'];
$comentario  = $_POST['comentario'];
$documento   = $_POST['documento'];

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
   { mensajenew("ERROR: Nro. de Expediente vac&iacute;o ...!!!","m_eveind_ti.php","N");
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
     mensajenew("ERROR: La Solicitud no ha sido procesada ni impresa su busqueda  ...!!!","m_eveind_ti.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1050");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("AVISO: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind_ti.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

if (($eventos_id==51) || ($eventos_id==54)) {
  if ($modalidad!="D") {
    //Verificando si el expediente ya presenta dicho evento 
    //$resul1=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1050");
    //$filas1_found=pg_numrows($resul1); 
    //$resul2=pg_exec("SELECT * FROM stmaudef WHERE pedido='$vsol'");
    //$filas2_found=pg_numrows($resul2);  
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
     mensajenew("ERROR: Solicitud NO presenta el Evento 234 cargado por jrisquez ...!!!","m_eveind_ti.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Certificados elaborados 
if ($eventos_id==838) {
  if ($estatus!=555) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas ya Registradas ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1838");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind_ti.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Certificados entregados 
if ($eventos_id==840) {
  if ($estatus!=555) {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas ya Registradas ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1840");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind_ti.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

// Evento de Desincorporacion 
if ($eventos_id==982) {
  if (($estatus==500) || ($estatus==600) || ($estatus==751) || ($estatus==915)) { } 
  else {
    mensajenew("AVISO: Evento $eventos_id Aplica solo a Marcas Negadas, Caducas, Desistidas y con Prioridad Extinguida ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //Verificando si el expediente ya presenta dicho evento 
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1982");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("ERROR: Evento cargado el $fechaeve por $loginusr ...!!!","m_eveind_ti.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
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
     mensajenew("ERROR: No existen Datos asociados al Evento ...!!!$eventos_id","javascript:history.back();","N");     
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
$escrito_asoc     = $regeve['escrito_asoc'];

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
     mensajenew("ERROR: Evento no aplica, Expediente en estatus Migrable por Boletin ...!!!","m_eveind_ti.php","N");     
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
$smarty->assign('ubicacion',$ubicacion);
$smarty->assign('cant_pag',$cant_pag);
$smarty->assign('fecha_evento',$fecha_evento);
$smarty->assign('escrito_asoc',$escrito_asoc);
$smarty->assign('documento_dig','../docutemp/escritos/'.$usuario.'_'.$dirano.$numero.'.pdf');
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
if ($escrito_asoc=='S') { $smarty->assign('varfocus','fordatev.cant_pag'); } 
$smarty->display('m_dateven_ti.tpl');
$smarty->display('pie_pag.tpl');
?>
