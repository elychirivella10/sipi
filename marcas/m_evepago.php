<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function buscarprensa(var1,var2,var3,var4,var5,var6) { 
  open("adm_derecho.php?vsol="+var1.value+"-"+var2.value+"&vmod="+var3.value+"&vcod="+var4.value+"&vbol="+var5.value+"&vtot="+var6.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

 
</script>
<?php
// *************************************************************************************
// Programa: m_evepago.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año 2013
// Modificacion por resoluciones con evento 97 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include ("../setting.mysql.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = trim($_SESSION['usuario_login']);
$role      = trim($_SESSION['usuario_rol']);
$sede      = $_SESSION['usuario_sede'];

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
$tbname_8  = "stmpagocon";
$tbname_9  = "stzboletin";
$tbname_10 = "stmfactura";

$vopc      = $_GET['vopc'];
$factura   = $_POST['factura'];
$boletin   = $_POST['boletin'];

$vsola=$vsol1."-".sprintf("%06d",$vsol2);
$vsolb=$vsol3."-".sprintf("%06d",$vsol4);
$resultado=false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Relaci&oacute;n de Pagos de Derechos de Registro de Marcas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('modo2','readonly');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==4) {
	
//  mensajenew('AVISO: Contactar al Administrador del Sistema Ing. Romulo Mendoza para desbloquear y verificar Factura, Bolet&iacute;n y si es Pago en Dolares ...!!!','javascript:history.back();','N');
//  $smarty->display('pie_pag.tpl'); exit();
  
  $factura   = $_POST["factura"]; 
  //$obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE evento=1066 AND documento=$factura");
  //$obj_filas = $sql->nums('',$obj_query);
  //if ($obj_filas!=0) {
  //  mensajenew('ERROR: Factura YA usado anteriormente ...!!!','javascript:history.back();','N');
  //  $smarty->display('pie_pag.tpl'); exit(); }

  $nfactura = 'F0'.$factura;
  $obj_query = $sql->query("SELECT * FROM $tbname_10 WHERE nro_factura='$nfactura'");
  $obj_filas = $sql->nums('',$obj_query);

  if ($obj_filas!=0) {
    $objs = $sql->objects('',$obj_query);
    $nderecho = trim($objs->cant_derecho);
    mensajenew('ERROR: Factura '.$nfactura.' YA usado anteriormente con '.$nderecho.' solicitud(es) de pago(s) ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
 
  $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE factura='$nfactura' AND estatus='G'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas!=0) {
    mensajenew('ERROR: Factura '.$nfactura.' YA usado anteriormente con '.$obj_filas.' solicitud(es) ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
    
  $obj_query = $sql->query("SELECT * FROM $tbname_9 WHERE nro_boletin=$boletin");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas==0) {
    mensajenew('ERROR: Bolet&iacute;n No. '.$boletin.' NO ha sido generado aun o NO existe en nuestra Base de Datos ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $objs = $sql->objects('',$obj_query);
  $vfecvigbol = trim($objs->fecha_vig); 
  $vfechavenc = trim($objs->fecha_ven);
  if ($vfechavenc=='') {  
    mensajenew('ERROR: Bolet&iacute;n No. '.$boletin.' NO ha entrado en vigencia aun ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  $esmayor=compara_fechas($fechahoy,$vfecvigbol); 
  if ($esmayor==0) {
       mensajenew('AVISO: Boletin aun NO Vigente para pagar los Derechos de Registro ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); exit();
  }

  //Verificando conexion a Mysql para consulta a facturacion
  $mysql = new mod_mysql_db(); 
  $mysql->connection_mysql();
	
  $nfac = 'F0'.$factura;
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
  //$ftotal   = explode(".",$objsfac->fac_total);
  //$factotal = $ftotal[0];
  $factotal = $objsfac->fac_total; 
  
  //$fechafac = "16/05/2013";  
  //$factotal = 1693.00;

  $anno = substr($fechafac,0,4);
  $mes  = substr($fechafac,5,2);
  $dia  = substr($fechafac,8,2);
  $vfechafactura = $dia.'/'.$mes.'/'.$anno; 

  //Datos del Detalle 
  $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('0107','0107E','0107E1','0107E2','0107E3','PGIP') AND fac_id=$fac_id"); 
  $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
  if ($objtotdtalle==0) {
    mensajenew('ERROR: Factura NO presenta ning&uacute;n servicio de Derecho de Registro de Marcas ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  if ($objtotdtalle==0) {
    mensajenew('ERROR: Factura NO presenta ning&uacute;n servicio de Derecho de Registro de Marcas ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $objsdta = $mysql->objects_mysql('',$objdetalle);
  $cant_fac = $objsdta->dtalle1_cantidad_ser;
  $codservi = $objsdta->ser_id;
  if($codservi=='0107') { $totalpag= 'Total Bolivares: '; }
  else { $totalpag= 'Total US$ : '; }

  //Validacion por Requerimiento 2014024813 15/05/2019 por Avisos Oficiales DG-001-2019 - DG-003-2019
  if ($codservi=='0107') { 
    $esmayor=compara_fechas($vfechafactura,$vfechavenc);
    //$esmayor1=compara_fechas($vfechafactura,$vfechavenc);
    if ($esmayor==1) {
     //Bloqueado en Noviembre por SIRE 2014025912 de Kilber para desactivar dicha validacion, en virtud de que no lo habian hecho.  
     //if ($boletin>=580 AND $boletin<=592) { }
     //if ($boletin>=1 AND $boletin<=2) { }
     if ($boletin>=598 AND $boletin<=599) { }
     else {
       mensajenew('AVISO: Fecha de Vencimiento Extemporanea, ya pasaron los (30) d&iacute;as de plazo para pagar los Derechos de Registro ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); exit();
     }
     //mensajenew("ERROR: Pago de Derecho de Registro Extemporaneo ...!!!","javascript:history.back();","N");
     //$smarty->display('pie_pag.tpl'); exit(); 
    }
  }

  //Validacion por Requerimiento 2014024813 15/05/2019 por Avisos Oficiales DG-001-2019 - DG-003-2019
  if (($codservi=='0107E') || ($codservi=='0107E1') || ($codservi=='0107E2') || ($codservi=='0107E3') || ($codservi=='PGIP')) { 
    $esmayor=compara_fechas($vfechafactura,$vfechavenc);
    if ($esmayor==1) {
     //if ($boletin>=580 AND $boletin<=592) { }
     //if ($boletin>=1 AND $boletin<=2) { }
     if ($boletin>=598 AND $boletin<=599) { }
     else {
       mensajenew('AVISO: Fecha de Vencimiento Extemporanea, ya pasaron los (30) d&iacute;as de plazo para pagar los Derechos de Registro ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); exit();
     }
     //mensajenew("ERROR: Pago de Derecho de Registro Extemporaneo ...!!!","javascript:history.back();","N");
     //$smarty->display('pie_pag.tpl'); exit(); 
    }
  }
  
  if($codservi=='0107') {  
    $objservicio = $mysql->query_mysql("SELECT ser_precios FROM sfa_servicios WHERE ser_id='0107'"); 
    $objsser = $mysql->objects_mysql('',$objservicio); 
    $pagoser  = explode(".",$objsser->ser_precios);
    $pagoreg  = $pagoser[0];
  }
  else {   
    //Modificado-Corregido 19/03/2019 
    //$objservicio = $mysql->query_mysql("SELECT ser_precios FROM sfa_servicios WHERE ser_id IN ('0107E','0107E1','0107E2','0107E3','PGIP')"); 
    $objservicio = $mysql->query_mysql("SELECT ser_precios FROM sfa_servicios WHERE ser_id='$codservi'"); 
    $objsser = $mysql->objects_mysql('',$objservicio); 
    $pagoser  = explode(".",$objsser->ser_precios);
    $pagoreg  = $pagoser[0];
  }

  //if ($nfac=='F0453960') { $cant_fac=5; }

  if ($nfac=='F0492089') {
  	 //$pagopat   = 4578903.63;
  	 //$factotal  = 4578903.63;
  	 $cant_fac  = 1;
  }  

  if ($nfac=='F0491677') {
  	 //$pagopat   = 9122951.62;
  	 //$factotal  = 9122951.62;
  	 $cant_fac  = 2;
  }  

  //Datos del Cliente 
  $objcliente = $mysql->query_mysql("SELECT cli_rifci,cli_nombre,cli_direccion,cli_tlfn1 FROM sfa_cliente WHERE cli_id=$cli_id"); 
  $objtotclie = $mysql->nums_mysql('',$objcliente);
  $objsdta = $mysql->objects_mysql('',$objcliente);
  $crifci  = $objsdta->cli_rifci;
  $nombre  = $objsdta->cli_nombre;
  $domicilio = $objsdta->cli_direccion;
  $telefono  = $objsdta->cli_tlfn1;
  
  $smarty->assign('factura',$nfac);
  $smarty->assign('fechafac',$fechafac);
  $smarty->assign('cisolicita',$crifci);
  $smarty->assign('solicitante',$nombre);  
  $smarty->assign('domicilio',$domicilio);
  $smarty->assign('telefono',$telefono);
  $smarty->assign('cantidad',$cant_fac);  
  $smarty->assign('pagoreg',$pagoreg);
  $smarty->assign('factotal',$factotal);
  $smarty->assign('totalpag',$totalpag);  
  $smarty->assign('codpago',$codservi);  
  $smarty->assign('modo1','readonly=readonly');
}   

//Verificando conexion
$sql->connection();

 if ($vopc==2) {
  $factura    = $_POST['factura'];
  $fechafac   = $_POST['fechafac'];
  $solicitante= $_POST['solicitante'];
  $cisolicita = $_POST['cisolicita'];
  $domicilio  = $_POST['domicilio'];
  $telefono   = $_POST['telefono'];
  $cantidad   = $_POST['cantidad'];
  $pagoreg    = $_POST['pagoreg'];
  $boletin    = $_POST['boletin'];
  $factotal   = $_POST['factotal'];
  $totalpag   = $_POST['totalpag'];  
  $codpago    = $_POST['codpago'];  

  $resultado=pg_exec("SELECT solicitud,nro_derecho FROM stmpagocon WHERE factura ='$factura' AND boletin=$boletin AND estatus='C'");
  $filas_found=pg_numrows($resultado);    
  if ($filas_found == 0) {
    mensajenew('ERROR: No introdujo ningún valor de Solicitud(es) asociado(s) a la Factura y Bolet&iacute;n ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($filas_found < $cantidad) {
    mensajenew('ERROR: No introdujo la cantidad exacta de Solicitud(es) asociado(s) a la Factura ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

   $evento1 = 1066;
   //busqueda de evento 66
   $resul=pg_exec("SELECT * FROM $tbname_2 WHERE evento='$evento1'");
   $regeve  = pg_fetch_array($resul);
   $mensa_automatico66=trim($regeve['mensa_automatico']);

   $evento2 = 1795;
   //busqueda de evento 795
   $resul=pg_exec("SELECT * FROM $tbname_2 WHERE evento='$evento2'");
   $regeve  = pg_fetch_array($resul);
   $mensa_automatico795=trim($regeve['mensa_automatico']);

   $evento3 = 1794;
   //busqueda de evento 794
   $resul=pg_exec("SELECT * FROM $tbname_2 WHERE evento='$evento3'");
   $regeve  = pg_fetch_array($resul);
   $mensa_automatico794=trim($regeve['mensa_automatico']);

   $errorgrabar = 0;
   for ($cont=0;$cont<$filas_found;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $instram1 = true;
       $instram2 = true;
       $actestat = true;
       $actpagos = true;
       $instram792 = true;
       $instram793 = true;
       
       $vder = $reg[nro_derecho];
       $facdoc = substr($factura,2,6);

       $res_der=pg_exec("SELECT tipo_derecho,estatus FROM $tbname_7 WHERE nro_derecho='$vder'");
       $resder = pg_fetch_array($res_der);
       $tipo_m = $resder['tipo_derecho']; 
       $vest = $resder['estatus'];

       if (($vest==1400) || ($vest==1401) || ($vest==1402) || ($vest==1404)) { //Esta bien 
       } else {
         mensajenew('ERROR: La solicitud ha sido modificada de Estatus por otro usuario ...!!!','javascript:history.back();','N');
  	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
       }
       
       $res_mod=pg_exec("SELECT clase FROM stmmarce WHERE nro_derecho='$vder'");
       $resmod = pg_fetch_array($res_mod);
       $comentario = trim($resmod['clase']);
       
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

       //Se obtiene el proximo valor del registro de acuerdo al tipo de marca 
       $sys_actual = next_sys("$tnumera");
       $vnumreg = grabar_sys("$tnumera",$sys_actual);
       $vregis  = $letrareg.sprintf("%06d",$vnumreg);
       $vcomenta = "REGISTRO NUMERO: ".$vregis;
       echo "Reg= $vcomenta";
       
       $obj_queryr = $sql->query("SELECT * FROM $tbname_7 WHERE registro='$vregis'");
       $obj_filasr = $sql->nums('',$obj_queryr);
       if ($obj_filasr!=0) {
       	$errorgrabar = $errorgrabar+1;
       	pg_exec("ROLLBACK WORK");
         mensajenew('ERROR: Nro de Registro '.$vregis.' YA existe en nuestra Base de Datos ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }

       $horactual=hora();
       if (($codpago=='0107E') || ($codpago=='0107E1') || ($codpago=='0107E2') || ($codpago=='PGIP')) {

       	$evento4 = 1793;
       	$comentario793="";
         //busqueda de evento 793 en Tramite 
         $resulev=pg_exec("SELECT * FROM $tbname_4 WHERE evento='$evento4' AND nro_derecho='$vder'");
         $obj_fil793 = $sql->nums('',$resulev);
         if ($obj_fil793!=0) {
           $regev793  = pg_fetch_array($resulev);
           $comentario793=trim($regev793['comentario']);
         }
         
       	$evento5 = 1792;
       	$comentario792 = "";
         //busqueda de evento 792 en Tramite 
         $resulev792=pg_exec("SELECT * FROM $tbname_4 WHERE evento='$evento5' AND nro_derecho='$vder'");
         $obj_fil792 = $sql->nums('',$resulev792);
         if ($obj_fil792!=0) {
           $regev792  = pg_fetch_array($resulev792);
           $comentario792=trim($regev792['comentario']);
         }      

         if ($obj_fil793!=0) {
           //Inserto Datos en la tabla de Tramite stzevtrd evento 794 
           $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
           $insert_str = "$vder,$evento3,'$fechahoy',nextval('stzevtrd_secuencial_seq'),'$vest','$fechahoy','$usuario','$mensa_automatico794',0,'$comentario793','$horactual'"; 
           $instram793 = $sql->insert("$tbname_4","$col_campos","$insert_str","");
         }

         if ($obj_fil792!=0) {
           //Inserto Datos en la tabla de Tramite stzevtrd evento 794 
           $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
           $insert_str = "$vder,$evento3,'$fechahoy',nextval('stzevtrd_secuencial_seq'),'$vest','$fechahoy','$usuario','$mensa_automatico794',0,'$comentario792','$horactual'"; 
           $instram792 = $sql->insert("$tbname_4","$col_campos","$insert_str","");
         }
     	 }

       //Inserto Datos en la tabla de Tramite stzevtrd evento 66 
       $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
       $insert_str = "$vder,$evento1,'$fechafac',nextval('stzevtrd_secuencial_seq'),'$vest','$fechahoy','$usuario','$mensa_automatico66',$facdoc,'$comentario','$horactual'"; 
       $instram1 = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 

       $resuleve=pg_exec("SELECT fecha_event FROM stzevtrd WHERE nro_derecho='$vder' AND evento in (1122,1097) AND documento=$boletin AND estat_ant in (1101,1027,1127,1029)");   
       $regconc = pg_fetch_array($resuleve);
       $vfecvi = $regconc[fecha_event];

       if ($boletin >= 496) { $plazoley = 15; }  
       $vfecve= calculo_fechas($vfecvi,$plazoley,"A","/");

       //Inserto Datos en la tabla de Tramite stzevtrd evento 795 
       $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,fecha_venc,documento,comentario,hora";
       $insert_str = "$vder,$evento2,'$vfecvi',nextval('stzevtrd_secuencial_seq'),1410,'$fechahoy','$usuario','$mensa_automatico795','$vfecve','$pagoreg','$vcomenta','$horactual'";
       $instram2 = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 
          
       //Actualizo la maestra en estatus a 555 
       $update_str = "registro='$vregis',estatus=1555,fecha_regis='$vfecvi',fecha_venc='$vfecve'";
       $actestat = $sql->update("$tbname_7","$update_str","nro_derecho=$vder");

       //Actualizo el control de pagos realizados  
       $update_str = "estatus='G'";
       $actpagos = $sql->update("$tbname_8","$update_str","factura='$factura' AND nro_derecho=$vder"); 
      
       if ($instram1 AND $instram2 AND $actestat AND $actpagos AND $instram792 AND $instram793) { }  
       else {
         $errorgrabar = $errorgrabar+1; }
   }  
   
   $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede";
   $insert_str = "'$factura','$fechafac',0,0,$cantidad,'$sede'";  
   $insfactu   = $sql->insert("$tbname_10","$col_campos","$insert_str","");
   if ($insfactu) { }  
   else {
     $errorgrabar = $errorgrabar+1; }

   // Verificacion y actualizacion real de los Datos en BD 
   if ($errorgrabar == 0) {  //Validacion del Numero de Solicitud
     pg_exec("COMMIT WORK");
     //Desconexion de la Base de Datos
     $sql->disconnect();
     Mensaje2("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_ingfacbol.php?vopc=1","m_rptregpag1.php?vfac=$factura&vusr=$usuario&vsol=$solicitante&viden=$cisolicita&ftot=$factotal&vfec=$fechafac&tpag=$totalpag"); 
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
$smarty->assign('campo1','Factura No.:');
$smarty->assign('campo2','Fecha de Factura:');
$smarty->assign('campo3','Nombre o Raz&oacute;n Social:');
$smarty->assign('campo4','C.I. &oacute; Rif.:');
$smarty->assign('campo5','Domicilio:');
$smarty->assign('campo6','Telefono:');
$smarty->assign('campo7','Cantidad de Registros Pagados:');
$smarty->assign('campo8','Bolet&iacute;n:');
$smarty->assign('campo9','Relaci&oacute;n de Solicitudes:');

$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('boletin',$boletin);

$smarty->display('m_evepago.tpl');
$smarty->display('pie_pag.tpl');

?>
