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

$modulo = 'm_bolactlo.php';
$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces+1;
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'M'); }
$smarty ->assign('nveces',$nveces); 
$smarty ->assign('nconexion',$nconexion);

$smarty ->assign('titulo','Sistema de Marcas'); 
$smarty ->assign('subtitulo','Actualizacion de Datos en Lotes del Boletin'); 
$smarty ->assign('login',$usuario);       
$smarty ->assign('fechahoy',$fecha);   
    
   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vbol=$_POST['vbol'];
   $vtip=$_POST['vtip'];
   $vfbol=$_POST['vfbol'];
   $vfvig=$_POST['vfvig'];
   $resultado=false;
   $vfec=hoy();
   
   $sql->connection($login);   
   $vtipest=   array(1002,1023,1024,1030,1006,1101,1390,1200,1116,1003,1025,1750,1910,1914,1125,1130,1913,1996,1102);
   $vtipsol=array("Orden de Publicacion","Publicacion Prensa Extemporanea","Publicacion Prensa Defectuosa","Perimidas por NO Publicacion Prensa","Solicitadas","Concedidas","Concedidas Reclasificadas","Devueltas","Devueltas por Fondo","Observadas","Prioridad Extinguida","Caducas","Desistidas","Desistimiento a Observadas por Ley","Desistimiento de Observaciones","Desistim. Observacion Mejor Derecho","Registros No Renovados","Caducas por no Renovacion","Negadas");
   
   if ($vopc==1) {
            
      if ($vbol=='' || $vtip=='' || $vfbol=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      
      $resulv=pg_exec("SELECT * FROM stztmpbo WHERE estatus='$vtip' and boletin='$vbol' and tipo='M'");
      $cantreg = pg_numrows($resulv);
      if ($cantreg <= 0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - No existen Datos para Actualizar','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      
      //identificacion del evento a utilizar
      if ($vtip==1002) {$codeve=1201; $vcomen="ORDEN DE PUBLICACION NOTIFICADA EN BOLETIN $vbol";}
      if ($vtip==1023) {$codeve=1123; $vcomen="PUBLICACION PRENSA EXTEMPORANEA EN BOLETIN $vbol";}
      if ($vtip==1024) {$codeve=1123; $vcomen="PUBLICACION PRENSA DEFECTUOSA EN BOLETIN $vbol";}
      if ($vtip==1030) {$codeve=1980; $vcomen="PERIMIDA POR NO PUBLICACION PRENSA EN BOLETIN $vbol";}
      if ($vtip==1006) {$codeve=1124; $vcomen="PUBLICADA EN BOLETIN $vbol";}
      if ($vtip==1101) {$codeve=1122; $vcomen="CONCEDIDA EN BOLETIN $vbol";}
      if ($vtip==1390) {$codeve=1122; $vcomen="CONCEDIDA RECLASIFICADA EN BOLETIN $vbol";}
      if ($vtip==1200) {$codeve=1122; $vcomen="DEVUELTA EN BOLETIN $vbol";}
      if ($vtip==1116) {$codeve=1122; $vcomen="DEVUELTA POR FONDO EN BOLETIN $vbol";}
      if ($vtip==1003) {$codeve=1122; $vcomen="OBSERVADA EN BOLETIN $vbol";}
      if ($vtip==1025) {$codeve=1123; $vcomen="PRIORIDAD EXTINGUIDA EN BOLETIN $vbol";}
      if ($vtip==1750) {$codeve=1125; $vcomen="CADUCA EN BOLETIN $vbol";}
      if ($vtip==1910) {$codeve=1123; $vcomen="DESISTIDA EN BOLETIN $vbol";}
      if ($vtip==1914) {$codeve=1251; $vcomen="SOLICITUD DESISTIDA POR LEY EN BOLETIN $vbol";}
      if ($vtip==1125) {$codeve=1121; $vcomen="DESISTIMIENTO DE OBSERVACION BOLETIN $vbol";}
      if ($vtip==1130) {$codeve=1121; $vcomen="DESISTIMIENTO DE OBSERVACION POR MEJOR DERECHO BOLETIN $vbol";}
      if ($vtip==1913) {$codeve=1855; $vcomen="REGISTRO NO RENOVADO BOLETIN $vbol";}
      if ($vtip==1996) {$codeve=1847; $vcomen="CADUCA POR NO RENOVACION BOLETIN $vbol";}
      if ($vtip==1102) {$codeve=1062; $vcomen="NEGADA PUBLICADA EN BOLETIN $vbol";}
      
      //descripcion del evento
      $result=pg_exec("SELECT * FROM stzevder WHERE evento='$codeve' and tipo_mp='M'");
      $regt = pg_fetch_array($result);
      $deseve=$regt[descripcion];
      $plaley=$regt[plazo_ley];
      $tippla=$regt[tipo_plazo];
      
      //Estatus final
      if ($vtip!=1130) {
         $resule=pg_exec("SELECT * FROM stzmigrr WHERE evento='$codeve' and 
                                 estatus_ini='$vtip' and tipo_mp='M'");
         $rege = pg_fetch_array($resule);
         $estfin=$rege[estatus_fin];}
      
      //fecha de vencimiento
      $fecven=calculo_fechas($vfvig,$plaley,$tippla,'/');

      //Actualizacion en tablas maestras
      $can_error=0;
      pg_exec("BEGIN WORK");
      $regv = pg_fetch_array($resulv);
      for ($cont=0;$cont<$cantreg;$cont++) {
          $vsolh=$regv[solicitud];
          $vderh=$regv[nro_derecho];

          //Estatus final (solo para los Desistimientos de Observacion por Mejor Derecho)
          if ($vtip==1130) {
            $resule=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vderh' and evento=1040");
            $cantr=pg_numrows($resule);
            if ($cantr==0) {$estfin=1008;}
            if ($cantr>0)  {$estfin=1003;}
          }
          //Estatus final (solo para los Desistimientos de Observacion)
          if ($vtip==1125) {
            $resu40=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vderh' and evento=1040");
            $cant40=pg_numrows($resu40);
            $resu42=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vderh' and evento=1042");
            $cant42=pg_numrows($resu42);
            if ($cant42==$cant40) { $estfin=1008; }
            if ($cant42<$cant40)  { $estfin=1120; $codeve=1120; $deseve="PUBLICADO DESISTIMIENTO DE OBSERVACION / PASA EXAMEN DE FONDO CON OBSERVACION"; }
          }

          if ($fecven=='' || empty($fecven)) {
          $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,
                          fecha_trans,usuario,desc_evento,comentario,hora";
          $insert_valores="'$vderh',$codeve,'$vfbol',nextval('stzevtrd_secuencial_seq'),$vtip,     
                            $vbol,'$vfec','$vuser','$deseve','$vcomen','$hora'";}
          else {
          $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,
                          documento,fecha_trans,usuario,desc_evento,comentario,hora";
          $insert_valores="'$vderh',$codeve,'$vfbol',nextval('stzevtrd_secuencial_seq'),
                            $vtip,'$fecven',$vbol,'$vfec','$vuser','$deseve','$vcomen','$hora'";}

          $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
          if (!$valido) {$can_error = $can_error + 1;}

          // Actualizacion de la Solicitud en stzderec
          if ($fecven=='' || empty($fecven)) {
             $update_str = "estatus='$estfin',fecha_publi='$vfbol'"; }
          else {
             $update_str = "estatus='$estfin',fecha_publi='$vfbol',fecha_venc='$fecven'"; }
	
          pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
          $valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
          if (!$valido) {$can_error = $can_error + 1;}

          $regv = pg_fetch_array($resulv); 
      } 
      //eliminacion de registros de la tabla stztmpbo
      $valido=$sql->del("stztmpbo","estatus='$vtip' and boletin='$vbol' and tipo='M'");
      if (!$valido) {$can_error = $can_error + 1;}
            
      // Mensaje final 
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("Se Actualizaron '$cantreg' Solicitudes",'m_bolactlo.php','S');
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
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('lfechaevent','Fecha del Boletin:');
   $smarty ->assign('lfechavigen','Fecha de Vigencia:');  
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_bolactlo.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
