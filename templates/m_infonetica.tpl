<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>
<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">
<br>

{if $vopc eq 1 || $vopc eq 3}
  <form name="formarcas2" enctype="multipart/form-data" action="m_infonetica.php?vopc=2" method="POST" onsubmit='return pregunta();'>
{/if}    
{if $vopc eq 4}
  <form name="formarcas1" action="m_infonetica.php?vopc=1" method="post">
  <table>
    <tr>
      <td class="izq5-color">{$campo4}</td>
      <td class="der-color">
         <input tabindex="5" type="text" name="recibo" value='{$recibo}' size="6" maxlength="6">
      </td>
      {if $vopc eq 4}
        <td class="cnt">
          &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  
        </td>
      {/if}    
    </tr>
  </table>
{/if} 		  

  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='accion' value={$accion}> 
  <table border="1" cellspacing="1">
  <tr>
    {if $vopc neq 4}
      <tr>
        <td class="izq-color" >{$campo4}</td>
        <td class="der-color">
          <input tabindex="5" type="text" name="recibo" {$modo} value='{$recibo}' size="6" maxlength="6" onkeyup="checkLength(event,this,6,document.formarcas2.fecharec)">
        </td>
      </tr>
    {/if}
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input tabindex="3" type="text" name="fecharec" {$modo1} value='{$fecharec}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.prioridad)" onchange="valFecha(this,document.formarcas2.prioridad)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar53');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select tabindex="4" size="1" name="prioridad" {$modo2}>
          {html_options values=$arraytipom selected=$prioridad output=$arraynotip}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        <select tabindex="4" size="1" name="busqueda" {$modo2}>
          {html_options values=$arraybusqt selected=$busqueda output=$arraynobus}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
          <input type="text" name="cantidad" {$modo1} value='{$cantidad}' size="2" maxlength="3" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
         <input tabindex="7" type="text" name="solicitant" {$modo1} value='{$solicitant}' size="60" maxlength="80" onkeyup="this.value=this.value.toUpperCase()">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color">
           <select size="1" name="indole" {$modo2}>
              {html_options values=$vindole_id selected=$indole output=$vindole_de}
           </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color">{$campo10}</td>
      <td class="der-color">
        <select size="1" name="lced" {$modo2}>
           {html_options values=$lced_id selected=$lced output=$lced_de}
        </select>
        <input tabindex="9" type="text" name='nced' size="9" maxlength="9" value='{$nced}' {$modo1} 
onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.formarcas2.nced,9)" onkeyup="checkLength(event,this,9,document.formarcas2.telefono)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo11}</td>
      <td class="der-color" colspan="2"><small>V = Venezolano,&nbsp;&nbsp;&nbsp;E = Extranjero,&nbsp;&nbsp;&nbsp;P = Pasaporte,&nbsp;&nbsp;&nbsp;J = Juridico,&nbsp;&nbsp;&nbsp;G = Gobierno</small></td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo12}</td>
      <td class="der-color">
        <input tabindex="10" type="text" name='telefono' value='{$telefono}' {$modo1} size="15" maxlength="15" onKeyPress="return acceptChar(event,9, this)" onkeyup="checkLength(event,this,15,document.formarcas2.Guardar)">
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>
    </table>
  &nbsp;
  &nbsp;

  <table width="380" >
  <tr>
    <td class="cnt"><input tabindex="10" name="Guardar" type="image" src="../imagenes/database_save.png" value="Guardar">Guardar</td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
         <a href="m_infonetica.php?vopc=4"><img tabindex="11" src="../imagenes/restore_f2.png" border="0"></a>Cancelar
      {/if}    
      {if $vopc eq 1}
         <a href="m_infonetica.php?vopc=5&recibo={$recibo}"><img tabindex="11" src="../imagenes/cancel_f2.png" border="0"></a>Eliminar
      {/if}    
      {if $vopc eq 3}
         <a href="m_infonetica.php?vopc=3"><img tabindex="12" src="../imagenes/restore_f2.png" border="0"></a>Cancelar
      {/if}    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="13" src="../imagenes/salir_f2.png" border="0"></a>Salir</td>
  </tr>
  </table>

<br><br><br><br><br><br><br><br><br><br><br>
</form>
</div>  

</body>
</html>
