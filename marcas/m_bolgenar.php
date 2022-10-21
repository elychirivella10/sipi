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
$modulo = 'm_bolgenar.php';
$fechahoy = hoy();

$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces+1;
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'I'); }

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Generaci&oacute;n de Datos Marcas para el Bolet&iacute;n'); 
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
   $vtipest=array(1002,1023,1024,1030,1006,1200,1116,1003,1011,1910,1914,1125,1130);
   $vtipsol=array("Orden de Publicacion","Perimidas x Publicacion en Prensa Extemporanea","Publicacion Prensa Defectuosa",
   "Perimidas por NO Publicacion Prensa","Solicitadas","Devueltas","Devueltas Fondo","Oposiciones","Oposicion Inadmisible x incumplir Art. 49 Lopa",
   "Desistidas","Desistimiento de Oposiciones por Ley","Desistimiento de Oposiciones",
   "Observacion Mejor Derecho");
   
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
        $sql->del(stztmpbo,"estatus='$vtip' AND boletin='$vbol' AND tipo='M' AND tipo_boletin='$tipobol'");
	pg_exec("COMMIT WORK"); 
      }
      $traerr=0;
      pg_exec("BEGIN WORK");
     if ($vtip==1002 || $vtip==1023 || $vtip==1024 || $vtip==1030 || $vtip==1006 || $vtip==1200 || $vtip==1011 ||  
         $vtip==1116 || $vtip==1003 || $vtip==1910 || $vtip==1914 || $vtip==1125 || $vtip==1130) {
         
       
       if ($vtip!=1130) {
          $resul=pg_exec("SELECT nro_derecho,solicitud FROM stzderec WHERE solicitud 
                          between '$vsola' and '$vsolb' and estatus='$vtip' and tipo_mp='M'");
       }
       if ($vtip==1130) {
          //Desistimiento...
          //$resul=pg_exec("SELECT a.nro_derecho,a.solicitud FROM stzderec a,stzevtrd b WHERE 
          //                a.nro_derecho=b.nro_derecho and a.solicitud between '$vsola' and 
          //                '$vsolb' and a.tipo_mp='M' and a.estatus='$vtip' and b.evento=1047");
          $resul=pg_exec("SELECT nro_derecho,solicitud FROM stzderec WHERE solicitud 
                          between '$vsola' and '$vsolb' and estatus='$vtip' and tipo_mp='M'");
       }
         //echo "SELECT nro_derecho,solicitud FROM stzderec WHERE solicitud 
         //                between '$vsola' and '$vsolb' and estatus='$vtip' and tipo_mp='M'";
         $cantreg = pg_numrows($resul);
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
            mensajenew('ERROR AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
            $smarty->display('pie_pag.tpl'); exit(); }
         $horahoy  = hora();
         $reg = pg_fetch_array($resul); 
         for ($cont=0;$cont<$cantreg;$cont++) {
          $vder=$reg[nro_derecho];
          $vsolh=$reg[solicitud];
	       $vnan=$reg[nanota];
          $insert_campos="nro_derecho,solicitud,boletin,estatus,tipo,nanota,usuario,
                          fecha_carga,hora_carga,tipo_boletin";
          $insert_valores ="$vder,'$vsolh',$vbol,$vtip,'M',
                            $vnan,'$usuario','$fechahoy','$horahoy','$tipobol'";
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
         mensajenew("Se Generaron '$cantreg' Solicitudes",'m_bolgenar.php?nveces='.$nveces.'&nconexion='.$nconexion,'S');
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
   
   $smarty ->assign('nveces',$nveces); 
   $smarty ->assign('nconexion',$nconexion);   
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('solicitud3',$vsol3); 
   $smarty ->assign('solicitud4',$vsol4);
   $smarty ->assign('aplica',$tipobol);
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest); 
   $smarty ->assign('aplica',$tipobol);
   $smarty ->assign('lsolicitud','Rango de Solicitudes:'); 
   $smarty ->assign('lboletin','Bolet&iacute;n:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_bolgenar.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
