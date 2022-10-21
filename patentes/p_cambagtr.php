<?php 
ob_start();
?> 
<script language="Javascript"> 
 function browsepoderhabi(var1,var2,var3,var4) {
   open("act_agente.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtipo=P","Ventana","width=2,height=2,left=511,top=300, scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
</script>

<?
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

$hh=hora();
$sql = new mod_db();  
$fecha=fechahoy(); 

$smarty ->assign('titulo','Sistema de Patentes'); 
$smarty ->assign('subtitulo','Cambio de Agente / Tramitante'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
   
   $vuser    =$usuario;  
   
   //Captura Variables leidas en formulario inicial
   $vopc=   $_GET['vopc'];
   $vsol1=  $_POST['vsol1'];
   $vsol2=  $_POST['vsol2'];
   $vreg1=  $_POST['vreg1'];
   $vreg2=  $_POST['vreg2'];
   $vnom=   $_POST['vnom'];
   $vest=   $_POST['vest'];
   $vfecsol=$_POST['vfecsol'];
   $vfecreg=$_POST['vfecreg'];
   $vfecven=$_POST['vfecven'];
   $vfevh=$_POST['vfevh'];
   $vdoc=$_POST['vdoc'];
   $smarty ->assign('vfecven',$vfecven); 
   $vtra=$_POST['vtra'];
   $vcodage=$_POST['vcodage'];
   $vnomage=$_POST['vnomage'];
   $vcodagen=$_POST['vcodagen'];
   $vnomagen=$_POST['vnomagen'];
   $vtranew=$_POST['vtranew'];
   $vnomagenew=$_POST['options'];
      
   $vsolh=  $_POST['vsolh'];
   $vderh=  $_POST['vderh'];
   $vregh=  $_POST['vregh'];
        
   $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vreg=   $vreg1.$vreg2;
   $resultado=false;
   $vfec=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('vmodo',''); 
   
   $sql->connection($login);   
   if ($vopc==1) {
      $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$vsol' and solicitud!='' and tipo_mp='P'");
   }

   if ($vopc==2) {
      $resultado=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg' and registro!='' and tipo_mp='P'");
   }

   if ($vopc==1 || $vopc==2) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      
      if (!$resultado) { 
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL PROCESAR LA BUSQUEDA','p_cambagtr.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS','p_cambagtr.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vderh=$reg[nro_derecho]; 
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vreg=$reg[registro];
      $vest=$reg[estatus];
      $vreg1=substr($vreg,-7,1);
      $vreg2=substr($vreg,1);
      $vnom=$reg[nombre];
      $vest=$reg[estatus]-2000;
      $vfecsol=$reg[fecha_solic];
      $vfecreg=$reg[fecha_regis];
      $vfecven=$reg[fecha_venc];
      $vtit=$reg[titular];
      $vcodage=$reg[agente];
      $vtra=$reg[tramitante];
      //$vmod=$reg[modalidad];
      //$nameimage=imagen($vsol1,$vsol2); 

      if ($vreg<>'       ' and $vreg<>null) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('Solicitud con Registro Asignado. Corresponde a una Anotacion Marginal','p_cambagtr.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }      

      $sql->del("tmpagenr","solicitud='$vsol' and tipo_mp='P'");
      if ($vcodage==0) {$vcodage='';}
                  
      // Descripcon del estatus 
      $resulest=pg_exec("SELECT * FROM stzstder WHERE estatus-2000='$vest' and tipo_mp='P'");
      $regest = pg_fetch_array($resulest);
      $vdesest=$regest[descripcion];
      
      // Vectores de Agentes
      $obj_query = $sql->query("SELECT * FROM stzagenr ORDER BY nombre");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $vcodagenew[$contobj] = '';
      $vnomagenew[$contobj] = '';
      $objs = $sql->objects('',$obj_query);
      for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
          $vcodagenew[$contobj] = $objs->agente;
          $vnomagenew[$contobj] = $objs->nombre;
	  $objs = $sql->objects('',$obj_query);}	
   }   
      
   if ($vopc==3) {
      // Validaciones iniciales
      $resultadoag=pg_exec("SELECT agente FROM tmpagenr WHERE solicitud='$vsolh' and tipo_mp='P' order by 1");
      $vcanagen=pg_numrows($resultadoag); 
      if (($vsolh=='-' && $vregh=='') || $vdoc=='' || $vfevh=='' || ($vcanagen==0 && $vtranew=='')) {
         $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
	 }
      if ($vcanagen>0 && $vtranew!='') {
         $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - No puede tener AGENTE y TRAMITANTE a la vez','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
	 }	
      //$vfecsol=convertir_en_fecha($vfecsol,1);
      $esmayor=compara_fechas($vfecsol,$vfec);
      if ($esmayor==1) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('No se puede cargar un evento previo a la Fecha de la Solicitud','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
         }

     $can_error=0;
     pg_exec("BEGIN WORK");
     // Actualiza en Stzderec
     pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");  
     $regag = pg_fetch_array($resultadoag); 
     $vcodagen=$regag[agente];
     if ($vcodagen=='') {$vcodagen=0;}
     $update_str="agente='$vcodagen',tramitante='$vtranew'";
     $valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
     if (!$valido) {$can_error = $can_error + 1;} 
     
     // Inserta en Stmevtrd
       // Primer evento: 165
       $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and evento=2165 and documento='$vdoc'");
       $rege = pg_fetch_array($resule);
       $cantfil = pg_numrows($resule);
       if ($cantfil>0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR - El Evento ya fue Cargado','m_cambtitu.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,
                      documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_valores ="'$vderh','2165','$vfevh',nextval('stzevtrd_secuencial_seq'),$vest+2000,
                         $vdoc,'$vfec','$vuser','MODIFICACION DE DATOS DE LA SOLICITUD',
                         'CAMBIO DE AGENTE / TRAMITANTE','$hh'";
      $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
      if (!$valido) {$can_error = $can_error + 1;} 
      // Segundo evento: 12
      $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and evento=2012 and 
                       documento='$vdoc'");
      $rege = pg_fetch_array($resule);
      $cantfil = pg_numrows($resule);
      if ($cantfil>0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensaje('ERROR - El Evento ya fue Cargado','m_cambtitu.php');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      
      if ($vtranew!='') {$vcomen='Tramitante:'.$vtranew;}
      if ($vcodagen!='') {
         $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vcodagen");
         $regage = pg_fetch_array($resulage);
         $vnomagen=$regage[nombre];
         $vcomen='Agente:'.$vnomagen;} 
      else {$vcodagen=0;}
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,
                      documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_valores ="'$vderh','2012','$vfevh',nextval('stzevtrd_secuencial_seq'),
                        $vest+2000,$vdoc,'$vfec','$vuser',
                        'CAMBIO DE AGENTE / TRAMITANTE','$vcomen','$hh'";
      $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
      if (!$valido) {$can_error = $can_error + 1;} 
       
      // Inserta los nuevos agentes (en caso de haber mas de uno)
      $sql->del("stzautod","nro_derecho='$vderh'");
      $regag = pg_fetch_array($resultadoag); 
      for ($cont=1;$cont<$vcanagen;$cont++) {     
           $vage=$regag[agente];
           $insert_campos="nro_derecho,agente";
           $insert_valores="'$vderh',$vage";	 
           $resbus=pg_exec("select * from stzautod where nro_derecho='$vderh' and agente='$vage'");
           $ff=pg_numrows($resbus); 
           if ($ff==0) {$sql->insert("stzautod","$insert_campos","$insert_valores","");}
           $regag = pg_fetch_array($resultadoag);
      }

      // Mensaje final 
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','p_cambagtr.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("Falla de Ingreso en la B.D. Transacciones Abortadas...!!!",
                      "javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();   }
   }

   //Asignaci� de variables para pasarlas a Smarty
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('vsol1',$vsol1); 
   $smarty ->assign('vsol2',$vsol2);
   $smarty ->assign('vsol',$vsol);
   $smarty ->assign('vderh',$vderh);
   $smarty ->assign('vfec',$vfec);
   $smarty ->assign('registro1',$vreg1);
   $smarty ->assign('registro2',$vreg2);
   $smarty ->assign('nombre',$vnom); 
   $smarty ->assign('vdesest',$vdesest); 
   $smarty ->assign('vest',$vest); 
   $smarty ->assign('vfecsol',$vfecsol); 
   $smarty ->assign('vfecreg',$vfecreg); 
   $smarty ->assign('vfecven',$vfecven); 
   $smarty ->assign('vlicen',$vlicen); 
   $smarty ->assign('vcomenta',$vcomenta);
   $smarty ->assign('vcodagenew',$vcodagenew);
   $smarty ->assign('vnomagenew',$vnomagenew);
   $smarty ->assign('vtranew',$vtranew); 
   $smarty ->assign('vcodage',$vcodage);
   $smarty ->assign('vnomage',$vnomage);
   $smarty ->assign('vtra',$vtra);
   $smarty->assign('vmod',$vmod);
   $smarty->assign('nameimage',$nameimage);
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lregistro','Registro:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lclase','Estatus:'); 
   $smarty ->assign('lfecsol','Fecha Solicitud:'); 
   $smarty ->assign('lfecreg','Fecha Registro:'); 
   $smarty ->assign('lfecven','Fecha Vencimiento:'); 
   $smarty ->assign('lfechaevento','Fecha del Evento:'); 
   $smarty ->assign('ldocumento','Numero de Documento:'); 
   $smarty ->assign('lcomenta','Informacion Adicional:'); 
   $smarty ->assign('lagenew','Agente Nuevo:'); 
   $smarty ->assign('ltranew','Tramitante Nuevo:'); 
   $smarty ->assign('ltrage','Tramitante/Agente Actual:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty->display('p_cambagtr.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
