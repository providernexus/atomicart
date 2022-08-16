<?php

namespace App\Controllers;

use App\Models\Common;
use App\Libraries\Paypal\Paypal_lib; // Import library

class Paypal extends BaseController
{

	public function __construct()
	{
		$this->common_model = new Common();
		//$this->paypal_lib = new Paypal_lib();
	}

	public function index(){

		//Set variables for paypal form
		$returnURL = base_url().'/paypal/payment-success'; //payment success url

		$cancelURL = base_url().'/paypal/payment-fail'; //payment cancel url
		$notifyURL = base_url().'/paypal/ipn'; //ipn url
		$user_id = session()->get('user_id');; //current user id
		$temp_upload_id = session()->get('temp_upload_id');
		$media = $this->common_model->GetSingleRow(MEDIA_TABLE, array('id' => $temp_upload_id));
		$file = $media['name'];
		$order_id = $this->request->getVar('oid');

		$logo = base_url().'assets/front/images/logo.png';
		$this->paypal_lib->add_field('return', $returnURL);
		$this->paypal_lib->add_field('cancel_return', $cancelURL);
		$this->paypal_lib->add_field('notify_url', $notifyURL);
		$this->paypal_lib->add_field('item_name', 'File Name: '.$file);
		$this->paypal_lib->add_field('user_id',$user_id);
		$this->paypal_lib->add_field('item_number',$order_id);
		$this->paypal_lib->add_field('amount',  70);        
		//$this->paypal_lib->image($logo);
		$this->paypal_lib->paypal_auto_form();
	}

	/**
     * get the transaction data
     *
     * @return response()
     */ 
   
