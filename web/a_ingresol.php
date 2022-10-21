<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }


function planilla(v1,v2,v3) {
  open("a_planilla.php?vsol="+v1.value+"&vtramt="+v2.value+"&vopc=","Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function Ventana_001 (URL){ 
  window.open(URL,"UTERRA","width=500,height=300,top=20,left=40,scrollbars=NO,titlebar=NO,menubar=YES,toolbar=NO,directories=YES,location=YES,status=NO,resizable=NO") 
} 
  
</script>
<?php
// *************************************************************************************
// Programa: a_ingresol.php 
// Realizado por el Analista de Sistema  Nelson Gonzalez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año 2022
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
$horactual= Hora();
$sql = new mod_db();

$tbname_1 = "stzpaisr";
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
$tbname_22 = "stmfonetica";

$vopc = $_GET['vopc'];
$vtramt=$_POST['vtramt'];
if (empty($vtramt)) {$vtramt=$_GET['vtramt'];}
$vsol=$_POST['vsol'];
if (empty($vsol)) {$vsol=$_GET['vsol'];}
//
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Solicitud al SIPI');
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

    //$actual=pg_exec("UPDATE stztramite SET estatus_tra = '14'  where nro_tramite='$vtramt'");    
    $sql1->disconnect1();
      
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
     if ($registro_tram['estatus']== 52) {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solicitud]</td>";
//         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='web/w_formsipi.php?vsol=$vsol''>FM-02</a></td>";
         
         
         //echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='a_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
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
//  if ($vtramt==41060 or $vtramt==41072) {
//    mensajenew("AVISO: Tramite NO Procede!!! Ponerse en contacto con la Coordinacion de Informatica.","javascript:history.back();","N");
//    $smarty->display('pie_pag.tpl'); exit(); } 
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

    $resultado_tram = pg_exec("SELECT * FROM stdsolobra, stztramite 
    			 	WHERE stztramite.nro_tramite = '$vtramt' 
    			 	AND stdsolobra.nro_tramite = stztramite.nro_tramite
    			 	AND stztramite.estatus_tra IN ('50','52','54') order by stdsolobra.nro_referencia");

    $filas_resultado_tram = pg_numrows($resultado_tram); 
  
    $sql1->disconnect1();
    
    if ($filas_resultado_tram==0) { mensajenew("AVISO: El Nro. del Tramite no esta Registrado o No tiene solicitudes que ingresar..!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); } 
    else{


    ?>

<p>&nbsp;</p>
<p align='center'><b><font > Solicitudes Asociadas al Tramite para Ingresar al SIPI </font></b></p>
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
$res_est = pg_exec("SELECT estatus FROM stdobras WHERE solicitud = '$registro_tram[solicitud_sipi]'");
$regest= pg_fetch_array($res_est);
//

  $resul_insert =pg_exec("INSERT INTO consulta (tramite,solicitud,estatus,solic_sipi,fecha,hora) VALUES ('$vtramt','$registro_tram[nro_referencia]','$registro_tram[estatus_sol]','$registro_tram[solicitud_sipi]','','')");
			    
 // echo "<LI> <a href='#' onclick=window.open('a_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4','miwin','width=900,height=700,scrollbars=yes')> Solicitud Nro: $registro_tram[solicitud] </a>";      

     $varsolic=trim($registro_tram['nro_referencia']);
     echo "<tr>";
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER >";
     if ($registro_tram[estatus_sol]<>'52') {echo "<a href='a_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>
        <input type='button' value='$varsolic' class='botones_rojo'></a></p></td>";} 
     else { echo "$registro_tram[nro_referencia]</p></td>";}
//     echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus_sol]</td>";
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     $vsol=$registro_tram[solicitud_sipi];
     $vsol1=substr($vsol,0,4);
     $vsol2=substr($vsol,5,6);
//     if ($registro_tram[estatus_sol]=='15') {echo "<a href='../expediente/m_rptexp.php?varsol=$vsol'><input type='button' value='$registro_tram[solicitud_sipi]' class='botones_rojo'></a></p></td>"; }
     if ($registro_tram[estatus_sol]=='52') {echo "$registro_tram[solicitud_sipi]</p></td>"; }
     else { echo "-</p></td>";}

//ver
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='52') {
        //echo "<a href='w_formsipi.php?vsol=$registro_tram[solicitud_sipi]''><input type='button' value='FM-02' class='botones_rojo'></a>";
        //echo "</p></td><td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";  
        echo "<a href='../autor/a_rptcronol.php?vsol1=$vsol'><input type='button' value='Cronología' class='botones_rojo'></a>";
//        if ($regest[estatus]=='1002') 
//           {echo "<a href='m_rptprensa_ti.php?vsol=$registro_tram[solicitud_sipi]&vsol1=$vsol1&vsol2=$vsol2''><input type='button' value='Clis&eacute;' class='botones_rojo'></a>";}
//        if ($regest[estatus]=='1200') 
//           {echo "<a href='../marcas/m_rptoficio55_ti.php?vsol=$registro_tram[solicitud_sipi]''><input type='button' value='Devoluci&oacute;n' class='botones_rojo'></a>";}
        echo "</p></td>";  
     }    
     else { echo "-</p></td><td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>-</p></td>";}
     $varhorasol=substr($registro_tram['solicitud_hora'],0,8).'-'.substr($registro_tram['solicitud_hora'],9,2);
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='52') {echo "$registro_tram[solicitud_fecha]</td>";} else {echo "-</p></td>";}
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='52') {echo "$varhorasol</p></td>";} else {echo "-</p></td>";} 
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
    $vtramt=$_POST['vtramt'];
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
    if ($vpagotasa=='F1105928') {$vpagotasa='EXONERADA'; $vpag=0; 
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
       $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id='DA01' AND fac_id=$fac_id"); 
       $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
       if ($objtotdtalle==0) {
         mensajenew('ERROR: Factura NO presenta ning&uacute;n pago de Tasa de Presentaci&oacute;n de Marcas ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
       $objsdet  = $mysql->objects_mysql('',$objdetalle);
       $can_tasa = $objsdet->dtalle1_cantidad_ser;
       $comenpagotasa='Factura: '.$vpagotasa;
    
       // Verificar si la factura ya fué usada en otras solicitudes
       $sql = new mod_db();
       $sql->connection();
       $query_tasas=pg_exec("SELECT evento FROM stdevtrd 
                             WHERE evento=64 and comentario = '$comenpagotasa'");
       $filas_tasas = pg_numrows($query_tasas);    
       if ($filas_tasas >= $can_tasa) {
          mensajenew('ERROR: Factura ya fue utilizada en otra(s) solicitud(es)...!!! Verifique...','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); }
       //fin verificacion facturacion
    }

    $sql = new mod_db();
    $sql->connection();

    $vaccion=$_POST['vaccion'];
    $tramite= $vtramt;
    //Generacion del Numero de Planilla
    $vnpla=$vsol;

    //Generacion del Numero de Derecho 
    $obj_query = $sql->query("update stzsystem set nro_derecho=nextval('stzsystem_nro_derecho_seq')");
    if ($obj_query) {
      $obj_query = $sql->query("select last_value from stzsystem_nro_derecho_seq");
      $objs = $sql->objects('',$obj_query);
      $prox_derecho = $objs->last_value; }
    
    //***Datos para stdobras 
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_obra="SELECT * FROM stdsolobra WHERE nro_tramite = '$vtramt' and nro_referencia= '$vsol'";
    $regobra = $sql1->query1($query_obra);
    $regis_obra = $sql1->objects1('',$regobra);
    $vder = $prox_derecho;
    $vfechas = $fechahoy;
    $vtitulo = $regis_obra->titulo_obra;
    $vpla =    $regis_obra->tipo_obra;
    $vclas =   $regis_obra->clase;
    $vorigen = $regis_obra->origen;
    $vforma =  $regis_obra->forma;
    $vpaisor = $regis_obra->pais_origen;
    $vcodidi = $regis_obra->cod_idioma;
    $vnum_ej = $regis_obra->n_ejemplares;
    $vsop_de = $regis_obra->tipo_soporte;
    $vobs_de = $regis_obra->observacion;
    $vnum_ho = 0;
    $vamplia = ' ';
    $vadicio = $regis_obra->descrip_cap;
    $vimag =   $regis_obra->imagenes;
    $vpimag =  $regis_obra->procedencia_imag;
    $vnumpla = $regis_obra->nro_referencia;
    $vdescri = $regis_obra->descrip_obra;
    $vtraduc = $regis_obra->traduccion;
    $vanorea = $regis_obra->anno_realiza;
    $vanoppu = $regis_obra->anno_1publica;
    $sql1->disconnect1();

    //***Datos para stdmusic
    // aplica sólo para obras musicales
    if ($vpla=='OM') { 
      $sql1 = new mod_db();
      $sql1->connection1();
      $query_obramus="SELECT * FROM stdtmpmus WHERE nro_tramite = '$vtramt' and nro_referencia= '$vsol'";
      $regobramus = $sql1->query1($query_obramus);
      $regis_obramus = $sql1->objects1('',$regobramus);
      $vcodg = $regis_obramus->cod_genero;
      $vletr = $regis_obramus->letra;
      if ($vletr=='S') {$vletr='TRUE';} else {$vletr='FALSE';}
      $vritm = $regis_obramus->ritmo;
      $vdapf = $regis_obramus->dat_produ_fon;
      $vfinc = $regis_obramus->fin_comercial;
      if (empty($vfinc)) {$vfinc='FALSE';}
      $vafis = $regis_obramus->anno_fija_sono;      
      $vntem = $regis_obramus->n_temas;
      $vdtem = $regis_obramus->d_temas;
      $vdpub = $regis_obramus->d_publicacion;
      $vdint = $regis_obramus->d_interpretes;
      $sql1->disconnect1();
    }

    if ($vpla=='AC') { 
      $sql1 = new mod_db();
      $sql1->connection1();
      $query_obraac="SELECT * FROM stdactos WHERE nro_tramite = '$vtramt' and nro_referencia= '$vsol'";
      $regobraac = $sql1->query1($query_obraac);
      $regis_obraac = $sql1->objects1('',$regobraac);
      $vpart = $regis_obraac->partes;
      $vnatu = $regis_obraac->naturaleza;
      $vobje = $regis_obraac->objeto;
      $vdere = $regis_obraac->derechos;
      $vtipo = $regis_obraac->tipo_cuantia;
      $vcuan = $regis_obraac->espec_cuantia;
      $vdura = $regis_obraac->duracion;      
      $vdomi = $regis_obraac->domicilio;
      $vpfir = $regis_obraac->pais_firma;
      $vffir = $regis_obraac->fecha_firma;
      $vdreg = $regis_obraac->datosregistro;
      $vcodi = $regis_obraac->cod_idioma;
      $vanex = $regis_obraac->anexos;
      $sql1->disconnect1();
    }

     //***Datos para stdvisua
    // aplica sólo para obras Arte Visual
    if ($vpla=='AV') { 
      $sql1 = new mod_db();
      $sql1->connection1();
      $query_obravis="SELECT * FROM stdtmpvis WHERE nro_tramite = '$vtramt' and nro_referencia= '$vsol'";
      $regobravis = $sql1->query1($query_obravis);
      $regis_obravis = $sql1->objects1('',$regobravis);
      $vcodg = $regis_obravis->cod_genero;
      $vexhi = $regis_obravis->exhibida;
      $vpubl = $regis_obravis->publicada;
      $vedif = $regis_obravis->edificada;
      $vubiex= $regis_obravis->ubica_exhibi;
      $vdpub = $regis_obravis->datos_public;
      $vubied= $regis_obravis->ubica_edifica;
      if ($vexhi=='S') {$vexhi='TRUE';} else {$vexhi='FALSE';}
      if ($vpubl=='S') {$vpubl='TRUE';} else {$vpubl='FALSE';}
      if ($vedif=='S') {$vedif='TRUE';} else {$vedif='FALSE';}
      $sql1->disconnect1();
    }

    //***Datos para stdderiv
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_deriv="SELECT * FROM stdtmpderiv WHERE nro_tramite = '$vtramt' and nro_referencia= '$vsol'";
    $regderiv = $sql1->query1($query_deriv);
    $regis_deriv = $sql1->objects1('',$regderiv);
    $vtit_oo = $regis_deriv->titulo_original;
    $vaut_oo = $regis_deriv->datos_autor;
    $vtip_od = $regis_deriv->tipo_obra_deri;
    $vano_oo = $regis_deriv->anno_pub_orig;
    $sql1->disconnect1();

    //***Datos para stdtrans 
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_trans="SELECT * FROM stdtmptrans WHERE nro_tramite = '$vtramt' and nro_referencia= '$vsol'";
    $regtrans = $sql1->query1($query_trans);
    $regis_trans = $sql1->objects1('',$regtrans);
    $vtransf = $regis_trans->transferencia;
    $sql1->disconnect1();

    //***Datos para stdobsol - Solicitantes 
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_obsol="SELECT * FROM stdtmpsol WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $regobsol = $sql1->query1($query_obsol);
    $filas_obsol = $sql1->nums1('',$regobsol);
    $sql1->disconnect1();

    //***Datos para stdobtit - Titulares 
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_obtit="SELECT * FROM stdtmptit WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $regobtit = $sql1->query1($query_obtit);
    $filas_obtit = $sql1->nums1('',$regobtit);
    $sql1->disconnect1();

    //***Datos para stdobaut - Autores 
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_obaut="SELECT * FROM stdtmpaut WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $regobaut = $sql1->query1($query_obaut);
    $filas_obaut = $sql1->nums1('',$regobaut);
    $sql1->disconnect1();

    //***Datos para stdobedi - Editores 
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_obedi="SELECT * FROM stdtmpedi WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $regobedi = $sql1->query1($query_obedi);
    $filas_obedi = $sql1->nums1('',$regobedi);
    $query_edici="SELECT * FROM stdtmpedici WHERE nro_tramite = '$vtramt' and nro_referencia= '$vsol'";
    $regedici = $sql1->query1($query_edici);
    $regis_edici = $sql1->objects1('',$regedici);
    $ved_cara = $regis_edici->caracteristicas;
    $ved_neje = $regis_edici->n_ejemplares;
    $ved_apub = $regis_edici->anno_public;
    $ved_nedi = $regis_edici->n_edicion;
    if (empty($ved_neje)) {$ved_neje=0;}
    if (empty($ved_apub)) {$ved_apub=0;}
    if (empty($ved_nedi)) {$ved_nedi=0;}
    $sql1->disconnect1();
    
    //***Datos para stdobpar - Partes
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_obpar="SELECT * FROM stdpartes WHERE nro_tramite = '$vtramt' and nro_referencia= '$vsol'";
    $regobpar = $sql1->query1($query_obpar);
    $filas_obpar = $sql1->nums1('',$regobpar);
    $sql1->disconnect1();

//*******************************************************************************************************************     
    // Grabar en sipi
    $sql = new mod_db();
    $sql->connection();  
    //Verificando conexion
    $sql->connection($login);
 
    //***Datos para stdevtrd 
    $query_even="SELECT * FROM stdevobr WHERE evento=200";
    $regeven = $sql->query($query_even);
    $regis_even = $sql->objects('',$regeven);
    $vdescrip_ev200 = $regis_even->descripcion;

    $query_even="SELECT * FROM stdevobr WHERE evento=64";
    $regeven = $sql->query($query_even);
    $regis_even = $sql->objects('',$regeven);
    $vdescrip_ev64 = $regis_even->descripcion;

    // Colocar valores a variables cuando esten en blanco
    if ($vanoppu=='') { $vanoppu=0;}
    if ($vanorea=='') { $vanorea=0;}
    if ($vano_fs=='') { $vano_fs=0;}
    if ($vano_oo=='') { $vano_oo=0;}
    if ($vnumpla=='') { $vnumpla=0;}
    if ($vexhibi=='') { $vexhibi='N';}
    if ($vpublic=='') { $vpublic='N';}
    if ($vedific=='') { $vedific='N';}
    if ($vclasif=='') { $vclasif='N';}
    if ($vorigen=='') { $vorigen='N';}
    if ($vforma=='')  { $vforma='N';}
    if ($tipo_soporte=='') {$tipo_soporte=='PAPEL';}

    //Identificacion de Datos en la Hoja Adicional
    $vdatos_adicionales='';
    $vaitem=1;
    if (strlen($vdescri)>600) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Continuación de la Descripción de la Obra. ';
       $vaitem=$vaitem+1;} 
    if (strlen($vtit_oo)>130) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Continuación del Titulo de la Obra Originaria. '; 
       $vaitem=$vaitem+1;}
    if (strlen($vtransf)>270) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Continuación de los datos de la Transferencia. '; 
       $vaitem=$vaitem+1;}
    if (strlen($vobs_de)>210) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Continuación de los datos del Depósito. '; 
       $vaitem=$vaitem+1;}
    if ($filas_obaut>2) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Continuación de los datos de los Autores. '; 
       $vaitem=$vaitem+1;}
    if ($filas_obtit>1) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Continuación de los datos de los Titulares. '; 
       $vaitem=$vaitem+1;}
    if ($filas_obedi>1) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Continuación de los datos de los Editores/Impresores. '; 
       $vaitem=$vaitem+1;}
    if ($filas_obsol>1) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Continuación de los datos de los Solicitantes. '; 
       $vaitem=$vaitem+1;}
    if ($vntem>0) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Cantidad de Temas: '.$vntem.' '; 
       $vaitem=$vaitem+1;}
    if (!empty($vdtem)) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Descripción de los Temas: '.$vdtem.' '; 
       $vaitem=$vaitem+1;}
    if (!empty($vdint)) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Datos de los Interpretes: '.$vdint.' '; 
       $vaitem=$vaitem+1;}
    /// Literarias
    if (!empty($vadicio)) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Descripción de los Capitulos: '.$vadicio.' '; 
       $vaitem=$vaitem+1;}
    if (!empty($vimag)) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Contiene Imágenes: '.$vimag.' '; 
       $vaitem=$vaitem+1;}
    if (!empty($vpimag)) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Procedencia de las Imágenes: '.$vpimag.' '; 
       $vaitem=$vaitem+1;}
    ///Musicales
    if (!empty($vdtem)) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Cantidad de Temas: '.$vntem.' '; 
       $vaitem=$vaitem+1;}
    if (!empty($vdtem)) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Descripción de los Temas: '.$vdtem.' '; 
       $vaitem=$vaitem+1;}
    if (!empty($vdint)) {
       $vdatos_adicionales=$vdatos_adicionales.$vaitem.'.- Datos de los Interpretes: '.$vdint.' '; 
       $vaitem=$vaitem+1;}

    if (!empty($vdatos_adicionales)) {
          $vadicio=$vdatos_adicionales;
          $vnum_ho=1;}

    pg_exec("BEGIN WORK");
    // Insertamos primero en la Tabla Maestra de Obras 
    $can_error=0;
    $res_vder=pg_exec("SELECT nextval('stzsystem_nro_derecho_seq') as vder FROM stzsystem");
    $reg_vder = pg_fetch_array($res_vder); 
    $vder=$reg_vder[vder]; 
    $col_campos = "nro_derecho,solicitud,fecha_solic,titulo_obra,tipo_obra,clase,origen,forma,
    cod_idioma,estatus,pais_origen,n_ejemplares,tipo_soporte,observacion,n_hojas_adic,datos_ampli,
                 datos_adicio,nplanilla,descrip_obra,traduccion,anno_realiza,anno_1publica";
    $insert_str = "$vder,
                 '-','$vfechas','$vtitulo','$vpla','$vclas','$vorigen','$vforma',
                 '$vcodidi',1,'$vpaisor',$vnum_ej,'$vsop_de','$vobs_de',$vnum_ho,'$vamplia',
                 '$vadicio','$vnumpla','$vdescri','$vtraduc',$vanorea,$vanoppu";
    $valido = $sql->insert("stdobras","$col_campos","$insert_str","");
    if (!$valido) {$can_error=$can_error+1; } 

    // Insertamos en la Tabla Musical
    // aplica sólo para obras musicales
    if ($vpla=='OM') {
       $col_campos = "nro_derecho,cod_genero,letra,ritmo,dat_produ_fon,anno_fija_sono,
                      n_temas,d_temas,d_publicacion,d_interpretes,fin_comercial";
       $insert_str = "'$vder','$vcodg','$vletr','$vritm','$vdapf','$vafis','$vntem','$vdtem','$vdpub','$vdint','$vfinc'";
       $valido = $sql->insert("stdmusic","$col_campos","$insert_str","");
       if (!$valido) {$can_error=$can_error+1;} 
    }
    // Insertamos en la Tabla visua
    // aplica sólo para obras Arte Visual
    if ($vpla=='AV') {
       $col_campos = "nro_derecho,cod_genero,exhibida,ubica_exhibi,publicada,datos_public,edificada,ubica_edifica";
       $insert_str = "'$vder','$vcodg','$vexhi','$vubiex','$vpubl','$vdpub','$vedif','$vubied'";
       $valido = $sql->insert("stdvisua","$col_campos","$insert_str","");
       if (!$valido) {$can_error=$can_error+1;} 
    }

    // Tabla Stdobpar / Partes y Persona Natural o Juridica 
    for($i=0;$i<$filas_obpar;$i++) 
    {
       $regis_obpar = $sql1->objects1('',$regobpar);
       $viden=trim($regis_obpar->identificacion);
       $vindo=$regis_obpar->indole;
       $vestc=trim($regis_obpar->estado_civil);
       if ($vestc=='') {$vestc='S';}
       $vpdom=trim($regis_obpar->pais_domicilio);
       $vdomi=trim($regis_obpar->domicilio);
       $vnomb=$regis_obpar->nombre;
       $vtel1=$regis_obpar->telefono1;
       $vtel2=$regis_obpar->telefono2;
       $vema1=$regis_obpar->email;
       $vema2=$regis_obpar->email2;
       $vtipp=$regis_obpar->indole;
       $vgene=$regis_obpar->genero;
       $vprof=substr($regis_obpar->profesion,0,39);
       $vseud=$regis_obpar->seudonimo;
       $vfnac=$regis_obpar->fecha_nac;
       $vcara=$regis_obpar->caracter;
       $vprur=$regis_obpar->prueba_repres;
       $vcedr=$regis_obpar->cedula_repre;
       $vdatr=$regis_obpar->prueba_repre;
       $vnomr=$regis_obpar->nombre_repre;
       $vcuar=$regis_obpar->cualidad_repre;
       if ($vindo=="N")
       {  
          $res_nat=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$viden'"); 
          $filas_natur=0; $filas_natur=pg_numrows($res_nat);     
          if ($filas_natur==0 and $vpdom!='' and $vdomi!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,email,email2,tipo_persona,genero";
            $insert_str = "'$viden','$vnomb','$vindo','$vtel1','$vtel2','$vema1','$vema2','$vtipp','$vgene'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,estado_civil,profesion,seudonimo";
            $insert_str = "'$vtit','$vestc','$vprof','$vseud'";
            if (!empty($vfnac)) {
               $col_campos = $col_campos.",fecha_nacim";
               $insert_str = $insert_str.",'$vfnac'";
            }
            if (!empty($vtit)) { $valido = $sql->insert("stzdaper","$col_campos","$insert_str",""); }
          }
          else {
            //Actualizar
            $reg_nat = pg_fetch_array($res_nat); 
            $vtit=$reg_nat[titular];
            $update_str = "identificacion='$viden',indole='$vindo',telefono1='$vtel1',telefono2='$vtel2',email='$vema1',email2='$vema2',
                          tipo_persona='$vindo',genero='$vgene',nombre='$vnomb'"; 
            $updsolic = $sql->update("stzsolic","$update_str","titular='$vtit'");
            $update_str = "estado_civil='$vestc',profesion='$vprof',seudonimo='$vseud'";
            if (!empty($vfnac)) {
               $update_str = $col_campos.",fecha_nacim='$vfnac'";  }
            $updpnat = $sql->update("stzdaper","$update_str","titular='$vtit'");
          }
       } else {
          $res_jur=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$viden'");
          $filas_juridr=pg_numrows($res_jur);
          if ($filas_juridr==0 and $vpdom!='' and $vdomi!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,email,email2,tipo_persona";
            $insert_str = "'$viden','$vnomb','$vindo','$vtel1','$vtel2','$vema1','$vema2','$vtipp'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,datos_registro,cedula_repre";
            $insert_str = "'$vtit','$vprur','$vcedr'";
            $valido = $sql->insert("stzdajur","$col_campos","$insert_str","");
            // stdrepre
            $res_repre=pg_exec("select * from stdrepre where nro_derecho='$vder' and cedula_repre='$vcedr'");
            $filas_repre=pg_numrows($res_repre); 
            if ($filas_repre==0  and $vcedr<>'') {
               $col_campos = "nro_derecho,cedula_repre,nombre_repre,cualidad_repre,prueba";
               $insert_str = "'$vder','$vcedr','$vnomr','$vcuar','$vdatr'";
               $valido = $sql->insert("stdrepre","$col_campos","$insert_str",""); 
            }
          }
          else {
            //Actualizar
            $reg_jur = pg_fetch_array($res_jur); 
            $vtit=$reg_jur[titular];
            $update_str = "identificacion='$viden',indole='$vindo',telefono1='$vtel1',telefono2='$vtel2',email='$vema1',email2='$vema2',
                          tipo_persona='$vindo',genero='$vgene',nombre='$vnomb'";
            $updsolic = $sql->update("stzsolic","$update_str","titular='$vtit'");
            $update_str = "datos_registro='$vprur',cedula_repre='$vcedr'";
            $updpnat = $sql->update("stzdajur","$update_str","titular='$vtit'");
            // stdrepre
            $res_repre=pg_exec("select * from stdrepre where nro_derecho='$vder' and cedula_repre='$vcedr'");
            $filas_repre=pg_numrows($res_repre); 
            if ($filas_repre==0  and $vcedr<>'') {
               $col_campos = "nro_derecho,cedula_repre,nombre_repre,cualidad_repre,prueba";
               $insert_str = "'$vder','$vcedr','$vnomr','$vcuar','$vdatr'";
               $valido = $sql->insert("stdrepre","$col_campos","$insert_str",""); 
            }
          }
       }
       //Ingreso en la tabla stdobpar
       $col_campos = "nro_derecho,nro_documento,caracter,prueba_repres,titular,domicilio,pais_resid"; 
       $insert_str = "'$vder','$viden','$vcara','$vprur',$vtit,'$vdomi','$vpdom'";
       $valido = $sql->insert("stdobpar","$col_campos","$insert_str",""); 
    }
    // fin partes

    // aplica sólo para Actos y Contratos
    if ($vpla=='AC') {
       $col_campos = "nro_derecho,partes,naturaleza,objeto,derechos,tipo_cuantia,espec_cuantia,duracion,domicilio,fecha_firma,datosregistro";
       $insert_str = "'$vder','$vpart','$vnatu','$vobje','$vdere','$vtipo','$vcuan','$vdura','$vdomi','$vffir','$vdreg'";
       $valido = $sql->insert("stdactos","$col_campos","$insert_str","");
       if (!$valido) {$can_error=$can_error+1;} 
    }

    // Insertamos en la Tabla Derivadas
    if ($vtit_oo!='' or !empty($vtit_oo)) {
       $col_campos = "nro_derecho,titulo_original,datos_autor,tipo_obra_deri,anno_pub_orig,
                    n_versiones_aut";
       $insert_str = "'$vder','$vtit_oo','$vaut_oo','$vtip_od','$vano_oo',0";
       $valido = $sql->insert("stdderiv","$col_campos","$insert_str","");
       if (!$valido) {$can_error=$can_error+1;} 
    } 

    // Insertamos en la Tabla Transferencia
    if ($vtransf!='' or !empty($vtransf)) {
       $col_campos = "nro_derecho,transferencia";
       $insert_str = "'$vder','$vtransf'";
       $valido = $sql->insert("stdtrans","$col_campos","$insert_str","");
       if (!$valido) {$can_error=$can_error+1;} 
    } 

    // Insertamos en la Tabla de Tramite 
    $vcomen_ev200='Tramite: '.$vtramt.' Ref: '.$vsol;
    $vcomen_ev64='Factura: '.$vpagotasa;
    $vdocfac=$vpag;
    // Evento 200 - ingreso
    $col_campos = "nro_derecho,evento,fecha_event,estat_ant,secuencial,
                    fecha_trans,usuario,desc_evento,hora,comentario";
    $insert_str = "'$vder','200','$vfechas','0',nextval('stdevtrd_secuencial_seq'),
                    '$fechahoy','$usuario','$vdescrip_ev200','$horactual','$vcomen_ev200'";
    $valido = $sql->insert("stdevtrd","$col_campos","$insert_str",""); 
    if (!$valido) {$can_error=$can_error+1;} 
    // Evento 64 pago de tasa
    $col_campos = "nro_derecho,evento,fecha_event,estat_ant,secuencial,
                    fecha_trans,usuario,desc_evento,hora,documento,comentario";
    $insert_str = "'$vder','64','$vfechas','0',nextval('stdevtrd_secuencial_seq'),
                    '$fechahoy','$usuario','$vdescrip_ev64','$horactual',$vdocfac,'$vcomen_ev64'";
    $valido = $sql->insert("stdevtrd","$col_campos","$insert_str",""); 
    if (!$valido) {$can_error=$can_error+1;} 

    // Tabla Stdobsol / Solicitante y Persona Natural o Juridica 
    for($i=0;$i<$filas_obsol;$i++) 
    {
       $regis_obsol = $sql1->objects1('',$regobsol);
       $viden=$regis_obsol->identificacion;
       $vindo=$regis_obsol->indole;
       $vestc=$regis_obsol->estado_civil;
       if ($vestc=='') {$vestc='S';}
       $vpdom=$regis_obsol->pais_domicilio;
       $vdomi=$regis_obsol->domicilio;
       $vnomb=$regis_obsol->nombre;
       $vtel1=$regis_obsol->telefono1;
       $vtel2=$regis_obsol->telefono2;
       $vema1=$regis_obsol->email;
       $vema2=$regis_obsol->email2;
       $vtipp=$regis_obsol->indole;
       $vgene=$regis_obsol->genero;
       $vprof=substr($regis_obsol->profesion,0,39);
       $vseud=$regis_obsol->seudonimo;
       $vfnac=$regis_obsol->fecha_nac;
       $vcara=$regis_obsol->caracter;
       if ($vcara=='E') {$vcara='O';}
       $vprur=$regis_obsol->prueba_repres;
       $vcedr=$regis_obsol->cedula_repre;
       $vdatr=$regis_obsol->prueba_repre;
       $vnomr=$regis_obsol->nombre_repre;
       $vcuar=$regis_obsol->cualidad_repre;
       if ($vindo=="N")
       {  
          $res_nat=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$viden'"); 
          $filas_natur=pg_numrows($res_nat);      
          if ($filas_natur==0 and $vpdom!='' and $vdomi!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,email,email2,tipo_persona,genero";
            $insert_str = "'$viden','$vnomb','$vindo','$vtel1','$vtel2','$vema1','$vema2','$vtipp','$vgene'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,estado_civil,profesion,seudonimo";
            $insert_str = "'$vtit','$vestc','$vprof','$vseud'";
            if (!empty($vfnac)) {
               $col_campos = $col_campos.",fecha_nacim";
               $insert_str = $insert_str.",'$vfnac'";
            }
            if (!empty($vtit)) { $valido = $sql->insert("stzdaper","$col_campos","$insert_str",""); }
          
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
          }
          else {
            //Actualizar
            $reg_nat = pg_fetch_array($res_nat); 
            $vtit=$reg_nat[titular];
            $update_str = "identificacion='$viden',indole='$vindo',telefono1='$vtel1',telefono2='$vtel2',email='$vema1',email2='$vema2',
                          tipo_persona='$vindo',genero='$vgene',nombre='$vnomb'"; 
            $updsolic = $sql->update("stzsolic","$update_str","titular='$vtit'");
//            if (!$updsolic) {$gbcorrecto=$gbcorrecto+1;}
            $update_str = "estado_civil='$vestc',profesion='$vprof',seudonimo='$vseud'";
            if (!empty($vfnac)) {
               $update_str = $col_campos.",fecha_nacim='$vfnac'";  }
            $updpnat = $sql->update("stzdaper","$update_str","titular='$vtit'");
          }
       } else {
          $res_jur=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$viden'");
          $filas_juridr=pg_numrows($res_jur);
          if ($filas_juridr==0 and $vpdom!='' and $vdomi!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,email,email2,tipo_persona";
            $insert_str = "'$viden','$vnomb','$vindo','$vtel1','$vtel2','$vema1','$vema2','$vtipp'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
 //           if (!$valido) {$gbcorrecto=$gbcorrecto+1;} 
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,datos_registro,cedula_repre";
            $insert_str = "'$vtit','$vprur','$vcedr'";
            $valido = $sql->insert("stzdajur","$col_campos","$insert_str","");
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            // stdrepre
            $res_repre=pg_exec("select * from stdrepre where nro_derecho='$vder' and cedula_repre='$vcedr'");
            $filas_repre=pg_numrows($res_repre); 
            if ($filas_repre==0  and $vcedr<>'') {
               $col_campos = "nro_derecho,cedula_repre,nombre_repre,cualidad_repre,prueba";
               $insert_str = "'$vder','$vcedr','$vnomr','$vcuar','$vdatr'";
               $valido = $sql->insert("stdrepre","$col_campos","$insert_str",""); 
//               if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            }
          }
          else {
            //Actualizar
            $reg_jur = pg_fetch_array($res_jur); 
            $vtit=$reg_jur[titular];
            $update_str = "identificacion='$viden',indole='$vindo',telefono1='$vtel1',telefono2='$vtel2',email='$vema1',email2='$vema2',
                          tipo_persona='$vindo',genero='$vgene',nombre='$vnomb'";
            $updsolic = $sql->update("stzsolic","$update_str","titular='$vtit'");
//            if (!$updsolic) {$gbcorrecto=$gbcorrecto+1;}
            $update_str = "datos_registro='$vprur',cedula_repre='$vcedr'";
            $updpnat = $sql->update("stzdajur","$update_str","titular='$vtit'");
            // stdrepre
            $res_repre=pg_exec("select * from stdrepre where nro_derecho='$vder' and cedula_repre='$vcedr'");
            $filas_repre=pg_numrows($res_repre); 
            if ($filas_repre==0  and $vcedr<>'') {
               $col_campos = "nro_derecho,cedula_repre,nombre_repre,cualidad_repre,prueba";
               $insert_str = "'$vder','$vcedr','$vnomr','$vcuar','$vdatr'";
               $valido = $sql->insert("stdrepre","$col_campos","$insert_str",""); 
//               if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            }
          }
       }
       //Ingreso en la tabla stdobsol
       $col_campos = "nro_derecho,caracter,prueba_repres,titular,domicilio,pais_resid"; 
       $insert_str = "'$vder','$vcara','$vprur','$vtit','$vdomi','$vpdom'";
       $valido = $sql->insert("stdobsol","$col_campos","$insert_str",""); 
//       if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
    }
    // fin solicitante

    // Tabla Stdobtit / Titular y Persona Natural o Juridica 
    for($i=0;$i<$filas_obtit;$i++) 
    {
       $regis_obtit = $sql1->objects1('',$regobtit);
       $viden=$regis_obtit->identificacion;
       $vindo=$regis_obtit->indole;
       $vestc=$regis_obtit->estado_civil;
       if ($vestc=='') {$vestc='S';}
       $vpdom=$regis_obtit->pais_domicilio;
       $vdomi=$regis_obtit->domicilio;
       $vnomb=$regis_obtit->nombre;
       $vtel1=$regis_obtit->telefono1;
       $vtel2=$regis_obtit->telefono2;
       $vema1=$regis_obtit->email;
       $vema2=$regis_obtit->email2;
       $vtipp=$regis_obtit->indole;
       $vgene=$regis_obtit->genero;
       //$vprof=$regis_obtit->profesion;
       $vprof='';
       $vseud=$regis_obtit->seudonimo;
       $vfnac=$regis_obtit->fecha_nac;
       //$vcara=$regis_obtit->caracter;
       //$vprur=$regis_obtit->prueba_repres;
       $vprur=$regis_obtit->rmercantil;
       //$vcedr=$regis_obtit->cedula_repre;
       $vcedr='';
       //$vdatr=$regis_obtit->prueba_repre;
       //$vnomr=$regis_obtit->nombre_repre;
       //$vcuar=$regis_obtit->cualidad_repre;
       $vtipl=$regis_obtit->titulo_presun;
       if ($vindo=="N")
       {  
          $res_nat=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$viden'"); 
          $filas_natur=pg_numrows($res_nat);      
          if ($filas_natur==0 and $vpdom!='' and $vdomi!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,email,email2,tipo_persona,genero";
            $insert_str = "'$viden','$vnomb','$vindo','$vtel1','$vtel2','$vema1','$vema2','$vtipp','$vgene'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,estado_civil,profesion,seudonimo";
            $insert_str = "'$vtit','$vestc','$vprof','$vseud'";
            if (!empty($vfnac)) {
               $col_campos = $col_campos.",fecha_nacim";
               $insert_str = $insert_str.",'$vfnac'";
            }
            if (!empty($vtit)) { $valido = $sql->insert("stzdaper","$col_campos","$insert_str",""); }
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
          }
          else {
            //Actualizar
            $reg_nat = pg_fetch_array($res_nat); 
            $vtit=$reg_nat[titular];
            $update_str = "identificacion='$viden',indole='$vindo',telefono1='$vtel1',telefono2='$vtel2',email='$vema1',email2='$vema2',
                          tipo_persona='$vindo',genero='$vgene',nombre='$vnomb'"; 
            $updsolic = $sql->update("stzsolic","$update_str","titular='$vtit'");
//            if (!$updsolic) {$gbcorrecto=$gbcorrecto+1;}
            $update_str = "estado_civil='$vestc',profesion='$vprof',seudonimo='$vseud'";
            if (!empty($vfnac)) {
               $update_str = $col_campos.",fecha_nacim='$vfnac'";  }
            $updpnat = $sql->update("stzdaper","$update_str","titular='$vtit'");
          }
       } else {
          $res_jur=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$viden'");
          $filas_juridr=pg_numrows($res_jur);
          if ($filas_juridr==0 and $vpdom!='' and $vdomi!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,email,email2,tipo_persona";
            $insert_str = "'$viden','$vnomb','$vindo','$vtel1','$vtel2','$vema1','$vema2','$vtipp'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
 //           if (!$valido) {$gbcorrecto=$gbcorrecto+1;} 
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,datos_registro,cedula_repre";
            $insert_str = "'$vtit','$vprur','$vcedr'";
            $valido = $sql->insert("stzdajur","$col_campos","$insert_str","");
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            // stdrepre
            $res_repre=pg_exec("select * from stdrepre where nro_derecho='$vder' and cedula_repre='$vcedr'");
            $filas_repre=pg_numrows($res_repre); 
            if ($filas_repre==0 and $vcedr<>'') {
               $col_campos = "nro_derecho,cedula_repre,nombre_repre,cualidad_repre,prueba";
               $insert_str = "'$vder','$vcedr','$vnomr','$vcuar','$vdatr'";
               $valido = $sql->insert("stdrepre","$col_campos","$insert_str",""); 
//               if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            }
          }
          else {
            //Actualizar
            $reg_jur = pg_fetch_array($res_jur); 
            $vtit=$reg_jur[titular];
            $update_str = "identificacion='$viden',indole='$vindo',telefono1='$vtel1',telefono2='$vtel2',email='$vema1',email2='$vema2',
                          tipo_persona='$vindo',genero='$vgene',nombre='$vnomb'";
            $updsolic = $sql->update("stzsolic","$update_str","titular='$vtit'");
//            if (!$updsolic) {$gbcorrecto=$gbcorrecto+1;}
            $update_str = "datos_registro='$vprur',cedula_repre='$vcedr'";
            $updpnat = $sql->update("stzdajur","$update_str","titular='$vtit'");
            // stdrepre
            $res_repre=pg_exec("select * from stdrepre where nro_derecho='$vder' and cedula_repre='$vcedr'");
            $filas_repre=pg_numrows($res_repre); 
            if ($filas_repre==0  and $vcedr<>'') {
               $col_campos = "nro_derecho,cedula_repre,nombre_repre,cualidad_repre,prueba";
               $insert_str = "'$vder','$vcedr','$vnomr','$vcuar','$vdatr'";
               $valido = $sql->insert("stdrepre","$col_campos","$insert_str",""); 
//               if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            }
          }
       }
       //Ingreso en la tabla stdobtit
       $col_campos = "nro_derecho,doc_titular,titulo_presun,doc_transfer,titular,domicilio,pais_resid"; 
       $insert_str = "'$vder','$viden','$vtipl','$vprur','$vtit','$vdomi','$vpdom'";
       $valido = $sql->insert("stdobtit","$col_campos","$insert_str",""); 
//       if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
    } 
    // fin titular

    // Tabla Stdobaut / Autor y Persona Natural o Juridica 
    for($i=0;$i<$filas_obaut;$i++) 
    {
       $regis_obaut = $sql1->objects1('',$regobaut);
       $viden=$regis_obaut->identificacion;
       $vindo=$regis_obaut->indole;
       $vestc=$regis_obaut->estado_civil;
       if ($vestc=='') {$vestc='S';}
       $vpdom=$regis_obaut->pais_domicilio;
       $vdomi=$regis_obaut->domicilio;
       $vnomb=$regis_obaut->nombre;
       $vtel1=$regis_obaut->telefono1;
       $vtel2=$regis_obaut->telefono2;
       $vema1=$regis_obaut->email;
       $vema2=$regis_obaut->email2;
       $vtipp=$regis_obaut->indole;
       $vgene=$regis_obaut->genero;
       //$vprof=$regis_obtit->profesion;
       $vprof='';
       $vseud=$regis_obtit->seudonimo;
       $vfnac=$regis_obtit->fecha_nac;
       if ($vindo=="N")
       {  
          $res_nat=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$viden'"); 
          $filas_natur=pg_numrows($res_nat);      
          if ($filas_natur==0 and $vpdom!='' and $vdomi!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,email,email2,tipo_persona,genero";
            $insert_str = "'$viden','$vnomb','$vindo','$vtel1','$vtel2','$vema1','$vema2','$vtipp','$vgene'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,estado_civil,profesion,seudonimo";
            $insert_str = "'$vtit','$vestc','$vprof','$vseud'";
            if (!empty($vfnac)) {
               $col_campos = $col_campos.",fecha_nacim";
               $insert_str = $insert_str.",'$vfnac'";
            }
            if (!empty($vtit)) { $valido = $sql->insert("stzdaper","$col_campos","$insert_str",""); }
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
          }
          else {
            //Actualizar
            $reg_nat = pg_fetch_array($res_nat); 
            $vtit=$reg_nat[titular];
            $update_str = "identificacion='$viden',indole='$vindo',telefono1='$vtel1',telefono2='$vtel2',email='$vema1',email2='$vema2',
                          tipo_persona='$vindo',genero='$vgene',nombre='$vnomb'"; 
            $updsolic = $sql->update("stzsolic","$update_str","titular='$vtit'");
//            if (!$updsolic) {$gbcorrecto=$gbcorrecto+1;}
            $update_str = "estado_civil='$vestc',profesion='$vprof',seudonimo='$vseud'";
            if (!empty($vfnac)) {
               $update_str = $col_campos.",fecha_nacim='$vfnac'";  }
            $updpnat = $sql->update("stzdaper","$update_str","titular='$vtit'");
          }
       } 
       //Ingreso en la tabla stdobaut
       $col_campos = "nro_derecho,doc_autor,tipo_autor,titular,domicilio,pais_resid,estado_civil,seudonimo"; 
       $insert_str = "'$vder','$viden','AU','$vtit','$vdomi','$vpdom','$vestc','$vseud'";
       if (!empty($vfnac)) { $col_campos=$col_campos.",fecha_nac";
                             $insert_str=$insert_str.",'$vfnac'"; }
       $valido = $sql->insert("stdobaut","$col_campos","$insert_str",""); 
//       if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
    } 
    // fin autor

    // Tabla Stdedici / Editor/Impresor y Persona Natural o Juridica 
    for($i=0;$i<$filas_obedi;$i++) 
    {
       $regis_obedi = $sql1->objects1('',$regobedi);
       $viden=$regis_obedi->identificacion;
       $vindo=$regis_obedi->indole;
       $vestc=$regis_obedi->estado_civil;
       if ($vestc=='') {$vestc='S';}
       $vpdom=$regis_obedi->pais_domicilio;
       $vdomi=$regis_obedi->domicilio;
       $vnomb=$regis_obedi->nombre;
       $vtel1=$regis_obedi->telefono1;
       $vtel2=$regis_obedi->telefono2;
       $vema1=$regis_obedi->email;
       $vema2=$regis_obedi->email2;
       $vtipp=$regis_obedi->indole;
       $vgene=$regis_obedi->genero;
       $vnaci=$regis_obtit->nacionalidad;
       $vprof='';
       $vseud=$regis_obedi->seudonimo;
       $vfnac=$regis_obedi->fecha_nac;
       $vprur=$regis_obedi->rmercantil;
       $vcedr='';
       $vtipe=$regis_obedi->tipo_edimpre;
       if ($vindo=="N")
       {  
          $res_nat=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$viden'"); 
          $filas_natur=pg_numrows($res_nat);      
          if ($filas_natur==0 and $vpdom!='' and $vdomi!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,email,email2,tipo_persona,genero";
            $insert_str = "'$viden','$vnomb','$vindo','$vtel1','$vtel2','$vema1','$vema2','$vtipp','$vgene'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,estado_civil,profesion,seudonimo";
            $insert_str = "'$vtit','$vestc','$vprof','$vseud'";
            if (!empty($vfnac)) {
               $col_campos = $col_campos.",fecha_nacim";
               $insert_str = $insert_str.",'$vfnac'";
            }
            if (!empty($vtit)) { $valido = $sql->insert("stzdaper","$col_campos","$insert_str",""); }
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
          }
          else {
            //Actualizar
            $reg_nat = pg_fetch_array($res_nat); 
            $vtit=$reg_nat[titular];
            $update_str = "identificacion='$viden',indole='$vindo',telefono1='$vtel1',telefono2='$vtel2',email='$vema1',email2='$vema2',
                          tipo_persona='$vindo',genero='$vgene',nombre='$vnomb'"; 
            $updsolic = $sql->update("stzsolic","$update_str","titular='$vtit'");
//            if (!$updsolic) {$gbcorrecto=$gbcorrecto+1;}
            $update_str = "estado_civil='$vestc',profesion='$vprof',seudonimo='$vseud'";
            if (!empty($vfnac)) {
               $update_str = $col_campos.",fecha_nacim='$vfnac'";  }
            $updpnat = $sql->update("stzdaper","$update_str","titular='$vtit'");
          }
       } else {
          $res_jur=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$viden'");
          $filas_juridr=pg_numrows($res_jur);
          if ($filas_juridr==0 and $vpdom!='' and $vdomi!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,email,email2,tipo_persona";
            $insert_str = "'$viden','$vnomb','$vindo','$vtel1','$vtel2','$vema1','$vema2','$vtipp'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
 //           if (!$valido) {$gbcorrecto=$gbcorrecto+1;} 
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,datos_registro,cedula_repre";
            $insert_str = "'$vtit','$vprur','$vcedr'";
            $valido = $sql->insert("stzdajur","$col_campos","$insert_str","");
//            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            // stdrepre
            $res_repre=pg_exec("select * from stdrepre where nro_derecho='$vder' and cedula_repre='$vcedr'");
            $filas_repre=pg_numrows($res_repre); 
            if ($filas_repre==0 and $vcedr<>'') {
               $col_campos = "nro_derecho,cedula_repre,nombre_repre,cualidad_repre,prueba";
               $insert_str = "'$vder','$vcedr','$vnomr','$vcuar','$vdatr'";
               $valido = $sql->insert("stdrepre","$col_campos","$insert_str",""); 
//               if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            }
          }
          else {
            //Actualizar
            $reg_jur = pg_fetch_array($res_jur); 
            $vtit=$reg_jur[titular];
            $update_str = "identificacion='$viden',indole='$vindo',telefono1='$vtel1',telefono2='$vtel2',email='$vema1',email2='$vema2',
                          tipo_persona='$vindo',genero='$vgene',nombre='$vnomb'";
            $updsolic = $sql->update("stzsolic","$update_str","titular='$vtit'");
//            if (!$updsolic) {$gbcorrecto=$gbcorrecto+1;}
            $update_str = "datos_registro='$vprur',cedula_repre='$vcedr'";
            $updpnat = $sql->update("stzdajur","$update_str","titular='$vtit'");
            // stdrepre
            $res_repre=pg_exec("select * from stdrepre where nro_derecho='$vder' and cedula_repre='$vcedr'");
            $filas_repre=pg_numrows($res_repre); 
            if ($filas_repre==0  and $vcedr<>'') {
               $col_campos = "nro_derecho,cedula_repre,nombre_repre,cualidad_repre,prueba";
               $insert_str = "'$vder','$vcedr','$vnomr','$vcuar','$vdatr'";
               $valido = $sql->insert("stdrepre","$col_campos","$insert_str",""); 
//               if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            }
          }
       }
       //Ingreso en la tabla stdedici
       $col_campos = "nro_derecho,doc_edimpres,titular,domicilio,pais_resid,editor_impres,caracteristicas,n_ejemplares,anno_publica,n_edicion"; 
       $insert_str = "'$vder','$viden','$vtit','$vdomi','$vpdom','$vtipe','$ved_cara','$ved_neje','$ved_apub','$ved_nedi'";
       $valido = $sql->insert("stdedici","$col_campos","$insert_str",""); 
//       if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
    } 
    // fin editor/impresor


    if ($can_error==0) {

    if ($usuario=="rmendoza") { $v_sol = 888888; }
    else {
     $res_sol=pg_exec("select dsolicitud from stzsystem");
     $reg_sol = pg_fetch_array($res_sol); 
     $v_sol=$reg_sol[dsolicitud]+1;
     $v_sol=str_repeat('0',6-strlen($v_sol)).$v_sol; 
//   $v_sol='999888';
     $update_str="dsolicitud='$v_sol'";
     $valido1 = $sql->update("stzsystem","$update_str","true");
    }     
     $update_str="solicitud='$v_sol'";
     $update_cond="nro_derecho='$vder'";
     $valido2 = $sql->update("stdobras","$update_str","$update_cond");
//     if ($valido1 and $valido2) {

     // Actualiza tabla temporal consulta y el WEBPI
     $update_str = "estatus='52',solic_sipi= '$v_sol', fecha='$fechahoy', hora= '$horactual'";
     $upddetit = $sql->update("consulta","$update_str","solicitud='$vsol'");
   
     pg_exec("COMMIT WORK");  
     $sql->disconnect();

     //*** Cambia de estatus la solicitud en el WEBPI
     $sql1 = new mod_db();
     $sql1->connection1();  
     pg_exec("BEGIN WORK");  
     $actualiza=pg_exec("UPDATE stdsolobra SET estatus_sol='52',solicitud_sipi='$v_sol',solicitud_fecha='$fechahoy',solicitud_hora='$horactual' 
                         where nro_referencia ='$vsol' AND nro_tramite='$vtramt'");             

     $resultado_cant = pg_exec("SELECT * FROM stdsolobra where nro_tramite='$vtramt' ");
     $filas_cant = pg_numrows($resultado_cant); 
     $resultado_estatus = pg_exec("SELECT * FROM stdsolobra where nro_tramite='$vtramt' and estatus_sol='52'");
     $filas_estatus = pg_numrows($resultado_estatus);  
     if ($filas_estatus == $filas_cant) {
          $actual=pg_exec("UPDATE stztramite SET estatus_tra='52' where nro_tramite='$vtramt'");   }    
     pg_exec("COMMIT WORK"); 
     $sql1->disconnect1();  

     Mensaje("DATOS GUARDADOS CORRECTAMENTE BAJO EL NUMERO DE EXPEDIENTE: ".$v_sol,
             "a_ingresol.php?vopc=4&vtramt=$vtramt");
//     } else {
//        pg_exec("ROLLBACK WORK"); 
//        $sql->disconnect();
//        mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, 
//                 Error en datos asociados...!!!","javascript:history.back();","N");
//        $smarty->display('pie_pag.tpl'); exit();    
//     }
    } else {
     pg_exec("ROLLBACK WORK"); 
     $sql->disconnect();
     mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, 
                 Error en datos asociados...!!!","javascript:history.back();","N");}
     $smarty->display('pie_pag.tpl'); exit();    

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
     if ($registro_tram['estatus']== 52) {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solicitud]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solic_sipi]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_formsipi.php?vsol=$registro_tram[solic_sipi]''>FM-02</a></td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='a_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
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
$smarty->display('a_ingresol.tpl');
$smarty->display('pie_pag.tpl');
//ob_end_clean(); 
?>

