<? 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql = new mod_db();
$fecha=fechahoy();
$hora=hora();

$modulo = 'm_bolactam.php';
$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces+1;
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'M'); }
$smarty ->assign('nveces',$nveces); 
$smarty ->assign('nconexion',$nconexion);  

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Actualizaci&oacute;n de Anotaciones Marginales'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
      
   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vbol=$_POST['vbol'];
   $vtip=$_POST['vtip'];
   $vfbol=$_POST['vfbol'];
   $resultado=false;
   $vfec=hoy();
   
   $sql->connection($login);   
   $vtipest=array(1209,1208,1207,1206,1205,1204);
   $vtipsol=array("Cambios de Titular","Cambios de Domicilio","Licencias de Uso","Fusiones","Cesiones","Renovaciones"); 
   
   if ($vopc==1) {
            
      if ($vbol=='' || $vtip=='' || $vfbol=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back()','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      
      $resulv=pg_exec("SELECT a.nro_derecho,a.solicitud,a.estatus,a.boletin,a.nanota,b.registro,
                              b.fecha_venc,b.estatus as estat 
                         FROM stztmpbo a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho and a.estatus='$vtip' and 
                              a.boletin='$vbol' and tipo='M'");
      $cantreg = pg_numrows($resulv);
      if ($cantreg <= 0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - No existen Datos para Actualizar','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      
      //Actualizacion en tablas maestras
      $can_error=0;
      pg_exec("BEGIN WORK");
      $regv = pg_fetch_array($resulv);
      for ($cont=0;$cont<$cantreg;$cont++) {
          $vsolh   =$regv[solicitud];
          $vderh   =$regv[nro_derecho];
	  $vnan    =$regv[nanota];
	  $vregh   =$regv[registro];
	  $vfecven =$regv[fecha_venc];
	  $vestat  =$regv[estat];
	  //informacion adicional extraida de stzantma
	  $resula=pg_exec("SELECT * FROM stzantma WHERE nro_derecho='$vderh' and evento='$vtip' 
                           and tipo='M' and nanota='$vnan'");
	  $rega = pg_fetch_array($resula);
	  $ctit1=$rega[cod_tit_1];
	  $ctit2=$rega[cod_tit_2];
	  $ageact=$rega[agente];
	  $traact=$rega[tramitante];
	  $nomtitant=trim($rega[nom_tit_1]);
	  $nomtitact=trim($rega[nom_tit_2]);
	  $domact=trim($rega[domicilio]);
	  $nacact=$rega[pais];
          $infadi=$rega[inf_adicional];
	  //identificacion del evento a utilizar
          if ($vtip==1209) {
           $codeve=1853; 
	   $deseve="CAMBIO DE TITULAR PUBLICADO";
	   $vcomen=$deseve." EN BOLETIN ".$vbol.", ".$infadi;}
          if ($vtip==1208) {
           $codeve=1851;  
	   $deseve="CAMBIO DE DOMICILIO PUBLICADO";
	   $vcomen=$deseve." EN BOLETIN ".$vbol.", ".$infadi;}
          if ($vtip==1207) {
           $codeve=1236; 
           $deseve="LICENCIA DE USO PUBLICADA";
           $vcomen=$deseve." EN BOLETIN ".$vbol.", ".$infadi;}
          if ($vtip==1206) {
           $codeve=1233; 
	   $deseve="FUSION DE REGISTRO PUBLICADA";
	   $vcomen=$deseve." EN BOLETIN ".$vbol.", ".$infadi;}
          if ($vtip==1205) {
           $codeve=1232; 
           $deseve="CESION DE REGISTRO PUBLICADA";
	   $vcomen=$deseve." EN BOLETIN ".$vbol.", ".$infadi;}   
          if ($vtip==1204) {
	   //$vfecven=convertir_en_fecha($vfecven,1);
	   if ($vfecven<'05/08/1992' || empty($vfecven)) {$codeve=1850;} else {$codeve=1849;}
	   if (empty($vfecven)) {$fecven='01/01/1990';} 
	   else {//descripcion del evento 
                 $result=pg_exec("SELECT * FROM stzevder WHERE evento='$codeve' and tipo_mp='M'");
                 $regt = pg_fetch_array($result);
                 $plaley=$regt[plazo_ley];
                 $tippla=$regt[tipo_plazo];
	         $fecven=calculo_fechas($vfecven,$plaley,$tippla,'/');}
	   $deseve="RENOVACION DE REGISTRO PUBLICADA";
	   $vcomen=$deseve." EN BOLETIN ".$vbol;}

	  if ($vtip==1204) {
             $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,
                             documento,fecha_trans,usuario,desc_evento,comentario,hora";
             $insert_valores="'$vderh',$codeve,'$vfbol',nextval('stzevtrd_secuencial_seq'),
                             $vestat,'$fecven',$vbol,'$vfec','$vuser','$deseve','$vcomen','$hora'";
	     $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
             if (!$valido) {$can_error = $can_error + 1;} 
          } 
          else {   
             $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,
                             documento,fecha_trans,usuario,desc_evento,comentario,hora";
             $insert_valores="'$vderh',$codeve,'$vfbol',nextval('stzevtrd_secuencial_seq'),$vestat,
                              $vbol,'$vfec','$vuser','$deseve','$vcomen','$hora'";
	     $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
             if (!$valido) {$can_error = $can_error + 1;}
          }
	     
          // actualizaciones demas tablas
	  // fusion - cesion - cambio titular
	  if ($ageact>0) {$traact='';}
	  if ($vtip==1209 || $vtip==1206 || $vtip==1205) {
             // Guardar en stzhotid
             $corrtitur=pg_exec("select * from stzottid where nro_derecho='$vderh'");
             $filcorr = pg_numrows($corrtitur); 
             $regcorr = pg_fetch_array($corrtitur);
             for ($contcorr=0;$contcorr<$filcorr;$contcorr++) {
                 $corrt=$regcorr[titular];
                 $corrn=$regcorr[nacionalidad];
                 $corrd=$regcorr[domicilio];
                 $resold=pg_exec("select * from stzhotid where nro_derecho='$vderh' and 
                                         titular=$corrt and nacionalidad='$corrn' and 
                                         domicilio='$corrd'");
                 $filold = pg_numrows($resold);
                 if ($filold==0) {
                    $insert_campos="nro_derecho,titular,nacionalidad,domicilio";
                    $insert_valores ="'$vderh','$corrt','$corrn','$corrd'";
                    $valido=$sql->insert("stzhotid","$insert_campos","$insert_valores",""); 
                    if (!$valido) {$can_error=$can_error+1;} 
                 } 
                 $regcorr = pg_fetch_array($corrtitur);
             } 
             // Guardar en Stzottid
             $sql->del("stzottid","nro_derecho='$vderh'");
             for ($contcorr2=0;$contcorr2<$vecesantma;$contcorr2++) {
	         $insert_campos="nro_derecho,titular,nacionalidad,domicilio";
                 $insert_valores ="'$vderh','$ctit2','$nacact','$domact'";
                 $valido=$sql->insert("stzottid","$insert_campos","$insert_valores",""); 
                 if (!$valido) {$can_error=$can_error+1;}  
                 $rega = pg_fetch_array($resula);
                 $ctit2=$rega[cod_tit_2];
                 $domact=$rega[domicilio];
                 $nacact=$rega[pais];
	     }
	     // actualiza en stzderec
             pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
	     $update_str = "agente='$ageact',tramitante='$traact'";
             $valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
             if (!$valido) {$can_error=$can_error+1;}
          }	    
	  // cambio domicilio
	  if ($vtip==1208) {
	     // actualiza en stzottid
             pg_exec("LOCK TABLE stzottid IN SHARE ROW EXCLUSIVE MODE");
	     $update_str = "nacionalidad='$nacact',domicilio='$domact'";
             $valido=$sql->update("stzottid","$update_str","nro_derecho='$vderh' and
                                   titular='$ctit1'");
             if (!$valido) {$can_error = $can_error + 1;} 
	     // actualiza en stmmarce
             pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
	     $update_str = "agente='$ageact',tramitante='$traact'";
             $valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
             if (!$valido) {$can_error = $can_error + 1;} 
          }	    
	  // licencia de uso
	  if ($vtip==1207) {
	     // actualiza en stzderec
	     $update_str = "agente='$ageact',tramitante='$traact'";
             $valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
             if (!$valido) {$can_error = $can_error + 1;} 
          }	    
	  // renovaciones
	  if ($vtip==1204) {
	     // actualiza en stzderec
	     $update_str = "fecha_venc='$fecven'";
             $valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
             if (!$valido) {$can_error = $can_error + 1;} 
          }	    
          // eliminar registro de la tabla stzantma
          $sql->del("stzantma","nro_derecho='$vderh' and evento='$vtip' and 
                     tipo='M' and nanota='$vnan'");          
 
          $regv = pg_fetch_array($resulv); 
      } 
      //eliminacion de registros de la tabla stztmpbo
      $sql->del("stztmpbo","estatus='$vtip' and boletin='$vbol' and tipo='M'");

      // Mensaje final 
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("Se Actualizaron '$cantreg' Solicitudes",'m_bolactam.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("Falla de Ingreso en la B.D. Transacciones Abortadas...!!!",
                      "javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();   }

 }      
      
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('varfocus','formarcas2.vbol'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest); 
   $smarty ->assign('vfbol',$vfbol); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('ltipo','Tipo de Anotacion:'); 
   $smarty ->assign('lfechaevent','Fecha del Boletin:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_bolactam.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
