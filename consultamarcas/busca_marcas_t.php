<html>

<head>
<meta http-equiv="Content-Language" content="es">
<LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="generator" content="Bluefish 2.2.3" >
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head>

<!-- <body bgcolor="#f9f7ed"> -->
<body oncontextmenu="return false" bgcolor="#FFFFFF">

<?php
 $lastupdate=$_GET['lastupdate'];
?>

<div align="center"> 

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top">
      <div align="center">
       <img src="../imagenes/cinta_azul.png" width="992" height="2">
      </div>
    </td>
  </tr> 
</table>
</div>    

<?php

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit(); }


//Variables
$login   = $_SESSION['usuario_login'];
$urole   = trim($_SESSION['usuario_rol']);
$subtitulo = "Consulta Interna de Marcas";
$fecha   = trim(fechahoy());
$sql = new mod_db();

$smarty->assign('titulo',$subtitulo);
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado3.tpl');

?>

<?php

//Verificando conexion
$sql->connection();

$vtipuser=$_GET['vusuario'];
if ($vtipuser==1)
    {$vhomepage='indexfull.php';}
if ($vtipuser==2)
    {$vhomepage='indexmp.php';}
if ($vtipuser==3)
    {$vhomepage='indexbt.php';}
if ($vtipuser==4)
    {$vhomepage='indexe.php';}
if ($vtipuser==5)
    {$vhomepage='indexi.php';}
if ($vtipuser==6)
    {$vhomepage='indexi2.php';}

//Inicializaci� de Variables; conteo de criterios de busqueda y Querys
pg_exec("CREATE TEMPORARY TABLE consulta (solicitud char(11),fecha_solic char(10),tipo_derecho char(1),nombre char(500),clase char(4),estatus char(4),registro char(7),fecha_regis char(10),fecha_venc char(10),nro_derecho integer)");
pg_exec("CREATE TEMPORARY TABLE consulta1 (solicitud char(11), cant char(3))");
$count_criterios=0;
$vsol1des=$_POST['vsol1des'];
$vsol2des=$_POST['vsol2des'];
$varsol1=sprintf("%04d-%06d",$vsol1des,$vsol2des);
$vsol1has=$_POST['vsol1has'];
$vsol2has=$_POST['vsol2has'];
$varsol2=sprintf("%04d-%06d",$vsol1has,$vsol2has);
if ($varsol2=="0000-000000") {$varsol2=$varsol1;}

