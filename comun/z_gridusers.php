<?php
// *************************************************************************************
// Programa: z_gridusers.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

// Variables
$sql      = new mod_db();
$tbname_1 = "stzmenu";
$tbname_2 = "stzrolmenu";

//Paginacion 
if(strlen($_POST['adelante']) > 0)
  $adelante = "1";
if(strlen($_POST['atras']) > 0)
  $atras = "1";
$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total = $_POST['total'];
$fila  = $_POST['fila'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 6;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$$cuanto;
$hiddenvars['total']=$total;

//Variables Post 
$idcod = $_POST['elimina'];

//Verificando conexion
$sql->connection();

// Verificacion en Tabla si no posee Usuarios Asignados para poder Eliminar ...  
if (!empty($idcod)) {
  $filasfound = 0;
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE codmenu='$idcod'");
  if ($obj_query) { 
    $filasfound = $sql->nums('',$obj_query); 
    if ($filasfound==0) {
      echo "<p align='right'><b><font size='1' color='#CC0000' face='Tahoma'>Eliminado Rol: $idcod</font></b></p>";
      $result = $sql->del($tbname_1,"codmenu='$idcod'"); } 
  }
}  

// Obtencion de los Registros o Filas
$resultado   = pg_exec("SELECT * FROM $tbname_1 ORDER BY nombre OFFSET $inicio LIMIT $cuanto");
$cantidad    = pg_exec("SELECT * FROM $tbname_1 ");
$total       = pg_numrows($cantidad);
$filas_found = pg_numrows($resultado);
if ($inicio == 0) { $fila = 0; }

if ($total==0) {
  mensajenew("La Tabla de Opciones de Menu esta Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); } 

?>
<p align='center'><b><font size='3' color='#CC0000' face='Tahoma'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Registros Encontrados </font></b></p>
<?php
    echo "<form name 'frmgrid' action='z_gridmenu.php method='POST'>";
    $cont = 1;
    $reg=pg_fetch_array($resultado);
    for($cont=1;$cont<=$filas_found;$cont++) {
      $nbunidad = substr(trim($reg[nombre]),0,50);
	   $conjunto[$cont]=$reg[codmenu];
	   $fila = $fila + 1;
      if ($cont % 2==0) {
        echo "<tr class='row0'>"; }
	   else { 
	     echo "<tr class='row1'>"; }
	   echo "<td>";
		echo "$fila";
		echo "</td>";
		echo "<td>";
		echo "	<input type='checkbox' id='chk' name='chk' value=$reg[codmenu] />"; 
		echo "</td>";
		echo "<td>";
		echo "	<a href=''>";
		echo "      $reg[codmenu]";
		echo "	</a>";
		echo "</td>";
		echo "<td nowrap='nowrap'>";
		echo "$nbunidad";
		echo "</td>";
		echo "<td align='center'>";
		echo "$reg[nivel]";
		echo "</td>";
		echo "<td>";
		echo "$reg[nomenclatura]";
		echo "</td>";
		echo "<td>";
		echo "$reg[estado]";
		echo "</td>";
		echo "<td>";
		echo "$reg[fecha_elim]";
		echo "</td>";
		echo "<td>";
		echo "  <a href='../marcas/z_modobj.php?vopc=$reg[codmenu]'>";
		echo "  <img src='../imagenes/edit.png'  name='editar' title='&nbsp;Editar' align='left' border='0'></a>";
		echo "</td>";
		echo "<td>";
		echo "  <input type='image' name='elimina' src='../imagenes/erase.png' title='&nbsp;Eliminar' value=$conjunto[$cont]>";
		echo "</td>";
	   echo "</tr>";
	   $reg=pg_fetch_array($resultado);
    }	
   echo "<input type='hidden' name='adelante'>";
   echo "<input type='hidden' name='atras'>";
   echo "<input type='hidden' name='fila' value=$fila>";
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
?>

