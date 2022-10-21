<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
<form name="forsolpre" action="z_fileboletin_conp.php?vopc=2" method="POST" onsubmit='return confirmar();'> 

<br><br>
&nbsp;
 <table width="500">
   <tr>
      <td class="izq-color" >Boletin:</td>
      <td class="der-color">
        <input type="text" name="boletin" size='3' maxlength="3" 
               onKeyPress="return acceptChar(event,2, this)" 
               onkeyup="checkLength(event,this,3,document.forsolpre.fechapub)"></td> 
   </tr>
   <tr>
      <td class="izq-color" >Fecha Vencimiento Pago de Derechos:</td>
      <td class="der-color">
        <input type="text" name="fechapub" size='9' onChange="valFecha(document.forsolpre.fechapub)"> 
        <font class="textoayuda">Formato: dd/mm/aaaa</font></td> 
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
