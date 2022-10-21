<?
//Modificado por Ing. Romulo Mendoza el 08/06/2010 
//Separacion de Marcas y Registro de Propiedad Industrial 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql = new mod_db();
$vuser = $usuario;
$fecha = fechahoy();
$modulo = 'm_bolgenobs.php';
$fechahoy = hoy();

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Generaci&oacute;n de Datos Marcas Observadas/Caducas por Bolet&iacute;n'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vbol1=$_POST['vbol1'];
   $vbol2=$_POST['vbol2'];
   $vtip=$_POST['vtip'];
   $resultado=false;
   
   if ($vopc==2) {
      $vbol1 =$_GET['v2'];
      $vbol2 =$_GET['v3'];
      $vtip =$_GET['v4'];   }
      
   $sql->connection($login);
   $vtipest=array(1003,1750);
   $vtipsol=array("Observadas","Caducas");
   
   if ($vopc==3 || $vopc==2) {
            
      if ($vbol1=='' || $vbol2=='' || $vtip=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
 
      if ($vopc==3) {
         // Fine
         $obj_query = $sql->query("SELECT max(nro_boletin) FROM stzboletin WHERE generado='S'");
         $objs = $sql->objects('',$obj_query);
         $vbolult = $objs->max;
         if ($vbol2<=$vbolult) {
           $smarty->display('encabezado1.tpl');
           mensajenew("ERROR: Bolet&iacute;n '$vbol2' ya Generado anteriormente ...!!!","javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();           
         }
      } else { 
        pg_exec("BEGIN WORK"); 
        $sql->del(stztmpbo,"estatus='$vtip' and boletin='$vbol2' and tipo='M'");
	pg_exec("COMMIT WORK"); 
      }
      $traerr=0;
      pg_exec("BEGIN WORK");
     if ($vtip==1003 || $vtip==1750) {
         
       if ($vtip==1003) {
         $resul=pg_exec("SELECT nro_derecho,solicitud FROM stzderec WHERE estatus=1003 AND tipo_mp='M'
                           AND nro_derecho IN (SELECT nro_derecho FROM stzevtrd 
                                               WHERE evento IN (1124,1168) AND estat_ant=1006 AND documento='$vbol1')");
       }
       if ($vtip==1750) {
         $resul=pg_exec("SELECT a.nro_derecho,a.solicitud FROM stzderec a,stzevtrd b 
                         WHERE a.tipo_mp='M' AND a.estatus=1750 AND (a.nro_derecho=b.nro_derecho) 
                          AND b.evento IN (1060,1097,1122,1181,1182,1956,1989,1928) 
                          AND b.estat_ant IN (1101,1390,1027,1399,1127,1102,1395,1008,1191) AND b.documento='$vbol1'");       	
       }
         $cantreg = pg_numrows($resul);
         echo "SELECT nro_derecho,solicitud FROM stzderec WHERE estatus=1003 AND tipo_mp='M'
                           AND nro_derecho IN (SELECT nro_derecho FROM stzevtrd 
                                               WHERE evento=1124 AND estat_ant=1006 AND documento='$vbol1')";
         if ($cantreg==0) {
            $sql->disconnect();
            $smarty->display('encabezado1.tpl');
            mensajenew('ERROR AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
            $smarty->display('pie_pag.tpl'); exit(); }
         $horahoy  = hora();
         $reg = pg_fetch_array($resul); 
         for ($cont=0;$cont<$cantreg;$cont++) {
          $vder=$reg[nro_derecho];
          $vsolh=$reg[solicitud];
          $insert_campos="nro_derecho,solicitud,boletin,estatus,tipo,usuario,
                          fecha_carga,hora_carga,nanota,tipo_boletin";
          $insert_valores ="$vder,'$vsolh',$vbol2,$vtip,'M','$usuario','$fechahoy','$horahoy',0,'O'";
          
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbo WHERE solicitud='$vsolh' and 
                               boletin='$vbol2' and estatus='$vtip' and tipo='M'");
          $cantfound = pg_numrows($resulfound);
          if ($cantfound==0) {
              $vertra=$sql->insert("stztmpbo","$insert_campos","$insert_valores","");     
              if (!$vertra) {$traerr=$traerr+1;}
          }
          $reg = pg_fetch_array($resul); }
      } else {
      }	  
      // Mensaje final 
      if ($traerr==0) {
         pg_exec("COMMIT WORK"); $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew("Se Generaron '$cantreg' Solicitudes",'m_bolgenobs.php','S');
         $smarty->display('pie_pag.tpl'); exit();   
      } else {
         pg_exec("ROLLBACK WORK"); $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit();   
      }
      
   }   
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('varfocus','formarcas1.vbol1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest); 
   $smarty ->assign('lboletin1','Solicitudes del Bolet&iacute;n Vencido:'); 
   $smarty ->assign('lboletin2','A Publicar en Bolet&iacute;n:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_bolgenobs.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
