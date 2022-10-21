<?php
/* BrowseEdit Class - ver 3.01
* copyright Peter Rosomoff, Chesterfield MO 2003-4 All rights reserved pr@thinktrain.com 
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.

* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

* You must include the above if you are reusing this code 
*/

/*
*	Basic class that displays browse style editable table contents (like a browse window in MS Access)
*  Features:
*		Columns have headers that allow sort order to be changed by clicking on them
*		Display may be editable or read only
*		Display has "select" mode or full edit mode (change, delete, insert) 
*     SelectBox (drop down list) 
*     Hidden columns
*     
*     Editable title bar allowing any html
*
*	Table must have at least one field and a field that contains an unique identifier (UID)
*	(typically auto-incremented field)
*	Class assumes that connection to database has already been made (see helper scripts)
*	Class uses doQuery($sql) function that processes $sql (can be substituted)
*/

/*Updates and fixes
* 04/04/2004 fixed register globals bugs
* 04/05/2004 added ascending-descending column toggle
* 04/05/2004 change fmod to simple toggle 
* 04/10/2004 added aliases for column headers
* 04/10/2004 added ability to validate data via javascript 
* 04/21/2004 added ability to define table color and rowcolors (Originally contribute by Tanghe ivan, edited by Rosomoff)
* 04/22/2004 added paging for large databases (Originally contributed by Tanghe ivan, adapted by Rosomoff)
* 05/01/2004 added line numbers
* 05/04/2004 fixed bugs in explicit sql update, add, delete functions
* 05/18/2004 fix bug in class = LIMIT clause offset was not set to 0 for first page display
* 05/31/2004 fixed bug in update function so that placement of set_pagingOn is no longer relevant
* 05/31/2004 added feature set_actionColumn
* 11/25/2004 fixed sorting functions, added GIF pointers
* 12/07/2004 fixed Alt on headers and header width for 'nowrap'
* fix bug in update function for non-numeric UID
* 12/15/2004 Rev 2.0 
	fix bug in sorting, added arrows for sort direction, added radio button option, added select action for radio or checkbox, added select column rename, added date/datetime column for MySQL date, added textarea type, DELETE function now requires argument ($_REQUEST['selRecord'] will work for default behavior, added select radio button or checkbox javascript action.
* 12/21/2004 Rev 2.01
	fixed bug in DateTime column, fixed example database schema
* 12/21/2004 Rev 2.02 fixed bug for using radio button select as delete function or UID enable function
* 12/30/2004 fixed typo on line 663 "this->fontsize"
* 01/30/2005 Rev 3.0 complete re-architecture of column type designation and parameters
* 2/7/2005 fixed bug in alias line 623
* 2/17/2005 update to conform to XHTML standards
*/

class BrowseEdit {
	
	var $table;   //subject table
	var $idField;  //UID of table
	var $sortOrder;  //sortOrder
	var $fontSize="8"; //fontsize 
	var $selectBox; //selectbox array (DEPRICATED)
	var $textarea; //textbox array  (DEPRICATED)
	var $textcols; //textbox # cols array (DEPRICATED)
	var $textrows; //textbox # rows array (DEPRICATED)
	var $result; //sql resutl
	var $hideColumn; //hide this column array (DEPRICATED)
	var $sql; //sql statement
	var $enabled=''; //editable field
	var $title='TITULARES SELECCIONADOS'; //table title
	var $formName=''; //form name
	var $selectForm=FALSE; //editable or select form (DEPRICATED)
	var $footer;  //footer of table
	var $showtable="";  //additional formatting for table
	var $recsPerPage="20"; //default value of records per page (paging on)
	var $maxPageShow="5"; //default value of page links to show (paging on)
	var $paging=0; // paging on/off
	var $sqlfull; //sql statement
	var $bgcolor="#FFFFFF"; //table background color
	var $selectAction=""; //javascript action when select button is clicked
	var $radioButton=FALSE; //radio buttons instead of checkbox for select
	var $fontFamily="verdana"; //font family
	var $selColumnName=""; //select column header text
	var $defaultColType="text";
	var $columnType=array();
	var $selectedRow=-1;
	var $arrowPath=array('ASC'=>'','DESC'=>'');
	var $charCode="ISO-8859-1";

	/* 
	*	Class constructor
	*		$ptable = Name of the table
	*		$pidField = Field name of unique identifier
	*		$psql = SQL Statement to use instead of "select * from $ptable ... etc"(optionAL)
	*					do not include an "ORDER BY" in the sql statement.  This is set by the set_sortOrder function
	*		$form = Form name for this instance
	*/
	function BrowseEdit($ptable,$pidField,$psql="",$form="mainForm"){
		// initialize all required variables
		$this->formName=$form;  //for distinguishing multiple form displays,
		$this->table=$ptable; //sets the table name
		$this->idField=$pidField; // sets the UID field
		$this->title="$ptable"; //sets the display title of the page
		$this->sql=$psql;
		$this->sqlfull=$psql;		
		$this->sortOrder=$pidField." DESC";
		$this->footer="";
		$this->selActionField=$pidField;
	}

	/***********************************
	display scope functions
	************************************/

