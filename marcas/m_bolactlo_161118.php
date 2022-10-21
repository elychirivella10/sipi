<?
//Creado por Nelson Gonzalez 
//Modificado por Ing. Romulo Mendoza I Semestre 2010 - Separación de Marcas y Registro
//Modificado por Ing. Romulo Mendoza I Semestre 2010, 30/06/2010 Devueltas a Notas Marginales 
//Modificado por Ing. Romulo Mendoza II Semestre 2018, 01/11/2018 Ratificacion de Recursos y Acciones  
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);
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

$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Actualizacion de Datos en Lotes del Boletin'); 
$smarty->assign('login',$usuario);       
$smarty->assign('fechahoy',$fecha);   
$smarty->display('encabezado1.tpl');
    
   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vbol=$_POST['vbol'];
   $vtip=$_POST['vtip'];
   $vfbol=$_POST['vfbol'];
   $vfvig=$_POST['vfvig'];
   $resultado=false;
   $vfec=hoy();
   
  //if (($usuario!='rmendoza') AND ($usuario!='ngonzalez')) {
  //  mensajenew('AVISO: Opci&oacute;n del sistema en Mantenimiento, Comuniquese con el Administrador del Sistema SIPI ...!!!','javascript:history.back();','N');
  //  $smarty->display('pie_pag.tpl'); exit(); 
  //}
   
   $sql->connection($login);   
   $vtipest=   array(1002,1023,1024,1030,1006,1101,1390,1200,1116,1003,1011,1025,1750,1910,1914,1125,1130,1913,1996,1102,1564,1800,1801,1802,1803,1804,1805,1806,1807,1808,1809,1821,1822,1823,1824,1825,1830,1831,1833,1835,1836,1837,1838);
   $vtipsol=array("Orden de Publicacion","Perimidas x Publicacion en Prensa Extemporanea","Publicacion Prensa Defectuosa","Perimidas por NO Publicacion Prensa","Solicitadas","Concedidas","Concedidas Reclasificadas","Devueltas","Devueltas por Fondo","Observadas","Observadas Inadmisible por LOPA","Prioridad Extinguida","Caducas","Desistidas","Desistimiento a Observadas por Ley","Desistimiento de Observaciones","Desistim. Observacion Mejor Derecho","Registros No Renovados","Caducas por no Renovacion","Negadas","Devolucion de Notas Marginales","Ratificacion Estatus 800","Ratificacion Estatus 801","Ratificacion Estatus 802","Ratificacion Estatus 803","Ratificacion Estatus 804",
   "Ratificacion Estatus 805","Ratificacion Estatus 806","Ratificacion Estatus 807","Ratificacion Estatus 808","Ratificacion Estatus 809","Ratificacion Estatus 821","Ratificacion Estatus 822","Ratificacion Estatus 823","Ratificacion Estatus 824",
   "Ratificacion Estatus 825","Ratificacion Estatus 830","Ratificacion Estatus 831","Ratificacion Estatus 833","Ratificacion Estatus 835","Ratificacion Estatus 836","Ratificacion Estatus 837","Ratificacion Estatus 838");
   if ($vopc==1) {
            
      if ($vbol=='' || $vtip=='' || $vfbol=='') {
         $sql->disconnect();
         //$smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }

      if ($vtip!=1564) {
        $resulv=pg_exec("SELECT * FROM stztmpbo WHERE estatus='$vtip' and boletin='$vbol' and tipo='M'"); }
      else {
        $resulv=pg_exec("SELECT stztmpbor.nro_derecho,stztmpbor.documento,
                         stztmpbor.solicitud,stztmpbor.registro,stzevtrd.comentario,
                         stztmpbor.tipo_anota
                         FROM stztmpbor,stzevtrd
                         WHERE stztmpbor.estatus='$vtip' AND stztmpbor.boletin='$vbol' 
                         AND stztmpbor.tipo='M' 
                         AND stzevtrd.evento = 1502 
                         AND stztmpbor.documento=stzevtrd.documento"); }
        
      $cantreg = pg_numrows($resulv);
      if ($cantreg <= 0) {
         $sql->disconnect();
         //$smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - No existen Datos para Actualizar','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      
      //identificacion del evento a utilizar
      if ($vtip==1002) {$codeve=1201; $vcomen="ORDEN DE PUBLICACION NOTIFICADA EN BOLETIN $vbol";}
      if ($vtip==1023) {$codeve=1123; $vcomen="SOLICITUD PERIMIDA PUBLICADA EN BOLETIN $vbol POR PUBLICACION EN PRENSA EXTEMPORANEA";}
      if ($vtip==1024) {$codeve=1123; $vcomen="PUBLICACION PRENSA DEFECTUOSA EN BOLETIN $vbol";}
      if ($vtip==1030) {$codeve=1980; $vcomen="PERIMIDA POR NO PUBLICACION PRENSA EN BOLETIN $vbol";}
      if ($vtip==1006) {$codeve=1124; $vcomen="PUBLICADA EN BOLETIN $vbol";}
      if ($vtip==1101) {$codeve=1122; $vcomen="CONCEDIDA EN BOLETIN $vbol";}
      if ($vtip==1390) {$codeve=1122; $vcomen="CONCEDIDA RECLASIFICADA EN BOLETIN $vbol";}
      if ($vtip==1200) {$codeve=1122; $vcomen="DEVUELTA EN BOLETIN $vbol";}
      if ($vtip==1116) {$codeve=1122; $vcomen="DEVUELTA POR FONDO EN BOLETIN $vbol";}
      if ($vtip==1003) {$codeve=1122; $vcomen="OBSERVADA EN BOLETIN $vbol";}
      if ($vtip==1011) {$codeve=1123; $vcomen="OBSERVACION INADMISIBLE PUBLICADA EN BOLETIN $vbol";}
      if ($vtip==1025) {$codeve=1123; $vcomen="PRIORIDAD EXTINGUIDA EN BOLETIN $vbol";}
      if ($vtip==1750) {$codeve=1125; $vcomen="CADUCA EN BOLETIN $vbol";}
      if ($vtip==1910) {$codeve=1123; $vcomen="DESISTIDA EN BOLETIN $vbol";}
      if ($vtip==1914) {$codeve=1251; $vcomen="SOLICITUD DESISTIDA POR LEY EN BOLETIN $vbol";}
      if ($vtip==1125) {$codeve=1121; $vcomen="DESISTIMIENTO DE OBSERVACION BOLETIN $vbol";}
      if ($vtip==1130) {$codeve=1121; $vcomen="DESISTIMIENTO DE OBSERVACION POR MEJOR DERECHO BOLETIN $vbol";}
      if ($vtip==1913) {$codeve=1855; $vcomen="REGISTRO NO RENOVADO BOLETIN $vbol";}
      if ($vtip==1996) {$codeve=1847; $vcomen="CADUCA POR NO RENOVACION BOLETIN $vbol";}
      if ($vtip==1102) {$codeve=1062; $vcomen="NEGADA PUBLICADA EN BOLETIN $vbol";}

      if (($vtip==1800) || ($vtip==1801) || ($vtip==1802) || ($vtip==1803) || ($vtip==1804) || ($vtip==1805) || ($vtip==1806) || ($vtip==1807) ||
          ($vtip==1808) || ($vtip==1809) || ($vtip==1821) || ($vtip==1822) || ($vtip==1823) || ($vtip==1824) || ($vtip==1825) || ($vtip==1830) ||
          ($vtip==1831) || ($vtip==1833) || ($vtip==1835) || ($vtip==1836) || ($vtip==1837) || ($vtip==1838)) {
        $codeve=1195; $vcomen="RATIFICACION DE RECURSOS DE RECONSIDERACION Y ACCIONES PUBLICADO EN BOLETIN $vbol";
        $plaley=2;
        $tippla="M";
        $fecven= '';
        //fecha de vencimiento
        $fecven=calculo_fechas($vfvig,$plaley,$tippla,'/'); 
      }

      if ($vtip!=1564) {
        //descripcion del evento
        $result=pg_exec("SELECT * FROM stzevder WHERE evento='$codeve' AND tipo_mp='M'");
        $regt = pg_fetch_array($result);
        $deseve=$regt[descripcion];
        $plaley=$regt[plazo_ley];
        $tippla=$regt[tipo_plazo];
        $tipeve=$regt[tipo_evento];
      }
      
      //Estatus final
      if (($vtip!=1130) AND ($vtip!=1564)) {
         $resule=pg_exec("SELECT * FROM stzmigrr WHERE evento='$codeve' AND 
                                 estatus_ini='$vtip' AND tipo_mp='M'");
         $rege = pg_fetch_array($resule);
         $estfin=$rege[estatus_fin]; }
      
      if ($vtip!=1564) {
        $fecven= '';
        //fecha de vencimiento
        if ($tipeve=='M') {
          $fecven=calculo_fechas($vfvig,$plaley,$tippla,'/'); } 
      }

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
           //if ($cant42==$cant40) { $estfin=1008; $deseve="PUBLICADO DESISTIMIENTO DE OBSERVACION / PASA EXAMEN DE FONDO SIN OBSERVACION"; }
           //else { if ($cant42<$cant40) { $estfin=1120; $codeve=1120; $deseve="PUBLICADO DESISTIMIENTO DE OBSERVACION / PASA EXAMEN DE FONDO CON OBSERVACION"; } }
           if ($cant42==$cant40) { $estfin=1008; $deseve="DESISTIMIENTO DE OBSERVACION PUBLICADO"; }
           else { if ($cant42<$cant40) { $estfin=1120; $codeve=1120; $deseve="DESISTIMIENTO DE OBSERVACION PUBLICADO"; } }
         }

         if ($vtip==1564) {
           $vtra     = trim($regv[comentario]); 
           $control  = $regv[documento]; 
           $tipanota = $regv[tipo_anota]; 
           switch ($tipanota) {
             case "R":
               $codeve=1511; $vcomen="RENOVACION DEVUELTA PUBLICADA EN BOLETIN $vbol".", RELACIONADO A: ".$vtra.", "." CONTROL NRO: ".$control;
               break;
             case "C":
               $codeve=1512; $vcomen="CESION DEVUELTA PUBLICADA EN BOLETIN $vbol".", RELACIONADO A: ".$vtra.", "." CONTROL NRO: ".$control;
               break;
             case "F":
               $codeve=1513; $vcomen="FUSION DEVUELTA PUBLICADA EN BOLETIN $vbol".", RELACIONADO A: ".$vtra.", "." CONTROL NRO: ".$control;
               break;
             case "L":
               $codeve=1514; $vcomen="LICENCIA DE USO DEVUELTA PUBLICADA EN BOLETIN $vbol".", RELACIONADO A: ".$vtra.", "." CONTROL NRO: ".$control;
               break;
             case "D":
               $codeve=1515; $vcomen="CAMBIO DE DOMICILIO DEVUELTA PUBLICADA EN BOLETIN $vbol".", RELACIONADO A: ".$vtra.", "." CONTROL NRO: ".$control;
               break;
             case "N":
               $codeve=1516; $vcomen="CAMBIO DE NOMBRE DEVUELTA PUBLICADA EN BOLETIN $vbol".", RELACIONADO A: ".$vtra.", "." CONTROL NRO: ".$control;
               break;
           }       
           //descripcion del evento
           $result=pg_exec("SELECT * FROM stzevder WHERE evento='$codeve' AND tipo_mp='M'");
           $regt = pg_fetch_array($result);
           $deseve=$regt[descripcion];
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

         // Actualizacion de la Solicitud en stzderec // OJO ARREGLAR

         $update_str = "";
         if ($vtip==1006) { 
           $update_str = $update_str."fecha_publi='$vfbol',";
         }

         if ($vtip!=1564) {
           if ($fecven=='' || empty($fecven)) {
             $update_str = $update_str."estatus='$estfin'"; }
           else {
             if (($vtip==1800) || ($vtip==1801) || ($vtip==1802) || ($vtip==1803) || ($vtip==1804) || ($vtip==1805) || ($vtip==1806) || ($vtip==1807) ||
                 ($vtip==1808) || ($vtip==1809) || ($vtip==1821) || ($vtip==1822) || ($vtip==1823) || ($vtip==1824) || ($vtip==1825) || ($vtip==1830) ||
                 ($vtip==1831) || ($vtip==1833) || ($vtip==1835) || ($vtip==1836) || ($vtip==1837) || ($vtip==1838)) {
               $estfin = $vtip; 
               $update_str = $update_str."estatus='$estfin'"; }
           	 else {
               $update_str = $update_str."estatus='$estfin',fecha_venc='$fecven'"; }
           }    
           pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
           $valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
           if (!$valido) { $can_error = $can_error + 1; }
         }

         $regv = pg_fetch_array($resulv); 
      } 

      if ($vtip!=1564) {
        //eliminacion de registros de la tabla stztmpbo
        $valido=$sql->del("stztmpbo","estatus='$vtip' AND boletin='$vbol' AND tipo='M'");
        if (!$valido) {$can_error = $can_error + 1;} 
      } else {
        //eliminacion de registros de la tabla stztmpbo
        $valido=$sql->del("stztmpbor","estatus='$vtip' AND boletin='$vbol' AND tipo='M'");
        if (!$valido) {$can_error = $can_error + 1;}
      }
            
      // Mensaje final 
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           //$smarty->display('encabezado1.tpl');
           mensajenew("AVISO: Se Actualizaron '$cantreg' Solicitudes",'m_bolactlo.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else { 
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           //$smarty->display('encabezado1.tpl');
           mensajenew("ERROR: Falla de Ingreso en la B.D. Transacciones Abortadas...!!!","javascript:history.back();","N");
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
   //$smarty->display('encabezado1.tpl');
   $smarty ->display('m_bolactlo.tpl'); 
   $smarty->display('pie_pag.tpl');
?>

