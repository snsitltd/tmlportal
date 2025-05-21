<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
/*********** Modules ROUTES *******************/

$route['welcome'] = "welcome";
$route['default_controller'] = "login";
$route['404_override'] = 'errors/page_missing';

$route['refreshLogin'] = 'Login/refreshLogin';

$route['TEST'] = "Tickets/TEST";
##$route['CustomerTickets'] = "CustomerTickets/index";
$route['NotAvailable'] = "CustomerTickets/NotAvailable";

$route['CustomerTickets/(:any)'] = "CustomerTickets/index/$1";
##$route['CustomerTickets/(:any)'] = "CustomerTickets/ListTickets/$1";
$route['CustomerTicketsAjax/(:any)'] = "CustomerTickets/CustomerTicketsAjax/$1";

/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";


/*********** Modules user *******************/
$route['dashboard'] = 'user';
$route['dashboard_new'] = 'livetracking';
$route['dashboard_replay_activity'] = 'livetracking/replay_activity';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";
$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['login-history'] = "user/loginHistoy";
$route['login-history/(:num)'] = "user/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "user/loginHistoy/$1/$2";


/*********** Modules Roles *******************/
$route['roles'] = "roles";
$route['addNewRoles'] = "roles/addNewRoles";
$route['addNewRolesSubmit'] = "roles/addNewRolesSubmit";
$route['edit-roles/(:num)'] = "roles/editroles/$1";
$route['editrolessubmit'] = "roles/editrolessubmit/"; 
$route['deleteRoles'] = "roles/deleteRoles";

/*********** Modules Company *******************/
$route['Tips'] = "Tips";
$route['AddTip'] = "Tips/AddTip";
$route['EditTip/(:any)'] = "Tips/EditTip/$1";
##$route['ViewTipTickets/(:any)'] = "Tips/ViewTipTickets/$1";
$route['DeleteTip'] = "Tips/DeleteTip";

$route['ViewTipTicketsTableMeta'] = "Tips/ViewTipTicketsTableMeta"; 
$route['ViewTipTickets/(:num)'] = "Tips/ViewTipTickets/$1"; 
$route['AjaxViewTipTickets'] = "Tips/AjaxViewTipTickets";
$route['TipTicketNoUpdateAJAX'] = "Tips/TipTicketNoUpdateAJAX"; 

/*********** Modules Company *******************/
$route['companies'] = "company";
$route['companies/(:any)'] = "company/companies/$1";
$route['Add-New-Company'] = "company/addNewCompany";
$route['addnewcompanysubmit'] = "company/addNewCompanySubmit";
$route['edit-company/(:any)'] = "company/editCompany/$1";
$route['SageCompany/(:any)'] = "company/SageCompany/$1";

$route['view-company/(:any)'] = "company/viewCompany/$1";
$route['editCompanySubmit'] = "company/editCompanySubmit/"; 
$route['deleteCompany'] = "company/deleteCompany";
$route['companyChangeStatus'] = "company/companyChangeStatus";
$route['addnewcompanynoteajax'] = "company/addnewcompanynoteajax";
$route['deleteCompanyNotes'] = "company/deleteCompanyNotes";
$route['editCompanyDocumentsSubmit'] = "company/editCompanyDocumentsSubmit";
$route['deleteCompanyDocuments'] = "company/deleteCompanyDocuments";
$route['AJAXCompanies'] = "company/AJAXCompanies";


/*********** Modules contacts *******************/
$route['contacts'] = "contacts";
$route['contacts/(:any)'] = "contacts/contacts/$1";
$route['Add-New-Contacts'] = "contacts/addNewContacts";
$route['addnewcontactsubmit'] = "contacts/addnewcontactsubmit";
$route['view-contacts/(:any)'] = "contacts/viewContacts/$1";
$route['edit-contacts/(:any)'] = "contacts/editContacts/$1";
$route['editContactsSubmit'] = "contacts/editContactsSubmit/"; 
$route['deleteContacts'] = "contacts/deleteContacts";
$route['contactsChangeStatus'] = "contacts/contactsChangeStatus";
$route['getCompanyDetails'] = "contacts/getCompanyDetails";
$route['AJAXContacts'] = "contacts/AJAXContacts";


/*********** Modules Opportunity *******************/
$route['OppoAuthorizeTip/(:any)'] = "Opportunity/OppoAuthorizeTip/$1";
$route['EditAuthoAJAX'] = "Opportunity/EditAuthoAJAX";
$route['EditAuthoAJAXPOST'] = "Opportunity/EditAuthoAJAXPOST";

$route['AjaxOppoBookings'] = "Opportunity/AjaxOppoBookings";

$route['opportunities'] = "Opportunity";
$route['AJAXOpportunity'] = "Opportunity/AJAXOpportunity";

$route['wifOppo'] = "Opportunity/wifOppo";
$route['opportunity/(:any)'] = "Opportunity/contacts/$1";
$route['Add-Opportunity'] = "Opportunity/addOpportunity";
$route['Add-New-Opportunity'] = "Opportunity/addNewOpportunity";
$route['addnewOpportunitysubmit'] = "Opportunity/addnewOpportunitysubmit";

$route['edit-Opportunity/(:any)'] = "Opportunity/editOpportunity/$1";
$route['edit-Opportunity-Company/(:any)'] = "Opportunity/editOpportunityCompany/$1";

$route['View-Opportunity/(:any)'] = "Opportunity/viewOpportunity/$1";
$route['editOpportunitysubmit'] = "Opportunity/editOpportunitysubmit/"; 
$route['deleteOpportunity'] = "Opportunity/deleteOpportunity";
$route['opportunityChangeStatus'] = "Opportunity/contactsChangeStatus";
$route['addnewopportunitynoteajax'] = "Opportunity/addnewopportunitynoteajax";
$route['deleteopportunityNotes'] = "Opportunity/deleteopportunityNotes";
$route['deleteOpportunityDocuments'] = "Opportunity/deleteOpportunityDocuments";

