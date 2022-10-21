<script language="javascript">
function cerrarwindows3() {
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: adm_prensa.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
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
<body onload="centrarwindows()" bgcolor="#FFFFFF"> 

<?php
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
$evto=$_GET['evto'];
$tbname_1 = "stzprensa";

echo "<br>";
echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>Datos de la Solicitud: $vsol, y Orden de Publicaci&oacute;n en Prensa </b></font></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><b>INTRODUZCA PRIMERO EL NUMERO DE SOLICITUD</b>";
   echo "<hr>";
   //echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows3()'></font></p>";
   echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='cerrarwindows3()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
   exit;
   }

$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vcod']=$vcod;
$hiddenvars['evto']=$evto;
// echo " entro con $vmod y $vcod $evto";

if (($vsol=='2018-007416') OR ($vsol=='2018-007417') OR ($vsol=='2018-007418')) { }
else {
    echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: SOLICITUD NO PERMITIDA ...!!</b></font></p>";
    echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
    exit();
}
 
if (($vmod=='Buscar/Incluir') or ($vmod=='Buscar/Incluir_32')  or ($vmod=='Buscar/Incluir_33')) {
  $resultado=pg_exec("select * from $tbname_1 WHERE solicitud='$vsol' AND nprensa = '$vcod'");
  $reg=pg_fetch_array($resultado);
  $filas_registro=pg_numrows($resultado);
  if ($filas_registro!=0){
    echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: SOLICITUD YA CARGADA CON ESTA MISMA PRENSA EN ESTE MISMO ACTO ...!!</b></font></p>";
    echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
    exit();
  }      
}

 if (($vmod=='Buscar/Incluir') or ($vmod=='Buscar/Incluir_32')  or ($vmod=='Buscar/Incluir_33')) {
   $resultado=pg_exec("SELECT * FROM stmmarce a, stzderec b  WHERE 
                           b.solicitud = '$vsol' AND b.solicitud!='0000-000000'  AND
                           (b.estatus = 1004  or b.estatus = 1024) AND
                           b.nro_derecho = a.nro_derecho and                       
                           b.tipo_mp='M'");
  
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
      echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: No Existe el Expediente o no esta en el Estatus Indicado ...!!!</b></font></p>";
      echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='cerrarwindows3()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
   }
else {   
       ?>
       <form action="m_gbprensa.php" name="formtitular" method="POST" >

       <?php
        $vsol = $reg[solicitud]; 
        
   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='evto' value='{$evto}'>";
   
$varsol=$reg[solicitud];

//imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
$varsolj=$varsol1.$varsol2;
$nameimage="../graficos/marcas/ef".$varsol1."/".$varsolj.".jpg";

$res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$reg[estatus]'");
$restat = pg_fetch_array($res_estatus);

$res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[pais_resid]' and pais!=''");
$respai = pg_fetch_array($res_pais);

$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente=$reg[agente] and agente!=''");
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
if ($reg[tipo_derecho]=='D') {$vtip='DENOMINACION DE ORIGEN';}

if ($$resmod[ind_claseni]=='N') {$vcla='NACIONAL';}
if ($$resmod[ind_claseni]=='I') {$vcla='INTERNACIONAL';}

$nregis=$reg[registro];
$nsolic=$reg[solicitud];
$nderec=$reg[nro_derecho];
$nagen=$reg[agente];

$vporc='83%';
if ($reg[modalidad]!="D")
   {$vporc='55%';} 

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
    <td width="17%" class='celda-titulo'><b>Tipo Marca:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$reg[tipo_derecho]-$vtip</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Modalidad:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$resmod[modalidad]-$vmod</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Pais:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$reg[pais_resid]-$respai[nombre]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Clase:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$resmod[clase]$vcla</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Nombre:</b></td>
<?php echo "    <td width=$vporc colspan='2' class='celda2'>$reg[nombre]</td>"; ?>
  </tr>
  <tr>
 <? $estatus= $reg[estatus]-1000; ?>
    <td width="17%" class='celda-titulo'><b>Estatus:</b></td>
<?php echo "    <td width=$vporc colspan='2' class='celda2'>$estatus -$restat[descripcion]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Fecha Vencimiento:</b></td>
<?php echo "    <td width=$vporc colspan='2' class='celda2'>$reg[fecha_venc]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Distingue:</b></td>

<?php echo "    <td width=$vporc colspan='2' class='celda2'>$resmod[distingue]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Tramitante/Agente:</b></td>

<?php
$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente=$nagen");
$regage = pg_fetch_array($res_agen);
if ($reg[agente]<=0)
   { 
   echo "    <td width=$vporc colspan='2' class='celda2'>$reg[tramitante]</td>"; 
   }
if ($reg[agente]>0)
   {
   echo "    <td width=$vporc colspan='2' class='celda2'>$reg[tramitante] - Codigo: $reg[agente] $regage[nombre]</td>"; 
   }
?>
  </tr>
  </tr>
</table>

<p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="10%" class='columna-titulo'><font color="#FFFFFF" face="MS Sans Serif" size="2" ><b>C&oacute;digo</b></font></td>
    <td width="30%" class='columna-titulo'><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Nombre</b></font></td>
    <td width="20%" class='columna-titulo'><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Pa&iacute;s</b></font></td>
    <td width="20%" class='columna-titulo'><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Domicilio</b></font></td>
  </tr>
  <?php

  $resultado = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
<br>
<p align="center"><b><font size="4" face="Tahoma">Datos de la Publicaci&oacute;n en Bolet&iacute;n</font></b></p>
<table border="0" cellpadding="1" cellspacing="1" width="100%">
  <tr>
    <td width="10%" class='columna-titulo'>C&oacute;digo del Evento</td>
    <td width="20%" class='columna-titulo'>Descripci&oacute;n</td>
    <td width="10%" class='columna-titulo'>No Documento</td>
    <td width="10%" class='columna-titulo'>Fecha Evento</td>
    <td width="10%" class='columna-titulo'>Vencimiento Evento</td>
    <td width="10%" class='columna-titulo'>Fecha de Transacci&oacute;n</td>
    <td width="30%" class='columna-titulo'>Comentarios</td>
    <?php
     if ($vtipuser==1) 
       {echo "<td class='columna-titulo' width='10%'>Usuario</td>";}
    ?>
  </tr>
  <?php
   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND ((evento=1201 AND estat_ant=1002) OR (evento=1089 AND estat_ant=1027))");   
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) 
     { 
	$evento= $reg[evento]-1000;
     echo "<tr>";
     echo "<td width='10%' class='celda2'>$evento</td>";
     echo "<td width='20%' class='celda2'>$reg[desc_evento]</td>";
     echo "<td width='10%' class='celda2'><b>$reg[documento]</b></td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_event]</td>";
     echo "<td width='10%' class='celda2'><b>$reg[fecha_venc]</b></td>";
     echo "<td width='10%' class='celda2'>$reg[fecha_trans]</td>";
     echo "<td width='30%' class='celda2'>$reg[comentario]</td>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
  ?>
</table>

<?php
       echo "<p align='center'>";
       echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/boton_guardar_rojo.png' alt='Save' align='middle' border='0' />
                               <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
       exit;
   }
} 

