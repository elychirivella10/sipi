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
$fecha=fechahoy();  
$fec=hoy();

// Obtencion de variables de los campos del tpl 
$pag_ini = $_POST['pag_ini'];
$pag_fin = $_POST['pag_fin']; 
$nombre  = $_POST['nombre']; 
$Submit  = $_POST['Submit']; 

$smarty ->assign('titulo','Sistema de Boletin'); 
$smarty ->assign('subtitulo','Gestor de Archivos de Boletin'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
echo $submit;
if ($submit=="Concatenar!") {
$commando = "pdftk ../../boletin/boletin.pdf ../../boletin/boletin_sol.pdf cat output /../../boletin/boletin-pdf".time().".pdf";
passthru($commando); //run the command

$uploaddir ='../../boletin/';    //set this to where your files should be uploaded.  Make sure to chmod to 777.

if ($_FILES['file']) {
    $command = "";
    
    foreach($_FILES['file']['type'] as $key => $value) {
    
    $ispdf = end(explode(".",$_FILES['file']['name'][$key]));  //make sure it's a PDF file    
    $ispdf = strtolower($ispdf);

        if ($value && $ispdf=='pdf') {
            //upload each file to the server
            $filename = $_FILES['file']['name'][$key];
            $filename = str_replace(" ","",$filename); //remove spaces from file name
            $uploadfile = $uploaddir . $filename;
            move_uploaded_file($_FILES['file']['tmp_name'][$key], $uploadfile);
            //
            //build an array for the command being sent to output the merged PDF using pdftk
            //$command = $command." files/".$filename;
           $command = $command." ../../boletin/".$filename; 
        }
    }
    
    $command = base64_encode($command); //encode and then decode the command string
    $command = base64_decode($command);

//    $output = "/home/kperez/boletin/boletin-pdf".time().".pdf"; //set name of output file
    $output = "../../boletin/boletin-pdf".".pdf"; //set name of output file
    $command = "pdftk $command cat output $output";
      
    passthru($command); //run the command

  //  ob_end_clean(); 
  //  header(sprintf('Location: %s', $output)); //open the merged pdf file in the browser
}
}

if ($Submit=="Dividir!") {
   $command = $command." ../../boletin/boletin-pdf_N.pdf";
   $command = base64_encode($command); 
   $command = base64_decode($command);
   $output = "../../boletin/".$nombre.".pdf"; 
   $command = "pdftk $command  cat $pag_ini-$pag_fin output $output"; 
   passthru($command); //run the command
}

$smarty->assign('titulo','S.I.P.I.');
$smarty->assign('subtitulo','Gestor de Archivos del Bolet&iacute;n'.$accion); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->assign('list_file',$list_file);
$smarty->assign('elementos',$list_file);
$smarty->assign('ip_local',$ip_local);
$smarty->assign('dir_local',$dir_local);
$smarty->assign('total_file',$cont);
$smarty->assign('iploc',$ip_local);
$smarty->assign('numloop',$cont);
$smarty ->assign('vtip',array("192.8.18.55")); 
$smarty->assign('cols',6);
$smarty->assign('vopc',$vopc);
$smarty->display('encabezado1.tpl');
$smarty->display('b_unionftp.tpl');
$smarty->display('pie_pag1.tpl');
?>

