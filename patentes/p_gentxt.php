<? 
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
   
   if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

   //Variables
   $login = $_SESSION['usuario_login'];
   $role    = $_SESSION['usuario_rol'];
   $fecha   = fechahoy();
   $sql   = new mod_db();
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
   $nconex = $_POST['nconex'];

   if ($vopc==2) {
      $vsola=$_GET['v1'];
      $vsolb=$_GET['v2'];
      $vbol =$_GET['v3'];
      $vtip =$_GET['v4'];   }
      
   $sql->connection($login); 

   $vtipest=array(2006,2101,2103,2200,2025,2023,2024,2030,2119,2910,2915,2090,2750,2009);
   $vtipsol=array("Solicitadas","Concedidas","Devueltas Fondo","Devueltas Forma","Prioridad Extinguida","Prioridad Ext. Prensa Extemporanea","Prioridad Ext. Prensa Defectuosa","Perimidas X no Publicacion en Prensa", "Denegadas","Desistidas","Desistidas X Registro","Abandonadas","Abandonadas X No Pago","Oposiciones"); 
   
	 
   if ($vopc==3 || $vopc==2) {
            
      if ($vsola=='' || $vsolb=='' || $vtip=='') {
         $smarty->display('encabezado1.tpl');
         mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
	 
      if ($vsola > $vsolb) {
         $smarty->display('encabezado1.tpl');
         mensaje('ERROR AL INTENTAR PROCESAR - RANGO INCORRECTO','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$smarty->assign('n_conex',$nconex);  
//Archivos de Txt para ventura de las solicitadas     
if ($vtip==2006) {
   //Solicitadas de Invencion con Resumen tipo A
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'A'
	ORDER BY b.solicitud");
	
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	    $mensaje=$mensaje."No Existen Solicitadas de Invencion"; }
	else {
   $reg = pg_fetch_array($resul); 
	$archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	$archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	$archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."@TITUL00=SOLICITADAS DE INVENCION"."\n"."\n";
	$archivo = $archivo."@TEXTO00="."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";

   for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";

	  //Prioridad
	  $cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
	  $reg_pri = pg_fetch_array($cons_pri);
	  $filas_cons_pri=pg_numrows($cons_pri);
	  $prioridad="";
	  for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	 	$prioridad=$prioridad.trim($reg_pri['prioridad']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['pais_priori']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['fecha_priori']).'; ';
     	     $reg_pri = pg_fetch_array($cons_pri);
          }
	  $archivo = $archivo."@COL_01= (30)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$prioridad."\n"."\n";  

  	  // Clasificacion Internacional
	  $clasi="";
	  $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	// Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

 	  //Inventores
	  $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
	   $reg_inv = pg_fetch_array($cons_inv);
	   $filas_cons_inv=pg_numrows($cons_inv);
  	   $archivo = $archivo."@COL_01= (72)"."\n"."\n";  
	   $inventores="";
	   for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
	      $inventores=$inventores.trim($reg_inv['nombre_inv'])."; ";
  	     $reg_inv = pg_fetch_array($cons_inv);
           }
           $archivo = $archivo."@COL_02= ".$inventores."\n"."\n";
      
	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";

	  //Resumen
	  $res_dist=pg_exec("SELECT * FROM stppatte WHERE nro_derecho = '$nderec'");
	  $regdis = pg_fetch_array($res_dist);
	  $archivo = $archivo."@COL_01= (57)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".trim($regdis['resumen'])."\n"."\n";
		   	   
     $reg = pg_fetch_array($resul);
   }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'SINV'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


  //Solicitadas tipo mejora C
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'C'
	ORDER BY b.solicitud");
	
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	    $mensaje=$mensaje."No Existen Solicitadas de Mejora"; }
	else {
   $reg = pg_fetch_array($resul); 
	$archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	$archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	$archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."@TITUL00=SOLICITADAS DE MEJORA"."\n"."\n";
	$archivo = $archivo."@TEXTO00="."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";

   for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";

	  //Prioridad
	  $cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
	  $reg_pri = pg_fetch_array($cons_pri);
	  $filas_cons_pri=pg_numrows($cons_pri);
	  $prioridad="";
	  for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	 	$prioridad=$prioridad.trim($reg_pri['prioridad']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['pais_priori']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['fecha_priori']).'; ';
     	     $reg_pri = pg_fetch_array($cons_pri);
          }
	  $archivo = $archivo."@COL_01= (30)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$prioridad."\n"."\n";  

  	  // Clasificacion Internacional
	  $clasi="";
	  $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	// Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

 	  //Inventores
	  $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
	   $reg_inv = pg_fetch_array($cons_inv);
	   $filas_cons_inv=pg_numrows($cons_inv);
  	   $archivo = $archivo."@COL_01= (72)"."\n"."\n";  
	   $inventores="";
	   for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
	      $inventores=$inventores.trim($reg_inv['nombre_inv'])."; ";
  	     $reg_inv = pg_fetch_array($cons_inv);
           }
           $archivo = $archivo."@COL_02= ".$inventores."\n"."\n";
      
	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";

	  //Resumen
	  $res_dist=pg_exec("SELECT * FROM stppatte WHERE nro_derecho = '$nderec'");
	  $regdis = pg_fetch_array($res_dist);
	  $archivo = $archivo."@COL_01= (57)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".trim($regdis['resumen'])."\n"."\n";
		   	   
     $reg = pg_fetch_array($resul);
   }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'SOLMEJ'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

  //Solicitadas de MODELO INDUSTRIAL E
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'E'
	ORDER BY b.solicitud");
	
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	    $mensaje=$mensaje."No Existen Solicitadas de Modelo Industrial"; }
	else {
   $reg = pg_fetch_array($resul); 
	$archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	$archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	$archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."@TITUL00=SOLICITADAS DE MODELO INDUSTRIAL"."\n"."\n";
	$archivo = $archivo."@TEXTO00="."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";

   for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";

	  //Prioridad
	  $cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
	  $reg_pri = pg_fetch_array($cons_pri);
	  $filas_cons_pri=pg_numrows($cons_pri);
	  $prioridad="";
	  for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	 	$prioridad=$prioridad.trim($reg_pri['prioridad']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['pais_priori']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['fecha_priori']).'; ';
     	     $reg_pri = pg_fetch_array($cons_pri);
          }
	  $archivo = $archivo."@COL_01= (30)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$prioridad."\n"."\n";  

  	  // Clasificacion Internacional
	  $clasi="";
	  $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	// Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

 	  //Inventores
	  $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
	   $reg_inv = pg_fetch_array($cons_inv);
	   $filas_cons_inv=pg_numrows($cons_inv);
  	   $archivo = $archivo."@COL_01= (72)"."\n"."\n";  
	   $inventores="";
	   for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
	      $inventores=$inventores.trim($reg_inv['nombre_inv'])."; ";
  	     $reg_inv = pg_fetch_array($cons_inv);
           }
           $archivo = $archivo."@COL_02= ".$inventores."\n"."\n";
      
	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";

	  //Resumen
	  $res_dist=pg_exec("SELECT * FROM stppatte WHERE nro_derecho = '$nderec'");
	  $regdis = pg_fetch_array($res_dist);
	  $archivo = $archivo."@COL_01= (57)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".trim($regdis['resumen'])."\n"."\n";
		   	   
     $reg = pg_fetch_array($resul);
   }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'SOLMMID'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


  //Solicitadas de DIBUJO INDUSTRIAL B
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'B'
	ORDER BY b.solicitud");
	
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	    $mensaje=$mensaje."No Existen Solicitadas de Dibujo Industrial"; }
	else {
   $reg = pg_fetch_array($resul); 
	$archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	$archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	$archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."@TITUL00=SOLICITADAS DE DIBUJO INDUSTRIAL"."\n"."\n";
	$archivo = $archivo."@TEXTO00="."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";

   for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";

	  //Prioridad
	  $cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
	  $reg_pri = pg_fetch_array($cons_pri);
	  $filas_cons_pri=pg_numrows($cons_pri);
	  $prioridad="";
	  for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	 	$prioridad=$prioridad.trim($reg_pri['prioridad']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['pais_priori']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['fecha_priori']).'; ';
     	     $reg_pri = pg_fetch_array($cons_pri);
          }
	  $archivo = $archivo."@COL_01= (30)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$prioridad."\n"."\n";  

  	  // Clasificacion Internacional
	  $clasi="";
	  $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	// Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

 	  //Inventores
	  $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
	   $reg_inv = pg_fetch_array($cons_inv);
	   $filas_cons_inv=pg_numrows($cons_inv);
  	   $archivo = $archivo."@COL_01= (72)"."\n"."\n";  
	   $inventores="";
	   for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
	      $inventores=$inventores.trim($reg_inv['nombre_inv'])."; ";
  	     $reg_inv = pg_fetch_array($cons_inv);
           }
           $archivo = $archivo."@COL_02= ".$inventores."\n"."\n";
      
	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";

	  //Resumen
	  $res_dist=pg_exec("SELECT * FROM stppatte WHERE nro_derecho = '$nderec'");
	  $regdis = pg_fetch_array($res_dist);
	  $archivo = $archivo."@COL_01= (57)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".trim($regdis['resumen'])."\n"."\n";
		   	   
     $reg = pg_fetch_array($resul);
   }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'SOLDBIN'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


  //Solicitadas de INTRODUCCION D
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'D'
	ORDER BY b.solicitud");
	
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	    $mensaje=$mensaje."No Existen Solicitadas de introduccion"; }
	else {
   $reg = pg_fetch_array($resul); 
	$archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	$archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	$archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."@TITUL00=SOLICITADAS DE INTRODUCCION"."\n"."\n";
	$archivo = $archivo."@TEXTO00="."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";

   for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";

	  //Prioridad
	  $cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
	  $reg_pri = pg_fetch_array($cons_pri);
	  $filas_cons_pri=pg_numrows($cons_pri);
	  $prioridad="";
	  for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	 	$prioridad=$prioridad.trim($reg_pri['prioridad']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['pais_priori']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['fecha_priori']).'; ';
     	     $reg_pri = pg_fetch_array($cons_pri);
          }
	  $archivo = $archivo."@COL_01= (30)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$prioridad."\n"."\n";  

  	  // Clasificacion Internacional
	  $clasi="";
	  $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	// Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

 	  //Inventores
	  $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
	   $reg_inv = pg_fetch_array($cons_inv);
	   $filas_cons_inv=pg_numrows($cons_inv);
  	   $archivo = $archivo."@COL_01= (72)"."\n"."\n";  
	   $inventores="";
	   for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
	      $inventores=$inventores.trim($reg_inv['nombre_inv'])."; ";
  	     $reg_inv = pg_fetch_array($cons_inv);
           }
           $archivo = $archivo."@COL_02= ".$inventores."\n"."\n";
      
	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";

	  //Resumen
	  $res_dist=pg_exec("SELECT * FROM stppatte WHERE nro_derecho = '$nderec'");
	  $regdis = pg_fetch_array($res_dist);
	  $archivo = $archivo."@COL_01= (57)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".trim($regdis['resumen'])."\n"."\n";
		   	   
     $reg = pg_fetch_array($resul);
   }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'SOLITDC'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


  //Solicitadas de VARIEDADES VEGETALES V
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'V'
	ORDER BY b.solicitud");
	
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	    $mensaje=$mensaje."No Existen Solicitadas de Variedades Vegetales"; }
	else {
   $reg = pg_fetch_array($resul); 
	$archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	$archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	$archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";
	$archivo = $archivo."@TITUL00=SOLICITADAS DE VARIEDADES VEGETALES"."\n"."\n";
	$archivo = $archivo."@TEXTO00="."\n"."\n";
	$archivo = $archivo."***TRIM***"."\n"."\n";

   for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";

	  //Prioridad
	  $cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
	  $reg_pri = pg_fetch_array($cons_pri);
	  $filas_cons_pri=pg_numrows($cons_pri);
	  $prioridad="";
	  for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	 	$prioridad=$prioridad.trim($reg_pri['prioridad']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['pais_priori']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['fecha_priori']).'; ';
     	     $reg_pri = pg_fetch_array($cons_pri);
          }
	  $archivo = $archivo."@COL_01= (30)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$prioridad."\n"."\n";  

  	  // Clasificacion Internacional
	  $clasi="";
	  $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	// Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

 	  //Inventores
	  $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
	   $reg_inv = pg_fetch_array($cons_inv);
	   $filas_cons_inv=pg_numrows($cons_inv);
  	   $archivo = $archivo."@COL_01= (72)"."\n"."\n";  
	   $inventores="";
	   for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
	      $inventores=$inventores.trim($reg_inv['nombre_inv'])."; ";
  	     $reg_inv = pg_fetch_array($cons_inv);
           }
           $archivo = $archivo."@COL_02= ".$inventores."\n"."\n";
      
	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";

	  //Resumen
	  $res_dist=pg_exec("SELECT * FROM stppatte WHERE nro_derecho = '$nderec'");
	  $regdis = pg_fetch_array($res_dist);
	  $archivo = $archivo."@COL_01= (57)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".trim($regdis['resumen'])."\n"."\n";
		   	   
     $reg = pg_fetch_array($resul);
   }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'SOLVV'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


   //Solicitadas de Diseño Industrial tipo G
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'G'
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	    $mensaje=$mensaje."No Existen Solicitadas de Diseño Industrial"; }
   else {
    $reg = pg_fetch_array($resul); 
	 
	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=PATENTES DE DISEÑOS INDUSTRIALES SOLICITADOS"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";

	  //Prioridad
	  $cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
	  $reg_pri = pg_fetch_array($cons_pri);
	  $filas_cons_pri=pg_numrows($cons_pri);
	  $prioridad="";
	  for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	 	$prioridad=$prioridad.trim($reg_pri['prioridad']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['pais_priori']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['fecha_priori']).'; ';
     	     $reg_pri = pg_fetch_array($cons_pri);
          }
	  $archivo = $archivo."@COL_01= (30)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$prioridad."\n"."\n";

  	  // Clasificacion locarno
  	  $locarn="";
	  $cons_clasl=pg_exec("SELECT * FROM stplocad WHERE nro_derecho = '$nderec'");
	  $reg_clasl = pg_fetch_array($cons_clasl);
	  $filas_cons_clasl=pg_numrows($cons_clasl);
          for($cont_loc=0;$cont_loc<$filas_cons_clasl;$cont_loc++) { 
	      $locarn=$locarn.trim($reg_clasl['clasi_locarno']).'; ';
	      $reg_clasl = pg_fetch_array($cons_clasl);
         }
          $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$locarn."\n"."\n";

	  // Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}
	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

 	  //Inventores
           $inventores="";
	  $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
	   $reg_inv = pg_fetch_array($cons_inv);
	   $filas_cons_inv=pg_numrows($cons_inv);
  	   $archivo = $archivo."@COL_01= (72)"."\n"."\n";  
	   $inventores="";
	   for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
	      $inventores=$inventores.trim($reg_inv['nombre_inv'])."; ";
  	     $reg_inv = pg_fetch_array($cons_inv);
           }
	   $archivo = $archivo."@COL_01= (72)"."\n"."\n";
           $archivo = $archivo."@COL_02= ".$inventores."\n"."\n";

	  // Tramitante o Agente 
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";

     $reg = pg_fetch_array($resul);
   }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'SDI'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

   //Solicitadas de Modelo de Utilidad tipo F
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'F'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	    $mensaje=$mensaje."No Existen Solicitadas de Modelo de Utilidad"; }
   else {
    $reg = pg_fetch_array($resul);
        
	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=PATENTES DE MODELOS DE UTILIDAD SOLICITADOS"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";

	  //Prioridad
	  $cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
	  $reg_pri = pg_fetch_array($cons_pri);
	  $filas_cons_pri=pg_numrows($cons_pri);
	  $prioridad="";
	  for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	 	$prioridad=$prioridad.trim($reg_pri['prioridad']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['pais_priori']).', ';
	 	$prioridad=$prioridad.trim($reg_pri['fecha_priori']).'; ';
     	     $reg_pri = pg_fetch_array($cons_pri);
          }
	  $archivo = $archivo."@COL_01= (30)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$prioridad."\n"."\n";

  	  // Clasificacion Internacional
	  $clasi="";
	  $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	  // Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}
	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

 	  //Inventores
           $inventores="";
	  $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
	   $reg_inv = pg_fetch_array($cons_inv);
	   $filas_cons_inv=pg_numrows($cons_inv);
  	   $archivo = $archivo."@COL_01= (72)"."\n"."\n";  
	   $inventores="";
	   for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
	      $inventores=$inventores.trim($reg_inv['nombre_inv'])."; ";
  	     $reg_inv = pg_fetch_array($cons_inv);
           }
	  $archivo = $archivo."@COL_01= (72)"."\n"."\n";
          $archivo = $archivo."@COL_02= ".$inventores."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";

	  //Resumen
	  $res_dist=pg_exec("SELECT * FROM stppatte WHERE nro_derecho = '$nderec'");
	  $regdis = pg_fetch_array($res_dist);
	  $archivo = $archivo."@COL_01= (57)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".trim($regdis['resumen'])."\n"."\n";

     $reg = pg_fetch_array($resul);
	}

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'SMU'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

