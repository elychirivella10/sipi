<? 
// *************************************************************************************
// Programa: m_prorroga.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login   = $_SESSION['usuario_login'];
$hh      = hora();
$sql     = new mod_db(); 
$fecha   = fechahoy();  
$tbname1 = "stzevder";
$tbname2 = "stzevtrd";
$tbname3 = "stzderec";

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Decisi&oacute;n de Prorroga Solicitada'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
  
$smarty->assign('arrayprom',array(0,1,2,3));
$smarty->assign('arrayprop',array('Ninguna','Un Mes','Dos Meses','Tres Meses'));
$smarty->assign('modo','disabled');
$smarty->assign('modo1','disabled');
$smarty->assign('modo2','disabled');

//$vuser = $usuario;
     
 //Captura Variables leidas en formulario inicial
 $vopc    = $_GET['vopc'];
 $nderec  = $_POST['nderec'];
 $vsol1   = $_POST['vsol1'];
 $vsol2   = $_POST['vsol2'];
 $vfecsol = $_POST['vfecsol'];
 $vnom    = $_POST['vnom'];
 $vcla    = $_POST['vcla'];
 $vindcla = $_POST['vindcla'];
 $resultado = false;
 $vsolh   = $_POST['vsolh'];
 $vfevh   = $_POST['vfevh'];
 $vbol    = $_POST['vbol'];
 $prorroga   = $_POST['prorroga'];
 $fecha_venc = $_POST['fecha_venc'];

 //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
 $smarty ->assign('varfocus','formarcas1.vsol1'); 
 $smarty ->assign('vmodo',''); 
   
 $sql->connection($login);   
   
 //Verifica si el progrma esta en mantenimiento
 $manphp = vman_php("m_prorroga.php");
 if ($manphp==1) {
   $sql->disconnect(); $smarty->display('encabezado1.tpl');
   MensageError('Modulo en Mantenimiento ...!!!','N');
   $smarty->display('pie_pag.tpl'); exit();
 }      

 if ($vopc==1) {
   $vsol = $vsol1."-".$vsol2;
   $smarty->assign('varfocus','formarcas2.vfevh'); 
   $smarty->assign('vmodo','disabled'); 
   $smarty->assign('modo1','');
   $smarty->assign('modo2','');

   $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                       Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,nombre,estatus,registro,
                       fecha_regis,fecha_publi,fecha_venc,pais_resid,poder,tramitante
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho and tipo_mp='M' and
                       b.solicitud= '$vsol'");
      
   if (!$resultado) { 
     $sql->disconnect(); $smarty->display('encabezado1.tpl');
     mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_prorroga.php','N');
     $smarty->display('pie_pag.tpl'); exit(); }	 
   $filas_found=pg_numrows($resultado); 
   if ($filas_found==0) {
     $sql->disconnect(); $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: NO EXISTEN DATOS ASOCIADOS ...!!!','m_prorroga.php','N');
     $smarty->display('pie_pag.tpl'); exit(); }	 
   $reg = pg_fetch_array($resultado);
   $vsol     = $reg[solicitud];
   $vnom     = $reg[nombre];
   $vcla     = $reg[clase];
   $vindcla  = $reg[ind_claseni];
   $vest     = $reg[estatus];
   $vfecsol  = $reg[fecha_solic];
   $vmod     = $reg[modalidad];
   $nderec   = $reg[nro_derecho];
   if ($vmod=='D') {$vmodal='DENOMINATIVA';}
   if ($vmod=='G') {$vmodal='GRAFICA';}
   if ($vmod=='M') {$vmodal='MIXTA';}
   $nameimage=ver_imagen($vsol1,$vsol2,'M'); 
   $smarty->assign('vmod',$vmod); 
   $smarty->assign('vmodal',$vmodal); 
   $smarty->assign('nameimage',$nameimage); 
   if (($vest-1000)!=115) {  
     $sql->disconnect(); $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: Solo Aplica en Solicitudes que esten en Estatus: 115','m_prorroga.php','N');
     $smarty->display('pie_pag.tpl'); exit(); }

   //Obtención de Datos del Evento de Prorroga 
   $obj_query = $sql->query("SELECT * FROM $tbname2 WHERE evento=1028 AND  nro_derecho='$nderec'");
   if (!$obj_query) { 
     Mensajenew("ERROR: Problema al accesar la Base de Datos ...!!!","javascript:history.back();","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   $filasfound=$sql->nums('',$obj_query);
   if ($filasfound==0) {
      Mensajenew("AVISO: Evento de Solicitud de Prorroga NO Cargado a la Solicitud ...!!!","javascript:history.back();","N");     
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
   $objs  = $sql->objects('',$obj_query);
   $vfevh = $objs->fecha_event;

   //Obtención de Datos del Evento de Publicacion de Devolucion 
   $obj_query = $sql->query("SELECT * FROM $tbname2 WHERE evento=1122 AND estat_ant=1200 AND  nro_derecho='$nderec'");
   if (!$obj_query) { 
      Mensajenew("ERROR: Problema al accesar la Base de Datos ...!!!","javascript:history.back();","N");     
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   $filasfound=$sql->nums('',$obj_query);
   if ($filasfound==0) {
      Mensajenew("AVISO: Solicitud NO presenta Evento de Publicacion de Devuelta ...!!!","javascript:history.back();","N");     
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
   $objs = $sql->objects('',$obj_query);
   $vbol = $objs->documento;
   $fecha_venc = $objs->fecha_venc;

 }
   
 if ($vopc==3) {
   $vfec=hoy();
   $vsol = $vsol1."-".$vsol2;

   if ($vsol=='-' || $vfevh=='' || $vbol=='' || $prorroga=='') {
     $sql->disconnect(); $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); }

   echo " grabar=$vsol,$vfevh,$vbol,$prorroga ";

   //Validacion adiconal por si acaso otro usuario cambia la solicitud
   $resulsol=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$nderec'");
   $regsol = pg_fetch_array($resulsol);
   $vest   = $regsol[estatus];
   $vfecsol= $regsol[fecha_solic];
   if ($vest-1000==115) { //Esta bien
   } else {
     $sql->disconnect(); $smarty->display('encabezado1.tpl');
     Mensajenew($vest.'ERROR: La solicitud ha sido modificada por otro usuario','m_prorroga.php','N');
     $smarty->display('pie_pag.tpl'); exit(); }
   //$vfecsol=convertir_en_fecha($vfecsol,1);

   $esmayor=compara_fechas($vfecsol,$vfevh);
   if ($esmayor==1) {
     $sql->disconnect(); $smarty->display('encabezado1.tpl');
     mensajenew('No se puede cargar un evento previo a la Fecha de la Solicitud',
                    'javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); }

   $estatus    = 1115;
   $tipo_plazo = "M";
   $plazo_ley  = $prorroga;
   if ($prorroga!=0) {
     $evento  = 1029;
     $vestfin = 1119; 
     $vdesev  = "PRORROGA A DEVOLUCION OTORGADA";
     $vcomen  = "SOLICITUD CON PRORROGA OTORGADA DE ".$prorroga." MES"; 
     $fechavenc  = calculo_fechas($fecha_venc,$plazo_ley,$tipo_plazo,"/"); }
   else {
     $evento  = 1031;
     $vestfin = 1022; 
     $vdesev  = "PRORROGA A DEVOLUCION NEGADA";
     $vcomen  = "SOLICITUD CON PRORROGA NEGADA"; 
   }

   $horactual=hora();
   //Comienzo de Transaccion      
   pg_exec("BEGIN WORK");

   $act_dere = true;
   // Actualizar Stzderec
   $update_str="estatus=$vestfin";
   if ($prorroga!=0) { $update_str = $update_str.",fecha_venc='$fechavenc'"; }
   $act_dere = $sql->update("$tbname3","$update_str","nro_derecho='$nderec'");    

   //Inserto Datos en la tabla de Tramite Stzevtrd
   $instram = true;
   if ($plazo_ley <> 0) {
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$nderec','$evento','$vfec',nextval('stzevtrd_secuencial_seq'),'$estatus','$fechavenc','$prorroga','$vfec','$usuario','$vdesev','$vcomen','$horactual'";
   } 
   else {
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$nderec','$evento','$vfec',nextval('stzevtrd_secuencial_seq'),'$estatus','$prorroga','$vfec','$usuario','$vdesev','$vcomen','$horactual'";
   }
   $instram = $sql->insert("$tbname2","$col_campos","$insert_str",""); 

   // Verificacion y actualizacion real de los Datos en BD 
   if ($act_dere AND $instram) {
     pg_exec("COMMIT WORK");
     //Desconexion de la Base de Datos
     $sql->disconnect();
   
     $smarty->display('encabezado1.tpl');
     Mensajenew("DATOS GUARDADOS CORRECTAMENTE !!!","m_prorroga.php",'S');
     $smarty->display('pie_pag.tpl'); exit();
   }
   else {
     pg_exec("ROLLBACK WORK");
     //Desconexion de la Base de Datos
     $sql->disconnect();

     if (!$act_dere) { $error_pri  = " - Maestra "; } 
     if (!$instram)  { $error_tra  = " - Tr&aacute;mite "; }
     Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_pri $error_tra  ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit();
   }
      
 }   
 //Asignacion de variables para pasarlas a Smarty
 $smarty->assign('nderec',$nderec); 
 $smarty->assign('vopc',$vopc); 
 $smarty->assign('solicitud1',$vsol1); 
 $smarty->assign('solicitud2',$vsol2); 
 $smarty->assign('vsol1',$vsol1); 
 $smarty->assign('vsol2',$vsol2); 
 $smarty->assign('nombre',$vnom); 
 $smarty->assign('clase',$vcla); 
 $smarty->assign('vfevh',$vfevh); 
 $smarty->assign('vfec',$vfec); 
 $smarty->assign('vfecsol',$vfecsol); 
 $smarty->assign('fecha_venc',$fecha_venc); 
 $smarty->assign('vbol',$vbol); 

 if ($vindcla=="I") {$smarty->assign('ind_claseni','INTERNACIONAL');}; 
 if ($vindcla=="N") {$smarty->assign('ind_claseni','NACIONAL');}; 
 $smarty->assign('lsolicitud','Solicitud:'); 
 $smarty->assign('lfechasolic','Fecha de Solicitud:'); 
 $smarty->assign('lfechaevent','Fecha de la Prorroga:'); 
 $smarty->assign('lnombre','Nombre:');
 $smarty->assign('lclase','Clase:'); 
 $smarty->assign('lotro','Otro:'); 
 $smarty->assign('lmodal','Modalidad:'); 
 $smarty->assign('campo1','Prorroga Otorgada:'); 
 $smarty->assign('lboletin','a Devolucion Publicada en:');
 $smarty->assign('espacios',''); 

 $smarty->display('encabezado1.tpl');
 $smarty->display('m_prorroga.tpl'); 
 $smarty->display('pie_pag.tpl');
?>
