<?php /* Smarty version 2.6.8, created on 2020-11-04 10:56:09
         compiled from m_est_usuxmes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_est_usuxmes.tpl', 31, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forestanu" action="m_est_usuxmes.php?vopc=1" method="POST">
  <div align="center">
  <br>
 <table>
  <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo0']; ?>
</td>
      <td class="der-color"><input type="text" name="ano1" align="right" size="8" maxlength="10" 
               onkeyup="checkLength(event,this,10,document.forestanu.ano2)"
               onchange="valFecha(this,document.forestanu.ano2)">
      </td>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color"><input type="text" name="ano2" align="right" size="8" maxlength="10" 
           onkeyup="checkLength(event,this,10,document.forestanu.evento)"
           onchange="valFecha(this,document.forestanu.evento)">
      </td>
  </tr>
</table>
&nbsp; 
<table>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <select size=1 name="evento">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['est_val'],'selected' => ' ','output' => $this->_tpl_vars['est_des']), $this);?>

        </select></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size=1 name="usuario">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['pai_val'],'selected' => 1,'output' => $this->_tpl_vars['pai_des']), $this);?>

        </select></td>
    </tr>
  </table></center>
    
	<br>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_graficar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_est_usuxmes.php?vopc=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

  </div>  
</form>
<br><br><br><br>
</body>
</html>