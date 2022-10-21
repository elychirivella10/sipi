<?php /* Smarty version 2.6.8, created on 2020-11-16 11:01:35
         compiled from m_ingresol.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_ingresol.tpl', 77, false),array('modifier', 'truncate', 'm_ingresol.tpl', 137, false),)), $this); ?>
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
<form name="formarcas1" action="m_ingresol.php?vopc=4" method="POST">
<?php endif; ?>
  <input type='hidden' name='conx' value='<?php echo $this->_tpl_vars['conx']; ?>
'>  
  <input type='hidden' name='salir' value='<?php echo $this->_tpl_vars['salir']; ?>
'>

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
        <!-- &nbsp;<input type="submit" value=" Nueva Solicitud " class="boton_blue"> -->
        &nbsp;<input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
      </form>
      <?php endif; ?> 		  
      </td>
    </tr>
  </tr>
  </table>

&nbsp;	 	     
<form name="formarcas2" enctype="multipart/form-data" action="m_ingresol.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='dirano' value=<?php echo $this->_tpl_vars['dirano']; ?>
>
  <input type='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type='hidden' name='vsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
>
  <input type='hidden' name='vsol1a' value=<?php echo $this->_tpl_vars['vsol1a']; ?>
>
  <input type='hidden' name='vsol2a' value=<?php echo $this->_tpl_vars['vsol2a']; ?>
>
  <input type='hidden' name='vstring' value='<?php echo $this->_tpl_vars['vstring']; ?>
'>
  <input type='hidden' name='vstring1' value='<?php echo $this->_tpl_vars['vstring1']; ?>
'>
  <input type='hidden' name='vstring2' value='<?php echo $this->_tpl_vars['vstring2']; ?>
'>
  <input type='hidden' name='campos' value='<?php echo $this->_tpl_vars['campos']; ?>
'>
  <input type='hidden' name='modo' value=<?php echo $this->_tpl_vars['vmodo']; ?>
>
  <input type='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type='hidden' name='auxnum' value=<?php echo $this->_tpl_vars['auxnum']; ?>
>
  <input type='hidden' name='vclase' value=<?php echo $this->_tpl_vars['vclase']; ?>
>
  <input type='hidden' name='varsol' value=<?php echo $this->_tpl_vars['varsol']; ?>
>
  <input type='hidden' name='vcodpais' value=<?php echo $this->_tpl_vars['vcodpais']; ?>
>
  <input type='hidden' name='vcodage' value=<?php echo $this->_tpl_vars['vcodage']; ?>
>
  <input type='hidden' name='psoli' value=<?php echo $this->_tpl_vars['psoli']; ?>
>
  <input type='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
>
  <input type='hidden' name='conx' value='<?php echo $this->_tpl_vars['conx']; ?>
'>  
  <input type='hidden' name='salir' value='<?php echo $this->_tpl_vars['salir']; ?>
'>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' size="10" align="left" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
      <td class="izq3-color" ><?php echo $this->_tpl_vars['campo15']; ?>
</td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="habilema(document.formarcas2.tipo_marca,document.formarcas2.vsol3,document.formarcas2.vsol4,document.formarcas2.vreg1d,document.formarcas2.vreg2d)" >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['tipo_marca'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>

      <!-- <td class="der-color" rowspan="9" valign="top">
        <input name="ubicacion" type="file" value='<?php echo $this->_tpl_vars['ubicacion']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size="27" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='<?php echo $this->_tpl_vars['nameimage']; ?>
' id="picture" width="270" height="264" alt="vista previa"/></br>
      </td> -->

      <td class="der-color" rowspan="9" valign="top">

        <table width="100%" cellspacing="1" border="1">
          <tr><td>
            <iframe id='top' style='width:100%;height:250px;background-color: WHITE;' src="../comun/z_verimagen.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe> 
          </td></tr>  
        </table>
        <?php echo $this->_tpl_vars['campo23']; ?>

        <input type="text" name="planilla" size="5" maxlength="6" <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.buscarimg)">&nbsp;
        <input type="button" class="boton_blue" <?php echo $this->_tpl_vars['modo2']; ?>
 value="Buscar" name="buscarimg" onclick="buscarimagen(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.planilla)">
        <input type="button" class="boton_blue" <?php echo $this->_tpl_vars['modo2']; ?>
 value="Eliminar" name="eliminaimg" onclick="limpiarplan(document.formarcas2.planilla);limpiarimagen(document.formarcas2.vsol1,document.formarcas2.vsol2)"">
      </td>

    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo16']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo21']; ?>

        <input type="text" name="vsol3" size="4" maxlength="4" value='<?php echo $this->_tpl_vars['vsol3']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol4)" onchange="Rellena(document.formarcas2.vsol3,4)">-	
        <input type="text" name="vsol4" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol4']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vreg1d)" onchange="Rellena(document.formarcas2.vsol4,6)">&nbsp;&nbsp; o 
        <?php echo $this->_tpl_vars['campo22']; ?>

        <input type="text" name="vreg1d" size="1" maxlength="1" value='<?php echo $this->_tpl_vars['vreg1d']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
        <input type="text" name="vreg2d" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vreg2d']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.nombre)" onchange="Rellena(document.formarcas2.vreg2d,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" <?php echo $this->_tpl_vars['modo']; ?>
 cols="52" maxlength="200" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <select size="1" name="modalidad" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="habilitar(document.formarcas2.modalidad,document.formarcas2.nombre,document.formarcas2.etiqueta,document.formarcas2.vviena,document.formarcas2.vvienai,document.formarcas2.vvienae,document.formarcas2.ubicacion)">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvmodal'],'selected' => $this->_tpl_vars['modalidad'],'output' => $this->_tpl_vars['arraytmodal']), $this);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><b><?php echo $this->_tpl_vars['campo9']; ?>
</b></td>
      <td class="der-color">
         <textarea rows="6" name="etiqueta" <?php echo $this->_tpl_vars['modo']; ?>
 cols="52" maxlength="6000" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['etiqueta']; ?>
</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
       <?php if ($this->_tpl_vars['accion'] == 2): ?>
        <select size="1" name="options" <?php echo $this->_tpl_vars['modo3']; ?>
  onchange="this.form.distingue.value=this.options[this.selectedIndex].value">
        <!-- <select size="1" name="options" <?php echo $this->_tpl_vars['modo3']; ?>
 > -->
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vnomclase'],'output' => ((is_array($_tmp=$this->_tpl_vars['vnomclase'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 56) : smarty_modifier_truncate($_tmp, 56))), $this);?>

        </select>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['accion'] != 2): ?>
          <input type="text" name="vclase" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" >
        <?php endif; ?>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo20']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vclnac" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vclnac']; ?>
' size="1" maxlength="2" >
        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo21']; ?>
&nbsp;&nbsp;
        <input type="text" name="planilla" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['planilla']; ?>
' size="5" maxlength="6" > -->
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><b><?php echo $this->_tpl_vars['campo8']; ?>
</b></td>
      <td class="der-color" colspan="2">
         <textarea rows="8" name="distingue" <?php echo $this->_tpl_vars['modo']; ?>
 cols="96" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['distingue']; ?>
</textarea>
      </td>
    </tr> 
<!--    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color" colspan="2"> -->
        <input type="hidden" name="input2" <?php echo $this->_tpl_vars['modo']; ?>
 value='VE' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.input1)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">-
<!--        <select size="1" name="pais" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraycodpais'],'selected' => $this->_tpl_vars['pais_resid'],'output' => $this->_tpl_vars['arraynompais']), $this);?>

        </select>
     </td>
    </tr>  -->
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo13']; ?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="tramitante" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['tramitante']; ?>
' size="50" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
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
      <td class="izq-color"></td>
      <td class="der-color" colspan="2"></td>
    </tr>
    <tr>
    </tr>
      
  </tr>
  </table></center>
  
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo12']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=M&tper=1"></iframe> 
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
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=M"></iframe> 
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
    
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo17']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=M"></iframe> 
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

    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2"><?php echo $this->_tpl_vars['campo14']; ?>
</td></tr>
    <tr><td>    
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="m_verccv.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" <?php echo $this->_tpl_vars['modo']; ?>
 size="11" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienai)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienae)">
    </td></tr>
    </table>
    &nbsp;

  <!-- <table align="center">
  <tr>
    <td class="cnt">
      <input type="submit" value=" GUARDAR " class="boton_azul"></td>
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
         <a href="m_ingresol.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><input type="button" value=" CANCELAR " class="boton_rojo"></a>
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 4): ?>
         <a href="m_ingresol.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><input type="button" value=" CANCELAR " class="boton_rojo"></a>
      <?php endif; ?>    
    </td>      
    <td class="cnt">
      <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><input type="button" value=" SALIR " class="boton_azul"></td></a>
    </td>
  </tr>
  </table>-->

  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
         <a href="m_ingresol.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 4): ?>
         <a href="m_ingresol.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
    </td>      
    <td class="cnt">
         <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>




</form>
</div>  

</body>
</html>