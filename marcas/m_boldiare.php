<?
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login   = $_SESSION['usuario_login'];
$sql   = new mod_db();
$fecha = fechahoy();
$modulo = 'm_boldiare.php';

$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces+1;
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'M'); }

$smarty ->assign('titulo',$substmar);  
$smarty ->assign('subtitulo','Edici&oacute;n de Datos para el Bolet&iacute;n'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha);

   $vuser = $usuario;
     
   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vbol=$_POST['vbol'];
   $vtip=$_POST['vtip'];
      
   $sql->connection($login);   
   $vtipest=array(1563,1564,1565,1566,1557,1558,1559,1560,1561,1562);
   $vtipsol=array("Certificados Elaborados","Devolucion de Anota. Marginal","Reingreso de Anota. Marginal","Aviso Cancelacion x Falta de Uso","Desistimiento Renovacion",
   "Desistimiento Cesion","Desistimiento Fusion","Desistimiento Licencia Uso","Desistimiento Cambio de Nombre","Desistimiento Cambio de Domicilio");
   
   if ($vopc==3) {
            
      if ($vbol=='' || $vtip=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
       
      $resul=pg_exec("SELECT * FROM stztmpbor WHERE estatus='$vtip' and tipo='M' and boletin='$vbol'");
      $cantreg = pg_numrows($resul);
      if ($cantreg==0) {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
      $reg = pg_fetch_array($resul); 
   }   
   
   //Asignacion de variables para pasarlas a Smarty
   $camposquery = "a.registro,c.nombre,b.clase,a.nro_derecho";
   $camposname= "registro,nombre,clase";
   $tablas    = "stztmpbor a,stmmarce b,stzderec c";
   $condicion = "a.nro_derecho=b.nro_derecho and a.nro_derecho=c.nro_derecho and
                 a.boletin=v1 and a.estatus=v2 and a.tipo='M'";
   $orden     = "1";
   //$modo      = "Incluir";
   //$modoabr   = "Inc";
   $modo      = "Eliminar";
   $modoabr   = "Elim";
   $vurl      = "m_boldiare.php?nveces={$nveces}&nconexion={$nconexion}";
   $tabladel  = "stztmpbor";
   //$condicion2= "solicitud=v6 and boletin=v1 and estatus=v2 and tipo='M'";
   $condicion2= "registro=v7 and boletin=v1 and estatus=v2 and tipo='M'";
   $tablains  = "stztmpbor";
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

   $smarty ->assign('nveces',$nveces); 
   $smarty ->assign('nconexion',$nconexion);  
   $smarty->display('encabezado1.tpl');
   $smarty ->display('m_boldiare.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
