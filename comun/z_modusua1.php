<?php
// *************************************************************************************
// Programa: z_modusua1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include ("$include_lib/m_mail.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login    = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$fecha    = fechahoy();
$sql      = new mod_db();
$tbname_1 = "stzusuar";
$tbname_2 = "stzdepto";
$tbname_3 = "stzbitac";
$modulo   = "z_modusua1.php";

$vopc     = $_GET['vopc'];
$conx     = $_GET['conx'];
$id       = $_GET['valor'];
$nconex   = $_GET['n_conex'];
$salir    = $_POST['salir'];
$na_conex = $_POST['na_conex'];
$idvalor  = $_POST['idvalor'];
$cedula   = $_POST['cedula'];
$nombre   = $_POST['nombre'];
$email    = trim($_POST['email']);
$usuario  = $_POST['usuario'];
$depto_id = $_POST['depto_id'];
$estado   = $_POST['estado'];
$sede     = $_POST['sede'];
$vstring  = $_POST['vstring'];

$smarty->assign('titulo',$substacc);
$smarty->assign('subtitulo','Mantenimiento de Usuarios / Modificaci&oacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('modo1','');
$smarty->assign('modo2','readonly');
$smarty->assign('est_ids',array(1,2));
$smarty->assign('est_def',array('Activo','Inactivo'));

//Verificando conexion
$sql->connection();

if ($vopc==1) {
  $smarty->assign('modo1','readonly');

  //Verificación de la Cedula
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE id='$id'");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_i ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found == 0) {
    mensajenew("Cedula del Usuario NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $objs      = $sql->objects('',$obj_query);
  $cedula    = trim($objs->cedula);
  $nombre    = trim($objs->nombre);
  $email     = trim($objs->email);
  $usuario   = trim($objs->usuario);
  $fecha_ing = $objs->fecha_ing;
  $hora_ing  = $objs->hora_ing;
  $estado    = $objs->estatus;
  $depto_id  = $objs->cod_depto;
  $nivel     = $objs->nivel;
  $sede      = trim($objs->sede);  
  
  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($cedula,$nombre,$email,$usuario,$passwd,$depto_id,$estado);
  $vstring = bitacora_fields();
  $smarty->assign('vstring',$vstring);
  
  //Obtención de los Departamentos 
  $obj_query = $sql->query("SELECT * FROM $tbname_2 order by nombre");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew("Tabla de Departamentos Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $cont = 0;
  $arraydepto[$cont]=0;
  $arraynombre[$cont]='';
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arraydepto[$cont]=$objs->cod_depto;
    $arraynombre[$cont]=trim($objs->nombre);
    $objs = $sql->objects('',$obj_query);
  }

  // Obtencion de las Sedes 
  $contobji=0;
  $vcodsede[$contobji] = '';
  $vnomsede[$contobji] = '';
  $objquery = $sql->query("SELECT * FROM stzsede WHERE sede <> '3' ORDER BY sede");
  $objfilas = $sql->nums('',$objquery);
  $objs = $sql->objects('',$objquery);
  for ($contobji=1;$contobji<=$objfilas;$contobji++) {
    $vcodsede[$contobji] = $objs->sede;
    $vnomsede[$contobji] = trim(sprintf("%02d",$objs->sede)." ".trim($objs->nombre));
    $objs = $sql->objects('',$objquery); }	  
  
  //Desconexion de la Base de Datos
  $sql->disconnect();
  $smarty->assign('modo2','');
}

if ($vopc==2) {
  $conx     = $_POST['conx'];
  $salir    = $_POST['salir'];
  $nconex   = $_POST['nconex'];
  $na_conex = $_POST['na_conex'];

  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("cedula","nombre","email","usuario"); 
  $valores = array($cedula,$nombre,$email,$usuario);
  $vacios = check_empty_fields();
  if (!$vacios) { 
    mensajenew("ERROR: Hay Informacion requerida en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

  if (($sede==0) || (empty($sede))) {
    mensajenew("ERROR: Debe seleccionar a que sede pertenece el Funcionario para actualizar ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  
  //Verificacion del email
  $valemail = 0;
  $valemail = check_email($email);
  if ($valemail==2) { 
    mensajenew("ERROR: La direccion e-mail no es valido  ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificación de la Cuenta del Usuario
  $ExisUser=Ex_user($cuenta);
  if ($ExisUser != 0) {
    mensajenew("ERROR: Cuenta del Usuario YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 

  //Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
  $sys_actual = next_sys("nbitaco");
  $vsecuencial = grabar_sys("nbitaco",$sys_actual);

  $fechahoy = hoy();
  $horactual= Hora();

  // Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  //Inserto Datos en la tabla de Bitacora
  if ($estado==1) {
    $insert_str = "'$vsecuencial','$fechahoy','$horactual','$login','$tbname_1','C','M','$cedula','$vstring'"; }
  else {
    $insert_str = "'$vsecuencial','$fechahoy','$horactual','$login','$tbname_1','C','E','$cedula','$vstring'";
  }
  //$ins_bita = $sql->insert("$tbname_3","","$insert_str","");

  //Actualizo Datos en la tabla de Usuario
  $clave = md5($passwd);
  $update_str = "cedula='$cedula',nombre='$nombre',usuario='$usuario',estatus='$estado',cod_depto='$depto_id',email='$email',sede='$sede'";
  $act_user = $sql->update("$tbname_1","$update_str","id='$idvalor'");

  // Verificacion y actualizacion real de los Datos en BD 
  if ($act_user) {
    pg_exec("COMMIT WORK"); 
    
    //Desconexion de la Base de Datos
    $sql->disconnect();
    
    Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","../comun/z_usuarios.php?conx=1&nconex=$nconex&na_conex=$na_conex&salir=0","S");
    $smarty->display('pie_pag.tpl'); exit(); }

  else {
    pg_exec("ROLLBACK WORK");

    //Desconexion de la Base de Datos
    $sql->disconnect();

    if (!$act_user)  { $error_user  = " - Usuarios "; } 
    Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD $error_user ...!!!","z_usuarios.php","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }
  //$smarty->assign('n_conex',$nconex); 

}

$smarty->assign('campo1','Nro. Cedula');
$smarty->assign('campo2','Nombre completo:');
$smarty->assign('campo3','E-Mail:');
$smarty->assign('campo4','Cuenta:');
$smarty->assign('campo5','Password:');
$smarty->assign('campo6','Confirmar Password:');
$smarty->assign('campo7','Ubicacion:');
$smarty->assign('campo8','Estatus:');
$smarty->assign('campo9','Sede:');
$smarty->assign('varfocus','forusing.cedula'); 
$smarty->assign('arraydepto',$arraydepto);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('cedula',$cedula);
$smarty->assign('nombre',$nombre);
$smarty->assign('email',$email);
$smarty->assign('usuario',$usuario);
$smarty->assign('depto_id',$depto_id);
$smarty->assign('estado',$estado);
$smarty->assign('idvalor',$id);
$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 
$smarty->assign('sede',$sede);

$smarty->display('z_modusua1.tpl');
$smarty->display('pie_pag.tpl');
?>
