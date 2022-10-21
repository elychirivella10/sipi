<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();

include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_tablesep.php");

//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection($login);

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }
;

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Cronologia Administrativa";
$linea="_________________________________________________________________________________________________";

//Pantalla Titulos
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Consulta de Expediente Electr&oacute;nico');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
// Obtencion de variables de los campos del tpl 
//$vopc   = $_GET['vopc'];
//$varsol1=$_POST["vsol1"];
$varsol=$_GET["varsol"];

//$varsol=($varsol1.'-'.$varsol2);

//Query para buscar las opciones deseadas
//Inicio del PDF
$pdf=new PDF_Table('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->Image('../imagenes/planilla_marcas.jpg',3,0,205,330,'JPEG');


//Verificando Segunda conexion
$sql = new mod_db();
$sql->connection();
       
// Armando el query segun el numero de tramite
$resultado = pg_exec("SELECT * FROM stzderec WHERE  solicitud = '$varsol' AND tipo_mp = 'M' ");
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

if ($filas_resultado==0) {
   //echo " No Existe el Numero de Solicitud "; exit();}
   mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   
 
// Inicio del Formulario
// for($cont=0;$cont<$filas_resultado;$cont++) { 
 
      $nsolic = $registro['solicitud'];
      $nderec = $registro['nro_derecho'];
      $nagen = $registro['agente'];
  

$sql->disconnect();
ob_end_clean();        
//$pdf->Output($varsol.".pdf");  

//Union de los Pdf
       //  $salida= "exp_".$varsol.".pdf";
         $vsol1=substr($nsolic,-11,4);
         $vsol2=substr($nsolic,-6,6);
         $varsol=$vsol1.$vsol2;       
         $salida= "../documentos/escritos/marcas/".$varsol.".pdf";

//         if ($ind_logo== 1) { $pdf->Text(170,325,'X',0,1); } // busqueda grafica      
//         else  { $pdf->Text(170,321,'X',0,1); } // busqueda fonetica         
       
         //$name =$varsol.".pdf"; 
         //if (file($name)) { $ruta = $name; } // formulario
         $ruta='';
         $name ="../documentos/escritos/marcas/ef".$vsol1."/".$varsol.".pdf"; 
         if (file($name)) { $ruta = $ruta." 	 ".$name; } 

         $total_escritos = count(glob("../documentos/escritos/marcas/ef$vsol1/$varsol"."*.*",GLOB_BRACE));
         if ($total_escritos>1) {
            for($cont=2;$cont<=$total_escritos;$cont++) { 
               $name ="../documentos/escritos/marcas/ef".$vsol1."/".$varsol."_".trim($cont).".pdf"; 
               if (file($name)) { $ruta = $ruta." 	 ".$name; } 
            }
         }
         
         //comando para unir los pdf
         $commando = "pdftk  $ruta cat  output $salida";
         passthru($commando); //run the command

	//Borro el archivo que genera el formulario de la solicitud
         $local =$varsol.".pdf"; 
         unlink("$local");
         
// rutina para visualizar el pdf generado   
$mi_pdf = $salida;
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="'.$mi_pdf.'"');
readfile($mi_pdf);
exec("rm $salida");   
?>
