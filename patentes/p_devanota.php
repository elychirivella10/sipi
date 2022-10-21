<? 
// ************************************************************************************* 
// Programa: p_devanota.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año 2008 
// Modificado Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$hh      = hora();
$sql     = new mod_db(); 
$fecha   = fechahoy();  
$tbname1 = "stzcoded";
$tbname2 = "stzderec";
$tbname3 = "stppatee";
$tbname4 = "stzstder";
$tbname5 = "stzagenr";

$smarty->assign('titulo',$substpat); 
$smarty->assign('subtitulo','Devoluci&oacute;n de Anotaciones Marginales'); 
$smarty->assign('login',$usuario); 
$smarty->assign('fechahoy',$fecha); 
$smarty->assign('arrayvtrami',array(B,C,F,L,N,O));
$smarty->assign('arrayttrami',array('','Cesi&oacute;n','Fusi&oacute;n','Licencia de Uso','Cambio de Nombre','Cambio de Domicilio'));
   
$vuser = $usuario;
     
//Captura Variables leidas en formulario inicial
 $vopc  = $_GET['vopc'];
 $vder  = $_POST['vder'];
 $vreg1 = $_POST['vreg1'];
 $vreg2 = $_POST['vreg2'];
 $vsol1 = $_POST['vsol1'];
 $vsol2 = $_POST['vsol2'];
 $vfecsol = $_POST['vfecsol'];
 $vsol  = sprintf("%04d-%06d",$vsol1,$vsol2);
 $vnom  = $_POST['vnom'];
 $vcla  = $_POST['vcla'];
 $vtra  = $_POST['tramite'];
 $vindcla = $_POST['vindcla'];
 $resultado=false;
  
 $vsolh   = $_POST['vsolh'];
 $vfevh   = $_POST['vfevh'];
 $vfechr  = $_POST['vfechr'];
 $vcausa1 = $_POST['causa1'];  $vcausa2 =$_POST['causa2'];  $vcausa3 =$_POST['causa3'];  
 $vcausa4 = $_POST['causa4'];  $vcausa5 =$_POST['causa5'];  $vcausa6 =$_POST['causa6'];  
 $vcausa7 = $_POST['causa7'];  $vcausa8 =$_POST['causa8'];  $vcausa9 =$_POST['causa9'];  
 $vcausa10= $_POST['causa10']; $vcausa11=$_POST['causa11']; $vcausa12=$_POST['causa12'];
 $vcausa13= $_POST['causa13']; $vcausa14=$_POST['causa14']; $vcausa15=$_POST['causa15'];
 $vcausa16= $_POST['causa16']; $vcausa17=$_POST['causa17']; $vcausa18=$_POST['causa18'];
 $vcausa19= $_POST['causa19']; $vcausa20=$_POST['causa20']; $vcausa21=$_POST['causa21'];
 $votro   = $_POST['otro'];
 $vnumtram= $_POST['vnumtram'];
 $vfec    = hoy();

 if (!empty($vreg1) && !empty($vreg2)) { $vreg = $vreg1.$vreg2; }

   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vreg1'); 
   $smarty ->assign('vmodo','readonly'); 
   $smarty ->assign('modo',''); 
   
   $sql->connection($usuario);   

   //Verifica si el progrma esta en mantenimiento
   $manphp = vman_php("p_devanota.php");
   if ($manphp==1) {
     $smarty->display('encabezado1.tpl');
     MensageError('Modulo en Mantenimiento ...!!!','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }     

   if ($vopc==1) {
    //Validacion del Numero de Registro
   if (empty($vreg1) && empty($vreg2)) {
      mensajenew("No introdujo ningún valor de Expediente ...!!!","p_devanota.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }

     $resultado=pg_exec("SELECT * FROM $tbname2 WHERE registro='$vreg' AND registro!='' AND tipo_mp='P'");
   }
   
   if ($vopc==1) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas2.tramite'); 
      $smarty ->assign('vmodo','readonly'); 
      $smarty ->assign('modo','readonly'); 
      
      if (!$resultado) { 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','p_devanota.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','p_devanota.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);

      $vsol=$reg[solicitud];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vder=$reg[nro_derecho];
      $vnom=$reg[nombre];
      $vest=$reg[estatus];
      $vfecsol=$reg[fecha_solic];
      $fechavenc=$reg[fecha_venc];
      $fechareg =$reg[fecha_regis];
      $vtramita=$reg[tramitante]; 
      $agente = $reg[agente];
      if ($reg['tipo_derecho']=='A') {$lctipo='A'; $tipopaten='DE INVENCION';}
      if ($reg['tipo_derecho']=='B') {$lctipo='B'; $tipopaten='DIBUJO INDUSTRIAL';}
      if ($reg['tipo_derecho']=='C') {$lctipo='C'; $tipopaten='DE MEJORA';}
      if ($reg['tipo_derecho']=='D') {$lctipo='D'; $tipopaten='DE INTRODUCCION';}
      if ($reg['tipo_derecho']=='E') {$lctipo='E'; $tipopaten='MODELO INDUSTRIAL';}
      if ($reg['tipo_derecho']=='F') {$lctipo='F'; $tipopaten='MODELO DE UTILIDAD';}
      if ($reg['tipo_derecho']=='G') {$lctipo='G'; $tipopaten='DISE&Ntilde;O INDUSTRIAL';}
      if ($reg['tipo_derecho']=='V') {$lctipo='V'; $tipopaten='VARIEDADES VEGETALES';}

      //Obtención de la Descripción del Estatus 
      $vdest = estatus($vest);

      //Obtención del agente si tramitante is NULL 
      if ($agente > 0) {
        $obj_query = $sql->query("SELECT nombre FROM stzagenr WHERE agente='$agente'");
        $objs = $sql->objects('',$obj_query);
        $vnbage = $objs->nombre; }

      if ($agente > 0) { $vtragen= $agente." - ".$vnbage; }
      else { $vtragen= $vtramita; }

      $nameimage=ver_imagen($vsol1,$vsol2,'P'); 
      $smarty ->assign('nameimage',$nameimage); 
   
      if ($vest==2555) { 
        //Descripcion de causales para Devolucion
        $smarty ->assign('lcausadev','Causales de Devoluci&oacute;n:'); 
        $resultadoc=pg_exec("SELECT * FROM stzcoded WHERE cod_causa=1 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('luno',$regc[desc_causa]);
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=2 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldos',    $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=3 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ltres',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=4 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lcuatro', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=5 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lcinco',  $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=6 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lseis',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=7 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lsiete',  $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=8 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('locho',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=9 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lnueve',  $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=10 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldiez',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=11 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lonce',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=12 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldoce',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=13 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ltrece',  $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=14 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lcatorce',$regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=15 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lquince', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=16 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldieciseis', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=17 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldiecisiete', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=18 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldieciocho', $regc[desc_causa]); 
        //$resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=19 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        //$smarty ->assign('ldiecinueve', $regc[desc_causa]); 
        //$resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=20 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        //$smarty ->assign('lveinte', $regc[desc_causa]); 
        //$resultadoc=pg_exec("SELECT * FROM $tbname1 WHERE cod_causa=21 and derecho='P' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        //$smarty ->assign('lveintiuno', $regc[desc_causa]); 
        $smarty ->assign('lveintidos', 'Otros:');
      } else {
          $smarty->display('encabezado1.tpl');
          mensajenew('Solo Aplica en Solicitudes que tengan Estatus: 555-Registradas','p_devanota.php','N');
	  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
   }
   
   if ($vopc==3) {
      if (($vcausa1=='' and $vcausa2=='' and $vcausa3=='' and 
         $vcausa4=='' and $vcausa5=='' and $vcausa6=='' and $vcausa7=='' and
         $vcausa8=='' and $vcausa9=='' and $vcausa10=='' and $vcausa11=='' and
         $vcausa12=='' and $vcausa13=='' and $vcausa14=='' and $vcausa15=='' and  
         $vcausa16=='' and $vcausa17=='' and $vcausa18=='' and $vcausa19=='' and
         $vcausa20=='' and $vcausa21=='' and $votro=='')) {
         $smarty->display('encabezado1.tpl');
         mensajenew("ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS ...!!!","javascript:history.back();","N");
	 $smarty->display('pie_pag.tpl'); exit();  
      }
      //$esmayor=compara_fechas($vfevh,$vfec);
      //if ($esmayor==1) {
      //   $smarty->display('encabezado1.tpl');
      //   mensajenew("No se puede cargar un Evento a futuro ...!!!","javascript:history.back();","N");
      //   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      //}
      if ($vtra=='B') {
        $smarty->display('encabezado1.tpl');
        mensajenew("No selecciono el Tipo de Anotaci&oacute;n Marginal ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }

      //Validacion adicional por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM $tbname2 WHERE solicitud='$vsolh' AND solicitud!='' AND tipo_mp='P'");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      $vfecsol= $regsol[fecha_solic];
      if ($vest==2555) { //Esta bien
      } else {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario ...!!!','p_devanota.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      //$vfecsol=convertir_en_fecha($vfecsol,1);
      //$esmayor=compara_fechas($vfecsol,$vfevh);
      $esmayor=compara_fechas($vfecsol,$vfechr);  
      if ($esmayor==1) {
         $smarty->display('encabezado1.tpl');
         mensajenew('No se puede cargar un evento previo a la Fecha de la Solicitud ...!!!','javascript:history.back();','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      switch ($vtra) {
        case "C":
          $vcomenta = "Cesión";
          break;
        case "F":
          $vcomenta = "Fusión";
          break;
        case "N":
          $vcomenta = "Cambio de Nombre";
          break;
        case "O":
          $vcomenta = "Cambio de Domicilio";
          break;
        case "L":
          $vcomenta = "Licencia de Uso";
          break;
      }       

      $vdese='REGISTRO CON SOLICITUD DE ANOTACION MARGINAL EN EXAMEN DE FORMA';
      pg_exec("BEGIN WORK");

      pg_exec("LOCK TABLE stzsystem IN ROW EXCLUSIVE MODE");
      $update_str = "devolucion = nextval('stzsystem_devolucion_seq')";
      $upd_sys = $sql->update("stzsystem","$update_str","");    
      
      $obj_query = $sql->query("SELECT * FROM stzsystem");
      $objs = $sql->objects('',$obj_query);
      $doc  = $objs->devolucion;

      //update stzsystem set ntitular = nextval('stzsystem_ntitular_seq');
      //SELECT currval('stzsystem_ntitular_seq');
      //SELECT nextval('stzsystem_ntitular_seq');

      // Inserta en Stzcaded
      $ins_de=true;
      $inscaus = 0;
      $col_campos = "nro_derecho,cod_causa,derecho,grupo,tipo_dev,fecha_dev,hora,documento";
      if ($vcausa1 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',1,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa2 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',2,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa3 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',3,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa4 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',4,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa5 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',5,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa6 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',6,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa7 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',7,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa8 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',8,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa9 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',9,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa10=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',10,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa11=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',11,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa12=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',12,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa13=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',13,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa14=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',14,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa15=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',15,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa16=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',16,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa17=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',17,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa18=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',18,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa19=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',19,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa20=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',20,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa21=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',21,'P','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }

      $votro = trim($votro);
      if ($votro<>'') {
        $col_campos = "nro_derecho,otros,derecho,grupo,tipo_dev,fecha_dev,hora,documento";
        $ins_otros = $sql->insert("stzotrde","$col_campos","'$vder','$votro','P','A','$vtra','$vfec','$hh','$doc'",""); 
        if (!$ins_otros) { $inscaus = $inscaus + 1; } }

      // Inserta evento en Stpevtrd
      //$ins_evento=true;
      //$comentario = "$vtra"." - "."$vcomenta"." de Fecha: "."$vfechr".", No. Tramite: "."$vnumtram";
      //$insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,fecha_trans,
      //                usuario,desc_evento,comentario,hora";
      //$insert_valores="'$vder',2502,'$vfec',$vest,$doc,'$vfec',
      //               '$vuser','$vdese','$comentario','$hh'";
      //$ins_evento= $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 

      // Inserta evento en Stzevtrd
      $ins_evento=true;
      $comentario = "$vtra"." - "."$vcomenta"." de Fecha: "."$vfechr".", No. Tramite: "."$vnumtram";
      $insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,fecha_trans,
                      usuario,desc_evento,comentario,hora";
      $insert_valores="'$vder',2502,'$vfec',$vest,$doc,'$vfec',
                     '$vuser','$vdese','$comentario','$hh'";
      $ins_evento= $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 


      // Mensaje final
      if ($ins_evento and $inscaus==0) { 
        pg_exec("COMMIT WORK");  
        $sql->disconnect();
        $smarty->display('encabezado1.tpl');
        mensajenew('DATOS GUARDADOS CORRECTAMENTE .!','p_devanota.php','S');
        $smarty->display('pie_pag.tpl'); exit();   
      }
      else {
        pg_exec("ROLLBACK WORK");
        $sql->disconnect();
        $smarty->display('encabezado1.tpl');
        mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!",
                   "javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();    
      }

   }   

   //Asignacion de variables para pasarlas a Smarty
   $smarty->assign('vopc',$vopc); 
   $smarty->assign('vder',$vder); 
   $smarty->assign('vsol1',$vsol1); 
   $smarty->assign('vsol2',$vsol2); 
   $smarty->assign('vreg1',$vreg1); 
   $smarty->assign('vreg2',$vreg2); 
   $smarty->assign('nombre',$vnom); 
   $smarty->assign('vfevh',$vfevh); 
   $smarty->assign('vfec',$vfec);
   $smarty->assign('vest',$vest-2000);
   $smarty->assign('vdest',$vdest);
   $smarty->assign('vtragen',$vtragen);
   $smarty->assign('vfecsol',$vfecsol); 
   $smarty->assign('causa1',$vcausa1); 
   $smarty->assign('causa2',$vcausa2); 
   $smarty->assign('causa3',$vcausa3); 
   $smarty->assign('causa4',$vcausa4); 
   $smarty->assign('causa5',$vcausa5); 
   $smarty->assign('causa6',$vcausa6); 
   $smarty->assign('causa7',$vcausa7); 
   $smarty->assign('causa8',$vcausa8); 
   $smarty->assign('causa9',$vcausa9); 
   $smarty->assign('causa10',$vcausa10); 
   $smarty->assign('causa11',$vcausa11); 
   $smarty->assign('causa12',$vcausa12); 
   $smarty->assign('causa13',$vcausa13); 
   $smarty->assign('causa14',$vcausa14); 
   $smarty->assign('causa15',$vcausa15); 
   $smarty->assign('causa16',$vcausa16); 
   $smarty->assign('causa17',$vcausa17);
   $smarty->assign('causa18',$vcausa18);
   $smarty->assign('causa19',$vcausa19);
   $smarty->assign('causa20',$vcausa20);
   $smarty->assign('causa21',$vcausa21);
   $smarty->assign('lctipo',$lctipo);
   $smarty->assign('fecha_venc',$fecha_venc);
   $smarty->assign('tipopaten',$tipopaten);
   $smarty->assign('solicitud1',$vsol1); 
   $smarty->assign('solicitud2',$vsol2); 
   $smarty->assign('uno','01'); 
   $smarty->assign('dos','02'); 
   $smarty->assign('tres','03'); 
   $smarty->assign('cuatro','04'); 
   $smarty->assign('cinco','05'); 
   $smarty->assign('seis','06'); 
   $smarty->assign('siete','07'); 
   $smarty->assign('ocho','08'); 
   $smarty->assign('nueve','09'); 
   $smarty->assign('diez','10'); 
   $smarty->assign('once','11'); 
   $smarty->assign('doce','12'); 
   $smarty->assign('trece','13'); 
   $smarty->assign('catorce','14'); 
   $smarty->assign('quince','15');
   $smarty->assign('dieciseis','16');
   $smarty->assign('diecisiete','17');
   $smarty->assign('dieciocho','18');
   $smarty->assign('diecinueve','19');
   $smarty->assign('veinte','20');
   $smarty->assign('veintiuno','21');
   $smarty->assign('lsolicitud','Solicitud:'); 
   $smarty->assign('lregistro','Registro:'); 
   $smarty->assign('lctipop','Tipo:'); 
   $smarty->assign('lnumtra','N&uacute;mero Tr&aacute;mite:'); 
   $smarty->assign('lfechasolic','Fecha de Solicitud:'); 
   $smarty->assign('lfechaevent','Fecha del Evento:'); 
   $smarty->assign('lfecharen','de Fecha:'); 
   $smarty->assign('lnombre','T&iacute;tulo:');
   $smarty->assign('lotro','Otro:'); 
   $smarty->assign('lestatus','Estatus:'); 
   $smarty->assign('ltramage','Tramitante/Agente:'); 
   $smarty->assign('espacios',''); 
   $smarty->assign('ltramite','Tipo Tramite:'); 

   $smarty->display('encabezado1.tpl');
   $smarty->display('p_devanota.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
