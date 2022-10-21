
<script language="Javascript"> 
 function pregunta() { 
    return confirm('Estas seguro de eliminar la Informacion ?'); }
</script>
<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = trim($_SESSION['usuario_rol']);
$vopc    = $_GET['vopc'];
$fecha   = fechahoy();
$hh      = hora();
$tbname_1= "stmfondo";

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Eliminacion de Solicitudes de Fondos ya Procesados'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) {
  //Conexion
  $sql = new mod_db();
  $sql->connection($usuario);

  // Obtencion de los Registros o Filas   
  $obj_query = $sql->query("SELECT expediente FROM $tbname_1 group by 1 order by 1");
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    Mensajenew("ERROR: No hay solicitudes que eliminar ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
  //for($cont=0;$cont<500;$cont++) {
  $van = 0;  	
  while($van<=100) {	 
    $objs = $sql->objects('',$obj_query);
    $vsol1= $objs->expediente;
    $vsol2= substr($vsol1,0,11);
    $resultado=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud,stzderec.estatus FROM stzderec WHERE stzderec.solicitud = '$vsol2' AND stzderec.tipo_mp= 'M'");
    $regmar = pg_fetch_array($resultado);
    $vder = $regmar[nro_derecho];
    $vsol = $regmar[nro_solicitud];
    $vest = $regmar[estatus];

    if (($vest==1001) || ($vest==1300) || ($vest==1008) || ($vest==1120)) { } 
    else { 
      echo " $vsol1, ";
      $van++;
      $del_datos = $sql->del("$tbname_1","expediente='$vsol1'");
    }
  }
       
}

$smarty->assign('vopc',$vopc);
$smarty->display('m_elimfondo.tpl');
$smarty->display('pie_pag.tpl');
?>


