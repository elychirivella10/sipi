<?
//Para trabajar con Operaciones de Bases de Datos
include ("setting.inc.php");
//Para trabajar con Smarty 
require ("$root_path/include.php");
//Para trabajar con sessiones
require("$root_path/aut_verifica.inc.php");
//LLamadas a funciones de Libreria 
include ("/var/www/apl/librerias/library.php");

//require('aut_verifica.inc.php');
//require('include.php');

$smarty->assign('titulop','');
$smarty->assign('titulo','');

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$login= $_SESSION['usuario_login'];

$nconex = $_GET['nconex'];
if (empty($nconex)) { $nconex=0; }

//Verificando conexion
$tbname_1 = "stzconex";
$sql      = new mod_db();
$sql->connection();

// La Hora para la transaccion
$horactual= date("h:i:s A");

// Comienzo de Transaccion 
pg_exec("BEGIN WORK");

//Actualizo Datos en la tabla
$update_str = "hora_salida='$horactual'";
$act_conex = $sql->update("$tbname_1","$update_str","conex='$nconex'");

// Verificacion y actualizacion real de los Datos en BD 
if ($act_conex) {
  pg_exec("COMMIT WORK"); 
  //Desconexion de la Base de Datos
  //$sql->disconnect();
}    
else {
  pg_exec("ROLLBACK WORK");
  //Desconexion de la Base de Datos
  //$sql->disconnect();
}

$smarty->display('encabezado_menu.tpl');

//Conexion a la Base de Datos  
//$sql->connection();   

//Variables 
$tbname_1 = "stzusuar";
$tbname_2 = "stzturnos";

// Obtencion de la Sede y Turno del Usuario  
$obj_query = $sql->query("SELECT sede,turno FROM $tbname_1 WHERE usuario='$login'");
if (!$obj_query) { 
  Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  Mensajenew("ERROR:NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$objs = $sql->objects('',$obj_query);
$vsede = $objs->sede;
$vturno = $objs->turno;

$obj_query = $sql->query("SELECT hora_ini,hora_fin FROM $tbname_2 WHERE turno='$vturno'");
if (!$obj_query) { 
  Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  Mensajenew("ERROR:NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$objs = $sql->objects('',$obj_query);
$vhora_ini  = $objs->hora_ini;
$vhora_tope = $objs->hora_fin;

//Desconexion de la Base de Datos
$sql->disconnect();

//Fecha Actual
$fecha   = fechahoy();
//Hora Actual 
$horactual = Hora();
$tiempotrab1 = Compara_Hora($horactual,$vhora_ini);
$tiempotrab2 = Compara_Hora($horactual,$vhora_tope);

if (($tiempotrab1==2) && ($tiempotrab2==1)) { //Sigue Trabajando 
  //Despliegue del Menu  
  require ('example-hormenu.php');
  $smarty->display('cuerpo.tpl');
}
else { 
  $subtitulo = "HORARIO RESTRINGIDO";
  echo "<table width='100%'>";
  echo " <tr>";
  echo "  <td width='35%' class='der2-color'>";
  echo "    <font face='MS Sans Serif' size='-1'>Usuario: {$login}&nbsp; &nbsp;&nbsp;Hora:{$horactual}</font>";
  echo "  </td>";
  echo "  <td width='30%' class='cnt-color3'>";
  echo "    <font face='MS Sans Serif' size='-1'>{$subtitulo}</font>";
  echo "  </td>";
  echo "  <td width='35%' class='izq-color'>";
  echo "    <font face='MS Sans Serif' size='-1'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$fecha} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></font>";
  echo "  </td>";
  echo "  </tr>";
  echo "</table>";
  echo "&nbsp;";

  echo"<div align='center'>";
  echo "<table><tr><td>";
  echo "<a href='index.php'><img src='system-lock-screen.jpg' border='0'>";
  echo "</a></td></tr></table></div>";
}

$smarty->display('pie_pag.tpl');

//require ('example-hormenu.php');
//$smarty->display('cuerpo.tpl');
//$smarty->display('pie_pag.tpl');
?>
