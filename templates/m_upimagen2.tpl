<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
<br>
<form name="formarcas1" enctype="multipart/form-data" action="m_upimagen2.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value={$accion}>

  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
           <input tabindex="1" type="text" name="vsol1" size="4" maxlength="4" value='{$vsol1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
           <input tabindex="2" type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      </td>
      <td class="der-color" rowspan="8" valign="top">
        <input tabindex="5" name="ubicacion" type="file" value='{$ubicacion}' size="23" onChange="javascript:document.formarcas1.picture.src = 'file:///'+ document.formarcas1.ubicacion.value;">
        <br><a href='{$nameimage}' target='_blank'><img border='0' id="picture" src='{$nameimage}' width='270' height='270'></a></br>
      </td>
    </tr>
    </table>
  &nbsp;
  &nbsp;
<!--
  <table width="255" >
  <tr>
    <td class="cnt"><input tabindex="3" type="image" src="../imagenes/database_save.png" value="Guardar">	Guardar 	</td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
         <a href="m_upimagen2.php?vopc=4"><img tabindex="4" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3}
         <a href="m_upimagen2.php?vopc=3"><img tabindex="5" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="6" src="../imagenes/salir_f2.png" border="0"></a>	Salir 		</td>
  </tr>
  </table>

  &nbsp; -->
  <table width="200">
  <tr>
    <td class="cnt"><input tabindex="3" type="image" name='botonname' value="Guardar" src="../imagenes/boton_guardar_azul.png"></td>
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
        <a href="m_upimagen2.php?vopc=4"><img tabindex="4" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      {/if}    
      {if $vopc eq 3}
        <a href="m_upimagen2.php?vopc=3"><img tabindex="5" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      {/if}    
    </td>
    <td class="cnt"><a href="../index1.php"><img tabindex="6" src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>
