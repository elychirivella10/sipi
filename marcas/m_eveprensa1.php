<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function buscarprensa(var1,var2,var3,var4,var5,var6) { 
  open("adm_mprensa.php?vsol="+var1.value+"-"+var2.value+"&vmod="+var3.value+"&vcod="+var4.value+"&vbol="+var5.value+"&vtot="+var6.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function buscarprensap(var1,var2,var3,var4,var5,var6,var7) { 
  open("adm_pprensa.php?vsol="+var1.value+"-"+var2.value+"&vmod="+var3.value+"&vcod="+var4.value+"&vbol="+var5.value+"&vtot="+var6.value+"&npub="+var7.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

 
</script>
<?php
// *************************************************************************************
// Programa: m_eveprensa.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinaci�n de Inform�tica / Direcci�n de Soporte Administrativo / SAPI / MICO
// A�o 2015 I Semestre
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include ("../setting.mysql.php"); 
include("$include_lib/class.phpmailer.php"); 

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
$tbname_8  = "stmpagopren";
$tbname_9  = "stzboletin";
$tbname_10 = "stmfactura";
$tbname_11 = "stppagopren";
$tbname_12 = "stmtmppren";
$tbname_13 = "stptmppren";

$vopc      = $_GET['vopc'];
$factura   = $_POST['factura'];
$boletin   = $_POST['boletin'];
$mcantidad = $_POST['mcantidad'];
$pcantidad = $_POST['pcantidad'];
$email     = $_POST['email'];

$vsola=$vsol1."-".sprintf("%06d",$vsol2);
$vsolb=$vsol3."-".sprintf("%06d",$vsol4);
$resultado=false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Relaci&oacute;n de Solicitudes a Publicar en Prensa');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('modo2','readonly');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==4) {
  $factura   = $_POST["factura"];
  $del_datos = $sql->del("$tbname_12","factura='$factura'");
  $del_datos = $sql->del("$tbname_13","factura='$factura'");

  $nfactura = 'F0'.$factura;
  $obj_query = $sql->query("SELECT * FROM $tbname_10 WHERE nro_factura='$nfactura'");
  $obj_filas = $sql->nums('',$obj_query);

  if ($obj_filas!=0) {
    $objs = $sql->objects('',$obj_query);
    $mprensa = trim($objs->cant_mprensa);
    $pprensa = trim($objs->cant_pprensa);
    mensajenew('ERROR: Factura '.$nfactura.' YA usado anteriormente con '.$mprensa.' y '.$pprensa.' solicitud(es) de Marcas y Patentes respectivamente a Publicar en Prensa ...!!!','javascript:history.back();','N');
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
  $vfechavenc = trim($objs->fecha_2meses);
  if ($vfechavenc=='') {  
    mensajenew('ERROR: Bolet&iacute;n No. '.$boletin.' NO ha entrado en vigencia aun o no ha sido actualizado aun ...!!!','javascript:history.back();','N');
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
  
  $ftotal   = explode(".",$objsfac->fac_total);
  $factotal = $ftotal[0];
  $ftotal   = explode(".",$objsfac->fac_total);
  $factotal = $objsfac->fac_total; 

  $anno = substr($fechafac,0,4);
  $mes  = substr($fechafac,5,2);
  $dia  = substr($fechafac,8,2);
  $vfechafactura = $dia.'/'.$mes.'/'.$anno; 
  $esmayor=compara_fechas($vfechafactura,$vfechavenc);
  //if ($esmayor==1) {
  //  mensajenew("ERROR: Pago de Publicacion en Prensa Extemporaneo ...!!!","javascript:history.back();","N");
  //  $smarty->display('pie_pag.tpl'); exit(); }

  $cant_facm = 0;
  $cant_facp = 0;
  //Datos del Detalle 
  $objdetalle = $mysql->query_mysql("SELECT dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id='044' AND fac_id=$fac_id"); 
  $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
  if ($objtotdtalle==0) {
    mensajenew('ERROR: Factura NO presenta ning&uacute;n servicio de Publicacion en Prensa marca ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  if ($objtotdtalle!=0) {
    $objsdta = $mysql->objects_mysql('',$objdetalle);
    $cant_facm = $objsdta->dtalle1_cantidad_ser; }

  $objdetalle = $mysql->query_mysql("SELECT dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id='048' AND fac_id=$fac_id"); 
  $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
  if ($objtotdtalle==0) {
    mensajenew('ERROR: Factura NO presenta ning&uacute;n servicio de Publicaci&oacute;n en Prensa patente ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  if ($objtotdtalle!=0) {
    $objsdta = $mysql->objects_mysql('',$objdetalle);
    $cant_facp = $objsdta->dtalle1_cantidad_ser; }

  $canttotal = $mcantidad + $pcantidad;
  $cant_fac = $cant_facm + $cant_facp;

  if ($canttotal!=$cant_fac) {
    mensajenew('ERROR: El Numero de Solicitudes no coincide con la cantidad total indicado en la Factura ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  
  $montom = 0; 
  $montop = 0;
  $montototal = 0;
  $objservicio = $mysql->query_mysql("SELECT ser_precios FROM sfa_servicios WHERE ser_id='044'"); 
  $objsser = $mysql->objects_mysql('',$objservicio); 
  $pagoser  = explode(".",$objsser->ser_precios);
  $pagomar  = $pagoser[0]; 
  $montom = ($mcantidad * $pagomar);

  $objservicio = $mysql->query_mysql("SELECT ser_precios FROM sfa_servicios WHERE ser_id='048'"); 
  $objsser = $mysql->objects_mysql('',$objservicio); 
  $pagoser  = explode(".",$objsser->ser_precios);
  $pagopat  = $pagoser[0]; 
  $montop = ($pcantidad * $pagopat);

  $montototal = $montom + $montop;
  if ($montototal <= $factotal) { }
  else {
    mensajenew('ERROR: El Monto total cancelado NO coincide con el monto de multiplicar el costo del servicios por Numero de Solicitudes de Marcas y/o Patentes indicado en la Factura ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

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
  $smarty->assign('mcantidad',$mcantidad);  
  $smarty->assign('pcantidad',$pcantidad);
  $smarty->assign('total',$cant_fac);  
  $smarty->assign('pagoreg',$pagomar);
  $smarty->assign('factotal',$factotal);
  $smarty->assign('email',$email);
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
  $mcantidad  = $_POST['mcantidad'];
  $pcantidad  = $_POST['pcantidad'];
  $total      = $_POST['total'];
  $pagoreg    = $_POST['pagoreg'];
  $boletin    = $_POST['boletin'];
  $factotal   = $_POST['factotal'];
  $email      = $_POST['email'];

  $obj_query = $sql->query("SELECT * FROM $tbname_9 WHERE nro_boletin=$boletin");
  $objs = $sql->objects('',$obj_query);
  $vfechavenc = trim($objs->fecha_2meses);

  //Proceso de grabado de Solicitudes de Marcas
  if ($mcantidad!=0) {
    $resultado=pg_exec("SELECT * FROM $tbname_12 WHERE factura ='$factura' AND boletin=$boletin");
    $filas_found=pg_numrows($resultado);    
    if ($filas_found==0) {
      mensajenew('ERROR: No introdujo ning�n valor de Solicitud(es) de Marcas asociado(s) a la Factura y Bolet&iacute;n ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    if ($filas_found < $mcantidad) {
      mensajenew('ERROR: No introdujo la cantidad exacta de Solicitud(es) de Marcas asociado(s) a la Factura ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    $plazo_ley = 1;
    $tipo_plazo = "H";
    $errorgrabar = 0;
    for ($cont=0;$cont<$filas_found;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $instram1 = true;
       $vder = $reg[nro_derecho];
       $facdoc = substr($factura,2,6);
       $vsol = $reg[solicitud];

       $res_der=pg_exec("SELECT tipo_derecho,estatus FROM $tbname_7 WHERE nro_derecho='$vder'");
       $resder = pg_fetch_array($res_der);
       $vest = $resder['estatus'];

       $tiempolegal="S";
       $horactual=hora();
       $horactual1=$horactual;
       $topehora  = Compara_Hora($horactual,$horatope); 
       if ($topehora==1) { 
         $fechapub = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/"); }
       else {
         $plazo_ley = 2;
         $tiempolegal="N";
         $horactual1 = "08:30:00 AM";
         $fechapub  = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/"); 
       }

       $vext="N";
       $esmayor=compara_fechas($fechapub,$vfechavenc);
       if ($esmayor==1) { $vext="S"; }

       //Inserto Datos en la tabla Temporal de Pagos  
       $col_campos = "factura,nro_derecho,solicitud,boletin,estatus,usuario,fecha_carga,hora_carga,fecha_publi,publicada,extemporanea,hora_publi,fecha_fac";
       if ($tiempolegal=="S") { 
         $insert_str = "'$factura',$vder,'$vsol',$boletin,'C','$usuario','$fechahoy','$horactual','$fechapub','N','$vext','$horactual1','$fechafac'"; }
       else {
         $insert_str = "'$factura',$vder,'$vsol',$boletin,'C','$usuario','$fechahoy','$horactual','$fechapub','N','$vext','$horactual1','$fechafac'"; }
       $instram1 = $sql->insert("$tbname_8","$col_campos","$insert_str",""); 

       if ($instram1) { }  
       else {
         $errorgrabar = $errorgrabar+1; }
    }  
  }

  //Proceso de grabado de Solicitudes de Patentes
  if ($pcantidad!=0) {
    $resultado=pg_exec("SELECT * FROM $tbname_13 WHERE factura ='$factura' AND boletin=$boletin");
    $filas_found=pg_numrows($resultado);    
    if ($filas_found==0) {
      mensajenew('ERROR: No introdujo ning�n valor de Solicitud(es) de Patentes asociado(s) a la Factura y Bolet&iacute;n ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    if ($filas_found < $pcantidad) {
      mensajenew('ERROR: No introdujo la cantidad exacta de Solicitud(es) de Marcas asociado(s) a la Factura ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    $tipo_plazo = "H";
    $errorgrabar = 0;
    for ($cont=0;$cont<$filas_found;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $instram2 = true;
       $vder = $reg[nro_derecho];
       $facdoc = substr($factura,2,6);
       $vsol = $reg[solicitud];
       $npub = $reg[nro_publica];

       $res_der=pg_exec("SELECT tipo_derecho,estatus FROM $tbname_7 WHERE nro_derecho='$vder'");
       $resder = pg_fetch_array($res_der);
       $vest = $resder['estatus'];

       if ($npub==4) {
         //Inserto Datos en la tabla Temporal de Pagos  
         $col_campos = "factura,nro_derecho,solicitud,boletin,estatus,usuario,fecha_carga,hora_carga,fecha_publi,publicada,nro_publica,extemporanea,hora_publi,fecha_fac";
         //Primera Publicacion
         $plazo_ley = 1;
         $tiempolegal="S";
         $horactual=hora();
         $horactual1=$horactual;
         $topehora  = Compara_Hora($horactual,$horatope); 
         if ($topehora==1) { 
           $fechapub1 = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/"); }
         else {
           $plazo_ley = 2;
           $tiempolegal="N";
           $horactual1 = "08:30:00 AM";
           $fechapub1 = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/");
         }
         $vext="N";
         $esmayor=compara_fechas($fechapub1,$vfechavenc);
         if ($esmayor==1) { $vext="S"; }
         $insert_str = "'$factura',$vder,'$vsol',$boletin,'C','$usuario','$fechahoy','$horactual','$fechapub1','N',1,'$vext','$horactual1','$fechafac'"; 
         $instram2 = $sql->insert("$tbname_11","$col_campos","$insert_str","");
         if ($instram2) { }  
         else {
           $errorgrabar = $errorgrabar+1; }
         //Segunda Publicacion
         //$plazo_ley = 12;
         $plazo_ley = 10;
         $horactual=hora();
         //if ($tiempolegal=="N") { $plazo_ley = $plazo_ley + 1; }
         $plazo_ley = $plazo_ley + 1;
         //$fechapub2 = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/");
         $fechapub2 = calculo_fechas($fechapub1,$plazo_ley,$tipo_plazo,"/");
         $vext="N";
         $esmayor=compara_fechas($fechapub2,$vfechavenc);
         if ($esmayor==1) { $vext="S"; }
         $insert_str = "'$factura',$vder,'$vsol',$boletin,'C','$usuario','$fechahoy','$horactual','$fechapub2','N',2,'$vext','$horactual1','$fechafac'"; 
         $instram2 = $sql->insert("$tbname_11","$col_campos","$insert_str","");
         if ($instram2) { }  
         else {
           $errorgrabar = $errorgrabar+1; }
         //Tercera Publicacion
         //$plazo_ley = 23;
         $plazo_ley = 10;
         $horactual=hora();
         //if ($tiempolegal=="N") { $plazo_ley = $plazo_ley + 1; }
         $plazo_ley = $plazo_ley + 1;
         //$fechapub3 = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/");
         $fechapub3 = calculo_fechas($fechapub2,$plazo_ley,$tipo_plazo,"/");
         $vext="N";
         $esmayor=compara_fechas($fechapub3,$vfechavenc);
         if ($esmayor==1) { $vext="S"; }
         $insert_str = "'$factura',$vder,'$vsol',$boletin,'C','$usuario','$fechahoy','$horactual','$fechapub3','N',3,'$vext','$horactual1','$fechafac'"; 
         $instram2 = $sql->insert("$tbname_11","$col_campos","$insert_str","");
         if ($instram2) { }  
         else {
           $errorgrabar = $errorgrabar+1; }
        }
    }  
  }

  $insfactu = true;
  $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede,cant_mprensa,cant_pprensa";
  $insert_str = "'$factura','$fechafac',0,0,0,'$sede',$mcantidad,$pcantidad";  
  $insfactu  = $sql->insert("$tbname_10","$col_campos","$insert_str","");
  if ($insfactu) { }  
  else {
    $errorgrabar = $errorgrabar+1; }

  // Verificacion y actualizacion real de los Datos en BD 
  if ($errorgrabar == 0) {  //Validacion del Numero de Solicitud
     //$del_datos = $sql->del("$tbname_12","solicitud='$vsol' AND factura='$factura'");
     //$del_datos = $sql->del("$tbname_13","solicitud='$vsol' AND factura='$factura'");
     $del_datos = $sql->del("$tbname_12","factura='$factura'");
     $del_datos = $sql->del("$tbname_13","factura='$factura'");
     pg_exec("COMMIT WORK");
     correo($sql_mail,$solicitante,$email,$factura,$pagoreg,$factotal);    
     //Desconexion de la Base de Datos
     $sql->disconnect();
     Mensaje2("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_ingfacpren.php?vopc=1","m_rptpagprensa.php?vfac=$factura&vusr=$usuario&vsol=$solicitante&viden=$cisolicita&ftot=$factotal&vfec=$fechafac"); 

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
$smarty->assign('campo7','Cantidad de Solicitudes de Marcas a Publicar:');
$smarty->assign('campo8','Bolet&iacute;n:');
$smarty->assign('campo9','Relaci&oacute;n de Solicitudes de Marcas a Publicar:');
$smarty->assign('campo10','Relaci&oacute;n de Solicitudes de Patentes a Publicar:');
$smarty->assign('campo11','Cantidad de Solicitudes de Patentes a Publicar:');
$smarty->assign('campo12','Total Solicitudes a Publicar:');
$smarty->assign('campo13','Publicaci&oacute;n:');
$smarty->assign('campo14','Monto Pagado:');
$smarty->assign('campo15','Correo Electr&oacute;nico:');

$blanco=0;
$blanco1='';
$cont=0;
$arrayannos[$cont]=$blanco;
$arraynameano[$cont]=$Blanco1;
$valorano = $topeanno;
$vannoini = $totalannos;
for($cont=1;$cont<$vannoini;$cont++) { 
  $arrayannos[$cont]  =$valorano;
  $arraynameano[$cont]=$valorano;
  $valorano = $valorano-1;
}

//$smarty->assign('publica_id',array('N','1','2','3','4')); 
//$smarty->assign('publica_de',array(' ','Primera','Segunda','Tercera','Todas'));
$smarty->assign('publica_id',array('4')); 
$smarty->assign('publica_de',array('Todas'));

$smarty->assign('arrayannos',$arrayannos); 
$smarty->assign('arraynameano',$arraynameano);

$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('boletin',$boletin);
$smarty->assign('mcantidad',$mcantidad);
$smarty->assign('pcantidad',$pcantidad);

$smarty->display('m_eveprensa.tpl');
$smarty->display('pie_pag.tpl');

function correo($sql_mail,$nombre,$vemail,$factura,$pagoreg,$factotal) {
 $mail = new PHPMailer();
 $mail->IsSMTP();              	// enviar v�a SMTP
 $mail->Host = $sql_mail; 
 $mail->SMTPAuth = true;     	// activar la identificac�n SMTP
 $mail->Username = "msystem";  	// usuario SMTP
 $mail->Password = "M6ccs9Ve"; 	// clave SMTP

 //Verificando conexion
 $sql = new mod_db();
 $sql->connection();
 $tbname_1 = "stmpagopren";
 $tbname_2 = "stppagopren";
 $tbname_3 = "stzderec";
 $tbname_4 = "stmmarce";

 $mail->From = "adminwebpi@sapi.gob.ve";
 $mail->FromName = "Administrador del Sistema SIPI - SAPI";
 $mail->Subject = "Solicitud de Publicacion en Prensa, Factura No. ".$factura;
 
 $mail->AddAddress($vemail,$nombre);
 $mail->AddBCC('adminbusqsipi@sapi.gob.ve','Administrador SIPI');

 $body  = "<strong>Estimada(o): </strong>".$nombre." <br><br>";
 
 $body .= " Su solicitud de Publicaci&oacue;n en Prensa correspondiente a la Factura No.: ".$factura." ha sido recibida, y ser&aacute; publicada en la pr&oacute;xima publicaci&oacute;n de nuestro diario digital.<br><br>";   
  
 $body .= "<H3><I>Servicios Solicitados</I></H3><br>"; 
 $body .= "<table width='100%' border='1'>";
 $body .= " <tr>";

 $caracter='.';
 $posicion = strpos($pagoreg, $caracter);
 if ($posicion === false) { $pagoreg = $pagoreg.".00"; } 

 $subtotmar = 0;
 $obj_filas = 0;
 $obj_fone = $sql->query("SELECT $tbname_1.solicitud,$tbname_3.nombre,$tbname_4.clase,$tbname_1.fecha_publi FROM $tbname_1,$tbname_3,$tbname_4
                          WHERE factura='$factura' 
                          AND $tbname_1.nro_derecho = $tbname_3.nro_derecho 
                          AND $tbname_1.nro_derecho = $tbname_4.nro_derecho 
                          AND $tbname_3.tipo_mp='M' 
                          ORDER BY $tbname_1.solicitud");

 $obj_filas = $sql->nums('',$obj_fone);
 if ($obj_filas>0) {
   $body .= "   <tr>";
   $body .= "     <td colspan='5' align='left'><b><H3><I>Marcas a Publicar</I></H3></b></td>";
   $body .= "   </tr>";
   $body .= "   <tr>";
   $body .= "     <td width='14%' align='left'><b>Solicitud</b></td>";
   $body .= "     <td width='58%' align='left'><b>Nombre</b></td>";
   $body .= "     <td width='08%' align='left'><b>Clase</b></td>";
   $body .= "     <td width='12%' align='left'><b>Fecha Publicaci&oacute;n</b></td>";
   $body .= "     <td width='12%' align='left'><b>Costo Bs.</b></td>";
   $body .= "   </tr>";

   $cont = 0;
   $objs = $sql->objects('',$obj_fone);
   for ($cont=0;$cont<$obj_filas;$cont++) {
     $bnombre = trim(utf8_decode($objs->nombre));
     $body .= "   <tr>";
     $body .= "     <td width='14%' align='left'>$objs->solicitud</td>";
     $body .= "     <td width='58%' align='left'>$bnombre</td>";
     $body .= "     <td width='08%' align='left'>$objs->clase</td>";
     $body .= "     <td width='12%' align='left'>$objs->fecha_publi</td>";
     $body .= "     <td width='12%' align='left'>$pagoreg</td>";
     $body .= "   </tr>";
     $subtotmar = $subtotmar + $pagoreg;
     $objs = $sql->objects('',$obj_fone); 
   }
   $caracter='.';
   $posicion = strpos($subtotmar, $caracter);
   if ($posicion === false) { $subtotmar = $subtotmar.".00"; } 
   $body .= "   <tr>";
   $body .= "     <td colspan='5' align='left'><b><I>Sub Total Bs.: $subtotmar</I></b></td>";
   $body .= "   </tr>";
 }
 $body .= " </tr>";
 $body .= "</table>";

 $body .= "<table width='100%' border='1'>";
 $body .= " <tr>";

 $subtotpat = 0;
 $obj_filas = 0;
 $obj_fone = $sql->query("SELECT $tbname_2.solicitud,$tbname_3.nombre,$tbname_2.fecha_publi FROM $tbname_2,$tbname_3
                          WHERE factura='$factura' 
                          AND $tbname_2.nro_derecho = $tbname_3.nro_derecho 
                          AND $tbname_3.tipo_mp='P' 
                          ORDER BY $tbname_2.solicitud");

 $obj_filas = $sql->nums('',$obj_fone);
 if ($obj_filas>0) {
   $body .= "   <tr>";
   $body .= "     <td colspan='4' align='left'><b><H3><I>Patentes a Publicar</I></H3></b></td>";
   $body .= "   </tr>";
   $body .= "   <tr>";
   $body .= "     <td width='14%' align='left'><b>Solicitud</b></td>";
   $body .= "     <td width='60%' align='left'><b>Titulo</b></td>";
   $body .= "     <td width='12%' align='left'><b>Fecha Publicaci&oacute;n</b></td>";
   $body .= "     <td width='12%' align='left'><b>Costo Bs.</b></td>";
   $body .= "   </tr>";

   $cont = 0;
   $objs = $sql->objects('',$obj_fone);
   for ($cont=0;$cont<$obj_filas;$cont++) {
     $bnombre = trim(utf8_decode($objs->nombre));
     $body .= "   <tr>";
     $body .= "     <td width='14%' align='left'>$objs->solicitud</td>";
     $body .= "     <td width='60%' align='left'>$bnombre</td>";
     $body .= "     <td width='12%' align='left'>$objs->fecha_publi</td>";
     $body .= "     <td width='08%' align='left'>$pagoreg</td>";
     $body .= "   </tr>";
     $subtotpat = $subtotpat + $pagoreg;
     $objs = $sql->objects('',$obj_fone); 
   }
   $caracter='.';
   $posicion = strpos($subtotpat, $caracter);
   if ($posicion === false) { $subtotpat = $subtotpat.".00"; } 
   $body .= "   <tr>";
   $body .= "     <td colspan='4' align='left'><b><I>Sub Total Bs.: $subtotpat</I></b></td>";
   $body .= "   </tr>";
 }

 $body .= " </tr>";
 $body .= "</table>";
 $grantotal = $subtotmar + ($subtotpat);
 $caracter='.';
 $posicion = strpos($grantotal, $caracter);
 if ($posicion === false) { $grantotal = $grantotal.".00"; } 
  $body .= "<b><I>Total Servicios Solicitados Bs.: $grantotal</I></b><br>"; 

 $body .= "<br><br>";
 $body .= "Le informamos que para poder descargar los resultados, en los correos gmail.com debe revisar la carpeta RECIBIDOS o la carpeta SPAM al hacer click en M�s; para los correos hotmail.com debe revisar la carpeta BANDEJA DE ENTRADA o la carpeta CORREO NO DESEADO.<br><br>";

 $body .= "Si desea enviarnos alg&uacute;n comentario, sugerencia o recomendaci&oacute;n comuniquese directamente con nosotros a sugerencias@sapi.gob.ve o dirijase a nuestra oficina ubicada en el ";
 $body .= " Centro Sim&oacute;n Bol&iacute;var, Edificio Norte, Piso 4, El Silencio. Al lado de la Plaza Caracas. Apto. Postal 1844 - C&oacute;d. Postal 1010 - Caracas-Venezuela.";
 $body .= " Horario de Atenci&oacute;n al P&uacute;blico: 8:00am a 1:30pm. o por nuestra Central Telef&oacute;nica (0212) 481.64.78 / 484.29.07<br><br>"; 
 $body .= " Para mayor informaci&oacute;n consulte nuestra pagina <strong>www.sapi.gob.ve</strong>";
 $body .= "<br><br>";
 $body .= " Ministerio del poder Popular para el Comercio - MPPC.<br/>";
 $body .= " Servicio Aut&oacute;nomo de la Propiedad Intelectual - S.A.P.I.<br/>";
 $body .= " Portal: www.sapi.gob.ve<br>";
 $body .= "<font color='red'>NOTA: Esta es una cuenta de correo NO Monitoreada, por favor no responda ni reenv&iacute;e mensajes a esta cuenta.</font>";
 $mail->Body = $body;
 $mail->AltBody = "x PHPMailer\n";

 $exito = $mail->Send();
 $intentos=1;
 while ((!$exito) && ($intentos < 5)) {
   sleep(5);
   $exito = $mail->Send();
   $intentos=$intentos+1;
 }

 if (!$exito) { echo "Problemas al enviar el correo"; }
}

?>
