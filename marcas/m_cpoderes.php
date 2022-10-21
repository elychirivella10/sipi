<?php 
ob_start();
?> 
<script language="Javascript"> 
 function browsetitularp(var1,var2,var3,var4) {
   open("act_titularp.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

 function browsepoderhabi(var1,var2,var3,var4) {
   open("act_poderhabi.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
</script>

<?
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql = new mod_db();
$fecha=fechahoy();
$vuser    =$usuario;  
   
//Captura Variables leidas en formulario inicial
$vopc=$_GET['vopc']; if (empty($vopc)) {$vopc=12;}
$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$vfecp=$_POST['vfecp'];
$vfac=$_POST['vfac'];
$vobs=$_POST['vobs'];
$vaccion=$_POST['vaccion'];
$vsol=sprintf("%04d-%04d",$vsol1,$vsol2);
$psoli=$vsol;
$vfec=hoy();
   
//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('titulo','Sistema de Marcas'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol1'); 
$smarty ->assign('vmodo','');
$smarty ->assign('vmodo2',''); 
if ($vopc==11) {$vaccion='Incluir';}
if ($vopc==12) {$vaccion='Buscar';}  
if ($vaccion=='Incluir') {$smarty ->assign('subtitulo','Ingreso de Poderes');}
if ($vaccion=='Buscar')  {$smarty ->assign('subtitulo','Consulta de Poderes');}

$sql->connection();   
   
//Asignacion de variables para pasarlas a Smarty
$smarty ->assign('vopc',$vopc); 
$smarty ->assign('vaccion',$vaccion);
$smarty ->assign('vsol',$vsol); 
$smarty ->assign('vsol1',$vsol1); 
$smarty ->assign('vsol2',$vsol2); 
$smarty ->assign('vfecp',$vfecp);
$smarty ->assign('vfac',$vfac);
$smarty ->assign('vobs',$vobs);
$smarty ->assign('lsolicitud','Codigo del Poder:'); 
$smarty ->assign('lcodigo','Codigo del Titular:'); 
$smarty ->assign('lnombre','Nombre:'); 
$smarty ->assign('lcpoder','Codigo:'); 
$smarty ->assign('lnpoder','Nombre:'); 
$smarty ->assign('lfechapoder','Fecha del Poder:'); 
$smarty ->assign('lfacultad','Facultad:'); 
$smarty ->assign('lfacultad2','(M)arcas (P)atentes (A)mbas'); 
$smarty ->assign('ltitular','Titular(es):');
$smarty ->assign('lpoderhabi','Poderhabiente(s):');
$smarty->display('encabezado1.tpl');
$smarty->display('m_ipoderes_sol.tpl'); 
$smarty->display('pie_pag.tpl');
?>

