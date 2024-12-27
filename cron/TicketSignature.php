<?php
	error_reporting(E_ALL);   
     
	//$dbhost='localhost'; 
    //$dbuser='tmlsnslt_tml';
    //$dbpass='qmw7V7vEiT3C';
	//$db='tmlsnslt_tml'; 
	
	
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
	$query = "select TicketNo ,TicketUniqueID ,  driversignature, driver_id  from tbl_tickets order by TicketNo  desc ";
	$result = $mysqli -> query($query); 
	if($result){ 
		while($rows = $result -> fetch_array(MYSQLI_ASSOC)){ 
			if($rows['driversignature']!=""){
				$driversignature1 = ''; $Signature=''; 
				$driversignature1 = str_replace('data:image/png;base64,', '', $rows['driversignature']);
				$driversignature1 = str_replace(' ', '+', $driversignature1); 
				$driversignature1 = base64_decode($driversignature1);
				
				//$Signature = $rows['driver_id'].'_'.date("Ymdhis").'_'.md5(rand()).".png"; 
				$Signature = $rows['TicketUniqueID'].'_'.md5($rows['TicketUniqueID']).".png"; 
				
				$file_name = $_SERVER['DOCUMENT_ROOT'].'/assets/TicketSignature/'.$Signature;
				file_put_contents($file_name,$driversignature1); 
				
				$updateQuery ="update `tbl_tickets` set `Signature` = '".$Signature."' where TicketNo ='".$rows['TicketNo']."' ";
				$result2 = $mysqli -> query($updateQuery);  
				if($result2){ $j = $j+1; }  			   
			}	
		}
	}	
	 echo $j; 
		 
exit; 
?> 





















