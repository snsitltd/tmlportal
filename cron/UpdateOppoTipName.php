<?php
	error_reporting(E_ALL);    
    $dbhost='localhost'; 
	$dbuser='root';
    $dbpass='';
	$db='tml';
	
    //$dbuser='tmlsnslt_tml';
	//$dbpass='qmw7V7vEiT3C';
	//$db='tmlsnslt_tml';
	 
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	}  
	
	$k = 0;    $j = 0;    
	$query = ""; $result = ""; $rows = ""; 
	$query = "select OpportunityID from tbl_opportunities order by tscreate_datetime desc ";
	$result = $mysqli -> query($query); 
	if($result){  
		while ($rows = $result -> fetch_assoc()){  
			$query1 =''; $TipText = '';$rows1 = ""; $result1 = ""; $result2 = ""; $updateQuery = ""; 
			$query1 = "SELECT `tbl_tipaddress`.`TipName`, DATE_FORMAT(tbl_opportunity_tip.CreateDateTime, '%d/%m/%Y') as TipDT 
			FROM `tbl_opportunity_tip` 
			LEFT JOIN `tbl_tipaddress` ON `tbl_opportunity_tip`.`TipID`=`tbl_tipaddress`.`TipID` 
			WHERE `tbl_opportunity_tip`.`OpportunityID` = '".$rows['OpportunityID']."' AND `tbl_opportunity_tip`.`Status` = '0' 
			ORDER BY `tbl_tipaddress`.`TipName` ASC  ";
			$result1 = $mysqli -> query($query1);  
			if($result1){ 
				while ($rows1 = $result1 -> fetch_assoc()){  
				//var_dump($rows1);
					$TipText =  $TipText.$rows1['TipName']." - ".$rows1['TipDT']."\n";
				} 
				$updateQuery ="update  `tbl_opportunities`  set `TipName` = '".$TipText."'  where `OpportunityID` = '".$rows['OpportunityID']."'    ";  
				$result2 = $mysqli -> query($updateQuery);  
			} 
		} 
	}	   
exit; 
?>   