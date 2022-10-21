<?php
// *************************************************************************************
// Programa: p_pbindis1.php 
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
$tbname_1 = "stppatee";
$tbname_2 = "stzstder";
$tbname_3 = "stplocar";
$tbname_4 = "stzagenr";
$tbname_5 = "stplocad";
$tbname_6 = "stmlogos";
$tbname_7 = "stpaudef";
$tbname_8 = "stzderec";
//$tbname_9 = "stmclbus";
//$tbname_10 = "stmtmpccv";
$ntabla1  = "diseno";
$ntabla2  = "stptmploc";

$fecha    = fechahoy();

$vopc  = $_GET['vopc'];
$vsol  = $_GET['vsol'];
$v1    = $_GET['vsol'];
$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vest  = $_POST['vest'];
$modal_id = $_POST['modal_id'];
$vcomenta = $_POST['vcomenta'];
$estatus_id=$_POST['estatus_id'];
$nameimage =$_POST['nameimage'];
$accion    =$_POST['accion'];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','B&uacute;squeda Interna de Diseño Industrial');
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
      mensajenew('AVISO: No introdujo ningún valor de Expediente ...!!!','p_pbindise.php','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    $resultado=pg_exec("SELECT * FROM $tbname_8 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='P'");
    if (!$resultado) { 
      mensajenew('ERROR: Problema con la tabla en la Base de Datos ...!!!','p_pbindise.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew('AVISO: NO existe el Expediente en la Base de Datos ...!!!','p_pbindise.php','N');
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

    if ($vtipo!="G") {
      mensajenew('AVISO: La patente debe ser Diseño Industrial para realizar la b&uacute;squeda ...!!!','p_pbindise.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 

    $vtip="DISENO INDUSTRIAL";

    $obj_query = $sql->query("SELECT * FROM $tbname_5 WHERE nro_derecho='$vder'");
    $objs      = $sql->objects('',$obj_query);
    $locarno   = trim($objs->clasi_locarno);

    //$resumen='';
    //Obtención de datos de la Patente 
    $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
    $objs      = $sql->objects('',$obj_query);
    //$resumen = trim($objs->resumen);
    
    //$nameimage = ver_imagen($vsol1,$vsol2,'M');
    $nameimage = "../graficos/patentes/di".$vsol1."/".$vsol1.$vsol2.".jpg";
    
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
    pg_exec("CREATE TEMPORARY TABLE $ntabla1 (solicitud char(11)); CREATE INDEX diseno_sol ON diseno USING btree (solicitud)");

    $universo = 0;
    //Cantidad de Marcas en la Clase Nacional asociada   
    $obj_query = $sql->query("SELECT count(*) FROM $tbname_5 WHERE clasi_locarno='$locarno'");
    $obj_filas = $sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    if ($obj_filas==0) {
      Mensajenew('ERROR: No existen Solicitudes que cumplan con los parametros ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $universo = $universo + $objs->count;  

    // Tabla temporal de Clasificaciones de Viena asignados 
    $resultado=pg_exec("INSERT INTO $ntabla1 SELECT stzderec.solicitud FROM stzderec,stplocad
                        WHERE stzderec.nro_derecho = stplocad.nro_derecho 
                        AND stzderec.tipo_mp = 'P' AND stplocad.clasi_locarno='$locarno'");

    pg_exec("DELETE FROM $ntabla2 WHERE control = '$v1'");
    pg_exec("DELETE FROM $ntabla2 WHERE fecha < '$fechahoy'");
    $respuesta=pg_exec("SELECT DISTINCT $ntabla1.solicitud FROM $ntabla1 order by $ntabla1.solicitud");   
    $filas_found=pg_numrows($respuesta);
    $fila=1;
    while ( $fila <= $filas_found )
    {
      $regis = pg_fetch_array($respuesta);
      $vs1=trim($regis['solicitud']);
      if ($vs1 <= $vsol) {
        $obj_query = $sql->query("SELECT stplocad.clasi_locarno FROM stzderec,stplocad 
                                  WHERE stzderec.solicitud='$vs1'
                                  AND stzderec.nro_derecho=stplocad.nro_derecho 
                                  AND stzderec.tipo_mp='P'
                                  AND stzderec.tipo_derecho='G'");
        $objs = $sql->objects('',$obj_query);
        $vclase = $objs->clasi_locarno;
        $insert_str = "'$fechahoy','$horahoy','$usuario','$v1','$vs1',$vclase";
        $reg_inser = $sql->insert("$ntabla2","","$insert_str","");
      }
      $fila++;
    }
    $droptable=pg_exec("drop table $ntabla1");

    $obj_query = $sql->query("SELECT * FROM $ntabla2 WHERE control='$v1'");
    if (!$obj_query) { 
      mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla $ntabla2 ...!!!','p_pbindise.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=$sql->nums('',$obj_query);

}

//Asignación de variables para pasarlas a Smarty
$camposquery = "solicitud,clase_locarno";
$camposname= "solicitud,clase,imagen";
$tablas    = $ntabla2;
$condicion = "control=v1";
$orden     = "1";
$modo      = "Imprimir";
$modoabr   = "Sel.";
$vurl      = "p_pbindise.php";
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
$smarty->assign('campo16','Locarno:'); 
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
$smarty->assign('locarno',$locarno); 

$smarty->display('p_pbindis1.tpl');
$smarty->display('pie_pag.tpl');
?>
