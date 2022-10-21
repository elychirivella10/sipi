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
$login = $_SESSION['usuario_login'];
//$role    = $_SESSION['usuario_rol'];
$sql = new mod_db();
$sql -> connection($login);
$fecha    =fechahoy();
$modulo   = "m_abfontxt.php";
$horactual=hora();
$fechahoy = hoy();

$separador="|";
//RUTA Para el archivo TXT 
 $via= "../../";
 $via1= "pedidosexternos/";
 $fecha1 = mktime(0,0,0,date('m'),date('d'),date('Y'));
 $fechahoy= date("d-m-Y",$fecha1);
 $horahoy= date("h:i:s A");

 $pedido1= trim($_POST['pedido1']);
 $pedido2= trim($_POST['pedido2']);
 $sede   = trim($_POST['options']);
 $desdec = trim($_POST['desdec']);
 $hastac = trim($_POST['hastac']);
 $usuario= trim($_POST['usuario']); 
 $envio  = trim($_POST['vplus']);
 $procesada = $_POST['procesada'];

 //echo " antes $sede ";
 if ($sede=='1') { $sede='4'; } 
 //echo " $sede despues "; exit(); 

  //Genero el archivo TXT 
  //$open = fopen($via.$via1.'pedidos_tu1'.'_'.$fechahoy.'_'.$horahoy.'.txt',"w+") or die ("Error de lectura");
 //echo "final sede = $sede ";
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

 //$where = "f_proceso is NULL ";
 $where = "";
 //Genero el listado segun la petición
 if (($pedido1!='')&&($pedido2!='')){
   if ($pedido1>$pedido2) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Error: Rango de Pedidos Erroneos ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); }
   if (empty($where)) {  
     $where = " nro_pedido BETWEEN '$pedido1' AND '$pedido2' "; }
   else {  
     $where = $where." AND nro_pedido BETWEEN '$pedido1' AND '$pedido2' "; }
 } else {
   $fecha= $_POST['fecharec'];
   if ($fecha!='') {
     if (empty($where)) {
       $where = " f_pedido='$fecha' "; }
     else {  
       $where = $where." AND f_pedido='$fecha' "; } 
   } 
   else {
     if(!empty($desdec) && !empty($hastac)) {
       $esmayor=compara_fechas($desdec,$hastac);
       if ($esmayor==1) {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: Rango de Fechas de Carga erroneo ...!!!','javascript:history.back();','N');    
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
       else {
         if (empty($where)) {       
           $where = " (stmbusqueda.f_transac>='$desdec' AND stmbusqueda.f_transac<='$hastac')"; }
         else {  
           $where = $where." AND (stmbusqueda.f_transac>='$desdec' AND stmbusqueda.f_transac<='$hastac')"; } 
       }
     }         
   }
 }

 if(!empty($usuario)) { 
   if (empty($where)) {
     $where = " (stmbusqueda.usuario='$usuario')"; }
   else {   
     $where = $where." AND (stmbusqueda.usuario='$usuario')"; }   
 }
 
 if ($procesada=='S') {
   if(!empty($where)) {
      $where = $where." AND"." (stmbusqueda.f_proceso is not null) "; }
 }

 if ($procesada=='N') {
   if(!empty($where)) {
      $where = $where." AND"." (stmbusqueda.f_proceso is null) "; }
 }

if (empty($where)) {
  $smarty->display('encabezado1.tpl');
  mensajenew('ERROR: NO ha escrito los valores de B&uacute;squedas ...!!!','javascript:history.back();','N');    
  $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); 
}

$where = $where." AND sede='$sede' AND envio='$envio' ";
if ($envio=='S') { $where = $where." AND estatus_envio='N' "; }

//$where = $where." AND envio='$envio' ";
//echo " where= $where "; exit();
//Genero el listado segun la petición
// if (($pedido1!='')&&($pedido2!='')){
//   if ($pedido1>$pedido2) {
//     $smarty->display('encabezado1.tpl');
//     mensajenew('Error: Rango de Pedidos Erroneos ...!!!','javascript:history.back();','N');    
//     $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); 
//   }
//   $query="SELECT * FROM stmbusqueda WHERE sede='$sede' AND f_proceso is NULL AND nro_pedido BETWEEN '$pedido1' AND '$pedido2'";
// } else {
//   $fecha= $_POST['fecharec'];
//   if ($fecha!=''){
//     $query="SELECT * FROM stmbusqueda WHERE f_pedido='$fecha' AND sede='$sede' AND f_proceso is NULL";
//   } else {
//       //$sede= Trim($_POST['options']);
//       if ($sede!=''){
//	 $query="SELECT * FROM stmbusqueda WHERE sede='$sede' AND f_proceso is NULL";
//	 //echo "SELECT * FROM stmbusqueda WHERE sede='$sede' AND f_proceso is NULL";
//       }		
//   }
// }

$query="SELECT * FROM stmbusqueda WHERE $where";
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
     $vped = $row['nro_pedido'];
     $archivo = $archivo.$row['nro_pedido'].$separador.$row['f_pedido'].$separador.$row['tipobusq'].$separador.trim($row['solicitante']).$separador.Trim($row['denominacion']).$separador.Trim($row['f_proceso']).$separador.Trim($row['clase']).$separador.Trim($row['nro_recibo']).$separador.Trim($row['usuario']).$separador.Trim($row['monto']).$separador.Trim($row['f_transac']).$separador.Trim($row['hora_c']).$separador.Trim($row['pagina']).$separador.Trim($row['sede'])."\n";
     $update_str = "f_proceso='$fechahoy',hora_proceso='$horactual'";
     $actbusqueda= $sql->update("stmbusqueda","$update_str","nro_pedido='$vped'"); 
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
 $smarty->assign('login',$login);
 $smarty->assign('fechahoy',$fecha);
 $smarty->display('encabezado1.tpl');
  
 mensajebrowse("Proceso Terminado...!!",'m_abfontxt.php');
 $smarty->display('pie_pag2.tpl');
 //$sql->disconnect();
 exit();  
  	
?>
