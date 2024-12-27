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
		$query = "select OpportunityID from tbl_opportunities order by tscreate_datetime  desc limit 15  ";
		$result = $mysqli -> query($query); 
		if($result){  
			while ($rows = $result -> fetch_assoc()){  
				$query1 ='';
				$query1 = "select TableID from tbl_opportunity_tip where OpportunityID = '".$rows['OpportunityID']."' and TipID =  '1' ";
				$result1 = $mysqli -> query($query1); 
				if($result1){   
					if( $result1->num_rows==0){ 		 
						
						$updateQuery ="insert into `tbl_opportunity_tip`  set `TipID` =  '1', `TipRefNo` =  '', `OpportunityID` = '".$rows['OpportunityID']."', `Status` = '0'   ";  
						$result2 = $mysqli -> query($updateQuery); 
						//echo $mysqli -> insert_id."<br>=========<br>";
						
						if($result2){ $j = $j+1; }   
					}	
				}	
			    $k = $k+1; 
			    
			}
			
		}	
	 
	echo "Total =====>>> Total Recordss : ".$k."  <br> ";	  
	echo "Updated =====>>> Updated : ".$j."  <br> ";
 		 
exit; 
?>   