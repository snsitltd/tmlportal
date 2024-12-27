<?php
	error_reporting(E_ALL);    
	###########################################  
	############ MYSQL CONNECTION #############
    $dbhost='localhost'; 
	//$dbuser='root';
    //$dbpass='';
	//$db='tml';
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
		$query = "select BookingRequestID, OpportunityID , OpportunityName from tbl_booking_request order by BookingRequestID  ASC   ";
		$result = $mysqli -> query($query); 
		if($result){  
			while ($rows = $result -> fetch_assoc()){ 
				//if(trim($rows['OpportunityName'])==""){   
				
					$updateQuery ="update `tbl_booking_request` set `OpportunityName` =  (select  OpportunityName from tbl_opportunities where OpportunityID = '".$rows['OpportunityID']."' ),
					`Street1` =  (select  Street1 from tbl_opportunities where OpportunityID = '".$rows['OpportunityID']."' ), 
 					`Street2` =  (select  Street2 from tbl_opportunities where OpportunityID = '".$rows['OpportunityID']."' ), 
					`Town` =  (select  Town from tbl_opportunities where OpportunityID = '".$rows['OpportunityID']."' ), 
					`County` =  (select  County from tbl_opportunities where OpportunityID = '".$rows['OpportunityID']."' ), 
					`PostCode` =  (select  PostCode from tbl_opportunities where OpportunityID = '".$rows['OpportunityID']."' ) 
					where BookingRequestID ='".$rows['BookingRequestID']."' ";  
					$result2 = $mysqli -> query($updateQuery); 
					if($result2){ $j = $j+1; } 
				//} 
				$k = $k+1;    
			}
		}	
	 
	echo "Total =====>>> Total Recordss : ".$k."  <br> ";	  
	echo "Updated =====>>> Updated : ".$j."  <br> ";
 		 
exit; 
?>   