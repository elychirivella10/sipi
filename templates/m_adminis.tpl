<html>
<head>
  <link rel="STYLESHEET" href="../main.css" type="text/css"> 
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body >

<div align="center">
 <div class="main">

    <form name="foruser" action="m_adminis.php" method="POST" >

 	<table class="adminheading" border="0">
	 <tr>
      <img src="../imagenes/query.png" align="left" border="0">
	   <th style="color: #CC0000; font-size: 16pt" >
	     <i><b>Panel de Opciones B&uacute;squeda Fon&eacute;tica</b></i>
	   </th>
	 </tr>
	</table>

   <table class="adminform">
    <tr>

	  <td width="55%" valign="top">
	    <div id="cpanel">
	    
		  <div style="float:left;">
			<div class="icon">
			  <a href="../marcas/m_abfontxt.php">
				 <img src="../imagenes/download_f2.png"  alt="Unidades" align="middle" border="0" /><span>Generar Archivo TXT Taquilla</span>
			  </a>
			</div>
		  </div>

		  <div style="float:left;">
			<div class="icon">
			  <a href="../comun/m_btxtpdfext.php?vopc=1">
				 <img src="../imagenes/copy_f2.png"  alt="Roles" align="middle" border="0" /><span>Transformar Archivos TXT a PDF</span>
			  </a>
			</div>
		  </div>

		  <div style="float:left;">
			<div class="icon">
			  <a href="../marcas/m_busfonpdfsr.php?vopc=1">
					<img src="../imagenes/menu.png"  alt="Menus" align="middle" width="38%" border="0" /><span>Generar Resultado PDF sin Antecedentes</span>
			  </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
			  <a href="../comun/m_mailbusqext.php?vopc=1">
				<img src="../imagenes/massemail.png"  alt="Usuarios" width="40%" align="middle" border="0" /><span>Envio de Resultados PDF por Correo</span>
			  </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
			 <a href="../marcas/m_actenvfon.php?vopc=4">
			  <img src="../imagenes/addedit.png"  alt="Asignacion Menu" width="35%" align="middle" border="0" /><span>Actualizacion de Estatus para Re-Envio de Resultados</span>
			 </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
  			 <a href="../marcas/m_veribusfon.php?vopc=1">
			  <img src="../imagenes/properties_f2.png"  alt="Asignacion Evento" align="middle" border="0" /><span>Verificaci&oacute;n de Env&iacute;o de Resultados por Correo</span>
			 </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
			  <a href="../marcas/m_rptconfon.php">
				<img src="../imagenes/printmgr.png"  alt="Asignacion Rol" align="middle" border="0" /><span>Factura B&uacute;squeda Fonetica Cargadas</span>
			  </a>
			</div>
		  </div>

		  <div style="float:left;">
			<div class="icon">
			 <a href="">
			  <img src=""  alt="" align="middle" border="0" /><span></span>
			 </a>
			</div>
		  </div>
		  
		  <div style="float:left;">
			<div class="icon">
			 <a href="">
			  <img src=""  alt="" align="middle" border="0" /><span></span>
			 </a>
			</div>
		  </div>

		  <div style="float:left;">
			<div class="icon">
			 <a href="../salir.php?nconex={$n_conex}">
			  <img src="../imagenes/salir_f2.png"  alt="Salir" align="middle" border="0" /><span>Salir de Panel Fon&eacute;tico</span>
			 </a>
			</div>
		  </div>
		  
		 </div>
	    <div style="clear:both;"></div>
	  </td>
	<td width="45%" valign="top">
	
 
  <div class="tab-page" id="module20">
  <h2 class="tab">Estad&iacute;sticas</h2>
  <script type="text/javascript">
    tabPane1.addTabPage( document.getElementById( "module20" ) );
  </script>
  <table class="adminlist">
   <tr>
	  <th class="title">
		Indicador
	  </th>
	  <th class="title">
		Cantidad
	  </th>
   </tr>
	<tr>
		<td>
			Total B&uacute;squedas por Impresora:
		</td>
		<td>
			<input type="text" name="tcorreo" {$modo} value='{$timpresora}' size="10" STYLE="text-align:right">		
		</td>
	</tr>
	<tr>
		<td>
			Total B&uacute;squedas por Correo:
		</td>
		<td>
			<input type="text" name="tcorreo" {$modo} value='{$tcorreo}' size="10" STYLE="text-align:right">		
		</td>
	</tr>
	<tr>
		<td>
			Total B&uacute;squedas por Correo sin Enviar:
		</td>
		<td>
			<input type="text" name="tcorreo" {$modo} value='{$tsinenviar}' size="10" STYLE="text-align:right">		
		</td>
	</tr>
	<tr>
		<td>
			Total B&uacute;squedas por Correo de Hoy hasta ahora cargadas:
		</td>
		<td>
			<input type="text" name="tcorreo" {$modo} value='{$tcorreohoy}' size="10" STYLE="text-align:right">		
		</td>
	</tr>
  </table>
  </div>


  </div>
  </div>
  </td>
  </tr>
  </table>
  </div>


</div>
</div>  
</form>

</body>
</html>
