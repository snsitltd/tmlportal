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
	$q="select convert(varchar(255), COMPANYID) as COMPANYID, convert(varchar(255), CONTACTID) as CONTACTID  
	from [Thames2013].[dbo].[TBL_COMPANY_CONTACT] ";
	$sql = sqlsrv_query($link, $q);
	while ( $ls = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {  
	$k = $k+1;    
		$query = ""; $result = ""; $rows = ""; $insertQuery = ""; $result1 = ""; 
		$query = "select count(*) as cnt from tbl_company_to_contact 
		where CompanyID ='".$mysqli -> real_escape_string(trim($ls['COMPANYID']))."' 
		AND ContactID ='".$mysqli -> real_escape_string(trim($ls['CONTACTID']))."'";
		$result = $mysqli -> query($query); 
		if($result){
			$rows = $result -> fetch_row(); 
			if($rows[0]==0){ 
				$insertQuery ="INSERT INTO `tbl_company_to_contact`(`CompanyID`, `ContactID` ) 
				values ('".$mysqli -> real_escape_string(trim($ls['COMPANYID']))."',
				'".$mysqli -> real_escape_string(trim($ls['CONTACTID']))."')";
				$result1 = $mysqli -> query($insertQuery);  
				if($result1){ $i = $i+1; }
			}else{
				$updateQuery ="update `tbl_company_to_contact` set `CompanyID` = '".$ls['COMPANYID']."', 
				`ContactID` = '".$mysqli -> real_escape_string(trim($ls['CONTACTID']))."'   
				where CompanyID ='".$mysqli -> real_escape_string(trim($ls['COMPANYID']))."' 
				AND ContactID ='".$mysqli -> real_escape_string(trim($ls['CONTACTID']))."' ";
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