<?php /* Smarty version 2.6.8, created on 2020-10-22 14:26:33
         compiled from z_bolvenc.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_bolvenc.tpl', 20, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
 <div align="center">
 <br>
 <form name="formarcas2" action="z_bolvenc.php?vopc=1" method="post">
   <table>
	     <tr>
	       <td class="izq-color"><?php echo $this->_tpl_vars['Campo1']; ?>
</td>
	       <td class="der-color">
	          <input type="text" name="vbol" size="2" maxlength="3" value='<?php echo $this->_tpl_vars['vbol']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vfpub)">
           <select size="1" name="aplica" >
             <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['apli_inf'],'selected' => $this->_tpl_vars['aplica'],'output' => $this->_tpl_vars['apli_def']), $this);?>

           </select> 
	          
	       </td>
	     </tr>
	     <tr>
	       <td class="izq-color"><?php echo $this->_tpl_vars['Campo5']; ?>
</td>
	       <td class="der-color">
	          <input size="9" maxlength="10" type="text" name="vfpub" value='<?php echo $this->_tpl_vars['vfpub']; ?>
'  onkeyup="checkLength(event,this,10,document.formarcas2.vfvig)" >
             <a href="javascript:showCal('Calendar86');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       </td>
	     </tr>
	     <tr>
	       <td class="izq-color"><?php echo $this->_tpl_vars['Campo6']; ?>
</td>
	       <td class="der-color">
	          <input size="9" maxlength="10" type="text" name="vfvig" value='<?php echo $this->_tpl_vars['vfvig']; ?>
'  onkeyup="checkLength(event,this,10,document.formarcas2.vfven15)" >
             <a href="javascript:showCal('Calendar87');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       </td>
	     </tr>
	     <tr>
	       <td class="izq-color"><?php echo $this->_tpl_vars['Campo2']; ?>
</td>
	       <td class="der-color">
	          <input size="9" maxlength="10" type="text" name="vfven15" value='<?php echo $this->_tpl_vars['vfven15']; ?>
'  onkeyup="checkLength(event,this,10,document.formarcas2.vfven30)" >
             <a href="javascript:showCal('Calendar88');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       </td>
	     </tr>
        <tr>
          <td class="izq-color"><?php echo $this->_tpl_vars['Campo3']; ?>
</td>
	       <td class="der-color">
	         <input size="9" maxlength="10" type="text" name="vfven30" value='<?php echo $this->_tpl_vars['vfven30']; ?>
'  onkeyup="checkLength(event,this,10,document.formarcas2.vfven2m)" onchange="valFecha(this,document.formarcas2.vfven2m)">
             <a href="javascript:showCal('Calendar89');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       </td>
	     </tr>		
	     <tr>
	       <td class="izq-color"><?php echo $this->_tpl_vars['Campo4']; ?>
</td>
	       <td class="der-color">
	         <input size="9" maxlength="10" type="text" name="vfven2m" value='<?php echo $this->_tpl_vars['vfven2m']; ?>
'  onkeyup="checkLength(event,this,10,document.formarcas2.grabar)" onchange="valFecha(this,document.formarcas2.otro)">
             <a href="javascript:showCal('Calendar90');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       </td>
	     </tr>
    </table>
   <br>
    <table width="225">
      <tr>
       <td class="cnt"><input type="image" name="grabar" src="../imagenes/boton_procesar_azul.png" value="Guardar"></td> 
       <td class="cnt"><a href="z_bolvenc.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['nconexion']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      </tr>
    </table>
   <br><br><br><br><br><br><br>
 </form>
 </div>  
</body>
</html>

