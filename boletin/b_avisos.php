<?php
// *************************************************************************************
// Programa: b_avisos.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año 
// *************************************************************************************
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
include("../fckeditor/fckeditor.php") ;
//include("../editor/fckeditor.php") ;
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$sql  = new mod_db();
$sql -> connection();
$fecha   = fechahoy();
$modulo  = "b_avisos.php";

// Definicion de Tablas 
$tbname_1 = "stzavisos";

// ************************************************************************************

// Obtencion de variables de los campos del tpl 
$vopc   = $_GET['vopc'];
$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 
$accion        =$_POST['accion'];
$naviso   = $_POST['naviso'];
$titulo   = $_POST['titulo'];


$smarty->assign('titulo',$substbol);
$smarty->assign('titulo',$substbol);
$smarty->assign('subtitulo','Avisos y Documentos del Boletin de la Propiedad Industrial');
if ($vopc==3 || $vopc==4) {

   $smarty->assign('subtitulo','Ingreso de Avisos o Documentos para el Boletin'); }
   
if ($vopc==5 || $vopc==6) {
   //Carga el Estatus para mostrarlo en el combo
   $resestatus=pg_exec("select * from stzavisos order by nro_aviso");
   $cont = 0;
   $arrayestatus[$cont]=0;
   $arraydescri1[$cont]='';
   $filas_res_estatus=pg_numrows($resestatus);
   $regest = pg_fetch_array($resestatus);
   for($cont=0;$cont<$filas_res_estatus;$cont++) 
   { 
      $arrayestatus[$cont]=$regest[titulo];
      $arraydescri1[$cont]=$regest[nro_aviso]." ".substr($regest[titulo],0,150);
      $regest = pg_fetch_array($resestatus);
    }
   $smarty->assign('subtitulo','Modificaci&oacute;n de Avisos o Documentos para el Boletin'); } 

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
 $sql->connection($usuario);

// Control de acceso: Entrada y Salida al Modulo 
if ($conx==0) { 
  $smarty->assign('n_conex',$nconex);      }
else {
  if ($vopc == 3) { $opra='I'; }
  if ($vopc == 6) { $opra='M'; }
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}


if ($vopc==4) {
   $accion = "I";
   $sys_act="0";   
   $ressys=pg_exec("SELECT MAX(nro_aviso) FROM stzavisos  ");
   $filasys_found=pg_numrows($ressys); 
   $sysact = pg_fetch_array($ressys); 
   $sys_act=$sysact['max'];
   $naviso=$sys_act +1 ; 
  
} // final de $vopc==4    
    
if ($vopc==2) { 
     //se procede a grabar
     $texto=str_replace("\"", "'",$_POST['texto']); 
     $col_campos = "nro_aviso,titulo,texto";
     $insert_str = "nextval('stzavisos_nro_aviso_seq'),'$titulo','$texto' ";
     $ins_solic = $sql->insert("$tbname_1","$col_campos","$insert_str","");
   
    if ($ins_solic) {
      pg_exec("COMMIT WORK"); }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      if (!$ins_solic) { $error_aviso  = " - Avisos "; }
         Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_aviso ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag1.tpl'); exit(); 
     
    }
       
// Despligue de mensajes  
  echo "<H3><p> $msj </p></H3>"; 
  Mensajenew('DOCUMENTO GUARDADO CORRECTAMENTE !!!','b_avisos.php?vopc=3','S'); 
  $smarty->display('pie_pag1.tpl'); exit();
 
   
}

if ($vopc==6) {
   $accion = "M";
//   $titulo = $_GET['titulo'];
    // $texto = $_POST['valor'];
 
      $texto=str_replace("\"", "'",$_POST['texto']);
      pg_exec("LOCK TABLE $tbname_1 IN SHARE ROW EXCLUSIVE MODE");
  
  $update_str = "texto= '$texto'";
  $updatext = $sql->update("$tbname_1","$update_str","nro_aviso='$naviso'");
	

    if ($updatext) {
       pg_exec("COMMIT WORK"); 
       echo "<H3><p> $msj </p></H3>"; 
       Mensajenew('DOCUMENTO GUARDADO CORRECTAMENTE !!!','b_avisos.php?vopc=5','S'); 
       $smarty->display('pie_pag1.tpl'); exit();
    }
    else {
       pg_exec("ROLLBACK WORK");
       //Desconexion de la Base de Datos
       $sql->disconnect();
       if (!$updatext) { $error_aviso  = " - Avisos de Falla de Texto"; }
          Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: error_aviso ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag1.tpl'); exit(); 
    }

} // final de $vopc==6    
// ************************************************************************************ 

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Titulo del Documento.:');
$smarty->assign('campo2','Nro del Documento:');
$smarty->assign('campo3','Texto del Documento:');

$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

$smarty->assign('vopc',$vopc);
$smarty->assign('titulo',$titulo);
$smarty->assign('usuario',$usuario);
$smarty->assign('accion',$accion);
$smarty->assign('varfocus','forboletin1.naviso'); 
$smarty->assign('naviso',$naviso);
$smarty->display('b_avisos.tpl');
$smarty->display('pie_pag1.tpl');
//ob_end_clean(); 
?>
