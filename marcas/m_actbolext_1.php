<?
//Creado por Ing. Romulo Mendoza I Semestre 2020  
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);
$login   = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$hora    = hora();
$tipo_boletin= "E";
$modulo = 'm_actbolext_1.php';

$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Actualizacion de Datos en Lotes del Boletin Extraordinario'); 
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
   
   $vtipest=   array(4000);
   $vtipsol=array("Perencion Recursos/Acciones x NO Ratificacion");
   if ($vopc==1) {
            
      if ($vbol=='' || $vtip=='' || $vfbol=='') {
        mensajenew('ERROR: DATOS INCORRECTOS O VACIOS ...!!!','m_actbolext_1.php','N');
        $smarty->display('pie_pag.tpl'); exit(); }

      //Perimidas por No Ratificaciones del Boletin 588, II Parte - Boletin 1 Extraordinario 

      //Conexion a la Base de Datos
      $sql = new mod_db();
      $sql->connection($login);

      $counter= 1;
      $vtip   = 1800;
      $filas_total = 0;
      while ( $counter <= 22) {
      //while ( $counter <= 1) {
          	
        if (($vtip==1800) || ($vtip==1801) || ($vtip==1802) || ($vtip==1803) || ($vtip==1804) || ($vtip==1805) || ($vtip==1806) || ($vtip==1807) ||
          ($vtip==1808)) {
          $codeve=1866; 
        }

        if (($vtip==1809) || ($vtip==1825) || ($vtip==1836) || ($vtip==1837)) {
          $codeve=1868; 
        }

        if (($vtip==1830) || ($vtip==1831)) {
          $codeve=1870; 
        }

        if ($vtip==1821) { $codeve=1872; }
        if ($vtip==1822) { $codeve=1874; }
        if ($vtip==1823) { $codeve=1876; }
        if ($vtip==1824) { $codeve=1878; }
        if ($vtip==1835) { $codeve=1880; }
        if ($vtip==1833) { $codeve=1882; }
        if ($vtip==1838) { $codeve=1884; }

        $result=pg_exec("SELECT * FROM stzevder WHERE evento='$codeve' AND tipo_mp='M'");
        $regt  = pg_fetch_array($result);
        $deseve=$regt[descripcion];
        $vcomen= "BOLETIN EXTRAORDINARIO NRO. 1 - ";
        $vcomen=$vcomen.$regt[descripcion];
        $tipeve=$regt[tipo_evento];
        $plaley=15;
        $tippla="H";
        //fecha de vencimiento
        $fecven=calculo_fechas($vfvig,$plaley,$tippla,'/'); 

        $resulv=pg_exec("SELECT * FROM stztmpbo WHERE estatus='$vtip' AND boletin='$vbol' AND tipo_boletin='E' AND tipo='M' ORDER BY solicitud");
        $cantreg = pg_numrows($resulv);
        if ($cantreg <= 0) {
          $sql->disconnect();
          mensajenew('ERROR: No existen Datos para Actualizar ...!!!','m_actbolext_1.php','N');
          $smarty->display('pie_pag.tpl'); exit(); }
      
        $filas_total = $filas_total + $cantreg; 
        //Actualizacion en tablas maestras
        $can_error=0;
        pg_exec("BEGIN WORK");
        $regv = pg_fetch_array($resulv);
        for ($cont=0;$cont<$cantreg;$cont++) {
        //for ($cont=0;$cont<1;$cont++) {
          $vsolh=$regv[solicitud];
          $vderh=$regv[nro_derecho];

          //Verificacion si ya fue cargado o no el evento de perimida publicada
          $obj_queryver = $sql->query("SELECT * FROM stzevtrd WHERE nro_derecho='$vderh' AND evento='$codeve'");
          $evento_found=$sql->nums('',$obj_queryver);
          if ($evento_found==0) {
            $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora,tipo_documento";
            $insert_valores="'$vderh',$codeve,'$vfbol',nextval('stzevtrd_secuencial_seq'),$vtip,'$fecven',$vbol,'$vfec','$vuser','$deseve','$vcomen','$hora','$tipo_boletin'";
            //echo "valores=$vsolh-$insert_valores"; 
            $valido=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");
            if (!$valido) { $can_error = $can_error + 1; }

            // Actualizacion de la Solicitud en stzderec // OJO ARREGLAR
            //$update_str = "";
            //if (($vtip==1800) || ($vtip==1801) || ($vtip==1802) || ($vtip==1803) || ($vtip==1804) || ($vtip==1805) || ($vtip==1806) || ($vtip==1807) ||
            //    ($vtip==1808) || ($vtip==1809) || ($vtip==1821) || ($vtip==1822) || ($vtip==1823) || ($vtip==1824) || ($vtip==1825) || ($vtip==1830) ||
            //    ($vtip==1831) || ($vtip==1833) || ($vtip==1835) || ($vtip==1836) || ($vtip==1837) || ($vtip==1838)) {
            //  $estfin = $vtip; 
            //  $update_str = $update_str."estatus='$estfin'"; }
            //}    
            //pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
            //$valido=$sql->update("stzderec","$update_str","nro_derecho='$vderh'");
            //if (!$valido) { $can_error = $can_error + 1; }
          }  

          $regv = pg_fetch_array($resulv); 
        } 

        //Eliminacion de registros de la tabla stztmpbo
        //$valido=$sql->del("stztmpbo","estatus='$vtip' AND boletin='$vbol' AND tipo_boletin='E' AND tipo='M'");
        //if (!$valido) { $can_error = $can_error + 1; } 

        $counter = $counter + 1; 
        if($counter==2)  { $vtip = 1801; }
        if($counter==3)  { $vtip = 1802; }
        if($counter==4)  { $vtip = 1803; }
        if($counter==5)  { $vtip = 1804; }
        if($counter==6)  { $vtip = 1805; }
        if($counter==7)  { $vtip = 1806; }
        if($counter==8)  { $vtip = 1807; }
        if($counter==9)  { $vtip = 1808; }
        if($counter==10) { $vtip = 1809; }
        if($counter==11) { $vtip = 1825; }
        if($counter==12) { $vtip = 1836; }
        if($counter==13) { $vtip = 1837; }
        if($counter==14) { $vtip = 1830; }
        if($counter==15) { $vtip = 1831; }
        if($counter==16) { $vtip = 1821; }
        if($counter==17) { $vtip = 1822; }
        if($counter==18) { $vtip = 1823; }
        if($counter==19) { $vtip = 1824; }
        if($counter==20) { $vtip = 1835; }
        if($counter==21) { $vtip = 1833; }
        if($counter==22) { $vtip = 1838; }
        
      }
            
      // Mensaje final 
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           //$smarty->display('encabezado1.tpl');
           mensajenew("AVISO: Se Actualizaron '$filas_total' Solicitudes.",'m_actbolext_1.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else { 
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           //$smarty->display('encabezado1.tpl');
           mensajenew("ERROR: Falla de Ingreso en la B.D. Transacciones Abortadas...!!!","javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit(); }
   }      
      
   //Asignacion de variables para pasarlas a Smarty
   $smarty->assign('varfocus','formarcas2.vbol'); 
   $smarty->assign('opcion',$vopc); 
   $smarty->assign('vtipsol',$vtipsol); 
   $smarty->assign('vtipest',$vtipest); 
   $smarty->assign('vfbol',$vfbol); 
   $smarty->assign('lboletin','Boletin Extraordinario:'); 
   $smarty->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty->assign('lfechaevent','Fecha del Boletin:');
   $smarty->assign('lfechavigen','Fecha de Vigencia:');  
   $smarty->assign('espacios',''); 
   $smarty->display('m_actbolext_1.tpl'); 
   $smarty->display('pie_pag.tpl');
?>

