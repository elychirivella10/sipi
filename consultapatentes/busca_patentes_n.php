<html>
<head>
 <meta http-equiv="Content-Language" content="es">
 <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta name="generator" content="Bluefish 2.2.10" >
 <meta name="ProgId" content="FrontPage.Editor.Document">
 <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
 
  <script language='javascript' type='text/javascript'> 
  function checkKey(evt){
   if (evt.keyCode == '17')  
     {alert("Comando No Permitido ...!!!");
     return false;}
   return true; }
   
  </script>
</head>

<body onkeydown="return checkKey(event)" bgcolor="#F9F9F9">

<div align="center"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="992" height="2">
      </div>
    </td>
  </tr> 
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
     <td width="100" valign="top">
      <font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <img src="../imagenes/encabezado.png" width="995px" height="52">
      </font>
    </td>
  </tr>
</table>

<table width="100%" align="center" >
  <tr height="30" >
    <td width="5%" class="subtitulo2">
      <b><i><a href="">Inicio</a></i></b>
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://www.sapi.gob.ve" target="blank">Sapi</a></i></b> 
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://correo.sapi.gob.ve" target="blank">Correo</a></i></b>
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://sire.sapi.gob.ve/" target="blank">Sire</a></i></b> 
    </td>
    <td width="10%" class="subtitulo2">
      <b><i><a href="http://www.bicentenariobu.com" target="blank">Banco Bicentenario</a></i></b>
    </td>
    <td width="40%" class="subtitulo1">
		<MARQUEE><b><i>Sistema Automatizado de Marcas, Patentes y Derecho de Autor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Impulsando el Software Libre como parte del Gobierno Electr&oacute;nico</i></b></MARQUEE>
    </td>
  </tr>
</table>

</div>    

<?php 
  error_reporting(E_ERROR); 
?>

<?
$vtipuser=$_GET['vusuario'];
if ($vtipuser==1)
    {$vhomepage='indexfull.php';}
if ($vtipuser==2)
    {$vhomepage='indexmp.php';}
if ($vtipuser==3)
    {$vhomepage='indexbt.php';}
if ($vtipuser==4)
    {$vhomepage='indexe.php';}
if ($vtipuser==5)
    {$vhomepage='indexi.php';}
if ($vtipuser==6)
    {$vhomepage='indexi2.php';}

$vopcion=$_GET["vopc"];
$vnumsol=$_GET["vnsol"];
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varreg1=$_POST["vreg"];
$varsel=$_POST["vsel"];
$vartex1=$_POST["vtex"];
$vartex=strtoupper($vartex1);
$varreg=strtoupper(substr($varreg1,-7,1)).sprintf("%06d",substr($varreg1,1));
$varsol=sprintf("%04d-%06d",$varsol1,$varsol2);

//if ($vtipuser==1) {echo "Usuario Interno";}
//if ($vtipuser==2) {echo "Usuario Externo";}
//if ($vtipuser==3) {echo "Usuario Externo";}
//if ($vtipuser==4) {echo "Usuario Externo";}

if ($varsol=="0000-000000" and $varreg==" 000000")
   {$varsol=$vnumsol;
    $vopcion=1;
   }

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$sql = new mod_db();

//if ($vtipuser==1) {echo "Usuario Interno: $usuario";}
if ($vtipuser==2) {echo "Usuario Externo";}
if ($vtipuser==3) {echo "Usuario Externo";}
if ($vtipuser==4) {echo "Usuario Externo";}

$fecha   = trim(fechahoy());
$subtitulo = "Consulta Interna de Patentes";
?>

  <table width="100%">
   <tr>
    <td width="30%" class="izq2-color">
      <font face="MS Sans Serif" size="-1">Usuario Interno: <?php echo $usuario ?> </font>
    </td>
    <td width="40%" class="cnt-color3">
      <font face="MS Sans Serif" size="-1"><?php echo $subtitulo ?> </font>
    </td>
    <td width="30%" class="der2-color">
      <font face="MS Sans Serif" size="-1"><?php echo $fecha ?> </font>
    </td>
    </tr>
  </table>

<?php
//Verificando conexion
$sql->connection();

if ($vopcion==1)
   {$resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$varsol' and tipo_mp='P' ");
   }

if ($vopcion==2)
   {$resultado=pg_exec("SELECT * FROM stzderec WHERE registro='$varreg' and tipo_mp='P' ");
   }

