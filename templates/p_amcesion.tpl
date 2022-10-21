<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <!-- <H3>{$subtitulo}</H3> -->
  
  <div align="center">
  <form name="formarcas1" action="p_amcesion.php?vopc=1" method="post">
     <table>
     <tr><td class="izq5-color">{$lsolicitud}</td>
         <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	     value='{$solicitud1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" 
             onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" 
             onchange="Rellena(document.formarcas1.vsol1,4)">-
	                       <input type="text" name="vsol2" size="6" maxlength="6" 
	     value='{$solicitud2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" 
             onkeyup="checkLength(event,this,6,document.formarcas1.submit)" 
             onchange="Rellena(document.formarcas1.vsol2,6)">
	 <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" 
             height="24" value="Buscar">  Buscar  </td>
  </form>				  
  <form name="formarcas2" action="p_amcesion.php?vopc=2" method="post">
         <td>{$espacios}</td>
	 <td class="izq5-color">{$lregistro} </td>
	 <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	     value='{$registro1}' {$vmodo} onKeyPress="return acceptChar(event,6, this)" 
             onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
	     onChange="this.value=this.value.toUpperCase()">-
		               <input type="text" name="vreg2" size="6" maxlength="6" 
	     value='{$registro2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" 
             onkeyup="checkLength(event,this,6,document.formarcas2.submit)" 
             onchange="Rellena(document.formarcas2.vreg2,6)">
	 <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" 
             height="24" value="Buscar">  Buscar  </td>
     </tr>
     </table>  
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color">{$lfecsol}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lfecreg}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='{$vfecreg}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lfecven}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='{$vfecven}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="73" type="text" name="vnom" value='{$nombre}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lclase}</td>
	    <td class="der-color"><input size="2" type="text" name="vest" value='{$vest}' {$vmodo}>
	                <input size="67" type="text" name="vdesest" value='{$vdesest}' {$vmodo}></td></tr>

	<tr><td class="izq-color">{$ltrage}</td>
	    <td class="der-color"><input size="73" type="text" name="vtrage" 
	    value="{$vtra|strip}{$vcodage}.{$vnomage}" {$vmodo}></td></tr>    
     </table>		
     <br />
     <!-- Titulares Actuales -->
     <table width="90%"> 
     <tr><td class="izq2-color">{$ltitular}</td></tr>
     <tr><td class="izq2-color">
     <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
             src='exampletit.php?psol={$vsol}&ptip=I&pder={$vderh}'></iframe> 
     </td></tr>  
     </table>		
     </form>
     <form name="formarcas3" action="p_amcesion.php?vopc=3" method="post" onsubmit='return pregunta();'>
     <input type="hidden" name="vest" value='{$vest}'>
     <input type="hidden" name="vcodtit" value='{$vcodtit}'>
     <input type="hidden" name="vnomtit" value='{$vnomtit}'>
     <input type="hidden" name="vnactit" value='{$vnactit}'>
     <input type="hidden" name="vdomtit" value='{$vdomtit}'>
     <input type="hidden" name="vcodage" value='{$vcodage}'>
     <input type="hidden" name="vnomage" value='{$vnomage}'>
     <input type="hidden" name="vtra" value='{$vtra}'>
     <table width="90%">
        <tr><td width="25%" class="izq-color">{$lfechaevento}</td>
	    <td class="der-color"><input size="9" type="text" name="vfevh"  onkeyup="checkLength(event,this,10,document.formarcas3.vdoc)"
	    onchange="valFecha(this,document.formarcas3.vdoc)"><td></tr>  
	    <tr><td class="izq-color">{$ldocumento}</td>
	    <td class="der-color"><input size="7" type="text" name="vdoc" value='{$vdoc}' maxlength="9" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,7,document.formarcas3.vtipo)"></td></tr>
        <tr><td class="izq-color">{$ltipo}</td>
	    <td class="der-color">
	        {html_radios name="vtipo" values=$vtipo_id selected=$vtipo output=$vtipo_de separator=""}
	</td></tr>
        </table>
     <!-- Titulares Finales--> 
     <table width="90%">
     <tr><td class="izq2-color">{$ltitular2}</td></tr>
     <tr><td class="izq2-color">
     <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
             src='exampletit.php?psol={$vsol}&ptip=P'></iframe> 
     </td></tr>  
     <table width="90%">	
     <tr><td class="der-color">
     <input type="text" name="vtitut" {$modo} size="35" 
             onChange="javascript:this.value=this.value.toUpperCase();">
     <input type="button" value="Buscar/Incluir" class="boton_blue" {$modo2} name="vtitui" 
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
     <input type="button" value="Buscar/Eliminar" class="boton_blue" {$modo2} name="vtitue"          
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
     <!--  -->
     </td></tr>	
     </table>
        <table width="90%">
	<tr><td class="izq-color">{$lagenew}</td>
	    <td class="der-color"><input size="6" type="text" name="vcodagen" maxlength="6" onchange="valagente(document.formarcas3.vcodagen,document.formarcas3.vnomagen)">	    
	    <select size=1 name="vnomagen" onchange= "this.form.vcodagen.value=this.options[this.selectedIndex].value">
	        {html_options values=$vcodagenew output=$vnomagenew}
	    </select></td>
	    </tr>        
        <tr><td class="izq-color">{$ltranew}</td>
	    <td class="der-color"><input size="73" type="text" name="vtranew"  onchange="this.value=this.value.toUpperCase()"></td></tr>      
	<tr><td class="izq-color">{$lcomenta}</td>
	    <td class="der-color"><textarea rows="2" name="vcomenta" cols="73" onchange="this.value=this.value.toUpperCase()"></textarea></td></tr>
      </table>
     &nbsp;
           <input type="hidden" name="vsolh" value='{$solicitud1}-{$solicitud2}'>
           <input type="hidden" name="vderh" value='{$vderh}'>  
           <input type="hidden" name="vregh" value='{$registro1}{$registro2}'>

     <table width="225">
     <tr>
<!--        <td class="cnt"><a href="m_rptcronol.php?vsol1={$solicitud1}&vsol2={$solicitud2}&vreg1={$registro1}&vreg2={$registro2}"><input type="image" src="../imagenes/folder_f2.png"></a>Cronologia</td> -->
     <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar"> Guardar </td> 
     <td class="cnt"><a href="p_amcesion.php"><img src="../imagenes/cancel_f2.png" border="0">
     </a>  Cancelar  </td>
     <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0">
     </a> Salir </td>
     </tr>
     </table>

    </form>
  </div>  
  </body>
</html>


