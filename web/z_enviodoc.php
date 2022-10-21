<?php
// *************************************************************************************
// Programa: z_enviodoc.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2010 II Semestre
// *************************************************************************************
//include ("../setting.inc.php");
include ("../setting.inc.pruebafm02.php");
ob_start();
//Para trabajar con Operaciones de Bases de Datos
//include ("../z_includes.php");
include ("../z_includes.pruebafm02.php");
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
$vreftra  = $_GET['vreftra'];
$verplanilla='N';
//$documento_path='/var/www/apl/sipi2011/graficos/docutemp';

$smarty->assign('titulo','Sistema En Line de Propiedad Intelectual Caracas - Venezuela');
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
    $sql1 = new mod_db();
    $sql1->connection1();
   //$vubica  = $_GET['ubicacion'];
   $ubicacion = $_FILES['ubicacion']['name'];
   $vsol = $_GET['vsol'];
   $vcod = $_GET['vcod'];
   $vsub = $_GET['vsub'];
//mensajenew('Bien: Solicitud'.$vsol.'- Ubicacion:'.$ubicacion.'- vcod:'.$vcod.'- vsub:'.$vsub,'javascript:history.back();','N');
//$smarty->display('pie_pag.tpl'); exit(); 
         $ruta=$documento_path.$vsub; 
         $vnewnombre = $vsol; 
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
            echo '';		
            $update_str="estatus='1',documento='$ubicacion'";
            $update_cond="nro_tramite='$vreftra' and solicitud='$vsol' and cod_anexo='$vcod'";
            $valido = pg_exec("update stzanxtra set estatus='1',documento='$ubicacion' where nro_tramite='$vreftra' and solicitud='$vsol' and cod_anexo='$vcod'");
            if (!$valido) {$can_error=$can_error+1;}
            // Verificar y actualizar estatus del tramite
            $resulfinal=pg_exec("select * from stzanxtra where nro_tramite='$vreftra' and estatus='0'");
            $vcanfin=pg_numrows($resulfinal); 
            if ($vcanfin==0) {
               $verplanilla='S';
               $update_str="estatus_tra='09', fecha_estatus='$fechahoy'";
               $update_cond="nro_tramite='$vreftra'";
               $valido = pg_exec("update stztramite set estatus_tra='09', fecha_estatus='$fechahoy' where nro_tramite='$vreftra'");
               if (!$valido) {$can_error=$can_error+1;}
            }
            $sql1->disconnect1();
            mensajenew('Archivo Cargado Correctamente !!!',"w_planilla.php?vsol=$vsol&vtramt=$vreftra&vopc=4",'S');
            $smarty->display('pie_pag.tpl'); exit(); 
         } else {
            mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
            //mensajenew($my_upload->show_error_string(),"z_enviodoc.php?vopc=1&vreftra=$vreftra","N");
            $smarty->display('pie_pag.tpl'); exit(); 
         } 
  $vopc=1;
}

if ($vopc==1) {
   $resulfinal=pg_exec("select * from stzanxtra where nro_tramite='$vreftra' and estatus='0'");
   $vcanfin=pg_numrows($resulfinal); 
   if ($vcanfin==0) {$verplanilla='S';}
   //
   $resultadosoltra=pg_exec("select a.nro_tramite,a.solicitud,a.nombre,a.tipo_derecho,b.clase,c.clase_nac,d.usuario from stzderec a,stmmarce b,stmclnac c,stztramite d where a.nro_tramite='$vreftra' and a.nro_tramite=b.nro_tramite and a.solicitud=b.solicitud and a.nro_tramite=c.nro_tramite and a.solicitud=c.solicitud and a.nro_tramite=d.nro_tramite order by a.nro_tramite,a.solicitud");
   $vcansol=pg_numrows($resultadosoltra); 
   $regsoltra = pg_fetch_array($resultadosoltra); 
   $vusuario=$regsoltra['usuario'];
   if ($vusuario<>$usuario) {
     mensajenew('Error: El Tramite pertenece a otro Usuario! Verifique...','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); 
   }
   if ($vcansol<1) {
     mensajenew('Error: Tramite No Registrado! Verifique...','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); 
   }
   for($cont=1;$cont<=$vcansol;$cont++) { 
     $vnumsol=$regsoltra['solicitud'];
     $vrefsol[$cont]=$regsoltra['solicitud'];
     $vnomsol[$cont]=$regsoltra['nombre'];
     $vtipder[$cont]=$regsoltra['tipo_derecho'];
     $vclaint[$cont]=$regsoltra['clase'];
     $vclanac[$cont]=$regsoltra['clase_nac'];
$resultadodocsol0=pg_exec("select a.cod_anexo,a.estatus,b.desc_anexo,b.ruta from stzanxtra a,stzanexo b where nro_tramite='$vreftra' and solicitud='$vnumsol' and a.cod_anexo=b.cod_anexo and a.estatus='0' order by 1");
     $vcandoc0=pg_numrows($resultadodocsol0); 
     $vcanane0[$cont]=$vcandoc0;
     $resultadodocsol=pg_exec("select a.cod_anexo,a.estatus,b.desc_anexo,b.ruta from stzanxtra a,stzanexo b where nro_tramite='$vreftra' and solicitud='$vnumsol' and a.cod_anexo=b.cod_anexo order by 1");
     $vcandoc=pg_numrows($resultadodocsol); 
     $vcanane[$cont]=$vcandoc;
     for($cont2=1;$cont2<=$vcandoc;$cont2++) { 
        $regdocsol = pg_fetch_array($resultadodocsol); 
        $vcodane[$cont][$cont2]=$regdocsol['cod_anexo'];
        $vdesane[$cont][$cont2]=$regdocsol['desc_anexo'];
        $vestane[$cont][$cont2]=$regdocsol['estatus'];
        $vsubdir[$cont][$cont2]=$regdocsol['ruta'];
     }
     $regsoltra = pg_fetch_array($resultadosoltra); 
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
$smarty->display('z_enviodoc.tpl');
$smarty->display('pie_pag.tpl');

?>

