<? 
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Para trabajar con Smarty 
include ("../z_includes.php");
   
   if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables de sesion
   $login = $_SESSION['usuario_login'];
   $role    = $_SESSION['usuario_rol'];
   $fecha   = fechahoy();
//Conexion
$sql = new mod_db();
$sql->connection($login);
$vuser = '';

   $smarty->assign('login',$login);
   $smarty->assign('fechahoy',$fecha);
   
   $smarty->display('encabezado1.tpl');
   mensajenew('AVISO: Opci&oacute;n del sistema Bloqueada por Obsoleto, contactar al Administrador ...!!!','../index1.php','N');
   $smarty->display('pie_pag.tpl'); exit();
  
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vsol1=$_POST['vsoli1'];
   $vsol2=$_POST['vsoli2'];
   $vsol3=$_POST['vsoli3'];
   $vsol4=$_POST['vsoli4'];
   $vbol=$_POST['vbol'];

   $vsola= $vsol1.'-'.$vsol2;
   $vsolb= $vsol3.'-'.$vsol4;
   $resultado=false;
   
   if ($vopc==2) {
      $vsola=$_GET['v1'];
      $vsolb=$_GET['v2'];
      $vbol =$_GET['v3'];  }
       
  if ($vopc==3 || $vopc==2) {
            
      if ($vsola=='' || $vsolb=='' || $vbol=='') {
         $smarty->display('encabezado1.tpl');
         mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
	 
      if ($vsola > $vsolb) {
         $smarty->display('encabezado1.tpl');
         mensaje('ERROR AL INTENTAR PROCESAR - RANGO INCORRECTO','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Archivos de Txt para Orden de Publicación Marcas Solicitadas  
$smarty->assign('n_conex',$nconex);

$resul=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stmmarce.clase, stzderec.nro_derecho
		FROM  stmmarce, stztmpbo, stzderec
		WHERE stztmpbo.solicitud between '$vsola' and '$vsolb' 
		AND stztmpbo.boletin = $vbol
		AND stztmpbo.nro_derecho = stzderec.nro_derecho 
		AND stzderec.nro_derecho = stmmarce.nro_derecho 
		AND stzderec.estatus = '1002'
		AND stztmpbo.tipo = 'M'
		ORDER BY stzderec.solicitud");	

        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $mensaje=$mensaje."No existen solicitadas con orden de publicacion a publicar"; }
	 else {
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=ORDEN DE PUBLICACIÓN DE SOLICITADAS ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) { 
         $reg = pg_fetch_array($resul); 
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE DE LAS MARCAS<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>SOLICITANTE<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
  	  	$archivo = $archivo."@COL_01=".$reg[solicitud]."\n";
	  	$archivo = $archivo."@COL_02=".$reg[clase]."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg[nombre])."\n";
	      //busqueda del titular y sus datos
	      $titular='';
	     $res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       			FROM stzottid, stzsolic,stmmarce 
			WHERE stzottid.nro_derecho='$reg[nro_derecho]'
			AND stmmarce.nro_derecho=stzottid.nro_derecho
                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//	if ($cont1=='0'){
	//      	    $titular= $titular.trim($regt['nombre']); }
	//      	else { $titular= $titular.", ".trim($regt['nombre']); }                
	//      	$regt = pg_fetch_array($res_titular);
	//}
        for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	}  
        //

	$archivo = $archivo."@COL_04=".$titular."\n";      
				    
        $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'ordenpub'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


  // Mensaje final
  $smarty ->assign('titulo','Sistema de Marcas'); 
  $smarty ->assign('subtitulo','Generación de Orden de Publicación para Ventura'); 
  $smarty->assign('login',$login);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  mensajebrowse("Proceso Terminado...!!",'m_genord.php');
  $smarty->display('pie_pag.tpl');
  $sql->disconnect();
  exit();    
   
  }   
 } 
   //Asignación de variables para pasarlas a Smarty
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('solicitud3',$vsol3); 
   $smarty ->assign('solicitud4',$vsol4); 
   $smarty ->assign('titulo','Sistema de Marcas'); 
   $smarty ->assign('subtitulo','Generaci&oacute;n de Orden de Publicaci&oacute;n para Ventura'); 
   $smarty ->assign('lsolicitud','Rango de Solicitudes:'); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('espacios','            '); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_genord.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
