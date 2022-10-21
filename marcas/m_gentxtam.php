<?php
//Comienzo del Programa por los encabezados del reporte
//ob_start();
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login = $_SESSION['usuario_login'];
$role  = $_SESSION['usuario_rol'];
$fecha = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n  de Anotaciones Marginales para Ventura');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);


//Nomenclatura para el tipo de marca 
function tipo_marca_am($var) {
  if ($var=='M') {return "MP";}
  if ($var=='N') {return "NC";}
  if ($var=='L') {return "LC";}
  if ($var=='S') {return "MS";}

}
//Nomenclatura para la clase N - I
function clase($clas,$ind,$vtip) {
  if ($vtip=='LC') {return "LC";}
  if ($vtip=='NC' and $ind == 'I') {return "NC";}
  if ($vtip=='NC' and $ind == 'N') {return "DC";}
  if ($vtip=='MP' or $vtip == 'MS') {return $clas.' '.$ind;}
}

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$boletin=$_POST["boletin"];
$tipo=$_POST["tipo"];

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("boletin","tipo");
  $valores = array($boletin,$tipo);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("Error: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Validacion de Boletin a Generar 
$obj_query = $sql->query("SELECT max(nro_boletin) FROM stzboletin");
$objs = $sql->objects('',$obj_query);
$vbolult = $objs->max;
if ($boletin<$vbolult) {
  $smarty->display('encabezado1.tpl');
  mensajenew("ERROR: Bolet&iacute;n '$boletin' ya Generado anteriormente ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit();           
}

// Armando el query segun las opciones
if ($tipo=='RENOVACIONES') { 
   $resultado=pg_exec("SELECT stzderec.nro_derecho, stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzmargi,stzderec
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'R'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.registro ");


//verificando que consiguio los datos necesarios
if (!$resultado)    { 
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Anotaciones Marginales: de Renovaciones ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Datos asociados para Generar ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$reg = pg_fetch_array($resultado);
$cantreg=pg_numrows($resultado); 


//generacion del TXT 
 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
 $archivo = $archivo."***TRIM***"."\n";
 $archivo = $archivo."***TRIM***"."\n";
 $archivo = $archivo."***TRIM***"."\n";
 $archivo = $archivo."***TRIM***"."\n";
 $archivo = $archivo."@TITUL00=Registro de Renovaciones de Marcas= "."\n"."\n";
 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
 $archivo = $archivo."@TIT_02=<B>TIPO<D>"."\n"."\n";
 $archivo = $archivo."@TIT_03=<B>MARCA<D>"."\n"."\n";
 $archivo = $archivo."@TIT_04=<B>CLASE INT.<D>"."\n"."\n";
 $archivo = $archivo."@TIT_05=<B>TITULAR<D>"."\n"."\n";
 $archivo = $archivo."@TIT_06=<B>VIGENTE HASTA<D>"."\n"."\n";
 $archivo = $archivo."@TIT_07=<B>TRAMITANTE<D>"."\n"."\n";
 $archivo = $archivo."***TRIM***"."\n"."\n";
 $archivo = $archivo."@SEPARADOR="."\n"."\n";

 for ($cont=0;$cont<$cantreg;$cont++) {
  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
   $vtip=tipo_marca_am($reg['tipo_derecho']);
	$archivo = $archivo."@COL_02=".$vtip."\n"."\n";
	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	//$clase=clase($reg['clase'],$reg['ind_claseni'],$vtip);
	$archivo = $archivo."@COL_04=".$reg['claseint']."\n"."\n";
	$archivo = $archivo."@COL_05=".$reg['titular2']."\n"."\n";      
	$archivo = $archivo."@COL_06=".$reg['vencimiento']."\n"."\n";      
	$archivo = $archivo."@COL_07=".$reg['tramitante']."\n"."\n";      
 	$archivo = $archivo."\n";
 	    
   $reg = pg_fetch_array($resultado); 
 }

 $archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 $via= "../../";
 $via1= "boletin/";
 $fecha= strftime("%d-%m-%y,%T");
 $open = fopen($via.$via1.'amrenova'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
 fputs($open, "$archivo");
 fclose($open);
}

// Armando el query segun las opciones
if ($tipo=='CAMBIO DE NOMBRE') { 
   $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzderec, stzmargi
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'N'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.registro ");


//verificando que consiguio los datos necesarios
if (!$resultado)    { 
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Anotaciones Marginales: de Cambio de Nombre ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Datos asociados para Generar ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$reg = pg_fetch_array($resultado);
$cantreg=pg_numrows($resultado); 


//generacion del TXT 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=Registro de Cambio de Nombre= "."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TIPO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>MARCA<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR ANTERIOR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TITULAR ACTUAL<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_06=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
		$vtip=tipo_marca_am($reg['tipo_derecho']);
	  	$archivo = $archivo."@COL_02=".$vtip."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	  	$archivo = $archivo."@COL_04=".$reg['titular1']."\n"."\n";
	  	$archivo = $archivo."@COL_05=".$reg['titular2']."\n"."\n";       
	  	$archivo = $archivo."@COL_06=".$reg['tramitante']."\n"."\n";      
  
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resultado); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amcanomb'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);
}

// Armando el query segun las opciones
if ($tipo=='CESIONES') { 
   $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzderec, stzmargi
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'C'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.registro ");


//verificando que consiguio los datos necesarios
if (!$resultado)    { 
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Anotaciones Marginales: de Cesiones ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Datos asociados para Generar ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$reg = pg_fetch_array($resultado);
$cantreg=pg_numrows($resultado); 


//generacion del TXT 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=Registro de Cesiones de Marcas= "."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TIPO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>MARCA<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>CEDENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>CESIONARIO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_06=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
		$vtip=tipo_marca_am($reg['tipo_derecho']);
	  	$archivo = $archivo."@COL_02=".$vtip."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	  	$archivo = $archivo."@COL_04=".$reg['titular1']."\n"."\n";
	  	$archivo = $archivo."@COL_05=".$reg['titular2']."\n"."\n";       
	  	$archivo = $archivo."@COL_06=".$reg['tramitante']."\n"."\n";      
  
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resultado); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amcesion'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);
}

// Armando el query segun las opciones
if ($tipo=='FUSIONES') { 
   $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzderec, stzmargi
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'F'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.registro ");


//verificando que consiguio los datos necesarios
if (!$resultado)    { 
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Anotaciones Marginales: de Fusiones ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Datos asociados para Generar ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$reg = pg_fetch_array($resultado);
$cantreg=pg_numrows($resultado); 


//generacion del TXT 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=Registro de Fusiones de Marcas= "."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TIPO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>MARCA<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>EMPRESA A FUSIONARSE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>EMPRESA SOBREVIVIENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_06=<B>DOMICILIO DEL SOBREVIVIENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_06=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
		$vtip=tipo_marca_am($reg['tipo_derecho']);
	  	$archivo = $archivo."@COL_02=".$vtip."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	  	$archivo = $archivo."@COL_04=".$reg['titular1']."\n"."\n";
	  	$archivo = $archivo."@COL_05=".$reg['titular2']."\n"."\n";  
	  	$archivo = $archivo."@COL_06=".$reg['domicilio']."\n"."\n";        
	  	$archivo = $archivo."@COL_07=".$reg['tramitante']."\n"."\n";      
  
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resultado); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amfusion'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);
}

// Armando el query segun las opciones
if ($tipo=='CAMBIO DE DOMICILIO') { 
   $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzderec, stzmargi
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'D'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.registro ");


//verificando que consiguio los datos necesarios
if (!$resultado)    { 
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Anotaciones Marginales: de Cambio de Domicilio ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Datos asociados para Generar ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$reg = pg_fetch_array($resultado);
$cantreg=pg_numrows($resultado); 


//generacion del TXT 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=Registro de Cambio de Domicilio= "."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TIPO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>MARCA<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>DOMICILIO ANTERIOR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_06=<B>DOMICILIO ACTUAL<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_06=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
		$vtip=tipo_marca_am($reg['tipo_derecho']);
	  	$archivo = $archivo."@COL_02=".$vtip."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	  	$archivo = $archivo."@COL_04=".$reg['titular2']."\n"."\n";
	  	$archivo = $archivo."@COL_05=".$reg['domicilio_ant']."\n"."\n";  
	  	$archivo = $archivo."@COL_06=".$reg['domicilio']."\n"."\n";        
	  	$archivo = $archivo."@COL_07=".$reg['tramitante']."\n"."\n";      
  
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resultado); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amcandom'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);
}

// Armando el query segun las opciones
if ($tipo=='LICENCIAS') { 
   $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzderec, stzmargi
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'L'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.registro ");


//verificando que consiguio los datos necesarios
if (!$resultado)    { 
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Anotaciones Marginales: de Licencias de Uso ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Datos asociados para Generar ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$reg = pg_fetch_array($resultado);
$cantreg=pg_numrows($resultado); 


//generacion del TXT 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=Registro de Licencias de Uso= "."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TIPO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>MARCA<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>LICENCIANTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>LICENCIATARIO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_06=<B>DOMICILIO DEL LICENCIATARIO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_06=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
		$vtip=tipo_marca_am($reg['tipo_derecho']);
	  	$archivo = $archivo."@COL_02=".$vtip."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	  	$archivo = $archivo."@COL_04=".$reg['titular1']."\n"."\n";
	  	$archivo = $archivo."@COL_05=".$reg['titular2']."\n"."\n";  
	  	$archivo = $archivo."@COL_06=".$reg['domicilio']."\n"."\n";        
	  	$archivo = $archivo."@COL_07=".$reg['tramitante']."\n"."\n";      
  
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resultado); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amlicenc'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);
}


//desistidas de AM. Renovaciones
if ($tipo=='DESTMTO. RENOVACIONES') {
   $resul=pg_exec("SELECT b.registro, b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbor c
	WHERE c.boletin = '$vbol'
   	AND c.estatus = '1557'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.registro");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."Error: No existen Desitidas de Renovaciones "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DESISTIMIENTO DE SOLICITUD DE RENOVACIONES"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
	       $titular= $titular.trim($regt['nombre']); }
	   else { $titular= $titular.", ".trim($regt['nombre']); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	  $archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resul); }
	
	$archivo = $archivo."@SEPARADOR="."\n"."\n";
	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";  
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amdesis_renov'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  }  

//desistidas de AM. Cambio de Nombre
if ($tipo=='DESTMTO. CAMBIO DE NOMBRE') {
   $resul=pg_exec("SELECT b.registro, b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbor c
	WHERE c.boletin = '$vbol'
   	AND c.estatus = '1561'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.registro");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."Error: No existen Desitidas de Cambio de Nombre "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DESISTIMIENTO DE SOLICITUD DE CAMBIO DE NOMBRE"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
	       $titular= $titular.trim($regt['nombre']); }
	   else { $titular= $titular.", ".trim($regt['nombre']); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	  $archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resul); }
	
	$archivo = $archivo."@SEPARADOR="."\n"."\n";
	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";  
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amdesis_camnb'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  }  

//desistidas de AM. Cambio de Domicilio
if ($tipo=='DESTMTO. CAMBIO DE DOMICILIO') {
   $resul=pg_exec("SELECT b.registro, b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbor c
	WHERE c.boletin = '$vbol'
   	AND c.estatus = '1562'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.registro");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."Error: No existen Desitidas de Cambio de Domicilio "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DESISTIMIENTO DE SOLICITUD DE CAMBIO DE DOMICILIO"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
	       $titular= $titular.trim($regt['nombre']); }
	   else { $titular= $titular.", ".trim($regt['nombre']); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	  $archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resul); }
	
	$archivo = $archivo."@SEPARADOR="."\n"."\n";
	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";  
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amdesis_camdo'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  }  


//desistidas de AM. Cesiones
if ($tipo=='DESTMTO. CESIONES') {
   $resul=pg_exec("SELECT b.registro, b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbor c
	WHERE c.boletin = '$vbol'
   	AND c.estatus = '1558'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.registro");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."Error: No existen Desitidas de Cesiones "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DESISTIMIENTO DE SOLICITUD DE CESIONES"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
	       $titular= $titular.trim($regt['nombre']); }
	   else { $titular= $titular.", ".trim($regt['nombre']); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	  $archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resul); }
	
	$archivo = $archivo."@SEPARADOR="."\n"."\n";
	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";  
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amdesis_cesi'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  }  

//desistidas de AM. Fusiones
if ($tipo=='DESTMTO. FUSIONES') {
   $resul=pg_exec("SELECT b.registro, b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbor c
	WHERE c.boletin = '$vbol'
   	AND c.estatus = '1559'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.registro");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."Error: No existen Desitidas de Fusiones "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DESISTIMIENTO DE SOLICITUD DE FUSIONES"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
	       $titular= $titular.trim($regt['nombre']); }
	   else { $titular= $titular.", ".trim($regt['nombre']); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	  $archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resul); }
	
	$archivo = $archivo."@SEPARADOR="."\n"."\n";
	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";  
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amdesis_fusi'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  }

//desistidas de AM. Licencias
if ($tipo=='DESTMTO. LICENCIAS') {
   $resul=pg_exec("SELECT b.registro, b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbor c
	WHERE c.boletin = '$vbol'
   	AND c.estatus = '1560'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.registro");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."Error: No existen Desitidas de Licencias de Uso "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DESISTIMIENTO DE SOLICITUD DE LICENCIAS DE USO"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
	       $titular= $titular.trim($regt['nombre']); }
	   else { $titular= $titular.", ".trim($regt['nombre']); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	  $archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resul); }
	
	$archivo = $archivo."@SEPARADOR="."\n"."\n";
	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";  
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'amdesis_lice'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  }

//Desconexion a la base de datos
$smarty->display('encabezado1.tpl');
mensajebrowse("Proceso Terminado...!!",'m_pgentxtam.php');
$smarty->display('pie_pag.tpl');
$sql->disconnect();exit(); 

?>
