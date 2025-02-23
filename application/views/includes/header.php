<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo substr($pageTitle,24); ?></title>
	<?php //FOR FAVICON OF TICKET PAGES  
		if($active_menu =="loads"){
			//echo '<meta http-equiv="refresh" content="10">';
		}
		if($active_menu =="intickets"){
			echo '<link rel="icon" type="image/png" sizes="96x96" href="assets/icons/up-arrow.png">';
		}
		if($active_menu =="outtickets"){ 		 
			echo '<link rel="icon" type="image/png" sizes="96x96" href="assets/icons/down-arrow.png">';
		}
		if($active_menu =="colltickets"){ 
			echo '<link rel="icon" type="image/png" sizes="96x96" href="assets/icons/collection.png">';
		}  
	?>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<script src="<?php echo base_url('assets/js/jQuery-2.1.4.min.js'); ?>"></script>  
	<!-- Bootstrap 3.3.4 -->
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>">   
	<!-- FontAwesome 4.3.0 -->
	<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
	
	<!-- Ionicons 2.0.0 -->
	<!--<link href="<?php //echo base_url('assets/css/ionicons.min.css'); ?>" rel="stylesheet" type="text/css" /> -->
	<!-- <link href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" /> -->
	<!--  <link href="<?php //echo base_url('assets/validation/dist/parsley.css') ?>" rel="stylesheet"> -->
	
	<!-- Theme style -->
	<link href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
	<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
	<link href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css'); ?>" rel="stylesheet" type="text/css" /> 
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/toastr/toastr.min.css'); ?>">  
	
	<?php // if($active_menu =="addopportunity" || $active_menu =="uploaddata" || $active_menu =="content" || $active_menu =="adduser" || 
	//$active_menu =="edituser" ||  $active_menu =="viewuser" ||  $active_menu =="edittip" ||  $active_menu =="addtip" || 
	//$active_menu =="editcompanies" ||  $active_menu =="addcompanies" ||  $active_menu =="viewcompanies" ||  $active_menu =="addcontact" || 
	//$active_menu =="editcontact" ||  $active_menu =="viewcontact" ||  $active_menu =="addopportunity" ||  $active_menu =="editProduct" || 
	//$active_menu =="addProduct" ||  $active_menu =="editContact" ||  $active_menu =="addContact" ||  $active_menu =="viewopportunity"  ||
	//$active_menu =="adddriver" ||  $active_menu =="editdriver" ||  $active_menu =="editdriverlogin" ||  $active_menu =="viewdriver"  ||
	//$active_menu =="editmaterial" ||  $active_menu =="addmaterial" ||  $active_menu =="viewmaterial" ||  $active_menu =="addbooking"  ||
	//$active_menu =="editbooking" ||  $active_menu =="intickets" ||  $active_menu =="outtickets" ||  $active_menu =="colltickets"  || 
	//$active_menu =="editintickets" ||  $active_menu =="viewintickets" ||  $active_menu =="editouttickets" ||  $active_menu =="viewouttickets"  || 
	//$active_menu =="editcolltickets" ||  $active_menu =="viewcollectiontickets" ||  $active_menu =="outtickets" ||  $active_menu =="colltickets"  
	//){ ?>
	
	<?php //}else{ ?>    
		<!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css'); ?>">   -->
		<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap4.min.css'); ?>">  
	<?php //} ?> 
	
	<?php if($active_menu =="addopportunity" || $active_menu =="editopportunity"   || $active_menu =="editincompleted"  || $active_menu =="incompletedtickets" || $active_menu =="loads" 
	|| $active_menu =="ticketreports" || $active_menu =="materialreports" || $active_menu =="tmlreports" || $active_menu =="eareports"|| $active_menu =="executivesummarydriverlist"
	|| $active_menu =="tippedinreports" || $active_menu =="ticketpaymentreports" || $active_menu =="MaterialReports"   || $active_menu =="tickets"|| $active_menu =="conveyance" || $active_menu =="tips" || $active_menu =="haulage"  ){ ?>
		<!-- daterangepicker -->
		<link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.css'); ?>">       
		<!-- datetimepicker -->
		<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/bootstrap-datetimepicker.min.css'); ?>" />
		
	<?php } ?>

	<?php if($active_menu =="addbooking" || $active_menu =="editbooking"|| $active_menu =="duplicatebooking" || $active_menu =="tickets" || $active_menu =="conveyance" || $active_menu =="tips"  || $active_menu =="incompletedtickets" || 
	$active_menu =="loads" || $active_menu =="pdausers" || $active_menu =="executivesummary"   || $active_menu =="nonapprequestloads"  ){ ?> 
		<script src="<?php echo base_url('assets/css/bootstrap-datepicker.css'); ?>"></script> 
	<?php } ?>
		
	<style type="text/css">.error{color:red;font-weight: normal;}</style>
	<script type="text/javascript">var baseURL = "<?php echo base_url(); ?>";</script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<?php if($this->session->userdata ( 'logout_time' )==2){ ?>
		<style>
		#example1 span{
			display:none !important; 
		}
		</style>
		<script >  
			function keepAlive() {
			  var xhttp = new XMLHttpRequest();
			  xhttp.onreadystatechange = function() {
				  if (this.readyState == 4 && this.status == 200) {
					  if (this.responseText === "pong") {
						  // session refreshed
					  } else {
						  // something wired happened
					  }
				 }
			  };
			  xhttp.open("GET", baseURL+"refreshLogin", true);  
			  xhttp.send(); 
			}
			// set an interval that runs keep alive every 10 minutes
			//setInterval(function() {keepAlive()}, 600000);
			//setInterval(function() {keepAlive()}, 300000);
			setInterval(function() {keepAlive()}, 120000);
		</script>
	<?php } ?>
	<style>

