<?php 

namespace Controller;
use Core\Request;
use Core\Session;
use Model\User;

defined('ROOTPATH') OR exit('Access Denied!');

class Login
{
	use MainController;

	public function index()
	{
        
		$ses = new Session;
		if ($ses->is_logged_in()){
            redirect('home');
            die;
		}

        $data = [];

        $request = new Request;

        if (!$request->posted()){
            $this->view('login', $data);
            die;
        }

        $user = new User;
        $username = $request->post('username');
        $password = $request->post('password');

        if (!$user->validateLogin(['username'=>$username,'password'=>$password])){
            $data['errors'] = $user->errors;
            $this->view('login', $data);
            die;
        }
        
        if ($row = $user->first(['username'=>$username])) {
        
            if (password_verify($password, $row->password)) {

                $ses->auth($row);
                redirect('home');
            }

            $user->errors['username'] = "Неправильний пароль";
        }

        $data['errors'] = $user->errors;

        $this->view('login', $data);
	}
}
