<? 
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

$smarty ->assign('titulo','Sistema de Marcas'); 
$smarty ->assign('subtitulo','Gestor de Transferencia de Archivos'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 

$vuser = ltrim(rtrim($usuario));              // Usuario Local
$dir_local='/home/'.$vuser.'/memorias';       // Directorio Local

$vopc=$_GET['vopc'];
$ip_local=ltrim(rtrim($_POST['vtip']));
$iploc=ltrim(rtrim($_POST['iploc']));

// Opcion 1 - Entra la primera vez y selecciona la IP local

// Opcion 2 Muestra la lista de archivos
if ($vopc==2) {
   exec('ssh '.$vuser.'@'.$ip_local.' -i /home/www-data/sshids/idrsa-1 ls '.$dir_local,$salida);
   $cont=0;
   foreach($salida as $line) { 
     $list_file[$cont]=ltrim(rtrim($line));
     $cont=$cont+1; 
   }
}

// Opcion 3 - Transfiere los archivos y los borra del directorio local
if ($vopc==3) {
   //Copia
   exec('scp -i /home/www-data/sshids/idrsa-1 '.$vuser.'@'.$iploc.':/home/'.$vuser.
        '/memorias/*.* /apl/memorias');
   //Guardar registros
   
   //Borra
   exec('ssh '.$vuser.'@'.$iploc.' -i /home/www-data/sshids/idrsa-1 rm '.$dir_local.'/*.*');
}

$smarty->assign('titulo','S.I.P.I.');
$smarty->assign('subtitulo','Gestor de Transferencia de Archivos'.$accion); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->assign('list_file',$list_file);
$smarty->assign('elementos',$list_file);
$smarty->assign('ip_local',$ip_local);
$smarty->assign('dir_local',$dir_local);
$smarty->assign('total_file',$cont);
$smarty->assign('iploc',$ip_local);
$smarty->assign('numloop',$cont);
$smarty ->assign('vtip',array("192.8.18.56","192.8.18.57","192.8.18.55","192.8.18.58")); 
$smarty->assign('cols',6);
$smarty->assign('vopc',$vopc);
$smarty->display('encabezado1.tpl');
$smarty->display('sipi_ftp.tpl');
$smarty->display('pie_pag.tpl');
?>
