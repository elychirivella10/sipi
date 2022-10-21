<script language="Javascript"> 
 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }
</script>

<?php
// *************************************************************************************
// Programa: m_genfirma.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2014 II Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$login   = $_SESSION['usuario_login'];
$vopc    = $_GET['vopc'];
$fecha   = fechahoy();
$fechahoy  = hoy();
$tbname_1  = "stzfirmel";
$diripmaq  = getRealIP();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generacion de Certificado de Marcas con Firma Electr&oacute;nica'); 
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) {
  //Conexion
  $sql = new mod_db();
  $sql->connection($login);

  //Variables
  $pagina         = $paginaFirma;
  $tipoFirma      = $tipoFirma;
  $resultado_firma= "";
  $server         = $ip_serv_local;
  $rutaOrigen     = $ruta_certificado;
  $rutaDestino    = $ruta_certif_e;
  $passwordPdf    = "null";
  $ubicacion      = $ubicacion_geografica;
  $mailContacto   = $mailContacto1;
  $razon          = $razon1;
  $pX             = $pXm;
  $pY             = $pYm;
  $pW             = $pWm;
  $pH             = $pHm;
  
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE estatus='G' ORDER BY solicitud");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla   $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $cantidad=$sql->nums('',$obj_query);

  //echo " $rutaOrigen - $rutaDestino, $diripmaq, $filas_found  ";

  $objreg = $sql->objects('',$obj_query);
  for($cont=0;$cont<$cantidad;$cont++) { 

    $expediente=$objreg->solicitud;
    $expyear = substr($objreg->solicitud, 0, 4);
    $expnume = substr($objreg->solicitud, 5, 6);
    ${'pdf_firma'.$cont} = $expyear.$expnume.".pdf";
    echo "<br>RES FINAL= ${'pdf_firma'.$cont}";
    //echo "<br> El 0= $pdf_firma0";
    //echo "El 5= $pdf_firma5 ";

    $horactual = hora();
    $update_str = "estatus='F',fecha_firmado='$fechahoy',hora_firmado='$horactual',usuario_firmante='$login',ipmaq_firma='$diripmaq'";
    //$actbusqueda= $sql->update("$tbname_1","$update_str","solicitud='$expediente' AND estatus='G'"); 

    $objreg = $sql->objects('',$obj_query);
  }
  Mensajenew("TOTAL ARCHIVOS PROCESADOS: ".$cantidad,"m_genfirma.php?vopc=1",'S');
  $smarty->display('pie_pag.tpl'); exit();
}
$smarty->assign('vopc',$vopc);
$smarty->display('m_genfirma.tpl');
$smarty->display('pie_pag.tpl');
?>
