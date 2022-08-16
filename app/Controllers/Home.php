<?php

namespace App\Controllers;

use App\Models\Common;

class Home extends BaseController
{
    public function __construct()
    {
        $this->common_model = new Common();
        $this->db =  \Config\Database::connect();
    }

    public function index()
    {
        if(empty(session()->get('lang'))):
            session()->set('lang','de');
        endif;
        
        $page_data = [];
		$user_id = session()->get('user_id');
		$page_data['user_id'] = $user_id;
        $adventures = $this->common_model->GetTableRows(ADVENTURES_TABLE, array('status' => 1), array('id', 'desc'), 3);
        $page_data['adventures'] = $adventures;
        $page_data['modal'] = $this->common_model;
        echo view('front/index', $page_data);
    }

    public function login()
    {

        /* if(isUserLoggedIn()):
            return redirect()->to('user/dashboard');
            die();
        endif;  */
        $page_data = [];
        if ($this->request->getVar('s')) :

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $rules = [
                'email' => ['label' => 'E-mail', 'rules' => 'required|valid_email'],
                'password' => ['label' => 'Password', 'rules' => 'required']
            ];

            if ($this->validate($rules)) {
                $common = new Common();
                $table = USERS_TABLE;
                $result = $common->GetSingleRow($table, array('email' => $email, 'password' => MD5($password)));
                if ($result) {

                    $sess_array = array('user_id' => $result['id'], 'username' => $result['name']);
                    $this->session->set($sess_array);
                    return redirect()->to('user/dashboard');
                } else {

                    $this->session->setFlashdata('flash_message', 'Invalid Username or Password.');
                    $this->session->setFlashdata('class', 'danger');
                }
            } else {
                $page_data["errors"] = $this->validator->getErrors();
            }
        endif;

        echo view('front/login', $page_data);
    }


    public function forgot_password()
    {
        $page_data = [];
        if ($this->request->getVar('s')) :
            $email = $this->request->getPost('email');
            $rules = [
                'email' => ['label' => 'E-mail', 'rules' => 'required|valid_email'],
            ];

            if ($this->validate($rules)) {
                $result = $this->common_model->GetSingleRow(USERS_TABLE, array('email' => $email));
                if ($result) {
                    $activation_key = md5($email) . rand(10, 9999);
                    $link = base_url('change-password?change-password=true&key=' . $activation_key);
					//for user 
					$subject = 'Password Reset Request';
					$page_data['name'] = 'Hello '.$result['name'];
					$page_data['user_name'] = $result['name'];
					$page_data['user_type'] = 'user';
					$page_data['link'] = $link;
					$page_data['email'] = $email;
					$email_template =  view('front/email/email', $page_data);
					$send_to_users = $this->common_model->SendEmail($email,FROM_EMAIL, $subject, $email_template);
                    $update_id = $this->common_model->UpdateTableData(USERS_TABLE, array('activation_key' => $activation_key), array('email' => $email));
					if($update_id){
						 $this->session->setFlashdata('flash_message', 'Reset password link has been sent to your registered e-mail address.');
						 $this->session->setFlashdata('class', 'success');
						 return redirect()->to('login');
					}
					
                } else {
                    $this->session->setFlashdata('flash_message', 'Invalid Username.');
                    $this->session->setFlashdata('class', 'danger');
                }
            } else {
                $page_data["errors"] = $this->validator->getErrors();
            }
        endif;

        echo view('front/login', $page_data);
    }
    public function change_password()
    {
        $page_data = [];
        $activation_key = $this->request->getVar('key');
        if (!empty($activation_key)) {
            $result = $this->common_model->GetSingleRow(USERS_TABLE, array('activation_key' => $activation_key));
            if (!empty(!$result)) {
                return redirect()->to('/');
            }
        }
        if ($this->request->getVar('s')) :
            $new_password = $this->request->getPost('new_password');
            $confirm_password = $this->request->getPost('confirm_password');
            $rules = [
                'new_password' => ['label' => 'Password', 'rules' => 'required'],
                'confirm_password' => ['label' => 'Confirm Password', 'rules' => 'required']
            ];
            if ($this->validate($rules)) {
				if ($_POST["new_password"] === $_POST["confirm_password"]) {
					$update_id = $this->common_model->UpdateTableData(USERS_TABLE, array('password' => MD5($new_password),'activation_key' => ''), array('activation_key' => $activation_key));
					if ($update_id) {
						$this->session->setFlashdata('flash_message', 'Password Changed Succeccfully.');
						$this->session->setFlashdata('class', 'success');
						return redirect()->to('login');
					} else {

						$this->session->setFlashdata('flash_message', 'Something went wrong please try again.');
						$this->session->setFlashdata('class', 'danger');
					}
				}else{
					$this->session->setFlashdata('flash_message', " New password does't match the confirm password.");
					$this->session->setFlashdata('class', 'danger');
				}
            } else {

                $page_data["errors"] = $this->validator->getErrors();
            }
        endif;
        $page_data["activation_key"] = $activation_key;
        echo view('front/change_password', $page_data);
    }

