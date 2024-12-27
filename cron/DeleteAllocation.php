<?php
	error_reporting(E_ALL);   
	###########################################  
	############ MYSQL CONNECTION #############
    //$dbhost='localhost'; 
    //$dbuser='tmlsnslt_tml';
    //$dbpass='qmw7V7vEiT3C';
	//$db='tmlsnslt_tml';
	 
	$dbhost='localhost'; 
    $dbuser='root';
    $dbpass='';
    $db='tml'; 
	
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	} 
	############################################
	   
	$query = "select LoadID from tbl_booking_loads  where Status = '0'  ";
	$result = $mysqli -> query($query); 
	if($result){ 
		$del = 0;
		while($rows = $result->fetch_array(MYSQLI_ASSOC)){ 
				$query1 =''; $result1 ='';
				$query1 = "delete from tbl_booking_loads  where LoadID = '".$rows['LoadID']."'  ";
				$result1 = $mysqli -> query($query1); 
				if($result1){ $del = $del+1; } 
		} 	    
	}	
	 
	echo "Date: ".date("d/m/Y ")." == Total Allocation Removed : ".$del."  <br> ";	 
   
?>  




















