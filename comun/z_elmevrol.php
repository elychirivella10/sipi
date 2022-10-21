<?php
// ************************************************************************************* 
// Programa: z_elmevrol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Modificado el Año: 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login     = $_SESSION['usuario_login'];
$fecha     = fechahoy();
$tbname_1  = "stzroles";
$tbname_2  = "stzroleve";
$tbname_3  = "stzevder";
$tbname_4  = "stdevobr";
$sql       = new mod_db();
$modulo    = "z_elmevrol.php";
$mselecion = 0;
$pselecion = 0;
$aselecion = 0;

$vopc     = $_GET['vopc'];
$conx     = $_GET['conx'];
$rol_id   = $_GET['valor'];
$nconex   = $_GET['n_conex'];
$salir    = $_POST['salir'];
$na_conex = $_POST['na_conex'];
$totalevm = $_POST["totalevm"];
$totalevp = $_POST["totalevp"];
$totaleva = $_POST["totaleva"];
$idm_even = $_POST["idm_even"];
$idp_even = $_POST["idp_even"];
$ida_even = $_POST["ida_even"];

if ($vopc==2) { $nconex   = $_POST['nconex']; }

if ($conx==0) { 
  $smarty->assign('n_conex',$nconex); 
  $smarty->assign('na_conex',$na_conex); }
else {
  if ($conx==1) {
    $salir=1;
    $res_conex = insconex($login,$modulo,'E');
    $smarty->assign('n_conex',$res_conex);
    $na_conex = $nconex; 
    $smarty->assign('na_conex',$na_conex); }
}    

if (($salir==0) && ($nconex>0)) {
  $salirphp = salirconx($nconex);
  $smarty->assign('n_conex',$na_conex); 
}

$smarty->assign('titulo','M&oacute;dulo de Configuraci&oacute;n');
$smarty->assign('subtitulo','Administraci&oacute;n de Eventos en Rol');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('modo1','');
$smarty->assign('modo2','readonly');

