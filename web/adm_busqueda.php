<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css"></link>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
  <title>Sistema En Linea de Propiedad Intelectual Caracas - Venezuela</title>
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
<body onload="centrarwindowstit(); this.document.all.vlmar.focus();">   

<?php
include ("../setting.inc.php");
ob_start();
include ("../z_includes.php");
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

$usuario = $_SESSION['usuario_login'];
  
$vtra=$_GET['vtra'];
$vsol=$_GET['vsol'];
$vtmp=$_GET['vtmp'];
$tbus=$_GET['tbus'];
if ($tbus=='N') {$tbus=1;}
$vfon=$_GET['vfon'];
$vgra=$_GET['vgra'];
$fechahoy = hoy();

if ((($tbus==1 or $tbus==3) and $vfon=='') or (($tbus==2 or $tbus==3) and $vgra=='')){
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
   echo "<p align='center'><b>Introduzca primero la referencia de la B&uacute;squeda que desea asociar</b>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
   echo "</td></tr>";
   echo "</table>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   exit;
}

$sql=new mod_db();
$sql->connection();

$sql->disconnect();
$sql1 = new mod_db();
$sql1->connection1();  

if ($tbus==1 or $tbus==3) {
   $res_tab = pg_exec("select denominacion,clase,b.usuario,a.f_vencimiento from stmbufon a, stztramite b where a.nro_tramite=b.nro_tramite and nro_busfon=$vfon and estatus_tra='06'");
   $rega = pg_fetch_array($res_tab); 
   $filas_found=pg_numrows($res_tab); 
   if ($filas_found>0) {
      $vnom=trim($rega[denominacion]);
      $vcla=trim($rega[clase]); 
      $vclaf=trim($rega[clase]); 
      $vusertra=$rega[usuario];
      $vfventra=$rega[f_vencimiento];
      $esmayor=compara_fechas($vfventra,$fechahoy);
      //if ($usuario<>$vusertra or $esmayor!=1) {
      //  echo "&nbsp;";
      //  echo "&nbsp;";
      //  echo "&nbsp;";
      //  echo "&nbsp;";
      //  echo "&nbsp;";
      //  echo "&nbsp;";
      //  echo "<div align='center'>";
      //  echo "<table width='50%' border='0' cellpadding='0' cellspacing='1'>";
      //  echo "<tr><td>";
      //  echo "<fieldset>";
      //  echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
      //  echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
      //  echo "<tr><td>";
      //  if ($usuario<>$vusertra) {
      //    echo "<p align='center'><b>La B&uacute;squeda Fonetica pertenece a otro Usuario!    (El usuario que realice la Solicitud de Marca debe ser el mismo que solicit&oacute; la B&uacute;squeda)</b>";
      // } else {
      //    if ($esmayor!=1) {
      //      echo "<p align='center'><b>La B&uacute;squeda Fonetica Expir&oacute; el dia: $vfventra</b>";
      //    }
      //  }
      //  echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
      //  echo "</td></tr>";
      //  echo "</table>";
      //  echo "</fieldset>";
      //  echo "</td></tr>";
      //  echo "</table>";
      //  exit;
      //}
      $res_tabref = pg_exec("select nro_tramite from stmsolref where ref_fon=$vfon");
      $filas_found=pg_numrows($res_tabref); 
      if ($filas_found>0) {
        echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "<div align='center'>";
        echo "<table width='50%' border='0' cellpadding='0' cellspacing='1'>"; echo "<tr><td>"; echo "<fieldset>";
        echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
        echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>"; echo "<tr><td>";
        echo "<p align='center'><b>La B&uacute;squeda Fonetica ya fu&eacute; utilizada en otra Solicitud de Marcas!</b>";
        echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
        echo "</td></tr>"; echo "</table>"; echo "</fieldset>"; echo "</td></tr>"; echo "</table>";
        exit;
      }
      $res_tabref = pg_exec("select nro_tramite from stztmpbus where ref_fonetica=$vfon and nro_tramite='$vtra'");
      $filas_found=pg_numrows($res_tabref); 
      if ($filas_found>0) {
        echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "<div align='center'>";
        echo "<table width='50%' border='0' cellpadding='0' cellspacing='1'>"; echo "<tr><td>"; echo "<fieldset>";
        echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
        echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>"; echo "<tr><td>";
        echo "<p align='center'><b>La B&uacute;squeda Fonetica est&aacute; siendo utilizada en este tramite para otra Solicitud de Marcas!</b>";
        echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
        echo "</td></tr>"; echo "</table>"; echo "</fieldset>"; echo "</td></tr>"; echo "</table>";
        exit;
      }
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
   echo "<p align='center'><b>La Referencia de la B&uacute;squeda Fonetica No Existe en nuestro Sistema &oacute; no ha sido Procesada</b>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
   echo "</td></tr>";
   echo "</table>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   exit;
   }
}
if ($tbus==2 or $tbus==3) {
   $res_tab = pg_exec("select archivo_logo,clase,b.usuario,b.f_vencimiento from stmbugra a, stztramite b where a.nro_tramite=b.nro_tramite and nro_busgra=$vgra and estatus_tra='06'");
   $rega = pg_fetch_array($res_tab); 
   $filas_found=pg_numrows($res_tab); 
   if ($filas_found>0) {
      $vrut=trim($rega[archivo_logo]);
      $vcla=trim($rega[clase]); 
      $vclag=trim($rega[clase]); 
      $vusertra=$rega[usuario];
      $vfventra=$rega[f_vencimiento];
      if ($tbus==3 and $vclaf<>$vclag) {
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
         echo "<p align='center'><b>La Clase en ambas b&uacute;squedas NO es la misma!!! Verifique...</b>";
         echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
         echo "</td></tr>";
         echo "</table>";
         echo "</fieldset>";
         echo "</td></tr>";
         echo "</table>";
         exit;
      }
      $esmayor=compara_fechas($vfventra,$fechahoy);
      if ($usuario<>$vusertra or $esmayor!=1) {
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
        if ($usuario<>$vusertra) {
          echo "<p align='center'><b>La B&uacute;squeda Gr&aacute;fica pertenece a otro Usuario!    (El usuario que realice la Solicitud de Marca debe ser el mismo que solicit&oacute; la B&uacute;squeda)</b>";
        } else {
          if ($esmayor!=1) {
            echo "<p align='center'><b>La B&uacute;squeda Gr&aacute;fica tiene m&aacute;s de Treinta (30) dias de Elaborada; por tanto ya Expir&oacute;!</b>";
          }
        }
        echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
        echo "</td></tr>";
        echo "</table>";
        echo "</fieldset>";
        echo "</td></tr>";
        echo "</table>";
        exit;
      }
      $res_tabref2 = pg_exec("select nro_tramite from stmsolref where ref_gra=$vgra");
      $filas_found=pg_numrows($res_tabref2); 
      if ($filas_found>0) {
        echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "<div align='center'>";
        echo "<table width='50%' border='0' cellpadding='0' cellspacing='1'>"; echo "<tr><td>"; echo "<fieldset>";
        echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
        echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>"; echo "<tr><td>";
        echo "<p align='center'><b>La B&uacute;squeda Gr&aacute;fica ya fu&eacute; utilizada en otra Solicitud de Marcas!</b>";
        echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
        echo "</td></tr>"; echo "</table>"; echo "</fieldset>"; echo "</td></tr>"; echo "</table>";
        exit;
      }
      $res_tabref2 = pg_exec("select nro_tramite from stztmpbus where ref_grafica=$vgra and nro_tramite='$vtra'");
      $filas_found=pg_numrows($res_tabref2); 
      if ($filas_found>0) {
        echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "&nbsp;"; echo "<div align='center'>";
        echo "<table width='50%' border='0' cellpadding='0' cellspacing='1'>"; echo "<tr><td>"; echo "<fieldset>";
        echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
        echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>"; echo "<tr><td>";
        echo "<p align='center'><b>La B&uacute;squeda Gr&aacute;fica est&aacute; siendo utilizada en este tramite para otra Solicitud de Marcas!</b>";
        echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
        echo "</td></tr>"; echo "</table>"; echo "</fieldset>"; echo "</td></tr>"; echo "</table>";
        exit;
      }
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
   if ($tbus==3 and $vclaf<>$vclag) {
     echo "<p align='center'><b>La Clase en ambas búsquedas NO es la misma!!! Verifique...</b>";
   } else {
     echo "<p align='center'><b>La Referencia de la B&uacute;squeda Gr&aacute;fica No Existe en nuestro Sistema &oacute; no ha sido Procesada</b>";
   } 
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
   echo "</td></tr>";
   echo "</table>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   exit;
   }
}
   // se busca a ver si ya existe en el temporal
   $res_tab = pg_exec("select lc_amarca,lc_solicitud,lc_registro,clase_nac from stztmpbus where nro_tramite=$vtra and solicitud=$vsol");
   $rega = pg_fetch_array($res_tab); 
   $filas_found=pg_numrows($res_tab); 
   if ($filas_found>0) {
      $vlmar=trim($rega[lc_amarca]);
      $vlsol=trim($rega[lc_solicitud]);
      $vlreg=trim($rega[lc_registro]);  
      $vlsol1=substr($vlsol,0,4);
      $vlsol2=substr($vlsol,5,6);
      $vlreg1=substr($vlreg,0,1);
      $vlreg2=substr($vlreg,1,6);
      $vclasenac=$rega[clase_nac];
   }
   echo "<form action='z_gbbusqueda.php' name='formtitular' method='post'>";
   echo "<input type='hidden' name='vtra' value='$vtra'>";
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vtmp' value='$vtmp'>";
   echo "<input type='hidden' name='vrut' value='$vrut'>";
   echo "<input type='hidden' name='tbus' value='$tbus'>";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong>DATOS DE LA BUSQUEDA</strong></legend>";  
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo " <tr><td>&nbsp;</td></tr>";
   if ($tbus=='2' or $tbus=='3') {
      echo "<tr><td class='der8-color'>B&uacute;squeda Gr&aacute;fica #:</td>";
      echo "<td width='50%'><input type='text' size='15' name='vgra' value='$vgra' readonly></td>"; 
      $vrut1=substr($vrut,17);
      echo "<td width='1%' rowspan='4'><img src='$vrut1' width='150' height='120'></td></tr>";}
   if ($tbus=='1' or $tbus=='3') {
      echo "<tr><td class='der8-color'>B&uacute;squeda Fonetica #:</td>";
      echo "<td><input type='text' size='15' name='vfon' value='$vfon' readonly></td></tr>"; }
   if ($tbus=='1' or $tbus=='3') {
      echo " <tr><td class='der8-color'>Nombre de la Marca:</td>";
      echo " <td><input type='text' size='40' name='vnom' value='$vnom' readonly></td></tr>"; }
   echo "<tr>";
   echo "<td class='der8-color'>Clase Internacional:</td>";
   echo "<td><input type='text' size='2' name='vcla' value='$vcla' readonly></td></tr>";
   $vtipomar=tipo_de_marca($vcla);
   $hayinputs=0;
   if ($vtipomar=='L') {
      echo "<tr><td colspan='2'>&nbsp;&nbsp;</td></tr>"; 
      echo "<tr><td colspan='2'><B>INGRESE LOS DATOS ASOCIADOS CON EL LEMA:</B></td></tr>";
      echo "<tr><td class='der8-color'>Lema aplicado a la Marca:</td>";
      echo " <td class='izq8-color'><input type='text' name='vlmar' value='$vlmar' size='50' maxlength='120' onkeyup='this.value=this.value.toUpperCase();'><font face='Arial' color='#800000' size='3' valign='up'>*</font>"; 
      echo "<tr><td class='der8-color'>Nro. Solicitud:</td>";   
      echo " <td class='izq8-color'><input type='text' name='vlsol1' value='$vlsol1' size='3' maxlength='4' onkeyup='number_sindec(this);' onchange='for(var x=this.value.length;x<4;x++)
this.value=0+this.value;'>-<input type='text' name='vlsol2' value='$vlsol2' size='5' maxlength='6' onkeyup='number_sindec(this);' onchange='for(var x=this.value.length;x<6;x++)
this.value=0+this.value;'>&oacute; Nro. Registro: <input type='text' name='vlreg1' value='$vlreg1' size='1' maxlength='1' onkeyup='letras_reg(this);' onchange='this.value=this.value.toUpperCase();'>-<input type='text' name='vlreg2' value='$vlreg2' size='5' maxlength='6' onkeyup='number_sindec(this);' onchange='for(var x=this.value.length;x<6;x++)
this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font>";
      echo "</td><tr>";
      $hayinputs=1; 
   }
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
   echo "<p align='center'><font color='#0000FF'><input type='submit' name='accion1' value='Aceptar' class='boton_cream'>&nbsp;&nbsp;<input type='button' value='Salir' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   echo "</form>";
//onchange='valFecha(this,document.fortitular.accion1)'
//&nbsp;&nbsp;<input type='submit' name='accion2' value='Rechazar' class='boton_cream'>
$sql->disconnect();
?>
</body>
</html>
