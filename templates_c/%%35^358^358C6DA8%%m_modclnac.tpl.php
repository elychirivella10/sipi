<?php /* Smarty version 2.6.8, created on 2020-10-21 09:39:56
         compiled from m_modclnac.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_modclnac.tpl', 63, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas1" action="m_modclnac.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value='<?php echo $this->_tpl_vars['usuario']; ?>
'>
  <input type='hidden' name='vsol' value='<?php echo $this->_tpl_vars['vsol']; ?>
'>
  <input type='hidden' name='nconexion' value='<?php echo $this->_tpl_vars['nconexion']; ?>
'>
  <input type='hidden' name='nveces' value='<?php echo $this->_tpl_vars['nveces']; ?>
'>    
  
  <table>
     <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      &nbsp;	 	     
      </td>	
      <td class="cnt">	 	
	 	<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_modclnac.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='dirano' value=<?php echo $this->_tpl_vars['dirano']; ?>
>
  <input type='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type='hidden' name='vsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
>
  <input type='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type='hidden' name='vclase' value=<?php echo $this->_tpl_vars['vclase']; ?>
>
  <input type='hidden' name='varsol' value=<?php echo $this->_tpl_vars['varsol']; ?>
>
  <input type='hidden' name='nconexion' value='<?php echo $this->_tpl_vars['nconexion']; ?>
'>
  <input type='hidden' name='nveces' value='<?php echo $this->_tpl_vars['nveces']; ?>
'>    
  <input type='hidden' name='vclnac' value='<?php echo $this->_tpl_vars['vclnac']; ?>
'>
  <input type='hidden' name='tipomarca' value='<?php echo $this->_tpl_vars['tipomarca']; ?>
'>
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>
  <input type='hidden' name='mstring1' value='<?php echo $this->_tpl_vars['mstring1']; ?>
'>
  <input type='hidden' name='campos1' value='<?php echo $this->_tpl_vars['campos1']; ?>
'>
  <input type='hidden' name='mstring2' value='<?php echo $this->_tpl_vars['mstring2']; ?>
'>
  <input type='hidden' name='campos2' value='<?php echo $this->_tpl_vars['campos2']; ?>
'>
  <input type='hidden' name='mstring3' value='<?php echo $this->_tpl_vars['mstring3']; ?>
'>
  <input type='hidden' name='campos3' value='<?php echo $this->_tpl_vars['campos3']; ?>
'>
      
  <table cellspacing="1" border="1">
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" <?php echo $this->_tpl_vars['modo1']; ?>
 > 
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['tipo_marca'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
         <select size="1" name="modalidad" <?php echo $this->_tpl_vars['modo1']; ?>
 >
           <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvmodal'],'selected' => $this->_tpl_vars['modalidad'],'output' => $this->_tpl_vars['arraytmodal']), $this);?>

         </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="120" onkeyup="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
         <input type="text" name="vclnac" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['vclnac']; ?>
' size="2" maxlength="2" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
         <input type="text" name="vclase" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="2" maxlength="2" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color" >
	     <textarea rows="8" name="distingue" <?php echo $this->_tpl_vars['modo']; ?>
 cols="80"><?php echo $this->_tpl_vars['distingue']; ?>
</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2"></td>
    </tr>
    </table>

  <table width="200" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo3']; ?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
          <a href="m_modclnac.php?vopc=4&nconexion=<?php echo $this->_tpl_vars['nconexion']; ?>
&nveces=<?php echo $this->_tpl_vars['nveces']; ?>
"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 4): ?>
          <a href="m_modclnac.php?vopc=4&nconexion=<?php echo $this->_tpl_vars['nconexion']; ?>
&nveces=<?php echo $this->_tpl_vars['nveces']; ?>
"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      <?php endif; ?>    
    </td>      
    <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['nconexion']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>
  
</form>
</div>  

</body>
</html>