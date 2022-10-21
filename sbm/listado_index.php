<?php 
// Programa PHP. Busqueda de Lista de Resultados de Consulta Avanzada
// (Lis_compleja.php por Consulta Avanzada)
// Realizado Por Ing. Romulo Mendoza Julio 2008 

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

include ("lib/template.inc.php");	// taken from PHPLib
include ("inc/constantes.inc");
include ("lis_funcion.php");

//Encabezados de pantalla
$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Reporte de Busqueda Tecnica');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Reporte de de Busqueda Tecnica";

//Conexion con la base de datos SAPI
require ("inc/NormalizaParametros.inc");
$sql = new mod_db();

//Verificando conexion
$sql->connection();

$opcion   = $_GET["opcion"];
$valor1   = $_GET['valor1'];
$criterio = $_GET["criterio"];

switch($opcion) {
 case 1:
   $valor1 = normaliza_texto($valor1);
   $valor1 = quitar_blancos($valor1);
   break;
 case 2:
   $valor1 = normaliza_texto($valor1);
   $valor1 = quitar_blancos($valor1);
   break;
 case 3:
   $valor1 = normaliza_texto($valor1);
   break;
}
$modoconsulta = $_GET["modoconsulta"];

//$valor1 = $_GET['texto'];
//$valor1 = $_GET["nom_emp"];
//$valor1 = $_GET['clasificacion'];

$where = "";
$where = $where." stzderec.nro_derecho=stppatee.nro_derecho";
$where = $where." AND stzderec.nro_derecho=stzottid.nro_derecho";
$where = $where." AND stppatee.nro_derecho=stzottid.nro_derecho";
$where = $where." AND stzsolic.titular = stzottid.titular";
$where = $where." AND stzderec.tipo_mp='P' ";