//Archivos de Txt para ventura de las Patentes concedidas     
if ($vtip==2101) {
   //Concedidas de Invencion tipo A
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic,b.fecha_publi, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'A'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
       $mensaje=$mensaje."No Existen Concedidas de Invencion"; }
   else {
       $reg = pg_fetch_array($resul);
     
 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=CONCEDIDAS DE INVENCION"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (45)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_publi']."\n"."\n";

	  // Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

  	  // Clasificacion Internacional
	  $clasi="";
          $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";
   	   
     $reg = pg_fetch_array($resul);
    }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'CINV'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

 //Concedidas de MEJORA C
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic,b.fecha_publi, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'C'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
       $mensaje=$mensaje."No Existen Concedidas de mejora"; }
   else {
       $reg = pg_fetch_array($resul);
     
 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=CONCEDIDAS DE MEJORAS"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (45)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_publi']."\n"."\n";

	  // Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

  	  // Clasificacion Internacional
	  $clasi="";
          $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";
   	   
     $reg = pg_fetch_array($resul);
    }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'CMEJ'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

 //Concedidas de MODELO INDUSTRIAL E
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic,b.fecha_publi, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'E'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
       $mensaje=$mensaje."No Existen Concedidas de Modelo Industrial"; }
   else {
       $reg = pg_fetch_array($resul);
     
 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=CONCEDIDAS DE MODELO INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (45)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_publi']."\n"."\n";

	  // Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

  	  // Clasificacion Internacional
	  $clasi="";
          $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";
   	   
     $reg = pg_fetch_array($resul);
    }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'CMOID'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


 //Concedidas de DIBUJO INDUSTRIAL B
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic,b.fecha_publi, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'B'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
       $mensaje=$mensaje."No Existen Concedidas de Dibujo Industrial"; }
   else {
       $reg = pg_fetch_array($resul);
     
 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=CONCEDIDAS DE DIBUJO INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (45)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_publi']."\n"."\n";

	  // Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

  	  // Clasificacion Internacional
	  $clasi="";
          $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";
   	   
     $reg = pg_fetch_array($resul);
    }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'CDBIN'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

 //Concedidas de INTRODUCCION D
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic,b.fecha_publi, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'D'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
       $mensaje=$mensaje."No Existen Concedidas de Introduccion"; }
   else {
       $reg = pg_fetch_array($resul);
     
 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=CONCEDIDAS DE INTRODUCCION"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (45)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_publi']."\n"."\n";

	  // Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

  	  // Clasificacion Internacional
	  $clasi="";
          $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";
   	   
     $reg = pg_fetch_array($resul);
    }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'CITDC'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


 //Concedidas de VARIEDADES VEGETALES V
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic,b.fecha_publi, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'V'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
       $mensaje=$mensaje."No Existen Concedidas de variedades vegetales"; }
   else {
       $reg = pg_fetch_array($resul);
     
 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=CONCEDIDAS DE VARIEDADES VEGETALES"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (45)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_publi']."\n"."\n";

	  // Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}

	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

  	  // Clasificacion Internacional
	  $clasi="";
          $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";
   	   
     $reg = pg_fetch_array($resul);
    }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'CVV'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


