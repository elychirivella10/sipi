<?php /* Smarty version 2.6.8, created on 2020-10-28 22:07:39
         compiled from z_rptroles.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_rptroles.tpl', 20, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forcronol" action="z_rptroles.php?vopc=2" method="POST">
  <div align="center">
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  
  <table >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='vrol'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayrole'],'selected' => $this->_tpl_vars['vrol'],'output' => $this->_tpl_vars['arraynombre']), $this);?>

        </select>
      </td>
      <td class="cnt">
         <input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" value="Buscar">  Buscar  
      </td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
    </tr>
   
  </table><!--</font>--></center>
  <p></p>

  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='80' maxlength="80" onKeyPress="return acceptChar(event,0, this)" onkeyup="checkLength(event,this,60,document.forusing1.email)">
        Cod:
        <input type='text' name='codigo' value='<?php echo $this->_tpl_vars['codigo']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='15' maxlength="15">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
       <textarea onkeyUp="max(this,1000)" onkeyPress="max(this,1000)" onChange="Vacio(document.forrole.descripcion)" cols='88' rows='4' name='descripcion' value='<?php echo $this->_tpl_vars['descripcion']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
><?php echo $this->_tpl_vars['descripcion']; ?>
</textarea>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='creacion' value='<?php echo $this->_tpl_vars['creacion']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='25' maxlength="25">
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color" >
        <input type='text' name='estado' value='<?php echo $this->_tpl_vars['estado']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='10' maxlength="7">
      </td>
    </tr>

  </tr>
  </table>
  <p>EVENTOS ASIGNADOS</p>

  <iframe name='frmevmar' id='frmevmar' style='width:75%;height:150px' src="../comun/z_coneve.php?vrol=<?php echo $this->_tpl_vars['vrol']; ?>
&vtipo=M"></iframe>
<p>&nbsp;</p>

  <iframe name='frmevpat' id='frmevpat' style='width:75%;height:150px' src="../comun/z_coneve.php?vrol=<?php echo $this->_tpl_vars['vrol']; ?>
&vtipo=P"></iframe>
<p>&nbsp;</p>

  <iframe name='frmevaut' id='frmevaut' style='width:75%;height:150px' src="../comun/z_coneve.php?vrol=<?php echo $this->_tpl_vars['vrol']; ?>
&vtipo=A"></iframe>
<p>&nbsp;</p>

  <p>USUARIOS ASIGNADOS</p>

  <iframe name='frmrlusr' id='frmrlusr' style='width:75%;height:150px' src="../comun/z_coneve.php?vrol=<?php echo $this->_tpl_vars['vrol']; ?>
&vtipo=R"></iframe>
  <!-- <iframe name='frmrlusr' id='frmrlusr' style='width:75%;height:150px' src="../comun/z_conusr.php?vrol=<?php echo $this->_tpl_vars['vrol']; ?>
"></iframe> -->

<table class="menubar2" cellpadding="0" cellspacing="0" border="1">
  <tr>
   <td class="menudottedline">
     <div class="pathway">
       <!--<img src="../imagenes/systeminfo.png"  align="left" border="0" /><br/>-->
     <p>
     <font size="-2">M&oacute;dulo:&nbsp;&nbsp;z_rptroles.php<p><p></b>Descripci&oacute;n: especificados.</font>
     </div>	
   </td>
   
   <td class="menudottedline" width="9%"></td>
      <td class="menudottedline" align="right">
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	  <tr valign="left" align="left">
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../comun/z_rptroles.php?vopc=1">
	      <img src="../imagenes/cancel_f2.png" alt="&nbsp;Cancelar" name="Cancelar" title="Cancelar" align="left" border="0" /><br/>&nbsp;Cancelar</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../comun/z_rptprol.php?vrol=<?php echo $this->_tpl_vars['vrol']; ?>
" target="_blank">
	      <img src="../imagenes/print_f2.png" alt="&nbsp;Imprimir" name="Imprimir" title="Imprimir" align="left" border="0" /><br/>&nbsp;Imprimir</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../comun/z_rptprolt.php">
	      <img src="../imagenes/print_f2.png" alt="&nbsp;Imprimir" name="Imprimir" title="Imprimir" align="left" border="0" /><br/>&nbsp;Imp. Todos</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../comun/z_adminis.php">
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
  </center>

  </div>  
</form>

</body>
</html>