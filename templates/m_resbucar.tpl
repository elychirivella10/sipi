<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/wforms.js"></script>  
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_resbuscar2.php" method="POST">
  <table>
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
        <input class="required" type="text" name="vsol1" size="4" maxlength="4" value='{$vsol1}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)" onBlur="valagente(document.formarcas1.vsol1,document.formarcas2.vsol1a)">-
        <input class="required" type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)" onBlur="valagente(document.formarcas1.vsol2,document.formarcas2.vsol2a)">
        </td>	
      <td class="cnt">
      <input type="image" src="../imagenes/buscar_f2.png" width="32" height="24" value="Nueva Solicitud">Buscar  
      </td>
    </tr>
<tr><td colspan='3' class='cnt'><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir</td>
  </tr>
  </table>
 </form>
</div>
</body>
</html>
