<?php
include_once("Controller.php");

class AppController extends Controller {
	public $group = array(
		"sales" => "58d26b56bbddbd7d027c51b0",
		"ws" => "591c20d1bbddbd732bd9fb73",
		"bec" => "554567d769702d2b42230000",
		"hello" => "5544351b69702d243bc00000"
	);
	public $per_page = 100;
	public $curr_page = 1;
	public $since_updated_at = "";
	public $new_updated_at = "";
	public $tickets = array();

	public function __construct() {
		parent::__construct();
	}

	public function login(){
		$this->view_file = "/view/login.php";
		
		if(isset($_REQUEST['submitLogin'])){
			if(isset($_REQUEST['password'])){ 
				if(trim($_REQUEST['password']) == APPPASSWORD){
					$_SESSION['app-login'] = true;
					$_SESSION['app-admin-login'] = false;
					header('Location: '.APPURL.'');
				} else if(trim($_REQUEST['password']) == ADMINPASSWORD){
					$_SESSION['app-login'] = true;
					$_SESSION['app-admin-login'] = true;
					header('Location: '.APPURL.'');
				}else{
					$this->response['formerror'] = "Invalid";
				}
			}else{
				$this->response['formerror'] = "Invalid";
			}
		}
		
		if(isset($_REQUEST['submitLogout'])){
			unset($_SESSION['app-login']); 
			unset($_SESSION['app-admin-login']); 
			header('Location: '.APPURL.'');
		}
	}
	
	public function errorInvalidPage(){
		$this->view_file = "/view/error.php";
		$this->showError("Invalid Page");
	}
	
	public function listLabels($type){
		try {
			$filename = dirname(__FILE__) . "/../data/labels_".$type.".txt";
			$file = fopen($filename, "r");
			$this->response['labels'] = json_decode(fread($file, filesize($filename)));
			$this->response['type'] = $type;
			$this->response['inbox'] = $this->group[$type];
			fclose($file);
			
			$this->view_file = "/view/list_labels.php";
		} catch (Exception $ex) {
			$this->showError($ex->getMessage());
		}
	}
		
	public function editLabel($type){
		$this->view_file = "/view/edit_label.php";
		
		if(isset($_REQUEST['save_label'])){
			if(isset($_REQUEST['id'])){
				$filename = dirname(__FILE__) . "/../data/labels_".$type.".txt";
				$file = fopen($filename, "r+");
				$labels = json_decode(fread($file, filesize($filename)));
				$labels->$_REQUEST['id'] = $_REQUEST['label_duration'];
				$file = fopen($filename, "w");
				fwrite($file, json_encode($labels));
				fclose($file);
			}

			header( "Location: " . APPURL."list_".$type );
		}
		
		try {	
			if(isset($_REQUEST['id'])){
				$filename = dirname(__FILE__) . "/../data/labels_".$type.".txt";
				$file = fopen($filename, "r");
				$labels = json_decode(fread($file, filesize($filename)));
				$this->response['label'] = array(
					"id"=>$_REQUEST['id'],
					"duration"=>$labels->$_REQUEST['id']
				);
				$this->response['type'] = $type;
				$this->response['inbox'] = $this->group[$type];
				fclose($file);
			}else{
				$this->response['label'] = array(
					"id"=>"",
					"duration"=>""
				);
			}
						
		} catch (Exception $ex) {
			$this->showError($ex->getMessage());
		}
	}

	public function deleteLabel($type){
		try {	
			if(isset($_REQUEST['id'])){
				$filename = dirname(__FILE__) . "/../data/labels_".$type.".txt";
				$file = fopen($filename, "r+");
				$labels = json_decode(fread($file, filesize($filename)));
				unset($labels->$_REQUEST['id']);
				$file = fopen($filename, "w");
				fwrite($file, json_encode($labels));
				fclose($file);
			}

			header( "Location: " . APPURL."list_".$type );
		} catch (Exception $ex) {
			$this->showError($ex->getMessage());
		}
	}

	public function updateMails($type){
		//$this->get_last_updated($type);

		$url = API_URL.'tickets';
		$url.='?per_page='.$this->per_page;
		$url.='&page='.$this->curr_page;
		//$url.='&since_updated_at='.$this->since_updated_at;
		$url.='&group_id='.$this->group[$type];
		$url.='&count=true&state=closed';
		$url.='&fields=id,label_ids,updated_at';

		echo $url;
		$res = $this->simple_curl($url);

		foreach ($res['content'] as $value){
			if(count($value->label_ids) > 0)
				array_push($this->tickets, $value);
		}
		//echo $res['count'];
		if($this->curr_page*$this->per_page < $res['count']){
			$this->curr_page++;
			$this->updateMails($type);
		}else{
			$this->curr_page = 1;
			//echo count($this->tickets);
			foreach ($this->tickets as $ticket){
				$this->validate_and_reopen($type, $ticket);
			}

			//$this->set_last_updated($type);
		}
	}

