<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function gestionvienap(var1,var3,var4) {
  open("adm_bviena.php?vsol="+var1.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script>

<?php
// *************************************************************************************
// Programa: m_pbexfigu.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

//Conexion
$sql = new mod_db();
$sql->connection($usuario);

//Variables
$tbname_1 = "stmcntrl";
$tbname_2 = "stmviena";
$tbname_3 = "stzusuar";
$tbname_4 = "stmtmpccv";

$fecha   = fechahoy();

$vopc=$_GET['vopc'];
$vauxnum=$_GET['vauxnum'];
$vsol1=$_POST['vsol1'];
$recibo=$_POST['recibo'];
$fecharec=$_POST['fecharec'];
$prioridad=$_POST['prioridad'];
$solicitant=$_POST['solicitant'];
$accion=$_POST['accion'];
$clase=$_POST['clase'];

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if ($vopc==1) {
  $smarty->assign('subtitulo','B&uacute;squeda Externa de Elemento Figurativo'); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('accion',1);
}

//Borra tablas temporales anteriores a la fecha de hoy 
//del_tmpef();

if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

$smarty->assign('arraytipom',array(N,L));
$smarty->assign('arraynotip',array('NORMAL','LINEA'));

//Opcion Procesar
if ($vopc==1) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3',''); 
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('submitbutton','button');
  $smarty->assign('subtitulo','B&uacute;squeda Externa de Elemento Figurativo'); 
  $smarty->assign('accion',1);

  //Validacion del Numero de Solicitud
  if (empty($vsol1)) {
     mensajenew('No introdujo ningún valor de Pedido ...!!!','m_pbexfigu.php?vopc=5','N');
     $smarty->display('pie_pag.tpl'); exit(); }

  //Nombre de la Imagen del Expediente 
  $nameimage="../graficos/logbext/".$vsol1.".jpg";
  $smarty->assign('nameimage',$nameimage);

  //Verificando conexion
  //$sql->connection();
  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE pedido='$vsol1'");
  if (!$resultado) { 
     mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_pbexfigu.php?vopc=5','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','m_pbexfigu.php?vopc=5','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $reg = pg_fetch_array($resultado);

  $vsol1=$reg[pedido];
  $recibo=$reg[recibo];
  $fecharec=$reg[fecharec];
  $solicitant=trim($reg[solicitant]);
  $prioridad=$reg[prioridad];
  $fechaing=$reg[fechaing];
  $horaing=$reg[hora];

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($recibo,$fecharec,$solicitant,$prioridad,$fechaing,$horaing);
  $campos = "recibo|fecharec|solicitant|prioridad|fechaing|hora";
  $vstring = bitacora_fields();
  $smarty->assign('fecharec',$fecharec);
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);

  $sql->del("$tbname_4","solicitud='$vsol1'");
  
  //Desconexion de la Base de Datos
  $sql->disconnect();
}

if ($vopc!=1) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton','button');
  $smarty->assign('submitbutton3','button');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
  $nameimage="../imagenes/sin_imagen.jpg";
  $smarty->assign('nameimage',$nameimage);
}

if ($vopc==5) {
  $smarty->assign('subtitulo','B&uacute;squeda Externa de Elemento Figurativo'); 
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton3','button');
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',1);
  $smarty->display('encabezado1.tpl');
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Pedido No.:');
$smarty->assign('campo2','Fecha busqueda:');
$smarty->assign('campo3','Tipo de busqueda:');
$smarty->assign('campo4','Recibo Numero:');
$smarty->assign('campo5','Solicitante:');
$smarty->assign('campo6','en Clase:');
$smarty->assign('campo7','Logotipo:');
$smarty->assign('campo8','Cod. Viena:');
$smarty->assign('lcviena','C&oacute;digos de Viena '); 

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.clase'); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('prioridad',$prioridad); }

$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('recibo',$recibo);
$smarty->assign('fecharec',$fecharec);
$smarty->assign('prioridad',$prioridad);
$smarty->assign('solicitant',$solicitant);
$smarty->assign('$clase',$clase);

$smarty->display('m_pbexfigu.tpl');
$smarty->display('pie_pag.tpl');
?>
