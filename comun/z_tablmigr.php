<?php
// *************************************************************************************
// Programa: z_tablmigr.php  
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$sql      = new mod_db();
$tbname_1 = "stzevder";
$tbname_2 = "stzstder";
$tbname_3 = "stzmigrr";
$fecha    = fechahoy();

$vopc    = $_GET['vopc'];
$accion  = $_POST['accion'];
$estatus = $_POST['estatus'];
$inicial = $_POST['inicial'];
$final   = $_POST['final'];
$tipomp  = $_POST['tipoder'];


$smarty->assign('titulo','Sistema de Marcas y Patentes');
$smarty->assign('subtitulo','Mantenimiento de Migraciones / '.$accion); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Migraciones / Ingreso'); }
if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Migraciones / Modificacion'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


echo "$vopc, $tipomp, $accion ";
if ($vopc==1 && $accion=='Modificacion') {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('accion',2);
  $smarty->assign('varfocus','frmstatus2.inicial');

  //Verificando conexion
  $sql->connection();

  $resultado=pg_exec("SELECT * FROM stdmigrr WHERE evento='$estatus'");
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!",'a_tablmigr.php?vopc=4',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $estatus=$reg[evento];
  $inicial =$reg[estatus_ini];
  $final   =$reg[estatus_fin];  

  //Paso a Smarty los Valores
  $smarty->assign('estatus',$estatus);
  $smarty->assign('inicial',$inicial);
  $smarty->assign('final',$final);
}

if ($vopc==1 && $accion=='Ingreso') {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('accion',1);
  $smarty->assign('varfocus','frmstatus2.inicial');

  //Verificando conexion
  $sql->connection();

    //Obtención de los Eventos 
    $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE tipo_mp = '$tipomp' ORDER BY evento"); 
    if (!$obj_query) { 
      mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!','m_evelote.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=$sql->nums('',$obj_query);
    if ($filas_found==0) {
      mensajenew('La Tabla de Eventos esta Vacia ...!!!','z_tablmigr.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
    $cont = 0;
    $arrayevento[$cont]=0;
    $arraydescri[$cont]='';
    $objs = $sql->objects('',$obj_query);
    for($cont=1;$cont<=$filas_found;$cont++) { 
      $arrayevento[$cont]=$objs->evento-1000;
      $arraydescri[$cont]=sprintf("%03d",$objs->evento-1000)."  ".substr(trim($objs->descripcion),0,75);
      $objs = $sql->objects('',$obj_query);
    }
  
  //Obtención de los Estatus
  $obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE tipo_mp = '$tipomp' ORDER BY estatus");
  if (!$obj_query) { 
    mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!','z_tablmigr.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('La Tabla de Estatus esta Vacia ...!!!','m_evelote.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
  $cont = 0;
  $arrayest1[$cont]=0;
  $arraynom1[$cont]='';
  $arrayest2[$cont]=0;
  $arraynom2[$cont]='';
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
    $arrayest1[$cont]=$objs->estatus-1000;
    $arraynom1[$cont]=sprintf("%03d",$objs->estatus-1000)."  ".substr(trim($objs->descripcion),0,75);
    $arrayest2[$cont]=$objs->estatus-1000;
    $arraynom2[$cont]=sprintf("%03d",$objs->estatus-1000)."  ".substr(trim($objs->descripcion),0,75);
    $objs = $sql->objects('',$obj_query);
  }


  //$resultado=pg_exec("SELECT * FROM stdevobr WHERE evento='$estatus'");
  //$filas_found=pg_numrows($resultado);
  //if ($filas_found==0) { 
  //  mensajenew("EL EVENTO NO ESTA REGISTRADO...!!!",'z_tablmigr.php?vopc=3',"N");
  //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  //}	 
  
  //Paso a Smarty los Valores
  $smarty->assign('estatus',$estatus);
  $smarty->assign('inicial',$inicial);
  $smarty->assign('final',$final);
}

if ($vopc==3) {
  $smarty->assign('varfocus','frmstatus1.estatus'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',1);
}

if ($vopc==4) {
  $smarty->assign('varfocus','frmstatus1.estatus'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
}

//Opcion Grabar...
if ($vopc==2) {
  //Verificando conexion
  $sql->connection();

  //Verificacion de que los campos requeridos esten llenos...
  if (empty($inicial) || empty($final)) {
    mensajenew("Hay Informacion basica en el formulario que esta Vacia ...!!!",
               "javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $resultado=pg_exec("SELECT * FROM stdmigrr WHERE evento='$estatus' and 
                      estatus_ini='$inicial' and estatus_fin='$final'");
  $filas_found=pg_numrows($resultado); 
  if ($filas_found>0) {
    mensajenew("Esta Migración ya esta Registrada...!!!",
               "javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  pg_exec("BEGIN WORK");
  //al Incluir
  if ($accion==1) {
    pg_exec("LOCK TABLE stdmigrr IN SHARE ROW EXCLUSIVE MODE");
    $insert_cam = "evento,estatus_ini,estatus_fin";
    $insert_str = "$estatus,$inicial,$final";
    $sql->insert("stdmigrr","$insert_cam","$insert_str","");
  }
  //al Modificar
  if ($accion==2) {
    // Actualizo en Maestra de Eventos
    pg_exec("LOCK TABLE stdmigrr IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "estatus_ini=$inicial,estatus_fin=$final";
    $sql->update("stdmigrr","$update_str","evento='$estatus'");
  }
  pg_exec("COMMIT WORK");
  //Desconexion de la Base de Datos
  $sql->disconnect();

  if ($accion==1) {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','z_tablmigr.php?vopc=3','S');
    $smarty->display('pie_pag.tpl'); exit(); }
  else {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','z_tablmigr.php?vopc=4','S');
    $smarty->display('pie_pag.tpl'); exit(); }
}

$smarty->assign('tipo_der',array(M,P));
$smarty->assign('dere_def',array('Marcas','Patentes')); 

$smarty->assign('campo1','Migraci&oacute;n aplicada a:');
$smarty->assign('campo2','Evento de Migraci&oacute;n:');
$smarty->assign('campo3','Estatus Inicial:');
$smarty->assign('campo4','Estatus Final:');

$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('arrayest1',$arrayest1);
$smarty->assign('arraynom1',$arraynom1);
$smarty->assign('arrayest2',$arrayest2);
$smarty->assign('arraynom2',$arraynom2);


$smarty->assign('vopc',$vopc);
$smarty->assign('estatus',$estatus);
$smarty->display('z_tablmigr.tpl');
$smarty->display('pie_pag.tpl');
?>
