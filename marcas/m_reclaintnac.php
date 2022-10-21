<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// *************************************************************************************
// Programa: m_reclaintnac.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado Año 2008 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

$sql  = new mod_db();
$tbname_1 = "stmmarce";
$tbname_2 = "stzstder";
$tbname_3 = "stzagenr";
$tbname_4 = "stzevder";
$tbname_5 = "stmrecla";
$tbname_6 = "stzderec";
$tbname_7 = "stzevtrd";
$tbname_8 = "stmtmprec";
$fecha     = fechahoy();

$vopc      = $_GET['vopc'];
$vsol1     = $_POST['vsol1'];
$vsol2     = $_POST['vsol2'];
$vsol      = $_POST['vsol'];
$vest      = $_POST['vest'];
$modal_id  = $_POST['modal_id'];
$vcomenta  = $_POST['vcomenta'];
$estatus_id= $_POST['estatus_id'];
$nameimage = $_POST['nameimage'];
$accion    = $_POST['accion'];
$vstring2  = $_POST['vstring2'];
$distingue = $_POST['distingue'];
$vexist    = $_POST['vexist'];
$vder      = $_POST['vder'];
$vfecsol   = $_POST['vfecsol'];
$fecha_evento = $_POST['fecha_evento'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Escrito de Reclasificaci&oacute;n de Solicitud Clase Int->Nac');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol1'); 
$smarty ->assign('vmodo',''); 

//Verificando conexion
$sql->connection($usuario);

if (!empty($vsol1) && !empty($vsol2))
{
  //Armado del Numero de Expediente
  $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
}  
$resultado=true;

if ($vopc!=1 || $vopc!=5) {
  $smarty ->assign('modo','readonly=readonly'); 
  $smarty ->assign('modo1',''); 
}

