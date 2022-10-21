<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
    <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
    <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../include/template_css.css" type="text/css" />   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  <div align="center">

<form name="frmconsunid" action="z_consunid.php?vtip=2" method="POST" >
  <input type="hidden" name="vunid" value='{$vunid}'>
  <input type="hidden" name="n_conex" value='{$na_conex}'>
  
<table>
<tr>

 <table>
 <tr>
   <td width="100%">
     <div><strong> </strong></div>
   </td>
   <td >
     <table>
      <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>
         {if $vmodal eq 2}
            <a href="../comun/z_unidad.php?conx=1&na_conex={$na_conex}&nconex=0&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir
         {/if}
         {if $vmodal eq 1}
            <input type="image" name="salir" value="Salir" onclick="window.close()" src="../imagenes/salir_f2.png" alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;
         {/if}
       </td>
       <td>&nbsp;</td>
      </tr>
     </table>
   </td>
 </tr>
 </table>

 <div class="tab-page" id="modules-cpanel">
  <script type="text/javascript">
     var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
  </script>

  <div class="tab-page" id="module01"><h2 class="tab">B&aacute;sico</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module01" ) );
  </script>
  
  <table width="100%" border="3" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo1}</td><td class="der-color">
       <input type="text" name="vunid" {$modo} value='{$vunid}' size="3">
       &nbsp;&nbsp;{$campo2}&nbsp;&nbsp;
       <input type="text" name='vunidad' value='{$vunidad}' {$modo} size="50">
       &nbsp;&nbsp;{$campo3}&nbsp;&nbsp;
       <input type="text" name='vcreacion' value='{$vcreacion}' {$modo} size="25">
     </td>
   </tr>
  </tr> 
  </table>

  <table class="adminlist">
	<tr class="row0">
		<th width="5%" class="title">
			ID
		</th>
		<th width="9%" class="title">
			Cedula
		</th>
		<th width="30%" class="title">
			Nombre
		</th>
		<th width="12%" class="title" nowrap="nowrap">
			Login
		</th>
		<th width="12%" class="title" nowrap="nowrap">
		   Rol
		</th>
		<th width="5%" class="title" nowrap="nowrap">
		   Estatus
		</th>
		<th width="15%" class="title" nowrap="nowrap">
		   Ingreso
		</th>
		<th width="10%" class="title" nowrap="nowrap">
		   Eliminaci&oacute;n
		</th>
		<th width="1%" class="title">
		   
		</th>
		<th width="1%" class="title">
		   
		</th>
	</tr>
	
   <p align='center'><b><font size='3' color='#CC0000' face='Tahoma'>Mostrando {$inicio+1}-{$inicial} de {$total} Registros Encontrados </font></b></p>
   {section name=cont loop=$vnumrows}
      <tr class="row0">
	   <td width="5%">
		{$arr_user1[cont]}
		</a>		 
		</td>
		<td width="9%">
		{$arr_user2[cont]}
		</a>		 
		</td>
		<td width="30%">
		{$arr_user3[cont]}
		</td>
		<td width="12%" nowrap='nowrap'>
		{$arr_user4[cont]}
		</td>
		<td width="12%" nowrap='nowrap'>
		{$arr_user5[cont]}
		</a>		 
		</td>
		<td width="5%" nowrap='nowrap'>
      {if $arr_user6[cont] eq "1"} 
          <img src="../imagenes/tick.png" border="0"> 
      {else} 
          <img src="../imagenes/publish_x.png" border="0"> 
      {/if} 
		</td>
		<td width="15%" nowrap='nowrap'>
		{$arr_user7[cont]}
	   </td>
		<td width="10%" nowrap='nowrap'>
		{$arr_user8[cont]}
		</td>
		<td width="1%">
		</td>
		<td width="1%">
		</td>
	   </tr>
   {/section} 
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
   <input type="hidden" name="inicio" value='{$inicio}'> 
   <input type="hidden" name="cuanto" value='{$cuanto}'>
   <input type="hidden" name="total" value='{$total}'>
   <input type="hidden" name="vmodal" value='{$vmodal}'>
   <input type="hidden" name="navega" value='S'>

   {if $inicio > 0}
     <input type="submit" style="color: #CC0000; font-size: 10pt" name="atras" value="Previos {$minprev}" />
   {/if}
   
   {if ($total - $inicio) > $cuanto}
     <input type="submit" style="color: #CC0000; font-size: 10pt" name="adelante" value="Siguientes {$minsig}" />
   {/if}
   </tr>
   </table>
  </table>
  </div>

 </div>

</tr> 
</table>
</form>

</div>  
</body>
</html>
