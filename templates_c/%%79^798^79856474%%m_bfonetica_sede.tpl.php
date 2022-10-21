<?php /* Smarty version 2.6.8, created on 2021-08-12 15:29:10
         compiled from m_bfonetica_sede.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_bfonetica_sede.tpl', 84, false),array('modifier', 'truncate', 'm_bfonetica_sede.tpl', 128, false),)), $this); ?>
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
  <form name="formarcas1" action="m_bfonetica_sede.php?vopc=5" method="post">
<?php endif; ?> 		  
<?php if ($this->_tpl_vars['vopc'] == 4): ?>
  <form name="formarcas1" action="m_bfonetica_sede.php?vopc=1" method="post">
<?php endif; ?> 		  
<?php if ($this->_tpl_vars['vopc'] == 6): ?>
  <form name="formarcas1" action="m_bfonetica_sede.php?vopc=7" method="post">
<?php endif; ?> 		  

  <input type ='hidden' name='login' value=<?php echo $this->_tpl_vars['login']; ?>
>
  <input type ='hidden' name='auxnum' value=<?php echo $this->_tpl_vars['auxnum']; ?>
>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <table>
     <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
         <input tabindex="1" type="text" name="vsol1" size="6" maxlength="6" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)"  onchange="valagente(document.formarcas1.vsol1,document.formarcas2.vsol2)">
      </td>
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
      <td class="cnt">
        &nbsp;&nbsp;<input type="image" src="../imagenes/boton_buscar_rojo.png" value="Nueva Solicitud">
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
</form>				  

<?php if ($this->_tpl_vars['vopc'] == 1 || $this->_tpl_vars['vopc'] == 5): ?>
<form name="formarcas2" enctype="multipart/form-data" action="m_bfonetica_sede.php?vopc=2" method="POST" onsubmit='return pregunta();'>
<?php endif; ?>    
<?php if ($this->_tpl_vars['vopc'] == 8): ?>
  <form name="formarcas2" enctype="multipart/form-data" action="m_bfonetica_sede.php?vopc=9" method="POST" onsubmit='return pregunta();'>
<?php endif; ?>    
  <input type ='hidden' name='login' value=<?php echo $this->_tpl_vars['login']; ?>
>
  <input type ='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type ='hidden' name='modo' value=<?php echo $this->_tpl_vars['vmodo']; ?>
>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='auxnum' value=<?php echo $this->_tpl_vars['auxnum']; ?>
>
  <input type ='hidden' name='planilla1' value=<?php echo $this->_tpl_vars['planilla1']; ?>
>

  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input tabindex="3" type="text" name="fecharec" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecharec']; ?>
' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.prioridad)" onchange="valFecha(this,document.formarcas2.prioridad)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar53');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
         <input tabindex="5" type="text" name="recibo" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['recibo']; ?>
' size="7" maxlength="6" onkeyup="checkLength(event,this,6,document.formarcas2.planilla)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
         <input tabindex="8" type="text" name="solicitant" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['solicitant']; ?>
' size="60" maxlength="80" onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,80,document.formarcas2.indole)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
           <select size="1" name="indole" <?php echo $this->_tpl_vars['modo2']; ?>
>
              <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vindole_id'],'selected' => $this->_tpl_vars['indole'],'output' => $this->_tpl_vars['vindole_de']), $this);?>

           </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <select size="1" name="lced" <?php echo $this->_tpl_vars['modo2']; ?>
>
           <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['lced_id'],'selected' => $this->_tpl_vars['lced'],'output' => $this->_tpl_vars['lced_de']), $this);?>

        </select>
        <input tabindex="9" type="text" name='nced' size="9" maxlength="9" value='<?php echo $this->_tpl_vars['nced']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 
onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.formarcas2.nced,9)" onkeyup="checkLength(event,this,9,document.formarcas2.telefono)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color" colspan="2"><small>V = Venezolano,&nbsp;&nbsp;&nbsp;E = Extranjero,&nbsp;&nbsp;&nbsp;P = Pasaporte,&nbsp;&nbsp;&nbsp;J = Juridico,&nbsp;&nbsp;&nbsp;G = Gobierno</small></td>
    </tr> 
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <input tabindex="10" type="text" name='telefono' value='<?php echo $this->_tpl_vars['telefono']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="15" maxlength="15" onKeyPress="return acceptChar(event,9, this)" onkeyup="checkLength(event,this,15,document.formarcas2.Guardar)">
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select tabindex="4" size="1" name="prioridad" <?php echo $this->_tpl_vars['modo2']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['prioridad'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo11']; ?>
</td>
      <td class="der-color">
      	<input tabindex="7" type="text" name="denominacion" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['denominacion']; ?>
' size="60" maxlength="120" onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,120,document.formarcas2.options)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
 			<!-- Inicio Combo de Clases> -->         
         <select size="1" name="options" <?php echo $this->_tpl_vars['modo4']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodclase'],'selected' => $this->_tpl_vars['clase'],'output' => ((is_array($_tmp=$this->_tpl_vars['vnomclase'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 70) : smarty_modifier_truncate($_tmp, 70))), $this);?>

         </select>
         <!-- Fin Combo de Clases> -->     
      </td>
    </tr>          
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color">
         <input tabindex="6" type="text" name="planilla" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['planilla']; ?>
' size="8" maxlength="8" onkeyup="checkLength(event,this,8,document.formarcas2.denominacion)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo18']; ?>
</td>
      <td class="der-color">
        <select size='1' name='vplus' onchange="valenvio(this.form);" <?php echo $this->_tpl_vars['modo4']; ?>
>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayplus'],'selected' => $this->_tpl_vars['vplus'],'output' => $this->_tpl_vars['arraydesplus']), $this);?>

        </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo17']; ?>
</td>
      <td class="der-color">
        <input type='text' name='email' value='<?php echo $this->_tpl_vars['email']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 size="70" maxlength="80" onkeyup="checkLength(event,this,80,document.formarcas2.passwd)" onchange="isEmail2(document.formarcas2.email.value,this.form);">
	     <br><font size="1">Cuenta correo para el env&iacute;o de la B&uacute;squeda, por ejemplo: correo@ejemplo.com</font></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo12']; ?>
</td>
      <td class="der-color">
         <select size="1" name="vsede" <?php echo $this->_tpl_vars['modo2']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodsede'],'selected' => $this->_tpl_vars['vsede'],'output' => $this->_tpl_vars['vnomsede']), $this);?>

         </select>
      </td>
    </tr>          
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo15']; ?>
</td>
      <td class="der-color">
      	<input tabindex="7" type="text" name="usuario" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['usuario']; ?>
' size="12" maxlength="12">
      </td>
    </tr> 
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo16']; ?>
</td>
      <td class="der-color">
      	<input tabindex="7" type="text" name="fh_carga" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fh_carga']; ?>
' size="20" maxlength="20">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo13']; ?>
</td>
      <td class="der-color">
         <input type="text" name="vfechr" <?php echo $this->_tpl_vars['modo3']; ?>
 value='<?php echo $this->_tpl_vars['fechapro']; ?>
' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.vfechr)" onchange="valFecha(this,document.formarcas2.vfechr)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar51');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
    </tr>          
    </table>
  &nbsp;
  &nbsp;

  <table width="255" >
  <tr>
    <td class="cnt"><input tabindex="11" name="Guardar" type="image" src="../imagenes/boton_guardar_azul.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1 || $this->_tpl_vars['vopc'] == 4): ?>
         <a href="m_bfonetica_sede.php?vopc=4"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
         <a><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 5): ?>
         <a href="m_bfonetica_sede.php?vopc=3"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 6 || $this->_tpl_vars['vopc'] == 8): ?>
         <a href="m_bfonetica_sede.php?vopc=6"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="13" src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>