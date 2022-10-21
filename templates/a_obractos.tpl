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

{if $vopc eq 3}
  <form name="foractos" id="foractos" action="a_obractos.php?vopc=4" method="post">
{/if}
{if $vopc eq 5}
  <form name="foractos" id="foractos" action="a_obractos.php?vopc=6" method="post">
{/if}
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <table>
  <tr> 
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="6" maxlength="6" value='{$vsol1}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,7,document.forautor.fecha_solic)" onchange="Rellena(document.foractos.vsol1,6)">&nbsp;&nbsp;
      </td>	
      {if $vopc eq 3}
      <td class="cnt">
        <input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud"></td>
      </form>
      {/if} 		  
      {if $vopc eq 5}
        <td class="cnt">
  	 	    <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">  
        </td>
        </form>
      {/if} 		  
      </td>
    </tr>
  </tr>
  </table>

<form name="forautor" id="forautor" enctype="multipart/form-data" action="a_obractos.php?vopc=2" method="POST" onsubmit='return pregunta();'> 
  <input type='hidden' name='vsol1' value='{$vsol1}'>
  <input type='hidden' name='nu_planilla' value='{$nu_planilla}'>
  <input type='hidden' name='accion' value='{$accion}'>
  <input type='hidden' name='string' value='{$string}'>
  <input type='hidden' name='campos' value='{$campos}'>
  <input type='hidden' name='string2' value='{$string2}'>
  <input type='hidden' name='campos2' value='{$campos2}'>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <input type='hidden' name='vder' value='{$vder}'>
    
