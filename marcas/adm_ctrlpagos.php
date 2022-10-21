<script language="javascript">
function cerrarwindows3() {
  window.opener.frames[0].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: adm_ctrlpagos.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2013 BD - Relacional I Semestre 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>SIPI - Servicio Autonomo de la Propiedad Intelectual</title>
</head> 
<body  bgcolor="#F9F7ED"> 

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection1();   

$vsol=trim($_GET['vsol']);
$vmod=$_GET['vmod'];
$vcod=$_GET['vcod'];

//La Fecha de Hoy para la transaccion
$fechahoy = hoy();

//echo "<p align='center'><b>EXPEDIENTE: $vsol</b></p>";   onload="centrarwindows()" 

$subtitulo = "Ingreso de Solicitudes de Marcas con Pagos de Derechos"; 

$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vcod']=$vcod;
$hiddenvars['vbol']=$vbol;

echo "$vsol $vcod $vbol "; exit();

 if ($vmod=='Buscar/Incluir') {
   echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_marca'>";
   echo " <td>";
   echo "   <i><b><font>$subtitulo</font></b></i>";
   echo " </td>";
   echo "</table>";
   echo " <br>";
 
   if ($vsol=='-') { 
     echo "<hr>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>INTRODUZCA PRIMERO EL NUMERO DEL EXPEDIENTE ...!!</b></font></p>";
     echo "<hr>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";       
     exit;
   }

   $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.solicitud = '$vsol' AND
                           a.evento = 1122 AND 
                           a.estat_ant = 1101 AND
                           a.documento = '$vbol' AND  
                           b.nro_derecho = a.nro_derecho AND
                           b.estatus = 400 AND                         
                           b.tipo_mp='M'");

   $filas_evento = pg_numrows($resultado);
   if ($filas_evento==0) {
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Expediente $vsol NO ha sido publicada como Solicitada ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
     exit();       
   }
   $regeve = pg_fetch_array($resultado);
   $vbol = $regeve[documento]; 
   $vfev = $regeve[fecha_venc];  
   
   $esmayor=compara_fechas($fechahoy,$vfev);
   if ($esmayor==1) {
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: La presente Solicitud fue publicada como solicitada en el Bolet&iacute;n No.: $vbol ...!!!</b></font></p>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>Y La Fecha tope para presentar Oposiciones a Solicitudes del Bolet&iacute;n $vbol era hasta el $vfev ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
     exit();       
   }

   $resultado=pg_exec("SELECT * FROM stmmarce a, stzderec b 
                        WHERE b.solicitud = '$vsol'AND
                           b.estatus = 1008 AND
                           b.nro_derecho = a.nro_derecho AND                        
                           b.tipo_mp='M'");
  
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0) {
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: No Existe el Expediente o no esta en el Estatus Indicado ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";       
   }
else {   
       ?>
       <form action="m_gbctrlopo.php" name="formtitular" method="POST" >

       <?php
        $vsol = $reg[solicitud]; 
        
   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='vmod' value='{$vbol}'>";
   
$varsol=$reg[solicitud];

//Ubicacion de la Imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
$varsolj=$varsol1.$varsol2;
$nameimage=ver_imagen2($varsol1,$varsol2,'M');

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

$modal = $resmod[modalidad];

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
$npoder=$reg[poder]; 

$vporc='83%';
if ($reg[modalidad]!="D")
   {$vporc='55%';} 

echo "<input type='hidden' name='vder' value='{$nderec}'>";

?>

<table border="0" cellpadding="2" cellspacing="2" width="100%">
  <tr>
    <td width="17%" align="right" class="der8-color">Solicitud:</td>
<?php echo "    <td width=$vporc class='izq6a-color'><i><u>$reg[solicitud]</u></i></td>"; 
if (($modal=='M') || ($modal=='G')) { 
  echo "  <td width='22%' rowspan='8' class='izq6a-color'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='130%' height='130%'></td></a>";  
}
?>
  </tr>
  <tr>
    <td width="17%" align="right" class="der8-color">Fecha Solicitud:</td>
<?php echo "    <td width=$vporc class='izq6a-color'>$reg[fecha_solic]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" class="der8-color">Tipo Marca:</td>
<?php echo "    <td width=$vporc class='izq6a-color'>$reg[tipo_derecho]-$vtip</td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" class="der8-color">Modalidad:</td>
<?php echo "    <td width=$vporc class='izq6a-color'>$resmod[modalidad]-$vmod</td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" class="der8-color">Pais:</td>
<?php echo "    <td width=$vporc class='izq6a-color'>$reg[pais_resid]-$respai[nombre]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" class="der8-color">Clase:</td>
<?php echo "    <td width=$vporc class='izq6a-color'>$resmod[clase]$vcla</td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" class="der8-color">Nombre:</td>
<?php echo "    <td width='83%' colspan='2' class='izq6a-color'>$reg[nombre]</td>"; ?>
  </tr>
  <tr>
 <? $estatus= $reg[estatus]-1000; ?>
    <td width="17%" align="right" class="der8-color">Estatus:</td>
<?php echo "    <td width='83%' colspan='2' class='izq6a-color'>$estatus -$restat[descripcion]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" class="der8-color">Distingue:</td>

<?php
//$res_dist=pg_exec("SELECT * FROM stmmarce WHERE nro_derecho='$nderec'");
//$regdis = pg_fetch_array($res_dist);
?>

<?php echo "    <td width='83%' colspan='2' class='izq6a-color'>$resmod[distingue]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" class="der8-color">Poder:</td>
<?php echo "    <td width='83%' colspan='2' class='izq6a-color'>$reg[poder]</td>"; ?>
  </tr>
 <!--  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Tramitante/Agente:</font></b></td> -->

<?php
//$agentram = agente_tram($nagen,$reg[tramitante],$npoder);
//$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente=$nagen");
//$regage = pg_fetch_array($res_agen);
//if ($reg[agente]<=0) { 
//  echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma'  size='2'>$reg[tramitante]</font></td>"; } 
//else {
//  echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma'  size='2'>Codigo: $reg[agente] $regage[nombre]</font></td>";
//  if ($reg[agente]>0)
//  {
//   echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma'  size='2'>$reg[tramitante] - Codigo: $reg[agente] $regage[nombre]</font></td>"; 
//   }
// }
?>
  <!-- </tr> -->

  <tr>
    <td width="17%" align="right" class="der8-color">Tramitante/Agente:</td>
      <?php
        $agentram = agente_tram($nagen,$reg[tramitante],$npoder);
        echo "    <td width='83%' colspan='2' class='izq6a-color'>$agentram</td>";
      ?>
  </tr>

<?php
$infadi='';
$res_prio=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho=$nderec");
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
    <td width="10%" class="Estilo5">C&oacute;digo</td> 
    <td width="30%" class="Estilo5">Nombre</td>
    <td width="20%" class="Estilo5">Nacionalidad</td>
    <td width="20%" class="Estilo5">Domicilio</td>
  <!-- <td width="20%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif"><b>Pa&iacute;s
      Residencia</b></font></td> -->
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
      echo "<td width='10%' class='izq6a-color'>$reg[titular]</td>";
      echo "<td width='30%' class='izq6a-color'>$reg[nombre]</td>";

      $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[nacionalidad]' and pais!=''");
      $respai = pg_fetch_array($res_pais);
      echo "<td width='20%' class='izq6a-color'>$reg[nacionalidad] - $respai[nombre]</td>";
      echo "<td width='20%' class='izq6a-color'>$reg[domicilio]</td>";
      echo "</tr>";
      $reg = pg_fetch_array($resultado);
     }
  ?>
  </tr>
</table>
<br />

<p align="center"><b><font size="4" face="Tahoma">Datos de la Publicaci&oacute;n en Bolet&iacute;n</font></b></p>
<table border="0" cellpadding="1" cellspacing="1" width="100%">
  <tr>
    <td width="10%" class='Estilo5'>Fecha Evento</td>
    <td width="10%" class='Estilo5'>Vencimiento Evento</td>
    <td width="10%" class='Estilo5'>N Documento</td>
    <td width="10%" class='Estilo5'>C&oacute;digo del Evento</td>
    <td width="20%" class='Estilo5'>Descripci&oacute;n</td>
    <td width="10%" class='Estilo5'>Fecha de Transacci&oacute;n</td>
    <td width="30%" class='Estilo5'>Comentarios</td>
    <?php
     if ($vtipuser==1) 
       {echo "<td class='izq3-color' width='10%'>Usuario</td>";}
    ?>
  </tr>
  <?php
   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento=1124");   
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) 
     { 
	$evento= $reg[evento]-1000;
     echo "<tr>";
     echo "<td width='10%' class='izq6a-color'>$reg[fecha_event]</td>";
     echo "<td width='10%' class='izq6a-color'>$reg[fecha_venc]</td>";
     echo "<td width='10%' class='izq6a-color'>$reg[documento]</td>";
     echo "<td width='10%' class='izq6a-color'>$evento</td>";
     echo "<td width='20%' class='izq6a-color'>$reg[desc_evento]</td>";
     echo "<td width='10%' class='izq6a-color'>$reg[fecha_trans]</td>";
     echo "<td width='30%' class='izq6a-color'>$reg[comentario]</td>";
     if ($vtipuser==1) 
        {echo "<td width='10%' class='izq6a-color'>$reg[usuario]</td>";}
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
 
  ?>
</table>

<br />
<?php
       echo "<p align='center'>";
       //echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/database_save.png' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
       //                        <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";       
       echo "<p align='center'><input type='submit' name='salir' value='Incluir' class='boton_azul'>&nbsp;&nbsp;
                               <input type='button' name='salir' value='Salir' class='boton_rojo' onclick='window.close()'>&nbsp;&nbsp;</p>";        
       exit;
   }
} 

 if ($vmod=='Buscar/Eliminar') {
   $subtitulo = "Consulta de Solicitudes de Marcas con Oposici&oacute;n a Eliminar"; 
   $resultado=pg_exec("SELECT stmtmpopo.solicitud, stmtmpopo.nro_derecho, stzderec.nombre,stmmarce.clase FROM stzderec, stmmarce, stmtmpopo 
                       WHERE  control = '$vcod' AND stzderec.tipo_mp='M' 
                       AND stzderec.nro_derecho = stmtmpopo.nro_derecho 
                       AND stzderec.nro_derecho = stmmarce.nro_derecho");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="m_gbctrlopo.php" name="formtitular" method="post">  
   <?php 
   echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_marca'>";
   echo " <td>";
   echo "   <i><b><font>$subtitulo</font></b></i>";
   echo " </td>";
   echo "</table>"; 
   //echo "<input type='hidden' name='vreg' value='{$vreg}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<br>";
   echo "<p align='center'><font size='4' face='Tahoma'><b>SELECCIONE LAS SOLICITUDES QUE DESEA ELIMINAR:</b></font></p>"; 
   echo "<table border='1' cellpadding='1' cellspacing='1' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' class='Estilo5'>Sel</td>";   
   echo " <td width='10%' class='Estilo5'>SOLICITUD</td>";
   echo " <td width='40%' class='Estilo5'>NOMBRE</td>";
   echo " <td width='40%' class='Estilo5'>CLASE</td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' class='izq6a-color'><input type='checkbox' name='B$cont'></td>";
     echo " <td width='10%' class='izq6a-color'><small>$reg[solicitud]</small></td>";
     echo " <td width='40%' class='izq6a-color'><small>$reg[nombre]</small></td>";
     echo " <td width='40%' class='izq6a-color'><small>$reg[clase]</small></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[solicitud]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre]'>";
     echo "<input type='hidden' name='cla$cont' value='$reg[clase]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){
      echo "<br>"; 
      echo "<p align='center'>AVISO: NINGUN NUMERO DE SOLICITUD ASOCIADO AL CONTROL ...!!</p>";
      echo "<p align='center'>
            <input type='button' value='Aceptar' name='aceptar' onclick='window.close()'>
            <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' align='middle' border='0' />&nbsp;Aceptar&nbsp;&nbsp;</p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";

      //echo "<input type='image' name='salir' value='Eliminar' src='../imagenes/folder_add_f3.png' align='middle' border='0' />&nbsp;Eliminar&nbsp;&nbsp; 
      //      <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p></p>";
      echo "<p align='center'><input type='submit' name='salir' value='Eliminar' class='boton_azul'>&nbsp;&nbsp;
                              <input type='button' name='salir' value='Salir' class='boton_rojo' onclick='window.close()'>&nbsp;&nbsp;</p>";        

   }
   echo "</form>";
   
  }

//Desconexion de la Base de Datos
$sql->disconnect1();

?>
</body>
</html>
