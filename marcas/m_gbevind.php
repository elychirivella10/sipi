<script language="Javascript"> 

function getKey(keyStroke) {  
isNetscape=(document.layers); 
eventChooser = (isNetscape) ? keyStroke.which : event.keyCode;    
if (eventChooser==13) {      
   return false; 
   }  
} 
document.onkeypress = getKey;

</script> 
<?php
// *************************************************************************************
// Programa: m_gbevind.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado Año 2009 BD - Relacional 
// *************************************************************************************

ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include ("../setting.mysql.php"); 

//Variables
$sql = new mod_db();
$tbname_o = "stzderec";
$tbname_u = "stmmarce";
$tbname_i = "stzevtrd";
$tbname_10 = "stmfactura";
$sede = $_SESSION['usuario_sede'];

//Validacion de Entrada
$vder         =$_POST["vder"]; 
$anno         =$_POST["anno"];
$numero       =$_POST["numero"];
$fecha_solic  =$_POST["fecha_solic"];
$fecha_venc   =$_POST["fecha_venc"];
$tipo_marca   =$_POST["tipo_marca"];
$nombre       =$_POST["nombre"];
$estatus      =$_POST["estatus"];
$descripcion  =$_POST["descripcion"];
$evento       =$_POST["evento"];
$eve_nombre   =$_POST["eve_nombre"];
$tipo_evento  =$_POST["tipo_evento"];
$plazo_ley    =$_POST["plazo_ley"];
$tipo_plazo   =$_POST["tipo_plazo"];
$mensa_automatico = $_POST["mensa_automatico"];
$aplica       =$_POST['aplica'];
$fecha_evento =$_POST["fecha_evento"];
$documento    =$_POST["documento"];
$comentario   =$_POST["comentario"];
$usuario      =$_POST['usuario'];
$inf_adicional=$_POST["inf_adicional"];
$nconex       =$_POST['nconex'];
$solicitud    =$anno."-".$numero;

$fecha   = fechahoy();
$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

$evento = $evento+1000;
$estatus= $estatus+1000;

if ($tipo_evento == "C") { 
    $smarty->display('encabezado1.tpl');
    mensajenew('AVISO: Evento de Tipo Cableado, NO puede ser ejecutado desde esta pantalla ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

if (empty($fecha_evento)) {
    $smarty->display('encabezado1.tpl');
    //Mensage_Error("La Fecha del Evento esta vacia...!!!");
    mensajenew('ERROR: La Fecha del Evento esta vacia ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

$fechahoy = hoy();
$fechaeve = Convertir_en_fecha($fecha_evento,0);
$solfecha = Convertir_en_fecha($fecha_solic,0);

//$esmayor=compara_fechas($fechaeve,$fechahoy);
$esmayor=compara_fechas($fecha_evento,$fechahoy);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit();  } 
//$esmayor=compara_fechas($solfecha,$fechaeve);
$esmayor=compara_fechas($fecha_solic,$fechaeve);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: NO se puede ejecutar un evento previo a la Fecha de la Solicitud ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit();    } 

//Verificando conexion
$sql->connection($usuario);

//Inicialización o calculo de la Fecha de Vencimiento
if ($tipo_evento == "M")
  {
   if ($plazo_ley == 0)
     { $fecha_venc = null; } 
     else 
      { if ($evento==1025) 
          { $fechavenc = calculo_fechas($fecha_venc,$plazo_ley,$tipo_plazo,"/"); }
        else
          { $fechavenc = calculo_fechas($fecha_evento,$plazo_ley,$tipo_plazo,"/"); }
        $fecha_venc = $fechavenc;          
      } 
  }

if ($tipo_evento == "M") {
  //Validacion adiconal por si acaso otro usuario cambia la solicitud
  $resulsol=pg_exec("SELECT * FROM $tbname_o WHERE nro_derecho='$vder'");
  $regsol = pg_fetch_array($resulsol);
  $vest   = $regsol[estatus];
  $restfin=estatus_final($evento,$vest,'M'); 
  if (!empty($restfin)) { //Esta bien
  } else {
      $smarty->display('encabezado1.tpl');
      mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario','m_eveind.php','N');
  	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }
}

pg_exec("BEGIN WORK");
$actprim = true;
if ($tipo_evento == "M") {
  if ($evento != 1020)
  {
   //Se obtiene el Estatus Final de la tabla de Migraciones y el derecho "M=Marca, P=Patente"
   $regestfin=estatus_final($evento,$estatus,'M');
   if ( $plazo_ley <> 0)
     {  $update_str = "estatus='$regestfin', fecha_venc='$fecha_venc'";
        $actprim = $sql->update("$tbname_o","$update_str","nro_derecho='$vder'");
     } 
     else {
     	  //Modificado el día 15/11/2016 por Romulo Mendoza  
        //$update_str = "estatus='$regestfin', fecha_venc=null";
        $update_str = "estatus='$regestfin'";
        $actprim =  $sql->update("$tbname_o","$update_str","nro_derecho='$vder'");
      } 
  }
}

//Evento de Publicación
if ($evento == 1124)
   {  $update_str = "fecha_venc='$fecha_venc'";
      $actprim = $sql->update("$tbname_o","$update_str","nro_derecho='$vder'");
   }

$comentario = str_replace("'","´",$comentario);
$horactual=hora();

if ($inf_adicional=='N' || $inf_adicional=='C') {
  $documento = 0;
}

if ($inf_adicional=='N' || $inf_adicional=='D') {
  $comentario = '';
}

if ($evento==1840) { $comentario = 'Retirado por: '.trim($comentario); }
if ($evento==1841) { $comentario = 'CERTIFICADO YA RETIRADO DE ACUERDO AL CUADERNO CONTROL.'; }

if ($inf_adicional=='C') {
  if (empty($comentario)) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: El Comentario esta Vacio ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit();
  }
}

if ($inf_adicional=='D') {
  if (empty($documento) || $documento==0) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: El Documento esta Vacio ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit();
  }
}