    public function register()
    {
        $page_data = [];
        if ($this->request->getVar('s')) :
            $name = $this->request->getPost('name', FILTER_UNSAFE_RAW);
            $email = $this->request->getPost('email', FILTER_UNSAFE_RAW);
            $password = $this->request->getPost('password');
            $gender = $this->request->getPost('gender');
            $dob = $this->request->getPost('dob', FILTER_UNSAFE_RAW);
            if (!empty($dob)) {
                $dob = strtotime($dob);
            }
            $rules = [
                'name' => ['label' => 'Name', 'rules' => 'trim|required'],
                'email' => ['label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[tbl_users.email]'],
                'password' => ['label' => 'Password', 'rules' => 'required'],
                'dob' => ['label' => 'Date Of Birth', 'rules' => 'trim|required'],
                'gender' => ['label' => 'Gender', 'rules' => 'required'],
            ];

            if ($this->validate($rules)) :
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => MD5($password),
                    'dob' => $dob,
                    'gender' => $gender,
                    'updated_at' => time(),
					'created_at' => time()
                ];

                $insert_id = $this->common_model->InsertTableData(USERS_TABLE, $data);
                if ($insert_id) {
					$subject = 'New Registration';
					$message = 'New account created successfully.';
					
					//for user 
					$page_data['name'] = 'Hello '.$name;
					$page_data['user_name'] = $name;
					$page_data['user_type'] = 'user';
					$page_data['email'] = $email;
					$page_data['msg'] = 'Thank you for the prompt payment on your account.';
					$user_email_template =  view('front/email/new_registration', $page_data);
					$send_to_users = $this->common_model->SendEmail($email,FROM_EMAIL, $subject, $user_email_template);
					
/* 					
					echo "<pre>";
					print_r($user_email_template);
					die('dsasa'); */
					
					//for admin 
					$subject = 'A new user has registered';
					$page_data['user_type'] = 'admin';
					$page_data['name'] = 'Dear Admin';
					$admin_email_template =  view('front/email/new_registration', $page_data);
					$send_to_admin = $this->common_model->SendEmail(ADMIN_EMAIL,FROM_EMAIL, $subject, $admin_email_template);
				
                    $this->session->setFlashdata('flash_message', 'You have registered successfully, please login to access your account.');
                    $this->session->setFlashdata('class', 'success');
                    return redirect()->to('login');
                } else {
                    $this->session->setFlashdata('flash_message', 'Something is went wrong please try again.');
                    $this->session->setFlashdata('class', 'danger');
                }

            else :
                $page_data["errors"] = $this->validator->getErrors();
            endif;

        endif;