	// set sortorder
	function set_sortOrder($so){
		$this->sortOrder=$so;
	}

	// set title of display page  (you can put any HTML here)
	function set_title($t){
		$this->title=$t;
	}
	
	// set footer of display table (inserts HTML between end of table and end of form tags)
	function set_footer($f){
		$this->footer=$f;
	}

	//set Paging function on
	function set_pagingOn(){
		$this->paging=1;
	}
	
	//set max pages shown in footer  (paging must be on)
	function set_maxPageShow($max){
		$this->maxPageShow=$max;
	}

	//set max records to show per page (paging must be on)
	function set_recsPerPage($recs){
		$this->recsPerPage=$recs;
	}
	
	// set line counter
	function set_counter(){
		$this->counter=1;
	}

	//set widths of columns 
	function set_width($width){   //$width is an array with key = column, value=width
		$this->width=$width;
	}

	//set up as a select form  (non-editable, for selecting row for other purposes -- see example scripts)(DEPRICATED)
	function set_selectForm(){ 
		$this->selectForm=TRUE;
		//$this->enabled="readonly"; //new
	}


	// set form to display only - no editing
	function set_displayOnly(){
		$this->enabled="readonly";
	}
	
	//pselect should be the UID of the row you want to appear selected (NEW for 3.0)
	function set_selectedRow($pselect){
		$this->selectedRow=$pselect;
	}
	

	
	/*set the character code in htmlentities - defaults to ISO-8859-1
	Charset Aliases Description 
	ISO-8859-1 ISO8859-1 Western European, Latin-1  
	ISO-8859-15 ISO8859-15 Western European, Latin-9. Adds the Euro sign, French and Finnish letters missing in Latin-1(ISO-8859-1).  
	UTF-8   ASCII compatible multi-byte 8-bit Unicode.  
	cp866 ibm866, 866 DOS-specific Cyrillic charset. This charset is supported in 4.3.2.  
	cp1251 Windows-1251, win-1251, 1251 Windows-specific Cyrillic charset. This charset is supported in 4.3.2.  
	cp1252 Windows-1252, 1252 Windows specific charset for Western European.  
	KOI8-R koi8-ru, koi8r Russian. This charset is supported in 4.3.2.  
	BIG5 950 Traditional Chinese, mainly used in Taiwan.  
	GB2312 936 Simplified Chinese, national standard character set.  
	BIG5-HKSCS   Big5 with Hong Kong extensions, Traditional Chinese.  
	Shift_JIS SJIS, 932 Japanese  
	EUC-JP EUCJP Japanese  
	*/

	function set_charCode($code){
		$this->charCode=$code;
	}
	
	
	/**************************************
	column scope functions
	***************************************/

	/*set array of column types  (NEW for 3.0)

		IF THE FOLLOWING FUNCTION IS NOT CALLED, DEFAULT TYPE WILL BE TEXT OR CAN BE DEFINED WITH set_defaultType(). Version2 functions such as set_selectBox() can still be used but are depricated.  
		Column display order will default to MySQL table structure.  PLEASE READ BELOW AND README FILE CAREFULLY.

	    This function utilizes an array as its only pararmeter.  The array contains all of the necessary information to type and supply parameters for all columns in the display including action, function, etc.  The structure is as follows:

		*** 1st index of the array is the fieldname from MySQL table or a name for an action or function column ***
		$parray['fieldName']  

		*** 2nd indices are the type and other parameters for the column ***

		*** SEQUENCE  - display sequence left to right of columns.  0 is leftmost, 0<sequence<10000.  Default is MySQL table structure and specified columns will appear to the left of non-specified columns ***
		$parray['fieldName']['sequence'] 
		
		*** TYPE - sets the type of column, defaults to text or can be set to hidden or checkbox with set_defaultType()***
		$parray['fieldName']['type'] 
							
					type=	hidden
							date
							dateTime
							selectBox
							action
							textarea
							function
							text
							checkbox
						
		*** WIDTH - sets the column width						
		$parray['fieldName']['width'] 

		*** ALIAS - sets an alias for column header display
		$parray['fieldName']['alias'] 

		*** VALIDATION - supplies a mechanism for validation via javascript. Row values can be inserted by enclosing field names with '#' (#email#) ***
		$parray['fieldName']['validate'] 

		*** SELECTBOX VALUES - array of key/value pairs where key will be posted and value will be displayed
		$parray['fieldName']['selectValues'] 

		*** TEXTAREA PARAMETERS - sets columns and row sizes for a text area type - default is 25 columns and 3 rows ***
		$parray['fieldName']['textareaCols'] //columns for textarea type
		$parray['fieldName']['textareaRows'] //rows for textarea type

		*** DATE AND DATETIME PARAMETERS - sets starting year, ending year, starting hour, ending hour for date and datetime types ***
		$parray['fieldName']['startYear'] //date time column starting year
		$parray['fieldName']['endYear']   //date time column ending year	
		$parray['fieldName']['startHour'] //date time column starting hour
		$parray['fieldName']['endHour']   //date time column ending hour

		*** ACTION - sets text for an action column, such as a button with javascript or a hyperlink.  Row values can be inserted by enclosing field names with '#' (#email#) ***
		$parray['fieldName']['actionText'] 

		*** FUNCTION - sets text for a function column, where the return of the function will be displayed. ***
		$parray['fieldName']['functionName'] //user defiend function name
		$parray['fieldName'}{'functionParam'] //comma separated list of row data for use in user defined function

		*** DYNAMIC SELECTBOX - provides a method for dynamically creating selectbox values with an sql statement.  This column is NOT EDITABLE. Result of sql query must be the key and value pair for the selectbox.  Row values can be inserted by enclosing field names with '#' (#email#) ***
		$parray['fieldName']['dynamicSelect'] 

		*** readonly BY COLUMN - sets column to readonly or disabled when equal to 0.
		$parray['fieldName']['enabled'] 
		
*/

