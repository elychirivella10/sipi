<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forevrol" action="z_gbrolus.php" method="POST" onsubmit='return pregunta();'>
  <input type="hidden" name="totalusr" value='{$totalusr}'>
  <input type="hidden" name="rol_user" value='{$rol_user}'>    
  <input type="hidden" name="usuario" value='{$login}'>
  <input type="hidden" name="nconex" value='{$n_conex}'>
  <input type="hidden" name="na_conex" value='{$na_conex}'>
      
  <div align="center">
  <table>
  <tr>  
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color" >
        <select size='1' name='rol_id'>
          {html_options values=$arrayrole selected=$rol_id output=$arraynombre}
        </select>
      </td>
    </tr>
  </table></center>
  &nbsp;
  {$campo2}
  <table>
    <tr>
      <td class="der-color" >
        {html_checkboxes name="rol_user" values=$arraylogin selected=$user_r output=$arrayusuario separator="<br />"}
      </td>
    </tr>
  </table></center>
  &nbsp;
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td>
    <td class="cnt">
      <a href="../comun/z_asgusrol.php?conx=0&na_conex={$na_conex}&nconex={$n_conex}&salir=1"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
    </td>      
    <td class="cnt">
      <a href="../comun/z_asigrol.php?conx=1&na_conex={$na_conex}&nconex={$n_conex}&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

  </div>  
</form>

</body>
</html>
