<?php
// *************************************************************************************
// Programa: z_rptpubprensa.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPIPN
// Año: 2017 I Semestre
// Modificado Año 2018 II Semestre
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");

//Table Base Classs
include ("$include_lib/jlpdf_prensa.php");
require ("$include_lib/PDF_tablepres.php");
require("$include_lib/MPDF45/mpdf.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$fecha = fechahoy();
$fechahoy  = hoy();
$horactual = hora();
$rutafinal = "/var/www/apl/sipi/respaldo_periodico/";

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Solicitudes a Publicar en Prensa Digital SAPI');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Hora para acceso al modulo y poder generar las solicitudes de prensa Internas y del WEBPI 
$horactual= date("Ymd H:i:s A"); 
//$horactual= date("Ymd")." 15:30:00 PM"; 
$horatope2 = date("Ymd")." 07:30:00 AM";
$horatope3 = date("Ymd")." 11:30:00 AM";

//$horatope3 = date("Ymd")." 09:30:00 AM";


$horatope4 = date("Ymd")." 11:10:00 AM";
$horatope5 = date("Ymd")." 14:30:00 PM";
$horatope6 = date("Ymd")." 15:40:00 PM";
$hora1=$horactual;
$hora2=$horatope2;
$hora3=$horatope3;
$hora4=$horatope4;
$hora5=$horatope5;
$hora6=$horatope6;

////echo " $hora1 - $hora2 ";
//if(($hora1 > $hora2) AND ($hora1 < $hora3)) { }
//else {
//  if(($hora1 > $hora4) AND ($hora1 < $hora5)) { }
//  else {	
//    if($hora1 > $hora6) { }
//    else {	
//      $smarty->display('encabezado1.tpl');
//      echo "<br><br><br><br><br>";
//      echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
//      echo "   <tr>";
//      echo "     <td colspan='2' height='60'>";
//      echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
//      echo "     </td>";
//      echo "     <td colspan='2' height='60'>";
//      echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>AVISO: La Hora tope para hacer uso de esta Opci&oacute;n del Sistema diariamente es entre las: 07:30:00 AM y las 09:30:00 AM, 11:10:00 AM y 02:30:00 PM, y despues de las 03:40:00 PM  ...!!!<br><br><font color='#FFFF00'></b></font>";
//      echo "       </div>";
//      echo "     </td>";
//      echo "   </tr>";
//      echo "</table>";
//      echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='javascript:history.back();' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
//      echo "<div align='center'>";
//      echo "<tr><td>&nbsp;</td></tr>";
//      echo "<tr><td>&nbsp;</td></tr>";
//      echo "<br><br><br><br><br><br><br>";
//      $smarty->display('pie_pag.tpl');   
//      echo "</div>";
//      exit();
      //mensajenew('AVISO: La Hora tope para hacer uso de esta Opci&oacute;n del Sistema diariamente es entre las: 07:30:00 AM y las 09:30:00 AM, 11:30:00 AM y 02:30:00 PM, y despues de las 03:40:00 PM  ...!!!','javascript:history.back();','N');
      //$smarty->display('pie_pag.tpl'); exit();
//    }
//  }  
//} 

//echo " $hora1 - $hora2 - $hora3 - $hora4 - $hora5";
//exit();
//if($hora1 > $hora2) {
//  mensajenew('AVISO: La Hora tope para hacer uso de esta Opci&oacute;n del Sistema diariamente es antes de las 09:30:00 AM  ...!!!','javascript:history.back();','N');
//  $smarty->display('pie_pag.tpl'); exit();
//}

//$fechagenera = date("Y-m-d"); echo " $fechagenera, ";
//$diafechagenera = date("w", $fechagenera); echo " $diafechagenera, ";
//if ($diafechagenera==5) { $date2=date("d/m/Y", strtotime ("+2days")); echo "sumo 2"; }
//else { $date2=date("d/m/Y", strtotime ("+1days")); echo "sumo 1"; }
//$fechapub = Cambiar_fecha_mes($date2);
//if ($diafechagenera==5) { $diasem=1; } 
//else { $diasem=$diafechagenera+1; }

//switch ($diasem) { 
//    case 0: $dialtr= "Domingo"; break; 
//    case 1: $dialtr= "Lunes"; break; 
//    case 2: $dialtr= "Martes"; break; 
//    case 3: $dialtr= "Miercoles"; break; 
//    case 4: $dialtr= "Jueves"; break; 
//    case 5: $dialtr= "Viernes"; break; 
//    case 6: $dialtr= "Sabado"; break; 
//}  
//$fechaprensa= " Caracas, ".$dialtr.', '.$fechapub;
$fechaprensa="";

//PDF Encabezados
$encab_principal= "Sistema de Marcas/Patentes";
$encabezado= "Solicitudes a Publicar en Prensa SAPI";

//Validacion de Entrada
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$horactual= Hora();

// Verificacion de que los campos requeridos esten llenos...
if(empty($fecsold)) { 
  $smarty->display('encabezado1.tpl');
  mensajenew("ERROR: Dejo la Fecha Vacia ...!!!","z_publiprensa.php","N");
  $smarty->display('pie_pag.tpl'); exit(); }

$diag = substr($fecsold, 0, 2);
$mesg = substr($fecsold, 3, 2);
$anog = substr($fecsold, 6, 4);
$fechaprensa = $diag.$mesg.$anog;

$dia = substr($fechahoy, 0, 2);
$mes = substr($fechahoy, 3, 2);
$ano = substr($fechahoy, 6, 4);
$fechagen = $dia.$mes.$ano;
$horagen = substr($horactual,0,8).substr($horactual,9,2);
$vnomprensa= "periodico".$fechaprensa."_".$fechagen."_".$horagen.".pdf";
$archivo = $rutafinal.$vnomprensa;

//echo " $fecsold - $fecsolh "; exit();
//Query para buscar las opciones deseadas
//$where='stzderec.estatus IN (1002,1004,1005) AND stzevtrd.evento=1021 ';
$where='stzderec.estatus IN (1004,1005,1008,1104) AND stzevtrd.evento IN (1201,1089,1169) ';
$titulo='';

// Verificacion de que los campos requeridos esten llenos...
/*
  $req_fields = array("fecsold","fecsolh");
  $valores = array($fecsold,$fecsolh);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("ERROR: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Verificacion del rango de fechas
$esmayor=compara_fechas($fecsold,$fecsolh);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
*/

//Verificacion del rango de fechas
$esmayor=compara_fechas($fecsold,$fechahoy);

if ($fecsold==$fechahoy) {
     $smarty->display('encabezado1.tpl');
     mensajenew("ERROR: NO puede Generar el Periodico del Mismo Día ->".$fechahoy.", Este debe ser generado al Dia Siguiente ...!!!","z_publiprensa.php","N");    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

/*
//if(!empty($fecsold)) { 
//	if(!empty($where)) {
//	   $where = $where." and"." (stmpagopren.fecha_publi = '$fecsold')";
//	   $titulo= $titulo." DEL: "." $fecsold";
//	}
//	else { 
//		$where = $where." (stmpagopren.fecha_publi = '$fecsold')";
//      $titulo= $titulo." DEL: ".$fecsold;
//	}
//}
*/

/*
if(!empty($fecsold) and !empty($fecsolh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stmpagopren.fecha_publi >= '$fecsold') and (stmpagopren.fecha_publi <='$fecsolh'))";
	   $titulo= $titulo." DESDE:"." $fecsold"." HASTA:"." $fecsolh";
	}
	else { 
		$where = $where." ((stmpagopren.fecha_publi >= '$fecsold') and (stmpagopren.fecha_publi <='$fecsolh'))";
      $titulo= $titulo." DESDE:".$fecsold." HASTA:".$fecsolh;
	}
}
*/
if(!empty($fecsold)) { 
  if(!empty($where)) {
     $where = $where." and"." (stmpagopren.fecha_publi = '$fecsold')";
     $titulo= $titulo." DEL:"." $fecsold";
  }
  else { 
    $where = $where." (stmpagopren.fecha_publi = '$fecsold')";
      $titulo= $titulo." DEL: ".$fecsold;
  }
}

$where = $where." and stzderec.nro_derecho=stmpagopren.nro_derecho";
$where = $where." and stmpagopren.nro_derecho=stmmarce.nro_derecho";
$where = $where." and stmpagopren.nro_derecho=stzevtrd.nro_derecho";
$where = $where." and stzderec.tipo_mp='M'";
$where = $where." and stmpagopren.publicada IN ('N','S')";
$where = $where." and stmpagopren.estatus IN ('C','G','P')";
//$where = $where." and stmpagopren.hora_carga <='01:30:00 PM'";

//if(!empty($fecsold) and !empty($fecsolh)) { 
//	if(!empty($where)) {
//	   $where = $where." and"." ((stzderec.fecha_solic >= '$fecsold') and (stzderec.fecha_solic <='$fecsolh'))";
//	   $titulo= $titulo." DESDE:"." $fecsold"." HASTA:"." $fecsolh";
//	}
//	else { 
//		$where = $where." ((stzderec.fecha_solic >= '$fecsold') and (stzderec.fecha_solic <='$fecsolh'))";
//     $titulo= $titulo." DESDE:".$fecsold." HASTA:".$fecsolh;
//	}
//}

//$where = $where." and stzderec.nro_derecho=stmmarce.nro_derecho";
//$where = $where." and stzderec.nro_derecho=stzevtrd.nro_derecho";
//$where = $where." and stzderec.tipo_mp='M'";

//Conexion a la base de datos  
$sql = new mod_db();
$sql->connection($login);

//Direccion IP de la Maquina
$dirIP = getRealIP(); 

//Conteo Total de Solicitudes Marcas con fecha de Publicacion en el rango indicado 
//$objquerypm = $sql->query("SELECT solicitud FROM stmpagopren WHERE (stmpagopren.fecha_publi>='$fecsold') AND (stmpagopren.fecha_publi<='$fecsolh')");
$objquerypm = $sql->query("SELECT solicitud FROM stmpagopren WHERE stmpagopren.fecha_publi='$fecsold'");
$objfilpm = $sql->nums('',$objquerypm);

//Conteo Total de Solicitudes Patentes con fecha de Publicacion en el rango indicado
//$objquerypp = $sql->query("SELECT solicitud FROM stppagopren WHERE (stppagopren.fecha_publi>='$fecsold') AND (stppagopren.fecha_publi<='$fecsolh')");
$objquerypp = $sql->query("SELECT solicitud FROM stppagopren WHERE stppagopren.fecha_publi='$fecsold'");
$objfilpp = $sql->nums('',$objquerypp);

// Tabla Auditoria de Periodico Generado 
$columnas_str = "fecha_gen,hora_gen,usuario_gen,direccion_ip,fecha_ini,fecha_fin,totalm_gen,totalp_gen";
//$insert_str = "'$fechahoy','$horactual','$login','$dirIP','$fecsold','$fecsolh','$objfilpm','$objfilpp'"; 
$insert_str = "'$fechahoy','$horactual','$login','$dirIP','$fecsold','$fecsold','$objfilpm','$objfilpp'"; 
$insaud = $sql->insert("stzaudipren","$columnas_str","$insert_str","");

//Publicaciones en Prensa Marcas
// Armando el query Marcas
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue,stzderec.tipo_derecho,stzderec.estatus,stmpagopren.hora_carga
 FROM  stzderec, stmmarce, stzevtrd, stmpagopren 
 WHERE $where ORDER BY 1"); 

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','z_publiprensa.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_foundm=pg_numrows($resultado); 
//if ($filas_found==0)    {
//     $smarty->display('encabezado1.tpl');
//     mensajenew('ERROR: No existen Datos Asociados ...!!!','z_publiprensa.php','N');
//     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$filasm = pg_numrows($resultado); 

$cantidad=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue,stzderec.tipo_derecho,stzderec.estatus 
 FROM  stzderec, stmmarce, stzevtrd, stmpagopren 
 WHERE $where "); 

$filas_res=pg_numrows($cantidad); 
$total=$filas_res;
$horactual=hora();

if ($filasm!=0) {
  //Inicio del Pdf
  header('Content-type: application/pdf'); 
  $pdf=new JLPDF('P','mm','Letter');
  $pdf->Open();
  $pdf->AliasNbPages();
}

if ($filas_resultado==0) {
  $mensaje= $mensaje.'* No se genero Solicitadas  ';
} 
else {
   $pdf->AddPage();
   // Montando los resultados en el formato boletin solicitadas
   $pdf->Setfont('Arial','B',10);
   $pdf->MultiCell(190,5,utf8_decode('MARCAS'),0,'C',0);
   $pdf->ln(6); 
     
   for($cont=0;$cont<$filas_resultado;$cont++) { 
      $nsolic=$registro['solicitud'];
      $nagen=$registro['agente'];
      $nderec=$registro['nro_derecho'];
      $ntipom=$registro['tipo_derecho'];
      $modalidad= $registro['modalidad'];
      $clase= $registro['clase'];
      $tipomarca = tipo_marca($ntipom);
      
      switch ($ntipom) {
        case "M":
          $tipomarca="de la ".$tipomarca;
          break;
        case "P":
          $tipomarca="de la ".$tipomarca;
          break;
        case "N":
          $tipomarca="del ".$tipomarca;
          break;
        case "L":
          $tipomarca="del ".$tipomarca;
          break;
        case "S":
          $tipomarca="de la ".$tipomarca;
          break;
        case "C":
          $tipomarca="de la ".$tipomarca;
          break;
        case "D":
          $tipomarca="de la ".$tipomarca;
          break;
        case "O":
          $tipomarca="de la ".$tipomarca;
          break;
      }
      
      //Obtención de la clase nacional de la Marca 
      $obj_query = $sql->query("SELECT * FROM stmclnac WHERE nro_derecho='$nderec'");
      $objs = $sql->objects('',$obj_query);
      $vclnac    = $objs->clase_nac;
      
      $x = $pdf->Getx();
      $y = $pdf->Gety();
      if ($y >= 245) {  $pdf->AddPage(); }
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,4,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR DE COMERCIO NACIONAL - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,utf8_decode('De conformidad con el artículo 76 de la Ley de Propiedad Industrial, se ordena la publicación '.$tipomarca.' siguiente:'),0,'C',0);
      $pdf->ln(2); 
      $pdf->MultiCell(135,4,utf8_decode('Inscripción: '). $registro['solicitud'],0,'J',0);
      $pdf->MultiCell(135,4,utf8_decode('Presentada en Caracas, ').Cambiar_fecha_mes($registro['fecha_solic']),0,'J',0);
      $pdf->Setfont('Arial','',8);
      if ($modalidad == 'M') { //Nombre de la marca en caso de que sea mixta
        $texto_nombre= "[b]Nombre de la Marca:  [/b] ".trim(utf8_decode($registro['nombre']));
        //$pdf->JLCell("$texto_nombre",135,'j');       
        //  $pdf->MultiCell(135,4,'NOMBRE DE LA MARCA: '.trim(utf8_decode($registro['nombre'])),0,'J',0); 	 
      } 
                     
    	//busqueda del titular y sus datos
	   $titular='';
  	   $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.pais_domicilio, stzottid.domicilio
                              FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                     AND stmmarce.nro_derecho=stzottid.nro_derecho
                              AND stzsolic.titular = stzottid.titular");
	   $filas_found1=pg_numrows($res_titular);
	   $regt = pg_fetch_array($res_titular);
	   for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	     $pais_nombre=pais($regt['pais_domicilio']);
 	     if ($cont1=='0'){
	       $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	     else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	     $regt = pg_fetch_array($res_titular);
	   } 
	
      $y = $pdf->Gety(); 
      //  $texto= $pdf->Setfont('Arial','B',8)."SOLICITADA POR: ".$pdf->Setfont('Arial','',9);
      //  $pdf->MultiCell(135,4,$texto.utf8_decode($titular),0,'J',0); 
      $texto_titular= "[b]Solicitada por:   "."[/b] ".$titular;
      $pdf->JLCell("$texto_titular",135,'j');
      //$texto_domicilio= "[b]Domicilio:   "."[/b] ".$domicilio;
      //$pdf->JLCell("$texto_domicilio",135,'j');

      //imagen
		$varsol1=substr($nsolic,-11,4);
		$varsol2=substr($nsolic,-6,6);
		$nameimage=ver_imagen($varsol1,$varsol2,'M');

      if (($modalidad=='M') || ($modalidad=='G')) { 
  		  if (file($nameimage)) {   
	       $x = $pdf->Getx();
          $y = $pdf->Gety();
	  	    if ($y >= 240) {
		      $pdf->AddPage();
	         //$pdf->Image("$nameimage",160,15,26,24,'JPG');
	         $pdf->Image("$nameimage",160,15,30,30,'JPG');
            $y = $pdf->Gety(); 	
            $pdf->SetXY($x,$y+5); 		 
          }
          else{	
            //$pdf->Image("$nameimage",160,$y,26,24,'JPG');
            $pdf->Image("$nameimage",160,$y,30,30,'JPG');
            $y = $pdf->Gety(); 	
            $pdf->SetXY($x,$y+12); 
		    }
		  }
        else {	
   	    $pdf->Setfont('Arial','B',8);
   	    $numbol = $nbol;
   	    $x = 150;
   	    $y = $pdf->Gety(); 
   	    $pdf->SetXY(150,$y+1);
    	    $pdf->MultiCell(50,4,trim(utf8_decode($registro['nombre'])),0,'C',0);  
	       $pdf->Setfont('Arial','',8);
   	  } 
      }
      if ($modalidad=='D') { 
   	  $pdf->Setfont('Arial','B',8);
   	  $numbol = $nbol;
   	  $x = 150;
   	  $y = $pdf->Gety(); 
   	  $pdf->SetXY(150,$y+1);
    	  $pdf->MultiCell(50,4,trim(utf8_decode($registro['nombre'])),0,'C',0);  
	     $pdf->Setfont('Arial','',8);
 	   } 
      
         	
   	//busqueda del distingue
	  $pdf->Setfont('Arial','',8);
	
	  if ($clase == 46) { $clase='NC';}
	  if ($clase == 47) { $clase='LC';}			
     $texto_clase= '[b]Clase Internacional: '.$clase.' [/b] ';
     $pdf->JLCell("$texto_clase",135,'j');        
     $texto_clasen= '[b]Clase Nacional: '.$vclnac.' [/b] ';
     $pdf->JLCell("$texto_clasen",135,'j');        
     $distingue= trim(mb_strtoupper(utf8_decode($registro['distingue'])));
     $texto_distingue= "[b]Para Distinguir:   "."[/b] ".$distingue;
     $pdf->JLCell("$texto_distingue",135,'j');       
     $pdf->ln(3); 
     $pdf->MultiCell(190,5,'Registrador(a) de la Propiedad Industrial',0,'C',0);
     $update_str = "fecha_gene='$fechahoy',hora_gene='$horactual',estatus='G',publicada='S'";
     $updpagoprensa = $sql->update("stmpagopren","$update_str","nro_derecho='$nderec' AND fecha_publi='$fecsold'");
     $registro = pg_fetch_array($resultado);
  }
 
  // Fin de Pagina (Firma del Registrador)
  $pdf->ln(6); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,'Total de Solicitudes Marcas Publicadas : '.$total,0,'J',0);
  $pdf->ln(6); 

  //ob_end_clean(); 
  //Salida del Reporte
  //$pdf->Output();
        
} // fin de publicacion Marcas

