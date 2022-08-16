<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Common;
use App\Models\OrderModel;

class Api extends BaseController
{
	use ResponseTrait;

	public function __construct()
	{
		$this->common_model = new Common();
		$this->db =  \Config\Database::connect();
	}

	public function index()
	{
	}
}
