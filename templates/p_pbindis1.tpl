<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="p_pbindise.php?vopc=1" method="post">
  <table>
        <tr><td class="izq5-color">{$campo1}</td>
	    <td class="der-color">
               <input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,2)">-
               <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$vsol2}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">&nbsp;
            </td>
            <td class="cnt"><input {$modo1} type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>

</form>				  

  </table>
  &nbsp; 
  <table cellspacing="1" border="1">	
  <tr>   
    <tr>
      <td class="izq-color">{$campo3}</td>
	   <td class="der-color"><input size="9" type="text" name="vfecsol" value='{$vfecsol|date_format:"%d/%m/%G"}' {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" rowspan="7" align="center">
          <a href='{$nameimage}' target="_blank">
          <img border="-1" src={$nameimage} width="230" height="230">
        </td>
      </td>
      {/if}
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color"><input size="1" type="text" name="vtipo" value='{$vtipo}' {$vmodo}>-
                            <input size="30" type="text" name="vtip" value='{$vtip}' {$vmodo}>  
      </td>
    </tr>
	 <tr>
	   <td class="izq-color">{$campo6}</td>
	   <td class="der-color"><input size="72" type="text" name="vnom" value='{$nombre}' {$vmodo}></td>
    </tr>
	 <tr>
	   <td class="izq-color">{$campo7}</td>
	   <td class="der-color"><input size="2" type="text" name="vest" value='{$vest}' {$vmodo}>
	                <input size="67" type="text" name="vdesest" value='{$vdesest}' {$vmodo}></td>
    </tr>
	 <tr><td class="izq-color">{$campo8}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='{$vfecreg|date_format:"%d/%m/%G"}' {$vmodo}></td>
    </tr>
	 <tr>
	    <td class="izq-color">{$campo9}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='{$vfecven|date_format:"%d/%m/%G"}' {$vmodo}></td>
    </tr>
	 <tr>
	    <td class="izq-color">{$campo10}</td>
	    <td class="der-color"><input size="72" type="text" name="vtrage" value="{$vtra}" {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr>
	 <tr>
	    <td class="izq-color">{$campo11}</td>
	    <td class="der-color"><input size="6" type="text" name="vcodtit" value='{$vcodtit}' {$vmodo}>
	                <input size="63" type="text" name="vnomtit" value='{$vnomtit}' {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr>
    <tr>
       <td class="izq-color">{$campo12}</td>
	    <td class="der-color"><input size="2" type="text" name="vnactit" value='{$vnactit}' {$vmodo}>
	                <input size="67" type="text" name="vnadtit" value='{$vnadtit}' {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr>
	 <tr>
	    <td class="izq-color">{$campo15}</td>
	    <td class="der-color"><input size="72" type="text" name="vdomtit" value='{$vdomtit}' {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr>
	 <tr>
	    <td class="izq-color">{$campo16}</td>
	    <td class="der-color">
	      <input size="4" type="text" name="locarno" value="{$locarno}" >
	    </td>
    </tr>

  </tr>
  </table>		
</form>
&nbsp;     
<form name="formarcas3" action="z_browdis.php?vopc=0&vtp=1" method="post" >
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vsol1' value={$vsol}>
  <input type ='hidden' name='v1' value={$vsol}>
  <input type ='hidden' name='clase' value={$vclase}>
  <input type ='hidden' name='vindcla' value={$vindcla}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='nameimage' value={$nameimage}>

  <input type ='hidden' name='camposquery' value='{$camposquery}'>
  <input type ='hidden' name='camposname'  value='{$camposname}'>
  <input type ='hidden' name='tablas'      value='{$tablas}'>
  <input type ='hidden' name='condicion'   value='{$condicion}'> 
  <input type ='hidden' name='orden'       value='{$orden}'>
  <input type ='hidden' name='modo'        value='{$modo}'> 
  <input type ='hidden' name='modoabr'     value='{$modoabr}'>
  <input type ='hidden' name='vurl'        value='{$vurl}'>
  <input type ='hidden' name='new_windows' value='{$new_windows}'>

  <table>
  <tr>
    <td>
      <p align='center'><b><font class="nota4">Se encontraron '{$universo}' Solicitudes en la Clase Locarno.! </font></b></p>
    </td>
  </tr>
  </table>

  <table class="menubar1" cellpadding="0" cellspacing="0" border="1">
  <tr>
   <td class="menudottedline" width="95%">
     <div class="pathway">
       <!--<img src="../imagenes/systeminfo.png"  align="left" border="0" /><br/>-->
     <p>
     <font size="-2">M&oacute;dulo:&nbsp;&nbsp;p_pbindise.php<p></b>Descripci&oacute;n: Rescata todas aquellas solicitudes de Patentes que presenten los C&oacute;digos de Locarno especificada.</font>
     </div>	
   </td>
   
   <td class="menudottedline" width="73%" ></td>
      <td class="menudottedline" align="right">
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	  <tr valign="left" align="left">
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" >
              <input type="image" {$modo3} src="../imagenes/find.png" value="Comparar" border="0">Comparar</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../patentes/p_pbindise.php?vopc=5">
	      <img src="../imagenes/cancel_f2.png" alt="&nbsp;Cancelar" name="Cancelar" title="Cancelar" align="left" border="0" /><br/>&nbsp;Cancelar</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../index1.php">
	      <img src="../imagenes/salir_f2.png"  alt="&nbsp;Logout" name="Salir" title="Salir" align="left" border="0" /><br/>&nbsp;Salir</a>
	    </td>
	    <td>&nbsp;</td>
	 </tr>
	</table>
      </td>
   </td>
  </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

  &nbsp;
  <!-- <table width="255" >
  <tr>
    <td class="cnt"><a href="m_pbinfigu.php"><input type="image" src="../imagenes/cancel_f2.png" value="Cancelar" border="0"></a>		Cancelar 	</td>
    <td class="cnt"><input type="image" {$modo3} src="../imagenes/find.png" value="Comparar" border="0"></a>		Comparar 	</td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir 		</td>
  </tr>
  </table> -->

</form>
</div>  
</body>
</html>
