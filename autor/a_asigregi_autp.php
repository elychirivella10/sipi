<?
// *************************************************************************************
// Programa: a_asigregi_autp.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Realizado Año:  2008
// Modificado Año: 2009 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
//$role = $_SESSION['usuario_rol'];
$hh=hora();
$sql = new mod_db(); 
$fecha=fechahoy(); 
$vannact = date("Y");

$smarty ->assign('titulo','Sistema de Derecho de Autor'); 
$smarty ->assign('subtitulo','Asignaci&oacute;n de Registros'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
   
   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc      = $_GET['vopc'];
   $vsol      = $_POST['vsol'];
   $vfecsol   = $_POST['vfecsol'];
   $vder      = $_POST['vder'];
   $vtitu     = $_POST['vtitu'];
   $vfevh     = $_POST['vfevh'];
   $vfechavig = $_POST['vfechavig'];
   $vregistro = $_POST['vregistro']; 
   $vfec      = hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty->assign('submitbutton','submit'); 
   $smarty->assign('varfocus','formarcas1.vsol'); 
   $smarty->assign('modo',''); 
   $smarty->assign('vmodo','readonly'); 
   $smarty->assign('vmodo1','readonly'); 
   
   $sql->connection($usuario);   
   if ($vopc==1) {
      $resultado=pg_exec("SELECT * FROM stdobras WHERE solicitud='$vsol'");
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas2.vfechavig'); 
      $smarty ->assign('modo','readonly'); 
      $smarty ->assign('vmodo','readonly'); 
      $smarty ->assign('vmodo1',''); 
      
      if (!$resultado) { 
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR AL PROCESAR LA BUSQUEDA','a_asigregi_autp.php','N');
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
        $smarty->display('encabezado1.tpl');
        mensajenew('NO EXISTEN DATOS ASOCIADOS','a_asigregi_autp.php','N');
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vder=$reg[nro_derecho];      
      $vtitu=$reg[titulo_obra];
      $vtipo=$reg[tipo_obra];
      $vfecsol=$reg[fecha_solic];
      $vesta=$reg[estatus];

      if ($vesta<>410) {
        $smarty->display('encabezado1.tpl');
        mensajenew('Solo aplica para Solicitudes en Estatus 410','a_asigregi_autp.php','N');
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
    
      $resultado=pg_exec("SELECT * FROM stdobsol WHERE nro_derecho='$vder'");
      $reg= pg_fetch_array($resultado);
      //$vdoc= $reg[doc_solicita];
      $vtit= $reg[titular];

      //$resultado=pg_exec("SELECT nombre_p FROM stddaper WHERE cedula='$vtit'
      //                    UNION
      //                    SELECT razon_social FROM stddajur WHERE rif='$vtit'"); 
      $resultado=pg_exec("SELECT nombre FROM stzsolic WHERE titular='$vtit'");
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

      // Valor automatico para el siguiente numero de registro

   }
   
   if ($vopc==3) {
      $vregistro=next_sys('nreg_obras');
      if ($vregistro==10328 or $vregistro==73100 or $vregistro==74444) {
         $varcqra=grabar_sys('nreg_obras',$vregistro);
         $vregistro=next_sys('nreg_obras');
      }   
      if ($vfechavig=='' || $vregistro=='') {
        $smarty->display('encabezado1.tpl');
        mensajenew("ERROR !!! Existen campos vacios en el formulario!",
                   "javascript:history.back();","N");
	     $smarty->display('pie_pag.tpl'); exit();  
      }
      $esmayor=compara_fechas($vfechavig,$vfec);
      if ($esmayor==1) {
         $smarty->display('encabezado1.tpl');
         mensajenew("No se puede cargar Fecha de Vigencia a futuro","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
           
      //Validacion adiconal por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stdobras WHERE nro_derecho='$vder'");
      $regsol = pg_fetch_array($resulsol);
      $vesta  = $regsol[estatus];
      $vfecsol= $regsol[fecha_solic];
      if ($vesta==410) { //Esta bien
      } else {
         $smarty->display('encabezado1.tpl');
         mensajenew("ERROR AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario","javascript:history.back();","N");
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      //$vfecsol=convertir_en_fecha($vfecsol,1);
      $esmayor=compara_fechas($vfecsol,$vfechavig);
      if ($esmayor==1) {
        $smarty->display('encabezado1.tpl');
        mensajenew("No se puede cargar Fecha de Vigencia previa a la Fecha de la Solicitud","javascript:history.back();","N");
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      //Validacion de si existe o no en la base de datos el numero de registro asignado ...               
      $resreg=pg_exec("SELECT * FROM stdobras WHERE registro='$vregistro'");
      $filas_reg=pg_numrows($resreg); 
      if ($filas_reg>0) {
        $smarty->display('encabezado1.tpl');
        mensajenew('Nro. de Registro YA EXISTE en la Base de Datos ...!!!','a_asigregi_autp.php','N');
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      
      $vestfin =555; 
      $vdese='REGISTRO DE OBRA';
      pg_exec("BEGIN WORK");

      // Actualizar Stdobras
      $ins_obras=true;
      pg_exec("LOCK TABLE stdobras IN SHARE ROW EXCLUSIVE MODE");
      $update_str="estatus='$vestfin',registro='$vregistro',fecha_regis='$vfechavig'";
      $ins_obras=$sql->update("stdobras","$update_str","solicitud='$vsol'");    

      // incrementa # de registro automatico
      $varcqra=grabar_sys('nreg_obras',$vregistro);
                  
      // inserta evento en Stdevtrd
      $vcomen= "Registro No.: ".$vregistro;
      $ins_evento=true;
      $insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,fecha_trans,
                      usuario,desc_evento,comentario,hora";
      $insert_valores="'$vder',795,'$vfec',410,0,'$vfec',
                     '$vuser','$vdese','$vcomen','$hh'";
      $ins_evento= $sql->insert("stdevtrd","$insert_campos","$insert_valores","");	 

      // Mensaje final
      if ($ins_obras and $ins_evento) { 
         pg_exec("COMMIT WORK");
         // Desconexion de la Base de datos 
         $sql->disconnect();
         
         $smarty->display('encabezado1.tpl');
         Mensajenew("DATOS GUARDADOS CORRECTAMENTE!!! Registro asignado Nro. ".$vregistro,"a_asigregi_autp.php","S");
         $smarty->display('pie_pag.tpl'); exit(); }   
         
      else {
         pg_exec("ROLLBACK WORK");
         // Desconexion de la Base de datos 
         $sql->disconnect();
                
         Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas!!!",
                    "javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit();    
      }
      //$smarty->display('encabezado1.tpl');
      //mensajenew("DATOS GUARDADOS CORRECTAMENTE!!!","a_asigregi_autp.php","S");
      //$smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();   
      
   }   
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('vopc',$vopc); 
   $smarty ->assign('vsol',$vsol); 
   $smarty ->assign('vder',$vder);   
   $smarty ->assign('vder',$vder);
   $smarty ->assign('vsolt',$vsolt); 
   $smarty ->assign('vtitu',$vtitu); 
   $smarty ->assign('vtipo',$vtipo); 
   $smarty ->assign('vfevh',$vfevh); 
   $smarty ->assign('vfec',$vfec);
   $smarty ->assign('vannact',$vannact);
   $smarty ->assign('vfecsol',$vfecsol);  
   $smarty ->assign('vfechavig',$vfechavig); 
   $smarty ->assign('vregistro',$vregistro); 
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lfechasolic','Fecha de Solicitud:'); 
   $smarty ->assign('lfechaevent','Fecha del Evento:'); 
   $smarty ->assign('ltitulo','Titulo:');
   $smarty ->assign('ltipo','Tipo de Solicitud:'); 
   $smarty ->assign('lotro','Otro:'); 
   $smarty ->assign('lsolicitante','Solicitante:'); 
   $smarty ->assign('lfechavig','Fecha de Registro:'); 
   $smarty ->assign('lregistro','Registro No.:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('a_asigregi_autp.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
