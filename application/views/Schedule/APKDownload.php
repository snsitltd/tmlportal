<div class="content-wrapper"> 

    <section class="content-header">
      <h1> <i class="fa fa-users"></i> TML APK Version </h1>
    </section> 
    <section class="content">  
	<div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">List Of Version</h3>
            </div> 
            <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
					<thead>
						<tr>
							<!-- <th width="20" >No</th>-->
							<th width="100" >Title </th>
							<th width="120">Version Date </th> 
							<th >Description </th> 
							<th width="100">Download</th> 
						</tr>
                    </thead>
                    <tbody> 
					<?php if(!empty($APK)){
							foreach($APK as $key=>$record){ ?>
						<tr>
							<!-- <td><?php //echo $key+1 ?></td> -->
							<td><?php echo $record->Title ?></td> 
							<td data-sort='<?php echo $record->VersionDate ?>' ><?php echo $record->vdate ?></td>  
							<td><?php echo $record->Description ?></td>  
							<td><a href="<?php echo base_url("TMLAPK/".$record->URL); ?>" class="btn btn-primary" target="_blank" > Download </a></td>   
						</tr>  
					<?php }} ?>	
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