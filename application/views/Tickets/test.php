<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"> <h1> <i class="fa fa-users"></i> TEST    </h1>    </section> 
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>In-Tickets"><i class="fa fa-plus"></i> Add In Ticket</a>
                     <a class="btn btn-primary" href="<?php echo base_url(); ?>Out-Tickets"><i class="fa fa-plus"></i> Add Out Ticket</a>
                      <a class="btn btn-primary" href="<?php echo base_url(); ?>Collection-Tickets"><i class="fa fa-plus"></i> Add Collection Ticket</a>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Tickets List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                        <th width="10" align="right">T.No </th>                        
						<th width="100" >Date </th>                        
                        <th >Company Name</th>
						<th >Site Name</th>
						<th width="50">Lorry No</th>
                        <th width="50">Veh.No</th>
                        <th width="100">Driver Name</th> 
                        <th width="40">Gross</th>
                        <th width="40">Tare</th>
                        <th width="40">Net</th> 
                        <th width="50">Operation</th>  
                        <th class="text-center" width="150">Actions</th>
                    </tr>
                    </thead>
                       
                  </table> 
              </div></div></div>
            </div> 
          </div> 
            </div>
        </div>
    </section>
</div> 