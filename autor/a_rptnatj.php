<?php
// Reporte de consulta avanzada por criterio DNDA
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");


//Para trabajar con graficos
require_once "$include_lib/class.graphic.php";

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Estadisticas de DNDA por Tipo de Personas Natural o Jur&iacute;dica');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql = new mod_db();
$sql->connection();

//Recibiendo campos de Entrada
$anod=$_POST["anod"];
$anoh=$_POST["anoh"];
$tipo=$_POST["tipo"];

if ($anod=='' || $anoh=='' || $tipo=='') {
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    
if ($anoh <$anod){ 
     mensajenew('Rango de A&ntilde;os erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$cantidad= $anoh-$anod;

$PG = new PowerGraphic;
echo $tipo;


if ($tipo=='NATURAL') { 
?>

<table border='1'>
<tr>
<?php
for($cont=0;$cont<=$cantidad;$cont++) { 
?>
<td><?php echo $anod+$cont; ?></td>
<?php } ?>
</tr><tr>
<?php
$PG->title     = 'Total x Personas Naturales';
$PG->axis_x    = 'Años';
$PG->axis_y    = 'Cantidad';
$PG->type      = 1;
$PG->skin      = 1;
$PG->credits   = 0;

for($cont=0;$cont<=$cantidad;$cont++)   { 

   $resultado=pg_exec("SELECT count(*) FROM stdobras, stdobsol, stzsolic
		       WHERE stdobsol.nro_derecho = stdobras.nro_derecho
		       and stzsolic.titular = stdobsol.titular
		       AND substr(stzsolic.identificacion,1,1) = 'V'
		       AND (extract(year from stdobras.fecha_solic)) = ($anod+$cont)");
   $registro = pg_fetch_array($resultado);	
 
// Set values
$PG->x[$cont] = $anod + $cont;
$PG->y[$cont] = $registro[0];
?>
<td><?php echo $registro[0]; ?> </td>
<?php
}	
?>
</tr>
<?php
}
?>
</table>

<?php
//Totales Obras x Personas Juridicas

if ($tipo=='JURIDICA') { 
?>

<table border='1'>
<tr>
<?php
for($cont=0;$cont<=$cantidad;$cont++) { 
?>
<td><?php echo $anod+$cont; ?></td>
<?php } ?>
</tr><tr>
<?php
$PG->title     = 'Total x Personas Jur&iacute;dicas';
$PG->axis_x    = 'Años';
$PG->axis_y    = 'Cantidad';
$PG->type      = 1;
$PG->skin      = 1;
$PG->credits   = 0;

for($cont=0;$cont<=$cantidad;$cont++)   { 


   $resultado=pg_exec("SELECT count(*) FROM stdobras, stdobsol, stzsolic
		       WHERE stdobsol.nro_derecho = stdobras.nro_derecho
		       and stzsolic.titular = stdobsol.titular
		       AND substr(stzsolic.identificacion,1,1) != 'V'
		       AND (extract(year from stdobras.fecha_solic)) = ($anod+$cont)");
	
	
   $registro = pg_fetch_array($resultado);	

// Set values
$PG->x[$cont] = $anod + $cont;
$PG->y[$cont] = $registro[0];
?>
<td><?php echo $registro[0]; ?> </td>
<?php
}	
?>
</tr>
<?php
}
?>
</table>

<div align="center" >
<?php
//Impresion de Graficos
echo ' Grafico Estilo Barra <br><br/>';
echo '<img src="../include/class.graphic.php?' . $PG->create_query_string() . '" border="1" alt="" /> <br /><br />';

$PG->type = 5;
echo 'Grafico Estilo Torta <br /><br />';
echo '<img  src="../include/class.graphic.php?' . $PG->create_query_string() . '" border="1"  alt="" /> <br /><br />';
?>

</div>
</body>
</html>
