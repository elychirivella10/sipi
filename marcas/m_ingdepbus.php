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
// Programa: m_ingdepbus.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2012 II Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos

include ("../z_includes.php");
include("$include_lib/class.phpmailer.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$vopc    = $_GET['vopc'];
$subtitulo = "Solicitud de B&uacute;squeda Fon&eacute;tica y/o Gr&aacute;fica";

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_marca'>";
echo " <td>";
echo "   <i><b><font>$subtitulo</font></b></i>";
echo " </td>";
echo "</table>"; 

//Verificando conexion
$sql = new mod_db();
$sql->connection();

$nbusfon = 0;
$nbusgra = 0;
//$costo_fon = calculo_costo("N","F");
//$costo_gra = calculo_costo("N","G");

if ($vopc!=1) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
}

$fechahoy = hoy();

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Tr&aacute;mite Control No.: ');
$smarty->assign('campo2','Entidad Financiera:');
$smarty->assign('campo3','Deposito No.:');
$smarty->assign('campo4','Fecha Deposito:');
$smarty->assign('campo5','Hora Deposito:');
$smarty->assign('campo6','Monto Deposito:');
$smarty->assign('campo7','Nombre o Denominaci&oacute;n a Buscar:');
$smarty->assign('campo8','Clases:');
$smarty->assign('campo9','Cantidad de B&uacute;sq. Fon&eacute;ticas a realizar:');
$smarty->assign('campo10','Cantidad de B&uacute;sq. Gr&aacute;ficas a realizar:');

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.banco');
  $smarty->assign('modo3','disabled'); }

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('banco',$banco);
$smarty->assign('nbusfon',$nbusfon);
$smarty->assign('nbusgra',$nbusgra);
$smarty->assign('costo_fon',$costo_fon);
$smarty->assign('costo_gra',$costo_gra);
$smarty->assign('vcodban',$vcodban);
$smarty->assign('vnomban',$vnomban); 

$smarty->display('m_ingdepbus.tpl');
$smarty->display('pie_pag.tpl');

?>

