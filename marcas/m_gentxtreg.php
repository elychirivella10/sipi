<? 
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

include ("../z_includes.php");
   
   if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

   //Variables de sesion
   $login = $_SESSION['usuario_login'];
   $role    = $_SESSION['usuario_rol'];
   $fecha   = fechahoy();
   $vuser = '';

   $smarty->assign('login',$login);
   $smarty->assign('fechahoy',$fecha);
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vsol1=$_POST['vsoli1'];
   $vsol2=$_POST['vsoli2'];
   $vsol3=$_POST['vsoli3'];
   $vsol4=$_POST['vsoli4'];
   $vbol=$_POST['vbol'];
   $vtip=$_POST['vtip'];
   $vsola=sprintf($vsol1.'-'.$vsol2);
   $vsolb=sprintf($vsol3.'-'.$vsol4);
   $resultado=false;

   
   if ($vopc==2) {
      $vsola=$_GET['v1'];
      $vsolb=$_GET['v2'];
      $vbol =$_GET['v3'];
      $vtip =$_GET['v4'];   }

   $sql   = new mod_db();      
   $sql->connection($login); 

   $vtipest=array(1101,1390,1025,1750,1913);
   $vtipsol=array("Concedidas","Concedidas Reclasificadas","Prioridad Extinguida","Caducas","Registros No Renovados"); 
   
	 
   if ($vopc==3 || $vopc==2) {
            
      if ($vsola=='' || $vsolb=='' || $vtip=='') {
         $smarty->display('encabezado1.tpl');
	 mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
	 
      if ($vsola > $vsolb) {
         $smarty->display('encabezado1.tpl');
         mensajenew('Rango de Solicitudes erroneo ...!!!','javascript:history.back();','N');    
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Archivos de Txt para ventura de las solicitadas     
$smarty->assign('n_conex',$nconex);
//Solicitadas todas juntas
if ($vtip==1006) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $mensaje=$mensaje."No existen solicitadas"; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=SOLICITADAS ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
  	  $archivo = $archivo."@01=INSC. ".$reg['solicitud']." DEL ".Cambiar_fecha_mes($reg['fecha_solic'])."\n"."\n";
	 
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
  
 	$archivo = $archivo."@02=SOLICITADA POR: ".$titular."\n"."\n";    

		if ($reg['modalidad']=="D") {
		   $archivo = $archivo."\n"."@SINLOGO=".trim($reg['nombre'])."\n"."\n"."\n";  }  
		if ($reg['modalidad']=="M" || $reg['modalidad']=="G") {
		   $archivo = $archivo."\n"."@TEXTO01=".trim($reg['nombre'])."\n"."\n"."\n"."\n"."\n"."\n"."\n"."\n"."\n"."\n"."\n";  }    

		 //busqueda del distingue
		 $archivo = $archivo."@05=PARA DISTINGUIR: ".$reg['distingue']." CLASE ".$reg['clase']."\n"."\n"; 		 	

		//busqueda del tramitante
		$tram = agente_tram($nagen,$reg['tramitante'],'1');
		$archivo = $archivo."@06=TRAMITANTE:".$tram."\n"."\n";
		   	   
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'solicitadas'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
	

}
 
//Archivos de Txt para ventura de las concedidas     
if ($vtip==1101) {
//Marcas de producto
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='M' 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No Existen Concedidas de Tipo Marca de Producto "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>Solicitud<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>Clase<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>Nombre de la Marcas<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>Titular<D>"."\n";
	 $archivo = $archivo."@TIT_05=<B>Tramitante<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n";
	      //busqueda del titular y sus datos
	      $titular='';
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio 
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//      $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";    

	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";
		    
        $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'marcconc'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Nombres Comerciales
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='N' 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
             $mensaje=$mensaje."No existen concedidas NC "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>Solicitud<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>Clase<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>Nombre de la Marcas<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>Titular<D>"."\n";
	 $archivo = $archivo."@TIT_05=<B>Tramitante<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";     
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";
 	    
        $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'nombconc'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Marcas de Servicio
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='S' 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	   $mensaje=$mensaje."No existen concedidas MS "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>Solicitud<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>Clase<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>Nombre de la Marcas<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>Titular<D>"."\n";
	 $archivo = $archivo."@TIT_05=<B>Tramitante<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";      
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";
		    
        $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'servconc'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
	
//Lemas Comerciales
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='L' 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
              $mensaje=$mensaje."No existen concedidas LC "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>Solicitud<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>Clase<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>Nombre de la Marcas<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>Titular<D>"."\n";
	 $archivo = $archivo."@TIT_05=<B>Tramitante<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n";
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
  	$archivo = $archivo."@COL_04=".$titular."\n";   
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";   
    
        $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'lemaconc'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
	
      } 
//Archivos txt para ventura de concedidas reclasificadas
//Marcas de productos
if ($vtip==1390) {

   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='M' 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
              $mensaje=$mensaje."No existen concedidas reclasificadas MP "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>Solicitud<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>Clase(N)<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>Nombre de la Marcas<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>Titular<D>"."\n";
	 $archivo = $archivo."@TIT_05=<B>Tramitante<D>"."\n";
	// $archivo = $archivo."@TIT_06=<B>Clase(I)<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//      $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
        $archivo = $archivo."@COL_04=".$titular."\n";
	         
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";   
		
	//	//Busqueda de clase internacional
	//	$clasei='';
	//	$res_clase=pg_exec("SELECT * FROM stmrecld WHERE solicitud='$reg[solicitud]'");
	//        $filas_found2=pg_numrows($res_clase);
	//        $regc = pg_fetch_array($res_clase);
	//       for($cont2=0;$cont2<$filas_found2;$cont2++)   {  
	//	   $clasei= $clasei." ".$regc['clase_inter'];
	//	   $regc = pg_fetch_array($res_clase); } 
	//	$archivo = $archivo."@COL_06=".$clasei."\n";  
		
        $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'marcrecl'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Nombres comerciales
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='N' 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
            $mensaje=$mensaje."No existen concedidas reclasificadas NC "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>Solicitud<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>Clase(N)<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>Nombre de la Marcas<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>Titular<D>"."\n";
	 $archivo = $archivo."@TIT_05=<B>Tramitante<D>"."\n";
	 $archivo = $archivo."@TIT_06=<B>Clase(I)<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg[solicitud]."\n";
	  	$archivo = $archivo."@COL_02=".$reg[clase]."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg[nombre])."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";   
		
		//Busqueda de clase internacional
		$clasei='';
		$res_clase=pg_exec("SELECT * FROM stmrecld WHERE solicitud='$reg[solicitud]'");
	        $filas_found2=pg_numrows($res_clase);
	        $regc = pg_fetch_array($res_clase);
	        for($cont2=0;$cont2<$filas_found2;$cont2++)   {  
		   $clasei= $clasei." ".$regc['clase_inter'];
		   $regc = pg_fetch_array($res_clase); } 
		$archivo = $archivo."@COL_06=".$clasei."\n";  
		
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'nombrecl'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Marcas de servicio
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='S' 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
            $mensaje=$mensaje."No existen concedidas reclasificadas MS "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>Solicitud<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>Clase(N)<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>Nombre de la Marcas<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>Titular<D>"."\n";
	 $archivo = $archivo."@TIT_05=<B>Tramitante<D>"."\n";
	 $archivo = $archivo."@TIT_06=<B>Clase(I)<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg[solicitud]."\n";
	  	$archivo = $archivo."@COL_02=".$reg[clase]."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg[nombre])."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		
		//Busqueda de clase internacional
		$clasei='';
		$res_clase=pg_exec("SELECT * FROM stmrecld WHERE solicitud='$reg[solicitud]'");
	        $filas_found2=pg_numrows($res_clase);
	        $regc = pg_fetch_array($res_clase);
	        for($cont2=0;$cont2<$filas_found2;$cont2++)   {  
		   $clasei= $clasei." ".$regc['clase_inter'];
		   $regc = pg_fetch_array($res_clase); } 
		$archivo = $archivo."@COL_06=".$clasei."\n";  
		
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'servrecl'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Lemas comerciales
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='L' 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
           $mensaje=$mensaje."No existen concedidas reclasificadas LC "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>Solicitud<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>Clase(N)<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>Nombre de la Marcas<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>Titular<D>"."\n";
	 $archivo = $archivo."@TIT_05=<B>Tramitante<D>"."\n";
	 $archivo = $archivo."@TIT_06=<B>Clase(I)<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg[solicitud]."\n";
	  	$archivo = $archivo."@COL_02=".$reg[clase]."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg[nombre])."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		
		//Busqueda de clase internacional
		$clasei='';
		$res_clase=pg_exec("SELECT * FROM stmrecld WHERE solicitud='$reg[solicitud]'");
	        $filas_found2=pg_numrows($res_clase);
	        $regc = pg_fetch_array($res_clase);
	        for($cont2=0;$cont2<$filas_found2;$cont2++)   {  
		   $clasei= $clasei." ".$regc['clase_inter'];
		   $regc = pg_fetch_array($res_clase); } 
		$archivo = $archivo."@COL_06=".$clasei."\n";  
		
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'nombrecl'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
      } 
// archivos para generar Devueltas Forma
if ($vtip==1200) {

   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Devueltas "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DEVUELTAS FORMA= ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  

	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
	$nombre=$nombre."devfor".$vbol;
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$nombre.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

// archivos para generar Devueltas Fondo
if ($vtip==1116) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Devueltas "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DEVUELTAS FONDO= ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
	$nombre=$nombre."devfon".$vbol;
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$nombre.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}
//Archivos txt para ventura de observadas
//Todos los tipos de marcas
if ($vtip==1003) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");
 
         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
              $mensaje=$mensaje."No existen Observadas "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=OBS ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
// SE ELIMINO EL TRAMITANTE Y SE AGRGO EL OBSERVANTE POR ORDENES DE CASTIELA 
	 $archivo = $archivo."@TIT_05=<B>OBSERVANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$reg['tramitante']);
	//$archivo = $archivo."@COL_05=".$tram."\n";  


	      //Busqueda del comentario (OBSERVANTE)
	      $coment='';
	      $res_coment=pg_exec("SELECT comentario FROM stzevtrd WHERE stzevtrd.solicitud='$reg[nro_derecho]' AND stzevtrd.evento='40'");
	      $filas_found1=pg_numrows($res_coment);
	      $regt = pg_fetch_array($res_coment);
	      for($cont1=0;$cont1<$filas_found1;$cont1++)   {      
	      	 if ($cont1=='0'){
	      	 	$coment= $coment.trim($regt['comentario']); }
	      	 else { $coment= $coment." / ".trim($regt['comentario']); }                
	      	 $regt = pg_fetch_array($res_coment);
	      } 

	  	$archivo = $archivo."@COL_05=".$coment."\n"."\n";
	         
           $reg = pg_fetch_array($resul); }

	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";  
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'observadas'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

      } 