//Concedidas de Diseño Industrial tipo G
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic,b.fecha_publi, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'G'
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	    $mensaje=$mensaje."No Existen Concedidas de Diseño Industrial"; }
   else {
    $reg = pg_fetch_array($resul);
     
 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=CONCEDIDAS DE DISEÑO INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (45)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_publi']."\n"."\n";

	  // Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}
	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	   $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

  	  // Clasificacion locarno
	  $locarn="";
	  $cons_clasl=pg_exec("SELECT * FROM stplocad WHERE nro_derecho = '$nderec'");
	  $reg_clasl = pg_fetch_array($cons_clasl);
	  $filas_cons_clasl=pg_numrows($cons_clasl);
          for($cont_loc=0;$cont_loc<$filas_cons_clasl;$cont_loc++) { 
	      $locarn=$locarn.trim($reg_clasl['clasi_locarno']).'; ';
	      $reg_clasl = pg_fetch_array($cons_clasl);
          }
          $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$locarn."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";
   	   
     $reg = pg_fetch_array($resul);
   }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'CDI'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//Concedidas de Modelo de Utilidad tipo F
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic,b.fecha_publi, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'F'
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	    $mensaje=$mensaje."No Existen Concedidas de Modelos de Utilidad"; }
   else {
   $reg = pg_fetch_array($resul);
     
 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=CONCEDIDAS DE MODELOS DE UTILIDAD"."\n"."\n";
	 $archivo = $archivo."@TEXTO00="."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $titulo=$reg['nombre'];
	  $agente = $reg['tramitante'];
	  $solicitud= substr($reg['solicitud'],-11,4).substr($reg['solicitud'],-6,6);
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01= (21)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_01= (22)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_solic']."\n"."\n";
	  $archivo = $archivo."@COL_01= (11)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$vbol."-".$solicitud."\n"."\n";
	  $archivo = $archivo."@COL_01= (45)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$reg['fecha_publi']."\n"."\n";

	  // Titulares
 	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
                $pais_nombre=pais($res['nacionalidad']);
 		if ($cont1=='0'){
	      	    $titular= $titular.trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }
	      	else { $titular= $titular."/ ".trim(sprintf($regt['nombre'])).", ".trim($res['domicilio']).", ".$pais_nombre; }                
	      	$regt = pg_fetch_array($res_titular);
	}
	  $archivo = $archivo."@COL_01= (73)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	  $archivo = $archivo."@COL_01= (74)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$tram."\n"."\n";

	  $clasi="";
  	  // Clasificacion Internacional
	  $clasi="";
	  $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
	  $regclasf = pg_fetch_array($cons_clas);
          $filas_clasif=pg_numrows($cons_clas); 
	  for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	     $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($cons_clas);
	  }
	  $archivo = $archivo."@COL_01= (51)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$clasi."\n"."\n";

	  // Nombre o titulo de la patente
	  $archivo = $archivo."@COL_01= (54)"."\n"."\n";
	  $archivo = $archivo."@COL_02= ".$titulo."\n"."\n";
   	   
     $reg = pg_fetch_array($resul);
   }

 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'CMU'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

