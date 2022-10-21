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

$smarty ->assign('titulo','Sistema de Patentes'); 
$smarty ->assign('subtitulo','Actualizacion de Anotaciones Marginales'); 
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
   $vtipest=array(2209,2208,2207,2206,2205);
   $vtipsol=array("Cambios de Titular","Cambios de Domicilio","Licencias de Uso","Fusiones","Cesiones"); 
   
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
                              a.boletin='$vbol' and a.tipo='P'");
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
                                  and nanota='$vnan' and tipo='P'");
          $vecesantma=pg_numrows($resula);
	  $rega = pg_fetch_array($resula);
	  $ctit1=$rega[cod_tit_1];
	  $ctit2=$rega[cod_tit_2];
	  $ageact=$rega[agente];
	  $traact=$rega[tramitante];
	  $nomtitant=$rega[nom_tit_1];
	  $nomtitact=$rega[nom_tit_2];
	  $domact=$rega[domicilio];
	  $nacact=$rega[pais];
          $infadi=$rega[inf_adicional];
	  //identificacion del evento a utilizar
          if ($vtip==2209) {
           $codeve=2853; 
	   $deseve="CAMBIO DE TITULAR PUBLICADO";
	   $vcomen=$deseve." EN BOLETIN ".$vbol.", ".$infadi;}
          if ($vtip==2208) {
           $codeve=2851;  
	   $deseve="CAMBIO DE DOMICILIO PUBLICADO";
	   $vcomen=$deseve." EN BOLETIN ".$vbol.", ".$infadi;}
          if ($vtip==2207) {
           $codeve=2210; 
           $deseve="LICENCIA DE USO PUBLICADA";
           $vcomen=$deseve." EN BOLETIN ".$vbol.", ".$infadi;}
          if ($vtip==2206) {
           $codeve=2233; 
	   $deseve="FUSION DE REGISTRO PUBLICADA";
	   $vcomen=$deseve." EN BOLETIN ".$vbol.", ".$infadi;}
          if ($vtip==2205) {
           $codeve=2232; 
           $deseve="CESION DE REGISTRO PUBLICADA";
	   $vcomen=$deseve." EN BOLETIN ".$vbol.", ".$infadi;}   
 
          // inserta evento en stzevtrd
	  if ($vtip==2204) {
             // No aplica Renovaciones para Patentes     
          } else {
            $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,
                            documento,fecha_trans,usuario,desc_evento,comentario,hora";
            $insert_valores="'$vderh',$codeve,'$vfbol',nextval('stzevtrd_secuencial_seq'),
                              $vestat,$vbol,'$vfec','$vuser','$deseve','$vcomen','$hora'";
	    $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");}
            if (!$valido) {$can_error=$can_error+1;}
	     
          // actualizaciones demas tablas
	  // fusion - cesion - cambio titular
	  if ($ageact>0) {$traact='';}
	  if ($vtip==2209 || $vtip==2206 || $vtip==2205) {
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
	  if ($vtip==2208) {
	     // actualiza en stzottid
             pg_exec("LOCK TABLE stzottid IN SHARE ROW EXCLUSIVE MODE");
	     $update_str = "nacionalidad='$nacact',domicilio='$domact'";
             $valido=$sql->update("stzottid","$update_str","nro_derecho='$vderh'");
             if (!$valido) {$can_error=$can_error+1;}

	     // actualiza en stzderec
	     $update_str = "agente='$ageact',tramitante='$traact'";
             $valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
             if (!$valido) {$can_error=$can_error+1;}
          }	    
	  // licencia de uso
	  if ($vtip==2207) {
	     // actualiza en stzderec
	     $update_str = "agente='$ageact',tramitante='$traact'";
             $valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
             if (!$valido) {$can_error=$can_error+1;}
// OJO   Consultar a ver si se llena esta tabla
             // inserta en stzliced
           //  $insert_campos="nro_derecho,licencia,nombre_licen,fecha_licen";
           //  $insert_valores ="'$vderh','$vnan','$nomtitact','$vfbol'";
           //  $valido=$sql->insert("stzliced","$insert_campos","$insert_valores",""); 
           //  if (!$valido) {$can_error=$can_error+1;} 
/////////////
          }
          // Eliminar registro de la tabla stzantma
          $sql->del("stzantma","nro_derecho='$vderh' and evento='$vtip' and tipo='P' and
	                       nanota='$vnan'");

          $regv = pg_fetch_array($resulv); 
      } 
      //eliminacion de registros de la tabla stztmpbo
      $sql->del("stztmpbo","estatus='$vtip' and boletin='$vbol' and tipo='P'");

      // Mensaje final 
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("Se Actualizaron '$cantreg' Solicitudes",'p_bolactam.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else { 
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("Falla de Ingreso en la B.D. Transacciones Abortadas...!!!",
                      "javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();   }
 }      
      
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('varfocus','forpatentes2.vbol'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest); 
   $smarty ->assign('vfbol',$vfbol); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('ltipo','Tipo de Anotacion:'); 
   $smarty ->assign('lfechaevent','Fecha del Boletin:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('p_bolactam.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
