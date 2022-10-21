<?php /* Smarty version 2.6.8, created on 2021-02-18 17:45:32
         compiled from m_resnueva.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/wforms.js"></script>  
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">
<?php if ($this->_tpl_vars['tipo'] == ""): ?>
<form name="form" action="m_resnueva.php" method="POST">
  <table>
      <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo0']; ?>
</td>
      <td class="der-color"><?php echo $this->_tpl_vars['campo01']; ?>

	<input type="image" width="20px" height="20px" alt="buscar" src="../imagenes/search.png" value="Guardar">
     </td>
     </tr>
    <tr>
 </table>
  <table width="255" >
  <tr>
    <td class="cnt">
	<a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir</td>
  </tr>
  </table>
 </form>
<?php endif;  if ($this->_tpl_vars['tipo'] != ""): ?>
<form name="form" action="m_resnueva2tpl.php" method="POST">
  <table>
      <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo0']; ?>
</td>
      <td class="der-color"><?php echo $this->_tpl_vars['campo01']; ?>
</td>	
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
	<fieldset id="solicitud" style="border:0px">
	    <input type="button" value="Añadir Solicitud" onclick="crear(this)" /><br />
	</fieldset>
      </td>	
    </tr>
    <tr> 
      <td class="izq-color"> <?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
	<select class="validate-integer required" id="reg_lab" name="reg_lab" value="selected" onchange="VisiblePlantillas(this.value,'ley55','ley344');">
	     <option value="">[Seleccione]</option>        
	     <option value="1"  >Ley de Propiedad Industrial de 1955</option>                 
	     <option value="2"  >Comunidad Andina de Naciones (CAN)</option>					  
	 </select>
      </td>	
    </tr>
    
    <tr> 
     <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
     <td class="der-color">
     
     	<div id="ley344">
            <label>Ley por La Comunidad Andina de Naciones (CAN)</label><br/>
	    <?php unset($this->_sections['cont']);
$this->_sections['cont']['name'] = 'cont';
$this->_sections['cont']['loop'] = is_array($_loop=$this->_tpl_vars['vnumrows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cont']['show'] = true;
$this->_sections['cont']['max'] = $this->_sections['cont']['loop'];
$this->_sections['cont']['step'] = 1;
$this->_sections['cont']['start'] = $this->_sections['cont']['step'] > 0 ? 0 : $this->_sections['cont']['loop']-1;
if ($this->_sections['cont']['show']) {
    $this->_sections['cont']['total'] = $this->_sections['cont']['loop'];
    if ($this->_sections['cont']['total'] == 0)
        $this->_sections['cont']['show'] = false;
} else
    $this->_sections['cont']['total'] = 0;
if ($this->_sections['cont']['show']):

            for ($this->_sections['cont']['index'] = $this->_sections['cont']['start'], $this->_sections['cont']['iteration'] = 1;
                 $this->_sections['cont']['iteration'] <= $this->_sections['cont']['total'];
                 $this->_sections['cont']['index'] += $this->_sections['cont']['step'], $this->_sections['cont']['iteration']++):
$this->_sections['cont']['rownum'] = $this->_sections['cont']['iteration'];
$this->_sections['cont']['index_prev'] = $this->_sections['cont']['index'] - $this->_sections['cont']['step'];
$this->_sections['cont']['index_next'] = $this->_sections['cont']['index'] + $this->_sections['cont']['step'];
$this->_sections['cont']['first']      = ($this->_sections['cont']['iteration'] == 1);
$this->_sections['cont']['last']       = ($this->_sections['cont']['iteration'] == $this->_sections['cont']['total']);
?>
 	    <input name="plantilla" id="plantilla" type="radio" value ="<?php echo $this->_tpl_vars['plantid1'][$this->_sections['cont']['index']]; ?>
" /> <?php echo $this->_tpl_vars['nombre'][$this->_sections['cont']['index']]; ?>
<br/>
	    <label><?php echo $this->_tpl_vars['descripcion'][$this->_sections['cont']['index']]; ?>
</label>
	    <br/>  
	    <?php endfor; endif; ?> 
        </div>

  
     	<div id="ley55">
            <label>Ley de Propiedad Indstrial de 1955</label><br/>
	    <?php unset($this->_sections['cont']);
$this->_sections['cont']['name'] = 'cont';
$this->_sections['cont']['loop'] = is_array($_loop=$this->_tpl_vars['vnumrows2']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cont']['show'] = true;
$this->_sections['cont']['max'] = $this->_sections['cont']['loop'];
$this->_sections['cont']['step'] = 1;
$this->_sections['cont']['start'] = $this->_sections['cont']['step'] > 0 ? 0 : $this->_sections['cont']['loop']-1;
if ($this->_sections['cont']['show']) {
    $this->_sections['cont']['total'] = $this->_sections['cont']['loop'];
    if ($this->_sections['cont']['total'] == 0)
        $this->_sections['cont']['show'] = false;
} else
    $this->_sections['cont']['total'] = 0;
if ($this->_sections['cont']['show']):

            for ($this->_sections['cont']['index'] = $this->_sections['cont']['start'], $this->_sections['cont']['iteration'] = 1;
                 $this->_sections['cont']['iteration'] <= $this->_sections['cont']['total'];
                 $this->_sections['cont']['index'] += $this->_sections['cont']['step'], $this->_sections['cont']['iteration']++):
$this->_sections['cont']['rownum'] = $this->_sections['cont']['iteration'];
$this->_sections['cont']['index_prev'] = $this->_sections['cont']['index'] - $this->_sections['cont']['step'];
$this->_sections['cont']['index_next'] = $this->_sections['cont']['index'] + $this->_sections['cont']['step'];
$this->_sections['cont']['first']      = ($this->_sections['cont']['iteration'] == 1);
$this->_sections['cont']['last']       = ($this->_sections['cont']['iteration'] == $this->_sections['cont']['total']);
?>
 	    <input name="plantilla" id="plantilla" type="radio" value ="<?php echo $this->_tpl_vars['plantid2'][$this->_sections['cont']['index']]; ?>
" /> <?php echo $this->_tpl_vars['nombre2'][$this->_sections['cont']['index']]; ?>
<br/>
	    <label><?php echo $this->_tpl_vars['descripcion2'][$this->_sections['cont']['index']]; ?>
</label>
	    <br/>  
	    <?php endfor; endif; ?> 
        </div>

	

     </td>        
    </tr>
 </table>

  <table width="255" >

  <tr>
    <td class="cnt">
	<input type="image" src="../imagenes/siguiente.gif" value="Guardar">Siguiente</td> 
    <td class="cnt">
	<a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir</td>
  </tr>
  </table>

 </form>
<?php endif; ?>
</div>
</body>
</html>