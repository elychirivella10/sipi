<?php
// *************************************************************************************
// Programa: z_enviodoc_ti.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2013 - Adaptado:nrgg
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
$vsol     = $_GET['vsol'];

$fecha_venc=$_POST['fecha_venc'];
$modalidad=$_POST['modalidad'];
$nameimage=$_POST['nameimage'];
$nconex=$_POST['n_conex'];
$vder=$_POST['vder'];
$anno=$_POST['anno'];
$numero=$_POST['numero'];
$fecha_solic=$_POST['fecha_solic'];
$tipo_marca=$_POST['tipo_marca'];
$nombre=$_POST['nombre'];
$estatus=$_POST['estatus'];
$descripcion=$_POST['descripcion'];
$registro=$_POST['registro'];
$eventos_id=$_POST['eventos_id'];
$input2=$_POST['input2'];
$cant_pag=$_POST['cant_pag'];
$fecha_evento=$_POST['fecha_evento'];
$comentario=$_POST['comentario'];
$documento=$_POST['documento'];

$smarty->assign('titulo','Sistema En Line de Propiedad Intelectual Caracas - Venezuela');
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Envio de Documentos'); 
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
   $vname_new=$_POST['vname_new'];
         $ruta=$root_path.'/docutemp/escritos/';  
         $vnewnombre = $vname_new; 
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

         echo "<form name='forevento' action='m_dateven1_ti.php' method='POST'>";
         echo "<input type ='hidden' name='usuario' value={$usuario}>";
         echo "<input type ='hidden' name='role' value={$role}>";
         echo "<input type ='hidden' name='fecha_venc' value='{$fecha_venc}'>";
         echo "<input type ='hidden' name='modalidad' value={$modalidad}>";
         echo "<input type ='hidden' name='nameimage' value={$nameimage}>";
         echo "<input type ='hidden' name='nconex' value='{$n_conex}'>";
         echo "<input type ='hidden' name='vder' value='{$vder}'>";
         echo "<input type ='hidden' name='anno' value='{$anno}'>";
         echo "<input type ='hidden' name='numero' value='{$numero}'>";
         echo "<input type ='hidden' name='fecha_solic' value='{$fecha_solic}'>";
         echo "<input type ='hidden' name='tipo_marca' value='{$tipo_marca}'>";
         echo "<input type ='hidden' name='nombre' value='{$nombre}'>";
         echo "<input type ='hidden' name='estatus' value='{$estatus}'>";
         echo "<input type ='hidden' name='descripcion' value='{$descripcion}'>";
         echo "<input type ='hidden' name='registro' value='{$registro}'>";
         echo "<input type ='hidden' name='eventos_id' value='{$eventos_id}'>";
         echo "<input type ='hidden' name='input2' value='{$input2}'>";
         echo "<input type ='hidden' name='ubicacion' value='{$ubicacion}'>";
         echo "<input type ='hidden' name='cant_pag' value='{$cant_pag}'>";
         echo "<input type ='hidden' name='fecha_evento' value='{$fecha_evento}'>";
         echo "<input type ='hidden' name='comentario' value='{$comentario}'>";
         echo "<input type ='hidden' name='documento' value='{$documento}'>";

         if ($my_upload->upload($vnewnombre)) { 
//            echo "Archivo Cargado Correctamente !!!";
//            echo "<input type='image' src='../imagenes/boton_guardar_rojo.png' value='Guardar'>";
            echo "<H3><p><img src='../imagenes/messagebox_info.png' align='middle'>Archivo Cargado Correctamente !!!</p></H3>"; 
//            echo "<p align='center'><img src='../imagenes/apply_f2.png' border='0'></a>  Continuar  </p>";
            echo "<p align='center'><input type='image' src='../imagenes/apply_f2.png'>Continuar</p>";
            $smarty->display('pie_pag.tpl'); exit(); 
         } else {
           mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit(); 
         } 
         echo "</form>";
  $vopc=1;
}

//Pase de variables y Etiquetas al template
//$smarty->assign('vfecact',$fechahoy);
//$smarty->assign('fecharec',$fecharec);
//$smarty->assign('vopc',$vopc);
//$smarty->assign('vtipo_mp','M');
//$smarty->assign('usuario',$usuario);
//$smarty->assign('vreftra',$vreftra);
//$smarty->assign('vcansol',$vcansol);
//$smarty->assign('vrefsol',$vrefsol);
//$smarty->assign('vnomsol',$vnomsol);
//$smarty->assign('vtipder',$vtipder);
//$smarty->assign('vclaint',$vclaint);
//$smarty->assign('vclanac',$vclanac);
//$smarty->assign('vcodane',$vcodane);
//$smarty->assign('vdesane',$vdesane);
//$smarty->assign('vestane',$vestane);
//$smarty->assign('vsubdir',$vsubdir);
//$smarty->assign('vcanane',$vcanane);
//$smarty->assign('vcanane0',$vcanane0);
//$smarty->assign('verplanilla',$verplanilla);
//$smarty->display('z_enviodoc.tpl');
$smarty->display('pie_pag.tpl');

?>

