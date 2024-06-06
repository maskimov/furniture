<?php 

namespace Controller;
use Core\Request;
use Core\Session;
use Core\Mailer;
use Model\User;

defined('ROOTPATH') OR exit('Access Denied!');

class ResetPassword
{
	use MainController;

    // сторінка, яка запитує на ім'я користувача та надсилає електронний лист з посиланням на сторінку цього ж Контроллеру - link
    public function index()
    {
        $data = [];

        // Request - допоміжний клас, який надає змогу просто взаємодіяти зі змінними форм (post, get, files тощо) 
        $request = new Request;

        // Session - допоміжний клас, який надає змогу просто взаємодіяти зі змінними сесії
        $ses = new Session;

        // тут ми перевіряємо, чи користувач не авторизований. Якщо так - то йому не треба скидати пароль - натомість він може змінити його консервативно
        if ($ses->is_logged_in()){
            redirect('changepassword');
            die;
		}

        // тут ми перевіряємо, чи користувач відправив форму. Якщо ні - показуємо сторінку для задання ім'я користувача
        if (!$request->posted()){
            $this->view('reset-password', $data);
            die;
        }
        
        // User - клас, який є Моделлю. За допомогою нього ми можемо використовувати валідацію користувача та формувати запити до бази даних
        $user = new User;
        $username = $request->post('username');

        if (!$user->validateUsername($username))
        {
            $data['errors'] = $user->errors;
            $this->view('reset-password', $data);
            die;
        }
        
        // тут ми перевіряємо, чи існує такий користувач. Якщо так - тоді формуємо посилання для скидання пароля
        $row = $user->first(['username'=>$username]);
        $url = ROOT. '/resetpassword/link/?username=' . $username . '&password=' . $row->password;

        // Mailer - допоміжний клас, який дозволяє відправляти електронні листи
        $mailer = new Mailer;
        $mailer->sendMail($row->email, "Password Reset email", $url);

        // після всіх опарацій та перевірок ми знову відображаємо сторінку
        $this->view('reset-password', $data);
    }

    // безпосередньо сторінка, яка оброблює посилання та надає можливість скинути пароль користувача
	public function link()
	{
        $data = [];

        $request = new Request;

        $ses = new Session;
        if ($ses->is_logged_in()){
            redirect('home');
            die;
		}

        if (!$request->posted()){
            $this->view('reset-password-link', $data);
            die;
        }

        $user = new User;

        // тут ми отримуємо дані з посилання, яке користувач отримав електронним листом
        // також, отримуємо новий пароль з форми
        $username = $request->get('username');
        $hashedPassword = $request->get('password');
        $newPassword = $request->post('newPassword');

        if (!$user->validatePassword($newPassword))
        {
            $data['errors'] = $user->errors;
            $this->view('reset-password-link', $data);
            die;
        }

        // знаходимо користувача у базі даних
        $row = $user->first(['username'=>$username]);

        // видаємо помилку, якщо користувача не знайдено
        if (!$row){
            $user->errors['request'] = "Неправильний запит";
            $data['errors'] = $user->errors;
            $this->view('reset-password-link', $data);
            die;
        };

        $originalHashedPassword = $row->password;

        // перевіряємо пхешований ароль з посилання з тим, що є в базі даних. 
        // Якщо він збігається - оновлюємо пароль в базі даних та адресуємо користувача на сторінку авторизації
        if ($hashedPassword == $originalHashedPassword){
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $user->update($username,['password'=>$hashedNewPassword], 'username');
            redirect('login');
        }

        // Якщо ні - знову помилка
        $user->errors['request'] = "Неправильний запит";

        $data['errors'] = $user->errors;

        $this->view('reset-password-link', $data);
	}
}
