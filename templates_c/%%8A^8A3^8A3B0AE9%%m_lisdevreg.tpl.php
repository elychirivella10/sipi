<?php /* Smarty version 2.6.8, created on 2021-01-14 12:50:00
         compiled from m_lisdevreg.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_lisdevreg.tpl', 24, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="devreg" action="m_lisdevreg1.php" method="POST">
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <div align="center">

<table >
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>
 <input type="text" name="fecsold" value='<?php echo $this->_tpl_vars['fecsold']; ?>
' size='9' onChange="valFecha(document.foravzcri.fecsold)"> 
	<?php echo $this->_tpl_vars['campoh']; ?>

     <input type="text" name="fecsolh" value='<?php echo $this->_tpl_vars['fecsolh']; ?>
' size='9' onChange="valFecha(document.foravzcri.fecsolh)">
    </tr>
    <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['ltramite']; ?>
</td>
       <td class="der-color">
            <select size="1" name="tramite" >
              <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvtrami'],'selected' => $this->_tpl_vars['tramite'],'output' => $this->_tpl_vars['arrayttrami']), $this);?>

            </select>
         </td>
    </tr>   
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name="usuario" size="12" maxlength="13">
      </td>
    </tr>   


  </table><!--</font>--></center>
	<p></p>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/buscar_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="m_lisdevreg.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
	  
  </div>  
</form>

</body>
</html>