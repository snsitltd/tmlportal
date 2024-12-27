<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Dummy NonApp Users Loads/Lorry </h1>    </section> 
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
		<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:1200px">  
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">  NonApp Users Loads/Lorry Information </h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div> 
				  <div class="modal-body"></div> 
				  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div> 
				</div>
			</div>
		</div>   
		<?php //var_dump($NonAppsLoads); ?>
		<div class="row"> 
			<div class="col-md-12">   
				<div class="row">
					<div class="col-xs-12">
						<form id="subcontractor" name="subcontractor" action="<?php echo base_url('NonAppsLoads'); ?>" method="post" role="form" > 
						<div class="box"> 
							<div class="box-body"> 
								<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
								   <table id="example" class="display" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th></th>
												<th>First name</th>
												<th>Last name</th>
												<th>Position</th>
												<th>Office</th>
												<th width="18%">Start date</th>
												<th>Salary</th>
											</tr>
										</thead>
									</table>
								</div> 
							</div>
							</div>
							</div> 
							</form>	
						</div> 
					</div>
				</div>  
			</div> 
        </div>
    </section>
</div>  
<script type="text/javascript" language="javascript" >
	var editor; // use a global for the submit and return data rendering in the examples
 
$(document).ready(function() {
    editor = new $.fn.dataTable.Editor( {
        ajax: "../php/staff.php",
        table: "#example",
        fields: [ {
                label: "First name:",
                name: "first_name"
            }, {
                label: "Last name:",
                name: "last_name"
            }, {
                label: "Position:",
                name: "position"
            }, {
                label: "Office:",
                name: "office"
            }, {
                label: "Extension:",
                name: "extn"
            }, {
                label: "Start date:",
                name: "start_date",
                type: "datetime"
            }, {
                label: "Salary:",
                name: "salary"
            }
        ]
    } );
 
    // Activate an inline edit on click of a table cell
    $('#example').on( 'click', 'tbody td:not(:first-child)', function (e) {
        editor.inline( this );
    } );
 
    $('#example').DataTable( {
        dom: "Bfrtip",
        ajax: "../php/staff.php",
        order: [[ 1, 'asc' ]],
        columns: [
            {
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false
            },
            { data: "first_name" },
            { data: "last_name" },
            { data: "position" },
            { data: "office" },
            { data: "start_date" },
            { data: "salary", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) }
        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        buttons: [
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor }
        ]
    } );
} );
</script>