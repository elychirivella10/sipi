<?php
/* This script is setting all vars */

$root_path    = "/var/www/apl/sipi";
$include_path = "$root_path/include";

##### Setting SQL Type #####
$sqltype2 = "1"; // 1 --> MySQL ; 2 --> MSSQL ; 3 --> PostgreSQL 

 if($sqltype2 == "1"){
  include ("$include_path/mysql.inc.php");
 }elseif($sqltype2 == "2"){
  include ("$include_lib/mssql.inc.php");
 }elseif($sqltype2 == "3"){
  include_once ("$include_path/pgsql.inc.php");
 }

##### Setting SQL Vars #####

$sql_myhost = "172.16.0.196";
$sql_myname = "sisfac2";
$sql_myuser = "root";
$sql_mypass = "s4p1";
$sql_mytabla= "";
?>
