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

$smarty ->assign('titulo',$substpat); 
$smarty ->assign('subtitulo','Modulo de Devoluciones'); 
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
   $vbol   =$_POST['vbol'];
   $vfec=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('vmodo',''); 
   
   $sql->connection($login);   
   
   //Verifica si el progrma esta en mantenimiento
   $manphp = vman_php("p_devoluci_mod.php");
   if ($manphp==1) {
     $sql->disconnect(); 
     $smarty->display('encabezado1.tpl');
     MensageError('Modulo en Mantenimiento ...!!!','N');
     $smarty->display('pie_pag.tpl'); exit();
	}      

   if ($vopc==1) {
      $resultado=pg_exec("SELECT nro_derecho,solicitud,
                        Tipo_derecho as tipo_paten,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante
                       FROM stzderec  
                       WHERE tipo_mp='P' and solicitud= '$vsol'");}
   if ($vopc==1) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas2.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      
      if (!$resultado) { 
         $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL PROCESAR LA BUSQUEDA','p_devoluci_mod.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS','p_devoluci_mod.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vnom=$reg[nombre];
      $vest=$reg[estatus];
      $vfecsol=$reg[fecha_solic];
      $nderec=$reg[nro_derecho];
      $vmod=$reg[tipo_paten];
      if ($vmod=='F') {$vmodal='MODELO UTILIDAD';}
      if ($vmod=='G') {$vmodal='DISEÑO INDUSTRIAL';}
      if ($vmod=='A') {$vmodal='INVENCION';}
      if ($vmod=='V') {$vmodal='VARIEDAD VEGETAL';}
      if ($vmod=='E') {$vmodal='MODELO INDUSTRIAL';}
      if ($vmod=='B') {$vmodal='DIBUJO INDUSTRIAL';}
      if ($vmod=='C') {$vmodal='DE MEJORAS';}
      if ($vmod=='D') {$vmodal='DE INTRODUCCION';}
      $nameimage=ver_imagen($vsol1,$vsol2,'P'); 
      $smarty ->assign('vmod',$vmod); 
      $smarty ->assign('vmodal',$vmodal); 
      $smarty ->assign('nameimage',$nameimage); 

      // Vector Causales de la Devolucion
      $obj_query = $sql->query("SELECT * FROM stzcoded where derecho='P' and grupo='M' 
                                ORDER BY derecho,grupo,cod_causa");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
          $vcodcausa[$contobj] = $objs->cod_causa;
          $vdescausa[$contobj] = $objs->desc_causa;
	  $objs = $sql->objects('',$obj_query);}
   
      //if ($vest==1 || $vest==103 || $vest==123 || $vest==8) {
      if ($vest-2000==200) {  
       	 //Descripcion de causales para Devolucion por forma
	 $smarty ->assign('lcausadev','Causales de Devoluci&oacute;n - Examen de Forma:'); 
      }  ELSE {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('Solo Aplica en Solicitudes que tengan Estatus: 200 (Devuelta)','p_devoluci_mod.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      //Inicializa variables para modificar
      //Stzcaded
      $obj_query = $sql->query("SELECT * FROM stzcaded where nro_derecho='$nderec' 
                                ORDER BY cod_causa");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $objs = $sql->objects('',$obj_query);
      $ccausa1='';$ccausa2='';$ccausa3='';$ccausa4='';$ccausa5='';
      $ccausa6='';$ccausa7='';$ccausa8='';$ccausa9='';$ccausa10='';
      $ccausa11='';$ccausa12='';$ccausa13='';$ccausa14='';$ccausa15='';
      $ccausa16='';$ccausa17='';$ccausa18='';$ccausa19='';$ccausa20='';
      $ccausa21='';$ccausa22='';$ccausa23='';$ccausa24='';$ccausa25='';
      for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
        if ($objs->cod_causa==1) {$ccausa1='checked';}
        if ($objs->cod_causa==2) {$ccausa2='checked';}
        if ($objs->cod_causa==3) {$ccausa3='checked';}
        if ($objs->cod_causa==4) {$ccausa4='checked';}
        if ($objs->cod_causa==5) {$ccausa5='checked';}
        if ($objs->cod_causa==6) {$ccausa6='checked';}
        if ($objs->cod_causa==7) {$ccausa7='checked';}
        if ($objs->cod_causa==8) {$ccausa8='checked';}
        if ($objs->cod_causa==9) {$ccausa9='checked';}
        if ($objs->cod_causa==10) {$ccausa10='checked';}
        if ($objs->cod_causa==11) {$ccausa11='checked';}
        if ($objs->cod_causa==12) {$ccausa12='checked';}
        if ($objs->cod_causa==13) {$ccausa13='checked';}
        if ($objs->cod_causa==14) {$ccausa14='checked';}
        if ($objs->cod_causa==15) {$ccausa15='checked';}
        if ($objs->cod_causa==16) {$ccausa16='checked';}
        if ($objs->cod_causa==17) {$ccausa17='checked';}
        if ($objs->cod_causa==18) {$ccausa18='checked';}
        if ($objs->cod_causa==19) {$ccausa19='checked';}
        if ($objs->cod_causa==20) {$ccausa20='checked';}
        if ($objs->cod_causa==21) {$ccausa21='checked';}
        if ($objs->cod_causa==22) {$ccausa22='checked';}
        if ($objs->cod_causa==23) {$ccausa23='checked';}
        if ($objs->cod_causa==24) {$ccausa24='checked';}
        if ($objs->cod_causa==25) {$ccausa25='checked';}
      $objs = $sql->objects('',$obj_query);}
      //Stzevtrd
      $obj_query = $sql->query("SELECT * FROM stzevtrd where nro_derecho='$nderec' and evento=2500");
      $obj_filas = $sql->nums('',$obj_query);
      $objs = $sql->objects('',$obj_query);
      $vbol=$objs->documento;
      //Stzotrde
      $obj_query = $sql->query("SELECT * FROM stzotrde where nro_derecho='$nderec'");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $objs = $sql->objects('',$obj_query);
      $votro=$objs->otros;
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
      if ($vest-2000==200) { //Esta bien
      } else {
         $sql->disconnect(); 
         $smarty->display('encabezado1.tpl');
    mensajenew($vest.'ERROR AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario',
                     'p_devoluci_mod.php','N');
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
      if ($vest-2000 ==1)   {$vestfin =200; $vtipdev='1'; $vdese='SOLICITUD EN EXAMEN DE FORMA';}
      //if ($vest ==103) {$vestfin =116; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      //if ($vest ==123) {$vestfin =117; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      //if ($vest ==8)   {$vestfin =200; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      //if ($vest ==8)   {$vestfin =116; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      
      pg_exec("BEGIN WORK");
      // eliminar todos los registros existentes en stzcaded
      $obj_query = $sql->query("DELETE FROM stzcaded where nro_derecho='$nderec'");
      // eliminar todos los registros existentes en stzotrde
      $obj_query = $sql->query("DELETE FROM stzotrde where nro_derecho='$nderec'");

      // Inserta en Stzcaded
      $ins_de=true;
      $inscaus = 0;
      $col_campos = "nro_derecho,cod_causa,derecho,grupo,tipo_dev,fecha_dev";
      if ($vcausa1 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',1,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa2 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',2,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa3 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',3,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa4 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',4,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa5 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',5,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa6 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',6,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa7 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',7,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa8 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',8,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa9 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',9,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa10=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',10,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa11=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',11,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa12=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',12,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa13=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',13,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa14=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',14,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa15=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',15,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa16=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',16,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa17=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',17,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa18=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',18,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa19=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',19,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa20=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',20,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa21=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',21,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa22=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',22,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa23=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',23,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa24=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',24,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa25=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$nderec',25,'P','M','M','$vfec'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }

      $votro = trim($votro);
      if ($votro<>'') {
        $col_campos = "nro_derecho,otros,derecho,grupo,tipo_dev,fecha_dev";
        $ins_otros = 
              $sql->insert("stzotrde","$col_campos","'$nderec','$votro','P','M','M','$vfec'",""); 
        if (!$ins_otros) { $inscaus = $inscaus + 1; } }
      
      // Actualizar Stzderec
//      $update_str="estatus='$vestfin'+2000";
//      $ins_otros = $sql->update("stzderec","$update_str","nro_derecho='$nderec'");    
//      if (!$ins_otros) { $inscaus = $inscaus + 1; }             

     
      //Carga del Evento 500    
//      $insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,
//                      fecha_trans,usuario,desc_evento,hora";
//      $insert_valores ="$nderec,2500,'$vfevh',$vest,'$vbol',
//                        '$vfec','$vuser','$vdese','$hh'";
//      $ins_otros = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 
//      if (!$ins_otros) { $inscaus = $inscaus + 1; }
//      Actualizar evento 500
      $update_str="documento=$vbol";
      $ins_otros = $sql->update("stzevtrd","$update_str","nro_derecho='$nderec' and evento=2500");    
      if (!$ins_otros) { $inscaus = $inscaus + 1; }         

      if ($inscaus==0) { 
        pg_exec("COMMIT WORK"); $sql->disconnect(); 
        $smarty->display('encabezado1.tpl');
        mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','p_devoluci_mod.php','S');
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
   $smarty ->assign('vbol',$vbol); 
   $smarty ->assign('ccausa1',$ccausa1); 
   $smarty ->assign('ccausa2',$ccausa2); 
   $smarty ->assign('ccausa3',$ccausa3); 
   $smarty ->assign('ccausa4',$ccausa4); 
   $smarty ->assign('ccausa5',$ccausa5); 
   $smarty ->assign('ccausa6',$ccausa6); 
   $smarty ->assign('ccausa7',$ccausa7); 
   $smarty ->assign('ccausa8',$ccausa8); 
   $smarty ->assign('ccausa9',$ccausa9); 
   $smarty ->assign('ccausa10',$ccausa10); 
   $smarty ->assign('ccausa11',$ccausa11); 
   $smarty ->assign('ccausa12',$ccausa12); 
   $smarty ->assign('ccausa13',$ccausa13); 
   $smarty ->assign('ccausa14',$ccausa14); 
   $smarty ->assign('ccausa15',$ccausa15); 
   $smarty ->assign('ccausa16',$ccausa16); 
   $smarty ->assign('ccausa17',$ccausa17);
   $smarty ->assign('ccausa18',$ccausa18); 
   $smarty ->assign('ccausa19',$ccausa19); 
   $smarty ->assign('ccausa20',$ccausa20); 
   $smarty ->assign('ccausa21',$ccausa21); 
   $smarty ->assign('ccausa22',$ccausa22); 
   $smarty ->assign('ccausa23',$ccausa23); 
   $smarty ->assign('ccausa24',$ccausa24); 
   $smarty ->assign('ccausa25',$ccausa25); 
   $smarty ->assign('codcausa',$vcodcausa);
   $smarty ->assign('descausa',$vdescausa); 
   $smarty ->assign('otro',$votro); 

   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lfechasolic','Fecha de Solicitud:'); 
   $smarty ->assign('lfechaevent','Fecha del Evento:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lotro','Otro:'); 
   $smarty ->assign('lmodal','Tipo de Patente:');
   $smarty ->assign('lboletin','No. Bolet&iacute;n a salir Publicada:');
    
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('p_devoluci_mod.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