if ($evento==1793) {
  $comprobante = "C".str_pad($documento,7,'0',STR_PAD_LEFT); 
  $comentario = 'COMPROBANTE: '.$comprobante.' Pago en Dolares.'; 
}

if ($evento==1805) {
  //Verificando conexion a Mysql para consulta a facturacion
  $mysql = new mod_mysql_db(); 
  $mysql->connection_mysql();
	
  $nfac = 'F0'.$documento;
  //Datos de la Factura 
  $objquery = $mysql->query_mysql("SELECT fac_id,cli_id,fac_fecha,fac_total FROM sfa_factura WHERE fac_num='$nfac'"); 
  $objfilas = $mysql->nums_mysql('',$objquery);
  if ($objfilas==0) {
    mensajenew('ERROR: Factura NO existe en la Base de Datos ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $objsfac  = $mysql->objects_mysql('',$objquery);
  $fac_id   = $objsfac->fac_id;
  $fechafac = $objsfac->fac_fecha; 
  $cli_id   = $objsfac->cli_id;
  $factotal = $objsfac->fac_total; 
  
  $anno = substr($fechafac,0,4);
  $mes  = substr($fechafac,5,2);
  $dia  = substr($fechafac,8,2);
  $vfechafactura = $dia.'/'.$mes.'/'.$anno; 

  //Datos del Detalle 
  $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('PDCE') AND fac_id=$fac_id"); 
  $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
  if ($objtotdtalle==0) {
    mensajenew('ERROR: Factura NO presenta ning&uacute;n servicio de Pago de Derecho de Registro de Marcas en Moneda Extranjera ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $objsdta = $mysql->objects_mysql('',$objdetalle);
  $cant_fac = $objsdta->dtalle1_cantidad_ser;
  $codservi = $objsdta->ser_id;
  if($codservi=='PDCE') { $totalpag= 'Total US$ : '; }
}

if ($evento==1167) {
  //Verificando conexion a Mysql para consulta a facturacion
  $mysql = new mod_mysql_db(); 
  $mysql->connection_mysql();
	
  $nfac = 'F0'.$documento;
  //Datos de la Factura 
  $objquery = $mysql->query_mysql("SELECT fac_id,cli_id,fac_fecha,fac_total FROM sfa_factura WHERE fac_num='$nfac'"); 
  $objfilas = $mysql->nums_mysql('',$objquery);
  if ($objfilas==0) {
    mensajenew('ERROR: Factura NO existe en la Base de Datos ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $objsfac  = $mysql->objects_mysql('',$objquery);
  $fac_id   = $objsfac->fac_id;
  $fechafac = $objsfac->fac_fecha; 
  $cli_id   = $objsfac->cli_id;
  $factotal = $objsfac->fac_total; 
  
  $anno = substr($fechafac,0,4);
  $mes  = substr($fechafac,5,2);
  $dia  = substr($fechafac,8,2);
  $vfechafactura = $dia.'/'.$mes.'/'.$anno; 

  //Datos del Detalle 
  $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('SC') AND fac_id=$fac_id"); 
  $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
  if ($objtotdtalle==0) {
    mensajenew('ERROR: Factura NO presenta ning&uacute;n Servicio de Correcci&oacute;n de Error de Datos de Marcas ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $objsdta = $mysql->objects_mysql('',$objdetalle);
  $cant_fac = $objsdta->dtalle1_cantidad_ser;
  $codservi = $objsdta->ser_id;
  //if($codservi=='PDCE') { $totalpag= 'Total US$ : '; }
}

//Pagos de Oposiciones Aviso Oficial DG-001-2020 
//if ($evento==1040) {
//  $nfactura =$_POST["factura"];
//  $nfac     = 'F0'.$nfactura;
//
//  //Validacion en Postgresql Tabla Stmfactura      
//  // =======================================================================================================================
//  $vcant_opo=0;
//  $obj_query = $sql->query("SELECT * FROM $tbname_10 WHERE nro_factura='$nfac'");
//  $obj_filas = $sql->nums('',$obj_query);
//  if ($obj_filas!=0) {
//    $objs=$sql->objects('',$obj_query);
//    $vcant_opo=$objs->cant_oposicion; 
//  }
//  //echo "$vcant_opo,$nfac";
//  //mensajenew('ERROR: EVENTO 40 NO puede cargarse por mantenimiento, contactar al Administrador del Sistema ...!!!','javascript:history.back();','N');
//  //$smarty->display('pie_pag.tpl'); exit();
//
//  //Verificando conexion a Mysql para consulta a facturacion
//  $mysql = new mod_mysql_db(); 
//  $mysql->connection_mysql();
//	
//  //Datos de la Factura 
//  $objquery = $mysql->query_mysql("SELECT fac_id,cli_id,fac_fecha,fac_total FROM sfa_factura WHERE fac_num='$nfac'"); 
//  $objfilas = $mysql->nums_mysql('',$objquery);
//  if ($objfilas==0) {
//    $smarty->display('encabezado1.tpl');
//    mensajenew('ERROR: Factura NO existe en la Base de Datos ...!!!','javascript:history.back();','N');
//    $smarty->display('pie_pag.tpl'); exit(); }
//  $objsfac  = $mysql->objects_mysql('',$objquery);
//  $fac_id   = $objsfac->fac_id;
//  $fechafac = $objsfac->fac_fecha; 
//  $cli_id   = $objsfac->cli_id;
//  $factotal = $objsfac->fac_total; 
//  
//  $anno = substr($fechafac,0,4);
//  $mes  = substr($fechafac,5,2);
//  $dia  = substr($fechafac,8,2);
//  $vfechafactura = $dia.'/'.$mes.'/'.$anno; 
//  //echo "$vfechafactura,$fac_id ";
//  //Datos del Detalle 
//  $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('OMB') AND fac_id=$fac_id"); 
//  $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
//  if ($objtotdtalle==0) {
//    $smarty->display('encabezado1.tpl');
//    mensajenew('ERROR: Factura NO presenta ning&uacute;n Servicio de Pago de Oposicion de Marcas ...!!!','javascript:history.back();','N');
//    $smarty->display('pie_pag.tpl'); exit(); }
//  $objsdta = $mysql->objects_mysql('',$objdetalle);
//  $cant_fac = $objsdta->dtalle1_cantidad_ser;
//  $codservi = $objsdta->ser_id;
//  if ($vcant_opo>=$cant_fac) {
//    $smarty->display('encabezado1.tpl');
//    mensajenew('ADVERTENCIA: Factura '.$nfactura.' YA asociada a la cantidad de Solicitud(es) permitidas o indicadas...!!!','m_eveind.php','N');
//    $smarty->display('pie_pag.tpl'); exit();
//  } 
//}

//Habilitacion de Resolucion de Oposicion x Aviso Oficial DG-001-2020 Boletines desde 462 al 599
if ($evento==1226) {
  $nfac = 'F0'.$documento;

  //Validacion en Postgresql Tabla Stmfactura      
  // =======================================================================================================================
  $vcant_hro=0;
  $obj_query = $sql->query("SELECT * FROM $tbname_10 WHERE nro_factura='$nfac'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas!=0) {
    $objs=$sql->objects('',$obj_query);
    $vcant_hro=$objs->cant_oposhabil; 
  }

  //Verificando conexion a Mysql para consulta a facturacion
  $mysql = new mod_mysql_db(); 
  $mysql->connection_mysql();
	
  //Datos de la Factura 
  $objquery = $mysql->query_mysql("SELECT fac_id,cli_id,fac_fecha,fac_total FROM sfa_factura WHERE fac_num='$nfac'"); 
  $objfilas = $mysql->nums_mysql('',$objquery);
  if ($objfilas==0) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: Factura NO existe en la Base de Datos ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $objsfac  = $mysql->objects_mysql('',$objquery);
  $fac_id   = $objsfac->fac_id;
  $fechafac = $objsfac->fac_fecha; 
  $cli_id   = $objsfac->cli_id;
  $factotal = $objsfac->fac_total; 
  
  $anno = substr($fechafac,0,4);
  $mes  = substr($fechafac,5,2);
  $dia  = substr($fechafac,8,2);
  $vfechafactura = $dia.'/'.$mes.'/'.$anno; 

  //Datos del Detalle 
  $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('HRO') AND fac_id=$fac_id"); 
  $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
  if ($objtotdtalle==0) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: Factura NO presenta ning&uacute;n Servicio de Habilitacion de Resolucion de Oposicion ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $objsdta = $mysql->objects_mysql('',$objdetalle);
  $cant_fac = $objsdta->dtalle1_cantidad_ser;
  $codservi = $objsdta->ser_id;
  if ($vcant_hro>=$cant_fac) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ADVERTENCIA: Factura '.$nfactura.' YA asociada a la cantidad de Solicitud(es) permitidas o indicadas...!!!','m_eveind.php','N');
    $smarty->display('pie_pag.tpl'); exit();
  } 
}

//Habilitacion de Cambios Posteriores a Registros x Aviso Oficial DG-001-2020
if (($evento==1260) || ($evento==1261) || ($evento==1262) || ($evento==1263) || ($evento==1264) || ($evento==1265)) {
  $nfac = 'F0'.$documento;

  switch ($evento) {
     case 1260:
       $tipcp = "R";
       break;
     case 1261:
       $tipcp = "C";
       break;
     case 1262:
       $tipcp = "F";
       break;
     case 1263:
       $tipcp = "L";
       break;
     case 1264:
       $tipcp = "D";
       break;
     case 1265:
       $tipcp = "N";
       break;
  }       

  //Validacion en Postgresql Tabla Stmfactura      
  // =======================================================================================================================
  $vcant_cp=0;
  $obj_query = $sql->query("SELECT * FROM $tbname_10 WHERE nro_factura='$nfac'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas!=0) {
    $objs=$sql->objects('',$obj_query);
    $vcant_cp=$objs->cant_cphabil; 
  }

  //Verificando conexion a Mysql para consulta a facturacion
  $mysql = new mod_mysql_db(); 
  $mysql->connection_mysql();
	
  //Datos de la Factura 
  $objquery = $mysql->query_mysql("SELECT fac_id,cli_id,fac_fecha,fac_total FROM sfa_factura WHERE fac_num='$nfac'"); 
  $objfilas = $mysql->nums_mysql('',$objquery);
  if ($objfilas==0) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: Factura NO existe en la Base de Datos ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $objsfac  = $mysql->objects_mysql('',$objquery);
  $fac_id   = $objsfac->fac_id;
  $fechafac = $objsfac->fac_fecha; 
  $cli_id   = $objsfac->cli_id;
  $factotal = $objsfac->fac_total; 
  
  $anno = substr($fechafac,0,4);
  $mes  = substr($fechafac,5,2);
  $dia  = substr($fechafac,8,2);
  $vfechafactura = $dia.'/'.$mes.'/'.$anno; 

  //Datos del Detalle 
  $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('SH') AND fac_id=$fac_id"); 
  $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
  if ($objtotdtalle==0) {
    $smarty->display('encabezado1.tpl');
    switch ($evento) {
      case 1260:
       mensajenew('ERROR: Factura NO presenta ning&uacute;n Servicio de Habilitacion de Renovacion de Marcas ...!!!','javascript:history.back();','N');
       break;
      case 1261:
        mensajenew('ERROR: Factura NO presenta ning&uacute;n Servicio de Habilitacion de Cesion de Marcas ...!!!','javascript:history.back();','N');
        break;
      case 1262:
        mensajenew('ERROR: Factura NO presenta ning&uacute;n Servicio de Habilitacion de Fusion de Marcas ...!!!','javascript:history.back();','N');
        break;
      case 1263:
        mensajenew('ERROR: Factura NO presenta ning&uacute;n Servicio de Habilitacion de Licencia de Marcas ...!!!','javascript:history.back();','N');
        break;
      case 1264:
        mensajenew('ERROR: Factura NO presenta ning&uacute;n Servicio de Habilitacion de Cambio de Domicilio de Marcas ...!!!','javascript:history.back();','N');
        break;
      case 1265:
        mensajenew('ERROR: Factura NO presenta ning&uacute;n Servicio de Habilitacion de Cambio de Nombre de Marcas ...!!!','javascript:history.back();','N');
        break;
    }       
    $smarty->display('pie_pag.tpl'); exit(); 
  }
  $objsdta = $mysql->objects_mysql('',$objdetalle);
  $cant_fac = $objsdta->dtalle1_cantidad_ser;
  $codservi = $objsdta->ser_id;
  if ($vcant_cp>=$cant_fac) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ADVERTENCIA: Factura '.$nfactura.' YA asociada a la cantidad de Solicitud(es) permitidas o indicadas...!!!','m_eveind.php','N');
    $smarty->display('pie_pag.tpl'); exit();
  } 

}

$can_error = 0;
//Inserto Datos en la tabla de Tramite Stmevtrd
$instram = true;
if ($tipo_evento == "M")
  {    
    if ($plazo_ley <> 0) {
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evento','$fecha_evento',nextval('stzevtrd_secuencial_seq'),'$estatus','$fecha_venc','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
    } 
    else {
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder','$evento','$fecha_evento',nextval('stzevtrd_secuencial_seq'),'$estatus','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
    }
    //echo "$insert_str"; 
    $instram = $sql->insert("$tbname_i","$col_campos","$insert_str",""); 
  }

if ($tipo_evento == "N") {
  $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
  $insert_str = "'$vder','$evento','$fecha_evento',nextval('stzevtrd_secuencial_seq'),'$estatus','$documento','$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
  //echo "$insert_str"; 
  $instram = $sql->insert("$tbname_i","$col_campos","$insert_str",""); 
}

//Validacion con Stmfactura
// =======================================================================================================================
  $insfactu = true;
//  if (($evento==1040) AND ($documento>=600)) {
//    $tipcp = "O";
//    if ($vcant_opo>0) {$delfactu = $resulage=pg_exec("delete from $tbname_10 where nro_factura='$nfac'");}
//    $vcant_opo=$vcant_opo+1;
//    $delfactu = $resulage=pg_exec("delete from $tbname_10 where nro_factura='$nfac'");
//    $insfactu   = true;
//    $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede,cant_mprensa,cant_pprensa,tipo_anotamar,cant_anotamar,cant_cambtitu,cant_cambdomi,cant_oposicion,cant_oposhabil,cant_cphabil";
//    $insert_str = "'$nfac','$fechafac',0,0,0,'$sede',0,0,'$tipcp',0,0,0,$vcant_opo,0,0";    
//
//    $insfactu   = $sql->insert("$tbname_10","$col_campos","$insert_str",""); 
//    if (!$insfactu) { $can_error = $can_error + 1; }
//  }

  if ($evento==1226) {
    $tipcp = "O";
    if ($vcant_hro>0) {$delfactu = $resulage=pg_exec("delete from $tbname_10 where nro_factura='$nfac'");}
    $vcant_hro=$vcant_hro+1;
    $delfactu = $resulage=pg_exec("delete from $tbname_10 where nro_factura='$nfac'");
    $insfactu   = true;
    $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede,cant_mprensa,cant_pprensa,tipo_anotamar,cant_anotamar,cant_cambtitu,cant_cambdomi,cant_oposicion,cant_oposhabil,cant_cphabil";
    $insert_str = "'$nfac','$fechafac',0,0,0,'$sede',0,0,'$tipcp',0,0,0,0,$vcant_hro,0";    

    $insfactu   = $sql->insert("$tbname_10","$col_campos","$insert_str",""); 
    if (!$insfactu) { $can_error = $can_error + 1; }
  }

  if (($evento==1260) || ($evento==1261) || ($evento==1262) || ($evento==1263) || ($evento==1264) || ($evento==1265)) {
    if ($vcant_cp>0) {$delfactu = $resulage=pg_exec("delete from $tbname_10 where nro_factura='$nfac'");}
    $vcant_cp=$vcant_cp+1;
    $delfactu = $resulage=pg_exec("delete from $tbname_10 where nro_factura='$nfac'");
    $insfactu   = true;
    $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede,cant_mprensa,cant_pprensa,tipo_anotamar,cant_anotamar,cant_cambtitu,cant_cambdomi,cant_oposicion,cant_oposhabil,cant_cphabil";
    $insert_str = "'$nfac','$fechafac',0,0,0,'$sede',0,0,'$tipcp',0,0,0,0,0,$vcant_cp";    

    $insfactu   = $sql->insert("$tbname_10","$col_campos","$insert_str",""); 
    if (!$insfactu) { $can_error = $can_error + 1; }
  }
// =======================================================================================================================

// Evento de Pago de Derechos en Dolares 
if ($evento==1794) {
  $resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento IN (1066)");
  $filas_found=pg_numrows($resul); 
  if ($filas_found!=0) {
    $reg66 = pg_fetch_array($resul);
    $fechaev66 = trim($reg66['fecha_event']);
    //echo "fecha= $fechaev66";
  } 
}  

// Verificacion y actualizacion real de los Datos en BD 
 if ($actprim and $instram) {
   pg_exec("COMMIT WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();
   
   $smarty->display('encabezado1.tpl');
   Mensajenew("DATOS GUARDADOS CORRECTAMENTE !!!","m_eveind.php?nconex=".$nconex."&conx=0",'S');
   $smarty->display('pie_pag.tpl'); exit();
 }
 else {
   pg_exec("ROLLBACK WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();

   if (!$actprim) { $error_pri  = " - Maestra "; } 
   if (!$instram) { $error_tra  = " - Tr&aacute;mite "; }
   mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_pri $error_tra  ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit();
 }

//Desconexion de la Base de Datos
//$sql->disconnect();

//$smarty->display('encabezado1.tpl');
//Mensajenew("DATOS GUARDADOS CORRECTAMENTE !!!","m_eveind.php?nconex=".$nconex."&conx=0",'S');
//$smarty->display('pie_pag.tpl');

?>
