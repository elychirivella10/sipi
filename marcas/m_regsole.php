<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// *************************************************************************************
// Programa: m_regsole.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube un archivo de imagen
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado";
   exit();}

//Variables
$usuario = trim($_SESSION['usuario_login']);
$role    = $_SESSION['usuario_rol'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "m_regsole.php";

$tbname_1 = "stmmarce";
$tbname_2 = "stzagenr";
$tbname_3 = "stzstder";
$tbname_4 = "stzevtrd";
$tbname_5 = "stzsystem";
$tbname_6 = "stzderec";
$vdes     = "REGISTRO DE MARCAS";
$evento   = 1795;

$vopc     = $_GET['vopc'];

$vsol1    = $_POST['vsol1'];
$vsol2    = $_POST['vsol2'];
$vsol     = $_POST['vsol'];
$vfecvi   = $_POST['vfecvi'];
$vfecve   = $_POST['vfecve'];
$pago     = $_POST['pago'];
$vest1    = $_POST['vest1'];
$tnumera  = $_POST['tnumera'];
$letrareg = $_POST['letrareg'];
$numereg  = $_POST['numereg'];
$letra    = $_POST['letra'];
$vder     = $_POST['vder'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Asignaci&oacute;n de N&uacute;mero de Registro a Expediente');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Quitada validacion hoy 19/08/2019
//if (($usuario=='amaestri') || ($usuario=='ngonzalez') || ($usuario=='rmendoza')) { }
//else {
//  Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo, solo el Registrador(a) tiene acceso ...!!!","../index1.php","N");
//  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
//}

// ************************************************************************************  
$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces + 1; 
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'M'); } 

// ************************************************************************************  
//Verificando conexion
$sql->connection($usuario);

