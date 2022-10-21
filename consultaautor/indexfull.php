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
$subtitulo = "Consulta Interna de Obras Derecho de Autor";
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
  $vtipuser=1; 
  $lastupdate="12/08/2008 - 08:30am"; 
  echo "<form name='formarca' action='busca_autor_n.php?vopc=1&vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>"; 
?>
<p align="center"><font size="3" face="Tahoma">N&uacute;mero de Solicitud:</font>
         
<input type="text" name="vsol1" size="4" maxlength="7" onKeyPress="return acceptChar(event,2, this)" onchange="Rellena(document.formarca.vsol1,6)" onkeyup="checkLength(event,this,6,document.formarca.buscar1)">-
<input type="submit" class="boton_blue" value="Buscar" name="buscar1">
<input type="reset" class="boton_blue" value="Limpiar" name="limpiar"></font>
</form>
<br><br>
<?php echo "<form action='busca_autor_n.php?vopc=2&vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>"; ?>
<p align="center"><font size="4" face="Tahoma">B&uacute;squeda por N&uacute;mero de Registro</font>
<p align="center"><font size="3" face="Tahoma">N&uacute;mero de Registro:  <input type="text" name="vreg" size="6" maxlength="7">  <input type="submit" class="boton_blue" value="Buscar" name="B2"> <input type="reset" class="boton_blue" value="Limpiar" name="limpiar"></font>
<br>
</form>
<br>

<div align="center">
  <td>
    <a href="../salir.php">
    <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" />
    <font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></a>
  </td>
  <br /><br /><br />
</div>

<br>

<br><br><br><br><br><br>
 
<?php
 $smarty->display('pie_pag.tpl');
?>

</body>
</html>

