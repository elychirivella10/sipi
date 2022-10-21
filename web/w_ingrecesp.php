<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }


function planilla(v1,v2,v3) {
  open("w_planillafp03.php?vsol="+v1.value+"&vtramt="+v2.value+"&vopc=","Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function Ventana_001 (URL){ 
  window.open(URL,"UTERRA","width=500,height=300,top=20,left=40,scrollbars=NO,titlebar=NO,menubar=YES,toolbar=NO,directories=YES,location=YES,status=NO,resizable=NO") 
} 
  
</script>
<?php
include ("../setting.inc.php");
include ("../setting.mysql.php");
//ob_start();

//Comienzo del Programa por los encabezados del reporte
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = trim($_SESSION['usuario_login']);
$role      = $_SESSION['usuario_rol'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();

$vopc = $_GET['vopc'];
$vtramt=$_POST['vtramt'];
if (empty($vtramt)) {$vtramt=$_GET['vtramt'];}
$vsol=$_POST['vsol'];
if (empty($vsol)) {$vsol=$_GET['vsol'];}
$vdoc=$_POST['vdoc'];
if (empty($vdoc)) {$vdoc=$_GET['vdoc'];}
$vcomadi=trim($_POST['vcomadi']);

//echo "docu=$vdoc,$vcomadi-$vopc";
//
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Cesion de Patente al SIPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','wingresol.vtramt'); 
$smarty->assign('modo2','readonly');

//if (($usuario!='rmendoza') AND ($usuario!='ngonzalez')) {	 
//    Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo ...!!!","../index1.php","N");
//    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
//}  

//Verificando conexion
$sql->connection($usuario);

//****************************************************************************
if ($vopc==2) {
    $vtramt=$_GET['vtramt'];
    //Cambia de estatus la solicitud en el WEBPI
    $sql->disconnect();
    $sql1 = new mod_db();
    $sql1->connection1();  

    $actual=pg_exec("UPDATE stztramite SET estatus_tra = '14'  where nro_tramite='$vtramt'");    
    $sql1->disconnect1();
      
   $sql = new mod_db();
   $sql->connection();  
   $resultado_tram = pg_exec("SELECT * FROM consulta order by solicitud ");
   $filas_resultado_tram = pg_numrows($resultado_tram); 
   $sql->disconnect(); 
   ?>

<p>&nbsp;</p>
<p align='center'><b><font > Cesiones Asociadas al Tramite No.: <?php echo $vtramt; ?> para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b> Referencia </b></td>
    <td width="30%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Nro. Registro</b></p></td> 
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Ver</b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Fecha</b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Hora</b></td>
  </tr>
  
  <?php  
             
    for($cont=0;$cont<$filas_resultado_tram;$cont++) { 
        $registro_tram = pg_fetch_array($resultado_tram);
        $vsol=   trim($registro_tram['solicitud']);
        $vtramt=  trim($registro_tram['tramite']);     
 
     echo "<tr >";
     if ($registro_tram['estatus']== 15) {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solicitud]</td>";
//         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
//         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='web/w_formsipi.php?vsol=$vsol''>FP-03</a></td>";
         
         
         //echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planillafp03.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
//         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> -</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> -</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> -</td>";         
         
         }    

     echo "</tr>";
     

    ?>

  <?php   

    }   
   echo " </table>";

 

}

if ($vopc==4) {
  $borrar = pg_exec("DROP TABLE consulta");
  if (empty($vtramt)) {
    mensajenew("AVISO: Nro. de Tramite en blanco, NO lo ingres&oacute; ...!!!","../web/w_ingrecesp.php?vopc=3","N");
    $smarty->display('pie_pag.tpl'); 
    exit(); } 
  else {
    $sql1 = new mod_db();
    $sql1->connection1();

    $resultado_tram = pg_exec("SELECT * FROM stmsolces, stztramite 
    			 	WHERE stztramite.nro_tramite = '$vtramt' 
    			 	AND stmsolces.nro_tramite = stztramite.nro_tramite
    			 	AND stztramite.estatus_tra IN ('13','14','09','10','15','02') order by stmsolces.nro_referencia");

    $filas_resultado_tram = pg_numrows($resultado_tram); 
  
    $sql1->disconnect1();
    
    if ($filas_resultado_tram==0) { 
      mensajenew("AVISO: El Nro. de Tramite no esta Registrado o No tiene solicitudes que ingresar ...!!!","../web/w_ingrecesp.php?vopc=3","N");
      $smarty->display('pie_pag.tpl'); 
      exit(); } 
    else{


    ?>

<p>&nbsp;</p>
<p align='center'><b><font > Cesiones Asociadas al Tramite No.: <?php echo $vtramt; ?> para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="10%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Referencia</b></p></td>
    <td width="30%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Nro. Registro</b></p></td> 
    <td width="30%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Ver</b></p></td>
    <td width="10%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Fecha</b></p></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Hora</b></p></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Documento</b></p></td>
  </tr>
  
  <?php  
    $sql = new mod_db();
    $sql->connection();
    pg_exec("CREATE TABLE consulta (tramite char(11), solicitud char(11), estatus char(2), solic_sipi char(11), fecha char(10), hora char(11)) ");         
    for($cont=0;$cont<$filas_resultado_tram;$cont++) { 
       $registro_tram = pg_fetch_array($resultado_tram);
       $vsol=   $registro_tram['nro_referencia'];
       $vreg=   $registro_tram['registro'];

       // estatus en el sipi
       $res_est = pg_exec("SELECT estatus FROM stzderec WHERE solicitud = '$registro_tram[nro_solicitud]'");
       $regest= pg_fetch_array($res_est);
       //
       $resul_insert =pg_exec("INSERT INTO consulta (tramite,solicitud,estatus,solic_sipi,fecha,hora) VALUES ('$vtramt','$registro_tram[nro_referencia]','$registro_tram[estatus_sol]','$registro_tram[nro_solicitud]','','')");
			    
     $varsolic=trim($registro_tram['nro_referencia']);
     echo "<tr>";
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER >";
     if ($registro_tram['estatus_sol']<>'15') {echo "<a href='w_planillafp03.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>
        <input type='button' value='$varsolic' class='botones_rojo'></a></p></td>";} 
     else { echo "$registro_tram[nro_referencia]</p></td>";}
     echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[registro]</td>";
     $vsol=$registro_tram['nro_solicitud'];
     $vsol1=substr($vsol,0,4);
     $vsol2=substr($vsol,5,6);
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram['estatus_sol']=='15') {
        echo "<a href='../patentes/p_rptcronol.php?vsol1=$vsol1&vsol2=$vsol2'><input type='button' value='Cronología' class='botones_rojo'></a>";
        echo "</p></td>";  
     }    
     else { echo "-</p></td>";}
     $varhorasol=substr($registro_tram['solicitud_hora'],0,8).'-'.substr($registro_tram['solicitud_hora'],9,2);
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram['estatus_sol']=='15') {echo "$registro_tram[solicitud_fecha]</td>";} else {echo "-</p></td>";}
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram['estatus_sol']=='15') {echo "$varhorasol</p></td>";} else {echo "-</p></td>";} 

     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram['estatus_sol']=='15') {echo "$registro_tram[solicitud_sipi]</p></td>";} else {echo "-</p></td>";} 

     //$res_factram = pg_exec("SELECT * FROM stzfactram WHERE nro_tramite = '$vtramt' AND referencia = '$varsolic'");
     //$reg_factram = pg_fetch_array($res_factram);
     //$vfac= $reg_factram['nro_factura'];
     //echo "$vfac";

     echo "</tr>";

    ?>


  <?php   

    }   
   echo " </table>";
   }   
       $sql->disconnect();
 }
}

