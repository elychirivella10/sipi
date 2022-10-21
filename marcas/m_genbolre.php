<?php
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login = $_SESSION['usuario_login'];
$fecha = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n de Anotaciones Marginales para el Bolet&iacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
$fecsold=$_POST["desdet"];
$fecsolh=$_POST["hastat"];
$vbol   =$_POST["boletin"];
$tipo   =$_POST["tipo"];

// Verificacion de que los campos requeridos esten llenos...
$req_fields = array("boletin","tipo");
$valores = array($vbol,$tipo);
$vacios = check_empty_fields();
if (!$vacios) { 
  $smarty->display('encabezado1.tpl');
  mensajenew("ERROR: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Boletin a Generar 
$obj_query = $sql->query("SELECT max(nro_boletin) FROM stzboletin");
$objs = $sql->objects('',$obj_query);
$vbolult = $objs->max;
if ($vbol<$vbolult) {
  $smarty->display('encabezado1.tpl');
  mensajenew("ERROR: Bolet&iacute;n '$vbol' ya Generado anteriormente ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit();           
}

$fechahoy= hoy();

//Devolucion de AM.  
if ($tipo=='DEVOLUCION ANOTACION MARGINAL') {
   $resul=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud, stzderec.registro, stzevtrd.documento, stzevtrd.comentario 
			FROM  stzderec, stzevtrd	
			WHERE stzevtrd.evento = '1502'   
			AND stzevtrd.fecha_trans >='$fecsold' AND stzevtrd.fecha_trans <='$fecsolh'
			AND tipo_mp='M'
			AND stzevtrd.nro_derecho = stzderec.nro_derecho 
         ORDER BY stzderec.registro ");		

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."ERROR: No existen Devoluciones de Anotaciones Marginales ...!!!"; }
	else {
    $traerr  = 0;
    $tipanota="V";
    $vtip    = 1564; 
    $horahoy = hora();
    $reg     = pg_fetch_array($resul); 
    for ($cont=0;$cont<$cantreg;$cont++) {
      $vder=$reg[nro_derecho];
      $vsol=$reg[solicitud];
      $vreg=$reg[registro];
      $vdoc=$reg[documento];
      $vtra=trim($reg[comentario]); 
      $tipanota = substr($vtra,0,1); 
      if ($tipanota=="O") { $tipanota="D"; }
      $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                      fecha_carga,hora_carga,nanota,tipo_anota,resolucion,documento";
      $insert_valores ="$vder,'$vsol','$vreg',$vbol,$vtip,'M','$login','$fechahoy','$horahoy',$vdoc,'$tipanota',0,$vdoc";
          
      //No grabar cuando la solicitud exista en el temporal
      $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' AND 
                           boletin='$vbol' AND estatus='$vtip' AND tipo='M' AND documento=$vdoc");
      $cantfound = pg_numrows($resulfound);
      if (($cantfound==0) AND ($vdoc!=0)) {
        $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
        if (!$vertra) {$traerr=$traerr+1;}
      }
      $reg = pg_fetch_array($resul); 
    }
  }  
}

//desistidas de AM. Renovaciones
if ($tipo=='DESISTIMIENTO RENOVACIONES') {
   $resul=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud, stzderec.registro 
			FROM  stzderec, stzevtrd	
			WHERE stzevtrd.evento = '1701'   
			AND stzevtrd.fecha_trans >='$fecsold' AND stzevtrd.fecha_trans <='$fecsolh'
			AND stzderec.estatus = '1555'
			AND tipo_mp='M'
			AND stzevtrd.nro_derecho = stzderec.nro_derecho 
         ORDER BY stzderec.registro ");		

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."ERROR: No existen Desistidas de Renovaciones ...!!!"; }
	else {
    $traerr  = 0;
    $tipanota="R";
    $vtip    = 1557; 
    $horahoy = hora();
    $reg     = pg_fetch_array($resul); 
    for ($cont=0;$cont<$cantreg;$cont++) {
      $vder=$reg[nro_derecho];
      $vsol=$reg[solicitud];
      $vreg=$reg[registro];
  
      $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                      fecha_carga,hora_carga,nanota,tipo_anota,resolucion";
      $insert_valores ="$vder,'$vsol','$vreg',$vbol,$vtip,'M','$login','$fechahoy','$horahoy',0,'$tipanota',0";
          
      //No grabar cuando la solicitud exista en el temporal
      $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' AND 
                           boletin='$vbol' AND estatus='$vtip' AND tipo='M'");
      $cantfound = pg_numrows($resulfound);
      if ($cantfound==0) {
        $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
        if (!$vertra) {$traerr=$traerr+1;}
      }
      $reg = pg_fetch_array($resul); 
    }
  }  
}

//desistidas de AM. Cambio de Nombre
if ($tipo=='DESISTIMIENTO CAMBIO DE NOMBRE') {
   $resul=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud, stzderec.registro
			FROM  stzderec, stzevtrd	
			WHERE stzevtrd.evento = '1705'   
			AND stzevtrd.fecha_trans >='$fecsold' AND stzevtrd.fecha_trans <='$fecsolh'
			AND stzderec.estatus = '1555'
			AND tipo_mp='M'
			AND stzevtrd.nro_derecho = stzderec.nro_derecho 
         ORDER BY stzderec.registro ");		

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."ERROR: No existen Desistidas de Cambio de Nombre ...!!!"; }
	else {
    $traerr  = 0;
    $tipanota="N";
    $vtip    = 1561; 
    $horahoy = hora();
    $reg     = pg_fetch_array($resul); 
    for ($cont=0;$cont<$cantreg;$cont++) {
      $vder=$reg[nro_derecho];
      $vsol=$reg[solicitud];
      $vreg=$reg[registro];
  
      $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                      fecha_carga,hora_carga,nanota,tipo_anota,resolucion";
      $insert_valores ="$vder,'$vsol','$vreg',$vbol,$vtip,'M','$login','$fechahoy','$horahoy',0,'$tipanota',0";
          
      //No grabar cuando la solicitud exista en el temporal
      $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' AND 
                           boletin='$vbol' AND estatus='$vtip' AND tipo='M'");
      $cantfound = pg_numrows($resulfound);
      if ($cantfound==0) {
        $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
        if (!$vertra) {$traerr=$traerr+1;}
      }
      $reg = pg_fetch_array($resul); 
    }
  }  
}

