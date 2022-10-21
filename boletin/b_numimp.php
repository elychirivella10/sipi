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
$txtinicial = 0;
$txtfinal  = 1;
while ($pos<=($tope-1)) {
  if ($pos%2==0) { }
  else {

    if ($txtinicial==0) { $txtinicial=1; $txtfinal=0; }
    else { if ($txtfinal==0) { $txtfinal=1; $txtinicial=0; } }
  }
  if ($txtinicial==1) { 
    $inicio = $inicio + 1;
    $siguiente = $inicio;
  }
  if ($txtfinal==1) {
    $final = $final - 1;
    $siguiente = $final;
  }
  $texto = $texto.",".$siguiente;
  $pos = $pos + 1;
}
//echo $texto;
$smarty->display('encabezado1.tpl');
echo "<p>";
echo "<textarea rows='3' name='orden' cols='125'>{$texto} </textarea>";
mensajenew('Copie los numeros de pagina, para colocarlo en las opciones de impresión.','b_numimp.php?vopc=1','S');
$smarty->display('pie_pag1.tpl'); exit();           

}

  
$smarty->assign('titulo','S.I.P.I.');
$smarty->assign('subtitulo','Gestor de Archivos del Bolet&iacute;n'.$accion); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

$smarty->assign('vopc',$vopc);
$smarty->display('encabezado1.tpl');
$smarty->display('b_numimp.tpl');
$smarty->display('pie_pag1.tpl');
?>

