<?php
ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Para trabajar con Smarty 
require ("$root_path/include.php");
include ("$include_lib/librar_cert.php");
//LLamadas a funciones de Libreria 
//include ("$include_lib/library.php");
$fecha   = fechahoy();
$fechahoy = hoy();

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/fpdf.php");

//Conexion
$sql = new mod_db();
$sql->connection();

//Pantalla Titulos

$smarty->assign('subtitulo','Certificados de Registro de Patentes');
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$registrod1=$_POST["vreg1"];
$registroh1=$_POST["vreg2"];


$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];

$varsol2 = str_pad($varsol2, 6, '0', STR_PAD_LEFT); 
$registroh1 = str_pad($registroh1, 6, '0', STR_PAD_LEFT); 

$registrod= $registrod1.$registroh1;
$varsol=($varsol1.'-'.$varsol2);

//Query para buscar los certificados de patentes en el rango correspondiente
if((!empty($registrod)) and ($registrod!= '000000')) {  
   $resultado=pg_exec("SELECT nro_derecho,solicitud,tipo_derecho,fecha_solic,tipo_mp,nombre,estatus,registro,
                        fecha_regis,fecha_publi,fecha_venc
                       FROM stzderec  
                       WHERE tipo_mp='P' 
		       AND estatus IN (2400,2410,2555,2919,2920)
		       AND registro =  '$registrod' ");
}
if((!empty($varsol)) and ($varsol != '-000000')) {  

   $resultado=pg_exec("SELECT nro_derecho,solicitud,tipo_derecho,fecha_solic,tipo_mp,nombre,estatus,registro,
                        fecha_regis,fecha_publi,fecha_venc
                       FROM stzderec  
                       WHERE tipo_mp='P' 
		       AND estatus IN (2400,2410,2555,2919,2920)
		       AND solicitud = '$varsol' and solicitud!='' ");

}

//verificando los resultados
if (!$resultado) { 
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     mensajenew('ERROR: No existe el Nro. de Registro o Solicitud, o NO se encuentra en el estatus adecuado ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit(); 
      } 
$reg = pg_fetch_array($resultado);

//Incio de la Clase de PDF para generar los reportes
//Inicio del Pdf
$pdf=new FPDF('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);
//$pdf->Image('../imagenes/certpatentes.jpg',3,0,205,330,'JPEG');
//$pdf->Image('../imagenes/certificado_patentes_invencion.jpg',3,0,205,330,'JPEG');
	
  for($cont=0;$cont<$filas_found;$cont++)   { 
    $tipoB = "";
    $tipoE = "";
    //tipo de Patente
    $vtipopat=trim($reg['tipo_derecho']);
    $varsol=$reg['solicitud'];
    $nderec=$reg['nro_derecho'];
    $coldm=0;
    switch ($vtipopat) {
     case "A":
       $pdf->Image('../imagenes/certpat_invencion2.jpg',3,0,205,330,'JPEG');
       break;
     case "F":
       $pdf->Image('../imagenes/certpat_modelo_utilidad2.jpg',3,0,205,330,'JPEG');
       break;
     case "B":
         $tipoB = "X";
         $pdf->Image('../imagenes/certpat_dib_model_industrial2.jpg',4,0,205,330,'JPEG');
         $coldm=1;
       break;
     case "E":
         $tipoE = "X";
         $pdf->Image('../imagenes/certpat_dib_model_industrial2.jpg',4,0,205,330,'JPEG');
         $coldm=1;
       break;
     case "G":
       $pdf->Image('../imagenes/certpat_diseno_industrial2.jpg',3,0,205,330,'JPEG');
       break;
    }       

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
//$esmayor=1;
    if ($esmayor==1) {
      $fil=274; $inc=3; 
      $pdf->SetXY(72,$fil+($inc*1)-1);$pdf->Cell(0,0,            '   _______________________________________________________');
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

    $pdf->Setxy(160,292);
    $pdf->SetFont('Arial','',7);
//    $pdf->Cell(20,4,utf8_decode("Fecha de Impresión: ").$fechahoy,0,1);
    
    // Continuacion de Datos del certificado
    $ind=0;
    $fil=14; $inc=4; 
    // Continuacion de los titulares
//    if ($filas_tit>1) { 
//       $pdf->AddPage(); 
//       $ind=1;
//       $pdf->SetFont('Arial','B',12);
//       $pdf->Multicell(120,4,utf8_decode('Continuación datos de Titulares:'));}
//       $pdf->SetFont('Arial','',9);
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

 }   
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
