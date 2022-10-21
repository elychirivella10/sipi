<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// ************************************************************************************* 
// Programa: p_boldev.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año 2012
// Modificado Año: BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado";
   exit();}

//Variables
$usuario = $_SESSION['usuario_login'];
$sql  = new mod_db();
$fecha   = fechahoy();

$tbname_1 = "stppatee";
$tbname_2 = "stzagenr";
$tbname_3 = "stzstder";
$tbname_4 = "stzevtrd";
$tbname_5 = "stzsystem";
$tbname_6 = "stzderec";

$vopc=$_GET['vopc'];
$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$vsol=$_POST['vsol'];
$vder=$_POST['vder'];
$fechasolic=$_POST['fechasolic'];
$tipo_p=$_POST['tipo_p']; 
$pago=$_POST['pago'];
$vest1=$_POST['vest1'];

$vdoc = $_POST['vdocumento'];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Modificaci&oacute;n del Bolet&iacute;n a Notificar Devoluci&oacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==1) {
  //Validacion del Numero de Solicitud
  if (empty($vsol1) & empty($vsol2))
   {
    mensajenew('No introdujo ningún valor de Expediente ...!!!','p_boldev.php','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  //Armado del Numero de Expediente
  $vsol=$vsol1."-".sprintf("%06d",$vsol2);
  $dirano=$vsol1;
  $numero=sprintf("%06d",$vsol2);
  //Variable para la busqueda de la imagen
  $varsol=$dirano.substr($vsol,-6,6);
  //Nombre de la Imagen del Expediente 
  $nameimage="../imagenes/SAPI_Logo.jpg";
  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='P'");
  if (!$resultado) { 
    mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','p_boldev.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','p_boldev.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $vder=$reg[nro_derecho];
  $vsol=$reg[solicitud];
  $vsol1=substr($vsol,-11,4);
  $vsol2=substr($vsol,-6,6);
  $fechasolic=$reg[fecha_solic];
  $vnombre=$reg[nombre];
  $tipo_p=$reg[tipo_derecho];
  $vcodage=$reg[agente];
  $vtra=$reg[tramitante];
  $vest1=$reg[estatus];
  //$nameimage="../imagenes/patentes/di".$dirano."/".$varsol.".jpg";

  switch ($tipo_p) {
      case "A":
         $tipo='INVENCION';
         $tnumera='ninvencion';
         $letrareg = "A";
         break;
      case "B":
         $tipo='DIBUJO INDUSTRIAL';
         $tnumera='ndiseno';
         $letrareg = "G";
         break;
      case "G":
         $tipo='DISEÑO INDUSTRIAL';
         $tnumera='ndiseno';
         $letrareg = "G";
         break;
      case "F":
         $tipo='MODELO DE UTILIDAD';
         $tnumera='nutilidad';
         $letrareg = "F";
         break;
      case "E":
         $tipo='MODELO INDUSTRIAL';
         $tnumera='nutilidad';
         $letrareg = "F";
         break;
  }

  // Nombre del Agente si es el caso      
  if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM $tbname_2 WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      $vtra=$vcodage." - ".$vnomage;
  }
  // Descripcon del estatus 
  $vest2 = estatus($vest1);

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

  $pago=0;
}

if ($vopc==2) {
  //Verificacion de que los campos requeridos esten llenos...
  if (($vdoc=='') || ($vsol=='') || ($vsol=='0000-000000'))
   { 
     mensajenew('Hay Informacion en el formulario que esta Vacia ...!!!','p_boldev.php','N');
     $smarty->display('pie_pag.tpl'); exit(); 
   }
  $numbereg = "";
  //Verificando el Numero de Expediente en Maestra de Patentes
  $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='P'");
  if (!$obj_query) { 
    mensajenew('Problema al intentar consultar la tabla Maestra Stzderec ...!!!','p_boldev.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);

  // Comienzo de Transaccion 
  pg_exec("BEGIN WORK");
  
  $upd_trami = true;
  //Se actualiza Maestra de Tramites 
  $update_str = "documento='$vdoc'";
  $upd_trami  =  $sql->update("$tbname_4","$update_str","nro_derecho='$vder' AND evento=2500");

  // Verificacion y actualizacion real de los Datos en BD 
  if ($upd_trami) {
    pg_exec("COMMIT WORK");  
    //Desconexion de la Base de Datos
    $sql->disconnect();
      
    Mensajenew('DATOS GUARDADOS CORRECTAMENTE...!!!','p_boldev.php','S');
    $smarty->display('pie_pag.tpl'); exit(); } 
  else {
    pg_exec("ROLLBACK WORK"); 
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("Falla de Ingreso de Datos en la BD, Transaccion Abortada ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();    
  }
   
}

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Patente:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo6','Estatus:');
$smarty->assign('campo7','Titular:');
$smarty->assign('campo8','Pais de Residencia:');
$smarty->assign('campo9','Tramitante:');
$smarty->assign('campo11','Bolet&iacute;n:');

if ($vopc==1) 
 { $smarty->assign('varfocus','formarcas2.vfechaven'); 
   $smarty->assign('vmodo',''); }
else 
 { $smarty->assign('varfocus','formarcas1.vsol1'); 
   $smarty->assign('vmodo','readonly'); 
 }

$smarty->assign('usuario',$vuser);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('vsol2',$vsol2);
$smarty->assign('vsol',$vsol);
$smarty->assign('vder',$vder);
$smarty->assign('dirano',$dirano);
$smarty->assign('fechasolic',$fechasolic);
$smarty->assign('vfecvi',$fechasolic);
$smarty->assign('vnombre',$vnombre); 
$smarty->assign('vest1',$vest1); 
$smarty->assign('vest2',$vest2); 
$smarty->assign('tipo_p',$tipo_p);
$smarty->assign('tipo',$tipo);
$smarty->assign('vtra',$vtra);
$smarty->assign('vnomtit',$vnomtit);
$smarty->assign('vnactit',$vnactit);
$smarty->assign('vnadtit',$vnadtit);

$smarty->display('p_boldev.tpl');
$smarty->display('pie_pag.tpl');
?>
