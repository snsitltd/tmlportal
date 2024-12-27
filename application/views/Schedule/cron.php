<div class="content-wrapper"> 

    <section class="content-header">
      <h1> <i class="fa fa-users"></i> Run Cron Job Manually  </h1>
    </section> 
    <section class="content">  
	<div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Company List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                        <th width="20" >No</th>
                        <th >Database Table Name </th>
                        <th width="100" >Action</th>  
                    </tr>
                    </thead>
                    <tbody> 
                    <tr>
                        <td>1. </td> 
                        <td>tbl_company</td> 
						<td><a href="<?php echo base_url("cron/company.php"); ?>" class="btn btn-primary" target="_blank" > Run Cron </a></td>   
                    </tr> 
					<tr>
                        <td>2. </td> 
                        <td>tbl_company_to_contact</td> 
						<td><a href="<?php echo base_url("cron/company_to_contact.php"); ?>" class="btn btn-primary" target="_blank" > Run Cron </a> </td>   
                    </tr> 
					<tr>
                        <td>3. </td> 
                        <td>tbl_contacts</td> 
						<td><a href="<?php echo base_url("cron/contact.php"); ?>" class="btn btn-primary" target="_blank" > Run Cron </a></td>   
                    </tr> 
					<tr>
                        <td>4. </td> 
                        <td>tbl_opportunities</td> 
						<td><a href="<?php echo base_url("cron/oppo.php"); ?>" class="btn btn-primary" target="_blank" > Run Cron </a></td>   
                    </tr> 
					<tr>
                        <td>5. </td> 
                        <td>tbl_company_to_opportunities</td> 
						<td><a href="<?php echo base_url("cron/company_to_oppo.php"); ?>" class="btn btn-primary" target="_blank" > Run Cron </a></td>   
                    </tr> 
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