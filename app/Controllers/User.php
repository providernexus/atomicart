<?php

namespace App\Controllers;

use angelleye\PayPal\PayPal;
use App\Models\Common;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class User extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->common_model = new Common();
        $this->default_table = CUSTOMERS_TABLE;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('home');
    }

    public function index()
    {
        $user_id = session()->get('user_id');
        $page_data = [];
        $page_data = $this->common_model->GetSingleRow($this->default_table, array('id' => $user_id));
        echo view('front/account/dashboard', $page_data);
/* 		echo "<pre>";
		print_r($page_data);
		die('as'); */
    }

    public function bookingProfile()
    {
        $page_data['module'] = 'booking_profile';
        echo view('front/account/booking_profile', $page_data);
    }

    public function dashboard()
    {
        //$page_data['module']= 'dashboard';
        $page_data = [];
        echo view('front/account/dashboard', $page_data);
    }

    public function profileHistory()
    {
        //$page_data['module']= 'profile_history';
        $page_data = [];
        echo view('front/account/profile-history', $page_data);
    }

    public function editProfile()
    {
        $user_id = session()->get('user_id');
        $page_data = [];
        $page_data = $this->common_model->GetSingleRow($this->default_table, array('id' => $user_id));
/*        if(empty($page_data)):
			return redirect()->to('user/'.$this->mr);
	   endif; */
        if ($this->request->getVar('s')) :
           /*  $avatar = 'uploads/' . basename($_FILES["file"]["name"]);
            move_uploaded_file($_FILES["file"]["tmp_name"], $avatar); */
            $avatar = $this->request->getPost('avatar');
            $name = $this->request->getPost('name');
		    $gender = $this->request->getPost('gender');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
			$dob = $this->request->getPost('dob',FILTER_SANITIZE_STRING);
			if(!empty($dob)){
    				$dob = strtotime($dob);
    			}
				
            $rules = [
                'name' => ['label' => 'Display Name', 'rules' => 'required'],
                'email' => ['label' => 'E-mail', 'rules' => 'required|valid_email'],
            ];

            if ($this->validate($rules)) :
			
                $data = [
                    'avatar' => $avatar,
                    'name' => $name,
					'dob' => $dob,
					'gender' => $gender,
                    'email' => $email,
                    'updated_at' => time()
                ];
				/* if (isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])) {
                    $data['avatar'] = ($avatar);
                } */
                if (!empty($password)) {
                    $data['password'] = MD5($password);
                }
                /* _p($data);
			die('ds'); */
                $updated = $this->common_model->UpdateTableData(USERS_TABLE, $data, array('id' => $user_id));
                if ($updated) {

                    $this->session->setFlashdata('flash_message', 'Profile have been updated successfully!.');
                    $this->session->setFlashdata('class', 'success');
                    return redirect()->to('user/edit-profile');
                } else {

                    $this->session->setFlashdata('flash_message', 'Something is went wrong please try again.');
                    $this->session->setFlashdata('class', 'danger');
                }

            else :
                $page_data["errors"] = $this->validator->getErrors();
            endif;

        endif;
		
		$page_data['model'] = $this->common_model;			 
        $page_data['module'] = '';
        echo view('front/account/edit-profile', $page_data);
    }
	
	public function upload()
	{
		$insert_id = 0;
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
			  $insert_id = $this->common_model->InsertTableData(MEDIA_TABLE, $data);
			}
		  }
		}
		echo $insert_id;
    }

    public function checkout($id)
    {
        $adventure = $this->common_model->GetSingleRow(ADVENTURES_TABLE, array('id' => $id, 'status' => 1));
        if (!$adventure) :
            return redirect()->to('adventures');
            die();
        endif;
        $adventure_id = $adventure['id'];
        $amount = $adventure['price'];

        $user_id = session()->get('user_id');
        if ($this->request->getVar('s')) :

            $teamcode = random_teamcode();
            $data = [
                'user_id' => $user_id,
                'adventure_id' => $adventure_id,
                'status' => 0,
                'amount' => $amount,
                'teamcode' => $teamcode,
                'created_at' => time(),
                'updated_at' => time(),
            ];

            $insert_id = $this->common_model->InsertTableData(ORDERS_TABLE, $data);
            if ($insert_id) {

                //require_once(FCPATH . '/vendor/angelleye/paypal-php-library/autoload.php');
                $PayPalConfig = array(
                    'Sandbox' => true,
                    'APIUsername' => "namratadhir-facilitator_api1.yahoo.com",
                    'APIPassword' => "SNTFCJH8Q8AXBUZ8",
                    'APISignature' => "AghqUnyUaRTJA1wlaRIfubW-Top8AaAFPkBX4urgnZs8ZcTLk-6SS3U7",
                    'PrintHeaders' => false,
                    'LogResults' => false,
                    'LogPath' => $_SERVER['DOCUMENT_ROOT'] . '/logs/',
                );

                $PayPal = new \angelleye\PayPal\PayPal($PayPalConfig);


                $returnURL = base_url() . '/paypal/payment-success'; //payment success url
                $cancelURL = base_url() . '/paypal/payment-fail'; //payment cancel url
                $notifyURL = base_url() . '/paypal/ipn'; //ipn url

                $SECFields = array(
                    'maxamt' => $amount,
                    'returnurl' => $returnURL,
                    'cancelurl' => $cancelURL,
                    'hdrimg' => base_url('assets/front/images/logo.png'),
                    'logoimg' => base_url('assets/front/images/logo.png'),
                    'brandname' => 'The Escape Room',
                    'NOSHIPPING' => '1',
                );

                $Payments = array();
                $Payment = array(
                    'PAYMENTREQUEST_0_AMT' => $amount,
                    'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
                    'PAYMENTREQUEST_0_ITEMAMT' => $amount,
                    'PAYMENTREQUEST_0_INVNUM' => $insert_id,
                    'PAYMENTREQUEST_0_CUSTOM' => $insert_id,
                    'L_PAYMENTREQUEST_0_NAME0' => 'Adventrure',
                    'L_PAYMENTREQUEST_0_AMT0' => $amount,
                    'L_PAYMENTREQUEST_0_QTY0' => '1',
                    'amt' => $amount
                );

                array_push($Payments, $Payment);

                $PayPalRequestData = array(
                    'SECFields' => $SECFields,
                    'Payments' => $Payments,
                );

                $PayPalResult = $PayPal->SetExpressCheckout($PayPalRequestData);
                if ($PayPal->APICallSuccessful($PayPalResult['ACK'])) {
                    session()->set('checkout_order_id', $insert_id);
                    session()->set('checkout_token', $PayPalResult['TOKEN']);
                    return redirect()->to($PayPalResult['REDIRECTURL']);
                    die();
                } else {
                    $this->session->setFlashdata('flash_message', 'Something is went wrong please try again.');
                    $this->session->setFlashdata('class', 'danger');
                }
            } else {
                $this->session->setFlashdata('flash_message', 'Something is went wrong please try again.');
                $this->session->setFlashdata('class', 'danger');
            }
        endif;
        $page_data = [];
        $page_data['adventure'] = $adventure;
        echo view('front/account/checkout', $page_data);
    }
    public function thankYou()
    {
        $user_id = session()->get('user_id');
        if (session()->getFlashdata('flash_message')) :

            $order_id = session()->get('checkout_order_id');
            // unset session data
            session()->remove('checkout_token');
            session()->remove('checkout_order_id');
            $page_data = [];
            $page_data = $this->common_model->GetSingleRow(ORDERS_TABLE, array('id' => $order_id, 'user_id' => $user_id));

            echo view('front/account/thankyou', $page_data);
        else :
            return redirect()->to('home');
            die();
        endif;
    }
	
	 public function email()
    {
		$user_id = session()->get('user_id');
        if (session()->getFlashdata('flash_message')) :
			$order_id = session()->get('checkout_order_id');
			
		  else :
       //     return redirect()->to('home');
        //   die();
        endif;
		echo view('front/account/email.php');
    }

    public function orders()
    {
        $user_id = session()->get('user_id');
        $where = [];
        $where[] = " user_id = '$user_id' ";
        $where = implode(' AND ', $where);
        $per_page = 5;
        $offset = (int)$this->request->getVar('page') ? ($this->request->getVar('page') - 1) * $per_page : 0;
        $total = $this->common_model->GetTotalCount(ORDERS_TABLE, $where);
        $data = $this->common_model->GetTableRows(ORDERS_TABLE, $where, array('id', 'desc'), $per_page, $offset);
        $pagination = false;
        if ($per_page < $total) :
            $pager = \Config\Services::pager();
            $pagination = $pager->makeLinks($offset, $per_page, $total, 'front');
        endif;
		
		
        $page_data['rows'] = $data;
        $page_data['total'] = $total;
        $page_data['pagination'] = $pagination;
        $page_data['model'] = $this->common_model;
        echo view('front/account/orders', $page_data);
    }

    public function checkTeamCode()
    {
        $user_id = session()->get('user_id');
        $teamcode = $this->request->getVar('teamcode');
        $response = [];
        if (empty($teamcode)) {
            $response = [
                'status'   => 'error',
                'msg' => 'Teamcode is empty.'
            ];
            return $this->respond($response);
            die();
        }

        // check if teamcode is valid and payment is made
        $valid_teamcode = $this->common_model->GetSingleRow(ORDERS_TABLE, array('teamcode' => $teamcode, 'status' => 1));
        if (!$valid_teamcode) :
            $response = [
                'status'   => 'error',
                'msg' => 'This teamcode is not valid.'
            ];
            return $this->respond($response);
            die();
        endif;
        $order_id = $valid_teamcode['id'];
        $adventure_id = $valid_teamcode['adventure_id'];
		//check played count
        $valid_players = $this->common_model->GetSingleValue(ADVENTURES_TABLE,'players', array('id' => $valid_teamcode['adventure_id'], 'status' => 1));
        $all_team_member = $this->common_model->GetTotalCount(TEAMS_TABLE,array('teamcode' => $teamcode,'order_id' => $order_id));
		// check if member already exits in team table
        $team_members_exists = $this->common_model->GetSingleRow(TEAMS_TABLE, array('teamcode' => $teamcode, 'order_id' => $order_id, 'user_id' => $user_id));
		session()->set('valid_players', $valid_players);
		if ($all_team_member >= $valid_players && empty($team_members_exists)) :
            $response = [
                'status'   => 'error',
                'msg' => 'Team is already full.'
            ];
            return $this->respond($response);
            die();
        endif;
        if (!$team_members_exists) :
            // insert data in teams table
            $teamdata = [
                'teamcode' => $teamcode,
                'order_id' => $order_id,
                'user_id' => $user_id,
                'created_at' => time(),
                'updated_at' => time(),
            ];

            $insert_id = $this->common_model->InsertTableData(TEAMS_TABLE, $teamdata);
            if ($insert_id) :
                session()->set('challenges_adventure_id', $adventure_id);
                session()->set('adventure_teamcode', $teamcode);
                session()->set('order_id', $order_id);
                $response = [
                    'status'   => 'success',
                    'url'   => base_url('game'),
                    'msg' => 'You are successfully entered into the game.'
                ];
            else :
                $response = [
                    'status'   => 'error',
                    'msg' => 'Something is went wrong please try again.'
                ];
            endif;
        else:
            // when the user is already in the team
            session()->set('challenges_adventure_id', $adventure_id);
            session()->set('adventure_teamcode', $teamcode);
            session()->set('order_id', $order_id);
            $response = [
                'status'   => 'success',
                'url'   => base_url('game'),
                'msg' => 'You are successfully entered to the game.'
            ];
        endif;
       
        return $this->respond($response);
        die();
    }

    public function game(){
        $user_id = session()->get('user_id');
        $adventure_id = session()->get('challenges_adventure_id');
        $teamcode = session()->get('adventure_teamcode');
        if($adventure_id):
            $valid_order = $this->common_model->GetSingleRow(ORDERS_TABLE, array('teamcode' => $teamcode, 'status' => 1,'adventure_id'=>$adventure_id));
            if (!$valid_order) :
                $response = [
                    'status'   => 'error',
                    'msg' => 'This teamcode is not valid.'
                ];
                return $this->respond($response);
                die();
            endif;
            $order_id = $valid_order['id'];
            $all_team_members = $this->common_model->GetTableRows(TEAMS_TABLE,array('teamcode'=>$teamcode,'order_id'=>$order_id));
            $page_data['model'] = $this->common_model;
            $page_data['team_members'] = $all_team_members;
            $page_data['user'] = $this->common_model->GetSingleRow(USERS_TABLE, array('id' => $user_id));
            $page_data['teamcode'] = $teamcode;
            /* _p($page_data);
            die(); */
            echo view('front/account/game', $page_data);

        else: 
            // when adventure is not valid
        endif;
    }
}
