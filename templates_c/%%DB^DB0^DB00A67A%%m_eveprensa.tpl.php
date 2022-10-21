<?php /* Smarty version 2.6.8, created on 2020-10-21 14:45:41
         compiled from m_eveprensa.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'm_eveprensa.tpl', 41, false),array('function', 'html_options', 'm_eveprensa.tpl', 116, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
<div align="center">


<form name="forlotes" enctype="multipart/form-data" action="m_eveprensa.php?vopc=2"  method="POST" >
   <input type="hidden" name="vsola" value='<?php echo $this->_tpl_vars['vsola']; ?>
'>
   <input type="hidden" name="vsolb" value='<?php echo $this->_tpl_vars['vsolb']; ?>
'>
   <input type="hidden" name="role" value='<?php echo $this->_tpl_vars['role']; ?>
'>
   <input type="hidden" name="usuario" value='<?php echo $this->_tpl_vars['usuario']; ?>
'>
   <input type="hidden" name="pagoreg" value='<?php echo $this->_tpl_vars['pagoreg']; ?>
'>
   <input type="hidden" name="factotal" value='<?php echo $this->_tpl_vars['factotal']; ?>
'>
   <input type="hidden" name="email" value='<?php echo $this->_tpl_vars['email']; ?>
'>

        
   &nbsp;
   <font class='nota7'><b>DATOS DE LA FACTURA, SOLICITANTE, BOLETIN Y CANTIDAD(ES):</b></font>
   <br>   
   &nbsp;
   <table cellspacing="1" border="1">
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color" >
    	     <input type="text" name="factura" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['factura']; ?>
' readonly >
      </td>
    </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="fechafac" size="7" maxlength="10" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fechafac'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' readonly="readonly">  
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="solicitante" size="70" maxlength="80" value='<?php echo $this->_tpl_vars['solicitante']; ?>
' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="cisolicita" size="8" maxlength="10" value='<?php echo $this->_tpl_vars['cisolicita']; ?>
' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="domicilio" size="70" maxlength="90" value='<?php echo $this->_tpl_vars['domicilio']; ?>
' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="telefono" size="10" maxlength="10" value='<?php echo $this->_tpl_vars['telefono']; ?>
' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo15']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="email" size="60" maxlength="70" value='<?php echo $this->_tpl_vars['email']; ?>
' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="mcantidad" size="2" maxlength="3" value='<?php echo $this->_tpl_vars['mcantidad']; ?>
' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo11']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="pcantidad" size="2" maxlength="3" value='<?php echo $this->_tpl_vars['pcantidad']; ?>
' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo12']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="total" size="2" maxlength="3" value='<?php echo $this->_tpl_vars['total']; ?>
' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo8']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="boletin" <?php echo $this->_tpl_vars['modo']; ?>
 size="2" maxlength="3" value='<?php echo $this->_tpl_vars['boletin']; ?>
' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo14']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="factotal" size="5" maxlength="5" value='<?php echo $this->_tpl_vars['factotal']; ?>
' readonly="readonly">
       </td>
     </tr>
    </table>

    <p></p>
    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq2-color" colspan="2"><?php echo $this->_tpl_vars['campo9']; ?>
</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:99%;height:90px;background-color: WHITE;' src="m_verprensa.php?vcod=<?php echo $this->_tpl_vars['factura']; ?>
&vbol=<?php echo $this->_tpl_vars['boletin']; ?>
"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <!-- <input type="text" name="nsol1" size="3" maxlength="4" value='<?php echo $this->_tpl_vars['nsol1']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol2)" onchange="Rellena(document.forlotes.vsol1,4);document.forlotes.vsol1.value=this.value;"> -->
        <select size='1' name='vsol1' onchange="document.forlotes.vsol1.value=this.value;">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayannos'],'selected' => $this->_tpl_vars['vsol1'],'output' => $this->_tpl_vars['arraynameano']), $this);?>

        </select> -
	<input type="text" name="vsol2" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol2']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" onchange="Rellena(document.forlotes.vsol2,6);document.forlotes.vsol2.value=this.value;">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai1" <?php echo $this->_tpl_vars['modo1']; ?>
 onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienai1,document.forlotes.factura,document.forlotes.boletin,document.forlotes.mcantidad)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae1" <?php echo $this->_tpl_vars['modo1']; ?>
 onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienae1,document.forlotes.factura,document.forlotes.boletin,document.forlotes.mcantidad)">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar1" onclick="document.forlotes.vsol1.value='';document.forlotes.vsol2.value='';"> 
    </td></tr>
    </table>

    <p></p>
    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq2-color" colspan="2"><?php echo $this->_tpl_vars['campo10']; ?>
</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:99%;height:90px;background-color: WHITE;' src="p_verprensa.php?vcod=<?php echo $this->_tpl_vars['factura']; ?>
&vbol=<?php echo $this->_tpl_vars['boletin']; ?>
"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <!-- <input type="text" name="vsol3" size="3" maxlength="4" value='<?php echo $this->_tpl_vars['vsol3']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol4)" onchange="Rellena(document.forlotes.vsol3,4);document.forlotes.vsol3.value=this.value;"> -->
        <select size='1' name='vsol3' onchange="document.forlotes.vsol3.value=this.value;">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayannos'],'selected' => $this->_tpl_vars['vsol3'],'output' => $this->_tpl_vars['arraynameano']), $this);?>

        </select> -
	<input type="text" name="vsol4" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol4']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" onchange="Rellena(document.forlotes.vsol4,6);document.forlotes.vsol4.value=this.value;">
	&nbsp;<?php echo $this->_tpl_vars['campo13']; ?>
&nbsp;
        <select size="1" name="npublica" class="required">
           <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['publica_id'],'selected' => $this->_tpl_vars['npublica'],'output' => $this->_tpl_vars['publica_de']), $this);?>

        </select>
	&nbsp;&nbsp;
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai2" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="buscarprensap(document.forlotes.vsol3,document.forlotes.vsol4,document.forlotes.vvienai2,document.forlotes.factura,document.forlotes.boletin,document.forlotes.pcantidad,document.forlotes.npublica)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae2" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="buscarprensap(document.forlotes.vsol3,document.forlotes.vsol4,document.forlotes.vvienae2,document.forlotes.factura,document.forlotes.boletin,document.forlotes.pcantidad,document.forlotes.npublica)">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar2" onclick="document.forlotes.vsol3.value='';document.forlotes.vsol4.value='';"> 
    </td></tr>
    </table>
    
   <p></p>
   &nbsp;
   <table width="210">
   <tr>
     <tr>
       <td class="cnt"><input type="image" src="../imagenes/boton_guardar_azul.png"></td> 
       <td class="cnt"><a href="m_ingfacpren.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>