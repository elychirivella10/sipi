<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/wforms.js"></script>  
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="form" action="m_resagregaexp2.php" method="POST">
  <table>
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
	<fieldset id="solicitud" style="border:0px">
	    <input type="button" value="AGREGAR EXPEDIENTE" onclick="crear(this)" /><br />
	</fieldset>
      </td>	
    </tr>
 </table>

  <table width="255" >
  <tr>
    <input type='hidden' value='{$campo2}' name='id'>
    <input type='hidden' value='{$campo3}' name='est'>
    <td class="cnt"><input type="image" src="../imagenes/save_f2.png" value="Guardar">Guardar </td> 
    
    <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir</td>
  </tr>
  </table>

 </form>
</div>
</body>
</html>
