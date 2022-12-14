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
$smarty->assign('subtitulo','Generaci&oacute;n de Certificados de Registros de Marcas para Firma Electr&oacute;nica');
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

 if ($boletin < 561) {
   mensajenew('ERROR: El Boletin a generar y firmar NO puede ser menor al 562 ...!!!','javascript:history.back();','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 }

 if ((!empty($vsol1)) && (!empty($vsol2)) && ((empty($vsol3)) || (empty($vsol4)))) {
   mensajenew('ERROR: Debe introducir el rango final de Solicitud para proseguir ...!!!','javascript:history.back();','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 } 

 if ((!empty($vsol1)) && (!empty($vsol2)) && (!empty($vsol3)) && (!empty($vsol4))) {
   if (empty($boletin)) {
     mensajenew('ERROR: Debe introducir el Numero de Boletin para proseguir ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } else {
     $vsoli=sprintf("%04d-%06d",$vsol1,$vsol2);
     $vsolf=sprintf("%04d-%06d",$vsol3,$vsol4);
 
     //echo " $vsoli, $vsolf, $boletin ";
     if ($vsoli > $vsolf) {  
       $smarty->display('encabezado1.tpl');
       mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

     $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,b.Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                       FROM stmmarce a, stzderec b, stzevtrd c 
                       WHERE b.solicitud >='$vsoli' AND b.solicitud <= '$vsolf'   
                       AND a.nro_derecho=b.nro_derecho
                       AND b.nro_derecho=c.nro_derecho
		                 AND b.tipo_mp='M' 
		                 AND b.estatus = 1555
		                 AND c.estat_ant IN (1101,1026,1027,1029)
		                 AND c.documento='$boletin'
		                 AND c.evento IN (1122,1097,1181)
		                 ORDER BY 6");

     //verificando los resultados
     if (!$resultado) { 
       mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
     $filas_found=pg_numrows($resultado); 
   }
 }

 if (!empty($boletin) &&  ((empty($vsol1)) && (empty($vsol2)) && (empty($vsol3)) && (empty($vsol4)))) {
   $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,b.Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                       FROM stmmarce a, stzderec b, stzevtrd c 
                       WHERE a.nro_derecho=b.nro_derecho
                       AND b.nro_derecho=c.nro_derecho
		                 AND b.tipo_mp='M' 
		                 AND b.estatus = 1555
		                 AND c.estat_ant IN (1101,1026,1027,1029)
		                 AND c.documento='$boletin'
		                 AND c.evento IN (1122,1097)
		                 ORDER BY 6");

   //verificando los resultados
   if (!$resultado) { 
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   $filas_found=pg_numrows($resultado); 
 }

 //echo " $vsoli, $vsolf, $boletin, $filas_found "; exit();


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
//    $pdf->Image('../imagenes/Certificado_em2018.jpg',3,0,205,330,'JPEG');
    $pdf->Image('../imagenes/certmarcas3.jpg',3,0,205,330,'JPEG');
    //$pdf->Image('../imagenes/Certelecmar1.jpg',3,0,205,330,'JPEG');
    //$pdf->Image('../imagenes/certmarcas2.jpg',3,0,205,330,'JPEG');
    //$pdf->Image('../imagenes/certmarcas3.jpg',3,0,205,330,'JPEG');

	 //tipo de marca
	 $vtip=tipo_marca($reg['tipo_marca']);

	 if ($reg['clase']=='46') {$vclas='NC';}
	 if ($reg['clase']=='47') {$vclas='LC';}
	 if (($reg['clase']!='46') and ($reg['clase']!='47')) {$vclas=$reg['clase'];}

    $varsol=$reg['solicitud'];
    $nderec=$reg['nro_derecho'];
    $varsol1 = substr($varsol,0,4);
    $varsol2 = substr($varsol,5,6);
    //$archivo   = $rutafinal."/".$varsol1.$varsol2.".pdf";
    $archivo   = $rutafinal."/".$boletin."_".$varsol1.$varsol2.".pdf";
    $registro  = trim($reg['registro']);
    //$archivo   = $rutafinal.$varsol1."/".$varsol1.$varsol2.".pdf";
    //echo "son $filas_found, $archivo, $nderec,$varsol,$registro ";

    //Ubica el evento 902 (reimpresion error material)
    $event902='N';
    $resulta_event902=pg_exec("SELECT solicitud
                                 FROM stzderec a, stzevtrd b 
                                WHERE a.nro_derecho=b.nro_derecho AND a.solicitud='$varsol' AND a.tipo_mp='M' AND b.evento=1902");
    $filas_902=pg_numrows($resulta_event902);
    if ($filas_902>0) {$event902='S';} 
    //Fin ubica 902

    $pdf->Setxy(70,71);
    $pdf->Cell(20,4,$reg['registro'],0,1); 
    $pdf->Setxy(70,75);
    $pdf->Cell(20,4,$reg['fecha_regis'],0,1);
    $pdf->Setxy(70,79);
    $pdf->Cell(75,4,$reg['fecha_venc'],0,0);
    $pdf->Setxy(148,71);
    $pdf->Cell(60,4,$vtip,0,0);
    $pdf->Setxy(128,79);
    $pdf->Cell(40,4,$vclas,0,1);
    $pdf->Setxy(70,83);
    $pdf->Cell(20,4,$reg['solicitud'],0,1);

    // titular
    $titular='';
    $pais='';
    $domi='';

    $result_tit = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");

    $res_tit = pg_fetch_array($result_tit);
    $filas_tit=pg_numrows($result_tit);
    if ($filas_tit>1) { 
       $titular=$titular.'  '.trim($res_tit['nombre']).', cont ***';
       $pais_nombre=pais($res_tit['nacionalidad']);
       $pais=$pais.trim($pais_nombre);
       $domi=$domi.trim($res_tit['domicilio']);
    }
    else {
       $titular=$titular.trim($res_tit['nombre']); 
       $pais_nombre=pais($res_tit['nacionalidad']);
       $pais=$pais.trim($pais_nombre);
       $domi=$domi.trim($res_tit['domicilio']);
    } 

    if (strlen(trim($titular))>72) {
      $pdf->SetFont('Arial','',8);
      $pdf->Setxy(64,93); 
      $pdf->Cell(50,4,utf8_decode(substr($titular,0,strrpos(substr(trim($titular),0,72),' '))));
      $pdf->Setxy(64,96); 
      $pdf->Cell(50,4,utf8_decode(substr($titular,strrpos(substr(trim($titular),0,72),' ')+1,strlen($titular))));
      $pdf->Setxy(64,99);  
      $pdf->Cell(50,4,utf8_decode($pais));
      $pdf->SetFont('Arial','',9);
      $pdf->Setxy(64,103);
      $pdf->Cell(50,4,utf8_decode($domi));
    }
    else { 
      $pdf->Setxy(64,93);
      $pdf->Cell(40,4,utf8_decode($titular));  
      $pdf->Setxy(64,99);  
      $pdf->Cell(30,4,utf8_decode($pais));
      if (strlen(trim($domi))>72) {
        $pdf->SetFont('Arial','',8);
        $pdf->Setxy(64,103);
        $pdf->Cell(50,4,utf8_decode(substr($domi,0,strrpos(substr(trim($domi),0,72),' '))));
        $pdf->Setxy(64,106); 
        $pdf->Cell(50,4,utf8_decode(substr($domi,strrpos(substr(trim($domi),0,72),' ')+1,strlen($domi))));
        $pdf->SetFont('Arial','',9);
      }
      else {
        $pdf->Setxy(64,103);
        $pdf->Cell(50,4,utf8_decode($domi));
      }	
    }
    //Nombre de la Marca
    $pdf->Setxy(44,120);   
    $pdf->MultiCell(150,4,trim(utf8_decode($reg['nombre'])),0,'J');
   
    //descripcion de la etiqueta
    $resultado1=pg_exec("SELECT * FROM stmlogos WHERE nro_derecho='$nderec'");
    $filas_found1=pg_numrows($resultado1);
    $reg_etiq = pg_fetch_array($resultado1);
    $pdf->Setxy(44,137); 
    $num_letras=strlen(trim($reg_etiq['descripcion']));
    if ($num_letras>850)
    {
       //no corta la palabra lo deja en el espacio anterior del limite
       //$str = trim(substr($reg_etiq['descripcion'],0,850));
       //$str = substr($str, 0, 680-strlen(strrchr($str, " ")));
       $str = substr(trim($reg_etiq['descripcion']),0,strrpos(substr(trim($reg_etiq['descripcion']),0,850),' '));
       $str = $str.' ***';
       $pdf->MultiCell(75,3,mb_strtoupper(utf8_decode($str)),0,'J'); 
    }
    if ($num_letras<=850) {$pdf->MultiCell(75,3, trim(mb_strtoupper(utf8_decode($reg_etiq['descripcion']))),0,'J');}
    //imagen
		$varsol1=substr($varsol,-11,4);
		$varsol2=substr($varsol,-6,6);
	   $nameimagen=ver_imagen($varsol1,$varsol2,'M');

      if (($reg['modalidad']!="D") AND file($nameimagen)) {
    		//$pdf->Image($nameimagen,122,128,80,80,'JPG');  
    		$pdf->Image($nameimagen,124,139,70,70,'JPG');  
    	}
       
    //descripcion del distingue
    $pdf->Setxy(44,219);  
    $num_letras=strlen(trim(utf8_decode($reg['distingue']))); 

    if ($num_letras>1200)    {
       //no corta la palabra lo deja en el espacio anterior del limite
       $str = substr(trim($reg['distingue']),0,strrpos(substr(trim($reg['distingue']),0,1200),' '));
       $str = $str.' ***';
       $pdf->MultiCell(158,3,mb_strtoupper(utf8_decode($str)),0,'J'); 
    }
    if ($num_letras<=1200) { $pdf->MultiCell(158,3,trim(mb_strtoupper(utf8_decode($reg['distingue']))),0,'J');}

    //firma y leyenda
    $pdf->SetFont('Arial','B',8);
    $fregistro=$reg['fecha_regis'];
    //$fecharegistradora="30/09/2021";
    $fecharegistradora="24/08/2022";
    $esmayor=compara_fechas2($fregistro,$fecharegistradora);
    //La Fecha de Registro es a partir del Nombramiento en Gaceta Oficial (fecha de la gaceta)
    if ($esmayor==1) {
      $fil=287; $inc=4; 
      $pdf->SetXY(34,$fil+($inc*1));$pdf->Cell(0,0,            '__________________________________________________________________________');
      $pdf->SetXY(34,$fil+($inc*2));$pdf->Cell(0,0,utf8_decode('                                                  Hendrick J. Perdomo Colmenares'));
      $pdf->SetXY(34,$fil+($inc*3));$pdf->Cell(0,0,utf8_decode('                                              Registrador de la Propiedad Industrial'));
      $pdf->SetXY(34,$fil+($inc*4));$pdf->Cell(0,0,utf8_decode('                               Resoluci??n No. 067/2022, de fecha 16 de Agosto de 2022'));
      $pdf->SetXY(34,$fil+($inc*5));$pdf->Cell(0,0,utf8_decode('Gaceta Oficial de la Rep??blica Bolivariana de Venezuela No. 42.447, de fecha 24/08/2022'));
      $pdf->SetFont('Arial','BI',7);
      $pdf->SetXY(34,$fil+($inc*6));
    }
    else {
      $fil=286; $inc=3; 
      $pdf->SetXY(34,$fil+($inc*1));$pdf->Cell(0,0,'__________________________________________________________________________');
      $pdf->SetXY(34,$fil+($inc*3));$pdf->Cell(0,0,utf8_decode('Certificado suscrito en fecha: _________ por Hendrick J. Perdomo Colmenares'));
      $pdf->SetXY(74,$fil+($inc*3));$pdf->Cell(0,0,$fechahoy);  
      $pdf->SetXY(34,$fil+($inc*4));$pdf->Cell(0,0,utf8_decode('Registrador de la Propiedad Industrial. Resoluci??n No. 067/2022, de fecha 16/08/2022'));
      $pdf->SetXY(34,$fil+($inc*5));$pdf->Cell(0,0,utf8_decode('Gaceta Oficial de la Rep??blica Bolivariana de Venezuela No. 42.447, de fecha 24/08/2022'));

      if ($reg['solicitud']=='2018-008000') {
        $pdf->SetXY(34,$fil+($inc*6));$pdf->Cell(0,0,utf8_decode('En virtud de haberse corregido en sistema el domicilio del tramitante, ya que en el original ')); 
        $pdf->SetXY(34,$fil+($inc*7));$pdf->Cell(0,0,utf8_decode('que cursa en el Libro de Protocolo de este Registro y expediente de la marca, se emitio el ')); 
        $pdf->SetXY(34,$fil+($inc*8));$pdf->Cell(0,0,utf8_decode('certificado con el domicilio incompleto, siendo corregido en el presente certificado.')); }
      else {
        if ($event902=='S') {
          $pdf->SetXY(34,$fil+($inc*6));$pdf->Cell(0,0,utf8_decode('En virtud de reimpresi??n por error material involuntario, aun cuando fue suscrito en su oportunidad.'));
        } else {
          $pdf->SetXY(34,$fil+($inc*6));$pdf->Cell(0,0,utf8_decode('En virtud de no haber sido firmada por el funcionario competente en su oportunidad.'));
        }
      }
      $pdf->SetFont('Arial','BI',7);
      $pdf->SetXY(34,$fil+($inc*7));
    }
    $pdf->SetFont('Arial','',9);

    //Datos del recibo
    $resultado4=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento-1000 = '66' ");   
    $filas_found4=pg_numrows($resultado4);
    $reg4 = pg_fetch_array($resultado4);
    $resultado5=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento-1000 = '795' ");   
    $filas_found5=pg_numrows($resultado5);
    $reg5 = pg_fetch_array($resultado5);
    if ($filas_found4!= 0) 
       {$pdf->Setxy(178,296);   
        $pdf->Cell(20,4,trim($reg4['documento']),0,1);
        $pdf->Setxy(178,300);
        $pdf->Cell(20,4,$reg4['fecha_event'],0,1);
        $pdf->Setxy(158,307);
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(20,4,utf8_decode("Fecha de Impresi??n: ").$fechahoy,0,1);
    }
    
    //Continuacion de Datos del certificado
    $titular='';
    $pais='';
    $domi='';
    $ind=0;
    //Continuacion de los titulares

    $fil=14; $inc=4; 
    if ($filas_tit>1) { 
       $pdf->AddPage(); 
       $ind=1;
       $pdf->Multicell(120,4,utf8_decode('Continuaci??n de Titulares '));}

    for($cont_tit=1;$cont_tit<$filas_tit;$cont_tit++)   { 
       $res_tit = pg_fetch_array($result_tit);
       $titular=$titular.trim($res_tit['nombre']); 
       $pais_nombre=pais($res_tit['nacionalidad']);
       $pais=$pais.trim($pais_nombre);
       $domi=$domi.trim($res_tit['domicilio']);

       $pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'TITULAR:  '.utf8_decode($titular));
       $pdf->SetXY(14,$fil+($inc*2));$pdf->Cell(0,0,'PAIS:  '.utf8_decode($pais));
       $pdf->SetXY(14,$fil+($inc*3));$pdf->Cell(0,0,'DOMICILIO:  '.utf8_decode($domi));
       $fil=$fil+($inc*4);
       $titular="";
       $pais="";
       $domi="";
    }

    //Continuacion del distingue o etiqueta
    //descripcion de la etiqueta
    $resultado1=pg_exec("SELECT * FROM stmlogos WHERE nro_derecho='$nderec'");
    $filas_found1=pg_numrows($resultado1);
    $reg_etiq = pg_fetch_array($resultado1);
    $num_letras=strlen(trim($reg_etiq['descripcion']));
    $pdf->SetX(14);
    $pdf->Ln(4);
    if ($num_letras>850)
    {
       if ($ind==1){ } else {$pdf->AddPage(); $ind=1;}
       //no corta la palabra lo deja en el espacio anterior del limite
       //$str = trim(substr($reg_etiq['descripcion'],850,9000));
       $str = substr(trim($reg_etiq['descripcion']),strrpos(substr(trim($reg_etiq['descripcion']),0,850),' ')+1,strlen($reg_etiq['descripcion']));
       $str = ' Cont. Etiqueta *** '.$str;
       $pdf->MultiCell(186,4,mb_strtoupper(utf8_decode($str)),0,'J'); 
       $pdf->Ln(3);
    }
     
    //descripcion del distingue
    $pdf->SetX(14);
    $pdf->Ln(4);
    $num_letras=strlen(trim($reg['distingue'])); 
    if ($num_letras>1200)
    {
    
       if ($ind==1){ } else {$pdf->AddPage(); }
       //no corta la palabra lo deja en el espacio anterior del limite
       //$str = trim(substr($reg['distingue'],1320,30000));
       $str = substr(trim($reg['distingue']),strrpos(substr(trim($reg['distingue']),0,1200),' ')+1,strlen($reg['distingue']));
       $str = 'Cont. Distingue *** '.$str;
       //Modificado por Romulo Mendoza 26/12/2017
       //$pdf->MultiCell(180,4,mb_strtoupper(utf8_decode($str)),0,'J'); 
       $pdf->MultiCell(186,4,mb_strtoupper(utf8_decode($str)),0,'J'); 
    }  
    //echo " genera el archivo: $archivo ";
    //$horactual = Hora();
    //$col_campos = "nro_derecho,solicitud,registro,tipo_mp,boletin,estatus,fecha_generado,hora_generado,usuario_genero,ipmaq_gen";
    //$insert_str = "'$nderec','$varsol','$registro','M','$boletin','G','$fechahoy','$horactual','$usuario','$diripmaq'";
    //$insgenerado= $sql->insert("$tbname_1","$col_campos","$insert_str","");
  
    $pdf->Output($archivo);
    $reg = pg_fetch_array($resultado);
  }   

  //ob_end_clean();
  //$filas_found=pg_numrows($resultado); 
  //$reg = pg_fetch_array($resultado);

  //$horactual = Hora();
  //$col_campos = "nro_derecho,solicitud,registro,tipo_mp,boletin,estatus,fecha_generado,hora_generado,usuario_genero,ipmaq_gen";
  //for($cont=0;$cont<50;$cont++) { 
  //  $varsol=$reg[solicitud];
  //  $nderec=$reg[nro_derecho];
  //  $registro  = trim($reg[registro]);
  //  $insert_str = "$nderec,'$varsol','$registro','M',$boletin,'G','$fechahoy','$horactual','$usuario','$diripmaq'";
  //  $insgenerado= $sql->insert("$tbname_1","$col_campos","$insert_str","");
  //  $reg = pg_fetch_array($resultado);
  //}   

		                 
 }                
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
   echo "<p align='center'><a href='../marcas/m_gencertif.php?vopc=1'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</a></p>";
   echo "<br>";
   $smarty->display('pie_pag.tpl'); 
}

if ($vopc==1) {
$smarty->assign('varfocus','forobscon.vsol1'); 
$smarty->display('m_gencertif.tpl');
$smarty->display('pie_pag.tpl');
}
$sql->disconnect();
?>