<table>
<tr>
  <table>
  <tr>
    <td width="100%"> 
       <div><strong> </strong></div>
    </td>

    <td align="rigth">
    <table>
     <tr>
	   <td>
	     {if $accion eq 'I' || $vopc eq 4}
	       <a href="a_obractos.php?vopc=3&nconex={$n_conex}&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     {/if}
	     {if $accion eq 'M' || $vopc eq 6}
	       <a href="a_obractos.php?vopc=5&nconex={$n_conex}&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     {/if}  
	   </td>
 	   <td>&nbsp;</td>
      <td>
        {if $vopc eq 4 || $vopc eq 6}
	       <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" src="../imagenes/boton_guardar_rojo.png" alt="Save" align="middle" name="save" border="0" "/>
        {else}
          <a><img src="../imagenes/boton_guardar_rojo.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" alt="Save" align="middle" name="save" border="0" /></a>
        {/if}
      </td>
 	   <td>&nbsp;</td>
	   <td>
 	     <a href="../salir.php?nconex={$n_conex}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_rojo.png',1);">
	     <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" /></a>
	   </td>
	   <td>&nbsp;</td>
     </tr>
	 </table>
    </td>
  </tr>
  </table>

 <tr>
   <div class="tab-page" id="modules-cpanel">
   <script type="text/javascript">
      var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
   </script>

  <div class="tab-page" id="modac01"><h2 class="tab">Partes/Nat.</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac01" ) );
  </script>
  <table width="100%" border="3" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color" >
         <input type="text" name="fecha_solic" {$modo1} value='{$fecha_solic}' size="10" maxlength="10" title="Haga Clic para Seleccionar la Fecha" align="left" onkeyup="checkLength(event,this,10,document.forautor.nplanilla)" onchange="valFecha(this,document.forautor.nplanilla)">
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar1');"><img src="../imagenes/calendar2.gif" align="middle" width="26" height="24" border="0"></a>
         &nbsp;&nbsp;&nbsp;&nbsp;{$campo3}&nbsp;&nbsp;&nbsp;
         <input type="text" name="nplanilla" {$modo1} value='{$nplanilla}' size="6" maxlength="6" onKeyPress="return acceptChar(event,2,this)" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
         <textarea rows="5" name="partes" {$modo1} cols="140">{$partes}</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
	     <textarea rows="5" name="naturaleza" {$modo1} cols="140" onKeyup="this.value=this.value.toUpperCase()">{$naturaleza}</textarea>
      </td>
    </tr>
  </tr>
  </table>
  </div>

  <div class="tab-page" id="modac02"><h2 class="tab">Objeto</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac02" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
    <tr>
      <td class="der-color" >
	 <textarea rows="11" name="objeto" {$modo1} cols="160">{$objeto}</textarea>
      </td>
    </tr> 
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac03"><h2 class="tab">Derechos</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac03" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color">{$campo12}</td>
      <td class="der-color" >
	     <textarea rows="5" name="derechos" {$modo1} cols="130">{$derechos}</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo13}</td>
      <td class="der-color">
        {html_radios name="tipo_cuantia" values=$tipo_cuan selected=$tipo_cuantia output=$cuan_def separator="" }
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo14}</td>
      <td class="der-color" >
	     <textarea rows="3" name="espec_cuantia" {$modo1} cols="130" onKeyPress="if(this.value.length>300) this.value=this.value.substring(0,300);">{$espec_cuantia}</textarea>
      </td>
    </tr> 
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac04"><h2 class="tab">Detalles</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac04" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
	     <textarea rows="2" name="duracion" {$modo1} cols="140" maxlength="200">{$duracion}</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo7}</td>
      <td class="der-color" >
         <input type="text" name="domicilio" {$modo1} value='{$domicilio}' size="20" maxlength="120" align="left" onkeyup="checkLength(event,this,24,document.forautor.p_origen)">
         &nbsp;{$campo8}&nbsp;
         <input type="text" name="p_origen" {$modo1} value='{$pais_origen}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.forautor.fecha_firma)" onchange="valagente(document.forautor.p_origen,document.forautor.pais)">-
         <select size="1" name="pais" {$modo2} onchange="this.form.p_origen.value=this.options[this.selectedIndex].value">
           {html_options values=$arraycodpais selected=$pais_origen output=$arraynompais}
         </select>
         &nbsp;{$campo9}&nbsp;
         <input type="text" name="fecha_firma" {$modo1} value='{$fecha_firma}' size="10" maxlength="10" title="Haga Clic para Seleccionar la Fecha" align="left" onkeyup="checkLength(event,this,10,document.forautor.cod_idioma)" onchange="valFecha(this,document.forautor.cod_idioma)">
         <small><a href="javascript:showCal('Calendar2');" onMouseOver="window.status='Selecciona Fecha'; return true;" onMouseOut="window.status=''; return true; "><img src="../imagenes/calendar2.gif" align="middle" width=26 height=24 border=0></a></small>         
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo10}</td>
      <td class="der-color" >
         <input type="text" name="cod_idioma" {$modo1} value='{$idioma_orig}' size="2" maxlength="2" align="left" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.forautor.datosregistro)" onchange="valagente(document.forautor.cod_idioma,document.forautor.idioma)">-
         <select size="1" name="idioma" {$modo2} onchange="this.form.cod_idioma.value=this.options[this.selectedIndex].value">
           {html_options values=$arraycodidiom selected=$idioma_orig output=$arraynomidiom}
         </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo11}</td>
      <td class="der-color" >
         <textarea rows="2" name="datosregistro" {$modo1} cols="140" maxlength="300" align="left">{$datosregistro}</textarea>
      </td>
    </tr>
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac05"><h2 class="tab">Solicitante</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac05" ) );
  </script>
  <div align="left">

  <table width="100%" border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo15}</td>
      <td class="der-color">
        <div id="resultado">
         <input type="text" name="solicitante" {$modo1} value='{$solicitante}' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="Nperson" value="Natural" {$bmodo} onclick="browsesolicitante(document.forautor.vsol1,document.forautor.solicitante,document.forautor.Nperson)">
         <input type="button" name="Jperson" value="Juridica" {$bmodo} onclick="browsesolicitante(document.forautor.vsol1,document.forautor.solicitante,document.forautor.Jperson)">
         <input type="button" name="Corregir" value="Corregir" {$bmodo} onclick="browsesolicitante(document.forautor.vsol1,document.forautor.solicitante,document.forautor.Corregir)">
         <input type="button" name="Eliminar" value="Eliminar" {$bmodo} onclick="browsesolicitante(document.forautor.vsol1,document.forautor.solicitante,document.forautor.Eliminar)">
         <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol1}&vtipo=Solicitante"></iframe>
        </div>
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo16}</td>
      <td class="der-color">
        <small>{html_radios name="tipo_caracter" values=$tipo_carac selected=$tipo_caracter output=$carac_def separator=""}</small>
      </td>
    </tr> 
    <tr>
     <td class="izq-color">{$campo17}</td>
     <td class="der-color">
       <input type="text" name="otro_caracter" {$modo1} value='{$otro_caracter}' size="100" maxlength="50" onKeyup="this.value=this.value.toUpperCase()">
     </td>
    </tr>
    <tr>
     <td class="izq-color">{$campo18}</td>
     <td class="der-color">
       <textarea rows="2" name="prueba_repres" {$modo1} cols="120" maxlength="150" onKeyup="this.value=this.value.toUpperCase()">{$prueba_repres}</textarea>
     </td>
    </tr>
  </tr> 
  </table>
  </div>
  </div>
  &nbsp;

  <div class="tab-page" id="modac06"><h2 class="tab">Anexos</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac06" ) );
  </script>

  <table width="100%" border="3" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo19}</td>
     <td class="der-color">
       <textarea rows="4" name="observacion" {$modo1} cols="120" maxlength="500" >{$observacion}</textarea>
     </td>
   </tr>
   <tr>
     <td class="izq-color">{$campo20}</td>
     <td class="der-color">
       {html_radios name="hojas_adicio" values=$tipo_hadic selected=$hojas_adicio output=$hadic_def separator=""}
       &nbsp;&nbsp;&nbsp;&nbsp;{$campo21}&nbsp;&nbsp;
       <input type="text" name="n_hojas_adic" {$modo1} value='{$n_hojas_adic}' size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
     </td>
   </tr>
   <tr>
     <td class="izq-color">{$campo22}</td>
     <td class="der-color">
       <textarea rows="4" name="datos_ampli" {$modo1} cols="120" maxlength="300" >{$datos_ampli}</textarea>
     </td>
   </tr>
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac07"><h2 class="tab">H.Adicional</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac07" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
    <tr>
      <td class="der-color" >
	     <textarea rows="11" name="datos_adicio" {$modo1} cols="160" >{$datos_adicio}</textarea>
      </td>
    </tr> 
  </tr> 
  </table>
  </div>

  </div>
</form>
</div>  
&nbsp;
</body>
</html>
