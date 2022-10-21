<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">
<form name="frmstatus1" action="a_tabldper.php?vopc=1" method="POST">
  <table>
  <tr>
    <tr>
      <td class="izq5-color">{$campo01}</td>
      <td class="der-color">
      <!--  <select size='1' name='evento0'>";
         <option value='V'>V</option>
         <option value='E'>E</option>
         <option value='P'>P</option>
        </select> -->
        <input type="text" name='titular' size="8" maxlength="9" value='{$titular}' {$vmodo}> 
<!--               onKeyPress="return acceptChar(event,3, this)"> -->
      </td>	
      <td class="cnt">
      {if $vopc eq 4}
          <input type ='hidden' name='accion' value='Modificacion'>
          <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">
      {/if}
      {if $vopc eq 3}
          <input type ='hidden' name='accion' value='Ingreso'> 
          <input type='image' src="../imagenes/boton_nuevo_azul.png" value="Nuevo">
      {/if} 
      </td>
    </tr>
  </tr>
  </table>
</form>				  


<form name="frmstatus2" action="a_tabldper.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='titular' value={$titular}>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <select size='1' name='lced'>";
         <option value='V'>V</option>
         <option value='E'>E</option>
         <option value='P'>P</option>
        </select> 
        <input type="text" name='nced' size="9" maxlength="9" value='{$nced}' {$modo} 
               onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.frmstatus2.nced,9)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name='nombre' value='{$nombre}' {$modo} size="60" maxlength="60"  
               onchange="checkLength(event,this,60,document.frmstatus2.fechanac); this.value=this.value.toUpperCase();">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color" >
        <input type="text" name='fechanac' value='{$fechanac}' {$modo} size="10" maxlength="10"  
               onkeyup="checkLength(event,this,10,document.frmstatus2.fechadef)"
               onchange="valFecha(this,document.frmstatus2.fechadef)">
        <small>Formato: dd/mm/aaaa</small>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name='fechadef' value='{$fechadef}' {$modo} size="10" maxlength="10"  
               onkeyup="checkLength(event,this,10,document.frmstatus2.estado)"
               onchange="valFecha(this,document.frmstatus2.estado)">
        <small>Formato: dd/mm/aaaa</small> 
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
           <select size="1" name="estado" {$modo1}>
              {html_options values=$vestado_id selected=$estado output=$vestado_de}
           </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo13}</td>
      <td class="der-color">
           <select size="1" name="indole" {$modo1}>
              {html_options values=$vindole_id selected=$indole output=$vindole_de}
           </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color" >{$campo81}</td>
      <td class="der-color">
        <input type="text" name='telefono1' value='{$telefono1}' {$modo} size="15" maxlength="15"  
               onKeyPress="return acceptChar(event,9, this)" 
               onchange="checkLength(event,this,15,document.frmstatus2.fax)">
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo82}</td>
      <td class="der-color">
        <input type="text" name='telefono2' value='{$telefono2}' {$modo} size="15" maxlength="15"  
               onKeyPress="return acceptChar(event,9, this)" 
               onchange="checkLength(event,this,15,document.frmstatus2.fax)">
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>  
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
        <input type="text" name='fax' value='{$fax}' {$modo} size="15" maxlength="15"  
               onKeyPress="return acceptChar(event,9, this)" 
               onchange="checkLength(event,this,15,document.frmstatus2.email)">
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color">
        <input type="text" name='email' value='{$email}' {$modo} size="60" maxlength="120"  
               onchange="checkLength(event,this,120,document.frmstatus2.profesion)">
        <small></small>   
      </td>
    </tr>  
    <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
        <input type="text" name='profesion' value='{$profesion}' {$modo} 
               size="40" maxlength="40"  
               onkeyup="this.value=this.value.toUpperCase()" 
               onchange="checkLength(event,this,90,document.frmstatus2.seudonimo)">
        <!-- onKeyPress="return acceptChar(event,13, this)" -->               
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color">
        <input type="text" name='seudonimo' value='{$seudonimo}' {$modo} 
               size="40" maxlength="80"  
               onkeyup="this.value=this.value.toUpperCase()">
        <!-- onKeyPress="return acceptChar(event,13, this)" -->               
      </td>
    </tr>  
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/boton_guardar_azul.png" value="Guardar"></td> 
    <td class="cnt">
      {if ($vopc eq 1 && $accion eq 2) || $vopc eq 4}
        <a href="a_tabldper.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      {/if}    
      {if ($vopc eq 1 && $accion eq 1) || $vopc eq 3}
        <a href="a_tabldper.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      {/if}    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>

</form>
</div>  
</body>
</html>
