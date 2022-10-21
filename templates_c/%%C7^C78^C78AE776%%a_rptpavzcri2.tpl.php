<?php /* Smarty version 2.6.8, created on 2022-07-08 11:49:47
         compiled from a_rptpavzcri2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'a_rptpavzcri2.tpl', 33, false),array('function', 'html_options', 'a_rptpavzcri2.tpl', 50, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="foravzcri" action="a_rptavzcri2.php" method="POST">
  <div align="center">
  <br>
<table width="80%">
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type='hidden' name='clase' value='I'>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
      <?php echo $this->_tpl_vars['campod']; ?>
 <input type="text" name="vsol1" align="right" size="6" maxlength="6"  onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol1,6)">
      <?php echo $this->_tpl_vars['campoh']; ?>
 <input type="text" name="vsol2" align="right" size="6" maxlength="6" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2,6)" >
      </td>
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
       <?php echo $this->_tpl_vars['campod']; ?>
 <input type="text" name="vreg1" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vreg1,6)">   

       <?php echo $this->_tpl_vars['campoh']; ?>
 <input type="text" name="vreg2" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vreg2,6)">   
      </td>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>
 <input type="text" name="fecsold" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecsold'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='10' maxlength="10" onChange="valFecha(document.foravzcri.fecsold)"> 
	<?php echo $this->_tpl_vars['campoh']; ?>

     <input type="text" name="fecsolh" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecsolh'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='10' maxlength="10" onChange="valFecha(document.foravzcri.fecsolh)">
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>
 <input type="text" name="fecregd" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecregd'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='10' maxlength="10" onChange="valFecha(document.foravzcri.fecregd)"> 
	<?php echo $this->_tpl_vars['campoh']; ?>

     <input type="text" name="fecregh" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecregh'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='10' maxlength="10" onChange="valFecha(document.foravzcri.fecregh)">
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo11']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayestatus'],'selected' => $this->_tpl_vars['estatus'],'output' => $this->_tpl_vars['arraydescri1']), $this);?>

        </select>
      </td>
    </tr> 

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo12']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipo'],'selected' => $this->_tpl_vars['tipo'],'output' => $this->_tpl_vars['arraytipo']), $this);?>

        </select>
      </td>
    </tr> 
<!--    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='clase'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayclase'],'selected' => $this->_tpl_vars['clase'],'output' => $this->_tpl_vars['arrayclase']), $this);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='origen'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayorigen'],'selected' => $this->_tpl_vars['origen'],'output' => $this->_tpl_vars['arrayorigen']), $this);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='forma'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayforma'],'selected' => $this->_tpl_vars['forma'],'output' => $this->_tpl_vars['arrayforma']), $this);?>

        </select>
      </td>
    </tr> 
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='pais'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraypais'],'selected' => $this->_tpl_vars['pais'],'output' => $this->_tpl_vars['arraynombre']), $this);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo15']; ?>
</td>
      <td class="der-color">
        <input type="text" name="nombre" size="65" maxlength="200" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>   -->
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo19']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='orden'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayorden'],'selected' => $this->_tpl_vars['orden'],'output' => $this->_tpl_vars['arrayorden']), $this);?>

        </select>
      </td>
    </tr> 

  </table></center>
  <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_rojo.png" value="Buscar"></td>
      <td class="cnt"><a href="a_rptpavzcri.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
	  
  </div>  
</form>

</body>
</html>