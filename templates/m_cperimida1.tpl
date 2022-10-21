<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="document.forevento.input2.focus()">

  <div align="center">
  
  <table cellspacing="1" border="1">
  <form name="forevento" action="m_gperimida.php" method="POST">
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='fecha_venc' value='{$fecha_venc|date_format:"%d/%m/%G"}'>
  <input type='hidden' name='modalidad' value={$modalidad}>
  <input type='hidden' name='tipo_marca' value={$tipo_marca}>
  <input type='hidden' name='nameimage' value={$nameimage}>
  <input type='hidden' name='vder' value='{$vder}'> 

  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name='anno' value='{$anno}' readonly='readonly' align="right" size="3" maxlength="4">-
        <input type="text" name='numero' value='{$numero}' readonly='readonly' align="right" size="6" maxlength="6">
	     {if $modalidad eq "G" || $modalidad eq "M"}
          <td rowspan="8" align="center" valign="top">
            <a href='{$nameimage}' target="_blank">
            <img border="-1" src={$nameimage} width="186" height="210">
          </td>
        {/if}
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo15}</td>
      <td class="der-color">
        <input type='text' name='nroderecho' value='{$nroderecho}' readonly='readonly' size='10'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type='text' name='fecha_solic' value='{$fecha_solic}' readonly='readonly' size='9'>
        &nbsp;&nbsp;{$campo14}&nbsp;&nbsp;
        <input type='text' name='clase' value='{$clase}' readonly='readonly' size='1'>&nbsp;&nbsp;
        <input type='text' name='ind_claseni' value='{$ind_claseni}' readonly='readonly' size='1'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type='text' name='vtipo_marca' value='{$vtipo_marca}' readonly='readonly' size='30'>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$campo9}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type='text' name='fecha_publi' value='{$fecha_publi}' readonly='readonly' size='9'>         
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type='text' name='nombre' value='{$nombre}' readonly='readonly' size='67'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        <input type='text' name='estatus' value='{$estatus}' readonly='readonly' size='3'>
        <input type='text' name='descripcion' value='{$descripcion}' readonly='readonly' size='61'>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
         <input type='text' name='registro' value='{$registro}' readonly='readonly' size='8'>
         &nbsp;&nbsp;&nbsp;{$campo7}&nbsp;&nbsp;
         <input type='text' name='fecha_regis' value='{$fecha_regis}' readonly='readonly' size='9'>
         &nbsp;&nbsp;&nbsp;{$campo8}&nbsp;&nbsp;
         <input type='text' name='fecha_venci' value='{$fecha_venci}' readonly='readonly' size='9'>         
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
         <input type='text' name='tmodalidad' value='{$tmodalidad}' readonly='readonly' size='11'>
         &nbsp;&nbsp;{$campo11}&nbsp;&nbsp;
         <input type='text' name='poder' value='{$poder}' readonly='readonly' size='9'>
         &nbsp;&nbsp;{$campo12}&nbsp;&nbsp;
         <input type='text' name='agente' value='{$agente}' readonly='readonly' size='9'>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo13}</td>
      <td class="der-color"><input type='text' name='tramitante' value='{$tramitante}' readonly='readonly' size='70'></td>
    </tr> 
    
  </table>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <div align="center">
  <table width="900" cellspacing="1" border="1">
    <tr>
      <td class="izq4-color" >C&oacute;digo &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nombre del Titular &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Domicilio &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pa&iacute;s 
      </td>
    </tr> 
    <tr>
      <td class="der-color" >
        {html_radios name="titular" values=$arraytitular selected=$titular output=$arraynombre separator="<br />"}
      </td>
    </tr>
  </table>

  &nbsp;
  <table width="200">
  <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_continuar_rojo.png"></td> 
    <td class="cnt"><a href="m_actelev.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

  </div>  
  
</body>
</html>
