<?php /* Smarty version 2.6.8, created on 2021-10-08 09:17:37
         compiled from z_consrole.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'wordwrap', 'z_consrole.tpl', 78, false),)), $this); ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
    <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
    <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../include/template_css.css" type="text/css" />   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  <div align="center">

<form name="frmconsunid" action="z_consrole.php?vtip=2" method="POST" >
  <input type="hidden" name="vrol" value='<?php echo $this->_tpl_vars['vrol']; ?>
'>
  <input type="hidden" name="n_conex" value='<?php echo $this->_tpl_vars['na_conex']; ?>
'>
  
<table>
<tr>

 <table>
 <tr>
   <td width="100%">
     <div><strong> </strong></div>
   </td>
   <td >
     <table>
      <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>
         <?php if ($this->_tpl_vars['vmodal'] == 2): ?>
            <?php if ($this->_tpl_vars['vopm'] == 'RO'): ?>
              <a href="../comun/z_roles.php?conx=1&na_conex=<?php echo $this->_tpl_vars['na_conex']; ?>
&nconex=0&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir
            <?php endif; ?>
            <?php if ($this->_tpl_vars['vopm'] == 'ER'): ?>
              <a href="../comun/z_evenrol.php?conx=1&na_conex=<?php echo $this->_tpl_vars['na_conex']; ?>
&nconex=0&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir
            <?php endif; ?>
            <?php if ($this->_tpl_vars['vopm'] == 'AR'): ?>
              <a href="../comun/z_asigrol.php?conx=1&na_conex=<?php echo $this->_tpl_vars['na_conex']; ?>
&nconex=0&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir
            <?php endif; ?>
         <?php endif; ?>
         <?php if ($this->_tpl_vars['vmodal'] == 1): ?>
            <input type="image" name="salir" value="Salir" onclick="window.close()" src="../imagenes/salir_f2.png" alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;
         <?php endif; ?>
       </td>
       <td>&nbsp;</td>
      </tr>
     </table>
   </td>
 </tr>
 </table>

 <div class="tab-page" id="modules-cpanel">
  <script type="text/javascript">
     var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
  </script>

  <div class="tab-page" id="module01"><h2 class="tab">B&aacute;sico</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module01" ) );
  </script>
  
  <table width="100%" border="3" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
     <td class="der-color" width="65%">
       <input type="text" name="vrol" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vrol']; ?>
' size="9" maxlength="8">
       <b>&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo2']; ?>
&nbsp;&nbsp;</b>
       <input type="text" name='vrole' value='<?php echo $this->_tpl_vars['vrole']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="38" maxlength="80">
       <b>&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo3']; ?>
&nbsp;&nbsp;</b>
       <input type="text" name='vcreacion' value='<?php echo $this->_tpl_vars['vcreacion']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="22">
     </td>
     <td class="der-color" align="top">
       <b><?php echo $this->_tpl_vars['campo4']; ?>
&nbsp;</b>
       <?php echo ((is_array($_tmp=$this->_tpl_vars['vdescripcion'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 25, "\n", true) : smarty_modifier_wordwrap($_tmp, 25, "\n", true)); ?>

     </td>
   </tr>
  </tr> 
  </table>

  <table class="adminlist">
	<tr class="row0">
		<th width="5%" class="title">
			ID
		</th>
		<th width="9%" class="title">
			Cedula
		</th>
		<th width="30%" class="title">
			Nombre
		</th>
		<th width="12%" class="title" nowrap="nowrap">
			Login
		</th>
		<th width="12%" class="title" nowrap="nowrap">
		   Unidad
		</th>
		<th width="5%" class="title" nowrap="nowrap">
		   Estatus
		</th>
		<th width="15%" class="title" nowrap="nowrap">
		   Ingreso
		</th>
		<th width="10%" class="title" nowrap="nowrap">
		   Eliminaci&oacute;n
		</th>
		<th width="1%" class="title">
		   
		</th>
		<th width="1%" class="title">
		   
		</th>
	</tr>
	
   <p align='center'><b><font size='3' color='#CC0000' face='Tahoma'>Mostrando <?php echo $this->_tpl_vars['inicio']+1; ?>
-<?php echo $this->_tpl_vars['inicial']; ?>
 de <?php echo $this->_tpl_vars['total']; ?>
 Registros Encontrados </font></b></p>
   <?php unset($this->_sections['cont']);
$this->_sections['cont']['name'] = 'cont';
$this->_sections['cont']['loop'] = is_array($_loop=$this->_tpl_vars['vnumrows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cont']['show'] = true;
$this->_sections['cont']['max'] = $this->_sections['cont']['loop'];
$this->_sections['cont']['step'] = 1;
$this->_sections['cont']['start'] = $this->_sections['cont']['step'] > 0 ? 0 : $this->_sections['cont']['loop']-1;
if ($this->_sections['cont']['show']) {
    $this->_sections['cont']['total'] = $this->_sections['cont']['loop'];
    if ($this->_sections['cont']['total'] == 0)
        $this->_sections['cont']['show'] = false;
} else
    $this->_sections['cont']['total'] = 0;
if ($this->_sections['cont']['show']):

            for ($this->_sections['cont']['index'] = $this->_sections['cont']['start'], $this->_sections['cont']['iteration'] = 1;
                 $this->_sections['cont']['iteration'] <= $this->_sections['cont']['total'];
                 $this->_sections['cont']['index'] += $this->_sections['cont']['step'], $this->_sections['cont']['iteration']++):
$this->_sections['cont']['rownum'] = $this->_sections['cont']['iteration'];
$this->_sections['cont']['index_prev'] = $this->_sections['cont']['index'] - $this->_sections['cont']['step'];
$this->_sections['cont']['index_next'] = $this->_sections['cont']['index'] + $this->_sections['cont']['step'];
$this->_sections['cont']['first']      = ($this->_sections['cont']['iteration'] == 1);
$this->_sections['cont']['last']       = ($this->_sections['cont']['iteration'] == $this->_sections['cont']['total']);
?>
      <tr class="row0">
	   <td width="5%">
		<?php echo $this->_tpl_vars['arr_user1'][$this->_sections['cont']['index']]; ?>

		</a>		 
		</td>
		<td width="9%">
		<?php echo $this->_tpl_vars['arr_user2'][$this->_sections['cont']['index']]; ?>

		</a>		 
		</td>
		<td width="30%">
		<?php echo $this->_tpl_vars['arr_user3'][$this->_sections['cont']['index']]; ?>

		</td>
		<td width="12%" nowrap='nowrap'>
		<?php echo $this->_tpl_vars['arr_user4'][$this->_sections['cont']['index']]; ?>

		</td>
		<td width="12%" nowrap='nowrap'>
		<?php echo $this->_tpl_vars['arr_user5'][$this->_sections['cont']['index']]; ?>

		</a>		 
		</td>
		<td width="5%" nowrap='nowrap'>
      <?php if ($this->_tpl_vars['arr_user6'][$this->_sections['cont']['index']] == '1'): ?> 
          <img src="../imagenes/tick.png" border="0"> 
      <?php else: ?> 
          <img src="../imagenes/publish_x.png" border="0"> 
      <?php endif; ?> 
		</td>
		<td width="15%" nowrap='nowrap'>
		<?php echo $this->_tpl_vars['arr_user7'][$this->_sections['cont']['index']]; ?>

	   </td>
		<td width="10%" nowrap='nowrap'>
		<?php echo $this->_tpl_vars['arr_user8'][$this->_sections['cont']['index']]; ?>

		</td>
		<td width="1%">
		</td>
		<td width="1%">
		</td>
	   </tr>
   <?php endfor; endif; ?> 
   <input type='hidden' name='adelante'>
   <input type='hidden' name='atras'>

   <table>
    <div align="left">
    &nbsp;<img src="../imagenes/tick.png" border="0">&nbsp;Activo&nbsp;&nbsp;&nbsp;&nbsp;<img src="../imagenes/publish_x.png" border="0">&nbsp;Inactivo
    </div>
   </table>

   <table>
   <br />
   <tr>
   <input type="hidden" name="inicio" value='<?php echo $this->_tpl_vars['inicio']; ?>
'> 
   <input type="hidden" name="cuanto" value='<?php echo $this->_tpl_vars['cuanto']; ?>
'>
   <input type="hidden" name="total" value='<?php echo $this->_tpl_vars['total']; ?>
'>
   <input type="hidden" name="vmodal" value='<?php echo $this->_tpl_vars['vmodal']; ?>
'>
   <input type="hidden" name="navega" value='S'>

   <?php if ($this->_tpl_vars['inicio'] > 0): ?>
     <input type="submit" style="color: #CC0000; font-size: 10pt" name="atras" value="Previos <?php echo $this->_tpl_vars['minprev']; ?>
" />
   <?php endif; ?>
   
   <?php if (( $this->_tpl_vars['total'] - $this->_tpl_vars['inicio'] ) > $this->_tpl_vars['cuanto']): ?>
     <input type="submit" style="color: #CC0000; font-size: 10pt" name="adelante" value="Siguientes <?php echo $this->_tpl_vars['minsig']; ?>
" />
   <?php endif; ?>
   </tr>
   </table>
  </table>
  </div>

  <div class="tab-page" id="module02"><h2 class="tab">Eventos</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module02" ) );
  </script>
  <div align="left">

  <table width="100%" border="3" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
     <td class="der-color" width="65%">
       <input type="text" name="vrol" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vrol']; ?>
' size="9" maxlength="8">
       <b>&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo2']; ?>
&nbsp;&nbsp;</b>
       <input type="text" name='vrole' value='<?php echo $this->_tpl_vars['vrole']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="38" maxlength="80">
       <b>&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo3']; ?>
&nbsp;&nbsp;</b>
       <input type="text" name='vcreacion' value='<?php echo $this->_tpl_vars['vcreacion']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="22">
     </td>
     <td class="der-color" align="top">
       <b><?php echo $this->_tpl_vars['campo4']; ?>
&nbsp;</b>
       <?php echo ((is_array($_tmp=$this->_tpl_vars['vdescripcion'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 25, "\n", true) : smarty_modifier_wordwrap($_tmp, 25, "\n", true)); ?>

     </td>
   </tr>
  </tr> 
  </table>

  <iframe name='frmevmar' id='frmevmar' style='width:100%;height:150px' src="../comun/z_coneve.php?vrol=<?php echo $this->_tpl_vars['vrol']; ?>
&vtipo=M"></iframe>
  <iframe name='frmevpat' id='frmevpat' style='width:100%;height:150px' src="../comun/z_coneve.php?vrol=<?php echo $this->_tpl_vars['vrol']; ?>
&vtipo=P"></iframe>
  <iframe name='frmevpat' id='frmevpat' style='width:100%;height:150px' src="../comun/z_coneve.php?vrol=<?php echo $this->_tpl_vars['vrol']; ?>
&vtipo=A"></iframe>

  </div>
  </div>


 </div>

</tr> 
</table>
</form>

</div>  
</body>
</html>