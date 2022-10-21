<?php /* Smarty version 2.6.8, created on 2020-10-28 11:15:32
         compiled from z_usuarios.tpl */ ?>
<html>
<head>
  <link rel="STYLESHEET" href="../main.css" type="text/css"> 
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script type="text/javascript" src="../include/js/adminjavascript.js"></script>
</head>

<body >

<form name="foruser" action="z_usuarios.php" method="POST" >
  <input type='hidden' name='n_conex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
   
<div align="center">
 <div class="main">
 
  <table class="adminheading" border="0">
	<tr>
     <img src="../imagenes/cpanel.png" align="left" border="0" />
	  <th style="color: #CC0000; font-size: 16pt" >
	  <i><b>Panel de Configuraci&oacute;n</b></i>
	  </th>
	</tr>
  </table>

  <table class="adminheading">
	 <tr>
		<th class="user"></th>
		<td>
			Filtro:
		</td>
		<td>
			<input type="text" name="search" value="" />
			
		</td>
		<td width="right">
        <select name="filtro" class="inputbox" size="1">
	       <option value="0" selected="selected">- Selecione Modo Busqueda-</option>
	       <option value="id">Codigo ID</option>
	       <option value="cedula">Cedula</option>
	       <option value="usuario">Login</option>
        </select>
		</td>
	 </tr>
  </table>

  <table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
    <tr>
	   <td class="menudottedline" width="40%">
		  <div class="pathway">
		    <a href=""><strong> Usuarios </strong></a>
		  </div>	
		</td>
	   <td class="menudottedline" align="right">
		</td>
    </tr> 
  </table> 

  <table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
  <tr>

	<td class="menudottedline" width="100%">
     <div class="pathway">
       <img src="../imagenes/contactenos_oficinas.gif"  align="left" border="0" /><br/>
     </div>	
   </td>
   
   <td class="menudottedline" width="40%" ></td>

	<td class="menudottedline" align="right">
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	 <tr valign="left" align="left">
		<td>
			<a class="toolbar" href="../comun/z_ingusua.php?conx=1&na_conex=<?php echo $this->_tpl_vars['n_conex']; ?>
" >
         <input type='image' src="../imagenes/new_f2.png" value="1" alt="Nuevo" name="vopc" title="Nuevo" align="left" border="0" />Nuevo</a>				
		</td>
		<td>&nbsp;</td>
		<td>
			<a class="toolbar">
         <input type='image' src="../imagenes/search_f2.png" value="2" alt="Consultar" name="vopc" title="Consultar" align="left" border="0" onclick="browseconsulta(document.foruser.search,document.foruser.filtro,document.foruser.n_conex)" />Consultar</a>  
		</td>
		<td>&nbsp;</td>
	   <td>
			<a class="toolbar" href="../comun/z_usuarios.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0">
		   <img src="../imagenes/cancel_f2.png"  alt="&nbsp;Cancelar" name="Cancelar" title="Cancelar" align="left" border="0" /><br/>&nbsp;Cancelar</a>
		</td>
		<td>&nbsp;</td>
	   <td>
			<a class="toolbar" href="../comun/z_adminis.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=0">
		   <img src="../imagenes/salir_f2.png"  alt="&nbsp;Logout" name="Salir" title="Salir" align="left" border="0" /><br/>&nbsp;Salir</a>
		</td>
		<td>&nbsp;</td>
	 </tr>
	</table>
	</td>
  </tr>
  </table>


  <table class="adminlist">
	<tr class="row0">
		<th width="2%" class="title">
			ID
		</th>
		<th width="3%" class="title">
			Cedula
			<!-- <input type="checkbox" name="chk" value="" onClick="check(this.form.chk);"/> -->  
		</th>
		<th width="5%" class="title">
			Depto
		</th>
		<th width="32%" class="title" nowrap="nowrap">
			Nombre
		</th>
		<th width="10%" class="title" nowrap="nowrap">
		   Login
		</th>
		<th width="10%" class="title" nowrap="nowrap">
		   Rol
		</th>
		<th width="15%" class="title" nowrap="nowrap">
		   Estatus
		</th>
		<th width="15%" class="title" nowrap="nowrap">
		   Ingreso
		</th>
		<th width="4%" class="title">
		   Editar
		</th>
		<th width="4%" class="title">
		   Eliminar
		</th>
	</tr>
	
   <p align='center'><b><font size='3' color='#CC0000' face='Tahoma'>Mostrando <?php echo $this->_tpl_vars['inicio']+1; ?>
-<?php echo $this->_tpl_vars['inicial']; ?>
 de <?php echo $this->_tpl_vars['total']; ?>
 Registros Encontrados </font></b></p>
   <?php unset($this->_sections['cont']);
