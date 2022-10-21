
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>
<body onLoad="Inicializar()">
<div align="center">

<form name="form" action="m_resnueva3.php" method="POST">

  <table>

        <tr>
	      <td class="izq-color">{$tencabezado}</td><td class="der-color">{$encabezado}</td>
	</tr>
        <tr>
	      <td class="izq-color">{$tvistos}</td><td class="der-color">
	    {section name=cont loop=$vnumrows}
 	    {$vistos[cont]}<br/><br/>
	    {/section} 

	      </td>
	</tr>
	<tr>
	      <td class="izq-color">{$toposicion}</td>
	      <td class="der-color">{$var1}
		{php}
		$sBasePath = $_SERVER['PHP_SELF'] ;
		$sBasePath = substr($sBasePath, 0, strpos($sBasePath, "resoluciones"));
		$oFCKeditor = new FCKeditor('oposicion') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor-> ToolbarSet = 'Basic';
		$oFCKeditor->Value ='';
		$oFCKeditor->Create();
		{/php}
	      </td>
	</tr>

	<tr>
	      <td class="izq-color">{$tcontestacion}</td>
	      <td class="der-color">
		{php}
		$sBasePath = $_SERVER['PHP_SELF'] ;
		$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "resoluciones" ) ) ;
		$oFCKeditor = new FCKeditor('contestacion') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor-> ToolbarSet = 'Basic';
		$oFCKeditor->Value = '';
		$oFCKeditor->Create();
		{/php}
	      </td>
	</tr>
	<tr>
	      <td class="izq-color">{$tanalisis}</td><td class="der-color">{$analisis}</td>      
	      
	</tr>
	<tr>
	      <td class="izq-color">{$tmotiva}</td>
	      <td class="der-color">
		{php}
		$sBasePath = $_SERVER['PHP_SELF'] ;
		$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "resoluciones" ) ) ;
		$oFCKeditor = new FCKeditor('motiva') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor-> ToolbarSet = 'Basic';
		$oFCKeditor->Value = '';
		$oFCKeditor->Create();
		{/php}
	      </td>
	</tr>
	<tr>
	      <td class="izq-color">{$tdesicion}</td>
              <td class="der-color">
		{php}
		$sBasePath = $_SERVER['PHP_SELF'] ;
		$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "resoluciones" ) ) ;
		$oFCKeditor = new FCKeditor('desicion') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor-> ToolbarSet = 'Basic';
		$oFCKeditor->Value = $decision;
		$oFCKeditor->Create();
		{/php}
              </td> 
	</tr>
	
	<tr>
	      <td class="izq-color">{$tpie}</td><td class="der-color">{$pie}</td>
	</tr>
 </table>

<p></p> <p></p> <p></p>
  <table width="255" >
    <tr>
      <td class="izq-color" >Evento a Cargar: </td>
      <td class="der-color" >
        <select size='1' name='evto'>
          {html_options values=$arrayevto selected=$tipo output=$arrayevto}
        </select>
      </td>
    </tr> 
  </table>        
        
<p></p> <p></p> <p></p>
  <table width="255" >
  <tr>
	<input  type='hidden' value='{$plantid}' name='plantid' />
	<input  type='hidden' value='{$encabezado}' name='encabezado' />
	<input  type='hidden' value='{$todovistos}' name='todovistos' />
	<input  type='hidden' value='{$analisis}' name='analisis' />
	<input  type='hidden' value='{$desicion}' name='desicion' />
	<input  type='hidden' value='{$oponente}' name='oponente' />
	<input  type='hidden' value='{$contesta}' name='contesta' />
	<input  type='hidden' value='{$pie}' name='pie' />
	<input  type='hidden' value='{$num}' name='num' />
	<input  type='hidden' value='{$solicitudes}' name='solicitudes' />
	<input  type='hidden' value='{$res_tipo}' name='res_tipo' />
	<input  type='hidden' value='{$evto}' name='evto' />
	
    <td class="cnt"><input type="image" src="../imagenes/save_f2.png" value="Guardar"><br>Guardar</td> 
    <td class="cnt"><a href="javascript:history.back();"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir</td>
  </tr>
  </table>

 </form>
</div>
</body>
</html>
