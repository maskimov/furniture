<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * User class
 */
class Product
{
	
	use Model;

	protected $table = 'products';

	protected $allowedColumns = [

		'name',
		'description',
		'image',
		'price',
		'stock',
        'created'
	];

	public function validateEdit($data)
	{
        $this->errors = [];
		
		if ($data['price'] < 1)
		{
			$this->errors['price'] = "Ціна має бути додатньою";
			return false;
		}

		return true;
	}

	public function validateCreate($data)
	{
        $this->errors = [];

		if ($this->first(['name'=> $data['name']]))
		{
			$this->errors['name'] = "Назва продукту вже існує";
			return false;
		}
		
		if ($data['price'] < 1)
		{
			$this->errors['price'] = "Ціна має бути додатньою";
			return false;
		}

		return true;
	}

	public function createTable()
	{
		$query = "
			CREATE TABLE IF NOT EXISTS ". $this->table . "
			(
				id INT UNSIGNED primary key auto_increment,
				name varchar(64) not null unique,
				description varchar(256) not null,
				image varchar(1024) null,
                price INT UNSIGNED not null,
                stock INT UNSIGNED not null,
				created datetime null
			)
		";

		$this->query($query);
	}
}