//Se verifica si el usuario puede o no cargar el evento seleccionado
$aplica = even_rol($role,$evento);
if ($aplica==0) {
    mensajenew('El Usuario NO tiene permiso para Asignar Registro ...!!!','../index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// ************************************************************************************  
if ($vopc==1) {
  //Validacion del Numero de Solicitud
  if (empty($vsol1) & empty($vsol2))
   {
    Mensajenew('No introdujo ningún valor de Expediente ...!!!','m_regsole.php','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  //Armado del Numero de Expediente
  $vsol  = $vsol1."-".sprintf("%06d",$vsol2);
  $dirano= $vsol1; 
  //Variable Numero del Expediente
  $numero=substr($varsol,-6,6);
  //Variable para la busqueda de la imagen
  $varsol=$dirano.substr($vsol,-6,6);
  //Nombre de la Imagen del Expediente 
  $nameimage="../imagenes/sin_imagen.jpg";

  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' and solicitud!='' AND tipo_mp='M'");
  if (!$resultado) { 
    mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_regsole.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','m_regsole.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $vder      =$reg[nro_derecho];  
  $vsol      =$reg[solicitud];
  $vsol1     =substr($vsol,-11,4);
  $vsol2     =substr($vsol,-6,6);
  $fechasolic=$reg[fecha_solic];
  $vnombre   =$reg[nombre];
  $tipo_m    =$reg[tipo_derecho]; 
  
  $vcodage=$reg[agente];
  $vtra=$reg[tramitante];
  $vest1=$reg[estatus];
  if ($vest1!=1410) {
     mensajenew('Evento NO aplica para este Estatus o no esta definido la Migracion ...!!!','m_regsole.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }

  //Obtención de datos de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $modal_id = $objs->modalidad;
  $vclase   = $objs->clase;
  $vindc    = $objs->ind_claseni;

  if ($modal_id=="D") {
    $nameimage="../imagenes/sin_imagen.jpg"; }
  else { $nameimage = ver_imagen($vsol1,$vsol2,"M"); }  

  if (!file_exists($nameimage)) {
    $nameimage="../imagenes/sin_imagen.jpg"; }

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

  if ($vsol=='1992-010152') { $tipo_m="D";} 
  if ($vsol=='1992-010144') { $tipo_m="D";} 
  if ($vsol=='1992-010146') { $tipo_m="D";} 
  if ($vsol=='1992-010147') { $tipo_m="D";} 
  if ($vsol=='1992-010148') { $tipo_m="D";} 
  if ($vsol=='1992-010149') { $tipo_m="D";} 
  if ($vsol=='1992-010150') { $tipo_m="D";} 
  if ($vsol=='1992-010151') { $tipo_m="D";} 
  if ($vsol=='1992-001093') { $tipo_m="D";} 
  if ($vsol=='1992-001042') { $tipo_m="D";} 
  if ($vsol=='1992-010493') { $tipo_m="D";} 
  if ($vsol=='1992-001946') { $tipo_m="D";} 
  if ($vsol=='1992-001937') { $tipo_m="D";} 
  if ($vsol=='1992-007692') { $tipo_m="D";} 

  switch ($tipo_m) {
      case "M":
         $tipo='MARCA DE PRODUCTO';
         $tnumera='nproducto';
         $letrareg = "P";
         break;
      case "N":
         $tipo='NOMBRE COMERCIAL';
         $tnumera='nnombres';
         $letrareg = "N";         
         break;
      case "L":
         $tipo='LEMA COMERCIAL';
         $tnumera='nlemas';
         $letrareg = "L";
         break;
      case "S":
         $tipo='MARCA DE SERVICIO';
         $tnumera='nservicios';
         $letrareg = "S";
         break;
      case "C":
         $tipo='MARCA COLECTIVA';
         $tnumera='ncolectivas';
         $letrareg = "C";
         break;
      case "D":
         $tipo='DENOMINACION COMERCIAL';
         $tnumera='ndcomercial';
         $letrareg = "D";
         break;
      case "O":
         $tipo='DENOMINACION DE ORIGEN';
         $tnumera='ndorigen';
         $letrareg = "O";
         break;
    }

  switch ($vindc) {
      case "I":
         $vindclase='INTERNACIONAL';
         break;
      case "N":
         $vindclase='NACIONAL';
         break;
    }

  // Nombre del Agente si es el caso      
  if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM $tbname_2 WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      $vtra=$vcodage." - ".$vnomage;
  }
  // Descripcion del estatus 
  $resulest=pg_exec("SELECT * FROM $tbname_3 WHERE estatus='$vest1'");
  $regest = pg_fetch_array($resulest);
  $vest2=$regest[descripcion];

  // Titular Actual
  $obj_query = $sql->query("SELECT a.titular,b.nombre,a.domicilio,a.nacionalidad,c.nombre as nombrep  
                            FROM   stzottid a,stzsolic b, stzpaisr c WHERE a.nro_derecho ='$vder' AND  
                                   a.titular=b.titular AND a.nacionalidad=c.pais");
                                 
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas>0) {
    $objs = $sql->objects('',$obj_query);
    $vcodtit = $objs->titular;
    $vnomtit = $objs->nombre;
    $vdomtit = $objs->domicilio;
    $vnactit = $objs->nacionalidad;
    $vnadtit = $objs->nombrep;
  }

  //Verificacion de que si existe la imagen en disco
  //if (($modal_id=="G") || ($modal_id=="M")) {
  //  if (!file_exists($nameimage)) {
  //    Mensage_Error("ERROR: No se encuentra la Imagen Digitalizada asociada al expediente...!!!");
  //    $smarty->display('pie_pag.tpl');
  //    exit(); 
  //  }  
  //}
  $pago=0;
  $vest1 = 1410-1000;  
}

// ************************************************************************************  
if ($vopc==2) {
  //Verificacion de que los campos requeridos esten llenos...
  if (($vfecvi=='') || ($vsol=='') || ($vsol=='0000-000000'))
   { 
     Mensajenew("Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); 
   }
  $numbereg = "";
  //Verificando el Numero de Expediente en Maestra de Marcas
  $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' and solicitud!='' AND tipo_mp='M'");
  if (!$obj_query) { 
    Mensajenew('Problema al intentar consultar la tabla Maestra $tbname_6 ...!!!','m_regsole.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  $numbereg = $objs->registro;
  if (!empty($numbereg)) {
    mensajenew('Expediente ya le fue asignado Numero de Registro ...!!!','m_regsole.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  if (empty($vfecvi)) { 
    mensajenew("La Fecha de Vigencia del Registro esta vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  //$fechaeve = Convertir_en_fecha($vfecvi,0);
  //$solfecha = Convertir_en_fecha($fechasolic,0);
  $esmayor=0;
  $esmayor=compara_fechas($vfecvi,$fechahoy);
  if ($esmayor==1) {
    //$smarty->display('encabezado.tpl');
    mensajenew("Fecha de Registro NO puede ser mayor a la fecha actual ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 
  $esmayor=0;
  $esmayor=compara_fechas($solfecha,$vfecvi);
  if ($esmayor==1) {
    //$smarty->display('encabezado.tpl');
    mensajenew("Fecha de Registro NO puede ser menor a la Fecha de la Solicitud ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 
  $esmayor=0;
  $fechaplazo="05/08/1992";
  $fechaley = Convertir_en_fecha($fechaplazo,0);  
  $esmayor=compara_fechas($fechaley,$vfecvi);
  if ($esmayor==1) { $plazoley = 15; }
  else { $plazoley = 10; } 

  //Verificando el Numero de Boletin en que salio concedida
  $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho='$vder' AND evento IN (1122,1097)");
  if (!$obj_query) { 
    Mensajenew('Problema al intentar consultar la tabla $tbname_4 ...!!!','m_regsole.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    //Mensajenew('EXPEDIENTE NO TIENE CARGADO EVENTO DE PUBLICACION DE CONCESION ...!!!','m_regsole.php','N');
    //$smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    $esmayor=0;
    $fechahoy = "12/09/2008";
    $fechacambio = Convertir_en_fecha($fechahoy,0);  
    $esmayor=compara_fechas($fechacambio,$vfecvi);
    if ($esmayor==1) { $numbol = 0; $plazoley = 10; } 
  }
  else {
    $objs = $sql->objects('',$obj_query);
    $numbol = $objs->documento; 
  }
  
  if ($numbol>=496) { $plazoley = 15; }
  $vfecve= calculo_fechas($vfecvi,$plazoley,"A","/");


  if (($letra=='F') || ($letra=='D')) {  }
  else {
  //Se obtiene el proximo valor del registro
  $sys_actual = next_sys("$tnumera");
  if ($numereg > $sys_actual) {
  //if ($numereg < $sys_actual) {
    mensajenew("ERROR: Numero de Registro No es Rezagado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 
  }
  
  if ($letra=='F') { $letrareg='F'; }
  else {
  if ($letrareg=='P') {
     if ($letra != $letrareg and $letra !='F') {
       mensajenew("Letra del Registro NO Corresponde al tipo de la Marca ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit(); } 
  } else {
     if ($letra != $letrareg) {
       mensajenew("Letra del Registro NO Corresponde al tipo de la Marca ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit(); } 
  }
  }

  $vregis  = $letra.sprintf("%06d",$numereg);

  //Se verifica que el numero de registro no exista --Nov-2008 
  $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE trim(registro)='$vregis' AND tipo_mp='M'");
  if (!$obj_query) { 
    Mensajenew('Problema al intentar consultar la tabla Maestra $tbname_6 ...!!!','m_regsole.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $fil_found_reg=$sql->nums('',$obj_query);
  if ($fil_found_reg>0) {
    Mensajenew('ERROR: NUMERO DE REGISTRO YA EXISTE EN LA BASE DE DATOS ...!!!','m_regsole.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 

  $instram = true;
  $actprim = true; 
  pg_exec("BEGIN WORK");
    
  //Se actualiza Maestra de Marcas
  $update_str = "estatus=1555,registro='$vregis',fecha_regis='$vfecvi',fecha_venc='$vfecve'";
  $actprim = $sql->update("$tbname_6","$update_str","solicitud='$vsol' AND tipo_mp='M'");

  $vest1 = $vest1 + 1000;
  $horactual=hora();
  $fechahoy = hoy();
  // Tabla de Eventos de Tramite
  $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora";
  $insert_str = "'$vder',$evento,'$vfecvi',nextval('stzevtrd_secuencial_seq'),'$vest1','$vfecve','$pago','$fechahoy','$usuario','$vdes','$vregis','$horactual'";
  $instram = $sql->insert("$tbname_4","$col_campos","$insert_str","");

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

    if (!$actprim) { $error_pri  = " - Maestra "; } 
    if (!$instram) { $error_tra  = " - Tr&aacute;mite "; }
    Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_pri $error_tra  ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

}

// ************************************************************************************  
if ($vopc==1) 
 { $smarty->assign('varfocus','formarcas2.vfecvi'); 
   $smarty->assign('vmodo',''); 
   $smarty->assign('modo',''); }
else 
 { $smarty->assign('varfocus','formarcas1.vsol1'); 
   $smarty->assign('vmodo','readonly');
   $smarty->assign('modo','disabled'); 
 }


// ************************************************************************************  
//Pase de variables y Etiquetas al template
$smarty->assign('submitbutton','submit'); 
$smarty->assign('submitbutton1','button'); 

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Marca:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Clase:');
$smarty->assign('campo6','Estatus:');
$smarty->assign('campo7','Titular:');
$smarty->assign('campo8','Pais de Residencia:');
$smarty->assign('campo9','Tramitante:');
$smarty->assign('campo11','Fecha de Vigencia:');
$smarty->assign('campo12','Pago de Derecho Bs.:');
$smarty->assign('campo13','Registro No.:');

$smarty->assign('vder',$vder);
$smarty->assign('usuario',$vuser);
$smarty->assign('role',$role);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('vsol2',$vsol2);
$smarty->assign('vsol',$vsol);
$smarty->assign('dirano',$dirano);
$smarty->assign('modal_id',$modal_id);
$smarty->assign('modal',$modal);
$smarty->assign('fechasolic',$fechasolic);
$smarty->assign('vnombre',$vnombre); 
$smarty->assign('vest1',$vest1); 
$smarty->assign('vest2',$vest2); 
$smarty->assign('tipo_m',$tipo_m);
$smarty->assign('tipo',$tipo);
$smarty->assign('vclase',$vclase);
$smarty->assign('vindclase',$vindclase);
$smarty->assign('vtra',$vtra);
$smarty->assign('vnomtit',$vnomtit);
$smarty->assign('vnactit',$vnactit);
$smarty->assign('vnadtit',$vnadtit);
$smarty->assign('tnumera',$tnumera);
$smarty->assign('letrareg',$letrareg);
$smarty->assign('pago',$pago);
$smarty->assign('fechasolic',$fechasolic);
$smarty->assign('nconexion',$nconexion); 
$smarty->assign('nveces',$nveces);  

$smarty->display('m_regsole.tpl');
$smarty->display('pie_pag.tpl');

?>
