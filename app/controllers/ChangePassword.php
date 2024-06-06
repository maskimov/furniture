<?php 

namespace Controller;
use Core\Request;
use Core\Session;
use Model\User;

defined('ROOTPATH') OR exit('Access Denied!');

class ChangePassword
{
	use MainController;

	public function index()
	{
        
		$ses = new Session;
		if (!$ses->is_logged_in()){
            redirect('login');
            die;
		}

        $data = ['isAdmin' => $ses->is_admin(), 'isManager' => $ses->is_manager(), 'page' => 'Зміна паролю'];

        $request = new Request;

        if (!$request->posted()){
            $this->view('change-password', $data);
            die;
        }
        
        $user = new User;
        $username = $ses->user('username');
        $oldPassword = $request->post('oldPassword');
        $newPassword = $request->post('newPassword');

        $row = $user->first(['username'=>$username]);

        if (password_verify($oldPassword, $row->password)) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $user->update($username,['password'=>$hashedNewPassword], 'username');
            $ses->logout();
            redirect('login');
        }

        $user->errors['oldPassword'] = "Неправильний старий пароль";

        $data['errors'] = $user->errors;

        $this->view('change-password', $data);
	}
}