//desistidas de AM. Cambio de Domicilio
if ($tipo=='DESISTIMIENTO CAMBIO DE DOMICILIO') {
   $resul=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud, stzderec.registro
			FROM  stzderec, stzevtrd	
			WHERE stzevtrd.evento = '1706'   
			AND stzevtrd.fecha_trans >='$fecsold' AND stzevtrd.fecha_trans <='$fecsolh'
			AND stzderec.estatus = '1555'
			AND tipo_mp='M'
			AND stzevtrd.nro_derecho = stzderec.nro_derecho 
         ORDER BY stzderec.registro ");		

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."ERROR: No existen Desistidas de Cambio de Domicilio ...!!!"; }
	else {
    $traerr  = 0;
    $tipanota="D";
    $vtip    = 1562; 
    $horahoy = hora();
    $reg     = pg_fetch_array($resul); 
    for ($cont=0;$cont<$cantreg;$cont++) {
      $vder=$reg[nro_derecho];
      $vsol=$reg[solicitud];
      $vreg=$reg[registro];
  
      $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                      fecha_carga,hora_carga,nanota,tipo_anota,resolucion";
      $insert_valores ="$vder,'$vsol','$vreg',$vbol,$vtip,'M','$login','$fechahoy','$horahoy',0,'$tipanota',0";
          
      //No grabar cuando la solicitud exista en el temporal
      $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' AND 
                           boletin='$vbol' AND estatus='$vtip' AND tipo='M'");
      $cantfound = pg_numrows($resulfound);
      if ($cantfound==0) {
        $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
        if (!$vertra) {$traerr=$traerr+1;}
      }
      $reg = pg_fetch_array($resul); 
    }
  }  
}  

//desistidas de AM. Cesiones
if ($tipo=='DESISTIMIENTO CESIONES') {
   $resul=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud, stzderec.registro
			FROM  stzderec, stzevtrd	
			WHERE stzevtrd.evento = '1702'   
			AND stzevtrd.fecha_trans >='$fecsold' AND stzevtrd.fecha_trans <='$fecsolh'
			AND stzderec.estatus = '1555'
			AND tipo_mp='M'
			AND stzevtrd.nro_derecho = stzderec.nro_derecho 
         ORDER BY stzderec.registro ");		

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."ERROR: No existen Desistidas de Cesi&oacute;n ...!!!"; }
	else {
    $traerr  = 0;
    $tipanota="C";
    $vtip    = 1558; 
    $horahoy = hora();
    $reg     = pg_fetch_array($resul); 
    for ($cont=0;$cont<$cantreg;$cont++) {
      $vder=$reg[nro_derecho];
      $vsol=$reg[solicitud];
      $vreg=$reg[registro];
  
      $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                      fecha_carga,hora_carga,nanota,tipo_anota,resolucion";
      $insert_valores ="$vder,'$vsol','$vreg',$vbol,$vtip,'M','$login','$fechahoy','$horahoy',0,'$tipanota',0";
          
      //No grabar cuando la solicitud exista en el temporal
      $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' AND 
                           boletin='$vbol' AND estatus='$vtip' AND tipo='M'");
      $cantfound = pg_numrows($resulfound);
      if ($cantfound==0) {
        $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
        if (!$vertra) {$traerr=$traerr+1;}
      }
      $reg = pg_fetch_array($resul); 
    }
  }  
}  

