<?php
include ("../setting.inc.php");
include ("../z_includes.php");
include("../fckeditor/fckeditor.php") ;

// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
$sBasePath = '../fckeditor/' ;
//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$sql -> connection();
$fecha   = fechahoy();

//Encabezado
$substmar="Subsistema de Boletin";
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Documentos o Avisos Oficiales');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$titulo   = $_POST['titulo'];

$objquery = $sql->query("SELECT * FROM stzavisos WHERE titulo='$titulo'");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
$titulo = trim($objs->titulo);
$naviso = trim($objs->nro_aviso);
$texto  = $objs->texto;

echo "<form name='form' action='b_avisos.php?vopc=6&titulo={$titulo}' method='POST'>\n";

echo "<table Width='100%'>\n<tr>\n<td class='izq-color'  Width='13%'>Nro. Documento:</td>\n";
echo "<td class='der-color'>".$naviso."</td>\n";
echo "<table Width='100%'>\n<tr>\n<td class='izq-color'  Width='13%'>Titulo:</td>\n";
echo "<td class='der-color'>".$titulo."</td>\n";
echo "<table Width='100%'>\n<tr>\n<td class='izq-color'  Width='13%'>Documento</td>\n";
echo "<td class='der-color'>";
$oFCKeditor = new FCKeditor('texto') ;
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Width  = '300%'; 
$oFCKeditor->Height = '600'; 
$oFCKeditor->Value  = $texto ;
$oFCKeditor->Create() ;
echo "</td>\n</tr>";	

echo "  <table align='center' width='200'>";
echo "  <tr>";
echo "	<input  type='hidden' value='$naviso' name='naviso' />";
echo "  <td class='cnt'><input type='image' src='../imagenes/save_f2.png' value='Grabar'>  Grabar  </td>";
echo "  <td class='cnt'><a href='b_avisos.php?vopc=5&nconex=&salir=1&conx=0'><img src='../imagenes/cancel_f2.png' border='0'>
</a>  Cancelar  </td>";

echo "  <td class='cnt'><a href='../index1.php'><img src='../imagenes/salir_f2.png' border='0'> </a>Salir</td>";
echo "	</tr> ";
echo "  </table> ";
     
echo "</form>";
$smarty->display('pie_pag1.tpl');
?>
		