if (!$resultado) 
   { echo "<hr>";     
     echo "<p align='center'><b>ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!</b>"; 
     echo "<hr>";
     // Desconexion de la Base de datos 
     $sql->disconnect();
     //exit(); 
   }

$filas_found=pg_numrows($resultado); 

if ($filas_found==0) 
   {
   echo "<hr>";     
   echo "<p align='center'><b>ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!</b>\n"; 
   echo "<hr>";
   // Desconexion de la Base de datos 
   $sql->disconnect();
   //exit();
   } 

if ($filas_found!=0) 
   {
$clasifica="";
$reg = pg_fetch_array($resultado);
$varsol=$reg[solicitud];

if (!empty($vnumsol)) {
 $varsol1 = substr($vnumsol,-11,4);
 $varsol2 = substr($vnumsol,-6,6);
} else {
 $vnumsol=$reg[solicitud];
 $varsol1 = substr($vnumsol,-11,4);
 $varsol2 = substr($vnumsol,-6,6);
} 

$nameimage = "../graficos/patentes/di".$varsol1."/".$varsol1.$varsol2.".jpg";

$res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$reg[estatus]'");
$restat = pg_fetch_array($res_estatus);

$res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[pais_resid]' and pais!=''");
$respai = pg_fetch_array($res_pais);

$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$reg[agente]' and agente!=''");
$resage = pg_fetch_array($res_agen);

$res_mod=pg_exec("SELECT * FROM stppatee WHERE nro_derecho='$reg[nro_derecho]' ");
$resmod = pg_fetch_array($res_mod);

$resulanual=pg_exec("SELECT * FROM stpanual WHERE nro_derecho='$reg[nro_derecho]' ORDER BY anualidad");
$resulinve =pg_exec("SELECT * FROM stpinved WHERE nro_derecho='$reg[nro_derecho]' ORDER BY nombre_inv");

if ($reg[tipo_derecho]=='A') {$vtip='INVENCION';}
if ($reg[tipo_derecho]=='C') {$vtip='MEJORA';}
if ($reg[tipo_derecho]=='E') {$vtip='MODELO INDUSTRIAL';}
if ($reg[tipo_derecho]=='G') {$vtip='DISEÑO INDUSTRIAL';}
if ($reg[tipo_derecho]=='B') {$vtip='DIBUJO INDUSTRIAL';}
if ($reg[tipo_derecho]=='D') {$vtip='INTRODUCCION';}
if ($reg[tipo_derecho]=='F') {$vtip='MODELO DE UTILIDAD';}
if ($reg[tipo_derecho]=='V') {$vtip='VARIEDAD VEGETAL';}

$nregis=$reg[registro];
$nsolic=$reg[solicitud];
$nderec=$reg[nro_derecho];
$nagen=$reg[agente];

//$vporc='83%';
$vporc='55%';
?>

<?php 
error_reporting(E_ERROR); 
?>

<table border="0" cellpadding="0" cellspacing="1" width="100%">
  <tr>
    <td class="celda-titulo">Solicitud:</td>  
<?php echo "<td width=$vporc class='celda2'><b>$reg[solicitud]</b></td>";
if ( file($nameimage))
   { echo "<td width='22%' rowspan='9' align='center' style='background-color: #FFFFFF; border: 1 solid #C6DEF2'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='150' height='150'></td></a>"; 
   }
?>
  </tr>
  <tr>
    <td class="celda-titulo">Fecha Solicitud:</td>
<?php echo "<td width=$vporc class='celda2'>$reg[fecha_solic]</td>"; ?> 
  </tr>
  <tr>
    <td class="celda-titulo">Tipo Patente:</td>
<?php echo "<td width=$vporc class='celda2'>$reg[tipo_derecho]-$vtip</td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">Pais:</td>
<?php echo "<td width=$vporc class='celda2'>$reg[pais_resid]-$respai[nombre]</td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">N de Registro:</td>
<?php echo "<td width=$vporc class='celda2'><b>$reg[registro]</b></td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">Fecha Registro:</td>
<?php echo "<td width=$vporc class='celda2'>$reg[fecha_regis]</td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">Fecha Vencim.:</td>
<?php echo "<td width=$vporc class='celda2'>$reg[fecha_venc]</td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">T&iacute;tulo:</td>
<?php echo "<td width='83%' colspan='2' class='celda2'>$reg[nombre]</td>"; ?>
  </tr>
  <tr>
 <? $estatus= $reg[estatus]-2000; ?>
    <td class="celda-titulo">Estatus:</td>
<?php echo "<td width='83%' colspan='2' class='celda2'><b>$estatus -$restat[descripcion]</b></td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">Resumen:</td>

<?php echo "<td width='83%' colspan='2' class='celda2'>$resmod[resumen]</td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">Tramitante/Agente:</td>

<?php
$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente=$nagen");
$regage = pg_fetch_array($res_agen);
if ($reg[agente]<=0)
   { 
   echo "<td width='83%' colspan='2' class='celda2'>$reg[tramitante]</td>"; 
   }
if ($reg[agente]>0)
   {
   echo "<td width='83%' colspan='2' class='celda2'>$reg[tramitante] - Codigo: $reg[agente] $regage[nombre]</td>"; 
   }
?>
  </tr>
  <tr>
    <td class="celda-titulo">Poder No.:</td>
    <?php echo "<td width='83%' colspan='2' class='celda2'>$reg[poder]</td>"; ?>

  </tr>
<?php
  if (($reg[tipo_derecho]=='E') || ($reg[tipo_derecho]=='B') || ($reg[tipo_derecho]=='G')) {
    $resulclas = pg_exec("SELECT * FROM stplocad WHERE nro_derecho='$reg[nro_derecho]'");
    $filasclas = pg_numrows($resulclas); 
    if ($filasclas!=0) {
      $regcla = pg_fetch_array($resulclas);
      $clasifica = $regcla[clasi_locarno]; }
?>   
  <tr>
    <td class="celda-titulo">Clasificacion Locarno:</td>
<?php    
  }
  else {   
    $resulclas = pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho='$reg[nro_derecho]'");
    $filasclas = pg_numrows($resulclas); 
    if ($filasclas!=0) {
      $regclasf = pg_fetch_array($resulclas);
	   for($cont_clai=0;$cont_clai<$filasclas;$cont_clai++) { 
	     $clasifica=$clasifica.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	     $regclasf = pg_fetch_array($resulclas);
	   }
    }   
?>
  <tr>
    <td class="celda-titulo">Clasificacion:</td>
<?php } echo "<td width='83%' colspan='2' class='celda2'>$clasifica</td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">Inform. Adicional:</td>
<?php
$infadi='';
$res_prio=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
$regpri = pg_fetch_array($res_prio);
$res_lice=pg_exec("SELECT * FROM stzliced WHERE nro_derecho='$nderec' ");
$reglic = pg_fetch_array($res_lice);
if (!empty($regpri[prioridad]))
   { 
   $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$regpri[pais_priori]' AND pais!=''");
   $respai = pg_fetch_array($res_pais);
   $infadi='Prioridad: '.$regpri[prioridad].' en: '.$respai[nombre].' de fecha: '.$regpri[fecha_priori];
   }
if (!empty($reglic[licencia]))
   { 
   $infadi=$infadi . 'Licencia: '. $reglic[licencia];
   }
?>
<?php echo "<td width='83%' colspan='2' class='celda2'>$infadi</td>"; ?>
  </tr>
</table>

<p align="center"><b><font size="4" face="Tahoma">Inventor(es)</font></b></p>
<table border='0' width='100%' class="celda1">
<tr><td class="columna-titulo" width='40%'>Nombre</td>
    <td class="columna-titulo" width='20%'>Nacionalidad</td></tr>
<?php
$filas_found=pg_numrows($resulinve); 
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resulinve); 
    $vnombre=$regtmp[nombre_inv];
    $vpais=$regtmp[nacionalidad];
    $resulpais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$vpais' AND pais!=''");
    $regpais = pg_fetch_array($resulpais);
    $vpais = $vpais." - ".$regpais[nombre];
    echo "<tr><td align='left' class='celda2'><small>";
    echo $vnombre; 
    echo "</small></td><td align='left' class='celda2'><small>";
    echo $vpais; 
    echo "</small></td></tr>";
}
?>
</table>



