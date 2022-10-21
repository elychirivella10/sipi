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
  if (valor < 2655) {
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
  var monto_fon, monto_gra, monto_acumulado, monto_total;
  monto_fon = formulario.nbusfon.value * formulario.costo_fon.value;
  monto_gra = formulario.nbusgra.value * formulario.costo_gra.value;
  monto_acumulado = monto_fon+monto_gra;
  deposito1 = formulario.montodep.value * 1;
  deposito2 = formulario.montodep1.value * 1;
  monto_total= (deposito1+deposito2);
  if (monto_acumulado > 0) {
    if (monto_acumulado > monto_total) {
      alert('Monto Depositado insuficiente para los Servicios a solicitar ...!!!'+' Bs. '+monto_acumulado);
      formulario.nbusfon.value = 0;
      formulario.nbusgra.value = 0;
      formulario.montofon.value = 0;
      formulario.montogra.value = 0;
      formulario.montodep.value = 0;
      formulario.montodep1.value = 0;
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
// Programa: z_ingpagdernac.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2016 II Semestre
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
$subtitulo = "Servicio de Pago de Derechos de Registro de Marcas Nacionales";

// ****************************************
$smarty->assign('titulo','Sistema En L&iacute;nea de Propiedad Intelectual Caracas - Venezuela');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->assign('boletinvigente',$boletinvigente);
$smarty->assign('fechatopepago30',$fechatopepago30);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado2.tpl'); }

echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_marca'>";
echo " <td>";
echo "   <i><b><font>$subtitulo</font></b></i>";
echo " </td>";
echo "</table>"; 

//Verificando conexion
$sql = new mod_db();
$sql->connection();

$contobji=0;
$vcodsede[$contobji] = 'G000000000';
$vnomsede[$contobji] = '                          ';
$objquery = $sql->query("SELECT * FROM stzbancos WHERE tipo=1 ORDER BY nombre");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
  $vcodban[$contobji] = $objs->rif;
  $vnomban[$contobji] = trim($objs->nombre);
  $objs = $sql->objects('',$objquery); }	  

$nbusfon = 0;
$nbusgra = 0;
$costo_fon = calculo_costo("N","PDM");

if ($vopc!=1) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
}

$fechahoy = hoy();
//Incremento de Control de estadisticas
$modulo= "mod_derechomar";
$sys_actual = control_auditor($usuario,$fechahoy,$modulo);

//mensajenew('AVISO: Opci&oacute;n del sistema en Mantenimiento ...!!!','javascript:history.back();','N');
//$smarty->display('pie_pag.tpl'); exit();

if (($usuario!='rmendoza@sapi.gob.ve') AND ($usuario!='ngonzalez@sapi.gob.ve')) {
  mensajenew('AVISO: Opci&oacute;n del sistema pr&oacute;ximamente disponible al P&uacute;blico ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit();
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Tr&aacute;mite Control No.: ');
$smarty->assign('campo2','Entidad Financiera:');
$smarty->assign('campo3','Deposito No.:');
$smarty->assign('campo4','Fecha Deposito:');
$smarty->assign('campo5','Hora Deposito:');
$smarty->assign('campo6','Monto Deposito:');
//$smarty->assign('campo7','Nombre Buscar:');
//$smarty->assign('campo8','Clases:');
$smarty->assign('campo9','Cantidad de Marcas a pagar:');
//$smarty->assign('campo10','Cantidad de Patentes a publicar:');
$smarty->assign('campo11','Del Bolet&iacute;n Vigente:');

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.banco');
  $smarty->assign('modo3','disabled'); }

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
//$smarty->assign('banco',$banco);
$smarty->assign('nbusfon',$nbusfon);
$smarty->assign('nbusgra',$nbusgra);
$smarty->assign('costo_fon',$costo_fon);
$smarty->assign('costo_gra',$costo_gra);
$smarty->assign('vcodban',$vcodban);
$smarty->assign('vnomban',$vnomban); 

$smarty->display('z_ingpagdernac.tpl');
$smarty->display('pie_pag2.tpl');

?>

