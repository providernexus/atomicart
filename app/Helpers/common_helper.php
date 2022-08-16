<?php
/* 
Author: Subhash Shipu
Email: provider.nexus@gmail.com
Website: https://www.nexustechies.com
*/
function have_permission($permission, $type = "page")
{
	$common_model = new \App\Models\Common();
	$role_id = session()->get('role_id');
	$user_id = session()->get('admin_id');
	$role_permissions = $common_model->GetSingleValue(ROLES_TABLE, 'permissions', ['id' => $role_id]);
	$user_permissions = $common_model->GetSingleValue(ADMIN_TABLE, 'permissions', ['id' => $user_id]);
	if (!$role_permissions) {
		$role_permissions = [];
	} else {
		$role_permissions = explode(',', $role_permissions);
	}
	if (!$user_permissions) {
		$user_permissions = [];
	} else {
		$user_permissions = explode(',', $user_permissions);
	}
	$role_permissions = array_merge($role_permissions, $user_permissions);
	if (in_array($permission, $role_permissions)) {
		return true;
	} else {
		if ($type == "page") :
			session()->setFlashdata('flash_message', 'You don\'t have permission to access this page.' . $permission);
			session()->setFlashdata('class', 'danger');
		endif;
		return false;
	}
}
function all_permissions()
{
	$common_model = new \App\Models\Common();
	$role_id = session()->get('role_id');
	$user_id = session()->get('admin_id');
	$role_permissions = $common_model->GetSingleValue(ROLES_TABLE, 'permissions', ['id' => $role_id]);
	$user_permissions = $common_model->GetSingleValue(ADMIN_TABLE, 'permissions', ['id' => $user_id]);
	if (!$role_permissions) {
		$role_permissions = [];
	} else {
		$role_permissions = explode(',', $role_permissions);
	}
	if (!$user_permissions) {
		$user_permissions = [];
	} else {
		$user_permissions = explode(',', $user_permissions);
	}
	$role_permissions = array_merge($role_permissions, $user_permissions);
	return $role_permissions;
}
function have_permissionOld($permission, $type = "page")
{
	$common_model = new \App\Models\Common();
	$role_id = session()->get('role_id');
	$role_permissions = $common_model->GetSingleValue(PERMISSIONS_TABLE, 'modules', ['role_id' => $role_id]);
	if (!$role_permissions) {
		$role_permissions = [];
	} else {
		$role_permissions = explode(',', $role_permissions);
	}
	if (in_array($permission, $role_permissions)) {
		return true;
	} else {
		if ($type == "page") :
			session()->setFlashdata('flash_message', 'You don\'t have permission to access this page .');
			session()->setFlashdata('class', 'danger');
		endif;
		return false;
	}
}

function generateLangFiles()
{
	$common_model = new \App\Models\Common();
	helper('filesystem');
	$translations = $common_model->GetTableRows('tbl_translations');
	$lang = array();
	$langstren = "<?php " . "\n\n";
	$langstrde = "<?php " . "\n\n";
	foreach ($translations as $row) {
		$text_en = $row['en'];
		$text_de = $row['de'];
		$langstren .= "\$lang['" . $row['slug'] . "'] = \"$text_en\";" . "\n";
		$langstrde .= "\$lang['" . $row['slug'] . "'] = \"$text_de\";" . "\n";
	}
	$langstren .= "return \$lang; ";
	$langstrde .= "return \$lang; ";
	write_file(APPPATH . '/Language/en/t.php', $langstren);
	write_file(APPPATH . '/Language/de/t.php', $langstrde);
}

function us_phone_format($input)
{
	$output = "(" . substr($input, -10, -7) . ")" . "-" . substr($input, -7, -4) . "-" . substr($input, -4);
	return $output;
}
function check_isset($key, $array)
{
	$value = "";
	if (isset($array[$key])) {
		$value = $array[$key];
	}
	return $value;
}
function check_checkbox($first, $second)
{
	$checked = "";
	if ($first == $second) {
		$checked = "checked";
	}
	return $checked;
}
function selected_select($first, $second)
{
	$selected = "";
	if ($first == $second) {
		$selected = "selected";
	}
	return $selected;
}
function hear_about_from($selected = "")
{
	$array = [
		'1' => 'Newspaper',
		'2' => 'Leaflet',
		'3' => 'Friend',
		'4' => 'Google',
		'5' => 'A19 road banner',
		'6' => 'Facebook',
		'7' => 'Instagram',
		'8' => 'Twitter',
		'9' => 'Other',
	];
	if (!empty($selected)) {
		return $array[$selected];
	} else {
		return $array;
	}
}

function email_confirm_class($selected, $sap = " ")
{
	$array = [
		'0' => 'Not Verified',
		'1' => 'text-success',
		'2' => 'text-danger',
	];
	if (!empty($selected)) {
		return $sap . $array[$selected];
	}
}
function payment_statuses($selected = '')
{
	$array = [
		'0' => ['label' =>lang('t.pending'), 'class' => 'pending'],
		'1' => ['label' =>lang('t.completed'), 'class' => 'complete'],
		'2' => ['label' =>lang('t.canceled'), 'class' => 'bg-secondary'],
		'3' => ['label' =>lang('t.failed'), 'class' => 'bg-danger'],
	];
	if ($selected != "") {
		if (isset($array[$selected])) :
			return $array[$selected];
		else :
			return '';
		endif;
	} else {
		return $array;
	}
}

