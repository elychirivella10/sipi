<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// ************************************************************************************* 
// Programa: p_evcomat.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año 2006 
// Modificado Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$fecha   = fechahoy();

$tbname_1 = "stppatee";
$tbname_2 = "stzstder";
$tbname_3 = "stzevder";
$tbname_4 = "stzagenr";
$tbname_5 = "stzevtrd";
$tbname_6 = "stzderec";

$evento = 2987;

$vopc  = $_GET['vopc'];
$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vreg1 = $_POST['vreg1'];
$vreg2 = $_POST['vreg2'];
$vest  = $_POST['vest'];
$vder  = $_POST['vder'];

$vcomenta = $_POST['vcomenta'];
$estatus_id=$_POST['estatus_id'];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Actualizacion de Estatus por Correccion de Error Material');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol1'); 
$smarty ->assign('vmodo','disabled'); 

if (empty($vopc)) {
  $smarty ->assign('modo2','disabled'); } 

//Verificando conexion
$sql->connection($usuario);

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
if (!empty($vreg1) && !empty($vreg2))
  { $vreg = $vreg1.$vreg2; }
  
$resultado=true;

//Obtención de los Estatus
$obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE tipo_mp='P' ORDER BY estatus");
if (!$obj_query) { 
  mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','index1.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  mensajenew('Tabla de Estatus Vacia ...!!!','index1.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$cont = 0;
$arraycodest[$cont]=0;
$arraynombre[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
{ 
  $arraycodest[$cont]=sprintf("%03d",$objs->estatus-2000);
  $arraynombre[$cont]=sprintf("%03d",$objs->estatus-2000).'-'.substr(trim($objs->descripcion),0,80);
  $objs = $sql->objects('',$obj_query);
}

  if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol1) && empty($vsol2)) {
     mensajenew('No introdujo ningún valor de Expediente ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); }
   $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='P'");
  }

  if ($vopc==2) {
   //Validacion del Numero de Registro
   if (empty($vreg1) && empty($vreg2))
    {
      mensajenew('No introdujo ningún valor de Expediente ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
   $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE registro='$vreg' AND registro!='' AND tipo_mp='P'");
  }
  
  if ($vopc==1 || $vopc==2) {
    $smarty ->assign('submitbutton','button'); 
    $smarty ->assign('varfocus','formarcas3.vdoc'); 
    $smarty ->assign('vmodo','readonly'); 
    $smarty ->assign('modo2',''); 
    $smarty ->assign('modo','disabled');    
      
    if (!$resultado) { 
      mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','p_evcomat.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','p_evcomat.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $reg = pg_fetch_array($resultado);
    $vsol=$reg[solicitud];
    $vest=$reg[estatus];

    if ($vest!=2026) {
      mensajenew('CAMBIO DE ESTATUS SOLAMENTE APLICABLE A EXPEDIENTES EN ESTATUS 26 ...!!!','p_evcomat.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    $vder=$reg[nro_derecho];
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

    switch ($vtipo) {
      case "A":
         $vtip='INVENCION';
         break;
      case "B":
         $vtip='DIBUJO INDUSTRIAL';
         break;
      case "G":
         $vtip='DISEÑO INDUSTRIAL';
         break;
      case "E":
         $vtip='MODELO INDUSTRIAL';
         break;
      case "F":
         $vtip='MODELO DE UTILIDAD';
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
    $vdesest = estatus($vest);

    // Titular Actual
    $resultit=pg_exec("SELECT a.titular,b.nombre,a.nacionalidad,a.domicilio,c.nombre as nombrep 
                       FROM stzottid a, stzsolic b, stzpaisr c 
                       WHERE a.nro_derecho='$vder' and a.titular=b.titular and a.nacionalidad=c.pais");
    $regtit = pg_fetch_array($resultit);
    $vcodtit=$regtit[titular];
    $vnomtit=$regtit[nombre];
    $vnactit=$regtit[nacionalidad];
    $vnadtit=$regtit[nombrep];
    $vdomtit=$regtit[domicilio];
  }

  if ($vopc==3) {
    if ((empty($vsol) || ($vsol=="0000-000000")) && empty($vreg)) {
      mensajenew('NO SELECCIONO NINGUN EXPEDIENTE ...!!!','p_evcomat.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    if (empty($estatus_id) || ($estatus_id==0)) {
      mensajenew('No selecciono el Estatus adecuado ...!!!','p_evcomat.php','N');
      $smarty->display('pie_pag.tpl'); exit();  }
      
    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $estatus_id = $estatus_id + 2000;
    $upd_derec = true;
    //Actualizacion del estatus del expediente en la maestra
    $update_str = "estatus='$estatus_id'";
    $upd_derec = $sql->update("$tbname_6","$update_str","nro_derecho='$vder'");

    $fechahoy = hoy();
    $horactual = hora();
    $mensa_automa = "CAMBIO DE ESTATUS POR COORDINADOR / CORRECCION DE ERROR MATERIAL";

    $ins_tram = true;
    //Inserto Datos en la tabla de Tramite Stmevtrd
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,comentario,hora";
    $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$vest','$fechahoy','$usuario','$mensa_automa','$vcomenta','$horactual'";
    $ins_tram = $sql->insert("$tbname_5","$col_campos","$insert_str","");

    // Verificacion y actualizacion real de los Datos en BD 
    if ($upd_derec AND $ins_tram) {
      pg_exec("COMMIT WORK");  
      //Desconexion de la Base de Datos
      $sql->disconnect();
      
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE... !!!','p_evcomat.php','S');
      $smarty->display('pie_pag.tpl'); exit(); } 
    else {
      pg_exec("ROLLBACK WORK"); 
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$upd_derec) { $error_derec = " - Maestra de Derecho "; }
      if (!$ins_tram)  { $error_tram  = " - Tramite "; }
    
      Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_derec $error_tram ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();    
    }

  }

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro No.:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
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
$smarty->assign('vtip',$vtip);
$smarty->assign('vtipo',$vtipo);
$smarty->assign('vtra',$vtra);
$smarty->assign('vcodtit',$vcodtit);
$smarty->assign('vnomtit',$vnomtit);
$smarty->assign('vnactit',$vnactit);
$smarty->assign('vnadtit',$vnadtit);
$smarty->assign('vdomtit',$vdomtit);

$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('usuario',$usuario);

$smarty->display('p_evcomat.tpl');
$smarty->display('pie_pag.tpl');
?>
