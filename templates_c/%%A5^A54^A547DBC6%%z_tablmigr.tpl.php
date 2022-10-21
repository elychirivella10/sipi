<?php /* Smarty version 2.6.8, created on 2021-09-17 22:32:19
         compiled from z_tablmigr.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'z_tablmigr.tpl', 19, false),array('function', 'html_options', 'z_tablmigr.tpl', 53, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="frmstatus1" action="z_tablmigr.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
        <?php echo smarty_function_html_radios(array('name' => 'tipoder','values' => $this->_tpl_vars['tipo_der'],'selected' => $this->_tpl_vars['tipoder'],'output' => $this->_tpl_vars['dere_def']), $this);?>

      <?php endif; ?> 
      &nbsp;   
      </td>	

      <td class="cnt">
        <?php if ($this->_tpl_vars['vopc'] == 4): ?>
                <input type ='hidden' name='accion' value='Modificacion'>
	        <input type='image' src="../imagenes/search_f2.png" width="28" height="24" 
                       value="Buscar">  Buscar  
        <?php endif; ?>
        <?php if ($this->_tpl_vars['vopc'] == 3): ?>
                <input type ='hidden' name='accion' value='Ingreso'> 
	        <input type='image' src="../imagenes/folder_add_f2.png" width="28" height="24" 
                       value="Nuevo">  Nuevo  
        <?php endif; ?> 
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="frmstatus2" action="z_tablmigr.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='estatus' value=<?php echo $this->_tpl_vars['estatus']; ?>
>

  <table>
  <tr>

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color" >
        <input type="text" name="input4" value='<?php echo $this->_tpl_vars['evento2_id']; ?>
' size="3" maxlength="3" <?php echo $this->_tpl_vars['modo']; ?>
 onKeyup="checkLength(event,this,3,document.frmstatus2.evento2_id)" onchange="valagente(document.frmstatus2.input4,document.frmstatus2.evento2_id)">-
        <select size="1" name="evento2_id" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="this.form.input4.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayevento'],'selected' => $this->_tpl_vars['evento2_id'],'output' => $this->_tpl_vars['arraydescri']), $this);?>

        </select>
      </td>
    </tr>
  
  
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color" >
        <input type="text" name="input1" value='<?php echo $this->_tpl_vars['est_id1']; ?>
' size="3" maxlength="3" <?php echo $this->_tpl_vars['modo']; ?>
 onKeyup="checkLength(event,this,3,document.forlotes.est_id1)" onchange="valagente(document.forlotes.input1,document.forlotes.est_id1)">-
        <select size='1' name='est_id1' '<?php echo $this->_tpl_vars['modo2']; ?>
' onchange="this.form.input1.value=this.options[this.selectedIndex].value">      
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayest1'],'selected' => $this->_tpl_vars['est_id1'],'output' => $this->_tpl_vars['arraynom1']), $this);?>

        </select>
        <!-- <select size='1' name='est_id1' '<?php echo $this->_tpl_vars['modo2']; ?>
'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayest1'],'selected' => $this->_tpl_vars['est_id1'],'output' => $this->_tpl_vars['arraynom1']), $this);?>

        </select> -->
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color" >
        <input type="text" name="input3" value='<?php echo $this->_tpl_vars['est_id2']; ?>
' size="3" maxlength="3" <?php echo $this->_tpl_vars['modo']; ?>
 onKeyup="checkLength(event,this,3,document.forlotes.est_id2)" onchange="valagente(document.forlotes.input3,document.forlotes.est_id2)" >-
        <select size='1' name='est_id2' '<?php echo $this->_tpl_vars['modo2']; ?>
' onchange="this.form.input3.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayest2'],'selected' => $this->_tpl_vars['est_id2'],'output' => $this->_tpl_vars['arraynom2']), $this);?>

        </select>
        <!-- <select size='1' name='est_id2' '<?php echo $this->_tpl_vars['modo2']; ?>
'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayest2'],'selected' => $this->_tpl_vars['est_id2'],'output' => $this->_tpl_vars['arraynom2']), $this);?>

        </select> -->
      </td>
    </tr>

  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name='estatus' size="3" maxlength="3" value='<?php echo $this->_tpl_vars['estatus']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 
               onKeyPress="return acceptChar(event,2, this)">&nbsp;
      </td>	
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <input type="text" name='inicial' value='<?php echo $this->_tpl_vars['inicial']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="3" maxlength="3" 
               onKeyPress="return acceptChar(event,2, this)"
               onKeyup="checkLength(event,this,3,document.frmstatus2.final)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type="text" name='final' value='<?php echo $this->_tpl_vars['final']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="3" maxlength="3" 
               onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <?php if (( $this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['accion'] == 2 ) || $this->_tpl_vars['vopc'] == 4): ?>
        <a href="z_tablmigr.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      <?php endif; ?>    
      <?php if (( $this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['accion'] == 1 ) || $this->_tpl_vars['vopc'] == 3): ?>
        <a href="z_tablmigr.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      <?php endif; ?>    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

</form>
</div>  
</body>
</html>