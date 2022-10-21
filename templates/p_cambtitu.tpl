<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  <div align="center">
    <form name="formarcas1" action="p_cambtitu.php?vopc=1" method="post">
      <table>
      <tr><td class="izq5-color">{$lsolicitud}</td>
	  <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$solicitud1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" 
                onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" 
                onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" 
                onkeyup="checkLength(event,this,6,document.formarcas1.submit)" 
                onchange="Rellena(document.formarcas1.vsol2,6)">
	  <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" 
                                   height="24" value="Buscar">  Buscar  </td></tr>
      </table>
    </form>				  
    <form name="formarcas3" action="p_cambtitu.php?vopc=3" method="post" 
          onsubmit='return pregunta();'>
    &nbsp; 
    <table  width="90%" cellspacing="1" border="1">	
    <tr><td width="20%" class="izq-color">{$lfecsol}</td>
	<td class="der-color"><input size="9" type="text" name="vfecsol" 
            value='{$vfecsol}' {$vmodo}>   </td>
	{if $vmod eq "G" || $vmod eq "M"}
        <td class="der-color" rowspan="3" align="left" valign="top">
          <a href='{$nameimage}' target="_blank">
          <img border="-1" src={$nameimage} width="100">
        </td> 
        {/if}
    </tr>
    <tr><td class="izq-color">{$lnombre}</td>
	<td class="der-color">
        <input size="73" type="text" name="vnom" value='{$nombre}' {$vmodo}>   </td></tr>
    <tr><td class="izq-color">{$lclase}</td>
	<td class="der-color"><input size="2" type="text" name="vest" value='{$vest}' {$vmodo}> 
        <input size="67" type="text" name="vdesest" value='{$vdesest}' {$vmodo}></td></tr>
    </table>
    <!-- Titulares Actuales--> 
    <table width="90%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$ltitular}</td></tr>
    <tr><td class="izq2-color">
    <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
              src='exampletit.php?psol={$vsol}&ptip=I&pder={$vderh}'></iframe> 
    </td></tr>  
    </table>		
    &nbsp;
    <input type="hidden" name="vfecven" value='{$vfecven}'>
    <input type="hidden" name="vmodo" value='Incluir'>
    &nbsp;     
    <table width="90%" cellspacing="1" border="1">	
    <tr>
       <td width="25%" class="izq-color">{$lfechaevento}</td>
<td class="der-color"><input size="9" type="text" name="vfevh"   onkeyup="checkLength(event,this,10,document.formarcas3.vdoc)"
	   onchange="valFecha(this,document.formarcas3.vdoc)"></td>
       </tr>
       <tr><td class="izq-color">{$ldocumento}</td>
	  <td class="der-color"><input size="9" type="text" name="vdoc" value='{$vdoc}' maxlength="9" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,9,document.formarcas3.vtitut)"></td></tr>
      </table>
      <!-- Titulares Finales--> 
      <table width="90%" cellspacing="1" border="1">
      <tr><td class="izq4-color">{$ltitular2}</td></tr>
      <tr><td class="izq2-color">
      <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
              src='exampletit.php?psol={$vsol}&ptip=P'></iframe> 
      </td></tr>  
      </table>
      <!-- -->
      <table width="90%" cellspacing="1" border="1">	
      <tr><td class="der-color">
      <input type="text" name="vtitut" {$modo} size="35" 
             onChange="javascript:this.value=this.value.toUpperCase();">
      <input type="button" class="boton_blue" value="Buscar/Incluir" {$modo2} name="vtitui" 
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
      <input type="button" class="boton_blue" value="Buscar/Eliminar" {$modo2} name="vtitue"          
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
      <!--  -->
      </td></tr>	
      </table>
      &nbsp;
      
      <legend align='center' class='Estilo3'><strong><span>&nbsp;&nbsp;INGRESE EL DATO DE FACTURACION&nbsp;&nbsp;</span></strong></legend>
      <table cellspacing="1" border="1">
	    <tr>
	      <td class="izq-color">{$lfactura}</td>
	      <td class="der-color">
	        <input size="7" type="text" name="vfactura" maxlength="7" {$modo2}>	    
         </td>
	    </tr>        
      </table>
      <br>
      
      <input type="hidden" name="vsolh" value='{$vsolh}'>
      <input type="hidden" name="vderh" value='{$vderh}'>
      <br/ >  
     <table width="225">
        <tr>
<!--        <td class="cnt"><a href="m_rptcronol.php?vsol1={$solicitud1}&vsol2={$solicitud2}&vreg1={$registro1}&vreg2={$registro2}"><input type="image" src="../imagenes/folder_f2.png"></a>Cronologia</td> -->
        <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar"> Guardar </td> 
    <td class="cnt"><a href="p_cambtitu.php"><img src="../imagenes/cancel_f2.png" border="0"></a>	Cancelar </td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir </td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


