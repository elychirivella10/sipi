<?php /* Smarty version 2.6.8, created on 2020-10-20 10:42:24
         compiled from a_tabldper.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'a_tabldper.tpl', 85, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
<div align="center">
<form name="frmstatus1" action="a_tabldper.php?vopc=1" method="POST">
  <table>
  <tr>
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo01']; ?>
</td>
      <td class="der-color">
      <!--  <select size='1' name='evento0'>";
         <option value='V'>V</option>
         <option value='E'>E</option>
         <option value='P'>P</option>
        </select> -->
        <input type="text" name='titular' size="8" maxlength="9" value='<?php echo $this->_tpl_vars['titular']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
> 
<!--               onKeyPress="return acceptChar(event,3, this)"> -->
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


<form name="frmstatus2" action="a_tabldper.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='titular' value=<?php echo $this->_tpl_vars['titular']; ?>
>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <select size='1' name='lced'>";
         <option value='V'>V</option>
         <option value='E'>E</option>
         <option value='P'>P</option>
        </select> 
        <input type="text" name='nced' size="9" maxlength="9" value='<?php echo $this->_tpl_vars['nced']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 
               onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.frmstatus2.nced,9)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="60" maxlength="60"  
               onchange="checkLength(event,this,60,document.frmstatus2.fechanac); this.value=this.value.toUpperCase();">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color" >
        <input type="text" name='fechanac' value='<?php echo $this->_tpl_vars['fechanac']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="10" maxlength="10"  
               onkeyup="checkLength(event,this,10,document.frmstatus2.fechadef)"
               onchange="valFecha(this,document.frmstatus2.fechadef)">
        <small>Formato: dd/mm/aaaa</small>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type="text" name='fechadef' value='<?php echo $this->_tpl_vars['fechadef']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="10" maxlength="10"  
               onkeyup="checkLength(event,this,10,document.frmstatus2.estado)"
               onchange="valFecha(this,document.frmstatus2.estado)">
        <small>Formato: dd/mm/aaaa</small> 
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
           <select size="1" name="estado" <?php echo $this->_tpl_vars['modo1']; ?>
>
              <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vestado_id'],'selected' => $this->_tpl_vars['estado'],'output' => $this->_tpl_vars['vestado_de']), $this);?>

           </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo13']; ?>
</td>
      <td class="der-color">
           <select size="1" name="indole" <?php echo $this->_tpl_vars['modo1']; ?>
>
              <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vindole_id'],'selected' => $this->_tpl_vars['indole'],'output' => $this->_tpl_vars['vindole_de']), $this);?>

           </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo81']; ?>
</td>
      <td class="der-color">
        <input type="text" name='telefono1' value='<?php echo $this->_tpl_vars['telefono1']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="15" maxlength="15"  
               onKeyPress="return acceptChar(event,9, this)" 
               onchange="checkLength(event,this,15,document.frmstatus2.fax)">
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo82']; ?>
</td>
      <td class="der-color">
        <input type="text" name='telefono2' value='<?php echo $this->_tpl_vars['telefono2']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="15" maxlength="15"  
               onKeyPress="return acceptChar(event,9, this)" 
               onchange="checkLength(event,this,15,document.frmstatus2.fax)">
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <input type="text" name='fax' value='<?php echo $this->_tpl_vars['fax']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="15" maxlength="15"  
               onKeyPress="return acceptChar(event,9, this)" 
               onchange="checkLength(event,this,15,document.frmstatus2.email)">
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo12']; ?>
</td>
      <td class="der-color">
        <input type="text" name='email' value='<?php echo $this->_tpl_vars['email']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="60" maxlength="120"  
               onchange="checkLength(event,this,120,document.frmstatus2.profesion)">
        <small></small>   
      </td>
    </tr>  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
        <input type="text" name='profesion' value='<?php echo $this->_tpl_vars['profesion']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 
               size="40" maxlength="40"  
               onkeyup="this.value=this.value.toUpperCase()" 
               onchange="checkLength(event,this,90,document.frmstatus2.seudonimo)">
        <!-- onKeyPress="return acceptChar(event,13, this)" -->               
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo11']; ?>
</td>
      <td class="der-color">
        <input type="text" name='seudonimo' value='<?php echo $this->_tpl_vars['seudonimo']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 
               size="40" maxlength="80"  
               onkeyup="this.value=this.value.toUpperCase()">
        <!-- onKeyPress="return acceptChar(event,13, this)" -->               
      </td>
    </tr>  
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_guardar_azul.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if (( $this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['accion'] == 2 ) || $this->_tpl_vars['vopc'] == 4): ?>
        <a href="a_tabldper.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      <?php endif; ?>    
      <?php if (( $this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['accion'] == 1 ) || $this->_tpl_vars['vopc'] == 3): ?>
        <a href="a_tabldper.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
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