<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>

 <script type="text/javascript">

   function checkKey(evt) 
    {if (evt.keyCode == '17') 
    {alert("Comando No Permitido ...!!!"); 
     return false} 
   return true}

  </script>  
  
</head>
<header>

<body onkeydown="return checkKey(event)" onLoad="this.document.formarca.vsol1.focus()" bgcolor="#F9F9F9">
<div align="center"> 

<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

$usuario = TRIM($_SESSION['usuario_login']);
$subtitulo = "Consulta Interna de Marcas";
$fecha   = trim(fechahoy());

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo',$subtitulo); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

?>
</header>

<p align="center"><font size="4" face="Tahoma">B&uacute;squeda por N&uacute;mero de Solicitud</font>
<?php 
  //require("../../librerias/library.php"); 
  $vtipuser=1; 
  $lastupdate="12/08/2008 - 08:30am"; 
  echo "<form name='formarca' action='busca_marcas_n.php?vopc=1&vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>"; 
?>
<p align="center"><font size="3" face="Tahoma">N&uacute;mero de Solicitud:</font>
<!-- <?php
  $lastupdate="05/10/2006 - 08:30am";
  require("lib/library.php");
  $vtipuser=1;
  // 1=Usuario Interno:  - Activa las Busquedas Avanzadas
  //                     - Las consultas por nombre son en todos los estatus
  // 2=Usuario Externo:  - No activa las Busquedas Avanzadas
  //                     - Las consultas por nombre son solo de Marcas Registradas (Estatus=555) 

?>-->
         
<!--<input type="text" name="vsol1" size="2" maxlength="5" onKeypress="Only_num()" onkeyup="checkLength()" 
onchange="Rellena(document.formarcas.vsol1,4)" onkeydown="codigotecla(document.formarcas.vsol2)">-<input type="text" 
name="vsol2" size="6" maxlength="7" onKeypress="Only_num()" onkeyup="javascript:checkLength();" 
onchange="Rellena(document.formarcas.vsol2,6)" onkeydown="codigotecla(document.formarcas.buscar1)"></td>-->

<input type="text" name="vsol1" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onchange="Rellena(document.formarca.vsol1,4)" onkeyup="checkLength(event,this,4,document.formarca.vsol2)">-
<input type="text" name="vsol2" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onchange="Rellena(document.formarca.vsol2,6)" onkeyup="checkLength(event,this,6,document.formarca.buscar1)">
<input type="submit" class="boton_blue" value="Buscar" name="buscar1">
<input type="reset" class="boton_blue" value="Limpiar" name="limpiar"></font>
</form>
<br><br>
<?php echo "<form action='busca_marcas_n.php?vopc=2&vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>"; ?>
<p align="center"><font size="4" face="Tahoma">B&uacute;squeda por N&uacute;mero de Registro</font>
<p align="center"><font size="3" face="Tahoma">N&uacute;mero de Registro:  <input type="text" name="vreg" size="6" maxlength="7">  <input type="submit" class="boton_blue" value="Buscar" name="B2"> <input type="reset" class="boton_blue" value="Limpiar" name="limpiar"></font>
<br>
</form>
<br>
<?php echo "<form action='busca_marcas_t.php?vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>"; ?>
<p align="center"><font size="4" face="Tahoma">B&uacute;squeda por Nombre</font>
<p align="center"><font size="3" face="Tahoma">Solicitudes que <select size="1" name="vsel">
      <option value="1">comiencen por</option>
      <option value="2">el nombre exacto sea</option>
      <option value="3">contengan la porci&oacute;n de texto</option> 
      </select>  <input type="text" name="vtex" size="30">  <input type="submit" class="boton_blue" value="Buscar" name="B1"> <input type="reset" class="boton_blue" value="Limpiar" name="limpiar"></p>
</form>
</div>    

<div align="center">
<?php
if ($vtipuser==1)
  {//echo "<form action='busca_marcas_a.php?vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>"; 
   echo "<form action='busca_marcas_a.php?vusuario=$vtipuser' method='POST'>";
   echo "<font size='1' face='Tahoma'><input type='submit' class='boton_blue' value='Busqueda Avanzada' name='B2'></font><br>";
   echo "</form>";
  }
?>
  <td>
    <a href="../salir.php">
    <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" />
    <font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></a>
  </td>
  <br /><br /><br />
</div>

 <br>

<?php
 $smarty->display('pie_pag.tpl');
?>

</body>
</html>

