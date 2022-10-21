<?php
// *************************************************************************************
// Programa: m_rptlisbol.php 
// Realizado por Ing. Karina Perez 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado I Semestre 2009 BD - Relacional   
// Modificado I Semestre 2010 05/05/2010 por Ing. Romulo Mendoza
// Por orden Ministerio colocar Domicilio y Pais en Titular 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Listados de RPI para la Emisi&oacute;n del Bolet&iacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol1h=$_POST["vsol1h"];
$varsol2h=$_POST["vsol2h"];
$fecpub=$_POST["fecpub"];
$boletin=$_POST["boletin"];
$tipo=$_POST["tipo"];
$nconex = $_POST['nconex'];

$varsold=$varsol1.'-'.$varsol2;
$varsolh=$varsol1h.'-'.$varsol2h;

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("varsold","varsolh","boletin","tipo");
  $valores = array($varsold,$varsolh,$boletin,$tipo); 
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

if ($varsolh <$varsold){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Query para buscar las opciones deseadas
$titulo='';
$titul='';
$fecha_venc = "";

//Conexion
$sql = new mod_db();
$sql->connection($login);

// Armando el query segun las opciones

if ($tipo=='ORDEN DE PUBLICACION') { 

   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1002'
			AND c.tipo = 'M'
			AND b.estatus = '1002'
			ORDER BY b.solicitud");	
	$est_fin= '4';
	$tipo_plazo= 'M';
	$plazo='2';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."ORDEN DE PUBLICACION" ; 
	$titul= $titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 2, Estatus Final 4";
}

if ($tipo=='SOLICITADAS') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1006'
			AND c.tipo = 'M'
			AND b.estatus = '1006'
			ORDER BY b.solicitud");	
	$est_fin= '8';
	$tipo_plazo= 'H';
	$plazo='30';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."SOLICITADAS" ; 
	$titul  = $titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
   $subtit = $subtit."Estatus inicial 6, Estatus Final 8";

}

if ($tipo=='CONCEDIDAS') { 

   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1101'
			AND c.tipo = 'M'
			AND b.estatus = '1101'
			ORDER BY b.solicitud");	
	$est_fin= '400';
	$tipo_plazo= 'H';
	$plazo='30';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."CONCEDIDAS" ;
	$titul  = $titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 101, Estatus Final 400";
}

if ($tipo=='CONCEDIDAS RECLASIF.') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1390'
			AND c.tipo = 'M'
			AND b.estatus = '1390'
			ORDER BY b.solicitud");	  
	$est_fin= '400';
	$tipo_plazo= 'H';
	$plazo='30';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."CONCEDIDAS RECLASIF." ;
	$titul = $titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 390, Estatus Final 400";
}

if ($tipo=='DEVUELTAS FORMA') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1200'
			AND c.tipo = 'M'
			AND b.estatus = '1200'
			ORDER BY b.solicitud");	
	$est_fin= '113';
	$tipo_plazo= 'H';
	$plazo='60';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."DEVUELTAS FORMA" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 200, Estatus Final 113";
}

if ($tipo=='DEVUELTAS FONDO') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1116'
			AND c.tipo = 'M'
			AND b.estatus = '1116'
			ORDER BY b.solicitud");	 
	$est_fin= '118';
	$tipo_plazo= 'H';
	$plazo='30';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."DEVUELTAS FONDO" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 116, Estatus Final 118";
}

if ($tipo=='OBSERVADAS') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1003'
			AND c.tipo = 'M'
			AND b.estatus = '1003'
			ORDER BY b.solicitud");	  
	$est_fin= '120';
	$tipo_plazo= 'H';
	$plazo='30';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."OBSERVADAS" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 3, Estatus Final 120";
}

if ($tipo=='PRIORIDAD EXTINGUIDA') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1025'
			AND c.tipo = 'M'
			AND b.estatus = '1025'
			ORDER BY b.solicitud");	
	$est_fin= '600';
	$tipo_plazo= 'H';
	$plazo='15';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."PRIORIDAD EXTINGUIDA" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 25, Estatus Final 600";
}

