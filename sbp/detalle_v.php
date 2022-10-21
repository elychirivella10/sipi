<?php 
// Programa PHP. Muestra los  Resultados de la Consulta y la llamada a los documentos PDF
// (detalle.php)
// Realizado Por Ing. Karina Pérez
// Modificado por Ing. Rómulo Mendoza / Julio 2008 
?>

<html>
<head>
 <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link rel="stylesheet" href="layersmenu.css" type="text/css"></link>
 <link rel="shortcut icon" href="LOGOS/shortcut_icon_phplm.png"></link>
 <title>SIPI - Sistema de Informaci&oacute;n de Propiedad Intelectual</title>

<?php include ("libjs/layersmenu-browser_detection.js"); ?>
<script language="JavaScript" type="text/javascript" src="libjs/layersmenu-library.js"></script>
<script language="JavaScript" type="text/javascript" src="libjs/layersmenu.js"></script>
<script language="JavaScript" type="text/javascript" src="libjs/layerstreemenu-cookies.js"></script>

<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

include ("lib/template.inc.php");	// taken from PHPLib
include ("lib/layersmenu.inc.php");

$usuario = $_SESSION['usuario_login'];
$usuario = trim($usuario);

$fecha   = trim(fechahoy());
$subtitulo = "B&uacute;squeda T&eacute;cnica de Patentes";

$mid = new LayersMenu();
$mid->setMenuStructureFile("layersmenu-horizontal-1.txt");
$mid->printHeader();
?>

<?
//Conexion con la base de datos SAPI
$sql       = new mod_db();
//Verificando conexion
$sql->connection();

// Realizando Consulta por numero de solicitud

$valor1 = $_GET["num_sol"];

