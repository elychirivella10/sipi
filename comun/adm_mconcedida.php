<script language="javascript">
function cerrarwindows3() {
  window.opener.frames[0].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: adm_mconcedida.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2016 BD - Relacional II Semestre 
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

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$fechahoy= hoy();

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado2.tpl');

$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vcod=$_GET['vcod'];
$vbol=trim($_GET['vbol']);
$vtip=$_GET['vtip'];
$pmar=$_GET['pmar'];
$vtot=$pmar;

$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vcod']=$vcod;
$hiddenvars['vbol']=$vbol;
$hiddenvars['vtip']=$vtip;
$hiddenvars['pmar']=$pmar;
$hiddenvars['vtot']=$vtot;

 if ($vmod=='Buscar/Incluir')  {
 	
   if($vtip=='M') {
     echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_marca'>";
     echo "  <td>";
     echo "    <i><b><font>Servicio de Pago de Derechos de Registro de Marca Nacional</font></b></i>";
     echo "  </td>";
     echo "</table>"; 
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>SOLICITUD DE MARCA: $vsol, TRAMITE: $vcod</b></font></p>";
   }
 	
   if ($vsol=='-') { 
     echo "<br>";
     echo "<hr>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO:  INTRODUZCA PRIMERO EL NUMERO DEL EXPEDIENTE ...!!</b></font></p>";
     echo "<hr>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
     echo "<br>";
     $smarty->display('pie_pag.tpl'); exit();
   }

   if ($vtot=='0') {
      echo "<br>";
      echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: LA CANTIDAD DE PAGOS DE DERECHOS DE MARCAS INGRESADA POR USTED ES 0 ...!!</b></font></p>";
      echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
      echo "<br>";
      $smarty->display('pie_pag.tpl'); exit();    
     }

     //Verificacion de Conexion 
     $sql = new mod_db();
     $sql->connection();   

     $resultado=pg_exec("SELECT * FROM stmpagoder WHERE nro_tramite = '$vcod'");
     $reg=pg_fetch_array($resultado);
     $filas_registro=pg_numrows($resultado);
     if ($filas_registro==$vtot){
      echo "<br>";
      echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: LLEGO AL TOPE DE PAGOS DE DERECHOS SEGUN TRAMITE ...!!</b></font></p>";
      echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
      echo "<br>";
      $smarty->display('pie_pag.tpl'); exit();    
     }

   // Datos del Expediente de Marcas a Mostrar 
   if($vtip=='M') {

     $resultado=pg_exec("SELECT * FROM stmpagoder WHERE solicitud = '$vsol'");
     $filas_pub = pg_numrows($resultado);
     if ($filas_pub!=0) {
       $regpub = pg_fetch_array($resultado);
       $vtrapub = $regpub['nro_tramite'];  
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol YA asociada a otro Tr&aacute;mite ($vtrapub) de Pagos de Derechos WEBPI...!!!</b></font></p>";
       echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
       $smarty->display('pie_pag.tpl'); 
       //$sql->disconnect(); 
       exit();       
     }

   //Verificacion de Conexion 
   $sql1 = new mod_db();
   $sql1->connection1();  

   $resultado=pg_exec("SELECT * FROM stzderec WHERE solicitud = '$vsol' AND tipo_mp='M'");
   $filas_stat = pg_numrows($resultado);
   if ($filas_stat==0) {
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol NO Existe en la Base de Datos ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     $smarty->display('pie_pag.tpl'); 
     //$sql->disconnect(); 
     exit();       
   }
   else {
     $regest = pg_fetch_array($resultado);
     $vest = $regest['estatus'];  
     if (($vest!=1400)) {
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol en Estatus diferente de Concedida (400) ...!!!</b></font></p>";
       echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
       $smarty->display('pie_pag.tpl'); 
       //$sql->disconnect(); 
       exit();       
     }
   }

   //Validacion de Boletin
   $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.solicitud = '$vsol' AND
                           a.evento in (1122) AND 
                           a.estat_ant in (1101) AND
                           a.documento = $vbol AND  
                           b.nro_derecho = a.nro_derecho AND
                           b.estatus IN (1400) AND                         
                           b.tipo_mp='M'");

   $filas_evento = pg_numrows($resultado);
   if ($filas_evento==0) {
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: Solicitud $vsol NO ha sido Concedida en el Bolet&iacute;n $vbol ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     $smarty->display('pie_pag.tpl'); 
     //$sql->disconnect(); 
     exit();       
   }
   $regeve = pg_fetch_array($resultado);
   $vbol = $regeve['documento']; 
   $vfevb = $regeve['fecha_venc'];  
   
   $esmayor=compara_fechas($fechahoy,$vfevb);
   //if ($esmayor==1) {
   //  echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: La presente Solicitud tiene Orden de Publicaci&oacute;n en Prensa en el Bolet&iacute;n No.: $vbol ...!!!</b></font></p>";
   //  echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>Y La Fecha tope para para Publicar en Prensa era hasta el $vfevb ...!!!</b></font></p>";
   //  echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
   //  exit();       
   //}

   $extemporanea="N";
   $tipo_plazo = "D";
   $plazo_ley = 0;
   $fechapub = calculo_fechas($fechahoy,$plazo_ley,$tipo_plazo,"/");
   $esmayor=compara_fechas($fechapub,$vfevb);
   if ($esmayor==1) { $extemporanea="S"; }
 	
   $resultado=pg_exec("SELECT * FROM stmmarce a, stzderec b  WHERE 
                           b.solicitud = '$vsol' AND b.solicitud!='0000-000000'  AND
                           b.estatus IN (1400) AND
                           b.nro_derecho = a.nro_derecho and                       
                           b.tipo_mp='M'");
  
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>No Existe el No. de Solicitud o NO esta en el Estatus Indicado ...!!!</b></font></p>"; }
   else {   
       ?>
       <form action="m_gbpagoder.php" name="formtitular" method="POST" >

       <?php
        $vsol = $reg['solicitud']; 
        
   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='vbol' value='{$vbol}'>";
   echo "<input type='hidden' name='vtip' value='{$vtip}'>";
   echo "<input type='hidden' name='pmar' value='{$pmar}'>";
   echo "<input type='hidden' name='vtot' value='{$vtot}'>";
      
   $varsol=$reg['solicitud'];

   //imagen
   $varsol1=substr($varsol,-11,4);
   $varsol2=substr($varsol,-6,6);
   $varsolj=$varsol1.$varsol2;
   //$nameimage="../graficos/marcas/ef".$varsol1."/".$varsolj.".jpg";

   $res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$reg[estatus]'");
   $restat = pg_fetch_array($res_estatus);

   $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[pais_resid]' and pais!=''");
	$respai = pg_fetch_array($res_pais);

	$res_mod=pg_exec("SELECT * FROM stmmarce WHERE nro_derecho='$reg[nro_derecho]' ");
	$resmod = pg_fetch_array($res_mod);

	if ($resmod['modalidad']=='D') {$vmod='DENOMINATIVA';}
	if ($resmod['modalidad']=='M') {$vmod='MIXTA';}
	if ($resmod['modalidad']=='G') {$vmod='GRAFICA';}

	if ($reg['tipo_derecho']=='M') {$vtipo='MARCA DE PRODUCTO';}
	if ($reg['tipo_derecho']=='N') {$vtipo='NOMBRE COMERCIAL';}
	if ($reg['tipo_derecho']=='L') {$vtipo='LEMA COMERCIAL';}
	if ($reg['tipo_derecho']=='S') {$vtipo='MARCA DE SERVICIO';}
	if ($reg['tipo_derecho']=='C') {$vtipo='MARCA COLECTIVA';}
	if ($reg['tipo_derecho']=='D') {$vtipo='DENOMINACION COMERCIAL';}
	if ($reg['tipo_derecho']=='O') {$vtipo='DENOMINACION DE ORIGEN';}

	if ($resmod['ind_claseni']=='N') {$vcla='NACIONAL';}
	if ($resmod['ind_claseni']=='I') {$vcla='INTERNACIONAL';}

	$nregis=$reg['registro'];
	$nsolic=$reg['solicitud'];
	$nderec=$reg['nro_derecho'];
	$nagen=trim($reg['agente']);
   $vnom=trim($reg['nombre']);

	echo "<input type='hidden' name='vder' value='{$nderec}'>"; 
	echo "<input type='hidden' name='vnom' value='{$vnom}'>"; 

	if (empty($nagen)) { $nagen=0; } 
	$vporc='83%';
	if ($reg['modalidad']!="D")
	   {$vporc='55%';} 

	?>

	<table border="0" cellpadding="0" cellspacing="1" width="100%">
	  <tr>
	    <td width="8%" class='Estilo5'><b>Solicitud:</b></td>
	<?php echo "    <td width=$vporc class='celda2'><b>$reg[solicitud]</b></td>"; 
	//if ( file($nameimage))
	//   { echo "  <td width='22%' rowspan='7' class='celda2'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='150' height='150'></td></a>"; 
	//   }
	?>
	  </tr>
	  <tr>
	    <td width="8%" class='Estilo5'><b>Fecha Solicitud:</b></td>
	<?php echo "    <td width=$vporc class='celda2'>$reg[fecha_solic]</td>"; ?>
	  </tr>
	  <tr>
	    <td width="8%" class='Estilo5'><b>Tipo Marca:</b></td>
	<?php echo "    <td width=$vporc class='celda2'>$reg[tipo_derecho]-$vtipo</td>"; ?>
	  </tr>
	  <tr>
	    <td width="8%" class='Estilo5'><b>Modalidad:</b></td>
	<?php echo "    <td width=$vporc class='celda2'>$resmod[modalidad]-$vmod</td>"; ?>
	  </tr>
	  <tr>
	    <td width="8%" class='Estilo5'><b>Clase:</b></td>
	<?php echo "    <td width=$vporc class='celda2'>$resmod[clase]$vcla</td>"; ?>
	  </tr>
	  <tr>
	    <td width="8%" class='Estilo5'><b>Nombre:</b></td>
	<?php echo "    <td width='83%' colspan='2' class='celda2'>$reg[nombre]</td>"; ?>
	  </tr>
	  <tr>
	 <? $estatus= $reg['estatus']-1000; ?>
	    <td width="8%" class='Estilo5'><b>Estatus:</b></td>
	<?php echo "    <td width='83%' colspan='2' class='celda2'><b>$estatus -$restat[descripcion]</b></td>"; ?>
	  </tr>
	  <tr>
	    <td width="8%" class='Estilo5'><b>Distingue:</b></td>


	<?php echo "    <td width='83%' colspan='2' class='celda2'>$resmod[distingue]</td>"; ?>
	  </tr>

	<?php
	  $reg['poder'] = trim($reg['poder']);
	  if (!empty($reg['poder'])) { ?>
  <tr>
    <td width="8%" class='Estilo5'><b>Poder No.:</b></td>
	<?php echo "    <td width='83%' colspan='2' class='celda2'>$reg[poder]</td>"; ?>
	  </tr>
	<?php  } ?>
	  <tr>
	    <td width="8%" class='Estilo5'><b>Tramitante/Agente:</b></td>

	<?php
	$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente=$nagen");
	$regage = pg_fetch_array($res_agen);
	if ($reg['agente']<=0)
	   { 
	   echo "    <td width='83%' colspan='2' class='celda2'>$reg[tramitante]</td>"; 
	   }
	if ($reg['agente']>0)
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
	if (!empty($regpri['prioridad']))
	   { 
	   $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$regpri[pais_priori]' and pais!=''");
	   $respai = pg_fetch_array($res_pais);
	   $infadi='Prioridad: '.$regpri['prioridad'].' en: '.$respai['nombre'].' de fecha: '.$regpri['fecha_priori'];
	   }
	if (!empty($reglic['licencia']))
	   { 
	   $infadi=$infadi . 'Licencia: '. $reglic['licencia'];
	   }
	?>

	  </tr>
	</table>

	<p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
	<table border="0" cellpadding="1" cellspacing="1" width="100%">
   <tr>
	  <tr>
	    <td width="10%" class='Estilo5'><b>C&oacute;digo</b></td>
	    <td width="30%" class='Estilo5'><b>Nombre</b></td>
	    <td width="20%" class='Estilo5'><b>Pa&iacute;s</b></td>
	    <td width="20%" class='Estilo5'><b>Domicilio</b></td>
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


	<p align="center"><b><font size="4" face="Tahoma">Datos de la Publicaci&oacute;n en Bolet&iacute;n </font></b></p>
	<table border="0" cellpadding="1" cellspacing="1" width="100%">
   <tr>
     <td width="10%" class='Estilo5'>Fecha Evento</td>
     <td width="10%" class='Estilo5'>Vencimiento Evento</td>
     <td width="10%" class='Estilo5'>N Documento</td>
     <td width="10%" class='Estilo5'>C&oacute;digo del Evento</td>
     <td width="20%" class='Estilo5'>Descripci&oacute;n</td>
     <td width="10%" class='Estilo5'>Fecha de Transacci&oacute;n</td>
     <td width="30%" class='Estilo5'>Comentarios</td>
   </tr>
   <?php
     $resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento in (1122) AND documento=$vbol AND estat_ant in (1101)");   
     $filas_found=pg_numrows($resultado);
     $reg = pg_fetch_array($resultado);
     for($cont=0;$cont<$filas_found;$cont++) 
     { 
       $evento= $reg['evento']-1000;
       echo "<tr>";
       echo "<td width='10%' class='celda2'>$reg[fecha_event]</td>";
       echo "<td width='10%' class='celda2'>$reg[fecha_venc]</td>";
       echo "<td width='10%' class='celda2'>$reg[documento]</td>";
       echo "<td width='10%' class='celda2'>$evento</td>";
       echo "<td width='20%' class='celda2'>$reg[desc_evento]</td>";
       echo "<td width='10%' class='celda2'>$reg[fecha_trans]</td>";
       echo "<td width='30%' class='celda2'>$reg[comentario]</td>";
       echo "</tr>";
       $vfevb = $reg['fecha_venc'];
       $reg = pg_fetch_array($resultado);
     }
   ?>
	</table>

	<?php
   echo "<p align='center'>";
   echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/boton_grabar_azul.png' alt='Save' align='middle' border='0' />&nbsp
                           <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
   $smarty->display('pie_pag.tpl');
   exit;
   }
   } // Fin de vtip=M
} 

 if ($vmod=='Buscar/Eliminar') {

   echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_patente'>";
   echo "  <td>";
   echo "    <i><b><font>Servicio de Solicitud de Pagos de Derechos de Registro de Marca Nacional</font></b></i>";
   echo "  </td>";
   echo "</table>"; 
 	
   echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>TRAMITE: $vcod</b></font></p>";

   //Verificacion de Conexion 
   $sql = new mod_db();
   $sql->connection();   

   $resultado=pg_exec("SELECT * FROM stmpagoder WHERE nro_tramite = '$vcod'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="m_gbpagoder.php" name="formtitular" method="post"> 
   <?php 
   if($filas_found==0){
     echo "<br>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: NO hay Solicitudes con Pagos de Derechos asociadas al Tramite ...!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
     echo "<br>";
     $smarty->display('pie_pag.tpl'); exit();    
   }

   echo "<input type='hidden' name='vsol' value='{$vsol}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='vbol' value='{$vbol}'>";
   echo "<input type='hidden' name='vtot' value='{$vtot}'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   
   echo "<p align='center'><b>SELECCIONE LAS SOLICITUDES QUE DESEA ELIMINAR:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='01%' class='Estilo5'>Sel</td>";   
   echo " <td width='10%' class='Estilo5'>SOLICITUD</td>";
   echo " <td width='40%' class='Estilo5'>NOMBRE</td>";
   echo " <td width='08%' class='Estilo5'>M/P</td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='01%' class='celda2'><input type='checkbox' name='B$cont'></td>";
     echo " <td width='10%' class='celda2'><small>$reg[solicitud]</small></td>";
     echo " <td width='40%' class='celda2'><small>$reg[nombre]</small></td>";
     echo " <td width='08%' class='celda2'><small>$reg[tipo_mp]</small></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[nro_derecho]'>";
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
   $smarty->display('pie_pag.tpl');
   exit;
  }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
