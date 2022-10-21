<?php
ob_start();
// *************************************************************************************
// Programa: z_gbobj.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables
$fecha    = fechahoy();
$sql      = new mod_db();
$tbname_1 = "stzmenu";

//Validacion de Entrada
$codigo=trim($_POST["codigo"]);
$nombre=trim($_POST["nombre"]);
$nivel=$_POST["nivel"];
$nomencla=trim($_POST["nomencla"]);
$usuario=$_POST["usuario"];

$smarty->assign('titulo','Modulo de Acceso');
$smarty->assign('subtitulo','Mantenimiento de Opciones del Menu / Ingreso');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificacion de que los campos requeridos esten llenos...
$req_fields = array("codigo","nombre","nivel","nomencla");
$valores = array($codigo,$nombre,$nivel,$nomencla);
$vacios = check_empty_fields();
if (!$vacios) { 
    mensajenew("Hay Informacion en el formulario requerida que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

switch ($nivel) {
     case 1:
         $nombre = " ".$nombre;
         break;
     case 2:
         $nombre = "  ".$nombre;
         break;
     case 3:
         $nombre = "   ".$nombre;
         break;
 }


//Verificación del Codigo
$obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE codmenu='$codigo'");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_i ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found > 0) 
  {
    mensajenew("Nombre de Opcion u Objeto YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 

//Inserto Datos en la tabla de Roles
$campos_col = "codmenu,nombre,nivel,nomenclatura,estado";
$insert_str = "'$codigo','$nombre','$nivel','$nomencla','A'";
$sql->insert("$tbname_1","","$insert_str","");

//Desconexion de la Base de Datos
$sql->disconnect();

mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','z_ingobj.php','S');
$smarty->display('pie_pag.tpl');
?>
