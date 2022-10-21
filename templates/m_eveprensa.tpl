<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">
  
<div align="center">


<form name="forlotes" enctype="multipart/form-data" action="m_eveprensa.php?vopc=2"  method="POST" >
   <input type="hidden" name="vsola" value='{$vsola}'>
   <input type="hidden" name="vsolb" value='{$vsolb}'>
   <input type="hidden" name="role" value='{$role}'>
   <input type="hidden" name="usuario" value='{$usuario}'>
   <input type="hidden" name="pagoreg" value='{$pagoreg}'>
   <input type="hidden" name="factotal" value='{$factotal}'>
   <input type="hidden" name="email" value='{$email}'>

        
   &nbsp;
   <font class='nota7'><b>DATOS DE LA FACTURA, SOLICITANTE, BOLETIN Y CANTIDAD(ES):</b></font>
   <br>   
   &nbsp;
   <table cellspacing="1" border="1">
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color" >
    	     <input type="text" name="factura" size="6" maxlength="6" value='{$factura}' readonly >
      </td>
    </tr>
     <tr>
       <td class="izq-color">{$campo2}</td>
       <td class="der7-color" >
	      <input type="text" name="fechafac" size="7" maxlength="10" value='{$fechafac|date_format:"%d/%m/%G"}' readonly="readonly">  
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo3}</td>
       <td class="der7-color" >
	      <input type="text" name="solicitante" size="70" maxlength="80" value='{$solicitante}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo4}</td>
       <td class="der7-color" >
	      <input type="text" name="cisolicita" size="8" maxlength="10" value='{$cisolicita}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo5}</td>
       <td class="der7-color" >
	      <input type="text" name="domicilio" size="70" maxlength="90" value='{$domicilio}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo6}</td>
       <td class="der7-color" >
	      <input type="text" name="telefono" size="10" maxlength="10" value='{$telefono}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo15}</td>
       <td class="der7-color" >
	      <input type="text" name="email" size="60" maxlength="70" value='{$email}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo7}</td>
       <td class="der7-color" >
	      <input type="text" name="mcantidad" size="2" maxlength="3" value='{$mcantidad}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo11}</td>
       <td class="der7-color" >
	      <input type="text" name="pcantidad" size="2" maxlength="3" value='{$pcantidad}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo12}</td>
       <td class="der7-color" >
	      <input type="text" name="total" size="2" maxlength="3" value='{$total}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo8}</td>
       <td class="der7-color" >
	      <input type="text" name="boletin" {$modo} size="2" maxlength="3" value='{$boletin}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo14}</td>
       <td class="der7-color" >
	      <input type="text" name="factotal" size="5" maxlength="5" value='{$factotal}' readonly="readonly">
       </td>
     </tr>
    </table>

    <p></p>
    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq2-color" colspan="2">{$campo9}</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:99%;height:90px;background-color: WHITE;' src="m_verprensa.php?vcod={$factura}&vbol={$boletin}"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <!-- <input type="text" name="nsol1" size="3" maxlength="4" value='{$nsol1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol2)" onchange="Rellena(document.forlotes.vsol1,4);document.forlotes.vsol1.value=this.value;"> -->
        <select size='1' name='vsol1' onchange="document.forlotes.vsol1.value=this.value;">
          {html_options values=$arrayannos selected=$vsol1 output=$arraynameano}
        </select> -
	<input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" onchange="Rellena(document.forlotes.vsol2,6);document.forlotes.vsol2.value=this.value;">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai1" {$modo1} onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienai1,document.forlotes.factura,document.forlotes.boletin,document.forlotes.mcantidad)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae1" {$modo1} onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienae1,document.forlotes.factura,document.forlotes.boletin,document.forlotes.mcantidad)">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar1" onclick="document.forlotes.vsol1.value='';document.forlotes.vsol2.value='';"> 
    </td></tr>
    </table>

    <p></p>
    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq2-color" colspan="2">{$campo10}</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:99%;height:90px;background-color: WHITE;' src="p_verprensa.php?vcod={$factura}&vbol={$boletin}"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <!-- <input type="text" name="vsol3" size="3" maxlength="4" value='{$vsol3}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol4)" onchange="Rellena(document.forlotes.vsol3,4);document.forlotes.vsol3.value=this.value;"> -->
        <select size='1' name='vsol3' onchange="document.forlotes.vsol3.value=this.value;">
          {html_options values=$arrayannos selected=$vsol3 output=$arraynameano}
        </select> -
	<input type="text" name="vsol4" size="6" maxlength="6" value='{$vsol4}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" onchange="Rellena(document.forlotes.vsol4,6);document.forlotes.vsol4.value=this.value;">
	&nbsp;{$campo13}&nbsp;
        <select size="1" name="npublica" class="required">
           {html_options values=$publica_id selected=$npublica output=$publica_de}
        </select>
	&nbsp;&nbsp;
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai2" {$modo2} onclick="buscarprensap(document.forlotes.vsol3,document.forlotes.vsol4,document.forlotes.vvienai2,document.forlotes.factura,document.forlotes.boletin,document.forlotes.pcantidad,document.forlotes.npublica)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae2" {$modo2} onclick="buscarprensap(document.forlotes.vsol3,document.forlotes.vsol4,document.forlotes.vvienae2,document.forlotes.factura,document.forlotes.boletin,document.forlotes.pcantidad,document.forlotes.npublica)">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar2" onclick="document.forlotes.vsol3.value='';document.forlotes.vsol4.value='';"> 
    </td></tr>
    </table>
    
   <p></p>
   &nbsp;
   <table width="210">
   <tr>
     <tr>
       <td class="cnt"><input type="image" src="../imagenes/boton_guardar_azul.png"></td> 
       <td class="cnt"><a href="m_ingfacpren.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>
