<?php
exit;
	error_reporting(E_ALL);   
	############ MSSQL CONNECTION #############  
	$serverName = "193.117.210.98\ACT7,1533"; //serverName\instanceName, portNumber (default is 1433)
	$db = "Thames2013";
	$UID = "hemal";
	$PWD = "@62uwFdfE";
	$connectionInfo = array( "Database"=>$db, "UID"=>$UID, "PWD"=>$PWD);
	$link = sqlsrv_connect( $serverName, $connectionInfo);  
	if( $link ) {
		 //echo "Connection established.<br />";
	}else{
		 echo "Connection could not be established.<br />";
		 die( print_r( sqlsrv_errors(), true));
	}   
	###########################################  
	############ MYSQL CONNECTION #############
    $dbhost='localhost'; 
    $dbuser='tmlsnslt_tml';
    $dbpass='qmw7V7vEiT3C';
	$db='tmlsnslt_tml';
	
	//$dbhost='109.75.161.249'; 
    //$dbuser='projects_tmldemo';
    //$dbpass='panchal12345';
	//$db='projects_tmldemo'; 
	
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	} 
	############################################
	 
	$i = 0;  $j = 0;   $k = 0;   
	/*$q = "select convert(varchar(255),OPPORTUNITYID) as OPPORTUNITYID, 
	NAME, CONVERT(varchar,OPENDATE,23) as OPENDATE,CONVERT(varchar,ESTIMATEDCLOSEDATE,23) as ESTIMATEDCLOSEDATE,	CREATEDATE ,EDITDATE ,
	CUST_PriceAgreed_032329203, CUST_SiteContact_032533311, CUST_Pricing_034825177, CUST_TipTicketsSent_011703706, CUST_NewField1_012315449, CUST_NameoftheTip_012924016,
	CUST_Mobile_015736621, CUST_TIPNAME_020653404, CUST_SpecialRequirements_020904643, CUST_AccountDepartmentNotes_045723254, CUST_TipTickets_025820907, CUST_Stamp_030147297,
	CUST_POrequired_030924009, CUST_SiteInstructionsNote_081744750, CUST_SiteInstructionsRequire_082121809, CUST_SiteContactName_024406636, CUST_StampDetails_103018148, 	 CUST_WIFRequired_111358217, CUST_WIF_111623654	
	from [Thames2013].[dbo].[TBL_OPPORTUNITY_PRODUCTSERVICE] join "; */
	
	$q = "SELECT convert(varchar(255),tops.OPPORTUNITYID) as OPPORTUNITYID  
	,tps.PRODUCTSERVICEID
	,[NAME]
	,[ITEMCODE]
	,[ITEMTYPE]
	,[QUANTITY]
	,[UNITCOST]
	,[UNITPRICE]
	,[UNITDISCOUNT]
	,[DISCOUNTTYPENUM]
	,[DISCOUNTPRICE]
	,[EXTENDEDAMT] 
	,[CREATEDATE] 
	,[EDITDATE]
	,[CUST_Angelasfield_033649899]
	,[CUST_OtherComments_011412974]
	,[CUST_JobNo_040647796]
	,[CUST_ItemDescription_101053158]
	,[CUST_Quote_031832710]
	,[CUST_DateRequired_080250490]
	,[DISCOUNTTYPE]
	FROM [Thames2013].[dbo].[TBL_PRODUCTSERVICE] as tps
	LEFT JOIN [Thames2013].[dbo].[OPPORTUNITY_PRODUCTSERVICE] as tops ON 
	tps.PRODUCTSERVICEID = tops.PRODUCTSERVICEID ";
	 
	$sql = sqlsrv_query($link, $q);
	
	while ( $ls = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {  
		//var_dump($ls);
		 
		$k = $k+1;    
		
		$query = ""; $result = ""; $rows = ""; $insertQuery = ""; $result1 = ""; 
		$query = "select count(*) as cnt from tbl_product  where PRODUCTSERVICEID ='".$mysqli -> real_escape_string($ls['PRODUCTSERVICEID'])."'  ";
		$result = $mysqli -> query($query); 
		if($result){
			$rows = $result ->fetch_array(MYSQLI_ASSOC);
			//echo $rows['cnt'];
			if($ls['CUST_DateRequired_080250490']!=""){
				$obj = (array)$ls['CUST_DateRequired_080250490']; 
				$cd = ''; 
				$cd = explode('.',$obj['date']);
				
				$cd1 = ''; 
				$cd1 = explode(' ',$cd[0]);
				
				$ls['CUST_DateRequired_080250490'] = $cd1[0];
			}
			//echo "<br><br>"; 
			$queryM = "select MaterialID  from tbl_materials  where MaterialCode = '".$mysqli -> real_escape_string(trim($ls['ITEMCODE']))."' ";
			$resultM = $mysqli -> query($queryM); 
			if($resultM){
				$rowsM = $resultM ->fetch_array(MYSQLI_ASSOC);
			} 
			if($rows['cnt']==0){   
				$insertQuery ="INSERT INTO  `tbl_product` set `PRODUCTSERVICEID` = '".trim($ls['PRODUCTSERVICEID'])."', `isAct` = '1',  
				`OpportunityID` = '".$mysqli -> real_escape_string(trim($ls['OPPORTUNITYID']))."',
				`MaterialName` = '".$mysqli -> real_escape_string(trim($ls['NAME']))."',
				`MaterialID` = '".$rowsM['MaterialID']."',
				`ProductCode` = '".$mysqli -> real_escape_string(trim($ls['ITEMCODE']))."',
				`ItemType` = '".$mysqli -> real_escape_string(trim($ls['ITEMTYPE']))."',
				`unitcost` = '".$mysqli -> real_escape_string(trim($ls['UNITCOST']))."',
				`UnitPrice` = '".$mysqli -> real_escape_string(trim($ls['UNITPRICE']))."',
				`UnitDiscount` = '".$mysqli -> real_escape_string(trim($ls['UNITDISCOUNT']))."',
				`DiscountTypeNum` = '".$mysqli -> real_escape_string(trim($ls['DISCOUNTTYPENUM']))."',
				`DiscountPrice` = '".$mysqli -> real_escape_string(trim($ls['DISCOUNTPRICE']))."',
				`ExtendedAmount` = '".$mysqli -> real_escape_string(trim($ls['EXTENDEDAMT']))."',  
				`CUST_Angelasfield_033649899` = '".$mysqli -> real_escape_string(trim($ls['CUST_Angelasfield_033649899']))."',
				`CUST_OtherComments_011412974` = '".$mysqli -> real_escape_string($ls['CUST_OtherComments_011412974'])."',
				`CUST_JobNo_040647796` = '".$mysqli -> real_escape_string($ls['CUST_JobNo_040647796'])."',
				`Description` = '".$mysqli -> real_escape_string($ls['CUST_ItemDescription_101053158'])."',
				`CUST_Quote_031832710` = '".$mysqli -> real_escape_string($ls['CUST_Quote_031832710'])."',
				`DISCOUNTTYPE` = '".$mysqli -> real_escape_string($ls['DISCOUNTTYPE'])."',  
				`DateRequired` = '".$ls['CUST_DateRequired_080250490']."' ";
				 
				$result1 = $mysqli -> query($insertQuery); 
				if($result1){ $i = $i+1; }
			}else{ 
				$updateQuery ="update `tbl_product` set `isAct` = '1',  
				`OpportunityID` = '".$mysqli -> real_escape_string(trim($ls['OPPORTUNITYID']))."',
				`MaterialName` = '".$mysqli -> real_escape_string(trim($ls['NAME']))."',
				`MaterialID` = '".$rowsM['MaterialID']."',
				`ProductCode` = '".$mysqli -> real_escape_string(trim($ls['ITEMCODE']))."',
				`ItemType` = '".$mysqli -> real_escape_string(trim($ls['ITEMTYPE']))."',
				`unitcost` = '".$mysqli -> real_escape_string(trim($ls['UNITCOST']))."',
				`UnitPrice` = '".$mysqli -> real_escape_string(trim($ls['UNITPRICE']))."',
				`UnitDiscount` = '".$mysqli -> real_escape_string(trim($ls['UNITDISCOUNT']))."',
				`DiscountTypeNum` = '".$mysqli -> real_escape_string(trim($ls['DISCOUNTTYPENUM']))."',
				`DiscountPrice` = '".$mysqli -> real_escape_string(trim($ls['DISCOUNTPRICE']))."',
				`ExtendedAmount` = '".$mysqli -> real_escape_string(trim($ls['EXTENDEDAMT']))."',  
				`CUST_Angelasfield_033649899` = '".$mysqli -> real_escape_string(trim($ls['CUST_Angelasfield_033649899']))."',
				`CUST_OtherComments_011412974` = '".$mysqli -> real_escape_string($ls['CUST_OtherComments_011412974'])."',
				`CUST_JobNo_040647796` = '".$mysqli -> real_escape_string($ls['CUST_JobNo_040647796'])."',
				`Description` = '".$mysqli -> real_escape_string($ls['CUST_ItemDescription_101053158'])."',
				`CUST_Quote_031832710` = '".$mysqli -> real_escape_string($ls['CUST_Quote_031832710'])."',
				`DISCOUNTTYPE` = '".$mysqli -> real_escape_string($ls['DISCOUNTTYPE'])."',  
				`DateRequired` = '".$ls['CUST_DateRequired_080250490']."' 
				where PRODUCTSERVICEID =  '".trim($ls['PRODUCTSERVICEID'])."' ";
				$result2 = $mysqli -> query($updateQuery); 
				if($result2){ $j = $j+1; } 
			} 	 
		}	 
	} 
	echo "Total =====>>> Total Record : ".$k."  <br> ";	 
	echo "Inserted =====>>> Inserted : ".$i."  <br> ";	 
	echo "Updated =====>>> Updated : ".$j."  <br> ";
exit; 
?>  