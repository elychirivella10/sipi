<?php /* Smarty version 2.6.8, created on 2020-10-28 21:44:22
         compiled from p_manlpi55_cualquierestatus.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'p_manlpi55_cualquierestatus.tpl', 63, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas1" action="p_manlpi55_cualquierestatus.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
>
  <input type ='hidden' name='invnac' value=<?php echo $this->_tpl_vars['invnac']; ?>
> 
  
  <table>
     <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      &nbsp;	 	     
      </td>	
      <td class="cnt">	 	
	 	<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="p_manlpi55_cualquierestatus.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='dirano' value=<?php echo $this->_tpl_vars['dirano']; ?>
>
  <input type='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type='hidden' name='vsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
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
  <input type='hidden' name='nroinv' value=<?php echo $this->_tpl_vars['nroinv']; ?>
>
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'> 

  <table cellspacing="1" border="1">
  <!--<tr>-->
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' size="10" maxlength="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" ></td>
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
        <input name="ubicacion" <?php echo $this->_tpl_vars['modo2']; ?>
 type="file"  value='<?php echo $this->_tpl_vars['ubicacion']; ?>
' size="28" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='<?php echo $this->_tpl_vars['nameimage']; ?>
' id="picture" width="270" height="272" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="200" onkeyup="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color" >
	     <textarea rows="13" name="resumen" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="8000" onkeyup="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['resumen']; ?>
</textarea>
      </td>
    </tr> 
<!--    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color" colspan="2"> -->
        <input type="hidden" name="input2" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['pais_resid']; ?>
' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.distingue)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">-
        <select size="1" name="pais" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraycodpais'],'selected' => $this->_tpl_vars['pais_resid'],'output' => $this->_tpl_vars['arraynompais']), $this);?>

        </select>
<!--      </td>
    </tr> -->
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo13']; ?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="tramitante" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['tramitante']; ?>
' size="50" maxlength="40" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
        &nbsp;&nbsp;&nbsp;&nbsp;Poder No.&nbsp;&nbsp;&nbsp; 
        <input type="text" name="vpod1" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vpod1']; ?>
' align="right" size="3" maxlength="4" onchange="Rellena(document.formarcas.vpod1,2)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas2.vpod2)">-
        <input type="text" name="vpod2" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vpod2']; ?>
' align="right" size="4" maxlength="5" onchange="Rellena(document.formarcas.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas2.agen_id)">

      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo18']; ?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="anualidad" '<?php echo $this->_tpl_vars['vmodo']; ?>
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
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2">
      </td>
    </tr>
  </table>
 
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
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo9']; ?>
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

  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo16']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_vercip.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vcip" <?php echo $this->_tpl_vars['modo']; ?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vcipe" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsecip(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vcip,document.formarcas2.vcipe)"> 
        <br>
    </td></tr> 
  </table>
  &nbsp;

  &nbsp;
  <table width="250" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <a href="p_manlpi55_cualquierestatus.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
    </td>      
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>
  
</form>
</div>  

</body>
</html>