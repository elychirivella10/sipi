<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
{if $vopc eq 3}
<form name="frmagente1" action="z_agentes.php?vopc=5" method="POST">
{/if}
{if $vopc eq 4}
<form name="frmagente1" action="z_agentes.php?vopc=1" method="POST">
{/if}
  <table>
  <tr>
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name='agente' size="5" maxlength="5" value='{$agente}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,5,document.frmstatus2.nombre)" onchange="valagente(document.frmstatus1.agente,document.frmstatus2.agente2)">&nbsp;
      </td>	
      <td class="cnt">
        {if $vopc eq 3}
           <input type='image' src="../imagenes/boton_nuevo_azul.png" value="Nuevo">
        {/if}
        {if $vopc eq 4}
	        <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">  
        {/if}
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="frmagente2" action="z_agentes.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='agente' value={$agente}>
  <input type ='hidden' name='agente2' value={$agente2}>
  <input type ='hidden' name='vstring' value='{$vstring}'>
  <input type ='hidden' name='campos' value='{$campos}'>

  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name='nombre' value='{$nombre}' {$modo} size="90" maxlength="90" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,90,document.frmagente2.domicilio)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <!--<select size='1' name='lced' value='{$lced}' {$modo1}>";
         <option value='V'>V</option>
         <option value='E'>E</option>
         <option value='P'>P</option>
        </select>-->
        <select size="1" name="lced" {$modo1} >
          {html_options values=$doc_inf selected=$lced output=$doc_def}
        </select>
        <input type="text" name="cedula" value='{$cedula}' {$modo} size="14" maxlength="14" onkeyup="checkLength(event,this,14,document.frmagente2.nombre);fn(this.form,this);">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name='domicilio' value='{$domicilio}' {$modo} size="90" maxlength="120" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,90,document.frmagente2.profesion)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        <select size="1" name="profesion" {$modo1} >
          {html_options values=$apli_inf selected=$profesion output=$apli_def}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
        <input type="text" name='codcolegio' value='{$codcolegio}' {$modo} size="6" maxlength="6">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color">
        <input type="text" name='inpre' value='{$inpre}' {$modo} size="6" maxlength="6">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input type="text" name='celular' value='{$celular}' {$modo} size="13" maxlength="12" onkeyup="number_tel(this);fn(this.form,this);">
        <small>Formato: 0000-0000000 (c&oacute;digo-n&uacute;mero)</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <input type="text" name='telefonoh' value='{$telefonoh}' {$modo} size="13" maxlength="12" onkeyup="number_tel(this);fn(this.form,this);">
        <small>Formato: 0000-0000000 (c&oacute;digo area-n&uacute;mero)</small>   
        <font face="Arial" color="#800000" size="2">*</font>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color">
        <input type='text' name='email' value='{$email}' {$modo} size="69" maxlength="90" onkeyup="number_mail(this);fn(this.form,this);" onchange="isEmail2(document.forusing.email.value,this.form);" >
	<br><font face='Time New Roman Bold' size="1">Por ejemplo: nombre@ejemplo.com</font></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
        <input type='text' name='email2' value='{$email2}' {$modo} size="69" maxlength="90" onkeyup="number_mail(this);fn(this.form,this);" onchange="isEmail2(document.forusing.email2.value,this.form);">
	<br><font face='Time New Roman Bold' size="1">Por ejemplo: nombre@ejemplo.com</font></br>
      </td>
    </tr>
      
  </tr>
  </table></center>
  &nbsp;
  
  <table width="210">
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/boton_grabar_azul.png" value="Guardar"></td> 
    <td class="cnt">
      {if $vopc eq 3 || $vopc eq 5}
         <a href="z_agentes.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
      {if $vopc eq 1 || $vopc eq 4}
         <a href="z_agentes.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
      
    </td>      
    <td class="cnt">
        <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>
  
  
  <!-- <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      {if $vopc eq 3 || $vopc eq 5}
        <a href="z_agentes.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 1 || $vopc eq 4}
        <a href="z_agentes.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table> -->

</form>
</div>  
</body>
</html>