//Publicaciones en Prensa Patentes
//Query para buscar las opciones deseadas
$where='stzderec.estatus IN (2004,2005,2011,2012) AND stzevtrd.evento IN (2201,2022,2023,2031,2089) ';
$titulo='';

/*
if(!empty($fecsold) and !empty($fecsolh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stppagopren.fecha_publi >= '$fecsold') and (stppagopren.fecha_publi <='$fecsolh'))";
	   $titulo= $titulo." DESDE:"." $fecsold"." HASTA:"." $fecsolh";
	}
	else { 
		$where = $where." ((stppagopren.fecha_publi >= '$fecsold') and (stppagopren.fecha_publi <='$fecsolh'))";
      $titulo= $titulo." DESDE:".$fecsold." HASTA:".$fecsolh;
	}
}
*/
if(!empty($fecsold)) { 
  if(!empty($where)) {
     $where = $where." and"." ((stppagopren.fecha_publi = '$fecsold'))";
     $titulo= $titulo." DEL:"." $fecsold";
  }
  else { 
    $where = $where." ((stppagopren.fecha_publi = '$fecsold'))";
      $titulo= $titulo." DEL: ".$fecsold;
  }
}

$where = $where." and stzderec.nro_derecho=stppagopren.nro_derecho";
$where = $where." and stppagopren.nro_derecho=stppatee.nro_derecho";
$where = $where." and stppagopren.nro_derecho=stzevtrd.nro_derecho";
$where = $where." and stzderec.tipo_mp='P'";
$where = $where." and stppagopren.publicada IN ('N','S')";
$where = $where." and stppagopren.estatus IN ('C','G','P')";

