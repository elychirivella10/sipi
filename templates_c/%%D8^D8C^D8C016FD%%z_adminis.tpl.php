<?php /* Smarty version 2.6.8, created on 2020-10-20 10:22:50
         compiled from z_adminis.tpl */ ?>
<html>
<head>
  <link rel="STYLESHEET" href="../main.css" type="text/css"> 
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body >

<div align="center">
<!-- <div class="main"> 

  <form name="foruser" action="z_adminis.php" method="POST" > -->

<table width="960px" border="0">

 	<table class="adminheading" border="0">
	 <tr>
      <img src="../imagenes/cpanel.png" align="left" border="0">
	   <th style="color: #CC0000; font-size: 16pt" >
	     <i><b>Panel de Configuraci&oacute;n</b></i>
	   </th>
	 </tr>
	</table>

   <table>
   <!--<table class="adminform"> -->
    <tr>

	  <td  valign="top">
	    <div id="cpanel">
	    
		  <div style="float:left;">
			<div class="icon">
			  <a href="../comun/z_unidad.php?conx=2&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
">
				 <img src="../imagenes/frontpage.png"  alt="Unidades" align="middle" border="0" /><span>Administraci&oacute;n de Departamentos</span>
			  </a>
			</div>
		  </div>

		  <div style="float:left;">
			<div class="icon">
			  <a href="../comun/z_roles.php?conx=2&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
">
				 <img src="../imagenes/systeminfo.png"  alt="Roles" align="middle" border="0" /><span>Administraci&oacute;n de Roles</span>
			  </a>
			</div>
		  </div>

		  <div style="float:left;">
			<div class="icon">
			  <a href="../comun/z_objmenu.php?conx=2&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
">
					<img src="../imagenes/menu.png"  alt="Menus" align="middle" border="0" /><span>Administraci&oacute;n de Menus</span>
			  </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
			  <a href="../comun/z_usuarios.php?conx=2&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
">
				<img src="../imagenes/contactenos_oficinas.gif"  alt="Usuarios" align="middle" border="0" /><span>Usuarios</span>
			  </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
			 <a href="../comun/z_asigmenu.php?conx=2&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
">
			  <img src="../imagenes/addedit.png"  alt="Asignacion Menu" align="middle" border="0" /><span>Administraci&oacute;n de Menus en Rol</span>
			 </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
  			 <a href="../comun/z_evenrol.php?conx=2&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
">
			  <img src="../imagenes/addedit.png"  alt="Asignacion Evento" align="middle" border="0" /><span>Administraci&oacute;n de Eventos en Rol</span>
			 </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
			  <a href="../comun/z_asigrol.php?conx=2&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
">
				<img src="../imagenes/addedit.png"  alt="Asignacion Rol" align="middle" border="0" /><span>Administraci&oacute;n de Usuarios en Rol</span>
			  </a>
			</div>
		  </div>

		  <div style="float:left;">
			<div class="icon">
			 <a href="../comun/z_rptuser.php">
			  <img src="../imagenes/query.png"  alt="Consulta de Usuario" align="middle" border="0" /><span>Consulta de Usuario</span>
			 </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
			 <a href="../comun/z_rptroles.php">
			  <img src="../imagenes/buscar_rol.png"  alt="Consulta por Rol" align="middle" border="0" /><span>Consulta por Rol</span>
			 </a>
			</div>
		  </div>

		  <div style="float:left;">
			<div class="icon">
			 <a href="">
			  <img src="../imagenes/contactenos_pagina.gif"  alt="Conexiones" align="middle" border="0" /><span>Conexiones</span> 
			 </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
			 <a href="">
			  <img src="../imagenes/backup.png"  alt="User Manager" align="middle" border="0" /><span>Bitacora</span>
			 </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
			 <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
