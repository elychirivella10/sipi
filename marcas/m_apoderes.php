<?php 
ob_start();
?> 
<script language="Javascript"> 
 function browsetitularp(var1,var2,var3,var4) {
   open("act_titularp.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana","width=2,height=2,left=511,top=300, scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

 function browsepoderhabi(var1,var2,var3,var4) {
   open("act_poderhabi.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana","width=2,height=2,left=511,top=300, scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
</script>

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
$vuser    =$usuario;  
   
//Captura Variables leidas en formulario inicial
$vopc=$_GET['vopc']; if (empty($vopc)) {$vopc=13;}
$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$vfecp=$_POST['vfecp'];
$vfac=$_POST['vfac'];
$vobs=$_POST['vobs'];
$vaccion=$_POST['vaccion'];
$vsol=sprintf("%04d-%04d",$vsol1,$vsol2);
$psoli=$vsol;
$vfec=hoy();
   
//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('titulo',$substmar); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol1'); 
$smarty ->assign('vmodo','');
$smarty ->assign('vmodo2',''); 
if ($vopc==13) {$vaccion='Actualizar';}  
if ($vaccion=='Actualizar')  {$smarty ->assign('subtitulo','Actualizacion de Poderes');}

$sql->connection($login);   
   
   if ($vopc==1) {
      $resultado=pg_exec("SELECT * FROM stzpoder WHERE poder='$vsol' and poder!=''");
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
      $sql->disconnect();
      $smarty->display('encabezado1.tpl');
      mensajenew('EL PODER que intenta actualizar NO EXISTE!!!','m_apoderes.php?vopc=13','N');
      $smarty->display('pie_pag.tpl'); exit(); 
      } else { 
      // Elimina posibles registros existentes en el temporal
      $sql->del("temptitu","solicitud='$vsol'");
      $sql->del("tmppohad","poder='$vsol'");
      // Se llenan los temporales
      $regresul = pg_fetch_array($resultado);
      $vfac=$regresul[facultad];
      $vfecp=$regresul[fecha_poder];
      $vobs=$regresul[observacion];
      for ($cont=0;$cont<$filas_found;$cont++) {
          $vtitular=$regresul[titular];
          //Ubicar el nombre del titular
          $resultit=pg_exec("SELECT nombre FROM stzsolic WHERE titular=$vtitular");
          $regtit = pg_fetch_array($resultit); 
          $vnomb=str_replace("'","`",$regtit[nombre]);
          $vnomb=str_replace("??","??",$regtit[nombre]);   
	  $insert_campos="solicitud,titular,nombre";
	  $insert_valores="'$vsol',$vtitular,'$vnomb'";	 
	  $sql->insert("temptitu","$insert_campos","$insert_valores","");
         $regresul = pg_fetch_array($resultado);
      }
      $resulpod=pg_exec("SELECT * FROM stzpohad WHERE poder='$vsol'");
      $filas_pod=pg_numrows($resulpod); 
      $regpod = pg_fetch_array($resulpod); 
      for ($cont=0;$cont<$filas_pod;$cont++) {
          $vpoha=$regpod[poderhabi];
          //Ubicar el nombre del poderhabiente (agente)
          $resulag=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vpoha");
          $regag = pg_fetch_array($resulag); 
          $vnomb=str_replace("'","`",$regag[nombre]);
          $vnomb=str_replace("??","??",$regag[nombre]);  
	  $insert_campos="poder,poderhabi,nombre";
	  $insert_valores="'$vsol',$vpoha,'$vnomb'";	 
	  $sql->insert("tmppohad","$insert_campos","$insert_valores","");
          $regpod = pg_fetch_array($resulpod);
      }
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.vfecp'); 
      $smarty ->assign('vmodo2','');
      $smarty ->assign('vmodo','');
      }
   }

   // cuando se va a guardar el poder   
   if ($vopc==5) {
      $resultmt=pg_exec("SELECT * FROM temptitu WHERE solicitud='$vsol'");
      $regtmt = pg_fetch_array($resultmt);
      $filtmt = pg_numrows($resultmt);
      $resultmp=pg_exec("SELECT * FROM tmppohad WHERE poder='$vsol'");
      $regtmp = pg_fetch_array($resultmp);
      $filtmp = pg_numrows($resultmp);
      // Validacion de campos obligatorios
      if ($vfecp=='' || $vfac=='' || $filtmt==0 || $filtmp==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR al intentar Grabar!!! Los Datos estan incompletos o vacios','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); 
      }

      pg_exec("BEGIN WORK"); 
      $valins=0;
      // Se eliminan los registro originales
      $sql->del("stzpoder","poder='$vsol'");
      $sql->del("stzpohad","poder='$vsol'");
      // Se guarda en la maestra de Poderes
      for ($cont=0;$cont<$filtmt;$cont++) {
          $vtitular=$regtmt[titular];
          $vnac=$regtmt[nacionalidad];
          $vdom=trim($regtmt[domicilio]);
          $vide=$regtmt[identificacion];
          $vnom=$regtmt[nombre];
          $vind=$regtmt[indole];
          $vte1=$regtmt[telefono1];
          $vte2=$regtmt[telefono2];
          $vfax=$regtmt[fax];
          $vema=$regtmt[email];
          if ($vtitular==0) // El titular es nuevo
          {  $insert_campos="identificacion,nombre,indole,telefono1,telefono2,fax,email";
             $insert_valores ="'$vide','$vnom','$vind','$vte1','$vte2','$vfax','$vema'";
             $valido=$sql->insert("stzsolic","$insert_campos","$insert_valores","");
             if (!$valido) {$valins = $valins + 1;}
             $rescodt=pg_exec("select last_value from stzsolic_titular_seq");
             $regcodt=pg_fetch_array($rescodt);
             $vtitular=$regcodt[last_value];   
          }
	  $insert_campos="poder,titular,fecha_poder,facultad,fecha_trans,observacion";
	  $insert_valores="'$vsol',$vtitular,'$vfecp','$vfac','$vfec','$vobs'";	 
	  $resins = $sql->insert("stzpoder","$insert_campos","$insert_valores","");
          if (!$resins) {$valins = $valins + 1;}
          $regtmt = pg_fetch_array($resultmt);
      }
      // Se guarda en la maestra de Podehabientes
      $sql->del("stzpohad","poder='$vsol'");
      for ($cont=0;$cont<$filtmp;$cont++) {
          $vpoderhabi=$regtmp[poderhabi];
	  $insert_campos="poder,poderhabi";
	  $insert_valores="'$vsol',$vpoderhabi";	 
	  $resins = $sql->insert("stzpohad","$insert_campos","$insert_valores","");
          if (!$resins) {$valins = $valins + 1;}
          $regtmp = pg_fetch_array($resultmp);
      }
      // Elimina todos los registros existentes en los temporales
      $sql->del("temptitu","solicitud='$vsol'");
      $sql->del("tmppohad","poder='$vsol'");
      
      // Mensaje final
      if ($valins==0) { 
        pg_exec("COMMIT WORK"); $sql->disconnect(); 
        $smarty->display('encabezado1.tpl');
        mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_apoderes.php?vopc=13','S');
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
   
//Asignacion de variables para pasarlas a Smarty
$smarty ->assign('vopc',$vopc); 
$smarty ->assign('vaccion',$vaccion);
$smarty ->assign('vsol',$vsol); 
$smarty ->assign('vsol1',$vsol1); 
$smarty ->assign('vsol2',$vsol2); 
$smarty ->assign('vfecp',$vfecp);
$smarty ->assign('vfac',$vfac);
$smarty ->assign('vobs',$vobs);
$smarty ->assign('lsolicitud','Codigo del Poder:'); 
$smarty ->assign('lcodigo','Codigo del Titular:'); 
$smarty ->assign('lnombre','Nombre:'); 
$smarty ->assign('lcpoder','Codigo:'); 
$smarty ->assign('lnpoder','Nombre:'); 
$smarty ->assign('lfechapoder','Fecha del Poder:'); 
$smarty ->assign('lfacultad','Facultad:'); 
$smarty ->assign('lfacultad2','(M)arcas (P)atentes (A)mbas'); 
$smarty ->assign('ltitular','Titular(es):');
$smarty ->assign('lpoderhabi','Poderhabiente(s):');
$smarty->display('encabezado1.tpl');
$smarty->display('m_apoderes.tpl'); 
$smarty->display('pie_pag.tpl');
?>
