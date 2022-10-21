<?php /* Smarty version 2.6.8, created on 2021-08-09 12:57:01
         compiled from sipi_ftp.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'sipi_ftp.tpl', 13, false),array('function', 'math', 'sipi_ftp.tpl', 40, false),array('modifier', 'count', 'sipi_ftp.tpl', 40, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
<div align="center">
<form name="frmstatus1" action="sipi_ftp.php?vopc=2" method="POST">
  <table>
   <tr><td class="izq-color">IP Maquina Local: </td>
       <td class="der-color"><select size=1 name="vtip">
	        <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vtip'],'selected' => 1,'output' => $this->_tpl_vars['vtip']), $this);?>

       </select></td>
       <?php if ($this->_tpl_vars['vopc'] == 1): ?>
       <td class="cnt"><input type="image" src="../imagenes/buscar_f2.png" 
            value="Buscar">Buscar Archivos</td> 
       <?php endif; ?>
   </tr>
  </table> 
  
</form>
<form name="frmstatus2" action="sipi_ftp.php?vopc=3" method="POST">
  <?php if ($this->_tpl_vars['vopc'] == 2): ?>
  <input type="hidden" name="iploc" value="<?php echo $this->_tpl_vars['iploc']; ?>
">  
  <table><tr><td>Directorio: <b><?php echo $this->_tpl_vars['dir_local']; ?>
</b></td></tr></table>
  <table><tr><td>Total de Archivos para transferir: <b><?php echo $this->_tpl_vars['total_file']; ?>
</b></td></tr></table>
  &nbsp;&nbsp;
  <table border='2'>
    <tr>
    <?php unset($this->_sections['numloop']);
$this->_sections['numloop']['name'] = 'numloop';
$this->_sections['numloop']['loop'] = is_array($_loop=$this->_tpl_vars['elementos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['numloop']['show'] = true;
$this->_sections['numloop']['max'] = $this->_sections['numloop']['loop'];
$this->_sections['numloop']['step'] = 1;
$this->_sections['numloop']['start'] = $this->_sections['numloop']['step'] > 0 ? 0 : $this->_sections['numloop']['loop']-1;
if ($this->_sections['numloop']['show']) {
    $this->_sections['numloop']['total'] = $this->_sections['numloop']['loop'];
    if ($this->_sections['numloop']['total'] == 0)
        $this->_sections['numloop']['show'] = false;
} else
    $this->_sections['numloop']['total'] = 0;
if ($this->_sections['numloop']['show']):

            for ($this->_sections['numloop']['index'] = $this->_sections['numloop']['start'], $this->_sections['numloop']['iteration'] = 1;
                 $this->_sections['numloop']['iteration'] <= $this->_sections['numloop']['total'];
                 $this->_sections['numloop']['index'] += $this->_sections['numloop']['step'], $this->_sections['numloop']['iteration']++):
$this->_sections['numloop']['rownum'] = $this->_sections['numloop']['iteration'];
$this->_sections['numloop']['index_prev'] = $this->_sections['numloop']['index'] - $this->_sections['numloop']['step'];
$this->_sections['numloop']['index_next'] = $this->_sections['numloop']['index'] + $this->_sections['numloop']['step'];
$this->_sections['numloop']['first']      = ($this->_sections['numloop']['iteration'] == 1);
$this->_sections['numloop']['last']       = ($this->_sections['numloop']['iteration'] == $this->_sections['numloop']['total']);
?>
        <td width="25%"><?php echo $this->_tpl_vars['elementos'][$this->_sections['numloop']['index']]; ?>
</td>
        <?php if (! ( $this->_sections['numloop']['rownum'] % $this->_tpl_vars['cols'] )): ?>
                <?php if (! $this->_sections['numloop']['last']): ?>
                        </tr><tr>
                <?php endif; ?>
        <?php endif; ?>
        <?php if ($this->_sections['numloop']['last']): ?>
                                <?php echo smarty_function_math(array('equation' => "n - a % n",'n' => $this->_tpl_vars['cols'],'a' => count($this->_tpl_vars['elementos']),'assign' => 'cells'), $this);?>

                <?php if ($this->_tpl_vars['cells'] != $this->_tpl_vars['cols']): ?>
                <?php unset($this->_sections['pad']);
$this->_sections['pad']['name'] = 'pad';
$this->_sections['pad']['loop'] = is_array($_loop=$this->_tpl_vars['cells']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['pad']['show'] = true;
$this->_sections['pad']['max'] = $this->_sections['pad']['loop'];
$this->_sections['pad']['step'] = 1;
$this->_sections['pad']['start'] = $this->_sections['pad']['step'] > 0 ? 0 : $this->_sections['pad']['loop']-1;
if ($this->_sections['pad']['show']) {
    $this->_sections['pad']['total'] = $this->_sections['pad']['loop'];
    if ($this->_sections['pad']['total'] == 0)
        $this->_sections['pad']['show'] = false;
} else
    $this->_sections['pad']['total'] = 0;
if ($this->_sections['pad']['show']):

            for ($this->_sections['pad']['index'] = $this->_sections['pad']['start'], $this->_sections['pad']['iteration'] = 1;
                 $this->_sections['pad']['iteration'] <= $this->_sections['pad']['total'];
                 $this->_sections['pad']['index'] += $this->_sections['pad']['step'], $this->_sections['pad']['iteration']++):
$this->_sections['pad']['rownum'] = $this->_sections['pad']['iteration'];
$this->_sections['pad']['index_prev'] = $this->_sections['pad']['index'] - $this->_sections['pad']['step'];
$this->_sections['pad']['index_next'] = $this->_sections['pad']['index'] + $this->_sections['pad']['step'];
$this->_sections['pad']['first']      = ($this->_sections['pad']['iteration'] == 1);
$this->_sections['pad']['last']       = ($this->_sections['pad']['iteration'] == $this->_sections['pad']['total']);
?>
                        <td width="25%"> </td>
                <?php endfor; endif; ?>
                <?php endif; ?>
                </tr>
        <?php endif; ?>
    <?php endfor; endif; ?>
  </table>
  <?php endif; ?>
  &nbsp;
     <table width="50%">
        <tr>
        <?php if ($this->_tpl_vars['vopc'] == 2 && $this->_tpl_vars['total_file'] > 0): ?>
        <td class="cnt"><input type="image" src="../imagenes/reload_f2.png" 
            value="Guardar">Transferir Archivos</td> 
        <?php endif; ?>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0">
            </a>Salir</td>
	</tr>
     </table>
</form>				  
</div>  
</body>
</html>