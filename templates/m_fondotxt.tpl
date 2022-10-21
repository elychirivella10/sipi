<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>{$title}</title>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
<form name="formarcas2" enctype="multipart/form-data" action="m_fondotxt.php?vopc=2" method="POST" onsubmit='return pregunta();'>

<table>
<tr>
  <tr>
    <td class="izq-color" >{$campo1}</td>
     <td class="der-color">
       <input type="text" name="boletin" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
    </td>
  </tr>   
  <tr>
    <td class="izq-color" >{$campo2}</td>
    <td class="der-color">
      <select size="1" name="estatus">
        {html_options values=$arrayvest selected=$estatus output=$arraytest}
      </select>
    </td>
  </tr> 
<table>
<tr>

&nbsp;
<table align="center">
  <tr>
    <td class="cnt">
      <input type="submit" value="Transferir" class="botones">&nbsp;&nbsp;</td>
    <td class="cnt">
      <a href="../index1.php"><input type="button" value=" Salir " class="botones"></a></td>
  </tr>
</table>



 </form>
</div>
</body>
</html>
