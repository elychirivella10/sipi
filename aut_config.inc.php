<?
//  Autentificator
//  Gesti�n de Usuarios PHP+Mysql
//  by Pedro Noves V. (Cluster)
//  clus@hotpop.com
//  ------------------------------

// Configuraci�n

// Nombre de la session (puede dejar este mismo)
$usuarios_sesion="autentificator";

// Datos conexi�n a la Base de datos (MySql o PostgreSQL)
//$pg_host="localhost";	// Host, nombre del servidor o IP del servidor MySql o PostgreSQL.
//$pg_host="192.8.18.2";	// Host, nombre del servidor o IP del servidor MySql o PostgreSQL.
$pg_host="172.16.0.196";	// Host, nombre del servidor o IP del servidor MySql o PostgreSQL.
$pg_usuario="postgres";	// Usuario de Mysql o PostgreSQL
$pg_pass=""; 		// contrase�a de Mysql o PostgreSQL
$pg_db="bdrpi";     	// Base de datos que se usar�.
$pg_tabla="stzusuar";	// Nombre de la tabla que contendr� los datos de los usuarios
?>
