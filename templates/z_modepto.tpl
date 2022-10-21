<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">

<form name="fordepto" action="z_modepto.php?vopc=2" method="POST" onsubmit="return pregunta();">  
 <input type='hidden' name='iddepto' value='{$iddepto}'> 
 <input type='hidden' name='usuario' value='{$login}'>
 <input type='hidden' name='nconex' value='{$n_conex}'>
 <input type='hidden' name='na_conex' value='{$na_conex}'>
 <input type='hidden' name='conx' value=0>
 <input type='hidden' name='salir' value=0> 
 
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type='text' name='nombre' value='{$nombre}' {$modo2} size='60' maxlength="60" onKeyup="this.value=this.value.toUpperCase()" onKeyPress="return acceptChar(event,4,this)" >
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;

  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <a href="../comun/z_unidad.php?conx=1&na_conex={$na_conex}&nconex={$n_conex}&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>
  
</div>  
</form>

</body>
</html>