switch($opcion) {
 case 1: 
   switch($modoconsulta)
   {
     case 1: //BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
         $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
                        FROM stppatee, stzderec, stzottid, stzsolic 
			WHERE $where AND stzderec.nombre LIKE '$valor1' 
			ORDER BY stzderec.solicitud");
         //$cantidad = pg_exec("SELECT * FROM stzderec WHERE nombre like '$valor1' AND tipo_mp='P'");       
	      //$total = pg_numrows($cantidad);
       break;

     case 2: // BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
         $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
                        FROM stppatee, stzderec, stzottid, stzsolic 
			WHERE $where AND stzderec.nombre LIKE '%$valor1%'  
         ORDER BY stzderec.solicitud");
	      //$cantidad = pg_exec("SELECT * FROM stzderec WHERE nombre like '%$valor1%' AND tipo_mp='P'");
	      //$total = pg_numrows($cantidad);
       break;

     case 3: //BÚSQUEDA_NOMBRE_COMIENCE_POR:
         $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
                        FROM stppatee, stzderec, stzottid, stzsolic 
			WHERE $where AND stzderec.nombre LIKE '$valor1%'  
         ORDER BY stzderec.solicitud");
	      //$cantidad = pg_exec("SELECT * FROM stzderec WHERE nombre like '$valor1%' AND tipo_mp='P'");	
	      //$total = pg_numrows($cantidad);
      break;
   }
   break;
 case 2:
   switch($modoconsulta)
   {
     case 1: //BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
        $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic 
			 WHERE $where AND stzsolic.nombre = '$valor1' 
			 ORDER BY stzderec.solicitud");
	     //$cantidad=pg_exec("SELECT stzderec.solicitud,stzottid.titular, stzsolic.nombre as titular, stzderec.nombre     
		  //   FROM stzottid, stzsolic, stzderec 
		  //   WHERE stzsolic.nombre = '$valor1' 
		  //   AND stzderec.nro_derecho=stzottid.nro_derecho
		  //   AND stzderec.tipo_mp='P'
        //   AND stzsolic.titular = stzottid.titular ");
	     //$total=pg_numrows($cantidad);
        break;

     case 2: //BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
        $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic 
			 WHERE $where AND stzsolic.nombre like '%$valor1%' 
			 ORDER BY stzderec.solicitud");
	     //$cantidad=pg_exec("SELECT stzderec.solicitud,stzottid.titular, stzsolic.nombre as titular, stzderec.nombre     
		  //   FROM stzottid, stzsolic, stzderec 
		  //   WHERE stzsolic.nombre like '%$valor1%' 
		  //   AND stzderec.nro_derecho=stzottid.nro_derecho
        //   AND stzsolic.titular = stzottid.titular
		  //   AND stzderec.tipo_mp='P' ");
	     //$total=pg_numrows($cantidad);
       break;

     case 3: //BÚSQUEDA_NOMBRE_COMIENCE_POR:
        $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic 
			 WHERE $where AND stzsolic.nombre like '$valor1%' 
			 ORDER BY stzderec.solicitud");
	     //$cantidad=pg_exec("SELECT stzderec.solicitud,stzottid.titular, stzsolic.nombre as titular, stzderec.nombre     
		  //   FROM stzottid, stzsolic, stzderec 
		  //   WHERE stzsolic.nombre like '$valor1%' 
		  //   AND stzderec.nro_derecho=stzottid.nro_derecho
        //   AND stzsolic.titular = stzottid.titular
		  //   AND stzderec.tipo_mp='P'");
	     //$total=pg_numrows($cantidad);
       break;
   }
   break;
 case 3: 
   switch($modoconsulta)
   {
     case 1: //BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
        $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic, stpclsfd 
			 WHERE $where 
			 AND stzderec.nro_derecho = stpclsfd.nro_derecho
          AND stpclsfd.clasificacion = '$valor1' 
			 ORDER BY stzderec.solicitud");
	    //$cantidad=pg_exec("SELECT *, stzderec.solicitud, stzderec.nombre 
		 //	FROM stpclsfd, stzderec 
		 //	WHERE stpclsfd.clasificacion = '$valor1' 
		 //	AND   stzderec.nro_derecho=stpclsfd.nro_derecho
		 //	AND stzderec.tipo_mp='P'");
	    //$total=pg_numrows($cantidad);
        break;
     case 2: //BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
        $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic, stpclsfd 
			 WHERE $where 
			 AND stzderec.nro_derecho = stpclsfd.nro_derecho
          AND stpclsfd.clasificacion like '%$valor1%' 
			 ORDER BY stzderec.solicitud");
	    //$cantidad=pg_exec("SELECT *, stzderec.solicitud, stzderec.nombre 
		//	FROM stpclsfd, stzderec 
		//	WHERE stpclsfd.clasificacion like '%$valor1%' 
		//	AND stzderec.nro_derecho=stpclsfd.nro_derecho
		//	AND stzderec.tipo_mp='P'");
	    //$total=pg_numrows($cantidad);
        break;

     case 3: //BÚSQUEDA_NOMBRE_COMIENCE_POR:
        $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic, stpclsfd 
			 WHERE $where 
			 AND stzderec.nro_derecho = stpclsfd.nro_derecho
          AND stpclsfd.clasificacion like '$valor1%' 
			 ORDER BY stzderec.solicitud");
	    //$cantidad=pg_exec("SELECT *, stzderec.solicitud, stzderec.nombre 
		//	FROM stpclsfd, stzderec 
		//	WHERE stpclsfd.clasificacion like '$valor1%' 
		//	AND stzderec.nro_derecho=stpclsfd.nro_derecho
		 //       AND stzderec.tipo_mp='P'");
	    //$total=pg_numrows($cantidad);
        break;
   }
   break;
}

$titulo= "Patron de Busqueda o ".$criterio;

// Seleccionar resultado de los diferentes select

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total = "Total: ".$filas_resultado;

//Incio de la Clase de PDF para generar los reportes
//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 22;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 90;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Sol.");
		$header_type[$i]['WIDTH'] = 19;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo ");
		$header_type[$i]['WIDTH'] = 10;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Est. ");
		$header_type[$i]['WIDTH'] = 10;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular ");
		$header_type[$i]['WIDTH'] = 110;

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
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = utf8_decode(trim($registro['nombre']));
	$data[2]['TEXT'] = $registro['fecha_solic'];
	$data[3]['TEXT'] = $registro['tipo_derecho'];
	$data[4]['TEXT'] = $registro['estatus']-2000;
   $data[4]['ALIGN'] = "L";
	$data[5]['TEXT'] = utf8_decode(trim($registro['ntitular'])).", Domicilio: ".utf8_decode(trim($registro['domicilio'])).", Nacionalidad: ".$registro['nacionalidad'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();

?>


