<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function validatelefono(campo) {
  valor = campo.value;
  if( !(/^\(\d{3}\)\s\d{7}$/.test(valor)) ) {
    alert('¡ Numero de Telefono Incorrecto ...!!!');
    campo.focus();
    return false;
  }
}

function isEmail2(who,formulario) {
  var emailpat=/^[A-Za-z0-9][\w-.]+@[A-Za-z0-9]([\w-.]+[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i;
  if (!emailpat.test(who)) { alert('¡ Cuenta Email o Correo no Válido ...!!!'); formulario.email.value=''; document.all.email.focus(); return false }
  return
}

function isEmail3(who,formulario) {
  var emailpat=/^[A-Za-z0-9][\w-.]+@[A-Za-z0-9]([\w-.]+[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i;
  if (!emailpat.test(who)) { formulario.email.value=''; document.all.email.focus(); return false }
  return
}

function valvacio(campo,valor) {
	if (campo.value=='') {
		alert('El campo '+valor.value+'esta vacio ...!!!');
	   campo.focus();
		return false;
	}
}


function fn(form,field)
{
 var next=0, found=false
 var f=form
 if(event.keyCode!=13) return;
 for(var i=0;i < f.length;i++) {
	if(field.name==f.item(i).name){
		next=i+1;
		found=true
		break;
	}
 }
 while(found){
	if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){
		f.item(next).focus();
		break;
	}
	else{
		if(next < f.length-1)
			next=next+1;
		else
			break;
	}
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

<script type="text/javascript">
String.prototype.reverse=function(){return this.split('').reverse().join('');};
function number_tel(e){
function f(){
this.value=this.value.reverse().replace(/[^0-9-]/g,'').replace(/\-(?=\d*[-]\d*)/g,'').reverse();
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
function number_mail(e){
function f(){
this.value=this.value.reverse().replace(/[^0-9.\-\@\_\A-Z\a-z]/g,'').replace(/\@(?=\d*[@]\d*)/g,'').reverse();
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

</script>

<?php
// *************************************************************************************
// Programa: z_agentes.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$sql      = new mod_db();
$tbname_1 = "stzagenr";
$fecha    = fechahoy();

$vopc    = $_GET['vopc'];
$accion  = $_POST['accion'];
$agente  = $_POST['agente'];
$nombre  = $_POST['nombre'];
$agente2 = $_POST['agente2'];
$domicilio = $_POST['domicilio'];
$profesion = $_POST['profesion'];

$letra     = $_POST['lced'];
$cedula    = $_POST['cedula'];
$telefono1 = $_POST['celular'];
$telefono2 = $_POST['telefonoh'];
$email1    = $_POST['email'];
$email2    = $_POST['email2'];
$codcolegio= $_POST['codcolegio'];
$inpre     = $_POST['inpre'];

$vstring   = $_POST['vstring'];
$campos    = $_POST['campos'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Agentes'); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Agentes / Ingreso'); }
if ($vopc==4 || $vopc==1) {
  $smarty->assign('subtitulo','Mantenimiento de Agentes / Modificaci&oacute;n'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
}

if ($vopc==5) {
  if (empty($agente)) {
    mensajenew("AVISO: No introdujo ningún valor de Agente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 
  
  //Verificando conexion
  $sql->connection($usuario);
  $resulm = pg_exec("select * from stzagenr WHERE agente='$agente'");
  $regm = pg_fetch_array($resulm);
  $nfil = pg_numrows($resulm);
  if ($nfil>0) {
   Mensajenew("ERROR: Codigo de Agente ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  $smarty->assign('agente',$agente);
  $smarty->assign('agente2',$agente);  
  $smarty->assign('varfocus','frmagente2.nombre');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('accion',1);
  $smarty->assign('profesion','V');
}   

//Opcion de Modificacion
if ($vopc==1) {
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('subtitulo','Mantenimiento de Agentes / Modificaci&oacute;n'); 
  $smarty->assign('accion',2);
  $smarty->assign('varfocus','frmagente2.nombre');

  //Verificando conexion
  $sql->connection($usuario);

  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE agente='$agente'");
  if (!$resultado) { 
    mensajenew("ERROR AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $agente=$reg[agente];
  $nombre=trim($reg[nombre]);
  $domicilio=trim($reg[domicilio]);
  $profesion=$reg[profesion];
  $email1=trim($reg[email]);
  $email2=trim($reg[email2]);
  $telefono1=trim($reg[telefono1]);
  $telefono2=trim($reg[telefono2]);
  $codcolegio=trim($reg[nro_colegiado]);
  $inpre=trim($reg[inpre]);
  $documento=trim($reg[cedula]);
  $cedula = substr($documento,1,10);
  $letra  = substr($documento,0,1);

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($nombre,$domicilio,$profesion);
  
  $campos = "nombre|domicilio|profesion";
  $vstring = bitacora_fields();

  //Paso a Smarty los Valores
  $smarty->assign('agente',$agente);
  $smarty->assign('nombre',$nombre);
  $smarty->assign('domicilio',$domicilio);
  $smarty->assign('profesion',$profesion);
  $smarty->assign('celular',$telefono1);
  $smarty->assign('telefonoh',$telefono2);
  $smarty->assign('email',$email1);
  $smarty->assign('email2',$email2);
  $smarty->assign('codcolegio',$codcolegio);
  $smarty->assign('inpre',$inpre);
  $smarty->assign('cedula',$cedula);
  $smarty->assign('lced',$letra);

  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);

}

if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Agentes / Ingreso'); 
  $smarty->assign('varfocus','frmagente1.agente');
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('accion',1);
  $smarty->assign('profesion','V');
}

if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Agentes / Modificaci&oacute;n'); 
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2',''); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('accion',2);
  $smarty->assign('agente',$agente);
  $smarty->assign('varfocus','frmagente1.agente');   
}

//Opcion Grabar...
if ($vopc==2) {
  $smarty->assign('modo',''); 
  $smarty->assign('modo2','disabled'); 

  //Verificando conexion
  $sql->connection($usuario);

  if ($accion==1) { 
    $valor_edo=$agente2; }
  else {
    $valor_edo=$agente; }

  //Validacion del Numero de Evento
  if (empty($valor_edo)) {
    mensajenew("No introdujo ning&uacute;n valor en Agente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificacion de que los campos requeridos esten llenos...
  if (empty($nombre) || $profesion=="V") {
    mensajenew("ERROR: Hay Informacion basica en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //al Incluir
  if ($accion==1) {
    pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzagenr IN SHARE ROW EXCLUSIVE MODE");
    $resultado=pg_exec("SELECT * FROM stzagenr WHERE agente='$valor_edo'");
    $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
      mensajenew("ERROR: Codigo de Agente YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 


    $horactual = Hora();
    $fechahoy  = hoy();
    $email1 = strtolower($email1);
    $email2 = strtolower($email2); 
    if($letra=='V') { $cedula = str_pad($cedula,10,"0",STR_PAD_LEFT); $documento = $letra.$cedula; }
    else { $documento = $letra.$cedula; } 
    $col_campos = "agente,nombre,domicilio,profesion,estatus_age,telefono1,telefono2,email,email2,cedula,pais_domicilio,fecha_ingre,hora_ingre,usuario,nro_colegiado,inpre";
    $insert_str = "$valor_edo,'$nombre','$domicilio','$profesion','A','$telefono1','$telefono2','$email1','$email2','$documento','VE','$fechahoy','$horactual','$usuario','$codcolegio','$inpre'";
    $sql->insert("$tbname_1","$col_campos","$insert_str","");
    pg_exec("COMMIT WORK");
  }

  //al Modificar
  if ($accion==2) {
    //Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");

    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();

    // Almaceno registro original en Bitacora
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_1','M','M','$agente','$vstring','$campos'";
    //$sql->insert("$tbname_2","","$insert_str","");

    if($letra=='V') { $cedula = str_pad($cedula,10,"0",STR_PAD_LEFT); $documento = $letra.$cedula; }
    else { $documento = $letra.$cedula; } 
    //echo "colegio=$codcolegio";
    // Actualizo en Maestra de Eventos
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stzagenr IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "nombre='$nombre',cedula='$documento',domicilio='$domicilio',profesion='$profesion',telefono1='$telefono1',telefono2='$telefono2',email='$email1',email2='$email2',nro_colegiado='$codcolegio',inpre='$inpre'";
    $sql->update("$tbname_1","$update_str","agente='$agente'");
    pg_exec("COMMIT WORK");
  }
  //Desconexion de la Base de Datos
  $sql->disconnect();

  if ($accion==2) {
    mensajenew('DATOS ACTUALIZADOS CORRECTAMENTE !!!','z_agentes.php?vopc=4','S');
    $smarty->display('pie_pag.tpl'); exit(); }
  else {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','z_agentes.php?vopc=3','S');
    $smarty->display('pie_pag.tpl'); exit(); }
}

$smarty->assign('apli_inf',array(V,A,E,O));
$smarty->assign('apli_def',array('','Abogado','Economista','Otro'));

$smarty->assign('doc_inf',array(N,V,E,P));
$smarty->assign('doc_def',array('','V','E','P'));

$smarty->assign('campo1','Agente:');
$smarty->assign('campo2','Apellidos y Nombres:');
$smarty->assign('campo3','Documento de Identidad:');
$smarty->assign('campo4','Domicilio:');
$smarty->assign('campo5','Profesion:');

$smarty->assign('campo6','Tel&eacute;fono1:');
$smarty->assign('campo7','Tel&eacute;fono2:');
$smarty->assign('campo8','Cuenta Correo:');
$smarty->assign('campo9','Correo alternativo:');
$smarty->assign('campo10','N&uacute;mero Colegiado:');
$smarty->assign('campo11','Inpre:');
$smarty->assign('vopc',$vopc);

$smarty->display('z_agentes.tpl');
$smarty->display('pie_pag.tpl');
?>