$route['Opportunity-AddContact/(:any)'] = "Opportunity/addContact/$1";
$route['Opportunity-EditContact/(:any)'] = "Opportunity/editContact/$1";

$route['Opportunity-AddProduct/(:any)'] = "Opportunity/addProduct/$1";
$route['Opportunity-EditProduct/(:any)'] = "Opportunity/editProduct/$1";
$route['GetMaterialDetails'] = "Opportunity/GetMaterialDetails";

$route['OppoTickets'] = "Opportunity/OppoTickets";

/*********** Modules County *******************/

$route['county'] = "county";
$route['addnewcountysubmit'] = "County/addnewcountysubmit";
$route['editcountysubmit'] = "County/editcountysubmit/";
$route['deleteCounty'] = "County/deleteCounty";

/*********** Modules Driver *******************/

$route['DriversLogin'] = "DriversLogin";
$route['DriversLoginDeleted'] = "DriversLogin/DriversLoginDeleted";

$route['addDriverLogin'] = "DriversLogin/addDriverLogin";
$route['editDriverProfile/(:any)'] = "DriversLogin/editDriverProfile/$1";
$route['editDriverPassword/(:any)'] = "DriversLogin/editDriverPassword/$1";

$route['AJAXDriversLogin'] = "DriversLogin/AJAXDriversLogin"; 
$route['AJAXDriversLoginDeleted'] = "DriversLogin/AJAXDriversLoginDeleted"; 

$route['deleteDriverLogin'] = "DriversLogin/deleteDriverLogin";
$route['restoreDriverLogin'] = "DriversLogin/restoreDriverLogin";

$route['Subcontractor'] = "DriversLogin/Subcontractor";
$route['AJAXSubcontractor'] = "DriversLogin/AJAXSubcontractor";
$route['addSubcontractor'] = "DriversLogin/addSubcontractor";
$route['EditSubcontractor/(:any)'] = "DriversLogin/EditSubcontractor/$1";


/*********** Modules Driver *******************/
$route['drivers'] = "Drivers";
$route['addDriver'] = "Drivers/addDriver";
$route['editDriver/(:any)'] = "Drivers/editDriver/$1";
$route['editDriverLogin/(:any)'] = "Drivers/editDriverLogin/$1";
$route['viewDriver/(:any)'] = "Drivers/viewDriver/$1";

$route['addnewdriversubmit'] = "Drivers/addnewdriversubmit";
$route['editdriversubmit'] = "Drivers/editdriversubmit/";
$route['deleteDriver'] = "Drivers/deleteDriver";
$route['checkRegNumber'] = "Drivers/checkRegNumber";
$route['checkRegEditNumber'] = "Drivers/checkRegEditNumber";
$route['AJAXDrivers'] = "Drivers/AJAXDrivers";
$route['AJAXDriversOthers'] = "Drivers/AJAXDriversOthers";

$route['UpdateLorryDriverAJAX'] = "Drivers/UpdateLorryDriverAJAX";  
$route['UpdateLorryDriverAJAXPOST'] = "Drivers/UpdateLorryDriverAJAXPOST";  

/*********** Modules Materials *******************/
$route['materiallist'] = "Materials";
$route['MaterialsInActive'] = "Materials/MaterialsInActive";
$route['Add-New-Materials'] = "Materials/addNewMaterials";
$route['addnewmaterialsubmit'] = "Materials/addnewmaterialsubmit";
$route['edit-material/(:num)'] = "Materials/editMaterial/$1";
$route['editmaterialsubmit'] = "Materials/editmaterialsubmit/"; 
$route['deleteMaterials'] = "Materials/deleteMaterials";
$route['view-material/(:num)'] = "Materials/ViewMaterial/$1";

$route['AJAXMaterials'] = "Materials/AJAXMaterials";
$route['AJAXMaterialsInActive'] = "Materials/AJAXMaterialsInActive";

/*********** Modules Bookings *******************/

$route['ShowOppoProductPriceAJAX'] = "Booking/ShowOppoProductPriceAJAX";
$route['ShowOppoProductPriceTonnageAJAX'] = "Booking/ShowOppoProductPriceTonnageAJAX";

$route['ShowHaulageOppoProductPriceAJAX'] = "Booking/ShowHaulageOppoProductPriceAJAX";

$route['SubcontractorLoads'] = "Booking/SubcontractorLoads";
$route['AjaxContractorLoads'] = "Booking/AjaxContractorLoads";

$route['NonAppsLoads1'] = "Booking/NonAppsLoads1";
$route['NonAppsLoads'] = "Booking/NonAppsLoads";
$route['AjaxNonAppsLoads'] = "Booking/AjaxNonAppsLoads";

##$route['Bookings'] = "Booking/index";

##$route['AllocateBookings'] = "Booking/AllocateBookings";
##$route['AllocateBookingsOverdue'] = "Booking/AllocateBookingsOverdue";
##$route['AllocateBookingsFinished'] = "Booking/AllocateBookingsFinished";

##$route['AllocateBookings1'] = "Booking/AllocateBookings1";
##$route['Loads'] = "Booking/Loads";
##$route['LoadsFinished'] = "Booking/LoadsFinished";
$route['ContractorLoads'] = "Booking/ContractorLoads";

$route['AllocateDrivers'] = "Booking/AllocateDrivers";
$route['AjaxAllocateDrivers'] = "Booking/AjaxAllocateDrivers";

##$route['AjaxBookings'] = "Booking/AjaxBookings";
##$route['AjaxAllocatedBookings'] = "Booking/AjaxAllocatedBookings";
##$route['AjaxAllocatedBookings2'] = "Booking/AjaxAllocatedBookings2";
##$route['AjaxAllocatedBookings3'] = "Booking/AjaxAllocatedBookings3";

##$route['AjaxAllocatedBookings1'] = "Booking/AjaxAllocatedBookings1";

