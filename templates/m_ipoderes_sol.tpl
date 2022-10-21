<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <div align="center">
    <form name="formarcas1" action="m_ipoderes_sol.php?vopc=1" method="post">
      <input type="hidden" name="vaccion" value='{$vaccion}'>
      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$vsol1}' {$vmodo2} onKeyPress="return acceptChar(event,2, this)" 
                onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" 
                onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="3" maxlength="4" 
		value='{$vsol2}' {$vmodo2} onKeyPress="return acceptChar(event,2, this)" 
                onkeyup="checkLength(event,this,4,document.formarcas1.submit)" 
                onchange="Rellena(document.formarcas1.vsol2,4)">
		                  &nbsp;&nbsp;<input type={$submitbutton} class="boton_blue" name='submit' value={$vaccion}></td>
      </table>
    </form>				  
<!--    <form name="formarcas3" action="m_ipoderes_sol.php?vopc=5&vsol={$vsol}" method="post"> -->
    <form name="formarcas3" action="m_ipoderes_sol.php?vopc=5" method="post">
      <input type="hidden" name="vsol1" value='{$vsol1}'>
      <input type="hidden" name="vsol2" value='{$vsol2}'>
      <input type="hidden" name="vaccion" value='{$vaccion}'>
      <!-- Fecha y Facultad --> 
      <table width="80%">	
          <tr><td width="25%" class="izq-color">{$lfechapoder}</td>
	  <td width="25%" class="der-color">
          <input size="9" type="text" name="vfecp" value='{$vfecp}' 
              onkeyup="checkLength(event,this,10,document.formarcas3.vfac)"
	      onchange="valFecha(this,document.formarcas3.vfac)" {$vmodo}></td>
	  <td width="14%" class="izq-color">{$lfacultad}</td>
	  <td width="36%" class="der-color">
          <input size="1" type="text" name="vfac" value='{$vfac}' maxlength="1"
	      onkeyup="javascript:this.value=this.value.toUpperCase(); valfacultad(this); checkLength(event,this,1,document.formarcas3.vtitut)" {$vmodo}>{$lfacultad2}</td></tr>
      </table>	
      &nbsp; 
      <!-- Titulares --> 
      <table width="80%" cellspacing="1" border="1">
      <tr><td class="izq4-color">{$ltitular}</td></tr>
      <tr><td class="izq2-color">
      <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
              src='exampletit.php?psol={$vsol}'></iframe> 
      </td></tr>  
      <!-- -->
      {if $vopc eq 1 and $vaccion eq 'Incluir'}   
      <tr><td class="der-color">
      <input type="text" name="vtitut" {$modo} size="35" 
             onChange="javascript:this.value=this.value.toUpperCase();">
      <input type="button" class="boton_blue" value="Buscar/Incluir" {$modo2} name="vtitui" 
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
      <input type="button" class="boton_blue" value="Buscar/Eliminar" {$modo2} name="vtitue"          
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
      {/if}
      </td></tr>	
      </table>	
      &nbsp;  
      <!-- Poder Habientes --> 
      <table width="80%" cellspacing="1" border="1">
      <tr><td class="izq4-color">{$lpoderhabi}</td></tr>
      <tr><td class="izq2-color">
      <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
              src='examplepoh.php?psol={$vsol}'></iframe> 
      </td></tr>  
      <!-- --> 
      {if $vopc eq 1 and $vaccion eq 'Incluir'}   
      <tr><td class="der-color">
      <input type="text" name="vpodet" {$modo} size="35" 
          onChange="javascript:this.value=this.value.toUpperCase();">
      <input type="button" class="boton_blue" value="Buscar/Incluir" {$modo2} name="vpodei" 
          onclick="browsepoderhabi(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vpodet,document.formarcas3.vpodei)">
      <input type="button" class="boton_blue" value="Buscar/Eliminar" {$modo2} name="vpodee" 
          onclick="browsepoderhabi(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vpodet,document.formarcas3.vpodee)"> 
      {/if}
      </table>	
      &nbsp;  
      <!-- Solicitudes Marcas--> 
      <table width="80%" cellspacing="1" border="1">
      <tr><td class="izq4-color">Solictud(es) de Marca(s) Asociada(s):</td></tr>
      <tr><td class="izq2-color">
      <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
              src='examplesolm.php?psol={$vsol}'></iframe>  
      </td></tr>  
      <!-- --> 
      </table>
      &nbsp;
      <!-- Solicitudes Patentes--> 
      <table width="80%" cellspacing="1" border="1">
      <tr><td class="izq4-color">Solictud(es) de Patente(s) Asociada(s):</td></tr>
      <tr><td class="izq2-color">
      <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
              src='examplesolp.php?psol={$vsol}'></iframe>  
      </td></tr>  
      <!-- --> 
      </table>
      &nbsp;
      <table width="80%" cellspacing="1" border="1">	
          <tr><td width="25%" class="izq-color">Observación:</td>
	         <td width="75%" class="der-color"><input size="100" type="text" maxlength='512' name="vobs" value='{$vobs}' {$vmodo}></td>
	  </tr>
      </table>	
      &nbsp;
      <table width="225">
        <tr>
        {if $vopc eq 1 and $vaccion eq 'Incluir'}  
        <td class="cnt"><input type="image" name="accion" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td>
        <td class="cnt"><a href="m_ipoderes_sol.php?vopc=11"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td> 
        {/if}
        {if $vopc eq 1 and $vaccion eq 'Buscar'}  
        <td class="cnt"><input type="image" name="accion" src="../imagenes/boton_buscar_rojo.png" value="Guardar"></td>
        {/if}
        {if $vopc neq 1}   
        <td class="cnt"><a href="m_ipoderes_sol.php?vopc={$vopc}"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        {/if}
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
	</tr>
     </table>
    </form>
  </div>  
  </body>
</html>


