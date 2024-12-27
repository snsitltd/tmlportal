<?php
	error_reporting(E_ALL);   
	###########################################  
	############ MYSQL CONNECTION #############
    /*$dbhost='localhost'; 
    $dbuser='tmlsnslt_tml';
    $dbpass='qmw7V7vEiT3C';
	$db='tmlsnslt_tml'; */
	 
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
	$del = 0;   
	//$query = "select LoadID from tbl_booking_loads1  where Status = '0' and DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime ,'%Y-%m-%d') <= CURDATE() "; 
	//echo $query = "select LoadID from tbl_booking_loads1  where Status = '0'   "; 
	$query = "select LoadID from tbl_booking_loads1  where Status = '0' and DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime ,'%Y-%m-%d') <= CURDATE()  and tbl_booking_loads1.JobStartDateTime =  '0000-00-00 00:00:00' ";  
	$result = $mysqli -> query($query); 
	if($result){ 
		
		while($rows = $result->fetch_array(MYSQLI_ASSOC)){ 
				$query1 =''; $result1 =''; $query2 =''; $result2 =''; $rows2 =''; $insertQuery = ''; $resultInsert = '';
				$JSONValues = '';
				
				$query2 = "select * from tbl_booking_loads1  where  LoadID = '".$rows['LoadID']."' ";  
				$result2 = $mysqli -> query($query2); 
				$rows2 = $result2->fetch_array(MYSQLI_ASSOC);
				$JSONValues = json_encode($rows2);
				
				$DeletedQuery ="INSERT INTO `tbl_booking_loads_deleted` set `LoadID` = '".$rows2['LoadID']."', 
				`ConveyanceNo` = '".$rows2['ConveyanceNo']."', `LoadValues` = '".$JSONValues."' ";
				$resultDeleted = $mysqli -> query($DeletedQuery);   

				$query1 = "delete from tbl_booking_loads1  where LoadID = '".$rows['LoadID']."'  ";
				$result1 = $mysqli -> query($query1); 
				if($result1){ 
					
					$insertQuery ="INSERT INTO `tbl_site_logs` set `TableName` = 'tbl_booking_loads1', 
					`PrimaryID` = '".$rows['LoadID']."', `UpdatedValue` = '".$query1."',
					`SitePage` = 'Delete Not Started Load Via CronJOB' , `UpdatedByUserID` = '1' ";
					$resultInsert = $mysqli -> query($insertQuery);   
					 
	
					$del = $del+1; 
				} 
		} 	    
	}	
	 
	echo "Date: ".date("d/m/Y ")." == Total Allocation Removed : ".$del."  <br> ";	 
   
?>  




















