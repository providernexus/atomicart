<?php

namespace Modules\Customers\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController
{

	public $common_model = '';
	public function __construct()
	{
		$this->common_model = new Common();
		$this->module = "Manage Customers";
		$this->fp = '\Modules\Customers\Views';
		$this->default_table = CUSTOMERS_TABLE;
        $this->mr = "customers"; // Module route
        
    }

    public function index()
    {
    	$permissions = all_permissions();

    	if(!have_permission('view_customers')){ return redirect()->to('admin/dashboard'); }

    	$page_data = [];
    	$where = array();
    	$where = $this->filter_query($where);
    	$where = implode(' AND ', $where);

		
    	$per_page = PER_PAGE_LIMIT;
    	$offset = (int)$this->request->getVar('page') ? ($this->request->getVar('page')-1)*$per_page : 0;
    	$total = $this->common_model->GetTotalCount($this->default_table,$where);
    	$data = $this->common_model->GetTableRows($this->default_table,$where,'',$per_page,$offset);

    	$pagination = false;
    	if($per_page < $total):
    		$pager = \Config\Services::pager();
    		$pagination = $pager->makeLinks($offset, $per_page, $total,'admin'); 
    	endif;  

		
		//$customers_name = $this->common_model->SelectDropdown(CUSTOMERS_TABLE, 'name', 'id', array($this->request->getVar('id')));

    	$page_data['results'] = $data;
    //	$page_data['customers_name'] = $customers_name;
    	$page_data['module'] = lang('Text.customer.manage_customers');
    	$page_data['model'] = $this->common_model;
    	$page_data['pagination'] = $pagination;
    	$page_data['permissions'] = $permissions;
    	$page_data['mr'] = $this->mr;
    	return view($this->fp."\index", $page_data);
    }

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
    				if($key == "name")
    				{
    					$value = trim($value);
    					if($value <> ""){
    						$value = $db->escapeLikeString($value);
    						$where[] = "  $key LIKE '%$value%'   ";
    					}
    				}
    				else
    				{
    					if($value <> "")
    					{
    						$value = $db->escape($value);
    						$where[] = "  $key = $value   ";
    					}
    				}
    			}
    		}

    	}
    	return $where; 
    }

    public function add()
    {

    	$permissions = all_permissions();

    	if(!have_permission('add_customer')){ return redirect()->to('admin/dashboard'); }
    	$page_data = [];
		//on submitting 
    	if($this->request->getVar('s')):
    		$name = $this->request->getPost('name',FILTER_UNSAFE_RAW);
    		$email = $this->request->getPost('email',FILTER_UNSAFE_RAW);
    		$phone = $this->request->getPost('phone',FILTER_UNSAFE_RAW);
    		$password = $this->request->getPost('password',FILTER_UNSAFE_RAW);
    		$gender = $this->request->getPost('gender',FILTER_UNSAFE_RAW);
    		$dob = $this->request->getPost('dob',FILTER_UNSAFE_RAW);
    		if(!empty($dob)){
    			$dob = strtotime($dob);
    		}

    		$rules = [ 
    			'name' => ['label' => 'Name', 'rules' => 'trim|required'],
    			'email' => ['label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique['.CUSTOMERS_TABLE.'.email]'],
    			'password' => ['label' => 'Password', 'rules' => 'trim|required'],
    		];
    		if($this->validate($rules)):
    			$data = [
    				'name' => $name,
    				'email' => $email,
    				'phone' => $phone,
    				'password' => md5($password),
    				'gender' => $gender,
    				'dob' => $dob,
    				'active' => 1,
    				'created_at' => time(),
    				'updated_at' => time()
    			];
    			$insert_id = $this->common_model->InsertTableData($this->default_table,$data);
    			if($insert_id)
    			{
    				$this->session->setFlashdata('flash_message',lang('t.data-successfully-added'));
    				$this->session->setFlashdata('class','success');
    				return redirect()->to('admin/'.$this->mr);
    			}
    			else
    			{
    				$this->session->setFlashdata('flash_message',lang('t.something-is-went-wrong-please-try-again'));
    				$this->session->setFlashdata('class','danger');
    			}
    		else:
    			$page_data["errors"] = $this->validator->getErrors();
    		endif;

    	endif;
    	$page_data['module'] = lang('Text.customer.manage_customer_add');
    	$page_data['mr'] = $this->mr;
    	$page_data['permissions'] = $permissions;

    	return view($this->fp.'/add',$page_data);
    }

	// update
    public function edit($id)
    {	
    	if(!have_permission('edit_customer')){ return redirect()->to('admin/dashboard'); }
    	$page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));
    	if(!empty($page_data)):
			//get profile picture
    		if(!empty($page_data['media_id'])):
    			$file_name = $this->common_model->GetSingleValue(MEDIA_TABLE,('name'),array('id'=>$page_data['media_id']));
				//profile
    			if(!empty($file_name)):
    				if(file_exists(FCPATH."uploads/".$file_name)):
    					$profile_pic_src = base_url('/uploads/'.$file_name.'');
    					$page_data['profile_pic_src'] = $profile_pic_src;
    				endif; 
    			endif;
    		endif;

			//on submitting 
    		if($this->request->getVar('s')):
    			$name = $this->request->getPost('name',FILTER_UNSAFE_RAW);
    			$email = $this->request->getPost('email',FILTER_UNSAFE_RAW);
    			$phone = $this->request->getPost('phone',FILTER_SANITIZE_NUMBER_INT);
    			$password = $this->request->getPost('password',FILTER_UNSAFE_RAW);
    			if($email != $page_data['email']) {
    				$is_unique =  '|is_unique['.CUSTOMERS_TABLE.'.email]';
    			} else {
    				$is_unique =  '';
    			}

    			$gender = $this->request->getPost('gender',FILTER_UNSAFE_RAW);
    			$dob = $this->request->getPost('dob',FILTER_UNSAFE_RAW);
    			if(!empty($dob)){
    				$dob = strtotime($dob);
    			}


    			$rules = [ 
    				'name' => ['label' => 'Name', 'rules' => 'trim|required'],
    				'email' => ['label' => 'Email', 'rules' => 'trim|required|valid_email'.$is_unique],
						//'phone' => ['label' => 'Phone', 'rules' => 'trim|required|numeric'],
    			];

    			if($this->validate($rules)):
    				$data = [
    					'name' => $name,
    					'email' => $email,
    					'phone' => $phone,
    					'gender' => $gender,
    					'dob' => $dob,
    					'updated_at' => time()
    				];
    				if(!empty($password)){
    					$data['password']  = md5($password);
    				}
    				$update_id = $this->common_model->UpdateTableData($this->default_table,$data,array('id'=>$id));
    				if($update_id)
    				{
    					$this->session->setFlashdata('flash_message',lang('t.data-successfully-updated'));
    					$this->session->setFlashdata('class','success');
    					return redirect()->to('admin/'.$this->mr);
    				}
    				else
    				{
    					$this->session->setFlashdata('flash_message',lang('t.something-is-went-wrong-please-try-again'));
    					$this->session->setFlashdata('class','danger');
    				}
    			else:
    				$page_data["errors"] = $this->validator->getErrors();
    			endif;

    		endif;
    		$page_data['module'] = lang('Text.customer.manage_customer_edit');
    		$page_data['mr'] = $this->mr;
    		return view($this->fp.'/edit',$page_data);
    	else:
    		$this->session->setFlashdata('flash_message','No data exist related.');
    		$this->session->setFlashdata('class','danger');
    		return redirect()->to('admin/'.$this->mr);
    	endif;
    }

	//Delete user
    public function delete()
    {
    	if(!have_permission('delete_customer')){ return redirect()->to('admin/dashboard'); }
    	if($this->request->isAJAX()){
    		if(!empty($this->request->getPost('id'))):
    			$id = $this->request->getPost('id',FILTER_SANITIZE_NUMBER_INT);

    			$row = $this->common_model->GetSingleRow($this->default_table,array('id' => $id));

    			$delete = $this->common_model->DeleteTableData($this->default_table,array('id'=>$id));
    			if($delete):
    				$data = array
    				(
    					'tbl' => $this->default_table,
    					'data' => serialize($row),
    					'created_at'=> time(),
    				);
    				$this->common_model->InsertTableData('tbl_deleted_data',$data);
    				$json_data['status'] = 'success';
    			else:
    				$json_data['status'] = 'error';
    			endif;
    		else:
    			$json_data['status'] = 'error';
    		endif;
    	}
    	else
    	{
    		$json_data['status'] = 'error';
    	}
    	echo json_encode($json_data);
    	die();
    }


	//change status
    public function changeStatus()
    {
		
    	//if(!have_permission('change_status_customer')){ return redirect()->to('admin/dashboard'); }
    	if($this->request->getPost('id'))
    	{
    		$id = $this->request->getPost('id',FILTER_SANITIZE_NUMBER_INT);
    		$active = $this->request->getPost('active',FILTER_UNSAFE_RAW);

    		$update_id = $this->common_model->UpdateTableData($this->default_table,array('active'=>$active),array('id'=>$id));

    		if(!empty($update_id)):
    			$status_value = $this->common_model->GetSinglevalue($this->default_table,'active',array('id'=>$id));
    			$json_data['status'] = 'success';
    			$json_data['status_value'] = $status_value;
    		else:
    			$json_data['status'] = 'error';
    		endif;
    	}
    	else
    	{
    		$json_data['status'] = 'error';
    	}
    	echo json_encode($json_data);
    	die();
    }
}