function payment_statuses_color($selected = '')
{
	$array = [
		'0' => ['label' => 'Pending', 'color' => 'text-warning'],
		'1' => ['label' => 'Completed', 'color' => 'text-success'],
		'2' => ['label' => 'Canceled', 'color' => 'text-danger'],
		'3' => ['label' => 'Failed', 'color' => 'text-danger'],
	];

	if ($selected != "") {
		if (isset($array[$selected])) :
			return $array[$selected];
		else :
			return '';
		endif;
	} else {
		return $array;
	}
}

function orders_statuses($selected = "")
{
	$array = [
		'0' => 'Pending',
		'1' => 'Processing',
		'5' => 'AI Processing',
		'2' => 'Hold',
		'3' => 'Approve',
		'6' => 'Completed',
		'7' => 'Downloaded',
		'8' => 'Move To Archive',
		'4' => 'Cancel',
	];
	if (!empty($selected) || $selected != "") {
		if (isset($array[$selected])) :
			return $array[$selected];
		else :
			return '';
		endif;
	} else {
		return $array;
	}
}

//for size
function size_types($selected = "")
{
	$array = [
		'1' =>lang('t.small'),
		'2' =>lang('t.medium'),
		'3' =>lang('t.large'),
		'4' =>lang('t.other'),
	];
	if (!empty($selected)) {
		return $array[$selected];
	} else {
		return $array;
	}
}
//for levels
function levels($selected = "")
{
	$array = [
		'1' =>lang('t.easy'),
		'2' =>lang('t.medium'),
		'3' =>lang('t.hard'),
	];
	if (!empty($selected)) {
		return $array[$selected];
	} else {
		return $array;
	}
}

