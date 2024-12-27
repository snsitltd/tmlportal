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
		$query = "select CompanyID , CompanyName, AccountRef  from tbl_company order by tscreate_datetime  desc   ";
		$result = $mysqli -> query($query); 
		if($result){  
			while ($rows = $result -> fetch_assoc()){  
				if($rows['AccountRef']==""){
					$query1 ='';
					$query1 = "select ACCOUNT_REF from table_name where NAME = '".trim($rows['CompanyName'])."'  ";
					$result1 = $mysqli -> query($query1); 
					if($result1){   
						if( $result1->num_rows>0){ 		 
							$rows1 = $result1 -> fetch_assoc(); 
							
							$updateQuery ="update `tbl_company`  set `AccountRef` = '".$rows1['ACCOUNT_REF']."' where  CompanyID = '".$rows['CompanyID']."' ";  
							$result2 = $mysqli -> query($updateQuery); 
							if($result2){ $j = $j+1; }   
						}	
					}	
				}
				
			}
			$k = $k+1; 
		}	
	 
	echo "Total =====>>> Total Recordss : ".$k."  <br> ";	  
	echo "Updated =====>>> Updated : ".$j."  <br> ";
 		 
exit; 
?>   