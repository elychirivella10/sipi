<?php 
  // *************************************************************************************
  // Programa: index_listado_xls.php 
  // Realizado por el Analista de Sistema Romulo Mendoza 
  // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
  // Año: 2011 II Semestre BD - Relacional 
  // *************************************************************************************
  // Programa PHP. Busqueda de Lista de Resultados Excel de Consulta Tecnica 

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
$opcion   = $_GET["opcion"];
$valor1   = $_GET['valor1'];
$criterio = $_GET["criterio"];

switch($opcion) {
 case 1:
   $valor1 = normaliza_texto($valor1);
   $valor1 = quitar_blancos($valor1);
   break;
 case 2:
   $valor1 = normaliza_texto($valor1);
   $valor1 = quitar_blancos($valor1);
   break;
 case 3:
   $valor1 = normaliza_texto($valor1);
   break;
}
$modoconsulta = $_GET["modoconsulta"];

$where = "";
$where = $where." stzderec.nro_derecho=stppatee.nro_derecho";
$where = $where." AND stzderec.nro_derecho=stzottid.nro_derecho";
$where = $where." AND stppatee.nro_derecho=stzottid.nro_derecho";
$where = $where." AND stzsolic.titular = stzottid.titular";
$where = $where." AND stzderec.tipo_mp='P' ";

switch($opcion) {
 case 1: 
   switch($modoconsulta)
   {
     case 1: //BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
         $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
                        FROM stppatee, stzderec, stzottid, stzsolic 
			WHERE $where AND stzderec.nombre LIKE '$valor1' 
			ORDER BY stzderec.solicitud");
       break;

     case 2: // BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
         $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
                        FROM stppatee, stzderec, stzottid, stzsolic 
			WHERE $where AND stzderec.nombre LIKE '%$valor1%'  
         ORDER BY stzderec.solicitud");
       break;

     case 3: //BÚSQUEDA_NOMBRE_COMIENCE_POR:
         $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
                        FROM stppatee, stzderec, stzottid, stzsolic 
			WHERE $where AND stzderec.nombre LIKE '$valor1%'  
         ORDER BY stzderec.solicitud");
      break;
   }
   break;
 case 2:
   switch($modoconsulta)
   {
     case 1: //BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
        $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic 
			 WHERE $where AND stzsolic.nombre = '$valor1' 
			 ORDER BY stzderec.solicitud");
        break;

     case 2: //BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
        $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic 
			 WHERE $where AND stzsolic.nombre like '%$valor1%' 
			 ORDER BY stzderec.solicitud");
       break;

     case 3: //BÚSQUEDA_NOMBRE_COMIENCE_POR:
        $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic 
			 WHERE $where AND stzsolic.nombre like '$valor1%' 
			 ORDER BY stzderec.solicitud");
       break;
   }
   break;
 case 3: 
   switch($modoconsulta)
   {
     case 1: //BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
        $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic, stpclsfd 
			 WHERE $where 
			 AND stzderec.nro_derecho = stpclsfd.nro_derecho
          AND stpclsfd.clasificacion = '$valor1' 
			 ORDER BY stzderec.solicitud");
        break;
     case 2: //BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
        $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic, stpclsfd 
			 WHERE $where 
			 AND stzderec.nro_derecho = stpclsfd.nro_derecho
          AND stpclsfd.clasificacion like '%$valor1%' 
			 ORDER BY stzderec.solicitud");
        break;

     case 3: //BÚSQUEDA_NOMBRE_COMIENCE_POR:
        $resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
          FROM stppatee, stzderec, stzottid, stzsolic, stpclsfd 
			 WHERE $where 
			 AND stzderec.nro_derecho = stpclsfd.nro_derecho
          AND stpclsfd.clasificacion like '$valor1%' 
			 ORDER BY stzderec.solicitud");
        break;
   }
   break;

 case 4: 
   switch($modoconsulta)
   {
     case 2: //BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
		  $resultado = pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                               stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
                      FROM stppatee, stzderec, stzottid, stzsolic 
			             WHERE stzderec.nro_derecho=stppatee.nro_derecho
                      AND stzderec.nro_derecho=stzottid.nro_derecho
                      AND stppatee.nro_derecho=stzottid.nro_derecho
                      AND stzsolic.titular = stzottid.titular
                      AND stzderec.tipo_mp='P'
                      AND stzderec.nombre LIKE '%$valor1%'
			             UNION 
                      SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
                      FROM stppatee, stzderec, stzottid, stzsolic 
                      WHERE stzderec.nro_derecho=stppatee.nro_derecho
                      AND stzderec.nro_derecho=stzottid.nro_derecho
                      AND stppatee.nro_derecho=stzottid.nro_derecho
                      AND stzsolic.titular = stzottid.titular
                      AND stppatee.resumen LIKE '%$valor1%' 
                      AND stzderec.tipo_mp='P'
                      ORDER BY 1");
        break;
     case 3: //BÚSQUEDA_NOMBRE_COMIENCE_POR:
		  $resultado = pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.fecha_solic,stzderec.registro,stzderec.nombre,stzderec.tipo_derecho,
                               stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
                      FROM stppatee, stzderec, stzottid, stzsolic 
			             WHERE stzderec.nro_derecho=stppatee.nro_derecho
                      AND stzderec.nro_derecho=stzottid.nro_derecho
                      AND stppatee.nro_derecho=stzottid.nro_derecho
                      AND stzsolic.titular = stzottid.titular
                      AND stzderec.tipo_mp='P'
                      AND stzderec.nombre LIKE '$valor1%'
			             UNION 
                      SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stzderec.registro,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,
                             stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad                        
                      FROM stppatee, stzderec, stzottid, stzsolic 
                      WHERE stzderec.nro_derecho=stppatee.nro_derecho
                      AND stzderec.nro_derecho=stzottid.nro_derecho
                      AND stppatee.nro_derecho=stzottid.nro_derecho
                      AND stzsolic.titular = stzottid.titular
                      AND stppatee.resumen LIKE '$valor1%' 
                      AND stzderec.tipo_mp='P'
                      ORDER BY 1");
        break;
   }
   break;
   
}

$titulo= "Patron de Busqueda o ".$criterio;

// Seleccionar resultado de los diferentes select
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
echo "<th scope='col'>Registro</th>";
echo "<th scope='col'>Titular</th>";
echo "</tr>";

  for($cont=0;$cont<$filas_resultado;$cont++) {
    $v1 = $registro['solicitud'];
    $v2 = trim($registro['nombre']);
    $v3 = $registro['fecha_solic'];
    $v4 = $registro['tipo_derecho'];
    $v5 = $registro['estatus']-2000;
    $v6 = $registro['registro'];
    $v7 = trim($registro['ntitular']).", Domicilio: ".trim($registro['domicilio']).", Nacionalidad: ".$registro['nacionalidad'];      
    echo "<tr>";
    echo "<td>$v1</td>";
    echo "<td>$v2</td>";
    echo "<td>$v3</td>"; 
    echo "<td>$v4</td>";
    echo "<td>$v5</td>";
    echo "<td>$v6</td>";
    echo "<td>$v7</td>";
    echo "</tr>";
    $registro = pg_fetch_array($resultado);
  }

echo "</table>"; 

echo "</body>";
echo "</html>";

//Desconexion a la base de datos
$sql->disconnect();
?>



