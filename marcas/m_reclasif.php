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
$smarty ->assign('subtitulo','Reclasificaci&oacute;n de Solicitudes'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha);
   
   $vuser    =$usuario;  
   
   //Captura Variables leidas en formulario inicial
   $vopc=   $_GET['vopc'];
   $nderec= $_POST['nderec'];
   $vsol1=  $_POST['vsol1'];
   $vsol2=  $_POST['vsol2'];
   $vreg1=  $_POST['vreg1'];
   $vreg2=  $_POST['vreg2'];
   $vnom=   $_POST['vnom'];
   $vcla=   $_POST['vcla'];
   $vindcla=$_POST['vindcla'];
   $vest=   $_POST['vest'];
   $vclas1= $_POST['clas1'];
   $vclas2= $_POST['clas2'];
   $vclas3= $_POST['clas3'];
   $vclas4= $_POST['clas4'];
   $vclas5= $_POST['clas5'];
   $vclas6= $_POST['clas6'];
   $vreg2=  $_POST['regis2'];
   $vreg3=  $_POST['regis3'];
   $vreg4=  $_POST['regis4'];
   $vreg5=  $_POST['regis5'];
   $vreg6=  $_POST['regis6'];
   $vhij1=  $_POST['hija1'];
   $vhij2=  $_POST['hija2'];
   $vhij3=  $_POST['hija3'];
   $vhij4=  $_POST['hija4'];
   $vhij5=  $_POST['hija5'];
   
   $vsolh=  $_POST['vsolh'];
   $vregh=  $_POST['vregh'];
        
   $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vreg=   $vreg1.$vreg2;
   $resultado=false;
   $vfec=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('vmodo',''); 
   
   $sql->connection($login);   
   if ($vopc==1) {
      $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho and tipo_mp='M' and 
                             b.solicitud='$vsol'");}
   if ($vopc==2) {
      $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho and tipo_mp='M' and
                        b.registro= '$vreg'");}

   if ($vopc==1 || $vopc==2) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.clas1'); 
      $smarty ->assign('vmodo','readonly'); 
      
      if (!$resultado) { 
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL PROCESAR LA BUSQUEDA','m_reclasif.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS','m_reclasif.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vsol=$reg[solicitud];
      $nderec=$reg[nro_derecho];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vhija1=$vsol1.'-1'.substr($vsol,-5,5);
      $vhija2=$vsol1.'-2'.substr($vsol,-5,5);
      $vhija3=$vsol1.'-3'.substr($vsol,-5,5);
      $vhija4=$vsol1.'-4'.substr($vsol,-5,5);
      $vhija5=$vsol1.'-5'.substr($vsol,-5,5);
      $vreg=$reg[registro];
      $vest=$reg[estatus];
      $vreg1=substr($vreg,-8,1);
      $vreg2=substr($vreg,1);
      $vnom=$reg[nombre];
      $vcla=$reg[clase];
      $vindcla=$reg[ind_claseni];
      $vest=$reg[estatus];
      $vfecsol=$reg[fecha_solic];
      $vmod=$reg[modalidad];
      $nameimage=ver_imagen($vsol1,$vsol2,'M');       

            
      if ($vest==1555 && ($vindcla=="N" || ($vindcla=="I" && $vcla==42))) { //Esta bien 
      }  ELSE {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('Solo puede reclasificar MARCAS REGISTRADAS que tengan CLASE NACIONAL o CLASE INTERNACIONAL 42','m_reclasif.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
   }   
      
   if ($vopc==3) {
      // Validaciones iniciales
      if ($vsolh=='-' || $vregh=='' || $vclas1=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
	 }
      //$vfecsol=convertir_en_fecha($vfecsol,1);
      $esmayor=compara_fechas($vfecsol,$vfec);
      if ($esmayor==1) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('No se puede cargar un evento previo a la Fecha de la Solicitud','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
         }
      if (($vclas1==$vclas2 || $vclas1==$vclas3 || $vclas1==$vclas4 || $vclas1==$vclas5 || $vclas1==$vclas6) ||
      ($vclas2!='' && ($vclas2==$vclas3 || $vclas2==$vclas4 || $vclas2==$vclas5 || $vclas2==$vclas6)) ||
      ($vclas3!='' && ($vclas3==$vclas4 || $vclas3==$vclas5 || $vclas3==$vclas6)) ||
      ($vclas4!='' && ($vclas4==$vclas5 || $vclas4==$vclas6)) ||
      ($vclas5!='' && ($vclas5==$vclas6))) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - Existen Clases Duplicadas','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      
      $vcomen797='SOLICITUD MADRE: '.$vsolh.' CLASE '.$vindcla.' '.$vcla.' REGISTRO '.$vregh;
            
      // busqueda de la descripción del evento 
      $resuldese=pg_exec("SELECT mensa_automatico FROM stzevder WHERE evento=1796");
      $regdese = pg_fetch_array($resuldese);
      $vdese = $regdese[mensa_automatico];
           
      // Captura de todos los valores de Stmmarce para duplicarlos
      $resulsol=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,agente
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho and tipo_mp='M' and
                        b.solicitud= '$vsolh'");
      $regsol = pg_fetch_array($resulsol);
      $vfecha_solic=$regsol[fecha_solic];
      $vnombre     =$regsol[nombre];
      $vpoder      =$regsol[poder];
      $vfecha_regis=$regsol[fecha_regis];
      $vfecha_publi=$regsol[fecha_public];
      $vfecha_venc =$regsol[fecha_venc];
      $vmodalidad  =$regsol[modalidad];
      $vtramitante =$regsol[tramitante]; 
      $vpais_resid =$regsol[pais_resid];
      $vest        =$regsol[estatus];
      $vindcla     =$regsol[ind_claseni];
      $vcla        =$regsol[clase]; 
      $vdistingue  =$regsol[distingue];
      $vagen       =$regsol[agente];
      $vtipo_marca =$regsol[tipo_marca];
      $vregistro   =$regsol[registro];
      $vmod=$reg[modalidad];
      $nameimage=ver_imagen($vsol1,$vsol2,'M');       
      if ($vest==1555 && ($vindcla=="N" || ($vindcla=="I" && $vcla==42))) { 
         // Actualización de la Solicitud Madre
         $vtipo_marca=tipo_de_marca($vclas1);
         if ($vtipo_marca=="P") {$vtipmar="M";} else {$vtipmar=$vtipo_marca;} 
      $error_bd=0;
      pg_exec("BEGIN WORK");
         // Stzderec
         $update_str = "tipo_derecho='$vtipmar'";
         $vtransac= $sql->update("stzderec","$update_str","nro_derecho='$nderec'");
         if (!$vtransac) {$error_bd = $error_bd + 1;}
         // Stmmarce
         $update_str = "ind_claseni='I',clase='$vclas1'";
         $vtransac= $sql->update("stmmarce","$update_str","nro_derecho='$nderec'");  
         if (!$vtransac) {$error_bd = $error_bd + 1;}
      }  ELSE {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR GRABAR - La Solicitud ha sido modificada por otro Usuario','m_reclasif.php','N');
	 $smarty->display('pie_pag.tpl'); exit(); 
      }
      
      // Captura de todos los valores de Stzottid para duplicarlos
      $resulott=pg_exec("SELECT * FROM stzottid WHERE nro_derecho='$nderec'");
      $regott = pg_fetch_array($resulott);
      $filasott=pg_numrows($resulott);
      for($cont=0;$cont<$filasott;$cont++) { 
         $vtitular[$cont]=$regott[titular];
	 $vnacionalidad[$cont]=$regott[nacionalidad];
	 $vdomicilio[$cont]=$regott[domicilio];
	 $regott = pg_fetch_array($resulott);}
      // Captura de todos los valores de Stzautod para duplicarlos
      $resulaut=pg_exec("SELECT * FROM stzautod WHERE nro_derecho='$nderec'");
      $regaut = pg_fetch_array($resulaut);
      $filasaut=pg_numrows($resulaut);
      for($cont=0;$cont<$filasaut;$cont++) { 
         $vagente[$cont]=$regaut[agente];
	 $regaut = pg_fetch_array($resulaut);}
      // Captura de todos los valores de Stzpriod para duplicarlos
      $resulpri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
      $regpri = pg_fetch_array($resulpri);
      $filaspri=pg_numrows($resulpri);
      $vprioridad=   $regpri[prioridad];
      $vpais_priori= $regpri[pais_priori];
      $vfecha_priori=$regpri[fecha_priori];
      // Captura de todos los valores de Stmlemad para duplicarlos
      $resullem=pg_exec("SELECT * FROM stmlemad WHERE nro_derecho='$nderec'");
      $reglem = pg_fetch_array($resullem);
      $filaslem=pg_numrows($resullem);
      for($cont=0;$cont<$filaslem;$cont++) { 
         $vsolicitud_aso[$cont]=$reglem[solicitud_aso];
         $vregistro_aso[$cont] =$reglem[registro_aso];
	 $reglem = pg_fetch_array($resullem);
         }	 
      	 
      // Creacion de Solicitudes Hijas (Stmmarce/Stzderec) con su respectivo evento en Stzevtrd
      for($cont=2;$cont<7;$cont++) { 
         $vnum=$cont-1;
	 if ($vnum==1) {$vsolhija=$vhij1;$vtipo_marca=tipo_de_marca($vclas2);$vclasnew=$vclas2;}
	 if ($vnum==2) {$vsolhija=$vhij2;$vtipo_marca=tipo_de_marca($vclas3);$vclasnew=$vclas3;}
	 if ($vnum==3) {$vsolhija=$vhij3;$vtipo_marca=tipo_de_marca($vclas4);$vclasnew=$vclas4;}
	 if ($vnum==4) {$vsolhija=$vhij4;$vtipo_marca=tipo_de_marca($vclas5);$vclasnew=$vclas5;}
	 if ($vnum==5) {$vsolhija=$vhij5;$vtipo_marca=tipo_de_marca($vclas6);$vclasnew=$vclas6;}
	 
	 if ($vtipo_marca=="P") {$vtipmar="M";} else {$vtipmar=$vtipo_marca;} 
	 
     if ($vclasnew!='') {
     
      //if ($vsolh!='1992-008020') {         	
            // Captura e incremento de secuencial stzsystem para registros

   switch ($vtipo_marca) {
         case "M":
           $tnumera='nproducto';
           $letrareg = "P";
           break;
         case "N":
           $tnumera='nnombres';
           $letrareg = "N";         
          break;
        case "L":
           $tnumera='nlemas';
           $letrareg = "L";
           break;
        case "S":
           $tnumera='nservicios';
           $letrareg = "S";
           break;
        case "C":
           $tnumera='ncolectivas';
           $letrareg = "C";
           break;
        case "D":
           $tnumera='ndorigen';
           $letrareg = "D";
           break;
       }

       $sys_actual = next_sys("$tnumera");
       $vnumreg = grabar_sys("$tnumera",$sys_actual);
       $vproxreg  = $letrareg.sprintf("%06d",$vnumreg);

//	    if ($vtipo_marca=="P" or $vtipo_marca=='M') { 
//               $vtransac= $sql->update("stzsystem",
//                                       "nproducto=nextval('stzsystem_nproducto_seq')","");
//               if (!$vtransac) {$error_bd = $error_bd + 1;} 
//               $resystem=pg_exec("SELECT * FROM stzsystem");
//               $regystem=pg_fetch_array($resystem);
//               $vproducto=$regystem[nproducto];
//               $proxreg = $vtipo_marca.sprintf("%06d",$vproducto);}
//	    if ($vtipo_marca=="S") { 
//               $vtransac= $sql->update("stzsystem",
//                                       "nservicios=nextval('stzsystem_nservicios_seq')","");
//               if (!$vtransac) {$error_bd = $error_bd + 1;}
//               $resystem=pg_exec("SELECT * FROM stzsystem");
//               $regystem=pg_fetch_array($resystem);
//               $vservicios=$regystem[nservicios];
//               $proxreg = $vtipo_marca.sprintf("%06d",$vservicios);}
//	    if ($vtipo_marca=="N") { 
//               $vtransac= $sql->update("stzsystem",
//                                       "nnombres=nextval('stzsystem_nnombres_seq')","");
//               if (!$vtransac) {$error_bd = $error_bd + 1;}
//               $resystem=pg_exec("SELECT * FROM stzsystem");
//               $regystem=pg_fetch_array($resystem);
//               $vnombres=$regystem[nnombres];
//               $proxreg = $vtipo_marca.sprintf("%06d",$vnombres);}
//	    if ($vtipo_marca=="L") { 
//               $vtransac= $sql->update("stzsystem","nlemas=nextval('stzsystem_nlemas_seq')","");
//               if (!$vtransac) {$error_bd = $error_bd + 1;}
//               $resystem=pg_exec("SELECT * FROM stzsystem");
//               $regystem=pg_fetch_array($resystem);
//               $vlemas=$regystem[nlemas];
//               $proxreg = $vtipo_marca.sprintf("%06d",$lemas);}
    //}           
    //else { $proxreg='S000637'; }
	 if ($vnum==1) {$vreg2=$proxreg;}
	 if ($vnum==2) {$vreg3=$proxreg;}
	 if ($vnum==3) {$vreg4=$proxreg;}
	 if ($vnum==4) {$vreg5=$proxreg;}
	 if ($vnum==5) {$vreg6=$proxreg;}
	 
	 // Inserta en Stzderec
	 $insert_campos="nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus,
                         registro,fecha_regis,fecha_publi,fecha_venc,pais_resid,
                         poder,tramitante,agente";
         $vtransac= $sql->update("stzsystem",
                                 "nro_derecho=nextval('stzsystem_nro_derecho_seq')","");
         if (!$vtransac) {$error_bd = $error_bd + 1;} 
         $resystem=pg_exec("SELECT * FROM stzsystem");
         $regystem=pg_fetch_array($resystem);
         $newderecho=$regystem[nro_derecho];
         $insert_valores="$newderecho,'$vtipmar','$vsolhija','$vfecha_solic','M','$vnombre',1555,
                          '$proxreg','$vfecha_regis','$vfecha_regis','$vfecha_venc','$vpais_resid',
                          '$vpoder','$vtramitante',$vagen";
	 $resdup=pg_exec("SELECT * FROM stzderec WHERE solicitud='$vsolhija' and tipo_mp='M'");
         $filasdup=pg_numrows($resdup);
	 if ($filasdup>0) {
            $sql->disconnect();
            $smarty->display('encabezado1.tpl');
            mensajenew("Error al Reclasificar. Ya existe la Solicitud hija: '$vsolhija'",
                        'm_reclasif.php','N');
            pg_exec("ROLLBACK WORK");
	    $smarty->display('pie_pag.tpl'); exit(); }
	 $vtransac= $sql->insert("stzderec","$insert_campos","$insert_valores","");
	 if (!$vtransac) {$error_bd = $error_bd + 1;}	 

         // Inserta en Stmmarce
	 $insert_campos="nro_derecho,clase,ind_claseni,modalidad,distingue";
         $insert_valores="$newderecho,'$vclasnew','I','$vmodalidad','$vdistingue'";
	 $vtransac= $sql->insert("stmmarce","$insert_campos","$insert_valores","");
	 if (!$vtransac) {$error_bd = $error_bd + 1;}
	
         // Inserta en Stzevtrd   
         $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,
                         documento,fecha_trans,usuario,desc_evento,comentario,hora";
         $insert_valores ="$newderecho,1797,'$vfec',nextval('stzevtrd_secuencial_seq'),
                           1555,0,'$vfec','$vuser','INGRESO DE SOLICITUD POR RECLASIFICACION',
                           '$vcomen797','$hh'";
         $vtransac= $sql->insert("stzevtrd","$insert_campos","$insert_valores","");
	 if (!$vtransac) {$error_bd = $error_bd + 1;}
	 
        // Inserta Stzottid
	if ($filasott>0) {
        for($inc=0;$inc<$filasott;$inc++) { 
             $insert_campos  ="nro_derecho,titular,nacionalidad,domicilio";
	     $insert_valores ="$newderecho,'$vtitular[$inc]','$vnacionalidad[$inc]',
                               '$vdomicilio[$inc]'";
             $vtransac= $sql->insert("stzottid","$insert_campos","$insert_valores",""); 
        }}
        $smarty->assign('vmod',$vmod);
        $smarty->assign('nameimage',$nameimage);

        // Inserta Stzautod 
	if ($filasaut>0) {
        for($inc=0;$inc<$filasaut;$inc++) { 
	    $insert_campos  ="nro_derecho,agente";
	    $insert_valores ="$newderecho,'$vagente[$inc]'";
            $vtransac= $sql->insert("stzautod","$insert_campos","$insert_valores","");
            if (!$vtransac) {$error_bd = $error_bd + 1;}
        }}

        // Inserta Stzpriod
	if ($filaspri>0) {
	$insert_campos  ="nro_derecho,prioridad,pais_priori,fecha_priori";
	$insert_valores ="$newderecho,'$vprioridad','$vpais_priori','$vfecha_priori'";
        $vtransac= $sql->insert("stzpriod","$insert_campos","$insert_valores","");}
	if (!$vtransac) {$error_bd = $error_bd + 1;}

 	// Inserta Stmlemad
	if ($filaslem>0) {
	for($inc=0;$inc<$filaslem;$inc++) { 
	   $insert_campos  ="nro_derecho,solicitud_aso,registro_aso";
	   $insert_valores ="$newderecho,'$vsolicitud_aso[$inc]','$vregistro_aso[$inc]'";
           $vtransac= $sql->insert("stmlemad","$insert_campos","$insert_valores","");
           if (!$vtransac) {$error_bd = $error_bd + 1;}
        }}
       }
      }	             
      
      // Inicialización de variables adicionales 
      $vindcla=substr($vindcla,0,3).'.';
      $vnewclas =$vclas2.' '.$vclas3.' '.$vclas4.' '.$vclas5.' '.$vclas6;
      $vnewreg  =$vreg2.' '.$vreg3.' '.$vreg4.' '.$vreg5.' '.$vreg6;
      $vnewsol  =$vhij1.' '.$vhij2.' '.$vhij3.' '.$vhij4.' '.$vhij5;
      $vcomen796='RECLASIF. DE LA CLASE '.$vindcla.' '.$vcla.' SOLICITUD(ES) HIJA(S): '.$vnewsol.' CLASE(S) INT.'.$vnewclas.' REGISTRO(S): '.$vnewreg.' RESPECTIVAMENTE';
      
      // Creación del Evento 796 en Stmevtrd para la Solicitud Madre
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,
                      fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_valores ="$nderec,1796,'$vfec',nextval('stzevtrd_secuencial_seq'),
                        1555,0,'$vfec','$vuser','MARCA RECLASIFICADA','$vcomen796','$hh'";
      $vtransac= $sql->insert("stzevtrd","$insert_campos","$insert_valores","");
      if (!$vtransac) {$error_bd = $error_bd + 1;}
    
      // Mensaje final
      if ($error_bd==0) { 
        pg_exec("COMMIT WORK"); $sql->disconnect();  
        $smarty->display('encabezado1.tpl');
        mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_reclasif.php','S');
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
   
   //Asignación de variables para pasarlas a Smarty
   $smarty ->assign('nderec',$nderec); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('vsol',$vsol);
   $smarty ->assign('registro1',$vreg1);
   $smarty ->assign('registro2',$vreg2);
   $smarty ->assign('nombre',$vnom); 
   $smarty ->assign('vfecsol',$vfecsol); 
   $smarty ->assign('clase',$vcla); 
   $smarty ->assign('hija1',$vhija1); 
   $smarty ->assign('hija2',$vhija2); 
   $smarty ->assign('hija3',$vhija3); 
   $smarty ->assign('hija4',$vhija4); 
   $smarty ->assign('hija5',$vhija5); 
   $smarty->assign('vmod',$vmod);
   $smarty->assign('nameimage',$nameimage);
   if ($vindcla=="I") {$smarty ->assign('ind_claseni','INTERNACIONAL');$vicl='INT.';}; 
   if ($vindcla=="N") {$smarty ->assign('ind_claseni','NACIONAL');     $vicl='NAC.';}; 
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lregistro','Registro:'); 
   $smarty ->assign('lfechasolic','Fecha de Solicitud:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lclase','Clase:'); 
   $smarty ->assign('lreclas','Reclasificar a las Clases:'); 
   $smarty ->assign('lregis1','Registro:'); 
   $smarty ->assign('lmadre','Madre:');
   $smarty ->assign('lhija','Hijas:'); 
   $smarty ->assign('espacios','            '); 
   $smarty->display('encabezado1.tpl');
   $smarty->display('m_reclasif.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
