<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// ************************************************************************************* 
// Programa: p_resumen.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
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

$tbname_1 = "stzderec";
$tbname_4 = "stppatee";
$tbname_5 = "stzstder";
$tbname_6 = "stzagenr";

$vopc  = $_GET['vopc'];
$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vreg1 = $_POST['vreg1'];
$vreg2 = $_POST['vreg2'];
$vtipo = $_POST['vtipo'];
$vest  = $_POST['vest'];
$vder  = $_POST['vder'];
$vresumen = $_POST['vresumen'];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Actualizaci&oacute;n de Resumen');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol1'); 
$smarty ->assign('vmodo','disabled'); 

if (empty($vopc)) {
  $smarty ->assign('modo2','disabled'); 
  $smarty ->assign('modo3','disabled');
  $smarty ->assign('modo4','disabled'); } 

//Verificando conexion
$sql->connection($usuario);

if (!empty($vsol1) && !empty($vsol2)) {
  //Armado del Numero de Expediente
  $vsol=$vsol1."-".$vsol2;
  $varsol=$vsol1."-".$vsol2;
}  
if (!empty($vreg1) && !empty($vreg2))
  { $vreg = $vreg1.$vreg2; }
  
$resultado=true;

  if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol1) && empty($vsol2)) {
     mensajenew('No introdujo ningún valor de Expediente ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); }
   $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='P'");
  }

  if ($vopc==2) {
   //Validacion del Numero de Registro - Mostrar Informacion 
   if (empty($vreg1) && empty($vreg2))
    {
      mensajenew('No introdujo ningún valor de Expediente ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
   $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE registro='$vreg' and registro!='' AND tipo_mp='P'");
  }
  
  if ($vopc==1 || $vopc==2) {
    $smarty ->assign('submitbutton','button'); 
    $smarty ->assign('varfocus','formarcas3.vdoc'); 
    $smarty ->assign('vmodo','readonly'); 
    $smarty ->assign('modo2',''); 
    $smarty ->assign('modo','disabled');
 
    if (!$resultado) { 
      mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','p_resumen.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','p_resumen.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $reg = pg_fetch_array($resultado);
    $vder=$reg[nro_derecho];
    $vsol=$reg[solicitud];
    $vest=$reg[estatus];
    $vsol1=substr($vsol,-11,4);
    $vsol2=substr($vsol,-6,6);
    $vreg=$reg[registro];
    $vreg1=substr($vreg,-7,1);
    $vreg2=substr($vreg,1);
    $vnom=trim($reg[nombre]);
    $vtipo=$reg[tipo_derecho];
    $vfecsol=$reg[fecha_solic];
    $vfecreg=$reg[fecha_regis];
    $vfecven=$reg[fecha_venc];
    $vcodage=$reg[agente];
    $vtra=trim($reg[tramitante]);

    switch ($vtipo) {
      case "A":
         $vtip='INVENCION';
         break;
      case "B":
         $vtip='DIBUJO INDUSTRIAL';
         break;
      case "G":
         $vtip='DISE&Ntilde;O INDUSTRIAL';
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
      $resulage=pg_exec("SELECT nombre FROM $tbname_6 WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      $vtra=$vcodage." - ".$vnomage;
    }
    // Descripcon del estatus 
    $vdesest = estatus($vest);
    
    // Descripcion del Resumen  
    $resulres=pg_exec("SELECT * FROM $tbname_4 WHERE nro_derecho='$vder'");
    $regres = pg_fetch_array($resulres);
    $vresumen=$regres[resumen]; 

    // Titular Actual
    $resultit=pg_exec("SELECT a.titular,b.nombre,a.nacionalidad,a.domicilio,c.nombre as nombrep FROM stzottid a, stzsolic b, stzpaisr c WHERE a.nro_derecho='$vder' and a.titular=b.titular and a.nacionalidad=c.pais");
    $regtit = pg_fetch_array($resultit);
    $vcodtit=$regtit[titular];
    $vnomtit=$regtit[nombre];
    $vnactit=$regtit[nacionalidad];
    $vnadtit=$regtit[nombrep];
    $vdomtit=$regtit[domicilio];
    
    if ($vtipo=="G") { $smarty ->assign('modo4','disabled'); }
    if ($vtipo=="A") { $smarty ->assign('modo3','disabled'); }
    if ($vtipo=="F") { $smarty ->assign('modo3','disabled'); }
    
    $fechahoy = hoy();

  }

  // Opcion de Grabar Informacion  
  if ($vopc==3) {
    if ((empty($vsol) || ($vsol=="0000-000000")) && empty($vreg)) {
      mensajenew('NO SELECCIONO NINGUN EXPEDIENTE ...!!!','p_resumen.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $upd_resum = true;
    // Tabla de Resumen 
    $vres = trim($vresumen);
    //$vres = str_replace("'","´",$resumen);
    if (!empty($vres)) {
      pg_exec("LOCK TABLE stppatee IN SHARE ROW EXCLUSIVE MODE");
      $update_str = "resumen='$vres'";
      $upd_resum = $sql->update("$tbname_4","$update_str","nro_derecho='$vder'"); }

    // Verificacion y actualizacion real de los Datos en BD 

    if ($upd_resum) {
      pg_exec("COMMIT WORK");  
      //Desconexion de la Base de Datos
      $sql->disconnect();
      
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','p_resumen.php','S');
      $smarty->display('pie_pag.tpl'); exit(); } 
    else {
      pg_exec("ROLLBACK WORK"); 
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$upd_resum) { $error_resum = " - Resumen "; }
      Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_resum ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();    
    }
  }

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro No.:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo6','T&iacute;tulo:');
$smarty->assign('campo7','Estatus:');
$smarty->assign('campo8','Fecha Registro:');
$smarty->assign('campo9','Fecha Vencimiento:');
$smarty->assign('campo10','Agente/Tramitante:');
$smarty->assign('campo11','Titular:');
$smarty->assign('campo12','Pais:');
$smarty->assign('campo13','Fecha del Evento:');
$smarty->assign('campo14','Clasificaci&oacute;n Locarno:');
$smarty->assign('campo15','Edici&oacute;n:');
$smarty->assign('campo16','Resumen:');
$smarty->assign('campo17','Domicilio:');
$smarty->assign('campo18','Clasificaci&oacute;n Inter.:');
$smarty->assign('campo19','Inventor(es):');
$smarty->assign('campo20','Nombre Inventor:');
$smarty->assign('campo21','Nro:');
$smarty->assign('campo22','Prioridad:');
$smarty->assign('campo23','Prioridad(es):');
$smarty->assign('campo24','Equivalente:');
$smarty->assign('campo25','Equivalente(es):');

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
$smarty->assign('vtit',$vtit); 
$smarty->assign('vest',$vest-2000); 
$smarty->assign('vdesest',$vdesest); 
$smarty->assign('vfecsol',$vfecsol); 
$smarty->assign('vfecreg',$vfecreg); 
$smarty->assign('vfecven',$vfecven);
$smarty->assign('vresumen',$vresumen); 
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

$smarty->display('p_resumen.tpl');
$smarty->display('pie_pag.tpl');
?>
