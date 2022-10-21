<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<br>
<div align="center">

<form name="frmstatus1" action="a_tablgene.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name='estatus' size="6" maxlength="6" value='{$estatus}' {$vmodo} 
               onKeyup="this.value=this.value.toUpperCase();">&nbsp;
      </td>	
      <td class="cnt">
        {if $vopc eq 4}
                <input type ='hidden' name='accion' value='Modificacion'>
	        <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">
        {/if}
        {if $vopc eq 3}
                <input type ='hidden' name='accion' value='Ingreso'> 
	        <input type='image' src="../imagenes/boton_nuevo_azul.png" value="Nuevo">
        {/if} 
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="frmstatus2" action="a_tablgene.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='estatus' value={$estatus}>

  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name='nombre' value='{$nombre}' {$modo} size="50" maxlength="50" 
               onKeyPress="return acceptChar(event,4, this)" 
               onkeyup="this.value=this.value.toUpperCase()" >
      </td>
    </tr>
  </tr>
  </table></center>
  <br>
  <table width="200" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      {if ($vopc eq 1 && $accion eq 2) || $vopc eq 4}
        <a href="a_tablgene.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      {/if}    
      {if ($vopc eq 1 && $accion eq 1) || $vopc eq 3}
        <a href="a_tablgene.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      {/if}    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>
<br><br><br><br><br><br><br>
</form>
</div>  
</body>
</html>
