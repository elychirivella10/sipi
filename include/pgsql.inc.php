<?php
/********************************************************************************************
# Class Name : PHP-MySQL Class
# Author : Henry Chen
# Last Mofidy Date : 2003-05-03
# License : GPL
# Contact Info
# 	E-Mail : henryi@wowphp.net
# 	ICQ : 55490755
# 	AIM : wowphp
# 	YIM : henryi_chen@yahoo.com
############################################################################################
*
*	Script Name	: PHP-PostgreSQL
*	Date 		: 2002-10-18 1300(GMT+8)
*	Author		: Henryi <henryi@wowphp.net>
*
*-------------------------------------------------------------------------------------------
*	Function Lists
*-------------------------------------------------------------------------------------------
* 	1. connection		-->	Function connection()
* 	2. query		-->	Function query($string)
* 	3. num_rows		-->	Function nums($string="",$qid="")
* 	4. object		-->	Function objects($string="",$qid="")
* 	5. insert		-->	Function insert($tb_name,$cols,$val,$astriction)
* 	6. update		-->	Function update($tb_name,$string,$astriction)
* 	7. delete		-->	Function del($tb_name,$astriction)
*	8. numscols		-->	Function numscols($string="",$qid="")
*------------------------------------------------------------------------------------------
*	Extra Announce
*------------------------------------------------------------------------------------------
*	You can add this script to PHP-MYSQL-MSSQL class
*	(you can find it at http://www.phpclasses.org/browse.html/package/657.html)
*	to make those classes more useful , all you have to do just edit setting.inc.php
*	add follow lines
*
*==============================================
*	elseif($sql_type == "3"){
*		include_once("pgsql.inc.php");
*	}
*==============================================
*
*-----------------------------------------------------------------------------------------
*	CopyLeft
*-----------------------------------------------------------------------------------------
*	Protected by GPL .... :P
*
*-----------------------------------------------------------------------------------------
*	Modificado por Ing. Romulo Mendoza  / Año 2005 y 2009  - Caracas-Venezuela.
*-----------------------------------------------------------------------------------------
******************************************************************************************/

	class mod_db{
	  //var $setting_file = "/var/www/sistemas/setting.inc.php";
	  var $setting_file = "/var/www/apl/sipi/setting.inc.php";
	  var $sql_link;
	  var $query_id;
	  var $sql_link1; 
	  var $query_id1;

/******* Setting & Connect ************************************/

   // Modificacion 2009: pase de usuarios .... 
	function connection($db_user='postgres') { 
	//	Check Connection is exist or not

     include("$this->setting_file");
	  global $sql_host,$sql_name,$sql_user,$sql_pass,$per_page;
    
	  if(!$this->sql_link){
	  //	Define All Variables
		$this->db_host = $sql_host;
		$this->db_user = $db_user;
		$this->db_pass = $sql_pass;
		$this->db_name = $sql_name;

	   //if(!$this->db_host || !$this->db_user || !$this->db_pass) {
		//include("$this->setting_file");
		//global $sql_host,$sql_name,$sql_user,$sql_pass,$per_page;
		
		//$this->db_host = $sql_host;
		//$this->db_user = $sql_user;
		//$this->db_pass = $sql_pass;
		//$this->db_name = $sql_name;
	  	
		// Connect to PostgreSQL
		$conn_string = "host=$this->db_host dbname=$this->db_name user=$this->db_user password=$this->db_pass";
		$this->sql_link = pg_connect ($conn_string);
		if(!$this->sql_link){
		  echo "ERROR: Fallo en la Conexión a PostgreSQL ... <br>\n"; }
		//elseif($this->sql_link){
		// echo "Conexión a PostgreSQL Satisfactoria, Host =$this->db_host, DB =$this->db_name, User =$this->db_user, Pass =$this->db_pass <br>\n";
		//}
	   //}
	  }
	}

	function connection1($db_user1='postgres') { 
	//	Check Connection is exist or not

     include("$this->setting_file");
	  global $sql_host,$sql1_name,$sql1_user,$sql1_pass,$per_page;
    
	  if(!$this->sql_link1){
	  //	Define All Variables
		$this->db_host1 = $sql_host;  
		$this->db_user1 = $db_user1;
		$this->db_pass1 = $sql1_pass;
		$this->db_name1 = $sql1_name;

	   //if(!$this->db_host || !$this->db_user || !$this->db_pass) {
		//include("$this->setting_file");
		//global $sql_host,$sql_name,$sql_user,$sql_pass,$per_page;
		
		//$this->db_host = $sql_host;
		//$this->db_user = $sql_user;
		//$this->db_pass = $sql_pass;
		//$this->db_name = $sql_name;
	  	
		// Connect to PostgreSQL
		$conn_string1 = "host=$this->db_host1 dbname=$this->db_name1 user=$this->db_user1 password=$this->db_pass1";
		$this->sql_link1 = pg_connect ($conn_string1);
		if(!$this->sql_link1){
		  echo "ERROR: Fallo en la Conexión a PostgreSQL ... <br>\n"; }
		//elseif($this->sql_link){
		// echo "Conexión a PostgreSQL Satisfactoria, Host =$this->db_host, DB =$this->db_name, User =$this->db_user, Pass =$this->db_pass <br>\n";
		//}
	   //}
	  }
	}

/******* Disconnect ************************************/

	function disconnect(){
		pg_close($this->sql_link);
	}

	function disconnect1(){
		pg_close($this->sql_link1);
	}

/******* Query ************************************/

	function query($query_str){
		if(empty($sql_link)){
			$this->connection();
		}
		$this->query_id = pg_exec("$query_str");
		// Testing 
		//	echo "query_id = ".$this->query_id."<br>\n";
		//	echo "query_str = ".$query_str."<br>\n";
		if(!$this->query_id){
			echo "Imposible de ejecutar la consulta :".$string."<br>\n";
		}
		return $this->query_id;
	}

	function query1($query_str){ 
		if(empty($sql_link1)){
			$this->connection1();
		}
		$this->query_id1 = pg_exec("$query_str"); 
		// Testing 
		//	echo "query_id = ".$this->query_id."<br>\n";
		//	echo "query_str = ".$query_str."<br>\n";
		if(!$this->query_id1){
			echo "Imposible de ejecutar la consulta :".$string."<br>\n";
		}
		return $this->query_id1;
	}

/******* Num ************************************/

	function nums($string="",$qid=""){
		if(empty($sql_link)){
			$this->connection();
		}
		// String is not empty but qid is empty
			if(!empty($string)){
				$this->query($string);
				$this->total_num = pg_num_rows($this->query_id);
				//Testing 
				//echo "Num Query String = ".$string."<br>\n";
				///echo "Num_1 = ".$this->total_num."<br>\n";
			}
       	        // String is empty but qid is not empty
			if(!empty($qid)){
				$this->total_num = pg_num_rows($qid);
				//Testing
				//echo "Num_2 = ".$this->total_num."<br>\n";
			}
		// String and qid are both empty
			if(empty($string) && empty($qid)){
				$this->total_num = pg_num_rows($this->query_id);
				//Testing
				//echo "Num_3 = ".$this->total_num."<br>\n";
			}
		return $this->total_num;
	}

	function nums1($string="",$qid=""){
		if(empty($sql_link1)){
			$this->connection1(); 
		}
		// String is not empty but qid is empty
			if(!empty($string)){
				$this->query1($string);
				$this->total_num1 = pg_num_rows($this->query_id1);
				//Testing 
				//echo "Num Query String = ".$string."<br>\n";
				///echo "Num_1 = ".$this->total_num."<br>\n";
			}
       	        // String is empty but qid is not empty
			if(!empty($qid)){
				$this->total_num1 = pg_num_rows($qid); 
				//Testing
				//echo "Num_2 = ".$this->total_num."<br>\n";
			}
		// String and qid are both empty
			if(empty($string) && empty($qid)){
				$this->total_num1 = pg_num_rows($this->query_id1); 
				//Testing
				//echo "Num_3 = ".$this->total_num."<br>\n";
			}
		return $this->total_num1;
	}

/******* TotalColumnas - numscols ************************************/
/* 15/04/2010 
 * Me devuelve el número de columnas de un query
 * Ing.Maryury Bonilla
 * maryurybonilla20@gmail.com
 * */

	function numscols($string="",$qid=""){
		if(empty($sql_link)){
			$this->connection();
		}
		// String is not empty but qid is empty
			if(!empty($string)){
				$this->query($string);
				$this->total_num = pg_numfields($this->query_id);
				//Testing 
				//echo "Num Query String = ".$string."<br>\n";
				///echo "Num_1 = ".$this->total_num."<br>\n";
			}
       	        // String is empty but qid is not empty
			if(!empty($qid)){
				$this->total_num = pg_numfields($qid);
				//Testing
				//echo "Num_2 = ".$this->total_num."<br>\n";
			}
		// String and qid are both empty
			if(empty($string) && empty($qid)){
				$this->total_num = pg_numfields($this->query_id);
				//Testing
				//echo "Num_3 = ".$this->total_num."<br>\n";
			}
		return $this->total_num;
	}
	
	function numscols1($string="",$qid=""){
		if(empty($sql_link1)){ 
			$this->connection1();
		}
		// String is not empty but qid is empty
			if(!empty($string)){
				$this->query1($string);
				$this->total_num1 = pg_numfields($this->query_id1); 
				//Testing 
				//echo "Num Query String = ".$string."<br>\n";
				///echo "Num_1 = ".$this->total_num."<br>\n";
			}
       	        // String is empty but qid is not empty
			if(!empty($qid)){
				$this->total_num1 = pg_numfields($qid); 
				//Testing
				//echo "Num_2 = ".$this->total_num."<br>\n";
			}
		// String and qid are both empty
			if(empty($string) && empty($qid)){
				$this->total_num1 = pg_numfields($this->query_id1); 
				//Testing
				//echo "Num_3 = ".$this->total_num."<br>\n";
			}
		return $this->total_num1;
	}
	
/******* Object ************************************/

	function objects($string="",$qid=""){
		if(empty($sql_link)){
			$this->connection();
		}
		//String is not empty but qid is empty
			if(!empty($string)){
				$this->query($string);
				$objects = pg_fetch_object($this->query_id);
				//Testing
				echo "Object Query String = ".$string."<br>\n";
			}
		//String is empty but qid is not empty
			if(!empty($qid)){
				$objects = pg_fetch_object($qid);
			}
		//String and qid are both empty
			if(empty($string) && empty($qid)){
				$objects = pg_fetch_object($this->query_id);
			}
		return $objects;
	}

	function objects1($string="",$qid=""){
		if(empty($sql_link1)){ 
			$this->connection1();
		}
		//String is not empty but qid is empty
			if(!empty($string)){
				$this->query1($string);
				$objects1 = pg_fetch_object($this->query_id1); 
				//Testing
				echo "Object Query String = ".$string."<br>\n";
			}
		//String is empty but qid is not empty
			if(!empty($qid)){
				$objects1 = pg_fetch_object($qid); 
			}
		//String and qid are both empty
			if(empty($string) && empty($qid)){
				$objects1 = pg_fetch_object($this->query_id1);
			}
		return $objects1; 
	}

/******* Insert ************************************/

	function insert($tb_name,$cols,$val,$astriction){
		if(empty($this->sql_link)){
			$this->connection();
		}
		//Check Cols is empty or not
			if(!$cols){
				$cols = "";
			}else{
				$cols = "(".$cols.")";
			}
		//Check astriction is empty or not
			if(!$astriction){
				$ast = "";
			}else{
				$ast = " WHERE ".$astriction;
			}

		$insert = pg_exec($this->sql_link,"INSERT INTO $tb_name $cols VALUES ($val) $ast");
		if(!$insert) {
		   $error = pg_last_error($this->sql_link);
		   echo "<br>Falla de Ingreso de Datos en la Base de Datos : <br>";
			echo " String = INSERT INTO $tb_name $cols VALUES ($val) $ast<br>";
			echo " analizar el mensaje de error: <ul>$error</ul>"; } 
		return $insert;
	}

	function insert1($tb_name,$cols,$val,$astriction){
		if(empty($this->sql_link1)){ 
			$this->connection1();
		}
		//Check Cols is empty or not
			if(!$cols){
				$cols = "";
			}else{
				$cols = "(".$cols.")";
			}
		//Check astriction is empty or not
			if(!$astriction){
				$ast = "";
			}else{
				$ast = " WHERE ".$astriction;
			}

		$insert1 = pg_exec($this->sql_link1,"INSERT INTO $tb_name $cols VALUES ($val) $ast"); 
		if(!$insert1) {
		   $error = pg_last_error($this->sql_link1);
		   echo "<br>Falla de Ingreso de Datos en la Base de Datos : <br>";
			echo " String = INSERT INTO $tb_name $cols VALUES ($val) $ast<br>";
			echo " analizar el mensaje de error: <ul>$error</ul>"; } 
		return $insert1; 
	}

/******* Update ************************************/

	function update($tb_name,$string,$astriction){
		if(empty($this->sql_link)){
			$this->connection();
		}
		//Check astriction is empty or not
			if(!$astriction){
				$ast = "";
			}else{
				$ast = " WHERE ".$astriction;
			}
//		echo "UPDATE $tb_name SET $string $ast<hr>";
		$update = pg_exec($this->sql_link,"UPDATE $tb_name SET $string $ast");
		//if(!$update){
		//   $error = pg_last_error($this->sql_link);
		//   echo "<br>Falla de Actualización de Datos en la Base de Datos : <br>";
		//	echo " String = UPDATE $tb_name SET $string $ast<br>";
		//	echo " analizar el mensaje de error: <ul>$error</ul>";  }
		return $update;
	}

	function update1($tb_name,$string,$astriction){
		if(empty($this->sql_link1)){ 
			$this->connection1();
		}
		//Check astriction is empty or not
			if(!$astriction){
				$ast = "";
			}else{
				$ast = " WHERE ".$astriction;
			}
//		echo "UPDATE $tb_name SET $string $ast<hr>";
		$update1 = pg_exec($this->sql_link1,"UPDATE $tb_name SET $string $ast"); 
		//if(!$update){
		//   $error = pg_last_error($this->sql_link);
		//   echo "<br>Falla de Actualización de Datos en la Base de Datos : <br>";
		//	echo " String = UPDATE $tb_name SET $string $ast<br>";
		//	echo " analizar el mensaje de error: <ul>$error</ul>";  }
		return $update1; 
	}

/******* Delete ************************************/

	function Del($tb_name,$astriction){
		if(empty($this->sql_link)){
			$this->connection();
		}
		//Check astriction is empty or not
			if(!$astriction){
				$ast = "";
			}else{
				$ast = " WHERE ".$astriction;
			}
      //echo "en clase= $tb_name $ast ";
		$del = pg_exec($this->sql_link,"DELETE FROM $tb_name $ast");
		//if(!$del){
		//   $error = pg_last_error($this->sql_link);
		//   echo "<br>Falla en la Eliminación de Datos en la Base de Datos : <br>";
		//	echo " String = DELETE FROM $tb_name $ast<br>";
		//	echo " analizar el mensaje de error: <ul>$error</ul>";  }
		return $del;
	}

	function Del1($tb_name,$astriction){
		if(empty($this->sql_link1)){
			$this->connection1();  
		}
		//Check astriction is empty or not
			if(!$astriction){
				$ast = "";
			}else{
				$ast = " WHERE ".$astriction;
			}
      //echo "en clase= $tb_name $ast ";
		$del1 = pg_exec($this->sql_link1,"DELETE FROM $tb_name $ast"); 
		//if(!$del){
		//   $error = pg_last_error($this->sql_link);
		//   echo "<br>Falla en la Eliminación de Datos en la Base de Datos : <br>";
		//	echo " String = DELETE FROM $tb_name $ast<br>";
		//	echo " analizar el mensaje de error: <ul>$error</ul>";  }
		return $del1; 
	}

}
?>
