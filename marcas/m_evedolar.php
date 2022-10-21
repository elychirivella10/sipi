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
	
  //mensajenew('AVISO: Contactar al Administrador del Sistema Ing. Romulo Mendoza para desbloquear y verificar Factura, Bolet&iacute;n y si es Pago en Dolares ...!!!','javascript:history.back();','N');
  //$smarty->display('pie_pag.tpl'); exit();
  
  $factura   = $_POST["factura"]; 
  //$obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE evento=1066 AND documento=$factura");
  //$obj_filas = $sql->nums('',$obj_query);
  //if ($obj_filas!=0) {
  //  mensajenew('ERROR: Factura YA usado anteriormente ...!!!','javascript:history.back();','N');
  //  $smarty->display('pie_pag.tpl'); exit(); }

  if ($factura!='221791') { 
    $nfactura = 'F0'.$factura;
    $obj_query = $sql->query("SELECT * FROM $tbname_10 WHERE nro_factura='$nfactura'");
    $obj_filas = $sql->nums('',$obj_query);

    if ($obj_filas!=0) {
      $objs = $sql->objects('',$obj_query);
      $nderecho = trim($objs->cant_derecho);
      mensajenew('ERROR: Factura '.$nfactura.' YA usado anteriormente con '.$nderecho.' solicitud(es) de pago(s) ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
  }     
 
  //echo "fac=$nfactura";
  if (($nfactura!='F0161681') && ($nfactura!='F0162089') && ($nfactura!='F0161842') && ($nfactura!='F0173580') && ($nfactura!='F0180299') && ($nfactura!='F0184639') && ($nfactura!='F0201227') && ($nfactura!='F0221791')) { 
    $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE factura='$nfactura' AND estatus='G'");
    $obj_filas = $sql->nums('',$obj_query);
    //Requerimiento por Castiela Velasquez pagaron 37 falto una por cargar por error de eduardo 
    //if ($nfactura=='F0154520') { $obj_filas=36; }
    if ($obj_filas!=0) {
      mensajenew('ERROR: Factura '.$nfactura.' YA usado anteriormente con '.$obj_filas.' solicitud(es) ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
  }
    
  $obj_query = $sql->query("SELECT * FROM $tbname_9 WHERE nro_boletin=$boletin");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas==0) {
    mensajenew('ERROR: Bolet&iacute;n No. '.$boletin.' NO ha sido generado aun o NO existe en nuestra Base de Datos ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $objs = $sql->objects('',$obj_query);
  $vfechavenc = trim($objs->fecha_ven);
  if ($vfechavenc=='') {  
    mensajenew('ERROR: Bolet&iacute;n No. '.$boletin.' NO ha entrado en vigencia aun ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }


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
  //$ftotal   = explode(".",$objsfac->fac_total);
  $factotal = $objsfac->fac_total; 
  
  //$fechafac = "09/05/2013";
  //$fechafac = "16/05/2013";  
  //$factotal = 1693.00;

  $anno = substr($fechafac,0,4);
  $mes  = substr($fechafac,5,2);
  $dia  = substr($fechafac,8,2);
  $vfechafactura = $dia.'/'.$mes.'/'.$anno; 

  //Datos del Detalle 
  $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('0107','0107E') AND fac_id=$fac_id"); 
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
 
  if($codservi=='0107') { 
    $esmayor=compara_fechas($vfechafactura,$vfechavenc);
    if ($esmayor==1) {
     mensajenew("ERROR: Pago de Derecho de Registro Extemporaneo ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }
  }
  
  //Pagaron 14 y colocaron 13 marcas ya que repetieron una dos veces. Se detectó en las pruebas de inducción por Jorge Santana 
  if ($nfactura=='F0152770') { $cant_fac=13; }
  //Requerimiento 660437 pagaron dos veces dos marcas facturas f0156651 y f0156387 Pagaron 6 
  if ($nfactura=='F0156651') { $cant_fac=4; }
  //Requerimiento 677308 pagaron dos veces una marca facturas f0155967 y f0154621 Pagaron 2 ???
  if ($nfactura=='F0155967') { $cant_fac=1; }
  //Requerimiento 371957 pagaron dos veces una marca facturas f0156484 y f0154520 Pagaron 3
  if ($nfactura=='F0156484') { $cant_fac=2; }
  //Requerimiento 649746 pagaron dos veces una marca facturas f0157155 y f0156642 Pagaron 13
  if ($nfactura=='F0157155') { $cant_fac=12; }
  //Requerimiento por Castiela Velasquez pagaron 37 falto una por cargar por error de eduardo 
  if ($nfactura=='F0154520') { $cant_fac=36; }
  //Requerimiento 815243 pagaron dos veces una marca facturas f0157100 y f0155908 Pagaron 3
  if ($nfactura=='F0157100') { $cant_fac=2; }
  //Requerimiento s/n pagaron 1 de las 3 marcas factura f0156484 (Lilian no podia cargar porque 1 de las marcas [2012-012004] ya tenia el pago cargado)
  if ($nfactura=='F0156484') { $cant_fac=2; }
  //Requerimiento 988287 pagaron 2 veces una marca factura F0151843 
  if ($nfactura=='F0161843') { $cant_fac=1; }
  //Requerimiento 628724 pagaron 13 y son 12 por estar una en estatus 8 aun 
  if ($nfactura=='F0162450') { $cant_fac=12; }
  //Requerimiento 639388 pagaron 185 y son 183 ya que pagaron las otras 2 aparte 
  if ($nfactura=='F0162250') { $cant_fac=183; }
  //Requerimiento 768126 pagaron 20 y son 15 ya que pagaron las otras 5 aparte 
  if ($nfactura=='F0162259') { $cant_fac=15; }
  //Requerimiento 916168 pagaron 2, una marca del bol 539 y otra del 540 con la misma factura  
  if ($nfactura=='F0161681') { $cant_fac=1; }
  //Requerimiento segun carta o memorandum s/fecha de administracion de andreina hernandez, pagaron 7, 4 marcas del bol 539 y 3 del 540 con la misma factura  
  if ($nfactura=='F0162089') { $cant_fac=3; }
  //Requerimiento segun carta o memorandum s/fecha de administracion de andreina hernandez, pagaron 4, 1 marca del bol 539 y 3 del 540 con la misma factura  
  if ($nfactura=='F0161842') { $cant_fac=3; }
  //Requerimiento 370567 pagaron 15 y son 14 por pagar una con otra factura 
  if ($nfactura=='F0165401') { $cant_fac=14; }
  //Requerimiento 474585 pagaron 82 y son 79 por pagar 3 con otras facturas. 
  if ($nfactura=='F0165954') { $cant_fac=79; }
  //Requerimiento 833452 pagaron 4 marcas, boletines 540 y 541, cada uno con dos derechos 
  if ($nfactura=='F0164727') { $cant_fac=2; }
  //Requerimiento 522707 pagaron 17 y son 16 por pagar una con otra factura 
  if ($nfactura=='F0167478') { $cant_fac=16; }
  //Requerimiento 2014012726 pagaron 5 y cargaron solo 1 faltando el resto por cargar 
  if ($nfactura=='F0169148') { $cant_fac=4; }
  //Requerimiento 2014012809 pagaron 5 y son 3 por doble facturacion en dos 
  if ($nfactura=='F0169633') { $cant_fac=3; }
  //Requerimiento 2014012809 pagaron 20 y son 19 por doble facturacion en una  
  if ($nfactura=='F0168689') { $cant_fac=19; }
  //Requerimiento 2014012872 pagaron 4 y son 2  
  if ($nfactura=='F0168591') { $cant_fac=2; }
  //Requerimiento 2014012872 pagaron 12 y son 11  
  if ($nfactura=='F0157155') { $cant_fac=11; }
  //Requerimiento 2014012996 pagaron 13 y son 12 una esta en 101. 
  if ($nfactura=='F0172186') { $cant_fac=12; }
  //Requerimiento 2014013133 pagaron 8, 6 son del boletin 543 y 2 del 544. 
  if ($nfactura=='F0173580') { $cant_fac=2; }
  //Requerimiento 2014013189 pagaron 10 y fueron 9. 
  if ($nfactura=='F0173482') { $cant_fac=9; }
  //Requerimiento 2014013276 pagadas=2 y es 1. Se volvio a cambiar s/req 2014013286 
  if ($nfactura=='F0174211') { $cant_fac=2; }
  //Requerimiento 2014013276 pagadas=13 y son 12 por estar una en estatus 8. 
  if ($nfactura=='F0177240') { $cant_fac=12; }
  //Requerimiento 2014013283 pagadas=15 y son 14 por estar ya pagada, doble pago. 
  if ($nfactura=='F0177981') { $cant_fac=14; }
  //Requerimiento 2014013286 pagadas=10 y son 9 
  if ($nfactura=='F0176733') { $cant_fac=9; }
  //Requerimiento 2014013517  
  if ($nfactura=='F0179719') { $cant_fac=3; } //pagadas 4 dejar en 3 (1 solicitud esta en estatus 8)
  if ($nfactura=='F0180072') { $cant_fac=3; } //pagadas 4 dejar en 3 (1 solicitud con doble pago)
  if ($nfactura=='F0180165') { $cant_fac=3; } //pagadas 5 dejar en 3 (2 solicitudes con doble pago)
  if ($nfactura=='F0180232') { $cant_fac=35; } //pagadas 36 dejar en 35 (1 solicitud con doble pago)
  if ($nfactura=='F0180299') { $cant_fac=7; } //pagadas 10 dejar en 7 (3 solicitudes con doble pago)
  //Requerimiento 2014013612  
  if ($nfactura=='F0181723') { $cant_fac=42; } //pagadas 43 dejar en 42
  if ($nfactura=='F0182850') { $cant_fac=1; } //pagadas 2 dejar en 1
  //Requerimiento 2014013724 pagaron 10, 2 tienen doble pago, 7 son del boletin 545 y 1 del 546. 
  if ($nfactura=='F0180299') { $cant_fac=1; }
  //Requerimiento 2014013733 pagaron 20, 18 son del boletin 546 y 2 del 547. 
  if ($nfactura=='F0184639') { $cant_fac=18; }
  //Requerimiento 2014013839  
  if ($nfactura=='F0186297') { $cant_fac=36; } //pagadas 37 dejar en 36
  //Requerimiento 2014013911  
  if ($nfactura=='F0187852') { $cant_fac=10; } //pagadas 11 dejar en 10
  if ($nfactura=='F0187716') { $cant_fac=2; } //pagadas 3 dejar en 2
  if ($nfactura=='F0187844') { $cant_fac=21; } //pagadas 22 dejar en 21
  if ($nfactura=='F0188228') { $cant_fac=2; } //pagadas 3 dejar en 2 por doble pago.
  if ($nfactura=='F0188187') { $cant_fac=28; } //pagadas 31 dejar en 28 por doble pago en 3.
  //Requerimiento 2014014342  
  if ($nfactura=='F0192204') { $cant_fac=27; } //pagadas 28 dejar en 27 por doble pago en 1.
  if ($nfactura=='F0192178') { $cant_fac=23; } //pagadas 24 dejar en 23 por doble pago en 1.
  if ($nfactura=='F0192328') { $cant_fac=27; } //pagadas 28 dejar en 27 por doble pago en 1.
  //Sin requerimiento: el usuario pago 1 doble por error. No le importa perder el dinero
  if ($nfactura=='F0197461') { $cant_fac=4; } //pagadas 5 dejar en 4 por doble pago en 1.
  //Sin requerimiento: 2014014749 el usuario pago 1 solicitud mal
  if ($nfactura=='F0201227') { $cant_fac=1; } //pagadas 10 dejar en 1 por mal carga en 1.
  //Requerimiento 2015  
  if ($nfactura=='F0221791') { $cant_fac=1; } //pagadas 3 dejar en 1 por error de carga de usuario
  
  if($codservi=='0107') {  
    $objservicio = $mysql->query_mysql("SELECT ser_precios FROM sfa_servicios WHERE ser_id='0107'"); 
    $objsser = $mysql->objects_mysql('',$objservicio); 
    $pagoser  = explode(".",$objsser->ser_precios);
    $pagoreg  = $pagoser[0];
  }
  else {   
    $objservicio = $mysql->query_mysql("SELECT ser_precios FROM sfa_servicios WHERE ser_id='0107E'"); 
    $objsser = $mysql->objects_mysql('',$objservicio); 
    $pagoser  = explode(".",$objsser->ser_precios);
    $pagoreg  = $pagoser[0];
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

  //echo "valores= $factura, $solicitante, $cisolicita, $boletin, $cantidad, $pagoreg, $fechafac, $factotal, $domicilio "; 
      
  $resultado=pg_exec("SELECT solicitud,nro_derecho FROM stmpagocon WHERE factura ='$factura' AND boletin=$boletin AND estatus='C'");
  $filas_found=pg_numrows($resultado);    
  if ($filas_found == 0) {
    mensajenew('ERROR: No introdujo ningún valor de Solicitud(es) asociado(s) a la Factura y Bolet&iacute;n ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($factura=='F0221791') { $cantidad=1; } //pagadas 3 dejar en 1 por error de carga de usuario
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
       $vder = $reg[nro_derecho];
       $facdoc = substr($factura,2,6);

       $res_der=pg_exec("SELECT tipo_derecho,estatus FROM $tbname_7 WHERE nro_derecho='$vder'");
       $resder = pg_fetch_array($res_der);
       $tipo_m = $resder['tipo_derecho']; 
       $vest = $resder['estatus'];

       if (($vest==1400) || ($vest==1401) || ($vest==1402)) { //Esta bien 
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

       $obj_queryr = $sql->query("SELECT * FROM $tbname_7 WHERE registro='$vregis'");
       $obj_filasr = $sql->nums('',$obj_queryr);
       if ($obj_filasr!=0) {
       	$errorgrabar = $errorgrabar+1;
       	pg_exec("ROLLBACK WORK");
         mensajenew('ERROR: Nro de Registro '.$vregis.' YA existe en nuestra Base de Datos ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }

       $horactual=hora();
       if ($codpago=='0107E') {
       	$evento4 = 1793;
         //busqueda de evento 793 en Tramite 
         $resulev=pg_exec("SELECT * FROM $tbname_4 WHERE evento='$evento4' and nro_derecho='$vder'");
         $regev793  = pg_fetch_array($resulev);
         $comentario793=trim($regev793['comentario']);

         //Inserto Datos en la tabla de Tramite stzevtrd evento 794 
         $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
         $insert_str = "$vder,$evento3,'$fechahoy',nextval('stzevtrd_secuencial_seq'),'$vest','$fechahoy','$usuario','$mensa_automatico794',0,'$comentario793','$horactual'"; 
         $instram1 = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 
     	 }

       //Inserto Datos en la tabla de Tramite stzevtrd evento 66 
       $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
       $insert_str = "$vder,$evento1,'$fechafac',nextval('stzevtrd_secuencial_seq'),'$vest','$fechahoy','$usuario','$mensa_automatico66',$facdoc,'$comentario','$horactual'"; 
       $instram1 = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 

       $resuleve=pg_exec("SELECT fecha_event FROM stzevtrd WHERE nro_derecho='$vder' AND evento in (1122,1097) AND documento=$boletin AND estat_ant in (1101,1027)");   
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
      
       if ($instram1 AND $instram2 AND $actestat AND $actpagos) { }  
       else {
         $errorgrabar = $errorgrabar+1; }

       //echo " son $filas_found, $facdoc, $vder, $tipo_m, $mensa_automatico66, $mensa_automatico795, $comentario, $vcomenta, $vregis, $vfecvi, $vfecve,  ";
   }  
   
   if ($factura!='F0221791') {  
     $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede";
     $insert_str = "'$factura','$fechafac',0,0,$cantidad,'$sede'";  
     $insfactu   = $sql->insert("$tbname_10","$col_campos","$insert_str","");
     if ($insfactu) { }  
     else {
       $errorgrabar = $errorgrabar+1; }
   }    

   // Verificacion y actualizacion real de los Datos en BD 
   if ($errorgrabar == 0) {  //Validacion del Numero de Solicitud
     pg_exec("COMMIT WORK");
     //Desconexion de la Base de Datos
     $sql->disconnect();
     //Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_ingfacbol.php?vopc=1','S');
     //Mensaje5("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_ingfacbol.php?vopc=1","m_rptlisreg.php?vfac=$factura&vusr=$usuario","m_impcertif.php?vfac=$factura&vusr=$usuario"); 
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
