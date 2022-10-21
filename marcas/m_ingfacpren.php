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

function isEmail2(who,formulario) {
  var emailpat=/^[A-Za-z0-9][\w-.]+@[A-Za-z0-9]([\w-.]+[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i;
  if (!emailpat.test(who)) { alert('� Cuenta Email o Correo no V�lido ...!!!'); formulario.email.focus(); return false }
  return
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


function validar(formulario) {
  formulario.email.value = trim(formulario.email.value);
  if (formulario.email.value=='') {
    alert('Aviso: No ha ingresado un Correo valido ...!!!');
    formulario.email.focus();
    return
  }
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
// Programa: m_ingfacpren.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinaci�n de Inform�tica / Direcci�n de Soporte Administrativo / SAPI / MICO
// Desarrollado en A�o: 2015 I Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos

include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);
$fecha   = fechahoy();
$vopc    = $_GET['vopc'];
$subtitulo = "Pago de Derechos de Registros de Marcas";

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Pago de Publicaciones en Prensa de Marcas / Patentes'); 
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
$smarty->assign('campo1','Factura No.:');
$smarty->assign('campo2','Pago correspondiente a Publicaci&oacute;n en Prensa del Bolet&iacute;n No.:');
$smarty->assign('campo3','Cantidad de Solicitudes de Marcas a Publicar:');
$smarty->assign('campo4','Cantidad de Solicitudes de Patentes a Publicar:');
$smarty->assign('campo5','Correo Electr&oacute;nico:');

//if (($usuario!='rmendoza') AND ($usuario!='ngonzalez')) {
//  mensajenew('AVISO: Opci&oacute;n del sistema en Mantenimiento ...!!!','javascript:history.back();','N');
//  $smarty->display('pie_pag.tpl'); exit();
//}

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.factura');
  $smarty->assign('modo3','disabled'); }

//Verificando conexion
$sql = new mod_db();
$sql->connection($usuario);

//Verifica si el progrma esta en mantenimiento
//$manphp = vman_php("m_ingfacpren.php");
//if ($manphp==1) {
//  MensageError('AVISO: Modulo en Mantenimiento, contactar al Administrador del Sistema ...!!!','N');
//  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);

$smarty->display('m_ingfacpren.tpl');
$smarty->display('pie_pag.tpl');
?>
