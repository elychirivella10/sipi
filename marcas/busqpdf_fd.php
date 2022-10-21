<?

ob_start();
include ("../setting.inc.php"); 
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");
include ("../z_includes.php");

require ("$include_lib/PDF_tablesbf.php");

//
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$hh=hora();
//Conexion
$sql = new mod_db();
$sql->connection($login);

$fecha=fechahoy();  

$linea="-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
$smarty ->assign('titulo','Sistema de Marcas'); 
$smarty ->assign('subtitulo','Busquedas Foneticas TXT a PDF'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 

$vuser = ltrim(rtrim($usuario));              // Usuario Local
$dir_local='/home/'.$vuser.'/memorias';       // Directorio Local
$vopc=$_GET['vopc'];
$total_file= 0;
// Opcion 1 - Entra la primera vez y selecciona la IP local
// Opcion 2 Muestra la lista de archivos

if ($vopc==2) {
// Lee el directorio 
 $dir='/home/'.$vuser.'/memorias'; 
 $directorio = opendir($dir); 
 //Carga el directorio en un arreglo
 while ($archivo = readdir($directorio)) { 
   if ($archivo=="." || $archivo=="..") { echo " "; } else { 
      $archivos[$archivo] = $archivo;
      $total_file=$total_file+1;
   }
 }  

 foreach ($archivos as $archivo) { 

 // INICIA EL PROCESO DE EXTRACION de la informacion de la busqueda a una tabla temporal
 $Descriptor2 = fopen('/home/kperez/memorias/'.$archivo,"r+");
 		
 $lineas = 1;
 #Vamos leyendo líneas y mostrándolas

 pg_exec("CREATE TEMPORARY TABLE consulta (solicitud char(11), fecha char(10), porc char(2)) ");
 while ((!feof($Descriptor2))) {

    $linearch = fgets($Descriptor2,4096);
    //Obtener Encabezado
    if ($lineas==2) {  $numpos = strpos($linearch,"Fecha"); $numpos = $numpos + 8; $fecha_bus=substr($linearch,$numpos,10);}
    if ($lineas==3) {  $numpos = strpos($linearch,"Hora"); $numpos = $numpos + 8; $hora_bus=substr($linearch,$numpos,10);  }
    if ($lineas==7) {  $numpos = strpos($linearch,"Pedido"); $numpos = $numpos + 8; $pedido=substr($linearch,$numpos,30);  }
    if ($lineas==7) {  $solicitante =substr($linearch,0,80);  }
    if ($lineas==8) {  $numpos = strpos($linearch,"Recibo"); $numpos = $numpos + 8; $recibo=substr($linearch,$numpos,10); } 
    if ($lineas==8) {  $denomi =substr($linearch,0,90);  }
    if ($lineas==9) {  $clase =substr($linearch,0,40);  }     
    
//    if ($lineas >= 15) {  



      $ind = substr($linearch, 0, 1);
      //extraigo la solicitud
      if (is_numeric($ind)) {
         $rest = substr($linearch, 0, 9);
         $fecha = substr($linearch, 11, 10);
         $ano = substr($linearch, 17, 4);
         $sol= $ano.substr($rest, 2, 7);
         //extraigo el porcentaje
         $porc= substr($linearch,-4, 2);
         if (is_numeric($porc)) {
         } 
         else { $porc= '';  
         }

       // Insertamos primero en la Tabla Maestra de Boletin
       $col_campos = "solicitud, fecha, porc";
       $insert_str = "'$sol', '$fecha', '$porc'";
       $ins_boletin = $sql->insert("consulta","$col_campos","$insert_str","");

      }
    $lineas = $lineas + 1;      
 }
 #Cerramos el fichero
 fclose($Descriptor2);


//Inicio del PDF
 $pdf=new PDF_Table('P','mm','Letter');
 $pdf->Open();
 $pdf->AddPage();
 $pdf->AliasNbPages();
 $pdf->SetFont('Arial','',8);

//initialize the table 
$pdf->Table_Init(12);
$columns=12;
//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,0,0) ,
						'BRD_SIZE' => 0
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
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("Nro.SOL.");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("F.SOL ");
		$header_type[$i]['WIDTH'] = 15;
		$i=2;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("STAT");
		$header_type[$i]['WIDTH'] = 10;
		$i=3;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("Nro.REG.");
		$header_type[$i]['WIDTH'] = 15;
		$i=4;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("F.REG.");
		$header_type[$i]['WIDTH'] = 15;
		$i=5;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("F.VENC");
		$header_type[$i]['WIDTH'] = 15;
		$i=6;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("TP");
		$header_type[$i]['WIDTH'] = 6;
		$i=7;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("CLASE");
		$header_type[$i]['WIDTH'] = 12;
		$i=8;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("M");
		$header_type[$i]['WIDTH'] = 6;
		$i=9;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("TITULAR/SOLICITANTE");
		$header_type[$i]['WIDTH'] = 50;
		$i=10;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("PAIS");
		$header_type[$i]['WIDTH'] = 22;
		$i=11;
		$header_type[$i] = $table_default_header_type;
	//	$header_type[$i]['TEXT'] = utf8_decode("%Par.");
		$header_type[$i]['WIDTH'] = 10;
		
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
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0',		
    );
   }
$pdf->Set_Data_Type($data_type);
//draw the first header
$pdf->Draw_Header();

    // Leyendo tabla temporal Consulta
    $res=pg_exec("SELECT * FROM consulta");  
    $filas_resultado=pg_numrows($res); 
//comienzo de la busqueda solicitud x solicitud.   
    $tit= 1 ;
    $tit2= 1 ; 
    for($cont=0;$cont<$filas_resultado;$cont++) { 
       $regist = pg_fetch_array($res); 
       $solicitud= $regist['solicitud'];
       // Armando el query
       $resultado=pg_exec("SELECT stzderec.nro_derecho, stzderec.solicitud,stzderec.fecha_solic, stzderec.tipo_derecho, stzderec.nombre, stzderec.pais_resid, stmmarce.clase, stmmarce.ind_claseni, stmmarce.modalidad, stzderec.estatus, stzderec.registro, stzderec.fecha_regis,stzderec.fecha_venc
						FROM  stzderec,stmmarce, consulta
						WHERE stzderec.solicitud = '$solicitud'
						AND stzderec.nro_derecho=stmmarce.nro_derecho
						AND stzderec.tipo_mp= 'M'
						ORDER BY stzderec.solicitud");  
        $registro = pg_fetch_array($resultado);
        $nderec=$registro['nro_derecho'];

 	//busqueda del titular
	$result = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce 
       WHERE stzottid.nro_derecho='$nderec'
       AND stmmarce.nro_derecho=stzottid.nro_derecho
       AND stzsolic.titular = stzottid.titular");
       $restit = pg_fetch_array($result);
       $filas_found_tit=pg_numrows($result);
	for ($j=0; $j<$filas_found_tit; $j++)
	{
	 $titular = $titular.' '.trim(utf8_decode($restit['nombre']));
	 $restit = pg_fetch_array($result);
	}
	$pais_nombre=pais($registro['pais_resid']);
	//Defino titulos de Identidades
	$porc = $regist['porc'];
        if (is_numeric($porc)) { 
           if ($tit==1) {  
             $pdf->ln(6);  
              $pdf->SetFont('Arial','B',8);             
             $pdf->MultiCell(196,3,'ANTECEDENTES DE SEMENJAZA EN LA CLASE SOLICITADA  ',0,'J',0); 
	      $pdf->SetFont('Arial','',8);              
             $pdf->ln(6);  
             $tit= 0; }}
	else {
           if ($tit2==1) { 
	      $pdf->MultiCell(196,4,'ANTECEDENTES DE IDENTIDAD EN TODAS LAS CLASES ',0,'J',0); 
	      $pdf->ln(8); 
	      $tit2= 0; }}	
	//detalle
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['fecha_solic'];
	$data[2]['TEXT'] = $registro['estatus']-1000;
	$data[3]['TEXT'] = $registro['registro'];
	$data[4]['TEXT'] = $registro['fecha_regis'];
	$data[5]['TEXT'] = $registro['fecha_venc'];	
	$data[6]['TEXT'] = $registro['tipo_derecho'];
	$data[7]['TEXT'] = $registro['clase'].'-'.$registro['ind_claseni'];
	$data[8]['TEXT'] = $registro['modalidad'];
	$data[9]['TEXT'] = $titular;
	$data[10]['TEXT'] = $pais_nombre;
	$data[11]['TEXT'] = $regist['porc'];
	$titular='';
	$pdf->Draw_Data($data);
        $pdf->MultiCell(196,4,'MARCA: '.utf8_decode($registro['nombre']),0,'J',0);
        $pdf->ln(1); 
    }

$pdf->Draw_Table_Border();
//Total de solicitudes
$pdf->ln(6);  
$pdf->SetFont('Arial','B',8);  
$pdf->MultiCell(196,4,'** Total de Solicitudes Buscadas: '.$filas_resultado,0,'J',0); 
$pdf->ln(6); 
$pdf->MultiCell(196,4,'----------------------------------------------------------------------------> Venezuela FIN DE ANTECEDENTES <-----------------------------------------------------------------------',0,'J',0);   
 //Borrar tabla temporal
//DROP TABLE ('consulta');
 $borrar=pg_exec("SELECT * FROM consulta"); 
 $filas_borrar = pg_numrows($borrar); 
 if ($filas_borrar==0)    { echo "ENTREPOR AQUI"; $borrar1=pg_exec("DROP TABLE consulta"); }


// $sql->disconnect();
 ob_end_clean(); 
// $pdf->Output();
 $pdf->Output('/home/'.$vuser.'/memorias/'.trim($recibo).'.pdf');    

}  

}

// Opcion 3 - Transfiere los archivos y los borra del directorio local
if ($vopc==3) {
   //Copia
 //  exec('scp -i /home/www-data/sshids/idrsa-1 '.$vuser.'@'.$iploc.':/home/'.$vuser.
   //     '/memorias/*.* /apl/memorias');
   //Guardar registros
   
   //Borra
  // exec('ssh '.$vuser.'@'.$iploc.' -i /home/www-data/sshids/idrsa-1 rm '.$dir_local.'/*.*');
}

$smarty->assign('titulo','S.I.P.I.');
$smarty->assign('subtitulo','Busquedas Foneticas TXT a PDF'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->assign('dir_local',$dir_local);
$smarty ->assign('vtip',array("192.8.18.55")); 
$smarty->assign('total_file',$total_file);
$smarty->assign('cols',6);
$smarty->assign('vopc',$vopc);
$smarty->display('encabezado1.tpl');
$smarty->display('busqpdf_fd.tpl');
$smarty->display('pie_pag.tpl');
?>
