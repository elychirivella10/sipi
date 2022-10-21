<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="p_ofidevfondo.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='vsol' value={$vsol}>
  <input type='hidden' name='accion' value={$accion}>


  <table>
     <tr>
      <td class="izq5-color">Solicitud No.:</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='{$vsol2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      &nbsp;	 	     
      </td>	
      <td class="cnt">	 	
	 	  &nbsp;&nbsp;<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>

  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="p_ofidevfondo.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='vsol1' value={$vsol1}>
  <input type='hidden' name='vsol2' value={$vsol2}>
  <input type='hidden' name='modo' value={$vmodo}>
  <input type='hidden' name='varsol' value={$varsol}>
  <input type='hidden' name='nameimage' value={$nameimage}>
  <input type='hidden' name='vder' value='{$vder}'>  

  <table cellspacing="1" border="1">
    <tr>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" {$modo} value='{$fecha_solic}' size="10" align="right">
      </td>
      <td class="der-color" rowspan="6" valign="top">
        <input name="ubicacion" type="file" disabled value='{$ubicacion}' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='{$nameimage}' id="picture" width="270" height="270" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" {$modo1} onchange="habilema(document.formarcas2.tipo_marca,document.formarcas2.vsol3,document.formarcas2.vsol4,document.formarcas2.vreg1d,document.formarcas2.vreg2d)">
          {html_options values=$arraytipom selected=$tipo_marca output=$arraynotip}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	     <textarea rows="3" name="nombre" {$modo} cols="57" maxlength="500" onchange="this.value=this.value.toUpperCase()">{$nombre}</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
	     <textarea rows="3" name="tramitante" {$modo} cols="57" maxlength="500" onchange="this.value=this.value.toUpperCase()">{$tramitante}</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
	      <textarea rows="2" name="estatus" {$modo} cols="57" maxlength="500" >{$estatus}</textarea>
      </td>
    </tr>
  </table>

    <p align="center"><b><font size="4" face="Tahoma">Resumen</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
    <tr>
      <td class="der-color">
        <textarea id="vresumen" name="vresumen" {$modo} rows="10" cols="116"  onchange="this.value=this.value.toUpperCase()">{$vresumen}</textarea>
      </td>
    </tr>
    </table>

    <p align="center"><b><font size="4" face="Tahoma">Inventor(es)</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
      <tr>
        <td class="columna-titulo">Nombre</b></font></td>
        <td class="columna-titulo">Domicilio</td>
      </tr>
      <tr>
        {section name = inventor loop = $custidinv}
        <tr>
          <td >{$custidinv[inventor][0]}</td>
          <td >{$custidinv[inventor][1]}</td>
        </tr>
        {/section}
      </tr>
    </table>

    <p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
      <tr>
        <td class="columna-titulo">C&oacute;digo</td>
        <td class="columna-titulo">Nombre</b></font></td>
        <td class="columna-titulo">Domicilio</td>
        <td class="columna-titulo">Pa&iacute;s de Domicilio</td>
        <td class="columna-titulo">Nacionalidad</td>
        <td class="columna-titulo">Identificaci&oacute;n</td>
      </tr>
      <tr>
        {section name = titular loop = $custidtit}
        <tr>
          <td >{$custidtit[titular][0]}</td>
          <td >{$custidtit[titular][1]}</td>
          <td >{$custidtit[titular][2]}</td>
          <td >{$custidtit[titular][3]}</td>
          <td >{$custidtit[titular][4]}</td>
          <td >{$custidtit[titular][5]}</td>
        </tr>
        {/section}
      </tr>
    </table>

    <p align="center"><b><font size="4" face="Tahoma">Cronolog&iacute;a de Eventos</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
      <tr>
        <td class="columna-titulo">Fecha Evento</td>
        <td class="columna-titulo">Evento</b></font></td>
        <td class="columna-titulo">Descripci&oacute;n</td>
        <td class="columna-titulo">Fecha de Transacci&oacute;n</td>
        <td class="columna-titulo">Nro Documento</td>
        <td class="columna-titulo">Comentario</td>
      </tr>
      <tr>
        {section name = customer loop = $custid}
        <tr>
          <td >{$custid[customer][0]}</td>
          <td >{$custid[customer][1]}</td>
          <td >{$custid[customer][2]}</td>
          <td >{$custid[customer][3]}</td>
          <td >{$custid[customer][4]}</td>
          <td >{$custid[customer][5]}</td>
        </tr>
        {/section}
      </tr>
    </table>

    <p align="center"><b><font size="4" face="Tahoma">Juicio del Evaluador:</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
    <tr>
      <td class="der-color">
        <textarea id="motivo" name="motivo" {$modo3} rows="15" cols="116">{$motivo}</textarea>
      </td>
    </tr>
    </table>
   <br>
   <table>
   <tr>
     <tr>
       <td class="izq-color" >{$campo1}</td>
       <td class="der-color">
         <input type="text" name="boletin" size="3" maxlength="3" value='{$boletin}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forcaduca.actualizar)">
       </td>
     </tr>   
   </table></center>
   <br><br><br>
  <table width="200">
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      {if $vopc eq 1}
          <a href="p_ofidevfondo.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      {/if}    
      {if $vopc eq 3}
          <a href="p_ofidevfondo.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a> 
      {/if}    
    </td>      
    <td class="cnt"><a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>
  
</form>
</div>  

</body>
</html>
