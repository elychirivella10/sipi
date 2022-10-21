<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <div align="center">
    <form name="formarcas1" action="m_reclasif.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color">
                <input type="text" name="vsol1" size="3" maxlength="4" 
	               value='{$solicitud1}' {$vmodo} 
                onKeyPress="return acceptChar(event,2, this)"  
                onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" 
                onchange="Rellena(document.formarcas1.vsol1,4)">-
                <input type="text" name="vsol2" size="6" maxlength="6" 
                       value='{$solicitud2}' {$vmodo} 
                onKeyPress="return acceptChar(event,2, this)" 
                onkeyup="checkLength(event,this,6,document.formarcas1.submit)" 
                onchange="Rellena(document.formarcas1.vsol2,6)">
            <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">
            </td></form>

            <form name="formarcas2" action="m_reclasif.php?vopc=2" method="post">
	    <td></td>
	    <td class="izq5-color">{$lregistro} </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='{$registro1}' {$vmodo} onKeyPress="return acceptChar(event,6, this)" 
                onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
            <input type="text" name="vreg2" size="6" maxlength="6" 
		value='{$registro2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)"  
                onkeyup="checkLength(event,this,6,document.formarcas2.submit)" 
                onchange="Rellena(document.formarcas2.vreg2,6)">
	    <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
      <tr><td class="izq-color">{$lfechasolic}</td>
	    <td class="der-color"><input size="10" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}></td>
	    {if $vmod eq "G" || $vmod eq "M"}
        <td class="der-color" rowspan="3" align="left" valign="top">
          <a href='{$nameimage}' target="_blank">
          <img border="-1" src={$nameimage} width="110">
        </td></tr>
      {/if}
    	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="70" type="text" name="vnom" value='{$nombre}' {$vmodo}></td>
	    </tr>
	<tr><td class="izq-color">{$lclase}</td>
	    <td class="der-color"><input size="1" type="text" name="vcla" value='{$clase}' {$vmodo}>
	                <input size="14" type="text" name="vindcla" value='{$ind_claseni}' {$vmodo}></td></tr>
      </table>
      </form>
      &nbsp; 
      <form name="formarcas3" action="m_reclasif.php?vopc=3" method="post" onsubmit='return pregunta();'>
      <table>			
        <!-- Clase Madre -->					   
	<tr>
	<td class="izq-color">{$lreclas}</td><td class="der-color"><input size="1" type="text" name="clas1"           onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas3.clas2)" onchange="valrangoclase(this,document.formarcas3.clas2,document.formarcas3.clas1,document.formarcas3.madre,'{$solicitud1}-{$solicitud2}')"></td>     
	<td class="izq-color">{$lregis1}</td><td class="der-color"><input size="6" type="text" name="regis1" value='{$registro1}{$registro2}' {$vmodo}"></td>
	<td class="izq-color">{$lmadre} </td><td class="der-color"><input size="9" type="text" name="madre"  {$vmodo}></td>
	</tr>
	<!-- Nuevas Clases Hijas-->
	<tr>
	<td class="der-color"></td><td class="der-color"><input size="1" type="text" name="clas2" 
	onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas3.clas3)" onchange="valrangoclase(this,document.formarcas3.clas3,document.formarcas3.clas1,document.formarcas3.hija1,'{$hija1}')"></td>
	<td class="der-color"></td><td class="der-color"><input size="6" type="text" name="regis2" {$vmodo}></td>
	<td class="der-color">{$lhija}</td><td class="der-color"><input size="9" type="text" name="hija1" {$vmodo}></td>
	</tr>
	<tr>
	<td class="der-color"></td><td class="der-color"><input size="1" type="text" name="clas3"
	onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas3.clas4)" onchange="valrangoclase(this,document.formarcas3.clas4,document.formarcas3.clas2,document.formarcas3.hija2,'{$hija2}')"></td> 
	<td class="der-color"></td><td class="der-color"><input size="6" type="text" name="regis3" {$vmodo}></td>
	<td class="der-color"></td><td class="der-color"><input size="9" type="text" name="hija2" {$vmodo}></td>
	</tr>
	<tr>
	<td class="der-color"></td><td class="der-color"><input size="1" type="text" name="clas4"
	onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas3.clas5)" onchange="valrangoclase(this,document.formarcas3.clas5,document.formarcas3.clas3,document.formarcas3.hija3,'{$hija3}')"></td>
	<td class="der-color"></td><td class="der-color"><input size="6" type="text" name="regis4" {$vmodo}></td>
	<td class="der-color"></td><td class="der-color"><input size="9" type="text" name="hija3" {$vmodo}></td>
	</tr>
	<tr>
	<td class="der-color"></td><td class="der-color"><input size="1" type="text" name="clas5"
	onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas3.clas6)" onchange="valrangoclase(this,document.formarcas3.clas6,document.formarcas3.clas4,document.formarcas3.hija4,'{$hija4}')"></td>
	<td class="der-color"></td><td class="der-color"><input size="6" type="text" name="regis5" {$vmodo}></td>
	<td class="der-color"></td><td class="der-color"><input size="9" type="text" name="hija4" {$vmodo}></td>
	</tr>
	<tr>
	<td class="der-color"></td><td class="der-color"><input size="1" type="text" name="clas6"
	onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas3.Guardar)" onchange="valrangoclase(this,document.formarcas3.Guardar,document.formarcas3.clas5,document.formarcas3.hija5,'{$hija5}')"></td>
	<td class="der-color"></td><td class="der-color"><input size="6" type="text" name="regis6" {$vmodo}></td>
	<td class="der-color"></td><td class="der-color"><input size="9" type="text" name="hija5" {$vmodo}></td>
	</tr>
     </table>
     &nbsp;
     <!-- </form>
     <form name="formarcas4" action="m_reclasif.php?vopc=3" method="post"> -->
           <input type="hidden" name="vsolh" value='{$solicitud1}-{$solicitud2}'> 
           <input type="hidden" name="vregh" value='{$registro1}{$registro2}'>
	   <input type="hidden" name="vindcla" value='{$ind_claseni}'>
	   <input type="hidden" name="vcla" value='{$clase}'>
           <input type="hidden" name="nderec" value='{$nderec}'>

     <table width="230">
      <tr> 
       <td class="cnt"><a href="m_cronolo.php?vsol={$solicitud1}-{$solicitud2}"><input type="image" src="../imagenes/boton_cronologia_azul.png"></a></td>
       <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
       <td class="cnt"><a href="m_reclasif.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


