<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Opportunity Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section> 
    <section class="content"> 
		<?php
			$this->load->helper('form');
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

        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url('Add-Opportunity'); ?>"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Opportunity List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                        <th width="10" >No</th>
                        <th>Site Address</th>
                        <th width="70" >Town</th>
                        <th width="70" >County</th>
                        <th width="70" >Post Code</th>
                        <th>CompanyName</th>                        
                        <th class="text-center" width="100" >Actions</th>
                    </tr>
                    </thead>
                      <tbody>
                    <?php
                    if(!empty($opportunityRecords)){
                        foreach($opportunityRecords as $key=>$record){
                    ?>
                    <tr>
                        <td><?php echo $key+1 ?></td>
                        <td><a href="<?php echo base_url().'View-Opportunity/'.$record->OpportunityID; ?>" ><?php echo $record->OpportunityName; ?></a></td>
                        <td><?php echo $record->Town ?></td>
                        <td><?php echo $record->County ?></td>
                        <td><?php echo $record->PostCode ?></td>
                        <td><a href="<?php echo base_url().'view-company/'.$record->CompanyID; ?>" ><?php echo $record->CompanyName ?></a></td> 	 
                        <td class="text-center">                            
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'View-Opportunity/'.$record->OpportunityID; ?>" title="View"><i class="fa fa-eye"></i></a>
							<a class="btn btn-sm btn-info" href="<?php echo base_url().'edit-Opportunity/'.$record->OpportunityID; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteOpportunity" href="#" data-OpportunityID="<?php echo $record->OpportunityID; ?>" title="Delete"><i class="fa fa-trash"></i></a>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Opportunity.js" charset="utf-8"></script>
