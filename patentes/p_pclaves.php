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

$smarty ->assign('titulo','Sistema de Patentes'); 
$smarty ->assign('subtitulo','Palabras Claves');
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
   
   $vuser    =$usuario;  
   
   //Captura Variables leidas en formulario inicial
   $vopc= $_GET['vopc'];
   $vsol1=$_POST['vsol1'];
   $vsol2=$_POST['vsol2'];
   $vder=$_POST['vder'];
   $accion=$_POST['accion'];
        
   $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
   $psoli=$vsol;
   $resultado=false;
   $vfec=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','forpatentes1.vsol1'); 
   $smarty ->assign('vmodo','');
   $smarty ->assign('vmodo2',''); 
   $smarty ->assign('lpodhab',''); 
   
   $sql->connection($login);   
   
  if ($vopc==1) {
      $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$vsol' and solicitud!=''
                          and tipo_mp='P'");
      $smarty ->assign('lpodhab','Palabras claves:'); 
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','forpatentes3.vagenom'); 
      $smarty ->assign('vmodo','readonly');
      $smarty ->assign('vmodo2','readonly'); 
      
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS','p_pclaves.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vder=$reg[nro_derecho];
      $smarty ->assign('vnompat',$reg[nombre]); 

      $resulpoh=pg_exec("SELECT a.nro_derecho,a.apuntador,palabra FROM stppacld a, stptesar b 
                          WHERE a.apuntador=b.apuntador and a.nro_derecho='$vder'");
      $regpoh = pg_fetch_array($resulpoh);
      $filaspoh=pg_numrows($resulpoh);
      // se elimina cualquier ocurrencia en la tabla tmppacla
      $sql->del("tmppacla","solicitud='$vsol'");
      for($cont=0;$cont<$filaspoh;$cont++) { 
         //se inserta en tabla auxiliar de palabras claves
         $insert_campos="solicitud,apuntador,palabra";
         $insert_valores ="'$vsol','$regpoh[apuntador]','$regpoh[palabra]'";
         $sql->insert("tmppacla","$insert_campos","$insert_valores","");
	 // se inicializa vector de poderhabientes
         $vpoderhab1[$cont]=$regpoh[apuntador];
	 $vpoderhab2[$cont]=$regpoh[palabra];
	 $regpoh = pg_fetch_array($resulpoh);
      }
      $smarty->assign('arr_ph1',$vpoderhab1); 
      $smarty->assign('arr_ph2',$vpoderhab2); 
      $smarty->assign('vnumrows',$filaspoh);
   }           
   
   if ($vopc==4 || ($vopc==5 && $accion!='Guardar')) {
      $smarty ->assign('lpodhab','Palabras Claves:'); 
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','forpatentes3.vagenom'); 
      $smarty ->assign('vmodo','readonly');
      
      // Validaciones iniciales
      $vagenom=$_POST['vagenom'];
      //$vcodt=$_POST['vcodt'];
      $vsol= $_GET['vsol'];
      $v1=$_GET['v1'];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);

      $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$vsol' and solicitud!=''
                          and tipo_mp='P'");
      $reg = pg_fetch_array($resultado);
      $vder=$reg[nro_derecho];
      $smarty ->assign('vnompat',$reg[nombre]); 

      $resultado=pg_exec("SELECT * FROM stppacld WHERE nro_derecho='$vder'");
      $reg = pg_fetch_array($resultado);
            
      if ($v1==0) {
         $vcodt=$reg[apuntador];
         $resultit=pg_exec("SELECT * FROM stptesar WHERE apuntador='$vcodt'");
         $cantfil=pg_numrows($resultit);
         if ($cantfil>0) 
         { $regtit = pg_fetch_array($resultit);
           $vnomt=$regtit[palabra]; 
         }
      }
      
      if ($vopc==5 && ($accion!="Guardar" && $accion!="Incluir")) {
         $vopc=4;
         if (!empty($accion))
         { $cqcs=pg_exec("delete from tmppacla where solicitud='$vsol' and apuntador=$accion"); }
      }
      
      if ($vopc==5 && $accion=="Incluir") {
         $vopc=4;
         if ($vagenom!='') {
            $resulpal=pg_exec("SELECT * FROM stptesar WHERE palabra='$vagenom'");
            $regpal = pg_fetch_array($resulpal);      
            $filaspal=pg_numrows($resulpal);
            if ($filaspal>0) {
               $vagen=$regpal[apuntador];
            }else{
               $resulpal=pg_exec("SELECT apuntador FROM stptesar order by 1 desc");
               $regpal = pg_fetch_array($resulpal);      
               $vagen=$regpal[apuntador]+1;
               $sql->insert("stptesar","apuntador,palabra","$vagen,'$vagenom'","");
            }
            $insert_campos="solicitud,apuntador,palabra";
            $insert_valores ="'$vsol',$vagen,'$vagenom'";
            pg_exec("delete from tmppacla where solicitud='$vsol' and palabra='$vagenom'");
            $sql->insert("tmppacla","$insert_campos","$insert_valores","");
         }  
      }
      // Vectores de Palabras Claves
      $resultado=pg_exec("SELECT * FROM stppatee WHERE nro_derecho='$vder'");
      $reg1 = pg_fetch_array($resultado);      
      $obj_query = $sql->query("SELECT * FROM stptesar ORDER BY palabra");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $vcodage[$contobj] = 0;
      $vnomage[$contobj] = '';
      $objs = $sql->objects('',$obj_query);
      for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
          $vcodage[$contobj] = $objs->apuntador;
          $vnomage[$contobj] = $objs->palabra;
	  $objs = $sql->objects('',$obj_query);
      }

      $resulpoh=pg_exec("SELECT solicitud,a.apuntador,a.palabra FROM tmppacla a, stptesar b 
                          WHERE a.apuntador=b.apuntador and a.solicitud='$vsol'");
      $regpoh = pg_fetch_array($resulpoh);
      $filaspoh=pg_numrows($resulpoh);
      for($cont=0;$cont<$filaspoh;$cont++) { 
         // se inicializa vector de palabras claves
         $vpoderhab1[$cont]=$regpoh[apuntador];
	 $vpoderhab2[$cont]=$regpoh[palabra];
	 $regpoh = pg_fetch_array($resulpoh);
      }
      $smarty->assign('arr_ph1',$vpoderhab1); 
      $smarty->assign('arr_ph2',$vpoderhab2);
      $smarty->assign('vnumrows',$filaspoh);
      $smarty->assign('vcodage',$vcodage); 
      $smarty->assign('vnomage',$vnomage); 
      $smarty->assign('codage',0); 
      $smarty->assign('codtit',$vcodt); 
      $smarty ->assign('varfocus','forpatentes3.vagenom'); 
   }
     
   if ($vopc==5 && $accion=='Guardar') {
      $vsol= $_GET['vsol'];
      $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$vsol' and solicitud!=''
                          and tipo_mp='P'");
      $reg = pg_fetch_array($resultado);
      $vder=$reg[nro_derecho];

      $restitam = $sql->query("SELECT * FROM tmppacla where solicitud='$vsol'");
      $regtitam = pg_fetch_array($restitam);
      $vnomtn=$regtitam[palabra];
      $vcodtn=$regtitam[apuntador]; 

      if ($vcodtn==0) {
         $res_cod=pg_exec("SELECT * FROM stptesar order by apuntador DESC");
         $regcod = pg_fetch_array($res_cod);
         $vtit=$regcod[apuntador];
         $vtit=$vtit+1;
         $resultado=pg_exec("INSERT INTO stptesar (apuntador,palabra) VALUES
                           ('$vtit','$vnomtn')");
         $vcodtn=$vtit;
      }      

      // Elimina todos los registros existentes para luego actualizarlos
      $resultmp = $sql->query("SELECT * FROM tmppacla where solicitud='$vsol'"); 
      $regtmp = pg_fetch_array($resultmp);
      $filtmp = pg_numrows($resultmp);
      $sql->del("stppacld","nro_derecho='$vder'");
      for ($cont=0;$cont<$filtmp;$cont++) {
         $var=$regtmp[apuntador];
	 $insert_campos="nro_derecho,apuntador";
	 $insert_valores="'$vder',$var";	 
	 $sql->insert("stppacld","$insert_campos","$insert_valores","");
         $regtmp = pg_fetch_array($resultmp);
      }

      // Elimina todos los registros existentes en el temporal
      $sql->del("tmppacla","solicitud='$vsol'");
      
      // Mensaje final
      $smarty->display('encabezado1.tpl');
      mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','p_pclaves.php','S');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   
   //Asignaci� de variables para pasarlas a Smarty
   $smarty ->assign('vopc',$vopc); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty ->assign('vder',$vder); 
   $smarty ->assign('psoli',$psoli);
   $smarty ->assign('vsol',$vsol);
   $smarty ->assign('vcodt',$vcodt);
   $smarty ->assign('vnomt',$vnomt);
   $smarty ->assign('vfecp',$vfecp);
   $smarty ->assign('vfac',$vfac);
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lcpoder','Codigo:'); 
   $smarty ->assign('lnpoder','Palabra:'); 
   $smarty->display('encabezado1.tpl');
   $smarty->display('p_pclaves.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
