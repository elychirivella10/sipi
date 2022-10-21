<?php
// *************************************************************************************
// Programa: w_formsipi.php 
// Realizado por el Analista de Sistema Ing. Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Formulario SiPI
// *************************************************************************************
//function formulario($vsol) {
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

ob_start();

include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_tablesep.php");

//captura de variables
//$vtramt = $vtramt;
$vsol=$_GET['vsol'];
$nombre_usuario=$_SESSION['usuario_nombre'];

//Verificando Segunda conexion
$sql = new mod_db();
$sql->connection();
       
// Armando el query segun el numero de tramite
$resultado = pg_exec("SELECT * FROM stzderec WHERE  solicitud = '$vsol' AND tipo_mp = 'M' ");
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

if ($filas_resultado==0) { 
   $smarty->display('encabezado1.tpl');
   mensajenew('Error: No Existe el Numero de Solicitud! Verifique...','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); exit(); 
} 

//Inicio del PDF
$pdf=new PDF_Table('P','mm','legal');
//$pdf=new PDF('P','mm','letter');
//$pdf->SetMargins(15,15,10);
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->Image('../imagenes/planilla_marcas.jpg',3,0,205,330,'JPEG');

// Inicio del Formulario
// for($cont=0;$cont<$filas_resultado;$cont++) { 
 
      $nsolic = $registro['solicitud'];
      $nderec = $registro['nro_derecho'];
      $nagen = $registro['agente'];
      
      // Numero de Tramite en la Planilla
      $pdf->Setfont('Arial','B',14); 
      $tramite= $vsol;  
      $res_hora = pg_exec("SELECT * FROM stzevtrd WHERE  nro_derecho = '$nderec' AND evento = '1200' ");
      $reg_hora = pg_fetch_array($res_hora);
      $pdf->Text(113,25,$tramite.' / '.$registro['fecha_solic'].' / '.$reg_hora['hora'] );  
      $pdf->Setfont('Arial','B',9);           
       $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzsolic.identificacion, stzsolic.indole, stzsolic.telefono1, stzsolic.telefono2, stzsolic.fax, stzsolic.email, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       			      FROM stzottid, stzsolic 
       			      WHERE stzottid.nro_derecho='$nderec'
                              AND stzsolic.titular = stzottid.titular");
      $filas_found1=pg_numrows($res_titular);
      $regt = pg_fetch_array($res_titular);

      for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	  $pais_nombre=pais($regt['nacionalidad']);
	  $pais_nombre2=pais($regt['pais_domicilio']);
	  if ($filas_found1 > 1) { $ind_titular= '1'; } // $ind_titular indicador de mas de un titular
 	  //buscar indole
	  if ($regt['indole']=='N') { $pdf->Text(40,58,'X',0,1); } //natural
	  if ($regt['indole']=='G') { $pdf->Text(73,64,'X',0,1); } //organismos del estado
	  if ($regt['indole']=='X') { $pdf->Text(162,64,'X',0,1); } //empresas del estado	    	
	  if ($regt['indole']=='M') { $pdf->Text(197,64,'X',0,1); } //empresas mixtas
	  if ($regt['indole']=='O') { $pdf->Text(54,78,'X',0,1); } //comunal
	  if ($regt['indole']=='C') { $pdf->Text(73,64,'X',0,1); } //cooperativas
	  if ($regt['indole']=='P') { $pdf->Text(74,70,'X',0,1); } //privadas (nacionales)
	  if ($regt['indole']=='E') { $pdf->Text(145,70,'X',0,1); } //extranjeras

	  $pdf->Text(55,83, $regt['identificacion']); //cedula
	  $pdf->Text(68,89,$regt['nombre']);  //nombre
	  $pdf->SetXY(5,96);
          $pdf->MultiCell(0,4,$regt['domicilio'],0,'J',0); //domicilio
	  $pdf->Text(32,114,$pais_nombre2);  //pais de domicilio
	  $pdf->Text(97,114,$pais_nombre);  //nacionalidad
	  $pdf->Text(153,114,$regt['email']);  //correo
	  $pdf->Text(32,120,$regt['telefono1']); //telefono	  
	  $pdf->Text(97,120,$regt['telefono2']); //celular
	  $pdf->Text(153,120,$regt['fax']);  //fax	  
	  	  	  	  	  
	  $regt = pg_fetch_array($res_titular);
          $cont1=$filas_found1+1;
      } 
      // Datos del Poder
	  $pdf->Text(38,133,$registro['poder']);      
      
      // Datos del Apoderado o Agente
          $res_agen=pg_exec("SELECT * FROM stzagenr,stzautod 
                             WHERE stzautod.nro_derecho='$nderec'
                             AND stzagenr.agente = stzautod.agente");
                                   
          $filas_agente=pg_numrows($res_agen);
 	  $regage = pg_fetch_array($res_agen);
	   if ($filas_agente == 0) 
             { 
              $res_tram=pg_exec("SELECT * FROM stztramr
                                 WHERE idtramitante = '$registro[idtramitante]' ");                          
              $regtram = pg_fetch_array($res_tram);
              $filas_tram = pg_numrows($res_tram);
             //  $pdf->Text(72,128,'entre a que exito',0,1);     
            //  $pdf->Text(72,128,trim($registro['tramitante'])); 
 	      $pdf->Text(157,134, $regtram['cedula']); //cedula
      	      $pdf->Text(68,140,$regtram['nombre']);  //nombre
	      $pdf->SetXY(5,147);
              $pdf->MultiCell(0,4,$regtram['domicilio'],0,'J',0); //domicilio
              $pais_nombre=pais($regtram['nacionalidad']);
              $pais_nombre2=pais($regtram['pais_domicilio']);
	      $pdf->Text(32,164,$pais_nombre2);  //pais de domicilio
	      $pdf->Text(97,164,$pais_nombre);  //nacionalidad
	      $pdf->Text(153,164,$regtram['email']);  //correo
	      $pdf->Text(32,170,$regtram['telefono1']); //telefono	  
	      $pdf->Text(97,170,$regtram['telefono2']); //celular
	      $pdf->Text(153,170,$regtram['fax']);  //fax	            
                         
             }
	  if ($regage['agente']> 0)
	     { if ($filas_agente > 1) { $ind_agente = 1; } // $ind_agente indicador de mas de un agente
	       $pdf->Text(99,134, $regage['agente']); //nro agente	     
	       $pdf->Text(157,134, $regage['cedula']); //cedula
      	       $pdf->Text(68,140,$regage['nombre']);  //nombre
	       $pdf->SetXY(5,147);
               $pdf->MultiCell(0,4,$regage['domicilio'],0,'J',0); //domicilio
               $pais_nombre=pais($regage['nacionalidad']);
               $pais_nombre2=pais($regage['pais_domicilio']);
	       $pdf->Text(32,164,$pais_nombre2);  //pais de domicilio
	       $pdf->Text(97,164,$pais_nombre);  //nacionalidad
	       $pdf->Text(153,164,$regage['email']);  //correo
	       $pdf->Text(32,170,$regage['telefono1']); //telefono	  
	       $pdf->Text(97,170,$regage['telefono2']); //celular
	       $pdf->Text(153,170,$regage['fax']);  //fax		     	      
          } 

      // Datos del Signo
	  $resul_marce = pg_exec("SELECT * FROM stmmarce WHERE  nro_derecho = '$nderec'");
	  $reg_marce = pg_fetch_array($resul_marce);
          if ($reg_marce['modalidad']== 'D') { $pdf->Text(93,184,'X',0,1); } //Nominativa
          if ($reg_marce['modalidad']== 'G') { $pdf->Text(132,184,'X',0,1); $ind_logo = 1;} //Grafica (indicador de logo)
          if ($reg_marce['modalidad']== 'M') { $pdf->Text(171,184,'X',0,1); $ind_logo = 1;} //Mixta
      	   
          if ($registro['tipo_derecho']== 'M') { $pdf->Text(47,191,'X',0,1); } //MARCA DE PRODUCTO
          if ($registro['tipo_derecho']== 'N') { $pdf->Text(102,191,'X',0,1); } //NOMBRE COMERCIAL
          if ($registro['tipo_derecho']== 'L') { $pdf->Text(143,191,'X',0,1); } //LEMA COMERCIAL
          if ($registro['tipo_derecho']== 'S') { $pdf->Text(47,198,'X',0,1); } //MARCA DE SERVICIO
          if ($registro['tipo_derecho']== 'C') { $pdf->Text(47,204,'X',0,1); } //MARCA COLECTIVA
          if ($registro['tipo_derecho']== 'D') { $pdf->Text(102,198,'X',0,1); } //DENOMINACION DE ORIGEN   

      // Datos del Lema
	  $res_lema=pg_exec("SELECT * FROM stmlemad WHERE nro_derecho = '$nderec'");
          $reg_reglem = pg_fetch_array($res_lema);  
          $pdf->Text(165,197,$reg_reglem['solicitud_aso'].$reg_reglem['registro_aso'],0,1); 
          $pdf->Setfont('Arial','B',7); 
          $pdf->Text(145,204,substr(trim($reg_reglem['nombre_sol']),0,40),0,1); 
          $pdf->Setfont('Arial','B',9); 

      // Datos de la prioridad
	  $res_prio=pg_exec("SELECT * FROM stzpriod  WHERE nro_derecho = '$nderec'");
          $reg_regprio = pg_fetch_array($res_prio);  
          $pdf->Text(120,45,$reg_regprio['prioridad'],0,1); 
          $pais_nombre=pais($reg_regprio['pais_priori']);
          $pdf->Text(72,45,$pais_nombre,0,1);       
          $pdf->Text(170,45,$reg_regprio['fecha_priori'],0,1);       
          
      // Tipo de Clase
      	$res_clase=pg_exec("SELECT * FROM stmclnac WHERE  nro_derecho = '$nderec'");
          $reg_clase = pg_fetch_array($res_clase);  
          if ($reg_clase['clase_nac']==0) {$pdf->Text(57,212,'LC',0,1); } else {$pdf->Text(57,212,$reg_clase['clase_nac'],0,1); }
          $pdf->Text(118,212,$reg_marce['clase'],0,1);   

      // Tipo de Producto
          //if ($reg_marce['ind_producto']== 'N') { $pdf->Text(57,204,'X',0,1); } //Producto Nacional      
          //if ($reg_marce['ind_producto']== 'E') { $pdf->Text(102,204,'X',0,1); } //Producto Extranjero     
          //if ($reg_marce['ind_producto']== 'E') { $pdf->Text(57,204,'X',0,1);
//                                                  $pdf->Text(102,204,'X',0,1); } //Ambos  
//          $pais_nombre=pais($registro['pais_resid']);   
//	  $pdf->Text(150,203, $pais_nombre); //pais de residencia          
                           
      // Signo  o Nombre de la Marca
          if ($ind_logo== 1) { 
             $vsol1=substr($nsolic,-11,4);
             $vsol2=substr($nsolic,-6,6);
             $varsol=$vsol1.$vsol2;
             $imag ="../graficos/marcas/ef".$vsol1."/".$varsol.".jpg"; 
             $pdf->Image("$imag",10,224,55,45,'jpg');
          }     
          else {
   	    $pdf->SetXY(12,245);
            $pdf->MultiCell(50,4,trim($registro['nombre']),0,'C',0); //nombre
            $pdf->Setfont('Arial','B',9); 
          }
      
      // Distingue
  	  $pdf->SetXY(72,224);
  	  $num_letras=strlen(trim($reg_marce['distingue'])); 

	  if ($num_letras>1000)
	  {
           //no corta la palabra lo deja en el espacio anterior del limite
             $str = trim(substr($reg_marce['distingue'],0,1000));
             $str = $str.' ***';
             $pdf->MultiCell(130,4,utf8_decode($str),0,'J'); 
          }
          if ($num_letras<1000) { $pdf->MultiCell(130,4,utf8_decode($reg_marce['distingue']),0,'J',0); }   	  
  	  
      // Anexos	 
         $vsol1=substr($nsolic,-11,4);
         $vsol2=substr($nsolic,-6,6);
         $varsol=$vsol1.$vsol2;
         $name ="../documentos/poder/ef".$vsol1."/".$varsol.".pdf"; 
         if (file($name)) { $pdf->Text(136,302,'X',0,1); } // poder
         
         $name ="../documentos/reglamento/ef".$vsol1."/".$varsol.".pdf"; 
         if (file($name)) { $pdf->Text(136,306,'X',0,1); }  // reglamento uso de marca     
         
         $name ="../documentos/prioridad/ef".$vsol1."/".$varsol.".pdf"; 
         if (file($name)) { $pdf->Text(136,311,'X',0,1); } // documento  de prioridad  
         
         $name ="../documentos/certificado/ef".$vsol1."/".$varsol.".pdf"; 
         if (file($name)) { $pdf->Text(136,316,'X',0,1); } // certificado de registro ext. 

         $pdf->Text(136,320,'X',0,1);  // comprobante de pago de tasa
                  
         $name ="../documentos/mercantil/ef".$vsol1."/".$varsol.".pdf"; 
         if (file($name)) { $pdf->Text(201,295,'X',0,1); } //registro mercantil               

         $name ="../documentos/asamblea/ef".$vsol1."/".$varsol.".pdf"; 
         if (file($name)) { $pdf->Text(201,306,'X',0,1); } // acta ultima asamblea

         $name ="../documentos/cedula/ef".$vsol1."/".$varsol.".pdf"; 
         if (file($name)) { $pdf->Text(201,310,'X',0,1); } // copia de ci
                 
         $name ="../documentos/rif/ef".$vsol1."/".$varsol.".pdf"; 
         if (file($name)) { $pdf->Text(201,313,'X',0,1); } //copia de rif  

         if ($ind_logo== 1) { $pdf->Text(170,325,'X',0,1); } // busqueda grafica      
         else  { $pdf->Text(170,321,'X',0,1); } // busqueda fonetica
         
         $name ="../documentos/otros/ef".$vsol1."/".$varsol.".pdf"; 
         if (file($name)) { $pdf->Text(170,325,'X',0,1); } // documento  
             
    $pdf->Text(5,334,'Nombre del Funcionario (SAPI): '.$nombre_usuario,0,1);
//    $pdf->Text(5,332,$nombre_usuario,0,1);
//    $pdf->Text(85,333,'Firma del Funcionario',0,1);
//    $pdf->Text(170,329,'Sello',0,1);

   //Hoja Adicional de Formulario datos extras
    //Datos del solicitante
    if ($ind_titular== 1) {
       $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzsolic.identificacion, stzsolic.indole, stzsolic.telefono1, stzsolic.telefono2, stzsolic.fax, stzsolic.email, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       			      FROM stzottid, stzsolic 
       			      WHERE stzottid.nro_derecho='$nderec'
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
	  $pais_nombre2=pais($regt['pais_domicilio']);
       if (substr($regt['identificacion'],0,1)=='G' or substr($regt['identificacion'],0,1)=='J' or substr($regt['identificacion'],0,1)=='V' or
           substr($regt['identificacion'],0,1)=='E' or substr($regt['identificacion'],0,1)=='P') {
           $pdf->MultiCell(120,4,"Cedula,Pasaporte o Rif: ".$regt['identificacion']); }
//	  $pdf->MultiCell(120,4,"Cedula,Pasaporte o Rif: ".$regt['identificacion']); //cedula
	  $pdf->MultiCell(120,4,utf8_decode("Nombre(s) Apellidos o Razón Social: ").$regt['nombre']);  //nombre
	  $pdf->MultiCell(0,4,"Domicilio: ".$regt['domicilio'],0,'J',0); //domicilio
	  $pdf->MultiCell(120,4,"Pais de Domicilio: ".$pais_nombre2);  //pais domicilio
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
                             WHERE stzautod.nro_derecho='$nderec'
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
   	       	  $pdf->MultiCell(120,4,utf8_decode("Código de Agente: ").$regage['agente']); //nro agente	     
	          $pdf->MultiCell(120,4,"Cedula: ".$regage['cedula']);  //cedula
      	       	  $pdf->MultiCell(120,4,utf8_decode("Nombre(s) Apellidos o Razón Social: ").$regage['nombre']);   //nombre
               	  $pdf->MultiCell(120,4,"Domicilio: ".$regage['domicilio'],0,'J',0); //domicilio
               	  $pais_nombre=pais($regage['nacionalidad']); 
                      $pais_nombre2=pais($regage['pais_domicilio']); 
	       	  $pdf->MultiCell(120,4,"Pais de Domicilio: ".$pais_nombre2); //pais de domicilio
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
     if ($num_letras>1000)
     {     
      if ($ind_pag != 1){ 
          $pdf->AddPage(); 
          $ind_pag = 1; 
          $fil=14; $inc=4; 
          $pdf->SetXY(14,14);}
       $str = trim(substr($reg_marce['distingue'],1000,3000));
       $pdf->Setfont('Arial','BUI',9);    
       $pdf->Multicell(120,4,utf8_decode('Continuación del Distingue '));        
       $pdf->Setfont('Arial','',9);  
       $pdf->MultiCell(180,4,utf8_decode($str),0,'J');  
     }  
   
//   if  ($cont+1!=$filas_resultado) {$pdf->AddPage();}    
         
//} //fin del for inicial

$sql->disconnect();

ob_end_clean();      
//Salida del Reporte
$pdf->Output("/var/www/apl/sipi/documentos/planilla/pl$vsol1/$varsol.pdf");
//$pdf->Output("$varsol.pdf");  
$pdf->Output();  

//}
       
?>
