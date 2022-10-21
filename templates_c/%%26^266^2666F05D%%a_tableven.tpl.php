<?php /* Smarty version 2.6.8, created on 2021-01-27 13:41:27
         compiled from a_tableven.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'a_tableven.tpl', 50, false),array('function', 'html_options', 'a_tableven.tpl', 57, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
<div align="center">
<br>

<form name="frmstatus1" action="a_tableven.php?vopc=1" method="POST">
  <table>
  <tr>
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='evento' size="3" maxlength="3" value='<?php echo $this->_tpl_vars['evento']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 
               onKeyPress="return acceptChar(event,2, this)">&nbsp;
      </td>	
      <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 4): ?>
          <input type ='hidden' name='accion' value='Modificacion'>
          <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">
      <?php endif; ?>
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
          <input type ='hidden' name='accion' value='Ingreso'> 
          <input type='image' src="../imagenes/boton_nuevo_azul.png" value="Nuevo">
      <?php endif; ?> 
      </td>
    </tr>
  </tr>
  </table>
</form>				  


<form name="frmstatus2" action="a_tableven.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='evento' value=<?php echo $this->_tpl_vars['evento']; ?>
>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="90" maxlength="90" onKeyPress="return acceptChar(event,0, this)" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,90,document.forevento2.tipo_evento)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color" >
        <?php echo smarty_function_html_radios(array('name' => 'tipo_evento','values' => $this->_tpl_vars['tipo_eve'],'selected' => $this->_tpl_vars['tipo_evento'],'output' => $this->_tpl_vars['even_def'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <select size="1" name="inf_adicional" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="habilinf(document.forevento2.inf_adicional,document.forevento2.documento,document.forevento2.comentario)">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['tipo_inf'],'selected' => $this->_tpl_vars['inf_adicional'],'output' => $this->_tpl_vars['info_def']), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color"><input type='text' name='mensa_automatico' value='<?php echo $this->_tpl_vars['mensa_automatico']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size='90' maxlength="90" onKeyPress="return acceptChar(event,0, this)" onkeyup="this.value=this.value.toUpperCase()"></td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_plazo" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="habilplz(document.forevento2.tipo_plazo,document.forevento2.plazo_ley)">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['tipo_plz'],'selected' => $this->_tpl_vars['tipo_plazo'],'output' => $this->_tpl_vars['plazo_def']), $this);?>

        </select>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color" >
      <input type='text' name='plazo_ley' value='<?php echo $this->_tpl_vars['plazo_ley']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size='3' maxlength="3" onKeyPress="return acceptChar(event,2, this)"></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color"><input type='text' name='documento' value='<?php echo $this->_tpl_vars['documento']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size='20' maxlength="20" onKeyPress="return acceptChar(event,3, this)"></td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color"><input type='text' name='comentario' value='<?php echo $this->_tpl_vars['comentario']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size='40' maxlength="40" onKeyPress="return acceptChar(event,0, this)"></td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
        <select size="1" name="aplica" <?php echo $this->_tpl_vars['modo2']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['apli_inf'],'selected' => $this->_tpl_vars['aplica'],'output' => $this->_tpl_vars['apli_def']), $this);?>

        </select>
      </td>
    </tr>
      
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if (( $this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['accion'] == 2 ) || $this->_tpl_vars['vopc'] == 4): ?>
        <a href="a_tableven.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      <?php endif; ?>    
      <?php if (( $this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['accion'] == 1 ) || $this->_tpl_vars['vopc'] == 3): ?>
        <a href="a_tableven.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      <?php endif; ?>    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>

</form>
</div>  
</body>
</html>