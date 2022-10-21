<?php 
ob_start();
?> 
<script language="Javascript"> 
 function browsetitularp(var1,var2,var3,var4) {
   open("act_titulard.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip=M","Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
</script>

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

$smarty ->assign('titulo','Sistema de Marcas'); 
$smarty ->assign('subtitulo','Cambio de Domicilio del Titular'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha);  
   
$vuser    = $usuario;  

if (($usuario!='rmendoza') AND ($usuario!='ngonzalez')) {
  mensajenew('AVISO: Opci&oacute;n del sistema en Mantenimiento, contactar al Administrador del Sistema ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit();
}
   
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
      $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$vsol' and solicitud!='' and tipo_mp='M'");
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      
      if (!$resultado) { 
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensaje('ERROR AL PROCESAR LA BUSQUEDA','m_cambdomi_original.php');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensaje('NO EXISTEN DATOS ASOCIADOS','m_cambdomi_original.php');
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
      
//      if ($vreg<>'' and $vreg<>null ) {
//         $smarty->display('encabezado1.tpl');
//         mensajenew('Solicitud con Registro Asignado. 
//                     Corresponde a una Anotacion Marginal','m_cambdomi.php','N');
//	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
//      }
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
          $resnom=pg_exec("select * from stzsolic where titular=$vtit");
          $regnom=pg_fetch_array($resnom);
          $vnom=$regnom[nombre];
          $insert_campos="solicitud,titular,nombre,nacionalidad,domicilio,tipo_mp";
          $insert_valores ="'$vsolh',$vtit,'$vnom','$vnac','$vdom','M'";
          $sql->insert("temptitu","$insert_campos","$insert_valores","");
          $rego=pg_fetch_array($reso);
      }
   }   

   // Grabar   
   if ($vopc==3) {     
      // Validaciones iniciales
      if ($vsolh=='-' || $vdoc=='' || $vfevh=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
	   }
      // $vfecsol=convertir_en_fecha($vfecsol,1); 
      $esmayor=compara_fechas($vfecsol,$vfec);
      if ($esmayor==1) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('No se puede cargar un evento previo a la Fecha de la Solicitud','javascript:history.back();','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }

      $fechahoy = hoy();
      //$esmayor=compara_fechas($fechaeve,$fechahoy);
      $esmayor=compara_fechas($vfec,$fechahoy);
      if ($esmayor==1) {
        mensajenew('ADVERTENCIA: NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
        $smarty->display('pie_pag.tpl'); exit(); 
      } 

       $cant_error=0;
       pg_exec("BEGIN WORK");
       // Inserta en Stzevtrd
       // Primer evento: 165
       $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and evento=1165 and 
                        documento='$vdoc'");
       $rege = pg_fetch_array($resule);
       $cantfil = pg_numrows($resule);
       if ($cantfil>0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR - El Evento ya fue Cargado','m_cambdomi_original.php','N');
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
       // Comentario del Evento
       $vcomen='';
       $resco=pg_exec("select * from temptitu where solicitud='$vsolh' and tipo_mp='M'");
       $numco=pg_numrows($resco);
       $contobj=0;
       $regco=pg_fetch_array($resco);
       for ($contobj=0;$contobj<$numco;$contobj++) 
       { $temptit=$regco[titular];
         $tempnom=$regco[nombre];
         $tempnac=$regco[nacionalidad];
         $tempdom=$regco[domicilio];
         $resco2=pg_exec("select * from stzottid where nro_derecho=$vderh and 
                          titular=$temptit");
         $regco2=pg_fetch_array($resco2);
         if (trim($tempnac)==trim($regco2[nacionalidad]) and 
             trim($tempdom)==trim($regco2[domicilio]))
         { // Good 
         } else
         { $vcomen=$vcomen.'Titular: '.trim($tempnom).' De: '.$regco2[nacionalidad].
                   '-'.trim($regco2[domicilio]).' A: '.$tempnac.'-'.trim($tempdom).' ';
         }
         $regco=pg_fetch_array($resco);
       }
       if ($vcomen=='') {
         pg_exec("ROLLBACK WORK"); 
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('No realizo ningun Cambio de Domicilio','javascript:history.back();','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
       }
       $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and evento=1010 and 
                       documento='$vdoc'");
       $rege = pg_fetch_array($resule);
       $cantfil = pg_numrows($resule);
       if ($cantfil>0) {
         pg_exec("ROLLBACK WORK");
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR - El Evento ya fue Cargado','m_cambdomi_original.php','N');
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
             $smarty->display('encabezado1.tpl');
             mensajenew('ERROR... Domicilio del Titular vacio!  Transaccion Abortada!','m_cambdomi_original.php','N');
             $smarty->display('pie_pag.tpl'); exit();
          }
          $insert_campos="nro_derecho,titular,nacionalidad,domicilio";
          $insert_valores ="$vderh,$vtit,'$vnac','$vdom'";
          $valido=$sql->insert("stzottid","$insert_campos","$insert_valores","");
          if (!$valido) {$cant_error=$cant_error+1;}
          
          $rego=pg_fetch_array($reso);
      }

      // Eliminar del temporal temptitu 
      $resul=pg_exec("delete from temptitu where solicitud='$vsolh' and tipo_mp='M'");
     
      // Mensaje final 
      if ($cant_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_cambdomi_original.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("Falla de Ingreso en la B.D. Transacciones Abortadas...!!!","javascript:history.back();","N");
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
   $smarty->display('encabezado1.tpl');
   $smarty->display('m_cambdomi_original.tpl'); 
   $smarty->display('pie_pag.tpl');
?>




