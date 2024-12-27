<?php
error_reporting(E_ALL);
//error_reporting(0);
$time_start = microtime(true);

$serverName = "193.117.210.98\MSSQLSERVER,1433"; //serverName\instanceName, portNumber (default is 1433)
$db = "FD_123E60A8";
$UID = "hemal";
$PWD = "62uwFdfE";
$connectionInfo = array( "Database"=>$db, "UID"=>$UID, "PWD"=>$PWD);
$conn = sqlsrv_connect( $serverName, $connectionInfo);  

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}  

	//$dbhost = 'localhost';
	//$dbuser = 'hemalj_new';
	//$dbpass = 'online123'; 
	//$db = 'accounts';

	$dbhost='213.175.208.242'; 
	$dbuser='tmlsnslt_tml';
	$dbpass='qmw7V7vEiT3C';
	$db='tmlsnslt_tml';
	
	
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db); 

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
	$i = 0;  $j = 0;   $k = 0;
	//$q ="SELECT  [GUID] ,[DocTypeID],[LastModifiedOn],[CreatedOn],[FD_650A620E],[FD_16EB2AD9]  FROM [FD_123E60A8].[dbo].[FD_Documents] where ( FD_650A620E != '' || FD_16EB2AD9 != '' ) ";	 
	$q ="SELECT  [GUID] ,[DocTypeID],[LastModifiedOn],[CreatedOn],[FD_650A620E],[FD_16EB2AD9]  FROM [FD_123E60A8].[dbo].[FD_Documents]";	 
    $sql = sqlsrv_query($conn, $q);
  
	if($sql){
	while ( $ls = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {  
		$k = $k+1;    
		$query = ""; $result = ""; $rows = ""; $insertQuery = ""; $result1 = ""; 
		$query = "select count(*) from  tbl_tickets_documents  where GUID ='".$mysqli -> real_escape_string($ls['GUID'])."'  ";
		$result = $mysqli -> query($query); 
		if($result){ 
			$rows = $result -> fetch_row();  
				if($ls['CreatedOn']!=""){
					$obj = (array)$ls['CreatedOn']; 
					$cd = ''; $cd = explode('.',$obj['date']);
					$ls['CreatedOn'] = $cd[0];
        		}
				if($ls['LastModifiedOn']!="" ){				
					$obj1 = (array)$ls['LastModifiedOn']; 
					$ed = ''; $ed = explode('.',$obj1['date']);
					$ls['LastModifiedOn'] = $ed[0]; 
				}	
        
			if($rows[0]==0){ 
				$insertQuery ="INSERT INTO `tbl_tickets_documents` set 
				`GUID` = '".$mysqli -> real_escape_string($ls['GUID'])."', 
				`DocTypeID` = '".$mysqli -> real_escape_string($ls['DocTypeID'])."', 
				`FD_650A620E` = '".$mysqli -> real_escape_string($ls['FD_650A620E'])."', 
				`FD_16EB2AD9` = '".$mysqli -> real_escape_string($ls['FD_16EB2AD9'])."', 
				`CreatedOn` =  '".trim($ls['CreatedOn'])."',
				`LastModifiedOn` =  '".trim($ls['LastModifiedOn'])."'  ";
				  
				$result1 = $mysqli -> query($insertQuery); 
				if($result1){ $i = $i+1; }
			}else{  
				$updateQuery ="update `tbl_company` set 
				`GUID` = '".$mysqli -> real_escape_string($ls['GUID'])."', 
				`DocTypeID` = '".$mysqli -> real_escape_string($ls['DocTypeID'])."', 
				`FD_650A620E` = '".$mysqli -> real_escape_string($ls['FD_650A620E'])."', 
				`FD_16EB2AD9` = '".$mysqli -> real_escape_string($ls['FD_16EB2AD9'])."', 
				`CreatedOn` =  '".trim($ls['CreatedOn'])."',
				`LastModifiedOn` =  '".trim($ls['LastModifiedOn'])."'     
				where GUID ='".$mysqli -> real_escape_string($ls['GUID'])."' "; 
			
				$result2 = $mysqli -> query($updateQuery); 
				if($result2){ $j = $j+1; } 
			} 	    
		}	
	}
	echo "Total =====>>> Total Recordss : ".$k."  <br> ";	 
	echo "Inserted =====>>> Inserted : ".$i."  <br> ";	 
	echo "Updated =====>>> Updated : ".$j."  <br> ";
	
	}else{
			echo "ERROR";
	}
	
?>
