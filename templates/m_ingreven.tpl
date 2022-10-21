<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="document.forevento.input2.focus()">

  <div align="center">
  <br>
  <table border="1" cellspacing="1">
  <form name="forevento" action="m_dateven1.php" method="POST">
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='role' value={$role}>
  <input type ='hidden' name='fecha_venc' value='{$fecha_venc|date_format:"%d/%m/%G"}'>
  <input type ='hidden' name='modalidad' value={$modalidad}>
  <input type ='hidden' name='nameimage' value={$nameimage}>
  <input type ='hidden' name='nconex' value='{$n_conex}'>
  <input type ='hidden' name='vder' value='{$vder}'>
   
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name='anno' value='{$anno}' readonly='readonly' align="right" size="3" maxlength="4">-
        <input type="text" name='numero' value='{$numero}' readonly='readonly' align="right" size="6" maxlength="6">
	     {if $modalidad eq "G" || $modalidad eq "M"}
          <td rowspan="7" align="center" valign="top">
            <a href='{$nameimage}' target="_blank">
            <img border="-1" src={$nameimage} width="180" height="205">
          </td>
        {/if}
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color"><input type='text' name='fecha_solic' value='{$fecha_solic}' readonly='readonly' size='9'></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color"><input type='text' name='tipo_marca' value='{$tipo_marca}' readonly='readonly' size='30'></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type='text' name='nombre' value='{$nombre}' readonly='readonly' size='60'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color"><input type='text' name='estatus' value='{$estatus}' readonly='readonly' size='3'><input type='text' name='descripcion' value='{$descripcion}' readonly='readonly' size='60'></td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color"><input type='text' name='registro' value='{$registro}' readonly='readonly' size='8'></td>
    </tr> 
    <!-- <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color" >
        <select size='1' name='eventos_id'>
          {html_options values=$arrayevento selected=$eventos_id output=$arraydescri}
        </select>
      </td>
    </tr> -->
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <input type="text" name="input2" value='{$eventos_id}' size="3" maxlength="3" onKeyup="checkLength(event,this,4,document.forevento.eventos_id)" onchange="valagente(document.forevento.input2,document.forevento.eventos_id)">-
        <select size="1" name="eventos_id" onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$arrayevento selected=$eventos_id output=$arraydescri}
        </select>
      </td>
    </tr> 

   
   
  </tr>
  </table>
  &nbsp;
  <table width="255">
  <tr>
    <!-- <td class="cnt"><a href="m_rptcronol.php?vsol1={$anno}&vsol2={$numero}">
    <input type="image" src="../imagenes/folder_f2.png"></a>		Cronologia 		</td> --> 
    <td class="cnt"><input type="image" src="../imagenes/boton_continuar_rojo.png"></td> 
    <td class="cnt"><a href="m_eveind.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><img src="../imagenes/boton_salir_rojo.png" border="0" onclick='window.close()'></td>
    <td class="cnt"><a href="../consultamarcas/ver_marcas_fon.php?vnsol={$anno}-{$numero}" target="_blank">
    <img src="../imagenes/boton_cronologia_azul.png" border="0"></a></td> 
  </tr>
  </table>
  <br><br><br><br><br><br><br><br><br>
  </div>  
</body>
</html>
