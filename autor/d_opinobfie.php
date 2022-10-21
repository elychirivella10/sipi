<?php
// *************************************************************************************
// Programa: d_opinobfie.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2006
// Modificado Año 2009 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

?>

<html>
<head>
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head> 
<body onload="centrarwindows()" bgcolor="#D8E6FF"> 

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$sql = new mod_db();
$usuario = $_SESSION['usuario_login'];

$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];
$vtip=$_GET['vtip'];

//echo "<p align='center'><b>SOLICITUD No.: $vsol $vmod $vtex $vtip </b></p>";
echo "<p align='center'><b>SOLICITUD No.: $vsol</b></p>";

if (empty($vsol)) { 
   echo "<hr>";
   echo "<p align='center'><b>INTRODUZCA PRIMERO EL NUMERO DE SOLICITUD</b>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close()'></font></p>";
   exit;
}

//Verificando conexion
$sql->connection($usuario);

 if ($vmod=='Incluir Obra Fijada' || $vmod=='Incluir Obra Int/Eje')
 {
   switch ($vtip) {
     case "Fijadas":
       echo "<small><p align='center'><b>INGRESE OBRA FIJADA NUEVA</p></small></b>"; 
       break;
     case "Interpretada":
       echo "<small><p align='center'><b>INGRESE OBRA INTERPRETADA/EJECUTADA NUEVA</p></small></b>";
       break;
     case "Ejecutada":
       echo "<small><p align='center'><b>INGRESE OBRA EJECUTADA NUEVA</p></small></b>";
       break;
   }
   ?>
   <form name="frmnatjur" id="frmnatjur" action="d_gbobrfie.php" method="POST" >
   <?php
     echo "<input type='hidden' name='vsol' value='$vsol'>";
     echo "<input type='hidden' name='vmod' value='$vmod'>";
     echo "<input type='hidden' name='vtip' value='$vtip'>";
     echo "<input type='hidden' name='vfil' value='0'>";
     echo "<input type='hidden' name='accion' value='incluir'>";
     echo "<table align='center' border='0' cellpadding='0' cellspacing='0' width='94%'>";
     echo "<tr>";
     echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
     echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b></b></font></td>";
     echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
     echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;</font></td>";
     echo "</tr>";
     if ($vmod=='Incluir Obra Fijada' || $vmod=='Incluir Obra Int/Eje') {
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>T&iacute;tulo:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vnom' value='$vtex' size='63' maxlength='70' onKeyup='this.value=this.value.toUpperCase()'></font></td>";          
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Autor(es):</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vaut' size='63' maxlength='70' onKeyup='this.value=this.value.toUpperCase()'></b></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Arreglos:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='varr' size='63' maxlength='70' onKeyup='this.value=this.value.toUpperCase()'></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Interprete:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vint' size='63' maxlength='70' onKeyup='this.value=this.value.toUpperCase()'></b></font></td>";
       echo "</tr>";
       $res_genero=pg_exec("SELECT * FROM stdgener ORDER BY desc_genero");
       $filas_genero=pg_numrows($res_genero);
       $reggen = pg_fetch_array($res_genero);
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Tipo o Genero:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<select size='1' name='vgen'>";
       for($cont=0;$cont<$filas_genero;$cont++) { 
         echo "<option value=$reggen[cod_genero]>$reggen[cod_genero] $reggen[desc_genero]</option>";
         $reggen = pg_fetch_array($res_genero);
       }
       echo "</select></font></td>";
       echo "</tr>";
     }
   echo "<tr>";
   echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
   echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b></b></font></td>";
   echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
   echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;</font></td>";
   echo "</tr>";
   echo "</table>";
   //echo "<p align='center'><input type='submit' name='incluir' value='Grabar Nueva Obra'>
   //                        <input type='button' name='salir' value='Salir' onclick='window.close()'></p>";
   echo "<p align='center'><input type='image' name='incluir' value='Grabar Nuevo Solicitante' src='../imagenes/save_f2.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                           <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
   echo "</form>";
   exit;
 }
 
 if ($vmod=='Modificar Obra Fijada' || $vmod=='Modificar Obra Int/Eje')
 {
   switch ($vtip) {
     case "Fijadas":
       echo "<small><p align='center'><b>MODIFICAR OBRA FIJADA $vtex</p></small></b>"; 
       break;
     case "Interpretada":
       echo "<small><p align='center'><b>MODIFICAR OBRA INTERPRETADA $vtex</p></small></b>";
       break;
     case "Ejecutada":
       echo "<small><p align='center'><b>MODIFICAR OBRA EJECUTADA $vtex</p></small></b>";
       break;
   }
   ?>
   <form name="frmnatjur" id="frmnatjur" action="d_gbobrfie.php" method="POST" >
   <?php
     echo "<input type='hidden' name='vsol' value='$vsol'>";
     echo "<input type='hidden' name='vmod' value='$vmod'>";
     echo "<input type='hidden' name='vtip' value='$vtip'>";
     echo "<input type='hidden' name='vtex' value='$vtex'>";     
     echo "<input type='hidden' name='vfil' value='0'>";
     echo "<input type='hidden' name='accion' value='modificar'>";
     echo "<table align='center' border='0' cellpadding='0' cellspacing='0' width='94%'>";
     $nbtabla="stdtmpfie";
     $res_fie=pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$vsol' and nro_obfinej='$vtex'");
     $filas_obfie=pg_numrows($res_fie);
     if ($filas_obfie!=0) { 
       $regfie = pg_fetch_array($res_fie); 
       $vnom = $regfie[titulo_obfie];
       $vaut = $regfie[nombre_autor];
       $varr = $regfie[arreglista];
       $vint = $regfie[interprete];
       $vgen = $regfie[tipo_obfie];
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b></b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;</font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>T&iacute;tulo:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vnom' value='$vnom' size='63' maxlength='70' onKeyup='this.value=this.value.toUpperCase()'></font></td>";          
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Autor(es):</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vaut' value='$vaut' size='63' maxlength='70' onKeyup='this.value=this.value.toUpperCase()'></b></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Arreglos:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='varr' value='$varr' size='63' maxlength='70' onKeyup='this.value=this.value.toUpperCase()'></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Interprete:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vint' value='$vint' size='63' maxlength='70' onKeyup='this.value=this.value.toUpperCase()'></b></font></td>";
       echo "</tr>";
       $res_genero=pg_exec("SELECT * FROM stdgener ORDER BY desc_genero");
       $filas_genero=pg_numrows($res_genero);
       $reggen = pg_fetch_array($res_genero);
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Tipo o Genero:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<select size='1' name='vgen'>";
       for($cont=0;$cont<$filas_genero;$cont++) { 
         echo "<option value=$reggen[cod_genero]>$reggen[cod_genero] $reggen[desc_genero]</option>";
         $reggen = pg_fetch_array($res_genero);
       }
       echo "</select></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b></b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;</font></td>";
       echo "</tr>";
       echo "</table>";
       //echo "<p align='center'><input type='submit' name='incluir' value='Actualizar Obra'>
       //                        <input type='button' name='salir' value='Salir' onclick='window.close()'></p>";
       echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/save_f2.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                               <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
       echo "</form>";
       exit;
     }
     else { 
       $vmessage= "Error: El C&oacute;digo NO esta asignado a la Solicitud ...!!!";
       echo "<p align='center'>&nbsp;</p>";
       echo "<p align='center'>&nbsp;</p>";
       echo "<p align='center'>&nbsp;</p>";
       echo "<small><H3><p align='center'><img src='../imagenes/messagebox_warning.png' align='middle'>$vmessage</p></H3></small>"; 
       echo "<p align='center'><img src='../imagenes/exit.png' border='0' onclick='window.close()'>Salir</p>";       
     }
 } 
?>
</body>
</html>
