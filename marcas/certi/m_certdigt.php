<?php
ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Para trabajar con Smarty 
require ("$root_path/include.php");
include ("$include_lib/librar_cert.php");
$fecha   = fechahoy();

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/fpdf.php");

//Conexion
$sql = new mod_db();
$sql->connection();

//Pantalla Titulos

$smarty->assign('subtitulo','Certificados de Registro de Marcas');
$smarty->assign('fechahoy',$fecha);
//$smarty->display('encabezado.tpl');

//Validacion de Entrada
$registrod1=$_POST["vreg1d"];
$registroh1=$_POST["vreg2d"];


$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];

$varsol2 = str_pad($varsol2, 6, '0', STR_PAD_LEFT); 
$registroh1 = str_pad($registroh1, 6, '0', STR_PAD_LEFT); 

//echo $varsol2;
//echo $registroh1;
$registrod= $registrod1.$registroh1;
$varsol=($varsol1.'-'.$varsol2);

//echo $registrod;
//Query para buscar los certificados de marcas en el rango correspondiente
if((!empty($registrod)) and ($registrod!= '000000')) {  
   $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho
		       AND tipo_mp='M' 
		       AND b.estatus= 1555
		       AND b.registro =  '$registrod' ");
}
if((!empty($varsol)) and ($varsol != '-000000')) {  

   $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho
		       AND tipo_mp='M' 
		       AND b.estatus = 1555
		       AND b.solicitud = '$varsol' and b.solicitud!='' ");

}

//verificando los resultados
if (!$resultado) { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();     exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Error: No existe el Nro. de Registro o Solicitud ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();     exit(); 
      } 
$reg = pg_fetch_array($resultado);


//Se obtiene el proximo valor para el secuencial a guardara partir de stzsistem
$obj_query = $sql->query("update stzsystem set ncertmar=nextval('stzsystem_ncertmar_seq')");


//Incio de la Clase de PDF para generar los reportes

