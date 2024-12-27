<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><h1><i class="fa fa-users"></i> Content Settings </h1></section>
    <section class="content">
    <?php
		$this->load->helper('form');
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
		if($success)
		{
	?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<?php echo $this->session->flashdata('success'); ?>
	</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-md-12">
			<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
		</div>
	</div>
                
    
        <div class="row">
            <!-- left column -->

            <div class="col-md-12">
              <!-- general form elements --> 
            
                <div class="box box-primary">
                    <div class="box-header">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Company Details</a></li>
                          <li class=""><a href="#in_pdf" data-toggle="tab" aria-expanded="false">In /  Collection Header</a></li>   
                           <li class=""><a href="#out_pdf" data-toggle="tab" aria-expanded="false">Out Header</a></li>           
                        </ul>
                    <!--  <h3 class="box-title">Enter Details</h3> -->
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <div class="tab-content">
                        <div  class="tab-pane active" id="activity">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="submitcontent" action="<?php echo base_url() ?>submitcontent" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $content['id'] ?>" name="id">
                    <input type="hidden" value="<?php echo $content['logo'] ?>" name="oldlogo">
                        <div class="box-body"> 
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Company title <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['title'] ?>" id="title" name="title" maxlength="128" required >
                                    </div>         
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Sub title <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['subtitle'] ?>" id="title" name="subtitle" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>

                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Version <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['version'] ?>" id="title" name="version" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                           
							<hr>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="VATRegNo">Vat Registration No. <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['VATRegNo'] ?>" id="VATRegNo" name="VATRegNo" maxlength="128" required >
                                    </div>         
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CompanyRegNo">Company Registration No. <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['CompanyRegNo'] ?>" id="CompanyRegNo" name="CompanyRegNo" maxlength="128" required >
                                    </div>         
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="FooterText">Footer Text <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['FooterText'] ?>" id="FooterText" name="FooterText" maxlength="128" required >
                                    </div>         
                                </div> 
                            </div>
                            <hr>
						   <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Ticket Limit <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['ticket_limit'] ?>" id="ticket_limit" name="ticket_limit" maxlength="5" required>
                                    </div> 
                                </div>                              
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Ticket Limit (WIF Tolerance ) <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['ticket_limit2'] ?>" id="ticket_limit2" name="ticket_limit2" maxlength="5" required>
                                    </div> 
                                </div>                              
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="TicketStart">First Ticket Number <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['TicketStart'] ?>" id="TicketStart" name="TicketStart" maxlength="10" required>
                                    </div> 
                                </div>                              
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="TicketStart">First Conveyance Number <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['ConveyanceStart'] ?>" id="ConveyanceStart" name="ConveyanceStart" maxlength="10" required>
                                    </div> 
                                </div>                              
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">VAT (%) <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['vat'] ?>" id="vat" name="vat" maxlength="6" required>
                                    </div> 
                                </div>                              
                            </div>
                            <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="uploadfile">Company Logo <span class="required" aria-required="true">*</span></label>
                                        <input type="file" name="logo" class="form-control required" id="fileUploadimage">
                                        <img src="<?php echo site_url().'assets/Uploads/Logo/'.$content['logo']?>" width="100">
                                    </div>
                                </div>                                
                            </div>

                            
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit"  class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>

                    </form>

                </div>
                    <div  class="tab-pane " id="in_pdf">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="submitcontent" action="<?php echo base_url() ?>submitheader" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $content['id'] ?>" name="id">
                    <input type="hidden" value="<?php echo $content['header_logo'] ?>" name="oldlogo">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Company Address <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['address'] ?>" id="address" name="address" maxlength="128" required >
                                    </div>
                                    
                                </div>
                              
                            </div>

                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Email <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['email'] ?>" id="email" name="email" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                           <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Phone <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['phone'] ?>" id="phone" name="phone" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Fax <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['fax'] ?>" id="fax" name="fax" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                               <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Website <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['website'] ?>" id="website" name="website" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Reference Number <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['reference'] ?>" id="reference" name="reference" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                              <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Header Des. 1 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['head1'] ?>" id="head1" name="head1" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                              <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Header Des. 2 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['head2'] ?>" id="head2" name="head2" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>

                            <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="uploadfile">Company Header Logo <span class="required" aria-required="true">*</span></label>
                                        <input type="file" name="header_logo" class="form-control required" id="fileUploadimage">
                                        <img src="<?php echo site_url().'assets/Uploads/Logo/'.$content['header_logo']?>" width="100">
                                    </div>
                                </div>                                
                            </div>

                            
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit"   class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>

                    </form>

                </div>
                   <div  class="tab-pane " id="out_pdf">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="submitcontent" action="<?php echo base_url() ?>submitOutHeaderContent" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $content['id'] ?>" name="id">
                    <input type="hidden" value="<?php echo $content['outpdf_header_logo'] ?>" name="oldlogo">
                        <div class="box-body">
                                <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Title <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['outpdf_title'] ?>" id="outpdf_title" name="outpdf_title" maxlength="128" required >
                                    </div>
                                    
                                </div>
                              
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Company Address <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['outpdf_address'] ?>" id="outpdf_address" name="outpdf_address" maxlength="128" required >
                                    </div>
                                    
                                </div>
                              
                            </div>

                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Email <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['outpdf_email'] ?>" id="outpdf_email" name="outpdf_email" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                           <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Phone <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['outpdf_phone'] ?>" id="outpdf_phone" name="outpdf_phone" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Fax <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['outpdf_fax'] ?>" id="outpdf_fax" name="outpdf_fax" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                               <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Website <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['outpdf_website'] ?>" id="outpdf_website" name="outpdf_website" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">WASTE LICENSE  Number <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $content['waste_licence'] ?>" id="waste_licence" name="waste_licence" maxlength="128" required>
                                    </div>
                                    
                                </div>                              
                            </div>
							
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Paragraph 1 </label>
                                        <textarea type="text" class="form-control"  id="outpdf_para1" name="outpdf_para1" rows="4"  ><?php echo $content['outpdf_para1'] ?></textarea>
                                    </div>
                                    
                                </div>                              
                            </div>
							
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Paragraph 2 </label>
                                        <textarea type="text" class="form-control" id="outpdf_para2" name="outpdf_para2" rows="4"  ><?php echo $content['outpdf_para2'] ?></textarea>
                                    </div>
                                    
                                </div>                              
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Paragraph 3 </label>
                                        <textarea type="text" class="form-control"  id="outpdf_para3" name="outpdf_para3" rows="4"  ><?php echo $content['outpdf_para3'] ?></textarea>
                                    </div>
                                    
                                </div>                              
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Paragraph 4 </label>
                                        <textarea type="text" class="form-control" id="outpdf_para4" name="outpdf_para4" rows="4"  ><?php echo $content['outpdf_para4'] ?></textarea>
                                    </div>
                                    
                                </div>                              
                            </div> 
                            <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="uploadfile">Company Header Logo <span class="required" aria-required="true">*</span></label>
                                        <input type="file" name="outpdf_header_logo" class="form-control required" id="fileUploadimage">
                                        <img src="<?php echo site_url().'assets/Uploads/Logo/'.$content['outpdf_header_logo']?>" width="100">
                                    </div>
                                </div>                                
                            </div>

                            
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit"   class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>

                    </form>

                </div>
                </div>
            </div>
            </div>
            
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/schedule.js" type="text/javascript"></script>