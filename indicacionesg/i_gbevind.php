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
// Programa: i_gbevind.php 
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
$tbname_u = "stiindig";
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

$evento = $evento+3000;
$estatus= $estatus+3000;

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
      { if ($evento==3025) 
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
      mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario','i_eveind.php','N');
  	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }
}

pg_exec("BEGIN WORK");
$actprim = true;
if ($tipo_evento == "M") {
  if ($evento != 3020)
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
if ($evento == 3124)
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

if ($evento==3167) {
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
// =======================================================================================================================

// Verificacion y actualizacion real de los Datos en BD 
 if ($actprim and $instram) {
   pg_exec("COMMIT WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();
   
   $smarty->display('encabezado1.tpl');
   Mensajenew("DATOS GUARDADOS CORRECTAMENTE !!!","i_eveind.php?nconex=".$nconex."&conx=0",'S');
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

?>
