<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
<style type="text/css"> 
	#block{
    	width:100%; 
		margin-left: 90px;
		margin-right: 100px;
		font-size: 14px;
    }  
</style>
</head>
<body >

<div style="width:100%;padding-top: 225px;font-size: 15px;" >
	<div style="width:45%;float: left;padding-left:25px;" ><?php echo $InvoiceInfo['CompanyName']; ?> <br> 
	<div style="font-size:12px;"><?php echo $CompanyInfo['Street1'].", ".$CompanyInfo['Street2'].", <br>".$CompanyInfo['Town'].", ".$CompanyInfo['County'].", ".$CompanyInfo['PostCode']."<br><br>"; ?></div>  
	<?php if($CompanyInfo['Phone1']!=""){ ?><div style="font-size:12px;"><b>Phone:</b> <?php echo $CompanyInfo['Phone1']; ?></div>  <?php } ?> 
	<?php if($CompanyInfo['EmailID']!=""){ ?><div style="font-size:12px;"><b>Email:</b> <?php echo $CompanyInfo['EmailID']; ?></div>  <?php } ?>
	
	</div> 
	
	<div  style="width:40%;float: right;"> 
		<div style="width:100%;margin-bottom: 5px;height:25px" >
			<div style="width:50%;float: left;" ><b>Invoice No.</b></div> 
			<div  style="width:45%;float: right;"><?php echo $InvoiceInfo['InvoiceNumber']; ?> </div>
		</div>   
		<?php $dt = explode('-',$InvoiceInfo['InvoiceDate']); 
			$date = $dt[2].'-'.$dt[1].'-'.$dt[0];	
		?>
		<div style="width:100%;margin-bottom: 5px;height:25px" >
			<div style="width:50%;float: left;" ><b>Invoice Date</b></div> 
			<div  style="width:45%;float: right;"><?php echo $date; ?> </div>
		</div> 
		<div style="width:100%;margin-bottom: 5px;height:25px;" >
			<div style="width:50%;float: left;" ><b>Cust. Order No.</b></div> 
			<div  style="width:45%;float: right;"></div>
		</div> 
		<div style="width:100%;margin-bottom: 5px;height:25px" >
			<div style="width:50%;float: left;" ><b>Account No.</b></div> 
			<div  style="width:45%;float: right;"><?php echo $CompanyInfo['AccountRef']; ?></div>
		</div>   
	</div>
</div> 

<div style="width:100%;padding-top: 45px;height:450px" >
<div style="width:100%;font-size: 13px;" >
	<div style="width:10%;float: left;padding-left:25px;font-weight:bold;" > Quantity </div> 
	<div style="width:40%;float: left;font-weight:bold;" > Details </div> 
	<div style="width:15%;float: left;font-weight:bold;" > TML REF: </div> 
	<div style="width:15%;float: left;font-weight:bold;" > Unit Price </div> 
	<div style="width:15%;float: left;font-weight:bold;" > Total </div>   
</div> 
<?php if(!empty($LoadInfo)){   
	foreach($LoadInfo as $key=>$record){ ?>
		<div style="width:100%;padding-top: 10px;font-size: 13px;" >
			<div style="width:10%;float: left;padding-left:25px;" > <?php echo (int)$record->TotalQty; ?> </div> 
			<div style="width:40%;float: left;" > <?php echo $record->MaterialName; ?></div> 
			<div style="width:15%;float: left;" > - </div> 
			<div style="width:15%;float: left;" > <?php echo $record->LoadPrice; ?></div> 
			<div style="width:15%;float: left;" > <?php echo $record->TotalPrice; ?> </div>    			
		</div> 
	<?php } ?>
<?php } ?>	
</div> 


<div style="width:100%;padding-top: 55px;font-size: 14px; " >
	<div style="width:45%;float: left;padding-left:25px;" ><?php echo $InvoiceInfo['OpportunityName']; ?> </div> 
	
	<div  style="width:40%;float: right;"> 
		<div style="width:100%;margin-bottom: 9px;height:25px" >
			<div style="width:50%;float: left;" ><b>Total Net Amount</b></div> 
			<div  style="width:45%;float: right; "><?php echo $InvoiceInfo['SubTotalAmount']; ?> </div>
		</div>    
		<div style="width:100%;margin-bottom: 9px;height:25px" >
			<div style="width:50%;float: left;" ><b>VAT @ 20%</b></div> 
			<div  style="width:45%;float: right; "><?php echo $InvoiceInfo['VatAmount']; ?> </div>
		</div> 
		<div style="width:100%;height:25px;" >
			<div style="width:50%;float: left;" ><b>Invoice Total</b></div> 
			<div  style="width:45%;float: right; "><?php echo $InvoiceInfo['FinalAmount']; ?></div>
		</div>  
	</div>
</div> 
<div style="width:100%;padding-top: 5px;font-size: 12px;" >
	<div style="width:100%;float: left;padding-left:25px;font-weight:bold;" > All Accounts Strictly 30 Days From Invoice Date </div> 
</div> 


</body>
</html> 