// prioridad extinguida
if ($vtip==1025) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Prioridad extinguida "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=PRIORIDADES EXTINGUIDAS "."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	$archivo = $archivo."\n";    
        $reg = pg_fetch_array($resul); }
 	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'priorid'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

// Prioridad Extinguida Publicada en prensa extemporanea
if ($vtip==1023) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Prioridad Extinguida Publicada en prensa extemporanea "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=PRIORIDADES EXTINGUIDAS PUB. EN PRENSA EXTEMPORANEA "."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	$archivo = $archivo."\n";    
        $reg = pg_fetch_array($resul); }
 	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'prior_ext_ext'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}


// prioridad extinguida en prensa DEFECTUOSA
if ($vtip==1024) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Prioridad extinguida publicada en prensa defectuosa"; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=PRIORIDADES EXTINGUIDAS PUB. EN PRENSA DEFECTUOSA "."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	  $archivo = $archivo."\n";    
          $reg = pg_fetch_array($resul); }
 	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'prior_ext_def'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

// Perimidas X No publicacion en Prensa
if ($vtip==1030) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No existen  Permidas X No Publicación en Prensa "; }
	 else {
         $reg = pg_fetch_array($resul); 
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=PERIMIDAS POR NO PUBLICACION EN PRENSA "."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	$archivo = $archivo."\n";    
        $reg = pg_fetch_array($resul); }
 	$archivo = $archivo."@IDENTIFIC=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'perimid_pre'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}



