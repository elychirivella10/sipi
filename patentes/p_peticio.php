<? 
// Programa de peticionario de patentes
// Realizado por: Ing. Karina Perez

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

   if (($_SERVER['HTTP_REFERER'] == "")) {
     echo "Acceso Indebido";
     exit();
   }

   $usuario = $_SESSION['usuario_login'];
   $role = $_SESSION['usuario_rol'];
   $fecha   = fechahoy();
   $sql = new mod_db();

   $sql->connection();
   $longitud=strlen($nomen);
   $ultimoc=substr($nomen,$longitud-3,$longitud);
        
   //Se obtiene el proximo valor para el secuencial a guardar en stmevtrd a partir de stzsistem
   $sys_actual = next_sys("mbusqpet");
   $vsecuencial = grabar_sys("mbusqpet",$sys_actual);
   $vcodigo=$vsecuencial;

   //Captura Variables leidas en formulario inicial
   $vopc=$_GET['vopc'];
   $vtitular=$_POST['vtitular'];
   $vpalabra=$_POST['vpalabra'];
   $nconex = $_POST['nconex'];
   if ($vopc==3) {

	$req_fields = array("vtitular","vpalabra");
	$valores = array($vtitular,$vpalabra);
	$vacios = check_empty_fields();
      if (!$vacios) { 
//      if ($vtitular=='' || $vpalabra=='') {
         mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
       
      $resul=pg_exec("SELECT * FROM stzsolic WHERE nombre like '%$vpalabra%'");
      $cantreg = pg_numrows($resul);
      if ($cantreg==0) {
          mensaje('ERROR AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $reg = pg_fetch_array($resul); 
   }   
   
   //Asignación de variables para pasarlas a Smarty
 
   $camposquery="DISTINCT ON (a.titular) a.titular,a.nombre,b.nacionalidad";
   $camposname= "titular,nombre,nacionalidad";
   $tablas    = "stzsolic a, stzottid b";
   $condicion = "a.nombre like v3 and a.titular = b.titular";
   $orden     = "1";
   $modo      = "Incluir";
   $modoabr   = "Inc";
   //$modo      = "Eliminar";
   //$modoabr   = "Elim";
   $vurl      = "p_peticio.php";
   $tabladel  = "wordtitu";
   //$condicion2= " ";
   $tablains  = "wordtitu";
   $camposins = "codigo,palabra,titular";
   $valoresins= "$vcodigo,v3,v8";

   $smarty->assign('n_conex',$nconex); 
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
   
   $smarty ->assign('varfocus','formarcas2.v2'); 
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('vtitular',$vtitular); 
   $smarty ->assign('vpalabra',$vpalabra); 
   $smarty ->assign('titulo','Sistema de Patentes');
   $smarty ->assign('subtitulo','Busqueda de Peticionario de Patentes'); 
   $smarty ->assign('login',$usuario);
   $smarty ->assign('fechahoy',$fecha);
   $smarty ->assign('lcodigo','Codigo de la Palabra:'); 
   $smarty ->assign('vcodigo',$vcodigo); 
   $smarty ->assign('ltitular','Titular:'); 
   $smarty ->assign('lpalabra','Palabra del Titular a Buscar:'); 
   $smarty ->assign('espacios','            '); 
   $smarty->display('encabezado1.tpl');

   $smarty ->display('p_peticio.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
