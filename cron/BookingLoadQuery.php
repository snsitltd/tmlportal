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
		echo $query = "SELECT  `BookingRequestID`, `BookingID`, `BookingDateID`, `DriverID`,  DATE_FORMAT(JobStartDateTime,'%Y-%m-%d') as ADT  FROM `tbl_booking_loads1` 
		WHERE `BookingDateID` = 0  
		GROUP BY BookingRequestID, BookingID, DriverID, DATE_FORMAT(JobStartDateTime,'%Y-%m-%d') 
		ORDER BY `tbl_booking_loads1`.`CreateDateTime` DESC ";
		$result = $mysqli -> query($query); 
		if($result){  
			while ($rows = $result -> fetch_assoc()){ 
				$query1 = ''; $updateQuery = ''; $result2 = ''; $result1 = ''; $rows1 = ''; $BDID ='';
				echo "<br><br><br>";
				echo $query1 = " SELECT `BookingRequestID`,`BookingID`,`BookingDateID`,`DriverID`,DATE_FORMAT(JobStartDateTime,'%Y-%m-%d') as ADT2  FROM `tbl_booking_loads1` 
				WHERE `BookingRequestID` = '".$rows['BookingRequestID']."' AND `BookingID` = '".$rows['BookingID']."' AND `DriverID` = '".$rows['DriverID']."' 
				AND `JobStartDateTime` like '%".$rows['ADT']."%' ORDER BY `tbl_booking_loads1`.`BookingDateID` DESC   ";
				$result1 = $mysqli -> query($query1); 
				if($result1){  
				    while ($rows1 = $result1 -> fetch_assoc()){  				
					    //echo $rows1['BookingDateID']; 
						if($rows1['BookingDateID']!=0){ $BDID = $rows1['BookingDateID']; }
						echo "<br><br><br>";
						if($rows1['BookingDateID']==0){
							echo $updateQuery ="update `tbl_booking_loads1` set `BookingDateID` = '".$BDID."' 
							where `BookingRequestID` = '".$rows1['BookingRequestID']."' AND `BookingID` = '".$rows1['BookingID']."' AND `DriverID` = '".$rows1['DriverID']."'  
							AND `JobStartDateTime` like '%".$rows1['ADT2']."%' ";  
							
							//$result2 = $mysqli -> query($updateQuery); 
							if($result2){ $j = $j+1; }   
						}
				    }	
				}
				$k = $k+1;    
			}
		}	
	 
	echo "Total =====>>> Total Recordss : ".$k."  <br> ";	  
	echo "Updated =====>>> Updated : ".$j."  <br> ";
 		 
exit; 
?>   