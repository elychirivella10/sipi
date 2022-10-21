<?
//Modificado por Ing. Romulo Mendoza el 08/06/2010
//Separacion de Marcas de lo de Registro de Propiedad Industrial
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql = new mod_db();
$fecha = fechahoy();

$modulo = 'm_bolediar.php';
$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces+1;
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'M'); }

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Edici&oacute;n de Datos Marcas para el Bolet&iacute;n'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha);

   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vbol=$_POST['vbol'];
   $vtip=$_POST['vtip'];
   $tipobol=$_POST['aplica'];
      
   $sql->connection($login);   
   $vtipest=array(1002,1023,1024,1030,1006,1200,1116,1003,1011,1910,1914,1125,1130);
   $vtipsol=array("Orden de Publicacion","Perimidas x Publicacion en Prensa Extemporanea","Publicacion Prensa Defectuosa","Perimidas por NO Publicacion Prensa",
   "Solicitadas","Devueltas","Devueltas Fondo","Observadas","Oposicion Inadmisible por incumplir Art. 49 Lopa","Desistidas",
   "Desistimiento a Observadas por Ley","Desistimiento de Observaciones",
   "Desistim. Observacion Mejor Derecho");
   
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
   $vurl      = "m_bolediar.php?nveces={$nveces}&nconexion={$nconexion}";
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
   $smarty ->assign('lboletin','Bolet&iacute;n:'); 
   $smarty ->assign('ltipo','Tipo de Solicitudes:'); 
   $smarty ->assign('espacios',''); 
   $smarty->assign('apli_inf',array('N','O','E'));
   $smarty->assign('apli_def',array('--- Seleccione Tipo Boletin ---','Ordinario','Extraordinario'));

   $smarty ->assign('nveces',$nveces); 
   $smarty ->assign('nconexion',$nconexion);  
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_bolediar.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
