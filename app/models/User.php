<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * User class
 */
class User
{
	
	use Model;

	protected $table = 'users';

	protected $allowedColumns = [

		'username',
		'image',
		'email',
		'phone',
		'password',
		'created',
		'privilege',
		'department'
	];

	public function validateUsername($username)
	{
		$this->errors = [];
		
		if(empty($username))
		{
			$this->errors['username'] = "Потрібно вказати ім'я користувача";
			return false;
		}

		if(!$this->first(['username'=>$username]))
		{
			$this->errors['username'] = "Ім'я користувача не знайдено";
			return false;
		}	

		return true;
	}

	public function validatePassword($password)
	{
		$this->errors = [];
		
		if(empty($password))
		{
			$this->errors['password'] = "Потрібно вказати пароль";
			return false;
		}	

		if(strlen($password) < 4)
		{
			$this->errors['password'] = "Пароль повинен бути довше 3 символів";
			return false;
		}	

		return true;
	}

	// TODO: transfer the getManager function from Manager to User

	public function validateLogin($data)
	{
		$this->errors = [];
		
		if (!$this->validateUsername($data['username']))
			return false;

		if (!$this->validatePassword($data['password']))
			return false;

		return true;
	}

	public function validateEdit($newData, $oldID)
	{
		$this->errors = [];

		if($this->first(['email'=>$newData['email']],['id'=>$oldID]))
		{
			$this->errors['email'] = "Така пошта вже існує";
			return false;
		}

		if(!filter_var($newData['email'], FILTER_VALIDATE_EMAIL))
		{
			$this->errors['$email'] = "Неправильний формат пошти";
			return false;
		}

		if($this->first(['phone'=>$newData['phone']],['id'=>$oldID]))
		{
			$this->errors['phone'] = "Такий телефон вже існує";
			return false;
		}

		return true;
	}

	public function validatePhone($phone)
	{
		$this->errors = [];
		
		if(empty($phone))
		{
			$this->errors['phone'] = "Потрібно вказати номер телефону";
			return false;
		}

		if($this->first(['phone'=>$phone]))
		{
			$this->errors['$phone'] = "Номер телефону вже існує";
			return false;
		}	

		return true;
	}

	public function validateEmail($email)
	{
		$this->errors = [];
		
		if(empty($email))
		{
			$this->errors['email'] = "Потрібно вказати електронну пошту";
			return false;
		}

		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$this->errors['$email'] = "Неправильний формат пошти";
			return false;
		}	

		if($this->first(['email'=>$email]))
		{
			$this->errors['$email'] = "Така пошта вже існує";
			return false;
		}	

		return true;
	}

	public function validateSignin($data)
	{
		$this->errors = [];
		
		if(empty($data['username']))
		{
			$this->errors['username'] = "Потрібно вказати ім'я користувача";
			return false;
		}

		if($this->first(['username'=>$data['username']]))
		{
			$this->errors['username'] = "Ім'я користувача існує";
			return false;
		}	

		if (!$this->validateEmail($data['email']))
			return false;

		if (!$this->validatePhone($data['phone']))
			return false;

		return true;
	}

	public function createTable()
	{
		$query = "
			CREATE TABLE IF NOT EXISTS ". $this->table . " 
			(
				id INT UNSIGNED primary key auto_increment,
				username varchar(32) not null unique,
				image varchar(1024) null,
				email varchar(128) not null unique,
				phone varchar(16) not null unique,
				password varchar(255) not null,
				created datetime null,
				privilege ENUM('admin','manager','worker') not null default 'worker',
				department ENUM('none', industrial','design','sales') not null default 'none'
			)
		";

		$this->query($query);
	}

	public function getManagers($department, $except = [])
	{
		return $this->where(['department' => $department, 'privilege' => 'manager'], $except);
	}

	public function getWorkers($department, $except = [])
	{
		return $this->where(['department' => $department, 'privilege' => 'worker'], $except);
	}
}