$resultado=pg_exec("SELECT  resumen,b.nro_derecho,solicitud,
                        tipo_derecho,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stppatee a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND tipo_mp='P' 
		        AND b.solicitud= '$valor1' and b.solicitud!=''");

$registro = pg_fetch_array($resultado);
if (!$resultado) { echo "<b>Error de busqueda</b>"; exit; }
    $filas_resultado=pg_numrows($resultado); 

if ($filas_resultado==0) { echo "No se encontro ningun registro\n"; exit; } else {

 $nderec=$registro['nro_derecho'];
 $varsol=$registro['solicitud'];
 $nregis=$registro['registro'];
 $nagen=$registro['agente'];

$cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
$cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
$cons_clasl=pg_exec("SELECT * FROM stplocad WHERE nro_derecho = '$nderec'");
$cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
$cons_palc=pg_exec("SELECT * FROM stppacld WHERE nro_derecho='$nderec'");
$cons_equiv=pg_exec("SELECT * FROM stpequiv WHERE nro_derecho='$nderec'");
$cons_nota=pg_exec("SELECT * FROM stpnotas WHERE nro_derecho='$nderec'");

$cons_tit = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad
		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");

$cons_bol=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento=2124");
$reg_inv = pg_fetch_array($cons_inv);
   $filas_cons_inv=pg_numrows($cons_inv); 
$regclasf = pg_fetch_array($cons_clas);
   $filas_clasif=pg_numrows($cons_clas); 
$reg_clasl = pg_fetch_array($cons_clasl);
   $filas_cons_clasl=pg_numrows($cons_clasl);
$reg_pri = pg_fetch_array($cons_pri);
   $filas_cons_pri=pg_numrows($cons_pri);
$reg_equiv = pg_fetch_array($cons_equiv);
   $filas_cons_equiv=pg_numrows($cons_equiv);
$reg_tit = pg_fetch_array($cons_tit);
   $filas_cons_tit=pg_numrows($cons_tit);
$reg_nota = pg_fetch_array($cons_nota);
   $filas_cons_nota=pg_numrows($cons_nota);

//$vtip=tipo_patente($registro['tipo_derecho']);

$vtip = $registro['tipo_derecho'];
$cons_tipo=pg_exec("SELECT * FROM stzutilr WHERE grupo=7 AND codigo = '$vtip'");
$reg_tipo = pg_fetch_array($cons_tipo);

  //  if ($var=='A') {$vtip = 'INVENCION';}
  //  if ($var=='C') {$vtip = 'MEJORA';}
  //  if ($var=='E') {$vtip = 'MODELO INDUSTRIAL';}
  //  if ($var=='G') {$vtip = "DISEÑO INDUSTRIAL";}
  //  if ($var=='B') {$vtip = 'DIBUJO INDUSTRIAL';}
  //  if ($var=='D') {$vtip = 'INTRODUCCION';}
  //  if ($var=='F') {$vtip = 'MODELO DE UTILIDAD';}
  //  if ($var=='V') {$vtip=  'VARIEDADES VEGETALES';}

//$vtip = utf8_decode($vtip);

$descripcion=estatus($registro['estatus']);

$pais_nombre=pais($registro['pais_resid']);

if ($cons_bol) { 
 $filas_boletin=pg_numrows($cons_bol);
 if ($filas_boletin!=0) {
   $reg_boletin = pg_fetch_array($cons_bol);
 }
}
  
?>

</head>
<body>

<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
<tr><td>
<table width="100%" border="0" cellpadding="8" cellspacing="1">
<tr>
<td class="topbar" colspan="2">

<table width="940px" align="center">
 <tr>
  <td>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
     <td width="100%" valign="top">
      <font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <!-- <img src="../imagenes/cintillo2015.png" width="100%" height="52"> -->
        <img src="../imagenes/cintillosapi_mcn.png" width="100%" height="52">        
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
      <b><i><a href="http://www.bancodevenezuela.com/" target="blank">Banco de Venezuela</a></i></b>
    </td>
    <td width="40%" class="subtitulo1">
		<b><i>Sistema Automatizado de Marcas, Patentes y Derecho de Autor - SIPI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></b>
    </td>
  </tr>
</table>

  <table width="100%">
   <tr>
    <td width="30%" class="izq2-color">
      <font face="MS Sans Serif" size="-1">Usuario: <?php echo $usuario ?> </font>
    </td>
    <td width="40%" class="cnt-color3">
      <font face="MS Sans Serif" size="-1"><?php echo $subtitulo ?> </font>
    </td>
    <td width="30%" class="der2-color">
      <font face="MS Sans Serif" size="-1"><?php echo $fecha ?> </font>
    </td>
    </tr>
  </table>

</td>
</tr>
<tr>
<td width="20%" class="bar" valign="top" nowrap="nowrap">
<center>
<br />
</center>
<br />
Menu
<?php
$mid->setMenuStructureFile("layersmenu-vertical-1.txt");
$mid->parseStructureForMenu("treemenu1");
print $mid->newTreeMenu("treemenu1");
//utf8_decode(
?>
<br />
<br />
<center>
</center>
<br />
<center>
</center>
<br />
<center>
</center>
</td>
<td valign="top" bgcolor="#add8e6">

   <table border="0" width="100%">
     <td width="100%"></td>
      <tr>
        <td width="90%"><b><font face="Tahoma" size="2">T&iacute;tulo del Documento: </font></b>
           <font face="Tahoma" size="2"><?= $registro['nombre']?></font></td>
        <td width="100%"></td>
      </tr>
      <tr>
        <td width="90%"><b><font face="Tahoma" size="2">Tipo de Patente: </font></b>
          <font face="Tahoma" size="2"><?= $registro['tipo_derecho']." - ".$reg_tipo['elemento'] ?></font></td>
        <td width="100%"></td>
      </tr>
      <tr>
        <td width="90%"><b>
          <font face="Tahoma" size="2">N&uacute;mero de la Solicitud: </font></b>
          <font face="Tahoma" size="2"><?= $registro['solicitud']?></font>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <b><font face="Tahoma" size="2">Fecha de Presentaci&oacute;n: </font></b>
          <font face="Tahoma" size="2"><?= $registro['fecha_solic']?></font>
        </td>
        <td width="72%"></td>
      </tr>
      <tr>
        <td width="28%"><b><font face="Tahoma" size="2">Inventor(es):</font></b>
          <font face="Tahoma" size="2">
          <?
            for($cont=0;$cont<$filas_cons_inv;$cont++) { 
              echo $reg_inv['nombre_inv'];
              echo "(".$reg_inv['nacionalidad'].")";
	           echo " | ";
	           $reg_inv = pg_fetch_array($cons_inv);
            }
          ?>
        </font></td>
        <td width="72%"></td>
      </tr>
      <tr>
        <td width="28%"><b><font face="Tahoma" size="2">Titular(es):</font></b>
          <font face="Tahoma" size="2"> 
          <?
            for($cont=0;$cont<$filas_cons_tit;$cont++) { 
              echo $reg_tit['nombre'];
              echo "(".$reg_tit['nacionalidad'].")";
	           echo " | ";
	           $reg_tit = pg_fetch_array($cons_tit);
            }
          ?>
          </font></td>
       <td width="72%"></td>
      </tr>
      <tr>
        <td width="28%"><b><font face="Tahoma" size="2">Clasificaci&oacute;n:</font></b> 
          <font face="Tahoma" size="2"> 
          <?
            for($cont=0;$cont<$filas_clasif;$cont++) { 
	           echo $regclasf['tipo_clas'];
	           echo "=";
              echo $regclasf['clasificacion'];
	           echo " | ";
	           $regclasf = pg_fetch_array($cons_clas);
            }
          ?>
        </font></td>
        <td width="72%"></td>
      </tr>
      <tr>
        <td width="28%"><b><font face="Tahoma" size="2">Clasificaci&oacute;n Locarno: 
          <?
            for($cont=0;$cont<$filas_cons_clasl;$cont++) { 
              echo $reg_clasl['clasi_locarno'];
	           $reg_clasl = pg_fetch_array($cons_clasl);
	           echo " | ";
            }
          ?>
		  </font></b></td>
        <td width="72%"></td>
      </tr>
<!--      <tr>
        <td width="28%"><b><font face="Tahoma" size="2">Pa&iacute;s: </font></b>
         <font face="Tahoma" size="2"><?= $registro['pais_resid']." - ".$pais_nombre;?></font></td> 
        <td width="72%"></td>
      </tr> -->
      <tr>
        <td width="28%"><b><font face="Tahoma" size="2">Estatus: </font></b>
          <font face="Tahoma" size="2"><?= ($registro['estatus']-2000)." - ".$descripcion;?></font></td>
        <td width="72%"></td>
      </tr>
      <tr>
        <td width="28%"><b>
          <font face="Tahoma" size="2">Fecha de Publicaci&oacute;n: </font></b>
          <font face="Tahoma" size="2"><?= $registro['fecha_publi']?></font>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <!-- <font face="Tahoma" size="2">Bolet&iacute;n: <?= $reg_boletin['documento']?>-->          
          <b><font face="Tahoma" size="2">Bolet&iacute;n:</font></b>
          <font face="Tahoma" size="2"> 
           <? 
             if ($filas_boletin!=0) { echo $reg_boletin['documento']; }
           ?>          
          </font>
        </td>
        <td width="72%"></td>
      </tr>
      
      <tr>
        <td width="28%">
          <b><font face="Tahoma" size="2">N&uacute;mero de Registro: &nbsp;</font></b>
          <font face="Tahoma" size="2"><?= trim($registro['registro']) ?></font>
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <b><font face="Tahoma" size="2">Fecha de Vencimiento: </font></b>
          <font face="Tahoma" size="2">
            <? if (strlen(trim($registro['registro']))!=0) 
              { echo $registro['fecha_venc']; }
            ?>
          </font>          
          </td>
        <td width="72%"></td>
      </tr>

      <tr>
        <td width="28%"><b><font face="Tahoma" size="2">N&uacute;mero de Prioridad:</font></b>
         <font face="Tahoma" size="2"> 
          <?
            for($cont=0;$cont<$filas_cons_pri;$cont++) { 
              echo $reg_pri['prioridad'];
	           echo " -Pa&iacute;s= ";              
	           echo $reg_pri['pais_priori'];
	           echo " -de Fecha= ";
	           echo $reg_pri['fecha_priori'];
              $reg_pri = pg_fetch_array($cons_pri);
	           echo " | ";
            }
          ?>
		  </font></td>
        <td width="72%"></td>
      </tr>
      <tr>
        <td width="90%"><b><font face="Tahoma" size="2">Poder No.: </font></b>
          <font face="Tahoma" size="2"><?= $registro['poder']?></font></td>
        <td width="100%"></td>
      </tr>
      <tr>
        <td width="28%"><b><font face="Tahoma" size="2">Equivalencias:</font></b>
         <font face="Tahoma" size="2"> 
          <?
            for($cont=0;$cont<$filas_cons_equiv;$cont++) { 
              echo $reg_equiv['equivalente'];
              $reg_equiv = pg_fetch_array($cons_equiv);
	           echo " | ";
            }
          ?>
		  </font></td>
        <td width="72%"></td>
      </tr>
      
   </table>
   <?
      echo "<table border='0'>";
      echo "<tr>";
      echo "  <td width='100%' >";
      $vs1=substr($valor1,-11,4);
      $vs2=substr($valor1,-6,6);
 		echo "<a href='../patentes/p_datostec2.php?vopc=1&vsol1=$vs1&vsol2=$vs2' target='_blank'><b>Actualizar Datos T&eacute;cnicos</b></a>";
		echo " </td>";
      echo " </tr> ";
      echo "</table>";

      echo "<table border='0'>";
      echo "<tr>";
	   echo "  <td>";
      $dirano=substr($valor1,-11,4);             
	   $solpdf=$dirano.substr($valor1,-6,6);
      echo "<p align='center'><a href='http://documentos.sapi.gob.ve/patente/venezuela/$solpdf.pdf' target='_blank' ><b>Ver Documento PDF</b></a>"; 
		echo " </td>";
      echo "  <td>";
 		echo "<p align='center'><a href='' target='_blank' ><b>Ver T&iacute;tulo</b></a>";
		echo " </td>";
      echo "  <td>";
 		echo "<p align='center'><a href='http://documentos.sapi.gob.ve/patente/venezuela/FICHAS/$solpdf.pdf' target='_blank' ><b>Ver Ficha</b></a>";
		echo " </td>";
      echo "  <td>";
 		echo "<p align='center'><a href='../patentes/p_rptcronol.php?vsol=$valor1' target='_blank' ><b>Cronologia</b></a></p>";
		echo " </td>";
      echo "  <td>";
 		echo "<p align='center'><a href='detalle_imp.php?num_sol=$valor1' target='_blank' ><b>Imprimir</b></a>";
		echo " </td>";
      echo "  <td>";
 		//$num1_imagen=substr($sol,0,2);
		//$num2_imagen=substr($sol,3,8);
		//$num_imagen=$num1_imagen.$num2_imagen;
		echo "<p align='right'>"; 
      $vsol1=substr($valor1,-11,4);
      $vsol2=substr($valor1,-6,6);
		$nameimagen = ver_imagen($vsol1,$vsol2,'P');
		//echo "<a href='../imagenes/patentes/di2004/$num_imagen.jpg' target='_blank' ><img border='2' src='di2001/$num_imagen.jpg' width='150' height='100' >";
		echo "<a href='$nameimagen' target='_blank' ><img border='2' src='$nameimagen' width='150' height='100' >";
		echo " </td>";
      echo " </tr> ";
      echo "</table>";
   ?>
   
   <table border="1" width="100%" height="39">
    <tr>
       <!-- <td width="100%" height="16" bgcolor="#669999"> -->
       <td width="100%" height="16" class="celda3">
         <b>RESUMEN</b>
       </td> 
    </tr>            
    <tr>
       <td width="100%" height="11">
         <b><font class="columna4"><?= $registro['resumen'] ?></b> 
       </td>
    </td>
    </tr>
   </table>
   <br/ > 
   
   <table border="1" width="100%" height="39">
    <tr>
       <td width="100%" height="16" class="celda3">
         <b>OBSERVACIONES</b>
       </td> 
    </tr>            
    <tr>
       <td width="100%" height="11">
         <b><font class="columna4"><?= utf8_decode($reg_nota['notas']) ?></b>
       </td>
    </td>
    </tr>
   </table>
   
</td></tr>
</table>

<?
}
?>

</body>
</html>

 <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="100%" height="4">
      </div>
    </td>
  </tr> 
 </table>

 <table width="100%" border="0" cellpadding="0" cellspacing="1">
  <tr> 
    <td width="100%" class="pie1"> 
     <div align="center">
      <font size="-2"><I>Desarrollado por: <b>Ing. R&oacute;mulo Mendoza, Ing. Karina P&eacute;rez y T.S.U. Nelson Gonz&aacute;lez - Coordinaci&oacute;n de Inform&aacute;tica - SAPI Rif: G-20008399-9<br/>
Sistema Versi&oacute;n 1.4, desarrollado con Smarty, CSS, HTML, PHP 5, JavaScript y PostgreSQL 8.3 <br/> 
  Caracas - Venezuela - CopyLeft 2005, 2006, 2007, 2010 / Decreto No. 3.390 <I></font>
      </p>
     </div>
    </td>
  </tr> 
 </table>

 <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="100%" height="4">
      </div>
    </td>
  </tr> 
 </table>
