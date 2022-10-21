<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="frmstatus1" action="z_tablmigr.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
      {if $vopc eq 3}
        {html_radios name="tipoder" values=$tipo_der selected=$tipoder output=$dere_def}
      {/if} 
      &nbsp;   
      </td>	

      <td class="cnt">
        {if $vopc eq 4}
                <input type ='hidden' name='accion' value='Modificacion'>
	        <input type='image' src="../imagenes/search_f2.png" width="28" height="24" 
                       value="Buscar">  Buscar  
        {/if}
        {if $vopc eq 3}
                <input type ='hidden' name='accion' value='Ingreso'> 
	        <input type='image' src="../imagenes/folder_add_f2.png" width="28" height="24" 
                       value="Nuevo">  Nuevo  
        {/if} 
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="frmstatus2" action="z_tablmigr.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='estatus' value={$estatus}>

  <table>
  <tr>

    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
        <input type="text" name="input4" value='{$evento2_id}' size="3" maxlength="3" {$modo} onKeyup="checkLength(event,this,3,document.frmstatus2.evento2_id)" onchange="valagente(document.frmstatus2.input4,document.frmstatus2.evento2_id)">-
        <select size="1" name="evento2_id" {$modo2} onchange="this.form.input4.value=this.options[this.selectedIndex].value">
          {html_options values=$arrayevento selected=$evento2_id output=$arraydescri}
        </select>
      </td>
    </tr>
  
  
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color" >
        <input type="text" name="input1" value='{$est_id1}' size="3" maxlength="3" {$modo} onKeyup="checkLength(event,this,3,document.forlotes.est_id1)" onchange="valagente(document.forlotes.input1,document.forlotes.est_id1)">-
        <select size='1' name='est_id1' '{$modo2}' onchange="this.form.input1.value=this.options[this.selectedIndex].value">      
          {html_options values=$arrayest1 selected=$est_id1 output=$arraynom1}
        </select>
        <!-- <select size='1' name='est_id1' '{$modo2}'>
          {html_options values=$arrayest1 selected=$est_id1 output=$arraynom1}
        </select> -->
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color" >
        <input type="text" name="input3" value='{$est_id2}' size="3" maxlength="3" {$modo} onKeyup="checkLength(event,this,3,document.forlotes.est_id2)" onchange="valagente(document.forlotes.input3,document.forlotes.est_id2)" >-
        <select size='1' name='est_id2' '{$modo2}' onchange="this.form.input3.value=this.options[this.selectedIndex].value">
          {html_options values=$arrayest2 selected=$est_id2 output=$arraynom2}
        </select>
        <!-- <select size='1' name='est_id2' '{$modo2}'>
          {html_options values=$arrayest2 selected=$est_id2 output=$arraynom2}
        </select> -->
      </td>
    </tr>

  
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name='estatus' size="3" maxlength="3" value='{$estatus}' {$vmodo} 
               onKeyPress="return acceptChar(event,2, this)">&nbsp;
      </td>	
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name='inicial' value='{$inicial}' {$modo} size="3" maxlength="3" 
               onKeyPress="return acceptChar(event,2, this)"
               onKeyup="checkLength(event,this,3,document.frmstatus2.final)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name='final' value='{$final}' {$modo} size="3" maxlength="3" 
               onKeyPress="return acceptChar(event,2, this)">
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
      {if ($vopc eq 1 && $accion eq 2) || $vopc eq 4}
        <a href="z_tablmigr.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if ($vopc eq 1 && $accion eq 1) || $vopc eq 3}
        <a href="z_tablmigr.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
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
