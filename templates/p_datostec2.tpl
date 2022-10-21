<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="p_datostec2.php?vopc=1" method="post">
  <table>
       <tr><td class="izq5-color">{$campo1}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$vsol1}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$vsol2}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		 </td>
		 <!-- <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td> -->
</form>				  
<!-- <form name="formarcas2" action="p_datostecj.php?vopc=2" method="post">
	    <td>&nbsp;&nbsp;&nbsp;</td>
	    <td class="izq5-color">{$campo2} </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='{$vreg1}' {$modo} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                  <input type="text" name="vreg2" size="6" maxlength="6" 
		value='{$vreg2}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vreg2,6)">
		 </td>
		 <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
</form> -->

  </table>
  &nbsp; 
</form>
&nbsp;     

<form name="formarcas3" action="p_datostec2.php?vopc=3" method="post" onsubmit='return pregunta();'>
  <input type="hidden" name="vsol1" value='{$vsol1}'>
  <input type="hidden" name="vsol2" value='{$vsol2}'>
  <input type="hidden" name="vreg1" value='{$vreg1}'>
  <input type="hidden" name="vreg2" value='{$vreg2}'>
  <input type="hidden" name="vsol" value='{$vsol1}-{$vsol2}'>
  <input type="hidden" name="vder" value='{$vder}'>
  <input type="hidden" name="vnota_ant" value='{$vnota_ant}'> 
  
  <table cellspacing="1" border="1">	
  <tr>   
    <tr>
      <td class="izq-color">{$campo3}</td>
	   <td class="der-color"><input size="9" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" rowspan="7" align="center">
          <a href='{$nameimage}' target="_blank">
          <img border="-1" src={$nameimage} width="193" height="205">
        </td>
      {/if}
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color"><input size="1" type="text" name="vtipo" value='{$vtipo}' {$vmodo}>-
                            <input size="30" type="text" name="vtip" value='{$vtip}' {$vmodo}></td>
    <!--</tr>
 	 <tr>
	   <td class="izq-color">{$campo6}</td>
	   <td class="der-color"><input size="84" type="text" name="vnom" value='{$nombre}' {$modo2}></td>
    </tr>-->
    <tr>
      <td class="izq-color">{$campo6}</td>
      <td class="der-color">
        <textarea rows="2" name="vnom" {$modo2} cols="84" onchange="this.value=this.value.toUpperCase()">{$nombre}</textarea>
      </td>
    </tr>

    <tr>
	   <td class="izq-color">{$campo7}</td>
	   <td class="der-color"><input size="2" type="text" name="vest" value='{$vest}' {$vmodo}>
	                <input size="78" type="text" name="vdesest" value='{$vdesest}' {$vmodo}></td>
    </tr>
	 <tr><td class="izq-color">{$campo8}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='{$vfecreg}' {$vmodo}></td>
    </tr>
	 <tr>
	    <td class="izq-color">{$campo9}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='{$vfecven}' {$vmodo}></td>
    </tr>
	 <tr>
	    <td class="izq-color">{$campo10}</td>
	    <td class="der-color"><input size="84" type="text" name="vtrage" value="{$vtra}" {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr>
  </tr>
  </table>		

  <table cellspacing="1" border="1">	
    <tr>
      <td class="izq-color">{$campo16}</td>
      <td class="der-color">
        <textarea id="vresumen" name="vresumen" {$modo2} rows="15" cols="82"  onchange="this.value=this.value.toUpperCase()">{$vresumen}</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo14}</td>
      <td class="der-color" >
        <input type="text" name="locarno1" {$modo3} value='{$locarno1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.locarno1)">-
        <input type="text" name="locarno2" {$modo3} value='{$locarno2}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.locarno2)">
      </td>
    </tr>
	 <tr>
	 </tr>
	 <tr>
	 </tr>
	 <tr>
	 </tr>
    <tr>
    </tr>

    <tr>
      <td class="izq-color">{$campo18}</td>
      <td class="der-color">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clasificaci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clasificaci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo&nbsp;
      </td>
    </tr>

	 <tr>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        1.&nbsp;<input type="text" name="c1l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c1l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c1l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c1n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c1n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c1n1)">
          <input type="text" name="c1l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c1l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c1l2)" onChange="this.value=this.value.toUpperCase()" >
          <input type="text" name="c1n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c1n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c1n2)"> /
          <input type="text" name="c1n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c1n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c1n3)"> -
          <input type="text" name="t1" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t1}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        2.&nbsp;<input type="text" name="c2l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c2l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c2l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c2n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c2n1)">
          <input type="text" name="c2l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c2l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c2l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c2n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c2n2)"> /
          <input type="text" name="c2n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c2n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c2n3)"> -
          <input type="text" name="t2" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t2}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        3.&nbsp;<input type="text" name="c3l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c3l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c3l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c3n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c3n1)">
          <input type="text" name="c3l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c3l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c3l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c3n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c3n2)"> /
          <input type="text" name="c3n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c3n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c3n3)"> -
          <input type="text" name="t3" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t3}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        4.&nbsp;<input type="text" name="c4l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c4l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c4l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c4n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c4n1)">
          <input type="text" name="c4l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c4l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c4l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c4n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c4n2)"> /
          <input type="text" name="c4n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c4n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c4n3)"> -
          <input type="text" name="t4" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t4}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        5.&nbsp;<input type="text" name="c5l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c5l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c5l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c5n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c5n1)">
          <input type="text" name="c5l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c5l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c5l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c5n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c5n2)"> /
          <input type="text" name="c5n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c5n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c5n3)"> -
          <input type="text" name="t5" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t5}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        6.&nbsp;<input type="text" name="c6l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c6l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c6l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c6n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c6n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c6n1)">
          <input type="text" name="c6l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c6l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c6l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c6n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c6n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c6n2)"> /
          <input type="text" name="c6n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c6n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c6n3)"> -
          <input type="text" name="t6" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t6}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        7.&nbsp;<input type="text" name="c7l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c7l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c7l1)" onChange="this.value=this.value.toUpperCase()" >
          <input type="text" name="c7n1" {$modo4}' onKeyPress="return acceptChar(event,2, this)" value='{$c7n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c7n1)">
          <input type="text" name="c7l2" {$modo4}' onKeyPress="return acceptChar(event,5, this)" value='{$c7l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c7l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c7n2" {$modo4}' onKeyPress="return acceptChar(event,2, this)" value='{$c7n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c7n2)"> /
          <input type="text" name="c7n3" {$modo4}' onKeyPress="return acceptChar(event,2, this)" value='{$c7n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c7n3)"> -
          <input type="text" name="t7" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t7}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        8.&nbsp;<input type="text" name="c8l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c8l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c8l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c8n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c8n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c8n1)">
          <input type="text" name="c8l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c8l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c8l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c8n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c8n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c8n2)"> /
          <input type="text" name="c8n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c8n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c8n3)"> -
          <input type="text" name="t8" {$modo4}' onKeyPress="return acceptChar(event,8, this)" value='{$t8}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
    </tr>
    <tr>
      <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        9.&nbsp;<input type="text" name="c9l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c9l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c9l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c9n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c9n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c9n1)">
          <input type="text" name="c9l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c9l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c9l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c9n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c9n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c9n2)"> /
          <input type="text" name="c9n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c9n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c9n3)"> -
          <input type="text" name="t9" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t9}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       10.&nbsp;<input type="text" name="c10l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c10l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c10l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c10n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c10n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c10n1)">
          <input type="text" name="c10l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c10l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c10l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c10n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c10n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c10n2)"> /
          <input type="text" name="c10n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c10n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c10n3)"> -
          <input type="text" name="t10" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t10}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;
       11.&nbsp;<input type="text" name="c11l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c11l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c11l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c11n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c11n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c11n1)">
          <input type="text" name="c11l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c11l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c11l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c11n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c11n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c11n2)"> /
          <input type="text" name="c11n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c11n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c11n3)"> -
          <input type="text" name="t11" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t11}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       12.&nbsp;<input type="text" name="c12l1" {$modo4} onKeyPress="return acceptChar(event,7, this)" value='{$c12l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c12l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c12n1" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c12n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c12n1)">
          <input type="text" name="c12l2" {$modo4} onKeyPress="return acceptChar(event,5, this)" value='{$c12l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c12l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c12n2" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c12n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c12n2)"> /
          <input type="text" name="c12n3" {$modo4} onKeyPress="return acceptChar(event,2, this)" value='{$c12n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c12n3)"> -
          <input type="text" name="t12" {$modo4} onKeyPress="return acceptChar(event,8, this)" value='{$t12}' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
    </tr>

    <tr>
      <td class="izq-color">&nbsp;&nbsp;</td>
      <td class="der-color">&nbsp;&nbsp;</td>
    </tr>  

    <!-- <tr>
      <td class="izq-color">{$campo15}</td>
      <td class="der-color" >
        <input type="text" name="edicion" '{$modo4}' value='{$edicion}' size="4" maxlength="4" onKeyup="checkLength(event,this,3,document.formarcas3.edicion)">
      </td>
    </tr> -->  

    <tr>
      <td class="izq-color"></td>
      <td class="der-color"></td>
    </tr>  

  </table>

  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo18}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_vercip.php?psol={$vsol1}-{$vsol2}"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vcip" {$modo4} size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vcipe" {$modo4} onclick="browsecip(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vcip,document.formarcas3.vcipe)"> 
        <br>
    </td></tr> 
  </table>

  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo19}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_verinven.php?psol={$vsol1}-{$vsol2}"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vinv" {$modo2} size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vinvi" {$modo2} onclick="browseinventorp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vinv,document.formarcas3.vinvi)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vinve" {$modo2} onclick="browseinventorp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vinv,document.formarcas3.vinve)"> 
        <br>
    </td></tr> 
  </table>
  &nbsp;
  
  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo23}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol={$vsol1}-{$vsol2}&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vprior" {$modo2} size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" {$modo2} onclick="browseprioridp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vprior,document.formarcas3.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" {$modo2} onclick="browseprioridp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vprior,document.formarcas3.vpriore)"> 
        <br>
    </td></tr> 
  </table>
  
  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo11}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol={$vsol1}-{$vsol2}&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <!-- <input type="text" name="vtitut" {$modo4} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" value="Buscar/Incluir"  name="vtitui" {$modo2} onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
        <input type="button" value="Buscar/Eliminar" name="vtitue" {$modo2} onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
        <br> --> 
    </td></tr> 
  </table>
  &nbsp;

  <table cellspacing="1" border="1">	
    <tr>
      <td class="izq-color">{$campo26}</td>
      <td class="der-color">
        <textarea id="vnotas" name="vnotas" {$modo2} rows="15" cols="82"  onChange="this.value=this.value.toUpperCase()">{$vnotas}</textarea> 
      </td>
    </tr>
  </table>
  &nbsp;
  
  <table width="40%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo25}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="p_verequiva.php?psol={$vsol1}-{$vsol2}"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vequiv" {$modo2} size="40" maxlength="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vequivi" {$modo2} onclick="browsequivap(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vequiv,document.formarcas3.vequivi)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vequive" {$modo2} onclick="browsequivap(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vequiv,document.formarcas3.vequive)"> 
        <br>
    </td></tr> 
  </table>
  &nbsp;
  
  &nbsp;
  <table width="230">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
      <td class="cnt"><img src="../imagenes/salir_f2.png" border="0" onclick="window.close()">  Cerrar  </td>
    </tr>
  </table>
</form>

</div>  
</body>
</html>
