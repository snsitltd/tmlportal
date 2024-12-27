<?php
	error_reporting(E_ALL);   
    //$dbhost='localhost'; 
    //$dbuser='yogi_tml';
    //$dbpass='qmw7V7vEiT3C';
	//$db='yogi_tml'; 
	
	$dbhost='localhost'; 
    $dbuser='root';
    $dbpass='';
	$db='tml'; 
	
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	} 
	  
	//print('<PRE>');
	//var_dump($ls);	
	//print('</PRE>');	
	$j =0; 
	$query = "select LorryNo, ltsignature from tbl_drivers order by LorryNo desc ";
	$result = $mysqli -> query($query); 
	if($result){ 
		while($rows = $result -> fetch_array(MYSQLI_ASSOC)){ 
			if($rows['ltsignature']!=""){
				$driversignature1 = ''; $Signature=''; 
				$driversignature1 = str_replace('data:image/png;base64,', '', $rows['ltsignature']);
				$driversignature1 = str_replace(' ', '+', $driversignature1); 
				$driversignature1 = base64_decode($driversignature1);
				
				$Signature = 'Lorry-'.$rows['LorryNo'].'_'.md5($rows['LorryNo']).".png"; 
				$file_name = $_SERVER['DOCUMENT_ROOT'].'/assets/DriverSignature/'.$Signature;
				file_put_contents($file_name,$driversignature1); 
				
				$updateQuery ="update `tbl_drivers` set `Signature` = '".$Signature."' where LorryNo ='".$rows['LorryNo']."' ";
				$result2 = $mysqli -> query($updateQuery);  
				if($result2){ $j = $j+1; }  			   
			}	
		}
	}	
	 echo $j; 
		 
exit; 
?> 





















