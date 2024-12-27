<?php
	error_reporting(E_ALL);      
	
    //$dbhost='localhost'; 
    //$dbuser='tmlsnslt_tml';
    //$dbpass='qmw7V7vEiT3C';
	//$db='tmlsnslt_tml';
	
	$dbhost='localhost'; 
    $dbuser= 'root'; //'projects_tmldemo';
    $dbpass= ''; //'panchal12345';
	$db= 'tml'; //'projects_tmldemo';
	
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	}  
  
	$query = "select LorryNo, ltsignature from tbl_drivers  order by LorryNo DESC ";
	$result = $mysqli -> query($query); 
	if($result){
		while($rows = $result -> fetch_array(MYSQLI_ASSOC)){
			echo $rows['LorryNo']." <br>"; 			
			$config['upload_path']   = '/assets/LorrySignature/'; 
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name'] = TRUE;
			$config['overwrite']     = FALSE;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('Signature')) {
				$SignatureUpload = '';
				$SignatureUploadfile_name = '';
			} else {
				$SignatureUpload = $this->upload->data();
				$SignatureUploadfile_name = $SignatureUpload['file_name'];
			} 						
		}	 		  
	}	
	  	
exit;  
?> 