<?php /* Smarty version 2.6.8, created on 2020-11-19 10:52:07
         compiled from m_fondotxt.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_fondotxt.tpl', 25, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?php echo $this->_tpl_vars['title']; ?>
</title>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">
<form name="formarcas2" enctype="multipart/form-data" action="m_fondotxt.php?vopc=2" method="POST" onsubmit='return pregunta();'>

<table>
<tr>
  <tr>
    <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
     <td class="der-color">
       <input type="text" name="boletin" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
    </td>
  </tr>   
  <tr>
    <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
    <td class="der-color">
      <select size="1" name="estatus">
        <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvest'],'selected' => $this->_tpl_vars['estatus'],'output' => $this->_tpl_vars['arraytest']), $this);?>

      </select>
    </td>
  </tr> 
<table>
<tr>

&nbsp;
<table align="center">
  <tr>
    <td class="cnt">
      <input type="submit" value="Transferir" class="botones">&nbsp;&nbsp;</td>
    <td class="cnt">
      <a href="../index1.php"><input type="button" value=" Salir " class="botones"></a></td>
  </tr>
</table>



 </form>
</div>
</body>
</html>