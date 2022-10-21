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
      <td class="izq-color">{$campo1}</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='{$vsol2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      &nbsp;	 	     
      </td>	
      <td class="cnt">	 	
	 	<input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
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
      
  <table cellspacing="2">
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" {$modo} value='{$fecha_solic}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" {$modo2} > 
          {html_options values=$arraytipom selected=$tipo_marca output=$arraynotip}
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

  <table width="250" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo3} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      {if $vopc eq 1}
          <a href="m_modclnac.php?vopc=4&nconexion={$nconexion}&nveces={$nveces}"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 4}
          <a href="m_modclnac.php?vopc=4&nconexion={$nconexion}&nveces={$nveces}"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>
  
</form>
</div>  

</body>
</html>
