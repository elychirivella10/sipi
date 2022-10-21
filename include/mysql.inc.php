<?php
#######################################################################################
# Class Name : PHP-MySQL Class
# Author : Henry Chen
# Last Mofidy Date : 2003-05-03
# License : GPL
# Contact Info
# 	E-Mail : henryi@wowphp.net
# 	ICQ : 55490755
# 	AIM : wowphp
# 	YIM : henryi_chen@yahoo.com
#######################################################################################
# Function List
# 	1.connection	 -->	function connection()
# 	2.disconnect	 -->	function disconnect()
# 	3.insert		 -->	function insert($tb_name,$cols,$val,$astriction)
# 	4.update		 -->	function update($tb_name,$string,$astriction)
# 	5.delete		 -->	function del($tb_name,$astriction)
# 	6.query			 -->	function query($string)
# 	7.num_rows		 -->	function nums($string="",$qid="")
# 	8.object		 -->	function objects($string="",$qid="")
# 	9.insert_id		 -->	function insert_id($qid="")
# 	10.pagecut		 -->	function page_cut($string,$nowpage = "0")
# 	11.show_page_cut -->	function show_page_cut($string="",$num="",$url="")
#######################################################################################
# About this changing
#	1. Add error handling
#	2. Modifing the new code format
#	3. More useful page cut function
#	4. Add the function about getting the ID generated from the previous INSERT operation 
#######################################################################################
# Change Log
#--------------------
#  2002-07-24
#--------------------
# 1. Correct page_cut error. 
# 2. Improve the function nums and function objects these two functions. 
# 3. The new pgae_cut and show_page_cut functions can let you use these functions 
#    with your template 
#
########################################################################################

class mod_mysql_db{
	var $setting_file = "/var/www/apl/sipi/setting.mysql.php";
	var $sql_mylink;
	var $db_mylink;
	var $query_myid;
	var $perpage;
	var $total;
	var $pagecut_query;
	var $conn_mytype = "0"; // 0: mysql_connect ; 1: mysql_pconnect
	var $debug     = "0"; // If your code can't work well just change it to 1, you can see the sql string.

	function connection_mysql(){
		// Check if SQL is connect or not
		if(!$this->sql_mylink){
			// Define SQL Variables
			//echo "$this->db_myhost | $this->db_myname | $this->db_myuser | $this->db_mypass)";
			if(!$this->db_myhost || !$this->db_myname || !$this->db_myuser || !$this->db_mypass){
				include_once("$this->setting_file");
				global $sql_myhost,$sql_myname,$sql_myuser,$sql_mypass,$per_mypage;
					$this->db_myhost = $sql_myhost;
					$this->db_myname = $sql_myname;
					$this->db_myuser = $sql_myuser;
					$this->db_mypass = $sql_mypass;
				// Define other variables
					$this->perpage=$per_page1;
			}
			//echo " connection_mysql: $this->db_myhost $this->db_myname $this->db_myuser $this->db_mypass ";
			// SQL Connection
				if($this->conn_mytype == 0){
					$this->sql_mylink = mysql_connect($this->db_myhost,$this->db_myuser,$this->db_mypass);
				}elseif($this->conn_mytype == 1){
					$this->sql_mylink = mysql_pconnect($this->db_myhost,$this->db_myuser,$this->db_mypass);
				}
         //echo " sql conex= $this->sql_mylink ";
				if($this->debug == 1){
					echo "Connect to MySQL Server Success<br>ServerHost=$this->db_myhost<br>";
				}

				if(!$this->sql_mylink){
					echo "Connect to mysql Server Error";
				}


			// Select Database
			$this->db_mylink = mysql_select_db($this->db_myname,$this->sql_mylink);
			//echo " conexion= $this->db_mylink ";
			if($this->debug == 1){
				echo "Connect to MySQL DB:$this->db_myname Success<br>";
			}

			if(!$this->db_mylink){
				echo "Connect to DB Error , DBName = $this->db_myname";
			}

			return;
		}else{
			exit;
		}
	}

