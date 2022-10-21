<?
//Para trabajar con Operaciones de Bases de Datos de Produccion
include ("setting.inc.php");
require('aut_verifica.inc.php');
require('include.php');
include ('/var/www/apl/librerias/library.php');

$smarty->assign('titulop','');
$smarty->assign('titulo','');
$smarty->display('encabezado_menu.tpl');

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$login= $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

//Conexion a la Base de Datos  
$sql = new mod_db(); 
$sql->connection();   

//Variables 
$tbname_1 = "stzusuar";
$tbname_2 = "stzturnos";

// Obtencion de la Sede y Turno del Usuario  
$obj_query = $sql->query("SELECT sede,turno,estatus FROM $tbname_1 WHERE usuario='$login'");
if (!$obj_query) { 
  Mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  Mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$objs = $sql->objects('',$obj_query);
$vsede = $objs->sede;
$vturno = $objs->turno;
$vestatus = $objs->estatus;

if (($vturno==7) || ($vestatus!=1)) {
  echo " <br><br><br>";
  Mensajenew("ERROR: Acceso al Sistema Negado por estar: Ausente, Vacaciones, Reposo o dado de Baja ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$obj_query = $sql->query("SELECT hora_ini,hora_fin FROM $tbname_2 WHERE turno='$vturno'");
if (!$obj_query) { 
  Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  Mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$objs = $sql->objects('',$obj_query);
$vhora_ini  = $objs->hora_ini;
$vhora_tope = $objs->hora_fin;

//Fecha Actual
$fecha   = fechahoy();
//Hora Actual 
$horactual = Hora();
$tiempotrab1 = 1;
$tiempotrab2 = 1;
$tiempotrab1 = Compara_Hora($horactual,$vhora_ini);
$tiempotrab2 = Compara_Hora($horactual,$vhora_tope);

//Verificacion del Dia que no sea Sabado, Domingo ni Feriado 
$diahoyes = hoy();
$dia =substr($diahoyes,0,2);
$mes =substr($diahoyes,3,2);
$anio=substr($diahoyes,6,4);
$fechactual = mktime(0,0,0,$mes,$dia,$anio);  
$diasemana=date("w", $fechactual);
$nroferiado = feriado(date("d/m/Y",$fechactual),"1");

//echo "Dia=$diasemana, Hora actual=".$horactual." Su turno ".$vturno." es hasta las ".$vhora_tope." comenzando desde ".$vhora_ini;
// 0= Sabado, 6= Domingo
//if ((($tiempotrab1==2) && ($tiempotrab2==1)) && (($diasemana != 6) && ($diasemana != 0) && ($nroferiado==0))) { //Sigue Trabajando

//modificado el 15/07/2011 antes de salir de vacaciones otra vez ....
$tiempotrab1=2;
$tiempotrab2=1;
 
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
?>