<p align="center"><b><font size="4" face="Tahoma">Anualidades</font></b></p>
<table border='0' width='100%' class="celda1">
<tr><td class="columna-titulo" width='10%'>Anualidad</td>
    <td class="columna-titulo" width='15%'>Fecha Anualidad</td>
    <td class="columna-titulo" width='10%'>Planilla</td>
    <td class="columna-titulo" width='10%'>Tasa</td>
    <td class="columna-titulo" width='10%'>Monto</td>
    <td class="columna-titulo" width='10%'>Multa</td></tr>
<?php
$filas_found=pg_numrows($resulanual); 
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resulanual); 
    $vanual=$regtmp[anualidad];
    $vfecha=$regtmp[fecha_anual];
    $vplani=$regtmp[planilla];
    $vtasa =$regtmp[tasa];
    $vmonto=$regtmp[monto];
    $vind  =$regtmp[ind_multa]; 
    $vmulta=$regtmp[multa];
    echo "<tr><td align='center' width='10%' class='celda2'><small>";
    echo $vanual; 
    echo "</small></td><td align='left' width='15%' class='celda2'><small>";
    echo $vfecha;
    echo "</small></td><td align='left' width='10%' class='celda2'><small>";
    echo $vplani; 
    echo "</small></td><td align='left' width='10%' class='celda2'><small>";
    echo $vtasa;
    echo "</small></td><td align='left' width='10%' class='celda2'><small>";
    echo $vmonto; 
    echo "</small></td><td align='left' width='10%' class='celda2'><small>";
    echo $vmulta; 
    echo "</small></td></tr>";
} 
?>
</table>


