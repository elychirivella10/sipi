<?php 
ob_start();
?> 
<script language="Javascript"> 
 function browsetitularp(var1,var2,var3,var4) {
   open("act_titulard.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip=M","Ventana", "width=2,height=2,left=511,top=300, scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
</script>

<?
include ("../z_includes.php");

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
$tbname_10 = "stmfactura";

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Anotaciones Marginales - Cambio de Domicilio del Titular'); 
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
   $vtipo=$_POST['vtipo'];
   $vdomnew=$_POST['vdomnew'];
   $vcomenta=$_POST['vcomenta'];
   $smarty ->assign('vfecven',$vfecven); 
   $vtra=$_POST['vtra'];
   $vcodagen=$_POST['vcodagen'];
   $vnomagen=$_POST['vnomagen'];
   $vtranew=$_POST['vtranew'];
   $vsolh=  $_POST['vsolh'];
   $vderh=  $_POST['vderh'];
   $vregh=  $_POST['vregh'];
   $vnacnew=$_POST['vnacnew'];
   $vnomagenew=$_POST['options'];
   $vfactura = trim($_POST['vfactura']);
   $fechafac = trim($_POST['fac_fecha']);

        
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
         mensajenew('ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!','m_amcamdomv.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','m_amcamdomv.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vsolh=$reg[solicitud];
      $vderh=$reg[nro_derecho];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vreg=ltrim(rtrim($reg[registro]));
      $vreg1=substr($vreg,-8,1);
      $vreg2=substr($vreg,1);
      $vnom=$reg[nombre];
      $vest=$reg[estatus];
      $vfecsol=$reg[fecha_solic];
      $vfecreg=$reg[fecha_regis];
      $vfecven=$reg[fecha_venc];
      $vcodage=$reg[agente];
      $vtra=$reg[tramitante];
      
      if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      }
      
      if ($vreg!='') { //Esta bien 
      }  ELSE {
         $sql->disconnect();
         mensajenew('ERROR: Solo aplica a MARCAS con REGISTRO ASIGNADO ...!!!','m_amcamdomv.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
      // Descripcon del estatus 
      $resulest=pg_exec("SELECT * FROM stzstder WHERE estatus='$vest' and tipo_mp='M'");
      $regest = pg_fetch_array($resulest);
      $vest=$vest-1000; 
      $vdesest=$regest[descripcion];
      
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
          $vnomt=$regnom[nombre];
          $insert_campos="solicitud,titular,nombre,nacionalidad,domicilio,tipo_mp";
          $insert_valores ="'$vsolh',$vtit,'$vnomt','$vnac','$vdom','M'";
          $sql->insert("temptitu","$insert_campos","$insert_valores","");
          $rego=pg_fetch_array($reso);
      }
   }   
      
   if ($vopc==3) {
      // Validaciones iniciales
      if ($vsolh=='-' || $vregh=='' || $vcomenta=='' || $vdoc=='' || $vfevh=='') {
        $sql->disconnect();
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - DATOS INCORRECTOS O VACIOS ...!!!','m_amcamdomv.php','N');
	     $smarty->display('pie_pag.tpl'); exit(); 
	 }
	 
	   if (empty($vfactura)) { 
         $sql->disconnect();
         mensajenew('ERROR: DEBE COLOCAR EL NUMERO DE LA FACTURA ...!!!','m_amcamdomv.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
	   }

	   if (empty($fechafac)) { 
         $sql->disconnect();
         mensajenew('ERROR: DEBE COLOCAR LA FECHA DE LA FACTURA ...!!!','m_amcamdomv.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
	   }
	 
      //$vfecsol=convertir_en_fecha($vfecsol,1); 
      $esmayor=compara_fechas($vfecsol,$vfec);
      if ($esmayor==1) {
        $sql->disconnect();
        mensajenew('ERROR: No se puede cargar un evento previo a la Fecha de la Solicitud ...!!!','m_amcamdomv.php','N');
	     $smarty->display('pie_pag.tpl'); exit(); 
      }

      $nfac=0;
      $nfac = 'FA'.$vfactura;
      $obj_query = $sql->query("SELECT * FROM $tbname_10 WHERE nro_factura='$nfac'");
      $obj_filas = $sql->nums('',$obj_query);
      if ($obj_filas!=0) {
        mensajenew('ERROR: Factura '.$nfactura.' YA usado anteriormente en otro Servicio ...!!!','m_amcamdomv.php','N');
        $smarty->display('pie_pag.tpl'); exit(); }
      $vcomenta = trim($vcomenta). ". "."S/Factura No.: ".$nfac." "."De Fecha: ".$fechafac; 
      
      $vcodeven=1208; $vdeseven='SOLICITUD CAMBIO DE DOMICILIO DEL TITULAR';
      $cant_error=0;
      pg_exec("BEGIN WORK");           
      // Inserta en Stmevtrd
      $resule=pg_exec("select * from stzevtrd where nro_derecho='$vderh' and 
                       evento='$vcodeven' and documento='$vdoc'");
      $rege = pg_fetch_array($resule);
      $cantfil = pg_numrows($resule);
      if ($cantfil>0) {
         $sql->disconnect();
         mensajenew('ERROR - El Evento ya fue Cargado ...!!!','m_amcamdomv.php','N');
         $smarty->display('pie_pag.tpl'); exit(); 
      }
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,
                      usuario,desc_evento,comentario,hora";
      $insert_valores ="'$vderh','$vcodeven','$vfevh',nextval('stzevtrd_secuencial_seq'),
                        $vest+1000,$vdoc,'$vfec','$vuser','$vdeseven','$vcomenta','$hh'";
      $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
      if (!$valido) {$cant_error=$cant_error+1;}
    
      // Guardar Tabla Nueva para posteriores actualizaciones
        $vagenf=0; $vtraf='';
        if ($vcodagen!='') { $vagenf=$vcodagen; $vtraf='';}
        if ($vcodagen=='') { if ($vtranew!='') {$vagenf=0; $vtraf=$vtranew;} }  
        if ($vagenf>0) {
           $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vagenf");
           $regage = pg_fetch_array($resulage);
           $vtraf=$regage[nombre];}            
      
      // Verificacion del Cambio de domicilio a alguno de los titulares
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
         { $vcomen=$vcomen.'Titular: '.trim($tempnom).' Domicilio: '.$tempnac.'-'.trim($tempdom).' ';
           $vcodtit=$temptit;
           $vnomtit=$tempnom;
           $vnacnew=$tempnac;
           $vdomnew=$tempdom;
           // Forzo la salida para agarrar solo la primera ocurrencia
           // ya que solo puede cambiar de Domicilio solo un titular por Anotacion Marginal
           $contobj=$numco;
         }
         $regco=pg_fetch_array($resco);
       }
       if ($vcomen=='') {
         pg_exec("ROLLBACK WORK"); 
         $sql->disconnect();
         mensajenew('ERROR: No realizo ningun Cambio de Domicilio ...!!!','m_amcamdomv.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
       } 
      if (ltrim(rtrim($vagenf))=='') {$vagenf=0;} 
      $insert_campos="nro_derecho,nanota,solicitud,tipo,evento,cod_tit_1,nom_tit_1,
                      domicilio,pais,tramitante,agente,verificado,inf_adicional,cod_tit_2";
      $insert_valores ="$vderh,$vdoc,'$vsolh','M',$vcodeven,$vcodtit,'$vnomtit',
                       '$vdomnew','$vnacnew','$vtraf',$vagenf,'N','$vcomen',0";
      $valido=$sql->insert("stzantma","$insert_campos","$insert_valores","");
      if (!$valido) {$cant_error=$cant_error+1;} 
      
      $insfactu   = true;
      $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede,tipo_anotamar";
      $insert_str = "'$nfac','$fechafac',0,0,0,'$sede','D'";  
      $insfactu   = $sql->insert("$tbname_10","$col_campos","$insert_str","");
      if (!$insfactu) { $can_error = $can_error + 1; }
      
      // Mensaje final 
      if ($cant_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_amcamdomv.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           mensajenew("ERROR: Falla de Ingreso en la B.D. Transacciones Abortadas...!!!","m_amcamdomv.php","N");
           $smarty->display('pie_pag.tpl'); exit();   } 
   }
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('vsol',$vsol);
   $smarty ->assign('vderh',$vderh);
   $smarty ->assign('vregh',$vregh);
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
   $smarty ->assign('vnompai',$vnompai);
   $smarty ->assign('vcodpai',$vcodpai);
   $smarty ->assign('vnomtit',$vnomtit);
   $smarty ->assign('vdomtit',$vdomtit); 
   $smarty ->assign('vnactit',$vnactit); 
   $smarty ->assign('vnadtit',$vnadtit); 
   $smarty ->assign('vcomenta',$vcomenta);
   $smarty ->assign('vcodagenew',$vcodagenew);
   $smarty ->assign('vnomagenew',$vnomagenew);
   $smarty ->assign('vtranew',$vtranew); 
   $smarty ->assign('vcodage',$vcodage);
   $smarty ->assign('vnomage',$vnomage);
   $smarty ->assign('vtra',$vtra);
   $smarty ->assign('vfactura',$vfactura);
   $smarty ->assign('fac_fecha',$fechafac); 

   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lregistro','Registro:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lclase','Estatus:'); 
   $smarty ->assign('lfecsol','Fecha Solicitud:'); 
   $smarty ->assign('lfecreg','Fecha Registro:'); 
   $smarty ->assign('lfecven','Fecha Vencimiento:'); 
   $smarty ->assign('lfechaevento','Fecha del Evento:'); 
   $smarty ->assign('ldocumento','Numero de Documento:'); 
   $smarty ->assign('lcomenta','Informacion Adicional:'); 
   $smarty ->assign('ltitular','Titular(es) Actual(es):');
   $smarty ->assign('ltitular2','Titular(es) con Nuevo Domicilio:');
   $smarty ->assign('ltrage','Tramitante/Agente Actual:'); 
   $smarty ->assign('lagenew','Agente Nuevo:'); 
   $smarty ->assign('ltranew','Tramitante Nuevo:'); 
   $smarty ->assign('lfactura','N&uacute;mero de Factura:');
   $smarty ->assign('lfechafactura','Fecha de la Factura:'); 
    
   $smarty ->assign('espacios',''); 
   $smarty->display('m_amcamdomv.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
