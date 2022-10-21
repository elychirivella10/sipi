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
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Estad&iacute;sticas - Por Estatus');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Recibiendo campos de Entrada
$vpub=$_POST["v2"];
$vbol=$_POST["bol"];
$vbol2=$_POST["bol2"];
$vclas=$_POST["clase"];
$vpais=$_POST["pais"];
$vesta=$_POST["estatus"];

$vopc=$_GET["vopc"];

if ($vopc==1) {

$ptit=''; $ve='VE'; $ptabla='';
if ($vpais=='ZZ' or $vpais=='') { $pquery2=''; }
else {if ($vpais=='EX') { 
          //$pquery2=" and pais_resid<>'".$ve."'"; 
          $pquery2=" and stzderec.nro_derecho in (select distinct nro_derecho from stzottid where pais_domicilio<>'VE')";
          $ptit=' EXTRANJERAS';} 
      else {
          //$pquery2=" and pais_resid='".$vpais."'"; 
          $pquery2=" and stzderec.nro_derecho in (select distinct nro_derecho from stzottid where pais_domicilio='".$vpais."')";
          $ptit=" DEL PAIS: ".$vpais;}
}
if ($vpais=='VE') {$ptit=' VENEZOLANAS';}

if ($vclas=='') { $pquery1=''; }
else {$pquery1=" and a.nro_derecho=b.nro_derecho and clasificacion like '".$vclas."%'"; 
      $ptit=$ptit.' CON CLASIFICACION:'.$vclas;
      $ptabla=' a, stpclsfd b ';}

if ($vesta==' ' or $vesta=='') { $pquery3='';}
else {$pquery3=" and estatus-2000='".$vesta."'"; $ptit=$ptit.' EN ESTATUS:'.$vesta;}

// Query 
$cant_rega=0; $cant_regc=0; $cant_rege=0;
$cant_regg=0; $cant_regb=0; $cant_regd=0;
$cant_regf=0; $cant_regv=0;

$resultado=pg_exec("SELECT tipo_derecho,count(*) as total FROM stzderec".$ptabla." 
	WHERE tipo_mp='P'".$pquery1.$pquery2.$pquery3." group by 1"); 

$registro=pg_fetch_array($resultado);
$cant_fil=pg_numrows($resultado);
for ($cant=0;$cant<$cant_fil;$cant++) {
    if ($registro[tipo_derecho]=='A') {$cant_rega=$registro[total];}
    if ($registro[tipo_derecho]=='C') {$cant_regc=$registro[total];}
    if ($registro[tipo_derecho]=='E') {$cant_rege=$registro[total];}
    if ($registro[tipo_derecho]=='G') {$cant_regg=$registro[total];}
    if ($registro[tipo_derecho]=='B') {$cant_regb=$registro[total];}
    if ($registro[tipo_derecho]=='D') {$cant_regd=$registro[total];}
    if ($registro[tipo_derecho]=='F') {$cant_regf=$registro[total];}
    if ($registro[tipo_derecho]=='V') {$cant_regv=$registro[total];}

    $registro=pg_fetch_array($resultado);
}

$cant_total=$cant_rega+$cant_regc+$cant_rege+$cant_regg+$cant_regb+$cant_regd+
            $cant_regf+$cant_regv;
$datay=array($cant_rega,$cant_regc,$cant_rege,$cant_regg,$cant_regb,$cant_regd,
             $cant_regf,$cant_regv); 
$datax=array('INVENCION','MEJORA','MODELO INDUST.','DISENO INDUST.','DIBUJO INDUST.','INTRODUCCION','MODELO UTILIDAD','VAR.VEGETALES'); 

// Funcion de Graficado
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
$graph->title->Set("PATENTES".$vtit0.$ptit."\n \n ");
$graph->xaxis->title->Set("");
$graph->yaxis->title->Set("");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetFont(FF_FONT0,FS_BOLD);
$graph->xaxis->SetTickLabels($datax);

//$bplot->SetLegend("Result");
//$graph->xaxis->SetLabelFormatCallback('TimeCallback');

//Display the graph
//$graph->Stroke();
// Setup color for gradient fill style 
$tcol=array(100,100,255);
$fcol=array(255,100,100);
$bplot->SetFillGradient($fcol,$tcol,GRAD_HOR);
$graph->Add($bplot);

//$line = new LinePlot($datay);
//$line->SetBarCenter();
//$line->SetWeight(2);
//$graph->Add($line);

$t1 = new Text("Total: ".$cant_total);
$t1->SetPos(0.43,0.1);
$t1->SetOrientation("h");
$t1->SetFont(FF_FONT1,FS_BOLD);
$t1->SetBox("white","blue","gray");
$t1->SetColor("black"); 
$graph->AddText($t1); 

$name="cuadro"; 
$graph->Stroke("../$name.jpg"); 

?><div align="center"><table>
<tr><img src="../cuadro.jpg" border="0"></tr>
<tr><td class="cnt"><a href="p_est_estatus.php?vopc=0"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td></tr></table><?php
$smarty->display('pie_pag.tpl'); 
}

if ($vopc==0) {
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
// Vector Estatus
$obj_query = $sql->query("SELECT * FROM stzstder WHERE tipo_mp='P' ORDER BY estatus");
$obj_filas = $sql->nums('',$obj_query);
$est_val[0] = ' '; $est_des[0] = '--- TODOS LOS ESTATUS ';
$objs = $sql->objects('',$obj_query);
for ($contobj=1;$contobj-1<$obj_filas;$contobj++) {
    $est_val[$contobj] = $objs->estatus-2000;
    $est_des[$contobj] = substr($objs->estatus,1,3).'-'.substr(ltrim(rtrim($objs->descripcion)),0,40);
    $objs = $sql->objects('',$obj_query);
}

//Paso de asignacion de variables de encabezados
$smarty->assign('pai_val',$pai_val); 
$smarty->assign('pai_des',$pai_des); 
$smarty->assign('est_val',$est_val); 
$smarty->assign('est_des',$est_des); 
$smarty->assign('campo2','Clasificaci&oacute;n:');
$smarty->assign('campo3','C&oacute;digo Pais:');
$smarty->assign('campo4','Estatus Actual:');
$smarty->assign('varfocus','forestanu.estatus'); 
$smarty->display('p_est_estatus.tpl');
$smarty->display('pie_pag.tpl');
}

$sql->disconnect();
?>
