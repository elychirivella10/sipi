<? 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$hh=hora();
$sql = new mod_db();
$fecha=fechahoy();

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Negaci&oacute;n (L.P.I. 10/12/1956)'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
   
   $vuser = $usuario;
   
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $nderec=$_POST['nderec'];
   $vsol1=$_POST['vsol1'];
   $vsol2=$_POST['vsol2'];
   $vfecsol=$_POST['vfecsol'];
   $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vnom=$_POST['vnom'];
   $vcla=$_POST['vcla'];
   $vindcla=$_POST['vindcla'];
   $vtram=$_POST['vtram'];
   $resultado=false;
   
   $vsolh=$_POST['vsolh'];
   $vfevh=$_POST['vfevh'];
   $vfec=hoy();
   $vart=$_POST['art'];
   $vlit1=$_POST['lit1'];
   $vlit2=$_POST['lit2'];
   $vcom=$_POST['comenta'];
   $vreg11=$_POST['vlit1reg11'];
   $vreg12=$_POST['vlit1reg12'];
   $vreg21=$_POST['vlit1reg21'];
   $vreg22=$_POST['vlit1reg22'];
   $vreg31=$_POST['vlit1reg31'];
   $vreg32=$_POST['vlit1reg32'];
   $vreg41=$_POST['vlit2reg11'];
   $vreg42=$_POST['vlit2reg12'];
   $vreg51=$_POST['vlit2reg21'];
   $vreg52=$_POST['vlit2reg22'];
   $vreg61=$_POST['vlit2reg31'];
   $vreg62=$_POST['vlit2reg32'];
   $vreg1=$vreg11.$vreg12;
   $vreg2=$vreg21.$vreg22;
   $vreg3=$vreg31.$vreg32;
   $vreg4=$vreg41.$vreg42;
   $vreg5=$vreg51.$vreg52;
   $vreg6=$vreg61.$vreg62;
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('vmodo',''); 
   $smarty ->assign('ltramitante','Tramitante/Agente:'); 
   
   $sql->connection($login);   
   if ($vopc==1) {
      $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho and tipo_mp='M' and
                        b.solicitud= '$vsol'");} 
   if ($vopc==1) {
      $vfeceve = hoy();
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas2.comenta'); 
      $smarty ->assign('vmodo','readonly'); 
      
      if (!$resultado) { 
         $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA','m_negacion56.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
        $sql->disconnect();
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS','m_negacion56.php','N');
	     $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $nderec=$reg[nro_derecho];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vnom=$reg[nombre];
      $vcla=$reg[clase];
      $vindcla=$reg[ind_claseni];
      $vest=$reg[estatus];
      $vtram=$reg[tramitante];
      $vagen=$reg[agente];
      $vpoder=$reg[vpoder];
      $vmod=$reg[modalidad];
      $nameimage=ver_imagen($vsol1,$vsol2,'M'); 
      $smarty ->assign('ltramitante','Tramitante:'); 
          
      if ($vtram=='                                        ') {
         $resultra=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vagen");
	      $regtra = pg_fetch_array($resultra);
         $vtram=$regtra[nombre];
	      $smarty ->assign('ltramitante','Agente:'); 
      }
      
      //if ($vest==1008 || $vest==1027 || $vest==1104 || $vest==1129 || $vest==1305) { 
      //   //Estatus correctos
      //}  ELSE {
      //   $sql->disconnect();
      //   $smarty->display('encabezado1.tpl');
      //   mensajenew('ERROR: Solo Aplica en Solicitudes que tengan Estatus: 8, 27, 104, 129 o 305',
      //              'm_negacion56.php','N');
	   //   $smarty->display('pie_pag.tpl'); exit(); 
      //}

      if (($vest!=1001) && ($vest!=1008) && ($vest!=1104) && ($vest!=1027) && ($vest!=1029) && ($vest!=1305)) {
        mensajenew('ERROR: Solo se pueden examinar Expedientes en Estatus 1, 8, 27, 29, 104 o 305...!!!','m_negacion56.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      if ($vest==1001) {
        if ($vsol>'2014-007441') { }
        else {
          mensajenew('ERROR: Opcion NO aplicable a este Expediente, solo se puede aplicar a solicitudes mayores a 2014-007441 en Estatus 1 ...!!!','m_negacion56.php','N');
          $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
        }   
      }

      if ($vest==1008) {
        if ($vsol<'2014-007442') { }
        else {
          mensajenew('ERROR: Opcion NO aplicable a este Expediente, solo se puede aplicar a solicitudes menores a 2014-007442 en Estatus 8 ...!!!','m_negacion56.php','N');
          $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
        }   
      }

      if ($vmod!="D") {
        //Verificando si el expediente ya presenta dicho evento 
        //$resul1=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento=1050");
        //$filas1_found=pg_numrows($resul1); 
        //$resul2=pg_exec("SELECT * FROM stmaudef WHERE pedido='$vsol'");
        //$filas2_found=pg_numrows($resul2);  
        //if (($filas1_found==0) && ($filas2_found==0)) {
        //  $smarty->display('encabezado1.tpl');
        //  mensajenew("ERROR: Expediente Gr&aacute;fico o Mixto sin B&uacute;squeda Gr&aacute;fica de Fondo ...!!!","m_negacion56.php","N");     
        //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
        //} 
        //if (($filas1_found==0) || ($filas2_found==0)) {
        //  $smarty->display('encabezado1.tpl');
        //  mensajenew("ERROR: Expediente Gr&aacute;fico o Mixto sin B&uacute;squeda Gr&aacute;fica de Fondo ...!!!","m_negacion56.php","N");     
        //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
        //} 
      }
      
   }   
      
   if ($vopc==3) {
      // Validaciones
      if ($vsolh=='-' || $vart=='') {
        $sql->disconnect();
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: PROBLEMAS AL INTENTAR GRABAR - DATOS INCORRECTOS','m_negacion56.php','N');
	     $smarty->display('pie_pag.tpl'); exit();  
      }

      //Validacion adiconal por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$nderec'");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      $vfecsol= $regsol[fecha_solic];
      $varsol = $regsol[solicitud];
      
      if ($vest==1008 || $vest==1027 || $vest==1104 || $vest==1129 || $vest==1305) { //Esta bien
      } else {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario','m_negacion56.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
      
      if (($vreg1!='' && ($vreg1==$vreg2 || $vreg1==$vreg3 || $vreg1==$vreg4 || $vreg1==$vreg5 || $vreg1==$vreg6)) ||
      ($vreg2!='' && ($vreg2==$vreg3 || $vreg2==$vreg4 || $vreg2==$vreg5 || $vreg2==$vreg6)) ||
      ($vreg3!='' && ($vreg3==$vreg4 || $vreg3==$vreg5 || $vreg3==$vreg6)) ||
      ($vreg4!='' && ($vreg4==$vreg5 || $vreg4==$vreg6)) ||
      ($vreg5!='' && ($vreg5==$vreg6))) {
         $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - Existen Registros Duplicados','m_negacion56.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
      $noexiste=0;
      if ($vreg1!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg1' 
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($vreg2!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg2'
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($vreg3!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg3'
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($vreg4!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg4'
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($vreg5!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg5'
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($vreg6!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg6'
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($noexiste==1) {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - Algún Registro no fué Encontrado','m_negacion56.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }
      //$vfecsol=convertir_en_fecha($vfecsol,1);
      //$esmayor=compara_fechas($vfecsol,$vfevh);
      $esmayor=0;
      if ($esmayor==1) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: No se puede cargar un evento previo a la Fecha de la Solicitud','m_negacion56.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
         }
      // Evento Cableado (225) se presume que los estatus finales son:
      $vestfin =102;
      $vdese='SOLICITUD EN EXAMEN DE FONDO - POR PUBLICAR DECISION';
      
      if (($vart=='33' && (empty($vlit1) or $vlit1<1 or $vlit1>12)) || 
          ($vart=='34' && (empty($vlit1) or $vlit1<1 or $vlit1>2)) || 
          ($vlit1!='' && !strpos('3527',$vart)===false)) {
          $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - Articulo y Literal no se corresponden','m_negacion56.php','N');
         $smarty->display('pie_pag.tpl'); exit(); 
         }
      if ($vlit2!='' && (($vart=='33' && (empty($vlit2) or $vlit2<1 or $vlit2>12)) || 
                         ($vart=='34' && (empty($vlit2) or $vlit2<1 or $vlit2>2)) || 
                         (!strpos('3527',$vart)===false))) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - Articulo y Literal no se corresponden','m_negacion56.php','N');
         $smarty->display('pie_pag.tpl'); exit(); 
         }	  
      if ( ($vart=='33' && $vlit1==11 && ($vreg1=='' or empty($vreg1))) || 
           ($vart=='33' && $vlit2==11 && ($vreg4=='' or empty($vreg4))) ) {
          $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - Falta colocar el Numero de Registro para aplicar el Art.33 Num.11',
                    'm_negacion56.php','N');
         $smarty->display('pie_pag.tpl'); exit(); 
         }
      if ($vart<>'33' && $vart<>'34' && ($vreg1<>'' or !empty($vreg1) or $vreg4<>'' or !empty($vreg4))) {
          $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - Numero de Registro solo aplica para el Art.33 Num.11',
                    'm_negacion56.php','N');
       $smarty->display('pie_pag.tpl'); exit(); 
         }
      pg_exec("BEGIN WORK"); 
      $sw_act=0;
      // inserta en Stzevtrd
      $insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_valores ="'$nderec',1225,'$vfevh','$vest',0,'$vfec','$vuser','$vdese','$vcom','$hh'";
      $sw_ins=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      
      // inserta en Stmliaor
      $sql->del("stmliaor","nro_derecho='$nderec'");    
      $insert_campos="nro_derecho,articulo,literal,reg_base";    
      if (substr($vlit1,0,1)=='0') {$vlit1=substr($vlit1,1,1);}
      if (substr($vlit2,0,1)=='0') {$vlit2=substr($vlit2,1,1);}
      $insert_valores="'$nderec','$vart','$vlit1','$vreg1'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores","");
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vreg2!='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base";
      $insert_valores="'$nderec','$vart','$vlit1','$vreg2'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }      
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vreg3!='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base"; 
      $insert_valores="'$nderec','$vart','$vlit1','$vreg3'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vlit2!='' && $vreg4=='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base"; 
      $insert_valores="'$nderec','$vart','$vlit2','$vreg4'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vlit2=='') {$vlit2=$vlit1;}      
      if ($vreg4!='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base"; 
      $insert_valores="'$nderec','$vart','$vlit2','$vreg4'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vreg5!='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base"; 
      $insert_valores="'$nderec','$vart','$vlit2','$vreg5'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vreg6!='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base"; 
      $insert_valores="'$nderec','$vart','$vlit2','$vreg6'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }
      if (!$sw_ins) {$sw_act=$sw_act+1;} 
      
      // Actualizar Stmmarce
      $update_str="estatus=1102";
      $sw_upd=$sql->update("stzderec","$update_str","nro_derecho='$nderec'");    
      if (!$sw_upd) {$sw_act=$sw_act+1;} 

      $insexam = true;
      // Inserta Datos en tabla control de nuevo examen de forma y fondo 
      $insert_campos="nro_derecho,solicitud,evento,fecha_trans,hora,usuario";
      $insert_valores ="'$nderec','$varsol','1225','$vfec','$hh','$vuser'";
      $insexam = $sql->insert("stmforfon","$insert_campos","$insert_valores","");	 
      if (!$insexam) {$sw_act=$sw_act+1;}
      
      if ($sw_act==0) { 
        pg_exec("COMMIT WORK"); $sql->disconnect(); 
        $smarty->display('encabezado1.tpl');
        mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_negacion56.php','S');
        $smarty->display('pie_pag.tpl'); exit();   
      }
      else {
        pg_exec("ROLLBACK WORK"); $sql->disconnect();
        $smarty->display('encabezado1.tpl');
        mensajenew("ERROR: Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();    
      } 
    }  
   
   //Asignación de variables para pasarlas a Smarty
   $smarty->assign('nderec',$nderec); 
   $smarty->assign('opcion',$vopc); 
   $smarty->assign('solicitud1',$vsol1); 
   $smarty->assign('solicitud2',$vsol2); 
   $smarty->assign('nombre',$vnom); 
   $smarty->assign('clase',$vcla); 
   $smarty->assign('tramitante',$vtram); 
   $smarty->assign('vfevh',$vfevh); 
   $smarty->assign('vsolh',$vsolh); 
   $smarty->assign('vfec',$vfec); 
   $smarty->assign('vmod',$vmod); 
   $smarty->assign('nameimage',$nameimage); 
   $smarty->assign('lart','Articulo:'); 
   $smarty->assign('llit','Numeral:'); 
   $smarty->assign('lreg','Registro:'); 
   $smarty->assign('lsol','Solicitud:'); 
   $smarty->assign('lcomentario','Comentario:'); 
   if ($vindcla=="I") {$smarty ->assign('ind_claseni','INTERNACIONAL');}; 
   if ($vindcla=="N") {$smarty ->assign('ind_claseni','NACIONAL');}; 
   $smarty->assign('lsolicitud','Solicitud:'); 
   $smarty->assign('lfechaevent','Fecha del Evento:'); 
   $smarty->assign('lnombre','Nombre:');
   $smarty->assign('lclase','Clase:'); 
   $smarty->assign('espacios','            '); 
   $smarty->display('encabezado1.tpl');
   $smarty->display('m_negacion56.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
