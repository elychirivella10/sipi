<?php /* Smarty version 2.6.8, created on 2020-10-20 08:36:18
         compiled from m_pbexfig1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_pbexfig1.tpl', 60, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas1" action="m_pbexfigu.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>

  <table>
     <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
         <input type="text" name="v1" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)">&nbsp;
      </td>
      <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="z_browsef.php?vopc=0" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='v1'      value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type ='hidden' name='accion'  value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
>

  <input type ='hidden' name='camposquery' value='<?php echo $this->_tpl_vars['camposquery']; ?>
'>
  <input type ='hidden' name='camposname'  value='<?php echo $this->_tpl_vars['camposname']; ?>
'>
  <input type ='hidden' name='tablas'      value='<?php echo $this->_tpl_vars['tablas']; ?>
'>
  <input type ='hidden' name='condicion'   value='<?php echo $this->_tpl_vars['condicion']; ?>
'> 
  <input type ='hidden' name='orden'       value='<?php echo $this->_tpl_vars['orden']; ?>
'>
  <input type ='hidden' name='modo'        value='<?php echo $this->_tpl_vars['modo']; ?>
'> 
  <input type ='hidden' name='modoabr'     value='<?php echo $this->_tpl_vars['modoabr']; ?>
'>
  <input type ='hidden' name='vurl'        value='<?php echo $this->_tpl_vars['vurl']; ?>
'>
  <input type ='hidden' name='new_windows' value='<?php echo $this->_tpl_vars['new_windows']; ?>
'>
  <input type ='hidden' name='envio'  value='<?php echo $this->_tpl_vars['envio']; ?>
'>
  <input type ='hidden' name='email'  value='<?php echo $this->_tpl_vars['email']; ?>
'>
  

  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fecharec" <?php echo $this->_tpl_vars['modo2']; ?>
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
        <select size="1" name="prioridad" <?php echo $this->_tpl_vars['modo1']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['prioridad'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
      <td class="der-color" rowspan="8" valign="top">
        <!-- <input name="ubicacion" type="file" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['ubicacion']; ?>
' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;"> -->
        <br><img src='<?php echo $this->_tpl_vars['nameimage']; ?>
' id="picture" width="270" height="270" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
         <input type="text" name="recibo" <?php echo $this->_tpl_vars['modo2']; ?>
 value='<?php echo $this->_tpl_vars['recibo']; ?>
' size="6" >
      </td>
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
	<textarea rows="2" name="solicitant" <?php echo $this->_tpl_vars['modo2']; ?>
 cols="57" maxlength="80"><?php echo $this->_tpl_vars['solicitant']; ?>
</textarea>
      </td>
    </tr> 
    <?php if ($this->_tpl_vars['accion'] == 1): ?>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <input type="text" name="clase" <?php echo $this->_tpl_vars['modo2']; ?>
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
         <input tabindex="6" type="text" name="planilla" <?php echo $this->_tpl_vars['modo2']; ?>
 value='<?php echo $this->_tpl_vars['planilla']; ?>
' size="8" maxlength="8" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    </table>

  <table>
  <tr>
    <td>
      <p align='center'><b><font size='2' face='Tahoma'>Se encontraron '<?php echo $this->_tpl_vars['subtotal']; ?>
' Posibles Parecidos Graficos</font></b></p>
    </td>
  </tr>
  </table>

  <table width="960px" border="1" cellspacing="1">
    <tr><td class="izq4-color" colspan="2"><?php echo $this->_tpl_vars['lcviena']; ?>
</td></tr>
    <tr><td>    
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="m_verccv.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vfac=<?php echo $this->_tpl_vars['recibo']; ?>
&vplan=<?php echo $this->_tpl_vars['planilla']; ?>
"></iframe> 
    </td></tr>
  </table>

  <table cellpadding="0" cellspacing="0" border="1" width="960px">
  <tr>
   <td class="menudottedline">
     <div class="pathway">
       <!--<img src="../imagenes/systeminfo.png"  align="left" border="0" /><br/>-->
     <p>
     <font size="-2">M&oacute;dulo:&nbsp;&nbsp;m_pbinfigu.php<p></b>Descripci&oacute;n: Rescata todas aquellas solicitudes de Marcas que presenten los C&oacute;digos de Viena en la Clase Internacional de Niza especificada.</font>
     </div>	
   </td>
   
   <td class="menudottedline" ></td>
      <td class="menudottedline" align="right">
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	  <tr valign="left" align="left">
	    <td>&nbsp;</td>
	    <td>
	      <a >
              <input type="image" <?php echo $this->_tpl_vars['modo3']; ?>
 src="../imagenes/boton_comparar_rojo.png" value="Comparar" border="0"></a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a href="../marcas/m_pbexfigu.php?vopc=5">
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
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

</form>
</div>  

</body>
</html>