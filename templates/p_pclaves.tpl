<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <form name="forpatentes1" action="p_pclaves.php?vopc=1" method="post">
    <div align="center">

      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$solicitud1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forpatentes1.vsol2)" onchange="Rellena(document.forpatentes1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forpatentes1.submit)" onchange="Rellena(document.forpatentes1.vsol2,6)">
		
		&nbsp;&nbsp;<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td></tr>
  </form>				  
  </div>  
    </table>
    
  <H3> {$vnompat} <H3>
  <form name="forpatentes3" action="p_pclaves.php?vopc=5&vsol={$vsol}&v1=1" method="post">
    <div align="center">
      &nbsp; 
      <input type="hidden" name="vder" value='{$vder}'>
      <H3>{$lpodhab}</H3>
      <table>
      {if $vopc eq 4} 
      <tr><td class="izq-color">{$lcpoder}</td><td class="der-color">
              <input size="5" {$vmodo} type="text" name="vagen" size="5" maxlength="6"></td>
	  <td class="izq-color">{$lnpoder}</td><td class="der-color">
              <input size="30" type="text" name="vagenom" maxlength="40" onChange="javascript:this.value=this.value.toUpperCase();"></td>        
          <td class="cnt"><input type="image" name="accion" src="../imagenes/tick.png" value="Incluir">Incluir</td>
      </tr>
      {/if}
      {section name=cont loop=$vnumrows}
          <tr><td class="izq-color">{$lcpoder}</td><td class="der-color">{$arr_ph1[cont]}</td>
	      <td class="izq-color">{$lnpoder}</td><td class="der-color">{$arr_ph2[cont]}</td>
	      {if $vopc eq 4}
	      <td class="cnt"><input type="image" src="../imagenes/delete.gif" name="accion" value="{$arr_ph1[cont]}">Borrar</td>
	      {/if}
	      </tr>
      {/section} 
     </table>

    <table width="180">
      <tr>
        <!-- {if $vopc eq 1} -->
        <td class="cnt"><a href="p_pclaves.php?vopc=5&vsol={$vsol}&v1=0"><img src="../imagenes/boton_modificar_azul.png" border="0"></a></td>
        <!-- {/if} -->
        {if $vopc eq 4}
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" name="accion" value="Guardar"></td> 
        {/if} 
        <td class="cnt"><a href="p_pclaves.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      </tr>
    </table>

<!-- 	{if $vopc eq 1} 
	<td class="cnt"><input type="button" name="Motit" value="Modificar"
	    onclick="location.href='p_pclaves.php?vopc=4&vsol={$vsol}&v1=0'"></td>
	{/if} 
	
	{if $vopc eq 4} 
	 <td class="cnt"><input type="submit" name="accion" value="Guardar"> 
	{/if} 
	<td class="cnt"><input type="reset" name="Cancelar" value="Cancelar"
	    onclick="location.href='p_pclaves.php'"></td>
	<td class="cnt"><input type="button" name="Salir" value="Salir"
	    onclick="location.href='index1.php'"></td>	--> 

    </div>  
    </form>


  </body>
</html>


