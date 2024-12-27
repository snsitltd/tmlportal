<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"></head>
<style>@page :right {	size: 3.in;   	margin: 0cm;	margin-header: 0cm;	margin-footer: 0cm;}</style>
<body>
<div style="width:30%;margin-bottom: 0px;margin-top: 0px;" >
<div style="width:100%;float: left;font-size: 12px;" >
<img src="'.site_url().'/assets/Uploads/Logo/'.$PDFContent[0]->logo.'" width ="100"> <br>
		<?php //echo $PDFContent[0]->address; ?> <br/>
		<b>Tel:</b>  <?php //'.$PDFContent[0]->phone.'; ?> (Head Office)<br/>
		<b>Email:</b> lkjljljlkjljkljkl  <br/>
		 lkjljljlkjljkljkl     <br/><br/>
		<b> lkjljljlkjljkljkl </b><br>
		<b> lkjljljlkjljkljkl </b><br><br>
		<b>Conveyance Note: #'.$dataarr[0]->ConveyanceNo.'  </b><br><br>
		<b>Company Name: </b> '.$dataarr[0]->CompanyName.' <br>
		<b>Site Address: </b> '.$dataarr[0]->OpportunityName.'<br>
		<b>Material: </b> '.$MaterialnameQRY['MaterialName'].' <br><br>
		<b>Driver Name: </b> '.$user['DriverName'].'<br>
		<b>Vehicle Reg. No. </b> '.$user['RegNumber'].' <br><br><br>
		<b></b><br>		<b>'.$CustomerName.'</b><br>
</div>  </div></body></html>