<script language="javascript">
 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }
</script>

<?php
// *************************************************************************************
// Programa: z_modepto.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado I Semestre 2009 BDR. 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$fecha    = fechahoy();
$sql      = new mod_db();
$tbname_1 = "stzdepto";
$modulo   = "z_modepto.php";

$smarty->assign('titulo',$substcon);
$smarty->assign('subtitulo','Mantenimiento de Unidades / Modificaci&oacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$vopc     = $_GET['vopc'];
$conx     = $_GET['conx'];
$id_depto = $_GET['valor'];
$nconex   = $_GET['n_conex'];
$iddepto  = $_POST['iddepto'];
$nombre   = $_POST['nombre'];

$salir    = $_POST['salir'];
$na_conex = $_POST['na_conex'];

if ($conx==0) { 
  $smarty->assign('n_conex',$nconex); 
  $smarty->assign('na_conex',$na_conex); }
else {
  if ($conx==1) {
    $salir=1;
    $res_conex = insconex($usuario,$modulo,'M');
    $smarty->assign('n_conex',$res_conex);
    $na_conex = $nconex; 
    $smarty->assign('na_conex',$na_conex); }
}    

if (($salir==0) && ($nconex>0)) {
  $salirphp = salirconx($nconex);
  $smarty->assign('n_conex',$na_conex); 
}

// Verificando conexion
$sql->connection();

if ($vopc==1) {
  //Obtencion del Nombre de la Ubicacion
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE cod_depto='$id_depto'");
  if (!$obj_query) { 
    $smarty->display('encabezado.tpl');
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found = 0) {
    $smarty->display('encabezado.tpl');
    mensajenew("Codigo de la Unidad NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 
  $objs = $sql->objects('',$obj_query);
  $nombre=trim($objs->nombre);
  $conx = 0; 
  $smarty->assign('modo2','');
  $smarty->assign('conx',$conx);
}

if ($vopc==2) {
  $conx     = $_POST['conx'];
  $salir    = $_POST['salir'];
  $nconex   = $_POST['nconex'];
  $na_conex = $_POST['na_conex'];

  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("nombre");
  $valores = array($nombre);
  $vacios = check_empty_fields();
  if (!$vacios) { 
    mensajenew("Hay Informacion requerida en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

  // La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();

  // Comienzo de Transaccion 
  pg_exec("BEGIN WORK");
 
  //Actualizo Datos en la tabla de Unidades
  $update_str = "nombre='$nombre'";
  $act_unid = $sql->update("$tbname_1","$update_str","cod_depto='$iddepto'");

  // Verificacion y actualizacion real de los Datos en BD 
  if ($act_unid) {
    pg_exec("COMMIT WORK"); 
    
    //Desconexion de la Base de Datos
    $sql->disconnect();
    
    Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","../comun/z_unidad.php?conx=1&nconex=$nconex&na_conex=$na_conex&salir=0","S");
    $smarty->display('pie_pag.tpl'); exit(); }

  else {
    pg_exec("ROLLBACK WORK");

    //Desconexion de la Base de Datos
    $sql->disconnect();

    if (!$act_unid)  { $error_unid  = " - Unidades "; } 
    Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD $error_unid ...!!!","z_unidad.php","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }
  $smarty->assign('n_conex',$nconex); 

}

$smarty->assign('iddepto',$id_depto);
$smarty->assign('campo2','Nombre:');
$smarty->assign('nombre',$nombre);
$smarty->assign('varfocus','fordepto.nombre');

$smarty->display('z_modepto.tpl');
$smarty->display('pie_pag.tpl');
?>
