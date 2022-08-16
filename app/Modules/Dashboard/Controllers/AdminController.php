<?php

 namespace Modules\Dashboard\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\RolesTable;
use App\Models\Common;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminController extends BaseController
{
	public function __construct()
	{
		$this->common_modal = new Common();
	}

	public function index()
	{
		$page_data = [];
		$role_id  = session()->get('role_id');
		$where = array();
		//filter
		$where = $this->filter_query($where);
		$where = implode(' AND ', $where);
		$departments = $this->common_modal->GetTotalCount(DEPARTMENT_TABLE);
		$page_data['departments'] = $departments;
		$page_data['model'] = $this->common_modal;
		
		echo view("\Modules\Dashboard\Views\index", $page_data);
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->to('admin');
	}

	public function upload()
	{
		/*$insert_id = 0;
		if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
			$file = $this->request->getFile('file');
			if (!$file->isValid()) {
				throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
			}
			$new_name = $file->getRandomName();
			$original_name = $file->getClientName();
			$type = $file->getClientMimeType();
			if ($file->isValid() && !$file->hasMoved()) {
				if ($file->move(ROOTPATH . 'uploads', $new_name)) {
					$data = array(
						'name' => $new_name,
						'original_name	' => $original_name,
						'mime_types	' => $type,
						'used	' => '0',
					);
					$insert_id = $this->common_modal->InsertTableData(MEDIA_TABLE, $data);
				}
			}
		}
		echo $insert_id; */
	} 

	//remove upload images during removal in dropzone 
	 public function remove_upload_images()
	{
		/* if ($this->request->getPost('id')) {
			$id = $this->request->getPost('id');
			$row = $this->common_modal->GetSingleRow(MEDIA_TABLE, array('id' => $id));
			$filename = $row['name'];

			$upload_dir = dirname(APPPATH) . "/uploads";

			$file_to_delete = $upload_dir . '/' . $filename;

			$delete = $this->common_modal->DeleteTableData(MEDIA_TABLE, array('id' => $id));
			if ($delete) {
				//unlink files
				unlink($file_to_delete);
			}
			$json_data['status'] = "success";
		} else {
			$json_data['status'] = 'error';
		}
		echo json_encode($json_data);
		die(); */
	}

	public function initChart()
	{
		if ($this->request->isAJAX()) {
			$order_month = [];
			$order_value = [];
			$db = db_connect();
			for ($m = 1; $m <= 12; $m++) {
				$start_date = date('Y-' . $m . '-1');
				$end_date = date('Y-' . $m . '-t');
				$start_date_time = strtotime($start_date);
				$start_end_date = strtotime($end_date);
				$order_count = $db->query("SELECT COUNT(id) from tbl_orders where created_at between '$start_date_time' and '$start_end_date'");
				if (!empty($order_count->getRowArray()['COUNT(id)'])):
					$order_value[] = $order_count->getRowArray()['COUNT(id)'];
				else :
					$order_value[] = 0;
				endif;
				$month_name = strtotime($start_date);
				$order_month[] = date('M', $month_name);
			}
			$json_data['order_month'] = $order_month;
			$json_data['order_value'] = $order_value;
			$json_data['status'] = "success";
			echo json_encode($json_data);
			die();
		} 
	}

	public function monthlyCustomers()
	{
		if ($this->request->isAJAX()) {
			$customers_month = [];
			$customers_value = [];
			$db = db_connect();
			for ($m = 1; $m <= 12; $m++) {
				$start_date = date('Y-' . $m . '-1');
				$end_date = date('Y-' . $m . '-t');
				$start_date_time = strtotime($start_date);
				$start_end_date = strtotime($end_date);
				$customers_count = $db->query("SELECT COUNT(id) from tbl_users where created_at between '$start_date_time' and '$start_end_date'");
	
				if (!empty($customers_count->getRowArray()['COUNT(id)'])):
					$customers_value[] = $customers_count->getRowArray()['COUNT(id)'];
				else :
					$customers_value[] = 0;
				endif;
				$month_name = strtotime($start_date);
				$customers_month[] = date('M', $month_name);
			}
			$json_data['customers_month'] = $customers_month;
			$json_data['customers_value'] = $customers_value;
			$json_data['status'] = "success";
			echo json_encode($json_data);
			die();
		} 
	}


	 public function exportData()
	{
		// Create new Spreadsheet object
		/* $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Set document properties
		$spreadsheet->getProperties()->setCreator('miraimedia.co.th')
			->setLastModifiedBy('Cholcool')
			->setTitle('how to export data to excel use phpspreadsheet in codeigniter')
			->setSubject('Generate Excel use PhpSpreadsheet in CodeIgniter')
			->setDescription('Export data to Excel Work for me!');

		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => array('rgb' => '333333'),
				),
			),
			'fill' => array(
				'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
				'startcolor' => array('rgb' => '0d0d0d'),
				'endColor'   => array('rgb' => 'f2f2f2'),
			),
		); 
		 $spreadsheet->getActiveSheet()->getStyle('7:11')->applyFromArray($styleArray);
		// auto fit column to content
		foreach(range('A', 'H') as $columnID) {
		  $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}  
		 $order_id = 1; */

		/* $query = "SELECT o.id, count(pv.skip_trace_record_id) as total from tbl_orders o, tbl_skip_tracing_records skr, tbl_skip_trace_record_phone_numbers pv where o.id=skr.order_id and skr.id=pv.skip_trace_record_id and o.id={$order_id} GROUP by pv.skip_trace_record_id order by total DESC";
		$total_phones = $this->common_modal->GetDataByRawQuery($query, 'single');
		$phone_count = 0;
		if (isset($total_phones['total'])) {
			$phone_count = $total_phones['total'];
		}

		$correct_phone_count = 0;
		$query = "SELECT o.id, count(pv.skip_trace_record_id) as total from tbl_orders o, tbl_skip_tracing_records skr, tbl_skip_trace_record_phone_numbers pv where o.id=skr.order_id and skr.id=pv.skip_trace_record_id and ( (pv.is_correct_phone='1' and pv.scraper_status='1') or (pv.is_correct_phone_from_scraper='1' and pv.scraper_status='3') ) and o.id={$order_id} GROUP by pv.skip_trace_record_id order by total DESC";
		$total_phones = $this->common_modal->GetDataByRawQuery($query, 'single');
		if (isset($total_phones['total'])) {
			$correct_phone_count = $total_phones['total'];
		}

		$relative_phone_count = 0;
		$query = "SELECT o.id, count(pv.skip_trace_record_id) as total from tbl_orders o, tbl_skip_tracing_records skr, tbl_skip_trace_record_phone_numbers pv where o.id=skr.order_id and skr.id=pv.skip_trace_record_id and ( (pv.is_correct_phone='2' and pv.scraper_status='1') or (pv.is_correct_phone_from_scraper='2' and pv.scraper_status='3') ) and o.id={$order_id} GROUP by pv.skip_trace_record_id order by total DESC";
		$total_phones = $this->common_modal->GetDataByRawQuery($query, 'single');
		if (isset($total_phones['total'])) {
			$relative_phone_count = $total_phones['total'];
		}

		$wrong_phone_count = 0;
		$query = "SELECT o.id, count(pv.skip_trace_record_id) as total from tbl_orders o, tbl_skip_tracing_records skr, tbl_skip_trace_record_phone_numbers pv where o.id=skr.order_id and skr.id=pv.skip_trace_record_id and ( (pv.is_correct_phone='3' and pv.scraper_status='1') or (pv.is_correct_phone_from_scraper='3' and pv.scraper_status='3') ) and o.id={$order_id} GROUP by pv.skip_trace_record_id order by total DESC";
		$total_phones = $this->common_modal->GetDataByRawQuery($query, 'single');
		if (isset($total_phones['total'])) {
			$wrong_phone_count = $total_phones['total'];
		}


		$headers = [
			'first_name' => 'Owner 1 First Name',
			'last_name' => 'Owner 1 Last Name',
			'owner2_first_name' => 'Owner 2 First Name',
			'owner2_last_name' => 'Owner 2 Last Name',
			'address' => 'Property Address',
			'city' => 'City',
			'state' => 'State',
			'zip' => 'Zip',
			'age' => 'Age',
		];  */

	/*  $headers_count = 1;
		for ($x = 1; $x <= $correct_phone_count; $x++) {
			$headers['phones'][1][] = "Phone " . $headers_count;
			$headers['phones'][1][] = "Phone " . $headers_count . " Type";
			$headers['phones'][1][] = "Phone " . $headers_count . " Name";
			$headers_count++;
		}

		for ($x = 1; $x <= $relative_phone_count; $x++) {
			$headers['phones'][2][] = "Phone " . $headers_count;
			$headers['phones'][2][] = "Phone " . $headers_count . " Type";
			$headers['phones'][2][] = "Phone " . $headers_count . " Name";
			$headers_count++;
		}

		for ($x = 1; $x <= $wrong_phone_count; $x++) {
			$headers['phones'][3][] = "Phone " . $headers_count;
			$headers['phones'][3][] = "Phone " . $headers_count . " Type";
			$headers['phones'][3][] = "Phone " . $headers_count . " Name";
			$headers_count++;
		}
		//_p($headers);
		
		$col = 1;
		$row = 1;
		foreach ($headers as $header_key => $header) :
			if($header_key=="phones") {
				$phone_headers = $header;
				foreach ($phone_headers as $ph_key => $ph_header_arr) {
					$phone_status_color = is_phone_correct_color($ph_key);
					
					foreach ($ph_header_arr as $ph_header) {
						$sheet->setCellValueByColumnAndRow($col, $row, $ph_header);
						$cell_key =  $sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
						$spreadsheet->getActiveSheet()->getStyle($cell_key)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($phone_status_color);
						$col++;
						//echo $col.'<br>';
					} 
				}
			} else {
				//echo $header_key.'-'.$header.'<br>'; 
				$sheet->setCellValueByColumnAndRow($col, $row, $header);
				$col++;
			}
			

		endforeach;
		
		$where = [];
		$where[] = " order_id = '$order_id' ";
		//$where = $this->filter_query($where);
		 $where = implode(' AND ', $where);

		$skip_records = $this->common_modal->GetTableRows(SKIP_TRACING_RECORDS_TABLE, $where, array('id', 'asc'));
		$row = 2;
		foreach ($skip_records as $skip_record) :

			$phone_numbers = $this->common_modal->GetSelectedFields(SKIP_TRACE_RECORDS_PHONE_NUMBER_TABLE, 'phone,phone_type,is_correct_phone,scraper_status,relative_name,relative_name_from_scraper,is_correct_phone_from_scraper', array('skip_trace_record_id' => $skip_record['id']));
			$sheet->setCellValueByColumnAndRow(1, $row, $skip_record['first_name']);
			$sheet->setCellValueByColumnAndRow(2, $row, $skip_record['last_name']);
			$sheet->setCellValueByColumnAndRow(3, $row, $skip_record['owner2_first_name']);
			$sheet->setCellValueByColumnAndRow(4, $row, $skip_record['owner2_last_name']);
			$sheet->setCellValueByColumnAndRow(5, $row, $skip_record['address']);
			$sheet->setCellValueByColumnAndRow(6, $row, $skip_record['city']);
			$sheet->setCellValueByColumnAndRow(7, $row, $skip_record['state']);
			$sheet->setCellValueByColumnAndRow(8, $row, $skip_record['zip']);
			$sheet->setCellValueByColumnAndRow(9, $row, $skip_record['age']);
			$col = 9;
			$phone_new_arr = [];
			for ($x = 0; $x < $phone_count; $x++) {
				if (isset($phone_numbers[$x])) {

					$phone = $phone_numbers[$x];
					$phone_type = phone_types($phone['phone_type']);
					if (is_array($phone_type)) {
						$phone_type = "";
					}
					if ($phone['scraper_status'] == 3) {
						$relative_name = $phone['relative_name_from_scraper'];
						$phone_correct_status = $phone['is_correct_phone_from_scraper'];
					} else {
						$relative_name = $phone['relative_name'];
						$phone_correct_status = $phone['is_correct_phone'];
					}
					$phone_correct_color = is_phone_correct_color($phone_correct_status);
					// just to move unverified records to bottom
					if ($phone_correct_status == 0) {
						$phone_correct_status = 4;
					}
					$phone_new_arr[$phone_correct_status][] = array($phone['phone'], $phone_type, $relative_name, $phone_correct_color);
				}
			}
			//_p($phone_new_arr);
			ksort($phone_new_arr);
			$empty_array = array(0, '', '', '');
			foreach ($phone_new_arr as $ps => $phone_arr) :

				// when correct phones
				if ($ps == 1 && count($phone_arr) != $correct_phone_count) {
					$left_arr = $correct_phone_count - count($phone_arr);
					for ($x = 0; $x < $left_arr; $x++) {
						$phone_arr[] = $empty_array;
					}
				}

				// when phones are from relative
				if ($ps == 2 && count($phone_arr) != $relative_phone_count) {
					$left_arr = $relative_phone_count - count($phone_arr);

					for ($x = 0; $x < $left_arr; $x++) {
						$phone_arr[] = $empty_array;
					}
				}

				// when phones are from Wrong
				if ($ps == 3 && count($phone_arr) != $wrong_phone_count) {
					$left_arr = $wrong_phone_count - count($phone_arr);
					for ($x = 0; $x < $left_arr; $x++) {
						$phone_arr[] = $empty_array;
					}
				}
				foreach ($phone_arr as $ph_data) :

					// set phone number now
					$col = $col + 1;
					$sheet->setCellValueByColumnAndRow($col, $row, $ph_data[0]); // for phone
					if (!empty($ph_data[3])) :
						$cell_key =  $sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
						$spreadsheet->getActiveSheet()->getStyle($cell_key)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($ph_data[3]);
					endif;

					// set phone type now
					$col = $col + 1;
					$sheet->setCellValueByColumnAndRow($col, $row, $ph_data[1]);
					if (!empty($ph_data[3])) :
						$cell_key =  $sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
						$spreadsheet->getActiveSheet()->getStyle($cell_key)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($ph_data[3]);
					endif;

					// set phone name or relative now
					$col = $col + 1;
					$sheet->setCellValueByColumnAndRow($col, $row, $ph_data[2]);
					if (!empty($ph_data[3])) :
						$cell_key =  $sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
						$spreadsheet->getActiveSheet()->getStyle($cell_key)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($ph_data[3]);
					endif;

				endforeach;
			endforeach;
			$row++;
		endforeach;

		$extension = 'Xlsx';
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, $extension);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"fileName.{$extension}\"");
		$writer->save('php://output');
		die(); */
	}
	
	//filter query
	public function filter_query($where = [])
	{
	if(count($_GET)){
		$db = db_connect();
		$fields = $db->getFieldNames($this->default_table);
		foreach($_GET as $key => $value)
		{
			if(!in_array($key,$fields)){ continue; }
			$value = strip_tags($value);
			if($key <> "from" && $key <> "to")
			{
				if($key == "title")
				{
					$value = trim($value);
					if($value <> "")
					{
						$value = $db->escapeLikeString($value);
						$where[] = "  $key LIKE '%$value%'   ";
					}
				}
				else
				{
					if($value <> "")
					{
					  $sub_cat = ""; 
					/*   if($key == 'id'){
						 $sub_cat = " or parent_id = $value"; 
					 } */
					 $value = $db->escape($value);
					 $where[] = "  $key = $value";
					}
				}
			}
		}
	}
	return $where; 
	}
	
	
	// function to upload multiple images 
	public function fileUpload(){
		$error=array();
        //$extension=array("jpeg","jpg","png","gif");
		$ids = [];
		foreach($_FILES as $file) {
			$file_name=$file["name"];
			$name=time().$file["name"];
			$file_tmp=$file["tmp_name"];
			$ext=pathinfo($file_name,PATHINFO_EXTENSION);
			if(move_uploaded_file($file_tmp=$file["tmp_name"],"uploads/".$name)){
				$data = array
					(
						'name' => $name,
						'original_name' => $file_name,
						'used' => 1,
					);
				$insert_id = $this->common_model->InsertTableData(MEDIA_TABLE,$data);
				 $json['id'] = $insert_id;
				 $json['name'] = $name;
				 echo json_encode($json);
					if( !empty($json))
					{
						  //echo json_encode(array('status' => $file_name , 'id' =>  $id)); 
					}
					else
					{
					//	echo json_encode(array('status' => 'error' , 'id' =>  $id));
					}
				 die();
				
			}
		}
	        //$media_id = implode(',',$ids);
		  die();  
	}
	public function delete_image($id){
	$page_data = [];
	$deleteID = $this->common_model->DeleteTableData(MEDIA_TABLE, array('id' => $id));
    echo json_encode($deleteID);
	die();
}
} 
