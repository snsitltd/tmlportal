<?php

error_reporting(E_ALL);  

###########################################  
############ MYSQL CONNECTION #############
$dbhost='localhost'; 
$dbuser='root';
$dbpass='';
$db='tml_new';

$dbuser='tmlsnsit_demo';
$dbpass='panchal12345';
$db='tmlsnsit_demo';
 
//$dbuser='tmlsnslt_tml';
//$dbpass='qmw7V7vEiT3C';
//$db='tmlsnslt_tml';
 
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}  
echo "<br>=========<br>";
$CompanyID = 'FA182C87-2672-426A-95D9-7056A6ACB112'; 
$k = 0;    $j = 0;     
 
echo $query = "select tbl_opportunity_tip.*, tbl_opportunities.OpportunityName as ONAME
from tbl_opportunity_tip  
join tbl_company_to_opportunities  on  tbl_opportunity_tip.OpportunityID =  tbl_company_to_opportunities.OpportunityID 
join tbl_opportunities  on tbl_opportunity_tip.OpportunityID  = tbl_opportunities.OpportunityID 
where tbl_company_to_opportunities.CompanyID = '".$CompanyID."'    
order by tbl_opportunity_tip.TableID  ASC "; 

$result = $mysqli -> query($query); 
if($result){  
	while ($rows = $result -> fetch_assoc()){  
		echo "<br>=========<br>"; 
		
		echo $query_oppo_tip = "select tbl_opportunities.OpportunityID  from tbl_opportunities 
		where tbl_opportunities.OpportunityName = '".$rows['ONAME']."' and tbl_opportunities.Copied = 1 ";
		$result_oppo_tip = $mysqli -> query($query_oppo_tip); 
		if($result_oppo_tip){   
			if( $result_oppo_tip->num_rows>0){ 		 
				while($rows_oppo_tip = $result_oppo_tip -> fetch_assoc()){
 			
				echo $Insert_Oppo ="insert into `tbl_opportunity_tip`  
				set    `OpportunityID` = '".$rows_oppo_tip['OpportunityID']."', 
				`TipID` = '".$rows['TipID']."', 
				`TipRefNo` = '".$rows['TipRefNo']."', 
				`Status` = '".$rows['Status']."',  
				`Copied` = '1'   ";  
				$result_oppo = $mysqli -> query($Insert_Oppo);  
				  
				echo "<br>=========<br>";   
				$k = $k+1;  
				
				}
			}
		}	
	} 
}	

echo "Total =====>>> Total Recordss : ".$k."  <br> ";	  
echo "Updated =====>>> Updated : ".$j."  <br> ";
 		 
exit; 
?>   