if ($tipo=='PRIORIDAD EXT.PRENSA EXTEMPORANEA') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1023'
			AND c.tipo = 'M'
			AND b.estatus = '1023'
			ORDER BY b.solicitud");	
	$est_fin= '601';
	$tipo_plazo= 'H';
	$plazo='15';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."PRIORIDAD EXTINGUIDA PUBLICADA EN PRENSA EXTEMPORANEA" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 23, Estatus Final 601";
}

if ($tipo=='PRIORIDAD EXT.PRENSA DEFECTUOSA') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1024'
			AND c.tipo = 'M'
			AND b.estatus = '1024'
			ORDER BY b.solicitud");	
	$est_fin= '602';
	$tipo_plazo= 'H';
	$plazo='15';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."PRIORIDAD EXTINGUIDA PUBLICADA EN PRENSA DEFECTUOSA" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 24, Estatus Final 602";
}

if ($tipo=='PERIMIDAS X NO PUBLICACION EN PRENSA') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1030'
			AND c.tipo = 'M'
			AND b.estatus = '1030'
			ORDER BY b.solicitud");	
	$est_fin= '651';
	$tipo_plazo= 'H';
	$plazo='';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."PERIMIDAS X NO PUBLICACION EN PRENSA" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 30, Estatus Final 651";
}

if ($tipo=='CADUCAS') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1750'
			AND c.tipo = 'M'
			AND b.estatus = '1750'
			ORDER BY b.solicitud");	
	$est_fin= '751';
	$tipo_plazo= 'H';
	$plazo='15';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo); 
   $titulo = $titulo."CADUCAS" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 750, Estatus Final 751";
}

if ($tipo=='DESISTIDAS') { 
  $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1910'
			AND c.tipo = 'M'
			AND b.estatus = '1910'
			ORDER BY b.solicitud");	
	$est_fin= '911';
	$tipo_plazo= 'H';
	$plazo='';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."DESISTIDAS" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 910, Estatus Final 911";
}

if ($tipo=='OBSERVADAS DESISTIDAS DE OFICIO') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1914'
			AND c.tipo = 'M'
			AND b.estatus = '1914'
			ORDER BY b.solicitud");	  
	$est_fin= '915';
	$tipo_plazo= 'H';
	$plazo='15';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."OBSERVADAS DESISTIDAS POR LEY" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 914, Estatus Final 915";
}

if ($tipo=='DESISTIMIENTO DE OBSERVACION') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1125'
			AND c.tipo = 'M'
			AND b.estatus = '1125'
			ORDER BY b.solicitud");	
	$est_fin= '8';
	$tipo_plazo= 'H';
	$plazo='';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."DESISTIMIENTO DE OBSERVACION" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 125, Estatus Final 8";
}

if ($tipo=='DESISTIM. OBSERVACION MEJOR DERECHO') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1130'
			AND c.tipo = 'M'
			AND b.estatus = '1130'
			ORDER BY b.solicitud");	  
	$est_fin= '8';
	$tipo_plazo= 'H';
	$plazo='';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."DESISTIMIENTO DE OBSERVACION MEJOR DERECHO" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 130, Estatus Final 8";
}

