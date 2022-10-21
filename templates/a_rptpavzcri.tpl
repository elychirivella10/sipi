<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="foravzcri" action="a_rptavzcri.php" method="POST">
  <div align="center">
  <br>
<table width="80%">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
      {$campod} <input type="text" name="vsol1" align="right" size="6" maxlength="6"  onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol1,6)">
      {$campoh} <input type="text" name="vsol2" align="right" size="6" maxlength="6" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2,6)" >
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
       {$campod} <input type="text" name="vreg1" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vreg1,6)">   

       {$campoh} <input type="text" name="vreg2" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vreg2,6)">   
      </td>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        {$campod} <input type="text" name="fecsold" value='{$fecsold|date_format:"%d/%m/%G"}' size='10' maxlength="10" onChange="valFecha(document.foravzcri.fecsold)"> 
	{$campoh}
     <input type="text" name="fecsolh" value='{$fecsolh|date_format:"%d/%m/%G"}' size='10' maxlength="10" onChange="valFecha(document.foravzcri.fecsolh)">
    </tr>

    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        {$campod} <input type="text" name="fecregd" value='{$fecregd|date_format:"%d/%m/%G"}' size='10' maxlength="10" onChange="valFecha(document.foravzcri.fecregd)"> 
	{$campoh}
     <input type="text" name="fecregh" value='{$fecregh|date_format:"%d/%m/%G"}' size='10' maxlength="10" onChange="valFecha(document.foravzcri.fecregh)">
    </tr>

    <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          {html_options values=$arrayestatus selected=$estatus output=$arraydescri1}
        </select>
      </td>
    </tr> 

    <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          {html_options values=$arraytipo selected=$tipo output=$arraytipo}
        </select>
      </td>
    </tr> 
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color" >
        <select size='1' name='clase'>
          {html_options values=$arrayclase selected=$clase output=$arrayclase}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color" >
        <select size='1' name='origen'>
          {html_options values=$arrayorigen selected=$origen output=$arrayorigen}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color" >
        <select size='1' name='forma'>
          {html_options values=$arrayforma selected=$forma output=$arrayforma}
        </select>
      </td>
    </tr> 
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>

    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color" >
        <select size='1' name='pais'>
          {html_options values=$arraypais selected=$pais output=$arraynombre}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo15}</td>
      <td class="der-color">
        <input type="text" name="nombre" size="65" maxlength="200" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>   
    <tr>
      <td class="izq-color" >{$campo19}</td>
      <td class="der-color" >
        <select size='1' name='orden'>
          {html_options values=$arrayorden selected=$orden output=$arrayorden}
        </select>
      </td>
    </tr> 

  </table></center>
  <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_rojo.png" value="Buscar"></td>
      <td class="cnt"><a href="a_rptpavzcri.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
	  
  </div>  
</form>

</body>
</html>
