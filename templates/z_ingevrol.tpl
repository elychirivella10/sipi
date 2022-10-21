<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forevrol" action="z_gbevrol.php" method="POST" onsubmit='return pregunta();'>
  <input type="hidden" name="totalevm" value='{$totalevm}'>
  <input type="hidden" name="totalevp" value='{$totalevp}'>  
  <input type="hidden" name="idm_even" value='{$idm_even}'>    
  <input type="hidden" name="idp_even" value='{$idm_even}'>    
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
        {html_checkboxes name="idm_even" values=$marrayevento selected=$evento_m output=$marraydescev separator="<br />"}
      </td>
    </tr>
  </table></center>
  &nbsp;
  {$campo3}
  <table>
    <tr>
      <td class="der-color" >
        {html_checkboxes name="idp_even" values=$parrayevento selected=$evento_p output=$parraydescev separator="<br />"}
      </td>
    </tr>
  </tr>
  </table></center>
  &nbsp;
  {$campo4}
  <table>
    <tr>
      <td class="der-color" >
        {html_checkboxes name="ida_even" values=$aarrayevento selected=$evento_a output=$aarraydescev separator="<br />"}
      </td>
    </tr>
  </tr>
  </table></center>
  &nbsp;
  {$campo5}
  <table>
    <tr>
      <td class="der-color" >
        {html_checkboxes name="idi_even" values=$iarrayevento selected=$evento_i output=$iarraydescev separator="<br />"}
      </td>
    </tr>
  </table></center>

  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td>
    <td class="cnt">
      <a href="../comun/z_ingevrol.php?conx=0&na_conex={$na_conex}&nconex={$n_conex}&salir=1"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
    </td>      
    <td class="cnt">
      <a href="../comun/z_evenrol.php?conx=1&na_conex={$na_conex}&nconex={$n_conex}&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

  </div>  
</form>

</body>
</html>
