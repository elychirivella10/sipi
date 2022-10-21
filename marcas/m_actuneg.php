<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// *************************************************************************************
// Programa: m_actuneg.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// Modificado I Semestre 2009 BD - Relacional   
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$sql  = new mod_db();

$tbname_1 = "stmmarce";
$tbname_2 = "stzevder";
$tbname_3 = "stzstder";
$tbname_4 = "stzevtrd";
$tbname_5 = "stzderec";
$evento   = 1062;

$vopc    =$_GET['vopc'];
$vsol1   =$_POST['vsol1'];
$vsol2   =$_POST['vsol2'];
$vsol3   =$_POST['vsol3'];
$vsol4   =$_POST['vsol4'];
$vsola   =$_POST['vsola'];
$vsolb   =$_POST['vsolb'];
$articulo=$_POST['articulo'];
$literal =$_POST['literal'];
$boletin =$_POST['boletin'];
$fechabol=$_POST['fechabol'];
$tomo    =$_POST['tomo'];
$pagina  =$_POST['pagina'];
$resolucion=$_POST['resolucion'];

$vsola=$vsol1."-".sprintf("%06d",$vsol2);
$vsolb=$vsol3."-".sprintf("%06d",$vsol4);
$resultado=false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizaci&oacute;n de Negadas por Paginas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('varfocus','formarcas.vsol1'); 
$smarty->assign('modo2','readonly');

//Verificando conexion
$sql->connection($usuario);

//Se verifica si el usuario puede o no actualizar por lotes
$aplica = even_rol($role,$evento);
if ($aplica==0) {
    mensajenew('El Usuario NO tiene permiso para Actualizar Negadas ...!!!','index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

if ($vopc==1) {
  //Validacion en el Rango de Solicitudes
  if (($vsola=='0000-000000' || $vsolb=='0000-000000') || (($vsola=='-000000') || ($vsolb=='-000000'))) {
   mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS ...!!!','m_actuneg.php','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  }
   
  if ($vsola > $vsolb) {
   mensajenew('ERROR AL INTENTAR PROCESAR - RANGO INCORRECTO ...!!!','m_actuneg.php','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if (($articulo=='' || $boletin=='' || $tomo=='' || $pagina=='' || $resolucion=='')) {
   mensajenew('Hay Datos en el formulario que estan Vacio(s) ...!!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  }
   
  //if ($articulo!=178) {
  //  if ($literal=='') {
  //    mensajenew('El Literal esta Vacio(s) ...!!!','javascript:history.back();','N');
  //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  }
  //}
  
  if (empty($fechabol)) { 
    mensajenew('ERROR: La Fecha de Vigencia del Boletin esta vacia ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  $resultado=pg_exec("SELECT * FROM $tbname_2 WHERE evento='$evento'");
  $filas_found=pg_numrows($resultado); 
  $regeve = pg_fetch_array($resultado);
  $tipo_evento   = $regeve['tipo_evento'];
  $inf_adicional = trim($regeve['inf_adicional']);
  $mensa_automatico = trim($regeve['mensa_automatico']);
  $tipo_plazo    = $regeve['tipo_plazo'];
  $plazo_ley     = $regeve['plazo_ley'];
  $documento=0;
  $comentario="Tomo: ".$tomo." Pagina: ".$pagina." Resolucion: ".$resolucion;
  
  //Obtencion de la Fecha de Vencimiento de acuerdo al evento
  $fechavenc = calculo_fechas($fechabol,$plazo_ley,$tipo_plazo,"/");
  
  //Obtención de los Expedientes a Actualizar
  if (($articulo==33) || ($articulo==34)) { 
    $obj_query=$sql->query("SELECT distinct stzderec.nro_derecho,stzderec.solicitud,boletin,articulo,literal
                            FROM stzderec,stmliaor,stztmpbo
                            WHERE stzderec.nro_derecho=stmliaor.nro_derecho AND
                                  stzderec.nro_derecho=stztmpbo.nro_derecho AND
                                  stzderec.estatus = 1102 AND
                                  stzderec.tipo_mp='M' AND  
                                  stmliaor.articulo = '$articulo' AND
                                  stmliaor.literal = '$literal' AND
                                  stztmpbo.boletin = '$boletin' AND
                                  stztmpbo.tipo = 'M' 
                            ORDER BY stzderec.solicitud"); }
  if (($articulo==27) || ($articulo==28) || ($articulo==35)) {
    $obj_query=$sql->query("SELECT distinct stzderec.nro_derecho,stzderec.solicitud,boletin,articulo,literal
                            FROM  stzderec,stmliaor,stztmpbo
                            WHERE stzderec.nro_derecho=stmliaor.nro_derecho AND
                                  stzderec.nro_derecho=stztmpbo.nro_derecho AND
                                  stzderec.estatus = 1102 AND
                                  stzderec.tipo_mp='M' AND  
                                  stmliaor.articulo = '$articulo' AND
                                  stztmpbo.boletin = '$boletin' AND 
                                  stztmpbo.tipo = 'M' 
                            ORDER BY stzderec.solicitud"); }
                                  
 if (!$obj_query) { 
    mensajenew('ERROR: Problema al intentar realizar la consulta en la Base de Datos ...!!!','index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    Mensage_Error("ERROR: Ningun Expediente recuperado para actualizar ...!!!");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //La Fecha de Hoy para la transaccion y calculos de fechas de vencimientos
  $fechahoy = hoy();

  $update_str = "estatus=1500,fecha_venc='$fechavenc'"; 

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $numerror = 0;
  $objs = $sql->objects('',$obj_query);
  for($cont=0;$cont<$filas_found;$cont++) 
  { 
    $ins_tram = true;
    $act_dere = true;
    $del_bole = true;
    
    $vder = $objs->nro_derecho;

    //Se actualiza Maestra Principal de Derecho 
    $act_dere = $sql->update("$tbname_5","$update_str","nro_derecho='$vder'");

    $horactual=hora();
    //Inserto Datos en la tabla de Tramite Stzevtrd
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora";
    $insert_str = "'$vder','$evento','$fechabol',nextval('stzevtrd_secuencial_seq'),1102,'$fechavenc','$boletin','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
    $ins_tram = $sql->insert("$tbname_4","$col_campos","$insert_str","");
    $del_bole = $sql->del("stztmpbo","nro_derecho='$vder'");

    if ($ins_tram AND $act_dere AND $del_bole) { }
    else { $numerror = $numerror + 1; }  

    $objs = $sql->objects('',$obj_query);
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_actuneg.php','S');
    $smarty->display('pie_pag.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

}

//Pase de variables y Etiquetas al template
$smarty->assign('submitbutton','submit'); 
$smarty->assign('submitbutton1','button'); 

$smarty->assign('campo1','Rango de Expedientes:');
$smarty->assign('campo2','Articulo:');
$smarty->assign('campo3','Literal:');
$smarty->assign('campo4','Boletin:');
$smarty->assign('campo5','Fecha de Vigencia:');
$smarty->assign('campo6','Tomo:');
$smarty->assign('campo7','Pagina:');
$smarty->assign('campo8','Resolucion:');

$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('vsola',$vsola);
$smarty->assign('vsolb',$vsolb);
$smarty->assign('vsol1',$vsol1); 
$smarty->assign('vsol2',$vsol2); 
$smarty->assign('vsol3',$vsol3); 
$smarty->assign('vsol4',$vsol4); 

$smarty->display('m_actuneg.tpl');
$smarty->display('pie_pag.tpl');

?>