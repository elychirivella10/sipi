<? 
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
$fechahoy = hoy();

$smarty ->assign('titulo','Sistema de Patentes'); 
$smarty ->assign('subtitulo','Generacion de Datos para el Boletin de RPI'); 
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
   $vtipest=array(2002,2023,2024,2030,2006,2101,2102,2103,2200,2119,2025,2032,2910,2752,2750,2090,2209,2208,2207,2206,2205,2009,2556,2917,2918,2800,2801,2802,2804,2805,2806,2809,2821,2833,2835,2836,2837,2838,2840,2921,2922);
   $vtipsol=array("Orden de Publicacion","Publicacion Prensa Extemporanea","Publicacion Prensa Defectuosa","Perimidas por NO Publicacion Prensa","Solicitadas","Concedidas","Negadas","Devueltas por Fondo","Devueltas por Forma","Denegadas","Prioridad Extinguida Forma","Prioridad Extinguida Fondo","Desistidas","Sin Efecto por NO Pago de Concesion","Anuladas","Abandonadas","Cambios de Titular","Cambios de Domicilio","Licencias de Uso","Fusiones","Cesiones","Oposiciones","Rehabilitacion","Sin Efecto Falto de Pago","Sin Efecto por Vencimiento","Ratificacion Estatus 800","Ratificacion Estatus 801","Ratificacion Estatus 802","Ratificacion Estatus 804","Ratificacion Estatus 805","Ratificacion Estatus 806","Ratificacion Estatus 809","Ratificacion Estatus 821","Ratificacion Estatus 833","Ratificacion Estatus 835","Ratificacion Estatus 836","Ratificacion Estatus 837","Ratificacion Estatus 838","Ratificacion Estatus 840","Ratificacion Estatus 921","Ratificacion Estatus 922");
   
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
         //Fine
      } else { 
        pg_exec("BEGIN WORK");
        $sql->del(stztmpbo,"estatus='$vtip' and boletin='$vbol' and tipo='P' AND tipo_boletin='$tipobol'");
	pg_exec("COMMIT WORK"); 
      }
      $traerr=0;
      pg_exec("BEGIN WORK");
      if ($vtip==2002 || $vtip==2023 || $vtip==2024 || $vtip==2030
                      || $vtip==2006 || $vtip==2101 || $vtip==2102 || $vtip==2103 || $vtip==2200 
                      || $vtip==2025 || $vtip==2750 || $vtip==2119 || $vtip==2910 || $vtip==2752 
                      || $vtip==2090 || $vtip==2009 || $vtip==2556 || $vtip==2917 || $vtip==2918
                      || $vtip==2800 || $vtip==2801 || $vtip==2802 || $vtip==2804 || $vtip==2805 
                      || $vtip==2806 || $vtip==2809 || $vtip==2821 || $vtip==2833 || $vtip==2835 
                      || $vtip==2836 || $vtip==2837 || $vtip==2838 || $vtip==2840 || $vtip==2921 
                      || $vtip==2922 || $vtip==2032) {
         if ($vtip==2556) {
           $resul=pg_exec("SELECT nro_derecho,solicitud FROM stzderec WHERE solicitud between '$vsola' and '$vsolb' and estatus=2555 and tipo_mp='P' and nro_derecho in (select nro_derecho from stzevtrd where solicitud between '$vsola' and '$vsolb' and evento=2799) and nro_derecho not in (select nro_derecho from stzevtrd where solicitud between '$vsola' and '$vsolb' and evento=2238)"); }
         else {  
         echo "SELECT nro_derecho,solicitud FROM stzderec WHERE solicitud between '$vsola' AND '$vsolb' AND estatus='$vtip' AND tipo_mp='P'";
         $resul=pg_exec("SELECT nro_derecho,solicitud FROM stzderec WHERE solicitud 
                         between '$vsola' AND '$vsolb' AND estatus='$vtip' AND tipo_mp='P'");}
         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
            $sql->disconnect();
            $smarty->display('encabezado1.tpl');
            mensajenew('ERROR: PROBLEMA AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
         $horahoy  = hora();   
         $reg = pg_fetch_array($resul); 
         for ($cont=0;$cont<$cantreg;$cont++) {
          $vder=$reg[nro_derecho];
          $vsolh=$reg[solicitud];
          $insert_campos="nro_derecho,solicitud,boletin,estatus,tipo,usuario,
                          fecha_carga,hora_carga,nanota,tipo_boletin";
          $insert_valores ="$vder,'$vsolh',$vbol,$vtip,'P','$usuario','$fechahoy','$horahoy',0,'$tipobol'";
          
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbo WHERE solicitud='$vsolh' and boletin='$vbol' and estatus='$vtip' and tipo='P' AND tipo_boletin='$tipobol'");
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
                                and tipo='P' and verificado='S'");
         $cantreg = pg_numrows($resul);
         if ($cantreg==0) {
            $sql->disconnect();
            $smarty->display('encabezado1.tpl');
            mensajenew('ERROR AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas o Anotaciones Verificadas','javascript:history.back();','N');
            $smarty->display('pie_pag.tpl'); exit(); }
         $horahoy  = hora();   
         $reg = pg_fetch_array($resul); 
         for ($cont=0;$cont<$cantreg;$cont++) {
          $vder=$reg[nro_derecho];
          $vsolh=$reg[solicitud];
	       $vnan=$reg[nanota];
          $insert_campos="nro_derecho,solicitud,boletin,estatus,tipo,nanota,usuario,
                          fecha_carga,hora_carga,tipo_boletin";
          $insert_valores ="$vder,'$vsolh',$vbol,$vtip,'P',$vnan,'$usuario',
                           '$fechahoy','$horahoy','$tipobol'";
          //No grabar cuando la solicitud exista en el temporal
          $resulfound=pg_exec("SELECT solicitud FROM stztmpbo WHERE solicitud='$vsolh' and boletin='$vbol' and estatus='$vtip' and tipo='P' and nanota=$vnan AND tipo_boletin='$tipobol'");
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
         mensajenew("Se Generaron '$cantreg' Solicitudes",'p_bolgenar.php','S');
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
   $smarty->assign('apli_def',array('--- Seleccione Tipo Boletin ---','Ordinario','Extraordinario'));
   $smarty ->assign('varfocus','forpatentes1.vsol1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('solicitud3',$vsol3); 
   $smarty ->assign('solicitud4',$vsol4); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest);
   $smarty ->assign('aplica',$tipobol);
   $smarty ->assign('lsolicitud','Rango de Solicitudes:'); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('p_bolgenar.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
