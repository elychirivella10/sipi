<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion de la Cesion ?'); }


function planilla(v1,v2,v3) {
  open("w_planillafm04.php?vsol="+v1.value+"&vtramt="+v2.value+"&vopc=","Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function Ventana_001 (URL){ 
  window.open(URL,"UTERRA","width=500,height=300,top=20,left=40,scrollbars=NO,titlebar=NO,menubar=YES,toolbar=NO,directories=YES,location=YES,status=NO,resizable=NO") 
} 
  
</script>
<?php
include ("../setting.inc.php");
include ("../setting.mysql.php");
ob_start();

//Comienzo del Programa por los encabezados del reporte
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = $_SESSION['usuario_login'];
$role      = $_SESSION['usuario_rol'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();

$vopc = $_GET['vopc'];
$vtramt=$_POST['vtramt'];
if (empty($vtramt)) {$vtramt=$_GET['vtramt'];}
$vsol=$_POST['vsol'];
if (empty($vsol)) {$vsol=$_GET['vsol'];}
//
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Planilla FM05 al SIPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','wingresol.vtramt'); 
$smarty->assign('modo2','readonly');

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
<p align='center'><b><font > Cesiones Asociadas al Tramite para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b> Referencia </b></td>
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
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='web/w_formsipi.php?vsol=$vsol''>FM-02</a></td>";
         
         
         //echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planillafm04.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
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
    mensajenew("AVISO: No Ingreso el Nro. del Tramite ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 
  else {
    $sql1 = new mod_db();
    $sql1->connection1();
    $resultado_tram = pg_exec("SELECT * FROM stmsolces, stztramite 
    			 	WHERE stztramite.nro_tramite = '$vtramt' 
    			 	AND stmsolces.nro_tramite = stztramite.nro_tramite
    			 	AND stztramite.estatus_tra IN ('13','14','09','10','15','02','99') order by stmsolces.nro_referencia");

    $filas_resultado_tram = pg_numrows($resultado_tram); 
  
    $sql1->disconnect1();
    
    if ($filas_resultado_tram==0) { mensajenew("AVISO: El Nro. del Tramite no esta Registrado o No tiene solicitudes que ingresar..!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); } 
    else{


    ?>

<p>&nbsp;</p>
<p align='center'><b><font > FM05 Asociadas al Tramite para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="10%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Referencia </b></p></td>
    <td width="30%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Ver</b></p></td>
    <td width="10%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Fecha</b></p></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Hora</b></p></td>
  </tr>
  
  <?php  
    $sql = new mod_db();
    $sql->connection();
    pg_exec("CREATE TABLE consulta (tramite char(11), solicitud char(11),estatus char(2), solic_sipi char(11), fecha char(10), hora char(11)) ");         
    for($cont=0;$cont<$filas_resultado_tram;$cont++) { 
        $registro_tram = pg_fetch_array($resultado_tram);
        $vsol=   $registro_tram['solicitud'];

// estatus en el sipi
$res_est = pg_exec("SELECT estatus FROM stzderec WHERE solicitud = '$registro_tram[nro_solicitud]'");
$regest= pg_fetch_array($res_est);
//

  $resul_insert =pg_exec("INSERT INTO consulta (tramite,solicitud,estatus,solic_sipi,fecha,hora) VALUES ('$vtramt','$registro_tram[nro_referencia]','$registro_tram[estatus_tra]','$registro_tram[solicitud_sipi]','','')");
			    
     $varsolic=trim($registro_tram['nro_referencia']);
     echo "<tr>";
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER >";
     if ($registro_tram['estatus_tra']<>'15') {echo "<a href='w_planillafm05.php?vsol=$varsolic&vtramt=$vtramt&vopc=4''>
        <input type='button' value='$varsolic' class='botones_rojo'></a></p></td>";} 
     else { echo "$registro_tram[nro_referencia]</p></td>";}
//     echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus_sol]</td>";
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     $vsol=$registro_tram[solicitud_sipi];
     $vsol1=substr($vsol,0,4);
     $vsol2=substr($vsol,5,6);
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='15') {
        //echo "<a href='w_formsipi.php?vsol=$registro_tram[solicitud_sipi]''><input type='button' value='FM-02' class='botones_rojo'></a>";
        //echo "</p></td><td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";  
        echo "<a href='../marcas/m_rptcronol.php?vsol1=$vsol1&vsol2=$vsol2'><input type='button' value='Cronología' class='botones_rojo'></a>";
        if ($regest[estatus]=='1002') 
           {echo "<a href='m_rptprensa_ti.php?vsol=$registro_tram[solicitud_sipi]&vsol1=$vsol1&vsol2=$vsol2''><input type='button' value='Clis&eacute;' class='botones_rojo'></a>";}
        if ($regest[estatus]=='1200') 
           {echo "<a href='../marcas/m_rptoficio55_ti.php?vsol=$registro_tram[solicitud_sipi]''><input type='button' value='Devoluci&oacute;n' class='botones_rojo'></a>";}
        echo "</p></td>";  
     }    
     else { echo "-</p></td><td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>-</p></td>";}
     $varhorasol=substr($registro_tram['solicitud_hora'],0,8).'-'.substr($registro_tram['solicitud_hora'],9,2);
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='15') {echo "$registro_tram[solicitud_fecha]</td>";} else {echo "-</p></td>";}
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='15') {echo "$varhorasol</p></td>";} else {echo "-</p></td>";} 
     echo "</tr>";

    ?>


  <?php   

    }   
   echo " </table>";
   }   
       $sql->disconnect();
 }
}

//*** Guardar la solicitud en el SIPI  
if ($vopc== 6) {
    $vpag=$_POST['vfact'];
    $vpagotasa='F'.ltrim(rtrim($vpag));
    if ($vpag=='' or $vpag=='000000' or $vpag=='0' or empty($vpag) or $vpagotasa=='F') {
       mensajenew("ERROR: Debe colocar el N&uacute;mero de Factura del Pago de Tasa de Presentaci&oacute;n..!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    
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
          mensajenew('ERROR: Factura NO existe en la Base de Datos ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); }
       $objsfac = $mysql->objects_mysql('',$objquery);
       $fac_id  = $objsfac->fac_id;
       $fac_fe  = $objsfac->fac_fecha;
   
       //Datos del Detalle 
       $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id like '0103%' AND fac_id=$fac_id"); 
       $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
       if ($objtotdtalle==0) {
         mensajenew('ERROR: Factura NO presenta ning&uacute;n pago de Tasa de Renovaci&oacute;n de Marcas ...!!!','javascript:history.back();','N');
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
       $query_tasas=pg_exec("SELECT nro_factura FROM stmfactura 
                             WHERE nro_factura='$nfac' and tipo_anotamar='R'");
       $filas_tasas = pg_numrows($query_tasas);    

       if ($filas_tasas >= $can_tasa) {
          mensajenew('ERROR: Factura ya fue utilizada en otra(s) solicitud(es)...!!! Verifique...','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); }
       //fin verificacion facturacion
    }

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
    $resultado_tram=pg_exec("SELECT * FROM stzevder WHERE evento=1204");
    $regeve = pg_fetch_array($resultado_tram);
    $vdeseven=trim($regeve['mensa_automatico']);
    $documento=0;
    $comentario="";
    $sql->disconnect();

      
    //***  Maestra de Derecho 
    $sql1 = new mod_db();
    $sql1->connection1();    

    $query_res="SELECT * FROM stmsolren WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $registro = $sql1->query1($query_res);
    $reg = $sql1->objects1('',$registro);

    $vreg=ltrim(rtrim($reg->registro));
    $vfre=$reg->fecha_registro;
    $vnom=$reg->nombre;
    $vcla=$reg->clase;
    $vinc=$reg->ind_clase;
    $vmod=$reg->modalidad;
    $vnsol=$reg->nro_solicitud;
    $vfsol=$reg->fecha_solicitud;
    $vpod=$reg->poder;
    $vfpo=$reg->fecha_poder;
    $vitr=$reg->idtramitante;
    $vcln=$reg->clase_nac;
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

    $resul_der = pg_exec("SELECT * FROM stzderec where registro='$vreg' ");
    $regis_der = pg_fetch_array($resul_der);
    $vnder=$regis_der['nro_derecho'];
    $vesta=$regis_der['estatus'];
    $vcomenta= 'Presentada en fecha:'.$fechahoy.', en Clase Int: '.$vcla.' y Clase Nac: '.$vcln.'. S/'.$comenpagotasa;

    // Insertar evento 1204 en stzevtrd
    $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
    $insert_valores ="'$vnder','1204','$fechahoy',nextval('stzevtrd_secuencial_seq'),
                       $vesta,$vsol,'$fechahoy','$usuario','$vdeseven','$vcomenta','$horactual'";
    $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
    if (!$valido) {$can_error = $can_error + 1;}  

    // Insertar numero de factura en stmfactura
    $insert_campos="nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede,tipo_anotamar";
    $insert_valores ="'$nfac','$fac_fe',0,0,0,'1','R'";
    $valido=$sql->insert("stmfactura","$insert_campos","$insert_valores","");
    if (!$valido) {$can_error = $can_error + 1;}  
     
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
    $actualiza=pg_exec("UPDATE stmsolren SET estatus_sol='1' where solicitud ='$vsol' AND nro_tramite='$vtramt'");             

      $resultado_cant = pg_exec("SELECT * FROM stmsolren where nro_tramite='$vtramt' ");
      $filas_cant = pg_numrows($resultado_cant); 
      $resultado_estatus = pg_exec("SELECT * FROM stmsolren where nro_tramite='$vtramt' and estatus_sol = '1'");
      $filas_estatus = pg_numrows($resultado_estatus);  
      if ($filas_estatus == $filas_cant) {
          $actual=pg_exec("UPDATE stztramite SET estatus_tra = '15'  where nro_tramite='$vtramt'");   }    
      $sql1->disconnect1();  

      
      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','w_ingrefm05.php?vopc=4&vtramt='.$vtramt,'S');
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
      $var=pg_exec("update stmsolren set estatus_sol=null,solicitud_sipi=null,solicitud_fecha=null,solicitud_hora=null 
                   where nro_tramite='$vtramt' and solicitud='$vsol'");
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
<p align='center'><b><font > Renovaciones Asociadas al Tramite para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b> Solicitud </b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Estatus</b></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Nro. Registro SIPI</b></td>
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
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_formsipi.php?vsol=$registro_tram[solic_sipi]''>FM-02</a></td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planillafm05.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
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

//*** Pase de variables y Etiquetas al template
$smarty->assign('submitbutton','submit'); 
$smarty->assign('submitbutton1','button'); 

$smarty->assign('campo1','Nro. Tramite:');
$smarty->assign('usuario',$usuario);
$smarty->assign('vopc',$vopc);
//$smarty->assign('accion',$accion);
$smarty->assign('vtramt',$vtramt);
$smarty->assign('vsol',$vsol);
$smarty->display('w_ingrefm05.tpl');
$smarty->display('pie_pag.tpl');
//ob_end_clean(); 
?>

