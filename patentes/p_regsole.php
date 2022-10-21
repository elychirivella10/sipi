<script language="Javascript"> 

  function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// *************************************************************************************
// Programa: p_regsole.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado Año: 2009 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube un archivo de imagen
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado";
   exit();}

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "p_regsole.php";

$tbname_1 = "stppatee";
$tbname_2 = "stzagenr";
$tbname_3 = "stzstder";
$tbname_4 = "stzevtrd";
$tbname_5 = "stzsystem";
$tbname_6 = "stzderec";
$vdes     = "REGISTRO DE PATENTES";
$evento   = 2795;

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

$smarty->assign('titulo',$substpat); 
$smarty->assign('subtitulo','Asignaci&oacute;n de N&uacute;mero de Registro a Expediente');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

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
    Mensajenew('No introdujo ningún valor de Expediente ...!!!','p_regsole.php','N');
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

  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='P'");
  if (!$resultado) { 
    mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','p_regsole.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','p_regsole.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $vder      =$reg['nro_derecho'];  
  $vsol      =$reg['solicitud'];
  $vsol1     =substr($vsol,-11,4);
  $vsol2     =substr($vsol,-6,6);
  $fechasolic=$reg['fecha_solic'];
  $vnombre   =$reg['nombre'];
  $tipo_p    =$reg['tipo_derecho']; 
  
  $vcodage=$reg['agente'];
  $vtra=$reg['tramitante'];
  $vest1=$reg['estatus'];
  //if ($vest1!=2400) {
  if ($vest1!=2410) {
     mensajenew('ERROR: Evento NO aplica para este Estatus o no esta definido la Migracion ...!!!','p_regsole.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }

  switch ($tipo_p) {
      case "A":
         $tipo='INVENCION';
         $tnumera='ninvencion';
         $letrareg = "A";
         break;
      case "B":
         $tipo='DIBUJO INDUSTRIAL';
         $tnumera='ndiseno';
         $letrareg = "B";         
         break;
      case "C":
         $tipo='DE MEJORA';
         $tnumera='n';
         $letrareg = "C";
         break;
      case "D":
         $tipo='DE INTRODUCCION';
         $tnumera='n';
         $letrareg = "D";
         break;
      case "E":
         $tipo='MODELO INDUSTRIAL';
         $tnumera='nutilidad';
         $letrareg = "F";
         break;
      case "F":
         $tipo='MODELO DE UTILIDAD';
         $tnumera='nutilidad';
         $letrareg = "F";
         break;
      case "G":
         $tipo='DISEÑO INDUSTRIAL';
         $tnumera='ndiseno';
         $letrareg = "G";
         break;
  }

  // Nombre del Agente si es el caso      
  if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM $tbname_2 WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage['nombre'];
      $vtra=$vcodage." - ".$vnomage;
  }
  // Descripcion del estatus 
  $resulest=pg_exec("SELECT * FROM $tbname_3 WHERE estatus='$vest1'");
  $regest = pg_fetch_array($resulest);
  $vest2=$regest['descripcion'];

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

  $pago=0;
  $vest1 = 2410-2000;
}

// ************************************************************************************  
if ($vopc==2) {
  $fechasolic = $_POST['fechasolic'];
  $tipo_p     = $_POST['tipo_p'];
  //echo "fsol = $fechasolic tipo= $tipo_p ";
  
  //Verificacion de que los campos requeridos esten llenos...
  if (($vfecvi=='') || ($vsol=='') || ($vsol=='0000-000000'))
   { 
     Mensajenew("ERROR: Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); 
   }
  $numbereg = "";
  //Verificando el Numero de Expediente en Maestra de Marcas
  $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' AND solicitud!='' AND tipo_mp='P'");
  if (!$obj_query) { 
    Mensajenew('Problema al intentar consultar la tabla Maestra $tbname_6 ...!!!','p_regsole.php','N'); 
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  $numbereg = $objs->registro;
  if (!empty($numbereg)) {
    mensajenew('Expediente ya le fue asignado Numero de Registro ...!!!','p_regsole.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  if (empty($vfecvi)) { 
    mensajenew("La Fecha de Vigencia del Registro esta vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $plazofecha = 0;
  //$vfecvi = $fechasolic;
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

  $fechaexito = 1;
  //$esmayor=0;
  //$fechacorte = "05/08/1992";
  //$esmayor=compara_fechas($fechacorte,$fechasolic); //($fechasolic<'05/08/1992') 
  //if ($esmayor==1) {
  //  $opcion=1;     
  //  $plazofecha = 10;
  //  $vfecve= calculo_fechas($vfecvi,$plazofecha,"A","/");
    //if ($vfechaven <= $vfecve) { $fechaexito = 0; } 
  //}
  
  //$esmayor=0;
  //$esmayor1=0;
  //$fechacorte = "04/08/1992";
  //$fechacorte1= "01/01/1996";
  //$esmayor=compara_fechas($fechasolic,$fechacorte);  // ($fechasolic>'04/08/1992')
  //$esmayor1=compara_fechas($fechacorte1,$fechasolic);  // ($fechasolic<='31/12/1995')
  //if (($esmayor==1) AND ($esmayor1==1)) {
  ////if (($fechasolic>'04/08/1992') and ($fechasolic<'31/12/1995')) {
  //$opcion=2;
  //  switch ($tipo_p) {
  //    case "A":
  //       $plazofecha = 15;
  //       break;
  //    case "G":
  //       $plazofecha = 8;
  //       break;
  //    case "F":
  //       $plazofecha = 10;
  //       break;
  //  }
  //  $vfecve= calculo_fechas($vfecvi,$plazofecha,"A","/");
  //  if ($vfechaven <= $vfecve) { $fechaexito = 0; } 
  //}
  
  //$esmayor=0;
  //$esmayor1=0;
  //$fechacorte = "31/12/1995";
  //$fechacorte1= "01/12/2000";
  //$esmayor=compara_fechas($fechasolic,$fechacorte);  // ($fechasolic>'01/01/1996')
  //$esmayor1=compara_fechas($fechacorte1,$fechasolic);  // ($fechasolic<='30/11/2000')
  //if (($esmayor==1) and ($esmayor1==1)) {
  ////if (($fechasolic>='01/01/1996') and ($fechasolic<='30/11/2000')) {
  //$opcion=3;
  //  switch ($tipo_p) {
  //    case "A":
  //       $plazofecha = 20;
  //       break;
  //    case "G":
  //       $plazofecha = 8;
  //       break;
  //    case "F":
  //       $plazofecha = 10;
  //       break;
  //  }
  //  $vfecve= calculo_fechas($vfecvi,$plazofecha,"A","/");
  //  if ($vfechaven <= $vfecve) { $fechaexito = 0; } 
  //}
  
  $esmayor=0;
  //$fechacorte = "30/11/2000";
  //$esmayor=compara_fechas($fechasolic,$fechacorte); //($fechasolic>='01/12/2000')
  //if ($esmayor==1) {
  //if ($fechasolic>='01/12/2000') {
    $opcion=4;
    switch ($tipo_p) {
      case "A":
         $plazofecha = 20;
         break;
      case "B":
         $plazofecha = 10;
         break;
      case "E":
         $plazofecha = 10;
         break;
      case "F":
         $plazofecha = 10;
         break;
      case "G":
         $plazofecha = 10;
         break;
    }
    $vfecve= calculo_fechas($vfecvi,$plazofecha,"A","/");
  //  if ($vfechaven <= $vfecve) { $fechaexito = 0; } 
  //}

  //echo " $tipo_p - $opcion / $solfecha - $vfecvi - $vfecve - $vfechaven ";

  //if ($fechaexito==1) {
  //  mensajenew('Fecha de Vencimiento Invalida ...!!!','p_regsole.php','N');
  //  $smarty->display('pie_pag.tpl'); exit(); 
  //}
  
  //echo "opcion= $opcion plazo= $plazofecha Vig=$vfecvi Venc= $vfecve ";

  //$esmayor=0;
  //$fechaplazo="05/08/1992";
  //$fechaley = Convertir_en_fecha($fechaplazo,0);  
  //$esmayor=compara_fechas($fechaley,$vfecvi);
  //if ($esmayor==1) { $plazoley = 15; }
  //else { $plazoley = 10; } 
  //$vfecve= calculo_fechas($vfecvi,$plazoley,"A","/");

  //Se obtiene el proximo valor del registro
  $sys_actual = next_sys("$tnumera");
  if ($numereg > $sys_actual) {
    mensajenew("Numero de Registro No es Rezagado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 

  if ($letra != $letrareg) {
    mensajenew("Letra correspondiente al Certificado NO Corresponde al tipo de la Patente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 

  $vregis  = $letrareg.sprintf("%06d",$numereg);

  //Se verifica que el numero de registro no exista --Nov-2008 
  $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE trim(registro)='$vregis' AND tipo_mp='P'");
  if (!$obj_query) { 
    Mensajenew('Problema al intentar consultar la tabla Maestra $tbname_6 ...!!!','p_regsole.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $fil_found_reg=$sql->nums('',$obj_query);
  if ($fil_found_reg>0) {
    Mensajenew('ERROR: NUMERO DE REGISTRO YA EXISTE EN LA BASE DE DATOS ...!!!','p_regsole.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 

  $instram = true;
  $actprim = true; 
  pg_exec("BEGIN WORK");
    
  //Se actualiza Maestra de Patentes 
  $update_str = "estatus=2555,registro='$vregis',fecha_regis='$vfecvi',fecha_venc='$vfecve'";
  $actprim = $sql->update("$tbname_6","$update_str","solicitud='$vsol' AND tipo_mp='P' AND nro_derecho='$vder'");

  $vest1 = $vest1 + 2000;
  $horactual=hora();
  // Tabla de Eventos de Tramite
  $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora";
  $insert_str = "'$vder',$evento,'$vfecvi',nextval('stzevtrd_secuencial_seq'),'$vest1','$vfecve',$pago,'$fechahoy','$usuario','$vdes','$vregis','$horactual'";
  $instram = $sql->insert("$tbname_4","$col_campos","$insert_str","");

  if ($actprim AND $instram) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","p_regsole.php?nconexion=".$nconexion."&nveces=".$nveces,"S");
    $smarty->display('pie_pag.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    if (!$actprim) { $error_pri  = " - Maestra "; } 
    if (!$instram) { $error_tra  = " - Tr&aacute;mite "; }
    Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_pri $error_tra  ...!!!","javascript:history.back();","N");
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
$smarty->assign('campo3','Tipo de Patente:');
$smarty->assign('campo4','Titulo:');
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
//$smarty->assign('modal_id',$modal_id);
//$smarty->assign('modal',$modal);
$smarty->assign('fechasolic',$fechasolic);
$smarty->assign('vnombre',$vnombre); 
$smarty->assign('vest1',$vest1); 
$smarty->assign('vest2',$vest2); 
$smarty->assign('tipo_p',$tipo_p);
$smarty->assign('tipo',$tipo);
//$smarty->assign('vclase',$vclase);
//$smarty->assign('vindclase',$vindclase);
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

$smarty->display('p_regsole.tpl');
$smarty->display('pie_pag.tpl');

?>
