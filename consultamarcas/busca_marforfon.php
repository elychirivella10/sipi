<html>
<head>
 <meta http-equiv="Content-Language" content="es">
 <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta name="generator" content="Bluefish 2.2.3" >
 <meta name="ProgId" content="FrontPage.Editor.Document">
 <title>SIPI - Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
 
  <script language='javascript' type='text/javascript'> 
  function checkKey(evt){
   if (evt.keyCode == '17')  
     {alert("Comando No Permitido ...!!!");
     return false;}
   return true; }
   
  </script>
 
</head>

<!-- <body bgcolor="#D8E6FF"> -->
<body onkeydown="return checkKey(event)" bgcolor="#F9F9F9">

<?
  $lastupdate=$_GET['lastupdate'];
?>

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
        <img src="../imagenes/cintillo2015.png" width="100%" height="52"> 
        <!-- <img src="../imagenes/topesapiplano_2014.png" width="100%" height="200"> -->
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
    {$vhomepage='indexforfon.php';}
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
$urole   = trim($_SESSION['usuario_rol']);
$sql = new mod_db();

//if ($vtipuser==1) {echo "Usuario Interno: $usuario";}
if ($vtipuser==2) {echo "Usuario Externo";}
if ($vtipuser==3) {echo "Usuario Externo";}
if ($vtipuser==4) {echo "Usuario Externo";}

$fecha   = trim(fechahoy());
$subtitulo = "Consulta Decisi&oacute;n nuevo Procedimiento Forma/Fondo de Marcas";
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
   {$resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud='$varsol' and tipo_mp='M' ");
   }

if ($vopcion==2)
   {$resultado=pg_exec("SELECT * FROM stzderec WHERE registro='$varreg' and tipo_mp='M' ");
   }

if (!$resultado) 
   { echo "<hr>";     
     echo "<p align='center'><b>ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!</b>"; 
     echo "<hr>";
     //pg_close($conexdb);
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
   //pg_close($conexdb); 
   //exit();
   } 

if ($filas_found!=0) 
   {
$reg = pg_fetch_array($resultado);
$varsol=$reg[solicitud];

//$nameimage="../graficos/marcas/ef".$varsol1."/".$varsol.".jpg";

if (!empty($vnumsol)) {
 $varsol1 = substr($vnumsol,-11,4);
 $varsol2 = substr($vnumsol,-6,6);
} else {
 $vnumsol=$reg[solicitud];
 $varsol1 = substr($vnumsol,-11,4);
 $varsol2 = substr($vnumsol,-6,6);
} 

//$nameimage=ver_imagen($varsol1,$varsol2,'M');
$nameimage = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".jpg";
$nameimage_may= "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".JPG";

$res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$reg[estatus]'");
$restat = pg_fetch_array($res_estatus);

$res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[pais_resid]' and pais!=''");
$respai = pg_fetch_array($res_pais);

$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$reg[agente]' and agente!=''");
$resage = pg_fetch_array($res_agen);

$res_mod=pg_exec("SELECT * FROM stmmarce WHERE nro_derecho='$reg[nro_derecho]' ");
$resmod = pg_fetch_array($res_mod);

if ($resmod[modalidad]=='D') {$vmod='DENOMINATIVA';}
if ($resmod[modalidad]=='M') {$vmod='MIXTA';}
if ($resmod[modalidad]=='G') {$vmod='GRAFICA';}

if ($reg[tipo_derecho]=='M') {$vtip='MARCA DE PRODUCTO';}
if ($reg[tipo_derecho]=='N') {$vtip='NOMBRE COMERCIAL';}
if ($reg[tipo_derecho]=='L') {$vtip='LEMA COMERCIAL';}
if ($reg[tipo_derecho]=='S') {$vtip='MARCA DE SERVICIO';}
if ($reg[tipo_derecho]=='C') {$vtip='MARCA COLECTIVA';}
if ($reg[tipo_derecho]=='D') {$vtip='DENOMINACION COMERCIAL';}
if ($reg[tipo_derecho]=='O') {$vtip='DENOMINACION DE ORIGEN';}

if ($$resmod[ind_claseni]=='N') {$vcla='NACIONAL';}
if ($$resmod[ind_claseni]=='I') {$vcla='INTERNACIONAL';}

$nregis=$reg[registro];
$nsolic=$reg[solicitud];
$nderec=$reg[nro_derecho];
$nagen=$reg[agente];
$poder=trim($reg[poder]); 
$vporc='83%';
if ($reg[modalidad]!="D")
   {$vporc='55%';} 

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
   } else {
     if ( file($nameimage_may))
     { echo "<td width='22%' rowspan='9' align='center' style='background-color: #FFFFFF; border: 1 solid #C6DEF2'><a href='$nameimage_may' target='_blank'><img border='0' src=$nameimage_may width='150' height='150'></td></a>"; 
     }
   }
?>
  </tr>
  <tr>
    <td class="celda-titulo">Fecha Solicitud:</td>
<?php echo "<td width=$vporc class='celda2'>$reg[fecha_solic]</td>"; ?> 
  </tr>
  <tr>
    <td class="celda-titulo">Tipo Marca:</td>
