<script language="javascript">
function cerrarwindows3() {
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: adm_derechop.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2013 BD - Relacional 
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

//Verificacion de Conexion 
$sql->connection($usuario);   

$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vcod=$_GET['vcod'];
$vbol=$_GET['vbol'];
$vtot=$_GET['vtot'];

echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>SOLICITUD: $vsol, FACTURA: $vcod</b></font></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><b>INTRODUZCA PRIMERO EL NUMERO DE SOLICITUD</b>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows3()'></font></p>";
   exit;
   }

$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vcod']=$vcod;
$hiddenvars['vbol']=$vbol;
$hiddenvars['vtot']=$vtot;

 if ($vmod=='Buscar/Incluir')  {
 	
   if ($vsol=='-') { 
     echo "<hr>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>INTRODUZCA PRIMERO EL NUMERO DEL EXPEDIENTE ...!!</b></font></p>";
     echo "<hr>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
     exit;
   }
   
   if (($vcod=='F0162089') || ($vcod=='F0161842') || ($vcod=='F0161681')) { }
   else {  
     $resultado=pg_exec("SELECT * FROM stppagocon WHERE factura = '$vcod'");
     $reg=pg_fetch_array($resultado);
     $filas_registro=pg_numrows($resultado);
   
     if ($filas_registro==$vtot){
      echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: LLEGO AL TOPE DE DERECHO(S) DE REGISTRO(S) PAGADOS SEGUN FACTURA ...!!</b></font></p>";
      echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
      exit();    
     }
   }
   
   $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.solicitud = '$vsol' AND
                           a.evento in (2122,2097) AND 
                           a.estat_ant in (2101,2027,2127) AND
                           a.documento = $vbol AND  
                           b.nro_derecho = a.nro_derecho AND
                           b.estatus IN (2400,2401,2410,2402,2404) AND                         
                           b.tipo_mp='P'");

   $filas_evento = pg_numrows($resultado);
   if ($filas_evento==0) {
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol NO ha sido publicada como Concedida en el Bolet&iacute;n $vbol ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     exit();       
   }
   $regeve = pg_fetch_array($resultado);
   $vbol = $regeve[documento]; 
   $vfev = $regeve[fecha_venc];  
   
   $esmayor=compara_fechas($fechahoy,$vfev);
   if ($esmayor==1) {
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: La presente Solicitud fue publicada como concedida en el Bolet&iacute;n No.: $vbol ...!!!</b></font></p>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>Y La Fecha tope para pagar los Pagos de Derechos del Bolet&iacute;n $vbol era hasta el $vfev ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     exit();       
   }
 	
   $resultado=pg_exec("SELECT * FROM stppatee a, stzderec b  WHERE 
                           b.solicitud = '$vsol' AND b.solicitud!='0000-000000'  AND
                           b.estatus IN (2400,2401,2410,2402,2404) AND
                           b.nro_derecho = a.nro_derecho and                       
                           b.tipo_mp='P'");
  
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>No Existe el No. de Solicitud o NO esta en el Estatus Indicado ...!!!</b></font></p>"; }
else {   
       ?>
       <form action="p_gbpagoder.php" name="formtitular" method="POST" >

       <?php
        $vsol = $reg[solicitud]; 
        
   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='vbol' value='{$vbol}'>";
   echo "<input type='hidden' name='vtot' value='{$vtot}'>";
      
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

//$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente=$reg[agente]");
//$resage = pg_fetch_array($res_agen);

$res_mod=pg_exec("SELECT * FROM stppatee WHERE nro_derecho='$reg[nro_derecho]' ");
$resmod = pg_fetch_array($res_mod);

if ($reg[tipo_derecho]=='A') {$vtip='INVENCION';}
if ($reg[tipo_derecho]=='B') {$vtip='DIBUJO INDUSTRIAL';}
if ($reg[tipo_derecho]=='C') {$vtip='DE MEJORA';}
if ($reg[tipo_derecho]=='D') {$vtip='DE INTRODUCCION';}
if ($reg[tipo_derecho]=='E') {$vtip='MODELO INDUSTRIAL';}
if ($reg[tipo_derecho]=='F') {$vtip='MODELO DE UTILIDAD';}
if ($reg[tipo_derecho]=='G') {$vtip='DISEÑO INDUSTRIAL';}

$nregis=$reg[registro];
$nsolic=$reg[solicitud];
$nderec=$reg[nro_derecho];
$nagen=trim($reg[agente]);

echo "<input type='hidden' name='vder' value='{$nderec}'>"; 

if (empty($nagen)) { $nagen=0; } 
$vporc='83%';

?>

<table border="0" cellpadding="0" cellspacing="1" width="100%">
  <tr>
    <td width="17%" class='celda-titulo'><b>Solicitud:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$reg[solicitud]</td>"; 
if ( file($nameimage))
   { echo "  <td width='22%' rowspan='9' class='celda2'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='150' height='150'></td></a>"; 
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
 <? $estatus= $reg[estatus]-1000; ?>
    <td width="17%" class='celda-titulo'><b>Estatus:</b></td>
<?php echo "    <td width='83%' colspan='2' class='celda2'>$estatus -$restat[descripcion]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Resumen:</b></td>

<?php
?>

<?php echo "    <td width='83%' colspan='2' class='celda2'>$resmod[resumen]</td>"; ?>
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
       FROM stzottid, stzsolic, stzderec WHERE stzottid.nro_derecho='$nderec'
			                AND stzderec.nro_derecho=stzottid.nro_derecho
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


<p align="center"><b><font size="4" face="Tahoma">Datos de la Publicaci&oacute;n en Bolet&iacute;n</font></b></p>
<table border="0" cellpadding="1" cellspacing="1" width="100%">
  <tr>
    <td width="10%" class='columna-titulo'>Fecha Evento</td>
    <td width="10%" class='columna-titulo'>Vencimiento Evento</td>
    <td width="10%" class='columna-titulo'>N Documento</td>
    <td width="10%" class='columna-titulo'>C&oacute;digo del Evento</td>
    <td width="20%" class='columna-titulo'>Descripci&oacute;n</td>
    <td width="10%" class='columna-titulo'>Fecha de Transacci&oacute;n</td>
    <td width="30%" class='columna-titulo'>Comentarios</td>
    <?php
     if ($vtipuser==1) 
       {echo "<td class='columna-titulo' width='10%'>Usuario</td>";}
    ?>
  </tr>
  <?php
   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento in (2122,2097) AND documento=$vbol AND estat_ant in (2101,2027,2127)");   
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) 
     { 
	$evento= $reg[evento]-2000;
     echo "<tr>";
     echo "<td width='10%' class='celda2'>$reg[fecha_event]</td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_venc]</td>";
     echo "<td width='10%' class='celda2'>$reg[documento]</td>";
     echo "<td width='10%' class='celda2'>$evento</td>";
     echo "<td width='20%' class='celda2'>$reg[desc_evento]</td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_trans]</td>";
     echo "<td width='30%' class='celda2'>$reg[comentario]</td>";
     if ($vtipuser==1) 
        {echo "<td width='10%' class='celda2'>$reg[usuario]</td>";}
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
 
  ?>
</table>

<br>

<?php
       echo "<p align='center'>";
       echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/boton_guardar_rojo.png' alt='Save' align='middle' border='0' />&nbsp
                               <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
       exit;
   }
} 

 if ($vmod=='Buscar/Eliminar') {
 
   $resultado=pg_exec("SELECT stppagocon.solicitud, nombre FROM stzderec, stppagocon 
                       WHERE  factura = '$vcod'  AND stzderec.tipo_mp='P' 
                       AND stzderec.solicitud = stppagocon.solicitud");
                       
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="p_gbpagoder.php" name="formtitular" method="post"> 
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
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NOMBRE</font></td>";
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
   else
   {  echo "<p align='center'><font color='#0000FF'>";

      echo "<input type='submit' value='Eliminar' name='eliminar' >
            <input type='button' value='Salir' name='aceptar' onclick='cerrarwindows3()'></font></p>";

   }
   echo "</form>";
   
  }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