.even1{
	background-color: #dae5f4; 
} 
.odd1{
	background-color: #f9f9f1; 
} 
</style>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
<header class="main-header"><a href="<?php echo base_url(); ?>" class="logo"><span class="logo-mini">TM</span><span class="logo-lg"><?php echo WEB_PAGE_TITLE; ?></span></a> 
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
			<li class="dropdown messages-menu">
					<a title="Version 1.0.0">
					  <span> <strong> VL.25.02.4.6[P] </strong></span> 
					</a> 
				</li>  
			</ul>
			<ul class="nav navbar-nav">
					<li class="dropdown messages-menu">
					<a href="<?php echo base_url('DeliveryHoldTickets'); ?>"   title="Delivery PDA Hold Tickets">
					  <i class="fa fa-truck fa-flip-horizontal"></i><span class="label label-danger" id="holdtkt" > <?php echo $DeliveryHoldTicket; ?></span> 
					</a> 
				</li>  
				<li class="dropdown messages-menu">
					<a href="<?php echo base_url('TML-Hold-Tickets'); ?>"   title="Collection NonAPP HOLD Tickets">
					  <i class="fa  fa-pause"></i><span class="label label-danger" id="holdtkt" > <?php echo $holdticket; ?></span> 
					</a> 
				</li> 
				<li class="dropdown messages-menu">
					<a href="<?php echo base_url('Inbound-Tickets'); ?>"  title="Inbound Tickets">
					  <i class="fa fa-truck"></i><span class="label label-warning" > <?php echo $inboundticket; ?></span> 
					</a> 
				</li>
				<li class="dropdown messages-menu">
					<a href="<?php echo base_url('Incompleted-Tickets'); ?>"  title="InCompleted Tickets">
					  <i class="fa fa-exclamation-circle" ></i><span class="label label-default" > <?php echo $incompletedticket; ?></span> 
					</a> 
				</li>
				<li class="dropdown tasks-menu">
					<a href="<?php echo base_url('content'); ?>"  title="Content Settings " > <i class="fa fa-gear"></i> </a> 
				</li> 	
				<li class="dropdown tasks-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
						<i class="fa fa-history"></i>
					</a>
					<ul class="dropdown-menu">
						<li class="header"> Last Login : <i class="fa fa-clock-o"></i> <?= empty($last_login) ? "First Time Login" : $last_login; ?></li>
					</ul>
				</li>
				<li class="dropdown tasks-menu">
					<a href="<?php echo base_url('Supports'); ?>" title="Support Tickets" alt="Support Tickets" > <i class="fa fa-life-ring"></i> </a> 
				</li> 
				<li class="dropdown tasks-menu">
					<a href="<?php echo base_url('APKDownload'); ?>" title="Download Android APK" alt="Download Android APK" > <i class="fa fa-android" aria-hidden="true"></i></a> 
				</li> 
				
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo base_url('assets/dist/img/avatar.png'); ?>" class="user-image" alt="User Image"/>
						<span class="hidden-xs"><?php echo $name; ?></span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="<?php echo base_url('assets/dist/img/avatar.png'); ?>" class="img-circle" alt="User Image" />
							<p><?php echo $name; ?><small><?php echo $role_text; ?></small></p>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<a href="<?php echo base_url('loadChangePass'); ?>" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Change Password</a>
							</div>
							<div class="pull-right">
								<a href="<?php echo base_url('logout'); ?>" <?php if($holdticket>0){ ?> 
								onclick="return confirm('Are you sure you signout ? There is HOLD Tickets Still Pending');" <?php } ?> class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	<style> 
	#overlay {
	  background: #ffffff;
	  color: #666666;
	  position: fixed;
	  height: 100%;
	  width: 100%;
	  z-index: 5000;
	  top: 0;
	  left: 0;
	  float: left;
	  text-align: center;
	  padding-top: 25%;
	  opacity: .80;
	} 
	.spinner {
		margin: 0 auto;
		height: 64px;
		width: 64px;
		animation: rotate 0.8s infinite linear;
		border: 5px solid firebrick;
		border-right-color: transparent;
		border-radius: 50%;
	}
	@keyframes rotate {
		0% {
			transform: rotate(0deg);
		}
		100% {
			transform: rotate(360deg);
		}
	}
	</style>				
</header> 
<?php include_once 'menu.php'; ?>  
<div id="overlay" style="display:none;">
    <div class="spinner"></div>
    <br/>
    Loading ...
</div>