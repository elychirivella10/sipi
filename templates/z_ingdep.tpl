<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="fordepto" action="z_gbdept.php" method="POST" onsubmit="return pregunta();">
  <input type="hidden" name="usuario" value="{$login}">
  <input type="hidden" name="nconex" value="{$n_conex}">
  <input type="hidden" name="na_conex" value="{$na_conex}">

  <div align="center">
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name='codigo' size="2" maxlength="2" onkeyup="this.value=this.value.toUpperCase()" onKeyPress="return acceptChar(event,2, this)" onchange="checkLength(event,this,3,document.fordepto.nombre)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name='nombre' size="60" maxlength="60" onkeyup="this.value=this.value.toUpperCase()" onKeyPress="return acceptChar(event,11, this)">
      </td>
    </tr>
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <a href="../comun/z_ingdep.php?conx=0&na_conex={$na_conex}&nconex={$n_conex}&salir=1"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
    </td>      
    <td class="cnt">
      <a href="../comun/z_unidad.php?conx=1&na_conex={$na_conex}&nconex={$n_conex}&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

  </div>  
</form>

</body>
</html>
