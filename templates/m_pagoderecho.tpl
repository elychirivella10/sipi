<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<table align='center' border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
  <td width="79%" align="left">

<div align="center">
{if $vopc eq 3}
  <form name="forlotes" enctype="multipart/form-data" action="m_pagoderecho.php?vopc=5"  method="POST" >  
{/if} 		  
{if $vopc eq 4}
  <form name="forlotes" enctype="multipart/form-data" action="m_pagoderecho.php?vopc=1"  method="POST" >  
{/if} 		  
{if $vopc eq 6}
  <form name="forlotes" enctype="multipart/form-data" action="m_pagoderecho.php?vopc=7"  method="POST" >  
{/if} 		  

  <table>
     <tr>
      <td class="der8-color">{$campo1}</td>
      <td class="der7-color">
	      <input tabindex="1" type="text" name="factura" size="6" maxlength="6" value='{$factura}' {$modo1}> 
      </td>
      {if $vopc eq 3}
      <td class="cnt">
        <!-- &nbsp;&nbsp;<input type="submit" id="B1" value="Buscar" align="center" class="boton_azul_var"> -->
        &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  
      </td>
      {/if} 		  
      {if $vopc eq 4 || $vopc eq 6}
        <td class="cnt">
          &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  
        </td>
      {/if}    
  </tr>
  </table> 
</form>			  
<br>
{if $vopc eq 1 || $vopc eq 5}
  <form name="forlotes" enctype="multipart/form-data" action="m_pagoderecho.php?vopc=2"  method="POST" onsubmit='return pregunta();'>
{/if}    
   <input type="hidden" name="usuario" value='{$usuario}'>
   <input type="hidden" name="factura" value='{$factura}'>
  
   &nbsp;
   <font class='nota6'><b>DATOS DEL SOLICITANTE Y BOLETIN:</b></font>
   &nbsp;
   <table cellspacing="1" border="1">
     <tr>
       <td class="izq-color">{$campo2}</td>
       <td class="der7-color" >
	      <input type="text" name="fechafac" size="7" maxlength="10" value='{$fechafac|date_format:"%d/%m/%G"}' readonly="readonly">  
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo3}</td>
       <td class="der7-color" >
	      <input type="text" name="solicitante" size="70" maxlength="80" value='{$solicitante}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo4}</td>
       <td class="der7-color" >
	      <input type="text" name="cisolicita" size="9" maxlength="10" value='{$cisolicita}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo5}</td>
       <td class="der7-color" >
	      <input type="text" name="domicilio" size="70" maxlength="90" value='{$domicilio}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo6}</td>
       <td class="der7-color" >
	      <input type="text" name="telefono" size="10" maxlength="10" value='{$telefono}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo7}</td>
       <td class="der7-color" >
	      <input type="text" name="cantidad" size="3" maxlength="3" value='{$cantidad}' readonly="readonly">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo8}</td>
       <td class="der7-color" >
	      <input type="text" name="boletin" {$modo} size="4" maxlength="4" value='{$boletin}' onchange="valagente(document.forlotes.boletin,document.forlotes.nbol)">
       </td>
     </tr>
    </table>

   &nbsp; <p></p>
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$campo9}</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:99%;height:180px;background-color: WHITE;' src="m_verpago.php?vcod={$factura}"></iframe> 
    </td></tr>
    
    <tr><td class="der-color">
        <input type="text" name="vsol1" size="3" maxlength="4" value='{$vsol1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol2)" 
		    onchange="Rellena(document.forlotes.vsol1,4);document.forlotes.vsol1.value=this.value;">-
	<input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" 
		    onchange="Rellena(document.forlotes.vsol2,6);document.forlotes.vsol2.value=this.value;">
      
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai1" onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienai1,document.forlotes.factura,document.forlotes.nbol)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae1" onclick="buscarprensa(document.forlotes.vsol1,document.forlotes.vsol2,document.forlotes.vvienae1,document.forlotes.factura,document.forlotes.nbol)">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar" onclick="document.forlotes.vsol1.value='';document.forlotes.vsol2.value='';"> 
    </td></tr>
    </table>
    
   &nbsp;
   <table width="380" >
   <tr>
    <td class="cnt"><a href="m_pagoderecho.php?vopc=3"><img tabindex="12" src="../imagenes/restore_f2.png" border="0"></a>Cancelar</td>      
    <td class="cnt"><input tabindex="10" name="Guardar" type="image" src="../imagenes/database_save.png" value="Guardar">Guardar</td> 
    <td class="cnt"><a href="../index1.php"><img tabindex="13" src="../imagenes/salir_f2.png" border="0"></a>Salir</td>
   </tr>
   </table>
     
</form>
</div>

 </tr>
</table>

  
</body>
</html>
