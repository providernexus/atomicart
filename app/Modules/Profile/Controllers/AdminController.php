<?php

namespace Modules\Profile\Controllers;

use App\Controllers\BaseController;
use App\Models\Common;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->common_model = new Common();
        $this->module = "Manage profile";
        $this->mr = "profile"; // Module route
        $this->fp = '\Modules\Profile\Views';
        $this->default_table = ADMIN_TABLE;

    }
    public function index()
    {
        $id = session()->get('admin_id');
        $page_data = $this->common_model->GetSingleRow($this->default_table,array('id'=>$id));

		if(!empty($page_data)):
		
			if($this->request->getVar('s')):
                $name = $this->request->getVar('name', FILTER_UNSAFE_RAW);
                $email = $this->request->getVar('email', FILTER_UNSAFE_RAW);
                $password = $this->request->getVar('password', FILTER_UNSAFE_RAW);
                $media_id = $this->request->getVar('file');
                $rules = [ 
                        'name' => ['label' => 'Name', 'rules' => 'required'],
                        'email' => ['label' => 'Email', 'rules' => 'required'],
                    ];
                if ($this->validate($rules)) 
                {
                    $data = array(
                        'name' => $name,
                        'email' => $email,
                        'media_id' => $media_id,
                    );
                    if(!empty($password)):
                        $data['password']=md5($password);
                    endif;
                    
                    
                    $update_id = $this->common_model->UpdateTableData($this->default_table,$data,array('id'=>$id));
                    if($update_id)
                    {
                        $this->session->setFlashdata('flash_message',lang('t.Profil erfolgreich aktualisiert.'));
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
                $page_data['module'] = $this->module;
                return view($this->fp."/index", $page_data);
        else:
            $this->session->setFlashdata('flash_message','Data not exist.');
            $this->session->setFlashdata('class','danger');
            return redirect()->to('admin/'.$this->mr);
        endif;
    }
}
