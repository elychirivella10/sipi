<script type="text/javascript" src="../include/js/adminjavascript.js"></script>

<?php
// *************************************************************************************
// Programa: z_gridunid.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

function gridunit() {
// Variables
$sql      = new mod_db();
$tbname_1 = "stzdepto";
$tbname_2 = "stzusuar";
$vopc     = $_POST['vopc'];

if (empty($vopc)) {
  $nconex = $_SESSION['conexion']; }

//echo "valor en grids= opc=$vopc $nconex "; 

//Paginacion 
if(strlen($_POST['adelante']) > 0)
  $adelante = "1";
if(strlen($_POST['atras']) > 0)
  $atras = "1";

$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total  = $_POST['total'];
if ($vopc==1) {
  $nconex = $_POST['nconex']; }

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 4;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$$cuanto;
$hiddenvars['total']=$total;
$hiddenvars['nconex']=$nconex;

//Variables Post 
$idcod = $_POST['elimina'];

//echo "opcion $nconex ";
//$smarty->assign('n_conex',$nconex);

//Verificando conexion
$sql->connection();

// Verificacion en Tabla si no posee Usuarios Asignados para poder Eliminar ...  
if (!empty($idcod)) {
  $filasfound = 0;
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE cod_depto='$idcod'");
  if ($obj_query) { 
    $filasfound = $sql->nums('',$obj_query); 
    if ($filasfound==0) {
      echo "<p align='right'><b><font size='1' color='#CC0000' face='Tahoma'>Eliminada Unidad: $idcod</font></b></p>";
      $result = $sql->del($tbname_1,"cod_depto='$idcod'"); } 
  }
}  

// Obtencion de los Registros o Filas
$resultado   = pg_exec("SELECT * FROM $tbname_1 ORDER BY nombre OFFSET $inicio LIMIT $cuanto");
$cantidad    = pg_exec("SELECT * FROM $tbname_1 ");
$total       = pg_numrows($cantidad);
$filas_found = pg_numrows($resultado);
if ($total==0) {
  mensajenew("La Tabla de Departamentos esta Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); } 

?>
<p align='center'><b><font size='3' color='#CC0000' face='Tahoma'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Registros Encontrados </font></b></p>
<?php
    echo "<form name 'frmgrid' action='z_gridunid.php method='POST'>";
    echo "<input type='hidden' name='nconex' value='$nconex'>";
    echo "<input type='hidden' name='vopc' value=1>";

    //$obj_query = $sql->query("SELECT * FROM $tbname_1 order by nombre");
    //if ($obj_query) { $filas_found = $sql->nums('',$obj_query); }
    $cont = 1;
    $reg=pg_fetch_array($resultado);
    //$objs = $sql->objects('',$obj_query);
    for($cont=1;$cont<=$filas_found;$cont++) {
      $nbunidad = trim($reg[nombre]);
	   $conjunto[$cont]=$reg['cod_depto'];
      if ($cont % 2==0) {
        echo "<tr class='row0'>"; }
	   else { 
	     echo "<tr class='row1'>"; }
	   echo "<td>";
		echo "$cont";
		echo "</td>";
		echo "<td>";
		echo "	<input type='checkbox' id='chk' name='chk' value=$reg[cod_depto] />"; 
		echo "</td>";
		echo "<td>";
		echo "	<a href='../comun/z_consunid.php?vunid=$reg[cod_depto]&vtip=0'>";
		//echo "      $objs->cod_depto";
		echo "      $reg[cod_depto]";
		echo "	</a>";
		echo "</td>";
		echo "<td nowrap='nowrap'>";
		//echo "      $objs->nombre";
		echo "$nbunidad";
		echo "</td>";
		echo "<td nowrap='nowrap'>";
		echo "</td>";
		echo "<td nowrap='nowrap'>";
		echo "</td>";
		echo "<td nowrap='nowrap'>";
		echo "</td>";
		echo "<td nowrap='nowrap'>";
		echo "</td>";
		echo "<td>";
		//echo "  <a href='../marcas/z_modepto.php?vopc=$objs->cod_depto'>";
		echo "  <a href='../comun/z_modepto.php?vopc=1&valor=$reg[cod_depto]&n_conex={$nconex}'>";
		echo "  <img src='../imagenes/edit.png'  name='editar' title='Editar' align='left' border='0'></a>";
		echo "</td>";
		echo "<td>";
		//echo "  <a href='../comun/z_elimunid.php?vopc=$objs->cod_depto'>";
		echo "  <input type='image' name='elimina' src='../imagenes/erase.png' title='Eliminar' value=$conjunto[$cont]>";
	   echo "<input type ='hidden' name=valor value=$conjunto[$cont]>";
		//echo "  <a href='../comun/z_elimunid.php?vopc=$reg[cod_depto]'>";
		//echo "  <img src='../imagenes/erase.png'  name='eliminar' title='&nbsp;Eliminar' align='left' border='0'></a>";
		echo "</td>";
	   echo "</tr>";
	   $reg=pg_fetch_array($resultado);
      //$objs = $sql->objects('',$obj_query);
    }	
   //echo "<form name 'frmgrid' action='z_gridunid.php method='POST'>"; 
   echo "<input type='hidden' name='adelante'>";
   echo "<input type='hidden' name='atras'>";
   echo "<table>";
   echo "<br />";
   echo "<tr>";
   foreach($hiddenvars as $var => $val)
   {
   ?>
   <input type="hidden" name="<?= $var ?>" value="<?= $val ?>" />
   <?
   }
   if($inicio > 0)
   {
   ?>
   <input type="submit" style="color: #CC0000; font-size: 10pt" name="atras" value="Previos <?= min($inicio, $cuanto) ?>" />
   <?
   }
   else
   {
   //espacio  &nbsp;
   }
   if($total - $inicio > $cuanto)
   {
   ?>
   <input type='submit' style="color: #CC0000; font-size: 10pt" name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
   <?
   }
   else
   {
   }
   echo "</tr>";
   echo "</table>";
   echo "</form>";
   return $nconex;
}
?>