if ($tipo=='NEGADAS') { 
  $resultado=pg_exec("SELECT a.clase,b.nro_derecho,b.solicitud,b.nombre, d.articulo, d.literal,c.fecha_carga,c.hora_carga
		FROM  stmmarce a, stzderec b, stztmpbo c, stmliaor d
		WHERE (c.solicitud between '$varsold' and '$varsolh')
		AND c.boletin = $boletin
		AND (b.registro ='' OR b.registro is NULL)
		AND c.nro_derecho = b.nro_derecho 
		AND b.nro_derecho = a.nro_derecho
     	AND b.nro_derecho = d.nro_derecho
		AND c.estatus = '1102'
		AND c.tipo = 'M'
		AND b.estatus = '1102'
		ORDER BY  d.articulo,d.literal,b.solicitud ");
	   $titulo = $titulo."Listado de Negadas";
	   $subtit = $subtit."Estatus inicial 102, Estatus Final 500";
}

if ($tipo=='CAMBIO DE DOMICILIO') { 
  $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,d.*,c.fecha_carga,c.hora_carga
			FROM  stzderec b, stztmpbo c, stzantma d
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND c.nro_derecho = d.nro_derecho 
			AND c.estatus = '1208'
			AND d.nanota = c.nanota
			AND c.tipo = 'M'
			AND b.estatus = '1208'
			ORDER BY b.solicitud");	  
	$titulo = $titulo."Listado de Registro de Cambio de Domicilio";
}

if ($tipo=='CESIONES') { 
 $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,d.*,c.fecha_carga,c.hora_carga
			FROM  stzderec b, stztmpbo c, stzantma d
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND c.nro_derecho = d.nro_derecho 
			AND c.estatus = '1205'
			AND d.nanota = c.nanota
			AND c.tipo = 'M'
			AND b.estatus = '1205'
			ORDER BY b.solicitud");	  
	$titulo = $titulo."Listado de Registro de Cesiones de Marcas";
}

if ($tipo=='FUSIONES') { 
 $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,d.*,c.fecha_carga,c.hora_carga
			FROM  stzderec b, stztmpbo c, stzantma d
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND c.nro_derecho = d.nro_derecho 
			AND c.estatus = '1206'
			AND d.nanota = c.nanota
			AND c.tipo = 'M'
			AND b.estatus = '1206'
			ORDER BY b.solicitud");	  
	$titulo = $titulo."Listado de Registro de Fusiones de Marcas";
}

if ($tipo=='LICENCIAS') { 
 $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,d.*,c.fecha_carga,c.hora_carga
			FROM  stzderec b, stztmpbo c, stzantma d
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND c.nro_derecho = d.nro_derecho 
			AND c.estatus = '1207'
			AND d.nanota = c.nanota
			AND c.tipo = 'M'
			AND b.estatus = '1207'
			ORDER BY b.solicitud");	    
	$titulo = $titulo."Listado de Registro de Licencias de Uso";
}

if ($tipo=='RENOVACIONES') { 
  $resultado=pg_exec("SELECT a.clase,b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,d.*,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c, stzantma d
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND c.nro_derecho = b.nro_derecho 
			AND c.nro_derecho = a.nro_derecho 
			AND c.estatus = '1204'
			AND d.nanota = c.nanota
			AND c.tipo = 'M'
			AND b.estatus = '1204'
			ORDER BY b.solicitud");	  
  $titulo = $titulo."Listado de Registro de Renovaciones de Marcas";
}

if ($tipo=='CAMBIO DE NOMBRE') { 
 $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic,d.*,c.fecha_carga,c.hora_carga
			FROM  stzderec b, stztmpbo c, stzantma d
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND c.nro_derecho = d.nro_derecho 
			AND c.estatus = '1209'
			AND d.nanota = c.nanota
			AND c.tipo = 'M'
			AND b.estatus = '1209'
			ORDER BY b.solicitud");	    
	$titulo = $titulo."Listado de Registro de Cambio de Nombre ";
}

if ($tipo=='CADUCAS POR NO RENOVACION') { 
   $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,a.clase, b.registro, e.nombre as titular, b.agente, trim(tramitante) as tramitante, d.nacionalidad, d.domicilio,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d, stzsolic e
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1996'
			AND c.tipo = 'M'
			AND b.estatus = '1996'
			AND a.nro_derecho = d.nro_derecho
			AND e.titular = d.titular
			ORDER BY b.registro");	
	$est_fin= '997';
	$tipo_plazo= 'H';
	$plazo='';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."CADUCAS POR NO RENOVACION" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='REGISTROS NO RENOVADOS') { 
  $resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, a.clase, b.registro, e.nombre as titular, b.agente, trim(tramitante) as tramitante, d.nacionalidad, d.domicilio,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d, stzsolic e
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1913'
			AND c.tipo = 'M'
			AND b.estatus = '1913'
			AND a.nro_derecho = d.nro_derecho
			AND e.titular = d.titular
			ORDER BY b.registro");	
	$est_fin= '916';
	$tipo_plazo= 'H';
	$plazo='';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."REGISTRO NO RENOVADO" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
	$subtit = $subtit."Estatus inicial 913, Estatus Final 916";
}

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total="Total de Solicitudes: ".$filas_resultado;
$filas_found=pg_numrows($resultado); 

$titul1= $boletin;

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= Utf8_decode("Listado para el Boletín");
$titulo= $titulo.' Boletin: '.$titul1;
$smarty->assign('n_conex',$nconex); 

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

if ($tipo=='CONCEDIDAS' or $tipo=='SOLICITADAS' or $tipo=='CONCEDIDAS RECLASIF.' or $tipo=='DEVUELTAS FORMA' or $tipo=='DEVUELTAS FONDO'
   or $tipo=='OBSERVADAS' or $tipo=='PRIORIDAD EXTINGUIDA' or $tipo=='PRIORIDAD EXT.PRENSA EXTEMPORANEA'  or $tipo=='PRIORIDAD EXT.PRENSA DEFECTUOSA'   or $tipo=='PERIMIDAS X NO PUBLICACION EN PRENSA' or $tipo=='CADUCAS' or $tipo=='DESISTIDAS' 
   or $tipo=='DESISTIMIENTO DE OBSERVACION' or $tipo=='DESISTIM. OBSERVACION MEJOR DERECHO' or $tipo=='ORDEN DE PUBLICACION' or $tipo=='OBSERVADAS DESISTIDAS DE OFICIO') {

//initialize the table 
$pdf->Table_Init(5);
$columns=5;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Sol.");
		$header_type[$i]['WIDTH'] = 19;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 76;
		//$i=3;
		//$header_type[$i] = $table_default_header_type;
		//$header_type[$i]['TEXT'] = utf8_decode("Status Inicial");
		//$header_type[$i]['WIDTH'] = 16;
		//$i=4;
		//$header_type[$i] = $table_default_header_type;
		//$header_type[$i]['TEXT'] = utf8_decode("Status Final");
		//$header_type[$i]['WIDTH'] = 16;
		//$i=5;
		//$header_type[$i] = $table_default_header_type;
		//$header_type[$i]['TEXT'] = utf8_decode("Fecha Venc");
		//$header_type[$i]['WIDTH'] = 20;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 60;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Generado el");
		$header_type[$i]['WIDTH'] = 20;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filas_resultado;$cont++) { 
   $vder = $registro['nro_derecho'];
   //Agregado 05/05/2010 por RM por Orden del Ministro 
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad,stzottid.domicilio
       		FROM stzottid, stzsolic, stmmarce 
       		WHERE stzottid.nro_derecho='$vder'
              AND stmmarce.nro_derecho=stzottid.nro_derecho
              AND stzsolic.titular=stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 

	$data = Array();
	//Arreglando el formato de la fecha
		
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['fecha_solic'];
	$data[2]['TEXT'] = utf8_decode(trim($registro['nombre']));
	//$data[3]['TEXT'] = $registro['estatus']-1000;
	//$data[4]['TEXT'] = $est_fin;
	//$data[5]['TEXT'] = $fecha_venc;
	$data[3]['TEXT'] = $titular;
	$data[4]['TEXT'] = $registro['fecha_carga']." ".$registro['hora_carga'];
	
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);

  }

}

