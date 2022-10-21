<script language="javascript">
 function cerrarwindows2() {
   window.opener.frames[0].location.reload();
   window.opener.frames[1].location.reload();
   window.opener.frames[2].location.reload();
   window.opener.frames[3].location.reload();
   window.close();
 }
</script>

<?php
  include ("../setting.inc.php");
  require ("../include.php");
  include ("/apl/librerias/library.php");
?>
<html><head>
<title>Servicio Autonomo de la Propiedad Intelectual</title>
</head><body onload="centrarwindows()" bgcolor="F9F7ED">   
<?php

//Variable
$sql = new mod_db();
$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];

echo "<p align='center'><b>Solicitud: $vsol</b></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><b>Introduzca primero el Numero de Prioridad que desea Incluir</b>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   exit;
   }

//Verificando conexion
$sql->connection();

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
       echo "<p align='center'><b>INGRESO DE NUEVA PRIORIDAD</p></b>"; 
       ?>
       <form action="m_gbpriorid.php" name="formtitular" method="POST" >
       <?php
       echo "<input type='hidden' name='vsol' value='$vsol'>";
       echo "<input type='hidden' name='vmod' value='$vmod'>";
       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='0' cellpadding='0' cellspacing='0' width='99%'>";
       echo "<tr>";
       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>&nbsp;"; 
       echo "</td></tr>"; 
       echo "<tr><td></td></tr>";       
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<p align='right' style='margin-top: 2; margin-bottom: 2'>";
       echo "<small><font color='#FFFFFF' face='MS Sans Serif'><b>* Numero:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      &nbsp;<input type='text' name='vnum' value='$vtex' size='20' maxlength='20' onkeydown='codigotecla(document.formtitular.vfec)'></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<small><p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>Fecha:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vfec' size='10' maxlength='10'></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       $filas_res_pais=pg_numrows($res_pais);
       $reg = pg_fetch_array($res_pais);
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<small><p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>Pa&iacute;s:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<select size='1' name='vnac' onkeydown='codigotecla(document.formtitular.vdom)'>";
        for($cont=0;$cont<$filas_res_pais;$cont++) 
        { 
          echo "<option value=$reg[pais]>$reg[pais] $reg[nombre]</option>";
          $reg = pg_fetch_array($res_pais);
        }
       echo "      </select></font></td>";
       echo "</tr>";

       echo "<tr><td></td></tr>";
       echo "<tr><td></td></tr>";       
       echo "<tr><td></td></tr>";       
       echo "<tr><td></td></tr>";

       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>";
	    echo "<font size='1'> * Campos Obligatorios</font>";
       echo "</td></tr>"; 
       echo "<tr><td></td></tr>";
      
       echo "</table>";   
       echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/save_f2.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                           <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
       echo "</form>";
       exit;
   }
  }
?>

 <?php
 if ($vmod=='Buscar/Eliminar' || $vmod=='Eliminar')
  {$resultado=pg_exec("SELECT * FROM stztmprio WHERE solicitud='$vsol' AND tipo_mp='M'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="m_gbpriorid.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><b>Seleccione la(s) Prioridad(es) que desea eliminar:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font>Sel</td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>N&uacute;mero</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Fecha</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Pa&iacute;s</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'> <input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[prioridad]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[fecha_priori]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[pais_priori]</font></td>";
     echo "<input type='hidden' name='num$cont' value='$reg[prioridad]'>";
     echo "<input type='hidden' name='fec$cont' value='$reg[fecha_priori]'>";
     echo "<input type='hidden' name='pai$cont' value='$reg[pais_priori]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUNA PRIORIDAD ASOCIADA</p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";

      echo "<input type='submit' value='Eliminar' name='eliminar' >
            <input type='button' value='Salir' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   echo "</form>";
  }

?>
</body>
</html>
