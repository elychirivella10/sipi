<?php /* Smarty version 2.6.8, created on 2021-04-12 07:38:24
         compiled from p_rptppeticio.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'p_rptppeticio.tpl', 24, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<!-- <h3> <?php echo $this->_tpl_vars['H3']; ?>
</h3> -->

<form name="forpeticio" action="p_rptpetic.php" method="POST">
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <div align="center">
  <table >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name="recibo" align="right" size="6" maxlength="6" onkeyup="checkLength(event,this,2,document.forpeticio.vsol2)"">
      </td>
    </tr>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name="fecha" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecsold'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.forpeticio.fecha)"> 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <input type="text" name="numpet" size="5" maxlength="5" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type="text" name="titular" size="65" maxlength="100" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <input type="text" name="solicit" size="65" maxlength="100" onchange="this.value=this.value.toUpperCase()">
      </td>
   </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <input type="text" name="tipo" size="1" maxlength="1" onchange="this.value=this.value.toUpperCase()">
      </td>
    <tr>
    </tr>
     
  </table><!--</font>--></center>
	<p></p>
     <!-- <input type="submit" value="Buscar" name="B1">
     <input type="reset" value="Cancelar" name="cancelar">
	  <input type="button" value="Salir" OnClick="location.href='index1.php';"> -->

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/save_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="p_rptppeticio.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>


  </div>  
</form>

</body>
</html>