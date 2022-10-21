<?php
include ("../z_includes.php");
//LLamadas a librerias graficas
include ("$include_lib/src/jpgraph.php");
include ("$include_lib/src/jpgraph_bar.php");
include ("$include_lib/src/jpgraph_line.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Estadisticas - Publicaciones Nac-Ext x Boletin');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Recibiendo campos de Entrada
$boletin=$_POST["bol"];
$vopc=$_GET["vopc"];

if ($vopc==1) {
if ($boletin=='') {
    $sql->disconnect();
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }

// Orden publicacion
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento=1201 and b.estat_ant=1002 and
              b.documento='$boletin'");
$registro=pg_fetch_array($resultado);	
$cant_ord=$registro[0];

// Solicitadas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento-1000 in (42,93,124,888,927,983,990,997) and
              b.estat_ant-1000 in (3,110,111,6,88,1,191,888,954,500) and
              b.documento='$boletin'");
$registro=pg_fetch_array($resultado);	
$cant_sol=$registro[0];

// concedidas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento-1000 in (122,181,182) and
              b.estat_ant-1000 in (101,390,399) and
              b.documento='$boletin'");
$registro=pg_fetch_array($resultado);	
$cant_con=$registro[0];

// Devueltas por Forma
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento in (1156,1122) and b.estat_ant in (1200,1116) and 
              b.documento='$boletin'");
$registro=pg_fetch_array($resultado);
$cant_devfor=$registro[0];

// Devueltas por Fondo
//$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
//	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
//              b.evento=1122 and b.estat_ant=1116 and 
//              b.documento='$boletin'");
//$registro=pg_fetch_array($resultado);
//$cant_devfon=$registro[0];

// Observadas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento=1122 and b.estat_ant=1003 and 
              b.documento='$boletin'");
$registro=pg_fetch_array($resultado);
$cant_obs=$registro[0];

// Prioridad Extinguida
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento=1123 and b.estat_ant=1025 and 
              b.documento='$boletin'");
$registro=pg_fetch_array($resultado);
$cant_pex=$registro[0];

// Caducas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento = 1125 and b.documento='$boletin'");
$registro=pg_fetch_array($resultado);	
$cant_cad=$registro[0];

// Desistidas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and 
              b.evento = 1123 and b.estat_ant=1910 and 
              b.documento='$boletin'");
$registro=pg_fetch_array($resultado);
$cant_des=$registro[0];

// Observada Desistidas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and 
              b.evento = 1251 and b.estat_ant=1914 and 
              b.documento='$boletin'");
$registro=pg_fetch_array($resultado);
$cant_obsdes=$registro[0];

// Desistimiento de Observacion
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and 
              b.evento=1121 and b.estat_ant=1125 and 
              b.documento='$boletin'");
$registro=pg_fetch_array($resultado);
$cant_desobs=$registro[0];

// Desistimiento de Observacion Mejor derecho
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and 
              b.evento=1121 and b.estat_ant=1130 and 
              b.documento='$boletin'");
$registro=pg_fetch_array($resultado);
$cant_desobsmd=$registro[0];

// Negadas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and 
              b.evento = 1062 and b.documento='$boletin'");
$registro=pg_fetch_array($resultado);
$cant_neg=$registro[0];

// Orden publicacion VE
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento=1201 and b.estat_ant=1002 and
              b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);	
$cant_ord2=$registro[0];

// Solicitadas VE
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento-1000 in (42,93,124,888,927,983,990,997) and
              b.estat_ant-1000 in (3,110,111,6,88,1,191,888,954,500) and
              b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);	
$cant_sol2=$registro[0];

// concedidas VE
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento-1000 in (122,181,182) and
              b.estat_ant-1000 in (101,390,399) and
              b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);	
$cant_con2=$registro[0];

// Devueltas por Forma VE
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento in (1156,1122) and b.estat_ant in (1200,1116) and 
              b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);
$cant_devfor2=$registro[0];

// Devueltas por Fondo VE
//$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
//	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
//              b.evento=1122 and b.estat_ant=1116 and 
//              b.documento='$boletin' and a.pais_resid='VE'");
//$registro=pg_fetch_array($resultado);
//$cant_devfon2=$registro[0];

// Observadas VE
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento=1122 and b.estat_ant=1003 and 
              b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);
$cant_obs2=$registro[0];

