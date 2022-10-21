<?php
// *************************************************************************************
// Programa: w_formulario.php 
// Realizado por el Analista de Sistema Ing. Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año 
// *************************************************************************************
function formulario($vtramt,$vsol) {
// *************************************************************************************
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

ob_start();

//Table Base Classs
require ("$include_lib/PDF_tablesep.php");


//captura de variables
$vtramt = $vtramt;
$vsol = $vsol;

//Inicio del PDF
$pdf=new PDF_Table('P','mm','A4');
//$pdf=new PDF('P','mm','letter');
//$pdf->SetMargins(15,15,10);
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();


//$pdf->Image('../imagenes/planilla_marcas.jpg',3,0,205,330,'JPEG');

//Verificando Segunda conexion
$sql1 = new mod_db();
$sql1->connection1();
       
// Armando el query segun el numero de tramite
$resultado = pg_exec("SELECT * FROM stzderec WHERE nro_tramite = '$vtramt' AND solicitud = '$vsol'");
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

if ($filas_resultado==0) { $mensaje= $mensaje.'* No Existe el Numero de Tramite '; exit();} 

// Inicio del Formulario
 for($cont=0;$cont<$filas_resultado;$cont++) { 
      $ind_titular=0;
      $ind_agente=0;
      $ind_pag=0; 
      $pdf->Image('../imagenes/planilla_marcas.jpg',3,0,205,330,'JPEG'); 
      $nsolic = $registro['solicitud'];
      $nagen = $registro['agente'];
      // Numero de Tramite en la Planilla
      $pdf->Setfont('Arial','B',11); 
      $tramite= $vtramt.'_'.$nsolic;  
      $pdf->Text(145,30,$tramite);          
         
      //Datos del solicitante
      $pdf->Setfont('Arial','B',9); 
      $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzsolic.identificacion, stzsolic.indole, stzsolic.telefono1, stzsolic.telefono2, stzsolic.fax, stzsolic.email, stzottid.nacionalidad, stzottid.domicilio
       			      FROM stzottid, stzsolic 
       			      WHERE stzottid.nro_tramite='$vtramt'
       			      AND stzottid.solicitud='$nsolic'
                              AND stzsolic.titular = stzottid.titular");
      $filas_found1=pg_numrows($res_titular);
      $regt = pg_fetch_array($res_titular);
      for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	  $pais_nombre=pais($regt['nacionalidad']);
 	  if ($filas_found1 > '1') { $ind_titular= '1'; } // $ind_titular indicador de mas de un titular
 	  //buscar indole
	  if ($regt['indole']=='N') { $pdf->Text(38,43,'X',0,1); } //natural
	  if ($regt['indole']=='G') { $pdf->Text(121,52,'X',0,1); } //organismos del estado
	  if ($regt['indole']=='X') { $pdf->Text(162,52,'X',0,1); } //empresas del estado	    	
	  if ($regt['indole']=='M') { $pdf->Text(197,52,'X',0,1); } //empresas mixtas
	  if ($regt['indole']=='O') { $pdf->Text(138,59,'X',0,1); } //comunal
	  if ($regt['indole']=='C') { $pdf->Text(60,65,'X',0,1); } //cooperativas
	  if ($regt['indole']=='P') { $pdf->Text(103,65,'X',0,1); } //privadas (nacionales)
	  if ($regt['indole']=='E') { $pdf->Text(171,65,'X',0,1); } //extranjeras

	  $pdf->Text(55,71, $regt['identificacion']); //cedula
	  $pdf->Text(68,77,$regt['nombre']);  //nombre
	  $pdf->SetXY(5,84);
          $pdf->MultiCell(0,4,$regt['domicilio'],0,'J',0); //domicilio
	  $pdf->Text(35,102,$pais_nombre);  //nacionalidad
	  $pdf->Text(90,102,$regt['email']);  //correo
	  $pdf->Text(35,108,$regt['telefono1']); //telefono	  
	  $pdf->Text(90,108,$regt['telefono2']); //celular
	  $pdf->Text(150,108,$regt['fax']);  //fax	  
	  	  	  	  	  
	  $regt = pg_fetch_array($res_titular);
          $cont1=$filas_found1+1;
      } 
      // Datos del Poder
	  $pdf->Text(38,121,$registro['poder']);       
      
      // Datos del Apoderado o Tramitante
          $res_agen=pg_exec("SELECT * FROM stzagenr,stzautod 
                             WHERE stzautod.nro_tramite = '$vtramt' 
                             AND stzautod.solicitud = '$nsolic' 
                             AND stzagenr.agente = stzautod.agente");
 	  $regage = pg_fetch_array($res_agen);
          $filas_agente=pg_numrows($res_agen);

	  if ($regage['agente']<= 0)
             { 
              $res_tram=pg_exec("SELECT * FROM stztramr
                                 WHERE idtramitante = '$registro[idtramitante]' ");                          
              $regtram = pg_fetch_array($res_tram);
              $filas_tram = pg_numrows($res_tram);
              $pdf->Text(72,128,trim($registro['tramitante'])); 
 	      $pdf->Text(155,121, $regtram['cedula']); //cedula
      	      $pdf->Text(68,128,$regtram['nombre']);  //nombre
	      $pdf->SetXY(5,135);
              $pdf->MultiCell(0,4,$regtram['domicilio'],0,'J',0); //domicilio
              $pais_nombre=pais($regtram['nacionalidad']);
	      $pdf->Text(35,152,$pais_nombre);  //nacionalidad
	      $pdf->Text(90,152,$regtram['email']);  //correo
	      $pdf->Text(35,158,$regtram['telefono1']); //telefono	  
	      $pdf->Text(90,158,$regtram['telefono2']); //celular
	      $pdf->Text(150,158,$regtram['fax']);  //fax	            
                         
             }
	  if ($regage['agente']> 0)
	     { if ($filas_agente > 1) { $ind_agente = '1'; } // $ind_agente indicador de mas de un agente
	       $pdf->Text(102,121, $regage['agente']); //nro agente	     
	       $pdf->Text(155,121, $regage['cedula']); //cedula
      	       $pdf->Text(68,128,$regage['nombre']);  //nombre
	       $pdf->SetXY(5,135);
               $pdf->MultiCell(0,4,$regage['domicilio'],0,'J',0); //domicilio
               $pais_nombre=pais($regage['nacionalidad']);
	       $pdf->Text(35,152,$pais_nombre);  //nacionalidad
	       $pdf->Text(90,152,$regage['email']);  //correo
	       $pdf->Text(35,158,$regage['telefono1']); //telefono	  
	       $pdf->Text(90,158,$regage['telefono2']); //celular
	       $pdf->Text(150,158,$regage['fax']);  //fax		     	      
          } 

      // Datos del Signo
	  $resul_marce = pg_exec("SELECT * FROM stmmarce WHERE nro_tramite = '$vtramt' AND solicitud = '$nsolic'");
	  $reg_marce = pg_fetch_array($resul_marce);
          if ($reg_marce['modalidad']== 'D') { $pdf->Text(93,172,'X',0,1); } //Nominativa
          if ($reg_marce['modalidad']== 'G') { $pdf->Text(132,172,'X',0,1); $ind_logo = 1;} //Grafica (indicador de logo)
          if ($reg_marce['modalidad']== 'M') { $pdf->Text(171,172,'X',0,1); $ind_logo = 1;} //Mixta
      	   
          if ($registro['tipo_derecho']== 'M') { $pdf->Text(47,179,'X',0,1); } //MARCA DE PRODUCTO
          if ($registro['tipo_derecho']== 'N') { $pdf->Text(102,179,'X',0,1); } //NOMBRE COMERCIAL
          if ($registro['tipo_derecho']== 'L') { $pdf->Text(143,179,'X',0,1); } //LEMA COMERCIAL
          if ($registro['tipo_derecho']== 'S') { $pdf->Text(47,186,'X',0,1); } //MARCA DE SERVICIO
          if ($registro['tipo_derecho']== 'C') { $pdf->Text(47,192,'X',0,1); } //MARCA COLECTIVA
          if ($registro['tipo_derecho']== 'D') { $pdf->Text(102,186,'X',0,1); } //DENOMINACION DE ORIGEN   

      // Datos del Lema
	  $res_lema=pg_exec("SELECT * FROM stmlemad WHERE nro_tramite='$vtramt' AND solicitud = '$nsolic'");
          $reg_reglem = pg_fetch_array($res_lema);  
          $pdf->Text(172,185,$reg_reglem['solicitud_aso'].$reg_reglem['registro_aso'],0,1); 
          $pdf->Text(147,192,trim($reg_reglem['nombre_sol']),0,1); 

      // Datos de la prioridad
	  $res_prio=pg_exec("SELECT * FROM stzpriod  WHERE nro_tramite='$vtramt' AND solicitud = '$nsolic'");
          $reg_regprio = pg_fetch_array($res_prio);  
          $pdf->Text(120,199,$reg_regprio['prioridad'],0,1); 
          $pais_nombre=pais($reg_regprio['pais_priori']);
          $pdf->Text(72,199,$pais_nombre,0,1);       
          $pdf->Text(170,199,$reg_regprio['fecha_priori'],0,1);       
          
      // Tipo de Clase
      	  $res_clase=pg_exec("SELECT * FROM stmclnac WHERE nro_tramite='$vtramt' AND solicitud = '$nsolic'");
   	  $reg_clase = pg_fetch_array($res_clase);  
   	  if ($reg_clase['clase_nac']== 0) {$pdf->Text(57,206,'LC',0,1); } else {$pdf->Text(57,206,$reg_clase['clase_nac'],0,1); }
          $pdf->Text(118,206,$reg_marce['clase'],0,1);   

      // Tipo de Producto
          if ($reg_marce['ind_producto']== 'N') { $pdf->Text(67,213,'X',0,1); } //Producto Nacional      
          if ($reg_marce['ind_producto']== 'E') { $pdf->Text(121,213,'X',0,1); } //Producto Extranjero     
          $pais_nombre=pais($registro['pais_resid']);   
	  $pdf->Text(151,213, $pais_nombre); //pais de residencia          
                           
      // Signo  o Nombre de la Marca
          if ($ind_logo== 1) { 
             $resul_logo = pg_exec("SELECT * FROM stmsolref WHERE nro_tramite = '$vtramt' AND solicitud = '$nsolic'");
             $reg_logo = pg_fetch_array($resul_logo);  
             $resul_logo1 = pg_exec("SELECT * FROM stmbugra WHERE nro_busgra = '$reg_logo[ref_gra]' ");
             $reg_logo1 = pg_fetch_array($resul_logo1);      
     	     $ruta = $reg_logo1['archivo_logo'];
     	   //  $pdf->Text(17,250,$ruta,0,1);    
             $pdf->Image("$ruta",10,224,55,45,'PNG');
          }     
          else {
            $pdf->Setfont('Arial','B',12); 
            //$pdf->Text(12,250,trim($registro['nombre']),0,1);  
            
   	    $pdf->SetXY(12,245);
            $pdf->MultiCell(50,4,trim($registro['nombre']),0,'C',0); //nombre
            
            $pdf->Setfont('Arial','B',9); 
          }
      
      // Distingue
  	  $pdf->SetXY(72,224);
  	  $num_letras=strlen(trim($reg_marce['distingue'])); 

	  if ($num_letras>1140)
	  {
           //no corta la palabra lo deja en el espacio anterior del limite
             $str = trim(substr($reg_marce['distingue'],0,1140));
             $str = $str.' *****';
             $pdf->MultiCell(130,4,utf8_decode($str),0,'J'); 
          }
          if ($num_letras<1140) { $pdf->MultiCell(130,4,utf8_decode($reg_marce['distingue']),0,'J',0); }   	  
  	  
      // Anexos	  
	  $resul_anexo = pg_exec("SELECT * FROM stzanxtra WHERE nro_tramite = '$vtramt' AND solicitud = '$nsolic'");
          $filas_anexo=pg_numrows($resul_anexo);	  
	  for($conta=0;$conta<$filas_anexo;$conta++)   { 
	     $reg_anexo = pg_fetch_array($resul_anexo);
             if ($reg_anexo['cod_anexo']== 'A') { $pdf->Text(136,302,'X',0,1); } // poder
             if ($reg_anexo['cod_anexo']== 'B') { $pdf->Text(136,306,'X',0,1); } // reglamento uso de marca
             if ($reg_anexo['cod_anexo']== 'C') { $pdf->Text(136,311,'X',0,1); } // documento  de prioridad y certificado de registro ext.
             if ($reg_anexo['cod_anexo']== 'D') { $pdf->Text(136,316,'X',0,1); } // certificado de registro ext.
             if ($reg_anexo['cod_anexo']== 'E') { $pdf->Text(136,320,'X',0,1); } // comprobante de pago de tasa
             if ($reg_anexo['cod_anexo']== 'F') { $pdf->Text(201,295,'X',0,1); } //registro mercantil      	   
             if ($reg_anexo['cod_anexo']== 'G') { $pdf->Text(201,306,'X',0,1); } // acta ultima asamblea
             if ($reg_anexo['cod_anexo']== 'H') { $pdf->Text(201,310,'X',0,1); } // copia de ci
             if ($reg_anexo['cod_anexo']== 'I') { $pdf->Text(201,313,'X',0,1); } //copia de rif  
             // if ($reg_anexo['cod_anexo']== 'J') { $pdf->Text(170,321,'X',0,1); } // busqueda fonetica
             if ($ind_logo== '1') { $pdf->Text(170,325,'X',0,1); } // busqueda grafica  
             else {   $pdf->Text(170,321,'X',0,1); }  
             if ($reg_marce['modalidad']== 'M') {  $pdf->Text(170,321,'X',0,1); } 
             if ($reg_anexo['cod_anexo']== 'O') { $pdf->Text(170,325,'X',0,1); } // Otros                 
         }       
   
   //Hoja Adicional de Formulario datos extras
    //Datos del solicitante
    if ($ind_titular== 1) {
       $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzsolic.identificacion, stzsolic.indole, stzsolic.telefono1, stzsolic.telefono2, stzsolic.fax, stzsolic.email, stzottid.nacionalidad, stzottid.domicilio
       			      FROM stzottid, stzsolic 
       			      WHERE stzottid.nro_tramite='$vtramt'
       			      AND stzottid.solicitud='$nsolic'
                              AND stzsolic.titular = stzottid.titular");
      $filas_found1=pg_numrows($res_titular);
      $regt = pg_fetch_array($res_titular);
      $pdf->AddPage(); 
      $ind_pag=1;
      $pdf->Setfont('Arial','BUI',9);
      $pdf->Multicell(120,4,utf8_decode('Continuación de Datos del Solicitante '));
      $pdf->Setfont('Arial','',9); 
      $filas_found1=$filas_found1-1;     
      for($cont1=0;$cont1<$filas_found1;$cont1++)   {       
          $regt = pg_fetch_array($res_titular);
	  $pais_nombre=pais($regt['nacionalidad']);
	  $pdf->MultiCell(120,4,"Cedula,Pasaporte o Rif: ".$regt['identificacion']); //cedula
	  $pdf->MultiCell(120,4,utf8_decode("Nombre(s) Apellidos o Razón Social: ").$regt['nombre']);  //nombre
	  $pdf->MultiCell(0,4,"Domicilio: ".$regt['domicilio'],0,'J',0); //domicilio
	  $pdf->MultiCell(120,4,"Nacionalidad: ".$pais_nombre);  //nacionalidad
	  $pdf->MultiCell(120,4,"Correo: ".$regt['email']);  //correo
	  $pdf->MultiCell(120,4,"Telefono: ".$regt['telefono1']); //telefono	  
	  $pdf->MultiCell(120,4,"Celular: ".$regt['telefono2']); //celular
	  $pdf->MultiCell(120,4,"Fax: ".$regt['fax']);  //fax	  
 	  $pdf->Ln(2);
      } 
   }
      //Datos Adicionales del tramitante o apoderado
      if ( $ind_agente == 1) {
          $res_agen=pg_exec("SELECT * FROM stzagenr,stzautod 
                             WHERE stzautod.nro_tramite = '$vtramt' 
                             AND stzautod.solicitud = '$nsolic' 
                             AND stzagenr.agente = stzautod.agente");
 	   $regage = pg_fetch_array($res_agen);   
           $filas_found1=pg_numrows($res_agen);
           $pdf->ln(6);
           if ($ind_pag != 1){ 
              $pdf->AddPage(); 
              $ind_pag = 1; 
           }
           $pdf->Setfont('Arial','BUI',9); 
           $pdf->Multicell(120,4,utf8_decode('Continuación de Datos del Apoderado / Tramitante '));        
           $pdf->Setfont('Arial','',9); 
           $filas_found1=$filas_found1-1;                 
           for($cont1=0;$cont1<$filas_found1;$cont1++)   {  
         	  $regage = pg_fetch_array($res_agen);    
   	       	  $pdf->MultiCell(120,4,"Nro de Agente: ".$regage['agente']); //nro agente	     
	          $pdf->MultiCell(120,4,"Cedula: ".$regage['cedula']);  //cedula
      	       	  $pdf->MultiCell(120,4,utf8_decode("Nombre(s) Apellidos o Razón Social: ").$regage['nombre']);   //nombre
               	  $pdf->MultiCell(120,4,"Domicilio: ".$regage['domicilio'],0,'J',0); //domicilio
               	  $pais_nombre=pais($regage['nacionalidad']); 
	       	  $pdf->MultiCell(120,4,"Nacionalidad: ".$pais_nombre); //nacionalidad
	       	  $pdf->MultiCell(120,4,"Correo: ".$regage['email']);   //correo
	       	  $pdf->MultiCell(120,4,"Telefono: ".$regage['telefono1']);  //telefono	  
	      	  $pdf->MultiCell(120,4,"Celular: ".$regage['telefono2']);   //celular
	       	  $pdf->MultiCell(120,4,"Fax: ".$regage['fax']);   //fax
 	          $pdf->Ln(2);
           }     
      }
      //Datos Adicionales del Distingue  
     $num_letras=strlen(trim($reg_marce['distingue'])); 
     if ($num_letras>1140)
     {     
      if ($ind_pag != 1){ 
          $pdf->AddPage(); 
          $ind_pag = 1; 
          $fil=14; $inc=4; 
          $pdf->SetXY(14,14);}
       $str = trim(substr($reg_marce['distingue'],1140,3000));
       $pdf->Setfont('Arial','BUI',9);    
       $pdf->Multicell(120,4,utf8_decode('Continuación del Distingue '));        
       $pdf->Setfont('Arial','',9);  
       $pdf->MultiCell(180,4,utf8_decode($str),0,'J');  
     }    
   
   if  ($cont+1!=$filas_resultado) {$registro = pg_fetch_array($resultado); $pdf->AddPage();}    
         
} //fin del for inicial

$sql->disconnect();

ob_end_clean();        
//Salida del Reporte
$salida='formulario'.$vtramt.'_'.$nsolic;
//$pdf->Output("../../tmp_anexos/".$salida.".pdf");  
$pdf->Output($salida.".pdf");  
//$pdf->Output();  
}
       
?>
