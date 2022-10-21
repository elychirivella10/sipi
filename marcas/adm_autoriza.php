<script language="javascript">
 function cerrarwindows2() {
   window.opener.frames[0].location.reload();
   window.opener.frames[1].location.reload();
   window.close();
 }
</script>

<?php
// ************************************************************************************* 
// Programa: adm_autoriza.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2014 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>SIPI - Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head><body onload="centrarwindows()" bgcolor="FFFFFF">
   
<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

//Variable
$vcod=$_GET['vcod'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];


$smarty->display('encabezado1.tpl');

echo "<p align='center'><b>Control de Certificado No.: $vcod</b></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><b>Introduzca primero el Nombre del Autorizado que desea Incluir</b>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
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
  $cuanto = 12;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['vcod']=$vcod;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vtex']=$vtex;
$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$$cuanto;
$hiddenvars['total']=$total;

 if ($vmod=='Buscar/Incluir') {
   $filas_resultado=0;
   if ($filas_resultado==0){
       echo "<p align='center'><b>DATOS DEL AUTORIZADO</p></b>"; 
       ?>
       <form action="m_gbautoriza.php" name="formtitular" method="POST" >
       <?php
       echo "<input type='hidden' name='vcod' value='$vcod'>";
       echo "<input type='hidden' name='vmod' value='$vmod'>";
       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='0' cellpadding='1' cellspacing='1' width='100%'>";
       echo "<tr>";
       echo "<tr><td></td></tr>";       
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'>* Nombre:</td>";
       echo "   <td width='77%' class='der-color'>";
       echo "    <input type='text' name='vnom' value='$vtex' size='80' maxlength='120' onkeydown='codigotecla(document.formtitular.vced)'></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'>* Cedula:</td>";
       echo "   <td width='77%' class='der-color'>";
       echo "  &nbsp;<select size='1' name='vcodl'>";
       echo "  <option value='V'>V</option>";
       echo "  <option value='E'>E</option>";
       echo "  <option value='P'>P</option>";
       echo "  </select>";
       echo "  <input type='text' name='vced' size='9' maxlength='9' onKeyPress='return acceptChar(event,2,this)' onKeyup='checkLength(event,this,9,document.formtitular.salir)' onchange='Rellena(document.formtitular.vced,9)'></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr><td></td></tr>";       
       echo "<tr>";
	    echo "<td>";
	    echo "<font size='1'> * Campos Obligatorios</font>";
       //echo "</td></tr>"; 
       echo "</td></tr>"; 
       echo "<tr><td></td></tr>";
      
       echo "</table>";   
       echo "<p align='center'>";
       echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/boton_guardar_rojo.png' alt='Save' align='middle' border='0' />
                               <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";       
       echo "</form>";
       $smarty->display('pie_pag.tpl');
       exit;
   }
  }
?>

 <?php
 if ($vmod=='Buscar/Eliminar') {
   $resultado=pg_exec("SELECT * FROM stmpceraut WHERE control='$vcod'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="m_gbautoriza.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vcod' value='$vcod'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><b>Seleccione el Autorizado que desea Eliminar:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='01%' class='Estilo5'>Sel</td>";   
   echo " <td width='10%' class='Estilo5'>C&eacute;dula</td>";
   echo " <td width='80%' class='Estilo5'>Nombre</td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='01%' class='celda3'><input type='checkbox' name='B$cont'></td>";
     echo " <td width='10%' class='izq6a-color'>$reg[cedula_aut]</td>";
     echo " <td width='80%' class='izq6a-color'>$reg[nombre_aut]</td>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre_aut]'>";
     echo "<input type='hidden' name='ced$cont' value='$reg[cedula_aut]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUN AUTORIZADO ASOCIADO</p>";
      echo "<p align='center'><input type='image' name='salir' value='Aceptar' src='../imagenes/boton_salir_rojo.png' alt='Save' align='middle' border='0' /></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";
      echo "<input type='image' name='salir' value='Eliminar' src='../imagenes/boton_eliminar_rojo.png' align='middle' border='0' />
            <input type='image' name='aceptar' value='Salir' onclick='cerrarwindows3()' src='../imagenes/boton_salir_rojo.png' align='middle' border='0'/></p>";   }
   echo "</form>";
   $smarty->display('pie_pag.tpl');
  }

//Desconexion de la Base de Datos
$sql->disconnect();
  
?>
</body>
</html>
