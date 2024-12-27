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
		$query = "select BookingID, MaterialID , MaterialName from tbl_booking1 order by BookingID ASC  ";
		$result = $mysqli -> query($query); 
		if($result){  
			while ($rows = $result -> fetch_assoc()){ 
				if(trim($rows['MaterialName'])==""){   
					$updateQuery ="update `tbl_booking1` set `MaterialName` =  (select  MaterialName from tbl_materials where MaterialID = '".$rows['MaterialID']."' )  
					where BookingID ='".$rows['BookingID']."' ";  
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