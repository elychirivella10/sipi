<!-- DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" -->

<head>
<script language="Javascript"> 

function browsetitularp(var1,var2,var3,var4) {
  this.derecho='P';
  open("../comun/adm_titular.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion de Anualidad ?'); }

</script> 
</head>

<?php
// *************************************************************************************
// Programa: p_anualidad.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado II Semestre 2009 BD - Relacional   
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit(); }

//Variables
$usuario = ltrim(rtrim($_SESSION['usuario_login']));
$sql     = new mod_db();
$fecha   = fechahoy();

$tbname_1 = "stppatee";
$tbname_2 = "stpanual";
$tbname_4 = "stzderec";
$tbname_5 = "stzstder";
$tbname_6 = "stzagenr";
$tbname_14= "stztmptit";
$tbname_15= "stzottid";
$tbname_16= "stzsolic";
$tbname_3 = "stzevtrd";
$tbname_7 = "stzevder";

$vopc  = $_GET['vopc'];
$vder  = $_POST['vder'];
$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vreg1 = $_POST['vreg1'];
$vreg2 = $_POST['vreg2'];
$vtipo = $_POST['vtipo'];
$vest  = $_POST['vest'];
$vnom  = $_POST['vnom'];
$fecha = $_POST['fecha_evento'];
$anuali1  = $_POST['anuali1'];
$anuali2  = $_POST['anuali2'];
$planilla = $_POST['planilla'];
//$tasa     = $_POST['planilla'];
$tasa     = $_POST['tasa'];
$monto    = $_POST['monto'];
$multa    = $_POST['multa'];
$monto_multa = $_POST['monto_multa'];

if (empty($vsol1)) {$vsol1 = $_GET['vsol1'];}
if (empty($vsol2)) {$vsol2 = $_GET['vsol2'];}
if (empty($vreg1)) {$vreg1 = $_GET['vreg1'];}
if (empty($vreg2)) {$vreg2 = $_GET['vreg2'];}

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Carga de Anualidades de Patentes con Pagos de Derecho a Concesion');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
//$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol1'); 
$smarty ->assign('vmodo','disabled'); 

if (empty($vopc)) {
  $smarty ->assign('modo2','disabled'); 
  $smarty ->assign('modo3','disabled');
  $smarty ->assign('modo4','disabled'); } 

//if (($usuario!='rmendoza') AND ($usuario!='ngonzalez')) {
//  mensajenew('AVISO: Opci&oacute;n del sistema en Mantenimiento, Comuniquese con el Administrador del Sistema SIPI ...!!!','javascript:history.back();','N');
//  $smarty->display('pie_pag.tpl'); exit();
//}

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
     mensajenew('ERROR: No introdujo ningún valor de Expediente ...!!!','p_anualidad.php','N');
     $smarty->display('pie_pag.tpl'); exit(); }
   $resultado=pg_exec("SELECT * FROM $tbname_4 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='P'");
  }

  if ($vopc==2) {
   //Validacion del Numero de Registro - Mostrar Informacion 
   if (empty($vreg1) && empty($vreg2))
    {
      mensajenew('ERROR: No introdujo ningún valor de Expediente ...!!!','p_anualidad.php','N');
      $smarty->display('pie_pag.tpl'); exit(); }
   $resultado=pg_exec("SELECT * FROM $tbname_4 WHERE registro='$vreg' and registro!='' AND tipo_mp='P'");   
  }
  
  if ($vopc==1 || $vopc==2) {
    //$smarty ->assign('submitbutton','button'); 
    $smarty ->assign('varfocus','formarcas3.vdoc'); 
    $smarty ->assign('vmodo','readonly'); 
    $smarty ->assign('modo2',''); 
    $smarty ->assign('modo','disabled');
 
    if (!$resultado) { 
      mensajenew('ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!','p_anualidad.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','p_anualidad.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $reg = pg_fetch_array($resultado);

    $vder=$reg[nro_derecho];
    $vsol=$reg[solicitud];
    $vest=$reg[estatus];
    $vsol1=substr($vsol,-11,4);
    $vsol2=substr($vsol,-6,6);
    $vreg=$reg[registro];
    $vreg1=substr($vreg,-8,1);
    $vreg2=substr($vreg,1);
    $vnom=trim($reg[nombre]);
    $vtipo=$reg[tipo_derecho];
    $vfecsol=$reg[fecha_solic];
    $vfecreg=$reg[fecha_regis];
    $vfecven=$reg[fecha_venc];
    $vcodage=$reg[agente];
    $vtra=trim($reg[tramitante]);

    //Validacion de Publicacion de Concesion
    $obj_query = $sql->query("SELECT * FROM stzevtrd a, stzderec b WHERE b.solicitud = '$vsol' AND
                             a.evento in (2122) AND a.estat_ant in (2101) AND
                             b.nro_derecho = a.nro_derecho AND b.tipo_mp='P'");
    if (!$obj_query) { 
      mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla de Cronologia ...!!!","p_anualidad.php","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_conc=$sql->nums('',$obj_query);
    if ($filas_conc==0) {
      Mensajenew('ERROR: La Solicitud NO ha sido Concedida en alg&uacute;n Bolet&iacute;n...!!!','p_anualidad.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    switch ($vtipo) {
      case "A":
         $vtip='INVENCION';
         break;
      case "B":
         $vtip='DIBUJO INDUSTRIAL';
         break;
      case "C":
         $vtip='DE MEJORA';
         break;
      case "D":
         $vtip='DE INTODUCCION';
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
    //Obtención de la Descripción del Estatus 
    $vdesest = estatus($vest);

    $resumen='';
    //Obtención de datos de la Patente  
    $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
    $objs = $sql->objects('',$obj_query);
    $vultanual = $objs->anualidad;
    $vresumen  = trim($objs->resumen);

    // Obtencion del o los Titular(es)  
    $sql->del("$tbname_14","solicitud='$vsol'");
    $obj_query = $sql->query("SELECT stzottid.titular,stzsolic.nombre,stzsolic.indole,stzottid.domicilio,stzottid.nacionalidad 
                              FROM stzottid,stzsolic WHERE stzottid.nro_derecho ='$vder' AND  
                                   stzottid.titular=stzsolic.titular");
    $obj_filas = $sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $vcod = $objs->titular;
      $nomb = $objs->nombre;
      $domi = $objs->domicilio;
      $pais = $objs->nacionalidad;
      $indo = $objs->indole;
      if (empty($indo)) { $indo = "P"; }  
      $col_campos = "solicitud,titular,nombre,domicilio,nacionalidad,indole,tipo_mp";
      $insert_str = "'$vsol','$vcod','$nomb','$domi','$pais','$indo','P'";
      $sql->insert("$tbname_14","$col_campos","$insert_str","");
    $objs = $sql->objects('',$obj_query); }	  

    
    if ($vtipo=="G") { $smarty ->assign('modo4','disabled'); }
    if ($vtipo=="A") { $smarty ->assign('modo3','disabled'); }
    if ($vtipo=="F") { $smarty ->assign('modo3','disabled'); }
    $multa = "N";
    
  }

  // Opcion de Grabar Informacion  
  if ($vopc==3) {

    if ((empty($vsol) || ($vsol=="0000-000000")) && empty($vreg)) {
      Mensajenew('ERROR: NO SELECCIONO NINGUN EXPEDIENTE ...!!!','p_anualidad.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    if ($anuali1==0 || $anuali2==0) {
      Mensajenew('ERROR: La Anualidad no puede ser Cero ...!!!','p_anualidad.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    if ($anuali2 < $anuali1) {
      Mensajenew('ERROR: Ultima Anualidad menor a la Primera ...!!!','p_anualidad.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    if ((empty($monto)) || ($monto==0)) {
      Mensajenew('ERROR: El Monto esta en blanco o NO puede ser Cero ...!!!','p_anualidad.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    if ((empty($tasa)) || ($tasa=='0')) {
      Mensajenew('ERROR: La Tasa esta en blanco o NO puede ser Cero ...!!!','p_anualidad.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    if ((empty($planilla)) || ($planilla=='0')) {
      Mensajenew('ERROR: La Planilla esta en blanco o NO puede ser Cero ...!!!','p_anualidad.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    if ($multa=="N") { $monto_multa = 0; }
    if ($multa=="S") { 
      if ($monto_multa==0) {
        Mensajenew('ERROR: El Monto de la Multa esta en blanco o NO puede ser Cero ...!!!','p_anualidad.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    }
   
    //Consulta de Ultima Anualidad Cargada ... 
    $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
    if (!$obj_query) { 
      mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","p_anualidad.php","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=$sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    $ultanualpat = $objs->anualidad;

    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $obser = '';
    $numanual = 0;
    $evenanual = 2236;
    $act_paten = true;
    $ins_anual = true;
    $fechahoy  = hoy();
    $horactual = Hora();
    $anualidad = $anuali1;
    $monto = str_replace(",",".",$monto);
    $total_anualidad = ($anuali2-$anuali1)+1;
    for($cont=1;$cont<=$total_anualidad;$cont++) 
    { 
      $col_campos = "nro_derecho,fecha_anual,anualidad,monto,observacion,planilla,tasa,usuario,fecha_trans,hora,ind_multa,multa";
      $insert_str = "'$vder','$fecha',$anualidad,$monto,'$obser','$planilla','$tasa','$usuario','$fechahoy','$horactual','$multa',$monto_multa";

      //Verificacion de Anualidad ... 
      $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho='$vder' AND anualidad=$anualidad");
      if (!$obj_query) { 
        mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","p_anualidad.php","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_found=$sql->nums('',$obj_query);
      if ($filas_found!=0) {
        mensajenew("ERROR: Anualidad $anualidad ya Cargada a solicitud $vsol ...!!!","p_anualidad.php","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      
      $ins_anual = $sql->insert("$tbname_2","$col_campos","$insert_str","");
      if ($ins_anual) { }
        else { $numanual = $numanual + 1; }  
      $anualidad = $anualidad + 1;
    }

    //Verificacion de Anualidad para actualizar ... 
    if ($anuali2 > $ultanualpat) {
      // Maestra de Patentes
      pg_exec("LOCK TABLE stppatee IN SHARE ROW EXCLUSIVE MODE");
      $update_str = "anualidad='$anuali2'";
      $act_paten = $sql->update("$tbname_1","$update_str","nro_derecho='$vder'");

      //busqueda de evento 236
      $obj_querye = $sql->query("SELECT * FROM $tbname_7 WHERE evento='$evenanual'");
      if (!$obj_querye) { 
        mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_7 ...!!!","p_anualidad.php","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filase_found=$sql->nums('',$obj_querye);
      $objse = $sql->objects('',$obj_querye);
      $mensa_automatico = $objse->mensa_automatico;

      $vest = $vest + 2000;
      $comentario = "Anualidad ".$anuali1." a la ".$anuali2." pagada segun Planilla No ".$planilla." y Factura/Tasa No ".$tasa;
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evenanual','$fecha',nextval('stzevtrd_secuencial_seq'),'$vest','$tasa','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
      $instram = $sql->insert("$tbname_3","$col_campos","$insert_str",""); 

    }
    
    // Verificacion y actualizacion real de los Datos en BD 

    if ($numanual==0 AND $act_paten) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!',"p_anualidad.php?vopc=1&vsol1=$vsol1&vsol2=$vsol2",'S');
      $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK"); 
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if ($numanual!=0) { $error_anual  = " - Detalle de Anualidad "; }
      if (!$act_paten) { $error_paten = " - Patentes "; }
      
      Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_anual $error_paten ...!!!","p_anualidad.php","N");
      $smarty->display('pie_pag.tpl'); exit();  
    }
  
  }

$smarty->assign('multa_opc',array(N,S));
$smarty->assign('multa_def',array('No','Si'));
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro No.:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo6','T&iacute;tulo:');
$smarty->assign('campo7','Estatus:');
$smarty->assign('campo8','Fecha Registro:');
$smarty->assign('campo9','Fecha Vencimiento:');
$smarty->assign('campo10','Agente/Tramitante:');
$smarty->assign('campo11','Titular(es):');
$smarty->assign('campo12','Anualidades Pagadas:');
$smarty->assign('campo13','Fecha del Pago:');
$smarty->assign('campo14','Ultima Anualidad Pagada:');
$smarty->assign('campo15','Presenta Multa:');
$smarty->assign('campo16','Monto Multa:');

$smarty->assign('campo18','Anualidad No.:');
$smarty->assign('campo19','Planilla No.:');
$smarty->assign('campo20','Factura No.:');
$smarty->assign('campo21','Monto:');

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
$smarty->assign('vtit',$vtit); 
$smarty->assign('vest',$vest-2000); 
$smarty->assign('vdesest',$vdesest); 
$smarty->assign('vfecsol',$vfecsol); 
$smarty->assign('vfecreg',$vfecreg); 
$smarty->assign('vfecven',$vfecven);
$smarty->assign('arraycodest',$arraycodest);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('vultanual',$vultanual);
//$smarty->assign('anuali1',$vultanual+1);
$smarty->assign('multa',$multa);
$smarty->assign('vtip',$vtip);
$smarty->assign('vtipo',$vtipo);
$smarty->assign('vtra',$vtra);
$smarty->assign('vcodtit',$vcodtit);
$smarty->assign('vnomtit',$vnomtit);
$smarty->assign('vnactit',$vnactit);
$smarty->assign('vnadtit',$vnadtit);
$smarty->assign('vdomtit',$vdomtit);
if ($vopc==1) {$smarty->assign('varfocus','formarcas3.fecha_evento'); }
else          {$smarty->assign('varfocus','formarcas1.vsol1'); }
$smarty->assign('usuario',$usuario);
$smarty->display('p_anualidad.tpl');
$smarty->display('pie_pag.tpl');
?>
