<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }


function planilla(v1,v2,v3) {
  open("w_planilla.php?vsol="+v1.value+"&vtramt="+v2.value+"&vopc=","Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function Ventana_001 (URL){ 
  window.open(URL,"UTERRA","width=500,height=300,top=20,left=40,scrollbars=NO,titlebar=NO,menubar=YES,toolbar=NO,directories=YES,location=YES,status=NO,resizable=NO") 
} 
  
</script>
<?php
// *************************************************************************************
// Programa: w_ingrescrito.php 
// Realizado por el Analista de Sistema Romulo Mendoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPIC
// Año 2016 II Semestre
// *************************************************************************************
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
if (empty($vsol)) {$vsol=$_GET['vsol'];}
//
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Solicitud(es) de Escrito(s) al SIPI');
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
<p align='center'><b><font > Solicitudes Asociadas al Tramite Escritos para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="100px" align="center">
  <tr>
    <td width="12%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b> Referencia </b></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Nro. Solicitud</b></td>
    <td width="20%" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Documento</b></td>
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

    $resultado_tram = pg_exec("SELECT * FROM stmescrito, stztramsindep 
    			 	WHERE stztramsindep.nro_tramite = '$vtramt' 
    			 	AND stmescrito.nro_tramite = stztramsindep.nro_tramite
    			 	AND stztramsindep.estatus_tra IN ('02') order by stmescrito.solicitud");
    $filas_resultado_tram = pg_numrows($resultado_tram); 
 
    $sql1->disconnect1();
   
    if ($filas_resultado_tram==0) { mensajenew("AVISO: El Nro. del Tramite no esta Registrado o No tiene solicitudes que ingresar..!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); } 
    else{

    ?>

<p>&nbsp;</p>
<p align='center'><b><font > Solicitudes Asociadas al Tramite de Escritos para Ingresar al SIPI </font></b></p>
<table style="background-color: #015B9E; border: 0 solid #D8E6FF" border="1" cellpadding="0" cellspacing="0" width="100px" align="center">
  <tr>
    <td width="08px" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Tr&aacute;mite </b></p></td>
    <td width="08px" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Referencia </b></p></td>
    <td width="10px" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Solicitud</b></p></td>
    <td width="08px" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Documento</b></p></td>
    <td width="08px" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Tipo Escrito</b></p></td>
    <td width="08px" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Fecha</b></p></td>
    <td width="25px" > <font color="#FFFFFF"> <P ALIGN=CENTER> <b>Hora</b></p></td>
  </tr>
  
  <?php  
    $sql = new mod_db();
    $sql->connection();
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = hoy();
    pg_exec("CREATE TABLE consulta (tramite char(11), solicitud char(11),referencia integer, documento char(10), fecha char(10), hora char(11)) ");         
    for($cont=0;$cont<$filas_resultado_tram;$cont++) { 
      $registro_tram = pg_fetch_array($resultado_tram);
      $vsol=   $registro_tram['solicitud'];

      $resul_insert =pg_exec("INSERT INTO consulta (tramite,solicitud,referencia,documento,fecha,hora) VALUES ('$vtramt','$registro_tram[solicitud]','$registro_tram[nro_escrito]','','','')");
			    
      $varsolic=trim($registro_tram['solicitud']);
      $vsol=$registro_tram[solicitud];
      $vsol1=substr($vsol,0,4);
      $vsol2=substr($vsol,5,6);
      $vtipe=$registro_tram[tipo_escrito];
      echo "<tr>";
      echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
      if ($registro_tram[estatus_tra]=='02') {echo "$registro_tram[nro_tramite]</td>";} else {echo "-</p></td>";}
      echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
      if ($registro_tram[estatus_tra]=='02') {echo "$registro_tram[nro_escrito]</p></td>";} else {echo "-</p></td>";}
      echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER >";
      if ($registro_tram[estatus_tra]=='02') {echo "<a href='w_codescrito.php?vsol=$vsol&vtramt=$vtramt&vtipe=$vtipe&vopc=4''>
        <input type='button' value='$varsolic' class='botones_rojo'></a></p></td>";} 
      else { echo "$registro_tram[solicitud]</p></td>";}

      echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>-</p></td>";

      echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
      if ($registro_tram[estatus_tra]=='02') {echo "$registro_tram[tipo_escrito]</td>";} else {echo "-</p></td>";}
      echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
      if ($registro_tram[estatus_tra]=='02') {echo "$fechahoy</td>";} else {echo "-</p></td>";}
      $horactual= Hora();
      echo "<td style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><P ALIGN=CENTER>";
      if ($registro_tram[estatus_tra]=='02') {echo "$horactual</p></td>";} else {echo "-</p></td>";} 
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
    //Validacion de Romulo Mendoza donde el año de la solicitud NO puede ser menor a 2015.
    if ($vsol1<2015) {
       mensajenew("ERROR: El A&nacute;o del N&uacute;mero de Solicitud NO puede ser menor a 2015 ..!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    if ($vsol2>30000) {
       mensajenew("ERROR: El N&uacute;mero de Solicitud es Incorrecto...   Verifique!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    if ($vsol1=='' or $vsol2=='' or $vsol1=='0000' or $vsol2=='000000' or empty($vsol1) or empty($vsol2) or $varsol=='-') {
       mensajenew("ERROR: Debe colocar el N&uacute;mero de Solicitud..!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    $vtramt=$_POST['vtramt'];
    if ($vsol2==$vtramt) {
       mensajenew("ERROR: El N&uacute;mero de Solicitud es igual al N&uacute;mero de Tramite...   Verifique!!!", "javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }
    
    $vaccion=$_POST['vaccion'];

    //$sql->disconnect();
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_est0=pg_exec("SELECT * FROM stzanxtra WHERE nro_tramite = '$vtramt' and solicitud='$vsol' and cod_anexo<>'C' and estatus='0'");
    $filest0=pg_numrows($query_est0); 
    $sql1->disconnect1();


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
    $sql->disconnect();

    //***  Maestra de Derecho 
    $sql1 = new mod_db();
    $sql1->connection1();    

    $query_res="SELECT * FROM stzderec WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $registro = $sql1->query1($query_res);
    $filas_found_res = $sql1->nums1('',$registro);
    $registro = $sql1->objects1('',$registro);

     $col_campos = "nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus, pais_resid,poder,tramitante,agente, nplanilla, idtramitante";
     $tipo_marca=$registro->tipo_derecho;
     $nombre= $registro->nombre;
     $pais_resid= $registro->pais_resid;
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
    $sql1 = new mod_db();
    $sql1->connection1();
    $query_mar="SELECT * FROM stmmarce WHERE nro_tramite = '$vtramt' and solicitud= '$vsol'";
    $registro = $sql1->query1($query_mar);
    $filas_resultado = $sql1->nums1('',$registro);
    $regis_marce = $sql1->objects1('',$registro);
    $modalidad= $regis_marce->modalidad;
    $sql1->disconnect1();

    //*** Actualizacion tabla stmsolref
    $sql1 = new mod_db();
    $sql1->connection1();
    $var=pg_exec("update stmsolref set estatus_sol='15',solicitud_sipi='$numsol',solicitud_fecha='$fechahoy',solicitud_hora= '$horactual' 
                   where nro_tramite='$vtramt' and solicitud='$vsol'");
    $sql1->disconnect1();

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


//*******************************************************************************************************************     
// Grabar en sipi
    $sql = new mod_db();
    $sql->connection(); 
    $query_verifinal=pg_exec("SELECT * FROM stzderec WHERE solicitud='$numsol' and tipo_mp='M'");
    $filas_verifinal=pg_numrows($query_verifinal); 
    if ($filas_verifinal>0) {
       //Mensaje de error
       //*** DesActualizacion tabla stmsolref
       $sql->disconnect();
       $sql1 = new mod_db();
       $sql1->connection1();
       $var=pg_exec("update stmsolref set estatus_sol=null,solicitud_sipi=null,solicitud_fecha=null,solicitud_hora=null 
                   where nro_tramite='$vtramt' and solicitud='$vsol'");
       $sql1->disconnect1();
       mensajenew('ERROR: Numero de Solicitud YA existe en la Base de Datos ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); exit();
    }
    pg_exec("BEGIN WORK");
        
   //*** Insercion del Registro Nuevo en la Maestra de Derecho 
    if (empty($numero_agente)) { $numero_agente = 0; }  
    if (empty($ntramitante)) { $ntramitante = 0; }  
    $varestatus='1001';
    $col_campos = "nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus,pais_resid,
poder,tramitante,agente,nplanilla,idtramitante"; 
    $insert_str = "'$prox_derecho', '$tipo_marca', '$numsol', '$fechahoy', 'M', '$nombre', '$varestatus', '$pais_resid', '$poder', '$tramitante', '$numero_agente','0','$ntramitante'";
    $insderecho = $sql->insert("$tbname_6","$col_campos","$insert_str","");

    //*** Insercion del Registro Nuevo en la Maestra de Marcas  
    $col_campos = "nro_derecho,clase,ind_claseni,modalidad,distingue,ind_producto"; 
    $vregdistin=str_replace("'","`",$regis_marce->distingue);    
    $insert_str = "'$prox_derecho','$regis_marce->clase','$regis_marce->ind_claseni','$regis_marce->modalidad','$vregdistin','$regis_marce->ind_producto'";
    $insmarce = $sql->insert("$tbname_4","$col_campos","$insert_str","");
  
    //*** Lemas Asociados  
    if ($tipo_marca=="L") {
       $col_campos = "nro_derecho,solicitud_aso,registro_aso,nombre_sol"; 
       $insert_str = "'$prox_derecho','$regis_lema->solicitud_aso','$regis_lema->registro_aso','$regis_lema->nombre_sol'"; 
       $inslema = $sql->insert("$tbname_14","$col_campos","$insert_str",""); }
        
    //*** Tabla de Eventos de Tramite     
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora,comentario";
    $insert_str = "'$prox_derecho','1200','$fechahoy',nextval('stzevtrd_secuencial_seq'), '1000', '0', '$fechahoy', '$usuario','$vdes','$horactual','Pago de Tasa: $vpagotasa'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");        

      //*** Tabla oficio devolucion 
      // Inserta en Stzcaded
      $ins_de=true;
      $inscaus = 0;
 
    //*** Tabla de Logos       
    if (($modalidad =="G") OR ($modalidad =="M"))  {
       $col_campos = "nro_derecho,descripcion";
       $vetilogo=str_replace("'","`",$regis_logo->descripcion);  
       $insert_str = "'$prox_derecho','$vetilogo'";
       $inslogo = $sql->insert("$tbname_8","$col_campos","$insert_str",""); }
      
    //*** Tabla de Prioridades
    if ($filas_prio !=0) {
       $col_campos = "nro_derecho,prioridad,pais_priori,fecha_priori "; 
       $insert_str = "'$prox_derecho','$regis_prio->prioridad','$regis_prio->pais_priori', '$regis_prio->fecha_priori'  "; 
       $insprio = $sql->insert("$tbname_15","$col_campos","$insert_str","");
    }


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
	        $insert_str = "$agente,'$regis_agente->nombre','$regis_agente->domicilio','$regis_agente->profesion','$regis_agente->estatus_age', '$regis_agente->telefono1', '$regis_agente->telefono2', '$regis_agente->email', '$regis_agente->email2', '$regis_agente->fax', '$regis_agente->cedula','$regis_agente->nacionalidad','$regis_agente->tipo','$regis_agente->pais_domicilio' "; 
	          
	        $insagent = $sql->insert("$tbname_2","$col_campos","$insert_str","");
            
	        $col_campos = "nro_derecho,agente";
             //$insert_str = "'$prox_derecho',$prox_apodera";
             $insert_str = "'$prox_derecho',$agente";  
 	        $insautop = $sql->insert("$tbname_16","$col_campos","$insert_str","");
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
    $col_campos = "nro_derecho,clase_nac";
    $insert_str = "'$prox_derecho',$vclasenac";
    $insclanac  = $sql->insert("$tbname_20","$col_campos","$insert_str","");

    //***envia los datos a la tabla de fonetica para realizar la busqueda fonetica
    $col_campos = "nro_derecho,solicitud";
    $insert_str = "'$prox_derecho', '$numsol'";
    $insfoneti  = $sql->insert("$tbname_22","$col_campos","$insert_str","");

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
$smarty->display('w_ingrescrito.tpl');
$smarty->display('pie_pag.tpl');
?>

