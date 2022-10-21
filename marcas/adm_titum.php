<script language="javascript">
  function cerrarwindows2() {
    window.opener.frames[0].location.reload();
    window.close(); }
</script>

<?php
// *************************************************************************************
// Programa: adm_titum.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: Semestre I 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autónomo de la Propiedad Intelectual</title>
</head>
<body onload="centrarwindows()">   

<?php
//#D8E6FF  bgcolor="F9F7ED"  
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

//Variables    
$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];
$vder=$_GET['vtip'];

if (empty($vder)) { $vder=$_POST['vder']; }

echo "<p align='center'><font class='nota5'><I><b>Solicitud: $vsol</b></I></font></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><font class='nota3'><b>Introduzca primero el Titular que desea Incluir</b></font>";
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

$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vtex']=$vtex;
$hiddenvars['vtip']=$vtip;
$hiddenvars['vder']=$vder;
$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$$cuanto;
$hiddenvars['total']=$total;

 if ($vmod=='Buscar/Incluir' || $vmod=='Buscar')
  {$resultado=pg_exec("SELECT * FROM stzsolic WHERE nombre like '%$vtex%' ORDER BY nombre OFFSET $inicio LIMIT $cuanto");
   $cantidad =pg_exec("SELECT * FROM stzsolic WHERE nombre like '%$vtex%'");
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);

   if ($filas_resultado==0){
       echo "<p align='center'><font class='nota3'><b>INGRESO DE TITULAR NUEVO</b></font></p>"; 
       ?>
       <form action="m_gbtitum.php" name="formtitular" method="POST" >
       <?php
       echo "<input type='hidden' name='vsol' value='$vsol'>";
       echo "<input type='hidden' name='vmod' value='$vmod'>";
       echo "<input type='hidden' name='vder' value='$vder'>";
       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='1' cellpadding='0' cellspacing='1' width='99%'>";
       echo "<tr>";
       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>&nbsp;"; 
       echo "</td></tr>"; 
       echo "<tr>";       
       echo "  <td width='23%' class='izq-color'><small><b>C&eacute;dula/Rif:</b></small></td>";
       echo "  <td width='77%' class='der-color'>";
       echo "  &nbsp;<select size='1' name='vcodl'>";
       echo "   <option value='V'>V</option>";
       echo "   <option value='E'>E</option>";
       echo "   <option value='P'>P</option>";
       echo "   <option value='J'>J</option>";
       echo "   <option value='G'>G</option>";
       echo "  </select>";
       echo "<input type='text' name='vcod' value='$vcod' size='9' maxlength='9' onKeyup='checkLength(event,this,9,document.formtitular.vnom)' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.formtitular.vcod,9)'></b>";
	    echo "<font size='1'>&nbsp;&nbsp;V= Venezolano  E= Extranjero  P= Pasaporte  J= Juridico  G= Gobierno</font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "  <td width='23%' class='izq-color'><small><b>* Nombre:</b></small></td>";
       echo "  <td width='77%' class='der-color'>";
       echo "    &nbsp;<input type='text' name='vnom' value='$vtex' size='68' maxlength='200' onkeydown='codigotecla(document.formtitular.vdom)'></td>";
       echo "</tr>";
       echo "<tr>";
       echo "  <td width='23%' class='izq-color'><small><b>* Domicilio:</b></small></td>";
       echo "  <td width='77%' class='der-color'>";
       echo "    &nbsp;<input type='text' name='vdom' size='68' maxlength='200'></td>";
       echo "</tr>";
       $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       $filas_res_pais=pg_numrows($res_pais);
       $reg = pg_fetch_array($res_pais);
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>* Nacionalidad:</b></small></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "       &nbsp;<select size='1' name='vnac' onkeydown='codigotecla(document.formtitular.vdom)'>";
        for($cont=0;$cont<$filas_res_pais;$cont++) 
        { 
          echo "<option value=$reg[pais]>$reg[pais] $reg[nombre]</option>";
          $reg = pg_fetch_array($res_pais);
        }
       echo "      </select></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "  <td width='23%' class='izq-color'><small><b>* Indole:</b></small></td>";
       echo "  <td width='77%' class='der-color'>";
       echo " &nbsp;<select size='1' name='vind'>";
       echo "   <option value='P'>Empresa Privada</option>";
       echo "   <option value='N'>Persona Natural</option>";
       echo "   <option value='G'>Sector Publico</option>";
       echo "   <option value='C'>Cooperativas</option>";
       echo "   <option value='O'>Comunales</option>";
       echo " </select></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>Tel&eacute;fono 1:</b></small></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "      &nbsp;<input type='text' name='tlf1' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.formtitular.tlf2)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>Tel&eacute;fono 2:</b></small></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "      &nbsp;<input type='text' name='tlf2' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.formtitular.vfax)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>Fax:</b></small></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "      &nbsp;<input type='text' name='vfax' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.formtitular.vemail)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>E-Mail:</b></small></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "       &nbsp;<input type='text' name='vemail' size='68' maxlength='200'></td>";
       echo "</tr>";
       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>";
	    echo "<font size='1'> * Campos Obligatorios</font>";
       echo "</td></tr>"; 
       echo "<tr><td></td></tr>";
      
       echo "</table>";   
       echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/database_save.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                           <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
       echo "</form>";
       exit;
   }
   echo "<p align='center'><font class='nota3'><b>Seleccione el Titular que desea Incluir:</b></font></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font><small>Sel</small></td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Codigo</small></font></td>";
   echo " <td width='50%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Nombre</small></font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Domicilio</small></font></td>";
   echo " <td width='5%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Nac.</small></font></td>";
   echo " <td width='5%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Ind.</small></font></td>";
   echo "</tr>";
   echo "<form name='formti' action='m_gbtitum.php' method='POST'>";
   for($cont=0;$cont<$filas_resultado;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><small><font color='#0000FF'>$reg[titular]</font></small></td>";
     echo " <td width='50%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><small><font color='#0000FF'>$reg[nombre]</font></small></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><small><font color='#0000FF'><input type='text' name='vdom$cont' value='$vdom' size='32' maxlength='200' onkeydown='codigotecla(document.formti.vpai$cont)'></font></small></td>";
     echo " <td width='5%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><small><font color='#0000FF'><select size='1' name='vpai$cont' value='$vpai' size='2' onkeydown='codigotecla(document.formti.B$cont)'>";
     $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
     $filas_res_pais=pg_numrows($res_pais);
     $regpais = pg_fetch_array($res_pais);
     for($i=0;$i<$filas_res_pais;$i++) 
        {echo "<option value=$regpais[pais]>$regpais[pais]</option>";
         $regpais = pg_fetch_array($res_pais);
        }
     echo "</select></font></small></td>";
     echo " <td width='5%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><small><font color='#0000FF'><select size='1' name='vind$cont' value='$vind' size='2' onkeydown='codigotecla(document.formti.B$cont)'>";
     echo "  <option value='P'>Empresa Privada</option>";
     echo "  <option value='N'>Persona Natural</option>";
     echo "  <option value='G'>Sector Publico</option>";
     echo "  <option value='C'>Cooperativas</option>";
     echo "  <option value='O'>Comunales</option>";
     echo " </select></font></small></td>";
     echo "</tr>";
     $titacum[$cont]=$reg[titular];
     $nomacum[$cont]=$reg[nombre];
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
      echo "<input type='hidden' name='vder' value='$vder'>";
      echo "<p align='center'><font color='#0000FF'>";

      //echo "<input type='submit' value='Incluir' name='incluir'>
      //      <input type='button' value='Salir' name='salir' onclick='cerrarwindows2()'></font></p>"; 

      echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/database_save.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                              <input type='image' name='salir' value='Salir' onclick='cerrarwindows2()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
   echo "</form>";
   echo "<form method='POST' action='adm_titum.php?vsol=$vsol&vmod=$vmod&vtex=$vtex&vder=$vder'>"; 
?>
   <p align='center'><b><font size='3' face='Tahoma'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> ocurrencias encontradas </font></b></p>
<div align="center">
   <?php
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
   <input type="submit" class="boton_blue" name="atras" value="Previos <?= min($inicio, $cuanto) ?>" />
   <?
   }
   else
   {
   //espacio  &nbsp;
   }
   if($total - $inicio > $cuanto)
   {

   ?>
   <input type='submit' class='boton_blue' name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
</div>
   <?
   }
   else
   {
   //espacio    &nbsp;
   }
   echo "</form>";
  }
 
 if ($vmod=='Buscar/Eliminar' || $vmod=='Eliminar')
  {$resultado=pg_exec("SELECT * FROM stztmptit WHERE solicitud='$vsol' AND tipo_mp='$vder'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="m_gbtitum.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vder' value='$vder'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><font class='nota3'><b>Selecciones los Titulares que desea eliminar:</b></font></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font>Sel</td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>CODIGO</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NOMBRE</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'> <input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[titular]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[nombre]</font></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[titular]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre]'>";
     echo "<input type='hidden' name='nac$cont' value='$reg[nacionalidad]'>";
     echo "<input type='hidden' name='dom$cont' value='$reg[domicilio]'>";
     echo "<input type='hidden' name='pai$cont' value='$reg[pais_resid]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUN TITULAR ASOCIADO</p>";
      echo "<p align='center'>
            <input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></p>";
   }
   else
   {  echo "<p align='center'>";
      echo "<input type='submit' class='boton_blue' value='Eliminar' name='eliminar' >
            <input type='button' class='boton_blue' value='Salir' name='aceptar' onclick='cerrarwindows2()'></p>";
   }
   echo "</form>";
  }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
