<?php 

namespace Controller;
use Core\Session;
use Core\Request;
use Model\User;
use Core\Mailer;

defined('ROOTPATH') OR exit('Access Denied!');

class Managers
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

        if (!$ses->is_admin())
        {
            redirect('home');
			die;
        }

		$user = new User;
		$this->data = ['isAdmin' => $ses->is_admin(), 'isManager' => $ses->is_manager(), 'page' => 'Менеджери'];
		$this->data['managers'] = [];
		$this->data['managers']['industrial'] = $user->getManagers('industrial');
		$this->data['managers']['design'] = $user->getManagers('design');
		$this->data['managers']['sales'] = $user->getManagers('sales');

        $request = new Request;

		if (!$request->posted()){
            $this->view('managers', $this->data);
            die;
        }

		if ($request->input('submit') == 'edit'){
			
			$newData = [
				'email' => trim($request->post('email')),
				'phone' => trim($request->post('phone'))
			];

			$user = new User;
			if (!$user->validateEdit($newData, $request->post('id')))
			{
				$this->data['errors'] = $user->errors;
				$this->view('managers', $this->data);
				die;
			}
			$user->update($request->post('id'), $newData);
		}

		if ($request->input('submit') == 'create'){
			
			$newData = [
				'username' => trim($request->post('username')),
				'email' => trim($request->post('email')),
				'phone' => trim($request->post('phone')),
				'password' => password_hash(rand(0, 10000000), PASSWORD_DEFAULT),
				'created' => date('Y-m-d H:i:s'),
				'privilege' => 'manager',
				'department' => trim($request->post('department'))
			];

			if (!$user->validateSignin($newData))
			{
				$this->data['errors'] = $user->errors;
				$this->view('managers', $this->data);
				die;
			}

			$url = ROOT. '/resetpassword/link/?username=' . $newData['username'] . '&password=' . $newData['password'];
			$mailer = new Mailer;
        	$mailer->sendMail($newData['email'], "Password Reset email", $url);

			$user->insert($newData);
		}

		redirect('managers');
	}
}
