<?php
	error_reporting(E_ALL);    
	###########################################  
	############ MYSQL CONNECTION #############
    $dbhost='localhost'; 
    $dbuser='tmlsnslt_tml';
    $dbpass='qmw7V7vEiT3C';
	$db='tmlsnslt_tml';
	
	 
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	}  
	
		$k = 0;    $j = 0;    
		$query = ""; $result = ""; $rows = ""; $insertQuery = ""; $result1 = ""; 
		$query = "select BookingID, BookingDateID , BookingDateStatus from tbl_booking_date1 order by BookingDateID ASC   ";
		$result = $mysqli -> query($query); 
		if($result){  
			while ($rows = $result -> fetch_assoc()){ 
				$query1 = '';
				$query1 = "select Status  from tbl_booking_ where BookingID = '".$rows['BookingID']."' ";
				$result1 = $mysqli -> query($query1); 
				if($result1){  
					$rows1 = $result1 -> fetch_assoc(); 					
					 
						$updateQuery ="update `tbl_booking_date1` set `BookingDateStatus` = '".$rows1['Status']."' where BookingDateID ='".$rows['BookingDateID']."' ";  
						$result2 = $mysqli -> query($updateQuery); 
						if($result2){ $j = $j+1; }   
				}
				$k = $k+1;    
			}
		}	
	 
	echo "Total =====>>> Total Recordss : ".$k."  <br> ";	  
	echo "Updated =====>>> Updated : ".$j."  <br> ";
 		 
exit; 
?>   