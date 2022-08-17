<?php

namespace Modules\Event\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;
//die('asass');
class AdminController extends BaseController
{

	public $common_model = '';
	public function __construct()
	{
		$this->common_model = new Common();
		$this->module = "Manage Event";
		$this->fp = '\Modules\Event\Views';
		$this->default_table = TABLE_EVENTS;
        $this->mr = "event"; // Module route
    }

    public function index()
    {
    	
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
		
		
		
		
		
    	$page_data['results'] = $data;
    	$page_data['module'] = 'Manage Events';
    	$page_data['modal'] = $this->common_model;
    	$page_data['pagination'] = $pagination;

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
    				if($key == "title")
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
	
	   //get employee data 
		public function getChallenges()
		{
			$option = '<option value="">--Select Challenge--</option>';
			if($this->request->getPost('adventure_id'))
			{
				
				$adventure_id = $this->request->getPost('adventure_id',FILTER_SANITIZE_NUMBER_INT);
				if(!empty($adventure_id)):
				  $where = 'adventure_id = '.$adventure_id.' and status = 1';
				  $challenges = $this->common_model->SelectDropdown(CHALLENGES_TABLE,'name','id','',$where);
				  $json_data['status'] = 'success';
				  $json_data['html'] = $option.$challenges;
				else:
					$json_data['status'] = 'error';
				endif;
			}
			else
			{
				$json_data['status'] = 'error';
				$json_data['html'] = $option;
			}
			echo json_encode($json_data);
			die();
		}
    public function add()
	{
		$page_data = [];
		//on submitting 
    	if($this->request->getVar('s')):
		    $image = 0;
 
    		$description = $this->request->getPost('description',FILTER_UNSAFE_RAW);
    		$title = $this->request->getPost('title',FILTER_UNSAFE_RAW);
			$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_NUMBER_INT);
			$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_NUMBER_INT);
    		$rules = [ 
    			'description' => ['label' => 'Description', 'rules' => 'trim|required'],
    			'title' => ['label' => 'Title', 'rules' => 'trim|required'],
    		];
		 	if($this->request->getPost('image',FILTER_SANITIZE_NUMBER_INT) > 0):
			  $image = $this->request->getPost('image',FILTER_SANITIZE_NUMBER_INT);
			endif; 
			 
    		if($this->validate($rules)):
    			$data = [
    				'title' => $title,
					'description' => $description,
    				'image' => $image,
    				'start_date' => $start_date,
    				'end_date' => $end_date,
					'created_at' => time(),
					'updated_at' => time(),
					];
    			$insert_id = $this->common_model->InsertTableData($this->default_table,$data);
    			if($insert_id){
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
	//	$parent_id = $this->common_model->SelectDropdown($this->default_table,'title','id', array($this->request->getVar('parent_id')),array('status' => 1));
		$media_img = $this->common_model->GetTableRows(MEDIA_TABLE);
		
		$page_data['media_img'] = $media_img;
   // 	$page_data['parent_id'] = $parent_id;
    	$page_data['module'] = 'Manage Events: Add';
    	$page_data['mr'] = $this->mr;
		$page_data['model'] = $this->common_model;
    	
    	return view($this->fp.'/add',$page_data);
    }