	function set_columnType($parray){
		$this->columnType=$parray;
	}


	//set the default column type (normally hidden)(only hidden, text, checkbox, textarea can be used as a default)

	function set_defaultColType($ptype){
		if (strpos("hidden,text,checkbox,textarea",$ptype)){
			$this->defaultColType=$ptype;
		}
	}
	

	//sets column header for select column
	function set_selColumnName($pname){
		$this->selColumnName=$pname;
	}
	
	//sets select column to a radio button instead of default checkbox
	function set_radioButton(){
		$this->radioButton=TRUE;
	}

	//set javascript action for select radio buttion or select checkbox  (enclose row values with '#' (#email#)
	function set_selectAction($paction){  
		$this->selectAction=$paction;
	}




	/************************************
	The following functions are found in the sel_columnType function and are depricated 
	*************************************/

	// set alias for field names (DEPRICATED)
	function set_fieldAs($pfield,$palias){
		$this->columnType[$pfield]['alias']=$palias;
	}

	// sets column as a MySQL date column with Year,Month,Day selectboxes and formatting for MySQL DATETIME type (DEPRICATED)
	function set_dateColumn($pfield,$pstartYear=2000,$pendYear=2025){
		$this->columnType[$pfield]['type']='date';
		$this->columnType[$pfield]['startYear']=$pstartYear;
		$this->columnType[$pfield]['endYear']=$pendYear;
	}
	
	// sets column as a MySQL datetime column with Year,Month,Day, Hour, min selectboxes and formatting for MySQL DATETIME type(DEPRICATED)
	function set_dateTimeColumn($pfield,$pstartYear=2000,$pendYear=2025){
		$this->columnType[$pfield]['type']='dateTime';
		$this->columnType[$pfield]['startYear']=$pstartYear;
		$this->columnType[$pfield]['endYear']=$pendYear;
	}

	//set actioncolumn
	//parameter is array with columnName, text 
	//appropriate text will replace UIDNAME and UIDVALUE
	// BE CAREFUL - substitution of this text in the display is verbatim and can have bizarre effects (DEPRICATED)
	function set_actionColumn($actionColumn){
		$repltext="#".$this->idField."#";
		while (list($kk,$vv)=each($actionColumn)){
			$actionColumnText=str_replace("UIDVALUE",$repltext,$vv);
			$actionColumnText=str_replace("UIDNAME",$this->idField,$actionColumnText);
			$this->columnType[$kk]['type']='action';
			$this->columnType[$kk]['actionText']=$actionColumnText;
		}
	}

	//sets field data substitiution for selectAction  (to capture row data into the javascript)(ELIMINATED - enclose row values with '#' (#email#) in the selectAction statement)
	function set_selActionFields($pfieldarray){  
		$this->selActionFields=$pfieldarray;
	}


	// set column to not display (DEPRICATED)
	function set_hideColumn($pfield){
		$this->columnType[$pfield]['type']='hidden';
	}

	// set a field to a select box. The submitted array $selList values will be displayed and keys will be posted (DEPRICATED)
	function set_selectBox($pfield,$selList){
		$this->columnType[$pfield]['type']='selectBox';
		$this->columnType[$pfield]['selectValues']=$selList;
	}

	//set a field to a checkbox  (data will be stored as "on" or "")(DEPRICATED)
	function set_checkBox($pfield){
		$this->columnType[$pfield]['type']='checkbox';
	}

	function set_size($pfield,$vsize){
		$this->columnType[$pfield]['size']=$vsize;
	}

	//set a field for textarea, columns and rows (DEPRICATED)
	function set_textarea($pfield,$cols=25,$rows=3){
		$this->columnType[$pfield]['type']='textarea';
		$this->columnType[$pfield]['textareaCols']=$cols;
		$this->columnType[$pfield]['textareaRows']=$rows;
	}

	//set javascript validation per field.  Javascript functions must be set up in calling HTML page(DEPRICATED)
	function set_validate($pfield,$func){
		$this->columnType[$pfield]['validate']=$func;
	}


	
	
	
	/*******************************
	formatting functions
	********************************/
	
	//set table formatting information
	function set_showtable($showtable){
		$this->showtable=$showtable;
	}
	
	//set alternating row colors
	function set_rowcolor($rowcolor1,$rowcolor2){
		$this->rowcolor1=$rowcolor1;
		$this->rowcolor2=$rowcolor2;
	}

