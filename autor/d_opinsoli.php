<?php
include ("../z_includes.php");
?>

<html>
<head>
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 
<body onload="centrarwindows()" bgcolor="#D8E6FF">

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
//$login = $_SESSION['usuario_login'];
$sql = new mod_db();

$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];
$vtip=$_GET['vtip'];

echo "<small><p align='center'><b>SOLICITUD: $vsol, Persona $vmod: $vtex</b></small></p>";

if (empty($vsol)) { 
   echo "<hr>";
   echo "<p align='center'><b>INTRODUZCA PRIMERO EL NUMERO DE SOLICITUD</b>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close()'></font></p>";
   exit;
}

//Verificando conexion
$sql->connection($usuario);

if ($vtip=='Solicitante') {
   $resul=pg_exec("SELECT * from stdtmpso where solicitud='$vsol'"); 
   if (pg_numrows($resul) > 0) {
     echo "<hr>";
     echo "<p align='center'><b>SOLO SE PUEDE ASOCIAR UN (1) SOLICITANTE POR CADA SOLICITUD...!!!</b>";
     echo "<hr>";
     echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close()'></font></p>";
     exit;
   } 
}

if ($vtip=='Editor') {
   $resul=pg_exec("SELECT * from stdtmped where solicitud='$vsol'"); 
   if (pg_numrows($resul) > 0) {
     echo "<hr>";
     echo "<p align='center'><b>SOLO SE PUEDE ASOCIAR UN (1) EDITOR/IMPRESOR POR CADA SOLICITUD...!!!</b>";
     echo "<hr>";
     echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close()'></font></p>";
     exit;
   } 
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
  $cuanto = 10;

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

 if ($vmod=='Natural' || $vmod=='Juridica')
  {
   if ($vmod=='Natural') {
     $resultado=pg_exec("SELECT distinct on (titular) titular,nombre,
                                ' ' as domicilio,' ' as pais,identificacion as ced_rif,
                                null as fecha_nacim,' ' as estado_civil,' ' as indole,
                                ' ' as telefono1,' ' as telefono2,' ' as fax,
                                ' ' as profesion,' ' as seudonimo,' ' as email
                           FROM stzsolic WHERE nombre like '$vtex%' 
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpau 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpti 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmped 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpco 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol' 
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmppt 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpso 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol'
                         OFFSET $inicio LIMIT $cuanto");
     $cantidad =pg_exec("SELECT distinct on (titular) titular,nombre,
                                ' ' as domicilio,' ' as pais,identificacion as ced_rif,
                                null as fecha_nacim,' ' as estado_civil,' ' as indole,
                                ' ' as telefono1,' ' as telefono2,' ' as fax,
                                ' ' as profesion,' ' as seudonimo,' ' as email
                           FROM stzsolic WHERE nombre like '$vtex%'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpau 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpti 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmped 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpco 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmppt 
                          WHERE nombre like '$vtex%' and tipo_persona='N' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpso 
                          WHERE nombre like '$vtex%' and tipo_persona='N' 
                                and solicitud='$vsol'"); }
   if ($vmod=='Juridica') {
     $resultado=pg_exec("SELECT distinct on (titular) titular,nombre,
                                ' ' as domicilio,' ' as pais, identificacion as ced_rif,
                                null as fecha_nacim,' ' as estado_civil,' ' as indole,
                                ' ' as telefono1,' ' as telefono2,' ' as fax,
                                ' ' as profesion,' ' as seudonimo,' ' as email
                           FROM stzsolic WHERE nombre like '$vtex%' 
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpau 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpti 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmped 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpco 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol' 
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmppt 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpso 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol'
                         OFFSET $inicio LIMIT $cuanto");
     $cantidad =pg_exec("SELECT distinct on (titular) titular,nombre,
                                ' ' as domicilio,' ' as pais, identificacion as ced_rif,
                                null as fecha_nacim,' ' as estado_civil,' ' as indole,
                                ' ' as telefono1,' ' as telefono2,' ' as fax,
                                ' ' as profesion,' ' as seudonimo,' ' as email
                           FROM stzsolic WHERE nombre like '$vtex%'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpau 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpti 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmped 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpco 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmppt 
                          WHERE nombre like '$vtex%' and tipo_persona='J' and solicitud='$vsol'
                         union
                         SELECT codigo as titular,nombre,domicilio,pais,ced_rif,
                                fecha_nacim,estado_civil,indole,
                                telefono1,telefono2,fax,profesion,seudonimo,email
                           FROM stdtmpso 
                          WHERE nombre like '$vtex%' and tipo_persona='J' 
                                and solicitud='$vsol'"); }
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
        switch ($vtip) {
          case "Solicitante":
            echo "<small><p align='center'><b>INGRESE SOLICITANTE NUEVO</p></small></b>"; 
            break;
          case "Productor":
            echo "<small><p align='center'><b>INGRESE PRODUCTOR NUEVO</p></small></b>";
            break;
          case "Autor":
            echo "<small><p align='center'><b>INGRESE AUTOR NUEVO</p></small></b>";
            break;
          case "Coautor":
            echo "<small><p align='center'><b>INGRESE COAUTOR NUEVO</p></small></b>";
            break;
          case "Artista":
            echo "<small><p align='center'><b>INGRESE ARTISTA NUEVO</p></small></b>";
            break;
          case "Editor":
            echo "<small><p align='center'><b>INGRESE EDITOR NUEVO</p></small></b>";
            break;
          case "Titular":
            echo "<small><p align='center'><b>INGRESE TITULAR NUEVO</p></small></b>";
            break;
       }
       ?>
       <form name="frmnatjur" id="frmnatjur" action="d_gbnatjur.php" method="POST" >
       <?php
       echo "<input type='hidden' name='vsol' value='$vsol'>";
       echo "<input type='hidden' name='vmod' value='$vmod'>";
       echo "<input type='hidden' name='vtip' value='$vtip'>";
       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='0' cellpadding='0' cellspacing='0' width='94%'>";
       if ($vmod=='Natural') {
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Nombre:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vnom' value='$vtex' size='55' maxlength='60' onKeyup='this.value=this.value.toUpperCase()'></font></td>";          
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>C&eacute;dula:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp";
         echo " <select size='1' name='vcodl'>";
         echo "  <option value='V'>V</option>";
         echo "  <option value='E'>E</option>";
         echo "  <option value='P'>P</option>";
         echo " </select><input type='text' name='vcod' size='9' maxlength='9' onKeyup='checkLength(event,this,9,document.frmnatjur.vfec)' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.frmnatjur.vcod,9)'></b></font></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Fecha Nacimiento:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vfec' size='9' maxlength='10' onkeyup='checkLength(event,this,10,document.frmnatjur.vedo)' onchange='valFecha(this,document.frmnatjur.vedo)'></font></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Estado Civil:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;";
         echo " <select size='1' name='vedo'>";
         echo "  <option value='S'>Soltero(a)</option>";
         echo "  <option value='C'>Casado(a)</option>";
         echo "  <option value='D'>Divorciado(a)</option>";
         echo "  <option value='V'>Viudo(a)</option>";          
         echo " </select></font></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Profesi&oacute;n:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vpro' size='40' maxlength='40'></b></font></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Seudonimo:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vseu' size='40' maxlength='30' onKeyup='this.value=this.value.toUpperCase()'></b></font></td>";
         echo "</tr>";
         if ($vtip=='Coautor') {
           echo "<tr>";
           echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
           echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Tipo Coautor:</b></font></small></td>";
           echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
           echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;";
           echo " <select size='1' name='vtco'>";
           echo "  <option value='CD'>Director o Realizador</option>";
           echo "  <option value='CA'>Autor del Argumento de la Adaptaci&oacute;n</option>";
           echo "  <option value='CG'>Autor del Gui&oacute;n o de los Di&aacute;logos</option>";
           echo "  <option value='CM'>Autor de la M&uacute;sica Especialmente Compuesta</option>";
           echo " </select></font></td>";
           echo "</tr>";
         }
       }
       else {
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Raz&oacute;n Social:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vnom' value='$vtex' size='55' maxlength='150' onKeyup='this.value=this.value.toUpperCase()'></font></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Rif:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp";
         echo " <select size='1' name='vcodl'>";
         echo "  <option value='J'>J</option>";
         echo "  <option value='G'>G</option>";
         echo "  <option value='I'>E</option></select>";
         echo " <input type='text' name='vcod' size='10' maxlength='9' onKeyPress='return acceptChar(event,2,this)' onchange='Rellena(document.frmnatjur.vcod,9)'></font></td>";
         echo "</tr>"; 
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Datos Registro:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<textarea cols=64 rows=2 name='vdat' maxlength='300' onKeyup='this.value=this.value.toUpperCase()'>$vdat</textarea></font></td>";
         echo "</tr>"; 
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>C&eacute;dula Representante:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp";
          echo " <select size='1' name='vrepl'>";
         echo "  <option value='V'>V</option>";
         echo "  <option value='E'>E</option>";
         echo "  <option value='P'>P</option></select>";
         echo "<input type='text' name='vrep' size='9' maxlength='9' onKeyPress='return acceptChar(event,2,this)' onchange='Rellena(document.frmnatjur.vrep,9)'></font></td>";
         echo "</tr>"; 
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Nombre Representante:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vnre' size='55' maxlength='80' onKeyup='this.value=this.value.toUpperCase()'></font></td>";
         echo "</tr>"; 
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Cualidad Representante:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vcua' size='55' maxlength='40' onKeyup='this.value=this.value.toUpperCase()'>$vcua</font></td>";
         echo "</tr>"; 
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Prueba:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<textarea cols=64 rows=2 name='vpru' maxlength='200' onKeyup='this.value=this.value.toUpperCase()'>$vpru</textarea></font></td>";
         echo "</tr>";
       }
       if ($vtip=='Titular') {
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>T&iacute;tulo o Presunci&oacute;n Legal:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vleg' size='55' maxlength='120' onKeyup='this.value=this.value.toUpperCase()'>$vleg</font></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Documento de Transferencia:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vtra' size='55' maxlength='100' onKeyup='this.value=this.value.toUpperCase()'>$vtra</font></td>";
         echo "</tr>";
       }
       $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       $filas_res_pais=pg_numrows($res_pais);
       $reg = pg_fetch_array($res_pais);
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Pa&iacute;s Residencia:</b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<select size='1' name='vpai'>";
       for($cont=0;$cont<$filas_res_pais;$cont++) { 
         echo "<option value=$reg[pais]>$reg[pais] $reg[nombre]</option>";
         $reg = pg_fetch_array($res_pais);
       }
       echo "</select></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Domicilio:</b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vdom' size='55' maxlength='120'></font></td>";
       echo "</tr>";

         echo "<tr>";
         echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
         echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Indole:</b></font></small></td>";
         echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
         echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp";
          echo " <select size='1' name='vindole'>";
         echo "  <option value=' '> </option>";
         echo "  <option value='G'>Sector Publico</option>";
         echo "  <option value='C'>Cooperativas</option>";
         echo "  <option value='O'>Comunal</option>";
         echo "  <option value='P'>Empresa Privada</option>";
         echo "  <option value='N'>Persona Natural</option></select>";
         echo "</font></td>";
         echo "</tr>"; 

       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Tel&eacute;fono 1:</b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vtlf' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vtlf2)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Tel&eacute;fono 2:</b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vtlf2' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vfax)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Fax:</b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vfax' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vemail)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Email:</b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vemail' size='25' maxlength='30' onKeyup='checkLength(event,this,30,document.forobfie.vemail)'></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b></b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;</font></td>";
       echo "</tr>";
       echo "</table>";
       echo "<p align='center'><input type='image' name='incluir' value='Grabar Nuevo Solicitante' src='../imagenes/save_f2.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                               <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
       echo "</form>";
       exit;
   }
   ?>
   <p align='center'><b><font size='3' face='Tahoma'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Solicitudes Encontradas </font></b></p>
   <?php
   switch ($vtip) {
      case "Solicitante":
        echo "<small><p align='center'><b>SELECCIONE EL SOLICITANTE QUE DESEA ASOCIAR:</b></small></p>"; 
        break;
      case "Productor":
        echo "<small><p align='center'><b>SELECCIONE EL PRODUCTOR QUE DESEA ASOCIAR:</b></small></p>";
        break;
      case "Autor":
        echo "<small><p align='center'><b>SELECCIONE EL AUTOR QUE DESEA ASOCIAR:</b></small></p>";
        break;
      case "Coautor":
        echo "<small><p align='center'><b>SELECCIONE EL COAUTOR QUE DESEA ASOCIAR:</b></small></p>";
        break;
      case "Artista":
        echo "<small><p align='center'><b>SELECCIONE EL ARTISTA QUE DESEA ASOCIAR:</b></small></p>";
        break;
      case "Editor":
        echo "<small><p align='center'><b>SELECCIONE EL EDITOR QUE DESEA ASOCIAR:</b></small></p>";
        break;
      case "Titular":
        echo "<small><p align='center'><b>SELECCIONE EL TITULAR QUE DESEA ASOCIAR:</b></small></p>";
        break;
   }       
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font>Sel</td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>CODIGO</font></td>";
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>CEDULA/RIF</font></td>";
   echo " <td width='19%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NOMBRE</font></td>";
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NACIONALIDAD</font></td>";
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>DOMICILIO</font></td>";

   if ($vtip=='Titular') {
   echo " <td width='25%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Titulo/Presuncion Legal</font></td>";
   echo " <td width='25%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Documento de Transferencia</font></td>";
   }
   if ($vtip=='Coautor') {
   echo " <td width='25%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Tipo de Coautor</font></td>";
   }
   echo "</tr>";
// llamado de la Forma ---->
   echo "<form name='formsoli' id='formsoli' action='d_gbnatjur.php' method='POST'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vtip' value='$vtip'>";

// Colocar los input dependiendo del personaje
   for($cont=0;$cont<$filas_resultado;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><input type='checkbox' name='B$cont'></font></td>";
     $titacum[$cont]=$reg[titular];
     $nomacum[$cont]=$reg[nombre];
     $cedacum[$cont]=$reg[ced_rif];
     $fnaacum[$cont]=$reg[fecha_nacim];
     $eciacum[$cont]=$reg[estado_civil];
     $indacum[$cont]=$reg[indole];
     $te1acum[$cont]=$reg[telefono1];
     $te2acum[$cont]=$reg[telefono2];
     $faxacum[$cont]=$reg[fax];
     $proacum[$cont]=$reg[profesion];
     $seuacum[$cont]=$reg[seudonimo];
     $emaacum[$cont]=$reg[email];
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[titular]</font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[ced_rif]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[nombre]</font></td>";

// Ingreso de la Nacionalidad y el Domicilio
       $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       $filas_res_pais=pg_numrows($res_pais);
       $reg_pd = pg_fetch_array($res_pais);
       echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><select size='1' name='vnac$cont' size='2'>";
       for($cont_p=0;$cont_p<$filas_res_pais;$cont_p++) { 
         if ($reg[pais] == $reg_pd[pais]){
           echo"<OPTION value=$reg[pais] SELECTED>$reg_pd[pais] $reg_pd[nombre]</OPTION>\n";
         } else {
           echo"<OPTION value=$reg_pd[pais]>$reg_pd[pais] $reg_pd[nombre]</OPTION>\n";
         }
         $reg_pd = pg_fetch_array($res_pais);
       }
       echo "</select></font></td>";
       echo " <td width='15%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'><input type='text' name='vdom$cont' value='$reg[domicilio]' size='20' maxlength='200'></font></td>"; 
   

     if ($vtip=='Coautor') {
     echo " <td width='25%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><select size='1' name='vtipoco$cont' value='$reg[tipo_coautor]' size='2'>"; 
     echo "<option value='CD'>Director o Realizador</option>";
     echo "<option value='CA'>Argumento Adaptaci&oacute;n</option>";
     echo "<option value='CG'>Gui&oacute;n o Dialogos</option>";
     echo "<option value='CM'>Autor de la M&uacute;sica</option>";
     echo "</select></font></td>";
     }
     if ($vtip=='Titular') {
     echo " <td width='25%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'><input type='text' name='vtitpre$cont' value='$reg[titulo_p]' size='20' maxlength='30'></font></td>"; 
     echo " <td width='25%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'><input type='text' name='vdoctra$cont' value='$reg[doc_transfer]' size='20' maxlength='100'></font></td>"; 
     }
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
   }
// Fin de muestreo de personajes

   echo "</table>"; 
// lectura de Variables tipo vector
   for($cont=0;$cont<$filas_resultado;$cont++) {
          echo "<input type='hidden' name='vtit$cont' value='$titacum[$cont]'>";
          echo "<input type='hidden' name='vnom$cont' value='$nomacum[$cont]'>";
          echo "<input type='hidden' name='vced$cont' value='$cedacum[$cont]'>";
          echo "<input type='hidden' name='vfna$cont' value='$fnaacum[$cont]'>";
          echo "<input type='hidden' name='veci$cont' value='$eciacum[$cont]'>";
          echo "<input type='hidden' name='vind$cont' value='$indacum[$cont]'>";
          echo "<input type='hidden' name='vte1$cont' value='$te1acum[$cont]'>";
          echo "<input type='hidden' name='vte2$cont' value='$te2acum[$cont]'>";
          echo "<input type='hidden' name='vfax$cont' value='$faxacum[$cont]'>";
          echo "<input type='hidden' name='vpro$cont' value='$proacum[$cont]'>";
          echo "<input type='hidden' name='vseu$cont' value='$seuacum[$cont]'>";
          echo "<input type='hidden' name='vema$cont' value='$emaacum[$cont]'>";
   } 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vfil' value='$filas_resultado'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<p align='center'><font color='#0000FF'>";
   //echo "<input type='submit' value='Incluir' name='incluir'>
   //      <input type='button' value='Salir' name='salir' onclick='window.close()'></font></p>"; 
   echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/save_f2.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                           <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
   echo "</form>";
   echo "<form name 'frmsolici' action='d_opinsoli.php?vsol=$vsol&vmod=$vmod&vtex=$vtex' method='POST'>"; 
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
   <?
   }
   else
   {
   //espacio    &nbsp;
   }
   echo "</form>";
   
  }
  //Desconexion de la Base de Datos
  $sql->disconnect();

?>
</body>
</html>
