<script language="javascript">
function cerrarwindows3() {
  window.opener.frames[0].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: adm_prensap.php 
// Realizado por el Analista de Sistema Karina Perez
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
   $resultado=pg_exec("SELECT * FROM stppatee a, stzderec b  WHERE 
                           b.solicitud = '$vsol' AND b.solicitud!='0000-000000'  AND
                           b.estatus = 2004 AND
                           b.nro_derecho = a.nro_derecho and                       
                           b.tipo_mp='P'");
  
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>No Existe el Expediente o no esta en el Estatus Indicado ...!!!</b></font></p>"; }
else {   
       ?>
       <form action="p_gbprensa.php"? name="formtitular" method="POST" >

       <?php
        $vsol = $reg[solicitud]; 
        
   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";




$varsol=$reg['solicitud'];
$vnumsol=$reg['solicitud'];
$nderec=$reg['nro_derecho'];

 $res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$reg[estatus]' and tipo_mp = 'P' order by estatus");
 $restat = pg_fetch_array($res_estatus);

$res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[pais_resid]' and pais!=''");
$respai = pg_fetch_array($res_pais);

//$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$reg[agente]'");
//$resage = pg_fetch_array($res_agen);

$cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
$cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
$cons_clasl=pg_exec("SELECT * FROM stplocad WHERE nro_derecho = '$nderec'");
$cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");


$cons_tit = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular ");


$reg_inv = pg_fetch_array($cons_inv);
   $filas_cons_inv=pg_numrows($cons_inv); 
$regclasf = pg_fetch_array($cons_clas);
   $filas_clasif=pg_numrows($cons_clas); 
$reg_clasl = pg_fetch_array($cons_clasl);
   $filas_cons_clasl=pg_numrows($cons_clasl);
$reg_pri = pg_fetch_array($cons_pri);
   $filas_cons_pri=pg_numrows($cons_pri);
$reg_tit = pg_fetch_array($cons_tit);
   $filas_cons_tit=pg_numrows($cons_tit);

  
if ($reg['tipo_derecho']=='A') {$vtip='INVENCION';}
if ($reg['tipo_derecho']=='G') {$vtip='DISEÑO INDUSTRIAL';}
if ($reg['tipo_derecho']=='F') {$vtip='MODELOS DE UTILIDAD';}
if ($reg['tipo_derecho']=='E') {$vtip='MODELO INDUSTRIAL';}
if ($reg['tipo_derecho']=='B') {$vtip='DIBUJO INDUSTRIAL';}
if ($reg['tipo_derecho']=='V') {$vtip='VARIEDAD VEGETAL';}
if ($reg['tipo_derecho']=='C') {$vtip='MEJORA';}
if ($reg['tipo_derecho']=='D') {$vtip='INDUCCION';}

$nregis=$reg['registro'];
$nsolic=$reg['solicitud'];
$nagen=$reg['agente'];

$varsol=$reg[solicitud];
$nameimage=ver_imagen($varsol1,$varsol2,'P');

$vporc='83%';
if ( file($nameimage))
   {$vporc='55%';} 

?>

<table border="0" cellpadding="0" cellspacing="1" width="100%">
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Solicitud:</font></b></td>
<?php echo "    <td width=$vporc style='background-color: #7AC0EF; border: 1 solid #000000'><font face='Tahoma'  size='2'>$reg[solicitud]</font></td>"; 


if ( file($nameimage))
   { echo "  <td width='22%' rowspan='9' align='center' style='background-color: #FFFFFF; border: 1 solid #000000'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='150' height='150'></td></a>"; 
   }
   
 ?>
 
  </tr>

  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Fecha Solicitud:</font></b></td>
<?php echo "    <td width='61%' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'>$reg[fecha_solic]</font></td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Tipo Patente:</font></b></td>
<?php echo "    <td width='55%' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'>$reg[tipo_derecho]/$vtip</font></td>"; ?>
  </tr>

  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Pais:</font></b></td>
<?php echo "    <td width='55%' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'>$reg[pais_resid]/$respai[nombre]</font></td>"; ?>
  </tr>


<? 
$estatus=$reg['estatus'];
$registro=$reg['registro'];

?>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Titulo:</font></b></td>
<? 

    $nombre=$reg[nombre];
    utf8_decode($nombre);
    echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'> $nombre </font></td>";

?>
<?php
$estatus=$reg[estatus]-2000;
?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Estatus:</font></b></td>
<?php echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'>$estatus</font></td>"; ?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Resumen:</font></b></td>

<?php
$res_dist=pg_exec("SELECT * FROM stppatee WHERE nro_derecho='$nderec' ");
$regdis = pg_fetch_array($res_dist);
?>

<? 
$resumen=$regdis[resumen];
utf8_decode($resumen);
    echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'>$resumen</font></td>";

?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Tramitante/Agente:</font></b></td>

<?php
//   Busqueda de tramitante y varios agentes
        $res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente = '$nagen'");
	$regage = pg_fetch_array($res_agen);
	//echo $regage['agente'];
	if ($regage['agente']<= 0)
           { $tram = trim($reg['tramitante']); }
	if ($regage['agente']> 0)
	   {$tram= "Codigo: ".$regage['agente']." ".trim(utf8_decode($regage['nombre']));
	    $res_agen1=pg_exec("SELECT stzagenr.agente, stzagenr.nombre  FROM stzautod,stzagenr WHERE stzautod.nro_derecho ='$nderec' and stzagenr.agente = stzautod.agente");
	    $regage1 = pg_fetch_array($res_agen1);
	    $filas_found_agen=pg_numrows($res_agen1);
	    if ($filas_found_agen <> 0){
	     for ($j=0; $j<$filas_found_agen; $j++){
		if ($regage1['agente'] == $regage['agente']){$regage1 = pg_fetch_array($res_agen1);}
		else{
 		   $tram= $tram."  /   Codigo: ".$regage1['agente']." ".trim(utf8_decode($regage1['nombre']));}
		$regage1 = pg_fetch_array($res_agen1);
	     }
            }
	}
  echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'>$tram</font></td>"; 

?>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Inventores:</font></b></td>
<? 

    echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'>";

	for($cont=0;$cont<$filas_cons_inv;$cont++) { 
	 $inventor= utf8_decode($reg_inv['nombre_inv']);
         echo $inventor;
	 echo " ; ";
	 $reg_inv = pg_fetch_array($cons_inv);
	}

?>   

	</font></td>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Clasif. Internac.:</font></b></td>
 
<? 

    echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'>";
	 for($cont=0;$cont<$filas_clasif;$cont++) { 
		echo $regclasf['tipo_clas'];
		echo "=";
	      echo $regclasf['clasificacion'];
		echo " ; ";
		$regclasf = pg_fetch_array($cons_clas);
	}

?>
	</font></td>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Locarno:</font></b></td>

<? 

    echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'> ";
	 for($cont=0;$cont<$filas_cons_clasl;$cont++) { 
	      echo $reg_clasl['clasi_locarno'];
		$reg_clasl = pg_fetch_array($cons_clasl);
		echo " ; ";
	}

?>
	</font></td>
  </tr>
  <tr>
    <td width="17%" align="right" style="background-color: #015B9E; border: 1 solid #C6DEF2"><b><font color="#FFFFFF" face="MS Sans Serif" size="2">Prioridad:</font></b></td>
<? 
    echo "    <td width='83%' colspan='2' style='background-color: #7AC0EF; border: 1 solid #C6DEF2'><font face='Tahoma' font size='2'>";
	for($cont=0;$cont<$filas_cons_pri;$cont++) { 
	      echo $reg_pri['prioridad'];
		$reg_pri = pg_fetch_array($cons_pri);
		echo " ; ";
	}

?>   
	</font></td>
  </tr>
</table>

<p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
<table border="0" cellpadding="0" cellspacing="1" width="100%">
  <tr>
    <td width="10%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>C&oacute;digo</b></font></td>
    <td width="30%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Nombre</b></font></td>
    <td width="20%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Nacionalidad</b></font></td>
    <td width="20%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Domicilio</b></font></td>
  
  </tr>
  <?php
   for($cont=0;$cont<$filas_cons_tit;$cont++) 
     {
      echo "<tr>";
      echo "<td width='10%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma' font size='2'>$reg_tit[titular]</font></td>";
      $titular= utf8_decode($reg_tit[nombre]);
      echo "<td width='30%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma' font size='2'>$titular</font></td>";
      $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg_tit[nacionalidad]' and pais!=''");
      $respai = pg_fetch_array($res_pais);
      echo "<td width='20%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma' font size='2'>$reg_tit[nacionalidad]/$respai[nombre]</font></td>";
      $domic=utf8_decode($reg_tit[domicilio]);
      echo "<td width='20%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma' font size='2'>$domic</font></td>";  
      echo "</tr>";
      $reg_tit = pg_fetch_array($cons_tit);
     }
  ?>
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
                       WHERE  nprensa = '$vcod'  AND stzderec.tipo_mp='P' 
                       AND stzderec.solicitud = stzprensa.solicitud ");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="p_gbprensa.php" name="formtitular" method="post"> 
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
