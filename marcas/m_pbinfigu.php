<script language="Javascript"> 

function gestionvienap(var1,var3,var4) {
  open("adm_bviena.php?vsol="+var1.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script>

<?php
// *************************************************************************************
// Programa: m_pbinfigu.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado II Semestre 2009 - BD.Relacional  
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos y Smarty 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

$sql  = new mod_db();
$tbname_1 = "stmmarce";
$tbname_2 = "stzstder";
$tbname_3 = "stmviena";
$tbname_4 = "stzagenr";
$tbname_5 = "stmccvma";
$tbname_6 = "stmlogos";
$tbname_7 = "stzderec";
$tbname_8 = "stmtmpccv";

$fecha    = fechahoy();

$vopc  = $_GET['vopc'];
$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vsol = $_POST['vsol'];
$vest  = $_POST['vest'];
$modal_id = $_POST['modal_id'];
$vcomenta = $_POST['vcomenta'];
$estatus_id=$_POST['estatus_id'];
$nameimage=$_POST['nameimage'];
$accion=$_POST['accion'];
$vstring2=$_POST['vstring2'];
$etiqueta=$_POST['etiqueta'];
$vexist=$_POST['vexist'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','B&uacute;squeda Interna de Elemento Figurativo');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty->assign('submitbutton','submit'); 
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('vmodo',''); 

//Verificando conexion
$sql->connection($usuario);

//Borra tablas temporales anteriores a la fecha de hoy 
delri_tmpef();
//del_tmpef();

if (!empty($vsol1) && !empty($vsol2))
{
  //Armado del Numero de Expediente
  $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
}  

$resultado=true;
if ($vopc!=1 || $vopc!=5) {
  $smarty ->assign('modo','readonly=readonly'); 
  $smarty ->assign('modo1',''); 
}

if ($vopc==1) {
  $smarty ->assign('submitbutton','button'); 
  $smarty ->assign('varfocus','formarcas3.vdoc'); 
  $smarty ->assign('vmodo','readonly=readonly'); 
  $smarty ->assign('modo1','disabled'); 

  //Validacion del Numero de Solicitud
  if (empty($vsol1) && empty($vsol2)) {
    mensajenew('AVISO: No introdujo ningún valor de Expediente ...!!!','m_pbinfigu.php','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  $resultado=pg_exec("SELECT * FROM $tbname_7 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='M'");
  if (!$resultado) { 
    mensajenew('ERROR: Problema con la Tabla en la Base de Datos ...!!!','m_pbinfigu.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
      mensajenew('AVISO: NO Existe el Expediente en la Base de Datos ...!!!','m_pbinfigu.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $reg    = pg_fetch_array($resultado);
  $vder   = $reg[nro_derecho];
  $vsol   = $reg[solicitud];
  $vest   = $reg[estatus];
  $vsol1  = substr($vsol,-11,4);
  $vsol2  = substr($vsol,-6,6);
  $vreg   = $reg[registro];
  $vreg1  = substr($vreg,-7,1);
  $vreg2  = substr($vreg,1);
  $vnom   = $reg[nombre];
  $vtipo  = $reg[tipo_derecho];
  $vfecsol= $reg[fecha_solic];
  $vfecreg= $reg[fecha_regis];
  $vfecven= $reg[fecha_venc];
  $vcodage= $reg[agente];
  $vtra   = $reg[tramitante];

  //$distingue='';
  //Obtención de datos de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
  $objs      = $sql->objects('',$obj_query);
  $modal_id  = $objs->modalidad;
  $vclase    = $objs->clase;
  $vindc     = $objs->ind_claseni;
  //$distingue = trim($objs->distingue);

  if (($modal_id!='G') && ($modal_id!='M')) {
    mensajenew('AVISO: SOLICITUD DEBE SER GRAFICA O MIXTA PARA REALIZARLE BUSQUEDA ...!!!','m_pbinfigu.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //$nameimage = ver_imagen($vsol1,$vsol2,'M');
  $nameimage = "../graficos/marcas/ef".$vsol1."/".$vsol1.$vsol2.".jpg";
  //echo "ruta= $nameimage ";
  switch ($modal_id) {
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

  //Verificacion de que si existe la imagen en disco
  if (!file_exists($nameimage)) {
    Mensajenew("ERROR: La Imagen $nameimage NO ha sido Encontrada, debe ser Scaneada para proseguir ...!!!","m_pbinfigu.php","N");
    $smarty->display('pie_pag.tpl'); exit(); }     

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
  $obj_query = $sql->query("SELECT stzottid.titular,stzsolic.nombre,stzottid.nacionalidad,stzottid.domicilio,stzpaisr.nombre as nombrep 
                            FROM stzottid,stzsolic,stzpaisr WHERE stzottid.nro_derecho ='$vder' AND  
                                 stzottid.titular=stzsolic.titular AND
                                 stzottid.nacionalidad=stzpaisr.pais");
  $obj_filas = $sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  $vcodtit=$objs->titular;
  $vnomtit=$objs->nombre;
  $vnactit=$objs->nacionalidad;
  $vnadtit=$objs->nombrep;
  $vdomtit=$objs->domicilio;

  // Tabla temporal de Clasificaciones de Viena asignados 
  $sql->del("$tbname_8","solicitud='$vsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_5,$tbname_3 WHERE $tbname_5.nro_derecho='$vder' AND 
                            $tbname_5.ccv = $tbname_3.ccv ORDER BY $tbname_5.ccv"); 
  $obj_filas = $sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  if ($obj_filas==0) {
    Mensajenew("ERROR: Expediente '$vsol' NO presenta Clasificacion Internacional de Viena(s) ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  for($i=0;$i<$obj_filas;$i++) { 
    $vcod = $objs->ccv;
    $desc = $objs->descripcion;
    $insert_str = "'$vsol','$vcod','$desc'";
    $insccv = $sql->insert("$tbname_8","","$insert_str","");
    $objs = $sql->objects('',$obj_query); 
  }

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
$smarty->assign('campo15','Domicilio:'); 
$smarty ->assign('lcpoder','Codigo:'); 
$smarty ->assign('lnpoder','Descripcion:'); 
$smarty->assign('lcviena','C&oacute;digos de Viena '); 

$smarty->assign('vopc',$vopc); 
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
$smarty->assign('vmodo','readonly=readonly'); 
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('usuario',$usuario);

$smarty->display('m_pbinfigu.tpl');
$smarty->display('pie_pag.tpl');
?>
