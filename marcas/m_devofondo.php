<?
//=======================================================================================================
//Programa: m_devofondo.php
//Modificado:Por Ing. Romulo Mendoza
//Fecha: 09/01/2012
//=======================================================================================================
 
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Para trabajar con Smarty 
require ("$root_path/include.php");
//Para trabajar con sessiones
require("$root_path/aut_verifica.inc.php");
//LLamadas a funciones de Libreria 
include ("$include_path/libreria.php");
include ("$include_path/library.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$hh=hora();
$sql = new mod_db(); 
$fecha=fechahoy();  

$smarty ->assign('titulo','Sistema de Marcas'); 
$smarty ->assign('subtitulo','Devoluci&oacute;n de Solicitudes de Fondo'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
   
mensajenew('Opcion en Mantenimiento, debe cargar en Examen de Registrabilidad ','../index1.php','N');
$smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 

$vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vsol1=$_POST['vsol1'];
   $vsol2=$_POST['vsol2'];
   $vfecsol=$_POST['vfecsol'];
   $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vnom=$_POST['vnom'];
   $vcla=$_POST['vcla'];
   $vindcla=$_POST['vindcla'];
   $resultado=false;
   
   $vsolh=  $_POST['vsolh'];
   $vfevh=  $_POST['vfevh'];
   $vcausa1=$_POST['causa1'];  $vcausa2=$_POST['causa2'];  $vcausa3=$_POST['causa3'];  $vcausa4=$_POST['causa4'];
   $vcausa5=$_POST['causa5'];  $vcausa6=$_POST['causa6'];  $vcausa7=$_POST['causa7'];  $vcausa8=$_POST['causa8'];
   $vcausa9=$_POST['causa9'];  $vcausa10=$_POST['causa10']; $vcausa11=$_POST['causa11']; $vcausa12=$_POST['causa12'];
   $vcausa13=$_POST['causa13']; $vcausa14=$_POST['causa14']; $vcausa15=$_POST['causa15'];
   $vcausa16=$_POST['causa16'];
   $vcausa17=$_POST['causa17'];
   $votro  =$_POST['otro'];
   $vfec=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('vmodo',''); 
   
   $sql->connection();   
   
   //Verifica si el progrma esta en mantenimiento
   $manphp = vman_php("m_devofondo.php");
   if ($manphp==1) {
     $smarty->display('encabezado1.tpl');
     MensageError('Modulo en Mantenimiento ...!!!','N');
	  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
	}      

   if ($vopc==1) {
      $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$vsol' and solicitud!=''");
   }
   
   if ($vopc==1) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas2.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      
      if (!$resultado) { 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL PROCESAR LA BUSQUEDA','m_devofondo.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS','m_devofondo.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vnom=$reg[nombre];
      $vcla=$reg[clase];
      $vindcla=$reg[ind_claseni];
      $vest=$reg[estatus];
      $vfecsol=$reg[fecha_solic];
      $vmod=$reg[modalidad];
      if ($vmod=='D') {$vmodal='DENOMINATIVA';}
      if ($vmod=='G') {$vmodal='GRAFICA';}
      if ($vmod=='M') {$vmodal='MIXTA';}
      $nameimage=imagen($vsol1,$vsol2); 
      $smarty ->assign('vmod',$vmod); 
      $smarty ->assign('vmodal',$vmodal); 
      $smarty ->assign('nameimage',$nameimage); 
   
      if ($vest==1 || $vest==103 || $vest==123 || $vest==8) { 
         if ($vest==1) {
	    //Descripcion de causales para Devolucion por forma
	    $smarty ->assign('lcausadev','Causales de Devoluci&acute;n - Examen de Forma:'); 
            $smarty ->assign('luno',    'Identificaci&oacute;n Del Peticionario o Tramitante'); 
            $smarty ->assign('ldos',    'Indicar productos/servicios de la Clase'); 
            $smarty ->assign('ltres',   'Anexar copia certif. Documento de la Sociedad'); 
            $smarty ->assign('lcuatro', 'Anexar copia certif. Acta Asamblea Sociedad'); 
            $smarty ->assign('lcinco',  'Anexar Instrum. Poder que acredite represent.'); 
            $smarty ->assign('lseis',   'Anexar copia Solicitud/Registro en otro pa&iacute;s'); 
            $smarty ->assign('lsiete',  'Traducir al Castellano'); 
            $smarty ->assign('locho',   'Indicar correctamente la Clase Internacional'); 
            $smarty ->assign('lnueve',  'Delimitar Productos/Actividades que distingue'); 
            $smarty ->assign('ldiez',   'Anexar 5 Fascimiles 8x8 cms'); 
            $smarty ->assign('lonce',   'Eliminar de la Marca las leyendas gen&eacute;ricas');
            $smarty ->assign('ldoce',   'Efectuar descripci&oacute; detallada de la Etiqueta'); 
            $smarty ->assign('ltrece',  'Indicar tipo de Marca:Producto,Servicio,Nombre'); 
            $smarty ->assign('lcatorce','Excluir del distintivo Productos/Servicios que no son de la Clase'); 
            $smarty ->assign('lquince', 'Indicar la marca a la cual aplicar&aacute; el Lema');   
            $smarty ->assign('ldieciseis', 'Falta la Firma del Solicitante');
            $smarty ->assign('ldiecisiete', 'Anexar lista de productos no mencionados en Planilla');
	 } else {
            //Descripcion de causales para Devolucion por fondo
	    $smarty ->assign('lcausadev','Causales de Devoluci&oacute;n - Examen de Fondo:'); 
            $smarty ->assign('luno',    'Identificaci&oacute;n del Peticionario o Tramitante'); 
            $smarty ->assign('ldos',    'Indicar productos/servicios de la Clase'); 
            $smarty ->assign('ltres',   'Anexar copia certif. Documento de la Sociedad'); 
            $smarty ->assign('lcuatro', 'Anexar copia certif. Acta Asamblea Sociedad'); 
            $smarty ->assign('lcinco',  'Anexar Instrum. Poder que acredite represent.'); 
            $smarty ->assign('lseis',   'Anexar copia 1era Solicitud en otro pa&iacute;s'); 
            $smarty ->assign('lsiete',  'Traducir al Castellano'); 
            $smarty ->assign('locho',   'Indicar correctamente la Clase Internacional'); 
            $smarty ->assign('lnueve',  'Delimitar Productos/Actividades que distingue');
            $smarty ->assign('ldiez',   'Anexar 5 Fascimiles 8x8 cms'); 
            $smarty ->assign('lonce',   'Eliminar de la Marca las leyendas gen&eacute;ricas');
            $smarty ->assign('ldoce',   'Efectuar descripci&oacute; detallada de la Etiqueta'); 
            $smarty ->assign('ltrece',  'Indicar tipo de Marca:Producto,Servicio,Nombre'); 
            $smarty ->assign('lcatorce','Excluir del distintivo Productos/Servicios que no son de la Clase'); 
            $smarty ->assign('lquince', 'Indicar la marca a la cual aplicar&aacute; el Lema');   
            $smarty ->assign('ldieciseis', 'Falta la Firma del Solicitante');
            $smarty ->assign('ldiecisiete', 'Anexar lista de productos no mencionados en Planilla');
	 } 
      }  ELSE {
         $smarty->display('encabezado1.tpl');
         mensajenew('Solo Aplica en Solicitudes que tengan Estatus: 1, 103, 123 u 8','m_devofondo.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
   }
   
   if ($vopc==3) {
      if ($vcausa1 =='on') {$vc1 ='X';}
      if ($vcausa2 =='on') {$vc2 ='X';}
      if ($vcausa3 =='on') {$vc3 ='X';}
      if ($vcausa4 =='on') {$vc4 ='X';}
      if ($vcausa5 =='on') {$vc5 ='X';}
      if ($vcausa6 =='on') {$vc6 ='X';}
      if ($vcausa7 =='on') {$vc7 ='X';}
      if ($vcausa8 =='on') {$vc8 ='X';}
      if ($vcausa9 =='on') {$vc9 ='X';}
      if ($vcausa10=='on') {$vc10='X';}
      if ($vcausa11=='on') {$vc11='X';}
      if ($vcausa12=='on') {$vc12='X';}
      if ($vcausa13=='on') {$vc13='X';}
      if ($vcausa14=='on') {$vc14='X';}
      if ($vcausa15=='on') {$vc15='X';}
      if ($vcausa16=='on') {$vc16='X';}
      if ($vcausa17=='on') {$vc17='X';}
      $allcausas = $vc1.$vc2.$vc3.$vc4.$vc5.$vc6.$vc7.$vc8.$vc9.$vc10.$vc11.$vc12.$vc13.$vc14.$vc15.$vc16.$vc17.$votro;
      if ($vsolh=='-' || $vfevh=='' || $allcausas=='') {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit();  
      }
      $esmayor=compara_fechas($vfevh,$vfec);
      if ($esmayor==1) {
         $smarty->display('encabezado1.tpl');
         mensajenew('No se puede cargar un Evento a futuro','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
           
      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE stmmarce IN SHARE ROW EXCLUSIVE MODE");
      //Validacion adiconal por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stmmarce WHERE solicitud='$vsolh' and solicitud!=''");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      $vfecsol= $regsol[fecha_solic];
      if ($vest==1 || $vest==103 || $vest==123 || $vest==8) { //Esta bien
      } else {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario','m_devoluci.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      //$vfecsol=convertir_en_fecha($vfecsol,1);
      $esmayor=compara_fechas($vfecsol,$vfevh);
      if ($esmayor==1) {
         $smarty->display('encabezado1.tpl');
         mensajenew('No se puede cargar un evento previo a la Fecha de la Solicitud','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
         }
               
      // Evento Cableado (500) se presume que los estatus finales son:
      if ($vest ==1)   {$vestfin =200; $vtipdev='1'; $vdese='SOLICITUD EN EXAMEN DE FORMA';}
      if ($vest ==103) {$vestfin =116; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      if ($vest ==123) {$vestfin =117; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      //if ($vest ==8)   {$vestfin =200; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      if ($vest ==8)   {$vestfin =116; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      
      // inserta en Stmcaded
      $insert_campos="solicitud,oficio_dev,fecha_dev,causa_01,causa_02,causa_03,causa_04,causa_05,causa_06,causa_07,causa_08,causa_09,causa_10,causa_11,causa_12,causa_13,causa_14,causa_15,causa_16,causa_17,otros,tipo_dev";
      $insert_valores="'$vsolh',' ','$vfevh','$vc1','$vc2','$vc3','$vc4','$vc5','$vc6','$vc7','$vc8','$vc9','$vc10','$vc11','$vc12','$vc13','$vc14','$vc15','$vc16','$vc17','$votro','$vtipdev'";
      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE stmcaded IN SHARE ROW EXCLUSIVE MODE");
      $sql->insert("stmcaded","$insert_campos","$insert_valores","");	 
      pg_exec("COMMIT WORK"); 
      
      // Actualizar Stmmarce
      $update_str="estatus='$vestfin'";
      $sql->update("stmmarce","$update_str","solicitud='$vsolh'");    
      pg_exec("COMMIT WORK"); 
            
      // inserta evento en Stmevtrd
      //pg_exec("BEGIN WORK");
      //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
      //$sys_actual = next_sys("msecuencial");
      //$vsecuencial = grabar_sys("msecuencial",$sys_actual);
      //pg_exec("COMMIT WORK"); 

      //Carga del Evento 53
      $insert_campos="solicitud,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
      $insert_valores ="'$vsolh',53,'$vfevh',nextval('stmevtrd_secuencial_seq'),'$vest',0,'$vfec','$vuser','$vdese','$hh'";
      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE stmevtrd IN SHARE ROW EXCLUSIVE MODE");
      $sql->insert("stmevtrd","$insert_campos","$insert_valores","");	 
      pg_exec("COMMIT WORK"); 
      
      //Carga del Evento 500   
      $insert_campos="solicitud,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
      $insert_valores ="'$vsolh',500,'$vfevh',nextval('stmevtrd_secuencial_seq'),103,0,'$vfec','$vuser','$vdese','$hh'";
      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE stmevtrd IN SHARE ROW EXCLUSIVE MODE");
      $sql->insert("stmevtrd","$insert_campos","$insert_valores","");	 
      pg_exec("COMMIT WORK"); 
      
      // Mensaje final
      $smarty->display('encabezado1.tpl');
      mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_devofondo.php','S');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();   
      
   }   
   //Asignaci� de variables para pasarlas a Smarty
   $smarty ->assign('vopc',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('nombre',$vnom); 
   $smarty ->assign('clase',$vcla); 
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
   $smarty ->assign('causa17',$vcausa17); 

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
   $smarty ->assign('diecisiete','17');
   if ($vindcla=="I") {$smarty ->assign('ind_claseni','INTERNACIONAL');}; 
   if ($vindcla=="N") {$smarty ->assign('ind_claseni','NACIONAL');}; 
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lfechasolic','Fecha de Solicitud:'); 
   $smarty ->assign('lfechaevent','Fecha del Evento:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lclase','Clase:'); 
   $smarty ->assign('lotro','Otro:'); 
   $smarty ->assign('lmodal','Modalidad:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   
   $smarty ->display('m_devofondo.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
