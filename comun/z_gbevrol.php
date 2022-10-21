<?php
ob_start();
// *************************************************************************************
// Programa: z_gbevrol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables
$fecha     = fechahoy();
$sql       = new mod_db();
$tbname_i  = "stzroleve";
$fechahoy  = hoy();
$mselecion = 0;
$pselecion = 0;

//Validacion de Entrada
$rol_id   = $_POST["rol_id"];
$totalevm = $_POST["totalevm"];
$totalevp = $_POST["totalevp"];
$totaleva = $_POST["totaleva"];
$totalevi = $_POST["totalevi"];
$idm_even = $_POST["idm_even"];
$idp_even = $_POST["idp_even"];
$ida_even = $_POST["ida_even"];
$idi_even = $_POST["idi_even"];
$usuario  = $_POST["usuario"];
$nconex   = $_POST['nconex'];
$na_conex = $_POST['na_conex'];

//$smarty->assign('titulo','Modulo de Acceso');
$smarty->assign('subtitulo','Administraci&oacute;n de Eventos por Rol');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Cuento cuantos eventos fueron seleccionados de Marcas como Patentes
$mselecion= count($idm_even);
$pselecion= count($idp_even);
$aselecion= count($ida_even);
$iselecion= count($idi_even);

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
$seli=0;
for ($cont=0;$cont<$iselecion;$cont++)
 { 
   $val_evei= $idi_even[$cont];
   if (!empty($val_evei)) { $seli=1; }
 }

//Se verifica que hayan elementos seleccionados
if (($rol_id=="0") || ($selm==0 && $selp==0 && $sela==0 && $seli==0))
 {
   mensajenew("Hay Informacion en el formulario requerida que esta Vacia ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit(); 
 }
 
//Nos Conectamos a la base de datos
$sql->connection();

// Comienzo de Transaccion 
pg_exec("BEGIN WORK");
$horahoy = hora();

//Inserto Datos en la tabla de Eventos asociados al Rol

// Eventos de Marcas
$ins_mevrol==0; 
if ($selm!=0)
 {
  for ($cont=0;$cont<$mselecion;$cont++)
  { 
    $exeverol = 0;
    $val_evem= $idm_even[$cont];
    $exeverol= Exroleve($rol_id,$val_evem,'M');
    if ($exeverol==0)
     {
       $columna_str = "role,evento,tip_derecho,fecha_asig,estado,hora_asig";
       $insert_str = "'$rol_id','$val_evem','M','$fechahoy','A','$horahoy'";
       $resultado = $sql->insert("$tbname_i","$columna_str","$insert_str","");
       if (!$resultado) { $ins_mevrol = $ins_mevrol + 1; }
     }  
  }  
 }

// Eventos de Patentes
$ins_pevrol==0;
if ($selp!=0)
 {
  for ($cont=0;$cont<$pselecion;$cont++)
  { 
    $exeverol = 0;
    $val_evep= $idp_even[$cont];
    $exeverol= Exroleve($rol_id,$val_evep,'P');
    if ($exeverol==0)
     {
       $columna_str = "role,evento,tip_derecho,fecha_asig,estado,hora_asig";
       $insert_str = "'$rol_id','$val_evep','P','$fechahoy','A','$horahoy'";
       $resultado = $sql->insert("$tbname_i","$columna_str","$insert_str","");
       if (!$resultado) { $ins_pevrol = $ins_pevrol + 1; }
     }  
  }
 }

// Eventos de Derecho de Autor 
$ins_aevrol==0;
if ($sela!=0)
 {
  for ($cont=0;$cont<$aselecion;$cont++)
  { 
    $exeverol = 0;
    $val_evea= $ida_even[$cont];
    $exeverol= Exroleve($rol_id,$val_evea,'A');
    if ($exeverol==0)
     {
       $columna_str = "role,evento,tip_derecho,fecha_asig,estado,hora_asig";
       $insert_str = "'$rol_id','$val_evea','A','$fechahoy','A','$horahoy'";
       $resultado = $sql->insert("$tbname_i","$columna_str","$insert_str","");
       if (!$resultado) { $ins_aevrol = $ins_aevrol + 1; }
     }  
  }  
 }

// Eventos de IG
$ins_ievrol==0; 
if ($seli!=0)
 {
  for ($cont=0;$cont<$iselecion;$cont++)
  { 
    $exeverol = 0;
    $val_evei= $idi_even[$cont];
    $exeverol= Exroleve($rol_id,$val_evei,'I');
    if ($exeverol==0)
     {
       $columna_str = "role,evento,tip_derecho,fecha_asig,estado,hora_asig";
       $insert_str = "'$rol_id','$val_evei','I','$fechahoy','A','$horahoy'";
       $resultado = $sql->insert("$tbname_i","$columna_str","$insert_str","");
       if (!$resultado) { $ins_ievrol = $ins_ievrol + 1; }
     }  
  }  
 }

// Verificacion y actualizacion real de los Datos en BD 
if (($ins_mevrol==0) and ($ins_pevrol==0) and ($ins_aevrol==0) and ($ins_ievrol==0)) {
  pg_exec("COMMIT WORK"); 
  //Desconexion de la Base de Datos
  $sql->disconnect();

  Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","../comun/z_ingevrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=1","S");
  $smarty->display('pie_pag.tpl'); exit(); }

else {
  pg_exec("ROLLBACK WORK");
  //Desconexion de la Base de Datos
  $sql->disconnect();

  Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD ...!!!","z_evenrol.php","N");
  $smarty->display('pie_pag.tpl'); exit(); 
}

?>
