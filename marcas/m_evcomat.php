<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// *************************************************************************************
// Programa: m_evcomat.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "m_evcomat.php";
$evento  = 1987;

$tbname_1 = "stmmarce";
$tbname_2 = "stzstder";
$tbname_3 = "stzevder";
$tbname_4 = "stzagenr";
$tbname_5 = "stzevtrd";
$tbname_6 = "stzderec";

$vopc  = $_GET['vopc'];
$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vreg1 = $_POST['vreg1'];
$vreg2 = $_POST['vreg2'];
$vest  = $_POST['vest'];
$vder  = $_POST['vder'];

$modal_id   = $_POST['modal_id'];
$vcomenta   = $_POST['vcomenta'];
$estatus_id = $_POST['estatus_id'];

// ************************************************************************************  
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizacion de Estatus por Correccion de Error Material');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($usuario=='mvelasquez') || ($usuario=='ngonzalez') || ($usuario=='rmendoza')) { }
else {
  Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo ...!!!","../index1.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}

// ************************************************************************************  
// Control de Entrada y Salida de Conexiones 
$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces + 1; 
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'M'); } 

// ************************************************************************************  
//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol1'); 
$smarty ->assign('vmodo','disabled'); 

if (empty($vopc)) {
  $smarty ->assign('modo2','disabled'); $smarty ->assign('modo1','disabled'); } 

// ************************************************************************************  
//Verificando conexion
$sql->connection($usuario);

