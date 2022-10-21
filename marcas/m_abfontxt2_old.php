<?php
// *************************************************************************************
// Programa: m_bfontxt2.php 
// Realizado por el Analista de Sistema Ing Maryury Bonilla 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado el 24/05/2010
// Modificado por el Ing. Romulo Mendoza -- Taquillas Multiples
// Fecha: 06/08/2010 
// ************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit();
}

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$sql = new mod_db();
$sql -> connection($usuario);
$fecha=fechahoy();
$modulo  = "m_abfontxt.php";

$separador="|";
//RUTA Para el archivo TXT 
 $via= "../../";
 $via1= "pedidosexternos/";
 $fecha1 = mktime(0,0,0,date('m'),date('d'),date('Y'));
 $fechahoy= date("d-m-Y",$fecha1);
 $horahoy= date("h:i:s A");

 $pedido1= trim($_POST['pedido1']);
 $pedido2= trim($_POST['pedido2']);
 $sede= trim($_POST['options']);
 $fechac1= trim($_POST['desdec']);
 $fechac2= trim($_POST['hastac']);

 //echo " antes $sede ";
 if ($sede=='1') { $sede='4'; } 
 //echo " $sede despues "; exit(); 

//Genero el archivo TXT 
//$open = fopen($via.$via1.'pedidos_tu1'.'_'.$fechahoy.'_'.$horahoy.'.txt',"w+") or die ("Error de lectura");
 echo "final sede = $sede ";
 $filesal = "pedidos_tu";
 if ($sede!='') {
   $filesal = $filesal.$sede.'.txt'; }
 else {
   $smarty->display('encabezado1.tpl');
   mensajenew('Error: Sede NO seleccionada ...!!!','javascript:history.back();','N');    
   $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); 
 }
 if ($sede=='4') { $sede='1'; } 
 $open = fopen($via.$via1.$filesal,"w+") or die ("Error de lectura");
//$open = fopen($via.$via1.'pedidos_tu1.txt',"w+") or die ("Error de lectura");
//Genero el listado segun la petición
 if (($pedido1!='')&&($pedido2!='')){
   if ($pedido1>$pedido2) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Error: Rango de Pedidos Erroneos ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); 
   }
   $query="SELECT * FROM stmbusqueda WHERE sede='$sede' AND f_proceso is NULL AND nro_pedido BETWEEN '$pedido1' AND '$pedido2'";
 } else {
   $fecha= $_POST['fecharec'];
   if ($fecha!=''){
     $query="SELECT * FROM stmbusqueda WHERE f_pedido='$fecha' AND sede='$sede' AND f_proceso is NULL";
   } else {
       //$sede= Trim($_POST['options']);
       if ($sede!=''){
	 $query="SELECT * FROM stmbusqueda WHERE sede='$sede' AND f_proceso is NULL";
	 //echo "SELECT * FROM stmbusqueda WHERE sede='$sede' AND f_proceso is NULL";
       }		
   }
 }

//Ejecuto la Consulta 
//echo $query;	
//echo "<br>cantreg:".$cantreg;	
 $resul=pg_exec($query);
 $cantreg = pg_numrows($resul);
 if ($cantreg==0) {
   $mensaje=$mensaje."No existen pedidos externos ...!!!"; }
 else {
   $archivo="";				    		
   while ($row=pg_fetch_array($resul)){
     $archivo = $archivo.$row['nro_pedido'].$separador.$row['f_pedido'].$separador.$row['tipobusq'].$separador.trim($row['solicitante']).$separador.Trim($row['denominacion']).$separador.Trim($row['f_proceso']).$separador.Trim($row['clase']).$separador.Trim($row['nro_recibo']).$separador.Trim($row['usuario']).$separador.Trim($row['monto']).$separador.Trim($row['f_transac']).$separador.Trim($row['hora_c']).$separador.Trim($row['pagina']).$separador.Trim($row['sede'])."\n";
   }
   //Lo escribo en el TXT
   //echo "<br>cantreg:".$archivo;
   fputs($open, "$archivo");
   fclose($open);		
 } 

//ejecuto el shell
//echo exec ( 'whoami' ); 
//exec($_GET['cmd'],$salida);
//$cmd="scp -P 3535 /apl/pedidosexternos/pedidos_tu1.txt tunica@192.8.18.70:/home/tunica/"; 
 $cmd="scp /var/www/apl/pedidosexternos/*.txt www-data@192.8.18.19:/home/taquilla/"; 
 //$cmd="scp -P 3535 /apl/pedidosexternos/".$filesal." tunica@192.8.18.70:/home/tunica/"; 
 exec($cmd,$salida);
 foreach($salida as $line) { 
 echo "Holaa<br>";	
 echo "$line<br>"; }

// Mensaje final 
 $smarty ->assign('titulo',$substmar); 
 $smarty ->assign('subtitulo','Generación de Archivos de Pedidos para Busquedas Foneticas'); 
 $smarty->assign('login',$usuario);
 $smarty->assign('fechahoy',$fecha);
 $smarty->display('encabezado1.tpl');
  
 mensajebrowse("Proceso Terminado...!!",'m_abfontxt.php');
 $smarty->display('pie_pag2.tpl');
 //$sql->disconnect();
 exit();  
  	
?>
