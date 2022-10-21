<?php 
ob_start();
?> 
<script language="Javascript"> 
 function browsetitularp(var1,var2,var3,var4) {
   open("act_titulard.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip=P","Ventana", "width=2,height=2,left=511,top=300, scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
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

$smarty->assign('titulo','Sistema de Patentes'); 
$smarty->assign('subtitulo','Cambio de Titular'); 
$smarty->assign('login',$usuario); 
$smarty->assign('fechahoy',$fecha);  
$smarty->display('encabezado1.tpl');
$vuser     = $usuario;  
   
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
      $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$vsol' and solicitud!='' and tipo_mp='P'");
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      
      if (!$resultado) { 
         $sql->disconnect();
         mensaje('ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA','p_cambtitu_original.php');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         mensaje('ERROR: NO EXISTEN DATOS ASOCIADOS','p_cambtitu_original.php');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vsolh=$reg[solicitud]; 
      $vderh=$reg[nro_derecho];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vreg=trim($reg[registro]);
      $vnom=$reg[nombre];
      $vest=$reg[estatus]-2000;
      $vfecsol=$reg[fecha_solic];
      //$vmod=$reg[modalidad];
      //$nameimage=imagen($vsol1,$vsol2);       
      
      if ($vreg<>'       ' and $vreg<>null ) {
         mensajenew('AVISO: Solicitud con Registro Asignado. Corresponde a una Anotacion Marginal','p_cambtitu_original.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      // Descripcon del estatus 
      $resulest=pg_exec("SELECT * FROM stzstder WHERE estatus-2000='$vest'");
      $regest = pg_fetch_array($resulest);
      $vdesest=$regest[descripcion];
      
      // Elimina posibles registros existentes en el temporal
      $sql->del("temptitu","solicitud='$vsolh' and tipo_mp='P'");
     
      // Vectores de Paises
      $obj_query = $sql->query("SELECT * FROM stzpaisr ORDER BY nombre");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
          $vcodpai[$contobj] = $objs->pais;
          $vnompai[$contobj] = $objs->nombre;
	  $objs = $sql->objects('',$obj_query);}
   }   

   // Grabar   
   if ($vopc==3) {     
      // Validaciones iniciales
      if ($vsolh=='-' || $vdoc=='' || $vfevh=='') {
        $sql->disconnect();
        mensajenew('ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
	     $smarty->display('pie_pag.tpl'); exit(); 
	 }
	 
      // Valida si se cargo algun titular nuevo
      $objquery = pg_exec("select * from temptitu where solicitud='$vsolh' and tipo_mp='P'");
      $objfilas = pg_numrows($objquery);
      if ($objfilas==0){  
         $sql->disconnect();
         mensajenew('ERROR... Debe cargar el nuevo titular!  Transaccion abortada!','javascript:history.back();','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      } else {
        $objreg = pg_fetch_array($objquery);
        $contobj=0;
        $vnomtit_final='';
        for ($contobj=0;$contobj<$objfilas;$contobj++) 
        { if ($contobj+1==$objfilas) {$vnomtit_final=$vnomtit_final.trim($objreg[nombre]);}
          else {$vnomtit_final=$vnomtit_final.trim($objreg[nombre]).';';}
          $objreg = pg_fetch_array($objquery);
        }
        $objquery = pg_exec("select * from stzottid where nro_derecho='$vderh'");
        $objfilas = pg_numrows($objquery);
        $objreg = pg_fetch_array($objquery);
        $contobj=0;
        $vnomtit_inicial='';
        for ($contobj=0;$contobj<$objfilas;$contobj++) 
        { $vtit_z=$objreg[titular];
          $objstz = pg_exec("select nombre from stzsolic where titular='$vtit_z'"); 
          $regstz = pg_fetch_array($objstz);
          if ($contobj+1==$objfilas) {$vnomtit_inicial=$vnomtit_inicial.trim($regstz[nombre]);}
          else {$vnomtit_inicial=$vnomtit_inicial.trim($regstz[nombre]).';';}
          $objreg = pg_fetch_array($objquery);
        }
      }
      // $vfecsol=convertir_en_fecha($vfecsol,1); 
      $esmayor=compara_fechas($vfecsol,$vfec);
      if ($esmayor==1) {
         $sql->disconnect();
         mensajenew('No se puede cargar un evento previo a la Fecha de la Solicitud','javascript:history.back();','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
         }

       $cant_error=0;
       pg_exec("BEGIN WORK");
       // Inserta en Stzevtrd
       // Primer evento: 165
       $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and evento=2165 and documento='$vdoc'");
       $rege = pg_fetch_array($resule);
       $cantfil = pg_numrows($resule);
       if ($cantfil>0) {
         $sql->disconnect();
         mensajenew('ERROR - El Evento ya fue Cargado','p_cambtitu.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
       }
       $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,
                       usuario,desc_evento,comentario,hora";
       $insert_valores ="'$vderh','2165','$vfevh',nextval('stzevtrd_secuencial_seq'),$vest+2000,
                         $vdoc,'$vfec','$vuser','MODIFICACION DE DATOS DE LA SOLICITUD',
                         'CAMBIO DE PETICIONARIO','$hh'";
       $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
       if (!$valido) {$cant_error=$cant_error+1;}
       // Segundo evento: 234
       $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and evento=2234 and documento='$vdoc'");
       $rege = pg_fetch_array($resule);
       $cantfil = pg_numrows($resule);
       if ($cantfil>0) {
         pg_exec("ROLLBACK WORK");
         $sql->disconnect();
         mensajenew('ERROR: El Evento ya fue Cargado','p_cambtitu_original.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      } 
      $vcomen = 'Elim.: '.$vnomtit_inicial.' Inser.: '.$vnomtit_final;
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,
                      usuario,desc_evento,comentario,hora";
      $insert_valores ="'$vderh','2234','$vfevh',nextval('stzevtrd_secuencial_seq'),$vest+2000,
                        $vdoc,'$vfec','$vuser','CAMBIO DE TITULAR','$vcomen','$hh'";
      $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
      if (!$valido) {$cant_error=$cant_error+1;}

      // Guardar en Stzottid
      // Eliminar todas las ocurrencias para grabarlas nuevas
      $sql->del("stzottid","nro_derecho=$vderh");
      $reso=pg_exec("select * from temptitu where solicitud='$vsolh' and tipo_mp='P'");
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
             mensajenew('ERROR... Domicilio del Titular vacio!  Transaccion Abortada!','p_cambtitu_original.php','N');
             $smarty->display('pie_pag.tpl'); exit();
          }
          if ($vtit==0) // El titular es nuevo
          {  $insert_campos="identificacion,nombre,indole,telefono1,telefono2,fax,email";
             $insert_valores ="'$vide','$vnom','$vind','$vte1','$vte2','$vfax','$vema'";
             $valido=$sql->insert("stzsolic","$insert_campos","$insert_valores","");
             if (!$valido) {$cant_error=$cant_error+1;}
             $rescodt=pg_exec("select last_value from stzsolic_titular_seq");
             $regcodt=pg_fetch_array($rescodt);
             $vtit=$regcodt[last_value];   
          }
          $insert_campos="nro_derecho,titular,nacionalidad,domicilio";
          $insert_valores ="$vderh,$vtit,'$vnac','$vdom'";
          $valido=$sql->insert("stzottid","$insert_campos","$insert_valores","");
          if (!$valido) {$cant_error=$cant_error+1;}
          // Guardar en stzhotid
          $resold=pg_exec("select * from stzhotid where nro_derecho=$vderh and titular=$vtit");
          $filold = pg_numrows($resold);
          if ($filold==0) {
             $insert_campos="nro_derecho,titular,nacionalidad,domicilio";
             $insert_valores ="$vderh,$vtit,'$vnac','$vdom'";
             $valido=$sql->insert("stzhotid","$insert_campos","$insert_valores","");
             if (!$valido) {$cant_error=$cant_error+1;}
          }
          $rego=pg_fetch_array($reso);
      }

      // Eliminar del temporal temptitu 
      $resul=pg_exec("delete from temptitu where solicitud='$vsolh' and tipo_mp='P'");
     
      // Mensaje final 
      if ($cant_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','p_cambtitu_original.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
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
   $smarty ->assign('nombre',$vnom); 
   $smarty ->assign('vdesest',$vdesest); 
   $smarty ->assign('vest',$vest); 
   $smarty ->assign('vfecsol',$vfecsol); 
   $smarty->assign('vmod',$vmod);
   $smarty->assign('nameimage',$nameimage);
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lclase','Estatus:'); 
   $smarty ->assign('ltitular','Titular(es) Actual(es):'); 
   $smarty ->assign('ltitular2','Titular(es) Final(es):');
   $smarty ->assign('lfecsol','Fecha Solicitud:'); 
   $smarty ->assign('lfechaevento','Fecha del Evento:'); 
   $smarty ->assign('ldocumento','Numero Documento:'); 
   
   $smarty->display('p_cambtitu_original.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
