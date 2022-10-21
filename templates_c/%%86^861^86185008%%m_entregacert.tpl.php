<?php /* Smarty version 2.6.8, created on 2022-05-06 14:56:42
         compiled from m_entregacert.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_entregacert.tpl', 67, false),)), $this); ?>
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
  <form name="forlotes" enctype="multipart/form-data" action="m_entregacert.php?vopc=5"  method="POST" >  
<?php endif; ?> 		  
<?php if ($this->_tpl_vars['vopc'] == 4): ?>
  <form name="forlotes" enctype="multipart/form-data" action="m_entregacert.php?vopc=1"  method="POST" >  
<?php endif; ?> 		  
<?php if ($this->_tpl_vars['vopc'] == 6): ?>
  <form name="forlotes" enctype="multipart/form-data" action="m_entregacert.php?vopc=7"  method="POST" >  
<?php endif; ?> 		  

  <table>
     <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	      <input tabindex="1" type="text" name="nctrlcer" size="5" maxlength="5" value='<?php echo $this->_tpl_vars['nctrlcer']; ?>
' <?php echo $this->_tpl_vars['modo3']; ?>
> 
      </td>
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
      <td class="cnt">
        &nbsp;&nbsp;<input type="image" src="../imagenes/folder_add_f2.png" width="32" height="24" value="Nueva Solicitud">Nueva Solicitud
        </form>
      </td>
      <?php endif; ?> 		  
      <?php if ($this->_tpl_vars['vopc'] == 4 || $this->_tpl_vars['vopc'] == 6): ?>
        <td class="cnt">
          &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/boton_buscar_rojo.png" value="Buscar">  
        </td>
      <?php endif; ?>    
  </tr>
  </table>
  <br />
</form>				  

<br>
<?php if ($this->_tpl_vars['vopc'] == 1 || $this->_tpl_vars['vopc'] == 5): ?>
  <form name="forlotes" enctype="multipart/form-data" action="m_entregacert.php?vopc=2"  method="POST" onsubmit='return pregunta();'>
<?php endif; ?>    
<!-- <form name="forlotes" enctype="multipart/form-data" action="m_controlcert.php?vopc=2"  method="POST" > -->
   <input type="hidden" name="usuario" value='<?php echo $this->_tpl_vars['usuario']; ?>
'>
   <input type="hidden" name="nctrlcer" value='<?php echo $this->_tpl_vars['nctrlcer']; ?>
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
        <select size="1" name="tipo" value='<?php echo $this->_tpl_vars['tipo']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayltipo'],'selected' => $this->_tpl_vars['tipo'],'output' => $this->_tpl_vars['arraydtipo']), $this);?>

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
	      <input type="text" name="cisolicita" <?php echo $this->_tpl_vars['modo']; ?>
 size="10" maxlength="10" value='<?php echo $this->_tpl_vars['cisolicita']; ?>
'>
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
        <?php if ($this->_tpl_vars['gestor_pn'] == 'X'): ?>
          <input type="checkbox" name="gestor_pn" checked="checked" disabled>Persona Natural Titular&nbsp;&nbsp;<br/>
        <?php else: ?>  
          <input type="checkbox" name="gestor_pn" disabled>Persona Natural Titular&nbsp;&nbsp;<br/>
        <?php endif; ?>  
        <?php if ($this->_tpl_vars['gestor_pj'] == 'X'): ?>
          <input type="checkbox" name="gestor_pj" checked="checked" disabled>Rep. Persona Jur&iacute;dica Nacional&nbsp;&nbsp;<br/>
        <?php else: ?>  
          <input type="checkbox" name="gestor_pj" disabled>Rep. Persona Jur&iacute;dica Nacional&nbsp;&nbsp;<br/>
        <?php endif; ?>  
        <?php if ($this->_tpl_vars['gestor_ap'] == 'X'): ?>
          <input type="checkbox" name="gestor_ap" checked="checked" disabled>Apoderado&nbsp;&nbsp;<br/>
        <?php else: ?>  
          <input type="checkbox" name="gestor_ap" disabled>Apoderado&nbsp;&nbsp;<br/>
        <?php endif; ?>  
        <?php if ($this->_tpl_vars['gestor_ag'] == 'X'): ?>
          <input type="checkbox" name="gestor_ag" checked="checked" disabled>Agente de la Propiedad Industrial No.&nbsp;&nbsp;
        <?php else: ?>  
          <input type="checkbox" name="gestor_ag" disabled>Agente de la Propiedad Industrial No.&nbsp;&nbsp;
        <?php endif; ?>  
        <input type="text" name='agente' size='6' maxlength="6" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['agente']; ?>
'><br/> 
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
        <select size="1" name="indaut" value='<?php echo $this->_tpl_vars['indaut']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
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
	      <input type="text" name="ciautorizado" <?php echo $this->_tpl_vars['modo']; ?>
 size="10" maxlength="10" value='<?php echo $this->_tpl_vars['ciautorizado']; ?>
'>
       </td>
     </tr>
    </table> -->

   <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="m_verautoriza.php?pcod=<?php echo $this->_tpl_vars['nctrlcer']; ?>
"></iframe> 
    </td></tr>  
   </table>

   &nbsp; <p></p>
   &nbsp;
    <table width="70%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="3"><?php echo $this->_tpl_vars['campo3']; ?>
</td><td></td><td></td></tr>
    <tr><td>    

	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa1" <?php echo $this->_tpl_vars['modo2']; ?>
></td><td class="izq-color" width="10%"><?php echo $this->_tpl_vars['codcausa'][0]; ?>
</td><td class="der-color" width="87%"><?php echo $this->_tpl_vars['descausa'][0]; ?>
</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa2" <?php echo $this->_tpl_vars['modo2']; ?>
></td><td class="izq-color" width="10%"><?php echo $this->_tpl_vars['codcausa'][1]; ?>
</td><td class="der-color" width="87%"><?php echo $this->_tpl_vars['descausa'][1]; ?>
</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa3" <?php echo $this->_tpl_vars['modo2']; ?>
></td><td class="izq-color" width="10%"><?php echo $this->_tpl_vars['codcausa'][2]; ?>
</td><td class="der-color" width="87%"><?php echo $this->_tpl_vars['descausa'][2]; ?>
</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa4" <?php echo $this->_tpl_vars['modo2']; ?>
></td><td class="izq-color" width="10%"><?php echo $this->_tpl_vars['codcausa'][3]; ?>
</td><td class="der-color" width="87%"><?php echo $this->_tpl_vars['descausa'][3]; ?>
</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa5" <?php echo $this->_tpl_vars['modo2']; ?>
></td><td class="izq-color" width="10%"><?php echo $this->_tpl_vars['codcausa'][4]; ?>
</td><td class="der-color" width="87%"><?php echo $this->_tpl_vars['descausa'][4]; ?>
</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa6" <?php echo $this->_tpl_vars['modo2']; ?>
></td><td class="izq-color" width="10%"><?php echo $this->_tpl_vars['codcausa'][5]; ?>
</td><td class="der-color" width="87%"><?php echo $this->_tpl_vars['descausa'][5]; ?>
</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa7" <?php echo $this->_tpl_vars['modo2']; ?>
></td><td class="izq-color" width="10%"><?php echo $this->_tpl_vars['codcausa'][6]; ?>
</td><td class="der-color" width="87%"><?php echo $this->_tpl_vars['descausa'][6]; ?>
</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa8" <?php echo $this->_tpl_vars['modo2']; ?>
></td><td class="izq-color" width="10%"><?php echo $this->_tpl_vars['codcausa'][7]; ?>
</td><td class="der-color" width="87%"><?php echo $this->_tpl_vars['descausa'][7]; ?>
</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa9" <?php echo $this->_tpl_vars['modo2']; ?>
></td><td class="izq-color" width="10%"><?php echo $this->_tpl_vars['codcausa'][8]; ?>
</td><td class="der-color" width="87%"><?php echo $this->_tpl_vars['descausa'][8]; ?>
</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa10" <?php echo $this->_tpl_vars['modo2']; ?>
></td><td class="izq-color" width="10%"><?php echo $this->_tpl_vars['codcausa'][9]; ?>
</td><td class="der-color" width="87%"><?php echo $this->_tpl_vars['descausa'][9]; ?>
</td>
	</tr>
    <!-- <?php if ($this->_tpl_vars['descausa'][11] != ''): ?>
	   <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][23]; ?>
</td><td class="der-color"><input type="checkbox" name="causa24"></td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][23]; ?>
</td>
	 <?php endif; ?> --> 
    </td></tr>
    </table>
    
   &nbsp;
   <table width="180">
    <tr>
     <tr>
      <td class="cnt"><input type="image" <?php echo $this->_tpl_vars['modo']; ?>
 src="../imagenes/boton_procesar_rojo.png"></td> 
      <td class="cnt"><a href="m_entregacert.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
    </tr>
   </table>
</form>

</div>  
</body>
</html>