##$route['AjaxLoads'] = "Booking/AjaxLoads";
##$route['AjaxLoads1'] = "Booking/AjaxLoads1";
##$route['AjaxLoads2'] = "Booking/AjaxLoads2";
$route['AJAXShowLoadsDetails'] = "Booking/AJAXShowLoadsDetails";

##$route['GetBookingData'] = "Booking/GetBookingData"; 
##$route['AddBooking'] = "Booking/AddBooking";

##$route['EditBooking/(:num)'] = "Booking/EditBooking/$1";
$route['LoadOpportunityContacts'] = "Booking/LoadOpportunityContacts";

$route['DisplayContactDetails'] = "Booking/DisplayContactDetails";

$route['LoadBookingMaterials'] = "Booking/LoadMaterials";
##$route['ApproveBooking'] = "Booking/ApproveBooking";
##$route['DeleteBooking'] = "Booking/DeleteBooking";
##$route['DeleteLoad'] = "Booking/DeleteLoad";
##$route['CancelLoad'] = "Booking/CancelLoad";
$route['GetDriverList'] = "Booking/GetDriverList";
$route['GetTipList'] = "Booking/GetTipList";
$route['AllocateBookingAJAX'] = "Booking/AllocateBookingAJAX";
$route['AllocateBookingAJAX1'] = "Booking/AllocateBookingAJAX1";


$route['TipAddressUpdateAjax'] = "Booking/TipAddressUpdateAjax";
$route['TipAddressUpdate/(:num)'] = "Booking/TipAddressUpdate/$1";

$route['TipAddressUpdateNonAppAjax'] = "Booking/TipAddressUpdateNonAppAjax";
$route['TipAddressUpdateNonApp/(:num)'] = "Booking/TipAddressUpdateNonApp/$1";


$route['UpdateBookingLoadAJAX'] = "Booking/UpdateBookingLoadAJAX"; 

$route['ShowLoadsAJAX'] = "Booking/ShowLoadsAJAX";
$route['ShowBLoadsAJAX'] = "Booking/ShowBLoadsAJAX";

$route['ShowLoadsAJAX1'] = "Booking/ShowLoadsAJAX1";

$route['ShowLoadsDeleteBookingAJAX'] = "Booking/ShowLoadsDeleteBookingAJAX";
$route['ShowLoadsDeleteBookingAJAXPOST'] = "Booking/ShowLoadsDeleteBookingAJAXPOST";

$route['ShowUpdateBookingAJAX'] = "Booking/ShowUpdateBookingAJAX";
$route['ShowUpdateBookingAJAXPOST'] = "Booking/ShowUpdateBookingAJAXPOST";


$route['ConveyanceTicketsTableMeta'] = "Booking/ConveyanceTicketsTableMeta";
$route['ConveyanceTickets'] = "Booking/ConveyanceTickets";
$route['AjaxConveyanceTickets'] = "Booking/AjaxConveyanceTickets";

$route['DeliveryTickets'] = "Booking/DeliveryTickets";
$route['AjaxDeliveryTickets'] = "Booking/AjaxDeliveryTickets";
$route['DeliveryTicketsTableMeta'] = "Booking/DeliveryTicketsTableMeta";


$route['Message'] = "Booking/Message";
$route['AllMessage'] = "Booking/AllMessage";
$route['AjaxMessage'] = "Booking/AjaxMessage";
$route['SendDriverMessage'] = "Booking/SendDriverMessage";

$route['AddChatMessage'] = "Chat/AddChatMessage";
$route['ViewChat'] = "Chat/ViewChat";
$route['SendDriverChatMessage'] = "Chat/SendDriverChatMessage";


$route['DriverLoads'] = "Booking/DriverLoads";
$route['DriverLoadsAjax'] = "Booking/DriverLoadsExcelAjax";

$route['BookingStageAtSite/(:any)'] = "Booking/BookingStageAtSite/$1";
$route['BookingStageLeftSite/(:any)'] = "Booking/BookingStageLeftSite/$1";
$route['BookingStageFinishLoad/(:any)'] = "Booking/BookingStageFinishLoad/$1";
$route['BookingStageFinishLoadNonApp/(:any)'] = "Booking/BookingStageFinishLoadNonApp/$1";

$route['BookingRequestStageAtSite/(:any)'] = "Booking/BookingRequestStageAtSite/$1";
$route['BookingRequestStageLeftSite/(:any)'] = "Booking/BookingRequestStageLeftSite/$1";
$route['BookingRequestStageFinishLoad/(:any)'] = "Booking/BookingRequestStageFinishLoad/$1";
$route['BookingRequestStageFinishLoadNonApp/(:any)'] = "Booking/BookingRequestStageFinishLoadNonApp/$1";


/*********** Modules Tickets *******************/


$route['AllTicketsArchived'] = "Tickets/AllTicketsArchived";
$route['AllTicketsTableMetaArchived'] = "Tickets/AllTicketsTableMetaArchived";
$route['AllTicketsAJAXArchived'] = "Tickets/AllTicketsAJAXArchived";

$route['TMLTicketsArchived'] = "Tickets/tmlTicketArchived";
$route['AJAXTmlTicketsArchived'] = "Tickets/AJAXTmlTicketsArchived";
$route['TMLTicketsTableMetaArchived'] = "Tickets/TMLTicketsTableMetaArchived";

$route['Tickets1'] = "Tickets/Tickets1";
//$route['All-Tickets'] = "Tickets";
$route['All-Tickets'] = "Tickets/AllTickets";
  
$route['AJAXTickets'] = "Tickets/AJAXTickets";
$route['AllTicketsAJAX'] = "Tickets/AllTicketsAJAX";
$route['AllTicketsTableMeta'] = "Tickets/AllTicketsTableMeta";

