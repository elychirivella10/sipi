<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forestanu" action="p_est_prexmes.php?vopc=1" method="POST">
  <div align="center">
 <br><br>
 <table>
  <tr>
      <td class="izq-color">{$campo0}</td>
      <td class="der-color"><input type="text" name="ano1" align="right" size="3" maxlength="4" 
               onKeyPress="return acceptChar(event,2, this)" 
               onkeyup="checkLength(event,this,4,document.forestanu.ano2)">
      </td>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color"><input type="text" name="ano2" align="right" size="3" maxlength="4" 
           onKeyPress="return acceptChar(event,2, this)" 
           onkeyup="checkLength(event,this,4,document.forestanu.estatus)">
      </td>
  </tr><tr>
     <td colspan=4>(Dejar a&ntilde;os en blanco para busqueda global)</td>
  </tr>
</table>
&nbsp; 
<table>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <select size=1 name="estatus">
          {html_options values=$est_val selected=' ' output=$est_des}
        </select></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size=1 name="pais">
          {html_options values=$pai_val selected=1 output=$pai_des}
        </select></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        <select size=1 name="tipomarca">
          {html_options values=$tip_val selected=1 output=$tip_des}
        </select></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color"><input type="text" name="clase" align="right" size="15" maxlength="15" value="" onKeyup="this.value=this.value.toUpperCase();">(Colocar c&oacute;digo completo o parcial...)</td> 
    </tr>
  </table></center>
    
	<br>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_graficar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_est_prexmes.php?vopc=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
</form>

</body>
</html>
