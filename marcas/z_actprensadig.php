<?php
// *************************************************************************************
// Programa: z_actprensadig.php 
// Realizado por el Analista de Sistema Romulo Mendoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creacion I semestre 2015
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = $_SESSION['usuario_login'];
$role      = $_SESSION['usuario_rol'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();
$tbname_1  = "stmmarce";
$tbname_2  = "stzevder";
$tbname_3  = "stzstder";
$tbname_4  = "stzevtrd";
$tbname_5  = "stzmigrr";
$tbname_6  = "stmpagopren";
$tbname_7  = "stzderec";
$tbname_8  = "stppagopren";

//Validacion de Entrada
$vopc    = $_GET['vopc'];
$fecsold = $_POST["fecsold"];
$numejemplar = $_POST["ejemplar"];
//$fecsolh = $_POST["fecsolh"];
$tipo    = "Periodico Digital del SAPI"." No.:".$numejemplar;
$fechaper= $_POST["fecsold"];
$resultado=false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizaci&oacute;n de Solicitudes Publicadas en Prensa Digital');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('modo2','readonly');

$fec_hoy = hoy();
$rev_fecha = Convertir_en_fecha($fechaper,0);
$esmayor=compara_fechas($rev_fecha,$fec_hoy);
if ($esmayor==1) {
  $smarty->display('encabezado1.tpl');
  mensajenew('ERROR: NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit();  } 

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecsold");
  $valores = array($fecsold);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("ERROR: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

 if ($vopc==2) {
   //Nombre de la Imagen de Prensa 
   $dia = substr($fechaper, 0, 2);
   $mes = substr($fechaper, 3, 2);
   $ano = substr($fechaper, 6, 4);
   $fecha = $dia.$mes.$ano;
            
   $vnewnombre= $tipo."_".$fecha;
   $where = "";
   //Verificacion del rango de fechas
   if(!empty($fecsold)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stmpagopren.fecha_publi = '$fecsold') ";
	}
	else { 
	   $where = $where." (stmpagopren.fecha_publi = '$fecsold') ";
  	}
   }

   $where = $where." and stzderec.nro_derecho=stmpagopren.nro_derecho";
   $where = $where." and stzderec.tipo_mp='M'";
   $where = $where." and stmpagopren.publicada='S'";
   $where = $where." and (stmpagopren.estatus='G' or stmpagopren.estatus='P')";
   //$where = $where." and stmpagopren.hora_carga <='03:30:00 PM'";

   //Verificando conexion
   $sql->connection($usuario);

   //Publicaciones en Prensa Marcas
   // Armando el query Marcas
   $resultado=pg_exec("SELECT stmpagopren.factura,stmpagopren.fecha_fac,stmpagopren.solicitud,stzderec.nro_derecho,stzderec.tipo_derecho,stzderec.estatus,stmpagopren.hora_carga,stmpagopren.fecha_publi
   FROM  stzderec, stmpagopren 
   WHERE $where ORDER BY 1"); 

   //echo "SELECT stmpagopren.factura,stmpagopren.fecha_fac,stmpagopren.solicitud,stzderec.nro_derecho,stzderec.tipo_derecho,stzderec.estatus,stmpagopren.hora_carga,stmpagopren.fecha_publi
   //FROM  stzderec, stmpagopren 
   //WHERE $where ORDER BY 1";

   //verificando los resultados
   //if (!$resultado)    { 
   //  mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','z_actualprensa.php','N');
   //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   $filas_foundm=0;
 
   //if ($filas_foundm==0)    {
   //  mensajenew('ERROR: No existen Datos Asociados ...!!!','z_actualprensa.php','N');
   //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

   //busqueda de evento 22
   $resul=pg_exec("SELECT * FROM $tbname_2 WHERE evento='1022'");
   $filas_f = pg_numrows($resul); 
   $regeve  = pg_fetch_array($resul);
   $mensa_automatico=trim($regeve['mensa_automatico']);

   $filas_found=pg_numrows($resultado);    
   $filas_foundm=$filas_found;              //echo "mar total=$filas_found "; exit();      
   $errorgrabar = 0;
   //$comentario=$tipo.' Fecha: '.$fechaper; 
   for ($cont=0;$cont<$filas_found;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $horactual=hora();
       $instram = true;
       $actestat = true;
       $actprensa = true;
       $vder = $reg['nro_derecho'];
       $factura  = $reg['factura'];
       $fechafac = $reg['fecha_fac'];
       $comentario=$tipo.' de Fecha: '.$fechaper; 
       //$comentario = $comentario.' segun Factura No.: '.$factura.' de Fecha: '.$fechafac;
       $comentario = $comentario.' segun T/No.: '.$factura;

       $res_der=pg_exec("SELECT tipo_derecho,estatus FROM $tbname_7 WHERE nro_derecho='$vder'");
       $resder = pg_fetch_array($res_der);
       $vest = $resder['estatus'];

       if ($vest==1004) { //Esta bien 
         //Inserto Datos en la tabla de Tramite stzevtrd
         $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
         $insert_str = "$vder,1022,'$fechaper',nextval('stzevtrd_secuencial_seq'),1004,'$fechahoy','$usuario','$mensa_automatico',0,'$comentario','$horactual'";
         $instram = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 
          
         //Actualizo la maestra en estatus a 5
         $update_str = "estatus=1005";
         $actestat = $sql->update("$tbname_7","$update_str","nro_derecho=$vder");

         //Actualizo la tabla de pagos de marcas
         $update_str = "estatus='P',publicada='S'";
         $actprensa = $sql->update("$tbname_6","$update_str","nro_derecho=$vder");
       }
       
       if ($instram AND $actestat AND $actprensa) { }
       else {
         $errorgrabar = $errorgrabar+1; }
   }  

   $where = "";
   //Verificacion del rango de fechas
   if(!empty($fecsold)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stppagopren.fecha_publi = '$fecsold') ";
	}
	else { 
	   $where = $where." (stppagopren.fecha_publi = '$fecsold') ";
  	}
   }

   $where = $where." and stzderec.nro_derecho=stppagopren.nro_derecho";
   $where = $where." and stzderec.tipo_mp='P'";
   $where = $where." and stppagopren.publicada='S'";
   $where = $where." and stppagopren.estatus='G'";
   //$where = $where." and stppagopren.hora_carga <='03:30:00 PM'";

   //Publicaciones en Prensa Patentes
   // Armando el query Pateentes
   $resultado=pg_exec("SELECT stppagopren.factura,stppagopren.fecha_fac,stppagopren.solicitud,stzderec.nro_derecho,stzderec.tipo_derecho,stzderec.estatus,stppagopren.hora_carga,stppagopren.fecha_publi,stppagopren.nro_publica
   FROM  stzderec, stppagopren 
   WHERE $where ORDER BY 3"); 


   $query = "SELECT stppagopren.factura,stppagopren.fecha_fac,stppagopren.solicitud,stzderec.nro_derecho,stzderec.tipo_derecho,stzderec.estatus,stppagopren.hora_carga,stppagopren.fecha_publi,stppagopren.nro_publica
   FROM  stzderec, stppagopren 
   WHERE $where ORDER BY 3";

   //echo "$query";
   //verificando los resultados
   //if (!$resultado)    { 
   //  mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','z_actualprensa.php','N');
   //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   $filas_foundp=0;
 
   //if ($filas_foundp==0)    {
   //  mensajenew('ERROR: No existen Datos Asociados ...!!!','z_actualprensa.php','N');
   //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

   //busqueda de evento 22
   $resul=pg_exec("SELECT * FROM $tbname_2 WHERE evento='2022'");
   $filas_f = pg_numrows($resul); 
   $regeve  = pg_fetch_array($resul);
   $mensa_autom22=trim($regeve['mensa_automatico']);

   //busqueda de evento 23
   $resul=pg_exec("SELECT * FROM $tbname_2 WHERE evento='2023'");
   $filas_f = pg_numrows($resul); 
   $regeve  = pg_fetch_array($resul);
   $mensa_autom23=trim($regeve['mensa_automatico']);

   //busqueda de evento 31
   $resul=pg_exec("SELECT * FROM $tbname_2 WHERE evento='2031'");
   $filas_f = pg_numrows($resul); 
   $regeve  = pg_fetch_array($resul);
   $mensa_autom31=trim($regeve['mensa_automatico']);

   $filas_foundp=pg_numrows($resultado);    //echo "pat total=$filas_foundp";
   //$filas_foundp=$filas_found;                    
   //$errorgrabar = 0;
   for ($cont=0;$cont<$filas_foundp;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $horactual=hora();
       $instram = true;
       $actestat = true;
       $actprensa = true;
       $vder = $reg['nro_derecho'];
       $factura  = $reg['factura'];
       $fechafac = $reg['fecha_fac'];
       $vpub = $reg['nro_publica'];
       $comentario=$tipo.' de Fecha: '.$fechaper; 
       $comentario = $comentario.' segun Factura No.: '.$factura.' de Fecha: '.$fechafac;

       $res_der=pg_exec("SELECT tipo_derecho,estatus FROM $tbname_7 WHERE nro_derecho='$vder'");
       $resder = pg_fetch_array($res_der);
       $vest = $resder['estatus'];

       switch ($vpub) {
         case 1:
           if ($vest==2004) { //Esta bien 
             //Inserto Datos en la tabla de Tramite stzevtrd estatus 2004
             $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
             $insert_str = "$vder,2022,'$fechaper',nextval('stzevtrd_secuencial_seq'),2004,'$fechahoy','$usuario','$mensa_autom22',0,'$comentario','$horactual'";
             $instram = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 
          
             //Actualizo la maestra en estatus a 5
             $update_str = "estatus=2005";
             $actestat = $sql->update("$tbname_7","$update_str","nro_derecho=$vder");

             //Actualizo la tabla de pagos de marcas
             $update_str = "estatus='P',publicada='S'";
             $actprensa = $sql->update("$tbname_8","$update_str","nro_derecho=$vder AND nro_publica='1'");
           }
           break;
         case 2:
           if ($vest==2005) { //Esta bien 
             //Inserto Datos en la tabla de Tramite stzevtrd estatus 2005
             $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
             $insert_str = "$vder,2023,'$fechaper',nextval('stzevtrd_secuencial_seq'),2005,'$fechahoy','$usuario','$mensa_autom23',0,'$comentario','$horactual'";
             $instram = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 
          
             //Actualizo la maestra en estatus a 5
             $update_str = "estatus=2011";
             $actestat = $sql->update("$tbname_7","$update_str","nro_derecho=$vder");

             //Actualizo la tabla de pagos de marcas
             $update_str = "estatus='P',publicada='S'";
             $actprensa = $sql->update("$tbname_8","$update_str","nro_derecho=$vder AND nro_publica='2'");
           }
           break;
         case 3:
           if ($vest==2011) { //Esta bien 
             //Inserto Datos en la tabla de Tramite stzevtrd estatus 2011
             $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
             $insert_str = "$vder,2031,'$fechaper',nextval('stzevtrd_secuencial_seq'),2011,'$fechahoy','$usuario','$mensa_autom31',0,'$comentario','$horactual'";
             $instram = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 
          
             //Actualizo la maestra en estatus a 5
             $update_str = "estatus=2012";
             $actestat = $sql->update("$tbname_7","$update_str","nro_derecho=$vder");

             //Actualizo la tabla de pagos de marcas
             $update_str = "estatus='P',publicada='S'";
             $actprensa = $sql->update("$tbname_8","$update_str","nro_derecho=$vder AND nro_publica='3'");
           }
           break;
       }    

       if ($instram AND $actestat AND $actprensa) { }
       else {
         $errorgrabar = $errorgrabar+1; }
   }  

   $filastotal = $filas_foundm + $filas_foundp;

   if ($filastotal == 0) { 
    //Desconexion de la Base de Datos
    $sql->disconnect();
    Mensajenew('AVISO: NO SE ENCONTRARON DATOS QUE ACTUALIZAR !!!','z_actualprensa.php','S');
    $smarty->display('pie_pag.tpl'); exit();
   }  

   // Verificacion y actualizacion real de los Datos en BD 
   if ($errorgrabar == 0) { 
         pg_exec("COMMIT WORK");
         //Desconexion de la Base de Datos
         $sql->disconnect();
         Mensajenew('DATOS ACTUALIZADOS CORRECTAMENTE!!!','z_actualprensa.php','S');
         $smarty->display('pie_pag.tpl'); exit();
   }
   else {
        pg_exec("ROLLBACK WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();
        Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();
   }
    
 }

?>