<p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
<table border="0" width="100%" class="celda1">
  <tr>
    <td class="columna-titulo">C&oacute;digo</td>
    <td class="columna-titulo">Nombre</td>
    <td class="columna-titulo">Nacionalidad</td>
    <td class="columna-titulo">Domicilio</td>
    <td class="columna-titulo">Indole</td>
    <td class="columna-titulo">Identificacion</td>  
  <!-- <td width="20%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif"><b>Pa&iacute;s
      Residencia</b></font></td> -->
  </tr>
  <?php

$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzsolic.indole, stzsolic.identificacion
       FROM stzottid,stzsolic,stppatee WHERE stzottid.nro_derecho='$nderec'
			                AND stppatee.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) 
     {
      echo "<tr>";
      echo "<td width='10%' class='celda2'><font face='Tahoma'>$reg[titular]</font></td>";
      echo "<td width='30%' class='celda2'><font face='Tahoma'>$reg[nombre]</font></td>";

      $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[nacionalidad]' and pais!=''");
      $respai = pg_fetch_array($res_pais);
      echo "<td width='15%' class='celda2'>$reg[nacionalidad] - $respai[nombre]</td>";
      echo "<td width='20%' class='celda2'>$reg[domicilio]</td>";

      echo "<td width='10%' class='celda2'>$reg[indole]</td>";
      echo "<td width='10%' class='celda2'>$reg[identificacion]</td>";
                  
    //  $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg2[pais_resid]' and pais!=''");
    //  $respai = pg_fetch_array($res_pais);
    //  echo "<td width='20%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>$reg2[pais_resid] - $respai[nombre]</font></td>";
      echo "</tr>";
      $reg = pg_fetch_array($resultado);
     }
  ?>
  </tr>
</table>

