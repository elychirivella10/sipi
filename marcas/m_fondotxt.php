<script language="Javascript"> 
function pregunta() { 
  return confirm('Estas seguro de transferir la Informacion ?'); }
</script> 

<?php
// *************************************************************************************
// Programa: m_fondotxt.php 
// Realizado por el Ing. Romulo Mendoza - Profesional II 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Fecha: 03/06/2011 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo  = "m_fondotxt.php";
$vopc    = $_GET['vopc'];
$boletin = $_POST['boletin'];
$estatus = $_POST['estatus'];

//Encabezado
$substmar="Subsistema de Marcas";
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n de Archivo TXT Solicitudes para Fondo');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) {
 $sql = new mod_db();
 $sql -> connection($usuario);
 $fechahoy = Hoy();

 $separador="|";
 //RUTA Para el archivo TXT 
 $via= "../../";
 $via1= "pedidosexternos/";
 $filesal = 'fondosol.txt';
 //Genero el archivo TXT 
 $open = fopen($via.$via1.$filesal,"w+") or die ("Error de lectura");

 //Genero el listado segun la petición
 //$query="SELECT * FROM stmbatfon";
 if ($estatus==8) { 
   $query = "SELECT stzderec.solicitud FROM stzderec,stzevtrd,stmmarce 
             WHERE stzderec.estatus = 1008
              AND stzevtrd.nro_derecho = stzderec.nro_derecho
              AND stzderec.nro_derecho = stmmarce.nro_derecho
              AND stzevtrd.evento = 1124
              AND stmmarce.modalidad IN ('D','M')
              AND stzevtrd.documento = '$boletin'
             ORDER BY stzderec.solicitud"; }
 if ($estatus==120) { 
   $query = "SELECT stzderec.solicitud FROM stzderec,stzevtrd,stmmarce 
             WHERE stzderec.estatus = 1120
              AND stzevtrd.nro_derecho = stzderec.nro_derecho
              AND stzderec.nro_derecho = stmmarce.nro_derecho
              AND stzevtrd.evento = 1122
              AND stzevtrd.estat_ant = 1003
              AND stmmarce.modalidad IN ('D','M')
              AND stzevtrd.documento = '$boletin'
             ORDER BY stzderec.solicitud"; }
 
 //Ejecuto la Consulta 
 $resul=pg_exec($query);
 $cantreg = pg_numrows($resul);
 if ($cantreg==0) {
   $mensaje=$mensaje."No existen Solicitudes Nuevas ...!!!"; }
 else {
   $archivo="";				    	
   $npag = 0;	
   while ($row=pg_fetch_array($resul)){
     $vsol = $row['solicitud'];
     $vanno = substr($vsol,2,2); 
     $vnumero=substr($vsol,-6,6);
     $vexp = $vanno.'-'.$vnumero;  
     $archivo = $archivo.$vexp.$separador.$separador.$fechahoy.$separador.$npag.$separador.$usuario."\n";
     //$archivo = $archivo.$row['solicitud'].$separador.$vexp.$separador.$separador."\n";
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
 $cmd="scp /var/www/apl/pedidosexternos/fondosol.txt www-data@192.8.18.19:/home/taquilla/"; 
 //$cmd="scp -P 3535 /apl/pedidosexternos/".$filesal." tunica@192.8.18.70:/home/tunica/"; 
 exec($cmd,$salida);
 foreach($salida as $line) { 
 echo "Holaa<br>";	
 echo "$line<br>"; }

 // Mensaje final 
 //$smarty ->assign('titulo',$substmar); 
 //$smarty ->assign('subtitulo','Generaci&oacute;n de Archivo TXT Solicitudes para Fondo'); 
 //$smarty->assign('login',$usuario);
 //$smarty->assign('fechahoy',$fecha);
 //$smarty->display('encabezado1.tpl');
  
 mensajebrowse("Proceso Terminado...!!",'m_fondotxt.php');
 $smarty->display('pie_pag2.tpl');
 //$sql->disconnect();
 exit();  
}

$smarty->assign('arrayvest',array(8,120));
$smarty->assign('arraytest',array('Solicitadas','Observadas'));

$smarty->assign('campo1','Bolet&iacute;n No.:');
$smarty->assign('campo2','Estatus:');
$smarty->display('m_fondotxt.tpl');
$smarty->display('pie_pag.tpl');
?>