$route['TML-Tickets'] = "Tickets/tmlTicket";
$route['AJAXTmlTickets'] = "Tickets/AJAXTmlTickets";
$route['TMLTicketsTableMeta'] = "Tickets/TMLTicketsTableMeta";

$route['DeliveryHoldTickets'] = "Tickets/DeliveryHoldTickets";
$route['AJAXDeliveryHoldTickets'] = "Tickets/AJAXDeliveryHoldTickets";
$route['DeliveryHoldTicketsTableMeta'] = "Tickets/DeliveryHoldTicketsTableMeta";
 
$route['TML-Hold-Tickets'] = "Tickets/tmlHoldTicket";
$route['AJAXHoldTickets'] = "Tickets/AJAXHoldTickets";
$route['HoldTicketsTableMeta'] = "Tickets/HoldTicketsTableMeta";

$route['Inbound-Tickets'] = "Tickets/InboundTicket";
$route['AJAXInboundTickets'] = "Tickets/AJAXInboundTickets";
$route['InboundTicketsTableMeta'] = "Tickets/InboundTicketsTableMeta";

$route['Incompleted-Tickets'] = "Tickets/IncompletedTicket";
$route['AJAXIncompletedTickets'] = "Tickets/AJAXIncompletedTickets";
$route['IncompletedTicketsTableMeta'] = "Tickets/IncompletedTicketsTableMeta";

$route['deleteTickets'] = "Tickets/deleteTickets";
$route['AJAXDeleteTickets'] = "Tickets/AJAXDeleteTickets";
$route['DeletedTicketsTableMeta'] = "Tickets/DeletedTicketsTableMeta";

$route['deleteNotes'] = "Tickets/deleteNotes"; 
$route['restoreTicket'] = "Tickets/restoreTicket"; 

$route['GetTicketData'] = "Tickets/GetTicketData";
$route['AddOfficeTicketAJAX'] = "Tickets/AddOfficeTicketAJAX";
$route['OfficeTicket/(:num)'] = "Tickets/OfficeTicket/$1";
$route['CheckDuplicateTicket'] = "Tickets/CheckDuplicateTicket";
$route['CheckDuplicateRegNo'] = "Tickets/CheckDuplicateRegNo";

$route['AddTicketAJAX'] = "Tickets/AddTicketAJAX";
$route['EditTicketAJAX'] = "Tickets/EditTicketAJAX";
$route['EditInBoundAJAX'] = "Tickets/EditInBoundAJAX";
$route['EditInCompletedAJAX'] = "Tickets/EditInCompletedAJAX";

$route['AddOutTicketAJAX'] = "Tickets/AddOutTicketAJAX";
$route['EditOutTicketAJAX'] = "Tickets/EditOutTicketAJAX";
$route['AddCollectionTicketAJAX'] = "Tickets/AddCollectionTicketAJAX";
$route['EditCollectionTicketAJAX'] = "Tickets/EditCollectionTicketAJAX";

$route['In-Tickets'] = "Tickets/inTickets";
$route['In-Tickets1'] = "Tickets/inTickets1";
$route['inTicketssubmit'] = "Tickets/inTicketssubmit";
$route['edit-In-ticket/(:num)'] = "Tickets/editInTicket/$1";
$route['View-In-Ticket/(:num)'] = "Tickets/ViewInTicket/$1";
$route['editInTicketSubmit'] = "Tickets/editInTicketSubmit";

$route['EditInBound/(:num)'] = "Tickets/EditInBound/$1";
$route['EditInCompleted/(:num)'] = "Tickets/EditInCompleted/$1";

$route['Collection-Tickets'] = "Tickets/collectionTickets";
$route['collectionTicketsSubmit'] = "Tickets/collectionTicketsSubmit";
$route['edit-Collection-ticket/(:num)'] = "Tickets/editCollectionTicket/$1";
$route['View-Collection-Ticket/(:num)'] = "Tickets/ViewCollectionTicket/$1";
$route['editCollectionTicketSubmit'] = "Tickets/editCollectionTicketSubmit";


$route['Out-Tickets'] = "Tickets/outTickets";
$route['outTicketssubmit'] = "Tickets/outTicketssubmit";
$route['edit-Out-ticket/(:num)'] = "Tickets/editOutTicket/$1";
$route['View-Out-Ticket/(:num)'] = "Tickets/ViewOutTicket/$1";
$route['editOutTicketSubmit'] = "Tickets/editOutTicketSubmit";
$route['generatePdf/(:num)'] = "Tickets/generatePdf/$1";

$route['mypdf'] = "Tickets/mypdf";

$route['GetHoldCount'] = "Tickets/GetHoldCount";
$route['GetWIFNumber'] = "Tickets/GetWIFNumber";
$route['getCompanyList'] = "Tickets/getCompanyList";
$route['getLorryList'] = "Tickets/getLorryList";
$route['getMaterialList'] = "Tickets/getMaterialList";
$route['getMaterialListDetails'] = "Tickets/getMaterialListDetails";


$route['getLorryNo'] = "Tickets/getLorryNo";
$route['getLorryNoDetails'] = "Tickets/getLorryNoDetails";
$route['getOpportunitiesList'] = "Tickets/getOpportunitiesList";
$route['loadAllOpportunitiesByCompany'] = "Tickets/loadAllOpportunitiesByCompany";

$route['LoadOppoByCompany'] = "Booking/LoadOppoByCompany";

$route['LoadMaterials'] = "Tickets/LoadMaterials";
$route['getCustomerDetails'] = "Tickets/getCustomerDetails";
$route['addTicketsSubmit'] = "Tickets/addTicketsSubmit";
$route['genrateBarcode'] = "Tickets/genrateBarcode";

// $route['edit-material/(:num)'] = "Tickets/editMaterial/$1";
// $route['editmaterialsubmit'] = "Tickets/editmaterialsubmit/"; 
// $route['deleteMaterials'] = "Tickets/deleteMaterials";

