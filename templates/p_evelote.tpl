<html>
<head>
   <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
  
<div align="center">
<form name="forlotes" action="p_evelote1.php" method="post">
   <input type="hidden" name="vsola" value='{$vsola}'>
   <input type="hidden" name="vsolb" value='{$vsolb}'>
   <input type="hidden" name="role" value='{$role}'>
   <input type="hidden" name="usuario" value='{$usuario}'>
  
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
        <input type="text" name="input2" value='{$evento_id}' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.forlotes.evento_id)" onchange="valagente(document.forlotes.input2,document.forlotes.evento_id)">-
        <select size="1" name="evento_id" onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$arrayevento selected=$evento_id output=$arraydescri}
        </select>
        <!-- <select size='1' name='evento_id'>
          {html_options values=$arrayevento selected=$evento_id output=$arraydescri}
        </select> -->
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color" >
        <input type="text" name="input1" value='{$est_id1}' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.forlotes.est_id1)" onchange="valagente(document.forlotes.input1,document.forlotes.est_id1)">-
        <select size='1' name='est_id1' '{$modo2}' onchange="this.form.input1.value=this.options[this.selectedIndex].value">      
          {html_options values=$arrayest1 selected=$est_id1 output=$arraynom1}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color" >
        <input type="text" name="input3" value='{$est_id2}' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.forlotes.est_id2)" onchange="valagente(document.forlotes.input3,document.forlotes.est_id2)" >-
        <select size='1' name='est_id2' '{$modo2}' onchange="this.form.input3.value=this.options[this.selectedIndex].value">
          {html_options values=$arrayest2 selected=$est_id2 output=$arraynom2}
        </select>
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
        <!-- <select size='1' name='evento2_id'>
          {html_options values=$arrayevento selected=$evento2_id output=$arraydescri}
        </select> -->
        <input type="text" name="input4" value='{$evento2_id}' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.forlotes.evento2_id)" onchange="valagente(document.forlotes.input4,document.forlotes.evento2_id)">-
        <select size="1" name="evento2_id" onchange="this.form.input4.value=this.options[this.selectedIndex].value">
          {html_options values=$arrayevento selected=$evento2_id output=$arraydescri}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo10}</td>
      <td class="der-color">
        <input type='text' name='fechapub' size="10" maxlength="10" value='{$fechapub|date_format:"%d/%m/%G"}' '{$modo2}' onChange="valFecha(document.forlotes.fechapub)">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo11}</td>
      <td class="der-color">
        <input type='text' name='fechaven' size="10" maxlength="10" value='{$fechaven|date_format:"%d/%m/%G"}' '{$modo2}' onChange="valFecha(document.forlotes.fechaven)">
      </td>
    </tr>
   <tr>
   </table>
   &nbsp;
   <table width="225">
   <tr>
     <tr>
       <td class="cnt"><input type="image" src="../imagenes/boton_continuar_azul.png"></td> 
       <td class="cnt"><a href="p_evelote.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>
