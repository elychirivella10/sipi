<?php /* Smarty version 2.6.8, created on 2022-05-13 15:59:33
         compiled from a_obraieanw.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'a_obraieanw.tpl', 131, false),array('function', 'html_radios', 'a_obraieanw.tpl', 166, false),)), $this); ?>
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
  <form name="foractos" id="foractos" action="a_obraieanw.php?vopc=4" method="post">
<?php endif;  if ($this->_tpl_vars['vopc'] == 5): ?>
  <form name="foractos" id="foractos" action="a_obraieanw.php?vopc=6" method="post">
<?php endif; ?>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type="hidden" name="nhora" value="<?php echo $this->_tpl_vars['vhora']; ?>
"> 
  <input type="hidden" name="npla" value="IE"> 
  <table>
  <tr> 
    <tr>
      <td class="izq5-color">Planilla No.</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="4" maxlength="16" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 
               onkeyup="checkLength (event,this,6,document.forobfie.fecha_solie)"
               onchange="Newsol(document.foractos.vsol1,6,document.foractos.npla,document.foractos.nhora)">
      </td>&nbsp;&nbsp;
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
      <td class="cnt">
        <input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
      </td>
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

<form name="forobfie" id="forobfie" enctype="multipart/form-data" action="a_obraieanw.php?vopc=2" method="POST" onsubmit='return pregunta();'> 
  <input type='hidden' name='vsol1' value='<?php echo $this->_tpl_vars['vsol1']; ?>
'>
  <input type='hidden' name='accion' value='<?php echo $this->_tpl_vars['accion']; ?>
'>
  <input type='hidden' name='nu_planilla' value='<?php echo $this->_tpl_vars['nu_planilla']; ?>
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
	       <a href="a_obraieanw.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     <?php endif; ?>
	     <?php if ($this->_tpl_vars['accion'] == 'M' || $this->_tpl_vars['vopc'] == 6): ?>
	       <a href="a_obraieanw.php?vopc=5&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     <?php endif; ?>  
	   </td>
 	   <td>&nbsp;</td>
      <td>
        <?php if ($this->_tpl_vars['vopc'] == 4 || $this->_tpl_vars['vopc'] == 6): ?>
	       <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" src="../imagenes/boton_guardar_rojo.png" alt="Save" align="middle" name="save" border="0" />&nbsp;Grabar&nbsp;&nbsp;
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

  <div class="tab-page" id="modac01"><h2 class="tab">Grupo/Dat.</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac01" ) );
  </script>
  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color" >
         <input type="text" name="fecha_solie" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solie']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forobfie.nplanilla)" onchange="valFecha(this,document.forobfie.nplanilla)">
         &nbsp;&nbsp;
         <small><a href="javascript:showCal('Calendar5');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a></small>
         &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo3']; ?>
&nbsp;&nbsp;&nbsp;
         <input type="text" name="nplanilla" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['nplanilla']; ?>
' size="6" maxlength="6" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,6,document.forobfie.nbgrupo)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
         <input type="text" name="nbgrupo" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['nbgrupo']; ?>
' size="72" maxlength="120" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,120,document.forobfie.tipo_grupo)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color" >
         <!-- <input type="text" name="tipo_grupo" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['tipo_grupo']; ?>
' size="72" maxlength="120" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,120,document.forobfie.director)"> -->
         <select size="1" name="tipo_grupo" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="this.form.tipo_grupo.value=this.options[this.selectedIndex].value">
           <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrcodgener'],'selected' => $this->_tpl_vars['tipo_grupo'],'output' => $this->_tpl_vars['arrnomgener']), $this);?>

         </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
         <input type="text" name="director" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['director']; ?>
' size="50" maxlength="120" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,100,document.forobfie.doc_cedula)">
         &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo7']; ?>
&nbsp;
         <input type="text" name="doc_cedula" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['doc_cedula']; ?>
' size="7" maxlength="8" onKeyup="checkLength(event,this,8,document.forobfie.domicilio)" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color">
         <input type="text" name="domicilio" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['domicilio']; ?>
' size="40" maxlength="120" onKeyup="checkLength(event,this,120,document.forobfie.p_origen)">
         &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo9']; ?>
&nbsp;
         <input type="text" name="p_origen" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pais_origen']; ?>
' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.forobfie.ntelefono)" onchange="valagente(document.forobfie.p_origen,document.forobfie.pais)">-
         <select size="1" name="pais" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="this.form.p_origen.value=this.options[this.selectedIndex].value">
           <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraycodpais'],'selected' => $this->_tpl_vars['pais_origen'],'output' => $this->_tpl_vars['arraynompais']), $this);?>

         </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
         <input type="text" name="ntelefono" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['ntelefono']; ?>
' size="13" maxlength="14" onKeyPress="return acceptChar(event,9,this)" onKeyup="checkLength(event,this,14,document.forobfie.nfax)">
         <small>Formato: (9999) 9999999</small>&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo11']; ?>
&nbsp;&nbsp;
         <input type="text" name="nfax" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['nfax']; ?>
' size="13" maxlength="14" onKeyPress="return acceptChar(event,9,this)" onKeyup="checkLength(event,this,14,document.forobfie.tipo_fijacion)">&nbsp;
         <small>Formato: (9999) 9999999</small> 
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo28']; ?>
</td>
      <td class="der-color">
        <?php echo smarty_function_html_radios(array('name' => 'tipo_fijacion','values' => $this->_tpl_vars['tipo_fija'],'selected' => $this->_tpl_vars['tipo_fijacion'],'output' => $this->_tpl_vars['fija_def'],'separator' => ""), $this);?>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo13']; ?>
&nbsp;&nbsp;
        <input type="text" name="annofijacion" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['annofijacion']; ?>
' size="4" maxlength="4" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,4,document.forobfie.annopripubli)" onChange="valanno(this,document.forobfie.fecha_solie)">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo14']; ?>
&nbsp;&nbsp;
        <input type="text" name="annopripubli" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['annopripubli']; ?>
' size="4" maxlength="4" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,4,document.forobfie.otrosdatos)" onChange="valanno(this,document.forobfie.fecha_solie)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo29']; ?>
</td>
      <td class="der-color" >
	     <textarea rows="2" name="otrosdatos" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="107"><?php echo $this->_tpl_vars['otrosdatos']; ?>
</textarea>
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
      <td class="izq-color"><?php echo $this->_tpl_vars['campo27']; ?>
</td>
      <td class="der-color">
         <input type="text" name="artista" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['artista']; ?>
' size="50" maxlength="150" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="ANperson" value="Natural" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browseartista(document.forobfie.vsol1,document.forobfie.artista,document.forobfie.ANperson)">
         &nbsp;<?php echo $this->_tpl_vars['campo30']; ?>
&nbsp;
         <input type="text" name="martista" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['martista']; ?>
' size="8" maxlength="8" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="MANperson" value="Modificar P. Natural" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browseartista(document.forobfie.vsol1,document.forobfie.martista,document.forobfie.MANperson)">
      </td>
    </tr> 
    <tr>
      <td colspan="2"> 
      <div id="resultado">
         <iframe name='frameart' id='frameart' style='width:100%;height:100px' src="../autor/d_consoli.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vtipo=Artista"></iframe>
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
      <td class="izq-color"><?php echo $this->_tpl_vars['campo25']; ?>
</td>
      <td class="der-color">
         <input type="text" name="obrafijada" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['obrafijada']; ?>
' size="30" maxlength="100" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="obrafija" value="Incluir Obra Int/Eje" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browseobfie(document.forobfie.vsol1,document.forobfie.obrafijada,document.forobfie.obrafija)">
         &nbsp;<?php echo $this->_tpl_vars['campo26']; ?>
&nbsp;
         <input type="text" name="obramfijada" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['obramfijada']; ?>
' size="6" maxlength="7" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="obramfija" value="Modificar Obra Int/Eje" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browseobfie(document.forobfie.vsol1,document.forobfie.obramfijada,document.forobfie.obramfija)">
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

  <div class="tab-page" id="modac04"><h2 class="tab">Titular</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac04" ) );
  </script>

  <table width="100%" border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo15']; ?>
</td>
      <td class="der-color">
         <input type="text" name="titular" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['titular']; ?>
' size="55" maxlength="150" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="TNperson" value="Natural" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsetitular(document.forobfie.vsol1,document.forobfie.titular,document.forobfie.TNperson)">
         <input type="button" name="TJperson" value="Juridica" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsetitular(document.forobfie.vsol1,document.forobfie.titular,document.forobfie.TJperson)">
         <input type="button" name="CorregirT" value="Corregir" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsetitular(document.forobfie.vsol1,document.forobfie.titular,document.forobfie.CorregirT)">
         <input type="button" name="EliminarT" value="Eliminar" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsetitular(document.forobfie.vsol1,document.forobfie.titular,document.forobfie.EliminarT)">
         <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vtipo=Titular"></iframe>
      </td>
    </tr> 
    <!-- <tr>
      <td colspan="2"> 
      <div id="resultado">
         <iframe name='frametitu' id='frametitu' style='width:100%;height:100px' src="../autor/d_consoli.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vtipo=Titular"></iframe>
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
	     <textarea rows="11" name="transferen" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="165"><?php echo $this->_tpl_vars['transferen']; ?>
</textarea>
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
      <td class="izq-color"><?php echo $this->_tpl_vars['campo15']; ?>
</td>
      <td class="der-color">
         <input type="text" name="solicitante" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['solicitante']; ?>
' size="60" maxlength="150" onKeyUp="javascript:this.value=this.value.toUpperCase();">
         <input type="button" name="Nperson" value="Natural" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsesolicitante(document.forobfie.vsol1,document.forobfie.solicitante,document.forobfie.Nperson)">
         <input type="button" name="Jperson" value="Juridica" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsesolicitante(document.forobfie.vsol1,document.forobfie.solicitante,document.forobfie.Jperson)">
         <input type="button" name="Corregir" value="Corregir" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsesolicitante(document.forobfie.vsol1,document.forobfie.solicitante,document.forobfie.Corregir)">
         <input type="button" name="Eliminar" value="Eliminar" <?php echo $this->_tpl_vars['bmodo']; ?>
 onclick="browsesolicitante(document.forobfie.vsol1,document.forobfie.solicitante,document.forobfie.Eliminar)">
         <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vtipo=Solicitante"></iframe>
         <!-- <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_consoli.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&vtipo=Solicitante"></iframe> -->         
      </td>
    </tr> 
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo16']; ?>
</td>
      <td class="der-color">
        <small><?php echo smarty_function_html_radios(array('name' => 'tipo_caracter','values' => $this->_tpl_vars['tipo_carac'],'selected' => $this->_tpl_vars['tipo_caracter'],'output' => $this->_tpl_vars['carac_def'],'separator' => ""), $this);?>
</small>
      </td>
    </tr> 
    <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo17']; ?>
</td>
     <td class="der-color">
       <input type="text" name="otro_caracter" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['otro_caracter']; ?>
' size="85" maxlength="50">
     </td>
    </tr>
    <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo18']; ?>
</td>
     <td class="der-color">
       <textarea rows="2" name="prueba_repres" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="98" maxlength="150"><?php echo $this->_tpl_vars['prueba_repres']; ?>
</textarea>
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
     <td class="izq-color"><?php echo $this->_tpl_vars['campo19']; ?>
</td>
     <td class="der-color">
       <input type="text" name="n_ejemplares" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['n_ejemplares']; ?>
' size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
       &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo20']; ?>
&nbsp;&nbsp;
       <input type="text" name="tipo_soporte" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['tipo_soporte']; ?>
' size="25" maxlength="25">
     </td>
   </tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo21']; ?>
</td>
     <td class="der-color">
       <textarea rows="3" name="observacion" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="90" maxlength="300"><?php echo $this->_tpl_vars['observacion']; ?>
</textarea>
     </td>
   </tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo22']; ?>
</td>
     <td class="der-color">
       <?php echo smarty_function_html_radios(array('name' => 'hojas_adicio','values' => $this->_tpl_vars['tipo_hadic'],'selected' => $this->_tpl_vars['hojas_adicio'],'output' => $this->_tpl_vars['hadic_def'],'separator' => ""), $this);?>

       &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo23']; ?>
&nbsp;&nbsp;
       <input type="text" name="n_hojas_adic" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['n_hojas_adic']; ?>
' size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
     </td>
   </tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo24']; ?>
</td>
     <td class="der-color">
       <textarea rows="4" name="datos_ampli" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="90" maxlength="300"><?php echo $this->_tpl_vars['datos_ampli']; ?>
</textarea>
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
	     <textarea rows="11" name="datos_adicio" <?php echo $this->_tpl_vars['modo1']; ?>
 cols="165"><?php echo $this->_tpl_vars['datos_adicio']; ?>
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