//desistidas de AM. Fusiones
if ($tipo=='DESISTIMIENTO FUSIONES') {
   $resul=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud, stzderec.registro
			FROM  stzderec, stzevtrd	
			WHERE stzevtrd.evento = '1703'   
			AND stzevtrd.fecha_trans >='$fecsold' AND stzevtrd.fecha_trans <='$fecsolh'
			AND stzderec.estatus = '1555'
			AND tipo_mp='M'
			AND stzevtrd.nro_derecho = stzderec.nro_derecho 
         ORDER BY stzderec.registro ");		

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."ERROR: No existen Desistidas de Fusiones ...!!!"; }
	else {
    $traerr  = 0;
    $tipanota="F";
    $vtip    = 1559; 
    $horahoy = hora();
    $reg     = pg_fetch_array($resul); 
    for ($cont=0;$cont<$cantreg;$cont++) {
      $vder=$reg[nro_derecho];
      $vsol=$reg[solicitud];
      $vreg=$reg[registro];
  
      $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                      fecha_carga,hora_carga,nanota,tipo_anota,resolucion";
      $insert_valores ="$vder,'$vsol','$vreg',$vbol,$vtip,'M','$login','$fechahoy','$horahoy',0,'$tipanota',0";
          
      //No grabar cuando la solicitud exista en el temporal
      $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' AND 
                           boletin='$vbol' AND estatus='$vtip' AND tipo='M'");
      $cantfound = pg_numrows($resulfound);
      if ($cantfound==0) {
        $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
        if (!$vertra) {$traerr=$traerr+1;}
      }
      $reg = pg_fetch_array($resul); 
    }
  }  

}

//desistidas de AM. Licencias
if ($tipo=='DESISTIMIENTO LICENCIAS') {
   $resul=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud, stzderec.registro
			FROM  stzderec, stzevtrd	
			WHERE stzevtrd.evento = '1704'   
			AND stzevtrd.fecha_trans >='$fecsold' AND stzevtrd.fecha_trans <='$fecsolh'
			AND stzderec.estatus = '1555'
			AND tipo_mp='M'
			AND stzevtrd.nro_derecho = stzderec.nro_derecho 
         ORDER BY stzderec.registro ");		

   $cantreg = pg_numrows($resul);
   if ($cantreg==0) {
	  $mensaje=$mensaje."ERROR: No existen Desistidas de Licencia de Uso ...!!!"; }
	else {
    $traerr  = 0;
    $tipanota="L";
    $vtip    = 1560; 
    $horahoy = hora();
    $reg     = pg_fetch_array($resul); 
    for ($cont=0;$cont<$cantreg;$cont++) {
      $vder=$reg[nro_derecho];
      $vsol=$reg[solicitud];
      $vreg=$reg[registro];
  
      $insert_campos="nro_derecho,solicitud,registro,boletin,estatus,tipo,usuario,
                      fecha_carga,hora_carga,nanota,tipo_anota,resolucion";
      $insert_valores ="$vder,'$vsol','$vreg',$vbol,$vtip,'M','$login','$fechahoy','$horahoy',0,'$tipanota',0";
          
      //No grabar cuando la solicitud exista en el temporal
      $resulfound=pg_exec("SELECT solicitud FROM stztmpbor WHERE solicitud='$vsol' AND 
                           boletin='$vbol' AND estatus='$vtip' AND tipo='M'");
      $cantfound = pg_numrows($resulfound);
      if ($cantfound==0) {
        $vertra=$sql->insert("stztmpbor","$insert_campos","$insert_valores","");     
        if (!$vertra) {$traerr=$traerr+1;}
      }
      $reg = pg_fetch_array($resul); 
    }
  }  
}

  //Desconexion a la base de datos
  if ($traerr==0) {
    pg_exec("COMMIT WORK"); $sql->disconnect();
    $smarty->display('encabezado1.tpl');
    mensajenew("Se Generaron '$cantreg' Solicitudes",'m_bolgenre.php?nveces='.$nveces.'&nconexion='.$nconexion,'S');
    $smarty->display('pie_pag.tpl'); exit();   
  } else {
    pg_exec("ROLLBACK WORK"); $sql->disconnect();
    $smarty->display('encabezado1.tpl');
    mensajenew("ERROR: Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();   
  }

?>
