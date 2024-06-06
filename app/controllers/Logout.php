<?php 

namespace Controller;
use Core\Session;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * home class
 */
class Logout
{
	use MainController;

	public function index()
	{
        $ses = new Session;

        if ($ses->is_logged_in()) {

            $ses->logout();
            redirect('login');
        }
		
        redirect('login');
	}
}
