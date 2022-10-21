<html>
<head>
   <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
  
<div align="center">
<form name="forlotes" action="m_evelote2.php?vopc=2" method="post">
   <input type="hidden" name="role" value='{$role}'>
   <input type="hidden" name="usuario" value='{$usuario}'>
   <input type="hidden" name="vsola" value='{$vsola}'>
   <input type="hidden" name="vsolb" value='{$vsolb}'>
   <input type="hidden" name="inf_adicional" value='{$inf_adicional}'>
   <input type="hidden" name="plazo_ley" value='{$plazo_ley}'>
   <input type="hidden" name="tipo_plazo" value='{$tipo_plazo}'>
   <input type="hidden" name="tipo_evento" value='{$tipo_evento}'>
   <input type="hidden" name="tit_comenta" value='{$tit_comenta}'>
   <input type="hidden" name="tit_nro_doc" value='{$tit_nro_doc}'>
   <input type="hidden" name="mensa_automatico" value='{$mensa_automatico}'>

   <table cellspacing="1" border="1">
   <tr>
     <tr>
      <td class="izq-color">{$campo1}</td>
	   <td class="der-color">
	      <input type="text" name="vsol1" size="3" maxlength="4" value='{$vsol1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol2)" 
		    onchange="Rellena(document.forlotes.vsol1,4);document.forlotes.vsoli1.value=this.value;">-
		   <input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" 
		    onchange="Rellena(document.forlotes.vsol2,6);document.forlotes.vsoli2.value=this.value;">
		hasta:
         <input type="text" name="vsol3" size="3" maxlength="4" value='{$vsol3}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol4)" 
          onchange="Rellena(document.forlotes.vsol3,4);document.forlotes.vsoli3.value=this.value;">-
		   <input type="text" name="vsol4" size="6" maxlength="6" value='{$vsol4}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vbol)" 
		    onchange="Rellena(document.forlotes.vsol4,6);document.forlotes.vsoli4.value=this.value;">
		<td>
	  </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
        <input type='text' name='evento_id' value='{$evento_id}' align="right" readonly='readonly' size='3'>
        <input type='text' name='evenombre' value='{$evenombre}' readonly='readonly' size='75'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color" >
        <input type='text' name='est_id1' value='{$est_id1}' align="right" readonly='readonly' size='3'>
        <input type='text' name='nomest1' value='{$nomest1}' readonly='readonly' size='75'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color" >
        <input type='text' name='est_id2' value='{$est_id2}' align="right" readonly='readonly' size='3'>
        <input type='text' name='nomest2' value='{$nomest2}' readonly='readonly' size='75'>
      </td>
    </tr>
	 <tr>
	   <td class="izq-color">{$campo5}</td>
	    <td class="der-color">
	     <input type="text" name="vuser" size="10" maxlength="10" value='{$vuser}' '{$modo2}'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo6}</td>
      <td class="der-color">
        <input type='text' name='fechat1' size="10" maxlength="10" value='{$fechat1|date_format:"%d/%m/%G"}' '{$modo2}' onChange="valFecha(document.forlotes.fechat1)">
        hasta:
        <input type='text' name='fechat2' size="10" maxlength="10" value='{$fechat2|date_format:"%d/%m/%G"}' '{$modo2}' onChange="valFecha(document.forlotes.fechat2)">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo7}</td>
      <td class="der-color">
        <input type='text' name='fechaeven' size="10" maxlength="10" value='{$fechaeven|date_format:"%d/%m/%G"}' '{$modo2}' onChange="valFecha(document.forlotes.fechaeven)">
      </td>
    </tr>
	 <tr>
	   <td class="izq-color">{$campo8}</td>
	    <td class="der-color">
	     <input type="text" name="vdoc" size="10" maxlength="10" value='{$vdoc}' '{$modo2}'>
      </td>
    </tr>
   </tr>
   </table>
   &nbsp;
   Datos Adicionales para Actualizar o Cargar:
   <table cellspacing="1" border="1">	
   <tr>
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color" >
        <input type='text' name='evento2_id' value='{$evento2_id}' align="right" readonly='readonly' size='3'>
        <input type='text' name='eve_nombre' value='{$eve_nombre}' readonly='readonly' size='75'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo10}</td>
      <td class="der-color">
        {if $evento2_id eq 0 }
          <input type='text' name='nfechaev' size="10" maxlength="10" value='{$nfechaev|date_format:"%d/%m/%G"}' readonly='readonly'>
        {else}  
          <input type='text' name='nfechaev' size="10" maxlength="10" value='{$nfechaev|date_format:"%d/%m/%G"}' '{$modo2}' onChange="valFecha(document.forlotes.nfechaev)">
        {/if}
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo11}</td>
      <td class="der-color">
        <input type='text' name='fechapub' size="10" maxlength="10" value='{$fechapub}' readonly='readonly'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo12}</td>
      <td class="der-color">
        <input type='text' name='fechaven' size="10" maxlength="10" value='{$fechaven}' readonly='readonly'>
      </td>
    </tr>
    {if $inf_adicional eq "C" }
    <input type ='hidden' name='documento' value='{$documento}'>
    <tr>
      <td class="izq-color" >{$campo13}</td>
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
    {if $inf_adicional eq "D" }
    <input type ='hidden' name='comentario' value='{$comentario}'>
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color">
        <input type='text' name='documento' value='{$documento}' size='10' maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    {/if}
    {if $inf_adicional eq "A" }
    <tr>
      <td class="izq-color" >{$campo13}</td>
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
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color">
        <input type='text' name='documento' value='{$documento}' size="10" maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    {/if}
    {if $inf_adicional eq "N" }
      <input type ="hidden" name="comentario" value='{$comentario}'>
      <input type ="hidden" name="documento" value='{$documento}'>
    {/if}
   </tr>
   </table>
   &nbsp;
   <table width="225">
   <tr>
     <tr>
       <td class="cnt"><input type="image" src="../imagenes/boton_modificar_azul.png">Actualizar</td> 
       <td class="cnt"><a href="m_evelote.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_buscar_rojo.png" border="0"></a></td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>
