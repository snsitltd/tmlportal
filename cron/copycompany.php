<?php

error_reporting(E_ALL);  

###########################################  
############ MYSQL CONNECTION #############
$dbhost='localhost'; 
$dbuser='root';
$dbpass='';
$db='tml_new';

//$dbuser='tmlsnsit_demo';
//$dbpass='panchal12345';
//$db='tmlsnsit_demo';
 
$dbuser='tmlsnslt_tml';
$dbpass='qmw7V7vEiT3C';
$db='tmlsnslt_tml';
 
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);  
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}  
echo "<br>=========<br>";
$CompanyID = 'FA182C87-2672-426A-95D9-7056A6ACB112';
$NewCompanyID = '9BRZS-X0PQLGAJWHEFU68VN4DOC15-3Y2KT';
$k = 0;    $j = 0;     
	
$query = "select tbl_opportunities.*
from tbl_company_to_opportunities 
join tbl_opportunities  on tbl_company_to_opportunities.OpportunityID  = tbl_opportunities.OpportunityID 
where tbl_company_to_opportunities.CompanyID = '".$CompanyID."' 
order by tbl_opportunities.tscreate_datetime ASC   ";

//$query = "select tbl_company_to_opportunities.OpportunityID, tbl_company_to_opportunities.CompanyID 
//from tbl_company_to_opportunities 
//join tbl_opportunities  on tbl_company_to_opportunities.OpportunityID  = tbl_opportunities.OpportunityID 
//where tbl_company_to_opportunities.CompanyID = '".$CompanyID."'
//order by tbl_opportunities.tscreate_datetime ASC limit 3 ";

