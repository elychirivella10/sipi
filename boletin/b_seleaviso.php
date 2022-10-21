<? 
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }


   $login = $_SESSION['usuario_login'];
   $role = $_SESSION['usuario_rol'];
   $fecha   = fechahoy();
   
   $sql = new mod_db();
   $sql->connection($login);


   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $nboletin=$_POST['nboletin'];
   $nconex = $_POST['nconex'];

   if ($vopc==3) {
      if ($nboletin=='' ) {
         mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
       
      $resul=pg_exec("SELECT * FROM stzavisos");
      $cantreg = pg_numrows($resul);
      if ($cantreg==0) {
         mensaje('ERROR AL INTENTAR PROCESAR - No Existen Documentos Asociadas','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $reg = pg_fetch_array($resul); 
   }   
   
   //Asignación de variables para pasarlas a Smarty
   $smarty->assign('n_conex',$nconex);  
   $camposquery="*";
   $camposname= "nro_aviso,titulo";
   $tablas    = "stzavisos";
   $condicion = "nro_aviso!=0";
   $orden     = "1";
   $modo      = "Incluir";
   $modoabr   = "Inc";
   //$modo      = "Eliminar";
   //$modoabr   = "Elim";
   $vurl      = "b_seleaviso.php";
   $tabladel  = "stztmpav";
   //$condicion2= " ";
   $tablains  = "stztmpav";
   $camposins = "nro_aviso,boletin,usuario,fecha,hora";
   $valoresins= "v6,v3,v7,v8,v9";
    
   $smarty ->assign('camposquery',$camposquery);
   $smarty ->assign('camposname',$camposname);
   $smarty ->assign('tablas',$tablas);
   $smarty ->assign('condicion',$condicion);
   $smarty ->assign('condeli',$condeli);
   $smarty ->assign('orden',$orden); 
   $smarty ->assign('modo',$modo); 
   $smarty ->assign('modoabr',$modoabr); 
   $smarty ->assign('vurl',$vurl);
   $smarty ->assign('tabladel',$tabladel);
   $smarty ->assign('condicion2',$condicion2);
   $smarty ->assign('tablains',$tablains);
   $smarty ->assign('camposins',$camposins);
   $smarty ->assign('valoresins',$valoresins);
   
   $smarty ->assign('varfocus','formarcas2.v2'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('nboletin',$nboletin); 
   $smarty ->assign('titulo','Sistema de Marcas');
   $smarty ->assign('subtitulo','Generar Avisos para Bolet&iacute;n'); 
   $smarty ->assign('login',$usuario);
   $smarty ->assign('fechahoy',$fecha);
   $smarty ->assign('lcodigo','Codigo de la Palabra:'); 
   $smarty ->assign('vcodigo',$vcodigo); 
   $smarty ->assign('ltitular','Titular:'); 
   $smarty ->assign('lpalabra','Nro. Bolet&iacute;n:'); 
   $smarty ->assign('espacios','            '); 
   $smarty->display('encabezado1.tpl');

   $smarty ->display('b_seleaviso.tpl'); 
   $smarty->display('pie_pag1.tpl');
?>
