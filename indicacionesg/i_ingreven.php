<script language="Javascript"> 

  function checkKey(evt){
   if (evt.keyCode == '17')  
     {alert("Comando No Permitido ...!!!");
     return false;}
   return true; }
   
  function cerrarwindows() {
     window.close(); }
  
function getKey(keyStroke) {  
isNetscape=(document.layers); 
eventChooser = (isNetscape) ? keyStroke.which : event.keyCode;    
if (eventChooser==13) {      
   return false; 
   }  
} 
document.onkeypress = getKey;

</script> 

<?php
// *************************************************************************************
// Programa: i_ingreven.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Dirección de Sistenas y Tecnologias de la Informacion / SAPI / MILCO
// Año: 2022
// *************************************************************************************

//Includes para trabajar con Operaciones de Bases de Datos y Librerias 
include ("../z_includes.php");

//Variables
$tbname_q1 = "stiindig";
$tbname_q2 = "stzstder";
$tbname_q3 = "stzderec";

$sql       = new mod_db();
$fecha     = fechahoy();

//Validacion de Entrada
$vopc    = $_GET['vopc'];
$usuario = $_POST['usuario'];
$role    = $_POST['role'];
$vsol1   = $_POST["vsol1"];
$vsol2   = $_POST["vsol2"];
$vreg1   = $_POST["vreg1"];
$vreg2   = $_POST["vreg2"];
$vcodeve = $_POST['vcodeve'];
$eventos_id = $_POST['eventos_id'];
$modalidad  = $_POST['modalidad'];
$nconex     = $_POST['nconex'];

//Encabezado de la Pantalla 
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// ************************************************************************************  
// Control de acceso: Entrada y Salida al Modulo 
$smarty->assign('n_conex',$nconex);
// ************************************************************************************  

