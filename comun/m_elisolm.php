<?php
// *************************************************************************************
// Programa: m_elisolm.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Realizado Año:  2008
// Modificado Año: 2009 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

$sql = new mod_db();
$tbname_1 = "stmmarce";
$tbname_2 = "stzstder";
$tbname_3 = "stmviena";
$tbname_4 = "stzagenr";
$tbname_5 = "stmccvma";
$tbname_6 = "stzderec";
$fecha    = fechahoy();

$vopc  = $_GET['vopc'];
$vder  = $_POST['vder'];
$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vsol  = $_POST['vsol'];
$vest  = $_POST['vest'];
$modal_id   = $_POST['modal_id'];
$vcomenta   = $_POST['vcomenta'];
$estatus_id = $_POST['estatus_id'];
$nameimage  = $_POST['nameimage'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Expediente / Eliminacion'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol1'); 
$smarty ->assign('vmodo',''); 

//Verificando conexion
$sql->connection($usuario);

$statusbd = Edo_bd();
if ($statusbd=="2") {
   mensajenew("Base de Datos en Mantenimiento, comunicarse con el Administrador del Sistema ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

if (empty($vopc)) { $vest=1000; }

if (!empty($vsol1) && !empty($vsol2))
{
  //Armado del Numero de Expediente
  $vsol=$vsol1."-".$vsol2;
  $dirano=$vsol1;
  //Variable Numero del Expediente
  $varsol=$dirano.$vsol2;
}  
$resultado=true;

if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol1) && empty($vsol2)) {
      mensajenew("No introdujo ningún valor de Expediente ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }
   $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' and solicitud!='' and tipo_mp='M'");
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
      mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }	 
    $reg = pg_fetch_array($resultado);
    $vder=$reg[nro_derecho]; 
    $vsol=$reg[solicitud];
    $vest=$reg[estatus];
   
    $vsol1=substr($vsol,-11,4);
    $vsol2=substr($vsol,-6,6);
    $vreg=$reg[registro];
    $vreg1=substr($vreg,-7,1);
    $vreg2=substr($vreg,1);
    $vnom=$reg[nombre];
    $vtipo=$reg[tipo_derecho];
    $vfecsol=$reg[fecha_solic];
    $vfecreg=$reg[fecha_regis];
    $vfecven=$reg[fecha_venc];
    $vcodage=$reg[agente];
    $vtra=$reg[tramitante];

    //Obtención de datos de la Marca 
    $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
    $objs = $sql->objects('',$obj_query);
    $modal_id  = $objs->modalidad;
    $vclase    = $objs->clase;
    $vindc     = $objs->ind_claseni;

    if ($modal_id=="D") {
      $nameimage="../imagenes/sin_imagen.jpg"; }
    else { $nameimage = ver_imagen($vsol1,$vsol2,"M"); }  

    if (!file_exists($nameimage)) {
      $nameimage="../imagenes/sin_imagen.jpg"; }
    $smarty->assign('ubicacion',$nameimage);

    switch ($modal_id) {
      case "D":
         $modal = "DENOMINATIVA";
         break;
      case "G":
         $modal = "GRAFICA";
         break;
      case "M":
         $modal = "MIXTA";
         break;
    }
    
    switch ($vtipo) {
      case "M":
         $vtip='MARCA DE PRODUCTO';
         break;
      case "N":
         $vtip='NOMBRE COMERCIAL';
         break;
      case "L":
         $vtip='LEMA COMERCIAL';
         break;
      case "S":
         $vtip='MARCA DE SERVICIO';
         break;
      case "C":
         $vtip='MARCA COLECTIVA';
         break;
      case "D":
         $vtip='DENOMINACION DE ORIGEN';
         break;
    }
    switch ($vindc) {
      case "I":
         $vindcla='INTERNACIONAL';
         break;
      case "N":
         $vindcla='NACIONAL';
         break;
    }
    // Nombre del Agente si es el caso      
    if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM $tbname_4 WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      $vtra=$vcodage." - ".$vnomage;
    }
    // Descripcon del estatus 
    $resulest=pg_exec("SELECT * FROM $tbname_2 WHERE estatus='$vest'");
    $regest = pg_fetch_array($resulest);
    $vdesest=$regest[descripcion];
    
    // Titular Actual
    $resultit=pg_exec("SELECT a.titular,b.nombre,b.indole,a.domicilio,a.nacionalidad,c.nombre as nombrep 
                       FROM stzottid a,stzsolic b, stzpaisr c WHERE a.nro_derecho ='$vder' AND  
                       a.titular=b.titular AND a.nacionalidad=c.pais"); 
    $regtit = pg_fetch_array($resultit);
    $vcodtit=$regtit[titular];
    $vnomtit=$regtit[nombre];
    $vnactit=$regtit[nacionalidad];
    $vnadtit=$regtit[nombrep];
    $vdomtit=$regtit[domicilio];

    $smarty->assign('vest',$vest); 
}