if ($vopc==1) {
    $smarty ->assign('submitbutton','button'); 
    $smarty ->assign('varfocus','formarcas3.vdoc'); 
    $smarty ->assign('vmodo','readonly=readonly'); 
    $smarty ->assign('modo1','disabled'); 

    //Validacion del Numero de Solicitud
    if (empty($vsol1) && empty($vsol2)) {
      mensajenew('No introdujo ningún valor de Expediente ...!!!','m_reclaintnac.php','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' and solicitud!='' AND tipo_mp='M'");
    if (!$resultado) { 
      mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_reclaintnac.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','m_reclaintnac.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $reg   = pg_fetch_array($resultado);
    $vder  = $reg[nro_derecho];
    $vsol  = $reg[solicitud];
    $vest  = $reg[estatus];
    $vsol1 = substr($vsol,-11,4);
    $vsol2 = substr($vsol,-6,6);
    $vreg  = $reg[registro];
    $vreg1 = substr($vreg,-7,1);
    $vreg2 = substr($vreg,1);
    $vnom  = trim($reg[nombre]);
    $vtipo = $reg[tipo_derecho];
    $vfecsol = $reg[fecha_solic];
    $vfecreg = $reg[fecha_regis];
    $vfecven = $reg[fecha_venc];
    $vcodage = $reg[agente];
    $vtra  = trim($reg[tramitante]);

    $vexist= 0;
    $distingue='';
    //Obtención de datos de la Marca 
    $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
    $objs = $sql->objects('',$obj_query);
    $modal_id  = $objs->modalidad;
    $vclase    = $objs->clase;
    $vindc     = $objs->ind_claseni;
    $distingue = trim($objs->distingue);
    if (!empty($distingue)) { $vexist= 1; } 
    $smarty->assign('vstring2',$distingue);
    $smarty->assign('distingue',$distingue);
    $smarty->assign('vexist',$vexist);

    if ($vindc!="I") {
      mensajenew('EVENTO APLICABLE A SOLICITUDES EN CLASE INTERNACIONAL ...!!!','m_reclaintnac.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    switch ($modal_id) {
      case "D":
         $modal = "DENOMINATIVA";
         break;
      case "G":
         $modal = "GRAFICA";
         $nameimage = ver_imagen($vsol1,$vsol2,'M');
         break;
      case "M":
         $modal = "MIXTA";
         $nameimage = ver_imagen($vsol1,$vsol2,'M'); 
         break;
    }

    switch ($vtipo) {
      case "M":
         $vtip='MARCA DE PRODUCTO';
         break;
      case "N":
         $vtip='NOMBRE COMERCIAL';
         break;
      case "L":
         $vtip='LEMA COMERCIAL';
         break;
      case "S":
         $vtip='MARCA DE SERVICIO';
         break;
      case "C":
         $vtip='MARCA COLECTIVA';
         break;
      case "D":
         $vtip='DENOMINACION DE ORIGEN';
         break;
    }

    switch ($vindc) {
      case "I":
         $vindcla='INTERNACIONAL';
         break;
      case "N":
         $vindcla='NACIONAL';
         break;
    }


    // Nombre del Agente si es el caso      
    if ($vcodage!='') {
      $resulage = pg_exec("SELECT nombre FROM $tbname_3 WHERE agente=$vcodage");
      $regage   = pg_fetch_array($resulage);
      $vnomage  = trim($regage[nombre]);
      $vtra=$vcodage." - ".$vnomage;
    }

    // Descripcon del estatus 
    $resulest= pg_exec("SELECT * FROM $tbname_2 WHERE estatus='$vest'");
    $regest  = pg_fetch_array($resulest);
    $vdesest = trim($regest[descripcion]);
    $vest    = $vest-1000;

    // Obtencion del Titular   
    $obj_query = $sql->query("SELECT a.titular,b.nombre,a.domicilio,a.nacionalidad,c.nombre as nombrep
                              FROM stzottid a,stzsolic b,stzpaisr c 
                              WHERE a.nro_derecho ='$vder' AND  
                                    a.titular=b.titular AND 
                                    a.nacionalidad=c.pais");
    $obj_filas = $sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    $vcodtit = $objs->titular;
    $vnomtit = trim($objs->nombre);
    $vdomtit = trim($objs->domicilio);
    $vnactit = $objs->nacionalidad;
    $vnadtit = $objs->nombrep;

    $resulpoh=pg_exec("SELECT * FROM stmrecla WHERE nro_derecho='$vder' order by clase_nac");
    $regpoh = pg_fetch_array($resulpoh);
    $filaspoh=pg_numrows($resulpoh);

    // se elimina cualquier ocurrencia en la tabla tmprecla 
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stmtmprec IN SHARE ROW EXCLUSIVE MODE");
    $sql->del("stmtmprec","nro_derecho='$vder'");
    for($cont=0;$cont<$filaspoh;$cont++) { 
      //se inserta en tabla auxiliar de reclasificacion
      $insert_valores ="'$vder','$regpoh[clase_nac]','$regpoh[productos]'";
      $sql->insert("stmtmprec","","$insert_valores","");
      // se inicializa vector de viena
      $vpoderhab1[$cont]=$regpoh[clase_nac];
      if (strlen(trim($regpoh[productos])) > 60) {
        $vpoderhab2[$cont] = substr(trim($regpoh[productos]),0,60)."..."; }
      else {
        $vpoderhab2[$cont] = substr(trim($regpoh[productos]),0,60); }
      $regpoh = pg_fetch_array($resulpoh);
    }
    pg_exec("COMMIT WORK"); 	 
    $smarty->assign('arr_ph1',$vpoderhab1); 
    $smarty->assign('arr_ph2',$vpoderhab2); 
    $smarty->assign('vnumrows',$filaspoh);
   
    $resultram=pg_exec("SELECT * FROM $tbname_7 WHERE nro_derecho='$vder' and evento=1218");
    $filasfound=pg_numrows($resultram);
    if ($filasfound!=0) {
      Mensajenew('Escrito de Reclasificación ya cargado a la Solicitud ...!!!','m_reclaintnac.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    
}

   if ($vopc==4 || ($vopc==5 && $accion!='Guardar')) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.etiqueta'); 
      $smarty ->assign('modo1','disabled'); 
      $smarty ->assign('vmodo','readonly=readonly'); 
      $smarty ->assign('modo',''); 
      
      // Validaciones iniciales
      $vder   = $_POST['vder'];
      $vccv   = $_POST['vccv'];
      $vsol   = $_GET['vsol'];
      $accion = $_POST['accion'];
      $vprodu = $_POST['vagenom'];
      $vsol1  = substr($vsol,-11,4);
      $vsol2  = substr($vsol,-6,6);
      
      //Datos de la Marca
      $resultado  = pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='M'");
      $filas_found= pg_numrows($resultado); 
      $reg  = pg_fetch_array($resultado);
      $vder = $reg[nro_derecho];
      $vsol = $reg[solicitud];
      $vest = $reg[estatus];
      $vsol1= substr($vsol,-11,4);
      $vsol2= substr($vsol,-6,6);
      $vreg = $reg[registro];
      $vreg1= substr($vreg,-7,1);
      $vreg2= substr($vreg,1);
      $vnom = trim($reg[nombre]); 
      $vtipo= $reg[tipo_derecho]; 
      $vfecsol=$reg[fecha_solic];
      $vfecreg=$reg[fecha_regis];
      $vfecven=$reg[fecha_venc];
      $vcodagen=$reg[agente];
      $vtra=trim($reg[tramitante]);

      $vexist= 0;
      $distingue='';
      //Obtención de datos de la Marca 
      $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
      $objs = $sql->objects('',$obj_query);
      $modal_id  = $objs->modalidad;
      $vclase    = $objs->clase;
      $vindc     = $objs->ind_claseni;
      $distingue = trim($objs->distingue);
      if (!empty($distingue)) { $vexist= 1; } 
      $smarty->assign('vstring2',$distingue);
      $smarty->assign('distingue',$distingue);
      $smarty->assign('vexist',$vexist);

      switch ($modal_id) {
        case "D":
          $modal = "DENOMINATIVA";
          break;
        case "G":
          $modal = "GRAFICA";
          $nameimage = ver_imagen($vsol1,$vsol2,'M');
          break;
        case "M":
          $modal = "MIXTA";
          $nameimage = ver_imagen($vsol1,$vsol2,'M');
          break;
      }
      switch ($vtipo) {
        case "M":
          $vtip='MARCA DE PRODUCTO';
          break;
        case "N":
          $vtip='NOMBRE COMERCIAL';
          break;
        case "L":
          $vtip='LEMA COMERCIAL';
          break;
        case "S":
          $vtip='MARCA DE SERVICIO';
          break;
        case "C":
          $vtip='MARCA COLECTIVA';
          break;
        case "D":
          $vtip='DENOMINACION DE ORIGEN';
          break;
      }
      switch ($vindc) {
        case "I":
          $vindcla='INTERNACIONAL';
          break;
        case "N":
          $vindcla='NACIONAL';
          break;
      }
      // Nombre del Agente si es el caso      
      if ($vcodage!='') {
       $resulage=pg_exec("SELECT nombre FROM $tbname_3 WHERE agente=$vcodagen");
       $regagen = pg_fetch_array($resulage);
       $vnomagen=$regagen[nombre];
       $vtra=$vcodagen." - ".$vnomagen;
      }
      // Descripcon del estatus 
      $resulest=pg_exec("SELECT * FROM $tbname_2 WHERE estatus='$vest'");
      $regest = pg_fetch_array($resulest);
      $vdesest=$regest[descripcion];
      $vest   = $vest-1000;
            
      // Obtencion del Titular   
      $obj_query = $sql->query("SELECT a.titular,b.nombre,a.domicilio,a.nacionalidad,c.nombre as nombrep
                                FROM stzottid a,stzsolic b,stzpaisr c 
                                WHERE a.nro_derecho ='$vder' AND  
                                      a.titular=b.titular AND 
                                      a.nacionalidad=c.pais");
      $obj_filas = $sql->nums('',$obj_query);
      $objs = $sql->objects('',$obj_query);
      $vcodtit = $objs->titular;
      $vnomtit = trim($objs->nombre);
      $vdomtit = trim($objs->domicilio);
      $vnactit = $objs->nacionalidad;
      $vnadtit = $objs->nombrep;

      if ($vopc==5 && ($accion!="Guardar" && $accion!="Incluir")) {
         $vopc=4;
         $vsol         = $_GET['vsol'];
         $fecha_evento = $_POST['fecha_evento'];
         $smarty->assign('fecha_evento',$fecha_evento);
         $resultado  = pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='M'");
         $reg  = pg_fetch_array($resultado);
         $vder = $reg[nro_derecho];
         if (empty($accion)) { $accion=0; }
         
         pg_exec("BEGIN WORK");
         pg_exec("LOCK TABLE stmtmprec IN SHARE ROW EXCLUSIVE MODE");
         pg_exec("DELETE FROM stmtmprec WHERE nro_derecho='$vder' AND clase_nac='$accion'");
         pg_exec("COMMIT WORK"); 
      }
      
      if ($vopc==5 && $accion=="Incluir") {
        $vopc=4;
        $vsol         = $_GET['vsol'];
        $fecha_evento = $_POST['fecha_evento'];
        $smarty->assign('fecha_evento',$fecha_evento);
        $resultado  = pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='M'");
        $reg  = pg_fetch_array($resultado);
        $vder = $reg[nro_derecho];
	     $insert_valores ="'$vder','$vccv','$vprodu'";
	     if ($vccv>0) {
	         pg_exec("BEGIN WORK");
            pg_exec("LOCK TABLE stmtmprec IN SHARE ROW EXCLUSIVE MODE");
            pg_exec("DELETE FROM stmtmprec WHERE nro_derecho='$vder' AND clase_nac='$vccv'");
            $sql->insert("stmtmprec","","$insert_valores","");
            pg_exec("COMMIT WORK"); } 
	   }

      // Mostrar Codigos de Clases Nacional(es) de la Solicitud
      $resulpoh=pg_exec("SELECT * FROM stmtmprec WHERE nro_derecho='$vder' order by clase_nac");
      $regpoh = pg_fetch_array($resulpoh);
      $filaspoh=pg_numrows($resulpoh);
      for($cont=0;$cont<$filaspoh;$cont++) { 
         $vpoderhab1[$cont]=$regpoh[clase_nac];
         if (strlen(trim($regpoh[productos])) > 60) {
           $vpoderhab2[$cont] = substr(trim($regpoh[productos]),0,60)."..."; }
         else {
           $vpoderhab2[$cont] = substr(trim($regpoh[productos]),0,60); }
         $regpoh = pg_fetch_array($resulpoh);
      }
      $smarty->assign('arr_ph1',$vpoderhab1); 
      $smarty->assign('arr_ph2',$vpoderhab2);
      $smarty->assign('vnumrows',$filaspoh);
      $smarty->assign('vcodage',$vcodage); 
      $smarty->assign('vnomage',$vnomage); 
      $smarty->assign('codage',0); 
   }

   // Guardado definitivo   
   if ($vopc==5 && $accion=='Guardar') {
     $vsol         = $_GET['vsol'];
     $vder         = $_POST['vder'];
     $vexist       = $_POST['vexist'];
     $fecha_evento = $_POST['fecha_evento'];     
     $fecha_solic  = $_POST['vfecsol'];     

     if (empty($fecha_evento)) {
       Mensajenew('La Fecha del Escrito o evento esta vacia ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); exit(); }

     $fechahoy = hoy();
     $fechaeve = Convertir_en_fecha($fecha_evento,0);
     //$solfecha = Convertir_en_fecha($fecha_solic,0);

     //$esmayor=compara_fechas($fechaeve,$fechahoy);
     $esmayor=compara_fechas($fecha_evento,$fechahoy);
     if ($esmayor==1) {
       mensajenew('NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); exit();  } 
     //$esmayor=compara_fechas($solfecha,$fechaeve);
     $esmayor=compara_fechas($fecha_solic,$fechaeve);
     if ($esmayor==1) {
       mensajenew('NO se puede ejecutar un evento previo a la Fecha de la Solicitud ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); exit();    } 
        
     $evento = 1218;
     $resultado   = pg_exec("SELECT * FROM $tbname_4 WHERE evento='$evento'");
     $filas_found = pg_numrows($resultado); 
     $regeve      = pg_fetch_array($resultado);
     $evendesc    = trim($regeve['descripcion']);
     $tipo_evento = $regeve['tipo_evento'];
     $mensa_automatico=trim($regeve['mensa_automatico']);
     $documento=0;

     $fechahoy = hoy();
     $horactual= hora();     
     $reclasi  = "Solicita reclasificacion en Clase(s) Nacional(es): ";
     $resultmp = pg_exec("SELECT * FROM stmtmprec WHERE nro_derecho='$vder'");
     // Elimina todos los registros existentes para luego actualizarlos
     $regtmp = pg_fetch_array($resultmp);
     $filtmp = pg_numrows($resultmp);
     
     if ($filtmp==0) {
       mensajenew('NO seleccionó ninguna Clase Nacional ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); exit(); }
     else {
       $valclas = 0;
       $insclas = true;     
       pg_exec("BEGIN WORK");
       pg_exec("LOCK TABLE $tbname_5 IN SHARE ROW EXCLUSIVE MODE");
       $sql->del("$tbname_5","nro_derecho='$vder'");
       for ($cont=0;$cont<$filtmp;$cont++) {
         $vclnac=$regtmp[clase_nac]; 
         $vprodu=$regtmp[productos];
         $reclasi = $reclasi.$vclnac.", ";
         $insert_valores="'$vder','$vclnac','$vprodu','N'";	 
         $insclas = $sql->insert("$tbname_5","","$insert_valores","");
         if ($insclas) { 
           $valclas = $valclas + 0; }
         else { 
           $valclas = $valclas + 1; }
         $regtmp = pg_fetch_array($resultmp);
       }
       $deltmp = $sql->del("stmtmprec","nro_derecho='$vder'");

       $vest = $vest+1000;
       $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
       $insert_str = "'$vder','$evento','$fecha_evento',nextval('stzevtrd_secuencial_seq'),'$vest','$documento','$fechahoy','$usuario','$mensa_automatico','$reclasi','$horactual'";
       $instra = $sql->insert("$tbname_7","$col_campos","$insert_str",""); 
     
       if ($instra AND $deltmp AND $valclas==0) {
         pg_exec("COMMIT WORK");  }
       else {
         if (!$instra)    { $error_tramite= " - Tramite "; }
         if ($valclas!=0) { $error_datcla = " - Clase Nacional "; } 

         Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_tramite $error_datcla ...!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit();    
         pg_exec("ROLLBACK WORK"); }

     }
     
     //Desconexion de la Base de Datos
     $sql->disconnect();
      
     // Mensaje final
     mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_reclaintnac.php','S');
     $smarty->display('pie_pag.tpl'); exit(); 
   }

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro No.:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo5','Clase:');
$smarty->assign('campo6','Nombre:');
$smarty->assign('campo7','Estatus:');
$smarty->assign('campo8','Fecha Registro:');
$smarty->assign('campo9','Fecha Vencimiento:');
$smarty->assign('campo10','Agente/Tramitante:');
$smarty->assign('campo11','Titular:');
$smarty->assign('campo12','Pais:');
$smarty->assign('campo13','Fecha del Evento:');
$smarty->assign('campo14','Cod. Viena:');
$smarty->assign('campo15','Distingue:');
$smarty->assign('lcpoder','Clase Nacional:'); 
$smarty->assign('lnpoder','Productos:'); 

$smarty->assign('vder',$vder);  
$smarty->assign('vopc',$vopc); 
$smarty->assign('vsol1',$vsol1); 
$smarty->assign('vsol2',$vsol2); 
$smarty->assign('vsol',$vsol);
$smarty->assign('vreg1',$vreg1);
$smarty->assign('vreg2',$vreg2);
$smarty->assign('vreg',$vreg);
$smarty->assign('vfec',$vfec);
$smarty->assign('nombre',$vnom); 
$smarty->assign('vest',$vest); 
$smarty->assign('vdesest',$vdesest); 
$smarty->assign('vfecsol',$vfecsol); 
$smarty->assign('vfecreg',$vfecreg); 
$smarty->assign('vfecven',$vfecven); 
$smarty->assign('arraycodest',$arraycodest);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('modal_id',$modal_id);
$smarty->assign('modal',$modal);
$smarty->assign('vtip',$vtip);
$smarty->assign('vtipo',$vtipo);
$smarty->assign('vclase',$vclase);
$smarty->assign('vindcla',$vindcla);
$smarty->assign('vindc',$vindc);
$smarty->assign('vtra',$vtra);
$smarty->assign('vcodtit',$vcodtit);
$smarty->assign('vnomtit',$vnomtit);
$smarty->assign('vnactit',$vnactit);
$smarty->assign('vnadtit',$vnadtit);
$smarty->assign('vdomtit',$vdomtit);
$smarty->assign('distingue',$distingue);
$smarty->assign('fecha_evento',$fecha_evento);
$smarty->assign('vmodo','readonly=readonly'); 
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('usuario',$usuario);

$smarty->display('m_reclaintnac.tpl');
$smarty->display('pie_pag.tpl');
?>