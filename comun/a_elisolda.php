<?php
// *************************************************************************************
// Programa: a_elisolda.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Realizado Año:  2009  
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];

$sql = new mod_db();
$tbname_1 = "stdobras";
$tbname_2 = "stdstobr";
$tbname_3 = "stzsolic";
$tbname_4 = "stdobsol";
$tbname_5 = "stdidiom";
$tbname_6 = "stdactos";
$fecha    = fechahoy();

$vopc  = $_GET['vopc'];
$vder  = $_POST['vder'];
$vsol  = $_POST['vsol'];
$vest  = $_POST['vest'];

$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Mantenimiento de Expediente / Eliminaci&oacute;n'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol');
$smarty ->assign('modo','readonly'); 
$smarty ->assign('vmodo',''); 

//Verificando conexion
$sql->connection($usuario);

$statusbd = Edo_bd();
if ($statusbd=="2") {
   mensajenew("Base de Datos en Mantenimiento, comunicarse con el Administrador del Sistema ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

$resultado=true;

if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol)) {
      mensajenew("No introdujo ningún valor de Expediente ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }
   $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE solicitud='$vsol' AND solicitud!=''");
}

if ($vopc==1) {
    $smarty ->assign('submitbutton','button'); 
    $smarty ->assign('varfocus','formarcas3.vdoc'); 
    $smarty ->assign('vmodo','readonly'); 

    if (!$resultado) { 
      mensajenew("ERROR AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }	 
    $reg  = pg_fetch_array($resultado);
    $vder = $reg[nro_derecho]; 
    $vsol = $reg[solicitud];
    $vfec = $reg[fecha_solic];
    $vnom = $reg[titulo_obra]; 
    $vtipo= $reg[tipo_obra];
    $vdesc= $reg[descrip_obra];
    $vest = $reg[estatus];
    $vpais= $reg[pais_origen];
    $vidio= $reg[cod_idioma];
    $vplan= $reg[nplanilla];

    switch ($vtipo) {
      case "OL":
         $vtip='OBRA LITERARIA';
         break;
      case "AV":
         $vtip='ARTE VISUAL'; 
         break;
      case "OE":
         $vtip='OBRA ESCENICA';
         break;
      case "OM":
         $vtip='OBRA MUSICAL';
         break;
      case "AR":
         $vtip='AUDIOVISUAL Y RADIOFONICA';
         break;
      case "PC":
         $vtip='PROGRAMA DE COMPUTACION';
         break;
      case "PF":
         $vtip='PRODUCCION FONOGRAFICA';
         break;
      case "AC":
         $vtip='ACTOS YCONTRATOS';
         break;
      case "IE":
         $vtip='INTERPRETACIONES Y EJECUCIONES ARTISTICAS';
         break;
    }

    if ($vtipo=='AC') {
      //Obtención de la datos de la Marca 
      $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE nro_derecho='$vder'");
      $objs = $sql->objects('',$obj_query);
      $vnom = trim($objs->naturaleza); 
      $vdesc= trim($objs->objeto);
    }

    // Descripcon del Idioma  
    $residio = pg_exec("SELECT * FROM $tbname_5 WHERE cod_idioma='$vidio'");
    $regidio  = pg_fetch_array($residio);
    $vdesidio = $regidio[idioma];
    $vidioma   = $vidio." - ".$vdesidio; 

    // Descripcon del estatus 
    $resulest=pg_exec("SELECT * FROM $tbname_2 WHERE estatus=$vest");
    $regest = pg_fetch_array($resulest);
    $vdesest=$regest[descripcion];
    
    // Solicitante Actual
    $resultado=pg_exec("SELECT * FROM stdobsol WHERE nro_derecho='$vder'");
    $reg= pg_fetch_array($resultado);
    $vcodtit= $reg[titular];
    $resultado=pg_exec("SELECT nombre FROM stzsolic WHERE titular='$vcodtit'");
    $reg= pg_fetch_array($resultado);
    $vnomtit= $reg[nombre];    
}

if ($vopc==3) 
{
    //Validacion del Numero de Solicitud
    if (empty($vsol)) {
      mensajenew("No introdujo ningún valor de Expediente ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }

    if ($vest!=1) {
      mensajenew("Solicitud no puede ser eliminada de la Base de Datos, estatus diferente a Presentada ...!!!","a_elisolda.php","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    } 

    //Elimino Datos asociado a la solicitud de la Base de Datos
    $sql->del("stdderiv","nro_derecho='$vder'");
    $sql->del("stdedici","nro_derecho='$vder'");
    $sql->del("stdrepre","nro_derecho='$vder'");
    $sql->del("stdotrde","nro_derecho='$vder'");
    $sql->del("stdactos","nro_derecho='$vder'");
    $sql->del("stdartar","nro_derecho='$vder'");
    $sql->del("stdcaded","nro_derecho='$vder'");
    $sql->del("stdtrans","nro_derecho='$vder'");
    $sql->del("stdfijac","nro_derecho='$vder'");
    $sql->del("stdfijin","nro_derecho='$vder'");
    $sql->del("stdgrupo","nro_derecho='$vder'");
    $sql->del("stdescen","nro_derecho='$vder'");
    $sql->del("stdvisua","nro_derecho='$vder'");
    $sql->del("stdmusic","nro_derecho='$vder'");
    $sql->del("stdobart","nro_derecho='$vder'");
    $sql->del("stdobaut","nro_derecho='$vder'");
    $sql->del("stdobpro","nro_derecho='$vder'");
    $sql->del("stdobpar","nro_derecho='$vder'");
    $sql->del("stdobsol","nro_derecho='$vder'");
    $sql->del("stdobtit","nro_derecho='$vder'");
    $sql->del("stdevtrd","nro_derecho='$vder'");
    $sql->del("stdobras","nro_derecho='$vder'");

    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    mensajenew('DATOS ELIMINADOS CORRECTAMENTE !!!','a_elisolda.php','S');
    $smarty->display('pie_pag.tpl'); exit();
}

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','No. Planilla:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo5','T&iacute;tulo:');
$smarty->assign('campo6','Descripci&oacute;n:');
$smarty->assign('campo7','Estatus:');
$smarty->assign('campo8','Idioma:');
$smarty->assign('campo9','Solicitante:');
$smarty->assign('campo10','Pa&iacute;s Origen:');

$smarty->assign('opcion',$vopc); 
$smarty->assign('vsol',$vsol);
$smarty->assign('vder',$vder); 
$smarty->assign('vfec',$vfec);
$smarty->assign('vnom',$vnom); 
$smarty->assign('vest',$vest); 
$smarty->assign('vtipo',$vtipo);
$smarty->assign('vtip',$vtip);
$smarty->assign('vplan',$vplan);
$smarty->assign('vidioma',$vidioma);
$smarty->assign('vdesc',$vdesc);
$smarty->assign('vdesest',$vdesest);
$smarty->assign('vpais',$vpais); 

$smarty->assign('vcodtit',$vcodtit);
$smarty->assign('vnomtit',$vnomtit);
$smarty->assign('vnactit',$vnactit);
$smarty->assign('vnadtit',$vnadtit);
$smarty->assign('vdomtit',$vdomtit);

$smarty->assign('varfocus','formarcas1.vsol'); 
$smarty->assign('usuario',$usuario);

$smarty->display('a_elisolda.tpl');
$smarty->display('pie_pag.tpl');
?>