// ************************************************************************************  
//Se verifica si el usuario puede o no cargar el evento seleccionado
$aplica = even_rol($role,$evento);
if ($aplica==0) {
   mensajenew('El Usuario NO tiene permiso para Cargar el Evento Seleccionado ...!!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

if (!empty($vsol1) && !empty($vsol2))
{
  //Armado del Numero de Expediente
  $vsol=$vsol1."-".$vsol2;
  $varsol=$vsol1."-".$vsol2;
}  

if (!empty($vreg1) && !empty($vreg2)) { $vreg = $vreg1.$vreg2; }
 
$resultado=true;
//Obtención de los Estatus
$obj_query = $sql->query("SELECT * FROM $tbname_2 order by estatus");
if (!$obj_query) { 
  Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","../salir.php?nconex=".$nconexion,"N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  Mensajenew("Tabla de Estatus Vacia ...!!!","../salir.php?nconex=".$nconexion,"N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$cont = 0;
$arraycodest[$cont]=0;
$arraynombre[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
{ 
  $arraycodest[$cont]=$objs->estatus-1000;
  $arraynombre[$cont]=($objs->estatus-1000).'-'.substr(trim($objs->descripcion),0,80);
  $objs = $sql->objects('',$obj_query);
}

// ************************************************************************************  
  if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol1) && empty($vsol2)) {
     Mensajenew('No introdujo ningún valor de Expediente ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); }
   $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='M'");
  }

// ************************************************************************************  
  if ($vopc==2) {
   //Validacion del Numero de Registro
   if (empty($vreg1) && empty($vreg2))
    {
      Mensajenew('No introdujo ningún valor de Expediente ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
   $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE registro='$vreg' AND registro!='' AND tipo_mp='M'");
  }

// ************************************************************************************  
  if ($vopc==1 || $vopc==2) {
    $smarty ->assign('submitbutton','button'); 
    $smarty ->assign('varfocus','formarcas3.vdoc'); 
    $smarty ->assign('vmodo','readonly'); 
    $smarty ->assign('modo2',''); 
    $smarty ->assign('modo','disabled');    
    $smarty ->assign('modo1',''); 
      
    if (!$resultado) { 
      Mensajenew("ERROR AL PROCESAR LA BUSQUEDA ...!!!","m_evcomat.php?nconexion=".$nconexion."&nveces=".$nveces,"N");
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      Mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!","m_evcomat.php?nconexion=".$nconexion."&nveces=".$nveces,"N");
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $reg = pg_fetch_array($resultado);
    $vsol=$reg[solicitud];
    $vest=$reg[estatus];
    if ($vest!=1026) {
      Mensajenew("CAMBIO DE ESTATUS SOLAMENTE APLICABLE A EXPEDIENTES EN ESTATUS 26 ...!!!","m_evcomat.php?nconexion=".$nconexion."&nveces=".$nveces,"N");
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $vder  = $reg[nro_derecho]; 
    $vsol1 = substr($vsol,-11,4);
    $vsol2 = substr($vsol,-6,6);
    $vreg  = $reg[registro];
    $vreg1 = substr($vreg,-7,1);
    $vreg2 = substr($vreg,1);
    $vnom  = $reg[nombre];
    $vtipo = $reg[tipo_derecho]; 
    $vfecsol = $reg[fecha_solic];
    $vfecreg = $reg[fecha_regis];
    $vfecven = $reg[fecha_venc];
    $vcodage = $reg[agente];
    $vtra    = $reg[tramitante];

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
    // Descripcion del estatus  
    $resulest=pg_exec("SELECT * FROM $tbname_2 WHERE estatus='$vest'");
    $regest  =pg_fetch_array($resulest);
    $vdesest =$regest[descripcion];
    $vest    =$vest - 1000;

    // Obtencion del Titular   
    $obj_query = $sql->query("SELECT a.titular,b.nombre,a.domicilio,a.nacionalidad,c.nombre as nombrep
                              FROM stzottid a,stzsolic b,stzpaisr c 
                              WHERE a.nro_derecho ='$vder' AND  
                                    a.titular=b.titular AND 
                                    a.nacionalidad=c.pais");
    $obj_filas = $sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    $vcodtit = $objs->titular;
    $vnomtit = trim($objs->nombre);
    $vdomtit = trim($objs->domicilio);
    $vnactit = $objs->nacionalidad;
    $vnadtit = $objs->nombrep;
    
  }

// ************************************************************************************  
  if ($vopc==3) {
    if ((empty($vsol) || ($vsol=="0000-000000")) && empty($vreg)) {
      Mensajenew('NO SELECCIONO NINGUN EXPEDIENTE ...!!!','m_evcomat.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    if (empty($estatus_id) || ($estatus_id==0)) {
      Mensajenew('No selecciono el Estatus adecuado ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit();  }

    pg_exec("BEGIN WORK");
 
    $actprim = true;
    $estatus_id = $estatus_id + 1000; 
    //Actualizacion del estatus del expediente en la maestra
    $update_str = "estatus='$estatus_id'";
    $actprim = $sql->update("$tbname_6","$update_str","nro_derecho='$vder'");

    $fechahoy = hoy();
    $horactual = hora();
    $mensa_automa = "CAMBIO DE ESTATUS POR COORDINADOR / CORRECCION DE ERROR MATERIAL";

    $instram = true;
    $vest = $vest + 1000;      
    //Inserto Datos en la tabla de Tramite Stmevtrd
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,comentario,hora";
    $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$vest','$fechahoy','$usuario','$mensa_automa','$vcomenta','$horactual'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");

    if ($actprim AND $instram) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_regsole.php?nconexion=".$nconexion."&nveces=".$nveces,"S");
      $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$actprim) { $error_pri  = " - Maestra de Derecho"; } 
      if (!$instram) { $error_tra  = " - Tr&aacute;mite "; }
      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_pri $error_tra  ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }

    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_evcomat.php?nconexion=".$nconexion."&nveces=".$nveces,"S");
    $smarty->display('pie_pag.tpl'); exit();
  }

// ************************************************************************************  
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
$smarty->assign('campo14','Estatus:');
$smarty->assign('campo15','Documento:');
$smarty->assign('campo16','Comentario:');
$smarty->assign('campo17','Domicilio:');

$smarty->assign('vder',$vder);
$smarty->assign('opcion',$vopc); 
$smarty->assign('vsol1',$vsol1); 
$smarty->assign('vsol2',$vsol2); 
$smarty->assign('vsol',$vsol);
$smarty->assign('vreg1',$vreg1);
$smarty->assign('vreg2',$vreg2);
$smarty->assign('vreg',$vreg);
$smarty->assign('vfec',$vfec);
$smarty->assign('nombre',$vnom); 
$smarty->assign('vest',$vest); 
$smarty->assign('vdesest',$vdesest); 
$smarty->assign('vfecsol',$vfecsol); 
$smarty->assign('vfecreg',$vfecreg); 
$smarty->assign('vfecven',$vfecven); 
$smarty->assign('arraycodest',$arraycodest);
$smarty->assign('arraynombre',$arraynombre);
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
$smarty->assign('nconexion',$nconexion); 
$smarty->assign('nveces',$nveces);  

$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('usuario',$usuario);

$smarty->display('m_evcomat.tpl');
$smarty->display('pie_pag.tpl');
?>
