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
  <form name="foractos" id="foractos" action="a_obrpfononw.php?vopc=4" method="post">
{/if}
{if $vopc eq 5}
  <form name="foractos" id="foractos" action="a_obrpfononw.php?vopc=6" method="post">
{/if} 
  <input type="hidden" name="nconex" value="{$n_conex}">
  <input type="hidden" name="nhora" value="{$vhora}"> 
  <input type="hidden" name="npla" value="PF"> 
  <table>
  <tr> 
    <tr>
      <td class="izq5-color">Planilla No.</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="4" maxlength="16" value='{$vsol1}' {$modo} 
               onkeyup="checkLength (event,this,6,document.forfonog.fecha_solpf)"
               onchange="Newsol(document.foractos.vsol1,6,document.foractos.npla,document.foractos.nhora)">
      </td>&nbsp;&nbsp;
      {if $vopc eq 3}
        <td class="cnt">
          <input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
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

<form name="forfonog" id="forfonog" enctype="multipart/form-data" action="a_obrpfononw.php?vopc=2" method="POST" onsubmit='return pregunta();'> 
  <input type='hidden' name='vsol1' value='{$vsol1}'>
  <input type='hidden' name='nu_planilla' value='{$nu_planilla}'>
  <input type='hidden' name='accion' value='{$accion}'>
  <input type='hidden' name='string' value='{$string}'>
  <input type='hidden' name='campos' value='{$campos}'>
  <input type='hidden' name='string14' value='{$string14}'>
  <input type='hidden' name='campos14' value='{$campos14}'>
  <input type='hidden' name='string15' value='{$string15}'>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <input type='hidden' name='vder' value='{$vder}'>
  
