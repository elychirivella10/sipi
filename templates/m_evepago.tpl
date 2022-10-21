<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
  
<div align="center">


<form name="forlotes" enctype="multipart/form-data" action="m_evepago.php?vopc=2"  method="POST" >
   <input type="hidden" name="vsola" value='{$vsola}'>
   <input type="hidden" name="vsolb" value='{$vsolb}'>
   <input type="hidden" name="role" value='{$role}'>
   <input type="hidden" name="usuario" value='{$usuario}'>
   <input type="hidden" name="pagoreg" value='{$pagoreg}'>
   <input type="hidden" name="factotal" value='{$factotal}'>
   <input type="hidden" name="totalpag" value='{$totalpag}'>
   <input type="hidden" name="codpago" value='{$codpago}'>
        
 <!--  <table cellspacing="1" border="1">
   <tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color" >
    	     <input type="text" name="nprensa" size="5" maxlength="5" value='{$nprensa}' readonly >
      </td>
    </tr>

     <tr>
      <td class="izq-color">{$campo1}</td>
	   <td class="der-color">
               <select size='1' name='tipo'>
                   {html_options values=$arraytipo selected=$tipo output=$arraytipo}
               </select>

       <td>
      </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
       
         <input type="text" name="fechaper" {$modo2} value='{$fechaper}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forlotes.vpag)" onchange="valFecha(this,document.forlotes.vpag)" >
&nbsp;
         <a href="javascript:showCal('Calendar65');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         
      </td>
    </tr>
    
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color" >
    	     <input type="text" name="vpag" size="5" maxlength="5" value='{$vpag}' >
      </td>
    </tr>
    
     <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color" >
        <input name="ubicacion" type="file" {$modo2} value='{$ubicacion}' size="25" onChange="javascript:document.forlotes.picture.src = 'file:///'+ document.forlotes.ubicacion.value;">
      </td>
    </tr>   
    
    </table> --> 

   &nbsp;
   <font class='nota7'><b>DATOS DE LA FACTURA, SOLICITANTE Y BOLETIN:</b></font>
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
       <td class="izq-color">{$campo7}</td>
       <td class="der7-color" >
	      <input type="text" name="cantidad" size="2" maxlength="3" value='{$cantidad}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo8}</td>
       <td class="der7-color" >
	      <input type="text" name="boletin" {$modo} size="2" maxlength="3" value='{$boletin}' readonly="readonly">
       </td>
     </tr>
    </table>

    <p></p>
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$campo9}</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:960px;height:90px;background-color: WHITE;' src="m_verpagos.php?vcod={$factura}&vbol={$boletin}"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vsol1" size="3" maxlength="4" value='{$vsol1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol2)" 
		    onchange="Rellena(document.forlotes.vsol1,4);document.forlotes.vsol1.value=this.value;">-
	<input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" 
		    onchange="Rellena(document.forlotes.vsol2,6);document.forlotes.vsol2.value=this.value;">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai1" {$modo2} onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienai1,document.forlotes.factura,document.forlotes.boletin,document.forlotes.cantidad)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae1" {$modo2} onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienae1,document.forlotes.factura,document.forlotes.boletin,document.forlotes.cantidad)">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar" onclick="document.forlotes.vsol1.value='';document.forlotes.vsol2.value='';"> 
    </td></tr>
    </table>
    
   <p></p>
   &nbsp;
   <table width="210">
   <tr>
     <tr>
       <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png"></td> 
       <td class="cnt"><a href="m_ingfacbol.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>
