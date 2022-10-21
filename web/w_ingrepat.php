<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }


function planilla(v1,v2,v3) {
  open("w_planillafp01.php?vsol="+v1.value+"&vtramt="+v2.value+"&vopc=","Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function Ventana_001 (URL){ 
  window.open(URL,"UTERRA","width=500,height=300,top=20,left=40,scrollbars=NO,titlebar=NO,menubar=YES,toolbar=NO,directories=YES,location=YES,status=NO,resizable=NO") 
} 
  
</script>
<?php
//ini_set('display_errors', '1');
// *************************************************************************************
// Programa: w_ingrepat.php 
// Realizado por el Analista de Sistema Wilson Garcia
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPEF
// Año 2017 I semestre
// *************************************************************************************
// *************************************************************************************
include ("../setting.inc.php");
include ("../setting.mysql.php");
//include ("../setting.inc.pruebafm02.php");
ob_start();

//Comienzo del Programa por los encabezados del reporte

include ("../z_includes.php");
//include ("../z_includes.pruebafm02.php");

//funcion del formulario
//include ("w_formulario.php");
//include ("w_grabar.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = trim($_SESSION['usuario_login']);
$role      = $_SESSION['usuario_rol'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();

/*$tbname_1 = "stzpaisr";
$tbname_2 = "stzagenr";
$tbname_3 = "stzsolic";
$tbname_4 = "stmmarce";
$tbname_5 = "stzevtrd";
$tbname_6 = "stzderec";
$tbname_7 = "stzottid";
$tbname_8 = "stmlogos";
$tbname_9 = "stztmptit";
$tbname_10 = "stzusuar";
$tbname_11 = "stmtmpccv";
$tbname_12 = "stzbitac";
$tbname_13 = "stzbider";
$tbname_14 = "stmlemad";
$tbname_15 = "stzpriod";
$tbname_16 = "stzautod";
$tbname_17 = "stmccvma";
$tbname_18 = "stztmpage";
$tbname_19 = "stztmprio";
$tbname_20 = "stmclnac";
$tbname_21 = "stztramr";
$tbname_22 = "stmfonetica";*/

$tbname_1 = "stzpaisr";
$tbname_2 = "stzagenr";
$tbname_3 = "stzsolic";
$tbname_4 = "stppatee";
$tbname_5 = "stzevtrd";
$tbname_6 = "stzderec";
$tbname_7 = "stzottid";
$tbname_8 = "stpinved";
$tbname_9 = "stztmptit";
$tbname_10 = "stzusuar";
$tbname_11 = "stptmpinv";
$tbname_12 = "stzbitac";
$tbname_13 = "stzbider";
$tbname_14 = "stplocad";
$tbname_15 = "stzpriod";
$tbname_16 = "stzautod";
//$tbname_17 = "stzautod";
$tbname_18 = "stztmpage";
$tbname_19 = "stztmprio";
$tbname_20 = "stpanual";
$tbname_21 = "stztramr";

//$anualidad= $_POST['anualidad'];
$planilla = $_POST['planilla'];
$tasa     = $_POST['tasa'];
//$monto    = $_POST['monto'];
$anualidad= "1";

$vopc = $_GET['vopc'];
$vtramt=$_POST['vtramt'];
if (empty($vtramt)) {$vtramt=$_GET['vtramt'];}
$vsol=$_POST['vsol'];
if (empty($vsol)) {$vsol=$_GET['vsol'];}
//
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Solicitud de Patente al SIPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','wingresol.vtramt'); 
$smarty->assign('modo2','readonly');

if ($vtramt==199735) {
   mensajenew("AVISO: Tr&aacute;mite NO Procede, TRANSFERENCIA o DEPOSITO ya usado en otro TRAMITE ...!!!","w_ingrepat.php?vopc=3","N");
   $smarty->display('pie_pag.tpl'); exit(); } 

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
<p align='center'><b><font > Solicitudes Asociadas al Tramite <?php echo $vtramt; ?> para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b> Referencia </b></td>
    <!-- <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Estatus</b></td> -->
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Nro. Solicitud SIPI</b></td>
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
     if ($registro_tram['estatus']== 45) {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solicitud]</td>";
//         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='web/w_formsipi.php?vsol=$vsol''>FM-02</a></td>";
         
         
         //echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planillafp01.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
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
  if ($vtramt==187802 or $vtramt==187795 or $vtramt==187807 or $vtramt==187879 or $vtramt==187869 or $vtramt==187886 or $vtramt==187882 or
      $vtramt==187980 or $vtramt==188170 or $vtramt==188190 or $vtramt==188203 or $vtramt==188214) {
    mensajenew("AVISO: Tramite NO Procede!!! Verificar Domicilio del Titular. El Pago debe realizarse en PETROS.!!!","w_ingrepat.php?vopc=3","N");
    $smarty->display('pie_pag.tpl'); exit(); } 
  if (empty($vtramt)) {
    mensajenew("AVISO: No Ingreso el Nro. del Tramite ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 
  else {
    $sql1 = new mod_db();
    $sql1->connection1();
    //$resultado_tram = pg_exec("SELECT * FROM stzderec, stztramite, stmsolref 
    //			 	WHERE stzderec.nro_tramite = '$vtramt' 
    //			 	AND stzderec.nro_tramite = stztramite.nro_tramite
    //			 	AND  stzderec.estatus in ('0')
    //			 	AND stztramite.estatus_tra IN ('13','14','09') order by stzderec.solicitud");

    //$resultado_tram = pg_exec("SELECT * FROM stmsolref, stztramite 
    //		 	WHERE stztramite.nro_tramite = '$vtramt' 
    //			 	AND stmsolref.nro_tramite = stztramite.nro_tramite
    //			 	AND stztramite.estatus_tra IN ('13','14','09','10','15','02') order by stmsolref.solicitud");
    
    $resultado_tram = pg_exec("SELECT * FROM stpsolref, stztramite 
    			 	WHERE stztramite.nro_tramite = '$vtramt' 
    			 	AND stpsolref.nro_tramite =stztramite.nro_tramite
    			 	AND stztramite.estatus_tra IN ('44','45') order by stpsolref.nro_tramite");

    $filas_resultado_tram = pg_numrows($resultado_tram); 
  
    $sql1->disconnect1();
    
    if ($filas_resultado_tram==0) { mensajenew("AVISO: El Nro. del Tramite no esta Registrado o No tiene solicitudes que ingresar..!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); } 
    else{


    ?>

<p>&nbsp;</p>
<p align='center'><b><font > Solicitudes Asociadas al Tramite <?php echo $vtramt; ?> para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="10%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Referencia </b></p></td>
<!--    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Estatus</b></td> -->
    <td width="30%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Solicitud-SIPI</b></p></td>
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
        $vsol=   $registro_tram['nro_referencia'];

// estatus en el sipi
$res_est = pg_exec("SELECT estatus FROM stzderec WHERE solicitud = '$registro_tram[solicitud_sipi]'");
$regest= pg_fetch_array($res_est);
//

  $resul_insert =pg_exec("INSERT INTO consulta (tramite,solicitud,estatus,solic_sipi,fecha,hora) VALUES ('$vtramt','$registro_tram[nro_referencia]','$registro_tram[estatus_sol]','$registro_tram[solicitud_sipi]','','')");
			    
 // echo "<LI> <a href='#' onclick=window.open('w_planillafp01.php?vsol=$vsol&vtramt=$vtramt&vopc=4','miwin','width=900,height=700,scrollbars=yes')> Solicitud Nro: $registro_tram[solicitud] </a>";      

     $varsolic=trim($registro_tram['nro_referencia']);
     echo "<tr>";
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER >";
     if ($registro_tram[estatus_sol]<>'45') {echo "<a href='w_planillafp01.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>
        <input type='button' value='$varsolic' class='botones_rojo'></a></p></td>";} 
     else { echo "$registro_tram[nro_referencia]</p></td>";}
//     echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus_sol]</td>";
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     $vsol=$registro_tram[solicitud_sipi];
     $vsol1=substr($vsol,0,4);
     $vsol2=substr($vsol,5,6);
//     if ($registro_tram[estatus_sol]=='15') {echo "<a href='../expediente/m_rptexp.php?varsol=$vsol'><input type='button' value='$registro_tram[solicitud_sipi]' class='botones_rojo'></a></p></td>"; }
     if ($registro_tram[estatus_sol]=='45') {echo "$registro_tram[solicitud_sipi]</p></td>"; }
     else { echo "-</p></td>";}

//ver
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='45') {
        //echo "<a href='w_formsipi.php?vsol=$registro_tram[solicitud_sipi]''><input type='button' value='FM-02' class='botones_rojo'></a>";
        //echo "</p></td><td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";  
        echo "<a href='../patentes/p_rptcronol.php?vsol1=$vsol1&vsol2=$vsol2'><input type='button' value='Cronología' class='botones_rojo'></a>";
        /*if ($regest[estatus]=='1002') 
           {echo "<a href='m_rptprensa_ti.php?vsol=$registro_tram[solicitud_sipi]&vsol1=$vsol1&vsol2=$vsol2''><input type='button' value='Clis&eacute;' class='botones_rojo'></a>";}*/
        /*if ($regest[estatus]=='1200') 
           {echo "<a href='../marcas/m_rptoficio55_ti.php?vsol=$registro_tram[solicitud_sipi]''><input type='button' value='Devoluci&oacute;n' class='botones_rojo'></a>";}*/
        echo "</p></td>";  
     }    
     else { echo "-</p></td><td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>-</p></td>";}
     $varhorasol=substr($registro_tram['solicitud_hora'],0,8).'-'.substr($registro_tram['solicitud_hora'],9,2);
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='45') {echo "$registro_tram[solicitud_fecha]</td>";} else {echo "-</p></td>";}
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='45') {echo "$varhorasol</p></td>";} else {echo "-</p></td>";} 
     echo "</tr>";

    ?>


  <?php   

    }   
   echo " </table>";
   }   
       $sql->disconnect();
 }
}

        //if ($regest[estatus]==1002) {echo "<a href='w_formsipi.php?vsol=$registro_tram[solicitud_sipi]''>Clis&eacute;</a>&nbsp;&nbsp;&nbsp;"; }
        //if ($regest[estatus]==1200) {echo "<a href='w_formsipi.php?vsol=$registro_tram[solicitud_sipi]''>Devoluci&oacute;n</a>"; }
     //echo "</td>";


//*** Guardar la solicitud en el SIPI  

if ($vopc== 6) {
    // Validar examen de forma
    $vpedpod=$_POST['vpedpod'];
    $vpod1=$_POST['vpod1'];
    $vpod2=$_POST['vpod2'];
    $varpoder=$vpod1.'-'.$vpod2;
    //Validacion de Romulo Mendoza, cuando el poder es blanco, hay que quitar la rayita ya que lo graba mal y trae otro agente distinto. Habia que blanquear el poder.
    if ($varpoder=='-') { $varpoder=''; }
    if ($pedpod=='S') {
      if ($vpod1=='' or $vpod2=='' or $vpod1=='0000' or $vpod2=='0000' or empty($vpod1) or empty($vpod2) or $varpoder=='-' or $varpoder=='') {
         mensajenew("ERROR: Debe colocar el N&uacute;mero de Poder..!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit();
      }
    }
    $vsol1=$_POST['vsol1'];
    $vsol2=$_POST['vsol2'];
    $varsol=$vsol1.'-'.$vsol2;
    $vcarp=trim($_POST['vcarp']);
    $fecha_pres=trim($_POST['fecha_pres']);
    $vfec_tram=trim($_POST['vfec_tram']);

    //Validacion de Romulo Mendoza donde el año de la solicitud NO puede ser menor a 2017.
   if ($vsol1=='' or $vsol2=='' or $vsol1=='0000' or $vsol2=='000000' or empty($vsol1) or empty($vsol2) or $varsol=='-') {
       mensajenew("ERROR: Debe colocar el N&uacute;mero de Solicitud..!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    } 
   if ($vsol1<2017) {
       mensajenew("ERROR: El A&nacute;o del N&uacute;mero de Solicitud NO puede ser menor a 2017 ..!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    if ($vsol2>30000) {
       mensajenew("ERROR: El N&uacute;mero de Solicitud es Incorrecto...   Verifique!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
        $vtramt=$_POST['vtramt'];
    if ($vsol2==$vtramt) {
       mensajenew("ERROR: El N&uacute;mero de Solicitud es igual al N&uacute;mero de Tramite...   Verifique!!!", "javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    //Validacion Tasa Presentacion de Patentes
    $vpag=$_POST['vfact'];
    $vpaganu=$_POST['vanu'];
    $vnumpla=$_POST['vplan']; //echo " $vpag, $vpaganu, $vnumpla  ";
    if ($vsol2==$vpag) {
       mensajenew("ERROR: El N&uacute;mero de Solicitud es igual a la Factura del Pago de Tasa de Presentaci&oacute;n...   Verifique!!!", "javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    $vpagotasa='F'.ltrim(rtrim($vpag));
    if ($vpag=='' or $vpag=='000000' or $vpag=='0' or empty($vpag) or $vpagotasa=='F') {
       mensajenew("ERROR: Debe colocar el N&uacute;mero de Factura del Pago de Tasa de Presentaci&oacute;n..!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }

    if ($vcarp=='' OR $vcarp=='000000' OR $vcarp=='0000000000' OR $vcarp=='0' OR empty($vcarp)) {
       mensajenew("ERROR: Debe colocar el N&uacute;mero de la Carpeta asociada a la FM02 ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }

    if (empty($fecha_pres)) {
      mensajenew('ERROR: La Fecha de Presentacion de la Solicitud FP01 esta vacia ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    //if (($usuario<>'wgarcia') && ($usuario<>'rmendoza')) {
    //Verificar TASA PRESENTACION de patentes en sistema de facturación
    $mysql = new mod_mysql_db(); 
    $mysql->connection_mysql();
	
    //$nfac = 'F0'.$factura;
    $nfac = $vpagotasa;
    //Datos de la Factura     F1105928 ---> PAGO EXONERADO
    if ($vpagotasa=='F1105928') {$vpagotasa='EXONERADO'; 
                                $fac_id='E0000000'; 
                                $fac_fe=$fechahoy;
    } else { 
       $objquery = $mysql->query_mysql("SELECT fac_id,fac_fecha FROM sfa_factura WHERE fac_num='$nfac'"); 
       $objfilas = $mysql->nums_mysql('',$objquery);
       if ($objfilas==0) {
          mensajenew('ERROR: Factura NO existe en la Base de Datos ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); }
       $objsfac = $mysql->objects_mysql('',$objquery);
       $fac_id  = $objsfac->fac_id;
       $fac_fe  = $objsfac->fac_fecha;
       //Validacion de Romulo Mendoza donde la fecha de la tasa de presentacion NO puede ser menor a 03/Agosto/2015
       //$fechatope = "03/08/2015";
       //$esmayor=compara_fechas($fechatope,$fecha_tasa);
       //if ($esmayor==1) {
       //  mensajenew('AVISO: La Fecha de la Tasa de Presentaci&oacute;n No puede ser menor de Agosto/2015 ...!!!','javascript:history.back();','N');
       //  $smarty->display('pie_pag.tpl'); exit(); }
   
       //Datos del Detalle 
       $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id='FP01' AND fac_id=$fac_id"); 
       $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
       if ($objtotdtalle==0) {
         mensajenew('ERROR: Factura NO presenta ning&uacute;n pago de Tasa de Presentaci&oacute;n de Patentes ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
       $objsdet  = $mysql->objects_mysql('',$objdetalle);
       $can_tasa = $objsdet->dtalle1_cantidad_ser;
       $comenpagotasa='Pago de Tasa: '.$vpagotasa;
    
       // Verificar si la factura ya fué usada en otras solicitudes
       $sql = new mod_db();
       $sql->connection();
       $query_tasas=pg_exec("SELECT evento FROM stzevtrd 
                             WHERE evento=2200 and comentario = '$comenpagotasa'");
       $filas_tasas = pg_numrows($query_tasas);    
       if ($filas_tasas >= $can_tasa) {
          mensajenew('ERROR: Factura ya fue utilizada en otra(s) solicitud(es)...!!! Verifique...','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); }
       //fin verificacion facturacion
    }
    //
    //Validacion Tasa Anualidad
    if ($vsol2==$vpaganu) {
       mensajenew("ERROR: El N&uacute;mero de Solicitud es igual a la Factura del Pago de Tasa de Anualidad...   Verifique!!!", "javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    $vpagoanu='F'.ltrim(rtrim($vpaganu));
    if ($vpaganu=='' or $vpaganu=='000000' or $vpaganu=='0' or empty($vpaganu) or $vpagoanu=='F') {
       mensajenew("ERROR: Debe colocar el N&uacute;mero de Factura del Pago de Tasa de Anualidad..!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    //Verificar TASA ANUALIDAD de patentes en sistema de facturación
    $mysql = new mod_mysql_db(); 
    $mysql->connection_mysql();
	
    //$nfac = 'F0'.$factura;
    $nanu = $vpagoanu;
    //Datos de la Factura     F1105928 ---> PAGO EXONERADO
    if ($vpagoanu=='F1105928') {$vpagoanu='EXONERADO';
                                $fac_id1='E0000000'; 
                                $fac_fe=$fechahoy;
                                $fac_fe1=$fecha;
                                $fac_monto=0;
    } else { 
       $objquery = $mysql->query_mysql("SELECT fac_id,fac_fecha,fac_total FROM sfa_factura WHERE fac_num='$nanu'"); 
       $objfilas = $mysql->nums_mysql('',$objquery);
       if ($objfilas==0) {
          mensajenew('ERROR: Factura NO existe en la Base de Datos ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); }
       $objsfac = $mysql->objects_mysql('',$objquery);
       $fac_id1  = $objsfac->fac_id;
       $fac_fe1  = $objsfac->fac_fecha;
       $fac_monto = $objsfac->fac_total;
       //Validacion de Romulo Mendoza donde la fecha de la tasa de presentacion NO puede ser menor a 03/Agosto/2015
       //$fechatope = "03/08/2015";
       //$esmayor=compara_fechas($fechatope,$fecha_tasa);
       //if ($esmayor==1) {
       //  mensajenew('AVISO: La Fecha de la Tasa de Presentaci&oacute;n No puede ser menor de Agosto/2015 ...!!!','javascript:history.back();','N');
       //  $smarty->display('pie_pag.tpl'); exit(); }
   
       //Datos del Detalle 
       //$objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id like '0207%' AND fac_id=$fac_id1"); 
       $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id like '0207%' AND fac_id=$fac_id1"); 
       $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
       if ($objtotdtalle==0) {
         mensajenew('ERROR: Factura NO presenta ning&uacute;n pago de Tasa de Anualidad de Patentes ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
       $objsdet  = $mysql->objects_mysql('',$objdetalle);
       $can_tasa1 = $objsdet->dtalle1_cantidad_ser;
       $comenpagotasa1=$vpaganu; 
    
       // Verificar si la factura de anualidad ya fué usada en otras solicitudes
       $sql = new mod_db();
       $sql->connection();
       $query_tasas1=pg_exec("SELECT nro_derecho FROM stpanual 
                             WHERE tasa='$comenpagotasa1'");
       $filas_tasas1 = pg_numrows($query_tasas1);    
       //if ($filas_tasas1 >= $can_tasa1) {
       if ($filas_tasas1 >=1) { 
          mensajenew('ERROR: Factura ya fue utilizada en otra(s) solicitud(es)...!!! Verifique...','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); }
       //fin verificacion facturacion
    }
    //Validando Numero Planilla Pago Anualidad
    if ($vnumpla=='' or $vnumpla=='000000' or $vnumpla=='0' or empty($vnumpla) or $vnumpla=='F') {
       mensajenew("ERROR: Debe colocar el N&uacute;mero de Planilla del Pago de la Anualidad..!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
   
   //} //Finn Validacion

    //$vaccion=$_POST['vaccion'];
    //$vcausa1=$_POST['causa1'];   $vcausa2=$_POST['causa2'];   $vcausa3=$_POST['causa3'];  
    //$vcausa4=$_POST['causa4'];   $vcausa5=$_POST['causa5'];   $vcausa6=$_POST['causa6'];  
    //$vcausa7=$_POST['causa7'];
    //$votro  =$_POST['otro'];

    //$vc1='';$vc2='';$vc3='';$vc4='';$vc5='';$vc6='';$vc7='';
    //if($vcausa1 =='on'){$vc1 ='X';};if($vcausa2 =='on'){$vc2 ='X';};if($vcausa3 =='on'){$vc3 ='X';}
    //if($vcausa4 =='on'){$vc4 ='X';};if($vcausa5 =='on'){$vc5 ='X';};if($vcausa6 =='on'){$vc6 ='X';}
    //if($vcausa7 =='on'){$vc7 ='X';}
    //$allcausas = $vc1.$vc2.$vc3.$vc4.$vc5.$vc6.$vc7.$votro;

    $recaud1=$_POST['recaud1'];
    $recaud2=$_POST['recaud2'];
    $recaud3=$_POST['recaud3'];
    $recaud4=$_POST['recaud4'];
    $recaud5=$_POST['recaud5'];
    $recaud6=$_POST['recaud6'];
    $recaud7=$_POST['recaud7'];
    $recaud8=$_POST['recaud8'];
    $vr1='-';$vr2='-';$vr3='-';$vr4='-';$vr5='-';$vr6='-';$vr7='-';$vr8='-';
    if($recaud1 =='on'){$vr1 ='X';};if($recaud2 =='on'){$vr2 ='X';};if($recaud3 =='on'){$vr3 ='X';}
    if($recaud4 =='on'){$vr4 ='X';};if($recaud5 =='on'){$vr5 ='X';};if($recaud6 =='on'){$vr6 ='X';}
    if($recaud7 =='on'){$vr7 ='X';};if($recaud8 =='on'){$vr8 ='X';};
/// POLICIA /////    
//$mens=Mensajenew('Policia-> Recaudos:'.$vr1.$vr2.$vr3.$vr4.$vr5.$vr6.$vr7.$vr8,'javascript:history.back();','N');
//$smarty->display('pie_pag.tpl'); exit();
/// POLICIA /////

    //$sql->disconnect();
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_est0=pg_exec("SELECT * FROM stzanxtra WHERE nro_tramite = '$vtramt' and solicitud='$vsol' and cod_anexo<>'C' and estatus='0'");
    $filest0=pg_numrows($query_est0); 
    $sql1->disconnect1();

    // aprobar examen de forma
//    if ($vaccion==1) {
//       if ($filest0>0) {
//          $mens=Mensajenew('Faltan cargar los Documentos Anexos a la solicitud!!! Verifique...','javascript:history.back();','N');
//          $smarty->display('pie_pag.tpl'); exit();  
//       }
//       if ($allcausas!='') {
//          $mens=Mensajenew('Se indicaron Causales de Devolución en el formulario!!! Verifique...','javascript:history.back();','N');
//          $smarty->display('pie_pag.tpl'); exit();  
//       }
//    }
    // generar oficio de devolucion
    //if ($vaccion==2) {
       //if ($filest0==0 and $allcausas=='') {
         // $mens=Mensajenew('No se encontraron causales de Devolución!!! Verifique...','javascript:history.back();','N');
          //$smarty->display('pie_pag.tpl'); exit();  
       //}
    //}
//    $mens=Mensajenew('Policia:'.$allcausas.$vaccion.$votro,'w_ingrepat.php?vopc=7','S');
//    $smarty->display('pie_pag.tpl'); exit();  

    $sql = new mod_db();
    $sql->connection();
    //inicializar variables
    //$insclanac  = true;
    //$inslema = true;
    //$insmarce = true;
    $instram = true;
    //$inslogo = true;
    //$insprio = true;
    $inspaten = true;
    $insanual = true;
    $insagen = true;
    $insderecho = true; 
    $insautod = true; 
    $insautop= true;
    $numapod = 0; 
    $numagen= 0;
    $prox_derecho = 0; 
    $numtitu = 0; 
    $ins_solic = true;
    $ins_titur = true;    
    $ins_tramt= true;
        
    $tramite= $vtramt;

    //Verificacion de Carpeta 
    $obj_query = $sql->query("SELECT * FROM stzfactram WHERE carpeta = '$vcarp' AND tipo_mpa='P' AND tipo_tram='FP01'");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas!=0) {
      $objs = $sql->objects('',$obj_query);
      $ntramuso = $objs->nro_tramite;
      mensajenew('ERROR: Nro. de Carpeta ya Utilizado en otro Tr&aacute;mite ('.$ntramuso.'), Verificar ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    //Verificar si existe el poder
//    $query_poder="SELECT * FROM stzpoder WHERE poder = '$varpoder'";
//    $regis_poder = $sql->query($query_poder);
//    $filas_poder = $sql->nums('',$regis_poder);
//    if ($filas_poder>0) {//Existe el poder
//    } else { //No Existe el poder
//    }
    //Generacion del Numero de Derecho 
    $obj_query = $sql->query("update stzsystem set nro_derecho=nextval('stzsystem_nro_derecho_seq')");
    if ($obj_query) {
      $obj_query = $sql->query("select last_value from stzsystem_nro_derecho_seq");
      $objs = $sql->objects('',$obj_query);
      $prox_derecho = $objs->last_value; }

    //*** Generacion numero de solicitud
    $obj_query1 = $sql->query("update stzsystem set msolicitud=nextval('stzsystem_msolicitud_seq')");
    if ($obj_query1) {
      $obj_query1 = $sql->query("select last_value from stzsystem_msolicitud_seq");
      $objs = $sql->objects('',$obj_query1);
      $num_sol = $objs->last_value; 
    }
    $ano= substr($fechahoy,-4,4);
    $num_sol=sprintf("%06d",$num_sol);
    $numsol= $ano.'-'.$num_sol;  // Numero de solicitud automática
    // Numero de solicitud establecida por el usuario
    $numsol= $varsol;          
        
    //***Tipo de clase nacional 
    //$sql1 = new mod_db();
   //$sql1->connection1();
    //$query_clase="SELECT * FROM stmclnac WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    //$regclase_nac = $sql1->query1($query_clase);
    //$regis_clase = $sql1->objects1('',$regclase_nac);
    //$vclasenac = $regis_clase->clase_nac; 
    //$sql1->disconnect1();

    //*** Tabla de Lemas Asociados     
//    if ($tipo_marca=="L") {
//        $sql1 = new mod_db();
//        $sql1->connection1();
//        $query_lem="SELECT * FROM stmlemad WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
//        $regis_lema = $sql1->query1($query_lem);
//        $regis_lema = $sql1->objects1('',$regis_lema);
//        $sql1->disconnect1();
//    }
    
    //*** Tabla de Eventos de Tramite  
    $horactual = Hora();
    //descripcion del evento
    $sql = new mod_db();
    $sql->connection();
    $resultado_tram=pg_exec("SELECT * FROM stzevder WHERE evento=2200");
    $regeve = pg_fetch_array($resultado_tram);
    $vdes=trim($regeve['mensa_automatico']);
    $documento=0;
    $comentario="";
//    $resultado_tram21=pg_exec("SELECT * FROM stzevder WHERE evento=1021");
//    $regeve21 = pg_fetch_array($resultado_tram21);
//    $vdes21=trim($regeve21['mensa_automatico']);
//    $resultado_tram53=pg_exec("SELECT * FROM stzevder WHERE evento=1053");
//    $regeve53 = pg_fetch_array($resultado_tram53);
//    $vdes53=trim($regeve53['mensa_automatico']);
//    $resultado_tram500=pg_exec("SELECT * FROM stzevder WHERE evento=1500");
//    $regeve500 = pg_fetch_array($resultado_tram500);
//    $vdes500=trim($regeve500['mensa_automatico']);
    $sql->disconnect();
    
     //**Tabla Detalle de Patentes
     $edicion = 0;
     $sql1 = new mod_db();
     $sql1->connection1();
     $query_prio="SELECT * FROM stppatee WHERE nro_tramite = '$vtramt' and nro_referencia= '$vsol'";
     $regis_pat = $sql1->query1($query_prio);
     $filas_pat = $sql1->nums1('',$regis_pat);
     $regis_pat = $sql1->objects1('',$regis_pat);
     $sql1->disconnect1();


    //*** Tabla de Prioridades   
       $sql1 = new mod_db();
       $sql1->connection1();
       $query_prio="SELECT * FROM stzpriod WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
       $regis_prio = $sql1->query1($query_prio);
       $filas_prio = $sql1->nums1('',$regis_prio);
       //$regis_prio = $sql1->objects1('',$regis_prio);
       $sql1->disconnect1();

//*** Tabla de Inventores ****************
       $sql1 = new mod_db();
       $sql1->connection1();
       $query_inve="SELECT * FROM stpinved WHERE nro_tramite = '$vtramt' AND nro_referencia ='$vsol'";
       $regis_inve = $sql1->query1($query_inve);
       $filas_inve = $sql1->nums1('',$regis_inve);
       //$regis_inve = $sql1->objects1('',$regis_inve);
       $sql1->disconnect1();
       

    //*** Tabla de Agentes y apoderados ****************
       $sql1 = new mod_db();
       $sql1->connection1();
       $query_agente="SELECT * FROM stzagenr,stzautod 
                             WHERE stzautod.nro_tramite = '$vtramt' 
                             AND stzautod.solicitud = '$vsol' 
                             AND stzagenr.agente = stzautod.agente ORDER BY stzautod.agente";                             
       $regisagente = $sql1->query1($query_agente);
       $filas_agente = $sql1->nums1('',$regisagente);
       $regis_agente = $sql1->objects1('',$regisagente);
      $sql1->disconnect1();
              
    //*** Tabla de Poderes ****************
//       $sql1 = new mod_db();
//       $sql1->connection1();
//       $query_poder="SELECT * FROM stzpoder 
//                             WHERE nro_tramite = '$vtramt' AND solicitud = '$vsol'";                             
//       $regispoder = $sql1->query1($query_poder);
//       $filas_poder = $sql1->nums1('',$regispoder);
//       $regis_poder = $sql1->objects1('',$regispoder);
//      $sql1->disconnect1();

    //*** Tabla de Poderhabientes ****************
       $sql1 = new mod_db();
       $sql1->connection1();
//       $query_pohabi=pg_exec("SELECT * FROM stzpohad WHERE nro_tramite = '$vtramt' AND solicitud ='$vsol'");
//       $filas_pohabi = pg_numrows($query_pohabi);
//       $regis_pohabi = pg_fetch_array($query_pohabi);
       $query_pohabi=pg_exec("SELECT * FROM stzautod WHERE nro_tramite = '$vtramt' AND solicitud ='$vsol'");
       $filas_pohabi = pg_numrows($query_pohabi);
       $regis_pohabi = pg_fetch_array($query_pohabi);
       $sql1->disconnect1();

    //***  Maestra de Derecho 
    $sql1 = new mod_db();
    $sql1->connection1();    

    $query_res="SELECT * FROM stzderec WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $registro = $sql1->query1($query_res);
    $filas_found_res = $sql1->nums1('',$registro);
    $registro = $sql1->objects1('',$registro);

     $col_campos = "nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus, pais_resid,poder,tramitante,agente, nplanilla, idtramitante";
     //$tipo_marca=$registro->tipo_derecho;
     $tipo_patente=$registro->tipo_derecho;
/// POLICIA /////    
//$mens=Mensajenew('Policia-> Tipo de Marca:'.$tipo_marca,'javascript:history.back();','N');
//$smarty->display('pie_pag.tpl'); exit();
/// POLICIA /////
     $nombre= $registro->nombre;
     $pais_resid= $registro->pais_resid;
 //    $poder= $registro->poder;
     $poder=$varpoder;  
     $tramitante= $registro->tramitante;
     $nsolic= $registro->solicitud; //identificador de solicitud en el webpi
     $cod_tramitante= $registro->idtramitante;  
     $sql1->disconnect1(); 
    
     //*** Tramitante *****
     $sql1 = new mod_db();
     $sql1->connection1(); 
     if (!empty($tramitante)) {
        $cod_tramitante= $registro->idtramitante;  
        $query_tram="SELECT * FROM stztramr WHERE idtramitante = '$cod_tramitante' ";
        $reg_tramt = $sql1->query1($query_tram);
        $filas_found_tram = $sql1->nums1('',$reg_tramt);
        $reg_tramt = $sql1->objects1('',$reg_tramt); 
        $tramita_bus= $reg_tramt->cedula;
 
     }     
     $sql1->disconnect1();    
    
        
    //*** Maestra de Marcas  
    //$sql1 = new mod_db();
    //$sql1->connection1();
    //$query_mar="SELECT * FROM stmmarce WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    //$registro = $sql1->query1($query_mar);
    //$filas_resultado = $sql1->nums1('',$registro);
    //$regis_marce = $sql1->objects1('',$registro);
    //$modalidad= $regis_marce->modalidad;
    //$sql1->disconnect1();

    //*** Actualizacion tabla stpsolref
    $sql1 = new mod_db();
    $sql1->connection1();
    $var=pg_exec("update stpsolref set estatus_sol='45',solicitud_sipi='$numsol',solicitud_fecha='$fechahoy',solicitud_hora= '$horactual' 
                   where nro_tramite='$vtramt' and nro_referencia='$vsol'");
    $sql1->disconnect1();

    //*** Tabla de Logos
   //if (($modalidad =="G") OR ($modalidad =="M"))  {
       //$sql1 = new mod_db();
       //$sql1->connection1();
       //$query_logo="SELECT * FROM stmlogos WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
       //$regis_logo = $sql1->query1($query_logo);
       //$filas_logo = $sql1->nums1('',$regis_logo);
       //$regis_logo = $sql1->objects1('',$regis_logo);
   //imagen**************
       //$query_imagen="SELECT * FROM stmsolref WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
       //$reg_imagen = $sql1->query1($query_imagen);
       //$regis_imagen = $sql1->objects1('',$reg_imagen);
       //$imagen= $regis_imagen->ref_gra;
   //busqueda grafica
   //    $query_busgra="SELECT * FROM stmsolref WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
   //    $busgra = $sql1->query1($query_busgra);
   //    $regis_busgra = $sql1->objects1('',$regis_busgra);
   //    $busgra= $regis_busgra->ref_gra; 
    //   $sql1->disconnect1();


  // }  

      //*** Tabla de Solicitantes o Titulares 
       $sql1->disconnect1();
       $sql1 = new mod_db();
       $sql1->connection1();    
       $query_titular="SELECT stzottid.titular, stzsolic.nombre, stzsolic.identificacion, stzsolic.indole, stzsolic.telefono1, stzsolic.telefono2, stzsolic.fax, stzsolic.email, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       			      FROM stzottid, stzsolic 
       			      WHERE stzottid.nro_tramite='$vtramt'
       			      AND stzottid.solicitud='$nsolic'
                              AND stzsolic.titular = stzottid.titular";
       $regis_titular = $sql1->query1($query_titular);
       $filas_titular = $sql1->nums1('',$regis_titular);
       $regis_titul = $sql1->objects1('',$regis_titular); 
       $sql1->disconnect1();

       $sql1 = new mod_db();
       $sql1->connection1();    
          // Documentos Anexos	  
	  //$resul_anexo = pg_exec("SELECT * FROM stzanxtra WHERE nro_tramite = '$vtramt' AND solicitud = '$vsol' and estatus='0'");
          //$filas_anexo=pg_numrows($resul_anexo);	  
          //$f_pod=0;$f_reg=0;$f_pri=0;$f_rex=0;$f_mer=0;$f_act=0;$f_cci=0;$f_rif=0;
	  //for($conta=0;$conta<$filas_anexo;$conta++)   { 
	     //$reg_anexo = pg_fetch_array($resul_anexo);
             //if ($reg_anexo['cod_anexo']== 'A') { $f_pod=1; } // poder  			--> Causal de Devolucion: 5  
             //if ($reg_anexo['cod_anexo']== 'B') { $f_reg=1; } // reglamento uso de marca  	--> Causal de Devolucion: (otro)
             //if ($reg_anexo['cod_anexo']== 'C') { $f_pri=1; } // documento de prioridad    	--> Causal de Devolucion: 16 
             //if ($reg_anexo['cod_anexo']== 'D') { $f_rex=1; } // certificado de registro ext. 	--> Causal de Devolucion: 16 
             //if ($reg_anexo['cod_anexo']== 'F') { $f_mer=1; } // registro mercantil      	--> Causal de Devolucion: (otro)
             //if ($reg_anexo['cod_anexo']== 'G') { $f_act=1; } // acta ultima asamblea 		--> Causal de Devolucion: 4  
             //if ($reg_anexo['cod_anexo']== 'H') { $f_cci=1; } // copia de ci 			--> Causal de Devolucion: 17  
             //if ($reg_anexo['cod_anexo']== 'I') { $f_rif=1; } // copia de rif 			--> Causal de Devolucion: 18   
         //} 


//*******************************************************************************************************************     
// Grabar en sipi
    $sql1->disconnect1();
    $sql = new mod_db();
    $sql->connection(); 
    $query_verifinal=pg_exec("SELECT * FROM stzderec WHERE solicitud='$numsol' and tipo_mp='P'");
    $filas_verifinal=pg_numrows($query_verifinal); 
    if ($filas_verifinal>0) {
       //Mensaje de error
       //*** DesActualizacion tabla stpsolref
       $sql->disconnect();
       $sql1 = new mod_db();
       $sql1->connection1();
       $var=pg_exec("update stpsolref set estatus_sol=null,solicitud_sipi=null,solicitud_fecha=null,solicitud_hora=null 
                   where nro_tramite='$vtramt' and nro_referencia='$vsol'");
       $sql1->disconnect1();
       mensajenew('ERROR: Numero de Solicitud YA existe en la Base de Datos ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); exit();
    }
    pg_exec("BEGIN WORK");
        
    //*** Tabla de Agentes y apoderados ******
       for($i=0;$i<$filas_agente;$i++) {  
       
         //*******Apoderado*******************
         $agente= $regis_agente->agente;
         $sql->connection();
         if ($agente > 50000) {
             $cedula= $regis_agente->cedula;                
             $query_apoderado=pg_exec("SELECT * FROM stzagenr WHERE cedula = '$cedula'");
	        $regis_apoderado = pg_fetch_array($query_apoderado);
             $filas_apoderado = pg_numrows( $query_apoderado); 
          
	        //if (filas_apoderado!= 0 ) {
		       $numero_agente = $agente;          
             //} else {
           	//$obj_system = $sql->query("update stzsystem set napoderado=nextval('stzsystem_napoderado_seq')");
     	     //$objsystem = $sql->query("select last_value from stzsystem_napoderado_seq");
     		//$objsy = $sql->objects('',$objsystem);
     		//$prox_apodera = $objsy->last_value;
               $prox_apodera = $agente;
		     //$numero_agente = $prox_apodera;
            //}
         } else {           
          $numero_agente = $agente;
         }
        
      }

     //*** Tramitante *****   
     if (!empty($tramitante)) {
        $cedula_tramt= $reg_tramt->cedula;        
        $query_tramita=pg_exec("SELECT * FROM stztramr WHERE cedula = '$cedula_tramt'");
	   $regis_tramita = pg_fetch_array($query_tramita);
        $filas_tramita = pg_numrows( $query_tramita);    

     if ($filas_tramita == "0") {     

	$obj_query = $sql->query("update stzsystem set ntramitante=nextval('stzsystem_ntramitante_seq')");
        if ($obj_query) {
           $obj_query = $sql->query("select last_value from stzsystem_ntramitante_seq");
           $objs = $sql->objects('',$obj_query);
            $ntramitante = $objs->last_value; }
	
         $col_tramita = "idtramitante,cedula,nacionalidad,domicilio,telefono1,telefono2,fax,email,email2,nombre,pais_domicilio";
         $insert_tramt = "$ntramitante,'$reg_tramt->cedula','$reg_tramt->nacionalidad','$reg_tramt->domicilio', '$reg_tramt->telefono1', '$reg_tramt->telefono2','$reg_tramt->fax','$reg_tramt->email','$reg_tramt->email2','$reg_tramt->nombre','$reg_tramt->pais_domicilio' ";
         $ins_tramt = $sql->insert("$tbname_21","$col_tramita","$insert_tramt","");
     }
     else
       {

        pg_exec("LOCK TABLE stzsolic IN SHARE ROW EXCLUSIVE MODE");
        $update_tra = "nacionalidad='$regis_tramita->nacionalidad', domicilio= '$regis_tramita->domicilio', telefono1='$regis_tramita->telefono1', telefono2= '$regis_tramita->telefono2', fax='$regis_tramita->fax', email='$regis_tramita->email', email2='$regis_tramita->email2', nombre='$regis_tramita->nombre', pais_domicilio= '$regis_tramita->pais_domicilio'";
        $upddetramt = $sql->update("$tbname_21","$update_tra","cedula= '$cedula'");
        $ntramitante= $regis_tramita['idtramitante'];
       }
      }


   //*** Insercion del Registro Nuevo en la Maestra de Derecho 
    if (empty($numero_agente)) { $numero_agente = 0; }  
    if (empty($ntramitante)) { $ntramitante = 0; }  
    $varestatus='2001';
//    if ($vaccion==1) {$varestatus='1002';}
//    if ($vaccion==2) {$varestatus='1200';}
    $col_campos = "nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus,pais_resid,
poder,tramitante,agente,nplanilla,idtramitante,tramitewebpi"; 
    $insert_str = "'$prox_derecho', '$tipo_patente', '$numsol', '$fecha_pres', 'P', '$nombre', '$varestatus', '$pais_resid', '$poder', '$tramitante', '$numero_agente','0','$ntramitante','S'";
    $insderecho = $sql->insert("$tbname_6","$col_campos","$insert_str","");

    //*** Insercion del Registro Nuevo en la Maestra de Marcas  
    //$col_campos = "nro_derecho,clase,ind_claseni,modalidad,distingue,ind_producto"; 
   //$vregdistin=str_replace("'","`",$regis_marce->distingue);    
    //$insert_str = "'$prox_derecho','$regis_marce->clase','$regis_marce->ind_claseni','$regis_marce->modalidad','$vregdistin','$regis_marce->ind_producto'";
    //$insmarce = $sql->insert("$tbname_4","$col_campos","$insert_str","");
  
    //*** Lemas Asociados  
    //if ($tipo_marca=="L") {
       //$col_campos = "nro_derecho,solicitud_aso,registro_aso,nombre_sol"; 
       //$insert_str = "'$prox_derecho','$regis_lema->solicitud_aso','$regis_lema->registro_aso','$regis_lema->nombre_sol'"; 
       //$inslema = $sql->insert("$tbname_14","$col_campos","$insert_str",""); }
        
    //*** Tabla de Eventos de Tramite     
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora,comentario";
    $insert_str = "'$prox_derecho','2200','$fecha_pres',nextval('stzevtrd_secuencial_seq'), '2000', '0', '$fechahoy', '$usuario','$vdes','$horactual','Pago de Tasa: $vpagotasa'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");   

    // Insertar Datos de factura, tramite y expediente en stzfactram
    $insfactram   = true;
    $col_campos = "nro_controlft,tipo_ft,nro_tramite,fecha_tramite,referencia,nro_factura,fecha_factura,nro_derecho,solicitud,registro,tipo_mpa,usuario,fecha_carga,hora_carga,carpeta,tipo_tram";
    $insert_factram = "nextval('stzfactram_nro_controlft_seq'),'W','$vtramt','$vfec_tram',$vsol,'$nfac','$fac_fe','$prox_derecho','$numsol','','P','$usuario','$fechahoy','$horactual','$vcarp','FP01'";    
    $insfactram = $sql->insert("stzfactram","$col_campos","$insert_factram","");

    // Cuando aprueba el examen de fondo
//    if ($vaccion==1) {
//       $insert_str = "'$prox_derecho','1021','$fechahoy',nextval('stzevtrd_secuencial_seq'), '1001', '0', '$fechahoy', '$usuario','$vdes21','$horactual'";
//       $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");        
//    }   
    // Cuando genera oficio de devolucion
//    if ($vaccion==2) {
//       $insert_str = "'$prox_derecho','1053','$fechahoy',nextval('stzevtrd_secuencial_seq'), '1001', '0', '$fechahoy', '$usuario','$vdes53','$horactual'";
//       $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");        
//       $insert_str = "'$prox_derecho','1500','$fechahoy',nextval('stzevtrd_secuencial_seq'), '1001', '0', '$fechahoy', '$usuario','$vdes500','$horactual'";
//       $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");     

      //*** Tabla oficio devolucion 
      // Inserta en Stzcaded
      $ins_de=true;
      $inscaus = 0;
//      $col_campos = "nro_derecho,cod_causa,derecho,grupo,tipo_dev,fecha_dev,hora";
//      if ($vcausa1 =='on') {
//        $ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',6,'M','M','M','$fechahoy','$horactual'","");
//        if (!$ins_de) { $inscaus = $inscaus + 1; } }
//      if ($vcausa2 =='on') {
//        $ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',10,'M','M','M','$fechahoy','$horactual'","");
//        if (!$ins_de) { $inscaus = $inscaus + 1; } }
//      if ($vcausa3 =='on') {
//        $ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',11,'M','M','M','$fechahoy','$horactual'","");
//        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa4 =='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',1,'M','M','M','$fechahoy','$horactual'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa5 =='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',1,'M','M','M','$fechahoy','$horactual'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa6 =='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',1,'M','M','M','$fechahoy','$horactual'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa7 =='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',1,'M','M','M','$fechahoy','$horactual'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      // Documentos anexos faltantes
//      $complemento=''; 
//      if ($f_pod==1) {$ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',5,'M','M','M','$fechahoy','$horactual'","");}
//      if ($f_reg==1) {$complemento=$complemento." Anexar Reglamento de Uso de la Marca. ";}
//      if ($f_pri==1 or 
//          $f_rex==1) {$ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',16,'M','M','M','$fechahoy','$horactual'","");}
//      if ($f_mer==1) {$complemento=$complemento." Anexar Registro Mercantil. ";}
//      if ($f_act==1) {$ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',4,'M','M','M','$fechahoy','$horactual'","");}
//      if ($f_cci==1) {$ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',17,'M','M','M','$fechahoy','$horactual'","");}
//      if ($f_rif==1) {$ins_de=$sql->insert("stzcaded","$col_campos","'$prox_derecho',18,'M','M','M','$fechahoy','$horactual'","");}
//      $votro = $complemento.trim($votro);
//      if ($votro<>'') {
//        $col_campos = "nro_derecho,otros,derecho,grupo,tipo_dev,fecha_dev,hora";
//        $ins_otros = 
//              $sql->insert("stzotrde","$col_campos","'$prox_derecho','$votro','M','M','M','$fechahoy','$horactual'",""); 
//      }   
//    }   
 
    //*** Tabla de Logos       
    //if (($modalidad =="G") OR ($modalidad =="M"))  {
       //$col_campos = "nro_derecho,descripcion";
       //$vetilogo=str_replace("'","`",$regis_logo->descripcion);  
       //$insert_str = "'$prox_derecho','$vetilogo'";
       //$inslogo = $sql->insert("$tbname_8","$col_campos","$insert_str",""); }
    

    //** Tabla Detalles de Patente
    if ($filas_pat !=0) {
       $col_campos = "nro_derecho,edicion,anualidad,resumen "; 
       $insert_str = "'$prox_derecho',$edicion,1, '$regis_pat->resumen'  "; 
       $inspaten = $sql->insert("$tbname_4","$col_campos","$insert_str","");
    }


    //*** Tabla de Prioridades
    $numprio = 0; 
    $insprio = true;
    if ($filas_prio !=0) {
       $reg_prio = $sql1->objects1('',$regis_prio);
       for($i=0;$i<$filas_prio;$i++) {
         $pprioridad=trim($reg_prio->prioridad); 
         $pais_priori = trim($reg_prio->pais_priori);
         $fecha_priori = trim($reg_prio->fecha_priori);
         $col_campos = "nro_derecho,prioridad,pais_priori,fecha_priori"; 
         $insert_str = "'$prox_derecho','$pprioridad', '$pais_priori', '$fecha_priori' "; 
         $insprio = $sql->insert("$tbname_15","$col_campos","$insert_str","");
         if ($insprio) { }
         else { $numprio = $numprio + 1; }
         $reg_prio = $sql1->objects1('',$regis_prio);
       }
     }

       //$col_campos = "nro_derecho,prioridad,pais_priori,fecha_priori "; 
       //$insert_str = "'$prox_derecho','$regis_prio->prioridad','$regis_prio->pais_priori', '$regis_prio->fecha_priori'  "; 
       //$insprio = $sql->insert("$tbname_15","$col_campos","$insert_str","");

    //** Tabla de Inventores
    $numinv = 0; 
    $insinv = true;
    if ($filas_inve !=0) {
       $reg_inve = $sql1->objects1('',$regis_inve);
       for($i=0;$i<$filas_inve;$i++) {
         $nombreinv=trim($reg_inve->nombre_inv); 
         $dirinv = trim($reg_inve->domicilio);
         $nacinv = trim($reg_inve->nacionalidad);
         $paisinv = trim($reg_inve->pais_domicilio);
         $col_campos = "nro_derecho,nombre_inv,nacionalidad,domicilio,pais_domicilio "; 
         $insert_str = "'$prox_derecho','$nombreinv', '$nacinv', '$dirinv', '$paisinv'  "; 
         $insinve = $sql->insert("$tbname_8","$col_campos","$insert_str","");
         if ($insinv) { }
         else { $numinv = $numinv + 1; }
         $reg_inve = $sql1->objects1('',$regis_inve);
       }
     }
     $obser = '';
     $fecha_solic = hoy();
     //$fac_monto = "1000";
     //Insercion Datos de Anualidad     
       //$fac_monto = str_replace(",",".",$fac_monto);
       $col_campos = "nro_derecho,fecha_anual,anualidad,monto,observacion,planilla,tasa,usuario,fecha_trans,hora";
       if ($vpaganu=='1105928') {$vpaganu='EXONERA';}
       $insert_str = "'$prox_derecho','$fecha_solic',1,$fac_monto,'$obser','$vnumpla','$vpaganu','$usuario','$fechahoy','$horactual'";
       $insanual = $sql->insert("$tbname_20","$col_campos","$insert_str","");


 //*** Tabla de Agentes y apoderados ******
       for($i=0;$i<$filas_agente;$i++) {  
       
         //*******Apoderado*******************
         $agente= $regis_agente->agente;
         $sql->connection();
         if ($agente > 50000) {
             $cedula= $regis_agente->cedula;                
             $query_apoderado=pg_exec("SELECT * FROM stzagenr WHERE cedula = '$cedula'");
	        $regis_apoderado = pg_fetch_array($query_apoderado);
             $filas_apoderado = pg_numrows( $query_apoderado); 
	        if ($filas_apoderado!= 0 ) {
                pg_exec("LOCK TABLE stzagenr IN SHARE ROW EXCLUSIVE MODE");                                 
                $update_str = "'$regis_apoderado[nombre]', '$regis_apoderado[domicilio]', '$regis_apoderado[profesion]', '$regis_apoderado[estatus_age]','$regis_apoderado[telefono1]', '$regis_apoderado[telefono2]','$regis_apoderado[email]','$regis_apoderado[cedula]', '$regis_apoderado[nacionalidad]', '$regis_apoderado[fax]', '$regis_apoderado[email2]','$regis_apoderado[tipo]', '$regis_apoderado[pais_domicilio]'";
                                 
                //$insapod = $sql->update("$tbname_2","$update_str","agente='$agente'");
                $col_campos = "nro_derecho,agente";
                $insert_str = "'$prox_derecho','$agente'";
 	           $insautop = $sql->insert("$tbname_16","$col_campos","$insert_str","");
      
                //if ($insapod AND $insautop) { }
                if ($insautop) { }
                else { $numapod = $numapod + 1; } 
      
	           $regis_apoderado = $sql1->objects1('',$regis_apoderado); 	           
            } else {
	        $col_campos = "agente,nombre,domicilio,profesion,estatus_age,telefono1,telefono2,email,email2,fax,cedula,nacionalidad,tipo,pais_domicilio"; 
           //	$obj_system = $sql->query("update stzsystem set napoderado=nextval('stzsystem_napoderado_seq')");
     	   //     $objsystem = $sql->query("select last_value from stzsystem_napoderado_seq");
     	//	$objsy = $sql->objects('',$objsystem);
     	//	$prox_apodera = $objsy->last_value;
  		   //$insert_str = "$prox_apodera,'
	        $insert_str = "$agente,'$regis_agente->nombre','$regis_agente->domicilio','$regis_agente->profesion','$regis_agente->estatus_age', '$regis_agente->telefono1', '$regis_agente->telefono2', '$regis_agente->email', '$regis_agente->email2', '$regis_agente->fax', '$regis_agente->cedula','$regis_agente->nacionalidad','$regis_agente->tipo','$regis_agente->pais_domicilio' "; 
	          
	        $insagent = $sql->insert("$tbname_2","$col_campos","$insert_str","");
            
	        $col_campos = "nro_derecho,agente";
             //$insert_str = "'$prox_derecho',$prox_apodera";
             $insert_str = "'$prox_derecho',$agente";  
 	        $insautop = $sql->insert("$tbname_16","$col_campos","$insert_str","");
		   //$numero_agente = $prox_apodera;
             $numero_agente = $agente;
            }
        }
	else {
          pg_exec("LOCK TABLE stzagenr IN SHARE ROW EXCLUSIVE MODE");

          $update_str = "nombre= '$regis_agente->nombre', domicilio='$regis_agente->domicilio', profesion= '$regis_agente->profesion', estatus_age= '$regis_agente->estatus_age', telefono1= '$regis_agente->telefono1', telefono2= '$regis_agente->telefono2', email='$regis_agente->email', cedula='$regis_agente->cedula', nacionalidad='$regis_agente->nacionalidad', fax='$regis_agente->fax', email2='$regis_agente->email2',tipo='$regis_agente->tipo', pais_domicilio='$regis_agente->pais_domicilio'";
          $insagen = $sql->update("$tbname_2","$update_str","agente='$agente'");
 
          $col_campos = "nro_derecho,agente";
          $insert_str = "'$prox_derecho','$agente'";
          $insautod = $sql->insert("$tbname_16","$col_campos","$insert_str","");              
          $numero_agente = $agente;
          
         if ($insagen AND $insautod) { }
         else { $numagen = $numagen + 1; } 
 
       }

       $regis_agente = $sql1->objects1('',$regisagente); 
      }


    //*** Tabla de Solicitantes o Titulares 
    $filas_poder1 = 0;
//    $poder= $regis_poder->poder;
    $poder=$varpoder; 
    $query_poder1=pg_exec("SELECT * FROM stzpoder WHERE poder = '$poder'");
    $regis_poder1 = pg_fetch_array($query_poder1);
    $filas_poder1 = pg_numrows($query_poder1);

    for($k=0;$k<$filas_titular;$k++) { 
      $vartitu = $regis_titul->identificacion;

      $res_titu=pg_exec("SELECT stzsolic.titular, stzsolic.nombre, stzsolic.identificacion
       			  FROM stzsolic 
       			  WHERE stzsolic.identificacion= '$vartitu' ");                       
      $filas_res_titu=pg_numrows($res_titu); 
      $regtitu = pg_fetch_array($res_titu);
    
      if ($filas_res_titu == "0")
       {

         $col_campos = "titular,identificacion,nombre,indole,telefono1,telefono2,fax,email,email2";
         $vident =$regis_titul->identificacion;
         $insert_str = "nextval('stzsolic_titular_seq'),'$regis_titul->identificacion','$regis_titul->nombre','$regis_titul->indole', '$regis_titul->telefono1', '$regis_titul->telefono2','$regis_titul->fax','$regis_titul->email','$regis_titul->email2' ";
         $ins_solic = $sql->insert("$tbname_3","$col_campos","$insert_str","");

         $obj_query = $sql->query("select last_value from stzsolic_titular_seq");
         $objs = $sql->objects('',$obj_query);
         $act_titular = $objs->last_value;

         $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
         $insert_str = "'$prox_derecho','$act_titular','$regis_titul->nacionalidad','$regis_titul->domicilio','$regis_titul->pais_domicilio'";
         $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");

         // STZPODER   
         if ($filas_poder1!= 0 ) {
	    $numero_poder = $poder;          
         }
         else {
            $col_campos = "poder,titular,fecha_poder,facultad,fecha_trans";    
//            $insert_str = "'$poder','$act_titular','$regis_poder->fecha_poder',
//                           '$regis_poder->facultad','$regis_poder->fecha_trans'";
            $insert_str = "'$poder','$act_titular','$fechahoy','M','$fechahoy'";

            if (!empty($poder)) {$inspoder = $sql->insert("stzpoder","$col_campos","$insert_str","");}
         }

         if ($ins_solic AND $ins_titur) { }
         else { $numtitu = $numtitu + 1; }  
       }
     else
       {

        pg_exec("LOCK TABLE stzsolic IN SHARE ROW EXCLUSIVE MODE");
        $update_str = "identificacion= '$regis_titul->identificacion', nombre='$regis_titul->nombre', indole= '$regis_titul->indole', telefono1='$regis_titul->telefono1', telefono2= '$regis_titul->telefono2', fax='$regis_titul->fax',  email='$regis_titul->email', email2='$regis_titul->email2'";
        $upddetit = $sql->update("$tbname_3","$update_str","titular='$regtitu[titular]'");
        
        $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
        $insert_str = "'$prox_derecho','$regtitu[titular]','$regis_titul->nacionalidad','$regis_titul->domicilio','$regis_titul->pais_domicilio'";
        $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");         

        // STZPODER   
         if ($filas_poder1!= 0 ) {
	    $numero_poder = $poder;          
         }
         else {
            $col_campos = "poder,titular,fecha_poder,facultad,fecha_trans";    
            $insert_str = "'$poder','$regtitu[titular]','$fechahoy','M','$fechahoy'";
            if (!empty($poder)) {$inspoder = $sql->insert("stzpoder","$col_campos","$insert_str","");}
         }

       }
	
      $regis_titul = $sql1->objects1('',$regis_titular);
      $regis_poder = $sql1->objects1('',$regispoder);

    }

    //*** Tabla de PoderHabientes ******
       $poder= $varpoder;
       $sql->connection();
       $query_pohabi1=pg_exec("SELECT * FROM stzpohad WHERE poder = '$poder'");
       $regis_pohabi1 = pg_fetch_array($query_pohabi1);
       $filas_pohabi1 = pg_numrows($query_pohabi1); 
       if ($filas_pohabi1!= 0 ) {
          $numero_poder = $poder;          
       } else {
         $query_pohaut=pg_exec("SELECT * FROM stzautod WHERE nro_derecho= '$prox_derecho'");
         $regis_pohaut = pg_fetch_array($query_pohaut);
         $filas_pohaut = pg_numrows($query_pohaut); 
         for($i=0;$i<$filas_pohaut;$i++) {  
            $col_campos = "poder,poderhabi";    
//            $insert_str = "'$regis_pohabi[poder]','$regis_pohabi[poderhabi]'";
            $insert_str = "'$varpoder','$regis_pohaut[agente]'";
            $inspohabi = $sql->insert("stzpohad","$col_campos","$insert_str","");
            $regis_pohaut = pg_fetch_array($query_pohaut); 
         }
       }

    //***Tipo de clase nacional 
    //$col_campos = "nro_derecho,clase_nac";
    //$insert_str = "'$prox_derecho',$vclasenac";
    //$insclanac  = $sql->insert("$tbname_20","$col_campos","$insert_str","");

    //***envia los datos a la tabla de fonetica para realizar la busqueda fonetica
    //$col_campos = "nro_derecho,solicitud";
    //$insert_str = "'$prox_derecho', '$numsol'";
    //$insfoneti  = $sql->insert("$tbname_22","$col_campos","$insert_str","");

    
//*** Comprobaciones finales de errores
   //    echo " numtitu=$numtitu inslema=$inslema instram=$instram insprio=$insprio inslogo=$inslogo numprio=$numprio insagen=$insagen numagen=$numagen numapod=$numapod insmarce=$insmarce insderecho=$insderecho insclanac=$insclanac  insautod=$insautod $insautop=$insautop ins_solic=$ins_solic ins_titur=$ins_titur ins_tramt=$ins_tramt ";
 
    //if ($numtitu==0 AND $inslema AND $instram AND $inslogo AND $ins_tramt AND $insfoneti AND
    //    $numprio==0 AND $numagen==0 AND $numapod==0 AND $insmarce AND $insderecho AND $insclanac) {
    //   pg_exec("COMMIT WORK");    
    //*************************if ($numtitu==0 AND $inslema AND $instram AND $inslogo AND $ins_tramt AND $insfoneti AND
    //    $numprio==0 AND $numagen==0 AND $numapod==0 AND $insmarce AND $insderecho) {
    //       pg_exec("COMMIT WORK");
    if ($numtitu==0 AND $inspaten AND $instram AND $ins_tramt AND
        $numprio==0 AND $numagen==0 AND $numapod==0 AND $insanual AND $insderecho AND $insfactram) {
       pg_exec("COMMIT WORK");
      
      //*********************************************    
      //*** Guarda en actualizacion de tabla temporal 
       $sql = new mod_db();
       $sql->connection();    
       $update_str = "estatus='45',solic_sipi= '$numsol', fecha='$fechahoy', hora= '$horactual'";
       $upddetit = $sql->update("consulta","$update_str","solicitud='$vsol'");
       $sql->disconnect();
   
      //*** Cambia de estatus la solicitud en el WEBPI
      $sql1 = new mod_db();
      $sql1->connection1();    
      $actualiza=pg_exec("UPDATE stzderec SET estatus='1' where solicitud ='$vsol' AND nro_tramite='$vtramt'");             

      $resultado_cant = pg_exec("SELECT * FROM stzderec where nro_tramite='$vtramt' ");
      $filas_cant = pg_numrows($resultado_cant); 
      $resultado_estatus = pg_exec("SELECT * FROM stzderec where nro_tramite='$vtramt' and estatus = '1'");
      $filas_estatus = pg_numrows($resultado_estatus);  
      if ($filas_estatus == $filas_cant) {
          $actual=pg_exec("UPDATE stztramite SET estatus_tra = '45'  where nro_tramite='$vtramt'");   }    
      $sql1->disconnect1();  

      //*** Copiar imagen a carpeta oficial con numero de solicitud
         $vsol1=substr($numsol,-11,4);
         $vsol2=substr($numsol,-6,6);         
         $varsol=$vsol1.$vsol2;
         $dirano = $vsol1;
         $imagen= '../docutemp/'.$vsol.'.jpg';
         if(!empty($imagen)){ 	
	 $origen= '../docutemp/'.$vsol.'.jpg';
         $destino='../graficos/patentes/di'.$dirano.'/'.$varsol.'.jpg';
         $policia=$origen.'-'.$destino;
	 copy("$origen", "$destino");
         if (file_exists("$destino")) {
              unlink("$origen"); }
         }
	//if($recaud1 =='on') { 
	//  $origen= '../docutemp/poder/'.$vsol.'.pdf';
       //   $destino='../documentos/poder/ef'.$vsol1.'/'.$varsol.'.pdf';
 //
	//   copy("$origen", "$destino");
         //  if (file_exists("$destino")) {
         //     unlink("$origen"); }	   
	//}
	//if($recaud2 =='on'){ 
	//  $origen= '../docutemp/asamblea/'.$vsol.'.pdf';
        //  $destino='../documentos/asamblea/ef'.$vsol1.'/'.$varsol.'.pdf';
	 //  copy("$origen", "$destino");
         //  if (file_exists("$destino")) {
         //     unlink("$origen"); }	   
	//}	 
	//if($recaud3 =='on'){ 
	//  $origen= '../docutemp/reglamento/'.$vsol.'.pdf';
        //  $destino='../documentos/reglamento/ef'.$vsol1.'/'.$varsol.'.pdf';
	 //  copy("$origen", "$destino");
         //  if (file_exists("$destino")) {
          //    unlink("$origen"); }	   
	//}
	//if($recaud4 =='on'){ 
	//  $origen= '../docutemp/cedula/'.$vsol.'.pdf';
         // $destino='../documentos/cedula/ef'.$vsol1.'/'.$varsol.'.pdf';
//$policiaced=$origen.'-'.$destino;
	 //  copy("$origen", "$destino");
         //  if (file_exists("$destino")) {
         //     unlink("$origen"); }	   
	//}	
  	//if($recaud5 =='on'){ 
	//  $origen= '../docutemp/prioridad/'.$vsol.'.pdf';
        //  $destino='../documentos/prioridad/ef'.$vsol1.'/'.$varsol.'.pdf';
	//   copy("$origen", "$destino");
         //  if (file_exists("$destino")) {
         //    unlink("$origen"); }	   
	//}  	
	//if($recaud6 =='on'){ 
	//  $origen= '../docutemp/rif/'.$vsol.'.pdf';
         // $destino='../documentos/rif/ef'.$vsol1.'/'.$varsol.'.pdf';
	 //  copy("$origen", "$destino");
         //  if (file_exists("$destino")) {
          //    unlink("$origen"); }	   
	//} 	
	//if($recaud7 =='on'){ 
	//  $origen= '../docutemp/mercantil/'.$vsol.'.pdf';
        //  $destino='../documentos/mercantil/ef'.$vsol1.'/'.$varsol.'.pdf';
	//   copy("$origen", "$destino");
        //   if (file_exists("$destino")) {
        //      unlink("$origen"); }	   
	//} 	
  	//if($recaud8 =='on'){ 	
	//  $origen= '../docutemp/otros/'.$vsol.'.pdf';
        //  $destino='../documentos/otros/ef'.$vsol1.'/'.$varsol.'.pdf';
	//   copy("$origen", "$destino");
         //  if (file_exists("$destino")) {
          //    unlink("$origen"); }	   
	//} 
	
   	//if(!empty($imagen)){ 	
	//  $origen= '../graficos/planblog/'.$imagen.'.jpg';
     //   $destino='../graficos/marcas/ef'.$vsol1.'/'.$varsol.'.jpg';
     //   $policia=$origen.'-'.$destino;
	//   copy("$origen", "$destino");
     //      if (file_exists("$destino")) {
     //         unlink("$origen"); }	

     //Validacion de Romulo Mendoza, solo se copia la imagen si y solo si presenta busqueda grafica, cuya modalidad es G o M.
     /*if (($modalidad =="G") OR ($modalidad =="M"))  {
       //ejecuto el shell
       $cmd="scp -P 3535 www-data@172.16.0.7:/var/www/apl/logotipos/".$imagen.".jpg /var/www/apl/sipi/graficos/marcas/ef".$vsol1."/".$varsol.".jpg"; 
       exec($cmd,$salida);
       
       $cmd="scp -P 3535 www-data@172.16.0.7:/var/www/apl/logotipos/".$imagen.".png /var/www/apl/sipi/graficos/marcas/ef".$vsol1."/".$varsol.".jpg"; 
       exec($cmd,$salida);

       //Busqueda grafica
       $origen= '../../webpi/graficas/'.$imagen.'.pdf';
       $destino='../documentos/busq_grafica/ef'.$vsol1.'/'.$varsol.'.pdf';
       copy("$origen", "$destino");
       if (file_exists("$destino")) {
         unlink("$origen"); }      
     }*/
                 
     //}
	       
      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','w_ingrepat.php?vopc=4&vtramt='.$vtramt,'S');
      // Aqui llamar al examen de forma
      //Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','w_devoluci.php?vopc=1&vsol=$varsol','S');
      $smarty->display('pie_pag.tpl'); exit();            

    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      //*** DesActualizacion tabla stpsolref
      $sql1 = new mod_db();
      $sql1->connection1();
      $var=pg_exec("update stpsolref set estatus_sol=null,solicitud_sipi=null,solicitud_fecha=null,solicitud_hora=null 
                   where nro_tramite='$vtramt' and solicitud='$vsol'");
      $sql1->disconnect1();

      //if (!$inslema)    { $error_lem = " - Lema "; }
      if (!$instram)    { $error_tra = " - Tramite "; }
      //if (!$inslogo)    { $error_log = " - Descripcion del Logo "; }
      if (!$inspaten)   { $error_pat = " - Patentes "; }
      //if (!$insmarce)   { $error_mar = " - Marcas "; }
      if (!$insderecho) { $error_der = " - Derecho "; }
      if ($numtitu!=0)  { $error_tit = " - Titular(es) "; }
      if ($numprio!=0)  { $error_pri = " - Prioridad "; }
      if ($numagen!=0)  { $error_age = " - Agente(s) "; }
      if ($numapod!=0)  { $error_agep = " - Apoderado(s) "; }      
      //if (!$insclanac)  { $error_cla = " - Clase Nacional "; }     
      if (!$ins_tramt)  { $error_tra = " - Tramitante "; }     
      //if (!$insfoneti)  { $error_foneti = " - Fonetica "; }
      if (!$insanual)   { $error_anu = " - Anualidad "; }
      if ($numinv!=0)   { $error_inv = " - Inventores "; }
            
      Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_lem,  $error_tra, $error_log,  $error_mar,  $error_der, $error_tit, $error_pri, $error_age, $error_agep,  $error_cla, $error_tra, $error_foneti...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
         
$sql->disconnect();   
}
$registro_tram = pg_fetch_array($resultado_tram);
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
<p align='center'><b><font > Solicitudes Asociadas al Tramite para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b> Solicitud </b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Estatus</b></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Nro. Solicitud SIPI</b></td>
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
     if ($registro_tram['estatus']== 45) {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solicitud]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solic_sipi]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_formsipi.php?vsol=$registro_tram[solic_sipi]''>FM-02</a></td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planillafp01.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
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
$smarty->display('w_ingrepat.tpl');
$smarty->display('pie_pag.tpl');
//ob_end_clean(); 
?>

