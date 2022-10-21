<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <script language="javascript" src="../librerias/library.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

  <div align="center">
  <br>
  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" nowrap="nowrap">{$campo1}</td>
      <td class="der-color">
        <input type="text" name='anno1' value='{$anno}' align="right" readonly='readonly' size="3" maxlength="4">-
        <input type="text" name='numero1' value='{$numero}' align="right" readonly='readonly' size="6" maxlength="6">
      </td>
      {if $modalidad eq "G" || $modalidad eq "M"}
          <td rowspan="5" align="center" valign="top">
            <a href='{$nameimage}' target="_blank">
            <img border="-1" src={$nameimage} width="180" height="205">
          </td>
      {/if}

    </tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color"><input type='text' name='fecha_solic1' value='{$fecha_solic}' readonly='readonly' size='10'></td>
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color"><input type='text' name='tipo_marca1' value='{$tipo_marca}' readonly='readonly' size='30'></td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color">
        <input type='text' name='nombre1' value='{$nombre}' readonly='readonly' size='83'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color">
        <input type='text' name='estatus1' value='{$estatus}' align="right" readonly='readonly' size='3'>
        <input type='text' name='descripcion1' value='{$descripcion}' readonly='readonly' size='77'>
      </td>
    </tr> 
  </tr>

  </table></center>
  <p class= "cnt" >DATOS DEL DOCUMENTO Y EVENTO </p>

  <table border="1" cellspacing="1">
  <tr>
    {if $escrito_asoc=='S'}
    <tr>
      <td class="izq-color">Documento:</td>
      <td class="der-color">
      <form name="forfile" enctype="multipart/form-data" action="z_enviodoc_ti.php?vopc=2&vsol={$anno}-{$numero}"  method="POST">

        <input type ='hidden' name='usuario' value={$usuario}>
        <input type ='hidden' name='role' value={$role}>
        <input type ='hidden' name='fecha_venc' value='{$fecha_venc|date_format:"%d/%m/%G"}'>
        <input type ='hidden' name='modalidad' value={$modalidad}>
        <input type ='hidden' name='nameimage' value={$nameimage}>
        <input type ='hidden' name='nconex' value='{$n_conex}'>
        <input type ='hidden' name='vder' value='{$vder}'>
        <input type ='hidden' name='anno' value='{$anno}'>
        <input type ='hidden' name='numero' value='{$numero}'>
        <input type ='hidden' name='fecha_solic' value='{$fecha_solic}'>
        <input type ='hidden' name='tipo_marca' value='{$tipo_marca}'>
        <input type ='hidden' name='nombre' value='{$nombre}'>
        <input type ='hidden' name='estatus' value='{$estatus}'>
        <input type ='hidden' name='descripcion' value='{$descripcion}'>
        <input type ='hidden' name='registro' value='{$registro}'>
        <input type ='hidden' name='eventos_id' value='{$evento}'>
        <input type ='hidden' name='input2' value='{$input2}'>
        <input type ='hidden' name='cant_pag' value='{$cant_pag}'>
        <input type ='hidden' name='fecha_evento' value='{$fecha_evento}'>
        <input type ='hidden' name='comentario' value='{$comentario}'>
        <input type ='hidden' name='documento' value='{$documento}'>
        {if file($documento_dig) }
            <b>El Documento Digitalizado Ya fu&eacute; Cargado Correctamente.</b>
        {else}
            <input type ='hidden' name='vname_new' value={$usuario}_{$anno}{$numero}>
            <input name="ubicacion" type="file" value={$ubicacion} size="60" onchange="checkear(this);" >&nbsp;&nbsp; 
            <input name="enviar" type="submit" value="Cargar Archivo" class="botones">  
        {/if}
      </form>

      </td>
    </tr>
    {/if}
  <form name="fordatev" action="m_gbevind_ti.php" method="POST" onsubmit="return pregunta();">
    <input type ='hidden' name='usuario' value={$usuario}>
    <input type ='hidden' name='fecha_venc' value='{$fecha_venc}'>
    <input type ='hidden' name='tipo_evento' value='{$tipo_evento}'>
    <input type ='hidden' name='plazo_ley' value='{$plazo_ley}'>
    <input type ='hidden' name='tipo_plazo' value='{$tipo_plazo}'>
    <input type ='hidden' name='mensa_automatico' value='{$mensa_automatico}'>
    <input type ='hidden' name='aplica' value='{$aplica}'>
    <input type ='hidden' name='inf_adicional' value='{$inf_adicional}'>
    <input type ='hidden' name='escrito_asoc' value='{$escrito_asoc}'>
    <input type ='hidden' name='nconex' value='{$n_conex}'>  
    <input type ='hidden' name='vder' value='{$vder}'>
    <input type ='hidden' name='anno' value='{$anno}'>
    <input type ='hidden' name='numero' value='{$numero}'>
    <input type ='hidden' name='fecha_solic' value='{$fecha_solic}'>
    <input type ='hidden' name='tipo_marca' value='{$tipo_marca}'>
    <input type ='hidden' name='nombre' value='{$nombre}'>
    <input type ='hidden' name='estatus' value='{$estatus}'>
    <input type ='hidden' name='descripcion' value='{$descripcion}'>

    {if $escrito_asoc=='S'}
    <tr>
      <td class="izq-color">Cantidad de P&aacute;ginas:</td>
      <td class="der-color">
        <input type='text' name='cant_pag' value='{$cant_pag}' maxlength="3" size='3' onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>
    {/if}
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
        <input type='text' name='fecha_evento' value='{$fecha_evento}' size='10' onChange="valFecha(document.fordatev.fecha_evento)" onkeyup="checkLength(event,this,10,document.fordatev.documento)">
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar6');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
    </tr>
  </tr>
    {if $inf_adicional eq "D" }
     <input type ='hidden' name='comentario' value='{$comentario}'>
     <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color">
        <input type='text' name='documento' value='{$documento}' size='10' maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
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
        <input type='text' name='documento' value='{$documento}' size="10" maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
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
<!-- Realizado por: Nelson Gonzalez 10/02/2020 - Incorpora la Factura para evento 40 
    {if $evento==40}
     <tr>
      <td class="izq-color" >NUMERO DE FACTURA:</td>
      <td class="der-color">
        <input type='text' name='num_fac' value='{$num_fac}' size="10" maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
      </td>
     </tr>
    {/if}
<!-- Fin Factura evento 40-->
  </tr>
  </table></center>
  &nbsp;

  <table width="248">
  <tr>
    <!-- <td class="der">
    <td class="cnt"><a href="m_rptcronol.php?vsol1={$anno}&vsol2={$numero}" target="blank">
    <input type="image" src="../imagenes/folder_f2.png"></a>		Cronologia 		</td> -->
    <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt"><a href="m_eveind_ti.php?nconex={$n_conex}&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_cerrar_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </tr>
  </table></form></center>
  &nbsp;

  <br><br><br><br><br><br><br><br><br><br> 
</div>  
</body>
</html>
