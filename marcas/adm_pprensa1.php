<script language="javascript">
function cerrarwindows3() {
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: adm_pprensa.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2015 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 
<body bgcolor="#FFFFFF"> 

<?php

 // onload="centrarwindows()"
  
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();
$fechahoy= hoy();

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificacion de Conexion 
$sql->connection($usuario);   

$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vcod=$_GET['vcod'];
$vbol=$_GET['vbol'];
$vtot=$_GET['vtot'];
$npub=$_GET['npub'];
$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vcod']=$vcod;
$hiddenvars['vbol']=$vbol;
$hiddenvars['vtot']=$vtot;
$hiddenvars['npub']=$npub;

 if ($vmod=='Buscar/Incluir')  {
   echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>SOLICITUD: $vsol, FACTURA: $vcod</b></font></p>";
 	
   if ($vsol=='-') { 
     echo "<hr>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>INTRODUZCA PRIMERO EL NUMERO DEL EXPEDIENTE ...!!</b></font></p>";
     echo "<hr>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
     exit;
   }
   
   if ($vtot=='0') {
      echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: LA CANTIDAD INGRESADA DE SOLICITUDES DE PATENTES A PUBLICAR POR USTED ES 0 ...!!</b></font></p>";
      echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
      $smarty->display('pie_pag.tpl'); exit();    
     }

   $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud = '$vsol' AND tipo_mp='P'");
   $filas_stat = pg_numrows($resultado);
   if ($filas_stat==0) {
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol NO Existe en la Base de Datos ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();       
   }
   else {
     $regest = pg_fetch_array($resultado);
     $vest = $regest[estatus];  
     if (($vest!=2004) && ($vest!=2005) && ($vest!=2011)) {
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol en Estatus diferente a 4, 5 o 11 ...!!!</b></font></p>";
       echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();       
     }
   }

     $resultado=pg_exec("SELECT * FROM stptmppren WHERE factura = '$vcod'");
     $reg=pg_fetch_array($resultado);
     $filas_registro=pg_numrows($resultado);
   
     if ($filas_registro==$vtot){
      echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: LLEGO AL TOPE DE PUBLICACIONES DE SOLICITUDES SEGUN FACTURA ...!!</b></font></p>";
      echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
      $smarty->display('pie_pag.tpl'); exit();    
     }

   if ($npub=='N') {
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: NO seleccion&oacute; el N&uacute;mero de P&uacute;blicaci&oacute;n a realizar ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();       
   }

   //Validacion de Boletin
   $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.solicitud = '$vsol' AND
                           a.evento in (2201) AND 
                           a.estat_ant in (2002) AND
                           a.documento ='$vbol' AND  
                           b.nro_derecho = a.nro_derecho AND
                           b.tipo_mp='P'");

   $filas_evento = pg_numrows($resultado);
   if ($filas_evento==0) {
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol NO ha sido notificada su Orden de Publicaci&oacute;n en Prensa en el Bolet&iacute;n $vbol ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();       
   }
   $regeve = pg_fetch_array($resultado);
   $vbol = $regeve[documento]; 
   //$vfevb = $regeve[fecha_2meses];  
   $vfevb = $regeve[fecha_venc];  
   $esmayor=compara_fechas($fechahoy,$vfevb);
   //habilitar despues en produccion
   //if ($esmayor==1) {
   //  echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: La presente Solicitud tiene Orden de Publicaci&oacute;n en Prensa en el Bolet&iacute;n No.: $vbol ...!!!</b></font></p>";
   //  echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>Y la Fecha tope para para Publicar en Prensa era hasta el $vfevb ...!!!</b></font></p>";
   //  echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
   //  exit();       
   //}

   //if ($npub=='1') { 
   //  $extemporanea="N";
   //  $tipo_plazo = "C";
   //  $plazo_ley = 1;
   //  $fechapub1 = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/");
   //  $esmayor=compara_fechas($fechapub1,$vfevb);
   //  if ($esmayor==1) { $extemporanea="S"; }
   //  //echo "<input type='hidden' name='vext' value='{$extemporanea}'>";
   //}

   //if ($npub=='4') { 
   //  $extemporanea="N";
   //  $tipo_plazo = "C";
   //  $plazo_ley = 1;
   //  $fechapub1 = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/");
   //  $esmayor=compara_fechas($fechapub1,$vfevb);
   //  if ($esmayor==1) { $extemporanea="S"; }
   //  $plazo_ley = 12;
   //  $fechapub2 = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/");
   //  $esmayor=compara_fechas($fechapub2,$vfevb);
   //  if ($esmayor==1) { $extemporanea="S"; }
   //  $plazo_ley = 23;
   //  $fechapub3 = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/");
   //  $esmayor=compara_fechas($fechapub3,$vfevb);
   //  if ($esmayor==1) { $extemporanea="S"; }
   //  echo "<input type='hidden' name='vext' value='{$extemporanea}'>";
   //}

   if ($npub=='1') {
     $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.solicitud = '$vsol' AND
                           a.evento in (2022) AND 
                           a.estat_ant in (2004) AND
                           b.nro_derecho = a.nro_derecho AND
                           b.tipo_mp='P'");
     $filas_pub = pg_numrows($resultado);
     if ($filas_pub!=0) {
       $regpub = pg_fetch_array($resultado);
       $vfev = $regpub[fecha_event];  
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol con PRIMERA Publicaci&oacute;n en Prensa el d&iacute;a $vfev ...!!!</b></font></p>";
       echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();       
     }
   }

   if ($npub=='2') {
     $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.solicitud = '$vsol' AND
                           a.evento in (2023) AND 
                           a.estat_ant in (2005) AND
                           b.nro_derecho = a.nro_derecho AND
                           b.tipo_mp='P'");
     $filas_pub = pg_numrows($resultado);
     if ($filas_pub!=0) {
       $regpub = pg_fetch_array($resultado);
       $vfev = $regpub[fecha_event];  
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol con SEGUNDA Publicaci&oacute;n en Prensa el d&iacute;a $vfev ...!!!</b></font></p>";
       echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();       
     }
   }

   if ($npub=='3') {
     $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.solicitud = '$vsol' AND
                           a.evento in (2031) AND 
                           a.estat_ant in (2011) AND
                           b.nro_derecho = a.nro_derecho AND
                           b.tipo_mp='P'");
     $filas_pub = pg_numrows($resultado);
     if ($filas_pub!=0) {
       $regpub = pg_fetch_array($resultado);
       $vfev = $regpub[fecha_event];  
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol con TERCERA Publicaci&oacute;n en Prensa el d&iacute;a $vfev ...!!!</b></font></p>";
       echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();       
     }
   }

   $resultado=pg_exec("SELECT * FROM stppagopren WHERE solicitud = '$vsol'");
   $filas_pub = pg_numrows($resultado);
   if ($filas_pub!=0) {
     $regpub = pg_fetch_array($resultado);
     $vfev = $regpub[fecha_event];  
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol YA asociada a otra Factura ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();       
   }
   
   //$resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
   //                     WHERE b.solicitud = '$vsol' AND
   //                        a.evento in (2201) AND 
   //                        a.estat_ant in (2002) AND
   //                        a.documento ='$vbol' AND  
   //                        b.nro_derecho = a.nro_derecho AND
   //                        b.tipo_mp='P'");

   //$filas_evento = pg_numrows($resultado);
   //if ($filas_evento==0) {
   //  echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol NO ha sido notificada su Orden de Publicaci&oacute;n en Prensa en el Bolet&iacute;n $vbol ...!!!</b></font></p>";
   //  echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
   //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();       
   //}
   //$regeve = pg_fetch_array($resultado);
   //$vbol = $regeve[documento]; 
   //$vfev = $regeve[fecha_venc];  
   
   //$esmayor=compara_fechas($fechahoy,$vfev);
   //if ($esmayor==1) {
   //  echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: La presente Solicitud tiene Orden de Publicaci&oacute;n en Prensa en el Bolet&iacute;n No.: $vbol ...!!!</b></font></p>";
   //  echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>Y La Fecha tope para para Publicar en Prensa era hasta el $vfev ...!!!</b></font></p>";
   //  echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
   //  exit();       
   //}
 	
   if ($npub=='1') { $valest = 2004; }
   if ($npub=='2') { $valest = 2005; }
   if ($npub=='3') { $valest = 2011; }
   if ($npub=='4') { $valest = 2004; }

   $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud = '$vsol' AND solicitud!='0000-000000' AND
                           estatus ='$valest' AND tipo_mp='P'");
  
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: No Existe el No. de Solicitud o NO esta en el Estatus Indicado ...!!!</b></font></p>"; 
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     $smarty->display('pie_pag.tpl'); exit();       
   }
   else {   
       ?>
       <form action="p_gbpagopren.php" name="formtitular" method="POST" >

       <?php
        $vsol = $reg[solicitud]; 
        
   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='vbol' value='{$vbol}'>";
   echo "<input type='hidden' name='vtot' value='{$vtot}'>";
   echo "<input type='hidden' name='npub' value='{$npub}'>";
   echo "<input type='hidden' name='vext' value='{$extemporanea}'>";
         
$varsol=$reg[solicitud];

//imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
$varsolj=$varsol1.$varsol2;
$nameimage="../graficos/patentes/di".$varsol1."/".$varsolj.".jpg";

$res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$reg[estatus]'");
$restat = pg_fetch_array($res_estatus);

$res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[pais_resid]' and pais!=''");
$respai = pg_fetch_array($res_pais);

if ($reg['tipo_derecho']=='A') {$vtip='INVENCION';}
if ($reg['tipo_derecho']=='G') {$vtip='DISEÑO INDUSTRIAL';}
if ($reg['tipo_derecho']=='F') {$vtip='MODELOS DE UTILIDAD';}
if ($reg['tipo_derecho']=='E') {$vtip='MODELO INDUSTRIAL';}
if ($reg['tipo_derecho']=='B') {$vtip='DIBUJO INDUSTRIAL';}
if ($reg['tipo_derecho']=='V') {$vtip='VARIEDAD VEGETAL';}
if ($reg['tipo_derecho']=='C') {$vtip='MEJORA';}
if ($reg['tipo_derecho']=='D') {$vtip='INDUCCION';}

$nregis=$reg[registro];
$nsolic=$reg[solicitud];
$nderec=$reg[nro_derecho];
$nagen=trim($reg[agente]);

echo "<input type='hidden' name='vder' value='{$nderec}'>"; 

if (empty($nagen)) { $nagen=0; } 
$vporc='83%';
if ($reg[modalidad]!="D")
   {$vporc='55%';} 

?>

<table border="0" cellpadding="0" cellspacing="1" width="100%">
  <tr>
    <td width="17%" class='celda-titulo'><b>Solicitud:</b></td>
<?php echo "    <td width=$vporc class='celda2'><b>$reg[solicitud]</b></td>"; 
if ( file($nameimage))
   { echo "  <td width='22%' rowspan='6' class='celda2'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='150' height='150'></td></a>"; 
   }
?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Fecha Solicitud:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$reg[fecha_solic]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Tipo Patente:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$reg[tipo_derecho]-$vtip</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Pais:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$reg[pais_resid]-$respai[nombre]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Titulo:</b></td>
<?php echo "    <td width='83%' colspan='2' class='celda2'>$reg[nombre]</td>"; ?>
  </tr>
  <tr>
 <? $estatus= $reg[estatus]-2000; ?>
    <td width="17%" class='celda-titulo'><b>Estatus:</b></td>
<?php echo "    <td width='83%' colspan='2' class='celda2'><b>$estatus -$restat[descripcion]</b></td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Resumen:</b></td>

<?php
$res_dist=pg_exec("SELECT * FROM stppatee WHERE nro_derecho='$nderec' ");
$regdis = pg_fetch_array($res_dist);
$resumen=$regdis[resumen];
?>

<?php echo "    <td width='83%' colspan='2' class='celda2'>$resumen</td>"; ?>
  </tr>

<?php
  $reg[poder] = trim($reg[poder]);
  if (!empty($reg[poder])) { ?>
  <tr>
    <td width="17%" class='celda-titulo'><b>Poder No.:</b></td>
<?php echo "    <td width='83%' colspan='2' class='celda2'>$reg[poder]</td>"; ?>
  </tr>
<?php  } ?>
  <tr>
    <td width="17%" class='celda-titulo'><b>Tramitante/Agente:</b></td>

<?php
$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente=$nagen");
$regage = pg_fetch_array($res_agen);
if ($reg[agente]<=0)
   { 
   echo "    <td width='83%' colspan='2' class='celda2'>$reg[tramitante]</td>"; 
   }
if ($reg[agente]>0)
   {
   echo "    <td width='83%' colspan='2' class='celda2'>$reg[tramitante] - Codigo: $reg[agente] $regage[nombre]</td>"; 
   }
?>
  </tr>

<?php
$infadi='';
$res_prio=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho=$nsolic");
$regpri = pg_fetch_array($res_prio);
$res_lice=pg_exec("SELECT * FROM stzliced WHERE nro_derecho=$nderec ");
$reglic = pg_fetch_array($res_lice);
if (!empty($regpri[prioridad]))
   { 
   $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$regpri[pais_priori]' and pais!=''");
   $respai = pg_fetch_array($res_pais);
   $infadi='Prioridad: '.$regpri[prioridad].' en: '.$respai[nombre].' de fecha: '.$regpri[fecha_priori];
   }
if (!empty($reglic[licencia]))
   { 
   $infadi=$infadi . 'Licencia: '. $reglic[licencia];
   }
?>

  </tr>
</table>

<p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="10%" class='columna-titulo'><b>C&oacute;digo</b></td>
    <td width="30%" class='columna-titulo'><b>Nombre</b></td>
    <td width="20%" class='columna-titulo'><b>Pa&iacute;s</b></td>
    <td width="20%" class='columna-titulo'><b>Domicilio</b></td>
  </tr>
  <?php

$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic WHERE stzottid.nro_derecho='$nderec'
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) 
     {
      echo "<tr>";
      echo "<td width='10%' class='celda2'>$reg[titular]</td>";
      echo "<td width='30%' class='celda2'>$reg[nombre]</td>";

      $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[nacionalidad]' and pais!=''");
      $respai = pg_fetch_array($res_pais);
      echo "<td width='20%' class='celda2'>$reg[nacionalidad] - $respai[nombre]</td>";
      echo "<td width='20%' class='celda2'>$reg[domicilio]</td>";
      echo "</tr>";
      $reg = pg_fetch_array($resultado);
     }
  ?>
  </tr>
</table>

<p align="center"><b><font size="4" face="Tahoma">Datos de la Publicaci&oacute;n en Bolet&iacute;n </font></b></p>
<table border="0" cellpadding="1" cellspacing="1" width="100%">
  <tr>
    <td width="10%" class='columna-titulo'>Fecha Evento</td>
    <td width="10%" class='columna-titulo'>Vencimiento Evento</td>
    <td width="10%" class='columna-titulo'>N Documento</td>
    <td width="10%" class='columna-titulo'>C&oacute;digo del Evento</td>
    <td width="20%" class='columna-titulo'>Descripci&oacute;n</td>
    <td width="10%" class='columna-titulo'>Fecha de Transacci&oacute;n</td>
    <td width="30%" class='columna-titulo'>Comentarios</td>
  </tr>
  <?php
   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento in (2201) AND documento=$vbol AND estat_ant in (2002)");   
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) { 
     $evento     = $reg[evento]-2000;
     $vfechavenc = $reg[fecha_venc];
     echo "<tr>";
     echo "<td width='10%' class='celda2'>$reg[fecha_event]</td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_venc]</td>";
     echo "<td width='10%' class='celda2'>$reg[documento]</td>";
     echo "<td width='10%' class='celda2'>$evento</td>";
     echo "<td width='20%' class='celda2'>$reg[desc_evento]</td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_trans]</td>";
     echo "<td width='30%' class='celda2'>$reg[comentario]</td>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
   }
   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento in (2022) AND estat_ant in (2004)");   
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) { 
     $evento= $reg[evento]-2000;
     $prifecha = $reg[fecha_event];
     echo "<tr>";
     echo "<td width='10%' class='celda2'>$reg[fecha_event]</td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_venc]</td>";
     echo "<td width='10%' class='celda2'>$reg[documento]</td>";
     echo "<td width='10%' class='celda2'>$evento</td>";
     echo "<td width='20%' class='celda2'>$reg[desc_evento]</td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_trans]</td>";
     echo "<td width='30%' class='celda2'>$reg[comentario]</td>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
   }
   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento in (2023) AND estat_ant in (2005)");   
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) { 
     $evento= $reg[evento]-2000;
     $segfecha = $reg[fecha_event];
     echo "<tr>";
     echo "<td width='10%' class='celda2'>$reg[fecha_event]</td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_venc]</td>";
     echo "<td width='10%' class='celda2'>$reg[documento]</td>";
     echo "<td width='10%' class='celda2'>$evento</td>";
     echo "<td width='20%' class='celda2'>$reg[desc_evento]</td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_trans]</td>";
     echo "<td width='30%' class='celda2'>$reg[comentario]</td>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
   }
   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento in (2031) AND estat_ant in (2011)");   
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) { 
     $evento= $reg[evento]-2000;
     $terfecha = $reg[fecha_event];
     echo "<tr>";
     echo "<td width='10%' class='celda2'>$reg[fecha_event]</td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_venc]</td>";
     echo "<td width='10%' class='celda2'>$reg[documento]</td>";
     echo "<td width='10%' class='celda2'>$evento</td>";
     echo "<td width='20%' class='celda2'>$reg[desc_evento]</td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_trans]</td>";
     echo "<td width='30%' class='celda2'>$reg[comentario]</td>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
   }
  ?>
