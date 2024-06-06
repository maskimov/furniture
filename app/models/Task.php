<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * User class
 */
class Task
{
	
	use Model;

	protected $table = 'tasks';

	public function __construct($order_type, $order_column)
	{
		$this->order_type = $order_type;
		$this->order_column = $order_column;
	}

	protected $allowedColumns = [

		'creator_id',
		'performer_id',
		'description',
		'product_id',
		'amount',
		'performed',
		'approved',
        'created'
	];

	public function validate($data)
	{
		$this->errors = [];

		if ($data['performed'] == 0)
		{
			$this->errors['performed'] = "Завдання ще не виконане";
			return false;
		}

		if ($data['approved'] == 1)
		{
			$this->errors['approved'] = "Виконання вже підтверджене";
			return false;
		}

		return true;
	}

	public function validateCreate($data)
	{
		$this->errors = [];

		$product = new Product;
		$user = new User;

		if (!$product->first(['id'=>$data['product_id']]))
		{
			$this->errors['product'] = "Продукт не знайдений";
			return false;
		}

		if (!$user->first(['id'=>$data['performer_id']]))
		{
			$this->errors['performer'] = "Виконавець не знайдений";
			return false;
		}

		if ($data['amount'] < 1)
		{
			$this->errors['amount'] = "Завдання має бути на 1 і більше одиниць продукту";
			return false;
		}

		return true;
	}

	public function createTableIndustial()
	{
		$query = "
			CREATE TABLE IF NOT EXISTS ". $this->table . "
			(
				id INT UNSIGNED primary key auto_increment,
				creator_id INT UNSIGNED not null,
				performer_id INT UNSIGNED not null,
				description varchar(256) not null,
				product_id INT UNSIGNED not null,
                amount INT UNSIGNED not null,
				performed BOOLEAL not null default false,
				approved BOOLEAL not null default false,
				created datetime null,
                FOREIGN KEY (creator_id) REFERENCES users(id),
                FOREIGN KEY (performer_id) REFERENCES users(id),
                FOREIGN KEY (product_id) REFERENCES products(id)
			)
		";

		$this->query($query);
	}
}