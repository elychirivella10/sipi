<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>
<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">
{if $vopc eq 3}
  <form name="formarcas1" action="m_bfonetica_sede.php?vopc=5" method="post">
{/if} 		  
{if $vopc eq 4}
  <form name="formarcas1" action="m_bfonetica_sede.php?vopc=1" method="post">
{/if} 		  
{if $vopc eq 6}
  <form name="formarcas1" action="m_bfonetica_sede.php?vopc=7" method="post">
{/if} 		  

  <input type ='hidden' name='login' value={$login}>
  <input type ='hidden' name='auxnum' value={$auxnum}>
  <input type ='hidden' name='accion' value={$accion}>
  <table>
     <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
         <input tabindex="1" type="text" name="vsol1" size="6" maxlength="6" 
	        value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)"  onchange="valagente(document.formarcas1.vsol1,document.formarcas2.vsol2)">
      </td>
      {if $vopc eq 3}
      <td class="cnt">
        &nbsp;&nbsp;<input type="image" src="../imagenes/boton_buscar_rojo.png" value="Nueva Solicitud">
        </form>
      </td>
      {/if} 		  
      {if $vopc eq 4 || $vopc eq 6}
        <td class="cnt">
          &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/boton_buscar_rojo.png" value="Buscar">  
        </td>
      {/if}    
  </tr>
  </table>
</form>				  

{if $vopc eq 1 || $vopc eq 5}
<form name="formarcas2" enctype="multipart/form-data" action="m_bfonetica_sede.php?vopc=2" method="POST" onsubmit='return pregunta();'>
{/if}    
{if $vopc eq 8}
  <form name="formarcas2" enctype="multipart/form-data" action="m_bfonetica_sede.php?vopc=9" method="POST" onsubmit='return pregunta();'>
{/if}    
  <input type ='hidden' name='login' value={$login}>
  <input type ='hidden' name='vsol1' value={$vsol1}>
  <input type ='hidden' name='modo' value={$vmodo}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='auxnum' value={$auxnum}>
  <input type ='hidden' name='planilla1' value={$planilla1}>

  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color">
         <input tabindex="3" type="text" name="fecharec" {$modo} value='{$fecharec}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.prioridad)" onchange="valFecha(this,document.formarcas2.prioridad)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar53');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color">
         <input tabindex="5" type="text" name="recibo" {$modo} value='{$recibo}' size="7" maxlength="6" onkeyup="checkLength(event,this,6,document.formarcas2.planilla)">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color">
         <input tabindex="8" type="text" name="solicitant" {$modo} value='{$solicitant}' size="60" maxlength="80" onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,80,document.formarcas2.indole)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo6}</td>
      <td class="der-color">
           <select size="1" name="indole" {$modo2}>
              {html_options values=$vindole_id selected=$indole output=$vindole_de}
           </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color">{$campo7}</td>
      <td class="der-color">
        <select size="1" name="lced" {$modo2}>
           {html_options values=$lced_id selected=$lced output=$lced_de}
        </select>
        <input tabindex="9" type="text" name='nced' size="9" maxlength="9" value='{$nced}' {$modo} 
onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.formarcas2.nced,9)" onkeyup="checkLength(event,this,9,document.formarcas2.telefono)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo8}</td>
      <td class="der-color" colspan="2"><small>V = Venezolano,&nbsp;&nbsp;&nbsp;E = Extranjero,&nbsp;&nbsp;&nbsp;P = Pasaporte,&nbsp;&nbsp;&nbsp;J = Juridico,&nbsp;&nbsp;&nbsp;G = Gobierno</small></td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo9}</td>
      <td class="der-color">
        <input tabindex="10" type="text" name='telefono' value='{$telefono}' {$modo} size="15" maxlength="15" onKeyPress="return acceptChar(event,9, this)" onkeyup="checkLength(event,this,15,document.formarcas2.Guardar)">
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color">
        <select tabindex="4" size="1" name="prioridad" {$modo2} >
          {html_options values=$arraytipom selected=$prioridad output=$arraynotip}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo11}</td>
      <td class="der-color">
      	<input tabindex="7" type="text" name="denominacion" {$modo1} value='{$denominacion}' size="60" maxlength="120" onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,120,document.formarcas2.options)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo10}</td>
      <td class="der-color">
 			<!-- Inicio Combo de Clases> -->         
         <select size="1" name="options" {$modo4} >
          {html_options values=$vcodclase selected=$clase output=$vnomclase|truncate:70}
         </select>
         <!-- Fin Combo de Clases> -->     
      </td>
    </tr>          
    <tr>
      <td class="izq-color">{$campo14}</td>
      <td class="der-color">
         <input tabindex="6" type="text" name="planilla" {$modo1} value='{$planilla}' size="8" maxlength="8" onkeyup="checkLength(event,this,8,document.formarcas2.denominacion)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo18}</td>
      <td class="der-color">
        <select size='1' name='vplus' onchange="valenvio(this.form);" {$modo4}>
          {html_options values=$arrayplus selected=$vplus output=$arraydesplus}
        </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color" >{$campo17}</td>
      <td class="der-color">
        <input type='text' name='email' value='{$email}' {$modo1} size="70" maxlength="80" onkeyup="checkLength(event,this,80,document.formarcas2.passwd)" onchange="isEmail2(document.formarcas2.email.value,this.form);">
	     <br><font size="1">Cuenta correo para el env&iacute;o de la B&uacute;squeda, por ejemplo: correo@ejemplo.com</font></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color">
         <select size="1" name="vsede" {$modo2} >
          {html_options values=$vcodsede selected=$vsede output=$vnomsede}
         </select>
      </td>
    </tr>          
    <tr>
      <td class="izq-color">{$campo15}</td>
      <td class="der-color">
      	<input tabindex="7" type="text" name="usuario" {$modo} value='{$usuario}' size="12" maxlength="12">
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo16}</td>
      <td class="der-color">
      	<input tabindex="7" type="text" name="fh_carga" {$modo} value='{$fh_carga}' size="20" maxlength="20">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo13}</td>
      <td class="der-color">
         <input type="text" name="vfechr" {$modo3} value='{$fechapro}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.vfechr)" onchange="valFecha(this,document.formarcas2.vfechr)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar51');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
    </tr>          
    </table>
  &nbsp;
  &nbsp;

  <table width="255" >
  <tr>
    <td class="cnt"><input tabindex="11" name="Guardar" type="image" src="../imagenes/boton_guardar_azul.png" value="Guardar"></td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
         <a href="m_bfonetica_sede.php?vopc=4"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
      {if $vopc eq 3}
         <a><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      {/if}    
      {if $vopc eq 5}
         <a href="m_bfonetica_sede.php?vopc=3"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      {/if}    
      {if $vopc eq 6 || $vopc eq 8}
         <a href="m_bfonetica_sede.php?vopc=6"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      {/if}    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="13" src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>
