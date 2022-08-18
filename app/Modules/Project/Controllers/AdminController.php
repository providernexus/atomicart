<?php
namespace Modules\Project\Controllers;
use App\Controllers\BaseController;
use App\Models\Common;
//die('asass');
class AdminController extends BaseController
{

	public $common_model = '';
	public function __construct()
	{
		$this->common_model = new Common();
		$this->module = "Manage Project";
		$this->fp ='\Modules\Project\Views';
		$this->default_table = TABLE_PROJECT;
        $this->mr = "project"; // Module route
    }

    public function index()
    {
	//	die('ad');
    //	$permissions = all_permissions();
    //	if(!have_permission('view_challenges')){ return redirect()->to('admin/dashboard'); }
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
    	$page_data['module'] = 'Manage Project';
    	$page_data['modal'] = $this->common_model;
    	$page_data['pagination'] = $pagination;
   // 	$page_data['permissions'] = $permissions;
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
		$page_data = [];
    //	$permissions = all_permissions();
    	//if(!have_permission('add_challenges')){ return redirect()->to('admin/dashboard'); }
    	$page_data = [];
		//on submitting 
		
    	if($this->request->getVar('s')):
		
		    $image = 0;
    		$title = $this->request->getPost('title',FILTER_UNSAFE_RAW);
    		$director = $this->request->getPost('director',FILTER_UNSAFE_RAW);
    		$studio = $this->request->getPost('studio',FILTER_UNSAFE_RAW);
    		$description = $this->request->getPost('description',FILTER_UNSAFE_RAW);
			$video_url = $this->request->getPost('video_url');
			$file = $this->request->getPost('file');
			
    		$rules = [ 
    			'title' => ['label' => 'Title', 'rules' => 'trim|required'],
    			'director' => ['label' => 'Director', 'rules' => 'trim|required'],
    			'studio' => ['label' => 'Studio', 'rules' => 'trim|required'],
    			'description' => ['label' => 'Description', 'rules' => 'trim|required'],
    		];
		 	if($this->request->getPost('image',FILTER_SANITIZE_NUMBER_INT) > 0):
			  $image = $this->request->getPost('image',FILTER_SANITIZE_NUMBER_INT);
			endif; 
    		if($this->validate($rules)):
    			$data = [
    				'title' => $title,
    				'director' => $director,
    				'studio' => $studio,
    				'description' => $description,
    				'file' => $file,
    				'image' => $image,
					'video_url' => $video_url,
					'created_at' => time(),
					'updated_at' => time(),
    			];
				
				
    			$insert_id = $this->common_model->InsertTableData(TABLE_PROJECT,$data);
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
		$media_img = $this->common_model->GetTableRows(MEDIA_TABLE);
		$page_data['media_img'] = $media_img;
		$page_data['module'] = 'Manage Project: Add';
    	$page_data['mr'] = $this->mr;
		$page_data['model'] = $this->common_model;
    	//$page_data['permissions'] = $permissions;
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
		
	//  $adventure_id = [];
	  $page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));
		
	 	
	  if(!$page_data){
			$this->session->setFlashdata('flash_message','Invalid data.');
			$this->session->setFlashdata('class','danger');
			return redirect()->to('admin/'.$this->mr);
		}
	if($this->request->getVar('s')):

		$title = $this->request->getPost('title',FILTER_UNSAFE_RAW);
		$director = $this->request->getPost('director',FILTER_UNSAFE_RAW);
		$studio = $this->request->getPost('studio',FILTER_UNSAFE_RAW);
		$description = $this->request->getPost('description',FILTER_UNSAFE_RAW);
		$image = $this->request->getPost('image',FILTER_SANITIZE_NUMBER_INT);
		$file = $this->request->getPost('file',FILTER_SANITIZE_NUMBER_INT);
		$video_url = $this->request->getPost('video_url');
	   $rules = [ 
			'title' => ['label' => 'Title', 'rules' => 'trim|required'],
			'director' => ['label' => 'Director', 'rules' => 'trim|required'],
			'studio' => ['label' => 'Studio', 'rules' => 'trim|required'],
			'description' => ['label' => 'Description', 'rules' => 'trim|required'],
	];
	if ($this->validate($rules)) 
	{
		$data = array(
			'title' => $title,
			'director' => $director,
			'studio' => $studio,
			'description' => $description,
			'image' => $image,
			'file' => $file,
			'video_url' => $video_url,
			'created_at' => time(),
			'updated_at' => time(),
			
		);
		
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
	}
	else
	{
		$page_data["errors"] = $this->validator->getErrors();
	}
	endif;
//	$adventure_id = $this->common_model->SelectDropdown(ADVENTURES_TABLE,'name','id', array($page_data['adventure_id']),array('name !=' => ''));
	$media_img = $this->common_model->GetTableRows(MEDIA_TABLE);
	$page_data['media_img'] = $media_img;
//	$page_data['adventure_id'] = $adventure_id; 
	$page_data['module'] = "Manage Project: Edit";
	$page_data['mr'] = $this->mr;
	$page_data['model'] = $this->common_model;
	return view($this->fp."/edit", $page_data);
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
    		$id = $this->request->getPost('id',FILTER_SANITIZE_STRING);
    		$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);

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
