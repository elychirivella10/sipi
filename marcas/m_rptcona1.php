<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();
include ("../z_includes.php");
//include ("$include_lib/librepor.php");
//require("$include_lib/MPDF45/mpdf.php");

require("$include_lib/class.ezpdf.php");
//Table Base Classs
//require_once("$include_lib/class.fpdf_table.php");
	
//Class Extention for header and footer	
//require_once("$include_lib/header_footer.inc");
//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection($login);

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Consulta de Expedientes de Solicitudes de Marcas";
//$linea="___________________________________________________________________________________________";

//Pantalla Titulos
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Consulta Abierta de Marcas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol1h=$_POST["vsol1h"];
$varsol2h=$_POST["vsol2h"];
$nconex = $_POST['nconex'];

//Formateando los campos solicitud y registro
$varsol= $varsol1.'-'.$varsol2;
$varsolh= $varsol1h.'-'.$varsol2h;

// Verificacion de que los campos requeridos esten llenos...
  if (($varsol=='0000-000000') and ($varsolh=='0000-000000')) {
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!",'javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

// Verificacion que el rango de solicitud este correcto
if ($varsolh <$varsol){ 
     mensajenew('Rango de Solicitudes Erroneo ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Query para buscar las opciones deseadas
if (($varsol!='-0') and ($varsolh!='-0')) {
   $resultado=pg_exec("SELECT  clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stmmarce a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND tipo_mp='M' 
		        AND b.solicitud between '$varsol' and '$varsolh' ORDER BY b.solicitud");
   $titulo= $titulo." Solicitud Inicial:"." $varsol"." Hasta: "." $varsolh"; 	
}

//verificando los resultados
if (!$resultado)    { 
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');   
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }  
$reg = pg_fetch_array($resultado);

//Inicio del Pdf
//$mpdf=new mPDF();
$pdf =& new Cezpdf('a4');

$smarty->assign('n_conex',$nconex);  
//Inicio de ciclo 

for($cont=0;$cont<$filas_found;$cont++) 
{

$varsol=$reg['solicitud'];
$nregis=$reg['registro'];
$nagen=$reg['agente'];
$nderec=$reg['nro_derecho'];

//Busqueda de Tablas necesarias

//imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
$nameimage=ver_imagen($varsol1,$varsol2,'M');


$vporc='83%';
if ($reg['modalidad']!="D")
   {$vporc='55%';} 

//imagen
if (file($nameimage)) 
   {


$pdf->ezImage("http://imagenes.sapi.gob.ve/marcas/ef1995/1995000001.jpg", 0, 420, 'none', 'left');



$pdf->ezText('Caracas, '.$reg['fecha_solic']);








      //   $mpdf->WriteHTML("<img src= 'file:///imagenes.sapi.gob.ve/marcas/ef1995/1995000001.jpg'>"); 
   
//    $prueba= "<A href='http://imagenes.sapi.gob.ve/marcas/ef1995/1995000001.jpg'> 'pulsar' </a>";
//    $prueba2 = "<img src= 'http://imagenes.sapi.gob.ve/marcas/ef1995/1995000001.jpg'>";
 
        //$mpdf->myvariable = file_get_contents('../../../graficos/marcas/ef1995/1995000001.jpg');
//$mpdf->myvariable = file_get_contents('http://imagenes.sapi.gob.ve/marcas/ef1995/1995000001.jpg');

//$html = '<img src="var:myvariable" />';
//$mpdf->WriteHTML($html);
//$mpdf->Image('var:myvariable',0,0);
 

  //  $prueba2 = "<img src= '$prueba'>";  
  //  $mpdf->WriteHTML($prueba); 
 //    $mpdf->WriteHTML($prueba2);    
 //  $pdf->Image('imagenes.sapi.gob.ve/marcas/ef1995/1995000001.jpg',0,10,8,33,'jpg');  
  //echo "<img src= 'http://imagenes.sapi.gob.ve/marcas/ef1995/1995000001.jpg' >"; 
//  echo "<img src= 'http://imagenes.sapi.gob.ve/graficos/marcas/ef'.$varsol1.'/'.$varsol1.$varsol2.'.jpg' >"; 
   }
  //  $pdf->Cell(10,5,$ruta,0,0); 
    //Imprimiendo los resultados    
    //Muestra campos principales de la cronologia
  //  $mpdf->WriteHTML('Caracas, '.$reg['fecha_solic']);      
  //  $mpdf->WriteHTML($varsol); 

   


$reg = pg_fetch_array($resultado);
if  ($cont+1!=$filas_found) {//$pdf->AddPage();
}
}
   
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
// $mpdf->Output();
$pdf->ezStream();
?>
