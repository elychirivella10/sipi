<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
<form name="forsolpre" action="m_busfonpdfsr.php?vopc=2" method="POST" onsubmit='return confirmar();'> 
  </br></br>
  <table>
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name="pedido" size="6" maxlength="6">  
        </td>	
    </tr>
  </table>
  &nbsp;

 <table width="210">
   <tr>
     <td class="cnt"><input type="image" src="../imagenes/boton_enviar_azul.png"></td>
     <td class="cnt"><a href="m_busfonpdfsr.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
     <td class="cnt"><a href="m_panelfon.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
   </tr>
 </table>
 
</form>
</div>

</body>
</html>
