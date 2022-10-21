<script language="Javascript"> 
function isetivalida(campo) {
   var veti2=document.getElementById("veti");
   if(veti2.value.length<10)
    {
     alert('Etiqueta no Valida ...!!! Coloque al menos 10 caracteres');
     veti.value=''; campo.focus(); return false }
  return
  }

function visible_anexopoder(estado) {
   if (estado) { 
         document.all.ubipoder.style.display='inline';
         document.all.ubipoder.visibility='visible'; }
   else {
         document.all.ubipoder.style.display='none';
         document.all.ubipoder.visibility='hidden';  }    
}
function visible_anexoregla(estado) {
   if (estado) { 
         document.all.ubiregla.style.display='inline';
         document.all.ubiregla.visibility='visible'; }
   else {
         document.all.ubiregla.style.display='none';
         document.all.ubiregla.visibility='hidden';  }    
}
function visible_anexoprior(estado) {
   if (estado) { 
         document.all.ubiprior.style.display='inline';
         document.all.ubiprior.visibility='visible'; }
   else {
         document.all.ubiprior.style.display='none';
         document.all.ubiprior.visibility='hidden';  }    
}
function visible_anexocerti(estado) {
   if (estado) { 
         document.all.ubicerti.style.display='inline';
         document.all.ubicerti.visibility='visible'; }
   else {
         document.all.ubicerti.style.display='none';
         document.all.ubicerti.visibility='hidden';  }    
}
function visible_anexopago(estado) {
   if (estado) { 
         document.all.ubipago.style.display='inline';
         document.all.ubipago.visibility='visible'; }
   else {
         document.all.ubipago.style.display='none';
         document.all.ubipago.visibility='hidden';  }    
}
function visible_anexoregis(estado) {
   if (estado) { 
         document.all.ubiregis.style.display='inline';
         document.all.ubiregis.visibility='visible'; }
   else {
         document.all.ubiregis.style.display='none';
         document.all.ubiregis.visibility='hidden';  }    
}
function visible_anexoacta(estado) {
   if (estado) { 
         document.all.ubiacta.style.display='inline';
         document.all.ubiacta.visibility='visible'; }
   else {
         document.all.ubiacta.style.display='none';
         document.all.ubiacta.visibility='hidden';  }    
}
function visible_anexocedula(estado) {
   if (estado) { 
         document.all.ubicedula.style.display='inline';
         document.all.ubicedula.visibility='visible'; }
   else {
         document.all.ubicedula.style.display='none';
         document.all.ubicedula.visibility='hidden';  }    
}
function visible_anexorif(estado) {
   if (estado) { 
         document.all.ubirif.style.display='inline';
         document.all.ubirif.visibility='visible'; }
   else {
         document.all.ubirif.style.display='none';
         document.all.ubirif.visibility='hidden';  }    
}
function visible_anexootro(estado) {
   if (estado) { 
         document.all.ubiotro.style.display='inline';
         document.all.ubiotro.visibility='visible'; }
   else {
         document.all.ubiotro.style.display='none';
         document.all.ubiotro.visibility='hidden';  }    
}

function visible_ref(estado) {
   if (estado==1){
         document.all.tbusfon.style.display='inline';
         document.all.tbusfon.visibility='visible';
         document.all.vbusfon.style.display='inline';
         document.all.vbusfon.visibility='visible';
         document.all.vbusfon.focus();
         document.all.tbusgra.style.display='none';
         document.all.tbusgra.visibility='hidden';
         document.all.vbusgra.style.display='none';
         document.all.vbusgra.visibility='hidden';
         document.all.teti.style.display='none';
         document.all.teti.visibility='hidden';
         document.all.veti.style.display='none';
         document.all.veti.visibility='hidden';
   }
   if (estado==2){
         document.all.tbusfon.style.display='none';
         document.all.tbusfon.visibility='hidden';
         document.all.vbusfon.style.display='none';
         document.all.vbusfon.visibility='hidden';
         document.all.tbusgra.style.display='inline';
         document.all.tbusgra.visibility='visible';
         document.all.vbusgra.style.display='inline';
         document.all.vbusgra.visibility='visible';
         document.all.teti.style.display='inline';
         document.all.teti.visibility='visible';
         document.all.veti.style.display='inline';
         document.all.veti.visibility='visible';
         document.all.vbusgra.focus();
   }
   if (estado==3){
         document.all.tbusfon.style.display='inline';
         document.all.tbusfon.visibility='visible';
         document.all.vbusfon.style.display='inline';
         document.all.vbusfon.visibility='visible';
         document.all.vbusfon.focus();
         document.all.tbusgra.style.display='inline';
         document.all.tbusgra.visibility='visible';
         document.all.vbusgra.style.display='inline';
         document.all.vbusgra.visibility='visible';
         document.all.teti.style.display='inline';
         document.all.teti.visibility='visible';
         document.all.veti.style.display='inline';
         document.all.veti.visibility='visible';
   }
   document.all.vtipbus.value=estado;
}

