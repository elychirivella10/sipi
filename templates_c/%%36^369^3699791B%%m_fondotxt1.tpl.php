<?php /* Smarty version 2.6.8, created on 2020-11-19 16:32:43
         compiled from m_fondotxt1.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <title><?php echo $this->_tpl_vars['title']; ?>
</title>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">
<form name="foravzcri" enctype="multipart/form-data" action="m_fondotxt1.php?vopc=2" method="POST" onsubmit='return pregunta();'>

<table>
<tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>

        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.foravzcri.vsol2)" onchange="Rellena(document.foravzcri.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2,6)">
        <?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.foravzcri.vsol2h)" onchange="Rellena(document.foravzcri.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2h,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>

        <input type="text" name="fecsold" value='<?php echo $this->_tpl_vars['fecsold']; ?>
' size='9' onChange="valFecha(document.foravzcri.fecsold)" onBlur="valagente(document.foravzcri.fecsold,document.foravzcri.fecsolh)">
        <a href="javascript:showCal('Calendar73');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	<?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="fecsolh" value='<?php echo $this->_tpl_vars['fecsolh']; ?>
' size='9' onChange="valFecha(document.foravzcri.fecsolh)">
        <a href="javascript:showCal('Calendar74');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
<table>
<tr>

&nbsp;
 <table align="center" width="100">
   <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_generar_azul.png"></td> 
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
   </tr>
 </table>

 </form>
</div>
</body>
</html>