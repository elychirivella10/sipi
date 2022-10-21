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
$smarty->assign('subtitulo','Estad&iacute;sticas - Publicaciones por Bolet&iacute;n');
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
if ($boletin=='') {
    $sql->disconnect();
    mensajenew('ERROR: DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }
if ($boletin2=='') {$boletin2=$boletin;}
if ($boletin>$boletin2) {
    $sql->disconnect();
    mensajenew('ERROR: EL RANGO DE BOLETINES ES INCORRECTO...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }
$dif=$boletin2-$boletin;
if ($dif>15) {
    $sql->disconnect(); 
    mensajenew('ERROR: El rango no puede ser mayor a 15 boletines...!!!',
               'javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); exit(); }

$ptit=''; $ve='VE';
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

// Orden publicacion
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and
              b.evento=2201 and b.estat_ant=2002 and a.tipo_mp='P' and
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);	
$cant_ord=$registro[0];

// Publicacion en Prensa Extemporanea
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and
              evento=2123 and estat_ant=2023 and tipo_mp='P' and
              documento between '$boletin' and '$boletin2'".$pquery2); 
$registro=pg_fetch_array($resultado);	
$cant_ppe=$registro[0];

// Publicacion en Prensa Defectuosa
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and
              evento=2123 and estat_ant=2024 and tipo_mp='P' and
              documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);	
$cant_ppd=$registro[0];
 
// Perimidas por no Publicacion en Prensa
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and
              evento=2980 and estat_ant=2030 and tipo_mp='P' and
              documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);	
$cant_npp=$registro[0];
 
// Solicitadas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and
              b.evento-2000 in (93,124,922) and
              b.estat_ant-2000 in (110,111,1,191,6,118) and
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);	
$cant_sol=$registro[0];

// concedidas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and
              b.evento-2000 in (122,930) and
              b.estat_ant-2000 in (101,1,191,8) and
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);	
$cant_con=$registro[0];

// Devueltas por Forma
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and
              b.evento in (2120,2122,2920) and b.estat_ant in (2200,2001,2191) and 
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);
$cant_devfor=$registro[0];

// Devueltas por Fondo
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and
              b.evento-2000 in (93,121,126,921) and 
              b.estat_ant-2000 in (112,103,1,191,8) and 
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);
$cant_devfon=$registro[0];

// Prioridad Extinguida
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and
              b.evento-2000 in (123,929) and 
              b.estat_ant-2000 in (25,950,1,191,8,118) and 
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);
$cant_pex=$registro[0];

// Desistidas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and 
              b.evento-2000 in (125,950) and 
              b.estat_ant-2000 in (910,1,191,8,555,400) and 
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);
$cant_des=$registro[0];

// Anuladas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and 
              b.evento-2000 in (122,931) and 
              b.estat_ant-2000 in(750,8,1,191,400) and 
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);
$cant_anu=$registro[0];

// Abandonadas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and 
              b.evento = 2122 and b.estat_ant = 2090 and 
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);
$cant_aba=$registro[0];

// Negadas
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and 
              b.evento = 2123 and b.estat_ant = 2102 and 
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);
$cant_neg=$registro[0];

// Sin Efecto por vencimiento del termino (920)
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and 
              b.evento = 2123 and b.estat_ant = 2918 and 
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);
$cant_sev=$registro[0];

// Sin Efecto por falta de pago de anualidades (919)
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and 
              b.evento = 2123 and b.estat_ant = 2917 and 
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);
$cant_sea=$registro[0];

