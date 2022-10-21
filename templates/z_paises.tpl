<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="frmstatus1" action="z_paises.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name='codigo' size="2" maxlength="2" value='{$codigo}' {$vmodo} onKeyPress="return acceptChar(event,4, this)" onkeyup="checkLength(event,this,2,document.frmstatus2.nombre)" onBlur="this.value=this.value.toUpperCase()" onchange="valagente(document.frmstatus1.codigo,document.frmstatus2.codigo2)">&nbsp;
      </td>	
      <td class="cnt">
        {if $vopc eq 4}
	  <input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" value="Buscar">  Buscar  
        {/if}
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="frmstatus2" action="z_paises.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='codigo' value={$codigo}>
  <input type ='hidden' name='codigo2' value={$codigo2}>
  <input type ='hidden' name='vstring' value='{$vstring}'>
  <input type ='hidden' name='campos' value='{$campos}'>

  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name='nombre' value='{$nombre}' {$modo} size="60" maxlength="60" onKeyPress="return acceptChar(event,4, this)" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,60,document.frmstatus2.publica)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name='nacional' value='{$nacional}' {$modo} size="30" maxlength="30" onKeyPress="return acceptChar(event,4, this)" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,30,document.frmstatus2.nacional)">
      </td>
    </tr>
      
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
        <a href="z_paises.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3}
        <a href="z_paises.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
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
