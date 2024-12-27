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
	$query = "select tbl_booking_loads1.LoadID from tbl_booking_loads1 
	left join tbl_booking1 on tbl_booking_loads1.BookingID =  tbl_booking1.BookingID 
	where tbl_booking1.BookingType = '4' and tbl_booking_loads1.Status = '8' 
	and DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime ,'%Y-%m-%d') <= CURDATE() "; 
	$result = $mysqli -> query($query); 
	if($result){ 
		
		while($rows = $result->fetch_array(MYSQLI_ASSOC)){ 
				$query1 =''; $result1 ='';
				$query1 = "update tbl_booking_loads1 set Status = '4'  where LoadID = '".$rows['LoadID']."'  ";
				$result1 = $mysqli -> query($query1); 
				if($result1){ $del = $del+1; } 
		} 	    
	}	
	 
	echo "Date: ".date("d/m/Y ")." == Total Updated : ".$del."  <br> ";	 
   
?>   