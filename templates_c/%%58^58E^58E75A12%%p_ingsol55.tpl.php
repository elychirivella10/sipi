<?php /* Smarty version 2.6.8, created on 2020-10-19 16:15:51
         compiled from p_ingsol55.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'p_ingsol55.tpl', 70, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<?php if ($this->_tpl_vars['vopc'] == 3): ?>
<form name="formarcas1" action="p_ingsol55.php?vopc=4" method="POST">
<?php endif; ?>
  <table>
  <tr> 
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="4" maxlength="4" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)" onBlur="valagente(document.formarcas1.vsol1,document.formarcas2.vsol1a)">-
        <input type="text" name="vsol2" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)" onBlur="valagente(document.formarcas1.vsol2,document.formarcas2.vsol2a)">
        </td>	
      <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
      &nbsp;<input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
      </form>
      <?php endif; ?> 		  
      </td>
    </tr>
  </tr>
  </table>

&nbsp;	 	     
<form name="formarcas2" enctype="multipart/form-data" action="p_ingsol55.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='dirano' value=<?php echo $this->_tpl_vars['dirano']; ?>
>
  <input type ='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type ='hidden' name='vsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
>
  <input type ='hidden' name='vsol1a' value=<?php echo $this->_tpl_vars['vsol1a']; ?>
>
  <input type ='hidden' name='vsol2a' value=<?php echo $this->_tpl_vars['vsol2a']; ?>
>
  <input type ='hidden' name='vstring' value='<?php echo $this->_tpl_vars['vstring']; ?>
'>
  <input type ='hidden' name='vstring1' value='<?php echo $this->_tpl_vars['vstring1']; ?>
'>
  <input type ='hidden' name='vstring2' value='<?php echo $this->_tpl_vars['vstring2']; ?>
'>
  <input type ='hidden' name='campos' value='<?php echo $this->_tpl_vars['campos']; ?>
'>
  <input type ='hidden' name='modo' value=<?php echo $this->_tpl_vars['vmodo']; ?>
>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='auxnum' value=<?php echo $this->_tpl_vars['auxnum']; ?>
>
  <input type ='hidden' name='varsol' value=<?php echo $this->_tpl_vars['varsol']; ?>
>
  <input type ='hidden' name='vcodpais' value=<?php echo $this->_tpl_vars['vcodpais']; ?>
>
  <input type ='hidden' name='vcodage' value=<?php echo $this->_tpl_vars['vcodage']; ?>
>
  <input type ='hidden' name='psoli' value=<?php echo $this->_tpl_vars['psoli']; ?>
>
  <input type ='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' size="10" align="left" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_paten)" onchange="valFecha(this,document.formarcas2.tipo_paten)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
      <td class="izq3-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_paten" <?php echo $this->_tpl_vars['modo2']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['tipo_paten'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
      <td class="der-color" rowspan="3" valign="top">
        <input name="ubicacion" type="file" value='<?php echo $this->_tpl_vars['ubicacion']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='<?php echo $this->_tpl_vars['nameimage']; ?>
' id="picture" width="270" height="300" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="200" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color" >
         <textarea rows="14" name="resumen" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="8000" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['resumen']; ?>
</textarea>
      </td>
    </tr> 
<!--    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color" colspan="2"> -->
        <input type="hidden" name="input2" <?php echo $this->_tpl_vars['modo']; ?>
 value='VE' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.input1)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">
<!--        -<select size="1" name="pais" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraycodpais'],'selected' => $this->_tpl_vars['pais_resid'],'output' => $this->_tpl_vars['arraynompais']), $this);?>

        </select>
      </td>
    </tr> -->

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo13']; ?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="tramitante" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['tramitante']; ?>
' size="56" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
        &nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo11']; ?>
&nbsp;
        <input type="text" name="vpod1" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vpod1']; ?>
' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
        <input type="text" name="vpod2" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vpod2']; ?>
' align="left" size="4" maxlength="5" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.tramitante)">
      </td>
    </tr> 
    
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="locarno1" '<?php echo $this->_tpl_vars['modo']; ?>
' value='<?php echo $this->_tpl_vars['locarno1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.locarno2)">-
        <input type="text" name="locarno2" '<?php echo $this->_tpl_vars['modo']; ?>
' value='<?php echo $this->_tpl_vars['locarno2']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.edicion)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo18']; ?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="anualidad" '<?php echo $this->_tpl_vars['modo1']; ?>
' value='<?php echo $this->_tpl_vars['anualidad']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.planilla)">
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo19']; ?>
&nbsp;
        <input type="text" name="planilla" '<?php echo $this->_tpl_vars['modo']; ?>
' value='<?php echo $this->_tpl_vars['planilla']; ?>
' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas2.tasa)">
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo20']; ?>
&nbsp;
        <input type="text" name="tasa" '<?php echo $this->_tpl_vars['modo']; ?>
' value='<?php echo $this->_tpl_vars['tasa']; ?>
' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas2.monto)">
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo21']; ?>
&nbsp;
        <input type="text" name="monto" '<?php echo $this->_tpl_vars['modo']; ?>
' value='<?php echo $this->_tpl_vars['monto']; ?>
' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas2.vagent)">
      </td>
    </tr>

    <tr>
    </tr>

  </tr>
  </table></center>

    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo12']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=P&tper=1"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vagent" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vageni" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vageni)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vagene" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vagene)"> 
        <br>
    </td></tr> 
    </table>
  
    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitui)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitue)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;
    
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo17']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vprior" <?php echo $this->_tpl_vars['modo']; ?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return acceptChar(event,12, this)">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;

    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_verinven.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vinv" <?php echo $this->_tpl_vars['modo']; ?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vinvi" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseinventorp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vinv,document.formarcas2.vinvi)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vinve" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseinventorp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vinv,document.formarcas2.vinve)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;

    
  <table cellspacing="1" border="1">
	 <tr>
	 </tr>
	 <tr>
	 </tr>
	 <tr>
	 </tr>
    <tr>
    </tr>
    <tr>
      <td class="izq4-color"><?php echo $this->_tpl_vars['campo16']; ?>
</td>
      <td class="der1-color">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clasificaci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clasificaci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo&nbsp;
      </td>
    </tr>
	 <tr>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        1.&nbsp;<input type="text" name="c1l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c1l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c1n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c1n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c1n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c1l2)">
          <input type="text" name="c1l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c1l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c1n2)" onChange="this.value=this.value.toUpperCase()" >
          <input type="text" name="c1n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c1n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c1n3)"> /
          <input type="text" name="c1n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c1n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t1)"> -
          <input type="text" name="t1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c2l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        2.&nbsp;<input type="text" name="c2l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c2l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas2.c2n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c2n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c2l2)">
          <input type="text" name="c2l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c2l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c2n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c2n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c2n3)"> /
          <input type="text" name="c2n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c2n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t2)"> -
          <input type="text" name="t2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c3l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        3.&nbsp;<input type="text" name="c3l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c3l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c3n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c3n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c3l2)">
          <input type="text" name="c3l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c3l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c3n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c3n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c3n3)"> /
          <input type="text" name="c3n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c3n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t3)"> -
          <input type="text" name="t3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t3']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c4l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        4.&nbsp;<input type="text" name="c4l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c4l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c4n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c4n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c4l2)">
          <input type="text" name="c4l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c4l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c4n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c4n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c4n3)"> /
          <input type="text" name="c4n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c4n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t4)"> -
          <input type="text" name="t4" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t4']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c5l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        5.&nbsp;<input type="text" name="c5l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c5l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c5n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c5n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c5l2)">
          <input type="text" name="c5l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c5l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c5n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c5n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c5n3)"> /
          <input type="text" name="c5n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c5n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t5)"> -
          <input type="text" name="t5" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t5']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c6l1)" >&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        6.&nbsp;<input type="text" name="c6l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c6l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c6n1)">
          <input type="text" name="c6n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c6n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c6l2)">
          <input type="text" name="c6l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c6l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c6n2)">
          <input type="text" name="c6n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c6n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c6n3)"> /
          <input type="text" name="c6n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c6n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t6)"> -
          <input type="text" name="t6" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t6']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c7l1)" >&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        7.&nbsp;<input type="text" name="c7l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c7l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c7n1)">
          <input type="text" name="c7n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c7n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c7l2)">
          <input type="text" name="c7l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c7l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c7n2)">
          <input type="text" name="c7n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c7n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c7n3)"> /
          <input type="text" name="c7n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c7n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t7)"> -
          <input type="text" name="t7" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t7']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c8l1)" >&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        8.&nbsp;<input type="text" name="c8l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c8l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c8n1)">
          <input type="text" name="c8n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c8n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c8l2)">
          <input type="text" name="c8l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c8l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c8n2)">
          <input type="text" name="c8n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c8n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c8n3)"> /
          <input type="text" name="c8n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c8n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t8)"> -
          <input type="text" name="t8" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t8']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c9l1)" >&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        9.&nbsp;<input type="text" name="c9l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c9l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c9n1)">
          <input type="text" name="c9n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c9n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c9l2)">
          <input type="text" name="c9l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c9l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c9n2)">
          <input type="text" name="c9n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c9n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c9n3)"> /
          <input type="text" name="c9n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c9n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t9)"> -
          <input type="text" name="t9" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t9']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c10l1)" >&nbsp;&nbsp; 
        &nbsp;
       10.&nbsp;<input type="text" name="c10l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c10l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c10n1)">
          <input type="text" name="c10n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c10n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c10l2)">
          <input type="text" name="c10l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c10l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c10n2)">
          <input type="text" name="c10n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c10n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c10n3)"> /
          <input type="text" name="c10n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c10n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t10)"> -
          <input type="text" name="t10" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t10']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c11l1)" >&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;
       11.&nbsp;<input type="text" name="c11l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c11l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c11n1)">
          <input type="text" name="c11n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c11n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c11l2)">
          <input type="text" name="c11l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c11l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c11n2)">
          <input type="text" name="c11n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c11n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c11n3)"> /
          <input type="text" name="c11n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c11n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t11)"> -
          <input type="text" name="t11" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t11']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c12l1)" >&nbsp;&nbsp; 
        &nbsp;
       12.&nbsp;<input type="text" name="c12l1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c12l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c12n1)">
          <input type="text" name="c12n1" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c12n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c12l2)">
          <input type="text" name="c12l2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c12l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c12n2)">
          <input type="text" name="c12n2" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c12n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c12n3)"> /
          <input type="text" name="c12n3" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c12n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t12)"> -
          <input type="text" name="t12" '<?php echo $this->_tpl_vars['modo']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t12']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.vinveni)" >&nbsp;&nbsp; 
      </td>
	 </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo15']; ?>
</td>
      <td class="der-color" colspan="2" >
        <input type="text" name="edicion" '<?php echo $this->_tpl_vars['modo']; ?>
' value='<?php echo $this->_tpl_vars['edicion']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.vnprior)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"></td>
      <td class="der-color"></td>
    </tr>  
  </table>
  &nbsp;&nbsp;
  <table width="230" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
         <a href="p_ingsol55.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 4): ?>
         <a href="p_ingsol55.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
    </td>      
    <td class="cnt">
         <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

</form>
</div>  
</body>
</html>