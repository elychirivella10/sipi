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
$smarty ->assign('subtitulo','Verificacion de Anotaciones Marginales'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha);    

   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vbol=$_POST['vbol'];
   $vtip=$_POST['vtip'];
      
   $sql->connection($login);  
   $vtipest=array(2209,2208,2207,2206,2205);
   $vtipsol=array("Cambios de Titular","Cambios de Domicilio","Licencias de Uso","Fusiones","Cesiones"); 
   
   if ($vopc==3) {
            
      if ($vbol=='' || $vtip=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
       
      $resul=pg_exec("SELECT * FROM stzantma WHERE evento='$vtip' and tipo='P'");
      $cantreg = pg_numrows($resul);
      if ($cantreg==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      $reg = pg_fetch_array($resul); 
   }   

   //Asignacion de variables para pasarlas a Smarty
   $camposquery = "distinct on (a.solicitud,tipo,evento,a.nanota)
                   a.solicitud,c.nombre,tipo_derecho,a.nanota,a.verificado";
   $camposname= "solicitud,nombre,tipo_derecho,nanota,verificado";
   $tablas    = "stzantma a,stppatee b,stzderec c";
   $condicion = "a.nro_derecho=b.nro_derecho and a.nro_derecho=c.nro_derecho and 
                 a.tipo='P' and a.evento=v2";
   $orden     = "1";
   $modo      = "Guardar";
   $modoabr   = "Verificar";
   $vurl      = "p_bolveram.php";
   $new_windows="N";
   
   $smarty ->assign('camposquery',$camposquery);
   $smarty ->assign('camposname',$camposname);
   $smarty ->assign('tablas',$tablas);
   $smarty ->assign('condicion',$condicion);
   $smarty ->assign('orden',$orden); 
   $smarty ->assign('modo',$modo); 
   $smarty ->assign('modoabr',$modoabr); 
   $smarty ->assign('vurl',$vurl);
   $smarty ->assign('new_windows',$new_windows);
   
   $smarty ->assign('varfocus','forpatentes2.v1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest); 
   $smarty ->assign('ltipo','Tipo de Anotacion:'); 
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty ->display('p_bolveram.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
