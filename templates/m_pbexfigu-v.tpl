<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_pbexfigu.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vsol' value={$vsol}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='nameimage' value={$nameimage}>

  <table>
     <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
         <input tabindex="1" type="text" name="vsol1" size="6" maxlength="6" value='{$vsol1}' {$modo1} onKeyPress="return acceptChar(event,2, this)">&nbsp;
      </td>
      <td class="cnt"><input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_pbexfig1.php?vopc=0" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vsol1' value={$vsol1}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='nameimage' value={$nameimage}>
  
  <table border="0" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecharec" {$modo} value='{$fecharec}' size="10" align="right">
      </td>
      <td class="izq2-color" >{$campo7}</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="prioridad" {$modo2} >
          {html_options values=$arraytipom selected=$prioridad output=$arraynotip}
        </select>
      </td>
      <td class="der-color" rowspan="8" valign="top">
        <input name="ubicacion" type="file" {$modo2} value='{$ubicacion}' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br> <a href='{$nameimage}' target='_blank'><img border='0' src='{$nameimage}' width='270' height='270'></a></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
         <input type="text" name="recibo" {$modo} value='{$recibo}' size="6" >
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
	<textarea rows="2" name="solicitant" {$modo} cols="57" maxlength="80">{$solicitant}</textarea>
      </td>
    </tr> 
    {if $accion eq 1}
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input tabindex="2" type="text" name="clase" {$modo3} value='{$clase}' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr> 
    {else}
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2"></td>
    </tr> 
    {/if}
    </table>
    &nbsp;

  <!-- <table border="0" width="87%" cellpadding="0" >
  <tr>
    <td class="izq-color"><font color='#FFFFFF' face='MS Sans Serif' size='2'>Clasificacion Viena:</font>&nbsp;&nbsp;
    1<input tabindex="3" type="text" name="C1" {$modo3} size="6" align="right" maxlength="6" onKeyPress="return acceptChar(event,2,this)">&nbsp;
    2<input tabindex="4" type="text" name="C2" {$modo3} size="6" align="right" maxlength="6" onKeyPress="return acceptChar(event,2,this)">&nbsp;
    3<input tabindex="5" type="text" name="C3" {$modo3} size="6" align="right" maxlength="6" onKeyPress="return acceptChar(event,2,this)">&nbsp;
    4<input tabindex="6" type="text" name="C4" {$modo3} size="6" align="right" maxlength="6" onKeyPress="return acceptChar(event,2,this)">&nbsp;
    5<input tabindex="7" type="text" name="C5" {$modo3} size="6" align="right" maxlength="6" onKeyPress="return acceptChar(event,2,this)">&nbsp;
    6<input tabindex="8" type="text" name="C6" {$modo3} size="6" align="right" maxlength="6" onKeyPress="return acceptChar(event,2,this)">&nbsp;
    7<input tabindex="9" type="text" name="C7" {$modo3} size="6" align="right" maxlength="6" onKeyPress="return acceptChar(event,2,this)">&nbsp;
    8<input tabindex="10" type="text" name="C8" {$modo3} size="6" align="right" maxlength="6" onKeyPress="return acceptChar(event,2,this)">&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
  </table> -->

  <!-- <table border="0" cellpadding="0" >
  <tr>
   <tr>
    <td class="izq-color">{$lcviena}1 
      <input size="5" type="text" name="C1" {$modo3} size="5" maxlength="6" onchange="valagente(document.formarcas2.C1,document.formarcas2.vagenom1)">
	   <select size=1 name='vagenom1' onchange="valagente(document.formarcas2.vagenom1,document.formarcas2.C1)">
	     {html_options values=$vcodage1 selected=$codage1 output=$vnomage1}
	   <select>
    </td>	   
   </tr>
   <tr>
    <td class="izq-color">{$lcviena}2 
      <input size="5" type="text" name="C2" {$modo3} size="5" maxlength="6" onchange="valagente(document.formarcas2.C2,document.formarcas2.vagenom2)">
	   <select size=1 name='vagenom2' onchange="valagente(document.formarcas2.vagenom2,document.formarcas2.C2)">
	     {html_options values=$vcodage2 selected=$codage2 output=$vnomage2}
	   <select>
    </td>	   
   </tr>
   <tr>
    <td class="izq-color">{$lcviena}3 
      <input size="5" type="text" name="C3" {$modo3} size="5" maxlength="6" onchange="valagente(document.formarcas2.C3,document.formarcas2.vagenom3)">
	   <select size=1 name='vagenom3' onchange="valagente(document.formarcas2.vagenom3,document.formarcas2.C3)">
	     {html_options values=$vcodage3 selected=$codage3 output=$vnomage3}
	   <select>
    </td>	   
   </tr>
   <tr>
    <td class="izq-color">{$lcviena}4 
      <input size="5" type="text" name="C4" {$modo3} size="5" maxlength="6" onchange="valagente(document.formarcas2.C4,document.formarcas2.vagenom4)">
	   <select size=1 name='vagenom4' onchange="valagente(document.formarcas2.vagenom4,document.formarcas2.C4)">
	     {html_options values=$vcodage4 selected=$codage4 output=$vnomage4}
	   <select>
    </td>	   
   </tr>
   <tr>
    <td class="izq-color">{$lcviena}5 
      <input size="5" type="text" name="C5" {$modo3} size="5" maxlength="6" onchange="valagente(document.formarcas2.C5,document.formarcas2.vagenom5)">
	   <select size=1 name='vagenom5' onchange="valagente(document.formarcas2.vagenom5,document.formarcas2.C5)">
	     {html_options values=$vcodage5 selected=$codage5 output=$vnomage5}
	   <select>
    </td>	   
   </tr>
   <tr>
    <td class="izq-color">{$lcviena}6 
      <input size="5" type="text" name="C6" {$modo3} size="5" maxlength="6" onchange="valagente(document.formarcas2.C6,document.formarcas2.vagenom6)">
	   <select size=1 name='vagenom6' onchange="valagente(document.formarcas2.vagenom6,document.formarcas2.C6)">
	     {html_options values=$vcodage6 selected=$codage6 output=$vnomage6}
	   <select>
    </td>	   
   </tr>
   <tr>
    <td class="izq-color">{$lcviena}7 
      <input size="5" type="text" name="C7" {$modo3} size="5" maxlength="6" onchange="valagente(document.formarcas2.C7,document.formarcas2.vagenom7)">
	   <select size=1 name='vagenom7' onchange="valagente(document.formarcas2.vagenom7,document.formarcas2.C7)">
	     {html_options values=$vcodage7 selected=$codage7 output=$vnomage7}
	   <select>
    </td>	   
   </tr>
   <tr>
    <td class="izq-color">{$lcviena}8 
      <input size="5" type="text" name="C8" {$modo3} size="5" maxlength="6" onchange="valagente(document.formarcas2.C8,document.formarcas2.vagenom8)">
	   <select size=1 name='vagenom8' onchange="valagente(document.formarcas2.vagenom8,document.formarcas2.C8)">
	     {html_options values=$vcodage8 selected=$codage8 output=$vnomage8}
	   <select>
    </td>	   
   </tr>

  </tr>
  </table>
    &nbsp; --> 

  <table width="85%">
    <tr><td class="izq2-color" colspan="2">{$lcviena}</td></tr>
    <tr><td>    
    <iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src="m_verccv.php?psol={$vsol1}"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" {$modo3} size="11" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" value="Buscar/Incluir"  name="vvienai" {$modo3} onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vviena,document.formarcas2.vvienai)">
        <input type="button" value="Buscar/Eliminar" name="vvienae" {$modo3} onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vviena,document.formarcas2.vvienae)">
    </td></tr>
  </table>
  &nbsp;



  &nbsp;
  <table width="255" >
  <tr>
    <td class="cnt"><a href="m_pbexfigu.php?vopc=5"><input type="image" src="../imagenes/cancel_f2.png" value="Cancelar" border="0"></a>		Cancelar 	</td>
    <td class="cnt"><input type="image" {$modo3} src="../imagenes/next_f2.png" value="Procesar" border="0"></a>		Procesar 	</td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir 		</td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>
