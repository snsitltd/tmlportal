<?php 
$lorry = array() ;
if(count($TodayPDAUsers)>0){  
	foreach($TodayPDAUsers as $row){  
		if (!in_array($row['LorryNo'], $lorry)){  $lorry[] = $row['LorryNo']; } 
	}  
}  

?> 

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
		
        <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?=$company_count;?></h3>
                  <p>Total Companies</p>
                </div>
                <div class="icon">
                   <i class="fa fa-building-o" aria-hidden="true"></i>
                </div>
                <a href="<?=base_url('companies');?>" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?=$contact_count;?></h3>
                  <p>Total Contacts</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="<?=base_url('contacts');?>" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?=$user_count;?></h3>
                  <p>Total Users</p>
                </div>
                <div class="icon">
                 <i class="fa fa-users"></i>
                </div>
                <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
			<div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                   <h3><?php echo count($lorry); ?></h3>
                  <p>Today's PDA Users</p>
                </div>
                <div class="icon">
                 <i class="fa fa-users"></i>
                </div>
                <a href="<?php echo base_url(); ?>PDAUsers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?=$ticket_count;?></h3>
                  <p>Total Tickets</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i> 
                </div>
                <a href="<?php echo base_url(); ?>All-Tickets" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div>
		  
		  
		   <div class="row">  
			<div class="col-lg-12 col-xs-6">
			
			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">WIF form required</h3>  
            </div> 
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Company Name</th>
                    <th>Opportunity Name</th>
                    <th align="right" >Tickets</th> 
                  </tr>
                  </thead>
                  <tbody>
					<?php if(count($ticket_limit_company)>0){ foreach($ticket_limit_company as $row){ ?>
					<tr>
						<td ><a href="<?php echo base_url('view-company/'.$row['CompanyID']); ?>" ><?php echo $row['CompanyName']; ?></a></td>		
						<td ><a href="<?php echo base_url('View-Opportunity/'.$row['OpportunityID']); ?>" ><?php echo $row['OpportunityName']; ?></a></td>
						<td align="right" ><?php echo $row['ccnt']; ?></td>
					</tr>  
					<?php }}else{ ?>
					<tr><td  align="center" colspan="3" >There is no records.  </td></tr>  
					<?php } ?>	  
                  </tbody>
                </table>
              </div> 
            </div> 
            <div class="box-footer clearfix"> 
              <a href="<?php echo base_url('wifOppo'); ?>" class="btn btn-sm btn-default btn-flat pull-right">View All</a>
            </div> 
          </div> 
		  
          </div>
		  </div> 
		  
		  <div class="row">  
		  
		  <div class="col-lg-6 col-xs-6">
			
			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Recently Added new company</h3>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Company Name</th> 
                  </tr>
                  </thead>
                  <tbody>
					<?php if(count($new_company1)>0){ foreach($new_company1 as $row){ ?>
						<tr>
							<td ><a href="<?php echo base_url('view-company/'.$row['CompanyID']); ?>" ><?php echo $row['CompanyName']; ?></a></td>		 
						</tr>  
					<?php }}else{ ?>
						<tr>  
							<td align="center" colspan="3" >There is no records.  </td>
						</tr>  
					<?php } ?> 
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?php echo base_url('Add-New-Company'); ?>" class="btn btn-sm btn-info btn-flat pull-left">Add New </a>
              <a href="<?php echo base_url('companies'); ?>" class="btn btn-sm btn-default btn-flat pull-right">View All</a>
            </div>
            <!-- /.box-footer -->
          </div> 
		  
          </div>
		  
		  <div class="col-lg-6 col-xs-6">
			
			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Recently Added New Opportunity</h3>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Company Name</th> 
					<th>Opportunity Name</th> 
                  </tr>
                  </thead>
                  <tbody>
					<?php if(count($new_company)>0){ foreach($new_company as $row){ ?>
						<tr>
							<td ><a href="<?php echo base_url('view-company/'.$row['CompanyID']); ?>" ><?php echo $row['CompanyName']; ?></a></td>		
							<td ><a href="<?php echo base_url('View-Opportunity/'.$row['OpportunityID']); ?>" ><?php echo $row['OpportunityName']; ?></a></td>
						</tr>  
					<?php }}else{ ?>
						<tr>  
							<td align="center" colspan="3" >There is no records.  </td>
						</tr>  
					<?php } ?>	
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?php echo base_url('Add-Opportunity'); ?>" class="btn btn-sm btn-info btn-flat pull-left">Add New </a>
              <a href="<?php echo base_url('opportunities'); ?>" class="btn btn-sm btn-default btn-flat pull-right">View All</a>
            </div>
            <!-- /.box-footer -->
          </div>  
          </div> 
		   
		  
    </section>
</div>