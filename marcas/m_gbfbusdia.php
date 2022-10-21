<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<?php
// *************************************************************************************
// Programa: m_gbfbusdia.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2014 II Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);
$sede    = $_SESSION['usuario_sede'];

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Variables
$tbname_1 = "stmbusdia";
$fecha    = fechahoy();

$vopc       = $_GET['vopc'];
$vsol1      = $_POST['vsol1'];
$accion     = $_POST['accion'];
$factura    = $_POST['factura'];
$fechadep   = $_POST['fechadep'];
$solicitant = $_POST['solicitant'];
$vsede      = $_POST['vsede'];
$nbusfon    = $_POST['nbusfon'];
$nbusgra    = $_POST['nbusgra'];
$vplus      = trim($_POST["vplus"]);
$fecharec   = $_POST['fecharec'];

$subtitulo  = "Solicitud(es) de B&uacute;squeda(s) Fon&eacute;tica y/o Gr&aacute;fica";

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo',$subtitulo);
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Opcion Grabar...
if ($vopc==2) {
  $horactual= Hora();
  $fechahoy = hoy();

  $solicitant = str_replace("'","´",$solicitant);
  if ($nbusfon!=0) { $tipobusq="F"; }
  if ($nbusgra!=0) { $tipobusq="G"; }
  
  if (empty($vplus)) {
    Mensajenew('ERROR: Debe seleccionar el Modo de Env&iacute;o ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  
  pg_exec("BEGIN WORK");
  //Ingreso de datos de la busqueda y factura
  $obj_query = $sql->query("select last_value from stmbusdia_nro_busdia_seq");
  $objs = $sql->objects('',$obj_query);
  $vnobusdia = $objs->last_value;
  //$obj_query = $sql->query("nextval('stmbusdia_nro_busdia_seq')");

  //$col_campos = "nro_busdia,nro_factura,fecha_factura,solicitante,cantidad_fon,cantidad_gra,fecha_recibido,hora_recibida,usuario,sede,envio_correo,tipo_busqueda";
  $insert_str = "nextval('stmbusdia_nro_busdia_seq'),'$factura','$fechadep','$solicitant',$nbusfon,$nbusgra,'$fecharec','$horactual','$usuario','$sede','$vplus','$tipobusq','$fechahoy'"; 
  $insfone = $sql->insert("$tbname_1","","$insert_str","");

  if ($insfone) { 
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
    Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_ingbusrec1.php?vopc=1','S');
    //Mensaje2("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_ingfacfon1.php?vopc=1","m_rptingbus.php?vfac=$factura&vusr=$usuario&nfon=$nbusfon&ngra=$nbusgra");
    $smarty->display('pie_pag2.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
    Mensajenew("ERROR: Falla de Inserci&oacute;n de Datos de la Factura en la BD ...!!!","../index1.php","N");
    $smarty->display('pie_pag2.tpl'); exit();
  }
}

?>
<html>