function generateRandomString($length = 24) {
		return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

$result = $mysqli -> query($query); 
if($result){  
	while ($rows = $result -> fetch_assoc()){  
		echo "<br>=========<br>";
		$query_oppo ='';$result_oppo ='';$rows_oppo ='';$Insert ='';
	  
/*===================== Insert Opportunity ======================== */
			 
				$OpportunityID = generateRandomString();  
				
				$Insert_Oppo ="insert into `tbl_opportunities`  
				set `OpportunityID` = '".$OpportunityID."', `OpportunityIDMapKey` = '".$OpportunityID."',  
				`OpportunityName` = '".$rows['OpportunityName']."', 
				`Street1` = '".$rows['Street1']."', 
				`Street2` = '".$rows['Street2']."', 
				`Town` = '".$rows['Town']."', 
				`County` = '".$rows['County']."', 
				`PostCode` = '".$rows['PostCode']."', 
				`careof` = '".$rows['careof']."',  
				`WIFRequired` = '".$rows['WIFRequired']."', 
				`WIF` = '".$rows['WIF']."', 
				`TipTicketRequired` = '".$rows['TipTicketRequired']."', 
				`TipName` = '".$rows['TipName']."', 
				`TipName_ACT` = '".$rows['TipName_ACT']."', 
				`StampRequired` = '".$rows['StampRequired']."', 
				`Stamp` = '".$rows['Stamp']."', 
				`SiteInstRequired` = '".$rows['SiteInstRequired']."', 
				`SiteNotes` = '".$rows['SiteNotes']."', 
				`PORequired` = '".$rows['PORequired']."', 
				`PO_Notes` = '".$rows['PO_Notes']."', 
				`AccountNotes` = '".$rows['AccountNotes']."', 
				`TipAutho` = '".$rows['TipAutho']."', 
				`CreateUserID` = '".$rows['CreateUserID']."', 
				`EditUserID` = '".$rows['EditUserID']."', 
				`CUST_PriceAgreed_032329203` = '".$rows['CUST_PriceAgreed_032329203']."', 
				`CUST_SiteContact_032533311` = '".$rows['CUST_SiteContact_032533311']."', 
				`CUST_Pricing_034825177` = '".$rows['CUST_Pricing_034825177']."', 
				`CUST_TipTicketsSent_011703706` = '".$rows['CUST_TipTicketsSent_011703706']."', 
				`CUST_NewField1_012315449` = '".$rows['CUST_NewField1_012315449']."', 
				`CUST_NameoftheTip_012924016` = '".$rows['CUST_NameoftheTip_012924016']."', 
				`CUST_Mobile_015736621` = '".$rows['CUST_Mobile_015736621']."', 
				`CUST_TIPNAME_020653404` = '".$rows['CUST_TIPNAME_020653404']."', 
				`CUST_SpecialRequirements_020904643` = '".$rows['CUST_SpecialRequirements_020904643']."', 
				`CUST_AccountDepartmentNotes_045723254` = '".$rows['CUST_AccountDepartmentNotes_045723254']."', 
				`CUST_TipTickets_025820907` = '".$rows['CUST_TipTickets_025820907']."', 
				`CUST_Stamp_030147297` = '".$rows['CUST_Stamp_030147297']."', 
				`CUST_POrequired_030924009` = '".$rows['CUST_POrequired_030924009']."', 
				`CUST_SiteInstructionsNote_081744750` = '".$rows['CUST_SiteInstructionsNote_081744750']."', 
				`CUST_SiteInstructionsRequire_082121809` = '".$rows['CUST_SiteInstructionsRequire_082121809']."', 
				`CUST_SiteContactName_024406636` = '".$rows['CUST_SiteContactName_024406636']."', 
				`CUST_StampDetails_103018148` = '".$rows['CUST_StampDetails_103018148']."', 
				`CUST_WIFRequired_111358217` = '".$rows['CUST_WIFRequired_111358217']."', 
				`CUST_WIF_111623654` = '".$rows['CUST_WIF_111623654']."', 
				`isAct` = '".$rows['isAct']."',
				`Copied` = '1'   ";  
				$result_oppo = $mysqli -> query($Insert_Oppo);  
				if($result_oppo){
/*================================================================= */
/*===================== Insert Opportunity ======================== */
					echo "<br>=========<br>";
				$InsertOppoCompany  ="insert into `tbl_company_to_opportunities`  
				set `OpportunityID` = '".$OpportunityID."',  `CompanyID` = '".$NewCompanyID."' ,  `Copied` = '1'  ";
				$resultOppoCompany = $mysqli -> query($InsertOppoCompany); 
				
				}
/*================================================================= */
/*===================== Insert Contact ======================== */

		$query_oppo_contact = "select tbl_contacts.* from tbl_opportunity_to_contact
		join tbl_contacts  on tbl_opportunity_to_contact.ContactID  = tbl_contacts.ContactID 
		where tbl_opportunity_to_contact.OpportunityID = '".$rows['OpportunityID']."'   
		order by tbl_contacts.ContactID ASC ";
		$result_oppo_contact = $mysqli -> query($query_oppo_contact); 
		if($result_oppo_contact){   
			if( $result_oppo_contact->num_rows>0){ 		 
				while($rows_oppo_contact = $result_oppo_contact -> fetch_assoc()){
						echo "<br>=========<br>";
					$ContactID = generateRandomString();  
					 $Insert_Contact ="insert into `tbl_contacts`  
					set `ContactID` = '".$ContactID."', 
					`ContactIDMapKey` = '".$rows_oppo_contact['ContactIDMapKey']."', 
					`Type` = '".$rows_oppo_contact['Type']."',
					`Title` = '".$rows_oppo_contact['Title']."',
					`ContactName` = '".$rows_oppo_contact['ContactName']."',
					`PhoneNumber` = '".$rows_oppo_contact['PhoneNumber']."',
					`PhoneExtension` = '".$rows_oppo_contact['PhoneExtension']."',
					`MobileNumber` = '".$rows_oppo_contact['MobileNumber']."',
					`EmailAddress` = '".$rows_oppo_contact['EmailAddress']."', 
					`Position` = '".$rows_oppo_contact['Position']."',
					`CreateDate` = '".$rows_oppo_contact['CreateDate']."',
					`CreateUserID` = '".$rows_oppo_contact['CreateUserID']."',
					`EditUserDate` = '".$rows_oppo_contact['EditUserDate']."',
					`EditUserID` = '".$rows_oppo_contact['EditUserID']."',
					`COMPANYID` = '".$rows_oppo_contact['COMPANYID']."',
					`COMPANYNAME` = '".$rows_oppo_contact['COMPANYNAME']."',  
					`CONTACTWEBADDRESS` = '".$rows_oppo_contact['CONTACTWEBADDRESS']."',  
					`CUST_AccountReferenceNumber_014126697` = '".$rows_oppo_contact['CUST_AccountReferenceNumber_014126697']."',  
					`CUST_Title_012223045` = '".$rows_oppo_contact['CUST_Title_012223045']."',  
					`isAct` = '".$rows_oppo_contact['isAct']."',  
					`Copied` = '1'   ";  
					$result_Contact = $mysqli -> query($Insert_Contact);  
					if($result_Contact){
							echo "<br>=========<br>";
						$Insert_Contact_Oppo  ="insert into `tbl_opportunity_to_contact`  
						set `OpportunityID` = '".$OpportunityID."',  `ContactID` = '".$ContactID."' ,  `Copied` = '1'   ";
						$result_Contact_Oppo = $mysqli -> query($Insert_Contact_Oppo); 
					}
								 
				}
			}
		}			
			
/*================================================================= */
/*===================== Insert Doc ======================== */

		$query_oppo_doc = "select tbl_documents.* from tbl_opportunity_to_document
		join tbl_documents  on tbl_opportunity_to_document.DocumentID  = tbl_documents.DocumentID 
		where tbl_opportunity_to_document.OpportunityID = '".$rows['OpportunityID']."'   
		order by tbl_documents.DocumentID ASC ";
		$result_oppo_doc = $mysqli -> query($query_oppo_doc); 
		if($result_oppo_doc){   
			if( $result_oppo_doc->num_rows>0){ 		 
				while($rows_oppo_doc = $result_oppo_doc -> fetch_assoc()){
						echo "<br>=========<br>";
					$DocumentID = generateRandomString(); 
					$Insert_Doc ="insert into `tbl_documents`  
					set `DocumentID` = '".$DocumentID."', 
					`DocumentIDMapKey` = '".$rows_oppo_doc['DocumentIDMapKey']."', 
					`DocumentAttachment` = '".$rows_oppo_doc['DocumentAttachment']."',
					`DocumentType` = '".$rows_oppo_doc['DocumentType']."',
					`DocumentNumber` = '".$rows_oppo_doc['DocumentNumber']."',
					`DocumentDetail` = '".$rows_oppo_doc['DocumentDetail']."',
					`CreateDate` = '".$rows_oppo_doc['CreateDate']."',
					`CreatedUserID` = '".$rows_oppo_doc['CreatedUserID']."',
					`EditUserDate` = '".$rows_oppo_doc['EditUserDate']."',
					`EditUserID` = '".$rows_oppo_doc['EditUserID']."', 
					`Copied` = '1'   ";  
					$result_Doc = $mysqli -> query($Insert_Doc);  
					if($result_Doc){
							echo "<br>=========<br>";
						 $Insert_Doc_Oppo  ="insert into `tbl_opportunity_to_document`  
						set `OpportunityID` = '".$OpportunityID."',  `DocumentID` = '".$DocumentID."' ,  `Copied` = '1'  ";
						$result_Doc_Oppo = $mysqli -> query($Insert_Doc_Oppo); 
					}
					
				}			
			}
		}					
/*================================================================= */

/*===================== Insert Notes ======================== */

		$query_oppo_notes = "select tbl_notes.* from tbl_opportunity_to_note
		join tbl_notes  on tbl_opportunity_to_note.NotesID  = tbl_notes.NotesID 
		where tbl_opportunity_to_note.OpportunityID = '".$rows['OpportunityID']."'  
		order by tbl_notes.NotesID ASC ";
		$result_oppo_notes = $mysqli -> query($query_oppo_notes); 
		if($result_oppo_notes){   
			if( $result_oppo_notes->num_rows>0){ 		 
				while($rows_oppo_notes = $result_oppo_notes -> fetch_assoc()){
						echo "<br>=========<br>";
					$NotesID  = generateRandomString(); 
					$Insert_Notes ="insert into `tbl_notes`  
					set `NotesID` = '".$NotesID."', 
					`NotesIDMapKey` = '".$rows_oppo_notes['NotesIDMapKey']."', 
					`NoteType` = '".$rows_oppo_notes['NoteType']."',
					`Regarding` = '".$rows_oppo_notes['Regarding']."',
					`NoteAttachement` = '".$rows_oppo_notes['NoteAttachement']."',
					`IsActive` = '".$rows_oppo_notes['IsActive']."',
					`CreateDate` = '".$rows_oppo_notes['CreateDate']."',
					`CreatedUserID` = '".$rows_oppo_notes['CreatedUserID']."',
					`EditUserDate` = '".$rows_oppo_notes['EditUserDate']."',
					`EditUserID` = '".$rows_oppo_notes['EditUserID']."', 
					`Copied` = '1'   ";  
					$result_Notes = $mysqli -> query($Insert_Notes);  
					if($result_Notes){
						echo "<br>=========<br>";
					    $Insert_Notes_Oppo  ="insert into `tbl_opportunity_to_note`  
						set `OpportunityID` = '".$OpportunityID."',  `NotesID` = '".$NotesID."',  `Copied` = '1'   ";
						$result_Notes_Oppo = $mysqli -> query($Insert_Notes_Oppo); 
					}
								
				}			
			}
		}
		
/*================================================================= */
 
				echo "<br>=========<br>";  
			//}	
		//}	
		$k = $k+1; 
		
	}
	
}	
 
	echo "Total =====>>> Total Recordss : ".$k."  <br> ";	  
	echo "Updated =====>>> Updated : ".$j."  <br> ";
 		 
exit; 
?>   