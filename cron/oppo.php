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
	$q = "select convert(varchar(255),OPPORTUNITYID) as OPPORTUNITYID, NAME, CONVERT(varchar,OPENDATE,23) as OPENDATE,CONVERT(varchar,ESTIMATEDCLOSEDATE,23) as ESTIMATEDCLOSEDATE,	CREATEDATE ,EDITDATE ,
	 CUST_PriceAgreed_032329203, CUST_SiteContact_032533311, CUST_Pricing_034825177, CUST_TipTicketsSent_011703706, CUST_NewField1_012315449, CUST_NameoftheTip_012924016,
	 CUST_Mobile_015736621, CUST_TIPNAME_020653404, CUST_SpecialRequirements_020904643, CUST_AccountDepartmentNotes_045723254, CUST_TipTickets_025820907, CUST_Stamp_030147297,
	 CUST_POrequired_030924009, CUST_SiteInstructionsNote_081744750, CUST_SiteInstructionsRequire_082121809, CUST_SiteContactName_024406636, CUST_StampDetails_103018148, 	 CUST_WIFRequired_111358217, CUST_WIF_111623654	
	from [Thames2013].[dbo].[TBL_OPPORTUNITY]";
	$sql = sqlsrv_query($link, $q);
	
	while ( $ls = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {  
		$k = $k+1;    
		$ad1 = array(); $ad = array(); 
		$ad1 = explode(',',$ls['NAME']); 
		$ad = array_pad(array_reverse($ad1),6," "); 
		
		$post = ""; $care =""; $street1 =""; $street2 =""; 
		if($ad[0]!=""){ $c = explode('(' , $ad[0] ); $post = $c[0]; if(isset($c[1])){ $care = "(".$c[1]; } }
		$street1 = trim($ad[4]);
		$street2 = trim($ad[3]);
		if(trim($ad[4])==""){ $street1 = trim($ad[3]); $street2 = "";  }	
		
		$query = ""; $result = ""; $rows = ""; $insertQuery = ""; $result1 = ""; 
		$query = "select count(*) from tbl_opportunities  where OpportunityID ='".$mysqli -> real_escape_string($ls['OPPORTUNITYID'])."'  ";
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
				$insertQuery ="INSERT INTO  `tbl_opportunities` set `OpportunityID` = '".trim($ls['OPPORTUNITYID'])."', `isAct` = '1',  
				`OpportunityIDMapKey` = '".$mysqli -> real_escape_string(trim($ls['OPPORTUNITYID']))."',
				`OpportunityName` = '".$mysqli -> real_escape_string(trim($ls['NAME']))."',
				`Street1` = '".$mysqli -> real_escape_string(trim($street1))."',
				`Street2` = '".$mysqli -> real_escape_string(trim($street2))."',
				`Town` = '".$mysqli -> real_escape_string(trim($ad[2]))."',
				`County` = '".$mysqli -> real_escape_string(trim($ad[1]))."',
				`PostCode` = '".$mysqli -> real_escape_string(trim($post))."',
				`careof` = '".$mysqli -> real_escape_string(trim($care))."',
				`OpenDate` = '".$mysqli -> real_escape_string(trim($ls['OPENDATE']))."',
				`CloseDate` = '".$mysqli -> real_escape_string(trim($ls['ESTIMATEDCLOSEDATE']))."',
				`CreateDate` = '".$mysqli -> real_escape_string(date('Y-m-d G:i:s',strtotime(trim($ls['CREATEDATE']))))."',
				`EditUserDate` = '".$mysqli -> real_escape_string(date('Y-m-d G:i:s',strtotime(trim($ls['EDITDATE']))))."',
				`CUST_PriceAgreed_032329203` = '".$mysqli -> real_escape_string(trim($ls['CUST_PriceAgreed_032329203']))."',
				`CUST_SiteContact_032533311` = '".$mysqli -> real_escape_string($ls['CUST_SiteContact_032533311'])."',
				`CUST_Pricing_034825177` = '".$mysqli -> real_escape_string($ls['CUST_Pricing_034825177'])."',
				`CUST_TipTicketsSent_011703706` = '".$mysqli -> real_escape_string($ls['CUST_TipTicketsSent_011703706'])."',
				`CUST_NewField1_012315449` = '".$mysqli -> real_escape_string($ls['CUST_NewField1_012315449'])."',
				`CUST_NameoftheTip_012924016` = '".$mysqli -> real_escape_string($ls['CUST_NameoftheTip_012924016'])."',
				`CUST_Mobile_015736621` = '".$mysqli -> real_escape_string($ls['CUST_Mobile_015736621'])."',
				`CUST_TIPNAME_020653404` = '".$mysqli -> real_escape_string($ls['CUST_TIPNAME_020653404'])."',				
				`TipName` = '".$mysqli -> real_escape_string($ls['CUST_TIPNAME_020653404'])."',
				`CUST_SpecialRequirements_020904643` = '".$mysqli -> real_escape_string($ls['CUST_SpecialRequirements_020904643'])."',
				`CUST_AccountDepartmentNotes_045723254` = '".$mysqli -> real_escape_string($ls['CUST_AccountDepartmentNotes_045723254'])."',
				`AccountNotes` = '".$mysqli -> real_escape_string($ls['CUST_AccountDepartmentNotes_045723254'])."',
				`CUST_TipTickets_025820907` = '".$mysqli -> real_escape_string($ls['CUST_TipTickets_025820907'])."',
				`TipTicketRequired` = '".$mysqli -> real_escape_string($ls['CUST_TipTickets_025820907'])."',
				`CUST_Stamp_030147297` = '".$mysqli -> real_escape_string($ls['CUST_Stamp_030147297'])."',
				`StampRequired` = '".$mysqli -> real_escape_string($ls['CUST_Stamp_030147297'])."',
				`CUST_POrequired_030924009` = '".$mysqli -> real_escape_string($ls['CUST_POrequired_030924009'])."',
				`PORequired` = '".$mysqli -> real_escape_string($ls['CUST_POrequired_030924009'])."',
				`CUST_SiteInstructionsNote_081744750` = '".$mysqli -> real_escape_string($ls['CUST_SiteInstructionsNote_081744750'])."',
				`SiteNotes` = '".$mysqli -> real_escape_string($ls['CUST_SiteInstructionsNote_081744750'])."',
				`CUST_SiteInstructionsRequire_082121809` = '".$mysqli -> real_escape_string($ls['CUST_SiteInstructionsRequire_082121809'])."',
				`SiteInstRequired` = '".$mysqli -> real_escape_string($ls['CUST_SiteInstructionsRequire_082121809'])."',
				`CUST_SiteContactName_024406636` = '".$mysqli -> real_escape_string($ls['CUST_SiteContactName_024406636'])."',
				`CUST_StampDetails_103018148` = '".$mysqli -> real_escape_string($ls['CUST_StampDetails_103018148'])."',
				`Stamp` = '".$mysqli -> real_escape_string($ls['CUST_StampDetails_103018148'])."',
				`WIFRequired` = '".$mysqli -> real_escape_string($ls['CUST_WIFRequired_111358217'])."' ,
				`CUST_WIFRequired_111358217` = '".$mysqli -> real_escape_string($ls['CUST_WIFRequired_111358217'])."' ,
				`WIF` = '".$mysqli -> real_escape_string($ls['CUST_WIF_111623654'])."' ,
				`CUST_WIF_111623654` = '".$mysqli -> real_escape_string($ls['CUST_WIF_111623654'])."'   ";
				 
				$result1 = $mysqli -> query($insertQuery); 
				if($result1){ $i = $i+1; 
					$updateQuery ="insert into `tbl_opportunity_tip`  set `TipID` =  '1', `TipRefNo` =  '', `OpportunityID` = '".$mysqli -> insert_id."', `Status` = '0'   ";  
					$result2 = $mysqli -> query($updateQuery); 	 
				}
			}else{
			    //`CUST_Mobile_015736621` = '".$mysqli -> real_escape_string($ls['CUST_Mobile_015736621'])."',
			    
				$updateQuery ="update `tbl_opportunities` set `OpportunityID` = '".trim($ls['OPPORTUNITYID'])."', `isAct` = '1',  
				`OpportunityIDMapKey` = '".$mysqli -> real_escape_string(trim($ls['OPPORTUNITYID']))."',
				`OpportunityName` = '".$mysqli -> real_escape_string(trim($ls['NAME']))."',
				`Street1` = '".$mysqli -> real_escape_string(trim($street1))."',
				`Street2` = '".$mysqli -> real_escape_string(trim($street2))."',
				`Town` = '".$mysqli -> real_escape_string(trim($ad[2]))."',
				`County` = '".$mysqli -> real_escape_string(trim($ad[1]))."',
				`PostCode` = '".$mysqli -> real_escape_string(trim($post))."',
				`careof` = '".$mysqli -> real_escape_string(trim($care))."',
				`OpenDate` = '".$mysqli -> real_escape_string(trim($ls['OPENDATE']))."',
				`CloseDate` = '".$mysqli -> real_escape_string(trim($ls['ESTIMATEDCLOSEDATE']))."',
				`CreateDate` = '".$mysqli -> real_escape_string(date('Y-m-d G:i:s',strtotime(trim($ls['CREATEDATE']))))."',
				`EditUserDate` = '".$mysqli -> real_escape_string(date('Y-m-d G:i:s',strtotime(trim($ls['EDITDATE']))))."',
				`CUST_PriceAgreed_032329203` = '".$mysqli -> real_escape_string(trim($ls['CUST_PriceAgreed_032329203']))."',
				`CUST_SiteContact_032533311` = '".$mysqli -> real_escape_string($ls['CUST_SiteContact_032533311'])."',
				`CUST_Pricing_034825177` = '".$mysqli -> real_escape_string($ls['CUST_Pricing_034825177'])."',
				`CUST_TipTicketsSent_011703706` = '".$mysqli -> real_escape_string($ls['CUST_TipTicketsSent_011703706'])."',
				`CUST_NewField1_012315449` = '".$mysqli -> real_escape_string($ls['CUST_NewField1_012315449'])."',
				`CUST_NameoftheTip_012924016` = '".$mysqli -> real_escape_string($ls['CUST_NameoftheTip_012924016'])."',
				
				`CUST_TIPNAME_020653404` = '".$mysqli -> real_escape_string($ls['CUST_TIPNAME_020653404'])."',				
				`TipName` = '".$mysqli -> real_escape_string($ls['CUST_TIPNAME_020653404'])."',
				`CUST_SpecialRequirements_020904643` = '".$mysqli -> real_escape_string($ls['CUST_SpecialRequirements_020904643'])."',
				`CUST_AccountDepartmentNotes_045723254` = '".$mysqli -> real_escape_string($ls['CUST_AccountDepartmentNotes_045723254'])."',
				`AccountNotes` = '".$mysqli -> real_escape_string($ls['CUST_AccountDepartmentNotes_045723254'])."',
				`CUST_TipTickets_025820907` = '".$mysqli -> real_escape_string($ls['CUST_TipTickets_025820907'])."',
				`TipTicketRequired` = '".$mysqli -> real_escape_string($ls['CUST_TipTickets_025820907'])."',
				`CUST_Stamp_030147297` = '".$mysqli -> real_escape_string($ls['CUST_Stamp_030147297'])."',
				`StampRequired` = '".$mysqli -> real_escape_string($ls['CUST_Stamp_030147297'])."',
				`CUST_POrequired_030924009` = '".$mysqli -> real_escape_string($ls['CUST_POrequired_030924009'])."',
				`PORequired` = '".$mysqli -> real_escape_string($ls['CUST_POrequired_030924009'])."',
				`CUST_SiteInstructionsNote_081744750` = '".$mysqli -> real_escape_string($ls['CUST_SiteInstructionsNote_081744750'])."',
				`SiteNotes` = '".$mysqli -> real_escape_string($ls['CUST_SiteInstructionsNote_081744750'])."',
				`CUST_SiteInstructionsRequire_082121809` = '".$mysqli -> real_escape_string($ls['CUST_SiteInstructionsRequire_082121809'])."',
				`SiteInstRequired` = '".$mysqli -> real_escape_string($ls['CUST_SiteInstructionsRequire_082121809'])."',
				`CUST_SiteContactName_024406636` = '".$mysqli -> real_escape_string($ls['CUST_SiteContactName_024406636'])."',
				`CUST_StampDetails_103018148` = '".$mysqli -> real_escape_string($ls['CUST_StampDetails_103018148'])."',
				`Stamp` = '".$mysqli -> real_escape_string($ls['CUST_StampDetails_103018148'])."',
				`WIFRequired` = '".$mysqli -> real_escape_string($ls['CUST_WIFRequired_111358217'])."' ,
				`CUST_WIFRequired_111358217` = '".$mysqli -> real_escape_string($ls['CUST_WIFRequired_111358217'])."' ,
				`WIF` = '".$mysqli -> real_escape_string($ls['CUST_WIF_111623654'])."' ,
				`CUST_WIF_111623654` = '".$mysqli -> real_escape_string($ls['CUST_WIF_111623654'])."'   
				where OpportunityID ='".$mysqli -> real_escape_string($ls['OPPORTUNITYID'])."' ";
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