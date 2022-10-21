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
   $vsola=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vsolb=sprintf("%04d-%06d",$vsol3,$vsol4);
  // $vsola=($vsol1.$vsol2);
  // $vsolb=($vsol3.$vsol4);
   $resul=false;
 

   if ($vopc==2) {
      $vsola=$_GET['v1'];
      $vsolb=$_GET['v2'];
      $vbol =$_GET['v3']; 
 }
      
   $sql->connection();  

  if ($vopc==3 || $vopc==2) {
            
      if ($vsola=='' || $vsolb=='' || $vbol=='') {
         $smarty->display('encabezado1.tpl');
         mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','p_genrehab.php');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
	 
      if ($vsola > $vsolb) {
         $smarty->display('encabezado1.tpl');
         mensaje('ERROR AL INTENTAR PROCESAR - RANGO INCORRECTO','p_genrehab.php');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$smarty->assign('n_conex',$nconex);

//Archivos de Txt para  Patentes de rehabiliatación
 $resul=pg_exec("SELECT stzderec.solicitud, stzderec.nro_derecho, stzderec.nombre, stzderec.tramitante, stzderec.agente 
					FROM  stzderec, stztmpbo
					WHERE (stztmpbo.solicitud >= '$vsola' AND stztmpbo.solicitud <= '$vsolb')
					AND stztmpbo.boletin = '$vbol'
  					AND stztmpbo.nro_derecho = stzderec.nro_derecho 
					AND stztmpbo.tipo = 'P'
					AND stzderec.estatus = '2555'
					AND stzderec.nro_derecho in (select nro_derecho FROM stzevtrd WHERE evento = 2799) 
					AND stzderec.nro_derecho not in (select nro_derecho FROM stzevtrd WHERE evento = 2238)	ORDER BY stzderec.solicitud");	

        $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
	    $smarty->display('encabezado1.tpl');
	    mensajenew('No existen Patentes de Rehabilitaci&oacute;n a Publicar...!!!','p_genrehab.php','N');
	    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
	 else {
  	 $archivo = "@ENCAB00=REPUBLICA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA LAS INDUSTRIAS LIGERAS Y EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL"."\n"."\n";
	 $archivo = $archivo."@TEXTO01=Caracas,"."\n"."\n";
	 $archivo = $archivo."@TEXO02=197 y 149"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."***TRIM***"."\n"."\n";
	 $archivo = $archivo."@TITUL00=REHABILITACION DE PATENTES".$vbol."\n"."\n";
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
	$open = fopen($via.$via1.'pat_rehabilit'.'_'.$fecha.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
        
  // Mensaje final
  $smarty ->assign('titulo','Sistema de Patentes'); 
  $smarty ->assign('subtitulo','Generaci&oacute;n de Rehabilitaci&oacute;n de Patentes para Ventura'); 
  $smarty->assign('login',$usuario);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  mensajebrowse("Proceso Terminado...!!",'p_genrehab.php');
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
   $smarty ->assign('subtitulo','Generaci&oacute;n de Rehabilitaci&oacute;n de Patentes'); 
   $smarty ->assign('lsolicitud','Rango de Solicitudes:'); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('espacios','            '); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('p_genrehab.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
