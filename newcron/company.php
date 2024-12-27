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
    //$dbhost='109.75.161.249'; 
    //$dbuser='yogi_tml';
    //$dbpass='qmw7V7vEiT3C';
	//$db='yogi_tml'; 
	
	$dbhost='109.75.161.249'; 
    $dbuser='projects_tmldemo';
    $dbpass='panchal12345';
	$db='projects_tmldemo'; 
	
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	} 
	############################################
	
	$i = 0;  $j = 0;   $k = 0;
	$q ="select ta.LINE1, ta.LINE2, ta.LINE3, ta.CITY, ta.STATE, ta.POSTALCODE, ta.COUNTRYNAME, convert(varchar(255), tc.COMPANYID) as COMPANYID , 
	tc.NAME, tc.CREATEDATE, convert(varchar(255), tc.EDITUSERID) as EDITUSERID, tc.EDITDATE,tc.CUST_AC_034611129,
	tc.CUST_Phone2_035624061, tc.CUST_EmailAddress_041412439, tc.CUST_Tradename_042305532, tc.CUST_CompanyStatus_045933488	
	from [Thames2013].[dbo].[TBL_COMPANY] tc INNER JOIN  [Thames2013].[dbo].[TBL_ADDRESS] ta on tc.COMPANYID = ta.COMPANYID  order by tc.CreateDate ASC ";	 
    $sql = sqlsrv_query($link, $q);
  
	if($sql){
	while ( $ls = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {  
		$k = $k+1;    
		$query = ""; $result = ""; $rows = ""; $insertQuery = ""; $result1 = ""; 
		$query = "select count(*) from tbl_company  where CompanyID ='".$mysqli -> real_escape_string($ls['COMPANYID'])."'  ";
		$result = $mysqli -> query($query); 
		if($result){ 
			$rows = $result -> fetch_row(); 
				
				if($ls['CREATEDATE']!=""){
					$obj = (array)$ls['CREATEDATE']; 
					$cd = ''; $cd = explode('.',$obj['date']);
					$ls['CREATEDATE'] = $cd[0];
        		}
				if($ls['EDITDATE']!="" ){				
					$obj1 = (array)$ls['EDITDATE']; 
					$ed = ''; $ed = explode('.',$obj1['date']);
					$ls['EDITDATE'] = $ed[0]; 
				}	
        
			if($rows[0]==0){ 
				$insertQuery ="INSERT INTO `tbl_company` set `CompanyID` = '".$mysqli -> real_escape_string($ls['COMPANYID'])."', `isAct` = '1',
				`CompanyIDMapKey` = '".$mysqli -> real_escape_string($ls['COMPANYID'])."', 
				`CompanyName` = '".$mysqli -> real_escape_string($ls['NAME'])."' ,
				`AccountRef` = '".$mysqli -> real_escape_string($ls['CUST_AC_034611129'])."', 
				`CreateDate` =  '".trim($ls['CREATEDATE'])."', 
				`EditUserID` = '".$mysqli -> real_escape_string($ls['EDITUSERID'])."', 
				`EditUserDate` =  '".trim($ls['EDITDATE'])."',
				`CUST_Phone2_035624061` = '".$mysqli -> real_escape_string($ls['CUST_Phone2_035624061'])."', 
				`CUST_EmailAddress_041412439` = '".$mysqli -> real_escape_string($ls['CUST_EmailAddress_041412439'])."', 
				`CUST_Tradename_042305532` = '".$mysqli -> real_escape_string($ls['CUST_Tradename_042305532'])."', 
				`CUST_CompanyStatus_045933488` = '".$mysqli -> real_escape_string($ls['CUST_CompanyStatus_045933488'])."'  ,
				`Street1` = '".$mysqli -> real_escape_string($ls['LINE1'])."',  
				`Street2` = '".$mysqli -> real_escape_string($ls['LINE2'])."',  
				`Town` = '".$mysqli -> real_escape_string($ls['CITY'])."',  
				`County` = '".$mysqli -> real_escape_string($ls['STATE'])."',  
				`PostCode` = '".$mysqli -> real_escape_string($ls['POSTALCODE'])."',  
				`Country` = '".$mysqli -> real_escape_string($ls['COUNTRYNAME'])."' ";
				
				/*$insertQuery ="INSERT INTO `tbl_company`(`CompanyID`, `CompanyIDMapKey`, `CompanyName`, `AccountRef`, `CreateDate`, `EditUserID`, `EditUserDate`,
				 `CUST_Phone2_035624061`, `CUST_EmailAddress_041412439`, `CUST_Tradename_042305532`, `CUST_CompanyStatus_045933488` ,`isAct`,`Street1`,`Street2`,`Town`
				,`County`,`PostCode`,`Country`  ) 
				values ('".$ls['COMPANYID']."','".mysqli_real_escape_string($conn1,$ls['COMPANYID'])."','".mysqli_real_escape_string($conn1,$ls['NAME'])."',
				'".mysqli_real_escape_string($conn1,$ls['CUST_AC_034611129'])."', '".mysqli_real_escape_string($conn1,$ls['CREATEDATE'])."',
				'".mysqli_real_escape_string($conn1,$ls['EDITUSERID'])."', '".mysqli_real_escape_string($conn1,$ls['EDITDATE'])."',
				'".mysqli_real_escape_string($conn1,$ls['CUST_Phone2_035624061'])."', '".mysqli_real_escape_string($conn1,$ls['CUST_EmailAddress_041412439'])."',
				'".mysqli_real_escape_string($conn1,$ls['CUST_Tradename_042305532'])."', '".mysqli_real_escape_string($conn1,$ls['CUST_CompanyStatus_045933488'])."', '1',
				'".mysqli_real_escape_string($conn1,$ls['LINE1'])."','".mysqli_real_escape_string($conn1,$ls['LINE2'])."',
				'".mysqli_real_escape_string($conn1,$ls['CITY'])."','".mysqli_real_escape_string($conn1,$ls['STATE'])."',
				'".mysqli_real_escape_string($conn1,$ls['POSTALCODE'])."','".mysqli_real_escape_string($conn1,$ls['COUNTRYNAME'])."' )"; */
				 
				$result1 = $mysqli -> query($insertQuery); 
				if($result1){ $i = $i+1; }
			}else{ 
			    
			    //echo $ls['CREATEDATE']; 
			    //echo $ls['EDITDATE'];
				 $updateQuery ="update `tbl_company` set `CompanyID` = '".$mysqli -> real_escape_string($ls['COMPANYID'])."', `isAct` = '1',
				`CompanyIDMapKey` = '".$mysqli -> real_escape_string($ls['COMPANYID'])."', 
				`CompanyName` = '".$mysqli -> real_escape_string($ls['NAME'])."' ,
				`AccountRef` = '".$mysqli -> real_escape_string($ls['CUST_AC_034611129'])."', 
				`CreateDate` =  '".$mysqli -> real_escape_string(trim($ls['CREATEDATE']))."', 
				`EditUserID` = '".$mysqli -> real_escape_string($ls['EDITUSERID'])."', 
				`EditUserDate` =  '".$mysqli -> real_escape_string(trim($ls['EDITDATE']))."',
				`CUST_Phone2_035624061` = '".$mysqli -> real_escape_string($ls['CUST_Phone2_035624061'])."', 
				`CUST_EmailAddress_041412439` = '".$mysqli -> real_escape_string($ls['CUST_EmailAddress_041412439'])."', 
				`CUST_Tradename_042305532` = '".$mysqli -> real_escape_string($ls['CUST_Tradename_042305532'])."', 
				`CUST_CompanyStatus_045933488` = '".$mysqli -> real_escape_string($ls['CUST_CompanyStatus_045933488'])."'  ,
				`Street1` = '".$mysqli -> real_escape_string($ls['LINE1'])."',  
				`Street2` = '".$mysqli -> real_escape_string($ls['LINE2'])."',  
				`Town` = '".$mysqli -> real_escape_string($ls['CITY'])."',  
				`County` = '".$mysqli -> real_escape_string($ls['STATE'])."',  
				`PostCode` = '".$mysqli -> real_escape_string($ls['POSTALCODE'])."',  
				`Country` = '".$mysqli -> real_escape_string($ls['COUNTRYNAME'])."'    
				where CompanyID ='".$mysqli -> real_escape_string($ls['COMPANYID'])."' "; 
			
				$result2 = $mysqli -> query($updateQuery); 
				if($result2){ $j = $j+1; } 
			} 	    
		}	
	}
	echo "Total =====>>> Total Record : ".$k."  <br> ";	 
	echo "Inserted =====>>> Inserted : ".$i."  <br> ";	 
	echo "Updated =====>>> Updated : ".$j."  <br> ";
	
	}else{
			echo "ERROR";
	}
		 
exit; 
?>   