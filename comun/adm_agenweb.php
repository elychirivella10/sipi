<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css"></link>
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
    if (!emailpat.test(who)) { alert('¡ Cuenta Email o Correo no Válido ...!!!');   
       campo.value=''; campo.focus(); return false }
  return
  }

  function isdirvalida(who,formulario,campo) {
    if (campo.value.length<10) { alert('¡ Direccion no Válida ...!!! Coloque al menos 10 caracteres');   
       campo.value=''; campo.focus(); return false }
  return
  }

  function isnomvalida(who,formulario,campo) {
    if (campo.value.length<3) { alert('¡ Nombre no Válido ...!!! Coloque al menos 3 caracteres');   
       campo.value=''; campo.focus(); return false }
  return
  }

  function centrarwindowstit() { 
    resizeTo(screen.width/1.5, screen.height/1.9); 
    iz=(screen.width-document.body.clientWidth) / 2; 
    de=(screen.height-document.body.clientHeight) / 2; 
    moveTo(iz,de); 
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
  function number_cor(e){
  function f(){
  this.value=this.value.reverse().replace(/[^0-9\.\-\@\_\A-Z\a-z]/g,'').replace(/\@(?=[A-Za-z0-9_.-]*[@][A-Za-z0-9_.-]*)/g,'').reverse();
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
  </script>
</head>
<body onload="centrarwindowstit();"> 

<?php
include ("../z_includes.php");
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable  onload="centrarwindows()"
$usuario = $_SESSION['usuario_login'];
  
$vsol=$_GET['vsol'];
$tper=$_GET['tper'];
$lced=$_GET['lced'];
$vced=$_GET['vced'];
$vpas=$_GET['vpas'];
$vtex=$_GET['vtex'];
$vtmp=$_GET['vtmp'];

$vtex1c = substr($vtex,0,1);
if ($vtex1c=='-') {
  $vage = substr($vtex,1); }
else { $vage = 0; }

//if ($vtex1c=='-') {
//     $resultado=pg_exec("SELECT * FROM stzagenr WHERE agente = '$vtexag' OFFSET $inicio LIMIT $cuanto");
//     $cantidad =pg_exec("SELECT * FROM stzagenr WHERE agente = '$vtexag'");
//   } else {
//     $resultado=pg_exec("SELECT * FROM stzagenr WHERE nombre like '%$vtex%' ORDER BY nombre OFFSET $inicio LIMIT $cuanto");
//     $cantidad =pg_exec("SELECT * FROM stzagenr WHERE nombre like '%$vtex%'"); }

if ((($tper==2 or $tper==3) and ($vced=='000000000' or empty($vced) or $vced==' ' or $vced==0) and ($vpas=='000000000' or empty($vpas) or $vpas==' ' or $vpas==0)) or 
    (($tper==1 or empty($tper)) and ($vage==0))) {

   echo "&nbsp;";
   echo "&nbsp;";
   echo "&nbsp;";
   echo "&nbsp;";
   echo "&nbsp;";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='50%' border='0' cellpadding='0' cellspacing='1' >";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<p align='center'><b>Introduzca primero la identificaci&oacute;n del Agente que desea buscar</b>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
   echo "</td></tr>";
   echo "</table>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   exit;
}

// Validacion de solo 1 tramitante o varios agentes
$sql = new mod_db();
$sql->connection();  
$error=0;
if ($tper=='1' or $tper=='' or $tper=='3') {
   $res_tab = pg_exec("select * from stztmpage where solicitud='$vsol' and tipo_per='2'");
} else {
   $vcedula=$lced.$vced;
   $res_tab = pg_exec("select * from stztmpage where solicitud='$vsol' and (tipo_per<>'2' or (agente=0 and identificacion<>'$vcedula'))"); }
$rega = pg_fetch_array($res_tab); 
$filas_found=pg_numrows($res_tab); 
if ($filas_found>0) {
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
   echo "<p align='center'><b>Solo se permite ingresar un Tramitante &oacute; uno o varios Agentes de la Propiedad Industrial y/o Apoderados</b>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='botones'></font></p>";
   echo "</td></tr>";
   echo "</table>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   exit;
}

if ($vage>0 and ($tper=='1' or empty($tper))) {
   // Buscar el B.D.P.I. // 
   //$sql = new mod_db();
   //$sql->connection(); echo " $tper --$vage ";
   $res_tab = pg_exec("select * from stzagenr where agente=$vage");
   $rega = pg_fetch_array($res_tab); 
   $filas_found=pg_numrows($res_tab); 
   if ($filas_found>0) {
      $vdom=trim($rega[domicilio]);
      $vnom=trim($rega[nombre]);
      $vtel=trim($rega[telefono1]);
      $vcel=trim($rega[telefono2]);
      $vfax=trim($rega[fax]);
      $vcor=trim($rega[email]);
      //$sql->disconnect();
      //$sql= new mod_db();
      //$sql->connection(); 
      $res_tab = pg_exec("select * from stztmpage where agente=$vage and tipo_per='1'");
      $rega = pg_fetch_array($res_tab); 
      $filas_found=pg_numrows($res_tab); 
      if ($filas_found>0) {
         $vced=trim($rega[identificacion]);
         $vdom=trim($rega[domicilio]);
         $vnom=trim($rega[nombre]);
         $vtel=trim($rega[telefono1]);
         $vcel=trim($rega[telefono2]);
         $vfax=trim($rega[fax]);
         $vcor=trim($rega[email]);
         $vcor2=trim($rega[email2]);
         $vpod=trim($rega[poder]); 
         $vpod1=substr($vpod,0,4);
         $vpod2=substr($vpod,5,4); 
         $vage=trim($rega[agente]); }   
   } else {
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
      echo "<p align='center'><b>El C&oacute;digo del Agente introducido No Existe en nuestros registros!!! Verifique...</b>";
      echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
      echo "</td></tr>";
      echo "</table>";
      echo "</fieldset>";
      echo "</td></tr>";
      echo "</table>";
      exit;
   }
}

if ($tper=='1' or empty($tper) or $tper=='2' or $tper=='3') { 
   //$sql = new mod_db();
   //$sql->connection();   
   if ($tper==1 or empty($tper)) {
                 $tide='Codigo del Agente:';
                 $tnom='Nombre Completo:';
                 $ttpe='AGENTE DE LA P.I.';
                 $vide=$vage;
                 $lced=substr($vced,0,1);
                 $vced=substr($vced,1,9);
   }
   if ($tper==2 or $tper==3){$tnom='Nombre Completo:';
                 $ttpe='TRAMITANTE';
                 if ($tper==3) {$ttpe='APODERADO';}
                 if ($lced=='P') { 
                    $tide='Pasaporte:';
                    $vide=$lced.$vpas;
                 } else {
                    $tide='Cedula:';
                    $vide=$lced.$vced; }
                 //$sql = new mod_db();
                 //$sql->connection();
                 if ($tper==2) { $res_tab = pg_exec("select * from stztramr where cedula='$vide'"); }  
                 if ($tper==3) { $res_tab = pg_exec("select * from stzagenr where cedula='$vide'"); }
                 $rega = pg_fetch_array($res_tab); 
                 $filas_found=pg_numrows($res_tab); 
                 if ($filas_found>0) {
                    if ($tper==2) {$vage=$rega[idtramitante];}
                    if ($tper==3) {$vage=$rega[agente]; $vnom=trim($rega[nombre]);
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
                       echo "<p align='center'><b>La Cedula ingresada corresponde al Codigo de Agente: $vage ($vnom). Debe ingresarlo como un Agente de La P.I.!  Verifique...</b>";
                       echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
                       echo "</td></tr>";
                       echo "</table>";
                       echo "</fieldset>";
                       echo "</td></tr>";
                       echo "</table>";
                       exit;
                    }
                    $vnom=trim($rega[nombre]);
                    $vtel=trim($rega[telefono1]);
                    $vcel=trim($rega[telefono2]);
                    $vfax=trim($rega[fax]);
                    $vcor=trim($rega[email]);
                 } else {
                    $vtit=0;
                    $vage=0;
                    $vnom='';
                    $vdom='';
                    $vtel='';
                    $vcel='';
                    $vfax='';
                    $vcor='';
                    $vcor2='';
                    $vpod1='';
                    $vpod2='';
                 }
                 $res_tab = pg_exec("select * from stztmpage where identificacion='$vide'");
                 $rega = pg_fetch_array($res_tab); 
                 $filas_found=pg_numrows($res_tab); 
                 if ($filas_found>0) {
                    $vnom=trim($rega[nombre]);
                    $vdom=trim($rega[domicilio]); 
                    $vtel=trim($rega[telefono1]);
                    $vcel=trim($rega[telefono2]);
                    $vfax=trim($rega[fax]);
                    $vcor=trim($rega[email]);
                    $vcor2=trim($rega[email2]);
                    $vpod=trim($rega[poder]); 
                    $vpod1=substr($vpod,0,4);
                    $vpod2=substr($vpod,5,4);
                    //$vage=trim($rega[agente]); 
                 } else {
                    $res_tab = pg_exec("select * from stztmptit where identificacion='$vide'");
                    $rega = pg_fetch_array($res_tab); 
                    $filas_found=pg_numrows($res_tab); 
                    if ($filas_found>0) {
                       $vnom=trim($rega[nombre]);
                       $vdom=trim($rega[domicilio]); 
                       $vtel=trim($rega[telefono1]);
                       $vcel=trim($rega[telefono2]);
                       $vfax=trim($rega[fax]);
                       $vcor=trim($rega[email]);
                       $vcor2=trim($rega[email2]); 
                       //$vage=0;
                       //$vpod1='';
                       //$vpod2=''; 
                    }
                 } 
   }
   echo "<form action='z_gbgestor.php' name='formtitular' method='post'>";
   echo "<input type='hidden' name='vtra' value='$vtra'>";
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vtmp' value='$vtmp'>";
   echo "<input type='hidden' name='vage' value='$vage'>";
   echo "<input type='hidden' name='vtip' value='$tper'>";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong>DATOS DEL $ttpe</strong></legend>";  
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo " <tr><td>&nbsp;</td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>$tide</td>";
   echo " <td><input type='text' size='9' name='vide' value='$vide' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   if ($tper==1 or empty($tper)) {
      echo " <tr>";
      echo " <div align='right'>";
      echo " <td class='der8-color'>Cedula/Pasaporte:</td>";
      echo " <td>";
      echo " <select size='1' name='lcedtit' id='lcedtit' onchange='visible_pas(this.value);'>";
      if ($lced=='V') { echo "    <option VALUE='V' selected>V</option>"; } 
                 else { echo "    <option VALUE='V'>V</option>"; } 
      if ($lced=='E') { echo "    <option VALUE='E' selected>E</option>"; } 
                 else { echo "    <option VALUE='E'>E</option>"; } 
      if ($lced=='P') { echo "    <option VALUE='P' selected>P</option>"; } 
                 else { echo "    <option VALUE='P'>P</option>"; } 
      echo " </select>";
      echo " <input type='text' name='vcedtit' value='$vced' size='8' maxlength='9' STYLE='display:inline' onkeyup='number_sindec(this);' onchange='for(var x=this.value.length;x<9;x++)
this.value=0+this.value;'>";
      echo "  <input type='text' name='vpastit' size='14' maxlength='14' STYLE='display:none' ><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";    
   }
   echo " <tr>";
   echo " <td class='der8-color'>$tnom</td>";
   echo " <td><input type='text' size='50' name='vnom' value='$vnom' onkeyup='this.value=this.value.toUpperCase();' onchange='isnomvalida(document.formtitular.vnom.value,this.form,this);'><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY nombre");
   $filas_res_pais=pg_numrows($res_pais);
   $reg = pg_fetch_array($res_pais);
   echo " <tr>";
   echo " <td class='der8-color'>Nacionalidad:</td>";
   echo " <td>";
   echo " <select size='1' name='vnac'>";
          for($cont=0;$cont<$filas_res_pais;$cont++) 
          { 
          if ($reg[pais]=='VE') {
            echo "<option value=$reg[pais] selected>$reg[nombre]</option>";
          } else { 
            echo "<option value=$reg[pais]>$reg[nombre]</option>";
          } 
          $reg = pg_fetch_array($res_pais);
          }
   echo " </select><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   echo "</tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Direcci&oacute;n:</td>";
   echo " <td><input type='text' size='50' name='vdom' maxlength='150' value='$vdom' onchange='isdirvalida(document.formtitular.vdom.value,this.form,this);'><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   if ($tper<>2) {
     echo " <tr>";
     echo " <td class='der8-color'>N&uacute;mero de Poder:</td>";
     echo " <td><input type='text' size='3' name='vpod1' maxlength='4' value='$vpod1' onkeyup='number_sindec(this);' onchange='for(var x=this.value.length;x<4;x++)
this.value=0+this.value;'>-<input type='text' size='3' name='vpod2' maxlength='4' value='$vpod2' onkeyup='number_sindec(this);' onchange='for(var x=this.value.length;x<4;x++)
this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000-0000 (año-n&uacute;mero)</font></td></tr>";
   }
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
   echo " <td align='left'><font face='Arial' color='#800000' size='3'>*</font><font face='Arial' color='#000000' size='2'>Campos Obligatorios</font></td></tr>";
   echo "</table>";
   echo "<p align='center'><font color='#0000FF'><input type='submit' name='accion1' value='Incluir' class='boton_blue'>&nbsp;&nbsp;<input type='submit'  name='accion2' value='Eliminar' class='boton_blue'>&nbsp;&nbsp;<input type='button' value='Salir' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   echo "</form>";
}

?>
</body>
</html>
