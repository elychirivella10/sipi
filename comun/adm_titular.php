<script language="javascript">
  function cerrarwindows2() {
    window.opener.frames[0].location.reload();
    window.opener.frames[1].location.reload();
    window.close(); } 
    
  function isTelvalido(who,formulario,campo) {
    var telefpat=/^\d{4}-\d{7}$/;
    if (!telefpat.test(who)) { alert('Numero de Telefono no Valido ...!!!');   
       campo.value=''; campo.focus(); return false }
  return
  }

  function isEmail2(who,formulario,campo) {
    var emailpat=/^[A-Za-z0-9][\w-.]+@[A-Za-z0-9]([\w-.]+[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i;
    if (!emailpat.test(who)) { alert('¡ Cuenta Email o Correo no Valido ...!!!');   
       campo.value=''; campo.focus(); return false }
  return
  }

  function isdirvalida(who,formulario,campo) {
    if (campo.value.length<5) { alert('¡ Direccion no Valida ...!!! Coloque al menos 5 caracteres');   
       campo.value=''; campo.focus(); return false }
  return
  }
</script>

<script type="text/javascript">
  String.prototype.reverse=function(){return this.split('').reverse().join('');};
  function number_tel(e){
  function f(){
  this.value=this.value.reverse().replace(/[^0-9-]/g,'').replace(/\-(?=\d*[-]\d*)/g,'').reverse();
  }
  e.onkeyup=f
  e.onkeydown=f
  e.onkeypress=f
  e.onmousedown=f
  e.onmouseup=f
  e.onblur=f
  }
  function number_cor(e){
  function f(){
  this.value=this.value.reverse().replace(/[^0-9\.\-\@\_\A-Z\a-z]/g,'').replace(/\@(?=[A-Za-z0-9_.-]*[@][A-Za-z0-9_.-]*)/g,'').reverse();
  }
  e.onkeyup=f
  e.onkeydown=f
  e.onkeypress=f
  e.onmousedown=f
  e.onmouseup=f
  e.onblur=f
  }
</script>

<?php
  //include ("../setting.inc.php");
  //require ("../include.php");
  //include ("/apl/librerias/library.php");
  include ("../z_includes.php");
  // *************************************************************************************
  // Programa: adm_titular.php 
  // Realizado por el Analista de Sistema Romulo Mendoza 
  // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
  // Año: 2009 BD - Relacional 
  // *************************************************************************************
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>SIPI - Servicio Autónomo de la Propiedad Intelectual</title>
</head><body onload="centrarwindows()" bgcolor="#FFFFFF">   
<?php
//#D8E6FF
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable  onload="centrarwindows()" bgcolor="#F9F9F9" 
$usuario = trim($_SESSION['usuario_login']);

$sql = new mod_db();
$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];
$vder=$_GET['vtip'];
$fecha = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Titular(es) o Solicitante(s)');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (empty($vder)) { $vder=$_POST['vder']; }

echo "<p align='center'><font class='nota5'><I><b>Solicitud: $vsol</b></I></font></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><font class='nota3'><b>Introduzca primero el Titular que desea Incluir</b></font>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
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
       echo "<p align='center'><font class='nota3'><b>INGRESO DE TITULAR NUEVO</p></b></font>"; 
       ?>
       <form action="../comun/m_gbtitular.php" name="formtitular" method="POST" >
       <?php
       echo "<p><small><I><b><blink><U>RECUERDE EL CARACTER OBLIGATORIO DE:</U></blink> Cargar el <blink>RIF</blink> en caso de Empresas Nacionales y/o <blink>CEDULA DE IDENTIDAD</blink> del titular o solicitante, el cual se encuentra en el expediente por ser requisito para su presentaci&oacute;n; ademas de seleccionar la <blink>INDOLE</blink> del mismo. </b></I></small><p>";
       echo "<input type='hidden' name='vsol' value='$vsol'>";
       echo "<input type='hidden' name='vmod' value='$vmod'>";
       echo "<input type='hidden' name='vder' value='$vder'>";
       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='1' cellpadding='0' cellspacing='1' width='99%'>";
       echo "<tr>";
       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>&nbsp;</td>"; 
       echo "</tr>"; 
       echo "<tr><td></td></tr>";       
       echo "<tr>";
       echo " <td width='23%' class='izq-color'><small><b>C&eacute;dula/Rif:</b></small></td>";
       echo " <td width='77%' class='der-color'>";
       echo "  &nbsp;<select size='1' name='vcodl'>";
       echo "  <option value='V'>V</option>";
       echo "  <option value='E'>E</option>";
       echo "  <option value='P'>P</option>";
       echo "  <option value='J'>J</option>";
       echo "  <option value='G'>G</option>";
       echo "  </select>";
       echo "  <input type='text' name='vcod' value='$vcod' size='9' maxlength='9' onKeyup='checkLength(event,this,9,document.formtitular.vnom)' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.formtitular.vcod,9)'></b>";
	    echo "  <font size='1'>&nbsp;&nbsp;V= Venezolano  E= Extranjero  P= Pasaporte  J= Juridico  G= Gobierno</font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "<td width='23%' class='izq-color'><small><b>* Nombre:</b></small></td>";
       echo "<td width='77%' class='der-color'>";
       echo "  &nbsp;<input type='text' name='vnom' value='$vtex' size='78' maxlength='200' onkeydown='codigotecla(document.formtitular.vdom)'></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo " <td width='23%' class='izq-color'><small><b>* Domicilio:</b></small></td>";
       echo " <td width='77%' class='der-color'>";
       echo "  &nbsp;<input type='text' name='vdom' size='78' maxlength='200'></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       $filas_res_pais=pg_numrows($res_pais);
       $reg = pg_fetch_array($res_pais);
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>* Pa&iacute;s de Domicilio:</b></small></td>"; 
       echo "   <td width='77%' class='der-color'>";
       echo "    &nbsp;<select size='1' name='vpdo' onkeydown='codigotecla(document.formtitular.vdom)'>";
        for($cont=0;$cont<$filas_res_pais;$cont++) 
        { 
          echo "<option value=$reg[pais]>$reg[pais] $reg[nombre]</option>";
          $reg = pg_fetch_array($res_pais);
        }
       echo "      </select></font></td>";
       echo "</tr>";
//Insertado
       $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       $filas_res_pais=pg_numrows($res_pais);
       $reg = pg_fetch_array($res_pais);
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>* Nacionalidad:</b></small></td>"; 
       echo "   <td width='77%' class='der-color'>";
       echo "    &nbsp;<select size='1' name='vnac' onkeydown='codigotecla(document.formtitular.vdom)'>";
        for($cont=0;$cont<$filas_res_pais;$cont++) 
        { 
          echo "<option value=$reg[pais]>$reg[pais] $reg[nombre]</option>";
          $reg = pg_fetch_array($res_pais);
        }
       echo "      </select></font></td>";
       echo "</tr>";
// Fin insertado
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo " <td width='23%' class='izq-color'><small><b>* Indole:</b></small></td>";
       echo "  <td width='77%' class='der-color'>";
       echo "   &nbsp;<select size='1' name='vind'>";
       echo "    <option value='P' selected>Empresa Privada</option>";
       echo "    <option value='N'>Persona Natural</option>";
       echo "    <option value='G'>Sector Publico</option>";
       echo "    <option value='C'>Cooperativas</option>";
       echo "    <option value='O'>Comunales</option>";
       echo "   </select></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>Tel&eacute;fono 1:</b></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "     &nbsp;<input type='text' name='tlf1' size='15' maxlength='15' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.tlf1.value,this.form,this);'>&nbsp;&nbsp;<small>Formato: 9999-9999999</small></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";       
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>Tel&eacute;fono 2:</b></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "     &nbsp;<input type='text' name='tlf2' size='15' maxlength='15' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.tlf2.value,this.form,this);'>&nbsp;&nbsp;<small>Formato: 9999-9999999</small></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";       
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>Fax:</b></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "     &nbsp;<input type='text' name='vfax' size='15' maxlength='15' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.vfax.value,this.form,this);'>&nbsp;&nbsp;<small>Formato: 9999-9999999</small></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";       
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><small><b>E-Mail:</b></small></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "     &nbsp;<input type='text' name='vemail' size='68' maxlength='80'></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";

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
?>    
   <p align='center'><I><b><font class='nota4'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> ocurrencias encontradas </font></b></I></p>
