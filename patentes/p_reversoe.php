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
$smarty ->assign('subtitulo','Reverso de Eventos'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
  
   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vsol1=$_POST['vsoli1'];
   $vsol2=$_POST['vsoli2'];
   $vsol3=$_POST['vsoli3'];
   $vsol4=$_POST['vsoli4'];
   $vbol=$_POST['vbol'];
   $vcodest=$_POST['vcodest'];
   $vcodeve=$_POST['vcodeve'];
   $vfeceve=$_POST['vfeceve'];
   $vsola=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vsolb=sprintf("%04d-%06d",$vsol3,$vsol4);
   $resultado=false;
   
   $sql->connection($login);   
   
   $obj_query = $sql->query("SELECT * FROM stzstder where tipo_mp='P' order by estatus");
   $filas_found=$sql->nums('',$obj_query);
   $cont = 0;
   $arraycodest[$cont]=0;
   $arraynomest[$cont]='';
   $objs = $sql->objects('',$obj_query);
   for($cont=1;$cont<=$filas_found;$cont++) 
   { 
     $arraycodest[$cont]=$objs->estatus-2000;
     $arraynomest[$cont]=trim($objs->descripcion);
     $objs = $sql->objects('',$obj_query);
   }
  
   $obj_query = $sql->query("SELECT * FROM stzevder where tipo_mp='P' order by evento");
   $filas_found=$sql->nums('',$obj_query);
   $cont = 0;
   $arraycodeve[$cont]=0;
   $arraynomeve[$cont]='';
   $objs = $sql->objects('',$obj_query);
   for($cont=1;$cont<=$filas_found;$cont++) 
   { 
     $arraycodeve[$cont]=$objs->evento-2000;
     $arraynomeve[$cont]=trim($objs->descripcion);
     $objs = $sql->objects('',$obj_query);
   }
    
   if ($vopc==3) {
      if (empty($vcodest)||empty($vcodeve)||empty($vfeceve)||$vsola=='00-000000'||$vsolb=='00-000000') {
          $sql->disconnect();
          $smarty->display('encabezado1.tpl');
          mensajenew("Imposible Reversar - Existen campos vacios",'javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit();   }
      
      $vcodeve=$vcodeve+2000;
      $vcodest=$vcodest+2000; 
      $resul = $sql->query("SELECT a.nro_derecho FROM stzevtrd a, stzderec b 
                             where a.nro_derecho=b.nro_derecho and evento=$vcodeve 
                                   and fecha_event='$vfeceve' and estat_ant=$vcodest 
                                   and documento=$vbol and b.solicitud between '$vsola' 
                                   and '$vsolb' and b.tipo_mp='P'");
      $filasr = pg_numrows($resul);
      $reg = pg_fetch_array($resul);
      pg_exec("BEGIN WORK");
      $error_t=0;
      for ($cont=0;$cont<$filasr;$cont++) {
         $vder=$reg[nro_derecho];
	 //se elimina el evento de tramite
         $vtrans=$sql->del("stzevtrd","nro_derecho=$vder and evento=$vcodeve 
                    and fecha_event='$vfeceve' and estat_ant=$vcodest and documento=$vbol");
         if (!$vtrans) {$error_t=$error_t+1;}
	 //se actualiza maestra de derechos
	 $update_str="estatus=$vcodest,fecha_venc=null,fecha_publi=null";
         $vtrans=$sql->update("stzderec","$update_str","nro_derecho='$vder'");    
         if (!$vtrans) {$error_t=$error_t+1;}
	 $reg = pg_fetch_array($resul);
      }
      
      // Mensaje final
      if ($error_t==0) {
         pg_exec("COMMIT WORK");
         if (empty($filasr) || $filasr=='' || $filasr==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew("No se Reverso ninguna solicitud".$vcodeve.$vcodest,'javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
         else {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew("Se Reversaron $filasr Solicitudes Correctamente",'p_reversoe.php','S');
         $smarty->display('pie_pag.tpl'); exit(); }
      } else {
         pg_exec("ROLLBACK WORK"); $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!",
                   "javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit();  
      }
      
   }   
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('varfocus','formarcas1.vsol1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('arraycodest',$arraycodest);
   $smarty ->assign('arraynombre',$arraynombre);
   $smarty ->assign('arraycodest',$arraycodest);
   $smarty ->assign('arraynomest',$arraynomest);
   $smarty ->assign('arraycodeve',$arraycodeve);
   $smarty ->assign('arraynomeve',$arraynomeve);
   $smarty ->assign('lsolicitud','Rango de Solicitudes:'); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('levento','Evento:'); 
   $smarty ->assign('lestatus','Estatus anterior:'); 
   $smarty ->assign('lfechaevento','Fecha del Evento:'); 
   $smarty ->assign('espacios',''); 
   $smarty ->display('encabezado1.tpl');
   $smarty ->display('p_reversoe.tpl'); 
   $smarty ->display('pie_pag.tpl');
?>