<p align="center"><b><font size="4" face="Tahoma">Cronolog&iacute;a de Eventos</font></b></p>
<table border="0" width="100%" class="celda1">
  <tr>
    <td class="columna-titulo">Fecha Evento</td>
    <td class="columna-titulo">Vencimiento Evento</td>
    <td class="columna-titulo">Nro Documento</td>
    <td class="columna-titulo">C&oacute;digo del
    Evento</b></font></td>
    <td class="columna-titulo">Descripci&oacute;n</td>
    <td class="columna-titulo">Fecha de Transacci&oacute;n</td>
    <td class="columna-titulo">Comentarios</td>
    <?php
     if (($vtipuser==1) || ($vtipuser==5) || ($vtipuser==6))
       {echo "<td width='10%' class='columna-titulo'>Usuario</td>";}
    ?>
    <td class="columna-titulo">Documento</td>
  </tr>
  <?php
   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' ORDER BY fecha_event,secuencial");   
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   $imagenresultado = "../imagenes/ver_devolucion.png";
   for($cont=0;$cont<$filas_found;$cont++) 
     { 
        $conpdf=0;
	$evento= $reg[evento]-2000;
	$estatus_ant = $reg[estat_ant]-2000;
	$boletin = $reg[documento];
        $usrcarga = trim($reg['usuario']);
        $controlsec = $reg['secuencial'];

     echo "<tr>";
     echo "<td width='10%' class='celda5'>$reg[fecha_event]</td>";
     echo "<td width='10%' class='celda5'>$reg[fecha_venc]</td>";
     echo "<td width='10%' class='celda5'>$reg[documento]</td>";
     echo "<td width='10%' class='celda5'>$evento </td>";
     echo "<td width='20%' class='celda5'>$reg[desc_evento]</td>";
     echo "<td width='10%' class='celda5'>$reg[fecha_trans]</td>";
     echo "<td width='30%' class='celda5'>$reg[comentario]</td>";
     if (($vtipuser==1) || ($vtipuser==5) || ($vtipuser==6))  
        {echo "<td width='10%' class='celda5'>$reg[usuario]</td>";}

     $imagenresultado = "../imagenes/ver_devolucion.png";
     $conpdf=0;
     if (($evento==122 or $evento==126) AND (($estatus_ant==200 or $estatus_ant==103) ) AND ($boletin>=611)) { 
       if ($estatus_ant==200) { 
         $archivodev = "http://172.16.0.7/documentos/devolucion/patentes/forma/boletin".$boletin."/".$varsol1.$varsol2.".pdf"; } 
       else {
         $archivodev = "http://172.16.0.7/documentos/devolucion/patentes/fondo/boletin".$boletin."/".$varsol1.$varsol2.".pdf"; }         
       echo "<td width='10%' class='celda8'><a href='$archivodev' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
       $conpdf=1;
     }

//Evento 20 - Escritos de Contestacion a Oficios de Devolucion
     if ($evento==20 AND $boletin>=609 AND $usrcarga=='admwebpi' AND ($estatus_ant==118 or $estatus_ant==202 or $estatus_ant==210)) { 
       if ($estatus_ant==202 or $estatus_ant==210) { 
          $archivodev = "http://172.16.0.7/documentos/cdevolucion/patentes/forma/boletin".$boletin."/ecd_".$varsol1.$varsol2.".pdf";
       }  
       else {
          $archivodev = "http://172.16.0.7/documentos/cdevolucion/patentes/fondo/boletin".$boletin."/ecd_".$varsol1.$varsol2.".pdf";
       }         
       echo "<td width='10%' class='celda8'><a href='$archivodev' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
       $conpdf=1;
     }

//Evento 38 - Escritos Prorroga de Contestacion a Oficios de Devolucion
     if ($evento==38 AND $boletin>=609 AND $usrcarga=='admwebpi' AND ($estatus_ant==202)) { 
        $archivodev = "http://172.16.0.7/documentos/prorrogas/patentes/boletin".$boletin."/epd_".$varsol1.$varsol2.".pdf";
        echo "<td width='10%' class='celda8'><a href='$archivodev' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
       $conpdf=1;
     }

//Evento 40 - Escrito de Oposicion

     if ($evento==40 AND $boletin>=609 and $usrcarga=='admwebpi' and ($estatus_ant==8 or $estatus_ant==9 or $estatus_ant==125 or $estatus_ant==130)) { 

       $resulesc = pg_exec("SELECT * FROM stzdocumento WHERE nro_derecho='$nderec' AND evento =2040 AND secuencial = $controlsec AND tipo_mp='P'");   
       $filas_esc=pg_numrows($resulesc);
       $regesc = pg_fetch_array($resulesc);
       $archivoesc = trim($regesc['documento']);
 
       $archivoesc = "http://172.16.0.7/documentos/oposiciones/patentes/boletin".$boletin."/".$archivoesc;
       echo "<td width='10%' class='celda8'><a href='$archivoesc' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
       $conpdf=1;
     }

//Evento 43 - Escrito de Oposicion por Mejor Derecho

     if ($evento==43 AND $boletin>=609 and $usrcarga=='admwebpi') { 

       $resulesc = pg_exec("SELECT * FROM stzdocumento WHERE nro_derecho='$nderec' AND evento =2043 AND secuencial = $controlsec AND tipo_mp='P'");   
       $filas_esc=pg_numrows($resulesc);
       $regesc = pg_fetch_array($resulesc);
       $archivoesc = trim($regesc['documento']);
 
       $archivoesc = "http://172.16.0.7/documentos/opmejorderecho/patentes/boletin".$boletin."/".$archivoesc;
       echo "<td width='10%' class='celda8'><a href='$archivoesc' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
       $conpdf=1;
     }

//Evento 48 - Escrito de Contestacion a Oposicion

     if ($evento==48 AND $boletin>=609 and $usrcarga=='admwebpi' and ($estatus_ant==10)) { 

       $resulesc = pg_exec("SELECT * FROM stzdocumento WHERE nro_derecho='$nderec' AND evento =2048 AND secuencial = $controlsec AND tipo_mp='P'");   
       $filas_esc=pg_numrows($resulesc);
       $regesc = pg_fetch_array($resulesc);
       $archivoesc = trim($regesc['documento']);
 
       $archivoesc = "http://172.16.0.7/documentos/coposicion/patentes/boletin".$boletin."/".$archivoesc;
       echo "<td width='10%' class='celda8'><a href='$archivoesc' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
       $conpdf=1;
     }

//Evento 310 - Escrito de Reconsideracion a Prioridad Extinguida

     if ($evento==310 AND $boletin>=616 and $usrcarga=='admwebpi' and (($estatus_ant==600))) { 

       $resulesc = pg_exec("SELECT * FROM stzdocumento WHERE nro_derecho='$nderec' AND evento =2310 AND secuencial = $controlsec AND tipo_mp='P'");   
       $filas_esc=pg_numrows($resulesc);
       $regesc = pg_fetch_array($resulesc);
       $archivoesc = trim($regesc['documento']);
 
       $archivoesc = "http://172.16.0.7/documentos/recursos/patentes/prioridadex/boletin".$boletin."/".$archivoesc;
       echo "<td width='10%' class='celda8'><a href='$archivoesc' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
       $conpdf=1;
     }


//Evento 310 - Escrito de Reconsideracion a Perencion de Procedimiento Prensa

     if ($evento==310 AND $boletin>=616 and $usrcarga=='admwebpi' and (($estatus_ant==651))) { 

       $resulesc = pg_exec("SELECT * FROM stzdocumento WHERE nro_derecho='$nderec' AND evento =2310 AND secuencial = $controlsec AND tipo_mp='P'");   
       $filas_esc=pg_numrows($resulesc);
       $regesc = pg_fetch_array($resulesc);
       $archivoesc = trim($regesc['documento']);
 
       $archivoesc = "http://172.16.0.7/documentos/recursos/patentes/ppprensa/boletin".$boletin."/".$archivoesc;
       echo "<td width='10%' class='celda8'><a href='$archivoesc' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
       $conpdf=1;
     }


     if ($conpdf==0) { 
        echo "<td width='10%' class='celda5'>&nbsp;&nbsp;</td>";
     }
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
 
  ?>
</table>

<?
}
?>

