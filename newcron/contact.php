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
	$q= "select convert(varchar(255), CONTACTID) as CONTACTID, FULLNAME,  JOBTITLE,DEPARTMENT, CREATEDATE, convert(varchar(255), CREATEUSERID) as CREATEUSERID,
	EDITDATE, convert(varchar(255), EDITUSERID) as EDITUSERID, convert(varchar(255), COMPANYID) as COMPANYID, COMPANYNAME, CONTACTWEBADDRESS, 
	CUST_AccountReferenceNumber_014126697, CUST_Title_012223045	
	from [Thames2013].[dbo].[TBL_CONTACT] order by CREATEDATE ASC";
	$sql = sqlsrv_query($link, $q);
	while ( $ls = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {   
	$k = $k+1;    
		$query = ""; $result = ""; $rows = ""; $insertQuery = ""; $result1 = ""; 
		$query = "select count(*) from tbl_contacts  where ContactID ='".$mysqli -> real_escape_string(trim($ls['CONTACTID']))."'  ";
		$result = $mysqli -> query($query); 
		if($result){
			$rows = $result -> fetch_row();  
			if($rows[0]==0){ 
				$insertQuery ="INSERT INTO `tbl_contacts`(`ContactID`, `ContactIDMapKey`, `ContactName`, `Position`, `Department`, `CreateDate`,`CreateUserID`, `EditUserDate`, `EditUserID`,
				`COMPANYID`,`COMPANYNAME`,`CONTACTWEBADDRESS`,`CUST_AccountReferenceNumber_014126697`,`CUST_Title_012223045`,`isAct` ) 
				values ('".$mysqli -> real_escape_string(trim($ls['CONTACTID']))."',
				'".$mysqli -> real_escape_string(trim($ls['CONTACTID']))."',
				'".$mysqli -> real_escape_string(trim($ls['FULLNAME']))."',
				'".$mysqli -> real_escape_string(trim($ls['JOBTITLE']))."',
				'".$mysqli -> real_escape_string(trim($ls['DEPARTMENT']))."',
				'".$mysqli -> real_escape_string(trim($ls['CREATEDATE']))."',
				'".$mysqli -> real_escape_string(trim($ls['CREATEUSERID']))."',
				'".$mysqli -> real_escape_string(trim($ls['EDITDATE']))."',
				'".$mysqli -> real_escape_string(trim($ls['EDITUSERID']))."',
				'".$mysqli -> real_escape_string(trim($ls['COMPANYID']))."',
				'".$mysqli -> real_escape_string(trim($ls['COMPANYNAME']))."',
				'".$mysqli -> real_escape_string(trim($ls['CONTACTWEBADDRESS']))."',
				'".$mysqli -> real_escape_string(trim($ls['CUST_AccountReferenceNumber_014126697']))."',
				'".$mysqli -> real_escape_string(trim($ls['CUST_Title_012223045']))."' , '1' )";
				$result1 = $mysqli -> query($insertQuery); 
				if($result1){ $i = $i+1; }
			}else{
				$updateQuery ="update `tbl_contacts` set `ContactID` = '".$ls['CONTACTID']."', `isAct` = '1',
				`ContactIDMapKey` = '".$mysqli -> real_escape_string(trim($ls['CONTACTID']))."', 
				`ContactName` = '".$mysqli -> real_escape_string(trim($ls['FULLNAME']))."' ,
				`Position` = '".$mysqli -> real_escape_string(trim($ls['JOBTITLE']))."', 
				`Department` =  '".$mysqli -> real_escape_string(trim($ls['DEPARTMENT']))."', 
				`CreateDate` = '".$mysqli -> real_escape_string(trim($ls['CREATEDATE']))."', 
				`CreateUserID` =  '".$mysqli -> real_escape_string(trim($ls['CREATEUSERID']))."',
				`EditUserDate` = '".$mysqli -> real_escape_string(trim($ls['EDITDATE']))."', 
				`EditUserID` = '".$mysqli -> real_escape_string(trim($ls['EDITUSERID']))."', 
				`COMPANYID` = '".$mysqli -> real_escape_string(trim($ls['COMPANYID']))."', 
				`COMPANYNAME` = '".$mysqli -> real_escape_string(trim($ls['COMPANYNAME']))."',  
				`CONTACTWEBADDRESS` = '".$mysqli -> real_escape_string(trim($ls['CONTACTWEBADDRESS']))."',
				`CUST_AccountReferenceNumber_014126697` = '".$mysqli -> real_escape_string(trim($ls['CUST_AccountReferenceNumber_014126697']))."',
				`CUST_Title_012223045` = '".$mysqli -> real_escape_string(trim($ls['CUST_Title_012223045']))."' 
				where ContactID ='".$mysqli -> real_escape_string(trim($ls['CONTACTID']))."' ";
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