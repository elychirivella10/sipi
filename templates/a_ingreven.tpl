<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

  <div align="center">

  <table cellspacing="1" border="1">
  <form name="forevento" action="a_dateven1.php?salir=1&conx=0" method="POST">
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='role' value={$role}>
  <input type='hidden' name='fecha_venc' value='{$fecha_venc|date_format:"%d/%m/%G"}'>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <input type='hidden' name='vder' value='{$vder}'>

  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name='vsol' value='{$vsol}' readonly='readonly' align="right" size="6" maxlength="6">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color"><input type='text' name='fecha_solic' value='{$fecha_solic}' readonly='readonly' size='9'></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color"><input type='text' name='tipo_obra' value='{$tipo_obra}' readonly='readonly' size='40'></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type='text' name='nombre' value='{$nombre}' readonly='readonly' size='66'>
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
        <input type="text" name="input2" value='{$eventos_id}' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.forevento.eventos_id)" onchange="valagente(document.forevento.input2,document.forevento.eventos_id)">-
        <select size="1" name="eventos_id" onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$arrayevento selected=$eventos_id output=$arraydescri}
        </select>
      </td>
    </tr>

  </tr>
  </table>
  &nbsp;
  <table width="200">
  <tr>
    <td class="cnt"><a href="a_rptcronol.php?vsol={$vsol}"><input type="image" src="../imagenes/boton_cronologia_rojo.png"></a></td>
    <td class="cnt"><input type="image" src="../imagenes/boton_continuar_rojo.png"></td>
    <td class="cnt"><a href="a_eveind.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

  </form>
  </div>
</body>
</html>