// archivos para generar OPOSICIONES
if ($vtip==2009) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");
 
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Oposiciones "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PATENTES CON OPOSICIONES"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	 // Titulares
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

	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'OPO'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

// Archivos para generar Devueltas
// archivos para generar DEVUELTAS POR EXAMEN DE FONDO
if ($vtip==2103) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	$mensaje=$mensaje."No existen Devueltas por Examen de Fondo "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PATENTE DEVUELTAS DE FONDO"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
     	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DFD'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

// archivos para generar DEVUELTAS POR EXAMEN DE FORMA INVENCION
if ($vtip==2200) {
   // DEVUELTAS EXAMEN DE FORMA INVENCION
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'A'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	$mensaje=$mensaje."No existen Devueltas por Examen de Forma Invencion "; }
   else {
    
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PATENTE DEVUELTAS DE FORMA INVENCION"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
 	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";

     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DFMIN'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

  // DEVUELTAS EXAMEN DE FORMA MEJORA C
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'C'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	$mensaje=$mensaje."No existen Devueltas por Examen de Forma Mejora "; }
   else {
    
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PATENTE DEVUELTAS DE FORMA MEJORA"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
 	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";

     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DFMMEJ'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

  // DEVUELTAS EXAMEN DE FORMA MODELO INDUSTRIAL E
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'E'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	$mensaje=$mensaje."No existen Devueltas por Examen de Forma Modelo Industrial "; }
   else {
    
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PATENTE DEVUELTAS DE FORMA DE MODELO INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
 	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";

     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DFMMID'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


  // DEVUELTAS EXAMEN DE FORMA DIBUJO INDUSTRIAL
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'B'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	$mensaje=$mensaje."No existen Devueltas por Examen de Forma Dibujo Industrial "; }
   else {
    
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PATENTE DEVUELTAS DE FORMA DE DIBUJO INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
 	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";

     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DFMDBIN'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

  // DEVUELTAS EXAMEN DE FORMA INDTRODUCCION D
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'D'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	$mensaje=$mensaje."No existen Devueltas por Examen de Forma de Introduccion "; }
   else {
    
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PATENTE DEVUELTAS DE FORMA DE INTRODUCCION"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
 	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";

     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DFMITDC'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

  // DEVUELTAS EXAMEN DE FORMA VARIEDADES VEGETALES V
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'V'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	$mensaje=$mensaje."No existen Devueltas por Examen de Forma de Variedades Vegetales "; }
   else {
    
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PATENTE DEVUELTAS DE FORMA INVENCION"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
 	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";

     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DFMVV'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

// DEVUELTAS EXAMEN DE FORMA DISEÑOS INDUSTRIALES
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'G'
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Devueltas por Examen de Forma Diseños Industriales "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PATENTE DEVUELTAS DE FORMA DISEÑOS INDUSTRIALES"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
 	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";

     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DFMDI'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

// DEVUELTAS EXAMEN DE FORMA MODELOS DE UTILIDAD
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'F'
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Devueltas por Examen de Forma Modelos de Utilidad "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PATENTE DEVUELTAS DE FORMA MODELOS DE UTILIDAD"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
 	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";

     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DFMMU'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

// PRIORIDAD EXTINGUIDA
if ($vtip==2025) {
// prioridad extinguidad por modelos de utilidad
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'F'
	ORDER BY b.solicitud");
 
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes con Prioridad Extinguida de modelos de utilidad "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PRIORIDADES EXTINGUIDAS"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PRIOMU'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

// prioridad extinguidad por mejora C
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'C'
	ORDER BY b.solicitud");
 
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes con Prioridad Extinguida de mejoras "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PRIORIDADES EXTINGUIDAS DE MEJORAS"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PRIOMEJ'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

// prioridad extinguidad por MODELO INDUSTRIAL
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'E'
	ORDER BY b.solicitud");
 
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes con Prioridad Extinguida de modelos de utilidad "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PRIORIDADES EXTINGUIDAS DE MODELO INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PRIOMID'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

// prioridad extinguidad por DIBUJOS INDUSTRIAL
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'B'
	ORDER BY b.solicitud");
 
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes con Prioridad Extinguida de dibujos industriales "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PRIORIDADES EXTINGUIDAS DE DIBUJO INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PRIODBIN'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

// prioridad extinguidad por INTRODUCCION
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'D'
	ORDER BY b.solicitud");
 
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes con Prioridad Extinguida de Introduccion "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PRIORIDADES EXTINGUIDAS DE INTRODUCCION"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PRIOITDC'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

// prioridad extinguidad por VARIEDADES VEGETALES
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'V'
	ORDER BY b.solicitud");
 
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes con Prioridad Extinguida de Variedades Vegetales "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PRIORIDADES EXTINGUIDAS DE VARIEDADES VEGETALES"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PRIOVV'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

//prioridad extinguidad por invenciones 
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'A'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes con Prioridad Extinguida de invenciones "; }
	else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PRIORIDADES EXTINGUIDAS"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PRIOINV'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

// prioridad extinguidad por diseño industrial
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = 'G'
	ORDER BY b.solicitud");
   
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes con Prioridad Extinguida de diseño industrial "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PRIORIDADES EXTINGUIDAS"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
     }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PRIODI'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

}