if ($vopc==3) 
{
    //Validacion del Numero de Solicitud
    if (empty($vsol1) && empty($vsol2)) {
      mensajenew("No introdujo ningún valor de Expediente ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }

    if ($vest!=1) {
      mensajenew("Solicitud no puede ser eliminada de la Base de Datos, estatus diferente a Presentada ...!!!","m_elisolm.php","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    } 

    //Elimino Datos asociado a la solicitud de la Base de Datos
    $sql->del("stmmarce","nro_derecho='$vder'");
    $sql->del("stzautod","nro_derecho='$vder'");
    $sql->del("stmlemad","nro_derecho='$vder'");
    $sql->del("stzpriod","nro_derecho='$vder'");
    $sql->del("stzottid","nro_derecho='$vder'");
    //$sql->del("stmotold","nro_derecho='$vder'");
    $sql->del("stzliced","nro_derecho='$vder'");
    $sql->del("stzcaded","nro_derecho='$vder'");
    $sql->del("stzotrde","nro_derecho='$vder'");
    $sql->del("stzevtrd","nro_derecho='$vder'");
    $sql->del("stmccvma","nro_derecho='$vder'");
    $sql->del("stmlogos","nro_derecho='$vder'");
    $sql->del("stmliaor","nro_derecho='$vder'");
    $sql->del("stmclnac","nro_derecho='$vder'");
    $sql->del("stmfonetica","nro_derecho='$vder'");
    $sql->del("stzderec","nro_derecho='$vder'");
    //$sql->del("stmbatfon","nro_derecho='$vder'");
    //$sql->del("stmrasgo","solicitud='$vsol'");
    //$sql->del("stmident","solicitud='$vsol'");
    //$sql->del("stmextrem","solicitud='$vsol'");

    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    mensajenew('DATOS ELIMINADOS CORRECTAMENTE !!!','m_elisolm.php','S');
    $smarty->display('pie_pag.tpl'); exit();
}

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro No.:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo5','Clase:');
$smarty->assign('campo6','Nombre:');
$smarty->assign('campo7','Estatus:');
$smarty->assign('campo8','Fecha Registro:');
$smarty->assign('campo9','Fecha Vencimiento:');
$smarty->assign('campo10','Agente/Tramitante:');
$smarty->assign('campo11','Titular:');
$smarty->assign('campo12','Pais:');
$smarty->assign('campo13','Fecha del Evento:');
$smarty->assign('campo14','Cod. Viena:');

$smarty->assign('opcion',$vopc); 
$smarty->assign('vsol1',$vsol1); 
$smarty->assign('vsol2',$vsol2); 
$smarty->assign('vsol',$vsol);
$smarty->assign('vder',$vder); 
$smarty->assign('vreg1',$vreg1);
$smarty->assign('vreg2',$vreg2);
$smarty->assign('vreg',$vreg);
$smarty->assign('vfec',$vfec);
$smarty->assign('nombre',$vnom); 
$smarty->assign('vest',$vest-1000); 
$smarty->assign('vdesest',$vdesest); 
$smarty->assign('vfecsol',$vfecsol); 
$smarty->assign('vfecreg',$vfecreg); 
$smarty->assign('vfecven',$vfecven); 
$smarty->assign('nameimage',$nameimage);
$smarty->assign('modal_id',$modal_id);
$smarty->assign('modal',$modal);
$smarty->assign('vtip',$vtip);
$smarty->assign('vtipo',$vtipo);
$smarty->assign('vclase',$vclase);
$smarty->assign('vindcla',$vindcla);
$smarty->assign('vtra',$vtra);
$smarty->assign('vcodtit',$vcodtit);
$smarty->assign('vnomtit',$vnomtit);
$smarty->assign('vnactit',$vnactit);
$smarty->assign('vnadtit',$vnadtit);
$smarty->assign('vdomtit',$vdomtit);

$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('usuario',$usuario);

$smarty->display('m_elisolm.tpl');
$smarty->display('pie_pag.tpl');
?>
