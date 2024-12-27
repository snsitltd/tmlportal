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
$route['404_override'] = 'error';

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
$route['ViewTipTickets/(:any)'] = "Tips/ViewTipTickets/$1";
$route['DeleteTip'] = "Tips/DeleteTip";

/*********** Modules Company *******************/
$route['companies'] = "company";
$route['companies/(:any)'] = "company/companies/$1";
$route['Add-New-Company'] = "company/addNewCompany";
$route['addnewcompanysubmit'] = "company/addNewCompanySubmit";
$route['edit-company/(:any)'] = "company/editCompany/$1";
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
$route['addDriverLogin'] = "DriversLogin/addDriverLogin";
$route['editDriverProfile/(:any)'] = "DriversLogin/editDriverProfile/$1";
$route['editDriverPassword/(:any)'] = "DriversLogin/editDriverPassword/$1";
$route['AJAXDriversLogin'] = "DriversLogin/AJAXDriversLogin";
//$route['editDriverLogin/(:any)'] = "Drivers/editDriverLogin/$1";
//$route['viewDriver/(:any)'] = "Drivers/viewDriver/$1";

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

/*********** Modules Materials *******************/
$route['materiallist'] = "Materials";
$route['Add-New-Materials'] = "Materials/addNewMaterials";
$route['addnewmaterialsubmit'] = "Materials/addnewmaterialsubmit";
$route['edit-material/(:num)'] = "Materials/editMaterial/$1";
$route['editmaterialsubmit'] = "Materials/editmaterialsubmit/"; 
$route['deleteMaterials'] = "Materials/deleteMaterials";
$route['view-material/(:num)'] = "Materials/ViewMaterial/$1";

$route['AJAXMaterials'] = "Materials/AJAXMaterials";

/*********** Modules Bookings *******************/

$route['SubcontractorLoads'] = "Booking/SubcontractorLoads";
$route['AjaxContractorLoads'] = "Booking/AjaxContractorLoads";


$route['Bookings'] = "Booking/index";
$route['AllocateBookings'] = "Booking/AllocateBookings";
$route['AllocateBookings1'] = "Booking/AllocateBookings1";
$route['Loads'] = "Booking/Loads";
$route['ContractorLoads'] = "Booking/ContractorLoads";

$route['AllocateDrivers'] = "Booking/AllocateDrivers";
$route['AjaxAllocateDrivers'] = "Booking/AjaxAllocateDrivers";

$route['AjaxBookings'] = "Booking/AjaxBookings";
$route['AjaxAllocatedBookings'] = "Booking/AjaxAllocatedBookings";
$route['AjaxAllocatedBookings2'] = "Booking/AjaxAllocatedBookings2";
$route['AjaxAllocatedBookings3'] = "Booking/AjaxAllocatedBookings3";
$route['AjaxAllocatedBookings1'] = "Booking/AjaxAllocatedBookings1";
$route['AjaxLoads'] = "Booking/AjaxLoads";
$route['AjaxLoads1'] = "Booking/AjaxLoads1";
$route['AjaxLoads2'] = "Booking/AjaxLoads2";
$route['AJAXShowLoadsDetails'] = "Booking/AJAXShowLoadsDetails";

$route['GetBookingData'] = "Booking/GetBookingData"; 
$route['AddBooking'] = "Booking/AddBooking";
$route['EditBooking/(:num)'] = "Booking/EditBooking/$1";
$route['LoadOpportunityContacts'] = "Booking/LoadOpportunityContacts";

$route['DisplayContactDetails'] = "Booking/DisplayContactDetails";

$route['LoadBookingMaterials'] = "Booking/LoadMaterials";
$route['ApproveBooking'] = "Booking/ApproveBooking";
$route['DeleteBooking'] = "Booking/DeleteBooking";
$route['DeleteLoad'] = "Booking/DeleteLoad";
$route['CancelLoad'] = "Booking/CancelLoad";
$route['GetDriverList'] = "Booking/GetDriverList";
$route['GetTipList'] = "Booking/GetTipList";
$route['AllocateBookingAJAX'] = "Booking/AllocateBookingAJAX";
$route['AllocateBookingAJAX1'] = "Booking/AllocateBookingAJAX1";

$route['ShowLoadsAJAX'] = "Booking/ShowLoadsAJAX";
$route['ShowBLoadsAJAX'] = "Booking/ShowBLoadsAJAX";

$route['ShowLoadsAJAX1'] = "Booking/ShowLoadsAJAX1";

$route['ShowLoadsDeleteBookingAJAX'] = "Booking/ShowLoadsDeleteBookingAJAX";
$route['ShowLoadsDeleteBookingAJAXPOST'] = "Booking/ShowLoadsDeleteBookingAJAXPOST";

$route['ConveyanceTickets'] = "Booking/ConveyanceTickets";
$route['AjaxConveyanceTickets'] = "Booking/AjaxConveyanceTickets";

$route['Message'] = "Booking/Message";
$route['AllMessage'] = "Booking/AllMessage";
$route['AjaxMessage'] = "Booking/AjaxMessage";
$route['SendDriverMessage'] = "Booking/SendDriverMessage";

$route['DriverLoads'] = "Booking/DriverLoads";

$route['BookingStageAtSite/(:any)'] = "Booking/BookingStageAtSite/$1";
$route['BookingStageLeftSite/(:any)'] = "Booking/BookingStageLeftSite/$1";
$route['BookingStageFinishLoad/(:any)'] = "Booking/BookingStageFinishLoad/$1";
$route['BookingStageFinishLoadNonApp/(:any)'] = "Booking/BookingStageFinishLoadNonApp/$1";

/*********** Modules Tickets *******************/

$route['Tickets1'] = "Tickets/Tickets1";
$route['All-Tickets'] = "Tickets";
$route['AJAXTickets'] = "Tickets/AJAXTickets";

$route['TML-Tickets'] = "Tickets/tmlTicket";
$route['AJAXTmlTickets'] = "Tickets/AJAXTmlTickets";
 
$route['TML-Hold-Tickets'] = "Tickets/tmlHoldTicket";
$route['Inbound-Tickets'] = "Tickets/InboundTicket";
$route['Incompleted-Tickets'] = "Tickets/IncompletedTicket";
$route['AJAXHoldTickets'] = "Tickets/AJAXHoldTickets";
$route['AJAXInboundTickets'] = "Tickets/AJAXInboundTickets";
$route['AJAXIncompletedTickets'] = "Tickets/AJAXIncompletedTickets";

$route['deleteTickets'] = "Tickets/deleteTickets";
$route['AJAXDeleteTickets'] = "Tickets/AJAXDeleteTickets";

$route['deleteNotes'] = "Tickets/deleteNotes"; 
$route['restoreTicket'] = "Tickets/restoreTicket"; 

$route['GetTicketData'] = "Tickets/GetTicketData";
$route['AddOfficeTicketAJAX'] = "Tickets/AddOfficeTicketAJAX";
$route['OfficeTicket/(:num)'] = "Tickets/OfficeTicket/$1";
$route['CheckDuplicateTicket'] = "Tickets/CheckDuplicateTicket";

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