<table width="100%">
<tr>
  <table width="100%">
  <tr>
    <td width="100%"> 
       <div><strong> </strong></div>
    </td>

    <td align="rigth">
    <table>
     <tr>
	   <td>
	     {if $accion eq 'I' || $vopc eq 4}
	       <a href="a_obrpfononw.php?vopc=3&nconex={$n_conex}&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     {/if}
	     {if $accion eq 'M' || $vopc eq 6}
	       <a href="a_obrpfononw.php?vopc=5&nconex={$n_conex}&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     {/if}  
	   </td>
 	   <td>&nbsp;</td>
      <td>
        {if $vopc eq 4 || $vopc eq 6}
	       <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" src="../imagenes/boton_guardar_rojo.png" alt="Save" align="middle" name="save" border="0" onclick="validate();return returnVal;"/>
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

  <div class="tab-page" id="modac01"><h2 class="tab">Datos</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac01" ) );
  </script>
  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color" >
         <input type="text" name="fecha_solpf" {$modo1} value='{$fecha_solpf}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forfonog.nplanilla)" onchange="valFecha(this,document.forfonog.nplanilla)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar4');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         &nbsp;&nbsp;&nbsp;&nbsp;{$campo3}&nbsp;&nbsp;&nbsp;
         <input type="hidden" name="nplanilla" value='{$nplanilla}'>  
         </div>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
         <textarea rows="2" name="titulobr" {$modo1} cols="110" onKeyup="this.value=this.value.toUpperCase()">{$titulobr}</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color" >
         <input type="text" name="p_origen" {$modo1} value='{$pais_origen}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.forfonog.cod_idioma)" onchange="valagente(document.forfonog.p_origen,document.forfonog.pais)">-
         <select size="1" name="pais" {$modo2} onchange="this.form.p_origen.value=this.options[this.selectedIndex].value">
           {html_options values=$arraycodpais selected=$pais_origen output=$arraynompais}
         </select>
         &nbsp;&nbsp;&nbsp;{$campo6}&nbsp;
         <input type="text" name="cod_idioma" {$modo1} value='{$idioma_orig}' size="1" maxlength="2" align="left" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.forfonog.traduccion)" onchange="valagente(document.forfonog.cod_idioma,document.forfonog.idioma)">-
         <select size="1" name="idioma" {$modo2} onchange="this.form.cod_idioma.value=this.options[this.selectedIndex].value">
           {html_options values=$arraycodidiom selected=$idioma_orig output=$arraynomidiom}
         </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
         <textarea rows="2" name="traduccion" {$modo1} cols="110" onKeyup="this.value=this.value.toUpperCase()">{$traduccion}</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color">
         <input type="text" name="annofijacion" {$modo1} value='{$annofijacion}' size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onKeyup="checkLength(event,this,4,document.forfonog.annopripubli)"> 
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
         <input type="text" name="annopripubli" {$modo1} value='{$annopripubli}' size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onKeyup="checkLength(event,this,4,document.forfonog.annopripubli)"> 
      </td>
    </tr>
  </tr>
  </table>
  </div>

  <div class="tab-page" id="modac02"><h2 class="tab">Productor</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac02" ) );
  </script>

  <table width="100%" border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo10}</td>
      <td class="der-color">
        <div id="resultado">
         <input type="text" name="productor" {$modo1} value='{$productor}' size="55" maxlength="150" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="PNperson" value="Natural" {$bmodo} onclick="browseproductor(document.forfonog.vsol1,document.forfonog.productor,document.forfonog.PNperson)">
         <input type="button" name="PJperson" value="Juridica" {$bmodo} onclick="browseproductor(document.forfonog.vsol1,document.forfonog.productor,document.forfonog.PJperson)">
         <input type="button" name="CorregirP" value="Corregir" {$bmodo} onclick="browseproductor(document.forfonog.vsol1,document.forfonog.productor,document.forfonog.CorregirP)">
         <input type="button" name="EliminarP" value="Eliminar" {$bmodo} onclick="browseproductor(document.forfonog.vsol1,document.forfonog.productor,document.forfonog.EliminarP)">
         <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol1}&vtipo=Productor"></iframe>
         <!-- <iframe name='frameprod' id='frameprod' style='width:100%;height:100px' src="../autor/d_consoli.php?psol={$vsol1}&vtipo=Productor"></iframe> -->
        </div>
      </td>
    </tr> 
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac03"><h2 class="tab">Obr.Fijadas</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac03" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color">{$campo20}</td>
      <td class="der-color">
         <input type="text" name="obrafijada" {$modo1} value='{$obrafijada}' size="33" maxlength="100" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="obrafija" value="Incluir Obra Fijada" {$bmodo} onclick="browseobfie(document.forfonog.vsol1,document.forfonog.obrafijada,document.forfonog.obrafija)">
         &nbsp;{$campo21}&nbsp;
         <input type="text" name="obramfijada" {$modo1} value='{$obramfijada}' size="6" maxlength="7" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="obramfija" value="Modificar Obra Fijada" {$bmodo} onclick="browsemobfie(document.forfonog.vsol1,document.forfonog.obramfijada,document.forfonog.obramfija)">
      </td>
    </tr> 
    <tr>
      <td colspan="2"> 
      <div id="resultado">
       <iframe name='frameobrfi' id='frameobrfi' style='width:100%;height:180px' src="../autor/d_conobfie.php?psol={$vsol1}&vtipo=Fijadas"></iframe>
      </div>
      </td>
    </tr> 
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac04"><h2 class="tab">Transferencias</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac04" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
    <tr>
      <td class="der-color" >
	     <textarea rows="11" name="transferen" {$modo1} cols="165">{$transferen}</textarea>
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
      <td class="izq-color">{$campo10}</td>
      <td class="der-color">
        <div id="resultado">
         <input type="text" name="solicitante" {$modo1} value='{$solicitante}' size="60" maxlength="150" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="Nperson" value="Natural" {$bmodo} onclick="browsesolicitante(document.forfonog.vsol1,document.forfonog.solicitante,document.forfonog.Nperson)">
         <input type="button" name="Jperson" value="Juridica" {$bmodo} onclick="browsesolicitante(document.forfonog.vsol1,document.forfonog.solicitante,document.forfonog.Jperson)">
         <input type="button" name="Corregir" value="Corregir" {$bmodo} onclick="browsesolicitante(document.forfonog.vsol1,document.forfonog.solicitante,document.forfonog.Corregir)">
         <input type="button" name="Eliminar" value="Eliminar" {$bmodo} onclick="browsesolicitante(document.forfonog.vsol1,document.forfonog.solicitante,document.forfonog.Eliminar)">
         <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol1}&vtipo=Solicitante"></iframe>
         <!-- <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="../autor/d_consoli.php?psol={$vsol1}&vtipo=Solicitante"></iframe> -->
        </div>
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo11}</td>
      <td class="der-color">
        <small>{html_radios name="tipo_caracter" values=$tipo_carac selected=$tipo_caracter output=$carac_def separator=""}</small>
      </td>
    </tr> 
    <tr>
     <td class="izq-color">{$campo12}</td>
     <td class="der-color">
       <input type="text" name="otro_caracter" {$modo1} value='{$otro_caracter}' size="100" maxlength="50">
     </td>
    </tr>
    <tr>
     <td class="izq-color">{$campo13}</td>
     <td class="der-color">
       <textarea rows="2" name="prueba_repres" {$modo1} cols="120" maxlength="150">{$prueba_repres}</textarea>
     </td>
    </tr>
  </tr> 
  </table>
  </div>
  </div>
  &nbsp;

  <div class="tab-page" id="modac06"><h2 class="tab">Deposito</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac06" ) );
  </script>

  <table width="100%" border="3" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo14}</td>
     <td class="der-color">
       <input type="text" name="n_ejemplares" {$modo1} value='{$n_ejemplares}' size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
       &nbsp;&nbsp;&nbsp;&nbsp;{$campo15}&nbsp;&nbsp;
       <input type="text" name="tipo_soporte" {$modo1} value='{$tipo_soporte}' size="25" maxlength="25">
     </td>
   </tr>
   <tr>
     <td class="izq-color">{$campo16}</td>
     <td class="der-color">
       <textarea rows="3" name="observacion" {$modo1} cols="120" maxlength="300">{$observacion}</textarea>
     </td>
   </tr>
   <tr>
     <td class="izq-color">{$campo17}</td>
     <td class="der-color">
       {html_radios name="hojas_adicio" values=$tipo_hadic selected=$hojas_adicio output=$hadic_def separator=""}
       &nbsp;&nbsp;&nbsp;&nbsp;{$campo18}&nbsp;&nbsp;
       <input type="text" name="n_hojas_adic" {$modo1} value='{$n_hojas_adic}' size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
     </td>
   </tr>
   <tr>
     <td class="izq-color">{$campo19}</td>
     <td class="der-color">
       <textarea rows="4" name="datos_ampli" {$modo1} cols="120" maxlength="300">{$datos_ampli}</textarea>
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
	     <textarea rows="11" name="datos_adicio" {$modo1} cols="165">{$datos_adicio}</textarea>
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
