<?php
	$dbhost='213.175.208.242'; 
    $dbuser='tmlsnslt_tml';
    $dbpass='qmw7V7vEiT3C';
	$db='tmlsnslt_tml';
	
	//$dbhost='localhost'; 
    //$dbuser='root';
    //$dbpass='';
	//$db='tml';
	 
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	} 
	 
$url = "http://193.117.210.98:5495/sdata/accounts50/GCRM/%7B6447298A-F14B-48EA-9EAC-A3955968B321%7D/tradingAccounts?select=reference&count=10000&format=json"; 

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Authorization: Basic YWN0OmFjdA==",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$jcode = curl_exec($curl);
curl_close($curl);
  
$jcode =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', stripslashes(html_entity_decode(rtrim($jcode, "\0")))), true ); 

//echo $jcode['$uuid'];
//echo "<PRE>";  
//print_r($jcode);	
//echo "</PRE>";  
//exit;
$j =0; $k =0;
foreach($jcode['$resources'] as $item) { //foreach element in $arr
		
		$query = ""; $result = ""; $rows = ""; $insertQuery = ""; $result1 = ""; 
		$query = "select AccountRef, CompanyID from tbl_company  where AccountRef ='".$item['reference']."'  ";
		$result = $mysqli -> query($query); 
		if($result){  
			if($result->num_rows>0){
				$rows = $result -> fetch_assoc();
				if(trim($rows['CompanyID'])!=""){   
					//echo $updateQuery ="update `tbl_company` set `SageURL` = '".str_replace('atomentry','json',str_replace('tml-server','193.117.210.98',$item['$url']))."', `SageUUID` = '".$item['$uuid']."' 
					//where CompanyID ='".$mysqli -> real_escape_string($rows['CompanyID'])."' ";  				
					//echo "<br>";
					//$result2 = $mysqli -> query($updateQuery); 
					if($result2){ $j = $j+1; }   
					$j = $j+1;
				}	  
			}else{
					//echo "Insert ";
					//echo $updateQuery ="update `tbl_company` set `SageURL` = '".str_replace('atomentry','json',str_replace('tml-server','193.117.210.98',$item['$url']))."', `SageUUID` = '".$item['$uuid']."' 
					//where CompanyID ='".$mysqli -> real_escape_string($rows['CompanyID'])."' ";  				
					//$result2 = $mysqli -> query($updateQuery); 
//					if($result2){ $k = $k+1; }   
				$k = $k+1;
			}	
		}
		 
}

echo "Updated Company Records : ". $j; 
echo "<br><br>Inserted Company Records : ". $k; 

  
?>
