<script language="javascript">
function cerrarwindows3() {
  window.opener.frames[0].location.reload();
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
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 
<body onload="centrarwindows()" bgcolor="#F9F7ED"> 

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

echo "<p align='center'><b>SOLICITUD: $vsol</b></p>";
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

// echo " entro con $vmod y $vcod ";
 if ($vmod=='Buscar/Incluir') {
   $resultado=pg_exec("SELECT * FROM stmmarce a, stzderec b  WHERE 
                           b.solicitud = '$vsol' AND b.solicitud!='0000-000000'  AND
                           b.estatus = 1004 AND
                           b.nro_derecho = a.nro_derecho and                       
                           b.tipo_mp='M'");
  
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>No Existe el Expediente o no esta en el Estatus Indicado ...!!!</b></font></p>"; }
else {   
       ?>
       <form action="m_gbprensa.php" name="formtitular" method="POST" >

       <?php
        $vsol = $reg[solicitud]; 
        
   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   
$varsol=$reg[solicitud];
$nameimage=ver_imagen($varsol1,$varsol2,'M');


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
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Solicitud:</font></b></td>
<?php echo "    <td width=$vporc style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma'  size='2'>$reg[solicitud]</font></td>"; 
if ( file($nameimage))
   { echo "  <td width='22%' rowspan='9' align='center' style='background-color: #FFFFFF; border: 1 solid #000000'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='150' height='150'></td></a>"; 
   }
?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Fecha Solicitud:</font></b></td>
<?php echo "    <td width=$vporc style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma' size='2'>$reg[fecha_solic]</font></td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Tipo Marca:</font></b></td>
<?php echo "    <td width=$vporc style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma' size='2'>$reg[tipo_derecho]-$vtip</font></td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Modalidad:</font></b></td>
<?php echo "    <td width=$vporc style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma' size='2'>$resmod[modalidad]-$vmod</font></td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Pais:</font></b></td>
<?php echo "    <td width=$vporc style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma' size='2'>$reg[pais_resid]-$respai[nombre]</font></td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Clase:</font></b></td>
<?php echo "    <td width=$vporc style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma' size='2'>$resmod[clase]$vcla</font></td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Nombre:</font></b></td>
<?php echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma' size='2'>$reg[nombre]</font></td>"; ?>
  </tr>
  <tr>
 <? $estatus= $reg[estatus]-1000; ?>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Estatus:</font></b></td>
<?php echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma' size='2'>$estatus -$restat[descripcion]</font></td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Distingue:</font></b></td>

<?php
//$res_dist=pg_exec("SELECT * FROM stmmarce WHERE nro_derecho='$nderec'");
//$regdis = pg_fetch_array($res_dist);
?>

<?php echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma'  size='2'>$resmod[distingue]</font></td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #000000"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Tramitante/Agente:</font></b></td>

<?php
$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente=$nagen");
$regage = pg_fetch_array($res_agen);
if ($reg[agente]<=0)
   { 
   echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma'  size='2'>$reg[tramitante]</font></td>"; 
   }
if ($reg[agente]>0)
   {
   echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma'  size='2'>$reg[tramitante] - Codigo: $reg[agente] $regage[nombre]</font></td>"; 
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
    <td width="10%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif" size="2" ><b>C&oacute;digo</b></font></td>
    <td width="30%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Nombre</b></font></td>
    <td width="20%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Nacionalidad</b></font></td>
    <td width="20%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Domicilio</b></font></td>
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
       echo "<td width='10%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma' size='2'>$reg[titular]</font></td>";
      echo "<td width='30%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma' size='2'>$reg[nombre]</font></td>";

      $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[nacionalidad]' and pais!=''");
      $respai = pg_fetch_array($res_pais);
      echo "<td width='20%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma' size='2'>$reg[nacionalidad] - $respai[nombre]</font></td>";
      echo "<td width='20%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma' size='2'>$reg[domicilio]</font></td>";
    //  $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg2[pais_resid]' and pais!=''");
    //  $respai = pg_fetch_array($res_pais);
    //  echo "<td width='20%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma' size='2'>$reg2[pais_resid] - $respai[nombre]</font></td>";
      echo "</tr>";
      $reg = pg_fetch_array($resultado);
     }
  ?>
  </tr>
</table>



<?php

       echo "<p align='center'>";
       
       echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/save_f2.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                               <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";       

       exit;
   }

} 
 if ($vmod=='Buscar/Eliminar') {
 
   $resultado=pg_exec("SELECT stzprensa.solicitud, nombre FROM stzderec, stzprensa 
                       WHERE  nprensa = '$vcod'  AND stzderec.tipo_mp='M' 
                       AND stzderec.solicitud = stzprensa.solicitud ");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="m_gbprensa.php" name="formtitular" method="post"> 
   <?php 
      
   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
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