// PRIORIDAD EXTINGUIDA PUBLICADA EN PRENSA EXTEMPORANEA
if ($vtip==2023) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");
 
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes con Prioridad Extinguida en Prensa Extemporanea "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PRIORIDADES EXTINGUIDAS PUBLICADAS EN PRENSA EXTEMPORANEA"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PRIO_PREN_EXT'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}


// PRIORIDAD EXTINGUIDA PUBLICADA EN PRENSA DEFECTUOSA
if ($vtip==2024) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");
 
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes con Prioridad Extinguida en Prensa Defectuosa "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PRIORIDADES EXTINGUIDAS PUBLICADAS EN PRENSA DEFECTUOSA"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PRIO_PREN_DEF'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}



//PERIMIDAS X NO PUBLICACION EN PRENSA 
if ($vtip==2030) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");
 
   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	   $mensaje=$mensaje."No existen Patentes Perimidas x no Publicacion en Prensa "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=PERIMIDAS POR NO PUBLICACION EN PRENSA"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind); 
	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'PERIMID_PREN'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}



// DENEGADAS
if ($vtip==2119) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Patentes Denegadas"; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=SOLICITUDES DE PATENTES DENEGADAS"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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

	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
 	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DNEG'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

// DESISTIDAS
if ($vtip==2910) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Patentes Desistidas "; }
	else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=DESISTIDAS"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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

	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DESIS'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

