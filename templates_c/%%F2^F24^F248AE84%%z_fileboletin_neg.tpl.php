<?php /* Smarty version 2.6.8, created on 2021-08-10 13:21:49
         compiled from z_fileboletin_neg.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">
<form name="forsolpre" action="z_fileboletin_neg.php?vopc=2" method="POST" onsubmit='return confirmar();'> 

<br><br>
&nbsp;
 <table width="200">
   <tr>
      <td class="izq-color" >Boletin:</td>
      <td class="der-color">
        <input type="text" name="boletin" size='3' maxlength="3" 
               onKeyPress="return acceptChar(event,2, this)"></td> 
   </tr>
   <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_enviar_azul.png"></td> 
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
   </tr>
 </table>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</form>
</div>

</body>
</html>