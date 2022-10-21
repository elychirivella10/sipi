<?php
// *************************************************************************************
// Programa: m_pbinfig1.php 
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
$tbname_7 = "stmaudef";
$tbname_8 = "stzderec";
$tbname_9 = "stmclbus";
$tbname_10 = "stmtmpccv";

$fecha    = fechahoy();

$vopc  = $_GET['vopc'];
$vsol = $_GET['vsol'];
$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vest  = $_POST['vest'];
$modal_id = $_POST['modal_id'];
$vcomenta = $_POST['vcomenta'];
$estatus_id=$_POST['estatus_id'];
$nameimage=$_POST['nameimage'];
$accion=$_POST['accion'];

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

$resultado=true;
if ($vopc!=1 || $vopc!=5) {
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('modo1',''); 
}

if ($vopc==1) {
    $smarty->assign('submitbutton','button'); 
    $smarty->assign('varfocus','formarcas3.vdoc'); 
    $smarty->assign('vmodo','readonly=readonly'); 
    $smarty->assign('modo1','disabled'); 

    //Validacion del Numero de Solicitud
    if (empty($vsol)) {
      mensajenew('No introdujo ningún valor de Expediente ...!!!','m_pbinfigu.php','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    $resultado=pg_exec("SELECT * FROM $tbname_8 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='M'");
    if (!$resultado) { 
      mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_pbinfigu.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','m_pbinfigu.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $reg   = pg_fetch_array($resultado);
    $vder  = $reg[nro_derecho];
    $vsol  = $reg[solicitud];
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
    $vest    = $reg[estatus];
    
    //$distingue='';
    //Obtención de datos de la Marca 
    $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
    $objs      = $sql->objects('',$obj_query);
    $modal_id  = $objs->modalidad;
    $vclase    = $objs->clase;
    $vindc     = $objs->ind_claseni;
    //$distingue = trim($objs->distingue);
    
    $nameimage = ver_imagen($vsol1,$vsol2,'M');

    if (($modal_id!='G') && ($modal_id!='M')) {
      mensajenew('SOLICITUD DEBE SER GRAFICA O MIXTA PARA REALIZARLE BUSQUEDA ...!!!','m_pbinfigu.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

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

    $fechahoy=Hoy();
    $horahoy= Hora(); 

    //Creando tabla temporal
    $ntabla1="figurativa";
    pg_exec("CREATE TEMPORARY TABLE figurativa (solicitud char(11))");

    $numero2=rand(1,9999);
    $ntabla2="tmpri2".$numero2;
    pg_exec("CREATE TABLE $ntabla2 (solicitud char(11), clase int2, ind_claseni char(1) )");

    $insert_tmp = "'$fechahoy','$horahoy','$usuario','$ntabla2','I'";
    $sql->insert("stmtmpef","","$insert_tmp","");

    $universo = 0;
    //Cantidad de Marcas en la Clase Nacional asociada   
    $obj_query = $sql->query("SELECT * FROM $tbname_9 WHERE clase_inter='$vclase'");
    $obj_filas = $sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    if ($obj_filas==0) {
      Mensajenew('No existen Solicitudes que cumplan con los parametros ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    for($i=0;$i<$obj_filas;$i++) {
      $indcl = "I"; 
      $vcl = $objs->clase_asoc;
      if ($vcl>50) { $indcl = "N"; $vcl = $vcl-50; } 
      $obj_clase = $sql->query("SELECT count(*) FROM $tbname_1 WHERE clase='$vcl' AND ind_claseni='$indcl' AND modalidad IN ('M','G')");
      $obj_filcl = $sql->nums('',$obj_clase);
      $objcl = $sql->objects('',$obj_clase);
      $universo = $universo + $objcl->count;  
      $objs = $sql->objects('',$obj_query);
    }

    // Tabla temporal de Clasificaciones de Viena asignados 
    $obj_query = $sql->query("SELECT * FROM $tbname_10 WHERE solicitud='$vsol'");
    $obj_filas = $sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    if ($obj_filas==0) {
     Mensajenew('Clasificacion Internacional de Viena Vacia(s) ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    for($i=0;$i<$obj_filas;$i++) { 
      $varsolc = $objs->ccv;
      $resultado=pg_exec("INSERT INTO $ntabla1 SELECT stzderec.solicitud FROM stmccvma,stzderec 
                          WHERE stzderec.nro_derecho = stmccvma.nro_derecho 
                          AND stzderec.tipo_mp = 'M' AND stmccvma.ccv='$varsolc'");
      $objs = $sql->objects('',$obj_query); 
    }

    $respuesta=pg_exec("SELECT DISTINCT $ntabla1.solicitud FROM $ntabla1 order by $ntabla1.solicitud");   
    $filas_found=pg_numrows($respuesta);
    $fila=1;
    while ( $fila <= $filas_found )
    {
      $regis = pg_fetch_array($respuesta);
      $vs1=trim($regis['solicitud']);
      if ($vs1 <= $vsol) {
        $resinsert=pg_exec("INSERT INTO $ntabla2 SELECT solicitud,clase,ind_claseni
                                                 FROM stmmarce,stzderec 
                                                 WHERE stzderec.solicitud='$vs1'
                                                 AND stmmarce.nro_derecho=stzderec.nro_derecho 
                                                 AND stzderec.tipo_mp='M'");   
      }
      $fila++;
    }
    //Filtro por Clasificación Internacional de Niza
    $filtro2=pg_exec("SELECT solicitud,clase,ind_claseni FROM $ntabla2 ORDER BY $ntabla2.solicitud");   
    $filas_found=pg_numrows($filtro2);
    $fila=1;
    while ( $fila <= $filas_found )
    {
      $regis = pg_fetch_array($filtro2);
      $vsoli = trim($regis['solicitud']);
      $cla=$regis['clase'];
      $ind=$regis['ind_claseni'];
      if ($ind=='N') {
        $vclabus = $cla+50;
      } else {
        $vclabus = $cla;
      }
      $match=pg_exec("SELECT clase_asoc FROM stmclbus WHERE clase_inter='$vclase' and clase_asoc='$vclabus'");
      $nfilas=pg_numrows($match);
      if ($nfilas==0) {
        pg_exec("DELETE FROM $ntabla2 WHERE solicitud = '$vsoli'");
      }
      $fila++;
    }
    //$droptable=pg_exec("drop table $ntabla1");

    $obj_query = $sql->query("SELECT * FROM $ntabla2");
    if (!$obj_query) { 
      mensajenew('Problema al intentar realizar la consulta en la tabla $ntabla2 ...!!!','m_pbinfigu.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=$sql->nums('',$obj_query);

}

//Asignación de variables para pasarlas a Smarty
$camposquery = "solicitud,clase,ind_claseni";
$camposname= "solicitud,clase,ind_claseni,imagen";
$tablas    = $ntabla2;
$condicion = "";
$orden     = "1";
$modo      = "Imprimir";
$modoabr   = "Sel.";
$vurl      = "m_pbinfigu.php";
$new_windows="N";
   
$smarty ->assign('camposquery',$camposquery);
$smarty ->assign('camposname',$camposname);
$smarty ->assign('tablas',$tablas);
$smarty ->assign('condicion',$condicion);
$smarty ->assign('orden',$orden); 
$smarty ->assign('modo',$modo); 
$smarty ->assign('modoabr',$modoabr); 
$smarty ->assign('vurl',$vurl);
$smarty ->assign('new_windows',$new_windows);

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
$smarty->assign('lcpoder','Codigo:'); 
$smarty->assign('lnpoder','Descripcion:'); 
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
$smarty->assign('subtotal',$filas_found);
$smarty->assign('universo',$universo);

$smarty->display('m_pbinfig1.tpl');
$smarty->display('pie_pag.tpl');
?>
