<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_modprod.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='vsol' value={$vsol}>
  <input type='hidden' name='vreg' value={$vreg}>
  <input type='hidden' name='nconex' value='{$n_conex}'>  
  <input type='hidden' name='conx' value='{$conx}'>  
  <input type='hidden' name='salir' value='{$salir}'>  
    
  <input type='hidden' name='nconexion' value='{$nconexion}'>
  <input type='hidden' name='nveces' value='{$nveces}'>    

  <table>
     <tr>
      <td class="izq5-color">{$campo1}</td>

	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
                      value='{$registro1}' {$vmodo} onKeyPress="return acceptChar(event,6, this)"  
                      onkeyup="checkLength(event,this,1,document.formarcas1.vreg2)"
		      onChange="this.value=this.value.toUpperCase()">-
            <input type="text" name="vreg2" size="6" maxlength="6" 
		      value='{$registro2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" 
                      onkeyup="checkLength(event,this,6,document.formarcas1.submit)" 
                      onchange="Rellena(document.formarcas1.vreg2,6)">
      <td class="cnt">&nbsp;<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      
      <td class="izq5-color">Solicitud No.:</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='{$vsol2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      </td>	
      <td class="cnt">	 	
	 	&nbsp;<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>

  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_modprod.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='vsol1' value={$vsol1}>
  <input type='hidden' name='vsol2' value={$vsol2}>
  <input type='hidden' name='vreg1' value={$vreg1}>
  <input type='hidden' name='vreg2' value={$vreg2}>
  <input type='hidden' name='accion' value={$accion}>
  <input type='hidden' name='vclase' value={$vclase}>
  <input type='hidden' name='varsol' value={$varsol}>
  <input type='hidden' name='nconex' value='{$n_conex}'>  
  <input type='hidden' name='conx' value='{$conx}'>
  <input type='hidden' name='salir' value='{$salir}'>  
  <input type='hidden' name='vder' value='{$vder}'>  

  <input type='hidden' name='nconexion' value='{$nconexion}'>
  <input type='hidden' name='nveces' value='{$nveces}'>    
        
  <table cellspacing="1" border="1">
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" {$modo1} value='{$fecha_solic}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.fecha_regis)" onchange="valFecha(this,document.formarcas2.fecha_regis)" >
         &nbsp;&nbsp;&nbsp;&nbsp;{$campo3}&nbsp;&nbsp;
         <select size="1" name="tipo_marca" {$modo1} onchange="habilema(document.formarcas2.tipo_marca,document.formarcas2.vsol3,document.formarcas2.vsol4,document.formarcas2.vreg1d,document.formarcas2.vreg2d)">
           {html_options values=$arraytipom selected=$tipo_marca output=$arraynotip}
         </select>
         &nbsp;&nbsp;{$campo5}&nbsp;
         <input type="text" name="vclase" {$modo1} value='{$vclase}' size="1" maxlength="2" >
      </td>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" {$modo1} cols="95" maxlength="120" onkeyup="this.value=this.value.toUpperCase()">{$nombre}</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color" colspan="2">
	     <textarea rows="13" name="distingue" {$modo} cols="95" onchange="this.value=this.value.toUpperCase()">{$distingue}</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2">
      </td>
    </tr>
    </table>
    &nbsp;
    &nbsp;
  <table width="180" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      {if $vopc eq 1}
          <a href="m_modprod.php?vopc=4&nconexion={$nconexion}&nveces={$nveces}"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
      {if $vopc eq 3}
          <a href="m_modprod.php?vopc=3&nconexion={$nconexion}&nveces={$nveces}"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
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