// En el caso de ser Negadas
if ($tipo=='NEGADAS') {
$pdf->Table_Init(7);
$columns=7;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 10;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 75;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Art");
		$header_type[$i]['WIDTH'] = 8;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Lit");
		$header_type[$i]['WIDTH'] = 8;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 55;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Generado el");
		$header_type[$i]['WIDTH'] = 20;

			  
$pdf->Set_Header_Type($header_type);

//set data style

$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostrando los datos en la Tabla
 for($cont=0;$cont<$filas_resultado;$cont++) { 
   $vder = $registro['nro_derecho'];
   //Agregado 05/05/2010 por RM por Orden del Ministro 
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad,stzottid.domicilio
       		FROM stzottid, stzsolic, stmmarce 
       		WHERE stzottid.nro_derecho='$vder'
              AND stmmarce.nro_derecho=stzottid.nro_derecho
              AND stzsolic.titular=stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
 
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['clase'];
	$data[2]['TEXT'] = trim(($registro['nombre']));
	$data[3]['TEXT'] = $registro['articulo'];
	$data[4]['TEXT'] = $registro['literal'];
	$data[5]['TEXT'] = $titular;
	$data[6]['TEXT'] = $registro['fecha_carga']." ".$registro['hora_carga'];

	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
}

// En el caso de ser Cambio de domicilio
if ($tipo=='CAMBIO DE DOMICILIO') {
$pdf->Table_Init(7);
$columns=7;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 20;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 12;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Marca");
		$header_type[$i]['WIDTH'] = 72;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Pais");
		$header_type[$i]['WIDTH'] = 12;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante");
		$header_type[$i]['WIDTH'] = 25;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Generado el");
		$header_type[$i]['WIDTH'] = 20;
	  
	  
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);
//draw the first header
$pdf->Draw_Header();

//Mostrando los datos en la Tabla
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['registro'];
	$data[1]['TEXT'] = $registro['tipo'];
	$data[2]['TEXT'] = trim(($registro['nombre']));
	$data[3]['TEXT'] = trim(($registro['domicilio']));
	$data[4]['TEXT'] = $registro['pais'];
	$data[5]['TEXT'] = trim(($registro['tramitante']));
	$data[6]['TEXT'] = $registro['fecha_carga']." ".$registro['hora_carga'];

	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
}

