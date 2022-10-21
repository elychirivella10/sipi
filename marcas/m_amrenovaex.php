<? 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login   = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$sede    = $_SESSION['usuario_sede'];

$hh=hora();
$sql = new mod_db();
$vuser=$usuario;  
$fecha=fechahoy();

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Anotaciones Marginales - Renovaciones Exoneradas'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
   
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
   $vcomenta=$_POST['vcomenta'];
   $smarty ->assign('vfecven',$vfecven); 
   $vtra=$_POST['vtra'];
   $vcodage=$_POST['vcodage'];
   $vcodagen=$_POST['vcodagen'];
   $vnomagen=$_POST['vnomagen'];
   $vnomage=$_POST['vnomage'];
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
   $smarty ->assign('modo1','readonly'); 
   
   $sql->connection($login);   
   if ($vopc==1) {
      $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$vsol' and solicitud!='' and tipo_mp='M'");
   }

   if ($vopc==2) {
      $resultado=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg' and registro!='' and tipo_mp='M'");
   }

   if ($vopc==1 || $vopc==2) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      $smarty ->assign('modo1',''); 
      
      if (!$resultado) { 
        $sql->disconnect();
        mensajenew('ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!','m_amrenovaex.php','N');
	     $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','m_amrenovaex.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vderh=$reg[nro_derecho];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vreg=ltrim(rtrim($reg[registro]));
      $vest=$reg[estatus];
      $vreg1=substr($vreg,-7,1);
      $vreg2=substr($vreg,1);
      $vnom=$reg[nombre];
      $vest=$reg[estatus];
      $vfecsol=$reg[fecha_solic];
      $vfecreg=$reg[fecha_regis];
      $vfecven=$reg[fecha_venc];
      $vtit=$reg[titular];
      $vcodage=$reg[agente];
      $vtra=$reg[tramitante];
      
      if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      }
            
      if ($vreg!='') { //Esta bien 
      }  ELSE {
         $sql->disconnect();
         mensajenew('ERROR: Solo aplica a MARCAS con REGISTRO ASIGNADO ...!!!','m_amrenovaex.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
      // Descripcon del estatus 
      $resulest=pg_exec("SELECT * FROM stzstder WHERE estatus='$vest' and tipo_mp='M'");
      $regest = pg_fetch_array($resulest);
      $vdesest=$regest[descripcion];
      $vest=$vest-1000;
      
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
      if ($vsolh=='-' || $vregh=='' || $vcomenta=='' || $vdoc=='' || $vfevh=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - DATOS INCORRECTOS O VACIOS ...!!!','m_amrenovaex.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
	 }
      $vfecsol=convertir_en_fecha($vfecsol,1);	   
      $esmayor=compara_fechas($vfecsol,$vfec);
      if ($esmayor==1) {
         $sql->disconnect(); 
         mensajenew('ERROR: No se puede cargar un evento previo a la Fecha de la Solicitud ...!!!','m_amrenovaex.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
         }

      $vcodeven=1204; $vdeseven='SOLICITUD DE RENOVACION';
      $can_error=0;
      pg_exec("BEGIN WORK");   
      // Inserta en Stmevtrd
      $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and evento='$vcodeven' and documento='$vdoc'");
      $rege = pg_fetch_array($resule);
      $cantfil = pg_numrows($resule);
      if ($cantfil>0) {
         $sql->disconnect();
         mensajenew('ERROR: El Evento ya fue Cargado ...!!!','m_amrenovaex.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
      $vcomenta = $vcomenta." EXONERADO.";
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_valores ="'$vderh','$vcodeven','$vfevh',nextval('stzevtrd_secuencial_seq'),
                         $vest+1000,$vdoc,'$vfec','$vuser','$vdeseven','$vcomenta','$hh'";
      $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
      if (!$valido) {$can_error = $can_error + 1;}  
       
      // Guardar Tabla Nueva para posteriores actualizaciones
      if ($vcodagen=='' && $vtranew=='' && $vcodage!='') {$vagef=$vcodage; $vtraf=$vnomage;} 
      else {$vagef=0; $vtraf=$vtra;}
       
      if ($vcodagen!='' || !empty($vcodagen)) {
         $resulage=pg_exec("SELECT * FROM stzagenr WHERE agente='$vcodagen'");
         $regage = pg_fetch_array($resulage);
         $vcodagenew=$regage[agente];}  else {$vcodagenew=0;}
         
      if ($vcodagen!='') {$vagef=$vcodagen; $vtraf=$vnomagen;} 
      else {if ($vtranew!='') {$vagef=0; $vtraf=$vtranew;}} 	 
      if ($vagef>0) {
         $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vagef");
         $regage = pg_fetch_array($resulage);
         $vtraf=$regage[nombre];} 
      if (ltrim(rtrim($vagef))=='') {$vagef=0;}           
      $insert_campos="nro_derecho,nanota,solicitud,tipo,evento,tramitante,agente,
                      verificado,inf_adicional,cod_tit_1,cod_tit_2";
      $insert_valores ="$vderh,$vdoc,'$vsolh','M',$vcodeven,'$vtraf',$vagef,'N','$vcomenta',0,0";
      $valido=$sql->insert("stzantma","$insert_campos","$insert_valores","");
      if (!$valido) {$can_error = $can_error + 1;}  

      // Mensaje final
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_amrenovaex.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           mensajenew("ERROR: Falla de Ingreso en la B.D. Transacciones Abortadas ...!!!","m_amrenovaex.php","N");
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
   $smarty ->assign('ldocumento','Nmero de Documento:'); 
   $smarty ->assign('lcomenta','Informacion Adicional:'); 
   $smarty ->assign('lagenew','Agente Nuevo:'); 
   $smarty ->assign('ltranew','Tramitante Nuevo:'); 
   $smarty ->assign('ltrage','Tramitante/Agente Actual:'); 
   
   $smarty ->assign('espacios',''); 
   $smarty->display('m_amrenovaex.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
