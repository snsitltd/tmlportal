<div class="content-wrapper"> 
    <section class="content-header"><h1><i class="fa fa-users"></i> Material Reports </h1></section>    
    <section class="content"> 
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->                 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Material Reports</h3>
                    </div><!-- /.box-header -->
                    <!-- form start --> 
                    <form role="form" action="<?php echo base_url('MaterialReports') ?>" method="post" id="MaterialReports" >
                        <div class="box-body">
                            <div class="row">
								<div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="role">Ticket Type</label>
                                        <select class="form-control" name="tickettype" id="tickettype" data-live-search="true" >
                                            <option value="">ALL Types</option> 
                                             <option value="In" <?php if(set_value('tickettype') =="In"){ ?> selected <?php } ?> >IN</option> 
											 <option value="Out"  <?php if(set_value('tickettype') =="Out"){ ?> selected <?php } ?> >OUT</option> 
                                        </select> 
                                    </div> 
                                </div>   
								<div class="col-md-2">                                
                                    <div class="form-group">
									   <label for="role">TML Type</label>
                                       <select class="form-control" name="tml" id="tml"  data-live-search="true" >
                                             <option value="" <?php if(set_value('tml')==""){ echo "Selected";} ?>>ALL</option>  
											 <option value="1" <?php if(set_value('tml')=='1'){ echo "Selected";} ?>>TML</option> 
											 <option value="0" <?php if(set_value('tml')=='0'){ echo "Selected";} ?>>NON TML</option> 
                                        </select>
                                    </div> 
                                </div>
								<div class="col-md-3">                                
                                    <div class="form-group">
									   <label for="role">Payment Type</label>
                                       <select class="form-control" name="payType[]" id="payType" multiple  data-live-search="true" >  
											<option value="0"  <?php if(set_value('payType')){ if (in_array("0", set_value('payType'))){ echo "selected"; }} ?> >CREDIT </option> 
											<option value="1" <?php if(set_value('payType')){  if (in_array("1", set_value('payType'))){  echo "selected"; }} ?>  >CASH</option> 
											<option value="2" <?php if(set_value('payType')){  if (in_array("2", set_value('payType'))){ echo "selected"; }} ?> >CARD</option>  
                                        </select> 
                                    </div> 
                                </div>
							</div>
							<div class="row">		
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                       <label for="role">Users</label>
                                       <select class="form-control" name="user[]" id="user" multiple data-live-search="true" > 
                                            <?php foreach($Users as $value){ ?>
                                             <option value="<?php echo $value->userId; ?>"  <?php if(set_value('user')){ if (in_array($value->userId, set_value('user'))){ echo "selected"; }} ?> ><?php echo $value->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> 
                                </div>
								<div class="col-md-4">     
									<div class="form-group">
										<label>Date range:</label> 
										<div class="input-group">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
										  <input type="text" class="form-control pull-right"  autocomplete="off"   id="reservation" required="" name="searchdate" value="<?php echo (set_value('searchdate')!=''?set_value('searchdate') : date('d/m/Y').'-'.date('d/m/Y'));?>">
										</div> 
									</div>                            
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-6"> </div> 
                            </div>     
                        </div> 
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Search" />
                            <?php if(!empty($ticketsRecords)){ ?>
                               <input type="submit" class="btn btn-primary" value="Export XLS"  name="export" />
							   <input type="submit" class="btn btn-primary" value="Export PDF"  name="export1" />
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>  
        </div> 
          <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header"><h3 class="box-title">Material Reports</h3></div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                   <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">   
					<thead>
                    <tr> 					
						<th width="40"> Type</th>	 
						<th>Material Name</th>    	
						<th width="50">Loads</th>    	
						<th width="100">Net in Tonnes</th>    
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(!empty($ticketsRecords)){ 
                        foreach($ticketsRecords as $key=>$record){ ?> 
                    <tr> 
						<td><?php echo $record->TypeOfTicket; ?></td>
						<td><?php echo $record->MaterialName ?></td>  
						<td><?php echo $record->CountLoads ?></td>  
                        <td align="right" ><?php echo $record->net_tonnes ?></td>  
                    </tr>
                    <?php } } ?>
                    </tbody>
                  </table> 
              </div></div></div>
            </div>
            <!-- /.box-body -->
          </div>
            </div>
        </div>    
    </section>
</div> 
<script src="<?php echo base_url(); ?>assets/js/Report.js" type="text/javascript"></script>