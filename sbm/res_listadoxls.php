<?php 
// Programa PHP. Busqueda de Lista de Resultados de Consulta Tecnica 
// (Lis_compleja.php por Consulta Avanzada)
// Realizado Por Ing. Romulo Mendoza Julio 2011 

// Cabecera para generar xls 
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=archivo.xls");
//Fin Cabecera para generar xls //

echo "<head>";
echo "  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />"; 
echo "</head>";

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//Para trabajar con Operaciones de Bases de Datos
//$root_path    = "/var/www/apl/sipi";
//$include_lib  = "/var/www/apl/librerias";
//$include_path = "$root_path/include";
//Para trabajar con Smarty 
//require ("$root_path/include.php");
//Para trabajar con sessiones
//require("$root_path/aut_verifica.inc.php");
//LLamadas a funciones de Libreria 
//include ("$include_lib/library.php");
//include ("../z_includes.php");

include ("lib/template.inc.php");	// taken from PHPLib
include ("inc/constantes.inc");
include ("lis_funcion.php");

//Conexion con la base de datos SAPI
require ("inc/NormalizaParametros.inc");

$sql = new mod_db();

//Verificando conexion
$sql->connection();

// Realizando Consulta por Busqueda Avanzada
$opcion1 = $_GET["opcion1"];
$opcion1 = normaliza_texto($opcion1);
$opcion2 = $_GET["opcion2"];
$opcion2 = normaliza_texto($opcion2);
$opcion3 = $_GET["opcion3"];
$opcion3 = normaliza_texto($opcion3);
$opcion4 = $_GET["opcion4"];
$opcion4 = normaliza_texto($opcion4);
$opcion5 = $_GET["opcion5"];
$opcion5 = normaliza_texto($opcion5);
$opcion6 = $_GET["opcion6"];
$opcion6 = normaliza_texto($opcion6);
$opcion7 = $_GET["opcion7"];
$opcion7 = normaliza_texto($opcion7);
$opcion8 = $_GET["opcion8"];
$opcion8 = normaliza_texto($opcion8);
$opcion9 = $_GET["opcion9"];
$opcion9 = normaliza_texto($opcion9);

$modocon1= $_GET["modocon1"];
$modocon2= $_GET["modocon2"];
$modocon3= $_GET["modocon3"];
$modocon4= $_GET["modocon4"];
$modocon5= $_GET["modocon5"];
$modocon6= $_GET["modocon6"];
$modocon7= $_GET["modocon7"];
$modocon8= $_GET["modocon8"];
$modocon9= $_GET["modocon9"];
$modo1   = $_GET["modo1"];
$modo2   = $_GET["modo2"];
$modo3   = $_GET["modo3"];
$modo4   = $_GET["modo4"];
$modo5   = $_GET["modo5"];
$modo6   = $_GET["modo6"];
$modo7   = $_GET["modo7"];
$modo8   = $_GET["modo8"];
$modo9   = $_GET["modo9"];
$modover = $_GET["modover"];

//Creando tabla temporal
pg_exec("CREATE TEMPORARY TABLE consulta (solicitud char(11))");
pg_exec("CREATE TEMPORARY TABLE consulta3 (solicitud char(11), cant char(3))");
pg_exec("CREATE TEMPORARY TABLE consulta4 (solicitud char(11), cant char(3))");

$ind=0;
if(!empty($opcion1)) {
  $ind=$ind+1;
  $criterio=$criterio.$modo1.": ".$opcion1." "; 
  $resulopc1 = sqlcompara($modo1,$modocon1,$opcion1);  
}  

if(!empty($opcion2)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo2.": ".$opcion2." "; 
  $resulopc1 = sqlcompara($modo2,$modocon2,$opcion2);
}

if(!empty($opcion3)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo3.": ".$opcion3." "; 
  $resulopc1 = sqlcompara($modo3,$modocon3,$opcion3);
}

if(!empty($opcion4)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo4.": ".$opcion4." "; 
  $resulopc1 = sqlcompara($modo4,$modocon4,$opcion4);
}

if(!empty($opcion5)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo5.": ".$opcion5." "; 
  $resulopc1 = sqlcompara($modo5,$modocon5,$opcion5);
}

if(!empty($opcion6)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo6.": ".$opcion6." "; 
  $resulopc1 = sqlcompara($modo6,$modocon6,$opcion6);
}

if(!empty($opcion7)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo7.": ".$opcion7." "; 
  $resulopc1 = sqlcompara($modo7,$modocon7,$opcion7);
}

if(!empty($opcion8)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo8.": ".$opcion8." "; 
  $resulopc1 = sqlcompara($modo8,$modocon8,$opcion8);
}

if(!empty($opcion9)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo9.": ".$opcion9." "; 
  $resulopc1 = sqlcompara($modo9,$modocon9,$opcion9);
}

