<?php
// *************************************************************************************
// Programa: z_canxnu600.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// creado: 2020 I Semestre 1 de Febrero 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha    = fechahoy();

//Variable
$sql = new mod_db();
$tbname_1 = "stmmarce";
$tbname_2 = "stzevder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzderec";

$resultado = false;
//$boletin = 600;

$vopc    = $_GET['vopc'];
$boletin = trim($_POST['boletin']);
$tipbol  = "O";

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Boletin Ordinario $boletin : Cancelaciones por NO Uso Notificadas/por Notificar: Normales/Ratificadas/NO Ratificacion');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
	
  if (empty($boletin)) {
    mensajenew('ERROR: NO indic&oacute; el Bolet&iacute;n a Generar ...!!!','z_cancelacion600.php','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //if ($boletin!=1) {
  //  mensajenew("ERROR: Bolet&iacute;n NO Corresponde a este Extraordinario a Generar ...!!!","z_cancelacion600.php","N");
  //  $smarty->display('pie_pag.tpl'); exit();           
  //}
	
  $obj_query = $sql->query("SELECT max(nro_boletin) FROM stzboletin WHERE generado='S' AND tipo_boletin='O'");
  $objs = $sql->objects('',$obj_query);
  $vbolult = $objs->max;
  if ($boletin<=$vbolult) {
    mensajenew("ERROR: Bolet&iacute;n '$boletin' ya Generado anteriormente ...!!!","z_cancelacion600.php","N");
    $smarty->display('pie_pag.tpl'); exit();           
  }
		
  //echo "paso ... "; exit();
  //Recursos y Acciones de Marcas
  $counter= 3;
  $estatus = 1831;
  $filas_total = 0;
  while ( $counter <= 3) {

    if($counter==1)  { 

    //$lcWhere = " WHERE a.tipo_mp='M' AND a.estatus='$estatus' AND (a.nro_derecho=b.nro_derecho) AND (a.nro_derecho=c.nro_derecho) AND c.evento = 1301 AND a.nro_derecho NOT IN (SELECT nro_derecho FROM stzevtrd WHERE evento = 1196)";

    $condicion = "SELECT DISTINCT a.registro,a.nro_derecho,a.solicitud,a.estatus FROM stzderec a, stmmarce b, stzevtrd c";
    $lcWhere = " WHERE a.tipo_mp='M' AND a.estatus='$estatus' AND (a.nro_derecho=b.nro_derecho) AND (a.nro_derecho=c.nro_derecho) AND c.evento = 1301 AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento = 1196)";
    $lcOrder = " ORDER BY 3";

    //La Fecha de Hoy para la transaccion
    $fechahoy = hoy();
    $comentario = "";

    //Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $resultado=pg_exec("$condicion$lcWhere$lcOrder");
    $filas_found=pg_numrows($resultado); 
    //echo "$filas_found ";
    if ($filas_found!=0) {
      $numerror = 0;
      $documento= 0;
      $comentario="";
      $horahoy  = hora();
      $evento  = 1196;

      $regsol = pg_fetch_array($resultado);
      $filas_total =  $filas_total + $filas_found;
      for($cont=0;$cont<$filas_found;$cont++) 
      {
        $ins_tram = true;
        $act_dere = true;
        $horactual= hora();
        $vsol = trim($regsol['solicitud']);
        $vreg = trim($regsol['registro']);
        $vder = trim($regsol['nro_derecho']); 
        //echo "$condicion$lcWhere$lcOrder DERECHO= $vder, $vsol, $vreg "; 
        //exit();

        //Verificacion si ya fue cargado o no el evento de perimida por publicar
        $obj_queryver = $sql->query("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento='$evento'");
        $evento_found=$sql->nums('',$obj_queryver);
        if ($evento_found!=0) {
 
          //Inserto Datos en Tabla Temporal del Boletin
          $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                          fecha_carga,hora_carga,nanota,tipo_boletin";
          $insert_valores ="$vder,'$vsol','$vreg',$boletin,$estatus,'M','$usuario','$fechahoy','$horahoy',0,'$tipbol'";
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' and 
                               boletin='$boletin' and estatus='$estatus' and tipo='M'");
          $cantfound = pg_numrows($resulfound);
          if ($cantfound==0) {
              $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
              if (!$vertra) { $numerror = $numerror + 1; }
          }
 
        } 
        $regsol = pg_fetch_array($resultado);
      }
    }
    } //Fin counter 1
    
    if($counter==2)  { 

    //$lcWhere = " WHERE a.tipo_mp='M' AND a.estatus='$estatus' AND (a.nro_derecho=b.nro_derecho) AND (a.nro_derecho=c.nro_derecho) AND c.evento = 1301 AND a.nro_derecho NOT IN (SELECT nro_derecho FROM stzevtrd WHERE evento = 1196)";

    $condicion = "SELECT DISTINCT a.registro,a.nro_derecho,a.solicitud,a.estatus FROM stzderec a, stmmarce b, stzevtrd c";
    $lcWhere = " WHERE a.tipo_mp='M' AND a.estatus='$estatus' AND (a.nro_derecho=b.nro_derecho) AND (a.nro_derecho=c.nro_derecho) AND c.evento = 1301 AND (c.fecha_event>='15/01/2019' AND c.fecha_event<='31/01/2020') AND a.nro_derecho NOT IN (SELECT nro_derecho FROM stzevtrd WHERE evento = 1195)";
    $lcOrder = " ORDER BY 3";

    //La Fecha de Hoy para la transaccion
    $fechahoy = hoy();
    $comentario = "";

    //Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $resultado=pg_exec("$condicion$lcWhere$lcOrder");
    $filas_found=pg_numrows($resultado); 
    //echo "$filas_found "; exit();
    
    if ($filas_found!=0) {
      $numerror = 0;
      $documento= 0;
      $comentario="";
      $horahoy  = hora();
      $evento  = 1195;
      $boletin_tmp = 1600;
      
      $regsol = pg_fetch_array($resultado);
      $filas_total =  $filas_total + $filas_found;
      for($cont=0;$cont<$filas_found;$cont++) 
      {
        $ins_tram = true;
        $act_dere = true;
        $horactual= hora();
        $vsol = trim($regsol['solicitud']);
        $vreg = trim($regsol['registro']);
        $vder = trim($regsol['nro_derecho']); 
        //echo "$condicion$lcWhere$lcOrder DERECHO= $vder, $vsol, $vreg "; 
        //exit();

        //Verificacion si ya fue cargado o no el evento de perimida por publicar
        $obj_queryver = $sql->query("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento='$evento'");
        $evento_found=$sql->nums('',$obj_queryver);
        if ($evento_found==0) {
 
          //Inserto Datos en Tabla Temporal del Boletin
          $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                          fecha_carga,hora_carga,nanota,tipo_boletin";
          $insert_valores ="$vder,'$vsol','$vreg',$boletin_tmp,$estatus,'M','$usuario','$fechahoy','$horahoy',0,'$tipbol'";
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' and 
                               boletin='$boletin' and estatus='$estatus' and tipo='M'");
          $cantfound = pg_numrows($resulfound);
          if ($cantfound==0) {
              $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
              if (!$vertra) { $numerror = $numerror + 1; }
          }
 
        } 
        $regsol = pg_fetch_array($resultado);
      }
    }
    } //Fin counter 2

    if($counter==3)  { 

    $condicion = "SELECT DISTINCT a.registro,a.nro_derecho,a.solicitud,a.estatus FROM stzderec a, stmmarce b, stzevtrd c";
    $lcWhere = " WHERE a.tipo_mp='M' AND a.estatus='$estatus' AND (a.nro_derecho=b.nro_derecho) AND (a.nro_derecho=c.nro_derecho) AND c.evento = 1301 AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento = 1196)";
    $lcOrder = " ORDER BY 3";

    //La Fecha de Hoy para la transaccion
    $fechahoy = hoy();
    $comentario = "";

    //Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $resultado=pg_exec("$condicion$lcWhere$lcOrder");
    $filas_found=pg_numrows($resultado); 
    //echo "$filas_found "; exit();
    
    if ($filas_found!=0) {
      $numerror = 0;
      $documento= 0;
      $comentario="";
      $horahoy  = hora();
      $evento  = 1196;
      
      $regsol = pg_fetch_array($resultado);
      $filas_total =  $filas_total + $filas_found;
      for($cont=0;$cont<$filas_found;$cont++) 
      {
        $ins_tram = true;
        $act_dere = true;
        $horactual= hora();
        $vsol = trim($regsol['solicitud']);
        $vreg = trim($regsol['registro']);
        $vder = trim($regsol['nro_derecho']); 
        //echo "$condicion$lcWhere$lcOrder $filas_found DERECHO= $vder, $vsol, $vreg "; 
        //exit();

        //Verificacion si ya fue cargado o no el evento de perimida por publicar
        $obj_queryver = $sql->query("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento='$evento'");
        $evento_found=$sql->nums('',$obj_queryver);
        if ($evento_found!=0) {
 
          //Inserto Datos en Tabla Temporal del Boletin
          $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                          fecha_carga,hora_carga,nanota,tipo_boletin";
          $insert_valores ="$vder,'$vsol','$vreg',$boletin,$estatus,'M','$usuario','$fechahoy','$horahoy',0,'$tipbol'";
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' and 
                               boletin='$boletin' and estatus='$estatus' and tipo='M'");
          $cantfound = pg_numrows($resulfound);
          if ($cantfound==0) {
              $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
              if (!$vertra) { $numerror = $numerror + 1; }
          }
 
        } 
        $regsol = pg_fetch_array($resultado);
      }
    }
    } //Fin counter 3
    
    $counter = $counter + 1; 
    //if($counter==2)  { $estatus = 1801; $evento  = 1865; }
    //if($counter==3)  { $estatus = 1802; $evento  = 1865; }
    //if($counter==4)  { $estatus = 1803; $evento  = 1865; }

  }//fin del while Recursos y Acciones de Marcas

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_total' SOLICITUDES GENERADAS CORRECTAMENTE  ...!!!","z_cancelacion600.php","S");
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