$evento= $evto+1000;
 if (($vmod=='Buscar/Eliminar')  or ($vmod=='Buscar/Eliminar_32')  or ($vmod=='Buscar/Eliminar_33')) {
 
   $resultado=pg_exec("SELECT stzprensa.solicitud, nombre FROM stzderec, stzprensa 
                       WHERE  nprensa = '$vcod'  AND stzderec.tipo_mp='M' 
                       AND stzderec.solicitud = stzprensa.solicitud 
                       AND evento= $evento");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="m_gbprensa.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='evto' value='{$evto}'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><b>SELECCIONE LOS CODIGOS QUE DESEA ELIMINAR:</b></p>";
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
   if ($filas_found==0) {
   	echo "<p align='center'>NINGUN NUMERO DE SOLICITUD ASOCIADO</p>";
      //echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows3()'></font></p>";
      echo "<p align='center'><input type='image' name='salir' value='Aceptar' src='../imagenes/boton_salir_rojo.png' alt='Save' align='middle' border='0' /></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";

      //echo "<input type='submit' value='Eliminar' name='eliminar' >
      //      <input type='button' value='Salir' name='aceptar' onclick='cerrarwindows3()'></font></p>";

      echo "<input type='image' name='salir' value='Eliminar' src='../imagenes/boton_eliminar_rojo.png' align='middle' border='0' />
            <input type='image' name='aceptar' value='Salir' onclick='cerrarwindows3()' src='../imagenes/boton_salir_rojo.png' align='middle' border='0' /></p>";       
   }
   echo "</form>";
  }

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
