<!DOCTYPE html>
<html lang="en">
<head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <meta charset="utf-8">


    <style type="text/css">

    ::selection { background-color: #E13300; color: white; }
    ::-moz-selection { background-color: #E13300; color: white; }
    #sty1{
    width: 24%;float: left;height: 50px ;    font-size:12px;
    }
    #sty2{
        width: 24%;float: left;font-weight: bold;font-size: 10px;height: 50px
    }
     #sty4{
        width: 48%;float: left;font-weight: bold;font-size: 10px;height: 50px
    }
    #sty5{
    width: 48%;float: left;height: 50px ;    font-size:12px;
    }
     #sty3{
        width: 98%;float: left;font-weight: bold;font-size: 10px;height: 50px;text-align: center;font-weight: bold;
    }
    body {
        background-color: #fff;
        margin: 40px;
        font: 13px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
    }
    table th{
        font-size: 10px !important;
    }
    table td{
        font-size: 10px !important;
    }
    #body {
        margin: 0 15px 0 15px;
    }
  


    #container {
        margin: 10px;
        height: 1000px;
        border: 1px solid #D0D0D0;
        box-shadow: 0 0 8px #D0D0D0;
    }
    </style>
</head>
<body>

<h1 align="center">TML IN/OUT (TML Drivers)</h1>

<div style="padding-left: 10px; padding-right: 10px;">

  <?php 
  if(!empty($resultmaterials)){

    foreach ($resultmaterials as $key => $value) { ?>

<div class="col-md-12" style="padding: 10px;margin-top: 20px;width: 100%;font-size: 14px;box-shadow: 1px 1px 6px #ddd; background-color:#c2c3c4  "><?php echo $value->MaterialName; ?> </div><br>


  <?php 

  foreach ($value->resultcompany as $key1 => $value2) { ?>

<div class="col-md-12" style="padding: 10px;margin-top: 20px;width: 100%;font-size: 14px;box-shadow: 1px 1px 6px #ddd; background-color:#ededed  "><?php echo $value2->CompanyName; ?> </div>
<br>


<table class="table table-striped" border="1"  autosize="1" >
  <thead>
    <tr>
     
      <th style="font-size: 10px;font-weight: bold" >Ticket No</th>
      <th style="font-size: 10px;font-weight: bold" >Date</th>
      <th style="font-size: 10px;font-weight: bold">Conveyance</th>
      <th style="font-size: 10px;font-weight: bold">Lorry No</th>
      <th style="font-size: 10px;font-weight: bold">Vehicle Reg No</th>
      <th style="font-size: 10px;font-weight: bold">SiteAddress</th>
      <th style="font-size: 10px;font-weight: bold">Gross Weight</th>
      <th style="font-size: 10px;font-weight: bold">Tare</th>
      <th style="font-size: 10px;font-weight: bold">Net</th>
    </tr>
  </thead>
    <tbody>
        <?php 
        
        $tipped = $this->db->query("select ticket.*,Opportunity.OpportunityName from  tbl_tickets as ticket left join tbl_opportunities as Opportunity on Opportunity.OpportunityID = ticket.OpportunityID  where ticket.CompanyID = '".$value2->CompanyID."' AND ticket.MaterialID = '".$value->MaterialID."' AND ticket.CreateDate between '".$firstDate."' and '".$SecondDate."'");

        foreach ($tipped->result() as $row) {?>
       <tr>
      <td style="font-size: 10px;"><?php echo $row->TicketNumber; ?></td>
      <td style="font-size: 10px;"><?php echo $row->TicketDate; ?></td>
      <td style="font-size: 10px;"><?php echo $row->Conveyance; ?></td>
      <td style="font-size: 10px;"><?php echo $row->driver_id; ?></td>
       <td style="font-size: 10px;"><?php echo $row->RegNumber; ?></td>
        <td style="font-size: 10px;"><?php echo $row->OpportunityName; ?></td>
        <td style="font-size: 10px;"><?php echo $row->GrossWeight; ?></td>
         <td style="font-size: 10px;"><?php echo $row->Tare; ?></td>
          <td style="font-size: 10px;"><?php echo $row->Net; ?></td>
  </tr>
  <?php } ?>
        </tbody>
</table>


<div style="float: right; width: 100%;text-align: right;">
       
        <div>
            <span style="font-weight: bold;font-size: 10px"> Net For all material: </span><span style="font-size: 10px"> <?php echo $value2->total_net; ?></span>
        </div>      

        <div>
        <span style="font-weight: bold;font-size: 10px"> Loads For all Mateials: </span><span style="font-size: 10px"> <?php echo $value2->total_count; ?></span>            
        </div>

</div>

    
  <?php } ?>


<div style="float: right; width: 100%; background-color:#ededed;text-align: right;padding: 15px;">
       
        <div>
            <span style="font-weight: bold;font-size: 10px"> Net: </span><span style="font-size: 10px"> <?php echo $value->total_net; ?></span>
        </div>        

        <div>
        <span style="font-weight: bold;font-size: 10px"> Loads: </span><span style="font-size: 10px"> <?php echo $value->total_count; ?></span>            
        </div>
</div>



 
  <?php } ?>


  
<?php } else{ ?>
   <div style="text-align: center;">
     <h2>NO DATA FOUND.</h2>
   </div>
<?php }?>
</div>
</body>
</html>