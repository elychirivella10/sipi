<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");

//Table Base Classs
//include ("$include_lib/jlpdf_pres.php");
require ("$include_lib/PDF_tablebol.php");
require("$include_lib/MPDF45/mpdf.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$fecha = fechahoy();
$fechahoy = hoy();

//Pantalla Titulos
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Solicitudes Formato Bolet&iacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Solicitudes Formato Boletín";

//Validacion de Entrada
//$fecsold=$_POST["fecsold"];
//$fecsolh=$_POST["fecsolh"];
//$usuario=$_POST["usuario"];
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];
$vsol1h=$_POST["vsol1h"];
$vsol2h=$_POST["vsol2h"];
$registrod1=$_POST["vreg1d"];
$registroh1=$_POST["vreg2d"];
$registrod2=$_POST["vreg1h"];
$registroh2=$_POST["vreg2h"];
$estatus=$_POST["estatus"];

$vsold=($vsol1.'-'.$vsol2);
$vsolh=($vsol1h.'-'.$vsol2h);

$registrod= $registrod1.$registroh1;
$registroh= $registrod2.$registroh2;

if ($vsolh <$vsold){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Verificacion del rango de fechas
//$esmayor=compara_fechas($fecsold,$fecsolh);
//if ($esmayor==1) {
//     $smarty->display('encabezado1.tpl');
//     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
//     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Conexion a la base de datos  
$sql = new mod_db();
$sql->connection($login);

$desc_est = estatus($estatus);
$titulo='';
$titulo1= " ESTATUS: ".($estatus-2000)." - ".$desc_est;

//Inicio del Pdf
$pdf=new PDF_Tablebol('P','mm','Letter');
$pdf->Open();
$pdf->AliasNbPages();

// Armando el query segun las opciones
$counter= 1;
$tipo_derecho='A';
$titulo='PATENTES DE INVENCION';
$total = 0;
$where= "";
$totalrepor = 0;
while ( $counter <= 8) {

 $where = "stzderec.tipo_mp='P' ";
 $where = $where." and (stzderec.estatus='$estatus')";

 $punt=0;
 if ($vsold == "-") { $punt=1; }
 if ($vsolh == "-") { $punt=1; }

 if (($punt!=1) and (!empty($vsold) and !empty($vsolh))) { 
 	$where = $where." and ((stzderec.solicitud >= '$vsold') and (stzderec.solicitud <='$vsolh'))"; 
   $titulo= $titulo." Desde Solicitud:"." $vsold"." Hasta:"." $vsolh";
   $orderby = 'stzderec.solicitud';
 }

 if(!empty($registrod) and !empty($registroh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzderec.registro >= '$registrod') and (stzderec.registro <='$registroh'))";
 	   $titulo= $titulo." Desde Registro:"." $registrod"." Hasta:"." $registroh";
	}
	else { 
		$where = $where." ((stzderec.registro >= '$registrod') and (stzderec.registro <='$registroh'))";
 	   $titulo= $titulo." Desde Registro:"." $registrod"." Hasta:"." $registroh";
	}
  $orderby = 'stzderec.registro';
 }

 $where = $where." and stzderec.nro_derecho=stppatee.nro_derecho";
 $where = $where." and stzderec.tipo_derecho='$tipo_derecho'";

 // Armando el query
 $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.registro,stzderec.fecha_regis,stzderec.fecha_venc,stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stzderec.tipo_derecho,stzderec.estatus,stppatee.resumen
                     FROM stzderec, stppatee WHERE $where ORDER BY $orderby"); 
 //$que="counter=$counter , SELECT stzderec.solicitud,stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stzderec.tipo_derecho,stzderec.estatus,stppatee.resumen
 //                         FROM  stzderec, stppatee WHERE $where ORDER BY 1";
 //echo "$que";

 if (!$resultado)    { 
   $smarty->display('encabezado1.tpl');
   mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','pb_rptpsolpre.php','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 $filas_resultado=pg_numrows($resultado);
 echo "son $filas_resultado ";
 $totalrepor = $totalrepor + $filas_resultado;  
 //exit();
  
 if ($totalrepor==0)    {
   $smarty->display('encabezado1.tpl');
   mensajenew('ERROR: No existen Datos Asociados ...!!!','pb_rptpsolpre.php','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

 $registro = pg_fetch_array($resultado);
 $total= $filas_resultado;

 //$cantidad=pg_exec("SELECT  DISTINCT ON (stzderec.solicitud) stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stzderec.tipo_derecho,stzderec.estatus,stppatee.resumen 
 // FROM  stzderec, stppatee, stzevtrd 
 // WHERE $where "); 
 //$filas_res=pg_numrows($cantidad); 
 //$total=$filas_res;

 if ($total==0) {$mensaje= $mensaje.'  - No se genero Solicitadas '.$titulo;} 
 else { 

 // Montando los resultados en el formato boletin solicitadas
   $pdf->AddPage();
   $pdf->Setfont('Arial','B',20);
   $pdf->MultiCell(190,5,utf8_decode('REPORTE DE PATENTES PARA REVISION'),0,'C',0);
   $pdf->ln(4); 
   $pdf->MultiCell(190,5,utf8_decode(trim($titp_soli)),0,'C',0);
   $pdf->Setfont('Arial','',8);          
   $pdf->Setfont('Arial','B',12);
   $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
   $pdf->Setfont('Arial','B',8);
   $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);
   $pdf->Setfont('Arial','',8);
   $pdf->ln(3); 
   $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fechahoy)),0,'J',0);
   $pdf->Setfont('Arial','B',8);
   $pdf->MultiCell(190,5,utf8_decode($titulo).' '.$titulo1,0,'C',0);
   $pdf->Setfont('Arial','',8);
   $pdf->ln(4); 
     
   for($cont=0;$cont<$filas_resultado;$cont++) { 

     $nsolic=$registro['solicitud'];
     $nagen=$registro['agente'];
     $nderec=$registro['nro_derecho'];
     $nregistro = trim($registro['registro']);
     $vfreg = $registro['fecha_regis'];
     $vfven = $registro['fecha_venc'];
     $varsol1=substr($nsolic,-11,4);
     $varsol2=substr($nsolic,-6,6);
     $pdf->Setfont('Arial','B',12);
     $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);

     $pdf->Setfont('Arial','B',8);
     if (empty($nregistro)) {
       $pdf->MultiCell(135,5,'(21)'.'     '.$registro['solicitud'].' Tipo Patente: '.$registro['tipo_derecho'],0,'J',0); }
     else {
     	 $datos_reg = ' Tipo Patente: '.$registro['tipo_derecho'].' -  Registro No: '.$nregistro.', Fecha Reg: '.$vfreg;
       $pdf->MultiCell(135,5,'(21)'.'     '.$registro['solicitud'].$datos_reg,0,'J',0); }
     //imagen
     $pdf->Setfont('Arial','',8);
     $varsol1=substr($nsolic,-11,4);
     $varsol2=substr($nsolic,-6,6);
     $nameimage = "../graficos/patentes/di".$varsol1."/".$varsol1.$varsol2.".jpg";
     if (file($nameimage)) {   
	  $pdf->ln(1);
	  $x = $pdf->Getx();
	  $y = $pdf->Gety();
	  $pto = $y;
     $pdf->Image("$nameimage",160,$y,30,25,'JPG');
	  // $pdf->MultiCell(59,38,$pdf->Image("$nameimage",(150+3),$y,40,35,'JPG'),0,'J',0);
     }

     $pdf->MultiCell(135,5,'(22)'.'     '.$registro['fecha_solic'],0,'J',0);      
     //Prioridad
	  $cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
	  $reg_pri = pg_fetch_array($cons_pri);
	  $filas_cons_pri=pg_numrows($cons_pri);
	  $prioridad="";
	  for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	     $prioridad=$prioridad.trim($reg_pri['prioridad']).' '.trim($reg_pri['pais_priori']).', ';
	     $prioridad=$prioridad.trim($reg_pri['fecha_priori']).';  ';
     	     $reg_pri = pg_fetch_array($cons_pri);
          }
     $pdf->Cell(9,5,'(30)'.'     ',0,0);  
     $pdf->MultiCell(135,5,$prioridad,0,'J',0);
     //Clasificación internacional.
     $clasi="";
     $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
     $regclasf = pg_fetch_array($cons_clas);
     $filas_clasif=pg_numrows($cons_clas); 
     for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
          $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
          $regclasf = pg_fetch_array($cons_clas);     }
     //$pdf->MultiCell(135,5,'(51)'.'     '.$clasi,0,'J',0);
     $pdf->Cell(9,5,'(51)'.'     ',0,0);  
     $pdf->MultiCell(135,5,$clasi,0,'J',0);
          
     //Titular
	  $titular='';
  	  $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	  $filas_found1=pg_numrows($res_titular);
	  $regt = pg_fetch_array($res_titular);
	  for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
       //$pais_nombre=pais($res['nacionalidad']);
       $pais_nombre=pais($regt['nacionalidad']);
 	    if ($cont1=='0'){
 	      $pdf->Cell(9,5,'(73)'.'     ',0,0);
	 	   //$pdf->MultiCell(135,5,'(73)'.'     '.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).' Nacionalidad: '.$pais_nombre.'',0,'J',0); }
 		   $pdf->MultiCell(135,5,utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode($pais_nombre).'',0,'J',0); }	   
		 else {$pdf->Getx(25); 
		   //$pdf->MultiCell(135,5,utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).' Nacionalidad: '.utf8_decode($pais_nombre).'',0,'J',0); }                   
		   $pdf->Cell(9,5,'    '.'     ',0,0);
		   $pdf->MultiCell(135,5,utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode($pais_nombre).'',0,'J',0); }                   
	    $regt = pg_fetch_array($res_titular);
	  }
	  //$pdf->MultiCell(135,5,utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode($pais_nombre).'',0,'J',0); }                   
   
     //Inventores
      $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
      $reg_inv = pg_fetch_array($cons_inv);
      $filas_cons_inv=pg_numrows($cons_inv);
      $inventores="";
      for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
         //$inventores=$inventores.utf8_decode(trim($reg_inv['nombre_inv']))."; ";
         if (empty($inventores)) { $inventores=$inventores.utf8_decode(trim($reg_inv['nombre_inv'])); }
         else { $inventores=$inventores."; ".utf8_decode(trim($reg_inv['nombre_inv'])); } 
         $reg_inv = pg_fetch_array($cons_inv);
      }
      $pdf->Cell(9,5,'(72)'.'     ',0,0);  
      $pdf->MultiCell(135,5,$inventores,0,'J',0);  
      //Tramitante o Agente         
      $ind=1;
      $tram = agente_tram($registro['agente'],$registro['tramitante'],$ind);     
      $pdf->MultiCell(135,5,'(74)'.'     '.utf8_decode($tram),0,'J',0);        
      //Titulo de la patente
      $pdf->Cell(9,5,'(54)'.'     ',0,0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(135,5,utf8_decode(trim($registro['nombre'])),0,'J',0);    
      $pdf->Setfont('Arial','',8);

      //Resumen 
      if ($estatus==2006) { 
        $pdf->Cell(9,5,'(57)'.'     ',0,0);  
        $resumen = mb_strtoupper(utf8_decode(trim($registro['resumen'])));
        $pdf->MultiCell(135,5,$resumen,0,'J',0); 
      }

    $registro = pg_fetch_array($resultado);

  }
  $pdf->Setfont('Arial','B',12);
  $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(6); 
  $pdf->MultiCell(190,5,'Total de Solicitudes: '.$total,0,'L',0);
  $pdf->ln(4); 
 } //fin del else si no hay resultado (filas_resultado)
 $counter = $counter + 1; 
 if($counter==2) { $tipo_derecho='C'; $titulo='PATENTES DE MEJORAS';}
 if($counter==3) { $tipo_derecho='E'; $titulo='PATENTES DE MODELO INDUSTRIAL';}
 if($counter==4) { $tipo_derecho='G'; $titulo='PATENTES DE DISEÑO INDUSTRIAL';}
 if($counter==5) { $tipo_derecho='B'; $titulo='PATENTES DE DIBUJO INDUSTRIAL';}
 if($counter==6) { $tipo_derecho='D'; $titulo='PATENTES DE INTRODUCCIÓN';}
 if($counter==7) { $tipo_derecho='F'; $titulo='PATENTES DE MODELOS DE UTILIDAD';}
 if($counter==8) { $tipo_derecho='V'; $titulo='PATENTES DE VARIEDADES VEGETALES';}
}//fin del while

//Desconexion a la base de datos
$sql->disconnect();
ob_end_clean(); 

//Salida del Reporte
$pdf->Output();
//$pdf->Output("../respaldoboletin/rptestatus.pdf");

?>
