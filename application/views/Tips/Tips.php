<div class="content-wrapper"> 
    <section class="content-header">
    <h1><i class="fa fa-users"></i> Tip Address <small>Add, Edit, Delete</small></h1>
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
                    <?php if($isAdd==1){?><a class="btn btn-primary" href="<?php echo base_url('AddTip'); ?>"><i class="fa fa-plus"></i> Add New</a><?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">List Of Tip Addresses</h3>
            </div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="Tips" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                        <th>Tip Name</th>
                        <th>Tip Address</th> 
                        <th  width="70" >HAZ</th>
						<th  width="70" >Price</th>
						<th  width="70" >Town</th>
                        <th  width="70" >County</th>
                        <th width="70" >PostCode</th>  
                        <th class="text-center" width="100" >Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($TipRecords)){
                        foreach($TipRecords as $key=>$record){ ?>
                    <tr> 
                        <td><?php echo $record->TipName ?></td>
                        <td><?php echo $record->Street1." ".$record->Street2 ?></td> 
						<td><?php if($record->HType==1){ echo "HAZ"; }else{ echo "NON HAZ"; } ?></td>
                        <td><?php echo $record->Price ?></td>
						<td><?php echo $record->Town ?></td>
                        <td><?php echo $record->County ?></td>
                        <td><?php echo $record->PostCode ?></td>  
                        <td class="text-center">  
						   <?php if($isEdit==1){?> <a class="btn btn-sm btn-info" href="<?php echo base_url('EditTip/'.trim($record->TipID)); ?>" title="Edit"><i class="fa fa-pencil"></i></a><?php } ?> 
                           <?php if($isDelete==1){?><a class="btn btn-sm btn-danger DeleteTip" href="#" data-TipID="<?php echo $record->TipID; ?>" title="Delete"><i class="fa fa-trash"></i></a><?php } ?>
						   <a class="btn btn-sm btn-info" href="<?php echo base_url('ViewTipTickets/'.trim($record->TipID)); ?>" title="View Tip Tickets"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
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

<script type="text/javascript"> 
    $(function () {  
        $('#Tips').DataTable({
			"order": [[ 0, "asc" ]], 
			"pageLength": 100,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>" 
		}); 
    }) 
	 
	
</script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/Tip.js'); ?>" charset="utf-8"></script> 