<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="forevento1" action="z_evento.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name='evento' size="3" maxlength="3" value='{$evento}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forevento2.nombre)" onchange="valagente(document.forevento1.evento,document.forevento2.evento2)">&nbsp;
        {if $vopc eq 4}
          {html_radios name="tipoder" values=$tipo_der selected=$tipoder output=$dere_def}
        {/if}    
      </td>	
      <td class="cnt">
        {if $vopc eq 4}
	  <input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  
        {/if}
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="forevento2" action="z_evento.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='evento' value={$evento}>
  <input type ='hidden' name='evento2' value={$evento2}>
  <input type ='hidden' name='vstring' value='{$vstring}'>
  <input type ='hidden' name='campos' value='{$campos}'>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name='nombre' value='{$nombre}' {$modo} size="90" maxlength="90" onKeyPress="return acceptChar(event,0, this)" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,90,document.forevento2.tipo_evento)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color" >
        {html_radios name="tipo_evento" values=$tipo_eve selected=$tipo_evento output=$even_def separator="<br />"}
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <select size="1" name="inf_adicional" {$modo2} onchange="habilinf(document.forevento2.inf_adicional,document.forevento2.documento,document.forevento2.comentario)">
          {html_options values=$tipo_inf selected=$inf_adicional output=$info_def}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color"><input type='text' name='mensa_automatico' value='{$mensa_automatico}' {$modo} size='90' maxlength="90" onKeyPress="return acceptChar(event,0, this)" onkeyup="this.value=this.value.toUpperCase()"></td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <select size="1" name="tipo_plazo" {$modo2} onchange="habilplz(document.forevento2.tipo_plazo,document.forevento2.plazo_ley)">
          {html_options values=$tipo_plz selected=$tipo_plazo output=$plazo_def}
        </select>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color" >
      <input type='text' name='plazo_ley' value='{$plazo_ley}' {$modo} size='3' maxlength="3" onKeyPress="return acceptChar(event,2, this)"></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color"><input type='text' name='documento' value='{$documento}' {$modo} size='20' maxlength="20" onKeyPress="return acceptChar(event,3, this)"></td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color"><input type='text' name='comentario' value='{$comentario}' {$modo} size='40' maxlength="40" onKeyPress="return acceptChar(event,0, this)"></td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
        <select size="1" name="aplica" {$modo2} >
          {html_options values=$apli_inf selected=$aplica output=$apli_def}
        </select>
      </td>
    </tr>
    {if $vopc eq 3 || $vopc eq 1}
    <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color" >
        {html_radios name="tipoder" values=$tipo_der selected=$tipoder output=$dere_def separator="<br />"}
      </td>
    </tr>
    {/if}    
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
        <a href="z_evento.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3}
        <a href="z_evento.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

</form>

</div>  
</body>
</html>
