<?php  


$url = $cInfo['SageURL'];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Authorization: Basic YWN0OmFjdA==",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$jcode = curl_exec($curl);
curl_close($curl);
  
$jcode =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', stripslashes(html_entity_decode(rtrim($jcode, "\0")))), true ); 

//echo $jcode['$uuid'];
//echo "<PRE>";  
//print_r($jcode);	
//echo "</PRE>";  
//exit;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Company Management
        <small>Sage Company Details </small>
      </h1>
    </section>

     <section class="content">
    
        <div class="row">

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li ><a href="<?php echo base_url('edit-company/'.$cInfo['CompanyID']); ?>"   >Company details </a></li>               
              <li ><a href="<?php echo base_url('edit-company/'.$cInfo['CompanyID']); ?>"   >Notes</a></li>           
              <li class="active"><a href="#sage"    >SAGE</a></li>               
            </ul>
            <div class="tab-content">
                  <div class="tab-pane active" id="sage"> 
                    <div class="box-body"> 
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>invoiceTradingAccount :</b>   </label> <?php echo $jcode['$resources'][0]['invoiceTradingAccount']; ?>
                                    </div> 
                                </div> 
                        </div>
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>openedDate :</b>   </label> <?php echo $jcode['$resources'][0]['openedDate']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>openedDate :</b>   </label> <?php echo $jcode['$resources'][0]['openedDate']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>reference :</b>   </label> <?php echo $jcode['$resources'][0]['reference']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>reference2 :</b>   </label> <?php echo $jcode['$resources'][0]['reference2']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>status :</b>   </label> <?php echo $jcode['$resources'][0]['status']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>name :</b>   </label> <?php echo $jcode['$resources'][0]['name']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>shortName :</b>   </label> <?php echo $jcode['$resources'][0]['shortName']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>type :</b>   </label> <?php echo $jcode['$resources'][0]['type']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>registeredAddress :</b>   </label> <?php echo $jcode['$resources'][0]['registeredAddress']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>postalAddresses :</b>   </label> <?php echo $jcode['$resources'][0]['postalAddresses']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>shippingAddresses :</b>   </label> <?php echo $jcode['$resources'][0]['shippingAddresses']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>billingAddresses :</b>   </label> <?php echo $jcode['$resources'][0]['billingAddresses']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>phones :</b>   </label> <?php echo $jcode['$resources'][0]['phones']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>emails :</b>   </label> <?php echo $jcode['$resources'][0]['emails']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>website :</b>   </label> <?php echo $jcode['$resources'][0]['website']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>contacts :</b>   </label> <?php echo $jcode['$resources'][0]['contacts']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>deliveryContact :</b>   </label> <?php echo $jcode['$resources'][0]['deliveryContact']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>salesPersons :</b>   </label> <?php echo $jcode['$resources'][0]['salesPersons']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>deliveryMethod :</b>   </label> <?php echo $jcode['$resources'][0]['deliveryMethod']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>deliveryRule :</b>   </label> <?php echo $jcode['$resources'][0]['deliveryRule']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>currency :</b>   </label> <?php echo $jcode['$resources'][0]['currency']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>taxCode :</b>   </label> <?php echo $jcode['$resources'][0]['taxCode']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>taxReference :</b>   </label> <?php echo $jcode['$resources'][0]['taxReference']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>taxationCountry :</b>   </label> <?php echo $jcode['$resources'][0]['taxationCountry']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>useTaxInclusivePrices :</b>   </label> <?php echo $jcode['$resources'][0]['useTaxInclusivePrices']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>financeBalance :</b>   </label> <?php echo $jcode['$resources'][0]['financeBalance']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>financeLimit :</b>   </label> <?php echo $jcode['$resources'][0]['financeLimit']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>financeBalanceDate :</b>   </label> <?php echo $jcode['$resources'][0]['financeBalanceDate']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>financeStatusFlag :</b>   </label> <?php echo $jcode['$resources'][0]['financeStatusFlag']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>financeStatusText :</b>   </label> <?php echo $jcode['$resources'][0]['financeStatusText']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>settlementDiscountType :</b>   </label> <?php echo $jcode['$resources'][0]['settlementDiscountType']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>settlementDiscountAmount :</b>   </label> <?php echo $jcode['$resources'][0]['settlementDiscountAmount']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>settlementDiscountPercent :</b>   </label> <?php echo $jcode['$resources'][0]['settlementDiscountPercent']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>settlementDiscountTerms :</b>   </label> <?php echo $jcode['$resources'][0]['settlementDiscountTerms']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>settlementDiscountTermsCommencement :</b>   </label> <?php echo $jcode['$resources'][0]['settlementDiscountTermsCommencement']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>settlementDiscountIncludedInTotal :</b>   </label> <?php echo $jcode['$resources'][0]['settlementDiscountIncludedInTotal']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>paymentTerms :</b>   </label> <?php echo $jcode['$resources'][0]['paymentTerms']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>paymentTermsCommencement :</b>   </label> <?php echo $jcode['$resources'][0]['paymentTermsCommencement']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>orderDiscountType :</b>   </label> <?php echo $jcode['$resources'][0]['orderDiscountType']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>orderDiscountAmount :</b>   </label> <?php echo $jcode['$resources'][0]['orderDiscountAmount']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>orderDiscountPercent :</b>   </label> <?php echo $jcode['$resources'][0]['orderDiscountPercent']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>orderText1 :</b>   </label> <?php echo $jcode['$resources'][0]['orderText1']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>orderText2 :</b>   </label> <?php echo $jcode['$resources'][0]['orderText2']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>orderLineDiscountType :</b>   </label> <?php echo $jcode['$resources'][0]['orderLineDiscountType']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>orderLineDiscountAmount :</b>   </label> <?php echo $jcode['$resources'][0]['orderLineDiscountAmount']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>orderLineDiscountPercent :</b>   </label> <?php echo $jcode['$resources'][0]['orderLineDiscountPercent']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>orderLineText1 :</b>   </label> <?php echo $jcode['$resources'][0]['orderLineText1']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>orderLineText2 :</b>   </label> <?php echo $jcode['$resources'][0]['orderLineText2']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>invoiceDiscountType :</b>   </label> <?php echo $jcode['$resources'][0]['invoiceDiscountType']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>invoiceDiscountAmount :</b>   </label> <?php echo $jcode['$resources'][0]['invoiceDiscountAmount']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>invoiceDiscountPercent :</b>   </label> <?php echo $jcode['$resources'][0]['invoiceDiscountPercent']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>invoiceText1 :</b>   </label> <?php echo $jcode['$resources'][0]['invoiceText1']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>invoiceText2 :</b>   </label> <?php echo $jcode['$resources'][0]['invoiceText2']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>bankAccounts :</b>   </label> <?php echo $jcode['$resources'][0]['bankAccounts']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>tenderType :</b>   </label> <?php echo $jcode['$resources'][0]['tenderType']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>defaultFulfillmentLocation :</b>   </label> <?php echo $jcode['$resources'][0]['defaultFulfillmentLocation']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>pricelists :</b>   </label> <?php echo $jcode['$resources'][0]['pricelists']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>pricingOverride :</b>   </label> <?php echo $jcode['$resources'][0]['pricingOverride']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>accountingType :</b>   </label> <?php echo $jcode['$resources'][0]['accountingType']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>financialAccounts :</b>   </label> <?php echo $jcode['$resources'][0]['financialAccounts']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>primacyIndicator :</b>   </label> <?php echo $jcode['$resources'][0]['primacyIndicator']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>opportunities :</b>   </label> <?php echo $jcode['$resources'][0]['opportunities']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>salesQuotations :</b>   </label> <?php echo $jcode['$resources'][0]['salesQuotations']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>salesOrders :</b>   </label> <?php echo $jcode['$resources'][0]['salesOrders']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>salesOrderDeliveries :</b>   </label> <?php echo $jcode['$resources'][0]['salesOrderDeliveries']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>salesInvoices :</b>   </label> <?php echo $jcode['$resources'][0]['salesInvoices']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>salesCredits :</b>   </label> <?php echo $jcode['$resources'][0]['salesCredits']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>purchaseOrders :</b>   </label> <?php echo $jcode['$resources'][0]['purchaseOrders']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>purchaseOrderDeliveries :</b>   </label> <?php echo $jcode['$resources'][0]['purchaseOrderDeliveries']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>receipts :</b>   </label> <?php echo $jcode['$resources'][0]['receipts']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>interactions :</b>   </label> <?php echo $jcode['$resources'][0]['interactions']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>projects :</b>   </label> <?php echo $jcode['$resources'][0]['projects']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>accountSummary :</b>   </label> <?php echo $jcode['$resources'][0]['accountSummary']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>accountSummary :</b>   </label> <?php echo $jcode['$resources'][0]['accountSummary']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>balance :</b>   </label> <?php echo $jcode['$resources'][0]['balance']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>creditLimit :</b>   </label> <?php echo $jcode['$resources'][0]['creditLimit']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>MTDTurnover :</b>   </label> <?php echo $jcode['$resources'][0]['MTDTurnover']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>YTDTurnover :</b>   </label> <?php echo $jcode['$resources'][0]['YTDTurnover']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>priorYTDTurnover :</b>   </label> <?php echo $jcode['$resources'][0]['priorYTDTurnover']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>firstInvoiceDate :</b>   </label> <?php echo $jcode['$resources'][0]['firstInvoiceDate']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>lastInvoiceDate :</b>   </label> <?php echo $jcode['$resources'][0]['lastInvoiceDate']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>lastPaymentDate :</b>   </label> <?php echo $jcode['$resources'][0]['lastPaymentDate']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>accountOpenedDate :</b>   </label> <?php echo $jcode['$resources'][0]['accountOpenedDate']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>lastCreditReviewDate :</b>   </label> <?php echo $jcode['$resources'][0]['lastCreditReviewDate']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>tradingTerms :</b>   </label> <?php echo $jcode['$resources'][0]['tradingTerms']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>standardDiscount :</b>   </label> <?php echo $jcode['$resources'][0]['standardDiscount']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>accountOnHold :</b>   </label> <?php echo $jcode['$resources'][0]['accountOnHold']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>analysis1 :</b>   </label> <?php echo $jcode['$resources'][0]['analysis1']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>analysis2 :</b>   </label> <?php echo $jcode['$resources'][0]['analysis2']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>analysis3 :</b>   </label> <?php echo $jcode['$resources'][0]['analysis3']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>canChargeCredit :</b>   </label> <?php echo $jcode['$resources'][0]['canChargeCredit']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>nextCreditReviewDate :</b>   </label> <?php echo $jcode['$resources'][0]['nextCreditReviewDate']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>additionalDiscount :</b>   </label> <?php echo $jcode['$resources'][0]['additionalDiscount']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"><b>creditAppliedDate :</b>   </label> <?php echo $jcode['$resources'][0]['creditAppliedDate']; ?>
                                    </div> 
                                </div> 
                        </div>                         
                        
                                              
                        
                    </div>  
                  </div>                       
               </div>  
          </div> 
        </div> 
        </div>    
    </section> 
</div> 