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
$smarty->assign('subtitulo','Estadisticas - Registradas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Recibiendo campos de Entrada
$vano1=$_POST["ano1"];
$vano2=$_POST["ano2"];
$vindclas=$_POST["indclase"];
$vclas=$_POST["clase"];
$vpais=$_POST["pais"];
$vesta=$_POST["estatus"];
$vmoda=$_POST["modalidad"];
$vtipo=$_POST["tipomarca"];
$vopc=$_GET["vopc"];

if ($vopc==1) {
if (($vano1=='' and $vano2!='') or ($vano2=='' and $vano1!='') or $vano1>$vano2) {
    $sql->disconnect(); 
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }

$dif=$vano2-$vano1;
if ($dif>20) {
    $sql->disconnect(); 
    mensajenew('El rango no puede ser mayor a 20 a&ntilde;os...!!!',
               'javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }

$ptit=''; $ve='VE';
if ($vpais=='ZZ' or $vpais=='') { $pquery2=''; }
else {if ($vpais=='EX') { 
          $pquery2=" and a.nro_derecho in (select distinct nro_derecho from stzottid where pais_domicilio<>'VE')";  
          $ptit=' EXTRANJERAS';} 
      else {
          $pquery2=" and a.nro_derecho in (select distinct nro_derecho from stzottid where pais_domicilio='".$vpais."')"; 
          $ptit=" DEL PAIS: ".$vpais;}
}
if ($vpais=='VE') {$ptit=' VENEZOLANAS';}

if ($vclas==99 or $vclas=='') { $pquery1=''; }
else {$pquery1=" and clase='".$vclas."'"; $ptit=$ptit.' EN CLASE:'.$vclas;}

if ($vindclas=='T' or $vindclas=='') { $pquery11=''; }
else {$pquery11=" and ind_claseni='".$vindclas."'"; $ptit=$ptit.' '.$vindclas;}

if ($vesta==' ' or $vesta=='') { $pquery3=''; }
else {$pquery3=" and estatus-1000='".$vesta."'"; $ptit=$ptit.' CON ESTATUS:'.$vesta;}

if ($vtipo=='T' or $vtipo=='') { $pquery4=''; }
else {$pquery4=" and tipo_derecho='".$vtipo."'"; 
      $ptit=$ptit.' TIPO:'.$vtipo;}

if ($vmoda=='T' or $vmoda=='T ' or $vmoda==' T' or $vmoda=='') { $pquery5=''; }
else {$pquery5=" and (position(modalidad in upper('".$vmoda."')) > 0)"; 
      $ptit=$ptit.' MODALIDAD:'.$vmoda;}

// Query 
if ($vano1=='' and $vano2=='') {
    $pquery0='';
} else {
    $pquery0=" and EXTRACT(YEAR FROM fecha_trans) between '$vano1' and '$vano2'";}

   $resultadosum=pg_exec("select count(*) from stzderec a, stzevtrd c
   where tipo_mp='M' and a.nro_derecho=c.nro_derecho 
         and evento=1795 ".$pquery0.$pquery1.$pquery11.$pquery2.$pquery3.$pquery4.
  $pquery5);

$registrosum=pg_fetch_array($resultadosum);	
$cant_total=$registrosum[0];
$promedio=$cant_total/12;

// Funcion de Graficado
if ($vano1==$vano2 and $vano1!='') {
   $resultado=pg_exec("select EXTRACT(MONTH FROM fecha_trans) as mes, count(*) as cant 
            from stzderec a, stzevtrd c
           where tipo_mp='M' and a.nro_derecho=c.nro_derecho
                 and evento=1795".$pquery0.$pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5.
          " group by 1 order by 1");
   $registro=pg_fetch_array($resultado);	
   $cantidad=pg_numrows($resultado);
   $datay=array("1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,
             "7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0,"12"=>0);	
   for($cont=0;$cont<$cantidad;$cont++)   {
      $datay["$registro[mes]"]=$registro[cant];
      $registro=pg_fetch_array($resultado); }
   $datay = array_slice ($datay,0,12); 
   $datax=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO",
             "JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
} else {
  if ($vano1<>$vano2) {
  for($cont=$vano1;$cont<=$vano2;$cont++)   {
   $resultado=pg_exec("select count(*) as cant from stzderec a, stzevtrd c
           where EXTRACT(YEAR FROM fecha_trans)= '$cont' and 
                 tipo_mp='M' and a.nro_derecho=c.nro_derecho 
                 and evento=1795 ".$pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5);
   $registro=pg_fetch_array($resultado);
   $cant_reg=$registro[0]; 
   if ($cont==$vano1) {
      $datay=array($cant_reg);
      $datax=array($vano1); 
      $cant_total=$cant_reg;
      $cant_bol=1;
   } else {
     array_push($datay,$cant_reg); 
     array_push($datax,$cont); 
     $cant_total=$cant_total+$cant_reg;
     $cant_bol=$cant_bol+1;
     $promedio=$cant_total/$cant_bol; }
  }
  } else { 
    $resultado=pg_exec("select count(*) as cant from stzderec a, stzevtrd c
           where tipo_mp='M' and a.nro_derecho=c.nro_derecho 
   and evento=1795".$pquery0.$pquery1.$pquery11.$pquery2.$pquery3.$pquery4.$pquery5);
   $registro=pg_fetch_array($resultado);
   $cant_reg=$registro[0];    
   $datay=array($cant_reg);
   $datax=array("SOLICITUDES");
  } 
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
if ($vano1==$vano2 and $vano1!='') {$graph->title->Set("MARCAS REGISTRADAS EN EL ANO ".$vano1.$ptit."\n \n ");}
if ($vano1==$vano2 and $vano1=='') {$graph->title->Set("MARCAS REGISTRADAS ".$ptit."\n \n ");}
if ($vano1<>$vano2) {$graph->title->Set("MARCAS REGISTRADAS POR ANO ".$ptit."\n \n ");}
$graph->xaxis->title->Set("");
$graph->yaxis->title->Set("");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetFont(FF_FONT0,FS_BOLD);
$graph->xaxis->SetTickLabels($datax);

if ($vano1==$vano2 and $vano1!='') {
 $t1 = new Text("Total Anual: ".$cant_total."   Promedio Mensual: ".cbFmtPercentage($promedio));
} 
if ($vano1<>$vano2) {
 $t1 = new Text("Total Periodo: ".$cant_total."   Promedio Anual: ".cbFmtPercentage($promedio));
}
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
<tr><td class="cnt"><a href="m_est_regxmes.php?vopc=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td></tr></table><?php
$smarty->display('pie_pag.tpl'); 
}

if ($vopc==0) {
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
$smarty->assign('campo0','Desde el A&ntilde;o:');
$smarty->assign('campo1','Hasta el A&ntilde;o:');
$smarty->assign('campo2','Clase:');
$smarty->assign('campo3','C&oacute;digo Pais:');
$smarty->assign('campo4','Estatus Actual:');
$smarty->assign('campo5','Tipo de Marca:');
$smarty->assign('campo6','Modalidad:');
$smarty->assign('campo7','Indicador Clase:');
$smarty->assign('varfocus','forestanu.ano1'); 
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
$smarty->display('m_est_regxmes.tpl');
$smarty->display('pie_pag.tpl');
}

$sql->disconnect();
?>
