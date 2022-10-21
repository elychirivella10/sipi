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
   echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='cerrarwindows3()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
   exit;
   }

$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vcod']=$vcod;
$hiddenvars['evto']=$evto;

if (($vmod=='Buscar/Incluir') OR ($vmod=='Buscar/Incluir_32') OR ($vmod=='Buscar/Incluir_33')) {
  $resultado=pg_exec("select * from $tbname_1 WHERE solicitud='$vsol' AND nprensa = '$vcod' AND tipo_mp='P'");
  $reg=pg_fetch_array($resultado);
  $filas_registro=pg_numrows($resultado);
  if ($filas_registro!=0){
    echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: SOLICITUD YA CARGADA CON ESTA MISMA PRENSA EN ESTE MISMO ACTO ...!!</b></font></p>";
    echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
    exit();
  }      
}

 if (($vmod=='Buscar/Incluir') or ($vmod=='Buscar/Incluir_32')  or ($vmod=='Buscar/Incluir_33')) {
   if ($vmod=='Buscar/Incluir') {
     $resultado=pg_exec("SELECT * FROM stppatee a, stzderec b  WHERE 
                           b.solicitud = '$vsol' AND b.solicitud!='0000-000000'  AND
                           b.estatus IN (2004,2005,2011) AND
                           b.nro_derecho = a.nro_derecho and                       
                           b.tipo_mp='P'"); }
   if (($vmod=='Buscar/Incluir_32') OR ($vmod=='Buscar/Incluir_33')) {
     $resultado=pg_exec("SELECT * FROM stppatee a, stzderec b  WHERE 
                           b.solicitud = '$vsol' AND b.solicitud!='0000-000000'  AND
                           b.estatus IN (2004,2005,2011) AND
                           b.nro_derecho = a.nro_derecho and                       
                           b.tipo_mp='P'"); }
  
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: No Existe el Expediente o no esta en el Estatus Indicado ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='cerrarwindows3()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
   }
else {   
       ?>
       <form action="p_gbprensa.php" name="formtitular" method="POST" >
       <?php
        $vsol = $reg[solicitud]; 
   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='evto' value='{$evto}'>";

$varsol=$reg['solicitud'];
$vnumsol=$reg['solicitud'];
$nderec=$reg['nro_derecho'];

 $res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$reg[estatus]' and tipo_mp = 'P' order by estatus");
 $restat = pg_fetch_array($res_estatus);

$res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[pais_resid]' and pais!=''");
$respai = pg_fetch_array($res_pais);

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

//imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
$varsolj=$varsol1.$varsol2;
$nameimage="../graficos/patentes/di".$varsol1."/".$varsolj.".jpg";
//$nameimage=ver_imagen($varsol1,$varsol2,'P');

$vporc='83%';
if (file($nameimage))
   {$vporc='55%';} 
?>

<table border="0" cellpadding="0" cellspacing="1" width="100%">
  <tr>
    <td width="17%" class='celda-titulo'><b>Solicitud:</b></td>
<?php echo "    <td width=$vporc class='celda2' >$reg[solicitud]</td>"; 

//if ( file($nameimage))
//   { echo "  <td width='22%' rowspan='8' align='center' style='background-color: #FFFFFF; border: 1 solid #000000'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='150' height='150'></td></a>"; 
//   }
if ( file($nameimage)) {
  echo "<td width='22%' class='celda2' rowspan='7'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='100%' height='100%'></td></a>"; 
}
 ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Fecha Solicitud:</b></td>
<?php echo "    <td width=$vporc class='celda2' >$reg[fecha_solic]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Tipo Patente:</b></td>
<?php echo "    <td width=$vporc class='celda2' >$reg[tipo_derecho]/$vtip</td>"; ?>
  </tr>

  <tr>
    <td width="17%" class='celda-titulo'><b>Pais:</b></td>
<?php echo "    <td width=$vporc class='celda2' >$reg[pais_resid]/$respai[nombre]</td>"; ?>
  </tr>
<? 
$estatus=$reg['estatus'];
$registro=$reg['registro'];

?>
  <tr>
    <td width="17%" class='celda-titulo'><b>Titulo:</b></td>
<? 
    $nombre=$reg[nombre];
    utf8_decode($nombre);
    echo "    <td width=$vporc  class='celda2'>$nombre</td>";
?>
<?php
 $estatus=$reg[estatus]-2000;
 echo "<input type='hidden' name='vest' value='{$estatus}'>";
?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Estatus:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$estatus -$restat[descripcion]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Fecha Vencimiento:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$reg[fecha_venc]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Resumen:</b></td>
<?php
$res_dist=pg_exec("SELECT * FROM stppatee WHERE nro_derecho='$nderec' ");
$regdis = pg_fetch_array($res_dist);
?>

<? 
$resumen=$regdis[resumen];
utf8_decode($resumen);
    echo "    <td width=$vporc colspan='2' class='celda2'>$resumen</td>";
?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Tramitante/Agente:</b></td>

<?php
   //Busqueda de tramitante y varios agentes
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
  echo " <td width=$vporc class='celda2' colspan='2'>$tram</td>"; 
?>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Inventores:</b></td>
<? 
   echo "    <td width=$vporc class='celda2' colspan='2'>";
	for($cont=0;$cont<$filas_cons_inv;$cont++) { 
	 $inventor= utf8_decode($reg_inv['nombre_inv']);
         echo $inventor;
	 echo " ; ";
	 $reg_inv = pg_fetch_array($cons_inv);
	}

?>   
	</td>
  </tr>
  <tr>
    <td width="17%" class='celda-titulo'><b>Prioridad:</b></td>
<? 
   echo "    <td width=$vporc class='celda2' colspan='2'>";
	for($cont=0;$cont<$filas_cons_pri;$cont++) { 
	      echo $reg_pri['prioridad'];
		$reg_pri = pg_fetch_array($cons_pri);
		echo " ; ";
	}
?>   
	</td>
  </tr>
</table>

<p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
<table border="0" cellpadding="0" cellspacing="1" width="100%">
  <tr>
    <td width="10%" class='columna-titulo'><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>C&oacute;digo</b></font></td>
    <td width="30%" class='columna-titulo'><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Nombre</b></font></td>
    <td width="20%" class='columna-titulo'><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Nacionalidad</b></font></td>
    <td width="20%" class='columna-titulo'><font color="#FFFFFF" face="MS Sans Serif" size="2"><b>Domicilio</b></font></td>
  
  </tr>
  <?php
   for($cont=0;$cont<$filas_cons_tit;$cont++) 
     {
      echo "<tr>";
      echo "<td width='10%' class='celda2'>$reg_tit[titular]</td>";
      $titular= utf8_decode($reg_tit[nombre]);
      echo "<td width='30%' class='celda2'>$titular</td>";
      $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg_tit[nacionalidad]' and pais!=''");
      $respai = pg_fetch_array($res_pais);
      echo "<td width='20%' class='celda2'>$reg_tit[nacionalidad]/$respai[nombre]</td>";
      $domic=utf8_decode($reg_tit[domicilio]);
      echo "<td width='20%' class='celda2'>$domic</td>";  
      echo "</tr>";
      $reg_tit = pg_fetch_array($cons_tit);
     }
  ?>
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
   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND (evento=2201 AND estat_ant=2002)");   
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

   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND (evento=2022 AND estat_ant=2004)");   
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

   $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND (evento=2023 AND estat_ant=2005)");   
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
       //echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/save_f2.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
       //                        <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
       echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/boton_guardar_rojo.png' alt='Save' align='middle' border='0' />
                               <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
       exit;
   }
} 

 $evento= $evto+2000;
 if (($vmod=='Buscar/Eliminar')  or ($vmod=='Buscar/Eliminar_32')  or ($vmod=='Buscar/Eliminar_33')) {
 
   if ($vmod=='Buscar/Eliminar') {
       $resultado=pg_exec("SELECT stzprensa.solicitud, nombre FROM stzderec, stzprensa 
                       WHERE  nprensa = '$vcod'  AND stzderec.tipo_mp='P' 
                       AND stzderec.solicitud = stzprensa.solicitud 
                       AND evento IN (2022,2023,2031)"); }
   else {	
   $resultado=pg_exec("SELECT stzprensa.solicitud, nombre FROM stzderec, stzprensa 
                       WHERE  nprensa = '$vcod'  AND stzderec.tipo_mp='P' 
                       AND stzderec.solicitud = stzprensa.solicitud 
                       AND evento= $evento");}
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
 //  echo "evento: $evento";
   ?>
   <form action="p_gbprensa.php" name="formtitular" method="post"> 
   <?php 
  //    echo "fila: $filas_found";
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
   if ($filas_found==0){echo "<p align='center'>NINGUN NUMERO DE SOLICITUD ASOCIADO</p>";
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
