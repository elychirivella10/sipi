<html>
<head>
  <link REL="STYLESHEET" TYPE="text/css" HREF="../main.css"></link>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
  <title>Sistema Webpi de Propiedad Intelectual Caracas - Venezuela</title>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script> 
  <script language="javascript" src="../include/js/wforms.js"></script>
  <script language="javascript">

  function isTelvalido(who,formulario,campo) {
    var telefpat=/^\d{4}-\d{7}$/;
    if (!telefpat.test(who)) { alert('Numero de Telefono no Valido ...!!!');   
       campo.value=''; campo.focus(); return false }
  return
  }

  function isEmail2(who,formulario,campo) {
    var emailpat=/^[A-Za-z0-9][\w-.]+@[A-Za-z0-9]([\w-.]+[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i;
    if (!emailpat.test(who)) { alert('¡ Cuenta Email o Correo no Valido ...!!!');   
       campo.value=''; campo.focus(); return false }
  return
  }

  function isdirvalida(who,formulario,campo) {
    if (campo.value.length<10) { alert('¡ Direccion no Valida ...!!! Coloque al menos 10 caracteres');   
       campo.value=''; campo.focus(); return false }
  return
  }

  function centrarwindowstit() { 
    //toolbar=no,directories=no,menubar=no,status=no;
    resizeTo(screen.width/1.5, screen.height/1.9);
    iz=(screen.width-document.body.clientWidth) / 2; 
    de=(screen.height-document.body.clientHeight) / 2; 
    moveTo(iz,de); 
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
  e.onblur=f
  }
  function number_cor(e){
  function f(){
  this.value=this.value.reverse().replace(/[^0-9\.\-\@\_\A-Z\a-z]/g,'').replace(/\@(?=[A-Za-z0-9_.-]*[@][A-Za-z0-9_.-]*)/g,'').reverse();
  }
  e.onkeyup=f
  e.onkeydown=f
  e.onkeypress=f
  e.onmousedown=f
  e.onmouseup=f
  e.onblur=f
  }
  </script>
</head>
<body onload="centrarwindowstit();">   

<?php
include ("../z_includes.php");
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

$usuario = $_SESSION['usuario_login'];
  
$sql = new mod_db();
$vsol=$_GET['vsol'];
$tper=$_GET['tper'];
$lced=$_GET['lced'];
$vced=$_GET['vced'];
$vpas=$_GET['vpas'];
$lrif=$_GET['lrif'];
$vrif=$_GET['vrif'];
$vnom=$_GET["vnom"];
$vtex=$_GET["vnom"];
$vtmp=$_GET["vtmp"]; 
$b='.';
$vrad=$_POST['radiotit'];

//str_replace("'","`",$vnom); 
echo " opcion= $vrad / $tper ";

if ((($tper==1 or empty($tper)) and ($vced=='000000000' or empty($vced) or $vced==' ' or $vced==0) and ($vpas=='000000000' or empty($vpas) or $vpas==' ' or $vpas==0)) or 
    (($tper==2 or $tper==3) and ($vrif=='000000000' or empty($vrif) or $vrif==' ' or $vrif==0)) or
    ($tper==4 and ($vnom=='' or substr($vnom,0,1)==' '))) {
   echo "&nbsp;";
   echo "&nbsp;";
   echo "&nbsp;";
   echo "&nbsp;";
   echo "&nbsp;";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='50%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<p align='center'><b>Introduzca primero la identificaci&oacute;n del Solicitante que desea buscar</b>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
   echo "</td></tr>";
   echo "</table>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   exit;
}

//Verificando conexion
$sql->connection(); 

if ($tper<>4 or ($tper==4 and $vrad<>'')) {
   if ($tper==1 or empty($tper)) {
                 $tnom='Nombre Completo:';
                 $ttpe='Persona Natural';
                 if ($lced=='P') { 
                    $tide='Pasaporte:';
                    $vide=$lced.$vpas;
                 } else {
                    $tide='C&eacute;dula:';
                    $vide=$lced.$vced; }
   }
   if ($tper>1) {$tide='Rif:';
                 $tnom='Raz&oacute;n Social:';
                 if ($tper==2) { 
                    $ttpe='Cooperativa'; }
                 if ($tper==3) { 
                    $ttpe='Persona Juridica Nacional'; }
                 $vide=$lrif.$vrif;
                 if ($tper==4) { 
                    $tide='C&oacute;digo del Titular:';
                    $ttpe='Persona Juridica Extranjera'; 
                    $vide=$vrad; }
   }
   echo " admtitu= $vrad - $vide ";
   if ($vrad=='') { echo "en stzsolic por identifica "; $res_tab = pg_exec("select * from stzsolic where identificacion='$vide'");}
   else           { echo "en stzsolic por titular "; $res_tab = pg_exec("select * from stzsolic where titular='$vrad'");}
   $rega = pg_fetch_array($res_tab); 
   $filas_found=pg_numrows($res_tab); 
   if ($filas_found>0) {
      echo " mayor 0 ";
      $vtit=trim($rega[titular]);
      $vnom=trim($rega[nombre]);
      $vdom='';
      $vnac='';
      $vtel=trim($rega[telefono1]);
      $vcel=trim($rega[telefono2]);
      $vfax=trim($rega[fax]);
      $vcor=trim($rega[email]);
   } else {
      echo " es 0 ";
      //$obj_query = $sql->query("update stzsystem set nro_titular=nextval('stzsystem_nro_titular_seq')");
      //$obj_query = $sql->query("select last_value from stzsystem_nro_titular_seq");
      //$objs = $sql->objects('',$obj_query);
      $vtit = 0;
      $vnom='';
      $vnac='';
      $vdom='';
      $vtel='';
      $vcel='';
      $vfax='';
      $vcor='';
      $vcor2='';
   }
   echo " titular=$vtit  "; 
   if ($vrad=='') { echo " por identifica "; $res_tab = pg_exec("select * from stztmptit where identificacion='$vide' order by solicitud desc");}
   else { echo " por titular "; $res_tab = pg_exec("select * from stztmptit where titular='$vide' order by solicitud desc");}
   $rega = pg_fetch_array($res_tab); 
   $filas_found=pg_numrows($res_tab); 
   if ($filas_found>0) {
      $vtit=trim($rega[titular]);
      $vnom=trim($rega[nombre]);
      $vnac=trim($rega[nacionalidad]);
      $vdom=trim($rega[domicilio]); 
      $vtel=trim($rega[telefono1]);
      $vcel=trim($rega[telefono2]);
      $vfax=trim($rega[fax]);
      $vcor=trim($rega[email]);
      $vcor2=trim($rega[email2]);
   }
   echo "<form name='formtitular' action='z_gbtituweb.php' method='post'>";
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vtmp' value='$vtmp'>";
   echo "<input type='hidden' name='vtit' value='$vtit'>";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong>DATOS DEL SOLICITANTE</strong></legend>";  
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo " <tr><td>&nbsp;</td></tr>";
   if ($tper==4) {
      echo "<input type='hidden' name='vide' value='$vide'>";
   } else {
      echo " <tr>";
      echo " <td class='der8-color'>$tide</td>";
      echo " <td><input type='text' size='9' name='vide' value='$vide' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   }
   echo " <tr>";
   echo " <td class='der8-color'>Indole:</td>";
   echo " <td><input type='text' size='30' name='vtip' value='$ttpe' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>$tnom</td>";
   echo " <td><input type='text' size='50' name='vnom' value='$vnom' onkeyup='this.value=this.value.toUpperCase();'><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY nombre");
   $filas_res_pais=pg_numrows($res_pais);
   $reg = pg_fetch_array($res_pais);
   echo " <tr>";
   echo " <td class='der8-color'>Pa&iacute;s:</td>";
   echo " <td>";
   if ($tper==2 or $tper==3) {
     echo "<input type='hidden' name='vnac' value='VE'>";
     echo " <input type='text' size='30' name='vnacdes' value='VENEZUELA' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   } else {
     echo " <select size='1' name='vnac'>";
          if ($vnac=='' and $tper<>4) {$vnac='VE';}
          for($cont=0;$cont<$filas_res_pais;$cont++) 
          {
          if ($tper==4 and $reg[pais]=='VE') {
            // No lo muestra 
          } else {   
            if ($reg[pais]==$vnac) {
             echo "<option value=$reg[pais] selected>$reg[nombre]</option>";   
            } else { 
             echo "<option value=$reg[pais]>$reg[nombre]</option>";   
            }
          } 
          $reg = pg_fetch_array($res_pais);
          }
     echo " </select><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   }
   echo "</tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Direcci&oacute;n:</td>";
   echo " <td><input type='text' size='50' name='vdom' maxlength='150' value='$vdom' onchange='isdirvalida(document.formtitular.vdom.value,this.form,this);'><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Correo Electr&oacute;nico 1:</td>";
   echo " <td><input type='text' size='50' name='vcor' maxlength='80' value='$vcor' onkeyup='number_cor(this);' onchange='isEmail2(document.formtitular.vcor.value,this.form,this);'></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Correo Electr&oacute;nico 2:</td>";
   echo " <td><input type='text' size='50' name='vcor2' maxlength='80' value='$vcor2' onkeyup='number_cor(this);' onchange='isEmail2(document.formtitular.vcor2.value,this.form,this);'></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Tel&eacute;fono:</td>";
   echo " <td><input type='text' size='11' maxlength='12' name='vtel' value='$vtel' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.vtel.value,this.form,this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Celular:</td>";
   echo " <td><input type='text' size='11' maxlength='12' name='vcel' value='$vcel' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.vcel.value,this.form,this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Fax:</td>";
   echo " <td><input type='text' size='11' maxlength='12' name='vfax' value='$vfax' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.vfax.value,this.form,this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td colspan=2 align='left'><font face='Arial' color='#800000' size='3'>*</font><font face='Arial' color='#000000' size='2'>Campos Obligatorios (Si se excluye alguno, el solicitante no ser&aacute; incluido en la solicitud)</font></td></tr>";
   echo "</table>";
   echo "<p align='center'><font color='#0000FF'><input type='submit' name='accion1' value='Incluir' class='boton_cream'>&nbsp;&nbsp;<input type='submit'  name='accion2' value='Eliminar' class='boton_cream'>&nbsp;&nbsp;<input type='button' value='Salir' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   echo "</form>";
}

if ($tper==4 and $vrad=='') {
   //Paginacion
   if(strlen($_POST['adelante']) > 0)
     $adelante = "1";
   if(strlen($_POST['atras']) > 0)
     $atras = "1";
   $inicio = $_POST['inicio'];
   $cuanto = $_POST['cuanto'];
   $total = $_POST['total'];
   
   if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
     $inicio = 0;
  
   if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
     $cuanto = 10;

   if(!empty($adelante))
     $inicio += $cuanto;

   if(!empty($atras))
     $inicio = max($inicio - $cuanto, 0);

   $hiddenvars['vtra']=$vtra;
   $hiddenvars['vsol']=$vsol;
   $hiddenvars['tper']=$tper;
   $hiddenvars['vtmp']=$vtmp;
   $hiddenvars['vtex']=$vtex;
   $hiddenvars['inicio']=$inicio;
   $hiddenvars['cuanto']=$$cuanto;
   $hiddenvars['total']=$total;

   $resultado=pg_exec("SELECT * FROM stzsolic WHERE nombre like '%$vtex%' ORDER BY nombre OFFSET $inicio LIMIT $cuanto");
   $cantidad =pg_exec("SELECT * FROM stzsolic WHERE nombre like '%$vtex%'");
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);

   if ($filas_resultado==0){


   $tnom='Raz&oacute;n Social:';
   $tide='C&oacute;digo del Titular:';
   $ttpe='Persona Jur&iacute;dica Extranjera'; 
   $vide=$vrad; 
   $obj_query = $sql->query("update stzsystem set nro_titular=nextval('stzsystem_nro_titular_seq')");
   $obj_query = $sql->query("select last_value from stzsystem_nro_titular_seq");
   $objs = $sql->objects('',$obj_query);
   $vtit = $objs->last_value;
   $vide=$vtit;
   $vnom=$vtex;
   $vnac='';
   $vdom='';
   $vtel='';
   $vcel='';
   $vfax='';
   $vcor='';
   $vcor2='';
   //if ($vrad=='') {$res_tab = pg_exec("select * from stztmptit where identificacion='$vide' order by nro_tramite desc");}
   if ($vrad=='') {$res_tab = pg_exec("select * from stztmptit where nombre='$vtex' order by solicitud desc");}
   else {$res_tab = pg_exec("select * from stztmptit where titular='$vide' order by solicitud desc");}
   $rega = pg_fetch_array($res_tab); 
   $filas_found=pg_numrows($res_tab); 
   if ($filas_found>0) {
      $vtit=trim($rega[titular]);
      $vnom=trim($rega[nombre]);
      $vnac=trim($rega[nacionalidad]);
      $vdom=trim($rega[domicilio]); 
      $vtel=trim($rega[telefono1]);
      $vcel=trim($rega[telefono2]);
      $vfax=trim($rega[fax]);
      $vcor=trim($rega[email]);
      $vcor2=trim($rega[email2]);
   }
   echo "<form name='formtitular' action='z_gbtituweb.php' method='post'>";
   echo "<input type='hidden' name='vtra' value='$vtra'>";
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vtmp' value='$vtmp'>";
   echo "<input type='hidden' name='vtit' value='$vtit'>";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong>DATOS DEL SOLICITANTE</strong></legend>";  
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo " <tr><td>&nbsp;</td></tr>";
   if ($tper==4) {
      echo "<input type='hidden' name='vide' value='$vide'>";
   } else { 
      echo " <tr>";
      echo " <td class='der8-color'>$tide</td>";
      echo " <td><input type='text' size='9' name='vide' value='$vide' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   }
   echo " <tr>";
   echo " <td class='der8-color'>Indole:</td>";
   echo " <td><input type='text' size='30' name='vtip' value='$ttpe' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>$tnom</td>";
   echo " <td><input type='text' size='50' name='vnom' value='$vtex' onkeyup='this.value=this.value.toUpperCase();'><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY nombre");
   $filas_res_pais=pg_numrows($res_pais);
   $reg = pg_fetch_array($res_pais);
   echo " <tr>";
   echo " <td class='der8-color'>Pa&iacute;s:</td>";
   echo " <td>";
   if ($tper==2 or $tper==3) {
     echo "<input type='hidden' name='vnac' value='VE'>";
     echo " <input type='text' size='30' name='vnacdes' value='VENEZUELA' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   } else {
     echo " <select size='1' name='vnac'>";
          if ($vnac=='' and $tper<>4) {$vnac='VE';}
          for($cont=0;$cont<$filas_res_pais;$cont++) 
          { 
          if ($tper==4 and $reg[pais]=='VE') {
            // No lo muestra 
          } else { 
            if ($reg[pais]==$vnac) {
              echo "<option value=$reg[pais] selected>$reg[nombre]</option>";
            } else { 
              echo "<option value=$reg[pais]>$reg[nombre]</option>";
            }
          }   
          $reg = pg_fetch_array($res_pais);
          }
     echo " </select><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   }
   echo "</tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Direcci&oacute;n:</td>";
   echo " <td><input type='text' size='50' name='vdom' maxlength='150' value='$vdom'><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Correo Electr&oacute;nico 1:</td>";
   echo " <td><input type='text' size='50' name='vcor' maxlength='80' value='$vcor' onkeyup='number_cor(this);'></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Correo Electr&oacute;nico 2:</td>";
   echo " <td><input type='text' size='50' name='vcor2' maxlength='80' value='$vcor2' onkeyup='number_cor(this);'></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Telefono:</td>";
   echo " <td><input type='text' size='11' maxlength='12' name='vtel' value='$vtel' onkeyup='number_tel(this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Celular:</td>";
   echo " <td><input type='text' size='11' maxlength='12' name='vcel' value='$vcel' onkeyup='number_tel(this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Fax:</td>";
   echo " <td><input type='text' size='11' maxlength='12' name='vfax' value='$vfax' onkeyup='number_tel(this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td align='left'><font face='Arial' color='#800000' size='3'>*</font><font face='Arial' color='#000000' size='2'>Campos Obligatorios</font></td></tr>";
   echo "</table>";
   echo "<p align='center'><font color='#0000FF'><input type='submit' name='accion1' value='Incluir' class='boton_cream'>&nbsp;&nbsp;<input type='submit'  name='accion2' value='Eliminar' class='boton_cream'>&nbsp;&nbsp;<input type='button' value='Salir' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   echo "</form>";




    exit;
   }
//   echo "<p align='center'><b>Tra:$vtra Sol:$vsol Per:$tper MP:$vtmp Tex:$vtex Rad:$vrad</b></p>";
   echo "<p align='center'><b>SELECCIONE EL TITULAR QUE BUSCA</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#FFFFCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font><small>Sel</small></td>";   
   echo " <td bgcolor='#FFFFCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Codigo</small></font></td>";
   echo " <td bgcolor='#FFFFCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Nombre/Raz&oacute;n Social</small></font></td>";
   echo " <td bgcolor='#FFFFCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Email</small></font></td>";
   echo " <td bgcolor='#FFFFCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Tel&eacute;fono</small></font></td>";
   echo " <td bgcolor='#FFFFCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Fax</small></font></td>";
   echo "</tr>";
   echo "<form name='formti' action='adm_tituweb.php?vtra=$vtra&vsol=$vsol&tper=$tper&vnom=$vnom&vtmp=$vtmp' method='POST'>";
   for($cont=0;$cont<$filas_resultado;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><input type='radio' name='radiotit' value='$reg[titular]'></font></td>";
     echo " <td bordercolorlight='#FFFFFF' align='center'><small><font color='#000000'>$reg[titular]</font></small></td>";
     echo " <td bordercolorlight='#FFFFFF' align='left'><small><font color='#000000'>$reg[nombre]</font></small></td>";
     echo " <td bordercolorlight='#FFFFFF' align='left'><small><font color='#000000'>$reg[email]<font color='#F9f7ED'>$b</font></font></small></td>";
     echo " <td bordercolorlight='#FFFFFF' align='left'><small><font color='#000000'>$reg[telefono1]<font color='#F9f7ED'>$b</font></font></small></td>";
     echo " <td bordercolorlight='#FFFFFF' align='left'><small><font color='#000000'>$reg[fax]<font color='#F9f7ED'>$b</font></font></small></td>";
     echo "</tr>";
//     $titacum[$cont]=$reg[titular];
//     $nomacum[$cont]=$reg[nombre];
     $reg = pg_fetch_array($resultado);
   }
   echo "</table>"; 
//      for($cont=0;$cont<$filas_resultado;$cont++) {
//          echo "<input type='hidden' name='vtit$cont' value='$titacum[$cont]'>";
//          echo "<input type='hidden' name='vnom$cont' value='$nomacum[$cont]'>";
//      } 
//      echo "<input type='hidden' name='vsol' value='$vsol'>";
//      echo "<input type='hidden' name='vfil' value='$filas_resultado'>";
//      echo "<input type='hidden' name='vmod' value='$vmod'>";
//      echo "<input type='hidden' name='vder' value='$vder'>";
//      echo "<p align='center'><font color='#0000FF'>";

   echo "<p align='center'><font color='#000000'><input type='submit' name='accion1' value='Seleccionar' class='boton_cream'>&nbsp;&nbsp;<input type='button' value='Salir' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";

   echo "</form>";
   echo "<form method='POST' action='adm_tituweb.php?vtra=$vtra&vsol=$vsol&tper=$tper&vnom=$vnom&vtmp=$vtmp'>"; 
?>
   <p align='center'><b><font color='#000000' size='2' face='Tahoma'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> ocurrencias encontradas </font></b></p>
<div align="center">
   <?php
   ?>
   <input type="hidden" name="adelante">
   <input type="hidden" name="atras">
   <?
   foreach($hiddenvars as $var => $val)
   {
   ?>
   <input type="hidden" name="<?= $var ?>" value="<?= $val ?>" />
   <?
   }
   if($inicio > 0)
   {
   ?>
   <input class='boton_cream' type="submit" name="atras" value="Previos <?= min($inicio, $cuanto) ?>" />
   <?
   }
   else
   {
   //espacio  &nbsp;
   }
   if($total - $inicio > $cuanto)
   {

   ?>
   <input class='boton_cream' type='submit' name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
</div>
   <?
   }
   else
   {
   //espacio    &nbsp;
   }
   echo "</form>";
  }

?>
</body>
</html>