// En el caso de ser Cesiones
if ($tipo=='CESIONES') {
$pdf->Table_Init(7);
$columns=7;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 8;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Marca");
		$header_type[$i]['WIDTH'] = 72;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cesionario");
		$header_type[$i]['WIDTH'] = 40;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 30;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante");
		$header_type[$i]['WIDTH'] = 25;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Generado el");
		$header_type[$i]['WIDTH'] = 20;

$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);
//draw the first header
$pdf->Draw_Header();

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = trim(($registro['registro']));
	$data[1]['TEXT'] = $registro['tipo'];
	$data[2]['TEXT'] = trim(($registro['nombre']));
	$data[3]['TEXT'] = trim(($registro['nom_tit_2']));
	$data[4]['TEXT'] = trim(($registro['domicilio']));
	$data[5]['TEXT'] = trim(($registro['tramitante']));
	$data[6]['TEXT'] = $registro['fecha_carga']." ".$registro['hora_carga'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
}

// En el caso de ser Fusiones
if ($tipo=='FUSIONES') {
$pdf->Table_Init(9);
$columns=9;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 8;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Marca");
		$header_type[$i]['WIDTH'] = 40;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Entre");
		$header_type[$i]['WIDTH'] = 40;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("A  Nuevo");
		$header_type[$i]['WIDTH'] = 30;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 20;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Pais");
		$header_type[$i]['WIDTH'] = 10;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante");
		$header_type[$i]['WIDTH'] = 25;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Generado el");
		$header_type[$i]['WIDTH'] = 20;
	  
$pdf->Set_Header_Type($header_type);
//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);
//draw the first header
$pdf->Draw_Header();

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = trim(($registro['registro']));
	$data[1]['TEXT'] = $registro['tipo'];
	$data[2]['TEXT'] = trim(($registro['nombre']));
	$data[3]['TEXT'] = trim(($registro['inf_adicional']));
	$data[4]['TEXT'] = trim(($registro['nom_tit_2']));
	$data[5]['TEXT'] = trim(($registro['domicilio']));
	$data[6]['TEXT'] = ($registro['pais']);
	$data[7]['TEXT'] = trim(($registro['tramitante']));
	$data[8]['TEXT'] = $registro['fecha_carga']." ".$registro['hora_carga'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
}

// En el caso de ser Licencias de uso
if ($tipo=='LICENCIAS') {
$pdf->Table_Init(8);
$columns=8;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 8;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Marca");
		$header_type[$i]['WIDTH'] = 65;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Otorgado");
		$header_type[$i]['WIDTH'] = 40;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 30;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Pais");
		$header_type[$i]['WIDTH'] = 10;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante");
		$header_type[$i]['WIDTH'] = 25;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Generado el");
		$header_type[$i]['WIDTH'] = 20;
	  
$pdf->Set_Header_Type($header_type);
//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);
//draw the first header
$pdf->Draw_Header();

//Mostrando datos en la Tabla
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();

	$data[0]['TEXT'] = trim(($registro['registro']));
	$data[1]['TEXT'] = $registro['tipo'];
	$data[2]['TEXT'] = trim(($registro['nombre']));
	$data[3]['TEXT'] = trim(($registro['nom_tit_2']));
	$data[4]['TEXT'] = trim(($registro['domicilio']));
	$data[5]['TEXT'] = trim(($registro['pais']));
	$data[6]['TEXT'] = trim(($registro['tramitante']));
	$data[7]['TEXT'] = $registro['fecha_carga']." ".$registro['hora_carga'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
}

// En el caso de ser Renovaciones de Marcas
if ($tipo=='RENOVACIONES') {
$pdf->Table_Init(7);
$columns=7;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 8;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 15;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Marca");
		$header_type[$i]['WIDTH'] = 80;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Vencimiento");
		$header_type[$i]['WIDTH'] = 20;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante");
		$header_type[$i]['WIDTH'] = 40;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Generado el");
		$header_type[$i]['WIDTH'] = 20;
		
$pdf->Set_Header_Type($header_type);
//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);
//draw the first header
$pdf->Draw_Header();

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();

	$data[0]['TEXT'] = trim(($registro['registro']));
	$data[1]['TEXT'] = $registro['tipo'];
	$data[2]['TEXT'] = trim(($registro['clase']));
	$data[3]['TEXT'] = trim(($registro['nombre']));
	$data[4]['TEXT'] = $registro['vencimiento'];
	$data[5]['TEXT'] = trim(($registro['tramitante']));
	$data[6]['TEXT'] = $registro['fecha_carga']." ".$registro['hora_carga'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
}

// En el caso de ser Renovaciones de Marcas
if ($tipo=='CAMBIO DE NOMBRE') {
$pdf->Table_Init(6);
$columns=6;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 8;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Marca");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("A Nuevo");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante");
		$header_type[$i]['WIDTH'] = 45;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Generado el");
		$header_type[$i]['WIDTH'] = 20;

$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);
//draw the first header
$pdf->Draw_Header();

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();

	$data[0]['TEXT'] = trim(($registro['registro']));
	$data[1]['TEXT'] = $registro['tipo'];
	$data[2]['TEXT'] = trim(($registro['nombre']));
	$data[3]['TEXT'] = trim(($registro['nom_tit_2']));
	$data[4]['TEXT'] = trim(($registro['tramitante']));
	$data[5]['TEXT'] = $registro['fecha_carga']." ".$registro['hora_carga'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
}

// En el caso de ser caducas por no renovacion y registros no renovados
if ($tipo=='CADUCAS POR NO RENOVACION' or $tipo=='REGISTROS NO RENOVADOS') {
$pdf->Table_Init(6);
$columns=6;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 16;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 10;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Marca");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante");
		$header_type[$i]['WIDTH'] = 40;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 60;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Generado el");
		$header_type[$i]['WIDTH'] = 20;
			  
$pdf->Set_Header_Type($header_type);

//set data style

$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostrando los datos en la Tabla
 for($cont=0;$cont<$filas_resultado;$cont++) {
   $pais_nombre=pais($registro['nacionalidad']);
   $nbtitular = trim($registro['titular']).'.'.trim($registro['domicilio']).','.trim($pais_nombre);  
	$data = Array();
	$data[0]['TEXT'] = $registro['registro'];
	$data[1]['TEXT'] = $registro['clase'];
	$data[2]['TEXT'] = utf8_decode(trim($registro['nombre']));
   $tram = agente_tram($registro['agente'],$registro['tramitante'],($ind='1'));
	$data[3]['TEXT'] = utf8_decode(trim($tram));
	//$data[4]['TEXT'] = utf8_decode(trim($registro['titular']));
	$data[4]['TEXT'] = utf8_decode($nbtitular);
	$data[5]['TEXT'] = $registro['fecha_carga']." ".$registro['hora_carga'];

	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
}


$pdf->Draw_Table_Border();


//Desconexion a la base de datos
ob_end_clean(); 
$sql->disconnect();
$pdf->Output();
?>
