<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * User class
 */
class Order
{
	
	use Model;

	protected $table = 'orders';

	protected $allowedColumns = [

		'customer_name',
		'customer_email',
		'product_id',
		'count',
        'created'
	];

    public function validate($data)
    {
        $this->errors = [];

        if (strlen($data['customer_name']) < 5)
		{
			$this->errors['name'] = "Ім'я замовника має бути довше за 4";
			return false;
		}

        if (strlen($data['customer_email']) < 5)
		{
			$this->errors['email'] = "Пошта замовника має бути довше за 4";
			return false;
		}

        if ($data['count'] < 1)
		{
			$this->errors['count'] = "Замовлення можливе на кількість продуктів від 1";
			return false;
		}

        $product = new \Model\Product;
		$productRow = $product->first(['id' => $data['product_id']]);
        $stock = $productRow->stock;

		if ($data['count'] > $stock)
		{
			$this->errors['count'] = "Стільки продуктів нема у наявності";
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
                customer_name varchar(64) not null,
                customer_email varchar(128) not null,
                product_id INT UNSIGNED not null,
                count INT UNSIGNED not null,
                created datetime null,
                FOREIGN KEY (product_id) REFERENCES products(id)
            )
        ";

		$this->query($query);
	}
}