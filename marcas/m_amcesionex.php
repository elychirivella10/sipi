<?php 
ob_start();
?> 
<script language="Javascript"> 
 function browsetitularp(var1,var2,var3,var4) {
   open("act_titulard.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip=M","Ventana", "width=2,height=2,left=511,top=300, scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
</script>

<?php
include ("../z_includes.php");
include ("../setting.mysql.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login   = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$sede    = $_SESSION['usuario_sede'];
$hh=hora();
$sql = new mod_db();
$fecha=fechahoy();

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Anotaciones Marginales Cesion/Fusion/Cambio de Titular Exoneradas'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
$smarty->display('encabezado1.tpl');
   
   $vuser    =$usuario;  
   
   //Captura Variables leidas en formulario inicial
   $vopc=   $_GET['vopc'];
   $vsol1=  $_POST['vsol1'];
   $vsol2=  $_POST['vsol2'];
   $vreg1=  $_POST['vreg1'];
   $vreg2=  $_POST['vreg2'];
   $vnom=   $_POST['vnom'];
   $vest=   $_POST['vest'];
   $vfecsol=$_POST['vfecsol'];
   $vfecreg=$_POST['vfecreg'];
   $vfecven=$_POST['vfecven'];
   $vfevh=$_POST['vfevh'];
   $vdoc=$_POST['vdoc'];
   $vcodtn=$_POST['vcodtn'];
   $vnomtn=$_POST['vnomtn'];
   $vcodtit=$_POST['vcodtit'];
   $vnomtit=$_POST['vnomtit'];
   $vtipo=$_POST['vtipo'];
   $vcomenta=$_POST['vcomenta'];
   $vdomnew=$_POST['vdomnew'];
   $vnompai=$_POST['vnompai'];
   $vdomtit=$_POST['vdomtit'];
   $vnactit=$_POST['vnactit'];
   $vtra=$_POST['vtra'];
   $vcodagen=$_POST['vcodagen'];
   $vnomagen=$_POST['vnomagen'];
   $vtranew=$_POST['vtranew'];
   $vsolh=  $_POST['vsolh'];
   $vderh=  $_POST['vderh'];  
   $vregh=  $_POST['vregh'];
   $vnacnew=$_POST['vnacnew'];
   $vnomagenew=$_POST['options'];
        
   $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vreg=   $vreg1.$vreg2;
   $resultado=false;
   $vfec=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('vmodo',''); 
   $smarty ->assign('modo1','readonly'); 
   
   $sql->connection($login);   

   if ($vopc==1) {
      $resultado=pg_exec("SELECT a.nro_derecho,solicitud,registro,estatus,nombre,fecha_solic,
                                 fecha_regis,fecha_venc,agente,tramitante
                            FROM stmmarce a, stzderec b
                           WHERE a.nro_derecho=b.nro_derecho and solicitud='$vsol' and solicitud!='' and tipo_mp='M'");
   }

   if ($vopc==2) {
      $resultado=pg_exec("SELECT a.nro_derecho,solicitud,registro,estatus,nombre,fecha_solic,
                                 fecha_regis,fecha_venc,agente,tramitante
                            FROM stmmarce a, stzderec b
                         WHERE a.nro_derecho=b.nro_derecho and registro='$vreg' and registro!='' and tipo_mp='M'");
   }

   if ($vopc==1 || $vopc==2) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      $smarty ->assign('modo1',''); 
      
      if (!$resultado) {
         $sql->disconnect(); 
         mensajenew('ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!','m_amcesionex.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','m_amcesionex.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vsolh=$reg[solicitud];
      $vderh=$reg[nro_derecho];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vreg=ltrim(rtrim($reg[registro]));
      $vest=$reg[estatus];
      $vreg1=substr($vreg,-8,1);
      $vreg2=substr($vreg,1);
      $vnom=$reg[nombre];
      $vest=$reg[estatus];
      $vfecsol=$reg[fecha_solic];
      $vfecreg=$reg[fecha_regis];
      $vfecven=$reg[fecha_venc];
      $vtit=$reg[titular];
      $vcodage=$reg[agente];
      $vtra=$reg[tramitante];
      
      if ($vcodage==0) {$vcodage='';}
      if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      }
                  
      if ($vreg!='') { //Esta bien 
      }  ELSE {
         $sql->disconnect(); 
         mensajenew('ERROR: Solo aplica a MARCAS con REGISTRO ASIGNADO ...!!!','m_amcesionex.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
      // Descripcon del estatus 
      $resulest=pg_exec("SELECT * FROM stzstder WHERE estatus='$vest' and tipo_mp='M'");
      $regest = pg_fetch_array($resulest);
      $vdesest=$regest[descripcion];
      $vest=$vest-1000;
      
      // Vectores de Agentes
      $obj_query = $sql->query("SELECT * FROM stzagenr ORDER BY nombre");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $vcodagenew[$contobj] = '';
      $vnomagenew[$contobj] = '';
      $objs = $sql->objects('',$obj_query);
      for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
          $vcodagenew[$contobj] = $objs->agente;
          $vnomagenew[$contobj] = $objs->nombre;
	  $objs = $sql->objects('',$obj_query);}

      // Elimina posibles registros existentes en el temporal
      $sql->del("temptitu","solicitud='$vsolh' and tipo_mp='M'");

   }   

   if ($vopc==3) {
      // Validaciones iniciales
      if ($vsolh=='-' || $vregh=='' || $vcomenta=='' || $vdoc=='' || $vfevh=='' || $vtipo=='') {
         $sql->disconnect();
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - DATOS INCORRECTOS O VACIOS...','m_amcesionex.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
	 }
	 
      //$vfecsol=convertir_en_fecha($vfecsol,1); 
      $esmayor=compara_fechas($vfecsol,$vfec);
      if ($esmayor==1) {
         $sql->disconnect();
         mensajenew('ERROR: No se puede cargar un evento previo a la Fecha de la Solicitud','m_amcesionex.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
      // Verificar que se ingrese al menos un titular en el temporal
      $restmp=pg_exec("select * from temptitu where solicitud='$vsolh' and tipo_mp='M'");
      $numtmp=pg_numrows($restmp);
      if ($numtmp==0) {
         $sql->disconnect();
         mensajenew('ERROR: No existe(n) Titular(es) Final(es). Transaccion Abortada...','m_amcesionex.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
       
      if ($vtipo==1) {$vcodeven=1205; $vdeseven='SOLICITUD DE CESION';}
      if ($vtipo==2) {$vcodeven=1206; $vdeseven='SOLICITUD DE FUSION';}
      if ($vtipo==3) {$vcodeven=1209; $vdeseven='SOLICITUD DE CAMBIO DEL TITULAR';}
      
      $cant_error=0;
      pg_exec("BEGIN WORK");
  
      // Inserta en Stmevtrd
      $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and 
                       evento='$vcodeven' and documento='$vdoc'");
      $rege = pg_fetch_array($resule);
      $cantfil = pg_numrows($resule);
      if ($cantfil>0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR - El Evento ya fue Cargado','m_amcesionex.php','N');
         $smarty->display('pie_pag.tpl'); exit(); 
      }
      $vcomenta = $vcomenta." EXONERADA.";
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,
                      usuario,desc_evento,comentario,hora";
      $insert_valores ="'$vderh','$vcodeven','$vfevh',nextval('stzevtrd_secuencial_seq'),
                        $vest+1000,$vdoc,'$vfec','$vuser','$vdeseven','$vcomenta','$hh'";
      $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
      if (!$valido) {$cant_error=$cant_error+1;}
      
      // Inicializacion de variables y comentarios
      $vagenf=0; $vtraf='';
      if ($vcodagen!='') { $vagenf=$vcodagen; $vtraf='';}
      if ($vcodagen=='') { if ($vtranew!='') {$vagenf=0; $vtraf=$vtranew;} }  
      if ($vagenf>0) {
         $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vagenf");
         $regage = pg_fetch_array($resulage);
         $vtraf=$regage[nombre];}           
      $restmp=pg_exec("select * from temptitu where solicitud='$vsolh' and tipo_mp='M'");
      $numtmp=pg_numrows($restmp);
      $contobj=0;
      $regtmp=pg_fetch_array($restmp);
      $vcomen2='Final(es): ';
      for ($contobj=0;$contobj<$numtmp;$contobj++) 
      { if ($contobj+1==$numtmp) { $vcomen2=$vcomen2.trim($regtmp[nombre]);}
        else                     { $vcomen2=$vcomen2.trim($regtmp[nombre]).';';}
        $regtmp=pg_fetch_array($restmp);
      }  
      $restmp=pg_exec("select * from stzottid where nro_derecho=$vderh");
      $numtmp=pg_numrows($restmp);
      $contobj=0;
      $regtmp=pg_fetch_array($restmp);
      $vcomen1='Inicial(es): ';
      for ($contobj=0;$contobj<$numtmp;$contobj++) 
      { $vct=$regtmp[titular];
        $restitur=pg_exec("select * from stzsolic where titular=$vct");
        $regtitur=pg_fetch_array($restitur);
        $nomtit=$regtitur[nombre];
        if ($contobj+1==$numtmp) { $vcomen1=$vcomen1.trim($nomtit);}
        else                     { $vcomen1=$vcomen1.trim($nomtit).';';}
        $regtmp=pg_fetch_array($restmp);
      } 
      $vcomen=$vcomen1.' '.$vcomen2;  
      // Guardar Tabla Nueva para posteriores actualizaciones
      $resco=pg_exec("select * from temptitu where solicitud='$vsolh' and tipo_mp='M'");
      $numco=pg_numrows($resco);
      $contobj=0;
      $regco=pg_fetch_array($resco);
      for ($contobj=0;$contobj<$numco;$contobj++) 
      {  $temptit=$regco[titular];
         $tempnom=$regco[nombre];
         $tempnac=$regco[nacionalidad];
         $tempdom=$regco[domicilio];
         $tempide=$rego[identificacion];
         $tempind=$rego[indole];
         $tempte1=$rego[telefono1];
         $tempte2=$rego[telefono2];
         $tempfax=$rego[fax];
         $tempema=$rego[email];
         if ($tempdom=='' or $tempnac=='') {
            $sql->disconnect();
            $smarty->display('encabezado1.tpl');
            mensajenew('ERROR - Falto ingresar Nacionalidad o Domicilio del Titular Final...','m_amcesionex.php','N');
            $smarty->display('pie_pag.tpl'); exit(); 
         }
         if ($temptit==0) // El titular es nuevo
         {  $insert_campos="identificacion,nombre,indole,telefono1,telefono2,fax,email";
            $insert_valores ="'$tempide','$tempnom','$tempind','$tempte1','$tempte2',
                             '$tempfax','$tempema'";
            $valido=$sql->insert("stzsolic","$insert_campos","$insert_valores","");
            if (!$valido) {$cant_error=$cant_error+1;}
            $rescodt=pg_exec("select last_value from stzsolic_titular_seq");
            $regcodt=pg_fetch_array($rescodt);
            $temptit=$regcodt[last_value];   
         }
         if (ltrim(rtrim($vagenf))=='') {$vagenf=0;}
         $insert_campos="nro_derecho,nanota,solicitud,tipo,evento,cod_tit_2,nom_tit_2,
                      domicilio,pais,tramitante,agente,verificado,inf_adicional,cod_tit_1";
         $insert_valores ="$vderh,$vdoc,'$vsolh','M',$vcodeven,$temptit,'$tempnom',
                       '$tempdom','$tempnac','$vtraf',$vagenf,'N','$vcomen',0";
         $valido=$sql->insert("stzantma","$insert_campos","$insert_valores","");
         if (!$valido) {$cant_error=$cant_error+1;} 
         $regco=pg_fetch_array($resco);
      }

      //$insfactu   = true;
      //$col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede,tipo_anotamar";
      //$insert_str = "'$nfac','$fechafac',0,0,0,'$sede','$tipoanota'";  
      //$insfactu   = $sql->insert("$tbname_10","$col_campos","$insert_str","");
      //if (!$insfactu) { $can_error = $can_error + 1; }

      // Elimina registros existentes en el temporal
      $sql->del("temptitu","solicitud='$vsolh' and tipo_mp='M'");   
           
      // Mensaje final 
      if ($cant_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_amcesionex.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           mensajenew("Falla de Ingreso en la B.D. Transacciones Abortadas...!!!","m_amcesionex.php","N");
           $smarty->display('pie_pag.tpl'); exit();   } 
   }

   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('psoli',$vsol1.'-'.$vsol2); 
   $smarty ->assign('vsol',$vsol);
   $smarty ->assign('vderh',$vderh);
   $smarty ->assign('vfec',$vfec);
   $smarty ->assign('registro1',$vreg1);
   $smarty ->assign('registro2',$vreg2);
   $smarty ->assign('nombre',$vnom); 
   $smarty ->assign('vdesest',$vdesest); 
   $smarty ->assign('vest',$vest); 
   $smarty ->assign('vfecsol',$vfecsol); 
   $smarty ->assign('vfecreg',$vfecreg); 
   $smarty ->assign('vfecven',$vfecven); 
   $smarty ->assign('vcodtit',$vcodtit); 
   $smarty ->assign('vcodtn',$vcodtn);
   $smarty ->assign('vnomtit',$vnomtit);
   $smarty ->assign('vcodtitnew',$vcodtitnew); 
   $smarty ->assign('vnomtitnew',$vnomtitnew);
   $smarty ->assign('vnactit',$vnactit); 
   $smarty ->assign('vnadtit',$vnadtit); 
   $smarty ->assign('vcodpai',$vcodpai);
   $smarty ->assign('vnompai',$vnompai);
   $smarty ->assign('vdomtit',$vdomtit); 
   $smarty ->assign('vcodagenew',$vcodagenew);
   $smarty ->assign('vnomagenew',$vnomagenew);
   $smarty ->assign('vtranew',$vtranew); 
   $smarty ->assign('vcodage',$vcodage);
   $smarty ->assign('vnomage',$vnomage);
   $smarty ->assign('vtra',$vtra);
   $smarty ->assign('vfactura',$vfactura); 
   $smarty ->assign('vtipo_id',array(1,2,3)); 
   $smarty ->assign('vtipo_de',array('Cesion','Fusion','Cambio de Titular'));
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lregistro','Registro:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lclase','Estatus:'); 
   $smarty ->assign('ltitular','Titular Actual:'); 
   $smarty ->assign('ltitularnew','Titular Nuevo:'); 
   $smarty ->assign('lfecsol','Fecha Solicitud:'); 
   $smarty ->assign('lfecreg','Fecha Registro:'); 
   $smarty ->assign('lfecven','Fecha Vencimiento:'); 
   $smarty ->assign('ltipo','Tipo de Anotacion:'); 
   $smarty ->assign('lfechaevento','Fecha del Evento:'); 
   $smarty ->assign('ldocumento','Numero de Documento:'); 
   $smarty ->assign('lcomenta','Informacion Adicional:'); 
   $smarty ->assign('ltitular','Titular(es) Actual(es):');
   $smarty ->assign('ltitular2','Titular(es) Final(es):');
   $smarty ->assign('lagenew','Agente Nuevo:'); 
   $smarty ->assign('ltranew','Tramitante Nuevo:'); 
   $smarty ->assign('ltrage','Tramitante/Agente Actual:');
   $smarty ->assign('espacios',''); 

   $smarty->display('m_amcesionex.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
