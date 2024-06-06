<?php 

namespace Controller;
use Core\Session;

defined('ROOTPATH') OR exit('Access Denied!');

class Home
{
	use MainController;

	private $data = [];

	public function index()
	{
		$ses = new Session;
		
		if (!$ses->is_logged_in())
		{
			redirect('login');
			die;
		}

		$this->data = [
			'page' => 'Головна',
			'username' => $ses->user('username'),
			'isAdmin' => $ses->is_admin(), 
			'isManager' => $ses->is_manager(), 
			'department' => $ses->department()
		];
		
		$this->view('home', $this->data);
	}
}
