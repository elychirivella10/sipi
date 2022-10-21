<? 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$hh=hora();
$sql = new mod_db(); 
$fecha=fechahoy();  

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Devoluci&oacute;n de Fondo'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
         $smarty->display('encabezado1.tpl');

mensajenew('Opcion en Mantenimiento, debe cargar en Examen de Registrabilidad ','../index1.php','N');
$smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 

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
   $resultado=false;
   $vsolh=  $_POST['vsolh'];
   $vfevh=  $_POST['vfevh'];
   $vcausa1=$_POST['causa1'];   $vcausa2=$_POST['causa2'];   $vcausa3=$_POST['causa3'];  
   $vcausa4=$_POST['causa4'];   $vcausa5=$_POST['causa5'];   $vcausa6=$_POST['causa6'];  
   $vcausa7=$_POST['causa7'];   $vcausa8=$_POST['causa8'];   $vcausa9=$_POST['causa9'];  
   $vcausa10=$_POST['causa10']; $vcausa11=$_POST['causa11']; $vcausa12=$_POST['causa12'];
   $vcausa13=$_POST['causa13']; $vcausa14=$_POST['causa14']; $vcausa15=$_POST['causa15'];
   $vcausa16=$_POST['causa16']; $vcausa17=$_POST['causa17']; $vcausa18=$_POST['causa18'];
   $vcausa19=$_POST['causa19']; $vcausa20=$_POST['causa20']; $vcausa21=$_POST['causa21'];
   $vcausa22=$_POST['causa22']; $vcausa23=$_POST['causa23']; $vcausa24=$_POST['causa24'];
   $vcausa25=$_POST['causa25'];
   $votro  =$_POST['otro'];
   $vfec=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('vmodo',''); 
   
   $sql->connection($login);   
   
   //Verifica si el progrma esta en mantenimiento
   $manphp = vman_php("m_devfondo.php");
   if ($manphp==1) {
     $sql->disconnect(); 
     $smarty->display('encabezado1.tpl');
     MensageError('Modulo en Mantenimiento ...!!!','N');
     $smarty->display('pie_pag.tpl'); exit();
	}      

   if ($vopc==1) {
      $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho and tipo_mp='M' and
                        b.solicitud= '$vsol'");}
   if ($vopc==1) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas2.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      
      if (!$resultado) { 
         $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL PROCESAR LA BUSQUEDA','m_devfondo.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS','m_devfondo.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vnom=$reg[nombre];
      $vcla=$reg[clase];
      $vindcla=$reg[ind_claseni];
      $vest=$reg[estatus];
      $vfecsol=$reg[fecha_solic];
      $vmod=$reg[modalidad];
      $nderec=$reg[nro_derecho];
      if ($vmod=='D') {$vmodal='DENOMINATIVA';}
      if ($vmod=='G') {$vmodal='GRAFICA';}
      if ($vmod=='M') {$vmodal='MIXTA';}
      $nameimage=ver_imagen($vsol1,$vsol2,'M'); 
      $smarty ->assign('vmod',$vmod); 
      $smarty ->assign('vmodal',$vmodal); 
      $smarty ->assign('nameimage',$nameimage); 

      // Vector Causales de la Devolucion
      $obj_query = $sql->query("SELECT * FROM stzcoded where derecho='M' and grupo='M' 
                                ORDER BY derecho,grupo,cod_causa");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
          $vcodcausa[$contobj] = $objs->cod_causa;
          $vdescausa[$contobj] = $objs->desc_causa;
	  $objs = $sql->objects('',$obj_query);}
   
      //if ($vest==1 || $vest==103 || $vest==123 || $vest==8) {
      if ($vest-1000==8) {  
       	 //Descripcion de causales para Devolucion por fondo
	 $smarty ->assign('lcausadev','Causales de Devoluci&oacute;n - Examen de Fondo:'); 
      }  ELSE {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('Solo Aplica en Solicitudes que tengan Estatus: 8','m_devfondo.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
   }
   
   if ($vopc==3) {
    if($vcausa1 =='on'){$vc1 ='X';};if($vcausa2 =='on'){$vc2 ='X';};if($vcausa3 =='on'){$vc3 ='X';}
    if($vcausa4 =='on'){$vc4 ='X';};if($vcausa5 =='on'){$vc5 ='X';};if($vcausa6 =='on'){$vc6 ='X';}
    if($vcausa7 =='on'){$vc7 ='X';};if($vcausa8 =='on'){$vc8 ='X';};if($vcausa9 =='on'){$vc9 ='X';}
    if($vcausa10=='on'){$vc10='X';};if($vcausa11=='on'){$vc11='X';};if($vcausa12=='on'){$vc12='X';}
    if($vcausa13=='on'){$vc13='X';};if($vcausa14=='on'){$vc14='X';};if($vcausa15=='on'){$vc15='X';}
    if($vcausa16=='on'){$vc16='X';};if($vcausa17=='on'){$vc17='X';};if($vcausa18=='on'){$vc18='X';}
    if($vcausa19=='on'){$vc19='X';};if($vcausa20=='on'){$vc20='X';};if($vcausa21=='on'){$vc21='X';}
    if($vcausa22=='on'){$vc22='X';};if($vcausa23=='on'){$vc23='X';};if($vcausa24=='on'){$vc24='X';}
    if($vcausa25=='on'){$vc25='X';}

      $allcausas = $vc1.$vc2.$vc3.$vc4.$vc5.$vc6.$vc7.$vc8.$vc9.$vc10.$vc11.$vc12.$vc13.$vc14.
                   $vc15.$vc16.$vc17.$vc18.$vc19.$vc20.$vc21.$vc22.$vc23.$vc24.$vc25.$votro;
      if ($vsolh=='-' || $vfevh=='' || $allcausas=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS',
                    'javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit();  
      }
      $esmayor=compara_fechas($vfevh,$vfec);
      if ($esmayor==1) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('No se puede cargar un Evento a futuro','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); 
      }
           
      //Validacion adiconal por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$nderec'");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      $vfecsol= $regsol[fecha_solic];
      //if ($vest==1 || $vest==103 || $vest==123 || $vest==8) { //Esta bien
      if ($vest-1000==8) { //Esta bien
      } else {
         $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew($vest.'ERROR AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario',
                     'm_devfondo.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      //$vfecsol=convertir_en_fecha($vfecsol,1);
      $esmayor=compara_fechas($vfecsol,$vfevh);
      if ($esmayor==1) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('No se puede cargar un evento previo a la Fecha de la Solicitud',
                    'javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
         }
               
      // Evento Cableado (1500) se presume que los estatus finales son:
      //if ($vest-1000 ==1)   {$vestfin =200; $vtipdev='1'; $vdese='SOLICITUD EN EXAMEN DE FORMA';}
      //if ($vest ==103) {$vestfin =116; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      //if ($vest ==123) {$vestfin =117; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      //if ($vest ==8)   {$vestfin =200; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      if ($vest-1000==8)   {$vestfin = 116; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      
      pg_exec("BEGIN WORK");
      // Inserta en Stzcaded
      $ins_de=true;
      $inscaus = 0;
      $col_campos = "nro_derecho,cod_causa,derecho,grupo,tipo_dev,fecha_dev,hora";
      if ($vcausa1 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',1,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa2 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',2,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa3 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',3,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa4 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',4,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa5 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',5,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa6 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',6,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa7 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',7,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa8 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',8,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa9 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',9,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa10=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',10,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa11=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',11,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa12=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',12,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa13=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',13,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa14=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',14,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa15=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',15,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa16=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',16,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa17=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',17,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa18=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',18,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa19=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',19,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa20=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',20,'M','M','D','$vfec','$hh'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa21=='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',21,'M','M','D','$vfec','$hh'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa22=='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',22,'M','M','D','$vfec','$hh'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa23=='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',23,'M','M','D','$vfec','$hh'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa24=='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',24,'M','M','D','$vfec','$hh'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa25=='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',25,'M','M','D','$vfec','$hh'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }

      $votro = trim($votro);
      if ($votro<>'') {
        $col_campos = "nro_derecho,otros,derecho,grupo,tipo_dev,fecha_dev,hora";
        $ins_otros = $sql->insert("stzotrde","$col_campos","'$nderec','$votro','M','M','D','$vfec','$hh'",""); 
        if (!$ins_otros) { $inscaus = $inscaus + 1; } }
      
      // Actualizar Stzderec
      $update_str="estatus='$vestfin'+1000";
      $ins_otros = $sql->update("stzderec","$update_str","nro_derecho='$nderec'");    
      if (!$ins_otros) { $inscaus = $inscaus + 1; }             
      $vdese = "DEVUELTA POR EXAMEN DE FONDO";
      // Insertar en Stzevtrd 
      //Carga del Evento 53
      $insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,
                     fecha_trans,usuario,desc_evento,hora";
      $insert_valores ="$nderec,1053,'$vfevh','$vest',0,
                        '$vfec','$vuser','$vdese','$hh'";
      $ins_otros = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 
      if (!$ins_otros) { $inscaus = $inscaus + 1; }
      
      $vdese = "OFICIO DE DEVOLUCION";
      //Carga del Evento 500    
      $insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,
                      fecha_trans,usuario,desc_evento,hora";
      $insert_valores ="$nderec,1500,'$vfevh','$vest',0,
                        '$vfec','$vuser','$vdese','$hh'";
      $ins_otros = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 
      if (!$ins_otros) { $inscaus = $inscaus + 1; }

      if ($inscaus==0) { 
        pg_exec("COMMIT WORK"); $sql->disconnect(); 
        $smarty->display('encabezado1.tpl');
        mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_devfondo.php','S');
        $smarty->display('pie_pag.tpl'); exit();   
      }
      else {
        pg_exec("ROLLBACK WORK"); $sql->disconnect();
        $smarty->display('encabezado1.tpl');
        mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!",
                   "javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();    
      }
      
   }   
   //Asignaciion de variables para pasarlas a Smarty
   $smarty ->assign('nderec',$nderec); 
   $smarty ->assign('vopc',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('nombre',$vnom); 
   $smarty ->assign('clase',$vcla); 
   $smarty ->assign('vfevh',$vfevh); 
   $smarty ->assign('vfec',$vfec); 
   $smarty ->assign('vfecsol',$vfecsol); 
   $smarty ->assign('causa1',$vcausa1); 
   $smarty ->assign('causa2',$vcausa2); 
   $smarty ->assign('causa3',$vcausa3); 
   $smarty ->assign('causa4',$vcausa4); 
   $smarty ->assign('causa5',$vcausa5); 
   $smarty ->assign('causa6',$vcausa6); 
   $smarty ->assign('causa7',$vcausa7); 
   $smarty ->assign('causa8',$vcausa8); 
   $smarty ->assign('causa9',$vcausa9); 
   $smarty ->assign('causa10',$vcausa10); 
   $smarty ->assign('causa11',$vcausa11); 
   $smarty ->assign('causa12',$vcausa12); 
   $smarty ->assign('causa13',$vcausa13); 
   $smarty ->assign('causa14',$vcausa14); 
   $smarty ->assign('causa15',$vcausa15); 
   $smarty ->assign('causa16',$vcausa16); 
   $smarty ->assign('causa17',$vcausa17);
   $smarty ->assign('causa18',$vcausa18); 
   $smarty ->assign('causa19',$vcausa19); 
   $smarty ->assign('causa20',$vcausa20); 
   $smarty ->assign('causa21',$vcausa21); 
   $smarty ->assign('causa22',$vcausa22); 
   $smarty ->assign('causa23',$vcausa23); 
   $smarty ->assign('causa24',$vcausa24); 
   $smarty ->assign('causa25',$vcausa25); 
   $smarty ->assign('codcausa',$vcodcausa);
   $smarty ->assign('descausa',$vdescausa); 

   if ($vindcla=="I") {$smarty ->assign('ind_claseni','INTERNACIONAL');}; 
   if ($vindcla=="N") {$smarty ->assign('ind_claseni','NACIONAL');}; 
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lfechasolic','Fecha de Solicitud:'); 
   $smarty ->assign('lfechaevent','Fecha del Evento:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lclase','Clase:'); 
   $smarty ->assign('lotro','Otro:'); 
   $smarty ->assign('lmodal','Modalidad:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_devfondo.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
