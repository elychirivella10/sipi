<?php /* Smarty version 2.6.8, created on 2021-03-15 12:45:14
         compiled from p_regsole.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'p_regsole.tpl', 104, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="formarcas1" action="p_regsole.php?vopc=1"method="POST">
 <input type='hidden' name='nconexion' value='<?php echo $this->_tpl_vars['nconexion']; ?>
'>
 <input type='hidden' name='nveces' value='<?php echo $this->_tpl_vars['nveces']; ?>
'>    

<div align="center">
  <table>
  <tr>
    <tr>
      <td class="izq5-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vsol2']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		 &nbsp;
		 </td>
		<td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
    </tr>
  </tr>
  </table>
</form>
&nbsp;

<form name="formarcas2" action="p_regsole.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
>
  <input type='hidden' name='vest1' value=<?php echo $this->_tpl_vars['vest1']; ?>
>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='tnumera' value=<?php echo $this->_tpl_vars['tnumera']; ?>
>
  <input type='hidden' name='letrareg' value=<?php echo $this->_tpl_vars['letrareg']; ?>
>
  <input type='hidden' name='fechasolic' value=<?php echo $this->_tpl_vars['fechasolic']; ?>
>
  <input type='hidden' name='nconexion' value='<?php echo $this->_tpl_vars['nconexion']; ?>
'>
  <input type='hidden' name='nveces' value='<?php echo $this->_tpl_vars['nveces']; ?>
'>    
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>

  <div align="center">

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fechasolic" value='<?php echo $this->_tpl_vars['fechasolic']; ?>
' readonly="readonly" size="9" align="right">
      </td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" rowspan="8" align="center">
          <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank">
          <img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="195" height="225">
        </td>
      <?php endif; ?>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <input type="text" name="tipo_p" value='<?php echo $this->_tpl_vars['tipo_p']; ?>
' readonly="readonly" size="1">
        <input type="text" name="tipo" value='<?php echo $this->_tpl_vars['tipo']; ?>
' readonly="readonly" size="30">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="vnombre" readonly="readonly" cols="70" maxlength="80"><?php echo $this->_tpl_vars['vnombre']; ?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vest1" value='<?php echo $this->_tpl_vars['vest1']; ?>
' size="3" readonly="readonly" > - 
        <input type="text" name="vest2" value='<?php echo $this->_tpl_vars['vest2']; ?>
' size="70" readonly="readonly" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vnomtit" value='<?php echo $this->_tpl_vars['vnomtit']; ?>
' readonly="readonly" size="70" maxlength="80">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vnactit" value='<?php echo $this->_tpl_vars['vnactit']; ?>
' size="1" readonly="readonly" align="right"> - 
        <input type="text" name="vnadtit" value='<?php echo $this->_tpl_vars['vnadtit']; ?>
' size="20" readonly="readonly">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vtra" value='<?php echo $this->_tpl_vars['vtra']; ?>
' size="70" maxlength="80" readonly="readonly">
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table>
  <tr>
    <td class="izq-color"><?php echo $this->_tpl_vars['campo11']; ?>
</td>
	 <td class="der-color">
	   <input type="text" name="vfecvi" size="10" maxlength="10" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['vfecvi'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onchange="valFecha(this,this,document.formarcas2.pago)" onKeyUp="checkLength(event,this,10,document.formarcas2.vfecvi)" >
	 </td>  
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td class="izq-color"><?php echo $this->_tpl_vars['campo12']; ?>
</td>
	 <td class="der-color">
	   <input type="text" name="pago" size="10" maxlength="10" value='<?php echo $this->_tpl_vars['pago']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 align="right">
	 </td>
	 <td>&nbsp;&nbsp;&nbsp;</td> 
    <td class="izq-color"><?php echo $this->_tpl_vars['campo13']; ?>
</td>
	 <td class="der-color">
	   <input type="text" name="letra" size="1" maxlength="1" value='<?php echo $this->_tpl_vars['letra']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 align="right" onKeyUp="this.value=this.value.toUpperCase();checkLength(event,this,1,document.formarcas2.numereg)" onKeyPress="return acceptChar(event,4, this)">-
	   <input type="text" name="numereg" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['numereg']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 align="right" onchange="Rellena(document.formarcas1.numereg,6)">
	 </td>
  </tr>
  </table>
  &nbsp;
  <table width="300">
  <tr>
    <td class="cnt"><a href="p_cronolo.php?vsol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
">
    <input type="image" src="../imagenes/folder_f2.png"></a>		Cronologia 		</td> 
    <td class="cnt"><input type="image" <?php echo $this->_tpl_vars['modo']; ?>
 src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
    <td class="cnt"><a href="p_regsole.php?nconexion=<?php echo $this->_tpl_vars['nconexion']; ?>
&nveces=<?php echo $this->_tpl_vars['nveces']; ?>
"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
    <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['nconexion']; ?>
"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
  </tr>
  </table>
  </div>  
</form>

</body>
</html>

