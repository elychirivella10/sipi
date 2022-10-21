<script language="Javascript"> 

function gestionclases(var1,var2,var3,var4,var5) {
  open("adm_clases1.php?vfac="+var1.value+"&vmod="+var2.value+"&vfon="+var3.value+"&vgra="+var4.value+"&vtip="+var5.value,"Selección de Clase Internacional de Niza", "width=500,height=400,top=20,left=40,scrollbars=YES,titlebar=YES,menubar=NO,toolbar=NO,directories=NO,location=NO,status=NO,resizable=NO"); }

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function habilita(formulario,valor) {
   formulario.modal.value = valor;
   if (formulario.nbusfon.value==0) {
     alert('AVISO: NO puede seleccionar Denominativa porque la cantidad es Cero ...!!!');
     formulario.rmodalidad[0].disabled = true;
     formulario.rmodalidad[1].disabled = false
     formulario.vvienai.disabled = true;
     formulario.vvienae.disabled = true;
   }
   else {
     formulario.vvienai.disabled = false;
     formulario.vvienae.disabled = false;
     formulario.vvienai.focus()
   }
} 

function deshabilita(formulario,valor) {  
   formulario.modal.value = valor;
   if (formulario.nbusgra.value==0) {
     alert('AVISO: NO puede seleccionar Grafica porque la cantidad es Cero ...!!!');
     formulario.rmodalidad[0].disabled = false;
     formulario.rmodalidad[1].disabled = true
     formulario.vvienai.disabled = true;
     formulario.vvienae.disabled = true;
   }
   else {
     formulario.vvienai.disabled = false;
     formulario.vvienae.disabled = false;
     formulario.vvienai.focus()
   }
} 

</script>

<?php
// *************************************************************************************
// Programa: z_ingfonetica.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2012 II Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$vsede   = $_SESSION['usuario_sede'];
$fecha   = fechahoy();

$vopc       = $_GET['vopc'];
$factura    = $_POST['factura'];
$fechadep   = $_POST['fechadep'];
$prioridad  = $_POST['prioridad'];
$prioridad1 = $_POST['prioridad1'];
$solicitant = $_POST['solicitant'];
$rmodalidad = $_POST['rmodalidad'];
$indole     = $_POST['indole'];
$indole1    = $_POST['indole1'];
$lced       = $_POST['lced'];
$nced       = $_POST['nced'];
$telefono   = $_POST['telefono']; 
$vsede      = $_POST['vsede'];
$nbusfon    = $_POST['nbusfon'];
$nbusgra    = $_POST['nbusgra'];
$accion     = $_POST['accion'];
$vplus      = $_POST["vplus"];
$correo     = trim($_POST['email']);
$subtitulo  = "Solicitud(es) de B&uacute;squeda(s) Fon&eacute;tica y/o Gr&aacute;fica";
$vsede      = '1';

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo',$subtitulo);
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado.tpl'); }

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
}

if ($indole=='X') {
  $smarty->display('encabezado1.tpl');
  Mensajenew("ERROR: NO seleccion&oacute; la indole del Solicitante ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit();
} 

if ($vplus=='S') {
  if (empty($correo)) {	
    $smarty->display('encabezado1.tpl');
    Mensajenew("ERROR: La cuenta Correo esta vac&iacute;a para poder env&iacute;ar el resultado de la b&uacute;squeda ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }
} 

if ($vopc==5) {
  $fechahoy = hoy();
  $vsede   = '1';

  //Verificando conexion
  $sql = new mod_db();
  $sql->connection();
  // Obtencion de las Sedes 
  $objquery = $sql->query("SELECT * FROM stzsede WHERE sede='1' ORDER BY sede");
  $objfilas = $sql->nums('',$objquery);
  $objs = $sql->objects('',$objquery);
  for ($contobji=1;$contobji<=$objfilas;$contobji++) {
    $vcodsede[$contobji] = $objs->sede;
    $vnomsede[$contobji] = trim(sprintf("%02d",$objs->sede)." ".trim($objs->nombre));
    $objs = $sql->objects('',$objquery); }	  

  //Eliminacion de Datos relacionados a esta factura del temporal  
  $delplanillas = $sql->del("stmtmpbus","nro_factura='$factura'");
  $del_datos = $sql->del("stmtmpcvfac","factura='$factura'"); 
  $del_datos = $sql->del("stmcvplan","factura='$factura'"); 
    
  //Verificacion de que los campos requeridos esten llenos...
  //if (empty($deposito) || empty($fechadep) || empty($montodep)) {
  //   $smarty->display('encabezado1.tpl');
  //   mensajenew('AVISO: Hay Informacion b&aacute;sica en el formulario que esta Vacia ...!!!','javascript:history.back();','N');
  //   $smarty->display('pie_pag.tpl'); exit(); }

  //La Fecha de Hoy para la solicitud
  $fecharec = hoy();
  
  $smarty->display('encabezado1.tpl');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','readonly=readonly'); 
  $smarty->assign('modo4',''); 
  $smarty->assign('accion',1);
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Factura No.:');
$smarty->assign('campo2','Factura Fecha:');
$smarty->assign('campo3','Prioridad de B&uacute;squeda:');
$smarty->assign('campo4','Solicitante:');
$smarty->assign('campo5','Indole:');
$smarty->assign('campo6','C&eacute;dula/Rif.:');
$smarty->assign('campo7','Nomenclatura:');
$smarty->assign('campo8','Tel&eacute;fono:');
$smarty->assign('campo9','Sede:');
$smarty->assign('campo10','Cantidad de B&uacute;sq. Fon&eacute;ticas a realizar:');
$smarty->assign('campo11','Cantidad de B&uacute;sq. Gr&aacute;ficas a realizar:');
$smarty->assign('campo12','Enviar por Correo:');
$smarty->assign('campo13','Correo Electr&oacute;nico:');
$smarty->assign('lced_id',array(' ','V','E','P','J','G')); 
$smarty->assign('lced_de',array(' ','V','E','P','J','G'));
$smarty->assign('vindole_id',array('X','G','C','O','P','N')); 
$smarty->assign('vindole_de',array(' ','Sector Publico','Cooperativa','Comunal','Empresa Privada','Persona Natural'));
$smarty->assign('arraytipom',array(' ','B','A'));
$smarty->assign('arraynotip',array(' ','NORMAL','HABILITADA'));
$smarty->assign('arrayplus',array('N','S'));
$smarty->assign('arraydesplus',array('NO','SI'));

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('factura',$factura);
$smarty->assign('fechadep',$fechadep);
$smarty->assign('solicitant',$solicitant);
$smarty->assign('indole',$indole); 
$smarty->assign('indole1',$indole); 
$smarty->assign('prioridad',$prioridad);
$smarty->assign('prioridad1',$prioridad);
$smarty->assign('telefono',$telefono); 
$smarty->assign('nbusfon',$nbusfon);
$smarty->assign('nbusgra',$nbusgra);
$smarty->assign('lced',$lced);
$smarty->assign('lced1',$lced);
$smarty->assign('nced',$nced);
$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 
$smarty->assign('vsede',$vsede);  
$smarty->assign('email',$correo);
$smarty->assign('vplus',$vplus);

$smarty->display('m_ingfonetica1.tpl');
$smarty->display('pie_pag.tpl');

?>
