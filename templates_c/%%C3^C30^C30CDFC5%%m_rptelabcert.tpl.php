<?php /* Smarty version 2.6.8, created on 2020-11-04 08:52:38
         compiled from m_rptelabcert.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'm_rptelabcert.tpl', 19, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<!-- <h3> <?php echo $this->_tpl_vars['H3']; ?>
</h3> -->

<form name="foravztra" action="m_rptelabcert.php" method="POST">
  <div align="center">
  <br>
  <table>
  <tr>
 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campot']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo7']; ?>
 <input type="text" name="desdet" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['desdet'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.desdet)" onChange="valFecha(this,document.foravztra.desdet)"> 
	<?php echo $this->_tpl_vars['campo8']; ?>

     <input type="text" name="hastat" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['hastat'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.hastat)" onChange="valFecha(this,document.foravztra.hastat)">
    </tr>
   


    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
    </tr>

    </tr>   
  </table><!--</font>--></center>
	<br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpelabcert.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div> 
<br><br><br><br><br><br><br><br><br><br><br><br><br><br> 
</form>

</body>
</html>