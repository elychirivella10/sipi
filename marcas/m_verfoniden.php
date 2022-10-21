<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<body>
<?php
// *************************************************************************************
// Programa: m_verfon.php  
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2012
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

$vsol = trim($_GET['psol']);
if ($vsol=='-') { }
else {
//$vsoli=$_GET['psol'].'\r';
$vsoli='%'.$_GET['psol'].'%';
//echo "$vsoli ";

$resultado=pg_exec("SELECT distinct on (b.solicitud) a.expediente,b.solicitud,b.nro_derecho,b.tipo_derecho,c.modalidad,b.estatus,b.fecha_solic,b.nombre,c.clase,c.ind_claseni,b.registro,a.porc,a.partebusq FROM stmfondo a,stzderec b,stmmarce c WHERE a.expediente like '$vsoli' AND a.expediente!='0000-000000' AND a.solicitud=b.solicitud AND b.nro_derecho=c.nro_derecho AND b.tipo_mp='M' AND a.partebusq='I' ORDER BY 2");

$filas_found=pg_numrows($resultado); 
echo "<table style='font-size:13' border='1' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td bgcolor='#CCCCCC' align='center' width='03%'></td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='10%'>Solicitud</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='09%'>Fecha</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='32%'>Nombre</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='01%'>Clase</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='01%'>TP</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='01%'>M</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='04%'>Est.</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='07%'>Registro.</td>";
echo "    <td bgcolor='#CCCCCC' align='center' width='30%'>Titular.</td></tr>";
$vtipuser = 1;
for ($cont=0;$cont<$filas_found;$cont++) {
    $regtmp = pg_fetch_array($resultado); 
    $vsol=$regtmp[solicitud];
    $vder=$regtmp[nro_derecho];
    $vfec=$regtmp[fecha_solic];
    $vnom=trim($regtmp[nombre]);
    $vpor=$regtmp[porc];
    $vind=$regtmp[ind_claseni];
    $vcla=$regtmp[clase]."-".$vind."&nbsp;&nbsp;";
    $vtip=$regtmp[tipo_derecho];
    $vmod=$regtmp[modalidad];
    $vreg=trim($regtmp[registro]);
    if ($vreg=='') { $vreg="0";}
    $vest=($regtmp[estatus]-1000);

    //busqueda del titular y sus datos
    $titular='';
    $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
                            FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$vder'
			     AND stmmarce.nro_derecho=stzottid.nro_derecho
                             AND stzsolic.titular = stzottid.titular");
    $filas_found1=pg_numrows($res_titular);
    $regt = pg_fetch_array($res_titular);
    for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
       $pais_nombre=pais($regt['nacionalidad']);
       if ($cont1=='0'){
	  $titular= $titular.trim($regt['nombre']).'. Pa&iacute;s: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
       else { $titular= $titular.", ".trim($regt['nombre']).'. Pa&iacute;s: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
       $regt = pg_fetch_array($res_titular);
    } 
    $vtit= utf8_decode($titular);
    echo "<tr><td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' 
          align='center' width='03%'><font color='#0000FF'>";
    echo $cont+1;
    echo "</td><td align='center' width='10%'>";
    echo "<a href='../consultamarcas/ver_marcas_fon.php?vnsol=$vsol' target='_blank'>$vsol</a>";  
    echo "</td><td align='center' width='09%'>";
    echo $vfec;
    echo "</td><td wrap='true' align='left' width='32%'>";
    echo "<b>$vnom</b>";
    echo "</td><td align='right' width='01%'>";
    echo "<b>$vcla</b>";
    echo "</td><td align='center' width='01%'>";
    echo $vtip;
    echo "</td><td align='center' width='01%'>";
    echo $vmod;
    echo "</td><td align='right' width='04%'>";
    echo "<b>$vest</b>";
    echo "</td><td align='right' width='07%'>";
    if ($vreg!="0") { echo "<b>$vreg</b>"; }
    else { echo $vreg; }
    echo "</td><td wrap='true' align='left' width='30%'>";
    echo $vtit;
    echo "</td></tr>";
} 
echo "</table>";

}
//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
