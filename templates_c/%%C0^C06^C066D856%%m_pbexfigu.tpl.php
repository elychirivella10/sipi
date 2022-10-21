<?php /* Smarty version 2.6.8, created on 2020-10-20 08:33:28
         compiled from m_pbexfigu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_pbexfigu.tpl', 51, false),)), $this); ?>
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
  <input type ='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
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

<form name="formarcas2" enctype="multipart/form-data" action="m_pbexfig1.php?vopc=0" method="POST" onsubmit='return pregunta();'>
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

  <!-- <table width="85%" border="1" cellspacing="1"> -->
  <table width="960px" border="1" cellspacing="1">
    <tr><td class="izq4-color" colspan="2"><?php echo $this->_tpl_vars['lcviena']; ?>
</td></tr>
    <tr><td>    
    <!-- <iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src="m_verccv.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vfac=<?php echo $this->_tpl_vars['recibo']; ?>
&vplan=<?php echo $this->_tpl_vars['planilla']; ?>
"></iframe> --> 
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="m_verccv.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vfac=<?php echo $this->_tpl_vars['recibo']; ?>
&vplan=<?php echo $this->_tpl_vars['planilla']; ?>
"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" <?php echo $this->_tpl_vars['modo3']; ?>
 size="11" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" <?php echo $this->_tpl_vars['modo3']; ?>
 onclick="gestionvienap(document.formarcas2.v1,document.formarcas2.vviena,document.formarcas2.vvienai)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" <?php echo $this->_tpl_vars['modo3']; ?>
 onclick="gestionvienap(document.formarcas2.v1,document.formarcas2.vviena,document.formarcas2.vvienae)">
    </td></tr>
  </table>

  <table  cellpadding="0" cellspacing="0" border="1" width="960px">
  <tr>
   <td class="menudottedline" >
     <div class="pathway">
       <!--<img src="../imagenes/systeminfo.png"  align="left" border="0" /><br/>-->
     <p>
     <font size="-2">M&oacute;dulo:&nbsp;&nbsp;m_pbexfigu.php<p></b>Descripci&oacute;n: Rescata todas aquellas solicitudes de Marcas que presenten los C&oacute;digos de Viena en la Clase Internacional de Niza especificada.</font>
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
 src="../imagenes/boton_procesar_rojo.png" value="Procesar" border="0"></a>
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
</form>
</div>  

</body>
</html>