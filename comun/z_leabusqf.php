
<script language="Javascript"> 
 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }
</script>
<?php
//Transforma busqueda de fondo del 70 a pdf
#ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Llamada al PDF
include ("../setting.inc.php"); 
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/PDF_tablesbfond.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login   = $_SESSION['usuario_login'];
$role    = trim($_SESSION['usuario_rol']);
$vopc    = $_GET['vopc'];
$fecha   = fechahoy();
$hh      = hora();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Conversi&oacute;n de Archivos Busquedas Fondo TXT a PDF'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) {
//Conexion
$sql = new mod_db();
$sql->connection($login);
//Variables
$linea="-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
//$ruta="/apl/busquedas/fondo";
$ruta="/var/www/apl/sipi/documentos/fonetica";
$vopc=2;
$reciboant='';
$cont=1; 
$totalfile=0;
//$total_archivos = count(glob($ruta."/d*",GLOB_BRACE));
//echo "son $total_archivos, $role "; 
//if (($total_archivos<=90) AND ($role!="ADMIN")) { }
//else {
//  mensajenew("AVISO: Demasiados archivos a procesar, Contacte al Administrador del Sistema para su conversi&oacute;n ...!!!","javascript:history.back();","N");
//  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
//}	
if ($vopc==2) {   
   exec('ls '.$ruta.'/d*',$salida);
   foreach($salida as $line) { 
     pg_exec("CREATE TEMPORARY TABLE consulta (solicitud char(11), fecha char(10), porc char(2)) ");
     $archivo=substr(ltrim(rtrim($line)),38,11);
     #Abrimos el fichero
     $Descriptor2 = fopen($ruta."/".$archivo,"r+");
     $lineas = 1;
     $fin=0;
     while ((!feof($Descriptor2)) AND $fin==0)  {
        $linearch = fgets($Descriptor2,4096);
        //Obtener Encabezado
        $finpos=strpos($linearch,"FIN ANTECEDENTES");
        if ($finpos === false) { $fin=0; } else { $fin=1; }
        if ($lineas==2) {  $numpos = strpos($linearch,"Fecha"); $numpos = $numpos + 8;  
            $fecha_bus=substr($linearch,$numpos,10);}
        if ($lineas==3) {  $numpos = strpos($linearch,"Hora"); $numpos = $numpos + 8; 
            $hora_bus=substr($linearch,$numpos,10);  }
               
     
        if ($lineas==7) {  $solicitud =substr($linearch,0,70);   
            $numpos = strpos($linearch,"Solicitud");

            $numpos = utf8_decode($numpos) + 10;
            $newname=ltrim(rtrim(substr($linearch,$numpos,4)));             
             
            $ano_hoy = date("Y");
            $digito= $ano_hoy - 2000;
            $dos= '20';
            $mil= '19';
            if ($newname <= $digito) { $fondo = $dos.substr($solicitud, 10, 2); }
            else { $fondo = $mil.substr($solicitud, 10, 2); }
            

            
            $numero = substr($solicitud, 13, 7);
            $newnameant=$fondo.'-'.$numero;
            $numero_nuevo=$fondo.'-'.$numero;
            $newname= $fondo.$numero;

            if ($newname==$reciboant) {
              if ($cont==1) {
                   $newnameant=$newname."_".ltrim(rtrim($cont));
                   #echo "Renombrar ".$newname," como ".$newnameant,"<br>";
                   exec('cp '.$ruta.'/'.$newname.'.pdf '.$ruta.'/'.$newnameant.'.pdf'); 
                   exec('rm '.$ruta.'/'.$newname.'.pdf');  
               }
               $cont=$cont+1;
               $newname=ltrim(rtrim(substr(utf8_decode($linearch),$numpos,9))).'_'.ltrim(rtrim($cont));
            }else{
               $reciboant=$newname;
               $cont=1; 
            }

            #echo "Renombrar ".$archivo." como ".$newname,"<br>"; 
            exec('cp '.$ruta.'/'.$archivo.' '.$ruta.'/'.$newname);
            //Agragado por Romulo Mendoza 25/01/2011 
      //     $tbname_1 = "stmbusweb";
      //      $update_str = "estado='2'";
      //      $act_user = $sql->update("$tbname_1","$update_str","tipo_busq='F' AND ref_busq='$ref'");
            
        }
        
        if ($lineas==8) {  $denomi =substr($linearch,0,70); }
        
        if ($lineas==9) {  $clase =substr($linearch,0,40);  } 
        $ind = substr($linearch, 0, 1);
        //extraigo la solicitud
        if (is_numeric($ind)) {
           $rest = substr($linearch, 0, 9);
           $fecha = substr($linearch, 11, 10);
           $ano = substr($linearch, 17, 4);
           $sol= $ano.substr($rest, 2, 7);
           
           //extraigo el porcentaje
           $porc= substr($linearch,-4, 2);
           if (is_numeric($porc)) { $x=''; } else { $porc= ''; }
           
           // Insertamos primero en la Tabla Maestra de Boletin
           $col_campos = "solicitud, fecha, porc";
           #echo "Solicitudes: ".$solicitud."  ".$fecha."  ".$porc,"<br>"; 
           $insert_str = "'$sol', '$fecha', '$porc'";
           $ins_boletin = $sql->insert("consulta","$col_campos","$insert_str","");
           //$porc = trim($porc);
           if ($porc=='') { $tipo='I'; $porc='00'; } else { $tipo='S'; } 
           $insert_str = "'$numero_nuevo','$sol','$fecha','$porc','$tipo'";
           $ins_fondo = $sql->insert("stmfondo","","$insert_str","");
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
    
   //  $pdf->ln(3);  
   //  $pdf->SetFont('Arial','B',8);             
   //  $pdf->MultiCell(196,3,'ANTECEDENTES DE SEMENJAZA EN LA CLASE SOLICITADA  ',0,'J',0); 
   //  $pdf->SetFont('Arial','',8);              
   //  $pdf->ln(6);      
     //$tit2=0;
     
     $tit= 1 ;
     $tit2= 1 ; 
    
    
     for($cont2=0;$cont2<$filas_resultado;$cont2++) { 
       $regist = pg_fetch_array($res); 
       $solicitud= $regist['solicitud'];
       // Armando el query
       $resultado=pg_exec("SELECT stzderec.nro_derecho, stzderec.solicitud,stzderec.fecha_solic, stzderec.tipo_derecho, stzderec.nombre, stzderec.pais_resid, stmmarce.clase, stmmarce.ind_claseni, stmmarce.modalidad, stzderec.estatus, stzderec.registro, stzderec.fecha_regis,stzderec.fecha_venc
						FROM  stzderec,stmmarce
						WHERE stzderec.solicitud = '$solicitud'
						AND stzderec.nro_derecho=stmmarce.nro_derecho
						AND stzderec.tipo_mp= 'M'");  
       $registro = pg_fetch_array($resultado);
       $nderec=$registro['nro_derecho'];

       //busqueda del titular
       $result = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic 
       WHERE stzottid.nro_derecho='$nderec'
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
       
        
       
      // if (is_numeric($porc)) { 
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
//             $tit2 = $tit2 + 1;
             $cant = $cant + 1;
      // }
      // else { $titular='';
      // }	
     } 
$pdf->Draw_Table_Border();
     //Total de solicitudes
     $pdf->ln(6);  
     $pdf->SetFont('Arial','B',8);  
 //    $pdf->MultiCell(196,4,'** Total de Solicitudes Buscadas: '.$cant,0,'J',0); 
 //    $pdf->ln(6); 
     $pdf->MultiCell(196,4,'------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,'J',0);   
     //Borrar tabla temporal

     $borrar1=pg_exec("DROP TABLE consulta"); 


     // $sql->disconnect();
     ob_end_clean(); 
     // $pdf->Output();
     $pdf->Output($ruta.'/'.'ef'.$fondo.'/'.trim($newname).'.pdf');  
     $pdf->Close();
     exec('rm '.$ruta.'/'.$newname);  
     $totalfile=$totalfile+1;
     //echo "Total de archivos procesados: ".$totalfile,"<br>";
   }
   exec('rm '.$ruta.'/d*');
      echo "Total de archivos procesados: ".$totalfile,"<br>";
}

}

$smarty->assign('vopc',$vopc);
$smarty->display('z_leabusqf.tpl');
$smarty->display('pie_pag.tpl');
?>


