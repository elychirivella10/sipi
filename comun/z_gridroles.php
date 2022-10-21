<?php
// *************************************************************************************
// Programa: z_gridroles.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

// Variables
$sql      = new mod_db();
$tbname_1 = "stzroles";
$tbname_2 = "stzusuar";
$tbname_3 = "stzuserol";

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
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE role='$idcod'");
  if ($obj_query) { 
    $filasfound = $sql->nums('',$obj_query); 
    if ($filasfound==0) {
      echo "<p align='right'><b><font size='1' color='#CC0000' face='Tahoma'>Eliminado Rol: $idcod</font></b></p>";
      $result = $sql->del($tbname_1,"role='$idcod'"); } 
  }
}  

// Obtencion de los Registros o Filas
$resultado   = pg_exec("SELECT * FROM $tbname_1 ORDER BY nombre OFFSET $inicio LIMIT $cuanto");
$cantidad    = pg_exec("SELECT * FROM $tbname_1 ");
$total       = pg_numrows($cantidad);
$filas_found = pg_numrows($resultado);
if ($inicio == 0) { $fila = 0; }

if ($total==0) {
  mensajenew("La Tabla de Roles esta Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); } 

?>
<p align='center'><b><font size='3' color='#CC0000' face='Tahoma'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Registros Encontrados </font></b></p>
<?php
    echo "<form name 'frmgrid' action='z_gridroles.php method='POST'>";
    $cont = 1;
    $reg=pg_fetch_array($resultado);
    for($cont=1;$cont<=$filas_found;$cont++) {
      $nbrole = substr(trim($reg[nombre]),0,50);
	   $conjunto[$cont]=$reg[role];
	   $fila = $fila + 1;
      if ($cont % 2==0) {
        echo "<tr class='row0'>"; }
	   else { 
	     echo "<tr class='row1'>"; }
	   echo "<td width='2%'>";
		echo "$fila";
		echo "</td>";
		echo "<td width='3%'>";
		echo "	<input type='checkbox' id='chk' name='chk' value=$reg[role] />"; 
		echo "</td>";
		echo "<td width='10%'>";
		echo "	<a href='../comun/z_consrole.php?vrole=$reg[role]&vtip=0'>";
		echo "      $reg[role]";
		echo "	</a>";
		echo "</td>";
		echo "<td width='25%' nowrap='nowrap'>";
		echo "$nbrole";
		echo "</td>";
		echo "<td width='5%' nowrap='nowrap'>";
                if ($reg[estado]=="A") { echo "<img src='../imagenes/tick.png'"; }
                else { echo "<img src='../imagenes/publish_x.png'"; }
		//echo "$reg[estado]";
		echo "</td>";
		echo "<td width='20%' nowrap='nowrap'>";
		echo "$reg[fecha_crea] - $reg[hora_crea]";
		echo "</td>";
		echo "<td width='20%' nowrap='nowrap'>";
		if (!empty($reg[fecha_elim])) { echo "$reg[fecha_elim] - $reg[hora_elim]"; }
		echo "</td>";
		echo "<td width='5%' nowrap='nowrap'>";
		echo "</td>";
		echo "<td width='5%'>";
		echo "  <a href='../comun/z_modrol.php?vopc=1&valor=$reg[role]'>";
		echo "  <img src='../imagenes/edit.png'  name='editar' title='Editar' align='left' border='0'></a>";
		echo "</td>";
		echo "<td width='5%'>";
		echo "  <input type='image' name='elimina' src='../imagenes/erase.png' title='Eliminar' value=$conjunto[$cont]>";
	        echo "<input type ='hidden' name=valor value=$conjunto[$cont]>";
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

