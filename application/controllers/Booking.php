<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
include_once APPPATH . '/third_party/mpdf/mpdf.php';

class Booking extends BaseController
{

	protected $isView;
	protected $isAdd;
	protected $isEdit;
	protected $isDelete;

	protected $isApprove;
	protected $isPApprove;
	protected $isIApprove;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Booking_model');
		$this->load->model('Fcm_model');
		$this->load->model('tickets_model');
		$this->isLoggedIn();

		$roleCheck = $this->Common_model->checkpermission('booking');

		//print_r($roleCheck); 
		//exit;

		$this->global['isView'] = $this->isView = $roleCheck->view;
		$this->global['isAdd'] = $this->isAdd = $roleCheck->add;
		$this->global['isEdit'] = $this->isEdit = $roleCheck->edit;
		$this->global['isDelete'] = $this->isDelete = $roleCheck->delete;

		$this->global['isApprove'] = $this->isApprove = $roleCheck->approve;
		$this->global['isPApprove'] = $this->isPApprove = $roleCheck->papprove;
		$this->global['isIApprove'] = $this->isIApprove = $roleCheck->iapprove;

		$this->global['active_menu'] = 'dashboard';

	}

	public function index()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			//echo '<pre>';print_r($data['ticketsRecords']);die;           
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Listing';
			$this->global['active_menu'] = 'bookings';

			$this->loadViews("Booking/Bookings", $this->global, $data, NULL);
		}
	}




	public function AllocateBookings()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			//$data['AllocateBookings'] = $this->Booking_model->AllocateBookings(); 			
			$data['TodayBookingRecords'] = $this->Booking_model->TodayBookingListing();
			//$data['OverdueBookingRecords'] = $this->Booking_model->OverdueBookingListing(); 
			$data['BookingRecords'] = $this->Booking_model->FutureBookingListing();

			//$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX1();  	 
			$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX();
			$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();
			$data['LorryRecords'] = $this->Booking_model->LorryListAJAX();
			$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList();

			$data['TipRecords'] = $this->Booking_model->TipListAJAX();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Allocate Booking ';
			$this->global['active_menu'] = 'bookingallocate';

			$this->loadViews("Booking/AllocateBookings", $this->global, $data, NULL);
		}
	}
	public function AllocateBookingsOverdue()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$data['OverdueBookingRecords'] = $this->Booking_model->OverdueBookingListing();

			$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX();
			$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();
			$data['LorryRecords'] = $this->Booking_model->LorryListAJAX();
			$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList();

			$data['TipRecords'] = $this->Booking_model->TipListAJAX();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Overdue Allocate Booking ';
			$this->global['active_menu'] = 'bookingallocate';

			$this->loadViews("Booking/AllocateBookingsOverdue", $this->global, $data, NULL);
		}
	}
	public function AllocateBookingsFinished()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Allocate Booking Finished';
			$this->global['active_menu'] = 'bookingallocate';

			$this->loadViews("Booking/AllocateBookingsFinished", $this->global, $data, NULL);
		}
	}
	public function AllocateBookings1()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$data['TodayBookingRecords'] = $this->Booking_model->TodayBookingListing();
			$data['OverdueBookingRecords'] = $this->Booking_model->OverdueBookingListing();
			$data['BookingRecords'] = $this->Booking_model->FutureBookingListing();

			//$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();  	  
			//$data['LorryRecords'] = $this->Booking_model->LorryListAJAX();  	
			//$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList();   
			//$data['TipRecords'] = $this->Booking_model->TipListAJAX(); 

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Allocate Booking ';
			$this->global['active_menu'] = 'bookingallocate';

			$this->loadViews("Booking/AllocateBookings1", $this->global, $data, NULL);
		}
	}

	function AllocateBookingAJAX1()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['BookingID'] = $this->input->post('BookingID');
			$data['BookingDateID'] = $this->input->post('BookingDateID');
			$data['BookingDate'] = $this->input->post('BookingDate');
			$data['LoadType'] = $this->input->post('LoadType');
			$data['PendingLoad'] = $this->input->post('PendingLoad');
			$data['BookingInfo'] = $this->Booking_model->GetBookingBasicInfo($data['BookingDateID']);
			//var_dump($data['BookingInfo']);
			//echo $data['BookingInfo']['BookingType'];
			//exit;

			if ($data['BookingInfo']['BookingType'] == 1) {
				if ($data['BookingDate'] != "") {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverBookedList($data['BookingDate']);
				} else {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList();
				}
			}
			if ($data['BookingInfo']['BookingType'] == 2) {
				if ($data['BookingDate'] != "") {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverBookedList1($data['BookingDate']);
				} else {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList1();
				}
			}

			$data['LorryRecords'] = $this->Booking_model->LorryListAJAX();
			//$data['TipRecords'] = $this->Booking_model->TipListAJAX(); 
			$data['TipRecords'] = $this->Booking_model->TipListAuthoAJAX($data['BookingInfo']['OpportunityID']);


			$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();
			$data['Loads'] = $this->Booking_model->ShowBookingDateLoads($data['BookingDateID']);

			$html = $this->load->view('Booking/AllocateBookingAjax1', $data, true);
			echo json_encode($html);

		}
	}

	function UpdateBookingLoadAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['BookingID'] = $this->input->post('BookingID');
			$data['BookingDateID'] = $this->input->post('BookingDateID');

			$data['BookingInfo'] = $this->Booking_model->GetBookingBasicInfo($data['BookingDateID']);
			//var_dump($data['BookingInfo']);
			//echo $data['BookingInfo']['BookingType'];
			//exit;

			if ($data['BookingInfo']['BookingType'] == 1) {
				if ($data['BookingDate'] != "") {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverBookedList($data['BookingDate']);
				} else {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList();
				}
			}
			if ($data['BookingInfo']['BookingType'] == 2) {
				if ($data['BookingDate'] != "") {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverBookedList1($data['BookingDate']);
				} else {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList1();
				}
			}

			$data['LorryRecords'] = $this->Booking_model->LorryListAJAX();
			$data['TipRecords'] = $this->Booking_model->TipListAJAX();
			$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();

			$html = $this->load->view('Booking/UpdateBookingLoadAJAX', $data, true);
			echo json_encode($html);

		}
	}

	function SplitExcelConvAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$CompanyName = $this->input->post('CompanyName');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$TipName = $this->input->post('TipName');
			//$JobStartDateTime   = $this->input->post('JobStartDateTime');  
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');

			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$WaitTime = $this->input->post('WaitTime');

			//$data['CompanyOppoRecords'] = $this->Booking_model->CompanyOppoRecordsAJAX(); 
			$data['CompanyOppoRecords'] = $this->Booking_model->SplitExcelOppoGroup($CompanyName, $OpportunityName, $reservation, $TipName, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status);

			$html = $this->load->view('Booking/SplitExcelConvAjax', $data, true);
			echo json_encode($html);

		}
	}



	function ConveyanceExcelExport()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			// Get input data
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$TipName = $this->input->post('TipName');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');
			$NetWeight = $this->input->post('NetWeight');

			// Fetch data
			$data['SplitExcelDelTickets'] = $this->Booking_model->SplitExcelConveyanceTicketsAll($CompanyName, $OpportunityName, $reservation, $TipName, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Search, $Price, $NetWeight);

			// Load required libraries
			$this->load->library("excel");
			$this->load->library('zip'); // Load Zip library

			// Lorry Type Mapping
			$lorryTypes = [
				1 => 'Tipper',
				2 => 'Grab',
				3 => 'Bin'
			];

			$xlsfiles = []; // Array to store generated Excel file names

			// Create Excel files for each lorry type
			foreach ($lorryTypes as $typeKey => $typeName) {
				$object = new PHPExcel();
				$object->setActiveSheetIndex(0);
				$object->getActiveSheet()->setTitle($typeName);

				// Define table columns
				$table_columns = ($NetWeight == '1')
					? array("ConvTkt No", "ConvTkt Date", "Customer Name", "Job Site Address", "PO NO", "Product Description", "Price", "WaitTime", "Status", "Net Weight", "Total Price")
					: array("ConvTkt No", "ConvTkt Date", "Customer Name", "Job Site Address", "PO NO", "Product Description", "Price", "WaitTime", "Status");

				// Set header row
				$column = 0;
				foreach ($table_columns as $field) {
					$object->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$object->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);

					$column++;
				}

				$excel_row = 2;
				$hasdata = 'false';
				// Fill data for the current lorry type
				foreach ($data['SplitExcelDelTickets'] as $row) {
					if ($row['LorryType'] == $typeKey) { // Filter by LorryType
						$hasData = true;
						if ($row['LorryType'] == $typeKey) { // Filter by LorryType
							$Price = is_numeric($row['Price']) ? $row['Price'] : 0;

							// Material Name Logic
							$MaterialText = $row['MStatus'] == 1
								? $row['MaterialName'] . ' Collected ' . $typeName
								: $row['MaterialName'];

							// Set values in the Excel sheet
							$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['TicketConveyance']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['SiteOutDateTime']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['CompanyName']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['OpportunityName']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['PurchaseOrderNo']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
							$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $Price);
							$min = $row['WaitTime'] === null ? "N/A" : $row['WaitTime'] . " Min";
							$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $min);
							$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row['Status']);

							if ($NetWeight == '1') {
								$NetWeight1 = round($row['Net'] / 1000, 2);
								$NPrice = round((float) $NetWeight1 * (float) $row['Price'], 2);
								$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $NetWeight1);
								$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $NPrice);
							}

							$excel_row++;
						}
					}
				}

				if ($hasdata) {
					// Auto size columns for the current sheet
					for ($col = 'A'; $col <= $object->getActiveSheet()->getHighestColumn(); $col++) {
						$object->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
						$object->getActiveSheet()->getStyle($col)->getFont()->setBold(true);

					}
				}
				// Save the Excel file to output buffer
				ob_start();
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
				$FileName = $typeName . '_Conveyance_' . date("Y-m-d-H-i") . '.xlsx';
				$object_writer->save("ConveyanceExcelExport/" . $FileName);
				$xlsfiles[] = $FileName; // Store the generated file name
				ob_end_clean();
			}

			// Add Excel files to the zip archive
			foreach ($xlsfiles as $xls) {
				$this->zip->read_file('ConveyanceExcelExport/' . $xls);
			}
			$zname = date("YmdHis") . "-" . rand() . ".zip";
			$this->zip->archive("ConveyanceExcelExport/" . $zname);

			$response = array(
				'op' => 'ok',
				'FileName' => "ConveyanceExcelExport/" . $zname,
				'file' => "data:application/zip;base64," . base64_encode(file_get_contents("ConveyanceExcelExport/" . $zname)) // Ensure correct base64 encoding
			);

			die(json_encode($response)); // Return JSON response
		}
	}

	function ConveyanceExcelExportNew()
	{

		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			// Input data
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$TipName = $this->input->post('TipName');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');
			$NetWeight = $this->input->post('NetWeight');

			// Fetch data
			$allData = $this->Booking_model->SplitExcelConveyanceTicketsAll(
				$CompanyName,
				$OpportunityName,
				$reservation,
				$TipName,
				$SiteOutDateTime,
				$ConveyanceNo,
				$MaterialName,
				$DriverName,
				$VehicleRegNo,
				$WaitTime,
				$Status,
				$Search,
				$Price,
				$NetWeight
			);

			// Group data by LorryType
			$lorryTypes = ['Tipper', 'Grab', 'Bin'];
			$groupedData = array_fill_keys($lorryTypes, []);

			foreach ($allData as $row) {
				$type = $row['LorryType'] == 1 ? 'Tipper' :
					($row['LorryType'] == 2 ? 'Grab' :
						($row['LorryType'] == 3 ? 'Bin' : 'Other'));

				if (isset($groupedData[$type])) {
					$groupedData[$type][] = $row;
				}
			}

			// Load required libraries
			$this->load->library('excel');
			$this->load->library('zip');

			// Create directory if it doesn't exist
			$exportDir = FCPATH . 'ConveyanceExcelExport';
			if (!file_exists($exportDir)) {
				mkdir($exportDir, 0777, true);
			}

			$xlsfiles = [];

			// Generate Excel files for each type
			foreach ($lorryTypes as $type) {
				if (!empty($groupedData[$type])) {
					$object = new PHPExcel();
					$object->setActiveSheetIndex(0);
					$object->getActiveSheet()->setTitle("$type Data");

					// Define table columns
					$table_columns = ($NetWeight == '1') ?
						[
							"ConvTkt No",
							"ConvTkt Date",
							"Customer Name",
							"Job Site Address",
							"Supplier Name",
							"Tip Site Address",
							"SuppTkt Date",
							"SuppTkt No",
							"PO NO",
							"Product Description",
							"Price",
							"Driver Name",
							"Vehicle Reg No",
							"WaitTime",
							"Status",
							"Net Weight"
						] :
						[
							"ConvTkt No",
							"ConvTkt Date",
							"Customer Name",
							"Job Site Address",
							"Supplier Name",
							"Tip Site Address",
							"SuppTkt Date",
							"SuppTkt No",
							"PO NO",
							"Product Description",
							"Price",
							"Driver Name",
							"Vehicle Reg No",
							"WaitTime",
							"Status"
						];

					// Set header row
					$column = 0;
					foreach ($table_columns as $field) {
						$columnLetter = PHPExcel_Cell::stringFromColumnIndex($column); // Get column letter
						$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
						$object->getActiveSheet()->getColumnDimension($columnLetter)->setAutoSize(true); // Auto-adjust column width
						$column++;
					}

					// Fill data
					$excel_row = 2;
					foreach ($groupedData[$type] as $row) {
						if ((int)$row['BookingMaterialID'] === (int)$row['MaterialID']) {
    					$Price = $row['Price']; // from tbl_booking_loads1.LoadPrice
					} else {
					    $Price = 0;
					}


						// Fill row data
						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['ConveyanceNo']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['SiteOutDateTime']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['CompanyName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['OpportunityName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['TipName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['TipAddress']);
						// die();
						if ($row['TipID'] == 1) {
							if ($row['Net'] != '0.00') {
								$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['SuppDate']);
								$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['SuppNo']);
								if ($row['pdf_name'] != "" && $row['pdf_name'] != '.pdf') {
									$object->getActiveSheet()->getCell('H' . $excel_row)->getHyperlink()->setUrl(base_url('assets/pdf_file/' . $row['pdf_name']));
								}
							}
						} else {
							$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['TipTicketNo']);
							$url = "http://193.117.210.98:8081/ticket/Supplier/" . rawurlencode($row['TipName'] . "-" . $row['TipTicketNo']) . ".pdf";

							$object->getActiveSheet()->getCell('H' . $excel_row)->getHyperlink()->setUrl($url);
						}
						$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row['PurchaseOrderNo']);
						// $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row['MaterialName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, html_entity_decode($row['MaterialName']));
						$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $Price);
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row['DriverName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row['VehicleRegNo']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row['WaitTime']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row['Status']);

						if ($NetWeight == '1') {
							$NetWeight1 = round($row['Net'] / 1000, 2);
							$object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $NetWeight1);
						}

						$excel_row++;
					}



					// Save the Excel file
					$fileName = $type . '_Conveyance_' . date("Y-m-d-H-i") . '.xlsx';
					$filePath = $exportDir . '/' . $fileName;




					// Save Excel file to disk
					$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
					$object_writer->save($filePath);

					$xlsfiles[] = $fileName;
				}
			}

			// Create ZIP archive
			foreach ($xlsfiles as $xls) {
				$this->zip->read_file($exportDir . '/' . $xls);
				// Clean up Excel file after adding to ZIP
				unlink($exportDir . '/' . $xls);
			}

			// Generate ZIP file
			$zipName = 'Conveyance_Export_' . date("YmdHis") . "_" . rand(1000, 9999) . ".zip";
			$zipPath = $exportDir . '/' . $zipName;
			$this->zip->archive($zipPath);

			// Prepare response with base64 encoded ZIP file
			$response = array(
				'op' => 'ok',
				'FileName' => $zipName,
				'file' => "data:application/zip;base64," . base64_encode(file_get_contents($zipPath))
			);

			// Clean up ZIP file
			unlink($zipPath);

			// Return JSON response
			die(json_encode($response));
		}
	}




	function SplitExcelExport_()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			//var_dump($_POST); 			
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityID = $this->input->post('OpportunityID');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$TipName = $this->input->post('TipName');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');
			$NetWeight = $this->input->post('NetWeight');

			$data['SplitExcelConveyanceTickets'] = $this->Booking_model->SplitExcelConveyanceTickets($OpportunityID, $CompanyName, $OpportunityName, $reservation, $TipName, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Search, $Price, $NetWeight);
			//var_dump($data['SplitExcelConveyanceTickets']); 
			//exit;


			$this->load->library("excel");

			$object = new PHPExcel();
			$object->setActiveSheetIndex(0);
			if ($NetWeight == '1') {
				$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "Supplier Name", "Tip Site Address", "SuppTkt Date", "SuppTkt No", "PO NO", "Product Description", "Price", "WaitTime", "Status", "Net Weight");
			} else {
				$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "Supplier Name", "Tip Site Address", "SuppTkt Date", "SuppTkt No", "PO NO", "Product Description", "Price", "WaitTime", "Status");
			}
			$column = 0;

			foreach ($table_columns as $field) {
				$object->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
				$object->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);

				$column++;
			}
			$object->getActiveSheet()->getStyle('k:k')->getNumberFormat()->setFormatCode('0.00');
			$excel_row = 2;
			$TPrice = 0.0;
			$TLoad = 0;

			foreach ($data['SplitExcelConveyanceTickets'] as $row) {
				$url = '';
				$Price = 0.0;

				if ($row['ReceiptName'] != "") {
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['ConveyanceNo']);
					if ($row['ReceiptName'] != "") {
						$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $row['ReceiptName']));
					}
				} else {
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['TicketConveyance']);
					if ($row['ConveyanceGUID'] != '') {
						$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl('http://193.117.210.98:8081/ticket/Conveyance/' . trim($row['TicketConveyance']) . '.pdf');

					}
				}

				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['SiteOutDateTime']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['CompanyName']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['OpportunityName']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['TipName']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['TipAddress']);

				if ($row['TipID'] == 1) {
					if ($row['Net'] != '0.00') {
						$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['SuppDate']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['SuppNo']);
						if ($row['pdf_name'] != "" && $row['pdf_name'] != '.pdf') {
							$object->getActiveSheet()->getCell('H' . $excel_row)->getHyperlink()->setUrl(base_url('assets/pdf_file/' . $row['pdf_name']));
						}
					}
				} else {
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['TipTicketDate']);

					if ($row['TipTicketNo'] != '' && $row['TipTicketNo'] != '0') {
						$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['TipTicketNo']);
						$url = "http://193.117.210.98:8081/ticket/Supplier/" . $row['TipName'] . "-" . $row['TipTicketNo'] . ".pdf";
						$HI = get_headers($url);
						if ($HI[1] == 'Content-Type: application/pdf') {
							$object->getActiveSheet()->getCell('H' . $excel_row)->getHyperlink()->setUrl($url);
						}
					}
				}

				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row['PurchaseOrderNo']);

				if ($row['MStatus'] == 1) {
					$LT = '';
					if ($row['LorryType'] == 1) {
						$LT = 'Tipper';
					} else if ($row['LorryType'] == 2) {
						$LT = 'Grab';
					} else if ($row['LorryType'] == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($row['TonBook'] == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$MaterialText = $row['MaterialName'] . ' Collected ' . $LT . ' ' . $TB;
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $MaterialText);
				} else {
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row['MaterialName']);
				}

				if (is_numeric($row['Price'])) {
					$Price = $row['Price'];
				} else {
					$Price = 0;
				}
				$TPrice = $TPrice + $Price;

				$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, number_format($Price, 3));

				if ($row['WaitTime'] == null) {
					$min = "N/A";
				} else {
					$min = $row['WaitTime'] . " Min";
				}

				$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $min);
				$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row['Status']);

				if ($NetWeight == '1') {
					$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($row['Net'] / 1000, 3));
				}

				$TLoad = $TLoad + 1;
				$excel_row++;
			}


			$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);

			$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Total Price');
			$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, number_format($TPrice, 3));
			$excel_row++;
			$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
			$object->getActiveSheet()->getStyle('k' . $excel_row)->getNumberFormat()->setFormatCode('0.00');
			$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Total Loads');
			$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $TLoad);
			$excel_row++;

			for ($i = 'A'; $i != $object->getActiveSheet()->getHighestColumn(); $i++) {
				$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
			}
			$FileName = $row['CompanyName'] . "@" . $row['OpportunityName'] . "@" . date("YmdHis") . ".xls";

			// Remove anything which isn't a word, whitespace, number
			// or any of the following caracters -_~,;[](). 
			$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).])", '', $FileName);
			// Remove any runs of periods (thanks falstro!)
			$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

			//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
			$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

			header('Content-Type: application/vnd.ms-excel');
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
			header('Content-Disposition: attachment;filename="' . $FileName . '"');
			//$object_writer->save('php://output'); 

			ob_start();
			$object_writer->save("php://output");
			//$objWriter->save(base_url("12121212.xls")); 
			$xlsData = ob_get_contents();
			ob_end_clean();

			$response = array(
				'op' => 'ok',
				'FileName' => $FileName,
				'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
			);
			die(json_encode($response));
		}
	}


	function SplitExcelExport()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityID = $this->input->post('OpportunityID');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$TipName = $this->input->post('TipName');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');
			$NetWeight = $this->input->post('NetWeight');

			$data['SplitExcelConveyanceTickets'] = $this->Booking_model->SplitExcelConveyanceTickets($OpportunityID, $CompanyName, $OpportunityName, $reservation, $TipName, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Search, $Price, $NetWeight);

			if (count($data['SplitExcelConveyanceTickets']) > 0) {
				// Group data by lorry type
				$lorryTypeData = array(
					1 => array(), // Tipper
					2 => array(), // Grab
					3 => array()  // Bin
				);

				foreach ($data['SplitExcelConveyanceTickets'] as $ticket) {
					$lorryType = $ticket['LorryType'];
					if (isset($lorryTypeData[$lorryType])) {
						$lorryTypeData[$lorryType][] = $ticket;
					}
				}

				$this->load->library('zip');
				$this->load->library("excel");
				$xlsfiles = array();

				foreach ($lorryTypeData as $lorryType => $typeTickets) {
					if (empty($typeTickets))
						continue;

					// Get lorry type name for filename
					$lorryTypeName = '';
					switch ($lorryType) {
						case 1:
							$lorryTypeName = 'Tipper';
							break;
						case 2:
							$lorryTypeName = 'Grab';
							break;
						case 3:
							$lorryTypeName = 'Bin';
							break;
					}

					// Find group boundaries
					$Array = array();
					$xx = 0;

					foreach ($typeTickets as $row) {
						if ($xx == 0) {
							$x = $row['CompanyID'];
							$y = $row['OpportunityID'];
							$z = $row['MaterialID'];
						}

						if ($x != $row['CompanyID'] || $y != $row['OpportunityID'] || $z != $row['MaterialID']) {
							$Array[] = $xx;
							$x = $row['CompanyID'];
							$y = $row['OpportunityID'];
							$z = $row['MaterialID'];
						}

						if (count($typeTickets) - 1 == $xx) {
							$xx++;
							$Array[] = $xx;
							break;
						} else {
							$xx++;
						}
					}

					// Create Excel files for each group
					for ($j = 0; $j < count($Array); $j++) {
						$object = new PHPExcel();
						$object->setActiveSheetIndex(0);

						if ($NetWeight == '1') {
							$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name", "Job Site Address", "Supplier Name", "Tip Site Address", "SuppTkt Date", "SuppTkt No", "PO NO", "Product Description", "Price", "WaitTime", "Status", "Net Weight", "Total Price");
						} else {
							$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name", "Job Site Address", "Supplier Name", "Tip Site Address", "SuppTkt Date", "SuppTkt No", "PO NO", "Product Description", "Price", "WaitTime", "Status");
						}

						$column = 0;
						foreach ($table_columns as $field) {
							$object->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
							$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
							$object->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);

							$column++;
						}

						$object->getActiveSheet()->getStyle('k:k')->getNumberFormat()->setFormatCode('0.00');
						$excel_row = 2;

						if ($j == 0) {
							$newi = 0;
						} else {
							$newi = $Array[$j - 1];
						}

						$TPrice = 0;
						$TNPrice = 0;
						$TLoad = 0;
						$TNetWeight = 0;
						$cname = '';
						$oname = '';

						for ($i = $newi; $i < $Array[$j]; $i++) {
							$row = $typeTickets[$i];
							$url = '';

							if ($row['ReceiptName'] != "") {
								$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['ConveyanceNo']);
								if ($row['ReceiptName'] != "") {
									$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $row['ReceiptName']));
								}
							} else {
								$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['TicketConveyance']);
								if ($row['ConveyanceGUID'] != '') {
									$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl('http://193.117.210.98:8081/ticket/Conveyance/' . trim($row['TicketConveyance']) . '.pdf');
								}
							}

							$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['SiteOutDateTime']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['CompanyName']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['OpportunityName']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['TipName']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['TipAddress']);

							if ($row['TipID'] == 1) {
								if ($row['Net'] != '0.00') {
									$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['SuppDate']);
									$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['SuppNo']);
									if ($row['pdf_name'] != "" && $row['pdf_name'] != '.pdf') {
										$object->getActiveSheet()->getCell('H' . $excel_row)->getHyperlink()->setUrl(base_url('assets/pdf_file/' . $row['pdf_name']));
									}
								}
							} else {
								$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['TipTicketDate']);
								if ($row['TipTicketNo'] != '' && $row['TipTicketNo'] != '0') {
									$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['TipTicketNo']);
									$url = "http://193.117.210.98:8081/ticket/Supplier/" . rawurlencode($row['TipName'] . "-" . $row['TipTicketNo']) . ".pdf";
									$object->getActiveSheet()->getCell('H' . $excel_row)->getHyperlink()->setUrl($url);
								}
							}

							$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row['PurchaseOrderNo']);

							if ($row['MStatus'] == 1) {
								$LT = '';
								if ($row['LorryType'] == 1) {
									$LT = 'Tipper';
								} else if ($row['LorryType'] == 2) {
									$LT = 'Grab';
								} else if ($row['LorryType'] == 3) {
									$LT = 'Bin';
								}

								$TB = ($row['TonBook'] == 1) ? ' Tonnage ' : ' Load ';
								// $MaterialText = $row['MaterialName'] . ' Collected ' . $LT . ' ' . $TB;
								$MaterialText = html_entity_decode($row['MaterialName']) . ' Collected ' . $LT . ' ' . $TB;
								// $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $MaterialText);
								$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, html_entity_decode($row['MaterialName']));
							} else {
								// $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row['MaterialName']);
								$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, html_entity_decode($row['MaterialName']));
							}

							$Price = ($row['BookingMaterialID'] == $row['MaterialID']) ? (is_numeric($row['Price']) ? $row['Price'] : 0) : 0;
							$TPrice = bcadd($TPrice, $Price, 3);

							$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $Price);
							$min = ($row['WaitTime'] === null) ? "N/A" : $row['WaitTime'] . " Min";
							$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $min);
							$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row['Status']);

							if ($NetWeight == '1') {
								$NetWeight1 = bcdiv($row['Net'], 1000, 2);
								$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $NetWeight1);
								$TNetWeight = bcadd($TNetWeight, $NetWeight1, 4);
								$NPrice = bcmul($NetWeight1, $row['Price'], 2);
								$TNPrice = bcadd($TNPrice, $NPrice, 2);
								$object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $NPrice);
							}

							$excel_row++;
							$TLoad++;
							$cname = $row['CompanyName'];
							$oname = $row['OpportunityName'];
						}

						if ($NetWeight != '1') {
							$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row)->getFont()->setBold(true);
							$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Total Price');
							$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $TPrice);
						}

						if ($NetWeight == '1') {
							$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row)->getFont()->setBold(true);
							$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 'Total NetWeight');
							$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $TNetWeight);
							$excel_row++;

							$object->getActiveSheet()->getStyle('A' . $excel_row . ':M' . $excel_row)->getFont()->setBold(true);
							$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, "Total Price");
							$object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $TNPrice);
						}

						$excel_row++;
						if ($NetWeight != '1') {
							$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row)->getFont()->setBold(true);
							$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Total Loads');
							$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $TLoad);
						}

						for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
							$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
						}

						$FileName = $cname . "@" . $oname . "@" . $lorryTypeName . "@" . date("YmdHis") . "@" . rand() . ".xls";
						$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).'])", '', $FileName);
						$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

						$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
						header('Content-Type: application/vnd.ms-excel');
						header('Content-Disposition: attachment;filename="' . $FileName . '"');

						ob_start();
						$object_writer->save("SplitXLS/" . $FileName);
						$xlsfiles[] = $FileName;
						$xlsData = ob_get_contents();
						ob_end_clean();
					}
				}

				foreach ($xlsfiles as $xls) {
					$this->zip->read_file('SplitXLS/' . $xls);
				}
				$zname = date("YmdHis") . "-" . rand() . ".zip";
				$this->zip->archive("SplitXLS/" . $zname);

				$response = array(
					'op' => 'ok',
					'FileName' => "SplitXLS/" . $zname,
					'file' => "data:application/zip;base64," . $zname
				);
				die(json_encode($response));
			}
		}
	}


	function SplitExcelExportAll()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$TipName = $this->input->post('TipName');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');
			$NetWeight = $this->input->post('NetWeight');

			$data['SplitExcelConveyanceTickets'] = $this->Booking_model->SplitExcelConveyanceTicketsAll($CompanyName, $OpportunityName, $reservation, $TipName, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Search, $Price, $NetWeight);

			if (count($data['SplitExcelConveyanceTickets']) > 0) {
				$groupedData = array();
				foreach ($data['SplitExcelConveyanceTickets'] as $row) {
					$groupedData[$row['LorryType']][] = $row;
				}

				$this->load->library('zip');
				$this->load->library("excel");
				$xlsfiles = array();

				foreach ($groupedData as $lorryType => $tickets) {
					$Array = array();
					$xx = 0;
					foreach ($tickets as $row) {
						if ($xx == 0) {
							$x = $row['CompanyID'];
							$y = $row['OpportunityID'];
							$z = $row['MaterialID'];
						}
						if ($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID']) {
							// Continue
						} else {
							$Array[] = $xx;
							$x = $row['CompanyID'];
							$y = $row['OpportunityID'];
							$z = $row['MaterialID'];
						}
						if (count($tickets) - 1 == $xx) {
							$xx++;
							$Array[] = $xx;
							break;
						} else {
							$xx++;
						}
					}

					for ($j = 0; $j < count($Array); $j++) {
						$FileName = "";
						$object = new PHPExcel();
						$object->setActiveSheetIndex(0);
						if ($NetWeight == '1') {
							$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name", "Job Site Address", "Supplier Name", "Tip Site Address", "SuppTkt Date", "SuppTkt No", "PO NO", "Product Description", "Price", "WaitTime", "Status", "Net Weight", "Total Price");
						} else {
							$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name", "Job Site Address", "Supplier Name", "Tip Site Address", "SuppTkt Date", "SuppTkt No", "PO NO", "Product Description", "Price", "WaitTime", "Status");
						}
						$column = 0;
						foreach ($table_columns as $field) {
							$object->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
							$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
							$column++;
						}
						$object->getActiveSheet()->getStyle('K:K')->getNumberFormat()->setFormatCode('0.00');
						$excel_row = 2;

						if ($j == 0) {
							$newi = 0;
						} else {
							$newi = $Array[$j - 1];
						}
						$TPrice = 0;
						$TNPrice = 0;
						$TLoad = 0;
						$TNetWeight = 0;
						for ($i = $newi; $i < $Array[$j]; $i++) {
							$cname = "";
							$oname = "";
							$url = '';
							$Price = 0;
							$NPrice = 0;
							$NetWeight1 = 0;

							if ($tickets[$i]['ReceiptName'] != "") {
								$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $tickets[$i]['ConveyanceNo']);
								if ($tickets[$i]['ReceiptName'] != "") {
									$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $tickets[$i]['ReceiptName']));
								}
							} else {
								$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $tickets[$i]['TicketConveyance']);
								if ($tickets[$i]['ConveyanceGUID'] != '') {
									$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl('http://193.117.210.98:8081/ticket/Conveyance/' . trim($tickets[$i]['TicketConveyance']) . '.pdf');
								}
							}

							$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $tickets[$i]['SiteOutDateTime']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $tickets[$i]['CompanyName']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $tickets[$i]['OpportunityName']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $tickets[$i]['TipName']);
							$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $tickets[$i]['TipAddress']);
							if ($tickets[$i]['TipID'] == 1) {
								if ($tickets[$i]['Net'] != '0.00') {
									$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $tickets[$i]['SuppDate']);
									$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $tickets[$i]['SuppNo']);
									if ($tickets[$i]['pdf_name'] != "" && $tickets[$i]['pdf_name'] != '.pdf') {
										$object->getActiveSheet()->getCell('H' . $excel_row)->getHyperlink()->setUrl(base_url('assets/pdf_file/' . $tickets[$i]['pdf_name']));
									}
								}
							} else {
								$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $tickets[$i]['TipTicketDate']);
								if ($tickets[$i]['TipTicketNo'] != '' && $tickets[$i]['TipTicketNo'] != '0') {
									$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $tickets[$i]['TipTicketNo']);
									$url = "http://193.117.210.98:8081/ticket/Supplier/" . rawurlencode($tickets[$i]['TipName'] . "-" . $tickets[$i]['TipTicketNo']) . ".pdf";
									$object->getActiveSheet()->getCell('H' . $excel_row)->getHyperlink()->setUrl($url);
								}
							}

							$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $tickets[$i]['PurchaseOrderNo']);
							if ($row['MStatus'] == 1) {
								$LT = '';
								if ($tickets[$i]['LorryType'] == 1) {
									$LT = 'Tipper';
								} else if ($tickets[$i]['LorryType'] == 2) {
									$LT = 'Grab';
								} else if ($tickets[$i]['LorryType'] == 3) {
									$LT = 'Bin';
								} else {
									$LT = '';
								}

								$TB = '';
								if ($tickets[$i]['TonBook'] == 1) {
									$TB = ' Tonnage ';
								} else {
									$TB = ' Load ';
								}
								$MaterialText = html_entity_decode($tickets[$i]['MaterialName']) . ' Collected ' . $LT . ' ' . $TB;
								// $MaterialText = $tickets[$i]['MaterialName'] . ' Collected ' . $LT . ' ' . $TB;
								$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $MaterialText);
							} else {
								$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, html_entity_decode($tickets[$i]['MaterialName']));
								// $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $tickets[$i]['MaterialName']);
							}
							$Price = is_numeric($tickets[$i]['Price']) ? $tickets[$i]['Price'] : 0;
							//if ($tickets[$i]['BookingMaterialID'] == $tickets[$i]['MaterialID']) {
								// $Price = is_numeric($row['Price']) ? $row['Price'] : 0;
							//	$Price = is_numeric($tickets[$i]['Price']) ? $tickets[$i]['Price'] : 0;

							//}
							// $TPrice = floor(($TPrice + $Price) * 100) / 100;
							$TPrice = bcadd($TPrice, $Price, 2);
							$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $Price);
							if ($tickets[$i]['WaitTime'] == null) {
								$min = "N/A";
							} else {
								$min = $tickets[$i]['WaitTime'] . " Min";
							}

							$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $min);
							$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $tickets[$i]['Status']);
							if ($NetWeight == '1') {
								$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($tickets[$i]['Net'] / 1000, 3));

								// Calculate NetWeight1 with bcmul
								$NetWeight1 = bcmul($tickets[$i]['Net'], '0.001', 3);
								// Apply floor adjustment for NetWeight1
								$NetWeight1 = floor(bcmul($NetWeight1, '100', 2)) / 100;

								// Update TNetWeight using bcadd and floor adjustment
								$TNetWeight = bcadd($TNetWeight, $NetWeight1, 4);
								$TNetWeight = floor(bcmul($TNetWeight, '100', 2)) / 100;

								// Calculate NPrice using bcmul and apply floor adjustment
								$NPrice = bcmul($NetWeight1, $tickets[$i]['Price'], 4);
								$NPrice = floor(bcmul($NPrice, '100', 2)) / 100;

								// Update TNPrice using bcadd and floor adjustment
								$TNPrice = bcadd($TNPrice, $NPrice, 4);
								$TNPrice = floor(bcmul($TNPrice, '100', 2)) / 100;

								$object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $NPrice);
							}

							$excel_row++;
							$TLoad = $TLoad + 1;
							$cname = $tickets[$i]['CompanyName'];
							$oname = $tickets[$i]['OpportunityName'];
						}

						if ($NetWeight != '1') {
							$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row)->getFont()->setBold(true);
							$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Total Price');
							$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $TPrice);
						}
						if ($NetWeight == '1') {
							$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
							$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 'Total NetWeight');
							$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $TNetWeight);
							$excel_row++;

							$object->getActiveSheet()->getStyle('A' . $excel_row . ':M' . $excel_row . '')->getFont()->setBold(true);
							$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, "Total Price");
							$object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $TNPrice);
						}
						$excel_row++;
						if ($NetWeight != '1') {
							$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row)->getFont()->setBold(true);
							$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Total Loads');
							$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $TLoad);
						}

						for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
							$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
						}

						$FileName = $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . ".xls";
						$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).'])", '', $FileName);
						$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);
						$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

						header('Content-Type: application/vnd.ms-excel');
						header('Content-Disposition: attachment;filename="' . $FileName . '"');

						ob_start();
						$object_writer->save("SplitXLS/" . $FileName);
						$xlsfiles[] = $FileName;
						$xlsData = ob_get_contents();
						ob_end_clean();
					}
				}

				foreach ($xlsfiles as $xls) {
					$this->zip->read_file('SplitXLS/' . $xls);
				}
				$zname = date("YmdHis") . "-" . rand() . ".zip";
				$this->zip->archive("SplitXLS/" . $zname);

				$response = array(
					'op' => 'ok',
					'FileName' => "SplitXLS/" . $zname,
					'file' => "data:application/zip;base64," . $zname
				);
				die(json_encode($response));
			}
		}
	}



	function WaitTimeSplitExcelConvAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$CompanyName = $this->input->post('CompanyName');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$TipName = $this->input->post('TipName');
			//$JobStartDateTime   = $this->input->post('JobStartDateTime');  
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');

			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$WaitTime = $this->input->post('WaitTime');

			//$data['CompanyOppoRecords'] = $this->Booking_model->CompanyOppoRecordsAJAX(); 
			$data['CompanyOppoRecords'] = $this->Booking_model->SplitExcelOppoGroup($CompanyName, $OpportunityName, $reservation, $TipName, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status);

			$html = $this->load->view('Booking/WaitTimeSplitExcelConvAjax', $data, true);
			echo json_encode($html);

		}
	}
	function WaitTimeSplitExcelExport()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {


			//var_dump($_POST); 			
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityID = $this->input->post('OpportunityID');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$TipName = $this->input->post('TipName');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');

			$data['SplitExcelConveyanceTickets'] = $this->Booking_model->WaitTimeSplitExcelConveyanceTickets($OpportunityID, $CompanyName, $OpportunityName, $reservation, $TipName, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Search, $Price);

			if (count($data['SplitExcelConveyanceTickets']) > 0) {
				$Array = array();
				$xx = 0;

				foreach ($data['SplitExcelConveyanceTickets'] as $row) {
					if ($xx == 0) {
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if ($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID']) {
					} else {
						$Array[] = $xx;
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if (count($data['SplitExcelConveyanceTickets']) - 1 == $xx) {
						$xx++;
						$Array[] = $xx;
						break;
					} else {
						$xx++;
					}
				}
			}


			//print_r($Array);
			//exit;
			$this->load->library('zip');
			$this->load->library("excel");
			$xlsfiles = array();
			for ($j = 0; $j < count($Array); $j++) {
				$FileName = "";
				/* Header Start Excel  */
				$object = new PHPExcel();
				//print_r($_POST); die;
				$object->setActiveSheetIndex(0);

				$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Price per min", "Arrival Time", "Departure Time", "Total Minutes", "FOC Minutes", "Total Hrs Waiting Time", "Total Mins Waiting Time", "Net Charge");

				$column = 0;
				foreach ($table_columns as $field) {
					$object->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$column++;
				}
				$object->getActiveSheet()->getStyle('k:k')->getNumberFormat()->setFormatCode('0.00');
				$excel_row = 2;
				/* Header End Excel  */

				/* Records Start  For Each  */
				//foreach( $data['SplitExcelConveyanceTickets'] as $row){ 
				//echo $Array[$j]; 
				if ($j == 0) {
					$newi = 0;
				} else {
					$newi = $Array[$j - 1];
				}
				$TPrice = 0;
				$ALLTotalWaitTime = 0;
				$THours = 0;
				for ($i = $newi; $i < $Array[$j]; $i++) {
					//for($i=0;$i<count($data['SplitExcelConveyanceTickets']);$i++){  
					$cname = "";
					$oname = "";
					$url = '';
					$TotalWaitTime = 0;
					$Price = 0; //$Status = ''; 

					if ($data['SplitExcelConveyanceTickets'][$i]['ReceiptName'] != "") {
						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['ConveyanceNo']);
						if ($data['SplitExcelConveyanceTickets'][$i]['ReceiptName'] != "") {
							$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $data['SplitExcelConveyanceTickets'][$i]['ReceiptName']));
						}
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['TicketConveyance']);
						if ($data['SplitExcelConveyanceTickets'][$i]['ConveyanceGUID'] != '') {
							$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl('http://193.117.210.98:8081/ticket/Conveyance/' . trim($data['SplitExcelConveyanceTickets'][$i]['TicketConveyance']) . '.pdf');
							//$object->getActiveSheet()->getCell('A'.$excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/'.$data['SplitExcelConveyanceTickets'][$i]['ReceiptName'])); 	
						}//else{ 	
						//} 
					}


					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['SiteOutDateTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['CompanyName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['OpportunityName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['PurchaseOrderNo']);
					if ($row['MStatus'] == 1) {
						$LT = '';
						if ($data['SplitExcelConveyanceTickets'][$i]['LorryType'] == 1) {
							$LT = 'Tipper';
						} else if ($data['SplitExcelConveyanceTickets'][$i]['LorryType'] == 2) {
							$LT = 'Grab';
						} else if ($data['SplitExcelConveyanceTickets'][$i]['LorryType'] == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($data['SplitExcelConveyanceTickets'][$i]['TonBook'] == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						// $MaterialText = $data['SplitExcelConveyanceTickets'][$i]['MaterialName'] . ' Collected ' . $LT . ' ' . $TB;
						$MaterialText = html_entity_decode($data['SplitExcelConveyanceTickets'][$i]['MaterialName']) . ' Collected ' . $LT . ' ' . $TB;
						// $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, html_entity_decode($MaterialText));
					} else {
						// $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['MaterialName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, html_entity_decode($data['SplitExcelConveyanceTickets'][$i]['MaterialName']));
					}

					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['WaitingCharge']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['ArrivalTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['DeptTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, round($data['SplitExcelConveyanceTickets'][$i]['WaitTime']));
					$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['WaitingTime']);

					$TotalWaitTime = round($data['SplitExcelConveyanceTickets'][$i]['WaitTime'] - $data['SplitExcelConveyanceTickets'][$i]['WaitingTime']);
					if ($TotalWaitTime > 0) {
						//$Price = round($TotalWaitTime * $data['SplitExcelConveyanceTickets'][$i]['WaitingCharge'],2); 
						$Price = floor(($TotalWaitTime * $data['SplitExcelConveyanceTickets'][$i]['WaitingCharge']) * 100) / 100;

						//$ALLTotalWaitTime = round(($ALLTotalWaitTime + $TotalWaitTime));
						$ALLTotalWaitTime = floor(($ALLTotalWaitTime + $TotalWaitTime) * 100) / 100;

					} else {
						$Price = 0;
					}
					//$TPrice = $TPrice + $Price;
					$TPrice = floor(($TPrice + $Price) * 100) / 100;

					if ($data['SplitExcelConveyanceTickets'][$i]['WaitTime'] - $data['SplitExcelConveyanceTickets'][$i]['WaitingTime'] > 0) {
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, round($TotalWaitTime / 60, 2));
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, round($TotalWaitTime));
						$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $Price);
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 0);
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 0);
						$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, 0);
					}
					$excel_row++;
					$TLoad = $TLoad + 1;
					$cname = $data['SplitExcelConveyanceTickets'][$i]['CompanyName'];
					$oname = $data['SplitExcelConveyanceTickets'][$i]['OpportunityName'];

				} /// For each 
				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Waiting Time - In Excess of FOC Minutes Per Load Count');
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, '');


				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				//$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Total Loads' );
				$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $ALLTotalWaitTime);

				$excel_row++;

				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				//$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 'Total Price' );
				$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $TPrice);


				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Total Chargeable Waiting Time Hours');

				/* Export Start Excel  */
				for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
					$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
				}

				$FileName = "WaitTimeCollection_" . $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . ".xls";

				//$FileName = $row['CompanyName']."-".$row['OpportunityName']."-".date("YmdHis").".xls";		
				//$FileName = date("YmdHis")."-".rand().".xls";		

				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_~,;[](). 
				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).])", '', $FileName);
				// Remove any runs of periods (thanks falstro!)
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

				//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
				header('Content-Disposition: attachment;filename="' . $FileName . '"');

				ob_start();
				$object_writer->save("SplitXLS/" . $FileName);

				$xlsfiles[] = $FileName;
				$xlsData = ob_get_contents();
				ob_end_clean();
				/* Export End Excel  */
			}

			foreach ($xlsfiles as $xls) {
				$this->zip->read_file('SplitXLS/' . $xls);
			}
			$zname = "WaitTimeCollection_" . date("YmdHis") . "-" . rand() . ".zip";
			$this->zip->archive("SplitXLS/" . $zname);

			$response = array(
				'op' => 'ok',
				'FileName' => "SplitXLS/" . $zname,
				'file' => "data:application/zip;base64," . $zname
			);
			die(json_encode($response));
		}
	}


	function WaitTimeSplitExcelExportAll()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			//var_dump($_POST); 			
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$TipName = $this->input->post('TipName');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');

			$data['SplitExcelConveyanceTickets'] = $this->Booking_model->WaitTimeSplitExcelConveyanceTicketsAll($CompanyName, $OpportunityName, $reservation, $TipName, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Search, $Price);
			//var_dump($data['SplitExcelConveyanceTickets']); 
			if (count($data['SplitExcelConveyanceTickets']) > 0) {
				$Array = array();
				//for($a=0;$a>count($data['SplitExcelConveyanceTickets']);$a++){  
				$xx = 0;

				foreach ($data['SplitExcelConveyanceTickets'] as $row) {
					if ($xx == 0) {
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if ($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID']) {
						//$xx++;  

						//	echo $xx;
						//	echo " ==== ";
						//	echo $x; 
						//	echo " ==== ";
						//	echo $y; 
						//	echo " ==== ";
						//	echo $z;
						//	echo " </br>  ";

					} else {
						$Array[] = $xx;

						//$xx++; 
						//echo "| else ".$xx." |";
						//	echo " ||| ==== ";
						$x = $row['CompanyID'];
						//	echo " ==== ";
						$y = $row['OpportunityID'];
						//	echo " ==== ";
						$z = $row['MaterialID'];
						//	echo " </br>  ";
					}

					if (count($data['SplitExcelConveyanceTickets']) - 1 == $xx) {
						$xx++;
						$Array[] = $xx;
						//echo "|  count ".$xx." |";
						break;

					} else {
						$xx++;
					}


				}

			}


			//print_r($Array);
			//exit;
			$this->load->library('zip');
			$this->load->library("excel");
			$xlsfiles = array();
			for ($j = 0; $j < count($Array); $j++) {
				$FileName = "";
				/* Header Start Excel  */
				$object = new PHPExcel();
				//print_r($_POST); die;
				$object->setActiveSheetIndex(0);

				$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Price per min", "Arrival Time", "Departure Time", "Total Minutes", "FOC Minutes", "Total Hrs Waiting Time", "Total Mins Waiting Time", "Net Charge");

				$column = 0;
				foreach ($table_columns as $field) {
					$object->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$column++;
				}
				$object->getActiveSheet()->getStyle('k:k')->getNumberFormat()->setFormatCode('0.00');
				$excel_row = 2;
				/* Header End Excel  */

				/* Records Start  For Each  */
				//foreach( $data['SplitExcelConveyanceTickets'] as $row){ 
				//echo $Array[$j]; 
				if ($j == 0) {
					$newi = 0;
				} else {
					$newi = $Array[$j - 1];
				}
				$TPrice = 0;
				$ALLTotalWaitTime = 0;
				$THours = 0;
				for ($i = $newi; $i < $Array[$j]; $i++) {
					//for($i=0;$i<count($data['SplitExcelConveyanceTickets']);$i++){  
					$cname = "";
					$oname = "";
					$url = '';
					$TotalWaitTime = 0;
					$Price = 0; //$Status = ''; 

					if ($data['SplitExcelConveyanceTickets'][$i]['ReceiptName'] != "") {
						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['ConveyanceNo']);
						if ($data['SplitExcelConveyanceTickets'][$i]['ReceiptName'] != "") {
							$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $data['SplitExcelConveyanceTickets'][$i]['ReceiptName']));
						}
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['TicketConveyance']);
						if ($data['SplitExcelConveyanceTickets'][$i]['ConveyanceGUID'] != '') {
							$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl('http://193.117.210.98:8081/ticket/Conveyance/' . trim($data['SplitExcelConveyanceTickets'][$i]['TicketConveyance']) . '.pdf');
							//$object->getActiveSheet()->getCell('A'.$excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/'.$data['SplitExcelConveyanceTickets'][$i]['ReceiptName'])); 	
						}//else{ 	
						//} 
					}


					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['SiteOutDateTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['CompanyName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['OpportunityName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['PurchaseOrderNo']);
					if ($row['MStatus'] == 1) {
						$LT = '';
						if ($data['SplitExcelConveyanceTickets'][$i]['LorryType'] == 1) {
							$LT = 'Tipper';
						} else if ($data['SplitExcelConveyanceTickets'][$i]['LorryType'] == 2) {
							$LT = 'Grab';
						} else if ($data['SplitExcelConveyanceTickets'][$i]['LorryType'] == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($data['SplitExcelConveyanceTickets'][$i]['TonBook'] == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						// $MaterialText = $data['SplitExcelConveyanceTickets'][$i]['MaterialName'] . ' Collected ' . $LT . ' ' . $TB;
						// $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
						$MaterialText = html_entity_decode($data['SplitExcelConveyanceTickets'][$i]['MaterialName']) . ' Collected ' . $LT . ' ' . $TB;
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, html_entity_decode($MaterialText));
					} else {
						// $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['MaterialName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, html_entity_decode($data['SplitExcelConveyanceTickets'][$i]['MaterialName']));
					}

					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['WaitingCharge']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['ArrivalTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['DeptTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, round($data['SplitExcelConveyanceTickets'][$i]['WaitTime']));
					$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $data['SplitExcelConveyanceTickets'][$i]['WaitingTime']);

					$TotalWaitTime = round($data['SplitExcelConveyanceTickets'][$i]['WaitTime'] - $data['SplitExcelConveyanceTickets'][$i]['WaitingTime']);
					if ($TotalWaitTime > 0) {
						$Price = floor(($TotalWaitTime * $data['SplitExcelConveyanceTickets'][$i]['WaitingCharge']) * 100) / 100;
						$ALLTotalWaitTime = floor(($ALLTotalWaitTime + $TotalWaitTime) * 100) / 100;

						//$Price = round($TotalWaitTime * $data['SplitExcelConveyanceTickets'][$i]['WaitingCharge'],2); 
						//$ALLTotalWaitTime = round(($ALLTotalWaitTime + $TotalWaitTime));

					} else {
						$Price = 0;
					}
					//$TPrice = $TPrice + $Price;
					$TPrice = floor(($TPrice + $Price) * 100) / 100;

					if ($data['SplitExcelConveyanceTickets'][$i]['WaitTime'] - $data['SplitExcelConveyanceTickets'][$i]['WaitingTime'] > 0) {
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, round($TotalWaitTime / 60, 2));
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, round($TotalWaitTime));
						$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $Price);
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 0);
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 0);
						$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, 0);
					}
					$excel_row++;
					$TLoad = $TLoad + 1;


					$cname = $data['SplitExcelConveyanceTickets'][$i]['CompanyName'];
					$oname = $data['SplitExcelConveyanceTickets'][$i]['OpportunityName'];

				} /// For each 
				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Waiting Time - In Excess of FOC Minutes Per Load Count');
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, '');


				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				//$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Total Loads' );
				$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $ALLTotalWaitTime);

				$excel_row++;

				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				//$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 'Total Price' );
				$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $TPrice);


				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Total Chargeable Waiting Time Hours');
				/* Export Start Excel  */
				for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
					$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
				}

				$FileName = "WaitTimeCollection_" . $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . ".xls";

				//$FileName = $row['CompanyName']."-".$row['OpportunityName']."-".date("YmdHis").".xls";		
				//$FileName = date("YmdHis")."-".rand().".xls";		

				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_~,;[](). 
				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).])", '', $FileName);
				// Remove any runs of periods (thanks falstro!)
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

				//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
				header('Content-Disposition: attachment;filename="' . $FileName . '"');
				//$object_writer->save('php://output'); 

				ob_start();
				//$object_writer->save("php://output");
				//$object_writer->save(str_replace(__FILE__,'SplitXLS/'.$FileName,__FILE__)); 
				$object_writer->save("SplitXLS/" . $FileName);

				//$this->zip->add_data($FileName,$object_writer->save("SplitXLS/".$FileName)); 
				$xlsfiles[] = $FileName;
				$xlsData = ob_get_contents();
				ob_end_clean();
				/* Export End Excel  */
			}

			foreach ($xlsfiles as $xls) {
				$this->zip->read_file('SplitXLS/' . $xls);
			}
			$zname = "WaitTimeCollection_" . date("YmdHis") . "-" . rand() . ".zip";
			$this->zip->archive("SplitXLS/" . $zname);
			//$this->zip->download($zname);

			//exit;
			//$zipFile = base_url("SplitXLS/".$zname); 
			$response = array(
				'op' => 'ok',
				'FileName' => "SplitXLS/" . $zname,
				'file' => "data:application/zip;base64," . $zname
			);
			die(json_encode($response));
			//'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)

		}
	}



	function SplitExcelDelAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$CompanyName = $this->input->post('CompanyName');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation1 = $this->input->post('reservation1');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$TicketNumber = $this->input->post('TicketNumber');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');
			$Search = $this->input->post('Search');
			$PurchaseOrderNo = $this->input->post('PurchaseOrderNo');

			//$data['CompanyOppoRecords'] = $this->Booking_model->CompanyOppoRecordsAJAX(); 
			$data['CompanyOppoRecords'] = $this->Booking_model->SplitExcelDelOppoGroup($CompanyName, $OpportunityName, $reservation1, $SiteOutDateTime, $TicketNumber, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Price, $Search, $PurchaseOrderNo);

			$html = $this->load->view('Booking/SplitExcelDelAjax', $data, true);
			echo json_encode($html);

		}
	}

	function SplitExcelDelExport()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$CompanyName = $this->input->post('CompanyName');
			$OpportunityID = $this->input->post('OpportunityID');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation1 = $this->input->post('reservation1');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$TicketNumber = $this->input->post('TicketNumber');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');
			$NetWeight = $this->input->post('NetWeight');
			$Price = $this->input->post('Price');
			$Search = $this->input->post('Search');
			$PurchaseOrderNo = $this->input->post('PurchaseOrderNo');

			$data['SplitExcelDelTickets'] = $this->Booking_model->SplitExcelDelTickets($OpportunityID, $CompanyName, $OpportunityName, $reservation1, $SiteOutDateTime, $TicketNumber, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Price, $Search, $PurchaseOrderNo);

			if (count($data['SplitExcelDelTickets']) > 0) {
				$this->load->library('zip');
				$this->load->library("excel");

				$lorryTypes = [1 => 'Tipper', 2 => 'Grab', 3 => 'Bin'];
				$xlsfiles = [];

				foreach ($lorryTypes as $lt => $ltName) {
					$FileName = "";
					/* Header Start Excel  */
					$object = new PHPExcel();
					$object->setActiveSheetIndex(0);
					if ($NetWeight == '1') {
						$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Driver Name", "VRNO", "Price", "WaitTime", "Status", "NetWeight", "Total Price");
					} else {
						$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Driver Name", "VRNO", "Price", "WaitTime", "Status");
					}
					$column = 0;
					foreach ($table_columns as $field) {
						$object->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
						$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
						$col = PHPExcel_Cell::stringFromColumnIndex($column);
						$object->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);

						$column++;
					}
					$object->getActiveSheet()->getStyle('G:G')->getNumberFormat()->setFormatCode('0.00');
					$excel_row = 2;
					/* Header End Excel  */

					/* Records Start  For Each  */
					$TPrice = 0;
					$TNPrice = 0;
					$TLoad = 0;
					$TNetWeight = 0;
					foreach ($data['SplitExcelDelTickets'] as $i => $row) {
						// Skip the rows that don't match the current lorry type
						if ($row['LorryType'] != $lt) {
							continue;
						}
						$TLoad++;

						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['TicketNumber']);

						if ($row['DOCID'] != '' && $row['DOCID'] != null) {
							$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('http://193.117.210.98:8081/ticket/Delivery/' . $row['TicketNumber'] . '.pdf'));
						} else {
							if ($row['ReceiptName'] != "") {
								$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $row['ReceiptName']));
							}
						}

						$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['SiteOutDateTime']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['CompanyName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['OpportunityName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['PurchaseOrderNo']);

						if ($row['MStatus'] == 1) {
							$LT = '';
							if ($row['LorryType'] == 1) {
								$LT = 'Tipper';
							} else if ($row['LorryType'] == 2) {
								$LT = 'Grab';
							} else if ($row['LorryType'] == 3) {
								$LT = 'Bin';
							} else {
								$LT = '';
							}

							$TB = '';
							if ($row['TonBook'] == 1) {
								$TB = ' Tonnage ';
							} else {
								$TB = ' Load ';
							}

							$MaterialText = $row['MaterialName'] . ' Delivered ' . $LT . ' ' . $TB;
							$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
						} else {
							$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['MaterialName']);
						}

						// Add Driver Name
						$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['DriverName']);

						// Add Vehicle Registration Number
						$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['VehicleRegNo']);

						$Price = is_numeric($row['Price']) ? $row['Price'] : 0;
						$TPrice = bcadd($TPrice, $Price, 3);
						$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $Price);

						$min = $row['WaitTime'] == null ? "N/A" : $row['WaitTime'] . " Min";
						$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $min);
						$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row['Status']);

						if ($NetWeight == '1') {
							$NetWeight1 = bcdiv($row['Net'], 1000, 2);
							$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $NetWeight1);
							$TNetWeight = bcadd($TNetWeight, $NetWeight1, 3);
							$NPrice = bcmul($NetWeight1, $row['Price'], 3);
							$TNPrice = bcadd($TNPrice, $NPrice, 3);
							$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $NPrice);
						}

						$excel_row++;
						$cname = $data['SplitExcelDelTickets'][$i]['CompanyName'];
						$oname = $data['SplitExcelDelTickets'][$i]['OpportunityName'];
					}

					if ($NetWeight != '1') {
						$object->getActiveSheet()->getStyle('A' . $excel_row . ':M' . $excel_row . '')->getFont()->setBold(true);
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, "Total Price");
						$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $TPrice);
						$excel_row++;
					}

					if ($NetWeight == '1') {
						$object->getActiveSheet()->getStyle('A' . $excel_row . ':M' . $excel_row . '')->getFont()->setBold(true);
						$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, "Total Net Weight");
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $TNetWeight);
						$excel_row++;

						$object->getActiveSheet()->getStyle('A' . $excel_row . ':M' . $excel_row . '')->getFont()->setBold(true);
						$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, "Total Price");
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $TNPrice);
						$excel_row++;
					}

					if ($TLoad == 0) {
						continue;
					}

					// $cname = preg_replace('/[^A-Za-z0-9]/', '', $CompanyName);
					$oname = preg_replace('/[^A-Za-z0-9]/', '', $OpportunityName);
					$FileName = $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . "_" . $ltName . ".xlsx";

					// Clean filename
					$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).'])", '', $FileName);
					$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

					$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

					ob_start();
					$object_writer->save("SplitXLS/" . $FileName);
					$xlsfiles[] = $FileName;
					$xlsData = ob_get_contents();
					ob_end_clean();
				}

				/* Skip ZIP if no files */
				if (empty($xlsfiles)) {
					$response = array('op' => 'no_data', 'message' => 'No data available to export.');
					echo json_encode($response);
					exit;
				}

				// Create ZIP file
				foreach ($xlsfiles as $xls) {
					$this->zip->read_file('SplitXLS/' . $xls);
				}

				$zname = date("YmdHis") . "-" . rand() . ".zip";
				$this->zip->archive("SplitXLS/" . $zname);

				// Clean up Excel files
				foreach ($xlsfiles as $xls) {
					@unlink('SplitXLS/' . $xls);
				}

				$response = array(
					'op' => 'ok',
					'FileName' => "SplitXLS/" . $zname,
					'file' => "data:application/zip;base64," . $zname
				);

				echo json_encode($response);
				exit;
			}
		}
	}
	function SplitExcelDelExportAll()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			$CompanyName = $this->input->post('CompanyName');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation1 = $this->input->post('reservation1');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$TicketNumber = $this->input->post('TicketNumber');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$WaitTime = $this->input->post('WaitTime');
			$NetWeight = $this->input->post('NetWeight');

			$Price = $this->input->post('Price');
			$Search = $this->input->post('Search');
			$PurchaseOrderNo = $this->input->post('PurchaseOrderNo');

			$data['SplitExcelDelTickets'] = $this->Booking_model->SplitExcelDeliveryTicketsAll($CompanyName, $OpportunityName, $reservation1, $SiteOutDateTime, $TicketNumber, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Search, $Price, $NetWeight, $PurchaseOrderNo);

			if (count($data['SplitExcelDelTickets']) > 0) {
				$Array = array();
				$xx = 0;

				foreach ($data['SplitExcelDelTickets'] as $row) {
					if ($xx == 0) {
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}
					if ($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID']) {
					} else {
						$Array[] = $xx;
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if (count($data['SplitExcelDelTickets']) - 1 == $xx) {
						$xx++;
						$Array[] = $xx;
						break;
					} else {
						$xx++;
					}
				}
			}

			$this->load->library('zip');
			$this->load->library("excel");
			$xlsfiles = array();
			for ($j = 0; $j < count($Array); $j++) {
				$FileName = "";
				/* Header Start Excel  */
				$object = new PHPExcel();
				$object->setActiveSheetIndex(0);
				if ($NetWeight == '1') {
					$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Vehicle Reg No", "Driver Name", "Price", "WaitTime", "Status", "NetWeight", "Total Price");
				} else {
					$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Vehicle Reg No", "Driver Name", "Price", "WaitTime", "Status");
				}
				$column = 0;
				foreach ($table_columns as $field) {
					$object->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$column++;
				}
				$object->getActiveSheet()->getStyle('g:g')->getNumberFormat()->setFormatCode('0.00');
				$excel_row = 2;
				/* Header End Excel  */

				/* Records Start  For Each  */
				if ($j == 0) {
					$newi = 0;
				} else {
					$newi = $Array[$j - 1];
				}
				$TPrice = 0;
				$TNPrice = 0;
				$TLoad = 0;
				$TNetWeight = 0;
				for ($i = $newi; $i < $Array[$j]; $i++) {
					$cname = "";
					$oname = "";
					$url = '';
					$Price = 0;
					$NPrice = 0;

					$NetWeight1 = 0;

					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelDelTickets'][$i]['TicketNumber']);

					if ($row['DOCID'] != '' && $row['DOCID'] != null) {
						$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('http://193.117.210.98:8081/ticket/Delivery/' . $data['SplitExcelDelTickets'][$i]['TicketNumber'] . '.pdf'));
					} else {
						if ($data['SplitExcelDelTickets'][$i]['ReceiptName'] != "") {
							$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $data['SplitExcelDelTickets'][$i]['ReceiptName']));
						}
					}

					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['SplitExcelDelTickets'][$i]['SiteOutDateTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $data['SplitExcelDelTickets'][$i]['CompanyName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $data['SplitExcelDelTickets'][$i]['OpportunityName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $data['SplitExcelDelTickets'][$i]['PurchaseOrderNo']);

					if ($data['SplitExcelDelTickets'][$i]['MStatus'] == 1) {
						$LT = '';
						if ($data['SplitExcelDelTickets'][$i]['LorryType'] == 1) {
							$LT = 'Tipper';
						} else if ($data['SplitExcelDelTickets'][$i]['LorryType'] == 2) {
							$LT = 'Grab';
						} else if ($data['SplitExcelDelTickets'][$i]['LorryType'] == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($data['SplitExcelDelTickets'][$i]['TonBook'] == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						$MaterialText = $data['SplitExcelDelTickets'][$i]['MaterialName'] . ' Delivered ' . $LT . ' ' . $TB;
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $data['SplitExcelDelTickets'][$i]['MaterialName']);
					}

					// Add Vehicle Reg No
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $data['SplitExcelDelTickets'][$i]['VehicleRegNo']);

					// Add Driver Name
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $data['SplitExcelDelTickets'][$i]['DriverName']);

					if (is_numeric($data['SplitExcelDelTickets'][$i]['Price'])) {
						$Price = $data['SplitExcelDelTickets'][$i]['Price'];
					} else {
						$Price = 0;
					}

					$TPrice = floor(($TPrice + $Price) * 100) / 100;

					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $Price);

					if ($data['SplitExcelDelTickets'][$i]['WaitTime'] == null) {
						$min = "N/A";
					} else {
						$min = $data['SplitExcelDelTickets'][$i]['WaitTime'] . " Min";
					}

					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $min);
					$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $data['SplitExcelDelTickets'][$i]['Status']);

					if ($NetWeight == '1') {
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, round($data['SplitExcelDelTickets'][$i]['Net'] / 1000, 2));
						$NetWeight1 = floor(((float) $data['SplitExcelDelTickets'][$i]['Net'] / 1000) * 100) / 100;

						$TNetWeight = floor(((float) $TNetWeight + (float) $NetWeight1) * 100) / 100;

						$NPrice = floor(((float) $NetWeight1 * (float) $data['SplitExcelDelTickets'][$i]['Price']) * 100) / 100;

						$TNPrice = floor(((float) $TNPrice + (float) $NPrice) * 100) / 100;

						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $NPrice);

					}

					$excel_row++;
					$cname = $data['SplitExcelDelTickets'][$i]['CompanyName'];
					$oname = $data['SplitExcelDelTickets'][$i]['OpportunityName'];
					$CompanyID = $data['SplitExcelDelTickets'][$i]['CompanyID'];
					$OpportunityID = $data['SplitExcelDelTickets'][$i]['OpportunityID'];
					$MaterialID = $data['SplitExcelDelTickets'][$i]['MaterialID'];
					$TLoad = $TLoad + 1;
				} /// For each 
				/* Records Start For Each   */
				if ($NetWeight != '1') {

					$object->getActiveSheet()->getStyle('A' . $excel_row . ':M' . $excel_row . '')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, "Total Price");
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $TPrice);
				}
				if ($NetWeight == '1') {
					$object->getActiveSheet()->getStyle('A' . $excel_row . ':M' . $excel_row . '')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, "Total Net Weight");
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $TNetWeight);
					$excel_row++;

					$object->getActiveSheet()->getStyle('A' . $excel_row . ':M' . $excel_row . '')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, "Total Price");
					$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $TNPrice);

				}
				$excel_row++;
				if ($NetWeight != '1') {
					$object->getActiveSheet()->getStyle('A' . $excel_row . ':M' . $excel_row . '')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, "Total Load Count");
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $TLoad);
					$excel_row++;
				}
				/* Export Start Excel  */
				for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
					$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
				}

				$FileName = $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . ".xls";	// filename	

				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_~,;[](). 
				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).'])", '', $FileName);

				// Remove any runs of periods (thanks falstro!)
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);
				//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
				header('Content-Disposition: attachment;filename="' . $FileName . '"');
				//$object_writer->save('php://output'); 

				ob_start();
				$object_writer->save("SplitXLS/" . $FileName);
				$xlsfiles[] = $FileName;
				$xlsData = ob_get_contents();
				ob_end_clean();
				/* Export End Excel  */
			}

			//exit; 
			foreach ($xlsfiles as $xls) {
				$this->zip->read_file('SplitXLS/' . $xls);
			}
			$zname = date("YmdHis") . "-" . rand() . ".zip";
			$this->zip->archive("SplitXLS/" . $zname);
			$response = array(
				'op' => 'ok',
				'FileName' => "SplitXLS/" . $zname,
				'file' => "data:application/zip;base64," . $zname
			);
			die(json_encode($response));
		}
	}
	public function DeliveryExcelExport()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$CompanyName = $this->input->post('CompanyName');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation1 = $this->input->post('reservation1');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$TicketNumber = $this->input->post('TicketNumber');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$WaitTime = $this->input->post('WaitTime');
			$NetWeight = $this->input->post('NetWeight');
			$Price = $this->input->post('Price');
			$Search = $this->input->post('Search');
			$PurchaseOrderNo = $this->input->post('PurchaseOrderNo');

			$data['SplitExcelDelTickets'] = $this->Booking_model->SplitExcelDeliveryTicketsAll(
				$CompanyName,
				$OpportunityName,
				$reservation1,
				$SiteOutDateTime,
				$TicketNumber,
				$MaterialName,
				$DriverName,
				$VehicleRegNo,
				$WaitTime,
				$Status,
				$Search,
				$Price,
				$NetWeight,
				$PurchaseOrderNo
			);

			// Load Excel library  
			$this->load->library("excel");

			// Lorry types (Tipper, Grab, Bin)
			$lorryTypes = [0 => 'delivery', 1 => 'Tipper', 2 => 'Grab', 3 => 'Bin'];

			// Create a folder to store the Excel files
			$xlsFolder = 'SplitXLS/';
			if (!is_dir($xlsFolder)) {
				mkdir($xlsFolder, 0777, true); // Create folder if it doesn't exist
			}

			// Initialize an array to hold the Excel file names
			$xlsFiles = [];

			foreach ($lorryTypes as $typeId => $lorryType) {

				$filteredData = array_filter($data['SplitExcelDelTickets'], function ($row) use ($typeId) {
					return $row['LorryType'] == $typeId;
				});

				if (empty($filteredData)) {
					continue;
				}

				$object = new PHPExcel();
				$object->setActiveSheetIndex(0);

				if ($NetWeight == '1') {
					$table_columns = ["ConvTkt No", "ConvTkt Date", "Customer Name", "Job Site Address", "PO NO", "Product Description", "Driver Name", "Vehicle Reg No", "Price", "WaitTime", "Status", "NetWeight", "Total Price"];
				} else {
					$table_columns = ["ConvTkt No", "ConvTkt Date", "Customer Name", "Job Site Address", "PO NO", "Product Description", "Driver Name", "Vehicle Reg No", "Price", "WaitTime", "Status"];
				}

				$column = 0;
				foreach ($table_columns as $field) {
					$columnLetter = PHPExcel_Cell::stringFromColumnIndex($column);
					$object->getActiveSheet()->getColumnDimension($columnLetter)->setAutoSize(true);

					$object->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$object->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);

					$column++;
				}

				$object->getActiveSheet()->getStyle('g:g')->getNumberFormat()->setFormatCode('0.00');
				$excel_row = 2;

				// Filtering data for the current LorryType
				foreach ($filteredData as $row) {
					if ($row['LorryType'] == $typeId) { // Filter by LorryType
						$Price = 0;
						$NetWeight1 = 0;

						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['TicketNumber']);

						// Hyperlink for each ticket
						if ($row['DOCID'] != '' && $row['DOCID'] != null) {
							$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('http://193.117.210.98:8081/ticket/Delivery/' . $row['TicketNumber'] . '.pdf'));
						} else {
							if ($row['ReceiptName'] != "") {
								$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $row['ReceiptName']));
							}
						}

						// Set data
						$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['SiteOutDateTime']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['CompanyName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['OpportunityName']);
						$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['PurchaseOrderNo']);

						// Material info
						if ($row['MStatus'] == 1) {
							$MaterialText = $row['MaterialName'] . ' Delivered ' . $lorryType;
							$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
						} else {
							$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['MaterialName']);
						}
						// Driver Name (Column 6)
						$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['DriverName']);

						// Vehicle Reg No (Column 7)
						$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['VehicleRegNo']);

						if ($row['BookingMaterialID'] == $row['MaterialID']) {
							$Price = isset($row['Price']) ? (float) $row['Price'] : 0;
							//$Price = is_numeric($row['Price']) ? $row['Price'] : 0;
						} else {
							$Price = 0;
						}


						$object->getActiveSheet()->getStyle('H2:H' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
						//	$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $Price);
						$priceColumnIndex = array_search("Price", $table_columns);
						$object->getActiveSheet()->setCellValueByColumnAndRow($priceColumnIndex, $excel_row, $Price);

						// Wait Time
						$min = ($row['WaitTime'] == null) ? "N/A" : $row['WaitTime'] . " Min";
						$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $min);
						$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row['Status']);

						// Net Weight and Price Calculation
						if ($NetWeight == '1') {
							$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, round($row['Net'] / 1000, 2));
							$NetWeight1 = round((float) $row['Net'] / 1000, 2);
							$NPrice = round((float) $NetWeight1 * (float) $row['Price'], 2);
							$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $NPrice);
						}

						$excel_row++;
					} // End filtering by LorryType
				}

				for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
					$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
				}

				$FileName = $lorryType . "_" . date("Y-m-d-H:i") . ".xlsx";
				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).])", '', $FileName);
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
				$filePath = $xlsFolder . $FileName;
				$object_writer->save($filePath);
				$xlsFiles[] = $filePath;

			}

			// Now, create the zip file
			$this->load->library('zip');
			foreach ($xlsFiles as $xls) {
				$this->zip->read_file($xls);
			}

			// Generate a unique name for the zip file
			$zname = date("YmdHis") . "-" . rand() . ".zip";

			// Archive the zip file
			$this->zip->archive($xlsFolder . $zname);

			// Prepare the response
			$response = array(
				'op' => 'ok',
				'FileName' => "ConveyanceExcelExport/" . $zname,
				'file' => "data:application/zip;base64," . base64_encode(file_get_contents($xlsFolder . $zname))
			);

			// Send the response
			die(json_encode($response));
		}
	}



	function WaitTimeSplitExcelDelAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$CompanyName = $this->input->post('CompanyName');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation1 = $this->input->post('reservation1');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$TicketNumber = $this->input->post('TicketNumber');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');
			$Search = $this->input->post('Search');
			$PurchaseOrderNo = $this->input->post('PurchaseOrderNo');

			//$data['CompanyOppoRecords'] = $this->Booking_model->CompanyOppoRecordsAJAX(); 
			$data['CompanyOppoRecords'] = $this->Booking_model->SplitExcelDelOppoGroup($CompanyName, $OpportunityName, $reservation1, $SiteOutDateTime, $TicketNumber, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Price, $Search, $PurchaseOrderNo);

			$html = $this->load->view('Booking/WaitTimeSplitExcelDelAjax', $data, true);
			echo json_encode($html);

		}
	}

	function WaitTimeSplitExcelDelExport()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			$CompanyName = $this->input->post('CompanyName');
			$OpportunityID = $this->input->post('OpportunityID');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation1 = $this->input->post('reservation1');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$TicketNumber = $this->input->post('TicketNumber');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$WaitTime = $this->input->post('WaitTime');
			$Status = $this->input->post('Status');

			$Price = $this->input->post('Price');
			$Search = $this->input->post('Search');
			$PurchaseOrderNo = $this->input->post('PurchaseOrderNo');

			$data['SplitExcelDelTickets'] = $this->Booking_model->WaitTimeSplitExcelDelTickets($OpportunityID, $CompanyName, $OpportunityName, $reservation1, $SiteOutDateTime, $TicketNumber, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Price, $Search, $PurchaseOrderNo);

			if (count($data['SplitExcelDelTickets']) > 0) {
				$Array = array();
				$xx = 0;

				foreach ($data['SplitExcelDelTickets'] as $row) {
					if ($xx == 0) {
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}
					if ($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID']) {
					} else {
						$Array[] = $xx;
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if (count($data['SplitExcelDelTickets']) - 1 == $xx) {
						$xx++;
						$Array[] = $xx;
						break;
					} else {
						$xx++;
					}
				}
			}

			$this->load->library('zip');
			$this->load->library("excel");
			$xlsfiles = array();
			for ($j = 0; $j < count($Array); $j++) {
				$FileName = "";
				/* Header Start Excel  */
				$object = new PHPExcel();
				//print_r($_POST); die;
				$object->setActiveSheetIndex(0);

				$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Price per min", "Arrival Time", "Departure Time", "Total Minutes", "FOC Minutes", "Total Hrs Waiting Time", "Total Mins Waiting Time", "Net Charge");

				$column = 0;
				foreach ($table_columns as $field) {
					$object->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$object->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);

					$column++;
				}
				$object->getActiveSheet()->getStyle('g:g')->getNumberFormat()->setFormatCode('0.00');
				$excel_row = 2;
				/* Header End Excel  */

				/* Records Start  For Each  */
				if ($j == 0) {
					$newi = 0;
				} else {
					$newi = $Array[$j - 1];
				}
				$TLoad = 0;
				$TPrice = 0;
				$ALLTotalWaitTime = 0;
				$THours = 0;
				for ($i = $newi; $i < $Array[$j]; $i++) {
					$cname = "";
					$oname = "";
					$url = '';
					$Price = 0;

					$Price = 0;

					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelDelTickets'][$i]['TicketNumber']);

					if ($row['DOCID'] != '' && $row['DOCID'] != null) {
						$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('http://193.117.210.98:8081/ticket/Delivery/' . $data['SplitExcelDelTickets'][$i]['TicketNumber'] . '.pdf'));
					} else {
						if ($data['SplitExcelDelTickets'][$i]['ReceiptName'] != "") {
							$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $data['SplitExcelDelTickets'][$i]['ReceiptName']));
						}
					}

					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['SplitExcelDelTickets'][$i]['SiteOutDateTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $data['SplitExcelDelTickets'][$i]['CompanyName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $data['SplitExcelDelTickets'][$i]['OpportunityName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $data['SplitExcelDelTickets'][$i]['PurchaseOrderNo']);

					if ($data['SplitExcelDelTickets'][$i]['MStatus'] == 1) {
						$LT = '';
						if ($data['SplitExcelDelTickets'][$i]['LorryType'] == 1) {
							$LT = 'Tipper';
						} else if ($data['SplitExcelDelTickets'][$i]['LorryType'] == 2) {
							$LT = 'Grab';
						} else if ($data['SplitExcelDelTickets'][$i]['LorryType'] == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($data['SplitExcelDelTickets'][$i]['TonBook'] == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						$MaterialText = $data['SplitExcelDelTickets'][$i]['MaterialName'] . ' Delivered ' . $LT . ' ' . $TB;
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $data['SplitExcelDelTickets'][$i]['MaterialName']);
					}


					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $data['SplitExcelDelTickets'][$i]['WaitingCharge']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $data['SplitExcelDelTickets'][$i]['ArrivalTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $data['SplitExcelDelTickets'][$i]['DeptTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, round($data['SplitExcelDelTickets'][$i]['WaitTime']));
					$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $data['SplitExcelDelTickets'][$i]['WaitingTime']);

					$TotalWaitTime = round($data['SplitExcelDelTickets'][$i]['WaitTime'] - $data['SplitExcelDelTickets'][$i]['WaitingTime']);
					if ($TotalWaitTime > 0) {
						$Price = floor(($TotalWaitTime * $data['SplitExcelDelTickets'][$i]['WaitingCharge']) * 100) / 100;
						$ALLTotalWaitTime = round(($ALLTotalWaitTime + $TotalWaitTime));

					} else {
						$Price = 0;
					}
					//$TPrice = $TPrice + $Price;
					$TPrice = floor(($TPrice + $Price) * 100) / 100;


					if ($data['SplitExcelDelTickets'][$i]['WaitTime'] - $data['SplitExcelDelTickets'][$i]['WaitingTime'] > 0) {
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, round($TotalWaitTime / 60, 2));
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, round($TotalWaitTime));
						$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $Price);
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 0);
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 0);
						$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, 0);
					}
					$excel_row++;
					$cname = $data['SplitExcelDelTickets'][$i]['CompanyName'];
					$oname = $data['SplitExcelDelTickets'][$i]['OpportunityName'];
					$CompanyID = $data['SplitExcelDelTickets'][$i]['CompanyID'];
					$OpportunityID = $data['SplitExcelDelTickets'][$i]['OpportunityID'];
					$MaterialID = $data['SplitExcelDelTickets'][$i]['MaterialID'];
					$TLoad = $TLoad + 1;
				} /// For each 
				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Waiting Time - In Excess of FOC Minutes Per Load Count');
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, '');


				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				//$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Total Loads' );
				$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $ALLTotalWaitTime);

				$excel_row++;

				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				//$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 'Total Price' );
				$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $TPrice);


				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Total Chargeable Waiting Time Hours');


				/* Export Start Excel  */
				for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
					$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
				}

				$FileName = "WaitTimeDelivery_" . $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . ".xls";	// filename	

				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_~,;[](). 
				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).])", '', $FileName);
				// Remove any runs of periods (thanks falstro!)
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

				//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
				header('Content-Disposition: attachment;filename="' . $FileName . '"');
				//$object_writer->save('php://output'); 

				ob_start();
				$object_writer->save("SplitXLS/" . $FileName);
				$xlsfiles[] = $FileName;
				$xlsData = ob_get_contents();
				ob_end_clean();
				/* Export End Excel  */
			}

			//exit; 
			foreach ($xlsfiles as $xls) {
				$this->zip->read_file('SplitXLS/' . $xls);
			}
			$zname = "WaitTimeDelivery_" . date("YmdHis") . "-" . rand() . ".zip";
			$this->zip->archive("SplitXLS/" . $zname);
			$response = array(
				'op' => 'ok',
				'FileName' => "SplitXLS/" . $zname,
				'file' => "data:application/zip;base64," . $zname
			);
			die(json_encode($response));
		}
	}

	function WaitTimeSplitExcelDelExportAll()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			$CompanyName = $this->input->post('CompanyName');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation1 = $this->input->post('reservation1');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$TicketNumber = $this->input->post('TicketNumber');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$WaitTime = $this->input->post('WaitTime');

			$Price = $this->input->post('Price');
			$Search = $this->input->post('Search');
			$PurchaseOrderNo = $this->input->post('PurchaseOrderNo');

			$data['SplitExcelDelTickets'] = $this->Booking_model->WaitTimeSplitExcelDeliveryTicketsAll($CompanyName, $OpportunityName, $reservation1, $SiteOutDateTime, $TicketNumber, $MaterialName, $DriverName, $VehicleRegNo, $WaitTime, $Status, $Search, $Price, $PurchaseOrderNo);

			if (count($data['SplitExcelDelTickets']) > 0) {
				$Array = array();
				$xx = 0;

				foreach ($data['SplitExcelDelTickets'] as $row) {
					if ($xx == 0) {
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}
					if ($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID']) {
					} else {
						$Array[] = $xx;
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if (count($data['SplitExcelDelTickets']) - 1 == $xx) {
						$xx++;
						$Array[] = $xx;
						break;
					} else {
						$xx++;
					}
				}
			}

			$this->load->library('zip');
			$this->load->library("excel");
			$xlsfiles = array();
			for ($j = 0; $j < count($Array); $j++) {
				$FileName = "";
				/* Header Start Excel  */
				$object = new PHPExcel();
				//print_r($_POST); die;
				$object->setActiveSheetIndex(0);

				$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Price per min", "Arrival Time", "Departure Time", "Total Minutes", "FOC Minutes", "Total Hrs Waiting Time", "Total Mins Waiting Time", "Net Charge");

				$column = 0;
				foreach ($table_columns as $field) {
					$object->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$column++;
				}
				$object->getActiveSheet()->getStyle('g:g')->getNumberFormat()->setFormatCode('0.00');
				$excel_row = 2;
				/* Header End Excel  */

				/* Records Start  For Each  */
				if ($j == 0) {
					$newi = 0;
				} else {
					$newi = $Array[$j - 1];
				}
				$TLoad = 0;
				$TPrice = 0;
				$ALLTotalWaitTime = 0;
				$THours = 0;
				for ($i = $newi; $i < $Array[$j]; $i++) {
					$cname = "";
					$oname = "";
					$url = '';
					$Price = 0;

					$Price = 0;

					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelDelTickets'][$i]['TicketNumber']);

					if ($row['DOCID'] != '' && $row['DOCID'] != null) {
						$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('http://193.117.210.98:8081/ticket/Delivery/' . $data['SplitExcelDelTickets'][$i]['TicketNumber'] . '.pdf'));
					} else {
						if ($data['SplitExcelDelTickets'][$i]['ReceiptName'] != "") {
							$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $data['SplitExcelDelTickets'][$i]['ReceiptName']));
						}
					}

					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['SplitExcelDelTickets'][$i]['SiteOutDateTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $data['SplitExcelDelTickets'][$i]['CompanyName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $data['SplitExcelDelTickets'][$i]['OpportunityName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $data['SplitExcelDelTickets'][$i]['PurchaseOrderNo']);

					if ($data['SplitExcelDelTickets'][$i]['MStatus'] == 1) {
						$LT = '';
						if ($data['SplitExcelDelTickets'][$i]['LorryType'] == 1) {
							$LT = 'Tipper';
						} else if ($data['SplitExcelDelTickets'][$i]['LorryType'] == 2) {
							$LT = 'Grab';
						} else if ($data['SplitExcelDelTickets'][$i]['LorryType'] == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($data['SplitExcelDelTickets'][$i]['TonBook'] == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						$MaterialText = $data['SplitExcelDelTickets'][$i]['MaterialName'] . ' Delivered ' . $LT . ' ' . $TB;
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $data['SplitExcelDelTickets'][$i]['MaterialName']);
					}

					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $data['SplitExcelDelTickets'][$i]['WaitingCharge']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $data['SplitExcelDelTickets'][$i]['ArrivalTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $data['SplitExcelDelTickets'][$i]['DeptTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, round($data['SplitExcelDelTickets'][$i]['WaitTime']));
					$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $data['SplitExcelDelTickets'][$i]['WaitingTime']);

					$TotalWaitTime = round($data['SplitExcelDelTickets'][$i]['WaitTime'] - $data['SplitExcelDelTickets'][$i]['WaitingTime']);
					if ($TotalWaitTime > 0) {
						//$Price = round($TotalWaitTime * $data['SplitExcelDelTickets'][$i]['WaitingCharge'],2); 
						$Price = floor(($TotalWaitTime * $data['SplitExcelDelTickets'][$i]['WaitingCharge']) * 100) / 100;
						$ALLTotalWaitTime = round(($ALLTotalWaitTime + $TotalWaitTime));

					} else {
						$Price = 0;
					}
					$TPrice = floor(($TPrice + $Price) * 100) / 100;


					if ($data['SplitExcelDelTickets'][$i]['WaitTime'] - $data['SplitExcelDelTickets'][$i]['WaitingTime'] > 0) {
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, round($TotalWaitTime / 60, 2));
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, round($TotalWaitTime));
						$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $Price);
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 0);
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 0);
						$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, 0);
					}
					$excel_row++;
					$cname = $data['SplitExcelDelTickets'][$i]['CompanyName'];
					$oname = $data['SplitExcelDelTickets'][$i]['OpportunityName'];
					$CompanyID = $data['SplitExcelDelTickets'][$i]['CompanyID'];
					$OpportunityID = $data['SplitExcelDelTickets'][$i]['OpportunityID'];
					$MaterialID = $data['SplitExcelDelTickets'][$i]['MaterialID'];
					$TLoad = $TLoad + 1;
				} /// For each 
				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Waiting Time - In Excess of FOC Minutes Per Load Count');
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, '');


				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				//$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Total Loads' );
				$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $ALLTotalWaitTime);

				$excel_row++;

				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				//$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 'Total Price' );
				$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $TPrice);


				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Total Chargeable Waiting Time Hours');

				/* Export Start Excel  */
				for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
					$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
				}

				$FileName = "WaitTimeDelivery_" . $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . ".xls";	// filename	

				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_~,;[](). 
				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).])", '', $FileName);
				// Remove any runs of periods (thanks falstro!)
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

				//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
				header('Content-Disposition: attachment;filename="' . $FileName . '"');
				//$object_writer->save('php://output'); 

				ob_start();
				$object_writer->save("SplitXLS/" . $FileName);
				$xlsfiles[] = $FileName;
				$xlsData = ob_get_contents();
				ob_end_clean();
				/* Export End Excel  */
			}

			//exit; 
			foreach ($xlsfiles as $xls) {
				$this->zip->read_file('SplitXLS/' . $xls);
			}
			$zname = "WaitTimeDelivery_" . date("YmdHis") . "-" . rand() . ".zip";
			$this->zip->archive("SplitXLS/" . $zname);
			$response = array(
				'op' => 'ok',
				'FileName' => "SplitXLS/" . $zname,
				'file' => "data:application/zip;base64," . $zname
			);
			die(json_encode($response));
		}
	}


	function SplitExcelConvAjax1()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			//var_dump($_POST); 			
			$CompanyName = $this->input->post('CompanyName');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$TipName = $this->input->post('TipName');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');

			$data['SplitExcelConveyanceTickets'] = $this->Booking_model->SplitExcelConveyanceTickets($CompanyName, $OpportunityName, $reservation, $TipName, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $Status);
			//var_dump($data['SplitExcelConveyanceTickets']);
			$this->load->library("excel");
			foreach ($data['SplitExcelConveyanceTickets'] as $row) {

				//echo $row['OpportunityID']." == ".$row['OpportunityName'];
				//echo "<br>";

				$object = new PHPExcel();
				//print_r($_POST); die;
				$object->setActiveSheetIndex(0);

				$table_columns = array("Ticket Date", "Company Name", "Vechicle Reg No", "Driver Name", "Gross Weight", "Tare", "Net");

				$column = 0;

				foreach ($table_columns as $field) {
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$column++;
				}

				$excel_row = 2;

				foreach ($data['SplitExcelConveyanceTickets'] as $row) {
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['OpportunityID']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['OpportunityID']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['OpportunityID']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['OpportunityID']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['OpportunityID']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['OpportunityID']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['OpportunityID']);
					$excel_row++;
				}

				for ($i = 'A'; $i != $object->getActiveSheet()->getHighestColumn(); $i++) {
					$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
				}

				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="' . rand() . '.xls"');
				//$object_writer->save('php://output'); 

				ob_start();
				$object_writer->save("php://output");
				$objWriter->save(base_url("12121212.xls"));
				$xlsData = ob_get_contents();
				ob_end_clean();
				//exit;
				$response = array(
					'op' => 'ok',
					'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
				);

				die(json_encode($response));

			}

			//exit; 	


		}
	}
	function TipAddressUpdateAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			$data['TipID'] = $this->input->post('TipID');
			$data['OppoID'] = $this->input->post('OppoID');
			$data['ConveyanceNo'] = $this->input->post('ConveyanceNo');

			//$data['TipRecords'] = $this->Booking_model->TipListAJAX(); 
			$data['TipRecords'] = $this->Booking_model->TipListAuthoAJAX($data['OppoID']);
			$data['CheckTicketNumber'] = $this->Booking_model->CheckTicketNumber($data['ConveyanceNo'], $data['OppoID']);

			$html = $this->load->view('Booking/TipAddressUpdateAjax', $data, true);
			echo json_encode($html);

		}
	}
	function TipAddressUpdateNonAppAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			$data['TipID'] = $this->input->post('TipID');

			$data['TipRecords'] = $this->Booking_model->TipListAJAX();

			$html = $this->load->view('Booking/TipAddressUpdateNonAppAjax', $data, true);
			echo json_encode($html);

		}
	}
	function TipAddressUpdate($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('ConveyanceTickets');
			}
			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$TipID = $this->input->post('TipID1');
				$LoadID = $this->input->post('LoadID');
				$GrossWeight = $this->input->post('GrossWeight');
				$TipTicketDatetime = $this->input->post('TipTicketDatetime');
				$TicketNumber = $this->input->post('TicketNumber');
				$TicketNo = $this->input->post('TicketNo');

				if ($TipTicketDatetime != "") {
					$T1 = explode(' ', $TipTicketDatetime);
					$T2 = explode('/', $T1[0]);
					$TipTicketDatetime = trim($T2[2]) . "-" . trim($T2[1]) . "-" . trim($T2[0]) . " " . $T1[1];
				}

				if ($TipID == null) {
					$this->session->set_flashdata('success', 'Tip Address Should Not Be Blank.');
					redirect('ConveyanceTickets');
				}
				if ($TipID == '1') {
					if ($TicketNumber == '') {
						if ($GrossWeight == '0' || $GrossWeight == '' || $TipTicketDatetime == "") {
							$this->session->set_flashdata('success', 'Gross Weight And TipTicketDatetime Should not be blank. ');
							redirect('ConveyanceTickets');
						}
					}
				}

				
				// ===== Fetch OLD TipID and TipName =====
					$oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
					$oldTipID = $oldData ? $oldData->TipID : null;
					$oldTipName = null;
					if ($oldTipID) {
						$tipRow = $this->db->get_where('tbl_tipaddress', ['TipID' => $oldTipID])->row();
						$oldTipName = $tipRow ? $tipRow->TipName : null;
					}

				if ($TicketNumber > 0 && $TicketNumber != '') {
					$LoadInfo = array('TipID' => $TipID, 'TicketID' => $TicketNo);
				} else {
					$LoadInfo = array('TipID' => $TipID);
				}
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				// ===== Fetch NEW TipID and TipName from updated record =====
				$newData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
				$newTipID = $newData ? $newData->TipID : null;
				$newTipName = null;
				if ($newTipID) {
					$tipRowNew = $this->db->get_where('tbl_tipaddress', ['TipID' => $newTipID])->row();
					$newTipName = $tipRowNew ? $tipRowNew->TipName : null;
				}
				if ($update) {
					/* =================== Site Logs ===================  */
					 $oldValue = json_encode(['TipID' => $oldTipID, 'TipName' => $oldTipName]);
    				$newValue = json_encode(['TipID' => $newTipID, 'TipName' => $newTipName]);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'UpdatedValue'=> $newValue,
        				'OldValue' => $oldValue,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'conveyance tip update',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					/* ===================================== */

					$conditions = array('LoadID ' => $LoadID);
					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

					if ($TipID == 1) {
						if ($TicketNumber > 0 && $TicketNumber != '') {
							$TInfo = array('LoadID' => $LoadID);
							$TCond = array('TicketNo' => $TicketNo);
							$this->Common_model->update("tbl_tickets", $TInfo, $TCond);

							/* =================== Site Logs ===================  */
							$TInfoJson = json_encode($TInfo);
							$TCondJson = json_encode($TCond);

							$SiteLogInfo = array(
								'TableName' => 'tbl_tickets',
								'PrimaryID' => $TicketNo,
								'UpdatedValue' => $TInfoJson . " => " . $TCond,
								'UpdatedByUserID' => $this->session->userdata['userId'],
								'SitePage' => 'conveyance tip update',
								'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
								'BrowserAgent' => getBrowserAgent(),
								'AgentString' => $this->agent->agent_string(),
								'UserPlatform' => $this->agent->platform()
							);
							$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
							/* ===================================== */

						} else {

							$TicketUniqueID = $this->generateRandomString();
							$LastTicketNumber = $this->tickets_model->LastTicketNo();
							if ($LastTicketNumber) {
								$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
							}
							$Net = $GrossWeight - $data['LoadInfo']->lorry_tare;
							//echo "<br>";
							//echo $GrossWeight;
							//echo "<br>";
							//echo $data['LoadInfo']->lorry_tare;
							if ($data['LoadInfo']->LorryType == "0" || $data['LoadInfo']->LorryType == "") {
								$LorryType = '1';
							}
							$ticketsInfo = array(
								'LoadID' => $LoadID,
								'TicketUniqueID' => $TicketUniqueID,
								'TicketNumber' => $TicketNumber,
								'TicketDate' => $TipTicketDatetime,
								'OpportunityID' => $data['LoadInfo']->OpportunityID,
								'Conveyance' => $data['LoadInfo']->ConveyanceNo,
								'CompanyID' => $data['LoadInfo']->CompanyID,
								'DriverName' => $data['LoadInfo']->DriverName,
								'RegNumber' => $data['LoadInfo']->VehicleRegNo,
								'Hulller' => $data['LoadInfo']->Haulier,
								'MaterialID' => $data['LoadInfo']->MaterialID,
								'GrossWeight' => $GrossWeight,
								'Tare' => $data['LoadInfo']->lorry_tare,
								'Net' => $Net,
								'SicCode' => $data['LoadInfo']->Haulier,
								'CreateUserID' => $this->session->userdata['userId'],
								'CreateDate' => date('Y-m-d H:i:s'),
								'TypeOfTicket' => 'In',
								'pdf_name' => $TicketUniqueID . ".pdf",
								'driver_id' => $data['LoadInfo']->DriverID,
								'is_tml' => $is_tml,
								'driversignature' => $data['LoadInfo']->dsignature
							);
							$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);

							/* =================== Site Logs ===================  */
							$TInfoJson = json_encode($ticketsInfo);

							$SiteLogInfo = array(
								'TableName' => 'tbl_tickets',
								'PrimaryID' => $TicketID,
								'UpdatedValue' => $TInfoJson,
								'UpdatedByUserID' => $this->session->userdata['userId'],
								'SitePage' => 'conveyance tip update',
								'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
								'BrowserAgent' => getBrowserAgent(),
								'AgentString' => $this->agent->agent_string(),
								'UserPlatform' => $this->agent->platform()
							);
							$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
							/* ===================================== */

							//exit;
							$LI = array('TicketID' => $TicketID);
							$co = array('LoadID ' => $LoadID);
							$up = $this->Common_model->update("tbl_booking_loads1", $LI, $co);

							/* =================== Site Logs ===================  */
							$LIJson = json_encode($LI);
							$coJson = json_encode($co);

							$SiteLogInfo = array(
								'TableName' => 'tbl_booking_loads1',
								'PrimaryID' => $LoadID,
								'UpdatedValue' => $LIJson . " => " . $coJson,
								'UpdatedByUserID' => $this->session->userdata['userId'],
								'SitePage' => 'conveyance date update',
								'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
								'BrowserAgent' => getBrowserAgent(),
								'AgentString' => $this->agent->agent_string(),
								'UserPlatform' => $this->agent->platform()
							);
							$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
							/* ===================================== */

							$data1['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
							$data1['tickets'] = $this->Common_model->get_pdf_data1($TicketID);

							$html = $this->load->view('Tickets/ticket_pdf', $data1, true);
							//this the the PDF filename that user will get to download
							$pdfFilePath = WEB_ROOT_PATH . "assets/pdf_file/" . $TicketUniqueID . ".pdf";
							$openPath = "/assets/pdf_file/" . $TicketUniqueID . ".pdf";

							//load mPDF library
							$this->load->library('m_pdf');

							//generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html);

							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F");

						}
					} else {
						$ticketsInfo = array('delete_notes' => 'Deleted via Conveyance Tip Update');
						$Del_Where = array('TicketNo' => $data['LoadInfo']->TicketID);
						//$this->Common_model->delete("tbl_tickets",$Del_Where);
						$this->Common_model->update("tbl_tickets", $ticketsInfo, $Del_Where);

						$LI = array('TicketID' => '', 'TicketUniqueID' => '');
						$co = array('LoadID ' => $LoadID);
						$up = $this->Common_model->update("tbl_booking_loads1", $LI, $co);

						/* =================== Site Logs ===================  */
						$LIJson = json_encode($LI);
						$coJson = json_encode($co);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_loads1',
							'PrimaryID' => $LoadID,
							'UpdatedValue' => $LIJson . " => " . $coJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'conveyance date update',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ===================================== */

					}

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data['LoadInfo']->TonBook == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
					$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';

					$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;

					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
					<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
						<div style="width:100%; " >
							<div style="width:35%;float: left;" > 		
								<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
							</div>
							<div style="width:65%;float: right;text-align: right;" > 		 
								<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
								' . $PDFContent[0]->address . ' <br/> 
								<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
							</div>
						</div>	
						<div style="width:100%;float: left;" >   
							<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
							<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
							<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> <hr>
							<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
							<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
							<div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
							<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
							<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
							' . $siteInDateTime . '
							' . $siteOutDateTime . '
							<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
							<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
							<b>Tip Address: </b> ' . $data['LoadInfo']->TipName . ',' . $data['LoadInfo']->Street1 . ',' . $data['LoadInfo']->Street2 . ',
							' . $data['LoadInfo']->Town . ',' . $data['LoadInfo']->County . ',' . $data['LoadInfo']->PostCode . '<br>	 
							<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/>							
							<b>Material: </b> ' . $MaterialText . '  <br> 
							<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
							<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
							<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
						</div>
						<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName . '<br><br>
							<div style="font-size: 9px;"> 
								<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
								<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
								' . $PDFContent[0]->FooterText . '  
							</div>
						</div>  
					</div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data['LoadInfo']->ReceiptName;
					$mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					/* =================== Site Logs ===================  */
					$OldFile = $pdfFilePath;
					$NewFileName = date('YmdHis') . ".pdf";
					$NewFile = WEB_ROOT_PATH . "/assets/conveyance/" . $NewFileName;

					copy($OldFile, $NewFile);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'FileName' => $NewFileName,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'conveyance date update',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					/* ===================================== */

					$this->session->set_flashdata('success', 'Tip Address has been updated successfully');

					redirect('ConveyanceTickets');

				} else {
					redirect('ConveyanceTickets');
				}
			}

		}
	}

	function TipAddressUpdateNonApp($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$TipID = $this->input->post('TipID1');
				$LoadID = $this->input->post('LoadID');

				$LoadInfo = array('TipID' => $TipID);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				if ($update) {
					$this->session->set_flashdata('success', 'Tip Address has been updated successfully');
					redirect('NonAppConveyanceTickets');
				} else {
					redirect('NonAppConveyanceTickets');
				}
			}

		}
	}

	function AJAXUpdateBookingPrice()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingRequestID = $this->input->post('BookingRequestID');
			$Loads = $this->input->post('Loads');
			$BookingID = $this->input->post('BookingID');
			$BookingDateID = $this->input->post('BookingDateID');
			$Price = $this->input->post('Price');

			$BookingInfo = array('Price' => $Price, 'TotalAmount' => $Price * $Loads);
			$Cond1 = array('BookingID' => $BookingID);
			$result = $this->Common_model->update("tbl_booking1", $BookingInfo, $Cond1);

			/* ========================================================================= */
			$LoadInfoJson = json_encode($BookingInfo);
			$condJson = json_encode($Cond1);

			$SiteLogInfo = array(
				'TableName' => 'tbl_booking1',
				'PrimaryID' => $BookingID,
				'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
				'UpdatedByUserID' => $this->session->userdata['userId'],
				'SitePage' => 'Update Price Grid ',
				'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
				'BrowserAgent' => getBrowserAgent(),
				'AgentString' => $this->agent->agent_string(),
				'UserPlatform' => $this->agent->platform()
			);
			$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
			/* ========================================================================= */

			$SubTotal = $this->Common_model->GetBookingPriceTotal($BookingRequestID);
			//$SubTotal[0]->TotalAmount; 
			$VAT = (($SubTotal[0]->TotalAmount * 20) / 100);
			$Total = $SubTotal[0]->TotalAmount + $VAT;

			$BRInfo = array('SubTotalAmount' => $SubTotal[0]->TotalAmount, 'VatAmount' => $VAT, 'TotalAmount' => $Total);
			$CondR = array('BookingRequestID' => $BookingRequestID);
			$resultR = $this->Common_model->update("tbl_booking_request", $BRInfo, $CondR);

			/* ========================================================================= */
			$LoadInfoJson = json_encode($BRInfo);
			$condJson = json_encode($CondR);

			$SiteLogInfo = array(
				'TableName' => 'tbl_booking_request',
				'PrimaryID' => $BookingRequestID,
				'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
				'UpdatedByUserID' => $this->session->userdata['userId'],
				'SitePage' => 'Update Price Grid',
				'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
				'BrowserAgent' => getBrowserAgent(),
				'AgentString' => $this->agent->agent_string(),
				'UserPlatform' => $this->agent->platform()
			);
			$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
			/* ========================================================================= */


			$BInfo = array('LoadPrice' => $Price);
			$Cnd = array('BookingID' => $BookingID);
			$Res = $this->Common_model->update("tbl_booking_loads1", $BInfo, $Cnd);

			/* ========================================================================= */
			$LoadInfoJson = json_encode($BInfo);
			$condJson = json_encode($Cnd);

			$SiteLogInfo = array(
				'TableName' => 'tbl_booking_loads1',
				'PrimaryID' => $BookingID,
				'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
				'UpdatedByUserID' => $this->session->userdata['userId'],
				'SitePage' => 'Update Price Grid',
				'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
				'BrowserAgent' => getBrowserAgent(),
				'AgentString' => $this->agent->agent_string(),
				'UserPlatform' => $this->agent->platform()
			);
			$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
			/* ========================================================================= */


			//$CountBookingDateID = $this->Booking_model->CountBookingDateID($BookingDateID);  
			$CountProductBookingID = $this->Booking_model->CountProductBookingID($BookingID);
			//echo $CountProductBookingID->CNT;
			//var_dump($CountProductBookingID);
			//exit; 
			if ($CountProductBookingID->CNT == 0) {
				$BookingReqInfo = $this->Booking_model->GetBookingIDRequestInfo($BookingID);
				//var_dump($BookingReqInfo);	
				//exit;				
				$ProductInfo = array(
					'OpportunityID' => $BookingReqInfo[0]->OpportunityID,
					'MaterialID' => $BookingReqInfo[0]->MaterialID,
					'BookingDateID' => $BookingReqInfo[0]->BookingDateID,
					'BookingID' => $BookingID,
					'PurchaseOrderNo' => $BookingReqInfo[0]->PurchaseOrderNo,
					'Qty' => $BookingReqInfo[0]->Loads,
					'DateRequired' => $BookingReqInfo[0]->BookingDate,
					'UnitPrice' => $Price,
					'LorryType' => $BookingReqInfo[0]->LorryType,
					'CreateUserID' => $this->session->userdata['userId'],
					'EditUserID' => $this->session->userdata['userId']
				);
				$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

				/* ========================================================================= */
				$LoadInfoJson = json_encode($ProductInfo);

				$SiteLogInfo = array(
					'TableName' => 'tbl_product',
					'PrimaryID' => $PID,
					'UpdatedValue' => $LoadInfoJson,
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'Update Price Grid',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
				/* ========================================================================= */

				$LogInfo = array('BookingID' => $BookingID, 'PriceTo' => $Price, 'UpdatedBy' => $this->session->userdata['userId']);
				$this->Common_model->insert("tbl_booking_priceby_logs", $LogInfo);


			} else {
				$BookingInfo1 = array('UnitPrice' => $Price);
				$Cond2 = array('BookingID' => $BookingID);
				$PID = $this->Common_model->update("tbl_product", $BookingInfo1, $Cond2);

				/* ========================================================================= */
				$LoadInfoJson = json_encode($BookingInfo1);
				$condJson = json_encode($Cond2);

				$SiteLogInfo = array(
					'TableName' => 'tbl_product',
					'PrimaryID' => $BookingID,
					'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'Update Price Grid',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
				/* ========================================================================= */

			}

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE, 'BookingID' => $BookingID)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}

	function AJAXUpdatePON()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingID = $this->input->post('BookingID');
			$PON = $this->input->post('PON');

			//$BookingInfo = array('PurchaseOrderNumber'=>$PON ); 
			//$Cond1 = array( 'BookingRequestID' => $BookingRequestID  );  
			//$result = $this->Common_model->update("tbl_booking_request", $BookingInfo, $Cond1);

			$BookingInfo = array('PurchaseOrderNo' => $PON);
			$Cond1 = array('BookingID' => $BookingID);
			$result = $this->Common_model->update("tbl_booking1", $BookingInfo, $Cond1);

			$LoadInfoJson = json_encode($BookingInfo);
			$condJson = json_encode($Cond1);

			$SiteLogInfo = array(
				'TableName' => 'tbl_booking1',
				'PrimaryID' => $BookingID,
				'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
				'UpdatedByUserID' => $this->session->userdata['userId'],
				'SitePage' => 'Update Purchase Order Number',
				'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
				'BrowserAgent' => getBrowserAgent(),
				'AgentString' => $this->agent->agent_string(),
				'UserPlatform' => $this->agent->platform()
			);
			$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);


			/*$BDID = $this->Common_model->GetBookingDateIDs($BookingRequestID);   
												$BDIDs = array();
												foreach ($BDID as $item) {
													$BDIDs[] = $item->BookingDateID; 
												} 
												$BD = implode(',', $BDIDs); 
												//var_dump($BDIDs);
												//exit;
												$BDIDs = $this->Common_model->UpdatePON($PON, $BD);   
												*/
			$BookingInfo1 = array('PurchaseOrderNo' => $PON);
			$Cond2 = array('BookingID' => $BookingID);
			$result1 = $this->Common_model->update("tbl_product", $BookingInfo1, $Cond2);

			$LoadInfoJson = json_encode($BookingInfo1);
			$condJson = json_encode($Cond2);

			$SiteLogInfo = array(
				'TableName' => 'tbl_product',
				'PrimaryID' => $BookingID,
				'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
				'UpdatedByUserID' => $this->session->userdata['userId'],
				'SitePage' => 'Update Purchase Order Number',
				'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
				'BrowserAgent' => getBrowserAgent(),
				'AgentString' => $this->agent->agent_string(),
				'UserPlatform' => $this->agent->platform()
			);
			$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE, 'BookingID' => $BookingID)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}
	function AJAXUpdateOpenPO()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingID = $this->input->post('BookingID');
			$OpenPO = $this->input->post('OpenPO');

			$BookingInfo = array('OpenPO' => $OpenPO);
			$Cond1 = array('BookingID' => $BookingID);
			$result = $this->Common_model->update("tbl_booking1", $BookingInfo, $Cond1);

			//exit;
			$LoadInfoJson = json_encode($BookingInfo);
			$condJson = json_encode($Cond1);

			$SiteLogInfo = array(
				'TableName' => 'tbl_booking1',
				'PrimaryID' => $BookingID,
				'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
				'UpdatedByUserID' => $this->session->userdata['userId'],
				'SitePage' => 'Update OpenPO ',
				'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
				'BrowserAgent' => getBrowserAgent(),
				'AgentString' => $this->agent->agent_string(),
				'UserPlatform' => $this->agent->platform()
			);
			$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);

			if ($result) {
				echo (json_encode(array('status' => TRUE, 'BookingID' => $BookingID)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}
	function MaterialUpdateAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			$data['MaterialID'] = $this->input->post('MaterialID');

			$data['MaterialRecords'] = $this->Booking_model->MaterialListAJAX();

			$html = $this->load->view('Booking/MaterialUpdateAjax', $data, true);
			echo json_encode($html);

		}
	}

	function MaterialUpdateDeliveryAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			$data['MaterialID'] = $this->input->post('MaterialID');
			$data['TicketNo'] = $this->input->post('TicketNo');

			$data['MaterialRecords'] = $this->Booking_model->MaterialListAJAX1();

			$html = $this->load->view('Booking/MaterialUpdateDeliveryAjax', $data, true);
			echo json_encode($html);

		}
	}

	function MaterialUpdateNonAppAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			$data['MaterialID'] = $this->input->post('MaterialID');

			$data['MaterialRecords'] = $this->Booking_model->MaterialListAJAX();

			$html = $this->load->view('Booking/MaterialUpdateNonAppAjax', $data, true);
			echo json_encode($html);

		}
	}

	function MaterialUpdate($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {


				$MaterialID = $this->input->post('MaterialID1');
				$LoadID = $this->input->post('LoadID');
				//exit;
				$oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
				$OldMaterialName = null;
				if ($oldData) {
					// Fetch material name from tbl_materials using OLD materialID
					if (!empty($oldData->MaterialID)) {
						$materialRow = $this->db->get_where('tbl_materials', ['MaterialID' => $oldData->MaterialID])->row();
						$OldMaterialName = $materialRow ? $materialRow->MaterialName : '(Unknown Material)';
					}
				}
				$LoadInfo = array('MaterialID' => $MaterialID , 'LoadPrice' => 0);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				if ($update) {

					// =================== Site Logs ===================   
					$LoadInfoJson = json_encode($LoadInfo);
					$condJson = json_encode($cond);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
						'OldValue' => json_encode(['MaterialName' => $OldMaterialName], JSON_UNESCAPED_UNICODE),
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'conveyance material update',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					///* ===================================== 

					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

					$data['MaterialPrice'] = $this->Booking_model->FetchSameBookingMaterialPrice($data['LoadInfo']->BookingRequestID, $MaterialID);

					//var_dump($data['MaterialPrice']);
					//echo $data['MaterialPrice']['Price'];
					//exit;
					if ($data['MaterialPrice']['Price']) {
						$PPrice = $data['MaterialPrice']['Price'];

					} else {
						$data['DateRequired'] = $this->Booking_model->FetchBookingDate($data['LoadInfo']->BookingID);
						$ProductPrice = $this->Booking_model->GetOppoMaterialListDetails($data['LoadInfo']->OpportunityID, $MaterialID, $data['DateRequired']['BookingDate'], $data['LoadInfo']->LorryType);

						//print_r($ProductPrice);
						if ($ProductPrice[0]->UnitPrice) {
							$PPrice = $ProductPrice[0]->UnitPrice;
						} else {
							$PPrice = 0;
						}
					}
					$PInfo = array('LoadPrice' => $PPrice);
					$PCond = array('LoadID ' => $LoadID);
					$PUpdate = $this->Common_model->update("tbl_booking_loads1", $PInfo, $PCond);
					if ($PUpdate) {
						// =================== Site Logs ===================   
						$PInfoJson = json_encode($PInfo);
						$PCondJson = json_encode($PCond);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_loads1',
							'PrimaryID' => $LoadID,
							'UpdatedValue' => $PInfoJson . " => " . $PCondJson,
							'OldValue' => json_encode(['MaterialName' => $OldMaterialName], JSON_UNESCAPED_UNICODE),
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'conveyance material price update',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						// ===================================== /
					}

					//$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);  

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}
					$TB = '';
					if ($data['LoadInfo']->TonBook == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}
					$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
					$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';
					$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;
					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
					<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
						<div style="width:100%; " >
							<div style="width:35%;float: left;" > 		
								<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
							</div>
							<div style="width:65%;float: right;text-align: right;" > 		 
								<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
								' . $PDFContent[0]->address . ' <br/> 
								<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
							</div>
						</div>	
						<div style="width:100%;float: left;" >   
							<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
							<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
							<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> <hr>
							<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
							<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
							<div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
							<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
							<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
							' . $siteInDateTime . '
							' . $siteOutDateTime . '
							<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
							<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
							<b>Tip Address: </b> ' . $data['LoadInfo']->TipName . ',' . $data['LoadInfo']->Street1 . ',' . $data['LoadInfo']->Street2 . ',
							' . $data['LoadInfo']->Town . ',' . $data['LoadInfo']->County . ',' . $data['LoadInfo']->PostCode . '<br>	 
							<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/>							
							<b>Material: </b> ' . $MaterialText . '  <br> 
							<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
							<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
							<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
						</div>
						<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName . '<br><br>
							<div style="font-size: 9px;"> 
								<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
								<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
								' . $PDFContent[0]->FooterText . '  
							</div>
						</div>  
					</div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data['LoadInfo']->ReceiptName;
					$mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					$this->session->set_flashdata('success', 'Material has been updated successfully');

					///* =================== Site Logs ===================   
					$OldFile = $pdfFilePath;
					$NewFileName = date('YmdHis') . ".pdf";
					$NewFile = WEB_ROOT_PATH . "/assets/conveyance/" . $NewFileName;

					copy($OldFile, $NewFile);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'FileName' => $NewFileName,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'conveyance material update pdf',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					// =====================================  

					$TicketID = $data['LoadInfo']->TicketID;

					$tInfo1 = array('MaterialID' => $MaterialID);
					$tcond1 = array('TicketNo' => $TicketID);
					$this->Common_model->update("tbl_tickets", $tInfo1, $tcond1);
					sleep(1); // optional

					$this->db->reset_query(); // optional cleanup
					$data1['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
					$data1['tickets'] = $this->Common_model->get_pdf_data1($TicketID);

					$TicketUniqueID = $data1['tickets']['TicketUniqueID'];

					$html = $this->load->view('Tickets/ticket_pdf', $data1, true);
					//this the the PDF filename that user will get to download
					$pdfFilePath = WEB_ROOT_PATH . "assets/pdf_file/" . $TicketUniqueID . ".pdf";
					$openPath = "/assets/pdf_file/" . $TicketUniqueID . ".pdf";

					//load mPDF library
					$this->load->library('m_pdf');

					//generate the PDF from the given html
					$this->m_pdf->pdf->WriteHTML($html);

					//download it.
					$this->m_pdf->pdf->Output($pdfFilePath, "F");


					redirect('ConveyanceTickets');

				} else {
					redirect('ConveyanceTickets');
				}
			}

		}
	}
	function MaterialUpdateDelivery($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {


				$MaterialID = $this->input->post('MaterialID1');
				$LoadID = $this->input->post('LoadID');
				$TicketNo = $this->input->post('TicketNo');
				//exit;
				$oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
				$OldMaterialName = null;
				if ($oldData) {
					// Fetch material name from tbl_materials using OLD materialID
					if (!empty($oldData->MaterialID)) {
						$materialRow = $this->db->get_where('tbl_materials', ['MaterialID' => $oldData->MaterialID])->row();
						$OldMaterialName = $materialRow ? $materialRow->MaterialName : '(Unknown Material)';
					}
				}

				$TInfo = array('MaterialID' => $MaterialID);
				$Tcond = array('LoadID ' => $LoadID);
				$update1 = $this->Common_model->update("tbl_tickets", $TInfo, $Tcond);

				/* =================== Site Logs ===================  */
				$TInfoJson = json_encode($TInfo);
				$TcondJson = json_encode($Tcond);

				$SiteLogInfo = array(
					'TableName' => 'tbl_tickets',
					'PrimaryID' => TicketNo,
					'UpdatedValue' => $TInfoJson . " => " . $TcondJson,
					'OldValue' => json_encode(['MaterialName' => $OldMaterialName], JSON_UNESCAPED_UNICODE),
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'delivery material update',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
				/* ===================================== */

				$LoadInfo = array('MaterialID' => $MaterialID, 'LoadPrice' => 0);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				/* =================== Site Logs ===================  */
				$LoadInfoJson = json_encode($LoadInfo);
				$condJson = json_encode($cond);

				$SiteLogInfo = array(
					'TableName' => 'tbl_booking_loads1',
					'PrimaryID' => $LoadID,
					'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
					'OldValue' => json_encode(['MaterialName' => $OldMaterialName], JSON_UNESCAPED_UNICODE),
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'delivery material update',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
				/* ===================================== */

				if ($update) {


					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

					$data['MaterialPrice'] = $this->Booking_model->FetchSameBookingMaterialPrice($data['LoadInfo']->BookingRequestID, $MaterialID);

					//var_dump($data['MaterialPrice']);
					//echo $data['MaterialPrice']['Price'];
					//exit;
					if ($data['MaterialPrice']['Price']) {
						$PPrice = $data['MaterialPrice']['Price'];

					} else {
						$data['DateRequired'] = $this->Booking_model->FetchBookingDate($data['LoadInfo']->BookingID);
						$ProductPrice = $this->Booking_model->GetOppoMaterialListDetails($data['LoadInfo']->OpportunityID, $MaterialID, $data['DateRequired']['BookingDate'], $data['LoadInfo']->LorryType);

						//print_r($ProductPrice);
						if ($ProductPrice[0]->UnitPrice) {
							$PPrice = $ProductPrice[0]->UnitPrice;
						} else {
							$PPrice = 0;
						}
					}
					$PInfo = array('LoadPrice' => $PPrice);
					$PCond = array('LoadID ' => $LoadID);
					$PUpdate = $this->Common_model->update("tbl_booking_loads1", $PInfo, $PCond);
					if ($PUpdate) {
						// =================== Site Logs ===================   
						$PInfoJson = json_encode($PInfo);
						$PCondJson = json_encode($PCond);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_loads1',
							'PrimaryID' => $LoadID,
							'UpdatedValue' => $PInfoJson . " => " . $PCondJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'delivery material price update',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						// ===================================== /
					}


					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();

					$data1['tickets'] = $this->Booking_model->BookingTicketInfo($TicketNo);

					$tInfo = array('ReceiptName' => $data1['tickets']['TicketUniqueID'] . ".pdf");
					$tcond = array('LoadID' => $LoadID);
					$this->Common_model->update("tbl_booking_loads1", $tInfo, $tcond);

					$tInfo1 = array('pdf_name' => $data1['tickets']['TicketUniqueID'] . ".pdf");
					$tcond1 = array('TicketNo' => $TicketNo);
					$this->Common_model->update("tbl_tickets", $tInfo1, $tcond1);
					$LT = '';
					if ($data1['tickets']['LorryType'] == 1) {
						$LT = 'Tipper';
					} else if ($data1['tickets']['LorryType'] == 2) {
						$LT = 'Grab';
					} else if ($data1['tickets']['LorryType'] == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data1['tickets']['TonBook'] == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$MaterialText = $data1['tickets']['MaterialName'] . ' Delivered ' . $LT . ' ' . $TB;


					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
							<div style="width:100%;float: left;" >    
								<b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
								<b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
								<b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
								<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
								<b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>		 
								<b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>		   
								<b>In Time: </b> ' . $data1['tickets']['SiteIn'] . ' <br>		   
								<b>Out Time: </b> ' . $data1['tickets']['SiteOut'] . ' <br>		   
								<b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
								<b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
								<b>Driver Name: </b> ' . $data1['tickets']['DriverName'] . '<br> 
								<b>Driver Signature: </b> <br> 
								<div><img src="/assets/DriverSignature/' . $data1['tickets']['dsignature'] . '" width ="100" height="40" style="float:left"> </div>
								<b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
								<b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
								<b>Tip Address: </b> ' . $data1['tickets']['TipName'] . ', ' . $data1['tickets']['Street1'] . ', ' . $data1['tickets']['Street2'] . ', ' . $data1['tickets']['Town'] . ', ' . $data1['tickets']['County'] . ', ' . $data1['tickets']['PostCode'] . ',								<br>	 
								<b>Waste License No:  </b>' . $data1['tickets']['PermitRefNo'] . ' <br> 
								<b>Material:  ' . $MaterialText . ' <br></b> 
								<b>SIC Code: </b> ' . $data1['tickets']['LoadSICCODE'] . ' <br> 
								<b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>		 
								<b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
								<b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
								<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
							<div style="width:100%;float: left;" > 
								<b>Received By: </b><br> 
								<div><img src="/uploads/Signature/' . $data1['tickets']['Signature'] . '" width ="100" height="40" style="float:left"></div> 
								' . $data1['tickets']['CustomerName'] . ' 
								<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data1['tickets']['TicketUniqueID'] . ".pdf";
					$mpdf = new mPDF('utf-8', array(70, 220), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					/* =================== Site Logs ===================  */
					$OldFile = $pdfFilePath;
					$NewFileName = date('YmdHis') . ".pdf";
					$NewFile = WEB_ROOT_PATH . "/assets/conveyance/" . $NewFileName;

					copy($OldFile, $NewFile);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'FileName' => $NewFileName,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'delivery material update pdf',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					/* ===================================== */

					$this->session->set_flashdata('success', 'Material has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Please Try Again Later');
				}
				redirect('DeliveryTickets');
			}

		}
	}
	function MaterialUpdateNonApp($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$MaterialID = $this->input->post('MaterialID1');
				$LoadID = $this->input->post('LoadID');

				$LoadInfo = array('MaterialID' => $MaterialID);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				if ($update) {
					$this->session->set_flashdata('success', 'Material has been updated successfully');
					redirect('NonAppConveyanceTickets');
				} else {
					redirect('NonAppConveyanceTickets');
				}
			}
		}
	}
	function StatusUpdateAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			$data['Status'] = $this->input->post('Status');
			$data['PDF'] = $this->input->post('PDF');

			$html = $this->load->view('Booking/StatusUpdateAjax', $data, true);
			echo json_encode($html);
		}
	}

	function StatusUpdate($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$Status = $this->input->post('Status');
				$LoadID = $this->input->post('LoadID');

				 $oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
	            $oldStatus = $oldData ? $oldData->Status : null;

				$LoadInfo = array('Status' => $Status);
				$cond = array('LoadID' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				 // Map status numbers to names
            $statusNames = [
                4 => 'Complete',
                5 => 'Cancel',
                6 => 'Waste Journey',
                7 => 'Invoice Cancel',
                8 => 'Invoice Cancel'
            ];
            $oldStatusName = isset($statusNames[$oldStatus]) ? $statusNames[$oldStatus] : 'Unknown';
            $newStatusName = isset($statusNames[$Status]) ? $statusNames[$Status] : 'Unknown';

				/* =================== Site Logs ===================  */
				$LoadInfoJson = json_encode($LoadInfo);
				$condJson = json_encode($cond);
				

				$SiteLogInfo = array(
					'TableName' => 'tbl_booking_loads1',
					'PrimaryID' => $LoadID,
					'UpdatedValue' => json_encode(['Status' => $newStatusName]) . " => " . json_encode($cond),
                	'OldValue' => json_encode(['Status' => $oldStatusName]),
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'conveyance status update',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
				/* ===================================== */

				if ($update) {
					if ($Status == 4) {
						$conditions = array('LoadID ' => $LoadID);
						$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

						$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
						$PDFContent = $PDFContentQRY->result();
						$LT = '';
						if ($data['LoadInfo']->LorryType == 1) {
							$LT = 'Tipper';
						} else if ($data['LoadInfo']->LorryType == 2) {
							$LT = 'Grab';
						} else if ($data['LoadInfo']->LorryType == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($data['LoadInfo']->TonBook == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
						$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';

						$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;

						$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
							<div style="width:100%; " >
								<div style="width:35%;float: left;" > 		
									<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
								</div>
								<div style="width:65%;float: right;text-align: right;" > 		 
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
									' . $PDFContent[0]->address . ' <br/> 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
								</div>
							</div>	
							<div style="width:100%;float: left;" >   
								<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
								<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
								<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> 
								<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/><hr>
								<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
								<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
								<div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
								<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
								<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
								' . $siteInDateTime . '
								' . $siteOutDateTime . '
								<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
								<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
								<b>Tip Address: </b> ' . $data['LoadInfo']->TipName . ',' . $data['LoadInfo']->Street1 . ',' . $data['LoadInfo']->Street2 . ',
								' . $data['LoadInfo']->Town . ',' . $data['LoadInfo']->County . ',' . $data['LoadInfo']->PostCode . '<br>		 		 
								<b>Material: </b> ' . $MaterialText . '  <br> 
								<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
								<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
								<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
							</div>
							<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
							<div style="width:100%;float: left;" >
								<b>Produced By: </b><br>
								<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
								' . $data['LoadInfo']->CustomerName . '<br><br>
								<div style="font-size: 9px;"> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
									<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
									' . $PDFContent[0]->FooterText . '  
								</div>
							</div>  
						</div></body></html>';

						$pdfFilePath = WEB_ROOT_PATH . "assets/conveyance/" . $data['LoadInfo']->ReceiptName;
						$mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);

						/* =================== Site Logs ===================  */
						$OldFile = $pdfFilePath;
						$NewFileName = date('YmdHis') . ".pdf";
						$NewFile = WEB_ROOT_PATH . "/assets/conveyance/" . $NewFileName;

						copy($OldFile, $NewFile);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_loads1',
							'PrimaryID' => $LoadID,
							'FileName' => $NewFileName,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'conveyance status update pdf',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ===================================== */


					}
					$this->session->set_flashdata('success', 'Status has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Please Try Again Later');
				}
				redirect('ConveyanceTickets');
			}

		}
	}
	function DeliveryStatusUpdateAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			$data['TicketNo'] = $this->input->post('TicketNo');
			$data['Status'] = $this->input->post('Status');
			$data['PDF'] = $this->input->post('PDF');

			$html = $this->load->view('Booking/DeliveryStatusUpdateAjax', $data, true);
			echo json_encode($html);
		}
	}
	function DeliveryStatusUpdate($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}
			
			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$Status = $this->input->post('Status');
				$LoadID = $this->input->post('LoadID');
				$TicketNo = $this->input->post('TicketNo');

				$oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
    	        $oldStatus = $oldData ? $oldData->Status : null;

				$LoadInfo = array('Status' => $Status);
				$cond = array('LoadID' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				 // Map status numbers to names
            $statusNames = [
                4 => 'Complete',
                5 => 'Cancel',
                6 => 'Waste Journey',
                7 => 'Invoice Cancel',
                8 => 'Invoice Cancel'
            ];
            $oldStatusName = isset($statusNames[$oldStatus]) ? $statusNames[$oldStatus] : 'Unknown';
            $newStatusName = isset($statusNames[$Status]) ? $statusNames[$Status] : 'Unknown';

				/* =================== Site Logs ===================  */
				$LoadInfoJson = json_encode($LoadInfo);
				$condJson = json_encode($cond);

				$SiteLogInfo = array(
					'TableName' => 'tbl_booking_loads1',
					'PrimaryID' => $LoadID,
					'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
					'OldValue' => json_encode(['Status' => $oldStatusName]),
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'delivery status update',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
				/* ===================================== */

				$update = 1;

				if ($update) {
					if ($Status == 4) {
						$conditions = array('LoadID ' => $LoadID);

						$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
						$PDFContent = $PDFContentQRY->result();

						$data1['tickets'] = $this->Booking_model->BookingTicketInfo($TicketNo);

						$tInfo = array('ReceiptName' => $data1['tickets']['TicketUniqueID'] . ".pdf");
						$tcond = array('LoadID' => $LoadID);
						$this->Common_model->update("tbl_booking_loads1", $tInfo, $tcond);

						$tInfo1 = array('pdf_name' => $data1['tickets']['TicketUniqueID'] . ".pdf");
						$tcond1 = array('TicketNo' => $TicketNo);
						$this->Common_model->update("tbl_tickets", $tInfo1, $tcond1);
						$LT = '';
						if ($data1['tickets']['LorryType'] == 1) {
							$LT = 'Tipper';
						} else if ($data1['tickets']['LorryType'] == 2) {
							$LT = 'Grab';
						} else if ($data1['tickets']['LorryType'] == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($data1['tickets']['TonBook'] == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						$MaterialText = $data1['tickets']['MaterialName'] . ' Delivered ' . $LT . ' ' . $TB;

						$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
							<div style="width:100%;float: left;" >    
								<b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
								<b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
								<b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
								<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
								<b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>		 
								<b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>		   
								<b>In Time: </b> ' . $data1['tickets']['SiteIn'] . ' <br>		   
								<b>Out Time: </b> ' . $data1['tickets']['SiteOut'] . ' <br>		   
								<b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
								<b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
								<b>Driver Name: </b> ' . $data1['tickets']['DriverName'] . '<br> 
								<b>Driver Signature: </b> <br> 
								<div><img src="/assets/DriverSignature/' . $data1['tickets']['dsignature'] . '" width ="100" height="40" style="float:left"> </div>
								<b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
								<b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
								<b>Tip Address: </b> ' . $data1['tickets']['TipName'] . ', ' . $data1['tickets']['Street1'] . ', ' . $data1['tickets']['Street2'] . ', ' . $data1['tickets']['Town'] . ', ' . $data1['tickets']['County'] . ', ' . $data1['tickets']['PostCode'] . ',								<br>	 
								<b>Waste License No:  </b>' . $data1['tickets']['PermitRefNo'] . ' <br> 
								<b>Material:  ' . $MaterialText . ' <br></b> 
								<b>SIC Code: </b> ' . $data1['tickets']['LoadSICCODE'] . ' <br> 
								<b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>		 
								<b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
								<b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
								<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
							<div style="width:100%;float: left;" > 
								<b>Received By: </b><br> 
								<div><img src="/uploads/Signature/' . $data1['tickets']['Signature'] . '" width ="100" height="40" style="float:left"></div> 
								' . $data1['tickets']['CustomerName'] . ' 
								<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

						$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data1['tickets']['TicketUniqueID'] . ".pdf";
						$mpdf = new mPDF('utf-8', array(70, 220), '', '', 5, 5, 5, 5, 5, 5);
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);

						/* =================== Site Logs ===================  */
						$OldFile = $pdfFilePath;
						$NewFileName = date('YmdHis') . ".pdf";
						$NewFile = WEB_ROOT_PATH . "/assets/conveyance/" . $NewFileName;

						copy($OldFile, $NewFile);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_loads1',
							'PrimaryID' => $LoadID,
							'FileName' => $NewFileName,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'conveyance status update pdf',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ===================================== */


					}
					if ($Status == 6) {
						$stampImage = WEB_ROOT_PATH . "assets/stamp/wasted.png";

						$conditions = array('LoadID ' => $LoadID);

						$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
						$PDFContent = $PDFContentQRY->result();

						$data1['tickets'] = $this->Booking_model->BookingTicketInfo($TicketNo);

						$tInfo = array('ReceiptName' => $data1['tickets']['TicketUniqueID'] . ".pdf");
						$tcond = array('LoadID' => $LoadID);
						$this->Common_model->update("tbl_booking_loads1", $tInfo, $tcond);

						$tInfo1 = array('pdf_name' => $data1['tickets']['TicketUniqueID'] . ".pdf");
						$tcond1 = array('TicketNo' => $TicketNo);
						$this->Common_model->update("tbl_tickets", $tInfo1, $tcond1);
						$LT = '';
						if ($data1['tickets']['LorryType'] == 1) {
							$LT = 'Tipper';
						} else if ($data1['tickets']['LorryType'] == 2) {
							$LT = 'Grab';
						} else if ($data1['tickets']['LorryType'] == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($data1['tickets']['TonBook'] == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						$MaterialText = $data1['tickets']['MaterialName'] . ' Delivered ' . $LT . ' ' . $TB;

						$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
							<div style="width:100%;float: left;" >    
								<b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
								<b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
								<b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
								<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
								<b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>		 
								<b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>		   
								<b>In Time: </b> ' . $data1['tickets']['SiteIn'] . ' <br>		   
								<b>Out Time: </b> ' . $data1['tickets']['SiteOut'] . ' <br>		   
								<b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
								<b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
								<b>Driver Name: </b> ' . $data1['tickets']['DriverName'] . '<br> 
								<b>Driver Signature: </b> <br> 
								<div><img src="/assets/DriverSignature/' . $data1['tickets']['dsignature'] . '" width ="100" height="40" style="float:left"> </div>
								<b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
								<b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
								<b>Tip Address: </b> ' . $data1['tickets']['TipName'] . ', ' . $data1['tickets']['Street1'] . ', ' . $data1['tickets']['Street2'] . ', ' . $data1['tickets']['Town'] . ', ' . $data1['tickets']['County'] . ', ' . $data1['tickets']['PostCode'] . ',								<br>	 
								<b>Waste License No:  </b>' . $data1['tickets']['PermitRefNo'] . ' <br> 
								<b>Material:  ' . $MaterialText . ' <br></b> 
								<b>SIC Code: </b> ' . $data1['tickets']['LoadSICCODE'] . ' <br> 
								<b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>		 
								<b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
								<b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
								<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
							<div style="width:100%;float: left;" > 
								<b>Received By: </b><br> 
								<div><img src="/uploads/Signature/' . $data1['tickets']['Signature'] . '" width ="100" height="40" style="float:left"></div> 
								' . $data1['tickets']['CustomerName'] . ' 
								<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

						$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data1['tickets']['TicketUniqueID'] . ".pdf";
						$mpdf = new mPDF('utf-8', array(70, 220), '', '', 5, 5, 5, 5, 5, 5);
						$mpdf->SetWatermarkImage($stampImage);
						$mpdf->showWatermarkImage = true;
						$mpdf->watermarkImgBehind = false;
						$mpdf->watermarkImageAlpha = 0.7;
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);

						/* =================== Site Logs ===================  */
						$OldFile = $pdfFilePath;
						$NewFileName = date('YmdHis') . ".pdf";
						$NewFile = WEB_ROOT_PATH . "/assets/conveyance/" . $NewFileName;

						copy($OldFile, $NewFile);


						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_loads1',
							'PrimaryID' => $LoadID,
							'FileName' => $NewFileName,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'conveyance status update pdf',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ===================================== */


					}
					$this->session->set_flashdata('success', 'Status has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Please Try Again Later');
				}
				redirect('DeliveryTickets');
			}

		}
	}
	public function Loads()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Loads/Lorry List ';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/Loads", $this->global, $data, NULL);
		}
	}
	public function LoadsFinished()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Finished Loads/Lorry List ';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/LoadsFinished", $this->global, $data, NULL);
		}
	}
	public function NonAppsLoads()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$data['NonAppsLoads'] = $this->Booking_model->GetNonAppsLoadsData();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : NonApps Loads/Lorry List ';
			$this->global['active_menu'] = 'nonappsloads';

			$this->loadViews("Booking/NonAppsLoads", $this->global, $data, NULL);
		}
	}

	public function NonAppsLoads1()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$data['NonAppsLoads'] = $this->Booking_model->GetNonAppsLoadsData1();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Dummy NonApps Loads/Lorry List ';
			$this->global['active_menu'] = 'nonappsloads';

			$this->loadViews("Booking/NonAppsLoads1", $this->global, $data, NULL);
		}
	}

	public function ContractorLoads()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				if (count($_POST['chkbox']) > 0) {
					$where_in = implode(',', $_POST['chkbox']);
					$ConInfo = array('Status' => 4);
					$u = $this->Common_model->update_in("tbl_booking_loads", $ConInfo, 'ConveyanceNo', $where_in);
					if ($u) {
						$this->session->set_flashdata('success', 'Selected Loads has been Finished successfully');
					} else {
						$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');
					}
				} else {
					$this->session->set_flashdata('error', 'Please select Any Loads to Finish. ');
				}
				redirect('ContractorLoads');
				exit;
			}
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Contractor Loads/Lorry List ';
			$this->global['active_menu'] = 'cloads';

			$this->loadViews("Booking/ContractorLoads", $this->global, $data, NULL);
		}
	}
	public function SubcontractorLoads($id)
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : SubcontractorLoads/Lorry List ';
			$this->global['active_menu'] = 'subcontractorloads';

			$this->loadViews("Booking/SubcontractorLoads", $this->global, $data, NULL);
		}
	}

	public function AllocateDrivers()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Allocated Drivers';
			$this->global['active_menu'] = 'allocateddrivers';

			$this->loadViews("Booking/AllocateDrivers", $this->global, $data, NULL);
		}
	}
	public function AjaxAllocateDrivers()
	{
		// echo "devam";
		// die();
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocateDriversData();
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
	public function ConveyanceTickets()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Conveyance Tickets';
			$this->global['active_menu'] = 'conveyance';

			$this->loadViews("Booking/ConveyanceTickets", $this->global, $data, NULL);
		}
	}



	public function DeliveryTickets()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Delivery Tickets';
			$this->global['active_menu'] = 'conveyance';

			$this->loadViews("Booking/DeliveryTickets", $this->global, $data, NULL);
		}
	}
	public function AllMessage()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : All Message';
			$this->global['active_menu'] = 'message';

			$this->loadViews("Booking/AllMessage", $this->global, $data, NULL);
		}
	}
	public function Message()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$data['driverList'] = $this->Booking_model->GetDriverList();
			//$data['driverList'] = $this->Booking_model->GetMessageLorryList();   

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Driver Message';
			$this->global['active_menu'] = 'message';

			$this->loadViews("Booking/Message", $this->global, $data, NULL);
		}
	}
	function SendDriverMessage()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			$IDS = $this->security->xss_clean($this->input->post('IDS'));
			$Message = $this->security->xss_clean($this->input->post('Message'));
			$Id = explode(',', $IDS);
			for ($i = 0; $i < count($Id); $i++) {
				$MessageInfo = array('DriverID' => $Id[$i], 'Status' => 0, 'Message' => $Message);
				$result1 = $this->Common_model->insert("tbl_driver_message", $MessageInfo);
			}
			$this->Fcm_model->sendNotication($IDS, $Message, 'message');
			//if ($result1 > 0) { 
			echo (json_encode(array('status' => TRUE, 'result' => $result1)));
			//}else{ 
			//	echo(json_encode(array('status'=>FALSE,'result'=>$result1))); 
			//}
		}
	}

	public function AjaxMessage()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetLoadsMessage();
		$this->ajax->send($data);
	}
	public function AjaxAllocatedBookings()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocatedBookingData();
		$this->ajax->send($data);
	}
	public function AjaxAllocatedBookings2()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocatedBookingData2();
		$this->ajax->send($data);
	}
	public function AjaxAllocatedBookings3()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocatedBookingData3();
		$this->ajax->send($data);
	}
	public function AjaxAllocatedBookings1()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocatedBookingData1();
		$this->ajax->send($data);
	}
	public function AjaxLoads()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetLoadsData();
		$this->ajax->send($data);
	}
	public function AjaxContractorLoads()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetContractorLoadsData();
		$this->ajax->send($data);
	}
	public function AjaxNonAppsLoads()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetNonAppsLoadsData();
		$this->ajax->send($data);
	}

	public function AjaxSubcontractorLoads()
	{
		$this->load->library('ajax');
		$ContractorID = $this->input->post('ContractorID');
		$data = $this->Booking_model->GetSubcontractorLoadsData($ContractorID);
		$this->ajax->send($data);
	}

	public function AjaxLoads1()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetLoadsData1();
		$this->ajax->send($data);
	}

	public function AjaxLoads2()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetLoadsData2();
		$this->ajax->send($data);
	}

	public function AjaxConveyanceTickets()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetConveyanceTickets();
		$this->ajax->send($data);
	}


	function ConveyanceTicketsTableMeta()
	{
		echo '{"Name":"Conveyance","Action":true,"Column":[{"Name":"ConveyanceNo","Title":"Conv No","Searchable":true,"Class":null},{"Name":"SiteOutDateTime","Title":"DateTime","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Customer Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Job Site Address","Searchable":true,"Class":null},{"Name":"TipName","Title":"Supplier Name","Searchable":true,"Class":null},{"Name":"TipAddress","Title":"Tip Site Address","Searchable":false,"Class":null},{"Name":"SuppDate","Title":"SuppTkt Dt","Searchable":false,"Class":null},{"Name":"SuppNo","Title":"SuppTkt No","Searchable":false,"Class":null},{"Name":"PurchaseOrderNo","Title":"PO NO","Searchable":false,"Class":null},{"Name":"MaterialName","Title":"Product Description","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"VehicleRegNo","Title":"VRNO","Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Searchable":true,"Class":null},{"Name":"WaitTime","Title":"WaitTime","Searchable":true,"Class":null},{"Name":"Status","Title":"Status","Searchable":true,"Class":null}]}';
	}




	public function AjaxDeliveryTickets()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetDeliveryTickets();
		$this->ajax->send($data);
	}

	function DeliveryTicketsTableMeta()
	{
		echo '{"Name":"Delivery","Action":true,"Column":[{"Name":"TicketNumber","Title":"TicketNo","Searchable":true,"Class":null},{"Name":"SiteOutDateTime","Title":"DateTime","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Customer Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Job Site Address","Searchable":true,"Class":null},{"Name":"PurchaseOrderNo","Title":"PO No","Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Product Description","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"VehicleRegNo","Title":"VRNO","Searchable":true,"Class":null},{"Name":"WaitTime","Title":"WaitTime","Searchable":true,"Class":null},{"Name":"Status","Title":"Status","Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Searchable":true,"Class":null}]}';
	}

	public function AjaxBookings()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetBookingData();
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}

	function GetDriverList()
	{
		$result['driver_list'] = $this->Booking_model->LorryListAJAX();
		if ($result > 0) {
			echo (json_encode($result));
		} else {
			echo (json_encode(array('status' => FALSE)));
		}
	}

	function GetTipList()
	{
		$result['tip_list'] = $this->Booking_model->TipListAJAX();
		if ($result > 0) {
			echo (json_encode($result));
		} else {
			echo (json_encode(array('status' => FALSE)));
		}
	}



	function getCompanyList()
	{
		$result['company_list'] = $this->Common_model->CompanyListAJAX();
		if ($result > 0) {
			echo (json_encode($result));
		} else {
			echo (json_encode(array('status' => FALSE)));
		}
	}

	function ApproveBooking()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingID = $this->input->post('BookingNo');

			$con = array('BookingID' => $BookingID);
			$BookingInfo = array('Status' => '1', 'ApprovedBy' => $this->session->userdata['userId'], 'UpdatedBy' => $this->session->userdata['userId']);
			$result = $this->Common_model->update("booking", $BookingInfo, $con);

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE, 'BookingID' => $BookingID)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}
		}
	}


	function AllocateBookingAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingID = $this->input->post('BookingID');
			$BookingDateID = $this->input->post('BookingDateID');
			$BookingDate = $this->input->post('BookingDate');
			$DriverID = $this->input->post('DriverID');
			$TipID = $this->input->post('TipID');
			$Qty = $this->input->post('Qty');
			$MaterialID = $this->input->post('MaterialID');
			$AllocatedDateTime = $this->input->post('AllocatedDateTime');
			$Loads = $this->input->post('Loads');
			$TotalLoads = $this->input->post('TotalLoads');
			$LID = $this->generateRandomString();
			if ($AllocatedDateTime == "") {
				$AllocatedDateTime = date('Y-m-d H:i:s');
			}

			$Booking = $this->Booking_model->GetBookingInfo($BookingID);
			$Driver = $this->Booking_model->getLorryNoDetails($DriverID);
			$j = 0;
			for ($i = 1; $i <= $Qty; $i++) {
				if ($Booking->BookingType == 1) {
					$AllocatedLoads = $this->Common_model->CountLoads($BookingDateID);
					//$cond = array( 'BookingDateID' => $BookingDateID);
					//$AllocatedLoads = $this->Common_model->select_count_where('tbl_booking_loads',$cond); 
				}
				if ($Booking->BookingType == 2) {
					$AllocatedLoads = $this->Common_model->CountLorry($BookingDateID);
				}
				//echo $TotalLoads;
				//echo " ==== ";
				//echo $AllocatedLoads;
				if ($TotalLoads != $AllocatedLoads) {

					$TicketID = 0;
					$TicketUniqueID = "";
					if ($Booking->BookingType == 2) {
						//echo json_encode($Driver);
						if ($TipID == 1) {
							//if($Driver->AppUser==0){
							$TicketUniqueID = $this->generateRandomString();
							$TicketNumber = 1;
							$LastTicketNumber = $this->Booking_model->LastTicketNo();
							if ($LastTicketNumber) {
								$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
							}

							$ticketsInfo = array(
								'TicketUniqueID' => $TicketUniqueID,
								'TicketNumber' => $TicketNumber,
								'TicketDate' => date('Y-m-d H:i:s'),
								'OpportunityID' => $Booking->OpportunityID,
								'CompanyID' => $Booking->CompanyID,
								'DriverName' => $Driver->DriverName,
								'RegNumber' => $Driver->RegNumber,
								'Hulller' => $Driver->Haulier,
								'Tare' => $Driver->Tare,
								'driversignature' => $Driver->ltsignature,
								'driver_id' => $DriverID,
								'MaterialID' => $Booking->MaterialID,
								'SicCode' => $Booking->SicCode,
								'CreateDate' => date('Y-m-d H:i:s'),
								'TypeOfTicket' => 'Out',
								'is_hold' => 1
							);
							$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);
							//}
						}
					} else if ($Booking->BookingType == 1) {
						if ($TipID == 1) {
							if ($Driver->AppUser == 1) {
								$TicketUniqueID = $this->generateRandomString();
								$TicketNumber = 1;
								$LastTicketNumber = $this->Booking_model->LastTicketNo();
								if ($LastTicketNumber) {
									$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
								}

								$ticketsInfo = array(
									'TicketUniqueID' => $TicketUniqueID,
									'TicketNumber' => $TicketNumber,
									'TicketDate' => date('Y-m-d H:i:s'),
									'OpportunityID' => $Booking->OpportunityID,
									'CompanyID' => $Booking->CompanyID,
									'DriverName' => $Driver->DriverName,
									'RegNumber' => $Driver->RegNumber,
									'Hulller' => $Driver->Haulier,
									'Tare' => $Driver->Tare,
									'driversignature' => $Driver->ltsignature,
									'driver_id' => $DriverID,
									'MaterialID' => $Booking->MaterialID,
									'SicCode' => $Booking->SicCode,
									'CreateDate' => date('Y-m-d H:i:s'),
									'TypeOfTicket' => 'In',
									'IsInBound' => 1
								);
								$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);
							}
						}
					}
					################################################

					$LastConNumber = $this->Booking_model->LastConNumber();
					if ($LastConNumber) {
						$ConveyanceNo = $LastConNumber['ConveyanceNo'] + 1;
					} else {
						$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
						$ConveyanceNo = $data['content']['ConveyanceStart'];
					}
					$result1 = "";
					if ($Driver->AppUser == 1) {
						$status = 1;
						if ($Driver->RegNumber != "") {
							$RegNumber = $Driver->RegNumber;
						} else {
							$RegNumber = $Driver->ContractorLorryNo;
						}
					} else {
						$status = 0;
						$RegNumber = $Driver->RegNumber;
					}

					$LoadInfo = array(
						'LID' => $LID,
						'BookingID' => $BookingID,
						'BookingDateID' => $BookingDateID,
						'ConveyanceNo' => $ConveyanceNo,
						'TicketID' => $TicketID,
						'TicketUniqueID' => $TicketUniqueID,
						'DriverID' => $DriverID,
						'DriverLoginID' => $Driver->DriverID,
						'DriverName' => $Driver->DriverName,
						'VehicleRegNo' => $RegNumber,
						'MaterialID' => $MaterialID,
						'AllocatedDateTime' => $AllocatedDateTime,
						'TipID' => $TipID,
						'Status' => $status,
						'AutoCreated' => 1,
						'CreatedBy' => $this->session->userdata['userId']
					);
					$result1 = $this->Common_model->insert("tbl_booking_loads", $LoadInfo);

					$Message = 'New load has been allocated';
					$this->Fcm_model->sendNotication($DriverID, $Message, 'noti');
					if ($TipID == 1) {
						if ($Booking->BookingType == 2) {
							$ticketsInfo1 = array('LoadID' => $result1, 'Conveyance' => $ConveyanceNo);
							$cond = array('TicketNo' => $TicketID);
							$this->Common_model->update("tbl_tickets", $ticketsInfo1, $cond);
						} else if ($Booking->BookingType == 1) {
							if ($Driver->AppUser == 1) {
								$ticketsInfo1 = array('LoadID' => $result1, 'Conveyance' => $ConveyanceNo);
								$cond = array('TicketNo' => $TicketID);
								$this->Common_model->update("tbl_tickets", $ticketsInfo1, $cond);
							}
						}

					}
					if ($result1 > 0) {
						$j = $j + 1;
					}
					################################################ 

				} else {
					echo (json_encode(array('status' => FALSE, )));
				}
			} // For 

			if ($j > 0) {
				if ((int) $Loads > 0) {
					(int) $Loads = (int) $Loads - $j;
				} else {
					(int) $Loads = 0;
				}
				$data['Loads'] = $this->Booking_model->ShowBookingDateLoads($BookingDateID);
				$ShowLoads = $this->load->view('Booking/AllAllocatedAJAX', $data, true);
				echo (json_encode(array('status' => TRUE, 'ShowLoads' => $ShowLoads, 'loads' => $Loads, 'Alloloads' => $j, 'BookingType' => $Booking->BookingType, 'LoadType' => $Booking->LoadType, 'BookingDateID' => $BookingDateID, 'BookingDate' => $BookingDate)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}

	function ShowLoadsAJAX()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingDateID = $this->input->post('BookingDateID');

			//$data['Loads'] = $this->Booking_model->ShowLoads($BookingID); 
			$data['Loads'] = $this->Booking_model->ShowBookingDateLoads($BookingDateID);
			//var_dump($data['Loads']);
			//exit; 
			$html = $this->load->view('Booking/LoadInfoAjax', $data, true);
			echo json_encode($html);
		}
	}
	function ShowBLoadsAJAX()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingID = $this->input->post('BookingID');

			$data['Loads'] = $this->Booking_model->ShowLoads($BookingID);
			//$data['Loads'] = $this->Booking_model->ShowBookingDateLoads($BookingDateID); 
			//var_dump($data['Loads']);
			//exit; 
			$html = $this->load->view('Booking/LoadInfoAjax', $data, true);
			echo json_encode($html);
		}
	}
	function ShowLoadsAJAX1()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingDateID = $this->input->post('BookingDateID');
			$LoadType = $this->input->post('LoadType');
			if ($LoadType == 1) {
				$data['Loads'] = $this->Booking_model->ShowLoads1($BookingDateID);
			}
			if ($LoadType == 2) {
				$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);
			}
			//var_dump($data['Loads']);
			//exit; 
			$html = $this->load->view('Booking/LoadInfoAjax1', $data, true);
			echo json_encode($html);
		}
	}

	function ShowLoadsDeleteBookingAJAX()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['BookingDateID'] = $this->input->post('BookingDateID');
			$data['PendingLoads'] = $this->input->post('PendingLoads');
			//$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);    
			//var_dump($data);
			//exit; 
			$html = $this->load->view('Booking/ShowLoadsDeleteBookingAJAX', $data, true);
			echo json_encode($html);
		}
	}
	function ShowLoadsDeleteBookingAJAXPOST()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingDateID = $this->input->post('BookingDateID');
			$CancelLoads = $this->input->post('CancelLoads');
			$PendingLoads = $this->input->post('PendingLoads');
			$CancelNote = $this->input->post('CancelNote');
			$LoadInfo = array('BookingDateStatus' => 1, 'CancelLoads' => $CancelLoads, 'CancelNote' => $CancelNote);
			$LoadCond = array('BookingDateID' => $BookingDateID);

			$result = $this->Common_model->update("tbl_booking_date", $LoadInfo, $LoadCond);
			redirect('AllocateBookings');
			//$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);    
			//var_dump($data);
			//exit; 

		}
	}
	function ShowUpdateBookingAJAX()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['BookingID'] = $this->input->post('BookingID');
			$data['PendingLoads'] = $this->input->post('PendingLoads');
			$data['TotalLoads'] = $this->input->post('TotalLoads');
			//$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);    
			//var_dump($data);
			//exit; 
			$html = $this->load->view('Booking/ShowUpdateBookingAJAX', $data, true);
			echo json_encode($html);
		}
	}
	function ShowUpdateBookingAJAXPOST()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingID = $this->input->post('BookingID');
			$Loads = $this->input->post('Loads');

			$LoadInfo = array('Loads' => $Loads);
			$LoadCond = array('BookingID' => $BookingID);

			$result = $this->Common_model->update("tbl_booking", $LoadInfo, $LoadCond);
			redirect('AllocateBookings');
			//$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);    
			//var_dump($data);
			//exit;    
		}
	}

	function ShowOppoProductPriceAJAX()
	{

		$OpportunityID = $this->input->post('OpportunityID');
		$MaterialID = $this->input->post('MaterialID');
		$DateRequired = $this->input->post('DateRequired');
		$LorryType = $this->input->post('LorryType');

		//$ProductPrice = $this->Booking_model->GetOppoMaterialListDetails($OpportunityID,$MaterialID,$DateRequired); 
		$ProductPrice = $this->Booking_model->GetOppoMaterialListDetails($OpportunityID, $MaterialID, $DateRequired, $LorryType);
		//var_dump($ProductPrice); 
		//exit; 

		echo (json_encode(array('Price' => trim($ProductPrice[0]->UnitPrice), 'PurchaseOrderNo' => trim($ProductPrice[0]->PurchaseOrderNo), 'PON' => trim($ProductPrice[0]->PON), 'OpenPO' => trim($ProductPrice[0]->OpenPO), 'PriceDate' => trim($ProductPrice[0]->PriceDate))));

	}
	function ShowHaulageOppoProductPriceAJAX()
	{

		$OpportunityID = $this->input->post('OpportunityID');
		$TipName = $this->input->post('TipName');
		$DateRequired = $this->input->post('DateRequired');
		$LorryType = $this->input->post('LorryType');

		//$ProductPrice = $this->Booking_model->GetOppoMaterialListDetails($OpportunityID,$MaterialID,$DateRequired); 
		$ProductPrice = $this->Booking_model->GetHaulageOppoMaterialListDetails($OpportunityID, $TipName, $DateRequired, $LorryType);
		//var_dump($ProductPrice); 
		//exit; 

		echo (json_encode(array('Price' => trim($ProductPrice[0]->UnitPrice), 'PurchaseOrderNo' => trim($ProductPrice[0]->PurchaseOrderNo), 'PON' => trim($ProductPrice[0]->PON), 'OpenPO' => trim($ProductPrice[0]->OpenPO), 'PriceDate' => trim($ProductPrice[0]->PriceDate))));
		//echo( json_encode(array('Price'=>trim($ProductPrice[0]->UnitPrice),'PurchaseOrderNo'=>trim($ProductPrice[0]->PurchaseOrderNo),'PriceDate'=>trim($ProductPrice[0]->PriceDate) ) ) ); 		 

	}
	function ShowOppoProductPriceTonnageAJAX()
	{

		$OpportunityID = $this->input->post('OpportunityID');
		$MaterialID = $this->input->post('MaterialID');
		$DateRequired = $this->input->post('DateRequired');
		$LorryType = $this->input->post('LorryType');

		//$ProductPrice = $this->Booking_model->GetOppoMaterialListTonnageDetails($OpportunityID,$MaterialID,$DateRequired); 
		$ProductPrice = $this->Booking_model->GetOppoMaterialListTonnageDetails($OpportunityID, $MaterialID, $DateRequired, $LorryType);
		//var_dump($ProductPrice); 
		//exit; 

		echo (json_encode(array('Price' => trim($ProductPrice[0]->UnitPrice), 'PurchaseOrderNo' => trim($ProductPrice[0]->PurchaseOrderNo), 'PON' => trim($ProductPrice[0]->PON), 'OpenPO' => trim($ProductPrice[0]->OpenPO), 'PriceDate' => trim($ProductPrice[0]->PriceDate))));
		//echo( json_encode(array('Price'=>trim($ProductPrice[0]->UnitPrice),'PurchaseOrderNo'=>trim($ProductPrice[0]->PurchaseOrderNo),'PriceDate'=>trim($ProductPrice[0]->PriceDate) ) ) ); 		 

	}

	function AJAXShowLoadsDetails()
	{

		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');

			$data['Loads'] = $this->Booking_model->ShowLoadDetails($LoadID);
			$data['Photos'] = $this->Booking_model->ShowLoadPhotos($LoadID);

			//var_dump($data['Loads']);
			//exit; 
			//echo json_encode(var_dump($data['Loads'])); 
			//exit;
			//$html =  $LoadID." ==== ";
			//$html .=  var_dump($data['Loads']);
			//$html .=  var_dump($data['Photos']);
			$html = $this->load->view('Booking/AJAXLoadTimeline', $data, true);
			echo json_encode($html);
		}
	}

	function AJAXGetPageHeaderInfo()
	{
		// echo "sdfsdfdsf";
		//exit;
		//$url  = $this->input->post('url');      
		//$HI = get_headers($url); 
		//echo $HI[1]; 
		//echo json_encode($HI[1]); 
		echo json_encode("ttttt");
	}


	function AJAXShowRequestLoadsDetails()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');

			$data['Loads'] = $this->Booking_model->ShowRequestLoadDetails($LoadID);
			$data['Photos'] = $this->Booking_model->ShowRequestLoadPhotos($LoadID);
			$data['updatelogs'] = $this->Booking_model->ShowUpdateLogs($LoadID);
			// var_dump($data['logs']);
			// exit; 
			//echo json_encode(var_dump($data['Loads'])); 
			//exit;
			//$html =  $LoadID." ==== ";
			//$html .=  var_dump($data['Loads']);
			//$html .=  var_dump($data['Photos']);
			$html = $this->load->view('Booking/AJAXRequestLoadTimeline', $data, true);
			echo json_encode($html);
		}
	}


	function AJAXShowRequestHaulageLoadsDetails()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');

			$data['Loads'] = $this->Booking_model->ShowRequestLoadDetails($LoadID);
			$data['Photos'] = $this->Booking_model->ShowRequestLoadPhotos($LoadID);
			$data['updatelogs'] = $this->Booking_model->ShowUpdateLogs($LoadID);
			//var_dump($data['Loads']);
			//exit; 
			//echo json_encode(var_dump($data['Loads'])); 
			//exit;
			//$html =  $LoadID." ==== ";
			//$html .=  var_dump($data['Loads']);
			//$html .=  var_dump($data['Photos']);
			$html = $this->load->view('Booking/AJAXHaulageRequestLoadTimeline', $data, true);
			echo json_encode($html);
		}
	}

	function DeleteBooking()
	{
		if ($this->isDelete == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingID = $this->input->post('BookingNo');
			$con = array('BookingID' => $BookingID);
			$result = $this->Common_model->delete('booking', $con);
			if ($result > 0) {
				echo (json_encode(array('status' => TRUE)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}
		}
	}

	function DeleteBookingRequest()
	{
		if ($this->isDelete == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingDateID = $this->input->post('BookingDateID');
			$BookingID = $this->input->post('BookingID');
			$BookingRequestID = $this->input->post('BookingRequestID');

			//$data['CountBookingDate'] = $this->Booking_model->CountBookingID($BookingID); 
			//$data['CountBooking'] = $this->Booking_model->CountBookingRequestID($BookingRequestID); 
			//echo $data['CountBookingDate']->CountBookingDate;
			//echo " === ".$data['CountBooking']->CountBooking;
			//exit;	

			$con = array('BookingDateID ' => $BookingDateID);
			$result = $this->Common_model->delete('tbl_booking_date1', $con);
			if ($result) {
				$data['CountBookingDate'] = $this->Booking_model->CountBookingID($BookingID);
				if ($data['CountBookingDate']->CountBookingDate == 0) {
					$con1 = array('BookingID ' => $BookingID);
					$result1 = $this->Common_model->delete('tbl_booking1', $con1);

					if ($result1) {
						$data['CountBooking'] = $this->Booking_model->CountBookingRequestID($BookingRequestID);
						if ($data['CountBooking']->CountBooking == 0) {
							$con2 = array('BookingRequestID ' => $BookingRequestID);
							$result2 = $this->Common_model->delete('tbl_booking_request', $con2);
						}
					}

				}


				$this->session->set_flashdata('success', 'Booking Request has been deleted successfully');
			} else {
				$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
			}
			redirect('BookingRequest');
			//if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
			//else { echo(json_encode(array('status'=>FALSE))); } 
		}
	}

	public function DriverLoads(){ 
        $data=array();  
		$data['Driver'] = 0; 
		if($this->input->post('search')){ 
			$driver = $this->input->post('driver'); 
			$data['Driver'] = $driver;
			$searchdate = $this->input->post('searchdate');
			$data['searchdate'] = $searchdate;

			$B = explode('/', $searchdate);
			$sd = $B[2] . "-" . $B[1] . "-" . $B[0];

			$data['TodayPDAUsers'] = $this->Common_model->TodayPDAUsers($sd);
			$data['DriverLoadsCollection'] = $this->Booking_model->GetDriverRequestLoadsCollection($searchdate, $driver);
			$data['DriverLoadsDelivery'] = $this->Booking_model->GetDriverRequestLoadsDelivery($searchdate, $driver);

			$data['DriverLoadsDayWork'] = $this->Booking_model->GetDriverRequestLoadsDayWork($searchdate, $driver);
			$data['DriverLoadsHaulage'] = $this->Booking_model->GetDriverRequestLoadsHaulage($searchdate, $driver);

			$data['DriverDetails'] = $this->Booking_model->GetDriverLoginDetails($driver);
		}

		$data['DriverList'] = $this->Booking_model->DriverLoginList();

		$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Driver Loads Reports';
		$this->global['active_menu'] = 'driverloads';
		$this->loadViews("Booking/DriverLoads", $this->global, $data, NULL);
	}

	function DeleteLoad()
	{
		if ($this->isDelete == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');
			$con = array('LoadID' => $LoadID, 'Status' => '0');
			$result = $this->Common_model->delete('booking_loads', $con);
			if ($result > 0) {
				echo (json_encode(array('status' => TRUE)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}
		}
	}
	function CancelLoad()
	{
		if ($this->isDelete == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');
			$Notes = $this->input->post('confirmation');

			$ticketsInfo = array('Status' => '5', 'CancelNote' => $Notes);
			$con = array('LoadID' => $LoadID);
			$result = $this->Common_model->update("booking_loads", $ticketsInfo, $con);

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}
		}
	}

	function pageNotFound()
	{
		$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : 404 - Page Not Found';

		$this->loadViews("404", $this->global, NULL, NULL);
	}
	function getMaterialList()
	{
		$type = $_POST['TicketType'];
		if ($type == 'In') {
			$type = 'IN';
		} else {
			$type = 'OUT';
		}
		$result = $this->tickets_model->getMaterialList($type);
		$html = '<option value="">-- Select material type--</option>';
		foreach ($result as $key => $value) {
			$html .= "<option value='" . $value->MaterialID . "'>" . $value->MaterialName . "</option>";
		}
		echo $html;

	}
	function getMaterialListDetails()
	{

		if ($_POST) {
			$id = $_POST['id'];
			$result = $this->tickets_model->getMaterialListDetails($id);
			$aray = array();
			if ($result) {
				$SicCode = $result->SicCode;
				$price = $result->price;
				$aray = array('SicCode' => $SicCode, 'price' => $price);
			}
			echo json_encode($aray);
		}
	}

	function getOpportunitiesList()
	{

		$result = $this->tickets_model->getOpportunitiesList();
		//print_r($result);
		$html = '<option value="">-- Select Opportunity --</option>';
		foreach ($result as $key => $value) {
			$html .= "<option value='" . $value->OpportunityID . "'>" . $value->OpportunityName . "</option>";
		}
		echo $html;
	}


	function LoadOppoByCompany()
	{

		$id = $_POST['id'];

		$result['CompanyInfo'] = $this->Booking_model->GetCompanyBookingInfoByID($id);
		//$result['CompanyInfo'][0]->SageURL = '';
		if ($result['CompanyInfo'][0]->SageURL != "") {

			$url = $result['CompanyInfo'][0]->SageURL;

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

			$jcode = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', stripslashes(html_entity_decode(rtrim($jcode, "\0")))), true);

			$result['SageCreditLimit'] = $jcode['$resources'][0]['creditLimit'];
			$result['SagePaymentType'] = $jcode['$resources'][0]['tradingTerms'];
			$result['SageOutstanding'] = $jcode['$resources'][0]['balance'];

			//echo "<PRE>";  
			//print_r($jcode);	
			//echo "</PRE>";  
			//exit;
		} else {
			$result['SageCreditLimit'] = '';
			$result['SagePaymentType'] = '';
			$result['SageOutstanding'] = '';
		}

		$result['Opportunity_list'] = $this->tickets_model->getAllOpportunitiesByCompany($id);
		if (count($result) > 0) {
			echo (json_encode($result));
		} else {
			echo (json_encode(array('status' => FALSE)));
		}

	}

	function LoadMaterials()
	{

		$t = $_POST['id'];
		if ($t == '1') {
			$type = "IN";
		}
		if ($t == '2') {
			$type = "OUT";
		}
		$result['material_list'] = $this->Booking_model->getMaterialList($type);
		if ($result > 0) {
			echo (json_encode($result));
		} else {
			echo (json_encode(array('status' => FALSE)));
		}

	}

	// function LoadSICCodeProduct()
	// {
	// 	$OpportunityID = $_POST['OpportunityID'];
	// 	$MaterialID = $_POST['MaterialID'];

	// 	$result['SICCODE'] = $this->Booking_model->GetLatestSICCode($OpportunityID, $MaterialID);
	// 	if ($result > 0) {
	// 		echo (json_encode($result));
	// 	} else {
	// 		echo (json_encode(array('status' => FALSE)));
	// 	}

	// }
	function LoadSICCodeProduct() {
		$OpportunityID = $this->input->post('OpportunityID');
		$MaterialID = $this->input->post('MaterialID');
		
		// Debugging: Log received data
		log_message('debug', "Received OpportunityID: $OpportunityID and MaterialID: $MaterialID");
	
		// Try to fetch SICCode using the model method
		$SICCode = $this->Booking_model->GetLatestSICCode($OpportunityID, $MaterialID);
		
		if ($SICCode) {
			// If SICCode is found, return it in a valid JSON format
			echo json_encode(array('status' => true, 'SICCODE' => $SICCode));
		} else {
			// If no SICCode is found, return a failure status
			echo json_encode(array('status' => false, 'message' => 'No SIC Code found'));
		}
	}
	
	

	// function LoadSICCodeProduct()
	// {
	// 	$OpportunityID = $this->input->post('OpportunityID');
	// 	$MaterialID = $this->input->post('MaterialID');

	// 	// Debugging: Log received data
	// 	//log_message('debug', "Received OpportunityID: $OpportunityID and MaterialID: $MaterialID");

	// 	// Try to fetch SICCode using the model method
	// 	$SICCode = $this->Booking_model->GetLatestSICCode($OpportunityID, $MaterialID);

	// 	if ($SICCode) {
	// 		// If SICCode is found, return it in a valid JSON format
	// 		echo json_encode(array('status' => true, 'SICCODE' => $SICCode));
	// 	} else {
	// 		// If no SICCode is found, return a failure status
	// 		echo json_encode(array('status' => false, 'message' => 'No SIC Code found'));
	// 	}
	// }

	function LoadOpportunityContacts()
	{
		$id = $_POST['id'];
		$result['OppPO'] = $this->Booking_model->GetOpenPO($id);
		$result['OppPriceBy'] = $this->Booking_model->GetPriceBy($id);
		$result['contact_list'] = $this->Booking_model->getContactsByOpportunity($id);
		$result['OppDetails'] = $this->Booking_model->getOppoByID($id);
		//echo count($result); 
		//exit;
		if (count($result) > 0) {
			echo (json_encode($result));
		} else {
			echo (json_encode(array('status' => FALSE)));
		}
	}
	function DisplayContactDetails()
	{
		$id = $_POST['id'];
		$result['contact'] = $this->Booking_model->getContactDetails($id);
		if ($result > 0) {
			echo (json_encode($result));
		} else {
			echo (json_encode(array('status' => FALSE)));
		}
	}

	function BookingStageAtSite($LoadID)
	{
		exit;
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			$conditions = array('LoadID ' => $LoadID);
			$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo($LoadID);
			if ($data['LoadInfo']->Status != 1) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$SiteInDateTime = date("Y-m-d H:i:s");
				$Notes1 = $this->security->xss_clean($this->input->post('Notes1'));
				$GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
				$TipNumber = $this->security->xss_clean($this->input->post('TipNumber'));

				$LoadInfo = array(
					'SiteInDateTime' => $SiteInDateTime,
					'Notes1' => $Notes1,
					'GrossWeight' => $GrossWeight,
					'TipNumber' => $TipNumber,
					'Status' => 2
				);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads", $LoadInfo, $cond);
				if ($update) {
					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
				}
				redirect('Loads');
			}
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Stage Update to Reach / At Site';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/BookingStageAtSite", $this->global, $data, NULL);
		}
	}
	function BookingStageLeftSite($LoadID)
	{
		exit;
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			$conditions = array('LoadID ' => $LoadID);
			$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo($LoadID);
			//if($data['LoadInfo']->Status!=2){ redirect('Loads'); }

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$SiteOutDateTime = date("Y-m-d H:i:s");
				$Notes2 = $this->security->xss_clean($this->input->post('Notes2'));
				$CustomerName = $this->security->xss_clean($this->input->post('CustomerName'));

				$Signature = $this->input->post('Signature', FALSE);

				if ($Signature != "") {
					$Signature1 = str_replace('data:image/png;base64,', '', $Signature);
					$Signature1 = str_replace(' ', '+', $Signature1);
					$Signature1 = base64_decode($Signature1);


					$Signature = md5(date("dmYhisA")) . ".png";
					$file_name = './uploads/Signature/' . $Signature;
					file_put_contents($file_name, $Signature1);
				} else {
					$Signature = "";
				}

				$TicketUniqueID = $this->generateRandomString();

				$LoadInfo = array(
					'SiteOutDateTime' => $SiteOutDateTime,
					'Notes2' => $Notes2,
					'ReceiptName' => $TicketUniqueID . ".pdf",
					'Signature' => $Signature,
					'CustomerName' => $CustomerName,
					'Status' => 3
				);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads", $LoadInfo, $cond);
				if ($update) {

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					if ($data['LoadInfo']->BookingType == 1) {

						$LastTicketNumber = $this->tickets_model->LastTicketNo();
						if ($LastTicketNumber) {
							$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
						} else {
							$TicketNumber = 1;
						}

						$ticketsInfo = array(
							'TicketUniqueID' => $TicketUniqueID,
							'LoadID' => $LoadID,
							'TicketNumber' => $TicketNumber,
							'TicketDate' => date('Y-m-d H:i:s'),
							'Conveyance' => $data['LoadInfo']->ConveyanceNo,
							'OpportunityID' => $data['LoadInfo']->OpportunityID,
							'CompanyID' => $data['LoadInfo']->CompanyID,
							'DriverName' => $data['LoadInfo']->DriverName,
							'RegNumber' => $data['LoadInfo']->VehicleRegNo,
							'Hulller' => $data['LoadInfo']->Haulier,
							'Tare' => $data['LoadInfo']->Tare,
							'driver_id' => $data['LoadInfo']->DriverID,
							'DriverLoginID' => $data['LoadInfo']->DriverLoginID,
							'MaterialID' => $data['LoadInfo']->MaterialID,
							'SicCode' => $data['LoadInfo']->SicCode,
							'CreateUserID' => 1,
							'CreateDate' => date('Y-m-d H:i:s'),
							'TypeOfTicket' => 'In',
							'IsInBound' => 1,
							'pdf_name' => $TicketUniqueID . '.pdf'
						);

						$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);



						$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
							<div style="width:100%; " >
								<div style="width:35%;float: left;" > 		
									<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
								</div>
								<div style="width:65%;float: right;text-align: right;" > 		 
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
									' . $PDFContent[0]->address . ' <br/> 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
								</div>
							</div>	
							<div style="width:100%;float: left;" >   
								<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
								<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
								<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> 
								<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/><hr>
								<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
								<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
								<div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
								<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
								<b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
								<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
								<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
								<b>Tip Address: </b> ' . $data['LoadInfo']->TipName . ', ' . $data['LoadInfo']->Street1 . ' ' . $data['LoadInfo']->Street2 . ' ' . $data['LoadInfo']->Town . ' ' . $data['LoadInfo']->County . ' ' . $data['LoadInfo']->PostCode . '<br>		 		 
								<b>Material: </b> ' . $data['LoadInfo']->MaterialName . ' ' . $LT . '  <br> 
								<b>SicCode: </b> ' . $data['LoadInfo']->SicCode . '  <br>  
								<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
								<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
							</div>
							<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
							<div style="width:100%;float: left;" >
								<b>Produced By: </b><br>
								<div><img src="/uploads/Signature/' . $Signature . '" width ="100" height="40" style="float:left"></div>
								' . $data['LoadInfo']->CustomerName . '<br><br>
								<div style="font-size: 9px;"> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
									<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
									' . $PDFContent[0]->FooterText . '  
								</div>
							</div>  
						</div></body></html>';

						$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $TicketUniqueID . '.pdf';
						$mpdf = new mPDF('utf-8', array(70, 180), '', '', 5, 5, 5, 5, 5, 5);
						//$mpdf->_setPageSize(array(70,180),'P');
						//$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
						//$mpdf->AddPage();
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);

					}

					if ($data['LoadInfo']->BookingType == 2) {

						$data1['tickets'] = $this->Booking_model->BookingTicketInfo($data['LoadInfo']->TicketID);

						$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
							<div style="width:100%;float: left;" >    
								<b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
								<b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
								<b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
								<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
								<b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>		 
								<b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>		   
								<b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
								<b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
								<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> 
								<b>Driver Signature: </b> <br> 
								<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>
								<b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
								<b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
								<b>Material: </b> ' . $data1['tickets']['MaterialName'] . ' <br> 
								<b>SIC Code: </b> ' . $data1['tickets']['SicCode'] . ' <br> 
								<b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>		 
								<b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
								<b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
								<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
							<div style="width:100%;float: left;" > 
								<b>Received By: </b><br> 
								<div><img src="/uploads/Signature/' . $Signature . '" width ="100" height="40" style="float:left"></div> 
								' . $data['LoadInfo']->CustomerName . ' 
								<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

						$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $TicketUniqueID . ".pdf";
						$mpdf = new mPDF('utf-8', array(70, 210), '', '', 5, 5, 5, 5, 5, 5);
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);

					}

					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
				}

				redirect('Loads');
			}
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Stage Update to Left Site';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/BookingStageLeftSite", $this->global, $data, NULL);
		}
	}
	function BookingStageFinishLoad($LoadID)
	{
		exit;
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			$conditions = array('LoadID ' => $LoadID);
			$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo($LoadID);
			if ($data['LoadInfo']->Status != 3) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$JobEndDateTime = date("Y-m-d H:i:s");
				$Notes = $this->security->xss_clean($this->input->post('Notes'));
				$GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
				$TipNumber = $this->security->xss_clean($this->input->post('TipNumber'));

				$LoadInfo = array(
					'JobEndDateTime' => $JobEndDateTime,
					'Notes' => $Notes,
					'Status' => 4,
					'GrossWeight' => $GrossWeight,
					'TipNumber' => $TipNumber
				);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads", $LoadInfo, $cond);
				if ($update) {
					if ($data['LoadInfo']->LoadType == 2) {

						if (isset($_POST['continue'])) {
							$TicketID = 0;
							$TicketUniqueID = "";

							$LID = $this->generateRandomString();

							$BDate = date('Y-m-d');
							$insertBookingDate = $this->db->query("insert into tbl_booking_date(BookingID,BookingDate) value('" . $data['LoadInfo']->BookingID . "','" . $BDate . "')");
							$BookingDateID = $this->db->insert_id();

							$LastConNumber = $this->Booking_model->LastConNumber();
							$LConveyanceNo = $LastConNumber['ConveyanceNo'] + 1;

							$LoadInfo = array(
								'LID' => $LID,
								'BookingID' => $data['LoadInfo']->BookingID,
								'BookingDateID' => $BookingDateID,
								'ConveyanceNo' => $LConveyanceNo,
								'DriverID' => $data['LoadInfo']->DriverID,
								'DriverLoginID' => $data['LoadInfo']->DriverLoginID,
								'MaterialID' => $data['LoadInfo']->MaterialID,
								'AllocatedDateTime' => date('Y-m-d H:i:s'),
								'TipID' => $data['LoadInfo']->TipID,
								'Status' => 0,
								'AutoCreated' => 0,
								'CreatedBy' => $this->session->userdata['userId']
							);
							$result1 = $this->Common_model->insert("tbl_booking_loads", $LoadInfo);

							if ($data['LoadInfo']->LoadType == 2) {
								$TicketUniqueID = $this->generateRandomString();
								$TicketNumber = 1;
								$LastTicketNumber = $this->Booking_model->LastTicketNo();
								if ($LastTicketNumber) {
									$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
								}

								$ticketsInfo = array(
									'TicketUniqueID' => $TicketUniqueID,
									'TicketNumber' => $TicketNumber,
									'TicketDate' => date('Y-m-d H:i:s'),
									'LoadID' => $result1,
									'Conveyance' => $LConveyanceNo,
									'OpportunityID' => $data['LoadInfo']->OpportunityID,
									'CompanyID' => $data['LoadInfo']->CompanyID,
									'DriverName' => $data['LoadInfo']->lorry_driver_name,
									'RegNumber' => $data['LoadInfo']->lorry_RegNumber,
									'Hulller' => $data['LoadInfo']->Haulier,
									'Tare' => $data['LoadInfo']->lorry_tare,
									'driversignature' => $data['LoadInfo']->lorry_signature,
									'driver_id' => $data['LoadInfo']->DriverID,
									'MaterialID' => $data['LoadInfo']->MaterialID,
									'SicCode' => $data['LoadInfo']->SicCode,
									'CreateUserID' => $this->session->userdata['userId'],
									'CreateDate' => date('Y-m-d H:i:s'),
									'TypeOfTicket' => 'Out',
									'is_hold' => 1
								);
								$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);

								$LoadInfo1 = array('TicketID' => $TicketID, 'TicketUniqueID' => $TicketUniqueID);
								$cond1 = array('LoadID' => $result1);
								$update1 = $this->Common_model->update("tbl_booking_loads", $LoadInfo1, $cond1);
							}
						}
					}

					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
				}
				redirect('Loads');
			}
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Stage Update to Finish Load';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/BookingStageFinishLoad", $this->global, $data, NULL);
		}
	}

	function BookingStageFinishLoadNonApp($LoadID)
	{
		exit;
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			$conditions = array('LoadID ' => $LoadID);
			$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo($LoadID);
			//echo $data['LoadInfo']->Status;
			//exit;
			//if($data['LoadInfo']->Status!=1){ redirect('Loads'); }

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$JobEndDateTime = date("Y-m-d H:i:s");
				$Notes = $this->security->xss_clean($this->input->post('Notes'));

				$LoadInfo = array('JobEndDateTime' => $JobEndDateTime, 'Notes' => $Notes, 'Status' => 4);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads", $LoadInfo, $cond);
				if ($update) {
					if ($data['LoadInfo']->LoadType == 2) {
						if (isset($_POST['continue'])) {
							$LID = $this->generateRandomString();
							$BDate = date('Y-m-d');
							$insertBookingDate = $this->db->query("insert into tbl_booking_date(BookingID,BookingDate) value('" . $data['LoadInfo']->BookingID . "','" . $BDate . "')");
							$BookingDateID = $this->db->insert_id();

							$LastConNumber = $this->Booking_model->LastConNumber();
							$LConveyanceNo = $LastConNumber['ConveyanceNo'] + 1;

							$LoadInfo = array(
								'LID' => $LID,
								'BookingID' => $data['LoadInfo']->BookingID,
								'BookingDateID' => $BookingDateID,
								'ConveyanceNo' => $LConveyanceNo,
								'DriverID' => $data['LoadInfo']->DriverID,
								'DriverName' => $data['LoadInfo']->DriverName,
								'VehicleRegNo' => $data['LoadInfo']->VehicleRegNo,
								'MaterialID' => $data['LoadInfo']->MaterialID,
								'AllocatedDateTime' => date('Y-m-d H:i:s'),
								'TipID' => $data['LoadInfo']->TipID,
								'Status' => 1,
								'AutoCreated' => 0,
								'CreatedBy' => $this->session->userdata['userId']
							);
							$result1 = $this->Common_model->insert("tbl_booking_loads", $LoadInfo);
						}
					}

					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
				}
				redirect('Loads');
			}

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Stage Update to Finish Load';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/BookingStageFinishLoadNonApp", $this->global, $data, NULL);
		}
	}

	function BookingRequest1()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Request Listing new';
			$this->global['active_menu'] = 'bookings';

			$this->loadViews("Booking/BookingRequest1", $this->global, $data, NULL);
		}
	}
	function BookingPriceByPendingAJAX()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetBookingRequestPriceByPending();
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}

	function BookingPriceByApprovedAJAX()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetBookingRequestPriceByApproved();
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}

	function BookingPriceByAllAJAX()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetBookingRequestPriceByAll();
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
	function AjaxBookingsRequest1()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetBookingRequestData1();
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
	function AjaxBookingsRequest2()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetBookingRequestData2();
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
	function AjaxBookingsRequestArchived()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetBookingRequestDataArchived();
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}


	function BookingPriceByPending()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Request (Price By) Listing';
			$this->global['active_menu'] = 'bookingpriceby';

			$this->loadViews("Booking/BookingPriceByPending", $this->global, $data, NULL);
		}
	}

	function BookingPriceByApproved()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Request (Price By) Listing';
			$this->global['active_menu'] = 'bookingpriceby';

			$this->loadViews("Booking/BookingPriceByApproved", $this->global, $data, NULL);
		}
	}

	function BookingPriceByAll()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Request (Price By) Listing';
			$this->global['active_menu'] = 'bookingpriceby';

			$this->loadViews("Booking/BookingPriceByAll", $this->global, $data, NULL);
		}
	}

	function BookingRequest()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Request Listing';
			$this->global['active_menu'] = 'bookings';

			$this->loadViews("Booking/BookingRequest", $this->global, $data, NULL);
		}
	}
	function BookingRequestApproved()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Request Listing';
			$this->global['active_menu'] = 'bookings';

			$this->loadViews("Booking/BookingRequestApproved", $this->global, $data, NULL);
		}
	}
	function BookingRequestApprovedArchived()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Archived Approved Booking Request Listing';
			$this->global['active_menu'] = 'bookings';

			$this->loadViews("Booking/BookingRequestApprovedArchived", $this->global, $data, NULL);
		}
	}
	function AjaxBookingsRequest()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetBookingRequestData();
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}

	function AddBookingRequest()
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');
				$this->form_validation->set_rules('ContactMobile', 'Site Contact Mobile', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
					$CompName = $this->security->xss_clean($this->input->post('CompName'));

					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$OppoName = $this->security->xss_clean($this->input->post('OppoName'));
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));

					//$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber')); 
					//$OpenPO = $this->security->xss_clean($this->input->post('OpenPO')); 
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));

					if ($CompanyID == '0') {
						if (trim($CompanyName) == '') {
							$this->session->set_flashdata('error', 'Company Name Must Not be blank');
							redirect('BookingsRequest');
						}
						$CompanyID = $this->generateRandomString();
						$CompanyInfo = array('CompanyID' => $CompanyID, 'CompanyIDMapKey' => $CompanyID, 'CompanyName' => $CompanyName, 'status' => 1, 'CreateDate' => date('Y-m-d H:i:s'));
						$this->Common_model->insert("tbl_company", $CompanyInfo);
					}
					if ($OpportunityID == '0') {
						if (trim($Street1) == '' && trim($Town) == '' && trim($County) == '' && trim($PostCode) == '') {
							$this->session->set_flashdata('error', 'Opportunity Must Not be blank');
							redirect('BookingsRequest');
						}
						$OpportunityID = $this->generateRandomString();
						$OpportunityName = $Street1 . ", " . $Street2 . ", " . $Town . ", " . $County . ", " . $PostCode;
						$OppoName = $OpportunityName;
						$OppoInfo = array(
							'OpportunityID' => $OpportunityID,
							'OpportunityIDMapKey' => $OpportunityID,
							'OpportunityName' => $OpportunityName,
							'OpenDate' => date("Y-m-d"),
							'Street1' => $Street1,
							'Street2' => $Street2,
							'Town' => $Town,
							'County' => $County,
							'PostCode' => $PostCode,
							'Status' => 1
						);
						$this->Common_model->insert("tbl_opportunities", $OppoInfo);

						$CO = array('OpportunityID' => $OpportunityID, 'CompanyID' => $CompanyID);
						$this->Common_model->insert("tbl_company_to_opportunities", $CO);

						$LoadInfo = array('TipID' => '1', 'OpportunityID' => $OpportunityID, 'TipRefNo' => '', 'Status' => '0');
						$this->Common_model->insert("tbl_opportunity_tip", $LoadInfo);


					}
					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('BookingsRequest');
						}
						if (trim($ContactMobile) == '') {
							$this->session->set_flashdata('error', 'Contact Mobile Must Not be blank');
							redirect('BookingsRequest');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}

					$BookingInfo = array(
						'CompanyID' => $CompanyID,
						'CompanyName' => $CompName,
						'OpportunityID' => $OpportunityID,
						'OpportunityName' => $OppoName,
						'Street1' => $Street1,
						'Street2' => $Street2,
						'Town' => $Town,
						'County' => $County,
						'PostCode' => $PostCode,
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'BookedBy' => $this->session->userdata['userId'],
						'Status' => 1
					);
					$BookingRequestID = $this->Common_model->insert("tbl_booking_request", $BookingInfo);
					if ($BookingRequestID) {

						/* ========================================================================= */
						$LoadInfoJson = json_encode($BookingInfo);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_request',
							'PrimaryID' => $BookingRequestID,
							'UpdatedValue' => $LoadInfoJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'Add Booking Request',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ========================================================================= */


						for ($i = 0; $i < count($BookingType); $i++) {
							if ($BookingType[$i] != "" && $DescriptionofMaterial[$i] != "" && $BookingDateTime[$i] != "") {
								$OP = 0;
								if (is_null($OpenPO[$i])) {
									$OP = 0;
								} else {
									$OP = $OpenPO[$i];
								}

								$BookingInfo = array(
									'BookingRequestID' => $BookingRequestID,
									'BookingType' => $BookingType[$i],
									'MaterialID' => $DescriptionofMaterial[$i],
									'LoadType' => $LoadType[$i],
									'LorryType' => $LorryType[$i],
									'MaterialName' => $MaterialName[$i],
									'Loads' => $Loads[$i],
									'Days' => '1',
									'Price' => $Price[$i],
									'SICCode' => $SICCode[$i],
									'PurchaseOrderNo' => $PurchaseOrderNo[$i],
									'OpenPO' => $OP,
									'TotalAmount' => $TotalHidden[$i],
									'BookedBy' => $this->session->userdata['userId']
								);
								$BookingID = '';
								$BookingID = $this->Common_model->insert("tbl_booking1", $BookingInfo);
								if ($BookingID) {

									/* ========================================================================= */
									$LoadInfoJson = json_encode($BookingInfo);

									$SiteLogInfo = array(
										'TableName' => 'tbl_booking1',
										'PrimaryID' => $BookingID,
										'UpdatedValue' => $LoadInfoJson,
										'UpdatedByUserID' => $this->session->userdata['userId'],
										'SitePage' => 'Add Booking Request',
										'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
										'BrowserAgent' => getBrowserAgent(),
										'AgentString' => $this->agent->agent_string(),
										'UserPlatform' => $this->agent->platform()
									);
									$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
									/* ========================================================================= */


									$BDT = '';
									$BDT = explode(',', $BookingDateTime[$i]);
									$BookingDate = array();
									for ($j = 0; $j < count($BDT); $j++) {
										$B = '';
										$B = explode('/', $BDT[$j]);
										//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0]; 
										$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
									}
									sort($BookingDate);
									for ($k = 0; $k < count($BookingDate); $k++) {
										$BookingDateInfo = array(
											'BookingRequestID' => $BookingRequestID,
											'BookingID' => $BookingID,
											'BookingDate' => $BookingDate[$k],
											'ApproveLoads' => $Loads[$i],
											'BookedBy' => $this->session->userdata['userId']
										);
										$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
										if ($insDate) {

											/* ========================================================================= */
											$LoadInfoJson = json_encode($BookingDateInfo);

											$SiteLogInfo = array(
												'TableName' => 'tbl_booking_date1',
												'PrimaryID' => $insDate,
												'UpdatedValue' => $LoadInfoJson,
												'UpdatedByUserID' => $this->session->userdata['userId'],
												'SitePage' => 'Add Booking Request',
												'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
												'BrowserAgent' => getBrowserAgent(),
												'AgentString' => $this->agent->agent_string(),
												'UserPlatform' => $this->agent->platform()
											);
											$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
											/* ========================================================================= */

											if ($Price[$i] != '' && $Price[$i] != 0) {
												if ($k == 0) {
													$ProductInfo = array(
														'OpportunityID' => $OpportunityID,
														'MaterialID' => $DescriptionofMaterial[$i],
														'SICCode' => $SICCode[$i],
														'BookingDateID' => $insDate,
														'BookingID' => $BookingID,
														'DateRequired' => $BookingDate[$k],
														'UnitPrice' => $Price[$i],
														'LorryType' => $LorryType[$i],
														'PurchaseOrderNo' => $PurchaseOrderNo[$i],
														'Qty' => $Loads[$i],
														'PriceType' => '0',
														'CreateUserID' => $this->session->userdata['userId'],
														'EditUserID' => $this->session->userdata['userId']
													);
													$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

													/* ========================================================================= */
													$LoadInfoJson = json_encode($ProductInfo);

													$SiteLogInfo = array(
														'TableName' => 'tbl_product',
														'PrimaryID' => $PID,
														'UpdatedValue' => $LoadInfoJson,
														'UpdatedByUserID' => $this->session->userdata['userId'],
														'SitePage' => 'Add Booking Request',
														'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
														'BrowserAgent' => getBrowserAgent(),
														'AgentString' => $this->agent->agent_string(),
														'UserPlatform' => $this->agent->platform()
													);
													$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
													/* ========================================================================= */

												}
											}
										}
									}
								}
							}
						}
						$this->session->set_flashdata('success', 'Booking has been Added successfully');
					} else {
						$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');
					}
					redirect('BookingRequest');
				}
			}

			$data['company_list'] = $this->Common_model->CompanyList();
			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$data['county'] = $this->Common_model->get_all('county');
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : ADD Booking Request';
			$this->global['active_menu'] = 'addbooking';

			$this->loadViews("Booking/AddBookingRequest", $this->global, $data, NULL);
		}
	}

	function AddBookingRequestTonnage()
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');
				$this->form_validation->set_rules('ContactMobile', 'Site Contact Mobile', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
					$CompName = $this->security->xss_clean($this->input->post('CompName'));

					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$OppoName = $this->security->xss_clean($this->input->post('OppoName'));
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));

					//$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber')); 
					//$OpenPO = $this->security->xss_clean($this->input->post('OpenPO')); 
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));

					$TotalTon = $this->security->xss_clean($this->input->post('TotalTon'));
					$TonPerLoad = $this->security->xss_clean($this->input->post('TonPerLoad'));

					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));

					if ($CompanyID == '0') {
						if (trim($CompanyName) == '') {
							$this->session->set_flashdata('error', 'Company Name Must Not be blank');
							redirect('Bookings');
						}
						$CompanyID = $this->generateRandomString();
						$CompanyInfo = array('CompanyID' => $CompanyID, 'CompanyIDMapKey' => $CompanyID, 'CompanyName' => $CompanyName, 'status' => 1, 'CreateDate' => date('Y-m-d H:i:s'));
						$this->Common_model->insert("tbl_company", $CompanyInfo);
					}
					if ($OpportunityID == '0') {
						if (trim($Street1) == '' && trim($Town) == '' && trim($County) == '' && trim($PostCode) == '') {
							$this->session->set_flashdata('error', 'Opportunity Must Not be blank');
							redirect('Bookings');
						}
						$OpportunityID = $this->generateRandomString();
						$OpportunityName = $Street1 . ", " . $Street2 . ", " . $Town . ", " . $County . ", " . $PostCode;
						$OppoName = $OpportunityName;
						$OppoInfo = array(
							'OpportunityID' => $OpportunityID,
							'OpportunityIDMapKey' => $OpportunityID,
							'OpportunityName' => $OpportunityName,
							'OpenDate' => date("Y-m-d"),
							'Street1' => $Street1,
							'Street2' => $Street2,
							'Town' => $Town,
							'County' => $County,
							'PostCode' => $PostCode,
							'Status' => 1
						);
						$this->Common_model->insert("tbl_opportunities", $OppoInfo);

						$CO = array('OpportunityID' => $OpportunityID, 'CompanyID' => $CompanyID);
						$this->Common_model->insert("tbl_company_to_opportunities", $CO);

						$LoadInfo = array('TipID' => '1', 'OpportunityID' => $OpportunityID, 'TipRefNo' => '', 'Status' => '0');
						$this->Common_model->insert("tbl_opportunity_tip", $LoadInfo);


					}
					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('Bookings');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactIDMapKey' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}

					$BookingInfo = array(
						'CompanyID' => $CompanyID,
						'CompanyName' => $CompName,
						'OpportunityID' => $OpportunityID,
						'OpportunityName' => $OppoName,
						'Street1' => $Street1,
						'Street2' => $Street2,
						'Town' => $Town,
						'County' => $County,
						'PostCode' => $PostCode,
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'BookedBy' => $this->session->userdata['userId'],
						'Status' => 1
					);
					$BookingRequestID = $this->Common_model->insert("tbl_booking_request", $BookingInfo);
					if ($BookingRequestID) {

						/* ========================================================================= */
						$LoadInfoJson = json_encode($BookingInfo);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_request',
							'PrimaryID' => $BookingRequestID,
							'UpdatedValue' => $LoadInfoJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'Add Booking Request Tonnage',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ========================================================================= */


						for ($i = 0; $i < count($BookingType); $i++) {
							if ($BookingType[$i] != "" && $DescriptionofMaterial[$i] != "" && $BookingDateTime[$i] != "") {
								$OP = 0;
								if (is_null($OpenPO[$i])) {
									$OP = 0;
								} else {
									$OP = $OpenPO[$i];
								}

								$BookingInfo = array(
									'BookingRequestID' => $BookingRequestID,
									'BookingType' => $BookingType[$i],
									'MaterialID' => $DescriptionofMaterial[$i],
									'TonBook' => '1',
									'TotalTon' => $TotalTon[$i],
									'TonPerLoad' => $TonPerLoad[$i],
									'LoadType' => $LoadType[$i],
									'LorryType' => $LorryType[$i],
									'MaterialName' => $MaterialName[$i],
									'Loads' => $Loads[$i],
									'Days' => '1',
									'Price' => $Price[$i],
									'SICCode' => $SICCode[$i],
									'PurchaseOrderNo' => $PurchaseOrderNo[$i],
									'OpenPO' => $OP,
									'TotalAmount' => $TotalHidden[$i],
									'BookedBy' => $this->session->userdata['userId']
								);
								$BookingID = '';
								$BookingID = $this->Common_model->insert("tbl_booking1", $BookingInfo);
								if ($BookingID) {

									/* ========================================================================= */
									$LoadInfoJson = json_encode($BookingInfo);

									$SiteLogInfo = array(
										'TableName' => 'tbl_booking1',
										'PrimaryID' => $BookingID,
										'UpdatedValue' => $LoadInfoJson,
										'UpdatedByUserID' => $this->session->userdata['userId'],
										'SitePage' => 'Add Booking Request Tonnage',
										'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
										'BrowserAgent' => getBrowserAgent(),
										'AgentString' => $this->agent->agent_string(),
										'UserPlatform' => $this->agent->platform()
									);
									$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
									/* ========================================================================= */


									$BDT = '';
									$BDT = explode(',', $BookingDateTime[$i]);
									$BookingDate = array();
									for ($j = 0; $j < count($BDT); $j++) {
										$B = '';
										$B = explode('/', $BDT[$j]);
										//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0]; 
										$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
									}
									sort($BookingDate);
									for ($k = 0; $k < count($BookingDate); $k++) {
										$BookingDateInfo = array(
											'BookingRequestID' => $BookingRequestID,
											'BookingID' => $BookingID,
											'BookingDate' => $BookingDate[$k],
											'ApproveLoads' => $Loads[$i],
											'BookedBy' => $this->session->userdata['userId']
										);
										$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
										if ($insDate) {

											/* ========================================================================= */
											$LoadInfoJson = json_encode($BookingDateInfo);

											$SiteLogInfo = array(
												'TableName' => 'tbl_booking_date1',
												'PrimaryID' => $insDate,
												'UpdatedValue' => $LoadInfoJson,
												'UpdatedByUserID' => $this->session->userdata['userId'],
												'SitePage' => 'Add Booking Request Tonnage',
												'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
												'BrowserAgent' => getBrowserAgent(),
												'AgentString' => $this->agent->agent_string(),
												'UserPlatform' => $this->agent->platform()
											);
											$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
											/* ========================================================================= */


											if ($Price[$i] != '' && $Price[$i] != 0) {
												if ($k == 0) {
													$ProductInfo = array(
														'OpportunityID' => $OpportunityID,
														'MaterialID' => $DescriptionofMaterial[$i],
														'SICCode' => $SICCode[$i],
														'BookingDateID' => $insDate,
														'PriceType' => '1',
														'DateRequired' => $BookingDate[$k],
														'UnitPrice' => $Price[$i],
														'LorryType' => $LorryType[$i],
														'PurchaseOrderNo' => $PurchaseOrderNo[$i],
														'Qty' => $Loads[$i],
														'TotalTon' => $TotalTon[$i],
														'CreateUserID' => $this->session->userdata['userId'],
														'EditUserID' => $this->session->userdata['userId']
													);
													$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

													/* ========================================================================= */
													$LoadInfoJson = json_encode($ProductInfo);

													$SiteLogInfo = array(
														'TableName' => 'tbl_product',
														'PrimaryID' => $PID,
														'UpdatedValue' => $LoadInfoJson,
														'UpdatedByUserID' => $this->session->userdata['userId'],
														'SitePage' => 'Add Booking Request Tonnage',
														'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
														'BrowserAgent' => getBrowserAgent(),
														'AgentString' => $this->agent->agent_string(),
														'UserPlatform' => $this->agent->platform()
													);
													$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
													/* ========================================================================= */

												}
											}
										}
									}
								}
							}
						}
						$this->session->set_flashdata('success', 'Booking has been Added successfully');
					} else {
						$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');
					}
					redirect('BookingRequest');
				}
			}

			$data['company_list'] = $this->Common_model->CompanyList();
			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$data['county'] = $this->Common_model->get_all('county');
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : ADD Booking Request Tonnage';
			$this->global['active_menu'] = 'addbooking';

			$this->loadViews("Booking/AddBookingRequestTonnage", $this->global, $data, NULL);
		}
	}




	function EditBookingRequest($BookingRequestID)
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($BookingRequestID == null) {
				redirect('BookingRequest');
			}
			//echo $BookingRequestID ; 
			//exit;
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));

					//$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber')); 
					//$OpenPO = $this->security->xss_clean($this->input->post('OpenPO')); 
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingID = $this->security->xss_clean($this->input->post('BookingID'));
					$TotalLoadAllocated = $this->security->xss_clean($this->input->post('TotalLoadAllocated'));
					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));

					$TonBook = $this->security->xss_clean($this->input->post('TonBook'));
					//print_r($TonBook); exit;
//print_r($BookingDateTime); exit;
					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('Bookings');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactIDMapKey' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail);
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail);
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}

					$BookingInfo = array(
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'UpdatedBy' => $this->session->userdata['userId']
					);
					$cond = array('BookingRequestID' => $BookingRequestID);
					$isUpdate = $this->Common_model->update("tbl_booking_request", $BookingInfo, $cond);

					/* ========================================================================= */
					$LoadInfoJson = json_encode($BookingInfo);
					$condJson = json_encode($cond);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_request',
						'PrimaryID' => $BookingRequestID,
						'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'Edit Booking Request  ',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					/* ========================================================================= */

					//if($isUpdate){ 
					$BArray = array();
					foreach ($BookingID as $key => $value) {
						$BArray[] = $value;
					}
					//var_dump($_POST);  				 
					//exit;
					//echo count($BookingID);
					for ($i = 0; $i < count($BArray); $i++) {

						if ($TotalLoadAllocated[$BArray[$i]] == 0) {
							if ($BookingType[$BArray[$i]] != "" && $DescriptionofMaterial[$BArray[$i]] != "" && $BookingDateTime[$BArray[$i]] != "") {

								$OP = 0;
								if (is_null($OpenPO[$BArray[$i]])) {
									$OP = 0;
								} else {
									$OP = $OpenPO[$BArray[$i]];
								}

								$BookingInfo = array(
									'BookingType' => $BookingType[$BArray[$i]],
									'MaterialID' => $DescriptionofMaterial[$BArray[$i]],
									'LoadType' => $LoadType[$BArray[$i]],
									'LorryType' => $LorryType[$BArray[$i]],
									'MaterialName' => $MaterialName[$BArray[$i]],
									'Loads' => $Loads[$BArray[$i]],
									'Days' => '1',
									'Price' => $Price[$BArray[$i]],
									'SICCode' => $SICCode[$BArray[$i]],
									'PurchaseOrderNo' => $PurchaseOrderNo[$BArray[$i]],
									'OpenPO' => $OP,
									'TotalAmount' => $TotalHidden[$BArray[$i]],
									'UpdatedBy' => $this->session->userdata['userId'],
									'TonBook' => $TonBook[$BArray[$i]]
								);
								$cond1 = array('BookingID' => $BArray[$i]);
								$this->Common_model->update("tbl_booking1", $BookingInfo, $cond1);


								/* ========================================================================= */
								$LoadInfoJson = json_encode($BookingInfo);
								$condJson = json_encode($cond1);

								$SiteLogInfo = array(
									'TableName' => 'tbl_booking1',
									'PrimaryID' => $BArray[$i],
									'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
									'UpdatedByUserID' => $this->session->userdata['userId'],
									'SitePage' => 'Edit Booking Request  ',
									'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
									'BrowserAgent' => getBrowserAgent(),
									'AgentString' => $this->agent->agent_string(),
									'UserPlatform' => $this->agent->platform()
								);
								$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
								/* ========================================================================= */

								//if($BookingID){
								$Delte_Where = array('BookingID' => $BArray[$i]);
								$this->Common_model->delete("tbl_booking_date1", $Delte_Where);
								$this->Common_model->delete("tbl_product", $Delte_Where);

								$BDT = '';
								$BDT = explode(',', $BookingDateTime[$BArray[$i]]);
								$BookingDate = array();
								for ($j = 0; $j < count($BDT); $j++) {
									$B = '';
									$B = explode('/', $BDT[$j]);
									//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0] ; 
									$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
								}
								sort($BookingDate);
								for ($k = 0; $k < count($BookingDate); $k++) {
									$BookingDateInfo = array(
										'BookingRequestID' => $BookingRequestID,
										'BookingID' => $BArray[$i],
										'BookingDate' => $BookingDate[$k],
										'ApproveLoads' => $Loads[$BArray[$i]],
										'BookedBy' => $this->session->userdata['userId'],
										'UpdatedBy' => $this->session->userdata['userId']
									);
									$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
									if ($insDate) {

										/* ========================================================================= */
										$LoadInfoJson = json_encode($BookingDateInfo);

										$SiteLogInfo = array(
											'TableName' => 'tbl_booking_date1',
											'PrimaryID' => $insDate,
											'UpdatedValue' => $LoadInfoJson,
											'UpdatedByUserID' => $this->session->userdata['userId'],
											'SitePage' => 'Edit Booking Request  ',
											'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
											'BrowserAgent' => getBrowserAgent(),
											'AgentString' => $this->agent->agent_string(),
											'UserPlatform' => $this->agent->platform()
										);
										$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
										/* ========================================================================= */


										if ($Price[$BArray[$i]] != '' && $Price[$BArray[$i]] != 0) {
											if ($k == 0) {
												$ProductInfo = array(
													'OpportunityID' => $OpportunityID,
													'MaterialID' => $DescriptionofMaterial[$BArray[$i]],
													'SICCode' => $SICCode[$BArray[$i]],
													'BookingDateID' => $insDate,
													'BookingID' => $BArray[$i],
													'DateRequired' => $BookingDate[$k],
													'UnitPrice' => $Price[$BArray[$i]],
													'LorryType' => $LorryType[$BArray[$i]],
													'PurchaseOrderNo' => $PurchaseOrderNo[$BArray[$i]],
													'Qty' => $Loads[$BArray[$i]],
													'CreateUserID' => $this->session->userdata['userId'],
													'EditUserID' => $this->session->userdata['userId']
												);
												$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

												/* ========================================================================= */
												$LoadInfoJson = json_encode($ProductInfo);

												$SiteLogInfo = array(
													'TableName' => 'tbl_product',
													'PrimaryID' => $PID,
													'UpdatedValue' => $LoadInfoJson,
													'UpdatedByUserID' => $this->session->userdata['userId'],
													'SitePage' => 'Edit Booking Request Haulage',
													'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
													'BrowserAgent' => getBrowserAgent(),
													'AgentString' => $this->agent->agent_string(),
													'UserPlatform' => $this->agent->platform()
												);
												$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
												/* ========================================================================= */

											}
										}
									}
								}
								//} //if($BookingID){
							}
						}

					}

					$this->session->set_flashdata('success', 'Booking has been Updated successfully');
					//}else{
					//	$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');                 
					//}
					//exit;
					redirect('BookingRequest');
				}
			}

			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			$BookingReqInfo = array('BookingRequestID' => $BookingRequestID);
			$data['BookingRequest'] = $this->Common_model->select_where('tbl_booking_request', $BookingReqInfo);

			$data['OppoContact'] = $this->Booking_model->getContactsByOpportunity($data['BookingRequest']['OpportunityID']);

			$data['BookingDates'] = $this->Booking_model->GetBookingRequestDates($BookingRequestID);
			$data['CollectionMaterialList'] = $this->Booking_model->getMaterialList1('IN');
			$data['DeliveryMaterialList'] = $this->Booking_model->getMaterialList1('OUT');


			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Edit Booking Request';
			$this->global['active_menu'] = 'editbooking';

			$this->loadViews("Booking/EditBookingRequest", $this->global, $data, NULL);
		}
	}

	function EditBookingRequestTonnage($BookingRequestID)
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($BookingRequestID == null) {
				redirect('BookingRequest');
			}
			//echo $BookingRequestID ; 
			//exit;
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));

					//$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber')); 
					//$OpenPO = $this->security->xss_clean($this->input->post('OpenPO')); 
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$TotalTon = $this->security->xss_clean($this->input->post('TotalTon'));
					$TonPerLoad = $this->security->xss_clean($this->input->post('TonPerLoad'));

					$BookingID = $this->security->xss_clean($this->input->post('BookingID'));
					$TotalLoadAllocated = $this->security->xss_clean($this->input->post('TotalLoadAllocated'));
					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));
					$TonBook = $this->security->xss_clean($this->input->post('TonBook'));
					//print_r($TonBook); exit;
					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('Bookings');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactIDMapKey' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail);
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail);
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}

					$BookingInfo = array(
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'UpdatedBy' => $this->session->userdata['userId']
					);
					$cond = array('BookingRequestID' => $BookingRequestID);
					$isUpdate = $this->Common_model->update("tbl_booking_request", $BookingInfo, $cond);

					/* ========================================================================= */
					$LoadInfoJson = json_encode($BookingInfo);
					$condJson = json_encode($cond);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_request',
						'PrimaryID' => $BookingRequestID,
						'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'Edit Booking Request  ',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					/* ========================================================================= */


					//if($isUpdate){ 
					$BArray = array();
					foreach ($BookingID as $key => $value) {
						$BArray[] = $value;
					}


					//var_dump($_POST);  				 
					//var_dump($BArray);  				 

					//echo count($BookingID);
					for ($i = 0; $i < count($BArray); $i++) {

						if ($TotalLoadAllocated[$BArray[$i]] == 0) {
							if ($BookingType[$BArray[$i]] != "" && $DescriptionofMaterial[$BArray[$i]] != "" && $BookingDateTime[$BArray[$i]] != "") {
								$OP = 0;
								if (is_null($OpenPO[$BArray[$i]])) {
									$OP = 0;
								} else {
									$OP = $OpenPO[$BArray[$i]];
								}

								$BookingInfo = array(
									'BookingType' => $BookingType[$BArray[$i]],
									'MaterialID' => $DescriptionofMaterial[$BArray[$i]],
									'TotalTon' => $TotalTon[$BArray[$i]],
									'TonPerLoad' => $TonPerLoad[$BArray[$i]],
									'LoadType' => $LoadType[$BArray[$i]],
									'LorryType' => $LorryType[$BArray[$i]],
									'MaterialName' => $MaterialName[$BArray[$i]],
									'Loads' => $Loads[$BArray[$i]],
									'Days' => '1',
									'Price' => $Price[$BArray[$i]],
									'SICCode' => $SICCode[$BArray[$i]],
									'PurchaseOrderNo' => $PurchaseOrderNo[$BArray[$i]],
									'OpenPO' => $OP,
									'TotalAmount' => $TotalHidden[$BArray[$i]],
									'UpdatedBy' => $this->session->userdata['userId'],
									'TonBook' => $TonBook[$BArray[$i]]
								);
								$cond1 = array('BookingID' => $BArray[$i]);
								$this->Common_model->update("tbl_booking1", $BookingInfo, $cond1);


								/* ========================================================================= */
								$LoadInfoJson = json_encode($BookingInfo);
								$condJson = json_encode($cond1);

								$SiteLogInfo = array(
									'TableName' => 'tbl_booking1',
									'PrimaryID' => $BArray[$i],
									'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
									'UpdatedByUserID' => $this->session->userdata['userId'],
									'SitePage' => 'Edit Booking Request  ',
									'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
									'BrowserAgent' => getBrowserAgent(),
									'AgentString' => $this->agent->agent_string(),
									'UserPlatform' => $this->agent->platform()
								);
								$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
								/* ========================================================================= */


								//if($BookingID){
								$Delte_Where = array('BookingID' => $BArray[$i]);
								$this->Common_model->delete("tbl_booking_date1", $Delte_Where);

								$BDT = '';
								$BDT = explode(',', $BookingDateTime[$BArray[$i]]);
								$BookingDate = array();
								for ($j = 0; $j < count($BDT); $j++) {
									$B = '';
									$B = explode('/', $BDT[$j]);
									//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0] ; 
									$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
								}
								sort($BookingDate);
								for ($k = 0; $k < count($BookingDate); $k++) {
									//echo $Loads[$BArray[$i]];
									$BookingDateInfo = array(
										'BookingRequestID' => $BookingRequestID,
										'BookingID' => $BArray[$i],
										'BookingDate' => $BookingDate[$k],
										'ApproveLoads' => $Loads[$BArray[$i]],
										'BookedBy' => $this->session->userdata['userId'],
										'UpdatedBy' => $this->session->userdata['userId']
									);
									$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
									if ($insDate) {

										/* ========================================================================= */
										$LoadInfoJson = json_encode($BookingDateInfo);

										$SiteLogInfo = array(
											'TableName' => 'tbl_booking_date1',
											'PrimaryID' => $insDate,
											'UpdatedValue' => $LoadInfoJson,
											'UpdatedByUserID' => $this->session->userdata['userId'],
											'SitePage' => 'Edit Booking Request  ',
											'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
											'BrowserAgent' => getBrowserAgent(),
											'AgentString' => $this->agent->agent_string(),
											'UserPlatform' => $this->agent->platform()
										);
										$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
										/* ========================================================================= */

										if ($Price[$BArray[$i]] != '' && $Price[$BArray[$i]] != 0) {
											if ($k == 0) {
												$ProductInfo = array(
													'OpportunityID' => $OpportunityID,
													'MaterialID' => $DescriptionofMaterial[$BArray[$i]],
													'SICCode' => $SICCode[$BArray[$i]],
													'BookingDateID' => $insDate,
													'PriceType' => '1',
													'BookingID' => $BArray[$i],
													'DateRequired' => $BookingDate[$k],
													'UnitPrice' => $Price[$BArray[$i]],
													'LorryType' => $LorryType[$BArray[$i]],
													'PurchaseOrderNo' => $PurchaseOrderNo[$BArray[$i]],
													'Qty' => $Loads[$BArray[$i]],
													'TotalTon' => $TotalTon[$BArray[$i]],
													'CreateUserID' => $this->session->userdata['userId'],
													'EditUserID' => $this->session->userdata['userId']
												);
												$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

												/* ========================================================================= */
												$LoadInfoJson = json_encode($ProductInfo);

												$SiteLogInfo = array(
													'TableName' => 'tbl_product',
													'PrimaryID' => $PID,
													'UpdatedValue' => $LoadInfoJson,
													'UpdatedByUserID' => $this->session->userdata['userId'],
													'SitePage' => 'Edit Booking Request  ',
													'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
													'BrowserAgent' => getBrowserAgent(),
													'AgentString' => $this->agent->agent_string(),
													'UserPlatform' => $this->agent->platform()
												);
												$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
												/* ========================================================================= */

											}
										}
									}
								}
								//} //if($BookingID){
							}
						}

					}

					$this->session->set_flashdata('success', 'Booking has been Updated successfully');
					//}else{
					//	$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');                 
					//}
					//exit;
					redirect('BookingRequest');
				}
			}

			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			$BookingReqInfo = array('BookingRequestID' => $BookingRequestID);
			$data['BookingRequest'] = $this->Common_model->select_where('tbl_booking_request', $BookingReqInfo);

			$data['OppoContact'] = $this->Booking_model->getContactsByOpportunity($data['BookingRequest']['OpportunityID']);

			$data['BookingDates'] = $this->Booking_model->GetBookingRequestDates($BookingRequestID);
			$data['CollectionMaterialList'] = $this->Booking_model->getMaterialList('IN');
			$data['DeliveryMaterialList'] = $this->Booking_model->getMaterialList('OUT');


			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Edit Booking Request Tonnage';
			$this->global['active_menu'] = 'editbooking';

			$this->loadViews("Booking/EditBookingRequestTonnage", $this->global, $data, NULL);
		}
	}
	function ApproveBookingPrice()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingID = $this->input->post('BookingID');

			$con = array('BookingID' => $BookingID);
			$BookingInfo = array('PriceApproved' => '1', 'PriceApprovedBy' => $this->session->userdata['userId']);
			$result = $this->Common_model->update("tbl_booking1", $BookingInfo, $con);

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE, 'BookingID' => $BookingID)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}
		}
	}
	function ApproveBookingRequest()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingDateID = $this->input->post('BookingDateID');

			$con = array('BookingDateID' => $BookingDateID);
			$BookingInfo = array('BookingDateStatus' => '1', 'ApprovedBy' => $this->session->userdata['userId'], 'UpdatedBy' => $this->session->userdata['userId']);
			$result = $this->Common_model->update("tbl_booking_date1", $BookingInfo, $con);

			/* ========================================================================= */
			$LoadInfoJson = json_encode($BookingInfo);
			$condJson = json_encode($con);

			$SiteLogInfo = array(
				'TableName' => 'tbl_booking_date1',
				'PrimaryID' => $BookingDateID,
				'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
				'UpdatedByUserID' => $this->session->userdata['userId'],
				'SitePage' => 'Approve Booking Request  ',
				'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
				'BrowserAgent' => getBrowserAgent(),
				'AgentString' => $this->agent->agent_string(),
				'UserPlatform' => $this->agent->platform()
			);
			$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
			/* ========================================================================= */


			if ($result > 0) {
				echo (json_encode(array('status' => TRUE, 'BookingDateID' => $BookingDateID)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}
		}
	}

	public function AllocateBookingRequest()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$data['TodayBookingRecords'] = $this->Booking_model->TodayBookingRequests();
			//$data['OverdueBookingRecords'] = $this->Booking_model->OverdueBookingRequest();  
			$data['BookingRecords'] = $this->Booking_model->FutureBookingRequest();

			$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX1();
			$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();
			$data['LorryRecords'] = $this->Booking_model->LorryListAJAX1();
			$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList1();

			$data['TipRecords'] = $this->Booking_model->TipListAJAX();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Allocate Booking Request';
			$this->global['active_menu'] = 'bookingallocate';

			$this->loadViews("Booking/AllocateBookingRequest", $this->global, $data, NULL);
		}
	}


	public function AllocateBookingRequestFuture()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$data['BookingRecords'] = $this->Booking_model->FutureBookingRequest();

			$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX1();
			$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();
			$data['LorryRecords'] = $this->Booking_model->LorryListAJAX1();
			$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList1();

			$data['TipRecords'] = $this->Booking_model->TipListAJAX();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Future Allocate Booking Request';
			$this->global['active_menu'] = 'bookingallocate';

			$this->loadViews("Booking/AllocateBookingRequestFuture", $this->global, $data, NULL);
		}
	}
	public function AllocateBookingRequestOverdue()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$data['OverdueBookingRecords'] = $this->Booking_model->OverdueBookingRequest();

			$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX1();
			$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();
			$data['LorryRecords'] = $this->Booking_model->LorryListAJAX1();
			$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList1();

			$data['TipRecords'] = $this->Booking_model->TipListAJAX();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Overdue Allocate Booking Request';
			$this->global['active_menu'] = 'bookingallocate';

			$this->loadViews("Booking/AllocateBookingRequestOverdue", $this->global, $data, NULL);
		}
	}
	public function AllocateBookingRequestFinished()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Allocate Booking Request Finished';
			$this->global['active_menu'] = 'bookingallocate';

			$this->loadViews("Booking/AllocateBookingRequestFinished", $this->global, $data, NULL);
		}
	}
	public function AllocateBookingRequestFinishedArchived()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Archived Finished Allocation';
			$this->global['active_menu'] = 'bookingallocate';

			$this->loadViews("Booking/AllocateBookingRequestFinishedArchived", $this->global, $data, NULL);
		}
	}
	public function BookingPreInvoice()
	{
		//if($this->isView == 0){
		if ($this->isIApprove == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			//$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX1();  	 
			//$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();  	  
			//$data['LorryRecords'] = $this->Booking_model->LorryListAJAX1();  	
			//$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList1();  

			//$data['TipRecords'] = $this->Booking_model->TipListAJAX(); 

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Pre Invoice';
			$this->global['active_menu'] = 'bookingpreinvoice';

			$this->loadViews("Booking/BookingPreInvoice", $this->global, $data, NULL);
		}
	}
	public function MyBookingInvoice()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : My Booking Invoice';
			$this->global['active_menu'] = 'mybookinginvoice';

			$this->loadViews("Booking/MyBookingInvoice", $this->global, $data, NULL);
		}
	}

	public function BookingInvoice()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : All Booking Invoice';
			$this->global['active_menu'] = 'bookinginvoice';

			$this->loadViews("Booking/BookingInvoice", $this->global, $data, NULL);
		}
	}
	public function MyReadyBookingInvoice()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : My Ready to Booking Invoice';
			$this->global['active_menu'] = 'myreadybookinginvoice';

			$this->loadViews("Booking/MyReadyBookingInvoice", $this->global, $data, NULL);
		}
	}

	public function ReadyBookingInvoice()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : All Ready to Booking Invoice';
			$this->global['active_menu'] = 'allreadybookinginvoice';

			$this->loadViews("Booking/ReadyBookingInvoice", $this->global, $data, NULL);
		}
	}
	public function MyBookingPreInvoice()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : My Booking Pre Invoice';
			$this->global['active_menu'] = 'mybookingpreinvoice';

			$this->loadViews("Booking/MyBookingPreInvoice", $this->global, $data, NULL);
		}
	}
	function ShowUpdateBookingRequestAJAX()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['BookingID'] = $this->input->post('BookingID');
			$data['PendingLoads'] = $this->input->post('PendingLoads');
			$data['TotalLoads'] = $this->input->post('TotalLoads');
			//$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);    
			//var_dump($data);
			//exit; 
			$html = $this->load->view('Booking/ShowUpdateBookingRequestAJAX', $data, true);
			echo json_encode($html);
		}
	}

	function ShowAddBookingRequestAJAX()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['BookingID'] = $this->input->post('BookingID');
			$data['TotalLoads'] = $this->input->post('TotalLoads');
			//$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);    
			//var_dump($data);
			//exit; 
			$html = $this->load->view('Booking/ShowAddBookingRequestAJAX', $data, true);
			echo json_encode($html);
		}
	}

	function ShowUpdateBookingRequestAJAXPOST()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingID = $this->input->post('BookingID');
			$Loads = $this->input->post('Loads');

			$LoadInfo = array('Loads' => $Loads);
			$LoadCond = array('BookingID' => $BookingID);

			$result = $this->Common_model->update("tbl_booking1", $LoadInfo, $LoadCond);

			redirect('AllocateBookingRequest');
			//$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);    
			//var_dump($data);
			//exit; 

		}
	}

	function ShowAddBookingRequestAJAXPOST()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingID = $this->input->post('BookingID');
			$Loads = $this->input->post('Loads');
			$TotalLoads = $this->input->post('TotalLoads');
			$Loads = $Loads + $TotalLoads;

			if ($Loads > $TotalLoads) {

				$LoadInfo = array('Loads' => $Loads);
				$LoadCond = array('BookingID' => $BookingID);

				$result = $this->Common_model->update("tbl_booking1", $LoadInfo, $LoadCond);
				if ($result) {
					$this->session->set_flashdata('success', 'Booking Qty has been added successfully');
				} else {
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
				}
			} else {
				$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
			}

			redirect('AllocateBookingRequestFinished');
			//$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);    
			//var_dump($data);
			//exit; 

		}
	}
	function ShowLoadsDeleteBookingRequestAJAX()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['BookingDateID'] = $this->input->post('BookingDateID');
			$data['PendingLoads'] = $this->input->post('PendingLoads');
			//$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);    
			//var_dump($data);
			//exit; 
			$html = $this->load->view('Booking/ShowLoadsDeleteBookingRequestAJAX', $data, true);
			echo json_encode($html);
		}
	}
	function DeleteBookingRequestConfirm()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['BookingDateID'] = $this->input->post('BookingDateID');
			$data['BookingID'] = $this->input->post('BookingID');
			$data['BookingRequestID'] = $this->input->post('BookingRequestID');
			$data['CountLoads'] = $this->Booking_model->CountLoadsBookingDate($data['BookingDateID']);

			//var_dump($data);
			//exit; 
			$html = $this->load->view('Booking/DeleteBookingRequestConfirm', $data, true);
			echo json_encode($html);
		}
	}
	function ShowLoadsDeleteBookingRequestAJAXPOST()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingDateID = $this->input->post('BookingDateID');
			$CancelLoads = $this->input->post('CancelLoads');
			$PendingLoads = $this->input->post('PendingLoads');
			$CancelNote = $this->input->post('CancelNote');
			$LoadInfo = array('BookingDateStatus' => 1, 'CancelLoads' => $CancelLoads, 'CancelNote' => $CancelNote);
			$LoadCond = array('BookingDateID' => $BookingDateID);
			//var_dump($_POST);
			//exit;
			$result = $this->Common_model->update("tbl_booking_date1", $LoadInfo, $LoadCond);

			redirect('AllocateBookingRequest');
			//$data['Loads'] = $this->Booking_model->ShowLoads2($BookingDateID);    
			//var_dump($data);
			//exit; 

		}
	}
	function AllocateBookingRequestAJAX1()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			//var_dump($_POST);
			$data['BookingRequestID'] = $this->input->post('BookingRequestID');
			$data['BookingID'] = $this->input->post('BookingID');
			$data['BookingDateID'] = $this->input->post('BookingDateID');
			$data['BookingDate'] = $this->input->post('BookingDate');
			$data['LoadType'] = $this->input->post('LoadType');
			$data['PendingLoad'] = $this->input->post('PendingLoad');
			$data['BookingInfo'] = $this->Booking_model->GetBookingBasicInfo1($data['BookingDateID']);
			//var_dump($data['BookingInfo']);
			//echo $data['BookingInfo']['BookingType'];
			//exit;

			if ($data['BookingInfo']['BookingType'] == 1) {
				if ($data['BookingDate'] != "") {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverBookedRequestList($data['BookingDate']);
				} else {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTARequestList();
				}
			}
			if ($data['BookingInfo']['BookingType'] == 2) {
				if ($data['BookingDate'] != "") {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverBookedRequestList1($data['BookingDate']);
				} else {
					$data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTARequestList1();
				}
			}

			//$data['LorryRecords'] = $this->Booking_model->LorryListAJAX();  	     
			$data['LorryRecords'] = $this->Booking_model->LorryListAJAXNEW();

			//$data['TipRecords'] = $this->Booking_model->TipListAJAX(); 
			if ($data['BookingInfo']['BookingType'] == 4) {
				$data['TipRecords'] = $this->Booking_model->TipListHaulage($data['BookingInfo']['TipID']);
			} else {
				$data['TipRecords'] = $this->Booking_model->TipListAuthoAJAX($data['BookingInfo']['OpportunityID']);
			}
			//var_dump($data['TipRecords']);
			//exit;
			$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();
			$data['Loads'] = $this->Booking_model->ShowBookingRequestDateLoads($data['BookingDateID']);

			$html = $this->load->view('Booking/AllocateBookingRequestAjax1', $data, true);
			echo json_encode($html);

		}
	}

	function AllocateBookingRequestAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingRequestID = $this->input->post('BookingRequestID');
			$BookingID = $this->input->post('BookingID');
			$BookingDateID = $this->input->post('BookingDateID');
			$BookingDate = $this->input->post('BookingDate');
			$DriverID = $this->input->post('DriverID');
			$TipID = $this->input->post('TipID');
			$Qty = $this->input->post('Qty');
			$MaterialID = $this->input->post('MaterialID');
			$AllocatedDateTime = $this->input->post('AllocatedDateTime');
			$Loads = $this->input->post('Loads');
			$TotalLoads = $this->input->post('TotalLoads');
			$LID = $this->generateRandomString();
			if ($AllocatedDateTime == "") {
				$AllocatedDateTime = date('Y-m-d H:i:s');
			}

			$Booking = $this->Booking_model->GetBookingInfo1($BookingID);
			$Driver = $this->Booking_model->getLorryNoDetails($DriverID);
			$BTText = "";
			if ($Booking->BookingType == 1) {
				$BTText = "Collection";
			}
			if ($Booking->BookingType == 2) {
				$BTText = "Delivery";
			}
			if ($Booking->BookingType == 3) {
				$BTText = "DayWork";
			}
			if ($Booking->BookingType == 4) {
				$BTText = "Haulage";
			}


			$j = 0;
			for ($i = 1; $i <= $Qty; $i++) {
				if ($Booking->BookingType == 1) {
					$AllocatedLoads = $this->Common_model->CountLoads1($BookingDateID);
					//$cond = array( 'BookingDateID' => $BookingDateID);
					//$AllocatedLoads = $this->Common_model->select_count_where('tbl_booking_loads',$cond); 
				}
				if ($Booking->BookingType == 2) {
					$AllocatedLoads = $this->Common_model->CountLorry1($BookingDateID);
				}
				if ($TotalLoads != $AllocatedLoads) {

					$TicketID = 0;
					$TicketUniqueID = "";
					if ($Booking->BookingType == 2) {
						if ($TipID == 1) {
							//echo json_encode($Driver);
							//if($Driver->AppUser==0){
							$TicketUniqueID = $this->generateRandomString();
							$TicketNumber = 1;
							$LastTicketNumber = $this->Booking_model->LastTicketNo();
							if ($LastTicketNumber) {
								$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
							}

							$ticketsInfo = array(
								'TicketUniqueID' => $TicketUniqueID,
								'TicketNumber' => $TicketNumber,
								'TicketDate' => date('Y-m-d H:i:s'),
								'OpportunityID' => $Booking->OpportunityID,
								'CompanyID' => $Booking->CompanyID,
								'DriverName' => $Driver->DriverName,
								'RegNumber' => $Driver->RegNumber,
								'Hulller' => $Driver->Haulier,
								'Tare' => $Driver->Tare,
								'driversignature' => $Driver->ltsignature,
								'driver_id' => $DriverID,
								'MaterialID' => $Booking->MaterialID,
								'SicCode' => $Booking->LoadSICCODE,
								'CreateDate' => date('Y-m-d H:i:s'),
								'TypeOfTicket' => 'Out',
								'is_hold' => 1,
								'is_tml' => 1
							);
							$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);

							if ($TicketID) {
								$LoadInfoJson = json_encode($ticketsInfo);

								$SiteLogInfo = array(
									'TableName' => 'tbl_tickets',
									'PrimaryID' => $TicketID,
									'UpdatedValue' => $LoadInfoJson,
									'UpdatedByUserID' => $this->session->userdata['userId'],
									'SitePage' => 'Allocate ' . $BTText . ' Booking Harefield ',
									'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
									'BrowserAgent' => getBrowserAgent(),
									'AgentString' => $this->agent->agent_string(),
									'UserPlatform' => $this->agent->platform()
								);
								$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
							}



							//} 
						}
					} else if ($Booking->BookingType == 1) {
						if ($TipID == 1) {
							if ($Driver->AppUser == 1) {
								$TicketUniqueID = $this->generateRandomString();
								$TicketNumber = 1;
								$LastTicketNumber = $this->Booking_model->LastTicketNo();
								if ($LastTicketNumber) {
									$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
								}

								$ticketsInfo = array(
									'TicketUniqueID' => $TicketUniqueID,
									'TicketNumber' => $TicketNumber,
									'TicketDate' => date('Y-m-d H:i:s'),
									'OpportunityID' => $Booking->OpportunityID,
									'CompanyID' => $Booking->CompanyID,
									'DriverName' => $Driver->DriverName,
									'RegNumber' => $Driver->RegNumber,
									'Hulller' => $Driver->Haulier,
									'Tare' => $Driver->Tare,
									'driversignature' => $Driver->ltsignature,
									'driver_id' => $DriverID,
									'MaterialID' => $Booking->MaterialID,
									'SicCode' => $Booking->LoadSICCODE,
									'is_tml' => 1,
									'CreateDate' => date('Y-m-d H:i:s'),
									'TypeOfTicket' => 'In',
									'IsInBound' => 1
								);
								$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);

								if ($TicketID) {
									$LoadInfoJson = json_encode($ticketsInfo);

									$SiteLogInfo = array(
										'TableName' => 'tbl_tickets',
										'PrimaryID' => $TicketID,
										'UpdatedValue' => $LoadInfoJson,
										'UpdatedByUserID' => $this->session->userdata['userId'],
										'SitePage' => 'Allocate  ' . $BTText . '  Booking Harefield',
										'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
										'BrowserAgent' => getBrowserAgent(),
										'AgentString' => $this->agent->agent_string(),
										'UserPlatform' => $this->agent->platform()
									);
									$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
								}
							}
						}
					}

					$LastConNumber = $this->Booking_model->LastConNumber1();
					if ($LastConNumber) {
						$ConveyanceNo = $LastConNumber['ConveyanceNo'] + 1;
					} else {
						$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
						$ConveyanceNo = $data['content']['ConveyanceStart'];
					}
					$result1 = "";
					if ($Driver->AppUser == 1) {
						$status = 1;
						if ($Driver->RegNumber != "") {
							$RegNumber = $Driver->RegNumber;
						} else {
							$RegNumber = $Driver->ContractorLorryNo;
						}
					} else {
						$status = 0;
						$RegNumber = $Driver->RegNumber;
					}



					//'DriverLoginID'=>$Driver->DriverID , 
					$LoadInfo = array(
						'LID' => $LID,
						'BookingRequestID' => $BookingRequestID,
						'BookingID' => $BookingID,
						'BookingDateID' => $BookingDateID,
						'ConveyanceNo' => $ConveyanceNo,
						'TicketID' => $TicketID,
						'TicketUniqueID' => $TicketUniqueID,
						'DriverID' => $DriverID,
						'DriverName' => $Driver->DriverName,
						'VehicleRegNo' => $RegNumber,
						'LoadPrice' => $Booking->Price,
						'MaterialID' => $MaterialID,
						'AllocatedDateTime' => $AllocatedDateTime,
						'TipID' => $TipID,
						'Status' => $status,
						'AutoCreated' => 1,
						'CreatedBy' => $this->session->userdata['userId']
					);
					$result1 = $this->Common_model->insert("tbl_booking_loads1", $LoadInfo);


					if ($result1) {
						$LoadInfoJson = json_encode($LoadInfo);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_loads1',
							'PrimaryID' => $result1,
							'UpdatedValue' => $LoadInfoJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'Allocate  ' . $BTText . '  Booking ',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					}

					$Message = 'New load has been allocated';
					$this->Fcm_model->sendNotication($DriverID, $Message, 'noti');
					if ($TipID == 1) {
						if ($Booking->BookingType == 2) {
							$ticketsInfo1 = array('LoadID' => $result1, 'Conveyance' => $ConveyanceNo);
							$cond = array('TicketNo' => $TicketID);
							$Update = $this->Common_model->update("tbl_tickets", $ticketsInfo1, $cond);

							if ($Update) {
								$LoadInfoJson = json_encode($ticketsInfo1);
								$condJson = json_encode($cond);

								$SiteLogInfo = array(
									'TableName' => 'tbl_tickets',
									'PrimaryID' => $TicketID,
									'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
									'UpdatedByUserID' => $this->session->userdata['userId'],
									'SitePage' => 'Allocate  ' . $BTText . '  Booking Harefield == Update  Conveyance in Ticket ',
									'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
									'BrowserAgent' => getBrowserAgent(),
									'AgentString' => $this->agent->agent_string(),
									'UserPlatform' => $this->agent->platform()
								);
								$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
							}

						} else if ($Booking->BookingType == 1) {
							if ($Driver->AppUser == 1) {
								$ticketsInfo1 = array('LoadID' => $result1, 'Conveyance' => $ConveyanceNo);
								$cond = array('TicketNo' => $TicketID);
								$Update = $this->Common_model->update("tbl_tickets", $ticketsInfo1, $cond);

								if ($Update) {
									$LoadInfoJson = json_encode($ticketsInfo1);
									$condJson = json_encode($cond);

									$SiteLogInfo = array(
										'TableName' => 'tbl_tickets',
										'PrimaryID' => $TicketID,
										'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
										'UpdatedByUserID' => $this->session->userdata['userId'],
										'SitePage' => 'Allocate  ' . $BTText . '  Booking Harefield == Update  Conveyance in Ticket ',
										'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
										'BrowserAgent' => getBrowserAgent(),
										'AgentString' => $this->agent->agent_string(),
										'UserPlatform' => $this->agent->platform()
									);
									$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
								}

							}
						}

					}

					if ($result1 > 0) {
						$j = $j + 1;
						//$this->Booking_model->BookingDateAllocatedLoadPlus($BookingDateID);  
					}
					################################################ 

				} else {
					echo (json_encode(array('status' => FALSE, 'status1' => 1111)));
				}
			} // For 

			if ($j > 0) {
				if ((int) $Loads > 0) {
					(int) $Loads = (int) $Loads - $j;
				} else {
					(int) $Loads = 0;
				}
				$data['Loads'] = $this->Booking_model->ShowBookingDateLoads1($BookingDateID);
				$ShowLoads = $this->load->view('Booking/AllAllocatedAJAX', $data, true);
				echo (json_encode(array('status' => TRUE, 'ShowLoads' => $ShowLoads, 'loads' => $Loads, 'Alloloads' => $j, 'BookingType' => $Booking->BookingType, 'LoadType' => $Booking->LoadType, 'BookingDateID' => $BookingDateID, 'BookingDate' => $BookingDate)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}
	function _OLD_AllocateBookingRequestAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingRequestID = $this->input->post('BookingRequestID');
			$BookingID = $this->input->post('BookingID');
			$BookingDateID = $this->input->post('BookingDateID');
			$BookingDate = $this->input->post('BookingDate');
			$DriverID = $this->input->post('DriverID');
			$TipID = $this->input->post('TipID');
			$Qty = $this->input->post('Qty');
			$MaterialID = $this->input->post('MaterialID');
			$AllocatedDateTime = $this->input->post('AllocatedDateTime');
			$Loads = $this->input->post('Loads');
			$TotalLoads = $this->input->post('TotalLoads');
			$LID = $this->generateRandomString();
			if ($AllocatedDateTime == "") {
				$AllocatedDateTime = date('Y-m-d H:i:s');
			}

			$Booking = $this->Booking_model->GetBookingInfo1($BookingID);
			$Driver = $this->Booking_model->getLorryNoDetails($DriverID);
			$j = 0;
			for ($i = 1; $i <= $Qty; $i++) {
				if ($Booking->BookingType == 1) {
					$AllocatedLoads = $this->Common_model->CountLoads1($BookingDateID);
					//$cond = array( 'BookingDateID' => $BookingDateID);
					//$AllocatedLoads = $this->Common_model->select_count_where('tbl_booking_loads',$cond); 
				}
				if ($Booking->BookingType == 2) {
					$AllocatedLoads = $this->Common_model->CountLorry1($BookingDateID);
				}
				if ($TotalLoads != $AllocatedLoads) {

					$TicketID = 0;
					$TicketUniqueID = "";
					if ($Booking->BookingType == 2) {
						if ($TipID == 1) {
							//echo json_encode($Driver);
							//if($Driver->AppUser==0){
							$TicketUniqueID = $this->generateRandomString();
							$TicketNumber = 1;
							$LastTicketNumber = $this->Booking_model->LastTicketNo();
							if ($LastTicketNumber) {
								$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
							}

							$ticketsInfo = array(
								'TicketUniqueID' => $TicketUniqueID,
								'TicketNumber' => $TicketNumber,
								'TicketDate' => date('Y-m-d H:i:s'),
								'OpportunityID' => $Booking->OpportunityID,
								'CompanyID' => $Booking->CompanyID,
								'DriverName' => $Driver->DriverName,
								'RegNumber' => $Driver->RegNumber,
								'Hulller' => $Driver->Haulier,
								'Tare' => $Driver->Tare,
								'driversignature' => $Driver->ltsignature,
								'driver_id' => $DriverID,
								'MaterialID' => $Booking->MaterialID,
								'SicCode' => $Booking->LoadSICCODE,
								'CreateDate' => date('Y-m-d H:i:s'),
								'TypeOfTicket' => 'Out',
								'is_hold' => 1,
								'is_tml' => 1
							);
							$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);
							//} 
						}
					} else if ($Booking->BookingType == 1) {
						if ($TipID == 1) {
							if ($Driver->AppUser == 1) {
								$TicketUniqueID = $this->generateRandomString();
								$TicketNumber = 1;
								$LastTicketNumber = $this->Booking_model->LastTicketNo();
								if ($LastTicketNumber) {
									$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
								}

								$ticketsInfo = array(
									'TicketUniqueID' => $TicketUniqueID,
									'TicketNumber' => $TicketNumber,
									'TicketDate' => date('Y-m-d H:i:s'),
									'OpportunityID' => $Booking->OpportunityID,
									'CompanyID' => $Booking->CompanyID,
									'DriverName' => $Driver->DriverName,
									'RegNumber' => $Driver->RegNumber,
									'Hulller' => $Driver->Haulier,
									'Tare' => $Driver->Tare,
									'driversignature' => $Driver->ltsignature,
									'driver_id' => $DriverID,
									'MaterialID' => $Booking->MaterialID,
									'SicCode' => $Booking->LoadSICCODE,
									'is_tml' => 1,
									'CreateDate' => date('Y-m-d H:i:s'),
									'TypeOfTicket' => 'In',
									'IsInBound' => 1
								);
								$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);
							}
						}
					}

					$LastConNumber = $this->Booking_model->LastConNumber1();
					if ($LastConNumber) {
						$ConveyanceNo = $LastConNumber['ConveyanceNo'] + 1;
					} else {
						$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
						$ConveyanceNo = $data['content']['ConveyanceStart'];
					}
					$result1 = "";
					if ($Driver->AppUser == 1) {
						$status = 1;
						if ($Driver->RegNumber != "") {
							$RegNumber = $Driver->RegNumber;
						} else {
							$RegNumber = $Driver->ContractorLorryNo;
						}
					} else {
						$status = 0;
						$RegNumber = $Driver->RegNumber;
					}
					//'DriverLoginID'=>$Driver->DriverID , 
					$LoadInfo = array(
						'LID' => $LID,
						'BookingRequestID' => $BookingRequestID,
						'BookingID' => $BookingID,
						'BookingDateID' => $BookingDateID,
						'ConveyanceNo' => $ConveyanceNo,
						'TicketID' => $TicketID,
						'TicketUniqueID' => $TicketUniqueID,
						'DriverID' => $DriverID,
						'DriverName' => $Driver->DriverName,
						'VehicleRegNo' => $RegNumber,
						'LoadPrice' => $Booking->Price,
						'MaterialID' => $MaterialID,
						'AllocatedDateTime' => $AllocatedDateTime,
						'TipID' => $TipID,
						'Status' => $status,
						'AutoCreated' => 1,
						'CreatedBy' => $this->session->userdata['userId']
					);
					$result1 = $this->Common_model->insert("tbl_booking_loads1", $LoadInfo);

					$Message = 'New load has been allocated';
					$this->Fcm_model->sendNotication($DriverID, $Message, 'noti');
					if ($TipID == 1) {
						if ($Booking->BookingType == 2) {
							$ticketsInfo1 = array('LoadID' => $result1, 'Conveyance' => $ConveyanceNo);
							$cond = array('TicketNo' => $TicketID);
							$this->Common_model->update("tbl_tickets", $ticketsInfo1, $cond);
						} else if ($Booking->BookingType == 1) {
							if ($Driver->AppUser == 1) {
								$ticketsInfo1 = array('LoadID' => $result1, 'Conveyance' => $ConveyanceNo);
								$cond = array('TicketNo' => $TicketID);
								$this->Common_model->update("tbl_tickets", $ticketsInfo1, $cond);
							}
						}

					}

					if ($result1 > 0) {
						$j = $j + 1;
						//$this->Booking_model->BookingDateAllocatedLoadPlus($BookingDateID);  
					}
					################################################ 

				} else {
					echo (json_encode(array('status' => FALSE, 'status1' => 1111)));
				}
			} // For 

			if ($j > 0) {
				if ((int) $Loads > 0) {
					(int) $Loads = (int) $Loads - $j;
				} else {
					(int) $Loads = 0;
				}
				$data['Loads'] = $this->Booking_model->ShowBookingDateLoads1($BookingDateID);
				$ShowLoads = $this->load->view('Booking/AllAllocatedAJAX', $data, true);
				echo (json_encode(array('status' => TRUE, 'ShowLoads' => $ShowLoads, 'loads' => $Loads, 'Alloloads' => $j, 'BookingType' => $Booking->BookingType, 'LoadType' => $Booking->LoadType, 'BookingDateID' => $BookingDateID, 'BookingDate' => $BookingDate)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}

	function AddTicketBookingRequestAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			//var_dump($_POST);
			$data['BookingRequestID'] = $this->input->post('BookingRequestID');
			$data['OpportunityID'] = $this->input->post('OpportunityID');
			$data['CompanyID'] = $this->input->post('CompanyID');

			$data['Bookings'] = $this->Booking_model->NonAppBookingDetails($data['BookingRequestID'], '1');
			$data['Material'] = $this->Booking_model->GetMaterialList('IN');
			$data['TipRecords'] = $this->Booking_model->TipListAuthoAJAX($data['OpportunityID']);
			//var_dump($data['TipRecords']);
			//exit;
			$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();

			$html = $this->load->view('Booking/AllocateNonAppBookingRequestAjax1', $data, true);
			echo json_encode($html);

		}
	}
	function AddDeliveryTicketBookingRequestAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			//var_dump($_POST);
			$data['BookingRequestID'] = $this->input->post('BookingRequestID');
			$data['OpportunityID'] = $this->input->post('OpportunityID');
			$data['CompanyID'] = $this->input->post('CompanyID');

			$data['Bookings'] = $this->Booking_model->NonAppBookingDetails($data['BookingRequestID'], '2');
			$data['Material'] = $this->Booking_model->GetMaterialList('OUT');

			$data['TipRecords'] = $this->Booking_model->TipListAuthoAJAX($data['OpportunityID']);
			//var_dump($data['TipRecords']);
			//exit;
			$data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();

			$html = $this->load->view('Booking/AllocateDeliveryNonAppBookingRequestAjax1', $data, true);
			echo json_encode($html);

		}
	}
	function NonAppCreateTicketAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			$data['BookingRequestID'] = $this->input->post('BookingRequestID');
			$data['DriverID'] = $this->input->post('DriverID');
			$data['Booking'] = $this->input->post('Booking');
			$data['TipID'] = $this->input->post('TipID');
			$data['NonAppConveyanceNo'] = $this->input->post('NonAppConveyanceNo');
			$data['ConveyanceDate'] = $this->input->post('ConveyanceDate');
			$data['MaterialID'] = $this->input->post('MaterialID');
			$data['GrossWeight'] = $this->input->post('GrossWeight');
			$data['TicketNo'] = $this->input->post('TicketNo');
			$data['TicketNumber'] = $this->input->post('TipTicketNo');
			$data['TipTicketDate'] = $this->input->post('TipTicketDate');
			$data['Remarks'] = $this->input->post('Remarks');

			$CD = explode("/", $data['ConveyanceDate']);
			$ConveyanceDate = $CD[2] . "-" . $CD[1] . "-" . $CD[0];

			$TD = explode("/", $data['TipTicketDate']);
			$TipTicketDate = $TD[2] . "-" . $TD[1] . "-" . $TD[0];

			$D = explode("|", $data['DriverID']);
			$DriverID = $D[0];
			$Tare = $D[1];
			$Net = $data['GrossWeight'] - $Tare;
			$B = explode("|", $data['Booking']);
			$BookingID = $B[0];
			$BookingDateID = $B[1];
			if ($data['MaterialID'] != "") {
				$MaterialID = $data['MaterialID'];
			} else {
				$MaterialID = $B[2];
			}

			$LID = $this->generateRandomString();
			$AllocatedDateTime = date('Y-m-d H:i:s');

			$Driver = $this->Booking_model->getLorryNoDetails($DriverID);
			$LastConNumber = $this->Booking_model->LastConNumber1();
			if ($LastConNumber) {
				$ConveyanceNo = $LastConNumber['ConveyanceNo'] + 1;
			}

			$Result = "";

			$LoadInfo = array(
				'LID' => $LID,
				'BookingRequestID' => $data['BookingRequestID'],
				'BookingID' => $BookingID,
				'TicketID' => $data['TicketNo'],
				'BookingDateID' => $BookingDateID,
				'ConveyanceNo' => $ConveyanceNo,
				'NonAppConveyanceNo' => $data['NonAppConveyanceNo'],
				'JobStartDateTime' => $ConveyanceDate,
				'JobEndDateTime' => $ConveyanceDate,
				'SiteInDateTime' => $ConveyanceDate,
				'SiteOutDateTime' => $ConveyanceDate,
				'PortalUpdate' => '1',
				'DriverID' => $DriverID,
				'DriverName' => $Driver->DriverName,
				'VehicleRegNo' => $Driver->RegNumber,
				'MaterialID' => $MaterialID,
				'AllocatedDateTime' => $AllocatedDateTime,
				'TipID' => $data['TipID'],
				'GrossWeight' => $data['GrossWeight'],
				'Tare' => $Tare,
				'Net' => $Net,
				'Status' => 4,
				'AutoCreated' => 1,
				'CreatedBy' => $this->session->userdata['userId']
			);
			$Result = $this->Common_model->insert("tbl_booking_loads1", $LoadInfo);
			if ($Result) {
				if ($data['TicketNo'] != 0 && $data['TicketNo'] != '') {
					$Tinfo = array('LoadID' => $Result);
					$TCond = array('TicketNo' => $data['TicketNo']);
					$TResult = $this->Common_model->update("tbl_tickets", $Tinfo, $TCond);
				} else {
					$Cond = array('BookingRequestID' => $data['BookingRequestID']);
					$data['RequestInfo'] = $this->Common_model->select_where('tbl_booking_request', $Cond);

					$Cond2 = array('TipID' => $data['TipID']);
					$data['TipInfo'] = $this->Common_model->select_where('tbl_tipaddress', $Cond2);

					$Cond3 = array('MaterialID' => $MaterialID);
					$data['MaterialInfo'] = $this->Common_model->select_where('tbl_materials', $Cond3);

					$Tinfo = array(
						'LoadID' => $Result,
						'CompanyID' => $data['RequestInfo']['CompanyID'],
						'OpportunityID' => $data['RequestInfo']['OpportunityID'],
						'TipID ' => $data['TipID'],
						'SiteAddress' => $data['RequestInfo']['OpportunityName'],
						'DriverName' => $Driver->DriverName,
						'DriverID' => $DriverID,
						'MaterialName' => $data['MaterialInfo']['MaterialName'],
						'CreatedDateTime' => $TipTicketDate,
						'TipTicketNo' => $data['TicketNumber'],
						'TipRefNo' => $data['TipInfo']['PermitRefNo'],
						'Remarks' => $data['Remarks']
					);
					$TResult = $this->Common_model->insert("tbl_tipticket", $Tinfo);
				}
				echo (json_encode(array('status' => TRUE)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}

	function NonAppCreateDeliveryTicketAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			$data['BookingRequestID'] = $this->input->post('BookingRequestID');
			$data['DriverID'] = $this->input->post('DriverID');
			$data['Booking'] = $this->input->post('Booking');
			$data['TipID'] = $this->input->post('TipID');
			$data['MaterialID'] = $this->input->post('MaterialID');
			$data['GrossWeight'] = $this->input->post('GrossWeight');
			$data['TicketNo'] = $this->input->post('TicketNo');
			$data['TicketNumber'] = $this->input->post('TipTicketNo');
			$data['TipTicketDate'] = $this->input->post('TipTicketDate');
			$data['Remarks'] = $this->input->post('Remarks');

			$LI = $this->Booking_model->FetchLoadIDTickets($data['TicketNo']);
			if ($LI['LoadID'] != 0) {
				echo (json_encode(array('status' => FALSE, 'error' => '1')));
				exit;
			}

			$TD = explode("/", $data['TipTicketDate']);
			$TipTicketDate = $TD[2] . "-" . $TD[1] . "-" . $TD[0];

			$D = explode("|", $data['DriverID']);
			$DriverID = $D[0];
			$Tare = $D[1];
			$Net = $data['GrossWeight'] - $Tare;
			$B = explode("|", $data['Booking']);
			$BookingID = $B[0];
			$BookingDateID = $B[1];
			if ($data['MaterialID'] != "") {
				$MaterialID = $data['MaterialID'];
			} else {
				$MaterialID = $B[2];
			}

			$LID = $this->generateRandomString();
			$AllocatedDateTime = date('Y-m-d H:i:s');

			$Driver = $this->Booking_model->getLorryNoDetails($DriverID);
			$LastConNumber = $this->Booking_model->LastConNumber1();
			if ($LastConNumber) {
				$ConveyanceNo = $LastConNumber['ConveyanceNo'] + 1;
			}

			$Result = "";
			if ($data['TipID'] != '1') {
				$TipNumber = $data['TicketNumber'];
			} else {
				$TipNumber = '0';
			}

			$LoadInfo = array(
				'LID' => $LID,
				'BookingRequestID' => $data['BookingRequestID'],
				'BookingID' => $BookingID,
				'TicketID' => $data['TicketNo'],
				'BookingDateID' => $BookingDateID,
				'ConveyanceNo' => $ConveyanceNo,
				'JobStartDateTime' => $TipTicketDate,
				'JobEndDateTime' => $TipTicketDate,
				'SiteInDateTime' => $TipTicketDate,
				'SiteOutDateTime' => $TipTicketDate,
				'PortalUpdate' => '1',
				'TipNumber' => $TipNumber,
				'DriverID' => $DriverID,
				'DriverName' => $Driver->DriverName,
				'VehicleRegNo' => $Driver->RegNumber,
				'MaterialID' => $MaterialID,
				'AllocatedDateTime' => $AllocatedDateTime,
				'TipID' => $data['TipID'],
				'GrossWeight' => $data['GrossWeight'],
				'Tare' => $Tare,
				'Net' => $Net,
				'Status' => 4,
				'AutoCreated' => 1,
				'CreatedBy' => $this->session->userdata['userId']
			);
			$Result = $this->Common_model->insert("tbl_booking_loads1", $LoadInfo);
			if ($Result) {
				if ($data['TicketNo'] != 0 && $data['TicketNo'] != '') {
					$Tinfo = array('LoadID' => $Result);
					$TCond = array('TicketNo' => $data['TicketNo']);
					$TResult = $this->Common_model->update("tbl_tickets", $Tinfo, $TCond);
				} else {

				}
				echo (json_encode(array('status' => TRUE)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}

	function CreateInvoiceHoldLoadAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['HOLD'] = $this->input->post('HOLD');

			//$LoadID = explode(",",$data['HOLD']);	 

			//$Tinfo = array('Hold'=>1 ); 
			//$Cond = array( 'LoadID' => $LoadID  );  
			$Result = $this->Common_model->HoldLoadOnInvoice($data['HOLD']);

			if ($Result) {
				echo (json_encode(array('status' => TRUE)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}
	function HoldLoadAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');

			$Tinfo = array('Hold' => 1);
			$Cond = array('LoadID' => $LoadID);
			$result = $this->Common_model->update("tbl_booking_loads1", $Tinfo, $Cond);

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE, 'LoadID' => $LoadID)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}

	public function AjaxAllocatedBookingsRequest1()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocatedBookingRequestData1();
		$this->ajax->send($data);
	}
	public function AjaxAllocatedBookingsRequestArchived()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocatedBookingRequestDataArchived();
		$this->ajax->send($data);
	}
	public function AjaxPreInvoiceList()
	{
		if ($this->isIApprove == 1) {
			$this->load->library('ajax');
			$data = $this->Booking_model->GetPreInvoiceList();
			$this->ajax->send($data);
		}
	}

	public function AjaxMyInvoiceList()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetMyInvoiceList();
		$this->ajax->send($data);
	}

	public function AjaxInvoiceList()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetInvoiceList();
		$this->ajax->send($data);
	}

	public function AjaxMyReadyInvoiceList()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetMyReadyInvoiceList();
		$this->ajax->send($data);
	}

	public function AjaxReadyInvoiceList()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetReadyInvoiceList();
		$this->ajax->send($data);
	}

	public function AjaxMyPreInvoiceList()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetMyPreInvoiceList();
		$this->ajax->send($data);
	}

	function ShowRequestLoadsAJAX()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingDateID = $this->input->post('BookingDateID');

			//$data['Loads'] = $this->Booking_model->ShowLoads($BookingID); 
			$data['Loads'] = $this->Booking_model->ShowBookingRequestDateLoads($BookingDateID);
			//var_dump($data['Loads']);
			//exit; 
			$html = $this->load->view('Booking/RequestLoadInfoAjax', $data, true);
			echo json_encode($html);
		}
	}
	function AddNewLoad()
	{

		$ID = $this->input->post('id');
		$data['ID'] = $ID;

		//echo $html = $this->load->view('Booking/AddNewLoad', $data, true);  

		echo '<tr id="' . $ID . '" ><td><select class="form-control BookingType" id="BookingType' . $ID . '" data-BID="' . $ID . '" name="BookingType[]" required="required"  ></select><div ></div></td> 
		<td><select class="form-control Material " id="DescriptionofMaterial' . $ID . '" name="DescriptionofMaterial[]" required="required" data-live-search="true"  ></select><div ></div></td> 
		<td><select class="form-control LoadType" id="LoadType' . $ID . '" name="LoadType[]" required="required"  > <option value="1">Loads</option><option value="2">TurnAround</option></select> </td> 
		<td><select class="form-control LorryType" id="LorryType' . $ID . '" name="LorryType[]"  data-live-search="true" ><option value="" >Select</option><option value="1" >Tipper</option><option value="2" >Grab</option><option value="3" >Bin</option></select></td> 
		<td><select class="form-control Loads" id="Loads' . $ID . '" name="Loads[]" required="required"   data-live-search="true" >  
		</select></td> 
		<td><div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control required BookingDateTime" data-BID="' . $ID . '" id="BookingDateTime' . $ID . '" autocomplete="off" value="" name="BookingDateTime[]" maxlength="65"></div><div ></div></td> 
		<td><input type="text" class="form-control Price" id="Price1" data-BID="' . $ID . '"    name="Price[]" value="" ><span id="pdate1" style="font-size:12px"></span></td> 
		<td><span id="Total1" style="font-size:12px"></span><input type="hidden" id="TotalHidden1"  name="TotalHidden[]"  > </td> </tr>';

		//echo json_encode($html); 

	}

	public function PendingLoads()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Not Started Loads/Lorry List ';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/PendingLoads", $this->global, $data, NULL);
		}
	}
	public function RequestLoads()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Request Loads/Lorry List ';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/RequestLoads", $this->global, $data, NULL);
		}
	}
	function NonAppGrossWeightUpdateAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');
			$Gross = $this->input->post('Gross');
			$Tare = $this->input->post('Tare');

			//$VAT = (($SubTotal[0]->TotalAmount*20)/100);
			$Net = $Gross - $Tare;

			$Tinfo = array('GrossWeight' => $Gross, 'Net' => $Net, 'Tare' => $Tare, 'PortalUpdate' => 1);
			$Cond = array('LoadID' => $LoadID);
			$result = $this->Common_model->update("tbl_booking_loads1", $Tinfo, $Cond);

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE, 'LoadID' => $LoadID, 'Net' => $Net)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}
	function FetchTicketFromConveyanceAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingRequestID = $this->input->post('BookingRequestID');
			$OpportunityID = $this->input->post('OpportunityID');
			$CompanyID = $this->input->post('CompanyID');
			$NonAppConveyanceNo = $this->input->post('NonAppConveyanceNo');
			$DriverID = $this->input->post('DriverID');
			$ConveyanceDate = $this->input->post('ConveyanceDate');

			$d = explode('|', $DriverID);

			$data['FetchTicketNumber'] = $this->Booking_model->FetchTicketNumber($NonAppConveyanceNo, $CompanyID, $OpportunityID, $ConveyanceDate, $d[0]);
			$p = $data['FetchTicketNumber']['pdf_name'];
			$pdf = "<a href='" . base_url("assets/pdf_file/" . $p) . "' target='_blank'>View Ticket</a>";

			if ($data['FetchTicketNumber']['TicketNo'] != '') {
				echo (json_encode(array('status' => TRUE, 'TicketNo' => $data['FetchTicketNumber']['TicketNo'], 'TicketNumber' => $data['FetchTicketNumber']['TicketNumber'], 'pdf' => $pdf)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}

	function FetchDeliveryTicketNoAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$TicketNumber = $this->input->post('TipTicketNo');

			$data['FetchTicketNumber'] = $this->Booking_model->FetchDeliveryTicketNumber($TicketNumber);

			$p = $data['FetchTicketNumber']['pdf_name'];
			$pdf = "<a href='" . base_url("assets/pdf_file/" . $p) . "' target='_blank'>View Ticket</a>";

			if ($data['FetchTicketNumber']['TicketNo'] != '') {
				echo (json_encode(array('status' => TRUE, 'TicketDate' => $data['FetchTicketNumber']['TicketDate'], 'TicketNo' => $data['FetchTicketNumber']['TicketNo'], 'GrossWeight' => $data['FetchTicketNumber']['GrossWeight'], 'TicketNumber' => $data['FetchTicketNumber']['TicketNumber'], 'pdf' => $pdf)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}
	function NonAppConveyanceUpdateAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');
			$NonAppConveyanceNo = $this->input->post('NonAppConveyanceNo');

			$Tinfo = array('NonAppConveyanceNo' => $NonAppConveyanceNo);
			$Cond = array('LoadID' => $LoadID);
			$result = $this->Common_model->update("tbl_booking_loads1", $Tinfo, $Cond);

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE, 'LoadID' => $LoadID)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}
	function NonAppConveyanceDateUpdateAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');
			$ConveyanceDate1 = $this->input->post('ConveyanceDate');

			$t = explode(' ', trim($ConveyanceDate1));
			$td = explode('-', trim($t[0]));
			$ConveyanceDate = $td[2] . "-" . $td[1] . "-" . $td[0] . " " . $t[1];

			$Tinfo = array(
				'SiteOutDateTime' => $ConveyanceDate,
				'SiteInDateTime' => $ConveyanceDate,
				'JobStartDateTime' => $ConveyanceDate,
				'JobEndDateTime' => $ConveyanceDate
			);
			$Cond = array('LoadID' => $LoadID);
			$result = $this->Common_model->update("tbl_booking_loads1", $Tinfo, $Cond);

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE, 'LoadID' => $LoadID)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}

	function NonAppStatusUpdateAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');

			$Tinfo = array('Status' => 4);
			$Cond = array('LoadID' => $LoadID);
			$result = $this->Common_model->update("tbl_booking_loads1", $Tinfo, $Cond);

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE, 'LoadID' => $LoadID)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}
	public function NonAppRequestLoads($BookingRequestID)
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();
			if ($BookingRequestID == "") {
				redirect('dashboard');
			}
			$data['BookingRequestID'] = $BookingRequestID;
			$Cond = array('BookingRequestID ' => $data['BookingRequestID']);
			$data['RequestInfo'] = $this->Common_model->select_where('tbl_booking_request', $Cond);
			$data['CountCollection'] = $this->Booking_model->GetCountCollectionBooking($data['BookingRequestID']);
			$data['CountDelivery'] = $this->Booking_model->GetCountDeliveryBooking($data['BookingRequestID']);

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Non App Request Loads/Lorry List ';
			$this->global['active_menu'] = 'nonapprequestloads';

			$this->loadViews("Booking/NonAppRequestLoads", $this->global, $data, NULL);
		}
	}

	public function AllNonAppRequestLoads()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Non App Request Loads/Lorry List ';
			$this->global['active_menu'] = 'allnonapprequestloads';

			$this->loadViews("Booking/AllNonAppRequestLoads", $this->global, $data, NULL);
		}
	}


	public function RequestLoadsFinished()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Finished Request Loads/Lorry List ';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/RequestLoadsFinished", $this->global, $data, NULL);
		}
	}
	public function RequestLoadsFinishedArchived()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Archived Finished Request Loads/Lorry List ';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/RequestLoadsFinishedArchived", $this->global, $data, NULL);
		}
	}

	public function RequestLoadsCancelled()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Cancelled Request Loads/Lorry List ';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/RequestLoadsCancelled", $this->global, $data, NULL);
		}
	}
	public function AjaxPendingLoads()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetRequestPendingLoadsData();
		$this->ajax->send($data);
	}

	public function AjaxRequestLoads()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetRequestLoadsData();
		$this->ajax->send($data);
	}

	public function NonAppRequestLoadsAJAX()
	{
		$this->load->library('ajax');

		$BookingRequestID = $this->input->post('BookingRequestID');

		//$data = $this->Booking_model->GetNonAppRequestLoadsData();   
		$data = $this->Booking_model->GetNonAppRequestLoadsData($BookingRequestID);
		$this->ajax->send($data);
	}
	public function AllNonAppRequestLoadsAJAX()
	{
		$this->load->library('ajax');
		//$data = $this->Booking_model->GetNonAppRequestLoadsData();   
		$data = $this->Booking_model->GetAllNonAppRequestLoadsData();
		$this->ajax->send($data);
	}

	public function AjaxRequestLoads1()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetRequestLoadsData1();
		$this->ajax->send($data);
	}
	public function AjaxRequestLoadsArchived()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetRequestLoadsDataArchived();
		$this->ajax->send($data);
	}

	public function AjaxRequestLoads2()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetRequestLoadsData2();
		$this->ajax->send($data);
	}

	function DeleteRequestLoad()
	{
		if ($this->isDelete == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');
			$LoadType = $this->input->post('LoadType');
			$BookingDateID = $this->input->post('BookingDateID');
			$con = array('LoadID' => $LoadID, 'Status' => '0');
			$result = $this->Common_model->delete('tbl_booking_loads1', $con);
			if ($result > 0) {
				//if($LoadType==1){ /*$this->Booking_model->BookingDateAllocatedLoadMinus($BookingDateID); */ }
				echo (json_encode(array('status' => TRUE)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}
		}
	}
	function CancelRequestLoad()
	{
		if ($this->isDelete == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$LoadID = $this->input->post('LoadID');
			$Notes = $this->input->post('confirmation');

			$ticketsInfo = array('Status' => '5', 'CancelNote' => $Notes, 'CancelDateTime' => date('Y-m-d H:i:s'), 'CancelBy' => $this->session->userdata['userId']);
			$con = array('LoadID' => $LoadID);
			$result = $this->Common_model->update("tbl_booking_loads1", $ticketsInfo, $con);

			if ($result > 0) {
				echo (json_encode(array('status' => TRUE)));
			} else {
				echo (json_encode(array('status' => FALSE)));
			}
		}
	}
	function BookingPriceByPendingTableMeta()
	{
		echo '{"Name":"tbl_booking","Deletable":false,"Action":true,"Insertable":false,"Column":[{"Name":"BookingRequestID","Title":"BNO","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingDate","Title":"Request Date","Editable":null,"Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Editable":null,"Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Editable":null,"Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Editable":null,"Searchable":true,"Class":null},{"Name":"TotalTon","Title":"Total Ton","Editable":null,"Searchable":true,"Class":null},{"Name":"TonPerLoad","Title":"Ton / Load","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingType","Title":"Booking Type","Editable":null,"Searchable":true,"Class":null},{"Name":"LoadType","Title":"Load Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Loads","Title":"Loads Lorry","Editable":null,"Searchable":true,"Class":null},{"Name":"LorryType","Title":"Lorry Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Editable":null,"Searchable":true,"Class":null},{"Name":"PurchaseOrderNumber","Title":"PON","Editable":null,"Searchable":true,"Class":null},{"Name":"Notes","Title":"Notes","Editable":null,"Searchable":true,"Class":null},{"Name":"BookedName","Title":"PriceBy","Editable":null,"Searchable":true,"Class":null},{"Name":"CreateDateTime","Title":"Created Datetime","Editable":null,"Searchable":true,"Class":null}]}';
	}

	function BookingPriceByApprovedTableMeta()
	{
		echo '{"Name":"tbl_booking","Deletable":false,"Action":true,"Insertable":false,"Column":[{"Name":"BookingRequestID","Title":"BNO","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingDate","Title":"Request Date","Editable":null,"Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Editable":null,"Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Editable":null,"Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Editable":null,"Searchable":true,"Class":null},{"Name":"TotalTon","Title":"Total Ton","Editable":null,"Searchable":true,"Class":null},{"Name":"TonPerLoad","Title":"Ton / Load","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingType","Title":"Booking Type","Editable":null,"Searchable":true,"Class":null},{"Name":"LoadType","Title":"Load Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Loads","Title":"Loads Lorry","Editable":null,"Searchable":true,"Class":null},{"Name":"LorryType","Title":"Lorry Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Editable":null,"Searchable":true,"Class":null},{"Name":"PurchaseOrderNumber","Title":"PON","Editable":null,"Searchable":true,"Class":null},{"Name":"Notes","Title":"Notes","Editable":null,"Searchable":true,"Class":null},{"Name":"BookedName","Title":"PriceBy","Editable":null,"Searchable":true,"Class":null},{"Name":"CreateDateTime","Title":"Created Datetime","Editable":null,"Searchable":true,"Class":null}]}';
	}

	function BookingPriceByAllTableMeta()
	{
		echo '{"Name":"tbl_booking","Deletable":false,"Action":true,"Insertable":false,"Column":[{"Name":"BookingRequestID","Title":"BNO","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingDate","Title":"Request Date","Editable":null,"Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Editable":null,"Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Editable":null,"Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Editable":null,"Searchable":true,"Class":null},{"Name":"TotalTon","Title":"Total Ton","Editable":null,"Searchable":true,"Class":null},{"Name":"TonPerLoad","Title":"Ton / Load","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingType","Title":"Booking Type","Editable":null,"Searchable":true,"Class":null},{"Name":"LoadType","Title":"Load Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Loads","Title":"Loads Lorry","Editable":null,"Searchable":true,"Class":null},{"Name":"LorryType","Title":"Lorry Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Editable":null,"Searchable":true,"Class":null},{"Name":"PurchaseOrderNumber","Title":"PON","Editable":null,"Searchable":true,"Class":null},{"Name":"Notes","Title":"Notes","Editable":null,"Searchable":true,"Class":null},{"Name":"BookedName","Title":"PriceBy","Editable":null,"Searchable":true,"Class":null},{"Name":"CreateDateTime","Title":"Created Datetime","Editable":null,"Searchable":true,"Class":null}]}';
	}

	function BookingRequestTableMeta()
	{
		//echo '{"Name":"tbl_booking","Deletable":false,"Action":true,"Insertable":false,"Column":[{"Name":"BookingRequestID","Title":"BNO","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingDate","Title":"Request Date","Editable":null,"Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Editable":null,"Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Editable":null,"Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingType","Title":"Booking Type","Editable":null,"Searchable":true,"Class":null},{"Name":"LoadType","Title":"Load Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Loads","Title":"Loads Lorry","Editable":null,"Searchable":true,"Class":null},{"Name":"LorryType","Title":"Lorry Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Notes","Title":"Notes","Editable":null,"Searchable":true,"Class":null},{"Name":"BookedName","Title":"Created By","Editable":null,"Searchable":true,"Class":null},{"Name":"CreateDateTime","Title":"Created Datetime","Editable":null,"Searchable":true,"Class":null}]}'; 
		//echo '{"Name":"tbl_booking","Deletable":false,"Action":true,"Insertable":false,"Column":[{"Name":"BookingRequestID","Title":"BNO","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingDate","Title":"Request Date","Editable":null,"Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Editable":null,"Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Editable":null,"Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Editable":null,"Searchable":true,"Class":null},{"Name":"TotalTon","Title":"Total Ton","Editable":null,"Searchable":true,"Class":null},{"Name":"TonPerLoad","Title":"Ton / Load","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingType","Title":"Booking Type","Editable":null,"Searchable":true,"Class":null},{"Name":"LoadType","Title":"Load Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Loads","Title":"Loads Lorry","Editable":null,"Searchable":true,"Class":null},{"Name":"LorryType","Title":"Lorry Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Notes","Title":"Notes","Editable":null,"Searchable":true,"Class":null},{"Name":"BookedName","Title":"Created By","Editable":null,"Searchable":true,"Class":null},{"Name":"CreateDateTime","Title":"Created Datetime","Editable":null,"Searchable":true,"Class":null}]}'; 
		echo '{"Name":"tbl_booking","Deletable":false,"Action":true,"Insertable":false,"Column":[{"Name":"BookingRequestID","Title":"BNO","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingDate","Title":"Request Date","Editable":null,"Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Editable":null,"Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Editable":null,"Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Editable":null,"Searchable":true,"Class":null},{"Name":"TotalTon","Title":"Total Ton","Editable":null,"Searchable":true,"Class":null},{"Name":"TonPerLoad","Title":"Ton / Load","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingType","Title":"Booking Type","Editable":null,"Searchable":true,"Class":null},{"Name":"LoadType","Title":"Load Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Loads","Title":"Loads Lorry","Editable":null,"Searchable":true,"Class":null},{"Name":"LorryType","Title":"Lorry Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Editable":null,"Searchable":true,"Class":null},{"Name":"PurchaseOrderNo","Title":"PON","Editable":null,"Searchable":true,"Class":null},{"Name":"Notes","Title":"Notes","Editable":null,"Searchable":true,"Class":null},{"Name":"BookedName","Title":"Created By","Editable":null,"Searchable":true,"Class":null},{"Name":"CreateDateTime","Title":"Created Datetime","Editable":null,"Searchable":true,"Class":null}]}';
	}
	function BookingRequestTableMeta1()
	{
		//echo '{"Name":"tbl_booking","Deletable":false,"Action":true,"Insertable":false,"Column":[{"Name":"BookingRequestID","Title":"BNO","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingDate","Title":"Request Date","Editable":null,"Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Editable":null,"Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Editable":null,"Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingType","Title":"Booking Type","Editable":null,"Searchable":true,"Class":null},{"Name":"LoadType","Title":"Load Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Loads","Title":"Loads Lorry","Editable":null,"Searchable":true,"Class":null},{"Name":"LorryType","Title":"Lorry Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Notes","Title":"Notes","Editable":null,"Searchable":true,"Class":null},{"Name":"BookedName","Title":"Created By","Editable":null,"Searchable":true,"Class":null},{"Name":"CreateDateTime","Title":"Created Datetime","Editable":null,"Searchable":true,"Class":null}]}'; 
		//echo '{"Name":"tbl_booking","Deletable":false,"Action":true,"Insertable":false,"Column":[{"Name":"BookingRequestID","Title":"BNO","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingDate","Title":"Request Date","Editable":null,"Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Editable":null,"Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Editable":null,"Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Editable":null,"Searchable":true,"Class":null},{"Name":"TotalTon","Title":"Total Ton","Editable":null,"Searchable":true,"Class":null},{"Name":"TonPerLoad","Title":"Ton / Load","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingType","Title":"Booking Type","Editable":null,"Searchable":true,"Class":null},{"Name":"LoadType","Title":"Load Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Loads","Title":"Loads Lorry","Editable":null,"Searchable":true,"Class":null},{"Name":"LorryType","Title":"Lorry Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Notes","Title":"Notes","Editable":null,"Searchable":true,"Class":null},{"Name":"BookedName","Title":"Created By","Editable":null,"Searchable":true,"Class":null},{"Name":"CreateDateTime","Title":"Created Datetime","Editable":null,"Searchable":true,"Class":null}]}'; 
		echo '{"Name":"tbl_booking","Deletable":false,"Action":true,"Insertable":false,"Column":[{"Name":"BookingRequestID","Title":"BNO","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingDate","Title":"Request Date","Editable":null,"Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Editable":null,"Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Editable":null,"Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Editable":null,"Searchable":true,"Class":null},{"Name":"TotalTon","Title":"Total Ton","Editable":null,"Searchable":true,"Class":null},{"Name":"TonPerLoad","Title":"Ton / Load","Editable":null,"Searchable":true,"Class":null},{"Name":"BookingType","Title":"Booking Type","Editable":null,"Searchable":true,"Class":null},{"Name":"LoadType","Title":"Load Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Loads","Title":"Loads Lorry","Editable":null,"Searchable":true,"Class":null},{"Name":"LorryType","Title":"Lorry Type","Editable":null,"Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Editable":null,"Searchable":true,"Class":null},{"Name":"PurchaseOrderNo","Title":"PON","Editable":null,"Searchable":true,"Class":null},{"Name":"Notes","Title":"Notes","Editable":null,"Searchable":true,"Class":null},{"Name":"BookedName","Title":"Created By","Editable":null,"Searchable":true,"Class":null},{"Name":"CreateDateTime","Title":"Created Datetime","Editable":null,"Searchable":true,"Class":null}]}';
	}

	function BookingRequestStageAtSite($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			$conditions = array('LoadID ' => $LoadID);
			$data['LoadInfo'] = $this->Booking_model->BookingRequestLoadInfo($LoadID);
			if ($data['LoadInfo']->Status != 1) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$SiteInDateTime = date("Y-m-d H:i:s");
				$Notes1 = $this->security->xss_clean($this->input->post('Notes1'));
				$GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
				$TipNumber = $this->security->xss_clean($this->input->post('TipNumber'));

				$LoadInfo = array(
					'SiteInDateTime' => $SiteInDateTime,
					'Notes1' => $Notes1,
					'GrossWeight' => $GrossWeight,
					'TipNumber' => $TipNumber,
					'Status' => 2
				);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);
				if ($update) {
					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
				}
				redirect('RequestLoads');
			}
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Stage Update to Reach / At Site';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/BookingRequestStageAtSite", $this->global, $data, NULL);
		}
	}
	function BookingRequestStageLeftSite($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			$conditions = array('LoadID ' => $LoadID);
			$data['LoadInfo'] = $this->Booking_model->BookingRequestLoadInfo($LoadID);

			//if($data['LoadInfo']->Status!=2){ redirect('Loads'); }

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$SiteOutDateTime = date("Y-m-d H:i:s");
				$Notes2 = $this->security->xss_clean($this->input->post('Notes2'));
				$CustomerName = $this->security->xss_clean($this->input->post('CustomerName'));

				$Signature = $this->input->post('Signature', FALSE);

				if ($Signature != "") {
					$Signature1 = str_replace('data:image/png;base64,', '', $Signature);
					$Signature1 = str_replace(' ', '+', $Signature1);
					$Signature1 = base64_decode($Signature1);


					$Signature = md5(date("dmYhisA")) . ".png";
					$file_name = './uploads/Signature/' . $Signature;
					file_put_contents($file_name, $Signature1);
				} else {
					$Signature = "";
				}

				$TicketUniqueID = $this->generateRandomString();

				$LoadInfo = array(
					'SiteOutDateTime' => $SiteOutDateTime,
					'Notes2' => $Notes2,
					'TicketUniqueID' => $TicketUniqueID,
					'ReceiptName' => $TicketUniqueID . ".pdf",
					'Signature' => $Signature,
					'CustomerName' => $CustomerName,
					'Status' => 3,
					'PortalUpdate' => 1
				);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);
				if ($update) {

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data['LoadInfo']->TonBook == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					if ($data['LoadInfo']->BookingType == 1) {


						$LastTicketNumber = $this->tickets_model->LastTicketNo();
						if ($LastTicketNumber) {
							$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
						} else {
							$TicketNumber = 1;
						}

						$ticketsInfo = array(
							'TicketUniqueID' => $TicketUniqueID,
							'LoadID' => $LoadID,
							'TicketNumber' => $TicketNumber,
							'TicketDate' => date('Y-m-d H:i:s'),
							'Conveyance' => $data['LoadInfo']->ConveyanceNo,
							'OpportunityID' => $data['LoadInfo']->OpportunityID,
							'CompanyID' => $data['LoadInfo']->CompanyID,
							'DriverName' => $data['LoadInfo']->DriverName,
							'RegNumber' => $data['LoadInfo']->VehicleRegNo,
							'Hulller' => $data['LoadInfo']->Haulier,
							'Tare' => $data['LoadInfo']->Tare,
							'driver_id' => $data['LoadInfo']->DriverID,
							'DriverLoginID' => $data['LoadInfo']->DriverLoginID,
							'MaterialID' => $data['LoadInfo']->MaterialID,
							'SicCode' => $data['LoadInfo']->LoadSICCODE,
							'CreateUserID' => 1,
							'CreateDate' => date('Y-m-d H:i:s'),
							'TypeOfTicket' => 'In',
							'IsInBound' => 1,
							'pdf_name' => $TicketUniqueID . '.pdf'
						);

						$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);

						$LoadInfo1 = array('TicketUniqueID' => $TicketUniqueID, 'TicketID' => $TicketID, 'PortalUpdate' => 1);
						$cond1 = array('LoadID ' => $LoadID);
						$update1 = $this->Common_model->update("tbl_booking_loads1", $LoadInfo1, $cond1);

						$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;

						$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
							<div style="width:100%; " >
								<div style="width:35%;float: left;" > 		
									<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
								</div>
								<div style="width:65%;float: right;text-align: right;" > 		 
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
									' . $PDFContent[0]->address . ' <br/> 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
								</div>
							</div>	
							<div style="width:100%;float: left;" >   
								<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
								<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
								<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> 
								<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/><hr>
								<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
								<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
								<div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
								<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
								<b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
								<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
								<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
								<b>Tip Address: </b> ' . $data['LoadInfo']->Street1 . ' ' . $data['LoadInfo']->Street2 . ' ' . $data['LoadInfo']->Town . ' ' . $data['LoadInfo']->County . ' ' . $data['LoadInfo']->PostCode . '<br>		 		 
								<b>Material: </b> ' . $MaterialText . '  <br> 
								<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
								<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
								<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
							</div>
							<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
							<div style="width:100%;float: left;" >
								<b>Produced By: </b><br>
								<div><img src="/uploads/Signature/' . $Signature . '" width ="100" height="40" style="float:left"></div>
								' . $data['LoadInfo']->CustomerName . '<br><br>
								<div style="font-size: 9px;"> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
									<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
									' . $PDFContent[0]->FooterText . '  
								</div>
							</div>  
						</div></body></html>';

						$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $TicketUniqueID . '.pdf';
						$mpdf = new mPDF('utf-8', array(70, 180), '', '', 5, 5, 5, 5, 5, 5);
						//$mpdf->_setPageSize(array(70,180),'P');
						//$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
						//$mpdf->AddPage();
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);

					}

					if ($data['LoadInfo']->BookingType == 2) {

						$data1['tickets'] = $this->Booking_model->BookingTicketInfo($data['LoadInfo']->TicketID);

						$MaterialText = $data['LoadInfo']->MaterialName . ' Delivered ' . $LT . ' ' . $TB;

						$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
							<div style="width:100%;float: left;" >    
								<b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
								<b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
								<b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
								<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
								<b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>		 
								<b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>		   
								<b>In Time: </b> ' . $data1['tickets']['SiteIn'] . ' <br>		   
								<b>Out Time: </b> ' . $data1['tickets']['SiteOut'] . ' <br>		   
								<b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
								<b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
								<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> 
								<b>Driver Signature: </b> <br> 
								<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>
								<b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
								<b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
								<b>Tip Address: </b> ' . $data1['tickets']['TipName'] . ', ' . $data1['tickets']['Street1'] . ', ' . $data1['tickets']['Street2'] . ', ' . $data1['tickets']['Town'] . ', ' . $data1['tickets']['County'] . ', ' . $data1['tickets']['PostCode'] . ',								<br>	 
								<b>Waste License No:  </b>' . $data1['tickets']['PermitRefNo'] . ' <br> 
								<b>Material:  ' . $MaterialText . ' <br></b> 
								<b>SIC Code: </b> ' . $data1['tickets']['LoadSICCODE'] . ' <br> 
								<b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>		 
								<b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
								<b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
								<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
							<div style="width:100%;float: left;" > 
								<b>Received By: </b><br> 
								<div><img src="/uploads/Signature/' . $Signature . '" width ="100" height="40" style="float:left"></div> 
								' . $data['LoadInfo']->CustomerName . ' 
								<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

						$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $TicketUniqueID . ".pdf";
						$mpdf = new mPDF('utf-8', array(70, 210), '', '', 5, 5, 5, 5, 5, 5);
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);

					}

					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
				}

				redirect('RequestLoads');
			}
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Stage Update to Left Site';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/BookingRequestStageLeftSite", $this->global, $data, NULL);
		}
	}
	function BookingRequestStageFinishLoad($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			$conditions = array('LoadID ' => $LoadID);
			$data['LoadInfo'] = $this->Booking_model->BookingRequestLoadInfo($LoadID);
			if ($data['LoadInfo']->Status != 3) {
				redirect('RequestLoads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$JobEndDateTime = date("Y-m-d H:i:s");
				$Notes = $this->security->xss_clean($this->input->post('Notes'));
				$GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
				$TipNumber = $this->security->xss_clean($this->input->post('TipNumber'));

				$LoadInfo = array(
					'JobEndDateTime' => $JobEndDateTime,
					'Notes' => $Notes,
					'Status' => 4,
					'GrossWeight' => $GrossWeight,
					'TipNumber' => $TipNumber
				);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);
				if ($update) {
					if ($data['LoadInfo']->LoadType == 2) {

						if (isset($_POST['continue'])) {
							$TicketID = 0;
							$TicketUniqueID = "";

							$LID = $this->generateRandomString();

							$BDate = date('Y-m-d');
							$insertBookingDate = $this->db->query("insert into tbl_booking_date1(BookingRequestID ,BookingID,BookingDate) 
							value('" . $data['LoadInfo']->BookingRequestID . "','" . $data['LoadInfo']->BookingID . "','" . $BDate . "')");
							$BookingDateID = $this->db->insert_id();

							$LastConNumber = $this->Booking_model->BookingRequestLastConNumber();
							$LConveyanceNo = $LastConNumber['ConveyanceNo'] + 1;

							$LoadInfo = array(
								'LID' => $LID,
								'BookingRequestID' => $data['LoadInfo']->BookingRequestID,
								'BookingID' => $data['LoadInfo']->BookingID,
								'BookingDateID' => $BookingDateID,
								'ConveyanceNo' => $LConveyanceNo,
								'DriverID' => $data['LoadInfo']->DriverID,
								'DriverLoginID' => $data['LoadInfo']->DriverLoginID,
								'MaterialID' => $data['LoadInfo']->MaterialID,
								'AllocatedDateTime' => date('Y-m-d H:i:s'),
								'TipID' => $data['LoadInfo']->TipID,
								'Status' => 0,
								'AutoCreated' => 0,
								'CreatedBy' => $this->session->userdata['userId']
							);
							$result1 = $this->Common_model->insert("tbl_booking_loads1", $LoadInfo);

							if ($data['LoadInfo']->LoadType == 2) {
								$TicketUniqueID = $this->generateRandomString();
								$TicketNumber = 1;
								$LastTicketNumber = $this->Booking_model->LastTicketNo();
								if ($LastTicketNumber) {
									$TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
								}

								$ticketsInfo = array(
									'TicketUniqueID' => $TicketUniqueID,
									'TicketNumber' => $TicketNumber,
									'TicketDate' => date('Y-m-d H:i:s'),
									'LoadID' => $result1,
									'Conveyance' => $LConveyanceNo,
									'OpportunityID' => $data['LoadInfo']->OpportunityID,
									'CompanyID' => $data['LoadInfo']->CompanyID,
									'DriverName' => $data['LoadInfo']->lorry_driver_name,
									'RegNumber' => $data['LoadInfo']->lorry_RegNumber,
									'Hulller' => $data['LoadInfo']->Haulier,
									'Tare' => $data['LoadInfo']->lorry_tare,
									'driversignature' => $data['LoadInfo']->lorry_signature,
									'driver_id' => $data['LoadInfo']->DriverID,
									'MaterialID' => $data['LoadInfo']->MaterialID,
									'SicCode' => $data['LoadInfo']->SicCode,
									'CreateUserID' => $this->session->userdata['userId'],
									'CreateDate' => date('Y-m-d H:i:s'),
									'TypeOfTicket' => 'Out',
									'is_hold' => 1
								);
								$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);

								$LoadInfo1 = array('TicketID' => $TicketID, 'TicketUniqueID' => $TicketUniqueID);
								$cond1 = array('LoadID' => $result1);
								$update1 = $this->Common_model->update("tbl_booking_loads1", $LoadInfo1, $cond1);
							}
						}
					}

					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
				}
				redirect('RequestLoads');
			}
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Request Stage Update to Finish Load';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/BookingRequestStageFinishLoad", $this->global, $data, NULL);
		}
	}
	function BookingRequestStageFinishLoadNonApp($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			$conditions = array('LoadID ' => $LoadID);
			$data['LoadInfo'] = $this->Booking_model->BookingRequestLoadInfo($LoadID);

			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				//$JobEndDateTime =date("Y-m-d H:i:s");
				$Notes = $this->security->xss_clean($this->input->post('Notes'));
				$NonAppConveyanceNo = $this->security->xss_clean($this->input->post('NonAppConveyanceNo'));
				$ConveyanceDate = $this->security->xss_clean($this->input->post('ConveyanceDate'));

				$GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
				$Tare = $this->security->xss_clean($this->input->post('Tare'));
				$Net = $this->security->xss_clean($this->input->post('Net'));

				$SiteInDateTime = $ConveyanceDate;
				$SiteOutDateTime = $ConveyanceDate;
				$JobEndDateTime = $ConveyanceDate;

				$LoadInfo = array(
					'NonAppConveyanceNo' => $NonAppConveyanceNo,
					'JobEndDateTime' => $JobEndDateTime,
					'SiteInDateTime' => $SiteInDateTime,
					'SiteOutDateTime' => $SiteOutDateTime,
					'Notes' => $Notes,
					'GrossWeight' => $GrossWeight,
					'Tare' => $Tare,
					'Net' => $Net,
					'Status' => 4,
					'PortalUpdate' => 1
				);

				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);
				if ($update) {
					if ($data['LoadInfo']->LoadType == 2) {
						if (isset($_POST['continue'])) {
							$LID = $this->generateRandomString();
							$BDate = date('Y-m-d');
							$insertBookingDate = $this->db->query("insert into tbl_booking_date1(BookingRequestID ,BookingID,BookingDate) 
							value('" . $data['LoadInfo']->BookingRequestID . "','" . $data['LoadInfo']->BookingID . "','" . $BDate . "')");
							$BookingDateID = $this->db->insert_id();

							$LastConNumber = $this->Booking_model->BookingRequestLastConNumber();
							$LConveyanceNo = $LastConNumber['ConveyanceNo'] + 1;

							$LoadInfo = array(
								'LID' => $LID,
								'BookingRequestID' => $data['LoadInfo']->BookingRequestID,
								'BookingID' => $data['LoadInfo']->BookingID,
								'BookingDateID' => $BookingDateID,
								'ConveyanceNo' => $LConveyanceNo,
								'DriverID' => $data['LoadInfo']->DriverID,
								'DriverName' => $data['LoadInfo']->DriverName,
								'VehicleRegNo' => $data['LoadInfo']->VehicleRegNo,
								'MaterialID' => $data['LoadInfo']->MaterialID,
								'AllocatedDateTime' => date('Y-m-d H:i:s'),
								'TipID' => $data['LoadInfo']->TipID,
								'Status' => 1,
								'AutoCreated' => 0,
								'CreatedBy' => $this->session->userdata['userId']
							);
							$result1 = $this->Common_model->insert("tbl_booking_loads1", $LoadInfo);
						}
					}

					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
				}
				redirect('RequestLoads');
			}

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Stage Update to Finish Load';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/BookingRequestStageFinishLoadNonApp", $this->global, $data, NULL);
		}
	}
	function BookingCreateInvoice($BookingRequestID)
	{
		if ($this->isIApprove == 0) {
			//if($this->isEdit == 0){
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($BookingRequestID == null) {
				redirect('Loads');
			}

			$IsTonnageBooking = $this->Booking_model->IsTonnageBooking($BookingRequestID);
			if ($IsTonnageBooking['TonBook'] == '1') {
				redirect('BookingCreateInvoiceTonnage/' . $BookingRequestID);
			}

			$Cond = array('BookingRequestID ' => $BookingRequestID);
			$data['RequestInfo'] = $this->Common_model->select_where('tbl_booking_request', $Cond);

			if ($data['RequestInfo']['Invoice'] == 1) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {


				$BookingRequestID = $this->security->xss_clean($this->input->post('BookingRequestID'));
				$InvoiceComment = $this->security->xss_clean($this->input->post('InvoiceComment'));
				$InvoiceHold = $this->security->xss_clean($this->input->post('InvoiceHold'));

				if (trim($InvoiceComment) != "") {
					$CommentInfo = array(
						'Comment' => $InvoiceComment,
						'BookingRequestID' => $BookingRequestID,
						'CommentBy' => $this->session->userdata['userId']
					);
					$this->Common_model->insert("tbl_booking_preinvoice_comments", $CommentInfo);
				}
				if ($InvoiceHold == '1') {
					$Info = array('InvoiceHold' => $InvoiceHold);
					$Cond = array('BookingRequestID' => $BookingRequestID);
					$update = $this->Common_model->update("tbl_booking_request", $Info, $Cond);
					if ($update) {
						$this->session->set_flashdata('success', 'Preinvoice has been Put On HOLD');
					}
					redirect('MyBookingPreInvoice');
					exit;
				} else {
					$Info = array('InvoiceHold' => $InvoiceHold);
					$Cond = array('BookingRequestID' => $BookingRequestID);
					$update = $this->Common_model->update("tbl_booking_request", $Info, $Cond);
				}

				$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
				$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
				$OpportunityName = $this->security->xss_clean($this->input->post('OpportunityName'));
				$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
				$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
				$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));
				$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$FinalAmount = $this->security->xss_clean($this->input->post('FinalAmount'));
				$BookingDateID = $this->security->xss_clean($this->input->post('BookingDateID'));
				$LoadID = $this->security->xss_clean($this->input->post('LoadID'));
				$TaxRate = $this->security->xss_clean($this->input->post('TaxRate'));

				$LastInvoiceNumber = $this->Booking_model->LastInvoiceNo();
				if ($LastInvoiceNumber) {
					$InvoiceNumber = str_pad((int) $LastInvoiceNumber['InvoiceNumber'] + 1, 7, "0", STR_PAD_LEFT);
				} else {
					$InvoiceNumber = str_pad(1, 7, "0", STR_PAD_LEFT);
				}

				$InvoiceInfo = array(
					'InvoiceNumber' => $InvoiceNumber,
					'InvoiceDate' => date('Y-m-d'),
					'BookingRequestID' => $BookingRequestID,
					'CompanyID' => $CompanyID,
					'CompanyName' => $CompanyName,
					'OpportunityID' => $OpportunityID,
					'OpportunityName' => $OpportunityName,
					'ContactID' => $ContactID,
					'ContactName' => $ContactName,
					'ContactMobile' => $ContactMobile,
					'TaxRate' => $TaxRate,
					'SubTotalAmount' => $SubTotalAmount,
					'VatAmount' => $VatAmount,
					'FinalAmount' => $FinalAmount,
					'Status' => '1',
					'CreatedUserID' => $this->session->userdata['userId']
				);
				$InvoiceID = $this->Common_model->insert("tbl_booking_invoice", $InvoiceInfo);

				if ($InvoiceID) {

					for ($i = 0; $i < count($LoadID); $i++) {
						$j = $LoadID[$i];
						$InvoiceInfo1 = array(
							'InvoiceID' => $InvoiceID,
							'BookingRequestID' => $BookingRequestID,
							'LoadID' => $j,
							'BookingDateID' => $this->input->post('BookingDateID' . $j),
							'MaterialID' => $this->input->post('MaterialID' . $j),
							'LoadStatus' => $this->input->post('LoadStatus' . $j),
							'TaxRate' => $TaxRate,
							'LoadPrice' => $this->input->post('LoadPrice' . $j),
							'TotalPrice' => $this->input->post('LoadPrice' . $j),
							'CreatedUserID' => $this->session->userdata['userId']
						);
						$this->Common_model->insert("tbl_booking_invoice_load", $InvoiceInfo1);
					}

					$data['LoadInfo'] = $this->Booking_model->BookingInvoiceLoads($InvoiceID);
					$i = 1;
					foreach ($data['LoadInfo'] as $row) {
						$InvoiceItem = array(
							'InvoiceID' => $InvoiceID,
							'ItemNumber' => $i,
							'GrossAmount' => $row->TotalPrice,
							'TaxAmount' => (($row->TotalPrice * $row->TaxRate) / 100),
							'NetAmount' => $row->TotalPrice + (($row->TotalPrice * $row->TaxRate) / 100),
							'TaxRate' => $row->TaxRate,
							'Qty' => $row->TotalQty,
							'UnitPrice' => $row->LoadPrice,
							'NominalCode' => '4000',
							'StockCode' => $row->MaterialCode,
							'Description' => $row->MaterialName
						);
						$this->Common_model->insert("tbl_booking_invoice_item", $InvoiceItem);
						$i++;
					}

					/* Add Invoice ID to Invoice Comment */
					$CommentInfo1 = array('InvoiceID' => $InvoiceID);
					$CommentCond1 = array('BookingRequestID' => $BookingRequestID);
					$this->Common_model->update("tbl_booking_preinvoice_comments", $CommentInfo1, $CommentCond1);

					/* Update Hold to Active Invoice */
					$Info1 = array('Hold' => '0');
					$Cond1 = array('BookingRequestID' => $BookingRequestID);
					$update1 = $this->Common_model->update("tbl_booking_loads1", $Info1, $Cond1);

					/* Insert Price By Logs  */
					for ($k = 0; $k < count($BookingDateID); $k++) {
						$j = $BookingDateID[$k];
						$BID = $this->Booking_model->FetchBookingID($BookingDateID[$k]);
						$LogInfo1 = array(
							'BookingID' => $BID['BookingID'],
							'PriceTo' => $this->input->post('Price' . $j),
							'UpdatedBy' => $this->session->userdata['userId']
						);
						$this->Common_model->insert("tbl_booking_priceby_logs", $LogInfo1);
					}

				}
				redirect('BookingInvoiceDetails/' . $InvoiceID);
				exit;
			}

			$data['LoadInfo'] = $this->Booking_model->PreInvoiceLoadInfo($BookingRequestID);
			$data['Loads'] = $this->Booking_model->ShowPreInvoiceLoadsByRequest($BookingRequestID);
			$data['Comments'] = $this->Booking_model->BookingComments($BookingRequestID);

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking PreInvoice';
			$this->global['active_menu'] = 'bookingcreateinvoice';

			$this->loadViews("Booking/BookingCreateInvoice", $this->global, $data, NULL);
		}
	}


	/*function BookingCreateInvoiceConfirm($InvoiceID){
					if($this->isIApprove == 0){
					//if($this->isEdit == 0){
						$data = array();
						$this->global['pageTitle'] = 'Error';             
						$this->loadViews("permission", $this->global, $data, NULL);
					}else{   
						if($InvoiceID  == null){ redirect('Loads'); }           
						$Cond = array( 'InvoiceID' => $InvoiceID );  
						$data['InvoiceInfo'] = $this->Common_model->select_where('tbl_booking_invoice',$Cond);
						
						$Cond2 = array( 'CompanyID' => $data['InvoiceInfo']['CompanyID'] );  
						$data['CompanyInfo'] = $this->Common_model->select_where('tbl_company',$Cond2); 
						
						$BookingRequestID = $data['InvoiceInfo']['BookingRequestID'];
						
						$Cond1 = array( 'BookingRequestID' => $BookingRequestID );  
						$data['RequestInfo'] = $this->Common_model->select_where('tbl_booking_request',$Cond1);   
						$data['LoadInfo'] = $this->Booking_model->BookingInvoiceLoads($InvoiceID); 
						 
						if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
							
							$i=1;
							foreach( $data['LoadInfo'] as $row){  
								$InvoiceItem = array('InvoiceID'=>$InvoiceID, 'ItemNumber'=>$i,
									'GrossAmount'=>$row->TotalPrice,  
									'TaxAmount'=>(($row->TotalPrice*$row->TaxRate)/100),  
									'NetAmount'=>$row->TotalPrice+(($row->TotalPrice*$row->TaxRate)/100),  
									'TaxRate'=>$row->TaxRate, 
									'Qty'=>$row->TotalQty,  
									'UnitPrice'=>$row->LoadPrice,  
									'NominalCode'=>'4000',  
									'StockCode'=>$row->MaterialCode,  
									'Description'=>$row->MaterialName ); 
									$this->Common_model->insert("tbl_booking_invoice_item",$InvoiceItem);	 
								$i++;  	
							} 
							
							$Ivinfo = array('Status'=>'1'); 
							$ICond = array( 'InvoiceID ' => $InvoiceID  );  
							$this->Common_model->update("tbl_booking_invoice", $Ivinfo, $ICond);
							 
							redirect('MyBookingInvoice');
							exit; 
						}  
						$data['Comments'] = $this->Booking_model->BookingCommentsInvoice($InvoiceID);  
						
						$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Booking PreInvoice Confirmation';
						$this->global['active_menu'] = 'bookingcreateinvoiceconfirm';
						
						$this->loadViews("Booking/BookingCreateInvoiceConfirm", $this->global, $data, NULL);
					}
				} */

	function BookingCreateInvoiceTonnage($BookingRequestID)
	{
		if ($this->isIApprove == 0) {
			//if($this->isEdit == 0){
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($BookingRequestID == null) {
				redirect('Loads');
			}
			$Cond = array('BookingRequestID ' => $BookingRequestID);
			$data['RequestInfo'] = $this->Common_model->select_where('tbl_booking_request', $Cond);

			$IsTonnageBooking = $this->Booking_model->IsTonnageBooking($BookingRequestID);
			if ($IsTonnageBooking['TonBook'] == '0') {
				redirect('BookingCreateInvoice/' . $BookingRequestID);
			}

			if ($data['RequestInfo']['Invoice'] == 1) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$BookingRequestID = $this->security->xss_clean($this->input->post('BookingRequestID'));

				$InvoiceComment = $this->security->xss_clean($this->input->post('InvoiceComment'));
				$InvoiceHold = $this->security->xss_clean($this->input->post('InvoiceHold'));

				if (trim($InvoiceComment) != "") {
					$CommentInfo = array(
						'Comment' => $InvoiceComment,
						'BookingRequestID' => $BookingRequestID,
						'CommentBy' => $this->session->userdata['userId']
					);
					$this->Common_model->insert("tbl_booking_preinvoice_comments", $CommentInfo);
				}
				if ($InvoiceHold == '1') {
					$Info = array('InvoiceHold' => $InvoiceHold);
					$Cond = array('BookingRequestID' => $BookingRequestID);
					$update = $this->Common_model->update("tbl_booking_request", $Info, $Cond);
					if ($update) {
						$this->session->set_flashdata('success', 'Preinvoice has been Put On HOLD');
					}
					redirect('MyBookingPreInvoice');
					exit;
				} else {
					$Info = array('InvoiceHold' => $InvoiceHold);
					$Cond = array('BookingRequestID' => $BookingRequestID);
					$update = $this->Common_model->update("tbl_booking_request", $Info, $Cond);
				}


				$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
				$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
				$OpportunityName = $this->security->xss_clean($this->input->post('OpportunityName'));
				$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
				$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
				$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));
				$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$FinalAmount = $this->security->xss_clean($this->input->post('FinalAmount'));
				$BookingDateID = $this->security->xss_clean($this->input->post('BookingDateID'));
				$LoadID = $this->security->xss_clean($this->input->post('LoadID'));
				$TaxRate = $this->security->xss_clean($this->input->post('TaxRate'));

				$LastInvoiceNumber = $this->Booking_model->LastInvoiceNo();
				if ($LastInvoiceNumber) {
					$InvoiceNumber = str_pad((int) $LastInvoiceNumber['InvoiceNumber'] + 1, 7, "0", STR_PAD_LEFT);
				} else {
					$InvoiceNumber = str_pad(1, 7, "0", STR_PAD_LEFT);
				}

				//var_dump($_POST); 
				//exit;
				$InvoiceInfo = array(
					'InvoiceNumber' => $InvoiceNumber,
					'InvoiceDate' => date('Y-m-d'),
					'BookingRequestID' => $BookingRequestID,
					'CompanyID' => $CompanyID,
					'CompanyName' => $CompanyName,
					'InvoiceType' => '1',
					'OpportunityID' => $OpportunityID,
					'OpportunityName' => $OpportunityName,
					'ContactID' => $ContactID,
					'ContactName' => $ContactName,
					'ContactMobile' => $ContactMobile,
					'TaxRate' => $TaxRate,
					'SubTotalAmount' => $SubTotalAmount,
					'VatAmount' => $VatAmount,
					'FinalAmount' => $FinalAmount,
					'Status' => '1',
					'CreatedUserID' => $this->session->userdata['userId']
				);
				$InvoiceID = $this->Common_model->insert("tbl_booking_invoice", $InvoiceInfo);

				if ($InvoiceID) {

					for ($i = 0; $i < count($LoadID); $i++) {
						$j = $LoadID[$i];
						$InvoiceInfo1 = array(
							'InvoiceID' => $InvoiceID,
							'BookingRequestID' => $BookingRequestID,
							'LoadID' => $j,
							'BookingDateID' => $this->input->post('BookingDateID' . $j),
							'MaterialID' => $this->input->post('MaterialID' . $j),
							'LoadStatus' => $this->input->post('LoadStatus' . $j),
							'LoadPrice' => $this->input->post('LoadPrice' . $j),
							'TotalTon' => $this->input->post('TotalLoadTon' . $j),
							'TaxRate' => $TaxRate,
							'TotalPrice' => $this->input->post('TotalLoadPrice' . $j),
							'CreatedUserID' => $this->session->userdata['userId']
						);
						$this->Common_model->insert("tbl_booking_invoice_load", $InvoiceInfo1);
					}

					$data['LoadInfo'] = $this->Booking_model->BookingInvoiceLoadsTonnage($InvoiceID);
					$i = 1;
					foreach ($data['LoadInfo'] as $row) {
						$InvoiceItem = array(
							'InvoiceID' => $InvoiceID,
							'ItemNumber' => $i,
							'GrossAmount' => $row->TotalPrice,
							'TaxAmount' => (($row->TotalPrice * $row->TaxRate) / 100),
							'NetAmount' => $row->TotalPrice + (($row->TotalPrice * $row->TaxRate) / 100),
							'TaxRate' => $row->TaxRate,
							'Qty' => $row->TotalTon,
							'UnitPrice' => $row->LoadPrice,
							'NominalCode' => '4000',
							'StockCode' => $row->MaterialCode,
							'Description' => $row->MaterialName
						);
						$this->Common_model->insert("tbl_booking_invoice_item", $InvoiceItem);
						$i++;
					}

					$CommentInfo1 = array('InvoiceID' => $InvoiceID);
					$CommentCond1 = array('BookingRequestID' => $BookingRequestID);
					$this->Common_model->update("tbl_booking_preinvoice_comments", $CommentInfo1, $CommentCond1);

					$Info1 = array('Hold' => '0');
					$Cond1 = array('BookingRequestID' => $BookingRequestID);
					$update1 = $this->Common_model->update("tbl_booking_loads1", $Info1, $Cond1);

					for ($k = 0; $k < count($BookingDateID); $k++) {
						$j = $BookingDateID[$k];
						$BID = $this->Booking_model->FetchBookingID($BookingDateID[$k]);
						$LogInfo1 = array(
							'BookingID' => $BID['BookingID'],
							'PriceTo' => $this->input->post('Price' . $j),
							'UpdatedBy' => $this->session->userdata['userId']
						);
						$this->Common_model->insert("tbl_booking_priceby_logs", $LogInfo1);
					}
				}
				redirect('BookingInvoiceDetailsTonnage/' . $InvoiceID);
				exit;
			}
			$data['LoadInfo'] = $this->Booking_model->PreInvoiceLoadInfo($BookingRequestID);
			$data['Loads'] = $this->Booking_model->ShowPreInvoiceLoadsByRequest($BookingRequestID);
			$data['Comments'] = $this->Booking_model->BookingComments($BookingRequestID);

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking PreInvoice ( Tonnage )';
			$this->global['active_menu'] = 'bookingcreateinvoicetonnage';

			$this->loadViews("Booking/BookingCreateInvoiceTonnage", $this->global, $data, NULL);
		}
	}


	/*function BookingCreateInvoiceConfirmTonnage($InvoiceID){
					if($this->isIApprove == 0){
					//if($this->isEdit == 0){
						$data = array();
						$this->global['pageTitle'] = 'Error';             
						$this->loadViews("permission", $this->global, $data, NULL);
					}else{   
						if($InvoiceID  == null){ redirect('Loads'); }           
						$Cond = array( 'InvoiceID' => $InvoiceID );  
						$data['InvoiceInfo'] = $this->Common_model->select_where('tbl_booking_invoice',$Cond);
						
						$Cond2 = array( 'CompanyID' => $data['InvoiceInfo']['CompanyID'] );  
						$data['CompanyInfo'] = $this->Common_model->select_where('tbl_company',$Cond2); 
						
						$BookingRequestID = $data['InvoiceInfo']['BookingRequestID'];
						
						$Cond1 = array( 'BookingRequestID' => $BookingRequestID );  
						
						$data['RequestInfo'] = $this->Common_model->select_where('tbl_booking_request',$Cond1);   
						$data['LoadInfo'] = $this->Booking_model->BookingInvoiceLoadsTonnage($InvoiceID); 
						 
						if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				
							$i=1;
							foreach( $data['LoadInfo'] as $row){  
								$InvoiceItem = array('InvoiceID'=>$InvoiceID, 'ItemNumber'=>$i,
									'GrossAmount'=>$row->TotalPrice,  
									'TaxAmount'=>(($row->TotalPrice*$row->TaxRate)/100),  
									'NetAmount'=>$row->TotalPrice+(($row->TotalPrice*$row->TaxRate)/100),  
									'TaxRate'=>$row->TaxRate, 
									'Qty'=>$row->TotalTon, 
									'UnitPrice'=>$row->LoadPrice,  
									'NominalCode'=>'4000',  
									'StockCode'=>$row->MaterialCode,  
									'Description'=>$row->MaterialName ); 
									$this->Common_model->insert("tbl_booking_invoice_item",$InvoiceItem);	 
								$i++;  
							} 
						
							$Ivinfo = array('Status'=>'1'); 
							$ICond = array( 'InvoiceID ' => $InvoiceID  );  
							$this->Common_model->update("tbl_booking_invoice", $Ivinfo, $ICond);
							
						redirect('MyBookingInvoice');
						exit; 
						}  
						$data['Comments'] = $this->Booking_model->BookingCommentsInvoice($InvoiceID);  
						$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Booking PreInvoice Confirmation';
						$this->global['active_menu'] = 'bookingcreateinvoiceconfirmtonnage';
						
						$this->loadViews("Booking/BookingCreateInvoiceConfirmTonnage", $this->global, $data, NULL);
					}
				} */


	function BookingInvoiceDetails($InvoiceID)
	{
		if ($this->isIApprove == 0) {
			//if($this->isEdit == 0){
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($InvoiceID == null) {
				redirect('dashboard');
			}
			$Cond = array('InvoiceID' => $InvoiceID);
			$data['InvoiceInfo'] = $this->Common_model->select_where('tbl_booking_invoice', $Cond);

			//$data['LoadInfo'] = $this->Booking_model->BookingInvoiceLoads($InvoiceID); 
			$data['InvoiceItems'] = $this->Booking_model->BookingInvoiceItems($InvoiceID);

			$data['Comments'] = $this->Booking_model->BookingCommentsInvoice($InvoiceID);
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Invoice Details';
			$this->global['active_menu'] = 'bookinginvoicedetails';

			$this->loadViews("Booking/BookingInvoiceDetails", $this->global, $data, NULL);
		}
	}
	function BookingInvoiceDetailsTonnage($InvoiceID)
	{
		if ($this->isIApprove == 0) {
			//if($this->isEdit == 0){
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($InvoiceID == null) {
				redirect('dashboard');
			}
			$Cond = array('InvoiceID' => $InvoiceID);
			$data['InvoiceInfo'] = $this->Common_model->select_where('tbl_booking_invoice', $Cond);

			//$data['LoadInfo'] = $this->Booking_model->BookingInvoiceLoads($InvoiceID); 
			$data['InvoiceItems'] = $this->Booking_model->BookingInvoiceItems($InvoiceID);

			$data['Comments'] = $this->Booking_model->BookingCommentsInvoice($InvoiceID);
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Invoice Details';
			$this->global['active_menu'] = 'bookinginvoicedetails';

			$this->loadViews("Booking/BookingInvoiceDetailsTonnage", $this->global, $data, NULL);
		}
	}

	function ShowPreInvoiceAllLoadsAJAX()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingDateID = $this->input->post('BookingDateID');
			$data['Loads'] = $this->Booking_model->ShowPreInvoiceLoads($BookingDateID);
			//var_dump($data['Loads']);
			//exit; 
			$html = $this->load->view('Booking/PreInvoiceLoadInfoAjax', $data, true);
			echo json_encode($html);
		}
	}


	function BookingPriceLogsAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['BookingID'] = $this->input->post('BookingID');
			$data['PriceLogs'] = $this->Booking_model->ShowBookingPriceLogs($data['BookingID']);

			$html = $this->load->view('Booking/BookingPriceLogsAJAX', $data, true);
			echo json_encode($html);
		}
	}
	public function NonAppConveyanceTickets()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : NonApp Conveyance Tickets';
			$this->global['active_menu'] = 'nonapprequestloads';

			$this->loadViews("Booking/NonAppConveyanceTickets", $this->global, $data, NULL);
		}
	}

	function NonAppConveyanceTicketsTableMeta()
	{
		//echo '{"Name":"Conveyance","Action":true,"Column":[{"Name":"ConveyanceNo","Title":"Conv No","Searchable":true,"Class":null},{"Name":"SiteOutDateTime","Title":"DateTime","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Customer Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Job Site Address","Searchable":true,"Class":null},{"Name":"TipName","Title":"Supplier Name","Searchable":true,"Class":null},{"Name":"TipAddress","Title":"Tip Site Address","Searchable":false,"Class":null},{"Name":"SuppDate","Title":"SuppTkt Dt","Searchable":false,"Class":null},{"Name":"SuppNo","Title":"SuppTkt No","Searchable":false,"Class":null},{"Name":"PurchaseOrderNumber","Title":"PO NO","Searchable":false,"Class":null},{"Name":"MaterialName","Title":"Product Description","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"VehicleRegNo","Title":"VRNO","Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Searchable":true,"Class":null},{"Name":"Status","Title":"Status","Searchable":true,"Class":null}]}';
		echo '{"Name":"Conveyance","Action":true,"Column":[{"Name":"BookingRequestID","Title":"BNO","Searchable":true,"Class":null},{"Name":"NonAppConveyanceNo","Title":"Conv No","Searchable":true,"Class":null},{"Name":"SiteOutDateTime","Title":"DateTime","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Customer Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Job Site Address","Searchable":true,"Class":null},{"Name":"TipName","Title":"Tip Name","Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Product Description","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"VehicleRegNo","Title":"VRNO","Searchable":true,"Class":null}, {"Name":"GrossWeight","Title":"GrossWeight","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null}, {"Name":"Net","Title":"Net","Searchable":true,"Class":null}]}';
	}

	public function AjaxNonAppConveyanceTickets()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetNonAppConveyanceTickets();
		$this->ajax->send($data);
	}

	public function NonAppDeliveryTickets()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : NonApp Delivery Tickets';
			$this->global['active_menu'] = 'nonapprequestloads';

			$this->loadViews("Booking/NonAppDeliveryTickets", $this->global, $data, NULL);
		}
	}
	function NonAppDeliveryTicketsTableMeta()
	{
		echo '{"Name":"Conveyance","Action":true,"Column":[{"Name":"BookingRequestID","Title":"BNO","Searchable":true,"Class":null},{"Name":"TicketNumber","Title":"Ticket Number","Searchable":true,"Class":null},{"Name":"NonAppConveyanceNo","Title":"Conv No","Searchable":true,"Class":null},{"Name":"SiteOutDateTime","Title":"DateTime","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Customer Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Job Site Address","Searchable":true,"Class":null},{"Name":"TipName","Title":"Tip Name","Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Product Description","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"VehicleRegNo","Title":"VRNO","Searchable":true,"Class":null}, {"Name":"GrossWeight","Title":"GrossWeight","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null}, {"Name":"Net","Title":"Net","Searchable":true,"Class":null}]}';
	}
	public function AjaxNonAppDeliveryTickets()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetNonAppDeliveryTickets();
		$this->ajax->send($data);
	}


	function DateUpdateAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');

			$data['SiteIn'] = $this->input->post('SiteInDateTime');
			$data['JobStart'] = $this->input->post('JobStartDateTime');
			$data['SiteOut'] = $this->input->post('SiteOutDateTime');
			$data['JobEnd'] = $this->input->post('JobEndDateTime');

			$html = $this->load->view('Booking/DateUpdateAjax', $data, true);
			echo json_encode($html);

		}
	}
	function DateUpdate($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}
			// Fetch OLD data BEFORE update
			$oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
			// print_r($oldData);
			// exit;
			$oldValueArray = [];
			if ($oldData) {
				if (isset($oldData->JobStartDateTime)) {
					$oldValueArray['JobStartDatetime'] = $oldData->JobStartDateTime;
				}
				if (isset($oldData->SiteInDateTime)) {
					$oldValueArray['SiteInDatetime'] = $oldData->SiteInDateTime;
				}
				if (isset($oldData->SiteOutDateTime)) {
					$oldValueArray['SiteOutDatetime'] = $oldData->SiteOutDateTime;
				}
				if (isset($oldData->JobEndDateTime)) {
					$oldValueArray['JobEndDatetime'] = $oldData->JobEndDateTime;
				}
			}
			$oldValueJson = json_encode($oldValueArray);



			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$JobStartDatetime = $this->input->post('JobStartDatetime');
				$SiteInDatetime = $this->input->post('SiteInDatetime');
				$SiteOutDatetime = $this->input->post('SiteOutDatetime');
				$JobEndDatetime = $this->input->post('JobEndDatetime');
				$LoadID = $this->input->post('LoadID');

				$js = explode(' ', $JobStartDatetime);
				$js1 = explode('/', $js[0]);
				$JobStartDatetime = trim($js1[2]) . "-" . trim($js1[1]) . "-" . trim($js1[0]) . " " . $js[1];

				$si = explode(' ', $SiteInDatetime);
				$si1 = explode('/', $si[0]);
				$SiteInDatetime = trim($si1[2]) . "-" . trim($si1[1]) . "-" . trim($si1[0]) . " " . $si[1];

				$so = explode(' ', $SiteOutDatetime);
				$so1 = explode('/', $so[0]);
				$SiteOutDatetime = trim($so1[2]) . "-" . trim($so1[1]) . "-" . trim($so1[0]) . " " . $so[1];

				$je = explode(' ', $JobEndDatetime);
				$je1 = explode('/', $je[0]);
				$JobEndDatetime = trim($je1[2]) . "-" . trim($je1[1]) . "-" . trim($je1[0]) . " " . $je[1];

				$LoadInfo = array('JobStartDatetime' => $JobStartDatetime, 'SiteInDatetime' => $SiteInDatetime, 'SiteOutDatetime' => $SiteOutDatetime, 'JobEndDatetime' => $JobEndDatetime);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);


				/* =================== Site Logs ===================  */
				$LoadInfoJson = json_encode($LoadInfo);
				$condJson = json_encode($cond);

				$SiteLogInfo = array(
					'TableName' => 'tbl_booking_loads1',
					'PrimaryID' => $LoadID,
					'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
					'OldValue'        => $oldValueJson,
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'conveyance date update',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
				/* ===================================== */

				if ($update) {

					$conditions = array('LoadID ' => $LoadID);
					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);
					$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data['LoadInfo']->TonBook == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
					$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';

					$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;

					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
					<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
						<div style="width:100%; " >
							<div style="width:35%;float: left;" > 		
								<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
							</div>
							<div style="width:65%;float: right;text-align: right;" > 		 
								<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
								' . $PDFContent[0]->address . ' <br/> 
								<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
							</div>
						</div>	
						<div style="width:100%;float: left;" >   
							<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
							<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
							<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/><hr>
							<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
							<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
							<div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
							<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
							<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
							' . $siteInDateTime . '
							' . $siteOutDateTime . '
							<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
							<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
							<b>Tip Address: </b> ' . $data['LoadInfo']->TipName . ',' . $data['LoadInfo']->Street1 . ',' . $data['LoadInfo']->Street2 . ',
							' . $data['LoadInfo']->Town . ',' . $data['LoadInfo']->County . ',' . $data['LoadInfo']->PostCode . '<br>		 		  
							<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/>
							<b>Material: </b> ' . $MaterialText . '  <br> 
							<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
							<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
							<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
						</div>
						<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName . '<br><br>
							<div style="font-size: 9px;"> 
								<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
								<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
								' . $PDFContent[0]->FooterText . '  
							</div>
						</div>  
					</div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "assets/conveyance/" . $data['LoadInfo']->ReceiptName;
					$mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					$this->session->set_flashdata('success', 'Date has been updated successfully');


					/* =================== Site Logs ===================  */
					$OldFile = $pdfFilePath;
					$NewFileName = date('YmdHis') . ".pdf";
					$NewFile = WEB_ROOT_PATH . "/assets/conveyance/" . $NewFileName;

					copy($OldFile, $NewFile);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'FileName' => $NewFileName,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'conveyance date update pdf ',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					/* ===================================== */


					redirect('ConveyanceTickets');

				} else {
					redirect('ConveyanceTickets');
				}
			}

		}
	}

	function DateUpdateDeliveryAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			$data['TicketNo'] = $this->input->post('TicketNo');
			$data['SiteIn'] = $this->input->post('SiteInDateTime');
			$data['JobStart'] = $this->input->post('JobStartDateTime');
			$data['SiteOut'] = $this->input->post('SiteOutDateTime');
			$data['JobEnd'] = $this->input->post('JobEndDateTime');

			$html = $this->load->view('Booking/DateUpdateDeliveryAjax', $data, true);
			echo json_encode($html);

		}
	}
	function DateUpdateDelivery($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}
			// Fetch OLD data BEFORE update
			$oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
			// print_r($oldData);
			// exit;
			$oldValueArray = [];
			if ($oldData) {
				if (isset($oldData->JobStartDateTime)) {
					$oldValueArray['JobStartDatetime'] = $oldData->JobStartDateTime;
				}
				if (isset($oldData->SiteInDateTime)) {
					$oldValueArray['SiteInDatetime'] = $oldData->SiteInDateTime;
				}
				if (isset($oldData->SiteOutDateTime)) {
					$oldValueArray['SiteOutDatetime'] = $oldData->SiteOutDateTime;
				}
				if (isset($oldData->JobEndDateTime)) {
					$oldValueArray['JobEndDatetime'] = $oldData->JobEndDateTime;
				}
			}
			$oldValueJson = json_encode($oldValueArray);

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$JobStartDatetime = $this->input->post('JobStartDatetime');
				$SiteInDatetime = $this->input->post('SiteInDatetime');
				$SiteOutDatetime = $this->input->post('SiteOutDatetime');
				$JobEndDatetime = $this->input->post('JobEndDatetime');
				$LoadID = $this->input->post('LoadID');
				$TicketNo = $this->input->post('TicketNo');

				$js = explode(' ', $JobStartDatetime);
				$js1 = explode('/', $js[0]);
				$JobStartDatetime = trim($js1[2]) . "-" . trim($js1[1]) . "-" . trim($js1[0]) . " " . $js[1];

				$si = explode(' ', $SiteInDatetime);
				$si1 = explode('/', $si[0]);
				$SiteInDatetime = trim($si1[2]) . "-" . trim($si1[1]) . "-" . trim($si1[0]) . " " . $si[1];

				$so = explode(' ', $SiteOutDatetime);
				$so1 = explode('/', $so[0]);
				$SiteOutDatetime = trim($so1[2]) . "-" . trim($so1[1]) . "-" . trim($so1[0]) . " " . $so[1];

				$je = explode(' ', $JobEndDatetime);
				$je1 = explode('/', $je[0]);
				$JobEndDatetime = trim($je1[2]) . "-" . trim($je1[1]) . "-" . trim($je1[0]) . " " . $je[1];

				$LoadInfo = array('JobStartDatetime' => $JobStartDatetime, 'SiteInDatetime' => $SiteInDatetime, 'SiteOutDatetime' => $SiteOutDatetime, 'JobEndDatetime' => $JobEndDatetime);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				/* =================== Site Logs ===================  */
				$LoadInfoJson = json_encode($LoadInfo);
				$condJson = json_encode($cond);

				$SiteLogInfo = array(
					'TableName' => 'tbl_booking_loads1',
					'PrimaryID' => $LoadID,
					'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
					'OldValue'        => $oldValueJson,
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'delivery date update',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
				/* ===================================== */

				if ($update) {
					$conditions = array('LoadID ' => $LoadID);

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();

					$data1['tickets'] = $this->Booking_model->BookingTicketInfo($TicketNo);

					$tInfo = array('ReceiptName' => $data1['tickets']['TicketUniqueID'] . ".pdf");
					$tcond = array('LoadID' => $LoadID);
					$this->Common_model->update("tbl_booking_loads1", $tInfo, $tcond);

					$tInfo1 = array('pdf_name' => $data1['tickets']['TicketUniqueID'] . ".pdf");
					$tcond1 = array('TicketNo' => $TicketNo);
					$this->Common_model->update("tbl_tickets", $tInfo1, $tcond1);

					$LT = '';
					if ($data1['tickets']['LorryType'] == 1) {
						$LT = 'Tipper';
					} else if ($data1['tickets']['LorryType'] == 2) {
						$LT = 'Grab';
					} else if ($data1['tickets']['LorryType'] == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data1['tickets']['TonBook'] == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$MaterialText = $data1['tickets']['MaterialName'] . ' Delivered ' . $LT . ' ' . $TB;

					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
							<div style="width:100%;float: left;" >    
								<b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
								<b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
								<b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
								<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
								<b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>		 
								<b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>		   
								<b>In Time: </b> ' . $data1['tickets']['SiteIn'] . ' <br>		   
								<b>Out Time: </b> ' . $data1['tickets']['SiteOut'] . ' <br>		   
								<b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
								<b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
								<b>Driver Name: </b> ' . $data1['tickets']['DriverName'] . '<br> 
								<b>Driver Signature: </b> <br> 
								<div><img src="/assets/DriverSignature/' . $data1['tickets']['dsignature'] . '" width ="100" height="40" style="float:left"> </div>
								<b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
								<b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
								<b>Tip Address: </b> ' . $data1['tickets']['TipName'] . ', ' . $data1['tickets']['Street1'] . ', ' . $data1['tickets']['Street2'] . ', ' . $data1['tickets']['Town'] . ', ' . $data1['tickets']['County'] . ', ' . $data1['tickets']['PostCode'] . ',								<br>	 
								<b>Waste License No:  </b>' . $data1['tickets']['PermitRefNo'] . ' <br> 
								<b>Material:  ' . $MaterialText . ' <br></b> 
								<b>SIC Code: </b> ' . $data1['tickets']['LoadSICCODE'] . ' <br> 
								<b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>		 
								<b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
								<b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
								<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
							<div style="width:100%;float: left;" > 
								<b>Received By: </b><br> 
								<div><img src="/uploads/Signature/' . $data1['tickets']['Signature'] . '" width ="100" height="40" style="float:left"></div> 
								' . $data1['tickets']['CustomerName'] . ' 
								<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data1['tickets']['TicketUniqueID'] . ".pdf";
					$mpdf = new mPDF('utf-8', array(70, 220), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					/* =================== Site Logs ===================  */
					$OldFile = $pdfFilePath;
					$NewFileName = date('YmdHis') . ".pdf";
					$NewFile = WEB_ROOT_PATH . "/assets/conveyance/" . $NewFileName;

					copy($OldFile, $NewFile);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'FileName' => $NewFileName,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'delivery date update pdf',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					/* ===================================== */


					$this->session->set_flashdata('success', 'Date has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Please Try Again Later');
				}
				redirect('DeliveryTickets');
			}

		}
	}


	function AddBookingRequestDaywork()
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');
				$this->form_validation->set_rules('ContactMobile', 'Site Contact Mobile', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
					$CompName = $this->security->xss_clean($this->input->post('CompName'));

					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$OppoName = $this->security->xss_clean($this->input->post('OppoName'));
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));

					//$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber')); 
					//$OpenPO = $this->security->xss_clean($this->input->post('OpenPO')); 
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					$DayWorkType = $this->security->xss_clean($this->input->post('DayWorkType'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));


					//$JourneyHour = $this->security->xss_clean($this->input->post('JourneyHour'));
					//$JourneyMin = $this->security->xss_clean($this->input->post('JourneyMin'));

					//$JourneyTime = $JourneyHour.":".$JourneyMin;
					$JourneyTime = $this->security->xss_clean($this->input->post('JourneyTime'));

					$StartTime = $this->security->xss_clean($this->input->post('StartTime'));
					$FinishTime = $this->security->xss_clean($this->input->post('FinishTime'));

					if ($CompanyID == '0') {
						if (trim($CompanyName) == '') {
							$this->session->set_flashdata('error', 'Company Name Must Not be blank');
							redirect('BookingsRequest');
						}
						$CompanyID = $this->generateRandomString();
						$CompanyInfo = array('CompanyID' => $CompanyID, 'CompanyIDMapKey' => $CompanyID, 'CompanyName' => $CompanyName, 'status' => 1, 'CreateDate' => date('Y-m-d H:i:s'));
						$this->Common_model->insert("tbl_company", $CompanyInfo);
					}
					if ($OpportunityID == '0') {
						if (trim($Street1) == '' && trim($Town) == '' && trim($County) == '' && trim($PostCode) == '') {
							$this->session->set_flashdata('error', 'Opportunity Must Not be blank');
							redirect('BookingsRequest');
						}
						$OpportunityID = $this->generateRandomString();
						$OpportunityName = $Street1 . ", " . $Street2 . ", " . $Town . ", " . $County . ", " . $PostCode;
						$OppoName = $OpportunityName;
						$OppoInfo = array(
							'OpportunityID' => $OpportunityID,
							'OpportunityIDMapKey' => $OpportunityID,
							'OpportunityName' => $OpportunityName,
							'OpenDate' => date("Y-m-d"),
							'Street1' => $Street1,
							'Street2' => $Street2,
							'Town' => $Town,
							'County' => $County,
							'PostCode' => $PostCode,
							'Status' => 1
						);
						$this->Common_model->insert("tbl_opportunities", $OppoInfo);

						$CO = array('OpportunityID' => $OpportunityID, 'CompanyID' => $CompanyID);
						$this->Common_model->insert("tbl_company_to_opportunities", $CO);

						$LoadInfo = array('TipID' => '1', 'OpportunityID' => $OpportunityID, 'TipRefNo' => '', 'Status' => '0');
						$this->Common_model->insert("tbl_opportunity_tip", $LoadInfo);


					}
					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('BookingsRequest');
						}
						if (trim($ContactMobile) == '') {
							$this->session->set_flashdata('error', 'Contact Mobile Must Not be blank');
							redirect('BookingsRequest');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}

					$BookingInfo = array(
						'CompanyID' => $CompanyID,
						'CompanyName' => $CompName,
						'OpportunityID' => $OpportunityID,
						'OpportunityName' => $OppoName,
						'Street1' => $Street1,
						'Street2' => $Street2,
						'Town' => $Town,
						'County' => $County,
						'PostCode' => $PostCode,
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'JourneyTime' => $JourneyTime,
						'StartTime' => $StartTime,
						'FinishTime' => $FinishTime,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'BookedBy' => $this->session->userdata['userId'],
						'Status' => 1
					);
					$BookingRequestID = $this->Common_model->insert("tbl_booking_request", $BookingInfo);
					if ($BookingRequestID) {

						/* ========================================================================= */
						$LoadInfoJson = json_encode($BookingInfo);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_request',
							'PrimaryID' => $BookingRequestID,
							'UpdatedValue' => $LoadInfoJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'Add Booking Request DayWork',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ========================================================================= */


						for ($i = 0; $i < count($BookingType); $i++) {
							if ($BookingType[$i] != "" && $DescriptionofMaterial[$i] != "" && $BookingDateTime[$i] != "") {
								$OP = 0;
								if (is_null($OpenPO[$i])) {
									$OP = 0;
								} else {
									$OP = $OpenPO[$i];
								}

								$BookingInfo = array(
									'BookingRequestID' => $BookingRequestID,
									'BookingType' => '3',
									'MaterialID' => $DescriptionofMaterial[$i],
									'DayWorkType' => $DayWorkType[$i],
									'LoadType' => $LoadType[$i],
									'LorryType' => $LorryType[$i],
									'MaterialName' => $MaterialName[$i],
									'Loads' => $Loads[$i],
									'Days' => '1',
									'Price' => $Price[$i],
									'SICCode' => $SICCode[$i],
									'PurchaseOrderNo' => $PurchaseOrderNo[$i],
									'OpenPO' => $OP,
									'TotalAmount' => $TotalHidden[$i],
									'BookedBy' => $this->session->userdata['userId']
								);
								$BookingID = '';
								$BookingID = $this->Common_model->insert("tbl_booking1", $BookingInfo);
								if ($BookingID) {

									/* ========================================================================= */
									$LoadInfoJson = json_encode($BookingInfo);

									$SiteLogInfo = array(
										'TableName' => 'tbl_booking1',
										'PrimaryID' => $BookingID,
										'UpdatedValue' => $LoadInfoJson,
										'UpdatedByUserID' => $this->session->userdata['userId'],
										'SitePage' => 'Add Booking Request DayWork',
										'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
										'BrowserAgent' => getBrowserAgent(),
										'AgentString' => $this->agent->agent_string(),
										'UserPlatform' => $this->agent->platform()
									);
									$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
									/* ========================================================================= */


									$BDT = '';
									$BDT = explode(',', $BookingDateTime[$i]);
									$BookingDate = array();
									for ($j = 0; $j < count($BDT); $j++) {
										$B = '';
										$B = explode('/', $BDT[$j]);
										//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0]; 
										$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
									}
									sort($BookingDate);
									for ($k = 0; $k < count($BookingDate); $k++) {
										$BookingDateInfo = array(
											'BookingRequestID' => $BookingRequestID,
											'BookingID' => $BookingID,
											'BookingDate' => $BookingDate[$k],
											'ApproveLoads' => $Loads[$i],
											'BookedBy' => $this->session->userdata['userId']
										);
										$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
										if ($insDate) {

											/* ========================================================================= */
											$LoadInfoJson = json_encode($BookingDateInfo);

											$SiteLogInfo = array(
												'TableName' => 'tbl_booking_date1',
												'PrimaryID' => $insDate,
												'UpdatedValue' => $LoadInfoJson,
												'UpdatedByUserID' => $this->session->userdata['userId'],
												'SitePage' => 'Add Booking Request DayWork',
												'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
												'BrowserAgent' => getBrowserAgent(),
												'AgentString' => $this->agent->agent_string(),
												'UserPlatform' => $this->agent->platform()
											);
											$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
											/* ========================================================================= */


											if ($Price[$i] != '' && $Price[$i] != 0) {
												if ($k == 0) {
													$ProductInfo = array(
														'OpportunityID' => $OpportunityID,
														'MaterialID' => $DescriptionofMaterial[$i],
														'SICCode' => $SICCode[$i],
														'BookingDateID' => $insDate,
														'BookingID' => $BookingID,
														'DateRequired' => $BookingDate[$k],
														'UnitPrice' => $Price[$i],
														'LorryType' => $LorryType[$i],
														'PurchaseOrderNo' => $PurchaseOrderNo[$i],
														'Qty' => $Loads[$i],
														'PriceType' => '0',
														'CreateUserID' => $this->session->userdata['userId'],
														'EditUserID' => $this->session->userdata['userId']
													);
													$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

													/* ========================================================================= */
													$LoadInfoJson = json_encode($ProductInfo);

													$SiteLogInfo = array(
														'TableName' => 'tbl_product',
														'PrimaryID' => $PID,
														'UpdatedValue' => $LoadInfoJson,
														'UpdatedByUserID' => $this->session->userdata['userId'],
														'SitePage' => 'Add Booking Request DayWork',
														'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
														'BrowserAgent' => getBrowserAgent(),
														'AgentString' => $this->agent->agent_string(),
														'UserPlatform' => $this->agent->platform()
													);
													$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
													/* ========================================================================= */

												}
											}
										}
									}
								}
							}
						}
						$this->session->set_flashdata('success', 'Booking has been Added successfully');
					} else {
						$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');
					}
					redirect('BookingRequest');
				}
			}

			$data['company_list'] = $this->Common_model->CompanyList();
			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			//$data['material_list'] = $this->Booking_model->GetMaterials('4');   	

			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$data['county'] = $this->Common_model->get_all('county');
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : ADD Booking Request Daywork';
			$this->global['active_menu'] = 'addbooking';

			$this->loadViews("Booking/AddBookingRequestDaywork", $this->global, $data, NULL);
		}
	}

	function EditBookingRequestDaywork($BookingRequestID)
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($BookingRequestID == null) {
				redirect('BookingRequest');
			}
			//echo $BookingRequestID ; 
			//exit;
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');

				if ($this->form_validation->run()) {


					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));

					//$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber')); 
					//$OpenPO = $this->security->xss_clean($this->input->post('OpenPO')); 
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingID = $this->security->xss_clean($this->input->post('BookingID'));
					$TotalLoadAllocated = $this->security->xss_clean($this->input->post('TotalLoadAllocated'));
					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$DayWorkType = $this->security->xss_clean($this->input->post('DayWorkType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));

					//$JourneyHour = $this->security->xss_clean($this->input->post('JourneyHour'));
					//$JourneyMin = $this->security->xss_clean($this->input->post('JourneyMin'));

					//$JourneyTime = $JourneyHour.":".$JourneyMin;
					$JourneyTime = $this->security->xss_clean($this->input->post('JourneyTime'));

					$StartTime = $this->security->xss_clean($this->input->post('StartTime'));
					$FinishTime = $this->security->xss_clean($this->input->post('FinishTime'));

					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('Bookings');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactIDMapKey' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail);
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail);
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}

					$BookingInfo = array(
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'JourneyTime' => $JourneyTime,
						'StartTime' => $StartTime,
						'FinishTime' => $FinishTime,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'UpdatedBy' => $this->session->userdata['userId']
					);
					$cond = array('BookingRequestID' => $BookingRequestID);
					$isUpdate = $this->Common_model->update("tbl_booking_request", $BookingInfo, $cond);

					/* ========================================================================= */
					$LoadInfoJson = json_encode($BookingInfo);
					$condJson = json_encode($cond);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_request',
						'PrimaryID' => $BookingRequestID,
						'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'Edit Booking Request DayWork',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					/* ========================================================================= */

					//if($isUpdate){ 
					$BArray = array();
					foreach ($BookingID as $key => $value) {
						$BArray[] = $value;
					}
					//var_dump($_POST);  				 
					//exit;
					//echo count($BookingID);
					for ($i = 0; $i < count($BArray); $i++) {

						if ($TotalLoadAllocated[$BArray[$i]] == 0) {
							if ($BookingType[$BArray[$i]] != "" && $DescriptionofMaterial[$BArray[$i]] != "" && $BookingDateTime[$BArray[$i]] != "") {

								$OP = 0;
								if (is_null($OpenPO[$BArray[$i]])) {
									$OP = 0;
								} else {
									$OP = $OpenPO[$BArray[$i]];
								}

								$BookingInfo = array(
									'BookingType' => '3',
									'MaterialID' => $DescriptionofMaterial[$BArray[$i]],
									'DayWorkType' => $DayWorkType[$BArray[$i]],
									'LoadType' => $LoadType[$BArray[$i]],
									'LorryType' => $LorryType[$BArray[$i]],
									'MaterialName' => $MaterialName[$BArray[$i]],
									'Loads' => $Loads[$BArray[$i]],
									'Days' => '1',
									'Price' => $Price[$BArray[$i]],
									'SICCode' => $SICCode[$BArray[$i]],
									'PurchaseOrderNo' => $PurchaseOrderNo[$BArray[$i]],
									'OpenPO' => $OP,
									'TotalAmount' => $TotalHidden[$BArray[$i]],
									'UpdatedBy' => $this->session->userdata['userId']
								);
								$cond1 = array('BookingID' => $BArray[$i]);
								$this->Common_model->update("tbl_booking1", $BookingInfo, $cond1);

								/* ========================================================================= */
								$LoadInfoJson = json_encode($BookingInfo);
								$condJson = json_encode($cond1);

								$SiteLogInfo = array(
									'TableName' => 'tbl_booking1',
									'PrimaryID' => $BArray[$i],
									'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
									'UpdatedByUserID' => $this->session->userdata['userId'],
									'SitePage' => 'Edit Booking Request DayWork',
									'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
									'BrowserAgent' => getBrowserAgent(),
									'AgentString' => $this->agent->agent_string(),
									'UserPlatform' => $this->agent->platform()
								);
								$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
								/* ========================================================================= */

								//if($BookingID){
								$Delte_Where = array('BookingID' => $BArray[$i]);
								$this->Common_model->delete("tbl_booking_date1", $Delte_Where);
								$this->Common_model->delete("tbl_product", $Delte_Where);

								$BDT = '';
								$BDT = explode(',', $BookingDateTime[$BArray[$i]]);
								$BookingDate = array();
								for ($j = 0; $j < count($BDT); $j++) {
									$B = '';
									$B = explode('/', $BDT[$j]);
									//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0] ; 
									$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
								}
								sort($BookingDate);
								for ($k = 0; $k < count($BookingDate); $k++) {
									$BookingDateInfo = array(
										'BookingRequestID' => $BookingRequestID,
										'BookingID' => $BArray[$i],
										'BookingDate' => $BookingDate[$k],
										'ApproveLoads' => $Loads[$BArray[$i]],
										'BookedBy' => $this->session->userdata['userId'],
										'UpdatedBy' => $this->session->userdata['userId']
									);
									$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
									if ($insDate) {

										/* ========================================================================= */
										$LoadInfoJson = json_encode($BookingDateInfo);

										$SiteLogInfo = array(
											'TableName' => 'tbl_booking_date1',
											'PrimaryID' => $insDate,
											'UpdatedValue' => $LoadInfoJson,
											'UpdatedByUserID' => $this->session->userdata['userId'],
											'SitePage' => 'Edit Booking Request DayWork',
											'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
											'BrowserAgent' => getBrowserAgent(),
											'AgentString' => $this->agent->agent_string(),
											'UserPlatform' => $this->agent->platform()
										);
										$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
										/* ========================================================================= */


										if ($Price[$BArray[$i]] != '' && $Price[$BArray[$i]] != 0) {
											if ($k == 0) {
												$ProductInfo = array(
													'OpportunityID' => $OpportunityID,
													'MaterialID' => $DescriptionofMaterial[$BArray[$i]],
													'SICCode' => $SICCode[$BArray[$i]],
													'BookingDateID' => $insDate,
													'BookingID' => $BArray[$i],
													'DateRequired' => $BookingDate[$k],
													'UnitPrice' => $Price[$BArray[$i]],
													'LorryType' => $LorryType[$BArray[$i]],
													'PurchaseOrderNo' => $PurchaseOrderNo[$BArray[$i]],
													'Qty' => $Loads[$BArray[$i]],
													'CreateUserID' => $this->session->userdata['userId'],
													'EditUserID' => $this->session->userdata['userId']
												);
												$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

												/* ========================================================================= */
												$LoadInfoJson = json_encode($ProductInfo);

												$SiteLogInfo = array(
													'TableName' => 'tbl_product',
													'PrimaryID' => $PID,
													'UpdatedValue' => $LoadInfoJson,
													'UpdatedByUserID' => $this->session->userdata['userId'],
													'SitePage' => 'Edit Booking Request DayWork',
													'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
													'BrowserAgent' => getBrowserAgent(),
													'AgentString' => $this->agent->agent_string(),
													'UserPlatform' => $this->agent->platform()
												);
												$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
												/* ========================================================================= */


											}
										}
									}
								}
								//} //if($BookingID){
							}
						}

					}

					$this->session->set_flashdata('success', 'Booking has been Updated successfully');
					//}else{
					//	$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');                 
					//}
					//exit;
					redirect('BookingRequest');
				}
			}

			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			$BookingReqInfo = array('BookingRequestID' => $BookingRequestID);
			$data['BookingRequest'] = $this->Common_model->select_where('tbl_booking_request', $BookingReqInfo);
			$data['OppoContact'] = $this->Booking_model->getContactsByOpportunity($data['BookingRequest']['OpportunityID']);
			$data['BookingDates'] = $this->Booking_model->GetBookingRequestDates($BookingRequestID);


			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Edit DayWork Booking Request';
			$this->global['active_menu'] = 'editbooking';

			$this->loadViews("Booking/EditBookingRequestDaywork", $this->global, $data, NULL);
		}
	}


	function AddBookingRequestHaulage()
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');
				$this->form_validation->set_rules('ContactMobile', 'Site Contact Mobile', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
					$CompName = $this->security->xss_clean($this->input->post('CompName'));

					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$OppoName = $this->security->xss_clean($this->input->post('OppoName'));
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));

					//$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber')); 
					//$OpenPO = $this->security->xss_clean($this->input->post('OpenPO')); 
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));

					$TipName = $this->security->xss_clean($this->input->post('TipName'));
					$tip_long = $this->security->xss_clean($this->input->post('tip_long'));
					$tip_lat = $this->security->xss_clean($this->input->post('tip_lat'));
					//$TStreet1 = $this->security->xss_clean($this->input->post('TStreet1')); 
					//$TStreet2 = $this->security->xss_clean($this->input->post('TStreet2')); 
					//$TTown = $this->security->xss_clean($this->input->post('TTown')); 
					//$TCounty = $this->security->xss_clean($this->input->post('TCounty')); 
					//$TPostCode = $this->security->xss_clean($this->input->post('TPostCode')); 

					if ($TipName != '') {
						for ($i = 0; $i < count($BookingType); $i++) {
							//$TipName = $TStreet1[$i].",".$TStreet2[$i].",".$TTown[$i].",".$TCounty[$i].",".$TPostCode[$i];
							$TipInfo = array('TipName' => $TipName[$i], 'tip_long' => $tip_long[$i], 'tip_lat' => $tip_lat[$i], 'RandomTip' => '1', 'CreatedBy' => $this->session->userdata['userId']);

							/*$TipInfo = array( 'TipName' => $TipName ,'Street1' => $TStreet1[$i] ,'Street2' => $TStreet2[$i] ,
																												'Town' => $TTown[$i] ,'County' => $TCounty[$i] ,'PostCode' => $TPostCode[$i] ,
																												'RandomTip'=>'1','CreatedBy'=>$this->session->userdata['userId']);  */

							$TipID = $this->Common_model->insert("tbl_tipaddress", $TipInfo);
						}
					}

					if ($CompanyID == '0') {
						if (trim($CompanyName) == '') {
							$this->session->set_flashdata('error', 'Company Name Must Not be blank');
							redirect('BookingsRequest');
						}
						$CompanyID = $this->generateRandomString();
						$CompanyInfo = array('CompanyID' => $CompanyID, 'CompanyIDMapKey' => $CompanyID, 'CompanyName' => $CompanyName, 'status' => 1, 'CreateDate' => date('Y-m-d H:i:s'));
						$this->Common_model->insert("tbl_company", $CompanyInfo);
					}
					if ($OpportunityID == '0') {
						if (trim($Street1) == '' && trim($Town) == '' && trim($County) == '' && trim($PostCode) == '') {
							$this->session->set_flashdata('error', 'Opportunity Must Not be blank');
							redirect('BookingsRequest');
						}
						$OpportunityID = $this->generateRandomString();
						$OpportunityName = $Street1 . ", " . $Street2 . ", " . $Town . ", " . $County . ", " . $PostCode;
						$OppoName = $OpportunityName;
						$OppoInfo = array(
							'OpportunityID' => $OpportunityID,
							'OpportunityIDMapKey' => $OpportunityID,
							'OpportunityName' => $OpportunityName,
							'OpenDate' => date("Y-m-d"),
							'Street1' => $Street1,
							'Street2' => $Street2,
							'Town' => $Town,
							'County' => $County,
							'PostCode' => $PostCode,
							'Status' => 1
						);
						$this->Common_model->insert("tbl_opportunities", $OppoInfo);

						$CO = array('OpportunityID' => $OpportunityID, 'CompanyID' => $CompanyID);
						$this->Common_model->insert("tbl_company_to_opportunities", $CO);

						$LoadInfo = array('TipID' => '1', 'OpportunityID' => $OpportunityID, 'TipRefNo' => '', 'Status' => '0');
						$this->Common_model->insert("tbl_opportunity_tip", $LoadInfo);


					}
					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('BookingsRequest');
						}
						if (trim($ContactMobile) == '') {
							$this->session->set_flashdata('error', 'Contact Mobile Must Not be blank');
							redirect('BookingsRequest');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}

					$BookingInfo = array(
						'CompanyID' => $CompanyID,
						'CompanyName' => $CompName,
						'OpportunityID' => $OpportunityID,
						'OpportunityName' => $OppoName,
						'Street1' => $Street1,
						'Street2' => $Street2,
						'Town' => $Town,
						'County' => $County,
						'PostCode' => $PostCode,
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'BookedBy' => $this->session->userdata['userId'],
						'Status' => 1
					);
					$BookingRequestID = $this->Common_model->insert("tbl_booking_request", $BookingInfo);
					if ($BookingRequestID) {

						/* ========================================================================= */
						$LoadInfoJson = json_encode($BookingInfo);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_request',
							'PrimaryID' => $BookingRequestID,
							'UpdatedValue' => $LoadInfoJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'Add Booking Request Haulage',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ========================================================================= */


						for ($i = 0; $i < count($BookingType); $i++) {
							if ($BookingType[$i] != "" && $DescriptionofMaterial[$i] != "" && $BookingDateTime[$i] != "") {
								$OP = 0;
								if (is_null($OpenPO[$i])) {
									$OP = 0;
								} else {
									$OP = $OpenPO[$i];
								}

								$BookingInfo = array(
									'BookingRequestID' => $BookingRequestID,
									'TipID' => $TipID,
									'BookingType' => '4',
									'MaterialID' => $DescriptionofMaterial[$i],
									'LoadType' => $LoadType[$i],
									'LorryType' => $LorryType[$i],
									'MaterialName' => $MaterialName[$i],
									'Loads' => $Loads[$i],
									'Days' => '1',
									'Price' => $Price[$i],
									'SICCode' => $SICCode[$i],
									'PurchaseOrderNo' => $PurchaseOrderNo[$i],
									'OpenPO' => $OP,
									'TotalAmount' => $TotalHidden[$i],
									'BookedBy' => $this->session->userdata['userId']
								);
								$BookingID = '';
								$BookingID = $this->Common_model->insert("tbl_booking1", $BookingInfo);
								if ($BookingID) {

									/* ========================================================================= */
									$LoadInfoJson = json_encode($BookingInfo);

									$SiteLogInfo = array(
										'TableName' => 'tbl_booking1',
										'PrimaryID' => $BookingID,
										'UpdatedValue' => $LoadInfoJson,
										'UpdatedByUserID' => $this->session->userdata['userId'],
										'SitePage' => 'Add Booking Request Haulage',
										'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
										'BrowserAgent' => getBrowserAgent(),
										'AgentString' => $this->agent->agent_string(),
										'UserPlatform' => $this->agent->platform()
									);
									$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
									/* ========================================================================= */

									$BDT = '';
									$BDT = explode(',', $BookingDateTime[$i]);
									$BookingDate = array();
									for ($j = 0; $j < count($BDT); $j++) {
										$B = '';
										$B = explode('/', $BDT[$j]);
										//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0]; 
										$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
									}
									sort($BookingDate);
									for ($k = 0; $k < count($BookingDate); $k++) {
										$BookingDateInfo = array(
											'BookingRequestID' => $BookingRequestID,
											'BookingID' => $BookingID,
											'BookingDate' => $BookingDate[$k],
											'ApproveLoads' => $Loads[$i],
											'BookedBy' => $this->session->userdata['userId']
										);
										$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
										if ($insDate) {

											/* ========================================================================= */
											$LoadInfoJson = json_encode($BookingDateInfo);

											$SiteLogInfo = array(
												'TableName' => 'tbl_booking_date1',
												'PrimaryID' => $insDate,
												'UpdatedValue' => $LoadInfoJson,
												'UpdatedByUserID' => $this->session->userdata['userId'],
												'SitePage' => 'Add Booking Request Haulage',
												'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
												'BrowserAgent' => getBrowserAgent(),
												'AgentString' => $this->agent->agent_string(),
												'UserPlatform' => $this->agent->platform()
											);
											$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
											/* ========================================================================= */

											if ($Price[$i] != '' && $Price[$i] != 0) {
												if ($k == 0) {
													$ProductInfo = array(
														'OpportunityID' => $OpportunityID,
														'MaterialID' => $DescriptionofMaterial[$i],
														'TipID' => $TipID,
														'TipName' => $TipName[$i],
														'SICCode' => $SICCode[$i],
														'BookingDateID' => $insDate,
														'BookingID' => $BookingID,
														'DateRequired' => $BookingDate[$k],
														'UnitPrice' => $Price[$i],
														'LorryType' => $LorryType[$i],
														'PurchaseOrderNo' => $PurchaseOrderNo[$i],
														'Qty' => $Loads[$i],
														'PriceType' => '0',
														'CreateUserID' => $this->session->userdata['userId'],
														'EditUserID' => $this->session->userdata['userId']
													);
													$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

													/* ========================================================================= */
													$LoadInfoJson = json_encode($ProductInfo);

													$SiteLogInfo = array(
														'TableName' => 'tbl_product',
														'PrimaryID' => $PID,
														'UpdatedValue' => $LoadInfoJson,
														'UpdatedByUserID' => $this->session->userdata['userId'],
														'SitePage' => 'Add Booking Request Haulage',
														'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
														'BrowserAgent' => getBrowserAgent(),
														'AgentString' => $this->agent->agent_string(),
														'UserPlatform' => $this->agent->platform()
													);
													$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
													/* ========================================================================= */

												}
											}
										}
									}
								}
							}
						}

						$this->session->set_flashdata('success', 'Booking has been Added successfully');
					} else {
						$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');
					}
					redirect('BookingRequest');
				}
			}

			$data['company_list'] = $this->Common_model->CompanyList();
			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			//$data['material_list'] = $this->Booking_model->GetMaterials('4');   	

			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$data['county'] = $this->Common_model->get_all('county');
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : ADD Booking Request Haulage';
			$this->global['active_menu'] = 'addbooking';

			$this->loadViews("Booking/AddBookingRequestHaulage", $this->global, $data, NULL);
		}
	}
	function EditBookingRequestHaulage($BookingRequestID)
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($BookingRequestID == null) {
				redirect('BookingRequest');
			}
			//echo $BookingRequestID ; 
			//exit;
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));

					//$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber')); 
					//$OpenPO = $this->security->xss_clean($this->input->post('OpenPO')); 
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingID = $this->security->xss_clean($this->input->post('BookingID'));
					$TotalLoadAllocated = $this->security->xss_clean($this->input->post('TotalLoadAllocated'));
					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$DayWorkType = $this->security->xss_clean($this->input->post('DayWorkType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));

					$TipID = $this->security->xss_clean($this->input->post('TipID'));
					//$TStreet1 = $this->security->xss_clean($this->input->post('TStreet1')); 
					//$TStreet2 = $this->security->xss_clean($this->input->post('TStreet2')); 
					//$TTown = $this->security->xss_clean($this->input->post('TTown')); 
					//$TCounty = $this->security->xss_clean($this->input->post('TCounty')); 
					//$TPostCode = $this->security->xss_clean($this->input->post('TPostCode')); 


					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('Bookings');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactIDMapKey' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail);
						$this->Common_model->insert("tbl_contacts", $ConInfo);


						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail);
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}


					$BookingInfo = array(
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'UpdatedBy' => $this->session->userdata['userId']
					);
					$cond = array('BookingRequestID' => $BookingRequestID);
					$isUpdate = $this->Common_model->update("tbl_booking_request", $BookingInfo, $cond);


					/* ========================================================================= */
					$LoadInfoJson = json_encode($BookingInfo);
					$condJson = json_encode($cond);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_request',
						'PrimaryID' => $BookingRequestID,
						'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'Edit Booking Request Haulage',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					/* ========================================================================= */


					//if($isUpdate){ 
					$BArray = array();
					foreach ($BookingID as $key => $value) {
						$BArray[] = $value;
					}

					/*if($TStreet1 != '' ){   
																					for($i = 0; $i < count($BArray); $i++ ){   						 		 
																						$TipID[$BArray[$i]];
																						$TipID = $TipID[$BArray[$i]] ;
																						$TipName = $TStreet1[$BArray[$i]].",".$TStreet2[$BArray[$i]].",".$TTown[$BArray[$i]].",".$TCounty[$BArray[$i]].",".$TPostCode[$BArray[$i]];
																						$TipInfo = array( 'TipName' => $TipName ,'Street1' => $TStreet1[$BArray[$i]] ,'Street2' => $TStreet2[$BArray[$i]] ,
																						'Town' => $TTown[$BArray[$i]] ,'County' => $TCounty[$BArray[$i]] ,'PostCode' => $TPostCode[$BArray[$i]] );    
																						$cond = array( 'TipID' => $TipID); 							
																						$this->Common_model->update("tbl_tipaddress",$TipInfo, $cond);  
																					} 
																				} */


					//var_dump($_POST);  				 
					//exit;
					//echo count($BookingID);
					for ($i = 0; $i < count($BArray); $i++) {

						if ($TotalLoadAllocated[$BArray[$i]] == 0) {
							if ($BookingType[$BArray[$i]] != "" && $DescriptionofMaterial[$BArray[$i]] != "" && $BookingDateTime[$BArray[$i]] != "") {
								$OP = 0;
								if (is_null($OpenPO[$BArray[$i]])) {
									$OP = 0;
								} else {
									$OP = $OpenPO[$BArray[$i]];
								}

								$BookingInfo = array(
									'LoadType' => $LoadType[$BArray[$i]],
									'LorryType' => $LorryType[$BArray[$i]],
									'Loads' => $Loads[$BArray[$i]],
									'Days' => '1',
									'Price' => $Price[$BArray[$i]],
									'SICCode' => $SICCode[$BArray[$i]],
									'PurchaseOrderNo' => $PurchaseOrderNo[$BArray[$i]],
									'OpenPO' => $OpenPO[$BArray[$i]],
									'TotalAmount' => $TotalHidden[$BArray[$i]],
									'UpdatedBy' => $this->session->userdata['userId']
								);
								$cond1 = array('BookingID' => $BArray[$i]);
								$this->Common_model->update("tbl_booking1", $BookingInfo, $cond1);


								/* ========================================================================= */
								$LoadInfoJson = json_encode($BookingInfo);
								$condJson = json_encode($cond1);

								$SiteLogInfo = array(
									'TableName' => 'tbl_booking1',
									'PrimaryID' => $BArray[$i],
									'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
									'UpdatedByUserID' => $this->session->userdata['userId'],
									'SitePage' => 'Edit Booking Request Haulage',
									'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
									'BrowserAgent' => getBrowserAgent(),
									'AgentString' => $this->agent->agent_string(),
									'UserPlatform' => $this->agent->platform()
								);
								$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
								/* ========================================================================= */


								//if($BookingID){
								$Delte_Where = array('BookingID' => $BArray[$i]);
								$this->Common_model->delete("tbl_booking_date1", $Delte_Where);
								$this->Common_model->delete("tbl_product", $Delte_Where);

								$BDT = '';
								$BDT = explode(',', $BookingDateTime[$BArray[$i]]);
								$BookingDate = array();
								for ($j = 0; $j < count($BDT); $j++) {
									$B = '';
									$B = explode('/', $BDT[$j]);
									//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0] ; 
									$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
								}
								sort($BookingDate);
								for ($k = 0; $k < count($BookingDate); $k++) {
									$BookingDateInfo = array(
										'BookingRequestID' => $BookingRequestID,
										'BookingID' => $BArray[$i],
										'BookingDate' => $BookingDate[$k],
										'ApproveLoads' => $Loads[$BArray[$i]],
										'BookedBy' => $this->session->userdata['userId'],
										'UpdatedBy' => $this->session->userdata['userId']
									);
									$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
									if ($insDate) {

										/* ========================================================================= */
										$LoadInfoJson = json_encode($BookingDateInfo);

										$SiteLogInfo = array(
											'TableName' => 'tbl_booking_date1',
											'PrimaryID' => $insDate,
											'UpdatedValue' => $LoadInfoJson,
											'UpdatedByUserID' => $this->session->userdata['userId'],
											'SitePage' => 'Edit Booking Request Haulage',
											'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
											'BrowserAgent' => getBrowserAgent(),
											'AgentString' => $this->agent->agent_string(),
											'UserPlatform' => $this->agent->platform()
										);
										$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
										/* ========================================================================= */


										if ($Price[$BArray[$i]] != '' && $Price[$BArray[$i]] != 0) {
											if ($k == 0) {
												$ProductInfo = array(
													'OpportunityID' => $OpportunityID,
													'MaterialID' => $DescriptionofMaterial[$BArray[$i]],
													'SICCode' => $SICCode[$BArray[$i]],
													'BookingDateID' => $insDate,
													'BookingID' => $BArray[$i],
													'DateRequired' => $BookingDate[$k],
													'UnitPrice' => $Price[$BArray[$i]],
													'LorryType' => $LorryType[$BArray[$i]],
													'PurchaseOrderNo' => $PurchaseOrderNo[$BArray[$i]],
													'Qty' => $Loads[$BArray[$i]],
													'CreateUserID' => $this->session->userdata['userId'],
													'EditUserID' => $this->session->userdata['userId']
												);
												$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

												/* ========================================================================= */
												$LoadInfoJson = json_encode($ProductInfo);

												$SiteLogInfo = array(
													'TableName' => 'tbl_product',
													'PrimaryID' => $PID,
													'UpdatedValue' => $LoadInfoJson,
													'UpdatedByUserID' => $this->session->userdata['userId'],
													'SitePage' => 'Edit Booking Request Haulage',
													'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
													'BrowserAgent' => getBrowserAgent(),
													'AgentString' => $this->agent->agent_string(),
													'UserPlatform' => $this->agent->platform()
												);
												$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
												/* ========================================================================= */


											}
										}
									}
								}
								//} //if($BookingID){
							}
						}

					}

					$this->session->set_flashdata('success', 'Booking has been Updated successfully');
					//}else{
					//	$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');                 
					//}
					//exit;
					redirect('BookingRequest');
				}
			}

			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			$BookingReqInfo = array('BookingRequestID' => $BookingRequestID);
			$data['BookingRequest'] = $this->Common_model->select_where('tbl_booking_request', $BookingReqInfo);
			$data['OppoContact'] = $this->Booking_model->getContactsByOpportunity($data['BookingRequest']['OpportunityID']);
			$data['BookingDates'] = $this->Booking_model->GetBookingRequestDatesHaulage($BookingRequestID);


			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Edit Haulage Booking Request';
			$this->global['active_menu'] = 'editbooking';

			$this->loadViews("Booking/EditBookingRequestHaulage", $this->global, $data, NULL);
		}
	}
	function BookingRequestDayworkFinish($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			$conditions = array('LoadID ' => $LoadID);
			$data['LoadInfo'] = $this->Booking_model->BookingRequestLoadInfo($LoadID);

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$SiteInDateTime = date("Y-m-d H:i:s");
				$SiteOutDateTime = date("Y-m-d H:i:s");
				$JobEndDateTime = date("Y-m-d H:i:s");
				$Notes2 = $this->security->xss_clean($this->input->post('Notes2'));
				$CustomerName = $this->security->xss_clean($this->input->post('CustomerName'));

				$Signature = $this->input->post('Signature', FALSE);

				if ($Signature != "") {
					$Signature1 = str_replace('data:image/png;base64,', '', $Signature);
					$Signature1 = str_replace(' ', '+', $Signature1);
					$Signature1 = base64_decode($Signature1);


					$Signature = md5(date("dmYhisA")) . ".png";
					$file_name = './uploads/Signature/' . $Signature;
					file_put_contents($file_name, $Signature1);
				} else {
					$Signature = "";
				}

				$TicketUniqueID = $this->generateRandomString();

				$LoadInfo = array(
					'SiteInDateTime' => $SiteInDateTime,
					'SiteOutDateTime' => $SiteOutDateTime,
					'JobEndDateTime' => $JobEndDateTime,
					'Notes2' => $Notes2,
					'ReceiptName' => $TicketUniqueID . ".pdf",
					'Signature' => $Signature,
					'CustomerName' => $CustomerName,
					'Status' => 4
				);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);
				if ($update) {

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();

					$MaterialText = $data['LoadInfo']->MaterialName;

					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
					<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
						<div style="width:100%; " >
							<div style="width:35%;float: left;" > 		
								<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
							</div>
							<div style="width:65%;float: right;text-align: right;" > 		 
								<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
								' . $PDFContent[0]->address . ' <br/> 
								<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
							</div>
						</div>	
						<div style="width:100%;float: left;" >   
							<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
							<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
							<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/>  
							<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
							<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
							<div style="text-align: center;"><b>CONVEYANCE NOTE: </b> </div><br>
							<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
							<b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
							<b>In Time: </b>' . date("d-m-Y H:i") . ' <br>		 
							<b>Out Time: </b>' . date("d-m-Y H:i") . ' <br>		 
							<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
							<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		 
							<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/>
							<b>Material: </b> ' . $MaterialText . '  <br>  
							<b>SicCode: </b> ' . $MaterialText . '  <br>  
							<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
							<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
						</div>
						<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/' . $Signature . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName . '<br><br>
							<div style="font-size: 9px;"> 
								<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
								<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
								' . $PDFContent[0]->FooterText . '  
							</div>
						</div>  
					</div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $TicketUniqueID . '.pdf';
					$mpdf = new mPDF('utf-8', array(70, 180), '', '', 5, 5, 5, 5, 5, 5);
					//$mpdf->_setPageSize(array(70,180),'P');
					//$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
					//$mpdf->AddPage();
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					$this->session->set_flashdata('success', 'Booking DayWork has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');
				}

				redirect('RequestLoads');
			}
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking DayWork Updated';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/BookingRequestDayworkFinish", $this->global, $data, NULL);
		}
	}
	public function DayWorkTickets()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : DayWork Tickets';
			$this->global['active_menu'] = 'conveyance';

			$this->loadViews("Booking/DayWorkTickets", $this->global, $data, NULL);
		}
	}
	public function AjaxDayWorkTickets()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetDayWorkTickets();
		$this->ajax->send($data);
	}


	public function HaulageTickets()
	{
		if ($this->isView == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data = array();

			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Haulage Tickets';
			$this->global['active_menu'] = 'conveyance';

			$this->loadViews("Booking/HaulageTickets", $this->global, $data, NULL);
		}
	}
	public function AjaxHaulageTickets()
	{
		$this->load->library('ajax');
		$data = $this->Booking_model->GetHaulageTickets();
		$this->ajax->send($data);
	}

	function DateUpdateDayWorkAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');

			$data['SiteIn'] = $this->input->post('SiteInDateTime');
			$data['JobStart'] = $this->input->post('JobStartDateTime');
			$data['SiteOut'] = $this->input->post('SiteOutDateTime');
			$data['JobEnd'] = $this->input->post('JobEndDateTime');

			$html = $this->load->view('Booking/DateUpdateDayWorkAjax', $data, true);
			echo json_encode($html);

		}
	}
	function DateUpdateDayWork($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}
			// Fetch OLD data BEFORE update
			$oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
			// print_r($oldData);
			// exit;
			$oldValueArray = [];
			if ($oldData) {
				if (isset($oldData->JobStartDateTime)) {
					$oldValueArray['JobStartDatetime'] = $oldData->JobStartDateTime;
				}
				if (isset($oldData->SiteInDateTime)) {
					$oldValueArray['SiteInDatetime'] = $oldData->SiteInDateTime;
				}
				if (isset($oldData->SiteOutDateTime)) {
					$oldValueArray['SiteOutDatetime'] = $oldData->SiteOutDateTime;
				}
				if (isset($oldData->JobEndDateTime)) {
					$oldValueArray['JobEndDatetime'] = $oldData->JobEndDateTime;
				}
			}
			$oldValueJson = json_encode($oldValueArray);

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$JobStartDatetime = $this->input->post('JobStartDatetime');
				$SiteInDatetime = $this->input->post('SiteInDatetime');
				$SiteOutDatetime = $this->input->post('SiteOutDatetime');
				$JobEndDatetime = $this->input->post('JobEndDatetime');
				$LoadID = $this->input->post('LoadID');

				$js = explode(' ', $JobStartDatetime);
				$js1 = explode('/', $js[0]);
				$JobStartDatetime = trim($js1[2]) . "-" . trim($js1[1]) . "-" . trim($js1[0]) . " " . $js[1];

				$si = explode(' ', $SiteInDatetime);
				$si1 = explode('/', $si[0]);
				$SiteInDatetime = trim($si1[2]) . "-" . trim($si1[1]) . "-" . trim($si1[0]) . " " . $si[1];

				$so = explode(' ', $SiteOutDatetime);
				$so1 = explode('/', $so[0]);
				$SiteOutDatetime = trim($so1[2]) . "-" . trim($so1[1]) . "-" . trim($so1[0]) . " " . $so[1];

				$je = explode(' ', $JobEndDatetime);
				$je1 = explode('/', $je[0]);
				$JobEndDatetime = trim($je1[2]) . "-" . trim($je1[1]) . "-" . trim($je1[0]) . " " . $je[1];

				$LoadInfo = array('JobStartDatetime' => $JobStartDatetime, 'SiteInDatetime' => $SiteInDatetime, 'SiteOutDatetime' => $SiteOutDatetime, 'JobEndDatetime' => $JobEndDatetime);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				/* =================== Site Logs ===================  */
				$LoadInfoJson = json_encode($LoadInfo);
				$condJson = json_encode($cond);

				$SiteLogInfo = array(
					'TableName' => 'tbl_booking_loads1',
					'PrimaryID' => $LoadID,
					'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
					'OldValue'        => $oldValueJson,
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'DayWork date update',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);

				/* ===================================== */


				if ($update) {

					$conditions = array('LoadID ' => $LoadID);
					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data['LoadInfo']->TonBook == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
					$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';

					$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;

					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
					<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
						<div style="width:100%; " >
							<div style="width:35%;float: left;" > 		
								<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
							</div>
							<div style="width:65%;float: right;text-align: right;" > 		 
								<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
								' . $PDFContent[0]->address . ' <br/> 
								<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
							</div>
						</div>	
						<div style="width:100%;float: left;" >   
							<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
							<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
							<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/>  <hr>
							<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
							<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
							<div style="text-align: center;"><b>CONVEYANCE NOTE: </b> </div><br>
							<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
							<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
							' . $siteInDateTime . '
							' . $siteOutDateTime . '
							<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
							<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
							<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/> 	 		 
							<b>Material: </b> ' . $MaterialText . '  <br> 
							<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
							<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
							<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
						</div>
						<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName . '<br><br>
							<div style="font-size: 9px;"> 
								<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
								<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
								' . $PDFContent[0]->FooterText . '  
							</div>
						</div>  
					</div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data['LoadInfo']->ReceiptName;
					$mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					$this->session->set_flashdata('success', 'Date has been updated successfully');

					redirect('DayWorkTickets');

				} else {
					redirect('DayWorkTickets');
				}
			}

		}
	}

	function DayWorkTicketsTableMeta()
	{
		echo '{"Name":"DayWork","Action":true,"Column":[{"Name":"ConveyanceNo","Title":"Conv No","Searchable":true,"Class":null},{"Name":"SiteOutDateTime","Title":"DateTime","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Customer Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Job Site Address","Searchable":true,"Class":null}, {"Name":"PurchaseOrderNo","Title":"PO NO","Searchable":false,"Class":null},{"Name":"MaterialName","Title":"Product Description","Searchable":false,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"VehicleRegNo","Title":"VRNO","Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Searchable":true,"Class":null}, {"Name":"Status","Title":"Status","Searchable":true,"Class":null}]}';
	}

	function HaulageTicketsTableMeta()
	{
		echo '{"Name":"DayWork","Action":true,"Column":[{"Name":"ConveyanceNo","Title":"Conv No","Searchable":true,"Class":null},{"Name":"SiteOutDateTime2","Title":"DateTime","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Customer Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Job Site Address","Searchable":true,"Class":null}, {"Name":"PurchaseOrderNo","Title":"PO NO","Searchable":false,"Class":null},{"Name":"MaterialName","Title":"Product Description","Searchable":false,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"VehicleRegNo","Title":"VRNO","Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Searchable":true,"Class":null}, {"Name":"Status","Title":"Status","Searchable":true,"Class":null}]}';
	}

	function StatusUpdateDayWorkAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			$data['Status'] = $this->input->post('Status');
			$data['PDF'] = $this->input->post('PDF');

			$html = $this->load->view('Booking/StatusUpdateDayWorkAjax', $data, true);
			echo json_encode($html);
		}
	}

	function StatusUpdateDayWork($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$Status = $this->input->post('Status');
				$LoadID = $this->input->post('LoadID');

				$oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
	            $oldStatus = $oldData ? $oldData->Status : null;

				$LoadInfo = array('Status' => $Status);
				$cond = array('LoadID' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				 // Map status numbers to names
            $statusNames = [
                4 => 'Complete',
                5 => 'Cancel',
                6 => 'Waste Journey',
                7 => 'Invoice Cancel',
                8 => 'Invoice Cancel'
            ];
            $oldStatusName = isset($statusNames[$oldStatus]) ? $statusNames[$oldStatus] : 'Unknown';
            $newStatusName = isset($statusNames[$Status]) ? $statusNames[$Status] : 'Unknown';
				/* =================== Site Logs ===================  */
				$LoadInfoJson = json_encode($LoadInfo);
				$condJson = json_encode($cond);

				$SiteLogInfo = array(
					'TableName' => 'tbl_booking_loads1',
					'PrimaryID' => $LoadID,
					'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
					'OldValue' => json_encode(['Status' => $oldStatusName]),
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'Daywork Status update',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);

				/* ===================================== */

				if ($update) {
					if ($Status == 4) {
						$conditions = array('LoadID ' => $LoadID);
						$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

						$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
						$PDFContent = $PDFContentQRY->result();
						$LT = '';
						if ($data['LoadInfo']->LorryType == 1) {
							$LT = 'Tipper';
						} else if ($data['LoadInfo']->LorryType == 2) {
							$LT = 'Grab';
						} else if ($data['LoadInfo']->LorryType == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($data['LoadInfo']->TonBook == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
						$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';

						$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;

						$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
							<div style="width:100%; " >
								<div style="width:35%;float: left;" > 		
									<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
								</div>
								<div style="width:65%;float: right;text-align: right;" > 		 
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
									' . $PDFContent[0]->address . ' <br/> 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
								</div>
							</div>	
							<div style="width:100%;float: left;" >   
								<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
								<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
								<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/>  <hr>
								<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
								<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
								<div style="text-align: center;"><b>CONVEYANCE NOTE: </b> </div><br>
								<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
								<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
								' . $siteInDateTime . '
								' . $siteOutDateTime . '
								<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
								<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
								<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/> 	 		 
								<b>Material: </b> ' . $MaterialText . '  <br> 
								<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
								<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
								<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
							</div>
							<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
							<div style="width:100%;float: left;" >
								<b>Produced By: </b><br>
								<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
								' . $data['LoadInfo']->CustomerName . '<br><br>
								<div style="font-size: 9px;"> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
									<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
									' . $PDFContent[0]->FooterText . '  
								</div>
							</div>  
						</div></body></html>';

						$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data['LoadInfo']->ReceiptName;
						$mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);

						$this->session->set_flashdata('success', 'Date has been updated successfully');

						redirect('DayWorkTickets');
					}
					$this->session->set_flashdata('success', 'Status has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Please Try Again Later');
				}
				redirect('DayWorkTickets');
			}

		}
	}

	function DayWorkExcelExport()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			//var_dump($_POST); 			
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');

			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');

			$data['SplitExcelDayWorkTicketsAll'] = $this->Booking_model->SplitExcelDayWorkTicketsAll($CompanyName, $OpportunityName, $reservation, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $Status, $Search, $Price);
			//var_dump($data['SplitExcelDayWorkTicketsAll']); 
			//exit;
			$this->load->library("excel");
			//foreach( $data['SplitExcelDayWorkTicketsAll'] as $row){ 

			$object = new PHPExcel();
			//print_r($_POST); die;
			$object->setActiveSheetIndex(0);
			$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Driver Name", "VRNO", "Lorry Type", "Price", "Status");

			$column = 0;
			foreach ($table_columns as $field) {
				$object->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
				$column++;
			}

			$excel_row = 2;
			//$TPrice = 0; $TLoad = 0; 
			foreach ($data['SplitExcelDayWorkTicketsAll'] as $row) {
				$url = '';
				$Price = 0; //$Status = '';  

				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['ConveyanceNo']);
				if ($row['ReceiptName'] != "") {
					$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $row['ReceiptName']));
				}
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['SiteOutDateTime']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['CompanyName']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['OpportunityName']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['PurchaseOrderNo']);
				if ($row['MStatus'] == 1) {
					$LT = '';
					if ($row['LorryType'] == 1) {
						$LT = 'Tipper';
					} else if ($row['LorryType'] == 2) {
						$LT = 'Grab';
					} else if ($row['LorryType'] == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($row['TonBook'] == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$MaterialText = $row['MaterialName'] . ' ' . $LT . ' ' . $TB;
					$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
				} else {
					$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['MaterialName']);
				}
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['DriverName']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['VehicleRegNo']);

				$LT = '';
				if ($row['LorryType'] == 1) {
					$LT = 'Tipper';
				} else if ($row['LorryType'] == 2) {
					$LT = 'Grab';
				} else if ($row['LorryType'] == 3) {
					$LT = 'Bin';
				} else {
					$LT = '';
				}


				// Set the value for the cell
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $LT);
				if ($row['BookingMaterialID'] == $row['MaterialID']) {
					$Price = is_numeric($row['Price']) ? $row['Price'] : 0;
				} else {
					$Price = 0;
				}

				$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $Price);
				$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row['Status']);
				//$TLoad = $TLoad + 1;
				$excel_row++;
			}

			for ($i = 'A'; $i != $object->getActiveSheet()->getHighestColumn(); $i++) {
				$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
			}
			$FileName = date("Y-m-d-H:i") . ".xls";
			//} 


			// Remove anything which isn't a word, whitespace, number
			// or any of the following caracters -_~,;[](). 
			$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).])", '', $FileName);
			// Remove any runs of periods (thanks falstro!)
			$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

			//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
			$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

			header('Content-Type: application/vnd.ms-excel');
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
			header('Content-Disposition: attachment;filename="' . $FileName . '"');
			//$object_writer->save('php://output'); 

			ob_start();
			$object_writer->save("php://output");
			//$objWriter->save(base_url("12121212.xls")); 
			$xlsData = ob_get_contents();
			ob_end_clean();

			$response = array(
				'op' => 'ok',
				'FileName' => $FileName,
				'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
			);
			die(json_encode($response));
		}
	}

	function SplitExcelDayWorkAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$CompanyName = $this->input->post('CompanyName');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');

			$data['CompanyOppoRecords'] = $this->Booking_model->SplitExcelOppoGroupDayWork($CompanyName, $OpportunityName, $reservation, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $Status);

			$html = $this->load->view('Booking/SplitExcelDayWorkAjax', $data, true);
			echo json_encode($html);

		}
	}

	function SplitExcelExportDayWork()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			//var_dump($_POST); 			
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityID = $this->input->post('OpportunityID');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');

			$data['SplitExcelDayWorkTicketsAll'] = $this->Booking_model->SplitExcelDayWorkTickets($OpportunityID, $CompanyName, $OpportunityName, $reservation, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $Status, $Search, $Price);

			if (count($data['SplitExcelDayWorkTicketsAll']) > 0) {
				$Array = array();
				$xx = 0;

				foreach ($data['SplitExcelDayWorkTicketsAll'] as $row) {
					if ($xx == 0) {
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if ($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID']) {
					} else {
						$Array[] = $xx;
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if (count($data['SplitExcelDayWorkTicketsAll']) - 1 == $xx) {
						$xx++;
						$Array[] = $xx;
						break;
					} else {
						$xx++;
					}
				}
			}
			$this->load->library('zip');
			$this->load->library("excel");
			$xlsfiles = array();
			for ($j = 0; $j < count($Array); $j++) {
				$FileName = "";
				/* Header Start Excel  */
				$object = new PHPExcel();
				$object->setActiveSheetIndex(0);

				$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Driver Name", "VRNO", "Price", "Status");

				$column = 0;
				foreach ($table_columns as $field) {
					$object->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$column++;
				}
				$object->getActiveSheet()->getStyle('i:i')->getNumberFormat()->setFormatCode('0.00');
				$excel_row = 2;
				/* Header End Excel  */

				/* Records Start  For Each  */
				if ($j == 0) {
					$newi = 0;
				} else {
					$newi = $Array[$j - 1];
				}
				$TPrice = 0;
				$TLoad = 0;
				for ($i = $newi; $i < $Array[$j]; $i++) {
					$cname = "";
					$oname = "";
					$url = '';
					$Price = 0;

					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['ConveyanceNo']);
					if ($data['SplitExcelDayWorkTicketsAll'][$i]['ReceiptName'] != "") {
						$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $data['SplitExcelDayWorkTicketsAll'][$i]['ReceiptName']));
					}


					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['SiteOutDateTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['CompanyName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['OpportunityName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['PurchaseOrderNo']);
					if ($row['MStatus'] == 1) {
						$LT = '';
						if ($row['LorryType'] == 1) {
							$LT = 'Tipper';
						} else if ($row['LorryType'] == 2) {
							$LT = 'Grab';
						} else if ($row['LorryType'] == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($row['TonBook'] == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						$MaterialText = $data['SplitExcelDayWorkTicketsAll'][$i]['MaterialName'] . ' ' . $LT . ' ' . $TB;
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['MaterialName']);
					}
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['DriverName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['VehicleRegNo']);

					if ($data['SplitExcelDayWorkTicketsAll'][$i]['BookingMatrialID'] == $data['SplitExcelDayWorkTicketsAll'][$i]['MatrialID']) {
						$Price = $data['SplitExcelDayWorkTicketsAll'][$i]['Price'];
					} else {
						$Price = 0;
					}
					//$TPrice = $TPrice + $Price;
					$TPrice = floor(($TPrice + $Price) * 100) / 100;

					$LT = '';
					if ($row['LorryType'] == 1) {
						$LT = 'Tipper';
					} else if ($row['LorryType'] == 2) {
						$LT = 'Grab';
					} else if ($row['LorryType'] == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					// Set the value for the cell
					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $Price);
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $LT);
					$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['Status']);


					$excel_row++;
					$cname = $data['SplitExcelDayWorkTicketsAll'][$i]['CompanyName'];
					$oname = $data['SplitExcelDayWorkTicketsAll'][$i]['OpportunityName'];

					$TLoad = $TLoad + 1;
				} /// For each 
				/* Records Start For Each   */

				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);

				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Total Price');
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $TPrice);
				$excel_row++;
				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);

				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Total Loads');
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $TLoad);

				/* Export Start Excel  */
				for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
					$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
				}

				$FileName = $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . ".xls";

				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_~,;[](). 
				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).'])", '', $FileName);

				// Remove any runs of periods (thanks falstro!)
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

				//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
				header('Content-Disposition: attachment;filename="' . $FileName . '"');
				//$object_writer->save('php://output'); 

				ob_start();
				$object_writer->save("SplitXLS/" . $FileName);
				$xlsfiles[] = $FileName;
				$xlsData = ob_get_contents();
				ob_end_clean();
				/* Export End Excel  */
			}

			foreach ($xlsfiles as $xls) {
				$this->zip->read_file('SplitXLS/' . $xls);
			}
			$zname = date("YmdHis") . "-" . rand() . ".zip";
			$this->zip->archive("SplitXLS/" . $zname);
			$response = array(
				'op' => 'ok',
				'FileName' => "SplitXLS/" . $zname,
				'file' => "data:application/zip;base64," . $zname
			);
			die(json_encode($response));
		}
	}
	function SplitExcelExportAllDayWork()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			//var_dump($_POST); 			
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$SiteOutDateTime = $this->input->post('SiteOutDateTime');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');


			$data['SplitExcelDayWorkTicketsAll'] = $this->Booking_model->SplitExcelDayWorkTicketsAll($CompanyName, $OpportunityName, $reservation, $SiteOutDateTime, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $Status, $Search, $Price);
			//	var_dump($data['SplitExcelDayWorkTicketsAll']); 
			//	echo count($data['SplitExcelDayWorkTicketsAll']);
			if (count($data['SplitExcelDayWorkTicketsAll']) > 0) {
				$Array = array();
				//for($a=0;$a>count($data['SplitExcelDayWorkTicketsAll']);$a++){  
				$xx = 0;

				foreach ($data['SplitExcelDayWorkTicketsAll'] as $row) {
					if ($xx == 0) {
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if ($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID']) {
						//$xx++;  

						//	echo $xx;
						//	echo " ==== ";
						//	echo $x; 
						//	echo " ==== ";
						//	echo $y; 
						//	echo " ==== ";
						//	echo $z;
						//	echo " </br>  ";

					} else {
						$Array[] = $xx;

						//$xx++; 
						//echo "| else ".$xx." |";
						//	echo " ||| ==== ";
						$x = $row['CompanyID'];
						//	echo " ==== ";
						$y = $row['OpportunityID'];
						//	echo " ==== ";
						$z = $row['MaterialID'];
						//	echo " </br>  ";
					}

					if (count($data['SplitExcelDayWorkTicketsAll']) - 1 == $xx) {
						$xx++;
						$Array[] = $xx;
						//echo "|  count ".$xx." |";
						break;

					} else {
						$xx++;
					}


				}

			}



			//print_r($Array);
			//exit;
			$this->load->library('zip');
			$this->load->library("excel");
			$xlsfiles = array();
			//echo count($Array);
			for ($j = 0; $j < count($Array); $j++) {
				$FileName = "";
				/* Header Start Excel  */
				$object = new PHPExcel();
				//print_r($_POST); die;
				$object->setActiveSheetIndex(0);

				$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Driver Name", "VRNO", "Price", "Status");

				$column = 0;
				foreach ($table_columns as $field) {
					$object->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$column++;
				}
				$object->getActiveSheet()->getStyle('i:i')->getNumberFormat()->setFormatCode('0.00');
				$excel_row = 2;
				/* Header End Excel  */

				/* Records Start  For Each  */
				//foreach( $data['SplitExcelDayWorkTicketsAll'] as $row){ 
				//echo $Array[$j]; 
				if ($j == 0) {
					$newi = 0;
				} else {
					$newi = $Array[$j - 1];
				}
				$TPrice = 0;
				$TLoad = 0;
				for ($i = $newi; $i < $Array[$j]; $i++) {
					//for($i=0;$i<count($data['SplitExcelDayWorkTicketsAll']);$i++){  
					$cname = "";
					$oname = "";
					$url = '';
					$Price = 0; //$Status = ''; 

					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['ConveyanceNo']);
					if ($data['SplitExcelDayWorkTicketsAll'][$i]['ReceiptName'] != "") {
						$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $data['SplitExcelDayWorkTicketsAll'][$i]['ReceiptName']));
					}


					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['SiteOutDateTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['CompanyName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['OpportunityName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['PurchaseOrderNo']);

					if ($row['MStatus'] == 1) {
						$LT = '';
						if ($row['LorryType'] == 1) {
							$LT = 'Tipper';
						} else if ($row['LorryType'] == 2) {
							$LT = 'Grab';
						} else if ($row['LorryType'] == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($row['TonBook'] == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						$MaterialText = $data['SplitExcelDayWorkTicketsAll'][$i]['MaterialName'] . ' ' . $LT . ' ' . $TB;
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $MaterialText);
					} else {
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['MaterialName']);
					}
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['DriverName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['VehicleRegNo']);

					if (is_numeric($data['SplitExcelDayWorkTicketsAll'][$i]['Price'])) {
						$Price = $data['SplitExcelDayWorkTicketsAll'][$i]['Price'];
					} else {
						$Price = 0;
					}
					//$TPrice = $TPrice + $Price;
					$TPrice = floor(($TPrice + $Price) * 100) / 100;

					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $Price);
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $data['SplitExcelDayWorkTicketsAll'][$i]['Status']);

					$excel_row++;
					$cname = $data['SplitExcelDayWorkTicketsAll'][$i]['CompanyName'];
					$oname = $data['SplitExcelDayWorkTicketsAll'][$i]['OpportunityName'];

					$TLoad = $TLoad + 1;
				} /// For each 
				/* Records Start For Each   */

				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);

				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Total Price');
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $TPrice);
				$excel_row++;
				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);

				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Total Loads');
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $TLoad);

				/* Export Start Excel  */
				for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
					$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
				}

				$FileName = $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . ".xls";

				//$FileName = $row['CompanyName']."-".$row['OpportunityName']."-".date("YmdHis").".xls";		
				//$FileName = date("YmdHis")."-".rand().".xls";		

				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_~,;[](). 
				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).'])", '', $FileName);

				// Remove any runs of periods (thanks falstro!)
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

				//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
				header('Content-Disposition: attachment;filename="' . $FileName . '"');
				//$object_writer->save('php://output'); 

				ob_start();
				//$object_writer->save("php://output");
				//$object_writer->save(str_replace(__FILE__,'SplitXLS/'.$FileName,__FILE__)); 
				$object_writer->save("SplitXLS/" . $FileName);

				//$this->zip->add_data($FileName,$object_writer->save("SplitXLS/".$FileName)); 
				$xlsfiles[] = $FileName;
				$xlsData = ob_get_contents();
				ob_end_clean();
				/* Export End Excel  */
			}

			foreach ($xlsfiles as $xls) {
				$this->zip->read_file('SplitXLS/' . $xls);
			}
			$zname = date("YmdHis") . "-" . rand() . ".zip";
			$this->zip->archive("SplitXLS/" . $zname);
			//$this->zip->download($zname);

			//exit;
			//$zipFile = base_url("SplitXLS/".$zname); 
			$response = array(
				'op' => 'ok',
				'FileName' => "SplitXLS/" . $zname,
				'file' => "data:application/zip;base64," . $zname
			);
			die(json_encode($response));
			//'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)

		}
	}

	function DateUpdateHaulageAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			//var_dump($_POST);
			$data['JobStart'] = $this->input->post('JobStartDateTime');
			$data['SiteIn'] = $this->input->post('SiteInDateTime');
			$data['SiteOut'] = $this->input->post('SiteOutDateTime');
			$data['HaulageIn'] = $this->input->post('HaulageInDateTime');
			$data['HaulageOut'] = $this->input->post('HaulageOutDateTime');
			$data['JobEnd'] = $this->input->post('JobEndDateTime');

			$html = $this->load->view('Booking/DateUpdateHaulageAjax', $data, true);
			echo json_encode($html);

		}
	}
	function DateUpdateHaulage($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				// ===== Fetch OLD data BEFORE update =====
            $oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();

            $oldValueArray = [];
			if ($oldData) {
				$oldValueArray = [
					'JobStartDateTime' => $oldData->JobStartDateTime,
					'SiteInDateTime'   => $oldData->SiteInDateTime,
					'SiteOutDateTime'  => $oldData->SiteOutDateTime,
					'SiteInDateTime2'  => $oldData->SiteInDateTime2,
					'SiteOutDateTime2' => $oldData->SiteOutDateTime2,
					'JobEndDateTime'   => $oldData->JobEndDateTime,
				];
			}
			$oldValueJson = json_encode($oldValueArray);


				$JobStartDatetime = $this->input->post('JobStartDatetime');
				$SiteInDatetime = $this->input->post('SiteInDatetime');
				$SiteOutDatetime = $this->input->post('SiteOutDatetime');
				$SiteInDatetime2 = $this->input->post('SiteInDatetime2');
				$SiteOutDatetime2 = $this->input->post('SiteOutDatetime2');
				$JobEndDatetime = $this->input->post('JobEndDatetime');
				$LoadID = $this->input->post('LoadID');

				$js = explode(' ', $JobStartDatetime);
				$js1 = explode('/', $js[0]);
				$JobStartDatetime = trim($js1[2]) . "-" . trim($js1[1]) . "-" . trim($js1[0]) . " " . $js[1];

				$si = explode(' ', $SiteInDatetime);
				$si1 = explode('/', $si[0]);
				$SiteInDatetime = trim($si1[2]) . "-" . trim($si1[1]) . "-" . trim($si1[0]) . " " . $si[1];

				$so = explode(' ', $SiteOutDatetime);
				$so1 = explode('/', $so[0]);
				$SiteOutDatetime = trim($so1[2]) . "-" . trim($so1[1]) . "-" . trim($so1[0]) . " " . $so[1];

				$si2 = explode(' ', $SiteInDatetime2);
				$si12 = explode('/', $si2[0]);
				$SiteInDatetime2 = trim($si12[2]) . "-" . trim($si12[1]) . "-" . trim($si12[0]) . " " . $si2[1];

				$so2 = explode(' ', $SiteOutDatetime2);
				$so12 = explode('/', $so2[0]);
				$SiteOutDatetime2 = trim($so12[2]) . "-" . trim($so12[1]) . "-" . trim($so12[0]) . " " . $so2[1];

				$je = explode(' ', $JobEndDatetime);
				$je1 = explode('/', $je[0]);
				$JobEndDatetime = trim($je1[2]) . "-" . trim($je1[1]) . "-" . trim($je1[0]) . " " . $je[1];

				$LoadInfo = array(
					'JobStartDatetime' => $JobStartDatetime,
					'SiteInDatetime' => $SiteInDatetime,
					'SiteOutDatetime' => $SiteOutDatetime,
					'SiteInDatetime2' => $SiteInDatetime2,
					'SiteOutDatetime2' => $SiteOutDatetime2,
					'JobEndDatetime' => $JobEndDatetime
				);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				/* =================== Site Logs ===================  */
				$LoadInfoJson = json_encode($LoadInfo);
				$condJson = json_encode($cond);

				$SiteLogInfo = array(
					'TableName' => 'tbl_booking_loads1',
					'PrimaryID' => $LoadID,
					'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
					'OldValue' => $oldValueJson, // Store old values here
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'Haulage date update',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);

				/* ===================================== */

				// print_r($SiteLogInfo);
				// exit;
				if ($update) {

					$conditions = array('LoadID ' => $LoadID);
					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data['LoadInfo']->TonBook == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
					$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';
					$HaulageInDateTime = '<b>Haulage In Time: </b>' . $data['LoadInfo']->HSIDateTime . ' <br>';
					$HaulageOutDateTime = '<b>Haulage Out Time: </b>' . $data['LoadInfo']->HSODateTime . ' <br>';

					$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;


					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
						<div style="width:100%;float: left;" >   
							<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
							<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
							<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> 
							<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/><hr>
							<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>   
							<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
							<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
							' . $siteInDateTime . '
							' . $siteOutDateTime . '
							' . $HaulageInDateTime . '
							' . $HaulageOutDateTime . '
							<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
							<b>Haulier </b> ' . $data['LoadInfo']->Haulier . '  <br> 
							<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br>  
							<b>Driver Signature: </b>   
							<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"></div> <br/>   
							<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
							<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
							<b>Haulage Address: </b> ' . $data['LoadInfo']->TipName . ',' . $data['LoadInfo']->Street1 . ',' . $data['LoadInfo']->Street2 . ',
							' . $data['LoadInfo']->Town . ',' . $data['LoadInfo']->County . ',' . $data['LoadInfo']->PostCode . '<br>		 		 
							<b>Material: </b> ' . $MaterialText . '  <br> 
							<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
							<b>Gross Weight: </b> ' . $data['LoadInfo']->GrossWeight . ' KGs <br>  
							<b>Tare Weight: </b> ' . $data['LoadInfo']->Tare . ' KGs  <br>  
							<b>Net Weight: </b> ' . $data['LoadInfo']->Net . ' KGs  <br>   
						</div>  
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName . '<br> 
							<b>Received By: </b> 
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature2 . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName2 . '<br> 
							<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p>
							<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p>
						</div>  
					</div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data['LoadInfo']->ReceiptName;
					$mpdf = new mPDF('utf-8', array(70, 240), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					$this->session->set_flashdata('success', 'Date has been updated successfully');

					redirect('HaulageTickets');

				} else {
					redirect('HaulageTickets');
				}
			}

		}
	}

	function StatusUpdateHaulageAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['LoadID'] = $this->input->post('LoadID');
			$data['Status'] = $this->input->post('Status');
			$data['PDF'] = $this->input->post('PDF');

			$html = $this->load->view('Booking/StatusUpdateHaulageAjax', $data, true);
			echo json_encode($html);
		}
	}

	function StatusUpdateHaulage($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

			//	Get OLD STATUS before updating
            $oldData = $this->db->select('Status')
				->from('tbl_booking_loads1')
				->where('LoadID', $LoadID)
				->get()
				->row();
            $oldStatus = $oldData ? $oldData->Status : null;

				$Status = $this->input->post('Status');
				$LoadID = $this->input->post('LoadID');

				$LoadInfo = array('Status' => $Status);
				$cond = array('LoadID' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);


				/* =================== Site Logs ===================  */
				$LoadInfoJson = json_encode($LoadInfo);
				$condJson = json_encode($cond);
				$OldValueJson = json_encode(['Status' => $oldStatus]);

				$SiteLogInfo = array(
					'TableName' => 'tbl_booking_loads1',
					'PrimaryID' => $LoadID,
					'OldValue' => $OldValueJson,
					'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
					'UpdatedByUserID' => $this->session->userdata['userId'],
					'SitePage' => 'Haulage status update',
					'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
					'BrowserAgent' => getBrowserAgent(),
					'AgentString' => $this->agent->agent_string(),
					'UserPlatform' => $this->agent->platform()
				);
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);

				/* ===================================== */


				if ($update) {
					if ($Status == 4) {
						$conditions = array('LoadID ' => $LoadID);
						$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

						$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
						$PDFContent = $PDFContentQRY->result();
						$LT = '';
						if ($data['LoadInfo']->LorryType == 1) {
							$LT = 'Tipper';
						} else if ($data['LoadInfo']->LorryType == 2) {
							$LT = 'Grab';
						} else if ($data['LoadInfo']->LorryType == 3) {
							$LT = 'Bin';
						} else {
							$LT = '';
						}

						$TB = '';
						if ($data['LoadInfo']->TonBook == 1) {
							$TB = ' Tonnage ';
						} else {
							$TB = ' Load ';
						}

						$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
						$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';
						$HaulageInDateTime = '<b>Haulage In Time: </b>' . $data['LoadInfo']->HSIDateTime . ' <br>';
						$HaulageOutDateTime = '<b>Haulage Out Time: </b>' . $data['LoadInfo']->HSODateTime . ' <br>';

						$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;

						$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
						<div style="width:100%;float: left;" >   
							<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
							<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
							<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> 
							<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/><hr>
							<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>   
							<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
							<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
							' . $siteInDateTime . '
							' . $siteOutDateTime . '
							' . $HaulageInDateTime . '
							' . $HaulageOutDateTime . '
							<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
							<b>Haulier </b> ' . $data['LoadInfo']->Haulier . '  <br> 
							<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br>  
							<b>Driver Signature: </b>   
							<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"></div> <br/>   
							<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
							<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
							<b>Haulage Address: </b> ' . $data['LoadInfo']->TipName . ',' . $data['LoadInfo']->Street1 . ',' . $data['LoadInfo']->Street2 . ',
							' . $data['LoadInfo']->Town . ',' . $data['LoadInfo']->County . ',' . $data['LoadInfo']->PostCode . '<br>		 		 
							<b>Material: </b> ' . $MaterialText . '  <br> 
							<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
							<b>Gross Weight: </b> ' . $data['LoadInfo']->GrossWeight . ' KGs <br>  
							<b>Tare Weight: </b> ' . $data['LoadInfo']->Tare . ' KGs  <br>  
							<b>Net Weight: </b> ' . $data['LoadInfo']->Net . ' KGs  <br>   
						</div>  
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName . '<br> 
							<b>Received By: </b> 
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature2 . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName2 . '<br> 
							<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p>
							<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p>
							<p style="font-size: 5px;"><b> P' . date("dmYHis") . ' </p>		
						</div>  
					</div></body></html>';

						$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data['LoadInfo']->ReceiptName;
						$mpdf = new mPDF('utf-8', array(70, 240), '', '', 5, 5, 5, 5, 5, 5);
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);
					}
					$this->session->set_flashdata('success', 'Status has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Please Try Again Later');
				}
				redirect('HaulageTickets');
			}

		}
	}
	function HaulageExcelExport()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			//var_dump($_POST); 			
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$SiteOutDateTime2 = $this->input->post('SiteOutDateTime2');

			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');

			$data['SplitExcelHaulageTicketsAll'] = $this->Booking_model->SplitExcelHaulageTicketsAll($CompanyName, $OpportunityName, $reservation, $SiteOutDateTime2, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $Status, $Search, $Price);
			//var_dump($data['SplitExcelHaulageTicketsAll']); 
			//exit;
			$this->load->library("excel");
			//foreach( $data['SplitExcelHaulageTicketsAll'] as $row){ 

			$object = new PHPExcel();
			//print_r($_POST); die;
			$object->setActiveSheetIndex(0);
			$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Driver Name", "VRNO", "Lorry Type", "Price", "Status");

			$column = 0;
			foreach ($table_columns as $field) {
				$object->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
				$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
				$column++;
			}

			$excel_row = 2;
			//$TPrice = 0; $TLoad = 0; 
			foreach ($data['SplitExcelHaulageTicketsAll'] as $row) {
				$url = '';
				$Price = 0; //$Status = '';  

				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['ConveyanceNo']);
				if ($row['ReceiptName'] != "") {
					$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $row['ReceiptName']));
				}
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['SiteOutDateTime2']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['CompanyName']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['OpportunityName']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['PurchaseOrderNo']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['MaterialName']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['DriverName']);
				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['VehicleRegNo']);

				$LT = '';
				if ($row['LorryType'] == 1) {
					$LT = 'Tipper';
				} else if ($row['LorryType'] == 2) {
					$LT = 'Grab';
				} else if ($row['LorryType'] == 3) {
					$LT = 'Bin';
				} else {
					$LT = '';
				}

				// Set the value for the cell
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $LT);

				if ($row['BookingMaterialID'] == $row['MaterialID']) {
					$Price = is_numeric($row['LoadPrice']) ? $row['LoadPrice'] : 0;
				} else {
					$Price = 0;
				}
				$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $Price);
				$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row['Status']);

				//$TLoad = $TLoad + 1;
				$excel_row++;
			}

			for ($i = 'A'; $i != $object->getActiveSheet()->getHighestColumn(); $i++) {
				$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
			}
			$FileName = date("Y-m-d-H:i") . ".xls";
			//} 


			// Remove anything which isn't a word, whitespace, number
			// or any of the following caracters -_~,;[](). 
			$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).])", '', $FileName);
			// Remove any runs of periods (thanks falstro!)
			$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

			//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
			$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

			header('Content-Type: application/vnd.ms-excel');
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
			header('Content-Disposition: attachment;filename="' . $FileName . '"');
			//$object_writer->save('php://output'); 

			ob_start();
			$object_writer->save("php://output");
			//$objWriter->save(base_url("12121212.xls")); 
			$xlsData = ob_get_contents();
			ob_end_clean();

			$response = array(
				'op' => 'ok',
				'FileName' => $FileName,
				'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
			);
			die(json_encode($response));
		}
	}

	function SplitExcelHaulageAjax()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$CompanyName = $this->input->post('CompanyName');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$SiteOutDateTime2 = $this->input->post('SiteOutDateTime2');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');

			$data['CompanyOppoRecords'] = $this->Booking_model->SplitExcelOppoGroupHaulage($CompanyName, $OpportunityName, $reservation, $SiteOutDateTime2, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $Status);

			$html = $this->load->view('Booking/SplitExcelHaulageAjax', $data, true);
			echo json_encode($html);

		}
	}
	function SplitExcelExportHaulage()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			//var_dump($_POST); 			
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityID = $this->input->post('OpportunityID');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$SiteOutDateTime2 = $this->input->post('SiteOutDateTime2');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');

			$data['SplitExcelHaulageTickets'] = $this->Booking_model->SplitExcelHaulageTickets($OpportunityID, $CompanyName, $OpportunityName, $reservation, $SiteOutDateTime2, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $Status, $Search, $Price);

			if (count($data['SplitExcelHaulageTickets']) > 0) {
				$Array = array();
				$xx = 0;

				foreach ($data['SplitExcelHaulageTickets'] as $row) {
					if ($xx == 0) {
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if ($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID']) {
					} else {
						$Array[] = $xx;
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if (count($data['SplitExcelHaulageTickets']) - 1 == $xx) {
						$xx++;
						$Array[] = $xx;
						break;
					} else {
						$xx++;
					}
				}
			}
			$this->load->library('zip');
			$this->load->library("excel");
			$xlsfiles = array();
			for ($j = 0; $j < count($Array); $j++) {
				$FileName = "";
				/* Header Start Excel  */
				$object = new PHPExcel();
				$object->setActiveSheetIndex(0);

				$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Driver Name", "VRNO", "Price", "Lorry Type", "Status");

				$column = 0;
				foreach ($table_columns as $field) {
					$object->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$column++;
				}
				$object->getActiveSheet()->getStyle('i:i')->getNumberFormat()->setFormatCode('0.00');
				$excel_row = 2;
				/* Header End Excel  */

				/* Records Start  For Each  */
				if ($j == 0) {
					$newi = 0;
				} else {
					$newi = $Array[$j - 1];
				}
				$TPrice = 0;
				$TLoad = 0;
				for ($i = $newi; $i < $Array[$j]; $i++) {
					$cname = "";
					$oname = "";
					$url = '';
					$Price = 0;

					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelHaulageTickets'][$i]['ConveyanceNo']);
					if ($data['SplitExcelHaulageTickets'][$i]['ReceiptName'] != "") {
						$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $data['SplitExcelHaulageTickets'][$i]['ReceiptName']));
					}


					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['SplitExcelHaulageTickets'][$i]['SiteOutDateTime2']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $data['SplitExcelHaulageTickets'][$i]['CompanyName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $data['SplitExcelHaulageTickets'][$i]['OpportunityName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $data['SplitExcelHaulageTickets'][$i]['PurchaseOrderNo']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $data['SplitExcelHaulageTickets'][$i]['MaterialName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $data['SplitExcelHaulageTickets'][$i]['DriverName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $data['SplitExcelHaulageTickets'][$i]['VehicleRegNo']);

					if ($data['SplitExcelHaulageTickets'][$i]['BookingMatrialID'] == $data['SplitExcelHaulageTickets'][$i]['MatrialID']) {
						$Price = $data['SplitExcelHaulageTickets'][$i]['LoadPrice'];
					} else {
						$Price = 0;
					}
					//$TPrice = $TPrice + $Price;
					$TPrice = floor(($TPrice + $Price) * 100) / 100;
					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $Price);

					$LT = '';
					if ($row['LorryType'] == 1) {
						$LT = 'Tipper';
					} else if ($row['LorryType'] == 2) {
						$LT = 'Grab';
					} else if ($row['LorryType'] == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					// Set the value for the cell
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $LT);
					$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $data['SplitExcelHaulageTickets'][$i]['Status']);

					$excel_row++;
					$cname = $data['SplitExcelHaulageTickets'][$i]['CompanyName'];
					$oname = $data['SplitExcelHaulageTickets'][$i]['OpportunityName'];

					$TLoad = $TLoad + 1;
				} /// For each 
				/* Records Start For Each   */

				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);

				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Total Price');
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $TPrice);
				$excel_row++;
				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);

				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Total Loads');
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $TLoad);

				/* Export Start Excel  */
				for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
					$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
				}

				$FileName = $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . ".xls";

				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_~,;[](). 
				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).'])", '', $FileName);

				// Remove any runs of periods (thanks falstro!)
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);
				//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
				header('Content-Disposition: attachment;filename="' . $FileName . '"');
				//$object_writer->save('php://output'); 

				ob_start();
				$object_writer->save("SplitXLS/" . $FileName);
				$xlsfiles[] = $FileName;
				$xlsData = ob_get_contents();
				ob_end_clean();
				/* Export End Excel  */
			}

			foreach ($xlsfiles as $xls) {
				$this->zip->read_file('SplitXLS/' . $xls);
			}
			$zname = date("YmdHis") . "-" . rand() . ".zip";
			$this->zip->archive("SplitXLS/" . $zname);
			$response = array(
				'op' => 'ok',
				'FileName' => "SplitXLS/" . $zname,
				'file' => "data:application/zip;base64," . $zname
			);
			die(json_encode($response));
		}
	}
	function SplitExcelExportAllHaulage()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {

			//var_dump($_POST); 			
			$CompanyName = $this->input->post('CompanyName');
			$Search = $this->input->post('Search');
			$OpportunityName = $this->input->post('OpportunityName');
			$reservation = $this->input->post('reservation');
			$SiteOutDateTime2 = $this->input->post('SiteOutDateTime2');
			$ConveyanceNo = $this->input->post('ConveyanceNo');
			$MaterialName = $this->input->post('MaterialName');
			$DriverName = $this->input->post('DriverName');
			$VehicleRegNo = $this->input->post('VehicleRegNo');
			$Status = $this->input->post('Status');
			$Price = $this->input->post('Price');


			$data['SplitExcelHaulageTicketsAll'] = $this->Booking_model->SplitExcelHaulageTicketsAll($CompanyName, $OpportunityName, $reservation, $SiteOutDateTime2, $ConveyanceNo, $MaterialName, $DriverName, $VehicleRegNo, $Status, $Search, $Price);
			//	var_dump($data['SplitExcelDayWorkTicketsAll']); 
			//	echo count($data['SplitExcelDayWorkTicketsAll']);
			if (count($data['SplitExcelHaulageTicketsAll']) > 0) {
				$Array = array();
				//for($a=0;$a>count($data['SplitExcelDayWorkTicketsAll']);$a++){  
				$xx = 0;

				foreach ($data['SplitExcelHaulageTicketsAll'] as $row) {
					if ($xx == 0) {
						$x = $row['CompanyID'];
						$y = $row['OpportunityID'];
						$z = $row['MaterialID'];
					}

					if ($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID']) {
						//$xx++;  

						//	echo $xx;
						//	echo " ==== ";
						//	echo $x; 
						//	echo " ==== ";
						//	echo $y; 
						//	echo " ==== ";
						//	echo $z;
						//	echo " </br>  ";

					} else {
						$Array[] = $xx;

						//$xx++; 
						//echo "| else ".$xx." |";
						//	echo " ||| ==== ";
						$x = $row['CompanyID'];
						//	echo " ==== ";
						$y = $row['OpportunityID'];
						//	echo " ==== ";
						$z = $row['MaterialID'];
						//	echo " </br>  ";
					}

					if (count($data['SplitExcelHaulageTicketsAll']) - 1 == $xx) {
						$xx++;
						$Array[] = $xx;
						//echo "|  count ".$xx." |";
						break;

					} else {
						$xx++;
					}


				}

			}



			//print_r($Array);
			//exit;
			$this->load->library('zip');
			$this->load->library("excel");
			$xlsfiles = array();
			//echo count($Array);
			for ($j = 0; $j < count($Array); $j++) {
				$FileName = "";
				/* Header Start Excel  */
				$object = new PHPExcel();
				//print_r($_POST); die;
				$object->setActiveSheetIndex(0);

				$table_columns = array("ConvTkt No", "ConvTkt Date", "Customer Name ", "Job Site Address", "PO NO", "Product Description", "Driver Name", "VRNO", "Price", "Status");

				$column = 0;
				foreach ($table_columns as $field) {
					$object->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$column++;
				}
				$object->getActiveSheet()->getStyle('i:i')->getNumberFormat()->setFormatCode('0.00');
				$excel_row = 2;
				/* Header End Excel  */

				/* Records Start  For Each  */
				//foreach( $data['SplitExcelHaulageTicketsAll'] as $row){ 
				//echo $Array[$j]; 
				if ($j == 0) {
					$newi = 0;
				} else {
					$newi = $Array[$j - 1];
				}
				$TPrice = 0;
				$TLoad = 0;
				for ($i = $newi; $i < $Array[$j]; $i++) {
					//for($i=0;$i<count($data['SplitExcelHaulageTicketsAll']);$i++){  
					$cname = "";
					$oname = "";
					$url = '';
					$Price = 0; //$Status = ''; 

					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $data['SplitExcelHaulageTicketsAll'][$i]['ConveyanceNo']);
					if ($data['SplitExcelHaulageTicketsAll'][$i]['ReceiptName'] != "") {
						$object->getActiveSheet()->getCell('A' . $excel_row)->getHyperlink()->setUrl(base_url('assets/conveyance/' . $data['SplitExcelHaulageTicketsAll'][$i]['ReceiptName']));
					}


					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['SplitExcelHaulageTicketsAll'][$i]['SiteOutDateTime2']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $data['SplitExcelHaulageTicketsAll'][$i]['CompanyName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $data['SplitExcelHaulageTicketsAll'][$i]['OpportunityName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $data['SplitExcelHaulageTicketsAll'][$i]['PurchaseOrderNo']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $data['SplitExcelHaulageTicketsAll'][$i]['MaterialName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $data['SplitExcelHaulageTicketsAll'][$i]['DriverName']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $data['SplitExcelHaulageTicketsAll'][$i]['VehicleRegNo']);

					if (is_numeric($data['SplitExcelHaulageTicketsAll'][$i]['LoadPrice'])) {
						$Price = $data['SplitExcelHaulageTicketsAll'][$i]['LoadPrice'];
					} else {
						$Price = 0;
					}
					//$TPrice = $TPrice + $Price;
					$TPrice = floor(($TPrice + $Price) * 100) / 100;
					$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $Price);
					$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $data['SplitExcelHaulageTicketsAll'][$i]['Status']);

					$excel_row++;
					$cname = $data['SplitExcelHaulageTicketsAll'][$i]['CompanyName'];
					$oname = $data['SplitExcelHaulageTicketsAll'][$i]['OpportunityName'];

					$TLoad = $TLoad + 1;

				} /// For each 
				/* Records Start For Each   */

				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);

				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Total Price');
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $TPrice);
				$excel_row++;
				$object->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row . '')->getFont()->setBold(true);

				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Total Loads');
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $TLoad);

				/* Export Start Excel  */
				for ($x = 'A'; $x != $object->getActiveSheet()->getHighestColumn(); $x++) {
					$object->getActiveSheet()->getColumnDimension($x)->setAutoSize(TRUE);
				}

				$FileName = $cname . "@" . $oname . "@" . date("YmdHis") . "@" . rand() . ".xls";

				//$FileName = $row['CompanyName']."-".$row['OpportunityName']."-".date("YmdHis").".xls";		
				//$FileName = date("YmdHis")."-".rand().".xls";		

				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).'])", '', $FileName);

				// Remove any runs of periods (thanks falstro!)
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);

				//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
				header('Content-Disposition: attachment;filename="' . $FileName . '"');
				//$object_writer->save('php://output'); 

				ob_start();
				//$object_writer->save("php://output");
				//$object_writer->save(str_replace(__FILE__,'SplitXLS/'.$FileName,__FILE__)); 
				$object_writer->save("SplitXLS/" . $FileName);

				//$this->zip->add_data($FileName,$object_writer->save("SplitXLS/".$FileName)); 
				$xlsfiles[] = $FileName;
				$xlsData = ob_get_contents();
				ob_end_clean();
				/* Export End Excel  */
			}

			foreach ($xlsfiles as $xls) {
				$this->zip->read_file('SplitXLS/' . $xls);
			}
			$zname = date("YmdHis") . "-" . rand() . ".zip";
			$this->zip->archive("SplitXLS/" . $zname);
			//$this->zip->download($zname);

			//exit;
			//$zipFile = base_url("SplitXLS/".$zname); 
			$response = array(
				'op' => 'ok',
				'FileName' => "SplitXLS/" . $zname,
				'file' => "data:application/zip;base64," . $zname
			);
			die(json_encode($response));
			//'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)

		}
	}


	function BookingRequestHaulageFinish($LoadID)
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($LoadID == null) {
				redirect('Loads');
			}

			$conditions = array('LoadID ' => $LoadID);
			$data['LoadInfo'] = $this->Booking_model->BookingRequestLoadInfo($LoadID);

			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				if ($data['LoadInfo']->Status == 4 || $data['LoadInfo']->Status == 5 || $data['LoadInfo']->Status == 6) {
					redirect('RequestLoads');
				}

				$SiteInDateTime = date("Y-m-d H:i:s");
				$SiteOutDateTime = date("Y-m-d H:i:s");
				$JobEndDateTime = date("Y-m-d H:i:s");

				$SiteInDateTime2 = date("Y-m-d H:i:s");
				$SiteOutDateTime2 = date("Y-m-d H:i:s");

				$Notes2 = $this->security->xss_clean($this->input->post('Notes2'));
				$CustomerName = $this->security->xss_clean($this->input->post('CustomerName'));
				$CustomerName2 = $this->security->xss_clean($this->input->post('CustomerName2'));

				/*
																$Signature = $this->input->post('Signature', FALSE); 
																 
																if($Signature!=""){  
																	$Signature1 = str_replace('data:image/png;base64,', '', $Signature);
																	$Signature1 = str_replace(' ', '+', $Signature1); 
																	$Signature1 = base64_decode($Signature1);
																	
																	
																	$Signature = md5(date("dmYhisA")).".png"; 
																	$file_name = './uploads/Signature/'.$Signature;
																	file_put_contents($file_name,$Signature1); 
																}else{
																	$Signature = "";
																}
																
																$Signature2 = $this->input->post('Signature2', FALSE); 
																 
																if($Signature2!=""){  
																	$Signature12 = str_replace('data:image/png;base64,', '', $Signature2);
																	$Signature12 = str_replace(' ', '+', $Signature1); 
																	$Signature12 = base64_decode($Signature12);
																	
																	
																	$Signature2 = md5(date("dmYhisA")).".png"; 
																	$file_name2 = './uploads/Signature/'.$Signature2;
																	file_put_contents($file_name2,$Signature12); 
																}else{
																	$Signature2 = "";
																}
																*/

				$TicketUniqueID = $this->generateRandomString();

				$LoadInfo = array(
					'SiteInDateTime' => $SiteInDateTime,
					'SiteOutDateTime' => $SiteOutDateTime,
					'SiteInDateTime2' => $SiteInDateTime2,
					'SiteOutDateTime2' => $SiteOutDateTime2,
					'JobEndDateTime' => $JobEndDateTime,
					'Notes2' => $Notes2,
					'ReceiptName' => $TicketUniqueID . ".pdf",
					'CustomerName' => $CustomerName,
					'CustomerName2' => $CustomerName2,
					'Status' => 4
				);
				$cond = array('LoadID ' => $LoadID);
				$update = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $cond);

				if ($update) {
					$conditions = array('LoadID ' => $LoadID);
					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data['LoadInfo']->TonBook == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
					$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';
					$HaulageInDateTime = '<b>Haulage In Time: </b>' . $data['LoadInfo']->HSIDateTime . ' <br>';
					$HaulageOutDateTime = '<b>Haulage Out Time: </b>' . $data['LoadInfo']->HSODateTime . ' <br>';

					$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;

					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
						<div style="width:100%;float: left;" >   
							<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
							<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
							<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> 
							<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/><hr>
							<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>   
							<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
							<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
							' . $siteInDateTime . '
							' . $siteOutDateTime . '
							' . $HaulageInDateTime . '
							' . $HaulageOutDateTime . '
							<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
							<b>Haulier </b> ' . $data['LoadInfo']->Haulier . '  <br> 
							<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br>  
							<b>Driver Signature: </b>   
							<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"></div> <br/>   
							<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
							<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
							<b>Haulage Address: </b> ' . $data['LoadInfo']->TipName . ',' . $data['LoadInfo']->Street1 . ',' . $data['LoadInfo']->Street2 . ',
							' . $data['LoadInfo']->Town . ',' . $data['LoadInfo']->County . ',' . $data['LoadInfo']->PostCode . '<br>		 		 
							<b>Material: </b> ' . $MaterialText . '  <br> 
							<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
							<b>Gross Weight: </b> ' . $data['LoadInfo']->GrossWeight . ' KGs <br>  
							<b>Tare Weight: </b> ' . $data['LoadInfo']->Tare . ' KGs  <br>  
							<b>Net Weight: </b> ' . $data['LoadInfo']->Net . ' KGs  <br>   
						</div>  
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName . '<br> 
							<b>Received By: </b> 
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature2 . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName2 . '<br> 
							<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p>
							<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p>
							<p style="font-size: 5px;"><b> P' . date("dmYHis") . ' </p>		
						</div>  
					</div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data['LoadInfo']->ReceiptName;
					$mpdf = new mPDF('utf-8', array(70, 240), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					$this->session->set_flashdata('success', 'Booking Haulage has been updated successfully');
				} else {
					$this->session->set_flashdata('error', 'Please Try Again Later');
				}
				redirect('RequestLoads');
			}
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Booking Haulage Updated';
			$this->global['active_menu'] = 'loads';

			$this->loadViews("Booking/BookingRequestHaulageFinish", $this->global, $data, NULL);
		}
	}

	function AllocateNewBookingAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			//var_dump($_POST);
			$data['LoadID'] = $this->input->post('LoadID');
			$data['BookingRequestID'] = $this->input->post('BookingRequestID');
			$data['BookingDateID'] = $this->input->post('BookingDateID');
			$data['BookingInfo'] = $this->Booking_model->GetBookingBasicInfo1($data['BookingDateID']);

			$html = $this->load->view('Booking/AllocateNewBookingAJAX', $data, true);
			echo json_encode($html);

		}
	}

	function FetchBookingRequestAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingRequestID = $this->input->post('BookingRequestID');
			$BookingType = $this->input->post('BookingType');

			$BookingInfo = $this->Booking_model->GetBookingDetails($BookingRequestID, $BookingType);
			//print_r($BookingInfo);   

			if ($BookingInfo[0]->BookingType == 1) {
				$BookingType = "Collection";
			}
			if ($BookingInfo[0]->BookingType == 2) {
				$BookingType = "Delivery";
			}
			if ($BookingInfo[0]->BookingType == 3) {
				$BookingType = "DayWork";
			}
			if ($BookingInfo[0]->BookingType == 4) {
				$BookingType = "Haulage";
			}

			if (count($BookingInfo) > 0) {
				$BDID = "<select  class='form-control' id='BookingDateID' name='BookingDateID'  >";
				for ($i = 0; $i < count($BookingInfo); $i++) {
					$BDID .= "<option value='" . $BookingInfo[$i]->BookingID . "," . $BookingInfo[$i]->BookingDateID . "'>" . $BookingInfo[$i]->BookingDate . " | " . $BookingInfo[$i]->MaterialName . " </option>";
				}
				$BDID .= "</select> <br> <button class='btn btn-info UpdateBookingRequest' title='Update'> Update </button>";
			} else {
				$BDID = "Invalid Booking Request Number.";
			}
			//if($BookingInfo[0]->TonBook==1){ $LoadType = "Tonnage"; }else{ if($BookingInfo[0]->LoadType ==1){ $LoadType = "Loads"; }else{ $LoadType = "Turnaround"; } }   
			//exit;
			if ($BookingInfo) {
				echo (json_encode(array('status' => TRUE, 'BDID' => $BDID, 'BookingType' => $BookingType, 'BookingRequestID' => $BookingRequestID, 'CompanyName' => $BookingInfo[0]->CompanyName, 'OpportunityName' => $BookingInfo[0]->OpportunityName)));
			} else {
				echo (json_encode(array('status' => FALSE, 'BDID' => $BDID)));
			}

		}
	}

	function UpdateBookingRequestAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$BookingRequestID = $this->input->post('BookingRequestID');
			$BookingDateID = $this->input->post('BookingDateID');
			$LoadID = $this->input->post('LoadID');
			$BookingType = $this->input->post('BookingType');

			$BD = explode(',', $BookingDateID);
			$BookingID = $BD[0];
			$BookingDateID = $BD[1];

			  // =================== Fetch OLD Data ===================
        $oldData = $this->db->get_where('tbl_booking_loads1', ['LoadID' => $LoadID])->row();
        $oldValueArray = [];
        if ($oldData) {
            if (isset($oldData->BookingID)) {
                $oldValueArray['BookingID'] = $oldData->BookingID;
            }
            if (isset($oldData->BookingDateID)) {
                $oldValueArray['BookingDateID'] = $oldData->BookingDateID;
            }
            if (isset($oldData->BookingRequestID)) {
                $oldValueArray['BookingRequestID'] = $oldData->BookingRequestID;
            }
        }
        $oldValueJson = json_encode($oldValueArray);
        // ========================================================

			//print_r($BD);
			//exit;
			$LoadInfo = array('BookingRequestID' => $BookingRequestID, 'BookingID' => $BookingID, 'BookingDateID' => $BookingDateID);
			$Cond = array('LoadID ' => $LoadID);
			$UpdateLoadInfo = $this->Common_model->update("tbl_booking_loads1", $LoadInfo, $Cond);
			$UpdateLoadInfo = 1;
			if ($UpdateLoadInfo) {
				if ($BookingType == 1) {
					// =================== Site Logs ===================   
					$LoadInfoJson = json_encode($LoadInfo);
					$condJson = json_encode($Cond);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
						'OldValue'        => $oldValueJson,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'booking update conveyance',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					///* ===================================== 

					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}
					$TB = '';
					if ($data['LoadInfo']->TonBook == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}
					$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
					$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';
					$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;
					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
							<div style="width:100%; " >
								<div style="width:35%;float: left;" > 		
									<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
								</div>
								<div style="width:65%;float: right;text-align: right;" > 		 
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
									' . $PDFContent[0]->address . ' <br/> 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
								</div>
							</div>	
							<div style="width:100%;float: left;" >   
								<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
								<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
								<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> <hr>
								<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
								<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
								<div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
								<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
								<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
								' . $siteInDateTime . '
								' . $siteOutDateTime . '
								<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
								<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
								<b>Tip Address: </b> ' . $data['LoadInfo']->TipName . ',' . $data['LoadInfo']->Street1 . ',' . $data['LoadInfo']->Street2 . ',
								' . $data['LoadInfo']->Town . ',' . $data['LoadInfo']->County . ',' . $data['LoadInfo']->PostCode . '<br>	 
								<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/>							
								<b>Material: </b> ' . $MaterialText . '  <br> 
								<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
								<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
								<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
							</div>
							<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
							<div style="width:100%;float: left;" >
								<b>Produced By: </b><br>
								<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
								' . $data['LoadInfo']->CustomerName . '<br><br>
								<div style="font-size: 9px;"> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
									<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
									' . $PDFContent[0]->FooterText . '  
								</div>
							</div>  
						</div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data['LoadInfo']->ReceiptName;
					$mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);



					///* =================== Site Logs ===================   
					$OldFile = $pdfFilePath;
					$NewFileName = date('YmdHis') . ".pdf";
					$NewFile = WEB_ROOT_PATH . "assets/conveyance/" . $NewFileName;

					copy($OldFile, $NewFile);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'FileName' => $NewFileName,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'booking update conveyance pdf',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					// =====================================  

					$TicketID = $data['LoadInfo']->TicketID;
					if ($TicketID > 0) {
						//exit;
						$TicketInfo = array('OpportunityID' => $data['LoadInfo']->OpportunityID, 'CompanyID' => $data['LoadInfo']->CompanyID);
						$Cond = array('TicketNo' => $TicketID);
						$UpdateTicketInfo = $this->Common_model->update('tbl_tickets', $TicketInfo, $Cond);
						$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);
						$data1['tickets'] = $this->Common_model->get_pdf_data1($TicketID);
						/* =================== Site Logs ===================  */
						$TInfoJson = json_encode($TicketInfo);
						$CondJson = json_encode($Cond);

						$SiteLogInfo = array(
							'TableName' => 'tbl_tickets',
							'PrimaryID' => $TicketID,
							'UpdatedValue' => $TInfoJson . " => " . $CondJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'booking update ticket ',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ===================================== */

						$data1['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
						//$data1['tickets'] = $this->Common_model->get_pdf_data1($TicketID);

						$TicketUniqueID = $data1['tickets']['TicketUniqueID'];

						$html = $this->load->view('Tickets/ticket_pdf', $data1, true);
						//this the the PDF filename that user will get to download
						$pdfFilePath = WEB_ROOT_PATH . "/assets/pdf_file/" . $TicketUniqueID . ".pdf";
						$openPath = "/assets/pdf_file/" . $TicketUniqueID . ".pdf";

						//load mPDF library
						$this->load->library('m_pdf');

						//generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($html);

						//download it.
						$this->m_pdf->pdf->Output($pdfFilePath, "F");

						$this->session->set_flashdata('success', 'Booking Details has been updated successfully');
						//exit;
						//redirect('ConveyanceTickets');  
					}

					echo (json_encode(array('status' => TRUE)));
					exit;

				} elseif ($BookingType == 2) {

					// =================== Site Logs ===================   
					$LoadInfoJson = json_encode($LoadInfo);
					$condJson = json_encode($Cond);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'booking update delivery',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					///* ===================================== 

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();

					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);
					$data1['tickets'] = $this->Booking_model->BookingTicketInfo($data['LoadInfo']->TicketID);

					$LT = '';
					if ($data1['tickets']['LorryType'] == 1) {
						$LT = 'Tipper';
					} else if ($data1['tickets']['LorryType'] == 2) {
						$LT = 'Grab';
					} else if ($data1['tickets']['LorryType'] == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data1['tickets']['TonBook'] == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$MaterialText = $data1['tickets']['MaterialName'] . ' Delivered ' . $LT . ' ' . $TB;

					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
							<div style="width:100%;float: left;" >    
								<b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
								<b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
								<b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
								<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
								<b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>		 
								<b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>		   
								<b>In Time: </b> ' . $data1['tickets']['SiteIn'] . ' <br>		   
								<b>Out Time: </b> ' . $data1['tickets']['SiteOut'] . ' <br>		   
								<b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
								<b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
								<b>Driver Name: </b> ' . $data1['tickets']['DriverName'] . '<br> 
								<b>Driver Signature: </b> <br> 
								<div><img src="/assets/DriverSignature/' . $data1['tickets']['dsignature'] . '" width ="100" height="40" style="float:left"> </div>
								<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		 	 	 
								<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>
								<b>Tip Address: </b> ' . $data['LoadInfo']->TipName . ',' . $data['LoadInfo']->Street1 . ',' . $data['LoadInfo']->Street2 . ',
								' . $data['LoadInfo']->Town . ',' . $data['LoadInfo']->County . ',' . $data['LoadInfo']->PostCode . '<br>	 
								<b>Waste License No:  </b>' . $data1['tickets']['PermitRefNo'] . ' <br> 
								<b>Material: </b>' . $MaterialText . ' <br>
								<b>SIC Code: </b> ' . $data1['tickets']['LoadSICCODE'] . ' <br> 
								<b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>		 
								<b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
								<b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
								<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
							<div style="width:100%;float: left;" > 
								<b>Received By: </b><br> 
								<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
								' . $data['LoadInfo']->CustomerName . '<br>
								<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data1['tickets']['TicketUniqueID'] . ".pdf";
					// Delete old PDF if it exists
					if (file_exists($pdfFilePath)) {
						unlink($pdfFilePath);
					}

					// Generate unique file name
					$uniqueFileName = time() . "_" . $data1['tickets']['TicketUniqueID'] . ".pdf";
					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $uniqueFileName;

					$TicketInfo = array('ReceiptName' => $uniqueFileName);
					$TicketInfoTic = array('pdf_name' => $uniqueFileName);
					$Cond = array('LoadId' => $data['LoadInfo']->LoadID);
					$UpdateTicketInfo = $this->Common_model->direct_update('tbl_booking_loads1', $TicketInfo, $Cond);
					$UpdateTicketInfoTic = $this->Common_model->direct_update('tbl_tickets', $TicketInfoTic, $Cond);
					// Generate PDF
					$mpdf = new mPDF('utf-8', array(70, 220), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					// Log file generation
					$SiteLogInfo = [
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'FileName' => $uniqueFileName,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'delivery booking update pdf',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					];
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);

					echo json_encode(['status' => TRUE]);
					exit;

				} else if ($BookingType == 3) {
					// =================== Site Logs ===================   
					$LoadInfoJson = json_encode($LoadInfo);
					$condJson = json_encode($Cond);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'booking update daywork',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					///* ===================================== 

					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);
					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data['LoadInfo']->TonBook == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
					$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';

					$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;

					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
							<div style="width:100%; " >
								<div style="width:35%;float: left;" > 		
									<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
								</div>
								<div style="width:65%;float: right;text-align: right;" > 		 
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
									' . $PDFContent[0]->address . ' <br/> 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
								</div>
							</div>	
							<div style="width:100%;float: left;" >   
								<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
								<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
								<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/>  <hr>
								<b>' . $PDFContent[0]->head1 . '</b><br/> <br>
								<b>' . $PDFContent[0]->head2 . '</b><br/> <br>
								<div style="text-align: center;"><b>CONVEYANCE NOTE: </b> </div><br>
								<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
								<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
								' . $siteInDateTime . '
								' . $siteOutDateTime . '
								<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
								<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
								<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/> 	 		 
								<b>Material: </b> ' . $MaterialText . '  <br> 
								<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
								<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
								<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br> <br/>   
							</div>
							<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"> </div>  <br> 
							<div style="width:100%;float: left;" >
								<b>Produced By: </b><br>
								<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
								' . $data['LoadInfo']->CustomerName . '<br><br>
								<div style="font-size: 9px;"> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
									<b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
									' . $PDFContent[0]->FooterText . '  
								</div>
							</div>  
						</div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data['LoadInfo']->ReceiptName;
					$mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					$this->session->set_flashdata('success', 'Booking Details has been updated successfully');

					echo (json_encode(array('status' => TRUE)));
					exit;

				} else if ($BookingType == 4) {

					// =================== Site Logs ===================   
					$LoadInfoJson = json_encode($LoadInfo);
					$condJson = json_encode($Cond);

					$SiteLogInfo = array(
						'TableName' => 'tbl_booking_loads1',
						'PrimaryID' => $LoadID,
						'UpdatedValue' => $LoadInfoJson . " => " . $condJson,
						'UpdatedByUserID' => $this->session->userdata['userId'],
						'SitePage' => 'booking update Haulage',
						'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
						'BrowserAgent' => getBrowserAgent(),
						'AgentString' => $this->agent->agent_string(),
						'UserPlatform' => $this->agent->platform()
					);
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
					///* ===================================== 

					$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID);

					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result();
					$LT = '';
					if ($data['LoadInfo']->LorryType == 1) {
						$LT = 'Tipper';
					} else if ($data['LoadInfo']->LorryType == 2) {
						$LT = 'Grab';
					} else if ($data['LoadInfo']->LorryType == 3) {
						$LT = 'Bin';
					} else {
						$LT = '';
					}

					$TB = '';
					if ($data['LoadInfo']->TonBook == 1) {
						$TB = ' Tonnage ';
					} else {
						$TB = ' Load ';
					}

					$siteInDateTime = '<b>In Time: </b>' . $data['LoadInfo']->SIDateTime . ' <br>';
					$siteOutDateTime = '<b>Out Time: </b>' . $data['LoadInfo']->SODateTime . ' <br>';
					$HaulageInDateTime = '<b>Haulage In Time: </b>' . $data['LoadInfo']->HSIDateTime . ' <br>';
					$HaulageOutDateTime = '<b>Haulage Out Time: </b>' . $data['LoadInfo']->HSODateTime . ' <br>';

					$MaterialText = $data['LoadInfo']->MaterialName . ' Collected ' . $LT . ' ' . $TB;

					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
									<b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
								</div> 
							</div>	 
						<div style="width:100%;float: left;" >   
							<b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
							<b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
							<b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> 
							<b>Permit Reference No: </b>' . $data['LoadInfo']->PermitRefNo . ' <br/><hr>
							<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>   
							<b>Conveyance Note No:</b> ' . $data['LoadInfo']->ConveyanceNo . '<br>		
							<b>Date Time: </b>' . $data['LoadInfo']->CDateTime . '<br>		 
							' . $siteInDateTime . '
							' . $siteOutDateTime . '
							' . $HaulageInDateTime . '
							' . $HaulageOutDateTime . '
							<b>Vehicle Reg. No. </b> ' . $data['LoadInfo']->VehicleRegNo . '  <br> 
							<b>Haulier </b> ' . $data['LoadInfo']->Haulier . '  <br> 
							<b>Driver Name: </b> ' . $data['LoadInfo']->DriverName . '<br>  
							<b>Driver Signature: </b>   
							<div><img src="/assets/DriverSignature/' . $data['LoadInfo']->dsignature . '" width ="100" height="40" style="float:left"></div> <br/>   
							<b>Company Name: </b> ' . $data['LoadInfo']->CompanyName . ' <br>		
							<b>Site Address: </b> ' . $data['LoadInfo']->OpportunityName . '<br>		 		
							<b>Haulage Address: </b> ' . $data['LoadInfo']->TipName . ',' . $data['LoadInfo']->Street1 . ',' . $data['LoadInfo']->Street2 . ',
							' . $data['LoadInfo']->Town . ',' . $data['LoadInfo']->County . ',' . $data['LoadInfo']->PostCode . '<br>		 		 
							<b>Material: </b> ' . $MaterialText . '  <br> 
							<b>SicCode: </b> ' . $data['LoadInfo']->LoadSICCODE . '  <br>  
							<b>Gross Weight: </b> ' . $data['LoadInfo']->GrossWeight . ' KGs <br>  
							<b>Tare Weight: </b> ' . $data['LoadInfo']->Tare . ' KGs  <br>  
							<b>Net Weight: </b> ' . $data['LoadInfo']->Net . ' KGs  <br>   
						</div>  
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName . '<br> 
							<b>Received By: </b> 
							<div><img src="/uploads/Signature/' . $data['LoadInfo']->Signature2 . '" width ="100" height="40" style="float:left"></div>
							' . $data['LoadInfo']->CustomerName2 . '<br> 
							<p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
								' . $PDFContent[0]->outpdf_para2 . '<br>  
								<b>' . $PDFContent[0]->outpdf_para3 . '</b></p>
							<p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
									<b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
									<b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
									' . $PDFContent[0]->FooterText . '</p>
							<p style="font-size: 5px;"><b> P' . date("dmYHis") . ' </p>		
						</div>  
					</div></body></html>';

					$pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data['LoadInfo']->ReceiptName;
					$mpdf = new mPDF('utf-8', array(70, 240), '', '', 5, 5, 5, 5, 5, 5);
					$mpdf->keep_table_proportions = false;
					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath);

					$this->session->set_flashdata('success', 'Booking Details has been updated successfully');

					echo (json_encode(array('status' => TRUE)));
					exit;

				}


			} else {
				echo (json_encode(array('status' => FALSE)));
			}

		}
	}
	function BookingRequestLogsAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['BookingID'] = $this->input->post('BookingID');
			$data['BookingLogs'] = $this->Booking_model->ShowBookingLogs($data['BookingID']);

			$html = $this->load->view('Booking/BookingRequestLogs', $data, true);
			echo json_encode($html);
		}
	}

	function OppoProductLogsAJAX()
	{
		if ($this->isEdit == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			$data['ProductID'] = $this->input->post('ProductID');
			$data['OppoProductLogs'] = $this->Booking_model->ShowProductLogs($data['ProductID']);

			$html = $this->load->view('Booking/OppoProductLogs', $data, true);
			echo json_encode($html);
		}
	}

	function DuplicateBookingRequest($BookingRequestID)
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($BookingRequestID == null) {
				redirect('BookingRequest');
			}
			//echo $BookingRequestID ; 
			//exit;
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				//  echo "<PRE>";
				//  print_r($_POST);
				//  echo "</PRE>"; 
				// exit;
				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');
				$this->form_validation->set_rules('ContactMobile', 'Site Contact Mobile', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));

					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$OpportunityName = $this->security->xss_clean($this->input->post('OpportunityName'));
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));

					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));

					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('BookingsRequest');
						}
						if (trim($ContactMobile) == '') {
							$this->session->set_flashdata('error', 'Contact Mobile Must Not be blank');
							redirect('BookingsRequest');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}


					$BookingInfo = array(
						'CompanyID' => $CompanyID,
						'CompanyName' => $CompanyName,
						'OpportunityID' => $OpportunityID,
						'OpportunityName' => $OpportunityName,
						'Street1' => $Street1,
						'Street2' => $Street2,
						'Town' => $Town,
						'County' => $County,
						'PostCode' => $PostCode,
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'BookedBy' => $this->session->userdata['userId'],
						'Status' => 1,
						'DuplicateBooking' => 1
					);
					$BookingRequestID = $this->Common_model->insert("tbl_booking_request", $BookingInfo);
					if ($BookingRequestID) {

						/* ========================================================================= */
						$LoadInfoJson = json_encode($BookingInfo);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_request',
							'PrimaryID' => $BookingRequestID,
							'UpdatedValue' => $LoadInfoJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'Duplicate Booking Request',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ========================================================================= */

						//echo count($BookingType);

						for ($i = 0; $i < count($BookingType); $i++) {
							if ($BookingType[$i] != "" && $DescriptionofMaterial[$i] != "" && $BookingDateTime[$i] != "") {
								$BookingInfo = array(
									'BookingRequestID' => $BookingRequestID,
									'BookingType' => $BookingType[$i],
									'MaterialID' => $DescriptionofMaterial[$i],
									'LoadType' => $LoadType[$i],
									'LorryType' => $LorryType[$i],
									'MaterialName' => $MaterialName[$i],
									'Loads' => $Loads[$i],
									'Days' => '1',
									'Price' => $Price[$i],
									'SICCode' => $SICCode[$i],
									'PurchaseOrderNo' => $PurchaseOrderNo[$i],
									'OpenPO' => $OpenPO[$i],
									'TotalAmount' => $TotalHidden[$i],
									'BookedBy' => $this->session->userdata['userId']
								);
								$BookingID = '';
								echo $BookingID = $this->Common_model->insert("tbl_booking1", $BookingInfo);
								if ($BookingID) {

									/* ========================================================================= */
									$LoadInfoJson = json_encode($BookingInfo);

									$SiteLogInfo = array(
										'TableName' => 'tbl_booking1',
										'PrimaryID' => $BookingID,
										'UpdatedValue' => $LoadInfoJson,
										'UpdatedByUserID' => $this->session->userdata['userId'],
										'SitePage' => 'Duplicate Booking Request',
										'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
										'BrowserAgent' => getBrowserAgent(),
										'AgentString' => $this->agent->agent_string(),
										'UserPlatform' => $this->agent->platform()
									);
									$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
									/* ========================================================================= */


									$BDT = '';
									$BDT = explode(',', $BookingDateTime[$i]);
									$BookingDate = array();
									for ($j = 0; $j < count($BDT); $j++) {
										$B = '';
										$B = explode('/', $BDT[$j]);
										//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0]; 
										$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
									}
									sort($BookingDate);
									for ($k = 0; $k < count($BookingDate); $k++) {
										$BookingDateInfo = array(
											'BookingRequestID' => $BookingRequestID,
											'BookingID' => $BookingID,
											'BookingDate' => $BookingDate[$k],
											'ApproveLoads' => $Loads[$i],
											'BookedBy' => $this->session->userdata['userId']
										);
										$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
										if ($insDate) {

											/* ========================================================================= */
											$LoadInfoJson = json_encode($BookingDateInfo);

											$SiteLogInfo = array(
												'TableName' => 'tbl_booking_date1',
												'PrimaryID' => $insDate,
												'UpdatedValue' => $LoadInfoJson,
												'UpdatedByUserID' => $this->session->userdata['userId'],
												'SitePage' => 'Duplicate Booking Request',
												'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
												'BrowserAgent' => getBrowserAgent(),
												'AgentString' => $this->agent->agent_string(),
												'UserPlatform' => $this->agent->platform()
											);
											$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
											/* ========================================================================= */

											if ($Price[$i] != '' && $Price[$i] != 0) {
												if ($k == 0) {
													$ProductInfo = array(
														'OpportunityID' => $OpportunityID,
														'MaterialID' => $DescriptionofMaterial[$i],
														'SICCode' => $SICCode[$i],
														'BookingDateID' => $insDate,
														'BookingID' => $BookingID,
														'DateRequired' => $BookingDate[$k],
														'UnitPrice' => $Price[$i],
														'LorryType' => $LorryType[$i],
														'PurchaseOrderNo' => $PurchaseOrderNo[$i],
														'Qty' => $Loads[$i],
														'PriceType' => '0',
														'CreateUserID' => $this->session->userdata['userId'],
														'EditUserID' => $this->session->userdata['userId']
													);
													$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

													/* ========================================================================= */
													$LoadInfoJson = json_encode($ProductInfo);

													$SiteLogInfo = array(
														'TableName' => 'tbl_product',
														'PrimaryID' => $PID,
														'UpdatedValue' => $LoadInfoJson,
														'UpdatedByUserID' => $this->session->userdata['userId'],
														'SitePage' => 'Duplicate Booking Request',
														'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
														'BrowserAgent' => getBrowserAgent(),
														'AgentString' => $this->agent->agent_string(),
														'UserPlatform' => $this->agent->platform()
													);
													$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
													/* ========================================================================= */

												}
											}
										}
									}
								}
							}
						}
						$this->session->set_flashdata('success', 'Booking (' . $BookingRequestID . ') has been Duplicated successfully');
					} else {
						$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');
					}

					redirect('BookingRequest');
				}
			}

			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			$BookingReqInfo = array('BookingRequestID' => $BookingRequestID);
			$data['BookingRequest'] = $this->Common_model->select_where('tbl_booking_request', $BookingReqInfo);

			$data['OppoContact'] = $this->Booking_model->getContactsByOpportunity($data['BookingRequest']['OpportunityID']);

			$data['BookingDates'] = $this->Booking_model->GetBookingRequestDates($BookingRequestID);
			$data['CollectionMaterialList'] = $this->Booking_model->getMaterialList1('IN');
			$data['DeliveryMaterialList'] = $this->Booking_model->getMaterialList1('OUT');


			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Duplicate Booking Request';
			$this->global['active_menu'] = 'duplicatebooking';

			$this->loadViews("Booking/DuplicateBookingRequest", $this->global, $data, NULL);
		}
	}

	function DuplicateBookingRequestDaywork($BookingRequestID)
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($BookingRequestID == null) {
				redirect('BookingRequest');
			}
			//echo $BookingRequestID ; 
			//exit;
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');
				$this->form_validation->set_rules('ContactMobile', 'Site Contact Mobile', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					// exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));

					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$OpportunityName = $this->security->xss_clean($this->input->post('OpportunityName'));
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));

					//$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber')); 
					//$OpenPO = $this->security->xss_clean($this->input->post('OpenPO')); 
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					$DayWorkType = $this->security->xss_clean($this->input->post('DayWorkType'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));


					//$JourneyHour = $this->security->xss_clean($this->input->post('JourneyHour'));
					//$JourneyMin = $this->security->xss_clean($this->input->post('JourneyMin'));

					//$JourneyTime = $JourneyHour.":".$JourneyMin;
					$JourneyTime = $this->security->xss_clean($this->input->post('JourneyTime'));

					$StartTime = $this->security->xss_clean($this->input->post('StartTime'));
					$FinishTime = $this->security->xss_clean($this->input->post('FinishTime'));

					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('BookingsRequest');
						}
						if (trim($ContactMobile) == '') {
							$this->session->set_flashdata('error', 'Contact Mobile Must Not be blank');
							redirect('BookingsRequest');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}
					//echo "<PRE>"; 
					//print_r($_POST);
					//echo "</PRE>";
					//exit;

					$BookingInfo = array(
						'CompanyID' => $CompanyID,
						'CompanyName' => $CompanyName,
						'OpportunityID' => $OpportunityID,
						'OpportunityName' => $OpportunityName,
						'Street1' => $Street1,
						'Street2' => $Street2,
						'Town' => $Town,
						'County' => $County,
						'PostCode' => $PostCode,
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'JourneyTime' => $JourneyTime,
						'StartTime' => $StartTime,
						'FinishTime' => $FinishTime,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'BookedBy' => $this->session->userdata['userId'],
						'Status' => 1,
						'DuplicateBooking' => 1
					);
					$BookingRequestID = $this->Common_model->insert("tbl_booking_request", $BookingInfo);
					if ($BookingRequestID) {

						/* ========================================================================= */
						$LoadInfoJson = json_encode($BookingInfo);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_request',
							'PrimaryID' => $BookingRequestID,
							'UpdatedValue' => $LoadInfoJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'Duplicate DayWork Booking Request',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ========================================================================= */
						//echo "<PRE>"; 
						//print_r($_POST);
						//echo "</PRE>";
						//exit;

						for ($i = 0; $i < count($BookingType); $i++) {
							if ($BookingType[$i] != "" && $DescriptionofMaterial[$i] != "" && $BookingDateTime[$i] != "") {
								$BookingInfo = array(
									'BookingRequestID' => $BookingRequestID,
									'BookingType' => '3',
									'MaterialID' => $DescriptionofMaterial[$i],
									'DayWorkType' => $DayWorkType[$i],
									'LoadType' => $LoadType[$i],
									'LorryType' => $LorryType[$i],
									'MaterialName' => $MaterialName[$i],
									'Loads' => $Loads[$i],
									'Days' => '1',
									'Price' => $Price[$i],
									'SICCode' => $SICCode[$i],
									'PurchaseOrderNo' => $PurchaseOrderNo[$i],
									'OpenPO' => $OpenPO[$i],
									'TotalAmount' => $TotalHidden[$i],
									'BookedBy' => $this->session->userdata['userId']
								);
								$BookingID = '';
								$BookingID = $this->Common_model->insert("tbl_booking1", $BookingInfo);
								if ($BookingID) {

									/* ========================================================================= */
									$LoadInfoJson = json_encode($BookingInfo);

									$SiteLogInfo = array(
										'TableName' => 'tbl_booking1',
										'PrimaryID' => $BookingID,
										'UpdatedValue' => $LoadInfoJson,
										'UpdatedByUserID' => $this->session->userdata['userId'],
										'SitePage' => 'Duplicate DayWork Booking Request',
										'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
										'BrowserAgent' => getBrowserAgent(),
										'AgentString' => $this->agent->agent_string(),
										'UserPlatform' => $this->agent->platform()
									);
									$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
									/* ========================================================================= */


									$BDT = '';
									$BDT = explode(',', $BookingDateTime[$i]);
									$BookingDate = array();
									for ($j = 0; $j < count($BDT); $j++) {
										$B = '';
										$B = explode('/', $BDT[$j]);
										//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0]; 
										$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
									}
									sort($BookingDate);
									for ($k = 0; $k < count($BookingDate); $k++) {
										$BookingDateInfo = array(
											'BookingRequestID' => $BookingRequestID,
											'BookingID' => $BookingID,
											'BookingDate' => $BookingDate[$k],
											'ApproveLoads' => $Loads[$i],
											'BookedBy' => $this->session->userdata['userId']
										);
										$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
										if ($insDate) {

											/* ========================================================================= */
											$LoadInfoJson = json_encode($BookingDateInfo);

											$SiteLogInfo = array(
												'TableName' => 'tbl_booking_date1',
												'PrimaryID' => $insDate,
												'UpdatedValue' => $LoadInfoJson,
												'UpdatedByUserID' => $this->session->userdata['userId'],
												'SitePage' => 'Duplicate DayWork Booking Request',
												'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
												'BrowserAgent' => getBrowserAgent(),
												'AgentString' => $this->agent->agent_string(),
												'UserPlatform' => $this->agent->platform()
											);
											$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
											/* ========================================================================= */


											if ($Price[$i] != '' && $Price[$i] != 0) {
												if ($k == 0) {
													$ProductInfo = array(
														'OpportunityID' => $OpportunityID,
														'MaterialID' => $DescriptionofMaterial[$i],
														'SICCode' => $SICCode[$i],
														'BookingDateID' => $insDate,
														'BookingID' => $BookingID,
														'DateRequired' => $BookingDate[$k],
														'UnitPrice' => $Price[$i],
														'LorryType' => $LorryType[$i],
														'PurchaseOrderNo' => $PurchaseOrderNo[$i],
														'Qty' => $Loads[$i],
														'PriceType' => '0',
														'CreateUserID' => $this->session->userdata['userId'],
														'EditUserID' => $this->session->userdata['userId']
													);
													$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

													/* ========================================================================= */
													$LoadInfoJson = json_encode($ProductInfo);

													$SiteLogInfo = array(
														'TableName' => 'tbl_product',
														'PrimaryID' => $PID,
														'UpdatedValue' => $LoadInfoJson,
														'UpdatedByUserID' => $this->session->userdata['userId'],
														'SitePage' => 'Duplicate DayWork Booking Request',
														'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
														'BrowserAgent' => getBrowserAgent(),
														'AgentString' => $this->agent->agent_string(),
														'UserPlatform' => $this->agent->platform()
													);
													$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
													/* ========================================================================= */

												}
											}
										}
									}
								}
							}
						}
						$this->session->set_flashdata('success', 'DayWork Booking (' . $BookingRequestID . ') has been Duplicated successfully');
					} else {
						$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');
					}
					redirect('BookingRequest');
				}
			}

			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			$BookingReqInfo = array('BookingRequestID' => $BookingRequestID);
			$data['BookingRequest'] = $this->Common_model->select_where('tbl_booking_request', $BookingReqInfo);
			$data['OppoContact'] = $this->Booking_model->getContactsByOpportunity($data['BookingRequest']['OpportunityID']);
			$data['BookingDates'] = $this->Booking_model->GetBookingRequestDates($BookingRequestID);

			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Duplicate DayWork Booking Request';
			$this->global['active_menu'] = 'duplicatebooking';

			$this->loadViews("Booking/DuplicateBookingRequestDayWork", $this->global, $data, NULL);
		}
	}

	function DuplicateBookingRequestHaulage($BookingRequestID)
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($BookingRequestID == null) {
				redirect('BookingRequest');
			}
			//echo $BookingRequestID ; 
			//exit;
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');
				$this->form_validation->set_rules('ContactMobile', 'Site Contact Mobile', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));

					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$OpportunityName = $this->security->xss_clean($this->input->post('OpportunityName'));
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));

					$TipName = $this->security->xss_clean($this->input->post('TipName'));
					$tip_long = $this->security->xss_clean($this->input->post('tip_long'));
					$tip_lat = $this->security->xss_clean($this->input->post('tip_lat'));

					if ($TipName != '') {
						for ($i = 0; $i < count($BookingType); $i++) {
							$TipInfo = array('TipName' => $TipName[$i], 'tip_long' => $tip_long[$i], 'tip_lat' => $tip_lat[$i], 'RandomTip' => '1', 'CreatedBy' => $this->session->userdata['userId']);
							$TipID = $this->Common_model->insert("tbl_tipaddress", $TipInfo);
						}
					}
					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('BookingsRequest');
						}
						if (trim($ContactMobile) == '') {
							$this->session->set_flashdata('error', 'Contact Mobile Must Not be blank');
							redirect('BookingsRequest');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}

					$BookingInfo = array(
						'CompanyID' => $CompanyID,
						'CompanyName' => $CompanyName,
						'OpportunityID' => $OpportunityID,
						'OpportunityName' => $OpportunityName,
						'Street1' => $Street1,
						'Street2' => $Street2,
						'Town' => $Town,
						'County' => $County,
						'PostCode' => $PostCode,
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'BookedBy' => $this->session->userdata['userId'],
						'Status' => 1,
						'DuplicateBooking' => 1
					);
					$BookingRequestID = $this->Common_model->insert("tbl_booking_request", $BookingInfo);
					if ($BookingRequestID) {

						/* ========================================================================= */
						$LoadInfoJson = json_encode($BookingInfo);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_request',
							'PrimaryID' => $BookingRequestID,
							'UpdatedValue' => $LoadInfoJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'Duplicate Booking Request Haulage',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ========================================================================= */


						for ($i = 0; $i < count($BookingType); $i++) {
							if ($BookingType[$i] != "" && $DescriptionofMaterial[$i] != "" && $BookingDateTime[$i] != "") {
								$BookingInfo = array(
									'BookingRequestID' => $BookingRequestID,
									'TipID' => $TipID,
									'BookingType' => '4',
									'MaterialID' => $DescriptionofMaterial[$i],
									'LoadType' => $LoadType[$i],
									'LorryType' => $LorryType[$i],
									'MaterialName' => $MaterialName[$i],
									'Loads' => $Loads[$i],
									'Days' => '1',
									'Price' => $Price[$i],
									'SICCode' => $SICCode[$i],
									'PurchaseOrderNo' => $PurchaseOrderNo[$i],
									'OpenPO' => $OpenPO[$i],
									'TotalAmount' => $TotalHidden[$i],
									'BookedBy' => $this->session->userdata['userId']
								);
								$BookingID = '';
								$BookingID = $this->Common_model->insert("tbl_booking1", $BookingInfo);
								if ($BookingID) {

									/* ========================================================================= */
									$LoadInfoJson = json_encode($BookingInfo);

									$SiteLogInfo = array(
										'TableName' => 'tbl_booking1',
										'PrimaryID' => $BookingID,
										'UpdatedValue' => $LoadInfoJson,
										'UpdatedByUserID' => $this->session->userdata['userId'],
										'SitePage' => 'Duplicate  Booking Request Haulage',
										'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
										'BrowserAgent' => getBrowserAgent(),
										'AgentString' => $this->agent->agent_string(),
										'UserPlatform' => $this->agent->platform()
									);
									$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
									/* ========================================================================= */

									$BDT = '';
									$BDT = explode(',', $BookingDateTime[$i]);
									$BookingDate = array();
									for ($j = 0; $j < count($BDT); $j++) {
										$B = '';
										$B = explode('/', $BDT[$j]);
										//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0]; 
										$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
									}
									sort($BookingDate);
									for ($k = 0; $k < count($BookingDate); $k++) {
										$BookingDateInfo = array(
											'BookingRequestID' => $BookingRequestID,
											'BookingID' => $BookingID,
											'BookingDate' => $BookingDate[$k],
											'ApproveLoads' => $Loads[$i],
											'BookedBy' => $this->session->userdata['userId']
										);
										$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
										if ($insDate) {

											/* ========================================================================= */
											$LoadInfoJson = json_encode($BookingDateInfo);

											$SiteLogInfo = array(
												'TableName' => 'tbl_booking_date1',
												'PrimaryID' => $insDate,
												'UpdatedValue' => $LoadInfoJson,
												'UpdatedByUserID' => $this->session->userdata['userId'],
												'SitePage' => 'Duplicate Booking Request Haulage',
												'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
												'BrowserAgent' => getBrowserAgent(),
												'AgentString' => $this->agent->agent_string(),
												'UserPlatform' => $this->agent->platform()
											);
											$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
											/* ========================================================================= */

											if ($Price[$i] != '' && $Price[$i] != 0) {
												if ($k == 0) {
													$ProductInfo = array(
														'OpportunityID' => $OpportunityID,
														'MaterialID' => $DescriptionofMaterial[$i],
														'TipID' => $TipID,
														'TipName' => $TipName[$i],
														'SICCode' => $SICCode[$i],
														'BookingDateID' => $insDate,
														'BookingID' => $BookingID,
														'DateRequired' => $BookingDate[$k],
														'UnitPrice' => $Price[$i],
														'LorryType' => $LorryType[$i],
														'PurchaseOrderNo' => $PurchaseOrderNo[$i],
														'Qty' => $Loads[$i],
														'PriceType' => '0',
														'CreateUserID' => $this->session->userdata['userId'],
														'EditUserID' => $this->session->userdata['userId']
													);
													$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

													/* ========================================================================= */
													$LoadInfoJson = json_encode($ProductInfo);

													$SiteLogInfo = array(
														'TableName' => 'tbl_product',
														'PrimaryID' => $PID,
														'UpdatedValue' => $LoadInfoJson,
														'UpdatedByUserID' => $this->session->userdata['userId'],
														'SitePage' => 'Duplicate  Booking Request Haulage',
														'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
														'BrowserAgent' => getBrowserAgent(),
														'AgentString' => $this->agent->agent_string(),
														'UserPlatform' => $this->agent->platform()
													);
													$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
													/* ========================================================================= */

												}
											}
										}
									}
								}
							}
						}

						$this->session->set_flashdata('success', 'Haulage Booking (' . $BookingRequestID . ')  has been Duplicated successfully');
					} else {
						$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');
					}
					redirect('BookingRequest');
				}
			}

			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			$BookingReqInfo = array('BookingRequestID' => $BookingRequestID);
			$data['BookingRequest'] = $this->Common_model->select_where('tbl_booking_request', $BookingReqInfo);
			$data['OppoContact'] = $this->Booking_model->getContactsByOpportunity($data['BookingRequest']['OpportunityID']);
			$data['BookingDates'] = $this->Booking_model->GetBookingRequestDatesHaulage($BookingRequestID);


			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Duplicate Haulage Booking Request';
			$this->global['active_menu'] = 'duplicatebooking';

			$this->loadViews("Booking/DuplicateBookingRequestHaulage", $this->global, $data, NULL);
		}
	}


	function DuplicateBookingRequestTonnage($BookingRequestID)
	{
		if ($this->isAdd == 0) {
			$data = array();
			$this->global['pageTitle'] = 'Error';
			$this->loadViews("permission", $this->global, $data, NULL);
		} else {
			if ($BookingRequestID == null) {
				redirect('BookingRequest');
			}
			//echo $BookingRequestID ; 
			//exit;
			$data = array();

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyID', 'Company Name', 'trim|required');
				$this->form_validation->set_rules('OpportunityID', 'Opportunity ', 'trim|required');
				$this->form_validation->set_rules('ContactID', 'Contact', 'trim|required');
				$this->form_validation->set_rules('ContactMobile', 'Site Contact Mobile', 'trim|required');

				if ($this->form_validation->run()) {

					//var_dump($_POST);
					//exit;
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
					$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));

					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$OpportunityName = $this->security->xss_clean($this->input->post('OpportunityName'));
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));

					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactEmail = $this->security->xss_clean($this->input->post('ContactEmail'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));
					$PriceBy = $this->security->xss_clean($this->input->post('PriceBy'));

					$WaitingCharge = $this->security->xss_clean($this->input->post('WaitingCharge'));
					$WaitingTime = $this->security->xss_clean($this->input->post('WaitingTime'));

					$Notes = $this->security->xss_clean($this->input->post('Notes'));
					$SubTotalAmount = $this->security->xss_clean($this->input->post('SubTotalAmount'));
					$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
					$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
					$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
					$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));

					$BookingType = $this->security->xss_clean($this->input->post('BookingType'));
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));

					$TotalTon = $this->security->xss_clean($this->input->post('TotalTon'));
					$TonPerLoad = $this->security->xss_clean($this->input->post('TonPerLoad'));

					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$SICCode = $this->security->xss_clean($this->input->post('SICCode'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$OpenPO = $this->security->xss_clean($this->input->post('OpenPO'));
					$TotalHidden = $this->security->xss_clean($this->input->post('TotalHidden'));

					if ($ContactID == '0') {
						if (trim($ContactName) == '') {
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');
							redirect('Bookings');
						}
						$ContactID = $this->generateRandomString();
						$ConInfo = array('ContactID' => $ContactID, 'ContactIDMapKey' => $ContactID, 'ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$this->Common_model->insert("tbl_contacts", $ConInfo);

						$OC = array('OpportunityID' => $OpportunityID, 'ContactID' => $ContactID);
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC);
					} else {
						$ConInfo = array('ContactName' => $ContactName, 'MobileNumber' => $ContactMobile, 'EmailAddress' => $ContactEmail, 'Type' => '1', 'Position' => 'Site Contact');
						$cond = array('ContactID' => $ContactID);
						$this->Common_model->update("tbl_contacts", $ConInfo, $cond);
					}

					$BookingInfo = array(
						'CompanyID' => $CompanyID,
						'CompanyName' => $CompanyName,
						'OpportunityID' => $OpportunityID,
						'OpportunityName' => $OpportunityName,
						'Street1' => $Street1,
						'Street2' => $Street2,
						'Town' => $Town,
						'County' => $County,
						'PostCode' => $PostCode,
						'ContactID ' => $ContactID,
						'ContactName' => $ContactName,
						'ContactMobile' => $ContactMobile,
						'ContactEmail' => $ContactEmail,
						'WaitingCharge' => $WaitingCharge,
						'WaitingTime' => $WaitingTime,
						'PriceBy' => $PriceBy,
						'Notes' => $Notes,
						'SubTotalAmount' => $SubTotalAmount,
						'VatAmount' => $VatAmount,
						'TotalAmount' => $TotalAmount,
						'PaymentType' => $PaymentType,
						'PaymentRefNo' => $PaymentRefNo,
						'BookedBy' => $this->session->userdata['userId'],
						'Status' => 1,
						'DuplicateBooking' => 1
					);
					$BookingRequestID = $this->Common_model->insert("tbl_booking_request", $BookingInfo);
					if ($BookingRequestID) {

						/* ========================================================================= */
						$LoadInfoJson = json_encode($BookingInfo);

						$SiteLogInfo = array(
							'TableName' => 'tbl_booking_request',
							'PrimaryID' => $BookingRequestID,
							'UpdatedValue' => $LoadInfoJson,
							'UpdatedByUserID' => $this->session->userdata['userId'],
							'SitePage' => 'Duplicate Booking Request Tonnage',
							'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
							'BrowserAgent' => getBrowserAgent(),
							'AgentString' => $this->agent->agent_string(),
							'UserPlatform' => $this->agent->platform()
						);
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
						/* ========================================================================= */


						for ($i = 0; $i < count($BookingType); $i++) {
							if ($BookingType[$i] != "" && $DescriptionofMaterial[$i] != "" && $BookingDateTime[$i] != "") {
								$BookingInfo = array(
									'BookingRequestID' => $BookingRequestID,
									'BookingType' => $BookingType[$i],
									'MaterialID' => $DescriptionofMaterial[$i],
									'TonBook' => '1',
									'TotalTon' => $TotalTon[$i],
									'TonPerLoad' => $TonPerLoad[$i],
									'LoadType' => $LoadType[$i],
									'LorryType' => $LorryType[$i],
									'MaterialName' => $MaterialName[$i],
									'Loads' => $Loads[$i],
									'Days' => '1',
									'Price' => $Price[$i],
									'SICCode' => $SICCode[$i],
									'PurchaseOrderNo' => $PurchaseOrderNo[$i],
									'OpenPO' => $OpenPO[$i],
									'TotalAmount' => $TotalHidden[$i],
									'BookedBy' => $this->session->userdata['userId']
								);
								$BookingID = '';
								$BookingID = $this->Common_model->insert("tbl_booking1", $BookingInfo);
								if ($BookingID) {

									/* ========================================================================= */
									$LoadInfoJson = json_encode($BookingInfo);

									$SiteLogInfo = array(
										'TableName' => 'tbl_booking1',
										'PrimaryID' => $BookingID,
										'UpdatedValue' => $LoadInfoJson,
										'UpdatedByUserID' => $this->session->userdata['userId'],
										'SitePage' => 'Duplicate Booking Request Tonnage',
										'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
										'BrowserAgent' => getBrowserAgent(),
										'AgentString' => $this->agent->agent_string(),
										'UserPlatform' => $this->agent->platform()
									);
									$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
									/* ========================================================================= */


									$BDT = '';
									$BDT = explode(',', $BookingDateTime[$i]);
									$BookingDate = array();
									for ($j = 0; $j < count($BDT); $j++) {
										$B = '';
										$B = explode('/', $BDT[$j]);
										//$BookingDate[$j] = $B[2]."-".$B[1]."-".$B[0]; 
										$BookingDate[$j] = trim($B[2]) . "-" . trim($B[1]) . "-" . trim($B[0]);
									}
									sort($BookingDate);
									for ($k = 0; $k < count($BookingDate); $k++) {
										$BookingDateInfo = array(
											'BookingRequestID' => $BookingRequestID,
											'BookingID' => $BookingID,
											'BookingDate' => $BookingDate[$k],
											'ApproveLoads' => $Loads[$i],
											'BookedBy' => $this->session->userdata['userId']
										);
										$insDate = $this->Common_model->insert("tbl_booking_date1", $BookingDateInfo);
										if ($insDate) {

											/* ========================================================================= */
											$LoadInfoJson = json_encode($BookingDateInfo);

											$SiteLogInfo = array(
												'TableName' => 'tbl_booking_date1',
												'PrimaryID' => $insDate,
												'UpdatedValue' => $LoadInfoJson,
												'UpdatedByUserID' => $this->session->userdata['userId'],
												'SitePage' => 'Duplicate Booking Request Tonnage',
												'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
												'BrowserAgent' => getBrowserAgent(),
												'AgentString' => $this->agent->agent_string(),
												'UserPlatform' => $this->agent->platform()
											);
											$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
											/* ========================================================================= */


											if ($Price[$i] != '' && $Price[$i] != 0) {
												if ($k == 0) {
													$ProductInfo = array(
														'OpportunityID' => $OpportunityID,
														'MaterialID' => $DescriptionofMaterial[$i],
														'SICCode' => $SICCode[$i],
														'BookingDateID' => $insDate,
														'PriceType' => '1',
														'DateRequired' => $BookingDate[$k],
														'UnitPrice' => $Price[$i],
														'LorryType' => $LorryType[$i],
														'PurchaseOrderNo' => $PurchaseOrderNo[$i],
														'Qty' => $Loads[$i],
														'TotalTon' => $TotalTon[$i],
														'CreateUserID' => $this->session->userdata['userId'],
														'EditUserID' => $this->session->userdata['userId']
													);
													$PID = $this->Common_model->insert("tbl_product", $ProductInfo);

													/* ========================================================================= */
													$LoadInfoJson = json_encode($ProductInfo);

													$SiteLogInfo = array(
														'TableName' => 'tbl_product',
														'PrimaryID' => $PID,
														'UpdatedValue' => $LoadInfoJson,
														'UpdatedByUserID' => $this->session->userdata['userId'],
														'SitePage' => 'Duplicate Booking Request Tonnage',
														'RemoteIPAddress' => $_SERVER['REMOTE_ADDR'],
														'BrowserAgent' => getBrowserAgent(),
														'AgentString' => $this->agent->agent_string(),
														'UserPlatform' => $this->agent->platform()
													);
													$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);
													/* ========================================================================= */

												}
											}
										}
									}
								}
							}
						}
						$this->session->set_flashdata('success', 'Tonnage Booking  (' . $BookingRequestID . ')  has been Duplicated successfully');
					} else {
						$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');
					}
					redirect('BookingRequest');
				}
			}

			$data['ApprovalUserList'] = $this->Common_model->ApprovalUserList();

			$BookingReqInfo = array('BookingRequestID' => $BookingRequestID);
			$data['BookingRequest'] = $this->Common_model->select_where('tbl_booking_request', $BookingReqInfo);

			$data['OppoContact'] = $this->Booking_model->getContactsByOpportunity($data['BookingRequest']['OpportunityID']);

			$data['BookingDates'] = $this->Booking_model->GetBookingRequestDates($BookingRequestID);
			$data['CollectionMaterialList'] = $this->Booking_model->getMaterialList('IN');
			$data['DeliveryMaterialList'] = $this->Booking_model->getMaterialList('OUT');


			$data['content'] = $this->Common_model->select_where('content_settings', array('id' => 1));
			$this->global['pageTitle'] = WEB_PAGE_TITLE . ' : Duplicate Booking Request Tonnage';
			$this->global['active_menu'] = 'duplicatebooking';

			$this->loadViews("Booking/DuplicateBookingRequestTonnage", $this->global, $data, NULL);
		}
	}

	function DriverLoadsExcelAjax()
	{
		// Fetch POST data
		$data = [
			'driver' => $this->input->post('driver'),
			'startDate' => $this->input->post('start_date'),
			'endDate' => $this->input->post('end_date')
		];

		// Retrieve data from the model
		$collectionData = $this->Booking_model->GetDriverRequestLoadsCollection($data['startDate'], $data['endDate'], $data['driver']);
		$deliveryData = $this->Booking_model->GetDriverRequestLoadsDelivery($data['startDate'], $data['endDate'], $data['driver']);
		$dayWorkData = $this->Booking_model->GetDriverRequestLoadsDayWork($data['startDate'], $data['endDate'], $data['driver']);
		$haulageData = $this->Booking_model->GetDriverRequestLoadsHaulage($data['startDate'], $data['endDate'], $data['driver']);

		// Combine all data (optional: can separate into different sheets if needed)
		$driverData = array_merge($collectionData, $deliveryData, $dayWorkData, $haulageData);

		// Load the PHPExcel library
		$this->load->library("excel");
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$sheet = $object->getActiveSheet();

		// Set the filename
		$fileName = 'Driver_Loads_' . date('YmdHis') . '.xlsx';
		$fileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).])", '', $fileName);
		$fileName = mb_ereg_replace("([\.]{2,})", '', $fileName);

		// Set header row
		$headers = [
			'Company Name',
			'Site Address',
			'Tip Address',
			'Material',
			'Conv. No.',
			'Start Time',
			'Time In',
			'Time Out',
			'Tip In Time',
			'Tip Ticket',
			'Expense'
		];
		$sheet->fromArray($headers, null, 'A1');



		// Make headers bold
		$headerRow = 'A1:K1'; // Range for header row
		$sheet->getStyle($headerRow)->getFont()->setBold(true);


		// Populate data rows
		$rowNumber = 2; // Start at the second row
		foreach ($driverData as $row) {
			$sheet->setCellValue('A' . $rowNumber, $row->CompanyName);  // Use -> for objects
			$sheet->setCellValue('B' . $rowNumber, $row->OpportunityName);
			$sheet->setCellValue('C' . $rowNumber, $row->TipName);
			$sheet->setCellValue('D' . $rowNumber, $row->MaterialName);
			$sheet->setCellValue('E' . $rowNumber, $row->ConveyanceNo);
			$sheet->setCellValue('F' . $rowNumber, $row->JobStartDateTime);
			$sheet->setCellValue('G' . $rowNumber, $row->SiteInDateTime);
			$sheet->setCellValue('H' . $rowNumber, $row->SiteOutDateTime);
			$sheet->setCellValue('I' . $rowNumber, $row->TipTicketDateTime);
			$sheet->setCellValue('J' . $rowNumber, $row->TipTicketID);
			$sheet->setCellValue('K' . $rowNumber, $row->Expenses);
			$rowNumber++;
		}

		// Auto-width for all columns
		foreach (range('A', 'K') as $columnID) {
			$sheet->getColumnDimension($columnID)->setAutoSize(true);
		}

		// Save the Excel file to the "DriverLoadsExcel" folder
		$filePath = FCPATH . 'DriverLoadsExcel/' . $fileName;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
		$object_writer->save($filePath);

		// Provide a response (optional)
		$response = array(
			'op' => 'ok',
			'FileName' => "DriverLoadsExcel/" . $fileName,
			'file' => "data:application/zip;base64," . base64_encode(file_get_contents("DriverLoadsExcel/" . $zname)) // Ensure correct base64 encoding
		);

		die(json_encode($response)); // Return JSON response
	}


	function generateRandomString($length = 12)
	{
		return substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
	}
	function object_to_array($data)
	{
		if (is_array($data) || is_object($data)) {
			$result = [];
			foreach ($data as $key => $value) {
				$result[$key] = (is_array($data) || is_object($data)) ? object_to_array($value) : $value;
			}
			return $result;
		}
		return $data;
	}
}


?>