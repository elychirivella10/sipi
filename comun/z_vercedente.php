<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<?php
//<style type="text/css">
//body {background-color: WHITE;}
//</style>

// ************************************************************************************* 
// Programa: z_vercedente.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPEF
// Año: 2018 I Semestre BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

$vsoli=$_GET['psol'];
$vder =$_GET['pder'];

$resultado=pg_exec("SELECT * FROM stztmptit WHERE solicitud='$vsoli' and solicitud!='0000-000000' AND tipo_mp='$vder'");
$filas_found=pg_numrows($resultado);
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center' width='05%'></td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>C&oacute;digo</td>"; 
echo "    <td bgcolor='#CCCCCC' align='left' width='35%'>Nombre</td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='45%'>Domicilio</td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='05%'>Pa&iacute;s Domicilio</td>";
echo "    <td bgcolor='#CCCCCC' align='left' width='05%'>Nacionalidad</td></tr>";
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vnombre=$regtmp[nombre];
    $vtitular=$regtmp[titular];
    // 
    $vpais=$regtmp[nacionalidad];
    $res_pais=pg_exec("SELECT nombre FROM stzpaisr where pais='$vpais'");
    $regpais = pg_fetch_array($res_pais);
    $vpais=$vpais.'-'.$regpais[nombre]; 
    //    
    $vdomicilio=$regtmp[domicilio];     
    //
    $vpaisdomicilio=trim($regtmp[pais_domicilio]);     
    $res_pais=pg_exec("SELECT nombre FROM stzpaisr where pais='$vpaisdomicilio'");
    $regpais = pg_fetch_array($res_pais);
    $vpaisdomicilio=$vpaisdomicilio.'-'.$regpais[nombre];     
    //
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center'><font color='#0000FF'><small>";
    echo $cont+1;
    echo "</small></td><td align='center'><small>";
    echo $vtitular; 
    echo "</small></td><td align='left'><small>";
    echo $vnombre; 
    echo "</small></td><td><small>";
    echo $vdomicilio; 
    echo "</small></td><td><small>";
    echo $vpaisdomicilio; 
    echo "</small></td><td><small>";
    echo $vpais; 
    echo "</small></td></tr>";
}
echo "</table>";

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
