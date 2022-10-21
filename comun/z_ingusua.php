<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
//$role     = $_SESSION['usuario_rol'];
$sql      = new mod_db();
$fecha    = fechahoy();
$tbname_1 = "stzdepto";
$email    = "@sapi.gob.ve";
$modulo   = "z_ingrol.php";

// Obtencion de variables de los campos del tpl
$conx     = $_GET['conx'];
$salir    = $_GET['salir'];
$nconex   = $_GET['nconex'];
$na_conex = $_GET['na_conex'];


$smarty->assign('titulo','Modulo de Acceso');
$smarty->assign('subtitulo','Mantenimiento de Usuarios / Ingreso');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($conx==0) { 
  $smarty->assign('n_conex',$nconex); 
  $smarty->assign('na_conex',$na_conex); }
else {
    $res_conex = insconex($usuario,$modulo,'I');
    $smarty->assign('n_conex',$res_conex); }
  
if (($salir==0) && ($nconex>0)) {
  $salirphp = salirconx($nconex);
}

//Obtención de los Departamentos 
$obj_query = $sql->query("SELECT * FROM $tbname_1 order by nombre");
if (!$obj_query) 
  { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) 
  {
    mensajenew("Tabla de Departamentos Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$cont = 0;
$arraydepto[$cont]=0;
$arraynombre[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arraydepto[$cont]=$objs->cod_depto;
    $arraynombre[$cont]=trim($objs->nombre);
    $objs = $sql->objects('',$obj_query);
  }
  
$smarty->assign('arraydepto',$arraydepto);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('depto_id',0);
$smarty->assign('campo1','Nro. Cedula');
$smarty->assign('campo2','Nombre completo:');
$smarty->assign('campo3','E-Mail:');
$smarty->assign('campo4','Cuenta:');
$smarty->assign('campo5','Password:');
$smarty->assign('campo6','Confirmar Password:');
$smarty->assign('campo7','Ubicacion:');
$smarty->assign('varfocus','forusing.cedula'); 
$smarty->assign('email',$email);
$smarty->assign('login',$usuario);
$smarty->assign('na_conex',$na_conex);

$smarty->display('z_ingusua.tpl');
$smarty->display('pie_pag.tpl');
?>
