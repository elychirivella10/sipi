<?php
ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Para trabajar con Smarty 
require ("$root_path/include.php");
include ("$include_lib/librar_cert.php");
//LLamadas a funciones de Libreria 
//include ("$include_lib/library.php");
$fecha   = fechahoy();
$fechahoy = hoy();

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/fpdf.php");

//Conexion
$sql = new mod_db();
$sql->connection();

//Pantalla Titulos

$smarty->assign('subtitulo','Certificados de Registro de Marcas');
$smarty->assign('fechahoy',$fecha);
//$smarty->display('encabezado.tpl');

//Validacion de Entrada
$registrod1=$_POST["vreg1"];
$registroh1=$_POST["vreg2"];


$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];

$varsol2 = str_pad($varsol2, 6, '0', STR_PAD_LEFT); 
$registroh1 = str_pad($registroh1, 6, '0', STR_PAD_LEFT); 

//echo $varsol2;
//echo $registroh1;
$registrod= $registrod1.$registroh1;
$varsol=($varsol1.'-'.$varsol2);
$vnsol=($varsol1.$varsol2);
//echo "$registrod";

//echo $registrod;
//Query para buscar los certificados de marcas en el rango correspondiente

//-> Se incorporaron los estatus 1821,1830,1831,1839,1842,1916 
//-> en Fecha: 06/11/2020 Por: Nelson Gonzalez
//-> para minimizar los requerimientos de cambios de estatus temporal para la impresión de certificados 

if((!empty($registrod)) and ($registrod!= '000000')) {  
   $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho
		       AND tipo_mp='M' 
		       AND b.estatus in (1555,1821,1830,1831,1839,1842,1916)
          	       AND b.registro =  '$registrod' ");
}
if((!empty($varsol)) and ($varsol != '000000')) {  
   $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho
		       AND tipo_mp='M' 
		       AND b.estatus in (1555,1821,1830,1831,1839,1842,1916)
		       AND b.solicitud = '$varsol' and b.solicitud!='' ");

}

//verificando los resultados
if (!$resultado) { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','m_rptpcertem.php?vopc=1','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Error: No existe el Nro. de Registro o Solicitud, o NO se encuentra en el estatus adecuado ...!!!','m_rptpcertem.php?vopc=1','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit(); 
      } 
$reg = pg_fetch_array($resultado);
$nderec=$reg['nro_derecho'];
$vnsol=substr($reg['solicitud'],0,4).substr($reg['solicitud'],5,6);

//Validación del boletin mayor o igual al 562
$resulbol=pg_exec("SELECT nro_derecho,documento FROM stzevtrd 
                    WHERE nro_derecho='$nderec' and evento IN ('1122','1097') and (estat_ant<>'1003' and estat_ant<>'1200' and estat_ant<>'1116')");
$reg_bol = pg_fetch_array($resulbol);
$filas_bol=pg_numrows($resulbol); 
if ($resulbol and $filas_bol>0) {
     $var_doc=trim($reg_bol['documento']);
     $vdir="boletin".trim($var_doc);
     if ($var_doc>=562) {
        $name ="../certificado/tmp/".$vnsol.".pdf"; 
//        $nameweb ="http://multimedia.sapi.gob.ve/marcas/certificados/".$vdir."/".$vnsol.".pdf"; 
        $nameweb ="http://172.16.0.130/marcas/certificados/".$vdir."/".$vnsol.".pdf";
        $smarty->display('encabezado1.tpl');  
        mensajenew('Concedida en Boletin '.$var_doc.'. Presione el Icono PDF para ver el Certificado Electr&oacute;nico...',$nameweb,'C');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
//        $cmd="scp -P 22 www-data@172.16.0.130:/var/www/multimedia/marcas/certificados/".$vdir."/".$vnsol.".pdf  /var/www/apl/sipi/certificado/tmp/";
//        exec($cmd,$salida);
//        $cmdrm="rm ../certificado/tmp/".$vnsol.".pdf";
//        if (is_file($name)) { $smarty->display('encabezado1.tpl');  mensajenew('Certificado Electr&oacute;nico Generado !!! ',$nameweb,'CE');
//                              mensajenew('Certificado Electronico Generado ',$nameweb,'C',$cmdrm);
//                                $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
//                                exec($cmdrm);
//        } else {$smarty->display('encabezado1.tpl');
//              mensajenew('Certificado Electr&oacute;nico No Generado !!! ','javascript:history.back();','N');
//              $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();}
     } else { $smarty->display('encabezado1.tpl');
       mensajenew('Marca Concedida en Boletin '.$var_doc.' (anterior al 562). No posee Certificado Electr&oacute;nico!!! ','m_rptpcertem.php?vopc=1','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
} else {
   $smarty->display('encabezado1.tpl');
   mensajenew('Error al Procesar la Busqueda del Certificado...!!!','m_rptpcertem.php?vopc=1','N');   
   $smarty->display('pie_pag.tpl');
   $sql->disconnect();
   exit(); 
}
   
//Desconexion a la base de datos
$sql->disconnect();

//ob_end_clean(); 
//$pdf->Output();
?>

