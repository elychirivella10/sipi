<script language="Javascript"> 

function gestionclases(var1,var2,var3) {
  open("adm_clases.php?vfac="+var1.value+"&vmod="+var2.value+"&vfon="+var3.value,"Selección de Clase Internacional de Niza", "width=500,height=400,top=20,left=40,scrollbars=YES,titlebar=YES,menubar=NO,toolbar=NO,directories=NO,location=NO,status=NO,resizable=NO"); }

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
$fecha   = fechahoy();

$vopc       = $_GET['vopc'];
$factura    = $_POST['factura'];
$fechadep   = $_POST['fechadep'];
$prioridad  = $_POST['prioridad'];
$prioridad1 = $_POST['prioridad1'];
$solicitant = $_POST['solicitant'];
$indole     = $_POST['indole'];
$indole1    = $_POST['indole1'];
$lced       = $_POST['lced'];
$nced       = $_POST['nced'];
$telefono   = $_POST['telefono']; 
$vsede      = $_POST['vsede'];
$nbusfon    = $_POST['nbusfon'];
$accion     = $_POST['accion'];
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
$smarty->assign('lced_id',array(' ','V','E','P','J','G')); 
$smarty->assign('lced_de',array(' ','V','E','P','J','G'));
$smarty->assign('vindole_id',array(' ','G','C','O','P','N')); 
$smarty->assign('vindole_de',array(' ','Sector Publico','Cooperativa','Comunal','Empresa Privada','Persona Natural'));
$smarty->assign('arraytipom',array(' ','B','A'));
$smarty->assign('arraynotip',array(' ','NORMAL','HABILITADA'));

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('factura',$factura);
$smarty->assign('fechadep',$fechadep);
$smarty->assign('solicitant',$solicitant);
$smarty->assign('indole',$indole1); 
$smarty->assign('indole1',$indole1); 
$smarty->assign('prioridad',$prioridad1);
$smarty->assign('prioridad1',$prioridad1);
$smarty->assign('telefono',$telefono); 
$smarty->assign('nbusfon',$nbusfon);
$smarty->assign('lced',$lced);
$smarty->assign('lced1',$lced);
$smarty->assign('nced',$nced);
$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 
$smarty->assign('vsede',$vsede);  

$smarty->display('m_ingfonetica.tpl');
$smarty->display('pie_pag.tpl');

?>
