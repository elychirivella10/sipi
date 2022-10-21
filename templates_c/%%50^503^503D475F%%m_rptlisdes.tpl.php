<?php /* Smarty version 2.6.8, created on 2020-11-07 20:33:02
         compiled from m_rptlisdes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_rptlisdes.tpl', 28, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<!-- <h3> <?php echo $this->_tpl_vars['H3']; ?>
</h3> -->

<form name="forobscon" action="m_rptlisdes.php" method="POST">
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <div align="center">

<table >
  <tr>

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>
  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipo'],'selected' => $this->_tpl_vars['tipo'],'output' => $this->_tpl_vars['arraytipo']), $this);?>

        </select>
      </td>
    </tr> 

  </table><!--</font>--></center>
	<p></p>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/search_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="m_rptplisdes.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0">
</a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
	  
  </div>  
</form>

</body>
</html>