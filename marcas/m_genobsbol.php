<?
//Desarrollado por Ing. Romulo Mendoza el 05/12/2011 
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
$modulo = 'm_genobsbol.php';
$fechahoy = hoy();

$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces+1;
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'I'); }

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Generaci&oacute;n de Marcas Observadas para el Bolet&iacute;n'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vbol=$_POST['vbol'];
   $cbol=$_POST['cbol'];
   $vtip=$_POST['vtip'];
   $resultado=false;
   
   if ($vopc==2) {
      $vbol =$_GET['v3'];
      $vtip =$_GET['v4'];   }
      
   $sql->connection($login);
   $vtipest=array(1003);
   $vtipsol=array("Observadas");
   
   if ($vopc==3 || $vopc==2) {
            
      if ($vbol=='' || $vtip=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      if ($cbol >= $vbol) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR BOLETINES','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
 
      if ($vopc==3) {
         // Fine
         $obj_query = $sql->query("SELECT max(nro_boletin) FROM stzboletin WHERE generado='S'");
         $objs = $sql->objects('',$obj_query);
         $vbolult = $objs->max;
         if ($vbol<=$vbolult) {
           $smarty->display('encabezado1.tpl');
           mensajenew("ERROR: Bolet&iacute;n '$vbol' ya Generado anteriormente ...!!!","javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();           
         }
      } else { 
        pg_exec("BEGIN WORK"); 
        $sql->del(stztmpbo,"estatus='$vtip' and boletin='$vbol' and tipo='M'");
	     pg_exec("COMMIT WORK"); 
      }
      $traerr=0;
      pg_exec("BEGIN WORK");
      if ($vtip==1003) {
         $resul=pg_exec("SELECT nro_derecho,solicitud FROM stzderec WHERE estatus=1003 AND tipo_mp='M'
                           AND nro_derecho IN (SELECT nro_derecho FROM stzevtrd 
                                               WHERE evento=1124 AND documento='$cbol')");
         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
            $sql->disconnect();
            $smarty->display('encabezado1.tpl');
            mensajenew('ERROR: PROBLEMA AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
            $smarty->display('pie_pag.tpl'); exit(); }
         $horahoy  = hora();
         //echo " hubo= $cantreg en $cbol "; exit();
         $reg = pg_fetch_array($resul); 
         for ($cont=0;$cont<$cantreg;$cont++) {
          $vder=$reg[nro_derecho];
          $vsolh=$reg[solicitud];
          $insert_campos="nro_derecho,solicitud,boletin,estatus,tipo,usuario,
                          fecha_carga,hora_carga,nanota";
          $insert_valores ="$vder,'$vsolh',$vbol,$vtip,'M','$usuario','$fechahoy','$horahoy',0";
          
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbo WHERE solicitud='$vsolh' and 
                               boletin='$vbol' and estatus='$vtip' and tipo='M'");
          $cantfound = pg_numrows($resulfound);
          if ($cantfound==0) {
              $vertra=$sql->insert("stztmpbo","$insert_campos","$insert_valores","");     
              if (!$vertra) {$traerr=$traerr+1;}
          }
          $reg = pg_fetch_array($resul); 
         }
      }	  
      // Mensaje final 
      if ($traerr==0) {
         pg_exec("COMMIT WORK"); $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew("Se Generaron '$cantreg' Solicitudes",'m_genobsbol.php?nveces='.$nveces.'&nconexion='.$nconexion,'S');
         $smarty->display('pie_pag.tpl'); exit();   
      } else {
         pg_exec("ROLLBACK WORK"); $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit();   
      }
      
   }   
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('nveces',$nveces); 
   $smarty ->assign('nconexion',$nconexion);   
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('solicitud3',$vsol3); 
   $smarty ->assign('solicitud4',$vsol4); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest); 
   $smarty ->assign('lsolicitud','Rango de Solicitudes:'); 
   $smarty ->assign('lboletin','Bolet&iacute;n a Generar:');
   $smarty ->assign('cboletin','Observadas del Bolet&iacute;n Vencido:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_genobsbol.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
