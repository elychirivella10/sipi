<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

  <div align="center">

  <form name="fordatev" action="a_gbevind.php" method="POST" onsubmit='return pregunta();''>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='fecha_venc' value='{$fecha_venc}'>
  <input type='hidden' name='tipo_evento' value='{$tipo_evento}'>
  <input type='hidden' name='plazo_ley' value='{$plazo_ley}'>
  <input type='hidden' name='tipo_plazo' value='{$tipo_plazo}'>
  <input type='hidden' name='mensa_automatico' value='{$mensa_automatico}'>
  <input type='hidden' name='aplica' value='{$aplica}'>
  <input type='hidden' name='inf_adicional' value='{$inf_adicional}'>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <input type='hidden' name='vder' value='{$vder}'>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" nowrap="nowrap">{$campo1}</td>
      <td class="der-color">
        <input type="text" name='vsol' value='{$vsol}' align="right" readonly='readonly' size="6" maxlength="6">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color"><input type='text' name='fecha_solic' value='{$fecha_solic}' readonly='readonly' size='9'></td>
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color"><input type='text' name='tipo_obra' value='{$tipo_obra}' readonly='readonly' size='60'></td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color">
        <input type='text' name='nombre' value='{$nombre}' readonly='readonly' size='83'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color">
        <input type='text' name='estatus' value='{$estatus}' align="right" readonly='readonly' size='3'>
        <input type='text' name='descripcion' value='{$descripcion}' readonly='readonly' size='77'>
      </td>
    </tr>
  </tr>

  </table></center>
  <p class= "cnt" >Datos del Evento</p>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo6}</td>
      <td class="der-color">
        <input type='text' name='evento' value='{$evento}' align="right" readonly='readonly' size='3'>
        <input type='text' name='eve_nombre' value='{$eve_nombre}' readonly='readonly' size='58'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo7}</td>
      <td class="der-color">
        <input type='text' name='fecha_evento' value='{$fecha_evento|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.fordatev.fecha_evento)">
         <small><a href="javascript:showCal('Calendar6');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a></small>
      </td>
    </tr>
  </tr>
    {if $inf_adicional eq "D" }
     <input type ='hidden' name='comentario' value='{$comentario}'>
     <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color">
        <input type='text' name='documento' value='{$documento}' size='9' maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
      </td>
     </tr>
    {/if}
    {if $inf_adicional eq "C" }
     <input type ='hidden' name='documento' value='{$documento}'>
     <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
        <textarea onkeyUp="max(this,255)" onkeyPress="max(this,255)" onChange="Vacio(document.fordatev.comentario)" cols='72' rows='4' name='comentario' value='{$comentario}'>{$comentario}</textarea>
      </td>
     </tr>
     <tr>
      <td class="izq-color" >  &nbsp;</td>
      <td class="der-color">
        <font id='Digitado' color='red'>0</font> Caracteres escritos / Restan <font id='Restante' color='red'>255</font>
      </td>
     </tr>
    {/if}
    {if $inf_adicional eq "A" }
     <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color">
        <input type='text' name='documento' value='{$documento}' size="9" maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
      </td>
     </tr>
     <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
        <textarea onkeyUp="max(this,255)" onkeyPress="max(this,255)" onChange="Vacio(document.fordatev.comentario)" cols='72' rows='4' name='comentario' value='{$comentario}'>{$comentario}</textarea>
      </td>
     </tr>
     <tr>
      <td class="izq-color" >  &nbsp;</td>
      <td class="der-color">
        <font id='Digitado' color='red'>0</font> Caracteres escritos / Restan <font id='Restante' color='red'>255</font>
      </td>
     </tr>
    {/if}

  </tr>
  </table></center>

  &nbsp;
  <table width="315">
  <tr>
    <td class="der">
    <td class="cnt"><a href="a_rptcronol.php?vsol={$anno}-{$numero}"><input type="image" src="../imagenes/boton_cronologia_rojo.png"></a></td>
    <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td>
    <td class="cnt"><a href="a_eveind.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </tr>
  </table></center>

  </form>
  </div>
</body>
</html>
