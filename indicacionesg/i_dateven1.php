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
// Programa: i_dateven1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Direccion de Sistemas y Tecnologias de la Informacion / SAPI / MPPCN
// Año: 2022
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

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$dirano=$anno;
$vsol=$anno."-".$numero;

if (empty($vsol))
   { mensajenew("ERROR: Nro. de Expediente vac&iacute;o ...!!!","i_eveind.php","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Verificando conexion
$sql->connection($usuario);

$nboletin = 0;

// Evento de Retiro de Escrito de Oposicion 
if ($eventos_id==240) {
  //Verificando el Boletin de Publicacion
  $resul=pg_exec("SELECT * FROM stzderec a,stzevtrd b WHERE a.nro_derecho='$vder' AND a.estatus IN (3120) AND b.evento=3122 AND b.estat_ant IN (3003) AND a.nro_derecho=b.nro_derecho");
  $filas_found=pg_numrows($resul); 
  if ($filas_found==0) {
    mensajenew("AVISO: Solicitud sin Escrito de Oposicion presentado ...!!!","javascript:history.back();","N"); 
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

$eventos_id  = $eventos_id+3000;
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
  $resul=pg_exec("SELECT * FROM $tbname2 WHERE solicitud='$vsol' AND tipo='I'");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) 
   {
     mensajenew("ERROR: Evento no aplica, Expediente en estatus Migrable por Boletin ...!!!","i_eveind.php","N");     
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
$smarty->assign('evento',$eventos_id-3000);
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

$smarty->display('i_dateven.tpl');
$smarty->display('pie_pag.tpl');
?>
