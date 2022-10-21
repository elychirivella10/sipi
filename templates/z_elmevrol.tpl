<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">

<!-- <form name="forrole" action="z_elmevrol.php?vopc=1" method="POST">
<div align="center">
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
       <td class="der-color" >
        <select size='1' name='rol_id'>
          {html_options values=$arrayrole selected=$rol_id output=$arraynombre}
        </select>
        <input type='{$submitbutton}' name='submit' value='Buscar'>
       </td>
    </tr>
  </tr>
  </table>
</form>    -->   

<form name="forrole1" action="z_elmevrol.php?vopc=2" method="POST" onsubmit="return pregunta1();" >  
  <input type='hidden' name='rol_id' value='{$rol_id}'>
  <input type="hidden" name="nconex" value='{$n_conex}'>
  <input type="hidden" name="na_conex" value='{$na_conex}'>

  <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name='rol' value='{$rol_id}' {$modo} size="13" maxlength="13">&nbsp;-&nbsp; 
        <input type="text" name='nbrol' value='{$nbrol}' {$modo} size="73" maxlength="73">
      </td>
  </tr>

  {if $totalevm neq 0}
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
        {html_checkboxes name="idm_even" values=$marrayevento selected=$evento_m output=$marraydescev separator="<br />"}
      </td>
    </tr>
  </tr>
  </table>
  {/if}    
  &nbsp;
  {if $totalevp neq 0}
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color" >
        {html_checkboxes name="idp_even" values=$parrayevento selected=$evento_p output=$parraydescev separator="<br />"}
      </td>
    </tr>
  </tr>
  </table>
  {/if}    
  &nbsp;
  {if $totaleva neq 0}
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color" >
        {html_checkboxes name="ida_even" values=$aarrayevento selected=$evento_a output=$aarraydescev separator="<br />"}
      </td>
    </tr>
  </tr>
  </table>
  {/if}    
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/delete_f2.png" value="Eliminar">  Eliminar  </td> 
    <td class="cnt">
      <a href="../comun/z_evenrol.php?conx=1&na_conex={$na_conex}&nconex={$n_conex}&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>
</div>  
</form>

</body>
</html>
