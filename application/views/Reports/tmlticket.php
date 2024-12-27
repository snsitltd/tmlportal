 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> TML IN-OUT Ticket Report
        <small>TML IN-OUT Ticket Report</small>
      </h1>
    </section> 
    <section class="content"> 
        <div class="row"> 
            <div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">TML IN-OUT Ticket Report</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->  
                    <form role="form" action="<?php echo current_url() ?>" method="post" id="tickeReport" role="form">
                        <div class="box-body"> 
                            <div class="row">
								<div class="col-md-3">                                
                                    <div class="form-group">
                                       <label for="role">Ticket Type</label>
                                       <select class="form-control" name="ttype[]" id="ttype" multiple  data-live-search="true" >  
											<option value="In"  <?php if(set_value('ttype')){ if (in_array("In", set_value('ttype'))){ echo "selected"; }} ?> >IN </option> 
											<option value="Out" <?php if(set_value('ttype')){  if (in_array("Out", set_value('ttype'))){  echo "selected"; }} ?>  >OUT</option> 
											<option value="Collection" <?php if(set_value('ttype')){  if (in_array("Collection", set_value('ttype'))){ echo "selected"; }} ?> >COLLECTION</option> 
											  
                                        </select> 
                                    </div> 
                                </div> 
								<div class="col-md-3">                                
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
								<!--<div class="col-md-3">                                
                                    <div class="form-group">
                                       <label for="role">Users</label>
                                       <select class="form-control" name="user[]" id="user" multiple data-live-search="true" >
                                            <option value="">All Users</option>
                                            <?php foreach($Users as $value){ ?>
                                             <option value="<?php echo $value->userId; ?>" <?php if(set_value('user')==$value->userId){ echo "Selected";} ?>><?php echo $value->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> 
                                </div>-->
							</div> 
							<div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="role">Customer</label>
                                        <select class="form-control" name="customer" id="customer"  data-live-search="true" >
											<option value=""> SELECT COMPANY </option>
                                            <?php foreach ($company_list as $key => $value) { ?>
											  <option value="<?php echo $value['CompanyID']; ?>" <?php if(set_value('customer')==$value['CompanyID']){ echo "Selected";} ?> ><?php echo $value['CompanyName']; ?></option>
											<?php } ?> 
                                        </select> 
                                    </div>
                                    <input type="radio" name="report" value="1"  <?php if(set_value('report')==1){ echo "checked"; } ?>  checked > CompanyWise ( For Export Only )
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="role">Material</label>
                                       <select class="form-control" name="material" id="material"  data-live-search="true" >
                                            <option value="">Select Material</option>
                                            <?php foreach($materialsRecords as $value){ ?>
                                             <option value="<?php echo $value->MaterialID; ?>" <?php if(set_value('material')==$value->MaterialID){ echo "Selected";} ?>><?php echo $value->MaterialName ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
									<input type="radio" name="report" value="2"  <?php if(set_value('report')==2){ echo "checked"; } ?> > MaterialWise	( For Export Only )
                                </div>
                                <div class="col-md-4">     
                                <div class="form-group">
                                    <label>Date range:</label> 
                                    <div class="input-group">
                                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                      <input type="text" class="form-control pull-right" id="reservation"  autocomplete="off"    required="" name="searchdate" value="<?php echo (set_value('searchdate')!=''?set_value('searchdate') : date('m/d/Y').'-'.date('m/d/Y'));?>">
                                    </div> 
									<input type="radio" name="order" value="ASC"  <?php if(set_value('order')!="") { if(set_value('order')=='ASC' ){ echo "checked"; } }else{ echo "checked";  } ?> > Ascending   
									<input type="radio" name="order" value="DESC"  <?php if(set_value('order')=='DESC'){ echo "checked"; } ?> > Descending
                                </div>             
                                </div> 
                            </div>   
                        </div>  
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Search" />
                            <?php if(!empty($ticketsRecords))
                              { ?>
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
            <div class="box-header"><h3 class="box-title">TML IN-OUT Ticket Report List</h3></div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">   
                  <thead>
                    <tr>        					
                        <th width="50">Date</th>
						<th>Conveyance</th>
						<th width="50">LorryNo</th>
                        <th width="80">Vehicle Rno</th>
                        <th>Site Address</th> 
                        <th width="70" >Gross</th>
                        <th width="70">Tare</th>
                        <th width="70">Net</th>  
                        <th width="50" class="text-center" >Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($ticketsRecords)){  $class = '';
                        foreach($ticketsRecords as $key=>$record){ if($record->LoadID!=0){ $class = 'even1'; }else{ $class = ''; } 
                    ?> 
                    <tr class="<?php echo $class; ?>" > 
                        <td><?php echo $record->TicketDate; ?></td>
						<td><?php echo $record->Conveyance ?></td>
                        <td><?php echo $record->driver_id ?></td>
                        <td><?php echo $record->RegNumber ?></td>
                        <td><?php echo $record->SiteName; ?></td> 
                        <td align="right" ><?php echo round($record->GrossWeight) ?></td>
                        <td align="right" ><?php echo round($record->Tare) ?></td>
                        <td align="right" ><?php echo round($record->Net) ?></td> 
                        <td class="text-center">                            
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'view-ticket/'.$record->TicketNumber; ?>" title="View" target="_blank"><i class="fa fa-eye"></i></a> 
                        </td> 
                    </tr>
                    <?php
                        }
                    }
                    ?>
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