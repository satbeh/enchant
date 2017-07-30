<?php
class Controller {
	public $view_file = "/view/index.php";
	public $response = Array();

	public function __construct() {
	}
	
	public function getViewFile() {
		return $this->view_file;
	}
			
	public function showError($errorMessage) {
		$this->view_file = "/view/error.php";
		$this->response['errorMessage'] = $errorMessage;
	}
}
?>
