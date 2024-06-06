<?php 

namespace Controller;
use Core\Session;
use Core\Request;
use Model\User;
use Model\Image;

defined('ROOTPATH') OR exit('Access Denied!');

class Settings
{
	use MainController;

	private $data = [];

	public function index()
	{
		$this->profile();
	}

	public function security()
	{
		$ses = new Session;
		
		if (!$ses->is_logged_in())
		{
			redirect('login');
			die;
		}

		$this->data = ['isAdmin' => $ses->is_admin(), 'isManager' => $ses->is_manager(), 'page' => 'Налаштування профілю'];
		
		$this->view('security', $this->data);
	}

	public function profile()
	{
		$ses = new Session;
		
		if (!$ses->is_logged_in())
		{
			redirect('login');
			die;
		}

		$this->data = [
			'isAdmin' => $ses->is_admin(), 
			'isManager' => $ses->is_manager(), 
			'page' => 'Налаштування безпеки',
			'username' => $ses->user('username'),
			'email' => $ses->user('email'),
			'phone' => $ses->user('phone'),
			'privilege' => $ses->user('privilege')
		];

		$request = new Request;

		if (!$request->posted()){
            $this->view('profile', $this->data);
            die;
        }

		if ($request->input('submit') == 'edit'){
			$newData = [
				'email' => trim($request->post('email')),
				'phone' => trim($request->post('phone'))
			];

			$user = new User;
			if (!$user->validateEdit($newData, $ses->user('id')))
			{
				$this->data['errors'] = $user->errors;
				$this->view('profile', $this->data);
				die;
			}

			$user->update($ses->user('id'), $newData);

			$ses->auth($user->first(['id'=>$ses->user('id')]));
		}
		if ($request->input('submit') == 'photo'){			
			$image = new Image;
			$photo = $image->saveImage("assets/images/users/", $request->files("photo"));

			if (isset($_SESSION['USER']->image))
			{
				$image->deleteImage($_SESSION['USER']->image);
			}
			
			$user = new User;
			$user->update(user("id"), ['image' => $photo]);
			$ses->auth($user->first(['id'=>$ses->user('id')]));
		}

		redirect('settings/profile');
	}
}
