<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" enctype="multipart/form-data" action="m_upimgbol.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='accion' value='{$accion}'>

  <table border="0" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
           <input tabindex="1" type="text" name="vsol" {$modo} size="10" maxlength="11" value='{$vsol}'>
      </td>
      <td class="der-color" rowspan="8" valign="top">
        <input name="ubicacion" type="file" size="23" >
        <!-- <br><a href='{$nameimage}' target='_blank'><img border='0' id="picture" src='{$nameimage}' width='270' height='270'></a></br>
        value='{$ubicacion}' onChange="javascript:document.formarcas1.picture.src = 'file:///'+ document.formarcas1.ubicacion.value;"  --> 
      </td>
    </tr>
    </table>
  &nbsp;
  &nbsp;

  <table width="255" >
  <tr>
    <td class="cnt"><input tabindex="3" type="image" src="../imagenes/save_f2.png" value="Guardar">	Guardar 	</td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
         <a href="m_upimgbol.php?vopc=4"><img tabindex="4" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3}
         <a href="m_upimgbol.php?vopc=3"><img tabindex="5" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="6" src="../imagenes/salir_f2.png" border="0"></a>	Salir 		</td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>