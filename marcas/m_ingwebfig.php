<?php
// *************************************************************************************
// Programa: m_bexlogo.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2010
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];

//Verificando conexion
$sql = new mod_db();
$sql->connection($usuario);

//Variables
$tbname_1 = "stmcntrl";
$fecha    = fechahoy();
$vopc     = $_GET['vopc'];

// ****************************************
$smarty->assign('titulo',$substmar);
if (($vopc!=1) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('subtitulo','Carga de B&uacute;squeda de Elementos Figurativos Web'); 
}
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

//Opcion Generar e Ingresar...
if ($vopc==2) {
  $smarty->assign('subtitulo','Carga de B&uacute;squeda de Elementos Figurativos Web'); 
  $smarty->display('encabezado1.tpl');

  $existefile = true;
  $existefile = file_exists('/apl/webpi/graficas/graficas.txt'); 
  if ($existefile) { }
  else {
   Mensajenew('ERROR: El archivo con la informaci&oacute;n de las Graficas No Existe o no ha sido generado aun ...!!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 

  $tamano = 0;
  $tamano = filesize('/apl/webpi/graficas/graficas.txt'); 
  if (($tamano==0) || ($tamano==1)) {
   Mensajenew('ERROR: El archivo generado esta vac&iacute;o  ...!!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 

  //Creo tabla temporal
  //$creacion = pg_exec("CREATE TEMPORARY TABLE stmtmpweb (nro_tramite integer, nro_busgra integer, fechatra date, horatra character(11), solicitante character varying(90), fechaing date, estatus character(1), usuario character(12), imagen character varying(180), prioridad character(1), identificacion character(10), indole character(1), telefono character(15), sede character(2), clase integer)");
  $creacion = pg_exec("CREATE TABLE stmtmpweb (nro_tramite integer, nro_busgra integer, fechatra date, horatra character(11), solicitante character varying(90), fechaing date, estatus character(1), usuario character(12), imagen character varying(180), prioridad character(1), identificacion character(10), indole character(1), telefono character(15), sede character(2), clase integer)");

 //Cargo el archivo plano en la tabla temporal
 $copiadata = pg_exec("copy stmtmpweb from '/apl/webpi/graficas/graficas.txt' delimiter '|'");
 echo "archivo=$existefile,$tamano,$creacion,$copiadata";

 $accion    = 2;
 $numerror  = 0;
 $fechahoy  = Hoy();
 $obj_query = $sql->query("SELECT * FROM stmtmpweb");
 $obj_filas = $sql->nums('',$obj_query);
 if ($obj_filas==0) {
   Mensajenew('ERROR: No hay informacion de graficas que cargar ...!!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
 $objs = $sql->objects('',$obj_query);
 //Comienzo de Transaccion 
 pg_exec("BEGIN WORK");
 echo "registros= $obj_filas ";
 for($i=0;$i<$obj_filas;$i++) { 
    $ntram    = $objs->nro_tramite;
    $ngraf    = $objs->nro_busgra;
    $fechatra = $objs->fechatra;
    $horatra  = $objs->horatra;
    $interesado = trim($objs->solicitante);
    $fechaing   = $objs->fechaing;
    $identifica = $objs->identificacion;
    $indole   = $objs->indole;
    $logotipo = trim($objs->imagen);
    $telefono = trim($objs->telefono);
    $clase    = $objs->clase;
    $horactual= Hora();
    $solicitante = str_replace("'","`",$interesado);

    echo "$ntram,$ngraf,$fechatra,$logotipo";
    //Generacion del Nuevo Numero de Pedido segun SIPI 
    $objquery = $sql->query("update stzsystem set figurativo=nextval('stzsystem_figurativo_seq')");
    $objquery = $sql->query("select last_value from stzsystem_figurativo_seq");
    $objsys = $sql->objects('',$objquery);
    $vauxnum = $objsys->last_value;

    $insbusq    = true;
    $insert_str = "'$vauxnum','$ntram','$fechatra','$horatra','$solicitante','$fechahoy','1','$usuario','$logotipo','N','$identifica','$indole','$telefono','03',$clase"; 
    $insbusq    = $sql->insert("$tbname_1","","$insert_str","");
    if ($insbusq) { }
    else { $numerror = $numerror + 1; }

   $objs = $sql->objects('',$obj_query); 
 }
 if ($numerror==0) {
   pg_exec("COMMIT WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();
   //Borrado del archivo grafico
   unlink('/apl/webpi/graficas/graficas.txt'); 

   Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_ingwebfig.php?vopc=1','S');
   $smarty->display('pie_pag.tpl'); exit();
 }
 else {
   pg_exec("ROLLBACK WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();

   Mensajenew("ERROR: Falla de Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit();
 }

  // Ingreso de Solicitud
  if ($accion==1) {

    //Variable para la busqueda de la imagen en busqueda
    //$ruta = "../graficos/logbext/";
    //$archivo = "$vsol1";
    //if (!empty($archivo)) {
    //  //Copiar archivo de logotipo en ruta final
    //  $max_size = 1024*100; // the max. size for uploading	
    //  $my_upload = new file_upload;
    //  $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
    //  $my_upload->extensions = array(".jpg", ".jpge",".png"); // specify the allowed extensions here
    //  $my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
    //  $my_upload->rename_file = true;
    //  //$my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
    //  //$my_upload->the_file = $_FILES['ubicacion']['name'];
    //  $my_upload->the_temp_file = "../graficos/sin_imagen.jpg";
    //  $my_upload->the_file = "$vsol1";
    //  //$my_upload->http_error = $_FILES['ubicacion']['error'];
    //  $my_upload->validateExtension();
    //  if ($my_upload->upload($vsol1)) { 
	 //    echo '';		
    //  } 
    //else {
    //  mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); exit(); }
    //}

  } //Incluir
}

//Pase de variables y Etiquetas al template
$smarty->assign('vopc',$vopc);

$smarty->display('m_ingwebfig.tpl');
$smarty->display('pie_pag.tpl');
?>
