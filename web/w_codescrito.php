<script language="Javascript"> 
function pregunta() { 
  return confirm('Estas seguro de enviar la Informacion ?'); }

function checkear(f)	{
				function no_prever() {
					alert("El archivo buscado y seleccionado no es valido ...!!!");
					f.value='';
				}
				function prever() {
					var campos = new Array("maxpeso", "maxalto", "maxancho");
					for (i = 0, total = campos.length; i < total; i ++)
						f.form[campos[i]].disabled = false;
					actionActual = f.form.action;
					targetActual = f.form.target;
					f.form.action = "previsor.php";
					f.form.target = "ver";
					f.form.submit();
					for (i = 0, total = campos.length; i < total; i ++)
						f.form[campos[i]].disabled = true;
					f.form.action = actionActual;
					f.form.target = targetActual;
				}

				(/\.(pdf)$/i.test(f.value)) ? prever() : no_prever();
			}
</script>

<?php
// *************************************************************************************
// Programa: w_codescrito.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPIC
// Año 2016 II Semestre
// *************************************************************************************
include ("../setting.inc.php");
ob_start();

//Comienzo del Programa por los encabezados del reporte
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = $_SESSION['usuario_login'];
$role      = $_SESSION['usuario_rol'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();

$tbname_1 = "stmescrito";
$tbname_2 = "stztramsindep";

$vopc = $_GET['vopc'];
$vtramt=$_GET['vtramt'];
$vsol=$_GET['vsol'];
$vtipe=$_GET['vtipe'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso o Presentacion de Escrito(s) al SIPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','wcodescrito1.vcode'); 
$smarty->assign('modo2','readonly');

//Verificando conexion
$sql->connection($usuario);

//****************************************************************************
if ($vopc==4) {
   $vtramite= $vtramt;

   $sql1 = new mod_db();
   $sql1->connection1();

   $resultadosoltra=pg_exec("select a.nro_tramite,a.nro_escrito,a.solicitud,a.denominacion,a.clase,a.usuario from stmescrito a,stztramsindep d where a.nro_tramite='$vtramt' and a.solicitud='$vsol' and a.nro_tramite=d.nro_tramite order by a.nro_tramite,a.solicitud");
   $vcansol=pg_numrows($resultadosoltra); 
   $regsoltra = pg_fetch_array($resultadosoltra); 
   $vusuario=$regsoltra['usuario'];
   if ($vcansol<1) {
     mensajenew('Error: Tramite No Registrado! Verifique...','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); 
   }
   for($cont=1;$cont<=$vcansol;$cont++) { 
     $vnumsol=$regsoltra['solicitud'];
     $vrefsol[$cont]=$regsoltra['solicitud'];
     $vnomsol[$cont]=$regsoltra['nombre'];
     $vclaint[$cont]=$regsoltra['clase'];
     
     $regsoltra = pg_fetch_array($resultadosoltra); 
   }
   $sql1->disconnect1();
}   

//Pase de variables y Etiquetas al template
$smarty->assign('submitbutton','submit'); 
$smarty->assign('submitbutton1','button'); 

$smarty->assign('campo1','Nro. Tramite:');
$smarty->assign('usuario',$usuario);
$smarty->assign('vopc',$vopc);
$smarty->assign('vtramt',$vtramt);
$smarty->assign('vsol',$vsol);
$smarty->assign('vtipe',$vtipe);

$smarty->assign('usuario',$usuario);
$smarty->assign('vcansol',$vcansol);
$smarty->assign('vrefsol',$vrefsol);
$smarty->assign('vnomsol',$vnomsol);
$smarty->assign('vtipder',$vtipder);
$smarty->assign('vclaint',$vclaint);

$smarty->display('w_codescrito.tpl');
$smarty->display('pie_pag.tpl');
?>