//Caducas
if ($vtip==1750) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Caducas "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=CADUCAS"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$archivo = $archivo."@COL_04=".$titular."\n";
	        
	//busqueda del tramitante
	$tram = agente_tram($nagen,$reg['tramitante'],'1');
	$archivo = $archivo."@COL_05=".$tram."\n";  
		   
	$archivo = $archivo."\n";    
        $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'caducas'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  }  
//desistidas 
if ($vtip==1910) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No existen desistidas "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DESISTIMIENTO DE SOLICITUD"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
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
	$open = fopen($via.$via1.'desistid'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  }    
//Desistidas de Observacion
if ($vtip==1125) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No Existen Desistidas de Observacion "; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DESISTIMIENTO DE OBSERVACION"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	  	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
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
	$open = fopen($via.$via1.'desisobs'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  }  


//Desistidas de Observacion X Ley
if ($vtip==1914) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No Existen Desistidas de Observacion X Ley"; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DESISTIMIENTO DE OBSERVACION X LEY"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//   if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
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
	$open = fopen($via.$via1.'desobsly'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  } 


//Desistidas de Observacion x Mejor Derecho
if ($vtip==1130) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	  $mensaje=$mensaje."No Existen Desistidas de Observacion Mejor Derecho"; }
	 else {
         $reg = pg_fetch_array($resul); 

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA, MINISTERIO DE INDUSTRIA Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=195 y 146"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=DESISTIMIENTO DE OBSERVACION MEJOR DERECHO"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE(N)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>NOMBRE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TRAMITANTE<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	 	$nagen=$reg['agente'];
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  	$archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	  	$archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";

	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzottid.nacionalidad, stzottid.domicilio
       		FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//  if ($cont1=='0'){
	//       $titular= $titular.trim($regt['nombre']); }
	//   else { $titular= $titular.", ".trim($regt['nombre']); }                
	//   $regt = pg_fetch_array($res_titular);
	//} 
        //Agregado 05/05/2010 por RM por Orden del Ministro 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
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
	$open = fopen($via.$via1.'desobsmd'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}     
  } 

