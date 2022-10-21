<?php /* Smarty version 2.6.8, created on 2020-10-21 12:42:52
         compiled from m_modprod.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_modprod.tpl', 73, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas1" action="m_modprod.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
>
  <input type='hidden' name='vreg' value=<?php echo $this->_tpl_vars['vreg']; ?>
>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>  
  <input type='hidden' name='conx' value='<?php echo $this->_tpl_vars['conx']; ?>
'>  
  <input type='hidden' name='salir' value='<?php echo $this->_tpl_vars['salir']; ?>
'>  
    
  <input type='hidden' name='nconexion' value='<?php echo $this->_tpl_vars['nconexion']; ?>
'>
  <input type='hidden' name='nveces' value='<?php echo $this->_tpl_vars['nveces']; ?>
'>    

  <table>
     <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>

	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
                      value='<?php echo $this->_tpl_vars['registro1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,6, this)"  
                      onkeyup="checkLength(event,this,1,document.formarcas1.vreg2)"
		      onChange="this.value=this.value.toUpperCase()">-
            <input type="text" name="vreg2" size="6" maxlength="6" 
		      value='<?php echo $this->_tpl_vars['registro2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" 
                      onkeyup="checkLength(event,this,6,document.formarcas1.submit)" 
                      onchange="Rellena(document.formarcas1.vreg2,6)">
      <td class="cnt">&nbsp;<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      
      <td class="izq5-color">Solicitud No.:</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      </td>	
      <td class="cnt">	 	
	 	&nbsp;<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>

  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_modprod.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type='hidden' name='vsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
>
  <input type='hidden' name='vreg1' value=<?php echo $this->_tpl_vars['vreg1']; ?>
>
  <input type='hidden' name='vreg2' value=<?php echo $this->_tpl_vars['vreg2']; ?>
>
  <input type='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type='hidden' name='vclase' value=<?php echo $this->_tpl_vars['vclase']; ?>
>
  <input type='hidden' name='varsol' value=<?php echo $this->_tpl_vars['varsol']; ?>
>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>  
  <input type='hidden' name='conx' value='<?php echo $this->_tpl_vars['conx']; ?>
'>
  <input type='hidden' name='salir' value='<?php echo $this->_tpl_vars['salir']; ?>
'>  
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>  

  <input type='hidden' name='nconexion' value='<?php echo $this->_tpl_vars['nconexion']; ?>
'>
  <input type='hidden' name='nveces' value='<?php echo $this->_tpl_vars['nveces']; ?>
'>    
        
  <table cellspacing="1" border="1">
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.fecha_regis)" onchange="valFecha(this,document.formarcas2.fecha_regis)" >
         &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo3']; ?>
&nbsp;&nbsp;
         <select size="1" name="tipo_marca" <?php echo $this->_tpl_vars['modo1']; ?>
 onchange="habilema(document.formarcas2.tipo_marca,document.formarcas2.vsol3,document.formarcas2.vsol4,document.formarcas2.vreg1d,document.formarcas2.vreg2d)">
           <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['tipo_marca'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

         </select>
         &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;
         <input type="text" name="vclase" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" >
      </td>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="95" maxlength="120" onkeyup="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color" colspan="2">
	     <textarea rows="13" name="distingue" <?php echo $this->_tpl_vars['modo']; ?>
 cols="95" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['distingue']; ?>
</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2">
      </td>
    </tr>
    </table>
    &nbsp;
    &nbsp;
  <table width="180" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
          <a href="m_modprod.php?vopc=4&nconexion=<?php echo $this->_tpl_vars['nconexion']; ?>
&nveces=<?php echo $this->_tpl_vars['nveces']; ?>
"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
          <a href="m_modprod.php?vopc=3&nconexion=<?php echo $this->_tpl_vars['nconexion']; ?>
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