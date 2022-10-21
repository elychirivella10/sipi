<?php
// *************************************************************************************
// Programa: m_actelev3.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// *************************************************************************************

ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$sql   = new mod_db();
$tbname_1 = "stzderec";
$tbname_2 = "stmmarce";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzottid";
$tbname_5 = "stzsolic";
$tbname_6 = "stzevder";

$login = $_SESSION['usuario_login'];
$fecha = fechahoy();

//Verificando conexion
$sql->connection($login);

//Validacion de Entrada
$vder=$_POST["vder"];
$anno=$_POST["anno"];
$numero=$_POST["numero"];
$fecha_solic=$_POST["fecha_solic"];
$tipo_marca=$_POST["tipo_marca"];
$modalidad=$_POST["modalidad"];
$nombre=$_POST["nombre"];
$clase=$_POST["clase"];
$ind_claseni=$_POST["ind_claseni"];
$registro=$_POST['registro'];
$estatus=$_POST["estatus"];
$descripcion=$_POST["descripcion"];
$fecha_venci=$_POST["fecha_venci"];
$fecha_regis=$_POST["fecha_regis"];
$fecha_publi=$_POST["fecha_publi"];
$tramitante=$_POST["tramitante"];
$poder=$_POST["poder"];
$agente=$_POST["agente"];

//$evento=$_POST["evento"];
//$esta_ant=$_POST["esta_ant"];
//$fecha_event=$_POST["fecha_event"];
//$fecha_venc=$_POST["fecha_venc"];
//$fecha_trans=$_POST["fecha_trans"];
//$documento=$_POST["documento"];
//$comentario=$_POST["comentario"];
//$usuario=$_POST['usuario'];
//$secuencial=$_POST['secuencial'];
$botonname=$_POST['botonname'];
//$titular=$_POST['titular'];
//$tnombre=$_POST['tnombre'];
//$tdomicilio=$_POST['tdomicilio'];
//$input2=$_POST['input2'];
$solicitud = $anno."-".$numero;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Eventos Cargados');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$actderec = true;
$actmarca = true;
$instram  = true;
$acttram  = true;
$deltram  = true;
$delnega  = true;
$deldevo  = true;
$delreno  = true;  

$botonname="Corregir";
//echo "valores= $estatus, $botonname, $vder, $solicitud ";
//exit();

if ($botonname=="Guardar") { }

$botonname="Corregir";
if ($botonname=="Corregir") {
      pg_exec("BEGIN WORK");

      $deltram = true;
      $actprim = true;
      $instram = true;
      $insexam = true; 
      $insdete = true;
      
      if ($estatus==104) {
        $vestfin = 1002;
        $evento  = "1021";
        // Obtencion de la Descripcion del Evento de Publicacion en Prensa 
        $nombeven='';
        $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE evento ='$evento'");
        $obj_filas = $sql->nums('',$obj_query);
        if ($obj_filas!=0) {
          $objs = $sql->objects('',$obj_query);
          $nombeven = trim($objs->mensa_automatico); }

        // Obtencion del Evento Cargado por el usuario abogado 
        $obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE evento ='1054' and nro_derecho='$vder'");
        $obj_filas = $sql->nums('',$obj_query);
        if ($obj_filas!=0) {
          $objs = $sql->objects('',$obj_query);
          $fevento3 = trim($objs->fecha_event);
          $fecha_carga = trim($objs->fecha_trans);
          $usuario1 = trim($objs->usuario);
          $hora_carga = trim($objs->hora);
          $comenta2 = trim($objs->comentario);
          $estatusant = $objs->estat_ant;
        }

        //echo " if= $usuario1, $vder, $fecha_carga, $nombeven ";
        //exit();  
      
        // Actualizar Maestra principal e insertar en Tramite 
        $update_str="estatus='$vestfin'";
        $actprim = $sql->update("stzderec","$update_str","nro_derecho='$vder'");     
            
        $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
        $insert_valores ="'$vder',$evento,'$fevento3',nextval('stzevtrd_secuencial_seq'),'$estatusant',0,'$fecha_carga','$usuario1','$nombeven','$hora_carga'";
        $instram = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 

        $insert_campos="nro_derecho,solicitud,evento,fecha_trans,hora,usuario";
        $insert_valores ="'$vder','$solicitud','1054','$fecha_carga','$hora_carga','$usuario1'";
        $insexam = $sql->insert("stmforfon","$insert_campos","$insert_valores","");	 

        $insert_campos="nro_derecho,solicitud,evento,fecha_trans,hora,usuario,comentario";
        $insert_valores ="'$vder','$solicitud','1054','$fecha_carga','$hora_carga','$usuario1','$comenta2'";
        $insdete = $sql->insert("stmdtforfon","$insert_campos","$insert_valores","");
        
        $deltram = $sql->del("$tbname_3","nro_derecho='$vder' AND evento='1054' AND usuario = '$usuario1'");
      }  	 

      // Verificacion y actualizacion real de los Datos en BD 
      if ($actprim AND $instram AND $insexam AND $insdete AND $deltram) {
        pg_exec("COMMIT WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();
   
        Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","m_reversarfondo.php",'S');
        $smarty->display('pie_pag.tpl'); exit();
      }
      else {
        pg_exec("ROLLBACK WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();

        if (!$actprim) { $error_pri  = " - Maestra Principal"; } 
        if (!$instram) { $error_tra  = " - Tr&aacute;mite "; }
        Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_pri $error_tra  ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();
      }
}

if ($botonname=="Eliminar") { }

//$actsoli = true;
//$acttitu = true;
//Actualizar Titular
//$update_str = "nombre='$tnombre'"; 
//$actsoli = $sql->update("$tbname_6","$update_str","titular='$titular'");
//$update_str = "nacionalidad='$input2',domicilio='$tdomicilio'";
//$acttitu = $sql->update("$tbname_5","$update_str","titular='$titular' and nro_derecho='$vder'");

//if ($actderec AND $actmarca AND $instram AND $acttram AND $delreno AND
//    $deltram AND $delnega AND $deldevo AND $actsoli AND $acttitu) {
//   pg_exec("COMMIT WORK");
//   //Desconexion de la Base de Datos
//   $sql->disconnect();
   
//   Mensajenew('DATOS ACTUALIZADOS Y/O ELIMINADOS CORRECTAMENTE!!!','m_actelev.php','S');
//   $smarty->display('pie_pag.tpl'); exit();
//}
//else {
//   pg_exec("ROLLBACK WORK");
//   //Desconexion de la Base de Datos
//   $sql->disconnect();

   //if (!$actderec) { $error_der  = " - Maestra de Derecho "; }
//   if (!$actmarca) { $error_mar  = " - Maestra de Marcas "; }
//   if (!$instram)  { $error_tra  = " - Tr&aacute;mite "; }
//   if (!$acttram)  { $error_tra  = " - Tr&aacute;mite "; }
//   if (!$deltram)  { $error_tra  = " - Tr&aacute;mite "; }
//   if (!$delnega)  { $error_neg  = " - Literales de Negaci&oacute;n "; }
//   if (!$deldevo)  { $error_dev  = " - Causales de Devoluci&oacute;n "; }
//   if (!$actsoli)  { $error_sol  = " - Maestra de Solicitantes "; }
//   if (!$acttitu)  { $error_tit  = " - Detalles del Solicitante "; }
//   if (!$delreno)  { $error_tit  = " - Detalles del Solicitante "; }

//   Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_der $error_mar $error_tra $error_neg $error_dev $error_sol $error_tit ...!!!","javascript:history.back();","N"); 
//   $smarty->display('pie_pag.tpl'); exit();
//}

?>