	function disconnect_mysql(){
		mysql_close($this->sql_mylink);
	}

	function insert_mysql($tb_name,$cols,$val,$astriction){
		if(empty($this->sql_mylink)){
			$this->connection_mysql();
		}

		// Check cols is empty or not
		if(!$cols){
			$cols = "";
		}elseif($cols != ""){
			$cols = "(".$cols.")";
		}

		// Check astriction is empty or not
		if(!$astriction){
			$ast = "";
		}elseif($astriction != ""){
			$ast = " WHERE ".$astriction;
		}

      echo " insert= $tb_name,$cols,$val $this->sql_mylink ";
		$insert = mysql_query("INSERT INTO $tb_name $cols VALUES($val) $ast",$this->sql_mylink);
			
		//	if($this->debug == 1){
		//		echo "Insert String = Insert into $tb_name $cols Values($val) $ast<br>";
		//		echo mysql_error();
		//	}

		//	if(!$insert){
				// echo "<script>alert('Insert Data Error');</script>"; // English Error Message
		//		echo "<script>alert('ERROR');</script>"; // Chinese Error Message
				
		//	}

			return;
	}

	function update_mysql($tb_name,$string,$astriction){
		if(empty($this->sql_mylink)){
			$this->connection_mysql();
		}

		// Check astriction is empty or not
		if(!$astriction){
			$ast = "";
		}elseif($astriction != ""){
			$ast = " WHERE ".$astriction;
		}
		$update = mysql_query("UPDATE $tb_name SET $string $ast",$this->sql_mylink);
		
		if($this->debug == 1){
			echo "Update String = Update $tb_name Set $string $ast<br>";
		}

		if(!$update){
			// echo "'<script>alert('Update Data Error');</script>"; // English Error Message
			echo "<script>alert('資料更新失敗');</script>"; // Chinese Error Message
			
		}
	}

	function del_mysql($tb_name,$astriction){
		if(empty($this->sql_mylink)){
			$this->connection_mysql();
		}

		// Check astriction is empty or not
		if(!$astriction){
			$ast = "";
		}elseif($astriction != ""){
			$ast = " WHERE ".$astriction;
		}
		$del = mysql_query("DELETE FROM $tb_name $ast",$this->sql_mylink);

		if($this->debug == 1){
			echo "Delete String = Delete From $tb_name $ast<br>";
		}

		if(!$del){
			// echo "<script>alert('Delete Data Error');</script>"; // English Error Message
			echo "<script>alert('資料刪除失敗');</script>"; // Chinese Error Message
			
		}
	}

	function query_mysql($string){
		if(empty($this->sql_mylink)){
			$this->connection_mysql();
		}
		$this->query_myid = mysql_query($string,$this->sql_mylink);

		if($this->debug == 1){
			echo "Query String = $string <br>";
		}

		//if(!$this->query_myid){
		//	// echo "<script>alert('Unable to Perform the query:$string');</script>"; // English Error Message
		//	echo "<script>alert('ERROR');</script>"; // Chinese Error Message
		//}
		
		return $this->query_myid;

	}

	function nums_mysql($string="",$qid=""){
		if($string != ""){
			$this->query_mysql($string);
			$this->total = mysql_num_rows($this->query_myid);
		}elseif($qid != ""){
			$this->total = mysql_num_rows($qid);
		}elseif(empty($sting) && empty($qid)){
			$this->total = mysql_num_rows($this->query_myid);
		}
		if($this->debug == 1){
			echo "Number = ".$this->total."<br>";
		}
		return $this->total;
	}

	function objects_mysql($string="",$qid=""){
		if($string != ""){
			$this->query_mysql($string);
			$objects = mysql_fetch_object($this->query_myid);
				if($this->debug == 1){
					echo "qid = ".$qid."<br>";
					echo "obj = ".$objects."<br><br>";
				}
		}elseif($qid != ""){
			$objects = mysql_fetch_object($qid);
				if($this->debug == 1){
					echo "qid = ".$qid."<br>";
					echo "obj = ".$objects."<br><br>";
				}
		}elseif(empty($string) && empty($qid)){
			$objects = mysql_fetch_object($this->query_myid);
				if($this->debug == 1){
					echo "qid = ".$qid."<br>";
					echo "obj = ".$objects."<br><br>";
				}
		}
		return $objects;
	}
	
