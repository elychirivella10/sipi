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
$smarty->assign('subtitulo','Estadisticas - Relacion Orden Pub.Prensa-Pagadas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Recibiendo campos de Entrada
$boletin=$_POST["bol"];
$boletin2=$_POST["bol2"];
$vpais=$_POST["pais"];
$vopc=$_GET["vopc"];

if ($vopc==1) {
if ($boletin=='' or $boletin2=='' or $boletin>$boletin2) {
    $sql->disconnect();
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }
$dif=$boletin2-$boletin;
if ($dif>11) {
    $sql->disconnect();
    mensajenew('El rango no puede ser mayor a 11 boletines...!!!',
               'javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }

$ptit='';
if ($vpais=='ZZ' or $vpais=='') { $pquery2=''; }
else {
  if ($vpais=='EX') { 
      $pquery2=" and a.nro_derecho in (select distinct nro_derecho from stzottid where pais_domicilio<>'VE')";
      $ptit=' EXTRANJERAS'; } 
  else { 
      $pquery2=" and a.nro_derecho in (select distinct nro_derecho from stzottid where pais_domicilio='".$vpais."')";
      $ptit=" DEL PAIS: ".$vpais; }
}
if ($vpais=='VE') {$ptit=' VENEZOLANAS';}

$tcon=0;
$tpag=0;
for($cont=$boletin;$cont<=$boletin2;$cont++)   {
// orden pub prensa
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and tipo_mp='M' and
              b.evento-1000 in (201) and
              b.documento='$cont'".$pquery2);
$registro=pg_fetch_array($resultado);	
$cant_con=$registro[0];
// orden pub prensa con pago 
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and tipo_mp='M' and
              b.evento-1000 in (201) and
              b.documento='$cont' and 
              a.nro_derecho in (select nro_derecho from stzevtrd where evento=1022)".$pquery2);
              
$registro=pg_fetch_array($resultado);	
$cant_pag=$registro[0];

if ($cont==$boletin) {
   $data1y=array($cant_con);
   $data2y=array($cant_pag);
   $datax=array($boletin); 
} else {
   array_push($data1y,$cant_con); 
   array_push($data2y,$cant_pag); 
   array_push($datax,$cont); 
}
$tcon=$tcon+$cant_con;
$tpag=$tpag+$cant_pag;

} //end for
$ppag=$tpag*100/$tcon;

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
$b1plot->SetFillColor('blue');
$b1plot->value->SetFormatCallback("cbFmtPercentage");
$b1plot->value->Show();
//$graph->Add($b1plot);
$b2plot->SetFillColor('red');
$b2plot->value->SetFormatCallback("cbFmtPercentage");
$b2plot->value->Show();
//$graph->Add($b2plot);

//Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot,$b2plot));
$graph->Add($gbplot);

// Setup the titles
if ($boletin2==$boletin) {
$graph->title->Set("RELACION DE MARCAS CON ORDEN PUB.PRENSA Y PAGADAS".$ptit." (Boletin ".$boletin.")\n \n "); 
} else {
$graph->title->Set("RELACION DE MARCAS CON ORDEN PUB.PRENSA Y PAGADAS".$ptit." (Boletines: ".$boletin."-".$boletin2.")\n \n ");
}
$graph->xaxis->title->Set("");
$graph->yaxis->title->Set("");
$graph->title->SetFont(FF_FONT2,FS_BOLD);
//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetFont(FF_FONT0,FS_BOLD);
$graph->xaxis->SetTickLabels($datax);

$b1plot->SetLegend("Pub.Prensa");
$b2plot->SetLegend("Pagadas   ");
$graph->legend->Pos(0.03,0.13,"right","center");
//$graph->xaxis->SetLabelFormatCallback('TimeCallback');

//Display the graph
//$graph->Stroke();
// Setup color for gradient fill style 
//$bplot->SetFillGradient("navy","lightsteelblue",GRAD_MIDVER);
// Set color for the frame of each bar
//$bplot->SetColor("navy");
//$graph->Add($bplot);

$t1 = new Text("Pub.Prensa: ".$tcon." (100%)    Pagadas: ".
               $tpag." (".cbFmtPercentage($ppag)."%)");
$t1->SetPos(0.3,0.1);
$t1->SetOrientation("h");
//$t1->SetFont(FF_FONT1,FS_BOLD);
$t1->SetBox("white","black","gray");
//$t1->SetColor("black");
$graph->AddText($t1);

$graph->Stroke("../cuadro.jpg"); 

?><div align="center"><table>
<tr><img src="../cuadro.jpg" border="0"></tr>
<tr><td class="cnt"><a href="m_est_rordpag.php?vopc=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td></tr></table><?php
$smarty->display('pie_pag.tpl');
}

if ($vopc==0) {
//Paso de asignacion de variables de encabezados
// Vector Paises
$obj_query = $sql->query("SELECT * FROM stzpaisr ORDER BY nombre");
$obj_filas = $sql->nums('',$obj_query);
$pai_val[0] = 'ZZ'; $pai_des[0] = '--- TODOS LOS PAISES        ';
$pai_val[1] = 'EX'; $pai_des[1] = '--- SOLO PAISES EXTRANJEROS ';
$objs = $sql->objects('',$obj_query);
for ($contobj=2;$contobj-2<$obj_filas;$contobj++) {
    $pai_val[$contobj] = $objs->pais;
    $pai_des[$contobj] = ltrim(rtrim($objs->nombre));
    $objs = $sql->objects('',$obj_query);
}
$smarty->assign('campo1','Desde Boletin:');
$smarty->assign('campo2','Hasta Boletin:');
$smarty->assign('campo3','C&oacute;digo Pais:');
$smarty->assign('pai_val',$pai_val); 
$smarty->assign('pai_des',$pai_des); 
$smarty->assign('varfocus','forestanu.bol'); 
$smarty->display('m_est_rordpag.tpl');
$smarty->display('pie_pag.tpl');
}

$sql->disconnect();
?>
