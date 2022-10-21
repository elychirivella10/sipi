<?php
function conectar_db()
{
   $db = pg_connect("dbname=bdrpi host=localhost user=postgres  password=postgres");
   return $db;	 
}

?>
