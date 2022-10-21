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
include ("w_formulario.php");
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

$vopc = $_GET['vopc'];
$vtramt=$_POST['vtramt'];
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
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b> Solicitud </b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Estatus</b></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Nro. Solicitud SIPI</b></td>
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
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='web/w_formsipi.php?vsol=$vsol''>$registro_tram[solic_sipi]</a></td>";
         
         
         //echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
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

    $resultado_tram = pg_exec("SELECT * FROM stzderec, stztramite 
    			 	WHERE stzderec.nro_tramite = '$vtramt' 
    			 	AND stzderec.nro_tramite = stztramite.nro_tramite  
    			 	AND  stzderec.estatus = '0'
    			 	AND stztramite.estatus_tra IN ('13','14') order by solicitud");
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
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b> Solicitud </b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Estatus</b></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Nro. Solicitud SIPI</b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Fecha</b></td>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Hora</b></td>
  </tr>
  
  <?php  
    $sql = new mod_db();
    $sql->connection();
    pg_exec("CREATE TABLE consulta (tramite char(11), solicitud char(11),estatus char(2), solic_sipi char(11), fecha char(10), hora char(11)) ");         
    for($cont=0;$cont<$filas_resultado_tram;$cont++) { 
        $registro_tram = pg_fetch_array($resultado_tram);
        $vsol=   $registro_tram['solicitud'];

  $resul_insert =pg_exec("INSERT INTO consulta (tramite,solicitud,estatus,solic_sipi,fecha,hora) VALUES ('$vtramt','$registro_tram[solicitud]','$registro_tram[estatus_tra]','','','')");
			    
 // echo "<LI> <a href='#' onclick=window.open('w_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4','miwin','width=900,height=700,scrollbars=yes')> Solicitud Nro: $registro_tram[solicitud] </a>";      

     echo "<tr >";
     echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
     echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus_tra]</td>";
     echo "<td width='20%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> - </td>";
     echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> - </td>";
     echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> - </td>";
     echo "</tr>";

    ?>


  <?php   

    }   
   echo " </table>";
   }   
       $sql->disconnect();
 }
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
         echo "<td width='12% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_formsipi.php?vsol=$registro_tram[solic_sipi]''>$registro_tram[solic_sipi]</a></td>";
         
        // echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[solic_sipi]</td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[fecha]</td>";
         echo "<td width='12%'  style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[hora]</td>";
         }
     else {
         echo "<td width='14% 'style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER><a href='w_planilla.php?vsol=$vsol&vtramt=$vtramt&vopc=4''>$registro_tram[solicitud]</a></td>";
         echo "<td width='12%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER> $registro_tram[estatus]</td>";
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
//*** Guardar la solicitud en el SIPI  

if ($vopc== 6) {
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
    
    $tramite= $vtramt;

    pg_exec("BEGIN WORK");
         
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
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_clase="SELECT * FROM stmclnac WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $regclase_nac = $sql1->query1($query_clase);
    $regis_clase = $sql1->objects1('',$regclase_nac);
    $vclasenac = $regis_clase->clase_nac; 
    $sql1->disconnect1();

    //*** Tabla de Lemas Asociados     
    if ($tipo_marca=="L") {
        $sql1 = new mod_db();
        $sql1->connection1();
        $query_lem="SELECT * FROM stmlemad WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
        $regis_lema = $sql1->query1($query_lem);
        $filas_resultado = $sql1->nums1('',$regis_lema);
        $regis_lema = $sql1->objects1('',$regis_lema);
        $sql1->disconnect1();
        echo " ESTOY EN LEMA ";
        $sql = new mod_db();
        $sql->connection(); 
        $col_campos = "nro_derecho,solicitud_aso,registro_aso, "; 
        $insert_str = "'$prox_derecho','$regis_lema->solicitud_aso','$regis_lema->registro_aso' "; 
        $inslema = $sql->insert("$tbname_14","$col_campos","$insert_str","");
        $sql->disconnect();
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
   
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$prox_derecho','1200','$fechahoy',nextval('stzevtrd_secuencial_seq'), '1000', '0', '$fechahoy', '$usuario','$vdes','$horactual'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");
    $sql->disconnect();
    
    
    //*** Tabla de Logos
   if (($modalidad =="G") OR ($modalidad =="M"))  {
       $sql1 = new mod_db();
       $sql1->connection1();
       $query_logo="SELECT * FROM stmlogos WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
       $regis_logo = $sql1->query1($query_logo);
       $filas_logo = $sql1->nums1('',$regis_logo);
       $regis_logo = $sql1->objects1('',$regis_logo);
       //imagen
       $query_imagen="SELECT * FROM stmsolref WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
       $imagen = $sql1->query1($query_imagen);
       $regis_imagen = $sql1->objects1('',$regis_imagen);
       $imagen= $regis_imagen->ref_gra;
      
       $sql1->disconnect1();
       $sql = new mod_db();
       $sql->connection();
       $insert_str = "'$prox_derecho','regis_logo->descripcion'";
       $inslogo = $sql->insert("$tbname_8","","$insert_str","");
       $sql->disconnect(); 
       
    //*** Paso de imagen al sipi
    //   $cmd="scp -P  22 www-data@172.16.0.7:/var/www/consulta/apl/logotipos/".$imagen.".pdf  /var/www/apl/sipi2011/graficos/marcas//"; 
    // exec($cmd); 
  }

    //*** Tabla de Prioridades   
       $sql1 = new mod_db();
       $sql1->connection1();
       $query_prio="SELECT * FROM stzpriod WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
       $regis_prio = $sql1->query1($query_prio);
       $filas_prio = $sql1->nums1('',$regis_prio);
       $regis_prio = $sql1->objects1('',$regis_prio);
       $sql1->disconnect1();
     
       if ($filas_prio !=0) {
          $sql = new mod_db();
          $sql->connection(); 
          $col_campos = "nro_derecho,prioridad,pais_priori,fecha_priori "; 
          $insert_str = "'$prox_derecho','$regis_prio->prioridad','$regis_prio->pais_priori', '$regis_prio->fecha_priori'  "; 
          $insprio = $sql->insert("$tbname_15","$col_campos","$insert_str","");
          $sql->disconnect();
       }  
      $sql->disconnect();
      $sql1->disconnect1();

    //*** Tabla de Agentes y apoderados ****************
       $sql = new mod_db();
       //$sql->connection();
       $sql1 = new mod_db();
       $sql1->connection1();
       echo " tramite= $vtramt $vsol ";
       $query_agente="SELECT * FROM stzagenr,stzautod 
                             WHERE stzautod.nro_tramite = '$vtramt' 
                             AND stzautod.solicitud = '$vsol' 
                             AND stzagenr.agente = stzautod.agente ORDER BY stzautod.agente";                             
       $regisagente = $sql1->query1($query_agente);
       $filas_agente = $sql1->nums1('',$regisagente);
       $regis_agente = $sql1->objects1('',$regisagente);
              
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
      
	           $regis_apoderado = $sql1->objects1('',$regis_apoderado); 	           
            }
	    else {
	        $col_campos = "agente,nombre,domicilio,profesion,estatus_age,telefono1,telefono2,email,email2,fax,cedula,nacionalidad, tipo"; 
           	$obj_system = $sql->query("update stzsystem set napoderado=nextval('stzsystem_napoderado_seq')");
     	        $objsystem = $sql->query("select last_value from stzsystem_napoderado_seq");
     		$objsy = $sql->objects('',$objsystem);
     		$prox_apodera = $objsy->last_value;
  		 
	        $insert_str = "$prox_apodera,'$regis_agente->nombre','$regis_agente->domicilio','$regis_agente->profesion','$regis_agente->estatus_age', '$regis_agente->telefono1', '$regis_agente->telefono2', '$regis_agente->email', '$regis_agente->email2', '$regis_agente->fax', '$regis_agente->cedula','$regis_agente->nacionalidad','$regis_agente->tipo' "; 
	          
	        $insagent = $sql->insert("$tbname_2","$col_campos","$insert_str","");
            
	        $col_campos = "nro_derecho,agente";
                $insert_str = "'$prox_derecho',$prox_apodera"; echo " valor=$insert_str ";
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

       $regis_agente = $sql1->objects1('',$regisagente); 
      	 echo " 2do $agente "; 
      }
      $sql->disconnect();
      $sql1->disconnect1();
              
    //*** Tabla de Solicitantes o Titulares 
       $sql1 = new mod_db();
       $sql1->connection1();
       $query_titular="SELECT stzottid.titular, stzsolic.nombre, stzsolic.identificacion, stzsolic.indole, stzsolic.telefono1, stzsolic.telefono2, stzsolic.fax, stzsolic.email, stzottid.nacionalidad, stzottid.domicilio
       			      FROM stzottid, stzsolic 
       			      WHERE stzottid.nro_tramite='$vtramt'
       			      AND stzottid.solicitud='$nsolic'
                              AND stzsolic.titular = stzottid.titular";
       $regis_titular = $sql1->query1($query_titular);
       $filas_titular = $sql1->nums1('',$regis_titular);
       $regis_titul = $sql1->objects1('',$regis_titular); 
       $sql1->disconnect1();
        
       $sql = new mod_db();
       $sql->connection();    
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
       }
	
      $regis_titul = $sql1->objects1('',$regis_titular); 

    }
  
    //***Tipo de clase nacional 
    $col_campos = "nro_derecho,clase_nac";
    $insert_str = "'$prox_derecho',$vclasenac";
    $insclanac  = $sql->insert("$tbname_20","$col_campos","$insert_str","");
    $sql->disconnect();
            
   //**********************************************************   
   //*** Insercion del Registro Nuevo en la Maestra de Derecho 
    $sql1 = new mod_db();
    $sql1->connection1();    
    
    $query_res="SELECT * FROM stzderec WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $registro = $sql1->query1($query_res);
    $filas_found_res = $sql1->nums1('',$registro);
    $registro = $sql1->objects1('',$registro);

     $col_campos = "nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus, pais_resid,poder,tramitante,agente";
     $tipo_marca=$registro->tipo_derecho;
     $nombre= $registro->nombre;
     $pais_resid= $registro->pais_resid;
     $poder= $registro->poder;
     $tramitante= $registro->tramitante;
     $nsolic= $registro->solicitud; //identificador de solicitud en el webpi
     $sql1->disconnect1();
        
    $sql = new mod_db();
    $sql->connection();  
    $insert_str = "'$prox_derecho', '$tipo_marca', '$numsol', '$fechahoy', 'M', '$nombre', '1001', '$pais_resid', '$poder', '$tramitante', '$numero_agente'";
    $insderecho = $sql->insert("$tbname_6","$col_campos","$insert_str","");
    $sql->disconnect();
    
    //*** Insercion del Registro Nuevo en la Maestra de Marcas  
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_mar="SELECT * FROM stmmarce WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $registro = $sql1->query1($query_mar);
    $filas_resultado = $sql1->nums1('',$registro);
    $regis_marce = $sql1->objects1('',$registro);
    $modalidad= $regis_marce->modalidad;
    $sql1->disconnect1();
  
    $sql = new mod_db();
    $sql->connection();  
    $col_campos = "nro_derecho,clase,ind_claseni,modalidad,distingue,ind_producto";    
    $insert_str = "'$prox_derecho','$regis_marce->clase','$regis_marce->ind_claseni','$regis_marce->modalidad','$regis_marce->distingue','$regis_marce->ind_producto'";
    $insmarce = $sql->insert("$tbname_4","$col_campos","$insert_str","");
    $sql->disconnect();
      
       
       
       
       
       
       
       
       
       
       
       
       
