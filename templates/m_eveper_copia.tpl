<html>
<head>
   <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
  
<div align="center">
<form name="forlotes" enctype="multipart/form-data" action="m_eveper.php?vopc=2"  method="POST" >
   <input type="hidden" name="vsola" value='{$vsola}'>
   <input type="hidden" name="vsolb" value='{$vsolb}'>
   <input type="hidden" name="role" value='{$role}'>
   <input type="hidden" name="usuario" value='{$usuario}'>
  
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
        <input type='text' name='fechaper' size="10" maxlength="10" value='{$fechaper}'  onChange="valFecha(document.forlotes.fechaper)">
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
    <iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src="m_vexpedt.php?vcod={$nprensa}"></iframe> 
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
       <td class="cnt"><a href="m_eveper.php"><img src="../imagenes/cancel_f2.png" border="0"></a>			Cancelar 			</td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>			Salir 			</td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>
