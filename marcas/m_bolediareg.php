<?
//Modificado por Ing. Romulo Mendoza 07/06/2010
//Separacion de Marcas y Registro de Propiedad Industrial
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql = new mod_db();
$fecha = fechahoy();

$modulo = 'm_bolediareg.php';
$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces+1;
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'M'); }

$smarty ->assign('titulo',$substmar);  
$smarty ->assign('subtitulo','Edici&oacute;n de Datos de Registro para el Bolet&iacute;n'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha);

   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vbol=$_POST['vbol'];
   $vtip=$_POST['vtip'];
   $tipobol=$_POST['aplica'];
      
   $sql->connection($login);   
   //$vtipest=array(1101,1390,1025,1750,1102,1209,1208,1207,1206,1205,1204,1913,1800,1801,1802,1803,1804,1805,1806,1807,1808,1809,1821,1822,1823,1824,1825,1830,1831,1833,1835,1836,1837,1838);
   //$vtipsol=array("Concedidas","Concedidas Reclasificadas","Prioridad Extinguida","Caducas","Negadas","Cambio de Titular","Cambios de Domicilio",
   //               "Licencias de Uso","Fusiones","Cesiones","Renovaciones","Registros No Renovados","Ratificacion Estatus 800","Ratificacion Estatus 801","Ratificacion Estatus 802",
   //               "Ratificacion Estatus 803","Ratificacion Estatus 804","Ratificacion Estatus 805","Ratificacion Estatus 806","Ratificacion Estatus 807","Ratificacion Estatus 808","Ratificacion Estatus 809","Ratificacion Estatus 821","Ratificacion Estatus 822","Ratificacion Estatus 823",
   //               "Ratificacion Estatus 824","Ratificacion Estatus 825","Ratificacion Estatus 830","Ratificacion Estatus 831","Ratificacion Estatus 833","Ratificacion Estatus 835","Ratificacion Estatus 836","Ratificacion Estatus 837","Ratificacion Estatus 838");

   $vtipest=array(1101,1025,1750,1102,1209,1208,1207,1206,1205,1204,1913);
   $vtipsol=array("Concedidas","Prioridad Extinguida","Caducas","Negadas","Cambio de Titular","Cambios de Domicilio",
                  "Licencias de Uso","Fusiones","Cesiones","Renovaciones","Registros No Renovados");


   if ($vopc==3) {
      if ($tipobol=='N') {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: DEBE SELECCIONAR EL TIPO DE BOLETIN ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
            
      if ($vbol=='' || $vtip=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      echo "$tipobol";    
      $resul=pg_exec("SELECT * FROM stztmpbo WHERE estatus='$vtip' and tipo='M' and boletin='$vbol' AND tipo_boletin='$tipobol'");
      $cantreg = pg_numrows($resul);
      if ($cantreg==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      $reg = pg_fetch_array($resul); 
   }   
   
   //Asignacion de variables para pasarlas a Smarty
   $camposquery = "a.solicitud,c.nombre,b.clase";
   $camposname= "solicitud,nombre,clase";
   $tablas    = "stztmpbo a,stmmarce b,stzderec c";
   $condicion = "a.nro_derecho=b.nro_derecho and a.nro_derecho=c.nro_derecho and
                 a.boletin=v1 and a.estatus=v2 and a.tipo='M'";
   $orden     = "1";
   //$modo      = "Incluir";
   //$modoabr   = "Inc";
   $modo      = "Eliminar";
   $modoabr   = "Elim";
   $vurl      = "m_bolediareg.php?nveces={$nveces}&nconexion={$nconexion}";
   $tabladel  = "stztmpbo";
   $condicion2= "solicitud=v6 and boletin=v1 and estatus=v2 and tipo='M'";
   $tablains  = "stztmpbo";
   $camposins = "solicitud,boletin,estatus,tipo";
   $valoresins= "v6,v1,v2,v7";
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
   
   $smarty ->assign('varfocus','formarcas2.v1'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('vtipsol',$vtipsol); 
   $smarty ->assign('vtipest',$vtipest); 
   $smarty ->assign('lboletin','Boletin:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('espacios',''); 
   $smarty->assign('apli_inf',array('N','O','E'));
   $smarty->assign('apli_def',array('--- Seleccione Tipo Boletin ---','Ordinario','Extraordinario'));

   $smarty ->assign('nveces',$nveces); 
   $smarty ->assign('nconexion',$nconexion);  
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_bolediareg.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
