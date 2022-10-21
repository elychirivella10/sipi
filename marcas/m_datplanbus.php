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

function isEmail2(who,formulario) {
  var emailpat=/^[A-Za-z0-9][\w-.]+@[A-Za-z0-9]([\w-.]+[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i;
  if (!emailpat.test(who)) { alert('¡ Cuenta Email o Correo no Válido ...!!!'); formulario.email.focus(); return false }
  return
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

function valenvio(formulario) {
  enviar = formulario.vplus.value;
  if (enviar=='N') {
    formulario.email.value='';
  }
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
// Programa: m_datplanbus.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2012 II Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos

include ("../z_includes.php");
include ("../setting.mysql.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$vsede   = $_SESSION['usuario_sede'];
$fecha   = fechahoy();
$vopc    = $_GET['vopc'];
$subtitulo = "Solicitud de Planillas B&uacute;squeda(s) / Peticionario";
$tbname_1  = "stmbusfac";
$tbname_2  = "stmbusqueda";
$tbname_3  = "stmcntrl";
$tbname_4  = "stmfactura";
$tbname_5  = "stzplanfac";
$fechahoy  = hoy();
//$vsede     = '1';

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo',$subtitulo); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

$factura = $_POST['factura'];
$clave   = trim($_POST["clave"]); 

if (empty($factura) AND empty($clave)) {
    Mensajenew("ERROR: NO ingreso el valor para la Factura o la Exoneracion ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
} 

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

  if ($factura!='') { 
    $nbusfon = 0;
    $factura   = trim($_POST["factura"]); 
    $nfac = 'F0'.$factura;

    //Verificacion de factura en stzplanfac
    $resultado=pg_exec("SELECT * FROM $tbname_5 WHERE nro_factura='$nfac'");
    if (!$resultado) { 
      mensajenew("ERROR: PROBLEMA AL PROCESAR LA CONSULTA DE LA FACTURA ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
      $regfac = pg_fetch_array($resultado);
      $cant = $regfac[cant_plan];
      $nplan1 = $regfac[nplanilla1];
      $nplan2 = $regfac[nplanilla2];
      mensajenew("ERROR: NO. DE FACTURA ".$nfac." YA SE LE IMPRIMIO $cant PLANILLAS BUSQUEDAS, DESDE LA NO. $nplan1 A LA $nplan2 ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();	 
    }

    //Verificacion de factura en stmfactura (fonetica,grafica,derecho)
    //$resultado=pg_exec("SELECT * FROM $tbname_4 WHERE nro_factura='$nfac'");
    //if (!$resultado) { 
    //  mensajenew("ERROR: PROBLEMA AL PROCESAR LA CONSULTA DE LA FACTURA ...!!!","javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    //$filas_found=pg_numrows($resultado); 
    //if ($filas_found!=0) {
    //  $regfac = pg_fetch_array($resultado);
    //  $nfon = $regfac[cant_fonetica];
    //  $ngra = $regfac[cant_grafica];
    //  $nder = $regfac[cant_derecho];
      //if ($nfon!=0) {
      //  mensajenew("ERROR: NO. DE FACTURA ".$factura." USADO ANTERIORMENTE CON ".$nfon." PLANILLA(S) BUSQUEDA(S) FONETICA...!!!","javascript:history.back();","N");
      //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
      //if ($ngra!=0) {
      //  mensajenew("ERROR: NO. DE FACTURA ".$factura." USADO ANTERIORMENTE CON ".$ngra." PLANILLA(S) BUSQUEDA(S) GRAFICA...!!!","javascript:history.back();","N");
      //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
      //if ($nder!=0) {
      //  mensajenew("ERROR: NO. DE FACTURA ".$factura." USADO ANTERIORMENTE CON ".$nder." PAGOS DE DERECHO DE REGISTRO DE MARCAS...!!!","javascript:history.back();","N");
      //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    //}

    //Verificacion de factura en stmbusqueda (fonetica)
    //$fact_usa = "N";
    //$resultado=pg_exec("SELECT * FROM $tbname_2 WHERE nro_recibo='$factura'");
    //if (!$resultado) { 
    //  mensajenew("ERROR: PROBLEMA AL PROCESAR LA CONSULTA DE LA FACTURA ...!!!","javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    //$filas_found=pg_numrows($resultado); $son = $filas_found;
    //if ($filas_found!=0) {
    //  $fact_usa = "S";
    //  mensajenew("ERROR: NO. DE FACTURA ".$factura." USADO ANTERIORMENTE CON ".$son." PLANILLA(S) BUSQUEDA(S) FONETICA...!!!","javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 

    //if ($fact_usa=="N") {
    //  $resultado=pg_exec("SELECT * FROM $tbname_2 WHERE nro_recibo='$nfac'");
    //  if (!$resultado) { 
    //    mensajenew("ERROR: PROBLEMA AL PROCESAR LA CONSULTA DE LA FACTURA ...!!!","javascript:history.back();","N");
    //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    //  $filas_found=pg_numrows($resultado); $son = $filas_found;
    //  if ($filas_found!=0) {
    //    $fact_usa = "S";
    //    mensajenew("ERROR: NO. DE FACTURA ".$nfac." USADO ANTERIORMENTE CON ".$son." PLANILLA(S) BUSQUEDA(S) FONETICA...!!!","javascript:history.back();","N");
    //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    //}


    //Verificacion de factura en stmcntrl (grafica)
    //$resultado=pg_exec("SELECT * FROM $tbname_3 WHERE recibo='$factura'");
    //if (!$resultado) { 
    //  mensajenew("ERROR: PROBLEMA AL PROCESAR LA CONSULTA DE LA FACTURA ...!!!","javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    //$filas_found=pg_numrows($resultado); $son = $filas_found;
    //if ($filas_found!=0) {
    //  $fact_usa = "S";
    //  mensajenew("ERROR: NO. DE FACTURA ".$factura." USADO ANTERIORMENTE CON ".$son." PLANILLA(S) BUSQUEDA(S) GRAFICA...!!!","javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 

    //if ($fact_usa=="N") {
    //  $resultado=pg_exec("SELECT * FROM $tbname_3 WHERE recibo='$nfac'");
    //  if (!$resultado) { 
    //    mensajenew("ERROR: PROBLEMA AL PROCESAR LA CONSULTA DE LA FACTURA ...!!!","javascript:history.back();","N");
    //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    //  $filas_found=pg_numrows($resultado); $son = $filas_found;
    //  if ($filas_found!=0) {
    //    $fact_usa = "S";
    //    mensajenew("ERROR: NO. DE FACTURA ".$nfac." USADO ANTERIORMENTE CON ".$son." PLANILLA(S) BUSQUEDA(S) GRAFICA...!!!","javascript:history.back();","N");
    //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    //}

    //$smarty->assign('varfocus','formarcas2.lced');
    //$smarty->assign('modo','readonly=readonly');
    //$smarty->assign('modo1','disabled'); 
    //$smarty->assign('modo2',''); 
    //$smarty->assign('modo3','');
    
    //Verificando conexion a Mysql para consulta a facturacion
    $mysql = new mod_mysql_db(); 
    $mysql->connection_mysql();
	
    $smarty->assign('modo1','readonly=readonly');

    $factura   = trim($_POST["factura"]);
    //$factura   = '142703';
    $nfac = 'F0'.$factura;
    //Datos de la Factura 
    $objquery = $mysql->query_mysql("SELECT fac_id,cli_id,fac_fecha FROM sfa_factura WHERE fac_num='$nfac'"); 
    $objfilas = $mysql->nums_mysql('',$objquery);
    if ($objfilas==0) {
      mensajenew('ERROR: Factura NO existe en la Base de Datos ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
    $objsfac  = $mysql->objects_mysql('',$objquery);
    $fac_id   = $objsfac->fac_id;
    $fechafac = $objsfac->fac_fecha; 
    $cli_id   = $objsfac->cli_id;
    $fechadep= substr($fechafac,8,2)."/".substr($fechafac,5,2)."/".substr($fechafac,0,4);
    //$fechadep = '31/03/2014';

    //Verificacion que la factura tenga algun servicio de busqueda
    $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('021') AND fac_id=$fac_id"); 
    $totalserv  = $mysql->nums_mysql('',$objdetalle);
    if ($totalserv==0) {
      mensajenew('ERROR: Factura NO presenta ning&uacute;n Costo por Planilla B&uacute;squeda asociado ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    //Datos del Detalle 
    //$nbusfon = 4;
    $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('021') AND fac_id=$fac_id"); 
    $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
    $objsdta = $mysql->objects_mysql('',$objdetalle);
    $serid = $objsdta->ser_id;
    if ($objtotdtalle==0) { $nbusfon = 0; }
    else { 
      $nbusfon = $objsdta->dtalle1_cantidad_ser; 
    //  if ($nfac=='F0142703') { $nbusfon = 6; }
    //  if ($serid=='001') { $prioridad='B'; $prioridad1='B'; }
    //  else  { $prioridad='A'; $prioridad1='A'; }
    }
    $prioridad='B'; $prioridad1='B';
    //Datos del Cliente 
    $objcliente = $mysql->query_mysql("SELECT cli_rifci,cli_nombre,cli_direccion,cli_tlfn1 FROM sfa_cliente WHERE cli_id=$cli_id"); 
    $objtotclie = $mysql->nums_mysql('',$objcliente);
    $objsdta = $mysql->objects_mysql('',$objcliente);
    $crifci  = trim($objsdta->cli_rifci);
    $solicitant = $objsdta->cli_nombre;
    $domicilio = $objsdta->cli_direccion;
    $telefono  = trim($objsdta->cli_tlfn1);

    //$crifci = 'V007428307';
    //$solicitant = 'ROMULO MENDOZA';
    //$domicilio = 'CARACAS';
    //$telefono  = '02123378769';
    if (empty($telefono)) { $telefono="0212"; }  
    //$indole    ="";

    $lced      = substr($crifci,0,1);
    if(is_numeric($lced)){
     //la variable es un numero
     $lced = 'V';
     $nced = $crifci;
    }else{
     //la variable no es numero
     $nced = trim(substr($crifci,1,9));
    }
    //$smarty->assign('factura',$nfac);
    //$smarty->assign('fechadep',$fechadep);
    //$smarty->assign('cisolicita',$crifci);
    //$smarty->assign('solicitant',$nombre);  
    //$smarty->assign('domicilio',$domicilio);
    //$smarty->assign('telefono',$telefono);
    //$smarty->assign('cantidad',$cant_fac);  

    $smarty->assign('modo','readonly=readonly');
    $smarty->assign('modo1','disabled'); 
    $smarty->assign('modo2',''); 
    $smarty->assign('modo3',''); 
    
  }
  if ($clave!='') {
    //if ($clave!='123450p') { 
    //  mensajenew("ERROR: La Clave es INVALIDA, adicionalmente NO hay exoneraci&oacute;n en b&uacute;squedas ...!!!","javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); exit(); 
    //} 	
    $obj_query = $sql->query("select last_value from stzsystem_exonerado_seq");
    $objs = $sql->objects('',$obj_query);
    $factura = $objs->last_value;
    $obj_query = $sql->query("update stzsystem set exonerado=nextval('stzsystem_exonerado_seq')");
    $factura = str_pad($factura,6,"0",STR_PAD_LEFT);
    $nfac = 'E0'.$factura;    
    $nbusfon = 0;
    $nbusgra = 0;
    $fechadep = $fechahoy;
  }	   
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
$smarty->assign('campo10','Cantidad de Planillas:');
$smarty->assign('campo12','Enviar por Correo:');
$smarty->assign('campo13','Correo Electr&oacute;nico:');
$smarty->assign('lced_id',array(' ','V','E','P','J','G')); 
$smarty->assign('lced_de',array(' ','V','E','P','J','G'));
$smarty->assign('vindole_id',array('X','G','C','O','P','N')); 
$smarty->assign('vindole_de',array(' ','Sector Publico','Cooperativa','Comunal','Empresa Privada','Persona Natural'));
$smarty->assign('arraytipom',array('B','A'));
$smarty->assign('arraynotip',array('NORMAL','HABILITADA'));
$smarty->assign('arrayplus',array('N','S'));
$smarty->assign('arraydesplus',array('NO','SI'));

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('nbusfon',$nbusfon);
$smarty->assign('nbusgra',$nbusgra);
$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 
$smarty->assign('vsede',$vsede);
$smarty->assign('prioridad',$prioridad); 
$smarty->assign('prioridad1',$prioridad);
$smarty->assign('indole',$indole); 
$smarty->assign('indole1',$indole);
//$smarty->assign('factura',$factura);
$smarty->assign('factura',$nfac);
$smarty->assign('fechadep',$fechadep);
$smarty->assign('solicitant',$solicitant);
$smarty->assign('lced',$lced);
$smarty->assign('nced',$nced);
$smarty->assign('telefono',$telefono);
$smarty->assign('varfocus','formarcas2.fechadep');

$smarty->display('m_datplanbus.tpl');
$smarty->display('pie_pag.tpl');

?>
