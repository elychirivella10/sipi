<?php
// *************************************************************************************
// Programa: z_enviodoc.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2010 II Semestre
// *************************************************************************************
include ("../setting.inc.php");
ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario   = $_SESSION['usuario_login'];
$role      = $_SESSION['usuario_rol'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();
$vopc     = $_GET['vopc'];
$verplanilla='N';

$smarty->assign('titulo','Documentos Expediente Electr&oacute;nico');
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Solicitud de Marca'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->assign('vmodo','normal');
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

// Primera entrada, hay que ubicar todas las solicitudes del tramite
if (empty($vopc)) {
   $vopc=0;
}

if ($vopc==2) {
   $ubicacion = $_FILES['ubicacion']['name'];
   $vsol = $_GET['vsol'];
   $vsub = $_GET['vsub'];

         $ruta=$fdocumento_path.$vsub; 
         $vnewnombre = substr($vsol,0,4).substr($vsol,5,6); 
         $tipodoc=substr($vsub,1,8);
         if ($tipodoc=='escritos') {
            $total_escritos = count(glob($ruta.$vnewnombre.'*.*',GLOB_BRACE));
            if ($total_escritos>0) {
               $correlativo=$total_escritos+1;
               $vnewnombre=$vnewnombre.'_'.$correlativo;
            } 
         }
         $max_size = 50; 
         $my_upload = new file_upload;
         $my_upload->upload_dir = $ruta; 
         $my_upload->extensions = array(".pdf"); 
         $my_upload->max_length_filename = 50; 
         $my_upload->rename_file = true;
         $my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
         $my_upload->the_file = $_FILES['ubicacion']['name'];
         $my_upload->http_error = $_FILES['ubicacion']['error'];
         $my_upload->validateExtension();
         if ($my_upload->upload($vnewnombre)) { 
            //$sql1->disconnect1();
            mensajenew('Archivo Cargado Correctamente !!!'.$total_escritos,"m_rptpexp1_esc.php?vsol=$vsol",'S');
            $smarty->display('pie_pag.tpl'); exit(); 
         } else {
            mensajenew($my_upload->show_error_string(),"m_rptpexp1_esc.php?vsol=$vsol",'S');
            $smarty->display('pie_pag.tpl'); exit(); 
         } 
}

//Pase de variables y Etiquetas al template
$smarty->assign('vfecact',$fechahoy);
$smarty->assign('fecharec',$fecharec);
$smarty->assign('vopc',$vopc);
$smarty->assign('vtipo_mp','M');
$smarty->assign('usuario',$usuario);
$smarty->assign('vreftra',$vreftra);
$smarty->assign('vcansol',$vcansol);
$smarty->assign('vrefsol',$vrefsol);
$smarty->assign('vnomsol',$vnomsol);
$smarty->assign('vtipder',$vtipder);
$smarty->assign('vclaint',$vclaint);
$smarty->assign('vclanac',$vclanac);
$smarty->assign('vcodane',$vcodane);
$smarty->assign('vdesane',$vdesane);
$smarty->assign('vestane',$vestane);
$smarty->assign('vsubdir',$vsubdir);
$smarty->assign('vcanane',$vcanane);
$smarty->assign('vcanane0',$vcanane0);
$smarty->assign('verplanilla',$verplanilla);
$smarty->display('z_enviodoc_esc.tpl');
$smarty->display('pie_pag.tpl');

?>

