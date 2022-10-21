<?php /* Smarty version 2.6.8, created on 2020-11-07 20:29:46
         compiled from m_devnocon.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forcaduca" action="m_devnocon1.php?vopc=2" method="POST">
  <div align="center">

  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3" value='<?php echo $this->_tpl_vars['boletin']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forcaduca.actualizar)">
      </td>
    </tr>   
  </table></center>
	<p></p>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="actualizar" src="../imagenes/search_f2.png" value="Actualizar">  Buscar  </td>
      <td class="cnt"><a href="m_devnocon.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
</div>  
</form>

</body>
</html>