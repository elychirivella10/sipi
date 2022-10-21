<?php /* Smarty version 2.6.8, created on 2020-11-17 14:46:22
         compiled from m_rptpexp_esc.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

 <form name="forcronol" action="m_rptpexp1_esc.php" method="post">
 <div align="center">
 <br>
 
  <table >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forcronol.vsol2)" onchange="Rellena(document.forcronol.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcronol.submit)" onchange="Rellena(document.forcronol.vsol2,6)">
      </td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
    </tr>
   
  </table><!--</font>--></center>
	<br>
 </form>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_rojo.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpexp_esc.php?vsol1=<?php echo $this->_tpl_vars['vsol1']; ?>
&vsol2=<?php echo $this->_tpl_vars['vsol2']; ?>
"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

  </div>  
</form>
<br><br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>