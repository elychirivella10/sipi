<? 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql = new mod_db();
$fecha = fechahoy();

$smarty ->assign('titulo','Sistema de Patentes'); 
$smarty ->assign('subtitulo','Edicion de Datos para el Boletin'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha);

   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vbol=$_POST['vbol'];
   $vtip=$_POST['vtip'];
   $tipobol=$_POST['aplica'];
      
   $sql->connection($login);   
   $vtipest=array(2002,2023,2024,2030,2006,2101,2102,2103,2200,2119,2025,2910,2750,2090,2209,2208,2207,2206,2205,2009,2556,2917,2918,2800,2801,2802,2804,2805,2806,2809,2821,2833,2835,2836,2837,2838,2840,2921,2922);
   $vtipsol=array("Orden de Publicacion","Publicacion Prensa Extemporanea","Publicacion Prensa Defectuosa","Perimidas por NO Publicacion Prensa",
   "Solicitadas","Concedidas","Negadas","Devueltas por Fondo","Devueltas por Forma","Denegadas","Prioridad Extinguida","Desistidas","Anuladas",
   "Abandonadas","Cambios de Titular","Cambios de Domicilio","Licencias de Uso","Fusiones","Cesiones","Oposiciones","Rehabilitacion",
   "Sin Efecto por Falta de Pago","Sin Efecto por Vencimiento","Ratificacion Estatus 800","Ratificacion Estatus 801","Ratificacion Estatus 802","Ratificacion Estatus 804","Ratificacion Estatus 805","Ratificacion Estatus 806",
   "Ratificacion Estatus 809","Ratificacion Estatus 821","Ratificacion Estatus 833","Ratificacion Estatus 835","Ratificacion Estatus 836","Ratificacion Estatus 837","Ratificacion Estatus 838","Ratificacion Estatus 840","Ratificacion Estatus 921","Ratificacion Estatus 922");

   if ($vopc==3) {
      if ($tipobol=='N') {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: DEBE SELECCIONAR EL TIPO DE BOLETIN ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
            
      if ($vbol=='' || $vtip=='') {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
       
      $resul=pg_exec("SELECT * FROM stztmpbo WHERE estatus='$vtip' and tipo='P' AND tipo_boletin='$tipobol'");
      $cantreg = pg_numrows($resul);
      if ($cantreg==0) {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $reg = pg_fetch_array($resul); 
   }   
   //Asignacion de variables para pasarlas a Smarty
   $camposquery = "a.solicitud,c.nombre,c.tipo_derecho";
   $camposname= "solicitud,nombre,tipo_derecho";
   $tablas    = "stztmpbo a,stppatee b,stzderec c";
   $condicion = "a.nro_derecho=b.nro_derecho AND a.nro_derecho=c.nro_derecho and
                 a.boletin=v1 AND a.estatus=v2 AND a.tipo='P' AND a.tipo_boletin=v5";
   $orden     = "1";
   //$modo      = "Incluir";
   //$modoabr   = "Inc";
   $modo      = "Eliminar";
   $modoabr   = "Elim";
   $vurl      = "p_bolediar.php";
   $tabladel  = "stztmpbo";
   $condicion2= "solicitud=v6 and boletin=v1 and estatus=v2 and tipo='P' and tipo_boletin=v5";
   $tablains  = "stztmpbo";
   $camposins = "solicitud,boletin,estatus,tipo";
   $valoresins= "v6,v1,v2,v7,v5";
   $new_windows="N";
   
   $smarty ->assign('camposquery',$camposquery);
   $smarty ->assign('camposname',$camposname);
   $smarty ->assign('tablas',$tablas);
   $smarty ->assign('condicion',$condicion);
   $smarty ->assign('orden',$orden); 
   $smarty ->assign('modo',$modo); 
   $smarty ->assign('modoabr',$modoabr); 
   $smarty ->assign('vurl',$vurl);
   $smarty ->assign('tabladel',$tabladel);
   $smarty ->assign('condicion2',$condicion2);
   $smarty ->assign('tablains',$tablains);
   $smarty ->assign('camposins',$camposins);
   $smarty ->assign('valoresins',$valoresins);
   $smarty ->assign('new_windows',$new_windows);
   
   $smarty ->assign('varfocus','forpatentes2.v1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('espacios',''); 
   $smarty->assign('apli_inf',array('N','O','E'));
   $smarty->assign('apli_def',array('--- Seleccione Tipo Boletin ---','Ordinario','Extraordinario'));

   $smarty->display('encabezado1.tpl');
   $smarty ->display('p_bolediar.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
