<? 
// *************************************************************************************
// Programa: m_actrenbol.php 
// Realizado por el Analista de Sistema: Ing. Romulo Mendoza PIII 
// Direccion de Sistemas / SAPI / MPPCN
// Año: 2021 I Semestre 
// *************************************************************************************
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$hora    = hora();
$vopc    = $_GET['vopc'];
$vbol    = $_POST['vbol'];
$vfbol   = $_POST['vfbol'];
$vhoy    = hoy();
$modulo  = 'm_actrenbol.php';

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Actualizaci&oacute;n de Fechas Renovaciones Publicadas en Bolet&iacute;n'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
$smarty->display('encabezado1.tpl');
      
   if ($vopc==2) {
            
      if ($vbol=='') {
         mensajenew('ERROR: DATOS INCORRECTOS O VACIOS','m_actrenbol.php','N');
         $smarty->display('pie_pag.tpl'); exit();
      }

      //Conexion a la BD
      $sql = new mod_db();
      $sql->connection($usuario);   

      //Verificacion de Boletin
      $obj_query = $sql->query("SELECT * FROM stzboletin WHERE nro_boletin=$vbol");
      $bol_found=$sql->nums('',$obj_query);
      if ($bol_found==0) {
        mensajenew("ERROR: Bolet&iacute;n '$vbol' NO Existe o NO Generado ...!!!","m_actrenbol.php","N");
        $smarty->display('pie_pag.tpl'); exit();           
      }
      $objs = $sql->objects('',$obj_query);
      $vfbol = $objs->fecha_pub;

      //Registros Renovados y publicados
      $resulv=pg_exec("SELECT * FROM stzmargi WHERE tipo_tramite='R' AND boletin='$vbol' and tipo_mp='M'");
      $cantren = pg_numrows($resulv);
      if ($cantren <= 0) {
        $sql->disconnect();
        mensajenew('ERROR: PROBLEMA AL INTENTAR PROCESAR - No existen Datos para Actualizar','m_actrenbol.php','N');
        $smarty->display('pie_pag.tpl'); exit(); 
      }
      
      //Actualizacion en tablas maestras
      $codeve=1862;
      $can_error=0;

      //descripcion del evento 
      $resultev=pg_exec("SELECT * FROM stzevder WHERE evento='$codeve' and tipo_mp='M'");
      $regtev = pg_fetch_array($resultev);
      $deseve=$regtev['mensa_automatico'];

      pg_exec("BEGIN WORK");
      $regv = pg_fetch_array($resulv);
      //for ($cont=0;$cont<1;$cont++) {
      for ($cont=0;$cont<$cantren;$cont++) {

          $vder   = $regv['nro_derecho'];
          $vsol   = $regv['solicitud'];
	  $vdoc   = $regv['nro_docum'];
	  $fecven = $regv['vencimiento'];
	  $gestor = trim($regv['tramitante']);

          //Verificacion de si ya le fue cargado la publicacion de renovacion
          $obj_query2 = $sql->query("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento='$codeve' AND documento='$vbol'");
          if (!$obj_query2) { 
            mensajenew('ERROR: Problema al intentar realizar la consulta en la tabla stzevtrd ...!!!','m_actrenbol.php','N');
            $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
          $filas_862=$sql->nums('',$obj_query2);
          if ($filas_862==0) {
          
	    $vcomen = $deseve." ".$vbol.", con Fecha de Publicacion: ".$vfbol.". Tramitante: ".$gestor.". Documento Nro: ".$vdoc;
            $valido = true;
            $resest  = pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='M'");
            $regesta = pg_fetch_array($resest);
            $vestat  = $regesta['estatus'];

	    // Actualiza Vencimiento (Renovacion) en Stzderec
	    $update_str = "fecha_venc='$fecven'"; 
            $valido = $sql->update("stzderec","$update_str","nro_derecho='$vder' AND tipo_mp='M'");
            if (!$valido) {$can_error = $can_error + 1;} 

	    // Insertar en Stzevtrd
            $insert_campos ="nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,
                            documento,fecha_trans,usuario,desc_evento,comentario,hora";
            $insert_valores="'$vder',$codeve,'$vfbol',nextval('stzevtrd_secuencial_seq'),
                            $vestat,'$fecven',$vbol,'$vhoy','$usuario','$deseve','$vcomen','$hora'";
            $valido = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");
            if (!$valido) {$can_error = $can_error + 1;} 
            //echo "$vsol - $vcomen - $update_str - $insert_valores"; 

          }
          $regv = pg_fetch_array($resulv); 
      } 

      // Mensaje final 
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); 
           $sql->disconnect();
           mensajenew("AVISO: Se Actualizaron '$cantren' Solicitudes",'m_actrenbol.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); 
           $sql->disconnect();
           mensajenew("ERROR: Falla de Ingreso en la B.D. Transacciones Abortadas...!!!","javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();  
      }

 }      
      
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('varfocus','formarcas2.vbol'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('vfbol',$vfbol); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('lfechaevent','Fecha del Boletin:'); 
   $smarty ->assign('espacios',''); 

   $smarty ->display('m_actrenbol.tpl'); 
   $smarty->display('pie_pag.tpl');
?>

