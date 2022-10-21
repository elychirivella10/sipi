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
   $vtipest=array(2002,2023,2024,2030,2006,2101,2102,2103,2200,2119,2025,2910,2752,2750,2090,2009,2556,2917,2918,2800,2801,2802,2804,2805,2806,2809,2821,2833,2835,2836,2837,2838,2840,2921,2922);
   $vtipsol=array("Orden de Publicacion","Publicacion Prensa Extemporanea","Publicacion Prensa Defectuosa","Perimidas por NO Publicacion Prensa","Solicitadas","Concedidas","Negadas","Devueltas por Fondo","Devueltas por Forma","Denegadas","Prioridad Extinguida","Desistidas","Sin Efecto por NO Pago de Derechos Concesion","Anuladas","Abandonadas","Oposiciones","Rehabilitacion","Sin Efecto por Falta de Pago","Sin Efecto por Vencimiento","Ratificacion Estatus 800","Ratificacion Estatus 801","Ratificacion Estatus 802","Ratificacion Estatus 804","Ratificacion Estatus 805","Ratificacion Estatus 806","Ratificacion Estatus 809","Ratificacion Estatus 821","Ratificacion Estatus 833","Ratificacion Estatus 835","Ratificacion Estatus 836","Ratificacion Estatus 837","Ratificacion Estatus 838","Ratificacion Estatus 840","Ratificacion Estatus 921","Ratificacion Estatus 922");
   
   if ($vopc==1) {
            
      if ($vbol=='' || $vtip=='' || $vfbol=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      
      $resulv=pg_exec("SELECT * FROM stztmpbo WHERE estatus='$vtip' and boletin='$vbol' and tipo='P' ORDER BY solicitud");
      $cantreg = pg_numrows($resulv);
      if ($cantreg <= 0) {
         $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL INTENTAR PROCESAR - No existen Datos para Actualizar','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      
      //identificacion del evento a utilizar
      if ($vtip==2002) {$codeve=2201; $vcomen="ORDEN DE PUBLICACION NOTIFICADA EN BOLETIN $vbol";}
if ($vtip==2023) {$codeve=2123; $vcomen="PUBLICACION PRENSA EXTEMPORANEA EN BOLETIN $vbol";}
if ($vtip==2024) {$codeve=2123; $vcomen="PUBLICACION PRENSA DEFECTUOSA EN BOLETIN $vbol";}
if ($vtip==2030) {$codeve=2980; $vcomen="PERIMIDA POR NO PUBLICACION PRENSA EN BOLETIN $vbol";}
      if ($vtip==2006) {$codeve=2124; $vcomen="PUBLICADA EN BOLETIN $vbol";}
      if ($vtip==2101) {$codeve=2122; $vcomen="CONCEDIDA EN BOLETIN $vbol";}
      if ($vtip==2102) {$codeve=2123; $vcomen="PUBLICACION DE SITUACION ADMINISTRATIVA (15 DIAS HABILES) / NEGADA EN BOLETIN $vbol";}
      if ($vtip==2103) {$codeve=2126; $vcomen="DEVUELTA EN BOLETIN $vbol";}
      if ($vtip==2200) {$codeve=2122; $vcomen="DEVUELTA EN BOLETIN $vbol";}
      if ($vtip==2025) {$codeve=2123; $vcomen="PRIORIDAD EXTINGUIDA EN BOLETIN $vbol";}
      if ($vtip==2910) {$codeve=2125; $vcomen="DESISTIDA BOLETIN $vbol";}
      if ($vtip==2750) {$codeve=2122; $vcomen="ANULADA BOLETIN $vbol";}
      if ($vtip==2752) {$codeve=2123; $vcomen="PATENTE SIN EFECTO POR FALTA DE PAGO DE LOS DERECHOS DE REGISTRO, PUBLICADA EN BOLETIN $vbol";}
      if ($vtip==2090) {$codeve=2122; $vcomen="ABANDONADA BOLETIN $vbol";}
      if ($vtip==2119) {$codeve=2123; $vcomen="DENEGADA BOLETIN $vbol";}
      if ($vtip==2009) {$codeve=2126; $vcomen="CON OPOSICION BOLETIN $vbol";}
      if ($vtip==2556) {$codeve=2238; $vcomen="PATENTE REHABILITADA, PUBLICADA EN BOLETIN $vbol";}
      if ($vtip==2917) {$codeve=2123; $vcomen="PATENTE SIN EFECTO POR FALTA DE PAGO DE ANUALIDAD, PUBLICADA EN BOLETIN $vbol";}
      if ($vtip==2918) {$codeve=2123; $vcomen="PATENTE SIN EFECTO POR VENCIMIENTO DE TERMINO, PUBLICADA EN BOLETIN $vbol";}
      
      if (($vtip==2800) || ($vtip==2801) || ($vtip==2802) || ($vtip==2804) || ($vtip==2805) || ($vtip==2806) || ($vtip==2809) ||
          ($vtip==2821) || ($vtip==2833) || ($vtip==2835) || ($vtip==2836) || ($vtip==2837) || ($vtip==2838) || ($vtip==2840) ||
          ($vtip==2921) || ($vtip==2922)) {
        $codeve=2195; $vcomen="RATIFICACION DE RECURSOS Y ACCIONES PUBLICADO EN BOLETIN $vbol";
        $plaley=2;
        $tippla="M";
        $fecven= '';
        //fecha de vencimiento
        $fecven=calculo_fechas($vfvig,$plaley,$tippla,'/'); 
      }
      
      //descripcion del evento
      $result=pg_exec("SELECT * FROM stzevder WHERE evento='$codeve' and tipo_mp='P'");
      $regt = pg_fetch_array($result);
      $deseve=$regt[descripcion];
      $plaley=$regt[plazo_ley];
      $tippla=$regt[tipo_plazo];
      
      //Estatus final
      $resule=pg_exec("SELECT * FROM stzmigrr WHERE evento='$codeve' and estatus_ini='$vtip' 
                                and tipo_mp='P'");
      $rege = pg_fetch_array($resule);
      $estfin=$rege[estatus_fin];
      if ($vtip==2556) {$estfin=2555;}
      
      //fecha de vencimiento
      $fecven=calculo_fechas($vfvig,$plaley,$tippla,'/');
      
      //echo "$vtip, $estfin, $codeve "; exit();
      
      //Actualizacion en tablas maestras
      $can_error=0;
      pg_exec("BEGIN WORK");
      $regv = pg_fetch_array($resulv);
      for ($cont=0;$cont<$cantreg;$cont++) {
      //for ($cont=0;$cont<1;$cont++) {
          $vsolh=$regv[solicitud];
          $vderh=$regv[nro_derecho];

	       //echo " $vsolh "; exit();
	       
          if ($fecven=='' || empty($fecven)) {
          $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,
                          documento,fecha_trans,usuario,desc_evento,comentario,hora";
              if ($vtip==2556) {
                 $insert_valores="'$vderh',$codeve,'$vfbol',nextval('stzevtrd_secuencial_seq'),
                                   2555,$vbol,'$vfec','$vuser','$deseve','$vcomen','$hora'";
              }  else {
                 $insert_valores="'$vderh',$codeve,'$vfbol',nextval('stzevtrd_secuencial_seq'),
                                   $vtip,$vbol,'$vfec','$vuser','$deseve','$vcomen','$hora'";} 
          } else {
          $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,
                          documento,fecha_trans,usuario,desc_evento,comentario,hora";
          $insert_valores="'$vderh',$codeve,'$vfbol',nextval('stzevtrd_secuencial_seq'),
                            $vtip,'$fecven',$vbol,'$vfec','$vuser','$deseve','$vcomen','$hora'";}

	       $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
          if (!$valido) {$can_error=$can_error+1;}

          // Actualizacion de la Solicitud en stzderec
          
          $update_str = "";
          if ($vtip==2006) { 
            $update_str = $update_str."fecha_publi='$vfbol',";
          }
          
          if ($fecven=='' || empty($fecven)) {
             $update_str = $update_str."estatus='$estfin'"; }
          else {
             if (($vtip==2800) || ($vtip==2801) || ($vtip==2802) || ($vtip==2804) || ($vtip==2805) || ($vtip==2806) || ($vtip==2809) ||
                 ($vtip==2821) || ($vtip==2833) || ($vtip==2835) || ($vtip==2836) || ($vtip==2837) || ($vtip==2838) || ($vtip==2840) ||
                 ($vtip==2921) || ($vtip==2922)) {
               $estfin = $vtip; 
               $update_str = $update_str."estatus='$estfin'"; }
           	 else {
               $update_str = $update_str."estatus='$estfin',fecha_venc='$fecven'"; }
          }     
          pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
          $valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
          if (!$valido) {$can_error=$can_error+1;}
            
          $regv = pg_fetch_array($resulv); 
      } 
      //eliminacion de registros de la tabla stztmpbo
      $valido=$sql->del("stztmpbo","estatus='$vtip' and boletin='$vbol' and tipo='P'");
      if (!$valido) {$can_error=$can_error+1;}

      // Mensaje final
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("Se Actualizaron '$cantreg' Solicitudes",'p_bolactlo.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else { 
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("ERROR: Falla de Ingreso en la B.D. Transacciones Abortadas ...!!!",
                      "javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();   }
 }      
      
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('varfocus','forpatentes2.vbol'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest); 
   $smarty ->assign('vfbol',$vfbol);
   $smarty ->assign('vfvig',$vfvig);  
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('lfechaevent','Fecha del Boletin:');
   $smarty ->assign('lfechavigen','Fecha de Vigencia:');  
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('p_bolactlo.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
