<?php
include ("../../../setting.inc.php");
include("../../fckeditor.php") ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>FCKeditor - Sample</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="noindex, nofollow">
		<link href="../sample.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<h1>FCKeditor - PHP - Sample 1</h1>
		This sample displays a normal HTML form with an FCKeditor with full features
		enabled.
		<hr>
		<form action="sampleposteddata.php" method="post" target="_blank">
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
$sBasePath = $_SERVER['PHP_SELF'] ;
$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;

$sql = new mod_db();
$sql->connection();   

$titulo= "PRUEBA DE AVISOS OFICIALES 1";
$objquery = $sql->query("SELECT * FROM stzavisos WHERE titulo='$titulo'");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
$valor = $objs->texto;

echo " V= $valor ";
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/silver/' ;
//$oFCKeditor->Value		= '<p>This is some <strong>sample text</strong>. You are using <a href="http://www.fckeditor.net/">FCKeditor</a>.</p>' ;
$oFCKeditor->Value		= $valor ;
$oFCKeditor->Create() ;
?>
			<br>
			<input type="submit" value="Submit">
		</form>
	</body>
</html>