//$where = $where." and stppagopren.hora_carga <='01:30:00 PM'";

//Publicaciones en Prensa PATENTES
// Armando el query Patentes 
$resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud, stzderec.nombre,stzderec.tipo_derecho,stzderec.nro_derecho,stzderec.fecha_solic,stppatee.resumen,stppagopren.hora_carga
FROM  stzderec, stppatee, stppagopren, stzevtrd
WHERE $where
ORDER BY 1");

//$query = "SELECT stzderec.solicitud, stzderec.nombre,stzderec.tipo_derecho,stzderec.nro_derecho,stzderec.fecha_solic,stppatee.resumen,stppagopren.hora_carga
//FROM  stzderec, stppatee, stppagopren, stzevtrd WHERE $where ORDER BY 1";
//echo "$query"; 
//exit();

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;
$horactual=hora();
$filasp = pg_numrows($resultado); 

if ($filas_resultado==0) { $mensaje= $mensaje.'  - No se genero Solicitadas '; } 
else { 
   if ($filasm==0) {
     //Inicio del Pdf
     header('Content-type: application/pdf'); 
     $pdf=new JLPDF('P','mm','Letter');
     $pdf->Open();
     $pdf->AliasNbPages();
   }
   // Montando los resultados en el formato boletin solicitadas
   $pdf->AddPage();
   $pdf->Setfont('Arial','B',10);
   $pdf->MultiCell(190,5,utf8_decode('PATENTES'),0,'C',0);
   $pdf->ln(6); 
   for($cont=0;$cont<$filas_resultado;$cont++) { 
     $nsolic=$registro['solicitud'];
     $nderec=$registro['nro_derecho'];
     $varsol1=substr($nsolic,-11,4);
     $varsol2=substr($nsolic,-6,6);
     $ntipop=$registro['tipo_derecho'];
     $tipopatente = tipo_patente($ntipop);
     if ($ntipop=='G') { $tipopatente = 'DISEÑO INDUSTRIAL'; }

     $update_str = "fecha_gene='$fechahoy',hora_gene='$horactual',estatus='G',publicada='S'";
     $updpagoprensa = $sql->update("stppagopren","$update_str","nro_derecho='$nderec' AND fecha_publi='$fecsold'");
     
     $pdf->Setfont('Arial','B',12);
     $pdf->MultiCell(190,4,'_______________________________________________________________________________',0,'J',0);
     $pdf->Setfont('Arial','B',8);
     $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR DE COMERCIO NACIONAL - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);
     $pdf->ln(2); 
     $pdf->MultiCell(190,5,utf8_decode('De conformidad con el artículo 60 de la Ley de Propiedad Industrial, se ordena la publicación de la solicitud de patente de ').utf8_decode($tipopatente).utf8_decode(' que a continuación se especifica:'),0,'J',0);
     $pdf->ln(2); 
     $pdf->MultiCell(135,4,utf8_decode('Inscripción: '). $registro['solicitud'],0,'J',0);
     $pdf->MultiCell(135,4,utf8_decode('Presentada en Caracas, ').Cambiar_fecha_mes($registro['fecha_solic']),0,'J',0);
       
  	  //Busqueda del Titular y sus datos
	  $titular='';
  	  $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		                       FROM stzottid, stzsolic, stzderec 
		                       WHERE stzottid.nro_derecho='$nderec'
		                       AND stzderec.nro_derecho=stzottid.nro_derecho
                             AND stzsolic.titular = stzottid.titular");
	  $filas_found1=pg_numrows($res_titular);
	  $regt = pg_fetch_array($res_titular);
	  for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	     $pais_nombre=pais($regt['nacionalidad']);
 	     if ($cont1=='0'){
	       $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	     else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	     $regt = pg_fetch_array($res_titular);
	  } 
     $y = $pdf->Gety(); 
     $texto_titular= "[b]Solicitada por:   "."[/b] ".$titular;
     $pdf->JLCell("$texto_titular",135,'j');

     //imagen
	  $varsol1=substr($nsolic,-11,4);
	  $varsol2=substr($nsolic,-6,6);
     $nameimage = "../graficos/patentes/di".$varsol1."/".$varsol1.$varsol2.".jpg";
	  if (file($nameimage)) {   
	     $x = $pdf->Getx();
        $y = $pdf->Gety();
		  if ($y >= 240) {
		    $pdf->AddPage();
	       $pdf->Image("$nameimage",160,15,30,30,'JPG');
          $y = $pdf->Gety(); 	
          $pdf->SetXY($x,$y+5); 		 
        }
        else{	
          $pdf->Image("$nameimage",160,$y,30,30,'JPG');
          $y = $pdf->Gety(); 	
          $pdf->SetXY($x,$y+12); 
		  }
	  }
   
     //Inventores
     $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
     $reg_inv = pg_fetch_array($cons_inv);
     $filas_cons_inv=pg_numrows($cons_inv);
     $inventores="";
     for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
        if (empty($inventores)) { $inventores=$inventores.utf8_decode(trim($reg_inv['nombre_inv'])); }
        else { $inventores=$inventores."; ".utf8_decode(trim($reg_inv['nombre_inv'])); } 
        $reg_inv = pg_fetch_array($cons_inv);
     }
     $texto_inventor= "[b]Nombre del Inventor(es):   "."[/b] ".$inventores;
     $pdf->JLCell("$texto_inventor",135,'j');

     //Titulo de la patente
     $pdf->Setfont('Arial','',8);
     $texto_titulo= "[b]Titulo:  [/b] ".utf8_decode(trim($registro['nombre']));
     $pdf->JLCell("$texto_titulo",135,'j');       

     //Resumen 
     $resumen= trim(mb_strtoupper(utf8_decode($registro['resumen'])));
     $texto_resumen= "[b]Resumen:   "."[/b] ".$resumen;
     $pdf->JLCell("$texto_resumen",135,'j');       
     $pdf->ln(3); 
     $pdf->MultiCell(190,5,'Registrador(a) de la Propiedad Industrial',0,'C',0);
     
     //$update_str = "fecha_gene='$fechahoy',hora_gene='$horactual',estatus='G',publicada='S'";
     //$updpagoprensa = $sql->update("stppagopren","$update_str","nro_derecho='$nderec' AND fecha_publi='$fecsold'");

     //imagen
     //$varsol1=substr($nsolic,-11,4);
     //$varsol2=substr($nsolic,-6,6);
     //$nameimage = "../graficos/patentes/di".$varsol1."/".$varsol1.$varsol2.".jpg";
     //if (file($nameimage)) {   
	  //$pdf->ln(1);
	  //$x = $pdf->Getx();
	  //$y = $pdf->Gety();
	  //$pto = $y;
     ////$pdf->Image("$nameimage",160,$y,30,25,'JPG');
     //$pdf->Image("$nameimage",160,$y,30,30,'JPG');
     //}
     $update_str = "fecha_gene='$fechahoy',hora_gene='$horactual',estatus='P',publicada='S'";
     $updpagoprensa = $sql->update("stppagopren","$update_str","nro_derecho='$nderec' AND fecha_publi='$fecsold'");
     $registro = pg_fetch_array($resultado);
  }
  
  // Fin de Pagina 
  $pdf->ln(6); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,'Total de Solicitudes Patentes Publicadas: '.$total,0,'J',0);
  $pdf->Setfont('Arial','B',8);

  $pdf->Setfont('Arial','B',12);
  $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);

} //fin del else si no hay resultado (filas_resultado)

$filastotalpren = $filasm+$filasp;

if ($filastotalpren!=0) {
  $pdf->Output($archivo);
  ob_end_clean(); 
  //Salida del Reporte
  $pdf->Output();
} else {
    $smarty->display('encabezado1.tpl');
    mensajenew('AVISO: NO Hay solicitudes de Marcas y Patentes a Publicar en Prensa del dia -> '.$fecsold.' ...!!!','z_publiprensa.php','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}  

//Desconexion a la base de datos
$sql->disconnect();

?>
