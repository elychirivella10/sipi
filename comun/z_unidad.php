<script language="JavaScript">

 function browseconsulta(var1,var2,var3) {
   this.interesado=1;
   this.modalidad=1;
   open("z_consunid.php?vunid="+var1.value+"&vmod="+var2.value+"&nconex="+var3.value+"&vmodal="+this.modalidad+"&vtip="+this.interesado,"Ventana","scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script>

<?php
// *************************************************************************************
// Programa: z_unidad.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login    = $_SESSION['usuario_login'];
$fecha    = fechahoy();
$tbname_1 = "stzdepto";
$tbname_2 = "stzusuar";
$sql      = new mod_db();

// Obtencion de variables de los campos del tpl
$conx   = $_GET['conx']; 
$vopc   = $_POST['vopc'];
$search = $_POST['search'];
$filtro = $_POST['filtro'];
$modulo = "z_unidad.php";

$salir  = trim($_GET['salir']); 
$nconex = $_GET['nconex'];

$n_conex = $_POST['n_conex'];
$navega  = $_POST['navega'];

$smarty->assign('titulo','M&oacute;dulo de Configuraci&oacute;n');
$smarty->assign('subtitulo','Administraci&oacute;n de Unidades / Departamentos');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paginacion 
if(strlen($_POST['adelante']) > 0)
  $adelante = "1";
if(strlen($_POST['atras']) > 0)
  $atras = "1";

$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total  = $_POST['total'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 4;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$cuanto;
$hiddenvars['total']=$total;

//Variables Post 
$idcod = $_POST['elimina'];

//Verificando conexion
$sql->connection();

// Verificacion en Tabla si no posee Usuarios Asignados para poder Eliminar ...  
if (!empty($idcod)) {
  $filasfound = 0;
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE cod_depto='$idcod'");
  if ($obj_query) { 
    $filasfound = $sql->nums('',$obj_query); 
    if ($filasfound==0) {
      $result = $sql->del($tbname_1,"cod_depto='$idcod'");
      echo "<p align='right'><b><font size='1' color='#CC0000' face='Tahoma'>Eliminada Unidad: $idcod</font></b></p>";
    } 
  }
}  

// Obtencion de los Registros o Filas   
$resultado   = pg_exec("SELECT * FROM stzdepto ORDER BY nombre OFFSET $inicio LIMIT $cuanto"); 
$cantidad    = pg_exec("SELECT * FROM $tbname_1");
$total       = pg_numrows($cantidad);
$filas_found = pg_numrows($resultado);
if ($total==0) {
  Mensajenew("La Tabla de Departamentos esta Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }
    
$cont = 0;
$arr_unid = array();
$reg=pg_fetch_array($resultado);
for($cont=0;$cont<$filas_found;$cont++) {
  $arr_unid1[$cont] = $reg['cod_depto'];
  $arr_unid2[$cont] = trim($reg['nombre']);
  $reg=pg_fetch_array($resultado);
}
$smarty->assign('arr_unid1',$arr_unid1);
$smarty->assign('arr_unid2',$arr_unid2); 
$smarty->assign('vnumrows',$filas_found);
    	
$minprev = min($inicio, $cuanto);
$minsig  = min(($total - ($inicio + $cuanto)), $cuanto);
$inicial = min($inicio + $cuanto, $total);

$smarty->assign('minprev',$minprev);
$smarty->assign('minsig',$minsig);
$smarty->assign('inicial',$inicial); 
 
if ($navega=='S') { $salir=1; $nconex=$n_conex; $smarty->assign('n_conex',$nconex); }

if ($conx==0) { $smarty->assign('n_conex',$nconex); }
else {
  if ($conx==1) {
    $na_conex = $_GET['na_conex']; 
    $smarty->assign('n_conex',$na_conex);
  }
  else {
    if ($conx==2) { $salirphp = salirconx($nconex); 
    $res_conex = insconex($login,$modulo,'A');
    $smarty->assign('n_conex',$res_conex); }
  }
}    

if ($vopc==2) {
  $salir = 1;
  $nconex = $_POST['n_conex'];
  $smarty->assign('n_conex',$nconex);
}

if (($salir==0) && ($nconex>0)) {
  $salirphp = salirconx($nconex);
}

$smarty->assign('inicio',$inicio);
$smarty->assign('cuanto',$cuanto);
$smarty->assign('total',$total);

$smarty->display('z_unidad.tpl');
$smarty->display('pie_pag.tpl');
?>