	//set bgcolor for table
	function set_bgcolor($color){
		$this->bgcolor=$color;
	}
	
	
	// set font size
	function set_fontSize($pfontSize){
		$this->fontSize=$pfontSize;
	}
	// set header font family
	function set_fontFamily($pfontFamily){
		$this->fontFamily=$pfontFamily;
	}

	//set path to arrow images (array has two members 'ASC' and 'DESC')
	function set_arrowPath($parray){
		$this->arrowPath=$parray;
	}


	/*********************************
	Utility functions
	**********************************/



	//calculate and display paging links
	function showpagelinks($srecord){
		if (empty($this->sqlfull)){
			$this->sqlfull="SELECT ". $this->idField." FROM $this->table";
		} 		
		$numTotalRecs = pg_numrows($this->doQuery($this->sqlfull)); 
		$numPages = ceil($numTotalRecs / $this->recsPerPage);
		$numGroups = ceil($numPages/$this->maxPageShow);
		$page=ceil(($srecord+1)/$this->recsPerPage);  
		$pageGroup=ceil($page/$this->maxPageShow);
		$prevPageGroupStart=(1+($pageGroup-2)*$this->maxPageShow)*$this->recsPerPage;
		$prevPageGroupStart=$prevPageGroupStart<0?0:$prevPageGroupStart;
		$nextPageGroupStart=$pageGroup*$this->maxPageShow*$this->recsPerPage;
		$nextPageGroupStart=$nextPageGroupStart>$numTotalRecs?$numTotalRecs:$nextPageGroupStart;
		$startPageLink=1+($pageGroup-1)*$this->maxPageShow;
		$lastPageStart=($numPages-1)*$this->recsPerPage;
		$fsize=$this->fontSize;
		$nav ="<p><table border='0' align='center' style='font-family:verdana;font-size=$fsize'>\n";
		$nav.="<tr><td align='center'>Page : $page of $numPages</td></tr></table>\n";
		$nav.="<table border='0' align='center' style='color:blue;font-family:verdana;font-size=$fsize;cursor:pointer;cursor:hand' ><tr>\n";
		$nav.="<td width=15 onClick='document.".$this->formName.".startRecord.value=0;document.".$this->formName.".submit()'>|&lt;</td><td width=15  onClick='document.".$this->formName.".startRecord.value=$prevPageGroupStart;document.".$this->formName.".submit()'>&lt;</td>\n";
		for ($n=$startPageLink;$n<=$numPages&&$n<=$startPageLink+$this->maxPageShow-1;$n++){
			$nRec=($n-1)*$this->recsPerPage;
			$nav.="<td align='center' width='15'  onClick='document.".$this->formName.".startRecord.value=$nRec;document.".$this->formName.".submit()'>$n</TD>\n";
		}
		if ($page>=$numPages){
			$nav.="<td align='right' width='15' style='color:black'>&gt;</td><td width='15' align='right' style='color:black'>&gt;|</td></tr>\n";
			
		} else {
			$nav.="<td align='right' width='15'  onClick='document.".$this->formName.".startRecord.value=$nextPageGroupStart;document.".$this->formName.".submit()'>&gt;</td><td width='15' align='right' onClick='document.".$this->formName.".startRecord.value=$lastPageStart;document.".$this->formName.".submit()'>&gt;|</td></tr>\n";
		}
		$nav .="</table>";
		return $nav; 
	} 


	//Processes SQL statement
	function doQuery($sql){
		//$sql = $this->paging($this->sql);
		if ($result=pg_exec($sql)){
			return $result;
		}else{
			echo "<p style='text-align:center;font-weight:bold'";
			echo "Error - query unsuccessful - Inform the <a href='admin'>systems administrator</a> of the following:</p>\n";
			echo pg_errormessage();
			echo "<p>$sql</p>";
			die;
		}
		return $result;
	}


	// delete the records identified by UID (can be array ir single value
	function deleteRecord($recUID){
		if (gettype($recUID)=="array"){
			while (list($k,$v)=each($recUID)){
				if ($v=='on'){
					$sql="delete from $this->table where $this->idField = '$k'";
					$this->doQuery($sql); 
				}
			}
		}else{
			$sql="delete from $this->table where $this->idField = '$recUID'";
			$this->doQuery($sql); 
		}
	}

	// adds a blank record to the table
	function addRecord(){
		$this->updateRecord();
		$sqlc="insert into $this->table ($this->idField) values (null)";
		$this->doQuery($sqlc); 
	}

