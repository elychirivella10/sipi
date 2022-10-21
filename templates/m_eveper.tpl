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
<form name="forlotes" enctype="multipart/form-data" action="m_eveper.php?vopc=2"  method="POST" >
   <input type="hidden" name="vsola" value='{$vsola}'>
   <input type="hidden" name="vsolb" value='{$vsolb}'>
      <input type="hidden" name="evto22" value='22'>
      <input type="hidden" name="evto32" value='32'>
            <input type="hidden" name="evto33" value='33'>
   <input type="hidden" name="role" value='{$role}'>
   <input type="hidden" name="usuario" value='{$usuario}'>
   <!-- <input type="hidden" name="MAX_FILE_SIZE" value="50000000">  -->
  
   <table cellspacing="1" border="1">
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
    <td class="izq4-color"> <a href="http://www.ciudadccs.org.ve/" target="_blank">Ver Prensa Ciudad Caracas</a></td>  
   </tr>  
   </table>

   &nbsp; <p></p>
   <font class='nota6'><b>Expedientes para Actualizar a Estatus 5, Aplicar Evento 22 (Recepción de Publicación en Prensa):</b></font>
   &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$campo4}</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:99%;height:90px;background-color: WHITE;' src="m_vexpedt.php?vcod={$nprensa}&evto=22"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vsol1" size="3" maxlength="4" value='{$vsol1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol2)" 
		    onchange="Rellena(document.forlotes.vsol1,4);document.forlotes.vsol1.value=this.value;">-
	<input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" 
		    onchange="Rellena(document.forlotes.vsol2,6);document.forlotes.vsol2.value=this.value;">
      
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai1" {$modo2} onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienai1,document.forlotes.nprensa,document.forlotes.evto22)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae1" {$modo2} onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienae1,document.forlotes.nprensa,document.forlotes.evto22)">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar" onclick="document.forlotes.vsol1.value='';document.forlotes.vsol2.value='';"> 
    </td></tr>
    </table>
    
   &nbsp; <p></p>
   <font class='nota6'><b>Expedientes para Actualizar a Estatus 23, Aplicar Evento 32 (Prioridad Extinguida, Publicación en Prensa Extemporanea):</b></font>
   &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$campo4}</td></tr>
    <tr><td>    
    <iframe id='top32' style='width:99%;height:90px;background-color: WHITE;' src="m_vexpedt.php?vcod={$nprensa}&evto=32"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vsol3" size="3" maxlength="4" value='{$vsol3}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol3)" 
		    onchange="Rellena(document.forlotes.vsol3,4);document.forlotes.vsol3.value=this.value;">-
	<input type="text" name="vsol4" size="6" maxlength="6" value='{$vsol4}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol4)" 
		    onchange="Rellena(document.forlotes.vsol4,6);document.forlotes.vsol4.value=this.value;">
      
        <input type="button" class="boton_blue" value="Buscar/Incluir_32"  name="vvienai2" {$modo2} onclick="buscarprensa(document.forlotes.vsol3,document.forlotes.vsol4,document.forlotes.vvienai2,document.forlotes.nprensa,document.forlotes.evto32)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar_32" name="vvienae2" {$modo2} onclick="buscarprensa(document.forlotes.vsol3,document.forlotes.vsol4,document.forlotes.vvienae2,document.forlotes.nprensa,document.forlotes.evto32)">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar32" onclick="document.forlotes.vsol3.value='';document.forlotes.vsol4.value='';"> 
    </td></tr>
    </table>
    
   &nbsp; <p></p>
   <font class='nota6'><b>Expedientes para Actualizar a Estatus 24, Aplicar Evento 33 (Prioridad Extinguida, Publicación en Prensa Defectuosa):</b></font>
   &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$campo4}</td></tr>
    <tr><td>    
    <iframe id='top33' style='width:99%;height:90px;background-color: WHITE;' src="m_vexpedt.php?vcod={$nprensa}&evto=33""></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vsol5" size="3" maxlength="4" value='{$vsol5}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol5)" 
		    onchange="Rellena(document.forlotes.vsol5,4);document.forlotes.vsol5.value=this.value;">-
	<input type="text" name="vsol6" size="6" maxlength="6" value='{$vsol6}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol6)" 
		    onchange="Rellena(document.forlotes.vsol6,6);document.forlotes.vsol6.value=this.value;">
      
        <input type="button" class="boton_blue" value="Buscar/Incluir_33"  name="vvienai3" {$modo2} onclick="buscarprensa(document.forlotes.vsol5,document.forlotes.vsol6,document.forlotes.vvienai3,document.forlotes.nprensa,document.forlotes.evto33)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar_33" name="vvienae3" {$modo2} onclick="buscarprensa(document.forlotes.vsol5,document.forlotes.vsol6,document.forlotes.vvienae3,document.forlotes.nprensa,document.forlotes.evto33)">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar33" onclick="document.forlotes.vsol5.value='';document.forlotes.vsol6.value='';"> 
    </td></tr>
    </table> 
    
   &nbsp;
   <table width="250">
   <tr>
     <tr>
       <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png"></td> 
       <td class="cnt"><a href="m_eveper.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
       <td class="cnt"> <a href="documentos/ayuda_prensa.pdf" target="_blank"><img src="../imagenes/boton_ayuda_azul.png" border="0"> </a></td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>