//for gender
function gender($selected = "")
{
	$array = [
		'1' =>lang('t.male'),
		'2' =>lang('t.female'),
		'0' =>lang('t.other'),
	];
	if (!empty($selected) || $selected == '0') {

		return $array[$selected];
	} else {
		return $array;
	}
}
//for levels
function expires($selected = "")
{
	$array = [
		'1' => '1 Day',
		'2' => '2 Days',
		'3' => '7 Days',
	];
	if (!empty($selected)) {
		return $array[$selected];
	} else {
		return $array;
	}
}
/* clean url  */
function clean($string, $symbol = "-")
{
	$string = str_replace(' ', $symbol, $string); // Replaces all spaces with hyphens.
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	return preg_replace('/-+/', $symbol, strtolower($string)); // Replaces multiple hyphens with single one.
}
function acronym($string = '')
{
	$words = explode(' ', $string);
	if (!$words) {
		return false;
	}
	$result = '';
	foreach ($words as $word) {
		$result .= $word[0];
	}
	return strtoupper($result);
}
function slug($string, $spaceRepl = "-")
{
	$string = str_replace("&", "and", $string);
	$string = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);
	$string = strtolower($string);
	$string = preg_replace("/[ ]+/", " ", $string);
	$string = str_replace(" ", $spaceRepl, $string);
	return $string;
}
function format_number($n, $point = '.', $sep = ',')
{
	if ($n < 0) {
		return 0;
	}
	if ($n < 10000) {
		return number_format($n, 0, $point, $sep);
	}
	$d = $n < 1000000 ? 1000 : 1000000;
	$f = round($n / $d, 1);
	return number_format($f, $f - intval($f) ? 1 : 0, $point, $sep) . ($d == 1000 ? 'k' : 'M');
}
/* Get currency code */
function get_currency_code($currency = "aed")
{
	$currency_code = "";
	if ($currency = "aed") {
		$currency_code = "&#x62f;&#x2e;&#x625;";
	}
	return $currency_code;
}
function _p($array)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}
function time_ago_days($expirationDate)
{
	$toDay = strtotime(date('Y-m-d H:i:s'));
	$difference = abs($toDay - $expirationDate);
	$days = floor($difference / 86400);
	$hours = floor(($difference - $days * 86400) / 3600);
	$minutes = floor(($difference - $days * 86400 - $hours * 3600) / 60);
	$seconds = floor($difference - $days * 86400 - $hours * 3600 - $minutes * 60);
	//echo "{$days} days {$hours} hours {$minutes} minutes {$seconds} seconds";
	if ($days > 0) {
		return "{$days} days {$hours} hours ago";
	}
	if ($hours > 0) {
		return "{$hours} hours {$minutes} minutes ago";
	}
	if ($hours < 1) {
		return "{$minutes} minutes ago";
	}
}
/* Time ago  */
function Timeago($time)
{
	$time_difference = time() - $time;
	if ($time_difference < 1) {
		return 'less than 1 second ago';
	}
	$condition = [
		12 * 30 * 24 * 60 * 60 => 'year',
		30 * 24 * 60 * 60 => 'month',
		24 * 60 * 60 => 'day',
		60 * 60 => 'hour',
		60 => 'minute',
		1 => 'second',
	];
	foreach ($condition as $secs => $str) {
		$d = $time_difference / $secs;
		if ($d >= 1) {
			$t = round($d);
			return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
		}
	}
}
/* Get file mime type */
function get_file_type($filename)
{
	if (empty($filename)) {
		return "";
	}
	$mime_types = [
		'txt' => 'text/plain',
		'htm' => 'text/html',
		'html' => 'text/html',
		'php' => 'text/html',
		'css' => 'text/css',
		'js' => 'application/javascript',
		'json' => 'application/json',
		'xml' => 'application/xml',
		'swf' => 'application/x-shockwave-flash',
		'flv' => 'video/x-flv',
		// images
		'png' => 'image/png',
		'jpe' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'jpg' => 'image/jpeg',
		'gif' => 'image/gif',
		'bmp' => 'image/bmp',
		'ico' => 'image/vnd.microsoft.icon',
		'tiff' => 'image/tiff',
		'tif' => 'image/tiff',
		'svg' => 'image/svg+xml',
		'svgz' => 'image/svg+xml',
		// archives
		'zip' => 'application/zip',
		'rar' => 'application/x-rar-compressed',
		'exe' => 'application/x-msdownload',
		'msi' => 'application/x-msdownload',
		'cab' => 'application/vnd.ms-cab-compressed',
		// audio/video
		'mp3' => 'audio/mpeg',
		'qt' => 'video/quicktime',
		'mov' => 'video/quicktime',
		// adobe
		'pdf' => 'application/pdf',
		'psd' => 'image/vnd.adobe.photoshop',
		'ai' => 'application/postscript',
		'eps' => 'application/postscript',
		'ps' => 'application/postscript',
		// ms office
		'doc' => 'application/msword',
		'rtf' => 'application/rtf',
		'xls' => 'application/vnd.ms-excel',
		'ppt' => 'application/vnd.ms-powerpoint',
		// open office
		'odt' => 'application/vnd.oasis.opendocument.text',
		'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
	];
	$explode = explode('.', $filename);
	$ext = strtolower(array_pop($explode));
	if (array_key_exists($ext, $mime_types)) {
		return $mime_types[$ext];
	} elseif (function_exists('finfo_open')) {
		$finfo = finfo_open(FILEINFO_MIME);
		$mimetype = finfo_file($finfo, $filename);
		finfo_close($finfo);
		return $mimetype;
	} else {
		return 'application/octet-stream';
	}
}
function money_format_india($amount = 1000.0)
{
	setlocale(LC_MONETARY, 'en_IN');
	$amount = money_format('%!i', $amount);
	return $amount;
}
function random_password($length = 8)
{
	$alphabet = "abcdefghijklmnopqrstuwxyz0123456789@#$";
	$pass = []; //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < $length; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}

function random_teamcode()
{
	$length = 8;
	$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$pass = []; //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < $length; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}


function secure_string($string, $action = 'e')
{
	$secret_key = '123654zxcvbnm';
	$secret_iv = 'qazxswedc!@#$#@!';
	$output = false;
	$encrypt_method = "AES-256-CBC";
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	if ($action == 'e') {
		$output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
	} elseif ($action == 'd') {
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}
	return $output;
}
//  functions only for this website
function meta_data($data = [])
{
}
// get profile media data
function getProfileMediaData($id)
{
	$json_data['logged_in_user_name'] = '';
	$json_data['media_src'] = '';
	$json_data['original_name'] = '';
	$db = \Config\Database::connect();
	//users table
	$user_builder = $db->table('tbl_users');
	$user_output = $user_builder
		->where('id', $id)
		->select('media_id,name')
		->get();
	//if not empty users table data
	if (!empty($user_output->getRowArray())) :
		$json_data['logged_in_user_name'] = $user_output->getRowArray()['name']; //get current user name
		$profile_media_id = $user_output->getRowArray()['media_id']; //get users's media id from users
		//placeholder image
		$json_data['media_src'] = "https://via.placeholder.com/60//fff?text=" . ucfirst(substr($user_output->getRowArray()['name'], 0, 1));
		//media table
		$builder = $db->table('tbl_media');
		$output = $builder
			->where('id', $profile_media_id)
			->select('name,original_name')
			->get();
		$file = $output->getRowArray();
		//if media data is not empty
		if (!empty($file)) :
			$file_name = $file['name'];
			$json_data['name'] = $file['name'];
			$json_data['original_name'] = $file['original_name'];
			if (!empty($file_name)) :
				if (file_exists(FCPATH . "uploads/" . $file_name)) :
					$media_src = base_url('/uploads/' . $file_name . '');
					$json_data['media_src'] = $media_src;
				endif;
			endif;
		endif;
	endif;
	return json_encode($json_data);
}

function isUserLoggedIn()
{
	$id = session()->get('user_id');
	if ($id) {
		return true;
	}
	return false;
}
