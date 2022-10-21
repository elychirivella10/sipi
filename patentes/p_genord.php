<? 
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
  
   if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

   //Variables
   $usuario = $_SESSION['usuario_login'];
   $role    = $_SESSION['usuario_rol'];
   $fecha   = fechahoy();
   $sql   = new mod_db();
   $vuser = '';

   $smarty->assign('login',$usuario);
   $smarty->assign('fechahoy',$fecha);
     
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
      
   $sql->connection();  
	 
  if ($vopc==3 || $vopc==2) {
            
      if ($vsola=='' || $vsolb=='' || $vbol=='') {
         $smarty->display('encabezado1.tpl');
         mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','p_genord.php');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
	 
      if ($vsola > $vsolb) {
         $smarty->display('encabezado1.tpl');
         mensaje('ERROR AL INTENTAR PROCESAR - RANGO INCORRECTO','p_genord.php');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$smarty->assign('n_conex',$nconex);

//Archivos de Txt para Orden de Publicación Patentes Solicitadas  de Invencion (A)
	$resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$vsola' and '$vsolb')
			AND c.boletin = '$vbol'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2002'
			AND c.tipo = 'P'
			AND b.estatus = '2002'
			AND b.tipo_derecho = 'A'
			ORDER BY b.solicitud");	

        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $mensaje=$mensaje."No existen patentes solicitadas de invencion a publicar"; }
	 else {
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=ORDEN DE PUBLICACIÓN PATENTES SOLICITADAS DE INVENCION ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";

	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>TRAMITANTE<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";
	 $reg = pg_fetch_array($resul); 

         for ($cont=0;$cont<$cantreg;$cont++) {
		$nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n";
	  	$archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n";
                $ind=1;
                $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
                $archivo = $archivo."@COL_03=".$tram."\n";
		
	      //busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])); }
	      	else { $titular= $titular.", ".trim(sprintf($regt['nombre'])); }                
	      	$regt = pg_fetch_array($res_titular);
	}
	$archivo = $archivo."@COL_04=".$titular."\n";   				    
        $reg = pg_fetch_array($resul); 
        }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'ordenpub_inv'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
        

//Archivos de Txt para Orden de Publicación Patentes Solicitadas  de Mejora (C)
	$resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$vsola' and '$vsolb')
			AND c.boletin = '$vbol'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2002'
			AND c.tipo = 'P'
			AND b.estatus = '2002'
			AND b.tipo_derecho = 'C'
			ORDER BY b.solicitud");	

        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $mensaje=$mensaje."No existen patentes solicitadas de Mejora a publicar"; }
	 else {

	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=ORDEN DE PUBLICACIÓN PATENTES SOLICITADAS DE MEJORA ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";

	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>TRAMITANTE<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";
         $reg = pg_fetch_array($resul); 
         for ($cont=0;$cont<$cantreg;$cont++) {
	        $nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n";
	  	$archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n";
                $ind=1;
                $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
                $archivo = $archivo."@COL_03=".$tram."\n";
		
    //busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])); }
	      	else { $titular= $titular.", ".trim(sprintf($regt['nombre'])); }                
	      	$regt = pg_fetch_array($res_titular);
	}
	  	$archivo = $archivo."@COL_04=".$titular."\n";      
				    
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'ordenpub_mej'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Archivos de Txt para Orden de Publicación Patentes Solicitadas  de Modelo Industrial (E)
	$resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$vsola' and '$vsolb')
			AND c.boletin = '$vbol'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2002'
			AND c.tipo = 'P'
			AND b.estatus = '2002'
			AND b.tipo_derecho = 'E'
			ORDER BY b.solicitud");	
        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $mensaje=$mensaje."No existen patentes solicitadas de Modelo Industrial a publicar"; }
	 else {
 	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=ORDEN DE PUBLICACIÓN PATENTES SOLICITADAS DE MODELO INDUSTRIAL ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>TRAMITANTE<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";
         $reg = pg_fetch_array($resul); 

         for ($cont=0;$cont<$cantreg;$cont++) {
		$nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg['solicitud']."\n";
	  	$archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n";
	        $ind=1;
                $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	        $archivo = $archivo."@COL_03=".$tram."\n";
		
//busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])); }
	      	else { $titular= $titular.", ".trim(sprintf($regt['nombre'])); }                
	      	$regt = pg_fetch_array($res_titular);
	} 
	  	$archivo = $archivo."@COL_04=".$titular."\n";      
				    
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'ordenpub_modi'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Archivos de Txt para Orden de Publicación Patentes Solicitadas  de Diseño Industrial (G)
	$resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$vsola' and '$vsolb')
			AND c.boletin = '$vbol'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2002'
			AND c.tipo = 'P'
			AND b.estatus = '2002'
			AND b.tipo_derecho = 'G'
			ORDER BY b.solicitud");	

        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $mensaje=$mensaje."No existen patentes solicitadas de Diseño Industrial a publicar"; }
	 else {
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=ORDEN DE PUBLICACIÓN PATENTES SOLICITADAS DE DISEÑO INDUSTRIAL".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>TRAMITANTE<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";
         $reg = pg_fetch_array($resul); 

         for ($cont=0;$cont<$cantreg;$cont++) {
		$nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg[solicitud]."\n";
	  	$archivo = $archivo."@COL_02=".trim($reg[nombre])."\n";
	        $ind=1;
                $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	        $archivo = $archivo."@COL_03=".$tram."\n";
	   	
//busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])); }
	      	else { $titular= $titular.", ".trim(sprintf($regt['nombre'])); }                
	      	$regt = pg_fetch_array($res_titular);
	} 

	  	$archivo = $archivo."@COL_04=".$titular."\n";      
				    
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'ordenpub_disn'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Archivos de Txt para Orden de Publicación Patentes Solicitadas  de Dibujo Industrial (B)
	$resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$vsola' and '$vsolb')
			AND c.boletin = '$vbol'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2002'
			AND c.tipo = 'P'
			AND b.estatus = '2002'
			AND b.tipo_derecho = 'B'
			ORDER BY b.solicitud");	

        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $mensaje=$mensaje."No existen patentes solicitadas de Dibujo Industrial a publicar"; }
	 else {
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=ORDEN DE PUBLICACIÓN PATENTES SOLICITADAS DE DIBUJO INDUSTRIAL ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";

 
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>TRAMITANTE<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";
         $reg = pg_fetch_array($resul); 

         for ($cont=0;$cont<$cantreg;$cont++) {
		$nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg[solicitud]."\n";
	  	$archivo = $archivo."@COL_02=".trim($reg[nombre])."\n";
	        $ind=1;
                $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	        $archivo = $archivo."@COL_03=".$tram."\n";
		
	    //busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])); }
	      	else { $titular= $titular.", ".trim(sprintf($regt['nombre'])); }                
	      	$regt = pg_fetch_array($res_titular);
	} 
	  	$archivo = $archivo."@COL_04=".$titular."\n";      
				    
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'ordenpub_dib'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Archivos de Txt para Orden de Publicación Patentes Solicitadas  de Introduccion (D)
	$resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$vsola' and '$vsolb')
			AND c.boletin = '$vbol'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2002'
			AND c.tipo = 'P'
			AND b.estatus = '2002'
			AND b.tipo_derecho = 'D'
			ORDER BY b.solicitud");	
        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $mensaje=$mensaje."No existen patentes solicitadas de Introduccion a publicar"; }
	 else {
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=ORDEN DE PUBLICACIÓN PATENTES SOLICITADAS DE INTRODUCCION ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";


	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>TRAMITANTE<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";
         $reg = pg_fetch_array($resul); 

         for ($cont=0;$cont<$cantreg;$cont++) {
 		$nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg[solicitud]."\n";
	  	$archivo = $archivo."@COL_02=".trim($reg[nombre])."\n";
 		$ind=1;
                $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	        $archivo = $archivo."@COL_03=".$tram."\n";
		
	    //busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])); }
	      	else { $titular= $titular.", ".trim(sprintf($regt['nombre'])); }                
	      	$regt = pg_fetch_array($res_titular);
	} 
	  	$archivo = $archivo."@COL_04=".$titular."\n";      
				    
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'ordenpub_int'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Archivos de Txt para Orden de Publicación Patentes Solicitadas  de Modelo de Utilidad (F)
	$resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$vsola' and '$vsolb')
			AND c.boletin = '$vbol'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2002'
			AND c.tipo = 'P'
			AND b.estatus = '2002'
			AND b.tipo_derecho = 'F'
			ORDER BY b.solicitud");	
        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $mensaje=$mensaje."No existen patentes solicitadas de Modelo de Utitlidad a publicar"; }
	 else {
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=ORDEN DE PUBLICACIÓN PATENTES SOLICITADAS DE MODELOS DE UTILIDAD ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";


	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>TRAMITANTE<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";
         $reg = pg_fetch_array($resul); 

         for ($cont=0;$cont<$cantreg;$cont++) {
 		$nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg[solicitud]."\n";
	  	$archivo = $archivo."@COL_02=".trim($reg[nombre])."\n";
 		$ind=1;
                $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	        $archivo = $archivo."@COL_03=".$tram."\n";
		
	    //busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])); }
	      	else { $titular= $titular.", ".trim(sprintf($regt['nombre'])); }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_04=".$titular."\n";      
				    
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'ordenpub_modu'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Archivos de Txt para Orden de Publicación Patentes Solicitadas  de Variedades Vegetales (V)
	$resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$vsola' and '$vsolb')
			AND c.boletin = '$vbol'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2002'
			AND c.tipo = 'P'
			AND b.estatus = '2002'
			AND b.tipo_derecho = 'V'
			ORDER BY b.solicitud");	

        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $mensaje=$mensaje."No existen patentes solicitadas de Variedades Vegetales a publicar"; }
	 else {
	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=ORDEN DE PUBLICACIÓN PATENTES SOLICITADAS DE VARIEDADES VEGETALES ".$vbol."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO<D>"."\n";
	 $archivo = $archivo."@TIT_03=<B>TRAMITANTE<D>"."\n";
	 $archivo = $archivo."@TIT_04=<B>TITULAR<D>"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n";
         $reg = pg_fetch_array($resul); 

         for ($cont=0;$cont<$cantreg;$cont++) {
 		$nderec=$reg['nro_derecho'];
  	  	$archivo = $archivo."@COL_01=".$reg[solicitud]."\n";
	  	$archivo = $archivo."@COL_02=".trim($reg[nombre])."\n";
 		$ind=1;
                $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	        $archivo = $archivo."@COL_03=".$tram."\n";

	    //busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])); }
	      	else { $titular= $titular.", ".trim(sprintf($regt['nombre'])); }                
	      	$regt = pg_fetch_array($res_titular);
	}
       	  $archivo = $archivo."@COL_04=".$titular."\n";      
				    
          $reg = pg_fetch_array($resul); }

 	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.'ordenpub_var'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

  // Mensaje final
  $smarty ->assign('titulo','Sistema de Patentes'); 
  $smarty ->assign('subtitulo','Generación de Orden de Publicación para Ventura'); 
  $smarty->assign('login',$usuario);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  mensajebrowse("Proceso Terminado...!!",'p_genord.php');
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
   $smarty ->assign('titulo','Sistema de Patentes'); 
   $smarty ->assign('subtitulo','Generaci&oacute;n de Orden de Publicaci&oacute;n para Ventura'); 
   $smarty ->assign('lsolicitud','Rango de Solicitudes:'); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('espacios','            '); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('p_genord.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