/*********** Modules Schedule *******************/
$route['schedule'] = "Schedule";
$route['uploaddata'] = "Schedule/uploaddata"; 
$route['uploaddatasubmit'] = "Schedule/uploaddatasubmit";
$route['importcsvfile/(:num)'] = "Schedule/importcsvfile/$1";
$route['importcsvfilesubmit'] = "Schedule/importcsvfilesubmit";
$route['content'] = "Schedule/content"; 
$route['submitcontent'] = "Schedule/submitcontent";
$route['submitheader'] = "Schedule/submitheadercontent";
$route['submitOutHeaderContent'] = "Schedule/submitOutHeaderContent";
$route['CronJobs'] = "Schedule/cron"; 
$route['TransferTickets'] = "Schedule/TransferTickets"; 

$route['APKDownload'] = "Schedule/APKDownload"; 
 
/*************************/
$route['tickets-reports'] = "Reports/ticket";
$route['tickets-payment-reports'] = "Reports/TicketPayment";
$route['tml-tickets-reports'] = "Reports/tmlticket";
$route['tml-tickets-reports_pdf'] = "Reports/tmlticket";
$route['material-reports'] = "Reports/material";
 
$route['MaterialReports'] = "Reports/MaterialReports";
$route['ea-reports'] = "Reports/eareports";
$route['tml-reports'] = "Reports/tmlReports";
$route['tipped-reports'] = "Reports/tippedReports"; 
$route['tipped-reports-submit'] = "Reports/tippedReportsSubmit";
$route['view-ticket/(:num)']= "Reports/viewTicket/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */

$route['tmlreports'] = "Reports/tmlreports";
$route['Invoice-List'] = "Reports/invoicelist";
$route['gen_invoices/(:num)'] = "Reports/gen_invoices/$1";
$route['slip_list/(:num)'] = "Reports/slip_list/$1";

$route['Cronjob'] = "Cronjob";

/*********** Modules Support *******************/
$route['Supports'] = "Support";
$route['Supports/(:any)'] = "Support/Supports/$1";
$route['addSupport'] = "Support/addSupport";
$route['editSupport/(:any)'] = "Support/editSupport/$1";
$route['viewSupport/(:any)'] = "Support/viewSupport/$1";
$route['deleteSupport'] = "Support/deleteSupport";
$route['SupportUpload'] = "Support/SupportUpload";

$route['BookingPriceByPendingTableMeta'] = "Booking/BookingPriceByPendingTableMeta";
$route['BookingPriceByPending'] = "Booking/BookingPriceByPending";
$route['BookingPriceByPendingAJAX'] = "Booking/BookingPriceByPendingAJAX";

$route['BookingPriceByApprovedTableMeta'] = "Booking/BookingPriceByApprovedTableMeta";
$route['BookingPriceByApproved'] = "Booking/BookingPriceByApproved";
$route['BookingPriceByApprovedAJAX'] = "Booking/BookingPriceByApprovedAJAX";

$route['BookingPriceByAllTableMeta'] = "Booking/BookingPriceByAllTableMeta";
$route['BookingPriceByAll'] = "Booking/BookingPriceByAll";
$route['BookingPriceByAllAJAX'] = "Booking/BookingPriceByAllAJAX";

$route['BookingRequest1'] = "Booking/BookingRequest1";
$route['AjaxBookingsRequest1'] = "Booking/AjaxBookingsRequest1";
$route['AddNewLoadAJAX'] = "Booking/AddNewLoadAJAX";

$route['BookingRequest'] = "Booking/BookingRequest";
$route['BookingRequestApproved'] = "Booking/BookingRequestApproved";
$route['BookingRequestApprovedArchived'] = "Booking/BookingRequestApprovedArchived";

$route['AjaxBookingsRequest'] = "Booking/AjaxBookingsRequest";
$route['ApproveBookingRequest'] = "Booking/ApproveBookingRequest";
$route['ApproveBookingPrice'] = "Booking/ApproveBookingPrice";


$route['AddBookingRequest'] = "Booking/AddBookingRequest";
$route['AddBookingRequestTonnage'] = "Booking/AddBookingRequestTonnage";
$route['EditBookingRequest/(:num)'] = "Booking/EditBookingRequest/$1";  
$route['EditBookingRequestTonnage/(:num)'] = "Booking/EditBookingRequestTonnage/$1";  

$route['AddBookingRequestDaywork'] = "Booking/AddBookingRequestDaywork";
$route['EditBookingRequestDaywork/(:num)'] = "Booking/EditBookingRequestDayWork/$1";  

$route['AllocateBookingRequest'] = "Booking/AllocateBookingRequest";
$route['AllocateBookingRequestOverdue'] = "Booking/AllocateBookingRequestOverdue";
$route['AllocateBookingRequestFuture'] = "Booking/AllocateBookingRequestFuture";
$route['AllocateBookingRequestFinished'] = "Booking/AllocateBookingRequestFinished";
$route['AllocateBookingRequestFinishedArchived'] = "Booking/AllocateBookingRequestFinishedArchived";

$route['ShowUpdateBookingRequestAJAX'] = "Booking/ShowUpdateBookingRequestAJAX";
$route['ShowUpdateBookingRequestAJAXPOST'] = "Booking/ShowUpdateBookingRequestAJAXPOST";



$route['ShowLoadsDeleteBookingRequestAJAX'] = "Booking/ShowLoadsDeleteBookingRequestAJAX";
$route['ShowLoadsDeleteBookingRequestAJAXPOST'] = "Booking/ShowLoadsDeleteBookingRequestAJAXPOST";

$route['AllocateBookingRequestAJAX1'] = "Booking/AllocateBookingRequestAJAX1"; 
$route['AllocateBookingRequestAJAX'] = "Booking/AllocateBookingRequestAJAX";
$route['AjaxAllocatedBookingsRequest1'] = "Booking/AjaxAllocatedBookingsRequest1";
$route['AjaxAllocatedBookingsRequestArchived'] = "Booking/AjaxAllocatedBookingsRequestArchived";
$route['ShowRequestLoadsAJAX'] = "Booking/ShowRequestLoadsAJAX";

