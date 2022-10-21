<?php
	
	// Creado por Pendulo Software - Anderson Guzman, como colaboracion en la correcion de transformacion de codigo de caracteres ISO8859-1 a UTF-8 en 
	// la migracion de la base de datos desde Informix a PostgreSQL
	// Caracas 04/09/2007
	
	set_time_limit(0);
	$cadena_conexion = "host=localhost port=5432 dbname=bdpi1 user=postgres";
	if(($conex = pg_connect($cadena_conexion)) == false){
		die ("Error en la conexion");
	}else{
		$recordset = pg_query($conex, "SELECT solicitud, nombre FROM stmmarce WHERE nombre LIKE '%¥%' OR nombre LIKE '%¶%'");
		while ($fila = pg_fetch_row($recordset)){
			$sustitucion_a = preg_replace("/(¶|¥)/", "Ñ", $fila[1]);
			echo ($fila[0] . "--" . $sustitucion_a. "<br>");
			pg_query($conex, "UPDATE stmmarce SET nombre = '" . addslashes($sustitucion_a) . "' WHERE solicitud = '" . $fila[0] . "'"); 
		
		}
		pg_close($conex);
	}
?>