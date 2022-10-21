<? 
// Modificado por Ing. Romulo Mendoza 07/06/2010 
// Separacion de Marcas y Registro de Propiedad Industrial
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
$modulo = 'm_bolgenareg.php';
$fechahoy = hoy();

$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces+1;
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'I'); }

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Generaci&oacute;n de Datos de Registro para el Bolet&iacute;n'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vsol1=$_POST['vsoli1'];
   $vsol2=$_POST['vsoli2'];
   $vsol3=$_POST['vsoli3'];
   $vsol4=$_POST['vsoli4'];
   $vbol=$_POST['vbol'];
   $vtip=$_POST['vtip'];
   $vsola=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vsolb=sprintf("%04d-%06d",$vsol3,$vsol4);
   $resultado=false;
   $tipobol=$_POST['aplica'];
   
   if ($vopc==2) {
      $vsola=$_GET['v1'];
      $vsolb=$_GET['v2'];
      $vbol =$_GET['v3'];
      $vtip =$_GET['v4'];   }
      
   $sql->connection($login);
   //$vtipest=array(1101,1390,1102,1025,1750,1209,1208,1207,1206,1205,1204,1913,1800,1801,1802,1803,1804,1805,1806,1807,1808,1809,1821,1822,1823,1824,1825,1830,1831,1833,1835,1836,1837,1838);
   //$vtipsol=array("Concedidas","Concedidas Reclasificadas","Negadas","Prioridad Extinguida","Caducas",
   //"Cambio de Titular","Cambios de Domicilio","Licencias de Uso","Fusiones","Cesiones",
   //"Renovaciones","Registros No Renovados","Ratificacion Estatus 800","Ratificacion Estatus 801","Ratificacion Estatus 802","Ratificacion Estatus 803","Ratificacion Estatus 804",
   //"Ratificacion Estatus 805","Ratificacion Estatus 806","Ratificacion Estatus 807","Ratificacion Estatus 808","Ratificacion Estatus 809","Ratificacion Estatus 821","Ratificacion Estatus 822","Ratificacion Estatus 823","Ratificacion Estatus 824",
   //"Ratificacion Estatus 825","Ratificacion Estatus 830","Ratificacion Estatus 831","Ratificacion Estatus 833","Ratificacion Estatus 835","Ratificacion Estatus 836","Ratificacion Estatus 837","Ratificacion Estatus 838");

   //$vtipest=array(1101,1390,1102,1025,1750,1209,1208,1207,1206,1205,1204,1913,1846);
   //$vtipsol=array("Concedidas","Concedidas Reclasificadas","Negadas","Prioridad Extinguida","Caducas",
   //"Cambio de Titular","Cambios de Domicilio","Licencias de Uso","Fusiones","Cesiones",
   //"Renovaciones","Registros No Renovados","Caducidad por NO Uso");

   $vtipest=array(1101,1102,1025,1750,1209,1208,1207,1206,1205,1204,1913,1846);
   $vtipsol=array("Concedidas","Negadas","Prioridad Extinguida","Caducas",
   "Cambio de Titular","Cambios de Domicilio","Licencias de Uso","Fusiones","Cesiones",
   "Renovaciones","Registros No Renovados","Caducidad por NO Uso");

  
   if ($vopc==3 || $vopc==2) {
      if ($tipobol=='N') {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: DEBE SELECCIONAR EL TIPO DE BOLETIN ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
            
      if ($vsola=='' || $vsolb=='' || $vbol=='' || $vtip=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }

      if ($vsola > $vsolb) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - RANGO INCORRECTO','javascript:history.back();','N');
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
     if ($vtip==1102 || $vtip==1101 || $vtip==1390 || $vtip==1025 || $vtip==1750 || $vtip==1800 || $vtip==1801 || $vtip==1802 || $vtip==1803 || $vtip==1804 ||
         $vtip==1805 || $vtip==1806 || $vtip==1807 || $vtip==1808 || $vtip==1809 || $vtip==1821 || $vtip==1822 || $vtip==1823 || $vtip==1824 || $vtip==1825 || $vtip==1830 ||       
         $vtip==1831 || $vtip==1833 || $vtip==1835 || $vtip==1836 || $vtip==1837 || $vtip==1838 || $vtip==1913 || $vtip==1846) {

         //echo "est=$vtip";
         $resul=pg_exec("SELECT nro_derecho,solicitud FROM stzderec WHERE solicitud 
                         between '$vsola' and '$vsolb' and estatus='$vtip' and tipo_mp='M'");
         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
            $sql->disconnect();
            $smarty->display('encabezado1.tpl');
            mensajenew('ERROR: No Existen Solicitudes Asociadas','javascript:history.back();','N');
            $smarty->display('pie_pag.tpl'); exit(); }
         $horahoy  = hora();
         $reg = pg_fetch_array($resul); 
         for ($cont=0;$cont<$cantreg;$cont++) {
          $vder=$reg[nro_derecho];
          $vsolh=$reg[solicitud];
          $insert_campos="nro_derecho,solicitud,boletin,estatus,tipo,usuario,
                          fecha_carga,hora_carga,nanota,tipo_boletin";
          $insert_valores ="$vder,'$vsolh',$vbol,$vtip,'M','$usuario','$fechahoy','$horahoy',0,'$tipobol'";
          
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbo WHERE solicitud='$vsolh' and 
                               boletin='$vbol' and estatus='$vtip' and tipo='M' AND tipo_boletin='$tipobol'");
          $cantfound = pg_numrows($resulfound);
          if ($cantfound==0) {
              $vertra=$sql->insert("stztmpbo","$insert_campos","$insert_valores","");     
              if (!$vertra) {$traerr=$traerr+1;}
          }
          $reg = pg_fetch_array($resul); }
      } else {
         $resul=pg_exec("SELECT distinct on (solicitud,tipo,evento,nanota)
                                nro_derecho,solicitud,nanota FROM stzantma 
                          WHERE solicitud between '$vsola' and '$vsolb' and evento='$vtip' 
                                and tipo='M' and verificado='S'");
         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
            $sql->disconnect(); 
            $smarty->display('encabezado1.tpl');
            mensajenew('ERROR: PROBLEMAS AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
            $smarty->display('pie_pag.tpl'); exit(); }
         $horahoy  = hora();
         $reg = pg_fetch_array($resul); 
         for ($cont=0;$cont<$cantreg;$cont++) {
          $vder=$reg[nro_derecho];
          $vsolh=$reg[solicitud];
	       $vnan=$reg[nanota];
          $insert_campos="nro_derecho,solicitud,boletin,estatus,tipo,nanota,usuario,fecha_carga,hora_carga,tipo_boletin";
          $insert_valores ="$vder,'$vsolh',$vbol,$vtip,'M',$vnan,'$usuario','$fechahoy','$horahoy','$tipobol'";
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbo WHERE solicitud='$vsolh' AND boletin='$vbol' AND estatus='$vtip' AND tipo='M' AND nanota=$vnan AND tipo_boletin='$tipobol'");
          $cantfound = pg_numrows($resulfound);
          if ($cantfound==0) {
              $vertra=$sql->insert("stztmpbo","$insert_campos","$insert_valores","");     
	      if (!$vertra) {$traerr=$traerr+1;}
          }
          $reg = pg_fetch_array($resul); }
      }	  
      // Mensaje final 
      if ($traerr==0) {
         pg_exec("COMMIT WORK"); $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew("Se Generaron '$cantreg' Solicitudes",'m_bolgenareg.php?nveces='.$nveces.'&nconexion='.$nconexion,'S');
         $smarty->display('pie_pag.tpl'); exit();   
      } else {
         pg_exec("ROLLBACK WORK"); $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit();   
      }
      
   }   
   //Asignacion de variables para pasarlas a Smarty
   $smarty->assign('apli_inf',array('N','O','E'));
   $smarty->assign('apli_def',array('--- Seleccione Tipo Bolet&iacute;n ---','Ordinario','Extraordinario'));
   $smarty ->assign('nveces',$nveces); 
   $smarty ->assign('nconexion',$nconexion);   
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('solicitud3',$vsol3); 
   $smarty ->assign('solicitud4',$vsol4); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('aplica',$tipobol);
   $smarty ->assign('vtipest',$vtipest);
   $smarty ->assign('aplica',$tipobol);
   $smarty ->assign('lsolicitud','Rango de Solicitudes:'); 
   $smarty ->assign('lboletin','Bolet&iacute;n:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_bolgenareg.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
