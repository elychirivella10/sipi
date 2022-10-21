<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>
<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
{if $vopc eq 4}
  <form name="formarcas1" action="m_actenvfon.php?vopc=1" method="post">
{/if} 		  
  <input type ='hidden' name='login' value={$login}>
  <input type ='hidden' name='auxnum' value={$auxnum}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='vfiltro' value={$vfiltro}>
    
  <table>
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input tabindex="1" type="text" name="recibo" size="7" maxlength="8" value='{$recibo}' {$vmodo} onkeyup="checkLength(event,this,8,document.formarcas1.vsol1)" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>
    <tr>
      <td class="izq5-color">{$campo2}</td>
      <td class="der-color">
         <input tabindex="2" type="text" name="vsol1" size="6" maxlength="6" value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)">
      </td>
      <td class="cnt">
         &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/boton_buscar_rojo.png" value="Buscar">  
      </td>
    </tr>
  </table>
</form>				  

{if $vopc eq 1}
<form name="formarcas2" enctype="multipart/form-data" action="m_actenvfon.php?vopc=2" method="POST" onsubmit='return pregunta();'>
{/if}    
  <input type ='hidden' name='login' value={$login}>
  <input type ='hidden' name='vsol1' value={$vsol1}>
  <input type ='hidden' name='modo' value={$vmodo}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='auxnum' value={$auxnum}>
  <input type ='hidden' name='vfiltro' value={$vfiltro}>
  <input type ='hidden' name='recibo' value={$recibo}>

  <table border="1" cellspacing="1">
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size='1' name='vplus' onchange="valenvio(this.form);" {$modo4}>
          {html_options values=$arrayplus selected=$vplus output=$arraydesplus}
        </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type='text' name='email' value='{$email}' {$modo1} size="70" maxlength="80" onkeyup="checkLength(event,this,80,document.formarcas2.passwd)" onchange="isEmail2(document.formarcas2.email.value,this.form);">
	     <br><font size="1">Cuenta correo para el env&iacute;o de la B&uacute;squeda, por ejemplo: correo@ejemplo.com</font></br>
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
         <a href="m_actenvfon.php?vopc=4"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
    </td>      
    <td class="cnt"><a href="m_panelfon.php"><img tabindex="13" src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>
