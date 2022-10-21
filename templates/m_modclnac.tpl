<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_modclnac.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value='{$usuario}'>
  <input type='hidden' name='vsol' value='{$vsol}'>
  <input type='hidden' name='nconexion' value='{$nconexion}'>
  <input type='hidden' name='nveces' value='{$nveces}'>    
  
  <table>
     <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='{$vsol2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      &nbsp;	 	     
      </td>	
      <td class="cnt">	 	
	 	<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_modclnac.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='dirano' value={$dirano}>
  <input type='hidden' name='vsol1' value={$vsol1}>
  <input type='hidden' name='vsol2' value={$vsol2}>
  <input type='hidden' name='accion' value={$accion}>
  <input type='hidden' name='vclase' value={$vclase}>
  <input type='hidden' name='varsol' value={$varsol}>
  <input type='hidden' name='nconexion' value='{$nconexion}'>
  <input type='hidden' name='nveces' value='{$nveces}'>    
  <input type='hidden' name='vclnac' value='{$vclnac}'>
  <input type='hidden' name='tipomarca' value='{$tipomarca}'>
  <input type='hidden' name='vder' value='{$vder}'>
  <input type='hidden' name='mstring1' value='{$mstring1}'>
  <input type='hidden' name='campos1' value='{$campos1}'>
  <input type='hidden' name='mstring2' value='{$mstring2}'>
  <input type='hidden' name='campos2' value='{$campos2}'>
  <input type='hidden' name='mstring3' value='{$mstring3}'>
  <input type='hidden' name='campos3' value='{$campos3}'>
      
  <table cellspacing="1" border="1">
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" {$modo} value='{$fecha_solic}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" {$modo1} > 
          {html_options values=$arraytipom selected=$tipo_marca output=$arraynotip}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
         <select size="1" name="modalidad" {$modo1} >
           {html_options values=$arrayvmodal selected=$modalidad output=$arraytmodal}
         </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" {$modo} cols="57" maxlength="120" onkeyup="this.value=this.value.toUpperCase()">{$nombre}</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
         <input type="text" name="vclnac" {$modo1} value='{$vclnac}' size="2" maxlength="2" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
         <input type="text" name="vclase" {$modo1} value='{$vclase}' size="2" maxlength="2" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color" >
	     <textarea rows="8" name="distingue" {$modo} cols="80">{$distingue}</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2"></td>
    </tr>
    </table>

  <table width="200" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo3} src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      {if $vopc eq 1}
          <a href="m_modclnac.php?vopc=4&nconexion={$nconexion}&nveces={$nveces}"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
      {if $vopc eq 4}
          <a href="m_modclnac.php?vopc=4&nconexion={$nconexion}&nveces={$nveces}"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      {/if}    
    </td>      
    <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>
  
</form>
</div>  

</body>
</html>
