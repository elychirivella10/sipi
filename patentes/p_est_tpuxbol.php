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
$smarty->assign('subtitulo','Estad&iacute;sticas - Tipo Publicaci&oacute;n por Bolet&iacute;n');
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
$vtipo=$_POST["tipomarca"];
$vopc=$_GET["vopc"];

if ($vopc==1) {
if ($vbol=='' or $vbol2=='' or $vbol>$vbol2 or $vpub==0) {
    $sql->disconnect();
    mensajenew('ERROR: DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }
$dif=$vbol2-$vbol;
//if ($dif>15) {
//    $sql->disconnect(); 
//    mensajenew('El rango no puede ser mayor a 15 boletines...!!!',
//               'javascript:history.back();','N');    
//    $smarty->display('pie_pag.tpl'); exit(); }

$ptit=''; $ve='VE'; $ptabla='';
if ($vpais=='ZZ' or $vpais=='') { $pquery2=''; }
else {if ($vpais=='EX') { 
          //$pquery2=" and pais_resid<>'".$ve."'"; 
          $pquery2=" and a.nro_derecho in (select distinct nro_derecho from stzottid where pais_domicilio<>'VE')";
          $ptit=' EXTRANJERAS';} 
      else {
          //$pquery2=" and pais_resid='".$vpais."'"; 
          $pquery2=" and a.nro_derecho in (select distinct nro_derecho from stzottid where pais_domicilio='".$vpais."')";
          $ptit=" DEL PAIS: ".$vpais;}
}
if ($vpais=='VE') {$ptit=' VENEZOLANAS';}

if ($vclas=='') { $pquery1=''; }
else {$pquery1=" and a.nro_derecho=c.nro_derecho and clasificacion like '".$vclas."%'"; 
      $ptit=$ptit.' CON CLASIFICACION:'.$vclas;
      $ptabla=', stpclsfd c ';}

if ($vesta==' ') { $pquery3=''; }
else {$pquery3=" and estatus-2000='".$vesta."'"; $ptit=$ptit.' EN ESTATUS:'.$vesta;}

if ($vtipo=='T' or $vtipo=='') { $pquery4=''; }
else {$pquery4=" and tipo_derecho='".$vtipo."'"; 
      $ptit=$ptit.' TIPO:'.$vtipo;}

// Query 
$boletin=$vbol;
$cant_total=0;
$cant_bol=0;
for($cont=$boletin;$cont<=$vbol2;$cont++)   {
// Orden de publicacion
if ($vpub==2) { $vtit0=" ORDEN PUBLICACION";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla."
              WHERE a.nro_derecho=b.nro_derecho and 
              evento=2201 and estat_ant=2002 and tipo_mp='P' and
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Publicacion en Prensa Extemporanea
if ($vpub==23) { $vtit0=" PUB.PRENSA EXTEMPORANEA";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla."
              WHERE a.nro_derecho=b.nro_derecho and 
              evento=2123 and estat_ant=2023 and tipo_mp='P' and
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Publicacion en Prensa Defectuosa
if ($vpub==24) { $vtit0=" PUB.PRENSA DEFECTUOSA";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla."
              WHERE a.nro_derecho=b.nro_derecho and
              evento=2123 and estat_ant=2024 and tipo_mp='P' and
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Perimidas por no Publicacion en Prensa
if ($vpub==30) { $vtit0=" PERIMIDAS NO PUB.PRENSA";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla."
              WHERE a.nro_derecho=b.nro_derecho and
              evento=2980 and estat_ant=2030 and tipo_mp='P' and
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Solicitadas
if ($vpub==6) { $vtit0=" SOLICITADAS";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla."
              WHERE a.nro_derecho=b.nro_derecho and
              tipo_mp='P' and evento-2000 in (93,124,922) and
              estat_ant-2000 in (110,111,1,191,6,118) and
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// concedidas
if ($vpub==101) { $vtit0=" CONCEDIDAS";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla."
              WHERE a.nro_derecho=b.nro_derecho and
              tipo_mp='P' and evento-2000 in (122,930) and
              estat_ant-2000 in (101,1,191,8) and
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Devueltas por Forma
if ($vpub==200) { $vtit0=" DEVUELTAS FORMA";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla."
              WHERE a.nro_derecho=b.nro_derecho and
              tipo_mp='P' and evento in (2120,2122,2920) and 
              estat_ant in (2200,2001,2191) and 
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Devueltas por Fondo
if ($vpub==103) { $vtit0=" DEVUELTA FONDO";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla."
              WHERE a.nro_derecho=b.nro_derecho and
              tipo_mp='P' and evento-2000 in (93,121,126,921) and 
              estat_ant-2000 in (112,103,1,191,8) and 
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Prioridad Extinguida
if ($vpub==25) { $vtit0=" PRIOR. EXTINGUIDA";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla."
              WHERE a.nro_derecho=b.nro_derecho and
              tipo_mp='P' and evento-2000 in (123,929) and 
              estat_ant-2000 in (25,950,1,191,8,118) and 
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Desistidas
if ($vpub==910) { $vtit0=" DESISTIDAS";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla." 
              WHERE a.nro_derecho=b.nro_derecho and
              tipo_mp='P' and evento-2000 in (125,950) and 
              estat_ant-2000 in (910,1,191,8,555,400) and 
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Anuladas
if ($vpub==750) { $vtit0=" ANULADAS";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla." 
              WHERE a.nro_derecho=b.nro_derecho and
              tipo_mp='P' and 
              evento-2000 in (122,931) and 
              estat_ant-2000 in(750,8,1,191,400) and 
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Abandonadas
if ($vpub==90) { $vtit0=" ABANDONADAS";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla." 
              WHERE a.nro_derecho=b.nro_derecho and 
              tipo_mp='P' and evento = 2122 and estat_ant = 2090 and 
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Negadas
if ($vpub==102) { $vtit0=" NEGADAS";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla." 
              WHERE a.nro_derecho=b.nro_derecho and 
              tipo_mp='P' and evento = 2123 and estat_ant = 2102 and 
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Sin Efecto por Vencimiento del termino
if ($vpub==920) { $vtit0=" SIN EFECTO (VENCIMIENTO)";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla." 
              WHERE a.nro_derecho=b.nro_derecho and 
              tipo_mp='P' and evento = 2123 and estat_ant = 2918 and 
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
// Sin Efecto por falta de pago de anualidades
if ($vpub==919) { $vtit0=" SIN EFECTO (PAGO ANUAL)";
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b".$ptabla." 
              WHERE a.nro_derecho=b.nro_derecho and 
              tipo_mp='P' and evento = 2123 and estat_ant = 2917 and 
              documento='$cont'".
              $pquery1.$pquery2.$pquery3.$pquery4); }
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
$graph->title->Set("PATENTES".$vtit0.$ptit."\n \n ");
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
<tr><td class="cnt"><a href="p_est_tpuxbol.php?vopc=0"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td></tr></table><?php
$smarty->display('pie_pag.tpl'); 
}

if ($vopc==0) {
$vtipest=array(0,2,23,24,30,6,101,200,103,25,910,750,90,102,920,919);
$vtipsol=array("--- Seleccione el tipo de publicacion...","Orden Publicacion","Publicacion en Prensa Extemporanea","Publicacion en Prensa Defectuosa","Perimidas por NO Public. en Prensa","Solicitadas","Concedidas","Devueltas por Forma","Devueltas por Fondo","Prioridad Extinguida","Desistidas","Anuladas","Abandonadas","Negadas","Sin Efecto (Vencimiento Termino)","Sin Efecto (No Pago Anual)");
//$ind_val=array('T','N','I');
//$ind_des=array('--- TODOS LOS INDICADORES','En Clase Nacional','En Clase Internacional');
$tip_val=array('T','A','C','E','G','B','D','F','V');
$tip_des=array('--- TODOS LOS TIPOS DE PATENTES','INVENCION','MEJORA','MODELO INDUSTRIAL','DISEÑO INDUSTRIAL','DIBUJO INDUSTRIAL','INTRODUCCION','MODELO DE UTILIDAD','VARIEDADES VEGETALES');
//$mod_val=array('T','D','G','M','DM','GM');
//$mod_des=array('--- TODAS LAS MODALIDADES','Solo Denominativas','Solo Graficas','Solo Mixtas','Denominativas y Mixtas','Graficas y Mixtas');
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
// Vector Clases
//$cla_val[0] = 99; $cla_des[0] = '--- TODAS LAS CLASES';
//for ($contobj=1;$contobj-1<50;$contobj++) {
//    $cla_val[$contobj] = $contobj; $cla_des[$contobj] = $contobj.'- CLASE '.$contobj;
//}

//Paso de asignacion de variables de encabezados
$smarty->assign('campo','Desde Boletin:');
$smarty->assign('campo0','Hasta Boletin:');
$smarty->assign('campo2','Clasificaci&oacute;n:');
$smarty->assign('campo3','C&oacute;digo Pais:');
$smarty->assign('campo4','Estatus Actual:');
$smarty->assign('campo5','Tipo de Patente:');
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
$smarty->display('p_est_tpuxbol.tpl');
$smarty->display('pie_pag.tpl');
}

$sql->disconnect();
?>
