<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" ></meta>
<?php
/* TO USE RELATIVE PATHS: */
$myDirPath = '';
$myWwwPath = '';
?>
<link rel="stylesheet" href="<?php print $myWwwPath; ?>layersmenu-demo.css" type="text/css"></link>
<link rel="stylesheet" href="<?php print $myWwwPath; ?>layersmenu-gtk2.css" type="text/css"></link>
<link rel="shortcut icon" href="<?php print $myWwwPath; ?>LOGOS/shortcut_icon_phplm.png"></link>
<title>The PHP Layers Menu System</title>

<script language="JavaScript" type="text/javascript">
<!--
<?php require_once $myDirPath . 'libjs/layersmenu-browser_detection.js'; ?>
// -->
</script>
<script language="JavaScript" type="text/javascript" src="<?php print $myWwwPath; ?>libjs/layersmenu-library.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print $myWwwPath; ?>libjs/layersmenu.js"></script>

<?php

require_once $myDirPath . 'lib/PHPLIB.php';
require_once $myDirPath . 'lib/layersmenu-common.inc.php';
require_once $myDirPath . 'lib/layersmenu.inc.php';

include ("setting.inc.php");
//Para trabajar con sessiones
require("$root_path/aut_verifica.inc.php");
//LLamadas a funciones de Libreria 
//include ("$include_lib/library.php");

$ruta_rol = $root_path."/roles/";

$usuario = $_SESSION['usuario_login'];
$vrol = trim($_SESSION['usuario_rol']);

//$vusuario=$_GET['vuser'];
//$vrol=$_GET['vrol'];
//$vrol=$_SESSION['usuario_nivel'];
//$usuario = $_SESSION['usuario_login'];
//$vrol = trim($_SESSION['usuario_rol']);
//echo "login= $usuario, role= $vrol M";

$mid = new LayersMenu(6, 7, 2, 5, 140);
//$mid = new LayersMenu(6, 7, 2, 1);	// Gtk2-like
$vnombre=$ruta_rol.$vrol.'.txt';
//echo " rol= ".$vnombre;

if (!file_exists($vnombre)) {
  Mensage_Error("Archivo de Rol no ha sido Encontrado, contacte al Administrador del Sistema ...!!!");
  exit(); }  

//$vnombre=$vrol.'.txt';
//echo "rol= ".$vnombre;
//$vnombre='layersmenu-horizontal-1';
$mid->setMenuStructureFile($myDirPath.$vnombre);
//$mid->setMenuStructureFile($myDirPath.'layersmenu-horizontal-1.txt');

$mid->setIconsize(16, 16);
$mid->parseStructureForMenu('hormenu1');
$mid->newHorizontalMenu('hormenu1');
$mid->printHeader();

?>

</head>
<body>
<?php
$mid->printMenu('hormenu1');
?>
<?php
$mid->printFooter();
?>

</body>
</html>
