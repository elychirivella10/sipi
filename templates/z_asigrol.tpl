<html>
<head>
  <link rel="STYLESHEET" href="../main.css" type="text/css"> 
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script type="text/javascript" src="../include/js/adminjavascript.js"></script>
</head>

<body>

<form name="forroles" action="z_asigrol.php" method="POST" >
 <input type='hidden' name='n_conex' value='{$n_conex}'>

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
			<input type="text" name="search" value=""/>
			
		</td>
		<td width="right">
        <select name="filtro" class="inputbox" size="1">
	       <option value="0" selected="selected">- Selecione Modo Busqueda-</option>
	       <option value="role">Codigo ID</option>
        </select>
		</td>
	 </tr>
  </table>

  <table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
    <tr>
	   <td class="menudottedline" width="40%">
		  <div class="pathway">
		    <a href=""><strong>Asignaci&oacute;n de Usuarios a Rol</strong></a>
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
       <img src="../imagenes/systeminfo.png"  align="left" border="0" /><br/>
     </div>	
   </td>
   
   <td class="menudottedline" width="40%" ></td>

	<td class="menudottedline" align="right">
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	 <tr valign="left" align="left">
		<td>
			<a class="toolbar" href="../comun/z_asgusrol.php?conx=1&na_conex={$n_conex}" >
         <input type='image' src="../imagenes/new_f2.png" value="1" alt="Nuevo" name="vopc" title="Asignaci&oacute;n" align="left" border="0" />Asignaci&oacute;n</a>				
		</td>
		<td>&nbsp;</td>
		<td>
			<a class="toolbar"> 
         <input type='image' src="../imagenes/search_f2.png" value="2" alt="Consultar" name="vopc" title="Consultar" align="left" border="0" onclick="browseconsulta(document.forroles.search,document.forroles.filtro,document.forroles.n_conex)" />Consultar</a>  
		</td>
		<td>&nbsp;</td>
	   <td>
			<a class="toolbar" href="../comun/z_asigrol.php?nconex={$n_conex}&salir=1&conx=0">
		   <img src="../imagenes/cancel_f2.png"  alt="&nbsp;Cancelar" name="Cancelar" title="Cancelar" align="left" border="0" /><br/>&nbsp;Cancelar</a>
		</td>
		<td>&nbsp;</td>
	   <td>
			<a class="toolbar" href="../comun/z_adminis.php?nconex={$n_conex}&salir=0">
		   <img src="../imagenes/salir_f2.png"  alt="&nbsp;Logout" name="Salir" title="Salir" align="left" border="0" /><br/>&nbsp;Salir</a>
		</td>
		<td>&nbsp;</td>
	 </tr>
	</table>
	</td>
  </tr>
  </table>

  <table class="adminlist">
	<tr class = "row0">
		<th width="2%" class="title">
			#
		</th>
		<th width="3%" class="title">
			<input type="checkbox" name="chk" value="" onClick="check(this.form.chk);"/> 
		</th>
		<th width="10%" class="title">
			ID
		</th>
		<th width="25%" class="title" >
			Nombre
		</th>
		<th width="5%" class="title" nowrap="nowrap">
		   Estado
		</th>
		<th width="20%" class="title">
		   Fecha Creaci&oacute;n
		</th>
		<th width="20%" class="title">
                   Fecha Eliminaci&oacute;n
		</th>
		<th width="5%" class="title">
		</th>
		<th width="5%" class="title">
		   Editar
		</th>
		<th width="5%" class="title">
		   <!-- Eliminar --> 
		</th>
	</tr>
  <p align="center"><b><font size="3" color="#CC0000" face="Tahoma">Mostrando {$inicio+1}-{$inicial} de {$total} Registros Encontrados </font></b></p>

   {section name=cont loop=$vnumrows}
      <tr class="row0">
	   <td width="2%">
		</td>
		<td width="3%">
		<input type="checkbox" id="chk" name="chk" value="{$arr_role1[cont]}" /> 
		</td>
		<td width="10%">
		<a href="../comun/z_consrole.php?vrol={$arr_role1[cont]}&vmodal=2&vtip=0&vopm=AR&nconex={$n_conex}&conx=0">
		{$arr_role1[cont]}
		</a>
		</td>
		<td width="25%" nowrap="nowrap">
		{$arr_role2[cont]}
		</td>
		<td width="5%" nowrap="nowrap">
                {if $arr_role3[cont] eq "A"} 
                   <img src="../imagenes/tick.png" border="0"> 
                {else} 
                   <img src="../imagenes/publish_x.png" border="0"> 
                {/if} 
		</td>
		<td width="20%" nowrap="nowrap">
                {$arr_role4[cont]}
		</td>
		<td width="20%" nowrap="nowrap" align="center">
                {$arr_role5[cont]}
		</td>
		<td width="5%" nowrap="nowrap">
		</td>
		<td width="5%">
		<a href="../comun/z_elmrolus.php?vopc=1&valor={$arr_role1[cont]}&n_conex={$n_conex}&conx=1">
		<img src="../imagenes/edit.png"  name="editar" title="Editar" align="left" border="0"></a>
		</td>
		<td width="5%">
		<!-- <input type="image" name="elimina" src="../imagenes/erase.png" title="Eliminar" value="{$arr_unid1[cont]}">
	   <input type="hidden" name="valor" value="{$arr_role1[cont]}"> -->
		</td>
	   </tr>
   {/section} 
   <input type="hidden" name="adelante">
   <input type="hidden" name="atras">
   <table>
   <br />
   <tr>
   <input type="hidden" name="inicio" value="{$inicio}"> 
   <input type="hidden" name="cuanto" value="{$cuanto}">
   <input type="hidden" name="total" value="{$total}">
   <input type="hidden" name="navega" value="S">
   {if $inicio > 0}
     <input type="submit" style="color: #CC0000; font-size: 10pt" name="atras" value="Previos {$minprev}" />
   {/if}
   {if ($total - $inicio) > $cuanto}
     <input type="submit" style="color: #CC0000; font-size: 10pt" name="adelante" value="Siguientes {$minsig}" />
   {/if}
   </tr>
   </table>
   </form>
  </table>

</div>  
</form>

</body>
</html>