	function paymentSuccess(){

		$token = session()->get('checkout_token');
		$order_id = session()->get('checkout_order_id');
		if(!$token):
			return redirect()->to('user/create-order');
		endif;

		$paypalInfo = $this->request->getVar();
		//require_once(FCPATH . '/vendor/angelleye/paypal-php-library/autoload.php');
        $PayPalConfig = array(
            'Sandbox' => true,
            'APIUsername' => "namratadhir-facilitator_api1.yahoo.com",
            'APIPassword' => "SNTFCJH8Q8AXBUZ8",
            'APISignature' => "AghqUnyUaRTJA1wlaRIfubW-Top8AaAFPkBX4urgnZs8ZcTLk-6SS3U7", 
            'PrintHeaders' => false, 
            'LogResults' => false,
            'LogPath' => $_SERVER['DOCUMENT_ROOT'].'/logs/',
        );
		
		$PayPal = new \angelleye\PayPal\PayPal($PayPalConfig);
		

		$PayPalResult = $PayPal->GetExpressCheckoutDetails($paypalInfo['token']);
		$DECPFields = array(
			'token' => $token, 
			'payerid' => $PayPalResult['PAYERID'], 	
		);

		$amount = $PayPalResult['AMT'];

		$Payments = array();
		$Payment = array(
			'amt'=>$amount
		);

		array_push($Payments, $Payment);

		$PayPalRequestData = array(
			'DECPFields' => $DECPFields, 
			'Payments' => $Payments, 
		);

		$PayPalResult = $PayPal->DoExpressCheckoutPayment($PayPalRequestData);

		if($PayPal->APICallSuccessful($PayPalResult['ACK']))
		{
			$txn_id = $PayPalResult['PAYMENTINFO_0_TRANSACTIONID'];
			// check if txn id already existing 
			$row = $this->common_model->GetSingleRow(PAYMENTS_TABLE,array('txn_id' => $txn_id));
			if($row):
				$json_data['order_id'] = $row['order_id']; 
				$json_data['txn_id'] = $row["txn_id"];
				$json_data['amount'] = $row["amount"];
				$json_data['payment_status'] = $PayPalResult["PAYMENTINFO_0_PAYMENTSTATUS"];
			else:

				// insert the data to payments table
				$data = [
					'order_id' => $order_id,
					'txn_id' => $PayPalResult["PAYMENTINFO_0_TRANSACTIONID"],
					'amount' => $PayPalResult["PAYMENTINFO_0_AMT"],
					'payment_status' => $PayPalResult["PAYMENTINFO_0_PAYMENTSTATUS"],
					'payment_method' => 'Paypal',
					'payment_gateway_response' => serialize($PayPalResult),
					'created_at' => time(),
					'updated_at' => time(),
				];

				$this->common_model->InsertTableData(PAYMENTS_TABLE, $data);

				


				$json_data['order_id'] = $order_id; 
				$json_data['txn_id'] = $PayPalResult["PAYMENTINFO_0_TRANSACTIONID"];
				$json_data['amount'] = $PayPalResult["PAYMENTINFO_0_AMT"];
				$json_data['payment_status'] = $PayPalResult["PAYMENTINFO_0_PAYMENTSTATUS"];
			endif;
                     //for send email to user and admin
			        $order = $this->common_model->GetSingleRow(ORDERS_TABLE,array('id' => $order_id));
                    $subject = 'You have successfully purchased an adventure!';
					$message = 'Adventure purchased successfully.';
					$name = session()->get('username');
					$user_id = session()->get('user_id');
					$adventures = $this->common_model->GetSingleRow(ADVENTURES_TABLE,array('id' => $order['adventure_id']));
					$email = $this->common_model->GetSingleValue(USERS_TABLE,'email',array('id' => $user_id));
					$level = 1;
					if($adventures['level'] > 0):
					 $level = $adventures['level'];
					endif;
					$level = levels($level);
					//for user 
					$page_data['name'] = 'Hello '.$name;
					$page_data['user_name'] = $name;
					$page_data['adventure_name'] = $adventures['name'];
					$page_data['price'] = CURRENCY_DOLLAR.$adventures['price'];
					$page_data['level'] = $level;
					$page_data['order_id'] = $order_id;
					$page_data['players'] = $adventures['players'];
					$page_data['teamcode'] = $order['teamcode'];
					$page_data['user_type'] = 'user';
					$page_data['email'] = $email;
					$page_data['msg'] = 'Thank you for the prompt payment on your account.';
					$user_email_template =  view('front/email/order_template', $page_data);
					$send_to_users = $this->common_model->SendEmail($email,FROM_EMAIL, $subject, $user_email_template);
					//for admin 
					$page_data['user_type'] = 'admin';
					$page_data['name'] = 'Dear Admin';
					$subject = 'A new adventure has been purchased';
					$admin_email_template =  view('front/email/order_template', $page_data);
					$send_to_admin = $this->common_model->SendEmail(ADMIN_EMAIL,FROM_EMAIL, $subject, $admin_email_template);
			// once payment is successfull update the status as well on order table
			$this->common_model->UpdateTableData(ORDERS_TABLE,array('status'=>1), array('id' => $order_id));
			
			//session()->set('payment_data',$json_data);	

			$this->session->setFlashdata('flash_message', 'Your order is submiited successfully. We will get back to you with your order status.');
			$this->session->setFlashdata('class', 'success');
			return redirect()->to('user/thank-you');
		}
		else
		{

		}
	}

    /**
     * if transaction cancelled
     *
     * @return response()
     */  

    function paymentFail(){
    	// $this->load->view('paypal/payment-fail');
		echo view('front/account/payment-fail.php');
    }

    /**
     * paypal return transaction details array
     *
     * @return response()
     */  
    function ipn(){
    	$paypalInfo = $_POST;

    	$data['user_id'] = $paypalInfo['custom'];
    	$data['product_id']    = $paypalInfo["item_number"];
    	$data['txn_id']    = $paypalInfo["txn_id"];
    	$data['payment_gross'] = $paypalInfo["mc_gross"];
    	$data['currency_code'] = $paypalInfo["mc_currency"];
    	$data['payer_email'] = $paypalInfo["payer_email"];
    	$data['payment_status']    = $paypalInfo["payment_status"];

    	$paypalURL = $this->paypal_lib->paypal_url;        
    	$result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);

    	if(preg_match("/VERIFIED/i",$result)){
    		$file_content = "Welcome to Online Web Tutor Blog";

			// Type#1 - This file will be created inside /public folder
    		write_file("paypaldata.txt", $file_content);
    		$this->product->storeTransaction($data);
    	}
    }

}