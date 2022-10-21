<?php
	// Creado por Pendulo Software - Anderson Guzman, como colaboracion en la correcion de transformacion de codigo de caracteres ISO8859-1 a UTF-8 en 
	// la migracion de la base de datos desde Informix a PostgreSQL
	// Caracas 04/09/2007
	
	set_time_limit(0);
	//$cadena_conexion = "host=localhost port=5432 dbname=bdpi user=postgres";
	$cadena_conexion = "host=localhost dbname=bdpi1 user=postgres";
   $conex = pg_connect($cadena_conexion);
   //echo "$cadena_conexion  $conex ";
	if(($conex = pg_connect($cadena_conexion))==false) {
		die ("Error en la conexion");
	}else{
		//$recordset = pg_query($conex, "SELECT solicitud, distingue FROM stmdistd WHERE distingue LIKE '%Ã¡%' OR distingue LIKE '%í¡%'");
		//while ($fila = pg_fetch_row($recordset)){
		//	$sustitucion_a = preg_replace("/(Ã¡|í¡)/", "á", $fila[1]);
		//	echo ($fila[0] . "--" . $sustitucion_a. "<br>");
		//	pg_query($conex, "UPDATE stmdistd SET distingue = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 
   	//}
		//$recordset = pg_query($conex, "SELECT solicitud, distingue FROM stmdistd WHERE distingue LIKE '%í©%'");
		//while ($fila = pg_fetch_row($recordset)){
		//	$sustitucion_a = preg_replace("/(í©|ÃƒÂ©)/", "é", $fila[1]);
		//	echo ($fila[0] . "--" . $sustitucion_a. "<br>");
		//	pg_query($conex, "UPDATE stmdistd SET distingue = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 
   	//}
		$recordset = pg_query($conex, "SELECT solicitud, distingue FROM stmdistd WHERE distingue LIKE '%Ã%' OR distingue LIKE '%ÃƒÂ%'");
		while ($fila = pg_fetch_row($recordset)){
			$sustitucion_a = preg_replace("/(Ã|ÃƒÂ)/", "í", $fila[1]);
			echo ($fila[0] . "--" . $sustitucion_a. "<br>");
			pg_query($conex, "UPDATE stmdistd SET distingue = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 
   	}
		//$recordset = pg_query($conex, "SELECT solicitud, distingue FROM stmdistd WHERE distingue LIKE '%Ã³%' OR distingue LIKE '%ÃƒÂ³%'");		//while ($fila = pg_fetch_row($recordset)){		//	$sustitucion_a = preg_replace("/(Ã³|ÃƒÂ³)/", "ó", $fila[1]);		//	echo ($fila[0] . "--" . $sustitucion_a. "<br>");		//	pg_query($conex, "UPDATE stmdistd SET distingue = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 		//}
		//$recordset = pg_query($conex, "SELECT solicitud, distingue FROM stmdistd WHERE distingue LIKE '%íº%' OR distingue LIKE '%íƒÂº%'");
		//while ($fila = pg_fetch_row($recordset)){
		//	$sustitucion_a = preg_replace("/(íº|íƒÂº)/", "ú", $fila[1]);
		//	echo ($fila[0] . "--" . $sustitucion_a. "<br>");
		//	pg_query($conex, "UPDATE stmdistd SET distingue = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 
   	//}
		pg_close($conex); 
	}
?>
