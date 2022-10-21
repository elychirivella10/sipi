<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css"></link>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
  <title>Sistema de Informaci&oacute;n de Propiedad Intelectual</title>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <script language="javascript" src="../include/js/wforms.js"></script>
  <script language="javascript">
 
  function centrarwindowstit() { 
    //toolbar=no,directories=no,menubar=no,status=no;
    resizeTo(screen.width/1.4, screen.height/2.0); 
    iz=(screen.width-document.body.clientWidth) / 2; 
    de=(screen.height-document.body.clientHeight) / 2; 
    moveTo(iz,de); 
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

function letras_reg(e){
function f(){
this.value=this.value.reverse().replace(/[^mpslndcMPSLNDC]/g,'').replace(/\.(?=\w*[.]\w*)/g,'').reverse();
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
</head>
<body  onload="centrarwindowstit(); this.document.all.vlmar.focus();">   

<?php
// onload="centrarwindowstit();
include ("../z_includes.php");
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

$usuario = $_SESSION['usuario_login'];
  
$vsol=$_GET['vsol'];
$vtpm=$_GET['vtpm'];
$vcla=$_GET['vcla'];
$fechahoy = hoy();

echo " $vsol, $vtpm, $vcla ";

if (empty($vcla)) {
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
   echo "<p align='center'><b>Introduzca primero la Clase Internacional en la que desea buscar la(s) Clase(s) Nacional(es) asociada(s) ... !!!</b>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
   echo "</td></tr>";
   echo "</table>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   exit;
}

$sql=new mod_db();
$sql->connection();
   echo "<form action='z_gbbusqueda.php' name='formtitular' method='post'>";
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vtpm' value='$vtpm'>";
   echo "<input type='hidden' name='vcla' value='$vcla'>";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong>DATOS DE LA BUSQUEDA</strong></legend>";  
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo " <tr><td>&nbsp;</td></tr>";

   $resultado=pg_exec("SELECT distinct on (clase_nacion) clase_nacion FROM stmnizarel WHERE clase_inter=$vcla");
   $filas_found=pg_numrows($resultado);
   if ($filas_found>1) {
      echo "<tr><td colspan='2'>&nbsp;&nbsp;</td></tr>";
      echo "<tr><td colspan='2'><B>SELECCIONE LA CLASE NACIONAL ASOCIADA:</B></td></tr>";
      echo "<tr><td class='der8-color'>Clase Nacional:</td>";  
      echo "<td colspan=2>";  
      for($cont=1;$cont<=$filas_found;$cont++) { 
         $regp = pg_fetch_array($resultado); 
         $vclanac=$regp['clase_nacion'];
         if (($vclasenac==0 and $cont==1) or ($vclanac==$vclasenac)) {
           echo "<input type='radio' name='clasesnac' value='$vclanac' checked>$vclanac &nbsp;";
         } else {
           echo "<input type='radio' name='clasesnac' value='$vclanac'>$vclanac &nbsp;";
         }
      }
      echo "<font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
      $hayinputs=1;
   }
   if ($filas_found==1 or $vcla==46) { 
      $regp = pg_fetch_array($resultado); 
      $vclanac=$regp['clase_nacion'];
      if ($vcla==46) {$vclanac=50;}
      echo "<td class='der8-color'>Clase Nacional:</td>";
      echo "<td><input type='text' size='2' name='clasesnac' value='$vclanac' readonly></td></tr>";
   }
   if ($vcla==47) { 
      echo "<input type='hidden' name='clasesnac' value=0>";
   }
   if ($hayinputs==1) {
      echo " <tr><td align='left'><font face='Arial' color='#800000' size='3'>*</font><font face='Arial' color='#000000' size='2'>Campo(s) Obligatorio(s)</font></td></tr>";
   }
   echo "</table>";
   echo "<p align='center'><font color='#0000FF'><input type='submit' name='accion1' value='Aceptar' class='boton_blue'>&nbsp;&nbsp;<input type='button' value='Salir' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   echo "</form>";
//onchange='valFecha(this,document.fortitular.accion1)'
//&nbsp;&nbsp;<input type='submit' name='accion2' value='Rechazar' class='boton_blue'>
$sql->disconnect();
?>
</body>
</html>
