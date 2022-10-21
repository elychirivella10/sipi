<script language="javascript">
 function cerrarwindows2() {
   window.opener.frames[0].location.reload();
   window.opener.frames[1].location.reload();
   window.opener.frames[2].location.reload();
   window.close();
 }
</script>

<?php
  include ("../setting.inc.php");
  require ("../include.php");
  include ("/apl/librerias/library.php");
  // ************************************************************************************* 
  // Programa: adm_agente.php 
  // Realizado por el Analista de Sistema Romulo Mendoza 
  // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
  // Año: 2009 BD - Relacional 
  // *************************************************************************************
?>
<html><head>
<title>Servicio Autonomo de la Propiedad Intelectual</title>
</head><body onload="centrarwindows()" bgcolor="F9F7ED">   
<?php
//#D8E6FF
//Variable
$sql = new mod_db();
$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];

echo "<p align='center'><b>Solicitud: $vsol</b></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><b>Introduzca primero el Agente que desea Incluir</b>";
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

 if ($vmod=='Buscar/Incluir' || $vmod=='Buscar')  {
   $resultado=pg_exec("SELECT * FROM stzagenr WHERE nombre like '$vtex%' ORDER BY nombre OFFSET $inicio LIMIT $cuanto");
   $cantidad =pg_exec("SELECT * FROM stzagenr WHERE nombre like '$vtex%'");
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);

   if ($filas_resultado==0) {
       echo "<p align='center'><b>NO EXISTE EL AGENTE ASOCIADO ...!!!</p></b>"; 
       ?>
       <form action="m_gbtitular.php" name="formtitular" method="POST" >
       <?php
       //echo "<input type='hidden' name='vsol' value='$vsol'>";
       //echo "<input type='hidden' name='vmod' value='$vmod'>";
       //echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='0' cellpadding='0' cellspacing='0' width='99%'>";
       echo "<tr>";
       //echo "<tr><td class='izq-color'></td>";
	    //echo "<td class='der-color'>&nbsp;"; 
       //echo "</td></tr>"; 
       //echo "<tr><td></td></tr>";       
       //echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       //echo "<p align='right' style='margin-top: 2; margin-bottom: 2'>";
       //echo "<small><font color='#FFFFFF' face='MS Sans Serif'><b>C&eacute;dula/Rif:</b></font></small></td>";
       //echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       //echo "&nbsp;<select size='1' name='vcodl'>";
       //echo "  <option value='V'>V</option>";
       //echo "  <option value='E'>E</option>";
       //echo "  <option value='P'>P</option>";
       //echo "  <option value='J'>J</option>";
       //echo "  <option value='G'>G</option>";
       //echo " </select>";
       //echo "<input type='text' name='vcod' value='$vcod' size='9' maxlength='9' onKeyup='checkLength(event,this,9,document.formtitular.vnom)' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.formtitular.vcod,9)'></b></font>";
	    //echo "<font size='1'>V= Venezolano  E= Extranjero  P= Pasaporte  J= Juridico  G= Gobierno</font></td>";
       //echo "</tr>";
       //echo "<tr><td></td></tr>";
       //echo "<tr>";
       //echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       //echo "<p align='right' style='margin-top: 2; margin-bottom: 2'>";
       //echo "<small><font color='#FFFFFF' face='MS Sans Serif'><b>* Nombre:</b></font></small></td>";
       //echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       //echo "      &nbsp;<input type='text' name='vnom' value='$vtex' size='68' maxlength='200' onkeydown='codigotecla(document.formtitular.vdom)'></font></td>";
       //echo "</tr>";
       //echo "<tr><td></td></tr>";
       //echo "<tr>";
       //echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       //echo "<small><p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>* Domicilio:</b></font></small></td>";
       //echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       //echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vdom' size='68' maxlength='200'></font></td>";
       //echo "</tr>";
       //echo "<tr><td></td></tr>";
       //$res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       //$filas_res_pais=pg_numrows($res_pais);
       //$reg = pg_fetch_array($res_pais);
       //echo "<tr>";
       //echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       //echo "<small><p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>* Nacionalidad:</b></font></small></td>";
       //echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       //echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<select size='1' name='vnac' onkeydown='codigotecla(document.formtitular.vdom)'>";
       // for($cont=0;$cont<$filas_res_pais;$cont++) 
       // { 
       //   echo "<option value=$reg[pais]>$reg[pais] $reg[nombre]</option>";
       //   $reg = pg_fetch_array($res_pais);
       // }
       //echo "      </select></font></td>";
       //echo "</tr>";
       //echo "<tr><td></td></tr>";
       //echo "<tr>";
       //echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       //echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Tel&eacute;fono:</b></font></td>";
       //echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       //echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vtlf' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vfax)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></font></td>";
       //echo "</tr>";
       //echo "<tr><td></td></tr>";       
       //echo "<tr>";
       //echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       //echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Fax:</b></font></td>";
       //echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       //echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vfax' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vfax)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></font></td>";
       //echo "</tr>";
       //echo "<tr><td></td></tr>";       
       //echo "<tr>";
       //echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       //echo "<small><p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>E-Mail:</b></font></small></td>";
       //echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       //echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vemail' size='68' maxlength='200'></font></td>";
       //echo "</tr>";
       //echo "<tr><td></td></tr>";

       //echo "<tr><td class='izq-color'></td>";
	    //echo "<td class='der-color'>";
	    //echo "<font size='1'> * Campos Obligatorios</font>";
       //echo "</td></tr>"; 
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "</table>";   
       echo "<p align='center'>
               &nbsp;<input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
       echo "</form>";
       exit;
   }
   else {
   ?>
   <p align='center'><b><font size='3' face='Tahoma' color='#0000FF'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> ocurrencias encontradas </font></b></p>
   <?php
   echo "<p align='center'><b>Seleccione el Agente que desea Incluir:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font><small>Sel</small></td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Codigo</small></font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Nombre</small></font></td>";
   echo " <td width='45%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'><small>Domicilio</small></font></td>";
   echo "</tr>";
   echo "<form name='formti' action='m_gbagente.php' method='POST'>";
   for($cont=0;$cont<$filas_resultado;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><small><font color='#0000FF'>$reg[agente]</font></small></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><small><font color='#0000FF'>$reg[nombre]</font></small></td>";
     echo " <td width='45%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><small><font color='#0000FF'>$reg[domicilio]</font></small></td>";
     echo "</tr>";
     $titacum[$cont]=$reg[agente];
     $nomacum[$cont]=$reg[nombre];
     $domacum[$cont]=$reg[domicilio];
     $reg = pg_fetch_array($resultado);
   }
   echo "</table>"; 
      for($cont=0;$cont<$filas_resultado;$cont++) {
          echo "<input type='hidden' name='vtit$cont' value='$titacum[$cont]'>";
          echo "<input type='hidden' name='vnom$cont' value='$nomacum[$cont]'>";
          echo "<input type='hidden' name='vdom$cont' value='$domacum[$cont]'>";
      } 
      echo "<input type='hidden' name='vsol' value='$vsol'>";
      echo "<input type='hidden' name='vfil' value='$filas_resultado'>";
      echo "<input type='hidden' name='vmod' value='$vmod'>";
      echo "<p align='center'><font color='#0000FF'>";

      echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/save_f2.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                              <input type='image' name='salir' value='Salir' onclick='cerrarwindows2()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
   echo "</form>";
   echo "<form method='POST' action='adm_agente.php?vsol=$vsol&vmod=$vmod&vtex=$vtex'>"; 
?>
   <!-- <p align='center'><b><font size='3' face='Tahoma'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> ocurrencias encontradas </font></b></p> --> 
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
   <input type="submit" name="atras" value="Previos <?= min($inicio, $cuanto) ?>" />
   <?
   }
   else
   {
   //espacio  &nbsp;
   }
   if($total - $inicio > $cuanto)
   {

   ?>
   <input type='submit' name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
</div>
   <?
   }
   else
   {
   //espacio    &nbsp;
   }
   echo "</form>";
  }
 }
 
 if ($vmod=='Buscar/Eliminar' || $vmod=='Eliminar')
  {$resultado=pg_exec("SELECT * FROM stztmpage WHERE solicitud='$vsol' AND tipo_mp='M'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="m_gbagente.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><b>Seleccione los Agentes que desea eliminar:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font>Sel</td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Codigo</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Nombre</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Domicilio</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'> <input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[agente]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[nombre]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[domicilio]</font></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[agente]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre]'>";
     echo "<input type='hidden' name='dom$cont' value='$reg[domicilio]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUN AGENTE ASOCIADO</p>";
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