if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol1) && empty($vsol2)) {
      mensajenew("ERROR: No introdujo ning&uacute;n valor de Expediente ...!!!","i_eveind.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}
if ($vopc==2) {
   //Validacion del Numero de Registro
   if (empty($vreg1) && empty($vreg2)) {
      mensajenew("ERROR: No introdujo ning&uacute;n valor de Expediente ...!!!","i_eveind.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}

//Verificando conexion
$sql->connection($usuario);

//Armado de Numero de Expediente
if ($vopc==1) {
  $varsol=sprintf("%02d-%06d",$vsol1,$vsol2);
  $resultado=pg_exec("SELECT * FROM $tbname_q3 WHERE solicitud='$varsol' and solicitud!='' and tipo_mp='I'"); }
if ($vopc==2) {
  $vreg='';
  if (!empty($vreg1) && !empty($vreg2)) {
    $vreg = $vreg1.$vreg2; }
  $resultado=pg_exec("SELECT * FROM $tbname_q3 WHERE registro='$vreg' and registro!='' and tipo_mp='I'"); }

if (!$resultado) { 
     mensajenew("ERROR: Nro. de Expediente ingresado NO existe en la Base de Datos ...!!!","i_eveind.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     mensajenew("ERROR: No existen Datos asociados al Expediente en Maestra de Indicaciones Geograficas ...!!!","i_eveind.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } 
$reg = pg_fetch_array($resultado);

//if ($resmod[modalidad]=='I') {$vmod='Declaraci&oacute;n de Indicaci&oacute;n Geogr&aacute;fica';}
//if ($resmod[modalidad]=='R') {$vmod='Reconocimiento de Indicaci&oacute;n Geogr&aacute;fica';}

if ($reg['tipo_derecho']=='I') {$tipo_marca='INDICACION GEOGRAFICA';}

$vder        =$reg['nro_derecho'];
$varsol      =$reg['solicitud'];
$nombre      =$reg['nombre'];
$estatus     =$reg['estatus'];
$fecha_solic =$reg['fecha_solic'];
$fecha_venc  =$reg['fecha_venc'];
$vreg        =trim($reg['registro']);
$dirano      =substr($varsol,-11,4);
$vexp        =$dirano."-".substr($varsol,-6,6);
$numero      =substr($varsol,-6,6);
$vsol        =$varsol;

//Obtención de datos de la Indicacion Geo.
$obj_query = $sql->query("SELECT * FROM $tbname_q1 WHERE nro_derecho='$vder'");
$objs = $sql->objects('',$obj_query);
$modalidad = $objs->modalidad;
if ($modalidad != "D") {
   $nameimage = ver_imagen($vsol1,$vsol2,"M");
}

//Obtención de la Descripción del Estatus 
$obj_query = $sql->query("SELECT * FROM $tbname_q2 WHERE estatus='$estatus'");
$objs = $sql->objects('',$obj_query);
$descripcion = $objs->descripcion;

//Obtención de los posibles eventos a aplicar al Expediente según el estatus de la marca 
if (empty($vreg)) {
  $resevento=pg_exec("SELECT stzevder.evento,stzevder.descripcion FROM stzmigrr,stzevder 
                      WHERE stzmigrr.estatus_ini = '$reg[estatus]' and
                            stzmigrr.tipo_mp = 'I' and
                            stzmigrr.evento=stzevder.evento and 
                            stzevder.tipo_mp = 'I' and
                            stzevder.aplica in ('T','A')
                      UNION
                      SELECT stzevder.evento,stzevder.descripcion FROM stzmigrr,stzevder 
                      WHERE stzmigrr.estatus_ini = 3888 and
                            stzmigrr.tipo_mp = 'I' and
                            stzmigrr.evento=stzevder.evento and
                            stzevder.tipo_mp = 'I' and  
                            stzevder.aplica in ('T','A')                      
                      UNION 
                      SELECT stzevder.evento,stzevder.descripcion FROM stzevder 
                      WHERE  stzevder.tipo_evento='N' and stzevder.tipo_mp = 'I'");
 
}
else {
  $resevento=pg_exec("SELECT stzevder.evento,stzevder.descripcion FROM stzmigrr,stzevder 
                      WHERE stzmigrr.estatus_ini = '$reg[estatus]' and
                            stzmigrr.tipo_mp = 'I' and
                            stzmigrr.evento=stzevder.evento and
                            stzevder.tipo_mp = 'I' and 
                            stzevder.aplica in ('R','A')
                      UNION
                      SELECT stzevder.evento,stzevder.descripcion FROM stzmigrr,stzevder 
                      WHERE stzmigrr.estatus_ini = 3888 and
                            stzmigrr.tipo_mp = 'I' and
                            stzmigrr.evento=stzevder.evento and
                            stzevder.tipo_mp = 'I' and 
                            stzevder.aplica in ('R','A')                      
                      UNION 
                      SELECT stzevder.evento,stzevder.descripcion FROM stzevder 
                      WHERE  stzevder.tipo_evento='N' and stzevder.tipo_mp = 'I'"); 
}

$cont = 0;
$arrayevento[$cont]=0;
$arraydescri[$cont]='';
$filas_res_evento=pg_numrows($resevento);
$regeve = pg_fetch_array($resevento);
for($cont=1;$cont<=$filas_res_evento;$cont++) 
  { 
    $arrayevento[$cont]=$regeve[evento]-3000;
    //$arraydescri[$cont]=substr($regeve[descripcion],0,70);
    $arraydescri[$cont]=sprintf("%03d",$regeve[evento]-3000)." ".substr($regeve[descripcion],0,70);
    $regeve = pg_fetch_array($resevento);
  }

$sql->disconnect();

$smarty->assign('vder',$vder);
$smarty->assign('vopc',$vopc); 
$smarty->assign('anno',$dirano);
$smarty->assign('numero',$numero);
$smarty->assign('nombre',$nombre);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('fecha_venc',$fecha_venc);
$smarty->assign('tipo_marca',$tipo_marca);
$smarty->assign('estatus',$estatus-3000);
$smarty->assign('descripcion',$descripcion);
$smarty->assign('registro',$vreg);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('modalidad',$modalidad);
$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('eventos_id',0);
$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('vcodeve',$vcodeve);
$smarty->assign('eventos_id',$eventos_id);

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('campo3','Tipo:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Estatus:');
$smarty->assign('campo6','Registro:');
$smarty->assign('campo7','Evento:');

$smarty->display('i_ingreven.tpl');
$smarty->display('pie_pag.tpl');
?>
