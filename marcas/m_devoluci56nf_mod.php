<? 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);
$login   = trim($_SESSION['usuario_login']);
$role    = $_SESSION['usuario_rol'];
$hh=hora();
$sql = new mod_db(); 
$fecha=fechahoy();  

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Modificaci&oacute;n Devoluci&oacute;n de Forma (L.P.I. 10/12/1956) NUEVO FORMATO'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
$smarty->display('encabezado1.tpl');
  
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
   $vsubcausa1=$_POST['subcausa1']; $vsubcausa2=$_POST['subcausa2']; 
   $vsubcausa3=$_POST['subcausa3']; $vsubcausa4=$_POST['subcausa4']; $vsubcausa5=$_POST['subcausa5']; 
   $vsubcausa6=$_POST['subcausa6']; $vsubcausa7=$_POST['subcausa7']; $vsubcausa8=$_POST['subcausa8']; 
   $vsubcausa9=$_POST['subcausa9']; $vsubcausa10=$_POST['subcausa10']; $vsubcausa11=$_POST['subcausa11']; 
   $vsubcausa12=$_POST['subcausa12']; $vsubcausa13=$_POST['subcausa13']; $vsubcausa14=$_POST['subcausa14']; 
   $vsubcausa15=$_POST['subcausa15']; $vsubcausa16=$_POST['subcausa16']; 
   $votro  =$_POST['otro'];
   $vfec=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('vmodo',''); 

   //if (($login=='rmendoza') || ($login=='ngonzalez') || ($login=='saissami')) { }	
   //else { 
   //  Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo ...!!!","../index1.php","N");
   //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
   //}  
  
   $sql->connection($login);   
   
   //Verifica si el progrma esta en mantenimiento
   $manphp = vman_php("m_devoluci56nf_mod.php");
   if ($manphp==1) {
     $sql->disconnect(); 
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
         //$smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL PROCESAR LA BUSQUEDA','m_devoluci56nf_mod.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         //$smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS','m_devoluci56nf_mod.php','N');
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

      $obj_qtram = $sql->query("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento='1053' AND usuario='$usuario'");
      $obj_ftram = $sql->nums('',$obj_qtram);
      if ($obj_ftram==0) {
        $sql->disconnect();
        //$smarty->display('encabezado1.tpl');
        mensajenew('AVISO: El Usuario que aplic&oacute; la Devolucion NO corresponde con '.$usuario.' ...!!!','m_devoluci56nf_mod.php','N');
	$smarty->display('pie_pag.tpl'); exit(); 
      }

      // Vector Causales de la Devolucion  ********* ORIGINAL *********
      /*$obj_query = $sql->query("SELECT * FROM stzcoded where derecho='M' and grupo='M' 
                                ORDER BY derecho,grupo,cod_causa");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
          $vcodcausa[$contobj] = $objs->cod_causa;
          $vdescausa[$contobj] = $objs->desc_causa;
	       $objs = $sql->objects('',$obj_query);}*/

      // Vector Causales de la Devolucion ** MODIFICADO JHORMAR TORREALBA **
      $obj_query = $sql->query("SELECT * FROM stzcadev where derecho='M' and grupo='M' ORDER BY derecho,grupo,cod_causa");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
        $vcodcausa[$contobj] = $objs->cod_causa;
        $vdescausa[$contobj] = $objs->desc_causa;
        $objs = $sql->objects('',$obj_query); }

	  // DETERMINAMOS LAS SUBCAUSAS CORRIENDO EL ARRAY PARA CADA CAUSA DETECTADA
	  $obj_query2 = $sql->query("SELECT * FROM stzsubcodev where derecho='M' and grupo='M' and sub_causa !='0' ORDER BY derecho,grupo,cod_causa");
	  $obj_filas2 = $sql->nums('',$obj_query2);
	  $contobj2 = 0;
	  $objs2 = $sql->objects('',$obj_query2);
	  for ($contobj2=0;$contobj2<=$obj_filas2;$contobj2++) {
	    $vcodcausa2[$contobj2] = $objs2->cod_causa;
	    $vcodsubcausa[$contobj2] = $objs2->sub_causa;
	    $vdessubcausa[$contobj2] = $objs2->desc_sub_causa;
	    $objs2 = $sql->objects('',$obj_query2); } 
	  	$smarty ->assign('codcausa2',$vcodcausa2);
	  	$smarty ->assign('codsubcausa',$vcodsubcausa);
		$smarty ->assign('dessubcausa',$vdessubcausa); 
	    // FIN DEL ARRAY
  
      //if ($vest==1 || $vest==103 || $vest==123 || $vest==8) {
      if ($vest-1000==200) {  
        //Descripcion de causales para Devolucion por forma
	$smarty ->assign('lcausadev','Causales de Devoluci&oacute;n - Examen de Forma:'); 
      }  else {
        $sql->disconnect();
        //$smarty->display('encabezado1.tpl');
        mensajenew('Solo Aplica en Solicitudes que tengan Estatus: 200','m_devoluci56nf_mod.php','N');
	$smarty->display('pie_pag.tpl'); exit(); 
      }

      //Inicializa variables para modificar
      //Stzcaded
      $obj_query = $sql->query("SELECT * FROM stzsoldev where nro_derecho='$nderec' AND derecho='M' AND grupo='M' AND tipo_dev='M' ORDER BY cod_causa,sub_causa");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $objs = $sql->objects('',$obj_query);
      $ccausa1='';$ccausa2='';$ccausa3='';$ccausa4='';$ccausa5='';
      $ccausa6='';$ccausa7='';$ccausa8='';$ccausa9='';$ccausa10='';
      $ccausa11='';$ccausa12='';$ccausa13='';$ccausa14='';$ccausa15='';
      $ccausa16='';$ccausa17='';$ccausa18='';$ccausa19='';$ccausa20='';
      $ccausa21='';$ccausa22='';$ccausa23='';$ccausa24='';
      for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
        if ($objs->cod_causa==1) {
          $ccausa1='checked';
          if ($objs->sub_causa==1) {$cscausa1='checked';}
          if ($objs->sub_causa==2) {$cscausa2='checked';}
          if ($objs->sub_causa==3) {$cscausa3='checked';}
        }
        if ($objs->cod_causa==2) {
          $ccausa2='checked';
          if ($objs->sub_causa==1) {$cscausa4='checked';}
          if ($objs->sub_causa==2) {$cscausa5='checked';}
        }
        if ($objs->cod_causa==3) {
          $ccausa3='checked';
          if ($objs->sub_causa==1) {$cscausa6='checked';}
          if ($objs->sub_causa==2) {$cscausa7='checked';}
          if ($objs->sub_causa==3) {$cscausa8='checked';}
        }
        if ($objs->cod_causa==4) {$ccausa4='checked';}
        if ($objs->cod_causa==5) {$ccausa5='checked';}
        if ($objs->cod_causa==6) {$ccausa6='checked';}
        if ($objs->cod_causa==7) {$ccausa7='checked';}
        if ($objs->cod_causa==8) {$ccausa8='checked';}
        if ($objs->cod_causa==9) {$ccausa9='checked';}
        if ($objs->cod_causa==10) {$ccausa10='checked';}
        if ($objs->cod_causa==11) {$ccausa11='checked';}
        if ($objs->cod_causa==12) {$ccausa12='checked';}
        if ($objs->cod_causa==13) {
          $ccausa13='checked';
          if ($objs->sub_causa==1) {$cscausa9='checked';}
          if ($objs->sub_causa==2) {$cscausa10='checked';}
          if ($objs->sub_causa==3) {$cscausa11='checked';}
          if ($objs->sub_causa==4) {$cscausa12='checked';}
          if ($objs->sub_causa==5) {$cscausa13='checked';}
          if ($objs->sub_causa==6) {$cscausa14='checked';}
          if ($objs->sub_causa==7) {$cscausa15='checked';}
          if ($objs->sub_causa==8) {$cscausa16='checked';}
        }
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
        $objs = $sql->objects('',$obj_query);
      }
      //Stzotrde
      $obj_query = $sql->query("SELECT * FROM stzotrode where nro_derecho='$nderec'");
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
    //if($vcausa25=='on'){$vc25='X';}

    if($vsubcausa1 =='on'){$vsc1 ='X';};if($vsubcausa2 =='on'){$vsc2 ='X';};if($vsubcausa3 =='on'){$vsc3 ='X';}
    if($vsubcausa4 =='on'){$vsc4 ='X';};if($vsubcausa5 =='on'){$vsc5 ='X';};if($vsubcausa6 =='on'){$vsc6 ='X';}
    if($vsubcausa7 =='on'){$vsc7 ='X';};if($vsubcausa8 =='on'){$vsc8 ='X';};if($vsubcausa9 =='on'){$vsc9 ='X';}
    if($vsubcausa10=='on'){$vsc10='X';};if($vsubcausa11=='on'){$vsc11='X';};if($vsubcausa12=='on'){$vsc12='X';}
    if($vsubcausa13=='on'){$vsc13='X';};if($vsubcausa14=='on'){$vsc14='X';};if($vsubcausa15=='on'){$vsc15='X';}
    if($vsubcausa16=='on'){$vsc16='X';}

      $allcausas = $vc1.$vc2.$vc3.$vc4.$vc5.$vc6.$vc7.$vc8.$vc9.$vc10.$vc11.$vc12.$vc13.
      			   $vc14.$vc15.$vc16.$vc17.$vc18.$vc19.$vc20.$vc21.$vc22.$vc23.$vc24.
                   $vsc1.$vsc2.$vsc3.$vsc4.$vsc5.$vsc6.$vsc7.$vsc8.$vsc9.$vsc10.$vsc11.$vsc12.
                   $vsc13.$vsc14.$vsc15.$vsc16.$votro;
      if ($vsolh=='-' || $vfevh=='' || $allcausas=='') {
         $sql->disconnect();
         //$smarty->display('encabezado1.tpl');
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - DATOS INCORRECTOS ...!!!','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit();  
      }
      $esmayor=compara_fechas($vfevh,$vfec);
      if ($esmayor==1) {
         $sql->disconnect();
         //$smarty->display('encabezado1.tpl');
         mensajenew('ERROR: No se puede cargar un Evento a futuro','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); 
      }
           
      //Validacion adicional por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$nderec'");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      $vfecsol= $regsol[fecha_solic];
      $vsold  = $regsol[solicitud];
      $vsol1=substr($vsold,-11,4);
      $vsol2=substr($vsold,-6,6);

      //if ($vest==1 || $vest==103 || $vest==123 || $vest==8) { //Esta bien
      if ($vest-1000==200) { //Esta bien
      } else {
         $sql->disconnect(); 
         //$smarty->display('encabezado1.tpl');
         mensajenew($vest.'ERROR: PROBLEMA AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario ...!!!','m_devoluci56nf_mod.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
      //$vfecsol=convertir_en_fecha($vfecsol,1);
      $esmayor=compara_fechas($vfecsol,$vfevh);
      if ($esmayor==1) {
         $sql->disconnect();
         //$smarty->display('encabezado1.tpl');
         mensajenew('ERROR: No se puede cargar un evento previo a la Fecha de la Solicitud ...!!!','javascript:history.back();','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
               
      // Evento Cableado (1500) se presume que los estatus finales son:
      if ($vest-1000 ==200)   {$vestfin =200; $vtipdev='1'; $vdese='SOLICITUD EN EXAMEN DE FORMA';}
      
      pg_exec("BEGIN WORK");
      // eliminar todos los registros existentes en stzsoldev
      $obj_query = $sql->query("DELETE FROM stzsoldev WHERE nro_derecho='$nderec'");
      // eliminar todos los registros existentes en stzotrode
      $obj_query = $sql->query("DELETE FROM stzotrode where nro_derecho='$nderec'");

      // Inserta en Stzcaded
      $ins_de=true;
      $inscaus = 0;
      $col_campos = "nro_derecho,cod_causa,sub_causa,derecho,grupo,tipo_dev,fecha_dev,hora,usuario";
      if ($vsubcausa1 =='on') { // Subcausa 1
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',1,1,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa2 =='on') { // Subcausa 1
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',1,2,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa3 =='on') { // Subcausa 1
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',1,3,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }

      if ($vsubcausa4 =='on') { // Subcausa 2
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',2,1,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa5 =='on') { // Subcausa 2
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',2,2,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }

      if ($vsubcausa6 =='on') { // Subcausa 3
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',3,1,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa7 =='on') { // Subcausa 3
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',3,2,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa8 =='on') { // Subcausa 3
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',3,3,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }

      if ($vcausa4 =='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',4,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa5 =='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',5,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa6 =='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',6,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa7 =='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',7,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa8 =='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',8,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa9 =='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',9,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa10=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',10,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa11=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',11,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa12=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',12,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }

      if ($vsubcausa9 =='on') { // Subcausa 13
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',13,1,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa10 =='on') { // Subcausa 13
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',13,2,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa11 =='on') { // Subcausa 13
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',13,3,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa12 =='on') { // Subcausa 13
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',13,4,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa13 =='on') { // Subcausa 13
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',13,5,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa14 =='on') { // Subcausa 13
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',13,6,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa15 =='on') { // Subcausa 13
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',13,7,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vsubcausa16 =='on') { // Subcausa 13
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',13,8,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }

      if ($vcausa14=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',14,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa15=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',15,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa16=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',16,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa17=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',17,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa18=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',18,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa19=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',19,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa20=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',20,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa21=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',21,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa22=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',22,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa23=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',23,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa24=='on') {
        $ins_de=$sql->insert("stzsoldev","$col_campos","'$nderec',24,0,'M','M','M','$vfec','$hh','$vuser'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }

      $votro = trim($votro); // Tabla carga de los anexos. Se utilizara la tabla 'stzotrode' 
      if ($votro<>'') {
        $col_campos = "nro_derecho,otros,derecho,grupo,tipo_dev,fecha_dev,hora";
        $ins_otros = 
              $sql->insert("stzotrode","$col_campos","'$nderec','$votro','M','M','M','$vfec','$hh'",""); 
        if (!$ins_otros) { $inscaus = $inscaus + 1; } }
      
      // Actualizar Stzderec
      //$update_str="estatus='$vestfin'+1000";
      //$ins_otros = $sql->update("stzderec","$update_str","nro_derecho='$nderec'");    
      //if (!$ins_otros) { $inscaus = $inscaus + 1; }             

      // Insertar en Stzevtrd 
      //Carga del Evento 53
      //$insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
      //$insert_valores ="$nderec,1053,'$vfevh','$vest',0,'$vfec','$vuser','$vdese','$hh'";
      //$ins_otros = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 
      //if (!$ins_otros) { $inscaus = $inscaus + 1; }
      
      //Carga del Evento 500    
      //$insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
      //$insert_valores ="$nderec,1500,'$vfevh','$vest',0,'$vfec','$vuser','$vdese','$hh'";
      //$ins_otros = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 
      //if (!$ins_otros) { $inscaus = $inscaus + 1; }

      //$aa =substr($vfec,6,4);  
      //$mm =substr($vfec,3,2);  
      //$dd =substr($vfec,0,2);  
      //$hor=substr($hh,0,2);    
      //$min=substr($hh,3,2);  
      //$seg=substr($hh,6,2);  
      //$tur=substr($hh,9,2);  
      //$codseg2=generarCodigo(15);
      
      //$codseg1=$nderec."M".$vsol1.$vsol2.$dd.$mm.$aa.$hor.$min.$seg.$tur.$codseg2.'1053';

      //Codigo de la Seguridad    
      //$insert_campos="nro_derecho,solicitud,derecho,evento,fecha_dev,hora,codigo1,codigo2,usuario";
      //$insert_valores ="$nderec,'$vsold','M',1053,'$vfec','$hh','$codseg1','$codseg2','$vuser'";
      //$ins_otros = $sql->insert("stzsegudev","$insert_campos","$insert_valores","");	 
      //if (!$ins_otros) { $inscaus = $inscaus + 1; }

      if ($inscaus==0) { 
        pg_exec("COMMIT WORK"); $sql->disconnect(); 
        //$smarty->display('encabezado1.tpl');
        //Mensaje2("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_devoluci56n.php","m_rptdevform.php?vsol=$vsold&vusr=$usuario");
        $vmessage="DATOS GUARDADOS CORRECTAMENTE ...!!!";
        echo "<H3><p><img src='../imagenes/messagebox_info.png' align='middle'>$vmessage</p></H3>"; 
        echo "<p align='center'><a href='m_devoluci56nf_mod.php'><img src='../imagenes/apply_f2.png' border='0'></a>  Continuar&nbsp;&nbsp;&nbsp;&nbsp;<a href='m_rptdevform.php?vsol=$vsold&vusr=$usuario' target='_blank'><img src='../imagenes/printmgr.png' border='0'></a> Imprimir </p>";
        $smarty->display('pie_pag.tpl'); exit();   
      }
      else {
        pg_exec("ROLLBACK WORK"); $sql->disconnect();
        //$smarty->display('encabezado1.tpl');
        mensajenew("ERROR: Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!","javascript:history.back();","N");
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
   $smarty ->assign('subcausa1',$vsubcausa1); 
   $smarty ->assign('subcausa2',$vsubcausa2); 
   $smarty ->assign('subcausa3',$vsubcausa3); 
   $smarty ->assign('subcausa4',$vsubcausa4); 
   $smarty ->assign('subcausa5',$vsubcausa5); 
   $smarty ->assign('subcausa6',$vsubcausa6); 
   $smarty ->assign('subcausa7',$vsubcausa7); 
   $smarty ->assign('subcausa8',$vsubcausa8); 
   $smarty ->assign('subcausa9',$vsubcausa9); 
   $smarty ->assign('subcausa10',$vsubcausa10); 
   $smarty ->assign('subcausa11',$vsubcausa11); 
   $smarty ->assign('subcausa12',$vsubcausa12); 
   $smarty ->assign('subcausa13',$vsubcausa13); 
   $smarty ->assign('subcausa14',$vsubcausa14); 
   $smarty ->assign('subcausa15',$vsubcausa15); 
   $smarty ->assign('subcausa16',$vsubcausa16); 
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

   $smarty ->assign('cscausa1',$cscausa1); 
   $smarty ->assign('cscausa2',$cscausa2); 
   $smarty ->assign('cscausa3',$cscausa3); 
   $smarty ->assign('cscausa4',$cscausa4); 
   $smarty ->assign('cscausa5',$cscausa5); 
   $smarty ->assign('cscausa6',$cscausa6); 
   $smarty ->assign('cscausa7',$cscausa7); 
   $smarty ->assign('cscausa8',$cscausa8); 
   $smarty ->assign('cscausa9',$cscausa9); 
   $smarty ->assign('cscausa10',$cscausa10); 
   $smarty ->assign('cscausa11',$cscausa11); 
   $smarty ->assign('cscausa12',$cscausa12); 
   $smarty ->assign('cscausa13',$cscausa13); 
   $smarty ->assign('cscausa14',$cscausa14); 
   $smarty ->assign('cscausa15',$cscausa15); 
   $smarty ->assign('cscausa16',$cscausa16); 
   $smarty ->assign('otro',$votro); 

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

   //$smarty ->display('encabezado1.tpl');
   $smarty ->display('m_devoluci56nf_mod.tpl'); 
   $smarty ->display('pie_pag.tpl');
?>
