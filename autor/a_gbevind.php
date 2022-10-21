<?php
ob_start();
// *************************************************************************************
// Programa: a_gbevind.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2006
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include ("../setting.mysql.php"); 

//Variables
$sql      = new mod_db();
$tbname_u = "stdobras";
$tbname_i = "stdevtrd";
$fecha    = fechahoy();

// Obtencion de variables de los campos del tpl
$conx   = $_GET['conx'];
$salir  = $_GET['salir'];
$nconex = $_POST['nconex'];

$solicitud        =$_POST["vsol"];
$vder             =$_POST["vder"];
$fecha_solic      =$_POST["fecha_solic"];
$fecha_venc       =$_POST["fecha_venc"];
$tipo_marca       =$_POST["tipo_marca"];
$nombre           =$_POST["nombre"];
$estatus          =$_POST["estatus"];
$descripcion      =$_POST["descripcion"];
$evento           =$_POST["evento"];
$eve_nombre       =$_POST["eve_nombre"];
$tipo_evento      =$_POST["tipo_evento"];
$plazo_ley        =$_POST["plazo_ley"];
$tipo_plazo       =$_POST["tipo_plazo"];
$mensa_automatico =$_POST["mensa_automatico"];
$aplica           =$_POST['aplica'];
$fecha_evento     =$_POST["fecha_evento"];
$documento        =$_POST["documento"];
$comentario       =$_POST["comentario"];
$usuario          =$_POST['usuario'];
$inf_adicional    =$_POST["inf_adicional"];

$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