">
			  <img src="../imagenes/salir_f2.png"  alt="Salir" align="middle" border="0" /><span>Salir de la Administraci&oacute;n</span>
			 </a>
			</div>
		  </div>
		  
		 </div>
	    <div style="clear:both;"></div>
	  </td>
	  
	<!-- <td width="45px" valign="top">
	
    <div style="width: 100%;">
    
     <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="http://localhost/joomla/includes/js/tabs/tabpane.css" />
   	<script type="text/javascript" src="../include/tabs/tabpane_mini.js"></script>
	   <div class="tab-page" id="modules-cpanel">
	   <script type="text/javascript">
	      var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
      </script>
      
      <div class="tab-page" id="module32"><h2 class="tab">Conexiones</h2>
      <script type="text/javascript">
         tabPane1.addTabPage( document.getElementById( "module32" ) );
      </script>
   
  		<table class="adminlist">
		 <tr>
	  		<th colspan="4">
	   		Usuarios Actualmente Conectados
	  		</th>
   	  </tr>
		  <tr>
	      <td width="5%">
				1		
			</td>
			<td>
				<a href="index2.php?option=com_users&task=editA&hidemainmenu=1&id=62" title="Editar Usuario">admin</a></td>
	 		<td>
				Super Administrator
	 		</td>
	 		<td>
	  			<a href="index2.php?option=com_users&task=flogout&id=62">
	   		<img src="images/publish_x.png" width="12" height="12" border="0" alt="Logout" Title="Forzar Salida Usuario" />
	  			</a>
	 		</td>
		 </tr>
      </table>
  
	   <table class="adminlist">
	   <tr>
 		 <th colspan="3">
	     <span class="pagenav">&lt;&lt;&nbsp;Start</span>
	     <span class="pagenav">&lt;&nbsp;Previous</span>
	     <span class="pagenav"> 1 </span>
	     <span class="pagenav">Next&nbsp;&gt;</span>
	     <span class="pagenav">End&nbsp;&gt;&gt;</span>
   	 </th>
	   </tr>
	   <tr>
	    <td nowrap="nowrap" width="48%" align="right">Display #
	    </td>
	    <td>
	     <select name="limit" class="inputbox" size="1" onchange="document.adminForm.submit();"> 
	  	   <option value="5">5</option>
		   <option value="10">10</option>
	 	   <option value="15">15</option>
		   <option value="20">20</option>
		   <option value="25">25</option>
		   <option value="30" selected="selected">30</option>
	      <option value="50">50</option>
	     </select>
	      <input type="hidden" name="limitstart" value="0" />
	     </td>
	    <td nowrap="nowrap" width="48%" align="left">
	      Results 1 - 1 of 1
	    </td>
	   </tr>
	   </table>

	   <input type="hidden" name="option" value="" />
	   </div> -->

  
  <!-- <div class="tab-page" id="module20">
  <h2 class="tab">Estadisticas</h2>
  <script type="text/javascript">
    tabPane1.addTabPage( document.getElementById( "module20" ) );
  </script>
  <table class="adminlist">
   <tr>
	  <th class="title">
		Most Popular Items
	  </th>
	  <th class="title">
		Created
	  </th>
	  <th class="title">
		Hits
	  </th>
   </tr>
	<tr>
		<td>
			<a href="index2.php?option=com_content&amp;task=edit&amp;hidemainmenu=1&amp;id=11">
				Example FAQ Item 2</a>
		</td>
		<td>
			2004-05-12 11:54:06		
		</td>
		<td>
			10		
		</td>
	</tr>
	<tr>
		<td>
			<a href="index2.php?option=com_typedcontent&amp;task=edit&amp;hidemainmenu=1&amp;id=5">
				Joomla! License Guidelines</a>
		</td>
		<td>
			2004-08-19 20:11:07		
		</td>
		<td>
			10
		</td>
	</tr>
	<tr>
		<td>
			<a href="index2.php?option=com_content&amp;task=edit&amp;hidemainmenu=1&amp;id=10">
				Example FAQ Item 1</a>
		</td>
		<td>
			2004-05-12 11:54:06		
		</td>
		<td>
			8		
		</td>
	</tr>
  </table>
  </div> 


  </div>
  </div>
  </td> -->
  </tr>
  </table>
  </div>


</div>
</div>  

</table>
</form>

</body>
</html>