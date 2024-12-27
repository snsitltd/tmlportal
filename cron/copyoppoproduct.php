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
 
echo $query = "select tbl_product.*, tbl_opportunities.OpportunityName as ONAME
from tbl_product  
join tbl_company_to_opportunities  on  tbl_product.OpportunityID =  tbl_company_to_opportunities.OpportunityID 
join tbl_opportunities  on tbl_product.OpportunityID  = tbl_opportunities.OpportunityID 
where tbl_company_to_opportunities.CompanyID = '".$CompanyID."'    
order by tbl_product.productid  ASC "; 

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
 			
				echo $Insert_Oppo ="insert into `tbl_product`  
				set    `OpportunityID` = '".$rows_oppo_tip['OpportunityID']."', 
				`PRODUCTSERVICEID` = '".$rows['PRODUCTSERVICEID']."', 
				`BookingID` = '".$rows['BookingID']."', 
				`BookingDateID` = '".$rows['BookingDateID']."', 
				`MaterialID` = '".$rows['MaterialID']."',
				`LorryType` = '".$rows['LorryType']."', 
				`SICCode` = '".$rows['SICCode']."',
				`ProductCode` = '".$rows['ProductCode']."',
				`ItemType` = '".$rows['ItemType']."',
				`unitcost` = '".$rows['unitcost']."',
				`UnitPrice` = '".$rows['UnitPrice']."',
				`UnitDiscount` = '".$rows['UnitDiscount']."',
				`DiscountTypeNum` = '".$rows['DiscountTypeNum']."',
				`DiscountPrice` = '".$rows['DiscountPrice']."',
				`ExtendedAmount` = '".$rows['ExtendedAmount']."',
				`Description` = '".$rows['Description']."',
				`Qty` = '".$rows['Qty']."',
				`PriceType` = '".$rows['PriceType']."',
				`TotalTon` = '".$rows['TotalTon']."',
				`DateRequired` = '".$rows['DateRequired']."',
				`PurchaseOrderNo` = '".$rows['PurchaseOrderNo']."',
				`JobNo` = '".$rows['JobNo']."',
				`Comments` = '".$rows['Comments']."',
				`ProductInfo` = '".$rows['ProductInfo']."',
				`type` = '".$rows['type']."',
				`unitofissue` = '".$rows['unitofissue']."',
				`picture` = '".$rows['picture']."',
				`CUST_Angelasfield_033649899` = '".$rows['CUST_Angelasfield_033649899']."',
				`CUST_OtherComments_011412974` = '".$rows['CUST_OtherComments_011412974']."',
				`CUST_JobNo_040647796` = '".$rows['CUST_JobNo_040647796']."',
				`CUST_Quote_031832710` = '".$rows['CUST_Quote_031832710']."',
				`CUST_DateRequired_080250490` = '".$rows['CUST_DateRequired_080250490']."',
				`DISCOUNTTYPE` = '".$rows['DISCOUNTTYPE']."',
				`isAct` = '".$rows['isAct']."',
				`CreateUserID` = '".$rows['CreateUserID']."',
				`EditUserID` = '".$rows['EditUserID']."',   
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