if ($tipo_evento == "C") {
  $smarty->display('encabezado1.tpl');
  mensajenew('Evento de Tipo Cableado, NO puede ser ejecutado desde esta pantalla ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit(); }

if (empty($fecha_evento)) {
  $smarty->display('encabezado1.tpl');
  mensajenew('La Fecha del Evento esta vacia ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit(); }

$fechahoy = hoy();
$fechaeve = Convertir_en_fecha($fecha_evento,0);
$solfecha = Convertir_en_fecha($fecha_solic,0);

//$esmayor=compara_fechas($fechaeve,$fechahoy);
$esmayor=compara_fechas($fecha_evento,$fechahoy);
if ($esmayor==1) {
   $smarty->display('encabezado1.tpl');
   mensajenew('NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); exit();  }
$esmayor=compara_fechas($fecha_solic,$fechaeve);
if ($esmayor==1) {
   $smarty->display('encabezado1.tpl');
   mensajenew('NO se puede ejecutar un evento previo a la Fecha de la Solicitud ...!!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); exit();    }

//Verificando conexion
$sql->connection($usuario);

if (($evento==64) && ($documento!=0)) {
  //Verificando si el codigo de factura existe o no.
  $resul=pg_exec("SELECT * FROM stdevtrd WHERE evento=64 AND documento=$documento");
  $filasfound=pg_numrows($resul);
  if ($filasfound!=0) {
    $smarty->display('encabezado1.tpl');
     mensajenew("ERROR: Encontrado ".$filasfound." Documento(s) o Factura(s) No.: ".$documento." cargado en la Base de Datos ...!!!","a_eveind.php","N");     
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}  

//Eliminado por instrucciones de la Jefa de Division de Derecho de Autor jarodriguez Judith R.
//if (($evento==65) && ($documento!=0)) {
if (($evento==66) && ($documento!=0)) {
// nrgg {
      //Verificando conexion a Mysql para consulta a facturacion
      $mysql = new mod_mysql_db(); 
      $mysql->connection_mysql();
     
      //Datos de la Factura 
      $vfac='F0'.$documento;
      $objquery = $mysql->query_mysql("SELECT fac_id,cli_id,fac_fecha,fac_total FROM sfa_factura WHERE fac_num='$vfac'"); 
      $objfilas = $mysql->nums_mysql('',$objquery);
      if ($objfilas==0) {
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: Factura NO existe en la Base de Datos del Sistema de Facturacion SISFAC ...!!!','a_eveind.php','N');
        $smarty->display('pie_pag.tpl'); exit(); }
      $objsfac  = $mysql->objects_mysql('',$objquery);
      $fac_id   = $objsfac->fac_id;
      $fechafac = $objsfac->fac_fecha; 
      $anno = substr($fechafac,0,4);
      $mes  = substr($fechafac,5,2);
      $dia  = substr($fechafac,8,2);
      $vfechafactura = $dia.'/'.$mes.'/'.$anno; 

      //Datos del Detalle Derecho de Registro de Autor (Codigo: DA03)
      $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('DA03') AND fac_id=$fac_id"); 
      $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
      if ($objtotdtalle==0) {
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: La Factura Existe, pero en ella no se cancel&oacute; ning&uacute;n Servicio de pago de Derecho de Registro de Obra. Verifique...!!!','a_eveind.php','N');
        $smarty->display('pie_pag.tpl'); exit(); }
      $objsdta = $mysql->objects_mysql('',$objdetalle);
      $codservi = $objsdta->ser_id;
      $canservi = $objsdta->dtalle1_cantidad_ser;

      //Verificando si el codigo de factura existe o no.
      //$resul=pg_exec("SELECT * FROM stdevtrd WHERE evento=65 AND documento='$documento'");
      $resul=pg_exec("SELECT * FROM stdevtrd WHERE evento=66 AND documento='$documento'");
      $filasfound=pg_numrows($resul);
      if ($filasfound >= $canservi) {
         $smarty->display('encabezado1.tpl');
         if ($filasfound>1) { mensajenew("ERROR: Ya existen ".$filasfound." Pagos de Tasas cargados con la Factura No.: ".$vfac.", Verifique...!!!","a_eveind.php","N"); }
         else { mensajenew("ERROR: Ya existe ".$filasfound." Pago de Tasa cargado con la Factura No.: ".$vfac.", Verifique...!!!","a_eveind.php","N"); }
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
// nrgg }
}  

$comentario = str_replace("'","´",$comentario);

if ($inf_adicional=='N' || $inf_adicional=='C') {
  $documento = 0; }

if ($inf_adicional=='N' || $inf_adicional=='D') {
  $comentario = ''; }

if ($inf_adicional=='C') {
  if (empty($comentario)) {
    $smarty->display('encabezado1.tpl');
    mensajenew('El Comentario esta Vacio ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
}

//Inicialización o calculo de la Fecha de Vencimiento
if ($tipo_evento == "M")
 {
   if ($plazo_ley == 0) { $fecha_venc = null; }
   else { 
     if ($evento==25)
       { $fechavenc = calculo_fechas($fecha_venc,$plazo_ley,$tipo_plazo); }
     else
       { $fechavenc = calculo_fechas($fecha_evento,$plazo_ley,$tipo_plazo); }
     $fecha_venc = $fechavenc;
   }
 }

if ($tipo_evento == "M") {
  //Validacion adicional por si acaso otro usuario cambia la solicitud
  $resulsol=pg_exec("SELECT * FROM stdobras WHERE nro_derecho='$vder'");
  $regsol = pg_fetch_array($resulsol);
  $vest   = $regsol[estatus];
  $restfin=estatus_final($evento,$vest,"A");
  //echo "$evento $vest $restfin ";
  if (!empty($restfin)) { //Esta bien
  } else {
      $smarty->display('encabezado1.tpl');
      mensajenew('ERROR AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario','a_eveind.php?nconex=$nconex&salir=1&conx=0','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    }
}

// Comienzo de Transaccion 
pg_exec("BEGIN WORK");

$act_obr = true;
if ($tipo_evento == "M")
 {
   //Se obtiene el Estatus Final de la tabla de Migraciones y el derecho "M=Marca, P=Patente, A=Autor"
   $regestfin=estatus_final($evento,$estatus,"A");
   if ( $plazo_ley <> 0) {  
     $update_str = "estatus='$regestfin'";
     $act_obr = $sql->update("$tbname_u","$update_str","nro_derecho='$vder'"); }
   else { 
     $update_str = "estatus='$regestfin'";
     $act_obr = $sql->update("$tbname_u","$update_str","nro_derecho='$vder'"); }
 }

$horactual=hora();

$ins_tra = true;
//Inserto Datos en la tabla de Tramite Stmevtrd
if ($tipo_evento == "M") {
    if ($plazo_ley <> 0) {
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_venc,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evento','$fecha_evento',nextval('stdevtrd_secuencial_seq'),'$estatus','$documento','$fecha_venc','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
    }
    else {
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evento','$fecha_evento',nextval('stdevtrd_secuencial_seq'),'$estatus','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
    }
    $ins_tra = $sql->insert("$tbname_i","$col_campos","$insert_str","");
 }

if ($tipo_evento == "N") {
     $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
     $insert_str = "'$vder','$evento','$fecha_evento',nextval('stdevtrd_secuencial_seq'),'$estatus','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
     $ins_tra = $sql->insert("$tbname_i","$col_campos","$insert_str","");
 }

 // Verificacion y actualizacion real de los Datos en BD 
 if ($act_obr and $ins_tra) {
   pg_exec("COMMIT WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();

   $smarty->display('encabezado1.tpl');
   Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!","a_eveind.php?nconex=$nconex&salir=1&conx=0","S");
   $smarty->display('pie_pag.tpl'); }
 else {
   pg_exec("ROLLBACK WORK"); 
   //Desconexion de la Base de Datos
   $sql->disconnect();

   if (!$act_obr)   { $error_obr  = " - Obras "; } 
   if (!$act_grupo) { $error_tra  = " - Tr&aacute;mite "; }

   Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_obr $error_tra  ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit();
 }

?>