//*** Guarda en actualizacion de tabla temporal 
       $sql = new mod_db();
       $sql->connection();    
       $update_str = "estatus='15',solic_sipi= '$numsol', fecha='$fechahoy', hora= '$horactual'";
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
       $actual=pg_exec("UPDATE stztramite SET estatus_tra = '15'  where nro_tramite='$vtramt'");   }
    
    $sql1->disconnect1();
      
    
//*** Comprobaciones finales de errores
       echo " numtitu=$numtitu inslema=$inslema instram=$instram insprio=$insprio inslogo=$inslogo numprio=$numprio insagen=$insagen numagen=$numagen numapod=$numapod insmarce=$insmarce insderecho=$insderecho insclanac=$insclanac  insautod=$insautod $insautop=$insautop ins_solic=$ins_solic ins_titur=$ins_titur";

    if ($numtitu==0 AND $inslema AND $instram AND $inslogo AND 
        $numprio==0 AND $numagen==0 AND $numapod==0 AND $insmarce AND $insderecho AND $insclanac) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','w_ingresol.php?vopc=7','S');
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
      
      Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_lem,  $error_tra, $error_log,  $error_mar,  $error_der, $error_tit, $error_pri, $error_age, $error_agep,  $error_cla ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
      
             
//*** Paso de documentos al SIPI
if($pepe =='on'){ 
 
  if($recaud1 =='on'){ 
  //ejecuto el shell para traer la imagen
  $cmd="scp -P  3535 www-data@172.16.0.7:/var/www/apl/documentos/poder/".$numsol.".pdf  /var/www/documentos/poder/"; 
  exec($cmd);}

  if($recaud2 =='on'){ 
  //ejecuto el shell para traer la imagen
  $cmd="scp -P  3535 www-data@172.16.0.7:/var/www/apl/documentos/asamblea/".$numsol.".pdf  /var/www/documentos/asamblea/"; 
  exec($cmd);}  
  
  if($recaud3 =='on'){ 
  //ejecuto el shell para traer la imagen
  $cmd="scp -P  3535 www-data@172.16.0.7:/var/www/apl/documentos/reglamento/".$numsol.".pdf  /var/www/documentos/reglamento/"; 
  exec($cmd);} 
  
  if($recaud4 =='on'){ 
  //ejecuto el shell para traer la imagen
  $cmd="scp -P  3535 www-data@172.16.0.7:/var/www/apl/documentos/cedula/".$numsol.".pdf  /var/www/documentos/cedula/"; 
  exec($cmd);}
  
  if($recaud5 =='on'){ 
  //ejecuto el shell para traer la imagen
  $cmd="scp -P  3535 www-data@172.16.0.7:/var/www/apl/documentos/prioridad/".$numsol.".pdf  /var/www/documentos/prioridad/"; 
  exec($cmd);}
  
  if($recaud6 =='on'){ 
  //ejecuto el shell para traer la imagen
  $cmd="scp -P  3535 www-data@172.16.0.7:/var/www/apl/documentos/rif/".$numsol.".pdf  /var/www/documentos/rif/"; 
  exec($cmd);}
  
  if($recaud7 =='on'){ 
  //ejecuto el shell para traer la imagen
  $cmd="scp -P  3535 www-data@172.16.0.7:/var/www/apl/documentos/mercantil/".$numsol.".pdf  /var/www/documentos/mercantil/"; 
  exec($cmd);}
  
  if($recaud8 =='on'){ 
  //ejecuto el shell para traer la imagen
  $cmd="scp -P  3535 www-data@172.16.0.7:/var/www/apl/documentos/otros/".$numsol.".pdf  /var/www/documentos/otros/"; 
  exec($cmd);}  
}//cierre if pepe

}
 
$registro_tram = pg_fetch_array($resultado_tram);

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
