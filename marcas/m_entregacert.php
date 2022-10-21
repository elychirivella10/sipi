<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script>
<?php
// *************************************************************************************
// Programa: m_entregacert.php 
// Realizado por el Analista de Sistema Romulo Mendoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año 2012 I Semestre
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Clase que sube el archivo
include ("$include_lib/upload_class.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = $_SESSION['usuario_login'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();
$tbname_1  = "stmmarce";
$tbname_2  = "stzevder";
$tbname_3  = "stzstder";
$tbname_4  = "stzevtrd";
$tbname_5  = "stzmigrr";
$tbname_6  = "stzsystem";
$tbname_7  = "stzderec";
$tbname_8  = "stmcertif";
$tbname_9  = "stmregcer";
$vopc      = $_GET['vopc'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Control de Certificados de Registros de Marcas a Entregar');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','formarcas1.vsol1'); 

//Verificando conexion
$sql->connection($usuario);

//Carga el tipo de marca para mostrarlo en el combo
$blanco='';
$arraytipo[0]='';
$arraytipo[1]='FIRMAR';
$arraytipo[2]='CORREGIR';

if ($vopc==4) {
  $smarty->assign('modo','readonly'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled');
  $smarty->assign('modo3','');
}

//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('modo','readonly'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','');
  $smarty->assign('modo3','readonly');
  $vopc=1;

  $nctrlcer = $_POST['nctrlcer'];
  //Validacion del Numero de Control de Pedido 
  if (empty($nctrlcer)) {
     mensajenew('AVISO: No introdujo ning&uacute;n valor de Control ...!!!','m_entregacert.php?vopc=4','N');
     $smarty->display('pie_pag.tpl'); exit(); }
  $resultado=pg_exec("SELECT * FROM stmcertif WHERE control = '$nctrlcer' AND estado='1'"); 
  
  if (!$resultado) { 
    mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_entregacert.php?vopc=4','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew('AVISO: NO EXISTEN DATOS ASOCIADOS O SOLICITUD YA PROCESADA ...!!!','m_entregacert.php?vopc=4','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $reg = pg_fetch_array($resultado);

  $tipo  = $reg[accion]; 
  $fechaper  = $reg[fecha_pedido];
  $solicitante = $reg[solicitante];
  $cisolicita = $reg[ci_solicitante];
  $telefono = $reg[telefono];
  $correo = $reg[correo];
  $indaut = $reg[indaut];
  $gestor_pn = $reg[gestor_pn];
  $gestor_pj = $reg[gestor_pj];
  $gestor_ap = $reg[gestor_ap];
  $gestor_ag = $reg[gestor_ag];
  $agente  = $reg[agente]; 
  $autorizado = $reg[autorizado];
  $ciautorizado = $reg[ci_autorizado];
  
  $obj_query = $sql->query("SELECT a.control,a.nro_derecho,a.registro,a.estado,b.nombre FROM stmregcer a,stzderec b WHERE a.control = '$nctrlcer' AND 
                            a.nro_derecho=b.nro_derecho AND a.estado='1' ORDER BY 3");
  $obj_filas = $sql->nums('',$obj_query);
  $contobj = 0;
  $objs = $sql->objects('',$obj_query);
  for ($contobj=0;$contobj < $obj_filas;$contobj++) {
    $vcodcausa[$contobj] = trim($objs->registro);
    $vdescausa[$contobj] = trim($objs->nombre);
    $vconcausa[$contobj] = trim($objs->nro_derecho);
    $objs = $sql->objects('',$obj_query); }

}

if ($vopc==2) {
  $nctrlcer = $_POST['nctrlcer'];
  $vcausa1=$_POST['causa1'];   $vcausa2=$_POST['causa2'];   $vcausa3=$_POST['causa3'];  
  $vcausa4=$_POST['causa4'];   $vcausa5=$_POST['causa5'];   $vcausa6=$_POST['causa6'];  
  $vcausa7=$_POST['causa7'];   $vcausa8=$_POST['causa8'];   $vcausa9=$_POST['causa9'];  
  $vcausa10=$_POST['causa10'];

  $obj_query = $sql->query("SELECT a.*,b.nombre FROM stmregcer a,stzderec b WHERE a.control = '$nctrlcer' AND 
                            a.nro_derecho=b.nro_derecho AND a.estado='1' ORDER BY 3");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas==0) {
    mensajenew('AVISO: CERTIFICADO(S) YA ENTREGADO(S) PARA ESTA SOLICITUD DE CONTROL ...!!!','m_entregacert.php?vopc=4','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 

  $contobj = 0;
  $objs = $sql->objects('',$obj_query);
  for ($contobj=0;$contobj < $obj_filas;$contobj++) {
    $vcodcausa[$contobj] = trim($objs->registro);
    $vdescausa[$contobj] = trim($objs->nombre);
    $vconcausa[$contobj] = trim($objs->nro_derecho);
    $objs = $sql->objects('',$obj_query); }
  
  $fechahoy = hoy();
  $horactual= Hora();

  $numsel = 0;
  $upderror = 0;
  if ($vcausa1 =='on') {
     $vder = $vconcausa[0];
     $numsel = $numsel + 1;
     $update_str = "estado='2',fecha_entrega='$fechahoy',hora_entrega='$horactual'";
     $upd_regis  = $sql->update("stmregcer","$update_str","nro_derecho=$vder AND control=$nctrlcer");
     if ($upd_regis) {}  
     else { $upderror = $upderror + 1; }    
  }
  if ($vcausa2 =='on') {
     $vder = $vconcausa[1];
     $numsel = $numsel + 1;
     $update_str = "estado='2',fecha_entrega='$fechahoy',hora_entrega='$horactual'";
     $upd_regis  = $sql->update("stmregcer","$update_str","nro_derecho=$vder AND control=$nctrlcer");
     if ($upd_regis) {}  
     else { $upderror = $upderror + 1; }    
  }
  if ($vcausa3 =='on') {
     $vder = $vconcausa[2];
     $numsel = $numsel + 1;
     $update_str = "estado='2',fecha_entrega='$fechahoy',hora_entrega='$horactual'";
     $upd_regis  = $sql->update("stmregcer","$update_str","nro_derecho=$vder AND control=$nctrlcer");
     if ($upd_regis) {}  
     else { $upderror = $upderror + 1; }    
  }
  if ($vcausa4 =='on') {
     $vder = $vconcausa[3];
     $numsel = $numsel + 1;
     $update_str = "estado='2',fecha_entrega='$fechahoy',hora_entrega='$horactual'";
     $upd_regis  = $sql->update("stmregcer","$update_str","nro_derecho=$vder AND control=$nctrlcer");
     if ($upd_regis) {}  
     else { $upderror = $upderror + 1; }    
  }
  if ($vcausa5 =='on') {
     $vder = $vconcausa[4];
     $numsel = $numsel + 1;
     $update_str = "estado='2',fecha_entrega='$fechahoy',hora_entrega='$horactual'";
     $upd_regis  = $sql->update("stmregcer","$update_str","nro_derecho=$vder AND control=$nctrlcer");
     if ($upd_regis) {}  
     else { $upderror = $upderror + 1; }    
  }
  if ($vcausa6 =='on') {
     $vder = $vconcausa[5];
     $numsel = $numsel + 1;
     $update_str = "estado='2',fecha_entrega='$fechahoy',hora_entrega='$horactual'";
     $upd_regis  = $sql->update("stmregcer","$update_str","nro_derecho=$vder AND control=$nctrlcer");
     if ($upd_regis) {}  
     else { $upderror = $upderror + 1; }    
  }
  if ($vcausa7 =='on') {
     $vder = $vconcausa[6];
     $numsel = $numsel + 1;
     $update_str = "estado='2',fecha_entrega='$fechahoy',hora_entrega='$horactual'";
     $upd_regis  = $sql->update("stmregcer","$update_str","nro_derecho=$vder AND control=$nctrlcer");
     if ($upd_regis) {}  
     else { $upderror = $upderror + 1; }    
  }
  if ($vcausa8 =='on') {
     $vder = $vconcausa[7];
     $numsel = $numsel + 1;
     $update_str = "estado='2',fecha_entrega='$fechahoy',hora_entrega='$horactual'";
     $upd_regis  = $sql->update("stmregcer","$update_str","nro_derecho=$vder AND control=$nctrlcer");
     if ($upd_regis) {}  
     else { $upderror = $upderror + 1; }    
  }
  if ($vcausa9 =='on') {
     $vder = $vconcausa[8];
     $numsel = $numsel + 1;
     $update_str = "estado='2',fecha_entrega='$fechahoy',hora_entrega='$horactual'";
     $upd_regis  = $sql->update("stmregcer","$update_str","nro_derecho=$vder AND control=$nctrlcer");
     if ($upd_regis) {}  
     else { $upderror = $upderror + 1; }    
  }
  if ($vcausa10 =='on') {
     $vder = $vconcausa[9];
     $numsel = $numsel + 1;
     $update_str = "estado='2',fecha_entrega='$fechahoy',hora_entrega='$horactual'";
     $upd_regis  = $sql->update("stmregcer","$update_str","nro_derecho=$vder AND control=$nctrlcer");
     if ($upd_regis) {}  
     else { $upderror = $upderror + 1; }    
  }

  if ($numsel>=$obj_filas) {
     $update_str = "estado='2'";
     $upd_cert  = $sql->update("stmcertif","$update_str","control=$nctrlcer");
     if ($upd_cert) {}  
     else { $upderror = $upderror + 1; }    
  }
   
  // Verificacion y actualizacion real de los Datos en BD 
  if ($upderror == 0) {    //Validacion del Numero de Solicitud
       pg_exec("COMMIT WORK");
       //Desconexion de la Base de Datos
       $sql->disconnect();
       Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_entregacert.php?vopc=4','S');
       $smarty->display('pie_pag.tpl'); exit();
  }
  else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
  }
    
}

//Paso de variables de datos
$smarty->assign('vopc',$vopc);
$smarty->assign('arrayvaut',array(N,S));
$smarty->assign('arraytaut',array('No','Si'));
$smarty->assign('arrayltipo',array(N,F,C));
$smarty->assign('arraydtipo',array('','FIRMAR','CORREGIR')); 

$smarty->assign('campo1','Acci&oacute;n:');
$smarty->assign('campo2','&nbsp;&nbsp;&nbsp;Fecha de Pedido:');
$smarty->assign('campo3','Seleccione los Certificados a entregar:');
$smarty->assign('campo4','Control No.:');
$smarty->assign('campo5','Nombre:');
$smarty->assign('campo6','C&eacute;dula de Identidad:');
$smarty->assign('campo7','Tel&eacute;fono:');
$smarty->assign('campo8','Correo:');
$smarty->assign('campo9','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actuando en su condici&oacute;n de:');
$smarty->assign('campo10','Autoriza para Presentar y/o Retirar:');

$smarty->assign('usuario',$usuario);
$smarty->assign('nctrlcer',$nctrlcer); 
$smarty->assign('tipo',$tipo);
$smarty->assign('fechaper',$fechaper);
$smarty->assign('solicitante',$solicitante); 
$smarty->assign('cisolicita',$cisolicita);
$smarty->assign('telefono',$telefono);
$smarty->assign('correo',$correo);
$smarty->assign('indaut',$indaut);
$smarty->assign('gestor_pn',$gestor_pn);
$smarty->assign('gestor_pj',$gestor_pj);
$smarty->assign('gestor_ap',$gestor_ap);
$smarty->assign('gestor_ag',$gestor_ag); 
$smarty->assign('agente',$agente);
$smarty->assign('autorizado',$autorizado);
$smarty->assign('ciautorizado',$ciautorizado);
$smarty ->assign('codcausa',$vcodcausa);
$smarty ->assign('descausa',$vdescausa); 
$smarty ->assign('concausa',$vconcausa);

$smarty->display('m_entregacert.tpl');
$smarty->display('pie_pag.tpl');
?>
