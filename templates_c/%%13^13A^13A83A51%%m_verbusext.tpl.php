<?php /* Smarty version 2.6.8, created on 2020-10-21 11:09:15
         compiled from m_verbusext.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_verbusext.tpl', 53, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas1" action="m_verbusext.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
>
  <input type ='hidden' name='name' value=<?php echo $this->_tpl_vars['name']; ?>
>

  <table>
     <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
         <input tabindex="1" type="text" name="v1" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)">&nbsp;
      </td>
      <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_verbusext.php?vopc=0" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='v1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
>
  <input type ='hidden' name='sede' value=<?php echo $this->_tpl_vars['sede']; ?>
>
  <input type ='hidden' name='envio' value=<?php echo $this->_tpl_vars['envio']; ?>
>
  <input type ='hidden' name='email' value=<?php echo $this->_tpl_vars['email']; ?>
>
  <input type ='hidden' name='name' value=<?php echo $this->_tpl_vars['name']; ?>
>
  
  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fecharec" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecharec']; ?>
' size="10" align="right">
      </td>
      <td class="izq2-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size="1" name="prioridad" <?php echo $this->_tpl_vars['modo2']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['prioridad'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
      <td class="der-color" rowspan="8" valign="top">
        <!--<input name="ubicacion" type="file" <?php echo $this->_tpl_vars['modo2']; ?>
 value='<?php echo $this->_tpl_vars['ubicacion']; ?>
' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;"> -->
        <br><a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target='_blank'><img border='0' src='<?php echo $this->_tpl_vars['nameimage']; ?>
' width='270' height='270'></a></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
         <input type="text" name="recibo" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['recibo']; ?>
' size="7" >
      </td>
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
	<textarea rows="2" name="solicitant" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="80"><?php echo $this->_tpl_vars['solicitant']; ?>
</textarea>
      </td>
    </tr> 
    <?php if ($this->_tpl_vars['accion'] == 1): ?>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <input tabindex="2" type="text" name="clase" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['clase']; ?>
' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr> 
    <?php else: ?>
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2"></td>
    </tr> 
    <?php endif; ?>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
         <input tabindex="6" type="text" name="planilla" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['planilla']; ?>
' size="8" maxlength="8" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    
    </table>
    &nbsp;

   <td class="menudottedline" ></td>
   <td class="menudottedline" align="right">

	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	  <tr valign="left" align="left">
	    <td>&nbsp;</td>
	    <td>
	      <a href='<?php echo $this->_tpl_vars['name']; ?>
' target='_blank'><img border='1' src='../imagenes/boton_verresultado_rojo.png'></a>
	      <!-- <a><input type="image" <?php echo $this->_tpl_vars['modo3']; ?>
 src="../imagenes/boton_verresultado_rojo.png" value="Ver PDF" border="0"></a> -->
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a href="../marcas/m_verbusext.php?vopc=5">
	      <img src="../imagenes/boton_cancelar_rojo.png" alt="&nbsp;Cancelar" name="Cancelar" title="Cancelar" align="left" border="0" /><br/></a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a href="../index1.php">
	      <img src="../imagenes/boton_salir_rojo.png"  alt="&nbsp;Logout" name="Salir" title="Salir" align="left" border="0" /><br/></a>
	    </td>
	    <td>&nbsp;</td>
	 </tr>
	</table>

      </td>
   </td>
  </tr>
  </table>
</form>
</div>  

</body>
</html>