<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Company Management
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
                    <?php if($isAdd==1){?><a class="btn btn-primary" href="<?php echo base_url(); ?>Add-New-Company"><i class="fa fa-plus"></i> Add New</a><?php } ?>
                </div>
            </div>
        </div>
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
                        <th width="40" >No</th>
                        <th>Company Name</th>
                        <th>Email</th> 
                        <th  width="70" >Town</th>
                        <th  width="70" >County</th>
                        <th width="70" >PostCode</th>
                        <th width="70" >Phone Number</th> 
                        <th  width="30" >Status</th>
                        <th class="text-center" width="100" >Actions</th>
                    </tr>
                    </thead>
                      <tbody>
                    <?php
                    if(!empty($companyRecords))
                    {
                        foreach($companyRecords as $key=>$record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $key+1 ?></td>
                        <td><a href="<?php echo base_url().'view-company/'.trim($record->CompanyID); ?>" ><?php echo $record->CompanyName ?></a></td>
                        <td><?php echo $record->EmailID ?></td> 
                        <td><?php echo $record->Town ?></td>
                        <td><?php echo $record->County ?></td>
                        <td><?php echo $record->PostCode ?></td>
                        <td><?php echo $record->Phone1 ?></td> 
                        <td>

                        <?php if($isEdit==1){?>

                        <?php if($record->Status==1){?>

                        <a href="javascript:void(0)" class="company_status_deactive label label-success" data-table-name="company" data-id="<?php echo $record->CompanyID; ?>"  >Active</a>

                        <?php } else{ ?>

                         <a href="javascript:void(0)" class="company_status_active label label-danger" data-table-name="company" data-id="<?php echo $record->CompanyID; ?>" >Deactive</a>

                          <?php  }?>

                          <?php  } else{ ?>


                           <?php if($record->Status==1){?>

                        <a href="javascript:void(0)" class="label label-success" data-table-name="company" data-id="<?php echo $record->CompanyID; ?>"  >Active</a>

                        <?php } else{ ?>

                         <a href="javascript:void(0)" class="label label-danger" data-table-name="company" data-id="<?php echo $record->CompanyID; ?>" >Deactive</a>

                          <?php  }?>


                            <?php  }?>

                        </td>
                        <td class="text-center">

                           <?php if($isView==1){?> <a class="btn btn-sm btn-info" href="<?php echo base_url().'view-company/'.trim($record->CompanyID); ?>" title="View"><i class="fa fa-eye"></i></a><?php  }?>
						   <?php if($isEdit==1){?> <a class="btn btn-sm btn-info" href="<?php echo base_url().'edit-company/'.trim($record->CompanyID); ?>" title="Edit"><i class="fa fa-pencil"></i></a><?php  }?>

                            <?php if($isDelete==1){?><a class="btn btn-sm btn-danger deleteCompany" href="#" data-CompanyID="<?php echo $record->CompanyID; ?>" title="Delete"><i class="fa fa-trash"></i></a><?php  }?>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Company.js" charset="utf-8"></script>

