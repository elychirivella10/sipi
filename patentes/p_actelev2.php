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
// Programa: p_actelev2.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// Modificado I Semestre 2009 BD - Relacional   
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$sql = new mod_db();
$tbname_1 = "stzevder";
$tbname_2 = "stzevtrd";
$fecha    = fechahoy();
$login    = $_SESSION['usuario_login'];

//Validacion de Entrada
$vder=$_POST["vder"]; 
$anno=$_POST["anno"]; 
$numero=$_POST["numero"];
$fecha_solic=$_POST["fecha_solic"];
$fecha_venci=$_POST["fecha_venci"];
$tipo_paten=$_POST["tipo_paten"];
$nombre=$_POST["nombre"];
$estatus=$_POST["estatus"];
$descripcion=$_POST["descripcion"];
$nameimage=$_POST["nameimage"];
$secuencial=$_POST['secuencial'];
$registro=$_POST['registro'];
$fecha_regis=$_POST["fecha_regis"];
$fecha_publi=$_POST["fecha_publi"];
$tramitante=trim($_POST["tramitante"]);
$poder=$_POST["poder"];
$agente=$_POST["agente"];
$titular=$_POST["titular"];
$tnombre=$_POST["tnombre"];
$tdomicilio=$_POST["tdomicilio"];
$tpais_resid=$_POST["tpais_resid"];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Mantenimiento de Eventos Cargados Patentes');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$dirano=$anno;
$vsol=$anno."-".$numero;

$smarty->assign('arraytipom',array(V,A,B,C,D,G,E,F));
$smarty->assign('arraynotip',array('','INVENCION','DIBUJO','MEJORA','INTRODUCCION','DISE&Ntilde;O INDUSTRIAL','MODELO INDUSTRIAL','MODELO DE UTILIDAD'));

if (empty($secuencial)) { $secuencial = 0; }

//Verificando conexion
$sql->connection($login);

//Obtención de los Paises
$obj_query = $sql->query("SELECT * FROM stzpaisr ORDER BY nombre");
if (!$obj_query) { 
  mensajenew("Problema al intentar realizar la consulta en la tabla stzpaisr ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  mensajenew("La Tabla de Paises esta Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
$cont = 0;
$arraycodpais[$cont]=0;
$arraynompais[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
 { 
   $arraycodpais[$cont]=$objs->pais;
   $arraynompais[$cont]=trim($objs->nombre);
   $objs = $sql->objects('',$obj_query);
 }

$documento=0;
$comentario="";

if ($secuencial!=0) {
  //Obtención del Evento de la Solicitud de Patentes
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho='$vder' AND secuencial= $secuencial");
  if (!$obj_query) { 
    Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_q2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $totalevm=$filas_found;
  if ($filas_found==0) {
    Mensajenew("No existen Eventos de Tramite para la Solicitud ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $secuencial = $objs->secuencial;
  $evento     = $objs->evento-2000;
  $esta_ant   = $objs->estat_ant-2000;
  $fecha_event= $objs->fecha_event;
  $fecha_venc = $objs->fecha_venc;
  $fecha_trans= $objs->fecha_trans;
  $documento  = $objs->documento;
  $comentario = trim($objs->comentario);
  $usuario    = $objs->usuario;
}

if ($titular!=0) {
  //Obtención de los Datos del Titular 
  $obj_query = $sql->query("SELECT a.titular,b.nombre,a.domicilio,a.nacionalidad 
                            FROM stzottid a,stzsolic b 
                            WHERE (a.titular=b.titular) AND a.nro_derecho='$vder' AND a.titular='$titular'"); 
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla stpottid o stztitur ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $totalevm=$filas_found;
  if ($filas_found==0) {
    mensajenew("No existen Titulares asociados a la Solicitud ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $titular = $objs->titular;
  $tnombre = trim($objs->nombre);
  $tdomicilio= trim($objs->domicilio);
  $tpais_resid= $objs->nacionalidad;
}

//Desconexion a la Base de Datos
$sql->disconnect();

$smarty->assign('vder',$vder);
$smarty->assign('anno',$dirano);
$smarty->assign('numero',$numero);
$smarty->assign('nombre',$nombre);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('fecha_venci',$fecha_venci);
$smarty->assign('tipo_paten',$tipo_paten);
$smarty->assign('estatus',$estatus);
$smarty->assign('descripcion',$descripcion);
$smarty->assign('fecha_publi',$fecha_publi);
$smarty->assign('registro',$registro);
$smarty->assign('fecha_regis',$fecha_regis);
$smarty->assign('tramitante',$tramitante);
$smarty->assign('poder',$poder);
$smarty->assign('agente',$agente);
$smarty->assign('arraycodpais',$arraycodpais);
$smarty->assign('arraynompais',$arraynompais);

$smarty->assign('evento',$evento);
$smarty->assign('eve_nombre',$evendesc);
$smarty->assign('documento',$documento);
$smarty->assign('comentario',$comentario);
$smarty->assign('usuario',$usuario);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('esta_ant',$esta_ant);
$smarty->assign('fecha_event',$fecha_event);
$smarty->assign('fecha_trans',$fecha_trans);
$smarty->assign('fecha_venc',$fecha_venc);
$smarty->assign('secuencial',$secuencial);
$smarty->assign('titular',$titular);
$smarty->assign('tnombre',$tnombre);
$smarty->assign('tdomicilio',$tdomicilio);
$smarty->assign('tpais_resid',$tpais_resid);

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('campo3','Tipo:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Estatus:');
$smarty->assign('campo6','Evento:');
$smarty->assign('campo7','Estatus Anterior:');
$smarty->assign('campo8','Fecha del Evento:');
$smarty->assign('campo9','Fecha de Vencimiento:');
$smarty->assign('campo10','Fecha de Transaccion:');
$smarty->assign('campo11','Documento');
$smarty->assign('campo12','Comentario');
$smarty->assign('campo13','Usuario');
$smarty->assign('campo14','Secuencia Control');
$smarty->assign('campo15','Fecha Publicacion:');
$smarty->assign('campo16','Registro:');
$smarty->assign('campo17','Fecha Registro:');
$smarty->assign('campo18','Fecha Vencimiento:');
$smarty->assign('campo19','Poder:');
$smarty->assign('campo20','Agente:');
$smarty->assign('campo21','Tramitante:');

$smarty->assign('campo24','Nombre:');
$smarty->assign('campo25','Domicilio:');
$smarty->assign('campo26','Pais:');
$smarty->assign('campo27','C&oacute;digo:');

$smarty->assign('varfocus','fordatev.evento'); 
$smarty->display('p_actelev2.tpl');
$smarty->display('pie_pag.tpl');
?>
