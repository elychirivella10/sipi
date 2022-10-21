<?php /* Smarty version 2.6.8, created on 2021-02-08 11:33:36
         compiled from z_filediario.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">
<form name="forsolpre" action="z_filediario.php?vopc=2" method="POST" onsubmit='return confirmar();'> 

<br><br>
&nbsp;
 <table width="500">
   <tr>
      <td class="izq-color" >Fecha:</td>
      <td class="der-color">
        <input type="text" name="fechahoy" value='<?php echo $this->_tpl_vars['fechahoy']; ?>
' size='9' onChange="valFecha(document.forsolpre.fechahoy)"> 
        <a href="javascript:showCal('Calendar73');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a><font class="textoayuda">Formato: dd/mm/aaaa</font>; 
   </tr>
   <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_enviar_azul.png"></td> 
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
   </tr>
 </table>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</form>
</div>

</body>
</html>