// Oposiciones (010)
$resultado=pg_exec("SELECT count(*) FROM stzderec a, stzevtrd b
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='P' and 
              b.evento = 2126 and b.estat_ant = 2009 and 
              b.documento between '$boletin' and '$boletin2'".$pquery2);
$registro=pg_fetch_array($resultado);
$cant_opo=$registro[0];

$datay=array(' '); $datax=array(' '); 
if($cant_ord>0)      {array_push($datay,$cant_ord);      array_push($datax,"ORDEN PUB");}
if($cant_ppe>0)      {array_push($datay,$cant_ppe);      array_push($datax,"PUB.PR.EXT.");}
if($cant_ppd>0)      {array_push($datay,$cant_ppd);      array_push($datax,"PUB.PR.DEF.");}
if($cant_npp>0)      {array_push($datay,$cant_npp);      array_push($datax,"PERIMIDAS");}
if($cant_sol>0)      {array_push($datay,$cant_sol);      array_push($datax,"SOLICITADAS");}
if($cant_con>0)      {array_push($datay,$cant_con);      array_push($datax,"CONCEDIDAS");}
if($cant_devfor>0)   {array_push($datay,$cant_devfor);   array_push($datax,"DEVUELT.FORMA");}
if($cant_devfon>0)   {array_push($datay,$cant_devfon);      array_push($datax,"DEVUELT.FONDO");}
if($cant_pex>0)      {array_push($datay,$cant_pex);      array_push($datax,"P.EXTING.");}
if($cant_des>0)      {array_push($datay,$cant_des);      array_push($datax,"DESISTIDAS");}
if($cant_anu>0)      {array_push($datay,$cant_obsdes);   array_push($datax,"ANULADAS");}
if($cant_aba>0)      {array_push($datay,$cant_desobs);   array_push($datax,"ABANDONADAS");}
if($cant_neg>0)      {array_push($datay,$cant_neg);      array_push($datax,"NEGADAS");}
if($cant_sev>0)      {array_push($datay,$cant_sev);      array_push($datax,"S.EFECTO X VENC");}
if($cant_sea>0)      {array_push($datay,$cant_sea);      array_push($datax,"S.EFECTO X PAGO");}
if($cant_opo>0)      {array_push($datay,$cant_opo);      array_push($datax,"OPOSICIONES");}
unset ($datay[0]); $datay = array_values($datay); 
unset ($datax[0]); $datax = array_values($datax);  
$cant_total=$cant_ord+$cant_ppe+$cant_ppd+$cant_npp+$cant_sol+$cant_con+$cant_devfor+$cant_devfon+$cant_pex+$cant_des+$cant_anu+$cant_aba+$cant_neg+$cant_sev+$cant_sea+$cant_opo;
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
if ($boletin==$boletin2) {$graph->title->Set("PUBLICACIONES DE PATENTES EN EL BOLETIN ".$boletin." ".$ptit);}
else {$graph->title->Set("PUBLICACIONES DE PATENTES DEL BOLETIN ".$boletin." AL ".$boletin2." ".$ptit);}
$graph->xaxis->title->Set("");
$graph->yaxis->title->Set("");
   $t1 = new Text("Total de Solicitudes Publicadas: ".$cant_total);
   $t1->SetPos(0.3,0.1);
   $t1->SetOrientation("h");
   $t1->SetFont(FF_FONT1,FS_BOLD);
   $t1->SetBox("white","blue","gray");
   $t1->SetColor("black");
   $graph->AddText($t1);
$graph->title->SetFont(FF_FONT2,FS_BOLD);
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

$name="cuadro"; 
$graph->Stroke("../$name.jpg"); 

?><div align="center"><table>
<tr><img src="../cuadro.jpg" border="0"></tr>
<tr><td class="cnt"><a href="p_est_pubxbol.php?vopc=0"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td></tr></table><?php
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

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Desde Boletin:');
$smarty->assign('campo2','Hasta Boletin:');
$smarty->assign('campo3','C&oacute;digo Pais:');
$smarty->assign('pai_val',$pai_val); 
$smarty->assign('pai_des',$pai_des); 
$smarty->assign('varfocus','forestanu.bol'); 
$smarty->display('p_est_pubxbol.tpl');
$smarty->display('pie_pag.tpl');
}

$sql->disconnect();
?>
