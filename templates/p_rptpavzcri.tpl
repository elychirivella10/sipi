<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="foravzcri" action="p_rptavzcri.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">
<br>
<table width="80%" cellspacing="1" border="0">
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
      {$campod} <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.foravzcri.vsol2)" onchange="Rellena(document.foravzcri.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2,6)">{$campoh}
<input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.foravzcri.vsol2h)" onchange="Rellena(document.foravzcri.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2h,6)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
       {$campod} <input type="text" name="vreg1d" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.foravzcri.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2d" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vreg2d,6)">   

       {$campoh} <input type="text" name="vreg1h" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.foravzcri.vreg2h)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2h" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vreg2h,6)">   
      </td>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        {$campod}
        <input type="text" name="fecsold" value='{$fecsold}' size='9' onChange="valFecha(document.foravzcri.fecsold)" onBlur="valagente(document.foravzcri.fecsold,document.foravzcri.fecsolh)"> 
        <a href="javascript:showCal('Calendar73');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campoh}
        <input type="text" name="fecsolh" value='{$fecsolh}' size='9' onChange="valFecha(document.foravzcri.fecsolh)">
        <a href="javascript:showCal('Calendar74');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        {$campod}
        <input type="text" name="fecpubd" value='{$fecpubd}' size='9' onChange="valFecha(document.foravzcri.fecpubd)" onBlur="valagente(document.foravzcri.fecpubd,document.foravzcri.fecpubh)"> 
        <a href="javascript:showCal('Calendar75');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        {$campoh}
        <input type="text" name="fecpubh" value='{$fecpubh}' size='9' onChange="valFecha(document.foravzcri.fecpubh)">
        <a href="javascript:showCal('Calendar76');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
        {$campod}
        <input type="text" name="fecvend" value='{$fecvend}' size='9' onChange="valFecha(document.foravzcri.fecvend)" onBlur="valagente(document.foravzcri.fecvend,document.foravzcri.fecvenh)"> 
        <a href="javascript:showCal('Calendar77');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        {$campoh}
        <input type="text" name="fecvenh" value='{$fecvenh}' size='9' onChange="valFecha(document.foravzcri.fecvenh)">
        <a href="javascript:showCal('Calendar78');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          {html_options values=$arrayestatus selected=$estatus output=$arraydescri1}
        </select>
      </td>
    </tr> 

    <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          {html_options values=$arraytipo selected=$tipo output=$arraytipo}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color" >
        <select size='1' name='pais'>
          {html_options values=$arraypais selected=$pais output=$arraynombre}
        </select>
      </td>
    </tr> 
 
    <tr>
      <td class="izq-color" >{$campo15}</td>
      <td class="der-color">
        <input type="text" name="nombre" size="65" maxlength="200" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>   

    <tr>
      <td class="izq-color" >{$campo16}</td>
      <td class="der-color">
        <input type="text" name="titular" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>   

    <tr>
      <td class="izq-color" >{$campo17}</td>
      <td class="der-color">
        <input type="text" name="agente" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>  

    <tr>
      <td class="izq-color" >{$campo18}</td>
      <td class="der-color">
        <input type="text" name="tramitante" size="65" maxlength="200" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>    

  </table><!--</font>--></center>
	<p></p>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_rptpavzcri.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  </div>  
</form>

</body>
</html>
