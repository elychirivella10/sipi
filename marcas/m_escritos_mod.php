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
$vfecha=hoy();
$vanno=substr($vfecha,6,4);  
//Quitar o poner en esta variable los escritos que se pueden cargar
$escritos_validos    ='1020,1040,1041,1042,1043,1048,1080,1151,1152,1153,1154,1160,1165,1301,1304,1305,1307,1310,1320,1458';
$vector_escritos=array(1020,1040,1041,1042,1043,1048,1080,1151,1152,1153,1154,1160,1165,1301,1304,1305,1307,1310,1320,1458);

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Control Administrativo - Escritos Defectuosos'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
$vuser=$usuario;  
   
   //Captura Variables leidas en formulario inicial
   $vopc=   $_GET['vopc'];
   $vopcant=$_POST['vopcant'];   
   $vesc1=   $_POST['vesc1'];    if ($vesc1=='') {$vesc1= $_GET['vesc1']; }
   $vesc2=   $_POST['vesc2'];    if ($vesc2=='') {$vesc2= $_GET['vesc2']; }
   $vfecesc=$_POST['vfecesc'];   if ($vfecesc=='') {$vfecesc= $_GET['vfecesc']; }
   $vsol1=  $_POST['vsol1'];     if ($vsol1=='') {$vsol1= $_GET['vsol1']; }
   $vsol2=  $_POST['vsol2'];     if ($vsol2=='') {$vsol2= $_GET['vsol2']; }
   $vreg1=  $_POST['vreg1'];     if ($vreg1=='') {$vreg1= $_GET['vreg1']; }
   $vreg2=  $_POST['vreg2'];     if ($vreg2=='') {$vreg2= $_GET['vreg2']; }
   $vnom=   $_POST['vnom'];      if ($vnom=='') {$vnom= $_GET['vnom']; }
   $vindcla=$_POST['vindcla'];   if ($vindcla=='') {$vindcla= $_GET['vindcla']; }
   $vcla=$_POST['vcla'];         if ($vcla=='') {$vcla= $_GET['vcla']; }
   $vtipesc=$_POST['vtipesc'];   if ($vtipesc=='') {$vtipesc= $_GET['vtipesc']; }
   $vnomesc=$_POST['vnomesc'];   if ($vnomesc=='') {$vnomesc= $_GET['vnomesc']; }
   $vdoc=$_POST['vdoc'];         if ($vdoc=='') {$vdoc= $_GET['vdoc']; }
   $vcom=$_POST['vcom'];         if ($vcom=='') {$vcom= $_GET['vcom']; }  
   $vtra=$_POST['vtra'];         if ($vtra=='') {$vtra= $_GET['vtra']; }
   $vmot1=$_POST['vmot1'];       if ($vmot1=='') {$vmot1= $_GET['vmot1']; }
   $vmot2=$_POST['vmot2'];       if ($vmot2=='') {$vmot2= $_GET['vmot2']; }
   $vmot3=$_POST['vmot3'];       if ($vmot3=='') {$vmot3= $_GET['vmot3']; }
   $vmot4=$_POST['vmot4'];       if ($vmot4=='') {$vmot4= $_GET['vmot4']; }
   $vmot5=$_POST['vmot5'];       if ($vmot5=='') {$vmot5= $_GET['vmot5']; }
   $vmot6=$_POST['vmot6'];       if ($vmot6=='') {$vmot6= $_GET['vmot6']; }
   $vomot=trim($_POST['vomot']); if ($vomot=='') {$vomot= $_GET['vomot']; }
   $vcodagen=$_POST['vcodagen']; if ($vcodagen=='') {$vcodagen= $_GET['vcodagen']; }
   $vnomagen=$_POST['vnomagen']; if ($vnomagen=='') {$vnomagen= $_GET['vnomagen']; }     
   $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vesc=sprintf("%04d-%06d",$vesc1,$vesc2);
   $vreg=   $vreg1.$vreg2;
   $resultado=false;
   
   //cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vesc'); 
   $smarty ->assign('vmodo','');
   $smarty ->assign('vmodo1','readonly');  
   $smarty ->assign('vmodo2','readonly'); 
   $smarty ->assign('vmodo3','readonly'); 
   
   $sql->connection($login);   
   if ($vopc==1) {
     if ($vesc=='' || $vesc==0) { 
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR! Introduzca el N&uacute;mero del Escrito que desea modificar &oacute; eliminar...','m_escritos_mod.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
     }
     $resultado=pg_exec("SELECT * FROM stzescri WHERE nro_escrito='$vesc' and tipo_mp='M'");
     $res_filas = pg_numrows($resultado); 
     if ($res_filas==0) { 
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR! El Escrito No existe...','m_escritos_mod.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
     }	 

     $vopc=2; $vopcant=2;
     $smarty ->assign('submitbutton','button'); 
     $smarty ->assign('varfocus','formarcas5.vfecesc'); 
     $smarty ->assign('vmodo','readonly');
     $smarty ->assign('vmodo1','readonly');  
     $smarty ->assign('vmodo2',''); 
     $smarty ->assign('vmodo3','readonly'); 
     
     $reg = pg_fetch_array($resultado);
     $vsol=$reg[solicitud];
     $vsol1=substr($vsol,-11,4);
     $vsol2=substr($vsol,-6,6);
     $vreg=ltrim(rtrim($reg[registro]));
     $vreg1=substr($vreg,-7,1);
     $vreg2=substr($vreg,1);
     $vnom=$reg[nombre];
     $vindcla=$reg[ind_claseni];
     $vcla=$reg[clase];
     $vcodagen=$reg[codigo_agente];
     $vtra=$reg[tramitante];   
     //
     $vfecesc=$reg[fecha];   
     $vtipesc=$reg[tipo_escrito];   
     $vdoc=$reg[nro_boletin];   
     $vcom=$reg[comentario];   
     $vmotivos=$reg[motivo]; 
     $vomot=$reg[otro_motivo];    
     if (stripos($vmotivos,'1')!==false) {$vmot1=true;}
     if (stripos($vmotivos,'2')!==false) {$vmot2=true;}
     if (stripos($vmotivos,'3')!==false) {$vmot3=true;}
     if (stripos($vmotivos,'4')!==false) {$vmot4=true;}
     if (stripos($vmotivos,'5')!==false) {$vmot5=true;}
     if (stripos($vmotivos,'6')!==false) {$vmot6=true;}

     if ($vsol=='' || $vsol=='0000-000000') {$smarty ->assign('vmodo3',''); $smarty ->assign('varfocus','formarcas5.vnom'); $vopc=4; $vopcant=4;} 
     // Vector tipo de Escrito (Escritos de Marcas involucrados)
     $obj_query = $sql->query("SELECT evento,descripcion FROM stzevder where evento 
                             in ($escritos_validos) order by 1");
     $obj_filas = pg_numrows($obj_query); 
     $contobj = 0;
     $obj_reg = pg_fetch_array($obj_query);
     for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
          $vcodescnew[$contobj] = $obj_reg[evento]-1000;
          $vnomescnew[$contobj] = $obj_reg[descripcion];
          $obj_reg = pg_fetch_array($obj_query); }
     if ($vtipesc=='') {$vtipesc=$vcodescnew[0]; $vnomesc=$vnomescnew[0];} 
     if ($vtipesc<>'') {
        $vareve=$vtipesc+1000;
        $obj_query = $sql->query("SELECT evento,descripcion FROM stzevder where evento='$vareve'");
        $obj_reg = pg_fetch_array($obj_query);
        $vnomesc= $obj_reg[descripcion];
     } 
     // Vectores de Agentes
     $obj_query = $sql->query("SELECT agente,nombre FROM stzagenr order by nombre");
     $obj_filas = pg_numrows($obj_query); 
     $contobj = 0;
     $vcodagenew[$contobj] = '';
     $vnomagenew[$contobj] = '';
     $obj_reg = pg_fetch_array($obj_query);
     for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
          $vcodagenew[$contobj] = $obj_reg[agente];
          $vnomagenew[$contobj] = $obj_reg[nombre];
          $obj_reg = pg_fetch_array($obj_query); }

      if ($vcodagen==0) {$vcodagen='';} 
      if ($vcodagen!='') {
      $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vcodagen");
      $regage = pg_fetch_array($resulage);
      $vnomagen=$regage[nombre];
      }
   }   

   if ($vopc==2 || $vopc==3 || $vopc==4)  {   
      $vopcant=$vopc;
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas5.vfecesc'); 
      $smarty ->assign('vmodo','readonly');
      $smarty ->assign('vmodo1','readonly');  
      $smarty ->assign('vmodo2',''); 
      $smarty ->assign('vmodo3','readonly'); 
      if ($vsol=='' || $vsol=='0000-000000') {$smarty ->assign('vmodo3',''); $smarty ->assign('varfocus','formarcas5.vnom');}
     // Vector tipo de Escrito (Escritos de Marcas involucrados)
     $obj_query = $sql->query("SELECT evento,descripcion FROM stzevder where evento 
                             in ($escritos_validos) order by 1");
     $obj_filas = pg_numrows($obj_query); 
     $contobj = 0;
     $obj_reg = pg_fetch_array($obj_query);
     for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
          $vcodescnew[$contobj] = $obj_reg[evento]-1000;
          $vnomescnew[$contobj] = $obj_reg[descripcion];
          $obj_reg = pg_fetch_array($obj_query); }
     if ($vtipesc=='') {$vtipesc=$vcodescnew[0]; $vnomesc=$vnomescnew[0];} 
     if ($vtipesc<>'') {
        $vareve=$vtipesc+1000;
        $obj_query = $sql->query("SELECT evento,descripcion FROM stzevder where evento='$vareve'");
        $obj_reg = pg_fetch_array($obj_query);
        $vnomesc= $obj_reg[descripcion];
     } 
     // Vectores de Agentes
     $obj_query = $sql->query("SELECT agente,nombre FROM stzagenr order by nombre");
     $obj_filas = pg_numrows($obj_query); 
     $contobj = 0;
     $vcodagenew[$contobj] = '';
     $vnomagenew[$contobj] = '';
     $obj_reg = pg_fetch_array($obj_query);
     for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
          $vcodagenew[$contobj] = $obj_reg[agente];
          $vnomagenew[$contobj] = $obj_reg[nombre];
          $obj_reg = pg_fetch_array($obj_query); }    
      if ($vcodagen==0) {$vcodagen='';} 
      if ($vcodagen!='') {
      $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vcodagen");
      $regage = pg_fetch_array($resulage);
      $vnomagen=$regage[nombre];
      }
   }   
      
   if ($vopc==5) {
      // Validaciones iniciales
      $vmotivos='';
      if ($vmot1) {$vmotivos=$vmotivos.'1';}
      if ($vmot2) {$vmotivos=$vmotivos.'2';}
      if ($vmot3) {$vmotivos=$vmotivos.'3';}
      if ($vmot4) {$vmotivos=$vmotivos.'4';}
      if ($vmot5) {$vmotivos=$vmotivos.'5';}
      if ($vmot6) {$vmotivos=$vmotivos.'6';}
      if ($vfecesc=='' || $vtipesc=='' || ($vmotivos=='' && $vomot=='')) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS O VACIOS','m_escritos_mod.php?vopc='.$vopcant.'&vesc='.$vesc.'&vesc1='.$vesc1.'&vesc2='.$vesc2.'&vfecesc='.$vfecesc.'&vsol1='.$vsol1.'&vsol2='.$vsol2.'&vreg1='.$vreg1.'&vreg2='.$vreg2.'&vnom='.$vnom.'&vindcla='.$vindcla.'&vcla='.$vcla.'&vtipesc='.$vtipesc.'&vdoc='.$vdoc.'&vcom='.$vcom.'&vtra='.$vtra.'&vmot1='.$vmot1.'&vmot2='.$vmot2.'&vmot3='.$vmot3.'&vmot4='.$vmot4.'&vmot5='.$vmot5.'&vmot6='.$vmot6.'&vomot='.$vomot.'&vcodagen='.$vcodagen.'&vnomagen='.$vnomagen.'&vnomesc='.$vnomesc,'N');

	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      $vescrito=$vtipesc+1000;
      if (!in_array($vescrito,$vector_escritos)) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - El Tipo de Escrito No es V&aacute;lido...','m_escritos_ing.php?vopc='.$vopcant.'&vesc='.$vesc.'&vesc1='.$vesc1.'&vesc2='.$vesc2.'&vfecesc='.$vfecesc.'&vsol1='.$vsol1.'&vsol2='.$vsol2.'&vreg1='.$vreg1.'&vreg2='.$vreg2.'&vnom='.$vnom.'&vindcla='.$vindcla.'&vcla='.$vcla.'&vtipesc='.$vtipesc.'&vdoc='.$vdoc.'&vcom='.$vcom.'&vtra='.$vtra.'&vmot1='.$vmot1.'&vmot2='.$vmot2.'&vmot3='.$vmot3.'&vmot4='.$vmot4.'&vmot5='.$vmot5.'&vmot6='.$vmot6.'&vomot='.$vomot.'&vcodagen='.$vcodagen.'&vnomagen='.$vnomagen.'&vnomesc='.$vnomesc,'N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      if ($vcodagen==0) {$vcodagen='';} 
      if ($vcodagen!='') {
         $resulage=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vcodagen");
         $filas_found=pg_numrows($resulage); 
         if ($filas_found==0) {
            $sql->disconnect();
            $smarty->display('encabezado1.tpl');
            mensajenew('ERROR AL INTENTAR GRABAR - El C&oacute;digo del Agente No es V&aacute;lido...','m_escritos_ing.php?vopc='.$vopcant.'&vesc='.$vesc.'&vesc1='.$vesc1.'&vesc2='.$vesc2.'&vfecesc='.$vfecesc.'&vsol1='.$vsol1.'&vsol2='.$vsol2.'&vreg1='.$vreg1.'&vreg2='.$vreg2.'&vnom='.$vnom.'&vindcla='.$vindcla.'&vcla='.$vcla.'&vtipesc='.$vtipesc.'&vdoc='.$vdoc.'&vcom='.$vcom.'&vtra='.$vtra.'&vmot1='.$vmot1.'&vmot2='.$vmot2.'&vmot3='.$vmot3.'&vmot4='.$vmot4.'&vmot5='.$vmot5.'&vmot6='.$vmot6.'&vomot='.$vomot.'&vcodagen='.$vcodagen.'&vnomagen='.$vnomagen.'&vnomesc='.$vnomesc,'N');
            $smarty->display('pie_pag.tpl'); exit(); 
         }
      }
      if ($vcla=='') {$vcla=0;}
      if ($vdoc=='') {$vdoc=0;}	  
      if ($vsol=='0000-000000') {$vsol='';}	  
      if ($vcodagen=='') {$vcodagen=0;}
      $can_error=0;
      pg_exec("BEGIN WORK");           
      $update_str="nro_escrito='$vesc',fecha='$vfecesc',solicitud='$vsol',registro='$vreg',nombre='$vnom',ind_claseni='$vindcla', clase='$vcla',tipo_escrito='$vtipesc',nro_boletin='$vdoc',comentario='$vcom',codigo_agente='$vcodagen',tramitante='$vtra',tipo_mp='M', motivo='$vmotivos',otro_motivo='$vomot',usuario='$vuser',fecha_trans='$vfecha',hora='$hh',anno='$vanno'";
      $valido = $sql->update("stzescri","$update_str","nro_escrito='$vesc' and tipo_mp='M'");
      if (!$valido) {$can_error = $can_error + 1;}
       
      // Mensaje final 
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew('DATOS MODIFICADOS CORRECTAMENTE!!!','m_escritos_mod.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else {
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("Falla de Ingreso en la B.D. Transacciones Abortadas...!!!",
                      "javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit();   }

   }
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('vcodescnew',$vcodescnew);
   $smarty ->assign('vnomescnew',$vnomescnew);  
   $smarty ->assign('vcodind',array('I','N'));
   $smarty ->assign('vdesind',array('Internacional','Nacional')); 
   $smarty ->assign('vopc',$vopc); 
   $smarty ->assign('vopcant',$vopcant); 
   $smarty ->assign('vesc',$vesc); 
   $smarty ->assign('vesc1',$vesc1); 
   $smarty ->assign('vesc2',$vesc2); 
   $smarty ->assign('vsol1',$vsol1); 
   $smarty ->assign('vsol2',$vsol2); 
   $smarty ->assign('vsol',$vsol);
   $smarty ->assign('vfecesc',$vfecesc);
   $smarty ->assign('vreg1',$vreg1);
   $smarty ->assign('vreg2',$vreg2);
   $smarty ->assign('vnom',$vnom); 
   $smarty ->assign('vcom',$vcom);
   $smarty ->assign('vindcla',$vindcla);
   $smarty ->assign('vcla',$vcla);
   $smarty ->assign('vtipesc',$vtipesc);
   $smarty ->assign('vnomesc',$vnomesc);
   $smarty ->assign('vdoc',$vdoc);
   $smarty ->assign('vcodagen',$vcodagen);
   $smarty ->assign('vnomagen',$vnomagen);
   $smarty ->assign('vcodagenew',$vcodagenew);
   $smarty ->assign('vnomagenew',$vnomagenew);
   $smarty ->assign('vtra',$vtra);
   $smarty ->assign('vmot1',$vmot1);
   $smarty ->assign('vmot2',$vmot2);
   $smarty ->assign('vmot3',$vmot3);
   $smarty ->assign('vmot4',$vmot4);
   $smarty ->assign('vmot5',$vmot5);
   $smarty ->assign('vmot6',$vmot6);
   $smarty ->assign('vomot',$vomot);
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty->display('m_escritos_mod.tpl'); 
   $smarty->display('pie_pag.tpl');
?>

