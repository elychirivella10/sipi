<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Mantenimiento de Colores del Sistema');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection();

//Validacion de Entrada
$fondo=$_POST["fondo"];
$letras=$_POST["letras"];
$tabizq=$_POST["tabizq"];
$letizq=$_POST["letizq"];
$tabder=$_POST["tabder"];

if ($fondo=='' || $letras=='' || $tabizq=='' || $letizq=='' || $tabder=='') {
    $smarty->display('encabezado1.tpl');
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

//Creacion de la informacion del archivo main.css
$archivo=$archivo."/*Hoja de Estilos */" ."\n";
$archivo=$archivo."/*Cuerpo del HTML */" ."\n";
$archivo=$archivo."body {" ."\n";
$archivo=$archivo."  zfont-family: sans-serif;" ."\n";
$archivo=$archivo."  zfont-size: 90%;" ."\n";
$archivo=$archivo."  background: ".$fondo.";"."\n";
$archivo=$archivo."  font-family: Tahoma, Arial, helvetica, sans-serif;" ."\n";
$archivo=$archivo."  font-size: 10pt;" ."\n";
$archivo=$archivo."  color: ".$letras.";"."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Titulos */" ."\n";
$archivo=$archivo."h1 {" ."\n";
$archivo=$archivo."  text-align: center;" ."\n";
$archivo=$archivo."  font-size: 140%" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."h2 {" ."\n";
$archivo=$archivo."  text-align: center;" ."\n";
$archivo=$archivo."  font-size: 120%" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."h3 {" ."\n";
$archivo=$archivo."  text-align: center;" ."\n";
$archivo=$archivo."  font-size: 110%" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."h5 {" ."\n";
$archivo=$archivo."  text-align: center;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo.".hotkeys { text-align: right }" ."\n";
$archivo=$archivo."/* Parrafos */" ."\n";
$archivo=$archivo."p {" ."\n";
$archivo=$archivo."  margin-left: 2em;" ."\n";
$archivo=$archivo."  margin-right: 2em;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."p.justificado {" ."\n";
$archivo=$archivo."  text-indent: 40pt;" ."\n";
$archivo=$archivo."  text-align: justify;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."p.izquierda {" ."\n";
$archivo=$archivo."  text-indent: 40pt;" ."\n";
$archivo=$archivo."  text-align: left;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."p.derecha {" ."\n";
$archivo=$archivo."  text-indent: 40pt;" ."\n";
$archivo=$archivo."  text-align: right;" ."\n";
$archivo=$archivo."  text-align: right;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."p.estad {" ."\n";
$archivo=$archivo."  text-align: center;" ."\n";
$archivo=$archivo."  font-size: 90%;" ."\n";
$archivo=$archivo."  padding: 3px" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Tabla */" ."\n";
$archivo=$archivo."table {" ."\n";
$archivo=$archivo."  font-family: Tahoma, Arial, helvetica, sans-serif;" ."\n";
$archivo=$archivo."  text-align: center" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Tablas filas */" ."\n";
$archivo=$archivo."td {" ."\n";
$archivo=$archivo."  text-align: left;" ."\n";
$archivo=$archivo."  font-size: 90%;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Tablas filas alineado el texto a la izquierda */" ."\n";
$archivo=$archivo."td.izq {" ."\n";
$archivo=$archivo."  text-align: right;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Tablas filas alineado el texto a la derecha */" ."\n";
$archivo=$archivo."td.der {" ."\n";
$archivo=$archivo."  text-align: left;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Tablas filas alineado el texto a la izquierda con color azul oscuro */" ."\n";
$archivo=$archivo."td.izq-color {" ."\n";
$archivo=$archivo."  color: ".$letizq.";"."\n";
$archivo=$archivo."  background: ".$tabizq.";"."\n";
$archivo=$archivo."  font-weight: bold;" ."\n";
$archivo=$archivo."  text-align: right;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Tablas filas alineado el texto a la derecha con color azul claro */	" ."\n";
$archivo=$archivo."td.der-color {" ."\n";
$archivo=$archivo."  background: ".$tabder.";"."\n";
$archivo=$archivo."  ztext-align: justify;" ."\n";
$archivo=$archivo."  text-align: left;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Tablas filas alineado el texto al centro */" ."\n";
$archivo=$archivo."td.cnt {" ."\n";
$archivo=$archivo."  text-align: center;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Tablas filas alineado el texto al centro con color azul claro */" ."\n";
$archivo=$archivo."td.cnt-color {" ."\n";
$archivo=$archivo."  background: #7AC0EF;" ."\n";
$archivo=$archivo."  text-align: center;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Tablas filas alineado el texto al centro con color azul claro 2do color */" ."\n";
$archivo=$archivo."td.cnt-color2 {" ."\n";
$archivo=$archivo."  background: #669ec4;" ."\n";
$archivo=$archivo."  text-align: center;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Tablas columnas texto al centro */" ."\n";
$archivo=$archivo."th {" ."\n";
$archivo=$archivo."  color: white;" ."\n";
$archivo=$archivo."  background: #1E5F99;" ."\n";
$archivo=$archivo."  font-weight: bold;" ."\n";
$archivo=$archivo."  text-align: center;" ."\n";
$archivo=$archivo."}" ."\n";
$archivo=$archivo."/* Mensajes */" ."\n";
$archivo=$archivo.".atencion {" ."\n";
$archivo=$archivo."  color: yellow;" ."\n";
$archivo=$archivo."  background: black;" ."\n";
$archivo=$archivo."  text-align: center;" ."\n";
$archivo=$archivo."}" ."\n";

//echo $archivo;
$nombre='main';

//if (file_exists($vusuario.'.txt')) {
	$open = fopen($nombre.'.css',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);
//}
  $smarty->display('encabezado1.tpl');
  //Mensaje("DATOS GUARDADOS CORRECTAMENTE. Pulse REFRESCAR para Actualizar!!!","m_pconfcol.php");
  mensajenew('DATOS GUARDADOS CORRECTAMENTE. Pulse REFRESCAR para Actualizar ...!!!','m_pconfcol.php','S');
  $smarty->display('pie_pag.tpl'); exit();
?>
