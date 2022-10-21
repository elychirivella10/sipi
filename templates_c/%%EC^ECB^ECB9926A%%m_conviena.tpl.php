<?php /* Smarty version 2.6.8, created on 2020-12-01 08:37:39
         compiled from m_conviena.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
</head>


<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
<div align="center">

<form name="formarcas1" action="m_conviena1.php?vopc=1" method="post">
  <table>
    <tr><td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
	<td class="der-color">
           <input type="text" name="v1" size="11" maxlength="11" value='<?php echo $this->_tpl_vars['vcontrol']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
>
        </td>
    </tr>
  </table>
  &nbsp;

  <table width="85%" cellpadding="0" cellspacing="1" border="1">
    <tr><td class="izq2-color" colspan="2"><?php echo $this->_tpl_vars['lcviena']; ?>
</td></tr>
    <tr><td>    
    <iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src="m_verccv.php?psol=<?php echo $this->_tpl_vars['vcontrol']; ?>
"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" <?php echo $this->_tpl_vars['modo2']; ?>
 size="11" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="gestionvienap(document.formarcas1.v1,document.formarcas1.vviena,document.formarcas1.vvienai)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="gestionvienap(document.formarcas1.v1,document.formarcas1.vviena,document.formarcas1.vvienae)">
    </td></tr>
  </table>

  <table class="menubar1" cellpadding="0" cellspacing="0" border="1">
  <tr>
   <td class="menudottedline" width="95%">
     <div class="pathway">
       <!--<img src="../imagenes/systeminfo.png"  align="left" border="0" /><br/>-->
     <p>
     <font size="-2">M&oacute;dulo:&nbsp;&nbsp;m_conviena.php<p></b>Descripci&oacute;n: Rescata todas aquellas solicitudes de Marcas con los C&oacute;digos de Viena especificados.</font>
     </div>	
   </td>
   
   <td class="menudottedline" width="73%" ></td>
      <td class="menudottedline" align="right">
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	  <tr valign="left" align="left">
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" >
              <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/search_f2.png" value="Buscar" border="0">Buscar</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../marcas/m_conviena.php">
	      <img src="../imagenes/cancel_f2.png" alt="&nbsp;Cancelar" name="Cancelar" title="Cancelar" align="left" border="0" /><br/>&nbsp;Cancelar</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../index1.php">
	      <img src="../imagenes/salir_f2.png"  alt="&nbsp;Logout" name="Salir" title="Salir" align="left" border="0" /><br/>&nbsp;Salir</a>
	    </td>
	    <td>&nbsp;</td>
	 </tr>
	</table>
      </td>
   </td>
  </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

</form>
</div>  
</body>
</html>