        echo view('front/register', $page_data);
    }


    public function about()
    {
        $page_data = [];
        echo view('front/about', $page_data);
    }

    public function faqs()
    {
        $page_data = [];
        echo view('front/faqs', $page_data);
    }
	
	public function privacy_policy()
    {
        $page_data = [];
        echo view('front/privacy_policy', $page_data);
    }
	
	public function term_condition()
    {
        $page_data = [];
        echo view('front/term_condition', $page_data);
    }
	
    public function how_it_works()
    {
        $page_data = [];
        echo view('front/how_it_works', $page_data);
    }
    public function contact()
    {
        $page_data = [];
        echo view('front/contact', $page_data);
    }
    public function adventures()
    {
        $user_id = session()->get('id');
        $page_data = [];
       // $where = [];
		$where[] = "status = '1'";
		//filter
       $where = $this->filter_query($where);
       $where = implode(' AND ', $where);
		//pagination
       $per_page = 6;
       $offset = (int)$this->request->getVar('page') ? ($this->request->getVar('page')-1)*$per_page : 0;
       $total = $this->common_model->GetTotalCount(ADVENTURES_TABLE,$where);
       $adventures = $this->common_model->GetTableRows(ADVENTURES_TABLE,$where,'',$per_page,$offset);
	  // $adventures = $this->common_model->GetTableRows(ADVENTURES_TABLE, array('status' => 1), array('id', 'desc'), 3);
       $pagination = false;
       if($per_page < $total):
          $pager = \Config\Services::pager();
          $pagination = $pager->makeLinks($offset, $per_page, $total,'admin'); 
      endif;  
        $page_data['pagination'] = $pagination;
        $page_data['model'] = $this->common_model;
        $page_data['adventures'] = $adventures;
        $page_data['modal'] = $this->common_model;
        echo view('front/adventures', $page_data);
    }
        //filter query
		public function filter_query($where = [])
		{
			if(count($_GET)){
				$db = db_connect();
				$fields = $db->getFieldNames(ADVENTURES_TABLE);
				foreach($_GET as $key => $value){
					if(!in_array($key,$fields)){ continue; }
					$value = strip_tags($value);
					if($key <> "from" && $key <> "to")
					{
						if($key == "name")
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
								$value = $db->escape($value);
								$where[] = "  $key = $value";
							}
						}
					}
				}
			}
		 return $where; 
		}
    public function adventure($id)
    {
        $page_data = [];
        $adventure = $this->common_model->GetSingleRow(ADVENTURES_TABLE, array('id' => $id, 'status' => 1));

        $other_adventures =  $this->common_model->GetTableRows(ADVENTURES_TABLE, array('status' => 1, 'id <> ' => $adventure['id'], 'level' => $adventure['level']));

        $page_data['adventure'] = $adventure;
        $page_data['other_adventures'] = $other_adventures;
        $page_data['modal'] = $this->common_model;
        echo view('front/adventure', $page_data);
    }

    public function challenge($id = 33)
    {
        $page_data = [];
        $challenge = $this->common_model->GetSingleRow(CHALLENGES_TABLE, array('id' => $id, 'status' => 1));
        $page_data['challenge'] = $challenge;
        $page_data['modal'] = $this->common_model;
        echo view('front/challenge', $page_data);
    }

    public function adventureComplete()
    {
        $page_data = [];
        echo view('front/account/adventure-complete', $page_data);
    }

    public function add_contact_form(){
        $page_data = [];
        if($this->request->getPost('s')){
        $name = $this->request->getPost('name', FILTER_UNSAFE_RAW);
        $email = $this->request->getPost('email', FILTER_UNSAFE_RAW);
        $message = $this->request->getPost('message', FILTER_UNSAFE_RAW);

        if (empty($name)) {
            $json_data['field_error_name'] = 'name';
        } 
		if (empty($email)) {
            $json_data['field_error_email'] = 'email';
        } 
		if (empty($message)) {
            $json_data['field_error_message'] = 'message';
        }

        if (!empty($name) && !empty($email) && !empty($message)) :
            $data = [
                'name' => $name,
                'email' => $email,
                'message' => $message,
            ];
            $insert_id = $this->common_model->InsertTableData(INQUIRY_TABLE, $data);
			//send email
			
		    $subject = 'Contact Us Enquiry';
			$name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
			$message = "Dear Admin, <br> You have received new contact us enquiry.  <br>Name: ". $name . "<br> Email: " . $email . "<br> Message: " . "\n\n" . $_POST['message'];
			 /* print_r($message);
			 die("rr"); */
            $send_to_users = $this->common_model->SendEmail(ADMIN_EMAIL,FROM_EMAIL, $subject,$message); 
			

           $json_data['status'] = 'success';
    			$json_data['insert_id'] = $insert_id;
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