//Inicio del Pdf
$pdf=new FPDF('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);
$pdf->Image('../imagenes/certmarcas.jpg',3,0,205,330,'JPEG');

  	
  for($cont=0;$cont<$filas_found;$cont++)   { 

	//tipo de marca
	$vtip=tipo_marca($reg['tipo_marca']);

	if ($reg['clase']=='46') {$vclas='NC';}
	if ($reg['clase']=='47') {$vclas='LC';}
	if (($reg['clase']!='46') and ($reg['clase']!='47')) {$vclas=$reg['clase'];}

    $varsol=$reg['solicitud'];
    $nderec=$reg['nro_derecho'];
    $pdf->Setxy(42,70);
    $pdf->Cell(20,4,$reg['registro'],0,1); 
    $pdf->Setxy(42,75);
    $pdf->Cell(20,4,$reg['fecha_regis'],0,1);
    $pdf->Setxy(42,81);
    $pdf->Cell(75,4,$reg['fecha_venc'],0,0);
    $pdf->Setxy(128,84);
    $pdf->Cell(60,4,$vtip,0,0);
    $pdf->Setxy(193,84);
    $pdf->Cell(40,4,$vclas,0,1);
    $pdf->Setxy(42,86);
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

  $pdf->Setxy(42,97);
  $pdf->Cell(40,4,utf8_decode($titular));
  $pdf->Setxy(42,102);  
  $pdf->Cell(30,4,utf8_decode($pais));
  $pdf->Setxy(42,107);
  $pdf->Cell(50,4,utf8_decode($domi));

//Nombre de la Marca
    $pdf->Setxy(10,129);   
    $pdf->MultiCell(85,4,trim(utf8_decode($reg['nombre'])),0,'J');
   
    //descripcion de la etiqueta
    $resultado1=pg_exec("SELECT * FROM stmlogos WHERE nro_derecho='$nderec'");
    $filas_found1=pg_numrows($resultado1);
    $reg_etiq = pg_fetch_array($resultado1);
    $pdf->Setxy(8,148); 
    $num_letras=strlen(trim($reg_etiq['descripcion']));

    if ($num_letras>720)
    {
       //no corta la palabra lo deja en el espacio anterior del limite
       $str = trim(substr($reg_etiq['descripcion'],0,720));
       //$str = substr($str, 0, 680-strlen(strrchr($str, " ")));
       $str = strtoupper($str).' *****';
       $pdf->MultiCell(98,4,utf8_decode($str),0,'J'); 
    }

    if ($num_letras<720) {$pdf->MultiCell(98,4, trim(strtoupper(utf8_decode($reg_etiq['descripcion']))),0,'J');}

    //imagen
		$varsol1=substr($varsol,-11,4);
		$varsol2=substr($varsol,-6,6);
	        $nameimagen=ver_imagen($varsol1,$varsol2,'M');

                if (($reg['modalidad']!="D") AND file($nameimagen)) {
    		     $pdf->Image($nameimagen,122,128,80,80,'JPG');  }
       
    //descripcion del distingue
    $pdf->Setxy(8,220);  
    $num_letras=strlen(trim(utf8_decode($reg['distingue']))); 

    if ($num_letras>1330)    {
       //no corta la palabra lo deja en el espacio anterior del limite
       $str = trim(substr($reg['distingue'],0,1330));
     //  $str = substr($str, 0, 1320-strlen(strrchr($str, " ")));
      
  //     $texto= trim($reg['distingue']);
  //     $cantidadCaracteres = 1320;
  //     $str= substr($texto,0,strrpos(substr($texto,0,$cantidadCaracteres)," "));
       
       $str = strtoupper($str).' *****';      
       
       $pdf->MultiCell(188,4,utf8_decode($str),0,'J'); 
    }

    
    if ($num_letras<1470) { $pdf->MultiCell(188,4,trim(strtoupper(utf8_decode($reg['distingue']))),0,'J');}


// firma y leyenda
$pdf->SetFont('Arial','B',9);
$fil=287; $inc=4; 
$pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'__________________________________________');
//$pdf->SetXY(34,$fil+($inc*2));$pdf->Cell(0,0,utf8_decode('Castiela Velásquez'));
$pdf->SetXY(18,$fil+($inc*3));$pdf->Cell(0,0,'Registrador de la Propiedad Industrial');
$pdf->SetFont('Arial','BI',8);
$pdf->SetFont('Arial','',9);
//$pdf->SetXY(14,308);

    // Datos del recibo
    $resultado4=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento-1000 = '65' ");   
    $filas_found4=pg_numrows($resultado4);
    $reg4 = pg_fetch_array($resultado4);
    $resultado5=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento-1000 = '795' ");   
    $filas_found5=pg_numrows($resultado5);
    $reg5 = pg_fetch_array($resultado5);
    if ($filas_found4!= 0) 
       {$pdf->Setxy(165,291);   
        $pdf->Cell(20,4,trim($reg4['documento']),0,1);
        $pdf->Setxy(165,296);
        $pdf->Cell(20,4,$reg4['fecha_event'],0,1);
    //    $pdf->Setxy(165,308);
   //     $pdf->Cell(20,4,number_format($reg5['documento']),0,1);
       }
    
    
    
    
    
    
 //   $reg = pg_fetch_array($resultado);
 //   if  ($cont+1!=$filas_found) {$pdf->AddPage();}

   //}     
   

    
// Continuacion de Datos del certificado

    $ind==0;
// Continuacion de los titulares

    $resultado3 = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
    $filas_found3=pg_numrows($resultado3);
    $reg_tit = pg_fetch_array($resultado3);
    $fil=14; $inc=4; 
    if ($filas_found3>1) {
       $pdf->AddPage(); 
       $ind=1;
       $pdf->Multicell(120,4,utf8_decode('Continuación de Titulares '));}

    for($cont_tit=1;$cont_tit<$filas_found3;$cont_tit++)   { 
       $titular=$titular.trim($reg_tit['nombre']); 
       $pais_nombre=pais($reg_tit['nacionalidad']);
       $pais=$pais.trim($pais_nombre);
       $domi=$domi.trim($reg_tit['domicilio']);

       $pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'TITULAR:  '.utf8_decode($titular));
       $pdf->SetXY(14,$fil+($inc*2));$pdf->Cell(0,0,'NACIONALIDAD:  '.utf8_decode($pais));
       $pdf->SetXY(14,$fil+($inc*3));$pdf->Cell(0,0,'DOMICILIO:  '.utf8_decode($domi));
       $fil=$fil+($inc*4);
       $reg_tit = pg_fetch_array($resultado3);
   }

//Continuacion del distingue o etiqueta

    //descripcion de la etiqueta
    $resultado1=pg_exec("SELECT * FROM stmlogos WHERE nro_derecho='$nderec'");
    $filas_found1=pg_numrows($resultado1);
    $reg_etiq = pg_fetch_array($resultado1);
    $num_letras=strlen(trim($reg_etiq['descripcion']));
    $pdf->SetX(14);
    $pdf->Ln(4);
    if ($num_letras>720)
    {
       if ($ind==1){ } else {$pdf->AddPage(); }
       //no corta la palabra lo deja en el espacio anterior del limite
       $str = trim(substr($reg_etiq['descripcion'],720,5000));
       //$str = substr($str, 0, 1480-strlen(strrchr($str, " ")));
       $str = ' Cont. Etiqueta *****    '.strtoupper($str);
       $pdf->MultiCell(180,4,utf8_decode($str),0,'J'); 
       $pdf->Ln(3);
    }
     
    //descripcion del distingue
    $pdf->SetX(14);
    $pdf->Ln(4);
    $num_letra=strlen(trim(utf8_decode($reg['distingue']))); 

    //if ($num_letras>1470)
    if ($num_letra>1330)
    {
    
       if ($ind==1){ } else {$pdf->AddPage(); }
       //no corta la palabra lo deja en el espacio anterior del limite
       $str = trim(substr($reg['distingue'],1330,5000));
       
    //   $texto= trim($reg['distingue']);
    //   $cantidadCaracteres = 5000;
    //   $str= substr($texto,1310,strrpos(substr($texto,1310,$cantidadCaracteres)," "));
       
       
       //$str = substr($str, 0, 1480-strlen(strrchr($str, " ")));
       $str = 'Cont. Distingue *****     '.strtoupper($str);
       $pdf->MultiCell(180,4,utf8_decode($str),0,'J'); 
    }  

}

 
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
