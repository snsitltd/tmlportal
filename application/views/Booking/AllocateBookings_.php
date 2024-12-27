<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i>Allocate Booking </h1>    </section> 
    <section class="content"> 
		<?php 
			$error = $this->session->flashdata('error');
			if($error){
		?>
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('error'); ?>                    
		</div>
		<?php } ?>
		<?php  
			$success = $this->session->flashdata('success');
			if($success){
		?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('success'); ?>
		</div>
		<?php } ?> 
        <!-- <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url('AddBooking'); ?>"><i class="fa fa-plus"></i> Add Booking</a> 
                </div> 
            </div>
        </div> -->
        <div class="row">
            <div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Approved Booking List</h3>
					</div> 
					<div class="box-body">
						<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
							  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
							  <thead>
								<tr> 
									<th width="10" align="right">BNO </th>                        
									<th width="100" >Date Time </th>                        
									<th >Company Name</th>
									<th >Site Name</th>    
									<th >Material</th>    
									<th width="20" >Loads</th>     
									<th >Tip Address</th>    
									<th >Driver (Lorry No)</th>    
									<th >Action</th>    
								</tr>
								</thead> 
								<tbody>
								<?php if(!empty($AllocateBookings)){
								foreach($AllocateBookings as $key=>$record){ ?>
								<tr> 
									<td align="right" data-sort="<?php echo $record->BookingID; ?>" ><?php echo $record->BookingID; ?></td>   
									<td align="right" data-sort="<?php echo $record->BookingDateTime; ?>" > <?php echo $record->BookingDateTime; ?></td>                        
									<td><a href="<?php echo base_url().'view-company/'.$record->CompanyID; ?>" ><?php echo $record->CompanyName ?></a></td>
									<td><?php echo $record->OpportunityName ?></td> 
									<td><?php echo $record->MaterialName ?></td> 
									<td><?php if($record->LoadType =='1' ){ echo $record->Loads; } if($record->LoadType =='2' ){ echo "Turn Around +".$record->Loads." Days"; }  ?></td> 
									<td><select  id="TipAddress" name="TipAddress" style="width:20px" >
											<option value="1">1</option>                                                                               
                                        </select></td> 
									<td><select  id="TipAddress" name="TipAddress" style="width:20px" >
											<option value="1">Driver</option>                                        
											                                                
                                        </select></td>
									<td><a class="btn btn-info" herf="#" title="Allocate"><i class="fa fa-check"></i></a></td>
									
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
    </section>
</div>  