<?php /* Smarty version 2.6.8, created on 2022-08-22 16:57:18
         compiled from m_pconfcol.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<!-- <h3> <?php echo $this->_tpl_vars['H3']; ?>
</h3> -->

  <div align="center">
      <TABLE cellPadding=5 border=1>    
        <TBODY> 
        <TR>
          <TD bgColor=#D8E6FF><FONT color=#ffffff size=1>#D8E6FF</FONT></TD>
          <TD bgColor=#000000><FONT color=#666666 size=1>#000000</FONT></TD>
          <TD bgColor=#1E5F99><FONT color=#ffffff size=1>#1E5F99</FONT></TD>
          <TD bgColor=#7AC0EF><FONT color=#666666 size=1>#7AC0EF</FONT></TD>
          <TD bgColor=#669EC4><FONT color=#ffffff size=1>#669EC4</FONT></TD>
          <TD bgColor=#6396FC><FONT color=#666666 size=1>#6396FC</FONT></TD>
          <TD bgColor=#FFF9CC><FONT color=#666666 size=1>#FFF9CC</FONT></TD></TR>
        <TR>
        <TR>
          <TD bgColor=#ff0000><FONT color=#ffffff size=1>#FF0000</FONT></TD>
          <TD bgColor=#00ff00><FONT color=#666666 size=1>#00FF00</FONT></TD>
          <TD bgColor=#0000ff><FONT color=#ffffff size=1>#0000FF</FONT></TD>
          <TD bgColor=#ffff00><FONT color=#666666 size=1>#FFFF00</FONT></TD>
          <TD bgColor=#ff00ff><FONT color=#ffffff size=1>#FF00FF</FONT></TD>
          <TD bgColor=#00ffff><FONT color=#666666 size=1>#00FFFF</FONT></TD>
          <TD bgColor=#ffffff><FONT color=#666666 size=1>#FFFFFF</FONT></TD></TR>
        <TR>
          <TD bgColor=#cc0000><FONT color=#ffffff size=1>#CC0000</FONT></TD>
          <TD bgColor=#00cc00><FONT color=#ffffff size=1>#00CC00</FONT></TD>
          <TD bgColor=#0000cc><FONT color=#ffffff size=1>#0000CC</FONT></TD>
          <TD bgColor=#cccc00><FONT color=#333333 size=1>#CCCC00</FONT></TD>
          <TD bgColor=#cc00cc><FONT color=#ffffff size=1>#CC00CC</FONT></TD>
          <TD bgColor=#00cccc><FONT color=#333333 size=1>#00CCCC</FONT></TD>
          <TD bgColor=#cccccc><FONT color=#333333 size=1>#CCCCCC</FONT></TD></TR>
        <TR>
          <TD bgColor=#990000><FONT color=#ffffff size=1>#990000</FONT></TD>
          <TD bgColor=#009900><FONT color=#ffffff size=1>#009900</FONT></TD>
          <TD bgColor=#000099><FONT color=#ffffff size=1>#000099</FONT></TD>
          <TD bgColor=#999900><FONT color=#ffffff size=1>#999900</FONT></TD>
          <TD bgColor=#990099><FONT color=#ffffff size=1>#990099</FONT></TD>
          <TD bgColor=#009999><FONT color=#ffffff size=1>#009999</FONT></TD>
         <TD bgColor=#999999><FONT color=#ffffff size=1>#999999</FONT></TD></TR>
        <TR>
          <TD bgColor=#660000><FONT color=#ffffff size=1>#660000</FONT></TD>
          <TD bgColor=#006600><FONT color=#ffffff size=1>#006600</FONT></TD>
          <TD bgColor=#000066><FONT color=#ffffff size=1>#000066</FONT></TD>
          <TD bgColor=#666600><FONT color=#ffffff size=1>#666600</FONT></TD>
          <TD bgColor=#660066><FONT color=#ffffff size=1>#660066</FONT></TD>
          <TD bgColor=#006666><FONT color=#ffffff size=1>#006666</FONT></TD>
          <TD bgColor=#666666><FONT color=#ffffff size=1>#666666</FONT></TD></TR>
        <TR>
          <TD bgColor=#330000><FONT color=#ffffff size=1>#330000</FONT></TD>
          <TD bgColor=#003300><FONT color=#ffffff size=1>#003300</FONT></TD>
          <TD bgColor=#000033><FONT color=#ffffff size=1>#000033</FONT></TD>
          <TD bgColor=#333300><FONT color=#ffffff size=1>#333300</FONT></TD>
          <TD bgColor=#330033><FONT color=#ffffff size=1>#330033</FONT></TD>
          <TD bgColor=#003333><FONT color=#ffffff size=1>#003333</FONT></TD>
          <TD bgColor=#333333><FONT color=#ffffff size=1>#333333</FONT></TD>
         </TR></TBODY></TABLE
  </div> 
  <form name="forconfcol" action="m_confcol.php" method="POST">
  <div align="center">
<p></p>
  <?php echo $this->_tpl_vars['campo0']; ?>

 <table >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">     
        <input type="text" name="fondo" align="right" size="7" maxlength="7" onchange="this.value=this.value.toUpperCase()">     
      </td>
    </tr>  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">     
        <input type="text" name="letras" align="right" size="7" maxlength="7" onchange="this.value=this.value.toUpperCase()" >     
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">     
        <input type="text" name="tabizq" align="right" size="7" maxlength="7" onchange="this.value=this.value.toUpperCase()">     
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">     
        <input type="text" name="letizq" align="right" size="7" maxlength="7" onchange="this.value=this.value.toUpperCase()" >     
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">     
        <input type="text" name="tabder" align="right" size="7" maxlength="7" >     
      </td>
    </tr>
  </table><!--</font>--></center>
	<p></p>
     <!-- <input type="submit" value="Grabar" name="B1">
     <input type="reset" value="Cancelar" name="cancelar">
	  <input type="button" value="Salir" OnClick="location.href='../index1.php';"> -->

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/save_f2.png" value="Buscar">  Modificar  </td>
      <td class="cnt"><a href="m_pconfcol.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
	  
  </div>  
</form>

</body>
</html>