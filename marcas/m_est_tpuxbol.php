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
$smarty->assign('subtitulo','Estadisticas - Tipo Publicaci&oacute;n por Boletin');
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
$vindclas=$_POST["indclase"];
$vclas=$_POST["clase"];
$vpais=$_POST["pais"];
$vesta=$_POST["estatus"];
$vmoda=$_POST["modalidad"];
$vtipo=$_POST["tipomarca"];
$vopc=$_GET["vopc"];

if ($vopc==1) {
if ($vbol=='' or $vbol2=='' or $vbol>$vbol2 or $vpub==0) {
    $sql->disconnect();
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }
$dif=$vbol2-$vbol;
if ($dif>11) {
    $sql->disconnect(); 
    mensajenew('El rango no puede ser mayor a 11 boletines...!!!',
               'javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }
$ptit=''; $ve='VE';
if ($vpais=='ZZ' or $vpais=='') { $pquery2=''; }
else {
  if ($vpais=='EX') { 
      //$pquery2=" and pais_domicilio<>'".$ve."'"; 
      $pquery2=" and a.nro_derecho in (select nro_derecho from stzottid where pais_domicilio<>'VE')";
      $ptit=' EXTRANJERAS';} 
  else {
      //$pquery2=" and pais_domicilio='".$vpais."'"; 
      $pquery2=" and a.nro_derecho in (select nro_derecho from stzottid where pais_domicilio='".$vpais."')";
      $ptit=" DEL PAIS: ".$vpais;}
}
if ($vpais=='VE') {$ptit=' VENEZOLANAS';}

if ($vclas==99 or $vclas=='') { $pquery1=''; }
else {$pquery1=" and clase='".$vclas."'"; $ptit=$ptit.' EN CLASE:'.$vclas;}

if ($vindclas=='T' or $vindclas=='') { $pquery11=''; }
else {$pquery11=" and ind_claseni='".$vindclas."'"; $ptit=$ptit.' '.$vindclas;}

if ($vesta==' ') { $pquery3=''; }
else {$pquery3=" and estatus-1000='".$vesta."'"; $ptit=$ptit.' CON ESTATUS:'.$vesta;}

if ($vtipo=='T' or $vtipo=='') { $pquery4=''; }
else {$pquery4=" and tipo_derecho='".$vtipo."'"; 
      $ptit=$ptit.' TIPO:'.$vtipo;}

if ($vmoda=='T' or $vmoda=='T ' or $vmoda==' T' or $vmoda=='') { $pquery5=''; }
else {$pquery5=" and (position(modalidad in upper('".$vmoda."')) > 0)"; 
      $ptit=$ptit.' MODALIDAD:'.$vmoda;}

// Query 
$boletin=$vbol;
$cant_total=0;
$cant_bol=0;
for($cont=$boletin;$cont<=$vbol2;$cont++)   {
// Orden de publicacion
if ($vpub==2) { $vtit0=" ORDEN PUBLICACION";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento=1201 and estat_ant=1002 and tipo_mp='M' and
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Publicacion en Prensa Extemporanea
if ($vpub==23) { $vtit0=" PUB.PRENSA EXTEMPORANEA";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento=1123 and estat_ant=1023 and tipo_mp='M' and
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Publicacion en Prensa Defectuosa
if ($vpub==24) { $vtit0=" PUB.PRENSA DEFECTUOSA";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento=1123 and estat_ant=1024 and tipo_mp='M' and
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Perimidas por no Publicacion en Prensa
if ($vpub==30) { $vtit0=" PERIMIDAS NO PUB.PRENSA";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento=1980 and estat_ant=1030 and tipo_mp='M' and
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Solicitadas
if ($vpub==6) { $vtit0=" SOLICITADAS";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento-1000 in (42,93,121,124,888,927,983,990,997) and tipo_mp='M' and
              estat_ant-1000 in (3,110,111,125,6,88,1,191,888,954,500) and
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// concedidas
if ($vpub==101) { $vtit0=" CONCEDIDAS";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento-1000 in (122,181,182) and tipo_mp='M' and
              estat_ant-1000 in (101,390,399) and
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Devueltas por Forma
if ($vpub==200) { $vtit0=" DEVUELTAS FORMA";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento=1122 and estat_ant in (1200,1116) and tipo_mp='M' and 
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Devueltas por Fondo
if ($vpub==116) { $vtit0=" DEVUELTA FONDO";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho  and
              evento=1122 and estat_ant in (1116,1200) and tipo_mp='M' and 
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Observadas
if ($vpub==3) { $vtit0=" OBSERVADAS";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and 
              evento=1122 and estat_ant=1003 and tipo_mp='M' and 
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Prioridad Extinguida
if ($vpub==25) { $vtit0=" PRIOR. EXTINGUIDA";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento=1123 and estat_ant=1025 and tipo_mp='M' and 
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Caducas
if ($vpub==750) { $vtit0=" CADUCAS";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and tipo_mp='M' and 
              evento = 1125 and documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Desistidas
if ($vpub==910) { $vtit0=" DESISTIDAS";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento = 1123 and estat_ant=1910 and tipo_mp='M' and 
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
// Observadas Desistidas
if ($vpub==914) { $vtit0=" OBSERV. DESISTIDAS";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento = 1251 and estat_ant=1914 and tipo_mp='M' and 
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }

// Desistimiento de Observacion
if ($vpub==125) { $vtit0=" DESIST. OBSERVACION";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento=1121 and estat_ant=1125 and tipo_mp='M' and 
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }

// Desistimiento de Observacion Mejor Derecho
if ($vpub==125) { $vtit0=" DESIST. OBSERV. MEJOR DERECHO";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and
              evento=1121 and estat_ant=1130 and tipo_mp='M' and 
              documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }

// Negadas
if ($vpub==102) { $vtit0=" NEGADAS";
$resultado=pg_exec("SELECT count(*) FROM stmmarce a, stzevtrd b, stzderec c
	WHERE c.nro_derecho=a.nro_derecho and c.nro_derecho=b.nro_derecho and tipo_mp='M' and 
              evento = 1062 and documento='$cont'".
              $pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5); }
$registro=pg_fetch_array($resultado);
$cant_reg=$registro[0]; 

if ($cont==$boletin) {
   $datay=array($cant_reg);
   $datax=array($boletin); 
   $cant_total=$cant_reg;
   $cant_bol=1;
} else {
   array_push($datay,$cant_reg); 
   array_push($datax,$cont); 
   $cant_total=$cant_total+$cant_reg;
   $cant_bol=$cant_bol+1; }
} // end for
$promedio=$cant_total/$cant_bol;

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
$graph->title->Set("MARCAS".$vtit0.$ptit."\n \n ");
$graph->xaxis->title->Set("");
$graph->yaxis->title->Set("");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetFont(FF_FONT0,FS_BOLD);
$graph->xaxis->SetTickLabels($datax);

if ($cant_bol>1) {
 $t1 = new Text("Total: ".$cant_total."    Promedio: ".cbFmtPercentage($promedio));
 $t1->SetPos(0.35,0.1);
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
<tr><td class="cnt"><a href="m_est_tpuxbol.php?vopc=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td></tr></table><?php
$smarty->display('pie_pag.tpl'); 
}

if ($vopc==0) {
$vtipest=array(0,2,23,24,30,6,101,200,116,3,25,750,910,914,125,130,102);
$vtipsol=array("--- Seleccione el tipo de publicacion...","Orden Publicacion","Publicacion en Prensa Extemporanea","Publicacion en Prensa Defectuosa","Perimidas por NO Public. en Prensa","Solicitadas","Concedidas","Devueltas","Devueltas Fondo","Observadas","Prioridad Extinguida","Caducas","Desistidas","Desistimiento a Observadas de Oficio","Desistimiento de Observaciones","Desistim. Observacion Mejor Derecho","Negadas");
$ind_val=array('T','N','I');
$ind_des=array('--- TODOS LOS INDICADORES','En Clase Nacional','En Clase Internacional');
$tip_val=array('T','M','N','S','L','C','D');
$tip_des=array('--- TODOS LOS TIPOS DE MARCAS','Marcas de Productos','Nombres Comerciales','Marcas de Servicios','Lemas Comerciales','Marcas Colectivas','Denominaciones de Origen');
$mod_val=array('T','D','G','M','DM','GM');
$mod_des=array('--- TODAS LAS MODALIDADES','Solo Denominativas','Solo Graficas','Solo Mixtas','Denominativas y Mixtas','Graficas y Mixtas');
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
$obj_query = $sql->query("SELECT * FROM stzstder WHERE tipo_mp='M' ORDER BY estatus");
$obj_filas = $sql->nums('',$obj_query);
$est_val[0] = ' '; $est_des[0] = '--- TODOS LOS ESTATUS ';
$objs = $sql->objects('',$obj_query);
for ($contobj=1;$contobj-1<$obj_filas;$contobj++) {
    $est_val[$contobj] = $objs->estatus-1000;
    $est_des[$contobj] = substr($objs->estatus,1,3).'-'.substr(ltrim(rtrim($objs->descripcion)),0,40);
    $objs = $sql->objects('',$obj_query);
}
// Vector Clases
$cla_val[0] = 99; $cla_des[0] = '--- TODAS LAS CLASES';
for ($contobj=1;$contobj-1<50;$contobj++) {
    $cla_val[$contobj] = $contobj; $cla_des[$contobj] = $contobj.'- CLASE '.$contobj;
}

//Paso de asignacion de variables de encabezados
$smarty->assign('campo','Desde Boletin:');
$smarty->assign('campo0','Hasta Boletin:');
$smarty->assign('campo1','A&ntilde;o:');
$smarty->assign('campo2','Clase:');
$smarty->assign('campo3','C&oacute;digo Pais:');
$smarty->assign('campo4','Estatus Actual:');
$smarty->assign('campo5','Tipo de Marca:');
$smarty->assign('campo6','Modalidad:');
$smarty->assign('campo7','Indicador Clase:');
$smarty->assign('vtipsol',$vtipsol); 
$smarty->assign('vtipest',$vtipest); 
$smarty->assign('ind_val',$ind_val); 
$smarty->assign('ind_des',$ind_des);
$smarty->assign('tip_val',$tip_val); 
$smarty->assign('tip_des',$tip_des);  
$smarty->assign('mod_val',$mod_val); 
$smarty->assign('mod_des',$mod_des); 
$smarty->assign('pai_val',$pai_val); 
$smarty->assign('pai_des',$pai_des); 
$smarty->assign('est_val',$est_val); 
$smarty->assign('est_des',$est_des); 
$smarty->assign('cla_val',$cla_val); 
$smarty->assign('cla_des',$cla_des); 
$smarty->assign('ltipo','Tipo de Solicitudes:'); 
$smarty->assign('varfocus','forestanu.bol'); 
$smarty->display('m_est_tpuxbol.tpl');
$smarty->display('pie_pag.tpl');
}

$sql->disconnect();
?>
