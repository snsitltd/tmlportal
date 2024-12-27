<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> County Management
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-county">
                <i class="fa fa-plus"></i> Add New
              </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">County List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                        <th width="50">S.No</th>                        
                        <th>County Name</th>                                              
                        <th width="100" class="text-center">Actions</th>
                    </tr>
                    </thead>
                      <tbody>
                    <?php
                    if(!empty($countyList))
                    {
                        foreach($countyList as $key=>$record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $key+1 ?></td>                        
                        <td><?php echo $record->County ?></td>
                        <td class="text-center">                            
                            <a class="btn btn-sm btn-info county-edit-model" href="javascript:void(0)" title="Edit" data-toggle="modal" data-target="#county-edit-model" data-ID="<?php echo $record->ID  ?>" data-County="<?php echo $record->County  ?>" ><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteCounty" href="#" data-ID="<?php echo $record->ID; ?>" title="Delete"><i class="fa fa-trash"></i></a>

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
<script src="<?= base_url('assets/validation/dist/parsley.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/County.js" charset="utf-8"></script>


<div class="modal fade" id="modal-add-county">
          <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Add County</h4>
                        </div>
                        <div class="modal-body">
                    <form class="form-horizontal form-label-left" data-parsley-validate action="<?=base_url('addnewcountysubmit')?>" method="post">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">County Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="name" class="form-control col-md-7 col-xs-12" 
                                          name="County" placeholder="County name" required minlength="2" maxlength="128" type="text">
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button id="send" type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                      </div>
                    </div>
        </div>
        <!-- /.modal -->



        <div class="modal fade" id="county-edit-model">
          <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Edit County</h4>
                        </div>
                        <div class="modal-body">
                    <form class="form-horizontal form-label-left" data-parsley-validate action="<?=base_url('editcountysubmit')?>" method="post">


                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EditID">County ID <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="EditID" class="form-control col-md-7 col-xs-12" 
                                          name="ID" type="text" readonly="readonly">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EditCounty">County Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="EditCounty" class="form-control col-md-7 col-xs-12" 
                                          name="County" placeholder="County name" required minlength="2" maxlength="128" type="text">
                                    </div>
                                </div>


                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button id="send" type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                      </div>
                    </div>
        </div>
        <!-- /.modal -->




