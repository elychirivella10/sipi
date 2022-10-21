<?php
include ("../z_includes.php");
?>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>SIPI - Sistema de Informaci&oacute;n de Propiedad Intelectual</title>
</head> 
<body onload="centrarwindows()" bgcolor="FFFFFF">

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
//$login = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();

$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];
$vtip=$_GET['vtip'];

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->assign('subtitulo','Mantenimiento de Solicitante / Autor / Titular / Productor / Artista'); 
$smarty->display('encabezado1.tpl');

//echo " $vsol, $vmod, $vtip, $vtex ";
if ($vmod=='Natural' || $vmod=='Juridica') {
  echo "<small><p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>SOLICITUD: $vsol, Persona $vmod: $vtex</b></font></small></p>"; }
else {
  echo "<small><p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>SOLICITUD: $vsol, $vmod: $vtex</b></font></small></p>"; }

if (empty($vsol)) { 
   echo "<hr>";
   echo "<p align='center'><b>INTRODUZCA PRIMERO EL NUMERO DE SOLICITUD</b>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close()'></font></p>";
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
  $cuanto = 10;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vtex']=$vtex;
$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$cuanto;
$hiddenvars['total']=$total;

 if ($vmod=='Natural' || $vmod=='Juridica')
  {

  if ($vtip=='Solicitante') {
   $resul=pg_exec("SELECT * from stdtmpso where solicitud='$vsol'"); 
   if (pg_numrows($resul) > 1) {
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
            echo "<p align='center'><b>INGRESE DATOS DEL SOLICITANTE NUEVO</p></b>"; 
            break;
          case "Productor":
            echo "<p align='center'><b>INGRESE DATOS DEL PRODUCTOR NUEVO</p></b>";
            break;
          case "Autor":
            echo "<p align='center'><b>INGRESE DATOS DEL AUTOR NUEVO</p></b>";
            break;
          case "Coautor":
            echo "<p align='center'><b>INGRESE DATOS DEL COAUTOR NUEVO</p></b>";
            break;
          case "Artista":
            echo "<p align='center'><b>INGRESE DATOS DEL ARTISTA NUEVO</p></b>";
            break;
          case "Editor":
            echo "<p align='center'><b>INGRESE DATOS DEL EDITOR NUEVO</p></b>";
            break;
          case "Titular":
            echo "<p align='center'><b>INGRESE DATOS DEL TITULAR NUEVO</p></b>";
            break;
       }
       ?>
       <form name="frmnatjur" id="frmnatjur" action="a_gbnatjur.php" method="POST" >
       <?php
       echo "<input type='hidden' name='vsol' value='$vsol'>";
       echo "<input type='hidden' name='vmod' value='$vmod'>";
       echo "<input type='hidden' name='vtip' value='$vtip'>";
       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='1' cellpadding='0' cellspacing='0' width='94%'>";
       if ($vmod=='Natural') {
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Nombre:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "     <input type='text' name='vnom' value='$vtex' size='55' maxlength='60' onKeyup='this.value=this.value.toUpperCase()'><small> Formato: Apellido, Nombre</small></td>";          
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>C&eacute;dula:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo " <select size='1' name='vcodl'>";
         echo "  <option value='V'>V</option>";
         echo "  <option value='E'>E</option>";
         echo "  <option value='P'>P</option>";
         echo " </select><input type='text' name='vcod' size='9' maxlength='9' onKeyup='checkLength(event,this,9,document.frmnatjur.vfec)' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.frmnatjur.vcod,9)'></b></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Fecha Nacimiento:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "      <input type='text' name='vfec' size='9' maxlength='10' onkeyup='checkLength(event,this,10,document.frmnatjur.vedo)' onchange='valFecha(this,document.frmnatjur.vedo)'></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Estado Civil:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo " <select size='1' name='vedo'>";
         echo "  <option value='S'>Soltero(a)</option>";
         echo "  <option value='C'>Casado(a)</option>";
         echo "  <option value='D'>Divorciado(a)</option>";
         echo "  <option value='V'>Viudo(a)</option>";          
         echo " </select></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Profesi&oacute;n:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "      <input type='text' name='vpro' size='40' maxlength='40'></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Seudonimo:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "      <input type='text' name='vseu' size='40' maxlength='80' onKeyup='this.value=this.value.toUpperCase()'></b></td>";
         echo "</tr>";
         if ($vtip=='Coautor') {
           echo "<tr>";
           echo "   <td width='23%' class='izq-color'><b>Tipo Coautor:&nbsp;&nbsp;</b></td>";
           echo "   <td width='77%' class='der-color'>";
           echo " <select size='1' name='vtco'>";
           echo "  <option value='CD'>Director o Realizador</option>";
           echo "  <option value='CA'>Autor del Argumento de la Adaptaci&oacute;n</option>";
           echo "  <option value='CG'>Autor del Gui&oacute;n o de los Di&aacute;logos</option>";
           echo "  <option value='CM'>Autor de la M&uacute;sica Especialmente Compuesta</option>";
           echo " </select></td>";
           echo "</tr>";
         }
       }
       else {
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Raz&oacute;n Social:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "      <input type='text' name='vnom' value='$vtex' size='55' maxlength='150' onKeyup='this.value=this.value.toUpperCase()'></td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Rif:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo " <select size='1' name='vcodl'>";
         echo "  <option value='J'>J</option>";
         echo "  <option value='G'>G</option>";
         echo "  <option value='I'>E</option></select>";
         echo " <input type='text' name='vcod' size='10' maxlength='9' onKeyPress='return acceptChar(event,2,this)' onchange='Rellena(document.frmnatjur.vcod,9)'></td>";
         echo "</tr>"; 
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Datos Registro:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "      <textarea cols=64 rows=2 name='vdat' maxlength='300' onKeyup='this.value=this.value.toUpperCase()'>$vdat</textarea></td>";
         echo "</tr>"; 
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>C&eacute;dula Representante:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
          echo " <select size='1' name='vrepl'>";
         echo "  <option value='V'>V</option>";
         echo "  <option value='E'>E</option>";
         echo "  <option value='P'>P</option></select>";
         echo "<input type='text' name='vrep' size='9' maxlength='9' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.frmnatjur.vrep,9)'></td>";
         echo "</tr>"; 
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Nombre Representante:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "      <input type='text' name='vnre' size='55' maxlength='80' onKeyup='this.value=this.value.toUpperCase()'></td>";
         echo "</tr>"; 
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Cualidad Representante:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "      <input type='text' name='vcua' size='55' maxlength='40' onKeyup='this.value=this.value.toUpperCase()'>$vcua</td>";
         echo "</tr>"; 
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Prueba:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "      <textarea cols=64 rows=2 name='vpru' maxlength='200' onKeyup='this.value=this.value.toUpperCase()'>$vpru</textarea></td>";
         echo "</tr>";
       }
       if ($vtip=='Titular') {
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>T&iacute;tulo o Presunci&oacute;n Legal:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "      <input type='text' name='vleg' size='55' maxlength='120' onKeyup='this.value=this.value.toUpperCase()'>$vleg</td>";
         echo "</tr>";
         echo "<tr>";
         echo "   <td width='23%' class='izq-color'><b>Documento de Transferencia:&nbsp;&nbsp;</b></td>";
         echo "   <td width='77%' class='der-color'>";
         echo "      <input type='text' name='vtra' size='55' maxlength='100' onKeyup='this.value=this.value.toUpperCase()'>$vtra</td>";
         echo "</tr>";
       }
       $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       $filas_res_pais=pg_numrows($res_pais);
       $reg = pg_fetch_array($res_pais);
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><b>Pa&iacute;s Residencia:&nbsp;&nbsp;</b></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "       <select size='1' name='vpai'>";
       for($cont=0;$cont<$filas_res_pais;$cont++) { 
         echo "<option value=$reg[pais]>$reg[pais] $reg[nombre]</option>";
         $reg = pg_fetch_array($res_pais);
       }
       echo "</select></font></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><b>Domicilio:&nbsp;&nbsp;</b></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "      <input type='text' name='vdom' size='90' maxlength='120'></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><b>Indole:&nbsp;&nbsp;</b></td>";
       echo "   <td width='77%' class='der-color'>";
       echo " <select size='1' name='vindole'>";
       echo "  <option value=' '> </option>";
       if ($vmod=='Juridica') {
         echo "  <option value='P'>Empresa Privada</option>";
         echo "  <option value='G'>Sector Publico</option>";
         echo "  <option value='C'>Cooperativas</option>";
         echo "  <option value='O'>Comunal</option>"; }
       if ($vmod=='Natural') {
         echo "  <option value='N'>Persona Natural</option></select>"; }
       echo "</td>";
       echo "</tr>"; 
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><b>Tel&eacute;fono 1:&nbsp;&nbsp;</b></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "      <input type='text' name='vtlf' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vtlf2)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><b>Tel&eacute;fono 2:&nbsp;&nbsp;</b></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "       <input type='text' name='vtlf2' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vfax)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><b>Fax:&nbsp;&nbsp;</b></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "       <input type='text' name='vfax' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vemail)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></td>";
       echo "</tr>";
       echo "<tr>";
       echo "   <td width='23%' class='izq-color'><b>Correo:&nbsp;&nbsp;</b></td>";
       echo "   <td width='77%' class='der-color'>";
       echo "      <input type='text' name='vemail' size='80' maxlength='120' onKeyup='checkLength(event,this,30,document.forobfie.vemail)'></td>";
       echo "</tr>";
       //echo "<tr>";
       //echo "   <td width='23%' class='izq-color'><b></b></td>";
       //echo "   <td width='77%' class='der-color'>";
       //echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;</td>";
       //echo "</tr>";
       echo "</table>";

       echo "<p align='center'>
         <input type='image' name='salir' value='Incluir' src='../imagenes/boton_guardar_azul.png'>&nbsp
         <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png'></p>";       

       //echo "<p align='center'><input type='image' name='incluir' value='Grabar Nuevo Solicitante' src='../imagenes/save_f2.png'>&nbsp;Grabar&nbsp;&nbsp;
       //                        <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' >&nbsp;Salir&nbsp;&nbsp;</p>";
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
   echo " <td width='01%' class='columna-titulo'></font>Sel</td>";   
   echo " <td width='07%' class='columna-titulo'>CODIGO</td>";
   echo " <td width='10%' class='columna-titulo'>CEDULA/RIF</font></td>";
   echo " <td width='15%' class='columna-titulo'>NOMBRE</font></td>";
   echo " <td width='14%' class='columna-titulo'>DOMICILIO</font></td>";
   echo " <td width='10%' class='columna-titulo'>PAIS</font></td>";

   if ($vtip=='Titular') {
   echo " <td width='25%' class='columna-titulo'>Titulo/Presuncion Legal</td>";
   echo " <td width='25%' class='columna-titulo'>Documento de Transferencia</td>";
   }
   if ($vtip=='Coautor') {
   echo " <td width='25%' class='columna-titulo'>Tipo de Coautor</td>";
   }
   echo "</tr>";
// llamado de la Forma ---->
   echo "<form name='formsoli' id='formsoli' action='a_gbnatjur.php' method='POST'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vtip' value='$vtip'>";

// Colocar los input dependiendo del personaje
   for($cont=0;$cont<$filas_resultado;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><input type='checkbox' name='B$cont'></font></td>";
     $vide = $reg[ced_rif];
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
     if (!empty($vide)) { $vcodl = substr($vide,0,1); $vcod = trim(substr($vide,1,9)); }
     //if (!empty($vcodl)) { $vcodl='N'; }
     echo " <td width='07%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[titular]</font></td>";
     //echo " <td width='07%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[ced_rif]</font></td>";
     echo " <td width='07%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'>";
     echo " <select size='1' name='vcodl$cont' value='$vcodl'>";
     //echo "  <option value='V'>V</option>";
     //echo "  <option value='E'>E</option>";
     //echo "  <option value='P'>P</option>";
     //echo "  <option value='J'>J</option>";
     //echo "  <option value='G'>G</option>";
     if ($vmod=='Natural') {
       //if ($vcodl=='N') { echo "  <option value='N' selected>N</option>"; }
       if ($vcodl=='V') { echo "  <option value='V' selected>V</option>"; }
       else { echo "  <option value='V'>V</option>"; }
       if ($vcodl=='P') { echo "  <option value='P' selected>P</option>"; }
       else { echo "  <option value='P'>P</option>"; }
     }
     if ($vmod=='Juridica') {
       if ($vcodl=='J') { echo "  <option value='J' selected>J</option>"; }
       else {echo "  <option value='J'>J</option>"; }
       if ($vcodl=='G') { echo "  <option value='G' selected>G</option>"; }
       else { echo "  <option value='G'>G</option>"; }
       if ($vcodl=='E') { echo "  <option value='E' selected>E</option>"; }
       else { echo "  <option value='E'>E</option>"; }
     }
     echo " </select><input type='text' name='vcod$cont' value='$vcod' size='7' maxlength='9' onKeyup='checkLength(event,this,9,document.formsoli.vfec)' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.formsoli.vcod,9)'></b></td>";
     echo " <td width='26%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[nombre]</font></td>";
     // Ingreso de la Nacionalidad y el Domicilio
     echo " <td width='22%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'><input type='text' name='vdom$cont' value='$reg[domicilio]' size='55' maxlength='200'></font></td>"; 
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

   echo "<p align='center'>
         <input type='image' name='salir' value='Incluir' src='../imagenes/boton_guardar_azul.png'>&nbsp
         <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png'></p>";       

   echo "</form>";
   echo "<form name 'frmsolici' action='adm_solobra.php?vsol=$vsol&vmod=$vmod&vtex=$vtex' method='POST'>"; 
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

 if ($vmod=='Corregir') {
   switch ($vtip) {
     case "Solicitante":
       $nbtabla="stdtmpso";
       break;
     case "Productor":
       $nbtabla="stdtmppt"; 
       break;
     case "Autor":
       $nbtabla="stdtmpau"; 
       break;
     case "Coautor":
       $nbtabla="stdtmpco"; 
       break;
     case "Artista":
       $nbtabla="stdtmpar"; 
       break;
     case "Editor":
       $nbtabla="stdtmped"; 
       break;
     case "Titular":
       $nbtabla="stdtmpti"; 
       break;
   }       

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
     echo "<p align='center'><b>Aviso: Introduzca primero el C&oacute;digo del $vtip que desea Corregir ... !!!</b>";
     echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='window.close();' class='boton_blue'></font></p>";
     echo "</td></tr>";
     echo "</table>";
     echo "</fieldset>";
     echo "</td></tr>";
     echo "</table>";
     exit;
   }   
   
   $resultado = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$vsol' ORDER BY nombre");
   if ($vtip=='Coautor1') {
     $resultado = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$vsol' and tipo_autor='CD' ORDER BY nombre"); }
   if ($vtip=='Coautor2') {
     $resultado = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$vsol' and tipo_autor='CA' ORDER BY nombre"); }
   if ($vtip=='Coautor3') {
     $resultado = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$vsol' and tipo_autor='CG' ORDER BY nombre"); }
   if ($vtip=='Coautor4') {
     $resultado = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$vsol' and tipo_autor='CM' ORDER BY nombre"); }
   
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
     echo "<p align='center'><b>C&oacute;digo del $vtip NO pertenece a la Solicitud ... !!!</b>";
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
      $vide=trim($reg['ced_rif']);
      $vnom=trim($reg['nombre']);
      $vnac=trim($reg['pais']);
      $vdom=trim($reg['domicilio']); 
      $vtel=trim($reg['telefono1']);
      $vcel=trim($reg['telefono2']);
      $vfax=trim($reg['fax']);
      $vcor=trim($reg['email']);
      $vper = trim($reg['tipo_persona']);
      $vind = trim($reg['indole']);
      if (!empty($vide)) { $vcodl = substr($vide,0,1); $vcod = substr($vide,1,9); }
   }
   echo "<form name='formtitular' action='a_gbnatjur.php' method='post'>";
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vtip' value='$vtip'>";
   echo "<input type='hidden' name='vper' value='$vper'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "&nbsp;";
   echo "<div align='center'>";
   echo "<table width='100%' border='0' cellpadding='0' cellspacing='1'>";
   echo "<tr><td>";
   echo "<fieldset>";
   echo "<legend align='center'><strong>CORRECCION DE DATOS DEL SOLICITANTE / AUTOR / PRODUCTOR / TITULAR / ARTISTA</strong></legend>";  
   echo "<table width='100%' border='1' cellpadding='0' cellspacing='1'>";
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
   if ($vind=='N') { $vper = "N"; } else { $vper = "J"; }
   echo "  </select>";
   echo "  <input type='text' name='vcod' value='$vcod' size='9' maxlength='9' onKeyup='checkLength(event,this,9,document.formtitular.vnom)' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.formtitular.vcod,9)'></b>";
   echo "  <font size='1'>&nbsp;&nbsp;V= Venezolano  E= Extranjero  P= Pasaporte  J= Juridico  G= Gobierno&nbsp;&nbsp;&nbsp;&nbsp;<I><b>( Si esta en el expediente se debe cargar ...! )</b></I></font></td>";
   echo "</tr>";
   echo " <tr>";
   echo " <td class='izq-color'>Direcci&oacute;n/Domicilio Completo:</td>";
   echo " <td class='der-color'><input type='text' size='90' name='vdom' maxlength='200' value='$vdom' onchange='isdirvalida(document.formtitular.vdom.value,this.form,this);'><font face='Arial' color='#800000' size='3' valign='up'>*</font></td></tr>";
   $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY nombre");
   $filas_res_pais=pg_numrows($res_pais);
   $reg = pg_fetch_array($res_pais);
   echo " <tr>";
   echo " <td class='izq-color'>Pa&iacute;s:</td>";
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
   echo " <td class='izq-color'>Correo Electr&oacute;nico:</td>";
   echo " <td class='der-color'><input type='text' size='50' name='vcor' maxlength='80' value='$vcor' onkeyup='number_cor(this);' onchange='isEmail2(document.formtitular.vcor.value,this.form,this);'></td></tr>";
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
   echo "<p align='center'><input type='image' src='../imagenes/boton_guardar_azul.png' value='Guardar'>&nbsp;&nbsp;<input type='image' value='Salir' name='aceptar' src='../imagenes/boton_salir_rojo.png' onclick='window.close();'></font></p>";
   echo "</fieldset>";
   echo "</td></tr>";
   echo "</table>";
   echo "</form>";
 }

 if ($vmod=='Eliminar') {
   switch ($vtip) {
     case "Solicitante":
       $nbtabla="stdtmpso";
       break;
     case "Productor":
       $nbtabla="stdtmppt"; 
       break;
     case "Autor":
       $nbtabla="stdtmpau"; 
       break;
     case "Coautor":
       $nbtabla="stdtmpco"; 
       break;
     case "Artista":
       $nbtabla="stdtmpar"; 
       break;
     case "Editor":
       $nbtabla="stdtmped"; 
       break;
     case "Titular":
       $nbtabla="stdtmpti"; 
       break;
   }       

   $resultado = pg_exec("SELECT * FROM $nbtabla WHERE solicitud='$vsol' ORDER BY nombre");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form name="formtitular" action="a_gbnatjur.php" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vtip' value='$vtip'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><b>Selecciones los Solicitante que desea Eliminar:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='1' width='100%'>";
   echo "<tr>";
   echo " <td width='01%' class='columna-titulo'>Sel</td>";   
   echo " <td width='05%' class='columna-titulo'>CODIGO</td>";
   echo " <td width='06%' class='columna-titulo'>CEDULA / RIF</td>";
   echo " <td width='30%' class='columna-titulo'>NOMBRE / RAZON SOCIAL</td>";
   echo " <td width='40%' class='columna-titulo'>DOMICILIO</td>";
   echo " <td width='03%' class='columna-titulo'>PAIS</td>";
   echo " <td width='04%' class='columna-titulo'>INDOLE</td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='01%' class='celda3'><input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='05%' class='celda3'>$reg[codigo]</font></td>";
     echo " <td width='06%' class='celda3'>$reg[ced_rif]</font></td>";
     echo " <td width='30%' class='celda3'>$reg[nombre]</font></td>";
     echo " <td width='40%' class='celda3'>$reg[domicilio]</font></td>";
     echo " <td width='03%' class='celda3'>$reg[pais]</font></td>";
     echo " <td width='04%' class='celda3'>$reg[indole]</font></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[codigo]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'><font class='nota3'>NINGUN SOLICITANTE ASOCIADO</font></p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";
      echo "<input type='image' src='../imagenes/boton_eliminar_rojo.png' value='Eliminar'>
            <input type='image' src='../imagenes/boton_salir_rojo.png' value='Salir' onclick='cerrarwindows2()'></p>";
   }
   echo "</form>";
  }

 //Desconexion de la Base de Datos
 $sql->disconnect();

?>
</body>
</html>
