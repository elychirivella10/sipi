<script language="javascript">
 function cerrarwindows2() {
   window.opener.frames[0].location.reload();
   window.close();
 }
</script>

<?php
  include ("../z_includes.php");
  // ************************************************************************************* 
  // Programa: adm_imagen.php 
  // Realizado por el Analista de Sistema Romulo Mendoza 
  // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
  // Año: 2013 BD - Relacional 
  // *************************************************************************************
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autónomo de la Propiedad Intelectual</title>
</head>
<body onload="centrarwindows()" bgcolor="#FFFFFF">   
<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$fecha     = fechahoy();
$subtitulo = "Ingreso de Solicitud / Asociaci&oacute;n de Imagen ";
$sql = new mod_db();
$vsol=$_GET['vsol'];
$vcod=$_GET['vcod'];
$tbname_1 = "stmpsolpla";

if ($vcod=='') { 
  $smarty->assign('titulo',$titulo);
  $smarty->assign('subtitulo',$subtitulo);
  $smarty->assign('login',$usuario);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  echo "<br><br><br>";
  echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
  echo "   <tr>";
  echo "     <td colspan='2' height='60'>";
  echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
  echo "     </td>";
  echo "     <td colspan='2' height='60'>";
  echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>Favor debe escribir el N&uacute;mero Control de la Planilla Blanca de B&uacute;squeda Gr&aacute;fica ...!!!<br><br><font color='#FFFF00'></b></font>";
  echo "       </div>";
  echo "     </td>";
  echo "   </tr>";
  echo "</table>";
  echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
  echo "<div align='center'>";
  echo "<tr><td>&nbsp;</td></tr>";
  echo "<tr><td>&nbsp;</td></tr>";
  $smarty->display('pie_pag.tpl');   
  echo "</div>";
  exit();
}

$nameimage = "../imagenes/sin_imagen8.png";
if ($vsol=='-') { 
  $smarty->assign('titulo',$titulo);
  $smarty->assign('subtitulo',$subtitulo);
  $smarty->assign('login',$usuario);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  echo "<br><br><br>";
  echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
  echo "   <tr>";
  echo "     <td colspan='2' height='60'>";
  echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
  echo "     </td>";
  echo "     <td colspan='2' height='60'>";
  echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>Por favor debe escribir el numero de Solicitud...!!!<br><br><font color='#FFFF00'></b></font>";
  echo "       </div>";
  echo "     </td>";
  echo "   </tr>";
  echo "</table>";
  echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
  echo "<div align='center'>";
  echo "<tr><td>&nbsp;</td></tr>";
  echo "<tr><td>&nbsp;</td></tr>";
  $smarty->display('pie_pag.tpl');   
  echo "</div>";
  exit();
}
else {
  $del_datos = $sql->del("$tbname_1","solicitud='$vsol'");
  $obj_query = $sql->query("SELECT * FROM stmbusplan WHERE cod_planilla='$vcod' AND tipo_busq='G'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas==0) {
    $smarty->assign('titulo',$titulo);
    $smarty->assign('subtitulo',$subtitulo);
    $smarty->assign('login',$usuario);
    $smarty->assign('fechahoy',$fecha);
    $smarty->display('encabezado1.tpl');
    echo "<br><br><br>";
    echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
    echo "   <tr>";
    echo "     <td colspan='2' height='60'>";
    echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
    echo "     </td>";
    echo "     <td colspan='2' height='60'>";
    echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>Numero de Planilla Blanca NO existe en la Base de Datos ...!!!<br><br><font color='#FFFF00'></b></font>";
    echo "       </div>";
    echo "     </td>";
    echo "   </tr>";
    echo "</table>";
    echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
    echo "<div align='center'>";
    echo "<tr><td>&nbsp;</td></tr>";
    echo "<tr><td>&nbsp;</td></tr>";
    $smarty->display('pie_pag.tpl');   
    echo "</div>";
    exit();
  }  	
  $objs = $sql->objects('',$obj_query);
  $nroped = $objs->nro_pedido;
  $obj_query = $sql->query("SELECT * FROM stmcntrl WHERE pedido='$nroped'");
  $objs = $sql->objects('',$obj_query);
  $nfactura = $objs->recibo;
  $fechafac = $objs->fecharec;
  $interesado = $objs->solicitant;
  $nameimage = "../graficos/planblog/".$vcod.".jpg";
}

echo "<form action='m_gbimagen.php' name='formplanilla' method='post'>";
echo "  <input type='hidden' name='vsol' value='$vsol'>";

echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_marca'>";
echo " <td>";
echo "   <i><b><font>$subtitulo</font></b></i>";
echo " </td>";
echo "</table>"; 

echo "<table border='1' cellpadding='1' cellspacing='1'>";
echo "<tr>";
echo "  <td class='izq-color'>"; 
echo "  &nbsp;&nbsp;Numero Planilla Blanca:&nbsp;<td>";
echo "  <td class='der-color'><input type='text' size='6' name='vcod' value='{$vcod}' readonly><td>";
echo "</tr>";
echo "<tr>";
echo "  <td class='izq-color'>";
echo "  &nbsp;&nbsp;Asociado al N&uacute;mero de Pedido B&uacute;squeda:&nbsp;<td>";
echo "  <td class='der-color'><input type='text' size='6' name='vpedido' value='{$nroped}' readonly><td>";
echo "  <td>";
echo "  <td class='der-color' rowspan='5' valign='top'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='350' height='350'></a></td>";
echo "</tr>";
echo "<tr>";
echo "  <td class='izq-color'>";
echo "  &nbsp;&nbsp;N&uacute;mero de Pedido asociado a la Factura No.:&nbsp;<td>";
echo "  <td class='der-color'><input type='text' size='10' name='nfactura' value='{$nfactura}' readonly><td>";
echo "  <td>";
echo "</tr>";
echo "<tr>";
echo "  <td class='izq-color'>";
echo "  &nbsp;&nbsp;Fecha de la Factura:&nbsp;<td>";
echo "  <td class='der-color'><input type='text' size='10' name='fechafac' value='{$fechafac}' readonly><td>";
echo "  <td>";
echo "</tr>";
echo "<tr>";
echo "  <td class='izq-color'>";
echo "  &nbsp;&nbsp;B&uacute;squeda Gr&aacute;fica Solicitado por:&nbsp;<td>";
echo "  <td class='der-color'><input type='text' size='40' name='vinteresado' value='{$interesado}' readonly><td>"; 
echo "  <td>";
echo "</tr>";
echo "</tr>";
echo "</table>";

echo "<p align='center'>";
//echo "<input type='submit' name='accion' value='Aceptar' class='boton_azul'>&nbsp;&nbsp;";
//echo "<input type='button' name='accion' value='Salir' onclick='window.close();' class='boton_rojo'>";
echo "<input type='image' name='accion' value='Aceptar' src='../imagenes/boton_aceptar_rojo.png'>&nbsp;&nbsp;";
echo "<input type='image' name='accion1' onclick='window.close()' src='../imagenes/boton_salir_rojo.png'>";
echo "</p>";
echo "<form>";
?>
</body>
</html>
