<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/wforms.js"></script>  
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="form" action="m_resbuscarbolabog2.php?est=7" method="POST">
  <table>
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
        <input class="validate-integer required" type="text" name="bol" size="4" maxlength="4" value=""> 
        </td>	
      <td class="cnt">
      <input type="image" src="../imagenes/buscar_f2.png" width="32" height="24" value="Nueva Solicitud">Buscar  
      </td>
    </tr>
    <tr><td colspan='3'><p align='center'>
    <a href='javascript:window.history.back();'><img src='../imagenes/restore_f2.png' border='0' onclick='javascript:history.back()' ></a>  Volver  
    </p> </td></tr>
  </table>
 </form>
</div>
</body>
</html>