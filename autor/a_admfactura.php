<script language="javascript">
function cerrarwindows3() {
  window.opener.frames[0].location.reload();
  window.close();
}

function max(txarea,totalc) 
 { 
   total = totalc; 
   tam = txarea.value.length; 
   str=""; 
   str=str+tam; 
   Digitado.innerHTML = str; 
   Restante.innerHTML = total - str; 
   if (tam > total){ 
      aux = txarea.value; 
      txarea.value = aux.substring(0,total); 
      Digitado.innerHTML = total 
      Restante.innerHTML = 0 
   } 
 } 

</script>

<?php
// ************************************************************************************* 
// Programa: adm_obras.php 
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
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 
<body onload="centrarwindows()" bgcolor="#FFFFFF"> 

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion WEBSIPI  
$sql->connection1();
//LLenado de Arreglo con los Bancos Autorizados    
$contobji=0;
$vcodsede[$contobji] = '';
$vnomsede[$contobji] = '';
$objquery = $sql->query1("SELECT * FROM stzbancos WHERE tipo=1 ORDER BY nombre");
$objfilas = $sql->nums1('',$objquery);
$objs = $sql->objects1('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
  $vcodban[$contobji] = $objs->rif;
  $vnomban[$contobji] = trim($objs->nombre);
  $objs = $sql->objects1('',$objquery); }	  
//Desconexion de la Base de Datos
$sql->disconnect1();

//Verificacion de Conexion con SIPI
$sql->connection();   

$vcod=$_GET['vcod'];
$vser=$_GET['vser'];

//La Fecha de Hoy para la transaccion
$fechahoy = hoy();
$subtitulo = "Registro de Pago Realizado y Entrega de Documento(s) relacionado con el Servicio No.: ".$vcod; 
$hiddenvars['vcod']=$vcod;

$vmod="Incluir";

if ($vmod=='Incluir') {
   echo "<table border='0' cellpadding='0' cellspacing='0' >";
   echo " <td>";
   echo "   <i><b><font>$subtitulo</font></b></i>";
   echo " </td>";
   echo "</table>";
   echo " <br>";

   $resultado=pg_exec("SELECT * FROM stdseraut WHERE control='$vcod'");
   $reg=pg_fetch_array($resultado);
   $filas_registro=pg_numrows($resultado);
   $serv = $reg[tipo_servicio]; 
   $fecha= $reg[fecha_trans];
   $hora = $reg[hora_trans];
   $vsol = $reg[solicitud];
   $vreg = $reg[registro];
   $titu = trim($reg[titulo_obra]);
   $tipo = $reg[tipo_obra];
   if ($reg['tipo_obra']=='OM'){$tipo_obra='OBRA MUSICAL';}
   if ($reg['tipo_obra']=='OL'){$tipo_obra='OBRA LITERARIA';}
   if ($reg['tipo_obra']=='OE'){$tipo_obra='OBRA ESCENICA';}
   if ($reg['tipo_obra']=='AV'){$tipo_obra='ARTE VISUAL';}
   if ($reg['tipo_obra']=='AR'){$tipo_obra='OBRA AUDIOVISUAL Y RADIOFONICA';}
   if ($reg['tipo_obra']=='PC'){$tipo_obra='PROGRAMAS DE COMPUTACION Y BASES DE DATOS';}
   if ($reg['tipo_obra']=='PF'){$tipo_obra='PRODUCCIONES FONOGRAFICAS';}
   if ($reg['tipo_obra']=='IE'){$tipo_obra='INTERPRETACIONES Y EJECUCIONES ARTISTICAS';}
   if ($reg['tipo_obra']=='AC'){$tipo_obra='ACTOS Y CONTRATOS';}
   $vporc='83%';
   //echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>AVISO: No Existe el Expediente en la Base de Datos ...!!!</b></font></p>";
   ?>
   <form action="a_gbfactser.php" name="formautor" method="POST" >
   <?php
     echo "<input type='hidden' name='vcod' value='{$vcod}'>";
   ?>
   <table border="0" cellpadding="2" cellspacing="2" width="100%">
     <tr>
       <td width="17%" align="right" class="der8-color">Tipo de Servicio Solicitado:</td>
       <td width=$vporc class="izq6a-color">
         <input type="text" name="solicitud" size="6" maxlength="6" value='<?php echo $serv; ?>' readonly> 
       </td>
     </tr>
     <tr>
       <td width="17%" align="right" class="der8-color">Fecha del Servicio:</td>
       <td width=$vporc class="izq6a-color">
         <input type="text" name="solicitud" size="21" maxlength="21" value='<?php echo $fecha." - ".$hora; ?>' readonly>  
       </td>
     </tr>
     <tr>
       <td width="17%" align="right" class="der8-color">Solicitud No.:</td>
       <td width=$vporc class="izq6a-color">
         <input type="text" name="solicitud" size="6" maxlength="6" value='<?php echo $vsol; ?>' readonly> 
       </td>
     </tr>
     <tr>
       <td width="17%" align="right" class="der8-color">Registro No.:</td>
       <td width=$vporc class="izq6a-color">
          <input type="text" name="registro" size="6" maxlength="6" value='<?php echo $vreg; ?>' readonly>
       </td>
     </tr>
     <tr>
       <td width="17%" align="right" class="der8-color">Titulo de la Obra:</td>
       <td width=$vporc class="izq6a-color">
          <textarea cols='72' rows='4' name='titulo' value='<?php echo $titu; ?>'readonly><?php echo $titu; ?></textarea>   
       </td>
     </tr>
     <tr>
       <td width="17%" align="right" class="der8-color">Tipo de Obra:</td>
       <td width=$vporc class="izq6a-color">
         <input type="text" name="solicitud" size="60" maxlength="60" value='<?php echo $tipo_obra; ?>' readonly> 
       </td>
     </tr>
     <tr>
       <td class="der8-color" >Entidad Financiera:</td>
       <td class="der7-color">
          <select size="1" name="banco" >
          <?php
            for($cont1=0;$cont1<=$objfilas;$cont1++) { 
              echo '<option value="'.$vcodban[$cont1].'">'.$vnomban[$cont1].'</option>'; }
          ?>     
          </select>
          <font class="obligatorio">*</font>
       </td>
     </tr>
     <tr>
       <td class="der8-color" >Deposito No.:</td>
       <td class="der7-color">
         <input type="text" name="deposito" size="10" maxlength="10">
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;Formato: 9999999999 (Diez &uacute;ltimos d&iacute;gitos)</font> 
         <font class="obligatorio">*</font>
       </td>
     </tr>
     <tr>
      <td class="der8-color" >Fecha de Deposito:</td>
      <td class="der7-color">
         <input type="text" name="fechadep" size="10" maxlength="10" align="right">
         <!-- &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar60');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> -->
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;Formato: dd/mm/aaaa</font> 
         <font class="obligatorio">*</font>
      </td>
     </tr>
     <tr>
       <td class="der8-color" >Factura No.:</td>
       <td class="der7-color">
         <input type="text" name="factura" size="6" maxlength="6">
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;Formato: 999999</font> 
         <font class="obligatorio">*</font>
       </td>
     </tr>

   </table>
   <br/>
   <font class="obligatorio">* Caracter Obligatorio</font>

   <?php
    echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/database_save.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                            <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
    exit();
}
   ?>

<?php
//Desconexion de la Base de Datos
$sql->disconnect();
?>

</body>
</html>
