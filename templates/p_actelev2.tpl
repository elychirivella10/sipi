<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

  <div align="center">

  <form name="fordatev" action="p_actelev3.php?vopc=1" method="POST" onsubmit='return pregunta();''>
    <input type='hidden' name='vder' value='{$vder}'>
          
  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" nowrap="nowrap">{$campo1}</td>
      <td class="der-color">
        <input type="text" name='anno' value='{$anno}' align="right" readonly='readonly' size="3" maxlength="4">-
        <input type="text" name='numero' value='{$numero}' align="right" readonly='readonly' size="6" maxlength="6">
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
      <td class="der-color"><input type='text' name='fecha_solic' value='{$fecha_solic}' readonly='readonly' size='9'></td>
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color">
        <select size="1" name="tipo_paten">
          {html_options values=$arraytipom selected=$tipo_paten output=$arraynotip}
        </select>
        &nbsp;&nbsp;&nbsp;{$campo15}&nbsp;&nbsp;&nbsp;
        <input type='text' name='fecha_publi' value='{$fecha_publi}' size='10' maxlength="10" onChange="valFecha(document.fordatev.fecha_publi)" onkeyup="checkLength(event,this,10,document.fordatev.estatus)">         
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color">
        <input type='text' name='nombre' value='{$nombre}' readonly='readonly' size='83' maxlength="400" onkeyup="this.value=this.value.toUpperCase()">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color">
        <input type='text' name='estatus' value='{$estatus}' align="right" size='3' maxlength="3" onKeyPress="return acceptChar(event,2,this)" >
        <input type='text' name='descripcion' value='{$descripcion}' readonly='readonly' size='77'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo16}</td>
      <td class="der-color">
         <input type='text' name='registro' value='{$registro}' readonly='readonly' size='8'>
         &nbsp;&nbsp;&nbsp;{$campo17}&nbsp;&nbsp;&nbsp;
         <input type='text' name='fecha_regis' value='{$fecha_regis}' size='9'>
         &nbsp;&nbsp;&nbsp;{$campo18}&nbsp;&nbsp;&nbsp;
         <input type='text' name='fecha_venci' value='{$fecha_venci}' size='10' maxlength="10" onChange="valFecha(document.fordatev.fecha_venci)" onkeyup="checkLength(event,this,10,document.fordatev.evento)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo19}</td>
      <td class="der-color">
         <input type='text' name='poder' value='{$poder}' readonly='readonly' size='9'>
         &nbsp;&nbsp;{$campo20}&nbsp;&nbsp;
         <input type='text' name='agente' value='{$agente}' readonly='readonly' size='9'>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo21}</td>
      <td class="der-color">
        <input type='text' name='tramitante' value='{$tramitante}' size='70' maxlength="100" onkeyup="this.value=this.value.toUpperCase()" >
      </td>
    </tr> 
  </tr>
  </table>
  <p class= "cnt" >Datos del Evento</p>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo6}</td>
      <td class="der-color">
        <input type='text' name='evento' value='{$evento}' align="left" size='3' onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo7}</td>
      <td class="der-color">
        <input type='text' name='esta_ant' value='{$esta_ant}' align="left" size='3' onKeyPress="return acceptChar(event,2,this)" >
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo8}</td>
      <td class="der-color">
        <input type='text' name='fecha_event' value='{$fecha_event}' size="10" maxlength="10" onChange="valFecha(document.fordatev.fecha_evento)" onkeyup="checkLength(event,this,10,document.fordatev.fecha_trans)">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo9}</td>
      <td class="der-color">
        <input type='text' name='fecha_venc' value='{$fecha_venc}' size="10" maxlength="10" onChange="valFecha(document.fordatev.fecha_trans)" onkeyup="checkLength(event,this,10,document.fordatev.comentario)">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo10}</td>
      <td class="der-color">
        <input type='text' name='fecha_trans' value='{$fecha_trans}' size="10" maxlength="10" onChange="valFecha(document.fordatev.fecha_trans)" onkeyup="checkLength(event,this,10,document.fordatev.comentario)">
      </td>
    </tr>
  </tr>
     <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color">
        <input type='text' name='documento' value='{$documento}' size="10" maxlength="10" align="left" onKeyPress="return acceptChar(event,2,this)">
      </td>
     </tr>
     <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color">
        <textarea onkeyUp="max(this,600)" onkeyPress="max(this,600)" onChange="Vacio(document.fordatev.comentario)" cols='72' rows='4' name='comentario' value='{$comentario}'>{$comentario}</textarea>
      </td>
     </tr>
     <tr>
      <td class="izq-color" >  &nbsp;</td>
      <td class="der-color">
        <font id='Digitado' color='red'>0</font> Caracteres escritos / Restan <font id='Restante' color='red'>600</font>
      </td>
     </tr>
     <tr>
      <td class="izq-color" >{$campo13}</td>
      <td class="der-color">
        <input type='text' name='usuario' value='{$usuario}' size="10" maxlength="12" align="left" onKeyPress="return acceptChar(event,3,this)" >
      </td>
     </tr>
     <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color">
        <input type='text' name='secuencial' value='{$secuencial}' size="15" maxlength="15" readonly='readonly' align="left">
      </td>
     </tr>

  </tr>
  </table>

  <p class= "cnt" >DATOS DEL TITULAR O PROPIETARIO</p>
  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo24}</td>
      <td class="der-color">
        <input type='text' name='tnombre' value='{$tnombre}' size='74' maxlength="150" >
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo25}</td>
      <td class="der-color">
        <input type='text' name='tdomicilio' value='{$tdomicilio}' size='74' maxlength="100" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo26}</td>
      <td class="der-color">
        <input type="text" name="input2" {$modo} value='{$tpais_resid}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.fordatev.botonname)" onchange="valagente(document.fordatev.input2,document.fordatev.pais)">-
        <select size="1" name="pais" {$modo2} onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$tpais_resid output=$arraynompais}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo27}</td>
      <td class="der-color">
        <input type='text' name='titular' value='{$titular}' size="7" maxlength="7" readonly='readonly' align="left">
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table width="220">
  <tr>
    <td class="der">
    <td class="cnt"><input type="image" name='botonname' value="Guardar" src="../imagenes/boton_grabar_rojo.png"></td>
    {if $secuencial neq 0}    
       <td class="cnt"><input type="image" name='botonname' value="Eliminar" src="../imagenes/boton_eliminar_rojo.png"></td>
    {/if}
    <td class="cnt"><a href="p_actelev.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>

</div>  
</body>
</html>
