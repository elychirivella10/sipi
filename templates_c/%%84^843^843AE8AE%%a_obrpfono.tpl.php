<?php /* Smarty version 2.6.8, created on 2020-11-11 12:53:25
         compiled from a_obrpfono.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'a_obrpfono.tpl', 133, false),array('function', 'html_radios', 'a_obrpfono.tpl', 258, false),)), $this); ?>
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

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<?php if ($this->_tpl_vars['vopc'] == 3): ?>
  <form name="foractos" id="foractos" action="a_obrpfono.php?vopc=4" method="post">
<?php endif;  if ($this->_tpl_vars['vopc'] == 5): ?>
  <form name="foractos" id="foractos" action="a_obrpfono.php?vopc=6" method="post">
<?php endif; ?> 
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <table>
  <tr> 
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,7,document.forfonog.fecha_solpf)" onchange="Rellena(document.foractos.vsol1,6)">&nbsp;&nbsp;
      </td>	
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
        <td class="cnt">
          <input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
        </form>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['vopc'] == 5): ?>
        <td class="cnt">
  	  <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">
        </td>
        </form>
      <?php endif; ?> 		  
      </td>
    </tr>
  </tr>
  </table>

<form name="forfonog" id="forfonog" enctype="multipart/form-data" action="a_obrpfono.php?vopc=2" method="POST" onsubmit='return pregunta();'> 
  <input type='hidden' name='vsol1' value='<?php echo $this->_tpl_vars['vsol1']; ?>
'>
  <input type='hidden' name='nu_planilla' value='<?php echo $this->_tpl_vars['nu_planilla']; ?>
'>
  <input type='hidden' name='accion' value='<?php echo $this->_tpl_vars['accion']; ?>
'>
  <input type='hidden' name='string' value='<?php echo $this->_tpl_vars['string']; ?>
'>
  <input type='hidden' name='campos' value='<?php echo $this->_tpl_vars['campos']; ?>
'>
  <input type='hidden' name='string14' value='<?php echo $this->_tpl_vars['string14']; ?>
'>
  <input type='hidden' name='campos14' value='<?php echo $this->_tpl_vars['campos14']; ?>
'>
  <input type='hidden' name='string15' value='<?php echo $this->_tpl_vars['string15']; ?>
'>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>
  
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
	     <?php if ($this->_tpl_vars['accion'] == 'I' || $this->_tpl_vars['vopc'] == 4): ?>
	       <a href="a_obrpfono.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     <?php endif; ?>
	     <?php if ($this->_tpl_vars['accion'] == 'M' || $this->_tpl_vars['vopc'] == 6): ?>
	       <a href="a_obrpfono.php?vopc=5&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     <?php endif; ?>  
	   </td>
 	   <td>&nbsp;</td>
      <td>
        <?php if ($this->_tpl_vars['vopc'] == 4 || $this->_tpl_vars['vopc'] == 6): ?>
	       <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" src="../imagenes/boton_guardar_rojo.png" alt="Save" align="middle" name="save" border="0" onclick="validate();return returnVal;"/>
        <?php else: ?>
          <a><img src="../imagenes/boton_guardar_rojo.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" alt="Save" align="middle" name="save" border="0" /></a>
        <?php endif; ?>
      </td>
 	   <td>&nbsp;</td>
	   <td>
 	     <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_rojo.png',1);">
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
      <td class="izq-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color" >
         <input type="text" name="fecha_solpf" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solpf']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forfonog.nplanilla)" onchange="valFecha(this,document.forfonog.nplanilla)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar4');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo3']; ?>
&nbsp;&nbsp;&nbsp;
         <input type="text" name="nplanilla" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['nplanilla']; ?>
' size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)"> 
         </div>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
         <textarea rows="2" name="titulobr" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="110" onKeyup="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['titulobr']; ?>
</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color" >
         <input type="text" name="p_origen" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pais_origen']; ?>
' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.forfonog.cod_idioma)" onchange="valagente(document.forfonog.p_origen,document.forfonog.pais)">-
         <select size="1" name="pais" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="this.form.p_origen.value=this.options[this.selectedIndex].value">
           <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraycodpais'],'selected' => $this->_tpl_vars['pais_origen'],'output' => $this->_tpl_vars['arraynompais']), $this);?>

         </select>
         &nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo6']; ?>
&nbsp;
         <input type="text" name="cod_idioma" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['idioma_orig']; ?>
' size="1" maxlength="2" align="left" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.forfonog.traduccion)" onchange="valagente(document.forfonog.cod_idioma,document.forfonog.idioma)">-
         <select size="1" name="idioma" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="this.form.cod_idioma.value=this.options[this.selectedIndex].value">
           <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraycodidiom'],'selected' => $this->_tpl_vars['idioma_orig'],'output' => $this->_tpl_vars['arraynomidiom']), $this);?>

         </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
         <textarea rows="2" name="traduccion" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="110" onKeyup="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['traduccion']; ?>
</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color">
         <input type="text" name="annofijacion" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['annofijacion']; ?>
' size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onKeyup="checkLength(event,this,4,document.forfonog.annopripubli)"> 
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
         <input type="text" name="annopripubli" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['annopripubli']; ?>
' size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onKeyup="checkLength(event,this,4,document.forfonog.annopripubli)"> 
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
      <td class="izq-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
        <div id="resultado">
         <input type="text" name="productor" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['productor']; ?>
' size="55" maxlength="150" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="PNperson" value="Natural" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browseproductor(document.forfonog.vsol1,document.forfonog.productor,document.forfonog.PNperson)">
         <input type="button" name="PJperson" value="Juridica" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browseproductor(document.forfonog.vsol1,document.forfonog.productor,document.forfonog.PJperson)">
         <input type="button" name="CorregirP" value="Corregir" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browseproductor(document.forfonog.vsol1,document.forfonog.productor,document.forfonog.CorregirP)">
         <input type="button" name="EliminarP" value="Eliminar" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browseproductor(document.forfonog.vsol1,document.forfonog.productor,document.forfonog.EliminarP)">
         <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vtipo=Productor"></iframe>
         <!-- <iframe name='frameprod' id='frameprod' style='width:100%;height:100px' src="../autor/d_consoli.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vtipo=Productor"></iframe> -->
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
      <td class="izq-color"><?php echo $this->_tpl_vars['campo20']; ?>
</td>
      <td class="der-color">
         <input type="text" name="obrafijada" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['obrafijada']; ?>
' size="33" maxlength="100" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="obrafija" value="Incluir Obra Fijada" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browseobfie(document.forfonog.vsol1,document.forfonog.obrafijada,document.forfonog.obrafija)">
         &nbsp;<?php echo $this->_tpl_vars['campo21']; ?>
&nbsp;
         <input type="text" name="obramfijada" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['obramfijada']; ?>
' size="6" maxlength="7" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="obramfija" value="Modificar Obra Fijada" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsemobfie(document.forfonog.vsol1,document.forfonog.obramfijada,document.forfonog.obramfija)">
      </td>
    </tr> 
    <tr>
      <td colspan="2"> 
      <div id="resultado">
       <iframe name='frameobrfi' id='frameobrfi' style='width:100%;height:180px' src="../autor/d_conobfie.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vtipo=Fijadas"></iframe>
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
	     <textarea rows="11" name="transferen" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="160"><?php echo $this->_tpl_vars['transferen']; ?>
</textarea>
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
      <td class="izq-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
        <div id="resultado">
         <input type="text" name="solicitante" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['solicitante']; ?>
' size="60" maxlength="150" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="Nperson" value="Natural" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsesolicitante(document.forfonog.vsol1,document.forfonog.solicitante,document.forfonog.Nperson)">
         <input type="button" name="Jperson" value="Juridica" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsesolicitante(document.forfonog.vsol1,document.forfonog.solicitante,document.forfonog.Jperson)">
         <input type="button" name="Corregir" value="Corregir" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsesolicitante(document.forfonog.vsol1,document.forfonog.solicitante,document.forfonog.Corregir)">
         <input type="button" name="Eliminar" value="Eliminar" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsesolicitante(document.forfonog.vsol1,document.forfonog.solicitante,document.forfonog.Eliminar)">
         <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vtipo=Solicitante"></iframe>
         <!-- <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="../autor/d_consoli.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vtipo=Solicitante"></iframe> -->
        </div>
      </td>
    </tr> 
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo11']; ?>
</td>
      <td class="der-color">
        <small><?php echo smarty_function_html_radios(array('name' => 'tipo_caracter','values' => $this->_tpl_vars['tipo_carac'],'selected' => $this->_tpl_vars['tipo_caracter'],'output' => $this->_tpl_vars['carac_def'],'separator' => ""), $this);?>
</small>
      </td>
    </tr> 
    <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo12']; ?>
</td>
     <td class="der-color">
       <input type="text" name="otro_caracter" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['otro_caracter']; ?>
' size="100" maxlength="50">
     </td>
    </tr>
    <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo13']; ?>
</td>
     <td class="der-color">
       <textarea rows="2" name="prueba_repres" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="120" maxlength="150"><?php echo $this->_tpl_vars['prueba_repres']; ?>
</textarea>
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
     <td class="izq-color"><?php echo $this->_tpl_vars['campo14']; ?>
</td>
     <td class="der-color">
       <input type="text" name="n_ejemplares" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['n_ejemplares']; ?>
' size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
       &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo15']; ?>
&nbsp;&nbsp;
       <input type="text" name="tipo_soporte" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['tipo_soporte']; ?>
' size="25" maxlength="25">
     </td>
   </tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo16']; ?>
</td>
     <td class="der-color">
       <textarea rows="3" name="observacion" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="130" maxlength="300"><?php echo $this->_tpl_vars['observacion']; ?>
</textarea>
     </td>
   </tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo17']; ?>
</td>
     <td class="der-color">
       <?php echo smarty_function_html_radios(array('name' => 'hojas_adicio','values' => $this->_tpl_vars['tipo_hadic'],'selected' => $this->_tpl_vars['hojas_adicio'],'output' => $this->_tpl_vars['hadic_def'],'separator' => ""), $this);?>

       &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo18']; ?>
&nbsp;&nbsp;
       <input type="text" name="n_hojas_adic" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['n_hojas_adic']; ?>
' size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
     </td>
   </tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo19']; ?>
</td>
     <td class="der-color">
       <textarea rows="4" name="datos_ampli" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="130" maxlength="300"><?php echo $this->_tpl_vars['datos_ampli']; ?>
</textarea>
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
	     <textarea rows="11" name="datos_adicio" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="160"><?php echo $this->_tpl_vars['datos_adicio']; ?>
</textarea>
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