//Obtención de los Roles
$obj_query = $sql->query("SELECT * FROM $tbname_1 order by nombre");
if (!$obj_query) { 
    Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
    Mensajenew("Tabla de Roles Vacia ...!!!","../comun/z_evenrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=1","N");    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$cont = 0;
$arrayrole[$cont]=0;
$arraynombre[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arrayrole[$cont]=$objs->role;
    $arraynombre[$cont]=trim($objs->nombre)." - ".$objs->role;
    $objs = $sql->objects('',$obj_query);
  }

if ($vopc==1) {
  $smarty->assign('modo1','readonly');
  $smarty->assign('modo2','');
  $smarty->assign('campo2','Eventos de Marca');
  $smarty->assign('campo3','Eventos de Patentes');
  $smarty->assign('campo4','Eventos de Derecho de Autor');

  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("rol_id");
  $valores = array($rol_id);
  $vacios = check_empty_fields();
  if (!$vacios) { 
    Mensajenew("Hay Informacion en el formulario Vacia ...!!!","javascript:history.back();","N");    
    $smarty->display('pie_pag.tpl'); exit(); }
  
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE role='$rol_id'");
  if (!$obj_query) { 
    Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    Mensajenew("Tabla de Roles Vacia ...!!!","../comun/z_evenrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=1","N");    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $nbrol=trim($objs->nombre);

  //Obtención de los Eventos de Marcas asignados el Rol
  $totalevm=0;
  $obj_query = $sql->query("SELECT stzevder.evento,descripcion FROM $tbname_2,$tbname_3 WHERE role='$rol_id' AND stzevder.evento=stzroleve.evento AND estado='A' AND stzevder.tipo_mp='M' AND stzroleve.tip_derecho='M' ORDER BY stzroleve.evento");
  if (!$obj_query) { 
      Mensajenew("Problema al intentar realizar la consulta en las tablas $tbname_2 y $tbname_3 ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $totalevm=$filas_found;
  //if ($filas_found==0) {
  //    Mensajenew("Tabla de Eventos de Marcas o Eventos por Roles Vacia ...!!!","../comun/z_elmevrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=1","N");
  //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $cont = 0;
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
      $marrayevento[$cont]=$objs->evento;
      $marraydescev[$cont]=$objs->evento." - ".trim($objs->descripcion);
      $objs = $sql->objects('',$obj_query);
  }

  $totalevp==0;
  $obj_query = $sql->query("SELECT stzevder.evento,descripcion FROM $tbname_2,$tbname_3 WHERE role='$rol_id' AND stzevder.evento=stzroleve.evento AND estado='A' AND stzevder.tipo_mp='P' AND stzroleve.tip_derecho='P' ORDER BY stzroleve.evento");
  if (!$obj_query) { 
      Mensajenew("Problema al intentar realizar la consulta en las tablas $tbname_2 y $tbname_3 ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $totalevp=$filas_found;
  $cont = 0;
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
      $parrayevento[$cont]=$objs->evento;
      $parraydescev[$cont]=$objs->evento." - ".trim($objs->descripcion);
      $objs = $sql->objects('',$obj_query);
  }
   
  $totaleva==0;
  $obj_query = $sql->query("SELECT stdevobr.evento,descripcion FROM $tbname_2,$tbname_4 WHERE role='$rol_id' AND stdevobr.evento=stzroleve.evento AND estado='A' AND stzroleve.tip_derecho='A' ORDER BY stzroleve.evento");
  if (!$obj_query) { 
      Mensajenew("Problema al intentar realizar la consulta en las tablas $tbname_2 y $tbname_4 ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $totaleva=$filas_found;
  $cont = 0;
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
      $aarrayevento[$cont]=$objs->evento;
      $aarraydescev[$cont]=$objs->evento." - ".trim($objs->descripcion);
      $objs = $sql->objects('',$obj_query);
  }

  if ($totalevm==0 && $totalevp==0 && $totaleva==0) { 
    Mensajenew("El Rol $rol_id NO posee eventos asociados ...!!!","../comun/z_evenrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=0","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}

if ($vopc==2) {
  $rol_id   = $_POST['rol_id'];
  $nconex   = $_POST['nconex'];
  $na_conex = $_POST['na_conex'];
  
  $fechahoy = hoy();
  //Cuento cuantos eventos fueron seleccionados de Marcas como Patentes y Autor 
  $mselecion = count($idm_even);
  $pselecion = count($idp_even);
  $aselecion = count($ida_even);
  
  //Se verifican si los arreglos traen valores
  $selm=0;
  for ($cont=0;$cont<$mselecion;$cont++)
  { 
     $val_evem= $idm_even[$cont];
     if (!empty($val_evem)) { $selm=1; }
  }
  $selp=0;
  for ($cont=0;$cont<$pselecion;$cont++)
  { 
     $val_evep= $idp_even[$cont];
     if (!empty($val_evep)) { $selp=1; }
  }
  $sela=0;
  for ($cont=0;$cont<$aselecion;$cont++)
  { 
     $val_evea= $ida_even[$cont];
     if (!empty($val_evea)) { $sela=1; }
  }

  //Se verifica que hayan elementos seleccionados
  if (($rol_id=="0") || ($selm==0 && $selp==0 && $sela==0)) {
    Mensajenew("Hay Informacion en el formulario Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  // Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $hora = hora();
  // Eliminacion de Eventos de Marcas asociados al Rol seleccionado
  $elm_evm = 0;
  if ($selm!=0) {
    for ($cont=0;$cont<$mselecion;$cont++) { 
      $val_evem= $idm_even[$cont];
      $update_str = "estado='E',fecha_elim='$fechahoy',hora_elim='$hora'";
      $del_evmrol = $sql->update("$tbname_2","$update_str","role='$rol_id' and evento='$val_evem' and estado='A' and tip_derecho='M'");
      if (!$del_evmrol) { $elm_evm = $elm_evm + 1; }  
    }  
  }

  // Eliminacion de Eventos de Patentes asociados al Rol seleccionado
  $elm_evp = 0;
  if ($selp!=0) {
    for ($cont=0;$cont<$pselecion;$cont++) { 
      $val_evep= $idp_even[$cont];
      $update_str = "estado='E',fecha_elim='$fechahoy',hora_elim='$hora'";
      $del_evprol = $sql->update("$tbname_2","$update_str","role='$rol_id' and evento='$val_evep' and estado='A' and tip_derecho='P'");
        if (!$del_evprol) { $elm_evp = $elm_evp + 1; }  
    }  
  }

  // Eliminacion de Eventos de Derecho de Autor asociados al Rol seleccionado
  $elm_eva = 0;
  if ($sela!=0) {
   for ($cont=0;$cont<$aselecion;$cont++) { 
      $val_evea= $ida_even[$cont];
      $update_str = "estado='E',fecha_elim='$fechahoy',hora_elim='$hora'";
      $del_evarol = $sql->update("$tbname_2","$update_str","role='$rol_id' and evento='$val_evea' and estado='A' and tip_derecho='A'");
        if (!$del_evarol) { $elm_eva = $elm_eva + 1; }  
    }  
  }

  // Verificacion y actualizacion real de los Datos en BD 
  if (($elm_evm==0) and ($elm_evp==0) and ($elm_eva==0)) {
    pg_exec("COMMIT WORK"); 
    
    //Desconexion de la Base de Datos
    $sql->disconnect();
    Mensajenew("DATOS ELIMINADOS CORRECTAMENTE...!","../comun/z_evenrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=0","S");
    $smarty->display('pie_pag.tpl'); exit(); }

  else {
    pg_exec("ROLLBACK WORK");

    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD ...!!!","../comun/z_evenrol.php","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

}

$smarty->assign('modo','disabled'); 
$smarty->assign('vmodo','readonly=readonly'); 
$smarty->assign('arrayrole',$arrayrole);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('rol_id',$rol_id);
$smarty->assign('nbrol',$nbrol);
$smarty->assign('marrayevento',$marrayevento);
$smarty->assign('marraydescev',$marraydescev);
$smarty->assign('evento_m',0);
$smarty->assign('parrayevento',$parrayevento);
$smarty->assign('parraydescev',$parraydescev);
$smarty->assign('evento_p',0);
$smarty->assign('aarrayevento',$aarrayevento);
$smarty->assign('aarraydescev',$aarraydescev);
$smarty->assign('evento_a',0);
$smarty->assign('totalevm',$totalevm);
$smarty->assign('totalevp',$totalevp);
$smarty->assign('totaleva',$totaleva);
$smarty->assign('na_conex',$na_conex);
$smarty->assign('campo1','Rol: ');
$smarty->assign('varfocus','forrole.rol_id'); 

$smarty->display('z_elmevrol.tpl');
$smarty->display('pie_pag.tpl');
?>
