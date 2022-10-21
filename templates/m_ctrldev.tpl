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

<table align='center' border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F9F9">
 <tr>
  <td width="79%" align="left">


<div align="center">
{if $vopc eq 3}
  <form name="forlotes" enctype="multipart/form-data" action="m_ctrldev.php?vopc=5"  method="POST" >  
{/if} 		  
{if $vopc eq 4}
  <form name="forlotes" enctype="multipart/form-data" action="m_ctrldev.php?vopc=1"  method="POST" >  
{/if} 		  
{if $vopc eq 6}
  <form name="forlotes" enctype="multipart/form-data" action="m_ctrldev.php?vopc=7"  method="POST" >  
{/if} 		  

  <table>
     <tr>
      <td class="izq5-color">{$campo4}</td>
      <td class="der7-color">
	      <input tabindex="1" type="text" name="nctrlcer" size="5" maxlength="5" value='{$nctrlcer}' readonly > 
      </td>
      {if $vopc eq 3}
      <td class="cnt">
        &nbsp;&nbsp;<input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
        </form>
      </td>
      {/if} 		  
      {if $vopc eq 4 || $vopc eq 6}
        <td class="cnt">
          &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">  
        </td>
      {/if}    
  </tr>
  </table>
  <br />
</form>				  

{if $vopc eq 1 || $vopc eq 5}
  <form name="forlotes" enctype="multipart/form-data" action="m_ctrldev.php?vopc=2"  method="POST" onsubmit='return pregunta();'>
{/if}    
   <input type="hidden" name="usuario" value='{$usuario}'>
   <input type="hidden" name="nctrlcer" value='{$nctrlcer}'>

   <font class='nota6'><b>SOLICITANTE, INTERESADO O AUTORIZADO:</b></font>
   &nbsp;
   <table cellspacing="1" border="1">
     <tr>
       <td class="izq-color">{$campo5}</td>
       <td class="der7-color" >
	      <input type="text" name="solicitante" {$modo} size="70" maxlength="80" value='{$solicitante}' onkeyup="this.value=this.value.toUpperCase()">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo6}</td>
       <td class="der7-color" >
	      <input type="text" name="cisolicita" {$modo} size="10" maxlength="10" value='{$cisolicita}'>
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo7}</td>
       <td class="der7-color" >
	      <input type="text" name="telefono" {$modo} size="15" maxlength="15" value='{$telefono}'>
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo8}</td>
       <td class="der7-color" >
	      <input type="text" name="correo" {$modo} size="70" maxlength="80" value='{$correo}'>
       </td>
     </tr>
    <tr>
      <td class="izq-color">{$campo9}</td>
      <td class="der7-color">
        <input type="checkbox" name="gestor_pn" {$modo} onClick="habilagen(document.forusing.agente,this)">Persona Natural Titular&nbsp;&nbsp;<br/>
        <input type="checkbox" name="gestor_pj" {$modo} onClick="habilagen(document.forusing.agente,this)">Rep. Persona Jur&iacute;dica Nacional&nbsp;&nbsp;<br/>  
        <input type="checkbox" name="gestor_ap" {$modo} onClick="habilagen(document.forusing.agente,this)">Apoderado&nbsp;&nbsp;<br/>
        <input type="checkbox" name="gestor_ag" {$modo} onClick="habilagen(document.forusing.agente,this)">Agente de la Propiedad Industrial No.&nbsp;&nbsp;
        <input type="text" name='agente' size='6' maxlength="6" {$modo} onkeyup="checkLength(event,this,5,document.forusing.autorizado);fn(this.form,this);" onKeyPress="return acceptChar(event,2,this)"><br/> 
      </td>
    </tr> 
    </table>

   &nbsp; <p></p>
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$campo3}</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:99%;height:180px;background-color: WHITE;' src="m_vercer.php?vcod={$nctrlcer}"></iframe> 
    </td></tr>
    <tr><td class="izq4-color">
        <input type="text" name="vreg1" {$modo} size="1" maxlength="1" value='{$vsol1}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forlotes.vreg2)" 
		    onchange="this.value=this.value.toUpperCase();document.forlotes.vreg1.value=this.value;">-
	     <input type="text" name="vreg2" {$modo} size="6" maxlength="6" value='{$vreg2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vvienai1)"  
		    onchange="Rellena(document.forlotes.vreg2,6);document.forlotes.vreg2.value=this.value;">
        <input type="button" class='boton_azul_cur' value="Buscar/Incluir"  name="vvienai1" {$modo2} onclick="cntrlcertificado(document.forlotes.vreg1,document.forlotes.vreg2,document.forlotes.vvienai1,document.forlotes.nctrlcer)">
        <input type="button" class='boton_azul_cur' value="Buscar/Eliminar" name="vvienae1" {$modo2} onclick="cntrlcertificado(document.forlotes.vreg1,document.forlotes.vreg2,document.forlotes.vvienae1,document.forlotes.nctrlcer)">  
        <input type="button" class='boton_azul_cur' value="Limpiar" name="limpiar" {$modo2} onclick="document.forlotes.vreg1.value='';document.forlotes.vreg2.value='';"> 
    </td></tr>
    </table>
    
   &nbsp;
   <table width="180">
    <tr>
     <tr>
      <td class="cnt"><input type="image" {$modo} src="../imagenes/boton_guardar_rojo.png"></td> 
      <td class="cnt"><a href="m_ctrldev.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
    </tr>
   </table>
   
   
</form>
</div>

 </tr>
</table>

  
</body>
</html>
