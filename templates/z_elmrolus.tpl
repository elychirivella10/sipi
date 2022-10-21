<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">

<form name="forrole1" action="z_elmrolus.php?vopc=2" method="POST" onsubmit="return pregunta1();" >  
  <input type="hidden" name="rol_id" value='{$rol_id}'>
  <input type="hidden" name="nconex" value='{$n_conex}'>
  <input type="hidden" name="na_conex" value='{$na_conex}'>
  
  {if $totalusr neq 0}
  <table width="900" >
  <tr>
    <tr>
      <td class="izq-color" width="150">{$campo2}</td>
      <td class="der-color" >
        {html_checkboxes name="idm_user" values=$uarraylogins selected=$login_id output=$uarraynombre separator="<br />"}
      </td>
    </tr>
  </tr>
  </table>
  {/if}    
  &nbsp;
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/delete_f2.png" value="Eliminar">  Eliminar  </td> 
    <td class="cnt">
      <a href="../comun/z_asigrol.php?conx=1&na_conex={$na_conex}&nconex={$n_conex}&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>
</div>  
</form>

</body>
</html>
