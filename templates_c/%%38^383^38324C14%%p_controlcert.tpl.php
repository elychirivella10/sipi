<?php /* Smarty version 2.6.8, created on 2022-05-09 10:29:40
         compiled from p_controlcert.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'p_controlcert.tpl', 68, false),)), $this); ?>
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
  <form name="forlotes" enctype="multipart/form-data" action="p_controlcert.php?vopc=5"  method="POST" >  
<?php endif; ?> 		  
<?php if ($this->_tpl_vars['vopc'] == 4): ?>
  <form name="forlotes" enctype="multipart/form-data" action="p_controlcert.php?vopc=1"  method="POST" >  
<?php endif; ?> 		  
<?php if ($this->_tpl_vars['vopc'] == 6): ?>
  <form name="forlotes" enctype="multipart/form-data" action="p_controlcert.php?vopc=7"  method="POST" >  
<?php endif; ?> 		  

  <table>
     <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	      <input tabindex="1" type="text" name="nctrlcer" size="5" maxlength="5" value='<?php echo $this->_tpl_vars['nctrlcer']; ?>
' readonly > 
      </td>
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
      <td class="cnt">
        &nbsp;&nbsp;<input type="image" src="../imagenes/boton_nuevo_rojo.png">
        </form>
      </td>
      <?php endif; ?> 		  
      <?php if ($this->_tpl_vars['vopc'] == 4 || $this->_tpl_vars['vopc'] == 6): ?>
        <td class="cnt">
          &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/boton_buscar_rojo.png">
        </td>
      <?php endif; ?>    
  </tr>
  </table>
  <br />
</form>				  

<br>
<?php if ($this->_tpl_vars['vopc'] == 1 || $this->_tpl_vars['vopc'] == 5): ?>
  <form name="forlotes" enctype="multipart/form-data" action="p_controlcert.php?vopc=2"  method="POST" onsubmit='return pregunta();'>
<?php endif; ?>    
<!-- <form name="forlotes" enctype="multipart/form-data" action="m_controlcert.php?vopc=2"  method="POST" > -->
   <input type="hidden" name="usuario" value='<?php echo $this->_tpl_vars['usuario']; ?>
'>
   <input type="hidden" name="nctrlcer" value='<?php echo $this->_tpl_vars['nctrlcer']; ?>
'>
   <input type="hidden" name="direccion" value='<?php echo $this->_tpl_vars['direccion']; ?>
'>
     
   <table cellspacing="1" border="1">
   <tr>
     <!--<tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
       <td class="der-color" >
	      <input type="text" name="nctrlcer" size="5" maxlength="5" value='<?php echo $this->_tpl_vars['nctrlcer']; ?>
' readonly > 
       </td>
     </tr> -->

     <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <select size='1' name='tipo' <?php echo $this->_tpl_vars['modo1']; ?>
>
           <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipo'],'selected' => $this->_tpl_vars['tipo'],'output' => $this->_tpl_vars['arraytipo']), $this);?>

        </select>
      <td>
     </tr>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color" >
         <input type="text" name="fechaper" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fechaper']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forlotes.vpag)" onchange="valFecha(this,document.forlotes.vpag)" >
         &nbsp;
         <a href="javascript:showCal('Calendar65');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
    </tr>
    </table>

   &nbsp; <p></p>
   <font class='nota6'><b>SOLICITANTE:</b></font>
   &nbsp;
   <table cellspacing="1" border="1">
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
       <td class="der-color" >
	      <input type="text" name="solicitante" <?php echo $this->_tpl_vars['modo']; ?>
 size="70" maxlength="80" value='<?php echo $this->_tpl_vars['solicitante']; ?>
' onkeyup="this.value=this.value.toUpperCase()">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
       <td class="der-color" >
          <select size="1" name="lced" <?php echo $this->_tpl_vars['modo2']; ?>
>
            <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['lced_id'],'selected' => $this->_tpl_vars['lced'],'output' => $this->_tpl_vars['lced_de']), $this);?>

          </select>
	  <input type="text" name="cisolicita" <?php echo $this->_tpl_vars['modo']; ?>
 size="9" maxlength="9" value='<?php echo $this->_tpl_vars['cisolicita']; ?>
' onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.forlotes.cisolicita,9)" onkeyup="checkLength(event,this,9,document.forlotes.telefono)">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
       <td class="der-color" >
	      <input type="text" name="telefono" <?php echo $this->_tpl_vars['modo']; ?>
 size="15" maxlength="15" value='<?php echo $this->_tpl_vars['telefono']; ?>
'>
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo8']; ?>
</td>
       <td class="der-color" >
	      <input type="text" name="correo" <?php echo $this->_tpl_vars['modo']; ?>
 size="70" maxlength="80" value='<?php echo $this->_tpl_vars['correo']; ?>
'>
       </td>
     </tr>
    <!-- <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <select size="1" name="indole">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvind'],'selected' => $this->_tpl_vars['indole'],'output' => $this->_tpl_vars['arraytind']), $this);?>

        </select>
      </td>
    </tr> -->  
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <!-- <input type="checkbox" name="gestor_pn" <?php echo $this->_tpl_vars['modo']; ?>
 onClick="habilagen(document.forlotes.agente,this)">Persona Natural Titular&nbsp;&nbsp;<br/>
        <input type="checkbox" name="gestor_pj" <?php echo $this->_tpl_vars['modo']; ?>
 onClick="habilagen(document.forlotes.agente,this)">Rep. Persona Jur&iacute;dica Nacional&nbsp;&nbsp;<br/>  
        <input type="checkbox" name="gestor_ap" <?php echo $this->_tpl_vars['modo']; ?>
 onClick="habilagen(document.forlotes.agente,this)">Apoderado&nbsp;&nbsp;<br/>
        <input type="checkbox" name="gestor_ag" <?php echo $this->_tpl_vars['modo']; ?>
 value='A' onClick="habilagen(document.forlotes.agente,document.forlotes.gestor_ag)">Agente de la Propiedad Industrial No.&nbsp;&nbsp; -->
        <input type="checkbox" name="gestor_pn" <?php echo $this->_tpl_vars['modo']; ?>
 >Persona Natural Titular&nbsp;&nbsp;<br/>
        <input type="checkbox" name="gestor_pj" <?php echo $this->_tpl_vars['modo']; ?>
 >Rep. Persona Jur&iacute;dica Nacional&nbsp;&nbsp;<br/>  
        <input type="checkbox" name="gestor_ap" <?php echo $this->_tpl_vars['modo']; ?>
 >Apoderado&nbsp;&nbsp;<br/>
        <input type="checkbox" name="gestor_ag" <?php echo $this->_tpl_vars['modo']; ?>
 onclick="agent(document.forlotes.gestor_ag,document.forlotes.agente);">Agente de la Propiedad Industrial No.&nbsp;&nbsp;
        <input type="text" name='agente' size='6' maxlength="6" <?php echo $this->_tpl_vars['modo']; ?>
 onkeyup="checkLength(event,this,5,document.forlotes.indaut);fn(this.form,this);" onKeyPress="return acceptChar(event,2,this)"><br/> 
      </td>
    </tr> 
    </table>

   &nbsp; <p></p>
   <!-- <font class='nota6'><b>AUTORIZADO:</b></font>
   &nbsp;
   <table cellspacing="1" border="1">
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
        <select size="1" name="indaut" <?php echo $this->_tpl_vars['modo1']; ?>
>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvaut'],'selected' => $this->_tpl_vars['indaut'],'output' => $this->_tpl_vars['arraytaut']), $this);?>

        </select>
      </td>
     </tr> 
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
       <td class="der-color" >
	      <input type="text" name="autorizado" <?php echo $this->_tpl_vars['modo']; ?>
 size="70" maxlength="80" value='<?php echo $this->_tpl_vars['autorizado']; ?>
' onkeyup="this.value=this.value.toUpperCase()">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
       <td class="der-color" >
          <select size="1" name="lced1" <?php echo $this->_tpl_vars['modo2']; ?>
>
            <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['lced_id'],'selected' => $this->_tpl_vars['lced1'],'output' => $this->_tpl_vars['lced_de']), $this);?>

          </select>
	  <input type="text" name="ciautorizado" <?php echo $this->_tpl_vars['modo']; ?>
 size="9" maxlength="9" value='<?php echo $this->_tpl_vars['ciautorizado']; ?>
' onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.forlotes.ciautorizado,9)" onkeyup="checkLength(event,this,9,document.forlotes.vreg1)">

       </td>
     </tr>
    </table>
   &nbsp;  -->

   <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_verautoriza.php?pcod=<?php echo $this->_tpl_vars['nctrlcer']; ?>
"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
      &nbsp;<b><?php echo $this->_tpl_vars['campo10']; ?>
</b>
      <select size="1" id="indaut" name="indaut" <?php echo $this->_tpl_vars['modo1']; ?>
 onclick="aut(document.forlotes.indaut,document.forlotes.autorizado);">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvaut'],'selected' => $this->_tpl_vars['indaut'],'output' => $this->_tpl_vars['arraytaut']), $this);?>

      </select>&nbsp;&nbsp; <I>Nombre Autorizado:&nbsp;</I>
      <input type="text" name="autorizado" <?php echo $this->_tpl_vars['modo3']; ?>
 size="55" onChange="javascript:this.value=this.value.toUpperCase();">
      <input type="button" class="boton_blue" value="Limpiar" name="limpiar1" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="document.forlotes.autorizado.value='';"> 
      <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vauti" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseautoriza(document.forlotes.nctrlcer,document.forlotes.autorizado,document.forlotes.vauti)">
      <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vaute" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseautoriza(document.forlotes.nctrlcer,document.forlotes.autorizado,document.forlotes.vaute)"> 
      <br>
    </td></tr> 
   </table>

   &nbsp; <p></p>
   <!-- <font class='nota6'><b>Expedientes a Solicitar:</b></font> -->
   &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2"><?php echo $this->_tpl_vars['campo3']; ?>
</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:99%;height:180px;background-color: WHITE;' src="p_vercer.php?vcod=<?php echo $this->_tpl_vars['nctrlcer']; ?>
"></iframe> 
    </td></tr>
    <tr><td class="der-color"><b><I>N&uacute;mero Registro:&nbsp;</I></b>
        <input type="text" name="vreg1" <?php echo $this->_tpl_vars['modo']; ?>
 size="1" maxlength="1" value='<?php echo $this->_tpl_vars['vreg1']; ?>
' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forlotes.vreg2)" 
		    onchange="this.value=this.value.toUpperCase();document.forlotes.vreg1.value=this.value;">-
	     <input type="text" name="vreg2" <?php echo $this->_tpl_vars['modo']; ?>
 size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vreg2']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vvienai1)"  
		    onchange="Rellena(document.forlotes.vreg2,6);document.forlotes.vreg2.value=this.value;">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="document.forlotes.vreg1.value='';document.forlotes.vreg2.value='';"> 
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="cntrlcertificado(document.forlotes.vreg1,document.forlotes.vreg2,document.forlotes.vvienai,document.forlotes.nctrlcer)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="cntrlcertificado(document.forlotes.vreg1,document.forlotes.vreg2,document.forlotes.vvienae,document.forlotes.nctrlcer)">  
    </td></tr>
    </table>
    
   &nbsp;
   <table width="180">
    <tr>
     <tr>
      <td class="cnt"><input type="image" <?php echo $this->_tpl_vars['modo']; ?>
 src="../imagenes/boton_guardar_rojo.png"></td> 
      <td class="cnt"><a href="p_controlcert.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
    </tr>
   </table>
</form>

</div>  
</body>
</html>