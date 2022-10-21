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
$smarty ->assign('subtitulo','Anotaciones Marginales - Licencias de Uso'); 
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
   $vtipo=$_POST['vtipo'];
   $vlicen=$_POST['vlicen'];
   $vcomenta=$_POST['vcomenta'];
   $smarty ->assign('vfecven',$vfecven); 
   $vtra=$_POST['vtra'];
   $vcodage=$_POST['vcodage'];
   $vnomage=$_POST['vnomage'];
   $vtranew=$_POST['vtranew'];
   $vcodagen=$_POST['vcodagen'];
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
         mensajenew('ERROR AL PROCESAR LA BUSQUEDA','p_amlicuso.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS','p_amlicuso.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vderh=$reg[nro_derecho];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vreg=$reg[registro];
      $vest=$reg[estatus];
      $vreg1=substr($vreg,-8,1);
      $vreg2=substr($vreg,1);
      $vnom=$reg[nombre];
      $vest=$reg[estatus];
      $vfecsol=$reg[fecha_solic];
      $vfecreg=$reg[fecha_regis];
      $vfecven=$reg[fecha_venc];
      $vtit=$reg[titular];
      $vcodage=$reg[agente];
      $vtra=$reg[tramitante];
      
      if ($vcodage==0) {$vcodage='';}
      if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      }
            
      if ($vreg!='') { //Esta bien 
      }  ELSE {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('Solo aplica a PATENTES con REGISTRO ASIGNADO','p_amlicuso.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      // Descripcon del estatus 
      $resulest=pg_exec("SELECT * FROM stzstder WHERE estatus='$vest' and tipo_mp='P'");
      $regest = pg_fetch_array($resulest);
      $vdesest=$regest[descripcion];
      $vest=$vest-2000;
      
      // Vectores de Agentes
      $obj_query = $sql->query("SELECT agente,nombre FROM stzagenr order by nombre");
      //$obj_filas = $sql->nums('',$obj_query);
      $obj_filas = pg_numrows($obj_query); 
      $contobj = 0;
      $vcodagenew[$contobj] = '';
      $vnomagenew[$contobj] = '';
      //$objs = $sql->objects('',$obj_query);
      $obj_reg = pg_fetch_array($obj_query);
      for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
          $vcodagenew[$contobj] = $obj_reg[agente];
          $vnomagenew[$contobj] = $obj_reg[nombre];
	  //$objs = $sql->objects('',$obj_query);}	
          $obj_reg = pg_fetch_array($obj_query); }
   }   
      
   if ($vopc==3) {
      // Validaciones iniciales
      if ($vsolh=='-' || $vregh=='' || $vcomenta=='' || $vdoc=='' || $vfevh=='' || $vlicen=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
	 }
      $vfecsol=convertir_en_fecha($vfecsol,1);	  
      $esmayor=compara_fechas($vfecsol,$vfec);
      if ($esmayor==1) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('No se puede cargar un evento previo a la Fecha de la Solicitud',
                    'javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
         }
       $vcodeven=2207; $vdeseven='SOLICITUD DE LICENCIA DE USO';
   
      $can_error=0;
      pg_exec("BEGIN WORK");           
      // Inserta en Stmevtrd
      $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and 
                       evento='$vcodeven' and documento='$vdoc'");
       $rege = pg_fetch_array($resule);
       $cantfil = pg_numrows($resule);
       if ($cantfil>0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR - El Evento ya fue Cargado','p_amlicuso.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,
                     fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_valores ="'$vderh','$vcodeven','$vfevh',nextval('stzevtrd_secuencial_seq'),
                         $vest+2000,$vdoc,'$vfec','$vuser','$vdeseven','$vcomenta','$hh'";
      $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
      if (!$valido) {$can_error = $can_error + 1;}
       
      // Guardar Tabla Nueva para posteriores actualizaciones
      if ($vcodagen=='' && $vtranew=='') {$vagef=$vcodage; $vtraf=$vnomage;} 
      else {$vagef=0; $vtraf=$vtra;}
      if ($vcodagen!='') {
         $resulage=pg_exec("SELECT * FROM stzagenr WHERE agente='$vcodagen'");
         $regage = pg_fetch_array($resulage);
         $vcodagenew=$regage[agente];}  else {$vcodagenew=0;}
      if ($vnomagenew!='') {$vagef=$vcodagenew; $vtraf=$vnomagenew;} 
      else {if ($vtranew!='') {$vagef=0; $vtraf=$vtranew;}} 	 
      if ($vagef>0) {
         $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vagef");
         $regage = pg_fetch_array($resulage);
         $vtraf=$regage[nombre];}   
      $vlicen2='Licenciatario: '.$vlicen;
      $insert_campos="nro_derecho,nanota,solicitud,tipo,evento,nom_tit_2,tramitante,agente,
                      verificado,inf_adicional,cod_tit_1,cod_tit_2";
      $insert_valores ="$vderh,$vdoc,'$vsolh','P',$vcodeven,'$vlicen','$vtraf',
                        $vagef,'N','$vlicen2',0,0";
      $valido=$sql->insert("stzantma","$insert_campos","$insert_valores","");
      if (!$valido) {$can_error = $can_error + 1;}  

      // Mensaje final 
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','p_amlicuso.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("Falla de Ingreso en la B.D. Transacciones Abortadas...!!!",
                      "javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();   }

   }
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
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
   $smarty ->assign('llicen','Licenciatario:'); 
   $smarty ->assign('lagenew','Agente Nuevo:'); 
   $smarty ->assign('ltranew','Tramitante Nuevo:'); 
    $smarty ->assign('ltrage','Tramitante/Agente Actual:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty->display('p_amlicuso.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
