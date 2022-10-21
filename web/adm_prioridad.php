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
    resizeTo(screen.width/1.5, screen.height/2.5); 
    iz=(screen.width-document.body.clientWidth) / 2; 
    de=(screen.height-document.body.clientHeight) / 2; 
    moveTo(iz,de); 
  }
  </script>
</head>
<body onload="centrarwindowstit();">   

<?php
include ("../setting.inc.php");
ob_start();
include ("../z_includes.php");
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

$usuario = $_SESSION['usuario_login'];
  
$vtra=$_GET['vtra'];
$vsol=$_GET['vsol'];
$vpri=$_GET['vpri'];
$vpai=$_GET['vpai'];
$fechadep=$_GET['fechadep'];
$vtmp=$_GET['vtmp'];

if ($vpri=='') {
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
   echo "<p align='center'><b>Introduzca primero la identificaci&oacute;n de la Prioridad que desea buscar</b>";
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

$res_tab = pg_exec("select * from stztmprio where prioridad='$vpri'");
$rega = pg_fetch_array($res_tab); 
$filas_found=pg_numrows($res_tab); 
if ($filas_found>0) {
   $vpri=trim($rega[prioridad]);
   $vpai=trim($rega[pais_priori]); 
   $fechadep=trim($rega[fecha_priori]);
} else {
   $vpai=''; 
   $fechadep='';
}

   echo "<form action='z_gbprioridad.php' name='formarcas2' method='post'>";
   echo "<input type='hidden' name='vtra' value='$vtra'>";
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vtmp' value='$vtmp'>";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong>DATOS DE LA PRIORIDAD EXTRANJERA</strong></legend>";  
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo " <tr><td>&nbsp;</td></tr>";
   echo " <tr>";
   echo " <td class='der8-colorf'>Prioridad:</td>";
   echo " <td><input type='text' size='60' name='vpri' value='$vpri' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   echo " <tr>";
   $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY nombre");
   $filas_res_pais=pg_numrows($res_pais);
   $reg = pg_fetch_array($res_pais);
   echo " <tr>";
   echo " <td class='der8-colorf'>Pais:</td>";
   echo " <td>";
   echo " <select size='1' name='vpai'>";
          for($cont=0;$cont<$filas_res_pais;$cont++) 
          { 
          if ($reg[pais]==$vpai) {
            echo "<option value=$reg[pais] selected>$reg[nombre]</option>";
          } else { 
            echo "<option value=$reg[pais]>$reg[nombre]</option>";
          } 
          $reg = pg_fetch_array($res_pais);
          }
   echo " </select><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   echo "</tr>";
   echo " <tr>";
   echo " <td class='der8-colorf'>Fecha de la Prioridad:</td>";
   echo " <td><input type='text' size='11' maxlength='10' name='fechadep' value='$fechadep' onchange='valFecha(this,this)'><font face='Arial' color='#800000' size='3' valign='up'>*</font>";
   echo " <a href=\"javascript:showCal('Calendar60');\"><img src='../imagenes/calendar2.gif' title='Haga Clic para Seleccionar la Fecha' align='middle' width='26' height='24' border='0'></a><font face='Arial' color='#000000' size='1'>Formato: dd/mm/aaaa</font></td>";
   echo "</tr>";
   echo " <tr>";
   echo " <td align='left'><font face='Arial' color='#800000' size='3'>*</font><font face='Arial' color='#000000' size='2'>Campos Obligatorios</font></td></tr>";
   echo "</table>";
   echo "<p align='center'><font color='#0000FF'><input type='submit' name='accion1' value='Incluir' class='boton_cream'>&nbsp;&nbsp;<input type='submit'  name='accion2' value='Eliminar' class='boton_cream'>&nbsp;&nbsp;<input type='button' value='Salir' name='aceptar' onclick='window.close();' class='boton_cream'></font></p>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   echo "</form>";
//onchange='valFecha(this,document.fortitular.accion1)'
$sql1->disconnect1();
?>
</body>
</html>
