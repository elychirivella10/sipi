<? 
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
$sql->connection($login);
$fecha=fechahoy();  
$fec=hoy();

// Obtencion de variables de los campos del tpl 
$pag_ini = $_POST['pag_ini'];
$pag_fin = $_POST['pag_fin']; 
$inicio=$pag_ini;
$final=$pag_fin;

$pos    = 1;
$texto  = $final;
$tope   = $final;
$vopc  = $_GET['vopc']; 

$smarty ->assign('titulo','Sistema de Boletin'); 
$smarty ->assign('subtitulo','Gestor de Archivos de Boletin'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 

if ($vopc==2) { 
$resultado=pg_exec("SELECT stzderec.solicitud
			FROM  stzderec, solicitudes
			WHERE stzderec.solicitud = solicitudes.solicitud
			AND stzderec.tipo_mp = 'P'
			AND stzderec.estatus not in (2001,2002,2003,2004,2005,2006,2007,2011,2012,2025,2200,2202) ");

$filas_found=pg_numrows($resultado); 
$registro = pg_fetch_array($resultado);

}
echo $filas_found;


$smarty->assign('titulo','S.I.P.I.');
$smarty->assign('subtitulo','Gestor de Archivos del Bolet&iacute;n'.$accion); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

$smarty->assign('vopc',$vopc);
$smarty->display('encabezado1.tpl');
$smarty->display('p_pdf.tpl');
$smarty->display('pie_pag1.tpl');
?>

