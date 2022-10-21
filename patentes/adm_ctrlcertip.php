<script language="javascript">
function cerrarwindows3() {
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: adm_ctrlcerti.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2012 BD - Relacional I Semestre 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>SIPI - Sistema de Informaci&oacute;n de Propiedad Intelectual</title>
</head> 
<body onload="centrarwindows()" bgcolor="#FFFFFF"> 

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Control de Certificados de Registro de Marcas'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificacion de Conexion 
$sql->connection($usuario);   

$vreg=trim($_GET['vreg']);
$vmod=$_GET['vmod'];
$vcod=$_GET['vcod'];

echo "<br>";
echo "<p align='center'><font size='4' face='Tahoma' color='#0000FF'><b>CONTROL DE CERTIFICADOS No: $vcod</b></font></p>";
if ($vmod=='Buscar/Incluir') {
  echo "<p align='center'><font size='4' face='Tahoma' color='#0000FF'><b>REGISTRO No: $vreg</b></font></p>";
}  
if (($vreg=='') AND ($vmod=='Buscar/Incluir')) {
   echo "<br>";
   echo "<hr>";
   echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: DEBE COLOCAR PRIMERO EL NUMERO DE REGISTRO PARA INGRESARLO ...!!</b></font></p>";
   echo "<hr>";
   echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
   echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
   $smarty->display('pie_pag.tpl');
   exit;
   }

$hiddenvars['vreg']=$vreg;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vcod']=$vcod;

 if ($vmod=='Buscar/Incluir') {
 
   $resultado=pg_exec("SELECT * FROM stmtmpcer WHERE control = '$vcod'");
   $reg=pg_fetch_array($resultado);
   $filas_registro=pg_numrows($resultado);
   
   if ($filas_registro==10){
     echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: LLEGO AL MAXIMO DE CERTIFICADOS DE REGISTRO PERMITIDOS A ENTREGAR ...!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
     echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
     $smarty->display('pie_pag.tpl');
     exit();    
   }
 
   //$resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
   //                     WHERE b.registro = '$vreg'AND
   //                        b.estatus = 1555 AND
   //                        a.evento = 1840 AND 
   //                        b.nro_derecho = a.nro_derecho AND                        
   //                        b.tipo_mp='M'");
   //$filas_evento = pg_numrows($resultado);
   //if($filas_evento==1) {
   //  echo "<p align='center'><font size='3' face='Tahoma' color='#000000'><b>AVISO: El Certificado de Registro ya fue entregado, favor solicitar una Copia Certificada ...!!!</b></font></p>";
   //  echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
   //  echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
   //  $smarty->display('pie_pag.tpl');
   //  exit();       
   //}

   $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.registro = '$vreg'AND
                           b.estatus = 1555 AND
                           a.evento = 1835 AND 
                           b.nro_derecho = a.nro_derecho AND                        
                           b.tipo_mp='M'");
   $filas_evento = pg_numrows($resultado);
   $regc=pg_fetch_array($resultado);
   $vdoc=$regc[documento];
   $vcom=$regc[comentario];
   $vfec=$regc[fecha_trans];
   $vdocom =$vdoc.", ".$vcom.", presentado el d&iacute;a: ".$vfec;       
   if ($filas_evento>1) {
     //echo "<p align='center'><font size='3' face='Tahoma' color='#000000'><b>AVISO: El Registro ya presenta una solicitud de tr&aacute;mite con el N&uacute;mero Control: $vdocom ...!!!</b></font></p>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#000000'><b>AVISO: El Registro ya lleg&oacute; al tope m&aacute;ximo de (2) Tr&aacute;mites para Corregir/Firmar, debe solicitar una Copia Certificada ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
     $smarty->display('pie_pag.tpl');
     exit();       
   }

   $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.registro = '$vreg'AND
                           b.estatus = 1555 AND
                           a.evento = 1838 AND 
                           b.nro_derecho = a.nro_derecho AND                        
                           b.tipo_mp='M'");
   $filas_evento = pg_numrows($resultado);
   $regc=pg_fetch_array($resultado);
   $vdoc=$regc[documento];
   $vcom=$regc[comentario];
   $vfec=$regc[fecha_trans];
   $vdocom =$vdoc.", ".$vcom.", presentado el d&iacute;a: ".$vfec;       
   if ($filas_evento>1) {
     //echo "<p align='center'><font size='3' face='Tahoma' color='#000000'><b>AVISO: El Registro ya presenta una solicitud de tr&aacute;mite con el N&uacute;mero Control: $vdocom ...!!!</b></font></p>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#000000'><b>AVISO: El Registro ya lleg&oacute; al tope m&aacute;ximo de (2) Tr&aacute;mites para Corregir/Firmar, debe solicitar una Copia Certificada ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
     $smarty->display('pie_pag.tpl');
     exit();       
   }

   $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.registro = '$vreg'AND
                           b.estatus = 1555 AND
                           a.evento = 1840 AND 
                           b.nro_derecho = a.nro_derecho AND                        
                           b.tipo_mp='M'");
   $filas_evento = pg_numrows($resultado);
   $regc=pg_fetch_array($resultado);
   $vdoc=$regc[documento];
   $vcom=$regc[comentario];
   $vfec=$regc[fecha_trans];
   $vdocom =$vdoc.", ".$vcom.", presentado el d&iacute;a: ".$vfec;       
   if ($filas_evento>1) {
     //echo "<p align='center'><font size='3' face='Tahoma' color='#000000'><b>AVISO: El Registro ya presenta una solicitud de tr&aacute;mite con el N&uacute;mero Control: $vdocom ...!!!</b></font></p>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#000000'><b>AVISO: El Registro ya lleg&oacute; al tope m&aacute;ximo de (2) Tr&aacute;mites para Corregir/Firmar, debe solicitar una Copia Certificada ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
     $smarty->display('pie_pag.tpl');
     exit();       
   }

   $resultado=pg_exec("SELECT * FROM stzevtrd a, stzderec b 
                        WHERE b.registro = '$vreg'AND
                           b.estatus = 1555 AND
                           a.evento = 1841 AND 
                           b.nro_derecho = a.nro_derecho AND                        
                           b.tipo_mp='M'");
   $filas_evento = pg_numrows($resultado);
   $regc=pg_fetch_array($resultado);
   $vdoc=$regc[documento];
   $vcom=$regc[comentario];
   $vfec=$regc[fecha_trans];
   $vdocom =$vdoc.", ".$vcom.", presentado el d&iacute;a: ".$vfec;       
   if ($filas_evento>1) {
     //echo "<p align='center'><font size='3' face='Tahoma' color='#000000'><b>AVISO: El Registro ya presenta una solicitud de tr&aacute;mite con el N&uacute;mero Control: $vdocom ...!!!</b></font></p>";
     echo "<p align='center'><font size='3' face='Tahoma' color='#000000'><b>AVISO: El Registro ya lleg&oacute; al tope m&aacute;ximo de (2) Tr&aacute;mites para Corregir/Firmar, debe solicitar una Copia Certificada ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
     echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
     $smarty->display('pie_pag.tpl');
     exit();       
   }

   $resultado=pg_exec("SELECT * FROM stmmarce a, stzderec b 
                        WHERE b.registro = '$vreg'AND
                           b.estatus = 1555 AND
                           b.nro_derecho = a.nro_derecho AND                        
                           b.tipo_mp='M'");
  
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0) {
     echo "<p align='center'><font size='3' face='Tahoma' color='#000000'><b>ERROR: No Existe el Expediente o no esta en el Estatus Indicado ...!!!</b></font></p>";
     echo "<p align='center'><input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir'></p>";       
     echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
     $smarty->display('pie_pag.tpl');
   }
else {   
       ?>
       <form action="m_gbctrlcer.php" name="formtitular" method="POST" >

       <?php
        $vsol = $reg[solicitud]; 
        
   echo "<input type='hidden' name='vreg' value='{$vreg}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   
$varsol=$reg[solicitud];

//imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
$varsolj=$varsol1.$varsol2;
//$nameimage=ver_imagen($varsol1,$varsol2,'M');
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


<table border="0" cellpadding="0" cellspacing="1" width="100%">
  <tr colspan='3'>
    <td width="17%" class="celda-titulo"><b>Solicitud No.:</b></td>    
<?php echo "    <td width=$vporc class='celda2' colspan='2'><b>$reg[solicitud]</b></td>";
if ( file($nameimage))
   { echo "  <td width='22%' rowspan='10' class='celda2'><a href='$nameimage' target='_blank'><img border='0' src=$nameimage width='90%' height='90%'></td></a>"; 
   }
?>
  </tr>
  <tr>
    <td width="17%" class="celda-titulo"><b>Registro No.:</b></td>
<?php echo "    <td width=$vporc class='celda2'><b>$reg[registro]</b></td>"; ?>
  </tr>
  <tr>
    <td width="17%" class="celda-titulo"><b>Fecha Solicitud:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$reg[fecha_solic]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class="celda-titulo"><b>Tipo Marca:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$reg[tipo_derecho]-$vtip</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class="celda-titulo"><b>Modalidad:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$resmod[modalidad]-$vmod</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class="celda-titulo"><b>Nombre:</b></td>
<?php echo "    <td width='83%' class='celda2' colspan='2'><b>$reg[nombre]</b></td>"; ?>
  </tr>
  <tr>
    <td width="17%" class="celda-titulo"><b>Clase:</b></td>
<?php echo "    <td width=$vporc class='celda2'><b>$resmod[clase]$vcla</b></td>"; ?>
  </tr>
  <tr>
    <td width="17%" class="celda-titulo"><b>Pais:</b></td>
<?php echo "    <td width=$vporc class='celda2'>$reg[pais_resid]-$respai[nombre]</td>"; ?>
  </tr>
  <tr>
 <? $estatus= $reg[estatus]-1000; ?>
    <td width="17%" class="celda-titulo"><b>Estatus:</b></td>
<?php echo "    <td width='83%' class='celda2' colspan='2'><b>$estatus -$restat[descripcion]</b></td>"; ?>
  </tr>
  <tr>
    <td width="17%" class="celda-titulo"><b>Distingue:</b></td>

<?php
//$res_dist=pg_exec("SELECT * FROM stmmarce WHERE nro_derecho='$nderec'");
//$regdis = pg_fetch_array($res_dist); colspan='2'
?>

<?php echo "    <td width='83%' class='celda2' colspan='2'>$resmod[distingue]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class="celda-titulo"><b>Poder:</b></td>
<?php echo "    <td width='83%' class='celda2' colspan='2'>$reg[poder]</td>"; ?>
  </tr>
  <tr>
    <td width="17%" class="celda-titulo"><b>Tramitante/Agente:</b></td>
      <?php
        $agentram = agente_tramp($nagen,$reg[tramitante],$npoder);
        echo "    <td width='83%' class='celda2' colspan='2'>$agentram</td>";
      ?>
  </tr>
  </tr>
</table>

<p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="08%" class="columna-titulo"><b>C&oacute;digo</b></td>
    <td width="10%" class="columna-titulo"><b>Identificaci&oacute;n</b></td>
    <td width="30%" class="columna-titulo"><b>Nombre</b></td>
    <td width="20%" class="columna-titulo"><b>Domicilio</b></td>
    <td width="16%" class="columna-titulo"><b>Pa&iacute;s</b></td>
  </tr>
  <?php

$resultado = pg_exec("SELECT stzottid.titular, stzsolic.identificacion, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) 
     {
      echo "<tr>";
      echo "<td width='08%' class='celda2'>$reg[titular]</td>"; 
      echo "<td width='10%' class='celda2'>$reg[identificacion]</td>"; 
      echo "<td width='30%' class='celda2'><b>$reg[nombre]</b></td>";
      $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[nacionalidad]' and pais!=''");
      $respai = pg_fetch_array($res_pais);
      echo "<td width='20%' class='celda2'>$reg[domicilio]</td>";
      echo "<td width='16%' class='celda2'>$reg[nacionalidad] - $respai[nombre]</td>";
      echo "</tr>";
      $reg = pg_fetch_array($resultado);
     }
  ?>
  </tr>
</table>

<?php
   echo "<p align='center'>";
   echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/boton_guardar_rojo.png' alt='Save' align='middle' border='0' />
                           <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
   exit;
   }
} 

$evento= $evto+1000;
 if ($vmod=='Buscar/Eliminar') {
 
   $resultado=pg_exec("SELECT * FROM stmtmpcer WHERE control = '$vcod'");
   $resultado=pg_exec("SELECT stmtmpcer.registro, stzderec.nombre FROM stzderec, stmtmpcer 
                       WHERE  stmtmpcer.control = '$vcod' AND stzderec.tipo_mp='M' 
                       AND stzderec.nro_derecho = stmtmpcer.nro_derecho");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="m_gbctrlcer.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vreg' value='{$vreg}'>";
   echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   echo "<input type='hidden' name='vmod' value='{$vmod}'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><b>SELECCIONE LOS CODIGOS QUE DESEA ELIMINAR:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' class='Estilo5'>Sel</td>";   
   echo " <td width='10%' class='Estilo5'>REGISTRO</td>";
   echo " <td width='40%' class='Estilo5'>NOMBRE</td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' class='izq6a-color'><input type='checkbox' name='B$cont'></td>";
     echo " <td width='10%' class='izq6a-color'><small>$reg[registro]</small></td>";
     echo " <td width='40%' class='izq6a-color'><small>$reg[nombre]</small></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[registro]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre]'>";

     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>ERROR: NINGUN NUMERO DE REGISTRO ASOCIADO ...!!!</p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows3()'></font></p>";
   }
   else
   {  
       echo "<p align='center'>";
       echo "<p align='center'><input type='image' name='eliminar' value='Eliminar' src='../imagenes/boton_eliminar_rojo.png' align='middle' border='0' />&nbsp
                               <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' align='middle' border='0' /></p>";       
   }
   echo "</form>";
   echo "<br><br><br>";
   $smarty->display('pie_pag.tpl');
  }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
