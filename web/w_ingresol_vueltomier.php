<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }
vtramt=$vtramt&vopc=4'

function planilla(v1,v2,v3) {
  open("w_planilla.php?vsol="+v1.value+"&vtramt="+v2.value+"&vopc=","Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function Ventana_001 (URL){ 
  window.open(URL,"UTERRA","width=500,height=300,top=20,left=40,scrollbars=NO,titlebar=NO,menubar=YES,toolbar=NO,directories=YES,location=YES,status=NO,resizable=NO") 
} 
  
</script>
<?php
// *************************************************************************************
// Programa: w_ingresol.php 
// Realizado por el Analista de Sistema  Karina Pérez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año 2010
// *************************************************************************************
// *************************************************************************************
include ("../setting.inc.php");
ob_start();

//Comienzo del Programa por los encabezados del reporte

include ("../z_includes.php");

//funcion del formulario
//include ("w_formulario.php");
//include ("w_grabar.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = $_SESSION['usuario_login'];
$role      = $_SESSION['usuario_rol'];
$fecha     = fechahoy();
$fechahoy  = hoy();
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
$recaud1=$_POST['recaud1'];
$recaud2=$_POST['recaud2'];
$recaud3=$_POST['recaud3'];
$recaud4=$_POST['recaud4'];
$recaud5=$_POST['recaud5'];
$recaud6=$_POST['recaud6'];
$recaud7=$_POST['recaud7'];
$recaud8=$_POST['recaud8'];

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
//    $sql1 = new mod_db();
//    $sql1->connection1();  
    $sql2 = new mod_db();
    $sql2->connection2();  

    $actual=pg_exec("UPDATE stztramite SET estatus_tra = '14'  where nro_tramite='$vtramt'");    
//    $sql1->disconnect1();
    $sql2->disconnect2();
      
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
     if ($registro_tram['estatus']== 15) {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solicitud]</td>";
//         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='web/w_formsipi.php?vsol=$vsol''>FM-02</a></td>";
         
         
         //echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
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
//    $sql1 = new mod_db();
//    $sql1->connection1();
    $sql2 = new mod_db();
    $sql2->connection2();

    //$resultado_tram = pg_exec("SELECT * FROM stzderec, stztramite, stmsolref 
    //			 	WHERE stzderec.nro_tramite = '$vtramt' 
    //			 	AND stzderec.nro_tramite = stztramite.nro_tramite
    //			 	AND  stzderec.estatus in ('0')
    //			 	AND stztramite.estatus_tra IN ('13','14','09') order by stzderec.solicitud");

    $resultado_tram = pg_exec("SELECT * FROM stmsolref, stztramite 
    			 	WHERE stztramite.nro_tramite = '$vtramt' 
    			 	AND stmsolref.nro_tramite = stztramite.nro_tramite
    			 	AND stztramite.estatus_tra IN ('13','14','09','10','15') order by stmsolref.solicitud");

    $filas_resultado_tram = pg_numrows($resultado_tram); 
  
//    $sql1->disconnect1();
    $sql2->disconnect2();
    
    if ($filas_resultado_tram==0) { mensajenew("AVISO: El Nro. del Tramite no esta Registrado o No tiene solicitudes que ingresar..!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); } 
    else{


    ?>

<p>&nbsp;</p>
<p align='center'><b><font > Solicitudes Asociadas al Tramite para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="10%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Solicitud </b></p></td>
<!--    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Estatus</b></td> -->
    <td width="30%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Solicitud-SIPI</b></p></td>
    <td colspan='2' width="30%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Ver Planillas</b></p></td>
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
$res_est = pg_exec("SELECT estatus FROM stzderec WHERE solicitud = '$registro_tram[solicitud_sipi]'");
$regest= pg_fetch_array($res_est);
//

  $resul_insert =pg_exec("INSERT INTO consulta (tramite,solicitud,estatus,solic_sipi,fecha,hora) VALUES ('$vtramt','$registro_tram[solicitud]','$registro_tram[estatus_sol]','$registro_tram[solicitud_sipi]','','')");
			    
 // echo "<LI> <a href='#' onclick=window.open('w_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4','miwin','width=900,height=700,scrollbars=yes')> Solicitud Nro: $registro_tram[solicitud] </a>";      

     $varsolic=trim($registro_tram['solicitud']);
     echo "<tr>";
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER >";
     if ($registro_tram[estatus_sol]<>'15') {echo "<a href='w_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>
        <input type='button' value='$varsolic' class='botones_rojo'></a></p></td>";} 
     else { echo "$registro_tram[solicitud]</p></td>";}
//     echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus_sol]</td>";
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     $vsol=$registro_tram[solicitud_sipi];
     $vsol1=substr($vsol,0,4);
     $vsol2=substr($vsol,5,6);
//     if ($registro_tram[estatus_sol]=='15') {echo "<a href='../expediente/m_rptexp.php?varsol=$vsol'><input type='button' value='$registro_tram[solicitud_sipi]' class='botones_rojo'></a></p></td>"; }
     if ($registro_tram[estatus_sol]=='15') {echo "$registro_tram[solicitud_sipi]</p></td>"; }
     else { echo "-</p></td>";}

//ver
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='15') {
        echo "<a href='w_formsipi.php?vsol=$registro_tram[solicitud_sipi]''><input type='button' value='FM-02' class='botones_rojo'></a>";
        echo "</p></td><td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";  
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

        //if ($regest[estatus]==1002) {echo "<a href='w_formsipi.php?vsol=$registro_tram[solicitud_sipi]''>Clis&eacute;</a>&nbsp;&nbsp;&nbsp;"; }
        //if ($regest[estatus]==1200) {echo "<a href='w_formsipi.php?vsol=$registro_tram[solicitud_sipi]''>Devoluci&oacute;n</a>"; }
     //echo "</td>";


//*** Guardar la solicitud en el SIPI  

if ($vopc== 6) {
    // Validar examen de forma
    $vaccion=$_POST['vaccion'];
//    $vcausa1=$_POST['causa1'];   $vcausa2=$_POST['causa2'];   $vcausa3=$_POST['causa3'];  
//    $vcausa4=$_POST['causa4'];   $vcausa5=$_POST['causa5'];   $vcausa6=$_POST['causa6'];  
//    $vcausa7=$_POST['causa7'];
//    $votro  =$_POST['otro'];
//    $vc1='';$vc2='';$vc3='';$vc4='';$vc5='';$vc6='';$vc7='';
//    if($vcausa1 =='on'){$vc1 ='X';};if($vcausa2 =='on'){$vc2 ='X';};if($vcausa3 =='on'){$vc3 ='X';}
//    if($vcausa4 =='on'){$vc4 ='X';};if($vcausa5 =='on'){$vc5 ='X';};if($vcausa6 =='on'){$vc6 ='X';}
//    if($vcausa7 =='on'){$vc7 ='X';}
//    $allcausas = $vc1.$vc2.$vc3.$vc4.$vc5.$vc6.$vc7.$votro;

    //$sql->disconnect();
//    $sql1 = new mod_db();
//    $sql1->connection1();
    $sql2 = new mod_db();
    $sql2->connection2();

    $query_est0=pg_exec("SELECT * FROM stzanxtra WHERE nro_tramite = '$vtramt' and solicitud='$vsol' and cod_anexo<>'C' and estatus='0'");
    $filest0=pg_numrows($query_est0); 
//    $sql1->disconnect1();
    $sql2->disconnect2();

    // aprobar examen de forma
//    if ($vaccion==1) {
//      if ($filest0>0) {
//          $mens=Mensajenew('Faltan cargar los Documentos Anexos a la solicitud!!! Verifique...','javascript:history.back();','N');
//          $smarty->display('pie_pag.tpl'); exit();  
//       }
//       if ($allcausas!='') {
//          $mens=Mensajenew('Se indicaron Causales de Devolución en el formulario!!! Verifique...','javascript:history.back();','N');
//          $smarty->display('pie_pag.tpl'); exit();  
//       }
//    }
    // generar oficio de devolucion
//    if ($vaccion==2) {
//       if ($filest0==0 and $allcausas=='') {
//          $mens=Mensajenew('No se encontraron causales de Devolución!!! Verifique...','javascript:history.back();','N');
//          $smarty->display('pie_pag.tpl'); exit();  
//       }
//    }
//    $mens=Mensajenew('Policia:'.$allcausas.$vaccion.$votro,'w_ingresol.php?vopc=7','S');
//    $smarty->display('pie_pag.tpl'); exit();  

    $sql = new mod_db();
    $sql->connection();
    //inicializar variables
    $insclanac  = true;
    $inslema = true;
    $instram = true;
    $inslogo = true;
    $insprio = true;
    $insagen = true;
    $insmarce = true;
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
      $num_sol = $objs->last_value; }
      $ano= substr($fechahoy,-4,4);
      $num_sol=sprintf("%06d",$num_sol);
      $numsol= $ano.'-'.$num_sol;
          
        
    //***Tipo de clase nacional 
//    $sql1 = new mod_db();
//    $sql1->connection1();
    $sql2 = new mod_db();
    $sql2->connection2();

    $query_clase="SELECT * FROM stmclnac WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $regclase_nac = $sql2->query2($query_clase);
    $regis_clase = $sql2->objects2('',$regclase_nac);
    $vclasenac = $regis_clase->clase_nac; 
//    $sql1->disconnect1();
    $sql2->disconnect2();

    //*** Tabla de Lemas Asociados     
    if ($tipo_marca=="L") {
//        $sql1 = new mod_db();
//        $sql1->connection1();
        $sql2 = new mod_db();
        $sql2->connection2();
        $query_lem="SELECT * FROM stmlemad WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
        $regis_lema = $sql2->query2($query_lem);
        $filas_resultado = $sql2->nums2('',$regis_lema);
        $regis_lema = $sql2->objects2('',$regis_lema);
//        $sql1->disconnect1();
        $sql2->disconnect2();
    }
    
    //*** Tabla de Eventos de Tramite  
    $horactual = Hora();
    //descripcion del evento
    $sql = new mod_db();
    $sql->connection();
    $resultado_tram=pg_exec("SELECT * FROM stzevder WHERE evento=1200");
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

    //*** Tabla de Prioridades   
//       $sql1 = new mod_db();
//       $sql1->connection1();
       $sql2 = new mod_db();
       $sql2->connection2();
       $query_prio="SELECT * FROM stzpriod WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
       $regis_prio = $sql2->query2($query_prio);
       $filas_prio = $sql2->nums2('',$regis_prio);
       $regis_prio = $sql2->objects2('',$regis_prio);
//       $sql1->disconnect1();
       $sql2->disconnect2();
     

    //*** Tabla de Agentes y apoderados ****************
//       $sql1 = new mod_db();
//       $sql1->connection1();
       $sql2 = new mod_db();
       $sql2->connection2();
       $query_agente="SELECT * FROM stzagenr,stzautod 
                             WHERE stzautod.nro_tramite = '$vtramt' 
                             AND stzautod.solicitud = '$vsol' 
                             AND stzagenr.agente = stzautod.agente ORDER BY stzautod.agente";                             
       $regisagente = $sql2->query2($query_agente);
       $filas_agente = $sql2->nums2('',$regisagente);
       $regis_agente = $sql2->objects2('',$regisagente);
//      $sql1->disconnect1();
       $sql2->disconnect2();
              
    //*** Tabla de Poderes ****************
//       $sql1 = new mod_db();
//       $sql1->connection1();
       $sql2 = new mod_db();
       $sql2->connection2();
       $query_poder="SELECT * FROM stzpoder 
                             WHERE nro_tramite = '$vtramt' AND solicitud = '$vsol'";                             
       $regispoder = $sql2->query2($query_poder);
       $filas_poder = $sql2->nums2('',$regispoder);
       $regis_poder = $sql2->objects2('',$regispoder);
//      $sql1->disconnect1();
       $sql2->disconnect2();

    //*** Tabla de Poderhabientes ****************
//       $sql1 = new mod_db();
//       $sql1->connection1();
       $sql2 = new mod_db();
       $sql2->connection2();
       $query_pohabi=pg_exec("SELECT * FROM stzpohad WHERE nro_tramite = '$vtramt' AND solicitud ='$vsol'");
       $filas_pohabi = pg_numrows($query_pohabi);
       $regis_pohabi = pg_fetch_array($query_pohabi);
//      $sql1->disconnect1();
      $sql2->disconnect2();

    //***  Maestra de Derecho 
//    $sql1 = new mod_db();
//    $sql1->connection1();    
    $sql2 = new mod_db();
    $sql2->connection2();    
    
    $query_res="SELECT * FROM stzderec WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
//    $registro = $sql2->query2($query_res);
//    $filas_found_res = $sql2->nums2('',$registro);
//    $registro = $sql2->objects2('',$registro);
    $registro = pg_exec($query_res);
    $filas_found_res = pg_numrows($registro);
    $registro = pg_fetch_array($registro);

     $col_campos = "nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus, pais_resid,poder,tramitante,agente, nplanilla, idtramitante";
     $tipo_marca=$registro['tipo_derecho'];
     $nombre= $registro['nombre'];
     $pais_resid= $registro['pais_resid'];
     $poder= $registro['poder'];
     $tramitante= $registro['tramitante'];
     $nsolic= $registro['solicitud']; //identificador de solicitud en el webpi
     $cod_tramitante= $registro['idtramitante'];  
//     $sql1->disconnect1(); 
     $sql2->disconnect2(); 
    
     //*** Tramitante *****
//     $sql1 = new mod_db();
//     $sql1->connection1(); 
     $sql2 = new mod_db();
     $sql2->connection2(); 

     if (!empty($tramitante)) {
        $cod_tramitante= $registro['idtramitante'];  
//        $query_tram="SELECT * FROM stztramr WHERE idtramitante = '$cod_tramitante' ";
//        $regis_tramt = $sql2->query2($query_tram);
//        $filas_found_tram = $sql2->nums2('',$regis_tramt);
//        $reg_tramt = $sql2->objects2('',$regis_tramt); 
        $query_tram=pg_exec("SELECT * FROM stztramr WHERE idtramitante = '$cod_tramitante'");
	   $reg_tramt = pg_fetch_array($query_tram);
        $filas_found_tram = pg_numrows($query_tram); 
        $tramita_bus= $reg_tramt->cedula;
 
     }     
//     $sql1->disconnect1();
     $sql2->disconnect2();        
    
        
    //*** Maestra de Marcas  
//    $sql1 = new mod_db();
//    $sql1->connection1();
    $sql2 = new mod_db();
    $sql2->connection2();
    $query_mar="SELECT * FROM stmmarce WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $registro = $sql2->query2($query_mar);
    $filas_resultado = $sql2->nums2('',$registro);
    $regis_marce = $sql2->objects2('',$registro);
    $modalidad= $regis_marce->modalidad;
//    $sql1->disconnect1();
    $sql2->disconnect2();

    //*** Actualizacion tabla stmsolref
//    $sql1 = new mod_db();
//    $sql1->connection1();
    $sql2 = new mod_db();
    $sql2->connection2();
    $var=pg_exec("update stmsolref set estatus_sol='15',solicitud_sipi='$numsol',solicitud_fecha='$fechahoy',solicitud_hora= '$horactual' 
                   where nro_tramite='$vtramt' and solicitud='$vsol'");
//    $sql1->disconnect1();
    $sql2->disconnect2();

    //*** Tabla de Logos
   if (($modalidad =="G") OR ($modalidad =="M"))  {
//       $sql1 = new mod_db();
//       $sql1->connection1();
       $sql2 = new mod_db();
       $sql2->connection2();
       $query_logo="SELECT * FROM stmlogos WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
       $regis_logo = $sql2->query2($query_logo);
       $filas_logo = $sql2->nums2('',$regis_logo);
       $regis_logo = $sql2->objects2('',$regis_logo);
   //imagen**************
       $query_imagen="SELECT * FROM stmsolref WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
       $reg_imagen = $sql2->query2($query_imagen);
       $regis_imagen = $sql2->objects2('',$reg_imagen);
       $imagen= $regis_imagen->ref_gra;
   //busqueda grafica
   //    $query_busgra="SELECT * FROM stmsolref WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
   //    $busgra = $sql1->query1($query_busgra);
   //    $regis_busgra = $sql1->objects1('',$regis_busgra);
   //    $busgra= $regis_busgra->ref_gra; 
//       $sql1->disconnect1();
       $sql2->disconnect2();

   }  

      //*** Tabla de Solicitantes o Titulares 
//       $sql1->disconnect1();
//       $sql1 = new mod_db();
//       $sql1->connection1();    
       $sql2->disconnect2();
       $sql2 = new mod_db();
       $sql2->connection2();    

       $query_titular="SELECT stzottid.titular, stzsolic.nombre, stzsolic.identificacion, stzsolic.indole, stzsolic.telefono1, stzsolic.telefono2, stzsolic.fax, stzsolic.email, stzottid.nacionalidad, stzottid.domicilio
       			      FROM stzottid, stzsolic 
       			      WHERE stzottid.nro_tramite='$vtramt'
       			      AND stzottid.solicitud='$nsolic'
                              AND stzsolic.titular = stzottid.titular";
       $regis_titular = $sql2->query2($query_titular);
       $filas_titular = $sql2->nums2('',$regis_titular);
       $regis_titul = $sql2->objects2('',$regis_titular); 
//       $sql1->disconnect1();
//       $sql1 = new mod_db();
//       $sql1->connection1();    
       $sql2->disconnect2();
       $sql2 = new mod_db();
       $sql2->connection2();    

          // Documentos Anexos	  
//	  $resul_anexo = pg_exec("SELECT * FROM stzanxtra WHERE nro_tramite = '$vtramt' AND solicitud = '$vsol' and estatus='0'");
//          $filas_anexo=pg_numrows($resul_anexo);	  
//          $f_pod=0;$f_reg=0;$f_pri=0;$f_rex=0;$f_mer=0;$f_act=0;$f_cci=0;$f_rif=0;
//	  for($conta=0;$conta<$filas_anexo;$conta++)   { 
//	     $reg_anexo = pg_fetch_array($resul_anexo);
//             if ($reg_anexo['cod_anexo']== 'A') { $f_pod=1; } // poder  			--> Causal de Devolucion: 5  
//             if ($reg_anexo['cod_anexo']== 'B') { $f_reg=1; } // reglamento uso de marca  	--> Causal de Devolucion: (otro)
//             if ($reg_anexo['cod_anexo']== 'C') { $f_pri=1; } // documento de prioridad    	--> Causal de Devolucion: 16 
//             if ($reg_anexo['cod_anexo']== 'D') { $f_rex=1; } // certificado de registro ext. 	--> Causal de Devolucion: 16 
//             if ($reg_anexo['cod_anexo']== 'F') { $f_mer=1; } // registro mercantil      	--> Causal de Devolucion: (otro)
//             if ($reg_anexo['cod_anexo']== 'G') { $f_act=1; } // acta ultima asamblea 		--> Causal de Devolucion: 4  
//             if ($reg_anexo['cod_anexo']== 'H') { $f_cci=1; } // copia de ci 			--> Causal de Devolucion: 17  
//             if ($reg_anexo['cod_anexo']== 'I') { $f_rif=1; } // copia de rif 			--> Causal de Devolucion: 18   
//         } 


//*******************************************************************************************************************     
// Grabar en sipi
//    $sql1->disconnect1();
    $sql2->disconnect2();

    $sql = new mod_db();
    $sql->connection(); 
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
          
	     if (filas_apoderado!= 0 ) {
		$numero_agente = $agente;          
          } else {
           	$obj_system = $sql->query("update stzsystem set napoderado=nextval('stzsystem_napoderado_seq')");
     	        $objsystem = $sql->query("select last_value from stzsystem_napoderado_seq");
     		$objsy = $sql->objects('',$objsystem);
     		$prox_apodera = $objsy->last_value;
		$numero_agente = $prox_apodera;
          }
         } else {           
          $numero_agente = $agente;
         }
      }

     //*** Tramitante *****   
//     if (!empty($tramitante)) {
        $cedula_tramt= $reg_tramt['cedula'];        
        $query_tramita=pg_exec("SELECT * FROM stztramr WHERE cedula = '$cedula_tramt'");
	   $regis_tramita = pg_fetch_array($query_tramita);
        $filas_tramita = pg_numrows($query_tramita); 
//        $query_tramita=$sql->query("SELECT * FROM stztramr WHERE cedula = '$cedula_tramt'");
//	   $regis_tramita=$sql->objects('',$query_tramita);
//        $filas_tramita=$sql->nums('',$query_tramita);    

        if ($filas_tramita == "0") {     
           $obj_query = $sql->query("update stzsystem set ntramitante=nextval('stzsystem_ntramitante_seq')");
           if ($obj_query) {
              $obj_query = $sql->query("select last_value from stzsystem_ntramitante_seq");
              $objs = $sql->objects('',$obj_query);
              $ntramitante = $objs->last_value; }
	      $col_tramita = "idtramitante,cedula,nacionalidad,domicilio,telefono1,telefono2,fax,email,email2,nombre";
           $insert_tramt = "$ntramitante,'$reg_tramt->cedula','$reg_tramt->nacionalidad','$reg_tramt->domicilio', '$reg_tramt->telefono1', '$reg_tramt->telefono2','$reg_tramt->fax','$reg_tramt->email','$reg_tramt->email2','$reg_tramt->nombre' ";
           $ins_tramt = $sql->insert("$tbname_21","$col_tramita","$insert_tramt","");
        } else {
          pg_exec("LOCK TABLE stztramr IN SHARE ROW EXCLUSIVE MODE");
          $ttnac=$regis_tramit['nacionalidad'];
          $ttdom=$regis_tramit['domicilio'];
//          $update_tra = "nacionalidad='$regis_tramita->nacionalidad', domicilio= '$regis_tramita->domicilio', telefono1='$regis_tramita->telefono1',  
//            telefono2= '$regis_tramita->telefono2', fax='$regis_tramita->fax', email='$regis_tramita->email', email2='$regis_tramita->email2', 
//            nombre='$regis_tramita->nombre'";
          $update_tra = "nacionalidad='$ttnac',domicilio='$ttdom'";
          $upddetramt = $sql->update("$tbname_21","$update_tra","cedula= '$cedula_tramt'");
//          $upddetramt=pg_exec("UPDATE stztramr SET '$update_tra' where cedula= '$cedula_tramt'");
          $ntramitante= $regis_tramita['idtramitante'];
        }
//     }

////// ojoooooooooooooooooooooo
    pg_exec("COMMIT WORK");
    pg_exec("BEGIN WORK");
////// ojoooooooooooooooooooooo

   //*** Insercion del Registro Nuevo en la Maestra de Derecho 
    if (empty($numero_agente)) { $numero_agente = 0; }  
    if (empty($ntramitante)) { $ntramitante = 0; }  
    $varestatus='1001';
//    if ($vaccion==1) {$varestatus='1002';}
//    if ($vaccion==2) {$varestatus='1200';}
    $col_campos = "nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus,pais_resid,
poder,tramitante,agente,nplanilla,idtramitante"; 
    $insert_str = "'$prox_derecho', '$tipo_marca', '$numsol', '$fechahoy', 'M', '$nombre', '$varestatus', '$pais_resid', '$poder', '$tramitante', '$numero_agente','0','$ntramitante'";
    $insderecho = $sql->insert("$tbname_6","$col_campos","$insert_str","");

    //*** Insercion del Registro Nuevo en la Maestra de Marcas  
    $col_campos = "nro_derecho,clase,ind_claseni,modalidad,distingue,ind_producto";    
    $insert_str = "'$prox_derecho','$regis_marce->clase','$regis_marce->ind_claseni','$regis_marce->modalidad','$regis_marce->distingue','$regis_marce->ind_producto'";
    $insmarce = $sql->insert("$tbname_4","$col_campos","$insert_str","");
  
    //*** Lemas Asociados  
    if ($tipo_marca=="L") {
       $col_campos = "nro_derecho,solicitud_aso,registro_aso "; 
       $insert_str = "'$prox_derecho','$regis_lema->solicitud_aso','$regis_lema->registro_aso' "; 
       $inslema = $sql->insert("$tbname_14","$col_campos","$insert_str",""); }
        
    //*** Tabla de Eventos de Tramite     
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$prox_derecho','1200','$fechahoy',nextval('stzevtrd_secuencial_seq'), '1000', '0', '$fechahoy', '$usuario','$vdes','$horactual'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");        
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
//      $ins_de=true;
//      $inscaus = 0;
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
//             $sql->insert("stzotrde","$col_campos","'$prox_derecho','$votro','M','M','M','$fechahoy','$horactual'",""); 
//      }   
//    }   
 
    //*** Tabla de Logos       
    if (($modalidad =="G") OR ($modalidad =="M"))  {
       $col_campos = "nro_derecho,descripcion"; 
       $insert_str = "'$prox_derecho','regis_logo->descripcion'";
       $inslogo = $sql->insert("$tbname_8","$col_campos","$insert_str",""); }

        
    //*** Tabla de Prioridades
    if ($filas_prio !=0) {
       $col_campos = "nro_derecho,prioridad,pais_priori,fecha_priori "; 
       $insert_str = "'$prox_derecho','$regis_prio->prioridad','$regis_prio->pais_priori', '$regis_prio->fecha_priori'  "; 
       $insprio = $sql->insert("$tbname_15","$col_campos","$insert_str","");
    }


 //*** Tabla de Agentes y apoderados ******
 //      $filas_agente=0;
// OJO ---- 
       for($i=0;$i<$filas_agente;$i++) {  
       
         //*******Apoderado*******************
         $agente= $regis_agente->agente;
         $sql->connection();
         if ($agente > 50000) {
             $cedula= $regis_agente->cedula;                
             $query_apoderado=pg_exec("SELECT * FROM stzagenr WHERE cedula = '$cedula'");
	     $regis_apoderado = pg_fetch_array($query_apoderado);
             $filas_apoderado = pg_numrows( $query_apoderado); 
           
	     if (filas_apoderado!= 0 ) {

                pg_exec("LOCK TABLE stzagenr IN SHARE ROW EXCLUSIVE MODE");
                                     
                $update_str = "'$regis_apoderado[nombre]', '$regis_apoderado[domicilio]', '$regis_apoderado[profesion]', '$regis_apoderado[estatus_age]','$regis_apoderado[telefono1]', '$regis_apoderado[telefono2]','$regis_apoderado[email]','$regis_apoderado[cedula]', '$regis_apoderado[nacionalidad]', '$regis_apoderado[fax]', '$regis_apoderado[email2]','$regis_apoderado[tipo]'";
                                      
                   $insapod = $sql->update("$tbname_2","$update_str","agente='$agente'"); 
                   $col_campos = "nro_derecho,agente";
                   $insert_str = "'$prox_derecho','$agente'";
 	           $insautop = $sql->insert("$tbname_16","$col_campos","$insert_str","");
      
                  if ($insapod AND $insautop) { }
                  else { $numapod = $numapod + 1; } 
      
	           $regis_apoderado = $sql2->objects2('',$regis_apoderado); 	           
            }
	    else {
	        $col_campos = "agente,nombre,domicilio,profesion,estatus_age,telefono1,telefono2,email,email2,fax,cedula,nacionalidad, tipo"; 
           //	$obj_system = $sql->query("update stzsystem set napoderado=nextval('stzsystem_napoderado_seq')");
     	   //     $objsystem = $sql->query("select last_value from stzsystem_napoderado_seq");
     	//	$objsy = $sql->objects('',$objsystem);
     	//	$prox_apodera = $objsy->last_value;
  		 
	        $insert_str = "$prox_apodera,'$regis_agente->nombre','$regis_agente->domicilio','$regis_agente->profesion','$regis_agente->estatus_age', '$regis_agente->telefono1', '$regis_agente->telefono2', '$regis_agente->email', '$regis_agente->email2', '$regis_agente->fax', '$regis_agente->cedula','$regis_agente->nacionalidad','$regis_agente->tipo' "; 
	          
	        $insagent = $sql->insert("$tbname_2","$col_campos","$insert_str","");
            
	        $col_campos = "nro_derecho,agente";
                $insert_str = "'$prox_derecho',$prox_apodera"; 
 	        $insautop = $sql->insert("$tbname_16","$col_campos","$insert_str","");
		$numero_agente = $prox_apodera;
            }
        }
	else {
          pg_exec("LOCK TABLE stzagenr IN SHARE ROW EXCLUSIVE MODE");

          $update_str = "nombre= '$regis_agente->nombre', domicilio='$regis_agente->domicilio', profesion= '$regis_agente->profesion', estatus_age= '$regis_agente->estatus_age', telefono1= '$regis_agente->telefono1', telefono2= '$regis_agente->telefono2', email='$regis_agente->email', cedula='$regis_agente->cedula', nacionalidad='$regis_agente->nacionalidad', fax='$regis_agente->fax', email2='$regis_agente->email2',tipo='$regis_agente->tipo'";
          $insagen = $sql->update("$tbname_2","$update_str","agente='$agente'");
 
          $col_campos = "nro_derecho,agente";
          $insert_str = "'$prox_derecho','$agente'";
          $insautod = $sql->insert("$tbname_16","$col_campos","$insert_str","");              
          $numero_agente = $agente;
          
         if ($insagen AND $insautod) { }
         else { $numagen = $numagen + 1; } 
 
       }

       $regis_agente = $sql2->objects2('',$regisagente); 
      }


    //*** Tabla de Solicitantes o Titulares 
    $filas_poder1 = 0;
    $poder= $regis_poder->poder;
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

         $col_campos = "nro_derecho,titular,nacionalidad,domicilio";
         $insert_str = "'$prox_derecho','$act_titular','$regis_titul->nacionalidad','$regis_titul->domicilio'";
         $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");

         // STZPODER   
         if ($filas_poder1!= 0 ) {
	    $numero_poder = $poder;          
         }
         else {
            $col_campos = "poder,titular,fecha_poder,facultad,fecha_trans";    
            $insert_str = "'$poder','$act_titular','$regis_poder->fecha_poder',
                           '$regis_poder->facultad','$regis_poder->fecha_trans'";
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
        
        $col_campos = "nro_derecho,titular,nacionalidad,domicilio";
        $insert_str = "'$prox_derecho','$regtitu[titular]','$regis_titul->nacionalidad','$regis_titul->domicilio'";
        $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");         

        // STZPODER   
         if ($filas_poder1!= 0 ) {
	    $numero_poder = $poder;          
         }
         else {
            $col_campos = "poder,titular,fecha_poder,facultad,fecha_trans";    
            $insert_str = "'$poder','$regtitu[titular]','$regis_poder->fecha_poder',
                           '$regis_poder->facultad','$regis_poder->fecha_trans'";
            if (!empty($poder)) {$inspoder = $sql->insert("stzpoder","$col_campos","$insert_str","");}
         }

       }
	
      $regis_titul = $sql2->objects2('',$regis_titular);
      $regis_poder = $sql2->objects2('',$regispoder);

    }

    //*** Tabla de PoderHabientes ******
       $poder= $regis_pohabi[poder];
       $sql->connection();
       $query_pohabi1=pg_exec("SELECT * FROM stzpohad WHERE poder = '$poder'");
       $regis_pohabi1 = pg_fetch_array($query_pohabi1);
       $filas_pohabi1 = pg_numrows($query_pohabi1); 
       if ($filas_pohabi1!= 0 ) {
          $numero_poder = $poder;          
       } else {
         for($i=0;$i<$filas_pohabi;$i++) {  
            $col_campos = "poder,poderhabi";    
            $insert_str = "'$regis_pohabi[poder]','$regis_pohabi[poderhabi]'";
            $inspohabi = $sql->insert("stzpohad","$col_campos","$insert_str","");
            $regis_pohabi = pg_fetch_array($query_pohabi); 
         }
       }

    //***Tipo de clase nacional 
    $col_campos = "nro_derecho,clase_nac";
    $insert_str = "'$prox_derecho',$vclasenac";
    $insclanac  = $sql->insert("$tbname_20","$col_campos","$insert_str","");

    //***envia los datos a la tabla de fonetica para realizar la busqueda fonetica
    $col_campos = "nro_derecho,solicitud";
    $insert_str = "'$prox_derecho', '$numsol'";
    $insfoneti  = $sql->insert("$tbname_22","$col_campos","$insert_str","");

    
//*** Comprobaciones finales de errores
   //    echo " numtitu=$numtitu inslema=$inslema instram=$instram insprio=$insprio inslogo=$inslogo numprio=$numprio insagen=$insagen numagen=$numagen numapod=$numapod insmarce=$insmarce insderecho=$insderecho insclanac=$insclanac  insautod=$insautod $insautop=$insautop ins_solic=$ins_solic ins_titur=$ins_titur ins_tramt=$ins_tramt ";
    $sql = new mod_db();
    $sql->connection(); 
    pg_exec("COMMIT WORK"); 
    if ($numtitu==0 AND $inslema AND $instram AND $inslogo AND $ins_tramt AND $insfoneti AND
        $numprio==0 AND $numagen==0 AND $numapod==0 AND $insmarce AND $insderecho AND $insclanac) {
       pg_exec("COMMIT WORK");
      
      //*********************************************    
      //*** Guarda en actualizacion de tabla temporal 
       $sql = new mod_db();
       $sql->connection();    
       $update_str = "estatus='15',solic_sipi= '$numsol', fecha='$fechahoy', hora= '$horactual'";
       $upddetit = $sql->update("consulta","$update_str","solicitud='$vsol'");
       $sql->disconnect();
   
      //*** Cambia de estatus la solicitud en el WEBPI
//      $sql1 = new mod_db();
//      $sql1->connection1();    
      $sql2 = new mod_db();
      $sql2->connection2();    

      $actualiza=pg_exec("UPDATE stzderec SET estatus='1' where solicitud ='$vsol' AND nro_tramite='$vtramt'");             

      $resultado_cant = pg_exec("SELECT * FROM stzderec where nro_tramite='$vtramt' ");
      $filas_cant = pg_numrows($resultado_cant); 
      $resultado_estatus = pg_exec("SELECT * FROM stzderec where nro_tramite='$vtramt' and estatus = '1'");
      $filas_estatus = pg_numrows($resultado_estatus);  
      if ($filas_estatus == $filas_cant) {
          $actual=pg_exec("UPDATE stztramite SET estatus_tra = '15'  where nro_tramite='$vtramt'");   }    
//      $sql1->disconnect1();  
      $sql2->disconnect2();  

      //*** Paso de documentos al SIPI e imagen carpeta oficial con numero de solicitud
         $vsol1=substr($numsol,-11,4);
         $vsol2=substr($numsol,-6,6);         
         $varsol=$vsol1.$vsol2;
	//if($recaud1 =='on') { 
	  $origen= '../docutemp/poder/'.$vsol.'.pdf';
          $destino='../documentos/poder/ef'.$vsol1.'/'.$varsol.'.pdf';
 
	   copy("$origen", "$destino");
           if (file_exists("$destino")) {
              unlink("$origen"); }	   
	//}
	//if($recaud2 =='on'){ 
	  $origen= '../docutemp/asamblea/'.$vsol.'.pdf';
          $destino='../documentos/asamblea/ef'.$vsol1.'/'.$varsol.'.pdf';
	   copy("$origen", "$destino");
           if (file_exists("$destino")) {
              unlink("$origen"); }	   
	//}	 
	//if($recaud3 =='on'){ 
	  $origen= '../docutemp/reglamento/'.$vsol.'.pdf';
          $destino='../documentos/reglamento/ef'.$vsol1.'/'.$varsol.'.pdf';
	   copy("$origen", "$destino");
           if (file_exists("$destino")) {
              unlink("$origen"); }	   
	//}
	//if($recaud4 =='on'){ 
	  $origen= '../docutemp/cedula/'.$vsol.'.pdf';
          $destino='../documentos/cedula/ef'.$vsol1.'/'.$varsol.'.pdf';
$policiaced=$origen.'-'.$destino;
	   copy("$origen", "$destino");
           if (file_exists("$destino")) {
              unlink("$origen"); }	   
	//}	
  	//if($recaud5 =='on'){ 
	  $origen= '../docutemp/prioridad/'.$vsol.'.pdf';
          $destino='../documentos/prioridad/ef'.$vsol1.'/'.$varsol.'.pdf';
	   copy("$origen", "$destino");
           if (file_exists("$destino")) {
              unlink("$origen"); }	   
	//}  	
	//if($recaud6 =='on'){ 
	  $origen= '../docutemp/rif/'.$vsol.'.pdf';
          $destino='../documentos/rif/ef'.$vsol1.'/'.$varsol.'.pdf';
	   copy("$origen", "$destino");
           if (file_exists("$destino")) {
              unlink("$origen"); }	   
	//} 	
	//if($recaud7 =='on'){ 
	  $origen= '../docutemp/mercantil/'.$vsol.'.pdf';
          $destino='../documentos/mercantil/ef'.$vsol1.'/'.$varsol.'.pdf';
	   copy("$origen", "$destino");
           if (file_exists("$destino")) {
              unlink("$origen"); }	   
	//} 	
  	//if($recaud8 =='on'){ 	
	  $origen= '../docutemp/otros/'.$vsol.'.pdf';
          $destino='../documentos/otros/ef'.$vsol1.'/'.$varsol.'.pdf';
	   copy("$origen", "$destino");
           if (file_exists("$destino")) {
              unlink("$origen"); }	   
	//} 
	
   	//if(!empty($imagen)){ 	
	  $origen= '../graficos/planblog/'.$imagen.'.jpg';
          $destino='../graficos/marcas/ef'.$vsol1.'/'.$varsol.'.jpg';
$policia=$origen.'-'.$destino;
	   copy("$origen", "$destino");
           if (file_exists("$destino")) {
              unlink("$origen"); }	
               
         //Busqueda grafica
          $origen= '../../webpi/graficas/'.$imagen.'.pdf';
          $destino='../documentos/busq_grafica/ef'.$vsol1.'/'.$varsol.'.pdf';
	   copy("$origen", "$destino");
           if (file_exists("$destino")) {
              unlink("$origen"); }      
                 
	//}
	       
      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','w_ingresol.php?vopc=4&vtramt='.$vtramt,'S');
      // Aqui llamar al examen de forma
      //Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','w_devoluci.php?vopc=1&vsol=$varsol','S');
      $smarty->display('pie_pag.tpl'); exit();            

    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$inslema)    { $error_lem = " - Lema "; }
      if (!$instram)    { $error_tra = " - Tramite "; }
      if (!$inslogo)    { $error_log = " - Descripcion del Logo "; }
      if (!$insmarce)   { $error_mar = " - Marcas "; }
      if (!$insderecho) { $error_der = " - Derecho "; }
      if ($numtitu!=0)  { $error_tit = " - Titular(es) "; }
      if ($numprio!=0)  { $error_pri = " - Prioridad "; }
      if ($numagen!=0)  { $error_age = " - Agente(s) "; }
      if ($numapod!=0)  { $error_agep = " - Apoderado(s) "; }      
      if (!$insclanac)  { $error_cla = " - Clase Nacional "; }     
      if (!$ins_tramt)  { $error_tra = " - Tramitante "; }     
      if (!$insfoneti)  { $error_foneti = " - Fonetica "; }
            
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
     if ($registro_tram['estatus']== 15) {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solicitud]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>$registro_tram[solic_sipi]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_formsipi.php?vsol=$registro_tram[solic_sipi]''>FM-02</a></td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
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
$smarty->display('w_ingresol.tpl');
$smarty->display('pie_pag.tpl');
//ob_end_clean(); 
?>