$this->_sections['cont']['name'] = 'cont';
$this->_sections['cont']['loop'] = is_array($_loop=$this->_tpl_vars['vnumrows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cont']['show'] = true;
$this->_sections['cont']['max'] = $this->_sections['cont']['loop'];
$this->_sections['cont']['step'] = 1;
$this->_sections['cont']['start'] = $this->_sections['cont']['step'] > 0 ? 0 : $this->_sections['cont']['loop']-1;
if ($this->_sections['cont']['show']) {
    $this->_sections['cont']['total'] = $this->_sections['cont']['loop'];
    if ($this->_sections['cont']['total'] == 0)
        $this->_sections['cont']['show'] = false;
} else
    $this->_sections['cont']['total'] = 0;
if ($this->_sections['cont']['show']):

            for ($this->_sections['cont']['index'] = $this->_sections['cont']['start'], $this->_sections['cont']['iteration'] = 1;
                 $this->_sections['cont']['iteration'] <= $this->_sections['cont']['total'];
                 $this->_sections['cont']['index'] += $this->_sections['cont']['step'], $this->_sections['cont']['iteration']++):
$this->_sections['cont']['rownum'] = $this->_sections['cont']['iteration'];
$this->_sections['cont']['index_prev'] = $this->_sections['cont']['index'] - $this->_sections['cont']['step'];
$this->_sections['cont']['index_next'] = $this->_sections['cont']['index'] + $this->_sections['cont']['step'];
$this->_sections['cont']['first']      = ($this->_sections['cont']['iteration'] == 1);
$this->_sections['cont']['last']       = ($this->_sections['cont']['iteration'] == $this->_sections['cont']['total']);
?>
      <tr class="row0">
	   <td width="2%">
      <a href="../comun/z_consuser.php?vuser=<?php echo $this->_tpl_vars['arr_user1'][$this->_sections['cont']['index']]; ?>
&vmod=id&vmodal=2&vtip=0&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&conx=0">
		<?php echo $this->_tpl_vars['arr_user1'][$this->_sections['cont']['index']]; ?>

		</a>		 
		</td>
		<td width="3%">
		<!-- <input type='checkbox' id='chk' name='chk' value='<?php echo $this->_tpl_vars['arr_user1'][$this->_sections['cont']['index']]; ?>
' /> -->
      <a href="../comun/z_consuser.php?vuser=<?php echo $this->_tpl_vars['arr_user2'][$this->_sections['cont']['index']]; ?>
&vmod=cedula&vmodal=2&vtip=0&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&conx=0">
		<?php echo $this->_tpl_vars['arr_user2'][$this->_sections['cont']['index']]; ?>

		</a>		 
		</td>
		<td width="5%">
		<?php echo $this->_tpl_vars['arr_user4'][$this->_sections['cont']['index']]; ?>

		</td>
		<td width="32%" nowrap='nowrap'>
		<?php echo $this->_tpl_vars['arr_user3'][$this->_sections['cont']['index']]; ?>

		</td>
		<td width="10%" nowrap='nowrap'>
		<a href="../comun/z_consuser.php?vuser=<?php echo $this->_tpl_vars['arr_user5'][$this->_sections['cont']['index']]; ?>
&vmod=usuario&vmodal=2&vtip=0&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&conx=0">
		<?php echo $this->_tpl_vars['arr_user5'][$this->_sections['cont']['index']]; ?>

		</a>		 
		</td>
		<td width="10%" nowrap='nowrap'>
		<?php echo $this->_tpl_vars['arr_user6'][$this->_sections['cont']['index']]; ?>

		</td>
		<td width="15%" nowrap='nowrap'>
      <?php if ($this->_tpl_vars['arr_user7'][$this->_sections['cont']['index']] == '1'): ?> 
          <img src="../imagenes/tick.png" border="0"> 
      <?php else: ?> 
          <img src="../imagenes/publish_x.png" border="0"> 
      <?php endif; ?> 
	   </td>
		<td width="15%" nowrap='nowrap'>
		<?php echo $this->_tpl_vars['arr_user8'][$this->_sections['cont']['index']]; ?>

		</td>
		<td width="4%">
		<a href='../comun/z_modusua1.php?vopc=1&valor=<?php echo $this->_tpl_vars['arr_user1'][$this->_sections['cont']['index']]; ?>
&n_conex=<?php echo $this->_tpl_vars['n_conex']; ?>
&conx=1'>
		<img src='../imagenes/edit.png'  name='editar' title='Editar' align='left' border='0'></a>
		</td>
		<td width="4%">
		<input type='image' name='elimina' src='../imagenes/erase.png' title='Eliminar' value='<?php echo $this->_tpl_vars['arr_user1'][$this->_sections['cont']['index']]; ?>
'>
	   <input type='hidden' name='valor' value='<?php echo $this->_tpl_vars['arr_user1'][$this->_sections['cont']['index']]; ?>
'>
		</td>
	   </tr>
   <?php endfor; endif; ?> 
   <input type='hidden' name='adelante'>
   <input type='hidden' name='atras'>

   <table>
    <div align="left">
    &nbsp;<img src="../imagenes/tick.png" border="0">&nbsp;Activo&nbsp;&nbsp;&nbsp;&nbsp;<img src="../imagenes/publish_x.png" border="0">&nbsp;Inactivo
    </div>
   </table>

   <table>
   <br />
   <tr>
   <input type="hidden" name="inicio" value='<?php echo $this->_tpl_vars['inicio']; ?>
'> 
   <input type="hidden" name="cuanto" value='<?php echo $this->_tpl_vars['cuanto']; ?>
'>
   <input type="hidden" name="total" value='<?php echo $this->_tpl_vars['total']; ?>
'>
   <input type="hidden" name="navega" value='S'>

   <?php if ($this->_tpl_vars['inicio'] > 0): ?>
     <input type="submit" style="color: #CC0000; font-size: 10pt" name="atras" value="Previos <?php echo $this->_tpl_vars['minprev']; ?>
" />
   <?php endif; ?>
   
   <?php if (( $this->_tpl_vars['total'] - $this->_tpl_vars['inicio'] ) > $this->_tpl_vars['cuanto']): ?>
     <input type="submit" style="color: #CC0000; font-size: 10pt" name="adelante" value="Siguientes <?php echo $this->_tpl_vars['minsig']; ?>
" />
   <?php endif; ?>
   </tr>
   </table>
   </form>

  </table>
  
</div>  
</form>

</body>
</html>