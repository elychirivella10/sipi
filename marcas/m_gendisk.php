<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

include ("../z_includes.php");

//Comienzo del Programa por los encabezados del reporte
ob_start();

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Generacion de Archivos TXT');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Captura Variables leidas en formulario inicial  
$tipo=$_POST["tipo"];
$boletin=$_POST["boletin"];
$fecpub=$_POST["fecpub"];
$nconex = $_POST['nconex'];


if ($tipo=='SOLICITADAS') { 
   if ($fecpub=='' ) {
     $smarty->display('encabezado1.tpl');
     mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

	pg_exec("CREATE TEMPORARY TABLE concedtemp (tipo_marca char(1), solicitud char(11),nombre_marca char(59), clase integer,nombre_titur char(60), domicilio char(60), blanco char(1), blanco1 char(12), agente integer)");

	$resultado=pg_exec("INSERT INTO concedtemp SELECT stzderec.tipo_derecho, stzderec.solicitud, substr(stzderec.nombre,1,59), stmmarce.clase, substr(stzsolic.nombre,1,60), substr(stzottid.domicilio,1,60), ' ','            ', stzderec.agente
			   FROM stzderec,stmmarce, stzottid, stzsolic
			   WHERE stzderec.nro_derecho=stmmarce.nro_derecho
				AND stzderec.nro_derecho=stzottid.nro_derecho
				AND stmmarce.nro_derecho=stzottid.nro_derecho
				AND stzsolic.titular = stzottid.titular
				AND stzderec.fecha_publi = '$fecpub'
				AND stzderec.estatus = '1008'
			   ORDER BY tipo_derecho, clase, solicitud");	 

}

if ($tipo=='CONCEDIDAS') { 

 if ($tipo=='' || $boletin=='') {
   $smarty->display('encabezado1.tpl');
   mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

	pg_exec("CREATE TEMPORARY TABLE concedtemp (solicitud char(11), blanco char(3), clase char(2), blanco1 char(2), nombre_marca char(59), blanco2 char(2), nombre_titur char(60), blanco3 char(2), tramitante char(40), titular integer, tipo_marca char(1),agente integer)");

	$resultado=pg_exec("INSERT INTO concedtemp SELECT stzderec.solicitud, ' ', stmmarce.clase, '    ', substr(stzderec.nombre,1,59), '  ', substr(stzsolic.nombre,1,60), '   ', substr(stzderec.tramitante,1,40),stzottid.titular,stzderec.tipo_derecho, stzderec.agente
			   FROM stzderec,stmmarce, stzottid, stzsolic, stzevtrd
			   WHERE stzderec.nro_derecho=stmmarce.nro_derecho
				 and stzderec.nro_derecho=stzevtrd.nro_derecho
				 and stzderec.nro_derecho=stzottid.nro_derecho
				 and stmmarce.nro_derecho=stzottid.nro_derecho
				 and stzsolic.titular = stzottid.titular
				 and stzevtrd.evento = '1122' 
				 and stzevtrd.estat_ant = '1101'
				 and stzevtrd.documento = '$boletin'
			   ORDER BY tipo_derecho, solicitud, titular");	  
}

if ($tipo=='CONCEDIDAS RECLASIFICADAS') { 
 if ($tipo=='' || $boletin=='') {
   $smarty->display('encabezado1.tpl');
   mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

	pg_exec("CREATE TEMPORARY TABLE concedtemp (solicitud char(11), blanco char(3), clase char(2), blanco1 char(2), nombre_marca char(59), blanco2 char(2), nombre_titur char(60), blanco3 char(2), tramitante char(40), titular integer, tipo_marca char(1),agente integer)");

	$resultado=pg_exec("INSERT INTO concedtemp SELECT stzderec.solicitud, ' ', stmmarce.clase, '    ', substr(stzderec.nombre,1,59), '  ', substr(stzsolic.nombre,1,60), '   ', substr(stzderec.tramitante,1,40),stzottid.titular,stzderec.tipo_derecho,stzderec.agente
			   FROM stzderec,stmmarce, stzottid, stzsolic, stzevtrd
			   WHERE stzderec.nro_derecho=stmmarce.nro_derecho
				 and stzderec.nro_derecho=stzevtrd.nro_derecho
				 and stzderec.nro_derecho=stzottid.nro_derecho
				 and stmmarce.nro_derecho=stzottid.nro_derecho
				 and stzsolic.titular = stzottid.titular
				 and stzevtrd.evento = '1122' 
				 and stzevtrd.estat_ant = '1390' 
				 and stzevtrd.documento = '$boletin'
			   ORDER BY tipo_derecho, solicitud, titular");	  
}

//********************************************************************************************
if ($tipo=='SOLICITADAS') { 
$archivo='';
// Proceso marcas comerciales
$resul=pg_exec("SELECT *   FROM concedtemp
			   WHERE tipo_marca = 'M' 
			   ORDER BY clase, solicitud");	

$filas_res=pg_numrows($resul);
$reg = pg_fetch_array($resul);  
if ($filas_res=='0') {
}
else {

//Datos del Listado 

         $clase=0;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
         if ($clase!=$reg['clase']) {
		$archivo = $archivo."\n";
	 	$archivo = $archivo."SOBRE LA CLASE:       ".$reg['clase']."\n";
		$archivo = $archivo."\n";
	 	$clase=$reg['clase'];
	 	
         }


         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['nombre_marca']."\n";
         $archivo = $archivo.$reg['blanco1'].$reg['nombre_titur']."\n";
         $archivo = $archivo.$reg['blanco1'].$reg['domicilio']."\n";	  	   
         
         $reg = pg_fetch_array($resul); 
         }
}

       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'marcas.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

$archivo='';
// Proceso nombres comerciales
$resul=pg_exec("SELECT *   FROM concedtemp
			   WHERE tipo_marca = 'N' 
			   ORDER BY clase, solicitud");	

$filas_res=pg_numrows($resul);
$reg = pg_fetch_array($resul);  
if ($filas_res=='0') {

}
else {

//Datos del Listado 

         $clase=0;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
         if ($clase!=$reg['clase']) {
		$archivo = $archivo."\n";
	 	$archivo = $archivo."SOBRE LA CLASE:       ".$reg['clase']."\n";
		$archivo = $archivo."\n";
	 	$clase=$reg['clase'];
	 	
         }


         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['nombre_marca']."\n";
         $archivo = $archivo.$reg['blanco1'].$reg['nombre_titur']."\n";
         $archivo = $archivo.$reg['blanco1'].$reg['domicilio']."\n";	  	   
         
         $reg = pg_fetch_array($resul); 
         }
}

       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'nombres.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

$archivo='';
// Proceso servicios comerciales
$resul=pg_exec("SELECT *   FROM concedtemp
			   WHERE tipo_marca = 'S' 
			   ORDER BY clase, solicitud");	

$filas_res=pg_numrows($resul);
$reg = pg_fetch_array($resul);  
if ($filas_res=='0') {
  // $smarty->display('encabezado1.tpl');
  // mensaje('No Existen Archivos que generar','m_pgendisk.php');
  // $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
else {

//Datos del Listado 

         $clase=0;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
         if ($clase!=$reg['clase']) {
		$archivo = $archivo."\n";
	 	$archivo = $archivo."SOBRE LA CLASE:       ".$reg['clase']."\n";
		$archivo = $archivo."\n";
	 	$clase=$reg['clase'];
	 	
         }


         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['nombre_marca']."\n";
         $archivo = $archivo.$reg['blanco1'].$reg['nombre_titur']."\n";
         $archivo = $archivo.$reg['blanco1'].$reg['domicilio']."\n";	  	   
         
         $reg = pg_fetch_array($resul); 
         }
}

       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'servicio.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

$archivo='';
// Proceso lemas comerciales
$resul=pg_exec("SELECT *   FROM concedtemp
			   WHERE tipo_marca = 'L' 
			   ORDER BY clase, solicitud");	

$filas_res=pg_numrows($resul);
$reg = pg_fetch_array($resul);  
if ($filas_res=='0') {
  // $smarty->display('encabezado1.tpl');
  // mensaje('No Existen Archivos que generar','m_pgendisk.php');
  // $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
else {

//Datos del Listado 

         $clase=0;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
         if ($clase!=$reg['clase']) {
		$archivo = $archivo."\n";
	 	$archivo = $archivo."SOBRE LA CLASE:       ".$reg['clase']."\n";
		$archivo = $archivo."\n";
	 	$clase=$reg['clase'];
	 	
         }


         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['nombre_marca']."\n";
         $archivo = $archivo.$reg['blanco1'].$reg['nombre_titur']."\n";
         $archivo = $archivo.$reg['blanco1'].$reg['domicilio']."\n";	  	   
         
         $reg = pg_fetch_array($resul); 
         }
}

       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'lemas.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

$archivo='';
// Proceso Agentes
//$resul=pg_exec("SELECT *   FROM concedtemp,
//			   WHERE tipo_marca in ('M','L','N','S') 
//			   ORDER BY agente, solicitud");	

$resul=pg_exec("SELECT stzderec.solicitud,substr(stzderec.nombre,1,40), stzderec.agente, stzagenr.nombre 
			FROM stzderec, stzagenr
			WHERE stzderec.agente = stzagenr.agente AND
			      stzderec.fecha_publi = '$fecpub' AND
			      stzderec.estatus = '1008'
			ORDER BY stzderec.agente, stzderec.solicitud");	


$filas_res=pg_numrows($resul);
$reg = pg_fetch_array($resul);  
if ($filas_res=='0') {
  // $smarty->display('encabezado1.tpl');
  // mensaje('No Existen Archivos que generar','m_pgendisk.php');
  // $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
else {

//Datos del Listado 

         $agente=0;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
         if ($agente!=$reg['agente']) {
		$archivo = $archivo."\n";
	 	$archivo = $archivo.$reg['agente'].'       '.$reg['nombre']."\n";
		$archivo = $archivo."\n";
	 	$agente=$reg['agente'];
	 	
         }

         $archivo = $archivo.$reg['solicitud'].'    '.$reg[substr]."\n";
         
         $reg = pg_fetch_array($resul); 
         }
}

       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'agentes.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}

}



//********************************************************************************************
if ($tipo=='CONCEDIDAS') { 
$archivo='';
// Proceso marcas comerciales
//Query Concedidas 
$resul=pg_exec("SELECT DISTINCT ON(solicitud) solicitud,blanco,clase,blanco1, nombre_marca, blanco2, nombre_titur, blanco3,tramitante, agente
			   FROM concedtemp
			   WHERE tipo_marca = 'M'");	

$filas_res=pg_numrows($resul);
$reg = pg_fetch_array($resul);  
if ($filas_res=='0') {
  // $smarty->display('encabezado1.tpl');
  // mensaje('No Existen Archivos que generar','m_pgendisk.php');
  // $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
else {

//Datos del Listado 
         $cant_enc=66;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
         $nagen=$reg['agente'];
         if ($cant_enc == 66){
	  $archivo = $archivo."Solicitud   Clase Nombre de la Marca                                            Titular                                                      Tramitante"."\n";
	  $archivo = $archivo."======================================================================================"."\n";
          
          $cant_enc =2;
         }

	//Busqueda de agente o tramitante
         $ind=1;
         $tramitante = agente_tram($nagen,$reg['tramitante'],$ind);

// Busqueda del titular

$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg_tit = pg_fetch_array($resultado);

   if ($filas_found > 1) {
       $ind=0;
    for($cont_tit=0;$cont_tit<$filas_found;$cont_tit++)   { 
     //   $resul2=pg_exec("SELECT titular,nombre,pais_resid FROM stztitur WHERE titular='$reg_tit[titular]'");    
       // $reg2 = pg_fetch_array($resul2);  
        $titular = substr($reg_tit['nombre'],1,60);
        if ($ind == 0) {
           $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['clase'].$reg['blanco1'].$reg ['nombre_marca'].$reg['blanco2'].$titular.$reg['blanco3'].$tramitante;
           $archivo = $archivo."\n";
           $ind=1;
	   $cant_enc = $cant_enc + 1;
        } 
        else {
	  $archivo = $archivo.'           '.$reg['blanco'].'  '.$reg['blanco1'].'                                                           '.$reg['blanco2'].$titular.$reg['blanco3'].'                                        ';
          $archivo = $archivo."\n";	  
          $cant_enc = $cant_enc + 1;
       }

       $reg_tit = pg_fetch_array($resultado);
    }
   }

         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['clase'].$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$reg['nombre_titur'].$reg['blanco3'].$tramitante;
	 $archivo = $archivo."\n";	   	   
         $cant_enc = $cant_enc + 1;
         $reg = pg_fetch_array($resul); 
         }
}
       	$archivo = $archivo.'                                                Total de Solicitudes : '.$filas_res."\n";
       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'marcconc.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


// Proceso nombre comerciales 
//Query Concedidas 
$archivo='';
$resul_n=pg_exec("SELECT DISTINCT ON(solicitud) solicitud,blanco,clase,blanco1, nombre_marca, blanco2, nombre_titur, blanco3, tramitante, agente
			   FROM concedtemp
			   WHERE tipo_marca = 'N'");	

$filas_res=pg_numrows($resul_n);
$reg = pg_fetch_array($resul_n);  
if ($filas_res=='0') {
  // $smarty->display('encabezado1.tpl');
  // mensaje('No Existen Archivos que generar','m_pgendisk.php');
  // $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
else {

//Datos del Listado 
         $cant_enc=66;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
	 $nagen=$reg['agente'];
         if ($cant_enc == 66) {
	  $archivo = $archivo."Solicitud   Clase Nombre de la Marca                                            Titular                                                      Tramitante"."\n";
	  $archivo = $archivo."======================================================================================"."\n";
          $cant_enc =2;
         }
	//Busqueda de agente o tramitante
	 $ind=1;
         $tramitante = agente_tram($nagen,$reg['tramitante'],$ind);

// Busqueda del titular

$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg_tit = pg_fetch_array($resultado);

   if ($filas_found > 1) {
       $ind=0;
    for($cont_tit=0;$cont_tit<$filas_found;$cont_tit++)   { 
        $titular = substr($reg_tit['nombre'],1,60);
        if ($ind == 0) {
           $archivo = $archivo.$reg['solicitud'].$reg['blanco'].'NC'.$reg['blanco1'].$reg  ['nombre_marca'].$reg['blanco2'].$titular.$reg['blanco3'].$tramitante;
           $archivo = $archivo."\n";
           $ind=1;
	   $cant_enc = $cant_enc + 1;
        } 
        else {
	  $archivo = $archivo.'           '.$reg['blanco'].'  '.$reg['blanco1'].'                                                           '.$reg['blanco2'].$titular.$reg['blanco3'].'                                        ';
          $archivo = $archivo."\n";	
	  $cant_enc = $cant_enc + 1;  
       }

       $reg_tit = pg_fetch_array($resultado);
    }
   }

         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].'NC'.$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$reg['nombre_titur'].$reg['blanco3'].$tramitante;
	 $archivo = $archivo."\n";	  
	 $cant_enc = $cant_enc + 1; 	   
         $reg = pg_fetch_array($resul_n); 
         }
}
       	$archivo = $archivo.'                                                Total de Solicitudes : '.$filas_res."\n";
       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'nombconc.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


// Proceso marcas de servicios
//Query Concedidas 
$archivo='';
$resul_s=pg_exec("SELECT DISTINCT ON(solicitud) solicitud,blanco,clase,blanco1, nombre_marca, blanco2, nombre_titur, blanco3, tramitante, agente
			   FROM concedtemp
			   WHERE tipo_marca = 'S'");	

$filas_res=pg_numrows($resul_s);
$reg = pg_fetch_array($resul_s);  
if ($filas_res=='0') {
   //$smarty->display('encabezado1.tpl');
   //mensaje('No Existen Archivos que generar','m_pgendisk.php');
   //$smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
else {

//Datos del Listado 
         $cant_enc=66;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
	 $nagen=$reg['agente'];
         if ($cant_enc == 66) {
	  $archivo = $archivo."Solicitud   Clase Nombre de la Marca                                            Titular                                                      Tramitante"."\n";
	  $archivo = $archivo."======================================================================================"."\n";
          $cant_enc = 2;
         }
//Busqueda de agente o tramitante
	 $ind=1;
         $tramitante = agente_tram($nagen,$reg['tramitante'],$ind);

// Busqueda del titular
$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg_tit = pg_fetch_array($resultado);
   if ($filas_found > 1) {
       $ind=0;
    for($cont_tit=0;$cont_tit<$filas_found;$cont_tit++)   { 
        $titular = substr($reg_tit['nombre'],1,60);
        if ($ind == 0) {
           $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['clase'].$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$titular.$reg['blanco3'].$tramitante;
           $archivo = $archivo."\n";
           $ind=1;
	   $cant_enc = $cant_enc + 1;
        } 
        else {
	  $archivo = $archivo.'           '.$reg['blanco'].'  '.$reg['blanco1'].'                                                           '.$reg['blanco2'].$titular.$reg['blanco3'].'                                        ';
          $archivo = $archivo."\n";	  
          $cant_enc = $cant_enc + 1;
       }

       $reg_tit = pg_fetch_array($resultado);
    }
   }

         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['clase'].$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$reg['nombre_titur'].$reg['blanco3'].$tramitante;
	 $archivo = $archivo."\n";	   	   
	 $cant_enc = $cant_enc + 1;
         $reg = pg_fetch_array($resul_s); 
         }
}
       	$archivo = $archivo.'                                                Total de Solicitudes : '.$filas_res."\n";
       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'servconc.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


// Proceso lema de servicio
//Query Concedidas 
$archivo='';
$resul_l=pg_exec("SELECT DISTINCT ON(solicitud) solicitud,blanco,clase,blanco1, nombre_marca, blanco2, nombre_titur, blanco3, tramitante, agente
			   FROM concedtemp
			   WHERE tipo_marca = 'L'");	

$filas_res_l=pg_numrows($resul_l);
$reg = pg_fetch_array($resul_l);  
if ($filas_res_l=='0') {
  // $smarty->display('encabezado1.tpl');
  // mensaje('No Existen Archivos que generar','m_pgendisk.php');
  // $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
 }
else {

//Datos del Listado 
         $cant_enc=66;
         for ($cont=0;$cont<$filas_res_l;$cont++) {
	 $varsol=$reg['solicitud'];
	 $nagen=$reg['agente'];
         if ($cant_enc == 66) {
	  $archivo = $archivo."Solicitud   Clase Nombre de la Marca                                            Titular                                                      Tramitante"."\n";
	  $archivo = $archivo."======================================================================================"."\n";
          $cant_enc = 2;
         }
//Busqueda de agente o tramitante
	 $ind=1;
         $tramitante = agente_tram($nagen,$reg['tramitante'],$ind);

// Busqueda del titular
$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg_tit = pg_fetch_array($resultado);

   if ($filas_found > 1) {
       $ind=0;
    for($cont_tit=0;$cont_tit<$filas_found;$cont_tit++)   { 
        $titular = substr($reg_tit['nombre'],1,60);
        if ($ind == 0) {
           $archivo = $archivo.$reg['solicitud'].$reg['blanco'].'LC'.$reg['blanco1'].$reg  ['nombre_marca'].$reg['blanco2'].$titular.$reg['blanco3'].$tramitante;
           $archivo = $archivo."\n";
	   $cant_enc = $cant_enc + 1;
           $ind=1;
        } 
        else {
	  $archivo = $archivo.'           '.$reg['blanco'].'  '.$reg['blanco1'].'                                                           '.$reg['blanco2'].$titular.$reg['blanco3'].'                                        ';
          $archivo = $archivo."\n";	  
  	  $cant_enc = $cant_enc + 1;
       }

       $reg_tit = pg_fetch_array($resultado);
    }
   }

         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].'LC'.$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$reg['nombre_titur'].$reg['blanco3'].$tramitante;
	 $archivo = $archivo."\n";	   	   
	 $cant_enc = $cant_enc + 1;
         $reg = pg_fetch_array($resul_l); 
         }
}
       	$archivo = $archivo.'                                                Total de Solicitudes : '.$filas_res_l."\n";
       if ($filas_res_l !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'lemaconc.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}


//********************************************************************************************
if ($tipo=='CONCEDIDAS RECLASIFICADAS') { 
$archivo='';
// Proceso marcas comerciales reclasificadas
//Query Concedidas reclasificadas
$resul=pg_exec("SELECT DISTINCT ON(solicitud) solicitud,blanco,clase,blanco1, nombre_marca, blanco2, nombre_titur, blanco3, tramitante, agente
			   FROM concedtemp
			   WHERE tipo_marca = 'M'");	

$filas_res=pg_numrows($resul);
$reg = pg_fetch_array($resul);  
if ($filas_res=='0') {
  // $smarty->display('encabezado1.tpl');
  // mensaje('No Existen Archivos que generar','m_pgendisk.php');
  // $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
else {

//Datos del Listado 
         $cant_enc=66;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
	 $nagen=$reg['agente'];
         if ($cant_enc == 66){
	  $archivo = $archivo."Solicitud   Clase Nombre de la Marca                                            Titular                                                      Tramitante"."\n";
	  $archivo = $archivo."======================================================================================"."\n";
          
          $cant_enc =2;
         }
//Busqueda de agente o tramitante
	 $ind=1;
         $tramitante = agente_tram($nagen,$reg['tramitante'],$ind);

// Busqueda del titular
$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg_tit = pg_fetch_array($resultado);

   if ($filas_found > 1) {
       $ind=0;
    for($cont_tit=0;$cont_tit<$filas_found;$cont_tit++)   { 
        $titular = substr($reg_tit['nombre'],1,60);
        if ($ind == 0) {
           $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['clase'].$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$titular.$reg['blanco3'].$tramitante;
           $archivo = $archivo."\n";
           $ind=1;
	   $cant_enc = $cant_enc + 1;
        } 
        else {
	  $archivo = $archivo.'           '.$reg['blanco'].'  '.$reg['blanco1'].'                                                           '.$reg['blanco2'].$titular.$reg['blanco3'].'                                        ';
          $archivo = $archivo."\n";	  
          $cant_enc = $cant_enc + 1;
       }

       $reg_tit = pg_fetch_array($resultado);
    }
   }

         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['clase'].$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$reg['nombre_titur'].$reg['blanco3'].$tramitante;
	 $archivo = $archivo."\n";	   	   
         $cant_enc = $cant_enc + 1;
         $reg = pg_fetch_array($resul); 
         }
}
       	$archivo = $archivo.'                                                Total de Solicitudes : '.$filas_res."\n";
       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'marcrecl.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


// Proceso nombre comerciales reclasificadas
//Query Concedidas reclasificadas
$archivo='';
$resul_n=pg_exec("SELECT DISTINCT ON(solicitud) solicitud,blanco,clase,blanco1, nombre_marca, blanco2, nombre_titur, blanco3, tramitante, agente
			   FROM concedtemp
			   WHERE tipo_marca = 'N'");	

$filas_res=pg_numrows($resul_n);
$reg = pg_fetch_array($resul_n);  
if ($filas_res=='0') {
  // $smarty->display('encabezado1.tpl');
  // mensaje('No Existen Archivos que generar','m_pgendisk.php');
  // $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
else {

//Datos del Listado 
         $cant_enc=66;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
	 $nagen=$reg['agente'];
         if ($cant_enc == 66) {
	  $archivo = $archivo."Solicitud   Clase Nombre de la Marca                                            Titular                                                      Tramitante"."\n";
	  $archivo = $archivo."======================================================================================"."\n";
          $cant_enc =2;
         }
//Busqueda de agente o tramitante
	 $ind=1;
         $tramitante = agente_tram($nagen,$reg['tramitante'],$ind);

// Busqueda del titular
$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg_tit = pg_fetch_array($resultado);
   if ($filas_found > 1) {
       $ind=0;
    for($cont_tit=0;$cont_tit<$filas_found;$cont_tit++)   { 
        $titular = substr($reg_tit['nombre'],1,60);
        if ($ind == 0) {
           $archivo = $archivo.$reg['solicitud'].$reg['blanco'].'NC'.$reg['blanco1'].$reg  ['nombre_marca'].$reg['blanco2'].$titular.$reg['blanco3'].$tramitante;
           $archivo = $archivo."\n";
           $ind=1;
	   $cant_enc = $cant_enc + 1;
        } 
        else {
	  $archivo = $archivo.'           '.$reg['blanco'].'  '.$reg['blanco1'].'                                                           '.$reg['blanco2'].$titular.$reg['blanco3'].'                                        ';
          $archivo = $archivo."\n";	
	  $cant_enc = $cant_enc + 1;  
       }

       $reg_tit = pg_fetch_array($resultado);
    }
   }

         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].'NC'.$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$reg['nombre_titur'].$reg['blanco3'].$tramitante;
	 $archivo = $archivo."\n";	  
	 $cant_enc = $cant_enc + 1; 	   
         $reg = pg_fetch_array($resul_n); 
         }
}
       	$archivo = $archivo.'                                                Total de Solicitudes : '.$filas_res."\n";
       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'nombrecl.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


// Proceso marcas de servicios reclasificadas
//Query Concedidas reclasificadas
$archivo='';
$resul_s=pg_exec("SELECT DISTINCT ON(solicitud) solicitud,blanco,clase,blanco1, nombre_marca, blanco2, nombre_titur, blanco3, tramitante, agente
			   FROM concedtemp
			   WHERE tipo_marca = 'S'");	

$filas_res=pg_numrows($resul_s);
$reg = pg_fetch_array($resul_s);  
if ($filas_res=='0') {
   //$smarty->display('encabezado1.tpl');
   //mensaje('No Existen Archivos que generar','m_pgendisk.php');
   //$smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
else {

//Datos del Listado 
         $cant_enc=66;
         for ($cont=0;$cont<$filas_res;$cont++) {
	 $varsol=$reg['solicitud'];
	 $nagen=$reg['agente'];
         if ($cant_enc == 66) {
	  $archivo = $archivo."Solicitud   Clase Nombre de la Marca                                            Titular                                                      Tramitante"."\n";
	  $archivo = $archivo."======================================================================================"."\n";
          $cant_enc = 2;
         }
//Busqueda de agente o tramitante
	 $ind=1;
         $tramitante = agente_tram($nagen,$reg['tramitante'],$ind);

// Busqueda del titular
$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg_tit = pg_fetch_array($resultado);

   if ($filas_found > 1) {
       $ind=0;
    for($cont_tit=0;$cont_tit<$filas_found;$cont_tit++)   { 
        $titular = substr($reg_tit['nombre'],1,60);
        if ($ind == 0) {
           $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['clase'].$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$titular.$reg['blanco3'].$tramitante;
           $archivo = $archivo."\n";
           $ind=1;
	   $cant_enc = $cant_enc + 1;
        } 
        else {
	  $archivo = $archivo.'           '.$reg['blanco'].'  '.$reg['blanco1'].'                                                           '.$reg['blanco2'].$titular.$reg['blanco3'].'                                        ';
          $archivo = $archivo."\n";	  
          $cant_enc = $cant_enc + 1;
       }

       $reg_tit = pg_fetch_array($resultado);
    }
   }

         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].$reg['clase'].$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$reg['nombre_titur'].$reg['blanco3'].$tramitante;
	 $archivo = $archivo."\n";	   	   
	 $cant_enc = $cant_enc + 1;
         $reg = pg_fetch_array($resul_s); 
         }
}
       	$archivo = $archivo.'                                                Total de Solicitudes : '.$filas_res."\n";
       if ($filas_res !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'servrecl.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}


// Proceso lema de servicio reclasificadas
//Query Concedidas reclasificadas
$archivo='';
$resul_l=pg_exec("SELECT DISTINCT ON(solicitud) solicitud,blanco,clase,blanco1, nombre_marca, blanco2, nombre_titur, blanco3, tramitante, agente
			   FROM concedtemp
			   WHERE tipo_marca = 'L'");	

$filas_res_l=pg_numrows($resul_l);
$reg = pg_fetch_array($resul_l);  
if ($filas_res_l=='0') {
  // $smarty->display('encabezado1.tpl');
  // mensaje('No Existen Archivos que generar','m_pgendisk.php');
  // $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
 }
else {

//Datos del Listado 
         $cant_enc=66;
         for ($cont=0;$cont<$filas_res_l;$cont++) {
	 $varsol=$reg['solicitud'];
	 $nagen=$reg['agente'];
         if ($cant_enc == 66) {
	  $archivo = $archivo."Solicitud   Clase Nombre de la Marca                                            Titular                                                      Tramitante"."\n";
	  $archivo = $archivo."======================================================================================"."\n";
          $cant_enc = 2;
         }
//Busqueda de agente o tramitante
	 $ind=1;
         $tramitante = agente_tram($nagen,$reg['tramitante'],$ind);

// Busqueda del titular
$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg_tit = pg_fetch_array($resultado);

   if ($filas_found > 1) {
       $ind=0;
    for($cont_tit=0;$cont_tit<$filas_found;$cont_tit++)   { 
        $titular = substr($reg_tit['nombre'],1,60);
        if ($ind == 0) {
           $archivo = $archivo.$reg['solicitud'].$reg['blanco'].'LC'.$reg['blanco1'].$reg  ['nombre_marca'].$reg['blanco2'].$titular.$reg['blanco3'].$tramitante;
           $archivo = $archivo."\n";
	   $cant_enc = $cant_enc + 1;
           $ind=1;
        } 
        else {
	  $archivo = $archivo.'           '.$reg['blanco'].'  '.$reg['blanco1'].'                                                           '.$reg['blanco2'].$titular.$reg['blanco3'].'                                        ';
          $archivo = $archivo."\n";	  
  	  $cant_enc = $cant_enc + 1;
       }

       $reg_tit = pg_fetch_array($resultado);
    }
   }

         $archivo = $archivo.$reg['solicitud'].$reg['blanco'].'LC'.$reg['blanco1'].$reg['nombre_marca'].$reg['blanco2'].$reg['nombre_titur'].$reg['blanco3'].$tramitante;
	 $archivo = $archivo."\n";	   	   
	 $cant_enc = $cant_enc + 1;
         $reg = pg_fetch_array($resul_l); 
         }
}
       	$archivo = $archivo.'                                                Total de Solicitudes : '.$filas_res_l."\n";
       if ($filas_res_l !='0') {
	$via1= "documentos/";
	$open = fopen($via1.'lemarecl.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);}
}


$smarty->assign('n_conex',$nconex); 
// Mensaje final
//if ($cont=$filas_res) {
   $smarty->display('encabezado1.tpl');
   mensaje('Proceso Terminado...!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
//}

//Desconexion a la base de datos
  $sql->disconnect(); 
  exit(); 

?>
