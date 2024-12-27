<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"> 
      <h1>
        <i class="fa fa-users"></i> Opportunity Management
        <small><?php echo $opInfo['OpportunityName']; ?></small>
      </h1>
    </section>
     <section class="content"> 
		<h4> <b>Company Name: <a href="<?php echo base_url().'view-company/'.$opInfo['CompanyID']; ?>" ><?=$opInfo['CompanyName']?></a></b></h4>
        <div class="row"> 
        <div class="col-md-12">
          <div class="nav-tabs-custom"> 
            <div class="tab-content"> 
              <div class="tab-pane active" id="activity">  
			  <form id="OpportunityCompanysubmit" action="<?php echo base_url('edit-Opportunity-Company/'.$opInfo['OpportunityID']) ?>" method="post" role="form"  >
			  <?php 
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
			    <b><?php echo validation_errors(); ?> </b>
				<input type="hidden" name="OpportunityID" value="<?=$opInfo['OpportunityID']?>">
				<div class="box-body"> 
					<div class="row">  	
						<div class="col-md-4">
							<div class="form-group"> 
								<select class="form-control" id="CompanyID" name="CompanyID"  data-live-search="true" >
									<option value="">-- SELECT COMPANY NAME --</option>
									<?php if(!empty($company_list)){
										foreach ($company_list as $rl){ if($rl['CompanyName']!=""){ ?>
											<option value="<?php echo $rl['CompanyID'] ?>" <?php if($opInfo['CompanyID'] == $rl['CompanyID'] ){ ?> selected <?php } ?>  >
											<?php echo $rl['CompanyName'] ?></option>
									<?php }}} ?>
								</select> 
							</div>
						</div>    
						<div class="col-md-2">
							<div class="form-group"> 
								<input type="submit" name="submit" class="btn btn-primary" value="UPDATE" />  
							</div>
						</div>  
					</div>  
					</div> 
				</div> 
              </form> 
			  <div class="row" style="margin:3px">  
				<div class="box-body"> 
				  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">  
					<table id="example3" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                        <th width="10" align="right">No </th>                        
                        <th >Company Name</th>
                        <th width="50">Veh.No</th>
                        <th width="100">Driver Name</th>
                        <th width="40">Gross</th>
                        <th width="40">Tare</th>
                        <th width="40">Net</th>
                        <th width="45">Date</th> 
                        <th width="50">Operation</th>  
						<th class="text-center" width="120">Actions</th>						
                    </tr>
                    </thead>
                      <tbody>
                    <?php if(!empty($ticketsRecords)){
                        foreach($ticketsRecords as $key=>$record){ ?>
                    <tr> 
                        <td align="right" ><?php echo $record->TicketNumber; ?></td>                        
                        <td><a href="<?php echo base_url().'view-company/'.$record->CompanyID; ?>" ><?php echo $record->CompanyName ?></a></td>
                        <td><?php echo $record->RegNumber ?></td>
                        <td><a href="<?php echo base_url().'viewDriver/'.$record->driver_id; ?>" ><?php echo $record->DriverName ?></a></td>
                        <td align="right" ><?php echo $record->GrossWeight ?></td>
                        <td align="right" ><?php echo $record->Tare ?></td>
                        <td align="right" ><?php echo $record->Net ?></td>
                        <td><?php echo substr($record->TicketDate,0,10); ?></td> 
                        <td><?php echo $record->TypeOfTicket ?></td>   
						<td class="text-center" >                            
                          <?php if($record->pdf_name != "") {?>  <a class="btn btn-sm btn-warning" target="blank" href="<?php echo base_url().'assets/pdf_file/'.$record->pdf_name; ?>" title="View PDF"><i class="fa fa-file-pdf-o"></i></a><?php }?>
						  <a class="btn btn-sm btn-info" href="<?php echo base_url().'View-'.$record->TypeOfTicket.'-Ticket/'.$record->TicketNumber; ?>" title="View"><i class="fa fa-eye"></i></a> 
                        </td> 
                    </tr>
                    <?php } } ?>
                    </tbody>
                  </table>    
				  </div>
				</div>   
			  </div>  
			  </div> 
              </div> 
          </div> 
        </div> 
        </div>    
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/js/Opportunity.js" type="text/javascript"></script> 