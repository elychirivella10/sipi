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
// Programa: m_datfacfon.php 
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
$vopc    = $_GET['vopc'];
$subtitulo = "Solicitud de B&uacute;squeda Fon&eacute;tica y/o Gr&aacute;fica";
$tbname_1  = "stmbusfac";
$tbname_2  = "stmbusqueda";
$fechahoy  = hoy();
$vsede     = '1';

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo',$subtitulo); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

if ($vopc==1) {
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

  $factura=$_POST['factura'];
  $nbusfon = 0;

  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE nro_recibo='$factura' AND busqueda='F' AND sede='1'");

  if (!$resultado) { 
     mensajenew("ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $fechadep = $reg[f_recibo];
  $prioridad = $reg[prioridad];
  $nbusfon = $reg[cantidad];
  $solicitant = trim($reg[solicitante]);
  $indole = $reg[indole];
  $lced     = substr($reg[identificacion],0,1);
  $nced     = trim(substr($reg[identificacion],1,9));
  $cedrif   = $reg[identificacion];
  $telefono = trim($reg[telefono]);

  $totalplan = pg_exec("SELECT * FROM $tbname_2 WHERE nro_recibo='$factura'");
  if (!$totalplan) { 
     mensajenew("ERROR: PROBLEMA AL PROCESAR LA CONSULTA ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_plan=pg_numrows($totalplan); 
  if ($filas_plan!=0) {
     mensajenew("ERROR: FACTURA YA CARGADA(S) CON ".$filas_plan." PLANILLA(S) BUSQUEDA(S)...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 

  $smarty->assign('varfocus','formarcas2.lced');
  $smarty->assign('modo','readonly=readonly');
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
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
$smarty->assign('arraytipom',array('B','A'));
$smarty->assign('arraynotip',array('NORMAL','HABILITADA'));

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('nbusfon',$nbusfon);
$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 
$smarty->assign('vsede',$vsede);
$smarty->assign('prioridad',$prioridad); 
$smarty->assign('prioridad1',$prioridad);
$smarty->assign('indole',$indole); 
$smarty->assign('indole1',$indole);
$smarty->assign('factura',$factura);
$smarty->assign('fechadep',$fechadep);
$smarty->assign('solicitant',$solicitant);
$smarty->assign('lced',$lced);
$smarty->assign('nced',$nced);
$smarty->assign('telefono',$telefono);


$smarty->display('m_datfacfon.tpl');
$smarty->display('pie_pag.tpl');

?>