if ($varsol1<>"0000-000000") {$count_criterios++;
    $res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho,nombre,stmmarce.clase,estatus,registro,fecha_regis,fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE stzderec.solicitud BETWEEN '$varsol1' AND '$varsol2' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");}

$vregdes= $_POST['vregdes'];
$varreg1=strtoupper(substr($vregdes,-7,1)).sprintf("%06d",substr($vregdes,1));
$vreghas= $_POST['vreghas'];
$varreg2=strtoupper(substr($vreghas,-7,1)).sprintf("%06d",substr($vreghas,1));
if ($varreg2=="000000") {$varreg2=$varreg1;}

if ($varreg1<>"000000") {$count_criterios++;
   $res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho,nombre,stmmarce.clase,estatus,registro,fecha_regis,fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE stzderec.registro BETWEEN '$varreg1' AND '$varreg2' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");}

$vfde=    $_POST['vfde'];
$vfha=    $_POST['vfha'];
if (empty($vfha)) {$vfha=$vfde;}
if (!empty($vfde)) {$count_criterios++;
    $res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho,nombre,stmmarce.clase,estatus,registro,fecha_regis,fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE stzderec.fecha_solic BETWEEN '$vfde' AND '$vfha' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");}

$vest=    substr($_POST['vest'],0,3);
if (!empty($vest) and $vest<>'') {$count_criterios++;
    $res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho,nombre,stmmarce.clase,estatus,registro,fecha_regis,fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE stzderec.estatus='$vest'and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");}

$vtip=    $_POST['vtip'];
if (!empty($vtip) and $vtip<>'') {$count_criterios++;
    $res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho,nombre,stmmarce.clase,estatus,registro,fecha_regis,fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE tipo_derecho='$vtip' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");}

$vcla=    $_POST['vcla'];
if (!empty($vcla)) {$count_criterios++;
    $res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho,nombre,stmmarce.clase,estatus,registro,fecha_regis,fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE clase='$vcla' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");}

$vpai=    substr($_POST['vpai'],0,2);
if (!empty($vpai) and $vpai<>'') {$count_criterios++;
    $res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho,nombre,stmmarce.clase,estatus,registro,fecha_regis,fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec  WHERE pais_resid='$vpai' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho ");}


$vsel=    $_POST['vsel'];
$vtex=    strtoupper($_POST['vtex']);
if (!empty($vtex)) {$count_criterios++;
    if (strlen($vtex)<1)
       {echo "<hr>";
       echo "<p align='center'><b>EL TEXTO PARA BUSQUEDAS POR NOMBRE DEBE CONTENER AL MENOS 1 LETRA(S)...!</b>";
       echo "<hr>";
       echo "<table border='0' cellpadding='0' cellspacing='0' width='100%' height='15'>";
       echo "<tr><td><p align='center'><a href=$vhomepage><font face='Tahoma'>Realizar otra B&uacute;squeda</font></a></td></tr>";
       echo" </tabla>";  
       exit();
       } 
    if ($vsel=="3")
       {
        $valorray=explode(" ",$vtex);
        if (!empty($valorray[2]))
           {echo "<hr>";
            echo "<p align='center'><b>AVISO: DEBE INTRODUCIR COMO MAXIMO DOS PALABRAS SEPARADAS...!</b>";
            echo "<hr>";
            echo "<table border='0' cellpadding='0' cellspacing='0' width='100%' height='15'>";
            echo "<tr><td><p align='center'><a href=$vhomepage><font face='Tahoma'>Realizar otra B&uacute;squeda</font></a></td></tr>";
            echo "</tabla>"; 
            exit();}
        if ($vtipuser==1)
           {$res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho,nombre, stmmarce.clase, estatus,registro, fecha_regis,fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE trim(stzderec.nombre) LIKE '%$valorray[0]%' and trim(stzderec.nombre) LIKE '%$valorray[1]%' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");}
        if ($vtipuser<>1)
           {$res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho, nombre, stmmarce.clase, estatus,registro, fecha_regis, fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE estatus='1555' and trim(stzderec.nombre) LIKE '%$valorray[0]%' and trim(stzderec.nombre) LIKE '%$valorray[1]%' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");}
        }

    if ($vsel=="2")
       {if ($vtipuser==1)
           {$res_consul=pg_exec("INSERT INTO consulta SELECT solicitud, fecha_solic, tipo_derecho, nombre, stmmarce.clase, estatus, registro, fecha_regis, fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE trim(stzderec.nombre) = '$vtex' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");} 
        if ($vtipuser<>1)
           {$res_consul=pg_exec("INSERT INTO consulta SELECT solicitud, fecha_solic, tipo_derecho, nombre, stmmarce.clase, estatus, registro, fecha_regis, fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE stzderec.estatus='1555' and trim(stzderec.nombre) = '$vtex' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");} 
       }
    if ($vsel=="1")
       {if ($vtipuser==1)
           {$res_consul=pg_exec("INSERT INTO consulta SELECT solicitud, fecha_solic, tipo_derecho, nombre, stmmarce.clase, estatus, registro,fecha_regis, fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE trim(stzderec.nombre) LIKE '$vtex%' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");}
        if ($vtipuser<>1)
           {$res_consul=pg_exec("INSERT INTO consulta SELECT solicitud, fecha_solic, tipo_derecho, nombre, stmmarce.clase, estatus, registro, fecha_regis, fecha_venc,stzderec.nro_derecho FROM stzderec, stmmarce WHERE stzderec.estatus='1555' and trim(stzderec.nombre) LIKE '$vtex%' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho");}
       }
}

$vcti=    $_POST['vcti'];
if (!empty($vcti)) {$count_criterios++;
    $res_consul=pg_exec("INSERT INTO consulta SELECT solicitud, fecha_solic, tipo_derecho,nombre, stmmarce.clase,estatus,registro,fecha_regis,fecha_venc,stzderec.nro_derecho FROM stzderec, stmmarce WHERE stzderec.nro_derecho in(select nro_derecho from stzottid where titular='$vcti')");}

$vcag=    $_POST['vcag'];
if (!empty($vcag)) {$count_criterios++;
    $res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho, nombre, stmmarce.clase, estatus,registro,fecha_regis,fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE agente='$vcag' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho" );}

$vntr=    strtoupper($_POST['vntr']);
if (!empty($vntr)) {$count_criterios++;
    $res_consul=pg_exec("INSERT INTO consulta SELECT solicitud,fecha_solic,tipo_derecho, nombre, stmmarce.clase, estatus, registro, fecha_regis,fecha_venc,stzderec.nro_derecho FROM stmmarce, stzderec WHERE tramitante='$vntr' and stzderec.tipo_mp='M' and stzderec.nro_derecho = stmmarce.nro_derecho ");}

$res_consul1=pg_exec("INSERT INTO consulta1 select solicitud,count(*) from consulta GROUP BY solicitud ORDER BY solicitud"); 

//verificando criterios de busqueda
if (empty($count_criterios)) 
   {echo "<hr>";
   echo "<p align='center'><b>AVISO: DEBE INGRESAR UNO O VARIOS CRITERIOS DE BUSQUEDAS...!</b>";
   echo "<hr>";
   //echo "<table border='0' cellpadding='0' cellspacing='0' width='100%' height='15'>";
   //echo "<tr><td><p align='center'><a href=$vhomepage><font face='Tahoma'>Realizar otra Bsqueda</font></a></td></tr>";
   //echo" </tabla>"; 
   //exit();
   }
else {
//Paginaci�
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
  $cuanto = 25;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['vsol1des'] = $vsol1des;
$hiddenvars['vsol2des'] = $vsol2des;
$hiddenvars['vsol1has'] = $vsol1has;
$hiddenvars['vsol2has'] = $vsol2has;
$hiddenvars['vregdes'] = $vregdes;
$hiddenvars['vreghas'] = $vreghas;
$hiddenvars['vfde'] = $vfde;
$hiddenvars['vfha'] = $vfha;
$hiddenvars['vest'] = $vest;
$hiddenvars['vtip'] = $vtip;
$hiddenvars['vcla'] = $vcla;
$hiddenvars['vpai'] = $vpai;
$hiddenvars['vcti'] = $vcti;
$hiddenvars['vcag'] = $vcag;
$hiddenvars['vntr'] = $vntr;
$hiddenvars['vtex'] = $vtex;
$hiddenvars['vsel'] = $vsel;
$hiddenvars['inicio'] = $inicio;
$hiddenvars['cuanto'] = $cuanto;
$hiddenvars['total'] = $total;
$hiddenvars['vusuario'] = $vtipuser;

$resultado=pg_exec("SELECT DISTINCT solicitud,fecha_solic,tipo_derecho, nombre, clase, estatus,registro,fecha_regis,fecha_venc,nro_derecho FROM consulta where solicitud in (select solicitud from consulta1 where cant='$count_criterios') order by solicitud DESC OFFSET $inicio LIMIT $cuanto");
$cantidad=pg_exec("SELECT * FROM consulta1 where cant='$count_criterios'");	
$total=pg_numrows($cantidad);
$filas_resultado=pg_numrows($resultado);

if ($filas_resultado==0) 
   {
   echo "<hr>";     
   echo "<p align='center'><b>AVISO: NO EXISTEN DATOS ASOCIADOS...!</b>\n"; 
   echo "<hr>";
   //pg_close($conexdb);
   // Desconexion de la Base de datos 
   $sql->disconnect();
   //echo "<table border='0' cellpadding='0' cellspacing='0' width='100%' height='15'>";
   //echo "<tr><td><p align='center'><a href=$vhomepage><font face='Tahoma'>Realizar otra Bsqueda</font></a></td></tr>";
   //echo" </tabla>"; 
   //exit();
   } 

if ($filas_resultado!=0) {

?>
<p align='center'><b><font size='3' face='Tahoma'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Solicitudes Encontradas </font></b></p>
<table border="0" cellpadding="1" cellspacing="1" width="100%" align="center">
  <tr>
    <td width="09%" align="center" style="background-color: #00688b; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Solicitud</b></font></td>
    <td width="07%" align="center" style="background-color: #00688b; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha Solicitud</b></font></td>
    <td width="03%" align="center" style="background-color: #00688b; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Tipo Marca</b></font></td>
    <td width="28%" align="center" style="background-color: #00688b; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Nombre</b></font></td>
    <td width="03%" align="center" style="background-color: #00688b; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Clase</b></font></td>
    <td width="03%" align="center" style="background-color: #00688b; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Estatus</b></font></td>
    <td width="06%" align="center" style="background-color: #00688b; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>No. Registro</b></font></td>
    <td width="07%" align="center" style="background-color: #00688b; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha Registro</b></font></td>
    <td width="09%" align="center" style="background-color: #00688b; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha Vencimiento</b></font></td>
    <td width="27%" align="center" style="background-color: #00688b; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Titular/Solicitante</b></font></td>
  </tr>

  <?php    
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_resultado;$cont++) 
     { 
     $estatus=$reg[estatus]-1000;
     echo "<tr>";
     $vs1=substr($reg[solicitud],-11,4);
     $vs2=substr($reg[solicitud],-6,6);
     $vsol=$vs1.'-'.$vs2;
     $varfecha=$reg[fecha_solic];
     $nderec =$reg[nro_derecho];
     
     //busqueda del titular y sus datos
	  $titular='';
  	  $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	  $filas_found1=pg_numrows($res_titular);
	  $regt = pg_fetch_array($res_titular);
	  for($contt1=0;$contt1<$filas_found1;$contt1++)   { 
	    //$pais_nombre=pais($regt['nacionalidad']);
 	    if ($contt1=='0'){
	      //$titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	      $titular= $titular.utf8_decode(trim($regt['nombre'])); }
	    else { 
	      //$titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	      $titular= $titular.", ".utf8_decode(trim($regt['nombre'])); }                
	    $regt = pg_fetch_array($res_titular);
	  } 
     
     echo "<td width='09%' style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'><a href='busca_marcas_n.php?vnsol=$vsol&vusuario=$vtipuser&lastupdate=$lastupdate'>$vsol</a></font></td>";
     echo "<td width='07%' style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>$varfecha</td>";
     echo "<td width='03%' style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>$reg[tipo_derecho]</td>";
     echo "<td width='28%' style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>$reg[nombre]</td>";
     echo "<td width='03%' style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>$reg[clase]</td>";
     echo "<td width='03%' style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>$estatus</td>";
     echo "<td width='06%' style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>$reg[registro]</td>";
     echo "<td width='07%' style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>$reg[fecha_regis]</td>";
     echo "<td width='09%' style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>$reg[fecha_venc]</td>";
     echo "<td width='27%' style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>$titular</td>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
    ?>
</table>
<?php
  if ($vtipuser==1)
     { echo "<form method='POST' action='busca_marcas_t.php?vusuario=1'>"; }
  if ($vtipuser==2)
     { echo "<form method='POST' action='busca_marcas_t.php?vusuario=2'>"; }
  if ($vtipuser==3)
     { echo "<form method='POST' action='busca_marcas_t.php?vusuario=3'>"; }
  if ($vtipuser==5)
     { echo "<form method='POST' action='busca_marcas_t.php?vusuario=5'>"; }
  if ($vtipuser==6)
     { echo "<form method='POST' action='busca_marcas_t.php?vusuario=6'>"; }

?>
<input type="hidden" name="vtex" value="<?= $_POST['vtex'] ?>">
<input type="hidden" name="vsel" value="<?= $_POST['vsel'] ?>">
<input type="hidden" name="adelante">
<input type="hidden" name="atras">
<input type="hidden" name="lastupdate">

<?
foreach($hiddenvars as $var => $val)
{
?>
      <input type="hidden" name="<?= $var ?>" value="<?= $val ?>" />
<?
}
?>

<?
if($inicio > 0)
{
?>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="boton_blue" name="atras" value="Previos <?= min($inicio, $cuanto) ?>" />
<?
}
else
{
   //espacio  &nbsp;
}

if($total - $inicio > $cuanto)
{
?>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' class="boton_blue" name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
<?
}
else
{
	//espacio    &nbsp;
}

?>

<?
}

}


?>



<table border="0" cellpadding="0" cellspacing="0" width="100%" height="15">
  <tr><td><p align='center'><a href='<? echo $vhomepage; ?>'>
<font face='Tahoma' ><input type='button' class='boton_blue' value='Realizar otra B&uacute;squeda' name='B2'></font></a>&nbsp;&nbsp;<input type='button' class='boton_blue' value='Imprimir' onclick='window.print();'>&nbsp;&nbsp;<a href="../salir.php">
<font face='Tahoma' ><input type='button' class='boton_blue' value='Salir' name='B3'></font></a><br></td></tr>
</tabla>
&nbsp;

<table align="center" border="0" cellpadding="0" cellspacing="0" width="70%" height="15">
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#00688b"><b>Los datos emitidos por la siguiente consulta son netamente informativos,</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#00688b"><b>la informaci&oacute;n contenida en la presente p&aacute;gina no obliga ni compromete la responsabilidad del SAPI.</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#00688b"><b>Por lo anterior, no reemplaza en ning&uacute;n caso los mecanismos legales de notificaci&oacute;n</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#00688b"><b>y se constituye exclusivamente en una ayuda adicional para los usuarios de la misma. </font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#00688b"><b>La validez legal de las consultas se notifica a trav&eacute;s del bolet&iacute;n.</font></b></td></tr>
</tabla>


<?php
 $smarty->display('pie_pag.tpl');
?>

</body>

</html>
