<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"></head>
<style> 
@page :right {
	size: 3.in; /* <length>{1,2} | auto | portrait | landscape */
	      /* 'em' 'ex' and % are not allowed; length values are width height */
	 
	margin: 1cm; /* <any of the usual CSS values for margins> */
	             /*(% of page-box width for LR, of height for TB) */
	  
}
</style>
<body> 
<div style="width:30%;margin-bottom: 0px;margin-top: 0px;" >
	<div style="width:100%;float: left;font-size: 12px;" > 
		<img src="<?php echo site_url().'/assets/Uploads/Logo/'.$content['logo']; ?>" width ="100"> <br>
		<?php echo $content['address']; ?> <br/>
		<b>Tel:</b>  <?php echo $content['phone']; ?> (Head Office)<br/> 
		<b>Email:</b> <?php echo $content['email']; ?> <br/>
		<b>Web:</b> <?php echo $content['website']; ?>  <br/><br/>
		 
		<b><?php echo $content['waste_licence']; ?></b><br>
		<b><?php echo $content['reference']; ?></b><br><br>
		
		<b>Conveyance Note</b><br><br>
		
		<b>Conveyance No:</b> <?php echo $LoadID; ?> <br>
		<b>Company Name: </b> <?php echo $dataarr[0]->CompanyName; ?> <br>
		<b>Site Address: </b> <?php echo $dataarr[0]->Street1.' '.$dataarr[0]->Street2.' '.$dataarr[0]->Town.' '.$dataarr[0]->County.' '.$dataarr[0]->PostCode; ?> <br>
		<b>Material: </b> <?php echo $MaterialnameQRY['MaterialName']; ?> <br><br>
		
		<b>Driver Name: </b> <?php echo $user['DriverName']; ?><br>
		<b>Vehicle Reg. No. </b> <?php echo $user['RegNumber']; ?><br><br><br>
		 
		<b></b><br>
		<b><?php echo $CustomerName; ?></b><br>  
	</div>  
</div>   
</body>
</html> 