// DESISTIDAS X REGISTRO
if ($vtip==2915) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);  
   if ($cantreg==0) {
	$mensaje=$mensaje."No existen Patentes Desistidas por Registro "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=DESISTIDAS POR REGISTRO"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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

	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
   	   $ind=1;
           $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
 	   $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
	 }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'DESISXR'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}

// ABANDONADAS
if ($vtip==2090) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Patentes Abandonadas "; }
	else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=ABANDONADAS POR NO SOLICITAR EXAMEN TECNICO"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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
	  $archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
  	  $ind=1;
          $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
    }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'ABAN'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
  }  

// ABANDONADAS X NO PAGO
if ($vtip==2750) {
   $resul=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.solicitud between '$vsola' and '$vsolb'
	AND c.estatus='$vtip'
    	AND c.boletin = '$vbol'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."No existen Patentes Abandonadas por no Pago "; }
   else {
    $reg = pg_fetch_array($resul); 

 	 $archivo = "@ENCAB00=REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=196 y 147"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."***TRIM***"."\n";
	 $archivo = $archivo."@TITUL00=".$vbol."\n"."\n"; 
	 $archivo = $archivo."@TEXTO00=ABANDONADAS POR NO PAGO"."\n"."\n";
	 $archivo = $archivo."@TIT_01=<B>SOLICITUD<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_02=<B>TITULO DE LA PATENTE<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_03=<B>TITULAR(ES)<D>"."\n"."\n";
	 $archivo = $archivo."@TIT_04=<B>TRAMITANTE<D>"."\n"."\n";
 	 $archivo = $archivo."@SEPARADOR="."\n"."\n";

    for ($cont=0;$cont<$cantreg;$cont++) {
	  $nderec=$reg['nro_derecho'];
	  $nagen=$reg['agente'];
	  $varsol=$reg['solicitud'];
	  $agente = $reg['tramitante'];
	  $archivo = $archivo."@SEPARADOR="."\n"."\n";
	  $archivo = $archivo."@COL_01=".$reg['solicitud']."\n"."\n";
	  $archivo = $archivo."@COL_02=".trim($reg['nombre'])."\n"."\n";

	  // Titulares
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

	$archivo = $archivo."@COL_03= ".$titular."\n"."\n";

	  // Tramitante o Agente
  	  $ind=1;
          $tram = agente_tram($reg['agente'],$reg['tramitante'],$ind);
	  $archivo = $archivo."@COL_04= ".$tram."\n"."\n";
     $reg = pg_fetch_array($resul);
   }

	$archivo = $archivo."@TEXTO00=Total de Solicitudes :".$cantreg."\n"."\n";
 	$archivo = $archivo."@SEPARADOR="."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Publiquese,"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC= "."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=MARGARITA VILATIMO"."\n"."\n";
 	$archivo = $archivo."@IDENTIFIC=Registrador"."\n"."\n";
	$archivo = $archivo."***EOR***"."\n"."\n";
	$via= "../../";
	$via1= "bolepat/";
	$fecha= strftime("%d-%m-%y,%T");
	$open = fopen($via.$via1.$vbol.'ABANXPG'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
  }  

  // Mensaje final
  $smarty ->assign('titulo','Sistema de Patentes'); 
  $smarty ->assign('subtitulo','Generación de Archivos del Boletin para Ventura'); 
  $smarty->assign('login',$usuario);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  mensajebrowse("Proceso Terminado...!!",'p_gentxt.php');
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
   $smarty ->assign('titulo','Sistema de Patentes'); 
   $smarty ->assign('subtitulo','Generaci&oacute;n de Archivos del Boletin para Ventura'); 
   $smarty ->assign('lsolicitud','Rango de Solicitudes:'); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('espacios','            '); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('p_gentxt.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