	// function to upload multiple images 
 	public function imgUpload(){
		$error=array();
        $extension = array("jpeg","jpg","png","gif");
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
				$ids[] = $insert_id;
			}
		}
	        $media_id = implode(',',$ids);
		    $media_id = $media_id;
			if( !empty($media_id))
			{
				  echo json_encode(array('status' => 'success' , 'media_id' =>  $media_id)); 
			}
			else
			{
				echo json_encode(array('status' => 'error' , 'media_id' =>  $media_id,));
			}
		 die();
	} 
	
	public function edit($id)
	{
	//die('sa');
	  $adventure_id = [];
	  $page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));
		
	  if(!$page_data){
			$this->session->setFlashdata('flash_message','Invalid data.');
			$this->session->setFlashdata('class','danger');
			return redirect()->to('admin/'.$this->mr);
		}
	if($this->request->getVar('s')):

		
		$description = $this->request->getPost('description',FILTER_UNSAFE_RAW);
	    $title = $this->request->getPost('title',FILTER_UNSAFE_RAW);
		$parent_id = $this->request->getPost('parent_id',FILTER_SANITIZE_NUMBER_INT);

		$image = $this->request->getPost('image',FILTER_UNSAFE_RAW); 
	  
	   $rules = [ 
			'description' => ['label' => 'Description', 'rules' => 'trim|required'],
			'title' => ['label' => 'Title', 'rules' => 'trim|required'],
			
	];
	if ($this->validate($rules)) 
	{
		$data = array(
			'description' => $description,
			'title' => $title,
			'image' => $image,
			'updated_at' => time(),
		);
		
	   $update_id = $this->common_model->UpdateTableData($this->default_table,$data,array('id'=>$id));
	   if($update_id)
	   {
		$this->session->setFlashdata('flash_message','Data successfully updated');
		$this->session->setFlashdata('class','success');
		return redirect()->to('admin/'.$this->mr);
	}
	else
	{
		$this->session->setFlashdata('flash_message',lang('t.something-is-went-wrong-please-try-again'));
		$this->session->setFlashdata('class','danger');
	}
	}
	else
	{
		$page_data["errors"] = $this->validator->getErrors();
	}
	endif;
	
	//$parent_id = $this->common_model->SelectDropdown($this->default_table,'title','id', array($page_data['parent_id']),array('status' => 1));
	$media_img = $this->common_model->GetTableRows(MEDIA_TABLE);

	$page_data['media_img'] = $media_img;
//	$page_data['parent_id'] = $parent_id;
	$page_data['module'] = 'Manage Events: Edit';
	$page_data['mr'] = $this->mr;
	$page_data['model'] = $this->common_model;
	return view($this->fp."/edit", $page_data);
	}

     public function clone($id)
	{
	  $adventure_id = [];
	  $page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));
		  if(!$page_data){
				$this->session->setFlashdata('flash_message','Invalid data.');
				$this->session->setFlashdata('class','danger');
				return redirect()->to('admin/'.$this->mr);
			}
			$data = array(
				'description' => $page_data['description'],
				'title' => $page_data['title'],
				'parent_id' => $page_data['parent_id'],
				'status' => $page_data['status'],
				'image' => $page_data['image'],
				'created_at' => time(),
				'updated_at' => time(),
			);
		   $insert_id = $this->common_model->InsertTableData($this->default_table,$data);
		   if($insert_id)
		   {
			$this->session->setFlashdata('flash_message',lang('t.Daten erfolgreich geklont.'));
			$this->session->setFlashdata('class','success');
			return redirect()->to('admin/'.$this->mr.'/edit/'.$insert_id);
		   }else{
				$this->session->setFlashdata('flash_message',lang('t.something-is-went-wrong-please-try-again'));
			   $this->session->setFlashdata('class','danger');
				return redirect()->to('admin/'.$this->mr);
		   }
	
	}
	//Delete user
    public function delete()
    {
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
	//change status
    public function changeStatus()
    {
		//die('sd');
    	//if(!have_permission('change_status_challenges')){ return redirect()->to('admin/dashboard'); }
    	if($this->request->getPost('id'))
    	{
    		$id = $this->request->getPost('id',FILTER_SANITIZE_NUMBER_INT);
    		$status = $this->request->getPost('status',FILTER_SANITIZE_NUMBER_INT);

    		$update_id = $this->common_model->UpdateTableData($this->default_table,array('status'=>$status),array('id'=>$id));

    		if(!empty($update_id)):
    			$status_value = $this->common_model->GetSinglevalue($this->default_table,'status',array('id'=>$id));
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
