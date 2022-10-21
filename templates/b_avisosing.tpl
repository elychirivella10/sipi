<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script type="text/javascript" src="../fckeditor/fckeditor.js"></script>
</head>
<body onLoad="Inicializar()">
<div align="center">

<form name="form" action="b_avisos.php?vopc=2" method="POST">

  <table width="100%">
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
         <input type="text" name="naviso" size="5" maxlength="5" value='{$naviso}' readonly > 
      </td>
  </tr>
     <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color">
         <input type="text" name="titulo" size="100" maxlength="200" value='{$titulo}' readonly > 
      </td>
  </tr> 
  
	<tr>
	      <td class="izq-color" Width='12%'>{$campo}</td>
	      <td class="der-color" >{$var1}
		{php}
		$sBasePath = '../fckeditor/' ;
		$oFCKeditor = new FCKeditor('texto') ;
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Width  = '300%'; 
		$oFCKeditor->Height = '600'; 
		$oFCKeditor->Value  = '' ;
		$oFCKeditor->Create() ;
		{/php}
	      </td>
	</tr>

 </table>

  <table width="255" >
  <tr>
        <input type='hidden' name='titulo' value='{$titulo}'>
        <input type='hidden' name='naviso' value='{$naviso}'>

    <td class="cnt"><input type="image" src="../imagenes/save_f2.png" value="Guardar"><br>Guardar</td> 
    <td class="cnt"><a href="javascript:history.back();"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir</td>
  </tr>
  </table>

 </form>
</div>
</body>
</html>
