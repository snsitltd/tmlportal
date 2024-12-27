<?php
	error_reporting(E_ALL);   
	###########################################  
	############ MYSQL CONNECTION #############
    $dbhost='localhost'; 
    $dbuser='tmlsnslt_tml';
    $dbpass='qmw7V7vEiT3C';
	$db='tmlsnslt_tml';
	 
	//$dbhost='localhost'; 
    //$dbuser='root';
    //$dbpass='';
    //$db='tml'; 
	
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	} 
	############################################
	$del = 0;   
	$query = "select LogID from  tbl_drivers_logs  where LogoutDateTIme = '0000-00-00 00:00:00' and DATE_FORMAT(tbl_drivers_logs.LoginDatetime ,'%Y-%m-%d') = CURDATE() ";
	$result = $mysqli -> query($query); 
	if($result){ 
		$DT = date("Y-m-d H:i:s");
		while($rows = $result->fetch_array(MYSQLI_ASSOC)){ 
				$query1 =''; $result1 =''; 
				$query1 ="update `tbl_drivers_logs` set `LogoutDateTIme` = '".$DT."' where LogID ='".$rows['LogID']."' "; 
				$result1 = $mysqli -> query($query1); 
				if($result1){ $del = $del+1; } 
		} 	    
	}	
	 
	echo "Date: ".date("d/m/Y ")." == Total LoggedOut  : ".$del."  <br> ";	 
   
?>  




















