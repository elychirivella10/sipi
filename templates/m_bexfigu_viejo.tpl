<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_bexfigu.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='auxnum' value={$auxnum}>
  <input type ='hidden' name='accion' value={$accion}>
  
  <table>
     <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
         <input tabindex="1" type="text" name="vsol1" size="5" maxlength="5" 
	        value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)"  onchange="valagente(document.formarcas1.vsol1,document.formarcas2.vsol2)">&nbsp;
      </td>
      <td class="cnt"><input tabindex="2" type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_bexfigu.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vsol1' value={$vsol1}>
  <input type ='hidden' name='modo' value={$vmodo}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='auxnum' value={$auxnum}>
  <input type ='hidden' name='planilla1' value={$planilla1}>
  
  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input tabindex="3" type="text" name="fecharec" {$modo} value='{$fecharec}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.prioridad)" onchange="valFecha(this,document.formarcas2.prioridad)" ></td>
      <td class="izq3-color" >{$campo10}</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select tabindex="4" size="1" name="prioridad" {$modo2} >
          {html_options values=$arraytipom selected=$prioridad output=$arraynotip}
        </select>
      </td>
      <td class="der-color" rowspan="8" valign="top">
        <input tabindex="5" name="ubicacion" type="file" {$modo3} value='{$ubicacion}' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><a href='{$nameimage}' target='_blank'><img border='0' id="picture" src='{$nameimage}' width='270' height='270'></a></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
         <input tabindex="6" type="text" name="recibo" {$modo} value='{$recibo}' size="6" maxlength="6">
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        <input tabindex="7" type="text" name="solicitant" {$modo} value='{$solicitant}' size="60" maxlength="80" onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,80,document.formarcas2.indole)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
           <select size="1" name="indole" {$modo2}>
              {html_options values=$vindole_id selected=$indole output=$vindole_de}
           </select>
      </td>
    </tr>  
   
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <select size="1" name="lced" {$modo2}>
           {html_options values=$lced_id selected=$lced output=$lced_de}
        </select>
        <input tabindex="8" type="text" name='nced' size="9" maxlength="9" value='{$nced}' {$modo} 
onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.formarcas2.nced,9)" onkeyup="checkLength(event,this,9,document.formarcas2.telefono)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color" colspan="2"><small>V = Venezolano,&nbsp;&nbsp;&nbsp;E = Extranjero,&nbsp;&nbsp;&nbsp;P = Pasaporte,&nbsp;&nbsp;&nbsp;J = Juridico,&nbsp;&nbsp;&nbsp;G = Gobierno</small></td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
        <input tabindex="9" type="text" name='telefono' value='{$telefono}' {$modo} size="15" maxlength="15" onKeyPress="return acceptChar(event,9, this)" onkeyup="checkLength(event,this,15,document.formarcas2.Guardar)">
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color">
         <input tabindex="10" type="text" name="planilla" {$modo} value='{$planilla}' size="7" maxlength="8" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2"></td>
    </tr> 
    </table>
  &nbsp;
  &nbsp;

  <table width="255" >
  <tr>
    <td class="cnt"><input tabindex="8" type="image" {$modo2} src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
         <a href="m_bexfigu.php?vopc=4"><img tabindex="9" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
      {if $vopc eq 3}
         <a href="m_bexfigu.php?vopc=3"><img tabindex="10" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      {/if}    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="11" src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>
