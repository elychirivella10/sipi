<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forestanu" action="m_est_exaxmes.php?vopc=1" method="POST">
  <div align="center">
 <br>
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
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <select size=1 name="modalidad">
          {html_options values=$mod_val selected=1 output=$mod_des}
        </select></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <select size=1 name="indclase">
          {html_options values=$ind_val selected=1 output=$ind_des}
        </select></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <select size=1 name="clase">
          {html_options values=$cla_val selected=99 output=$cla_des}
        </select></td> 
    </tr>
  </table></center>
    
	<br>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_graficar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_est_exaxmes.php?vopc=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

  </div>  
</form>
<br><br><br><br>
</body>
</html>
