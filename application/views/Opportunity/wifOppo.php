<div class="content-wrapper"> 
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> WIF FORMS | Opportunity  
      </h1>
    </section> 
    <section class="content">   
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Opportunity List with WIF Forms</h3>
            </div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                        <th>Site Address</th> 
                        <th width="500">Company Name</th>  
						<th width="150">WIF Forms (DOC NO.)</th>    
                    </tr>
                    </thead>
                      <tbody>
                    <?php
                    if(!empty($opportunityRecords)){
                        foreach($opportunityRecords as $key=>$record){
                    ?>
                    <tr> 
                        <td><a href="<?php echo base_url().'View-Opportunity/'.$record->OpportunityID; ?>" ><?php echo $record->OpportunityName; ?></a></td> 
                        <td><a href="<?php echo base_url().'view-company/'.$record->CompanyID; ?>" ><?php echo $record->CompanyName ?></a></td> 	  
						<td><a href="<?php echo base_url('assets/Documents/'.$record->DocumentAttachment ) ?>" target="_blank" title=" View WIF FORM" >
						<?php if($record->DocumentNumber!=""){ echo $record->DocumentNumber; }else{ echo "View"; } ?></a></td> 	    
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                  </table>

              </div></div></div>
            </div> 
          </div> 
            </div>
        </div>
    </section>
</div> 