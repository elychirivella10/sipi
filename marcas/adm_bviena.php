<script language="javascript">
function cerrarwindows3(){
  window.opener.frames[0].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: adm_bviena.php 
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

//Verificacion de Conexion 
$sql->connection($usuario);   

$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=trim($_GET['vtex']);

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Asignaci&oacute;n de C&oacute;digos de Viena a Solicitud de Pedido Gr&aacute;fico'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


echo "<p align='center'><b>SOLICITUD DE PEDIDO No.: $vsol</b></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><b>AVISO: INTRODUZCA PRIMERO EL NUMERO DE SOLICITUD DE PEDIDO ...!!!</b>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows3()'></font></p>";
   exit;
   }

//Paginacion 
if(strlen($_POST['adelante']) > 0)
  $adelante = "1";
if(strlen($_POST['atras']) > 0)
  $atras = "1";
$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total = $_POST['total'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 15;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vtex']=$vtex;
$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$$cuanto;
$hiddenvars['total']=$total;

 if ($vmod=='Buscar/Incluir') {
   $vtex1c = substr($vtex,0,1);
   $vtexag = substr($vtex,1);
   if ($vtex1c=='-') {
     $resultado=pg_exec("SELECT * FROM stmviena WHERE ccv = '$vtexag' OFFSET $inicio LIMIT $cuanto");
     $cantidad =pg_exec("SELECT * FROM stmviena WHERE ccv = '$vtexag'");
   } else {
       $resultado=pg_exec("SELECT * FROM stmviena WHERE descripcion like '%$vtex%' OFFSET $inicio LIMIT $cuanto");
       $cantidad =pg_exec("SELECT * FROM stmviena WHERE descripcion like '%$vtex%'"); }
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
       echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>ERROR: NO EXISTE EL Codigo de Viena Buscado ...!!!</b></font></p>"; 
       ?>
       <form action="updatitular.php" name="formtitular" method="POST" >
       <?php
//       echo "<input type='hidden' name='vsol' value='$vsol'>";
//       echo "<input type='hidden' name='vmod' value='$vmod'>";
//       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<div align='center'>";
       echo "<table align='center' border='0' cellpadding='0' cellspacing='0' width='960px'>";
       echo "<tr>";
//       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
//       echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>NOMBRE:</b></font></td>";
//       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
//       echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vnom' value='$vtex' size='56' onkeydown='codigotecla(document.formtitular.vpai)'></font></td>";
//       echo "</tr>";
//            $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
//            $filas_res_pais=pg_numrows($res_pais);
//            $reg = pg_fetch_array($res_pais);
//       echo "<tr>";
//       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
//       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>PAIS RESIDENCIA:</b></font></td>";
//       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
//       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<select size='1' name='vpai' onkeydown='codigotecla(document.formtitular.vnac)'>";
//             for($cont=0;$cont<$filas_res_pais;$cont++) 
//             { 
//             echo "<option value=$reg[pais]>$reg[pais]$reg[nombre]</option>";
//             $reg = pg_fetch_array($res_pais);
//             }
//       echo "      </select></font></td>";
//       echo "</tr>";
//            $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
//            $filas_res_pais=pg_numrows($res_pais);
//            $reg = pg_fetch_array($res_pais);
//       echo "<tr>";
//       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
//       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>NACIONALIDAD:</b></font></td>";
//       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
//       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<select size='1' name='vnac' onkeydown='codigotecla(document.formtitular.vdom)'>";
//             for($cont=0;$cont<$filas_res_pais;$cont++) 
//             { 
//             echo "<option value=$reg[pais]>$reg[pais]$reg[nombre]</option>";
//             $reg = pg_fetch_array($res_pais);
//             }
//       echo "      </select></font></td>";
//       echo "</tr>";
//       echo "<tr>";
//       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
//       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>DOMICILIO:</b></font></td>";
//       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
//       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vdom' size='56'</font></td>";
       echo "</tr>";
       echo "</table>";   
       echo "</div>";
       echo "<p align='center'>&nbsp;
             <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png'></p>";
       echo "</form>";
       exit;
   }
//   ?>
   <p align='center'><b><font size='3' face='Tahoma' color='#0000FF'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Solicitudes Encontradas </font></b></p>
   <?php
   echo "<div align='center'>";
   echo "<p align='center'><b>SELECCIONE LOS CODIGOS DE VIENA QUE DESEA ASOCIAR:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='960px'>";
   echo "<tr>";
   echo " <td width='1%'  class='columna-titulo'><small>Sel</small></td>";   
   echo " <td width='10%' class='columna-titulo'><small>C&oacute;digo</small></td>";
   echo " <td width='40%' class='columna-titulo'><small>Descripci&oacute;n</small></td>";
   echo "</tr>";
   echo "<form name='formti' method='POST' action='m_gbccv.php'>"; 
   for($cont=0;$cont<$filas_resultado;$cont++) {
     echo "<tr>";
     echo " <td width='1%'  class='celda2'><input type='checkbox' name='B$cont'></td>";
     echo " <td width='10%' class='celda2'><small>$reg[ccv]</small></td>";
     echo " <td width='40%' class='celda2'><small>$reg[descripcion]</small></td>";
     echo "</tr>";
     $titacum[$cont]=$reg[ccv];
     $nomacum[$cont]=utf8_decode($reg[descripcion]);
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   for($cont=0;$cont<$filas_resultado;$cont++) {
          echo "<input type='hidden' name='vtit$cont' value='$titacum[$cont]'>";
          echo "<input type='hidden' name='vnom$cont' value='$nomacum[$cont]'>";
   } 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vfil' value='$filas_resultado'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";

   //echo "<p align='center'><font color='#0000FF'>"; <p align='center'> </p>
   echo "</div>";
   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
   echo "<input type='image' name='salir' value='Incluir' src='../imagenes/boton_guardar_rojo.png' alt='Save' align='middle' border='0' />&nbsp
                              <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' />";       
   echo "</form>";
   echo "<form method='POST' action='adm_bviena.php?vsol=$vsol&vmod=$vmod&vtex=$vtex'>"; 
   echo "<div align='center'>";
   ?>
   <input type="hidden" name="adelante">
   <input type="hidden" name="atras">
   <?
   foreach($hiddenvars as $var => $val)
   {
   ?>
   <input type="hidden" name="<?= $var ?>" value="<?= $val ?>" />
   <?
   }
   if($inicio > 0)
   {
   ?>
   <!-- <input type="submit" class="boton_blue" name="atras" value="Previos <?= min($inicio, $cuanto) ?>" /> -->
   <input type="image" src="../imagenes/boton_previos_azul.png" name="atras" value="Previos <?= min($inicio, $cuanto) ?>" > <?= min($inicio, $cuanto) ?>  
   <?
   }
   else
   {
   //espacio  &nbsp;
   }
   if($total - $inicio > $cuanto)
   {
   ?>
   <!-- <input type='submit' class="boton_blue" name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' /> -->
   <input type="image" src="../imagenes/boton_siguiente_azul.png" name="adelante" value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' > <?= min(($total - ($inicio + $cuanto)), $cuanto)?>
   <?
   }
   else
   {
   //espacio    &nbsp;
   }
   echo "</div>";
   echo "</form>";
   
  }
 
 if ($vmod=='Buscar/Eliminar') { 
   $resultado=pg_exec("SELECT * FROM stmtmpccv,stmviena WHERE solicitud='$vsol' and stmtmpccv.ccv=stmviena.ccv");
   $filas_found=pg_numrows($resultado);
   if ($filas_found==0) { 
     $resultado=pg_exec("SELECT * FROM stmviena,stmcvbgra WHERE stmcvbgra.solicitud='$vsol' AND stmviena.ccv=stmcvbgra.ccv ORDER BY stmcvbgra.ccv");
     $filas_found=pg_numrows($resultado);  
   }
   $reg=pg_fetch_array($resultado);
   ?>
   <form action="m_gbccv.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<div align='center'>";
   echo "<p align='center'><b>SELECCIONE LOS CODIGOS QUE DESEA ELIMINAR:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='960px'>";
   echo "<tr>";
   echo " <td width='1%'  class='columna-titulo'>Sel</td>";   
   echo " <td width='10%' class='columna-titulo'>C&oacute;digo</td>";
   echo " <td width='40%' class='columna-titulo'>Descripci&oacute;n</td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%'  class='celda2'><input type='checkbox' name='B$cont'></td>";
     echo " <td width='10%' class='celda2'><small>$reg[ccv]</small></td>";
     echo " <td width='40%' class='celda2'><small>$reg[descripcion]</small></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[ccv]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[descripcion]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>ERROR: NINGUN CODIGO VIENA ASOCIADO ...!!!</p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='image' name='aceptar' value='Aceptar' onclick='cerrarwindows3()' src='../imagenes/boton_salir_rojo.png'></p>";
            //<input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows3()'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";
      //echo "<input type='submit' class='boton_blue' value='Eliminar' name='eliminar' >
      //      <input type='button' class='boton_blue' value='Salir' name='aceptar' onclick='cerrarwindows3()'></font></p>";
       
      echo "<input type='image' src='../imagenes/boton_eliminar_rojo.png' value='Eliminar'>
            <input type='image' src='../imagenes/boton_salir_rojo.png' value='Salir' onclick='cerrarwindows2()'></p>";

   }
   echo "</div>";
   echo "</form>";
  }

  $smarty->display('pie_pag.tpl');

//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
