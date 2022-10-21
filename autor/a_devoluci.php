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
$vfec=hoy();  

$smarty ->assign('titulo','Sistema de Derecho de Autor'); 
$smarty ->assign('subtitulo','Devoluci&oacute;n de Solicitudes'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
   
   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vsol=$_POST['vsol'];
   $vfecsol=$_POST['vfecsol'];
   $vtitu=$_POST['vtitu'];
   $vfevh=   $_POST['vfevh'];
   $vcausa1= $_POST['causa1'];  $vcausa2= $_POST['causa2'];  $vcausa3= $_POST['causa3'];  
   $vcausa4= $_POST['causa4'];  $vcausa5= $_POST['causa5'];  $vcausa6= $_POST['causa6'];  
   $vcausa7= $_POST['causa7'];  $vcausa8= $_POST['causa8'];  $vcausa9= $_POST['causa9'];  
   $vcausa10=$_POST['causa10']; $vcausa11=$_POST['causa11']; $vcausa12=$_POST['causa12'];
   $vcausa13=$_POST['causa13']; $vcausa14=$_POST['causa14']; $vcausa15=$_POST['causa15'];
   $vcausa16=$_POST['causa16']; $vcausa17=$_POST['causa17']; $vcausa18=$_POST['causa18'];
   $votro  =$_POST['otro'];
   $vfec=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vsol'); 
   $smarty ->assign('vmodo',''); 
   
   $sql->connection($login);   
   if ($vopc==1) {
      $resultado=pg_exec("SELECT * FROM stdobras WHERE solicitud='$vsol' and solicitud!=''");
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas2.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      
      if (!$resultado) { 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL PROCESAR LA BUSQUEDA','a_devoluci.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS','a_devoluci.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vder=$reg[nro_derecho];
      $vsol=$reg[solicitud];
      $vtitu=$reg[titulo_obra];
      $vtipo=$reg[tipo_obra];
      $vfecsol=$reg[fecha_solic];
      $vesta=$reg[estatus];

      if (($vesta<>1) and ($vesta<>5)) {
         $smarty->display('encabezado1.tpl');
         mensajenew('Solo aplica para Solicitudes en Estatus 1 o 5','a_devoluci.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
    
      $resultado=pg_exec("SELECT * FROM stdobsol WHERE nro_derecho='$vder'");
      $reg= pg_fetch_array($resultado);
      $vdoctit= $reg[titular];
      $resultado=pg_exec("SELECT nombre FROM stzsolic WHERE titular='$vdoctit'"); 
      $reg= pg_fetch_array($resultado);
      $vsolt= $reg[nombre];
 
      if ($vtipo=='OL') {$vtipo='OBRA LITERARIA';}
      if ($vtipo=='OM') {$vtipo='OBRA MUSICAL';}
      if ($vtipo=='OE') {$vtipo='OBRA ESCENICA';}
      if ($vtipo=='AR') {$vtipo='OBRA AUDIOVISUAL Y RADIOFONICA';}
      if ($vtipo=='AV') {$vtipo='ARTE VISUAL';}
      if ($vtipo=='PC') {$vtipo='PROGRAMA DE COMPUTACION Y BASE DE DATOS';}
      if ($vtipo=='AC') {$vtipo='ACTOS Y CONTRATOS';}
      if ($vtipo=='IE') {$vtipo='INTERPRETACIONES Y EJECUCIONES ARTISTICAS';}
      
      $smarty ->assign('lcausadev','Causales de Devoluci&oacute;n:'); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=1");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('luno',    $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=2");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('ldos',    $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=3");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('ltres',   $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=4");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('lcuatro', $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=5");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('lcinco',  $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=6");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('lseis',   $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=7");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('lsiete',  $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=8");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('locho',   $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=9");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('lnueve',  $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=10");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('ldiez',   $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=11");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('lonce',   $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=12");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('ldoce',   $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=13");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('ltrece',  $regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=14");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('lcatorce',$regc[desc_causa]); 
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=15");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('lquince', $regc[desc_causa]);
      $resultadoc=pg_exec("SELECT * FROM stdcoded WHERE cod_causa=16");$regc=pg_fetch_array($resultadoc);
      $smarty ->assign('ldieciseis', $regc[desc_causa]); 
      $smarty ->assign('ldiecisiete', 'Otros:');
   }
   
   if ($vopc==3) {
      if ($vfevh=='' || ($vcausa1=='' and $vcausa2=='' and $vcausa3=='' and 
         $vcausa4=='' and $vcausa5=='' and $vcausa6=='' and $vcausa7=='' and
         $vcausa8=='' and $vcausa9=='' and $vcausa10=='' and $vcausa11=='' and
         $vcausa12=='' and $vcausa13=='' and $vcausa14=='' and $vcausa15=='' and  
         $vcausa16=='' and $votro=='')) {
         $smarty->display('encabezado1.tpl');
         mensajenew("ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS",
                    "javascript:history.back();","N");
	 $smarty->display('pie_pag.tpl'); exit();  
      }
      $esmayor=compara_fechas($vfevh,$vfec);
      if ($esmayor==1) {
         $smarty->display('encabezado1.tpl');
         mensajenew("No se puede cargar un Evento a futuro","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
           
      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE stdobras IN SHARE ROW EXCLUSIVE MODE");
      //Validacion adiconal por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stdobras WHERE solicitud='$vsol'");
      $regsol = pg_fetch_array($resulsol);
      $vesta  = $regsol[estatus];
      $vfecsol= $regsol[fecha_solic];
      $vder=$regsol[nro_derecho];
      if (($vesta==1) || ($vesta==5)) { //Esta bien
      } else {
         $smarty->display('encabezado1.tpl');
         mensajenew("ERROR AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario","javascript:history.back();","N");
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      //$vfecsol=convertir_en_fecha($vfecsol,1);
      $esmayor=compara_fechas($vfecsol,$vfevh);
      if ($esmayor==1) {
         $smarty->display('encabezado1.tpl');
         mensajenew("No se puede cargar un evento previo a la Fecha de la Solicitud","javascript:history.back();","N");
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
         }
               
      $vestfin =7; 
      $vdese='EXPEDIENTE EN EXAMEN DE FORMA';
      pg_exec("BEGIN WORK");

      // Elimina causales anteriores en caso de tener alguna otra devolucion
      $sql->del("stdcaded","nro_derecho='$vder'");
      $sql->del("stdotrde","nro_derecho='$vder'");

      // inserta en Stdcaded
      $ins_de=true;
      if ($vcausa1 =='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',1,'$vfec'","");}
      if ($vcausa2 =='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',2,'$vfec'","");}
      if ($vcausa3 =='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',3,'$vfec'","");}
      if ($vcausa4 =='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',4,'$vfec'","");}
      if ($vcausa5 =='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',5,'$vfec'","");}
      if ($vcausa6 =='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',6,'$vfec'","");}
      if ($vcausa7 =='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',7,'$vfec'","");}
      if ($vcausa8 =='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',8,'$vfec'","");}
      if ($vcausa9 =='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',9,'$vfec'","");}
      if ($vcausa10=='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',10,'$vfec'","");}
      if ($vcausa11=='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',11,'$vfec'","");}
      if ($vcausa12=='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',12,'$vfec'","");}
      if ($vcausa13=='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',13,'$vfec'","");}
      if ($vcausa14=='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',14,'$vfec'","");}
      if ($vcausa15=='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',15,'$vfec'","");}
      if ($vcausa16=='on') {$ins_de=$sql->insert("stdcaded","nro_derecho,cod_causa,fecha_dev",
                                                 "'$vder',16,'$vfec'","");}
      if ($votro<>'') {$ins_de=$sql->insert("stdotrde","nro_derecho,otros","'$vder','$votro'","");}
      // Actualizar Stdobras
      $ins_obras=true;
      pg_exec("LOCK TABLE stdobras IN SHARE ROW EXCLUSIVE MODE");
      $update_str="estatus='$vestfin'";
      $ins_obras=$sql->update("stdobras","$update_str","solicitud='$vsol'");    
                  
      // inserta evento en Stdevtrd
      $ins_evento=true;
      $insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,fecha_trans,
                      usuario,desc_evento,hora";
      $insert_valores="'$vder',500,'$vfevh',$vesta,0,'$vfec',
                     '$vuser','$vdese','$hh'";
      pg_exec("LOCK TABLE stdevtrd IN SHARE ROW EXCLUSIVE MODE");
      $ins_evento= $sql->insert("stdevtrd","$insert_campos","$insert_valores","");	 

      // Mensaje final
      if ($ins_obras and $ins_evento and $ins_de) { 
         pg_exec("COMMIT WORK");  }
      else {
         pg_exec("ROLLBACK WORK");
         mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas!!!",
                    "javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit();    
      }
      $smarty->display('encabezado1.tpl');
      mensajenew("DATOS GUARDADOS CORRECTAMENTE!!!","a_devoluci.php","S");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();   
      
   }   
   //Asignaci� de variables para pasarlas a Smarty
   $smarty ->assign('vopc',$vopc); 
   $smarty ->assign('vsol',$vsol); 
   $smarty ->assign('vsolt',$vsolt); 
   $smarty ->assign('vtitu',$vtitu); 
   $smarty ->assign('vtipo',$vtipo); 
   $smarty ->assign('vfevh',$vfevh); 
   $smarty ->assign('vfec',$vfec); 
   $smarty ->assign('vfecsol',$vfecsol); 
   $smarty ->assign('causa1',$vcausa1); 
   $smarty ->assign('causa2',$vcausa2); 
   $smarty ->assign('causa3',$vcausa3); 
   $smarty ->assign('causa4',$vcausa4); 
   $smarty ->assign('causa5',$vcausa5); 
   $smarty ->assign('causa6',$vcausa6); 
   $smarty ->assign('causa7',$vcausa7); 
   $smarty ->assign('causa8',$vcausa8); 
   $smarty ->assign('causa9',$vcausa9); 
   $smarty ->assign('causa10',$vcausa10); 
   $smarty ->assign('causa11',$vcausa11); 
   $smarty ->assign('causa12',$vcausa12); 
   $smarty ->assign('causa13',$vcausa13); 
   $smarty ->assign('causa14',$vcausa14); 
   $smarty ->assign('causa15',$vcausa15);
   $smarty ->assign('causa16',$vcausa16);  
   $smarty ->assign('uno','01'); 
   $smarty ->assign('dos','02'); 
   $smarty ->assign('tres','03'); 
   $smarty ->assign('cuatro','04'); 
   $smarty ->assign('cinco','05'); 
   $smarty ->assign('seis','06'); 
   $smarty ->assign('siete','07'); 
   $smarty ->assign('ocho','08'); 
   $smarty ->assign('nueve','09'); 
   $smarty ->assign('diez','10'); 
   $smarty ->assign('once','11'); 
   $smarty ->assign('doce','12'); 
   $smarty ->assign('trece','13'); 
   $smarty ->assign('catorce','14'); 
   $smarty ->assign('quince','15');
   $smarty ->assign('dieciseis','16');  
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lfechasolic','Fecha de Solicitud:'); 
   $smarty ->assign('lfechaevent','Fecha del Evento:'); 
   $smarty ->assign('ltitulo','Titulo:');
   $smarty ->assign('ltipo','Tipo de Solicitud:'); 
   $smarty ->assign('lotro','Otro:'); 
   $smarty ->assign('lsolicitante','Solicitante:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('a_devoluci.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