<? if ($vtipuser==7) { ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="15">
  <tr><td><p align='center'><input type='button' class='boton_blue' value='Imprimir' onclick='window.print();'>&nbsp;&nbsp;
     <font face='Tahoma' ><input type='button' class='boton_blue' value='Salir' onclick='window.close();'></font>
  <br></td></tr>
</tabla>
<?} else { ?> 
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="15">
  <tr><td><p align='center'><a href='<? echo $vhomepage; ?>'>
<font face='Tahoma' ><input type='button' class='boton_blue' value='Realizar otra B&uacute;squeda' name='B2'></font></a>&nbsp;&nbsp;<input type='button' class='boton_blue' value='Imprimir' onclick='window.print();'>&nbsp;&nbsp;<a href="../salir.php">
<font face='Tahoma' ><input type='button' class='boton_blue' value='Salir' name='B3'></font></a><br></td></tr>
</tabla>
<? } ?> 
&nbsp;

<table align="center" border="0" cellpadding="0" cellspacing="0" width="70%" height="15">
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#015B9E"><b>Los datos emitidos por la siguiente consulta son netamente informativos,</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#015B9E"><b>la informaci&oacute;n contenida en la presente p&aacute;gina no obliga ni compromete la responsabilidad del SAPI.</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#015B9E"><b>Por lo anterior, no reemplaza en ning&uacute;n caso los mecanismos legales de notificaci&oacute;n</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#015B9E"><b>y se constituye exclusivamente en una ayuda adicional para los usuarios de la misma. </font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#015B9E"><b>La validez legal de las consultas se notifica a trav&eacute;s del bolet&iacute;n.</font></b></td></tr>
</tabla>

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="15" bgcolor="#666666">
<?
  echo "<tr><td><p align='center'>&nbsp;</td></tr>"; 
?>
</tabla>  

 <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="987" height="4">
      </div>
    </td>
  </tr> 
 </table>

 <div align="center">
 <font size="-2"><I>Desarrollado por: <b>Coordinaci&oacute;n de Inform&aacute;tica - SAPI Rif: G-20008399-9<br/>
Sistema Versi&oacute;n 1.4, desarrollado con Smarty, CSS, HTML, PHP 5, JavaScript y PostgreSQL 8.3 <br/> 
  Caracas - Venezuela - CopyLeft 2005, 2006, 2007, 2010, 2011 / Decreto No. 3.390 <I></font>
 </p>
 </div>

 <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="987" height="4">
      </div>
    </td>
  </tr> 
 </table>

</body>
</html>
