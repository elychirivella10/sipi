<? 
// *************************************************************************************
// Programa: b_dividir.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año 
// *************************************************************************************
//Comienzo del Programa 
//ob_start();
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$hh=hora();
$sql = new mod_db(); 
$fecha=fechahoy();  
$fec=hoy();

// Obtencion de variables de los campos del tpl 
$pag_ini = $_POST['pag_ini'];
$pag_fin = $_POST['pag_fin']; 
$nombre  = $_POST['nombre']; 
$archivo1  = $_POST['archivo1']; 
$archivo2 = $_POST['archivo2']; 
$archivo3  = $_POST['archivo3']; 
$archivo4 = $_POST['archivo4']; 
$archivo5 = $_POST['archivo5']; 
$Submit  = $_POST['Submit']; 
$vopc  = $_GET['vopc']; 

//echo $pag_ini;
//echo $nombre;
$smarty ->assign('titulo','Sistema de Boletin'); 
$smarty ->assign('subtitulo','Gestor de Archivos de Boletin'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 

if ($vopc==2) { 

   $command = $command." ../../boletin/boletin_final_N.pdf";
   $command = base64_encode($command); 
   $command = base64_decode($command);
   $output = "../../boletin/".$nombre.".pdf"; 

   $command = "pdftk $command  cat $pag_ini-$pag_fin output $output"; 
 //  echo $command;
   passthru($command); //run the command
}

$smarty->assign('titulo','S.I.P.I.');
$smarty->assign('subtitulo','Gestor de Archivos del Bolet&iacute;n'.$accion); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

$smarty->assign('vopc',$vopc);
$smarty->display('encabezado1.tpl');
$smarty->display('b_dividir.tpl');
$smarty->display('pie_pag1.tpl');
?>