$route['PendingLoads'] = "Booking/PendingLoads";
$route['RequestLoads'] = "Booking/RequestLoads";
$route['RequestLoadsFinished'] = "Booking/RequestLoadsFinished"; 
$route['RequestLoadsCancelled'] = "Booking/RequestLoadsCancelled";
$route['RequestLoadsFinishedArchived'] = "Booking/RequestLoadsFinishedArchived";

$route['AjaxPendingLoads'] = "Booking/AjaxPendingLoads";

$route['AjaxRequestLoads'] = "Booking/AjaxRequestLoads";
$route['AjaxRequestLoads1'] = "Booking/AjaxRequestLoads1";
$route['AjaxRequestLoadsArchived'] = "Booking/AjaxRequestLoadsArchived";
$route['AjaxRequestLoads2'] = "Booking/AjaxRequestLoads2"; 

$route['CancelRequestLoad'] = "Booking/CancelRequestLoad";

$route['AJAXShowRequestLoadsDetails'] = "Booking/AJAXShowRequestLoadsDetails";

$route['DeleteRequestLoad'] = "Booking/DeleteRequestLoad";
$route['DeleteRequestLoad'] = "Booking/DeleteRequestLoad";

$route['BookingRequestTableMeta'] = "Booking/BookingRequestTableMeta";
$route['DeleteBookingRequestConfirm'] = "Booking/DeleteBookingRequestConfirm"; 
$route['DeleteBookingRequest'] = "Booking/DeleteBookingRequest"; 
$route['BookingRequestTableMeta1'] = "Booking/BookingRequestTableMeta1";

$route['AjaxBookingsRequest2'] = "Booking/AjaxBookingsRequest2";
$route['AjaxBookingsRequestArchived'] = "Booking/AjaxBookingsRequestArchived";

$route['AddNewLoad'] = "Booking/AddNewLoad";

$route['BookingPreInvoice'] = "Booking/BookingPreInvoice";
$route['AjaxPreInvoiceList'] = "Booking/AjaxPreInvoiceList";

$route['MyBookingPreInvoice'] = "Booking/MyBookingPreInvoice";
$route['AjaxMyPreInvoiceList'] = "Booking/AjaxMyPreInvoiceList";

$route['BookingCreateInvoice/(:any)'] = "Booking/BookingCreateInvoice/$1";
$route['BookingCreateInvoiceConfirm/(:any)'] = "Booking/BookingCreateInvoiceConfirm/$1";

$route['BookingCreateInvoiceTonnage/(:any)'] = "Booking/BookingCreateInvoiceTonnage/$1";
$route['BookingCreateInvoiceConfirmTonnage/(:any)'] = "Booking/BookingCreateInvoiceConfirmTonnage/$1";


$route['ShowPreInvoiceAllLoadsAJAX'] = "Booking/ShowPreInvoiceAllLoadsAJAX";

$route['MaterialUpdateAjax'] = "Booking/MaterialUpdateAjax";
$route['MaterialUpdate/(:num)'] = "Booking/MaterialUpdate/$1";

$route['MaterialUpdateDeliveryAjax'] = "Booking/MaterialUpdateDeliveryAjax";
$route['MaterialUpdateDelivery/(:num)'] = "Booking/MaterialUpdateDelivery/$1";


$route['MaterialUpdateNonAppAjax'] = "Booking/MaterialUpdateNonAppAjax";
$route['MaterialUpdateNonApp/(:num)'] = "Booking/MaterialUpdateNonApp/$1";
 
$route['AJAXUpdateBookingPrice'] = "Booking/AJAXUpdateBookingPrice";
$route['AJAXUpdatePON'] = "Booking/AJAXUpdatePON";
$route['AJAXUpdateOpenPO'] = "Booking/AJAXUpdateOpenPO";
$route['AJAXUpdateGrossWeight'] = "Tickets/AJAXUpdateGrossWeight";
$route['AJAXUpdateTicketDate'] = "Tickets/AJAXUpdateTicketDate";
$route['IncompletedPDF'] = "Tickets/IncompletedPDF";
$route['InBoundPDF'] = "Tickets/InBoundPDF";
$route['DeliveryHoldTicketsPDF'] = "Tickets/DeliveryHoldTicketsPDF";

$route['AJAXUpdateHoldTicketDate'] = "Tickets/AJAXUpdateHoldTicketDate";
$route['AJAXUpdateHoldGrossWeight'] = "Tickets/AJAXUpdateHoldGrossWeight";

$route['SplitExcelConv'] = "Booking/SplitExcelConv"; 
$route['SplitExcelConvAjax'] = "Booking/SplitExcelConvAjax"; 
$route['SplitExcelExport'] = "Booking/SplitExcelExport";
$route['ConveyanceExcelExport'] = "Booking/ConveyanceExcelExport";
$route['ConveyanceExcelExportNew'] = "Booking/ConveyanceExcelExportNew";
$route['DeliveryExcelExport'] = "Booking/DeliveryExcelExport";


$route['WaitTimeSplitExcelConvAjax'] = "Booking/WaitTimeSplitExcelConvAjax"; 
$route['WaitTimeSplitExcelExport'] = "Booking/WaitTimeSplitExcelExport";
$route['WaitTimeSplitExcelExportAll'] = "Booking/WaitTimeSplitExcelExportAll";
  
  
$route['TempConveyanceExcelExport'] = "Booking/TempConveyanceExcelExport";


$route['SplitExcelExportAll'] = "Booking/SplitExcelExportAll";
$route['SplitExcelDelExportAll'] = "Booking/SplitExcelDelExportAll";
 
