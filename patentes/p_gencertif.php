<?php

echo "<script language='javascript' type= 'text/javascript'>";
echo "  function valagente(v1,v2){"; 
echo "    if (v1!=''){";
echo "      v2.value=v1.value;";
echo "    }";
echo "  }";
echo "</script>";

ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Para trabajar con Smarty 
require ("$root_path/include.php");
include ("$include_lib/librar_cert.php");
//Para trabajar con sessiones
require("$root_path/aut_verifica.inc.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$modulo  = "m_gencertif.php";
$fecha   = fechahoy();
$fechahoy = hoy();
$tbname_1 = "stzfirmel";

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/fpdf.php");

//Conexion
$sql = new mod_db();
$sql->connection($usuario);

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n de Certificados de Registros de Patentes para Firma Electr&oacute;nica');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$vopc     = $_GET['vopc'];

if ($vopc==1) {
//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo2','Bolet&iacute;n:');
}

if ($vopc==2) {
 //Validacion de Entrada
 $boletin = trim($_POST["boletin"]);
 $vsol1 = $_POST["vsol1"];
 $vsol2 = $_POST["vsol2"];
 $vsol3 = $_POST["vsol1h"];
 $vsol4 = $_POST["vsol2h"];

 if ((empty($boletin)) && (empty($vsol1)) && (empty($vsol2)) && (empty($vsol3)) && (empty($vsol4))) {
   mensajenew('ERROR: Debe introducir un Criterio de B&uacute;squeda ...!!!','javascript:history.back();','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 }

 if ((!empty($vsol1)) && (!empty($vsol2)) && ((empty($vsol3)) || (empty($vsol4)))) {
   mensajenew('ERROR: Debe introducir el rango final de Solicitud para proseguir ...!!!','javascript:history.back();','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 } 

 if (!empty($boletin) && $boletin < 563) {
   mensajenew('ERROR: El Boletin a generar y firmar NO puede ser menor al 563 ...!!!','javascript:history.back();','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 }

 if ((!empty($vsol1)) && (!empty($vsol2)) && (!empty($vsol3)) && (!empty($vsol4))) {
   if (empty($boletin)) {
     mensajenew('ERROR: Debe introducir el Numero de Boletin para proseguir ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } else {
     $vsoli=sprintf("%04d-%06d",$vsol1,$vsol2);
     $vsolf=sprintf("%04d-%06d",$vsol3,$vsol4);
 
     if ($vsoli > $vsolf) {  
       $smarty->display('encabezado1.tpl');
       mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

     $resultado=pg_exec("SELECT a.nro_derecho,solicitud,tipo_derecho,fecha_solic,tipo_mp,nombre,estatus,registro,
                        a.fecha_regis,a.fecha_publi,a.fecha_venc
                       FROM stzderec a, stzevtrd b 
                       WHERE a.solicitud >='$vsoli' AND a.solicitud <= '$vsolf'   
                       AND a.nro_derecho=b.nro_derecho
		                 AND a.tipo_mp='P' 
		                 AND a.estatus = 2555
		                 AND b.documento='$boletin'
		                 AND b.evento IN (2122)
		                 ORDER BY 2");

     //verificando los resultados
     if (!$resultado) { 
       mensajenew('ERROR: No existen certificados para generar en el rango indicado...!!!','javascript:history.back();','N');   
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
     $filas_found=pg_numrows($resultado); 
   }
 }

 if (!empty($boletin) &&  ((empty($vsol1)) && (empty($vsol2)) && (empty($vsol3)) && (empty($vsol4)))) {
     $resultado=pg_exec("SELECT a.nro_derecho,solicitud,tipo_derecho,fecha_solic,tipo_mp,nombre,estatus,registro,
                        a.fecha_regis,a.fecha_publi,a.fecha_venc
                       FROM stzderec a, stzevtrd b 
                       WHERE a.nro_derecho=b.nro_derecho
		                 AND a.tipo_mp='P' 
		                 AND a.estatus = 2555
		                 AND b.documento='$boletin'
		                 AND b.evento IN (2122)
		                 ORDER BY 2");

   //verificando los resultados
   if (!$resultado) { 
     mensajenew('ERROR: No existen certificados para generar en el boletin indicado...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   $filas_found=pg_numrows($resultado); 
 }

 if ($filas_found>0) {
  $reg = pg_fetch_array($resultado);
  //$rutafinal = "$ruta_certificado";
  $rutafinal = "$ruta_certifi2";
  $diripmaq = getRealIP();

  for($cont=0;$cont<$filas_found;$cont++)   { 
    //for($cont=0;$cont<50;$cont++) { 
    //Incio de la Clase de PDF para generar los reportes
    //Inicio del Pdf
    $pdf=new FPDF('P','mm','A4');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','',9);
    //$pdf->Image('../imagenes/Certificado_ep2018.jpg',3,0,205,330,'JPEG');
    //$pdf->Image('../imagenes/Cerelecopat.jpg',3,0,205,330,'JPEG');
    //$pdf->Image('../imagenes/certpatentes1.jpg',3,0,205,330,'JPEG');

    $tipoA = "";
    $tipoB = "";
    $tipoE = "";
    //tipo de Patente
    $vtipopat=trim($reg['tipo_derecho']);
    $varsol=$reg['solicitud'];
    $nderec=$reg['nro_derecho'];
    $coldm=0; 
    switch ($vtipopat) {
     case "A":
       $pdf->Image('../imagenes/certpat_invencion.jpg',3,0,205,330,'JPEG');
       break;
     case "F":
       $pdf->Image('../imagenes/certpat_modelo_utilidad.jpg',3,0,205,330,'JPEG');
       break;
     case "B":
         $tipoB = "X";
         $pdf->Image('../imagenes/certpat_dib_model_industrial.jpg',4,0,205,330,'JPEG');
         $coldm=1;
       break;
     case "E":
         $tipoE = "X";
         $pdf->Image('../imagenes/certpat_dib_model_industrial.jpg',4,0,205,330,'JPEG');
         $coldm=1;
       break;
     case "G":
         $pdf->Image('../imagenes/certpat_diseno_industrial.jpg',3,0,205,330,'JPEG');
       break;
    }  

    $varsol1 = substr($varsol,0,4);
    $varsol2 = substr($varsol,5,6);
    $archivo   = $rutafinal."/patentes"."/".$boletin."_".$varsol1.$varsol2.".pdf";


    // Datos de Prioridad
    $npriori='';
    $pais='';
    $pais_nombre='';
    $fechaprior='';
    $result_prio = pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
    $res_prio = pg_fetch_array($result_prio);
    $filas_prio=pg_numrows($result_prio);
    if ($filas_prio!=0) { 
       $npriori=trim($res_prio['prioridad']);
       $pais_nombre=pais($res_prio['pais_priori']);
       $pais=trim($pais_nombre);
       $fechaprior=$res_prio['fecha_priori'];
    }

    $pdf->Setxy(44,97);  $pdf->Cell(20,4,$npriori,0,0);
    if (strlen($pais_nombre)<=30) { 
       $pdf->Setxy(44,105); 
       $pdf->Cell(20,4,utf8_decode($pais_nombre),0,0); 
    } else {
       $pdf->Setxy(44,105);   
       $pdf->MultiCell(58,3,utf8_decode($pais_nombre),0,'J');
    }
    $pdf->Setxy(44,114); $pdf->Cell(75,4,$fechaprior,0,0);  

    $pdf->SetFont('Arial','',12);
    $pdf->Setxy(104,91-$coldm);  $pdf->Cell(20,4,$reg['solicitud'],0,0);
    $pdf->SetFont('Arial','',9); 
    $pdf->Setxy(104,99-$coldm);  $pdf->Cell(75,4,$reg['fecha_solic'],0,0);

    $pdf->SetFont('Arial','',12);
    if ($vtipopat=='B' or $vtipopat=='E') {
       $pdf->Setxy(114,109);  $pdf->Cell(20,4,$reg['registro'],0,0);
       $pdf->SetFont('Arial','',9);
       $pdf->Setxy(127,114); $pdf->Cell(75,4,$reg['fecha_regis'],0,1);
       $pdf->Setxy(127,118); $pdf->Cell(75,4,$reg['fecha_venc'],0,0);    
       $pdf->Setxy(163,97);  $pdf->Cell(20,4,$tipoE,0,1);
       $pdf->Setxy(163,104);  $pdf->Cell(20,4,$tipoB,0,1);
       //Nombre de la Patente
       $pdf->Setxy(44,141);   
       $pdf->MultiCell(155,4,trim(utf8_decode($reg['nombre'])),0,'J');
       $filas_tit_pdf = 167;
       $colum_tit_pdf = 70;
    } else {
       $pdf->Setxy(150,95);  $pdf->Cell(20,4,$reg['registro'],0,0);
       $pdf->SetFont('Arial','',9);
       $pdf->Setxy(150,103); $pdf->Cell(75,4,$reg['fecha_regis'],0,1);
       $pdf->Setxy(150,111); $pdf->Cell(75,4,$reg['fecha_venc'],0,0); 
       //Nombre de la Patente
       $pdf->Setxy(44,150);   
       $pdf->MultiCell(155,4,trim(utf8_decode($reg['nombre'])),0,'J');  
       $filas_tit_pdf = 193;
       $colum_tit_pdf = 155; 
    }   
    

    // Datos del titular o solicitante
    $titular='';
    $pais='';
    $domi='';

    $result_tit = pg_exec("SELECT stzottid.titular, stzsolic.indole, stzsolic.nombre, stzsolic.identificacion, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio, stzsolic.telefono1, stzsolic.telefono2, stzsolic.rmercantil
                           FROM stzottid, stzsolic WHERE stzottid.nro_derecho='$nderec'
	                         AND stzsolic.titular = stzottid.titular");

    $res_tit = pg_fetch_array($result_tit);
    $filas_tit=pg_numrows($result_tit);
    
    $arraytitular = array();
    $arraydomicilio = array();
    for($cont_tit=1;$cont_tit<=$filas_tit;$cont_tit++)   { 
       $nombre=trim($res_tit['nombre']); 
       $nacionalidad=pais($res_tit['nacionalidad']);
       $pais_nacion=trim($nacionalidad);
       $pais=pais($res_tit['pais_domicilio']);
       $pais_domi=trim($pais);
       $domi=trim($res_tit['domicilio']);
       $arraytitular[]=utf8_decode($nombre); 
       $arraydomicilio[]=trim(utf8_decode(" Domicilio: ".$domi.", ".$pais_nacion));
       $res_tit = pg_fetch_array($result_tit);
    }
    
    for($i=0;$i<4;$i++)   { 
      $filas_tit_pdf = $filas_tit_pdf + 4;
      $pdf->Setxy(44,$filas_tit_pdf); 
      $pdf->MultiCell($colum_tit_pdf,4,$arraytitular[$i]);
      $filas_tit_pdf = $filas_tit_pdf + 4;
      $pdf->Setx(44); 
      $pdf->MultiCell($colum_tit_pdf,4,$arraydomicilio[$i],0,'J');
    }


    //Datos del Pago de Derecho
    $factura = "";
    $fechafac="";
    $montofac=0;
    $result_fac = pg_exec("SELECT * FROM stzevtrd WHERE stzevtrd.nro_derecho='$nderec' AND evento=2066");
    $res_fac = pg_fetch_array($result_fac);
    $filas_fac=pg_numrows($result_fac);
    if ($filas_fac>0) { 
      $factura="F0".$res_fac['documento'];
      $fechafac=$res_fac['fecha_event'];
    }

    //Datos de la Anualidad
    $recibo = "";
    $fechaanual="";
    $nmonto=0;
    $result_anual = pg_exec("SELECT * FROM stpanual WHERE stpanual.nro_derecho='$nderec' AND stpanual.anualidad=1");
    $res_anual = pg_fetch_array($result_anual);
    $filas_anual=pg_numrows($result_anual);
    if ($filas_anual>0) { 
       $nmonto=$res_anual['monto'];
       $recibo=trim($res_anual['tasa']);
       $fechaanual=$res_anual['fecha_anual'];
    }
    //imagen
    if ($vtipopat=='B' or $vtipopat=='E') {
       $varsol1=substr($varsol,-11,4);
       $varsol2=substr($varsol,-6,6);
       $nameimagen=ver_imagen($varsol1,$varsol2,'P');
       if (file($nameimagen)) { $pdf->Image($nameimagen,120,167,72,76,'JPG'); }
    }


    // firma y leyenda
    $pdf->SetFont('Arial','B',8);
    $fregistro=$reg['fecha_regis'];
    $fecharegistradora="24/08/2022";
    $esmayor=compara_fechas2($fregistro,$fecharegistradora);
    //La Fecha de Registro es a partir del Nombramiento
$esmayor=1;
if ($esmayor==1) {
      $fil=274; $inc=3; 
      $pdf->SetXY(72,$fil+($inc*1)-1);$pdf->Cell(0,0,            '     _______________________________________________________');
      $pdf->SetXY(72,$fil+($inc*2));$pdf->Cell(0,0,utf8_decode('                               Hendrick J. Perdomo Colmenares'));
      $pdf->SetXY(72,$fil+($inc*3));$pdf->Cell(0,0,utf8_decode('                           Registrador de la Propiedad Industrial'));
      $pdf->SetXY(72,$fil+($inc*4));$pdf->Cell(0,0,utf8_decode('         Resolución No. 067/2022, de fecha 16 de Agosto de 2022'));
      $pdf->SetXY(72,$fil+($inc*5));$pdf->Cell(0,0,utf8_decode('Gaceta Oficial de la República Bolivariana de Venezuela No. 24.447,')); 
      $pdf->SetXY(72,$fil+($inc*6));$pdf->Cell(0,0,utf8_decode('                                 de fecha 24 de Agosto de 2022')); 
    }
    else {
      $fil=274; $inc=3; 
      $pdf->SetXY(60,$fil+($inc*1)-1);$pdf->Cell(0,0,'      _____________________________________________________________________');
      $pdf->SetXY(65,$fil+($inc*2));$pdf->Cell(0,0,utf8_decode('Certificado suscrito en fecha: __________ por Hendrick J. Perdomo Colmenares'));
      $pdf->SetXY(106,$fil+($inc*2));$pdf->Cell(0,0,$fechahoy);  
      $pdf->SetXY(60,$fil+($inc*3));$pdf->Cell(0,0,utf8_decode('   Registrador de la Propiedad Industrial. Resolución No. 067/2022, de fecha 16/08/2022'));
      $pdf->SetXY(60,$fil+($inc*4));$pdf->Cell(0,0,utf8_decode(' Gaceta Oficial de la República Bolivariana de Venezuela No. 42.447 de fecha 24/08/2022'));
      $pdf->SetXY(60,$fil+($inc*5));$pdf->Cell(0,0,utf8_decode('   En virtud de no haber sido firmada por el funcionario competente en su oportunidad.'));
    }
    $pdf->Setxy(160,290);
    $pdf->SetFont('Arial','',7);
//    $pdf->Cell(20,4,utf8_decode("Fecha de Impresión: ").$fechahoy,0,1);
  
    
    // Continuacion de Datos del certificado
    $ind==0;
    $fil=14; $inc=4; 
    // Continuacion de los titulares
//    if ($filas_tit>1) { 
//       $pdf->AddPage(); 
//       $ind=1;
//       $pdf->Multicell(120,4,utf8_decode('Continuación de Titulares '));}
//
//    for($cont_tit=1;$cont_tit<$filas_tit;$cont_tit++)   { 
//       $res_tit = pg_fetch_array($result_tit);
//       $titular=$titular.trim($res_tit['nombre']); 
//       $pais_nombre=pais($res_tit['nacionalidad']);
//       $pais=$pais.trim($pais_nombre);
//       $domi=$domi.trim($res_tit['domicilio']);
//
//       $pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'TITULAR:  '.utf8_decode($titular));
//       $pdf->SetXY(14,$fil+($inc*2));$pdf->Cell(0,0,'PAIS:  '.utf8_decode($pais));
//       $pdf->SetXY(14,$fil+($inc*3));$pdf->Cell(0,0,'DOMICILIO:  '.utf8_decode($domi));
//       $fil=$fil+($inc*4);
//       $titular="";
//       $pais="";
//       $domi="";
//    }
    // Continuacion de Prioridad
    if ($filas_prio>1) { 
       if ($ind==0) {
          $pdf->AddPage(); 
          $ind=1;
       }
       $pdf->SetFont('Arial','B',12);
       $pdf->Multicell(120,4,utf8_decode('Continuación datos de Prioridad:'));       
       $pdf->SetFont('Arial','',9);
       for($cont_prio=1;$cont_prio<$filas_prio;$cont_prio++)   { 
          $res_prio = pg_fetch_array($result_prio);
          $npriori=trim($res_prio['prioridad']);
          $pais_nombre=pais($res_prio['pais_priori']);
          $pais=trim($pais_nombre);
          $fechaprior=$res_prio['fecha_priori'];

          $pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'PRIORIDAD: '.utf8_decode($npriori));
          $pdf->SetXY(14,$fil+($inc*2));$pdf->Cell(0,0,'PAIS: '.utf8_decode($pais_nombre));
          $pdf->SetXY(14,$fil+($inc*3));$pdf->Cell(0,0,'FECHA: '.$fechaprior);
          $fil=$fil+($inc*4);
          $npriori="";
          $pais_nombre="";
          $fechaprior="";
       }
    }

    $pdf->Output($archivo);
    $reg = pg_fetch_array($resultado);
  } //END For
 } //END If  
               
 //Desconexion a la base de datos
 $sql->disconnect();

 //$cmd="scp -P 3535 /var/www/apl/sipi/documentos/certificado/*.pdf www-data@172.16.0.7:/var/www/apl/webpi/documentos/"; 
 //$cmd="scp -P 22 /var/www/apl/sipi/documentos/certificado/*.pdf www-data@172.16.0.10:/var/www/apl/sifel/documentos/certificado/"; 
 //exec($cmd,$salida);
 //foreach($salida as $line) { 
 //echo "Holaa<br>";	
 //echo "$line<br>"; }

   $vmessage="$filas_found CERTIFICADO(S) DE REGISTRO(S) GENERADO(S) ...!!";
   $vmessage1="";
   echo "<br><br>";
   echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
   echo "   <tr>";
   echo "     <td colspan='2' height='60'>";
   echo "        <img src='../imagenes/messagebox_info.png' align='middle'>";
   echo "     </td>";
   echo "     <td colspan='2' height='60'>";
   echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>$vmessage<br><br><font color='#FFFF00'></b></font>";
   echo "       </div>";
   echo "     </td>";
   echo "   </tr>";
   echo "</table>";
   echo "<p align='center'><a href='../patentes/p_gencertif.php?vopc=1'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</a></p>";
   echo "<br>";
   $smarty->display('pie_pag.tpl'); 
}

if ($vopc==1) {
$smarty->assign('varfocus','forobscon.vsol1'); 
$smarty->display('p_gencertif.tpl');
$smarty->display('pie_pag.tpl');
}
$sql->disconnect();
?>
