<?php

namespace Modules\Media\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage Media";
        $this->mr = "media"; // Module route
        $this->fp = '\Modules\Media\Views';
        $this->default_table = ADVENTURES_TABLE;

    }
    public function index(){
		$page_data = [];
		$attachment_ids = [];
		$single_gallery = [];
		$image = [];
    if($this->request->getVar('s')):
        $avtar_file = $this->request->getVar('avtar_file', FILTER_UNSAFE_RAW);
        $gallery = $this->request->getVar('gallery', FILTER_UNSAFE_RAW);
        $attachment_ids = $this->request->getVar('attachment_ids');
			$rules = [ 
				'attachment_ids[]' => ['label' => 'attachment_ids', 'rules' => 'required'],
			];
			
			if ($this->validate($rules)) 
			{
				$str = implode(',',$attachment_ids);
				$data = array(
					'gallery' => $str, 
					'created_at' => time(),
					'updated_at' => time(),
				);
				
				//if avtar file gets upload
				if($avtar_file)
				{
				   $data['media_id'] = $avtar_file;
				}
					$insert = $this->common_model->InsertTableData($this->default_table,$data);
				
			   if($insert)
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
			}
			else
			{
				$page_data["errors"] = $this->validator->getErrors();
			}
		endif; 
	
		$media_img = $this->common_model->GetTableRows(MEDIA_TABLE);
		$page_data['media_img'] = $media_img;
		$page_data['module'] = lang('Text.media.manage_media_gallery');
		$page_data['model'] = $this->common_model;
		$page_data['mr'] = $this->mr;
		return view($this->fp."/gallery", $page_data);

	}


	public function delete($id){
		$page_data = [];
		$deleteID = $this->common_model->DeleteTableData(MEDIA_TABLE, array('id' => $id));
		$page_data['deleteID'] = $deleteID;
		return view($this->fp."/gallery", $page_data);
	}

     // function to upload multiple images 
	  public function fileUpload(){
		$error = array();
        $extension = array("jpeg","jpg","png","gif");
		$ids = [];
		foreach($_FILES as $file) {
			$file_name=$file["name"];
			$name=time().$file["name"];
			$file_tmp=$file["tmp_name"];
			$ext=pathinfo($file_name,PATHINFO_EXTENSION);
			if(move_uploaded_file($file_tmp=$file["tmp_name"],"uploads/".$name)){
				$data = array(
						'name' => $name,
						'original_name' => $file_name,
						'used' => 1,
					);
					
				$insert_id = $this->common_model->InsertTableData(MEDIA_TABLE,$data);
				 $id = $insert_id;
				 echo json_encode($id);
					if( !empty($id))
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
	
	//change status
	public function changeStatus()
	{
	  if($this->request->getPost('id'))
	    {
		    $id = $this->request->getPost('id',FILTER_SANITIZE_NUMBER_INT);
		    $status = $this->request->getPost('status',FILTER_UNSAFE_RAW);
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
	
	//for remove image 
		public function removeImage()
		{
		  if($this->request->getPost('id')){
			 $id = $this->request->getPost('id',FILTER_SANITIZE_NUMBER_INT);
			 $media_name = $this->common_model->GetSinglevalue(MEDIA_TABLE,'name',array('id'=>$id));
			 $path = FCPATH.'/uploads/'.$media_name;
			 if(file_exists($path)):
				$file = FCPATH.'/uploads/'.$media_name;;
				$newfile = FCPATH.'/recycle/'.$media_name;
				if (copy($file, $newfile) ) {
					$deleteID = $this->common_model->DeleteTableData(MEDIA_TABLE, array('id' => $id));
					if(unlink($path)):
					  $json_data['status'] = 'success';
					endif;
				} else {
					 $json_data['status'] = 'error';
				}
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