	function insert_id_mysql($qid=""){
		if($qid){
			$insert_id = mysql_insert_id($qid);
		}elseif(!$qid){
			$insert_id = mysql_insert_id();
		}
		
		if($this->debug == 1){
			echo "Insert ID = ".$insert_id."<br>";
		}
		return $insert_id;
	}

	function page_cut_mysql($string,$nowpage = "0"){
		if(empty($this->sql_mylink)){
			$this->connection_mysql();
		}

			$query_str=$string;

		//Limit
		if(!$nowpage){
			$start = "0";
		}else{
			$start = ($nowpage-1)*$this->perpage;
		}
			$this->pagecut_query=$query_str." LIMIT $start,".$this->perpage."";
				if($this->debug == 1){
					echo"pagecut string=".$query_str." LIMIT $start,".$this->perpage."";
				}
		Return $this->pagecut_query;
	}

	function show_page_cut_mysql($string="",$num="",$url=""){
		global $nowpage;

		if($string){
			$this->nums_mysql($string,'');
			$pages = ceil($this->total / $this->perpage);
		}elseif($num){
			$this->total = $num;
			$pages = ceil($this->total / $this->perpage);
		}
		//echo "pages = ".$pages."<br>";

		###First Page###
		if(!$nowpage || $nowpage == "1"){
			$pagecut = "<font color = 'C0C0C0'>第一頁</font>";
		}else{
			$pagecut .=  "<a href='$PHP_SELF?".$url."&nowpage=1'>";
			$pagecut .=  "<font color = '#000066'style = 'font-size:12pt'>";
			$pagecut .=  "<<<第一頁</font>";
			$pagecut .=  "</a>";
		}
		$pagecut .=  "&nbsp;&nbsp;";

		###Previous Page###
		if(($nowpage-1) > 0){
			$prevpage = $nowpage-1;
			$pagecut .=  "<a href='$PHP_SELF?".$url."&nowpage=$prevpage'>";
			$pagecut .=  "<font color = '#336600' style = 'font-size:12pt'>";
			$pagecut .=  "<<前一頁</font>";
			$pagecut .=  "</a>";
		}else{
			$pagecut .=  "<font color = 'C0C0C0'>前一頁</font>";
		}
			$pagecut .=  "&nbsp;&nbsp;";

		###At which Page###
		if(!$nowpage){
			$i = "1";
		}else{
			$i = $nowpage;
		}
		$pagecut .=  "目前在第&nbsp;";
		$pagecut .=  $i;
		$pagecut .=  "&nbsp;頁<font color = '#663300'>/共&nbsp;".$pages."&nbsp;頁</font>";
		$pagecut .=  "&nbsp;&nbsp;";

		###Next Page###
		if(!$nowpage){$nowpage = '1';}
		if(($pages-$nowpage) > 0){
			$nextpage = $nowpage+1;
			$pagecut .=  "<a href='$PHP_SELF?".$url."&nowpage=$nextpage'>";
			$pagecut .=  "<font color = '336600'style = 'font-size:12pt'>";
			$pagecut .=  "下一頁>></font>";
			$pagecut .=  "</a>";
		}else{
			$pagecut .=  "<font color = 'C0C0C0'>下一頁</font>";
		}
			$pagecut .=  "&nbsp;&nbsp;";

		###Last Page###
		if($nowpage == $pages){
			$pagecut .=  "<font color = 'C0C0C0'>最後一頁</font>";
		}else{
			$pagecut .=  "<a href='$PHP_SELF?".$url."&nowpage=$pages'>";
			$pagecut .=  "<font color = '000066'style = 'font-size:12pt'>";
			$pagecut .=  "最後一頁>>></font>";
			$pagecut .=  "</a>";
		}
		Return $pagecut;
		}

}
?>