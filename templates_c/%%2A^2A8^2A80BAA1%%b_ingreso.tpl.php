<?php /* Smarty version 2.6.8, created on 2020-10-20 09:00:18
         compiled from b_ingreso.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'b_ingreso.tpl', 43, false),)), $this); ?>
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

<body onLoad="mueveReloj(); this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
<div align="center">

<form name="form_reloj">
<table width="960px" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr>
    <td class="der">
      <div align="right">
        <I><font size="-1"><b><?php echo $this->_tpl_vars['titulo']; ?>
</b></font></I>
         &nbsp;&nbsp;<font face="Arial" size="2" > 
         <input type="text" name="reloj" size="15" style="background-color : Rich Blue; color : Black; font-family : Verdana, Arial, Helvetica; font-size : 8pt; text-align : center; font-weight: bold;" onfocus="window.document.form_reloj.reloj.blur()"><br/>
         </font>
      </div>
    </td>
  </tr>
</table>
</form>

<?php if ($this->_tpl_vars['vopc'] == 3): ?>
  <form name="forboletin1" id="forboletin1" action="b_ingreso.php?vopc=4" method="post">
<?php endif;  if ($this->_tpl_vars['vopc'] == 5): ?>
  <form name="forboletin1" id="forboletin1" action="b_ingreso.php?vopc=6" method="post">
<?php endif; ?> 
  <table>
  <tr> 
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name="nbol" size="3" maxlength="3" value='<?php echo $this->_tpl_vars['nbol']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onchange="Rellena(document.forboletin.nbol,3)">&nbsp;&nbsp;
        <select size="1" name="aplica" <?php echo $this->_tpl_vars['modo']; ?>
>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['apli_inf'],'selected' => $this->_tpl_vars['aplica'],'output' => $this->_tpl_vars['apli_def']), $this);?>

        </select> 
        &nbsp;
      </td>	
      
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
        <td class="cnt">
          <input type="image" src="../imagenes/note_f2.png" width="32" height="24" value="Crear Boletin">Crear Boletin</td>
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

<table width="960px">
<tr>

<form name="forboletin" id="forboletin" enctype="multipart/form-data" action="b_ingreso.php?vopc=2" method="POST" onsubmit='return pregunta();'> 
  <input type='hidden' name='nbol' value='<?php echo $this->_tpl_vars['nbol']; ?>
'>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type='hidden' name='accion' value='<?php echo $this->_tpl_vars['accion']; ?>
'>
  <input type='hidden' name='string' value='<?php echo $this->_tpl_vars['string']; ?>
'>
  <input type='hidden' name='campos' value='<?php echo $this->_tpl_vars['campos']; ?>
'>
  <input type='hidden' name='aplica' value='<?php echo $this->_tpl_vars['aplica']; ?>
'>
  
  <table width="960px">
  <tr>
    <td> 
       <div><strong> </strong></div>
    </td>

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
	       <a href="b_ingreso.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_azul.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     <?php endif; ?>
	     <?php if ($this->_tpl_vars['accion'] == 'M' || $this->_tpl_vars['vopc'] == 6): ?>
	       <a href="b_ingreso.php?vopc=5&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_azul.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     <?php endif; ?>  
	   </td>
 	   <td>&nbsp;</td>
      <td>
        <?php if ($this->_tpl_vars['vopc'] == 4 || $this->_tpl_vars['vopc'] == 6): ?>
	       <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" src="../imagenes/boton_guardar_rojo.png" alt="Save" align="middle" name="save" border="0" onclick="validate();return returnVal;"/>
        <?php else: ?>
          <a><img src="../imagenes/boton_guardar_rojo.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" alt="Save" align="middle" name="save" border="0" /></a>
        <?php endif; ?>
      </td>
 	   <td>&nbsp;</td>
	   <td>
 	     <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_azul.png',1);">
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

   <div class="tab-page" id="modac01"><h2 class="tab">Inf.General</h2>
   <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac01" ) );
   </script>
  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td width="20%" class="izq-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td width="80%" class="der-color" >
         <input type="text" name="fecha_pub" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecha_pub']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fecha_ven)" onchange="valFecha(this,document.forboletin.fecha_ven)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar9');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         </div>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color" >
         <input type="text" name="anoi" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['anoi']; ?>
' size="3" maxlength="3" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,3,document.forboletin.anof)" >
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color" >
         <input type="text" name="anof" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['anof']; ?>
' size="3" maxlength="3" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,3,document)" >
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo12']; ?>
</td>
      <td class="der-color" >
         <input type="text" name="anor" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['anor']; ?>
' size="3" maxlength="3" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,3,document)" >
      </td>
    </tr>
  </tr>
  </table>
  </div>

  <div class="tab-page" id="modac03"><h2 class="tab">Marcas</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac03" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
   <tr>
    <td colspan="2" width="100%" class="izq3-color" > <b> <?php echo $this->_tpl_vars['campo6']; ?>
</b> <?php echo $this->_tpl_vars['campo8']; ?>
</td>
   </tr>
      
    <tr>
     <td width="100%" colspan="1"> 
      <p> </p>
      <p style="margin: 0 5"><FONT COLOR=2B547E><b><i>- Solicitadas       	
      <p style="margin: 0 25" > <input type="text" name="tit_soli" value='<?php echo $this->_tpl_vars['tit_soli']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_soli" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_soli']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_soli)" >
      <a href="javascript:showCal('Calendar11');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Orden de Publicación<br>
      <p style="margin: 0 25" > <input type="text" name="tit_orden" value='<?php echo $this->_tpl_vars['tit_orden']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_orde" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_orde']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_orde)"  >
      <a href="javascript:showCal('Calendar12');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Devueltas por Forma<br>
      <p style="margin: 0 25" ><input type="text" name="tit_devu" value='<?php echo $this->_tpl_vars['tit_devu']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fec_devu" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_devu']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)" >
      <a href="javascript:showCal('Calendar14');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">      	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Notificación de Solicitudes de Marcas con Oposición<br>
      <p style="margin: 0 25" ><input type="text" name="tit_obse" value='<?php echo $this->_tpl_vars['tit_obse']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fec_obse" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_obse']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar15');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">  
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Oposiciones sin Contestación Desistidas por Ley<br> 
      <p style="margin: 0 25" ><input type="text" name="tit_obse_scon" value='<?php echo $this->_tpl_vars['tit_obse_scon']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fec_obse_scon" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_obse_scon']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar16');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Concedidas<br>    
      <p style="margin: 0 25" > <input type="text" name="tit_conc" value='<?php echo $this->_tpl_vars['tit_conc']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fec_conc" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_conc']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar13');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">      	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Prioridad Extinguida<br>
      <p style="margin: 0 25" ><input type="text" name="tit_prio" value='<?php echo $this->_tpl_vars['tit_prio']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_prio" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_prio']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar17');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>    
    </tr>
    <tr>
     <td width="100%" colspan="1">      	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b> <i>- Prioridad Extinguida Extemporánea<br>
      <p style="margin: 0 25" ><input type="text" name="tit_prio_exte" value='<?php echo $this->_tpl_vars['tit_prio_exte']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fec_prio_exte" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_prio_exte']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar18');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">  
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Prioridad Extinguida Defectuosa<br>
      <p style="margin: 0 25" ><input type="text" name="tit_prio_defe" value='<?php echo $this->_tpl_vars['tit_prio_defe']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_prio_defe" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_prio_defe']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar19');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>    	 
    </tr>
    <tr>
     <td width="100%" colspan="1">      	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Perimidas por no Publicación en Prensa<br>
      <p style="margin: 0 25" ><input type="text" name="tit_peri" value='<?php echo $this->_tpl_vars['tit_peri']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_peri" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_peri']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar20');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>  
    </tr>
    </tr>
     <td width="100%" colspan="1">     	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Caducas<br>
      <p style="margin: 0 25" ><input type="text" name="tit_cadu" value='<?php echo $this->_tpl_vars['tit_cadu']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_cadu" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_cadu']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar21');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">           	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Desistidas<br>      
      <p style="margin: 0 25" ><input type="text" name="tit_desi" value='<?php echo $this->_tpl_vars['tit_desi']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fec_desi" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_desi']; ?>
' size="10" maxlength="10" align="left"  onkeyup="checkLength(event,this,10,document.forboletin.anoi)">
      <a href="javascript:showCal('Calendar22');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>	
    </tr>
    <tr>
     <td width="100%" colspan="1">           	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Desistimiento de Oposiciones<br>      
      <p style="margin: 0 25" ><input type="text" name="tit_desi_obse" value='<?php echo $this->_tpl_vars['tit_desi_obse']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_desi_obse" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_desi_obse']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar49');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>	
    </tr>
    <tr>
     <td width="100%" colspan="1">        
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Desistimiento de Oposiciones Mejor Derecho<br>
      <p style="margin: 0 25" ><input type="text" name="tit_desi_mejo" value='<?php echo $this->_tpl_vars['tit_desi_mejo']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  > 
&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_desi_mejo" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_desi_mejo']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar23');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">          	       	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Negadas<br>
      <p style="margin: 0 25" ><input type="text" name="tit_nega" value='<?php echo $this->_tpl_vars['tit_nega']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fec_nega" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_nega']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar31');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">           	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Certificados Elaborados<br>
      <p style="margin: 0 25" > <input type="text" name="tit_cert" value='<?php echo $this->_tpl_vars['tit_cert']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_cert" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_cert']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar32');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">           	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Notificación de Cancelación<br>
      <p style="margin: 0 25" > <input type="text" name="tit_noti" value='<?php echo $this->_tpl_vars['tit_noti']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_noti" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_noti']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar50');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">          	 		
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Anotaciones Marginales<br>
      <p style="margin: 0 25" > <input type="text" name="tit_anot" value='<?php echo $this->_tpl_vars['tit_anot']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fec_anot" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_anot']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar33');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">          	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Devoluciones de Registros a Públicar <br> 	
      <p style="margin: 0 25" ><input type="text" name="tit_devo_regi" value='<?php echo $this->_tpl_vars['tit_devo_regi']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_devo_regi" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_devo_regi']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar29');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">          	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Reingresos de Devoluciones de Anotaciones Marginales<br>
      <p style="margin: 0 25" ><input type="text" name="tit_rein_devam" value='<?php echo $this->_tpl_vars['tit_rein_devam']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_rein_devam" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_rein_devam']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar30');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Desistimiento de Anotaciones Marginales <br> 
      <p style="margin: 0 25" ><input type="text" name="tit_desi_anom" value='<?php echo $this->_tpl_vars['tit_desi_anom']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_desi_anom" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_desi_anom']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
     <a href="javascript:showCal('Calendar28');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>   
    </tr>
    <tr>
     <td width="100%" colspan="1">       
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Registros no renovados<br>
      <p style="margin: 0 25" ><input type="text" name="tit_regi" value='<?php echo $this->_tpl_vars['tit_regi']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_regi" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_regi']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar26');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>     
    </tr>
    <tr>
     <td width="100%" colspan="1">      	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Caducas por No Renovación<br>    
      <p style="margin: 0 25" ><input type="text" name="tit_cadu_nren" value='<?php echo $this->_tpl_vars['tit_cadu_nren']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_cadu_nren" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_cadu_nren']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar25');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>       
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Devueltas por Fondo<br>
      <p style="margin: 0 25" ><input type="text" name="tit_fondo" value='<?php echo $this->_tpl_vars['tit_fondo']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fec_fondo" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_fondo']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)" >
      <a href="javascript:showCal('Calendar68');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
   </td>
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac04"><h2 class="tab">Patentes</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac04" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
   <tr>
     <td colspan="2" width="100%" class="izq3-color" > <b> <?php echo $this->_tpl_vars['campo7']; ?>
</b>  <?php echo $this->_tpl_vars['campo8']; ?>
</td>
   </tr>
   
   <tr>
     <td width="50%" colspan="1"> 
     <p> </p>
     <div id="resultado">

      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Solicitadas<br>
      <p style="margin: 0 25" > <input type="text" name="titp_soli" value='<?php echo $this->_tpl_vars['titp_soli']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_soli" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_soli']; ?>
' size="10" maxlength="10" align="left"   onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar34');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    
     <td width="100%" colspan="1">        	      	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Orden de Publicación<br>
      <p style="margin: 0 25" ><input type="text" name="titp_orden" value='<?php echo $this->_tpl_vars['titp_orden']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fecp_orde" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_orde']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar35');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
  
     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Devueltas<br>
      <p style="margin: 0 25" ><input type="text" name="titp_devu" value='<?php echo $this->_tpl_vars['titp_devu']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_devu" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_devu']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar37');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
 
     <td width="100%" colspan="1">  
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Concedidas<br>    
      <p style="margin: 0 25" ><input type="text" name="titp_conc" value='<?php echo $this->_tpl_vars['titp_conc']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_conc" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_conc']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar36');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
 
     <td width="100%" colspan="1">           	       	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Prioridad Extinguida<br>
	   <p style="margin: 0 25" ><input type="text" name="titp_prio" value='<?php echo $this->_tpl_vars['titp_prio']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_prio" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_prio']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar38');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
 
     <td width="100%" colspan="1">      	       	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Prioridad Extinguida Extemporánea<br>
    	<p style="margin: 0 25" ><input type="text" name="titp_prio_exte" value='<?php echo $this->_tpl_vars['titp_prio_exte']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_prio_exte" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_prio_exte']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar39');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
 
     <td width="100%" colspan="1">          	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Prioridad Extinguida Defectuosa<br>
      <p style="margin: 0 25" ><input type="text" name="titp_prio_defe" value='<?php echo $this->_tpl_vars['titp_prio_defe']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_prio_defe" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_prio_defe']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar40');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
 
     <td width="100%" colspan="1">       
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Perimidas por no Publicación en Prensa<br>
      <p style="margin: 0 25" ><input type="text" name="titp_peri" value='<?php echo $this->_tpl_vars['titp_peri']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_peri" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_peri']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar41');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
 
     <td width="100%" colspan="1">      	     	      	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Denegadas<br>
      <p style="margin: 0 25" ><input type="text" name="titp_dene" value='<?php echo $this->_tpl_vars['titp_dene']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_dene" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_dene']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar42');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    
     <td width="100%" colspan="1">          	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Desistidas<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_desi" value='<?php echo $this->_tpl_vars['titp_desi']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_desi" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_desi']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar43');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">          	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Abandonadas<br>
      <p style="margin: 0 25" ><input type="text" name="titp_aban" value='<?php echo $this->_tpl_vars['titp_aban']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_aban" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_aban']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar44');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">          	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Oposiciones<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_opos" value='<?php echo $this->_tpl_vars['titp_opos']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  > 
  &nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_opos" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_opos']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar46');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes en Rehabilitacion<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_reha" value='<?php echo $this->_tpl_vars['titp_reha']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_reha" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_reha']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar47');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">     	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Titulos de Patentes<br>  	
      <p style="margin: 0 25" ><input type="text" name="titp_titu" value='<?php echo $this->_tpl_vars['titp_titu']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_titu" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_titu']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar48');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes Sin Efecto x Falto de Pago de Anualidad<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_sefp" value='<?php echo $this->_tpl_vars['titp_sefp']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_sefp" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_sefp']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar66');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes Sin Efecto x Vencimiento de Termino<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_sevt" value='<?php echo $this->_tpl_vars['titp_sevt']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_sevt" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_sevt']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar67');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1">          	       	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Negadas<br>
      <p style="margin: 0 25" ><input type="text" name="titp_nega" value='<?php echo $this->_tpl_vars['titp_nega']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>
 
      <input type="text" name="fecp_nega" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_nega']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)" >
      <a href="javascript:showCal('Calendar45');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>

     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes Sin Efecto x Falto de Pago de Concesion<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_derp" value='<?php echo $this->_tpl_vars['titp_derp']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_derp" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_derp']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar93');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">            
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes Devueltas por Fondo<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_devfon" value='<?php echo $this->_tpl_vars['titp_devfon']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_devfon" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_devfon']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar96');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">            
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Prioridades Extinguidas por Fondo<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_priofon" value='<?php echo $this->_tpl_vars['titp_priofon']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fecp_priofon" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fecp_priofon']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar97');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

   </td>
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac05"><h2 class="tab">Recursos M</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac05" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
   <tr>
    <td colspan="2" width="100%" class="izq3-color" > <b> <?php echo $this->_tpl_vars['campo9']; ?>
</b> <?php echo $this->_tpl_vars['campo8']; ?>
</td>
   </tr>
      
    <tr>
     <td width="100%" colspan="1"> 
      <p> </p>
      <p style="margin: 0 5"><FONT COLOR=2B547E><b><i>- Reconsideración Prioridad Extinguida Marcas - Estatus 800<br>       	
      <p style="margin: 0 25" > <input type="text" name="tit_800" value='<?php echo $this->_tpl_vars['tit_800']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_800" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_800']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_800)" >
      <a href="javascript:showCal('Calendar101');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Negadas Marcas - Estatus 801<br>
      <p style="margin: 0 25" > <input type="text" name="tit_801" value='<?php echo $this->_tpl_vars['tit_801']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_801" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_801']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_801)"  >
      <a href="javascript:showCal('Calendar102');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Resolución a Observaciones Marcas - Estatus 802<br>
      <p style="margin: 0 25" > <input type="text" name="tit_802" value='<?php echo $this->_tpl_vars['tit_802']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_802" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_802']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_802)"  >
      <a href="javascript:showCal('Calendar103');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Perencion de Procedimiento Marcas - Estatus 803<br>
      <p style="margin: 0 25" > <input type="text" name="tit_803" value='<?php echo $this->_tpl_vars['tit_803']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_803" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_803']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_803)"  >
      <a href="javascript:showCal('Calendar104');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Prioridad Extinguida Publicacion Extemporanea Marcas - Estatus 804<br>
      <p style="margin: 0 25" > <input type="text" name="tit_804" value='<?php echo $this->_tpl_vars['tit_804']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_804" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_804']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_804)"  >
      <a href="javascript:showCal('Calendar105');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Perencion de Procedimiento Orden de Publicacion Prensa Marcas - Estatus 805<br>
      <p style="margin: 0 25" > <input type="text" name="tit_805" value='<?php echo $this->_tpl_vars['tit_805']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_805" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_805']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_805)"  >
      <a href="javascript:showCal('Calendar106');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Marcas Caduca - Estatus 806<br>
      <p style="margin: 0 25" > <input type="text" name="tit_806" value='<?php echo $this->_tpl_vars['tit_806']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_806" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_806']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_806)"  >
      <a href="javascript:showCal('Calendar138');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Desistidas por Ley Marcas - Estatus 807<br>
      <p style="margin: 0 25" > <input type="text" name="tit_807" value='<?php echo $this->_tpl_vars['tit_807']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_807" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_807']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_807)"  >
      <a href="javascript:showCal('Calendar107');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Perencion de Prioridad Extinguida Publicacion Defectuosa Marcas - Estatus 808<br>
      <p style="margin: 0 25" > <input type="text" name="tit_808" value='<?php echo $this->_tpl_vars['tit_808']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_808" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_808']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_808)"  >
      <a href="javascript:showCal('Calendar108');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Nulidad a la Concesión pendiente de Notificación Marcas - Estatus 809<br>
      <p style="margin: 0 25" > <input type="text" name="tit_809" value='<?php echo $this->_tpl_vars['tit_809']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_809" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_809']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_809)"  >
      <a href="javascript:showCal('Calendar109');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Solicitud en Tramite con Petición de Nulidad del Acto Administrativo Marcas - Estatus 821<br>
      <p style="margin: 0 25" > <input type="text" name="tit_821" value='<?php echo $this->_tpl_vars['tit_821']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_821" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_821']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_821)"  >
      <a href="javascript:showCal('Calendar110');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Nulidad del Acto Administrativo de Oficio Marcas - Estatus 822<br>
      <p style="margin: 0 25" > <input type="text" name="tit_822" value='<?php echo $this->_tpl_vars['tit_822']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_822" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_822']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_822)"  >
      <a href="javascript:showCal('Calendar111');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Solicitud en Tramite con Petición de Nulidad del Acto Administrativo de Oficio Notificada Marcas - Estatus 823<br>
      <p style="margin: 0 25" > <input type="text" name="tit_823" value='<?php echo $this->_tpl_vars['tit_823']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_823" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_823']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_823)"  >
      <a href="javascript:showCal('Calendar112');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Solicitud con Nulidad del Acto Administrativo de Oficio Notificada Marcas - Estatus 824<br>
      <p style="margin: 0 25" > <input type="text" name="tit_824" value='<?php echo $this->_tpl_vars['tit_824']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_824" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_824']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_824)"  >
      <a href="javascript:showCal('Calendar113');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Recurso de Nulidad a la Concesión Notificada Marcas - Estatus 825<br>
      <p style="margin: 0 25" > <input type="text" name="tit_825" value='<?php echo $this->_tpl_vars['tit_825']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_825" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_825']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_825)"  >
      <a href="javascript:showCal('Calendar114');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Registro con Solicitud de Cancelación Pendiente de Notificar Marcas - Estatus 830<br>
      <p style="margin: 0 25" > <input type="text" name="tit_830" value='<?php echo $this->_tpl_vars['tit_830']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_830" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_830']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_830)"  >
      <a href="javascript:showCal('Calendar115');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Registro con Solicitud de Cancelación Notificada Marcas - Estatus 831<br>
      <p style="margin: 0 25" > <input type="text" name="tit_831" value='<?php echo $this->_tpl_vars['tit_831']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_831" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_831']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_831)"  >
      <a href="javascript:showCal('Calendar116');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Recurso de Reconsideración - Disposición Administrativa que afecta al Registro Marcas - Estatus 833<br>
      <p style="margin: 0 25" > <input type="text" name="tit_833" value='<?php echo $this->_tpl_vars['tit_833']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_833" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_833']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_833)"  >
      <a href="javascript:showCal('Calendar117');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Marca con Solicitud de Nulidad, pendiente de Notificar - Estatus 835<br>
      <p style="margin: 0 25" > <input type="text" name="tit_835" value='<?php echo $this->_tpl_vars['tit_835']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_835" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_835']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_835)"  >
      <a href="javascript:showCal('Calendar118');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Marca con Solicitud de Nulidad Notificada - Estatus 836<br>
      <p style="margin: 0 25" > <input type="text" name="tit_836" value='<?php echo $this->_tpl_vars['tit_836']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_836" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_836']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_836)"  >
      <a href="javascript:showCal('Calendar119');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Registro con Nulidad por Disposición Administrativa Marcas - Estatus 837<br>
      <p style="margin: 0 25" > <input type="text" name="tit_837" value='<?php echo $this->_tpl_vars['tit_837']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_837" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_837']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_837)"  >
      <a href="javascript:showCal('Calendar120');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Recurso de Reconsideración - Disposición Administrativa de Nulidad de Registro Marcas - Estatus 838<br>
      <p style="margin: 0 25" > <input type="text" name="tit_838" value='<?php echo $this->_tpl_vars['tit_838']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="fec_838" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['fec_838']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_838)"  >
      <a href="javascript:showCal('Calendar121');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

   </td>
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac06"><h2 class="tab">Recursos P</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac06" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
   <tr>
    <td colspan="2" width="100%" class="izq3-color" > <b> <?php echo $this->_tpl_vars['campo9']; ?>
</b> <?php echo $this->_tpl_vars['campo8']; ?>
</td>
   </tr>
      
    <tr>
     <td width="100%" colspan="1"> 
      <p> </p>
      <p style="margin: 0 5"><FONT COLOR=2B547E><b><i>- Reconsideración Prioridad Extinguida Patentes - Estatus 800<br>       	
      <p style="margin: 0 25" > <input type="text" name="ptit_800" value='<?php echo $this->_tpl_vars['ptit_800']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp;<?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_800" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_800']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_800)" >
      <a href="javascript:showCal('Calendar122');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Negadas Patentes - Estatus 801<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_801" value='<?php echo $this->_tpl_vars['ptit_801']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_801" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_801']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_801)"  >
      <a href="javascript:showCal('Calendar123');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Denegada Patentes - Estatus 802<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_802" value='<?php echo $this->_tpl_vars['ptit_802']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_802" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_802']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_802)"  >
      <a href="javascript:showCal('Calendar124');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Prioridad Extinguida Publicacion Defectuosa Patentes - Estatus 804<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_804" value='<?php echo $this->_tpl_vars['ptit_804']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_804" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_804']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_804)"  >
      <a href="javascript:showCal('Calendar125');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Perencion de Procedimiento Orden de Publicacion Prensa Patentes - Estatus 805<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_805" value='<?php echo $this->_tpl_vars['ptit_805']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_805" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_805']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_805)"  >
      <a href="javascript:showCal('Calendar126');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Abandonada Patentes - Estatus 806<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_806" value='<?php echo $this->_tpl_vars['ptit_806']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_806" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_806']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_806)"  >
      <a href="javascript:showCal('Calendar127');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Nulidad a la Concesión pendiente de Notificación Patentes - Estatus 809<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_809" value='<?php echo $this->_tpl_vars['ptit_809']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_809" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_809']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_809)"  >
      <a href="javascript:showCal('Calendar128');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Solicitud en Tramite con Petición de Nulidad del Acto Administrativo Patentes - Estatus 821<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_821" value='<?php echo $this->_tpl_vars['ptit_821']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_821" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_821']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_821)"  >
      <a href="javascript:showCal('Calendar129');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Recurso de Reconsideración - Disposición Administrativa que afecta al Registro Patentes - Estatus 833<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_833" value='<?php echo $this->_tpl_vars['ptit_833']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_833" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_833']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_833)"  >
      <a href="javascript:showCal('Calendar130');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Patente con Solicitud de Nulidad, pendiente de Notificar - Estatus 835<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_835" value='<?php echo $this->_tpl_vars['ptit_835']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_835" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_835']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_835)"  >
      <a href="javascript:showCal('Calendar131');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Registro con Solicitud de Nulidad Notificada - Estatus 836<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_836" value='<?php echo $this->_tpl_vars['ptit_836']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_836" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_836']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_836)"  >
      <a href="javascript:showCal('Calendar132');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Registro con Nulidad por Disposición Administrativa - Estatus 837<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_837" value='<?php echo $this->_tpl_vars['ptit_837']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_837" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_837']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_837)"  >
      <a href="javascript:showCal('Calendar135');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Disposición Administrativa de Nulidad de Registro Patentes - Estatus 838<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_838" value='<?php echo $this->_tpl_vars['ptit_838']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_838" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_838']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_838)"  >
      <a href="javascript:showCal('Calendar133');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración - Solicitud Desistida Patentes - Estatus 840<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_840" value='<?php echo $this->_tpl_vars['ptit_840']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_840" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_840']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_840)"  >
      <a href="javascript:showCal('Calendar134');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración - Patente Sin Efecto por Falta de Pago de Anualidad Publicada - Estatus 921<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_921" value='<?php echo $this->_tpl_vars['ptit_921']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_921" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_921']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_921)"  >
      <a href="javascript:showCal('Calendar136');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración - Patente Sin Efecto por Vencimiento de Termino Publicada - Estatus 922<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_922" value='<?php echo $this->_tpl_vars['ptit_922']; ?>
' size="90" maxlength="200" align="left"   <?php echo $this->_tpl_vars['modo1']; ?>
  >&nbsp; <?php echo $this->_tpl_vars['campof']; ?>

      <input type="text" name="pfec_922" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['pfec_922']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_922)"  >
      <a href="javascript:showCal('Calendar137');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
   </td>
  </tr> 
  </table>
  </div>

  </form>
  </tr> 
  </table>

</tr>
</table>


</div>  
&nbsp;