	// updates records from form
	function updateRecord(){
		// requery the table before the submission		
		// initialize sql statement to use
		if (empty($this->sql)){
			 $sqlupdate="SELECT * FROM $this->table ORDER BY $this->sortOrder";
		} else {
			$sqlupdate=$this->sql;
		}
		if ($this->paging || ISSET($_POST['startRecord'])){
			$sqlupdate .= " offset " . $_POST['startRecord'] . " limit " . $this->recsPerPage;
		}
   	//echo($sqlupdate); //debug
		$result=$this->doQuery($sqlupdate);
		/*loop through the rows of the table and each field value and diff to the posted values.  If there 	is a difference then add to sql statement text to update and continue.  Run sql if there is any updating necessary */
		while ($row=pg_fetch_array($result)){ 
			$sqlu="UPDATE $this->table SET"; //first part of the sql string
			$doQ=false; // initialize 'updates are needed' flag
			$uid=$row[$this->idField]; //get the UID of the record
			for ($i=0; $i < pg_numfields ($result); $i++) { //loop through the fields
				$f=pg_fieldname($result,$i); //get the field name
				if ($f!=$this->idField){
					// test if a submitted value is set for this record and field and otherwise set to empty (needed for checkboxes)
					$_POST[$f][$uid]=ISSET($_POST[$f][$uid])?$_POST[$f][$uid]:''; 
					if (addslashes($_POST[$f][$uid])<>$row[$f]){ // test if submitted value is the same as database
						$doQ=TRUE; // flag this record for update
						$sqlu.=" $f='".addslashes($_POST[$f][$uid])."',"; //add appropriate text to sql statement
					}
				}	
					
			}
			$sqlu=substr($sqlu,0,strlen($sqlu)-1)." where $this->idField='$uid'"; //reformat sql statement
			if ($doQ){ //test for record requires update
				//echo "SQL=$sqlu";  //debug
				$this->doQuery($sqlu); //update record
			}
		}

		if (pg_numrows($result)>0){ //see if there are any records in the query
		//	mysql_data_seek($result,0); //reset result set to initial value for display
		}
	}

	
	// main display function
	function display(){
		$hiddenFields="";  //variable to hold hidden field HTML
		// use provided sql statement or set default
		if (empty($this->sql)){
			 $this->sql="SELECT * FROM $this->table ORDER BY $this->sortOrder";
		} 	
		//echo $this->sql; //debug

		//paging start record
		if ($this->paging){
			$startRecord=isset($_POST['startRecord'])?$_POST['startRecord']:0;
			$this->sql .= " offset " . $startRecord . " limit " . $this->recsPerPage;
		}

		$this->result=$this->doQuery($this->sql); //query table
		//echo($this->sql);//debug

		// set up form
		echo "<Div align=center>\n";
		echo "<form method=post action='".$_SERVER['PHP_SELF']."' name='$this->formName' enctype='multipart/form-data'>\n"; //use multipart for file upload
		echo "<table with='100%'>"; 
		//echo empty($this->showtable)?"<table with='100%' border='0'>\n":$this->showtable;  //additional formatting
		//echo "<tr>\n<th style='font-size:".$this->fontSize."pt;font-family:$this->fontFamily'>$this->title</TH>\n</TR>\n";
		echo "<tr>\n<td align='center'>\n";
		
		//background:$this->bgcolor;
		echo "<table style='font-size:".$this->fontSize."pt;font-family:".$this->fontFamily.";border-collapse: collapse;' cellpadding='0' cellspacing='0' align='center' ";
							
		// display select column title and optional counter for editable displays otherwise put in a border for the table
		echo " border='0'>\n<tr>\n";
		echo ISSET($this->counter)?"<th><br /></th>\n":"";
		echo "<th valign=bottom>$this->selColumnName</th>\n";	
		
		// sort order HTML field name
		$sortOrderName=$this->formName."_sortOrder";
		$sortOrderNameOld=$this->formName."_sortOrderOld";

		// set default values for column type and sort for column display order
		// first get sql result 
		if (empty($this->sql)){
			 $this->sql="SELECT * FROM $this->table ORDER BY $this->sortOrder";
		} 	
		$this->result=$this->doQuery($this->sql);

		//add non-specified fields to columnType array with default type and sequence
		$n=10000;  //default sequence starter
		for ($i=0; $i < pg_numfields ($this->result); $i++) {
			$fname=pg_fieldname($this->result,$i);
			if (!array_key_exists($fname,$this->columnType)){
				$this->columnType[$fname]['sequence']=$n;
				$n++;
			}else{
				if (!ISSET($this->columnType[$fname]['sequence'])){
					$this->columnType[$fname]['sequence']=$n;
					$n++;
				}
			}
		}
		
		reset($this->columnType);	

		//sort the array by specified sequence
		while (list($k,$v)=each($this->columnType)){
			$v['type']=ISSET($v['type'])?$v['type']:$this->defaultColType;
			if (!ISSET($v['sequence'])){
				$v['sequence']=$n; //add missing sequence numbers 
				$n++;
			}
			$tmp[$v['sequence']]=$v;  //create a temporary array with the sequence as the key
			$tmp[$v['sequence']]['fieldName']=$k;
		}
		ksort($tmp);
		reset($tmp);
		
		// make column sequential array and set column headers
		while (list($k,$v)=each($tmp)){   
			$fieldName=$tmp[$k]['fieldName'];
			$tmpColType[$fieldName]=$v;
			if ($v['type']!='hidden'){
				// calculate ascending or descending depending on last sortorder	
				$oldAD="ASC";
				if (ISSET($this->sortOrder) && strpos($this->sortOrder,$fieldName)===0){
					$oldAD=ltrim(substr($this->sortOrder,strlen($this->sortOrder)-4));
				}
				$newAD=$oldAD=="ASC"?"DESC":"ASC";
				
				// display column title or alias with sort order functionality
				$colName=ISSET($v['alias'])?$v['alias']:$fieldName;
				
				// set column width
				$colWidth=ISSET($v['width'])?"width='".$v['width']."'":"";
                        
				// set column size
				//$colSize=ISSET($v['size'])?"size='".$v['size']."'":"";
				
				echo "<td>".$colName."</td>";
				//echo "<th nowrap $colWidth style='cursor:pointer;cursor:hand' onClick=\"document.$this->formName.$sortOrderName.value='".$fieldName." ".$newAD."';document.$this->formName.submit()\">".$colName;
				if ($this->arrowPath['ASC']!=''){
					echo $oldad=="asc"?"<img src='".$this->arrowpath['ASC']."' width='15' height='15' border='0' alt='ASC' /></th>\n":"<img src='".$this->arrowpath['DESC']."' width='15' height='15' border='0' alt='DESC' /></th>\n";  //gifs are generic small arrows
				}else{
					echo "</TH>\n";
				}
			}
		}
		echo "</tr>\n";

		// fetch rows and display

		$counti=0; //set counter

		while ($row=pg_fetch_array($this->result)){
			//$row=mysql_fetch_array($this->result);  //debug			
			$counti++; //increment counter
	
			//optional alternating row colors
			if (ISSET($this->rowcolor1) || ISSET($this->rowcolor2)){
				echo $counti %2 == 0?"<tr bgcolor='".$this->rowcolor1."'>\n":"<tr bgcolor='".$this->rowcolor2."'>\n";
			}else{
				echo "<tr>\n";
			}
			// display row counter
			if (ISSET($this->counter)){
				echo "<td style='font-size:".$this->fontSize."pt;font-family:$this->fontFamily'>$counti</td>\n";
			}

			// do substitutions for selectAction
			$selAction="";
			if (ISSET($this->selectAction)){
				$selAction=$this->selectAction;
				while ($fieldstart=strpos($selAction,"#")){
					$fieldstart++;
					$fieldlength=strpos($selAction,"#",$fieldstart)-$fieldstart;
					$tmpTxt=substr($selAction,$fieldstart,$fieldlength);
					if (isset($row[$tmpTxt])){
						$fieldid="#".$tmpTxt."#";
						$selAction=str_replace($fieldid,$row[$tmpTxt],$selAction);
					}
				}
			}
	
			//display select column 
			$isSelected=$this->selectedRow==$row[$this->idField]?"checked='checked'":"";
			if ($this->radioButton){
			   //echo "<td>&nbsp;<input type='radio' $isSelected name='selrecord[".$row[$this->idField]."]' $selAction />.</td>\n"; //the extra period seems necessary for large table display speed (anyone?)
			   echo "<td>&nbsp;<input type='radio' $isSelected name='selrecord[".$row[$this->idField]."]' $selAction /></td>\n"; //the extra period seems necessary for large table display speed (anyone?)
			}else{
				//echo "<td>&nbsp;<input $isSelected type='checkbox' name='selRecord[".$row[$this->idField]."]' $selAction />.</td>\n"; //the extra period seems necessary for large table display speed (anyone?)
				echo "<td>&nbsp;<input $isSelected type='hidden' name='selRecord[".$row[$this->idField]."]' $selAction /></td>\n"; //the extra period seems necessary for large table display speed (anyone?)
			}

			//display the data
			reset($tmpColType);
			while (list($k,$v)=each($tmpColType)){  //$k is the fieldname, $v parameters
				$rowUID=$row[$this->idField];
				$objID=$k."[".$rowUID."]";  //sets unique object ID for each column and row

				$camSize=$v['size'];

				//set validation text for this field
				if (ISSET($v['validate'])){
					$validtext=$v['validate'];
					while ($fieldstart=strpos($validtext,"#")){
						$fieldstart++;
						$fieldlength=strpos($validtext,"#",$fieldstart)-$fieldstart;
						$tmpTxt=substr($validtext,$fieldstart,$fieldlength);
						if (isset($row[$tmpTxt])){
							$fieldid="#".$tmpTxt."#";
							$validtext=str_replace($fieldid,$row[$tmpTxt],$validtext);
						}
					}
				}else{
					$validtext="";
				}

				//determine readonly
				$enabled="";
				if (ISSET($v['enabled'])){ //column has a setting
					$enabled=$v['enabled']==0?"readonly":"";
				}
				if ($this->enabled=="readonly"){ //entire form is readonly
					$enabled="readonly";
				}


				switch ($v['type']){
				case "text":
					//echo "<td with='33%'><input $enabled style='";
					//echo ISSET($v['size'])?"width:".$v['size'].";":"";
					//echo "font-size:".$this->fontSize."pt;font-family:$this->fontFamily' size='$camSize' TYPE='text' name='$objID' VALUE='".htmlentities($row[$k],ENT_QUOTES,$this->charCode)."' $validtext /></TD>\n";
					
					echo "<td'><input $enabled TYPE='text' readonly='enable' size='30' name='$objID' VALUE='".htmlentities($row[$k],ENT_QUOTES,$this->charCode)."' $validtext /></TD>\n";
					break;

				case "selectBox":
					$active=$enabled=="readonly"?"disabled":"";
					if (ISSET($v['dynamicSelect'])){
						$selArray=array();
						$sqlSelect=$v['dynamicSelect'];
						while ($fieldstart=strpos($sqlSelect,"#")){
							$fieldstart++;
							$fieldlength=strpos($sqlSelect,"#",$fieldstart)-$fieldstart;
							$tmpTxt=substr($sqlSelect,$fieldstart,$fieldlength);
							if (isset($row[$tmpTxt])){
								$fieldid="#".$tmpTxt."#";
								$sqlSelect=str_replace($fieldid,$row[$tmpTxt],$sqlSelect);
							}
						}
						$resSelect=$this->doQuery($sqlSelect);
						while ($rselect=pg_fetch_row($resSelect)){
							$selArray[$rselect[0]]=$rselect[1];
						}
						$v['selectValues']=$selArray;
					}
					echo "<td>&nbsp;<select  $active name='$objID' $validtext>\n";
					echo "<option value=''></option>\n"; //add empty starting option
					//place array keys and values into selectbox
					while (list($kk,$vv)=each($v['selectValues'])){
						if (ISSET($row[$k])){
							$checked=$kk==$row[$k]?"selected='selected'":"";
						}else{
							$checked="";
						}
						echo "<option value='$kk' $checked>".$vv."</option>\n";
					}
					reset($v['selectValues']);  //reset selectbox value array
					echo "</select></TD>\n";
					break;

				case "textarea":	
					if (!ISSET($v['textareaCols'])){
						$v['textareaCols']=25;	
					}
					if (!ISSET($v['textareaRows'])){
						$v['textareaRows']=3;	
					}
					echo "<td><textarea style='font-size:".$this->fontSize."pt;font-family:$this->fontFamily'  $enabled cols='".$v['textareaCols']."' rows='".$v['textareaRows']."' name='$objID' >".htmlentities($row[$k],ENT_QUOTES,$this->charCode)."</textarea></TD>\n";
					break;

				case "checkbox":
					$checked=$row[$k]=="on"?"checked='checked'":"";
					$active=$enabled=="readonly"?"disabled":"";
					echo "<td with='33%'>&nbsp;<input $active type='checkbox' name='$objID' $checked $validtext /></TD>\n";
					break;
				
				case "date":
					if ($row[$k]=="0000-00-00 00:00:00" || $row[$k]==NULL){
						$todayDate=getdate();
					}else{
						$todayDate['year']=substr($row[$k],0,4);
						$todayDate['mon']=substr($row[$k],5,2);
						$todayDate['mday']=substr($row[$k],8,2);
						$todayDate['hours']=substr($row[$k],11,2);
						$todayDate['minutes']=substr($row[$k],14,2);
					}
					// create hidden field and default to today's date
					echo "<td style='font-size:".$this->fontSize."pt;font-family:$this->fontFamily' nowrap><input type=hidden name='$objID' id='selDate".$k.$rowUID."' value='$todayDate[year]-$todayDate[mon]-$todayDate[mday]'>\n";
					if ($enabled!="readonly"){
						$active="";	$blur="\"document.getElementById('selDate".$k.$rowUID."').value=document.getElementById('Year".$k.$rowUID."').options[document.getElementById('Year".$k.$rowUID."').selectedIndex].text+'-'+document.getElementById('Month".$k.$rowUID."').options[document.getElementById('Month".$k.$rowUID."').selectedIndex].text+'-'+document.getElementById('Day".$k.$rowUID."').options[document.getElementById('Day".$k.$rowUID."').selectedIndex].text\"";
					}else{
						$blur="";
						$active="disabled";
					}
					//display month, set select to table value or default date, reformat mysql value 
					echo "&nbsp;&nbsp;M<select $active name='Month".$objID."' id='Month".$k.$rowUID."'  onBlur=$blur>\n";
					for ($n=1;$n<=12;$n++){
						$on = $todayDate['mon']==$n ? "selected='selected'":"";
						echo "<option $on>$n</option>\n";
					}
					echo "</select>\n";
					
					//display day	
					echo "D<select $active name='Day".$objID."' id='Day".$k.$rowUID."'  onBlur=$blur>\n";
					for ($n=1;$n<=31;$n++){
						$on = $todayDate['mday']==$n ? "selected='selected'":"";
						echo "<option $on>$n</option>\n";
					}
					echo "</select>\n";
					
					//display year
					$sy=ISSET($v['startYear'])?$v['startYear']:date('Y');
					$ey=ISSET($v['endYear'])?$v['endYear']:date('Y')+10;
					echo "Y<select $active name='Year".$objID."' id='Year".$k.$rowUID."'  onBlur=$blur>\n";
					for ($n=$sy;$n<=$ey;$n++){
						$on = $todayDate['year']==$n ? "selected='selected'":"";
						echo "<option $on>$n</option>\n";
					}
					echo "</select>\n";
					break;

				case "dateTime":
						if ($row[$k]=="0000-00-00 00:00:00" || $row[$k]==NULL){
						$todayDate=getdate();
					}else{
						$todayDate['year']=substr($row[$k],0,4);
						$todayDate['mon']=substr($row[$k],5,2);
						$todayDate['mday']=substr($row[$k],8,2);
						$todayDate['hours']=substr($row[$k],11,2);
						$todayDate['minutes']=substr($row[$k],14,2);
					}
					// create hidden field and default to today's date
					echo "<td style='font-size:".$this->fontSize."pt;font-family:$this->fontFamily' nowrap><input type='hidden' name='$objID' id='selDate".$k.$rowUID."' value='$todayDate[year]-$todayDate[mon]-$todayDate[mday]'>\n";

					if ($enabled!="readonly"){
						$active="";
						$blur="\"document.getElementById('selDate".$k.$rowUID."').value=document.getElementById('Year".$k.$rowUID."').options[document.getElementById('Year".$k.$rowUID."').selectedIndex].text+'-'+document.getElementById('Month".$k.$rowUID."').options[document.getElementById('Month".$k.$rowUID."').selectedIndex].text+'-'+document.getElementById('Day".$k.$rowUID."').options[document.getElementById('Day".$k.$rowUID."').selectedIndex].text+' '+document.getElementById('Hour".$k.$rowUID."').options[document.getElementById('Hour".$k.$rowUID."').selectedIndex].text+':'+document.getElementById('Minute".$k.$rowUID."').options[document.getElementById('Minute".$k.$rowUID."').selectedIndex].text\"";
					}else{
						$blur="";
						$active="disabled";
					}
					//display month, set select to table value or default date, reformat mysql value 
					echo "&nbsp;&nbsp;M<select $active name='Month".$objID."' id='Month".$k.$rowUID."'  onBlur=$blur>\n";
					for ($n=1;$n<=12;$n++){
						$on = $todayDate['mon']==$n ? "selected='selected'":"";
						echo "<option $on>$n</option>\n";
					}
					echo "</select>\n";
					
					//display day	
					echo "D<select $active name='Day".$objID."' id='Day".$k.$rowUID."'  onBlur=$blur>\n";
					for ($n=1;$n<=31;$n++){
						$on = $todayDate['mday']==$n ? "selected='selected'":"";
						echo "<option $on>$n</option>\n";
					}
					echo "</select>\n";
					
					//display year
					$sy=ISSET($v['startYear'])?$v['startYear']:date('Y');
					$ey=ISSET($v['endYear'])?$v['endYear']:date('Y')+10;
					echo "Y<select $active name='Year".$objID."' id='Year".$k.$rowUID."'  onBlur=$blur>\n";
					for ($n=$sy;$n<=$ey;$n++){
						$on = $todayDate['year']==$n ? "selected='selected'":"";
						echo "<option $on>$n</option>\n";
					}
					echo "</select>\n";
														
					//display Hours	
					echo "h<select $active name='Hour".$objID."' id='Hour".$k.$rowUID."'  onBlur=$blur>\n";
					for ($n=0;$n<=23;$n++){
						$on = $todayDate['hours']==$n ? "selected='selected'":"";
						echo "<option $on>$n</option>\n";
					}
					echo "</select>\n";
					//display Minutes
					echo "m<select $active name='Minute".$objID."' id='Minute".$k.$rowUID."' onBlur=$blur>\n";
					for ($n=0;$n<=55;$n=$n+5){
						$on = $todayDate['minutes']==$n ? "selected='selected'":"";
						echo "<option $on>$n</option>\n";
					}
					echo "</select>\n";
					break;

				case "action":
					$dispText=$v['actionText'];
	
					while ($fieldstart=strpos($dispText,"#")){
						$fieldstart++;
						$fieldlength=strpos($dispText,"#",$fieldstart)-$fieldstart;
						$tmpTxt=substr($dispText,$fieldstart,$fieldlength);
						if (isset($row[$tmpTxt])){
							$fieldid="#".$tmpTxt."#";
							$dispText=str_replace($fieldid,$row[$tmpTxt],$dispText);
						}
					}
					echo "<td>&nbsp;$dispText</td>\n";
					break;
				case "function":
					$param=explode(",",$v['functionParam']);
					foreach($param as $fieldName){
						$pvalue[$fieldName]=$row[$fieldName];
					}
					$output=call_user_func_array($v['functionName'],array(&$pvalue));
					echo "<td nowrap style='font-size:".$this->fontSize."pt; font-family:".$this->fontFamily.";color:black'>$output</td>\n";
					unset($pvalue);
					break;
				case "hidden":
					$hiddenFields.= "<input type='hidden' name='$objID'  VALUE='".htmlentities($row[$k],ENT_QUOTES,$this->charCode)."' />\n";
					break;
				}	
			}
			echo "</tr>\n";
		}

		echo "</table>\n";
		echo "</td></tr></table>\n";
		
		// set sortorder post variable
		echo "<input type='hidden' name='$sortOrderName' value='";  
		echo ISSET($this->sortOrder)?$this->sortOrder:"";
		echo "' />\n";

		//add footer
		echo $this->footer;
	
		//add paging *** muestra paginacion ej: Page: 1 of 4
		if ($this->paging){
		//	echo "<input type='hidden' name='startRecord' value='$startRecord' />\n";
		//	$links =$this->showpagelinks($startRecord);
		//	echo $links;
		}
		echo $hiddenFields;	
		echo "</form>\n</div>\n";
		pg_freeresult($this->result);

	}
}

?>