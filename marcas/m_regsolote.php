<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script>

<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit(); }

//Variables
$usuario  = trim($_SESSION['usuario_login']);
$role     = $_SESSION['usuario_rol'];
$fecha    = fechahoy();
$sql      = new mod_db();
$tbname_1 = "stmmarce";
$tbname_2 = "stzevtrd";
$tbname_3 = "stzderec";
$evento   = 1795;
$vdes     = "REGISTRO DE MARCAS";

$vopc    = $_GET['vopc'];
$boletin = $_POST['boletin'];
$vfecvi  = $_POST['vfecvi'];
$vfecve  = $_POST['vfecve'];
$pago    = $_POST['pago'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Asignaci&oacute;n de Numero de Registro por Lote');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

mensajenew('ERROR: Acceso Negado, procedimiento de asignaci&oacute;n cambiado ...!!!','javascript:history.back();','N');
$smarty->display('pie_pag.tpl'); exit();

if (($usuario=='jrrodriguez') || ($usuario=='ngonzalez') || ($usuario=='rmendoza')) { }
else {
  Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo, solo el Registrador(a) tiene acceso ...!!!","../index1.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}

//Verificando conexion
$sql->connection($usuario);

//Se verifica si el usuario puede o no cargar el evento seleccionado
$aplica = even_rol($role,$evento);
if ($aplica==0) {
    mensajenew('ERROR: El Usuario NO tiene permiso para Asignar Registro ...!!!','../index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

if ($vopc==2) {
  //Verificacion de que los campos requeridos esten llenos...
  if (($vfecvi=='') || ($pago==0) || ($boletin=='')) { 
    mensajenew('ERROR: Hay Informacion en el formulario que esta Vacia ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $esmayor=0;
  $esmayor=compara_fechas($vfecvi,$fechahoy);
  if ($esmayor==1) {
    mensajenew("ERROR: La Fecha de Registro NO puede ser mayor a la fecha actual ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 

  $fechaplazo="05/08/1992";
  $fechaley = Convertir_en_fecha($fechaplazo,0);
  $esmayor=compara_fechas($fechaley,$vfecvi);
  if ($esmayor==1) { $plazoley = 15; }
  else { $plazoley = 10; }
  if ($boletin >= 496) { $plazoley = 15; }  
  $vfecve= calculo_fechas($vfecvi,$plazoley,"A","/");

  //$obj_query = $sql->query("SELECT distinct stmmarce.solicitud,tipo_marca,estatus,registro 
  //                          from $tbname_1,$tbname_2
  //                          where stmmarce.solicitud=stmevtrd.solicitud and
  //                                stmmarce.estatus = 410 and
  //                                stmmarce.solicitud in (select distinct solicitud from stmevtrd 
  //                                      where evento in (97,122,181,182,956,180) and
  //                                            estat_ant in (26,27,101,390,399,127) and
  //                                      stmevtrd.documento=$boletin)
  //                          order by tipo_marca,solicitud");

  //$obj_query = $sql->query("SELECT distinct stmmarce.solicitud,tipo_marca,estatus,registro
  //                          FROM  stmmarce, stmevtrd 
	//	                      WHERE stmmarce.estatus = 410  
	//		                   AND   stmevtrd.documento = $boletin
	//		                   AND   stmmarce.solicitud=stmevtrd.solicitud 
	//		                   AND ((evento = '122' and estat_ant in (101,390)) or
   //                              (evento = '97' and stmevtrd.solicitud not in (select solicitud from stmevtrd 
   //                                                                            where (evento='180' and estat_ant < '555') or
   //                                                                           (evento='122' and estat_ant in (101,390)))) or
   //                              (evento = '180' and estat_ant < '555' 
   //                               and stmevtrd.solicitud not in (select solicitud from stmevtrd 
   //                                                              where evento='122' and estat_ant in (101,390))))
	//	                      ORDER BY tipo_marca,solicitud");	

  $obj_query = $sql->query("SELECT distinct stzderec.nro_derecho,stzderec.solicitud,tipo_derecho,estatus,registro
                            FROM  stzderec, stzevtrd 
		                      WHERE stzderec.estatus = 1410
		                      AND   stzderec.tipo_mp = 'M'   
			                   AND   stzevtrd.documento = $boletin
			                   AND   stzderec.nro_derecho=stzevtrd.nro_derecho 
			                   AND ((evento = '1122' AND estat_ant IN (1101,1390)) OR 
                                 (evento = '1097' AND stzevtrd.nro_derecho NOT IN (select nro_derecho FROM stzevtrd 
                                                                               WHERE (evento='1180' AND estat_ant < '1555') OR 
                                                                              (evento='1122' AND estat_ant in (1101,1390)))) OR 
                                 (evento = '1180' AND estat_ant < '1555' 
                                  AND stzevtrd.nro_derecho NOT IN (select nro_derecho FROM stzevtrd 
                                                                 WHERE evento='1122' AND estat_ant in (1101,1390))))
		                      ORDER BY tipo_derecho,solicitud");
		                      	
  if (!$obj_query) { 
    mensajenew('ERROR: Problema al intentar realizar la consulta en la Base de Datos ...!!!','index1.php','N');
    $smarty->display('pie_pag.tpl');
    $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew('ERROR: Ningun Expediente recuperado para actualizar ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  pg_exec("BEGIN WORK");    
  $numact = 0;    
  $objs = $sql->objects('',$obj_query);
  for($cont=0;$cont<$filas_found;$cont++) 
  { 
    $actprim= true;
    $instram= true;
    $vsol   = $objs->solicitud;
    $vder   = $objs->nro_derecho;
    $tipo_m = $objs->tipo_derecho;
    switch ($tipo_m) {
      case "M":
         $tnumera='nproducto';
         $letrareg = "P";
         break;
      case "N":
         $tnumera='nnombres';
         $letrareg = "N";         
         break;
      case "L":
         $tnumera='nlemas';
         $letrareg = "L";
         break;
      case "S":
         $tnumera='nservicios';
         $letrareg = "S";
         break;
      case "C":
         $tnumera='ncolectivas';
         $letrareg = "C";
         break;
      case "D":
         $tnumera='ndorigen';
         $letrareg = "D";
         break;
    }
    
    //Se obtiene el proximo valor del registro
    $sys_actual = next_sys("$tnumera");
    $vnumreg = grabar_sys("$tnumera",$sys_actual);
    $vregis  = $letrareg.sprintf("%06d",$vnumreg);
    $vcomenta = "REGISTRO NUMERO: ".$vregis;
    $instram = true;
    $actprim = true; 
    
    //Se actualiza Maestra de Marcas
    $update_str = "estatus=1555,registro='$vregis',fecha_regis='$vfecvi',fecha_venc='$vfecve'";
    $actprim = $sql->update("$tbname_3","$update_str","nro_derecho='$vder'");

    $horactual=hora();
    // Tabla de Eventos de Tramite
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora";
    $insert_str = "'$vder',$evento,'$vfecvi',nextval('stzevtrd_secuencial_seq'),'1410','$vfecve','$pago','$fechahoy','$usuario','$vdes','$vcomenta','$horactual'";
    $instram = $sql->insert("$tbname_2","$col_campos","$insert_str","");
    
    if ($actprim AND $instram) { }
    else { $numact = $numact + 1; }  

    $objs = $sql->objects('',$obj_query);
  }

  if ($numact==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_regsolote.php','S');
    $smarty->display('pie_pag.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

}

//Pase de variables y Etiquetas al template
$smarty->assign('submitbutton','submit'); 
$smarty->assign('submitbutton1','button'); 
$smarty->assign('campo1','Boletin No.:');
$smarty->assign('campo2','Fecha de Publicacion:');
$smarty->assign('campo3','Pago de Derecho Bs.:');
$smarty->assign('varfocus','formarcas1.boletin'); 
$smarty->assign('vmodo','');
$smarty->assign('usuario',$vuser);
$smarty->assign('role',$role);
$smarty->assign('boletin',$boletin);
$smarty->assign('vfecvi',$vfecvi);
$smarty->assign('vfecve',$vfecve);
$smarty->assign('pago',$pago);

$smarty->display('m_regsolote.tpl');
$smarty->display('pie_pag.tpl');
?>