// Caducas por no renovacion y registros no renovados
if ($vtip==1996 or $vtip == 1913) {
 if ($vtip==1996) {
     $resultado=pg_exec("SELECT b.solicitud, b.nombre, a.clase, b.registro, e.nombre as titular, b.agente, trim(tramitante) as tramitante,d.domicilio,d.nacionalidad
			FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d, stzsolic e
			WHERE (c.solicitud between '$vsola' and '$vsolb')
			AND c.boletin = '$vbol'
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1996'
			AND c.tipo = 'M'
			AND b.estatus = '1996'
			AND a.nro_derecho = d.nro_derecho
			AND e.titular = d.titular
			ORDER BY b.registro");	
 }
 if ($vtip==1913) {
     $resultado=pg_exec("SELECT b.solicitud, b.nombre, a.clase, b.registro, e.nombre as titular, b.agente, trim(tramitante) as tramitante,d.domicilio,d.nacionalidad
			FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d, stzsolic e
			WHERE (c.solicitud between '$vsola' and '$vsolb')
			AND c.boletin = '$vbol'
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1913'
			AND c.tipo = 'M'
			AND b.estatus = '1913'
			AND a.nro_derecho = d.nro_derecho
			AND e.titular = d.titular
			ORDER BY b.registro");
 }

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
	 if ($vtip ==1996) {
	    $archivo = $archivo."@TITUL00=Caducas por No Renovacion= "."\n"."\n";}
	 if ($vtip ==1913) {
	    $archivo = $archivo."@TITUL00=Registros No Renovados= "."\n"."\n";}
	 $archivo = $archivo."@TEXTO00="."\n"."\n"; 
	 $archivo = $archivo."@TIT_01=<B>REGISTRO<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>CLASE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>MARCA<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE.<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_05=<B>TITULAR<D>"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

         for ($cont=0;$cont<$cantreg;$cont++) {
	   $pais_nombre = pais($reg['nacionalidad']);
	   $nbtitular = trim($reg['titular']).'.'.trim($reg['domicilio']).','.trim($pais_nombre);
  	   $archivo = $archivo."@COL_01=".$reg['registro']."\n"."\n";
	   $archivo = $archivo."@COL_02=".$reg['clase']."\n"."\n";
	   $archivo = $archivo."@COL_03=".trim($reg['nombre'])."\n"."\n";
	      $tram = agente_tram($reg['agente'],$reg['tramitante'],($ind='1'));
	   $archivo = $archivo."@COL_04=".trim($tram)."\n"."\n";
	   //$archivo = $archivo."@COL_05=".$reg['titular']."\n"."\n";      
	   $archivo = $archivo."@COL_05=".$nbtitular."\n"."\n";      
  
	   $archivo = $archivo."\n";    
           $reg = pg_fetch_array($resultado); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
	$via= "../../";
	$via1= "boletin/";
	$fecha= strftime("%d-%m-%y,%T");
        if ($vtip ==1996) {
	   $open = fopen($via.$via1.'cadnorenv'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");}
        if ($vtip ==1913) {
           $open = fopen($via.$via1.'regnorenv'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");}
	fputs($open, "$archivo");
	fclose($open);
}

  // Mensaje final
  $smarty ->assign('titulo','Sistema de Marcas'); 
  $smarty ->assign('subtitulo','Generación de Archivos del Boletin para Ventura'); 
  $smarty->assign('login',$usuario);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  mensajebrowse("Proceso Terminado...!!",'m_gentxtreg.php');
  //mensajenew('Proceso Terminado ...!!','m_gentxt.php','S');
  //mensaje("Se Generaron '$cantreg' Solicitudes",'m_gentxt.php');
  $smarty->display('pie_pag.tpl');
  $sql->disconnect();
  exit();    
   
  }   
  
   //Asignación de variables para pasarlas a Smarty
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('solicitud3',$vsol3); 
   $smarty ->assign('solicitud4',$vsol4); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest); 
   $smarty ->assign('titulo','Sistema de Marcas'); 
   $smarty ->assign('subtitulo','Generaci&oacute;n de Archivos del Bolet&iacute;n Registro para Ventura'); 
   $smarty ->assign('lsolicitud','Rango de Solicitudes:'); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('espacios','            '); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_gentxtreg.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