$route['SplitExcelDel'] = "Booking/SplitExcelDel";
$route['SplitExcelDelAjax'] = "Booking/SplitExcelDelAjax"; 
$route['SplitExcelDelExport'] = "Booking/SplitExcelDelExport";

$route['WaitTimeSplitExcelDelAjax'] = "Booking/WaitTimeSplitExcelDelAjax"; 
$route['WaitTimeSplitExcelDelExport'] = "Booking/WaitTimeSplitExcelDelExport";
$route['WaitTimeSplitExcelDelExportAll'] = "Booking/WaitTimeSplitExcelDelExportAll";

$route['DeleteProductPrice'] = "Opportunity/DeleteProductPrice";

$route['AJAXGetPageHeaderInfo'] = "Booking/AJAXGetPageHeaderInfo";

$route['TicketMaterialUpdateAjax'] = "Tickets/TicketMaterialUpdateAjax";
$route['TicketMaterialUpdate/(:num)'] = "Tickets/TicketMaterialUpdate/$1";

$route['PDAUsers'] = "user/PDAUsers";
$route['ExecutiveSummary'] = "user/ExecutiveSummary";
$route['ExecutiveSummaryDriverList'] = "user/ExecutiveSummaryDriverList";

$route['NonAppRequestLoads/(:any)'] = "Booking/NonAppRequestLoads/$1"; 
$route['NonAppRequestLoadsAJAX'] = "Booking/NonAppRequestLoadsAJAX";
 

$route['NonAppGrossWeightUpdateAJAX'] = "Booking/NonAppGrossWeightUpdateAJAX";
$route['NonAppConveyanceUpdateAJAX'] = "Booking/NonAppConveyanceUpdateAJAX";
$route['NonAppConveyanceDateUpdateAJAX'] = "Booking/NonAppConveyanceDateUpdateAJAX";
$route['NonAppStatusUpdateAJAX'] = "Booking/NonAppStatusUpdateAJAX";
$route['FetchTicketFromConveyanceAJAX'] = "Booking/FetchTicketFromConveyanceAJAX";
$route['FetchDeliveryTicketNoAJAX'] = "Booking/FetchDeliveryTicketNoAJAX";


$route['StatusUpdateAjax'] = "Booking/StatusUpdateAjax";
$route['StatusUpdate/(:num)'] = "Booking/StatusUpdate/$1";
$route['DeliveryStatusUpdateAjax'] = "Booking/DeliveryStatusUpdateAjax";
$route['DeliveryStatusUpdate/(:num)'] = "Booking/DeliveryStatusUpdate/$1";

 
$route['AllNonAppRequestLoads'] = "Booking/AllNonAppRequestLoads"; 
$route['AllNonAppRequestLoadsAJAX'] = "Booking/AllNonAppRequestLoadsAJAX";

$route['AddTicketBookingRequestAJAX'] = "Booking/AddTicketBookingRequestAJAX"; 
$route['AddDeliveryTicketBookingRequestAJAX'] = "Booking/AddDeliveryTicketBookingRequestAJAX"; 

$route['NonAppCreateTicketAJAX'] = "Booking/NonAppCreateTicketAJAX"; 
$route['NonAppCreateDeliveryTicketAJAX'] = "Booking/NonAppCreateDeliveryTicketAJAX"; 

$route['CreateInvoiceHoldLoadAJAX'] = "Booking/CreateInvoiceHoldLoadAJAX"; 
$route['HoldLoadAJAX'] = "Booking/HoldLoadAJAX"; 

//$route['BookingInvoice'] = "Booking/BookingInvoice";
//$route['AjaxInvoiceList'] = "Booking/AjaxInvoiceList";

$route['MyBookingInvoice'] = "Booking/MyBookingInvoice";
$route['AjaxMyInvoiceList'] = "Booking/AjaxMyInvoiceList";

$route['BookingInvoice'] = "Booking/BookingInvoice";
$route['AjaxInvoiceList'] = "Booking/AjaxInvoiceList";

$route['BookingInvoiceDetails/(:any)'] = "Booking/BookingInvoiceDetails/$1";
$route['BookingInvoiceDetailsTonnage/(:any)'] = "Booking/BookingInvoiceDetailsTonnage/$1";

$route['MyReadyBookingInvoice'] = "Booking/MyReadyBookingInvoice"; 
$route['AjaxMyReadyInvoiceList'] = "Booking/AjaxMyReadyInvoiceList";

$route['ReadyBookingInvoice'] = "Booking/ReadyBookingInvoice"; 
$route['AjaxReadyInvoiceList'] = "Booking/AjaxReadyInvoiceList";

$route['BookingPriceLogsAJAX'] = "Booking/BookingPriceLogsAJAX"; 

//$route['BookingStageLeftSite/(:any)'] = "Booking/BookingStageLeftSite/$1";

$route['NonAppConveyanceTicketsTableMeta'] = "Booking/NonAppConveyanceTicketsTableMeta";
$route['NonAppConveyanceTickets'] = "Booking/NonAppConveyanceTickets";
$route['AjaxNonAppConveyanceTickets'] = "Booking/AjaxNonAppConveyanceTickets";

$route['NonAppDeliveryTicketsTableMeta'] = "Booking/NonAppDeliveryTicketsTableMeta";
$route['NonAppDeliveryTickets'] = "Booking/NonAppDeliveryTickets";
$route['AjaxNonAppDeliveryTickets'] = "Booking/AjaxNonAppDeliveryTickets";

/*********** Modules Lorry  *******************/
$route['Lorry'] = "Drivers/Lorry";
$route['LorryOthers'] = "Drivers/LorryOthers";
$route['AddLorry'] = "Drivers/AddLorry";
$route['EditLorry/(:any)'] = "Drivers/EditLorry/$1";   
$route['DeleteLorry'] = "Drivers/DeleteLorry"; 
$route['AJAXLorry'] = "Drivers/AJAXLorry";


$route['UpdateTicketPDFTemp'] = "Tickets/UpdateTicketPDFTemp"; 