<?php echo "<td width=$vporc class='celda2'>$reg[tipo_derecho]-$vtip</td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">Modalidad:</td>
<?php echo "<td width=$vporc class='celda2'>$resmod[modalidad]-$vmod</td>"; ?>
  </tr>
<!--  <tr>
    <td class="celda-titulo">Pais:</td>
<?php echo "<td width=$vporc class='celda2'>$reg[pais_resid]-$respai[nombre]</td>"; ?>
  </tr> -->
  <tr>
    <td class="celda-titulo">Clase:</td>
<?php echo "<td width=$vporc class='celda2'>$resmod[clase]$vcla</td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">Fecha Publicaci&oacute;n:</td>
<?php echo "<td width=$vporc class='celda2'>$reg[fecha_publi]</td>"; ?>
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
    <td class="celda-titulo">Nombre:</td>
<?php echo "<td width='83%' colspan='2' class='celda2'>$reg[nombre]</td>"; ?>
  </tr>
  <tr>
 <? $estatus= $reg[estatus]-1000; ?>
    <td class="celda-titulo">Estatus:</td>
<?php echo "<td width='83%' colspan='2' class='celda2'><b>$estatus -$restat[descripcion]</b></td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">Distingue:</td>

<?php
//$res_dist=pg_exec("SELECT * FROM stmmarce WHERE nro_derecho='$nderec'");
//$regdis = pg_fetch_array($res_dist);
?>

<?php echo "<td width='83%' colspan='2' class='celda2'>$resmod[distingue]</td>"; ?>
  </tr>
  <tr>
    <td class="celda-titulo">Tramitante/Agente:</td>

<?php
//$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente=$nagen");
//$regage = pg_fetch_array($res_agen);
//if ($reg[agente]<=0)
//   { 
//   echo "<td width='83%' colspan='2' class='celda2'>$reg[tramitante]</td>"; 
//   }
//if ($reg[agente]>0)
//   {
//   echo "<td width='83%' colspan='2' class='celda2'>$reg[tramitante] - Codigo: $reg[agente] $regage[nombre]</td>"; 
//   }
 //echo "$nagen,trim($reg[tramitante]),$poder";
 $gestor = agente_tramp($nagen,trim($reg[tramitante]),$poder);    
 echo "<td width='83%' colspan='2' class='celda2'>$gestor</td>";
   
?>
  </tr>

  <tr>
    <td class="celda-titulo">Poder No.:</td>
    <?php echo "<td width='83%' colspan='2' class='celda2'>$reg[poder]</td>"; ?>

  </tr>

  <tr>
    <td class="celda-titulo">Desc. Etiqueta:</td>
    <?php
      $reg_etq=pg_exec("SELECT * FROM stmlogos WHERE nro_derecho='$reg[nro_derecho]' ");
      $regetq = pg_fetch_array($reg_etq);
      echo "<td width='83%' colspan='2' class='celda2'>$regetq[descripcion]</td>"; 
    ?>
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
   $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$regpri[pais_priori]' and pais!=''");
   $respai = pg_fetch_array($res_pais);
   $infadi='Prioridad: '.$regpri[prioridad].' en: '.$respai[nombre].' de fecha: '.$regpri[fecha_priori];
   }
if (!empty($reglic[licencia]))
   { 
   $infadi=$infadi . 'Licencia: '. $reglic[licencia];
   }
   //cellpadding="0" cellspacing="0" 
?>
<?php echo "<td width='83%' colspan='2' class='celda2'>$infadi</td>"; ?>
  </tr>
</table>

<p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
<table border="0" width="100%" class="celda1">
  <tr>
    <td class="columna-titulo">C&oacute;digo</td>
    <td class="columna-titulo">Nombre</td>
    <td class="columna-titulo">Domicilio</td>
    <td class="columna-titulo">Pa&iacute;s</td>
    <td class="columna-titulo">Indole</td>
    <td class="columna-titulo">Identificacion</td>  
  <!-- <td width="20%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif"><b>Pa&iacute;s
      Residencia</b></font></td> -->
  </tr>
  <?php

$resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzsolic.indole, stzsolic.identificacion
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
      echo "<td width='20%' class='celda2'>$reg[domicilio]</td>";
      echo "<td width='15%' class='celda2'>$reg[nacionalidad] - $respai[nombre]</td>";
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
    <td class="columna-titulo">Doc</td>
  </tr>
  <?php
   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' order by fecha_event,secuencial");   
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   // bgcolor='#faf9de' 
   for($cont=0;$cont<$filas_found;$cont++) 
     { 
	$evento= $reg[evento]-1000;
	$estatus_ant = $reg[estat_ant]-1000;
	$boletin = $reg[documento];
     echo "<tr>";
     echo "<td width='10%' class='celda8'>$reg[fecha_event]</td>";
     echo "<td width='10%' class='celda8'>$reg[fecha_venc]</td>";
     echo "<td width='10%' class='celda8'>$reg[documento]</td>";
     echo "<td width='10%' class='celda8'>$evento </td>";
     echo "<td width='20%' class='celda8'>$reg[desc_evento]</td>";
     echo "<td width='10%' class='celda8'>$reg[fecha_trans]</td>";
     echo "<td width='30%' class='celda8'>$reg[comentario]</td>";
     if (($vtipuser==1) || ($vtipuser==5) || ($vtipuser==6))  
        {echo "<td width='10%' class='celda8'>$reg[usuario]</td>";}
     $imagenresultado = "../imagenes/ver_devolucion.png";
     if (($evento==122) AND (($estatus_ant==200) || ($estatus_ant==116)) AND ($boletin>=587)) { 
       if ($estatus_ant==200) { 
         $archivodev = "../documentos/devueltas/marcas/forma/boletin".$boletin."/".$varsol1.$varsol2.".pdf"; } 
       else {
         $archivodev = "../documentos/devueltas/marcas/fondo/boletin".$boletin."/".$varsol1.$varsol2.".pdf"; }         
     //if (is_file($name)) {
     //  echo "<td align='left'><a href='$name' target='_blank'><img border='1' src='$imagenresultado' width='80' height='80'></a>";
       echo "<td width='10%' class='celda8'><a href='$archivodev' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
     }
     else {
       echo "<td width='10%' class='celda8'>&nbsp;&nbsp;</td>";
     }
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
 
  ?>
</table>

<p align="center"><b><font size="4" face="Tahoma">Decisi&oacute;n cargada nuevo Procedimiento Forma/Fondo</font></b></p>
<table border="0" width="100%" class="celda1">
  <tr>
    <td class="columna-titulo">Evento</td>
    <td class="columna-titulo">Fecha</td>
    <td class="columna-titulo">Hora</td>
    <td class="columna-titulo">Usuario</td>
    <td class="columna-titulo">Comentario</td>
  </tr>
  <?php

$resultado = pg_exec("SELECT * FROM stmforfon WHERE nro_derecho='$nderec'");
$filas_found=pg_numrows($resultado);
$reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) 
     {
      echo "<tr>";
      $codeve = $reg[evento]-1000;
      echo "<td width='10%' class='celda2'><font face='Tahoma'>$codeve</font></td>";
      echo "<td width='15%' class='celda2'><font face='Tahoma'>$reg[fecha_trans]</font></td>";
      echo "<td width='15%' class='celda2'><font face='Tahoma'>$reg[hora]</font></td>";
      echo "<td width='20%' class='celda2'><font face='Tahoma'>$reg[usuario]</font></td>";
      if ($reg[evento]==1054) { 
        $res_det=pg_exec("SELECT * FROM stmdtforfon WHERE nro_derecho='$nderec'");
        $resdet = pg_fetch_array($res_det);
        echo "<td width='40%' class='celda2'>$resdet[comentario]</td>";
      } 
      else {
        echo "<td width='40%' class='celda2'></td>";
      }
                  
    //  $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg2[pais_resid]' and pais!=''");
    //  $respai = pg_fetch_array($res_pais);
    //  echo "<td width='20%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>$reg2[pais_resid] - $respai[nombre]</font></td>";
      echo "</tr>";
      $reg = pg_fetch_array($resultado);
     }
  ?>
  </tr>
</table>

<?
}
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="15">
  <tr><td><p align='center'><a href='<? echo $vhomepage; ?>'>
<font face='Tahoma' ><input type='button' class='boton_blue' value='Realizar otra B&uacute;squeda' name='B2'></font></a>&nbsp;&nbsp;<input type='button' class='boton_blue' value='Imprimir' onclick='window.print();'>&nbsp;&nbsp;<a href="../salir.php">
<font face='Tahoma' ><input type='button' class='boton_blue' value='Salir' name='B3'></font></a><br></td></tr>
</tabla>
&nbsp;

<table align="center" border="0" cellpadding="0" cellspacing="0" width="70%" height="15">
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#015B9E"><b>Los datos emitidos por la siguiente consulta son netamente informativos, uso Interno para los examinadores de Marcas</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#015B9E"><b>la informaci&oacute;n contenida en la presente p&aacute;gina no obliga ni compromete la responsabilidad del SAPI.</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#015B9E"><b>Por lo anterior, no reemplaza en ning&uacute;n caso los mecanismos legales de notificaci&oacute;n</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#015B9E"><b>y se constituye exclusivamente en una ayuda adicional para los usuarios de la misma. </font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#015B9E"><b>La validez legal de las consultas se notifica a trav&eacute;s del bolet&iacute;n.</font></b></td></tr>
</tabla>

 <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="100%" height="4">
      </div>
    </td>
  </tr> 
 </table>

 <div align="center" class="pie1">
 <font size="-2"><I>Desarrollado por: <b>Coordinaci&oacute;n de Inform&aacute;tica - SAPI Rif: G-20008399-9<br/>
Sistema Versi&oacute;n 1.4, desarrollado con Smarty, CSS, HTML, PHP 5, JavaScript y PostgreSQL 8.3 <br/> 
  Caracas - Venezuela - CopyLeft 2005 - 2013 / Decreto No. 3.390 <I></font>
 </div> 

 <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="100%" height="4">
      </div>
    </td>
  </tr> 
 </table>

</body>
</html>