function visible_per(estado) {
   if (estado==1){
         document.all.tpernat.style.display='inline';
         document.all.tpernat.visibility='visible';
         document.all.lcedtit.style.display='inline';
         document.all.lcedtit.visibility='visible';
         document.all.lcedtit.value='V';
         document.all.vcedtit.style.display='inline';
         document.all.vcedtit.visibility='visible';
         document.all.vcedtit.value='';
         document.all.vcedtit.focus();
         document.all.vpastit.style.display='none';
         document.all.vpastit.visibility='hidden';
         document.all.vpastit.value='';
         document.all.tperjurn.style.display='none';
         document.all.tperjurn.visibility='hidden';
         document.all.lriftit.style.display='none';
         document.all.lriftit.visibility='hidden';
         document.all.vriftit.style.display='none';
         document.all.vriftit.visibility='hidden';
         document.all.vriftit.value='';
         document.all.tperjure.style.display='none';
         document.all.tperjure.visibility='hidden';
         document.all.vnomtit.style.display='none';
         document.all.vnomtit.visibility='hidden';
         document.all.vnomtit.value='';
   }
   if (estado==2 || estado==3){
         document.all.tpernat.style.display='none';
         document.all.tpernat.visibility='hidden';
         document.all.lcedtit.style.display='none';
         document.all.lcedtit.visibility='hidden';
         document.all.vcedtit.style.display='none';
         document.all.vcedtit.visibility='hidden';
         document.all.vcedtit.value='';
         document.all.vpastit.style.display='none';
         document.all.vpastit.visibility='hidden';
         document.all.vpastit.value='';
         document.all.tperjurn.style.display='inline';
         document.all.tperjurn.visibility='visible';
         document.all.lriftit.style.display='inline';
         document.all.lriftit.visibility='visible';
         document.all.lriftit.value='J';
         document.all.vriftit.style.display='inline';
         document.all.vriftit.visibility='visible';
         document.all.vriftit.value='';
         document.all.vriftit.focus();
         document.all.tperjure.style.display='none';
         document.all.tperjure.visibility='hidden';
         document.all.vnomtit.style.display='none';
         document.all.vnomtit.visibility='hidden';
         document.all.vnomtit.value='';
   }
   if (estado==4){
         document.all.tpernat.style.display='none';
         document.all.tpernat.visibility='hidden';
         document.all.lcedtit.style.display='none';
         document.all.lcedtit.visibility='hidden';
         document.all.vcedtit.style.display='none';
         document.all.vcedtit.visibility='hidden';
         document.all.vcedtit.value='';
         document.all.vpastit.style.display='none';
         document.all.vpastit.visibility='hidden';
         document.all.vpastit.value='';
         document.all.tperjurn.style.display='none';
         document.all.tperjurn.visibility='hidden';
         document.all.lriftit.style.display='none';
         document.all.lriftit.visibility='hidden';
         document.all.vriftit.style.display='none';
         document.all.vriftit.visibility='hidden';
         document.all.vriftit.value='';
         document.all.tperjure.style.display='inline';
         document.all.tperjure.visibility='visible';
         document.all.vnomtit.style.display='inline';
         document.all.vnomtit.visibility='visible';
         document.all.vnomtit.value='';
         document.all.vnomtit.focus();
   }
   document.all.vtipper.value=estado;
}

function visible_age(estado) {
   if (estado==1){
         document.all.tperage.style.display='inline';
         document.all.tperage.visibility='visible';
         document.all.vcodage.style.display='inline';
         document.all.vcodage.visibility='visible';
         document.all.vcodage.value='';
         document.all.vcodage.focus();
         document.all.tpertra.style.display='none';
         document.all.tpertra.visibility='hidden';
         document.all.lcedtra.style.display='none';
         document.all.lcedtra.visibility='hidden';
         document.all.lcedtra.value='V';
         document.all.vcedtra.style.display='none';
         document.all.vcedtra.visibility='hidden';
         document.all.vcedtra.value='';
         document.all.vpastra.style.display='none';
         document.all.vpastra.visibility='hidden';
         document.all.vpastra.value='';
   }
   if (estado!=1){
         document.all.tperage.style.display='none';
         document.all.tperage.visibility='hidden';
         document.all.vcodage.style.display='none';
         document.all.vcodage.visibility='hidden';
         document.all.vcodage.value='';
         document.all.tpertra.style.display='inline';
         document.all.tpertra.visibility='visible';
         document.all.lcedtra.style.display='inline';
         document.all.lcedtra.visibility='visible';
         document.all.lcedtra.value='V';
         document.all.vcedtra.style.display='inline';
         document.all.vcedtra.visibility='visible';
         document.all.vcedtra.value='';
         document.all.vcedtra.focus();
         document.all.vpastra.style.display='none';
         document.all.vpastra.visibility='hidden';
         document.all.vpastra.value='';
   }
   document.all.vtipage.value=estado;
}

function visible_pas(estado) {
   if (estado!="P"){
         document.all.vcedtit.style.display='inline';
         document.all.vcedtit.visibility='visible';
         document.all.vcedtit.focus();
         document.all.vpastit.style.display='none';
         document.all.vpastit.visibility='hidden';
   }
   if (estado=="P"){
         document.all.vpastit.style.display='inline';
         document.all.vpastit.visibility='visible';
         document.all.vpastit.focus();
         document.all.vcedtit.style.display='none';
         document.all.vcedtit.visibility='hidden';
   }
}

function visible_pai(estado) {
   if (estado=="Nacional"){
         document.all.vpav.style.display='inline';
         document.all.vpav.visibility='visible';
         document.all.vpap.style.display='none';
         document.all.vpap.visibility='hidden';
   }
   if (estado=="Extranjero"){
         document.all.vpap.style.display='inline';
         document.all.vpap.visibility='visible';
         document.all.vpav.style.display='none';
         document.all.vpav.visibility='hidden';
   }
   document.all.vtippro.value=estado;
}

function visible_cedtra(estado) {
   if (estado!="P"){
         document.all.vcedtra.style.display='inline';
         document.all.vcedtra.visibility='visible';
         document.all.vcedtra.focus();
         document.all.vpastra.style.display='none';
         document.all.vpastra.visibility='hidden';
   }
   if (estado=="P"){
         document.all.vpastra.style.display='inline';
         document.all.vpastra.visibility='visible';
         document.all.vpastra.focus();
         document.all.vcedtra.style.display='none';
         document.all.vcedtra.visibility='hidden';
   }
}

function pregunta() { 
  return confirm('Estas seguro de enviar la Informacion ?'); }

