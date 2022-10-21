<?php /* Smarty version 2.6.8, created on 2020-10-28 11:30:52
         compiled from z_modusua1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_modusua1.tpl', 48, false),array('function', 'html_radios', 'z_modusua1.tpl', 62, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forusing1" action="z_modusua1.php?vopc=2" method="POST" onsubmit="return pregunta();">  
  <input type='hidden' name='idvalor' value='<?php echo $this->_tpl_vars['idvalor']; ?>
'> 
  <input type='hidden' name='vstring' value='<?php echo $this->_tpl_vars['vstring']; ?>
'>
  <input type='hidden' name='usuario' value='<?php echo $this->_tpl_vars['login']; ?>
'>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type='hidden' name='na_conex' value='<?php echo $this->_tpl_vars['na_conex']; ?>
'>
  <input type='hidden' name='conx' value=0>
  <input type='hidden' name='salir' value=0> 

  <div align="center">
    
  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='cedula' value='<?php echo $this->_tpl_vars['cedula']; ?>
' size="8" maxlength="8" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,8,document.forusing1.nombre)" <?php echo $this->_tpl_vars['modo2']; ?>
 >&nbsp;
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='60' maxlength="60" onKeyPress="return acceptChar(event,0, this)" onkeyup="checkLength(event,this,60,document.forusing1.email)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <input type='text' name='email' value='<?php echo $this->_tpl_vars['email']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='50' maxlength="50"></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='usuario' value='<?php echo $this->_tpl_vars['usuario']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size="12" maxlength="12" onKeyPress="return acceptChar(event,3, this)">
      </td>
    </tr>
    <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='depto_id' '<?php echo $this->_tpl_vars['modo2']; ?>
'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraydepto'],'selected' => $this->_tpl_vars['depto_id'],'output' => $this->_tpl_vars['arraynombre']), $this);?>

        </select>
    </td>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
         <select size='1' name='sede'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodsede'],'selected' => $this->_tpl_vars['sede'],'output' => $this->_tpl_vars['vnomsede']), $this);?>

         </select>
      </td>
    </tr>          
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color" >
        <?php echo smarty_function_html_radios(array('name' => 'estado','values' => $this->_tpl_vars['est_ids'],'selected' => $this->_tpl_vars['estado'],'output' => $this->_tpl_vars['est_def'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table width="350" >
  <tr>
    <td class="cnt">
      <a href="../comun/z_genpaswd.php?ced=<?php echo $this->_tpl_vars['cedula']; ?>
&nom=<?php echo $this->_tpl_vars['nombre']; ?>
&usr=<?php echo $this->_tpl_vars['usuario']; ?>
&email=<?php echo $this->_tpl_vars['email']; ?>
"><img src="../imagenes/security_f2.png" border="0" /></a>Generar Password</td>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td>
    <td class="cnt">
      <a href="../comun/z_usuarios.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>
  
</div>  
</form>

</body>
</html>