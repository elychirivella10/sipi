<script language="javascript">
 function cerrarwindows2() {
   window.opener.frames[0].location.reload();
   window.opener.frames[1].location.reload();
   window.opener.frames[2].location.reload();
   window.opener.frames[3].location.reload();
   window.opener.frames[4].location.reload();
   window.close();
 }
</script>

<?php
  //include ("../setting.inc.php");
  //require ("../include.php");
  //include ("/apl/librerias/library.php");
  include ("../z_includes.php");
  // ************************************************************************************* 
  // Programa: adm_priorid.php 
  // Realizado por el Analista de Sistema Romulo Mendoza 
  // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
  // Año: 2009 BD - Relacional 
  // *************************************************************************************
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head>
<body onload="centrarwindows()">   
<?php
//bgcolor="F9F7ED" 
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];

$sql = new mod_db();
$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];
$vder=$_GET['vtip'];

echo "<p align='center'><font class='nota5'><I><b>Solicitud: $vsol</b></I></font></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><font class='nota3'><b>Introduzca primero el Numero de Prioridad que desea Incluir</b></font></p>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   exit;
   }

//Verificando conexion
$sql->connection($usuario);

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
  $cuanto = 12;

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

 if ($vmod=='Buscar/Incluir' || $vmod=='Buscar')
  {$resultado=pg_exec("SELECT * FROM stzpriod WHERE prioridad like '$vtex%' ORDER BY fecha_priori OFFSET $inicio LIMIT $cuanto");
   $cantidad =pg_exec("SELECT * FROM stzpriod WHERE prioridad like '$vtex%'");
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   $filas_resultado=0;
   
   if ($filas_resultado==0){
       echo "<p align='center'><font class='nota3'><b>INGRESO DE NUEVA PRIORIDAD</b></font></p>"; 
       ?>
       <form action="../comun/m_gbpriorid.php" name="formtitular" method="POST" >
       <?php
       echo "<input type='hidden' name='vsol' value='$vsol'>";
       echo "<input type='hidden' name='vmod' value='$vmod'>";
       echo "<input type='hidden' name='vder' value='$vder'>";
       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='1' cellpadding='0' cellspacing='1' width='99%'>";
       echo "<tr>";
       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>&nbsp;</td></tr>";  
       //echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "  <td width='23%' class='izq-color'><small><b>* Numero:</b></small></td>";
       echo "  <td width='77%' class='der-color'>";
       //echo "    &nbsp;<input type='text' name='vnum' value='$vtex' size='20' maxlength='20' onkeydown='codigotecla(document.formtitular.vfec)' onKeyPress='return acceptChar(event,12, this)'></td>";
       echo "    &nbsp;<input type='text' name='vnum' value='$vtex' size='20' maxlength='20' onkeydown='codigotecla(document.formtitular.vfec)' ></td>";
       echo "</tr>";
       //echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "  <td width='23%' class='izq-color'><small><b>Fecha:</b></small></td>";
       echo "  <td width='77%' class='der-color'>";
       echo "    &nbsp;<input type='text' name='vfec' size='10' maxlength='10'></td>";
       echo "</tr>";
       //echo "<tr><td></td></tr>";
       $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       $filas_res_pais=pg_numrows($res_pais);
       $reg = pg_fetch_array($res_pais);
       echo "<tr>";
       echo "  <td width='23%' class='izq-color'><small><b>Pa&iacute;s:</b></small></td>";
       echo "  <td width='77%' class='der-color'>";
       echo "    &nbsp;<select size='1' name='vnac' onkeydown='codigotecla(document.formtitular.vdom)'>";
        for($cont=0;$cont<$filas_res_pais;$cont++) 
        { 
          echo "<option value=$reg[pais]>$reg[pais] $reg[nombre]</option>";
          $reg = pg_fetch_array($res_pais);
        }
       echo "      </select></td>";
       echo "</tr>";
       //echo "<tr><td></td></tr>";
       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>";
	    echo "<font size='1'> * Campos Obligatorios</font>";
       echo "</td></tr>"; 
       echo "<tr><td></td></tr>";
      
       echo "</table>";   
       echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/boton_guardar_rojo.png' alt='Save' align='middle' border='0' />
                               <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
       echo "</form>";
       exit;
   }
  }
?>

 <?php
 if ($vmod=='Buscar/Eliminar' || $vmod=='Eliminar')
  {$resultado=pg_exec("SELECT * FROM stztmprio WHERE solicitud='$vsol' AND tipo_mp='$vder'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="../comun/m_gbpriorid.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vder' value='$vder'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><font class='nota3'><b>Seleccione la(s) Prioridad(es) que desea eliminar:</b></font></p>";
   echo "<table border='1' cellpadding='0' cellspacing='1' width='100%'>";
   echo "<tr>";
   echo " <td width='1%'  class='celda4'>Sel</td>";   
   echo " <td width='10%' class='celda4'>N&uacute;mero</td>";
   echo " <td width='40%' class='celda4'>Fecha</td>";
   echo " <td width='40%' class='celda4'>Pa&iacute;s</td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%'  class='celda3'><input type='checkbox' name='B$cont'></td>";
     echo " <td width='10%' class='celda3'>$reg[prioridad]</td>";
     echo " <td width='40%' class='celda3'>$reg[fecha_priori]</td>";
     echo " <td width='40%' class='celda3''>$reg[pais_priori]</td>";
     echo "<input type='hidden' name='num$cont' value='$reg[prioridad]'>";
     echo "<input type='hidden' name='fec$cont' value='$reg[fecha_priori]'>";
     echo "<input type='hidden' name='pai$cont' value='$reg[pais_priori]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'><font class='nota3'>NINGUNA PRIORIDAD ASOCIADA</font></p>";
      //<input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'>
      echo "<p align='center'><font color='#0000FF'>
            <input type='image' name='salir' value='Salir' onclick='cerrarwindows2()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";
      //echo "<input type='submit' class='boton_blue' value='Eliminar' name='eliminar' >
      //      <input type='button' class='boton_blue' value='Salir' name='aceptar' onclick='cerrarwindows2()'></font></p>";
      echo "<input type='image' src='../imagenes/boton_eliminar_rojo.png' value='Eliminar'>
            <input type='image' src='../imagenes/boton_salir_rojo.png' value='Salir' onclick='cerrarwindows2()'></p>";
   }
   echo "</form>";
  }

?>
</body>
</html>
