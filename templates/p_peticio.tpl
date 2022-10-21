<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <!-- <H3>{$titulo}</H3> -->
  
  <div align="center">

    <table>
 <!--cuando es en ventana nueva debe incluirse en la siguiente linea despues del "post": target="_blank" -->
        <form name="formarcas2" action="z_browse.php?vopc=0" method="post"> 
	<tr><td class="izq-color">{$lcodigo}</td>
	    <td class="der-color">{$vcodigo}	
	<tr><td class="izq-color">{$ltitular}</td>
	<td class="der-color"><input type="text" name="v2" size="60" maxlength="130" 
           onchange="this.value=this.value.toUpperCase()">
	<tr><td class="izq-color">{$lpalabra}</td>
	<td class="der-color"><input type="text" name="v3" size="8" maxlength="8" 
          onchange="this.value=this.value.toUpperCase()"  onkeyup="checkLength(event,this,5,document.formarcas2.v3)">


    </table>
     &nbsp;
     <input type='hidden' name='camposquery' value="{$camposquery}">
     <input type='hidden' name='camposname'  value="{$camposname}">
     <input type='hidden' name='tablas'      value="{$tablas}">
     <input type='hidden' name='condicion'   value="{$condicion}"> 
     <input type='hidden' name='orden'       value="{$orden}">
     <input type='hidden' name='modo'        value="{$modo}"> 
     <input type='hidden' name='modoabr'     value="{$modoabr}">
     <input type='hidden' name='vurl'        value="{$vurl}">
     <input type='hidden' name='tabladel'    value="{$tabladel}">
     <input type='hidden' name='condicion2'  value="{$condicion2}">
     <input type='hidden' name='tablains'    value="{$tablains}">
     <input type='hidden' name='camposins'   value="{$camposins}">
     <input type='hidden' name='valoresins'  value="{$valoresins}">
     <input type='hidden' name='vpalabra'  value="{$vpalabra}">
  
     <table width="210">
        <tr>
        <!-- <td class="cnt"><input type="submit" name="editar" value="Editar"></td> 
	     <td class="cnt"><input type="reset" name="cancelar" value="Cancelar"
	    onclick="location.href='m_peticio.php'"></td>
	     <td class="cnt"><input type="button" name="salir" value="Salir"
	    onclick="location.href='index1.php'"></td> -->

      <td class="cnt"><input type="image" src="../imagenes/edit_f2.png" value="Editar">  Editar  </td>
      <td class="cnt"><a href="p_peticio.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


