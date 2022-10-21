<script language="Javascript"> 
 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }
</script>

<?php 
// *************************************************************************************
// Programa: z_buspeticio.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPEF
// Desarrollado Año 2017 I Semestre BD Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$login = $_SESSION['usuario_login'];
$role  = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo  = "z_buspeticio.php";

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Busqueda por Palabra del Peticionario/Titular');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

//Captura Variables leidas en formulario inicial
$vopc=$_GET['vopc'];
$vtitular=$_POST['vtitular'];
$vpalabra=$_POST['vpalabra'];

//Se obtiene el proximo valor para el secuencial a partir de stzsistem
$sys_actual = next_sys("mbusqpet");
$vsecuencial = grabar_sys("mbusqpet",$sys_actual);
$vcodigo=$vsecuencial;

if ($vopc==3) {
  if ($vtitular=='' || $vpalabra=='') {
    mensaje('ERROR: PROBLEMA AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
       
  $resul=pg_exec("SELECT * FROM stzsolic WHERE nombre ilike '%$vpalabra%'");
  $cantreg = pg_numrows($resul);
  if ($cantreg==0) {
    mensaje('ERROR: PROBLEMA AL INTENTAR PROCESAR - No Existen Solicitudes Asociadas','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $reg = pg_fetch_array($resul); 
}   
   
//Asignación de variables para pasarlas a Smarty a z_browspet.php
$camposquery="DISTINCT ON (a.titular) a.titular,a.nombre,b.nacionalidad";
$camposname= "titular,nombre,pais";
$tablas    = "stzsolic a, stzottid b";
$condicion = "a.nombre ilike v3 and a.titular = b.titular";
$orden     = "1";
$modo      = "Incluir";
$modoabr   = "INC";
//$modo      = "Eliminar";
//$modoabr   = "Elim";
$vurl      = "z_buspeticio.php";
$tabladel  = "stzwordpet";
//$condicion2= " ";
$tablains  = "stzwordpet";
$camposins = "nro_tramite,ref_busq,tipo_busq,codigo,palabra,titular,estado";
$valoresins= "v4,v5,$vcodigo,v3,v8,v9";
  
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
$smarty ->assign('titulo','Sistema de Marcas/Patentes');
$smarty ->assign('subtitulo','Busqueda de Peticionario'); 
$smarty ->assign('login',$usuario);
$smarty ->assign('fechahoy',$fecha);
$smarty ->assign('lcodigo','C&oacute;digo de la Palabra:'); 
$smarty ->assign('vcodigo',$vcodigo); 
$smarty ->assign('ltitular','Titular:'); 
$smarty ->assign('ltipobus','Tipo Derecho:'); 
$smarty ->assign('lreferencia','N&uacute;mero de Referencia asociado al Tr&aacute;mite a Buscar:'); 
$smarty ->assign('arraytipom',array('N','M','P'));
$smarty ->assign('arraynotip',array(' ','Marca','Patente'));

$smarty ->assign('lpalabra','Palabra del Titular a Buscar:'); 
$smarty ->assign('espacios','            '); 

$smarty ->display('z_buspeticio.tpl'); 
$smarty->display('pie_pag.tpl');
?>
