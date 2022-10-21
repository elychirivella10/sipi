<? 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login   = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$hora    = hora();
$tipo_boletin= "E";
$modulo = 'p_actbolext_1.php';

$smarty->assign('titulo','Sistema de Patentes'); 
$smarty->assign('subtitulo','Actualizacion de Datos en Lotes de Boletin Extraordinario'); 
$smarty->assign('login',$usuario);       
$smarty->assign('fechahoy',$fecha);   
$smarty->display('encabezado1.tpl');
    
   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc  = $_GET['vopc'];
   $vbol  = $_POST['vbol'];
   $vtip  = $_POST['vtip'];
   $vfbol = $_POST['vfbol'];
   $vfvig = $_POST['vfvig'];
   $resultado=false;
   $vfec  = hoy();

  //if (($usuario!='rmendoza') AND ($usuario!='ngonzalez')) {
  //  mensajenew('AVISO: Opci&oacute;n del sistema en Mantenimiento, Comuniquese con el Administrador del Sistema SIPI ...!!!','javascript:history.back();','N');
  //  $smarty->display('pie_pag.tpl'); exit(); 
  //}
   
   $vtipest=array(4000);
   $vtipsol=array("Perencion Recursos/Acciones x NO Ratificacion");
   
   if ($vopc==1) {
            
      if ($vbol=='' || $vtip=='' || $vfbol=='') {
         mensajenew('ERROR: DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }

      //Perimidas por No Ratificaciones del Boletin 588, II Parte - Boletin 1 Extraordinario 

      //Conexion a la Base de Datos
      $sql = new mod_db();
      $sql->connection($login);

      $counter= 1;
      $vtip   = 2800;
      $filas_total = 0;
      while ( $counter <= 15) {
      //while ( $counter <= 1) {
      
        if (($vtip==2800) || ($vtip==2801) || ($vtip==2802) || ($vtip==2804) || ($vtip==2805) || ($vtip==2806) || ($vtip==2840)) {
          $codeve=2866; 
        }

        if (($vtip==2809) || ($vtip==2821)) {
          $codeve=2868; 
        }

        if (($vtip==2833) || ($vtip==2838)) {
          $codeve=2870; 
        }

        if (($vtip==2835) || ($vtip==2836)) {
          $codeve=2872; 
        }

        if (($vtip==2921) || ($vtip==2922)) {
          $codeve=2874; 
        }

        $result=pg_exec("SELECT * FROM stzevder WHERE evento='$codeve' AND tipo_mp='P'");
        $regt = pg_fetch_array($result);
        $deseve=$regt[descripcion];
        $vcomen  = "BOLETIN EXTRAORDINARIO NRO. 1 - ";
        $vcomen=$vcomen.$regt[descripcion];
        $tipeve=$regt[tipo_evento];
        $plaley=15;
        $tippla="H";
        //fecha de vencimiento
        $fecven=calculo_fechas($vfvig,$plaley,$tippla,'/'); 

        $resulv=pg_exec("SELECT * FROM stztmpbo WHERE estatus='$vtip' AND boletin='$vbol' AND tipo='P' AND tipo_boletin='E' ORDER BY solicitud");
        $cantreg = pg_numrows($resulv);
        if ($cantreg <= 0) {
          $sql->disconnect(); 
          mensajenew('ERROR: No existen Datos para Actualizar ...!!!','javascript:history.back();','N');
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

          }  

          $regv = pg_fetch_array($resulv); 
        }
         
        //eliminacion de registros de la tabla stztmpbo
        //$valido=$sql->del("stztmpbo","estatus='$vtip' and boletin='$vbol' and tipo='P'");
        //if (!$valido) {$can_error=$can_error+1;}

        $counter = $counter + 1; 
        if($counter==2)  { $vtip = 2801; }
        if($counter==3)  { $vtip = 2802; }
        if($counter==4)  { $vtip = 2804; }
        if($counter==5)  { $vtip = 2805; }
        if($counter==6)  { $vtip = 2806; }
        if($counter==7)  { $vtip = 2840; }

        if($counter==8)  { $vtip = 2809; }
        if($counter==9)  { $vtip = 2821; }

        if($counter==10) { $vtip = 2833; }
        if($counter==11) { $vtip = 2838; }

        if($counter==12) { $vtip = 2835; }
        if($counter==13) { $vtip = 2836; }

        if($counter==14) { $vtip = 2921; }
        if($counter==15) { $vtip = 2922; }
        
      }

      // Mensaje final
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           mensajenew("Se Actualizaron '$filas_total' Solicitudes",'p_actbolext_1.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else { 
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           mensajenew("ERROR: Falla de Ingreso en la B.D. Transacciones Abortadas ...!!!","javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();   }
   }      
      
   //Asignacion de variables para pasarlas a Smarty
   $smarty->assign('varfocus','forpatentes2.vbol'); 
   $smarty->assign('opcion',$vopc); 
   $smarty->assign('vtipsol',$vtipsol); 
   $smarty->assign('vtipest',$vtipest); 
   $smarty->assign('vfbol',$vfbol);
   $smarty->assign('vfvig',$vfvig);  
   $smarty->assign('lboletin','Boletin Extraordinario:'); 
   $smarty->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty->assign('lfechaevent','Fecha del Boletin:');
   $smarty->assign('lfechavigen','Fecha de Vigencia:');  
   $smarty->assign('espacios',''); 
   
   $smarty->display('p_actbolext_1.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
