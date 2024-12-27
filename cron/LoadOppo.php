<?php
	error_reporting(E_ALL);    
	###########################################  
	############ MYSQL CONNECTION #############
    $dbhost='localhost'; 
    $dbuser='tmlsnsit_demo';
    $dbpass='panchal12345';
	$db='tmlsnsit_demo';
	 
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	}  
	
		$k = 0;    $j = 0;    
		$query = ""; $result = ""; $rows = ""; $insertQuery = ""; $result1 = ""; 
		$query = "select BookingRequestID, OpportunityID , OpportunityName from tbl_booking_request order by BookingRequestID  ASC limit 1 ";
		$result = $mysqli -> query($query); 
		if($result){  
			while ($rows = $result -> fetch_assoc()){ 
				if(trim($rows['OpportunityName'])==""){   
				
					$updateQuery ="update `tbl_booking_request` set `OpportunityName` =  (select  OpportunityName from tbl_opportunities where OpportunityID = '".$rows['OpportunityID']."' )  
					where BookingRequestID ='".$rows['BookingRequestID']."' ";  
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