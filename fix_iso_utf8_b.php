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
		//$recordset = pg_query($conex, "SELECT solicitud, distingue FROM stmdistd WHERE distingue LIKE '%á%' OR distingue LIKE '%�%'");
		//while ($fila = pg_fetch_row($recordset)){
		//	$sustitucion_a = preg_replace("/(á|�)/", "�", $fila[1]);
		//	echo ($fila[0] . "--" . $sustitucion_a. "<br>");
		//	pg_query($conex, "UPDATE stmdistd SET distingue = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 
   	//}
		//$recordset = pg_query($conex, "SELECT solicitud, distingue FROM stmdistd WHERE distingue LIKE '%�%'");
		//while ($fila = pg_fetch_row($recordset)){
		//	$sustitucion_a = preg_replace("/(�|Ã©)/", "�", $fila[1]);
		//	echo ($fila[0] . "--" . $sustitucion_a. "<br>");
		//	pg_query($conex, "UPDATE stmdistd SET distingue = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 
   	//}
		$recordset = pg_query($conex, "SELECT solicitud, distingue FROM stmdistd WHERE distingue LIKE '%�%' OR distingue LIKE '%Ã�%'");
		while ($fila = pg_fetch_row($recordset)){
			$sustitucion_a = preg_replace("/(�|Ã�)/", "�", $fila[1]);
			echo ($fila[0] . "--" . $sustitucion_a. "<br>");
			pg_query($conex, "UPDATE stmdistd SET distingue = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 
   	}
		//$recordset = pg_query($conex, "SELECT solicitud, distingue FROM stmdistd WHERE distingue LIKE '%ó%' OR distingue LIKE '%Ã³%'");		//while ($fila = pg_fetch_row($recordset)){		//	$sustitucion_a = preg_replace("/(ó|Ã³)/", "�", $fila[1]);		//	echo ($fila[0] . "--" . $sustitucion_a. "<br>");		//	pg_query($conex, "UPDATE stmdistd SET distingue = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 		//}
		//$recordset = pg_query($conex, "SELECT solicitud, distingue FROM stmdistd WHERE distingue LIKE '%�%' OR distingue LIKE '%�º%'");
		//while ($fila = pg_fetch_row($recordset)){
		//	$sustitucion_a = preg_replace("/(�|�º)/", "�", $fila[1]);
		//	echo ($fila[0] . "--" . $sustitucion_a. "<br>");
		//	pg_query($conex, "UPDATE stmdistd SET distingue = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 
   	//}
		pg_close($conex); 
	}
?>
