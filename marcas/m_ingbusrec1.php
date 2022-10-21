<script language="Javascript"> 

function validaMonto(){
  var monto=document.getElementById('txtmonto').value;
  var patron=/^\d+(\.\d{1,2})?$/;
  if(!patron.test(monto)){
    alert('Valor ingresado incorrecto ...!!!');
    document.getElementById('txtmonto').focus();
    document.formarcas2.txtmonto.focus();
    return false;
  }else{ }
}

function valmontodep() {
  var valor = document.getElementById("montodep").value;
  if( isNaN(valor) ) {
    alert('Valor ingresado del Monto del Deposito es incorrecto ...!!!');
    document.formarcas2.montodep.focus();
    return false;
  }
}

function valminimo(formulario) {
  var valor = document.getElementById("montodep").value;
  formulario.montofon.value = formulario.nbusfon.value * formulario.costo_fon.value;
  formulario.montogra.value = formulario.nbusgra.value * formulario.costo_gra.value;
  if (valor < 50) {
    alert('Valor ingresado en Monto del Deposito menor al permitido ...!!!');
    document.getElementById("montodep").focus();
    formulario.nbusfon.value = 0;
    formulario.nbusgra.value = 0;
    return
  }
  
}

function validavalor() {
var valor = document.getElementById("horadep").value;
if ((valor>=1) && (valor<=24)) {
  alert('Valor ingresado correcto ...!!!');
  document.formarcas2.horadep.focus();
  return false;
}
}

function valcantidad(vtipo,formulario)
 {
  var monto_fon, monto_gra, monto_acumulado;
  monto_fon = formulario.nbusfon.value * formulario.costo_fon.value;
  monto_gra = formulario.nbusgra.value * formulario.costo_gra.value;
  monto_acumulado = monto_fon+monto_gra;
  if (monto_acumulado > 0) {
    if (monto_acumulado > formulario.montodep.value) {
      alert('Monto Depositado insuficiente para los Servicios a solicitar ...!!!'+' Bs. '+monto_acumulado);
      formulario.nbusfon.value = 0;
      formulario.nbusgra.value = 0;
      formulario.montofon.value = 0;
      formulario.montogra.value = 0;
      formulario.montodep.value = 0;
      formulario.nbusfon.focus();
    }
  }
  return 
 }

</script>

<script type="text/javascript">
String.prototype.reverse=function(){return this.split('').reverse().join('');};
function number_condec(e){
function f(){
var v=this.value;
var pos=v.indexOf('.');
var vdec=v.substring(pos+1,pos+3);
var vent=v.substring(0,pos);
if (pos>0) {this.value=vent.concat('.').concat(vdec);}
this.value=this.value.reverse().replace(/[^0-9.]/g,'').replace(/\.(?=\d*[.]\d*)/g,'').reverse();
}
e.onkeyup=f
e.onkeydown=f
e.onkeypress=f
e.onmousedown=f
e.onmouseup=f
e.onclick=f
e.onchange=t
e.onblur=f
}

function number_sindec(e){
function f(){
this.value=this.value.reverse().replace(/[^0-9]/g,'').replace(/\.(?=\d*[.]\d*)/g,'').reverse();
}
e.onkeyup=f
e.onkeydown=f
e.onkeypress=f
e.onmousedown=f
e.onmouseup=f
e.onclick=f
e.onchange=t
e.onblur=f
}

function solo2dec(n) {
   var v=n.value;
   var pos=v.indexOf('.');
   var vdec=v.substring(pos+1,pos+3);
   var vent=v.substring(0,pos);
   var vfin=vent.concat('.').concat(vdec);
   if (pos>0) {n.value=vfin;}
}

</script>

<?php
// *************************************************************************************
// Programa: m_ingbusrec1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2014 II Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos

include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$sede    = $_SESSION['usuario_sede'];
$fecha   = fechahoy();
$vopc    = $_GET['vopc'];
$subtitulo = "Carga de Solicitud(es) de B&uacute;squeda Fon&eacute;tica y/o Gr&aacute;ficas Diarias";

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Carga de Solicitud(es) de B&uacute;squeda(s) Fon&eacute;tica y/o Gr&aacute;ficas Diarias'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

if ($vopc!=1) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
}
$fechahoy = hoy();

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Ingrese N&uacute;mero de Factura:');
$smarty->assign('campo2','Fecha de Recibida la Factura en Informaci&oacute;n:');

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.factura');
  $smarty->assign('modo3','disabled'); }

//Verificando conexion
//$sql = new mod_db();
//$sql->connection($usuario);

//Verifica si el progrma esta en mantenimiento
//$manphp = vman_php("m_ingfacfon1.php");
//if ($manphp==1) {
//  MensageError('AVISO: Modulo en Mantenimiento, contactar al Administrador del Sistema ...!!!','N');
//  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
//$smarty->assign('fecharec',$fechahoy);

$smarty->display('m_ingbusrec1.tpl');
$smarty->display('pie_pag.tpl');
?>