	function validate_and_reopen($type, $ticket){
		$interval = date_diff(date_create(date('Y-m-d\TH:i:s\Z')), date_create($ticket->updated_at));
		$status_duration = $interval->format("%d");
		$filename = dirname(__FILE__) . "/../data/labels_".$type.".txt";
		$file = fopen($filename, "r");
		$reopen = json_decode(fread($file, filesize($filename)));
		fclose($file);

		foreach ($reopen as $label=>$duration){
			
			if (in_array($label, $ticket->label_ids)) {
				/*
				echo $ticket->id;
				echo "--";
				echo $label;
				echo "--";
				echo $duration;
				echo "--";
				echo $status_duration;
				echo "\n";*/
				if($status_duration >= $duration){
					$this->reopen_ticket($type, $ticket->id);
				}
			}
		}
	}

	function reopen_ticket($type, $ticket_id){
		$url = API_URL.'tickets/'.$ticket_id;
		$data = array(
			"state"=>"open"
		);
		//echo $url;
		//echo "\n";
		
		$res = $this->simple_curl($url, 'PATCH', json_encode($data));
	}

	function get_last_updated($type){
		if(strlen($this->since_updated_at) == 0){
			$file = fopen(dirname(__FILE__) . "/../data/last_updated_".$type.".txt","r");
			$this->since_updated_at = fread($file, 30);
			fclose($file);
			$this->new_updated_at = date('Y-m-d\TH:i:s\Z');
		}
	}

	function set_last_updated($type){
		$file = fopen(dirname(__FILE__) . "/../data/last_updated_".$type.".txt","r+");
		fwrite($file, $this->new_updated_at);
		fclose($file);
	}
		
	function simple_curl($uri, $method='GET', $data=null, $curl_headers=array(), $curl_options=array()) {
		// defaults
		$default_curl_options = array(
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HEADER => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 3,
		);
		$default_headers = array('Content-Type: application/json');

		// validate input
		$method = strtoupper(trim($method));
		$allowed_methods = array('GET', 'POST', 'PUT', 'PATCH', 'DELETE');

		if(!in_array($method, $allowed_methods))
			throw new \Exception("'$method' is not valid cURL HTTP method.");

		if(!empty($data) && !is_string($data))
			throw new \Exception("Invalid data for cURL request '$method $uri'");

		// init
		$curl = curl_init($uri);

		// apply default options
		curl_setopt_array($curl, $default_curl_options);

		// apply method specific options
		switch($method) {
			case 'GET':
				break;
			case 'POST':
				if(!is_string($data))
					throw new \Exception("Invalid data for cURL request '$method $uri'");
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case 'PUT':
				if(!is_string($data))
					throw new \Exception("Invalid data for cURL request '$method $uri'");
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case 'PATCH':
				if(!is_string($data))
					throw new \Exception("Invalid data for cURL request '$method $uri'");
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case 'DELETE':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
				break;
		}

		// apply user options
		curl_setopt_array($curl, $curl_options);

		// add headers
		curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge($default_headers, $curl_headers));
		curl_setopt($curl, CURLOPT_USERPWD, API_USERNAME.':'.API_PASSWORD);

		// parse result
		$raw = rtrim(curl_exec($curl));
		$lines = explode("\r\n", $raw);
		$headers = array();
		$content = '';
		$write_content = false;
		if(count($lines) > 3) {
			foreach($lines as $h) {
				if($h == '')
					$write_content = true;
				else {
					if($write_content)
						$content .= $h."\n";
					else
						$headers[] = $h;
				}
			}
		}
		$error = curl_error($curl);

		curl_close($curl);

		$count = 0;

		foreach ($headers as $key => $value){
			$currheader = explode(":", $value);
			if($currheader[0] == "Total-Count")
				$count = $currheader[1];
		}

		// return
		return array(
			'count' => $count,
			'content' => json_decode($content),
			'error' => $error
		);
	}

	function writeLog($message){
		$file = 'log_webhook.txt';
		file_put_contents($file, date('Y-m-d h:i:s') . " - " . $message . "\n", FILE_APPEND | LOCK_EX);
	}
}
?>