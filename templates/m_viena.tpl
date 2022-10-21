<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="frmstatus1" action="m_viena.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name='ccv' size="6" maxlength="6" value='{$ccv}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.frmstatus2.nombre)" onchange="valagente(document.frmstatus1.ccv,document.frmstatus2.ccv2)">&nbsp;
      </td>	
      <td class="cnt">
        {if $vopc eq 4}
	        <input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  
        {/if}
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="frmstatus2" action="m_viena.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value='{$accion}'>
  <input type ='hidden' name='ccv' value='{$ccv}'>
  <input type ='hidden' name='ccv2' value='{$ccv2}'>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <textarea rows="3" name="nombre" cols="80" onkeyup="this.value=this.value.toUpperCase()">{$nombre}</textarea>
      </td>
    </tr>
      
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
        <a href="m_viena.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3}
        <a href="m_viena.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

</form>
</div>  
</body>
</html>
