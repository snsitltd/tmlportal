<?php
	error_reporting(E_ALL);   
	###########################################  
	############ MYSQL CONNECTION #############
    $dbhost='localhost'; 
    $dbuser='tmlsnslt_tml';
    $dbpass='qmw7V7vEiT3C';
	$db='tmlsnslt_tml';
	
	//$dbhost='localhost'; 
    //$dbuser='tmlsnsit_demo';
    //$dbpass='panchal12345';
	//$db='tmlsnsit_demo';
	
	//$dbhost='localhost'; 
    //$dbuser='root';
    //$dbpass='';
    //$db='tml_new'; 
	
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	} 
	############################################
	 
	$del = 0;   
	$query = "SELECT  
    `tbl_booking_date1`.`BookingDateID`, 
    `tbl_booking_date1`.`CancelLoads`,  
    `tbl_booking1`.`LoadType`,  
    `tbl_booking1`.`Loads`, 
    `tbl_booking_date1`.`BookingDate` AS `BookingDateTime1`, 
    ( SELECT COUNT(*)  FROM tbl_booking_loads1 WHERE tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID AND tbl_booking_loads1.AutoCreated = 1) AS TotalLoadAllocated,
	( SELECT COUNT(DISTINCT DriverID) FROM tbl_booking_loads1 WHERE tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID AND tbl_booking_loads1.AutoCreated = 1 ) AS DistinctLorry 
	
	FROM  `tbl_booking_date1`
	LEFT JOIN `tbl_booking1` ON `tbl_booking_date1`.`BookingID` = `tbl_booking1`.`BookingID`
	LEFT JOIN `tbl_booking_request` ON `tbl_booking_date1`.`BookingRequestID` = `tbl_booking_request`.`BookingRequestID`
	WHERE
    `tbl_booking_date1`.`BookingDateStatus` = 1 
	AND DATE_FORMAT(tbl_booking_date1.BookingDate, '%Y-%m-%d') < ( CURDATE() - INTERVAL 7 DAY  )
	AND DATE_FORMAT(tbl_booking_date1.BookingDate, '%Y-%m-%d') > ( CURDATE() - INTERVAL 10 DAY  )
	AND( CASE WHEN tbl_booking1.LoadType = 1 
		THEN tbl_booking1.Loads - tbl_booking_date1.CancelLoads -( SELECT COUNT(*) FROM tbl_booking_loads1 WHERE tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ) > 0 
		ELSE tbl_booking1.Loads - tbl_booking_date1.CancelLoads -( SELECT COUNT(DISTINCT DriverID) FROM tbl_booking_loads1 WHERE tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID AND DATE_FORMAT(  tbl_booking_loads1.AllocatedDateTime, '%Y-%m-%d' ) < CURDATE()) > 0 
		END
    ) ORDER BY `tbl_booking_date1`.`BookingDateID` DESC  ";
	$result = $mysqli -> query($query); 
	if($result){   	

		while($rows = $result->fetch_array(MYSQLI_ASSOC)){ 
				$q1 =''; $result1 =''; $CancelLoads =0; 
				if($rows['LoadType']=='1'){ 
					$CancelLoads = ($rows['Loads']-$rows['CancelLoads']-$rows['TotalLoadAllocated']);
				}else{
					$CancelLoads = ($rows['Loads']-$rows['CancelLoads']-$rows['DistinctLorry']);
				}
				$q1 = "update   tbl_booking_date1   set BookingDateStatus = '1' ,CancelLoads = '".$CancelLoads."' ,
				CancelReason = '3' , CancelNote = 'Auto Cancelled By Admin'  , CancelBy = '1'  , CancelDateTime = '".date('Y-m-d H:i:s')."' 
				where BookingDateID = '".$rows['BookingDateID']."' ";  
				 
				$result1 = $mysqli -> query($q1); 
				 // echo("Error description: " . $mysqli -> error);


				if($result1){ $del = $del+1; } 
		} 	    
		 
	}	
	 
	echo "Date: ".date("d/m/Y ")." == Total Updated : ".$del."  <br> ";	 
   
?>   