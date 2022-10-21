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
$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Estadisticas - Usuarios');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Recibiendo campos de Entrada
$vano1=$_POST["ano1"];
$vano2=$_POST["ano2"];
$vusua=$_POST["usuario"];
$veven=$_POST["evento"];
$vopc=$_GET["vopc"];

if ($vopc==1) {
if (($vano1=='') or ($vano2=='') or $vano1>$vano2) {
    $sql->disconnect(); 
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }

$ptit='';
if ($vusua=='ZZ' or $vusua=='') { $pquery2=''; }
else {$pquery2=" and usuario='".$vusua."'"; $ptit=" - USUARIO: ".$vusua;}

if ($veven==' ' or $veven=='') { $pquery3=''; }
else {$pquery3=" and evento-2000='".$veven."'"; $ptit=$ptit.' - EVENTO:'.$veven;}

// Query 
if ($vano1=='' and $vano2=='') {
    $pquery0='evento>2000';
} else {
    $pquery0=" evento>2000 and fecha_trans between '$vano1' and '$vano2'";}

   $resultadosum=pg_exec("select count(*) from stzevtrd where ".$pquery0.$pquery2.$pquery3);

$registrosum=pg_fetch_array($resultadosum);	
$cant_total=$registrosum[0];
$promedio=$cant_total/12;

// Funcion de Graficado
if ($vano1!='') {
   $resultado=pg_exec("select evento-2000 as evento, count(*) as cant 
            from stzevtrd where ".$pquery0.$pquery2.$pquery3.
           " group by 1 order by 1");
   $registro=pg_fetch_array($resultado);	
   $cantidad=pg_numrows($resultado);
   //$datay=array("1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,
   //          "7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0,"12"=>0);	
   $datay=array(); 
   $datax=array(); 
   for($cont=0;$cont<$cantidad;$cont++)   {
      array_push($datay,$registro[cant]);
      array_push($datax,$registro[evento]);
      $registro=pg_fetch_array($resultado); }
   //$datay = array_slice ($datay,0,12); 
   //$datax=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO",
   //          "JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
}
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
$bplot = new BarPlot($datay);

// Adjust fill color
$bplot->SetFillColor('blue');
$bplot->value->SetFormatCallback("cbFmtPercentage");
$bplot->value->Show();
$graph->Add($bplot);

// Setup the titles
$graph->title->Set("TRANSACCIONES Desde:".$vano1." Hasta:".$vano2.$ptit."\n \n ");
$graph->xaxis->title->Set("");
$graph->yaxis->title->Set("");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetFont(FF_FONT0,FS_BOLD);
$graph->xaxis->SetTickLabels($datax);

$t1 = new Text("Total Eventos Cargados: ".$cant_total);

if (($vano1==$vano2 and $vano1!='') or ($vano1<>$vano2)) {
   $t1->SetPos(0.3,0.1);
   $t1->SetOrientation("h");
   $t1->SetFont(FF_FONT1,FS_BOLD);
   $t1->SetBox("white","blue","gray");
   $t1->SetColor("black");
   $graph->AddText($t1);
}

//$bplot->SetLegend("Result");
//$graph->xaxis->SetLabelFormatCallback('TimeCallback');

//Display the graph
//$graph->Stroke();
// Setup color for gradient fill style 
$tcol=array(100,100,255);
$fcol=array(255,100,100);
$bplot->SetFillGradient($fcol,$tcol,GRAD_HOR);
$graph->Add($bplot);

$line = new LinePlot($datay);
$line->SetBarCenter();
$line->SetWeight(2);
$graph->Add($line);

$name="cuadro"; 
$graph->Stroke("../$name.jpg"); 

?><div align="center"><table>
<tr><img src="../cuadro.jpg" border="0"></tr>
<tr><td class="cnt"><a href="p_est_usuxmes.php?vopc=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td></tr></table><?php
$smarty->display('pie_pag.tpl'); 
}

if ($vopc==0) {
// Vector Usuarios
$obj_query = $sql->query("SELECT * FROM stzusuar WHERE estatus='1' ORDER BY nombre");
$obj_filas = $sql->nums('',$obj_query);
$pai_val[0] = 'ZZ'; $pai_des[0] = '--- TODOS LOS USUARIOS        ';
$objs = $sql->objects('',$obj_query);
for ($contobj=1;$contobj-1<$obj_filas;$contobj++) {
    $pai_val[$contobj] = $objs->usuario;
    $pai_des[$contobj] = ltrim(rtrim($objs->nombre));
    $objs = $sql->objects('',$obj_query);
}
// Vector Eventos
$obj_query = $sql->query("SELECT * FROM stzevder WHERE tipo_mp='P' ORDER BY evento");
$obj_filas = $sql->nums('',$obj_query);
$est_val[0] = ' '; $est_des[0] = '--- TODOS LOS EVENTOS ';
$objs = $sql->objects('',$obj_query);
for ($contobj=1;$contobj-1<$obj_filas;$contobj++) {
    $est_val[$contobj] = $objs->evento-2000;
    $est_des[$contobj] = substr($objs->evento,1,3).'-'.substr(ltrim(rtrim($objs->descripcion)),0,40);
    $objs = $sql->objects('',$obj_query);
}

//Paso de asignacion de variables de encabezados
$smarty->assign('campo0','Desde la Fecha:');
$smarty->assign('campo1','Hasta la Fecha:');
$smarty->assign('campo3','Usuario:');
$smarty->assign('campo4','Evento:');
$smarty->assign('varfocus','forestanu.ano1'); 
$smarty->assign('pai_val',$pai_val); 
$smarty->assign('pai_des',$pai_des); 
$smarty->assign('est_val',$est_val); 
$smarty->assign('est_des',$est_des); 
$smarty->display('p_est_usuxmes.tpl');
$smarty->display('pie_pag.tpl');
}

$sql->disconnect();
?>
