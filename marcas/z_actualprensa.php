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

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = trim($_SESSION['usuario_login']);
$fecha   = fechahoy();
$modulo= "z_publiprensa.php";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizaci&oacute;n de Solicitudes Publicadas en Prensa Digital');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//if (($usuario!='khernandez') AND ($usuario!='mcova') AND ($usuario!='aluces') AND ($usuario!='rmendoza')) {
//  mensajenew('AVISO: Usuario NO Autorizado para usar esta Opci&oacute;n del Sistema ...!!!','javascript:history.back();','N');
//  $smarty->display('pie_pag.tpl'); exit();
//}

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Fecha de Publicaci&oacute;n:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo2','N&uacute;mero de Ejemplar:');
$smarty->assign('varfocus','foravzcri.vsol1'); 
$smarty->display('z_actualprensa.tpl');
$smarty->display('pie_pag.tpl');

?>
