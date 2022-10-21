<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/wforms.js"></script>  
  <script language="javascript" src="../libjs/r_funciones.js"></script>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
<form name="formarcas2" enctype="multipart/form-data" action="m_abfontxt2.php" method="POST">
  <br><br>
  <table>
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name="pedido1" size="6" maxlength="6"> y 
        <input type="text" name="pedido2" size="6" maxlength="6">
        </td>	
    </tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color">
         <input tabindex="3" type="text" name="fecharec" {$modo} value='{$fecharec}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.prioridad)" onchange="valFecha(this,document.formarcas2.prioridad)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar53');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp;         
      </td>	
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name="desdec" value='{$desdec}' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     hasta <input type="text" name="hastac" value='{$hastac}' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="11" maxlength="12">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color" ><select size='1' name='vplus'>
                             {html_options values=$arrayplus selected=$vplus output=$arraydesplus}
                             </select>{$campo72}
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color">    
         <select size="1" name="options">
          {html_options values=$vcodsede selected=$vsede output=$vnomsede|truncate:15}
         </select>                
        </td>	
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <select size="1" name="procesada">
          {html_options values=$arraytipop selected=$procesada output=$arraydescp}
        </select>
      </td>
    </tr>
   
  </tr>
  </table>
  &nbsp;
  &nbsp;
  <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png"></td>
      <td class="cnt"><a href="m_abfontxt.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="m_panelfon.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
 </form>
</div>
</body>
</html>
