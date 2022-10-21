<?php /* Smarty version 2.6.8, created on 2020-10-22 10:51:16
         compiled from m_evepago.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_evepago.tpl', 40, false),array('modifier', 'date_format', 'm_evepago.tpl', 86, false),)), $this); ?>
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


<form name="forlotes" enctype="multipart/form-data" action="m_evepago.php?vopc=2"  method="POST" >
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
   <input type="hidden" name="totalpag" value='<?php echo $this->_tpl_vars['totalpag']; ?>
'>
   <input type="hidden" name="codpago" value='<?php echo $this->_tpl_vars['codpago']; ?>
'>
        
 <!--  <table cellspacing="1" border="1">
   <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color" >
    	     <input type="text" name="nprensa" size="5" maxlength="5" value='<?php echo $this->_tpl_vars['nprensa']; ?>
' readonly >
      </td>
    </tr>

     <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
	   <td class="der-color">
               <select size='1' name='tipo'>
                   <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipo'],'selected' => $this->_tpl_vars['tipo'],'output' => $this->_tpl_vars['arraytipo']), $this);?>

               </select>

       <td>
      </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color" >
       
         <input type="text" name="fechaper" <?php echo $this->_tpl_vars['modo2']; ?>
 value='<?php echo $this->_tpl_vars['fechaper']; ?>
' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forlotes.vpag)" onchange="valFecha(this,document.forlotes.vpag)" >
&nbsp;
         <a href="javascript:showCal('Calendar65');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         
      </td>
    </tr>
    
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color" >
    	     <input type="text" name="vpag" size="5" maxlength="5" value='<?php echo $this->_tpl_vars['vpag']; ?>
' >
      </td>
    </tr>
    
     <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color" >
        <input name="ubicacion" type="file" <?php echo $this->_tpl_vars['modo2']; ?>
 value='<?php echo $this->_tpl_vars['ubicacion']; ?>
' size="25" onChange="javascript:document.forlotes.picture.src = 'file:///'+ document.forlotes.ubicacion.value;">
      </td>
    </tr>   
    
    </table> --> 

   &nbsp;
   <font class='nota7'><b>DATOS DE LA FACTURA, SOLICITANTE Y BOLETIN:</b></font>
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
       <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
       <td class="der7-color" >
	      <input type="text" name="cantidad" size="2" maxlength="3" value='<?php echo $this->_tpl_vars['cantidad']; ?>
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
    </table>

    <p></p>
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2"><?php echo $this->_tpl_vars['campo9']; ?>
</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:960px;height:90px;background-color: WHITE;' src="m_verpagos.php?vcod=<?php echo $this->_tpl_vars['factura']; ?>
&vbol=<?php echo $this->_tpl_vars['boletin']; ?>
"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vsol1" size="3" maxlength="4" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol2)" 
		    onchange="Rellena(document.forlotes.vsol1,4);document.forlotes.vsol1.value=this.value;">-
	<input type="text" name="vsol2" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol2']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" 
		    onchange="Rellena(document.forlotes.vsol2,6);document.forlotes.vsol2.value=this.value;">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai1" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienai1,document.forlotes.factura,document.forlotes.boletin,document.forlotes.cantidad)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae1" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienae1,document.forlotes.factura,document.forlotes.boletin,document.forlotes.cantidad)">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar" onclick="document.forlotes.vsol1.value='';document.forlotes.vsol2.value='';"> 
    </td></tr>
    </table>
    
   <p></p>
   &nbsp;
   <table width="210">
   <tr>
     <tr>
       <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png"></td> 
       <td class="cnt"><a href="m_ingfacbol.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>