// Prioridad Extinguida VE
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento=1123 and b.estat_ant=1025 and 
              b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);
$cant_pex2=$registro[0];

// Caducas VE
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              b.evento = 1125 and b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);	
$cant_cad2=$registro[0];

// Desistidas VE
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and 
              b.evento = 1123 and b.estat_ant=1910 and 
              b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);
$cant_des2=$registro[0];

// Observada Desistidas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and 
              b.evento = 1251 and b.estat_ant=1914 and 
              b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);
$cant_obsdes2=$registro[0];

// Desistimiento de Observacion VE
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and 
              b.evento=1121 and b.estat_ant=1125 and 
              b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);
$cant_desobs2=$registro[0];

// Desistimiento de Observacion Mejor derecho
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and 
              b.evento=1121 and b.estat_ant=1130 and 
              b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);
$cant_desobsmd2=$registro[0];

// Negadas VE
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and 
              b.evento = 1062 and b.documento='$boletin' and a.pais_resid='VE'");
$registro=pg_fetch_array($resultado);
$cant_neg2=$registro[0];


$data1y=array($cant_ord2,$cant_sol2,$cant_con2,$cant_devfor2,$cant_obs2,
             $cant_pex2,$cant_cad2,$cant_des2,$cant_obsdes2,$cant_desobs2,
             $cant_desobsmd2,$cant_neg2);
$data2y=array($cant_ord-$cant_ord2,$cant_sol-$cant_sol2,$cant_con-$cant_con2,
              $cant_devfor-$cant_devfor2,$cant_obs-$cant_obs2,
              $cant_pex-$cant_pex2,$cant_cad-$cant_cad2,$cant_des-$cant_des2,
              $cant_obsdes-$cant_obsdes2,$cant_desobs-$cant_desobs2,
              $cant_desobsmd-$cant_desobsmd2,$cant_neg-$cant_neg2);

$datax=array("ORDEN PUB","SOLICITADA","CONCEDIDAS","DEVUELTAS","OBSERVADAS",
             "P.EXTING.","CADUCAS","DESISTIDAS","OBS.DES.","DES.OBS.",
             "DES.OBS.MD.","NEGADAS");

// convertir a formato de numero entero
function cbFmtPercentage($aVal) {
    return sprintf("%d",$aVal); }

// Create the graph. These two calls are always required
$graph = new Graph(700,300,"auto");	
$graph->SetScale("textlin");
$graph->yaxis->scale->SetGrace(5);

// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(40,30,60,40);

// Create a bar pot
$b1plot = new BarPlot($data1y);
$b2plot = new BarPlot($data2y);

// Adjust fill color
$b1plot->SetFillColor('red');
$b1plot->value->SetFormatCallback("cbFmtPercentage");
$b1plot->value->Show();
//$graph->Add($b1plot);
$b2plot->SetFillColor('blue');
$b2plot->value->SetFormatCallback("cbFmtPercentage");
$b2plot->value->Show();
//$graph->Add($b2plot);

//Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot,$b2plot));
$graph->Add($gbplot);

// Setup the titles
$graph->title->Set("PUBLICACIONES DE MARCAS EN EL BOLETIN ".$boletin);
$graph->xaxis->title->Set("");
$graph->yaxis->title->Set("");

$graph->title->SetFont(FF_FONT2,FS_BOLD);
//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetFont(FF_FONT0,FS_BOLD);
$graph->xaxis->SetTickLabels($datax);

$b1plot->SetLegend("Venezolanas");
$b2plot->SetLegend("Extranjeras");
//$graph->xaxis->SetLabelFormatCallback('TimeCallback');

//Display the graph
//$graph->Stroke();
// Setup color for gradient fill style 
//$bplot->SetFillGradient("navy","lightsteelblue",GRAD_MIDVER);
// Set color for the frame of each bar
//$bplot->SetColor("navy");
//$graph->Add($bplot);

$graph->Stroke("../cuadro.jpg"); 

?><div align="center"><table>
<tr><img src="../cuadro.jpg" border="0"></tr>
<tr><td class="cnt"><a href="m_est_pnexbol.php?vopc=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td></tr></table><?php
$smarty->display('pie_pag.tpl');
}

if ($vopc==0) {
//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Boletin:');
$smarty->assign('varfocus','forestanu.bol'); 
$smarty->display('m_est_pnexbol.tpl');
$smarty->display('pie_pag.tpl');
}

$sql->disconnect();
?>
