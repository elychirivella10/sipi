<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="frmstatus1" action="z_estatus.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name='estatus' size="3" maxlength="3" value='{$estatus}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.frmstatus2.nombre)" onchange="valagente(document.frmstatus1.estatus,document.frmstatus2.estatus2)">&nbsp;
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

<form name="frmstatus2" action="z_estatus.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='estatus' value={$estatus}>
  <input type ='hidden' name='estatus2' value={$estatus2}>
  <input type ='hidden' name='vstring' value='{$vstring}'>
  <input type ='hidden' name='campos' value='{$campos}'>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name='nombre' value='{$nombre}' {$modo} size="90" maxlength="90" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,90,document.frmstatus2.publica)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="publica" {$modo2} >
          {html_options values=$apli_inf selected=$publica output=$apli_def}
        </select>
      </td>
    </tr>
    {if $vopc eq 3 || $vopc eq 1}
    <tr>
      <td class="izq-color" >{$campo4}</td>
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
        <a href="z_estatus.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3}
        <a href="z_estatus.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
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
