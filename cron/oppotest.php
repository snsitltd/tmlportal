<?php
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
     $dbhost='213.175.208.242'; 
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
	$q = "select convert(varchar(255),OPPORTUNITYID) as OPPORTUNITYID, NAME, CONVERT(varchar,OPENDATE,23) as OPENDATE,CONVERT(varchar,ESTIMATEDCLOSEDATE,23) as ESTIMATEDCLOSEDATE,	CREATEDATE ,EDITDATE ,
	 CUST_PriceAgreed_032329203, CUST_SiteContact_032533311, CUST_Pricing_034825177, CUST_TipTicketsSent_011703706, CUST_NewField1_012315449, CUST_NameoftheTip_012924016,
	 BINARY_CHECKSUM(CUST_Mobile_015736621) as CUST_Mobile_015736621, CUST_TIPNAME_020653404, CUST_SpecialRequirements_020904643, CUST_AccountDepartmentNotes_045723254, CUST_TipTickets_025820907, CUST_Stamp_030147297,
	 CUST_POrequired_030924009, CUST_SiteInstructionsNote_081744750, CUST_SiteInstructionsRequire_082121809, CUST_SiteContactName_024406636, CUST_StampDetails_103018148, 	 CUST_WIFRequired_111358217, CUST_WIF_111623654	
	from [Thames2013].[dbo].[TBL_OPPORTUNITY] where BINARY_CHECKSUM(CUST_Mobile_015736621) <> ''  ";
	$sql = sqlsrv_query($link, $q);
	
	while ( $ls = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {  
		$k = $k+1;   
		
		$query = ""; $result = ""; $rows = ""; $insertQuery = ""; $result1 = ""; 
		$query = "select CUST_Mobile_015736621 from tbl_opportunities  where OpportunityID ='".$mysqli -> real_escape_string($ls['OPPORTUNITYID'])."'  ";
		$result = $mysqli -> query($query); 
		if($result){
			$rows = $result -> fetch_row();  	
        
			//if($rows[0]!=''){  
				 
				echo $updateQuery ="update `tbl_opportunities` set  
				`CUST_Mobile_015736621` = '".$mysqli -> real_escape_string($ls['CUST_Mobile_015736621'])."' 
				where OpportunityID ='".$mysqli -> real_escape_string($ls['OPPORTUNITYID'])."' ";
				echo "<br><br><br>";
				//$result2 = $mysqli -> query($updateQuery); 
				if($result2){ $j = $j+1; } 
			//} 		      
		}	
	} 
	echo "Total =====>>> Total Record : ".$k."  <br> ";	  
	echo "Updated =====>>> Updated : ".$j."  <br> ";
exit; 
?>  