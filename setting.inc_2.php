<?php
/* This script is setting all vars Sistema SIPI */

/* Document root o raiz del Proyecto */
$doc_root     = "/var/www";
/* Ubicacion del Sistema */
$root_path    = "$doc_root/apl/sipi";
/* Ubicacion de las Librerias */
$include_lib  = "$doc_root/apl/librerias";
/* Ubicacion de los includes */
$include_path = "$root_path/include";
/* Ubicacion de las imagenes del Sistema */
$imagen_path  = "$root_path/imagenes";
/* Ubicacion temporal de los logotipos del usuario */ 
$imagen_temp  = "$doc_root/apl/sipi/imagentemp"; 
/* Ubicacion definitiva de los logotipos del usuario para la busqueda grafica*/ 
$imagen_def  = "$root_path/graficos/planblog"; 
/* Nombre Dominio de ubicacion de los Logotipos de las Marcas */
$dom_virtual  = "http://imagenes.sapi.gob.ve/";
/* Ubicacion Temporal de los diferentes Documentos asociados al Tramite de Marca */ 
$documento_path  = "$doc_root/apl/sipi/docutemp";
/* Ubicacion Definitiva de los diferentes Documentos asociados a la Solicitud de Marca */ 
$fdocumento_path  = "$doc_root/apl/sipi/documentos";
/* Ubicación o Ruta Original de Certificados Generados */
$ruta_certificado="$fdocumento_path/certificado";
$ruta_certifi2   ="/apl/certificados";
/* Ubicación o Destino de Certificados Electrónicos Firmados */
$ruta_certif_e ="$fdocumento_path/certificado_e";
$ruta_certif_em="$fdocumento_path/certificado_e/marcas";
$ruta_certif_ep="$fdocumento_path/certificado_e/patentes";
$ruta_certif_ea="$fdocumento_path/certificado_e/autor";
/* Datos extras para los Certificados Electrónicos */
$ip_serv_local = "172.16.0.30";
$paginaFirma = "1";
$tipoFirma = "2";
$razon1 = "11.032.754";
$razon2 = "";
//$mailcontacto1 = "mvelasquez@sapi.gob.ve";
$mailcontacto1 = "rmendoza@sapi.gob.ve";
$mailcontacto2 = "";
$ubicacion_geografica = "";
$ministerio = "MINISTERIO DEL PODER POPULAR DE COMERCIO NACIONAL";
/* Ubicacion de la Firma en el Certificado Electrónico para Marcas */
$pXm = "";
$pYm = "";
$pWm = "";
$pHm = "";
/* Ubicacion de la Firma en el Certificado Electrónico para Derecho de Autor */
$pXa = "";
$pYa = "";
$pWa = "";
$pHa = "";
/* Ubicacion Real o absoluta de los Logotipos */
$img_real     = "$doc_root/apl/sipi/graficos";
/* Ubicacion virtual de los Logotipos */
$img_virtual  = "../graficos";
/* Ubicacion real de los logotipos de Marcas, Patentes y Busquedas externas */
$img_mar_real = "$img_real/marcas";
$img_pat_real = "$img_real/patentes";
$img_ext_real = "$img_real/logbext";
/* Nombre para cada Subsistema */
$substmar     = "SIPI - SubSistema de Marcas";
$substpat     = "SIPI - SubSistema de Patentes";
$substrpi     = "SIPI - SubSistema de Marcas y Patentes del R.P.I.";
$substaut     = "SIPI - SubSistema de Derecho de Autor";
$substacc     = "SIPI - M&oacute;dulo de Acceso";
$substcon     = "SIPI - M&oacute;dulo de Configuraci&oacute;n";
$horatope     = "12:00:00 PM";
$topeanno     = '2018';
$totalannos   = 100;

$annoactual   = "2015";
$annoinicial  = 1900;
$annotope     = 2015;

##### Setting SQL Type #####
$sql_type = "3"; // 1 --> MySQL ; 2 --> MSSQL ; 3 --> PostgreSQL

 if($sql_type == "1"){
  include ("$include_lib/mysql.inc.php");
 }elseif($sql_type == "2"){
  include ("$include_lib/mssql.inc.php");
 }elseif($sql_type == "3"){
  include_once ("$include_lib/pgsql.inc.php");
 }

##### Setting SQL Vars #####

/* Servidor de Datos */
$sql_host = "192.8.18.2";
/* Servidor de Correo */
//$sql_mail = "172.16.0.2";
$sql_mail = "172.16.0.5";
/* Nombre de Base de Datos del Sipi */ 
$sql_name = "bdrpi";
$sql_user = "postgres";
$sql_pass = "";
/* Nombre de Base de Datos del Webpi */
//$sql1_name = "websipi";
$sql1_name = "websipi";
$sql1_user = "";
$sql1_pass = "";

$sql_tabla= "stzusuar";

?>
