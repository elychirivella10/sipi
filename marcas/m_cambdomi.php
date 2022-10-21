<?php 
ob_start();
?> 
<script language="Javascript"> 
 function browsetitularp(var1,var2,var3,var4) {
   open("act_titulard.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip=M","Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
</script>

<?
include ("../z_includes.php");
include ("../setting.mysql.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login   = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$sede    = $_SESSION['usuario_sede'];
$hh      = hora();
$sql     = new mod_db(); 
$fecha   = fechahoy();
$vuser   = $usuario;  
$tbname_10 = "stmfactura";
$tbname_2  = "stzfactram";
$vuser=$usuario;

$smarty->assign('titulo','SIPI - Sistema de Marcas'); 
$smarty->assign('subtitulo','Cambio de Domicilio del Titular'); 
$smarty->assign('login',$usuario); 
$smarty->assign('fechahoy',$fecha);  
$smarty->display('encabezado1.tpl');

//if (($usuario!='rmendoza') AND ($usuario!='ngonzalez')) {
//  mensajenew('AVISO: Opci&oacute;n del sistema en Mantenimiento, contactar al Administrador del Sistema ...!!!','../index1.php','N');
//  $smarty->display('pie_pag.tpl'); exit();
//}
   
   //Captura Variables leidas en formulario inicial
   $vopc=   $_GET['vopc'];
   $vsol1=  $_POST['vsol1'];
   $vsol2=  $_POST['vsol2'];
   $vnom=   $_POST['vnom'];
   $vest=   $_POST['vest'];
   $vfecsol=$_POST['vfecsol'];
   $vfevh=  $_POST['vfevh'];
   $vdoc=   $_POST['vdoc'];   
   $vsolh=  $_POST['vsolh'];
   $vderh=  $_POST['vderh'];
   $vregh=  $_POST['vregh'];
   $vfactura =  trim($_POST['vfactura']);
        
   $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vreg=   $vreg1.$vreg2;
   $resultado=false;
   $vfec=hoy();
   $fechahoy=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('vmodo',''); 
   $smarty ->assign('vmodo1','readonly'); 
   $smarty ->assign('modo2','disabled'); 
   $smarty ->assign('modo3','disabled'); 

   
   $sql->connection($login);   
    
   if ($vopc==1) {
      $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$vsol' and solicitud!='' and tipo_mp='M'");
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      $smarty ->assign('vmodo1','readonly'); 
      $smarty ->assign('modo2',''); 
      $smarty ->assign('modo3',''); 
      
      if (!$resultado) { 
         $sql->disconnect();
         mensaje('ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!','m_cambdomi.php');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         mensaje('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','m_cambdomi.php');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vsolh=$reg[solicitud]; 
      $vderh=$reg[nro_derecho];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vreg=ltrim(rtrim($reg[registro]));
      $vnomsol=$reg[nombre];
      $vest=$reg[estatus]-1000;
      $vfecsol=$reg[fecha_solic];
      //$vmod=$reg[modalidad];
      //$nameimage=imagen($vsol1,$vsol2);       


      //Validacion si esta registrada o NO la marca para la Reconversion Monetaria, Validos depositos > 20/08/2018.
      if ($vreg<>'' and $vreg<>null ) {
        $res795 = pg_exec("select * from stzevtrd where nro_derecho='$vderh' and evento=1795");
        $reg795 = pg_fetch_array($res795);
        $vfec795= trim($reg795['fecha_event']); //echo "fecha795=$vfec795";
        $esmayor=compara_fechas($vfec795,$vfevh);
        if ($esmayor==1) { }
        else {  
         mensajenew('ADVERTENCIA: Solicitud con Registro Asignado. Corresponde a una Anotacion Marginal','m_cambdomi.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
	     }  
      }
      //exit();

      // Descripcon del estatus 
      $resulest=pg_exec("SELECT * FROM stzstder WHERE estatus-1000='$vest'");
      $regest = pg_fetch_array($resulest);
      $vdesest=$regest[descripcion];
      
      // Elimina posibles registros existentes en el temporal
      $sql->del("temptitu","solicitud='$vsolh' and tipo_mp='M'");
     
      // Llenar el temporal
      $reso=pg_exec("select * from stzottid where nro_derecho='$vderh'");
      $numo=pg_numrows($reso);
      $contobj=0;
      $rego=pg_fetch_array($reso);
      for ($contobj=0;$contobj<$numo;$contobj++) 
      {   $vtit=$rego[titular];
          $vnac=$rego[nacionalidad];
          $vdom=trim($rego[domicilio]);
          $pdom=trim($rego[pais_domicilio]);
          $resnom=pg_exec("select * from stzsolic where titular=$vtit");
          $regnom=pg_fetch_array($resnom);
          $vnom=$regnom[nombre];
          $insert_campos="solicitud,titular,nombre,nacionalidad,domicilio,tipo_mp,pais_domicilio";
          $insert_valores ="'$vsolh',$vtit,'$vnom','$vnac','$vdom','M','$pdom'";
          $sql->insert("temptitu","$insert_campos","$insert_valores","");
          $rego=pg_fetch_array($reso);
      }
   }   

   // Grabar   
   if ($vopc==3) {     
      // Validaciones iniciales
      if ($vsolh=='-' || $vdoc=='' || $vfevh=='') {
         $sql->disconnect();
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - DATOS INCORRECTOS O VACIOS ...!!','javascript:history.back();','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }

      //Validacion segun requerimiento-correo 05-2019 por el Director General Alberto Rey      
      // =======================================================================================================================
      $vcant_am=0;
      $nfac=0;
      $nfac = 'F0'.$vfactura;
      $obj_query = $sql->query("SELECT * FROM $tbname_10 WHERE nro_factura='$nfac'");
      $obj_filas = $sql->nums('',$obj_query);
      if ($obj_filas!=0) {
        $objs=$sql->objects('',$obj_query);
        $vcant_am=$objs->cant_cambdomi; 
        //mensajenew('ERROR: Factura '.$nfactura.' YA usado anteriormente en otro Servicio ...!!!','m_amcesion.php','N');
        //$smarty->display('pie_pag.tpl'); exit(); 
      }

      //if (($usuario=='rmendoza') OR ($usuario=='ngonzalez')) {
      // =======================================================================================================================
      //Verificando conexion a Mysql para consulta a facturacion
      $mysql = new mod_mysql_db(); 
      $mysql->connection_mysql();

      //Datos de la Factura 
      $objquery = $mysql->query_mysql("SELECT fac_id,cli_id,fac_fecha,fac_total FROM sfa_factura WHERE fac_num='$nfac'"); 
      $objfilas = $mysql->nums_mysql('',$objquery);
      if ($objfilas==0) {
        mensajenew('ADVERTENCIA: Factura NO existe en la Base de Datos del SISFAC ...!!!','m_cambdomi.php','N');
        $smarty->display('pie_pag.tpl'); exit(); }
      $objsfac  = $mysql->objects_mysql('',$objquery);
      $fac_id   = $objsfac->fac_id;
      $fechafac = $objsfac->fac_fecha; 
      $anno = substr($fechafac,0,4);
      $mes  = substr($fechafac,5,2);
      $dia  = substr($fechafac,8,2);
      $vfechafactura = $dia.'/'.$mes.'/'.$anno; 

      //Detalle de la Factura 
      $objdetalle = $mysql->query_mysql("SELECT ser_id,dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id IN ('CDARE','CDARN') AND fac_id=$fac_id"); 
      $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
      if ($objtotdtalle==0) {
        mensajenew('ADVERTENCIA: Factura NO presenta ning&uacute;n Servicio de Cambio de Peticionario ...!!!','m_cambdomi.php','N');
        $smarty->display('pie_pag.tpl'); exit(); 
      }
      $objsdta = $mysql->objects_mysql('',$objdetalle);
      $codservi = $objsdta->ser_id;
      $canservi = $objsdta->dtalle1_cantidad_ser;

      //echo "cd=$codservi";

      if ($vcant_am>=$canservi) {
        ///mensajenew('ERROR: Factura '.$nfactura.' YA asociada a otra(s) solicitud(es)...!!!','m_cambdomi.php','N');
        mensajenew('ADVERTENCIA: Factura '.$nfactura.' YA asociada a la cantidad de Solicitud(es) permitidas o indicadas...!!!','m_cambdomi.php','N');
        $smarty->display('pie_pag.tpl'); exit();
      } 
      if($codservi=='CDARN') { $totalpag= 'Total Bolivares: '; }
      else { $totalpag= 'Total US$ : '; }
      //Desconexion de la Base de Datos
      $mysql->disconnect_mysql();
      // =======================================================================================================================

      //}

      //Ejemplo de Prueba
      //$nfac = "F0469088";
      //$vfechafactura = "15/05/2019";
      //$fechafac = "15/05/2019";
      //$canservi = 1;
      //$codservi="CDARN";
      //if ($vcant_am>=$canservi) {
      //  mensajenew('ADVERTENCIA: Factura '.$nfactura.' YA asociada a la cantidad de Solicitud(es) permitidas o indicadas...!!!','m_cambdomi.php','N');
      //  $smarty->display('pie_pag.tpl'); exit();
      //} 
      // Fin de Prueba

      // $vfecsol=convertir_en_fecha($vfecsol,1); 
      $esmayor=compara_fechas($vfecsol,$vfec);
      if ($esmayor==1) {
         $sql->disconnect();
         mensajenew('ADVERTENCIA: No se puede cargar un evento previo a la Fecha de la Solicitud. ...!!!','javascript:history.back();','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }

      //$fechahoy = hoy();
      //$esmayor=compara_fechas($fechaeve,$fechahoy);
      $esmayor=compara_fechas($vfec,$fechahoy);
      if ($esmayor==1) {
        mensajenew('ADVERTENCIA: NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
        $smarty->display('pie_pag.tpl'); exit(); 
      } 

      // Validacion del Domicilio - Comentario del Evento 1010
      $vcomen='';
      $resco=pg_exec("select * from temptitu where solicitud='$vsolh' and tipo_mp='M'");
      $numco=pg_numrows($resco);
      $contobj=0;
      $ind_nac_ext = 'N';
      $regco=pg_fetch_array($resco);
      for ($contobj=0;$contobj<$numco;$contobj++) { 
        $temptit=$regco[titular];
        $tempnom=$regco[nombre];
        $tempnac=$regco[nacionalidad];
        $tempdom=$regco[domicilio];
        $temppdom=$regco[pais_domicilio];
        if ($tempnac!='VE') { $ind_nac_ext = 'S'; }        
        $resco2=pg_exec("select * from stzottid where nro_derecho=$vderh and titular=$temptit");
        $regco2=pg_fetch_array($resco2);
        if (trim($tempnac)==trim($regco2[nacionalidad]) and 
            trim($tempdom)==trim($regco2[domicilio]))
        { // Good 
        } else
        { $vcomen=$vcomen.'Titular: '.trim($tempnom).' De: '.$regco2[nacionalidad].
                  '-'.trim($regco2[domicilio]).' A: '.$tempnac.'-'.trim($tempdom).'. Segun Factura: '.$nfac;
        }
        $regco=pg_fetch_array($resco);
      }
      if ($vcomen=='') {
        pg_exec("ROLLBACK WORK"); 
        $sql->disconnect();
        mensajenew('ADVERTENCIA: No realizo ningun Cambio de Domicilio ...!!!','javascript:history.back();','N');
	$smarty->display('pie_pag.tpl'); exit(); 
      }

      //Validación de Nacionalidad Extranjero con Codigo de Servicio CDARE en Detalle de la Factura 
      // =======================================================================================================================
      if (($ind_nac_ext=='S') AND ($codservi!='CDARE')) {
        $sql->disconnect();
        mensajenew('ADVERTENCIA: Factura Inv&aacute;lida, Titular Extranjero, por lo que el Pago debe ser en Moneda Extranjera o en Petros ...!!'.$ind_nac_ext.' '.$codservi,'javascript:history.back();','N');
	$smarty->display('pie_pag.tpl'); exit(); 
      }

      //Validación de Nacionalidad Venezolano con Codigo de Servicio CDARN en Detalle de la Factura 
      if (($ind_nac_ext=='N') AND ($codservi!='CDARN')) {
         $sql->disconnect();
         mensajenew('ADVERTENCIA: Factura Inv&aacute;lida, Titular Nacional, por lo que el Pago debe ser en Moneda Nacional o en Petros ...!!','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }

      // =======================================================================================================================

       $cant_error=0;
       pg_exec("BEGIN WORK");
       // Inserta en Stzevtrd
       // Primer evento: 165
       $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and evento=1165 AND documento='$vdoc'");
       $rege = pg_fetch_array($resule);
       $cantfil = pg_numrows($resule);
       if ($cantfil>0) {
         $sql->disconnect();
         mensajenew('ADVERTENCIA: El Evento ya fue Cargado ...!!!','m_cambdomi.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
       }
       $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,
                       usuario,desc_evento,comentario,hora";
       $insert_valores ="'$vderh','1165','$vfevh',nextval('stzevtrd_secuencial_seq'),$vest+1000,
                         $vdoc,'$vfec','$vuser','MODIFICACION DE DATOS DE LA SOLICITUD',
                         'CAMBIO DE DOMICILIO','$hh'";
       $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
       if (!$valido) {$cant_error=$cant_error+1;}

       // Segundo evento: 1010
       $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and evento=1010 and documento='$vdoc'");
       $rege = pg_fetch_array($resule);
       $cantfil = pg_numrows($resule);
       if ($cantfil>0) {
         pg_exec("ROLLBACK WORK");
         $sql->disconnect();
         mensajenew('ADVERTENCIA: El Evento ya fue Cargado ...!!!','m_cambdomi.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      } 
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,
                      usuario,desc_evento,comentario,hora";
      $insert_valores ="'$vderh','1010','$vfevh',nextval('stzevtrd_secuencial_seq'),$vest+1000,
                        $vdoc,'$vfec','$vuser','CAMBIO DE DOMICILIO','$vcomen','$hh'";
      $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
      if (!$valido) {$cant_error=$cant_error+1;}

      // Guardar en Stzottid
      // Eliminar todas las ocurrencias para grabarlas nuevas
      $sql->del("stzottid","nro_derecho=$vderh");
      $reso=pg_exec("select * from temptitu where solicitud='$vsolh' and tipo_mp='M'");
      $numo=pg_numrows($reso);
      $contobj=0;
      $rego=pg_fetch_array($reso);
      for ($contobj=0;$contobj<$numo;$contobj++) {
          $vtit=$rego[titular];
          $vnac=$rego[nacionalidad];
          $vdom=trim($rego[domicilio]);
          $pdom=$rego[pais_domicilio];
          $vide=$rego[identificacion];
          $vnom=$rego[nombre];
          $vind=$rego[indole];
          $vte1=$rego[telefono1];
          $vte2=$rego[telefono2];
          $vfax=$rego[fax];
          $vema=$rego[email];
          if ($vdom=='' or empty($vdom)) 
          {  pg_exec("ROLLBACK WORK");
             $sql->disconnect();
             mensajenew('ADVERTENCIA: Domicilio del Titular vacio ...!!!  Transaccion Abortada!','m_cambdomi.php','N');
             $smarty->display('pie_pag.tpl'); exit();
          }
          $insert_campos="nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
          $insert_valores ="$vderh,$vtit,'$vnac','$vdom','$pdom'";
          $valido=$sql->insert("stzottid","$insert_campos","$insert_valores","");
          if (!$valido) {$cant_error=$cant_error+1;}
          $rego=pg_fetch_array($reso);
      }

      //Validacion con Stmfactura y Stzfactram
      // =======================================================================================================================
      if ($vcant_am>0) {$delfactu = $resulage=pg_exec("delete from $tbname_10 where nro_factura='$nfac'");}
      $vcant_am=$vcant_am+1;
      $tipoanota='';
      $delfactu = $resulage=pg_exec("delete from $tbname_10 where nro_factura='$nfac'");
      $insfactu   = true;
      $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede,cant_mprensa,cant_pprensa,tipo_anotamar,cant_anotamar,cant_cambtitu,cant_cambdomi";
      $insert_str = "'$nfac','$fechafac',0,0,0,'$sede',0,0,'$tipoanota',0,0,$vcant_am";    
      $insfactu   = $sql->insert("$tbname_10","$col_campos","$insert_str","");
      if (!$insfactu) { $can_error = $can_error + 1; }

      $insolfac   = true;
      $col_campos = "nro_controlft,tipo_ft,nro_factura,fecha_factura,nro_derecho,solicitud,tipo_mpa,usuario,fecha_carga,hora_carga,tipo_tram";
      $insert_str = "nextval('stzfactram_nro_controlft_seq'),'S','$nfac','$fechafac','$vderh','$vsolh','M','$usuario','$fechahoy','$hh','$codservi'";    
      $insolfac   = $sql->insert("$tbname_2","$col_campos","$insert_str","");
      if (!$insolfac) { $can_error = $can_error + 1; }
      // =======================================================================================================================

      // Eliminar del temporal temptitu 
      $resul=pg_exec("delete from temptitu where solicitud='$vsolh' and tipo_mp='M'");
     
      // Mensaje final 
      if ($cant_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_cambdomi.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           mensajenew("ERROR: Falla de Ingreso en la B.D. Transacciones Abortadas...!!!","javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();   } 
   }

   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('psoli',$vsol1.'-'.$vsol2);
   $smarty ->assign('vsol',$vsol);
   $smarty ->assign('vderh',$vderh);
   $smarty ->assign('vsolh',$vsolh);
   $smarty ->assign('vfec',$vfec);
   $smarty ->assign('nombre',$vnomsol); 
   $smarty ->assign('vdesest',$vdesest); 
   $smarty ->assign('vest',$vest); 
   $smarty ->assign('vfecsol',$vfecsol); 
   $smarty->assign('vmod',$vmod);
   $smarty->assign('nameimage',$nameimage);
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lclase','Estatus:'); 
   $smarty ->assign('ltitular','Titular(es):'); 
   $smarty ->assign('ltitular2','Titular(es) con su Nuevo Domicilio:');
   $smarty ->assign('lfecsol','Fecha Solicitud:'); 
   $smarty ->assign('lfechaevento','Fecha del Evento:'); 
   $smarty ->assign('ldocumento','Numero Documento:'); 
   $smarty ->assign('lfactura','N&uacute;mero de Factura:'); 

   $smarty->display('m_cambdomi.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
