<?php /* Smarty version 2.6.8, created on 2020-12-02 11:52:48
         compiled from m_rptpavztra_u.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_rptpavztra_u.tpl', 43, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="formarcas2" action="m_rptavztra_u.php" method="POST">
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <div align="center">
  <br>
  <table>
  <tr>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campot']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo9']; ?>

        <input type="text" name="desdec" value='<?php echo $this->_tpl_vars['desdec']; ?>
' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	<?php echo $this->_tpl_vars['campo8']; ?>

        <input type="text" name="hastac" value='<?php echo $this->_tpl_vars['hastac']; ?>
' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo2']; ?>
 
        <input type="text" name="desdet" value='<?php echo $this->_tpl_vars['desdet']; ?>
' size='9' onChange="valFecha(document.formarcas2.desdet)" onBlur="valagente(document.formarcas2.desdet,document.formarcas2.hastat)"> 
        <a href="javascript:showCal('Calendar71');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	<?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="hastat" value='<?php echo $this->_tpl_vars['hastat']; ?>
' size='9' onChange="valFecha(document.formarcas2.hastat)">
        <a href="javascript:showCal('Calendar72');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='evento'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayevento'],'selected' => $this->_tpl_vars['evento'],'output' => $this->_tpl_vars['arraydescri']), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayestatus'],'selected' => $this->_tpl_vars['estatus'],'output' => $this->_tpl_vars['arraydescri1']), $this);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo51']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='estatusant'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayestatus'],'selected' => $this->_tpl_vars['estatusant'],'output' => $this->_tpl_vars['arraydescri1']), $this);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        DESDE:<input type="text" name="boletin1" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
        HASTA:<input type="text" name="boletin2" size="4" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>   
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <input type="text" name="modalidad" size="3" maxlength="2">
      </td>
    </tr>   
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo82']; ?>
<select size='1' name='cplus'>
                             <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraycplus'],'selected' => $this->_tpl_vars['cplus'],'output' => $this->_tpl_vars['arraydescplus']), $this);?>

                             </select>
      </td>
      <td class="der-color">
        <input type="text" name="claseplus" size="3" maxlength="2">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><select size='1' name='vplus'>
                             <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayplus'],'selected' => $this->_tpl_vars['vplus'],'output' => $this->_tpl_vars['arraydesplus']), $this);?>

                             </select><?php echo $this->_tpl_vars['campo72']; ?>

      </td>
      <td class="der-color" >
        <select size='1' name='eventoplus'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayevento'],'selected' => $this->_tpl_vars['evento'],'output' => $this->_tpl_vars['arraydescri']), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo19']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='orden'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayorden'],'selected' => $this->_tpl_vars['orden'],'output' => $this->_tpl_vars['arrayorden']), $this);?>

        </select>
      </td>
    </tr> 
  </table><!--</font>--></center>
  <br>

   <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpavztra_u.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div>  
</form>
<br><br>
</body>
</html>