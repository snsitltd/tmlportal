<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> User Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">

     <?php $this->load->helper('form'); ?> 

<div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                 
                                <th class='black-cell'>No</th>
                                <th class='black-cell'>Invoice No</a></th>                                
                                <th scope='col'>Invoice Date</a></th>
                                <th scope='col'>Customer Name</a></th>
                                <th scope='col'>Job Site Address</a></th>
                                <th scope='col'>TML Ref</a></th>
                                <th scope='col'>Ticket List</th>
                                <th scope='col'>Tickets</th>
                                <th scope='col'>Select All</th>                                                        
                               

                  
                    </tr>
                    </thead>
                      <tbody>
                    <?php
                    if(!empty($invoice_list))
                    {
                        foreach($invoice_list as $key=> $row)
                        { ?>
                        
                        <tr>
                        <td><?php echo $row['start'] ?></td>
                        <td><a href="<?php echo base_url("gen_invoices/").$row['INVOICE_NUMBER']?>" target='_blank'><?php echo $row['INVOICE_NUMBER']?></td>
                        <td><?php echo date(DATE_FORMATE , strtotime($row['invdt'])) ?></td>
                         <td><?php echo $row['cust_name'] ?></td>
                          <td><?php echo $row['job_site_address']?></td>
                          <td><?php echo $row['TML_Ref']?></td> 
                          <?php 
                           
                        if(file_exists($row['filename1'])) { ?>

                        <td><a href='#' style='cursor: pointer' onclick="viewxls("<?php echo $row['filename1']?>");"><font style='display:none;'><?php echo $row['path1']?></font><img width='30' height='30' src='<?php echo  base_url('assets/images/excel_icon.gif')?>' style='height:30px !important; width:30px !important;'/> </a></td>


                      <?php   }else{ ?>

                        <td><a href='#' style='cursor: pointer' onclick = "alert('No file available on Path:  $path');"><font style='display:none;'><?php echo $row['path1']?> </font><img width='30' height='30' src='<?php echo  base_url('assets/images/excel_icon.gif')?>' style='height:30px !important; width:30px !important;'/> </a></td>

                     <?php } ?>

                         <td>
                         <a href="#"> <?php echo $row['Pages_No']?> </a>                         
                         <input type='hidden' id='cust_remote_url' value="<?php echo $row['path']?>"/>
                         </td>

                         <td><input id='list_invoice_$cnt' type='checkbox' value="<?php echo $row['INVOICE_NUMBER']?>" name='list_invoices[]' style='width:50px !important;' /></td>


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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });
    });

    function viewxls(filename)
    { 
        
      
        url = document.location.href;
        xend = url.lastIndexOf("/") + 1;
        var base_url = url.substring(0, xend);
        url="ajax.php";
         if (url.substring(0, 4) != 'http') {
            url = base_url + url;       
        }
        var strSubmit="filename="+filename; 
        var strURL = url;
        
        var strResultFunc = "displaysubResult2";
        xmlhttpPost(strURL, strSubmit, strResultFunc)
        return true; 
        
    }

    function displaysubResult2(strIn) 
    {   
    document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'
        document.getElementById('light').innerHTML=strIn;
    }

</script>