// Seleccionar resultado de los diferentes select
$cantidad = pg_exec("INSERT INTO consulta3 SELECT solicitud,count(*)
			    FROM consulta GROUP BY solicitud ORDER BY solicitud "); 
			    
$respuesta= pg_exec("INSERT INTO consulta4 SELECT solicitud FROM consulta3 WHERE cant='$ind'");

$where = $where." consulta4.solicitud=stzderec.solicitud";
$where = $where." AND stzderec.nro_derecho=stppatee.nro_derecho";
$where = $where." AND stzderec.nro_derecho=stzottid.nro_derecho";
$where = $where." AND stppatee.nro_derecho=stzottid.nro_derecho";
$where = $where." AND stzsolic.titular = stzottid.titular";
$where = $where." AND stzderec.tipo_mp='P'";

$resultado=pg_exec("SELECT DISTINCT ON (consulta4.solicitud) consulta4.solicitud, stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad FROM consulta4, stppatee, stzottid, stzsolic, stzderec WHERE $where ORDER BY 1");

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

echo "<body>";
echo "<table width='200' border='1'>";
echo "<tr>";
echo "<th scope='col'>Solicitud</th>";
echo "<th scope='col'>Titulo</th>";
echo "<th scope='col'>Fecha Sol.</th>";
echo "<th scope='col'>Tipo</th>";
echo "<th scope='col'>Est.</th>";
echo "<th scope='col'>Titular</th>";
echo "</tr>";

//echo "<tr>";
//echo "<td>Fernando</td>";
//echo "<td>Muñoz</td>";
//echo "<td>21</td>"; 
//echo "<td>Estudiante</td>";

  for($cont=0;$cont<$filas_resultado;$cont++) {
    $v1 = $registro['solicitud'];
    $v2 = trim($registro['nombre']);
    $v3 = $registro['fecha_solic'];
    $v4 = $registro['tipo_derecho'];
    $v5 = $registro['estatus']-2000;
    $v6 = trim($registro['ntitular']).", Domicilio: ".trim($registro['domicilio']).", Nacionalidad: ".$registro['nacionalidad'];      
    echo "<tr>";
    echo "<td>$v1</td>";
    echo "<td>$v2</td>";
    echo "<td>$v3</td>"; 
    echo "<td>$v4</td>";
    echo "<td>$v5</td>";
    echo "<td>$v6</td>";
    echo "</tr>";
    $registro = pg_fetch_array($resultado);
  }

echo "</table>"; 

//if ($filas_resultado > 0) {
//  echo "<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>";
//  echo "<tr>";
//  echo "    <td width='9%'><div align='left'><font face='Arial' color='#000000' size='2'><b>Solicitud</b></font></div></td>";
//  echo "    <td width='36%'><div align='left'><font face='Arial' color='#000000' size='2'><b>Titulo</b></font></div></td>";
//  echo "    <td width='9%'><div align='left'><font face='Arial' color='#000000' size='2'><b>Fecha Sol.</b></font></div></td>";
//  echo "    <td width='5%'><div align='center'><font face='Arial' color='#000000' size='2'><b>Tipo</b></font></div></td>";
//  echo "    <td width='5%'><div align='left'><font face='Arial' color='#000000' size='2'><b>Est.</b></font></div></td>";
//  echo "    <td width='36%'><div align='center'><font face='Arial' color='#000000' size='2'><b>Titular</b></font></div></td>";
//  echo "</tr>";

//  for($cont=0;$cont<$filas_resultado;$cont++)
//    $v1 = $registro['solicitud'];
//    $v2 = utf8_decode(trim($registro['nombre']));
//    $v3 = $registro['fecha_solic'];
//    $v4 = $registro['tipo_derecho'];
//    $v5 = $registro['estatus']-2000;
//    $v6 = utf8_decode(trim($registro['ntitular'])).", Domicilio: ".utf8_decode(trim($registro['domicilio'])).", Nacionalidad: ".$registro['nacionalidad'];      
//    echo "<tr>";
//    echo "<td><div align='left'><font face='Arial' color='#000000' size='1'>$v1</font></div></td>";
//    echo "<td><div align='left'><font face='Arial' color='#000000' size='1'>$v2</font></div></td>";
//    echo "<td><div align='left'><font face='Arial' color='#000000' size='1'>$v3</font></div></td>";
//    echo "<td><div align='left'><font face='Arial' color='#000000' size='1'>$v4</font></div></td>";
//    echo "<td><div align='left'><font face='Arial' color='#000000' size='1'>$v5</font></div></td>";
//    echo "<td><div align='left'><font face='Arial' color='#000000' size='1'>$v6</font></div></td>";
//    echo "</tr>";
//    $registro = pg_fetch_array($resultado);
//  }
//  echo "</table>";
//}

echo "</body>";
echo "</html>";

//Desconexion a la base de datos
$sql->disconnect();
?>


