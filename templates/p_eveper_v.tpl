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
<form name="forlotes" enctype="multipart/form-data" action="p_eveper.php?vopc=2"  method="POST" >
   <input type="hidden" name="vsola" value='{$vsola}'>
   <input type="hidden" name="vsolb" value='{$vsolb}'>
   <input type="hidden" name="usuario" value='{$usuario}'>
   <!-- <input type="hidden" name="MAX_FILE_SIZE" value="50000000">  -->
  
   <table>
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
    
    </table>

    <p></p>
   &nbsp; <p></p>
   Expedientes para Actualizar o Cargar:
   &nbsp;
    <table width="85%">
    <tr><td class="izq2-color" colspan="2">{$campo4}</td></tr>
    <tr><td>    
    <iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src="p_vexpedt.php?vcod={$nprensa}"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vsol1" size="3" maxlength="4" value='{$vsol1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol2)" 
		    onchange="Rellena(document.forlotes.vsol1,4);document.forlotes.vsol1.value=this.value;">-
	<input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" 
		    onchange="Rellena(document.forlotes.vsol2,6);document.forlotes.vsol2.value=this.value;">
      
        <input type="button" value="Buscar/Incluir"  name="vvienai" {$modo2} onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienai,document.forlotes.nprensa)">
        
        <input type="button" value="Buscar/Eliminar" name="vvienae" {$modo2} onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienae,document.forlotes.nprensa)">
    </td></tr>
    </table>
    
   &nbsp;
   <table width="225">
   <tr>
     <tr>
       <td class="cnt"><input type="image" src="../imagenes/next_f2.png">			Guardar 			</td> 
       <td class="cnt"><a href="p_eveper.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>			Cancelar 			</td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>			Salir 			</td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>