<?php
   echo "<p align='center'><font class='nota3'><b>Seleccione el Titular que desea Incluir:</b></font></p>";
   echo "<p><small><I><b><blink><U>RECUERDE EL CARACTER OBLIGATORIO DE:</U></blink> Cargar el <blink>RIF</blink> en caso de Empresas Nacionales y/o <blink>CEDULA DE IDENTIDAD</blink> del titular o solicitante, el cual se encuentra en el expediente por ser requisito para su presentaci&oacute;n; ademas de seleccionar la <blink>INDOLE</blink> del mismo. </b></I></small><p>";
   echo "<table border='1' cellpadding='0' cellspacing='1' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' class='celda4'><small>Sel</small></td>";   
   echo " <td width='10%' class='celda4'<small>Codigo</small></td>";
   echo " <td width='50%' class='celda4'><small>Nombre</small></td>";
   echo " <td width='40%' class='celda4'><small>Domicilio</small></td>";
   echo " <td width='5%' class='celda4'><small>Pa&iacute;s de domicilio</small></td>";
   echo " <td width='5%' class='celda4'><small>Nacionalidad</small></td>";
   echo " <td width='5%' class='celda4'><small>Indole</small></td>";
   echo "</tr>";
   echo "<form name='formti' action='../comun/m_gbtitular.php' method='POST'>";
   for($cont=0;$cont<$filas_resultado;$cont++) {
     echo "<tr>";
     echo " <td width='1%' class='celda3'><input type='checkbox' name='B$cont'></td>";
     echo " <td width='10%' class='celda3'><small>$reg[titular]</small></td>";
     echo " <td width='50%' class='celda3'><small>$reg[nombre]</font></small></td>";
     echo " <td width='40%' class='celda3'><small><input type='text' name='vdom$cont' value='$vdom' size='32' maxlength='200' onkeydown='codigotecla(document.formti.vpai$cont)'></small></td>";
     echo " <td width='5%' class='celda3'><small><select size='1' name='vpdo$cont' value='$vpdo' size='2' onkeydown='codigotecla(document.formti.B$cont)'>";
     $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
     $filas_res_pais=pg_numrows($res_pais);
     $regpais = pg_fetch_array($res_pais);
     for($i=0;$i<$filas_res_pais;$i++) 
        {
         echo "<option value=$regpais[pais]>$regpais[pais] $regpais[nombre]</option>";
         $regpais = pg_fetch_array($res_pais);
        }
     echo "</select></small></td>";
// Insertado 2
     echo " <td width='5%' class='celda3'><small><select size='1' name='vpai$cont' value='$vpai' size='2' onkeydown='codigotecla(document.formti.B$cont)'>";
     $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
     $filas_res_pais=pg_numrows($res_pais);
     $regpais = pg_fetch_array($res_pais);
     for($i=0;$i<$filas_res_pais;$i++) 
        {
         echo "<option value=$regpais[pais]>$regpais[pais] $regpais[nombre]</option>";
         $regpais = pg_fetch_array($res_pais);
        }
     echo "</select></small></td>";
// Fin insertado 2
     echo " <td width='5%' class='celda3'><small><select size='1' name='vind$cont' value='$vind' size='2' onkeydown='codigotecla(document.formti.B$cont)'>";
     echo "  <option value='P' selected>Empresa Privada</option>";
     echo "  <option value='N'>Persona Natural</option>";
     echo "  <option value='G'>Sector Publico</option>";
     echo "  <option value='C'>Cooperativas</option>";
     echo "  <option value='O'>Comunales</option>";
     echo " </select></small></td>";
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

      echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/boton_guardar_rojo' alt='Save' align='middle' border='0' />
                              <input type='image' name='salir' value='Salir' onclick='cerrarwindows2()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
   echo "</form>";
   echo "<form method='POST' action='adm_titular.php?vsol=$vsol&vmod=$vmod&vtex=$vtex&vder=$vder'>"; 
?>
   <!-- <p align='center'><I><b><font class='nota4'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> ocurrencias encontradas </font></b></I></p> -->
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
   <input type='submit' class="boton_blue" name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
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
   <form action="../comun/m_gbtitular.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vder' value='$vder'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><b>Selecciones los Titulares que desea Eliminar:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='1' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' class='celda4'>Sel</td>";   
   echo " <td width='10%' class='celda4'>CODIGO</td>";
   echo " <td width='40%' class='celda4'>NOMBRE</td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' class='celda3'><input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' class='celda3'>$reg[titular]</font></td>";
     echo " <td width='40%' class='celda3'>$reg[nombre]</font></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[titular]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre]'>";
     echo "<input type='hidden' name='nac$cont' value='$reg[nacionalidad]'>";
     echo "<input type='hidden' name='dom$cont' value='$reg[domicilio]'>";
     echo "<input type='hidden' name='pai$cont' value='$reg[pais_domicilio]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'><font class='nota3'>NINGUN TITULAR ASOCIADO</font></p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
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

 if ($vmod=='Modificar') {
   $vtex1c = substr($vtex,0,1);
   $vtit = substr($vtex,1);

   if (empty($vtex) OR ($vtex1c!='-') OR (!is_numeric($vtit))) {
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "<div align='center'>";
     echo "<table width='50%' border='0' cellpadding='0' cellspacing='1' >";
     echo "<tr><td>";
     echo "<fieldset>";
     echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
     echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
     echo "<tr><td>";
     echo "<p align='center'><b>Introduzca primero el C&oacute;digo del Titular que desea Modificar ... !!!</b>";
     echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
     echo "</td></tr>";
     echo "</table>";
     echo "</fieldset>";
     echo "</td></tr>";
     echo "</table>";
     exit;
   }   
   
   if ($vtex1c=='-') {
     $resultado=pg_exec("SELECT * FROM stztmptit WHERE solicitud='$vsol' AND tipo_mp='$vder' AND titular='$vtit'");
   }
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   if ($filas_found==0) {
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "<div align='center'>";
     echo "<table width='50%' border='0' cellpadding='0' cellspacing='1' >";
     echo "<tr><td>";
     echo "<fieldset>";
     echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
     echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
     echo "<tr><td>";
     echo "<p align='center'><b>C&oacute;digo del Titular NO pertenece a la Solicitud ... !!!</b>";
     echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
     echo "</td></tr>";
     echo "</table>";
     echo "</fieldset>";
     echo "</td></tr>";
     echo "</table>";
     exit;
   }   
   
   ?>
   <?php 
   if ($filas_found>0) {
      //$vtit=trim($reg[titular]);
      $vide=trim($reg[identificacion]);
      $vnom=trim($reg[nombre]);
      $vnac=trim($reg[nacionalidad]);
      $vdom=trim($reg[domicilio]); 
      $vpdo=$reg[pais_domicilio];
      $vtel=trim($reg[telefono1]);
      $vcel=trim($reg[telefono2]);
      $vfax=trim($reg[fax]);
      $vcor=trim($reg[email]);
      $vcor2=trim($reg[email2]);
      $vind = trim($reg[indole]);
      if (!empty($vide)) { $vcodl = substr($vide,0,1); $vcod = substr($vide,1,9); }
   }
   echo "<form name='formtitular' action='m_gbtitular' method='post'>";
   echo "<input type='hidden' name='vtit' value='$vtit'>";
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vder' value='$vder'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong>DATOS DEL SOLICITANTE</strong></legend>";  
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo " <tr><td>&nbsp;</td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>C&oacute;digo del Titular:</td>";
   echo " <td><input type='text' size='9' name='vtit' value='$vtit' readonly></td></tr>";
   echo "<tr>";
   echo " <td class='der8-color'>Indole:</td>";
   echo "  <td width='77%' class='der-color'>";
   echo "   <select size='1' name='vind'>";
   if ($vind=='P') { echo "    <option value='P' selected>Empresa Privada</option>"; }
   else { echo "    <option value='P'>Empresa Privada</option>"; }
   //if ($vind=='E') { echo "    <option value='P' selected>Empresa Privada Extranjera</option>"; }
   //else { echo "    <option value='P'>Empresa Privada Extranjera</option>"; }
   if ($vind=='N') { echo "    <option value='N' selected>Persona Natural</option>"; }
   else { echo "    <option value='N'>Persona Natural</option>"; }
   if ($vind=='G') { echo "    <option value='G' selected>Sector Publico</option>"; }
   else { echo "    <option value='G'>Sector Publico</option>"; }
   if ($vind=='C') { echo "    <option value='C' selected>Cooperativas</option>"; }
   else { echo "    <option value='C'>Cooperativas</option>"; }
   if ($vind=='O') { echo "    <option value='O' selected>Comunales</option>"; }
   else { echo "    <option value='O'>Comunales</option>"; }
   echo "   </select><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   echo "</tr>";

   echo "<tr>";
   echo " <td class='der8-color'>C&eacute;dula/Rif:</td>";
   echo " <td width='77%' class='der-color'>";
   echo "  <select size='1' name='vcodl' value=$vcodl>";
   if ($vcodl=='V') { echo "  <option value='V' selected>V</option>"; }
   else { echo "  <option value='V'>V</option>"; }
   if ($vcodl=='E') { echo "  <option value='E' selected>E</option>"; }
   else { echo "  <option value='E'>E</option>"; }
   if ($vcodl=='P') { echo "  <option value='P' selected>P</option>"; }
   else { echo "  <option value='P'>P</option>"; }
   if ($vcodl=='J') { echo "  <option value='J' selected>J</option>"; }
   else {echo "  <option value='J'>J</option>"; }
   if ($vcodl=='G') { echo "  <option value='G' selected>G</option>"; }
   else { echo "  <option value='G'>G</option>"; }
   echo "  </select>";
   echo "  <input type='text' name='vcod' value='$vcod' size='9' maxlength='9' onKeyup='checkLength(event,this,9,document.formtitular.vnom)' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.formtitular.vcod,9)'></b>";
   echo "  <font size='1'>&nbsp;&nbsp;V= Venezolano  E= Extranjero  P= Pasaporte  J= Juridico  G= Gobierno&nbsp;&nbsp;&nbsp;&nbsp;<I><b>( Si esta en el expediente se debe cargar ...! )</b></I></font></td>";
   echo "</tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Nombre Completo:</td>";
   echo " <td><input type='text' size='90' maxlength='200' name='vnom' value='$vnom' onkeyup='this.value=this.value.toUpperCase();' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";

   $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY nombre");
   $filas_res_pais=pg_numrows($res_pais);
   $reg = pg_fetch_array($res_pais);
   echo " <tr>";
   echo " <td class='der8-color'>Nacionalidad:</td>";
   echo " <td>";
   if ($tper==2 or $tper==3) {
     echo "<input type='hidden' name='vnac' value='VE'>";
     echo " <input type='text' size='30' name='vnacdes' value='VENEZUELA' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   } else {
     echo " <select size='1' name='vnac'>";
          if ($vnac=='' and $tper<>4) {$vnac='VE';}
          for($cont=0;$cont<$filas_res_pais;$cont++) 
          {
          if ($tper==4 and $reg[pais]=='VE') {
            // No lo muestra 
          } else {   
            if ($reg[pais]==$vnac) {
             echo "<option value=$reg[pais] selected>$reg[nombre]</option>";   
            } else { 
             echo "<option value=$reg[pais]>$reg[nombre]</option>";   
            }
          } 
          $reg = pg_fetch_array($res_pais);
          }
     echo " </select><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   }
   echo "</tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Direcci&oacute;n Completa:</td>";
   echo " <td><input type='text' size='90' name='vdom' maxlength='200' value='$vdom' onchange='isdirvalida(document.formtitular.vdom.value,this.form,this);'><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
//Insertado 3
   $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
   $filas_res_pais=pg_numrows($res_pais);
   $reg = pg_fetch_array($res_pais);
   echo " <tr>";
   echo " <td class='der8-color'>Pais de Domicilio:</td>";
   echo " <td>";
   echo " <select size='1' name='vpdo'>";
          for($cont=0;$cont<$filas_res_pais;$cont++) 
          {
            if ($reg[pais]==$vpdo) {
             echo "<option value=$reg[pais] selected>$reg[nombre]</option>";   
            } else { 
             echo "<option value=$reg[pais]>$reg[nombre]</option>";   
            }
          $reg = pg_fetch_array($res_pais);
          }
   echo " </select><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   echo "</tr>";
//Fin insertado 3
   echo " <tr>";
   echo " <td class='der8-color'>Correo Electr&oacute;nico 1:</td>";
   echo " <td><input type='text' size='50' name='vcor' maxlength='80' value='$vcor' onkeyup='number_cor(this);' onchange='isEmail2(document.formtitular.vcor.value,this.form,this);'></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Correo Electr&oacute;nico 2:</td>";
   echo " <td><input type='text' size='50' name='vcor2' maxlength='80' value='$vcor2' onkeyup='number_cor(this);' onchange='isEmail2(document.formtitular.vcor2.value,this.form,this);'></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Tel&eacute;fono:</td>";
   echo " <td><input type='text' size='11' maxlength='12' name='vtel' value='$vtel' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.vtel.value,this.form,this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Celular:</td>";
   echo " <td><input type='text' size='11' maxlength='12' name='vcel' value='$vcel' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.vcel.value,this.form,this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td class='der8-color'>Fax:</td>";
   echo " <td><input type='text' size='11' maxlength='12' name='vfax' value='$vfax' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.vfax.value,this.form,this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td colspan=2 align='left'><font face='Arial' color='#800000' size='3'>*</font><font face='Arial' color='#000000' size='2'>Campos Obligatorios (Si se excluye alguno, el solicitante no ser&aacute; incluido en la solicitud)</font></td></tr>";
   echo "</table>";
   //echo "<p align='center'><font color='#0000FF'><input type='submit' name='modificar' value='Modificar' class='boton_blue'>&nbsp;&nbsp;<input type='button' value='Salir' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
   echo "<p align='center'><input type='image' src='../imagenes/boton_guardar_rojo.png' value='Guardar'>&nbsp;&nbsp;<input type='image' value='Salir' name='aceptar' src='../imagenes/boton_salir_rojo.png' onclick='window.close();'></font></p>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   echo "</form>";
 }

 if ($vmod=='Corregir') {

   //if ($usuario!='rmendoza') {
   //  mensajenew("ERROR: Opcion EN Desarrollo ...!!!","javascript:history.back();","N");
   //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

   $vtex1c = substr($vtex,0,1);
   $vtit = substr($vtex,1);
   if (empty($vtex) OR ($vtex1c!='-') OR (!is_numeric($vtit))) {
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "<div align='center'>";
     echo "<table width='50%' border='0' cellpadding='0' cellspacing='1' >";
     echo "<tr><td>";
     echo "<fieldset>";
     echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
     echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
     echo "<tr><td>";
     echo "<p align='center'><b>Aviso: Introduzca primero el C&oacute;digo del Titular que desea Corregir ... !!!</b>";
     echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
     echo "</td></tr>";
     echo "</table>";
     echo "</fieldset>";
     echo "</td></tr>";
     echo "</table>";
     exit;
   }   
   
   if ($vtex1c=='-') {
     $resultado=pg_exec("SELECT * FROM stztmptit WHERE solicitud='$vsol' AND tipo_mp='$vder' AND titular='$vtit'");
   }
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   if ($filas_found==0) {
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "<div align='center'>";
     echo "<table width='50%' border='0' cellpadding='0' cellspacing='1' >";
     echo "<tr><td>";
     echo "<fieldset>";
     echo "<legend align='center'><strong><font color='800000'>ERROR:</font></strong></legend>";  
     echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
     echo "<tr><td>";
     echo "<p align='center'><b>C&oacute;digo del Titular NO pertenece a la Solicitud ... !!!</b>";
     echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
     echo "</td></tr>";
     echo "</table>";
     echo "</fieldset>";
     echo "</td></tr>";
     echo "</table>";
     exit;
   }   
   
   ?>
   <?php 
   if ($filas_found>0) {
      //$vtit=trim($reg[titular]);
      $vide=trim($reg[identificacion]);
      $vnom=trim($reg[nombre]);
      $vnac=trim($reg[nacionalidad]);
      $vdom=trim($reg[domicilio]); 
      $vpdo=trim($reg[pais_domicilio]); 
      $vtel=trim($reg[telefono1]);
      $vcel=trim($reg[telefono2]);
      $vfax=trim($reg[fax]);
      $vcor=trim($reg[email]);
      $vcor2=trim($reg[email2]);
      $vind = trim($reg[indole]);
      if (!empty($vide)) { $vcodl = substr($vide,0,1); $vcod = substr($vide,1,9); }
   }
   echo "<form name='formtitular' action='m_gbtitular' method='post'>";
   echo "<input type='hidden' name='vtit' value='$vtit'>";
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vder' value='$vder'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong>CORRECCION DE DOMICILIO Y PAIS DEL TITULAR / SOLICITANTE</strong></legend>";  
   echo "<table width='100%' border='1' cellpadding='0' cellspacing='1'>";
   //echo " <tr><td>&nbsp;</td></tr>";
   echo " <tr>&nbsp;</tr>";
   echo " <tr>";
   echo " <td class='izq-color'>C&oacute;digo del Titular:</td>";
   echo " <td class='der-color'><input type='text' size='9' name='vtit' value='$vtit' readonly></td></tr>";

   echo " <tr>";
   echo " <td class='izq-color'>Nombre Completo:</td>";
   echo " <td class='der-color'><input type='text' size='90' maxlength='200' name='vnom' value='$vnom' onkeyup='this.value=this.value.toUpperCase();' readonly=readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";


   echo "<tr>";
   echo " <td class='izq-color'>Indole:</td>";
   echo "  <td width='77%' class='der-color'>";
   echo "   <select size='1' name='vind'>";
   if ($vind=='P') { echo "    <option value='P' selected>Empresa Privada</option>"; }
   else { echo "    <option value='P'>Empresa Privada</option>"; }
   //if ($vind=='E') { echo "    <option value='P' selected>Empresa Privada Extranjera</option>"; }
   //else { echo "    <option value='P'>Empresa Privada Extranjera</option>"; }
   if ($vind=='N') { echo "    <option value='N' selected>Persona Natural</option>"; }
   else { echo "    <option value='N'>Persona Natural</option>"; }
   if ($vind=='G') { echo "    <option value='G' selected>Sector Publico</option>"; }
   else { echo "    <option value='G'>Sector Publico</option>"; }
   if ($vind=='C') { echo "    <option value='C' selected>Cooperativas</option>"; }
   else { echo "    <option value='C'>Cooperativas</option>"; }
   if ($vind=='O') { echo "    <option value='O' selected>Comunales</option>"; }
   else { echo "    <option value='O'>Comunales</option>"; }
   echo "   </select><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   echo "</tr>";

   echo "<tr>";
   echo " <td class='izq-color'>C&eacute;dula/Rif:</td>";
   echo " <td width='77%' class='der-color'>";
   echo "  <select size='1' name='vcodl' value=$vcodl>";
   if ($vcodl=='V') { echo "  <option value='V' selected>V</option>"; }
   else { echo "  <option value='V'>V</option>"; }
   if ($vcodl=='E') { echo "  <option value='E' selected>E</option>"; }
   else { echo "  <option value='E'>E</option>"; }
   if ($vcodl=='P') { echo "  <option value='P' selected>P</option>"; }
   else { echo "  <option value='P'>P</option>"; }
   if ($vcodl=='J') { echo "  <option value='J' selected>J</option>"; }
   else {echo "  <option value='J'>J</option>"; }
   if ($vcodl=='G') { echo "  <option value='G' selected>G</option>"; }
   else { echo "  <option value='G'>G</option>"; }
   echo "  </select>";
   echo "  <input type='text' name='vcod' value='$vcod' size='9' maxlength='9' onKeyup='checkLength(event,this,9,document.formtitular.vnom)' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.formtitular.vcod,9)'></b>";
   echo "  <font size='1'>&nbsp;&nbsp;V= Venezolano  E= Extranjero  P= Pasaporte  J= Juridico  G= Gobierno&nbsp;&nbsp;&nbsp;&nbsp;<I><b>( Si esta en el expediente se debe cargar ...! )</b></I></font></td>";
   echo "</tr>";
   echo " <tr>";
   echo " <td class='izq-color'>Direcci&oacute;n/Domicilio Completo:</td>";
   echo " <td class='der-color'><input type='text' size='90' name='vdom' maxlength='200' value='$vdom' onchange='isdirvalida(document.formtitular.vdom.value,this.form,this);'><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
// Insertado 4
   $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY nombre");
   $filas_res_pais=pg_numrows($res_pais);
   $reg = pg_fetch_array($res_pais);
   echo " <tr>";
   echo " <td class='izq-color'>Pais de Domicilio:</td>";
   echo " <td>";
   echo " <select size='1' name='vpdo'>";
          for($cont=0;$cont<$filas_res_pais;$cont++) 
          {
            if ($reg[pais]==$vpdo) {
             echo "<option value=$reg[pais] selected>$reg[nombre]</option>";   
            } else { 
             echo "<option value=$reg[pais]>$reg[nombre]</option>";   
            }
          $reg = pg_fetch_array($res_pais);
          }
   echo " </select><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   echo "</tr>";
//Fin insertado 4
   $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY nombre");
   $filas_res_pais=pg_numrows($res_pais);
   $reg = pg_fetch_array($res_pais);
   echo " <tr>";
   echo " <td class='izq-color'>Nacionalidad:</td>";
   echo " <td class='der-color'>";
   if ($tper==2 or $tper==3) {
     echo "<input type='hidden' name='vnac' value='VE'>";
     echo " <input type='text' size='30' name='vnacdes' value='VENEZUELA' readonly><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   } else {
     echo " <select size='1' name='vnac'>";
          if ($vnac=='' and $tper<>4) {$vnac='VE';}
          for($cont=0;$cont<$filas_res_pais;$cont++) 
          {
          if ($tper==4 and $reg[pais]=='VE') {
            // No lo muestra 
          } else {   
            if ($reg[pais]==$vnac) {
             echo "<option value=$reg[pais] selected>$reg[nombre]</option>";   
            } else { 
             echo "<option value=$reg[pais]>$reg[nombre]</option>";   
            }
          } 
          $reg = pg_fetch_array($res_pais);
          }
     echo " </select><font face='Arial' color='#800000' size='3' valign='up'>*</font></td>";
   }
   echo "</tr>";
   echo " <tr>";
   echo " <td class='izq-color'>Correo Electr&oacute;nico 1:</td>";
   echo " <td class='der-color'><input type='text' size='50' name='vcor' maxlength='80' value='$vcor' onkeyup='number_cor(this);' onchange='isEmail2(document.formtitular.vcor.value,this.form,this);'></td></tr>";
   echo " <tr>";
   echo " <td class='izq-color'>Correo Electr&oacute;nico 2:</td>";
   echo " <td class='der-color'><input type='text' size='50' name='vcor2' maxlength='80' value='$vcor2' onkeyup='number_cor(this);' onchange='isEmail2(document.formtitular.vcor2.value,this.form,this);'></td></tr>";
   echo " <tr>";
   echo " <td class='izq-color'>Tel&eacute;fono:</td>";
   echo " <td class='der-color'><input type='text' size='11' maxlength='12' name='vtel' value='$vtel' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.vtel.value,this.form,this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td class='izq-color'>Celular:</td>";
   echo " <td class='der-color'><input type='text' size='11' maxlength='12' name='vcel' value='$vcel' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.vcel.value,this.form,this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td class='izq-color'>Fax:</td>";
   echo " <td class='der-color'><input type='text' size='11' maxlength='12' name='vfax' value='$vfax' onkeyup='number_tel(this);' onchange='isTelvalido(document.formtitular.vfax.value,this.form,this);'><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (c&oacute;digo area-n&uacute;mero)</font></td></tr>";
   echo " <tr>";
   echo " <td colspan=2 align='left'><font face='Arial' color='#800000' size='3'>*</font><font face='Arial' color='#000000' size='2'>Campos Obligatorios (Si se excluye alguno, el solicitante no ser&aacute; incluido en la solicitud)</font></td></tr>";
   echo "</table>";
   //echo "<p align='center'><font color='#0000FF'><input type='submit' name='modificar' value='Modificar' class='boton_blue'>&nbsp;&nbsp;<input type='button' value='Salir' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
   echo "<p align='center'><input type='image' src='../imagenes/boton_guardar_rojo.png' value='Guardar'>&nbsp;&nbsp;<input type='image' value='Salir' name='aceptar' src='../imagenes/boton_salir_rojo.png' onclick='window.close();'></font></p>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   echo "</form>";
 }

$smarty->display('pie_pag.tpl');

?>
</body>
</html>