</table>
<br>

<?php
   $tipo_plazo = "H";
   //Primera Publicacion
   $plazo_ley = 1;
   $tiempolegal="S";
   $horactual=hora(); //echo "hora $horactual ";
   $horactual1=$horactual;
   //$horatope = "12:00:00 PM";
   $topehora  = Compara_Hora($horactual,$horatope); 
   //if ($horactual<='13:30:00 PM') { 
   if ($topehora==1) { 
     $fechapub1 = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/"); }
   else {
     $plazo_ley = 2;
     $tiempolegal="N";
     $horactual1 = "08:30:00 AM";
     $fechapub1 = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/");
   }
   $vext1="No"; //echo "fechas $fechapub1,$vfechavenc ";
   $esmayor=compara_fechas($fechapub1,$vfechavenc);
   if ($esmayor==1) { $vext1="Si"; }
   //Segunda Publicacion
   //$plazo_ley = 12;
   $plazo_ley = 10;
   //if ($tiempolegal=="N") { $plazo_ley = $plazo_ley + 1; } else { $plazo_ley = $plazo_ley + 2; }
   $plazo_ley = $plazo_ley + 1; 
   $fechapub2 = calculo_fechas($fechapub1,$plazo_ley,$tipo_plazo,"/");
   $vext2="N";
   $esmayor=compara_fechas($fechapub2,$vfechavenc);
   if ($esmayor==1) { $vext2="Si"; }
   //Tercera Publicacion
   //$plazo_ley = 23;
   $plazo_ley = 10;
   //if ($tiempolegal=="N") { $plazo_ley = $plazo_ley + 1; } else { $plazo_ley = $plazo_ley + 2; }
   $plazo_ley = $plazo_ley + 1;
   $fechapub3 = calculo_fechas($fechapub2,$plazo_ley,$tipo_plazo,"/");
   $vext3="N";
   $esmayor=compara_fechas($fechapub3,$vfechavenc);
   if ($esmayor==1) { $vext3="Si"; }

   echo "<p align='center'><b><font size='4' face='Tahoma'>Fechas de Publicaci&oacute;n en Prensa Digital</font></b></p>";
   echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'>";
   echo "<tr>";
   echo "<table border='0' cellpadding='0' cellspacing='1' width='100%'>";
   echo "<tr>";
   echo " <td width='17%' class='celda-titulo'><b>Primera Publicaci&oacute;n:</b></td>";
   echo "   <td width='83' class='celda2'><input type='text' name='fechapub1' {$modo} size='8' value='{$fechapub1}' readonly='readonly'>";
   echo " <td width='17%' class='celda-titulo'><b>Segunda Publicaci&oacute;n:</b></td>";
   echo "   <td width='83' class='celda2'><input type='text' name='fechapub2' {$modo} size='8' value='{$fechapub2}' readonly='readonly'>";   
   echo " <td width='17%' class='celda-titulo'><b>Tercera Publicaci&oacute;n:</b></td>";
   echo "   <td width='83' class='celda2'><input type='text' name='fechapub3' {$modo} size='8' value='{$fechapub3}' readonly='readonly'>";
   echo "</td>";
   echo "</tr>";

   //echo "<tr>";
   //echo " <td width='17%' class='celda-titulo'><b>Segunda Publicacion:</b></td>";
   //echo "   <td width='83' class='celda2'><input type='text' name='fechapub2' {$modo} size='8' value='{$fechapub2}' readonly='readonly'>Extemporanea:<input type='text' name='vext1' {$modo} size='1' value='{$vext1}' readonly='readonly'></td>";
   //echo "</tr>";
   //echo "<tr>";
   //echo " <td width='17%' class='celda-titulo'><b>Tercera Publicacion:</b></td>";
   //echo "   <td width='83' class='celda2'><input type='text' name='fechapub3' {$modo} size='8' value='{$fechapub3}' readonly='readonly'>Extemporanea:<input type='text' name='vext1' {$modo} size='1' value='{$vext1}' readonly='readonly'></td>";
   //echo "</tr>";

   echo "</tr>";
   echo "</table>";
   echo "<br>";
   echo "<p align='center'>";
   echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/boton_guardar_azul.png' alt='Save' align='middle' border='0' />&nbsp
                           <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
   $smarty->display('pie_pag.tpl');
   exit;
   }
} 

 if ($vmod=='Buscar/Eliminar') {
   echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>FACTURA: $vcod</b></font></p>";

   $resultado=pg_exec("SELECT stptmppren.solicitud, nombre FROM stzderec, stptmppren 
                       WHERE  factura = '$vcod'  AND stzderec.tipo_mp='P' 
                       AND stzderec.solicitud = stptmppren.solicitud");
                       
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="p_gbpagopren.php" name="formtitular" method="post"> 
   <?php 

   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='vbol' value='{$vbol}'>";
   echo "<input type='hidden' name='vtot' value='{$vtot}'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   
   echo "<p align='center'><b>SELECCIONE LAS SOLICITUDES QUE DESEA ELIMINAR:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font>Sel</td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>SOLICITUD</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>TITULO</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'> <input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><small>$reg[solicitud]</small></font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'><small>$reg[nombre]</small></font></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[solicitud]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre]'>";

     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUN NUMERO DE SOLICITUD ASOCIADO</p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows3()'></font></p>";
   }
   else { 
     echo "<p align='center'><font color='#0000FF'>";
     echo "<p align='center'>
           <input type='image' name='eliminar' value='Eliminar' src='../imagenes/boton_eliminar_rojo.png' align='middle' border='0' />&nbsp
           <input type='image' name='aceptar' value='Salir' onclick='cerrarwindows3()' src='../imagenes/boton_salir_rojo.png' align='middle' border='0' />
           </p>";
   }
   echo "</form>";
  }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