function b_titular(v1,v2,v3,v4,v5,v6,v7,v8,v9,v10) {
  open("adm_titulares.php?vsol="+v1.value+"&tper="+v2.value+"&lced="+v3.value+"&vced="+v4.value+"&lrif="+v5.value+"&vrif="+v6.value+"&vnom="+v7.value+"&vtmp="+v8.value+"&vtra="+v9.value+"&vpas="+v10.value,"Ventana","scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function b_agente(v1,v2,v3,v4,v5,v6,v7,v8) {
  open("adm_agentes.php?vsol="+v1.value+"&tper="+v2.value+"&lced="+v3.value+"&vced="+v4.value+"&vpas="+v5.value+"&vcod="+v6.value+"&vtmp="+v7.value+"&vtra="+v8.value,"Ventana","scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function b_prioridad(v1,v2,v3,v4) {
  open("adm_prioridad.php?vsol="+v1.value+"&vpri="+v2.value+"&vtmp="+v3.value+"&vtra="+v4.value,"Ventana","scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function b_busqueda(v1,v2,v3,v4,v5,v6) {
  open("adm_busqueda.php?vsol="+v1.value+"&tbus="+v2.value+"&vfon="+v3.value+"&vgra="+v4.value+"&vtmp="+v5.value+"&vtra="+v6.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function ValidaCosto(c,md,cs) {
var cant=c.value;
var mdep=md.value;
var cost=cs.value;
if ((cant*cost)>mdep) {
  alert('Monto Depositado insuficiente para la cantidad de Solicitudes...!!!'); 
  c.value='';
  md.value='';
  document.all.md.focus(); }
if ((cant==0) || (cant=='')) { alert('La Cantidad de Marcas a Solicitar debe ser mayor a 0');}
return false; 
}

function checkear(f)	{
				function no_prever() {
					alert("El archivo buscado y seleccionado no es valido ...!!!");
					f.value='';
				}
				function prever() {
					var campos = new Array("maxpeso", "maxalto", "maxancho");
					for (i = 0, total = campos.length; i < total; i ++)
						f.form[campos[i]].disabled = false;
					actionActual = f.form.action;
					targetActual = f.form.target;
					f.form.action = "previsor.php";
					f.form.target = "ver";
					f.form.submit();
					for (i = 0, total = campos.length; i < total; i ++)
						f.form[campos[i]].disabled = true;
					f.form.action = actionActual;
					f.form.target = targetActual;
				}

				(/\.(pdf)$/i.test(f.value)) ? prever() : no_prever();
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
function parpadeo() {
var imagen = document.images["parpadeante"];
imagen.style.visibility = (imagen.style.visibility == "visible") ? "hidden" : "visible";
}
setInterval("parpadeo()", 500);
</script>

<script type="text/javascript">
function parpadeo2() {
var imagen = document.images["parpadeante2"];
imagen.style.visibility = (imagen.style.visibility == "visible") ? "hidden" : "visible";
}
setInterval("parpadeo2()", 500);
</script>

<?php
// *************************************************************************************
// Programa: z_solmarweb.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2010 II Semestre
// *************************************************************************************
include ("../setting.inc.php");
ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Para trabajar con Envios de Correo
include("$include_lib/class.phpmailer.php"); 
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Variables
$fecha    = fechahoy();
$fechahoy = hoy();
$vopc     = $_GET['vopc'];
$vreftra  = $_POST['vreftra'];
$vrefsol  = $_POST['vrefsol'];
$vnumsol  = $_POST['vnumsol'];
$ventfin  = $_POST['ventfin'];
$vnomban  = $_POST['vnomban'];
$vnomban2  = $_POST['vnomban2'];
$vnumdep  = $_POST['vnumdep'];
$fechadep = $_POST['fechadep'];
$vmondep  = $_POST['vmondep'];
$accion   = $_POST['accion'];
$vcansol  = $_POST['vcansol'];
$cosxmar  = $_POST['cosxmar'];
$tramite  = $_POST['tramite'];

$checkpaisn='checked';
$checkpaise='';
$checksigno1='checked';
$checksigno2='';
$checksigno3='';
$checkreffon='display:inline'; 
$checkrefgra='display:none';
$checkdespaisn='display:inline';  
$checkdespaise='display:none';
$checka=''; $checkb=''; $checkc=''; $checkf='';
$checkg=''; $checkh=''; $checki=''; $checko='';

$smarty->assign('titulo','Sistema En Line de Propiedad Intelectual Caracas - Venezuela');
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Solicitud de Marca'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->assign('vmodo','normal');
$smarty->display('encabezado2.tpl');

// Guardar Tramite Completo
if ($vopc==3 and $tramite=='Guardar Datos de la Solicitud') {
  $sql->disconnect();
  $sql1 = new mod_db();
  $sql1->connection1();  

  $resultado=pg_exec("SELECT * FROM stztmpbus WHERE nro_tramite=$vreftra and solicitud=$vrefsol order by solicitud");
  $filas_found=pg_numrows($resultado);
  $vf_cantmarca=pg_numrows($resultado); 
  $can_error=0;
  $primer='S';
  for($cont=1;$cont<=$filas_found;$cont++) { 
     $regtra = pg_fetch_array($resultado); 
     $vrefsol=$regtra['solicitud'];
     $vtipmar=$regtra['tipo_marca'];
     if ($vtipmar=='P') {$vtipmar='M';}
     $vfeccar=$regtra['fecha_carga'];
     $vlc_ama=$regtra['lc_amarca'];
     $vlc_sol=$regtra['lc_solicitud'];
     $vlc_reg=$regtra['lc_registro'];
     $vtippro=$regtra['tipo_producto'];
     $vpaipro=$regtra['pais_producto'];
     $vclaint=$regtra['clase_int'];
     $vclanac=$regtra['clase_nac'];
     $vdis=$regtra['distingue'];
     $vtipmp=$regtra['tipo_mp'];
     $vnombre=$regtra['nombre'];
     $vtipsig=$regtra['tipo_signo'];
     if ($vtipsig=='N') {$vtipsig='D';}
     $vreffon=$regtra['ref_fonetica'];
     $vrefgra=$regtra['ref_grafica'];
     $veti=$regtra['etiqueta'];
     $horactual= Hora();
     // vector que almacena los datos de las solicitudes para el correo
     $vf_solmar0[$cont]=$vrefsol;
     $vf_solmar1[$cont]=$vnombre;
     $vf_solmar2[$cont]=$vtipmar;
     $vf_solmar3[$cont]=$vclaint;
     $vf_solmar4[$cont]=$vclanac;
     $vf_solmar5[$cont]=$vtipsig;
     if ($vtipsig=='D') {$vf_solmar6[$cont]=$vreffon;}
     if ($vtipsig=='G') {$vf_solmar6[$cont]=$vrefgra;}
     if ($vtipsig=='M') {$vf_solmar6[$cont]=$vreffon.'/'.$vrefgra;} 
     //
     pg_exec("BEGIN WORK");
     // Insertamos en la Tabla (stmsolref)
     $insert_campo="nro_tramite,solicitud,ref_fon,ref_gra";  
     $insert_valor="'$vreftra','$vrefsol',$vreffon,$vrefgra";
     $chequeo=pg_exec("SELECT * FROM stmsolref WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
     $fil_chequeo=pg_numrows($chequeo);
     if ($fil_chequeo>0) { $valido=pg_exec("DELETE FROM stmsolref where nro_tramite='$vreftra' and solicitud='$vrefsol'"); } 
     else {$valido = pg_exec("INSERT INTO stmsolref (nro_tramite,solicitud,ref_fon,ref_gra) VALUES ('$vreftra','$vrefsol',$vreffon,$vrefgra)");}
     if (!$valido) {$can_error=$can_error+1;}
     // Insertamos en la Tabla (stmmarce)
     $insert_campo="nro_tramite,solicitud,clase,ind_claseni,modalidad,distingue,ind_producto";  
     $insert_valor="'$vreftra','$vrefsol','$vclaint','I','$vtipsig','$vdis','$vtippro'";
     $chequeo=pg_exec("SELECT * FROM stmmarce WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
     $fil_chequeo=pg_numrows($chequeo);
     if ($fil_chequeo>0) { $valido=pg_exec("DELETE FROM stmmarce where nro_tramite='$vreftra' and solicitud='$vrefsol'"); } 
     else {$valido = pg_exec("INSERT INTO stmmarce (nro_tramite,solicitud,clase,ind_claseni,modalidad,distingue,ind_producto) VALUES ('$vreftra','$vrefsol','$vclaint','I','$vtipsig','$vdis','$vtippro')"); }
     if (!$valido) {$can_error=$can_error+1;}
     // Insertamos en la Tabla (stmclnac)
     $insert_campo="nro_tramite,solicitud,clase_nac";  
     $insert_valor="'$vreftra','$vrefsol','$vclanac'";
     $chequeo=pg_exec("SELECT * FROM stmclnac WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
     $fil_chequeo=pg_numrows($chequeo);
     if ($fil_chequeo>0) { $valido=pg_exec("DELETE FROM stmclnac where nro_tramite='$vreftra' and solicitud='$vrefsol'"); } 
     else {$valido = pg_exec("INSERT INTO stmclnac (nro_tramite,solicitud,clase_nac) VALUES ('$vreftra','$vrefsol','$vclanac')"); }
     if (!$valido) {$can_error=$can_error+1;} 
     // Insertamos en la Tabla (stmlogos)
     if ($vtipsig=='M' or $vtipsig=='G') {
        $insert_campo="nro_tramite,solicitud,descripcion";  
        $insert_valor="'$vreftra','$vrefsol','$veti'";
        $chequeo=pg_exec("SELECT * FROM stmlogos WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
        $fil_chequeo=pg_numrows($chequeo);
        if ($fil_chequeo>0) { $valido=pg_exec("DELETE FROM stmlogos where nro_tramite='$vreftra' and solicitud='$vrefsol'"); } 
        else {$valido = pg_exec("INSERT INTO stmlogos (nro_tramite,solicitud,descripcion) VALUES ('$vreftra','$vrefsol','$veti')"); }
        if (!$valido) {$can_error=$can_error+1;}
     }
     // Insertamos en la Tabla (stmlemad)
     if ($vclaint==47) {
        $insert_campo="nro_tramite,solicitud,solicitud_aso,registro_aso";  
        $insert_valor="'$vreftra','$vrefsol','$vlc_sol','$vlc_reg'";
        $chequeo=pg_exec("SELECT * FROM stmlemad WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
        $fil_chequeo=pg_numrows($chequeo);
        if ($fil_chequeo>0) { $valido=pg_exec("DELETE FROM stmlemad where nro_tramite='$vreftra' and solicitud='$vrefsol'"); } 
        else {$valido = pg_exec("INSERT INTO stmlemad (nro_tramite,solicitud,solicitud_aso,registro_aso) VALUES ('$vreftra','$vrefsol','$vlc_sol','$vlc_reg')"); }
        if (!$valido) {$can_error=$can_error+1;}
     }
     // Insertamos en la Tabla (stzagenr y stzautod)
     $vtrami1='';
     $vpoder1='';
     $vagente1=0;
     $idtram=0;
     $resage=pg_exec("SELECT * FROM stztmpage WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
     $fil_age=pg_numrows($resage); 
     for($cont2=1;$cont2<=$fil_age;$cont2++) { 
        $regage = pg_fetch_array($resage); 
        $aage=$regage['agente'];
        $anac=$regage['nacionalidad'];   
        $adom=$regage['domicilio'];
        $atag=$regage['tipo_per'];
        $anom=$regage['nombre'];
        $apod=$regage['poder'];
        $ate1=$regage['telefono1'];
        $ate2=$regage['telefono2'];
        $aem1=$regage['email'];
        $aem2=$regage['email2'];
        $aide=$regage['identificacion'];
        $afax=$regage['fax'];
        if ($cont2==1) { if ($atag=='1') {$vagente1=$aage; $vpoder1=$apod;}
                         if ($atag=='2') {$vtrami1=$anom; $idtram=$vrefsol;}
                         if ($atag=='3') {$vagente1=$aage; $vpoder1=$apod;}
        }
        if ($atag=='1' or $atag=='3') {
           // stzagenr
           $res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$aage'");
           $fil_agen=pg_numrows($res_agen); 
           if ($fil_agen>0) {
              // update
              $update_str="nombre='$anom',domicilio='$adom',profesion=' ',estatus_age='A', telefono1='$ate1',telefono2='$ate2',fax='$afax',email='$aem1',email2='$aem2',cedula='$aide', nacionalidad='$anac'";
              $update_cond="agente='$aage'";
              $valido = pg_exec("UPDATE stzagenr SET nombre='$anom',domicilio='$adom',profesion=' ',estatus_age='A', telefono1='$ate1',telefono2='$ate2',fax='$afax',email='$aem1',email2='$aem2',cedula='$aide', nacionalidad='$anac' WHERE agente='$aage'");
              if (!$valido) {$can_error=$can_error+1;}
           } else {
              // insert
              if ($atag=='3') { $atagletra='P'; } else { $atagletra='A'; } 
              $insert_campo="agente,nombre,domicilio,profesion,estatus_age,telefono1,telefono2, email,email2,cedula,nacionalidad,fax,tipo";  
              $insert_valor="$aage,'$anom','$adom',' ','A','$ate1','$ate2', '$aem1','$aem2','$aide','$anac','$afax','$atagletra'";
              $valido = pg_exec("INSERT INTO stzagenr (agente,nombre,domicilio,profesion,estatus_age,telefono1,telefono2, email,email2,cedula,nacionalidad,fax,tipo) VALUES ($aage,'$anom','$adom',' ','A','$ate1','$ate2', '$aem1','$aem2','$aide','$anac','$afax','$atagletra')");     
              if (!$valido) {$can_error=$can_error+1;}           
           }
           // stzautod
           $insert_campo="nro_tramite,solicitud,agente";  
           $insert_valor="'$vreftra','$vrefsol',$aage";
           $chequeo=pg_exec("SELECT * FROM stzautod WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
           $fil_chequeo=pg_numrows($chequeo);
           if ($fil_chequeo>0) { $valido=pg_exec("DELETE FROM stzautod where nro_tramite='$vreftra' and solicitud='$vrefsol'"); } 
           else {$valido = pg_exec("INSERT INTO stzautod (nro_tramite,solicitud,agente) VALUES ('$vreftra','$vrefsol',$aage)"); }
           if (!$valido) {$can_error=$can_error+1;}
        } else {
           // stztramr
           $res_tram=pg_exec("SELECT * FROM stztramr WHERE cedula='$aide'");
           $fil_tram=pg_numrows($res_tram); 
           if ($fil_tram>0) {
              // update
              $regtram=pg_fetch_array($res_tram); 
              $idtram=$regtram['idtramitante'];
              $update_str="nombre='$anom',domicilio='$adom',telefono1='$ate1',telefono2='$ate2',fax='$afax',email='$aem1',email2='$aem2',nacionalidad='$anac'";
              $update_str_ch = $update_str;
              $update_cond="cedula='$aide'";
              $valido = pg_exec("UPDATE stztramr SET nombre='$anom',domicilio='$adom',telefono1='$ate1',telefono2='$ate2',fax='$afax',email='$aem1',email2='$aem2',nacionalidad='$anac' WHERE cedula='$aide'");
              if (!$valido) {$can_error=$can_error+1;}
           } else {
              // insert
              $insert_campo="idtramitante,domicilio,telefono1,telefono2,email,email2,cedula,nacionalidad,fax,nombre";  
              $insert_valor="$vrefsol,'$adom','$ate1','$ate2', '$aem1','$aem2','$aide','$anac','$afax','$anom'";
              $valido = pg_exec("INSERT INTO stztramr (idtramitante,domicilio,telefono1,telefono2,email,email2,cedula,nacionalidad,fax,nombre) VALUES ($vrefsol,'$adom','$ate1','$ate2', '$aem1','$aem2','$aide','$anac','$afax','$anom')");     
              if (!$valido) {$can_error=$can_error+1;}           
           }
        } 
     }
     // Insertamos en la Tabla (stzderec)
     $insert_campo="nro_tramite,solicitud,tipo_derecho,fecha_solic,tipo_mp,nombre,estatus, pais_resid,poder,tramitante,agente,hora_solic,idtramitante";  
     $insert_valor="'$vreftra','$vrefsol','$vtipmar','$vfeccar','$vtipmp','$vnombre',0, '$vpaipro','$vpoder1','$vtrami1',$vagente1,'$horactual','$idtram'";
     $chequeo=pg_exec("SELECT * FROM stzderec WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
     $fil_chequeo=pg_numrows($chequeo);
     if ($fil_chequeo>0) { $valido=pg_exec("DELETE FROM stzderec where nro_tramite='$vreftra' and solicitud='$vrefsol'"); } 
     else {$valido = pg_exec("INSERT INTO stzderec (nro_tramite,solicitud,tipo_derecho,fecha_solic,tipo_mp,nombre,estatus, pais_resid,poder,tramitante,agente,hora_solic,idtramitante) VALUES ('$vreftra','$vrefsol','$vtipmar','$vfeccar','$vtipmp','$vnombre',0, '$vpaipro','$vpoder1','$vtrami1',$vagente1,'$horactual','$idtram')"); }
     if (!$valido) {$can_error=$can_error+1;}
     // Insertamos en la Tabla (stzsolic y stzottid)
     $restit=pg_exec("SELECT * FROM stztmptit WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
     $fil_tit=pg_numrows($restit); 
     for($cont3=1;$cont3<=$fil_tit;$cont3++) { 
        $regtit = pg_fetch_array($restit); 
        $ttit=$regtit['titular'];
        $tide=$regtit['identificacion'];
        $tnac=$regtit['nacionalidad'];   
        $tdom=$regtit['domicilio'];
        $tnom=$regtit['nombre'];
        $tind=$regtit['indole'];
        $tte1=$regtit['telefono1'];
        $tte2=$regtit['telefono2'];
        $tem1=$regtit['email'];
        $tem2=$regtit['email2'];
        $tfax=$regtit['fax'];
        // stzsolic
        $res_soli=pg_exec("SELECT * FROM stzsolic WHERE titular='$ttit'");
        $fil_soli=pg_numrows($res_soli); 
        if ($fil_soli>0) {
           // update
           $update_str="identificacion='$tide',nombre='$tnom',indole='$tind', telefono1='$tte1',telefono2='$tte2',fax='$tfax',email='$tem1',email2='$tem2'";
           $update_cond="titular='$ttit'";
           $valido = pg_exec("UPDATE stzsolic SET identificacion='$tide',nombre='$tnom',indole='$tind', telefono1='$tte1',telefono2='$tte2',fax='$tfax',email='$tem1',email2='$tem2' WHERE titular='$ttit'");
           if (!$valido) {$can_error=$can_error+1;}
        } else {
           // insert
           $insert_campo="titular,identificacion,nombre,indole, telefono1,telefono2,fax,email,email2";  
           $insert_valor="$ttit,'$tide','$tnom','$tind', '$tte1','$tte2','$tfax','$tem1','$tem2'";
           $valido = pg_exec("INSERT INTO stzsolic (titular,identificacion,nombre,indole, telefono1,telefono2,fax,email,email2) VALUES ($ttit,'$tide','$tnom','$tind', '$tte1','$tte2','$tfax','$tem1','$tem2')");     
           if (!$valido) {$can_error=$can_error+1;}
        }
        // stzottid
        $insert_campo="nro_tramite,solicitud,titular,nacionalidad,domicilio";  
        $insert_valor="'$vreftra','$vrefsol',$ttit,'$tnac','$tdom'";
        $chequeo=pg_exec("SELECT * FROM stzottid WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
        $fil_chequeo=pg_numrows($chequeo);
        if ($fil_chequeo>0) { $valido=pg_exec("DELETE FROM stzottid where nro_tramite='$vreftra' and solicitud='$vrefsol'"); } 
        else {$valido = pg_exec("INSERT INTO stzottid (nro_tramite,solicitud,titular,nacionalidad,domicilio) VALUES ('$vreftra','$vrefsol',$ttit,'$tnac','$tdom')"); }
        if (!$valido) {$can_error=$can_error+1;}
     }
     // Insertamos en la Tabla (stzpriod)
     $respri=pg_exec("SELECT * FROM stztmprio WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
     $fil_pri=pg_numrows($respri); 
     for($cont4=1;$cont4<=$fil_pri;$cont4++) { 
        $regpri = pg_fetch_array($respri); 
        $ppri=$regpri['prioridad'];
        $ppai=$regpri['pais_priori'];
        $pfec=$regpri['fecha_priori'];   
        $insert_campo="nro_tramite,solicitud,prioridad,pais_priori,fecha_priori";  
        $insert_valor="'$vreftra','$vrefsol','$ppri','$ppai','$pfec'";
        $chequeo=pg_exec("SELECT * FROM stzpriod WHERE nro_tramite='$vreftra' and solicitud='$vrefsol'");
        $fil_chequeo=pg_numrows($chequeo);
        if ($fil_chequeo>0) { $valido=pg_exec("DELETE FROM stzpriod where nro_tramite='$vreftra' and solicitud='$vrefsol'"); } 
        else { $valido = pg_exec("INSERT INTO stzpriod (nro_tramite,solicitud,prioridad,pais_priori,fecha_priori) VALUES ('$vreftra','$vrefsol','$ppri','$ppai','$pfec')"); }
        if (!$valido) {$can_error=$can_error+1;}
     }
  }
  if ($can_error==0) { 
     pg_exec("COMMIT WORK");  
     // Vector Datos Usuario 
     $obj_usr = $sql->query("SELECT nombres,apellidos FROM stzusuar WHERE usuario='$usuario'");
     $objs = $sql->objects('',$obj_usr);
     $persona = trim($objs->nombres)." ".trim($objs->apellidos);
     // Enviar Correo de Envio Satisfactorio
     correo($sql_mail,$persona,$usuario,$vreftra,$vf_cantmarca,$cosxmar,$vf_solmar0,$vf_solmar1,$vf_solmar2,$vf_solmar3,$vf_solmar4,$vf_solmar5,$vf_solmar6,$docane);
     //    
     $sql1->disconnect1();
//     mensajenewprinter("Los datos de la(s) solicitud(es) de Marcas fueron Guardados Correctamente! &nbsp;&nbsp;&nbsp;El n&uacute;mero asignado a su Tramite es: ".$vreftra." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Le informamos que este tramite tendr&aacute; validez una vez se consignen los documentos anexos requeridos para cada solicitud de Marcas (ver planilla). A partir de este momento tiene un lapso de diez (10) d&iacute;as h&aacute;biles para realizar dicho proceso; de lo contrario esta solicitud ser&aacute; eliminada de nuestro sistema.","z_enviodoc.php?vopc=1&vreftra=".$vreftra."","../index1.php","S");  
     mensajenew("Datos Guardados Correctamente!!!","javascript:history.back()","N"); 
     $smarty->display('pie_pag.tpl'); exit();}
  else {
     pg_exec("ROLLBACK WORK"); 
     $sql->disconnect();
     mensajenew("Falla en Ingreso de Datos; verifique los datos e intente de nuevo...!!!","javascript:history.back()","N"); 
     $smarty->display('pie_pag.tpl'); exit();}
}

if ($vopc==4) {
  $fechahoy = hoy();
  $fecharec = hoy();
  $horactual= Hora();
  $vopc     = $_GET['vopc'];
  $vreftra  = $_GET['vreftra'];
  $vrefsol  = $_GET['vrefsol'];

  $vnumsol  = $_GET['vnumsol'];
  $ventfin  = $_GET['ventfin'];
  $vnomban2 = $_GET['vnomban2'];
  $vnumdep  = $_GET['vnumdep'];
  $fechadep = $_GET['fechadep'];
  $vmondep  = $_GET['vmondep'];
  $vcansol  = $_GET['vcansol'];
  $cosxmar  = $_GET['cosxmar'];
  $afavor=0;
  if ($vmondep > ($vcansol*$cosxmar)) {
     $afavor=$vmondep-($vcansol*$cosxmar);
  }
  // Vector de Paises 
  $obj_query = $sql->query("SELECT * FROM stzpaisr where pais<>'VE' order by nombre");
  $filas_found=$sql->nums('',$obj_query);
  $cont = 0;
  $arraycodpais[$cont]=0;
  $arraynompais[$cont]='Seleccione pais extranjero';
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
    $arraycodpais[$cont]=$objs->pais;
    $arraynompais[$cont]=trim($objs->nombre);
    $objs = $sql->objects('',$obj_query);  }
  //
  $sql->disconnect();
  $sql1 = new mod_db();
  $sql1->connection1();  
  //
  $obj_query = pg_exec("select * from stztmpbus where nro_tramite='$vreftra' and solicitud='$vrefsol'");
  $objs = pg_fetch_array($obj_query);
  $vtipbus=$objs['tipo_signo'];
  $vtippro=$objs['tipo_producto'];
  if ($vtippro=='N') {$vtippro='Nacional';}
  if ($vtippro=='E') {$vtippro='Extranjero';}
  $vpaisor=$objs['pais_producto'];
  $vbusfon=$objs['ref_fonetica'];
  $vbusgra=$objs['ref_grafica'];
  $veti=$objs['etiqueta'];
  //anexos
  $obj_query = pg_exec("SELECT * FROM stztmpanxtra where nro_tramite='$vreftra' and solicitud='$vrefsol'");
  $filas_found=pg_numrows($obj_query);
  $cont = 0;
  $objs = pg_fetch_array($obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
    $vcodane=$objs['cod_anexo'];
    $vrutane=trim($objs['ruta']);
    if ($vcodane=='A') {$checka='checked disabled';}
    if ($vcodane=='B') {$checkb='checked disabled';}
    if ($vcodane=='C') {$checkc='checked disabled';}
    if ($vcodane=='F') {$checkf='checked disabled';}
    if ($vcodane=='G') {$checkg='checked disabled';}
    if ($vcodane=='H') {$checkh='checked disabled';}
    if ($vcodane=='I') {$checki='checked disabled';}
    if ($vcodane=='0') {$checko='checked disabled';}
    $objs = pg_fetch_array($obj_query);  }
  //
  $smarty->assign('vtipbus',$vtipbus);
  $smarty->assign('vtippro',$vtippro);
  $smarty->assign('vpaisor',$vpaisor);
  $smarty->assign('vbusfon',$vbusfon);
  $smarty->assign('vbusgra',$vbusgra);
  $smarty->assign('veti',$veti);
  $smarty->assign('vmodo','update');
  if ($vtippro=='Nacional') {$checkpaisn='checked';  $checkpaise='';
                      $checkdespaisn='display:inline';  $checkdespaise='display:none'; }
  if ($vtippro=='Extranjero') {$checkpaise='checked';  $checkpaisn='';
                      $checkdespaisn='display:none';  $checkdespaise='display:inline';}
  if ($vtipbus=='N') {$checksigno1='checked'; $checksigno2=''; $checksigno3='';
                      $checkreffon='display:inline'; $checkrefgra='display:none';}
  if ($vtipbus=='G') {$checksigno2='checked'; $checksigno1=''; $checksigno3='';
                      $checkreffon='display:none'; $checkrefgra='display:inline';}
  if ($vtipbus=='M') {$checksigno3='checked'; $checksigno1=''; $checksigno2='';
                      $checkreffon='display:inline'; $checkrefgra='display:inline';}
  $vopc=3;
}

if ($vopc==5) {
  // Vector Bancos
  $contobji=0;
  $vcodsede[$contobji] = '';
  $vnomsede[$contobji] = '';
  $objquery = $sql->query("SELECT * FROM stzbancos WHERE tipo=1 ORDER BY nombre");
  $objfilas = $sql->nums('',$objquery);
  $objs = $sql->objects('',$objquery);
  for ($contobji=1;$contobji<=$objfilas;$contobji++) {
    $vcodban[$contobji] = $objs->rif;
    $vnomban[$contobji] = trim($objs->nombre);
    $objs = $sql->objects('',$objquery); }	  
  // Servicios y su Costo
  $cosxmar = calculo_costo("N","M");
}

//Pase de variables y Etiquetas al template
$smarty->assign('vfecact',$fechahoy);
$smarty->assign('fecharec',$fecharec);
$smarty->assign('vopc',$vopc);
$smarty->assign('vtipo_mp','M');
$smarty->assign('usuario',$usuario);
$smarty->assign('vreftra',$vreftra);
$smarty->assign('vrefsol',$vrefsol);
$smarty->assign('vnumsol',$vnumsol);
$smarty->assign('cosxmar',$cosxmar);
$smarty->assign('ventfin',$ventfin);
$smarty->assign('vnumdep',$vnumdep);
$smarty->assign('fechadep',$fechadep);
$smarty->assign('vmondep',$vmondep);
$smarty->assign('vcodban',$vcodban);
$smarty->assign('vnomban',$vnomban);
$smarty->assign('vnomban2',$vnomban2);
$smarty->assign('vcansol',$vcansol);
$smarty->assign('afavor',$afavor);
$smarty->assign('checka',$checka);
$smarty->assign('checkb',$checkb);
$smarty->assign('checkc',$checkc);
$smarty->assign('checkf',$checkf);
$smarty->assign('checkg',$checkg);
$smarty->assign('checkh',$checkh);
$smarty->assign('checki',$checki);
$smarty->assign('checko',$checko);
$smarty->assign('checkpaisn',$checkpaisn);
$smarty->assign('checkpaise',$checkpaise);
$smarty->assign('checkdespaisn',$checkdespaisn);
$smarty->assign('checkdespaise',$checkdespaise);
$smarty->assign('checksigno1',$checksigno1);
$smarty->assign('checksigno2',$checksigno2);
$smarty->assign('checksigno3',$checksigno3);
$smarty->assign('checkreffon',$checkreffon); 
$smarty->assign('checkrefgra',$checkrefgra);
$smarty->assign('arraycodpais',$arraycodpais);
$smarty->assign('arraynompais',$arraynompais);
$smarty->display('z_solmarweb.tpl');
$smarty->display('pie_pag.tpl');

function correo($sql_mail,$nombre,$vemail,$tramite,$vf_cantmarca,$costo_gra,$vf_solmar0,$vf_solmar1,$vf_solmar2,$vf_solmar3,$vf_solmar4,$vf_solmar5,$vf_solmar6,$docane) {
 $mail = new PHPMailer();
 $mail->IsSMTP();              	// enviar vía SMTP
 $mail->Host = $sql_mail; 
 $mail->SMTPAuth = true;     		// activar la identificacín SMTP
 $mail->Username = "msystem";  	// usuario SMTP
 $mail->Password = "M6ccs9Ve"; 	// clave SMTP

 $mail->From = "adminwebpi@sapi.gob.ve";
 $mail->FromName = "Administrador del Sistema WEBPI - SAPI";
 $mail->Subject = "Solicitud de Marcas En Línea, Tramite No. ".$tramite;
 
 $mail->AddAddress($vemail,$nombre);
 $mail->AddBCC('adminwebpi@sapi.gob.ve','Administrador Webpi');

 $body  = "<strong>Estimada(o): </strong>".$nombre." <br><br>";
 
 $body .= " Su solicitud de Marcas ha sido recibida y esta siendo procesada bajo el n&uacute;mero de tramite: <strong>".$tramite."</strong>. ";
 $body .= " <br>";   
 $body .= " <font color='red'>Le informamos que esta solicitud tendrá validez una vez se consignen los documentos anexos requeridos (indicados en la planilla de solicitud); y a partir de este momento ";
 $body .= " tiene un lapso de diez (10) días h&aacute;biles para realizar dicho proceso. En caso contrario esta solicitud será eliminada de nuestro sistema.</font>";
 $body .= " <br><br>";   
  
 $body .= "<H3><I>Marca(s) Solicitada(s):</I></H3><br>"; 
 $body .= "<table width='100%' border='1'>";
 $body .= " <tr>";

 $caracter='.';
 $posicion = strpos($costo_gra, $caracter);
 if ($posicion === false) { $costo_gra = $costo_gra.".00"; } 

 //$caracter='.';
 //$posicion = strpos($costo_gra, $caracter);
 //if ($posicion === false) { $costo_gra = $costo_gra.".00"; }  

 //Verificando conexion
 //$sql = new mod_db();
 //$sql->connection();
 //$tbname_2 = "stmbufon";
 //$tbname_3 = "stmbugra";

 //$subtotfon = 0;
 //$obj_filas = 0;
 //$obj_fone = $sql->query("SELECT * FROM $tbname_2 where nro_tramite='$tramite' ORDER BY nro_busfon");
 //$obj_filas = $sql->nums('',$obj_fone);
 if ($vf_cantmarca>0) {
   $body .= "   <tr>";
   $body .= "     <td width='10%' align='left'><b>Ref. Solicitud</b></td>";
   $body .= "     <td width='25%' align='left'><b>Nombre</b></td>";
   $body .= "     <td width='10%' align='left'><b>Tipo</b></td>";
   $body .= "     <td width='10%' align='left'><b>Clase Internacional</b></td>";
   $body .= "     <td width='10%' align='left'><b>Clase Nacional</b></td>";
   $body .= "     <td width='10%' align='left'><b>Modalidad</b></td>";
   $body .= "     <td width='15%' align='left'><b>Ref.B&uacute;squeda</b></td>";
   $body .= "     <td width='10%' align='left'><b>Costo Bs.</b></td>";
   $body .= "   </tr>";

   //$cont = 1;
   //$objs = $sql->objects('',$obj_fone);
   for ($cont=1;$cont<=$vf_cantmarca;$cont++) {
     $body .= "   <tr>";
     $body .= "     <td width='10%' align='left'>$vf_solmar0[$cont]</td>";
     $body .= "     <td width='20%' align='left'>$vf_solmar1[$cont]</td>";
     $body .= "     <td width='10%' align='left'>$vf_solmar2[$cont]</td>";
     $body .= "     <td width='10%' align='left'>$vf_solmar3[$cont]</td>";
     $body .= "     <td width='10%' align='left'>$vf_solmar4[$cont]</td>";
     $body .= "     <td width='10%' align='left'>$vf_solmar5[$cont]</td>";
     $body .= "     <td width='15%' align='left'>$vf_solmar6[$cont]</td>";
     $body .= "     <td width='15%' align='left'>$costo_gra</td>";
     $body .= "   </tr>";
     //$subtotfon = $subtotfon + $costo_fon;
     //$objs = $sql->objects('',$obj_fone); 
   }
   //$caracter='.';
   //$posicion = strpos($subtotfon, $caracter);
   //if ($posicion === false) { $subtotfon = $subtotfon.".00"; } 
   //$body .= "   <tr>";
   //$body .= "     <td colspan='8' align='left'><b><I>Sub Total Bs.: $subtotfon</I></b></td>";
   //$body .= "   </tr>";
 }

 //$subtotgra = 0;
 //$obj_filas = 0;
 //$ruta = "/var/www/consulta/apl/logotipos/";
 //$obj_graf = $sql->query("SELECT * FROM $tbname_3 where nro_tramite='$tramite' ORDER BY nro_busgra");
 //$obj_filas = $sql->nums('',$obj_graf);
 //if ($obj_filas>0) {
 //  $body .= "   <tr>";
 //  $body .= "     <td colspan='4' align='left'><b><H3><I>Búsquedas Gráficas</I></H3></b></td>";
 //  $body .= "   </tr>";
 //  $body .= "   <tr>";
 //  $body .= "     <td width='14%' align='left'><b>Referencia</b></td>";
   //$body .= "     <td width='60%' align='left'><b>Denominaci&oacute;n</b></td>";
 //  $body .= "     <td width='08%' align='left'><b>Clase</b></td>";
 //  $body .= "     <td width='12%' align='left'><b>Costo Bs.</b></td>";
 //  $body .= "   </tr>";

 //  $cont = 0;
 //  $objs = $sql->objects('',$obj_graf);
 //  for ($cont=0;$cont<$obj_filas;$cont++) {
 //    //$imagen = $ruta.trim($objs->archivo_logo);
 //    $body .= "   <tr>";
 //    $body .= "     <td width='14%' align='left'>$objs->nro_busgra</td>";
 //    //$body .= "     <td width='60%' align='left'><img src='$imagen' align='left' width='50' height='50' border='0'></td>";  
 //    $body .= "     <td width='08%' align='left'>$objs->clase</td>";
 //    $body .= "     <td width='08%' align='left'>$costo_gra</td>";
 //    $body .= "   </tr>";
 //    $subtotgra = $subtotgra + $costo_gra;
 //    $objs = $sql->objects('',$obj_graf); 
 //  }
 //  $caracter='.';
 //  $posicion = strpos($subtotgra, $caracter);
 //  if ($posicion === false) { $subtotgra = $subtotgra.".00"; } 
 //  $body .= "   <tr>";
 //  $body .= "     <td colspan='4' align='left'><b><I>Sub Total Bs.: $subtotgra</I></b></td>";
 //  $body .= "   </tr>";
 //}

 $body .= " </tr>";
 $body .= "</table>";
 $grantotal = $vf_cantmarca * $costo_gra;
 $caracter='.';
 $posicion = strpos($grantotal, $caracter);
 if ($posicion === false) { $grantotal = $grantotal.".00"; } 
 $body .= "<br><br>";
 $body .= "<b><I>Total Marca(s) Solicitada(s): $vf_cantmarca, por un costo de Bs.: $grantotal</I></b><br>"; 
 $body .= "<br><br>";

 $body .= "IMPORTANTE: Le recordamos que para ingresar de manera exitosa en el sistema WEBPI debe tener activada la opción de visualización de ventanas emergentes (popup) en su navegador web.<br><br>";
 $body .= "Si desea enviarnos alg&uacute;n comentario, sugerencia o recomendaci&oacute;n comuniquese directamente con nosotros a sugerencias@sapi.gob.ve o dirijase a nuestra oficina ubicada en el ";
 $body .= " Centro Sim&oacute;n Bol&iacute;var, Edificio Norte, Piso 4, El Silencio. Al lado de la Plaza Caracas. Apto. Postal 1844 - C&oacute;d. Postal 1010 - Caracas-Venezuela.";
 $body .= " Horario de Atenci&oacute;n al P&uacute;blico: 8:00am a 1:30pm. o por nuestra Central Telef&oacute;nica (0212) 481.64.78 / 484.29.07<br><br>"; 
 $body .= " Para mayor informaci&oacute;n consulte nuestra pagina <strong>www.sapi.gob.ve</strong>";
 $body .= "<br><br>";
 $body .= " Ministerio del poder Popular para el Comercio - MPPC.<br/>";
 $body .= " Servicio Aut&oacute;nomo de la Propiedad Intelectual - S.A.P.I.<br/>";
 $body .= " Portal: www.sapi.gob.ve<br>";
 $body .= "<font color='red'>NOTA: Esta es una cuenta de correo NO Monitoreada, por favor no responda ni reenv&iacute;e mensajes a esta cuenta.</font>";
 $mail->Body = $body;
 $mail->AltBody = "x PHPMailer\n";

 $exito = $mail->Send();
 $intentos=1;
 while ((!$exito) && ($intentos < 5)) {
   sleep(5);
   $exito = $mail->Send();
   $intentos=$intentos+1;
 }

 if (!$exito) { echo "Problemas al enviar el correo"; }
}



?>