//*** Guardar la solicitud de CESION en el SIPI  
if ($vopc== 6) {
    $vpag=$_POST['vfact'];
    $vdoc=trim($_POST['vdoc']);
    $vfec_tram=$_POST['vfec_tram'];
    $vcarp=trim($_POST['vcarp']);
    $vcomadi=trim($_POST['vcomadi']);
    $fecha_reno=trim($_POST['fecha_reno']);

    $vpagotasa='F'.ltrim(rtrim($vpag));
    if ($vpag=='' or $vpag=='000000' or $vpag=='0' or empty($vpag) or $vpagotasa=='F') {
       mensajenew("ERROR: Debe colocar el N&uacute;mero de Factura del Pago de Tasa de Presentaci&oacute;n ...!!!","../web/w_ingrecesp.php?vopc=3","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    
    if ($vdoc=='' or $vdoc=='0000000000' or $vdoc=='0' or empty($vdoc)) {
       mensajenew("ERROR: Debe colocar el N&uacute;mero de Documento del Reloj asociado a la Cesi&oacute;n ...!!!","../web/w_ingrecesp.php?vopc=3","N");
       $smarty->display('pie_pag.tpl'); exit();
    }

    if ($vcarp=='' OR $vcarp=='000000' OR $vcarp=='0000000000' OR $vcarp=='0' OR empty($vcarp)) {
       mensajenew("ERROR: Debe colocar el N&uacute;mero de la Carpeta asociada a la Cesi&oacute;n ...!!!","../web/w_ingrecesp.php?vopc=3","N");
       $smarty->display('pie_pag.tpl'); exit();
    }

    if (empty($fecha_reno)) {
      mensajenew('ERROR: La Fecha de la Cesion esta vacia ...!!!','../web/w_ingrecesp.php?vopc=3','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    $fechahoy = hoy();
    $esmayor=compara_fechas($fecha_reno,$fechahoy);
    if ($esmayor==1) {
      mensajenew('AVISO: NO se pueden ejecutar eventos a Futuros ...!!!','../web/w_ingrecesp.php?vopc=3','N');
      $smarty->display('pie_pag.tpl'); exit();  } 

if ($usuario!='rmendoza') {
    //Verificar tasa en sistema de facturación
    $mysql = new mod_mysql_db(); 
    $mysql->connection_mysql();
	
    //$nfac = 'F0'.$factura;
    $nfac = $vpagotasa;
    //Datos de la Factura     F1105928 ---> PAGO EXONERADO
    if ($vpagotasa=='F1105928') {$comenpagotasa='Factura: EXONERADA';
    } else { 
       $objquery = $mysql->query_mysql("SELECT fac_id,fac_fecha FROM sfa_factura WHERE fac_num='$nfac'"); 
       $objfilas = $mysql->nums_mysql('',$objquery);
       if ($objfilas==0) {
          mensajenew('ERROR: Nro. de Factura NO existe en la Base de Datos ...!!!','../web/w_ingrecesp.php?vopc=3','N');
          $smarty->display('pie_pag.tpl'); exit(); }
       $objsfac = $mysql->objects_mysql('',$objquery);
       $fac_id  = $objsfac->fac_id;
       $fac_fe  = $objsfac->fac_fecha;
   
       //Datos del Detalle 
       $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id like '0205%' AND fac_id=$fac_id"); 
       $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
       if ($objtotdtalle==0) {
         mensajenew('ERROR: Nro. de Factura NO presenta ning&uacute;n pago de Tasa de Cesi&oacute;n de Patentes ...!!!','../web/w_ingrecesp.php?vopc=3','N');
         $smarty->display('pie_pag.tpl'); exit(); }
       $objsdet  = $mysql->objects_mysql('',$objdetalle);
       $can_tasa = $objsdet->dtalle1_cantidad_ser;
       $comenpagotasa='Factura: '.$nfac.', de fecha: '.$fac_fe;
    
       // Verificar si la factura ya fué usada en otras solicitudes
       $sql = new mod_db();
       $sql->connection();
       //$query_tasas=pg_exec("SELECT evento FROM stzevtrd 
       //                      WHERE evento=1204 and comentario like '%$comenpagotasa'");
       //$filas_tasas = pg_numrows($query_tasas);    
       $query_tasas=pg_exec("SELECT nro_factura FROM stmfactura WHERE nro_factura='$nfac' and tipo_anotamar='C'");
       $filas_tasas = pg_numrows($query_tasas);    

       if ($filas_tasas >= $can_tasa) {
          mensajenew('ERROR: Nro. de Factura ya fue utilizada en otra(s) solicitud(es) ...!!! Verifique...','../web/w_ingrecesp.php?vopc=3','N');
          $smarty->display('pie_pag.tpl'); exit(); }
       //fin verificacion facturacion
    }
}  
    //$nfac = $vpagotasa; 
    //$fac_fe = "03/05/2022";
    //echo "$vpagotasa,$vfec_tram,$fecha_reno,$vcarp,$nfac ... ";
    
    $vaccion=$_POST['vaccion'];
    $sql = new mod_db();
    $sql->connection();
    //inicializar variables
    $tramite= $vtramt;
   
    //*** Tabla de Eventos de Tramite  
    $horactual = Hora();
    //descripcion del evento
    $sql = new mod_db();
    $sql->connection();
    $resultado_tram=pg_exec("SELECT * FROM stzevder WHERE evento=2205");
    $regeve = pg_fetch_array($resultado_tram);
    $vdeseven=trim($regeve['mensa_automatico']);
    $documento=0;
    $comentario="";

    //Verificacion de Carpeta 
    $obj_query = $sql->query("SELECT * FROM stzfactram WHERE carpeta = '$vcarp'");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas!=0) {
      $objs = $sql->objects('',$obj_query);
      $ntramuso = $objs->nro_tramite;
      mensajenew('ERROR: Nro. de Carpeta ya Utilizado en otro Tr&aacute;mite ('.$ntramuso.'), Verificar ...!!!','../web/w_ingrecesp.php?vopc=3','N');
      $smarty->display('pie_pag.tpl'); exit(); }
    $sql->disconnect();

    //***  Maestra de Derecho 
    $sql1 = new mod_db();
    $sql1->connection1();    

    $query_res="SELECT * FROM stmsolces WHERE nro_tramite = '$vtramt' and nro_referencia= '$vsol'";
    $registro = $sql1->query1($query_res);
    $reg = $sql1->objects1('',$registro);

    $vreg=ltrim(rtrim($reg->registro));
    $vfre=$reg->fecha_registro;
    $vnom=$reg->nombre;
    //$vcla=$reg->clase;
    //$vinc=$reg->ind_clase;
    //$vmod=$reg->modalidad;
    $vnsol=$reg->nro_solicitud;
    $vfsol=$reg->fecha_solicitud;
    $vpod=$reg->poder;
    $vfpo=$reg->fecha_poder;
    $vitr=$reg->idtramitante;
    //$vcln=$reg->clase_nac;

    $cesionario = "";
    $res_cesionario = pg_exec("SELECT * FROM stzcesion WHERE stzcesion.nro_tramite='$vtramt' AND stzcesion.solicitud='$vsol'");
    $filas_cfound1=pg_numrows($res_cesionario);
    if ($filas_cfound1==0) {
      mensajenew('ERROR: Nro. de Tr&aacute;mite de Cesi&oacute;n NO presenta ning&uacute;n CESIONARIO ...!!!','../web/w_ingrecesp.php?vopc=3','N');
      $smarty->display('pie_pag.tpl'); exit(); }
    
    $regtc = pg_fetch_array($res_cesionario);
    for($cont1=0;$cont1<$filas_cfound1;$cont1++) { 
      $codigo    = $regtc['titular'];
      $titular   = $regtc['nombre'];
      $domicilio = $regtc['domicilio'];
      $pais_domicilio=pais($regtc['pais_domicilio']);
      $pais = $regtc['pais_domicilio'];
      $pais_nombre =pais($regtc['nacionalidad']);
      if (empty($cesionario)) {
        $cesionario = $cesionario.$titular." con Domicilio en: ".$domicilio. ", ".$pais_domicilio; }
      else {
        $cesionario = ", ".$cesionario.$titular." con Domicilio en: ".$domicilio. ", ".$pais_domicilio; }
      $regtc = pg_fetch_array($res_cesionario);
    } 
    $sql1->disconnect1(); 

    //*** Actualizacion tabla stmsolren
//    $sql1 = new mod_db();
//    $sql1->connection1();
//    $var=pg_exec("update stmsolren set estatus_sol='15',solicitud_sipi='$numsol',solicitud_fecha='$fechahoy',solicitud_hora= '$horactual' 
//                   where nro_tramite='$vtramt' and solicitud='$vsol'");
//    $sql1->disconnect1();


    //*******************************************************************************************************************     
    // Grabar en sipi
    $can_error=0;
    $sql1->disconnect1();
    $sql = new mod_db();
    $sql->connection(); 

    //$nfac = "F0123456"; $fac_fe="18/06/2019";
    //$comenpagotasa='Factura: '.$nfac.', de fecha: '.$fac_fe;

    $resul_der = pg_exec("SELECT * FROM stzderec where registro='$vreg' AND tipo_mp='P' ");
    $regis_der = pg_fetch_array($resul_der);
    $vnder=$regis_der['nro_derecho'];
    $vesta=$regis_der['estatus'];

    $vcomenta= 'Cesi&oacute;n presentada en fecha: '.$fecha_reno.", CESIONARIO: ".$cesionario.', WEBPI Tramite No: '.$vtramt.' y Referencia: '.$vsol.'.  S/'.$comenpagotasa;

    $vcomenta= $vcomenta.' '.$vcomadi;
    //echo " $vcomenta "; exit();
    
    // Insertar evento 2205 en stzevtrd
    $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
    $insert_valores ="'$vnder','2205','$fecha_reno',nextval('stzevtrd_secuencial_seq'),
                       $vesta,$vdoc,'$fechahoy','$usuario','$vdeseven','$vcomenta','$horactual'";
    $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
    if (!$valido) {$can_error = $can_error + 1;}  

    // Insertar datos de cesion en Stzantma
    $insert_campos="nro_derecho,nanota,solicitud,tipo,evento,cod_tit_2,nom_tit_2,domicilio,pais,tramitante,agente,verificado,inf_adicional,cod_tit_1";
    $insert_valores ="$vnder,$vdoc,'$vnsol','P',2205,$codigo,'$titular','$domicilio','$pais','',0,'N','$cesionario',0";
    $valido=$sql->insert("stzantma","$insert_campos","$insert_valores","");
    if (!$valido) {$cant_error = $cant_error + 1;} 

    // Insertar numero de factura en stmfactura
    $obj_query = $sql->query("SELECT * FROM stmfactura WHERE nro_factura='$nfac'");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas!=0) {
	   $objs = $sql->objects('',$obj_query);
      $vcant_am = $objs->cant_anotamar; }
    if ($vcant_am>0) { $delfactu = $resulage=pg_exec("DELETE FROM stmfactura WHERE nro_factura='$nfac'"); }         
    $vcant_am=$vcant_am+1;
    $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede,tipo_anotamar,cant_anotamar,tipo_mp";
    $insert_str = "'$nfac','$fac_fe',0,0,0,'1','C',$vcant_am,'P'";  
    $valido     = $sql->insert("stmfactura","$col_campos","$insert_str","");
    if (!$valido) { $can_error = $can_error + 1; }

    // Insertar Datos de factura, tramite y expediente en stzfactram
    $insolfac   = true;
    $col_campos = "nro_controlft,tipo_ft,nro_tramite,fecha_tramite,referencia,nro_factura,fecha_factura,nro_derecho,solicitud,registro,tipo_mpa,usuario,fecha_carga,hora_carga,carpeta,tipo_tram";
    $insert_factram = "nextval('stzfactram_nro_controlft_seq'),'W','$vtramt','$vfec_tram',$vsol,'$nfac','$fac_fe','$vnder','$vnsol','$vreg','P','$usuario','$fechahoy','$horactual','$vcarp','FP03'";    
    $valido     = $sql->insert("stzfactram","$col_campos","$insert_factram","");
    if (!$valido) { $can_error = $can_error + 1; }

    //echo " tram=$vtramt and refferncia= $vsol, $vdoc, $insert_valores - $insert_valfac - $insert_factram"; //exit();
     
    if ($can_error==0) {
       pg_exec("COMMIT WORK");
      
    //*********************************************    
    //*** Guarda en actualizacion de tabla temporal 
    $sql = new mod_db();
    $sql->connection();    
    $update_str = "estatus='15',solic_sipi= '$vreg', fecha='$fechahoy', hora= '$horactual'";
    $upddetit = $sql->update("consulta","$update_str","solicitud='$vsol'");
    $sql->disconnect();
   
    //*** Cambia de estatus la solicitud en el WEBPI
    $sql1 = new mod_db();
    $sql1->connection1();    
    $actualiza=pg_exec("UPDATE stmsolces SET estatus_sol='15',solicitud_fecha='$fechahoy',solicitud_hora='$horactual',solicitud_sipi='$vdoc' where nro_referencia ='$vsol' AND nro_tramite='$vtramt'");             

      $resultado_cant = pg_exec("SELECT * FROM stmsolces where nro_tramite='$vtramt' ");
      $filas_cant = pg_numrows($resultado_cant); 
      $resultado_estatus = pg_exec("SELECT * FROM stmsolces where nro_tramite='$vtramt' and estatus_sol = '15'");
      $filas_estatus = pg_numrows($resultado_estatus);  
      if ($filas_estatus == $filas_cant) {
          $actual=pg_exec("UPDATE stztramite SET estatus_tra = '15' where nro_tramite='$vtramt'");   }    
      $sql1->disconnect1();  

      
      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','w_ingrecesp.php?vopc=4&vtramt='.$vtramt,'S');
      // Aqui llamar al examen de forma
      //Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','w_devoluci.php?vopc=1&vsol=$varsol','S');
      $smarty->display('pie_pag.tpl'); exit();            

    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      //*** DesActualizacion tabla stmsolref
      $sql1 = new mod_db();
      $sql1->connection1();
      $var=pg_exec("update stmsolces set estatus_sol=null,solicitud_sipi=null,solicitud_fecha=null,solicitud_hora=null 
                   where nro_tramite='$vtramt' and nro_referencia='$vsol'");
      $sql1->disconnect1();

          
      Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
         
      $sql->disconnect();   
    }  
    //$registro_tram = pg_fetch_array($resultado_tram);
}

//*** Opcion Actualizar Estatus de Ingreso al SIPI
if ($vopc== 7) {
   $sql = new mod_db();
   $sql->connection();  
   $resultado_tram = pg_exec("SELECT * FROM consulta order by solicitud ");
   $filas_resultado_tram = pg_numrows($resultado_tram); 
   $sql->disconnect(); 
   ?>

<p>&nbsp;</p>
<p align='center'><b><font > Cesiones Asociadas al Tramite para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b> Solicitud </b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Estatus</b></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Nro. Registro </b></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Ver</b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Fecha</b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Hora</b></td>
  </tr>
  
  <?php  
             
    for($cont=0;$cont<$filas_resultado_tram;$cont++) { 
        $registro_tram = pg_fetch_array($resultado_tram);
        $vsol=   trim($registro_tram['solicitud']);
        $vtramt=  trim($registro_tram['tramite']);     
 
     echo "<tr >";
     if ($registro_tram['estatus']== 15) {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solicitud]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solic_sipi]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_formsipi.php?vsol=$registro_tram[solic_sipi]''>FP-03</a></td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planillafp03.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> -</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> -</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> -</td>";         
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> -</td>";    
         }    

     echo "</tr>";
     

    ?>

  <?php   

    }   
   echo " </table>";

}

$smarty->assign('campo1','Nro. Tramite:');
$smarty->assign('usuario',$usuario);
$smarty->assign('vopc',$vopc);
$smarty->assign('vtramt',$vtramt);
$smarty->assign('vsol',$vsol);
$smarty->display('w_ingrecesp.tpl');
$smarty->display('pie_pag.tpl');
//ob_end_clean(); 
?>

