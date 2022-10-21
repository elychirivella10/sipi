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
  <form name="foractos" id="foractos" action="a_obraiea.php?vopc=4" method="post">
{/if}
{if $vopc eq 5}
  <form name="foractos" id="foractos" action="a_obraiea.php?vopc=6" method="post">
{/if}
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <table>
  <tr> 
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="6" maxlength="6" value='{$vsol1}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,7,document.forobfie.fecha_solpf)" onchange="Rellena(document.foractos.vsol1,6)">&nbsp;&nbsp;
      </td>	
      {if $vopc eq 3}
      <td class="cnt">
        <input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
      </td>
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

<form name="forobfie" id="forobfie" enctype="multipart/form-data" action="a_obraiea.php?vopc=2" method="POST" onsubmit='return pregunta();'> 
  <input type='hidden' name='vsol1' value='{$vsol1}'>
  <input type='hidden' name='accion' value='{$accion}'>
  <input type='hidden' name='nu_planilla' value='{$nu_planilla}'> 
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
	       <a href="a_obraiea.php?vopc=3&nconex={$n_conex}&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     {/if}
	     {if $accion eq 'M' || $vopc eq 6}
	       <a href="a_obraiea.php?vopc=5&nconex={$n_conex}&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     {/if}  
	   </td>
 	   <td>&nbsp;</td>
      <td>
        {if $vopc eq 4 || $vopc eq 6}
	       <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" src="../imagenes/boton_guardar_rojo.png" alt="Save" align="middle" name="save" border="0" />
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

  <div class="tab-page" id="modac01"><h2 class="tab">Grupo/Dat.</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac01" ) );
  </script>
  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color" >
         <input type="text" name="fecha_solie" {$modo1} value='{$fecha_solie}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forobfie.nplanilla)" onchange="valFecha(this,document.forobfie.nplanilla)">
         &nbsp;&nbsp;
         <small><a href="javascript:showCal('Calendar5');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a></small>
         &nbsp;&nbsp;&nbsp;&nbsp;{$campo3}&nbsp;&nbsp;&nbsp;
         <input type="text" name="nplanilla" {$modo1} value='{$nplanilla}' size="6" maxlength="6" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,6,document.forobfie.nbgrupo)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
         <input type="text" name="nbgrupo" {$modo1} value='{$nbgrupo}' size="72" maxlength="120" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,120,document.forobfie.tipo_grupo)">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color" >
         <!-- <input type="text" name="tipo_grupo" {$modo1} value='{$tipo_grupo}' size="72" maxlength="120" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,120,document.forobfie.director)"> -->
         <select size="1" name="tipo_grupo" {$modo2} onchange="this.form.tipo_grupo.value=this.options[this.selectedIndex].value">
           {html_options values=$arrcodgener selected=$tipo_grupo output=$arrnomgener}
         </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
         <input type="text" name="director" {$modo1} value='{$director}' size="50" maxlength="120" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,100,document.forobfie.doc_cedula)">
         &nbsp;&nbsp;{$campo7}&nbsp;
         <input type="text" name="doc_cedula" {$modo1} value='{$doc_cedula}' size="7" maxlength="8" onKeyup="checkLength(event,this,8,document.forobfie.domicilio)" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color">
         <input type="text" name="domicilio" {$modo1} value='{$domicilio}' size="40" maxlength="120" onKeyup="checkLength(event,this,120,document.forobfie.p_origen)">
         &nbsp;&nbsp;{$campo9}&nbsp;
         <input type="text" name="p_origen" {$modo1} value='{$pais_origen}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.forobfie.ntelefono)" onchange="valagente(document.forobfie.p_origen,document.forobfie.pais)">-
         <select size="1" name="pais" {$modo2} onchange="this.form.p_origen.value=this.options[this.selectedIndex].value">
           {html_options values=$arraycodpais selected=$pais_origen output=$arraynompais}
         </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
         <input type="text" name="ntelefono" {$modo1} value='{$ntelefono}' size="13" maxlength="14" onKeyPress="return acceptChar(event,9,this)" onKeyup="checkLength(event,this,14,document.forobfie.nfax)">
         <small>Formato: (9999) 9999999</small>&nbsp;&nbsp;&nbsp;{$campo11}&nbsp;&nbsp;
         <input type="text" name="nfax" {$modo1} value='{$nfax}' size="13" maxlength="14" onKeyPress="return acceptChar(event,9,this)" onKeyup="checkLength(event,this,14,document.forobfie.tipo_fijacion)">&nbsp;
         <small>Formato: (9999) 9999999</small> 
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo28}</td>
      <td class="der-color">
        {html_radios name="tipo_fijacion" values=$tipo_fija selected=$tipo_fijacion output=$fija_def separator=""}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$campo13}&nbsp;&nbsp;
        <input type="text" name="annofijacion" {$modo1} value='{$annofijacion}' size="4" maxlength="4" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,4,document.forobfie.annopripubli)" onChange="valanno(this,document.forobfie.fecha_solie)">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$campo14}&nbsp;&nbsp;
        <input type="text" name="annopripubli" {$modo1} value='{$annopripubli}' size="4" maxlength="4" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,4,document.forobfie.otrosdatos)" onChange="valanno(this,document.forobfie.fecha_solie)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo29}</td>
      <td class="der-color" >
	     <textarea rows="2" name="otrosdatos" {$modo1} cols="107">{$otrosdatos}</textarea>
      </td>
    </tr> 
  </tr>
  </table>
  </div>

  <div class="tab-page" id="modac02"><h2 class="tab">Artistas</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac02" ) );
  </script>

  <table width="100%" border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo27}</td>
      <td class="der-color">
         <input type="text" name="artista" {$modo1} value='{$artista}' size="50" maxlength="150" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="ANperson" value="Natural" {$bmodo} onclick="browseartista(document.forobfie.vsol1,document.forobfie.artista,document.forobfie.ANperson)">
         &nbsp;{$campo30}&nbsp;
         <input type="text" name="martista" {$modo1} value='{$martista}' size="8" maxlength="8" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="MANperson" value="Modificar P. Natural" {$bmodo} onclick="browseartista(document.forobfie.vsol1,document.forobfie.martista,document.forobfie.MANperson)">

         <input type="button" name="CorregirA" value="Corregir" {$bmodo} onclick="browseartista(document.forobfie.vsol1,document.forobfie.artista,document.forobfie.CorregirA)">
         <input type="button" name="EliminarA" value="Eliminar" {$bmodo} onclick="browseartista(document.forobfie.vsol1,document.forobfie.artista,document.forobfie.EliminarA)">
         <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol1}&vtipo=Artista"></iframe>

      </td>
    </tr> 
    <tr>
      <td colspan="2"> 
      <div id="resultado">
         <iframe name='frameart' id='frameart' style='width:100%;height:100px' src="../autor/d_consoli.php?psol={$vsol1}&vtipo=Artista"></iframe>
      </div>
      </td>
    </tr> 
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac03"><h2 class="tab">Obr.Int/Ejec</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac03" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color">{$campo25}</td>
      <td class="der-color">
         <input type="text" name="obrafijada" {$modo1} value='{$obrafijada}' size="30" maxlength="100" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="obrafija" value="Incluir Obra Int/Eje" {$bmodo} onclick="browseobfie(document.forobfie.vsol1,document.forobfie.obrafijada,document.forobfie.obrafija)">
         &nbsp;{$campo26}&nbsp;
         <input type="text" name="obramfijada" {$modo1} value='{$obramfijada}' size="6" maxlength="7" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="obramfija" value="Modificar Obra Int/Eje" {$bmodo} onclick="browseobfie(document.forobfie.vsol1,document.forobfie.obramfijada,document.forobfie.obramfija)">
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

  <div class="tab-page" id="modac04"><h2 class="tab">Titular</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac04" ) );
  </script>

  <table width="100%" border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo15}</td>
      <td class="der-color">
         <input type="text" name="titular" {$modo1} value='{$titular}' size="55" maxlength="150" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="TNperson" value="Natural" {$bmodo} onclick="browsetitular(document.forobfie.vsol1,document.forobfie.titular,document.forobfie.TNperson)">
         <input type="button" name="TJperson" value="Juridica" {$bmodo} onclick="browsetitular(document.forobfie.vsol1,document.forobfie.titular,document.forobfie.TJperson)">
         <input type="button" name="CorregirT" value="Corregir" {$bmodo} onclick="browsetitular(document.forobfie.vsol1,document.forobfie.titular,document.forobfie.CorregirT)">
         <input type="button" name="EliminarT" value="Eliminar" {$bmodo} onclick="browsetitular(document.forobfie.vsol1,document.forobfie.titular,document.forobfie.EliminarT)">
         <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol1}&vtipo=Titular"></iframe>
      </td>
    </tr> 
    <!-- <tr>
      <td colspan="2"> 
      <div id="resultado">
         <iframe name='frametitu' id='frametitu' style='width:100%;height:100px' src="../autor/d_consoli.php?psol={$vsol1}&vtipo=Titular"></iframe>
      </div>
      </td>
    </tr> --> 
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac05"><h2 class="tab">Transferencias</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac05" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
    <tr>
      <td class="der-color" >
	     <textarea rows="11" name="transferen" {$modo1} cols="160">{$transferen}</textarea>
      </td>
    </tr> 
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac06"><h2 class="tab">Solicitante</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac06" ) );
  </script>
  <div align="left">

  <table width="100%" border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo15}</td>
      <td class="der-color">
         <input type="text" name="solicitante" {$modo1} value='{$solicitante}' size="60" maxlength="150" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="Nperson" value="Natural" {$bmodo} onclick="browsesolicitante(document.forobfie.vsol1,document.forobfie.solicitante,document.forobfie.Nperson)">
         <input type="button" name="Jperson" value="Juridica" {$bmodo} onclick="browsesolicitante(document.forobfie.vsol1,document.forobfie.solicitante,document.forobfie.Jperson)">
         <input type="button" name="Corregir" value="Corregir" {$bmodo} onclick="browsesolicitante(document.forobfie.vsol1,document.forobfie.solicitante,document.forobfie.Corregir)">
         <input type="button" name="Eliminar" value="Eliminar" {$bmodo} onclick="browsesolicitante(document.forobfie.vsol1,document.forobfie.solicitante,document.forobfie.Eliminar)">
         <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol1}&vtipo=Solicitante"></iframe>
         <!-- <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_consoli.php?psol={$vsol1}&vtipo=Solicitante"></iframe> -->         
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
       <input type="text" name="otro_caracter" {$modo1} value='{$otro_caracter}' size="100" maxlength="50">
     </td>
    </tr>
    <tr>
     <td class="izq-color">{$campo18}</td>
     <td class="der-color">
       <textarea rows="2" name="prueba_repres" {$modo1} cols="120" maxlength="150">{$prueba_repres}</textarea>
     </td>
    </tr>
  </tr> 
  </table>
  </div>
  </div>
  &nbsp;

  <div class="tab-page" id="modac07"><h2 class="tab">Deposito</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac07" ) );
  </script>

  <table width="100%" border="3" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo19}</td>
     <td class="der-color">
       <input type="text" name="n_ejemplares" {$modo1} value='{$n_ejemplares}' size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
       &nbsp;&nbsp;&nbsp;&nbsp;{$campo20}&nbsp;&nbsp;
       <input type="text" name="tipo_soporte" {$modo1} value='{$tipo_soporte}' size="25" maxlength="25">
     </td>
   </tr>
   <tr>
     <td class="izq-color">{$campo21}</td>
     <td class="der-color">
       <textarea rows="3" name="observacion" {$modo1} cols="115" maxlength="300">{$observacion}</textarea>
     </td>
   </tr>
   <tr>
     <td class="izq-color">{$campo22}</td>
     <td class="der-color">
       {html_radios name="hojas_adicio" values=$tipo_hadic selected=$hojas_adicio output=$hadic_def separator=""}
       &nbsp;&nbsp;&nbsp;&nbsp;{$campo23}&nbsp;&nbsp;
       <input type="text" name="n_hojas_adic" {$modo1} value='{$n_hojas_adic}' size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
     </td>
   </tr>
   <tr>
     <td class="izq-color">{$campo24}</td>
     <td class="der-color">
       <textarea rows="4" name="datos_ampli" {$modo1} cols="115" maxlength="300">{$datos_ampli}</textarea>
     </td>
   </tr>
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac08"><h2 class="tab">H.Adicional</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac08" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
    <tr>
      <td class="der-color" >
	     <textarea rows="11" name="datos_adicio" {$modo1} cols="160">{$datos_adicio}</textarea>
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
