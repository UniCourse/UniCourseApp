<?php

Class TestAction extends Action {

	public function index() {
		$this->display();
	}

	public function test1() {
		$this->display();
	}

	public function test2() {
		$this->display();
	}

	public function testnews() {
		$this->display();
	}

	public function login() {
		$usernumber = I('username');
		$password = I('password', '', 'md5');
		$data['usernumber'] = $usernumber;
		$data['password'] = $password;
		$data['status'] = 1;
		$this->ajaxReturn($data, 'json');
		
	}

	public function showSession() {
		echo "hi<br />";
		p($_SESSION);
	}

}



?>