$route['LogOutDriver'] = "user/LogOutDriver"; 


$route['ShowAddBookingRequestAJAX'] = "Booking/ShowAddBookingRequestAJAX";
$route['ShowAddBookingRequestAJAXPOST'] = "Booking/ShowAddBookingRequestAJAXPOST";

$route['DateUpdateAjax'] = "Booking/DateUpdateAjax";
$route['DateUpdate/(:num)'] = "Booking/DateUpdate/$1";

$route['DateUpdateDeliveryAjax'] = "Booking/DateUpdateDeliveryAjax";
$route['DateUpdateDelivery/(:num)'] = "Booking/DateUpdateDelivery/$1";

$route['LoadSICCodeProduct'] = "Booking/LoadSICCodeProduct";

$route['AddBookingRequestDaywork'] = "Booking/AddBookingRequestDaywork";
$route['EditBookingRequestDaywork/(:num)'] = "Booking/EditBookingRequestDaywork/$1";  

$route['AddBookingRequestHaulage'] = "Booking/AddBookingRequestHaulage";
$route['EditBookingRequestHaulage/(:num)'] = "Booking/EditBookingRequestHaulage/$1";  
 

$route['BookingRequestDayworkFinish/(:any)'] = "Booking/BookingRequestDayworkFinish/$1";

$route['DayWorkTicketsTableMeta'] = "Booking/DayWorkTicketsTableMeta";
$route['DayWorkTickets'] = "Booking/DayWorkTickets";
$route['AjaxDayWorkTickets'] = "Booking/AjaxDayWorkTickets";

$route['DateUpdateDayWorkAjax'] = "Booking/DateUpdateDayWorkAjax";
$route['DateUpdateDayWork/(:num)'] = "Booking/DateUpdateDayWork/$1";


$route['StatusUpdateDayWorkAjax'] = "Booking/StatusUpdateDayWorkAjax";
$route['StatusUpdateDayWork/(:num)'] = "Booking/StatusUpdateDayWork/$1";



$route['SplitExcelDayWork'] = "Booking/SplitExcelDayWork"; 
$route['SplitExcelDayWorkAjax'] = "Booking/SplitExcelDayWorkAjax"; 
$route['SplitExcelExportDayWork'] = "Booking/SplitExcelExportDayWork";
$route['DayWorkExcelExport'] = "Booking/DayWorkExcelExport";
$route['SplitExcelExportAllDayWork'] = "Booking/SplitExcelExportAllDayWork";

$route['HaulageTicketsTableMeta'] = "Booking/HaulageTicketsTableMeta";
$route['HaulageTickets'] = "Booking/HaulageTickets";
$route['AjaxHaulageTickets'] = "Booking/AjaxHaulageTickets";
 
$route['AJAXShowRequestHaulageLoadsDetails'] = "Booking/AJAXShowRequestHaulageLoadsDetails";


$route['DateUpdateHaulageAjax'] = "Booking/DateUpdateHaulageAjax";
$route['DateUpdateHaulage/(:num)'] = "Booking/DateUpdateHaulage/$1";

$route['StatusUpdateHaulageAjax'] = "Booking/StatusUpdateHaulageAjax";
$route['StatusUpdateHaulage/(:num)'] = "Booking/StatusUpdateHaulage/$1";


$route['SplitExcelHaulage'] = "Booking/SplitExcelHaulage"; 
$route['SplitExcelHaulageAjax'] = "Booking/SplitExcelHaulageAjax"; 
$route['SplitExcelExportHaulage'] = "Booking/SplitExcelExportHaulage";
$route['HaulageExcelExport'] = "Booking/HaulageExcelExport";
$route['SplitExcelExportAllHaulage'] = "Booking/SplitExcelExportAllHaulage";


$route['BookingRequestHaulageFinish/(:any)'] = "Booking/BookingRequestHaulageFinish/$1";

$route['SearchConveyanceAJAX'] = "Tickets/SearchConveyanceAJAX";  
$route['SearchConveyanceSubmit/(:num)'] = "Tickets/SearchConveyanceSubmit/$1";

$route['LinkConveyanceAJAX'] = "Tickets/LinkConveyanceAJAX";  
$route['LinkConveyanceSubmit/(:num)'] = "Tickets/LinkConveyanceSubmit/$1";

$route['AddConveyanceTicketAJAX'] = "Tickets/AddConveyanceTicketAJAX";  
$route['EditConveyanceTicketAJAX'] = "Tickets/EditConveyanceTicketAJAX";  
 
$route['OppoChangeStatus'] = "Opportunity/OppoChangeStatus"; 

$route['AJAXShowTipTicketImages'] = "Tips/AJAXShowTipTicketImages";

$route['LogsTableMeta'] = "Booking/LogsTableMeta";
$route['Logs'] = "Booking/Logs";


$route['AllocateNewBookingAJAX'] = "Booking/AllocateNewBookingAJAX"; 
$route['FetchBookingRequestAJAX'] = "Booking/FetchBookingRequestAJAX"; 
$route['UpdateBookingRequestAJAX'] = "Booking/UpdateBookingRequestAJAX"; 
 

$route['BookingRequestLogsAJAX'] = "Booking/BookingRequestLogsAJAX"; 
$route['OppoProductLogsAJAX'] = "Booking/OppoProductLogsAJAX"; 


$route['DuplicateBookingRequest/(:num)'] = "Booking/DuplicateBookingRequest/$1";  
$route['DuplicateBookingRequestTonnage/(:num)'] = "Booking/DuplicateBookingRequestTonnage/$1";   
$route['DuplicateBookingRequestDayWork/(:num)'] = "Booking/DuplicateBookingRequestDayWork/$1";  
$route['DuplicateBookingRequestHaulage/(:num)'] = "Booking/DuplicateBookingRequestHaulage/$1";  


$route['TipTicketExcelExport'] = "Tips/TipTicketExcelExport";
