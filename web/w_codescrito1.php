<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script>
<?php
// *************************************************************************************
// Programa: w_codescrito1.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPIC
// Año 2016 II Semestre
// *************************************************************************************

include ("../setting.inc.php");
include ("../z_includes.php");

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
$vtipe=$_POST['vtipe'];
if (empty($vsol)) {$vsol=$_GET['vsol'];}
//
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso o Presentacion de Escrito(s) al SIPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','wcodescrito.vtramt'); 
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
<p align='center'><b><font > Solicitudes Asociadas al Tramite para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
  <tr>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b> Referencia </b></td>
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
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='web/w_formsipi.php?vsol=$vsol''>FM-02</a></td>";
         
         
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
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

    $resultado_tram = pg_exec("SELECT * FROM stmsolref, stztramite 
    			 	WHERE stztramite.nro_tramite = '$vtramt' 
    			 	AND stmsolref.nro_tramite = stztramite.nro_tramite
    			 	AND stztramite.estatus_tra IN ('13','14','09','10','15','02') order by stmsolref.solicitud");

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
        $vsol=   $registro_tram['solicitud'];

// estatus en el sipi
$res_est = pg_exec("SELECT estatus FROM stzderec WHERE solicitud = '$registro_tram[solicitud_sipi]'");
$regest= pg_fetch_array($res_est);
//

  $resul_insert =pg_exec("INSERT INTO consulta (tramite,solicitud,estatus,solic_sipi,fecha,hora) VALUES ('$vtramt','$registro_tram[solicitud]','$registro_tram[estatus_sol]','$registro_tram[solicitud_sipi]','','')");
			    
     $varsolic=trim($registro_tram['solicitud']);
     echo "<tr>";
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER >";
     if ($registro_tram[estatus_sol]<>'15') {echo "<a href='w_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>
        <input type='button' value='$varsolic' class='botones_rojo'></a></p></td>";} 
     else { echo "$registro_tram[solicitud]</p></td>";}
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     $vsol=$registro_tram[solicitud_sipi];
     $vsol1=substr($vsol,0,4);
     $vsol2=substr($vsol,5,6);
     if ($registro_tram[estatus_sol]=='15') {echo "$registro_tram[solicitud_sipi]</p></td>"; }
     else { echo "-</p></td>";}

//ver
     echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
     if ($registro_tram[estatus_sol]=='15') {
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
    $vsol=$_POST['vsol'];
    $vtramt=$_POST['vtramt'];
    $vcode=$_POST['vcode'];
    $tramite= $vtramt;
    $horactual = Hora();

    //Validacion de Romulo Mendoza donde el año de la solicitud NO puede ser menor a 2015.
    if ($vcode<2015) {
       mensajenew("ERROR: El N&uacute;mero de C&oacute;digo Control NO puede ser menor a 2015 ..!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
   
    //inicializar variables
    $instram = true;
    $insesc  = true;
    $numsol  = $vsol;          
        
    //descripcion del evento
    $sql = new mod_db();
    $sql->connection();
    
    switch ($vtipe) {
      case "CD":
        $evento = 1020;
        $resultado_tram=pg_exec("SELECT * FROM stzevder WHERE evento=$evento");
        $regeve = pg_fetch_array($resultado_tram);
        $vdes=trim($regeve['mensa_automatico']);
        $documento=0;
        $comentario="";
        break;
      case "CO":
        break;
      case "RR":
        break;
    }       
    $sql->disconnect();


    //*******************************************************************************************************************     
    // Grabar en Webpi Actualizacion tabla stmescrito
    $sql1 = new mod_db();
    $sql1->connection1();
    $insesc=pg_exec("update stmescrito set documento_control='$vcode',fecha_carga='$fechahoy',hora_carga= '$horactual',usuario_interno= '$usuario'
                   where nro_tramite='$vtramt' and solicitud='$vsol'");
    $sql1->disconnect1();

    // Grabar en Sipi
    $sql = new mod_db();
    $sql->connection(); 

    $query_verifinal=pg_exec("SELECT * FROM stzderec WHERE solicitud='$numsol' and tipo_mp='M'");
    $regsol = pg_fetch_array($query_verifinal);
    $vder   = trim($regsol['nro_derecho']);
    $vest   = trim($regsol['estatus']);
    
    pg_exec("BEGIN WORK");
    //*** Tabla de Eventos de Tramite     
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora,comentario";
    $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$vest','$documento','$fechahoy','$usuario','$vdes','$horactual','$comentario'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");        

    if ($instram) AND ($insesc) {
      pg_exec("COMMIT WORK");
      
      //*********************************************    
      //*** Guarda en actualizacion de tabla temporal Webpi 
      //$sql1 = new mod_db();
      //$sql1->connection1();    
      //$update_str = "documento_control='$vcode',fecha='$fechahoy',hora='$horactual',usuario='$usuario'";
      //$updescrito = $sql1->update1("stmescrito","$update_str","nro_tramite='$tramite' AND solicitud='$vsol'");
      //$sq1l->disconnect1();

      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','w_ingrescrito.php?vopc=4&vtramt='.$vtramt,'S');
      $smarty->display('pie_pag.tpl'); exit();            

    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      //*** DesActualizacion tabla stmsolref
      $sql1 = new mod_db();
      $sql1->connection1();
      $var=pg_exec("update stmsolref set estatus_sol=null,solicitud_sipi=null,solicitud_fecha=null,solicitud_hora=null 
                   where nro_tramite='$vtramt' and solicitud='$vsol'");
      $sql1->disconnect1();

      Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
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
$smarty->assign('vtramt',$vtramt);
$smarty->assign('vsol',$vsol);
$smarty->display('w_codescrito1.tpl');
$smarty->display('pie_pag.tpl');
//ob_end_clean(); 
?>
