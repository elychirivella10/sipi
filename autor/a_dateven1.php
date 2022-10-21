<script language="Javascript">

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
// Programa: a_dateven1.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2008
// Modificado Año: 2009
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables
$sql       = new mod_db();
$tbname_q1 = "stdevobr";
$fecha     = fechahoy();

// Obtencion de variables de los campos del tpl
$conx   = $_GET['conx'];
$salir  = $_GET['salir'];
$nconex = $_POST['nconex'];

$vsol        =$_POST["vsol"];
$vder        =$_POST["vder"];
$fecha_solic =$_POST["fecha_solic"];
$fecha_venc  =$_POST["fecha_venc"];
$tipo_obra   =$_POST["tipo_obra"];
$nombre      =$_POST["nombre"];
$estatus     =$_POST["estatus"];
$descripcion =$_POST["descripcion"];
$eventos_id  =$_POST["eventos_id"];
$input2      =$_POST["input2"];
$usuario     =$_POST['usuario'];
$role        =$_POST['role'];

$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// ************************************************************************************
// Control de acceso: Entrada y Salida al Modulo
if ($conx==0) {
  $smarty->assign('n_conex',$nconex);      }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

if (empty($vsol)) { 
   mensajenew("ERROR: Nro. de Expediente vacio ...!!!","a_eveind.php?nconex={$nconex}&salir=1&conx=0","N");
   $smarty->display('pie_pag.tpl'); exit(); }

//Verificando conexion
$sql->connection($usuario);

//Verificando si el expediente ya presenta dicho evento 
if ($eventos_id==64) {
  $resul=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho='$vder' AND evento=64");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
     $regtrami = pg_fetch_array($resul);
     $fechaeve = trim($regtrami['fecha_trans']);
     $loginusr = trim($regtrami['usuario']); 
     mensajenew("AVISO: Evento cargado el $fechaeve por $loginusr ...!!!","a_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
}  

if ($eventos_id==65) {
    mensajenew("AVISO: Evento $eventos_id NO Aplica en esta pantalla ...!!!","a_eveind.php","N");
    $smarty->display('pie_pag.tpl'); exit();
}

//Verificando Código Evento en tabla básica de Eventos de Marcas
//if (!empty($vsol)) {
  $resultado=pg_exec("SELECT * FROM $tbname_q1 WHERE evento='$eventos_id'"); 
  $filas_found=pg_numrows($resultado);
//}
if (!$resultado) {
     mensajenew("ERROR: Código de Evento NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  }
//$filas_found=pg_numrows($resultado);
if ($filas_found==0) {
     mensajenew("ERROR: No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  }

$regeve          = pg_fetch_array($resultado);
$evendesc        = trim($regeve['descripcion']);
$tipo_evento     = $regeve['tipo_evento'];
$inf_adicional   = trim($regeve['inf_adicional']);
$mensa_automatico= trim($regeve['mensa_automatico']);
$tit_comenta     = trim($regeve['tit_comenta']);
$tit_nro_doc     = trim($regeve['tit_nro_doc']);
$tipo_plazo      = $regeve['tipo_plazo'];
$plazo_ley       = $regeve['plazo_ley'];
$aplica          = $regeve['aplica'];
$documento       = 0;
$comentario      = "";

//Se verifica si el usuario puede o no cargar el evento seleccionado
$aplica = even_rol($role,$eventos_id);
if ($aplica==0) {
  mensajenew("ERROR: El Usuario NO tiene permiso para Cargar el Evento Seleccionado ...!!!","a_eveind.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$tipoevento = $tipo_evento;

//Desconexion a la Base de Datos
$sql->disconnect();

$smarty->assign('vsol',$vsol);
$smarty->assign('vder',$vder); 
$smarty->assign('nombre',$nombre);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('fecha_venc',$fecha_venc);
$smarty->assign('tipo_obra',$tipo_obra);
$smarty->assign('estatus',$estatus);
$smarty->assign('descripcion',$descripcion);
$smarty->assign('evento',$eventos_id);
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

$smarty->display('a_dateven.tpl');
$smarty->display('pie_pag.tpl');
?>
