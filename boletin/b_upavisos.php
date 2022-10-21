<?php
// *************************************************************************************
// Programa: b_upavisos.php 
// Realizado por Romulo Mendoza Adaptado por Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2010
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 
?>

<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 


<?php 
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

//Verificando conexion
$sql = new mod_db();
$sql->connection($usuario);

//Variables
$fecha   = fechahoy();

$vopc=$_GET['vopc'];
//$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$accion=$_POST['accion'];
$nameimage=$_POST['nameimage'];
$ubicacion=$_POST['ubicacion'];

// ****************************************
$smarty->assign('titulo',$substmar);
if (($vopc!=1) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('subtitulo','Mantenimiento de Imagen Ext. / Envio al Servidor'); 
}

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

//Opcion Grabar...
if ($vopc==2) {
  $smarty->assign('subtitulo','Mantenimiento de Imagen Ext. / Envio al Servidor'); 
  $smarty->display('encabezado1.tpl');

  //Verificacion de que los campos requeridos esten llenos...
  //if (empty($vsol1) || empty($vsol2)) {
  if (empty($vsol2)) {
     mensajenew('Hay Informacion basica en el formulario que esta Vacia ...!!!','m_upimagen.php','N');
     $smarty->display('pie_pag.tpl'); exit(); }

  // Ingreso de Solicitud
  if ($accion==1) {
    //Variable para la busqueda de la imagen
    $fechahoy = Hoy();
    $horactual= Hora();

    //$dirano = $vsol1;
    //$varsol=$vsol1."-".$vsol2;
    $varsol=$vsol2;
    //Variable para la busqueda de la imagen
    //$vnewnombre=$dirano.substr($vsol2,-6,6); 
    $vnewnombre=substr($vsol2,-6,6);

    //Variable para la busqueda de la imagen en busqueda
    //$ruta = "/var/www/sistemas/imagenes/logbext/";
    //Maryury
    $ruta= "/graficos/logbext/";
    $archivo = $_FILES['ubicacion']['name'];

    if (!empty($archivo)) {
       //Copiar archivo de logotipo en ruta final
       $max_size = 1; // the max. size for uploading	
       $my_upload = new file_upload;
       //$my_upload->upload_dir = "/var/www/sistemas/imagenes/temp/"; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->extensions = array(".jpg", ".jpge",".png"); // specify the allowed extensions here
       $my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
       $my_upload->rename_file = true;
       $my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
       $my_upload->the_file = $_FILES['ubicacion']['name'];
       $my_upload->http_error = $_FILES['ubicacion']['error'];
       $my_upload->validateExtension();
       if ($my_upload->upload($vnewnombre)) { 
	  echo '';		
       } 
       else {
	  //Mensage_Error($my_upload->show_error_string());
          mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
          $smarty->display('pie_pag.tpl'); 
	  exit(); }
    }
    else {
       mensajenew('Imagen aun NO seleccionada ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    }

  } //Incluir
  // Modificar Solicitud
  else {
    //Variable para la busqueda de la imagen en busqueda
    $ruta= "/graficos/logbext/";
    $archivo = $_FILES['ubicacion']['name'];

    if (!empty($archivo)) {
       //$anterior=$ruta.$vsol1.".jpg";
       $anterior=$ruta.$vsol2.".jpg";
       unlink($anterior);
       //Copiar archivo de logotipo en ruta final
       $max_size = 1024*100; // the max. size for uploading	
       $my_upload = new file_upload;
       //$my_upload->upload_dir = "/var/www/sistemas/imagenes/temp/"; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->extensions = array(".jpg", ".jpge",".png"); // specify the allowed extensions here
       $my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
       $my_upload->rename_file = true;
       $my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
       $my_upload->the_file = $_FILES['ubicacion']['name'];
       $my_upload->http_error = $_FILES['ubicacion']['error'];
       $my_upload->validateExtension();
       if ($my_upload->upload($vsol2)) { 
	  echo '';		
       } 
       else {
	  //Mensage_Error($my_upload->show_error_string());
          mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
          $smarty->display('pie_pag.tpl'); 
	  exit(); }
    }

  } // Modificar

  //Desconexion de la Base de Datos
  $sql->disconnect();

  mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_upimagen.php?vopc=3','S');
  $smarty->display('pie_pag.tpl'); exit();
}

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton','button');
  $smarty->assign('submitbutton3','button');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
  $nameimage="../imagenes/sin_imagen.jpg";
  $smarty->assign('nameimage',$nameimage);
}

if ($vopc==3) {
  //La Fecha de Hoy para la solicitud
  $fecharec = hoy();
  $smarty->assign('subtitulo','Mantenimiento de Imagen Ext. / Envio al Servidor'); 
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('fecharec',$fecharec);
  $smarty->display('encabezado1.tpl');
  $smarty->assign('accion',1);
  $nameimage="../imagenes/sin_imagen.jpg";
  $smarty->assign('nameimage',$nameimage);
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Logotipo :');

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
//$smarty->assign('vsol1',$vsol1);
$smarty->assign('vsol2',$vsol2);
$smarty->assign('nameimage',$nameimage);

$smarty->display('m_upimagen.tpl');
$smarty->display('pie_pag.tpl');
?>
