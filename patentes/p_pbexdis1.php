<?php 
// *************************************************************************************
// Programa: m_pbexfig1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

//Conexion
$sql = new mod_db();
$sql->connection($usuario); 

//Variables
$tbname_1 = "stmcntrl";
$tbname_2 = "stmviena";
$tbname_3 = "stmccvma";
$tbname_4 = "stmaudef";
$tbname_5 = "stmtmpccv";
$tbname_6 = "stzderec";
$tbname_7 = "stmmarce";
$tbname_8 = "stmclbus";
$ntabla1  = "figuraext";
$ntabla2  = "stmpvie99";

$fecha    = fechahoy();

$vopc=$_GET["vopc"];
$v1 = $_POST['v1'];
$vsol1=$_POST['v1'];
$recibo=$_POST['recibo'];
$fecharec=$_POST['fecharec'];
$prioridad=$_POST['prioridad'];
$solicitant=$_POST['solicitant'];
$nameimage=$_POST['nameimage'];
$accion=$_POST['accion'];
$vaclas=$_POST['clase'];
//echo " clase= $vaclas ";
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','B&uacute;squeda Externa Elemento Figurativo');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('arraytipom',array(N,L));
$smarty->assign('arraynotip',array('NORMAL','LINEA'));

if ($vopc==0) {
 //Validación de Clase Internacional de Niza
 if (empty($vaclas)) {
   mensajenew('Clase Internacional de Niza Vacia ...!!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 

 $fechahoy=Hoy();
 $horahoy= Hora();

//Creacion de Tablas Temporales
//pg_exec("CREATE TABLE $ntabla1 ( solicitud CHAR(11) )");
//pg_exec("CREATE TEMPORARY TABLE $ntabla1 (solicitud char(11)); CREATE INDEX figuraext_sol ON figuraext USING btree (solicitud)");
pg_exec("CREATE TEMPORARY TABLE $ntabla1 (fecha date,hora character(11),usuario character(12), control character(11),solicitud char(11),clase int2,ind_claseni char(1))");

//$numero2=rand(1,9999);
//$ntabla2="tmpres2".$numero2;
//pg_exec("CREATE TABLE $ntabla2 (solicitud char(11), clase int2, ind_claseni char(1) )");

$insert_tmp = "'$fechahoy','$horahoy','$usuario','$ntabla2','E'";
$sql->insert("stmtmpef","","$insert_tmp","");

  $universo = 0;
  //Cantidad de Marcas en la Clase Nacional asociada   
  //$obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE clase_inter='$vaclas'");
  //$obj_filas = $sql->nums('',$obj_query);
  //$objs = $sql->objects('',$obj_query);
  //if ($obj_filas==0) {
  // Mensajenew('No existen Solicitudes que cumplan con los parametros ...!!!','javascript:history.back();','N');
  // $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  //for($i=0;$i<$obj_filas;$i++) {
  //  $indcl = "I"; 
  //  $vcl = $objs->clase_asoc;
  //  if ($vcl>50) { $indcl = "N"; $vcl = $vcl-50; } 
  //  $obj_clase = $sql->query("SELECT count(*) FROM $tbname_7 WHERE clase='$vcl' AND ind_claseni='$indcl' AND modalidad IN ('M','G')");
  //  $obj_filcl = $sql->nums('',$obj_clase);
  //  $objcl = $sql->objects('',$obj_clase);
  //  $universo = $universo + $objcl->count;  
  //  $objs = $sql->objects('',$obj_query);
 // }

  // Tabla temporal de Clasificaciones de Viena asignados 
  $obj_query = $sql->query("SELECT * FROM $tbname_5 WHERE solicitud='$v1'");
  $obj_filas = $sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  if ($obj_filas==0) {
   Mensajenew('Clasificacion Internacional de Viena Vacia(s) ...!!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  for($i=0;$i<$obj_filas;$i++) { 
    $varsolc = $objs->ccv;
    //$resultado=pg_exec("INSERT INTO $ntabla1 SELECT stzderec.solicitud FROM stmccvma,stzderec 
    //                    WHERE stzderec.nro_derecho = stmccvma.nro_derecho 
    //                    AND stzderec.tipo_mp = 'M' AND stmccvma.ccv='$varsolc'");

    $resultado=pg_exec("INSERT INTO $ntabla1 SELECT '$fechahoy','$horahoy','$usuario','$v1',solicitud,clase,ind_claseni
                                              FROM stmmarce,stzderec,stmccvma
                                              WHERE stmccvma.ccv='$varsolc' 
                                              AND stmccvma.nro_derecho=stzderec.nro_derecho 
                                              AND stmmarce.nro_derecho=stzderec.nro_derecho 
                                              AND stzderec.tipo_mp='M'");   

    $objs = $sql->objects('',$obj_query); 
  }
   //echo "hoy es $fechahoy ";
   //$respuesta=pg_exec("SELECT DISTINCT tmpresef.solicitud FROM tmpresef");   
   pg_exec("DELETE FROM $ntabla2 WHERE control = '$v1'");
   pg_exec("DELETE FROM $ntabla2 WHERE fecha < '$fechahoy'");
   pg_exec("CREATE INDEX figuraext_sol ON figuraext USING btree (solicitud)");
   //$respuesta=pg_exec("SELECT DISTINCT $ntabla1.solicitud FROM $ntabla1");   
   $respuesta=pg_exec("SELECT DISTINCT ON($ntabla1.solicitud) solicitud,clase,ind_claseni FROM $ntabla1");   
   $filas_found=pg_numrows($respuesta);
   $fila=1;
   while ( $fila <= $filas_found )
   {
     $regis = pg_fetch_array($respuesta);
     $vs1=trim($regis['solicitud']);
     ////$resinsert=pg_exec("INSERT INTO $ntabla2 SELECT solicitud,clase,ind_claseni
     ////                                         FROM stmmarce,stzderec 
     ////                                         WHERE stzderec.solicitud='$vs1'
     ////                                         AND stmmarce.nro_derecho=stzderec.nro_derecho 
     ////                                         AND stzderec.tipo_mp='M'");   
     //$obj_query = $sql->query("SELECT solicitud,clase,ind_claseni FROM stmmarce,stzderec 
     //                          WHERE stzderec.solicitud='$vs1'
     //                          AND stmmarce.nro_derecho=stzderec.nro_derecho 
     //                          AND stzderec.tipo_mp='M'");
     //$objs = $sql->objects('',$obj_query);
     //$vclase = $objs->clase;
     //$vindcl = $objs->ind_claseni;
     //$insert_str = "'$fechahoy','$horahoy','$usuario','$v1','$vs1',$vclase,'$vindcl'";
     //$reg_inser = $sql->insert("$ntabla2","","$insert_str","");
     $vclase = $regis['clase'];
     $vindcl = $regis['ind_claseni'];
     $insert_str = "'$fechahoy','$horahoy','$usuario','$v1','$vs1',$vclase,'$vindcl'";
     $reg_inser = $sql->insert("$ntabla2","","$insert_str","");
     //echo " $vs1 ";
     $fila++;
   }

   //Filtro por Clasificación Internacional de Niza
   $filtro2=pg_exec("SELECT solicitud,clase,ind_claseni FROM $ntabla2 WHERE control='$v1' ORDER BY $ntabla2.solicitud");   
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
     $match=pg_exec("SELECT clase_asoc FROM stmclbus WHERE clase_inter='$vaclas' and clase_asoc='$vclabus'");
     $nfilas=pg_numrows($match);
     if ($nfilas==0) {
       pg_exec("DELETE FROM $ntabla2 WHERE solicitud = '$vsoli' AND control='$v1'");
     }
     $fila++;
   }

$droptable=pg_exec("drop table $ntabla1");

$obj_query = $sql->query("SELECT * FROM $ntabla2 WHERE control='$v1'");
if (!$obj_query) { 
  mensajenew('Problema al intentar realizar la consulta en la tabla $ntabla2 ...!!!','m_pbexfigu.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);

//Cantidad de Solicitudes de Marcas con el Codigo de Viena asociado 
$universo = $filas_found;
//if ($universo==0) {
//  mensajenew('ERROR: NO Existen Datos asociados al Codigo de Viena y a la Clasificacion de Niza ...!!!','m_pbexfigu.php?vopc=5','N');
//  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $smarty->assign('universo',$universo);
}

//Asignación de variables para pasarlas a Smarty
$camposquery = "solicitud,clase,ind_claseni";
$camposname= "solicitud,clase,ind_claseni,imagen";
$tablas    = $ntabla2;
//$condicion = "";
$condicion = "control=v1"; 
$orden     = "1";
$modo      = "Imprimir";
$modoabr   = "Sel.";
$vurl      = "m_pbexfigu.php?vopc=5";
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

$smarty->assign('accion',1); 
$smarty->assign('modo1','disabled'); 
$smarty->assign('modo2','readonly=readonly'); 
$smarty->assign('modo3',''); 
$smarty->assign('submitbutton3','submit');
$smarty->assign('submitbutton','button');

$smarty->assign('campo1','Pedido No.:');
$smarty->assign('campo2','Fecha busqueda:');
$smarty->assign('campo3','Tipo de busqueda:');
$smarty->assign('campo4','Recibo Numero:');
$smarty->assign('campo5','Solicitante:');
$smarty->assign('campo6','en Clase:');
$smarty->assign('campo7','Logotipo:');
$smarty->assign('campo8','Cod. Viena:');
$smarty->assign('lcviena','C&oacute;digos de Viena '); 

$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('vsol1',$v1);
$smarty->assign('recibo',$recibo);
$smarty->assign('fecharec',$fecharec);
$smarty->assign('prioridad',$prioridad);
$smarty->assign('solicitant',$solicitant);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('clase',$vaclas);
$smarty->assign('subtotal',$filas_found);
$smarty->assign('universo',$universo);

$smarty ->display('m_pbexfig1.tpl'); 
$smarty->display('pie_pag.tpl');   
?>
