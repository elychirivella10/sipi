<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
  
 <div align="center">
 <br>
 <form name="formarcas2" action="z_bolvenc.php?vopc=1" method="post">
   <table>
	     <tr>
	       <td class="izq-color">{$Campo1}</td>
	       <td class="der-color">
	          <input type="text" name="vbol" size="2" maxlength="3" value='{$vbol}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vfpub)">
           <select size="1" name="aplica" >
             {html_options values=$apli_inf selected=$aplica output=$apli_def}
           </select> 
	          
	       </td>
	     </tr>
	     <tr>
	       <td class="izq-color">{$Campo5}</td>
	       <td class="der-color">
	          <input size="9" maxlength="10" type="text" name="vfpub" value='{$vfpub}'  onkeyup="checkLength(event,this,10,document.formarcas2.vfvig)" >
             <a href="javascript:showCal('Calendar86');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       </td>
	     </tr>
	     <tr>
	       <td class="izq-color">{$Campo6}</td>
	       <td class="der-color">
	          <input size="9" maxlength="10" type="text" name="vfvig" value='{$vfvig}'  onkeyup="checkLength(event,this,10,document.formarcas2.vfven15)" >
             <a href="javascript:showCal('Calendar87');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       </td>
	     </tr>
	     <tr>
	       <td class="izq-color">{$Campo2}</td>
	       <td class="der-color">
	          <input size="9" maxlength="10" type="text" name="vfven15" value='{$vfven15}'  onkeyup="checkLength(event,this,10,document.formarcas2.vfven30)" >
             <a href="javascript:showCal('Calendar88');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       </td>
	     </tr>
        <tr>
          <td class="izq-color">{$Campo3}</td>
	       <td class="der-color">
	         <input size="9" maxlength="10" type="text" name="vfven30" value='{$vfven30}'  onkeyup="checkLength(event,this,10,document.formarcas2.vfven2m)" onchange="valFecha(this,document.formarcas2.vfven2m)">
             <a href="javascript:showCal('Calendar89');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       </td>
	     </tr>		
	     <tr>
	       <td class="izq-color">{$Campo4}</td>
	       <td class="der-color">
	         <input size="9" maxlength="10" type="text" name="vfven2m" value='{$vfven2m}'  onkeyup="checkLength(event,this,10,document.formarcas2.grabar)" onchange="valFecha(this,document.formarcas2.otro)">
             <a href="javascript:showCal('Calendar90');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       </td>
	     </tr>
    </table>
   <br>
    <table width="225">
      <tr>
       <td class="cnt"><input type="image" name="grabar" src="../imagenes/boton_procesar_azul.png" value="Guardar"></td> 
       <td class="cnt"><a href="z_bolvenc.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      </tr>
    </table>
   <br><br><br><br><br><br><br>
 </form>
 </div>  
</body>
</html>


